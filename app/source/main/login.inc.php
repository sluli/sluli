<?php
defined('IN_IA') or exit('Access Denied');
if( $_GPC['act'] == 'out' ){
    isetcookie('__session', false, -100);
    message('退出成功!', urlGo('main','login'));
    exit();
}

if ( checksubmit('submit') ) {
    $name = $_GPC['username'];
    $passwd = $_GPC['passwd'];
    if( empty($name)  ){
        message('不输入帐号就想登录？？', '', 'error');
    }

    $user = pdo_fetch('SELECT * FROM '.tablename('users')." where name ='{$name}'");
    if( empty($user) ){
        message('用户名或密码错误~', '', 'error');
    }
    if( $user['passwd'] != user_hash($passwd, $user['salt']) || !$user['status'] ){
        message('用户名或密码错误~', '', 'error');
    }
    if( !$user['is_front'] ){
        message('你的帐号不能登录前台哦', '', 'error');
    }
    $cookie = array();
    $cookie['id'] = $user['id'];
    $cookie['hash'] = md5($user['passwd'] . $user['salt']);
    $session = base64_encode(json_encode($cookie));
    isetcookie('__session', $session, 7 * 86400);
    message('登录成功~', urlGo('main', 'index'));
    exit();
}
template('main/login');