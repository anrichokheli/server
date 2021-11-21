<title>ქვეითი SOS</title>
<head><link rel="icon" href="<?php include 'get_web_url.php' ?>/qveitiSOS.jpg"></head>
<html>
<center>
    <image src="delete.png" style="width:512px; height:512px;">
    <br><br>
    <font size="512" color="red">
        <strong>
            <?php
		$n = $_GET["n"];
		if(strpos($n, '|') === FALSE)	{
			echo "ატვირთული მასალა №" . $n . " წაიშალა!";
		}
		else	{
			$lastChar = substr($n, strlen($n) - 1);
			if($lastChar == '|')	{
				$n = substr($n, 0, strlen($n) - 1);
			}
			$list = explode('|', $n);
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