<?php
/**
 * Created by JetBrains PhpStorm.
 * User: wangq
 * Date: 14-7-16
 * Time: 下午9:18
 * To change this template use File | Settings | File Templates.
 */
session_start();
header("Content-type: text/html; charset=utf-8");
require_once '..' . DIRECTORY_SEPARATOR . 'includes'.DIRECTORY_SEPARATOR . 'Config.php';
require_once ROOT . PATH . 'includes'.PATH .'service'.PATH. 'PageService.php';
$st = empty($_GET['st']) ? 0 : $_GET['st'];
$page_title="三国志";
$pages=PageService::find($st,10);
include(ROOT . "/web/views/top-a.html");
include(ROOT . "/web/views/meizi.html");
include(ROOT . "/web/views/footer-a.html");