<?php
header("Content-type: text/html; charset=utf-8");
session_start();
require_once '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'Config.php';
require_once '..' . DIRECTORY_SEPARATOR . 'includes' . PATH . 'service' . PATH . 'DiscussService.php';
$ac = $_GET['ac'];
switch ($ac) {
    case 'query_discuss':
        queryDiscuss($_GET); //查询评论
        break;
    case 'add_discuss':
        addDiscuss($_POST); //查询评论
        break;
}

function queryDiscuss($req)
{
    $pageid = $req['pageid'];
    $response['status'] = 0;
    if (empty($pageid)) {
        echo json_encode($response);
        return;
    }
    $response['status'] = 1;
    $response['data'] = DiscussService::queryDiscuss($pageid);
    echo json_encode($response);
}

function addDiscuss($req)
{
    $discuss = $req['dis'];
    $pageid = $req['pageid'];
    $response['status'] = 0;
    if (empty($discuss) || empty($pageid)) {
        $response['msg'] = "评论内容不能为空";
        echo json_encode($response);
        return;
    }
    if (strlen($discuss) > 60) {
        $response['msg'] = "评论要短小精悍";
        echo json_encode($response);
        return;
    }
    $user = $_SESSION['user'];
    if (empty($user)) {
        $response['msg'] = "登录后您才能发表评论";
        echo json_encode($response);
        return;
    }
    $disObj['pageid'] = $pageid;
    $disObj['discuss'] = $discuss;
    $disObj['userid'] = $user['userid'];
    $disObj['username'] = $user['username'];
    $disObj['cdate'] = time();
    $id = DiscussService::insertDiscuss($disObj);
    if ($id > 0) {
        $response['status'] = 1;
    } else {
        $response['msg'] = "很抱歉，由于系统问题该评论没有发布成功";
    }
    echo json_encode($response);
}