<?php
/**
 * Created by JetBrains PhpStorm.
 * User: yfwangqing
 * Date: 14-7-23
 * Time: 下午5:08
 * To change this template use File | Settings | File Templates.
 */
require_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'Config.php';
require_once dirname(dirname(__FILE__)) . PATH . 'dao' . PATH . 'MySQL.php';
class UserService
{

    public static function signup($user)
    {
        $sql = "insert into user(userid,username,email,tel,password,cdate,udate) values()";
        $mysql = new MySQL();
        $datatypes=array('int','str','str','str','str','int','int');
        $mysql->insert("user",$user,'',$datatypes);
        $mysql->closeConnection();
    }

    public static function verifyUsername($username)
    {
        $mysql = new MySQL();
        $where = "username='" . $username . "'";
        $total = $mysql->countRows("user", $where);
        $mysql->closeConnection();
        return $total > 0;
    }

    public static function verifyEmail($email)
    {
        $mysql = new MySQL();
        $where = "email='" . $email . "'";
        $total = $mysql->countRows("user", $where);
        $mysql->closeConnection();
        return $total > 0;
    }

    public static function verifyTel($tel)
    {
        $mysql = new MySQL();
        $where = "tel='" . $tel . "'";
        $total = $mysql->countRows("user", $where);
        $mysql->closeConnection();
        return $total > 0;
    }
}