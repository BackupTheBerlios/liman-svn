<?php
	$title = "Login";
	//$extracss = "home.css";

	
	require_once("include/global.php");

	if (!empty($_POST["login"]) && !empty($_POST["password"]))
	{
		$login = new Login($_POST["login"], $_POST["password"]);
	}
	elseif (isset($_GET["logout"]))
	{
		$login->Logout();
	}

	require_once("include/header.php");
?>
<div id="clogin" class="content">
</div>
<?php	require_once("include/footer.php"); ?>
