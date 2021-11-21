<?php
session_start();
if(!(isset($_SESSION["qveitisosreactloggedin"]) && $_SESSION["qveitisosreactloggedin"] === true))    {
	session_destroy();
	exit;
}
define("protectedPrivatePath", dirname(getcwd()) . "/protected/private/");
if(isset($_POST["logout"]))    {
	if(session_status() != PHP_SESSION_ACTIVE)	{
		session_start();
	}
    $_SESSION = array();
    session_destroy();
    $n = intval(file_get_contents(protectedPrivatePath . "reactweb_n"));
    --$n;
    file_put_contents(protectedPrivatePath . "reactweb_n", strval($n));
    header("location: reactweb.php");
}
?>