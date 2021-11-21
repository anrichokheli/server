<?php
    function generateKey($n)  {
        $key = "";
        for($count = 0; $count < $n; $count++)   {
            $key .= chr(random_int(0, 255));
        }
        return $key;
    }
    function createFile($fileName, $value)    {
        if(!file_exists($fileName))    {
            file_put_contents($fileName, $value);
        }
    }
    function createDirectory($directoryName)    {
        if(!file_exists($directoryName))    {
            mkdir($directoryName);
        }
    }
    include 'database.php';
    include 'tables.php';
    createFile(dirname(getcwd()) . "/private/keyfile_login", "1" . time() . generateKey(3.2 * 10**6));
    createFile(dirname(getcwd()) . "/private/keyfile_delete", "2" . time() . generateKey(3.2 * 10**6));
    createFile("uploaded_n", "0");
    createFile("reactweb_n", "0");
    createDirectory("media");
    createDirectory("react_media");
    createDirectory("sound");
    createDirectory("users_images");
    include 'sessions2.php';
?>