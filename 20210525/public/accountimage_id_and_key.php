<?php
	if(!isset($_POST["account_name"]) || !isset($_POST["password"]))	{
		exit("-1");
	}
	define("protectedPrivatePath", dirname(getcwd()) . "/protected/private/");
	include protectedPrivatePath . "mysqli_database.php";
	$stmt = mysqli_prepare($mysqliConnectValue, "SELECT * FROM users WHERE account_name=?");
	$accountname = htmlspecialchars($_POST["account_name"]);
	mysqli_stmt_bind_param($stmt, "s", $accountname);
	if(mysqli_stmt_execute($stmt))	{
		mysqli_stmt_bind_result($stmt, $id, $account_name, $password, $name, $image, $time_created);
		mysqli_stmt_fetch($stmt);
		if(password_verify($_POST["password"], $password))	{
			$ID = /*hr*/time(/*1*/) . random_int(0, time());
			$KEY = "";
			for($count = 0; $count < 256; $count++)   {
				$KEY .= random_int(0, 9);
			}
			if(file_put_contents(protectedPrivatePath . "accountimage_keys/" . $ID, $KEY . '#' . $id))	{
				echo $ID . "*" . $KEY;
			}
		}
		else	{
			echo "-3";
		}
	}
	else	{
		echo "-2";
	}
	mysqli_stmt_close($stmt);
	mysqli_close($mysqliConnectValue);
?>