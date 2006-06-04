<?php
	require_once("include/login.php");
	require_once("include/kommentar.php");

	/*! \brief Verwaltet Mitglieder
	 *
	 *  Stellt Funktionen zum Entfernen, Hinzufügen, Ändern und Auflisten
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
		function Mitglied($nr)
		{
			global $db_config, $sqldb;
			$sql = "SELECT Mitglieds_Nr, Login, Passwort, Rechte, Vorname, Name, Email
					FROM ".$db_config['prefix']."Mitglieder
					WHERE Mitglieds_Nr='$nr'
					LIMIT 1";
			$sqldb->Query($sql);
			
			if ($cur = $sqldb->Fetch())
			{
				$this->Nr = $cur->Mitglieds_Nr;
				$this->Login = $cur->Login;
				$this->Passwort = $cur->Passwort;
				$this->Vorname = $cur->Vorname;
				$this->Nachname = $cur->Name;
				$this->Email = $cur->Email;

				switch ($cur->Rechte)
				{
				case "Administrator":
					$this->Rechte = 2;
					break;
				case "Benutzer":
					$this->Rechte = 1;
					break;
				default:
					$this->Rechte = 0;
				}
			}
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
		 *  \remarks Ist der Nutzer nicht als Administrator angemeldet,
		 *    werden keine Operationen ausgeführt
		 */
		function Delete($nr)
		{
			global $db_config, $sqldb, $login;

			if ($login->IsAdministrator() === true)
			{
				$sql = "DELETE FROM ".$db_config['prefix']."Mitglieder
						WHERE Mitglieds_Nr = '$nr'
						LIMIT 1";
				$sqldb->Query($sql);

				Kommentar::DeleteAllMember($nr);
			}
		}
		
		/*! \brief Legt  Mitglied an
		 *
		 *  Fügt neues Mitglied mit Benutzernamen ($loginname), Passwort
		 *  ($passwort), Benutzerrechten ($rechte), Vorname ($vorname),
		 *  Nachname ($nachname), E-Mail-Adresse ($email) in Mitglieder
		 *  ein. Dazu wird das Passwort noch mit Mitglied::PasswortHash
		 *  gehasht. Sollte ein Mitglied mit gleichem Login existieren
		 *  wird ein Fehler zurückgegeben, da die Datenbank nur ein
		 *  Mitglied mit gleichem Login erlaubt.
		 *  \pre Datenbankverbindung muss bestehen
		 *  \param[in] $loginname Benutzername des neuen Mitglieds
		 *  \param[in] $passwort Benutzerpasswort des neuen Mitglieds
		 *  \param[in] $rechte Rechte des neuen Mitglieds
		 *     (Benutzer, Administrator)
		 *  \param[in] $vorname Vorname des neuen Mitglieds
		 *  \param[in] $nachname Nachname des neuen Mitglieds
		 *  \param[in] $email E-Mail-Adresse des neuen Mitglieds
		 *  \retval true Mitglied wurde eingefügt
		 *  \retval false Mitglied konnte nicht hinzugefügt werden
		 *  \remarks Ist der Nutzer nicht als Administrator angemeldet,
		 *    werden keine Operationen ausgeführt.
		 */
		function Insert($loginname, $passwort, $rechte, $vorname, $nachname, $email)
		{
			global $db_config, $sqldb, $login;

			if ($login->IsAdministrator() === true)
			{
				$passworthash = Mitglied::PasswordHash($passwort);
				$sql = "INSERT INTO ".$db_config['prefix']."Mitglieder
						VALUES (NULL, '$nachname', '$vorname', '$email', '$loginname', '$passworthash', '$rechte')";
				
				if ($sqldb->Query($sql) !== false)
				{
					return true;
				}
				else
				{
					return false;
				}
			}
			else
			{
				return false;
			}
		}
		
		/*! \brief Ändert ein Mitglied
		 *
		 *  Ändert die Daten das Mitglieds mit der Mitglieds_Nr ($nr),
		 *  in neuen Benutzernamen ($loginname), Passwort ($passwort),
		 *  Benutzerrechten ($rechte), Vorname ($vorname),
		 *  Nachname ($nachname), E-Mail-Adresse ($email) in
		 *  Mitglieder. Wenn $passwort nicht die Länge 0 hat, wird es 
		 *  noch mit Mitglied::PasswortHash gehasht. Andernfalls wird
		 *  das alte Passwort in Mitglieder beibehalten. Sollte ein
		 *  Mitglied mit gleichem Login existieren wird ein Fehler
		 *  zurückgegeben, da die Datenbank nur ein Mitglied mit
		 *  gleichem Login erlaubt.
		 *  \pre Datenbankverbindung muss bestehen
		 *  \param[in] $nr Mitglieds_Nr des zu verändernden Mitglieds
		 *  \param[in] $loginname neuer Benutzername des Mitglieds
		 *  \param[in] $passwort neues Passwort des Mitglieds
		 *  \param[in] $rechte neuen Rechte des Mitglieds
		 *    (Benutzer, Administrator)
		 *  \param[in] $vorname neuer Vorname des Mitglieds
		 *  \param[in] $nachname neuer Nachname des Mitglieds
		 *  \param[in] $email neue E-Mail-Adresse des Mitglieds
		 *  \retval true Mitglied wurde geändert
		 *  \retval false Mitglied konnte nicht geändert werden
		 *  \remarks Ist der Nutzer nicht als Administrator angemeldet,
		 *    werden keine Operationen ausgeführt, wenn $nr ungleich
		 *    der eigenen Mitglieds_Nr is.
		 */
		function Update($nr, $loginname, $passwort, $rechte, $vorname, $nachname, $email)
		{
			global $db_config, $sqldb, $login;

			if ($login->IsAdministrator() === true || $nr == $login->Nr)
			{
				if ($login->IsAdministrator() === false)
				{
					$rechte = "Benutzer";
				}

				$sql = "";
				if (empty($passwort) === true)
				{
					
					$sql = "UPDATE ".$db_config['prefix']."Mitglieder
							SET Login='$loginname', Rechte='$rechte', Vorname='$vorname', Name='$nachname', Email='$email'
							WHERE Mitglieds_Nr='$nr'
							LIMIT 1";
				}
				else
				{
					$passworthash = Mitglied::PasswordHash($passwort);
					$sql = "UPDATE ".$db_config['prefix']."Mitglieder
							SET Login='$loginname', Passwort='$passworthash', Rechte='$rechte', Vorname='$vorname', Name='$nachname', Email='$email'
							WHERE Mitglieds_Nr='$nr'
							LIMIT 1";
				}
	
				if ($sqldb->Query($sql) !== false)
				{
					return true;
				}
				else
				{
					return false;
				}
			}
			else
			{
				return false;
			}
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
		 *  \remarks Ist der Nutzer nicht als Administrator, sondern
		 *    als Mitglied angemeldet, wird nur der eigene Eintrag
		 *    zurückgegeben. Ist der Nutzer nicht angemeldet werden
		 *    keine Operationen ausgeführt.
		 */
		function GetAll()
		{
			global $db_config, $sqldb, $login;

			$members = array();

			if ($login->IsAdministrator() === true)
			{
				$sql = "SELECT Mitglieds_Nr AS Nr, Login, Vorname, Name AS Nachname, Email
						FROM ".$db_config['prefix']."Mitglieder";
				$sqldb->Query($sql);
				
				while ($cur = $sqldb->Fetch())
				{
					$members[] = $cur;
				}
			}
			elseif ($login->IsMember() === true)
			{
				$sql = "SELECT Mitglieds_Nr AS Nr, Login, Vorname, Name AS Nachname, Email
						FROM ".$db_config['prefix']."Mitglieder
						WHERE Mitglieds_Nr='".$login->Nr."'
						LIMIT 1";
				$sqldb->Query($sql);
				
				if ($cur = $sqldb->Fetch())
				{
					$members[] = $cur;
				}
			}

			return $members;
		}
	}
?>
