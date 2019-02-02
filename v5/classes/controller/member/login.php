<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Class Controller_Member_Login
 * 会员登陆
 */
class Controller_Member_Login extends Stourweb_Controller
{

    private $_mid;

    public function before()
    {
        parent::before();
        $user = Model_Member::check_login();
        $this->_mid = $user['mid'] ? $user['mid'] : 0;

    }

    //登录首页
    public function action_index()
    {

        $redirect_url = St_Filter::remove_xss(Arr::get($_GET, 'redirecturl'));
        if (empty($redirect_url)) {
            $fromurl = rtrim($GLOBALS['cfg_basehost'], '/') . '/member/';
        }
        else
        {
            $fromurl = strip_tags($redirect_url);
            $fromurl = St_String::filter_quotes($fromurl);
        }
        //判断是否是登陆状态
        if (!empty($this->_mid)) {
            $this->request->redirect($fromurl);
        }

        $bool = Common::session('login_num') ? false : true;
        $send = Common::session('quick_login_send') ? false : true;
        $sms = DB::select()->from('sms_msg')->where('msgtype="login_msgcode"')->execute()->current();
        $this->assign('isopen', $sms['isopen']);
        if(!$send)
        {
            $send_waiting=intval(Common::session('quick_login_send_time'))+120-time();
            $this->assign('send_waiting', $send_waiting>0?$send_waiting:0);
        }
        $this->assign('one', $bool);

        Common::session('login_referer', $fromurl);
        //token
        $token = md5(time());
        Common::session('crsf_code', $token);
        $this->assign('frmcode', $token);
        $this->assign('fromurl', $fromurl);
        $this->display('member/login');
    }

    public function action_ajax_login_out()
    {
        $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $this->cmsurl;
        $fromurl = strpos($referer, 'member') || strpos($referer, 'login') || strpos($fromurl, 'register') ? $GLOBALS['cfg_basehost'] : $referer;
        Model_Member_Login::login_out();
        exit(json_encode(array('status' => 1,'url'=>$fromurl)));
    }

    //退出登陆
    public function action_loginout()
    {
        $referer = $_SERVER['HTTP_REFERER'];//来源地址
        Model_Member::login_out();
        if (file_exists(BASEPATH . '/data/ucenter.php')) {
            include_once BASEPATH . '/data/ucenter.php';
        }
        if (defined('UC_API') && include_once BASEPATH . '/uc_client/client.php') {
            $loginoutjs = uc_user_synlogout();
        }
        echo $loginoutjs;
        echo "<script>window.location.href='" . $referer . "'</script>";
        exit();

    }

    //ajax登陆
    public function action_ajax_login()
    {
        $ucsynlogin = '';
        $loginName = Arr::get($_POST, 'loginname');
        $loginPwd = Arr::get($_POST, 'loginpwd');
        $frmCode = Arr::get($_POST, 'frmcode');
        //安全校验码验证
        $orgCode = Common::session('crsf_code');
        if ($orgCode != $frmCode&&!empty($frmCode)) {
            $out['status'] = 0;
            $out['msg'] = __("error_frmcode");
            echo json_encode($out);
            exit;
        }
        $code = Arr::get($_POST, 'code');
        //验证码检测
        if(!empty($code)&&!Captcha::valid($code))
        {
            Common::session('login_num', 1);
            $message = array('msg' => __("error_code"), 'status' => 0);
            exit(json_encode($message));
            exit;
        }
        $user = Model_Member::login($loginName, $loginPwd, 1);
        if (!$user) {
            $message = array('msg' =>'账号密码错误！', 'status' => 0);
            exit(json_encode($message));
            exit;
        }
        if ($user['isopen']==0) {
            $message = array('msg' =>'账号已冻结请联系您的服务网点！', 'status' => 0);
            exit(json_encode($message));
            exit;
        }
        $status = !empty($user) ? 1 : 0;
        Common::session('captcha_response', null);
        #api{{
        if (file_exists(BASEPATH . '/data/ucenter.php')) {
            include_once BASEPATH . '/data/ucenter.php';
        }
        if (defined('UC_API') && include_once BASEPATH . '/uc_client/client.php') {

            //检查帐号
            list($uid, $loginname, $password, $email) = uc_user_login($loginName, $loginPwd);

            if ($uid > 0) {

                //同步登录的代码
                $ucsynlogin = uc_user_synlogin($uid);

                //ucenter自动注册
                $data = array(
                    'email' => $email,
                    'nickname' => $loginname,
                    'pwd' => $password,
                    'regtype' => 1
                );

                if (preg_match("/^1[3-8]+\d{9}$/", $loginname)) {
                    $data['mobile'] = $loginname;
                    $data['regtype'] = 0;
                }

                if(empty($user))
                {
                    $member = Model_Member::register($data);
                    if ($member) {
                        $ucUser = Model_Member::login($email, $password, 1);
                        $status = !empty($ucUser) ? 1 : 0;
                    } else {
                        $status = 0;
                    }
                }


            }
            else if ($uid == -1 && $status == 1) {
                $uid = uc_user_register($loginname, md5($password), '');
                if ($uid > 0) {
                    $ucsynlogin = uc_user_synlogin($uid);
                }
            }
        }
        #/aip}}

        $out = array();
        if($status)
        {
            $out =Model_Member_Login::login_init($user);
        }
        $out['status'] = $status;
        $out['js'] = $ucsynlogin;
        echo json_encode($out);

    }

