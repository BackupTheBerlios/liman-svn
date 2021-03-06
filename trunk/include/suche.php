<?php
	require_once("include/autor.php");
	require_once("include/literatur.php");

	/*! \brief Suche Literaturdaten
	 *
	 *  Durchsucht die Tabelle Bibliothek und Autoren über Volltextsuche,
	 *  nach Autor und Titel oder nach den 10 zuletzt hinzugefügten
	 *  Literatureinträgen und speichert sie in $Treffer zwischen.
	 *  \pre Datenbankverbindung muss bestehen
	 *  \sa
	 *  - Autor::GetAll
	 *  - SQLDB::Query
	 *  - SQLDB::Fetch
	 *
	 *  \author Sven Eckelmann
	 *  \date 30.05.2006
	 */
	class Suche
	{
		/*! \brief gefundene Treffer
		 *
		 *  Feld aus gefundenen Trefferobjekten mit Attributen
		 *   - Nr
		 *   - Titel
		 *   - Autor
		 *   - Verlag
		 *   - ISBN
		 */
		var $Treffer = array();

		/*! \brief Sucht zuletzt hinzugefügte Literatur
		 *
		 *  Sucht in Tabelle Bibliothek nach den 10 zuletzt hinzugefügten
		 *  Literatureinträgen und speichert Nr, Titel, Autor, Verlag
		 *  und ISBN als Objekt im Feld $Treffer. Sollte ein Fehler
		 *  auftreten oder bisher keine Einträge vorhanden sein, dann
		 *  wird $Treffer ein Feld der Länge 0.
		 *  \pre Datenbankverbindung muss bestehen.
		 *  \private
		 */
		function LetzteLiteratur()
		{
			global $sqldb, $db_config;

			// Finde die 10 zuletzt hinzugefügten Literatureinträge
			$sql = "SELECT Literatur_Nr AS Nr, Titel, Verlag, ISBN
					FROM ".$db_config['prefix']."Bibliothek AS bibliothek
					ORDER BY `Literatur_Nr` DESC
					LIMIT 10";
			$sqldb->Query($sql);

			// Lese Treffer aus
			$this->Treffer = array();
			while ($cur = $sqldb->Fetch())
			{
				$this->Treffer[] = $cur;	
			}

			// Lese zu jedem Treffer Autoren
			for ($i = 0; $i < count($this->Treffer); $i++)
			{
				// Kommagetrennte Autorenliste erstellen
				$authors = Autor::GetAll($this->Treffer[$i]->Nr);

				// Erstelle kommagetrennte Liste der Autoren
				$autorlist = "";
				if (empty($authors) === false)
				{
					$autornamen = array();
					foreach ($authors as $cur)
					{
						$autornamen[] = $cur->Name;
					}
	
					$autorlist = implode(", ", $autornamen);
				}
				$this->Treffer[$i]->Autor = $autorlist;
			}
		}

		/*! \brief Sucht nach Literatur mit Suchbegriff
		 *
		 *  Sucht in Tabelle Bibliothek und Autor nach dem Auftreten
		 *  des übergebenen Textes in  Literatureinträgen und speichert
		 *  Nr, Titel, Autor, Verlag und ISBN als Objekt im Feld
		 *  $Treffer. Sollte ein Fehler auftreten oder keine passenden
		 *  Einträge vorhanden sein, dann wird $Treffer ein Feld der
		 *  Länge 0.
		 *  \pre Datenbankverbindung muss bestehen.
		 *  \param[in] $volltext Suchtext
		 *  \private
		 */
		function VolltextSuche($volltext)
		{
			global $sqldb, $db_config;
			$this->Treffer = array();

			$volltext = trim($volltext);
			if (empty($volltext) === false)
			{
				// Finde Literatur mit Suchbegriff
				$sql = "SELECT DISTINCT bibliothek.Literatur_Nr AS Nr, Titel, Verlag, ISBN
						FROM (".$db_config['prefix']."Bibliothek AS bibliothek
							INNER JOIN  ". $db_config['prefix'] ."Literatur_Autor AS connect
							ON bibliothek.Literatur_Nr = connect.Literatur_Nr)
						INNER JOIN  ".$db_config['prefix']."Autoren AS autoren
						ON connect.Autor_Nr = autoren.Autor_Nr
						WHERE MATCH (Titel, Verlag, ISBN, Beschreibung, Ort, Stichworte) AGAINST ('$volltext' IN BOOLEAN MODE)
						OR MATCH (Autorname) AGAINST ('$volltext' IN BOOLEAN MODE)";

				if ($sqldb->Query($sql) === false)
				{
					// Workaround für MySQL < 4
					// Ohne Boolean Mode suchen
					$sql = "SELECT DISTINCT bibliothek.Literatur_Nr AS Nr, Titel, Verlag, ISBN
						FROM (".$db_config['prefix']."Bibliothek AS bibliothek
							INNER JOIN  ". $db_config['prefix'] ."Literatur_Autor AS connect
							ON bibliothek.Literatur_Nr = connect.Literatur_Nr)
						INNER JOIN  ".$db_config['prefix']."Autoren AS autoren
						ON connect.Autor_Nr = autoren.Autor_Nr
						WHERE MATCH (Titel, Verlag, ISBN, Beschreibung, Ort, Stichworte) AGAINST ('$volltext')
						OR MATCH (Autorname) AGAINST ('$volltext')";
					$sqldb->Query($sql);
				}
				
				// Lese Treffer aus
				while ($cur = $sqldb->Fetch())
				{
					$this->Treffer[] = $cur;	
				}
	
				// Lese zu jedem Treffer Autoren
				for ($i = 0; $i < count($this->Treffer); $i++)
				{
					// Kommagetrennte Autorenliste erstellen
					$authors = Autor::GetAll($this->Treffer[$i]->Nr);
	
					// Erstelle kommagetrennte Liste der Autoren
					$autorlist = "";
					if (empty($authors) === false)
					{
						$autornamen = array();
						foreach ($authors as $cur)
						{
							$autornamen[] = $cur->Name;
						}
		
						$autorlist = implode(", ", $autornamen);
					}
					$this->Treffer[$i]->Autor = $autorlist;
				}
			}
		}
		
		/*! \brief Sucht Literatur mit Autor und Titel
		 *
		 *  Sucht in Tabelle Bibliothek und Autoren nach dem Auftreten
		 *  von $autor in Autor und $titel im Titel des Literatureintrags
		 *  und speichert Nr, Titel, Autor, Verlag und ISBN der Treffer
		 *  als Objekt im Feld $Treffer. Sollte ein Fehler auftreten
		 *  oder keine passenden Einträge vorhanden sein, dann wird
		 *  $Treffer ein Feld der Länge 0.
		 *  \pre Datenbankverbindung muss bestehen.
		 *  \param[in] $titel String mit Literaturtitel
		 *  \param[in] $autor String mit Autorname
		 *  \private
		 *  \remarks Wird eine kommagetrennte Liste von Autoren als
		 *    $autor übergeben, muss in Treffern nur einer der
		 *    genannten Autoren auftreten.
		 */
		function AutorTitelSuche($titel, $autor)
		{
			global $sqldb, $db_config;
			$this->Treffer = array();

			$titel = trim($titel);
			$autor = trim($autor);
			if (empty($titel) === false || empty($autor) === false)
			{
				// Finde Literatur mit Titel und Autor
				$sql = "SELECT DISTINCT bibliothek.Literatur_Nr AS Nr, Titel, Verlag, ISBN
						FROM (".$db_config['prefix']."Bibliothek AS bibliothek
							INNER JOIN  ". $db_config['prefix'] ."Literatur_Autor AS connect
							ON bibliothek.Literatur_Nr = connect.Literatur_Nr)
						INNER JOIN  ".$db_config['prefix']."Autoren AS autoren
						ON connect.Autor_Nr = autoren.Autor_Nr
						WHERE bibliothek.Titel like '%".$titel."%'";

				// Trenne kommagetrennte Autorenliste und
				// füge es Suche hinzu
				if (empty($autor) === false)
				{
					$sql .= " AND (";
					$authors = array();
					$authors = split(",", $autor);
					for($i = 0; $i < count($authors); $i++)
					{
						if ($i != 0)
						{
							$sql .= " OR ";
						}
						$sql .= "autoren.Autorname like '%".trim($authors[$i])."%'";
					}
					$sql .= ")";
				}
				$sqldb->Query($sql);

				// Lese Treffer aus
				while ($cur = $sqldb->Fetch())
				{
					$this->Treffer[] = $cur;	
				}
	
				// Lese zu jedem Treffer Autoren
				for ($i = 0; $i < count($this->Treffer); $i++)
				{
					// Kommagetrennte Autorenliste erstellen
					$authors = Autor::GetAll($this->Treffer[$i]->Nr);
	
					// Erstelle kommagetrennte Liste der Autoren
					$autorlist = "";
					if (empty($authors) === false)
					{
						$autornamen = array();
						foreach ($authors as $cur)
						{
							$autornamen[] = $cur->Name;
						}
		
						$autorlist = implode(", ", $autornamen);
					}
					$this->Treffer[$i]->Autor = $autorlist;
				}
			}
		}

		
		/*! \brief Sucht Literatur
		 *
		 *  Wenn keine Parameter übergeben werden:
		 *  - Sucht in Tabelle Bibliothek nach den 10 zuletzt
		 *    hinzugefügten Literatureinträgen und speichert Nr, Titel,
		 *    Autor, Verlag und ISBN als Objekt im Feld $Treffer.
		 *    Sollte ein Fehler auftreten oder bisher keine Einträge
		 *    vorhanden sein, dann wird $Treffer ein Feld der Länge 0.
		 *
		 *  Wenn ein $suchbegriff übergeben wird:
		 *  - Sucht in Tabelle Literatur und Autoren nach dem Auftreten
		 *    des übergebenen Textes in  Literatureinträgen und speichert
		 *    Nr, Titel, Autor, Verlag und ISBN als Objekt im Feld
		 *    $Treffer. Sollte ein Fehler auftreten oder keine passenden
		 *    Einträge vorhanden sein, dann wird $Treffer ein Feld der
		 *    Länge 0.
		 *
		 *  Wenn $suchbegriff und $autor übergeben werden:
		 *  - Sucht in Tabelle Bibliothek und Autoren nach dem Auftreten
		 *    von $autor in Autor und $suchbegriff im Titel des 
		 *    Literatureintrags und speichert Nr, Titel, Autor, Verlag
		 *    als Objekt im Feld $Treffer. Sollte ein Fehler auftreten
		 *    und ISBN der Treffer oder keine passenden Einträge vorhanden
		 *    sein, dann wird $Treffer ein Feld der Länge 0.
		 *  - Wird eine kommagetrennte Liste von Autoren als
		 *    $autor übergeben, muss in Treffern nur einer der
		 *    genannten Autoren auftreten.
		 *
		 *  \pre Datenbankverbindung muss bestehen.
		 *  \param[in] $autor String mit Autorname
		 *  \param[in] $suchbegriff String mit Literaturtitel bzw. wenn
		 *     einzeln übergeben Suchtext für Volltextsuche
		 */
		function Suche($suchbegriff="", $autor="")
		{
			// Wähle nach Parameteranzahl die richtige Suchfunktion
			switch (func_num_args())
			{
			case 0:
				$this->LetzteLiteratur();
				break;
			case 1:
				$this->VolltextSuche($suchbegriff);
				break;
			case 2:
				$this->AutorTitelSuche($suchbegriff, $autor);
				break;
			}
		}
	}
?>
