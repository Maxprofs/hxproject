<?php defined('SYSPATH') or die('No direct script access.');

/**
 * 登陆信息管理
 * Class Login
 */
Class Model_Member_Login extends ORM
{

    //登陆设备
    public static $source = array(
        '1' => 'pc',
        '2' => 'mobile',
        '3' => 'xcx',
    );

    //登陆角色
    public static $role = array(
        '1' => 'member',
        '2' => 'admin',
        '3' => 'supplier',
    );
    /**
     * 登陆检测,
     * 返回登陆生效状态码
     */
    public static function check_login($data)
    {
        if(!self::session_login())
        {
            if(!self::cookies_login())
            {
                if($data)
                {
                    if(!self::storage_login($data))
                    {
                        return 0;
                    }
                    return 3;
                }
                return 0;
            }
            return 2;
        }
        return 1;
    }


    public static function login_init($member)
    {
        //写入Cookie_Session
        Model_Member::write_session($member);
        //删除Cookie
        Common::session('login_num', null);
        //清空红包信息
        Common::session('envelope_id',null);
        $serectkey =Common::authcode($member['mid'] . '||' . $member['pwd'], '');
        return array('secret'=>$serectkey,'time'=>time());
    }

    //发送快速登录信息
    public static function send_quick_code($phone)
    {
        $member = Model_Member::member_find($phone);
        if (empty($member))
        {
            $data = array('msg' => __("error_user_noexists"), 'status' => 0);
            return $data;
        }
        $code = rand(1000, 9999);
        if(Common::session('quick_login_send_time'))
        {
            $send_time=intval(Common::session('quick_login_send_time'));
            //频繁发送检查
            if((time()-$send_time)<=120)
            {
                $data = array('msg' => __("error_send_quick_msgcode"), 'status' => 1,'type'=>1);
                return $data;
            }
        }
        $status = json_decode(St_SMSService::send_member_msg($phone,NoticeCommon::MEMBER_QUICK_LOGIN_CODE_MSGTAG,"","",$code));
        if($status->Success){
            Common::session('quick_login_send', 1);
            Common::session('quick_login_send_code', $code);
            Common::session('quick_login_send_time', time());
            $data['status']=1;
        }else{
            $data['status']=0;
            $data['msg']=$status->Message;
        }
        return $data;
    }

    //短信快速登录检查
    public static function sms_quick_login_check($phone,$sms_code)
    {
        //检测用户是否存在
        $member = Model_Member::member_find($phone);
        if (empty($member))
        {
            $data = array('msg' => __("error_user_noexists"), 'status' => 0);
            return $data;
        }
        //动态码为空
        if(!$sms_code)
        {
            $data = array('msg' => __("error_msg_not_empty"), 'status' => 0);
            return $data;
        }
        //动态码不正确
        if(!Common::session('quick_login_send_code')||$sms_code!=Common::session('quick_login_send_code'))
        {
            $data = array('msg' => __("error_msgcode"),'status' => 0);
            return $data;
        }
        $send_time=intval(Common::session('quick_login_send_time'));
        //时效检验
        if(time()>($send_time+15*60))
        {
            $data = array('msg' => __("error_overtime_msgcode"), 'status' => 0);
            return $data;
        }
        Common::session('quick_login_send_code', null);
        Common::session('quick_login_send_time', null);
        Common::session('quick_login_send',null);
        $data['status']=1;
        $data['member']=$member;
        return $data;
    }

    //登陆检测并返回登陆用户信息
    public static function check_login_info($data=null)
    {
        $member=array();
        if($status=self::check_login($data))
        {
            if(intval($status)>0)
            {
                $login_type=intval($status);
                $member_info=array();
                switch ($login_type){
                    case 1:
                        $session_member= Common::session('member');
                        $member_info=Model_Member::get_member_info($session_member['mid']);
                        break;
                    case 2:
                        $cookie_member= Cookie::get('st_userid');
                        $member_info=Model_Member::get_member_info($cookie_member);
                        break;
                    case 3:
                        $info = explode('||', Common::authcode($data['md5']));
                        if (isset($info[0]) && $info[1])
                        {
                            $mid = Common::remove_xss($info[0]);
                            $upwd = Common::remove_xss($info[1]);
                            $model = ORM::factory('member')->where("mid='{$mid}' and pwd='{$upwd}'")->find();
                            if (isset($model->mid))
                            {
                                $member_info = $model->as_array();
                            }
                        }
                        break;
                }
                $member['login_type']=$login_type;
                $member['nickname']=$member_info['nickname'];
                $member['logintime']=$member_info['logintime'];
                $member['mid']=$member_info['mid'];
                $member['bflg']=$member_info['bflg'];
            }
            return $member;
        }
        return $member;
    }

    //h5本地存储登陆状态检测
    public static function storage_login($data)
    {
        //
        $info = explode('||', Common::authcode($data['md5']));
        if (isset($info[0]) && $info[1])
        {
            $mid = Common::remove_xss($info[0]);
            $upwd = Common::remove_xss($info[1]);
            $model = ORM::factory('member')->where("mid='{$mid}' and pwd='{$upwd}'")->find();
            if (isset($model->mid))
            {
                //本地登陆过期
                if(time()>(intval($data['logintime'])+7200*1000))
                {
                    return false;
                }
                self::update_login_status($model->as_array());
                return true;
            }
            return false;
        }
        return false;
    }

    //cookies登陆检测
    public static function cookies_login()
    {
        $cookie_member= Cookie::get('st_userid');
        $secret = Cookie::get('st_secret');
        if($cookie_member&&$secret)
        {
            $info = explode('||', Common::authcode($secret));
            if (isset($info[0]) && $info[1]&&($cookie_member==$info[0]))
            {
                $mid = Common::remove_xss($info[0]);
                $upwd = Common::remove_xss($info[1]);
                $model = ORM::factory('member')->where("mid='{$mid}' and pwd='{$upwd}'")->find();
                if (isset($model->mid))
                {
                    $member = $model->as_array();
                    if(!empty($member))
                    {
                        self::update_login_status($member);
                        return true;
                    }
                    return false;
                }
                return false;
            }
            return false;
        }
        return false;
    }

    //session登陆检测
    public static function session_login()
    {
        $member = Common::session('member');
        if($member)
        {
            $member=Model_Member::get_member_info($member['mid']);
            if($member)
            {
                self::update_login_status($member);
                return true;
            }
            return false;
        }
        return false;
    }

    //更新登陆状态
    public static function update_login_status($member)
    {
        if (is_null($member))
        {
            $user = empty($member['email']) ? $member['mobile'] : $member['email'];
        }
        //昵称
        if (empty($member['nickname']) && !empty($user))
        {
            $member['nickname'] = substr_replace($user, '****', floor(strlen($user) / 2) - 2, 4);
        }
        //没有会员图片
        if (empty($member['litpic']))
        {
            $member['litpic'] = Model_Member::member_nopic();
        }

        //登录信息更新写入seesion
        Common::session('member', array('mid' => $member['mid'], 'nickname' => $member['nickname'], 'litpic' => $member['litpic']));

        //登录信息更新写入cookie
        Cookie::set('st_username', $member['nickname'], 7200);
        Cookie::set('st_userid', $member['mid'], 7200);

        //清空登录次数
        Common::session('login_num', null);
        //清空红包信息
        Common::session('envelope_id',null);
    }

    /**
     * @function 退出登录
     */
    public static function login_out()
    {
        //清除登录Session
        Common::session('member', NULL);
        //清除登录Cookie
        Cookie::delete('st_username');
        Cookie::delete('st_userid');
        Cookie::delete('st_secret');
    }
}