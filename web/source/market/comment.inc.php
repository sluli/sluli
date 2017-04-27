<?php
defined('IN_IA') or exit('Access Denied');
$do = $_GPC['do'];
$market_id = $_GPC['market_id'];
if($do == "add"){  
    $id = intval($_GPC['id']);
    if ( checksubmit('submit') ) {
        if( empty($_GPC['username']) || empty($_GPC['phone']) || empty($_GPC['content']) ){
            message('请将数据输入完整！', '', 'error');
        }
        $data = [];
        $data['username'] = $_GPC['username'];
        $data['content'] = $_GPC['content'];
        $data['address'] = $_GPC['address'];      
        $data['phone'] = $_GPC['phone'];
        if( $id ){
            pdo_update('comment', $data, array('id'=>$id));
        } else {
            $data['market_id'] = $market_id;
            $data['addtime'] = TIMESTAMP;
            pdo_insert('comment', $data);
        }
        message('操作成功！', urlGo('market','comment',array('market_id'=>$market_id)), 'success');
    }
    $edit = [];
    if( $id ){
        $edit = pdo_fetch('SELECT * FROM '.tablename('comment')." WHERE id=:id", [':id'=>$id]);
    }
    template('market/addcomment');
    exit();
}
if($do == "del"){
    $id = intval($_GPC['id']);
    pdo_delete('comment',array('id'=>$id));
    message('操作成功！', urlGo('market','comment',array('market_id'=>$market_id)), 'success');
}
$list = pdo_fetchall('SELECT * FROM '.tablename('comment').' where market_id=:market_id ORDER BY addtime ASC',[':market_id'=>$market_id]);

template('market/commentlist');