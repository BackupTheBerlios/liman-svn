<?php
	// Wähle Datenbanksystem aus
	switch ($db_config['dbms'])
	{
		default:
		case "mysql":
			require_once("include/sqldb_mysql.php");
			break;
	}
	
	// Verbinde mit Datenbank
	$sqldb = new SQLDB($db_config["host"], $db_config["user"], $db_config["pass"], $db_config["name"]);
	
	// Gib Fehler aus und breche ab, wenn keine Verbindung zum SQL-Server besteht
	if ($sqldb->db_id === false)
		die(mysql_error().". Could not connect to SQL server. Please inform Webmaster");;
?>
