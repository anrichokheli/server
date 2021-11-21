<?php
if(isset($_GET["time1"]))    {
    $time1 = $_GET["time1"];
}
if(isset($_GET["time2"]))    {
    $time2 = $_GET["time2"];
    if($time1 > $time2)    {
        $t1 = $time1;
        $t2 = $time2;
        $time1 = $t2;
        $time2 = $t1;
    }
}
function searchForDateAndTime()    {
    $DB_VAR = "row0";
    if($GLOBALS["searchFor"] === "uploaddateandtime")    {
        $timeDBname = "time";
    }
    else if($GLOBALS["searchFor"] === "reactdateandtime")    {
        $timeDBname = "react_time";
        if(empty($GLOBALS[$DB_VAR]["$timeDBname"]))    {
            return 0;
        }
    }
    else if($GLOBALS["searchFor"] === "uploadlocationdateandtime")    {
        $timeDBname = "location_time";
        if(empty($GLOBALS[$DB_VAR]["$timeDBname"]))    {
            return 0;
        }
    }
    else if($GLOBALS["searchFor"] === "uploadsounddateandtime")    {
        $timeDBname = "sound_time";
        if(empty($GLOBALS[$DB_VAR]["$timeDBname"]))    {
            return 0;
        }
    }
    else if($GLOBALS["searchFor"] === "uploadinfodateandtime")    {
        $timeDBname = "info_time";
        if(empty($GLOBALS[$DB_VAR]["$timeDBname"]))    {
            return 0;
        }
    }
    else if($GLOBALS["searchFor"] === "accountdateandtime")    {
        $timeDBname = "time_created";
	$DB_VAR = "row";
        if(empty($GLOBALS[$DB_VAR]["$timeDBname"]))    {
            return 0;
        }
    }
    return                
    (
        (isset($GLOBALS["time1"]))
        &&
        (
            (
                (
                    (!isset($GLOBALS["time2"]))
                    &&
                    ($GLOBALS[$DB_VAR]["$timeDBname"] >= $GLOBALS["time1"])
                    &&
                    ($GLOBALS[$DB_VAR]["$timeDBname"] < ($GLOBALS["time1"] + 60))
                )
            )
            ||
            (
                (
                    (isset($GLOBALS["time2"]))
                    &&
                    ($GLOBALS[$DB_VAR]["$timeDBname"] >= $GLOBALS["time1"])
                    &&
                    ($GLOBALS[$DB_VAR]["$timeDBname"] < ($GLOBALS["time2"] + 60))
                )
            )
        )
    );
}
?>