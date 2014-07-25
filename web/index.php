<?php
session_start();
require_once '..' . DIRECTORY_SEPARATOR . 'includes'.DIRECTORY_SEPARATOR . 'Config.php';
require_once SERVCIEROOT . 'PageService.php';


$page_title="首页";
//unset($_SESSION['user']);
//var_dump($_SESSION['user']);exit;
include(ROOT . "/web/views/top-a.html");
include(ROOT . "/web/views/index.html");
include(ROOT . "/web/views/footer-a.html");