<?php
	require "prepend.php";
?>
<title>ქვეითი SOS</title>
<head><link rel="icon" href="/pedestriansos.png"></head>
<meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1">
<style>
	body	{
		font-size: 32;
		text-align: center;
	}
	#error	{
		color: #ff0000;
		font-weight: bold;
	}
	#info	{
		color: #555;
	}
	#inputURL	{
		color: #111;
	}
	#qveitiSOSimage	{
		width: 128;
	}
</style>
<html>
	<span id="title">
	<b><font color=blue>ქვეითი </font><font color=red>SOS</font></b>
	</span>
	<br><br>
	<image id="qveitiSOSimage" src="/pedestriansos2.png"></image>
	<br><br>
	<img src="/?/images/404.png" / >
	<div id="error">
		შეცდომა! 404
	</div>
	<br>
	<div id="info">
		მისამართზე: "<span id="inputURL"></span>" მონაცემები არ არის
	</div>
</html>
<script>
	document.getElementById("inputURL").innerHTML = window.location.pathname;
</script>