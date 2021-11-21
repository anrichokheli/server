<?php
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
$n = mysqli_real_escape_string($dbc, $_GET['n']);
if(!empty($n))  {
    $IDs = explode("|", $n);
    $reactEcho = "";
for($i = 0; $i < count($IDs); $i++)   {
$query = "SELECT * FROM violations WHERE n = " . str_replace("c", "", $IDs[$i]);
$row = mysqli_fetch_array(mysqli_query($dbc, $query));
if(mysqli_query($dbc, $query))	{
    if((!empty($row["react"]) && !empty($row["react_media"])) || (empty($row["link"])) || (($row["state"] != 0) && (strpos($IDs[$i], "c") === FALSE)))    {
        $reactEcho .= str_replace("c", "", $IDs[$i]);
        if(!empty($row) && empty($row["react"]) && empty($row["react_media"]))	{
        	if($row["state"] == 1)	{
        		$reactEcho .= "a";
        	}
        	else if($row["state"] == -1)	{
        		$reactEcho .= "b";
        	}
        }
        $reactEcho .= "|";
    }
}
}
if(empty($reactEcho))
    $reactEcho = "0";
echo $reactEcho;
}
else    {
    echo "0";
}
mysqli_close($dbc);
?>