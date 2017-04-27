<?php
defined('IN_IA') or exit('Access Denied');
$act = $_GPC['act'];

if($act == 'commit'){
    template('form/jubao2');
    exit();
}
if($act == 'result'){
    template('form/jubao3');
    exit();
}
template('form/jubao');