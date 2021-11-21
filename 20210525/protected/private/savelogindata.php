<?php
	define("loginDataPath", dirname(getcwd()) . "/protected/private/data/logins/");
	$loginIndex = count(scandir(loginDataPath)) - 2;
	$loginTime = /*hr*/time(1);
	if(!isset($keyFileCorrect))	{
		$keyFileCorrect = -1;
	}
	$loginData = serialize(array($accountID, $loginTime, $_SERVER["PHP_SELF"], isset($_GET["mode"]) && $_GET["mode"] == "verify", $_SERVER["REMOTE_ADDR"], $_SERVER["HTTP_USER_AGENT"], $keyFileCorrect));
	file_put_contents(loginDataPath . $loginIndex, $loginData);
?>