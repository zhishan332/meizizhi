<?php
session_start();
require_once '..' . DIRECTORY_SEPARATOR . 'includes'.DIRECTORY_SEPARATOR . 'Config.php';

$page_title="登录注册";
//
//echo telFormatCheck("17178809527")==true?"1":"0";
//die();
include(ROOT . "/web/views/top-a.html");
include(ROOT . "/web/views/login.html");
include(ROOT . "/web/views/footer-a.html");