<?php
/**
 * Created by JetBrains PhpStorm.
 * User: yfwangqing
 * Date: 14-7-24
 * Time: 下午3:05
 * To change this template use File | Settings | File Templates.
 */
require_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'Config.php';
require_once dirname(dirname(__FILE__)) . PATH . 'dao' . PATH . 'MySQL.php';
class DiscussService
{

    public static function queryDiscuss($pageid)
    {
        $sql = "select id,pageid,userid,username,discuss,cdate from page_discs where pageid=" . $pageid;
        $mysql = new MySQL();
        $res = $mysql->executeReturnObj($sql);
        $mysql->closeCon();

        return $res;
    }
}