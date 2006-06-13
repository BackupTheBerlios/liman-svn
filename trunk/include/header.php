<?php 
	header("Content-Language: de");
	header("Content-type: text/html; charset=UTF-8");

	require_once("include/global.php");

	// Aktiviere GZIP-Kompression, wenn gewünscht
	if (isset($gz_enable) === true && $gz_enable === true)
	{
		ob_start('ob_gzhandler');
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<title><?=empty($title)?"":$title." :: "; ?>LiMan</title>
		<link rel="SHORTCUT ICON" href="favicon.ico">
		<style type="text/css" title="LiMan 1.0" media="screen,projection">
			@import "design/liman.css";
			<?=empty($extracss)?"":"@import \"design/".$extracss."\";\n"; ?>
		</style>
		<?=empty($extrahead)?"":$extrahead."\n"; ?>
		<meta name="description" content="Literature Manager">
		<meta name="keywords" content="bibtex, books, literature, database, manager">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="robots" content="follow">
		<meta http-equiv="content-language" content="de">
		<meta name="author" content="Simon Wunderlich">
		<link rel="home" title="Home" href="index.<?=$ext;?>">
	</head>
	<body id="liman">
		<?php
			// Gebe Warnung aus, wenn install.php nicht gelöscht wurde und es nicht unterdrückt wird
			if (file_exists("install.php") === true && 
				((empty($disable_installwarning) === false && $disable_installwarning === false)
				|| empty($disable_installwarning) === true))
			{
				echo "<div id=\"installerror\">
					install.php wurde nicht gelöscht. Erledigen sie dies so schnell wie möglich
					</div>";
			}
		?>
		<div id="container">
			<div id="header">
				<h1><span><acronym title="Literature Manager">LiMan</acronym></span></h1>
			</div>
			
			<div id="sidebar">
				<div id="navigation">
					<h2><span>Navigation</span></h2>
					<ul>
						<li id="nhome"><a href="index.<?=$ext;?>" accesskey="h">Literatur</a></li>
						<li id="nuser"><a href="userlist.<?=$ext;?>" accesskey="n">Nutzer</a></li>
					</ul>
				</div>

				<div id="search">
					<h2><span>Suchen</span></h2>
					<form action="search.<?=$ext;?>" id="searchform" method="get">
						<div>
						<input name="suchbegriff" value="" type="text">
						<input value="Suche" type="submit">
						<span style="font-size: xx-small"><a href="searchmore.php">Erweiterte Suche</a></span>
						</div>
					</form>
				</div>

				<div id="loginbox">
					<h2><span>Einloggen</span></h2>
					<?php
						if ($login->IsMember() === false)
						{
						?>
							<form action="login.<?=$ext;?>" id="loginform" method="post">
							<div>
							<label for="loginname">Login:</label>
							<input id="loginname" name="loginname" value="" type="text">
							<label for="passwort">Passwort:</label>
							<input id="passwort" name="passwort" type="password">
							<input type="submit" value="Login">
							</div>
							</form>
						<?php
						}
						else
						{
						?>
							<form action="login.<?=$ext;?>?logout" id="loginform" method="post">
							<div><input type="submit" value="Logout">
							</div>
							</form>
						<?php
						}
					?>
				</div>
			</div>

			<div id="content">
				<h2 <?=empty($title)?"":"id=\"".makeid($title)."\""; ?>><?=empty($title)?"Inhalt":$title; ?></h2>
