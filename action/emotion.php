<?php
header("Content-type: text/html; charset=utf-8");
session_start();
require_once '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'Config.php';
require_once '..' . DIRECTORY_SEPARATOR . 'includes' . PATH . 'service' . PATH . 'EmotionService.php';
$ac = $_GET['ac'];
switch ($ac) {
    case 'query_all':
        queryAll(); //查询评论
        break;
}
function queryAll()
{
    $data = EmotionService::queryAllEmotion();
    echo json_encode($data);
}