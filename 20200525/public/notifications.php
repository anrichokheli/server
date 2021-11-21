<title>ქვეითი SOS</title>
<head><link rel="icon" href="<?php include 'get_web_url.php' ?>/qveitiSOS.jpg"></head>
<html>
<style>
    #textBackground    {
        border-radius: 2px;
        background: rgba(64, 64, 64, 0.1);
    }
    svg {
        background-image: linear-gradient(red, green, blue);
        border-radius: 5px;
    }
    #dashedline    {
        border-top: dashed;
    }
</style>
<?php
function getTime($second)  {
    $hour = floor($second / 3600);
    $minute = floor($second / 60) % 60;
    $second %= 60;
    $time = $hour . "სთ " . $minute . "წთ " . $second . "წმ";
    return $time;
}
$database = parse_ini_file(dirname(getcwd()) . "/private/database.ini");
define ('dbuser', $database["username"]);
define ('dbpw', $database["password"]);
define ('dbhost', $database["host"]);
define ('dbname', $database["name"]);
$dbc = mysqli_connect(dbhost, dbuser, dbpw, dbname);
if(!$dbc) {
die("DATABASE CONNECTION FAILED:" .mysqli_error($dbc));
exit();
}
$dbs = mysqli_select_db($dbc, dbname);
if(!$dbs) {
die("DATABASE SELECTION FAILED:" .mysqli_error($dbc));
exit();
}
$n = mysqli_real_escape_string($dbc, $_GET['n']);
$n = str_replace(array("a", "b"), "", $n);
$IDs0 = explode("|", $n);
$db_reactTime = array();
$emptyRowsIDs = array();
$toDeleteIDs = array();
$toReactIDs = array();
foreach($IDs0 as $N)	{
	$r = mysqli_fetch_array(mysqli_query($dbc, "SELECT * FROM violations WHERE n = $N"));
	if(empty($r))	{
		array_push($emptyRowsIDs, $N);
	}
	else if($r["state"] == -1)	{
		array_push($toDeleteIDs, $N);
	}
	else if(!empty($r["react_time"]) && !empty($r["react_media"]) && !empty($r["react"]))	{
		array_push($db_reactTime, $r["react_time"]);
	}
	else if($r["state"] == 1)	{
		array_push($toReactIDs, $N);
	}
}
rsort($db_reactTime);
$IDs = array();
foreach($db_reactTime as $T)	{
	$r = mysqli_fetch_array(mysqli_query($dbc, "SELECT * FROM violations WHERE react_time = $T"));
	array_push($IDs, $r["n"]);
}
$IDs = array_merge($toDeleteIDs, $emptyRowsIDs, $IDs, $toReactIDs);
$reactEcho = "შეყტობინებათა რაოდენობა: " . count($IDs) . "<br><hr id=dashedline><br>";
$returnMode = 1;
for($i = 0; $i < count($IDs); $i++)	{
$_GET['n'] = $IDs[$i];
if(include 'check_n.php')    {
$query = "SELECT * FROM violations WHERE n = $IDs[$i]";
if(mysqli_query($dbc, $query))    {
$row = mysqli_fetch_array(mysqli_query($dbc, $query));
$media = $row["link"];
$location = htmlspecialchars($row["location"]);
$accuracy = $row["accuracy"];
$address = htmlspecialchars($row["address"]);
$category = htmlspecialchars($row["situation"]);
$description = nl2br(htmlspecialchars($row["description"]));
$react = htmlspecialchars($row["react"]);
$reactMedia = $row["react_media"];
$type = explode("/", mime_content_type(str_replace("http://" . $_SERVER['HTTP_HOST'] . "/media/", getcwd() . trim("/media/ "), $media)))[0];
if($type === "video")  {
    $media = "<video src=$media width=100% max-height=100% controls></video>";
}
else if($type === "image") {
    $media = "<img src=$media alt=$media width=100%>";
}
if(!empty($reactMedia))	{
$type = explode("/", mime_content_type(str_replace("http://" . $_SERVER['HTTP_HOST'] . "/react_media/", getcwd() . trim("/react_media/ "), $reactMedia)))[0];
if($type === "video")  {
    $reactMedia = "<video src=$reactMedia width=100% controls></video>";
}
else if($type === "image") {
    $reactMedia = "<img src=$reactMedia alt=$reactMedia width=100%>";
}
else   {
    $reactMedia = "<a href = $reactMedia>რეაგირების ფაილის გახსნა</a>";
}
}
$MAP_API_KEY = parse_ini_file(dirname(getcwd()) . "/private/apikey.ini")["google_map"];
$map = "<iframe src=https://www.google.com/maps/embed/v1/place?key=" . $MAP_API_KEY . "&q=" . str_replace(' ', '%20', $location) . " height=400 width=100%></iframe>";
if(!empty($category))
	$category = "<strong>" . "კატეგორია: " . "</strong>" . "<br><br>" . str_replace("DELIMITER_BETWEEN_Aiip9ivope_QVEITIქვეითიSOS", "</p><p id=textBackground>", str_replace("DELIMITER_AFTER_e2QP1tyepu_QVEITIქვეითიSOS", "</b><p id=textBackground>", str_replace("DELIMITER_AFTER2_PnAogaR8vs_QVEITIქვეითიSOS", "</p>", str_replace("DELIMITER_BEFORE_qHwe31xrAO_QVEITIქვეითიSOS", "<b>", $category))));
else
	$category = "კატეგორია არ არის ატვირთული";
$category = "<br><hr><br>" . $category;
if(!empty($description))
	$description = "<strong>" . "აღწერა: " . "</strong>" . "<br>" . "<p id=textBackground>" . $description . "</p>";
else
	$description = "აღწერა არ არის ატვირთული";
$description = "<br><hr><br>" . $description;
if(!empty($react))
	$react = "<strong>" . "რეაგირების ტექსტი: " . "</strong>" . "<br>" . "<p id=textBackground>" . $react . "</p>";
else
	$react = "რეაგირების შესახებ მონაცემები არ არის ატვირთული";
$react = "<br><hr><br>" . $react;
if(!empty($reactMedia))
	$reactMedia = "<br><hr><br>" . "<strong>" . "რეაგირების ფაილი: " . "</strong>" . "<br><hr><br>" . $reactMedia;
if(!empty($location))	{
	if($accuracy == 0)	{
		$accuracy = "მდებარეობა აირჩია მომხმარებელმა";
	}
	else if($accuracy > 0)	{
		$accuracy = $accuracy . " მეტრი";
	}
	else	{
		$accuracy = ($accuracy * -1) . " მეტრი (მდებარეობა და სიზუსტე აირჩია მომხმარებელმა)";
	}
	$accuracy = "<br><hr><br>" . "<strong>" . "მდებარეობის სიზუსტე:<br>" . "</strong>" . $accuracy;
}
$map = "<br><hr><br>" . $map;
if(!empty($location))	{
	$location = "<strong>" . "მდებარეობის კოორდინატები:" . "</strong>" . "<br>" . $location;
}
else	{
	$location = "მდებარეობის კოორდინატები არ არის ატვირთული";
	$accuracy = "";
	$map = "";
}
$location = "<br><hr><br>" . $location;
if(!empty($address))	{
	$address = "<strong>" . "მისამართი:" . "</strong>" . "<br>" . $address . "<br>";
}
else	{
	$address = "მისამართი არ არის ატვირთული";
}
$address = "<br><hr><br>" . $address;
date_default_timezone_set("Etc/GMT-4");
$time = $row["time"];
$reactTime = $row["react_time"];
$interval = $reactTime - $time;
$time = date("Y-m-d", $time) . "    " . date("H:i:s", $time);
if($reactTime !== "0")  {
    $reactTime = date("Y-m-d", $reactTime) . "    " . date("H:i:s", $reactTime);
    $interval = getTime($interval) . " (" . $interval . "წმ)";
    $reactTime = "<br><hr><br>" . "<strong>" . "რეაგირების დრო და თარიღი:" . "</strong>" . "<br>" . $reactTime;
    $interval = "<br><hr><br>" . "<strong>" . "რეაგირებისთვის საჭირო დრო:" . "</strong>" . "<br>" . $interval;
}
else    {
    $reactTime = "";
    $interval = "";
}
$time = "<br><hr><br>" . "<strong>" . "ატვირთვის დრო და თარიღი:" . "</strong>" . "<br>" . $time;
$soundLink = $row["sound_link"];
if(!empty($soundLink))	{
	$sound = "<audio controls src=" . $soundLink . "></audio>";
	$sound = "<strong>" . "ხმოვანი აღწერა:" . "</strong>" . "<br>" . $sound;
}
else	{
	$sound = "ხმოვანი აღწერა არ არის ატვირთული";
}
$sound = "<br><hr><br>" . $sound;
$locationTime = $row["location_time"];
if($locationTime !== "0")    {
    $locationTime = date("Y-m-d", $locationTime) . "    " . date("H:i:s", $locationTime);
    $locationTime = "<br><hr><br>" . "<strong>" . "მდებარეობის მონაცემების ატვირთვის დრო და თარიღი: " . "</strong>" . "<br>" . $locationTime;
}
else    {
    $locationTime = "";
}
$soundTime = $row["sound_time"];
if($soundTime !== "0")    {
    $soundTime = date("Y-m-d", $soundTime) . "    " . date("H:i:s", $soundTime);
    $soundTime = "<br><hr><br>" . "<strong>" . "ხმოვანი აღწერის ატვირთვის დრო და თარიღი: " . "</strong>" . "<br>" . $soundTime;
}
else    {
    $soundTime = "";
}
$infoTime = $row["info_time"];
if($infoTime !== "0")    {
    $infoTime = date("Y-m-d", $infoTime) . "    " . date("H:i:s", $infoTime);
    $infoTime = "<br><hr><br>" . "<strong>" . "კატეგორი(ებ)ის ან/და აღწერის ატვირთვის დრო და თარიღი: " . "</strong>" . "<br>" . $infoTime;
}
else    {
    $infoTime = "";
}
$userID = $row["user_id"];
if($userID == 0)	{
	$userID = "ატვირთულია არარეგისტრირებული (ანონიმური) მომხმარებლის მიერ";
	$username = "";
	$name = "";
	$userimage = "";
	$accountdatetime = "";
	$userImageAndName = "";
}
else	{
	$user = mysqli_fetch_array(mysqli_query($dbc, "SELECT * FROM users WHERE id LIKE '$userID'"));
	$username = $user["account_name"];
	$name = htmlspecialchars($user["name"]);
	$userimage = htmlspecialchars($user["image"]);
	if(empty($userimage))	{
		$userimage = "user_icon2.png";
	}
	$userimage = "<img src=$userimage alt=$userimage style=max-width:192px;max-height:192px;>";
	$accountdatetime = $user["time_created"];
	$accountdatetime = date("Y-m-d", $accountdatetime) . " " . date("H:i:s", $accountdatetime);
	$userID = "<strong>" . "ანგარიშის რიგითი ნომერი:" . "</strong>" . "<br>" . $userID;
	$username = "<br><hr><br>" . "<strong>" . "ანგარიშის სახელი:" . "</strong>" . "<br>" . $username;
	$accountdatetime = "<br><hr><br>" . "<strong>" . "ანგარიშის შექმნის დრო და თარიღი:" . "</strong>" . "<br>" . $accountdatetime;
	if(empty($name))	{
		$name = "<font color=#808080>" . "სახელი" . "</font>";
	}
	$userImageAndName = "<br><hr><br>" . "<strong>" . "ანგარიშის სურათი და სახელი:" . "</strong>" . "<br><br>" . "<center>" . $userimage . "<br>" . $name . "</center>";
}
$account = "<br><hr><br>" . $userID . $username . $accountdatetime . $userImageAndName;
$state = "<br><hr><br>";
if($row["state"] == 0)	{
	$state .= "მონიშნული არ არის";
	$stateTime = "";
}
else	{
	$stateTime = $row["state_time"];
	$stateTime = date("Y-m-d", $stateTime) . "    " . date("H:i:s", $stateTime);
	$stateTime = "<br><hr><br>" . "<strong>" . "მონიშვნის დრო და თარიღი: " . "</strong>" . "<br>" . $stateTime;
	$state .= "<strong>" . "მონიშნულია როგორც:" . "</strong>" . "<br>";
	if($row["state"] == 1)	{
		$state .= "<span style=\"font-weight:bold;color:green;\">✓</span> შესაბამისი";
	}
	else if($row["state"] == -1)	{
		$state .= "<span style=\"font-weight:bold;color:red;\">✕</span> შეუსაბამო" . "<center><p style=\"color:white;background-color:red;\">წაიშლება სერვერიდან!</p></center>";
	}
}
$reactEcho .= "<strong>" . "#: " . $IDs[$i] . "</strong>" . $state . $stateTime . $reactTime . $react . $reactMedia . $interval . $time . "<br><hr><br>" . "<strong>" . "ფოტო/ვიდეო: " . "</strong>" . "<br><hr><br>" . $media . $location . $accuracy . $address . $locationTime . $map . $sound . $soundTime . $category . $description . $infoTime . $account . "<br><hr><br><br><svg width=100% height=25px></svg><br><br>";
}
}
else    {
    $reactEcho .= "<strong>" . "#: " . $IDs[$i] . "</strong>" . "<center>" . "<br><strong><font color=red>წაშლილია!</font></strong><br>" . "<br><img src=delete.png width=100%><br>" . "</center>" . "<br><br><svg width=100% height=25px></svg><br><br>";
}
}
echo $reactEcho . "<br><hr><br><i><font color=blue>ქვეითი</font> <font color=red>SOS</font></i><br><hr><br>";
mysqli_close($dbc);
?>
</html>