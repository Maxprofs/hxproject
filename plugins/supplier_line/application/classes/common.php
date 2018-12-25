<?php

/**
 * 公共静态类模块
 * User: Netman
 * Date: 15-09-12
 * Time: 下午14:06
 */
require TOOLS_COMMON . 'functions.php';
class Common extends Functions {
	/**
	 * @param $type
	 * @param $key
	 * @param string $value
	 * @return bool|mixed
	 * 缓存设置与获取
	 */
	public static function cache($type, $key, $value = '') {
		if (!$GLOBALS['cfg_cache_open']) {
			return false;
		}
		$cache_dir = CACHE_DIR . 'supplier_lin/html';
		if (!file_exists($cache_dir)) {
			mkdir($cache_dir, 0777, true);
		}
		$cache = Cache::instance('default');
		//获取缓存
		if ($type == 'get') {
			return $cache->get($key, '');
		}
		//设置缓存
		else if ($type == 'set' && mb_stripos($value, '没有找到符合条件的产品') === false) {
			return $cache->set($key, $value, 3600);
		}

	}
	/**
	 * @return string
	 * 获取当前网址
	 */
	public static function get_current_url() {
		return St_Functions::get_http_prefix() . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	}

	/*
		     * 获取配置文件值
	*/
	public static function get_config($group) {
		return Kohana::$config->load($group);

	}

	/*
		     * 生成缩略图
		     *
	*/
	public static function thumb($srcfile, $savepath, $w, $h) {
		Image::factory($srcfile)->resize($w, $h, Image::WIDTH)->save($savepath);
		return $savepath;
	}

	/*
		     * 时间转换函数
	*/
	public static function mydate($format, $timest) {
		$addtime = 8 * 3600;
		if (empty($format)) {
			$format = 'Y-m-d H:i:s';
		}
		return gmdate($format, $timest + $addtime);
	}

	/*
		    * 获取文件扩展名
	*/
	public static function get_extension($file) {
		return end(explode('.', $file));
	}

	/*
		     * 级联删除文件夹
	*/
	public static function rrmdir($dir) {
		if (is_dir($dir)) {
			$objects = scandir($dir);
			foreach ($objects as $object) {
				if ($object != "." && $object != "..") {
					if (filetype($dir . "/" . $object) == "dir") {
						self::rrmdir($dir . "/" . $object);
					} else {
						unlink($dir . "/" . $object);
					}

				}
			}
			reset($objects);
			rmdir($dir);
		}

	}

	/*
		     * 保存文件
	*/
	public static function save_file($file, $content) {

		$fp = fopen($file, "wb");
		flock($fp, 3);
		//@flock($this->open,3);
		$result = fwrite($fp, $content);
		fclose($fp);
		return $result;
	}

	//检查一个串是否存在在某个串中
	public static function check_instr($str, $substr) {

		$tmparray = explode($substr, $str);
		if (count($tmparray) > 1) {
			return true;
		} else {
			return false;
		}
	}

	/*
		     * curl http访问
	*/
	public static function http($url, $method = 'get', $postfields = '') {

		$ci = curl_init();

		curl_setopt($ci, CURLOPT_RETURNTRANSFER, 1);

		if ($method == 'POST') {
			curl_setopt($ci, CURLOPT_POST, TRUE);
			if ($postfields != '') {
				curl_setopt($ci, CURLOPT_POSTFIELDS, $postfields);
			}

		}

		curl_setopt($ci, CURLOPT_URL, $url);
		$response = curl_exec($ci);
		curl_close($ci);
		return $response;

	}

	/*
		     * 对象转数组
	*/

	public static function object_to_array($array) {
		if (is_object($array)) {
			$array = (array) $array;
		}
		if (is_array($array)) {
			foreach ($array as $key => $value) {
				$array[$key] = self::object_to_array($value);
			}
		}
		return $array;
	}

