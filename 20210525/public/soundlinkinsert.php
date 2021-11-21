<?php
exit("00000000");
__halt_compiler();
if(!defined("soundFolderPath"))	define("soundFolderPath", dirname(getcwd()) . "/protected/public/uploads/sound/");
if(!defined("protectedPrivatePath"))	define("protectedPrivatePath", dirname(getcwd()) . "/protected/private/");
if(!isset($_GET["n"]) || !isset($_GET["filename"]) || !isset($_GET["key"]))    {
    exit("-6");
}
$n = $_GET["n"];
require protectedPrivatePath . "check_n_input.php";
$filename = $_GET["filename"];
$found = 0;
foreach(scandir(soundFolderPath) as $dirFile)	{
	$name = substr($dirFile, 0, strpos($dirFile, '.'));
	if($name === $filename)	{
		$filename = $dirFile;
		$found = 1;
		break;
	}
}
if(!$found)	{
	exit("-4");
}
$database = parse_ini_file(protectedPrivatePath . "database.ini");
$dbc = mysqli_connect($database["host"], $database["username"], $database["password"], $database["name"]);
$result = mysqli_query($dbc, "SELECT * FROM violations");
if ($result->num_rows > 0) {
	while($row0 = $result->fetch_assoc()) {
		$items[] = $row0["sound_name"];
	}
}
else	{
	$items = array();
}
foreach($items as $fileLink)	{
	$items[array_search($fileLink, $items)] = pathinfo($fileLink)['filename'];
}
if(!in_array($filename, $items))	{
    $query = "SELECT * FROM violations WHERE n LIKE '$n'";
    if(mysqli_query($dbc, $query))    {
        $row = mysqli_fetch_array(mysqli_query($dbc, $query));
        if(empty($row["sound_name"]) && empty($row["sound_time"]))    {
           if($_GET["key"] === $row["upload_key"])    {
                $time = time();
                $query = "UPDATE violations SET sound_name='$filename', sound_time='$time' WHERE n='$n'";
                $saved = mysqli_query($dbc, $query);
                if($saved !== FALSE)	{
                    echo "1";
                }
                else	{
                    echo "0";
                }
            }
            else    {
                echo "-2";
            }
        }
        else    {
            echo "-3";
        }
    }
    else    {
        echo "-1";
    }
}
else	{
	echo "-5";
}
mysqli_close($dbc);
?>