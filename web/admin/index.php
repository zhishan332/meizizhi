<?php
require_once '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'Config.php';
require_once ROOT.PATH.'includes' .PATH.'admin'.PATH. 'AdminService.php';

$page_title = "管理首页";
include("views/top.html");
include("views/index.html");