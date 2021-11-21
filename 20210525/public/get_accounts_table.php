<!DOCTYPE html>
<html>
<title>ქვეითი SOS</title>
<head><link rel="icon" href="/pedestriansos.png"></head>
<style>
table {
border-collapse: collapse;
width: 100%;
color: #000000;
font-family: monospace;
font-size: 25px;
text-align: center;
}
th, td {
  border: 1px solid #C0C0C0;
  text-align: center;
  padding: 8px;
}
th {
  background-color: #808080;
  color: white;
}
tr:nth-child(even) {background-color: #f2f2f2}
</style>
</head>
<body> <table> <tr>
<th>#</th>
<th>ანგარიშის შექმნის დრო</th>
<th>ანგარიშის სახელი</th>
<th>სურათი</th>
<th>სახელი</th>
<th>ატვირთული მასალ(ებ)ის რაოდენობა</th>
<th>ატვირთული მასალ(ებ)ის რიგითი ნომერი/ნომრები</th>
</tr> <?php
function getTime($second)  {
    $hour = floor($second / 3600);
    $minute = floor($second / 60) % 60;
    $second %= 60;
    $time = $hour . "სთ " . $minute . "წთ " . $second . "წმ";
    return $time;
}
include dirname(getcwd()) . "/protected/private/mysqli_database.php";
$conn = $mysqliConnectValue;
// Check connection
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT * FROM users";
$result = $conn->query($sql);
if(!empty($result))    {
if ($result->num_rows > 0) {
// output data of each row
while($row0 = $result->fetch_assoc()) {
	$items[] = $row0;
}
$items = array_reverse($items);
foreach($items as $row)	{
$imageLink = $row["image"];
if(!empty($imageLink))	{
	$imageLink = "/?/uploads/users_images/" . $imageLink;
	$image = "<img src=$imageLink style=max-width:300px;max-height:300px;>";
}
else	{
	$image = "";
}
date_default_timezone_set("Etc/GMT-4");
$time = $row["time_created"];
$time = date("Y-m-d", $time) . "<br>" . date("H:i:s", $time);
$userID = $row["id"];
$userName = $row["account_name"];
$name = $row["name"];
$sql = "SELECT * FROM violations";
$result = $conn->query($sql);
$uploadedIDs = array();
if(!empty($result))	{
	if ($result->num_rows > 0)	{
		while($row = $result->fetch_assoc())	{
			if(($row["user_id"] != 0) && ($row["user_id"] == $userID))	{
				array_push($uploadedIDs, $row["n"]);
			}
		}
	}
}
$uploadedQuantity = count($uploadedIDs);
$uploadedIDs = implode("; ", $uploadedIDs);
echo "<tr><td>" . $userID . "</td><td>" . $time . "</td><td>" . $userName . "</td><td>" . $image . "</td><td>" . $name . "</td><td>" . $uploadedQuantity . "</td><td>" . $uploadedIDs . "</td></tr>";
}
}
}
$conn->close();
?> </table>
</body>
</html>