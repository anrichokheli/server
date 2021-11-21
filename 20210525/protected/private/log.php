<?php
define("logsPath", dirname(getcwd()) . "/protected/private/logs");
function createDirectory($directoryName)    {
	if(!file_exists($directoryName))    {
		mkdir($directoryName);
	}
}
createDirectory(logsPath);
$data = $_SERVER;
date_default_timezone_set ("Etc/GMT-4");
$data = implode("\n", $data);
$data .= "\n\n" . gethostbyaddr($_SERVER["REMOTE_ADDR"]);
$t = time();
$folderPath = logsPath . $_SERVER["PHP_SELF"];
createDirectory($folderPath);
file_put_contents($folderPath . "/" . date("Y-m-d", $t) . " " . date("H-i-s", $t) . "_" . microtime(1) . "_" . rand(0, microtime(1)) . ".txt", $data);
?>