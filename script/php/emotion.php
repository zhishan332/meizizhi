<?php
header("Content-type: text/html; charset=utf-8");
session_start();
require_once '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'Config.php';
function getContents($url)
{
    $ch = @curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $contents = @curl_exec($ch);
    @curl_close($ch);
    return $contents;
}

include("emotion.html");
