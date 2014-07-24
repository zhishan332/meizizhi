<?php
session_start();
require_once '..' . DIRECTORY_SEPARATOR . 'includes'.DIRECTORY_SEPARATOR . 'Config.php';

$page_title="查看";
include(ROOT . "/web/views/top-a.html");
include(ROOT . "/web/views/view.html");
include(ROOT . "/web/views/footer-a.html");