	/**
	 *  获取拼音信息
	 *
	 * @access    public
	 * @param     string $str 字符串
	 * @param     int $ishead 是否为首字母
	 * @param     int $isclose 解析后是否释放资源
	 * @return    string
	 */
	public static function get_pinyin($str, $ishead = 0, $isclose = 1) {
		$str = iconv('utf-8', 'gbk//ignore', $str);
		$restr = '';
		$str = trim($str);
		$slen = strlen($str);
		if ($slen < 2) {
			return $str;
		}

		if (count(self::$pinyin) == 0) {
			$fp = fopen(APPPATH . '/vendor/pinyin/pinyin.dat', 'r');
			while (!feof($fp)) {
				$line = trim(fgets($fp));
				self::$pinyin[$line[0] . $line[1]] = substr($line, 3, strlen($line) - 3);
			}
			fclose($fp);
		}
		for ($i = 0; $i < $slen; $i++) {
			if (ord($str[$i]) > 0x80) {
				$c = $str[$i] . $str[$i + 1];
				$i++;
				if (isset(self::$pinyin[$c])) {
					if ($ishead == 0) {
						$restr .= self::$pinyin[$c];
					} else {
						$restr .= self::$pinyin[$c][0];
					}
				} else {
					$restr .= "_";
				}
			} else if (preg_match("/[a-z0-9]/i", $str[$i])) {
				$restr .= $str[$i];
			} else {
				$restr .= "_";
			}
		}
		if ($isclose == 0) {
			unset(self::$pinyin);
		}
		$sheng = "/.*sheng.*/";
		$shi = "/.*shi.*/";
		$qu = "/.*qu.*/";
		if (preg_match($sheng, $restr, $matches)) {
			$restr = str_replace('sheng', '', $matches[0]);
		}
		if (preg_match($shi, $restr, $matches)) {
			$restr = str_replace('shi', '', $matches[0]);
		}
		if (preg_match($qu, $restr, $matches)) {
			$restr = str_replace('qu', '', $matches[0]);
		}
		return $restr;
	}

	/*
		     * decode加密/解密算法
	*/

	public static function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
		$ckey_length = 4;

		$key = md5($key ? $key : 'stourweb');
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

	//表字段操作(添加)
	public static function add_field($table, $fieldname, $fieldtype, $isunique, $comment) {
		$fieldname = 'e_' . $fieldname;
		$sql = "ALTER TABLE `{$table}` ADD COLUMN `{$fieldname}` {$fieldtype} NULL DEFAULT NULL COMMENT '$comment'";
		$sql .= $isunique == 1 ? ",ADD unique('{$fieldname}');" : '';
		return DB::query(1, $sql)->execute();
	}

	/*
		     * 表字段操作(删除)
	*/
	public static function del_field($table, $fieldname) {
		$sql = "ALTER TABLE `{$table}` DROP COLUMN `{$fieldname}`";
		DB::query(1, $sql)->execute();
	}

	//获取时间范围
	/*
	     * 1:今日
	     * 2:昨日
	     * 3:本周
	     * 4:上周
	     * 5:本月
	     * 6:上月
*/
	public function get_timerange($type) {
		switch ($type) {
		case 1:
			$starttime = strtotime(date('Y-m-d 00:00:00'));
			$endtime = strtotime(date('Y-m-d 23:59:59'));
			break;
		case 2:
			$starttime = strtotime(date('Y-m-d 00:00:00', strtotime('-1 day')));
			$endtime = strtotime(date('Y-m-d 23:59:59', strtotime('-1 day')));
			break;
		case 3:
			$starttime = mktime(0, 0, 0, date("m"), date("d") - date("w") + 1, date("Y"));
			$endtime = time();
			break;
		case 4:
			$starttime = strtotime(date('Y-m-d 00:00:00', strtotime('last Sunday')));
			$endtime = strtotime(date('Y-m-d H:i:s', strtotime('last Sunday') + 7 * 24 * 3600 - 1));
			break;
		case 5:
			$starttime = strtotime(date('Y-m-01 00:00:00', time()));
			$endtime = time();
			break;
		case 6:
			$starttime = strtotime(date('Y-m-01 00:00:00', strtotime('-1 month')));
			$endtime = strtotime(date('Y-m-31 23:59:00', strtotime('-1 month')));
			break;

		}
		$out = array($starttime, $endtime);
		return $out;

	}

	/*
		     * xml转数组
	*/
	public static function xml_to_array($xml) {
		$array = (array) (simplexml_load_string($xml));
		foreach ($array as $key => $item) {
			$array[$key] = self::struct_to_array((array) $item);
		}
		return $array;
	}

