<?php
if(!disk_free_space(dirname(getcwd())))	{
	exit("💾🚫 სერვერის მეხსიერება სრულად დაკავებულია!");
}
define("protectedPath", dirname(getcwd()) . "/protected/");
define("mediaFolderPath", protectedPath . "public/uploads/media/");
if(!defined("protectedPrivatePath"))	define("protectedPrivatePath", dirname(getcwd()) . "/protected/private/");
//define("maxFileSize", 100000000);
//define("maxImageSize", 1000000);
//define("maxImageWidth", 4000);
//define("maxImageHeight", 4000);
//define("maxVideoWidth", 1000);
//define("maxVideoHeight", 1000);
//define("maxVideoDuration", 900);
//define("compressedImageQualityValue", 75);
$allowedExtensions = array("bmp", "gif", "ico", "jpg", "png",/* "svg",*/ "tif", "webp", "avi", "mpeg", "ogv", "ts", "webm", "3gp", "3g2", "mp4");
function exitFunction($exitString)	{
	unlink($GLOBALS["temp"]);
	exit($exitString);
}
$temp = protectedPath . "private/temp/tmp" . /*hrtime(true)*/time() . rand(0, time());
if(isset($_FILES['file']['tmp_name']))	{
	move_uploaded_file($_FILES['file']['tmp_name'], $temp);
	$file = file_get_contents($temp);
}
/*else if(isset($_POST["image"]))	{
	$file = base64_decode(explode(',', $_POST["image"])[1]);
	file_put_contents($temp, $file);
}*/
/*else if(isset($_POST["URL"]))	{
	$URL = $_POST["URL"];
	$URL0 = parse_url($URL);
	$URL0 = $URL0["scheme"] . "://" . $URL0["host"];
	$URL = str_replace($URL0, '', $URL);
	$URL = $URL0 . implode('/', array_map("rawurlencode", explode('/', $URL)));
	if(!filter_var($URL, FILTER_VALIDATE_URL))	{
		exit("-7");
	}
	$file = file_get_contents($URL);
	file_put_contents($temp, $file);
}*/
else	{
	$file = file_get_contents('php://input');
	file_put_contents($temp, $file);
}
//$file = str_replace("script", "code", $file);
$mimeContentType = mime_content_type($temp);
$fileSize = filesize($temp);
clearstatcache();
if(defined("maxFileSize") && ($fileSize > maxFileSize))	{
	exitFunction("ფაილის ზომა უნდა იყოს არაუმეტეს " . maxFileSize . " ბაიტი");
}
if(!$mimeContentType || (strpos($mimeContentType, '/') === FALSE)/*!str_contains($mimeContentType, '/')*/)	exitFunction("-5");
$file_info_array = explode("/", $mimeContentType);
$type = $file_info_array[0];
$extension = $file_info_array[1];
if($extension === "vnd.microsoft.icon")	{
	$extension = "ico";
}
else if($extension === "jpeg")	{
	$extension = "jpg";
}
else if($extension === "svg+xml")	{
	$extension = "svg";
}
else if($extension === "tiff")	{
	$extension = "tif";
}
else if($extension === "x-msvideo")	{
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
if(($type === "image") || ($type === "video"))    {
if($type === "image")	{
	list($width, $height) = getimagesize($temp);
	if(defined("maxImageWidth") && defined("maxImageHeight"))	{
		$resolutionLimitExceeded = ($width > maxImageWidth) || ($height > maxImageHeight);
	}
	if((isset($resolutionLimitExceeded) && $resolutionLimitExceeded) || (defined("maxImageSize") && ($fileSize > maxImageSize)))	{
		$compressedImagePath = protectedPath . "private/temp/tmp_image" . /*hrtime(true)*/time() . rand(0, time());
		$imageFile = $temp;
		if(isset($resolutionLimitExceeded) && $resolutionLimitExceeded)	{
			$compressedImageWidth = maxImageWidth;
			$compressedImageHeight = maxImageHeight;
		}
		include_once(protectedPath . "private/compressImage.php");
		if(defined("canNotCompress"))	{
			exitFunction("სურათის ზომა უნდა იყოს არაუმეტეს " . maxImageSize . " ბაიტი.. აღნიშნულ ზომაზე მეტი ზომის მქონე სურათის ატვირთვის შემთხვევაში, ხდება მისი ზომის შემცირება.. ამ შემთხვევაში, ატვრირთული სურათის ზომის შემცირება ვერ მოხერხდა..");
		}
		$file = file_get_contents($compressedImagePath);
		unlink($compressedImagePath);
	}
}
else if($type === "video")	{
	if(defined("maxVideoDuration") || (defined("maxVideoWidth") && defined("maxVideoHeight")))	{
		include_once(protectedPath . 'private/getid3/getid3.php');
		$getID3 = new getID3;
		$videoFile = $getID3->analyze($temp);
		$width = $videoFile['video']['resolution_x'];
		$height = $videoFile['video']['resolution_y'];
		$duration = $videoFile['playtime_seconds'];
	}
	if(defined("maxVideoDuration") && ($duration > maxVideoDuration))	{
		exitFunction("ვიდეოს ხანგრძლივობა უნდა იყოს არაუმეტეს " . maxVideoDuration . " წამი");
	}
	if(defined("maxVideoWidth") && defined("maxVideoHeight"))	{
		$resolutionLimitExceeded = ($width > maxVideoWidth) || ($height > maxVideoHeight);
	}
	if(isset($resolutionLimitExceeded) && $resolutionLimitExceeded)	{
		$compressedVideoPath = protectedPath . "private/temp/tmp_video" . /*hrtime(true)*/time() . rand(0, time()) . '.' . $extension;
		exec(protectedPath . "private/ffmpeg -i " . $temp . " -vf scale=" . maxVideoWidth . ":-2 " . $compressedVideoPath);
		$videoFile = $getID3->analyze($compressedVideoPath);
		$width = $videoFile['video']['resolution_x'];
		$height = $videoFile['video']['resolution_y'];
		if(($width > maxVideoWidth) || ($height > maxVideoHeight))	{
			$compressedVideoPath2 = protectedPath . "private/temp/tmp_video2" . /*hrtime(true)*/time() . rand(0, time()) . '.' . $extension;
			exec(protectedPath . "private/ffmpeg -i " . $compressedVideoPath . " -vf scale=-2:" . maxVideoHeight . " " . $compressedVideoPath2);
			unlink($compressedVideoPath);
			$compressedVideoPath = $compressedVideoPath2;
			unset($compressedVideoPath2);
		}
		$file = file_get_contents($compressedVideoPath);
		unlink($compressedVideoPath);
	}
}
//exitFunction("ფაილის ზომა უნდა იყოს არაუმეტეს" . maxFileWidth . "×" . maxFileHeight . " (პიქსელები)");
if(!in_array(strtolower($extension), array_map("strtolower", $allowedExtensions)))	{
	exitFunction("-6" . implode(", ", $allowedExtensions));
}
$files = scandir(mediaFolderPath);
$exists = 0;
foreach($files as $dirfile)   {
	if(!empty(str_replace(".", "", $dirfile)))	{
		$local_filePath = mediaFolderPath . $dirfile;
    		if(($fileSize === filesize($local_filePath)) && ($file === file_get_contents($local_filePath)))    {
        		$file_name = $dirfile;
        		$exists = 1;
        		break;
    		}
	}
}
if(!$exists)    {
    $T = /*hr*/time();
    $fileName = $T/*[0] . "_" . $T[1]*/ . "_" . rand(0, time()) . "." . $extension;
    $path = mediaFolderPath . $fileName;
    file_put_contents($path, $file);
    $insert = file_exists($path);
    if($insert){

include dirname(getcwd()) . "/protected/private/mysqli_database.php";
$dbc = $mysqliConnectValue;
if(!$dbc) {
die("DATABASE CONNECTION FAILED:" .mysqli_error($dbc));
exitFunction();
}
$dbs = mysqli_select_db($dbc, $database["name"]);
if(!$dbs) {
die("DATABASE SELECTION FAILED:" .mysqli_error($dbc));
exitFunction();
}
if(in_array($fileName, scandir(mediaFolderPath)) && !empty(str_replace(".", "", $fileName)))	{
$result = mysqli_query($dbc, "SELECT * FROM violations");
if ($result->num_rows > 0) {
	while($row0 = $result->fetch_assoc()) {
		$items[] = $row0["filename"];
	}
}
else	{
	$items = array();
}
$time = time();
$key = "";
for($count = 0; $count < 255; $count++)    {
    $key .= strval(random_int(0, 9));
}
$query = "INSERT INTO violations (latitude, longitude, accuracy, situation, description, filename, react, react_media, time, react_time, sound_name, location_time, sound_time, info_time, upload_key, user_id, state, state_time, address) VALUES ('0', '0', '0', '', '', '$fileName', '', '', '$time', 0, '', '0', '0', '0', '$key', '0', '0', '0', '')";
if(mysqli_query($dbc, $query)){
$mysqliInsertID = mysqli_insert_id($dbc);
echo "#" . $mysqliInsertID . "|" . $key;
} else{
echo "0" . mysqli_error($dbc);
}
$n = intval(file_get_contents(protectedPrivatePath . "uploaded_n"));
++$n;
file_put_contents(protectedPrivatePath . "uploaded_n", strval($n));
file_put_contents(protectedPrivatePath . "data/n_files/" . $n, serialize(array($mysqliInsertID, $fileName, $time)));
}
else	{
	echo "-3";
}
mysqli_close($dbc);

    } else{
    echo "-4";
    }
}
else    {
    $database = parse_ini_file(dirname(getcwd()) . "/protected/private/database.ini");
    $conn = mysqli_connect($database["host"], $database["username"], $database["password"], $database["name"]);
    $sql = "SELECT * FROM violations";
    $result = $conn->query($sql);
    $n = false;
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            if($row["filename"] == $file_name)    {
                $n = $row["n"];
                break;
            }
        }
    }
    if($n)    {
        echo "-2" . $n;
    }
}
}
else    {
    echo "-1";
}
unlink($temp);
?>