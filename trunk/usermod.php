<?php
	if (isset($_GET["delete"]) === true)
	{
		$title = "Nutzer löschen";
	}
	elseif (isset($_GET["id"]) === true || isset($_POST["id"]) === true)
	{
		$title = "Nutzer ändern";
	}
	else
	{
		$title = "Nutzer hinzufügen";
	}
	//$extracss = "home.css";

	require_once("include/header.php");

	if ($login->IsMember() === false
		|| ($login->IsAdministrator() === false
			&& (isset($_GET["delete"]) === true || isset($_GET["insert"]) === true)
		))
	{
		echo "<div id=\"error\">Sie sind für diese Aktion nicht berechtigt</div>";
		require_once("include/footer.php");
		die();
	}
	elseif ($login->IsAdministrator() === false)
	{
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

		if (empty($_POST["password"]) === true && isset($_GET["insert"]) === true)
		{
			$error_password = true;
			$error_password_missing = true;
			$error_occurred = true;
		}

		if (empty($_POST["password"]) === false || empty($_POST["password_check"]) === false)
		{
			if ($_POST["password"] != $_POST["password_check"])
			{
				$error_password = true;
				$error_password_different = true;
				$error_occurred = true;
			}
		}
	}

	if ($error_occurred == true)
	{
		echo "<div id=\"error_list\">Es scheinen Fehler bei der Verarbeitung aufgetreten zu sein:<ul>";
		
		if ($error_benutzername === true)
		{
			echo "<li>Sie müssen ein Login angeben</li>";
		}
		
		if ($error_vorname === true)
		{
			echo "<li>Sie müssen einen Vornamen angeben</li>";
		}
		
		if ($error_nachname === true)
		{
			echo "<li>Sie müssen ein Nachnamen angeben</li>";
		}
		
		if ($error_email === true)
		{
			echo "<li>E-Mail scheint nicht korrekt zu sein</li>";
		}
		
		if ($error_password_missing === true)
		{
			echo "<li>Sie müssen ein Passwort angeben</li>";
		}
		elseif ($error_password_different === true)
		{
			echo "<li>Passwörter stimmen nicht überein</li>";
		}

		echo "</ul></div>";
	}


	if ((isset($_GET["delete"]) === false && isset($_GET["insert"]) === false && isset($_GET["update"]) === false)
		|| $error_occurred === true)
	{
		require_once("include/form_helper.php");
		if (isset($_GET["id"]) === true || isset($_POST["id"]) === true)
		{
			require_once("include/mitglied.php");

			if (isset($_POST["id"]) === true)
			{
				$id = $_POST["id"];
			}
			else
			{
				$id = $_GET["id"];
			}

			$mitglied = new Mitglied($_GET["id"]);
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
			if (isset($_POST["benutzername"]) === true)
			{
				$benutzername = stripslashes($_POST["benutzername"]);
			}
			else
			{
				$benutzername = "";
			}

			if (isset($_POST["rechte"]) === true)
			{
				$rechte = stripslashes($_POST["rechte"]);
			}
			else
			{
				$rechte = "Benutzer";
			}

			if (isset($_POST["vorname"]) === true)
			{
				$vorname = stripslashes($_POST["vorname"]);
			}
			else
			{
				$vorname = "";
			}

			if (isset($_POST["nachname"]) === true)
			{
				$nachname = stripslashes($_POST["nachname"]);
			}
			else
			{
				$nachname = "";
			}

			if (isset($_POST["email"]) === true)
			{
				$email = stripslashes($_POST["email"]);
			}
			else
			{
				$email = "";
			}

			$passwort = "";
		}

	if (empty($id) === true)
	{
		echo "<form action=\"usermod.".$ext."?insert\" id=\"useraddform\" method=\"post\">";
	}
	else
	{
		echo "<form action=\"usermod.".$ext."?update\" id=\"userupdateform\" method=\"post\">";
		echo form_input("hidden", "id", $id);
	}
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
		require_once("include/mitglied.php");
		if (isset($_GET["delete"]) === true)
		{
			if (isset($_POST["accept"]) === true)
			{
				Mitglied::Delete($_POST["id"]);
				echo "<p style=\"text-align: center\">Nutzer wurde entfernt</p>";
			}
			else
			{
				require_once("include/form_helper.php");
				echo "<div id=\"warning\" style=\"margin-top: 2em\">";
				echo "Wollen sie den Nutzer wirklich entfernen?";
				echo "<form action=\"usermod.".$ext."?delete\" id=\"userupdateform\" method=\"post\">";
				echo form_input("hidden", "id", $_GET["id"]);
				echo form_input("hidden", "accept", "true");
				echo "<input type=\"submit\" value=\"Bestätigen\">";
				echo "</form></div>";
			}
		}
		elseif  (isset($_GET["insert"]) === true)
		{
			if (Mitglied::Insert($_POST["benutzername"], $_POST["password"], $_POST["rechte"], $_POST["vorname"], $_POST["nachname"], $_POST["email"]) === true)
			{
				echo "<p style=\"text-align: center\">Nutzer wurde angelegt</p>";
			}
			else
			{
				
				echo "<p id=\"warning\">Nutzer konnte nicht angelegt werden. Ist Login vielleicht schon vergeben?</p>";
			}
		}
		elseif (isset($_GET["update"]) === true)
		{
			if (Mitglied::Update($_POST["id"], $_POST["benutzername"], $_POST["password"], $_POST["rechte"], $_POST["vorname"], $_POST["nachname"], $_POST["email"]) === true)
			{
				echo "<p style=\"text-align: center\">Nutzer wurde geändert</p>";
			}
			else
			{
				echo "<p id=\"warning\">Nutzer konnte nicht geändert werden. Ist Login vielleicht schon vergeben?</p>";
			}
		}
	}
?>
</div>
<?php	require_once("include/footer.php"); ?>
