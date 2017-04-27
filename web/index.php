<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
define('IN_SYS', true);
require '../framework/bootstrap.inc.php';
load()->web('template');
require IA_ROOT . '/web/common/bootstrap.sys.inc.php';

//if ($_W['setting']['copyright']['status'] == 1) {
//    $_W['siteclose'] = true;
//    message('抱歉，站点已关闭，关闭原因：' . $_W['setting']['copyright']['reason']);
//}
//echo json_encode($_W);exit();
$controller = isset($_GPC['c']) ? $_GPC['c'] : 'main';
$action = isset($_GPC['a']) ? $_GPC['a'] : 'index';
Common::checkLogin();

require _forward($controller, $action);

function _forward($c, $a) {
    $file = IA_ROOT . '/web/source/' . $c . '/' . $a . '.inc.php';
    if(!file_exists($file)){
        exit("{$c}/{$a} not found.");
    }
    return $file;
}