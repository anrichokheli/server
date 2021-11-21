<?php
error_reporting(E_ALL & ~E_NOTICE);
$files = scandir(sys_get_temp_dir());
$t = parse_ini_file(dirname(getcwd()) . "/private/times.ini")["reactwebsessiondeletetime"];
$n = intval(file_get_contents("reactweb_n"));
$count = $n;
foreach($files as $dirfile)   {
	if(!empty(str_replace(".", "", $dirfile)) && (strpos($dirfile, "sess_") === 0))	{
    		$sessionFilePath = sys_get_temp_dir() . "/" . $dirfile;
		if(file_exists($sessionFilePath))	{
                	if(strpos(file_get_contents($sessionFilePath), "qveitisosreactloggedin") !== FALSE)	{
				if(time() - filemtime($sessionFilePath) > $t)    {
        				unlink($sessionFilePath);
					--$count;
    				}
			}
		}
	}
}
if($count !== $n)	{
	file_put_contents("reactweb_n", strval($count));
}
?>