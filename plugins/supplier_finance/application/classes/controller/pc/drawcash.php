<?php defined('SYSPATH') or die('No direct script access.');

/**
 * 验单管理
 * Class Controller_Pc_Checkorder
 */
class Controller_Pc_Drawcash extends Stourweb_Controller
{
    /**
     * 初始化
     */
    public function before()
    {
        parent::before();
        //登陆状态判断
        $this->_id = Cookie::get('st_supplier_id');
        if(empty($this->_id))
        {
            $this->request->redirect($GLOBALS['cfg_basehost'].'/plugins/supplier/pc/login');
        }
        else
        {
            $this->_user_info = Model_Supplier::get_supplier_byid($this->_id);
            $this->assign('userinfo',$this->_user_info);
        }
    }


    public function action_list()
    {
        $drawcashModel = new Model_Supplier_finance_Drawcash();
        $data = $drawcashModel->get_list();
        $this->assign('data', $data);
        $this->assign('get', $_GET);
        $this->display('drawcash/list');
    }


    public function action_drawcash_detail()
    {
        $drawcashModel = new Model_Supplier_finance_Drawcash();
        $data = $drawcashModel->get_detail(Common::remove_xss(Arr::get($_GET, "id")));
        if (count($data) <= 0)
            $data = null;
        else
            $data = $data[0];

        $this->assign('info', $data);
        $this->display('drawcash/detail');
    }


    public function action_drawcash_apply()
    {
        $countinfo = Model_Member_Order_Extend::get_overview_info($this->_id);
        $withdraw_total = $countinfo['withdraw_total'];

        $this->assign('withdraw_total',$withdraw_total);
        $this->display('drawcash/apply');
    }

    public function action_ajax_post_drawcash_apply()
    {
        if (!$this->request->is_ajax())
        {
            echo json_encode(array('status' => 0, 'msg' => '请求异常'));
            exit;
        }

        //注册信息验证
        $validataion = Validation::factory($this->request->post());
        $validataion->rule('withdrawamount', 'not_empty');
        $validataion->rule('withdrawamount', 'numeric');
        if (!$validataion->check())
        {
            $error = $validataion->errors();
            $keys = array_keys($validataion->errors());
            if ($keys[0] == 'withdrawamount')
            {
                echo json_encode(array('status' => 0, 'msg' => '“提现金额”不正确'));
                exit;
            }
        }

        //保留两位小数
        $withdrawamount = Common::remove_xss(Arr::get($_POST, 'withdrawamount'));
        $withdrawamount = round($withdrawamount, 2);

        $drawcashModel = new Model_Supplier_finance_Drawcash();

        $drawcashModel->supplierid = intval(Cookie::get('st_supplier_id'));
        $drawcashModel->withdrawamount = $withdrawamount;
        $drawcashModel->bankcardnumber = Common::remove_xss(Arr::get($_POST, 'bankcardnumber'));
        $drawcashModel->bankaccountname = Common::remove_xss(Arr::get($_POST, 'bankaccountname'));
        $drawcashModel->bankname = Common::remove_xss(Arr::get($_POST, 'bankname'));
        $drawcashModel->description = Common::remove_xss(Arr::get($_POST, 'description'));
        $drawcashModel->addtime = time();
        $drawcashModel->status = "0";

        $drawcashModel->proceeds_type = Common::remove_xss(Arr::get($_POST,'proceeds_type'));
        $drawcashModel->alipayaccount = Common::remove_xss(Arr::get($_POST,'alipayaccount'));
        $drawcashModel->alipayaccountname = Common::remove_xss(Arr::get($_POST,'alipayaccountname'));

        $drawcashModel->save();

        if ($drawcashModel->saved())
        {
            echo json_encode(array('status' => 1, 'msg' => '保存成功'));
            exit;
        } else
        {
            echo json_encode(array('status' => 0, 'msg' => '保存失败'));
            exit;
        }
    }
}