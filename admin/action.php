<?php
header("Content-type: text/html; charset=utf-8");
session_start();
require_once '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'Config.php';
require_once '..' . DIRECTORY_SEPARATOR . 'admin' . PATH . 'ReviewService.php';

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
}

function delImg($req)
{
    $imgid = $req['imgid'];
    $flag = ReviewService::delImg($imgid);
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
    $flag = ReviewService::delPage($pageid,$deltype);
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