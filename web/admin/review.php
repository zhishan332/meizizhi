<?php
header("Content-type: text/html; charset=utf-8");
require_once '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'Config.php';
require_once ROOT . PATH . 'admin' . PATH . 'ReviewService.php';
$page_title = "内容管理-内容审核";

$key = empty($_GET['k']) ? "" : $_GET['k'];
$pnum = empty($_GET['p']) ? 1 : $_GET['p'];
$status = empty($_GET['s']) ? -1 : $_GET['s'];
$pid = empty($_GET['pid']) ? '' : $_GET['pid'];

$statusText="全部";
switch($status){
    case -1:
        $statusText="全部";
        break;
    case 10:
        $statusText="未审核";
        break;
    case 20:
        $statusText="已审核";
        break;
}

$size = 10;
$start = ($pnum - 1) * $size;
$total = 0;

$pages = ReviewService::find($key, $status,$pid,$start, 15);
$total = ReviewService::getTotal($key, $status,$pid);
//分页使用
$tt = ceil($total / 15 * 8);
$ee = ceil($pnum / 8);
$lastpg = ceil($total / 15);
$dd = 8 * $ee;
if ($dd > $lastpg) {
    $dd = $lastpg;
}
$ss = 8 * ($ee - 1) + 1;
$pre_url = 'review.php?p=' . ($pnum - 1) . '&s=' . $status;
if (!empty($key)) {
    $pre_url = 'review.php?k=' . $key . '&p=' . ($pnum - 1) . '&s=' . $status;
}
$next_url = 'review.php?p=' . ($pnum + 1) . '&s=' . $status;
if (!empty($key)) {
    $next_url = 'review.php?k=' . $key . '&p=' . ($pnum + 1) . '&s=' . $status;
}


include("views/top.html");
include("views/review.html");