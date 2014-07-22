<?php
header("Content-type: text/html; charset=utf-8");
require_once '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'Config.php';
require_once '..' . DIRECTORY_SEPARATOR . 'includes' . PATH . 'service' . PATH . 'PageService.php';
$ac = $_GET['ac'];
switch ($ac) {
    case 'img_query':
        imgQuery($_GET);
        break;
}

function imgQuery($req)
{
    $pageid=intval($req['pageid']);
    $res = PageService::getImg($pageid);
    $imgs = array();
    $imgs['status']=1;
    $imgs['msg']="";
    $imgs['title']="";
    $imgs['id']=$pageid;
    $imgs['start']=0;
    foreach ($res as $img) {
        $nimg['name'] = $img['img'];
        $nimg['pid'] = intval($img['id']);
        $nimg['src'] = STATICROOT2 . "/" . $img['img'];
        $nimg['thumb'] = "";
        $nimg['area'] = array(800,800);
        $imgs['data'][] = $nimg;
    }
    echo  stripslashes(json_encode($imgs,true));
}