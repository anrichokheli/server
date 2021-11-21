<?php
$DB = $_GET["db"] . "_time";
$database = parse_ini_file(dirname(getcwd()) . "/private/database.ini");
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
$times = array();
foreach($items as $row)    {
    array_push($times, $row[$DB]);
}
$t = max($times);
if($t == 0)	{
	exit("0");
}
foreach($items as $row)    {
    if($row[$DB] === $t)    {
        $n = $row["n"];
        break;
    }
}
echo $n;
?>