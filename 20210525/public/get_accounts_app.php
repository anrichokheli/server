<?php
	$darkMode = 1;
	if(isset($_COOKIE["darkmode"]))	{
		$darkMode = ($_COOKIE["darkmode"] == 1);
	}
	define("darkMode", $darkMode);
	unset($darkMode);
	if(darkMode)    {
		echo "
			<style>
				*	{
					background-color: #000000;
					color: #ffffff;
				}
			</style>
		";
	}
?>
<title>ქვეითი SOS</title>
<head><link rel="icon" href="/pedestriansos.png"></head>
<!DOCTYPE html>
<html>
<head>
	<style>
		table {
			border-collapse: collapse;
			width: 100%;
			color: #000000;
			font-family: monospace;
			font-size: 16px;
			text-align: center;
		}
		#userbtn	{
			border: none;
			padding: 8px;
			text-align: center;
			text-decoration: none;
			display: inline-block;
			font-size: 16px;
			margin: 1px 1px;
			cursor: pointer;
			border-radius: 8px;
			background-color: rgba(192, 192, 192, 0.25);
		}
		#textBackground    {
			border-radius: 2px;
			background: rgba(64, 64, 64, 0.1);
		}
		#nametext	{
			color: #808080;
		}
	</style>
</head>
<body>
<table>
<?php
//define ('weblink', include 'get_web_url.php');
include dirname(getcwd()) . "/protected/private/mysqli_database.php";
$conn = $mysqliConnectValue;
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
} 
$sql = "SELECT * FROM users";
$result = $conn->query($sql);
include 'search_date_time.php';
if(isset($_GET["search_for"]))	{
	$searchFor = $_GET["search_for"];
}
if ($result->num_rows > 0) {
	while($row0 = $result->fetch_assoc())	{
		$items[] = $row0;
	}
	$items = array_reverse($items);
	$users = array();
	foreach($items as $row)	{
		$imageLink = $row["image"];
		$userID = $row["id"];
		$userName = $row["account_name"];
		$name = $row["name"];
		if(empty($imageLink))	{
			$imageLink = "user_icon2.png";
		}
		else	{
			$imageLink = "/?/uploads/users_images/" . $imageLink;
		}
		$image = "<img loading=\"lazy\" src=$imageLink style=max-width:64px;max-height:64px;>";
		if(empty($name))	{
			$name = "<span id=nametext>" . "სახელი" . "</span>";
		}
		$url = "get_app.php?search_for=all&user_id=" . $userID;
		$sql2 = "SELECT * FROM violations";
		$result2 = $conn->query($sql2);
		$uploaded = 0;
		if(!empty($result2))	{
			if ($result2->num_rows > 0)	{
				while($row2 = $result2->fetch_assoc())	{
					if(($row2["user_id"] != 0) && ($row2["user_id"] == $userID))	{
						$uploaded = 1;
						break;
					}
				}
			}
		}
		if(
			(
			(!isset($searchFor))
			||
			(
				isset($searchFor)
				&&
				(
					(
						($searchFor === "accountdateandtime")
						&&
						searchForDateAndTime()
					)
					||
					(
						($searchFor === "accountname")
						&&
						isset($_GET["accountname"])
						&&
						(strpos($row["account_name"], $_GET["accountname"]) !== FALSE)
					)
					||
					(
						($searchFor === "name")
						&&
						isset($_GET["name"])
						&&
						(strpos($row["name"], $_GET["name"]) !== FALSE)
					)
					||
					(
						($searchFor === "everywhere")
						&&
						isset($_GET["everywhere"])
						&&
						(strpos($row["id"] . $row["account_name"] . $row["name"] . $row["time_created"], $_GET["everywhere"]) !== FALSE)
					)
				)
			)
			)
			&&
			(
			(!isset($_GET["filter"]))
			||
			(
				isset($_GET["filter"])
				&&
				(
					(
						($_GET["filter"] === "uploaded")
						&&
						($uploaded)
					)
					||
					(
						($_GET["filter"] === "notuploaded")
						&&
						(!$uploaded)
					)
				)
			)
			)
		)	{
			array_push($users, "<tr><td>" . "#" . $userID . "</td><td>" . "<span id=textBackground>" . $userName . "</span>" . "</td><td>" . $image . "<br>" . $name . "</td><td>" . "<a href=$url target=_blank>" . "<input type=submit id=userbtn value=მეტი»>" . "</a>" . "</td></tr>");
		}
	}
	if(isset($_GET["filter"]))	{
		if($_GET["filter"] == "uploaded")	{
			echo "<i>" . "აქვთ ატვირთული" . "</i>" . "<br><hr><br>";
		}
		else if($_GET["filter"] == "notuploaded")	{
			echo "<i>" . "არ აქვთ ატვირთული" . "</i>" . "<br><hr><br>";
		}
	}
	if(isset($searchFor))	{
		$quantity = count($users);
		if($quantity > 0)	{
			echo "<i>" . "მოიძებნა " . $quantity . " მონაცემი" . "</i>" . "<br><hr><br>";
		}
		else	{
			echo "<font size=25>მონაცემები არ არის</font>";
		}
	}
	foreach($users as $userRow)	{
		echo $userRow;
	}
}
else	{
	echo "<font size=25>" .  "ცარიელია" . "</font>";
}
echo "</table>";
$conn->close();
?>