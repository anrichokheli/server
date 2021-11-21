<html>
<title>ქვეითი SOS</title>
<head><link rel="icon" href="<?php include 'get_web_url.php' ?>/qveitiSOS.jpg"></head>
<style>
#textBackground    {
    border-radius: 2px;
    background: rgba(64, 64, 64, 0.1);
}
div.center {
text-align: center;
}
#react {
width: 100%;
text-align: center;
}
#category {
width: 100%;
text-align: center;
}
canvas {
display: inline;
}
</style>
<div class="center">
<font size="5">
<?php
date_default_timezone_set("Etc/GMT-4");
echo date("Y-m-d") . " " . date("H:i:s");
/*
$filename = "n.txt";
$handle = fopen($filename, "r");
$n = fread($handle, filesize($filename));
fclose($handle);
*/
$n = intval(file_get_contents("uploaded_n"));
$GLOBALS["n"] = $n;
$database = parse_ini_file(dirname(getcwd()) . "/private/database.ini");
?>
<br>
<br>
<strong>რეაგირებულის წილი</strong>
<br>
<i>სერვერზე არსებული მასალების რაოდენობის</i>
</font>
</div>
<canvas id="react" width="500" height="500"></canvas>
<?php php("text"); ?>
<div class="center">

<font size="5">
<br>
<strong>კატეგორიების წილები</strong>
</font>
</div>
<?php php("category"); ?>
<br>
<center>
	<strong>
		<font size="5">
			მომხმარებლები
		</font>
	</strong>
</center>
<br>
<?php
	$database = $GLOBALS["database"];
	$dbc = mysqli_connect($database["host"], $database["username"], $database["password"], $database["name"]);
	$result = mysqli_query($dbc, "SELECT * FROM users");
	if ($result->num_rows > 0) {
		while($row0 = $result->fetch_assoc()) {
			$items[] = $row0;
		}
	}
	else	{
		$items = array();
	}
	$usersQuantity = count($items);
	$registeredUploads = 0;
	$anonymousUploads = 0;
	$result = mysqli_query($dbc, "SELECT * FROM violations");
	if ($result->num_rows > 0) {
		while($row0 = $result->fetch_assoc()) {
			if($row0["user_id"] == 0)	{
				++$anonymousUploads;
			}
			else	{
				++$registeredUploads;
			}
		}
	}
	mysqli_close($dbc);
	$all = $GLOBALS["ALL"];
	if($all != 0)	{
		$registeredUploads2 = round(($registeredUploads / $all) * 100, 2);
		$anonymousUploads2 = round(($anonymousUploads / $all) * 100, 2);
	}
	else	{
		$registeredUploads2 = 0;
		$anonymousUploads2 = 0;
	}
	echo "
		<p id=textBackground>
		<font size=5><b>რეგისტრირებული მომხმარებლების რაოდენობა:</b><br>$usersQuantity</font><br>
		</p>
		<p id=textBackground>
		<font size=5><b>რეგისტრირებული მომხმარებლების მიერ ატვირთული მასალების რაოდენობა:</b><br>
		$registeredUploads ($registeredUploads2%)</font><br>
		</p>
		<p id=textBackground>
		<font size=5><b>არარეგისტრირებული მომხმარებლების მიერ ატვირთული მასალების რაოდენობა:</b><br>
		$anonymousUploads ($anonymousUploads2%)</font><br>
		</p>
	";
?>
<script>
var efficiency = <?php php("efficiency"); ?>;
var c = document.getElementById("react");
var ctx = c.getContext("2d");
ctx.beginPath();
ctx.font = "50px Arial";
ctx.textAlign = "center";
var text = Math.round(efficiency * 100).toString();
text = text.concat("%");
ctx.fillText(text, c.width/2, c.height/2);
ctx.lineWidth = 50;
ctx.strokeStyle = "blue";
efficiency *= 2;
ctx.arc(250, 250, 125, 0, efficiency * Math.PI);
ctx.stroke();
ctx.closePath();
ctx.beginPath();
ctx.strokeStyle = "blue";
ctx.globalAlpha = "0.1";
if(efficiency)
    ctx.arc(250, 250, 125, 0, efficiency * Math.PI, true);
else
    ctx.arc(250, 250, 125, 0, 2 * Math.PI);
