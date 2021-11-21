<?php
    define("id", "0123");
    define("key", "123");
    define("username", "qveitisos");
    define("password", "admin_qveitisos");
    define("lockTime", 60);
    define("protectedPrivatePath", dirname(getcwd()) . "/protected/private/");
    define("lockTimePath", protectedPrivatePath . "locktime");
    function temporarilyClosedWarning() {
        include "503.php";
        exit;
    }
    function timeSecurity()	{
        if(file_exists(lockTimePath))    {
            $t = file_get_contents(lockTimePath);
            if((time() - $t) <= lockTime)	{
                $page = file_get_contents(protectedPrivatePath . "loginlocked.html");
                date_default_timezone_set("Etc/GMT-4");
                $t2 = $t + lockTime;
                $datetime = date("Y-m-d", $t2) . " " . date("H:i:s", $t2);
                $page = str_replace("DATE_AND_TIME", $datetime, $page);
                exit($page);
            }
            else    {
                unlink(lockTimePath);
            }
        }
    }
    if(isset($_GET[id]) && ($_GET[id] === key))    {
        timeSecurity();
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header('WWW-Authenticate: Basic realm="My Realm"');
            //header('HTTP/1.0 401 Unauthorized');
            http_response_code(401);
            exit;
        } else if($_SERVER['PHP_AUTH_USER'] !== username || $_SERVER['PHP_AUTH_PW'] !== password) {
            file_put_contents(lockTimePath, time());
            http_response_code(401);
            exit;
        }
    }
    else    {
        temporarilyClosedWarning();
    }
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
    function createDirectory2($directoryName)    {
        if(!file_exists($directoryName))    {
            mkdir($directoryName);
        }
    }
    $protectedPublicPath = dirname(getcwd()) . "/protected/public/";
    $protectedPrivatePath = dirname(getcwd()) . "/protected/private/";
    //$securePath = $protectedPrivatePath . "/secure/";
    //include $protectedPrivatePath . 'database.php';
    include $protectedPrivatePath . 'tables.php';
    //createFile($securePath . "keyfile_login", "1" . time() . generateKey(1 * 10**3));
    //createFile($securePath . "keyfile_delete", "2" . time() . generateKey(1 * 10**3));
    createDirectory2($protectedPrivatePath . "secret");
    createFile($protectedPrivatePath . "uploaded_n", "0");
    createFile($protectedPrivatePath . "reactweb_n", "0");
    createFile($protectedPrivatePath . "live_n", "0");
    createFile($protectedPrivatePath . "accounts_n", "0");
    createDirectory2($protectedPrivatePath . "temp");
    createDirectory2($protectedPrivatePath . "live_keys");
    createDirectory2($protectedPrivatePath . "sound_keys");
    createDirectory2($protectedPrivatePath . "accountimage_keys");
    $dataPath = $protectedPrivatePath . "/data/";
    createDirectory2($dataPath);
    createDirectory2($dataPath . "logins");
    createDirectory2($dataPath . "states");
    createDirectory2($dataPath . "reacts");
    createDirectory2($dataPath . "deletes");
    createDirectory2($dataPath . "n_files");
    createDirectory2($dataPath . "infos");
    createDirectory2($dataPath . "locations");
    createDirectory2($dataPath . "sounds");
    createDirectory2($dataPath . "accounts");
    $uploadsPath = $protectedPublicPath . "/uploads/";
    createDirectory2($uploadsPath);
    createDirectory2($uploadsPath . "media");
    createDirectory2($uploadsPath . "live");
    createDirectory2($uploadsPath . "react_media");
    createDirectory2($uploadsPath . "sound");
    createDirectory2($uploadsPath . "users_images");
    include $protectedPrivatePath . 'sessions2.php';
    createDirectory2($protectedPrivatePath . "captcha");
    createDirectory2($protectedPrivatePath . "captcha/images");
    createDirectory2($protectedPrivatePath . "captcha/texts");
    createFile($protectedPrivatePath . "captcha/captcha_n", 0);
    if(isset($_POST["upload"]))    {
        echo '
            <html>
                <form action="" enctype="multipart/form-data" method=post>
                    <input type="text" id="username" name="username" required>
                    <br>
                    <input type="password" id="password" name="password" required>
                    <br>
                    <input type="submit" name="createaccount">
                </form>
            </html>
        ';
        define("disableCaptchaHtmlOutput", 1);
    }
    define("secretPath", protectedPrivatePath . "secret/");
    $username = "";
    $dbc = "";
    $stmt = "";
    function prepareStaffAccountSql($column)    {
        $username = htmlspecialchars(mb_substr($_POST["username"], 0, 50));
        include_once(protectedPrivatePath . "mysqli_database.php");
        $dbc = $mysqliConnectValue;
        $stmt = mysqli_prepare($dbc, "SELECT " . $column . " FROM staff WHERE account_name=?");
        mysqli_stmt_bind_param($stmt, "s", $username);
        $GLOBALS["username"] = $username;
        $GLOBALS["dbc"] = $dbc;
        $GLOBALS["stmt"] = $stmt;
    }
    if(isset($_POST["createaccount"]) && isset($_POST["username"]) && isset($_POST["password"]))    {
        define("disableCaptchaHtmlOutput", 1);
        prepareStaffAccountSql("account_name");
        $dbc = $GLOBALS["dbc"];
        $stmt = $GLOBALS["stmt"];
        if(mysqli_stmt_execute($stmt))    {
            mysqli_stmt_store_result($stmt);
            if(mysqli_stmt_num_rows($stmt) == 1)    {
                $accountExists = 1;
            }
            if(isset($accountExists) && ($accountExists == 1))    {
                echo "-1";
            }
            else    {
                mysqli_stmt_close($stmt);
                $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
                $reactPermission = 1;
                $deletePermission = 1;
                $time = time();
                $stmt = mysqli_prepare($dbc, "INSERT INTO staff (account_name, password, time_created, react_permission, delete_permission) VALUES (?, ?, ?, ?, ?)");
                mysqli_stmt_bind_param($stmt, "ssiii", $username, $password, $time, $reactPermission, $deletePermission);
                if(mysqli_stmt_execute($stmt))    {
                    $keyfilelogin_content = "1" . time() . generateKey(1 * 10**3);
                    $keyfiledelete_content = "2" . time() . generateKey(1 * 10**3);
                    $accountID = mysqli_stmt_insert_id($stmt);
                    $secretPathID = secretPath . $accountID . '/';
                    mkdir($secretPathID);
                    file_put_contents($secretPathID . "keyfile_login", $keyfilelogin_content);
                    file_put_contents($secretPathID . "keyfile_delete", $keyfiledelete_content);
                    if(session_status() != PHP_SESSION_ACTIVE)    {
                        session_start();
                    }
                    $_SESSION["keyfiledownload_accountid"] = $accountID;
                    $_SESSION["keyfilelogin_downloadallowed"] = 1;
                    $_SESSION["keyfiledelete_downloadallowed"] = 1;
                    echo "1";
                    echo "<br>";
                    echo "<a href=\"" . $_SERVER["REQUEST_URI"] . "&accountid=" . $accountID . "&downloadkeyfile=1\" download=\"keyfile_login\">keyfile_login</a><br><a href=\"" . $_SERVER["REQUEST_URI"] . "&accountid=" . $accountID . "&downloadkeyfile=2\" download=\"keyfile_delete\">keyfile_delete</a>";
                    echo '
                        <html>
                            <form action="" enctype="multipart/form-data" method=post>
                                <input type="text" id="username" name="username" required>
                                <br>
                                <input type="password" id="password" name="password" required>
                                <br>
                                <input type="file" id="keyfile_login" name="keyfile_login" autocomplete="off" required>
                                <br>
                                <input type="submit" onclick="return confirm();" name="allow_access">
                            </form>
                        </html>
                    ';
                }
                else    {
                    echo "-2";
                }
            }
        }
        else    {
            echo "0";
        }
        mysqli_stmt_close($stmt);
        mysqli_close($dbc);
    }
    else if(isset($_GET["downloadkeyfile"]) && isset($_GET["accountid"]) && ctype_digit($_GET["accountid"]) && ($_GET["accountid"] > 0))    {
        if(session_status() != PHP_SESSION_ACTIVE)    {
            session_start();
        }
        if(!(isset($_SESSION["keyfiledownload_accountid"]) && isset($_SESSION["keyfilelogin_downloadallowed"]) && isset($_SESSION["keyfiledelete_downloadallowed"]) && ($_SESSION["keyfiledownload_accountid"] == $_GET["accountid"]) && (($_SESSION["keyfilelogin_downloadallowed"] == 1) || ($_SESSION["keyfiledelete_downloadallowed"] == 1))))    {
            session_destroy();
            exit;
        }
        if(($_GET["downloadkeyfile"] == 1) && ($_SESSION["keyfilelogin_downloadallowed"] == 1))    {
            $fileName = "login";
            $_SESSION["keyfilelogin_downloadallowed"] = 0;
        }
        else if(($_GET["downloadkeyfile"] == 2) && ($_SESSION["keyfiledelete_downloadallowed"] == 1))    {
            $fileName = "delete";
            $_SESSION["keyfiledelete_downloadallowed"] = 0;
        }
        else    {
            exit;
        }
        if(($_SESSION["keyfilelogin_downloadallowed"] == 0) && ($_SESSION["keyfiledelete_downloadallowed"] == 0))    {
            $_SESSION["keyfiledownload_accountid"] = 0;
            session_destroy();
        }
        $fileName = "keyfile_" . $fileName;
        $filePath = secretPath . $_GET["accountid"] . '/' . $fileName;
        header("Content-Type: " . mime_content_type($filePath));
        header("Content-Disposition: filename=\"" . $fileName . "\"");
        exit(file_get_contents($filePath));
    }
    else if(isset($_POST["allow_access"]) && isset($_POST["username"]) && isset($_POST["password"]) && isset($_FILES["keyfile_login"]["tmp_name"]))    {
        define("disableCaptchaHtmlOutput", 1);
        prepareStaffAccountSql("*");
        $dbc = $GLOBALS["dbc"];
        $stmt = $GLOBALS["stmt"];
        if(mysqli_stmt_execute($stmt))    {
            mysqli_stmt_bind_result($stmt, $id, $account_name, $password, $timeCreated, $reactPermission, $deletePermission);
            if(mysqli_stmt_fetch($stmt) && password_verify($_POST["password"], $password) && (file_get_contents($_FILES["keyfile_login"]["tmp_name"]) === file_get_contents(secretPath . $id . "/keyfile_login")))    {
                $prependSetupString = 'php_value auto_prepend_file "setup.php"';
                $htaccessPath = ".htaccess";
                file_put_contents($htaccessPath, str_replace($prependSetupString, '#' . $prependSetupString, file_get_contents($htaccessPath)));
                echo "1";
            }
            else    {
                echo "0";
            }
        }
        mysqli_stmt_close($stmt);
        mysqli_close($dbc);
    }
    include_once(protectedPrivatePath . "captcha_upload.php");
    exit;
?>