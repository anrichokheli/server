<title>ქვეითი SOS</title>
<head><link rel="icon" href="/pedestriansos.png"></head>
<meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1">
<?php
$darkMode = 1;
if(isset($_COOKIE["darkmode"]))	{
	$darkMode = ($_COOKIE["darkmode"] == 1);
}
/*else if(isset($_GET["darkmode"]))	{
	$darkMode = ($_GET["darkmode"] == 1);
}*/
define("darkMode", $darkMode);
unset($darkMode);
if(!isset($n))	{
	if(isset($_GET["n"]))    {
		$n = $_GET["n"];
	}
	else if(isset($_POST["n"]))    {
		$n = $_POST["n"];
	}
}
require dirname(getcwd()) . "/protected/private/check_n_input.php";
?>
<style>
    <?php
        if(darkMode)    {
            echo "
                *:not(.samecolourindarkmode)   {
                    background: #000000;
                    color: #ffffff;
                }
            ";
        }
    ?>
	#userbtn	{
		border: none;
		padding: 8px;
		text-align: center;
		text-decoration: none;
		display: inline-block;
		font-size: 32px;
		margin: 1px 1px;
		cursor: pointer;
		color: black; 
		border-radius: 8px;
		background-color: rgba(192, 192, 192, 0.25);
	}
	#more {display: none;}
	#more_less, #dots	{
		color: #808080;
	}
	#nametext	{
		color: #808080;
	}
