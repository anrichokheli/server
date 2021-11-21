<?php
require dirname(getcwd()) . "/protected/private/check_n_input.php";
include dirname(getcwd()) . "/protected/private/mysqli_database.php";
$dbc = $mysqliConnectValue;
if(!$dbc) {
	die("DATABASE CONNECTION FAILED:" .mysqli_error($dbc));
	exit();
}
$dbs = mysqli_select_db($dbc, $database["name"]);
if(!$dbs) {
	die("DATABASE SELECTION FAILED:" .mysqli_error($dbc));
	exit();
}
$return_mode = 1;
if(isset($_POST['key']) && !empty($_POST['key']) && isset($_POST['n']) && !empty($_POST['n']) && isset($_POST['name']) && !empty($_POST['name']) && isset($_POST['password']) && !empty($_POST['password']) && (require 'check_account_password.php'))	{
	$n = $_POST['n'];
	$row = mysqli_fetch_array(mysqli_query($dbc, "SELECT * FROM violations WHERE n LIKE '$n'"));
	if($_POST["key"] === $row["upload_key"])	{
		$username = mysqli_real_escape_string($dbc, $_POST['name']);
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