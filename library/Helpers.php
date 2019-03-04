<?php

function cutstr($string, $length, $dot = ' ...') {
	if (strlen($string) <= $length) {
		return $string;
	}

	$pre = chr(1);
	$end = chr(1);
	$string = str_replace(array('&amp;', '&quot;', '&lt;', '&gt;'), array($pre . '&' . $end, $pre . '"' . $end, $pre . '<' . $end, $pre . '>' . $end), $string);

	$strcut = '';
	if (strtolower(CHARSET) == 'utf-8') {

		$n = $tn = $noc = 0;
		while ($n < strlen($string)) {

			$t = ord($string[$n]);
			if ($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
				$tn = 1;
				$n++;
				$noc++;
			} elseif (194 <= $t && $t <= 223) {
				$tn = 2;
				$n += 2;
				$noc += 2;
			} elseif (224 <= $t && $t <= 239) {
				$tn = 3;
				$n += 3;
				$noc += 2;
			} elseif (240 <= $t && $t <= 247) {
				$tn = 4;
				$n += 4;
				$noc += 2;
			} elseif (248 <= $t && $t <= 251) {
				$tn = 5;
				$n += 5;
				$noc += 2;
			} elseif ($t == 252 || $t == 253) {
				$tn = 6;
				$n += 6;
				$noc += 2;
			} else {
				$n++;
			}

			if ($noc >= $length) {
				break;
			}

		}
		if ($noc > $length) {
			$n -= $tn;
		}

		$strcut = substr($string, 0, $n);

	} else {
		$_length = $length - 1;
		for ($i = 0; $i < $length; $i++) {
			if (ord($string[$i]) <= 127) {
				$strcut .= $string[$i];
			} else if ($i < $_length) {
				$strcut .= $string[$i] . $string[++$i];
			}
		}
	}

	$strcut = str_replace(array($pre . '&' . $end, $pre . '"' . $end, $pre . '<' . $end, $pre . '>' . $end), array('&amp;', '&quot;', '&lt;', '&gt;'), $strcut);

	$pos = strrpos($strcut, chr(1));

	if ($pos !== false) {
		$strcut = substr($strcut, 0, $pos);
	}
	return $strcut . $dot;
}

function create_guidq() {
	$charid = md5(uniqid(mt_rand(), true));
	$hyphen = chr(45);
	$uuid = substr($charid, 0, 8) . $hyphen
	. substr($charid, 8, 4) . $hyphen
	. substr($charid, 12, 4) . $hyphen
	. substr($charid, 16, 4) . $hyphen
	. substr($charid, 20, 12);
	return $uuid;
}

function count_file_lines($filepath) {
	$fp = fopen($filepath, "r");
	$line = 0;
	while (fgets($fp)) {
		$line++;
	}

	fclose($fp);
	return $line;
}

function deep_addslashes($string, $force = 1) {
	if (is_array($string)) {
		$keys = array_keys($string);
		foreach ($keys as $key) {
			$val = $string[$key];
			unset($string[$key]);
			$string[addslashes($key)] = daddslashes($val, $force);
		}
	} else {
		$string = addslashes($string);
	}
	return $string;
}

function debug($var = null) {
	if ($var === null) {
		$var = $GLOBALS;
	}
	dump_r($var);
	exit();
}

function dfopen($url, $limit = 0, $post = '', $cookie = '', $bysocket = FALSE, $ip = '', $timeout = 15, $block = TRUE) {
	$return = '';
	$matches = parse_url($url);
	$host = $matches['host'];
	$path = $matches['path'] ? $matches['path'] . ($matches['query'] ? '?' . $matches['query'] : '') : '/';
	$port = !empty($matches['port']) ? $matches['port'] : 80;

	if ($post) {
		$out = "POST $path HTTP/1.0\r\n";
		$out .= "Accept: */*\r\n";
		//$out .= "Referer: $boardurl\r\n";
		$out .= "Accept-Language: zh-cn\r\n";
		$out .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
		$out .= "Host: $host\r\n";
		$out .= 'Content-Length: ' . strlen($post) . "\r\n";
		$out .= "Connection: Close\r\n";
		$out .= "Cache-Control: no-cache\r\n";
		$out .= "Cookie: $cookie\r\n\r\n";
		$out .= $post;
	} else {
		$out = "GET $path HTTP/1.0\r\n";
		$out .= "Accept: */*\r\n";
		//$out .= "Referer: $boardurl\r\n";
		$out .= "Accept-Language: zh-cn\r\n";
		$out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
		$out .= "Host: $host\r\n";
		$out .= "Connection: Close\r\n";
		$out .= "Cookie: $cookie\r\n\r\n";
	}
	$fp = @fsockopen(($ip ? $ip : $host), $port, $errno, $errstr, $timeout);
	if (!$fp) {
		return '';
	} else {
		stream_set_blocking($fp, $block);
		stream_set_timeout($fp, $timeout);
		@fwrite($fp, $out);
		$status = stream_get_meta_data($fp);
		if (!$status['timed_out']) {
			while (!feof($fp)) {
				if (($header = @fgets($fp)) && ($header == "\r\n" || $header == "\n")) {
					break;
				}
			}

			$stop = false;
			while (!feof($fp) && !$stop) {
				$data = fread($fp, ($limit == 0 || $limit > 8192 ? 8192 : $limit));
				$return .= $data;
				if ($limit) {
					$limit -= strlen($data);
					$stop = $limit <= 0;
				}
			}
		}
		@fclose($fp);
		return $return;
	}
}

