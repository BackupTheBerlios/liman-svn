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
		function Literatur($nr);

		/*! \brief Exportiert Literatur nach BibTeX
		 *
		 *  Exportiert die aktuellen Informationen im Literaturobjekt
		 *  in das BibTeX-Format.
		 *  \pre -
		 *  \return $string mit BibTeX-Eintrag
		 */
		function ToBibtex();

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
		function Delete($nr);

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
		function InsertBibTeX($bibtex);

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
		function Insert($autoren, $art, $titel, $jahr, $verlag, $isbn, $beschreibung, $ort, $stichworte);

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
		function Update($nr, $autoren, $art, $titel, $jahr, $verlag, $isbn, $beschreibung, $ort, $stichworte);
	}
?>
