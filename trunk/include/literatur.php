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
		 */
		class Literatur
		{
			var $Nr = 0; ///< TODO
			var $Titel = ""; ///< TODO
			var $Jahr = 0; ///< TODO
			var $Verlag = ""; ///< TODO
			var $ISBN = ""; ///< TODO
			var $Beschreibung = ""; ///< TODO
			var $Ort = ""; ///< TODO
			var $Stichworte = ""; ///< TODO
			var $Art; ///< TODO
			var $Autoren = array(); ///< TODO
			var $Kommentare = array(); ///< TODO
			
			/*! \brief TODO
			 *
			 *  TODO
			 *  \param $nr TODO
			 */
			function Literatur($nr)
			{
			}

			/*! \brief TODO
			 *
			 *  TODO
			 *  \return TODO
			 */
			function ToBibtex()
			{
			}

			/*! \brief TODO
			 *
			 *  TODO
			 *  \param $nr TODO
			 */
			function Delete($nr)
			{
			}

			/*! \brief TODO
			 *
			 *  TODO
			 *  \param $bibtex TODO
			 */
			function Insert($bibtex)
			{
			}

			/*! \brief TODO
			 *
			 *  TODO
			 *  \param $art TODO
			 *  \param $titel TODO
			 *  \param $jahr TODO
			 *  \param $nr TODO
			 *  \param $verlag TODO
			 *  \param $isbn TODO
			 *  \param $beschreibung TODO
			 *  \param $ort TODO
			 *  \param $stichworte TODO
			 */
			function Insert($art, $titel, $jahr, $nr, $verlag, $isbn, $beschreibung, $ort, $stichworte)
			{
			}

			/*! \brief TODO
			 *
			 *  TODO
			 *  \param $nr TODO
			 *  \param $art TODO
			 *  \param $titel TODO
			 *  \param $jahr TODO
			 *  \param $nr TODO
			 *  \param $verlag TODO
			 *  \param $isbn TODO
			 *  \param $beschreibung TODO
			 *  \param $ort TODO
			 *  \param $stichworte TODO
			 */
			function Insert($nr, $art, $titel, $jahr, $nr, $verlag, $isbn, $beschreibung, $ort, $stichworte)
			{
			}
		}
	}
?>