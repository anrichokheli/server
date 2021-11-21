<title>ქვეითი SOS</title>
<head><link rel="icon" href="/pedestriansos.png"></head>
<?php/*
	if(!isset($_GET["n"]))	{
		exit("!SET GET \"n\"");
	}
*/?>
<html>
<center>
    <image src="delete.png" style="width:512px; height:512px;">
    <br><br>
    <font size="512" color="red">
        <strong>
            <?php
		//define("protectedPrivatePath", dirname(getcwd()) . "/protected/private/");
		//$n = $_GET["n"];
		//$N_STRING = $n;
		require protectedPrivatePath . "check_n_string.php";
		if(strpos($N_STRING, '|') === FALSE)	{
			echo "ატვირთული მასალა №" . $N_STRING . " წაიშალა!";
		}
		else	{
			$lastChar = substr($N_STRING, strlen($N_STRING) - 1);
			if($lastChar == '|')	{
				$N_STRING = substr($N_STRING, 0, strlen($N_STRING) - 1);
			}
			$list = explode('|', $N_STRING);
			echo "წაიშალა " . count($list) . " ატვირთული:<br>";
			$ECHO = "";
			foreach($list as $ID)	{
				$ECHO .= '#' . $ID;
				if($ID != end($list))	{
					$ECHO .= "; ";
				}
				else	{
					$ECHO .= ".";
				}
			}
			echo $ECHO;
		}
            ?>
        </strong>
    </font>
</center>
</html>