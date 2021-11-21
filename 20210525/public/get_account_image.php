<?php
include dirname(getcwd()) . "/protected/private/mysqli_database.php";
$conn = $mysqliConnectValue;
$text = mysqli_real_escape_string($conn, htmlspecialchars($_POST['name']));
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
        if(!empty($image))	{
		$image = "?/uploads/users_images/" . $image;
	}
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