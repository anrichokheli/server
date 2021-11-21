<?php
if(!isset($_GET["n"]) || !isset($_GET["filename"]) || !isset($_GET["key"]))    {
    exit("EXIT");
}
$n = $_GET["n"];
$filename = $_GET["filename"];
$fileNameAndExtension = $filename . ".mp3";
if(!in_array($fileNameAndExtension, scandir("sound")))	{
	exit("-4");
}
$database = parse_ini_file(dirname(getcwd()) . "/private/database.ini");
$dbc = mysqli_connect($database["host"], $database["username"], $database["password"], $database["name"]);
$result = mysqli_query($dbc, "SELECT * FROM violations");
if ($result->num_rows > 0) {
	while($row0 = $result->fetch_assoc()) {
		$items[] = $row0["sound_link"];
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
        if(empty($row["sound_link"]) && empty($row["sound_time"]))    {
           if($_GET["key"] === $row["upload_key"])    {
                $time = time();
                $filelink = "http://" . $_SERVER['HTTP_HOST'] . "/sound/" . $filename . ".mp3";
                $query = "UPDATE violations SET sound_link='$filelink', sound_time='$time' WHERE n='$n'";
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