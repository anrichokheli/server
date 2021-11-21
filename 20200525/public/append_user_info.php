<?php
$database = parse_ini_file(dirname(getcwd()) . "/private/database.ini");
define ('dbname', $database["name"]);
$dbc = mysqli_connect($database["host"], $database["username"], $database["password"], dbname);
if(!$dbc) {
	die("DATABASE CONNECTION FAILED:" .mysqli_error($dbc));
	exit();
}
$dbs = mysqli_select_db($dbc, dbname);
if(!$dbs) {
	die("DATABASE SELECTION FAILED:" .mysqli_error($dbc));
	exit();
}
$return_mode = 1;
if(isset($_GET['key']) && !empty($_GET['key']) && isset($_GET['n']) && !empty($_GET['n']) && isset($_GET['name']) && !empty($_GET['name']) && isset($_GET['password']) && !empty($_GET['password']) && (include 'check_account_password.php'))	{
	$n = $_GET['n'];
	$row = mysqli_fetch_array(mysqli_query($dbc, "SELECT * FROM violations WHERE n LIKE '$n'"));
	if($_GET["key"] === $row["upload_key"])	{
		$username = mysqli_real_escape_string($dbc, $_GET['name']);
		$userID = mysqli_fetch_array(mysqli_query($dbc, "SELECT * FROM users WHERE account_name LIKE '$username'"))["id"];
		if($row["user_id"] === '0')	{
			if(mysqli_query($dbc, "UPDATE violations SET user_id='$userID' WHERE n=$n"))	{
				echo "1";
			}
			else	{
				echo "0";
			}
		}
		else	{
			echo "-2";
		}
	}
	else	{
		echo "-3";
	}
}
else	{
	echo "-1";
}
mysqli_close($dbc);
?>