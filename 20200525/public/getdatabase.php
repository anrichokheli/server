<title>ქვეითი SOS</title>
<head><link rel="icon" href="<?php include 'get_web_url.php' ?>/qveitiSOS.jpg"></head>
<audio hidden src="notificationsound.wav" id="notificationSound"></audio>
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
input[name="logout"]	{
  width: 100%;
}
input[name="logout"], #clear_all {
  border: 2px solid red;
}
input[name="logout"]:hover, #clear_all:hover {
  background-color: red;
  color: white;
}
.react {
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
  border-radius: 50%;
  width: 128px;
  height: 128px;
}
.react:hover {
  color: white;
}
#more	{
	border: 2px solid blue;
}
#more:hover	{
	background-color: blue;
}
#yes, #yes_all	{
	border: 2px solid green;
}
#yes:hover, #yes_all:hover	{
	background-color: green;
}
#no, #no_all	{
	border: 2px solid red;
}
#no:hover, #no_all:hover	{
	background-color: red;
}
#text, #text2 {
    background-color: red;
    color: white;
    font-size: 22;
}
#save	{
	border: 2px solid #404040;
	width: auto;
}
#save:hover	{
	background-color: #404040;
	color: white;
}
#delete_chosen	{
	border: 2px solid #ff0000;
	width: auto;
}
#delete_chosen:hover	{
	background-color: #ff0000;
	color: white;
}
.row	{
	transition: background-color 0.25s ease;
}
#yesLabel, #noLabel, #yesQuantity, #noQuantity, #allLabel, #allQuantity	{
	font-size: 32px;
}
#yesLabel, #noLabel, #allLabel	{
	font-weight: bold;
}
#yesLabel	{
	color: green;
}
#noLabel	{
	color: red;
}
#yes_all, #no_all	{
	font-size: 32px;
	width: 64px;
	height: 64px;
}
#textBackground    {
    border-radius: 2px;
    background: rgba(64, 64, 64, 0.1);
}

.saveAndCancel    {
    background-color: rgba(192, 192, 192, 0.25);
    color: black;
}

.saveAndCancel:hover    {
    background-color: rgba(224, 224, 224, 0.1);
}

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

/* Float cancel and delete buttons and add an equal width */
.cancelbtn, .deletebtn {
  background-color: #4CAF50;
  color: white;
  padding: 10px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
  opacity: 0.9;
  float: left;
  width: 50%;
  font-size: 25;
}

.cancelbtn:hover {
  opacity:1;
}

/* Add padding and center-align text to the container */
.container {
  padding: 16px;
  text-align: center;
  font-size: 25;
}

/* The Modal (background) */

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

#greenRow	{
	background-color: rgba(0, 255, 0, 0.75);
}
#redRow	{
	background-color: rgba(255, 0, 0, 0.75);
}
#saveInfoText	{
	background-color: #4000ff;
	color: white;
	font-size: 22;
	text-align: center;
	font-weight: bold;
}
	#yesFilterButton span, #noFilterButton span, #individualViewButton span	{
		cursor: pointer;
		display: inline-block;
		position: relative;
		transition: 0.25s;
		color: black;
	}
	#yesFilterButton span:after, #noFilterButton span:after, #individualViewButton span:after {
		content: '\00bb';
		position: absolute;
		opacity: 0;
		top: 0;
		right: -20px;
		transition: 0.25s;
		color: white;
	}
	#yesFilterButton:hover span, #noFilterButton:hover span, #individualViewButton:hover span {
		padding-right: 25px;
		color: white;
	}
	#yesFilterButton:hover span:after, #noFilterButton:hover span:after, #individualViewButton:hover span:after {
		opacity: 1;
		right: 0;
		color: white;
	}
	#yesFilterButton	{
		border: 2px solid green;
	}
	#yesFilterButton:hover	{
		background-color: green;
	}
	#noFilterButton	{
		border: 2px solid red;
	}
	#noFilterButton:hover	{
		background-color: red;
	}
	#individualViewButton	{
		border: 2px solid blue;
	}
	#individualViewButton:hover	{
		background-color: blue;
	}
