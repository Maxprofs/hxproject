<?php defined('SYSPATH') or die('No direct script access.');

/**
 * 供应商资质验证
 *
 */
class Controller_PC_Qualify extends Stourweb_Controller
{

    private $_id = NULL;
    private $_user_info = NULL;

    public function before()
    {
        parent::before();
        //登陆状态判断
        $this->_id = Cookie::get('st_supplier_id');
        if(empty($this->_id))
        {
            $this->request->redirect('pc/login');
        }
        else
        {
            $this->_user_info = Model_Supplier::get_supplier_byid($this->_id);
            $this->assign('userinfo',$this->_user_info);
        }
    }
    //资质验证首页
    public function action_index()
    {
        $this->display("qualify/index");
    }
    //资质验证步骤
    public function action_step()
    {
        //供应商可申请产品列表
        $product_list = Model_Supplier::get_authorization_product_list();
        $this->assign('product_list',$product_list);
        $qualify_data = unserialize($this->_user_info['qualification']);//获取序列化数据
        $isfirstupdate = Common::session('isfirstupdate');
        $this->assign('isfirstupdate',$isfirstupdate);
        $this->assign('qd',$qualify_data);
        $this->display("qualify/step");
    }

    //上传图片
    public function action_ajax_upload_litpic()
    {

        $filedata = Arr::get($_FILES,'filedata');
        $storepath = UPLOADPATH.'/supplier/';
        if(!file_exists($storepath))
        {
            mkdir($storepath);
        }
        $filename = uniqid();
        $target_file_name = $filedata['name'];
        $target_file_name = urldecode($target_file_name);
        $target_file_name = preg_replace('/([\x80-\xff]*)/i','',$target_file_name);
        $out = array();
        if(move_uploaded_file($filedata['tmp_name'], $storepath.$filename.$target_file_name))
        {
            $out['status'] = 1;
            $out['litpic'] = '/uploads/supplier/'.$filename.$target_file_name;
        }
        else
        {
            $out['status'] = 0;
        }
        echo json_encode($out);

    }

    //保存资质
    public function action_ajax_save_qualify()
    {
        $arr = array();
        foreach($_POST as $k=>$v)
        {
            if($k == "apply_product")
            {
                $arr[$k] = Common::remove_xss(implode(",",$v));
            }
            else
            {
                $arr[$k] = Common::remove_xss($v);
            }
        }
        $m = ORM::factory('supplier',$this->_id);
        if(empty($m->qualification))
        {
            Common::session('isfirstupdate',1);
        }
        else
        {
            Common::session('isfirstupdate',-1);
        }

        $qualify = serialize($arr);
        $m->qualification = $qualify;
        $m->suppliername = $arr['suppliername'];
        $m->reprent = $arr['reprent'];
        $m->verifystatus = 1;
        $out = array();
        $m->save();
        if($m->saved())
        {
            $out['status'] = 1;
            $out['msg']='您的资料已提交成功，请等待客服审核！';
        }
        else
        {
            $out['status'] = 0;
        }

        echo json_encode($out);
    }

    //重新验证
    public function action_ajax_reverify()
    {
        $model = ORM::factory('supplier',$this->_id);
        $model->verifystatus = 0;
        $model->save();
        if($model->saved())
        {
            echo json_encode(array('status'=>true,'msg'=>'提交成功'));
        }
        else
        {
            echo json_encode(array('status'=>false,'msg'=>'提交失败'));
        }


    }










}