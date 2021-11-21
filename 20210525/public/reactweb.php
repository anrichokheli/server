<?php
if(session_status() != PHP_SESSION_ACTIVE)	{
	session_start();
}
if(isset($_SESSION["qveitisosreactloggedin"]) && $_SESSION["qveitisosreactloggedin"] === true)    {
	if(isset($_GET["mode"]) && $_GET["mode"] === "verify")	{
		include dirname(getcwd()) . "/protected/private/login.php";
	}
	else	{
		echo "<form action=logout.php method=post><input type=submit class=button name=logout value=გამოსვლა></form>";
		include 'getdatabase.php';
	}
}
else    {
	session_destroy();
	include dirname(getcwd()) . "/protected/private/login.php";
}
?>