<?php
defined('IN_IA') or exit('Access Denied');
$do = $_GPC['do'];
if( $do == 'abc'){
    echo 'ABC';
    exit();
}
//所有推广
$market_list = pdo_fetchall('SELECT * FROM '.tablename('market').' WHERE roles_id=:roles_id and status=1 ORDER BY id DESC', [':roles_id'=>$_W['user']['roles_id']]);
//今日订单
$start_time = strtotime(date('Y-m-d 00:00:00'));
$end_time = strtotime(date('Y-m-d 23:59:00'));
$toDayOrderNum = pdo_fetchcolumn('SELECT count(*) FROM '.tablename('orders').' WHERE uid=:uid AND add_time>=:start_time AND add_time<:end_time', [':uid'=>$_W['uid'],':start_time'=>$start_time, ':end_time'=>$end_time]);


$toDayOKOrderNum = pdo_fetchcolumn('SELECT count(*) FROM '.tablename('orders').' WHERE uid=:uid AND add_time>=:start_time AND add_time<:end_time AND dubious=0', [':uid'=>$_W['uid'],':start_time'=>$start_time, ':end_time'=>$end_time]);

$toDayNoOrderNum = pdo_fetchcolumn('SELECT count(*) FROM '.tablename('orders').' WHERE uid=:uid AND add_time>=:start_time AND add_time<:end_time AND dubious=1', [':uid'=>$_W['uid'],':start_time'=>$start_time, ':end_time'=>$end_time]);


//昨日订单
$start_time = strtotime(date('Y-m-d 00:00:00')) - 86400;
$end_time = strtotime(date('Y-m-d 23:59:00')) - 86400;
$yesterDayOrderNum = pdo_fetchcolumn('SELECT count(*) FROM '.tablename('orders').' WHERE uid=:uid AND add_time>=:start_time AND add_time<:end_time', [':uid'=>$_W['uid'],':start_time'=>$start_time, ':end_time'=>$end_time]);
//本月订单
$start_time = strtotime(date('Y-m-1 00:00:00'));
$end_time = strtotime(date('Y-m-d 23:59:00'));
$monthOrderNum = pdo_fetchcolumn('SELECT count(*) FROM '.tablename('orders').' WHERE uid=:uid AND add_time>=:start_time AND add_time<:end_time', [':uid'=>$_W['uid'],':start_time'=>$start_time, ':end_time'=>$end_time]);
$domains = Common::getDomains();
$domain = array_pop($domains['main']);

template('main/home');