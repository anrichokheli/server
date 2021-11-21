<?php
$database = parse_ini_file(dirname(getcwd()) . "/private/database.ini");
$conn = mysqli_connect($database["host"], $database["username"], $database["password"], $database["name"]);
$text = mysqli_real_escape_string($conn, $_GET['name']);
// Check connection
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT * FROM users";
$result = $conn->query($sql);
if(!empty($result))    {
if ($result->num_rows > 0) {
// output data of each row
$accountNameFound = FALSE;
while($row = $result->fetch_assoc()) {
    if($text === $row["account_name"])    {
        $image = $row["image"];
        $accountNameFound = TRUE;
        break;
    }
}
if($accountNameFound)    {
    echo "1" . $image;
}
else    {
    echo "0";
}
}
else    {
    echo "0";
}
}
$conn->close();
?>