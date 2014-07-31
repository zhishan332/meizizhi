<?php
session_start();
header("Content-type: text/html; charset=utf-8");
require_once '..' . DIRECTORY_SEPARATOR . 'includes'.DIRECTORY_SEPARATOR . 'Config.php';
require_once ROOT . PATH . 'includes'.PATH .'service'.PATH. 'PageService.php';
$active='active';
$menu_color='menu_active';
$key = empty($_GET['k']) ? "" : $_GET['k'];
$pnum = empty($_GET['p']) ? 1 : $_GET['p'];
$size = 15;
$start = ($pnum - 1) * $size;
$total = 0;

$page_title="三国志";
$pages=PageService::find($key,$start,15);
$total=PageService::getTotal($key);
//分页使用
$tt = ceil($total / 15 * 8);
$ee = ceil($pnum / 8);
$lastpg=ceil($total / 15);
$dd = 8*$ee;
if($dd>$lastpg){
    $dd=$lastpg;
}
$ss = 8 * ($ee - 1) + 1;
$pre_url='meizi.php?p='.($pnum-1);
if(!empty($key)){
    $pre_url='meizi.php?k='.$key.'&p='.($pnum-1);
}
$next_url='meizi.php?p='.($pnum+1);
if(!empty($key)){
    $next_url='meizi.php?k='.$key.'&p='.($pnum+1);
}
include(ROOT . "/web/views/top-a.html");
include(ROOT . "/web/views/meizi.html");
include(ROOT . "/web/views/footer-a.html");