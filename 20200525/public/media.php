<?php
$file = file_get_contents('php://input');
$temp = sys_get_temp_dir() . "/" . "tmp" . hrtime(true) . rand(0, time());
file_put_contents($temp, $file);
$file_info_array = explode("/", mime_content_type($temp));
unlink($temp);
$type = $file_info_array[0];
$extension = "." . $file_info_array[1];
if(($type === "image") || ($type === "video"))    {
$files = scandir('media');
$exists = 0;
foreach($files as $dirfile)   {
	if(!empty(str_replace(".", "", $dirfile)))	{
    		if($file === file_get_contents("media/" . $dirfile))    {
        		$file_name = $dirfile;
        		$exists = 1;
        		break;
    		}
	}
}
if(!$exists)    {
    $T = hrtime();
    $fileName = $T[0] . "_" . $T[1] . "_" . rand(0, time()) . $extension;
    $path = 'media/' . $fileName;
    file_put_contents($path, $file);
    $insert = file_exists($path);
    if($insert){

$database = parse_ini_file(dirname(getcwd()) . "/private/database.ini");
define ('dbname', $database["name"]);
$dbc = mysqli_connect($database["host"], $database["username"], $database["password"], dbname);
if(!$dbc) {
die("DATABASE CONNECTION FAILED:" .mysqli_error($dbc));
exit();
}
$dbs = mysqli_select_db($dbc, dbname);
if(!$dbs) {
die("DATABASE SELECTION FAILED:" .mysqli_error($dbc));
exit();
}
if(in_array($fileName, scandir('media')) && !empty(str_replace(".", "", $fileName)))	{
$result = mysqli_query($dbc, "SELECT * FROM violations");
if ($result->num_rows > 0) {
	while($row0 = $result->fetch_assoc()) {
		$items[] = $row0["link"];
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
$URL = include 'get_web_url.php';
$link = $URL . "/media/" . $fileName;
$query = "INSERT INTO violations (location, accuracy, situation, description, link, react, react_media, time, react_time, sound_link, location_time, sound_time, info_time, upload_key, user_id, state, state_time, address) VALUES ('', '0', '', '', '$link', '', '', '$time', 0, '', '0', '0', '0', '$key', '0', '0', '0', '')";
if(mysqli_query($dbc, $query)){
echo "#" . mysqli_insert_id($dbc) . "|" . $key;
} else{
echo "0" . mysqli_error($dbc);
}
$n = intval(file_get_contents("uploaded_n"));
++$n;
file_put_contents("uploaded_n", strval($n));
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
    $database = parse_ini_file(dirname(getcwd()) . "/private/database.ini");
    $conn = mysqli_connect($database["host"], $database["username"], $database["password"], $database["name"]);
    $sql = "SELECT * FROM violations";
    $result = $conn->query($sql);
    $n = false;
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            if(strpos($row["link"], $file_name) !== false)    {
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
?>