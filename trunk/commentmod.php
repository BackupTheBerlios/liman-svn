<?php
	if (isset($_GET["delete"]) === true)
	{
		$title = "Kommentar löschen";
	}
	elseif (isset($_GET["id"]) === true || isset($_POST["id"]) === true)
	{
		$title = "Kommentar ändern";
	}
	else
	{
		$title = "Kommentar hinzufügen";
	}
	//$extracss = "home.css";

	require_once("include/header.php");

	if ($login->IsMember() === false)
	{
		echo "<div id=\"error\">Sie sind für diese Aktion nicht berechtigt</div>";
		require_once("include/footer.php");
		die();
	}
	elseif ($login->IsAdministrator() === false)
	{
		$_GET["userid"] = $login->Nr;
		$_POST["userid"] = $login->Nr;
	}
?>
<div id="cfront" class="content">
<?php
	require_once("include/kommentar.php");
	require_once("include/form_helper.php");
	if (isset($_GET["delete"]) === true)
	{
		if (isset($_POST["accept"]) === true)
		{
			Kommentar::Delete($_POST["id"]);
			echo "<p style=\"text-align: center\">Kommentar wurde entfernt</p>";

			if (empty($_POST["litid"]) === false)
			{
				echo form_back("lit.$ext", $_POST["litid"]);
			}
		}
		else
		{
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

			echo "<input type=\"submit\" value=\"Bestätigen\">";
			echo "</form></div>";
		}
	}
	elseif  (isset($_GET["insert"]) === true)
	{
		Kommentar::Insert($_POST["text"], $_POST["userid"], $_POST["litid"]);
		echo "<p style=\"text-align: center\">Kommentar wurde angelegt</p>";

		if (empty($_POST["litid"]) === false)
		{
			echo form_back("lit.$ext", $_POST["litid"]);
		}
	}
	elseif (isset($_GET["update"]) === true)
	{
		Kommentar::Update($_POST["id"], $_POST["text"]);
		echo "<p style=\"text-align: center\">Kommentar wurde geändert</p>";

		if (empty($_POST["litid"]) === false)
		{
			echo form_back("lit.$ext", $_POST["litid"]);
		}
	}
?>
</div>
<?php	require_once("include/footer.php"); ?>
