<?php
function exitFunction($exitValue)	{
	$GLOBALS["conn"]->close();
	exit($exitValue);
}
define("outputAtOnce", 30);
define("notFirstPage", isset($_GET["start_index"]) && ctype_digit($_GET["start_index"]) && isset($_GET["firstrequesttime"]) && ctype_digit($_GET["firstrequesttime"]));
if(notFirstPage)	{
	$pageIndex = $_GET["start_index"];
	$firstRequestTime = $_GET["firstrequesttime"];
}
else	{
	$pageIndex = 0;
	$firstRequestTime = time();
}
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
	$tableButtonBackgroundColour = "background: #101010;";
	$accountNameBackgroundColour = "#101010";
}
else    {
	$tableButtonBackgroundColour = "background: #f0f0f0;";
	$accountNameBackgroundColour = "#EFEFEF";
}
		echo "
			<title>ქვეითი SOS</title>
			<head><link rel=\"icon\" href=\"/pedestriansos.png\"></head>
			<meta charset=\"UTF-8\" name=\"viewport\" content=\"width=device-width, initial-scale=1\">
			<style type=text/css>
				.images, .videos	{
					max-width:80px;
					max-height:80px;
				}
				.tableButtons	{
					display: inline-block;
					margin: 2px;
					border: solid #808080 2px;
					" . $tableButtonBackgroundColour . "
					width: 100px;
					height: 100px;
					text-align: center;
					vertical-align: top;
					padding: 2px 2px;
					cursor: pointer;
				}
				/*.loader {
					border: 4px solid #f3f3f3;
					border-radius: 50%;
					border-top: 4px solid #808080;
					width: 50px;
					height: 50px;
					-webkit-animation: spin 1s linear infinite;
					animation: spin 1s linear infinite;
				}
				@-webkit-keyframes spin {
					0% { -webkit-transform: rotate(0deg); }
					100% { -webkit-transform: rotate(360deg); }
				}
				@keyframes spin {
					0% { transform: rotate(0deg); }
					100% { transform: rotate(360deg); }
				}*/
				#nextpage	{
					color: #256AFF;
					font-size: 64;
					cursor: pointer;
				}
				#nextpage:disabled	{
					color: #808080;
					font-size: 64;
					cursor: not-allowed;
				}
		#nametext	{
			color: #808080;
		}
			</style>
		";
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
$filter = "stateyes";
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
        $temp = $accuracy1;
        $accuracy1 = $accuracy2;
        $accuracy2 = $temp;
        unset($temp);
    }
    else if($accuracy1 === $accuracy2)    {
        unset($accuracy2);
    }
}
function getSqlWhereOrAnd($local_sql)	{
	if(strpos($local_sql, "WHERE") !== FALSE)	{
		$local_sql = "AND";
	}
	else	{
		$local_sql = "WHERE";
	}
	$local_sql = " " . $local_sql . " ";
	return $local_sql;
}
function setSearchSQL_0($local_input, $local_db)	{
	$GLOBALS["sql"] .= getSqlWhereOrAnd($GLOBALS["sql"]) . $local_db . " LIKE ?";
	$sql_parameter_1 = '%' . $local_input . '%';
	$GLOBALS["bindParamFunctionParameters"] = array("s", &$sql_parameter_1);
}
function setSearchSQL()	{
	if(($GLOBALS["searchFor"] === "description") && (!empty($GLOBALS["description"])))	{
		setSearchSQL_0($GLOBALS["description"], "description");
	}
	/*else if(($GLOBALS["searchFor"] === "category") && (!empty($GLOBALS["category"])))	{
		setSearchSQL_0($GLOBALS["category"], "situation");
	}*/
}
include dirname(getcwd()) . "/protected/private/mysqli_database.php";
$conn = $mysqliConnectValue;
  // Check connection
  if ($conn->connect_error) {
   die("Connection failed: " . $conn->connect_error);
  }
  $sql = "SELECT * FROM violations";
	if(($filter !== "stateno") && ($filter !== "stateempty") && ($filter !== "all"))	{
		$sql .= getSqlWhereOrAnd($sql);
		$sql .= "state=1";
	}
	else if($filter === "stateno")	{
		$sql .= getSqlWhereOrAnd($sql);
		$sql .= "state=-1";
	}
	else if($filter === "stateempty")	{
		$sql .= getSqlWhereOrAnd($sql);
		$sql .= "state=0";
	}
	if($filter === "reacted")	{
		$sql .= getSqlWhereOrAnd($sql);
		$sql .= "react_time>0";
	}
	else if($filter === "notreacted")	{
		$sql .= getSqlWhereOrAnd($sql);
		$sql .= "react_time=0";
	}
	setSearchSQL();
	if(notFirstPage)	{
		$sql .= getSqlWhereOrAnd($sql);
		$sql .= "time<" . $firstRequestTime;
	}
	if($searchFor === "all" || $searchFor === "description")	{
		$sql .= " ORDER BY n DESC LIMIT " . ($pageIndex * outputAtOnce) . ", " . (outputAtOnce + 1);
	}
	//$rowsNumber = intval(file_get_contents(dirname(getcwd()) . "/protected/private/uploaded_n"));
	if(isset($_GET["user_id"]))	{
		$userID = ltrim(preg_replace("/[^0-9]/", '', $_GET["user_id"]), '0');
	}
	$userMode = (isset($userID) && ctype_digit($userID) && ($userID > 0));
  if($userMode)	{
	//$userID = $_GET["user_id"];
	$sql .= " WHERE user_id = " . $userID;
	$row = mysqli_fetch_array(mysqli_query($GLOBALS["conn"], "SELECT * FROM users WHERE id LIKE '$userID'"));
	$datetime = $row["time_created"];
	date_default_timezone_set("Etc/GMT-4");
	$datetime = date("Y-m-d", $datetime) . "<br>" . date("H:i:s", $datetime);
	$image = $row["image"];
	$name = $row["name"];
	if(empty($image))	{
		$image = "user_icon2.png";
	}
	else	{
		$image = "/?/uploads/users_images/" . $image;
	}
	$image = "<img src=$image style=max-width:128px;max-height:128px;>";
	if(empty($name))	{
		$name = "<span id=nametext>" . "სახელი" . "</span>";
	}
	//if(!ajaxMode)	{
		echo
			"<center><p>
			<strong>მომხმარებელი №" . $userID . "-ის მიერ ატვირთული მასალების ნახვა</strong>
			<br>
			<strong>ანგარიშის შექმნის დრო და თარიღი:</strong><br>" . $datetime . "
			<br>
			<strong>ანგარიშის სახელი:</strong><br><span style=background-color:" . $accountNameBackgroundColour . ">" . $row["account_name"] . "</span>
			<br>" .
			$image . "<br>" . $name .
			"</p></center>"
		;
	//}
  }
  //$result = $conn->query($sql);
	$stmt = mysqli_prepare($conn, $sql);
	if(isset($GLOBALS["bindParamFunctionParameters"]))	{
		array_unshift($bindParamFunctionParameters, $stmt);
		call_user_func_array("mysqli_stmt_bind_param", $bindParamFunctionParameters);
	}
	if(mysqli_stmt_execute($stmt))	{
		$result = mysqli_stmt_get_result($stmt);
	}
  if(!empty($result))  {
  if ($result->num_rows > 0) {
   // output data of each row
        $count = 0;
	$allQuantity = 0;
	while($row0 = $result->fetch_assoc())	{
		++$allQuantity;
/*
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
*/
			$isLocation = ($row0["location_time"] != 0);
			if($isLocation)	{
				$databaseLatitude = $row0["latitude"];
				$databaseLongitude = $row0["longitude"];
			}
            if(
                  ($searchFor === "all")
                  ||
                  searchForDateAndTime()
                  ||
                  (
                      ($searchFor === "location")
                      &&
                      ($isLocation)
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
                      (strpos($row0["n"] . $row0["latitude"] . ", " . $row0["longitude"] . $row0["accuracy"] . $row0["situation"] . $row0["description"] . $row0["react"], $everywhere) !== FALSE)
                  )
              )    {
                /*if(
                      (!isset($filter))
                      ||
                      (
                          ($filter === "reacted") && (!empty($row0["react"])) && (!empty($row0["react_media"]))
                      )
                      ||
                      (
                          ($filter === "notreacted") && (empty($row0["react"])) && (empty($row0["react_media"])) && ($row0["state"] == 1)
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
                      ||
                      (
                          ($filter === "all")
                      )
                  )    {*/
                    $items[] = $row0;
                    ++$count;
                //}
            }
	}
	if($userMode/* && !ajaxMode*/)	{
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
			$text = "<span style=\"background-color:#008000;color:#ffffff;font-style:normal;\">✓ მონიშნულები როგორც შესაბამისი</span>";
		}
		else if($filter === "stateno")	{
			$text = "<span style=\"background-color:#e00000;color:#ffffff;font-style:normal;\">✕ მონიშნულები როგორც შეუსაბამო</span>";
		}
		else if($filter === "stateempty")	{
			$text = "მონიშნული არ არის";
		}
		else if($filter === "all")	{
			$text = "ყველა";
		}
		echo "<i>" . $text . "</i>" . "<br><hr><br>";
	}
  if(isset($items))    {
	//$items = array_reverse($items);
	$codeLoadMore = "";
	//else	{
		if($searchFor !== "all")    {
			echo "<i>" . "მოიძებნა " . $count . " მონაცემი" . "</i>" . "<br><hr><br>";
		}
		$codeLoadMore = "<span id=\"loadedContent\"></span>
			<br>
			<center>
				<div id=\"scroll_loader\" class=\"loader\"></div>
			</center>
			<script>
				let pageElement = document.getElementById(\"page\");
				let windowElementBackground = document.getElementById(\"fileWindowBackground\");
				let windowElement = document.getElementById(\"fileWindow\");
				let scrollLoader = document.querySelector(\"#scroll_loader\")
				let loadedContentElement = document.getElementById(\"loadedContent\");
				let loadQuantity = " . outputAtOnce . ";
				var startIndex = 0;
				function openFile(urlPath)	{
					//sessionStorage.setItem(\"startIndex\", startIndex);
					//sessionStorage.setItem(\"lastScroll\", document.scrollTop);
					window.open(urlPath);
					/*var windowAjax = new XMLHttpRequest();
					windowAjax.open(\"GET\", urlPath);
					windowAjax.onreadystatechange = function(){
						if(this.readyState == 4 && this.status == 200)	{
							windowElement.innerHTML = this.responseText;
							windowElementBackground.style.display = \"block\";
						}
					};
					windowAjax.send();*/
				}
				function isInViewport(element) {
					const rect = element.getBoundingClientRect();
					return (
						rect.top >= 0 &&
						rect.left >= 0 &&
						rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
						rect.right <= (window.innerWidth || document.documentElement.clientWidth)
					);
				}
				function loadIfVisible()	{
					if(isInViewport(scrollLoader))	{
						loadMore();
					}
				}
				function loadMore()	{
					startIndex += loadQuantity;
					var loadAjax = new XMLHttpRequest();
					loadAjax.open(\"GET\", window.location.href + \"&start_index=\" + startIndex);
					loadAjax.onreadystatechange = function(){
						if(this.readyState == 4 && this.status == 200)	{
							if(this.responseText == \"0\")	{
								scrollLoader.style.display = \"none\";
							}
							else	{
								loadedContentElement.innerHTML += this.responseText;
								loadIfVisible();
							}
						}
					};
					loadAjax.send();
				}
				/*
				var lastStartIndex = sessionStorage.getItem(\"startIndex\");
				console.log(lastStartIndex);
				for(startIndex = 0; startIndex < lastStartIndex; startIndex += loadQuantity)	{
					loadMore();
				}
				window.scrollTo(0, sessionStorage.getItem(\"lastScroll\"));
				var observer = new IntersectionObserver(function(entries) {
					if(entries[0].isIntersecting === true)
						loadMore();
				}, { threshold: [0] });
				observer.observe(scrollLoader);
				*/
				setInterval(function(){loadIfVisible();}, 250);
			</script>
		";
	//}
	$nextPageButtonAttributes = "";
	if(count($items) <= outputAtOnce/*empty(array_slice($items, ($pageIndex + 1) * outputAtOnce, outputAtOnce))*/)	{
		$nextPageButtonAttributes = " disabled";
	}
	else	{
		array_pop($items);
	}
	//$items = array_slice($items, $pageIndex * outputAtOnce, outputAtOnce);
	/*if(empty($items))	{
		exitFunction("0");
	}*/
   foreach($items as $row) {
        //$path = $row["path"];
        $n = $row["n"];
        //$type = explode("/", mime_content_type(getcwd() . $path))[0];
$filePath = "uploads/media/" . $row["filename"];
$path = "/?/" . $filePath;
$type = explode("/", mime_content_type(dirname(getcwd()) . "/protected/public/" . $filePath))[0];
        if($type === "video") {
            $tag = "<video loading=\"lazy\" loop autoplay muted src=$path class=\"videos\">";
        }
        else if($type === "image")    {
            $tag = "<img loading=\"lazy\" src=$path class=\"images\">";
        }
	if(isset($_GET["filter"]))	{
		$filter = $_GET["filter"];
		//$filter = "<input type=hidden name=filter value=$filter>";
		$filter = "&filter=" . $filter;
	}
	else	{
		$filter = "";
	}
        //$media = "<label for=" . $n . " class=\"tableButtons\">" . $tag . "</label>" . "<input id=$n type=image style=width:0px;height:0px;>";
        //$media = "<form action=get2.php method=get>" . $media . "<input type=hidden name=n value=$n>" . $filter . "</form>";
        //$media = "<button class=\"tableButtons\" onclick=openFile(\"get2.php?n=" . $n . $filter . "\")>" . $tag . "</button>";
        $media = "<a href=\"get2.php?n=" . $n . $filter . "\"><button class=\"tableButtons\">" . $tag . "</button></a>";
    echo $media;
   }
	++$pageIndex;
	$nextURL = $_SERVER["REQUEST_URI"];
	if(strpos($nextURL, "&start_index=") !== FALSE)	{
		$nextURL = substr($nextURL, 0, strpos($nextURL, "&start_index="));
	}
	//$allPageNumber = ceil($count / outputAtOnce);
	echo "<br><br><center><a href=\"" . $nextURL . "&start_index=" . $pageIndex . "&firstrequesttime=" . $firstRequestTime . "\"><button" . $nextPageButtonAttributes . " id=\"nextpage\">»</button></a><br><br>" . $pageIndex/* . " / " . $allPageNumber*/ . "</center><br><br>";
	/*if(!empty($codeLoadMore))	{
		echo $codeLoadMore;
	}*/
  }
  else    {
      echo "<font size=25>მონაცემები არ არის</font>";
  }
}
else	{
	if(!$userMode)	{
		echo "<font size=25>" .  "ცარიელია" . "</font>";
	}
	else	{
		echo "<center><strong>ამ მომხმარებელს არცერთი მასალა არ აქვს ატვირთული</strong></center>";
	}
}
}
mysqli_stmt_close($stmt);
$conn->close();
?>