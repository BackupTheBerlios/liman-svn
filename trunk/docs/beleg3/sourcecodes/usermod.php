<?php
	// W�hle Seitentitel nach ausgew�hlter Aktion
	if (isset($_GET["delete"]) === true)
	{
		$title = "Nutzer l�schen";
	}
	elseif (isset($_GET["id"]) === true || isset($_POST["id"]) === true)
	{
		$title = "Nutzer �ndern";
	}
	else
	{
		$title = "Nutzer hinzuf�gen";
	}

	require_once("include/header.php");

	// Abbruch wenn keine Mitgliedsrechte vorhanden
	// oder gel�scht und hinzugef�gt werden soll und keine Administratorrechte vorliegen
	if ($login->IsMember() === false
		|| ($login->IsAdministrator() === false
			&& (isset($_GET["delete"]) === true || isset($_GET["insert"]) === true)
		))
	{
		echo "<div id=\"error\">Sie sind f�r diese Aktion nicht berechtigt</div>";
		require_once("include/footer.php");
		die();
	}
	elseif ($login->IsAdministrator() === false)
	{
		// Wenn keine Administratorrechte vorhanden sind
		// d�rfen nur die eigenen Daten ge�ndert werden
		$_GET["id"] = $login->Nr;
		$_POST["id"] = $login->Nr;
	}
