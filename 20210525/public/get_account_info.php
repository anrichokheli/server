<?php
include dirname(getcwd()) . "/protected/private/mysqli_database.php";
$conn = $mysqliConnectValue;
$mode = mysqli_real_escape_string($conn, $_GET['mode']);
$text = mysqli_real_escape_string($conn, htmlspecialchars($_POST['searchfor']));
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
        if(!empty($image))	{
		$image = "?/uploads/users_images/" . $image;
	}
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