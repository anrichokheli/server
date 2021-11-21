<?php
$content = $_GET["content"];
$n = $_GET["n"];
$database = parse_ini_file(dirname(getcwd()) . "/private/database.ini");
$dbc = mysqli_connect($database["host"], $database["username"], $database["password"], $database["name"]);
$query = "SELECT * FROM violations WHERE n = $n";
if(mysqli_query($dbc, $query))    {
    $row = mysqli_fetch_array(mysqli_query($dbc, $query));
    if($content === "file")
        echo $row["link"];
    else if($content === "react_file")
        echo $row["react_media"];
}
mysqli_close($dbc);
?>