<?php
if(!isset($_POST["n"]) || !isset($_POST["key"]))    {
    exit("-4");
}
if(!defined("protectedPrivatePath"))	{
	define("protectedPrivatePath", dirname(getcwd()) . "/protected/private/");
}
require protectedPrivatePath . "check_n_input.php";
include protectedPrivatePath . "mysqli_database.php";
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
$n = mysqli_real_escape_string($dbc, $_POST['n']);
if(isset($_POST["latitude"]) && is_numeric($_POST['latitude']))	{
	$latitude = $_POST['latitude'];
}
else	{
	$latitude = 0;
}
if(isset($_POST["longitude"]) && is_numeric($_POST['longitude']))	{
	$longitude = $_POST['longitude'];
}
else	{
	$longitude = 0;
}
if(isset($_POST["accuracy"]) && is_numeric($_POST['accuracy']))	{
	$accuracy = $_POST['accuracy'];
}
else	{
	$accuracy = 0.0;
}
if(isset($_POST['altitude']) && is_numeric($_POST['altitude']))	{
	$altitude = $_POST['altitude'];
}
else	{
	$altitude = 0;
}
if(isset($_POST["address"]))	{
	$address = htmlspecialchars($_POST["address"]);
}
else	{
	$address = "";
}
$query = "SELECT * FROM violations WHERE n LIKE '$n'";
if(mysqli_query($dbc, $query))    {
    $row = mysqli_fetch_array(mysqli_query($dbc, $query));
    if($row["location_time"] == 0)    {
        if($_POST["key"] === $row["upload_key"])    {
            $time = time();
			file_put_contents(protectedPrivatePath . "data/locations/" . $n, serialize(array($time, $latitude, $longitude, $altitude, $accuracy, $address)));
			//$address = mysqli_real_escape_string($dbc, $address);
			$stmt = mysqli_prepare($dbc, "UPDATE violations SET latitude=?, longitude=?, altitude=?, accuracy=?, address=?, location_time=? WHERE n=?");
			mysqli_stmt_bind_param($stmt, "ddddsii", $latitude, $longitude, $altitude, $accuracy, $address, $time, $n);
            //$query = "UPDATE violations SET latitude='$latitude', longitude='$longitude', altitude='$altitude', accuracy='$accuracy', address='$address', location_time='$time' WHERE n='$n'";
            if(/*mysqli_query($dbc, $query)*/mysqli_stmt_execute($stmt)){
                echo "1";
            } else{
                echo "-1" . mysqli_error($dbc);
            }
        }
        else    {
            echo "-3";
        }
    }
    else    {
        echo "-2";
    }
}
else    {
    echo "0";
}
mysqli_stmt_close($stmt);
mysqli_close($dbc);
?>