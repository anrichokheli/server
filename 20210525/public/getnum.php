<?php
$database = parse_ini_file(dirname(getcwd()) . "/protected/private/database.ini");
$conn = mysqli_connect($database["host"], $database["username"], $database["password"], $database["name"]);
$sql = "SELECT * FROM violations";
$result = $conn->query($sql);
if(!empty($result))    {
    if ($result->num_rows > 0) {
        while($row0 = $result->fetch_assoc()) {
		$items[] = $row0;
        }
    }
}
$conn->close();
if(!isset($items))	{
	exit("0");
}
if(!defined("echoDisable"))	{
	echo end($items)["n"];
}
?>