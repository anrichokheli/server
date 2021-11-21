<?php
session_start();
$logged_in = (isset($_SESSION["qveitisosreactloggedin"]) && $_SESSION["qveitisosreactloggedin"] === true);
if(!$logged_in)    {
	session_destroy();
}
?>
<title>ქვეითი SOS</title>
<head><link rel="icon" href="/pedestriansos.png"></head>
<style>
.buttons	{
	outline: none;
	border: none;
	padding: 4px 16px;
	text-align: center;
	text-decoration: none;
	display: inline-block;
	font-size: 18px;
	margin: 4px 2px;
	transition-duration: 0.25s;
	cursor: pointer;
	background-color: rgb(224, 224, 224, 0.25);
	border-radius: 8px;
}
.buttons:hover	{
	background-color: rgb(248, 248, 248, 0.5);
}
#file_n	{
	font-size: 30px;
	background-color: rgba(255, 255, 255, 0.1);
}
#infoTitle	{
	background-color: rgba(255, 255, 255, 0.1);
	font-size: 20;
	font-weight: bold;
}
#moreButton	{
	background-color: rgb(56, 112, 224, 0.25);
}
#moreButton:hover	{
	background-color: rgb(80, 136, 248, 0.5);
}
#imagevideo	{
	display: inline-block;
	width: 100%;
}
.marked	{
	display: inline-block;
	<?php
		if($_GET["display"] == "stateyes")	{
			echo "opacity: 1";
		}
		else	{
			echo "opacity: 0.6";
		}
		echo ";\n";
	?>
	width: 100%;
}
</style>
<?php
unset($temp_n);
$darkMode = 1;
if(isset($_COOKIE["darkmode"]))	{
	$darkMode = ($_COOKIE["darkmode"] == 1);
}
define("darkMode", $darkMode);
unset($darkMode);
if(darkMode)    {
	echo "
		<style>
		*:not(.samecolourindarkmode)   {
			color: #ffffff;
		}
		body	{
			background: #000000;
		}
		</style>
	";
}
include dirname(getcwd()) . "/protected/private/mysqli_database.php";
$dbc = $mysqliConnectValue;
$query = "SELECT * FROM violations";
if(isset($_GET["display"]) && $_GET["display"] == "stateyes")	{
	$query .= " WHERE state=1";
}
$result = mysqli_query($dbc, $query);
if($result)	{
	echo "<span id=allelement style=display:none>";
	echo "<script>var state_yes = new Array();var state_no = new Array();</script>";
	foreach($result as $row)	{
		if((($row["state"] == 0) && (empty($row["react"]) && empty($row["react_media"]))) || ($_GET["display"] == "all") || ($_GET["display"] == "stateyes"))	{
			$N = $row["n"];
			$filePath = "uploads/media/" . $row["filename"];
			$path = "/?/" . $filePath;
			$type = explode("/", mime_content_type(dirname(getcwd()) . "/protected/public/" . $filePath))[0];
			if($type === "video")	{
				$element = "<video id=a" . $N . " style=width:90%;height:75%; muted autoplay controls loop></video>";
			}
			else if($type === "image")	{
				$element = "<img id=a" . $N . " style=max-width:90vw;max-height:75vh;>";
			}
			//$element = "<center>" . "<span class=\"file_n\">" . '#' . $N . "</span>" . "<br>" . $element . "</center>";
			if($row["state"] != 0)	{
				if($row["state"] == 1)	{
					$colourRGB = "rgb(0, 255, 0)";
				}
				else if($row["state"] == -1)	{
					$colourRGB = "rgb(255, 0, 0)";
				}
				$element = "<div class=\"marked\" style=\"background-color:" . $colourRGB . ";\">" . $element . "</div>";
			}
			echo "<a class=media id=" . $N . ">" . $element . "<a style=display:none; id=b" . $N . ">" . $path . "</a></a>";
		}
	}
	echo "</span>";
}
mysqli_close($dbc);
?>
<center>
	<input type="checkbox" id="keyboardEnable" checked onclick=checkboxClicked()>
	<label for="keyboardEnable">⌨️ კლავიატურით მართვა</label>
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
	<span id="nums" style="font-size:20px;background-color:rgba(255, 255, 255, 0.1)"></span>
	<br>
	<span id="infoTitle"></span>
	<br>
	<span id="file_n">#<span id="file_id"></span></span>
	&nbsp
	<button type="button" class="buttons" id="moreButton">🛈» მეტი</button>
	<br>
	<span id="imagevideo"></span>
