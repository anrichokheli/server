<?php
$database = parse_ini_file(dirname(getcwd()) . "/protected/private/database.ini");
$servername = $database["host"];
$username = $database["username"];
$password = $database["password"];
$dbname = $database["name"];
$conn = new mysqli($servername, $username, $password);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "CREATE DATABASE $dbname";
$conn->query($sql);
$conn->close();
?>