<title>ქვეითი SOS</title>
<head><link rel="icon" href="/pedestriansos.png"></head>
<meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1">
<?php
$darkMode = 1;
if(isset($_COOKIE["darkmode"]))	{
	$darkMode = ($_COOKIE["darkmode"] == 1);
}
define("darkMode", $darkMode);
unset($darkMode);
if(darkMode)	{
	echo "
		<style>
			body, #text	{
				background: #000000;
			}
			*:not(.samecolourindarkmode)	{
				color: #ffffff;
			}
		</style>
	";
}
if(!defined("protectedPrivatePath"))	define("protectedPrivatePath", dirname(getcwd()) . "/protected/private/");
if(!isset($n))	{
	if(isset($_GET["n"]))    {
		$n = $_GET["n"];
	}
	else if(isset($_POST["n"]))    {
		$n = $_POST["n"];
	}
}
require protectedPrivatePath . "check_n_input.php";
$returnMode = 1;
$dataExists = include 'check_n.php';
if(!$dataExists)    {
	exit("<center>" . "<br>" . "<font size=25>#" . $n . "</font>" . "<br><br>" . "<img src=no_data.png>" . "<br><br>" . "<strong>" . "<font size=25 class=samecolourindarkmode color=red>" . "მონაცემები არ არის" . "</font>" . "</strong>" . "</center>");
}
?>
<!DOCTYPE html>
<html>
<style>
#textBackground    {
    border-radius: 2px;
    background: rgba(64, 64, 64, 0.1);
    word-wrap: break-word;
}
#remove_button {
  background-color: red;
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 32px;
  width: 100%;
  border-radius: 8px;
}
#remove_button:hover    {
	background-color: #c20000;
	cursor: pointer;
}
#remove_button:active   {
    background-color: #800000;
}
#remove_button:disabled	{
	background-color: red;
	opacity: 0.5;
	cursor: not-allowed;
}
#update, #upload, #cancel, #ok, #choseButton, #userbtn {
  border: none;
  padding: 8px 16px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 25px;
  margin: 4px 2px;
  transition-duration: 0.4s;
  border-radius: 8px;
  background: none;
  cursor: pointer;
}

#update, #upload {
  border: 2px solid #4CAF50;
}

#cancel    {
  border: 2px solid red;
}

#upload, #cancel    {
    margin: 10px 50px;
}

#update:hover, #upload:hover {
  background-color: #4CAF50;
  color: white;
}

#cancel:hover {
  background-color: red;
  color: white;
}

textarea, input[type=file] {
    font-size: 25px;
}
label   {
    font-size: 25px;
}
.center {
    text-align: center;
}

#ok, #choseButton    {
    background-color: rgba(192, 192, 192, 0.25);
}

#ok:hover, #choseButton:hover    {
    background-color: rgba(224, 224, 224, 0.1);
}

/* Float cancel and delete buttons and add an equal width */
.cancelbtn, .deletebtn {
  background-color: #4CAF50;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
  opacity: 0.9;
  float: left;
  width: 50%;
  font-size: 25;
}

.cancelbtn, .deletebtn:hover {
  opacity:1;
}

/* Add a color to the cancel button */
.cancelbtn {
  background-color: #ccc;
  color: black;
}

/* Add a color to the delete button */
.deletebtn {
  background-color: #f44336;
}

/* Add padding and center-align text to the container */
.container {
  padding: 16px;
  text-align: center;
  font-size: 25;
}

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: #474e5d80;
  padding-top: 50px;
}

/* Modal Content/Box */
.modal-content {
<?php
	$modalBackgroundColour = "background-color: ";
	if(darkMode)	{
		$modalBackgroundColour .= "#010101";
	}
	else	{
		$modalBackgroundColour .= "#fefefe";
	}
	$modalBackgroundColour .= ";";
	echo $modalBackgroundColour;
?>
  margin: 5% auto 15% auto; /* 5% from the top, 15% from the bottom and centered */
  border: 1px solid #888;
  width: 80%; /* Could be more or less, depending on screen size */
}

#rounded    {
    border-radius: 25px;
}
 
