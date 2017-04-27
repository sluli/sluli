<?php
defined('IN_IA') or exit('Access Denied');
if( $_GPC['act'] == 'getmarket'){
    $id = $_GPC['id'];
    $market = pdo_fetch('SELECT m.id,g.price FROM '.tablename('market')." m LEFT JOIN ".tablename('goods')." g ON g.gid=m.gid WHERE m.id=:id", [':id'=>$id]);
    echo json_encode($market);exit();
}
if($_GPC['act'] == 'setTime'){
    $id = $_GPC['id'];
    $htime = time()+3600*3;
    $res = pdo_update('market', array('endtime'=>$htime), array('id'=>$id));
    if($res){
        $re['data'] = $htime*1000;
        $re['status'] = 1;
    }else{
        $re['status'] = 0;
    }
    echo json_encode($re);
    exit();
}