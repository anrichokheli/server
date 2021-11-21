<?php
exit("00000000");
__halt_compiler();
define("protectedPath", dirname(getcwd()) . "/protected/");
define("protectedPrivatePath", protectedPath . "private/");
define("keysPath", protectedPrivatePath . "live_keys/");
define("live_n_path", protectedPrivatePath . "live_n");
define("livePath", protectedPath . "public/uploads/live/");
function exitFunction($exitString)	{
	unlink($GLOBALS["temp"]);
	exit($exitString);
}
if(isset($_POST["image"]) && isset($_COOKIE["ID"]) && isset($_COOKIE["KEY"]))	{
	$correct = (in_array($_COOKIE["ID"], scandir(keysPath)) && ($_COOKIE["KEY"] === explode("#", file_get_contents(keysPath . $_COOKIE["ID"]))[0]));
	if(!$correct)	{
		exit("0");
	}
	$file = base64_decode(explode(',', $_POST["image"])[1]);
	$temp = protectedPrivatePath . "temp/tmp_live_video_frame" . /*hr*/time(/*true*/) . rand(0, time());
	file_put_contents($temp, $file);
	if(mime_content_type($temp) !== "image/png")	{
		exitFunction("! image/png");
	}
	$n = explode("#", file_get_contents(keysPath . $_COOKIE["ID"]))[1];
	$fileNumPath = livePath . $n . "_n";
	$NUM = intval(file_get_contents($fileNumPath));
	++$NUM;
	file_put_contents($fileNumPath, strval($NUM));
	file_put_contents(livePath . $n . '/' . $NUM, $file);
	unlink($temp);
}
else if(isset($_GET["setup"]))	{
	$n = intval(file_get_contents(live_n_path));
	++$n;
	file_put_contents(live_n_path, strval($n));
	$liveID = /*hr*/time(/*1*/) . random_int(0, time());
	$liveKEY = "";
	for($count = 0; $count < 256; $count++)   {
		$liveKEY .= random_int(0, 9);
	}
	file_put_contents(keysPath . $liveID, $liveKEY . '#' . $n);
	mkdir(livePath . $n);
	echo ':' . $n . '#' . $liveID . '*' . $liveKEY;
}
else	{
	header("location: live.html");
}
?>