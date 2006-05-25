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
		}

		/*! \brief Entfernt unnötige Autoren
		 *
		 *  Entfernt aus Autoren alle Autoren, die keine Verbindung
		 *  (Autoren_Literatur-Tabelle) mehr mit Literatur haben.
		 *  \pre Datenbankverbindung muss bestehen
		 */
		function Clean()
		{
		}

		/*! \brief Rückgabe eines Feldes von Autoren
		 *
		 *  Liest alle Autoren die einer Literatur ($nr) zugeordnet
		 *  sind aus Bibliothek aus und gibt sie als Feld des Typs
		 *  Autor zurück.
		 *  \param[in] $nr Nr einer Literatur mit Autoren
		 *  \pre Datenbankverbindung muss bestehen
		 *  \return Feld vom Typ Autor
		 */
		function GetAll($nr)
		{
			/// \todo implementieren
			$authors = array();

			//return $authors;
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
		}
	}
}
?>
