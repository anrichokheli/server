<?php
if(!defined("protectedPrivatePath"))
	define("protectedPrivatePath", dirname(getcwd()) . "/protected/private/");
//if(!defined("protectedPublicPath"))
//	define("protectedPublicPath", dirname(getcwd()) . "/protected/public/");
error_reporting(E_ALL & ~E_NOTICE);
$files = scandir(sys_get_temp_dir());
$t = parse_ini_file(protectedPrivatePath . "times.ini")["reactwebsessiondeletetime"];
$n = intval(file_get_contents(protectedPrivatePath . "reactweb_n"));
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
	file_put_contents(protectedPrivatePath . "reactweb_n", strval($count));
}
?>