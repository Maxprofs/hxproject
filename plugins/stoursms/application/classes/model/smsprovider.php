<?php defined('SYSPATH') or die('No direct access allowed.');
// require TOOLS_COMMON . '/sms/ismsprovider.php';
// http://mb345.com:999/ws/SelSum.aspx?CorpID=*&Pwd=*  余额查询
// http://mb345.com:999/ws/BatchSend2.aspx?CorpID=*&Pwd=*&Mobile=*&Content=*&SendTime=*&cell=* 
class SMSProvider
{
    var $_apiUrl = 'http://mb345.com:999/ws/'; //短信接口地址
    var $_account_data = array();

    function __construct()
    {
        $sql = "SELECT * from sline_sysconfig where varname='cfg_sms_username' or varname='cfg_sms_password'";
        $rows = DB::query(Database::SELECT, $sql)->execute()->as_array();
        foreach ($rows as $row)
        {
            if ($row['varname'] == 'cfg_sms_username')
                $this->_account_data['account'] = $row['value'];
            if ($row['varname'] == 'cfg_sms_password')
                $this->_account_data['password'] = $row['value'];
        }
    }


    /*
	 * 发送短消息
	 *@param string $phone,接收手机号
	 *@param string $prefix,短信签名,如"xx旅行网",短信中显示【xx旅行网】
	 *@param string $content,短信内容.
     *@return json {"Success":false,"Message":"短信帐户余额不足，可用短信0条，需要1条","Data":null}
     *@json {"Success":执行是否成功,"Message":执行相关提示、错误等说明信息,"Data":执行返回结果数据}
	 * */

    public function send_msg($phone, $content)
    {
        // http://mb345.com:999/ws/BatchSend2.aspx?CorpID=*&Pwd=*&Mobile=*&Content=*&SendTime=*&cell=* 
        $encode = mb_detect_encoding($content, array("ASCII","UTF-8","GB2312","GBK","BIG5"));
        $msg=array(
            'Message'=>'',
            'success'=>true,
            '–1'=>'账号未注册',
            '–2'=>'其他错误',
            '–3'=>'帐号或密码错误',
            '–5'=>'余额不足，请充值',
            '–6'=>'定时发送时间不是有效的时间格式',
            '-7'=>'提交信息末尾未签名，请添加中文的企业签名【 】',
            '–8'=>'发送内容需在1到300字之间',
            '-9'=>'发送号码为空',
            '-10'=>'定时时间不能小于系统当前时间',
            '-100'=>'IP黑名单',
            '-102'=>'账号黑名单',
            '-103'=>'IP未导白',
        );


        $init = array(
            'CorpID' => $this->_account_data['account'],
            'Pwd'=> $this->_account_data['password'],
            'Mobile' => $phone,
            'Content' => iconv($encode,"GB2312//IGNORE",$content)
        );
        
        $params = http_build_query($init); //生成参数数组
        $url = $this->_apiUrl.'BatchSend2.aspx?'.$params;

        $index = $this->http($url);
        if ((int)$index>0) {
            return array('Success'=>$msg['success']);
        }else{
            return array('Message'=>$msg[$index]);
        }
        
    }

    /*
    * @查询短信帐户余额(条数)
    * @return 从短信网关直接返回短信条数
    * @$id是传递给query_modify_balance使用的
    * */
    public function query_balance($id='')
    {
        $data = array(
            'CorpID' => $this->_account_data['account'],
            'Pwd'=> $this->_account_data['password']
        );
        $params = http_build_query($data); //生成参数数组
        $url = $this->_apiUrl.'SelSum.aspx?'.$params;
        $sms_count=$this->http($url);
        $msg=$this->query_modify_balance($id,$sms_count);
        if ($msg) {
            return $sms_count;
        }else{
            return '查询失败';
        }
        
    }
    /*
    * @修改sline_sms_provider
    * @return 从短信网关直接返回短信条数
    * */
    public function query_modify_balance($id,$count)
    {
        $sql = "UPDATE `sline_sms_provider` SET `sms_count`=".(int)$count." WHERE `id`=".(int)$id;
        try {
            DB::query(Database::SELECT, $sql)->execute()->as_array();
        } catch (Exception $e) {
            return false;
        }
        return true;
    }
    /*
     * 查询发送记录接口
     * @param string begindate //发送记录日期 如2014-05-06,表示2014-5-6以后的发送记录
     * @return json {"Success":true,"Message":"","Data":[]}
     * @json {"Success":执行是否成功,"Message":执行相关提示、错误等说明信息,"Data":执行返回结果数据}
     * */
    public function query_send_log($begindate)
    {
        $init = array(
            'action' => 'querysmssendlog',
            'sendtime' => $begindate
        );
        $data = array_merge($this->_account_data, $init); //合并数组
        $params = http_build_query($data); //生成参数数组
        $url = $this->_apiUrl . $params;
        return $this->http($url);
    }


    /*
     * 查询帐户冲值记录
     * @param string begindate //充值记录日期 如2014-05-06,表示2014-5-6以后的充值记录
     * @return json {"Success":true,"Message":"","Data":[]}
     * @json {"Success":执行是否成功,"Message":执行相关提示、错误等说明信息,"Data":执行返回结果数据}
     * */
    public function query_buy_log($begindate)
    {

        $init = array(
            'action' => 'querysmsbuylog',
            'buytime' => $begindate
        );
        $data = array_merge($this->_account_data, $init); //合并数组
        $params = http_build_query($data); //生成参数数组
        $url = $this->_apiUrl . $params;

        return $this->http($url);
    }

    public function query_send_fail_Log($begindate)
    {
        $init = array(
            'action'=>'querysmssendlog',
            'sendtime'=>$begindate,
            'sendstatus'=>0
        );
        $data = array_merge($this->_account_data,$init);//合并数组
        $params = http_build_query($data);//生成参数数组
        $url = $this->_apiUrl.$params;
        return $this->http($url);
    }

    /*
     * 查询系统参数(可购买条数等信息)
     * @return json {"Success":true,"Message":null,"Data":{"IsSMSInterfaceEnable":true,"IsBalanceNotEnough":true,"TotalSMSBalance":37961.8,"TotalSaleSMS":865916.0}}
     * */
    public function query_service_info()
    {
        $init = array(
            'action' => 'queryservicestatus'
        );
        $data = array_merge($this->_account_data, $init); //合并数组
        $params = http_build_query($data); //生成参数数组
        $url = $this->_apiUrl . $params;
        return $this->http($url);
    }


    /*
     * 接口请求函数
     * @param string url
     * @param string postfields,post请求附加字段.
     * @return $response
     * */
    private function http($url, $postfields = '', $method = 'GET')
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
}