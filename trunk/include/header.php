<?php
	ob_start('ob_gzhandler'); 
	header("Content-Language: de");

	header("Content-type: text/html; charset=UTF-8");
	
	if (empty($basepath))
                $basepath = "./";
	elseif (isset($_GET["basepath"]) || isset($_POST["basepath"]))
		die("Don't send basepath with request");

	require($basepath."include/global.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<title><?=empty($title)?"":$title." :: "; ?>LiMan</title>
		<link rel="SHORTCUT ICON" href="favicon.ico">
		<style type="text/css" title="LiMan 1.0" media="screen,projection">
			@import "<?=$basepath;?>design/liman.css";
			<?=empty($extracss)?"":"@import \"$basepath/design/".$extracss."\";\n"; ?>
		</style>
		<?=empty($extrahead)?"":$extrahead."\n"; ?>
		<meta name="description" content="Literature Manager">
		<meta name="keywords" content="bibtex, books, literature, database, manager">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="robots" content="follow">
		<meta http-equiv="content-language" content="de">
		<meta name="author" content="Simon Wunderlich">
		<link rel="home" title="Home" href="<?=$basepath."index.".$ext;?>">
	</head>
	<body id="liman">
		<div id="container">
			<div id="header">
				<h1><span><acronym title="Literature Manager">LiMan</acronym></span></h1>
			</div>
			
			<div id="sidebar">
				<div id="navigation">
					<h2><span>Navigation</span></h2>
					<ul>
						<li id="nhome"><a href="index.<?=$ext;?>" accesskey="h">Home</a></li>
						<li id="nadd"><a href="add.<?=$ext;?>" accesskey="a">Hinzufügen</a></li>
						<li id="nsearch"><a href="search.<?=$ext;?>" accesskey="s">Suchen</a></li>
					</ul>
				</div>

				<div id="search">
					<h2><span>Suchen</span></h2>
					<form action="search.<?=$ext;?>" id="searchform">
						<div>
						<input name="search" value="" type="text">
						<input value="Suche" type="submit">
						</div>
					</form>
				</div>
			</div>

			<div id="content">
				<h2 <?=empty($title)?"":"id=\"".strtolower($title)."\""; ?>><?=empty($title)?"Inhalt":$title; ?></h2>
