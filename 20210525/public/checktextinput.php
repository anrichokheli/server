<?php
sleep(1);
session_start();
if(isset($_SESSION["qveitisosreactloggedin"]) && $_SESSION["qveitisosreactloggedin"] === true)    {
    define("protectedPrivatePath", dirname(getcwd()) . "/protected/private/");
    require(protectedPrivatePath . "checkAccountPermission.php");
    if(!getAccountPermission("delete", $_SESSION["account_id"]))    {
        exit("!DELETE_PERMISSION");
    }
	define("session_numberinimage", "numberinimage_" . preg_replace('/\D/', '', $_GET["id"]));
    if(isset($_SESSION[session_numberinimage]) && isset($_POST["num"]) && isset($_FILES["file"]["tmp_name"]))    {
		define("secretPath", protectedPrivatePath . "secret/");
		$accountID = $_SESSION["account_id"];
		$keyFileCorrect = (file_get_contents($_FILES["file"]["tmp_name"]) === file_get_contents(secretPath . $accountID . "/keyfile_delete"));
		$keyFileType = "delete";
		require protectedPrivatePath . "login_security.php";
        if(($_POST["num"] === $_SESSION[session_numberinimage]) && $keyFileCorrect)    {
            echo "1";
        }
        else    {
			if(!$keyFileCorrect)	{
				file_put_contents($filepath, time());
			}
            echo "0";
        }
    }
}
else    {
    session_destroy();
    ?><script>
    window.location.replace('login.php');
    </script><?php
    //header('location: login.php');
}