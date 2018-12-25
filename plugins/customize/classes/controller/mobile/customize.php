<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Class Controller_Customize
 * 私人定制控制器
 */
class Controller_Mobile_Customize extends Stourweb_Controller
{
    private $_typeid = 14;   //产品类型

    public function before()
    {
        parent::before();
        $channelname = Model_Nav::get_channel_name_mobile($this->_typeid);
        $this->assign('typeid', $this->_typeid);
        $this->assign('channelname', $channelname);
    }

    /**
     * 结伴首页
     */
    public function action_index()
    {
        $seoinfo = Model_Nav::get_channel_seo_mobile($this->_typeid);
        $extend_fields = Model_Customize_Extend_Field_Desc::get_fields();
        $plan_result = Model_Customize_Plan::search_result(null,1);

        $this->assign('extend_fields',$extend_fields);
        $this->assign('plans',$plan_result['list']);
        $this->assign('seoinfo', $seoinfo);
        $this->display('../mobile/customize/index','customize_index');
    }

    public function action_plan()
    {
        $id = intval($this->request->param('id'));
        $model = ORM::factory('customize_plan',$id);

        $info = $model->as_array();
        $extend_info = DB::select()->from('customize_extend_field')->where('planid','=',$id)->execute()->current();

        $this->assign('extend_info',$extend_info);
        $this->assign('info', $info);
     //   $templet = Product::get_use_templet('customize_plan');
      //  $templet = $templet ? $templet : 'customize/plan';
        $this->display('../mobile/customize/plan','customize_plan');
        Model_Customize_Plan::update_click_rate($info['id']);

    }

    /**
     * 验证码
     */
    public function action_ajax_check_code()
    {
        //验证码检测
        if (isset($_POST['code']))
        {
            $code = Arr::get($_POST, 'code');
            $result = (bool)(sha1(utf8::strtoupper($code)) === Session::instance()->get('captcha_response'));
            if ($result)
            {
                print_r('true');
                exit;
            }
            else
            {
                print_r('false');
                exit;
            }
        }
        else
        {
            print_r('false');
            exit;
        }
    }

