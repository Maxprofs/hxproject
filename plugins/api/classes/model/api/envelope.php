<?php defined('SYSPATH') or die('No direct access allowed.');

/*
 * api通信协议包装类
 */

class Model_Api_Envelope
{

    private static $_version = '1.0';
    private $_envelope = array();

    /*
     * 传入参数并创建一个api通信协议包装类实例
     */
    public function  __construct($client_id, $content, $success = true, $message = "")
    {
        //api客户端id
        $this->_envelope['client_id'] = $client_id;
        //api执行是否成功完成，此项主要在响应时用，在请求时可忽略
        $this->_envelope['success'] = $success;
        //api执行附加备注说明信息，比如错误详细等
        $this->_envelope['message'] = $message;
        //时件戳
        $this->_envelope['timestamp'] = time();
        //通信主体内容
        $this->_envelope['content'] = $content;
    }

    /*
     * 根据当前api通信内容生成带安全签名的发送报文
     */
    public function generate_datagrams($secret_key)
    {
        $body = base64_encode(json_encode($this->_envelope));

        $result = array(
            'version' => self::$_version,
            'body' => $body,
            'signature' => md5($body . $secret_key)
        );

        return json_encode($result);
    }

    /*
     * 分析并验证api客户端的请求报文
     */
    public static function analyse_datagrams($datagrams)
    {
        $result = array(
            'success' => false,
            'message' => '',
            'client' => null,
            'body' => null
        );

        $request = json_decode($datagrams);
        if (empty($request))
        {
            $result['message'] = "请求报文无法被解析";
            return $result;
        }

        if ($request->version != self::$_version)
        {
            $result['message'] = "请求报文版本不匹配";
            return $result;
        }

        $body = $request->body;
        $body = json_decode(base64_decode($body));
        if (empty($body))
        {
            $result['message'] = "请求报文体无法被解析";
            return $result;
        }
        $result['body'] = $body;

        $client_id = $body->client_id;
        $client_info = Model_Api_Client::get_info($client_id);
        if (empty($client_info) || $client_info['status'] == '0')
        {
            $result['message'] = "无法找到对应的API客户端信息或API客户端被停用";
            return $result;
        }
        $result['client'] = $client_info;

        $secret_key = $client_info['secret_key'];
        $signature = md5($request->body . $secret_key);
        if ($signature != $request->signature)
        {
            $result['message'] = "请求报文签名认证失败";
            return $result;
        }

        $result['success'] = true;
        return $result;

    }

}