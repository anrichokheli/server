<?php
session_start();
if(isset($_SESSION["qveitisosreactloggedin"]) && $_SESSION["qveitisosreactloggedin"] === true)    {
	echo "<form action=logout.php method=post><input type=submit class=button name=logout value=გამოსვლა></form>";
	include 'getdatabase.php';
}
else    {
    session_destroy();
    ?><script>
    window.location.replace('login.php');
    </script><?php
    //header('location: login.php');
}
?>