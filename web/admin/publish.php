<?php
require_once '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'Config.php';
require_once ROOT.PATH.'includes' .PATH.'admin'.PATH. 'AdminService.php';

$uploadFilePath='../../action/uploadify.php';
$timestamp=time();
$token=md5('zhimeizimeizizhi9_wangqing' . $timestamp);
$page_title = "内容管理-内容发布";
include("views/top.html");
include("views/publish.html");