#delete:hover img	{
	filter: grayscale(100%) invert(100%);
}
.remove_button {
  background-color: red;
  border: none;
  color: white;
  padding: 11px 22px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 22px;
  border-radius: 8px;
}
.remove_button:hover    {
    background-color: #c20000;
}
.remove_button:active   {
    opacity: 0.5;
}
#id01    {
    background-color: #FF000080;
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
.red_and_white	{
	color:#ffffff;
	background-color:#ff0000;
	font-weight:bold;
}
#del, #del_all	{
	border: 2px solid red;
}
#del img, #del_all img	{
	transition-duration: 0.4s;
}
#del img	{
	width: 96px;
	height: 96px;
}
#del_all img	{
	transition-duration: 0.4s;
	width: 32px;
	height: 32px;
}
#del:hover, #del_all:hover	{
	background-color: red;
}
#del img:hover, #del_all img:hover	{
	filter: grayscale(100%) invert(100%);
}
#del_all	{
	width: 64px;
	height: 64px;
}
 </style>
</head>
<body>
<table>
<tr>
    <th>#</th>
    <th>ფოტო/ვიდეო</th> 
    <th>ატვირთვის დრო და თარიღი</th> 
    <th>მეტი</th>
    <?php
        $logged_in = (isset($_SESSION["qveitisosreactloggedin"]) && $_SESSION["qveitisosreactloggedin"] === true);
	if(defined("deleteMode") && $logged_in)	{
		echo "<p style=\"text-align:center;font-size:48px;font-weight:bold;color:#ffffff;background-color:#ff0000;padding:2px;\"><img src=\"delete.png\" style=\"width:64px;height:64px;filter:grayscale(100%)invert(100%)\"> ატვირთული მასალ(ებ)ის წაშლა</center></p>";
	}
	else if(!isset($user))	{
		echo "
			<center>
			<button type=\"button\" id=\"individualViewButton\" class=\"button\" onclick=openURL(\"individual.php\")><span>↔↕ ატვირთულების სათითაოდ ნახვა</span></button>
			<br>
			<button type=\"button\" id=\"yesFilterButton\" class=\"button\" onclick=openURL(\"filtered.php?mode=yes\")><span>✓ მონიშნულები როგორც შესაბამისი</span></button>
			<button type=\"button\" id=\"noFilterButton\" class=\"button\" onclick=openURL(\"filtered.php?mode=no\")><span>✕ მონიშნულები როგორც შეუსაბამო</span></button>
			</center>
			<script>
				function openURL(URL)	{
					window.open(URL);
				}
			</script>
		";
	}
        if($logged_in)	{
		if(defined("deleteMode"))	{
			echo "<th>წაშლა</th>";
		}
		else if(!defined("yesMode") && !defined("noMode"))	{
			echo "<th>შესაბამისი ან შეუსაბამო</th>";
		}
		else	{
			echo "<th>მონიშვნის შეცვლა</th>";
		}
	}
    ?>
