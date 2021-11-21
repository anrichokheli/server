<?php
	include dirname(getcwd()) . "/protected/private/redirect.php";
	$darkMode = 1;
	if(isset($_COOKIE["darkmode"]))	{
		$darkMode = ($_COOKIE["darkmode"] == 1);
	}
	define("darkMode", $darkMode);
	unset($darkMode);
	echo "<style>";
	if(darkMode)	{
		echo "
			body	{
				background: #000000;
			}
			*:not(.samecolourindarkmode)	{
				color: #ffffff;
			}
		";
		$defaultTextColour = "#ffffff";
	}
	else	{
		$defaultTextColour = "#000000";
	}
	echo "</style><script>var defaultTextColour = \"" . $defaultTextColour . "\";</script>";
?>
<title>ქვეითი SOS</title>
<head><link rel="icon" href="/pedestriansos.png"></head>
<meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1">
<!DOCTYPE html>
<html>
    <style>
        .center {
            text-align: center;
        }
        input[name=name], input[name=password], select {
          width: 80%;
          padding: 12px 20px;
          margin: 8px 0;
          display: inline-block;
          border: 1px solid #ccc;
          border-radius: 4px;
          box-sizing: border-box;
          font-size: 25;
          background: rgba(64, 64, 64, 0.1);
        }
        input[type=submit] {
          display: none;
        }
        .loginButtons {
          width: 100%;
          background: rgba(128, 128, 128, 0.25);
          padding: 14px 20px;
          margin: 8px 0;
          border: none;
          border-radius: 4px;
          cursor: pointer;
          font-size: 25;
        }
        .loginButtons:hover:not(#loginButton:disabled) {
          background-color: rgba(64, 64, 64, 0.25);
        }
        .loginButtons:disabled {
          color: #808080;
          cursor: not-allowed;
        }
        div {
          border-radius: 5px;
          background: rgba(64, 64, 64, 0.1);
          padding: 20px;
        }
        label[for=name], label[for=password]    {
            font-size: 25;
        }
	.typewriter {
		width: 15em;
		overflow: hidden;
		border-right: .15em solid blue;
		white-space: nowrap;
		margin: 0 auto;
		letter-spacing: .10em;
		animation: 
			typing 1s steps(20, end),
			blink-caret .25s step-end infinite;
	}
	@keyframes typing {
		from { width: 0 }
		to { width: 15em }
	}
	@keyframes blink-caret {
		from, to { border-color: transparent }
		50% { border-color: blue; }
	}
	#choseButton	{
		border: none;
		padding: 8px;
		text-align: center;
		text-decoration: none;
		display: inline-block;
		font-size: 16px;
		margin: 1px 1px;
		transition-duration: 0.4s;
		cursor: pointer;
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
	#captchaFrame   {
	    width: 90%;
	    height: 90%;
	}
	.overlays {
        position: fixed;
        display: none;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 2;
    }
    #captchaOverlay {
        background-color: rgba(0,0,0,0.5);
        cursor: pointer;
    }
    #wrongOverlay   {
        background-color: rgba(255,0,0,0.5);
        color: #ffffff;
        font-size: 32;
        cursor: pointer;
    }
    .center2 {
        margin: 0;
        position: absolute;
        top: 50%;
        left: 50%;
        -ms-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
    }
    </style>
    <div class=center>
        <div id="captchaOverlay" class="overlays">
		    <iframe id="captchaFrame" src="captcha.php" title="captcha"></iframe>
	    </div>
	    <div id="wrongOverlay" class="overlays" onclick="this.style.display='none';">
	        <div class="center2" style="background-color:#ff0000;padding:4px 4px;border-radius:8px;">
	            <span style="font-size:128;">✕</span><br>მონაცემები არასწორია!
            </div>
        </div>
        <font style=font-size:40px>
            <b><font class="samecolourindarkmode" color=blue>ქვეითი </font><font class="samecolourindarkmode" color=red>SOS</font></b>
        </font>
        <br><br>
        <image src="/reactweb.png"></image>
	<p class="typewriter">რეაგირების ვებ გვერდი</p>
        <?php
            if(isset($_GET["mode"]) && $_GET["mode"] === "verify")    {
                echo "<span style=\"font-size:15px;\">დამატებითი უსაფრთხოებისთვის, შეიყვანეთ მონაცემები...</span>";
            }
            if(isset($_GET["wrong"]) && $_GET["wrong"] === "1")    {
                echo "<script>document.getElementById('wrongOverlay').style.display='block';</script>";
            }
        ?>
        <br>
        <form action="" enctype="multipart/form-data" method=post>
            <label for="name">სახელი:</label>
            <input type="text" id="name" name="name"><br><br>
            <label for="password" name="name_and_password">პაროლი:</label>
            <input type="password" id="password" name="password"><br><br>
            <label>დამატებითი უსაფრთხოების ფაილი:</label>
            <span id="fileName"></span>
            <label for="keyfile" id="choseButton">ფაილის არჩევა</label>
            <label>ან</label>
            <span id="draganddrop">ჩააგდეთ ფაილი</span>
            <br><br>
            <input type="submit" value="1" name="login" id="submitLogin">
            <input type="file" id="keyfile" name="file" style=display:none autocomplete="off">
            <input type="hidden" name="n" id="n">
        </form>
        <button id="loginButton" class="loginButtons" disabled>შესვლა</button>
    </div>
