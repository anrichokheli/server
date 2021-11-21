<?php
if(!isset($_GET["n"]) || !isset($_GET["location"]) || !isset($_GET["accuracy"]) || !isset($_GET["key"]))    {
    exit("EXIT");
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
$n = mysqli_real_escape_string($dbc, $_GET['n']);
$location = mysqli_real_escape_string($dbc, $_GET['location']);
$accuracy = mysqli_real_escape_string($dbc, $_GET['accuracy']);
if(isset($_GET["address"]))	{
	$address = mysqli_real_escape_string($dbc, $_GET["address"]);
}
else	{
	$address = "";
}
$query = "SELECT * FROM violations WHERE n LIKE '$n'";
if(mysqli_query($dbc, $query))    {
    $row = mysqli_fetch_array(mysqli_query($dbc, $query));
    if(empty($row["location"]) && empty($row["accuracy"]) && empty($row["location_time"]))    {
        if($_GET["key"] === $row["upload_key"])    {
            $time = time();
            $query = "UPDATE violations SET location='$location', accuracy='$accuracy', address='$address', location_time='$time' WHERE n=$n";
            if(mysqli_query($dbc, $query)){
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
mysqli_close($dbc);
?>