<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Created by PhpStorm.
 * Author: daisc
 * QQ: 2444329889
 * Time: 2018/01/12 14:05
 * Desc: desc
 */

class  Controller_Pc_Brokerage extends Stourweb_Controller
{
    private $_id;
    private $_user_info;

    function before()
    {
        parent::before();

        //登陆状态判断
        $this->_id = Cookie::get('st_supplier_id');
        if (empty($this->_id)) {
            $this->request->redirect('pc/login');
        } else {
            $this->_user_info = Model_Supplier::get_supplier_byid($this->_id);
            $this->assign('userinfo', $this->_user_info);
        }
    }


    //首页
    public function action_index()
    {
        $pagesize = 20;
        $page = $_GET['page'] ? $_GET['page'] : 1;
        $status = intval($_GET['status']);
        $keyword = Common::remove_xss($_GET['keyword']);
        $where = "a.id>0 and a.supplierlist=" . $this->_id;
        if ($status) {
            $where .= " and a.status=$status";
        }
        if ($keyword) {
            $where .= " and (b.productname like '%$keyword%' or a.ordersn like '%$keyword%')";
        }

        $start = ($page - 1) * $pagesize;


        $sql = "select a.*,b.productname,b.status as order_status,c.suppliername,b.paytype,b.dingjin from sline_supplier_brokerage as a LEFT JOIN sline_member_order as b  on a.ordersn=b.ordersn  LEFT JOIN sline_supplier as c  on  a.supplierlist=c.id WHERE $where order by a.addtime desc limit $start,$pagesize";
        $total_sql = "select count(*) as num from sline_supplier_brokerage as a LEFT JOIN sline_member_order as b  on a.ordersn=b.ordersn  LEFT JOIN sline_supplier as c  on  a.supplierlist=c.id WHERE $where ";
        $total = DB::query(1, $total_sql)->execute()->get('num');
        $list = DB::query(1, $sql)->execute()->as_array();
        foreach ($list as &$l) {
            $l['addtime'] = date('Y-m-d H:i:s', $l['addtime']);
            $l['open_price'] = $l['brokerage'] - $l['finish_brokerage'];
        }
        unset($l);
        $route_array = array(
            'controller' => $this->request->controller(),
            'action' => $this->request->action(),
        );
        $pager = Pagination::factory(
            array(
                'current_page' => array('source' => 'query_string', 'key' => 'page'),
                'view' => 'default/pagination/brokerage',
                'total_items' => $total,
                'items_per_page' => $pagesize,
                'first_page_in_url' => false,
            )
        );
        //配置访问地址 当前控制器方法
        $pager->route_params($route_array);
        $this->assign('pageinfo', $pager);
        $this->assign('list', $list);
        $this->assign('status', $status);
        $this->assign('keyword', $keyword);
        $this->display('brokerage/index');

    }

    //提现记录
    public function action_approval()
    {

        $pagesize = 20;
        $page = $_GET['page'] ? $_GET['page'] : 1;
        $status = $_GET['status'];
        $where = " a.id>0 and b.id>0 and a.supplierid=" . $this->_id;
        switch ($status) {
            case 1://未审核
                $where .= " and a.status=0";
                break;
            case 2://审核未通过
                $where .= " and a.status=2";
                break;
            case 3:
                $where .= " and a.status=1";
                break;
        }
        $start = ($page - 1) * $pagesize;
        $total_sql = "select COUNT(*) as num from sline_supplier_finance_drawcash as a LEFT JOIN sline_supplier as b on a.supplierid=b.id WHERE $where ";
        $total = DB::query(1, $total_sql)->execute()->get('num');

        $sql = "select a.*,b.suppliername from sline_supplier_finance_drawcash as a LEFT JOIN sline_supplier as b on a.supplierid=b.id WHERE $where ORDER by a.id desc limit $start,$pagesize";
        $list = DB::query(1, $sql)->execute()->as_array();
        foreach ($list as &$l) {
            $l['addtime'] = date('Y-m-d H:i:s', $l['addtime']);
            $l['proceeds_type_title'] = Model_Supplier_Brokerage::get_proceeds_type($l['proceeds_type']);
            $l = array_merge($l, Model_Supplier_Brokerage::get_supplier_price_info($l['supplierid']));
        }
        unset($l);

        $route_array = array(
            'controller' => $this->request->controller(),
            'action' => $this->request->action(),
        );
        $pager = Pagination::factory(
            array(
                'current_page' => array('source' => 'query_string', 'key' => 'page'),
                'view' => 'default/pagination/brokerage',
                'total_items' => $total,
                'items_per_page' => $pagesize,
                'first_page_in_url' => false,
            )
        );
        //配置访问地址 当前控制器方法
        $pager->route_params($route_array);
        $this->assign('pageinfo', $pager);
        $this->assign('list', $list);
        $this->assign('status', $status);

        $this->display('brokerage/approval');

    }

