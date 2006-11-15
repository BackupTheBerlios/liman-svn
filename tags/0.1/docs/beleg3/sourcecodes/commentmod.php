<?php
	// W�hle Seitentitel nach ausgew�hlter Aktion
	if (isset($_GET["delete"]) === true)
	{
		$title = "Kommentar l�schen";
	}
	elseif (isset($_GET["id"]) === true || isset($_POST["id"]) === true)
	{
		$title = "Kommentar �ndern";
	}
	else
	{
		$title = "Kommentar hinzuf�gen";
	}

	require_once("include/header.php");

	// Abbruch wenn keine Mitgliedsrechte vorhanden
	if ($login->IsMember() === false)
	{
		echo "<div id=\"error\">Sie sind f�r diese Aktion nicht berechtigt</div>";
		require_once("include/footer.php");
		die();
	}
	elseif ($login->IsAdministrator() === false)
	{
		// Wenn keine Administratorrechte vorhanden sind
		// d�rfen nur die eigenen Daten ge�ndert werden
		$_GET["userid"] = $login->Nr;
		$_POST["userid"] = $login->Nr;
	}
?>
<div id="cfront" class="content">
<?php
	require_once("include/kommentar.php");
	require_once("include/form_helper.php");

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
				echo "<p id=\"error\">Kommentar konnte nicht gel�scht werden, da es ein Fehler bei der �bertragung der Informationen des Kommentars gab</p>";
			}
			else
			{
				// Wenn nicht, l�sche Kommentar und gebe Erfolgsmeldung aus
				Kommentar::Delete($_POST["id"]);
				echo "<p style=\"text-align: center\">Kommentar wurde entfernt</p>";
			}

			// Wurde eine Literaturnummer �bergeben, gebe Zur�ckbutton aus
			if (empty($_POST["litid"]) === false)
			{
				echo form_back("lit.$ext", $_POST["litid"]);
			}
		}
		else
		{
			// Frage ob Kommentar gel�scht werden soll
			require_once("include/form_helper.php");
			echo "<div id=\"warning\" style=\"margin-top: 2em\">";
			echo "Wollen sie den Kommentar wirklich entfernen?";
			echo "<form action=\"commentmod.".$ext."?delete\" id=\"commentupdateform\" method=\"post\">";
			echo form_input("hidden", "id", $_GET["id"]);
			echo form_input("hidden", "accept", "true");
			if (empty($_GET["litid"]) === false)
			{
				echo form_input("hidden", "litid", $_GET["litid"]);
			}

			echo "<input type=\"submit\" value=\"Best�tigen\">";
			echo "</form></div>";
		}
	}
	elseif  (isset($_GET["insert"]) === true)
	{
		// Fehlerhafte Daten zum Anlegen �bertragen?
		if (isset($_POST["text"]) === false ||
			empty($_POST["userid"]) === true || is_numeric($_POST["userid"]) === false ||
			empty($_POST["litid"]) === true || is_numeric($_POST["litid"]) === false)
		{
			// Wenn ja, gebe Fehler aus
			echo "<p id=\"error\">Kommentar konnte nicht angelegt werden, da es ein Fehler bei der �bertragung der Informationen des Kommentars gab</p>";
		}
		else
		{
			// Wenn nicht, lege Kommentar an und gebe Erfolgsmeldung aus
			Kommentar::Insert($_POST["text"], $_POST["userid"], $_POST["litid"]);
			echo "<p style=\"text-align: center\">Kommentar wurde angelegt</p>";
		}

		// Wurde eine Literaturnummer �bergeben, gebe Zur�ckbutton aus
		if (empty($_POST["litid"]) === false)
		{
			echo form_back("lit.$ext", $_POST["litid"]);
		}
	}
	elseif (isset($_GET["update"]) === true)
	{
		// Fehlerhafte Daten zum �ndern �bertragen?
		if (isset($_POST["text"]) === false ||
			empty($_POST["id"]) === true || is_numeric($_POST["id"]) === false)
		{
			// Wenn ja, gebe Fehler aus
			echo "<p id=\"error\">Kommentar konnte nicht ge�ndert werden, da es ein Fehler bei der �bertragung der Informationen des Kommentars gab</p>";
		}
		else
		{
			// Wenn nicht, �ndere Kommentar und gebe Erfolgsmeldung aus
			Kommentar::Update($_POST["id"], $_POST["text"]);
			echo "<p style=\"text-align: center\">Kommentar wurde ge�ndert</p>";
		}

		// Wurde eine Literaturnummer �bergeben, gebe Zur�ckbutton aus
		if (empty($_POST["litid"]) === false)
		{
			echo form_back("lit.$ext", $_POST["litid"]);
		}
	}
?>
</div>
<?php	require_once("include/footer.php"); ?>
