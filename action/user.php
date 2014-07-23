<?php
header("Content-type: text/html; charset=utf-8");
require_once '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'Config.php';
require_once '..' . DIRECTORY_SEPARATOR . 'includes' . PATH . 'service' . PATH . 'UserService.php';
$ac = $_GET['ac'];
switch ($ac) {
    case 'signup':
        signup($_POST);
        break;
}

function signup($req)
{
    $username = trim($req['username']);
    $email = trim($req['email']);
    $tel = trim($req['tel']);
    $password = $req['password'];
    $password2 = $req['password2'];
    $response['status'] = 0;
    if (empty($username)) {
        $response['msg'] = "用户名不能为空";
        echo $response;
        return;
    }
    if (strlen($username) < 2 || strlen($username) > 10) {
        $response['msg'] = "用户名长度需要在2到10位之间";
        echo $response;
        return;
    }

    if (empty($email)) {
        $response['msg'] = "邮箱格式不正确";
        echo $response;
        return;
    }
    if (!emailFormatCheck($email)) {
        $response['msg'] = "邮箱格式不正确";
        echo $response;
        return;
    }
    if (!empty($tel) && !telFormatCheck($tel)) {
        $response['msg'] = "手机号码格式不对";
        echo $response;
        return;
    }
    if (empty($password) || empty($password2)) {
        $response['msg'] = "密码不能为空";
        echo $response;
        return;
    }
    if ($password != $password2) {
        $response['msg'] = "两次输入的密码不一致";
        echo $response;
        return;
    }

}

/**
 * email格式校验
 * @param {Object} email 邮件地址内容
 * @return bool
 */
function emailFormatCheck($email)
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

function telFormatCheck($tel)
{
    if (preg_match("/^13[0-9]{1}[0-9]{8}$|15[0189]{1}[0-9]{8}$|18[0-9]{1}[0-9]{8}$|14[0-9]{1}[0-9]{8}$|170[0-9]{8}$/", $tel)) {
        return true;
    } else {
        return false;
    }
}