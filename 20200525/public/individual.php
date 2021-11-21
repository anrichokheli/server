<?php
session_start();
$logged_in = (isset($_SESSION["qveitisosreactloggedin"]) && $_SESSION["qveitisosreactloggedin"] === true);
if(!$logged_in)    {
	session_destroy();
}
?>
<title>ქვეითი SOS</title>
<head><link rel="icon" href="<?php include 'get_web_url.php' ?>/qveitiSOS.jpg"></head>
<?php
$database = parse_ini_file(dirname(getcwd()) . "/private/database.ini");
$dbc = mysqli_connect($database["host"], $database["username"], $database["password"], $database["name"]);
$query = "SELECT * FROM violations";
$result = mysqli_query($dbc, $query);
if($result)	{
	echo "<span id=allelement style=display:none>";
	foreach($result as $row)	{
		if((($row["state"] == 0) && (empty($row["react"]) && empty($row["react_media"]))) || ($_GET["display"] == "all"))	{
			$N = $row["n"];
			$link = $row["link"];
			$type = explode("/", mime_content_type(str_replace("http://" . $_SERVER['HTTP_HOST'] . "/media/", getcwd() . trim("/media/ "), $link)))[0];
			if($type === "video")	{
				$element = "<video src=" . $link . " style=width:90%;height:75%; muted autoplay controls loop></video>";
			}
			else if($type === "image")	{
				$element = "<img src=" . $link . " style=max-width:90vw;max-height:75vh;>";
			}
			$element = "<center>" . "<span style=font-size:30px;background-color:#ffffff>" . '#' . $N . "</span>" . "<br>" . $element . "</center>";
			echo "<a class=media id=" . $N . ">" . $element . "</a>";
		}
	}
	echo "</span>";
}
mysqli_close($dbc);
?>
<style>
.buttons	{
	border: none;
	color: white;
	padding: 4px 16px;
	text-align: center;
	text-decoration: none;
	display: inline-block;
	font-size: 18px;
	margin: 4px 2px;
	transition-duration: 0.25s;
	cursor: pointer;
	background-color: rgb(224, 224, 224); 
	color: black; 
	border-radius: 8px;
}
.buttons:hover	{
	background-color: rgb(248, 248, 248);
}
#infoTitle	{
	background-color: white;
	font-size: 20;
	font-weight: bold;
}
</style>
<center>
	<input type="checkbox" id="keyboardEnable" checked>
	<label for="keyboardEnable">კლავიატურით მართვა</label>
	<br>
	<button type="button" class="buttons" id="previousButton" onclick="next_previous(0)">← წინა</button>
	<button type="button" class="buttons" id="nextButton" onclick="next_previous(1)">→ შემდეგი</button>
	<?php
	if($logged_in)	{
	?>
		<button type="button" class="buttons" id="yesButton" onclick="setStatus(1)">⏎ მონიშვნა როგორც შესაბამისი</button>
		<button type="button" class="buttons" id="noButton" onclick="setStatus(0)">␠ მონიშვნა როგორც შეუსაბამო</button>
		<button type="button" class="buttons" id="clearButton" onclick="clearStatus()">␛ მონიშნულის გაუქმება</button>
	<?php
	}
	?>
	<br>
	<span id="nums" style="font-size:20px;background-color:#ffffff"></span>
	<br>
	<span id="infoTitle"></span>
