<?php
	if(!isset($_POST["n"]) || !isset($_POST["key"]))	{
		exit("-1");
	}
	define("protectedPrivatePath", dirname(getcwd()) . "/protected/private/");
	require protectedPrivatePath . "check_n_input.php";
	include protectedPrivatePath . "mysqli_database.php";
	$queryValue = mysqli_query($mysqliConnectValue, "SELECT * FROM violations WHERE n='$n'");
	mysqli_close($mysqliConnectValue);
	if(!$queryValue)	{
		exit("-2");
	}
	if(mysqli_fetch_array($queryValue)["upload_key"] !== $_POST["key"])	{
		exit("0");
	}
	$ID = /*hr*/time(/*1*/) . random_int(0, time());
	$KEY = "";
	for($count = 0; $count < 256; $count++)   {
		$KEY .= random_int(0, 9);
	}
	if(file_put_contents(protectedPrivatePath . "sound_keys/" . $ID, $KEY . '#' . $n))	{
		echo $ID . "*" . $KEY;
	}
	else	{
		echo "-3";
	}
?>