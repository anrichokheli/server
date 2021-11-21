<?php
	$database = parse_ini_file(dirname(getcwd()) . "/protected/private/database.ini");
	$mysqliConnectValue = mysqli_connect($database["host"], $database["username"], $database["password"], $database["name"]);
	mysqli_set_charset($mysqliConnectValue, "utf8mb4");
?>