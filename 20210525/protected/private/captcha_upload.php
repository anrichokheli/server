<?php
/*if(session_status() != PHP_SESSION_ACTIVE)	{
	session_start();
}
if(!(isset($_SESSION["qveitisosreactloggedin"]) && $_SESSION["qveitisosreactloggedin"] === true))    {
    session_destroy();
    header("Location: /");
    exit;
}
if (!isset($_SERVER['PHP_AUTH_USER'])) {
    header('WWW-Authenticate: Basic realm="My Realm"');
    header('HTTP/1.0 401 Unauthorized');
    http_response_code(401);
    exit;
} else if($_SERVER['PHP_AUTH_USER'] !== "qveitisos" || $_SERVER['PHP_AUTH_PW'] !== "admin_qveitisos") {
    http_response_code(401);
    exit;
}
define("protectedPrivatePath", dirname(getcwd()) . "/protected/private/");*/
if(isset($_POST["upload"]) && !empty($_FILES["image"]["tmp_name"]) && !empty($_POST["text"]))    {
    define("captchaPath", protectedPrivatePath . "captcha/");
    define("imagesPath", captchaPath . "images/");
    define("textsPath", captchaPath . "texts/");
    define("countPath", captchaPath . "captcha_n");
    $text = htmlspecialchars($_POST["text"]);
    $n = "NO VALUE";
    foreach(scandir(textsPath) as $fileName)    {
        if(ctype_digit($fileName) && ($text === file_get_contents(textsPath . $fileName)))    {
            $n = $fileName;
            break;
        }
    }
    if($n === "NO VALUE")    {
        $n = intval(file_get_contents(countPath));
        $textNotExists = 1;
    }
    $savedAnyFile = 0;
    for($i = 0; $i < count($_FILES["image"]["name"]); $i++)   {
        $imagePath = $_FILES["image"]["tmp_name"][$i];
        if(exif_imagetype($imagePath) == IMAGETYPE_PNG)    {
            $src = imagecreatefrompng($imagePath);
        }
        else if(exif_imagetype($imagePath) == IMAGETYPE_JPEG)    {
            $src = imagecreatefromjpeg($imagePath);
        }
        $src = imagescale($src, 128, 128);
        $temp = protectedPrivatePath . "temp/" . time() . "_" . random_int(0, time());
        imagepng($src, $temp);
        $imageString = file_get_contents($temp);
        unlink($temp);
        $files = scandir(imagesPath);
        $exists = 0;
        foreach($files as $dirfile)   {
	        if(!empty(str_replace(".", "", $dirfile)))	{
    		    if($imageString === file_get_contents(imagesPath . $dirfile))    {
        		    //$file_name = $dirfile;
        		    $exists = 1;
        		    break;
    		    }
	        }
        }
        if(!$exists)    {
            $saved = file_put_contents(imagesPath . $n . "_" . time() . random_int(0, time()), $imageString);
            if(!$savedAnyFile)    {
                $savedAnyFile = 1;
            }
        }
        unset($imageString);
    }
    if($savedAnyFile)    {
        if(isset($textNotExists) && ($textNotExists == 1))    {
            file_put_contents(countPath, $n + 1);
            file_put_contents(textsPath . $n, $text);
        }
    }
    else    {
        echo "0";
    }
}
if(!defined("disableCaptchaHtmlOutput"))    {
    echo '
        <html>
            <form action="" enctype="multipart/form-data" method=post>
                <input type="file" id="image" name="image[]" multiple>
                <input type="text" id="text" name="text">
                <input type="submit" name="upload" id="upload">
            </form>
        </html>
    ';
}
?>