	/*
		     * 结构转数组
	*/
	public static function struct_to_array($item) {
		if (!is_string($item)) {
			$item = (array) $item;
			foreach ($item as $key => $val) {
				$item[$key] = self::struct_to_array($val);
			}
		}
		return $item;
	}

	/*
		     * 去除xss全局函数,所有输入参数都要调用这个参数.
	*/

	// 写入系统缓存
	public static function cache_config() {
		$file = APPPATH . '/cache/config.php';
		//缓存文件不存在
		if (!file_exists($file)) {
			$data = Model_Sysconfig::config();
			$config = array();
			foreach ($data as $v) {
				$config[$v['varname']] = trim($v['value']);
			}
			if (!isset($config['cfg_m_img_url'])) {
				$config['cfg_m_img_url'] = $config['cfg_m_main_url'];
			}
			$config['cfg_m_logo'] = $config['cfg_m_img_url'] . $config['cfg_m_logo'];
			file_put_contents($file, '<?php defined(\'SYSPATH\') or die(\'No direct script access.\');' . PHP_EOL . 'return ' . var_export($config, true) . ';');
		}
		$data = require_once $file;
		return $data;
	}

	/*
		     * 生成站点列表
	*/
	public static function cache_web_list() {

	}
	public static function getBaseUrl($webid) {
		$url = $GLOBALS['cfg_basehost'];
		if ($webid != 0) {
			$sql = "select weburl from sline_destinations where id='$webid'";
			$row = DB::query(1, $sql)->execute();
			return $row[0]['weburl'];
		}
	}
	public static function getSeries($id, $prefix) {
		$ar = array(
			'01' => 'A',
			'02' => 'B',
			'05' => 'C',
			'03' => 'D',
			'08' => 'E',
			'13' => 'G',
			'14' => 'H',
			'15' => 'I',
			'16' => 'J',
			'17' => 'K',
			'18' => 'L',
			'19' => 'M',
			'20' => 'N',
			'21' => 'O',
			'22' => 'P',
			'23' => 'Q',
			'24' => 'R',
			'25' => 'S',
			'26' => 'T',
		);
		$prefix = $ar[$prefix];
		$len = strlen($id);
		$needlen = 4 - $len;
		if ($needlen == 3) {
			$s = '000';
		} else if ($needlen == 2) {
			$s = '00';
		} else if ($needlen == 1) {
			$s = '0';
		}

		$out = $prefix . $s . "{$id}";
		return $out;
	}

	// 发送邮件
	public static function send_email($maillto, $title, $content) {
		require_once TOOLS_COMMON . 'email/emailservice.php';
		$status = EmailService::send_email($maillto, $title, $content);
		return $status;
	}

	//session 管理
	public static function session($k, $v = '') {
		$session = Session::instance();
		if (empty($v)) {
			$session = is_null($v) ? $session->delete($k) : $session->get($k);
		} else {
			$session->set($k, $v);
		}
		return $session;
	}

	//提示信息
	public static function message($msg) {
		if (empty($msg['jumpUrl'])) {
			Request::current()->redirect('/');
		}
		$javascript = Common::js('jquery.min.js,layer/layer.m.js');
		echo <<<EOT
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>信息提示</title>
            {$javascript}
        </head>
        <body>
        </body>
        <script type="text/javascript">
         layer.open({
                content: '{$msg["message"]}',
                time: 2,
                end:function(){
                   window.location.href='{$msg["jumpUrl"]}';
                }
            });
        </script>
        </html>
EOT;
	}

	/**
	 * @return string
	 * @return 无图设置
	 */
	public static function nopic() {
		return '/phone/public/images/nopicture.png';
	}

	public static function member_nopic() {
		return '/phone/public/images/member_nopic.png';
	}

	public static function menu_nopic() {
		return '/phone/public/images/menu_no_ico.png';
	}

	/*
		     * 缩略图url
	*/
	public static function img($src, $width = '', $height = '') {
		if (empty($src)) {
			return self::nopic();
		}
//无图返回

		if (!empty($width) && !empty($height) && !preg_match('/_\d+X\d+\.(jpg|jpeg|png|gif)$/is', $src)) {
			$src = preg_replace('/(\.(?:jpg|jpeg|png|gif))$/', "_{$width}x{$height}$1", $src);
		}
		return strpos($src, St_Functions::get_http_prefix()) === false ? rtrim($GLOBALS['cfg_m_img_url'], '/') . $src : $src;
	}

