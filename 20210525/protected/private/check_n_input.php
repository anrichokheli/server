<?php
if(isset($_GET["n"]))	{
	$n = $_GET["n"];
}
else if(isset($_POST["n"]))	{
	$n = $_POST["n"];
}
$n = ltrim(preg_replace("/[^0-9]/", '', $n), '0');
if(!(ctype_digit($n) && ($n > 0)))	{
	exit("შეცდომა! რიგითი ნომერი (n) უნდა იყოს მთელი დადებითი (ნატურალური) რიცხვი");
}
?>