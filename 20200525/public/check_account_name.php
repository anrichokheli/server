<?php
$database = parse_ini_file(dirname(getcwd()) . "/private/database.ini");
$conn = mysqli_connect($database["host"], $database["username"], $database["password"], $database["name"]);
$text = mysqli_real_escape_string($conn, $_GET['text']);
// Check connection
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT * FROM users";
$result = $conn->query($sql);
$notexists = "1";
if(!empty($result))    {
	if ($result->num_rows > 0) {
		// output data of each row
		while($row = $result->fetch_assoc()) {
    			if($text === $row["account_name"])    {
        			$notexists = "0";
        			break;
			}
    		}
	}
}
if(!isset($returnMode))	{
	echo $notexists;
}
$conn->close();
?>