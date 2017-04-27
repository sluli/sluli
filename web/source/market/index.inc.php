<?php
defined('IN_IA') or exit('Access Denied');
$do = $_GPC['do'];
$rwhere = '';
if( !Common::checkRoles($_W['user']['roles_id']) ){
    $rwhere .= " AND find_in_set('{$_W['user']['roles_id']}', roles_id)";
}
$goods_list = pdo_fetchall('SELECT * FROM '.tablename('goods').' where status=1 '.$rwhere.' ORDER BY gid ASC');
if( $do == 'add'){
    $id = intval($_GPC['id']);

    if ( checksubmit('submit') ) {
        if( empty($_GPC['title']) || empty($_GPC['show_link']) || empty($_GPC['gid']) ){
            message('请将数据输入完整！', '', 'error');
        }
        $data = [];
        $data['title'] = $_GPC['title'];
        $data['intro'] = $_GPC['intro'];
        $data['gid'] = $_GPC['gid'];
        $data['show_link'] = $_GPC['show_link'];
        $data['status'] = $_GPC['status'] == 1 ? 1 : 0;
        $data['uid'] = $_W['uid'];
        $data['roles_id'] = $_W['user']['roles_id'];
        $data['keyword'] = $_GPC['keyword'];
        if( $id ){
            pdo_update('market', $data, array('id'=>$id));
        } else {
            $data['add_time'] = TIMESTAMP;
            pdo_insert('market', $data);
        }
        message('操作成功！', urlGo('market'), 'success');
    }
    $edit = [];
    if( $id ){
        $edit = pdo_fetch('SELECT * FROM '.tablename('market')." WHERE id=:id", [':id'=>$id]);
    }
    template('market/add');
    exit();
} elseif( $do == 'chg_status' ){
    $status = $_GPC['status'] == 1 ? 1 : 0;
    $id = intval($_GPC['id']);
    pdo_update('market', ['status'=>$status], array('id'=>$id));
    message('操作成功！', urlGo('market'), 'success');
}
if($do == 'del'){
    $id = intval($_GPC['id']);
    $res = pdo_delete('market',array('id'=>$id));
    if($res){
        message('操作成功！', urlGo('market'), 'success');
    }else{
        message('删除失败！', '', 'error');
    }
}
$where = ' WHERE 1 ';
$param = [];
//if( !$_W['isfounder'] ){
//    $where.=" AND m.uid=:uid";
//    $param[':uid'] = $_W['uid'];
//}

if( !$_W['isfounder'] ){
    $where.=" AND u.roles_id=:roles_id";
    $param[':roles_id'] = $_W['user']['roles_id'];
}

$domain = pdo_fetch('SELECT * FROM '.tablename('domain').' WHERE status=1 AND type=1');

$list = pdo_fetchall('SELECT m.*, g.name, u.name as username FROM '.tablename('market').' m LEFT JOIN '.tablename('goods').' g ON(m.gid=g.gid) LEFT JOIN '.tablename('users').' u ON(m.uid=u.id) '. $where.' ORDER BY m.id DESC', $param);
foreach ($list as &$row){
    $row['out_link'] = 'http://'.$domain['domain'].'/app/'.urlGo('main', 'show', ['id'=>$row['id'].'_'.$_W['uid']]);
}
template('market/list');