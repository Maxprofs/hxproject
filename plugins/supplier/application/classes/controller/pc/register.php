<?php defined('SYSPATH') or die('No direct script access.');

/**
 * 用户注册
 * Class Controller_Pc_Register
 */
class Controller_Pc_Register extends Stourweb_Controller
{
    //默认对象
    private $_model;

    /**
     * 初始化
     */
    public function before()
    {
        parent::before();
        $this->_model = new Model_Supplier();
        $this->assign('logo',Common::get_sys_para('cfg_supplier_logo'));
    }

    /**
     * 注册页面
     */
    public function action_index()
    {
        $this->display('login/register');
    }
    /**
     * 注册第一步
     */
    public function action_ajax_do_check()
    {
        $phone = Common::remove_xss(Arr::get($_POST, 'phone'));
        $email = Common::remove_xss(Arr::get($_POST, 'email'));
        //注册信息验证
        $validataion = Validation::factory($this->request->post());
        if (empty($phone))
        {
            $validataion->rule('email', 'email');
        } else
        {
            $validataion->rule('phone', 'phone');
        }

        if (!$validataion->check())
        {
            $error = $validataion->errors();
            $keys = array_keys($validataion->errors());
            if (empty($phone))
            {
                if ($keys[0] == 'email')
                {
                    echo json_encode(array('status' => 0, 'msg' => '“邮件地址”格式错误'));
                    exit;
                }
            } else
            {
                if ($keys[0] == 'phone')
                {
                    echo json_encode(array('status' => 0, 'msg' => '“手机号码”格式错误'));
                    exit;
                }
            }
        }
        $data = $this->_model->supplier_find((empty($phone) ? $email : $phone), null, false);
        if (!empty($data))
        {
            echo json_encode(array('status' => 0, 'msg' => '该' . (empty($phone) ? '邮件地址' : '电话号码') . '已存在'));
            exit;
        } else
        {
            echo json_encode(array('status' => 1, 'msg' => '验证通过'));
            exit;
        }
    }

    /**
     * 注册第一步
     */
    public function action_ajax_do_setp1()
    {
        if (!$this->request->is_ajax())
        {
            echo json_encode(array('status' => 0, 'msg' => '请求异常'));
            exit;
        }

        $phone = Common::remove_xss(Arr::get($_POST, 'phone'));
        $email = Common::remove_xss(Arr::get($_POST, 'email'));
        $smscode = Common::remove_xss(Arr::get($_POST, 'smscode'));
        $code = Common::remove_xss(Arr::get($_POST, 'code'));
        if (!Captcha::valid($code))
        {
            echo json_encode(array('status' => 0, 'msg' => '“验证码”错误'));
            exit;
        }

        if (Common::session('msg_account') != (empty($phone) ? $email : $phone))
        {
            echo json_encode(array('status' => 0, 'msg' => '“注册帐号”错误'));
            exit;
        }
        if (Common::session('msg_code') != $smscode)
        {
            echo json_encode(array('status' => 0, 'msg' => '“动态验证码”错误'));
            exit;
        }
        //注册信息验证
        $validataion = Validation::factory($this->request->post());
        if (empty($phone))
        {
            $validataion->rule('email', 'email');
            if (!$validataion->check())
            {
                $error = $validataion->errors();
                $keys = array_keys($validataion->errors());
                if ($keys[0] == 'email')
                {
                    echo json_encode(array('status' => 0, 'msg' => '“邮件地址”格式错误'));
                    exit;
                }
            }
        } else
        {
            $validataion->rule('phone', 'phone');
            if (!$validataion->check())
            {
                $error = $validataion->errors();
                $keys = array_keys($validataion->errors());
                if ($keys[0] == 'phone')
                {
                    echo json_encode(array('status' => 0, 'msg' => '“手机号码”格式错误'));
                    exit;
                }
            }
        }

        $data = $this->_model->supplier_find((empty($phone) ? $email : $phone), null, false);
        if (!empty($data))
        {
            echo json_encode(array('status' => 0, 'msg' => '该' . (empty($phone) ? '邮件地址' : '手机号码') . '已存在'));
            exit;
        } else
        {
            echo json_encode(array('status' => 1, 'msg' => '验证通过'));
            exit;
        }
    }

    /**
     * 注册第二步
     */
    public function action_ajax_do_setp2()
    {
        if(!$this->request->is_ajax())
        {
            echo json_encode(array('status' => 0,'msg' => '请求异常'));
            exit;
        }

        $password = Common::remove_xss(Arr::get($_POST,'password'));
        $account = Common::remove_xss(Arr::get($_POST,'account'));
        $smscode = Common::remove_xss(Arr::get($_POST,'smscode'));
        $code = Common::remove_xss(Arr::get($_POST,'code'));

        if (!Captcha::valid($code))
        {
            echo json_encode(array('status' => 0,'msg' => '“验证码”错误'));
            exit;
        }
        if (Common::session('msg_code') != $smscode && Common::session('msg_account') != $account)
        {
            echo json_encode(array('status' => 0,'msg' => '“动态验证码”错误'));
            exit;
        }

        Common::session('captcha_response', null);
        Common::session('msg_code', null);
        Common::session('msg_account', null);

        //注册信息验证
        $validataion = Validation::factory($this->request->post());
        $validataion->rule('account', 'not_empty');
        $validataion->rule('password', 'not_empty');
        $validataion->rule('password', 'min_length', array(':value', '6'));
        if (!$validataion->check())
        {
            $error = $validataion->errors();
            $keys = array_keys($validataion->errors());
            if($keys[0] == 'account')
            {
                echo json_encode(array('status' => 0, 'msg' => '“手机号码或邮件地址”不能为空'));
                exit;
            }
            if($keys[0] == 'password')
            {
                echo json_encode(array('status' => 0, 'msg' => '“密码”最小长度为六位'));
                exit;
            }
        }
        $password = md5($password);
        $data = array(
            'account' => $account,
            'password' => $password
        );
        $rtn = $this->_model->register($data);
        if ($rtn == 'error_member_exists')
        {
            echo json_encode(array('status' => 0, 'msg' => '该手机号码或邮件地址已存在'));
            exit;
        }
        elseif ($rtn == 'error_member_insert')
        {
            echo json_encode(array('status' => 0, 'msg' => '注册异常，请重试'));
            exit;
        }
        elseif ($rtn[0] > 0)
        {
            $this->_model->login($account, $password);
            echo json_encode(array('status' => 1, 'msg' => '注册成功'));
            exit;
        }
        else
        {
            echo json_encode(array('status' => 0, 'msg' => '注册异常，请重试'));
            exit;
        }
    }
}