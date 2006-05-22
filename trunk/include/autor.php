<?php
if(!defined("Autor"))
{
	define("Autor", 1);

	/*! \brief Verwaltet Autoren
	 *
	 *  TODO
	 *  \pre Datenbankverbindung muss bestehen
	 */
	class Autor
	{
		var $Nr = 0; ///< Identifikationsnummer des Autors
		var $Name = 0; ///< Name des Autors
		
		/*! \brief Legt Autorenobjekt an
		 *
		 *  TODO
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
		 *  TODO
		 *  \pre Datenbankverbindung muss bestehen
		 */
		function Clean()
		{
		}

		/*! \brief Legt neue Autoren aus kommagetrennter Liste an
		 *
		 *  TODO
		 *  \pre Datenbankverbindung muss bestehen
		 *  \param[in] $autoren String mit kommagetrennter Liste von Autoren
		 *  \return Datenbankverbindung muss bestehen
		 */
		function Split($autoren)
		{
		}
	}
}
?>
