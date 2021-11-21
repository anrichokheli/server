<?php
$database = parse_ini_file(dirname(getcwd()) . "/private/database.ini");
$conn = mysqli_connect($database["host"], $database["username"], $database["password"], $database["name"]);
$n = mysqli_real_escape_string($conn, $_GET['n']);
if(isset($_GET["account"]))	{
	$accountMode = 1;
}
else	{
	$accountMode = 0;
}
$sql = "SELECT * FROM ";
if(!$accountMode)	{
	$sql .= "violations";
	$ROW_ID = "n";
}
else	{
	$sql .= "users";
	$ROW_ID = "id";
}
$result = $conn->query($sql);
$found = "0";
if(!empty($result))    {
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            if($n === $row[$ROW_ID])    {
                $found = "1";
                break;
            }
        }
    }
}
$conn->close();
if(isset($returnMode) && $returnMode === 1)    {
    return $found;
}
else    {
    echo $found;
}
?>