<?php
$database = parse_ini_file(dirname(getcwd()) . "/protected/private/database.ini");
$conn = mysqli_connect($database["host"], $database["username"], $database["password"], $database["name"]);
$q = mysqli_query($conn, "SELECT * FROM violations");
if(!$q)    {
    $table = "CREATE TABLE violations (
        n BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        filename TINYTEXT COLLATE utf8mb4_unicode_ci,
        sound_name TINYTEXT COLLATE utf8mb4_unicode_ci,
        latitude DOUBLE,
        longitude DOUBLE,
        altitude DOUBLE,
        accuracy DOUBLE,
        address TEXT COLLATE utf8mb4_unicode_ci,
        situation TEXT COLLATE utf8mb4_unicode_ci,
        description TEXT COLLATE utf8mb4_unicode_ci,
        react TEXT COLLATE utf8mb4_unicode_ci,
        react_media TINYTEXT COLLATE utf8mb4_unicode_ci,
        time INT UNSIGNED,
        location_time INT UNSIGNED,
        sound_time INT UNSIGNED,
        info_time INT UNSIGNED,
        react_time INT UNSIGNED,
        upload_key TINYTEXT COLLATE utf8mb4_unicode_ci,
	user_id INT UNSIGNED,
	state TINYINT,
        state_time INT UNSIGNED
    )";
    mysqli_query($conn, $table);
}
$q = mysqli_query($conn, "SELECT * FROM users");
if(!$q)    {
    $table = "CREATE TABLE users (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        account_name TINYTEXT COLLATE utf8mb4_unicode_ci,
        password TINYTEXT COLLATE utf8mb4_unicode_ci,
        name TINYTEXT COLLATE utf8mb4_unicode_ci,
        image TINYTEXT COLLATE utf8mb4_unicode_ci,
        time_created BIGINT UNSIGNED
    )";
    mysqli_query($conn, $table);
}
$q = mysqli_query($conn, "SELECT * FROM staff");
if(!$q)    {
    $table = "CREATE TABLE staff (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
        account_name TINYTEXT COLLATE utf8mb4_unicode_ci NOT NULL,
        password TINYTEXT COLLATE utf8mb4_unicode_ci NOT NULL,
        time_created INT UNSIGNED NOT NULL,
        react_permission BIT NOT NULL,
        delete_permission BIT NOT NULL
    )";
    mysqli_query($conn, $table);
}
$conn->close();
?>