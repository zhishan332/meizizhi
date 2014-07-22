<?php
/**
 * Created by JetBrains PhpStorm.
 * User: yfwangqing
 * Date: 14-7-16
 * Time: 下午4:53
 * To change this template use File | Settings | File Templates.
 */
require_once '..' . DIRECTORY_SEPARATOR . 'includes'.DIRECTORY_SEPARATOR . 'Config.php';
require_once SERVCIEROOT . 'PageService.php';

$page_title="首页";
include(ROOT . "/web/views/top-a.html");
include(ROOT . "/web/views/index.html");
include(ROOT . "/web/views/footer-a.html");