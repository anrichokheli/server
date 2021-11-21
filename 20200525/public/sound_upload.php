<?php
$paths = array();
$file = file_get_contents('php://input');
$T = hrtime();
$temp = sys_get_temp_dir() . "/" . "tmp" . $T[0] . "_" . $T[1] . rand(0, time());
file_put_contents($temp, $file);
$file_info_array = explode("/", mime_content_type($temp));
$type = $file_info_array[0];
$extension = "." . $file_info_array[1];
if(strpos($extension, ".3gp") !== FALSE)    {
$T = hrtime();
$temp_name = "tmp_mp3_" . $T[0] . "_" . $T[1] . "_" . rand(0, time());
$temp_path = sys_get_temp_dir() . "/" . $temp_name . ".mp3";
exec('ffmpeg -i ' . $temp . ' ' . $temp_path);
$files = scandir('sound');
$exists = 0;
foreach($files as $dirfile)   {
	if(!empty(str_replace(".", "", $dirfile)))	{
    		if(file_get_contents($temp_path) === file_get_contents("sound/" . $dirfile))    {
        		$file_name = $dirfile;
        		$exists = 1;
        		break;
    		}
	}
}
if(!$exists)    {
    $T = hrtime();
    $name = $T[0] . "_" . $T[1] . "_" . rand(0, time());
    $path = "sound/" . $name . ".mp3";
    copy($temp_path, $path);
    $insert = file_exists($path);
    if($insert){
    echo "1" . $name;
    } else{
    echo "0";
    }
}
else    {
    echo "-2";
}
unlink($temp_path);
}
else    {
    echo "-1";
}
unlink($temp);
?>