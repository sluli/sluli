<?php
/**
 * [MicroEngine Mall] Copyright (c) 2014 WE7.CC
 * MicroEngine Mall is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */

define('IN_IA', true);
define('STARTTIME', microtime());

define('IA_ROOT', str_replace("\\", '/', dirname(dirname(__FILE__))));
define('ATTACHMENT_ROOT', IA_ROOT .'/attachment');
define('MAGIC_QUOTES_GPC', (function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) || @ini_get('magic_quotes_sybase'));
define('TIMESTAMP', time());

$_W = $_GPC = array();

require IA_ROOT . "/data/config.php";
require IA_ROOT . '/framework/class/loader.class.php';
require IA_ROOT . "/data/Common.php";
load()->func('global');
load()->func('pdo');
load()->classs('db');
load()->classs('agent');

$_W['config'] = $config;
unset($config);


define('CLIENT_IP', getip());
$_W['clientip'] = CLIENT_IP;
$_W['timestamp'] = TIMESTAMP;
$_W['charset'] = $_W['config']['setting']['charset'];
$_W['token'] = token();

define('DEVELOPMENT', $_W['config']['setting']['development'] == 1);
if(DEVELOPMENT) {
    ini_set('display_errors', '1');
    error_reporting(E_ALL ^ E_NOTICE);
} else {
    error_reporting(0);
}

if(!in_array($_W['config']['setting']['cache'], array('mysql', 'file'))) {
    $_W['config']['setting']['cache'] = 'mysql';
}

if(function_exists('date_default_timezone_set')) {
    date_default_timezone_set($_W['config']['setting']['timezone']);
}
if(!empty($_W['config']['memory_limit']) && function_exists('ini_get') && function_exists('ini_set')) {
    if(@ini_get('memory_limit') != $_W['config']['memory_limit']) {
        @ini_set('memory_limit', $_W['config']['memory_limit']);
    }
}

$_W['script_name'] = htmlspecialchars(scriptname());

$sitepath = substr($_SERVER['PHP_SELF'], 0, strrpos($_SERVER['PHP_SELF'], '/'));
$_W['siteroot'] = htmlspecialchars('http://' . $_SERVER['HTTP_HOST'] . $sitepath);
unset($sitepath);

if(substr($_W['siteroot'], -1) != '/') {
    $_W['siteroot'] .= '/';
}
$urls = parse_url($_W['siteroot']);
$urls['path'] = str_replace(array('/web', '/app', '/payment/wechat', '/payment/alipay', '/api'), '', $urls['path']);
$_W['siteroot'] = $urls['scheme'].'://'.$urls['host'].((!empty($urls['port']) && $urls['port']!='80') ? ':'.$urls['port'] : '').$urls['path'];
$_W['siteurl'] = $urls['scheme'].'://'.$urls['host'].((!empty($urls['port']) && $urls['port']!='80') ? ':'.$urls['port'] : '') . $_W['script_name'] . (empty($_SERVER['QUERY_STRING'])?'':'?') . $_SERVER['QUERY_STRING'];
$_W['attachurl'] = $_W['siteroot'] . 'attachment/';

if (!empty($_W['setting']['upload']['type']) && $_W['setting']['upload']['type'] != UPLOAD_TYPE_COMMON) {
    $_W['attachurl'] = ($_W['setting']['upload']['type'] == UPLOAD_TYPE_REMOTE)
        ? "{$_W['setting']['upload']['remote']['url']}/"
        : "http://{$_W['setting']['upload']['alioss']['url']}.aliyuncs.com/{$_W['setting']['upload']['alioss']['bucket']}/";
}
unset($urls);

$_W['setting']['upload']['image']['folder'] = "images/" . date('Y/m/d/');
$_W['setting']['upload']['audio']['folder'] = "audios/" . date('Y/m/d/');

$_W['isajax'] = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
$_W['ispost'] = $_SERVER['REQUEST_METHOD'] == 'POST';

if(MAGIC_QUOTES_GPC) {
    $_GET = istripslashes($_GET);
    $_POST = istripslashes($_POST);
    $_COOKIE = istripslashes($_COOKIE);
}
$cplen = strlen($_W['config']['cookie']['pre']);
foreach($_COOKIE as $key => $value) {
    if(substr($key, 0, $cplen) == $_W['config']['cookie']['pre']) {
        $_GPC[substr($key, $cplen)] = $value;
    }
}
unset($cplen, $key, $value);

