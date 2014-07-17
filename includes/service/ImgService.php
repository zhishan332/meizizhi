<?php
/**
 * Created by JetBrains PhpStorm.
 * User: yfwangqing
 * Date: 14-7-16
 * Time: 下午4:49
 * 图片操作
 */

require_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'Config.php';
require_once dirname(dirname(__FILE__)) . PATH . 'dao' . PATH . 'MySQL.php';
class ImgService
{

    static function find($start = 0, $limit = DEFAULT_LIMIT)
    {
        $sql = "select id,title,url,description,udate,imgnum,imgurl from page order by udate limit  " . $start . "," . $limit;
        $mysql = new MySQL();
        $res = $mysql->executeSQL($sql);
        $mysql->closeConnection();
        var_dump($res);
    }
}