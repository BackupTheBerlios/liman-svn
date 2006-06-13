<?php
	/*! \brief Verwaltet Autoren
	 *
	 *  Stellt Funktionen zum Hinzufügen von Autoren und Bereinigen nicht
	 *  mehr benutzter Autoren bereit.
	 *  \pre Datenbankverbindung muss bestehen
	 *  \sa
	 *  - Login::IsMember
	 *  - SQLDB::Query
	 *  - SQLDB::Fetch
	 *  - SQLDB::GetInsertID
	 *
	 *  \author Frank Wilhelm
	 *  \date 6.06.2006
	 */
	class Autor
	{
		var $Nr = 0; ///< Identifikationsnummer des Autors
		var $Name = 0; ///< Name des Autors
		
		/*! \brief Legt Autorenobjekt an
		 *
		 *  Legt ein neues Autorenobjekt aus einem Objekt mit den
		 *  Attributen Nr und Name an.
		 *  \pre -
		 *  \param[in] $data Objekt mit Autorendaten der Form
		 *    - Nr
		 *    - Name
		 */
		function Autor($data)
		{
			$this->Nr = $data->Nr;
			$this->Name = $data->Name;
		}

		/*! \brief Entfernt unnötige Autoren
		 *
		 *  Entfernt aus Autoren alle Autoren, die keine Verbindung
		 *  (Literatur_Autor-Tabelle) mehr mit Literatur haben.
		 *  \pre Datenbankverbindung muss bestehen
		 *  \remarks Ist der Nutzer nicht eingeloggt, werden keine
		 *    Operationen ausgeführt.
		 */
		function Clean()
		{
			global $db_config, $sqldb, $login;

			// Nur wenn wir als Mitglied angemeldet sind
			if ($login->IsMember() === true)
			{
				// Entferne Autoren ohne Verbindung in Literatur_Autor zur Literatur
				$sql = "DELETE autoren, connect
						FROM ".$db_config['prefix']."Autoren AS autoren
						LEFT JOIN ".$db_config['prefix']."Literatur_Autor AS connect
						ON autoren.Autor_Nr = connect.Autor_Nr
						WHERE connect.Autor_Nr is NULL";

				if ($sqldb->Query($sql) === false)
				{
					// Workaround für MySQL < 4
					// Finde Autoren ohne Verbindung in Literatur_Autor zur Literatur
					$sql = "SELECT autoren.Autor_Nr AS Nr
							FROM ".$db_config['prefix']."Autoren AS autoren
							LEFT JOIN ".$db_config['prefix']."Literatur_Autor AS connect
							ON autoren.Autor_Nr = connect.Autor_Nr
							WHERE connect.Autor_Nr is NULL";
					$sqldb->Query($sql);

					// Lese alle Autorennummern aus
					$authorid = array();
					while ($line = $sqldb->Fetch())
					{
						$authorid[] = $line->Nr;
					}

					// Wenn Autoren gefunden worden
					if (empty($authorid) === false)
					{
						// Erstelle Kommagetrennte Liste der Autorennummern
						$idlist = implode(", ", $authorid);

						// Lösche gefundene Autoren
						$sqlDelete = "DELETE FROM ".$db_config['prefix']."Autoren
								WHERE Autor_Nr IN (";
								$sqlDelete .= $idlist.")";
						$sqldb->Query($sqlDelete);
					}
				}
			}
		}

		/*! \brief Gibt Autoren zu bestimmter Literatur zurück
		 *
		 *  Liest alle Autoren die einer Literatur ($literatur_nr)
		 *  zugeordnet sind aus Kommentare aus und gibt sie als Feld des
		 *  Typs Autor zurück.
		 *  \param[in] $literatur_nr Nr einer Literatur mit Autoren
		 *  \pre Datenbankverbindung muss bestehen
		 *  \return Feld mit Elementen vom Typ Autor
		 */
		function GetAll($literatur_nr)
		{
			global $db_config, $sqldb;

			// Lese alle Autoren mit Verbindung zu Literatur in Literatur_Autor
			$sql = "SELECT  autoren.Autor_Nr AS Nr, Autorname AS Name
					FROM ".$db_config['prefix']."Literatur_Autor AS connect
					INNER JOIN  ".$db_config['prefix']."Autoren AS autoren
					ON connect.Autor_Nr = autoren.Autor_Nr
					WHERE Literatur_Nr = '$literatur_nr'";
			$sqldb->Query($sql);

			// Lese Autoren aus und erstelle Array aus gefundenen Autoren
			$authors = array();
			while ($cur = $sqldb->Fetch())
			{
				$authors[] = new Autor($cur);
			}
			return $authors;
		}

		/*! \brief Legt neue Autoren aus kommagetrennter Liste an
		 *
		 *  Teilt die kommagetrennte Liste von Autoren in einzelne
		 *  Autorennamen ein und überprüft gegen Autorentabelle, ob
		 *  diese schon in der Datenbank existieren. Sollten diese
		 *  schon existieren, dann wird Autor_Nr ausgelesen und zum
		 *  Feld hinzugefügt. Sollten diese noch nicht existieren,
		 *  werden sie hinzugefügt und die neuen Autor_Nr zum Feld
		 *  hinzugefügt. Das komplette Feld mit Autor_Nr wird
		 *  zurückgegeben.
		 *  \pre Datenbankverbindung muss bestehen
		 *  \param[in] $autoren String mit kommagetrennter Liste von Autoren
		 *  \return Feld mit Autor_Nr der Autoren
		 *  \remarks Ist der Nutzer nicht eingeloggt, werden keine
		 *    Operationen ausgeführt.
		 */
		function Split($autoren)
		{
			global $db_config, $sqldb, $login;
			$authorNumbers = array();

			// Nur wenn wir als Mitglied angemeldet sind
			if ($login->IsMember() === true)
			{
				// Trenne kommagetrennte Liste der Autoren an Kommas auf
				$authorNames = array();
				$authorNames = split(",", $autoren);

				// Suche ob jeder Autorname in kommagetrennter Liste in Autoren steht
				foreach ($authorNames as $autor)
				{
					// Suche nach Autoreintrag
					$sqlSelect = "SELECT Autor_Nr AS Nr FROM ".$db_config['prefix']."Autoren AS autoren
							WHERE Autorname = '".trim($autor)."'";
					$sqldb->Query( $sqlSelect );
					
					// Existiert der Eintrag?
					if ($cur = $sqldb->Fetch())
					{
						// Wenn ja, speichere Autornummer für Rückgabe
						$authorNumbers[] = $cur->Nr;
					}
					else
					{
						// Wenn nicht, dann füge Autorname in Datenbank ein
						$sqlInsert = "INSERT INTO ".$db_config['prefix']."Autoren VALUES (NULL, '".trim($autor)."')";
						$sqldb->Query($sqlInsert);

						// Speichere neue Autornummer für Rückgabe
						$authorNumbers[] = $sqldb->GetInsertID();
					}
				}
			}
			
			return $authorNumbers;
		}
	}
?>
