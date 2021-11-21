<?php
session_start();
if(isset($_SESSION["qveitisosreactloggedin"]) && $_SESSION["qveitisosreactloggedin"] === true)	{
	define("deleteMode", "");
	include 'getdatabase.php';
}
else    {
	session_destroy();
	?><script>
	window.location.replace('login.php');
	</script><?php
}
?>