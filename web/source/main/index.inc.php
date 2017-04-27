<?php
defined('IN_IA') or exit('Access Denied');
$do = $_GPC['do'];
if( $do == 'abc'){
    if( !$_W['isfounder'] ){
        $where = "m.roles_id='{$_W['user']['roles_id']}' AND ";
    }
    //今日订单
    $start_time = strtotime(date('Y-m-d 00:00:00'));
    $end_time = strtotime(date('Y-m-d 23:59:00'));
    $toDayOrderNum = pdo_fetchcolumn('SELECT count(*) FROM '.tablename('orders').' o LEFT JOIN '.tablename('market').' m ON(o.market_id=m.id) WHERE '.$where.' o.add_time>=:start_time AND o.add_time<:end_time', [':start_time'=>$start_time, ':end_time'=>$end_time]);

    //昨日订单
    $start_time = strtotime(date('Y-m-d 00:00:00')) - 86400;
    $end_time = strtotime(date('Y-m-d 23:59:00')) - 86400;
    $yesterDayOrderNum = pdo_fetchcolumn('SELECT count(*) FROM '.tablename('orders').' o LEFT JOIN '.tablename('market').' m ON(o.market_id=m.id) WHERE '.$where.' o.add_time>=:start_time AND o.add_time<:end_time', [':start_time'=>$start_time, ':end_time'=>$end_time]);

    //本月订单
    $start_time = strtotime(date('Y-m-1 00:00:00'));
    $end_time = strtotime(date('Y-m-d 23:59:00'));
    $monthOrderNum = pdo_fetchcolumn('SELECT count(*) FROM '.tablename('orders').' o LEFT JOIN '.tablename('market').' m ON(o.market_id=m.id) WHERE '.$where.' o.add_time>=:start_time AND o.add_time<:end_time', [':start_time'=>$start_time, ':end_time'=>$end_time]);
    //上月订单
    $start_time = strtotime('-1 month', strtotime(date('Y-m-1 00:00:00')) );
    $end_time = strtotime(date('Y-m-1 00:00:00'));
    $prevMonthOrderNum = pdo_fetchcolumn('SELECT count(*) FROM '.tablename('orders').' o LEFT JOIN '.tablename('market').' m ON(o.market_id=m.id) WHERE '.$where.' o.add_time>=:start_time AND o.add_time<:end_time', [':start_time'=>$start_time, ':end_time'=>$end_time]);

    //今年
    $start_time = strtotime(date('Y-1-1 00:00:00'));
    $end_time = strtotime(date('Y-m-d 23:59:00'));
    $yearOrderNum = pdo_fetchcolumn('SELECT count(*) FROM '.tablename('orders').' o LEFT JOIN '.tablename('market').' m ON(o.market_id=m.id) WHERE '.$where.' o.add_time>=:start_time AND o.add_time<:end_time', [':start_time'=>$start_time, ':end_time'=>$end_time]);

    //所有
    $start_time = strtotime(date('Y-1-1 00:00:00'));
    $end_time = strtotime(date('Y-m-d 23:59:00'));
    $orderNum = pdo_fetchcolumn('SELECT count(*) FROM '.tablename('orders').' o LEFT JOIN '.tablename('market').' m ON(o.market_id=m.id) WHERE '.$where.' 1=1');


    template('main/right');
    exit();
}
$homePage = urlGo('main', 'index', array('do'=>'abc'));
template('main/index');