<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/5
 * Time: 14:51
 */
class Common
{
    /**
     * 产生随机数
     */
    public static function random($length, $numeric = 0)
    {
        PHP_VERSION < '4.2.0' ? mt_srand((double)microtime() * 1000000) : mt_srand();
        $seed = base_convert(md5(print_r($_SERVER, 1) . microtime()), 16, $numeric ? 10 :
            35);
        $seed = $numeric ? (str_replace('0', '', $seed) . '012340567890') : ($seed .
            'zZ' . strtoupper($seed));
        $hash = '';
        $max = strlen($seed) - 1;
        for ($i = 0; $i < $length; $i++) {
            $hash .= $seed[mt_rand(0, $max)];
        }
        return $hash;
    }

    public static function checkLogin(){
        global $_W;
        if( empty($_W['uid']) ){
            switch ( $_W['page_mark'] ){
                case 'main-login':
                case 'main-show':
                case 'main-share':
                case 'main-interface':
                case 'form-add':
                case 'form-result':
                case 'form-jubao':
                case 'order-delivery':
                case 'delivery-index':
                    break;
                default:

                    header( 'Location:'.urlGo('main', 'login') );
                    exit();
            }
        }

    }

    public static function checkRoles( $roles_id ){
        if( $roles_id == 1 ){
            return true;
        }
        return false;
    }

    public static function printJson( $data ){
        global $_GPC;
        if( $_GPC['debug'] ){
            echo '<pre>';
            print_r($data);
            die();
        }
        echo json_encode( $data );
        die();
    }
    public static function is_weixin(){
        if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
            return true;
        }
        return false;
    }

    public static function getDomains(){
        $results = pdo_fetchall('SELECT * FROM '.tablename('domain').' WHERE status=1');
        $domainMain = $domainTest = [];
        foreach ($results as $row){
            if( $row['type'] ){
                $domainMain[] = $row['domain'];
            } else {
                $domainTest[] = $row['domain'];
            }
        }
        shuffle($domainTest);
        shuffle($domainMain);
        return ['main'=>$domainMain, 'test'=>$domainTest];
    }

    public static function getMobileCity($mobile){
        $content = file_get_contents("http://sj.apidata.cn/?mobile={$mobile}");
        $content = json_decode($content, true);
        return isset($content['data']) ? $content['data'] : [];
    }

}