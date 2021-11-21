<?php
    if(isset($_GET["n"]) || isset($_POST["n"]))    {
        $one = 1;
    }
    else    {
        $one = 0;
    }
    define("protectedPrivatePath", dirname(getcwd()) . "/protected/private/");
    if($one)
        require protectedPrivatePath . "check_n_input.php";
    include protectedPrivatePath . "mysqli_database.php";
    $query = "SELECT * FROM violations";
    if($one)
        $query .= " WHERE n=?";
    $stmt = mysqli_prepare($mysqliConnectValue, $query);
    if($one)
        mysqli_stmt_bind_param($stmt, "i", $n);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $n, $filename, $soundname, $latitude, $longitude, $altitude, $accuracy, $address, $situation, $description, $react, $react_media, $time, $location_time, $sound_time, $info_time, $react_time, $upload_key, $user_id, $state, $state_time);
    if(!$one)
        $rows = [];
    $dataExists = 0;
    while(mysqli_stmt_fetch($stmt))  {
        if($dataExists != 1)    {
            $dataExists = 1;
        }
        $jsonRow = json_encode(array($n, $filename, $soundname, $latitude, $longitude, $altitude, $accuracy, $address, $situation, $description, $react, $react_media, $time, $location_time, $sound_time, $info_time, $react_time, /*$upload_key, */$user_id, $state, $state_time));
        if(!$one)    {
            array_push($GLOBALS["rows"], $jsonRow);
        }
    }
    if($dataExists)    {
        if($one)
            echo $jsonRow;
        else
            echo json_encode($rows);
    }
    else    {
        echo "0000";
    }
    mysqli_stmt_close($stmt);
    mysqli_close($mysqliConnectValue);
?>