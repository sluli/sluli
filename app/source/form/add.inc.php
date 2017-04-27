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
$is_assist = 0;
if($_POST['m_id']){
    if($_POST['m_id'] == -1){
        echo json_encode(['code'=>0, 'message'=>'请选择推广内容！']);
        exit();
    }
    $id = $_POST['m_id'];
    $uid = $_W['uid'];
    $is_assist = 1;//协助下单标记
}else{
    list($id, $uid) = explode('_', $_GPC['id']);
}
//获取推广列表
$m_list = pdo_fetchall('SELECT id,title FROM '.tablename('market').' WHERE roles_id=:roles_id and status=1 ORDER BY id DESC', [':roles_id'=>$_W['user']['roles_id']]);
array_unshift($m_list,array('id'=>-1,'title'=>'--请选择推广内容--'));
$market = pdo_fetch('SELECT m.*,g.content,g.price,g.formats,g.size FROM '.tablename('market')." m LEFT JOIN ".tablename('goods')." g ON g.gid=m.gid WHERE m.id=:id", [':id'=>$id]);
$market['content'] = htmlspecialchars_decode($market['content']);
$market_list = [];
if( empty($market) ){
    $market_list = pdo_fetchall('SELECT * FROM '.tablename('market')." WHERE roles_id=:roles_id", [':roles_id'=>$_W['user']['roles_id']]);
} else {
    $market['content'] = htmlspecialchars_decode($market['content']);
    $market['formats'] = $market['formats'] ? explode(',', $market['formats']) : [];
    $market['size'] = $market['size'] ? explode(',', $market['size']) : [];
}
//获取评论列表
$commentlist = pdo_fetchall('SELECT * FROM '.tablename('comment').' WHERE market_id=:market_id and status=1 ORDER BY id DESC', [':market_id'=>$id]);
$openid = $_GPC['openid'];
/* $row = pdo_fetch('SELECT count(*) as num FROM '.tablename('orders')." WHERE market_id = :market_id AND openid=:openid", [':market_id'=>$market['id'], ':openid'=>$openid]);
if( !empty($row) && $row['num']>=2 ){
    header('Location:'.urlGo('order','delivery'));
    exit();
} */
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
    $submit_data['is_assist'] = $is_assist;
    //$citys = get_city( $submit_data['ip'] );
    $citys = Common::getMobileCity($submit_data['mobile']);
    $submit_data['dubious'] = check_city($citys['province'], $submit_data['province']) >=70 ? 0 : 1;
    $submit_data['sjprovince'] = $citys['province'];
    $submit_data['hash'] = md5(TIMESTAMP.$submit_data['mobile']);
    
    //限制每个月下单两次---验证(name、mobile、province、city)
    $stime = time() - 3600*24*30;
    $where = ' WHERE 1 ';
    $param = [];
    $where.=" AND name=:name AND mobile=:mobile AND province=:province AND city=:city AND add_time>=:addtime";
    $param[':name'] = $submit_data['name'];
    $param[':mobile'] = $submit_data['mobile'];
    $param[':province'] = $submit_data['province'];
    $param[':city'] = $submit_data['city'];
    $param[':addtime'] = $stime;
    $res = pdo_fetchall('select oid,name from '.tablename('orders').$where,$param);
    if(count($res)>=2){
        echo json_encode(['code'=>0, 'message'=>'您的下单已经达到上限']);exit();
    }
    $oid = pdo_insert('orders', $submit_data);
    echo json_encode(['code'=>1, 'message'=>'操作成功！', 'hash'=>$submit_data['hash']]);
    //header('Location:'.urlGo('form', 'result'));
    exit();
}
$endtime = $market['endtime']*1000;
$head_title = $market['title'];
template('form/add');