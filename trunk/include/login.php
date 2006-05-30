<?php
	require_once("include/mitglied.php");

	/*! \brief Verwaltet Logininformationen
	 *
	 *  Verwaltet die aus der sich aktuellen Anmeldung ergebenen Session
	 *  des Users und der damit entstehenden Rechte
	 *  \pre Das Loginobjekt muss vor einer Übertragung von Inhaltsdaten zum 
	 *    User angelegt werden, um ein Cookie anlegen zu können. Es sollte
	 *    kein zweites Objekt vom Typ Login existieren.
	 *    Datenbankverbindung muss bestehen.
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
		/*! Level des aktuellen Nutzers
		 *   - >=1 Mitglied
		 *   - >=2 Administrator
		 *   - >=0 Nutzer
		 *  \private
		 */
		var $Level = 0;
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
		 *  mit gehashtem Passwort, Benuternamen und
		 *  Verbindungsinformationen erstellt. Sollte irgendwo ein
		 *  Fehler bei der Anmeldung auftreten, erhält er Nutzerrechte
		 *  (wird also nicht zum Mitglied). Sonst erhält er die Rechte
		 *  und Mitglieds_Nr aus dem gefundenem Eintrag in Mitglieder.
		 *  \param[in] $benutzer neuer Benutzername
		 *  \param[in] $passwort Passwort in Klartext des Nutzers
		 *  \pre Eine Verbindung zur Datenbank muss bestehen.
		 *    Der Konstruktor muss vor dem Senden von Inhaltsdaten
		 *    aufgerufen werden, um ein Cookie erstellen zu können.\n
		 *    Zum Einloggen mit Daten darf kein Parameter leer sein
		 */
		function Login($benutzer = "", $passwort = "")
		{
			global $db_config, $sqldb;

			@session_start();

			$this->Level = 0;
			$this->Nr = 0;

			// Neue Session starten?
			if (empty($benutzer) === false && empty($passwort) === false)
			{
				session_register("benutzer");
				session_register("passwort");
				session_register("ip");

				$_SESSION["benutzer"] = $benutzer;
				$_SESSION["passwort"] = Mitglied::PasswordHash($passwort);
				$_SESSION["ip"] = $_SERVER['REMOTE_ADDR'];
				
			}

			// Korrekt eingeloggt?
			if (isset($_SESSION["ip"]) && $_SESSION["ip"] == $_SERVER['REMOTE_ADDR'] &&
				!empty($_SESSION["benutzer"]) && !empty($_SESSION["passwort"]))
			{
				// Hole, Nr, Passwort und Rechte zu Loginnamen
				$sql = "SELECT Mitglieds_Nr AS Nr, Passwort AS passwort, Rechte
					FROM ".$db_config['prefix']."Mitglieder AS members
					WHERE members.Login = '".$_SESSION["benutzer"]."'
					LIMIT 1";
			
				$sqldb->Query($sql);
				if ($line = $sqldb->Fetch())
				{
					if ($line->passwort === $_SESSION["passwort"])
					{
						$this->Nr = $line->Nr;
						switch ($line->Rechte)
						{
						case "Administrator":
							$this->Level = 2;
							break;
						case "Benutzer":
							$this->Level = 1;
							break;
						default:
							$this->Level = 0;
						}
					}
					else
					{
						// Falsche Passwort
						$this->Logout();
					}
				}
				else
				{
					// Benutzername nicht gefunden
					$this->Logout();
				}
			}
		}

		/*! \brief Entfernt Session
		 *
		 *  Die Anmeldedaten und Verbindungsdaten werden in der
		 *  Session entfernt. Außerdem werden die Rechte auf Nutzer (0)
		 *  und Nr auf 0 gesetzt.
		 *  \pre -
		 */
		function Logout()
		{
			session_unset();
			session_destroy();
			$this->Level = 0;
			$this->Nr = 0;
		}

		/*! \brief Ermittelt ob Administratorrechte vorliegen
		 *
		 *  Vergleicht ob die bei der Erstellung des Loginobjekts
		 *  ermittelten Rechte mindestens den Wert für
		 *  Administratorrechte (>=2) haben.
		 *  \pre -
		 *  \retval true wenn Administratorrechte vorliegen
		 *  \retval false wenn Nutzer- oder Mitgliedsrechte vorliegen
		 */
		function IsAdministrator()
		{
			if ($this->Level >= 2)
			{
				return true;
			}
			else
			{
				return false;
			}
		}

		/*! \brief Ermittelt ob mindestens Mitgliedsrechte vorliegen
		 *
		 *  Vergleicht ob die bei der Erstellung des Loginobjekts
		 *  ermittelten Rechte mindestens den Wert für
		 *  Mitgliedsrechte (>=1) haben.
		 *  \pre -
		 *  \retval true wenn mindestens Mitgliedsrechte vorliegen
		 *  \retval false wenn Nutzerrechte vorliegen
		 */
		function IsMember()
		{
			if ($this->Level >= 1)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
	}

	// Globales Loginobjekt erstellen
	$login = new Login();
?>
