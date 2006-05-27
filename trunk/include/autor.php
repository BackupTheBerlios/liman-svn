<?php
if(!defined("Autor"))
{
	define("Autor", 1);

	/*! \brief Verwaltet Autoren
	 *
	 *  Stellt Funktionen zum Hinzufügen von Autoren und Bereinigen nicht
	 *  mehr benutzter Autoren bereit.
	 *  \pre Datenbankverbindung muss bestehen
	 */
	class Autor
	{
		var $Nr = 0; ///< Identifikationsnummer des Autors
		var $Name = 0; ///< Name des Autors
		
		/*! \brief Legt Autorenobjekt an
		 *
		 *  Legt ein neues Autorenobjekt aus einem Objekt mit den
		 *  Attributen Nr und Name an.
		 *  \pre -
		 *  \param[in] $data Objekt mit Autorendaten der Form
		 *    - Nr
		 *    - Name
		 */
		function Autor($data)
		{
			$this->Nr = $data->Nr;
			$this->Name = $data->Name;
		}

		/*! \brief Entfernt unnötige Autoren
		 *
		 *  Entfernt aus Autoren alle Autoren, die keine Verbindung
		 *  (Literatur_Autoren-Tabelle) mehr mit Literatur haben.
		 *  \pre Datenbankverbindung muss bestehen
		 */
		function Clean()
		{
			$sql = "DELETE FROM ".$db_config['prefix']."Autoren as autoren
					WHERE (0 = (SELECT COUNT(*) FROM ".$db_config['prefix']."Literatur_Autoren WHERE (AutorNr = autoren.ID)))";
			$sqldb->Query($sql);
		}

		/*! \brief Rückgabe eines Feldes von Autoren
		 *
		 *  Liest alle Autoren die einer Literatur ($nr) zugeordnet
		 *  sind aus Bibliothek aus und gibt sie als Feld des Typs
		 *  Autor zurück.
		 *  \param[in] $literatur_nr Nr einer Literatur mit Autoren
		 *  \pre Datenbankverbindung muss bestehen
		 *  \return Feld vom Typ Autor
		 */
		function GetAll($literatur_nr)
		{
			global $db_config, $sqldb;

			$authors = array();
			$sql = "SELECT  autoren.Autor_Nr AS Nr, Autorname AS Name
					FROM ".$db_config['prefix']."Literatur_Autor AS connect
					INNER JOIN  ".$db_config['prefix']."Autoren AS autoren
					ON connect.Autor_Nr = autoren.Autor_Nr
					WHERE Literatur_Nr = '$literatur_nr'";
			$sqldb->Query($sql);
			while ($cur = $sqldb->Fetch())
			{
				$authors[] = new Autor($cur);
			}
			return $authors;
		}

		/*! \brief Legt neue Autoren aus kommagetrennter Liste an
		 *
		 *  Teilt die kommagetrennte Liste von Autoren in einzelne
		 *  Autorennamen ein und überprüft gegen Autorentabelle, ob
		 *  diese schon in der Datenbank existieren. Sollten diese
		 *  schon existieren, dann wird Autor_Nr ausgelesen und zum
		 *  Feld hinzugefügt. Sollten diese noch nicht existieren,
		 *  werden sie hinzugefügt und die neuen Autor_Nr zum Feld
		 *  hinzugefügt. Das komplette Feld vom Typ Autor_Nr wird
		 *  zurückgegeben.
		 *  \pre Datenbankverbindung muss bestehen
		 *  \param[in] $autoren String mit kommagetrennter Liste von Autoren
		 *  \return Feld mit Autor_Nr der Autoren
		 */
		function Split($autoren)
		{
			global $db_config, $sqldb;
			
			$authorNames = array();
			$authorNumbers = array();
			$authorNames = split( ",", $autoren );
			
			for( $i = 0; i < count($authorNames); $i++ )
			{
				$sqlSelect = "SELECT Autor_Nr AS Nr FROM ".$db_config['prefix']."Autoren AS autoren
						      WHERE Autorname = '".trim($authorNames[i])."'";
				$sqldb->Query( $sqlSelect );
				
				if( $cur = $sqldb->Fetch() )
				{
					$authorNumbers[] = $cur->Nr;
				}
				else
				{
					$sqlInsert = "INSERT INTO ".$db_config['prefix']."Autoren VALUES ('".trim($authorNames[i])."')";
					$sqlIdentity = "SELECT @@IDENTITY AS Nr FROM ".$db_config['prefix']."Autoren";
					$sqldb->Query( $sqlInsert );
					$sqldb->Query( $sqlIdentity );
					$authorNumbers[] = $sqldb->Fetch()->Nr;
				}
			}
			
			return $authorNumbers;
		}
	}
}
?>