/* The Modal Close Button (x) */
.close {
  position: absolute;
  right: 35px;
  top: 15px;
  font-size: 40px;
  font-weight: bold;
  color: #f1f1f1;
}

.close:hover,
.close:focus {
  color: #f44336;
  cursor: pointer;
}

/* Clear floats */
.clearfix::after {
  content: "";
  clear: both;
  display: table;
}

/* Change styles for cancel button and delete button on extra small screens */
@media screen and (max-width: 300px) {
  .cancelbtn, .deletebtn {
     width: 100%;
  }
}

#id01    {
    background-color: #FF000080;
}

#choseButton	{
	border: 2px solid #A0A0A0;
}

#draganddrop	{
	transition: background-color 0.25s ease;
	padding: 150px;
	text-align: center;
	border: 2px dashed #808080;
	border-radius: 8px;
	font-size: 32;
	background-color: rgba(208, 208, 208, 0.25);
}

.preview	{
	max-width: 100vw;
	max-height: 50vh;
}

#reactLines	{
	background-image: linear-gradient(red, green, blue);
	height: 16px;
	border-radius: 8px;
	style: display:inline;
}

#userbtn	{
	border: 2px solid #4000ff;
	font-size: 32;
}
#userbtn:hover	{
	background-color: #4000ff;
	color: white;
}
#userbtn span	{
	cursor: pointer;
	display: inline-block;
	position: relative;
	transition: 0.25s;
}
#userbtn span:after {
	content: '\00bb';
	position: absolute;
	opacity: 0;
	top: 0;
	right: -20px;
	transition: 0.25s;
	color: white;
}
#userbtn:hover span {
	padding-right: 25px;
	color: white;
}
#userbtn:hover span:after {
	opacity: 1;
	right: 0;
	color: white;
}
.stateTitle	{
	font-size: 32px;
	text-align: center;
	color: white;
}
#yesTitle	{
	background-color: green;
}
#noTitle	{
	background-color: red;
}
#emptyTitle	{
	background-color: blue;
}
.react {
	border: none;
	text-align: center;
	text-decoration: none;
	display: inline-block;
	font-size: 64px;
	margin: 4px 4px;
	transition-duration: 0.4s;
	cursor: pointer;
	border-radius: 50%;
	width: 96px;
	height: 96px;
	background: none;
}
.react:hover {
	color: white;
}
#yes	{
	border: 2px solid green;
}
#yes:hover	{
	background-color: green;
}
#no	{
	border: 2px solid red;
}
#no:hover	{
	background-color: red;
}
#yes_label, #no_label	{
	font-size: 64px;
	cursor: pointer;
}
#yes_label	{
	color: green;
}
#no_label	{
	color: red;
}
#more {display: none;}
#more_less, #dots	{
	color: #808080;
}
</style>
</html>
<?php
define("allowDeleteTime", parse_ini_file(protectedPrivatePath . "times.ini")["uploaddeleteallowtime"]);
define("info_to_delete", "<div style=\"font-size: 2em;border: 2px dotted #808080;\">ატვირთული მასალის წაშლისთვის, ის უნდა იყოს მონიშნული როგორც <span class=\"samecolourindarkmode\" style=\"color:#ff0000;\">✕ შეუსაბამო</span> და მონიშვნიდან გასული დრო უნდა იყოს არანაკლებ " . allowDeleteTime . " წამი</div>");
define("deleteTimeInfo1", "<div style=\"font-size: 2em;background: #ff0000;color: #ffffff;text-align: center;\">წაშლა შესაძლებელი იქნება <span style=\"border: 2px solid #ffffff;background: #ffffff;color: #ff0000;\">");
define("deleteTimeInfo2", "</span> - დან</div>");
function getTime($second)  {
    $hour = floor($second / 3600);
    $minute = floor($second / 60) % 60;
    $second %= 60;
    $time = $hour . "სთ " . $minute . "წთ " . $second . "წმ";
    return $time;
}
include dirname(getcwd()) . "/protected/private/mysqli_database.php";
$n = $GLOBALS["n"];
$dbc = $GLOBALS["mysqliConnectValue"];
if(!$dbc) {
die("DATABASE CONNECTION FAILED:" .mysqli_error($dbc));
exit();
}
$dbs = mysqli_select_db($dbc, $GLOBALS["database"]["name"]);
if(!$dbs) {
die("DATABASE SELECTION FAILED:" .mysqli_error($dbc));
exit();
}
$query = "SELECT * FROM violations WHERE n = $n";
if(mysqli_query($dbc, $query))    {
$row = mysqli_fetch_array(mysqli_query($dbc, $query));
$loggedIn = (isset($GLOBALS["logged_in"]) && $GLOBALS["logged_in"]);
$notReacted = ($row["react_time"] == 0);
date_default_timezone_set("Etc/GMT-4");
$stateTime = "<br><br>" . date("Y-m-d", $row["state_time"]) . " " . date("H:i:s", $row["state_time"]);
echo "<p id=emptyTitle class=stateTitle style=display:none>მონიშნული არ არის</p>";
echo "<p id=yesTitle class=stateTitle style=display:none>✓ მონიშნულია როგორც შესაბამისი" . "<span id=statetimeyes>" . $stateTime . "</span>" . "</p>";
echo "<p id=noTitle class=stateTitle style=display:none>✕ მონიშნულია როგორც შეუსაბამო" . "<span id=statetimeno>" . $stateTime . "</span>" . "</p>";
if($row["state"] == 1)	{
	echo "<script>document.getElementById('yesTitle').style.display = '';</script>";
	echo "<span id=\"stateValue\" style=\"display:none\">1</span>";
}
else if($row["state"] == -1)	{
	echo "<script>document.getElementById('noTitle').style.display = '';</script>";
	echo "<span id=\"stateValue\" style=\"display:none\">-1</span>";
}
else	{
	echo "<script>document.getElementById(\"emptyTitle\").style.display = \"\"</script>";
	echo "<span id=\"stateValue\" style=\"display:none\">0</span>";
}
if($loggedIn && $notReacted)	{
	echo "
		<center>
		<span id=\"state_title\" style=\"font-size:36px;font-weight:bold\"></span>
		<br>
		<input type=\"submit\" class=\"react\" id=\"yes\" value=\"✓\" onclick=\"setState(1)\" style=\"display:none\">
		<label id=\"yes_label\" for=\"yes\" style=\"display:none\">შესაბამისი</label>
		<span id=\"distance\"></span>
		<input type=\"submit\" class=\"react\" id=\"no\" value=\"✕\" onclick=\"setState(0)\" style=\"display:none\">
		<label id=\"no_label\" for=\"no\" style=\"display:none\">შეუსაბამო</label>
		</center>
		<br>
		<script>
			stateNum = document.getElementById(\"stateValue\").innerHTML;
			function state(stateVal)	{
				if(stateVal == 0)	{
					document.getElementById(\"state_title\").innerHTML = \"მონიშვნა როგორც:\";
					document.getElementById(\"distance\").style.padding = \"10vw\";
				}
				else	{
					document.getElementById(\"state_title\").innerHTML = \"მონიშვნის შეცვლა:\";
				}
				if(stateVal == 0)	{
					document.getElementById(\"emptyTitle\").style.display = \"\";
				}
				else	{
					document.getElementById(\"emptyTitle\").style.display = \"none\";
				}
				if((stateVal == 0) || (stateVal == -1))	{
					document.getElementById(\"yes\").style.display = \"\";
					document.getElementById(\"yes_label\").style.display = \"\";
					if(stateVal != 0)	{
						document.getElementById(\"no\").style.display = \"none\";
						document.getElementById(\"no_label\").style.display = \"none\";
					}
				}
				if((stateVal == 0) || (stateVal == 1))	{
					document.getElementById(\"no\").style.display = \"\";
					document.getElementById(\"no_label\").style.display = \"\";
					if(stateVal != 0)	{
						document.getElementById(\"yes\").style.display = \"none\";
						document.getElementById(\"yes_label\").style.display = \"none\";
					}
				}
			}
			if(stateNum == 0)	{
				state(0);
			}
			else if(stateNum == 1)	{
				state(1);
			}
			else if(stateNum == -1)	{
				state(-1);
			}
			/*function getDateTime(unix)	{
				var t = new Date(unix * 1000);
				return (t.getFullYear() + '-' + (t.getMonth() + 1) + '-' + t.getDate() + \" \" + t.getHours() + ':' + t.getMinutes() + ':' + t.getSeconds());
			}*/
			function whenSaved()	{
				document.getElementById(\"distance\").style.padding = \"\";
				let deleteInfoElement = document.getElementById(\"infoToDelete\");
				let yesTitleElement = document.getElementById('yesTitle');
				let noTitleElement = document.getElementById('noTitle');
				if(POST_TEXT.includes(\"yes=\"))	{
					document.getElementById(\"statetimeyes\").innerHTML = \"<br><br>\" + stateTime;
					yesTitleElement.style.display = '';
					noTitleElement.style.display = 'none';
					document.getElementById(\"remove_button\").disabled = 1;
					deleteInfoElement.innerHTML = '" . info_to_delete . "';
					state(1);
				}
				else if(POST_TEXT.includes(\"no=\"))	{
					document.getElementById(\"statetimeno\").innerHTML = \"<br><br>\" + stateTime;
					noTitleElement.style.display = '';
					yesTitleElement.style.display = 'none';
					//document.getElementById(\"remove_button\").disabled = 0;
					deleteInfoElement.innerHTML = '" . deleteTimeInfo1 . "' + allowDeleteTime + '" . deleteTimeInfo2 . "';
					state(-1);
				}
			}
			function saveChanges()	{
				document.getElementById('id02').style.display='none';
				changeStates = new XMLHttpRequest();
				changeStates.onreadystatechange = function() {
					if(this.responseText.startsWith(\"1\"))    {
						stateTime = this.responseText.substring(1, this.responseText.indexOf('|'));
						allowDeleteTime = this.responseText.substring(this.responseText.indexOf('|') + 1);
						whenSaved();
					}
				};
				changeStates.open(\"POST\", \"change_states.php?\", true);
				changeStates.setRequestHeader(\"Content-Type\", \"application/x-www-form-urlencoded\");
				POST_TEXT += \"&gettime\";
				changeStates.send(POST_TEXT);
			}
			function setState(state)	{
				if(state)	{
					stateText = \"green>შესაბამისი\";
					POST_TEXT = \"no&yes=\";
				}
				else	{
					stateText = \"red>შეუსაბამო\";
					POST_TEXT = \"yes&no=\";
				}
				POST_TEXT += " . $n . " + \"|\";
				stateText = \"<font class=\\\"samecolourindarkmode\\\" color=\" + stateText + \"</font>\";
				document.getElementById(\"windowText\").innerHTML = \"<p style=font-size:32px>ატვირთული მასალა #\" + " . $n . " + \"<br>მონიშვნა როგორც \" + stateText + \"</p>\";
				okButton = document.getElementById(\"upload\");
				okButton.innerHTML = \"მონიშვნა\";
				okButton.onclick = function(){saveChanges()};
				document.getElementById('id02').style.display='block';
			}
		</script>
	";
}
$location = "";
$latitude = $row["latitude"];
$longitude = $row["longitude"];
if($row["location_time"] != 0)	{
	$location = $latitude . ", " . $longitude;
}
$accuracy = $row["accuracy"];
$address = $row["address"];
$category = $row["situation"];
$description = $row["description"];
$react = $row["react"];
$reactPath = "uploads/react_media/" . $row["react_media"];
$reactLink = "/?/" . $reactPath;
$filePath = "uploads/media/" . $row["filename"];
$path = "/?/" . $filePath;
$type = explode("/", mime_content_type(dirname(getcwd()) . "/protected/public/" . $filePath))[0];
if($type === "video")  {
    $media = "<video src=$path style=max-width:512px;max-height:512px; controls></video>";
}
else if($type === "image") {
    $media = "<img src=$path alt=$path style=max-width:512px;max-height:512px;>";
}
else {
    $media = $path;
}
$mapIframeSize = "width:750px;height:500px;";
$map = include(protectedPrivatePath . "map.php");
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
	$accuracy = "<br><hr><br>" . "<font size=25>" . "<strong>" . "მდებარეობის სიზუსტე:<br>" . "</strong>" . $accuracy . "</font>";
}
if(!empty($category))
	$category = "<strong>" . "კატეგორია: " . "</strong>" . "<br><br>" . str_replace("DELIMITER_BETWEEN_Aiip9ivope_QVEITIქვეითიSOS", "</p><p id=textBackground>", str_replace("DELIMITER_AFTER_e2QP1tyepu_QVEITIქვეითიSOS", "</b><p id=textBackground>", str_replace("DELIMITER_AFTER2_PnAogaR8vs_QVEITIქვეითიSOS", "</p>", str_replace("DELIMITER_BEFORE_qHwe31xrAO_QVEITIქვეითიSOS", "<b>", $category))));
else
	$category = "კატეგორია არ არის ატვირთული";
$category = "<br><hr><br>" . "<font size=25>" . $category . "</font>";
if(!empty($description))	{
	$l = 100;
	if(strlen($description) > $l)	{
		$description = substr_replace($description, "<span id=\"dots\">...</span><span id=\"more\">", $l, 0) . "</span><span id=\"more_less\">>></span>";
	}
	$description = "<strong>" . "აღწერა: " . "</strong>" . "<br>" . "<p id=textBackground onclick=\"readMore()\">" . $description . "</p>";
}
else
	$description = "აღწერა არ არის ატვირთული";
$description = "<br><hr><br>" . "<font size=25>" . $description . "</font>";
if(!empty($location))	{
	$location = "<strong>" . "მდებარეობის კოორდინატები:" . "</strong>" . "<br>" . $location . "<br>";
}
else	{
	$location = "მდებარეობის კოორდინატები არ არის ატვირთული";
	$accuracy = "";
	$map = "";
}
$location = "<br><hr><br>" . "<font size=25>" . $location . "</font>";
if(!empty($address))	{
	$address = "<strong>" . "მისამართი:" . "</strong>" . "<br>" . $address . "<br>";
}
else	{
	$address = "მისამართი არ არის ატვირთული";
}
$address = "<br><hr><br>" . "<font size=25>" . $address . "</font>";
date_default_timezone_set("Etc/GMT-4");
$time = $row["time"];
$time = date("Y-m-d H:i:s", $time);
$time = "<br>" . "<font size=25>" . "<strong>" . "ატვირთვის დრო და თარიღი: " . "</strong>" . $time . "</font>";
$echo = '';
if($loggedIn)	{
	$stateIsNo = ($row["state"] == -1);
	$isDeleteTime = ((time() - $row["state_time"]) >= allowDeleteTime);
	$deleteEnable = false;
	include(protectedPrivatePath . "checkAccountPermission.php");
	$reactPermission = getAccountPermission("react", $_SESSION["account_id"]);
	$deletePermission = getAccountPermission("delete", $_SESSION["account_id"]);
	if(!$reactPermission)	{
		$echo .= "<div class=\"noPermissionNotice\">თქვენს ანგარიშს არ აქვს რეაგირების შესახებ მონაცემების ატვირთვის ნებართვა</div><br>";
	}
	if(!$reactPermission || !$deletePermission)	{
		echo "<style>.noPermissionNotice{font-size:32px;text-align:center;border:2px solid #ff0000;}</style>";
	}
}
if($notReacted)    {
	$echo .= "<span style=\"font-size:25;\">რეაგირების შესახებ მონაცემები არ არის ატვირთული</span><br><hr style=\"border:2px dotted;\"><br>";
	if($loggedIn)	{
		$reactForm = "<span id=reactElement>" . "<form style=display:inline method=post enctype=multipart/form-data id=react_submit>" . "<label><span class=\"samecolourindarkmode\" style=\"color:red;\">*</span>ტექსტი: </label><br><br>" . "<textarea style=\"resize:none;width:100%;height:30%;\" name=text id=text placeholder=ჩაწერეთ&nbspტექსტი></textarea>" . "<br><br><label><span class=\"samecolourindarkmode\" style=\"color:red;\">*</span>ფაილი: <span id=fileName></span></label><br><br>" . "<span id=preview></span><br>" . "<label for=media id=choseButton>ფაილის არჩევა</label>" . "<input type=file name=media id=media value=media style=display:none>" . "<input type=hidden name=n value=$n>" . "</form>" . "<br><span style=font-size:36;>ან</span><br>" . "<p id=draganddrop>ჩააგდეთ ფაილი</p>" . "<br>" . "<center><button onclick=confirmreact() id=update>დასტური</button></center>" . "</span>";
		if(!$reactPermission)	{
			$reactForm = "<div style=\"position:relative;\"><div style=\"position:absolute;z-index:1;width:100%;height:100%;background:rgba(255, 0, 0, 0.25);cursor:not-allowed;\"></div>" . $reactForm . "</div>";
		}
		$echo .= $reactForm;
		if(($row["state"] == -1) && $stateIsNo && $isDeleteTime && $deletePermission)	{
			$deleteEnable = true;
		}
	}
}
else    {
    $type = explode("/", mime_content_type(dirname(getcwd()) . "/protected/public/" . $reactPath))[0];
    if($type === "video")  {
        $reactMedia = "<video src=$reactLink style=max-width:512px;max-height:512px; controls></video>";
    }
    else if($type === "image") {
        $reactMedia = "<img src=$reactLink style=max-width:512px;max-height:512px;>";
    }
    else   {
        $reactMedia = "<a style=font-size:32px target=_blank href = $reactLink>რეაგირების ფაილის გახსნა</a>";
    }
    $echo .= "<font size=25>შევსებულია</font><br><br>" . "<div id=textbackground>" . "<font size=25>" . $react . "</font>" . "</div>" . "<br>" . $reactMedia;
}
$react = "<font size=32>" . "<strong>რეაგირება</strong> (რეაგირების შესახებ ინფორმაცია უნდა შეიცავდეს ტექსტსაც და ფაილსაც)" . "</font>" . "<br><br><hr id=reactLines><br><br>" . $echo . "<br><br><hr id=reactLines><br><br>" . "</font>"; 
//$delete_url = weblink . "/delete.php?n=" . $n;
$soundLink = $row["sound_name"];
if(!empty($soundLink))	{
	$soundLink = "/?/uploads/sound/" . $soundLink;
	$sound = "<audio controls src=" . $soundLink . "></audio>";
	$sound = "<strong>" . "ხმოვანი აღწერა:" . "</strong>" . "<br>" . $sound;
}
else	{
	$sound = "ხმოვანი აღწერა არ არის ატვირთული";
}
$sound = "<br><hr><br>" . "<font size=25>" . $sound . "</font>";
$userID = $row["user_id"];
$GLOBALS["user_id"] = $userID;
if($userID == 0)	{
	$userID = "<font size=25>" . "ატვირთულია არარეგისტრირებული (ანონიმური) მომხმარებლის მიერ" . "</font>";
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
	$userimage = "<img src=$userimage alt=$userimage style=max-width:256px;max-height:256px;>";
	$accountdatetime = $user["time_created"];
	$accountdatetime = date("Y-m-d", $accountdatetime) . " " . date("H:i:s", $accountdatetime);
	$userID = "<font size=25>" . "<strong>" . "ანგარიშის რიგითი ნომერი: " . "</strong>" . $userID . "</font>";
	$username = "<br><hr><br>" . "<font size=25>" . "<strong>" . "ანგარიშის სახელი: " . "</strong>" . $username . "</font>";
	$accountdatetime = "<br><hr><br>" . "<font size=25>" . "<strong>" . "ანგარიშის შექმნის დრო და თარიღი: " . "</strong>" . $accountdatetime . "</font>";
	if(empty($name))	{
		$name = "<font color=#808080>" . "სახელი" . "</font>";
	}
	$name = "<font size=25>" . $name . "</font>";
	$userImageAndName = "<br><hr><br>" . "<strong>" . "<font size=25>" . "ანგარიშის სურათი და სახელი:" . "</font>" . "</strong>" . "<br><br>" . "<center>" . $userimage . " " . $name . "</center>";
	$userButton = "<br><hr><br>" . "<center>" . "<button type=button id=userbtn><span>ანგარიშის ნახვა</span></button>" . "</center>";
}
function getDateTime($TIME, $TEXT)	{
	if(($TIME != 0) || ($TEXT === "რეაგირებისთვის საჭირო დრო"))	{
		if($TEXT === "რეაგირებისთვის საჭირო დრო")	{
			return "<br><hr><br>" . "<font size=25>" . "<strong>" . $TEXT . ":<br>" . "</strong>" . getTime($TIME) . "</font>";
		}
		else	{
			return "<br><hr><br>" . "<font size=25>" . "<strong>" . $TEXT . ":<br>" . "</strong>" . date("Y-m-d", $TIME) . " " . date("H:i:s", $TIME) . "</font>";
		}
	}
	else	{
		return "";
	}
}
$locationTime = getDateTime($row["location_time"], "მდებარეობის მონაცემების ატვირთვის დრო და თარიღი");
$soundTime = getDateTime($row["sound_time"], "ხმოვანი აღწერის ატვირთვის დრო და თარიღი");
$infoTime = getDateTime($row["info_time"], "კატეგორი(ებ)ის ან/და აღწერის ატვირთვის დრო და თარიღი");
$reactTime = getDateTime($row["react_time"], "რეაგირების დრო და თარიღი");
if($row["react_time"] != 0)	{
	$reactInterval = getDateTime($row["react_time"] - $row["time"], "რეაგირებისთვის საჭირო დრო");
}
else	{
	$reactInterval = "";
}
$altitude = $row["altitude"];
if($altitude)	{
	$altitude .= " მეტრი";
}
else	{
	$altitude = "მონაცემები არ არის";
}
$altitude = "<br><hr><br><font size=25>სიმაღლე (WGS84):<br>" . $altitude . "</font>";
$mediaPath = dirname(getcwd()) . "/protected/public/" . $filePath;
$exifDateTime = @exif_read_data($mediaPath)["DateTimeOriginal"];
$captureDateTime = "";
if($exifDateTime && isset($exifDateTime) && !empty($exifDateTime) && strtotime($exifDateTime))	{
	$captureDateTime = htmlspecialchars($exifDateTime);
	$captureDateTime = date_format(date_create($captureDateTime), "Y-m-d H:i:s");
	$captureDateTime = "<br><hr><br>" . "<font size=25>" . "<strong>" . "გადაღების დრო და თარიღი: " . "</strong>" . $captureDateTime . "</font>";
}
echo "<font size=25>" . "<strong>" . "#: " . "</strong>" . $n . "</font>" . "<br><hr><br>" . "<div class=center>" . $media . " " . $map . "</div>" . "<br><hr><br>" . $time . $captureDateTime . $location . $altitude . $accuracy . $address . $locationTime . $sound . $soundTime . $category . $description . $infoTime . "<br><hr><br>" . $react . $reactTime . $reactInterval . "<br><hr><br>" . $userID . $username . $accountdatetime . $userImageAndName . $userButton . "<br><hr><br>";
mysqli_close($dbc);
if($loggedIn)	{
	$deleteButtonHTML = "<div id=\"infoToDelete\">";
	if(!$stateIsNo)	{
		$deleteButtonHTML .= info_to_delete;
	}
	else if(!$isDeleteTime)	{
		$deleteButtonHTML .= deleteTimeInfo1 . date("Y-m-d H:i:s", $row["state_time"] + allowDeleteTime) . deleteTimeInfo2;
	}
	if(!$deletePermission)	{
		$deleteButtonHTML .= "<br><div class=\"noPermissionNotice\">თქვენს ანგარიშს არ აქვს წაშლის ნებართვა</div>";
	}
	$deleteButtonHTML .= "</div><br><button onclick=\"confirmdelete()\" id=\"remove_button\"";
	if(!$deleteEnable)    {
		$deleteButtonHTML .= " disabled";
	}
	$deleteButtonHTML .= "><img src=\"delete.png\" style=\"width:32px;height:32px;filter:grayscale(100%)invert(100%)\"> ატვირთული მასალის წაშლა</button>";
	echo $deleteButtonHTML;
}
}
else	{
	echo "MYSQLI QUERY ERROR";
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
		if(isset($GLOBALS["user_id"]))
			echo '
				userButtonElement = document.getElementById("userbtn");
				if(userButtonElement != null)	{
					userButtonElement.onclick = function()	{
						window.open("user_uploads.php?id=" + ' . $GLOBALS["user_id"] . ');
					};
				}
			';
	?>
</script>