<?php
/**
 * Created by JetBrains PhpStorm.
 * User: yfwangqing
 * Date: 14-7-24
 * Time: 下午5:58
 * To change this template use File | Settings | File Templates.
 */
require_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'Config.php';
require_once dirname(dirname(__FILE__)) . PATH . 'dao' . PATH . 'MySQL.php';
class EmotionService {

    public static function  queryAllEmotion(){
        $sql = "select phrase,type,url,hot,common,category,icon,value,picid from emotion ";
        $mysql = new MySQL();
        $res = $mysql->executeReturnObj($sql);
        $mysql->closeCon();
        return $res;
    }
}