</html>
<script>
let loginButtonElement = document.getElementById("loginButton");
let nameElement = document.getElementById("name");
let passwordElement = document.getElementById("password");
let keyfileElement = document.getElementById("keyfile");
let fileNameElement = document.getElementById("fileName");
let captchaOverlay = document.getElementById("captchaOverlay");
captchaOverlay.onclick = function(){this.style.display = "none";};
function checkAndSetLoginButtonEnabled()	{
	loginButtonElement.disabled = !(nameElement.value != '' && passwordElement.value != '' && keyfileElement.value != '');
}
nameElement.oninput = function(){checkAndSetLoginButtonEnabled();};
passwordElement.oninput = function(){checkAndSetLoginButtonEnabled();};
loginButtonElement.onclick = function(){
	//document.getElementById("submitLogin").click();
	captchaOverlay.style.display = "block";
};
onkeydown = function()    {
    if(event.keyCode == 13)    {
        event.preventDefault();
        if(loginButtonElement.disabled)    {
            return false;
        }
        else    {
            captchaOverlay.style.display = "block";
        }
    }
};
document.getElementById("n").value = window.location.href.substring(window.location.href.indexOf("&n=") + 3);
keyfileElement.onchange = function()	{
	fileNameElement.innerHTML = keyfileElement.files[0].name;
	checkAndSetLoginButtonEnabled();
};

let dropbox = document.getElementById("draganddrop");
dropbox.addEventListener("dragenter", dragenter, false);
dropbox.addEventListener("dragover", dragover, false);
dropbox.addEventListener("drop", drop, false);
dropbox.addEventListener("dragleave", dragleave, false);

function setDefaultBackgroundColourOfDragAndDrop()	{
  dropbox.style.backgroundColor = "rgba(208, 208, 208, 0.25)";
}

function dragenter(e) {
  e.stopPropagation();
  e.preventDefault();
  dropbox.style.backgroundColor = "rgb(32, 16, 255)";
  dropbox.style.color = "white";
}

function dragleave(e) {
  e.stopPropagation();
  e.preventDefault();
  setDefaultBackgroundColourOfDragAndDrop();
  dropbox.style.color = defaultTextColour;
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
  
  keyfileElement.files = files;
  fileNameElement.innerHTML = keyfileElement.files[0].name;
  checkAndSetLoginButtonEnabled();
  var file = files[0];
  //document.getElementById("droppedFileURL").value = file;
  dropbox.style.backgroundColor = "rgb(16, 255, 32)";
  dropbox.style.color = defaultTextColour;
  setTimeout(function()	{
	setDefaultBackgroundColourOfDragAndDrop();
  },
  250
  );
}
</script>