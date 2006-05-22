<?php
if(!defined("Kommentar"))
{
	define("Kommentar", 1);
	require_once("login.php");

	/*! \brief Verwaltet Kommentare
	 *
	 *  TODO
	 *  \pre Datenbankverbindung muss bestehen
	 */
	class Kommentar
	{
		var $Nr = 0; ///< Identifikationsnummer des Kommentars
		var $Text = 0; ///< Kommentartext
		var $Verfasser_Nr = 0; ///< Mitglieds_Nr des Verfassers
		var $Verfasser_Name = 0; ///< Name des Verfassers (Vor- und Nachname)
		
		/*! \brief Legt Kommentarobjekt an
		 *
		 *  TODO
		 *  \pre -
		 *  \param[in] $data Objekt mit Kommentardaten der Form
		 *    - Nr
		 *    - Text
		 *    - Mitglieds_Nr
		 *    - Vorname
		 *    - Nachname
		 */
		function Kommentar($data)
		{
		}
		
		/*! \brief Löscht Kommentar
		 *
		 *  TODO
		 *  \pre Datenbankverbindung muss bestehen
		 *  \param[in] $nr Nummer des zu löschenden Kommentars
		 */
		function Delete($nr)
		{
		}
		
		/*! \brief Löscht alle zu einer Literatur gehörenden Kommentare
		 *
		 *  TODO
		 *  \pre Datenbankverbindung muss bestehen
		 *  \param[in] $literatur_nr Nummer der Literatur
		 */
		function DeleteAll($literatur_nr)
		{
		}
		
		/*! \brief Legt Kommentar an
		 *
		 *  TODO
		 *  \pre Datenbankverbindung muss bestehen
		 *  \param[in] $text Text des Kommentars
		 *  \param[in] $verfasser_nr Mitglieds_Nr des Verfassers
		 *  \param[in] $literatur_nr Nummer der Literatur
		 */
		function Insert($text, $verfasser_nr, $literatur_nr)
		{
		}
		
		/*! \brief Ändert einen Kommentar
		 *
		 *  TODO
		 *  \pre Datenbankverbindung muss bestehen
		 *  \param[in] $nr Nummer des zu verändernden Kommentars
		 *  \param[in] $text neuer Text des Kommentars
		 */
		function Update($nr, $text)
		{
		}
	}
}
?>
