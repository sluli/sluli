<?php
defined('IN_IA') or exit('Access Denied');
if( !Common::checkRoles($_W['user']['roles_id']) ){
    message('你没有权限操作此模块', urlGo('main', 'index', ['do'=>'abc']), 'error');
}
$do = $_GPC['do'];
if( $do == 'add'){
    $id = intval($_GPC['id']);
    if ( checksubmit('submit') ) {
        if( empty($_GPC['name']) ){
            message('请将数据输入完整！', '', 'error');
        }
        $data = [];
        $data['name'] = $_GPC['name'];
        $data['status'] = $_GPC['status'] == 1 ? 1 : 0;
        $data['acls'] = json_encode($_GPC['acls']);
        if( $id ){
            pdo_update('roles', $data, array('id'=>$id));
        } else {
            $data['add_time'] = TIMESTAMP;
            pdo_insert('roles', $data);
        }
        message('操作成功！', urlGo('user', 'roles'), 'success');
    }
    $edit = [];
    if( $id ){
        $edit = pdo_fetch('SELECT * FROM '.tablename('roles')." WHERE id=:id", [':id'=>$id]);
    }
    template('user/roles_add');
    exit();
} elseif( $do == 'chg_status' ){
    $status = $_GPC['status'] == 1 ? 1 : 0;
    $id = intval($_GPC['id']);
    pdo_update('roles', ['status'=>$status], array('id'=>$id));
    message('操作成功！', urlGo('user', 'roles'), 'success');
}
$list = pdo_fetchall('SELECT * FROM '.tablename('roles').' ORDER BY id ASC');
template('user/roles');