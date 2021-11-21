<?php
sleep(1);
session_start();
?>
<title>ქვეითი SOS</title>
<head><link rel="icon" href="<?php include 'get_web_url.php' ?>/qveitiSOS.jpg"></head>
<?php
if(isset($_SESSION["qveitisosreactloggedin"]) && $_SESSION["qveitisosreactloggedin"] === true)    {
$N = $_GET["n"];
$database = parse_ini_file(dirname(getcwd()) . "/private/database.ini");
$dbc = mysqli_connect($database["host"], $database["username"], $database["password"], $database["name"]);
$lastChar = substr($N, strlen($N) - 1);
if($lastChar == '|')	{
	$N = substr($N, 0, strlen($N) - 1);
}
$N_ALL = explode('|', $N);
$link_all0 = array();
$path_all0 = array();
$soundPath_all = array();
foreach($N_ALL as $N_FROM_ARRAY)	{
	if(is_numeric($N_FROM_ARRAY))	{
		$link = mysqli_fetch_array(mysqli_query($dbc, "SELECT * FROM violations WHERE n = $N_FROM_ARRAY"))["link"];
		$path = str_replace("http://" . $_SERVER['HTTP_HOST'] . "/media/", getcwd() . trim("/media/ "), $link);
		$soundLink = mysqli_fetch_array(mysqli_query($dbc, "SELECT * FROM violations WHERE n = $N_FROM_ARRAY"))["sound_link"];
		if(!empty($soundLink))	{
			$soundPath = str_replace("http://" . $_SERVER['HTTP_HOST'] . "/sound/", getcwd() . trim("/sound/ "), $soundLink);
		}
		else	{
			$soundPath = "";
		}
		array_push($link_all0, $link);
		array_push($path_all0, $path);
		array_push($soundPath_all, $soundPath);
	}
}
$GLOBALS["link_all"] = $link_all0;
$GLOBALS["path_all"] = $path_all0;
function mediaout($videoid)    {
	for($index = 0; $index < count($GLOBALS["N_ALL"]); $index++)	{
		if(is_numeric($GLOBALS["N_ALL"][$index]))	{
			$type = explode("/", mime_content_type($GLOBALS["path_all"][$index]))[0];
			if($type === "video")  {
				$link = "<video id=$videoid src=" . $GLOBALS["link_all"][$index] . " style=max-width:90%;height:85%; controls loop autoplay muted></video>";
			}
			else if($type === "image") {
				$link = "<img src=" . $GLOBALS["link_all"][$index] . " style=max-width:90%;height:85%;>";
			}
			echo "<div class=center>" . "<span style=\"font-size:64px\"># " . $GLOBALS["N_ALL"][$index] . "</span><br>" . $link . "</div>";
		}
	}
}
if(isset($_SESSION["count"]) && ($_SESSION["count"] === 0) && isset($_SESSION["verified"]) && ($_SESSION["verified"] === true))    {
$_SESSION["count"] = 1;
?>
<html>
<style>

#textinput {
    padding: 12px 20px;
    margin: 4px 0;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    font-size: 16;
    vertical-align: top;
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
  background-color: #ff000080;
}

/* Modal Content/Box */
.modal-content {
  background-color: #fefefe;
  margin: 0% auto 0% auto; /* 5% from the top, 15% from the bottom and centered */
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

#emojis    {
    color: rgb(255, 64, 0);
    font-size: 32;
}
        .center {
            text-align: center;
        }
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
        }
        .button:hover {
            background-color: red;
            color: white;
        }
	#choseButton	{
		border: none;
		color: white;
		padding: 8px;
		text-align: center;
		text-decoration: none;
		display: inline-block;
		font-size: 16px;
		margin: 1px 1px;
		transition-duration: 0.4s;
		cursor: pointer;
		background-color: white; 
		color: black; 
		border-radius: 8px;
		background-color: rgba(192, 192, 192, 0.25);
	}
	#choseButton:hover    {
		background-color: rgba(224, 224, 224, 0.1);
	}
	#draganddrop	{
		transition: background-color 0.25s ease;
		padding: 14px;
		text-align: center;
		border: 2px dashed #808080;
		border-radius: 8px;
		font-size: 14;
		background-color: rgba(208, 208, 208, 0.25);
	}
