<?php
exit("00000000");
__halt_compiler();
session_start();
if(isset($_SESSION["qveitisosreactloggedin"]) && $_SESSION["qveitisosreactloggedin"] === true)	{
	define("deleteMode", "");
	include 'getdatabase.php';
}
else    {
	session_destroy();
	?><script>
	window.location.replace('reactweb.php');
	</script><?php
}
?>