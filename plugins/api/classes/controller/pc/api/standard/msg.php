<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Pc_Api_Standard_Msg extends Controller_Pc_Api_Base
{

    public function before()
    {
        parent::before();
    }

    public function action_sendmsg()
    {
        $mobile = St_Filter::remove_xss($this->request_body->content->mobile);
        if($mobile)
        {
            $code =  self::get_rand_code($mobile,5);//验证码
            $content = "本次操作验证码{$code},千万不要告诉别人!";
            $flag = json_decode(St_SMSService::send_msg($mobile,'',$content));
            if($flag->Success)//发送成功
            {

                $msgcode = md5($code.$mobile);
                $result = array('status'=>true,'msg'=>'验证码发送成功','secret_code'=>$msgcode);
            }
            else
            {
                $result = array('status'=>false,'msg'=>'验证码发送失败，请重试'.$flag->Message);
            }
            $this->send_datagrams($this->client_info['id'], $result, $this->client_info['secret_key']);
        }
    }



    //生成随机数
    public static function get_rand_code($mobile,$num)
    {
        $out = '';
        for ($i = 1; $i <= $num; $i++)
        {
            $out .= mt_rand(0, 9);
        }
        $session = Session::instance();
        $session->set('code_'.$mobile,$out);
        return $out;

    }

}