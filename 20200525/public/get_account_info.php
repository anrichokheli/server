<?php
$database = parse_ini_file(dirname(getcwd()) . "/private/database.ini");
$conn = mysqli_connect($database["host"], $database["username"], $database["password"], $database["name"]);
$mode = mysqli_real_escape_string($conn, $_GET['mode']);
$text = mysqli_real_escape_string($conn, $_GET['searchfor']);
// Check connection
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT * FROM users";
$result = $conn->query($sql);
if(!empty($result))    {
if ($result->num_rows > 0) {
// output data of each row
$accountFound = FALSE;
while($row = $result->fetch_assoc()) {
    $string_id = strval($row["id"]);
    if((($text === $row["account_name"]) && ($mode === "AN")) || (($text === $string_id) && ($mode === "ID")))    {
        $image = $row["image"];
        $name = $row["name"];
        $time = $row["time_created"];
        if($mode === "AN")    {
            $accountName = $text;
        }
        else if($mode == "ID")   {
            $accountName = $row["account_name"];
        }
        if($mode === "AN")    {
            $id = $string_id;
        }
        else if($mode == "ID")   {
            $id = $text;
        }
        $accountFound = TRUE;
        break;
    }
}
if($accountFound)    {
    define("DELIMITER_BETWEEN", "DELIMITER_BETWEEN_Aiip9ivope_QVEITIქვეითიSOS");
    echo "1" . $image . DELIMITER_BETWEEN . $name . DELIMITER_BETWEEN . $time . DELIMITER_BETWEEN . $accountName . DELIMITER_BETWEEN . $id;
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