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
		function Suche($suchbegriff="", $autor="");
	}
?>
