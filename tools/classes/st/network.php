<?php defined('SYSPATH') or die('No direct script access.');

/**
 * 网络函数
 * Class Functions
 */
class St_Network
{
    /**
     * @function 远程请求
     * @param $url
     * @param string $postfields
     * @param string $method
     * @param array $headers
     * @return mixed
     */
    static function http($url, $postfields='', $method='GET', $headers=array())
    {
        if(strpos($url,'http') === false)
        {
           return;
        }

        $ci=curl_init();
        curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ci, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ci, CURLOPT_TIMEOUT, 30);
        if($method=='POST')
        {
            curl_setopt($ci, CURLOPT_POST, TRUE);
            if($postfields!='')
            {
                curl_setopt($ci, CURLOPT_POSTFIELDS, $postfields);
            }
        }

        curl_setopt($ci, CURLOPT_URL, $url);
        $response=curl_exec($ci);
        curl_close($ci);
        return $response;
    }

    /*
    * 检测链接是否是SSL连接
    * @return bool
    */
    public static function is_ssl()
    {
        if (!isset($_SERVER['HTTPS'])) return FALSE;
        if ($_SERVER['HTTPS'] === 1)
        { //Apache
            return TRUE;
        }
        elseif ($_SERVER['HTTPS'] === 'on')
        { //IIS
            return TRUE;
        }
        elseif ($_SERVER['SERVER_PORT'] == 443)
        { //其他
            return TRUE;
        }
        return FALSE;
    }



}