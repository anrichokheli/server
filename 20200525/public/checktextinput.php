<?php
sleep(1);
session_start();
if(isset($_SESSION["qveitisosreactloggedin"]) && $_SESSION["qveitisosreactloggedin"] === true)    {
    if(isset($_SESSION["numberinimage"]) && isset($_POST["num"]) && isset($_FILES["file"]["tmp_name"]))    {
        if(($_POST["num"] === $_SESSION["numberinimage"]) && (file_get_contents($_FILES["file"]["tmp_name"]) === file_get_contents(dirname(getcwd()) . "/private/keyfile_delete")))    {
            echo "1";
        }
        else    {
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