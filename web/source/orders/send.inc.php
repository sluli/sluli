<?php
defined('IN_IA') or exit('Access Denied');
load()->classs('excel');
if( checksubmit() ){

    if( isset($_FILES['file']) && $_FILES['file']['error']==0 ){
        $xls_data = excel::xlsToArray( $_FILES['file']['tmp_name'] );
        #print_r($_FILES['file']);exit;
	foreach ($xls_data as $row){
            if( !empty($row['系统单号']) && !empty($row['快递公司']) && !empty($row['快递单号']) ){
               $res = pdo_update('orders', ['delivery'=>$row['快递公司'], 'delivery_code'=>$row['快递单号'],'status'=>2], ['oid'=>$row['系统单号']]);
            }
        }
        message('操作成功');
    } else {
        message('上传文件失败', '', 'error');
    }
    exit();
}

template('orders/send');
