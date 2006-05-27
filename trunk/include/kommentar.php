<?php
if(!defined("Kommentar"))
{
	define("Kommentar", 1);
	require_once("include/login.php");

	/*! \brief Verwaltet Kommentare
	 *
	 *  Stellt Funktionen zum Anlegen, Löschen, Bearbeiten von Kommentaren
	 *  bereit. Es können sowohl einzelne Kommentare oder nach Literatur-
	 *  bzw. Mitgliederverbundenen Kommentaren gelöscht werden.
	 *  \pre Datenbankverbindung muss bestehen *  \sa
	 *  - SQLDB::Query
	 *  - SQLDB::Fetch
	 */
	class Kommentar
	{
		var $Nr = 0; ///< Identifikationsnummer des Kommentars
		var $Text = 0; ///< Kommentartext
		var $Verfasser_Nr = 0; ///< Mitglieds_Nr des Verfassers
		var $Verfasser_Name = 0; ///< Name des Verfassers (Vor- und Nachname)
		
		/*! \brief Legt Kommentarobjekt an
		 *
		 *  Legt ein neues Kommentarobjekt aus einem Objekt mit den
		 *  Attributen Nr, Text, Verfasser_Nr und Verfasser_Name an.
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
			$this->Nr = $data->Nr;
			$this->Text = $data->Text;
			$this->Verfasser_Nr = $data->Mitglieds_Nr;
			$this->Verfasser_Name = $data->Vorname." ".$data->Nachname;
		}
		
		/*! \brief Löscht Kommentar
		 *
		 *  Löscht einen Kommentar aus Kommentare mit der Kommentar_Nr
		 *  $nr.
		 *  \pre Datenbankverbindung muss bestehen
		 *  \param[in] $nr Nummer des zu löschenden Kommentars
		 */
		function Delete($nr)
		{
			global $db_config, $sqldb;

			$sql = "DELETE FROM ".$db_config['prefix']."Kommentare
					WHERE Kommentar_Nr = '$nr'
					LIMIT 1";
			$sqldb->Query($sql);
		}
		
		/*! \brief Löscht alle zu einer Literatur gehörenden Kommentare
		 *
		 *  Löscht alle Kommentare aus Kommentare, die mit Literatur
		 *  mit der Literaturnummer ($literatur_nr) verbunden sind.
		 *  \pre Datenbankverbindung muss bestehen
		 *  \param[in] $literatur_nr Nummer der Literatur
		 */
		function DeleteAll($literatur_nr)
		{
			global $db_config, $sqldb;

			$sql = "DELETE FROM ".$db_config['prefix']."Kommentare
					WHERE Literatur_Nr = '$literatur_nr'";
			$sqldb->Query($sql);
		}

		/*! \brief Löscht alle zu einem Mitglied gehörenden Kommentare
		 *
		 *  Löscht alle Kommentare aus Kommentare, die mit Mitglieder
		 *  mit der Mitglieds_Nr ($member_nr) verbunden sind.
		 *  \pre Datenbankverbindung muss bestehen
		 *  \param[in] $member_nr Nummer eines Mitglieds
		 */
		function DeleteAllMember($member_nr)
		{
			global $db_config, $sqldb;

			$sql = "DELETE FROM ".$db_config['prefix']."Kommentare
					WHERE Mitglieds_Nr = '$member_nr'";
			$sqldb->Query($sql);
		}
		
		/*! \brief Legt Kommentar an
		 *
		 *  Legt einen neuen Kommentar mit Text ($text) zu einer
		 *  Literatur ($literatur_nr) vom einem Verfasser 
		 *  ($verfasser_nr) an. Ist das aktuelle Mitglied kein 
		 *  Administrator, dann muss $verfasser_nr gleich der aktuellen
		 *  Nummer des Logins sein.
		 *  \pre Datenbankverbindung muss bestehen
		 *  \param[in] $text Text des Kommentars
		 *  \param[in] $verfasser_nr Mitglieds_Nr des Verfassers
		 *  \param[in] $literatur_nr Nummer der Literatur
		 */
		function Insert($text, $verfasser_nr, $literatur_nr)
		{
			global $db_config, $sqldb;

			$sql = "INSERT INTO ".$db_config['prefix']."Kommentare
					VALUES (NULL, '$text', '$literatur_nr', '$verfasser_nr')";
			$sqldb->Query($sql);
		}
		
		/*! \brief Ändert einen Kommentar
		 *
		 *  Ändert in Kommentare den Text des Kommentars mit $nr
		 *  in $text. Ist das aktuelle Mitglied kein Administrator,
		 *  dann muss die aktuelle Nummer des Mitglieds gleich der
		 *  Mitglieds_Nr des Kommentars in Kommentare sein.
		 *  \pre Datenbankverbindung muss bestehen
		 *  \param[in] $nr Nummer des zu verändernden Kommentars
		 *  \param[in] $text neuer Text des Kommentars
		 */
		function Update($nr, $text)
		{
			global $db_config, $sqldb;

			$sql = "UPDATE ".$db_config['prefix']."Kommentare
					SET Kommentartext='$text'
					WHERE Kommentar_Nr='$nr'
					LIMIT 1";
			$sqldb->Query($sql);
		}
	}
}
?>