    //提现详情
    public function action_approval_show()
    {
        $id = intval($this->params['id']);
        $sql = "select a.*,b.suppliername  from sline_supplier_finance_drawcash as a LEFT JOIN sline_supplier as b on a.supplierid=b.id WHERE a.id=$id";
        $info = DB::query(1, $sql)->execute()->current();
        if ($info) {
            $info = array_merge($info, Model_Supplier_Brokerage::get_supplier_price_info($info['supplierid']));
            $info['proceeds_type_title'] = Model_Supplier_Brokerage::get_proceeds_type($info['proceeds_type']);
        }
        $this->assign('info', $info);


        $this->display('brokerage/approval_show');
    }

    //申请提现
    public function action_approval_apply()
    {

        $price_arr = Model_Supplier_Brokerage::get_supplier_price_info($this->_id);
        $this->assign('price_arr', $price_arr);
        $this->display('brokerage/approval_apply');

    }

    //保存提现申请
    public function action_ajax_save_approval()
    {
        $withdrawamount = Common::remove_xss($_POST['withdrawamount']);
        $bankcardnumber = Common::remove_xss($_POST['bankcardnumber']);
        $bankaccountname = Common::remove_xss($_POST['bankaccountname']);
        $bankname = Common::remove_xss($_POST['bankname']);
        $alipayaccount = Common::remove_xss($_POST['alipayaccount']);
        $wechataccount = Common::remove_xss($_POST['wechataccount']);
        $description = Common::remove_xss($_POST['description']);
        $proceeds_type = intval($_POST['proceeds_type']);
        $data = array(
            'supplierid'=>$this->_id,
            'withdrawamount'=>$withdrawamount,
            'proceeds_type'=>$proceeds_type,
            'bankname'=>$bankname,
            'bankcardnumber'=>$bankcardnumber,
            'bankaccountname'=>$bankaccountname,
            'alipayaccount'=>$alipayaccount,
            'description'=>$description,
            'wechataccount'=>$wechataccount,
            'addtime'=>time(),

        );
        $rsn = DB::insert('supplier_finance_drawcash',array_keys($data))
            ->values(array_values($data))->execute();
        if($rsn)
        {
            exit(json_encode(array('status'=>1)));
        }
        exit(json_encode(array('status'=>0)));
    }



    //统计
    public function action_stat()
    {
        $price_arr = Model_Supplier_Brokerage::get_supplier_price_info($this->_id);
        //总结算金额
        $total_brokerage_price = DB::select(DB::expr('sum(brokerage) as total'))->from('supplier_brokerage')
            ->where('supplierlist','=',$this->_id)->execute()->get('total');
        //未结算金额
        $wait_brokerage_price = $total_brokerage_price - $price_arr['brokerage_price'];

        $price_arr['total_brokerage_price'] = $total_brokerage_price;
        $price_arr['wait_brokerage_price'] = $wait_brokerage_price;

        $this->assign('price_arr', $price_arr);
        $this->display('brokerage/stat');
    }


}