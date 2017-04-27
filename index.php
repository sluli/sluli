<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/2/24
 * Time: 13:36
 */
include_once dirname(__FILE__).'/framework/bootstrap.inc.php';
if($_W['os'] == 'mobile' && (!empty($_GPC['i']) || !empty($_SERVER['QUERY_STRING']))) {
    header('Location: ./app/index.php?' . $_SERVER['QUERY_STRING']);
} else {
    header('Location: ./web/index.php?' . $_SERVER['QUERY_STRING']);
}
exit();
