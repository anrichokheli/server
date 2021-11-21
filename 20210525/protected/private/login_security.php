<?php
require "savelogindata.php";
define("lockTime", 60);
$filepath = secretPath . $accountID . "/incorrect_keyfile_time_" . $keyFileType;
if(file_exists($filepath))	{
	$t = file_get_contents($filepath);
	if((time() - $t) < lockTime)	{
		$page = file_get_contents(protectedPrivatePath . "loginlocked.html");
		date_default_timezone_set("Etc/GMT-4");
		$t2 = $t + lockTime;
		$datetime = date("Y-m-d", $t2) . " " . date("H:i:s", $t2);
		$page = str_replace("DATE_AND_TIME", $datetime, $page);
		exit($page);
	}
	else	{
		unlink($filepath);
	}
}
?>