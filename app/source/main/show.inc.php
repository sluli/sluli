<?php
defined('IN_IA') or exit('Access Denied');
require IA_ROOT . '/app/auth.php';

$id = $_GPC['id'];
if( $_GPC['act'] == 'auth' ){
    $code = $_GPC['code'];
    if( empty($code) ){
        exit('Param Error!');
    }

    $auth = new Auth( $_W['config']['setting']['appId'], $_W['config']['setting']['appSecret'] );

    $token = $auth->getOauthInfo($code);
    $openid = isset($token['openid']) ? $token['openid'] : '';

}
if( !Common::is_weixin() ){
    //exit('请使用微信浏览器访问');
    header('Location:http://tz.52dinghuo.com/zgxt/yqx.php?top=118&cpid=959');
    exit();
}
list($id, $uid) = explode('_', $_GPC['id']);
$flag = intval($_GPC['flag']);

$market = pdo_fetch('SELECT m.*, g.thumb FROM '.tablename('market')." m LEFT JOIN ".tablename('goods')." g ON m.gid=g.gid WHERE id=:id", [':id'=>$id]);
$users = pdo_fetch('SELECT * FROM '.tablename('users')." WHERE id=:id", [':id'=>$uid]);
if( empty($market) || empty($users) ){
    exit('fail');
}
$domains = Common::getDomains();

$isMain = in_array($_SERVER['HTTP_HOST'], $domains['main']) ? 1 : 0;
$target_url = '';
/* if( $isMain && !$flag ){
    $domain = array_pop($domains['main']);
    $target_url = "http://{$domain}/app/" . urlGo('main', 'show', ['id' => "{$id}_{$uid}", 'flag'=>1]);
}elseif ( $isMain && $flag == 1 ) {
    $domain = array_pop($domains['main']);
    $target_url = "http://{$domain}/app/" . urlGo('main', 'show', ['id' => "{$id}_{$uid}", 'flag'=>2]);
    //header('Location:'.$target_url);
} else {
    //授权
    //$openid = $_GPC['openid'];
    if( empty($openid) ){
        $callback = urlencode("http://{$_SERVER['HTTP_HOST']}/app/" . urlGo('main', 'show', ['act'=>'auth','id' => "{$id}_{$uid}", 'flag'=>2]));
        $auth = new Auth( $_W['config']['setting']['appId'], $_W['config']['setting']['appSecret'] );

        $authUrl = $auth->getOauthUserInfoUrl($callback, '');
        header('Location:'.$authUrl);
        exit();
    }
    //测试域名
    $domain = array_pop($domains['test']);
    $target_url = "http://{$domain}/app/" . urlGo('main', 'share', ['id' => "{$id}_{$uid}", 'openid'=>$openid]);
    //header('Location:'.$target_url);
    echo "<script type='text/javascript'>";
    echo "location.href='{$target_url}';";
    echo "</script>";
    exit();
} */
if( $isMain ) {
    $domain = array_pop($domains['test']);
    $target_url = "http://{$domain}/app/" . urlGo('main', 'share', ['id' => "{$id}_{$uid}"]);
}
$head_title = $market['title'];
require IA_ROOT . '/framework/opp/jssdk/jssdk.php';
$jssdk = new JSSDK($_W['config']['setting']['appId'], $_W['config']['setting']['appSecret']);
$signPackage = $jssdk->GetSignPackage();

template('main/show');