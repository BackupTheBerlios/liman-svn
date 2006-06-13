<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<title>Install :: LiMan</title>
		<link rel="SHORTCUT ICON" href="favicon.ico">
		<meta name="description" content="Literature Manager">
		<meta name="keywords" content="bibtex, books, literature, database, manager">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="robots" content="follow">
		<meta http-equiv="content-language" content="de">
		<meta name="author" content="Simon Wunderlich">
		<link rel="home" title="Home" href="index.php">
		<style type="text/css">
			th {
				width: 10em;
				text-align: left;
			}
			td {
				width: 20em;
			}

			.input_text, .input_password {
				width: 20em;
			}
		</style>
	</head>
	<body id="liman_install">
		<h1>LiMan Installation</h1>
<?php
	// Lese übergebene Variablen aus bzw. setzte Standardwerte
	if (empty($_POST["dbms"]) === false)
	{
		$db_config['dbms'] = "mysql";

		if ($_POST["dbms"] === "MySQL5")
		{
			$enableUTF8 = true;
		}
		else
		{
			$enableUTF8 = false;
		}
	}
	else
	{
		$db_config['dbms'] = "mysql";
	}

	if (empty($_POST["user"]) === false)
	{
		$db_config['user'] = $_POST["user"];
	}
	else
	{
		$db_config['user'] = "";
	}

	if (empty($_POST["pass"]) === false)
	{
		$db_config['pass'] = $_POST["pass"];
	}
	else
	{
		$db_config['pass'] = "";
	}

	if (empty($_POST["name"]) === false)
	{
		$db_config['name'] = $_POST["name"];
	}
	else
	{
		$db_config['name'] = "";
	}

	if (empty($_POST["host"]) === false)
	{
		$db_config['host'] = $_POST["host"];
	}
	else
	{
		$db_config['host'] = "";
	}

	if (empty($_POST["prefix"]) === false)
	{
		$db_config['prefix'] = $_POST["prefix"];
	}
	elseif (isset($_GET["install"]) === true)
	{
		$db_config['prefix'] = "";
	}
	else
	{
		$db_config['prefix'] = "liman_";
	}

	if (empty($_POST["loginname"]) === false)
	{
		$loginname = $_POST["loginname"];
	}
	elseif (isset($_GET["install"]) === true)
	{
		die("Sie müssen ein Loginname angeben");
		echo "</body></html>";
	}
	else
	{
		$loginname = "admin";
	}

	if (empty($_POST["passwort"]) === false)
	{
		$passworthash = sha1($_POST["passwort"]);
	}
	elseif (isset($_GET["install"]) === true)
	{
		$passworthash = "";
		die("Sie müssen ein Passwort angeben");
		echo "</body></html>";
	}
	else
	{
		$passworthash = "";
	}

	
	// Soll Tabellen Datenbank erstellt werden?
	if (isset($_GET["install"]) === true)
	{
		// Wenn ja, verbinde mit Datenbank
		require_once("include/sqldb.php");

		// Erstelle SQL-Befehle zum Löschen alter Tabellen
		$sqlDrop["Autoren"] = "DROP TABLE IF EXISTS `".$db_config['prefix']."Autoren`";
		$sqlDrop["Bibliothek"] = "DROP TABLE IF EXISTS `".$db_config['prefix']."Bibliothek`";
		$sqlDrop["Kommentare"] = "DROP TABLE IF EXISTS `".$db_config['prefix']."Kommentare`";
		$sqlDrop["Literatur_Autor"] = "DROP TABLE IF EXISTS `".$db_config['prefix']."Literatur_Autor`";
		$sqlDrop["Mitglieder"] = "DROP TABLE IF EXISTS `".$db_config['prefix']."Mitglieder`";

		// Erstelle SQL-Befehle zum Erstellen neuer Tabellen
		$sqlCreate["Autoren"] = "CREATE TABLE `".$db_config['prefix']."Autoren` (
			`Autor_Nr` int(11) NOT NULL auto_increment,
			`Autorname` varchar(40) NOT NULL,
			PRIMARY KEY  (`Autor_Nr`),
			UNIQUE KEY `Autorname` (`Autorname`),
			FULLTEXT KEY `Autorname_2` (`Autorname`)
			)";
		$sqlCreate["Bibliothek"] = "CREATE TABLE `".$db_config['prefix']."Bibliothek` (
			`Literatur_Nr` int(11) NOT NULL auto_increment,
			`Art` enum('Buch', 'Artikel', 'Broschüre', 'Protokoll', 'Anleitung', 'Diplomarbeit', 'Dissertation', 'Techn. Bericht', 'Unveröffentlicht', 'Sonstiges') NOT NULL,
			`Titel` varchar(40) NOT NULL,
			`Jahr` int(11) NOT NULL,
			`Verlag` varchar(40) NOT NULL,
			`ISBN` varchar(20) NOT NULL,
			`Beschreibung` text NOT NULL,
			`Ort` varchar(40) NOT NULL,
			`Stichworte` varchar(100) NOT NULL,
			PRIMARY KEY  (`Literatur_Nr`),
			FULLTEXT KEY `Titel` (`Titel`,`Verlag`,`ISBN`,`Beschreibung`,`Ort`,`Stichworte`)
			)";
		$sqlCreate["Kommentare"] = "CREATE TABLE `".$db_config['prefix']."Kommentare` (
			`Kommentar_Nr` int(11) NOT NULL auto_increment,
			`Kommentartext` text NOT NULL,
			`Literatur_Nr` int(11) NOT NULL,
			`Mitglieds_Nr` int(11) NOT NULL,
			PRIMARY KEY  (`Kommentar_Nr`),
			KEY `Literatur_Nr` (`Literatur_Nr`,`Mitglieds_Nr`),
			FULLTEXT KEY `Kommentartext` (`Kommentartext`)
			)";
		$sqlCreate["Literatur_Autor"] = "CREATE TABLE `".$db_config['prefix']."Literatur_Autor` (
			`Autor_Nr` int(11) NOT NULL,
			`Literatur_Nr` int(11) NOT NULL,
			KEY `Autor_Nr` (`Autor_Nr`,`Literatur_Nr`)
			)";
		$sqlCreate["Mitglieder"] = "CREATE TABLE `".$db_config['prefix']."Mitglieder` (
			`Mitglieds_Nr` int(11) NOT NULL auto_increment,
			`Name` varchar(20) NOT NULL,
			`Vorname` varchar(20) NOT NULL,
			`Email` text NOT NULL,
			`Login` varchar(12) NOT NULL,
			`Passwort` varchar(40) NOT NULL,
			`Rechte` enum('Benutzer','Administrator') NOT NULL,
			PRIMARY KEY  (`Mitglieds_Nr`),
			UNIQUE KEY `Login` (`Login`)
			)";
	
		// Sollen Tabellen mit Standardzeichenkodierung UTF-8 erstellt werden?
		if ($enableUTF8 === true)
		{
			$sqlCreate["Autoren"] .= " DEFAULT CHARSET=utf8";
			$sqlCreate["Bibliothek"] .= " DEFAULT CHARSET=utf8";
			$sqlCreate["Kommentare"] .= " DEFAULT CHARSET=utf8";
			$sqlCreate["Literatur_Autor"] .= " DEFAULT CHARSET=utf8";
			$sqlCreate["Mitglieder"] .= " DEFAULT CHARSET=utf8";
		}
	
		// Erstelle SQL-Befehle zum Anlegen des ersten Nuters an
		$sqlInsertMitglied = "INSERT INTO ".$db_config['prefix']."Mitglieder
				VALUES (NULL, 'Istrator', 'Admin', 'foo@bar.de', '$loginname', '$passworthash', 'Administrator')";
	
		// Lösche alte Tabellen in Datenbank
		foreach ($sqlDrop as $drop)
		{
			if ($sqldb->Query($drop) === false)
			{
				echo "<div class=\"error\">Es trat ein Fehler bei dem Löschen alter Tabellen auf:<pre>";
				$error = $sqldb->GetError();
				echo htmlspecialchars($error[0])."<br>";
				echo "SQL-Befehl: <br>".htmlspecialchars($drop);
				echo "</pre></div>";
				echo "</body></html>";
				die();
			}
		}
	
		// Erstelle neue Tabellen
		foreach ($sqlCreate as $create)
		{
			if ($sqldb->Query($create) === false)
			{
				echo "<div class=\"error\">Es trat ein Fehler bei dem Erstellen neuer Tabellen auf:<pre>";
				$error = $sqldb->GetError();
				echo htmlspecialchars($error[0])."<br>";
				echo "SQL-Befehl: <br>".htmlspecialchars($create);
				echo "</pre></div>";
				echo "</body></html>";
				die();
			}
		}
	
		// Einfügen erstes Mitglied (Administrator)
		if ($sqldb->Query($sqlInsertMitglied) === false)
		{
			echo "<div class=\"error\">Es trat ein Fehler bei dem Einfügen des ersten Mitglieds auf:<pre>";
			$error = $sqldb->GetError();
			echo htmlspecialchars($error[0])."<br>";
			echo "SQL-Befehl: <br>".htmlspecialchars($sqlInsertMitglied);
			echo "</pre></div>";
			echo "</body></html>";
			die();
		}

		?>
			<p>Datenbank wurde erfolgreich eingerichtet.</p>
			<p>Erstellen sie in ihrem Installationsordner unter "include" eine Datei mit dem Namen "config.php" und folgendem Inhalt:
			<pre>