	/*
		    * 获取某个配置值
	*/

	public static function get_sys_conf($field, $varname, $webid = 0) {
		$result = DB::query(Database::SELECT, "select $field from sline_sysconfig where varname='$varname' and webid=$webid")->execute()->as_array();
		return $result[0][$field];
	}

	public static function get_sys_para($varname) {
		return self::get_sys_conf('value', $varname, 0);
	}

	//分析当前域名,返回主域名
	/**
	 * @return string
	 * @desc 如www.lvyou.com 返回 lvyou.com
	 */
	private static function get_domain() {
		$url = $GLOBALS['cfg_basehost'];

		$uarr = explode('.', $url);
		$k = 0;
		$out = '';
		foreach ($uarr as $value) {
			$out .= $k != 0 ? $value : '';
			$out .= '.';
			$k++;
		}
		$out = substr($out, 0, strlen($out) - 1);
		return $out;

	}

	/*
		    * 获取主站prefix
	*/
	public static function get_main_prefix() {

		$sql = "SELECT webprefix FROM `sline_weblist` WHERE webid=0";
		$row = DB::query(1, $sql)->execute()->as_array();
		return $row[0]['webprefix'] ? $row[0]['webprefix'] : 'www';
	}

	/**
	 * @param $webid
	 * @return string
	 * @desc 根据webid获取产品的url绝对地址
	 */
	public static function get_web_url($webid) {
		$domain = self::get_domain(); //顶级域名
		//如果webid不为0,则读取站点的信息
		if ($webid != 0) {
			$prefix = ORM::factory('destinations', $webid)->get('webprefix');
		} else {
			$prefix = self::get_main_prefix();
		}
		$url = isset($GLOBALS['cfg_phone_cmspath']{1}) ? St_Functions::get_http_prefix() . $prefix . $domain . $GLOBALS['cfg_phone_cmspath'] : $GLOBALS['cfg_basehost'];
		return $url;
	}

	public static function cutstr_html($string, $sublen) {
		$string = strip_tags($string);

		$string = preg_replace('/\n/is', '', $string);

		$string = preg_replace('/ |　/is', '', $string);

		$string = preg_replace('/&nbsp;/is', '', $string);

		preg_match_all("/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/", $string, $t_string);

		if (count($t_string[0]) - 0 > $sublen) {
			$string = join('', array_slice($t_string[0], 0, $sublen)) . "…";
		} else {
			$string = join('', array_slice($t_string[0], 0, $sublen));
		}

		return $string;

	}

	public static function GetIP() {
		static $realip = NULL;
		if ($realip !== NULL) {
			return $realip;
		}
		if (isset($_SERVER)) {
			if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
				$arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
				/* 取X-Forwarded-For中第x个非unknown的有效IP字符? */
				foreach ($arr as $ip) {
					$ip = trim($ip);
					if ($ip != 'unknown') {
						$realip = $ip;
						break;
					}
				}
			} elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
				$realip = $_SERVER['HTTP_CLIENT_IP'];
			} else {
				if (isset($_SERVER['REMOTE_ADDR'])) {
					$realip = $_SERVER['REMOTE_ADDR'];
				} else {
					$realip = '0.0.0.0';
				}
			}
		} else {
			if (getenv('HTTP_X_FORWARDED_FOR')) {
				$realip = getenv('HTTP_X_FORWARDED_FOR');
			} elseif (getenv('HTTP_CLIENT_IP')) {
				$realip = getenv('HTTP_CLIENT_IP');
			} else {
				$realip = getenv('REMOTE_ADDR');
			}
		}
		preg_match("/[\d\.]{7,15}/", $realip, $onlineip);
		$realip = !empty($onlineip[0]) ? $onlineip[0] : '0.0.0.0';
		return $realip;
	}

	//跳转404页面
	public static function head404() {
		header("HTTP/1.1 404 Not Found");
		header("Status: 404 Not Found");
		//header("Location: ".$GLOBALS['cfg_basehost']."/404.php");
		echo "<script>window.location.href='/404.php'</script>";
		exit;

	}

