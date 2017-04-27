<?php
defined('IN_IA') or exit('Access Denied');
$do = $_GPC['do'];
if( checksubmit('submit') && $_GPC['infos'] ){
    $info = pdo_fetch('SELECT * FROM '.tablename('orders')." WHERE name=:name OR mobile=:mobile", [':name'=>$_GPC['infos'], ':mobile'=>$_GPC['infos']]);
    if( empty($info) ){
        message('没有找到对应订单', '', 'error');
    }
    if( empty($info['delivery_code']) ){
        message('此订单还没有物流单号号', '', 'error');
    }
    $url = "http://m.kuaidi100.com/index_all.html?type={$info['delivery_code']}&postid={$info['delivery_code']}#result";
    header('Location:'.$url);
    exit();
}
$homePage = urlGo('main', 'index', array('do'=>'abc'));
template('order/delivery');