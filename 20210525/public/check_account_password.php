<?php
if(!isset($database))	{
	$DBcloseEnable = 1;
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
}
$password = mysqli_real_escape_string($dbc, $_POST['password']);
$name = mysqli_real_escape_string($dbc, htmlspecialchars($_POST['name']));
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