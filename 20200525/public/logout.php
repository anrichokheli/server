<?php
if(isset($_POST["logout"]))    {
    session_start();
    $_SESSION = array();
    session_destroy();
    $n = intval(file_get_contents("reactweb_n"));
    --$n;
    file_put_contents("reactweb_n", strval($n));
    header("location: login.php");
}
?>