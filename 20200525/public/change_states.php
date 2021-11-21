<?php
if(!isset($_POST["yes"]) || !isset($_POST["no"]))	{
	exit("0");
}
if((strpos($_POST["yes"], "|") === FALSE) && (strpos($_POST["no"], "|") === FALSE))	{
	exit("-1");
}
session_start();
if(isset($_SESSION["qveitisosreactloggedin"]) && $_SESSION["qveitisosreactloggedin"] === true)    {
	$yes = explode("|", $_POST["yes"]);
	$no = explode("|", $_POST["no"]);
	$database = parse_ini_file(dirname(getcwd()) . "/private/database.ini");
	$dbc = mysqli_connect($database["host"], $database["username"], $database["password"], $database["name"]);
	$queries = "";
	$time = time();
	foreach($yes as $n)	{
		if(is_numeric($n))	{
			$queries .= "UPDATE violations SET state='1', state_time='$time' WHERE n=$n;";
		}
	}
	foreach($no as $n)	{
		if(is_numeric($n))	{
			$queries .= "UPDATE violations SET state='-1', state_time='$time' WHERE n=$n;";
		}
	}
	$saved = mysqli_multi_query($dbc, $queries);
	mysqli_close($dbc);
	if($saved)	{
		if(isset($_POST["gettime"]))	{
			date_default_timezone_set("Etc/GMT-4");
			echo "1" . "<br><br>" . date("Y-m-d", $time) . " " . date("H:i:s", $time);
		}
		else	{
			echo "1";
		}
	}
	else	{
		echo "-3";
	}
}
else    {
	session_destroy();
	echo "-2";
}
?>