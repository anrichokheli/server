<?php
define("captchaPath", dirname(getcwd()) . "/protected/private/captcha/");
define("imagesPath", captchaPath . "images/");
define("textsPath", captchaPath . "texts/");
define("imageWidth", 512);
define("imageHeight", 512);
if(!(is_readable(imagesPath) && is_readable(textsPath) && (count(scandir(imagesPath)) != 2) && (count(scandir(textsPath)) != 2)))    {
    http_response_code(403);
    //include("403.php");
    exit;
}
if(session_status() != PHP_SESSION_ACTIVE)	{
	session_start();
}
if(isset($_GET["verify"]) && $_GET["verify"] == "1" && isset($_SESSION["captcha_correct_image_ids"]) && isset($_POST["selectedimages"]) && is_array(explode(';', $_POST["selectedimages"])))    {
    $sessionNumbers = unserialize($_SESSION["captcha_correct_image_ids"]);
    unset($_SESSION["captcha_correct_image_ids"]);
    $inputNumbers = explode(';', $_POST["selectedimages"]);
    $sessionNumbers = array_map('intval', $sessionNumbers);
    $inputNumbers = array_map('intval', $inputNumbers);
    sort($sessionNumbers);
    sort($inputNumbers);
    if($sessionNumbers === $inputNumbers)    {
        $correct = "1";
        $_SESSION["captchaCorrect"] = 1;
    }
    else    {
        $correct = "0";
    }
    exit($correct);
}
if(isset($_GET["ajaxmode"]))    {
$dest = imagecreatetruecolor(imageWidth, imageHeight);
//shuffle($images);
//$images = array_slice($images, 0, 16);
$images = array_slice(scandir(imagesPath), 2);
$randomMaxNumber = count($images) - 1;
$imageTypeID = random_int(0, count(scandir(textsPath)) - 3);
$gridImagesIDs = array();
for($i = 0; $i < 16; $i++)   {
    $imageName = $images[random_int(0, $randomMaxNumber)];
    if(substr($imageName, 0, strpos($imageName, "_")) == $imageTypeID)    {
        array_push($gridImagesIDs, $i);
    }
    $imagePath = imagesPath . $imageName;
    //if(exif_imagetype($imagePath) == IMAGETYPE_PNG)    {
        $src = imagecreatefrompng($imagePath);
    //}
    //else if(exif_imagetype($imagePath) == IMAGETYPE_JPEG)    {
    //    $src = imagecreatefromjpeg($imagePath);
    //}
    //$src = imagescale($src, imageWidth / 4, imageHeight / 4);
    imagecopymerge($dest, $src, ($i % 4) * (imageWidth / 4), floor($i / 4) * (imageHeight / 4), 0, 0, imageWidth / 4, imageHeight / 4, 100);
    imagedestroy($src);
}
$_SESSION["captcha_correct_image_ids"] = serialize($gridImagesIDs);
$noise = imagecreatetruecolor(imageWidth, imageHeight);
for($i = 0; $i < imageWidth; $i++)   {
    for($j = 0; $j < imageHeight; $j++)   {
        imagesetpixel($noise, $i, $j, imagecolorallocate($noise, random_int(0, 255), random_int(0, 255), random_int(0, 255)));
    }
}
imagecopymerge($dest, $noise, 0, 0, 0, 0, imageWidth, imageHeight, 25);
imagedestroy($noise);
//header('Content-Type: image/png');
ob_start();
imagepng($dest, null, 9);
imagedestroy($dest);
}
if(!isset($_GET["ajaxmode"]))    {
    $output = "<html><title>ქვეითი SOS</title><meta charset=\"UTF-8\" name=\"viewport\" content=\"width=device-width, initial-scale=1\"><center>";
    $output .= "<span style=\"font-size:24;\"><span style=\"color:#256AFF;\">ქვეითი</span>&nbsp<span style=\"color:#ff0000;\">SOS</span><br><span style=\"background:-webkit-linear-gradient(#000000, #ffffff);-webkit-background-clip:text;-webkit-text-fill-color:transparent;\">CAPTCHA</span></span><br><span id=\"titleText\">მონიშნეთ სურათ(ებ)ი</span><br>";
    $output .= "<span id=\"noticeText\">თუ არც ერთი სურათი არ შეესაბამება ტექსტს, გააგრძელეთ მონიშვნის გარეშე</span><br><br>";
    $output .= "<div id=\"captchaContent\">";
}
if(isset($_GET["ajaxmode"]))    {
    $output .= "<span id=\"imageTypeText\">" . file_get_contents(textsPath . $imageTypeID) . "</span><br><br>";
    $output .= '<style>#captcha{background-image:url("data:image/png;base64,%s");width:512;height:512;}</style>';
}
if(!isset($_GET["ajaxmode"]))
    $output .= "</div>";
