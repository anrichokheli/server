<?php
session_start();
if(!(isset($_SESSION["qveitisosreactloggedin"]) && $_SESSION["qveitisosreactloggedin"] === true))    {
	session_destroy();
	exit("-1");
}
if(!defined("protectedPrivatePath"))	define("protectedPrivatePath", dirname(getcwd()) . "/protected/private/");
require(protectedPrivatePath . "checkAccountPermission.php");
if(!getAccountPermission("react", $_SESSION["account_id"]))    {
    exit("!REACT_PERMISSION");
}
if(!defined("protectedPublicPath"))	define("protectedPublicPath", dirname(getcwd()) . "/protected/public/");
if(!defined("reactMediaFolderPath"))	define("reactMediaFolderPath", protectedPublicPath . "uploads/react_media/");
if(isset($_POST["n"]) && isset($_POST["text"]) && isset($_FILES['media'])) {
    $text = nl2br(htmlspecialchars($_POST["text"]));
    $file = $_FILES['media']['tmp_name'];
    $ext = explode("/", mime_content_type($file))[1];
    $T = /*hr*/time();
    $name = $T/*[0] . $T[1]*/ . "_" . rand(0, 1000000) . "." . $ext;
    require dirname(getcwd()) . "/protected/private/check_n_input.php";
    $n = $_POST["n"];
    if(!empty($text) && !empty($file))    {
        $path = reactMediaFolderPath . $name;
        $files = scandir(reactMediaFolderPath);
        $exists = 0;
        foreach($files as $dirfile)   {
	    if(!empty(str_replace(".", "", $dirfile)))	{
    		    if(file_get_contents($file) === file_get_contents(reactMediaFolderPath . $dirfile))    {
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
        /*else    {
            $media = "";
        }*/
	include dirname(getcwd()) . "/protected/private/mysqli_database.php";
	$dbc = $mysqliConnectValue;
	$reactTime = time();
	define("reactDataPath", protectedPrivatePath . "data/reacts/");
	$fileIndex = count(scandir(reactDataPath)) - 2;
	file_put_contents(reactDataPath . $fileIndex, serialize(array($_SESSION["account_id"], $reactTime, $n, $text, $name)));
	$text = mysqli_real_escape_string($dbc, $text);
	$query = "UPDATE violations SET react='$text', react_media='$name', react_time='$reactTime' WHERE n='$n'";
	if(mysqli_query($dbc, $query)){
		$row = mysqli_fetch_array(mysqli_query($dbc, "SELECT * FROM violations WHERE n = '$n'"));
		$react = $row["react"];
		$reactLink = "/?/uploads/react_media/" . $row["react_media"];
		$type = explode("/", mime_content_type(reactMediaFolderPath . $row["react_media"]))[0];
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