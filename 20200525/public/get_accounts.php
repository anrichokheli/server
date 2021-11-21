<title>ქვეითი SOS</title>
<head><link rel="icon" href="<?php include 'get_web_url.php' ?>/qveitiSOS.jpg"></head>
<!DOCTYPE html>
<html>
<head>
 <style>
  table {
   border-collapse: collapse;
   width: 100%;
   color: #000000;
   font-family: monospace;
   font-size: 25px;
   text-align: center;
  }
  th {
   background-color: #808080;
   color: white;
  }
  tr:nth-child(even) {background-color: #f2f2f2}
.button {
  background-color: red;
  border: none;
  color: white;
  padding: 8px 16px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 25px;
  margin: 4px 2px;
  transition-duration: 0.4s;
  cursor: pointer;
  background-color: white; 
  color: black; 
  border: 2px solid red;
  border-radius: 8px;
  width: 100%;
}
.button:hover {
  background-color: red;
  color: white;
}
#uploaded {
  background-color: blue;
  border: none;
  color: white;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 96px;
  margin: 4px 4px;
  transition-duration: 0.4s;
  cursor: pointer;
  background-color: white; 
  color: black; 
  border: 2px solid blue;
  border-radius: 50%;
  width: 128px;
  height: 128px;
}
#uploaded:hover {
  background-color: blue;
  color: white;
}
#text {
    background-color: red;
    color: white;
    font-size: 22;
}
 </style>
</head>
<body>
<table>
<tr>
    <th>#</th>
    <th>ანგარიშის სახელი</th>
    <th>სურათი და სახელი</th>
    <th>შექმნის დრო<br>და თარიღი</th>
    <th>ატვირთული<br>მასალ(ებ)ის<br>რაოდენობა</th>
    <th>ატვირთული<br>მასალ(ებ)ის<br>ნახვა</th>
</tr>
<?php
define ('weblink', include 'get_web_url.php');
$database = parse_ini_file(dirname(getcwd()) . "/private/database.ini");
$conn = mysqli_connect($database["host"], $database["username"], $database["password"], $database["name"]);
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
} 
$sql = "SELECT * FROM users";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	while($row0 = $result->fetch_assoc())	{
		$items[] = $row0;
	}
	$items = array_reverse($items);
	foreach($items as $row)	{
		$imageLink = $row["image"];
		date_default_timezone_set("Etc/GMT-4");
		$time = $row["time_created"];
		$time = date("Y-m-d", $time) . "<br>" . date("H:i:s", $time);
		$userID = $row["id"];
		$userName = htmlspecialchars($row["account_name"]);
		$name = htmlspecialchars($row["name"]);
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
		if(empty($imageLink))	{
			$imageLink = "user_icon2.png";
		}
		$image = "<img src=$imageLink style=max-width:192px;max-height:192px;>";
		if(empty($name))	{
			$name = "<font color=#808080>" . "სახელი" . "</font>";
		}
		$url = "user_uploads.php?id=" . $userID;
		echo "<tr><td>" . $userID . "</td><td>" . $userName . "</td><td>" . $image . "<br>" . $name . "</td><td>" . $time . "</td><td>" . $uploadedQuantity . "</td><td>" . "<a href=$url target=_blank>" . "<input type=submit id=uploaded value=»>" . "</a>" . "</td></tr>";
	}
}
echo "</table>";
$conn->close();
?>