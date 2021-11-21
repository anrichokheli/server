<?php
if(!isset($_GET['account_name']) || !isset($_GET['password']))	{
	exit("-2");
}
$_GET['text'] = $_GET['account_name'];
$returnMode = 1;
include 'check_account_name.php';
if(!$notexists)	{
	exit("-3");
}
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
$account_name = mysqli_real_escape_string($dbc, $_GET['account_name']);
$password = mysqli_real_escape_string($dbc, $_GET['password']);
if(!empty(str_replace(" ", "", $account_name)) && !empty($password))	{
$name = "";
$image = "";
if(isset($_GET['name']) && !empty($_GET['name']))	{
	$name = mysqli_real_escape_string($dbc, $_GET['name']);
}
if(isset($_GET['image']) && !empty($_GET['image']))	{
	$image = mysqli_real_escape_string($dbc, $_GET['image']);
	if(!in_array(pathinfo($image)["filename"] . "." . pathinfo($image)["extension"], scandir("users_images")))	{
		$image = "";
	}
}
$time = time();
$password = password_hash($password, PASSWORD_DEFAULT);
$query = "INSERT INTO users (account_name, password, name, image, time_created) VALUES ('$account_name', '$password', '$name', '$image', '$time')";
if(mysqli_query($dbc, $query)){
echo "1";
} else{
echo "0a" . mysqli_error($dbc);
}
}
else	{
	echo "-1a";
}
mysqli_close($dbc);
?>