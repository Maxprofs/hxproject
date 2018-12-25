<?php defined('SYSPATH') or die('No direct script access.');

/**
 * 公共控制器
 */
class Controller_Pc_Pub extends Stourweb_Controller
{
    private $_user_info;
    public function before()
    {
        parent::before();
        //登陆状态判断
        $st_supplier_id = Cookie::get('st_supplier_id');
        if(empty($st_supplier_id))
        {
            //$this->request->redirect($GLOBALS['cfg_basehost'].'/plugins/supplier/pc/login');
        }
        else
        {
            $this->_user_info = Model_Supplier::get_supplier_byid($st_supplier_id);
            $this->assign('userinfo',$this->_user_info);
        }

    }
    /**
     * 网站头部
     */
    public function action_header()
    {
        $sid = Arr::get($_GET,'sid') ? intval(Arr::get($_GET,'sid')): '';
        if(!empty($sid))
        {
            $this->_user_info = Model_Supplier::get_supplier_byid($sid);
            $this->assign('userinfo',$this->_user_info);
        }
        $user_m_kind = ($this->_user_info['verifystatus'] == 3 ? explode(',', $this->_user_info['authorization']) : array());

        $line_product = file_exists(PLUGINPATH.'supplier_line') && in_array(1,$user_m_kind) && St_Functions::is_normal_app_install('supplierlinemanage') ? 1: 0;
        $hotel_product = file_exists(PLUGINPATH.'supplier_hotel') && in_array(2,$user_m_kind)&& St_Functions::is_normal_app_install('supplierhotelmanage') ? 1 : 0;
        $car_product = file_exists(PLUGINPATH.'supplier_car') && in_array(3,$user_m_kind)&& St_Functions::is_normal_app_install('suppliercarmanage') ? 1 : 0;
        $tuan_product = file_exists(PLUGINPATH.'supplier_tuan') && in_array(13,$user_m_kind) && St_Functions::is_normal_app_install('suppliertuanmanage')? 1 : 0;
        $spot_product = file_exists(PLUGINPATH.'supplier_spot') && in_array(5,$user_m_kind) && St_Functions::is_normal_app_install('supplierspotmanage')? 1 : 0;
        $outdoor_product = file_exists(PLUGINPATH.'supplier_outdoor') && in_array(114,$user_m_kind) && St_Functions::is_normal_app_install('supplieroutdoormanage')? 1 : 0;
        $tongyong_product = file_exists(PLUGINPATH.'supplier_tongyong') && St_Functions::is_normal_app_install('suppliercommonmanage')? 1 : 0;
        $check_product = file_exists(PLUGINPATH.'supplier_check') && St_Functions::is_normal_app_install('supplierverifyorder') ? 1 : 0;
        if($tongyong_product)
        {
            $ty_list = Model_Model::tongyoug_model();
            $tongyong_list = array();
            foreach($ty_list as $tongyong)
            {
                if (in_array($tongyong['id'], $user_m_kind))
                {
                    array_push($tongyong_list,$tongyong);
                }
            }
            $this->assign('tongyong_list',$tongyong_list);
        }
        $finance_manage = file_exists(PLUGINPATH.'supplier_finance') && St_Functions::is_normal_app_install('supplierfinancemanage')? 1 : 0;

        $this->assign('line_product',$line_product);
        $this->assign('hotel_product',$hotel_product);
        $this->assign('car_product',$car_product);
        $this->assign('spot_product',$spot_product);
        $this->assign('tuan_product',$tuan_product);
        $this->assign('tongyong_product',$tongyong_product);
        $this->assign('check_product',$check_product);
        $this->assign('finance_manage',$finance_manage);
        $this->assign('outdoor_product',$outdoor_product);
        $this->display("pub/header");
    }

    /**
     * 网站底部
     */
    public function action_footer()
    {
        $this->display("pub/footer");
    }

    /**
     * ajax 验证码验证
     */
    public function action_ajax_do_code()
    {
        $code = Common::remove_xss(Arr::get($_POST,'code'));

        if (!Captcha::valid($code))
        {
            echo json_encode(array('status' => 0));
            exit;
        }

        echo json_encode(array('status' => 1));
    }

    /**
     * ajax 发送验证码
     */
    public function action_ajax_send_message()
    {
        //检测用户是否存在
        $phone = Arr::get($_POST, 'phone');
        $email = Arr::get($_POST, 'email');
        $type = Arr::get($_POST, "type");
        $code = rand(1000, 9999);

        if (empty($phone))
        {
            //email send code
            $validataion = Validation::factory($this->request->post());
            $validataion->rule('email', 'not_empty');
            $validataion->rule('email', 'email');
            if (!$validataion->check())
            {
                exit(__('error_user_email'));
            }

            require_once TOOLS_COMMON . 'email/emailservice.php';
            Common::session('msg_code', null);

            $status = EmailService::send_member_email($email, ($type == 'findpass_code' ? NoticeCommon::MEMBER_FINDPWD_CODE_MSGTAG : NoticeCommon::MEMBER_REG_CODE_MSGTAG), "", $code);
            if ($status)
            {
                Common::session('msg_code', $code);
                Common::session('msg_account', $email);
            }
            echo intval($status);
        } else
        {
            //phone send code
            $validataion = Validation::factory($this->request->post());
            $validataion->rule('phone', 'not_empty');
            $validataion->rule('phone', 'phone');
            if (!$validataion->check())
            {
                exit(__('error_user_phone'));
            }

            require_once TOOLS_COMMON . 'sms/smsservice.php';
            Common::session('msg_code', null);

            $status = SMSService::send_member_msg($phone, ($type == 'findpass_code' ? NoticeCommon::MEMBER_FINDPWD_CODE_MSGTAG : NoticeCommon::MEMBER_REG_CODE_MSGTAG), "", "", $code);
            $status = json_decode($status);
            if ($status->Success)
            {
                Common::session('msg_code', $code);
                Common::session('msg_account', $phone);
            }
            echo intval($status->Success);
        }

    }

}