function download_file($file, $filename = "") {
	$downfilename = $filename ?: basename($file);
	if (file_exists($file)) {
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename=' . $downfilename);
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		header('Content-Length: ' . filesize($file));
		ob_clean();
		flush();
		readfile($file);
		exit;
	}
}

function dhtmlspecialchars($string) {
	if (is_array($string)) {
		foreach ($string as $key => $val) {
			$string[$key] = dhtmlspecialchars($val);
		}
	} else {
		$string = preg_replace('/&amp;((#(\d{3,5}|x[a-fA-F0-9]{4}));)/', '&\\1',
			//$string = preg_replace('/&amp;((#(\d{3,5}|x[a-fA-F0-9]{4})|[a-zA-Z][a-z0-9]{2,5});)/', '&\\1',
			str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $string));
	}
	return $string;
}

function gen_random_string($length = 32) {
	if (file_exists('/dev/urandom')) {
		$randomData = file_get_contents('/dev/urandom', false, null, 0, 100) . uniqid(mt_rand(), true);
	} else {
		$randomData = mt_rand() . mt_rand() . mt_rand() . mt_rand() . microtime(true) . uniqid(mt_rand(), true);
	}
	return substr(hash('sha512', $randomData), 0, $length);
}

function get_remote_file_size($url) //远程获取文件长度 By YEE
{
	$url = parse_url($url);
	if ($fp = @dfopen($url['host'], empty($url['port']) ? 80 : $url['port'], $error)) {
		fputs($fp, "GET " . (empty($url['path']) ? '/' : $url['path']) . " HTTP/1.1\r\n");
		fputs($fp, "Host:$url[host]\r\n\r\n");
		while (!feof($fp)) {
			$tmp = fgets($fp);
			if (trim($tmp) == '') {
				break;
			} else if (preg_match('/Content-Length:(.*)/si', $tmp, $arr)) {
				return trim($arr[1]);
			}
		}
		return FALSE;
	} else {
		return FALSE;
	}
}

function microtime_float() {
	list($usec, $sec) = explode(" ", microtime());
	return $sec . substr($usec, 2);
}

function is_utf8($string) //检测是否为UTF-8字符串 来自：PHPCMS
{
	return preg_match('%^(?:
                    [\x09\x0A\x0D\x20-\x7E] # ASCII
                    | [\xC2-\xDF][\x80-\xBF] # non-overlong 2-byte
                    | \xE0[\xA0-\xBF][\x80-\xBF] # excluding overlongs
                    | [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2} # straight 3-byte
                    | \xED[\x80-\x9F][\x80-\xBF] # excluding surrogates
                    | \xF0[\x90-\xBF][\x80-\xBF]{2} # planes 1-3
                    | [\xF1-\xF3][\x80-\xBF]{3} # planes 4-15
                    | \xF4[\x80-\x8F][\x80-\xBF]{2} # plane 16
                    )*$%xs', $string);
}

function sendlog($string, $t = 'day') {
	if (is_array($string)) {
		$string = json_encode($string);
	}
	$timestamp = time();
	if ($t == 'day') {
		$f = date('Ymd', $timestamp);
		$filename = DATA_PATH . '/log/mlog/' . $f . '.log';
	}
	$logtime = date('Y/m/d H:i:s', $timestamp);
	$record = $logtime . ' - ' . $string . "\n";
	writelog($filename, $record, 'ab');
}

function mkdir_recursive($pathname, $mode) {
	if (strpos($pathname, '..') !== false) {
		return false;
	}
	$pathname = rtrim(preg_replace(array('/\\{1,}/', '/\/{2,}/'), '/', $pathname), '/');
	if (is_dir($pathname)) {
		return true;
	}

	is_dir(dirname($pathname)) || mkdir_recursive(dirname($pathname), $mode);
	return is_dir($pathname) || @mkdir($pathname, $mode);
}

function rc4($string, $operation = 'DECODE', $key = '', $expiry = 0) {
	$ckey_length = 4;
	$key = md5($key != '' ? $key : getglobal('authkey'));
	$keya = md5(substr($key, 0, 16));
	$keyb = md5(substr($key, 16, 16));
	$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length) : substr(md5(microtime()), -$ckey_length)) : '';

	$cryptkey = $keya . md5($keya . $keyc);
	$key_length = strlen($cryptkey);

	$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0) . substr(md5($string . $keyb), 0, 16) . $string;
	$string_length = strlen($string);

	$result = '';
	$box = range(0, 255);

	$rndkey = array();
	for ($i = 0; $i <= 255; $i++) {
		$rndkey[$i] = ord($cryptkey[$i % $key_length]);
	}

	for ($j = $i = 0; $i < 256; $i++) {
		$j = ($j + $box[$i] + $rndkey[$i]) % 256;
		$tmp = $box[$i];
		$box[$i] = $box[$j];
		$box[$j] = $tmp;
	}

	for ($a = $j = $i = 0; $i < $string_length; $i++) {
		$a = ($a + 1) % 256;
		$j = ($j + $box[$a]) % 256;
		$tmp = $box[$a];
		$box[$a] = $box[$j];
		$box[$j] = $tmp;
		$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
	}

	if ($operation == 'DECODE') {
		if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16)) {
			return substr($result, 26);
		} else {
			return '';
		}
	} else {
		return $keyc . str_replace('=', '', base64_encode($result));
	}
}