</center>
<span id="imagevideo"></span>
<script>
	var keyPressed = 0;
	var lastReceived;
	var n = 0;
	var elements = document.getElementsByClassName("media");
	buttonsArray = document.getElementsByClassName("buttons");
	if(elements.length > 0)	{
		document.getElementById("nums").innerHTML = (n + 1) + " / " + elements.length;
		document.getElementById("imagevideo").innerHTML = elements[n].innerHTML;
	}
	else	{
		setButtonsVisibility(0);
		document.getElementById("imagevideo").innerHTML = "<center><p style=font-size:64px><span id=clock></span><br>სურათი/ვიდეო-ს ატვირთვისთანავე, ატვირთული მასალა გამოჩნდება...</p></center>";
	}
	function getTime()    {
		datetime = new Date();
		textToReturn = "";
		var hour = datetime.getHours();
		var minute = datetime.getMinutes();
		var second = datetime.getSeconds();
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
		return textToReturn;
	}
	clockElement = document.getElementById("clock");
	if(clockElement != null)	{
		clockElement.innerHTML = getTime();
		clock = setInterval(function()	{
			clockElement.innerHTML = getTime();
		}, 1000);
	}
	function setButtonsVisibility(visibility)	{
		for(a = 0; a < buttonsArray.length; a++)	{
			if(visibility)	{
				buttonsArray[a].style.display = "";
			}
			else	{
				buttonsArray[a].style.display = "none";
			}
		}
	}
	function next_previous(direction, clickedProgramatically)	{
		document.body.style.backgroundColor = "#ffffff";
		if(direction)	{
			if(!clickedProgramatically)
				clearAndSetBorder("nextButton");
			if(++n > (elements.length - 1))	{
				n = 0;
			}
		}
		else	{
			if(!clickedProgramatically)
				clearAndSetBorder("previousButton");
			if(--n < 0)	{
				n = (elements.length - 1);
			}
		}
		document.getElementById("imagevideo").innerHTML = elements[n].innerHTML;
		document.getElementById("nums").innerHTML = (n + 1) + " / " + elements.length;
	}
	function clearAndSetBorder(elementID)	{
		clearBorders();
		document.getElementById(elementID).style.border = "2px solid #0000ff";
	}
	function clearBorders()	{
		for(var i = 0; i < buttonsArray.length; i++)	{
			buttonsArray[i].style.border = "";
		}
	}
	<?php
	if($logged_in)	{
	?>
	function whenSaved()	{
		document.getElementById("infoTitle").innerHTML = "#" + ID + " მოინიშნა როგორც " + infoText;
		document.getElementById(ID).innerHTML = "<div style=background-color:" + colourHEX + ";opacity:0.6>" + document.getElementById(ID).innerHTML + "</div>";
		next_previous(1, 1);
	}
	function saveChanges()	{
		changeStates = new XMLHttpRequest();
		changeStates.onreadystatechange = function() {
			if(this.responseText === "1")    {
				whenSaved();
			}
		};
		changeStates.open("POST", "change_states.php?", true);
		changeStates.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		changeStates.send(POST_TEXT);
	}
	function setStatus(mode)	{
		currentElement = document.getElementById("imagevideo").innerHTML;
		ID = currentElement.substring(currentElement.indexOf(">#") + 2, currentElement.indexOf("</span>"));
		if(mode)	{
			clearAndSetBorder("yesButton");
		}
		else	{
			clearAndSetBorder("noButton");
		}
		if(!document.getElementById(ID).innerHTML.includes("opacity:0.6"))	{
			infoText = "<font color=#";
			if(mode)	{
				colourHEX = "#00ff00";
				colourRGB = "rgb(0, 255, 0)";
				infoText += "00ff00>შესაბამისი";
				POST_TEXT = "no&yes=";
			}
			else	{
				colourHEX = "#ff0000";
				colourRGB = "rgb(255, 0, 0)";
				infoText += "ff0000>შეუსაბამო";
				POST_TEXT = "yes&no=";
			}
			infoText += "</font> (" + getTime() + ")";
			if(document.body.style.backgroundColor == colourRGB)	{
				POST_TEXT += ID + "|";
				saveChanges();
			}
			else	{
				document.body.style.backgroundColor = colourRGB;
			}
		}
	}
	function clearStatus()	{
		clearAndSetBorder("clearButton");
		document.body.style.backgroundColor = "#ffffff";
	}
	<?php
	}
	?>
	onkeydown = function()	{
		if(!document.getElementById("keyboardEnable").checked)	return;
		document.activeElement.blur();
		if(event.keyCode == 37)	{// arrow left
			next_previous(0);
		}
		else if(event.keyCode == 39)	{// arrow right
			next_previous(1);
		}
		<?php
		if($logged_in)	{
		?>
		else if(event.keyCode == 13)	{// enter
			setStatus(1);
		}
		else if(event.keyCode == 32)	{// space
			setStatus(0);
		}
		else if(event.keyCode == 27)	{// escape
			clearStatus();
		}
		<?php
		}
		?>
	}
	setInterval(function()	{
		var getNew = new XMLHttpRequest();
		getNew.open("GET", "get_new_element.php");
		getNew.send();
		getNew.onreadystatechange = function()	{
			if((this.responseText != lastReceived) && (this.responseText != "") && (!document.getElementById("allelement").innerHTML.includes(this.responseText.substring(this.responseText.indexOf("id="), this.responseText.indexOf(">")))))	{
				document.getElementById("allelement").innerHTML += this.responseText;
				document.getElementById("nums").innerHTML = (n + 1) + " / " + elements.length;
				if(buttonsArray[0].style.display == "none")	{
					clearInterval(clock);
					next_previous(1, 1);
					setButtonsVisibility(1);
				}
				lastReceived = this.responseText;
			}
		};
	},250);
</script>