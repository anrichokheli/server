<?php
if(!isset($_POST["n"]) || (!isset($_POST["situation"]) && !isset($_POST["description"])) || !isset($_POST["key"]))    {
    exit("EXIT");
}
if(!defined("protectedPrivatePath"))	{
	define("protectedPrivatePath", dirname(getcwd()) . "/protected/private/");
}
require protectedPrivatePath . "check_n_input.php";
$n = htmlspecialchars($_POST['n']);
if(isset($_POST["situation"]))	{
	$situation = htmlspecialchars($_POST['situation']);
}
else	{
	$situation = '';
}
if(isset($_POST["description"]))	{
	$description = nl2br(htmlspecialchars($_POST['description']));
}
else	{
	$description = '';
}
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
$query = "SELECT * FROM violations WHERE n LIKE '$n'";
if(mysqli_query($dbc, $query))    {
    $row = mysqli_fetch_array(mysqli_query($dbc, $query));
    if(empty($row["situation"]) && empty($row["description"]) && empty($row["info_time"]))    {
        if($_POST["key"] === $row["upload_key"])    {
            $time = time();
			file_put_contents(protectedPrivatePath . "data/infos/" . $n, serialize(array($time, $situation, $description)));
			//$situation = mysqli_real_escape_string($dbc, $situation);
			//$description = mysqli_real_escape_string($dbc, $description);
			$stmt = mysqli_prepare($dbc, "UPDATE violations SET situation=?, description=?, info_time=? WHERE n=?");
			mysqli_stmt_bind_param($stmt, "ssii", $situation, $description, $time, $n);
            //$query = "UPDATE violations SET situation='$situation', description='$description', info_time='$time' WHERE n='$n'";
            if(/*mysqli_query($dbc, $query)*/mysqli_stmt_execute($stmt)){
                echo "1";
            } else{
                echo "0" . mysqli_error($dbc);
            }
        }
        else    {
            echo "-1";
        }
    }
    else    {
        echo "-2";
    }
}
else    {
    echo "-3";
}
mysqli_stmt_close($stmt);
mysqli_close($dbc);
?>