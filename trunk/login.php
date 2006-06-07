<?php
	$title = "Login";
	//$extracss = "home.css";

	
	require_once("include/global.php");

	if (empty($_POST["loginname"]) === false && empty($_POST["passwort"]) === false)
	{
		$login = new Login($_POST["loginname"], $_POST["passwort"]);
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
		if (isset($_GET["logout"]) === true)
		{
			echo "Auf Wiedersehen";
		}
		elseif ($login->IsMember() === true)
		{
			require_once("include/mitglied.php");
			$mitglied = new Mitglied($login->Nr);
			echo "Willkommen ".$mitglied->Vorname." ".$mitglied->Nachname;
		}
		else
		{
			echo "<div id=\"error\">Login ist Fehlgeschlagen</div>";
		}
	?>
	</div>
</div>
<?php	require_once("include/footer.php"); ?>
