<?php
/**
 * Created by JetBrains PhpStorm.
 * User: yfwangqing
 * Date: 14-7-17
 * Time: 下午4:02
 * To change this template use File | Settings | File Templates.
 */
require_once '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'Config.php';
require_once ROOT.PATH.'includes' .PATH.'admin'.PATH. 'AdminService.php';

$page_title = "管理首页";
include("views/top.html");
include("views/index.html");