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
$cusername=$page[0]['cusername'];
$udate=$page[0]['udate'];
$udate=floor($udate/1000);
$nowTime=time();
$dateStr=date('Y-m-d H:i',$udate);
if($nowTime-$udate<24*3600){
    $dateStr=date('H:i',$udate);
}elseif($nowTime-$udate<24*3600*365){
    $dateStr=date('m-d H:i',$udate);
}
include(ROOT . "/web/views/top-a.html");
include(ROOT . "/web/views/view.html");
include(ROOT . "/web/views/footer-a.html");