function fileext($filename) {
	return addslashes(strtolower(substr(strrchr($filename, '.'), 1, 10)));
}

function ffile_get_contents($url, $timeout = 3) {
	$ctx = stream_context_create(
		[
			'http' => [
				'timeout' => $timeout,
			],
		]
	);
	$r = file_get_contents($url, 0, $ctx);
	unset($ctx);
	return $r;
}

function isemail($email) {
	return preg_match("/^([A-Za-z0-9\-_.+]+)@([A-Za-z0-9\-]+[.][A-Za-z0-9\-.]+)$/", $email);
}

function time_diff($start, $end) {
	return ceil(($end - $start) / 86400);
}

function random($length, $numeric = 0) {
	$seed = base_convert(md5(microtime() . $_SERVER['DOCUMENT_ROOT']), 16, $numeric ? 10 : 35);
	$seed = $numeric ? (str_replace('0', '', $seed) . '012340567890') : ($seed . 'zZ' . strtoupper($seed));
	if ($numeric) {
		$hash = '';
	} else {
		$hash = chr(rand(1, 26) + rand(0, 1) * 32 + 64);
		$length--;
	}
	$max = strlen($seed) - 1;
	for ($i = 0; $i < $length; $i++) {
		$hash .= $seed{mt_rand(0, $max)};
	}
	return $hash;
}

function validate_ip($ip) {
	if (strtolower($ip) === 'unknown') {
		return false;
	}

	$ip = ip2long($ip);

	if ($ip !== false && $ip !== -1) {

		$ip = sprintf('%u', $ip);

		if ($ip >= 0 && $ip <= 50331647) {
			return false;
		}

		if ($ip >= 167772160 && $ip <= 184549375) {
			return false;
		}

		if ($ip >= 2130706432 && $ip <= 2147483647) {
			return false;
		}

		if ($ip >= 2851995648 && $ip <= 2852061183) {
			return false;
		}

		if ($ip >= 2886729728 && $ip <= 2887778303) {
			return false;
		}

		if ($ip >= 3221225984 && $ip <= 3221226239) {
			return false;
		}

		if ($ip >= 3232235520 && $ip <= 3232301055) {
			return false;
		}

		if ($ip >= 4294967040) {
			return false;
		}

	}
	return true;
}

function ip_address() {
	if (!empty($_SERVER['HTTP_CLIENT_IP']) && validate_ip($_SERVER['HTTP_CLIENT_IP'])) {
		return $_SERVER['HTTP_CLIENT_IP'];
	}

	if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',') !== false) {
			$iplist = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
			foreach ($iplist as $ip) {
				if (validate_ip($ip)) {
					return $ip;
				}
			}
		} else {
			if (validate_ip($_SERVER['HTTP_X_FORWARDED_FOR'])) {
				return $_SERVER['HTTP_X_FORWARDED_FOR'];
			}
		}
	}
	if (!empty($_SERVER['HTTP_X_FORWARDED']) && validate_ip($_SERVER['HTTP_X_FORWARDED'])) {
		return $_SERVER['HTTP_X_FORWARDED'];
	}

	if (!empty($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']) && validate_ip($_SERVER['HTTP_X_CLUSTER_CLIENT_IP'])) {
		return $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
	}

	if (!empty($_SERVER['HTTP_FORWARDED_FOR']) && validate_ip($_SERVER['HTTP_FORWARDED_FOR'])) {
		return $_SERVER['HTTP_FORWARDED_FOR'];
	}

	if (!empty($_SERVER['HTTP_FORWARDED']) && validate_ip($_SERVER['HTTP_FORWARDED'])) {
		return $_SERVER['HTTP_FORWARDED'];
	}

	return $_SERVER['REMOTE_ADDR'];
}

function writelog($filename, $data, $method = 'wb+', $iflock = 1, $check = 1, $chmod = 1) {
	if (empty($filename)) {
		return false;
	}

	if ($check && strpos($filename, '..') !== false) {
		return false;
	}
	if (!is_dir(dirname($filename)) && !mkdir_recursive(dirname($filename), 0777)) {
		return false;
	}
	if (false == ($handle = fopen($filename, $method))) {
		return false;
	}
	if ($iflock) {
		flock($handle, LOCK_EX);
	}
	fwrite($handle, $data);
	touch($filename);

	if ($method == "wb+") {
		ftruncate($handle, strlen($data));
	}
	fclose($handle);
	$chmod && @chmod($filename, 0777);
	return true;
}