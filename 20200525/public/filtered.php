<?php
	session_start();
	if(!(isset($_SESSION["qveitisosreactloggedin"]) && $_SESSION["qveitisosreactloggedin"] === true))	{
		session_destroy();
	}
	function redirectToGetDatabase()	{
		?><script>
		window.location.replace('getdatabase.php');
		</script><?php
		exit;
	}
	if(!isset($_GET["mode"]))	{
		redirectToGetDatabase();
	}
	$mode = $_GET["mode"];
	if($mode === "yes")	{
		define("yesMode", "");
	}
	else if($mode === "no")	{
		define("noMode", "");
	}
	else	{
		redirectToGetDatabase();
	}
	include 'getdatabase.php';
?>