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
<th>ატვირთვის დრო</th>
<th>ფოტო/ვიდეო</th>
<th>მდებარეობის კოორდინატები</th>
<th>სიმაღლე (WGS84)</th>
<th>მდებარეობის სიზუსტე</th>
<th>მისამართი</th>
<th>მდებარეობის მონაცემების ატვირთვის დრო</th>
<th>ხმოვანი აღწერა</th>
<th>ხმოვანი აღწერის ატვირთვის დრო</th>
<th>კატეგორია</th>
<th>აღწერა</th>
<th>კატეგორი(ებ)ის ან/და აღწერის ატვირთვის დრო</th>
<th>მონიშნულია როგორც</th>
<th>მონიშვნის დრო</th>
<th>რეაგირების დრო</th>
<th>რეაგირებისთვის საჭირო დრო</th>
<th>რეაგირების ტექსტი</th>
<th>რეაგირების ფაილი</th>
<th>ანგარიშის რიგითი ნომერი</th>
<th>ანგარიშის სახელი</th>
<th>სახელი</th>
<th>სურათი</th>
<th>ანგარიშის შექმნის დრო და თარიღი</th>
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
$sql = "SELECT * FROM violations";
$result = $conn->query($sql);
if(!empty($result))    {
if ($result->num_rows > 0) {
// output data of each row
while($row0 = $result->fetch_assoc()) {
	$items[] = $row0;
}
$items = array_reverse($items);
foreach($items as $row)	{
$filePath = "uploads/media/" . $row["filename"];
$path = "/?/" . $filePath;
$type = explode("/", mime_content_type(dirname(getcwd()) . "/protected/public/" . $filePath))[0];
if($type === "video") {
$media = "<video src=$path style=max-width:480px;max-height:320px; controls></video>";
}
else if($type === "image") {
$media = "<img src=$path alt=$path style=max-width:480px;max-height:320px;>";
}
else {
$media = $path;
}
if($row["react_time"] != 0)    {
$reactPath = "uploads/react_media/" . $row["react_media"];
$reactLink = "/?/" . $reactPath;
$type = explode("/", mime_content_type(dirname(getcwd()) . "/protected/public/" . $reactPath))[0];
if($type === "video") {
$reactMedia = "<video src=$reactLink style=max-width:480px;max-height:320px; controls></video>";
}
else if($type === "image") {
$reactMedia = "<img src=$reactLink alt=$reactLink style=max-width:480px;max-height:320px;>";
}
else {
$reactMedia = "<a style=font-size:32px target=_blank href = $reactLink>რეაგირების ფაილის გახსნა</a>";
}
}
else    {
    $reactMedia = "";
}
date_default_timezone_set("Etc/GMT-4");
$time = $row["time"];
$reactTime = $row["react_time"];
$interval = $reactTime - $time;
$time = date("Y-m-d", $time) . "<br>" . date("H:i:s", $time);
if($reactTime !== "0") {
$reactTime = date("Y-m-d", $reactTime) . "<br>" . date("H:i:s", $reactTime);
$interval = getTime($interval) . " (" . $interval . "წმ)";
}
else {
$reactTime = "";
$interval = "";
}
$soundLink = $row["sound_name"];
if(!empty($soundLink))	{
	$sound = "<audio controls src=/?/uploads/sound/" . $soundLink . "></audio>";
}
else	{
	$sound = "";
}
$locationTime = $row["location_time"];
if($locationTime !== "0")    {
    $locationTime = date("Y-m-d", $locationTime) . "<br>" . date("H:i:s", $locationTime);
}
else    {
    $locationTime = "";
}
$soundTime = $row["sound_time"];
if($soundTime !== "0")    {
    $soundTime = date("Y-m-d", $soundTime) . "<br>" . date("H:i:s", $soundTime);
}
else    {
    $soundTime = "";
}
$infoTime = $row["info_time"];
if($infoTime !== "0")    {
    $infoTime = date("Y-m-d", $infoTime) . "<br>" . date("H:i:s", $infoTime);
}
else    {
    $infoTime = "";
}
$stateTime = $row["state_time"];
if($stateTime !== "0")    {
    $stateTime = date("Y-m-d", $stateTime) . "<br>" . date("H:i:s", $stateTime);
}
else    {
    $stateTime = "";
}
$location = $row["latitude"] . ", " . $row["longitude"];
if($location === "0, 0")	{
	$location = "";
}
$situation = $row["situation"];
$description = $row["description"];
$react = $row["react"];
$situation = str_replace("DELIMITER_BETWEEN_Aiip9ivope_QVEITIქვეითიSOS", "<br>", str_replace("DELIMITER_AFTER_e2QP1tyepu_QVEITIქვეითიSOS", ":</b><br>", str_replace("DELIMITER_AFTER2_PnAogaR8vs_QVEITIქვეითიSOS", "<br>", str_replace("DELIMITER_BEFORE_qHwe31xrAO_QVEITIქვეითიSOS", "<b>", $situation))));
$userID = $row["user_id"];
if($userID == 0)	{
	$userID = "";
	$username = "";
	$name = "";
	$userimage = "";
	$accountdatetime = "";
}
else	{
	$user = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM users WHERE id LIKE '$userID'"));
	$username = $user["account_name"];
	$name = $user["name"];
	$userimage = $user["image"];
	if(!empty($userimage))	{
		$userimage = "/?/uploads/users_images/" . $userimage;
		$userimage = "<img src=$userimage alt=$userimage style=max-width:256px;max-height:256px;>";
	}
	$accountdatetime = $user["time_created"];
	$accountdatetime = date("Y-m-d", $accountdatetime) . "<br>" . date("H:i:s", $accountdatetime);
}
if($row["state"] == 1)	{
	$state = "შესაბამისი";
}
else if($row["state"] == -1)	{
	$state = "შეუსაბამო";
}
else	{
	$state = "";
}
if(!empty($location))	{
	$accuracy = $row["accuracy"];
	if($accuracy == 0)	{
		$accuracy = "მდებარეობა აირჩია მომხმარებელმა";
	}
	else if($accuracy > 0)	{
		$accuracy = $accuracy . " მეტრი";
	}
	else	{
		$accuracy = ($accuracy * -1) . " მეტრი (მდებარეობა და სიზუსტე აირჩია მომხმარებელმა)";
	}
}
else	{
	$accuracy = "";
}
$altitude = $row["altitude"];
if(!$altitude)	{
	$altitude = "";
}
else	{
	$altitude .= " მეტრი";
}
$address = $row["address"];
echo "<tr><td>" . $row["n"] . "</td><td>" . $time . "</td><td>" . $media . "</td><td>" . $location . "</td><td>" . $altitude . "</td><td>" . $accuracy . "</td><td>" . $address . "</td><td>" . $locationTime . "</td><td>" . $sound . "</td><td>" . $soundTime . "</td><td>" .
$situation . "</td><td>" . $description . "</td><td>" . $infoTime . "</td><td>" .
$state . "</td><td>" . $stateTime . "</td><td>" . $reactTime . "</td><td>" . $interval . "</td><td>" . $react . "</td><td>" . $reactMedia . "</td><td>" . $userID . "</td><td>" . $username . "</td><td>" . $name . "</td><td>" . $userimage . "</td><td>" . $accountdatetime . "</td></tr>";
}
}
}
$conn->close();
?> </table>
</body>
</html>