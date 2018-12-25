<?php defined('SYSPATH') or die('No direct script access.');
class Controller_Pc_Customize extends Stourweb_Controller{
    /*
     * 私人定制
     * */
    private $_typeid = 14;

    public function before()
    {
        parent::before();
        $channelname = Model_Nav::get_channel_name($this->_typeid);
        $this->assign('typeid', $this->_typeid);
        $this->assign('channelname', $channelname);

    }

    public function action_index()
    {
       $seoinfo = Model_Nav::get_channel_seo($this->_typeid);
       $extend_fields = Model_Customize_Extend_Field_Desc::get_fields();
       $plan_result = Model_Customize_Plan::search_result(null,1);
       $this->assign('plans',$plan_result['list']);
       $this->assign('extend_fields',$extend_fields);
       $this->assign('seoinfo', $seoinfo);
        //frmcode
       $code = md5(time());
       Common::session('code',$code);
        $this->assign('frmcode',$code);
        $templet = Product::get_use_templet('customize_index');
        $templet = $templet ? $templet : 'customize/index';
        $this->display($templet);
    }

    public function action_plan()
    {
        $id = intval($this->request->param('id'));
        $model = ORM::factory('customize_plan',$id);

        $info = $model->as_array();
        $extend_info = DB::select()->from('customize_extend_field')->where('planid','=',$id)->execute()->current();

        $this->assign('extend_info',$extend_info);
        $this->assign('info', $info);
        $templet = Product::get_use_templet('customize_plan');
        $templet = $templet ? $templet : 'customize/plan';
        $this->display($templet);
        Model_Customize_Plan::update_click_rate($info['id']);

    }

    public function action_ajax_save()
    {


        $addtime=time();

        $checkCode = strtolower(Arr::get($_POST, 'captcha'));
        //验证码验证
        if (!Captcha::valid($checkCode) || empty($checkCode))
        {
            echo json_encode(array('status'=>0,'flag'=>'captcha'));
            return;
        }
        $frmCode = Arr::get($_POST,'frmcode');
        //安全校验码验证
        $orgCode = Common::session('code');
        if($orgCode!=$frmCode || empty($frmCode))
        {
            exit('code err');
        }
        $curtime= time();

        $model = ORM::factory('customize');
        //strip_tags
        $model->dest = Common::remove_xss(strip_tags($_POST['dest']));
        $model->starttime =strtotime($_POST['starttime']);
        $model->startplace = Common::remove_xss(strip_tags($_POST['startplace']));
        $model->days = Common::remove_xss($_POST['days']);
        $model->adultnum = Common::remove_xss($_POST['adultnum']);
        $model->childnum = Common::remove_xss($_POST['childnum']);

        $model->sex =Common::remove_xss($_POST['sex']);
//        $model->address =Common::remove_xss(strip_tags($_POST['address']));
        $model->phone = Common::remove_xss($_POST['phone']);
        $model->email = Common::remove_xss($_POST['email']);

        $model->contacttime =Common::remove_xss($_POST['contacttime']);
        $model->content =Common::remove_xss(strip_tags($_POST['content']));
        $model->contactname = Common::remove_xss(strip_tags($_POST['contactname']));
        $model->addtime = $curtime;

        $login_user=Model_Member_Login::check_login_info();
        $member_id = $login_user['mid'];
        $phone = St_Functions::remove_xss($_POST['phone']);
        if(empty($member_id) && !empty($phone))
        {
            $member_id = St_Product::auto_reg($phone);
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
               echo json_encode(array('status'=>0));
               return;
           }

        }
        echo json_encode(array('status'=>1));

    }

}