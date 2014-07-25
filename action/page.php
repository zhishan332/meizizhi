<?php
header("Content-type: text/html; charset=utf-8");
session_start();
require_once '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'Config.php';
require_once '..' . DIRECTORY_SEPARATOR . 'includes' . PATH . 'service' . PATH . 'PageService.php';
$ac = $_GET['ac'];
switch ($ac) {
    case 'img_query':
        imgQuery($_GET);
        break;
    case 'praise':
        praise($_POST);
        break;
}
function praise($req)
{
    $pageid = intval($req['pageid']);
    $praise = $_SESSION['praise'];
    if (empty($praise)) { //从没赞过的话初始化Session
        $_SESSION['praise'] = array("$pageid");
        PageService::updatePraiseNum($pageid);
        $response['status'] = 1;
        echo json_encode($response);
        return;
    }
    $praise = $_SESSION['praise'];
    if (!in_array($pageid, $praise)) { //如果没有赞过则可以赞
        $praise[] = $pageid;
        $_SESSION['praise'] = $praise;
        PageService::updatePraiseNum($pageid);
        $response['status'] = 1;
        echo json_encode($response);
        return;
    } else {
        $response['status'] = 0;
        echo json_encode($response);
    }
}

function imgQuery($req)
{
    $pageid = intval($req['pageid']);
    $res = PageService::getImg($pageid);
    $imgs = array();
    $imgs['status'] = 1;
    $imgs['msg'] = "";
    $imgs['title'] = "";
    $imgs['id'] = $pageid;
    $imgs['start'] = 0;
    foreach ($res as $img) {
        $nimg['name'] = $img['img'];
        $nimg['pid'] = intval($img['id']);
        $nimg['src'] = STATICROOT2 . "/" . $img['img'];
        $nimg['thumb'] = "";
        $nimg['area'] = array(800, 800);
        $imgs['data'][] = $nimg;
    }
    echo stripslashes(json_encode($imgs, true));
}