<?php
require_once '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'Config.php';
require_once ROOT.PATH.'includes' .PATH.'admin'.PATH. 'AdminService.php';

$page_title = "内容管理-内容审核";
include("views/top.html");
include("views/review.html");