<?php
	$title = "Login";
	
	require_once("include/global.php");

	// Suche gewählte Aktion
	if (empty($_POST["loginname"]) === false && empty($_POST["passwort"]) === false)
	{
		// Fehlerhafte Daten zum Löschen übertragen?
		if (empty($_POST["loginname"]) === true || empty($_POST["passwort"]) === true)
		{
			// Wenn ja, gebe Fehler aus
			echo "<p id=\"error\">Sie konnte nicht angemeldet werden, da es ein Fehler bei der Übertragung der Informationen des Logins gab</p>";
		}
		else
		{
			// Logge Mitglied mit übergebenen Parametern ein
			$login = new Login($_POST["loginname"], $_POST["passwort"]);
		}
	}
	elseif (isset($_GET["logout"]) === true)
	{
		$login->Logout();
	}

	require_once("include/header.php");
?>
<div id="clogin" class="content">
	<div style="text-align: center">
	<?php
		// Gebe je nach Aktion Statusinformation aus
		if (isset($_GET["logout"]) === true)
		{
			// Verabschiede Nutzer beim Abmelden
			echo "Auf Wiedersehen";
		}
		elseif ($login->IsMember() === true)
		{
			// Begrüße Nutzer beim Anmelden
			require_once("include/mitglied.php");
			$mitglied = new Mitglied($login->Nr);
			echo "Willkommen ".$mitglied->Vorname." ".$mitglied->Nachname;
		}
		else
		{
			// Sonst gebe Fehlermeldung beim Anmelden aus
			echo "<div id=\"error\">Login ist Fehlgeschlagen</div>";
		}
	?>
	</div>
</div>
<?php	require_once("include/footer.php"); ?>