</center>
<script>
	let keyboardEnableCheckbox = document.getElementById("keyboardEnable");
	function checkboxClicked()	{
		keyboardEnableCheckbox.blur();
	}
	var keyPressed = 0;
	var lastReceived;
	var n = 0;
	var current_id;
	var statusSetted = 0;
	let elements = document.getElementsByClassName("media");
	let buttonsArray = document.getElementsByClassName("buttons");
	let fileIDelement = document.getElementById("file_id");
	let ImageVideoElement = document.getElementById("imagevideo");
	let InfoTitleElement = document.getElementById("infoTitle");
	let fileNelement = document.getElementById("file_n");
	if(elements.length > 0)	{
		setFileSRC(n);
		document.getElementById("nums").innerHTML = (n + 1) + " / " + elements.length;
		ImageVideoElement.innerHTML = elements[n].innerHTML;
		for(var i = 0; i < state_yes.length; i++)	{
			document.getElementById(state_yes[i]).style.opacity = 0.6;
			document.getElementById(state_yes[i]).style.background = "#00ff00";
		}
		for(var i = 0; i < state_no.length; i++)	{
			document.getElementById(state_no[i]).style.opacity = 0.6;
			document.getElementById(state_no[i]).style.background = "#ff0000";
		}
	}
	else	{
		setButtonsVisibility(0);
		fileNelement.hidden = 1;
		ImageVideoElement.innerHTML = "<center><p style=font-size:64px><span id=clock></span><br>სურათი/ვიდეო-ს ატვირთვისთანავე, ატვირთული მასალა გამოჩნდება...</p></center>";
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
	function setFileSRC(local_n)	{
		current_id = elements[local_n].id;
		fileIDelement.innerHTML = current_id;
		document.getElementById("a" + current_id).src = document.getElementById("b" + current_id).innerHTML;
	}
	function next_previous(direction, clickedProgramatically)	{
		if(statusSetted)	{
			clearStatus(clickedProgramatically);
			statusSetted = 0;
		}
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
		setFileSRC(n);
		ImageVideoElement.innerHTML = elements[n].innerHTML;
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
		InfoTitleElement.innerHTML = "#" + current_id + " მოინიშნა" + infoText + " (" + getTime() + ")";
		local_currentElement = document.getElementById(current_id);
		local_currentElement.innerHTML = "<div class=\"marked\" style=\"background-color:" + colourRGB + ";\">" + local_currentElement.innerHTML + "</div>";
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
		if(mode)	{
			clearAndSetBorder("yesButton");
		}
		else	{
			clearAndSetBorder("noButton");
		}
		if(!document.getElementById(current_id).innerHTML.includes("class=\"marked\""))	{
			infoText = " როგორც <font class=\"samecolourindarkmode\" color=#";
			if(mode)	{
				colourRGB = "rgb(0, 255, 0)";
				infoText += "00ff00>შესაბამისი";
				POST_TEXT = "no&yes=";
			}
			else	{
				colourRGB = "rgb(255, 0, 0)";
				infoText += "ff0000>შეუსაბამო";
				POST_TEXT = "yes&no=";
			}
			infoText += "</font>";
			if(ImageVideoElement.style.backgroundColor == colourRGB)	{
				POST_TEXT += current_id + "|";
				saveChanges();
			}
			else	{
				ImageVideoElement.style.backgroundColor = colourRGB;
				InfoTitleElement.innerHTML = "მონიშვნა" + infoText;
			}
		}
		statusSetted = 1;
	}
	function clearStatus(CLICKEDPROGRAMATICALLY)	{
		clearAndSetBorder("clearButton");
		ImageVideoElement.style.background = "none";
		if(!CLICKEDPROGRAMATICALLY && InfoTitleElement.innerHTML.includes("მონიშვნა"))	{
			InfoTitleElement.innerHTML = '';
		}
	}
	<?php
	}
	?>
	onkeydown = function()	{
		if(!keyboardEnableCheckbox.checked)	return;
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
	if(!window.location.href.includes("display=stateyes"))
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
					fileNelement.hidden = 0;
				}
				lastReceived = this.responseText;
			}
		};
	},10000);
	document.getElementById("moreButton").onclick = function(){
		window.open("more.php?n=" + current_id);
	};
</script>