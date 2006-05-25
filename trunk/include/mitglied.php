<?php
if(!defined("Mitglied"))
{
	define("Mitglied", 1);
	require_once("include/login.php");

	/*! \brief Verwaltet Mitglieder
	 *
	 *  Stellt Funktionen zum Entfernen, Hinzufügen, Ändern und Auflisten
	 *  von Mitgliedern bereit.
	 *  \pre Datenbankverbindung muss bestehen
	 */
	class Mitglied
	{
		var $Nr = 0; ///< Identifikationsnummer des Mitglieds
		var $Login = ""; ///< Benutzername des Mitglieds
		var $Passwort = ""; ///< Passworthash des Benutzerpassworts
		var $Rechte = 0; ///< Rechte des Mitglieds (0 - Gast, 1 - Mitglied, 2 - Administrator)
		var $Vorname = ""; ///< Vorname des Mitglieds
		var $Nachname = ""; ///< Nachname des Mitglieds
		var $Email = ""; ///< E-Mail-Adresse des Mitglieds
		
		/*! \brief Liest Mitglied ein
		 *
		 *  Liest Mitglied mit Mitglied_Nr ($nr)
		 *  und setzt Felder entsprechend den Daten.
		 *  \pre Datenbankverbindung muss bestehen
		 *  \param[in] $nr Nummer der zu einlesenden Literatur
		 */
		function Mitglied($nr)
		{
		}
		
		/*! \brief Generiert Passworthash
		 *
		 *  Aus übergebenes Klartextpasswort wird ein 40 Byte großer
		 *  hexkodierter Hash generiert. Als Hashingalgorithmus wird
		 *  SHA-1 genutzt
		 *  \pre -
		 *  \param[in] $pass zu hashendes Klartextpasswort
		 */
		function PasswordHash($pass)
		{
			return sha1($pass);
		}
		
		/*! \brief Entfernt Mitglied
		 *
		 *  Entfernt Mitglied mit Mitgliedsnummer ($nr) aus Mitglieder
		 *  und löscht zusätzlich die Kommentare des Mitglieds in
		 *  Kommentare
		 *  \pre Datenbankverbindung muss bestehen
		 *  \param[in] $nr Mitglieds_Nr des zu löschenden Mitglieds
		 */
		function Delete($nr)
		{
			/// \todo implementieren
		}
		
		/*! \brief Legt  Mitglied an
		 *
		 *  Fügt neues Mitglied mit Benutzernamen ($login), Passwort
		 *  ($passwort), Benutzerrechten ($rechte), Vorname ($vorname),
		 *  Nachname ($nachname), E-Mail-Adresse ($email) in Mitglieder
		 *  ein. Dazu wird das Passwort noch mit Mitglied::PasswortHash
		 *  gehasht.
		 *  \pre Datenbankverbindung muss bestehen
		 *  \param[in] $login Benutzername des neuen Mitglieds
		 *  \param[in] $passwort Benutzerpasswort des neuen Mitglieds
		 *  \param[in] $rechte Rechte des neuen Mitglieds
		 *     (1 - Mitglied, 2 - Passwort)
		 *  \param[in] $vorname Vorname des neuen Mitglieds
		 *  \param[in] $nachname Nachname des neuen Mitglieds
		 *  \param[in] $email E-Mail-Adresse des neuen Mitglieds
		 */
		function Insert($login, $passwort, $rechte, $vorname, $nachname, $email)
		{
			/// \todo implementieren
		}
		
		/*! \brief Ändert ein Mitglied
		 *
		 *  Ändert die Daten das Mitglieds mit der Mitglieds_Nr ($nr),
		 *  in neuen Benutzernamen ($login), Passwort ($passwort),
		 *  Benutzerrechten ($rechte), Vorname ($vorname),
		 *  Nachname ($nachname), E-Mail-Adresse ($email) in
		 *  Mitglieder. Wenn $passwort nicht die Länge 0 hat, wird es 
		 *  noch mit Mitglied::PasswortHash gehasht. Andernfalls wird
		 *  das alte Passwort in Mitglieder beibehalten.
		 *  \pre Datenbankverbindung muss bestehen
		 *  \param[in] $nr Mitglieds_Nr des zu verändernden Mitglieds
		 *  \param[in] $login neuer Benutzername des Mitglieds
		 *  \param[in] $passwort neues Passwort des Mitglieds
		 *  \param[in] $rechte neuen Rechte des Mitglieds
		 *  \param[in] $vorname neuer Vorname des Mitglieds
		 *  \param[in] $nachname neuer Nachname des Mitglieds
		 *  \param[in] $email neue E-Mail-Adresse des Mitglieds
		 */
		function Update($nr, $login, $passwort, $rechte, $vorname, $nachname, $email)
		{
			/// \todo implementieren
		}
		
		/*! \brief Rückgabe einer Liste der Mitglieder
		 *
		 *  Liest alle Mitglieder mit Nr, Login, Vorname, Nachname und
		 *  Email aus Mitgliedertabelle und gibt die ausgelesenen
		 *  Objekte in einem Feld zurück
		 *  \pre Datenbankverbindung muss bestehen
		 *  \return Feld mit Objekten der Form
		 *    - Nr
		 *    - Login
		 *    - Vorname
		 *    - Nachname
		 *    - Email
		 */
		function GetAll()
		{
			/// \todo implementieren
			$members = array();

			$cur1->Nr = 1;
			$cur1->Login = "siwu";
			$cur1->Vorname = "Simon";
			$cur1->Nachname = "Wunderlich";
			$cur1->Email = "siwu@hrz.tu-chemnitz.de";
			$members[] = $cur1;

			$cur2->Nr = 2;
			$cur2->Login = "hans";
			$cur2->Vorname = "Hans";
			$cur2->Nachname = "Wurst";
			$cur2->Email = "hans@foobar.de";
			$members[] = $cur2;

			return $members;
		}
	}
}
?>
