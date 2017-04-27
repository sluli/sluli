<?php
defined('IN_IA') or exit('Access Denied');
if( !Common::checkRoles($_W['user']['roles_id']) ){
    message('你没有权限操作此模块', urlGo('main', 'index', ['do'=>'abc']), 'error');
}
$do = $_GPC['do'];
$roles_list = pdo_fetchall('SELECT * FROM '.tablename('roles').' ORDER BY id ASC');
if ( checksubmit('submit') ) {
    if( empty($_GPC['domain']) ){
        message('请将数据输入完整！', '', 'error');
    }
    $data = [];
    $data['domain'] = $_GPC['domain'];
    $data['type'] = $_GPC['type'];
    $data['status'] = 1;
    $data['add_time'] = TIMESTAMP;
    pdo_insert('domain', $data);
    message('操作成功！', urlGo('domain'), 'success');
    exit();
}

if( $do == 'add'){

} elseif( $do == 'chg_status' ){
    $status = $_GPC['status'] == 1 ? 1 : 0;
    $id = intval($_GPC['id']);
    pdo_update('domain', ['status'=>$status], array('id'=>$id));
    message('操作成功！', urlGo('domain'), 'success');
}
elseif( $do == 'delete' ){
    $id = intval($_GPC['id']);
    pdo_delete('domain', array('id'=>$id));
    message('操作成功！', urlGo('domain'), 'success');
}
$list = pdo_fetchall('SELECT * FROM '.tablename('domain').' ORDER BY id ASC');
template('domain/list');