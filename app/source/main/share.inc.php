<?php
defined('IN_IA') or exit('Access Denied');
@session_start();
if( !Common::is_weixin() ){
    //exit('请使用微信浏览器访问');
}
$id = $_GPC['id'];
$ref = $_GPC['ref'];
$openid = $_GPC['openid'];
list($id, $uid) = explode('_', $_GPC['id']);

$market = pdo_fetch('SELECT m.*, g.thumb FROM '.tablename('market')." m LEFT JOIN ".tablename('goods')." g ON m.gid=g.gid WHERE m.id=:id", [':id'=>$id]);
$users = pdo_fetch('SELECT * FROM '.tablename('users')." WHERE id=:id", [':id'=>$uid]);
if( empty($market) || empty($users) ){
    exit('fail');
}
$domains = Common::getDomains();
if( $ref ){
    /* if( !isset($_SESSION['HTTP_REFERER']) ){
        header('Location:/404/');
        exit();
    }
    $paths = parse_url($_SESSION['HTTP_REFERER']);
    if( !in_array($paths['path'], $domains['test']) ){
        header('Location:/404/');
        exit();
    } */
} else {

    $row = pdo_fetch('SELECT count(*) as num FROM '.tablename('orders')." WHERE market_id = :market_id AND openid=:openid", [':market_id'=>$id, ':openid'=>$openid]);
    if( !empty($row) && $row['num']>=2 ){
        header('Location:'.urlGo('order','delivery'));
        exit();
    }


    $domain = array_pop($domains['test']);
    $target_url = "http://{$domain}/app/" . urlGo('main', 'share', ['id' => "{$id}_{$uid}",'ref'=>time(),'openid'=>$openid]);
    $_SESSION['HTTP_REFERER'] = $domain;
    echo "<script type='text/javascript'>";
    echo "location.href='{$target_url}';";
    echo "</script>";
    //header('Location:'.$target_url);
    exit();
}
$isMain = 0;
$head_title = $market['title'];
require IA_ROOT . '/framework/opp/jssdk/jssdk.php';
$jssdk = new JSSDK($_W['config']['setting']['appId'], $_W['config']['setting']['appSecret']);
$signPackage = $jssdk->GetSignPackage();

template('main/show');