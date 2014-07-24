<?php
/**
 * Created by JetBrains PhpStorm.
 * User: yfwangqing
 * Date: 14-7-16
 * Time: 下午4:50
 * To change this template use File | Settings | File Templates.
 */
error_reporting(E_WARNING);
define("CHARSET", "utf-8");
define("ROOT", dirname(dirname(__FILE__)));
define("PATH", DIRECTORY_SEPARATOR);
define("SERVCIEROOT", (dirname(dirname(__FILE__)) . PATH . 'includes' . PATH . 'service' . PATH));
define("STATICROOT", "http://127.0.0.1:9999/meizizhi/web/statics");
define("STATICROOT2", "http://127.0.0.1:8181/hunter/imgs");
//查询Limit默认条数
define('DEFAULT_LIMIT', 10);
//sequence type
define('SEQ_USER', "SEQ_USER");