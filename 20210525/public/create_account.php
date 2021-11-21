<?php
if(!isset($_POST['account_name']) || !isset($_POST['password']))	{
	exit("-2");
}
$_POST['text'] = $_POST['account_name'];
$returnMode = 1;
include 'check_account_name.php';
if(!$notexists)	{
	exit("-3");
}
define("protectedPrivatePath", dirname(getcwd()) . "/protected/private/");
include protectedPrivatePath . "mysqli_database.php";
$dbc = $mysqliConnectValue;
if(!$dbc) {
die("DATABASE CONNECTION FAILED:" .mysqli_error($dbc));
exit();
}
$dbs = mysqli_select_db($dbc, $database["name"]);
if(!$dbs) {
die("DATABASE SELECTION FAILED:" .mysqli_error($dbc));
exit();
}
$account_name = /*mysqli_real_escape_string($dbc, */htmlspecialchars(mb_substr($_POST['account_name'], 0, 50))/*)*/;
$password = /*mysqli_real_escape_string($dbc, */$_POST['password']/*)*/;
if(!empty(str_replace(" ", "", $account_name)) && !empty($password))	{
$name = "";
//$image = "";
if(isset($_POST['name']) && !empty($_POST['name']))	{
	$name = mysqli_real_escape_string($dbc, htmlspecialchars(mb_substr($_POST['name'], 0, 50)));
}
//if(isset($_POST['image']) && !empty($_POST['image']))	{
//	$image = mysqli_real_escape_string($dbc, $_POST['image']);
//	if(!in_array($image/*pathinfo($image)["filename"] . "." . pathinfo($image)["extension"]*/, scandir(dirname(getcwd()) . "/protected/public/uploads/users_images")))	{
//		$image = "";
//	}
//}
$time = time();
$password = password_hash($password, PASSWORD_DEFAULT);
$mysqli_insert_id = 0;
$stmt = mysqli_prepare($dbc, "INSERT INTO users (account_name, password, name, time_created) VALUES (?, ?, ?, ?)");
mysqli_stmt_bind_param($stmt, "sssi", $account_name, $password, $name, $time);
//$query = "INSERT INTO users (account_name, password, name, image, time_created) VALUES ('$account_name', '$password', '$name', '$image', '$time')";
if(/*mysqli_query($dbc, $query)*/mysqli_stmt_execute($stmt)){
echo "1";
$mysqli_insert_id = mysqli_stmt_insert_id($stmt);
} else{
echo "0a" . mysqli_error($dbc);
}
$accounts_n = intval(file_get_contents(protectedPrivatePath . "accounts_n"));
++$accounts_n;
file_put_contents(protectedPrivatePath . "accounts_n", strval($accounts_n));
file_put_contents(protectedPrivatePath . "data/accounts/" . $accounts_n, serialize(array($mysqli_insert_id, $account_name, $password, $name, $time)));
}
else	{
	echo "-1a";
}
mysqli_stmt_close($stmt);
mysqli_close($dbc);
?>