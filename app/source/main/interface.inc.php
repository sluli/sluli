<?php
defined('IN_IA') or exit('Access Denied');
error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);
header('Content-Type: text/html; charset=utf-8');
$appdir = dirname(__FILE__);

// 接口验证 token
$token = 'wechatsync';


if(W::isGET()){
    W::valid($token);
}

if(W::isPOST()){
    $post    = $GLOBALS["HTTP_RAW_POST_DATA"];
    $xml     = simplexml_load_string($post, 'SimpleXMLElement', LIBXML_NOCDATA);
    $content = trim($xml->Content);    // 获取消息内容
    $type    = strtolower($xml->MsgType);
    /***************************wordpress文章搜索 ****************************************************/
    $row = pdo_fetch('SELECT * FROM '.tablename('market').' WHERE keyword=:keyword', [':keyword'=>$content]);
    if( $row){
        $domains = Common::getDomains();
        $domain = array_pop($domains['main']);
        $link = "http://{$domain}/app/" .urlGo('main', 'show', ['id'=>$row['id'].'_'.$row['uid'], 'flag'=>1]);
        $data = "[玫瑰]欢迎关注我们！[玫瑰]\n
             同心同德，共创辉煌！\n
            下面是您的专用推广链接，请点击打开，然后收藏！\n
            重要提示：打开链接浏览30秒钟后再收藏！\n
            <a href=\"{$link}\">{$row['title']}</a>\n
            如需重新获取，请回复 {$row['keyword']}";
    } else {
        $data = "没找到";
    }
    exit(W::response($xml, $data));
}


class w {
    static function valid($token) {
        $echoStr = $_GET["echostr"];
        if(self::signature($token)){
            exit($echoStr);
        }
        return false;
    }

