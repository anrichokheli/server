<?php
define("echoDisable", "");
include 'getnum.php';
if((end($items)["state"] != 0) || (end($items)["react"] != "") || (end($items)["react_media"] != ""))	exit;
$N = end($items)["n"];
$link = end($items)["filename"];
$filePath = "uploads/media/" . $link;
$link = "/?/" . $filePath;
$type = explode("/", mime_content_type(dirname(getcwd()) . "/protected/public/" . $filePath))[0];
if($type === "video")	{
	$element = "<video id=a" . $N . " style=width:90%;height:75%; muted autoplay controls loop></video>";
}
else if($type === "image")	{
	$element = "<img id=a" . $N . " style=max-width:90vw;max-height:75vh;>";
}
//$element = "<center>" . "<span style=font-size:30px;background-color:#ffffff>" . '#' . $N . "</span>" . "<br>" . $element . "</center>";
echo "<a class=media id=\"" . $N . "\">" . $element . "<a style=display:none; id=b" . $N . ">" . $link . "</a></a>";
?>