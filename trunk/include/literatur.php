<?php
	require_once("include/login.php");
	require_once("include/kommentar.php");
	require_once("include/literaturart.php");
	require_once("include/autor.php");

	/*! \brief Verwaltet Literatur
	 *
	 *  Stellt Funktionen zum Abruf, Exportieren, Löschen, Importieren,
	 *  Hinzufügen und Ändern von Literatur in Bibliothek zur Verfügung.
	 *  \pre Datenbankverbindung muss bestehen
	 *  \sa
	 *  - Autor::Clean
	 *  - Autor::GetAll
	 *  - Autor::Split
	 *  - Kommentar::DeleteAll
	 *  - Kommentar::GetAll
	 *  - LiteraturArt::LiteraturArt
	 *  - LiteraturArt::GetBibTexText
	 *  - Login::IsAdministrator
	 *  - Login::IsMember
	 *  - SQLDB::Query
	 *  - SQLDB::Fetch
	 *
	 *  \author Sven Eckelmann
	 *  \date 30.05.2006
	 */
	class Literatur
	{
		var $Nr = 0; ///< Buchidentifikationsnummer
		var $Titel = ""; ///< Titel der Literatur
		var $Jahr = 0; ///< Erscheinungsjahr
		var $Verlag = ""; ///< Verlag/Herausgeber
		var $ISBN = ""; ///< ISBN der Literatur
		var $Beschreibung = ""; ///< Bemerkung zur Literatur
		var $Ort = ""; ///< Herausgabeort
		var $Stichworte = ""; ///< Stichworte zum Inhalt der Literatur
		var $Art; ///< Typ der Literatur
		var $Autoren = array(); ///< Feld mit Autoren der Literatur
		var $Kommentare = array(); ///< Feld mit Kommentaren der Literatur
		
		/*! \brief Liest Literatur ein
		 *
		 *  Erstellt aus Literatur in Bibliothek mit Literatur_Nr
		 *  ($nr) neues Literaturobjekt.
		 *  \pre Datenbankverbindung muss bestehen
		 *  \param[in] $nr Nummer der zu einlesenden Literatur
		 */
		function Literatur($nr)
		{
			global $db_config, $sqldb;
			$sql = "SELECT Literatur_Nr, Art, Titel, Jahr, Verlag, ISBN, Beschreibung, Ort, Stichworte
					FROM ".$db_config['prefix']."Bibliothek
					WHERE Literatur_Nr='$nr'
					LIMIT 1";
			$sqldb->Query($sql);
			if ($cur = $sqldb->Fetch())
			{
				$this->Nr = $cur->Literatur_Nr;
				$this->Art = new LiteraturArt($cur->Art);
				$this->Titel = $cur->Titel;
				$this->Jahr = $cur->Jahr;
				$this->Verlag = $cur->Verlag;
				$this->ISBN = $cur->ISBN;
				$this->Beschreibung = $cur->Beschreibung;
				$this->Ort = $cur->Ort;
				$this->Stichworte = $cur->Stichworte;
				$this->Autoren = Autor::GetAll($nr);
				$this->Kommentare = Kommentar::GetAll($nr);
			}
		}

		/*! \brief Exportiert Literatur nach BibTeX
		 *
		 *  Exportiert die aktuellen Informationen im Literaturobjekt
		 *  in das BibTeX-Format.
		 *  \pre -
		 *  \return $string mit BibTeX-Eintrag
		 */
		function ToBibtex()
		{
			$str = "@".$this->Art->GetBibtexText()."{".$this->Art->GetBibtexText().$this->Nr;
				
			if (!empty($this->Titel))
			{
				$str .= ",\n\ttitle = \"".addslashes($this->Titel)."\"";
			}

			if (count($this->Autoren) > 0)
			{
				$autorlist = "";
				for ($j = 0; $j < count($this->Autoren); $j++)
				{
					if ($j != 0)
					{
						$autorlist .= " and ";
					}
					$autorlist .= $this->Autoren[$j]->Name;
				}

				$str .= ",\n\tauthor = \"".addslashes($autorlist)."\"";
			}

			if (!empty($this->Jahr))
			{
				$str .= ",\n\tyear = \"".addslashes($this->Jahr)."\"";
			}

			if (!empty($this->Verlag))
			{
				$str .= ",\n\tpublisher = \"".addslashes($this->Verlag)."\"";
			}

			if (!empty($this->ISBN))
			{
				$str .= ",\n\tisbn = \"".addslashes($this->ISBN)."\"";
			}

			if (!empty($this->Ort))
			{
				$str .= ",\n\taddress = \"".addslashes($this->Ort)."\"";
			}
			
			$str .= "\n}\n";
			return $str;
		}

		/*! \brief Löscht Literatur
		 *
		 *  Löscht Literatur aus Bibliothek mit der Literatur_Nr $nr.
		 *  Alle verbundenen Kommentare werden aus Kommentare gelöscht.
		 *  Außerdem werden alle nun nicht mehr gebrauchten Autoren in
		 *  Autoren gelöscht.
		 *  \pre Datenbankverbindung muss bestehen
		 *  \param[in] $nr Nummer der zu löschenden Literatur
		 *  \remarks Ist der Nutzer nicht als Mitglied angemeldet,
		 *    werden keine Operationen ausgeführt
		 */
		function Delete($nr)
		{
			global $db_config, $sqldb, $login;

			if ($login->IsMember() === true)
			{
				$sql = "DELETE FROM ".$db_config['prefix']."Bibliothek
						WHERE Literatur_Nr = '$nr'
						LIMIT 1";
				$sqldb->Query($sql);

				$sql = "DELETE FROM ".$db_config['prefix']."Literatur_Autor
						WHERE Literatur_Nr = '$nr'";
				$sqldb->Query($sql);

				Autor::Clean();

				Kommentar::DeleteAll($nr);
			}
		}

		/*! \brief Importiert BibTeX
		 *
		 *  Importiert Literatur nach Bibliothek aus einem
		 *  BibTeX-formatierten String. Alle Einträge werden dazu
		 *  nacheinandere eingelesen und umgewandelt, um diese dann
		 *  in die Datenbank zu schreiben.
		 *  \pre Datenbankverbindung muss bestehen
		 *  \param[in] $bibtex String mit Inhalt einer BibTeX-Datei
		 */
		function InsertBibTeX($bibtex)
		{
			/// \todo implementieren
		}

		/*! \brief Legt Literatur an
		 *
		 *  Legt neue Literatur in Bibliothek mit den übergebenen
		 *  Parametern ($art, $titel, $jahr, $verlag, $isbn,
		 *  $beschreibung, $ort, $stichworte) an. Danach werden die
		 *  Autoren ($autoren) in Autoren geschrieben und mit der
		 *  Tabelle Literatur_Autor der Literatur zugeordnet.
		 *  \pre Datenbankverbindung muss bestehen
		 *  \param[in] $autoren String mit kommagetrennter Liste von Autoren
		 *  \param[in] $art Bezeichner der Literaturart
		 *  \param[in] $titel Titel der Literatur
		 *  \param[in] $jahr Erscheinungsjahr der Literatur
		 *  \param[in] $verlag Verlag der Literatur
		 *  \param[in] $isbn ISBN der Literatur
		 *  \param[in] $beschreibung Beschreibung der Literatur
		 *  \param[in] $ort Erscheinungsort
		 *  \param[in] $stichworte Stichworte
		 *  \remarks Ist der Nutzer nicht als Mitglied angemeldet,
		 *    werden keine Operationen ausgeführt
		 */
		function Insert($autoren, $art, $titel, $jahr, $verlag, $isbn, $beschreibung, $ort, $stichworte)
		{
			global $db_config, $sqldb, $login;

			if ($login->IsAdministrator() === true)
			{
				$sql = "INSERT INTO ".$db_config['prefix']."Bibliothek
						VALUES (NULL, '$art', '$titel', '$jahr', '$verlag', '$isbn', '$beschreibung', '$ort', '$stichworte')";
				$sqldb->Query($sql);

				$sqlIdentity = "SELECT @@IDENTITY AS Nr FROM ".$db_config['prefix']."Bibliothek";
				$sqldb->Query($sqlIdentity);

				if ($identity = $sqldb->Fetch())
				{
					$nr = $identity->Nr;
					$autorlist = Autor::Split($autoren);
					for ($i = 0; $i < count($autorlist); $i++)
					{
						$sql = "INSERT INTO ".$db_config['prefix']."Literatur_Autor
							VALUES ('".$autorlist[$i]."', '$nr')";
						$sqldb->Query($sql);
					}
				}
			}
		}

		/*! \brief Ändert Literatur
		 *
		 *  Entfernt alle zur Literatur_Nr ($nr) gehörenden
		 *  Verbindungen in Autor_Literatur um danach die Literatur mit
		 *  Literatur_Nr $nr zu den neuen Werten ($art, $titel, $jahr,
		 *  $verlag, $isbn, $beschreibung, $ort, $stichworte) zu ändern.
		 *  Danach werden die Autoren ($autoren) in Autoren geschrieben
		 *  und mit der Tabelle Literatur_Autor der Literatur
		 *  zugeordnet. Alle jetzt noch nicht zugeordneten Autoren in
		 *  Autoren werden gelöscht.
		 *  \pre Datenbankverbindung muss bestehen
		 *  \param[in] $nr Nummer der zu verändernden Literatur
		 *  \param[in] $autoren String mit kommagetrennter Liste von Autoren
		 *  \param[in] $art neuer Bezeichner der Literaturart
		 *  \param[in] $titel neuer Titel der Literatur
		 *  \param[in] $jahr neues Erscheinungsjahr der Literatur
		 *  \param[in] $verlag neuer Verlag der Literatur
		 *  \param[in] $isbn neue ISBN der Literatur
		 *  \param[in] $beschreibung neue Beschreibung der Literatur
		 *  \param[in] $ort neuer Erscheinungsort
		 *  \param[in] $stichworte neue Stichworte
		 *  \remarks Ist der Nutzer nicht als Mitglied angemeldet,
		 *    werden keine Operationen ausgeführt
		 */
		function Update($nr, $autoren, $art, $titel, $jahr, $verlag, $isbn, $beschreibung, $ort, $stichworte)
		{
			global $db_config, $sqldb, $login;

			if ($login->IsAdministrator() === true)
			{
				$sql = "DELETE FROM ".$db_config['prefix']."Literatur_Autor
						WHERE Literatur_Nr='$nr'";
				$sqldb->Query($sql);

				$sql = "UPDATE ".$db_config['prefix']."Bibliothek
							SET Art='$art', Titel='$titel', Jahr='$jahr', Verlag='$verlag', ISBN='$isbn', Beschreibung='$beschreibung', Ort='$ort', Stichworte='$stichworte'
							WHERE Literatur_Nr='$nr'
							LIMIT 1";
				$sqldb->Query($sql);

				$autorlist = Autor::Split($autoren);
				for ($i = 0; $i < count($autorlist); $i++)
				{
					$sql = "INSERT INTO ".$db_config['prefix']."Literatur_Autor
						VALUES ('".$autorlist[$i]."', '$nr')";
					$sqldb->Query($sql);
				}

				Autor::Clean();
			}
		}
	}
?>
