<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
load()->model('user');
$_W['token'] = token();
$session = json_decode(base64_decode($_GPC['__session']), true);
if(is_array($session)) {
	$user = user_single($session['id']);
	if(is_array($user) && $session['hash'] == md5($user['passwd'] . $user['salt'])) {
		$_W['uid'] = $user['id'];
		$_W['username'] = $user['name'];
		$_W['user'] = $user;
		$founders = explode(',', $_W['config']['setting']['founder']);
		$_W['isfounder'] = in_array($_W['uid'], $founders);
		unset($founders);
	} else {
		isetcookie('__session', false, -100);
	}
	unset($user);
}
unset($session);

function message($msg, $redirect = '', $type = '') {
    global $_W;
    if($redirect == 'refresh') {
        $redirect = $_W['script_name'] . '?' . $_SERVER['QUERY_STRING'];
    }
    if($redirect == 'referer') {
        $redirect = referer();
    }
    $type == 'error' && $type = 'danger';
    $type = in_array($type, array('success', 'error', 'info', 'warning', 'danger')) ? $type : 'success';

    include template('common/message', TEMPLATE_INCLUDEPATH);
    exit();
}