<?php defined('SYSPATH') or die('No direct script access.');

/**
 * 微信快速登陆
 * Class Controller_Index
 */
class Controller_Mobile_Share_Wxclient extends Stourweb_Controller
{

    //初始化设置
    public function before()
    {
        parent::before();
    }

    //首页
    public function action_index()
    {

    }

    public function action_ajax_share_wx_info()
    {
        $config = Model_Share_Weixin::get_config();
        $url    =$_POST['url'];
        try
        {
            $ticket = Model_Share_Weixin::get_ticket($config['appid'], $config['appsecret']);
            if (!$ticket)
            {
                throw new Exception('ticket获取失败');
            }
            $noncestr = Model_Share_Weixin::get_wx_noncestr();
            $timestamp = time();
            $queryArr = array('jsapi_ticket' => $ticket, 'noncestr' => $noncestr, 'timestamp' => $timestamp, 'url' => $url);
            $queryStr = '';
            foreach ($queryArr as $k => $v)
            {
                $queryStr .= $k . '=' . $v . '&';
            }
            $queryStr = substr($queryStr, 0, -1);
            $signature = sha1($queryStr);
            //  站点基础信息
            $web_basc_info = Model_Share_Weixin::get_wx_share_default_info();
            $wx_data = array(
                'appid'     => $config['appid'],
                'ticket'    => $ticket,
                'noncestr'  => $noncestr,
                'timestamp' => $timestamp,
                'signature' => $signature,
                'url'       => $url,
                'default'   => $web_basc_info,
            );
            $rtn = array('status'=>true, 'msg'=>'', 'data'=>$wx_data);
        }
        catch (Exception $excep)
        {
            $rtn = array('status'=>false, 'msg'=> $excep->getMessage());
        }
        echo json_encode($rtn);
        exit;
    }




}