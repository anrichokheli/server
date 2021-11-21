<?php
sleep(1);
if(isset($_POST["login"]) && $_POST["login"] === "შესვლა")    {
    $login = parse_ini_file(dirname(getcwd()) . "/private/login.ini");
    $name = $login["name"];
    $password = $login["password"];
    $file = file_get_contents(dirname(getcwd()) . "/private/keyfile_login");
    if(($_POST["name"] === $name) && ($_POST["password"] === $password) && (file_get_contents($_FILES["file"]["tmp_name"]) === $file))    {
        session_start();
        if(isset($_SESSION["verify_mode"]) && $_SESSION["verify_mode"] === true)  {
            $_SESSION["verified"] = true;
            $_SESSION["verify_mode"] = false;
            echo "<script>
            window.location.replace(\"delete.php?n=" . $_POST["n"] . "\");
            </script>";
            //header('location: delete.php');
        }
        else    {
            $_SESSION["qveitisosreactloggedin"] = true;
            $n = intval(file_get_contents("reactweb_n"));
            ++$n;
            file_put_contents("reactweb_n", strval($n));
            ?><script>
            window.location.replace('reactweb.php');
            </script><?php
            //header('location: reactweb.php');
        }
    }
    else    {
        ?><script>
        window.location.replace('login.php?mode=wrong');
        </script><?php
        //header('location: login.php');
    }
}
else	{
	?><script>
	window.location.replace('login.php');
	</script><?php
}
?>