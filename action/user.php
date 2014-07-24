<?php
header("Content-type: text/html; charset=utf-8");
session_start();
require_once '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'Config.php';
require_once '..' . DIRECTORY_SEPARATOR . 'includes' . PATH . 'service' . PATH . 'UserService.php';
require_once '..' . DIRECTORY_SEPARATOR . 'includes' . PATH . 'helper' . PATH . 'SequenceHelper.php';
require_once '..' . DIRECTORY_SEPARATOR . 'includes' . PATH . 'helper' . PATH . 'UserHelper.php';
$ac = $_GET['ac'];
switch ($ac) {
    case 'signup':
        signup($_POST);
        break;
    case 'login':
        login($_POST);
        break;
    case 'logout':
        logout();
        break;
    case 'checkemail':
        checkEmail($_POST);
        break;
    case 'checkusername':
        checkUserName($_POST);
        break;
    case 'checktel':
        checkTel($_POST);
        break;

}
function logout(){
    cleanSessionCookie();
    $response['status'] = 1;
    echo json_encode($response);
}
function login($req)
{
    $emailOrTel = trim($req['user']);
    $password = $req['password'];
    $response['status'] = 0;
    if (empty($emailOrTel) || empty($password)) {
        $response['msg'] = "用户名密码格式错误";
        echo json_encode($response);
        return;
    }
    $user['user'] = $emailOrTel;
    $user['password'] = $password;
    $res = UserService::getUser($user);
    if (empty($res)||count($res)<=0) {
        $response['msg'] = "用户名密码错误";
        echo json_encode($response);
        return;
    }
    $response['status'] = 1;
    setSessionCookie($res);
    echo json_encode($response);
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
        echo json_encode($response);
        return;
    }
    if (strlen($username) < 2 || strlen($username) > 10) {
        $response['msg'] = "用户名长度需要在2到10位之间";
        echo json_encode($response);
        return;
    }
    if (UserService::verifyUsername($username)) {
        $response['msg'] = "用户名已存在";
        echo json_encode($response);
        return;
    }
    if (empty($email)) {
        $response['msg'] = "邮箱格式不正确";
        echo json_encode($response);
        return;
    }
    if (!UserHelper::emailFormatCheck($email)) {
        $response['msg'] = "邮箱格式不正确";
        echo json_encode($response);
        return;
    }
    if (UserService::verifyEmail($email)) {
        $response['msg'] = "邮箱已被注册";
        echo json_encode($response);
        return;
    }
    if (!empty($tel) && !UserHelper::telFormatCheck($tel)) {
        $response['msg'] = "手机号码格式不对";
        echo json_encode($response);
        return;
    }
    if (UserService::verifyTel($tel)) {
        $response['msg'] = "手机号码已被注册";
        echo json_encode($response);
        return;
    }
    if (empty($password) || empty($password2)) {
        $response['msg'] = "密码不能为空";
        echo json_encode($response);
        return;
    }
    if ($password != $password2) {
        $response['msg'] = "两次输入的密码不一致";
        echo json_encode($response);
        return;
    }
    $user['userid'] = SequenceHelper::getSequence(SEQ_USER);
    $user['username'] = $username;
    $user['email'] = $email;
    $user['tel'] = $tel;
    $user['password'] = $password;
    $user['cdate'] = time();
    $user['udate'] = time();
    $id = UserService::signup($user);
    if ($id <= 0) {
        $response['msg'] = "抱歉，系统错误注册失败";
        echo json_encode($response);
        return;
    }
    $response['status'] = 1;
    setSessionCookie($user);
    echo json_encode($response);
}

function checkUserName($req)
{
    $username = trim($req['username']);
    $response['status'] = 0;
    if (empty($username)) {
        $response['msg'] = "昵称格式错误";
        echo json_encode($response);
        return;
    }
    if (UserService::verifyUsername($username)) {
        $response['msg'] = "昵称已被注册";
        echo json_encode($response);
        return;
    }
    $response['status'] = 1;
    echo json_encode($response);
}

function checkTel($req)
{
    $tel = trim($req['tel']);
    $response['status'] = 0;
    if (empty($tel)) {
        $response['status'] = 1;
        echo json_encode($response);
        return;
    }
    if (UserService::verifyTel($tel)) {
        $response['msg'] = "手机号码已被注册";
        echo json_encode($response);
        return;
    }
    $response['status'] = 1;
    echo json_encode($response);
}

function checkEmail($req)
{
    $email = trim($req['email']);
    $response['status'] = 0;
    if (empty($email)) {
        $response['msg'] = "邮箱格式错误";
        echo json_encode($response);
        return;
    }
    if (UserService::verifyEmail($email)) {
        $response['msg'] = "邮箱已被注册";
        echo json_encode($response);
        return;
    }
    $response['status'] = 1;
    echo json_encode($response);
}

function setSessionCookie($user)
{
    $_SESSION['user']=$user;
    setcookie("email", $user['email'], time() + 31104000, "/"); //360天过时
    setcookie("password", $user['password'], time() + 31104000, "/"); //360天过时
}

function cleanSessionCookie()
{
    unset($_SESSION['user']);
    setcookie("email", "", time() - 31104000, "/"); //360天过时
    setcookie("password", "", time() - 31104000, "/"); //360天过时
}