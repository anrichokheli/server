<?php
if(!isset($database))	{
	$DBcloseEnable = 1;
	$database = parse_ini_file(dirname(getcwd()) . "/private/database.ini");
	define ('dbuser', $database["username"]);
	define ('dbpw', $database["password"]);
	define ('dbhost', $database["host"]);
	define ('dbname', $database["name"]);
	$dbc = mysqli_connect(dbhost, dbuser, dbpw, dbname);
	if(!$dbc) {
	    die("DATABASE CONNECTION FAILED:" .mysqli_error($dbc));
	    exit();
	}
	$dbs = mysqli_select_db($dbc, dbname);
	if(!$dbs) {
	    die("DATABASE SELECTION FAILED:" .mysqli_error($dbc));
	    exit();
	}
}
$password = mysqli_real_escape_string($dbc, $_GET['password']);
$name = mysqli_real_escape_string($dbc, $_GET['name']);
$query = "SELECT * FROM users WHERE account_name LIKE '$name'";
$result = 0;
if(mysqli_query($dbc, $query))    {
    $row = mysqli_fetch_array(mysqli_query($dbc, $query));
    if(password_verify($password, $row["password"]))    {
        $result = 1;
    }
}
if(isset($DBcloseEnable) && ($DBcloseEnable === 1))	{
	mysqli_close($dbc);
}
if(isset($return_mode) && ($return_mode === 1))    {
    return $result;
}
else    {
    echo $result;
}
?>