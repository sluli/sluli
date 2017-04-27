<?php
defined('IN_IA') or exit('Access Denied');
$act = $_GPC['act'];
if( $act == 'cancel'){
    pdo_delete('orders', ['oid'=>$_GPC['oid'], 'dubious'=>1, 'uid'=>$_W['uid']]);

    message('操作成功', urlGo('order', 'index', ['dubious'=>1]));
    exit();
}
$dubious = $_GPC['dubious'] == 1 ? 1 : 0;
//所有推广
$order_list = pdo_fetchall('SELECT o.*, g.name AS goods_name, g.price FROM '.tablename('orders').'o LEFT JOIN '.tablename('goods').' g ON o.gid=g.gid WHERE o.uid=:uid AND o.dubious=:dubious ORDER BY o.oid DESC', [':uid'=>$_W['uid'],':dubious'=>$dubious]);

template('order/list');