</style>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
.loader {
  display: none;
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #ff0000;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite; /* Safari */
  animation: spin 1s linear infinite;
}

/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>
</head>
<div id="confirmdelete" class="modal">
  <span onclick="setvisibilityandcleartext('none')" class="close" title="დახურვა">×</span>
  <form class="modal-content">
    <div class="container">
      <h1>ატვირთული მასალის წაშლა</h1>
      <center>
          <div class="loader" id="loaderfordelete"></div>
      </center>
      <p>წაშლის დამატებითი დადასტურებისთვის, ჩაწერეთ წინადადება:<br></p>
      <?php
          $code = "";
          $img = imagecreate(720, 50);
          $textbgcolor = imagecolorallocate($img, 255, 255, 255);
          $textcolor = imagecolorallocate($img, 0, 0, 0);
          $georgianLetters = array("ქ","წ","ე","რ","ტ","ყ","უ","ი","ო","პ","ა","ს","დ","ფ","გ","ჰ","ჯ","კ","ლ","ზ","ხ","ც","ვ","ბ","ნ","მ","ჭ","ღ","თ","შ","ჟ","ძ","ჩ");
          for($n = 0; $n < 10; $n++)    {
		$randomMode = random_int(0, 3);
		if($randomMode === 0)	{
			$character = random_int(0, 9);
		}
		else if($randomMode === 1)	{
			$character = chr(random_int(65, 90));
		}
		else if($randomMode === 2)	{
			$character = chr(random_int(97, 122));
		}
		else	{
			$character = $georgianLetters[random_int(0, count($georgianLetters) - 1)];
		}
		if($randomMode !== 3)	{
			$font = getcwd() . "/NotoSans-LightItalic.ttf";
		}
		else	{
			$font = getcwd() . "/NotoSerifGeorgian-Light.ttf";
		}
		imagettftext($img, 25, 0, 15 + $n * 64, 35, $textcolor, $font, $character);
		$code .= $character;
          }
          $_SESSION["numberinimage"] = $code;
          imagefilter($img, IMG_FILTER_SCATTER, 3, 5);
          ob_start();
          imagepng($img);
          printf('<img src="data:image/png;base64,%s"/ width="720" height="50">', base64_encode(ob_get_clean()));
      ?> 
      <br>
      <input id="textinput" type="text"></input>
      <div class="clearfix">
        <button type="button" onclick="setvisibilityandcleartext('none')" class="cancelbtn">გაუქმება</button>
        <button type="button" onclick="checkinput()" class="deletebtn">შემდეგი</button>
      </div>
    </div>
  </form>
</div>
<div id="confirmdelete2" class="modal">
  <span onclick="setvisibilityandmutevideo('none')" class="close" title="დახურვა">×</span>
  <form class="modal-content">
    <div class="container">
      <h1><strong><font color="red">❗❗❗❗❗❗❗❗❗❗გაფრთხილება!❗❗❗❗❗❗❗❗❗❗</font></strong></h1>
      <p><strong>ღილაკ "<font color="red"><cite>წაშლა</cite></font>"-ზე დაჭერის შემთხვევაში, ეს მასალა/მასალები <font color="red"><u>წაიშლება</u></font>!❗❗❗<br>❗❗❗ეს <font color="red"><u>საბოლოო</u></font> დასტურია!❗❗❗<br>❗❗❗ამ მოქმედების უკან დაბრუნება <font color="red"><u>შეუძლებელია</u></font>!❗❗❗<br><span id="emojis">🗑️ ⚠ 🗑️ ⚠ 🗑️ ⚠ 🗑️ ⚠ 🗑️ ⚠ 🗑️ ⚠ 🗑️ ⚠ 🗑️ ⚠ 🗑️ ⚠ 🗑️ ⚠</span></strong></p>
      <?php echo "<p style=\"font-size:48px;\">" . "წასაშლელი მასალ(ებ)ის რაოდენობა: " . count($GLOBALS["N_ALL"]) . "</p>"; ?>
      <?php mediaout("video_id2"); ?>
      <div class="clearfix">
        <button type="button" onclick="setvisibilityandmutevideo('none')" class="cancelbtn">გაუქმება</button>
        <button type="button" onclick="delete2()" class="deletebtn">წაშლა</button>
      </div>
    </div>
  </form>
