<title>ქვეითი SOS</title>
<head><link rel="icon" href="<?php include 'get_web_url.php' ?>/qveitiSOS.jpg"></head>
<?php
$returnMode = 1;
$dataExists = include 'check_n.php';
if($dataExists)    {
?>
<!DOCTYPE html>
<html>
<style>
#textBackground    {
    border-radius: 2px;
    background: rgba(64, 64, 64, 0.1);
}
.remove_button {
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
.remove_button:hover    {
    background-color: #c20000;
}
.remove_button:active   {
    opacity: 0.5;
}

#update, #upload, #cancel, #ok, #choseButton, #userbtn {
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
  border-radius: 8px;
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

input[type=text], input[type=file] {
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
  background-color: #fefefe;
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
	color: black;
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
	color: white;
	text-align: center;
	text-decoration: none;
	display: inline-block;
	font-size: 64px;
	margin: 4px 4px;
	transition-duration: 0.4s;
	cursor: pointer;
	background-color: white; 
	color: black; 
	border-radius: 50%;
	width: 96px;
	height: 96px;
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
}
#yes_label	{
	color: green;
}
#no_label	{
	color: red;
}
</style>
</html>
<?php
function getTime($second)  {
    $hour = floor($second / 3600);
    $minute = floor($second / 60) % 60;
    $second %= 60;
    $time = $hour . "სთ " . $minute . "წთ " . $second . "წმ";
    return $time;
}
function code() {
$n = $_GET["n"];
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
$query = "SELECT * FROM violations WHERE n = $n";
if(mysqli_query($dbc, $query))    {
$row = mysqli_fetch_array(mysqli_query($dbc, $query));
$loggedInAndNotReacted = (isset($GLOBALS["logged_in"]) && $GLOBALS["logged_in"] && empty($row["react"]) && empty($row["react_media"]));
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
if($loggedInAndNotReacted)	{
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
			function whenSaved()	{
				document.getElementById(\"distance\").style.padding = \"\";
				if(POST_TEXT.includes(\"yes=\"))	{
					document.getElementById(\"statetimeyes\").innerHTML = stateTime;
					document.getElementById('yesTitle').style.display = '';
					document.getElementById('noTitle').style.display = 'none';
					state(1);
				}
				else if(POST_TEXT.includes(\"no=\"))	{
					document.getElementById(\"statetimeno\").innerHTML = stateTime;
					document.getElementById('noTitle').style.display = '';
					document.getElementById('yesTitle').style.display = 'none';
					state(-1);
				}
			}
			function saveChanges()	{
				document.getElementById('id02').style.display='none';
				changeStates = new XMLHttpRequest();
				changeStates.onreadystatechange = function() {
					if(this.responseText.startsWith(\"1\"))    {
						stateTime = this.responseText.substring(1);
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
					stateText = \"<font color=green>შესაბამისი\";
					POST_TEXT = \"no&yes=\" + " . $n . " + \"|\";
				}
				else	{
					stateText = \"<font color=red>შეუსაბამო\";
					POST_TEXT = \"yes&no=\" + " . $n . " + \"|\";
				}
				stateText += \"</font>\";
				document.getElementById(\"windowText\").innerHTML = \"<p style=font-size:32px>ატვირთული მასალა #\" + " . $n . " + \"<br>მონიშვნა როგორც \" + stateText + \"</p>\";
				okButton = document.getElementById(\"upload\");
				okButton.innerHTML = \"მონიშვნა\";
				okButton.onclick = function(){saveChanges()};
				document.getElementById('id02').style.display='block';
			}
		</script>
	";
}
$location = htmlspecialchars($row["location"]);
$accuracy = $row["accuracy"];
$address = htmlspecialchars($row["address"]);
$category = htmlspecialchars($row["situation"]);
$description = nl2br(htmlspecialchars($row["description"]));
$react = htmlspecialchars($row["react"]);
$reactLink = $row["react_media"];
$link = $row["link"];
$type = explode("/", mime_content_type(str_replace("http://" . $_SERVER['HTTP_HOST'] . "/media/", getcwd() . trim("/media/ "), $link)))[0];
if($type === "video")  {
    $media = "<video src=$link style=max-width:512px;max-height:512px; controls></video>";
}
else if($type === "image") {
    $media = "<img src=$link alt=$link style=max-width:512px;max-height:512px;>";
}
else {
    $media = $link;
}
$MAP_API_KEY = parse_ini_file(dirname(getcwd()) . "/private/apikey.ini")["google_map"];
$map = "<iframe src=https://www.google.com/maps/embed/v1/place?key=" . "$MAP_API_KEY" . "&q=" . str_replace(' ', '%20', $location) . " style=width:750px;height:500px;></iframe>";
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
if(!empty($description))
	$description = "<strong>" . "აღწერა: " . "</strong>" . "<br>" . "<p id=textBackground>" . $description . "</p>";
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
$time = date("Y-m-d", $time) . "    " . date("H:i:s", $time);
$time = "<br>" . "<font size=25>" . "<strong>" . "ატვირთვის დრო და თარიღი: " . "</strong>" . $time . "</font>";
$deleteEnable = false;
if(empty($react) && empty($reactLink))    {
	if(isset($GLOBALS["logged_in"]) && $GLOBALS["logged_in"])	{
		$echo = "<span id=reactElement>" . "<form style=display:inline method=post enctype=multipart/form-data id=react_submit>" . "<label><font color=red>*</font>ტექსტი: </label>" . "<input type=text name=text id=text placeholder=ჩაწერეთ&nbspტექსტი required>" . "<br><br><label><font color=red>*</font>ფაილი: <span id=fileName></span></label><br><br>" . "<span id=preview></span><br>" . "<label for=media id=choseButton>ფაილის არჩევა</label>" . "<input type=file name=media id=media value=media style=display:none>" . "<input type=hidden name=n value=$n>" . "</form>" . "<br><span style=font-size:36;>ან</span><br>" . "<p id=draganddrop>ჩააგდეთ ფაილი</p>" . "<br>" . "<center><button onclick=confirmreact() id=update>დასტური</button></center>" . "</span>";
		if($row["state"] != 1)	{
			$deleteEnable = true;
		}
	}
	else	{
		$echo = "<font size=25>რეაგირების შესახებ მონაცემები არ არის ატვირთული</font>";
	}
}
else    {
    $type = explode("/", mime_content_type(str_replace("http://" . $_SERVER['HTTP_HOST'] . "/react_media/", getcwd() . trim("/react_media/ "), $reactLink)))[0];
    if($type === "video")  {
        $reactMedia = "<video src=$reactLink style=max-width:512px;max-height:512px; controls></video>";
    }
    else if($type === "image") {
        $reactMedia = "<img src=$reactLink style=max-width:512px;max-height:512px;>";
    }
    else   {
        $reactMedia = "<a style=font-size:32px target=_blank href = $reactLink>რეაგირების ფაილის გახსნა</a>";
    }
    $echo = "<font size=25>შევსებულია</font><br><br>" . "<div id=textbackground>" . "<font size=25>" . $react . "</font>" . "</div>" . "<br>" . $reactMedia;
}
$react = "<font size=32>" . "<strong>რეაგირება</strong> (რეაგირების შესახებ ინფორმაცია უნდა შეიცავდეს ტექსტსაც და ფაილსაც)" . "</font>" . "<br><br><hr id=reactLines><br><br>" . $echo . "<br><br><hr id=reactLines><br><br>" . "</font>"; 
$delete_url = weblink . "/delete.php?n=" . $n;
$soundLink = $row["sound_link"];
if(!empty($soundLink))	{
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
	$name = htmlspecialchars($user["name"]);
	$userimage = htmlspecialchars($user["image"]);
	if(empty($userimage))	{
		$userimage = "user_icon2.png";
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
echo "<font size=25>" . "<strong>" . "#: " . "</strong>" . $n . "</font>" . "<br><hr><br>" . $time . "<br><hr><br>" . "<div class=center>" . $media . " " . $map . "</div>" . $location . $accuracy . $address . $locationTime . $sound . $soundTime . $category . $description . $infoTime . "<br><hr><br>" . $react . $reactTime . $reactInterval . "<br><hr><br>" . $userID . $username . $accountdatetime . $userImageAndName . $userButton . "<br><hr><br>";
mysqli_close($dbc);
}
if($deleteEnable)    {
    ?>
    <button onclick="confirmdelete()" class="remove_button"><img src="delete.png" style="width:32px;height:32px;filter:grayscale(100%)invert(100%)"> ატვირთული მასალის წაშლა</button>
    <?php
}
}
$database = parse_ini_file(dirname(getcwd()) . "/private/database.ini");
define ('weblink', include 'get_web_url.php');
define ('dbuser', $database["username"]);
define ('dbpw', $database["password"]);
define ('dbhost', $database["host"]);
define ('dbname', $database["name"]);
code();
?>
<?php
}
else	{
	echo "<center>" . "<br>" . "<font size=25>#" . $_GET["n"] . "</font>" . "<br><br>" . "<img src=no_data.png>" . "<br><br>" . "<strong>" . "<font size=25 color=red>" . "მონაცემები არ არის" . "</font>" . "</strong>" . "</center>";
}
?>
<script>
	userButtonElement = document.getElementById("userbtn");
	if(userButtonElement != null)	{
		userButtonElement.onclick = function()	{
			window.open("user_uploads.php?id=" + <?php echo $GLOBALS["user_id"]; ?>);
		};
	}
</script>