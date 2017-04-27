<?php
defined('IN_IA') or exit('Access Denied');
$hash = $_GPC['hash'];

$orders = pdo_fetch('SELECT o.*, m.title FROM '.tablename('orders')." o LEFT JOIN ".tablename('market')." m ON o.market_id=m.id WHERE o.hash=:hash", [':hash'=>$hash]);
template('form/success');