<?php
defined('IN_IA') or exit('Access Denied');
$do = $_GPC['do'];
$where = [];
$rwhere = '';
load()->classs('upload');
if( !Common::checkRoles($_W['user']['roles_id']) ){
    $rwhere .= " AND id='{$_W['user']['roles_id']}'";
    $where[] = "r.id='{$_W['user']['roles_id']}'";
}
$roles_list = pdo_fetchall('SELECT * FROM '.tablename('roles').' WHERE status=1 '.$rwhere.' ORDER BY id ASC');
if( $do == 'add'){
    $id = intval($_GPC['id']);

    if ( checksubmit('submit') ) {
        if( empty($_GPC['name']) ){
            message('请将数据输入完整！', '', 'error');
        }
        $data = [];
        $data['roles_id'] = $_GPC['roles_id'];
        $data['name'] = $_GPC['name'];
        $data['nickname'] = $_GPC['nickname'];
        $data['status'] = $_GPC['status'] == 1 ? 1 : 0;
        $data['is_front'] = $_GPC['is_front'] == 1 ? 1 : 0;
        if( !$_FILES['file']['error'] ){
            $upload = new upload($_FILES['file']);
            $upload->upload_files();
            $data['avatar'] = $upload->imgname;
        }
        if( $id ){
            if( $_GPC['passwd'] ){
                $data['salt'] = random(8);
                $data['passwd'] = user_hash($_GPC['passwd'], $data['salt']);
            }
            pdo_update('users', $data, array('id'=>$id));
        } else {
            if( empty($_GPC['passwd']) ){
                message('请输入登录密码！', '', 'error');
            }
            $data['salt'] = random(8);
            $data['passwd'] = user_hash($_GPC['passwd'], $data['salt']);
            $data['add_time'] = TIMESTAMP;
            pdo_insert('users', $data);
        }
        message('操作成功！', urlGo('user', 'index'), 'success');
    }

    $edit = [];
    if( $id ){
        $edit = pdo_fetch('SELECT * FROM '.tablename('users')." WHERE id=:id", [':id'=>$id]);
    }
    template('user/add');
    exit();
} elseif( $do == 'chg_status' ){
    $status = $_GPC['status'] == 1 ? 1 : 0;
    $id = intval($_GPC['id']);
    pdo_update('users', ['status'=>$status], array('id'=>$id));
    message('操作成功！', urlGo('user', 'index'), 'success');
}
//删除员工
if($do == 'del'){
    $id = intval($_GPC['id']);
    $res = pdo_delete('users',array('id'=>$id));
    if($res){
        message('操作成功！', urlGo('user', 'index'), 'success');
    }else{
        message('删除失败！', '', 'error');
    }
}
if( $_GPC['roles_id'] ){
    $where[] = " u.roles_id='{$_GPC['roles_id']}'";
}
if( $_GPC['keywords'] ){
    $where[] = " u.name LIKE '%{$_GPC['keywords']}%'";
}
if( $where ){
    $where = ' WHERE '.implode(' AND ', $where);
} else {
    $where = '';
}
$list = pdo_fetchall('SELECT u.*, r.name as roles_name FROM '.tablename('users').' u LEFT JOIN '.tablename('roles').' r ON u.roles_id=r.id '.$where.' ORDER BY u.id ASC');
template('user/index');