if(isset($_GET["ajaxmode"]))
    printf($output, base64_encode(ob_get_clean()));
else
    echo $output;
if(!isset($_GET["ajaxmode"]))	{
$echoString = '
    <style>';
$darkMode = 1;
if(isset($_COOKIE["darkmode"]))	{
	$darkMode = ($_COOKIE["darkmode"] == 1);
}
define("darkMode", $darkMode);
unset($darkMode);
if(darkMode)    {
	$echoString .= "
		*:not(.samecolourindarkmode)   {
			color: #ffffff;
		}
		body	{
			background: #000000;
		}
	";
}
$echoString .= '        .captchaButtons {
            width: 124;
            height: 124;
            background: none;
            outline: none;
            border: none;
            cursor: pointer;
        }
        .newLinePadding {
            padding-top: 2px;
        }
        #titleText  {
            font-size: 24;
            font-weight: bold;
        }
        #noticeText {
            font-size: 22;
            font-weight: 600;
            font-style: italic;
            color: #808080;
        }
        #imageTypeText  {
            font-size: 20;
            background: rgba(128, 128, 128, 0.25);
            border-radius: 8px;
            padding: 4px 4px;
        }
        .unicodeButtons   {
            font-size: 36;
            font-weight: 900;
            background: rgba(128, 128, 128, 0.25);
            outline: none;
            border: solid 2px #808080;
            border-radius: 4px;
            cursor: pointer;
            color: #256AFF;
        }
        .unicodeButtons:disabled    {
            color: #808080;
            cursor: not-allowed;
        }
        .unicodeButtons:active   {
            background: rgba(64, 64, 64, 0.25);
        }
        #warning_incorrect {
            font-size: 25;
            background-color: #ff0000;
            color: #ffffff;
            padding: 4px 4px;
            border-radius: 8px;
        }
        #overlay {
            position: fixed;
            display: none;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0,0,0,0.5);
            z-index: 2;
            font-size: 30;
            color: #ffffff;
        }
        .loader {
            border: 16px solid #f3f3f3;
            border-radius: 50%;
            border-top: 16px solid #256AFF;
            width: 120px;
            height: 120px;
            -webkit-animation: spin 2s linear infinite;
            animation: spin 2s linear infinite;
        }
        @-webkit-keyframes spin {
            0% { -webkit-transform: rotate(0deg); }
            100% { -webkit-transform: rotate(360deg); }
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .center {
            margin: 0;
            position: absolute;
            top: 50%;
            left: 50%;
            -ms-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
        }
        #centeredOverlay    {
            display: inline-block;
        }
    </style>
    <div id="captcha">
        <button id="0" class="captchaButtons"></button>
        <button id="1" class="captchaButtons"></button>
        <button id="2" class="captchaButtons"></button>
        <button id="3" class="captchaButtons"></button>
        <div class="newLinePadding"></div>
        <button id="4" class="captchaButtons"></button>
        <button id="5" class="captchaButtons"></button>
        <button id="6" class="captchaButtons"></button>
        <button id="7" class="captchaButtons"></button>
        <div class="newLinePadding"></div>
        <button id="8" class="captchaButtons"></button>
        <button id="9" class="captchaButtons"></button>
        <button id="10" class="captchaButtons"></button>
        <button id="11" class="captchaButtons"></button>
        <div class="newLinePadding"></div>
        <button id="12" class="captchaButtons"></button>
        <button id="13" class="captchaButtons"></button>
        <button id="14" class="captchaButtons"></button>
        <button id="15" class="captchaButtons"></button>
    </div>
    <br>
    <button id="refreshButton" class="unicodeButtons" disabled>⟳ განახლება</button>
    &nbsp
    <button id="submitButton" class="unicodeButtons" disabled>✓ დასტური</button>
    <div id="overlay">
        <div class="center">
            <div id="centeredOverlay">
            </div>
        </div>
    </div>
    </center>
    </html>
    <script>
        let warningIncorrectElement = document.getElementById("warning_incorrect");
        let anchors = document.getElementsByClassName("captchaButtons");
        let overlayElement = document.getElementById("overlay");
        let centeredOverlayElement = document.getElementById("centeredOverlay");
        var captchaImageButtonsEnabled;
        window.onload = function() {
            for(var i = 0; i < anchors.length; i++) {
                var anchor = anchors[i];
                anchor.onclick = function() {
                    buttonClicked(this.id);
                }
            }
            getNewCaptcha();
        }
        var selectedImages = [];
        function buttonClicked(button_id)  {
            if(!captchaImageButtonsEnabled)    {
                return;
            }
            local_buttonElement = document.getElementById(button_id);
            if(selectedImages.includes(button_id))    {
                local_buttonElement.style.outline = "none";
                const index = selectedImages.indexOf(button_id);
                if (index > -1) {
                    selectedImages.splice(index, 1);
                }
            }
            else    {
                local_buttonElement.style.outline = "4px solid #4080ff";
                selectedImages.push(button_id);
            }
        }
        function getNewCaptcha()    {
            captchaImageButtonsEnabled = 0;
            refreshButton.disabled = 1;
            submitButton.disabled = 1;
            document.getElementById("captchaContent").innerHTML = "<div style=\"height:128;\"></div><div class=\"loader\"></div>";
            var getNewCaptcha = new XMLHttpRequest();
		    getNewCaptcha.open("GET", "captcha.php?ajaxmode");
		    getNewCaptcha.onreadystatechange = function(){
		        if(this.readyState == 4 && this.status == 200)    {
		            document.getElementById("captchaContent").innerHTML = this.responseText;
		            captchaImageButtonsEnabled = 1;
		            refreshButton.disabled = 0;
		            submitButton.disabled = 0;
		        }
		    };
		    getNewCaptcha.send();
        }
        function clearSelectionsAndOverlay()    {
            selectedImages = [];
		    for(var i = 0; i < anchors.length; i++) {
		        anchors[i].style.outline = "none";
            }
            centeredOverlayElement.innerHTML = "<div class=\"loader\"></div><br><div>გთხოვთ დაიცადოთ...</div>";
            overlayElement.onclick = "";
            overlayElement.style.backgroundColor = "rgba(0,0,0,0.5)";
            overlayElement.style.cursor = "";
        }
        submitButton.onclick = function(){
            local_selectedImagesString = selectedImages.join(";");
            clearSelectionsAndOverlay();
            overlayElement.style.display = "block";
            var captchaAjax = new XMLHttpRequest();
		    captchaAjax.open("POST", "captcha.php?verify=1", true);
		    captchaAjax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		    captchaAjax.onreadystatechange = function(){
		        if(this.readyState == 4 && this.status == 200)    {
		            if(this.responseText == "0")    {
                        centeredOverlayElement.innerHTML = "<div id=\"warning_incorrect\">✕ მონაცემები არასწორია! გთხოვთ სცადოთ ხელახლა..</div>";
		                overlayElement.style.backgroundColor = "rgba(255,0,0,0.5)";
		                getNewCaptcha();
		                overlayElement.onclick = function(){overlayElement.style.display = "none";};
		                overlayElement.style.cursor = "pointer";
		            }
		            else if(this.responseText == "1")   {
		                centeredOverlayElement.innerHTML = "<div style=\"display:inline-block;color:#00ff00;background-color:rgba(0, 0, 0, 0.5);border-radius:8px;padding:4px 4px;\"><span style=\"font-size:128;\">✓</span><br>მონაცემები სწორია!</div>";
		                overlayElement.style.backgroundColor = "rgba(0, 255, 0, 0.5)";
		                window.parent.document.getElementById("submitLogin").click();
		            }
		        }
		    };
		    captchaAjax.send("selectedimages=" + local_selectedImagesString);
        };
        refreshButton.onclick = function()   {
            clearSelectionsAndOverlay();
            getNewCaptcha();
        };
    </script>
';
echo $echoString;
}
?>