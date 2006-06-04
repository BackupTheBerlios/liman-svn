<?php
	$title = "Login";
	//$extracss = "home.css";

	
	require_once("include/global.php");

	if (empty($_POST["benutzername"]) === false && empty($_POST["password"]) === false)
	{
		$login = new Login($_POST["benutzername"], $_POST["password"]);
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
