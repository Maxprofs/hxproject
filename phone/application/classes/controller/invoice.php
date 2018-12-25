<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Invoice extends Stourweb_Controller
{
    /*
     * 公共请求控制器,此控制器不能删除.
     *
     * */
    private $_userinfo;
    public function before()
    {
        parent::before();
        $userinfo = Common::session('member');
        $userinfo = Model_Member::get_member_byid($userinfo['mid']);

        if($userinfo)
        {
            $this->_userinfo=$userinfo;
            $this->assign('userinfo',$userinfo);
        }
    }
    /*
     * 发票选择
     */
    public function action_choose()
    {

        $typeid = $this->params['typeid'];
        $contents = $GLOBALS['cfg_invoice_content_'.$typeid];
        $description = $GLOBALS['cfg_invoice_des_'.$typeid];
        $types = $GLOBALS['cfg_invoice_type_'.$typeid];

        $contents = explode(',',$contents);
        $types = explode(',',$types);

        $invoice_list = Model_Member_Invoice::search_result($this->_userinfo['mid'],null,$types,1,1);

        $this->assign('contents',$contents);
        $this->assign('description',$description);
        $this->assign('types',$types);
        $tpl = empty($this->_userinfo) || empty($invoice_list)?'invoice/choose_unlogin':'invoice/choose';
        $this->display($tpl);
    }

    /*
     * 发票地址
     */
    public function action_address()
    {
        $list = DB::select()->from('member_address')->where('memberid', '=', $this->_userinfo['mid'])->execute()->as_array();
        $this->assign('address', $list);
        $tpl = empty($this->_userinfo)?'invoice/address_unlogin':'invoice/address';
        $this->display($tpl);
    }

    /*
     * 加载发票
     */
    public function action_ajax_invoice_more()
    {


        $page = intval($_POST['page']);
        $types = $_POST['types'];
        $pagesize = 10;
        $out = Model_Member_Invoice::search_result($this->_userinfo['mid'],null,$types,$page,$pagesize);
        echo json_encode($out);
    }

    /*
     * 地址加载
     */
    public function action_ajax_address_more()
    {
        $page = intval($_POST['page']);
        $page = $page<1?1:$page;
        $pagesize = 20;
        $offset = ($page-1)*$pagesize;
        $list = DB::select()->from('member_address')->where('memberid', '=', $this->_userinfo['mid'])->order_by('is_default','desc')->offset($offset)->limit($pagesize)->execute()->as_array();
        echo json_encode(array('status'=>1,'list'=>$list));
    }
}