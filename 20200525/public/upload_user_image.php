<?php
$file = file_get_contents('php://input');
$temp = sys_get_temp_dir() . "/" . "tmp" . hrtime(true) . rand(0, time());
file_put_contents($temp, $file);
$file_info_array = explode("/", mime_content_type($temp));
unlink($temp);
$type = $file_info_array[0];
$extension = "." . $file_info_array[1];
if($type === "image")    {
$files = scandir('users_images');
$exists = 0;
foreach($files as $dirfile)   {
	if(!empty(str_replace(".", "", $dirfile)))	{
    		if($file === file_get_contents("users_images/" . $dirfile))    {
        		$file_name = $dirfile;
        		$exists = 1;
        		break;
    		}
	}
}
if(!$exists)    {
    $T = hrtime();
    $name = $T[0] . $T[1] . rand(0, time()) . $extension;
    $path = 'users_images/' . $name;
    file_put_contents($path, $file);
    $insert = file_exists($path);
    if($insert){
    echo "1" . $name;
    } else{
    echo "0";
    }
}
else    {
    $database = parse_ini_file(dirname(getcwd()) . "/private/database.ini");
    $conn = mysqli_connect($database["host"], $database["username"], $database["password"], $database["name"]);
    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);
    $userImageName = false;
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            if(strpos($row["image"], $file_name) !== false)    {
                $userImageName = $file_name;
                break;
            }
        }
    }
    if($userImageName)    {
        echo "1" . $userImageName;
    }
}
}
else    {
    echo "-1";
}
?>