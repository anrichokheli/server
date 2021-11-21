<?php
//error_reporting(E_ALL & ~E_NOTICE);
/*
$files = scandir(sys_get_temp_dir());
$count = 0;
session_start();
$isLoggedIn = (isset($_SESSION["qveitisosreactloggedin"]) && ($_SESSION["qveitisosreactloggedin"] === true));
$sessionID = session_id();
if(!$isLoggedIn)	{
	session_destroy();
}
foreach($files as $dirfile)   {
	if(!empty(str_replace(".", "", $dirfile)))	{
		$filename = sys_get_temp_dir() . "/" . $dirfile;
		if(file_exists($filename))	{
			if(strpos($dirfile, $sessionID) !== FALSE)	{
				if($isLoggedIn)	$count++;
			}
			else	{
				if(is_file($filename) && is_readable($filename) && is_writeable($filename))	{
					$size = filesize($filename);
					if($size > 0)	{
						$handle = fopen($filename, "r");
						$contents = fread($handle, $size);
						fclose($handle);
						if(strpos($contents, "qveitisosreactloggedin|b:1") !== FALSE)	{
							$count++;
						}
					}
				}
			}
		}
	}
}
*/
include 'sessions2.php';
$count = file_get_contents("reactweb_n");
if(!isset($echoDisable))	{
	echo $count;
}
?>