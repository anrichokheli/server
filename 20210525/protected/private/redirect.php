<?php
define("protectedPrivatePath", dirname(getcwd()) . "/protected/private/");
define("secretPath", protectedPrivatePath . "secret/");
//define("protectedPublicPath", dirname(getcwd()) . "/protected/public/");
define("securePath", protectedPrivatePath . "/secure/");
if(isset($_POST["login"]) && $_POST["login"] === "1")    {
	sleep(1);
	if(!(isset($_SESSION["captchaCorrect"]) && $_SESSION["captchaCorrect"] == 1))	{
		exit("!CAPTCHA");
	}
	$_SESSION["captchaCorrect"] = 0;
	if(empty($_POST["name"]) || empty($_POST["password"]) || empty($_FILES["file"]["tmp_name"]))	{
		exit("მონაცემები არასაკმარისია");
	}
	$verifyMode = (isset($_GET["mode"]) && $_GET["mode"] == "verify");
        $accountExists = 0;
	$username = htmlspecialchars(mb_substr($_POST["name"], 0, 50));
	include_once(protectedPrivatePath . "mysqli_database.php");
	$dbc = $mysqliConnectValue;
	$stmt = mysqli_prepare($dbc, "SELECT id, account_name, password FROM staff WHERE account_name=?");
	mysqli_stmt_bind_param($stmt, "s", $username);
        if(mysqli_stmt_execute($stmt))    {
            mysqli_stmt_store_result($stmt);
            if(mysqli_stmt_num_rows($stmt) == 1)    {
                $accountExists = 1;
            }
            mysqli_stmt_bind_result($stmt, $accountID, $name, $password);
            mysqli_stmt_fetch($stmt);
        }
        mysqli_stmt_close($stmt);
        mysqli_close($dbc);
    //$login = parse_ini_file(securePath . "login.ini");
    //$name = $login["name"];
    //$password = $login["password"];
	$nameAndPasswordCorrect = ($accountExists && ($username === $name) && password_verify($_POST["password"], $password));
	$keyFileCorrect = ($accountExists && (file_get_contents($_FILES["file"]["tmp_name"]) === file_get_contents(secretPath . $accountID . "/keyfile_login")));
	if($nameAndPasswordCorrect)	{
		$keyFileType = "login";
		require protectedPrivatePath . "login_security.php";
	}
    if($nameAndPasswordCorrect && $keyFileCorrect)    {
        if(session_status() != PHP_SESSION_ACTIVE)	{
		session_start();
	}
        if($verifyMode)  {
            $_SESSION["verified_" . preg_replace('/\D/', '', $_GET["id"])] = true;
            //$_SESSION["verify_mode"] = false;
            echo "<script>
            //window.location.replace(\"delete.php?n=" . $_POST["n"] . "\");
            window.location.replace(\"delete.php?id=" . $_GET["id"] . "\");
            </script>";
            //header('location: delete.php');
        }
        else    {
			//$_SESSION["username"] = $username;
			$_SESSION["account_id"] = $accountID;
            $_SESSION["qveitisosreactloggedin"] = true;
            $n = intval(file_get_contents(protectedPrivatePath . "reactweb_n"));
            ++$n;
            file_put_contents(protectedPrivatePath . "reactweb_n", strval($n));
		exit("<script>window.location.replace(\"reactweb.php?mode=all\");</script>");
        }
    }
    else    {
	if(isset($filepath) && !file_exists($filepath) && $nameAndPasswordCorrect)	{
		file_put_contents($filepath, time());
	}
	$locationLoginWrong = "reactweb.php?wrong=1";
	if($verifyMode)    {
	    $locationLoginWrong .= "&mode=verify&id=" . $_GET["id"];
	}
	exit("<script>window.location.replace(\"" . $locationLoginWrong . "\");</script>");
    }
}
?>