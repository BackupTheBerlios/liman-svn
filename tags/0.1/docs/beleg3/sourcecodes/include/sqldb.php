<?php
	// Wähle Datenbanksystem aus
	switch ($db_config['dbms'])
	{
		default:
		case "mysql":
			if (function_exists("mysql_connect") === true
			    && function_exists("mysql_connect") === true)
			{
				require_once("include/sqldb_mysql.php");
			}
			else
			{
				die("Es liegt ein Problem mit der PHP-MySQL-Einbindung vor. Bitte vergewissern sie sich, dass alle nötigen PHP-Module vorhanden sind.");
			}
			break;
	}
	
	// Verbinde mit Datenbank
	$sqldb = new SQLDB($db_config["host"], $db_config["user"], $db_config["pass"], $db_config["name"]);
	
	// Gib Fehler aus und breche ab, wenn keine Verbindung zum SQL-Server besteht
	if ($sqldb->db_id === false)
	{
		$error = $sqldb->GetError();
		die("Could not connect to SQL server. Please inform Webmaster:\n ".$error['msg']);
	}
?>
