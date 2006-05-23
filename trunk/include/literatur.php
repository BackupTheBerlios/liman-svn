<?php
if(!defined("Literatur"))
{
	define("Literatur", 1);
	require_once("login.php");
	require_once("kommentar.php");
	require_once("literaturart.php");
	require_once("autor.php");

	/*! \brief Verwaltet Literatur
	 *
	 *  TODO
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
		 *  TODO
		 *  \pre Datenbankverbindung muss bestehen
		 *  \param[in] $nr Nummer der zu einlesenden Literatur
		 */
		function Literatur($nr)
		{
		}

		/*! \brief Exportiert Literatur nach BibTeX
		 *
		 *  TODO
		 *  \pre -
		 *  \return TODO
		 */
		function ToBibtex()
		{
		}

		/*! \brief Löscht Literatur
		 *
		 *  TODO
		 *  \pre Datenbankverbindung muss bestehen
		 *  \param[in] $nr Nummer der zu löschenden Literatur
		 */
		function Delete($nr)
		{
		}

		/*! \brief Importiert BibTeX
		 *
		 *  TODO
		 *  \pre Datenbankverbindung muss bestehen
		 *  \param[in] $bibtex String mit Inhalt einer BibTeX-Datei
		 */
		function InsertBibTeX($bibtex)
		{
		}

		/*! \brief Legt Literatur an
		 *
		 *  TODO
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
		}

		/*! \brief Ändert Literatur
		 *
		 *  TODO
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
		}
	}
}
?>
