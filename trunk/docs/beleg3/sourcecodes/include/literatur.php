<?php
	require_once("include/login.php");
	require_once("include/kommentar.php");
	require_once("include/literaturart.php");
	require_once("include/autor.php");

	/*! \brief Verwaltet Literatur
	 *
	 *  Stellt Funktionen zum Abruf, Exportieren, L�schen, Importieren,
	 *  Hinzuf�gen und �ndern von Literatur in Bibliothek zur Verf�gung.
	 *  \pre Datenbankverbindung muss bestehen
	 *  \sa
	 *  - Autor::Clean
	 *  - Autor::GetAll
	 *  - Autor::Split
	 *  - Kommentar::DeleteAll
	 *  - Kommentar::GetAll
	 *  - LiteraturArt::LiteraturArt
	 *  - LiteraturArt::GetBibTexText
	 *  - Login::IsMember
	 *  - SQLDB::Query
	 *  - SQLDB::Fetch
	 *  - SQLDB::GetInsertID
	 *
	 *  \author Sven Eckelmann
	 *  \date 06.06.2006
	 */
	class Literatur
	{
		var $Nr = 0; ///< Literaturidentifikationsnummer
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
		 *  \pre Literatur in Bibliothek mit Literatur_Nr $nr muss
		 *    existieren
		 *  \param[in] $nr Nummer der zu einlesenden Literatur
		 */
		function Literatur($nr)
		{
			global $db_config, $sqldb;

			// Suche Literatur mit Literatur_Nr = $nr heraus
			$sql = "SELECT Literatur_Nr, Art, Titel, Jahr, Verlag, ISBN, Beschreibung, Ort, Stichworte
					FROM ".$db_config['prefix']."Bibliothek
					WHERE Literatur_Nr='$nr'
					LIMIT 1";
			$sqldb->Query($sql);

			// Lese gefundene Daten aus
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
			$str = "";

			// Wurde ein LiteraturArt-Objekt angelegt?
			if (is_object($this->Art) === true)
			{
				// Lege Kopf des BibTeX-Eintrags an
				$str = "@".$this->Art->GetBibtexText()."{". $this->Art->GetBibtexText().$this->Nr;
				
				// Titel hinzuf�gen, wenn vorhanden
				if (empty($this->Titel) === false)
				{
					$str .= ",\n\ttitle = \"".addslashes($this->Titel)."\"";
				}
	
				// Autoren hinzuf�gen, wenn vorhanden
				if (empty($this->Autoren) === false)
				{
					// Erstelle and-getrennte Liste der Autorennamen
					$autornamen = array();
					foreach ($this->Autoren as $autor)
					{
						$autornamen[] = $autor->Name;
					}

					$autorlist = implode(" and ", $autornamen);
					$str .= ",\n\tauthor = \"".addslashes($autorlist)."\"";
				}
	
				// Jahr hinzuf�gen, wenn vorhanden
				if (empty($this->Jahr) === false)
				{
					$str .= ",\n\tyear = \"".addslashes($this->Jahr)."\"";
				}
	
				// Verlag hinzuf�gen, wenn vorhanden
				if (empty($this->Verlag) === false)
				{
					$str .= ",\n\tpublisher = \"".addslashes($this->Verlag)."\"";
				}
	
				// ISBN hinzuf�gen, wenn vorhanden
				if (empty($this->ISBN) === false)
				{
					$str .= ",\n\tisbn = \"".addslashes($this->ISBN)."\"";
				}
	
				// Ort hinzuf�gen, wenn vorhanden
				if (empty($this->Ort) === false)
				{
					$str .= ",\n\taddress = \"".addslashes($this->Ort)."\"";
				}
				
				// Beende BibTeX-Eintrag
				$str .= "\n}\n";
			}
			return $str;
		}

		/*! \brief L�scht Literatur
		 *
		 *  L�scht Literatur aus Bibliothek mit der Literatur_Nr $nr.
		 *  Alle verbundenen Kommentare werden aus Kommentare gel�scht.
		 *  Au�erdem werden alle nun nicht mehr gebrauchten Autoren in
		 *  Autoren gel�scht.
		 *  \pre Datenbankverbindung muss bestehen
		 *  \pre Literatur in Bibliothek mit Literatur_Nr $nr muss
		 *    existieren
		 *  \param[in] $nr Nummer der zu l�schenden Literatur
		 *  \remarks Ist der Nutzer nicht als Mitglied angemeldet,
		 *    werden keine Operationen ausgef�hrt
		 */
		function Delete($nr)
		{
			global $db_config, $sqldb, $login;

			// Nur wenn wir als Mitglied angemeldet sind
			if ($login->IsMember() === true)
			{
				// L�sche Literatur aus Bibliothek
				$sql = "DELETE FROM ".$db_config['prefix']."Bibliothek
						WHERE Literatur_Nr = '$nr'
						LIMIT 1";
				$sqldb->Query($sql);

				// Entferne alle Verbindugnen zwischen Literatur und Autoren
				$sql = "DELETE FROM ".$db_config['prefix']."Literatur_Autor
						WHERE Literatur_Nr = '$nr'";
				$sqldb->Query($sql);

				// L�sche nun alle freigewordenen Autoren
				Autor::Clean();

				// L�sche alle zur Literatur geh�rdenden Kommentare
				Kommentar::DeleteAll($nr);
			}
		}

		/*! \brief Importiert BibTeX
		 *
		 *  Importiert Literatur nach Bibliothek aus einem
		 *  BibTeX-formatierten String. Alle Eintr�ge werden dazu
		 *  nacheinandere eingelesen und umgewandelt, um diese dann
		 *  in die Datenbank zu schreiben.
		 *  \pre Datenbankverbindung muss bestehen
		 *  \param[in] $bibtex String mit Inhalt einer BibTeX-Datei
		 *  \return Anzahl der importierten Literatur
		 */
		function InsertBibTeX($bibtex)
		{
			$allowed_entries = array('book', 'article', 'booklet',
					'conference', 'inbook', 'incollection', 'inproceedings', 'manual',
					'mastersthesis', 'misc', 'phdthesis', 'proceedings', 'techreport',
					'unpublished');

			// Finde alle BibTeX-Eintr�ge
			// Funktioniert nicht bei Argumenten �ber mehrere Zeilen
			if (preg_match_all('/@([\w]+[\s]*)\{[\s]*([-\d\w]+)(([\s]*,[\s]*'. '[\w]*[\s]*=[\s]*([\w]+|\{.*\}|".*")[\s]*)+)\}/', $bibtex, $regexp_entries) !== false)
			{
				$num_entries = sizeof($regexp_entries[0]);
			}
			else
			{
				$num_entries = 0;
			}

			$entries = false;
			
			// Extrahiere alle Eintr�ge
			for ($i = 0; $i < $num_entries; $i++)
			{
				$cur = new stdClass;
				$cur->autoren = "";
				$cur->art = new LiteraturArt("book");
				$cur->titel = "";
				$cur->jahr = date("Y");
				$cur->verlag = "";
				$cur->isbn = "";
				$cur->beschreibung = "";
				$cur->ort = "";

				// Lese Typ vom Eintrag
				$type = trim($regexp_entries[1][$i]);
				
				// Haben wir �berhaupt den Anfang eines Eintrags gefunden?
				if (in_array($type, $allowed_entries) === false)
				{
					continue;
				}
				else
				{
					$cur->art = new LiteraturArt($type);
				}
				

				// Lese K�rzel
				$cur->id = trim($regexp_entries[2][$i]);

				// Extrahiere "Optionen"
				if (preg_match_all('/(([\w]*)[\s]*=[\s]*([\w]+|\{.*\}|'. '".*")[\s]*(,|\}))+/', $regexp_entries[3][$i], $regexp_options) !== false)
				{
					// Lese die Optionen des aktuellen BibTeX-Eintrags einzeln
					$num_options = sizeof($regexp_options[0]);
					for ($j = 0; $j < $num_options; $j++)
					{
						// Name des Arguments der "Option" auslesen und bereinigen
						$argument = trim($regexp_options[3][$j]);

						if ($argument[0] == "{" && $argument[strlen($argument)-1] == "}")
						{
							$argument = substr($argument, 1, strlen($argument)-2);
						}
						if ($argument[0] == "\"" && $argument[strlen($argument)-1] == "\"")
						{
							$argument = substr($argument, 1, strlen($argument)-2);
						}

						// Wei�e Daten der aktuellen Option zu
						switch (strtolower( trim($regexp_options[2][$j])))
						{
						case "title":
							$cur->titel = $argument;
							break;
						case "author":
							$cur->autoren = preg_replace("/ AND /i", ", ", $argument);
							break;
						case "year":
							$cur->jahr = $argument;
							break;
						case "publisher":
							$cur->verlag = $argument;
							break;
						case "isbn":
							$cur->isbn = $argument;
							break;
						case "address":
							$cur->ort = $argument;
							break;
						case "note":
						case "annote":
							$cur->beschreibung = $argument;
							break;
						}
					}
				}
				else
				{
					continue;
				}
				
				// Erzeuge array, wenn noch nicht geschehen
				if ($entries === false)
				{
					$entries = array();
				}
				$entries[] = $cur;
			}


			$imported = 0;
			if ($entries !== false && empty($entries) === false)
			{
				// Importiere die einzelnen Eintr�ge in Bibliothek
				// wenn Titel und Autor vorhanden sind
				foreach ($entries as $entry)
				{
					if (empty($entry->titel) === false && empty($entry->autoren) === false)
					{
						$imported++;
						Literatur::Insert($entry->autoren, $entry->art->GetDisplayText(),
							$entry->titel, $entry->jahr, $entry->verlag, $entry->isbn,
							$entry->beschreibung, $entry->ort, "");
					}
				}
			}

			return $imported;
		}

		/*! \brief Legt Literatur an
		 *
		 *  Legt neue Literatur in Bibliothek mit den �bergebenen
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
		 *    werden keine Operationen ausgef�hrt
		 */
		function Insert($autoren, $art, $titel, $jahr, $verlag, $isbn, $beschreibung, $ort, $stichworte)
		{
			global $db_config, $sqldb, $login;

			// Nur wenn wir als Mitglied angemeldet sind
			if ($login->IsMember() === true)
			{
				// F�ge Literatur in Bibliothek ein
				$sql = "INSERT INTO ".$db_config['prefix']."Bibliothek
						VALUES (NULL, '$art', '$titel', '$jahr', '$verlag', '$isbn', '$beschreibung', '$ort', '$stichworte')";
				$sqldb->Query($sql);

				// Importiere jeden Autor und f�ge Verbindung zur
				// zur Literatur in Literatur_Autor an
				if ($nr = $sqldb->GetInsertID())
				{
					$autorlist = Autor::Split($autoren);
					foreach ($autorlist as $cur)
					{
						$sql = "INSERT INTO ".$db_config['prefix']."Literatur_Autor
							VALUES ('".$cur."', '$nr')";
						$sqldb->Query($sql);
					}
				}
			}
		}

		/*! \brief �ndert Literatur
		 *
		 *  Entfernt alle zur Literatur_Nr ($nr) geh�renden
		 *  Verbindungen in Autor_Literatur um danach die Literatur mit
		 *  Literatur_Nr $nr zu den neuen Werten ($art, $titel, $jahr,
		 *  $verlag, $isbn, $beschreibung, $ort, $stichworte) zu �ndern.
		 *  Danach werden die Autoren ($autoren) in Autoren geschrieben
		 *  und mit der Tabelle Literatur_Autor der Literatur
		 *  zugeordnet. Alle jetzt noch nicht zugeordneten Autoren in
		 *  Autoren werden gel�scht.
		 *  \pre Datenbankverbindung muss bestehen
		 *  \pre Literatur in Bibliothek mit Literatur_Nr $nr muss
		 *    existieren
		 *  \param[in] $nr Nummer der zu ver�ndernden Literatur
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
		 *    werden keine Operationen ausgef�hrt
		 */
		function Update($nr, $autoren, $art, $titel, $jahr, $verlag, $isbn, $beschreibung, $ort, $stichworte)
		{
			global $db_config, $sqldb, $login;

			// Nur wenn wir als Mitglied angemeldet sind
			if ($login->IsMember() === true)
			{
				// L�sche jede Verbindung zu Autoren in Literatur_Autor mit aktueller Literatur
				$sql = "DELETE FROM ".$db_config['prefix']."Literatur_Autor
						WHERE Literatur_Nr='$nr'";
				$sqldb->Query($sql);

				// �ndere aktuellen Literatureintrag
				$sql = "UPDATE ".$db_config['prefix']."Bibliothek
							SET Art='$art', Titel='$titel', Jahr='$jahr', Verlag='$verlag', ISBN='$isbn', Beschreibung='$beschreibung', Ort='$ort', Stichworte='$stichworte'
							WHERE Literatur_Nr='$nr'
							LIMIT 1";
				$sqldb->Query($sql);

				// F�ge neue Autoren hinzu und verbinde sie mit Literatur durch Literatur_Autor
				$autorlist = Autor::Split($autoren);
				foreach ($autorlist as $cur)
				{
					$sql = "INSERT INTO ".$db_config['prefix']."Literatur_Autor
						VALUES ('".$cur."', '$nr')";
					$sqldb->Query($sql);
				}

				Autor::Clean();
			}
		}
	}
?>