&lt;?php
	// Datenbankeinstellungen
	$db_config['dbms'] = "<?=htmlspecialchars($db_config['dbms']);?>";
	$db_config['user'] = "<?=htmlspecialchars($db_config['user']);?>";
	$db_config['pass'] = "<?=htmlspecialchars($db_config['pass']);?>";
	$db_config['name'] = "<?=htmlspecialchars($db_config['name']);?>";
	$db_config['host'] = "<?=htmlspecialchars($db_config['host']);?>";
	$db_config['prefix'] = "<?=htmlspecialchars($db_config['prefix']);?>";

	$ext = "php";	// Endung der von den Usern abrufbaren Dateien
	$gz_enable = false; // aktiviere GZIP-Kompression der HTML-Dateien
?&gt;
			</pre></p>
		<?php
	}
	else
	{
		require_once("include/form_helper.php");
		?>
		<form id="installform" action="install.php?install=" method="post">
		
		<h2>Datenbankeinstellungen</h2>
		<table>
		<tbody>
			<tr>
			<th scope="row"><label for="dbms">Datenbanksystem</label></th>
			<td><?= form_select(array("MySQL3", "MySQL4", "MySQL5"), "dbms", "MySQL5"); ?></td>
			</tr>

			<tr>
			<th scope="row"><label for="user">Benutzername</label></th>
			<td><?= form_input("text", "user", $db_config["user"]); ?></td>
			</tr>

			<tr>
			<th scope="row"><label for="pass">Passwort</label></th>
			<td><?= form_input("password", "pass"); ?></td>
			</tr>

			<tr>
			<th scope="row"><label for="host">Host</label></th>
			<td><?= form_input("text", "host", $db_config["host"]); ?></td>
			</tr>

			<tr>
			<th scope="row"><label for="name">Datenbankname</label></th>
			<td><?= form_input("text", "name", $db_config["name"]); ?></td>
			</tr>

			<tr>
			<th scope="row"><label for="prefix">Prefix</label></th>
			<td><?= form_input("text", "prefix", $db_config["prefix"]); ?></td>
			</tr>
		</tbody>
		</table>


		<h2>Administratoreinstellungen</h2>
		<table>
		<tbody>
			<tr>
			<th scope="row"><label for="loginname">Loginname</label></th>
			<td><?= form_input("text", "loginname", $db_config["loginname"]); ?></td>
			</tr>

			<tr>
			<th scope="row"><label for="passwort">Passwort</label></th>
			<td><?= form_input("password", "passwort", $db_config["passwort"]); ?></td>
			</tr>
		</tbody>
		</table>

		<div><input type="submit" value="&Uuml;bernehmen"></div>
		</form>
		<?php
	}
	
?>
</body></html>