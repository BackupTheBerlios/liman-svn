<?php
	switch ($db_config['dbms'])
	{
		default:
		case "mysql":
			require_once($basepath."include/sqldb_mysql.php");
			break;
	}
	
	$sqldb = new SQLDB($db_config["host"], $db_config["user"], $db_config["pass"], $db_config["name"]);
	
	if ($sqldb->db_id === false)
		die(mysql_error().". Could not connect to SQL server. Please inform Webmaster");;
?>
