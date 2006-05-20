<?php
if(!defined("Literatur"))
{
	define("Literatur", 1);
	require_once("login.php");
	require_once("kommentar.php");
	require_once("literaturart.php");
	require_once("autor.php");

	/*! \brief TODO
	 *
	 *  TODO
	 *  \pre TODO
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
		
		/*! \brief TODO
		 *
		 *  TODO
		 *  \pre TODO
		 *  \param[in] $nr TODO
		 */
		function Literatur($nr)
		{
		}

		/*! \brief TODO
		 *
		 *  TODO
		 *  \pre TODO
		 *  \return TODO
		 */
		function ToBibtex()
		{
		}

		/*! \brief TODO
		 *
		 *  TODO
		 *  \pre TODO
		 *  \param[in] $nr TODO
		 */
		function Delete($nr)
		{
		}

		/*! \brief TODO
		 *
		 *  TODO
		 *  \pre TODO
		 *  \param[in] $bibtex TODO
		 */
		function Insert($bibtex)
		{
		}

		/*! \brief TODO
		 *
		 *  TODO
		 *  \pre TODO
		 *  \param[in] $art TODO
		 *  \param[in] $titel TODO
		 *  \param[in] $jahr TODO
		 *  \param[in] $nr TODO
		 *  \param[in] $verlag TODO
		 *  \param[in] $isbn TODO
		 *  \param[in] $beschreibung TODO
		 *  \param[in] $ort TODO
		 *  \param[in] $stichworte TODO
		 */
		function Insert($art, $titel, $jahr, $nr, $verlag, $isbn, $beschreibung, $ort, $stichworte)
		{
		}

		/*! \brief TODO
		 *
		 *  TODO
		 *  \pre TODO
		 *  \param[in] $nr TODO
		 *  \param[in] $art TODO
		 *  \param[in] $titel TODO
		 *  \param[in] $jahr TODO
		 *  \param[in] $nr TODO
		 *  \param[in] $verlag TODO
		 *  \param[in] $isbn TODO
		 *  \param[in] $beschreibung TODO
		 *  \param[in] $ort TODO
		 *  \param[in] $stichworte TODO
		 */
		function Insert($nr, $art, $titel, $jahr, $nr, $verlag, $isbn, $beschreibung, $ort, $stichworte)
		{
		}
	}
}
?>
