<?php
defined('IN_IA') or exit('Access Denied');
load()->classs('upload');
$do = $_GPC['do'];
$where = [];
$rwhere = '';
if( !Common::checkRoles($_W['user']['roles_id']) ){
    $rwhere .= " AND id='{$_W['user']['roles_id']}'";
}
$roles_list = pdo_fetchall('SELECT * FROM '.tablename('roles').' WHERE status=1 '.$rwhere.' ORDER BY id ASC');
if( $do == 'add'){
    $gid = intval($_GPC['gid']);

    if ( checksubmit('submit') ) {
        if( empty($_GPC['name']) || empty($_GPC['price']) ){
            message('请将数据输入完整！', '', 'error');
        }
        $data = [];
        $data['name'] = $_GPC['name'];
        $data['price'] = floatval($_GPC['price']);
        $data['status'] = $_GPC['status'] == 1 ? 1 : 0;
        $data['content'] = isset($_GPC['content']) ? $_GPC['content'] : '';
        $data['formats'] = $_GPC['formats'];
        $data['size'] = $_GPC['size'];
        $data['roles_id'] = implode(',',$_GPC['roles_id']);
        if( !$_FILES['thumb']['error'] ){
            $upload = new upload($_FILES['thumb']);
            $upload->upload_files();
            $data['thumb'] = $upload->imgname;
        }
        if( $gid ){
            pdo_update('goods', $data, array('gid'=>$gid));
        } else {
            $data['add_time'] = TIMESTAMP;
            pdo_insert('goods', $data);
        }
        message('操作成功！', urlGo('goods'), 'success');
    }
    $edit = [];
    if( $gid ){
        $edit = pdo_fetch('SELECT * FROM '.tablename('goods')." WHERE gid=:gid", [':gid'=>$gid]);
    }
    template('goods/add');
    exit();
} elseif( $do == 'chg_status' ){
    $status = $_GPC['status'] == 1 ? 1 : 0;
    $gid = intval($_GPC['gid']);
    pdo_update('goods', ['status'=>$status], array('gid'=>$gid));
    message('操作成功！', urlGo('goods'), 'success');
}
if($do == 'del'){
    $gid = intval($_GPC['gid']);
    $market = pdo_fetch('SELECT title FROM '.tablename('market')." WHERE gid=:gid", [':gid'=>$gid]);
    if($market){
        message('该商品使用于推广《'.$market['title'].'》，请先删除推广内容再删除商品！', '', 'error');
    }
    $res = pdo_delete('goods',array('gid'=>$gid));
    if($res){
        message('操作成功！', urlGo('goods'), 'success');
    }else{
        message('删除失败！', '', 'error');
    }
}
$where = ' WHERE 1 ';
$param = [];
if( !$_W['isfounder'] ){
    $where.=" AND  FIND_IN_SET(:roles_id,roles_id)";
    $param[':roles_id'] = $_W['user']['roles_id'];
}
$list = pdo_fetchall('SELECT * FROM '.tablename('goods').' '.$where.' ORDER BY gid ASC', $param);
template('goods/list');