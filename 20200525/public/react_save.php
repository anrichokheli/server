<?php
session_start();
if(!(isset($_SESSION["qveitisosreactloggedin"]) && $_SESSION["qveitisosreactloggedin"] === true))    {
	session_destroy();
	exit("-1");
}
if(isset($_POST["n"]) && isset($_POST["text"]) && isset($_FILES['media'])) {
    $text = $_POST["text"];
    $file = $_FILES['media']['tmp_name'];
    $ext = explode("/", mime_content_type($file))[1];
    $T = hrtime();
    $name = $T[0] . $T[1] . "_" . rand(0, 1000000) . "." . $ext;
    $n = $_POST["n"];
    if(!empty($text) && !empty($file))    {
        $path = "react_media/" . $name;
        $files = scandir('react_media');
        $exists = 0;
        foreach($files as $dirfile)   {
	    if(!empty(str_replace(".", "", $dirfile)))	{
    		    if(file_get_contents($file) === file_get_contents("react_media/" . $dirfile))    {
        		    $name = $dirfile;
        		    $exists = 1;
        		    break;
    		    }
	    }
        }
        if(!$exists)    {
            move_uploaded_file($file, $path);
        }
        else    {
            unlink($file);
        }
        if(!empty($name))    {
            $media = "http://" . $_SERVER['HTTP_HOST'] . "/react_media/" . $name;
        }
        else    {
            $media = "";
        }
	$database = parse_ini_file(dirname(getcwd()) . "/private/database.ini");
	$dbc = mysqli_connect($database["host"], $database["username"], $database["password"], $database["name"]);
	$reactTime = time();
	$query = "UPDATE violations SET react='$text', react_media='$media', react_time='$reactTime' WHERE n=$n";
	if(mysqli_query($dbc, $query)){
		$row = mysqli_fetch_array(mysqli_query($dbc, "SELECT * FROM violations WHERE n = '$n'"));
		$react = htmlspecialchars($row["react"]);
		$reactLink = $row["react_media"];
		$type = explode("/", mime_content_type(str_replace("http://" . $_SERVER['HTTP_HOST'] . "/react_media/", getcwd() . trim("/react_media/ "), $reactLink)))[0];
		if($type === "video")	{
		$reactMedia = "<video src=$reactLink style=max-width:512px;max-height:512px; controls></video>";
		}
		else if($type === "image")	{
		$reactMedia = "<img src=$reactLink style=max-width:512px;max-height:512px;>";
		}
		else	{
			$reactMedia = "<a style=font-size:32px target=_blank href = $reactLink>რეაგირების ფაილის გახსნა</a>";
		}
		echo "<font size=25>შევსებულია</font><br><br>" . "<div id=textbackground>" . "<font size=25>" . $react . "</font>" . "</div>" . "<br>" . $reactMedia;
	} else{
		echo "0" . mysqli_error($dbc);
	}
	mysqli_close($dbc);
    }
}
else	{
	echo "-2";
}
?>