<?php
header("Content-type: text/html; charset=utf-8");
session_start();
set_time_limit(0);
require_once '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'Config.php';
require_once dirname(dirname(dirname(__FILE__))) . PATH . "includes" . PATH . 'dao' . PATH . 'MySQL.php';

$data = $_POST['dd'];
if (!empty($data)) {
    $mysql = new MySQL();

    $objs=json_decode($data);
//    echo count($objs);exit;
    foreach ($objs as $d) {
        $insertData['phrase'] = $d->phrase;
        $insertData['type'] = $d->type;
        $insertData['url'] = $d->url;
        $insertData['hot'] = $d->hot;
        $insertData['common'] = $d->common;
        $insertData['category'] = $d->category;
        $insertData['icon'] =$d->icon;
        $insertData['value'] =$d->value;
        $insertData['picid'] =$d->picid;
//        var_dump($insertData);
        $id = $mysql->insert("emotion", $insertData);
        echo "id=".$id."  ";
    }
    $mysql->closeCon();
    echo json_encode("解析成功");
    exit;
} else {
    echo json_encode("没有数据");
}