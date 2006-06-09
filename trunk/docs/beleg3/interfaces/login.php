<?php
	require_once("include/mitglied.php");

	/*! \brief Verwaltet Logininformationen
	 *
	 *  Verwaltet die aus der sich aktuellen Anmeldung ergebenen Session
	 *  des Users und der damit entstehenden Rechte
	 *  \pre Das Loginobjekt muss vor einer Übertragung von Inhaltsdaten zum 
	 *    User angelegt werden, um ein Cookie anlegen zu können.
	 *  \pre Es sollte kein zweites Objekt vom Typ Login existieren.
	 *  \pre Datenbankverbindung muss bestehen.
	 *  \remarks Sollte ein weiteres Objekt vom Typ Login existieren, in
	 *    welche neue Logininformationen eingetragen werden, wird keine
	 *    weitere Session angelegt, sondern die alten Informationen in
	 *    der aktuellen Session überschrieben.
	 *  \sa
	 *  - Mitglied::PasswordHash
	 *  - SQLDB::Query
	 *  - SQLDB::Fetch
	 *
	 *  \author Frank Wilhelm
	 *  \date 30.05.2006
	 */
	class Login
	{
		var $Nr = 0; ///< Mitglieds_Nr für angemeldetes Mitglied (sonst 0)
		
		/*! \brief Liest bzw. Erstellt Session für Anmeldedaten
		 *
		 *  Liest Daten aus der Session ein. Sollten keine vorhanden
		 *  sein, dann wird eine neue, leere Session angelegt. Sollten
		 *  Daten vorhanden sein, wird die Korrektheit über die
		 *  Datenbank (Mitglieder) und die Verbindungsinformationen
		 *  geprüft. Nach dieser Prüfung werden abhängig vom Ausgang
		 *  die Rechteinformationen gesetzt.\n
		 *  Werden keine Parameter übergeben, wird das Klartextpasswort
		 *  mit Mitglied::PasswordHash gehasht, um diese mit
		 *  Benutzernamen ($benutzer) gegen die Einträge in Mitglieder
		 *  zu prüfen. Ist diese erfolgreich, wird eine neue Session
		 *  mit gehashtem Passwort, Benutzernamen und
		 *  Verbindungsinformationen erstellt. Sollte ein Fehler 
		 *  bei der Anmeldung auftreten, erhält er Nutzerrechte
		 *  (wird also nicht zum Mitglied). Sonst erhält er die Rechte
		 *  und Mitglieds_Nr aus dem gefundenem Eintrag in Mitglieder.
		 *  \param[in] $benutzer neuer Benutzername
		 *  \param[in] $passwort Passwort in Klartext des Nutzers
		 *  \pre Eine Verbindung zur Datenbank muss bestehen.
		 *  \pre Der Konstruktor muss vor dem Senden von Inhaltsdaten
		 *    aufgerufen werden, um ein Cookie erstellen zu können.
		 *  \pre Zum Einloggen mit Daten darf kein Parameter leer sein
		 */
		function Login($benutzer = "", $passwort = "");

		/*! \brief Entfernt Session
		 *
		 *  Die Anmeldedaten und Verbindungsdaten werden in der
		 *  Session entfernt. Außerdem werden die Rechte auf Nutzer (0)
		 *  und Nr auf 0 gesetzt.
		 *  \pre -
		 */
		function Logout();

		/*! \brief Ermittelt ob Administratorrechte vorliegen
		 *
		 *  Vergleicht ob die bei der Erstellung des Loginobjekts
		 *  ermittelten Rechte mindestens den Wert für
		 *  Administratorrechte (>=2) haben.
		 *  \pre -
		 *  \retval true wenn Administratorrechte vorliegen
		 *  \retval false wenn Nutzer- oder Mitgliedsrechte vorliegen
		 */
		function IsAdministrator();

		/*! \brief Ermittelt ob mindestens Mitgliedsrechte vorliegen
		 *
		 *  Vergleicht ob die bei der Erstellung des Loginobjekts
		 *  ermittelten Rechte mindestens den Wert für
		 *  Mitgliedsrechte (>=1) haben.
		 *  \pre -
		 *  \retval true wenn mindestens Mitgliedsrechte vorliegen
		 *  \retval false wenn Nutzerrechte vorliegen
		 */
		function IsMember();
	}

	// Globales Loginobjekt erstellen
	$login = new Login();
?>