</style>
<?php
$returnMode = 1;
if(include 'check_n.php')    {
?>
<html>
<style>
#textBackground    {
    border-radius: 2px;
    background: rgba(64, 64, 64, 0.1);
    word-wrap: break-word;
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
$n = $GLOBALS["n"];
include dirname(getcwd()) . "/protected/private/mysqli_database.php";
$dbc = $mysqliConnectValue;
if(!$dbc) {
die("DATABASE CONNECTION FAILED:" .mysqli_error($dbc));
exit();
}
$dbs = mysqli_select_db($dbc, $database["name"]);
if(!$dbs) {
die("DATABASE SELECTION FAILED:" .mysqli_error($dbc));
exit();
}
$query = "SELECT * FROM violations WHERE n = '$n'";
if(mysqli_query($dbc, $query))    {
$row = mysqli_fetch_array(mysqli_query($dbc, $query));
$media = $row["filename"];
$latitude = $row["latitude"];
$longitude = $row["longitude"];
if($row["location_time"] != 0)	{
	$location = $latitude . ", " . $longitude;
}
else	{
	$location = "";
}
$accuracy = $row["accuracy"];
$address = $row["address"];
$category = $row["situation"];
$description = $row["description"];
$react = $row["react"];
$reactMedia = $row["react_media"];
$filePath = "uploads/media/" . $row["filename"];
$media = "/?/" . $filePath;
$type = explode("/", mime_content_type(dirname(getcwd()) . "/protected/public/" . $filePath))[0];
if($type === "video")  {
    $media = "<video src=$media width=100% max-height=100% controls></video>";
}
else if($type === "image") {
    $media = "<img src=$media alt=$media width=100%>";
}
if($row["react_time"] != 0)    {
$reactPath = "uploads/react_media/" . $row["react_media"];
$reactMedia = "/?/" . $reactPath;
$type = explode("/", mime_content_type(dirname(getcwd()) . "/protected/public/" . $reactPath))[0];
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
else    {
    $reactMedia = "";
}
$mapIframeSize = "width:100%;height:400;";
$map = include(protectedPrivatePath . "map.php");
$map = "<br><hr><br>" . $map;
if(!empty($category))
	$category = "<strong>" . "კატეგორია:" . "</strong>" . "<br><br>" . str_replace("DELIMITER_BETWEEN_Aiip9ivope_QVEITIქვეითიSOS", "</p><p id=textBackground>", str_replace("DELIMITER_AFTER_e2QP1tyepu_QVEITIქვეითიSOS", "</b><p id=textBackground>", str_replace("DELIMITER_AFTER2_PnAogaR8vs_QVEITIქვეითიSOS", "</p>", str_replace("DELIMITER_BEFORE_qHwe31xrAO_QVEITIქვეითიSOS", "<b>", $category))));
else
	$category = "კატეგორია არ არის ატვირთული";
$category = "<br><hr><br>" . $category;
if(!empty($description))	{
	$l = 100;
	if(strlen($description) > $l)	{
		$description = substr_replace($description, "<span id=\"dots\">...</span><span id=\"more\">", $l, 0) . "</span><span id=\"more_less\">>></span>";
	}
	$description = "<strong>" . "აღწერა:" . "</strong>" . "<br>" . "<p id=textBackground onclick=\"readMore()\">" . $description . "</p>";
}
else
	$description = "აღწერა არ არის ატვირთული";
$description = "<br><hr><br>" . $description;
if(!empty($react))
	$react = "<strong>" . "რეაგირების ტექსტი:" . "</strong>" . "<br>" . "<p id=textBackground>" . $react . "</p>";
else
	$react = "რეაგირების შესახებ მონაცემები არ არის ატვირთული";
$react = "<br><hr><br>" . $react;
if(!empty($reactMedia))
	$reactMedia = "<br><hr><br>" . "<strong>" . "რეაგირების ფაილი:" . "</strong>" . "<br><hr><br>" . $reactMedia;
if($row["location_time"] != 0)	{
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
if($row["location_time"] != 0)	{
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
$time = date("Y-m-d H:i:s", $time);
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
$time = "<br><hr><br>" . "<strong>" . "ატვირთვის დრო და თარიღი: " . "</strong>" . "<br>" . $time;
$soundLink = $row["sound_name"];
if(!empty($soundLink))	{
	$sound = "<audio controls src=/?/uploads/sound/" . $soundLink . "></audio>";
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
$userID = $row["user_id"];
$GLOBALS["user_id"] = $userID;
if($userID == 0)	{
	$userID = "ატვირთულია არარეგისტრირებული (ანონიმური) მომხმარებლის მიერ";
	$username = "";
	$name = "";
	$userimage = "";
	$accountdatetime = "";
	$userImageAndName = "";
	$userButton = "";
}
else	{
	$user = mysqli_fetch_array(mysqli_query($dbc, "SELECT * FROM users WHERE id LIKE '$userID'"));
	$username = $user["account_name"];
	$name = $user["name"];
	$userimage = $user["image"];
	if(empty($userimage))	{
		$userimage = "user_icon2.png";
	}
	else	{
		$userimage = "/?/uploads/users_images/" . $userimage;
	}
	$userimage = "<img src=$userimage alt=$userimage style=max-width:192px;max-height:192px;>";
	$accountdatetime = $user["time_created"];
	$accountdatetime = date("Y-m-d", $accountdatetime) . " " . date("H:i:s", $accountdatetime);
	$userID = "<strong>" . "ანგარიშის რიგითი ნომერი:" . "</strong>" . "<br>" . $userID;
	$username = "<br><hr><br>" . "<strong>" . "ანგარიშის სახელი:" . "</strong>" . "<br>" . $username;
	$accountdatetime = "<br><hr><br>" . "<strong>" . "ანგარიშის შექმნის დრო და თარიღი:" . "</strong>" . "<br>" . $accountdatetime;
	if(empty($name))	{
		$name = "<span id=nametext>" . "სახელი" . "</span>";
	}
	$userImageAndName = "<br><hr><br>" . "<strong>" . "ანგარიშის სურათი და სახელი:" . "</strong>" . "<br><br>" . "<center>" . $userimage . "<br>" . $name . "</center>";
	$userButton = "<br><hr><br>" . "<center>" . "<button type=button id=userbtn><span style=\"background: none;\">ანგარიშის ნახვა</span></button>" . "</center>";
}
$account = "<br><hr><br>" . $userID . $username . $accountdatetime . $userImageAndName;
$altitude = $row["altitude"];
if($altitude)	{
	$altitude .= " მეტრი";
}
else	{
	$altitude = "მონაცემები არ არის";
}
$altitude = "<br><hr><br>სიმაღლე (WGS84):<br>" . $altitude;
$mediaPath = dirname(getcwd()) . "/protected/public/" . $filePath;
$exifDateTime = @exif_read_data($mediaPath)["DateTimeOriginal"];
$captureDateTime = "";
if($exifDateTime && isset($exifDateTime) && !empty($exifDateTime) && strtotime($exifDateTime))	{
	$captureDateTime = htmlspecialchars($exifDateTime);
	$captureDateTime = date_format(date_create($captureDateTime), "Y-m-d H:i:s");
	$captureDateTime = "<br><hr><br>" . "<strong>" . "გადაღების დრო და თარიღი: " . "</strong>" . "<br>" . $captureDateTime;
}
echo "<strong>" . "#: " . $n . "</strong>" . "<br><hr><br>" . "<strong>" . "ფოტო/ვიდეო:" . "</strong>" . "<br><hr><br>" . $media . $time . $captureDateTime . $location . $altitude . $accuracy . $address . $locationTime . $map . $sound . $soundTime . $category . $description . $infoTime . $state . $stateTime . $reactTime . $interval . $react . $reactMedia . $account . $userButton . "<br><br><br><br><hr><br><i><span style=\"color:#0000ff;\">ქვეითი</span> <span style=\"color:#ff0000;\">SOS</span></i><br><hr><br>";
mysqli_close($dbc);
}
if(isset($_GET["filter"]))	{
	$GLOBALS["filter_mode"] = "&filter=" . $_GET["filter"];
}
else	{
	$GLOBALS["filter_mode"] = "";
}
$GLOBALS["url_text"] = "get_app.php?search_for=all&user_id=" . $GLOBALS["user_id"] . $GLOBALS["filter_mode"];
?>
</html>
<?php
}
else	{
	echo "<center>" . "<br>" . "<font size=25>#" . $n . "</font>" . "<br><br>" . "<img src=no_data.png>" . "<br><br>" . "<strong>" . "<font class=\"samecolourindarkmode\" size=25 color=red>" . "მონაცემები არ არის" . "</font>" . "</strong>" . "</center>";
}
?>
<script>
	var dots = document.getElementById("dots");
	var moreText = document.getElementById("more");
	var btnText = document.getElementById("more_less");
	function readMore() {
		var selection = window.getSelection();
		if(selection.toString().length === 0)	{
			if (dots.style.display === "none") {
				dots.style.display = "inline";
				btnText.innerHTML = ">>";
				moreText.style.display = "none";
			} else {
				dots.style.display = "none";
				btnText.innerHTML = "<<";
				moreText.style.display = "inline";
			}
		}
	}
	<?php
	    if($GLOBALS["user_id"] != 0)    {
        	echo "
        	    document.getElementById(\"userbtn\").onclick = function()	{
	            	window.open(\"" . $GLOBALS["url_text"] . "\");
            	};
            ";
    	}
	?>
</script>