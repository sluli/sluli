<?php
defined('IN_IA') or exit('Access Denied');
if( $_GPC['act'] == 'sendcode'){
    //发送短信
    $mobile = $_GPC['mobile'];
    if( $mobile ){
        $code = Common::random(6,1);
        $data = ['code'=>$code, 'mobile'=>$mobile, 'add_time'=>TIMESTAMP];
        pdo_insert('smscode', $data, true);
        $url = "{$_W['config']['setting']['sms_server']}&msg=".urlencode("你的短信验证码为:{$code}");
    }
    echo json_encode(['code'=>1, 'message'=>'短信验证码已发送！']);
    exit();
}
list($id, $uid) = explode('_', $_GPC['id']);

$market = pdo_fetch('SELECT m.*,g.content,g.price FROM '.tablename('market')." m LEFT JOIN ".tablename('goods')." g ON g.gid=m.gid WHERE m.id=:id", [':id'=>$id]);
$market['content'] = htmlspecialchars_decode($market['content']);
$market_list = [];
if( empty($market) ){
    $market_list = pdo_fetchall('SELECT * FROM '.tablename('market')." WHERE roles_id=:roles_id", [':roles_id'=>$_W['user']['roles_id']]);
}

if( checksubmit() ){
    if( empty($market) ){
        exit('fail');
    }
    if( $_W['config']['setting']['smscode']){
        $code = $_GPC['code'];
        $sms = pdo_fetch('SELECT * FROM '.tablename('smscode')." WHERE mobile=:mobile", [':mobile'=>$_GPC['submit_data']['mobile']]);
        if( empty($sms) || $sms['code']!=$code || TIMESTAMP - $sms['add_time'] > 600 ){
            echo json_encode(['code'=>0, 'message'=>'短信验证码错误！']);
            exit();
        }
    }
    $submit_data = $_GPC['submit_data'];
    $submit_data['market_id'] = $market['id'];
    $submit_data['gid'] = $market['gid'];
    $submit_data['add_time'] = TIMESTAMP;
    $submit_data['ip'] = getip();
    $submit_data['status'] = 1;
    $submit_data['uid'] = $uid ? $uid : $market['uid'];
    //$citys = get_city( $submit_data['ip'] );
    $citys = Common::getMobileCity($submit_data['mobile']);
    $submit_data['dubious'] = check_city($citys['province'], $submit_data['province']) >=70 ? 0 : 1;
    $submit_data['sjprovince'] = $citys['province'];
    $submit_data['hash'] = md5(TIMESTAMP.$submit_data['mobile']);
    $oid = pdo_insert('orders', $submit_data);
    echo json_encode(['code'=>1, 'message'=>'操作成功！', 'hash'=>$submit_data['hash']]);
    //header('Location:'.urlGo('form', 'result'));
    exit();
}
$head_title = $market['title'];
template('form/add');
