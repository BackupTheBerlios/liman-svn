<?php
	error_reporting(E_ALL);

	// Datenbankeinstellungen
	$db_config['dbms'] = "mysql";	// welche Datenbankklasse benutzen?
	$db_config['user'] = "liman";
	$db_config['pass'] = "drownamil";
	$db_config['name'] = "liman";
	$db_config['host'] = "db.berlios.de";
	$db_config['prefix'] = "liman_";

	$ext = "php";	// Endung der von den Usern abrufbaren Dateien
	$gz_enable = true; // aktiviere GZIP-Kompression der HTML-Dateien
?>
