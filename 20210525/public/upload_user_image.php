<?php
if(!defined("protectedPrivatePath"))	define("protectedPrivatePath", dirname(getcwd()) . "/protected/private/");
if(!defined("usersImagesPath"))	define("usersImagesPath", dirname(getcwd()) . "/protected/public/uploads/users_images/");
if(!isset($_GET["id"]) || !isset($_GET["key"]))	{
	exit("-3");
}
$correct = 0;
$keyFilePath = protectedPrivatePath . "accountimage_keys/" . $_GET["id"];
if(file_exists($keyFilePath))	{
	$keyFileContent = explode("#", file_get_contents($keyFilePath));
	if($keyFileContent[0] === $_GET["key"])	{
		$id = $keyFileContent[1];
		$correct = 1;
	}
}
if(!$correct)	{
	exit("-4");
}
$allowedExtensions = array("bmp", "gif", "ico", "jpg", "png",/* "svg",*/ "tif", "webp");
$file = file_get_contents('php://input');
$temp = protectedPrivatePath . "temp/tmp" . /*hr*/time(/*true*/) . rand(0, time());
file_put_contents($temp, $file);
$mimeContentType = mime_content_type($temp);
unlink($temp);
if(!$mimeContentType || (strpos($mimeContentType, '/') === FALSE)/*!str_contains($mimeContentType, '/')*/)	exit("-2");
$file_info_array = explode("/", $mimeContentType);
$type = $file_info_array[0];
$extension = $file_info_array[1];
if($extension === "vnd.microsoft.icon")	{
	$extension = "ico";
}
else if($extension === "jpeg")	{
	$extension = "jpg";
}
else if($extension === "svg+xml")	{
	$extension = "svg";
}
else if($extension === "tiff")	{
	$extension = "tif";
}
if(($type === "image") && in_array(strtolower($extension), array_map("strtolower", $allowedExtensions)))    {
$files = scandir(usersImagesPath);
$exists = 0;
foreach($files as $dirfile)   {
	if(!empty(str_replace(".", "", $dirfile)))	{
    		if($file === file_get_contents(usersImagesPath . $dirfile))    {
        		$file_name = $dirfile;
        		$exists = 1;
        		break;
    		}
	}
}
if(!$exists)    {
    //$T = /*hr*/time();
    //$name = $T/*[0] . $T[1]*/ . rand(0, time()) . '.' . $extension;
    $name = $id . '.' . $extension;
    $path = usersImagesPath . $name;
    file_put_contents($path, $file);
    $insert = file_exists($path);
    if($insert){
        $image_name = $name;
    }
}
else    {
    include protectedPrivatePath . "mysqli_database.php";
    $conn = $mysqliConnectValue;
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
    $conn->close();
    if($userImageName)    {
        $image_name = $userImageName;
    }
}
if(isset($image_name))	{
	include protectedPrivatePath . "mysqli_database.php";
	$stmt = mysqli_prepare($mysqliConnectValue, "UPDATE users SET image=? WHERE id='$id'");
	mysqli_stmt_bind_param($stmt, "s", $image_name);
	if(mysqli_stmt_execute($stmt))	{
		echo "1";
		unlink($keyFilePath);
	}
	mysqli_stmt_close($stmt);
	mysqli_close($mysqliConnectValue);
}
}
else    {
    echo "-1";
}
?>