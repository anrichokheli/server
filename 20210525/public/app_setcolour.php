<?php
	setcookie("darkmode", $_GET["darkmode"]);
	if($_GET["darkmode"] == 1)	{
		echo "<style>body{background:#000000;}</style>";
	}
?>