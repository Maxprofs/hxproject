<?php

/**
 * 公共静态类模块
 * User: Netman
 * Date: 15-09-12
 * Time: 下午14:06
 */
//引入公用函数库
require TOOLS_COMMON . 'functions.php';

class Common extends Functions
{


    /*
     * 获取配置文件值
     * */
    public static function get_config($group)
    {
        return Kohana::$config->load($group);
    }

    /*
     * 清空数组里的空值
     * */

    public static function remove_arr_empty($arr)
    {

        $newarr = array_diff($arr, array(null, 'null', '', ' '));
        return $newarr;

    }

    /*
     * 生成缩略图
     *
     * */
    public static function thumb($srcfile, $savepath, $w, $h)
    {
        Image::factory($srcfile)->resize($w, $h, Image::WIDTH)->save($savepath);
        return $savepath;
    }

    /*
     * 时间转换函数
     * */
    public static function mydate($format, $timest)
    {
        $addtime = 8 * 3600;
        if (empty($format))
        {
            $format = 'Y-m-d H:i:s';
        }
        return gmdate($format, $timest + $addtime);
    }

    /*
     * 获取网站http网址
     * */
    public static function get_weburl($webid = 0)
    {
        return $GLOBALS['cfg_basehost'];
    }

    /*
    * 获取文件扩展名
    * */
    public static function get_extension($file)
    {
        return end(explode('.', $file));
    }

    /*
     * 级联删除文件夹
     */
    public static function rrmdir($dir)
    {
        if (is_dir($dir))
        {
            $objects = scandir($dir);
            foreach ($objects as $object)
            {
                if ($object != "." && $object != "..")
                {
                    if (filetype($dir . "/" . $object) == "dir") self::rrmdir($dir . "/" . $object);
                    else unlink($dir . "/" . $object);
                }
            }
            reset($objects);
            rmdir($dir);
        }

    }

    /*
     * 保存文件
     * */
    public static function save_file($file, $content)
    {

        $fp = fopen($file, "wb");
        flock($fp, 3);
        //@flock($fp,3);
        $result = fwrite($fp, $content);
        fclose($fp);
        return $result;
    }
    /*
     * 获取编号
     * */
    //获取编号,共6位,不足6位前面被0
    public static function get_series($id, $prefix)
    {
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
            '26' => 'T'
        );
        $prefix = $ar[$prefix];
        $len = strlen($id);
        $needlen = 4 - $len;
        if ($needlen == 3) $s = '000';
        else if ($needlen == 2) $s = '00';
        else if ($needlen == 1) $s = '0';

