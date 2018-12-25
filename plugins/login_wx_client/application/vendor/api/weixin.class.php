<?php

/**
 * PHP 微信
 *
 */
class weixinPHP
{
    var $appid;
    var $appkey;
    var $callback_url;
    var $access_token;
    var $state;//可回调验证参数
    var $scope = 'snsapi_userinfo'; //授权方法

    function __construct($appid, $appkey, $callback_url, $state, $access_token = NULL)
    {
        $this->appid = $appid;
        $this->appkey = $appkey;
        $this->callback_url = $callback_url;
        $this->state = $state;
        $this->access_token = $access_token;
    }

    /**
     * 初始化回调设置
     * @return string
     */
    function login_url()
    {
        $params = array(
            'appid' => $this->appid,
            'redirect_uri' => $this->callback_url,
            'response_type' => 'code',
            'scope' => $this->scope,
            'state' => $this->state,
        );
        return 'https://open.weixin.qq.com/connect/oauth2/authorize?' . http_build_query($params) . '#wechat_redirect';
    }

    /**
     * 获取动态口令
     * @param $code
     * @return array|mixed
     */
    function access_token($code)
    {
        $params = array(
            'appid' => $this->appid,
            'secret' => $this->appkey,
            'code' => $code,
            'grant_type' => 'authorization_code',
        );
        $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?' . http_build_query($params);
        $result_str = $this->http($url);

        $json_r = array();
        if ($result_str != '')
        {
            $json_r = json_decode($result_str, true);
        }
        return $json_r;
    }

    /**
     * 获取用户信息
     * @param $openid
     * @param $token
     * @return array|mixed
     */
    function get_user_info($openid, $token)
    {
        $params = array(
            'access_token' => $token,
            'openid' => $openid,
            'lang' => 'zh_CN'
        );
        $url = 'https://api.weixin.qq.com/sns/userinfo';
        return $this->api($url, $params);
    }

    /**
     * 封装URL参数
     * @param $url
     * @param $params
     * @param string $method
     * @return array|mixed
     */
    function api($url, $params, $method = 'GET')
    {
        if ($method == 'GET')
        {
            $result_str = $this->http($url . '?' . http_build_query($params));
        }
        else
        {
            $result_str = $this->http($url, http_build_query($params), 'POST');
        }
        $result = array();
        if ($result_str != '') $result = json_decode($result_str, true);
        return $result;
    }

    /**
     * CURL提交参数
     * @param $url
     * @param string $postfields
     * @param string $method
     * @param array $headers
     * @return mixed
     */
    function http($url, $postfields = '', $method = 'GET', $headers = array())
    {
        $ci = curl_init();
        curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ci, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ci, CURLOPT_TIMEOUT, 30);
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