</div>
<?php
$_SESSION["post"] = true;
$N = $GLOBALS["N"];
$link = $GLOBALS["link"];
echo "<div class=center><image src=warning.png style=width:128px; height:128px;><image src=delete.png style=width:128px; height:128px;><br><br><font size=25 color=red>" . "წასაშლელი მასალ(ებ)ის რაოდენობა: " . count($GLOBALS["N_ALL"]) . "</font></div>";
echo "<br><br>";
mediaout("video_id1");
?>
<br><br>
<div class="center">
<form method="post" enctype="multipart/form-data" style: "display:inline" id="formofdelete">
    <label for="file">უსაფრთხოების ფაილი (წაშლის):</label>
    <span id="fileName"></span>
    <label for="keyfile" id="choseButton">ფაილის არჩევა</label>
    <label>ან</label>
    <span id="draganddrop">ჩააგდეთ ფაილი</span>
    <input type="file" name="file" id="keyfile" style="display:none">
    <input type="text" id="textinputform" name="num" style="display:none">
    <input hidden type="submit" name="delete" id="submitdelete">
</form>
<br><br>
<button class="button" onclick="confirmdelete0()">ატვირთული მასალ(ებ)ის წაშლა</button>
</div>
    <body>
        <script>
document.getElementById("keyfile").onchange = function ()	{
	document.getElementById("fileName").innerHTML = document.getElementById('keyfile').files[0].name;
};

let dropbox;

dropbox = document.getElementById("draganddrop");
dropbox.addEventListener("dragenter", dragenter, false);
dropbox.addEventListener("dragover", dragover, false);
dropbox.addEventListener("drop", drop, false);
dropbox.addEventListener("dragleave", dragleave, false);

function setDefaultBackgroundColourOfDragAndDrop()	{
  document.getElementById("draganddrop").style.backgroundColor = "rgba(208, 208, 208, 0.25)";
}

function dragenter(e) {
  e.stopPropagation();
  e.preventDefault();
  document.getElementById("draganddrop").style.backgroundColor = "rgb(32, 16, 255)";
  document.getElementById("draganddrop").style.color = "white";
}

function dragleave(e) {
  e.stopPropagation();
  e.preventDefault();
  setDefaultBackgroundColourOfDragAndDrop();
  document.getElementById("draganddrop").style.color = "black";
}

function dragover(e) {
  e.stopPropagation();
  e.preventDefault();
} 

function drop(e) {
  e.stopPropagation();
  e.preventDefault();

  const dt = e.dataTransfer;
  const files = dt.files;

  //handleFiles(files);
  
  keyfile.files = files;
  document.getElementById("fileName").innerHTML = document.getElementById('keyfile').files[0].name;
  var file = files[0];
  //document.getElementById("droppedFileURL").value = file;
  document.getElementById("draganddrop").style.backgroundColor = "rgb(16, 255, 32)";
  document.getElementById("draganddrop").style.color = "black";
  setTimeout(function()	{
	setDefaultBackgroundColourOfDragAndDrop();
  },
  250
  );
}
        function delete2()    {
            document.getElementById("submitdelete").click();
        }
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if(this.responseText === "1")    {
                confirmdelete2();
                document.getElementById("loaderfordelete").style.display = "none";
            }
            else if(this.responseText !== "")    {
                window.location.replace('incorrect.php');
            }
        };
	//var fileString;
