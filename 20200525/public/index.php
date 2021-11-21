<title>ქვეითი SOS</title>
<head><link rel="icon" href="<?php include 'get_web_url.php' ?>/qveitiSOS.jpg"></head>
<html>
<style>
	#page	{
		text-align: center;
		animation-name: invisibleToVisible;
		animation-duration: 0.5s;
	}
	@keyframes invisibleToVisible	{
		from {opacity: 0;}
		to {opacity: 1;}
	}
	#title	{
		display: inline;
		font-size: 48;
	}
	button	{
		border: none;
		color: white;
		padding: 8px 16px;
		text-align: center;
		text-decoration: none;
		display: inline-block;
		font-size: 25px;
		margin: 4px 2px;
		transition-duration: 0.4s;
		cursor: pointer;
		background-color: white;
		color: black;
		border-radius: 8px;
		border: 2px solid #4000ff;
	}
	button:hover	{
		background-color: #4000ff;
		color: white;
	}
	button span	{
		cursor: pointer;
		display: inline-block;
		position: relative;
		transition: 0.25s;
		color: black;
	}
	button span:after {
		content: '\00bb';
		position: absolute;
		opacity: 0;
		top: 0;
		right: -20px;
		transition: 0.25s;
		color: white;
	}
	button:hover span {
		padding-right: 25px;
		color: white;
	}
	button:hover span:after {
		opacity: 1;
		right: 0;
		color: white;
	}
	.animate-top	{
		position: relative;
		animation: animatetop 0.25s
	}
	@keyframes animatetop	{
		from	{
			top: -300px;
			opacity: 0
		}
		to	{
			top: 0;
			opacity: 1
		}
	}
	#reactButton	{
		border: 2px solid #4080ff;
	}
	#reactButton:hover	{
		background-color: #4080ff;
	}
</style>
<div id="page">
	<link rel="stylesheet">
	<div class="animate-top">
		<p id="title">
			<b><font color=blue>ქვეითი </font><font color=red>SOS</font></b>
		</p>
		<br><br>
		<image src=<?php include 'get_web_url.php' ?>/qveitiSOSimage.png height=20%></image>
		<br><br>
	</div>
	<button type="button" id="databaseButton"><span>მონაცემთა ბაზა</span></button>
	<button type="button" id="accountsDatabaseButton"><span>რეგისტრირებული მომხმარებლები</span></button>
	<br>
	<button type="button" id="databaseButtonTable"><span>მონაცემთა ბაზა<br>(ცხრილი)</span></button>
	<button type="button" id="accountsDatabaseButtonTable"><span>რეგისტრირებული მომხმარებლები<br>(ცხრილი)</span></button>
	<br>
	<button type="button" id="databaseButtonApp"><span>მონაცემთა ბაზა<br>(მობილური ვერსია)</span></button>
	<button type="button" id="accountsDatabaseButtonApp"><span>რეგისტრირებული მომხმარებლები<br>(მობილური ვერსია)</span></button>
	<br>
	<button type="button" id="statisticsButton"><span>სტატისტიკა</span></button>
	<br>
	<button type="button" id="reactButton"><span>რეაგირების ვებ გვერდი</span></button>
</div>
<script>
	var database = document.getElementById("databaseButton");
	var databaseTable = document.getElementById("databaseButtonTable");
	var databaseApp = document.getElementById("databaseButtonApp");
	var statistics = document.getElementById("statisticsButton");
	var react = document.getElementById("reactButton");
	var accounts = document.getElementById("accountsDatabaseButton");
	var accountsTable = document.getElementById("accountsDatabaseButtonTable");
	var accountsApp = document.getElementById("accountsDatabaseButtonApp");
	database.onclick = function()	{
		window.open("getdatabase.php");
	};
	databaseTable.onclick = function()	{
		window.open("get.php");
	};
	databaseApp.onclick = function()	{
		window.open("get_app.php?search_for=all");
	};
	statistics.onclick = function()	{
		window.open("statistics.php");
	};
	react.onclick = function()	{
		window.open("reactweb.php");
	};
	accounts.onclick = function()	{
		window.open("get_accounts.php");
	};
	accountsTable.onclick = function()	{
		window.open("get_accounts_table.php");
	};
	accountsApp.onclick = function()	{
		window.open("get_accounts_app.php");
	};
</script>
</html>