</tr>
<?php
$database = parse_ini_file(dirname(getcwd()) . "/private/database.ini");
$conn = mysqli_connect($database["host"], $database["username"], $database["password"], $database["name"]);
if(!isset($user))	{
?>
<p id="devices"></p>
<p id="text"></p>
<p id="text2"></p>
<?php
	$reactDisabledAndDisplayAll = (!$logged_in && !defined("yesMode") && !defined("noMode"));
	if($reactDisabledAndDisplayAll)	{
		echo"
			<script>
				document.getElementById(\"individualViewButton\").onclick = function(){openURL(\"individual.php?display=all\")};
				textElement = document.getElementById(\"text2\");
				textElement.innerHTML = \"<center>ყველა</center>\";
				textElement.style.backgroundColor = \"blue\";
			</script>
		";
	}
	if($logged_in)	{
	?>
		<?php
		if(defined("noMode") || defined("deleteMode"))	{
		?>
			<script>
				function multipleDelete(a)	{
					document.getElementById('id01').style.display='none';
					if(!a)	{
						window.open("delete_multiple.php");
					}
					else	{
						window.open("delete.php?n=" + NO_ID, "_self");
					}
				}
			</script>
			<div id="id01" class="modal">
			  <span onclick="document.getElementById('id01').style.display='none'" class="close" title="დახურვა">×</span>
			  <div class="modal-content">
			    <div class="container">
			      <h1><span style="color:#ff0000">
				<?php
				if(defined("noMode"))	{
				?>
					გაფრთხილება!
				<?php
				}
				else if(defined("deleteMode"))	{
				?>
					წაშლა
				<?php
				}
				?>
			      </span></h1>
				<?php
				if(!defined("deleteMode"))	{
				?>
			      		<p class="red_and_white">ატვირთული მასალის წაშლა უნდა მოხდეს მხოლოდ იმ შემთხვევაში, თუ ის არის შეუსაბამო ან/და ატვირთულია სერვერის გავსების, მუშაობის შეფერხების მიზნით
			      		</p>
			      		<p class="red_and_white">წაშლის დაწყების შემთხვევაში, შესაძლებელი იქნება <u>1-ზე მეტი</u> მასალის წაშლაც
			      		</p>
				<?php
				}
				else	{
				?>
					<div id="allDeleteRow"></div>
				<?php
				}
				?>
			      <div class="clearfix">
			        <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">გაუქმება</button>
			        <button type="button" class="deletebtn"
					<?php
					if(!defined("deleteMode"))	{
					?>
						onclick="multipleDelete()">
						წაშლის დაწყება
					<?php
					}
					else	{
					?>
						onclick="multipleDelete(1)">
						წაშლის გაგრძელება
					<?php
					}
					?>
				</button>
			      </div>
			    </div>
			  </div>
			</div>
			<?php
			if(defined("noMode"))	{
			?>
				<audio hidden src="warningsound.wav" id="warningSound"></audio>
				<center>
				<button onclick="document.getElementById('id01').style.display='block';document.getElementById('warningSound').play();" class="remove_button"><img src="delete.png" style="width:22px;height:22px;filter:grayscale(100%)invert(100%)"> ატვირთული მასალ(ებ)ის წაშლა</button>
				</center>
			<?php
			}
			?>
		<?php
		}
		?>
		<p id="saveInfoText"></p>
		<div id="after_selected" style="display:none">
			<center>
				<p id="textBackground">
					<label id="allLabel">შებრუნებული მონიშვნა: </label>
					<span style="padding:2px"></span>
					<?php
					if(defined("yesMode"))	{
					?>
						<input type="submit" class="react" id="no_all" value="✕" onclick="noAll()">
					<?php
					}
					else if(defined("noMode"))	{
					?>
						<input type="submit" class="react" id="yes_all" value="✓" onclick="yesAll()">
					<?php
					}
					else if(defined("deleteMode"))	{
					?>
						<button type="button" class="react" id="del_all" onclick="noAll()"><img src="delete.png"></button>
					<?php
					}
					?>
					<span style="padding:16px"></span>
					<input type="submit" class="button" id="clear_all" value="ყველა მონიშვნის გასუფთავება" onclick="clearAll()">
				</p>
				<br>
				<?php
				if(defined("deleteMode"))	{
				?>
					<label id="allLabel">წასაშლელად მონიშნულია: </label>
				<?php
				}
				else if(!defined("yesMode") && !defined("noMode"))	{
				?>
					<label id="yesLabel">შესაბამისი: </label><span id="yesQuantity">0</span>
					<span style="padding:16px"></span>
					<label id="noLabel">შეუსაბამო: </label><span id="noQuantity">0</span>
					<span style="padding:32px"></span>
					<label id="allLabel">სულ მონიშნულია: </label>
				<?php
				}
				else	{
				?>
					<label id="allLabel">სტატუსის შესაცვლელად მონიშნულია: </label>
				<?php
				}
				?>
				<span id="allQuantity">0</span>
				<span style="padding:32px"></span>
				<?php
				if(!defined("deleteMode"))	{
				?>
					<button type="button" class="button" id="save" onclick="openVerify()">💾 შენახვა</button>
				<?php
				}
				else	{
				?>
					<button type="button" class="button" id="delete_chosen" onclick="openVerify(1)">🗑️ წაშლა</button>
				<?php
				}
				?>
			</center>
		</div>
	<?php
	}
?>

<div id="verify" class="modal">

  <!-- Modal content -->
  <div class="modal-content" id="rounded">
    <span onclick="document.getElementById('verify').style.display='none'" class="close" title="დახურვა">×</span>
    <div class="container">
      <h1><font color="blue">ქვეითი</font> <font color="red">SOS</font></h1>
      <p><strong>ცვლილებების შენახვა</strong></p>
	<i>
		<font color="green">მწვანე</font> - შესაბამისი მასალა
		<br>
		<font color="red">წითელი</font> - შეუსაბამო მასალა
	</i>
	<div id="allRow"></div>
      <div class="clearfix">
        <button type="button" onclick="document.getElementById('verify').style.display='none'" id="cancel" class="button saveAndCancel">გაუქმება</button>
        <span style="padding:96px"></span>
        <button type="button" onclick="saveChanges()" id="saveChangesButton" class="button saveAndCancel">შენახვა</button>
      </div>
    </div>
  </div>

</div>

<script>
var modal1 = document.getElementById('verify');
var modal2 = document.getElementById('id01');
window.onclick = function(event) {
  if (event.target == modal1) {
    modal1.style.display = "none";
  }
  else if (event.target == modal2) {
    modal2.style.display = "none";
  }
}
if(Notification.permission !== 'granted')    {
    Notification.requestPermission();
}
function getTime()    {
    datetime = new Date();
    textToReturn = "";
    var hour = datetime.getHours();
    var minute = datetime.getMinutes();
    var second = datetime.getSeconds();
    var millisecond = datetime.getMilliseconds();
    if(hour < 10)    {
        textToReturn += "0";
    }
    textToReturn += hour;
    textToReturn += ":";
    if(minute < 10)    {
        textToReturn += "0";
    }
    textToReturn += minute;
    textToReturn += ":";
    if(second < 10)    {
        textToReturn += "0";
    }
    textToReturn += second;
    textToReturn += ".";
    if(millisecond < 10)    {
        textToReturn += "00";
    }
    else if(millisecond < 100)    {
        textToReturn += "0";
    }
    textToReturn += millisecond;
    return textToReturn;
}
function notification(text, number) {
    document.getElementById("text").innerHTML = "<center><strong>მონაცემთა ბაზა განახლდა! </strong>(" + getTime() + ") <i>განახლებული მონაცემების სანახავად, დააჭირეთ ვებ გვერდის განახლებას</i> (⟳)</center>";
    document.getElementById("notificationSound").play();
    if(Notification.permission === 'granted')    {
        var notify = new Notification('ქვეითი SOS', {
        body: text,
        icon: window.location.href.replace(window.location.pathname, "/qveitiSOS.jpg"),
        data: number
        });
        notify.onclick = function()    {
            if(window.location.pathname.includes("reactweb.php"))    {
                var fileName = "react";
            }
            else    {
                var fileName = "more";
            }
            window.open(window.location.protocol + "//" + window.location.hostname + "/" + fileName + ".php?n=" + notify.data);
        };
    }
}
var n;
sessionStorage.setItem("last", n);
var sound;
sessionStorage.setItem("lastsound", sound);
var locationNum;
sessionStorage.setItem("lastlocation", locationNum);
var infoNum;
sessionStorage.setItem("lastinfo", infoNum);
var lastNum;
var last;
var lastSound;
var lastLocation;
var lastInfo;
var xmlhttp;
var soundXMLHTTP;
var locationXMLHTTP;
var infoXMLHTTP;
function check() {
xmlhttp = new XMLHttpRequest();
soundXMLHTTP = new XMLHttpRequest();
locationXMLHTTP = new XMLHttpRequest();
infoXMLHTTP = new XMLHttpRequest();
xmlhttp.onreadystatechange = function() {
    if(this.responseText !== "")    {
        n = this.responseText;
    }
};
soundXMLHTTP.onreadystatechange = function() {
    if(this.responseText !== "")    {
        sound = this.responseText;
    }
};
locationXMLHTTP.onreadystatechange = function() {
    if(this.responseText !== "")    {
        locationNum = this.responseText;
    }
};
infoXMLHTTP.onreadystatechange = function() {
    if(this.responseText !== "")    {
        infoNum = this.responseText;
    }
};
last = sessionStorage.getItem("last");
if((parseInt(n) > parseInt(last)) && (n !== 'undefined') && (last !== 'undefined')) {
    notification('სურათი/ვიდეო აიტვირთა! (#' + n + ')', n);
}
lastSound = sessionStorage.getItem("lastsound");
if((parseInt(sound) > parseInt(lastSound)) && (sound !== 'undefined') && (lastSound !== 'undefined')) {
    notification('ხმოვანი აღწერა აიტვირთა! (#' + sound + ')', sound);
}
lastLocation = sessionStorage.getItem("lastlocation");
if((parseInt(locationNum) > parseInt(lastLocation)) && (locationNum !== 'undefined') && (lastLocation !== 'undefined')) {
    notification('მდებარეობა აიტვირთა! (#' + locationNum + ')', locationNum);
}
lastInfo = sessionStorage.getItem("lastinfo");
if((parseInt(infoNum) > parseInt(lastInfo)) && (infoNum !== 'undefined') && (lastInfo !== 'undefined')) {
    notification('კატეგორია ან/და აღწერა აიტვირთა! (#' + infoNum + ')', infoNum);
}
last = n;
sessionStorage.setItem("last", last);
xmlhttp.open("GET", "getnum.php", true);
xmlhttp.send();
lastSound = sound;
sessionStorage.setItem("lastsound", lastSound);
soundXMLHTTP.open("GET", "getupdatednum.php?db=sound", true);
soundXMLHTTP.send();
lastLocation = locationNum;
sessionStorage.setItem("lastlocation", lastLocation);
locationXMLHTTP.open("GET", "getupdatednum.php?db=location", true);
locationXMLHTTP.send();
lastInfo = infoNum;
sessionStorage.setItem("lastinfo", lastInfo);
infoXMLHTTP.open("GET", "getupdatednum.php?db=info", true);
infoXMLHTTP.send();
var sessions = new XMLHttpRequest();
sessions.open("GET", "sessions.php", true);
sessions.send();
var devices = new XMLHttpRequest();
devices.open("GET", "getDevicesNumber.php", true);
devices.send();
devices.onreadystatechange = function() {
    var connectedDevicesNumber = this.responseText;
    if((connectedDevicesNumber !== "") && (connectedDevicesNumber !== lastNum))    {
        document.getElementById("devices").innerHTML = "<center>რეაგირების ვებ გვერდზე სულ შესულია <mark>" + connectedDevicesNumber + "</mark> მოწყობილობა</center>";
        lastNum = connectedDevicesNumber;
    }
};
}
if(window.location.href.includes("filtered.php?mode=yes"))	{
	textElement = document.getElementById("text");
	textElement.innerHTML = "<center>✓ მონიშნულები როგორც შესაბამისი</center>";
	textElement.style.backgroundColor = "green";
}
else if(window.location.href.includes("filtered.php?mode=no"))	{
	textElement = document.getElementById("text");
	textElement.innerHTML = "<center>✕ მონიშნულები როგორც შეუსაბამო</center>";
	textElement.style.backgroundColor = "red";
}
else if(!window.location.href.includes("delete_multiple.php"))	{
	R = setInterval(check, 250);
}
</script>
<?php
}
else	{
	$userID = $_GET["id"];
	$row = mysqli_fetch_array(mysqli_query($GLOBALS["conn"], "SELECT * FROM users WHERE id LIKE '$userID'"));
	$datetime = $row["time_created"];
	date_default_timezone_set("Etc/GMT-4");
	$datetime = date("Y-m-d", $datetime) . " " . date("H:i:s", $datetime);
	$image = $row["image"];
	$name = htmlspecialchars($row["name"]);
	if(empty($image))	{
		$image = "user_icon2.png";
	}
	$image = "<img src=$image style=max-width:128px;max-height:128px;>";
	if(empty($name))	{
		$name = "<font color=#808080>" . "სახელი" . "</font>";
	}
	echo
		"<center><p style=font-size:32px>
		<strong>მომხმარებელი №" . $userID . "-ის მიერ ატვირთული მასალების ნახვა</strong>
		<br>
		<strong>ანგარიშის შექმნის დრო და თარიღი: </strong>" . $datetime . "
		<br>
		<strong>ანგარიშის სახელი: </strong><span style=background-color:#EFEFEF>" . htmlspecialchars($row["account_name"]) . "</span>
		<br>" .
		$image . " " . $name .
		"</p></center>"
	;
}
?>
<?php
if($GLOBALS["logged_in"])	{
?>
<script>
	var countYes = 0;
	var countNo = 0;
	var YES_ID = "";
	var NO_ID = "";
	function ROWS_FOR(mode)	{
		var ALL_ID = YES_ID + NO_ID;
		var ID_LIST = ALL_ID.split("|");
		var rowElement;
		var rowColor;
		for(var rowElementID = 0; rowElementID < ALL_ID.length; rowElementID++)	{
			rowElement = document.getElementById(ID_LIST[rowElementID]);
			if(rowElement == null)
				break;
			rowColor = rowElement.style.backgroundColor;
			if((rowColor != "white") && (rowColor != "#f2f2f2"))	{
				if(mode)	{
					rowElement.value = 0;
					setDefaultRowStyle(ID_LIST[rowElementID], rowElement);
				}
				else	{
					rowElement.style.opacity = 0.6;
				}
			}
		}
	}
	function setDefaultRowStyle(NUM, ROW)	{
		if(!(NUM % 2))	{
			ROW.style.backgroundColor = "white";
		}
		else	{
			ROW.style.backgroundColor = "#f2f2f2";
		}
	}
	function clearAll()	{
		ROWS_FOR(1);
		countYes = 0;
		countNo = 0;
		YES_ID = "";
		NO_ID = "";
		afterSelected();
	}
	function whenSaved()	{
		document.getElementById("saveInfoText").innerHTML = "ცვლილებები შენახულია! (" + getTime() + ")<br>" + "შესაბამისი: " + countYes + "<span style=\"padding:64px\"></span>შეუსაბამო: " + countNo + "<span style=\"padding:64px\"></span>სულ: " + (countYes + countNo);
		ROWS_FOR(0);
	}
	function saveChanges()	{
		changeStates = new XMLHttpRequest();
		changeStates.onreadystatechange = function() {
			if(this.responseText === "1")    {
				document.getElementById('verify').style.display='none';
				whenSaved();
			}
		};
		changeStates.open("POST", "change_states.php?", true);
		changeStates.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		changeStates.send("yes=" + YES_ID + "&no=" + NO_ID);
	}
	function openVerify(DELETE_MODE)	{
		var selectedRows = document.getElementsByClassName("photovideo");
		var output = "";
		var rowID;
		var rowElement;
		for(var num = 0; num < selectedRows.length; num++)	{
			rowID = selectedRows[num].id;
			rowElement = document.getElementById(rowID);
			rowColor = rowElement.style.backgroundColor;
			if((rowColor == "rgba(0, 255, 0, 0.5)") || (rowColor == "rgba(255, 0, 0, 0.5)"))	{
				output += "<p id=";
				if(rowColor == "rgba(0, 255, 0, 0.5)")	{
					output += "green";
				}
				else if(rowColor == "rgba(255, 0, 0, 0.5)")	{
					output += "red";
				}
				output += "Row>" + "<span style=\"font-size:64px;background-color:#ffffff\">#" + rowID + "</span><br>" + selectedRows[num].innerHTML + "</p>" + "<br><hr><br>";
			}
		}
		if(!DELETE_MODE)	{
			document.getElementById("allRow").innerHTML = output;
			document.getElementById('verify').style.display='block';
		}
		else	{
			document.getElementById("allDeleteRow").innerHTML = output;
			document.getElementById('id01').style.display='block';
		}
	}
	function afterSelected()	{
		var afterSelected = document.getElementById("after_selected");
		if((countYes > 0) || (countNo > 0))	{
			if(afterSelected.style.display == 'none')	{
				afterSelected.style.display = '';
			}
			if(yesQuantityElement != null)
				yesQuantityElement.innerHTML = countYes;
			if(noQuantityElement != null)
				noQuantityElement.innerHTML = countNo;
			document.getElementById("allQuantity").innerHTML = countYes + countNo;
		}
		else	{
			afterSelected.style.display = 'none';
		}
	}
	function setRow(n, state)	{
		var DB_ROW = document.getElementById(n);
		yesQuantityElement = document.getElementById("yesQuantity");
		noQuantityElement = document.getElementById("noQuantity");
		if((DB_ROW.value == 0) || (DB_ROW.value === undefined))	{
			if(state == '+')	{
				DB_ROW.style.backgroundColor = "rgba(0, 255, 0, 0.5)";
				++countYes;
				YES_ID += DB_ROW.id + '|';
			}
			else if(state == '-')	{
				DB_ROW.style.backgroundColor = "rgba(255, 0, 0, 0.5)";
				++countNo;
				NO_ID += DB_ROW.id + '|';
			}
			DB_ROW.value = state;
		}
		else	{
			setDefaultRowStyle(n, DB_ROW);
			if(DB_ROW.value == '+')	{
				--countYes;
				YES_ID = YES_ID.replace(DB_ROW.id + '|', "");
			}
			else if(DB_ROW.value == '-')	{
				--countNo;
				NO_ID = NO_ID.replace(DB_ROW.id + '|', "");
			}
			DB_ROW.value = 0;
		}
		afterSelected();
	}
	function yes(N)	{
		setRow(N, '+');
	}
	function no(N)	{
		setRow(N, '-');
	}
	function setAll(character)	{
		var rows = document.getElementsByClassName("row");
		for(var index = 0; index < rows.length; index++)	{
			setRow(rows[index].id, character);
		}
	}
	function yesAll()	{
		setAll('+');
	}
	function noAll()	{
		setAll('-');
	}
</script>
<?php
}
?>
<?php
define ('weblink', include 'get_web_url.php');
$conn = $GLOBALS["conn"];
  // Check connection
  if ($conn->connect_error) {
   die("Connection failed: " . $conn->connect_error);
  } 
  $sql = "SELECT * FROM violations";
  if(isset($GLOBALS["userID"]))	{
  	$sql .= " WHERE user_id = " . $GLOBALS["userID"];
  }
  $result = $conn->query($sql);
  if(!empty($result))  {
  if ($result->num_rows > 0) {
	while($row0 = $result->fetch_assoc())	{
		$items[] = $row0;
	}
	$items = array_reverse($items);
	if(isset($GLOBALS["userID"]))	{
		echo "<center><p style=font-size:32px>" . "<strong>ატვირთულ მასალათა რაოდენობა: </strong>" . count($items) . "</p></center>";
	}
   // output data of each row
   foreach($items as $row) {
        $time = $row["time"];
        $reactTime = $row["react_time"];
       $link = $row["link"];
       $type = explode("/", mime_content_type(str_replace("http://" . $_SERVER['HTTP_HOST'] . "/media/", getcwd() . trim("/media/ "), $link)))[0];
       if($type === "video")  {
        $media = "<video src=$link style=max-width:480px;max-height:320px; controls autoplay loop muted></video>";
       }
       else if($type === "image") {
        /*$list = explode("/", $link);
        $name = $list[4];
        $list2 = explode("_", $name);
        $name2 = $list2[2];
        $link = $list[0] . "/" . $list[1] . "/" . $list[2] . "/" . $list[3] . "/" . $name2;*/
        $media = "<img src=$link alt=$link style=max-width:480px;max-height:320px;>";
       }
       else {
           $media = $link;
       }
       $react = $row["react"];
       $reactLink = $row["react_media"];
       $value = $row["n"];
       $location = $row["location"];
       $accuracy = $row["accuracy"];
       $category = $row["situation"];
       $description = $row["description"];
       $loggedIn = $GLOBALS["logged_in"];
	if($loggedIn)	{
		$phpFileName = "react";
	}
	else	{
		$phpFileName = "more";
	}
       $url = weblink . "/" . $phpFileName . ".php?n=" . $value;
    date_default_timezone_set("Etc/GMT-4");
    $time = date("Y-m-d", $row["time"]) . "<br>" . date("H:i:s", $row["time"]);
    $time = "<font size=25>" . $time . "</font>";
    if(((empty($react) && empty($reactLink)) && ((($row["state"] == 0) && !defined("yesMode") && !defined("noMode") && !defined("deleteMode")) || (($row["state"] == 1) && defined("yesMode")) || (($row["state"] == -1) && (defined("noMode") || defined("deleteMode"))))) || (!isset($user) && $reactDisabledAndDisplayAll) || isset($user))    {
	if($loggedIn && !defined("deleteMode"))	{
		if(!defined("yesMode"))	{
			$yesButton = "<input type=submit class=react id=yes value=✓ onclick=yes($value)>";
		}
		else	{
			$yesButton = "";
		}
		if(!defined("noMode"))	{
			$noButton = "<input type=submit class=react id=no value=✕ onclick=no($value)>";
			$deleteButton = "";
		}
		else	{
			$noButton = "";
		}
		$YesNoButtons = "</td><td>" . $yesButton . $noButton;
	}
	else	{
		$YesNoButtons = "";
	}
	if(defined("deleteMode"))	{
		$deleteButton = "</td><td>" . "<button type=\"button\" class=\"react\" id=\"del\" onclick=\"setRow($value, '-')\"><img src=\"delete.png\"></button>";
	}
	else	{
		$deleteButton = "";
	}
        echo "<tr class=row id=$value><td>" . "<font size=25>" . $value . "</font>" . "</td><td class=photovideo id=$value>" . $media . "</td><td>" . $time . "\t" . "</td><td>" . "<a href=$url target=_blank>" . "<input type=submit class=react id=more value=»>" . "</a>" . $YesNoButtons . $deleteButton . "</td></tr>";
    }
}
echo "</table>";
}
else if(isset($GLOBALS["userID"]))	{
	echo "<center><p style=font-size:32><strong>ამ მომხმარებელს არცერთი მასალა არ აქვს ატვირთული</strong></p></center>";
}
}
$conn->close();
?>