/*function getFileAsString(file) {
  if((file == undefined) || (file == null))	{
  	checkinput();
  	return;
  }
  var reader = new FileReader();
  reader.onload = function(evt) {
    fileString = encodeURI(evt.target.result);
    checkinput();
  };
  reader.readAsText(file);
}*/
        function checkinput()    {
            document.getElementById("loaderfordelete").style.display = "block";
            document.getElementById("textinputform").value = document.getElementById("textinput").value;
            xmlhttp.open("POST", "checktextinput.php", true);
            //xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xmlhttp.send(new FormData(document.getElementById("formofdelete")));
        }
        function setvisibilityandcleartext(visibility)    {
            document.getElementById('confirmdelete').style.display = visibility;
            document.getElementById("textinput").value = "";
        }
        function setvisibilityandmutevideo(visibility)    {
            document.getElementById('confirmdelete2').style.display = visibility;
            video1 = document.getElementById("video_id1");
            video2 = document.getElementById("video_id2");
            if(video1 != null)
                video1.muted = 1;
            if(video2 != null)
                video2.muted = 1;
        }
        function confirmdelete0()    {
            setvisibilityandcleartext('block');
        }
        function confirmdelete2()    {
            document.getElementById('confirmdelete').style.display = 'none';
            setvisibilityandmutevideo('block');
            /*var stringNumber = "";
            for(var n = 0; n < 10; n++)    {
                stringNumber += Math.floor(Math.random() * 10).toString();
            }
            if(prompt("წაშლის დამატებითი დადასტურებისთვის, ჩაწერეთ რიცხვი:\n" + stringNumber) == stringNumber)    {
                return confirm("❗❗❗❗❗❗❗❗❗❗\n❗❗❗გაფრთხილება!❗❗❗\n❗❗❗ღილაკ \"OK\"-ზე დაჭერის შემთხვევაში, ეს მასალა წაიშლება!❗❗❗\n❗❗❗ეს საბოლოო დასტურია!❗❗❗\n❗❗❗ამ მოქმედების უკან დაბრუნება შეუძლებელია!❗❗❗\n⚠⚠⚠⚠⚠⚠⚠⚠⚠⚠");
            }
            else    {
                return false;
            }*/
        }
        var modal = document.getElementById('confirmdelete');
        var modal2 = document.getElementById('confirmdelete2');
        window.onclick = function(event) {
            if(event.target == modal)    {
                setvisibilityandcleartext('none');
            }
            else if (event.target == modal2) {
                setvisibilityandmutevideo("none");
            }
        };
        </script>
    </body>
</html>
<?php
}
else    {
    $submited = 0;
    $correct = 0;
    if(isset($_SESSION["post"]) && $_SESSION["post"] === true)   {
        $_SESSION["post"] = false;
        if(isset($_POST["delete"]))    {
            $submited = 1;
            $inputfile = file_get_contents($_FILES["file"]["tmp_name"]);
            $file = file_get_contents(dirname(getcwd()) . "/private/keyfile_delete");
            if($inputfile === $file)    {
                $correct = 1;
            }
        }
    }
    if($submited)    {
        if($correct)    {
		for($index = 0; $index < count($GLOBALS["N_ALL"]); $index++)	{
			unlink($GLOBALS["path_all"][$index]);
			if(!empty($GLOBALS["soundPath_all"][$index]))	{
				unlink($GLOBALS["soundPath_all"][$index]);
			}
			mysqli_query($dbc, "DELETE FROM violations WHERE n=" . $GLOBALS["N_ALL"][$index]);
		}
		header('location: deleted.php?n=' . $N);
        }
        else    {
            ?>
            <script>
            window.location.replace('incorrect.php');
            </script>
            <?php
        }
    }
    else    {
        $_SESSION["count"] = 0;
        $_SESSION["verified"] = false;
        $_SESSION["verify_mode"] = true;
        echo "
	<script>
        window.location.replace(\"login.php?mode=verify&n=" . $GLOBALS["N"] . "\");
        </script>
        ";
    }
}
}
else    {
    session_destroy();
    ?><script>
    window.location.replace('login.php');
    </script><?php
}
?>