<?php
session_start();
require_once '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'Config.php';
require_once ROOT . PATH . 'includes' . PATH . 'service' . PATH . 'PageService.php';
$pageid = empty($_GET['p']) ? 0 : $_GET['p'];
if ($pageid <= 0) exit;
$page = PageService::getPage($pageid);
if (empty($page)) {
    echo "惭愧，页面已经不存在了，可能回火星去了。";
    exit;
}
$imgnum=count($page);
$page_title = $page[0]['title'];
include(ROOT . "/web/views/top-a.html");
include(ROOT . "/web/views/view.html");
include(ROOT . "/web/views/footer-a.html");