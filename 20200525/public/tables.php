<?php
$database = parse_ini_file(dirname(getcwd()) . "/private/database.ini");
$conn = mysqli_connect($database["host"], $database["username"], $database["password"], $database["name"]);
$q = mysqli_query($conn, "SELECT * FROM violations");
if(!$q)    {
    $table = "CREATE TABLE violations (
        n BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        link TINYTEXT,
        sound_link TINYTEXT,
        location TINYTEXT,
        accuracy DOUBLE,
        address TEXT,
        situation TEXT,
        description TEXT,
        react TEXT,
        react_media TINYTEXT,
        time BIGINT UNSIGNED,
        location_time BIGINT UNSIGNED,
        sound_time BIGINT UNSIGNED,
        info_time BIGINT UNSIGNED,
        react_time BIGINT UNSIGNED,
        upload_key TINYTEXT,
	user_id BIGINT UNSIGNED,
	state TINYINT,
        state_time BIGINT UNSIGNED
    )";
    mysqli_query($conn, $table);
}
$q = mysqli_query($conn, "SELECT * FROM users");
if(!$q)    {
    $table = "CREATE TABLE users (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        account_name VARCHAR(10),
        password TINYTEXT,
        name VARCHAR(10),
        image TINYTEXT,
        time_created BIGINT UNSIGNED
    )";
    mysqli_query($conn, $table);
}
$conn->close();
?>