$_GPC = array_merge($_GET, $_POST, $_GPC);
$_GPC = ihtmlspecialchars($_GPC);
if(!$_W['isajax']) {
    $input = file_get_contents("php://input");
    if(!empty($input)) {
        $__input = @json_decode($input, true);
        if(!empty($__input)) {
            $_GPC['__input'] = $__input;
            $_W['isajax'] = true;
        }
    }
    unset($input, $__input);
}

if (empty($_W['setting']['upload'])) {
    $_W['setting']['upload'] = array_merge($_W['config']['upload']);
}
$_W['attachurl'] = $_W['attachurl_local'] = $_W['siteroot'] . $_W['config']['upload']['attachdir'] . '/';
if (!empty($_W['setting']['remote']['type'])) {
    if ($_W['setting']['remote']['type'] == 1) {
        $_W['attachurl'] = $_W['attachurl_remote'] = $_W['setting']['remote']['ftp']['url'] . '/';
    } elseif ($_W['setting']['remote']['type'] == 2) {
        $_W['attachurl'] = $_W['attachurl_remote'] = $_W['setting']['remote']['alioss']['url'].'/';
    } elseif ($_W['setting']['remote']['type'] == 3) {
        $_W['attachurl'] = $_W['attachurl_remote'] = $_W['setting']['remote']['qiniu']['url'].'/';
    } elseif ($_W['setting']['remote']['type'] == 4) {
        $_W['attachurl'] = $_W['attachurl_remote'] = $_W['setting']['remote']['cos']['url'].'/';
    }
}
$_W['os'] = Agent::deviceType();
if($_W['os'] == Agent::DEVICE_MOBILE) {
    $_W['os'] = 'mobile';
} elseif($_W['os'] == Agent::DEVICE_DESKTOP) {
    $_W['os'] = 'windows';
} else {
    $_W['os'] = 'unknown';
}

$_W['container'] = Agent::browserType();
if(Agent::isMicroMessage() == Agent::MICRO_MESSAGE_YES) {
    $_W['container'] = 'wechat';
} elseif ($_W['container'] == Agent::BROWSER_TYPE_ANDROID) {
    $_W['container'] = 'android';
} elseif ($_W['container'] == Agent::BROWSER_TYPE_IPAD) {
    $_W['container'] = 'ipad';
} elseif ($_W['container'] == Agent::BROWSER_TYPE_IPHONE) {
    $_W['container'] = 'iphone';
} elseif ($_W['container'] == Agent::BROWSER_TYPE_IPOD) {
    $_W['container'] = 'ipod';
} else {
    $_W['container'] = 'unknown';
}

$_W['controller'] = isset($_GPC['c']) ? $_GPC['c'] : 'main';
$_W['action'] = isset($_GPC['a']) ? $_GPC['a'] : 'index';
$_W['do'] = $_GPC['do'];

$_W['page_mark'] = "{$_W['controller']}-{$_W['action']}";

$_W['uid'] = 0;
$_W['user'] = [];
$_W['isfounder'] = false;

function get_city($ip){
    $s = file_get_contents("http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=js&ip=$ip");
    preg_match('/{.+}/',$s,$r);
    $p = json_decode($r[0]);
    $rtn = [];
    $rtn['province'] = isset($p->province) ? $p->province : '';
    $rtn['city'] = isset($p->city) ? $p->city : '';
    $rtn['district'] = isset($p->district) ? $p->district : '';
    return $rtn;
}

function check_city($province, $province2){
    $province = str_replace(['省','市'], '', $province);
    $province2 = str_replace(['省','市'], '', $province2);
    similar_text(urlencode($province), urlencode($province2), $percent);
    return $percent;
}

function getOrderStatus( $status ){
    $txt = '';
    switch ( $status ){
        case 1:
            $txt = '未发货'; break;
        case 2:
            $txt = '待收货'; break;
        case 3:
            $txt = '已收货'; break;
        case 0:
            $txt = '取消'; break;
    }
    return $txt;
}
header('Content-Type: text/html; charset=' . $_W['charset']);