<?php
session_start();
if(isset($_SESSION["qveitisosreactloggedin"]) && $_SESSION["qveitisosreactloggedin"] === true)    {
    $_SESSION["micros"] = microtime();
}
else    {
    session_destroy();
}
include 'sessions2.php';
?>