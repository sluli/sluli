<?php
defined('IN_IA') or exit('Access Denied');
load()->classs('excel');
$do = $_GPC['do'];

if( !Common::checkRoles($_W['user']['roles_id']) ){
    $rwhere .= " AND id='{$_W['user']['roles_id']}'";
    $where[] = "r.id='{$_W['user']['roles_id']}'";
}
$roles_list = pdo_fetchall('SELECT * FROM '.tablename('roles').' WHERE status=1 '.$rwhere.' ORDER BY id ASC');

$goods_list = pdo_fetchall('SELECT * FROM '.tablename('goods').' where roles_id=:roles_id ORDER BY gid ASC', [':roles_id'=>$_W['user']['roles_id']]);
if( $do == 'add'){

} elseif( $do == 'chg_status' ){
    $status = intval($_GPC['status']);
    $oid = intval($_GPC['oid']);
    pdo_update('orders', ['status'=>$status], array('oid'=>$oid));
    message('操作成功！', urlGo('orders'), 'success');
}
$where = ' WHERE 1 ';
$param = [];
if( !$_W['isfounder'] ){
    $where.=" AND u.roles_id=:roles_id";
    $param[':roles_id'] = $_W['user']['roles_id'];
} else {
    if( $_GPC['roles_id'] ){
        $where.=" AND u.roles_id=:roles_id";
        $param[':roles_id'] = $_GPC['roles_id'];
    }
}

if( $_GPC['oid'] ){
    $where.=" AND o.oid=:oid";
    $param[':oid'] = $_GPC['oid'];
}

if( $_GPC['gid'] ){
    $where.=" AND o.gid=:gid";
    $param[':gid'] = $_GPC['gid'];
}

if( $_GPC['name'] ){
    $where.=" AND o.name=:name";
    $param[':name'] = $_GPC['name'];
}

if( $_GPC['mobile'] ){
    $where.=" AND o.mobile=:mobile";
    $param[':mobile'] = $_GPC['mobile'];
}

if( $_GPC['delivery_code'] ){
    $where.=" AND o.delivery_code=:delivery_code";
    $param[':delivery_code'] = $_GPC['delivery_code'];
}
if( $_GPC['start_time'] ){
    $where.=" AND o.add_time>=:start_time";
    $param[':start_time'] = strtotime($_GPC['start_time']);
}
if( $_GPC['end_time'] ){
    $where.=" AND o.add_time<=:end_time";
    $param[':end_time'] = strtotime($_GPC['end_time'].' 23:59:59');
}
switch ( intval($_GPC['status']) ){
    case 1:
        $where.=" AND o.dubious=1";
        break;
    case 2:
    case 3:
    case 4:
    case 5:
        $where.=" AND o.status=".$_GPC['status']-2;
        break;
}

$list = pdo_fetchall('SELECT o.*, g.name AS goods_name, g.price, u.name as sale_name, r.name as roles_name FROM '.tablename('orders').' o LEFT JOIN '.tablename('goods').' g ON(o.gid=g.gid) LEFT JOIN '.tablename('users').' u ON(o.uid=u.id)  LEFT JOIN '.tablename('roles').' r ON(u.roles_id=r.id) '. $where.' ORDER BY o.oid DESC', $param);
//var_dump($list);
if( $_GPC['export'] ){
    $xlsData = [];
    $xlsData[] = ['系统单号','姓名','详细收货地址','手机号','是否同意发货','代收金额','业务员','时间','产品','款式','尺寸','是否异常'];
    foreach ($list as $row) {
        $xlsData[] = [
            $row['oid'],
            $row['name'],
            $row['province'] . $row['city'] . $row['district'] . $row['address'] ,
            $row['mobile'],
            $row['is_send'] ? '同意' : '不同意',
            $row['price'],
            $row['sale_name'],
            date('Y-m-d H:i:s', $row['add_time']),
            $row['goods_name'],
            $row['formats'],
            $row['size'],
            $row['dubious'] ? '异常' : ''
        ];
    }
    excel::arrayToXls( $xlsData, date('Y-m-d'));
    exit();
}
template('orders/list');