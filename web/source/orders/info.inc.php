<?php
defined('IN_IA') or exit('Access Denied');
$oid = $_GPC['oid'];
$orders = pdo_fetch('SELECT * FROM '.tablename('orders')." WHERE oid=:oid", [':oid'=>$oid]);
if( empty($orders) ){
    message('参数错误');
}
$market = pdo_fetch('SELECT * FROM '.tablename('market')." WHERE id=:id", [':id'=>$orders['market_id']]);
$goods = pdo_fetch('SELECT * FROM '.tablename('goods')." WHERE gid=:id", [':id'=>$orders['gid']]);

if( checksubmit() ){
    if( empty($market) ){
        exit('fail');
    }
    $submit_data = $_GPC['submit_data'];
    pdo_update('orders', $submit_data, ['oid'=>$orders['oid']]);
    message('编辑成功', urlGo('orders', 'index'));
    exit();
}

template('orders/info');