<?php
if(!defined("Mitglied"))
{
	define("Mitglied", 1);
	require_once("login.php");

	/*! \brief TODO
	 *
	 *  TODO
	 *  \pre
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
		 *  \pre
		 *  \param[in] $pass TODO
		 */
		function PasswordHash($pass)
		{
			return sha1($pass);
		}
		
		/*! \brief TODO
		 *
		 *  TODO
		 *  \pre
		 *  \param[in] $nr TODO
		 */
		function Delete($nr)
		{
		}
		
		/*! \brief TODO
		 *
		 *  TODO
		 *  \pre
		 *  \param[in] $login TODO
		 *  \param[in] $passwort TODO
		 *  \param[in] $rechte TODO
		 *  \param[in] $vorname TODO
		 *  \param[in] $nachname TODO
		 *  \param[in] $email TODO
		 */
		function Insert($login, $passwort, $rechte, $vorname, $nachname, $email)
		{
		}
		
		/*! \brief TODO
		 *
		 *  TODO
		 *  \pre
		 *  \param[in] nr TODO
		 *  \param[in] $login TODO
		 *  \param[in] $passwort TODO
		 *  \param[in] $rechte TODO
		 *  \param[in] $vorname TODO
		 *  \param[in] $nachname TODO
		 *  \param[in] $email TODO
		 */
		function Update($nr, $login, $passwort, $rechte, $vorname, $nachname, $email)
		{
		}
		
		/*! \brief TODO
		 *
		 *  TODO
		 *  \pre
		 *  \return TODO
		 */
		function GetAll()
		{
		}
	}
}
?>
