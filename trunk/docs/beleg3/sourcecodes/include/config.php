<?php
	error_reporting(E_ALL);

	// Datenbankeinstellungen
	$db_config['dbms'] = "mysql";	// welche Datenbankklasse benutzen?
	$db_config['user'] = ""; // Nutzername des Datenbanknutzers
	$db_config['pass'] = ""; // Passwort für Datenbanknutzer
	$db_config['name'] = ""; // Name der Datenbank
	$db_config['host'] = ""; // Adresse des Datenbankservers
	$db_config['prefix'] = "liman_"; // Prefix der Tabellennamen

	$ext = "php";	// Endung der von den Usern abrufbaren Dateien
	$gz_enable = true; // aktiviere GZIP-Kompression der HTML-Dateien
?>
