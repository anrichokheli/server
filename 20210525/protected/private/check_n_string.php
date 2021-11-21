<?php
$N_CHARS = str_split($N_STRING);
foreach($N_CHARS as $char)	{
	if(($char != '0') && ($char != '1') && ($char != '2') && ($char != '3') && ($char != '4') && ($char != '5') && ($char != '6') && ($char != '7') && ($char != '8') && ($char != '9') && ($char != '|'))	{
		exit("! STRING \"n\"");
	}
}
?>