<?php
header("Content-type: text/html; charset=utf-8");
session_start();
require_once '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'Config.php';
require_once '..' . DIRECTORY_SEPARATOR . 'admin' . PATH . 'ReviewService.php';
require_once '..' . DIRECTORY_SEPARATOR . 'includes' . PATH . 'helper' . PATH . 'DownLoader.php';
require_once '..' . DIRECTORY_SEPARATOR . 'includes' . PATH . 'helper' . PATH . 'SequenceHelper.php';

$ac = $_GET['ac'];
switch ($ac) {
    case 'del_img':
        delImg($_POST);
        break;
    case 'set_cover':
        setCover($_POST);
        break;

    case 'del_page':
        delPage($_POST);
        break;

    case 'update_page':
        updatePage($_POST);
        break;

    case 'add_page':
        addPage($_POST);
        break;

    case 'donot_showindex':
        doNotShowIndex($_POST);
        break;
}

function delImg($req)
{
    $imgid = $req['imgid'];
    $deltype = $req['deltype'];
    $flag = ReviewService::delImg($imgid, $deltype);
    $response['status'] = $flag ? 1 : 0;
    echo json_encode($response);
}

function setCover($req)
{
    $imgid = $req['imgid'];
    $flag = ReviewService::setCover($imgid);
    $response['status'] = $flag ? 1 : 0;
    echo json_encode($response);
}

function delPage($req)
{
    $pageid = $req['pageid'];
    $deltype = $req['deltype'];
    $flag = ReviewService::delPage($pageid, $deltype);
    $response['status'] = $flag ? 1 : 0;
    echo json_encode($response);
}

function updatePage($req)
{
    $pageid = $req['pageid'];
    $title = $req['title'];
    $showindex = $req['showindex'];
    $response['status'] = 0;
    if (empty($title)) {
        $response['msg'] = "标题不能为空";
        echo json_encode($response);
        return;
    }
    ReviewService::update($pageid, $title, $showindex);
    $response['status'] = 1;
    echo json_encode($response);
}

function addPage($req)
{
    $response['status'] = 0;
    $title = $req['title'];
    $imgurl = $req['imgurl'];
    $imgname = $req['imgname'];
    $showindex = $req['showindex'];
    $imgArr = array();
    if (!empty($imgname)) {
        $imgs = explode(";", $imgname);
        foreach ($imgs as $name) {
            if (empty($name)) continue;
            $imgArr[] = $name;
        }
    }

    if (!empty($imgurl)) {
        $urlArr = explode(";", $imgurl);
        foreach ($urlArr as $url) {
            if (empty($url)) continue;
            $newName=uniqid().".jpg";
            $tarFilePath=MIMGPATH.$newName;
            DownLoader::download($url,$tarFilePath);
            $imgArr[] = $newName;
        }
    }
    if(count($imgArr)==0){
        $response['msg'] = "图片不能为空";
        echo json_encode($response);
        return;
    }
    $page=[];
    $page['pageid']=SequenceHelper::getSequence("SEQ_PAGE");
    $page['title']=$title;
    $page['cover']=$imgArr[0];
    $page['imgnum']=count($imgArr);
    $page['status']=20;
    $page['cuserid']=6;
    $page['cusername']="胖大掌柜";
    $t=time()*1000;
    $page['cdate']=$t;
    $page['udate']=$t;
    $page['showindex']=$showindex;
    ReviewService::addPage($page,$imgArr);
    $response['status'] = 1;
    echo json_encode($response);
}

function doNotShowIndex($req){
    $pageid = $req['pageid'];
    $flag = ReviewService::updateShowIndex($pageid, 0);
    $response['status'] = $flag ? 1 : 0;
    echo json_encode($response);
}