    /**
     * 私人定制后台处理
     * @return string
     */
    public function action_ajax_do_add()
    {
        if (!$this->request->is_ajax()) return '';
        $status = 0;
        //目的地
        $dest = Arr::get($_POST, 'dest');
        //出发地点
        $startplace = Arr::get($_POST, 'startplace');
        //出发时间
        $starttime = strtotime(Arr::get($_POST, 'starttime'));
        $starttime = $starttime > 0 ? $starttime : '';
        //出行时长
        $days =intval(Arr::get($_POST, 'days'));
        //成人数
        $adultnum = intval(Arr::get($_POST, 'adultnum'));
        //儿童数
        $childnum =intval(Arr::get($_POST, 'childnum'));
        //您的称呼
        $contactname = Arr::get($_POST, 'contactname');
        //性别
        $sex = Arr::get($_POST, 'sex');
        //所在地点
//        $address =Arr::get($_POST, 'address');
        //手机号码
        $phone = Arr::get($_POST, 'phone');
        //E-mail
        $email = Arr::get($_POST, 'email');
        //合适的联系时间
        $contacttime =Arr::get($_POST, 'contacttime');
        //其他要求
        $content = Arr::get($_POST, 'content');
        //验证码
        $code =Arr::get($_POST, 'code');

        //验证码检测
        if (isset($code))
        {
            if (!Captcha::valid($code))
            {
                echo json_encode(array('status' => $status, 'message' => __("error_code")));
                exit;
            }
            Common::session('captcha_response', null);
        }
        else
        {
            echo json_encode(array('status' => $status, 'message' => __("error_code_not_empty")));
            exit;
        }

        $validataion = Validation::factory($this->request->post());
        $validataion->rule('dest', 'not_empty');
        $validataion->rule('startplace', 'not_empty');
        $validataion->rule('starttime', 'not_empty');
        $validataion->rule('starttime', 'date');
        $validataion->rule('days', 'digit');
        $validataion->rule('adultnum', 'digit');
        $validataion->rule('childnum', 'digit');
        $validataion->rule('contactname', 'not_empty');
        $validataion->rule('sex', 'not_empty');
//        $validataion->rule('address', 'not_empty');
        $validataion->rule('phone', 'not_empty');
        $validataion->rule('phone', 'phone');
        $validataion->rule('email', 'not_empty');
        $validataion->rule('email', 'email');
        $validataion->rule('contacttime', 'not_empty');

        if (!$validataion->check())
        {
            $error = $validataion->errors();
            $keys = array_keys($validataion->errors());
            if ($keys[0] == 'phone')
            {
                echo json_encode(array('status' => $status, 'message' => __("error_user_phone")));
            }
            elseif ($keys[0] == 'email')
            {
                echo json_encode(array('status' => $status, 'message' => __("error_user_email")));
            }
            elseif ($keys[0] == 'adultnum')
            {
                echo json_encode(array('status' => $status, 'message' => __("error_adultnum_digit")));
            }
            elseif ($keys[0] == 'childnum')
            {
                echo json_encode(array('status' => $status, 'message' => __("error_childnum_digit")));
            }
            else
            {
                echo json_encode(array('status' => $status, 'message' => __("error_customize_{$keys[0]}_{$error[$keys[0]][0]}")));
            }
            exit;
        }

          $curtime= time();

        $model = ORM::factory('customize');
        $model->dest =$dest;
        $model->starttime =$starttime;
        $model->startplace =$startplace;
        $model->days =$days;
        $model->adultnum = $adultnum;
        $model->childnum =$childnum;

        $model->sex = $sex;
//        $model->address = $address;
        $model->phone = $phone;
        $model->email = $email;

        $model->contacttime = $contacttime;
        $model->content =$content;
        $model->contactname =$contactname;
        $model->addtime = $curtime;

        $login_user=Model_Member_Login::check_login_info();
        $member_id = $login_user['mid'];
        if(empty($member_id) && !empty($phone))
        {
            $member_id = St_Product::auto_reg($_POST['phone']);
        }
        $model->memberid = $member_id;

        $model->save();
        $status = 0;
        if($model->saved())
        {
            //保存扩展信息
            $extend_model = ORM::factory('customize_extend_field');
            $extend_model->productid = $model->id;
            foreach($_POST as $k=>$v)
            {
                if(strpos($k,'e_')===0)
                {
                    $extend_model->$k=$v;
                }
            }
            $extend_model->save();
            $ordersn = St_Product::get_ordersn($this->_typeid);
            $arr = array(
                'ordersn' => $ordersn,
                'webid' => 0,
                'typeid' => $this->_typeid,
                'productautoid' => $model->id,
                'productaid' => 0,
                'productname' => '私人定制',
                'price' => 0,
                'usedate' => $_POST['starttime'],
                'dingnum' => 1,
                'departdate' => '',
                'linkman' => $model->contactname,
                'linktel' => $model->phone,
                'linkemail' => $model->email,
                'jifentprice' => 0,
                'jifenbook' => 0,
                'jifencomment' =>0,
                'addtime' => $curtime,
                'memberid' => $member_id,
                'dingjin' => 0,
                'paytype' => 3,
                'suitid' => 0,
                'usejifen' => 0,
                'needjifen' => 0,
                'status' => 0,
                'remark' => '',
                'isneedpiao' => 0

            );
            $result = St_Product::add_order($arr,'Model_Customize',$arr);
            if(!$result)
            {
                $model->delete();
                echo json_encode(array('status' => 0, 'message' => __("error_customize_add_insert")));
                return;
            }

        }
        echo json_encode(array('status' => 1, 'message' => __("success_customize_add_insert")));

    }
}

