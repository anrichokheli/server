<?php
if(!isset($_GET["id"]) || !isset($_GET["key"]))	{
	exit("a-6");
}
if(!defined("soundFolderPath"))	define("soundFolderPath", dirname(getcwd()) . "/protected/public/uploads/sound/");
if(!defined("protectedPrivatePath"))	define("protectedPrivatePath", dirname(getcwd()) . "/protected/private/");
$correct = 0;
$keyFilePath = protectedPrivatePath . "sound_keys/" . $_GET["id"];
if(file_exists($keyFilePath))	{
	$keyFileContent = explode("#", file_get_contents($keyFilePath));
	if($keyFileContent[0] === $_GET["key"])	{
		$n = $keyFileContent[1];
		$correct = 1;
	}
}
if(!$correct)	{
	exit("-5");
}
include protectedPrivatePath . "mysqli_database.php";
$dbc = $mysqliConnectValue;
$mysqliQueryValue = mysqli_query($dbc, "SELECT * FROM violations WHERE n='$n'");
if(!$mysqliQueryValue)	{
	mysqli_close($dbc);
	exit("-7");
}
if(mysqli_fetch_array($mysqliQueryValue)["sound_time"] != "0")	{
	mysqli_close($dbc);
	exit("-8");
}
$allowedExtensions = array("avi", "mpeg", "ogv", "ts", "webm", "3gp", "3g2", "aac", "mp3", "oga", "opus", "wav", "weba", "mp4");
$T = /*hr*/time();
$temp = protectedPrivatePath . "temp/tmp" . $T/*[0] . "_" . $T[1]*/ . rand(0, time());
if(isset($_FILES['file']['tmp_name']))	{
	move_uploaded_file($_FILES['file']['tmp_name'], $temp);
	$file = file_get_contents($temp);
}
else	{
	$file = file_get_contents('php://input');
	file_put_contents($temp, $file);
}
$mimeContentType = mime_content_type($temp);
if(!$mimeContentType || (strpos($mimeContentType, '/') === FALSE)/*!str_contains($mimeContentType, '/')*/)	{
	mysqli_close($dbc);
	exit("-3");
}
$file_info_array = explode("/", $mimeContentType);
$type = $file_info_array[0];
$extension = $file_info_array[1];
if($extension === "x-msvideo")	{
	$extension = "avi";
}
else if($extension === "ogg")	{
	$extension = "ogv";
}
else if($extension === "mp2t")	{
	$extension = "ts";
}
else if($extension === "3gpp")	{
	$extension = "3gp";
}
else if($extension === "3gpp2")	{
	$extension = "3g2";
}
else if($extension === "mpeg")	{
	$extension = "mp3";
}
else if($extension === "ogg")	{
	$extension = "oga";
}
else if($extension === "webm")	{
	$extension = "weba";
}
if($mimeContentType === "application/octet-stream")	{
	$type = "audio";
	$extension = "3gp";
}
if((($type === "audio") || ($type === "video")) && in_array(strtolower($extension), array_map("strtolower", $allowedExtensions)))    {
$T = /*hr*/time();
$temp_name = "tmp_mp3_" . $T/*[0] . "_" . $T[1]*/ . "_" . rand(0, time());
$temp_path = protectedPrivatePath . "temp/tmp" . $temp_name;
/*if($extension === "3gp")	{
	exec(protectedPrivatePath . 'ffmpeg -i ' . $temp . ' ' . $temp_path . ".mp3");
	$extension = "mp3";
	$temp_path .= "." . $extension;
}
else	{*/
	$temp_path = $temp;
//}
$files = scandir(soundFolderPath);
$exists = 0;
foreach($files as $dirfile)   {
	if(!empty(str_replace(".", "", $dirfile)))	{
    		if(file_get_contents($temp_path) === file_get_contents(soundFolderPath . $dirfile))    {
        		$file_name = $dirfile;
        		$exists = 1;
        		break;
    		}
	}
}
if(!$exists)    {
    $T = /*hr*/time();
    $name = $T/*[0] . "_" . $T[1]*/ . "_" . rand(0, time()) . "." . $extension;
    $path = soundFolderPath . $name;
    copy($temp_path, $path);
    $insert = file_exists($path);
    if($insert){
		$time = time();
		file_put_contents(protectedPrivatePath . "data/sounds/" . $n, serialize(array($time, $name)));
		$query = "UPDATE violations SET sound_name='$name', sound_time='$time' WHERE n='$n'";
		$saved = mysqli_query($dbc, $query);
		if($saved)	{
			echo "1";
			unlink($keyFilePath);
		}
		else	{
			echo "-4";
		}
    } else{
        echo "0";
    }
}
else    {
    echo "-2";
}
}
else    {
    echo "a-1";
}
if(isset($temp_path) && file_exists($temp_path))	unlink($temp_path);
if(isset($temp) && file_exists($temp))	unlink($temp);
mysqli_close($dbc);
?>