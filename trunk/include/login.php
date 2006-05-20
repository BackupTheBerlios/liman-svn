<?php
if(!defined("Login"))
{
	define("Login", 1);

	/*! \brief Verwaltet Logininformationen
	 *
	 *  Verwaltet die aus der sich aktuellen Anmeldung ergebenen Session
	 *  des Users und der damit entstehenen Rechte
	 *  \pre Das Loginobjekt muss vor einer Übertragung von Inhaltsdaten zum 
	 *    User angelegt werden, um ein Cookie anlegen zu können. Es sollte
	 *    kein zweites Objekt vom Typ Login existieren.
	 *  \remarks Sollte ein weiteres Objekt vom Typ Login existieren in
	 *    welche neue Logininformationen eingetragen werden, wird keine
	 *    weitere Session angelegt, sondern die alten Informationen in
	 *    der aktuellen Session überschrieben.
	 */
	class Login
	{
		/*! Level des aktuellen Nutzers
		 *   - >=1 Mitglied
		 *   - >=2 Administrator
		 *   - >=0 Nutzer
		 *  \private
		 */
		var $level = 0; 
		
		/*! \brief Liest Session für Anmeldedaten ein
		 *
		 *  Liest Daten aus der Session ein. Sollten keine vorhanden
		 *  sein, dann wird eine neue, leere Session angelegt. Sollten
		 *  Daten vorhanden sein, wird die Korrektheit über die
		 *  Datenbank (Mitglieder) und die Verbindungsinformationen
		 *  geprüft. Nach dieser Prüfung werden abhängig vom Ausgang
		 *  die Rechteinformationen gesetzt
		 *  \pre Eine Verbindung zur Datenbank muss bestehen.
		 *    Der Konstruktor muss vor dem Senden von Inhaltsdaten
		 *    aufgerufen werden, um ein Cookie erstellen zu können.
		 */
		function Login()
		{
		}

		/*! \brief Ändert Session mit neuen Anmeldedaten
		 *
		 *  Das Klartextpasswort wird mit Mitglied::PasswordHash
		 *  gehashtd um danach mit Benutzernamen ($benutzer) gegen die
		 *  Einträge in Mitglieder zu prüfen. Ist diese erfolgreich,
		 *  wird eine neue Session mit gehashtem Passwort, Benuternamen
		 *  und Verbindungsinformationen erstellt. Sollte irgendwo ein
		 *  Fehler bei der Anmeldung auftreten, erhält er Nutzerrechte
		 *  (wird also nicht zum Mitglied). Sonst erhält er die Rechte
		 *  aus dem gefundenem Eintrag in Mitglieder.
		 *  \pre Eine Verbindung zur Datenbank muss bestehen.
		 *    Der Konstruktor muss vor dem Senden von Inhaltsdaten
		 *    aufgerufen werden, um ein Cookie erstellen zu können.
		 *  \param[in] $benutzer neuer Benutzername
		 *  \param[in] $passwort Passwort in Klartext des Nutzers
		 */
		function Login($benutzer, $passwort)
		{
		}

		/*! \brief Entfernt Session
		 *
		 *  Die Anmeldedaten und Verbindungsdaten werden in der
		 *  Session entfernt. Außerdem werden die Rechte auf Gast (0)
		 *  gesetzt.
		 *  \pre -
		 */
		function Logout()
		{
		}

		/*! \brief Ermittelt ob Administratorrechte vorliegen
		 *
		 *  Vergleicht ob die bei der Erstellung des Loginobjekts
		 *  ermittelten Rechte mindestens den Wert für
		 *  Administratorrechte (>=2) haben
		 *  \pre -
		 *  \retval true wenn Administratorrechte vorliegen
		 *  \retval false wenn Nutzer- oder Mitgliedsrechte vorliegen
		 */
		function IsAdministrator()
		{
		}

		/*! \brief Ermittelt ob mindestens Mitgliedsrechte vorliegen
		 *
		 *  Vergleicht ob die bei der Erstellung des Loginobjekts
		 *  ermittelten Rechte mindestens den Wert für
		 *  Mitgliedsrechte (>=1) haben
		 *  \pre -
		 *  \retval true wenn mindestens Mitgliedsrechte vorliegen
		 *  \retval false wenn Nutzerrechte vorliegen
		 */
		function IsMember()
		{
		}
	}
}
?>
