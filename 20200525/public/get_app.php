<title>ქვეითი SOS</title>
<head><link rel="icon" href="<?php include 'get_web_url.php' ?>/qveitiSOS.jpg"></head>
<?php
$DELIMITER_BETWEEN = "DELIMITER_BETWEEN_Aiip9ivope_QVEITIქვეითიSOS";
$DELIMITER_AFTER = "DELIMITER_AFTER_e2QP1tyepu_QVEITIქვეითიSOS";
$DELIMITER_BEFORE = "DELIMITER_BEFORE_qHwe31xrAO_QVEITIქვეითიSOS";
$DELIMITER_AFTER2 = "DELIMITER_AFTER2_PnAogaR8vs_QVEITIქვეითიSOS";
function getDistance($latitude1, $longitude1, $latitude2, $longitude2)    {
    $r = 6371000;
    $d = 2 * $r * asin(sqrt(sin((deg2rad($latitude2) - deg2rad($latitude1)) / 2)**2 + cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * sin((deg2rad($longitude2) - deg2rad($longitude1)) / 2)**2));
    return $d;
}
function isArrayElementInString($array, $string)    {
    $found = 0;
    foreach($array as $element)    {
        if(!empty($element))    {
            if(strpos($string, $element) !== FALSE)    {
                $found = 1;
                break;
            }
        }
    }
    return $found;
}
include 'search_date_time.php';
$searchFor = $_GET["search_for"];
if(isset($_GET["latitude"]))    {
    $latitude = $_GET["latitude"];
}
if(isset($_GET["longitude"]))    {
    $longitude = $_GET["longitude"];
}
if(isset($_GET["radius"]))    {
    $radius = $_GET["radius"];
}
if(isset($_GET["address"]))    {
    $address = $_GET["address"];
}
if(isset($_GET["category"]))    {
    $category = explode($DELIMITER_BETWEEN, str_replace(array($DELIMITER_BEFORE, $DELIMITER_AFTER, $DELIMITER_AFTER2), $DELIMITER_BETWEEN, $_GET["category"]));
}
if(isset($_GET["description"]))    {
    $description = $_GET["description"];
}
if(isset($_GET["reacttext"]))    {
    $reactText = $_GET["reacttext"];
}
if(isset($_GET["everywhere"]))    {
    $everywhere = $_GET["everywhere"];
}
if(isset($_GET["filter"]))    {
    $filter = $_GET["filter"];
}
if(isset($_GET["accuracy1"]))    {
    $accuracy1 = floatval($_GET["accuracy1"]);
}
if(isset($_GET["accuracy2"]))    {
    $accuracy2 = floatval($_GET["accuracy2"]);
}
if(!isset($accuracy1) && isset($accuracy2))    {
    $accuracy1 = $accuracy2;
    unset($accuracy2);
}
else if(isset($accuracy1) && isset($accuracy2))    {
    if($accuracy1 > $accuracy2)    {
        $a1 = $accuracy1;
        $a2 = $accuracy2;
        $accuracy1 = $a2;
        $accuracy2 = $a1;
    }
    else if($accuracy1 === $accuracy2)    {
        unset($accuracy2);
    }
}
$database = parse_ini_file(dirname(getcwd()) . "/private/database.ini");
$conn = mysqli_connect($database["host"], $database["username"], $database["password"], $database["name"]);
  // Check connection
  if ($conn->connect_error) {
   die("Connection failed: " . $conn->connect_error);
  } 
  $sql = "SELECT * FROM violations";
  if(isset($_GET["user_id"]))	{
	$userID = $_GET["user_id"];
	$sql .= " WHERE user_id = " . $userID;
	$row = mysqli_fetch_array(mysqli_query($GLOBALS["conn"], "SELECT * FROM users WHERE id LIKE '$userID'"));
	$datetime = $row["time_created"];
	date_default_timezone_set("Etc/GMT-4");
	$datetime = date("Y-m-d", $datetime) . "<br>" . date("H:i:s", $datetime);
	$image = $row["image"];
	$name = htmlspecialchars($row["name"]);
	if(empty($image))	{
		$image = "user_icon2.png";
	}
	$image = "<img src=$image style=max-width:128px;max-height:128px;>";
	if(empty($name))	{
		$name = "<font color=#808080>" . "სახელი" . "</font>";
	}
	echo
		"<center><p>
		<strong>მომხმარებელი №" . $userID . "-ის მიერ ატვირთული მასალების ნახვა</strong>
		<br>
		<strong>ანგარიშის შექმნის დრო და თარიღი:</strong><br>" . $datetime . "
		<br>
		<strong>ანგარიშის სახელი:</strong><br><span style=background-color:#EFEFEF>" . htmlspecialchars($row["account_name"]) . "</span>
		<br>" .
		$image . "<br>" . $name .
		"</p></center>"
	;
  }
  $result = $conn->query($sql);
  if(!empty($result))  {
  if ($result->num_rows > 0) {
   // output data of each row
        $count = 0;
	$allQuantity = 0;
	while($row0 = $result->fetch_assoc())	{
		++$allQuantity;
            if($searchFor === "location")    {
                $location = $row0["location"];
                $coordinates = $location;
                if(!empty($location))    {
                    if(strpos($location, " (") !== FALSE)    {
                        $coordinates = strstr($coordinates, " (", true);
                    }
                    if(strpos($coordinates, ", ") !== FALSE)    {
                        $databaseLatitude = explode(", ", $coordinates)[0];
                        $databaseLongitude = explode(", ", $coordinates)[1];
                    }
                }
            }
            if(
                  ($searchFor === "all")
                  ||
                  searchForDateAndTime()
                  ||
                  (
                      ($searchFor === "location")
                      &&
                      (!empty($location))
                      &&
                      (
                          (!isset($accuracy1) && !isset($accuracy2))
                          ||
                          (
                              (isset($accuracy1) && !isset($accuracy2))
                              &&
                              ($accuracy1 === floatval($row0["accuracy"]))
                          )
                          ||
                          (
                              (isset($accuracy1) && isset($accuracy2))
                              &&
                              ((floatval($row0["accuracy"]) > $accuracy1) && (floatval($row0["accuracy"]) < $accuracy2))
                          )
                      )
                      &&
                      (
                          (
                              (isset($_GET["latitude"]) && isset($_GET["longitude"]))
                              &&
                              (
                                  (
                                      isset($_GET["radius"])
                                      &&
                                      (getDistance($latitude, $longitude, $databaseLatitude, $databaseLongitude) <= $radius)
                                  )
                                  ||
                                  (
                                      !isset($_GET["radius"])
                                      &&
                                      $latitude === $databaseLatitude
                                      &&
                                      $longitude === $databaseLongitude
                                  )
                              )
                          )
                          ||
                          (
                              isset($address)
                              &&
                              (strpos($row0["address"], $address) !== FALSE)
                          )
                      )
                  )
                  ||
                  (
                      ($searchFor === "category")
                      &&
                      (!empty($category))
                      &&
                      isArrayElementInString($category, str_replace(array($DELIMITER_BEFORE, $DELIMITER_BETWEEN, $DELIMITER_AFTER, $DELIMITER_AFTER2), "", $row0["situation"]))
                  )
                  ||
                  (
                      ($searchFor === "description")
                      &&
                      (!empty($description))
                      &&
                      (strpos($row0["description"], $description) !== FALSE)
                  )
                  ||
                  (
                      ($searchFor === "reacttext")
                      &&
                      (!empty($reactText))
                      &&
                      (strpos($row0["react"], $reactText) !== FALSE)
                  )
                  ||
                  (
                      ($searchFor === "everywhere")
                      &&
                      (!empty($everywhere))
                      &&
                      (strpos($row0["n"] . $row0["location"] . $row0["accuracy"] . $row0["situation"] . $row0["description"] . $row0["react"], $everywhere) !== FALSE)
                  )
              )    {
                if(
                      (!isset($filter))
                      ||
                      (
                          ($filter === "reacted") && (!empty($row0["react"])) && (!empty($row0["react_media"]))
                      )
                      ||
                      (
                          ($filter === "notreacted") && (empty($row0["react"])) && (empty($row0["react_media"]))
                      )
                      ||
                      (
                          ($filter === "stateyes") && ($row0["state"] == 1)
                      )
                      ||
                      (
                          ($filter === "stateno") && ($row0["state"] == -1)
                      )
                      ||
                      (
                          ($filter === "stateempty") && ($row0["state"] == 0)
                      )
                  )    {
                    $items[] = $row0;
                    ++$count;
                }
            }
	}
	if(isset($_GET["user_id"]))	{
		echo "<center><p>" . "<strong>ატვირთულ მასალათა რაოდენობა: </strong>" . $allQuantity . "</p></center>";
	}
	if(isset($filter))	{
		if($filter === "reacted")	{
			$text = "რეაგირებული";
		}
		else if($filter === "notreacted")	{
			$text = "არარეაგირებული";
		}
		else if($filter === "stateyes")	{
			$text = "მონიშნულები როგორც შესაბამისი";
		}
		else if($filter === "stateno")	{
			$text = "მონიშნულები როგორც შეუსაბამო";
		}
		else if($filter === "stateempty")	{
			$text = "მონიშნული არ არის";
		}
		echo "<i>" . $text . "</i>" . "<br><hr><br>";
	}
  if(isset($items))    {
	$items = array_reverse($items);
        if($searchFor !== "all")    {
            echo "<i>" . "მოიძებნა " . $count . " მონაცემი" . "</i>" . "<br><hr><br>";
        }
   foreach($items as $row) {
        $link = $row["link"];
        $n = $row["n"];
        $type = explode("/", mime_content_type(str_replace("http://" . $_SERVER['HTTP_HOST'] . "/media/", getcwd() . trim("/media/ "), $link)))[0];
        if($type === "video") {
            $tag = "<label for=$n>" . "<video loop autoplay muted src=$link style=max-width:80px;max-height:80px;>" . "</label>" . "<input id=$n type=image style=width:0px;height:0px;>";
        }
        else if($type === "image")    {
            $tag = "<input type=image src=$link style=max-width:80px;max-height:80px;>";
        }
	if(isset($_GET["filter"]))	{
		$filter = $_GET["filter"];
		$filter = "<input type=hidden name=filter value=$filter>";
	}
	else	{
		$filter = "";
	}
        $media = "<form action=get2.php method=get>" . $tag . "<input type=hidden name=n value=$n>" . $filter . "</form>";
    echo "<style type=text/css>form, table {display:inline;margin:0px;padding:0px;}</style>" . $media . " ";
   }
  }
  else    {
      echo "<font size=25>მონაცემები არ არის</font>";
  }
}
else	{
	if(!isset($_GET["user_id"]))	{
		echo "<font size=25>" .  "ცარიელია" . "</font>";
	}
	else	{
		echo "<center><strong>ამ მომხმარებელს არცერთი მასალა არ აქვს ატვირთული</strong></center>";
	}
}
}
$conn->close();
?>