//跳转301
	public static function head301($url) {
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: $url");
		exit();

	}

	/**
	 * 主站域名
	 * @return string
	 */
	static function get_main_host() {
		$host = '';
		$sql = "select weburl from sline_weblist where webid=0";
		$arr = DB::query(Database::SELECT, $sql)->execute()->current();
		if (!empty($arr)) {
			$host = $arr['weburl'];
		}
		return $host;
	}
	/**
	 * COOKIE 域名
	 * @return string
	 */
	static function cookie_domain() {
		$host = $_SERVER['HTTP_HOST'];
		$sql = "select * from sline_weblist where webid=0";
		$arr = DB::query(Database::SELECT, $sql)->execute()->current();
		if (!empty($arr)) {
			$host = str_replace($arr['webprefix'] . '.', '', parse_url($arr['weburl'], PHP_URL_HOST));
		}
		return $host;
	}
	/**
	 * 支付表单数据提交
	 * @param $data
	 * @return string
	 */
	static function payment_from($data) {
		if (!is_array($data) && empty($data) && !isset($data['ordersn'])) {
			return false;
		}
		$url = self::get_main_host() . '/payment/';
		$html = "<form action='{$url}' style='display:none;' method='post' id='payment'>";
		foreach ($data as $name => $v) {
			$html .= "<input type='text' name='{$name}' value='{$v}'>";
		}
		$html .= '</form>';
		$html .= "<script>document.forms['payment'].submit();</script>";
		return $html;
	}

	/**
	 * @param $text
	 * 生成二维码
	 */
	public static function qrcode($text) {
		if (!class_exists('QRcode')) {
			include Kohana::find_file('vendor', "phpqrcode/phpqrcode");
		}
		$errorCorrectionLevel = "L";
		$matrixPointSize = 8;
		QRcode::png($text, false, $errorCorrectionLevel, $matrixPointSize);
	}
	public static function getExtendTable($typeid) {
		$row = ORM::factory('model', $typeid)->as_array();
		return 'sline_' . $row['addtable'];
	}

	/*
		     * 根据typeid获取扩展字段信息
	*/
	public static function getExtendInfo($typeid, $productid) {
		//$table = self::$extend_table_arr[$typeid];
		$table = self::getExtendTable($typeid);
		$sql = "select * from {$table} where productid='$productid'";
		$arr = DB::query(1, $sql)->execute()->as_array();
		return $arr[0];
	}
	public static function getSelectedAttr($typeid, $attr_str) {
		$productattr_arr = array(1 => 'line_attr', 2 => 'hotel_attr', 3 => 'car_attr', 4 => 'article_attr', 5 => 'spot_attr', 6 => 'photo_attr', 13 => 'tuan_attr');
		$attrtable = $typeid < 14 ? $productattr_arr[$typeid] : 'model_attr';
		$attrid_arr = explode(',', $attr_str);
		$attr_arr = array();
		foreach ($attrid_arr as $k => $v) {
			if ($typeid < 14) {
				$attr = ORM::factory($attrtable)->where("pid!=0 and id='$v'")->find();
			} else {
				$attr = ORM::factory($attrtable)->where("pid!=0 and id='$v' and typeid='$typeid'")->find();
			}
			if ($attr->id) {
				$attr_arr[] = $attr->as_array();
			}
		}
		return $attr_arr;
	}
	public static function getSelectedIcon($iconlist) {
		$iconid_arr = explode(',', $iconlist);
		$iconarr = array();
		foreach ($iconid_arr as $k => $v) {
			$icon = ORM::factory('icon', $v);
			if ($icon->id) {
				$iconarr[] = $icon->as_array();
			}

		}
		return $iconarr;
	}

	public static function getEditor($fname, $fvalue, $nwidth = "700", $nheight = "350", $etype = "Sline", $ptype = '', $gtype = "print", $jsEditor = false) {

		require DOCROOT . '/public/vendor/slineeditor/ueditor.php';
		$UEditor = new UEditor();
		$UEditor->basePath = $GLOBALS['cfg_cmspath'] . 'public/vendor/slineeditor/';
		$nheight = $nheight == 400 ? 300 : $nheight;
		$config = $events = array();
		$GLOBALS['tools'] = empty($toolbar[$etype]) ? $GLOBALS['tools'] : $toolbar[$etype];
		$config['toolbars'] = $GLOBALS['tools'];
		$config['minFrameHeight'] = $nheight;
		$config['initialFrameHeight'] = $nheight;
		$config['initialFrameWidth'] = $nwidth;
		$config['autoHeightEnabled'] = false;
		if (!$jsEditor) {
			$code = $UEditor->editor($fname, $fvalue, $config, $events);
		} else {
			$code = $UEditor->jseditor($fname, $fvalue, $config, $events);
		}
		if ($gtype == "print") {
			echo $code;
		} else {
			return $code;
		}
	}
	public static function getIco($type, $helpid = 0) {
		switch ($type) {
		case 'help':
			$out = "<img class='fl' style='cursor:pointer' src='" . $GLOBALS['cfg_public_url'] . "images/help-ico.png' onclick='ST.Util.helpBox(this," . $helpid . ",event)' />";
			break;
		case 'edit':
			$out = "<img class='' src='" . $GLOBALS['cfg_public_url'] . "images/xiugai-ico.gif' />";
			break;
		case 'del':
			$out = "<img class='' src='" . $GLOBALS['cfg_public_url'] . "images/del-ico.gif' />";
			break;
		case 'hide':
			$out = "<img class='' src='" . $GLOBALS['cfg_public_url'] . "images/close-s.png' data-show='0' />";
			break;
		case 'show':
			$out = "<img class='' src='" . $GLOBALS['cfg_public_url'] . "images/show-ico.png' data-show='1' />";
			break;
		case 'preview':
			$out = "<img class='' src='" . $GLOBALS['cfg_public_url'] . "images/preview.png' data-show='1' />";
			break;
		case 'order':
			$out = "<img class='' src='" . $GLOBALS['cfg_public_url'] . "images/order.png' data-show='1' />";
			break;
		case 'order_unview':
			$out = "<img class='' src='" . $GLOBALS['cfg_public_url'] . "images/order_unview.png' data-show='1' />";
			break;
		}
		return $out;
	}
	public static function getWebList() {
		$arr = DB::select_array(array('id', 'kindname', 'weburl', 'webroot', 'webprefix'))->from('destinations')->where("iswebsite=1 and isopen=1")->order_by("displayorder", 'asc')->execute()->as_array();
		foreach ($arr as $key => $value) {
			$arr[$key]['webid'] = $value['id'];
			$arr[$key]['webname'] = $value['kindname'];
		}
		/* $main=array(
			             array(
			             'webid' => 0 ,
			             'webname'=>'主站'
			             )
		*/
		// $ar = array_merge($main,$arr);
		return $arr;
	}
	public static function getConfig($group) {
		return Kohana::$config->load($group);
	}
	public static function saveExtendData($typeid, $productid, $info) {
		//$table = self::$extend_table_arr[$typeid];
		$table = self::getExtendTable($typeid);
		$extendinfo = array();
		$columns = array('productid');
		$values = array($productid);
		foreach ($info as $k => $v) {
			if (preg_match('/^e_/', $k)) //找出所有扩展字段设置
			{
				$extendinfo[$k] = $v;
				$columns[] = $k;
				$values[] = $v;
			}
		}
		if (count($extendinfo) > 0) {
			$sql = "select count(*) as num from $table where productid='$productid'";
			$row = DB::query(1, $sql)->execute()->as_array();
			//optable
			$optable = str_replace('sline_', '', $table);
			if ($row[0]['num'] > 0) //已存在则更新
			{
				DB::update($optable)->set($extendinfo)->where("productid='$productid'")->execute();
			} else {
				DB::insert($optable)->columns($columns)->values($values)->execute();
			}
		}
	}

	public static function last_offer($modelId, $data) {
		$lastOffer = array();
		switch ($modelId) {
		//线路
		case 1:
			$lastOffer = array(
				'pricerule' => $data['pricerule'],
				'adultbasicprice' => $data['adultbasicprice'],
				'adultprofit' => $data['adultprofit'],
				'adultprice' => $data['adultbasicprice'] + $data['adultprofit'],
				'childbasicprice' => $data['childbasicprice'],
				'childprofit' => $data['childprofit'],
				'childprice' => $data['childbasicprice'] + $data['childprofit'],
				'oldbasicprice' => $data['oldbasicprice'],
				'oldprofit' => $data['oldprofit'],
				'oldprice' => $data['oldbasicprice'] + $data['oldprofit'],
				'starttime' => $data['starttime'],
				'endtime' => $data['endtime'],
			);
			break;
		//酒店、租车
		case 2:
		case 3:
			$lastOffer = array(
				'pricerule' => $data['pricerule'],
				'basicprice' => $data['basicprice'],
				'profit' => $data['profit'],
				'price' => $data['basicprice'] + $data['profit'],
				'starttime' => $data['starttime'],
				'endtime' => $data['endtime'],
			);
			break;
		}
		return serialize($lastOffer);
	}
	public static function page($count, $pageno, $pagesize, $url, $disnum = 5, $url1) //分页函数
	{
		$title_arr = array(
			'firstpage' => '',
			'prepage' => '',
			'lastpage' => '',
			'nextpage' => '',
		);

		if ($count == 0) {
			return '';
		}

		$page = ceil($count / $pagesize);
		$str .= '<div class="page">
		';

		//前一页按钮2
		if ($pageno <= 1) {
			$str .= '<span class="pageOff firstpage">' . $title_arr['firstpage'] . '</span> <span class="pageOff prepage">' . $title_arr['prepage'] . '</span> ';
		} else {
			$pre_pageno = $pageno - 1;
			$nurl = $pre_pageno == 1 ? $url1 : str_replace('{page}', $pre_pageno, $url);
			$str .= "<a class='pageOff firstpage' href='$url1'>" . $title_arr['firstpage'] . "</a> <a class='pageOff prepage' href='$nurl'>" . $title_arr['prepage'] . "</a> ";
		}
		//计算页起始页和结束页
		if ($page >= $disnum) {
			$pre_num = ceil(($disnum - 1) / 2);
			$next_num = floor(($disnum - 1) / 2);
			if ($pre_num >= $pageno) {
				$start_index = 1;
				$end_index = $disnum;
			} else {
				$start_index = $pageno - $pre_num;
				$end_index = $pageno + $next_num;
			}
			if ($end_index >= $page) {
				$start_index = $page - $disnum;
				$end_index = $page;
			}
		} else {
			$start_index = 1;
			$end_index = $page;
		}

		//前置省略页面
		if ($start_index > 1) {
			$str .= '<span class="pageOff pagenum">...</span> ';
		}

		$start_index = $start_index < 1 ? 1 : $start_index;
		//实现
		for ($i = $start_index; $i <= $end_index; $i++) {
			if ($pageno == $i) {
				$str .= "<span class='pageCurrent pagenum'>$i</span> ";
			} else {
				$burl = $i == 1 ? $url1 : str_replace('{page}', $i, $url);
				$str .= "<a class='pageOff pagenum' href='$burl'>{$i}</a> ";
			}
		}

		//后置省略页面
		if ($end_index < $page) {
			$str .= '<span class="pageOff pagenum">...</span> ';
		}

		//下一页按钮
		if ($pageno == $page) {
			$str .= '<span class="pageOff nextpage">' . $title_arr['nextpage'] . '</span> <span class="pageOff lastpage">' . $title_arr['lastpage'] . '</span> ';
		} else {
			$next_pageno = ($pageno + 1) <= $page ? $pageno + 1 : $page;
			$nurl = str_replace('{page}', $next_pageno, $url);
			$lasturl = str_replace('{page}', $page, $url);
			$str .= "<a href=\"{$nurl}\" class=\"pageOff nextpage\">" . $title_arr['nextpage'] . "</a> <a href=\"{$lasturl}\" class=\"pageOff lastpage\">" . $title_arr['lastpage'] . "</a> ";
		}
		$str .= "<span class='pageContent'>(总计<span class='pageTotal'>{$page}</span>页<span class='numTotal'>{$count}</span>条记录)</span></div>";
		return $str;
	}

	public static function getLastAid($tablename, $webid = 0) {
		$aid = 1; //初始值
		$sql = "select max(aid) as aid from {$tablename} where webid=$webid order by id desc";
		$row = DB::query(1, $sql)->execute()->as_array();
		if (is_array($row)) {
			$aid = $row[0]['aid'] + 1;
		}
		return $aid;
	}
	//检查一个串是否存在在某个串中
	public static function checkStr($str, $substr) {
		$tmparray = explode($substr, $str);
		if (count($tmparray) > 1) {
			return true;
		} else {
			return false;
		}
	}
	public static function getDefaultImage() {
		return '';
	}

	/**
	 * 获取扩展字段相关信息
	 * @param $typeid
	 * @param $extendinfo
	 * @return array
	 */
	public static function get_line_extend_content($typeid, $extendinfo) {
		$content_table = array(
			1 => 'line_content',

		);
		$table = $content_table[$typeid];

		$content_field_list = DB::select()
			->from($table)
			->where("isopen=1 AND columnname like 'e_%'")
			->execute()
			->as_array();

		$fields = array();
		foreach ($content_field_list as $v) {
			$fields[] = $v['columnname'];
		}

		$arr = DB::select()
			->from('extend_field')
			->where("typeid='$typeid' AND isopen=1")
			->execute()
			->as_array();
		$contentHtml = '';
		$extendHtml = '';
		foreach ($arr as $row) {
			$default = !empty($extendinfo[$row['fieldname']]) ? $extendinfo[$row['fieldname']] : '';
			if (in_array($row['fieldname'], $fields)) {
				$contentHtml .= '<div id="content_' . $row['fieldname'] . '"  data-id="' . $row['fieldname'] . '" class="product-add-div content-hide">';
				$contentHtml .= '
                                 <div  class="editor-range">
' . self::get_editor($row['fieldname'], $default, 700, 300, 'Sline', '0', '0') . '</div>
                            ';
				$contentHtml .= '</div>';
				continue;
			}
			if ($row['fieldtype'] == 'editor') {
				$head = '<div class="add-class">';
				$head .= '<dl>
                            <dt>' . $row['description'] . '：</dt>
                            <dd>
                                <div>' . self::get_editor($row['fieldname'], $default, 700, 300, 'Sline', '0', '0') . '</div>
                            </dd>
                        </dl>';
				$head .= '</div>';
				$extendHtml .= $head;
			} else if ($row['fieldtype'] == 'text') {
				$head = '<div class="add-class">';
				$head .= '<dl>
                            <dt>' . $row['description'] . '：</dt>
                            <dd>
                                <input type="text" name="' . $row['fieldname'] . '"  value="' . $default . '" class="set-text-xh text_300 mt-2">
                            </dd>
                        </dl>';
				$head .= '</div>';
				$extendHtml .= $head;
			}
		}
		return array('contentHtml' => $contentHtml, 'extendHtml' => $extendHtml);
	}

	//加载指定模块的css
	public static function plugin_pinyin_css($filelist, $pinyin) {
		$filearr = explode(',', $filelist);
		$filelist = array();
		$out = '';
		foreach ($filearr as $file) {
			$plugin_file = '/' . basename(dirname(DOCROOT)) . '/' . $pinyin . "/public/css/{$file}";
			$tfile = dirname(DOCROOT) . '/' . $pinyin . '/public/css/' . $file;
			if (file_exists($tfile)) {
				$filelist[] = $plugin_file;
			}
		}

		if (!empty($filelist)) {
			$f = implode(',', $filelist);
			$cssUrl = '/min/?f=' . $f;
			$out = '<link type="text/css" href="' . $cssUrl . '" rel="stylesheet"  />' . "\r\n";
		}
		return $out;
	}

	//加载指定模块的js
	public static function plugin_pinyin_js($filelist, $pinyin) {
		$filearr = explode(',', $filelist);
		$filelist = array();
		$out = '';
		foreach ($filearr as $file) {
			$plugin_file = '/' . basename(dirname(DOCROOT)) . '/' . $pinyin . "/public/js/{$file}";
			$tfile = dirname(DOCROOT) . '/' . $pinyin . '/public/js/' . $file;
			if (file_exists($tfile)) {
				$filelist[] = $plugin_file;
			}
		}
		if ($filelist) {
			//如果开启自动合并js
			$f = implode(',', $filelist);
			$jsUrl = '/min/?f=' . $f;
			$out = '<script type="text/javascript" src="' . $jsUrl . '"></script>' . "\r\n";

		}
		return $out;
	}
}
