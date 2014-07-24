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
        $mysql = new MySQL();
        $id = $mysql->insert("user", $user);
        $mysql->closeCon();
        return $id;
    }

    public static function verifyUsername($username)
    {
        $mysql = new MySQL();
        $where = "username='" . $username . "'";
        $total = $mysql->countRows("user", $where);
        $mysql->closeCon();
        return $total > 0;
    }

    public static function verifyEmail($email)
    {
        $mysql = new MySQL();
        $where = "email='" . $email . "'";
        $total = $mysql->countRows("user", $where);
        $mysql->closeCon();
        return $total > 0;
    }

    public static function verifyTel($tel)
    {
        $mysql = new MySQL();
        $where = "tel='" . $tel . "'";
        $total = $mysql->countRows("user", $where);
        $mysql->closeCon();
        return $total > 0;
    }

    public static function getUser($user)
    {
        $mysql = new MySQL();
        $where = " (email='" . $user['user'] . "' or tel='" . $user['user'] . "') and password='" . $user['password'] . "'";
        $fd = array("userid,username,email,tel");
        $res = $mysql->selectOne("user", $where, $fd);
        $mysql->closeCon();
        return $res;
    }
}