<?php
/**
 * Created by JetBrains PhpStorm.
 * User: yfwangqing
 * Date: 14-7-24
 * Time: 上午9:55
 * To change this template use File | Settings | File Templates.
 */
require_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'Config.php';
require_once dirname(dirname(__FILE__)) . PATH . 'dao' . PATH . 'MySQL.php';

class SequenceHelper
{

    public static function getSequence($seqType)
    {
        $replace_sql = "replace into sequence(seqname) VALUES('" . $seqType . "')";
        $mysql = new MySQL();
        $mysql->execute($replace_sql);
        $get_sql = "select seq from sequence where seqname='" . $seqType . "'";
        $res = $mysql->executeReturnFirstObj($get_sql);
        $seq = $res['seq'];
        $mysql->closeCon();
        return $seq;
    }

}