<?php
	if(!defined("Mitglied"))
	{
		define("Mitglied", 1);
		require_once("login.php");

		/*! \brief TODO
		 *
		 *  TODO
		 */
		class Mitglied
		{
			var $Nr = 0; ///< TODO
			var $Login = ""; ///< TODO
			var $Passwort = ""; ///< TODO
			var $Rechte = 0; ///< TODO
			var $Vorname = ""; ///< TODO
			var $Nachname = ""; ///< TODO
			var $Email = ""; ///< TODO
			
			/*! \brief TODO
			 *
			 *  TODO
			 *  \param $pass TODO
			 */
			function PasswordHash($pass)
			{
				return sha1($pass);
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
			 *  \param $login TODO
			 *  \param $passwort TODO
			 *  \param $rechte TODO
			 *  \param $vorname TODO
			 *  \param $nachname TODO
			 *  \param $email TODO
			 */
			function Insert($login, $passwort, $rechte, $vorname, $nachname, $email)
			{
			}
			
			/*! \brief TODO
			 *
			 *  TODO
			 *  \param nr TODO
			 *  \param $login TODO
			 *  \param $passwort TODO
			 *  \param $rechte TODO
			 *  \param $vorname TODO
			 *  \param $nachname TODO
			 *  \param $email TODO
			 */
			function Update($nr, $login, $passwort, $rechte, $vorname, $nachname, $email)
			{
			}
			
			/*! \brief TODO
			 *
			 *  TODO
			 *  \return TODO
			 */
			function GetAll()
			{
			}
		}
	}
?>