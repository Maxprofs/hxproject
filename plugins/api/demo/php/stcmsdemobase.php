<?php
define('BASEPATH', str_replace("\\", '/', dirname(__FILE__)));


abstract class StcmsDemoBase
{
    protected $client_id = "1";
    protected $clinet_secret_key = "5f5c92a39a294e6ca414be8d054c1bda";
    protected $host = "http://www.v6.com/";
    protected $version = "1.0";

    public abstract function exec();

    protected function send_request($method, $content)
    {
        $request_result = array(
            'success' => false,
            'message' => '',
            'body' => null
        );

        $api_envelope = array(
            'version' => $this->version,
            'body' => null,
            'signature' => ""
        );

        $api_envelope_body = array(
            'client_id' => $this->client_id,
            'success' => true,
            'message' => "",
            'timestamp' => time(),
            'content' => $content
        );

        $api_envelope['body'] = base64_encode(json_encode($api_envelope_body));
        $api_envelope['signature'] = md5($api_envelope['body'] . $this->clinet_secret_key);

        $request_param = json_encode($api_envelope);
        $uri = $this->host . "/{$method}";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $uri);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request_param);
        $return = curl_exec($ch);
        curl_close($ch);

        $return_object = json_decode($return);
        if (!is_object($return_object))
        {
            $request_result['message'] = "请求返回的报文格式不正确";
            return $request_result;
        }

        if ($return_object->version != $this->version)
        {
            $request_result['message'] = "报文版本号不匹配";
            return $request_result;
        }

        if ($return_object->signature != md5($return_object->body . $this->clinet_secret_key))
        {
            $request_result['message'] = "签名认证失败";
            return $request_result;
        }

        $request_result['body'] = json_decode(base64_decode($return_object->body));
        if ($request_result['body']->success == false)
        {
            $request_result['message'] = $request_result['body']->message;
            return $request_result;
        }

        $request_result['success'] = true;
        return $request_result;
    }

}

?>
