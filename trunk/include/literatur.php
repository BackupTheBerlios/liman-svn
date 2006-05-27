<?php
if(!defined("Literatur"))
{
	define("Literatur", 1);
	require_once("include/login.php");
	require_once("include/kommentar.php");
	require_once("include/literaturart.php");
	require_once("include/autor.php");

	/*! \brief Verwaltet Literatur
	 *
	 *  Stellt Funktionen zum Abruf, Exportieren, Löschen, Importieren,
	 *  Hinzufügen und Ändern von Literatur in Bibliothek zur Verfügung.
	 *  \pre Datenbankverbindung muss bestehen
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
			/// \todo implementieren
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
			/// \todo implementieren
		}

		/*! \brief Löscht Literatur
		 *
		 *  Löscht Literatur aus Bibliothek mit der Literatur_Nr $nr.
		 *  Alle verbundenen Kommentare werden aus Kommentare gelöscht.
		 *  Außerdem werden alle nun nicht mehr gebrauchten Autoren in
		 *  Autoren gelöscht.
		 *  \pre Datenbankverbindung muss bestehen
		 *  \param[in] $nr Nummer der zu löschenden Literatur
		 */
		function Delete($nr)
		{
			/// \todo implementieren
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
		 *  Tabelle Literatur_Autoren der Literatur zugeordnet.
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
		 */
		function Insert($autoren, $art, $titel, $jahr, $verlag, $isbn, $beschreibung, $ort, $stichworte)
		{
			/// \todo implementieren
		}

		/*! \brief Ändert Literatur
		 *
		 *  Entfernt alle zur Literatur_Nr ($nr) gehörenden
		 *  Verbindungen in Autor_Literatur um danach die Literatur mit
		 *  Literatur_Nr $nr zu den neuen Werten ($art, $titel, $jahr,
		 *  $verlag, $isbn, $beschreibung, $ort, $stichworte) zu ändern.
		 *  Danach werden die Autoren ($autoren) in Autoren geschrieben
		 *  und mit der Tabelle Literatur_Autoren der Literatur
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
		 */
		function Update($nr, $autoren, $art, $titel, $jahr, $verlag, $isbn, $beschreibung, $ort, $stichworte)
		{
			/// \todo implementieren
		}
	}
}
?>