    static function signature($token){
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce     = $_GET["nonce"];
        $tmpArr    = array($token, $timestamp, $nonce);
        sort($tmpArr);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);
        if($tmpStr == $signature){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 响应请求
     */
    static function response($xml, $data, $type = 'text') {
        $time = time();
        $xmltpl['text']  = '<xml><ToUserName><![CDATA[%s]]></ToUserName><FromUserName><![CDATA[%s]]></FromUserName>';
        $xmltpl['text'] .= '<CreateTime>%s</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA[%s]]></Content><FuncFlag>0</FuncFlag></xml>';
        $xmltpl['item']  = '<item><Title><![CDATA[%s]]></Title><Description><![CDATA[%s]]></Description><PicUrl><![CDATA[%s]]></PicUrl><Url><![CDATA[%s]]></Url></item>';
        $xmltpl['news']  = '<xml><ToUserName><![CDATA[%s]]></ToUserName><FromUserName><![CDATA[%s]]></FromUserName><CreateTime>%s</CreateTime><MsgType><![CDATA[news]]></MsgType>';
        $xmltpl['news'] .= '<ArticleCount>%s</ArticleCount><Articles>%s</Articles><FuncFlag>1</FuncFlag></xml>';
        if($type == 'text'){
            return sprintf($xmltpl['text'], $xml->FromUserName, $xml->ToUserName, $time, $data);
        }elseif($type == 'news'){
            if(is_array($data)){
                $items = '';
                if(count($data) > 1){
                    foreach($data as $e){
                        $title = trim($e['title'] . "\n" . $e['note'], "\n");
                        $items .= sprintf($xmltpl['item'], $title, '', $e['cover'], $e['link']);
                    }
                }elseif(count($data) == 1){
                    foreach($data as $e){
                        $items = sprintf($xmltpl['item'], $e['title'], $e['note'], $e['cover'], $e['link']);
                    }
                }else{
                    return self::response($xml, '没有数据');
                }
                return sprintf($xmltpl['news'], $xml->FromUserName, $xml->ToUserName, $time, count($data), $items);
            }
            return self::response($xml, '没有数据');
        }
        return self::response($xml, '类型不正确');
    }

    /**
     * 已知两点的经纬度，计算两点间的距离(公里)
     */
    static function getDistance($lat1, $lng1, $lat2, $lng2){
        $lat1 = (double)$lat1;
        $lat2 = (double)$lat2;
        $lng1 = (double)$lng1;
        $lng2 = (double)$lng2;
        $EARTH_RADIUS = 6378.137;
        $radLat1 = $lat1 * pi() / 180.0;
        $radLat2 = $lat2 * pi() / 180.0;
        $a = $radLat1 - $radLat2;
        $b = $lng1 * pi() / 180.0 - $lng2 * pi() / 180.0;
        $s = 2 * asin(sqrt(pow(sin($a/2),2) +
                cos($radLat1)*cos($radLat2)*pow(sin($b/2),2)));
        $s = $s * $EARTH_RADIUS;
        $s = round($s * 10000) / 10000;
        return number_format($s, 2, '.', '');
    }

    static function requestMethod() {
        return $_SERVER['REQUEST_METHOD'];
    }

    static function isGET() {
        return self::requestMethod() == 'GET';
    }

    static function isPOST() {
        return self::requestMethod() == 'POST';
    }

    /**
     * POST 请求指定URL
     */
    static function fpost($url, $post = '', $limit = 0, $cookie = '', $ip = '', $timeout = 15, $block = TRUE) {
        $return = '';
        $matches = parse_url($url);
        !isset($matches['host']) && $matches['host'] = '';
        !isset($matches['path']) && $matches['path'] = '';
        !isset($matches['query']) && $matches['query'] = '';
        !isset($matches['port']) && $matches['port'] = '';
        $host = $matches['host'];
        $path = $matches['path'] ? $matches['path'].($matches['query'] ? '?'.$matches['query'] : '') : '/';
        $port = !empty($matches['port']) ? $matches['port'] : 80;
        if($post) {
            $out = "POST $path HTTP/1.0\r\n";
            $out .= "Accept: */*\r\n";
            $out .= "Accept-Language: zh-cn\r\n";
            $out .= "Content-Type: application/x-www-form-urlencoded\r\n";
            $out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
            $out .= "Host: $host\r\n";
            $out .= 'Content-Length: '.strlen($post)."\r\n";
            $out .= "Connection: Close\r\n";
            $out .= "Cache-Control: no-cache\r\n";
            $out .= "Cookie: $cookie\r\n\r\n";
            $out .= $post;
        } else {
            $out = "GET $path HTTP/1.0\r\n";
            $out .= "Accept: */*\r\n";
            $out .= "Accept-Language: zh-cn\r\n";
            $out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
            $out .= "Host: $host\r\n";
            $out .= "Connection: Close\r\n";
            $out .= "Cookie: $cookie\r\n\r\n";
        }

        if(function_exists('fsockopen')) {
            $fp = @fsockopen(($ip ? $ip : $host), $port, $errno, $errstr, $timeout);
        } elseif (function_exists('pfsockopen')) {
            $fp = @pfsockopen(($ip ? $ip : $host), $port, $errno, $errstr, $timeout);
        } else {
            $fp = false;
        }

        if(!$fp) {
            return '';
        } else {
            stream_set_blocking($fp, $block);
            stream_set_timeout($fp, $timeout);
            @fwrite($fp, $out);
            $status = stream_get_meta_data($fp);
            if(!$status['timed_out']) {
                while (!feof($fp)) {
                    if(($header = @fgets($fp)) && ($header == "\r\n" ||  $header == "\n")) {
                        break;
                    }
                }

                $stop = false;
                while(!feof($fp) && !$stop) {
                    $data = fread($fp, ($limit == 0 || $limit > 8192 ? 8192 : $limit));
                    $return .= $data;
                    if($limit) {
                        $limit -= strlen($data);
                        $stop = $limit <= 0;
                    }
                }
            }
            @fclose($fp);
            return $return;
        }
    }

}