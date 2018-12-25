<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Class Controller_Member_Comment
 * 用户评论
 */
class Controller_Member_Invoice extends Stourweb_Controller
{
    /**
     * 前置操作
     */
    private $_member;
    public function before()
    {
        parent::before();
        $this->_member = Common::session('member');
        if (empty($this->_member))
        {
            Common::message(array('message' => __('unlogin'), 'jumpUrl' => $this->cmsurl . 'member/login'));
        }
    }

    /**
     * 评论视图
     */
    public function action_index()
    {
        $this->display('member/invoice/index');
    }

    /**
     * 修改发票
     */
    public function action_edit()
    {
        $id = $_GET['id'];
        $info = DB::select()->from('member_invoice')->where('id','=',$id)->and_where('memberid','=',$this->_member['mid'])->execute()->current();
        $this->assign('info',$info);
        $this->display('member/invoice/edit');
    }

    /**
     * 增加发票
     */
    public function action_add()
    {
        $this->display('member/invoice/edit');
    }

    /*
     * 加载发票
     */
    public function action_ajax_invoice_more()
    {
        $page = intval($_POST['page']);
        $pagesize = 10;
        $out = Model_Member_Invoice::search_result($this->_member['mid'],null,null,$page,$pagesize);
        echo json_encode($out);
    }

    /*
   * 发票保存
   */
    public function action_ajax_invoice_save()
    {
        $mtype = $_POST['mtype'];
        $subtype = $_POST['subtype'];
        $id = $_POST['id'];
        $invoice_model = ORM::factory('member_invoice',$id);
        if($invoice_model->loaded() && $invoice_model->memberid!=$this->_member['mid'])
        {
            echo json_encode(array('status'=>0,'msg'=>'权限错误'));
            return;
        }





        $type = $mtype==2?2:$subtype;
        $taxpayer_number = $_POST['taxpayer_number'];

        if($type!=0 && !empty($taxpayer_number))
        {
            $num = DB::query(Database::SELECT, "select count(*) as num from sline_member_invoice where id!='{$id}' and taxpayer_number='{$taxpayer_number}' ")->execute()->get('num');
            if($num>0)
            {
                echo json_encode(array('status'=>0,'msg'=>'纳税人识别号重复'));
                return;
            }
        }

        $invoice_model->type = $type;
        $invoice_model->memberid = $this->_member['mid'];
        $invoice_model->title = $_POST['title'];
        $invoice_model->taxpayer_number = $type==1 || $type==2? $_POST['taxpayer_number']:'';
        $invoice_model->taxpayer_address = $type==2? $_POST['taxpayer_address']:'';
        $invoice_model->taxpayer_phone =  $type==2?$_POST['taxpayer_phone']:'';
        $invoice_model->bank_branch =  $type==2?$_POST['bank_branch']:'';
        $invoice_model->bank_account =  $type==2?$_POST['bank_account']:'';
        $invoice_model->save();
        if($invoice_model->saved())
        {
            echo json_encode(array('status'=>1,'msg'=>'保存成功','id'=>$invoice_model->id));
        }
        else
        {
            echo json_encode(array('status'=>0,'msg'=>'保存失败'));
        }
    }

    /*
     * 删除发票
     */
    public function action_ajax_invoice_del()
    {
        $id = $_POST['id'];
        $invoice_model = ORM::factory('member_invoice')->where('id','=',$id)->and_where('memberid','=',$this->_member['mid'])->find();
        if(!$invoice_model->loaded())
        {
            echo json_encode(array('status'=>false,'msg'=>'发票不存在'));
            return;
        }
        $invoice_model->delete();
        echo json_encode(array('status'=>true,'msg'=>'删除成功'));
    }
}