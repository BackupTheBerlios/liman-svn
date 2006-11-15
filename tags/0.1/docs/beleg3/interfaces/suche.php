<?php
	require_once("include/autor.php");
	require_once("include/literatur.php");

	/*! \brief Suche Literaturdaten
	 *
	 *  Durchsucht die Tabelle Bibliothek und Autoren �ber Volltextsuche,
	 *  nach Autor und Titel oder nach den 10 zuletzt hinzugef�gten
	 *  Literatureintr�gen und speichert sie in $Treffer zwischen.
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
		 *  Wenn keine Parameter �bergeben werden:
		 *  - Sucht in Tabelle Bibliothek nach den 10 zuletzt
		 *    hinzugef�gten Literatureintr�gen und speichert Nr, Titel,
		 *    Autor, Verlag und ISBN als Objekt im Feld $Treffer.
		 *    Sollte ein Fehler auftreten oder bisher keine Eintr�ge
		 *    vorhanden sein, dann wird $Treffer ein Feld der L�nge 0.
		 *
		 *  Wenn ein $suchbegriff �bergeben wird:
		 *  - Sucht in Tabelle Literatur und Autoren nach dem Auftreten
		 *    des �bergebenen Textes in  Literatureintr�gen und speichert
		 *    Nr, Titel, Autor, Verlag und ISBN als Objekt im Feld
		 *    $Treffer. Sollte ein Fehler auftreten oder keine passenden
		 *    Eintr�ge vorhanden sein, dann wird $Treffer ein Feld der
		 *    L�nge 0.
		 *
		 *  Wenn $suchbegriff und $autor �bergeben werden:
		 *  - Sucht in Tabelle Bibliothek und Autoren nach dem Auftreten
		 *    von $autor in Autor und $suchbegriff im Titel des 
		 *    Literatureintrags und speichert Nr, Titel, Autor, Verlag
		 *    als Objekt im Feld $Treffer. Sollte ein Fehler auftreten
		 *    und ISBN der Treffer oder keine passenden Eintr�ge vorhanden
		 *    sein, dann wird $Treffer ein Feld der L�nge 0.
		 *  - Wird eine kommagetrennte Liste von Autoren als
		 *    $autor �bergeben, muss in Treffern nur einer der
		 *    genannten Autoren auftreten.
		 *
		 *  \pre Datenbankverbindung muss bestehen.
		 *  \param[in] $autor String mit Autorname
		 *  \param[in] $suchbegriff String mit Literaturtitel bzw. wenn
		 *     einzeln �bergeben Suchtext f�r Volltextsuche
		 */
		function Suche($suchbegriff="", $autor="");
	}
?>