?>
<div id="cfront" class="content">
<?php
	$error_occurred = false; // Fehler beim Verarbeiten aufgetreten?
	$error_benutzername = false;
	$error_vorname = false;
	$error_nachname = false;
	$error_email = false;
	$error_password = false;
	$error_password_missing = false;
	$error_password_different = false;

	// �berpr�fe wichtige Parameter bei Insert und Update auf Vorhandensein
	if (isset($_GET["insert"]) === true || isset($_GET["update"]) === true)
	{
		if (empty($_POST["benutzername"]) === true)
		{
			$error_benutzername = true;
			$error_occurred = true;
		}

		if (empty($_POST["vorname"]) === true)
		{
			$error_vorname = true;
			$error_occurred = true;
		}

		if (empty($_POST["nachname"]) === true)
		{
			$error_nachname = true;
			$error_occurred = true;
		}
		
		if (empty($_POST["email"]) === true)
		{
			$error_email = true;
			$error_occurred = true;
		}

		// Teste ob Passwort beim hinzuf�gen vergessen wurde
		if (empty($_POST["password"]) === true && isset($_GET["insert"]) === true)
		{
			$error_password = true;
			$error_password_missing = true;
			$error_occurred = true;
		}

		if (empty($_POST["password"]) === false || empty($_POST["password_check"]) === false)
		{
			// Teste ob Passw�rter unterschiedlich sind
			if ($_POST["password"] != $_POST["password_check"])
			{
				$error_password = true;
				$error_password_different = true;
				$error_occurred = true;
			}
		}
	}

	// Gebe Fehler bei Parameter�berpr�fung aus
	if ($error_occurred == true)
	{
		echo "<div id=\"error_list\">Es scheinen Fehler bei der Verarbeitung aufgetreten zu sein:<ul>";
		
		if ($error_benutzername === true)
		{
			echo "<li>Sie m�ssen ein Login angeben</li>";
		}
		
		if ($error_vorname === true)
		{
			echo "<li>Sie m�ssen einen Vornamen angeben</li>";
		}
		
		if ($error_nachname === true)
		{
			echo "<li>Sie m�ssen ein Nachnamen angeben</li>";
		}
		
		if ($error_email === true)
		{
			echo "<li>E-Mail scheint nicht korrekt zu sein</li>";
		}
		
		if ($error_password_missing === true)
		{
			echo "<li>Sie m�ssen ein Passwort angeben</li>";
		}
		elseif ($error_password_different === true)
		{
			echo "<li>Passw�rter stimmen nicht �berein</li>";
		}

		echo "</ul></div>";
	}


	// Gebe Formular aus, wenn keine Schreibaktionen ausgef�hrt werden
	if ((isset($_GET["delete"]) === false && isset($_GET["insert"]) === false && isset($_GET["update"]) === false)
		|| $error_occurred === true)
	{
		// Lese id aus, wenn vorhanden
		if (isset($_POST["id"]) === true)
		{
			$id = $_POST["id"];
		}
		elseif (isset($_GET["id"]) === true)
		{
			$id = $_GET["id"];
		}
		else
		{
			unset($id);
		}

		require_once("include/form_helper.php");
		// Lese Mitglied aus, wenn id bekannt ist und vorher kein Fehler aufgetreten ist
		if ($error_occurred === false && (isset($_GET["id"]) === true || isset($_POST["id"]) === true))
		{
			require_once("include/mitglied.php");
			$mitglied = new Mitglied($id);
			$benutzername = $mitglied->Login;

			if (isset($mitglied->Rechte) === true)
			{
				switch ($mitglied->Rechte)
				{
				case 2:
					$rechte = "Administrator";
					break;
				default:
				case 1:
					$rechte = "Benutzer";
					break;
				}
			}
			else
			{
				$rechte = "Benutzer";
			}

			$vorname = $mitglied->Vorname;
			$nachname = $mitglied->Nachname;
			$email = $mitglied->Email;
		}
		else
		{
			// Sollte vorher Fehler aufgetreten sein, lese Parameter aus.
			// Sollten vorher keine Fehler aufgetreten sein (keine
			// id bekannt), setze Default Wert

			// Setze Login
			if (isset($_POST["benutzername"]) === true)
			{
				$benutzername = stripslashes($_POST["benutzername"]);
			}
			else
			{
				$benutzername = "";
			}

			// Setze Rechte
			if (isset($_POST["rechte"]) === true)
			{
				$rechte = stripslashes($_POST["rechte"]);
			}
			else
			{
				$rechte = "Benutzer";
			}

			// Setze Vorname
			if (isset($_POST["vorname"]) === true)
			{
				$vorname = stripslashes($_POST["vorname"]);
			}
			else
			{
				$vorname = "";
			}

			// Setze Nachname
			if (isset($_POST["nachname"]) === true)
			{
				$nachname = stripslashes($_POST["nachname"]);
			}
			else
			{
				$nachname = "";
			}

			// Setze Email
			if (isset($_POST["email"]) === true)
			{
				$email = stripslashes($_POST["email"]);
			}
			else
			{
				$email = "";
			}

			// �bernehme nie das Passwort
			$passwort = "";
		}

	if (empty($id) === true)
	{
		// Gebe Hinzuf�gen-Formular aus
			echo "<form action=\"usermod.".$ext."?insert\" id=\"useraddform\" method=\"post\">";
	}
	else
	{
		// Gebe Update-Formular aus
		echo "<form action=\"usermod.".$ext."?update\" id=\"userupdateform\" method=\"post\">";
		echo form_input("hidden", "id", $id);
	}

	// Gebe Formular mit vorher bestimmten Werten aus
?>
	<table id="bookdetails">
		<tbody>
			<tr>
				<th scope="row">Login:</th>	
				<td><?=form_input("text", "benutzername", $benutzername, $error_benutzername);?></td>
			</tr>
			<tr>
				<th scope="row">Vorname:</th>	
				<td><?=form_input("text", "vorname", $vorname, $error_vorname);?></td>
			</tr>
			<tr>
				<th scope="row">Nachname:</th>	
				<td><?=form_input("text", "nachname", $nachname, $error_nachname);?></td>
			</tr>
			<tr>
				<th scope="row">E-Mail:</th>	
				<td><?=form_input("text", "email", $email, $error_email);?></td>
			</tr>
			<tr>
				<th scope="row" name="rechte" id="rechte">Rechte:</th>	
				<td><?=form_select(array("Administrator", "Benutzer"),
					"rechte", $rechte);?>
				</td>
			</tr>

			<tr>
				<th scope="row">Passwort:</th>	
				<td><?=form_input("password", "password", "", $error_password);?></td>
			</tr>
			<tr>
				<th scope="row">Passwort (wiederholen):</th>	
				<td><?=form_input("password", "password_check", "", $error_password);?></td>
			</tr>

			<tr>
				<th scope="row">Aktionen:</th>	
				<td>
				<input type="submit" value="&Uuml;bernehmen">
				</td>
			</tr>

		</tbody>
	</table>
	</form>
<?php
	}
	else
	{
		// F�hre Schreibaktionen aus
		
		require_once("include/mitglied.php");
		
		// Suche gew�hlte Aktion
		if (isset($_GET["delete"]) === true)
		{
			// L�schen wenn akzeptiert wurde
			if (isset($_POST["accept"]) === true)
			{
				// Fehlerhafte Daten zum L�schen �bertragen?
				if (empty($_POST["id"]) === true || is_numeric($_POST["id"]) === false)
				{
					// Wenn ja, gebe Fehler aus
					echo "<p id=\"error\">Nutzer konnte nicht gel�scht werden, da es ein Fehler bei der �bertragung der Informationen des Nutzers gab</p>";
				}
				else
				{
					// Wenn nicht, l�sche Mitglied und gebe Erfolgsmeldung aus
					Mitglied::Delete($_POST["id"]);
					echo "<p style=\"text-align: center\">Nutzer wurde entfernt</p>";
				}
			}
			else
			{
				// Frage ob Mitglied gel�scht werden soll
				require_once("include/form_helper.php");
				echo "<div id=\"warning\" style=\"margin-top: 2em\">";
				echo "Wollen sie den Nutzer wirklich entfernen?";
				echo "<form action=\"usermod.".$ext."?delete\" id=\"userupdateform\" method=\"post\">";
				echo form_input("hidden", "id", $_GET["id"]);
				echo form_input("hidden", "accept", "true");
				echo "<input type=\"submit\" value=\"Best�tigen\">";
				echo "</form></div>";
			}
		}
		elseif  (isset($_GET["insert"]) === true)
		{
			// Versuche Benutzer anzulegen
			if (Mitglied::Insert($_POST["benutzername"], $_POST["password"], $_POST["rechte"], $_POST["vorname"], $_POST["nachname"], $_POST["email"]) === true)
			{
				// Wenn ok, gebe Erfolgsmeldung aus
				echo "<p style=\"text-align: center\">Nutzer wurde angelegt</p>";
			}
			else
			{
				// Wenn nicht, gebe Fehler aus
				echo "<p id=\"warning\">Nutzer konnte nicht angelegt werden. Ist Login vielleicht schon vergeben?</p>";
			}
		}
		elseif (isset($_GET["update"]) === true)
		{
			// Fehlerhafte Daten zum �ndern �bertragen?
			if (empty($_POST["id"]) === true || is_numeric($_POST["id"]) === false)
			{
				// Wenn ja, gebe Fehler aus
				echo "<p id=\"error\">Nutzer konnte nicht ge�ndert werden, da es ein Fehler bei der �bertragung der Informationen des Nutzers gab</p>";
			}
			elseif (Mitglied::Update($_POST["id"], $_POST["benutzername"], $_POST["password"], $_POST["rechte"], $_POST["vorname"], $_POST["nachname"], $_POST["email"]) === true)
			{
				// Wenn ok, gebe Erfolgsmeldung aus
				echo "<p style=\"text-align: center\">Nutzer wurde ge�ndert</p>";
			}
			else
			{
				// Wenn nicht, gebe Fehler aus
				echo "<p id=\"warning\">Nutzer konnte nicht ge�ndert werden. Ist Login vielleicht schon vergeben?</p>";
			}
		}
	}
?>
</div>
<?php	require_once("include/footer.php"); ?>