    public function action_ajax_send_code()
    {
        $code = Common::remove_xss(Arr::get($_POST, 'code'));
        //验证码检查
        if(!empty($code)&&!Captcha::valid($code))
        {
            Common::session('login_num', 1);
            $message = array('msg' => __("error_code"), 'status' => 0);
            exit(json_encode($message));
        }
        $validataion = Validation::factory($this->request->post());
        $validataion->rule('phone', 'not_empty');
        $validataion->rule('phone', 'phone');
        //账号合法性检查
        if (!$validataion->check())
        {
            Common::session('login_num', 1);
            $message = array('msg' => __("error_user_phone"), 'status' => 0);
            exit(json_encode($message));
        }
        $phone = Common::remove_xss(Arr::get($_POST, 'phone'));
        $return=Model_Member_Login::send_quick_code($phone);
        exit(json_encode($return));
    }

    public function action_ajax_check_sms_code()
    {
        //验证码检查
        $code = Common::remove_xss(Arr::get($_POST, 'code'));
        if(!empty($code)&&!Captcha::valid($code))
        {
            Common::session('login_num', 1);
            $message = array('msg' => __("error_code"), 'status' => 0);
            exit(json_encode($message));
        }
        $validataion = Validation::factory($this->request->post());
        $validataion->rule('phone', 'not_empty');
        $validataion->rule('phone', 'phone');
        //账号合法性检查
        if (!$validataion->check())
        {
            Common::session('login_num', 1);
            $message = array('msg' => __("error_user_phone"), 'status' => 0);
            exit(json_encode($message));
        }
        $phone = Common::remove_xss(Arr::get($_POST, 'phone'));
        $sms_code = Common::remove_xss(Arr::get($_POST, 'sms_code'));
        $return=Model_Member_Login::sms_quick_login_check($phone,$sms_code);
        if($return['status']==1)
        {
            Common::session('login_num',null);
            $data=Model_Member_Login::login_init($return['member']);
            $data['status']=$return['status'];
            exit(json_encode($data));
        }
        exit(json_encode($return));
    }

    /**
     * 下单时，ajax判断是否登陆
     */
    public function action_ajax_is_login()
    {
        $data['md5'] = Arr::get($_POST, 'data');
        $data['logintime'] = Arr::get($_POST, 'logintime');
        if($data['md5'])
        {
            $member=Model_Member_Login::check_login_info($data);
        }
        else
        {
            //检测用户是否存在
            //$mid = Cookie::get('st_userid');
            $member=Model_Member_Login::check_login_info();
        }
        if(!empty($member))
        {
            $mid=$member['mid'];
        }
        if (!isset($mid)) {
            exit(json_encode(array('status' => 0)));
        }
        else {
            $member = Model_Member::get_member_byid($mid);
            if (empty($member)) {
                exit(json_encode(array('status' => 0)));
            }
            $minfo = array(
                'mid' => $member['mid'],
                'nickname' => $member['nickname'],
                'litpic' => $member['litpic'],
                'last_logintime' => $member['last_logintime'],
                'mobile' => $member['mobile'],
                'has_msg'=> Model_Message::has_msg($member['mid']),
                'did'=>Model_Distributor::distributor_find_relationship($member['mid'],'view')
            );
            // 设置分销商ID
            $GLOBALS['did']=$minfo['did'];
            if ($data['md5']) {
                $serectkey = $data['md5'];
            } else {
                $serectkey = Common::authcode($member['mid'] . '||' . $member['pwd'], '');
            }
            exit(json_encode(array('status' => 1, 'user' => $minfo,'checktime'=>time(),'secret'=>$serectkey)));
        }
    }

    //注销登录
    public function action_ajax_out()
    {
        $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $this->cmsurl;
        $fromurl = strpos($referer, 'member') || strpos($referer, 'login') || strpos($fromurl, 'register') ? $GLOBALS['cfg_basehost'] : $referer;
//        Common::session('member', NULL);
//        Cookie::delete('st_userid');
//        Cookie::delete('st_secret');
        Model_Member_Login::login_out();
        header("Location:{$fromurl}");
    }
}