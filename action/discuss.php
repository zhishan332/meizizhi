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