ctx.stroke();
</script>
<?php
function getTime($second)  {
    $hour = floor($second / 3600);
    $minute = floor($second / 60) % 60;
    $second %= 60;
    $time = $hour . "სთ " . $minute . "წთ " . $second . "წმ";
    return $time;
}
function php($mode) {
$database = $GLOBALS["database"];
$conn = mysqli_connect($database["host"], $database["username"], $database["password"], $database["name"]);
// Check connection
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT * FROM violations";
$result = $conn->query($sql);
if(!empty($result))    {
if ($result->num_rows > 0) {
// output data of each row
$reacted = 0;
$notReactedQuantity = 0;
$emission = 0;
$pedestrianPlaces = 0;
$road = 0;
$infrastructure = 0;
$sound = 0;
$other = 0;
$time = 0;
$unknown = 0;
$saved = 0;
$deleted = 0;
$statusYes = 0;
$statusNo = 0;
$statusEmpty = 0;
while($row = $result->fetch_assoc()) {
if($row["state"] == 1)	{
	++$statusYes;
}
else if($row["state"] == -1)	{
	++$statusNo;
}
else	{
	++$statusEmpty;
}
if(!empty($row["react"]) && !empty($row["react_media"]) && ($row["react_time"] != 0)) {
	++$reacted;
}
else	{
	++$notReactedQuantity;
}
if((strpos($row["situation"], "DELIMITER_BEFORE_qHwe31xrAO_QVEITIქვეითიSOS" . "გამონაბოლქვი" . "DELIMITER_AFTER_e2QP1tyepu_QVEITIქვეითიSOS")) !== FALSE) {
++$emission;
}
if((strpos($row["situation"], "DELIMITER_BEFORE_qHwe31xrAO_QVEITIქვეითიSOS" . "ტრანსპორტი ქვეითთათვის განკუთვნილ ადგილებზე" . "DELIMITER_AFTER_e2QP1tyepu_QVEITIქვეითიSOS")) !==
FALSE) {
++$pedestrianPlaces;
}
if((strpos($row["situation"], "DELIMITER_BEFORE_qHwe31xrAO_QVEITIქვეითიSOS" . "ქვეითთა უფლებების შელახვა გზის სავალ ნაწილზე" . "DELIMITER_AFTER_e2QP1tyepu_QVEITIქვეითიSOS")) !==
FALSE) {
++$road;
}
if((strpos($row["situation"], "DELIMITER_BEFORE_qHwe31xrAO_QVEITIქვეითიSOS" . "ქვეითთა ინფრასტრუქტურა" . "DELIMITER_AFTER_e2QP1tyepu_QVEITIქვეითიSOS")) !== FALSE) {
++$infrastructure;
}
if((strpos($row["situation"], "DELIMITER_BEFORE_qHwe31xrAO_QVEITIქვეითიSOS" . "ხმაური და სიგნალები" . "DELIMITER_AFTER_e2QP1tyepu_QVEITIქვეითიSOS")) !== FALSE) {
++$sound;

}
if((strpos($row["situation"], "DELIMITER_BEFORE_qHwe31xrAO_QVEITIქვეითიSOS" . "სხვა" . "DELIMITER_AFTER_e2QP1tyepu_QVEITIქვეითიSOS")) !== FALSE) {
++$other;
}
if(empty($row["situation"]))	{
	++$unknown;
}
$uploadTime = $row["time"];
$reactTime = $row["react_time"];
if($reactTime !== "0") {
$time += $reactTime - $uploadTime;
}
//$n = $row["n"];
}
}
}
$n = $GLOBALS["n"];
if($n != 0) {
for($N = 1; $N <= $n; $N++)	{
	$found = 0;
	foreach($result as $ROW)	{
		if($N == $ROW["n"])	{
			$found = 1;
			break;
		}
	}
	if($found)	{
		++$saved;
	}
	else	{
		++$deleted;
	}
}
$GLOBALS["ALL"] = $saved;
$all = $n;
$saved2 = round(($saved / $all) * 100, 2);
$deleted2 = round(($deleted / $all) * 100, 2);
$efficiency = ($reacted / $saved);
$emission2 = $emission / $saved;
$pedestrianPlaces2 = $pedestrianPlaces / $saved;
$road2 = $road / $saved;
$infrastructure2 = $infrastructure / $saved;
$sound2 = $sound / $saved;
$other2 = $other / $saved;
$unknown2 = $unknown / $saved;
$reacted2 = round(($reacted / $saved) * 100, 2);
$notReacted = round((1 - $efficiency) * 100, 2);
$statusYes2 = round(($statusYes / $saved) * 100, 2);
$statusNo2 = round(($statusNo / $saved) * 100, 2);
$statusEmpty2 = round(($statusEmpty / $saved) * 100, 2);
if($reacted !== 0) {
$time /= $reacted;
}

$time = round($time);
$time = getTime($time) . " (" . $time . "წმ)";
}
else	{
$GLOBALS["ALL"] = 0;
$all = $n;
$saved2 = 0;
$deleted2 = 0;
$efficiency = 0;
$emission2 = 0;
$pedestrianPlaces2 = 0;
$road2 = 0;
$infrastructure2 = 0;
$sound2 = 0;
$other2 = 0;
$unknown2 = 0;
$reacted2 = 0;
$notReacted = 0;
$statusYes = 0;
$statusNo = 0;
$statusEmpty = 0;
$statusYes2 = 0;
$statusNo2 = 0;
$statusEmpty2 = 0;
}
if($mode === "efficiency") {
echo $efficiency;
}
else if($mode === "text") {
$echoDisable = 1;
include 'getDevicesNumber.php';
echo "
<p id=textBackground>
<font size=5><b>აიტვირთა:</b><br>$all</font><br>
</p>
<p id=textBackground>
<font size=5><b>სერვერზე ინახება:</b><br>$saved ($saved2%)</font><br>
</p>
<p id=textBackground>
<font size=5><b>წაშლილია:</b><br>$deleted ($deleted2%)</font><br>
</p>
<p id=textBackground>
<font size=5><b>მონიშნულია როგორც შესაბამისი:</b><br>$statusYes ($statusYes2%)</font><br>
</p>
<p id=textBackground>
<font size=5><b>მონიშნულია როგორც შეუსაბამო:</b><br>$statusNo ($statusNo2%)</font><br>
</p>
<p id=textBackground>
<font size=5><b>მონიშნული არ არის:</b><br>$statusEmpty ($statusEmpty2%)</font><br>
</p>
<p id=textBackground>
<font size=5><b>რეაგირებული:</b><br>$reacted ($reacted2%)</font><br>
</p>
<p id=textBackground>
<font size=5><b>არარეაგირებული:</b><br>$notReactedQuantity ($notReacted%)</font><br>
</p>
<p id=textBackground>
<font size=5><b>რეაგირების საშუალო დრო:</b><br>$time</font><br>
</p>
<p id=textBackground>
<font size=5><b>რეაგირების ვებ გვერდზე შესული მოწყობილობების რაოდენობა:</b><br>$count</font><br>
</p>
";
}
else if($mode === "category") {
$emission2 *= 100;
$pedestrianPlaces2 *= 100;
$road2 *= 100;
$infrastructure2 *= 100;
$sound2 *= 100;
$other2 *= 100;
$unknown2 *= 100;
$emission2 = round($emission2, 2);
$pedestrianPlaces2 = round($pedestrianPlaces2, 2);
$road2 = round($road2, 2);
$infrastructure2 = round($infrastructure2, 2);
$sound2 = round($sound2, 2);
$other2 = round($other2, 2);
$unknown2 = round($unknown2, 2);

echo "
<p id=textBackground>
<font size=5><b>გამონაბოლქვი:</b><br>$emission ($emission2%)</font><br>
</p>
<p id=textBackground>
<font size=5><b>ტრანსპორტი ქვეითთათვის განკუთვნილ ადგილებზე:</b><br>
$pedestrianPlaces ($pedestrianPlaces2%)</font><br>
</p>
<p id=textBackground>
<font size=5><b>ქვეითთა უფლებების შელახვა გზის სავალ ნაწილზე:</b><br>$road
($road2%)</font><br>
</p>
<p id=textBackground>
<font size=5><b>ქვეითთა ინფრასტრუქტურა:</b><br>$infrastructure
($infrastructure2%)</font><br>
</p>
<p id=textBackground>
<font size=5><b>ხმაური და სიგნალები:</b><br>$sound ($sound2%)</font><br>
</p>
<p id=textBackground>
<font size=5><b>სხვა:</b><br>$other ($other2%)</font><br>
</p>
<p id=textBackground>
<font size=5><b>უცნობი:</b><br>$unknown ($unknown2%)</font><br>
</p>
";
}
$conn->close();
}
?>
</html>