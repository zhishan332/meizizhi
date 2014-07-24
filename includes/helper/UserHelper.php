<?php
/**
 * Created by JetBrains PhpStorm.
 * User: yfwangqing
 * Date: 14-7-24
 * Time: 上午10:15
 * To change this template use File | Settings | File Templates.
 */

class UserHelper
{
    /**
     * email格式校验
     * @param {Object} email 邮件地址内容
     * @return bool
     */
    public static function emailFormatCheck($email)
    {
        if (strlen($email) > 128 || strlen($email) < 6) {
            return false;
        }
        $pattern = "/^[A-Za-z0-9+]+[A-Za-z0-9\.\_\-+]*@([A-Za-z0-9\-]+\.)+[A-Za-z0-9]+$/i";
        if (preg_match($pattern, $email)) {
            return true;
        }
        return false;
    }

    public static function telFormatCheck($tel)
    {
        if (preg_match("/^13[0-9]{1}[0-9]{8}$|15[0189]{1}[0-9]{8}$|18[0-9]{1}[0-9]{8}$|14[0-9]{1}[0-9]{8}$|170[0-9]{8}$/", $tel)) {
            return true;
        } else {
            return false;
        }
    }
}