        $out = $prefix . $s . "{$id}";
        return $out;

    }

    //检查一个串是否存在在某个串中
    public static function check_instr($str, $substr)
    {

        $tmparray = explode($substr, $str);
        if (count($tmparray) > 1)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /*
     * curl http访问
     * */
    public static function http($url, $method = 'get', $postfields = '')
    {

        $ci = curl_init();

        curl_setopt($ci, CURLOPT_RETURNTRANSFER, 1);

        if ($method == 'POST')
        {
            curl_setopt($ci, CURLOPT_POST, TRUE);
            if ($postfields != '') curl_setopt($ci, CURLOPT_POSTFIELDS, $postfields);
        }

        curl_setopt($ci, CURLOPT_URL, $url);
        $response = curl_exec($ci);
        curl_close($ci);
        return $response;

    }

    /*
     * 对象转数组
     * */

    public static function object_to_array($array)
    {
        if (is_object($array))
        {
            $array = (array)$array;
        }
        if (is_array($array))
        {
            foreach ($array as $key => $value)
            {
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
    public static function get_pinyin($str, $ishead = 0, $isclose = 1)
    {
        $str = iconv('utf-8', 'gbk//ignore', $str);
        $restr = '';
        $str = trim($str);
        $slen = strlen($str);
        if ($slen < 2)
        {
            return $str;
        }

        if (count(self::$pinyin) == 0)
        {
            $fp = fopen(APPPATH . '/vendor/pinyin/pinyin.dat', 'r');
            while (!feof($fp))
            {
                $line = trim(fgets($fp));
                self::$pinyin[$line[0] . $line[1]] = substr($line, 3, strlen($line) - 3);
            }
            fclose($fp);
        }
        for ($i = 0; $i < $slen; $i++)
        {
            if (ord($str[$i]) > 0x80)
            {
                $c = $str[$i] . $str[$i + 1];
                $i++;
                if (isset(self::$pinyin[$c]))
                {
                    if ($ishead == 0)
                    {
                        $restr .= self::$pinyin[$c];
                    }
                    else
                    {
                        $restr .= self::$pinyin[$c][0];
                    }
                }
                else
                {
                    $restr .= "_";
                }
            }
            else if (preg_match("/[a-z0-9]/i", $str[$i]))
            {
                $restr .= $str[$i];
            }
            else
            {
                $restr .= "_";
            }
        }
        if ($isclose == 0)
        {
            unset(self::$pinyin);
        }
        $sheng = "/.*sheng.*/";
        $shi = "/.*shi.*/";
        $qu = "/.*qu.*/";
        if (preg_match($sheng, $restr, $matches))
        {
            $restr = str_replace('sheng', '', $matches[0]);
        }
        if (preg_match($shi, $restr, $matches))
        {
            $restr = str_replace('shi', '', $matches[0]);
        }
        if (preg_match($qu, $restr, $matches))
        {
            $restr = str_replace('qu', '', $matches[0]);
        }
        return $restr;
    }

    /*
     * decode加密/解密算法
     * */

    public static function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0)
    {
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
        for ($i = 0; $i <= 255; $i++)
        {
            $rndkey[$i] = ord($cryptkey[$i % $key_length]);
        }

        for ($j = $i = 0; $i < 256; $i++)
        {
            $j = ($j + $box[$i] + $rndkey[$i]) % 256;
            $tmp = $box[$i];
            $box[$i] = $box[$j];
            $box[$j] = $tmp;
        }

        for ($a = $j = $i = 0; $i < $string_length; $i++)
        {
            $a = ($a + 1) % 256;
            $j = ($j + $box[$a]) % 256;
            $tmp = $box[$a];
            $box[$a] = $box[$j];
            $box[$j] = $tmp;
            $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
        }

        if ($operation == 'DECODE')
        {
            if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16))
            {
                return substr($result, 26);
            }
            else
            {
                return '';
            }
        }
        else
        {
            return $keyc . str_replace('=', '', base64_encode($result));
        }

    }

    //获取时间范围
    /*
     * 1:今日
     * 2:昨日
     * 3:本周
     * 4:上周
     * 5:本月
     * 6:上月
     * */
    public static function get_timerange($type)
    {
        switch ($type)
        {
            case 1:
                $starttime = strtotime(date('Y-m-d 00:00:00'));
                $endtime = strtotime(date('Y-m-d 23:59:59'));
                break;
            case 2:
                $starttime = strtotime(date('Y-m-d 00:00:00', strtotime('-1 day')));
                $endtime = strtotime(date('Y-m-d 23:59:59', strtotime('-1 day')));
                break;
            case 3:
                $starttime = mktime(0, 0, 0, date("m"), date("d") - date("w") + 1, date("Y"));;
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
     * */
    public static function xml_to_array($xml)
    {
        $array = (array)(simplexml_load_string($xml));
        foreach ($array as $key => $item)
        {
            $array[$key] = self::struct_to_array((array)$item);
        }
        return $array;
    }

    /*
     * 结构转数组
     * */
    public static function struct_to_array($item)
    {
        if (!is_string($item))
        {
            $item = (array)$item;
            foreach ($item as $key => $val)
            {
                $item[$key] = self::struct_to_array($val);
            }
        }
        return $item;
    }


    /**
     * 获取函数配置
     * @param mixed $name
     * @param mixed $value
     * @return mixed
     */
    public static function C($name, $value = '')
    {
        static $_config = array();
        if (is_string($name))
        {
            if (empty($value))
            {
                return isset($_config[$name]) ? $_config[$name] : null;
            }
            else
            {
                $_config[$name] = $value;
            }
        }
        if (is_array($name))
        {
            $_config = array_merge($_config, $name);
        }
    }


    /**
     * SEESION 管理
     * @param $k
     * @param string $v
     * @return $this|mixed|Session
     */
    public static function session($k, $v = '')
    {
        $session = Session::instance();
        if (empty($v))
        {
            $session = is_null($v) ? $session->delete($k) : $session->get($k);
        }
        else
        {
            $session->set($k, $v);
        }
        return $session;
    }


    /**
     * 获取IP地址
     * @return bool
     */
    static function get_ip()
    {
        $ip = false;
        if (!empty($_SERVER["HTTP_CLIENT_IP"]))
        {
            $ip = $_SERVER["HTTP_CLIENT_IP"];
        }
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        {
            $ips = explode(", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
            if ($ip)
            {
                array_unshift($ips, $ip);
                $ip = FALSE;
            }
            for ($i = 0; $i < count($ips); $i++)
            {
                if (!preg_match("^(10|172\.16|192\.168)\.", $ips[$i]))
                {
                    $ip = $ips[$i];
                    break;
                }
            }
        }
        return ($ip ? $ip : $_SERVER['REMOTE_ADDR']);
    }

    /**
     * 产品编号 共6位,不足6位前面被0
     * @param $id
     * @param $prefixId
     * @return string
     */
    static function product_number($id, $prefixId)
    {
        $prefixId = str_pad($prefixId, 2, "0", STR_PAD_LEFT);
        $arr = array(
            'A' => '01',
            'B' => '02',
            'C' => '05',
            'D' => '03',
            'E' => '08',
            'G' => '13',
            'H' => '14',
            'I' => '15',
            'J' => '16',
            'K' => '17',
            'L' => '18',
            'M' => '19',
            'N' => '20',
            'O' => '21',
            'P' => '22',
            'Q' => '23',
            'R' => '24',
            'S' => '25',
            'T' => '26'
        );
        return array_search($prefixId, $arr) . str_pad($id, 5, "0", STR_PAD_LEFT);
    }


    /**
     * 发送邮件
     * @param $maillto 收件人
     * @param $title   主题
     * @param $content 内容
     * @return bool
     */
    static function order_maill($maillto, $title, $content)
    {
        require_once TOOLS_COMMON . 'email/emailservice.php';
        $status = EmailService::send_email($maillto, $title, $content);
        return $status;
    }

    /**
     * 查询供应商信息
     * @param $table
     * @param $productAid
     * @return mixed
     */
    static function get_supplier($table, $productAid)
    {
        $sql = "select s.* from sline_{$table} as t,sline_supplier as s where t.aid={$productAid} and t.supplierlist=s.id";
        return DB::query(Database::SELECT, $sql)->execute()->current();
    }

    /**
     * 主站域名
     * @return string
     */
    static function get_main_host()
    {
        $host = '';
        $sql = "select weburl from sline_weblist where webid=0";
        $arr = DB::query(Database::SELECT, $sql)->execute()->current();
        if (!empty($arr))
        {
            $host = $arr['weburl'];
        }
        return $host;
    }

    /**
     * COOKIE 域名
     * @return string
     */
    static function cookie_domain()
    {
        $host = $_SERVER['HTTP_HOST'];
        $sql = "select * from sline_weblist where webid=0";
        $arr = DB::query(Database::SELECT, $sql)->execute()->current();
        if (!empty($arr))
        {
            $host = str_replace($arr['webprefix'] . '.', '', parse_url($arr['weburl'], PHP_URL_HOST));
        }
        return $host;
    }

    /*
    * 判断是否是手机端
    * **/
    public static function is_mobile_device()
    {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $mobile_agents = Array("240x320", "acer", "acoon", "acs-", "abacho", "ahong", "airness", "alcatel", "amoi", "android", "anywhereyougo.com", "applewebkit/525", "applewebkit/532", "asus", "audio", "au-mic", "avantogo", "becker", "benq", "bilbo", "bird", "blackberry", "blazer", "bleu", "cdm-", "compal", "coolpad", "danger", "dbtel", "dopod", "elaine", "eric", "etouch", "fly ", "fly_", "fly-", "go.web", "goodaccess", "gradiente", "grundig", "haier", "hedy", "hitachi", "htc", "huawei", "hutchison", "inno", "ipad", "ipaq", "ipod", "jbrowser", "kddi", "kgt", "kwc", "lenovo", "lg ", "lg2", "lg3", "lg4", "lg5", "lg7", "lg8", "lg9", "lg-", "lge-", "lge9", "longcos", "maemo", "mercator", "meridian", "micromax", "midp", "mini", "mitsu", "mmm", "mmp", "mobi", "mot-", "moto", "nec-", "netfront", "newgen", "nexian", "nf-browser", "nintendo", "nitro", "nokia", "nook", "novarra", "obigo", "palm", "panasonic", "pantech", "philips", "phone", "pg-", "playstation", "pocket", "pt-", "qc-", "qtek", "rover", "sagem", "sama", "samu", "sanyo", "samsung", "sch-", "scooter", "sec-", "sendo", "sgh-", "sharp", "siemens", "sie-", "softbank", "sony", "spice", "sprint", "spv", "symbian", "tablet", "talkabout", "tcl-", "teleca", "telit", "tianyu", "tim-", "toshiba", "tsm", "up.browser", "utec", "utstar", "verykool", "virgin", "vk-", "voda", "voxtel", "vx", "wap", "wellco", "wig browser", "wii", "windows ce", "wireless", "xda", "xde", "zte");
        $is_mobile = false;
        foreach ($mobile_agents as $device)
        {
            if (stristr($user_agent, $device))
            {
                $is_mobile = true;
                break;
            }
        }
        return $is_mobile;
    }

    /**
     * @param $field
     * @param $varname
     * @param int $webid
     * @return mixed
     * 获取配置值.
     */
    public static function get_sys_para($varname, $webid = 0)
    {
        $sql = "SELECT value FROM `sline_sysconfig` WHERE varname='$varname' AND webid=$webid";
        $result = DB::query(1, $sql)->execute()->current();
        return $result['value'];
    }


    public static function getExtendContent($typeid, $extendinfo)
    {

        $model = ORM::factory('model', $typeid);
        $conTable = $model->pinyin . '_content';
        $isTongyong = false;

        $existResult = DB::query(Database::SELECT, "SHOW   TABLES   LIKE   '%" . $conTable . "'")->execute()->as_array();

        if (empty($existResult))
        {
            $isTongyong = true;
            $conTable = 'model_content';
        }
        $sql = '';
        if ($isTongyong)
        {
            $sql = "select columnname from sline_{$conTable} where isopen=1 and typeid='$typeid' and columnname like 'e_%'";
        }
        else
        {
            $sql = "select columnname from sline_{$conTable} where isopen=1 and columnname like 'e_%'";
        }
        $contentFields = DB::query(Database::SELECT, $sql)->execute()->as_array();
        $fields = array();
        foreach ($contentFields as $v)
        {
            $fields[] = $v['columnname'];
        }
        $arr = ORM::factory('extend_field')->where("typeid='$typeid' and isopen=1")->get_all();
        $contentHtml = '';
        $extendHtml = '';
        $sysconfig = ORM::factory('sysconfig')->getConfig(0);
        foreach ($arr as $row)
        {
            $default = !empty($extendinfo[$row['fieldname']]) ? $extendinfo[$row['fieldname']] : '';
            if (in_array($row['fieldname'], $fields))
            {
                $contentHtml .= '<div id="content_' . $row['fieldname'] . '"  data-id="' . $row['fieldname'] . '" class="product-add-div content-hide"><div class="add-class">';
                $contentHtml .= '<dl>
                            <dt>' . $row['description'] . '：</dt>
                            <dd>
                                <div>' . self::getEditor($row['fieldname'], $default, $sysconfig['cfg_admin_htmleditor_width'], 300, 'Sline', '0', '0') . '</div>
                            </dd>
                        </dl>';
                $contentHtml .= '</div></div>';
                continue;
            }
            if ($row['fieldtype'] == 'editor')
            {
                $head = '<div class="add-class">';
                $head .= '<dl>
                            <dt>' . $row['description'] . '：</dt>
                            <dd>
                                <div>' . self::getEditor($row['fieldname'], $default, $sysconfig['cfg_admin_htmleditor_width'], 300, 'Sline', '0', '0') . '</div>
                            </dd>
                        </dl>';
                $head .= '</div>';
                $extendHtml .= $head;
            }
            else if ($row['fieldtype'] == 'text')
            {
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

    public static function getEditor($fname, $fvalue, $nwidth = "700", $nheight = "350", $etype = "Sline", $ptype = '', $gtype = "print", $jsEditor = false)
    {

        require(BASEPATH . '/res/vendor/slineeditor/ueditor.php');
        $UEditor = new UEditor();
        $UEditor->basePath = '/res/vendor/slineeditor/';
        $nheight = $nheight == 400 ? 300 : $nheight;
        $config = $events = array();
        $GLOBALS['tools'] = empty($toolbar[$etype]) ? $GLOBALS['tools'] : $toolbar[$etype];
        $config['toolbars'] = $GLOBALS['tools'];
        $config['minFrameHeight'] = $nheight;
        $config['initialFrameHeight'] = $nheight;
        $config['initialFrameWidth'] = $nwidth;
        $config['autoHeightEnabled'] = false;
        if (!$jsEditor)
        {
            $code = $UEditor->editor($fname, $fvalue, $config, $events);
        }
        else
        {
            $code = $UEditor->jseditor($fname, $fvalue, $config, $events);
        }

        if ($gtype == "print")
        {
            echo $code;
        }
        else
        {
            return $code;
        }

    }
    public static function getExtendTable($typeid)
    {
        $row = ORM::factory('model', $typeid)->as_array();
        return 'sline_' . $row['addtable'];
    }

    public static function getExtendInfo($typeid, $productid)
    {
        //$table = self::$extend_table_arr[$typeid];
        $table = self::getExtendTable($typeid);
        $sql = "select * from {$table} where productid='$productid'";
        $arr = DB::query(1, $sql)->execute()->as_array();
        return $arr[0];
    }

    /*
    * 生成扩展字段填写form
    * */
    public static function genExtendData($typeid, $extendinfo = array())
    {
        $sysconfig = ORM::factory('sysconfig')->getConfig(0);
        $arr = ORM::factory('extend_field')->where("typeid='$typeid' and isopen=1")->get_all();
        $out = '';
        foreach ($arr as $row)
        {
            $default = !empty($extendinfo[$row['fieldname']]) ? $extendinfo[$row['fieldname']] : '';
            if ($row['fieldtype'] == 'editor')
            {
                $head = '<div class="add-class">';
                $head .= '<dl>
                            <dt>' . $row['description'] . '：</dt>
                            <dd>
                                <div>' . self::getEditor($row['fieldname'], $default, $sysconfig['cfg_admin_htmleditor_width'], 200, 'Sline', '0', '0') . '</div>
                            </dd>
                        </dl>';
                $head .= '</div>';
                $out .= $head;
            }
            else if ($row['fieldtype'] == 'text')
            {
                $head = '<div class="add-class">';
                $head .= '<dl>
                            <dt>' . $row['description'] . '：</dt>
                            <dd>
                                <input type="text" name="' . $row['fieldname'] . '"  value="' . $default . '" class="set-text-xh text_300 mt-2">
                            </dd>
                        </dl>';
                $head .= '</div>';
                $out .= $head;
            }
        }
        echo $out;
    }

    /*
    * 根据,分隔的字符串获取图标数组(修改页面用)
    * */
    public static function getSelectedIcon($iconlist)
    {
        $iconid_arr = explode(',', $iconlist);
        $iconarr = array();
        foreach ($iconid_arr as $k => $v)
        {
            $icon = DB::select()->from('icon')->where('id', '=', $v)->execute()->current();//ORM::factory('icon', $v);
            if ($icon)
                $iconarr[] = $icon;
        }
        return $iconarr;
    }

    /*
      * 根据,分隔字符串获取上传的图片数组(修改页面用)
      * */
    public static function getUploadPicture($piclist)
    {
        $out = array();
        $arr = self::removeEmpty(explode(',', $piclist));
        foreach ($arr as $row)
        {
            $picinfo = explode('||', $row);
            $out[] = array('litpic' => $picinfo[0], 'desc' => isset($picinfo[1]) ? $picinfo[1] : '');
        }
        return $out;
    }

    /*
     * 清空数组里的空值
     * */
    public static function removeEmpty($arr)
    {
        $newarr = array_diff($arr, array(null, 'null', '', ' '));
        return $newarr;
    }

    /**
     * @function 加载后台皮肤
     * @return string
     */
    public static function get_skin_css()
    {
        $out = '';
        $cfg_skin_back_id = DB::select('value')
                              ->from('sysconfig')
                              ->where('varname', '=', 'cfg_skin_back_id')
                              ->execute()
                              ->get('value');
        if ($cfg_skin_back_id)
        {
            $file = DB::select('file')
                      ->from('skin_back')
                      ->where('id', '=', $cfg_skin_back_id)
                      ->execute()
                      ->get('file');

            $tfile = BASEPATH . Common::get_sys_para('cfg_admin_dirname') . "/public/css/" . $file;
            if (file_exists($tfile))
            {
                $out .= "<link type=\"text/css\" href=\"". Common::get_web_url(0). '/' .Common::get_sys_para('cfg_admin_dirname') . "/public/css/" . $file."\" rel=\"stylesheet\" />";
            }
        }

        return $out;
    }
}
