<?php
define("echoDisable", "");
include 'getnum.php';
if((end($items)["state"] != 0) || (end($items)["react"] != "") || (end($items)["react_media"] != ""))	exit;
$N = end($items)["n"];
$link = end($items)["link"];
$type = explode("/", mime_content_type(str_replace("http://" . $_SERVER['HTTP_HOST'] . "/media/", getcwd() . trim("/media/ "), $link)))[0];
if($type === "video")	{
	$element = "<video src=" . $link . " style=width:75%;height:75%; muted autoplay controls loop></video>";
}
else if($type === "image")	{
	$element = "<img src=" . $link . " style=max-width:75vw;max-height:75vh;>";
}
$element = "<center>" . "<span style=font-size:32px;background-color:#ffffff>" . '#' . $N . "</span>" . "<br>" . $element . "</center>";
echo "<a class=media id=\"" . $N . "\">" . $element . "</a>";
?>