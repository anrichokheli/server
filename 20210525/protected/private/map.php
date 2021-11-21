<?php
	$MAP_API_KEY = parse_ini_file(dirname(getcwd()) . "/protected/private/apikey.ini")["google_map"];
	return "<iframe src=https://www.google.com/maps/embed/v1/place?key=" . "$MAP_API_KEY" . "&q=" . str_replace(' ', '%20', $location) . " style=" . $mapIframeSize . "></iframe>";
?>