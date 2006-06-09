<?php
	require_once("include/login.php");
	require_once("include/kommentar.php");

	/*! \brief Verwaltet Mitglieder
	 *
	 *  Stellt Funktionen zum Entfernen, Hinzuf�gen, �ndern und Auflisten
	 *  von Mitgliedern bereit.
	 *  \pre Datenbankverbindung muss bestehen
	 *  \sa
	 *  - Kommentar::DeleteAllMember
	 *  - Login::IsAdministrator
	 *  - Login::IsMember
	 *  - SQLDB::Query
	 *  - SQLDB::Fetch
	 *
	 *  \author Sven Eckelmann
	 *  \date 30.05.2006
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
		function Mitglied($nr);
		
		/*! \brief Generiert Passworthash
		 *
		 *  Aus �bergebenes Klartextpasswort wird ein 40 Byte gro�er
		 *  hexkodierter Hash generiert. Als Hashingalgorithmus wird
		 *  SHA-1 genutzt
		 *  \pre -
		 *  \param[in] $pass zu hashendes Klartextpasswort
		 */
		function PasswordHash($pass);
		
		/*! \brief Entfernt Mitglied
		 *
		 *  Entfernt Mitglied mit Mitgliedsnummer ($nr) aus Mitglieder
		 *  und l�scht zus�tzlich die Kommentare des Mitglieds in
		 *  Kommentare
		 *  \pre Datenbankverbindung muss bestehen
		 *  \pre Mitglied in Mitglieder mit Mitglieds_Nr $nr muss
		 *    existieren
		 *  \param[in] $nr Mitglieds_Nr des zu l�schenden Mitglieds
		 *  \remarks Ist der Nutzer nicht als Administrator angemeldet,
		 *    werden keine Operationen ausgef�hrt
		 */
		function Delete($nr);
		
		/*! \brief Legt  Mitglied an
		 *
		 *  F�gt neues Mitglied mit Benutzernamen ($loginname), Passwort
		 *  ($passwort), Benutzerrechten ($rechte), Vorname ($vorname),
		 *  Nachname ($nachname), E-Mail-Adresse ($email) in Mitglieder
		 *  ein. Dazu wird das Passwort noch mit Mitglied::PasswordHash
		 *  gehasht. Sollte ein Mitglied mit gleichem Login existieren
		 *  wird ein Fehler zur�ckgegeben, da die Datenbank nur ein
		 *  Mitglied mit gleichem Login erlaubt.
		 *  \pre Datenbankverbindung muss bestehen
		 *  \param[in] $loginname Benutzername des neuen Mitglieds
		 *  \param[in] $passwort Benutzerpasswort des neuen Mitglieds
		 *  \param[in] $rechte Rechte des neuen Mitglieds
		 *     (Benutzer, Administrator)
		 *  \param[in] $vorname Vorname des neuen Mitglieds
		 *  \param[in] $nachname Nachname des neuen Mitglieds
		 *  \param[in] $email E-Mail-Adresse des neuen Mitglieds
		 *  \retval true Mitglied wurde eingef�gt
		 *  \retval false Mitglied konnte nicht hinzugef�gt werden
		 *  \remarks Ist der Nutzer nicht als Administrator angemeldet,
		 *    werden keine Operationen ausgef�hrt.
		 */
		function Insert($loginname, $passwort, $rechte, $vorname, $nachname, $email);
		
		/*! \brief �ndert ein Mitglied
		 *
		 *  �ndert die Daten des Mitglieds mit der Mitglieds_Nr ($nr),
		 *  in neuen Benutzernamen ($loginname), Passwort ($passwort),
		 *  Benutzerrechten ($rechte), Vorname ($vorname),
		 *  Nachname ($nachname), E-Mail-Adresse ($email) in
		 *  Mitglieder. Wenn $passwort nicht die L�nge 0 hat, wird es 
		 *  noch mit Mitglied::PasswortHash gehasht. Andernfalls wird
		 *  das alte Passwort in Mitglieder beibehalten. Sollte ein
		 *  Mitglied mit gleichem Login existieren wird ein Fehler
		 *  zur�ckgegeben, da die Datenbank nur ein Mitglied mit
		 *  gleichem Login erlaubt.
		 *  \pre Datenbankverbindung muss bestehen
		 *  \pre Mitglied in Mitglieder mit Mitglieds_Nr $nr muss
		 *    existieren
		 *  \param[in] $nr Mitglieds_Nr des zu ver�ndernden Mitglieds
		 *  \param[in] $loginname neuer Benutzername des Mitglieds
		 *  \param[in] $passwort neues Passwort des Mitglieds
		 *  \param[in] $rechte neuen Rechte des Mitglieds
		 *    (Benutzer, Administrator)
		 *  \param[in] $vorname neuer Vorname des Mitglieds
		 *  \param[in] $nachname neuer Nachname des Mitglieds
		 *  \param[in] $email neue E-Mail-Adresse des Mitglieds
		 *  \retval true Mitglied wurde ge�ndert
		 *  \retval false Mitglied konnte nicht ge�ndert werden
		 *  \remarks Ist der Nutzer nicht als Administrator angemeldet,
		 *    werden keine Operationen ausgef�hrt, wenn $nr ungleich
		 *    der eigenen Mitglieds_Nr is.
		 */
		function Update($nr, $loginname, $passwort, $rechte, $vorname, $nachname, $email);
		
		/*! \brief R�ckgabe einer Liste der Mitglieder
		 *
		 *  Liest alle Mitglieder mit Nr, Login, Vorname, Nachname und
		 *  Email aus Tabelle Mitglieder und gibt die ausgelesenen
		 *  Objekte in einem Feld zur�ck
		 *  \pre Datenbankverbindung muss bestehen
		 *  \return Feld mit Objekten der Form
		 *    - Nr
		 *    - Login
		 *    - Vorname
		 *    - Nachname
		 *    - Email
		 *  \remarks Ist der Nutzer nicht als Administrator, sondern
		 *    als Mitglied angemeldet, wird nur der eigene Eintrag
		 *    zur�ckgegeben. Ist der Nutzer nicht angemeldet werden
		 *    keine Operationen ausgef�hrt.
		 */
		function GetAll();
	}
?>
