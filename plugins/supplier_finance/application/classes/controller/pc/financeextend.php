<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Pc_Financeextend extends Stourweb_Controller
{
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

    //财务总览
    public function action_overview()
    {
        $info = Model_Member_Order_Extend::get_overview_info($this->_id);//汇总信息
        $list = Model_Member_Order_Extend::get_overview_list($this->_id);
        $this->assign('info',$info);
        $this->assign('list', $list['list']);
        $this->display('finance/overview');
    }

    //订单统计
    public function action_ordercount()
    {
        $unorder_typeids=array(4,6,7,10,11,12,14,101);
        $modules = DB::select('id','modulename','pinyin')->from('model')
            ->where(" find_in_set(id, '{$this->_user_info['authorization']}') ")
            ->where('id','not in',$unorder_typeids)
            ->execute()
            ->as_array();
        $modules_new = array();
        foreach($modules as $m)
        {
            if($m['id']>101)
            {
                $p_code = 'stourwebcms_app_system_tongyong';
            }
            else
            {
                $p_code = 'stourwebcms_app_system_'.$m['pinyin'];
            }
            $arr = DB::select()->from('app')->where('productcode','=',$p_code)->execute()->current();
            if($arr)
            {
                $modules_new[] = $m;
            }
        }

        $this->assign('modules',$modules_new);
        $this->assign('count_fields',Model_Member_Order_Extend::$count_fields);
        //$this->assign('countinfo',$countinfo);
        $this->display('finance/ordercount');
    }

    //获取订单列表
    public function action_ajax_ordercount_list()
    {
        $category = Common::remove_xss(Arr::get($_GET, 'category'));
        $typeid = Common::remove_xss(Arr::get($_GET, 'typeid'));
        $id = Common::remove_xss(Arr::get($_GET, 'id'));

        $starttime = Common::remove_xss(Arr::get($_GET, 'starttime'));
        $starttime = !empty($starttime) ? strtotime($starttime) : null;
        $endtime = Common::remove_xss(Arr::get($_GET, 'endtime'));
        $endtime = !empty($endtime) ? (strtotime($endtime) + 24 * 60 * 60) : null;

        $settle_status = Common::remove_xss(Arr::get($_GET, 'settle_status'));
        $order_status = Common::remove_xss(Arr::get($_GET, 'order_status'));
        $pageno = Common::remove_xss(Arr::get($_GET, 'pageno'));
        $pagesize = Common::remove_xss(Arr::get($_GET, 'pagesize'));

        $info = Model_Member_Order_Extend::get_order_list($this->_id, $category, $id, $typeid, $starttime, $endtime, $settle_status, $order_status, $pagesize, $pageno);

        //汇总信息
        $gather_info = Model_Member_Order_Extend::get_order_list($this->_id, $category, $id, $typeid, $starttime, $endtime, $settle_status, $order_status,9999999, 1);
        $countinfo=array(
            'total'=>0,
            'totalprice'=>0,
            'payprice'=>0,
            'jifentprice'=>0,
            'basicprice'=>0,
            'commission'=>0,
            'settle_amount'=>0
        );


        foreach($gather_info['list'] as $o)
        {
            $countinfo['totalprice'] += $o['totalprice'];
            $countinfo['payprice'] += $o['payprice'];
            $countinfo['jifentprice'] += $o['jifentprice'];
            $countinfo['basicprice'] += $o['product_basicprice'];
            $countinfo['commission'] += $o['commission'];
            if($o['status']==5)
            {
                $countinfo['settle_amount'] += $o['settle_amount'];
            }
        }
        //end 汇总信息

        $info['countinfo'] = $countinfo;

        //var_dump($info);exit;
        echo json_encode($info);
    }


    //获取产品,供应商,分销商列表数据
    public function action_ajax_ordercount_query_list()
    {
        //1:产品列表;2:供应商;3:分销商
        $category = Common::remove_xss(Arr::get($_GET, 'category'));
        $typeid = Common::remove_xss(Arr::get($_GET, 'typeid'));
        $pagesize = 10;
        $pageno = Common::remove_xss(Arr::get($_GET, 'pageno'));
        $keyword = Common::remove_xss(Arr::get($_GET,'keyword'));

        $data = Model_Member_Order_Extend::get_query_list($this->_id, $category, $typeid, $keyword, $pagesize, $pageno);
        echo json_encode($data);
    }

    //订单结算导出报表
    public function action_ordercount_export_excel()
    {
        $fields = Common::remove_xss(Arr::get($_GET,'fields'));
        $fields = explode(',', $fields);
        $type = Common::remove_xss(Arr::get($_GET,'type'));
        $typeid = Common::remove_xss(Arr::get($_GET,'typeid'));
        $id = Common::remove_xss(Arr::get($_GET,'id'));
        $starttime=Common::remove_xss(Arr::get($_GET,'starttime'));
        $endtime=Common::remove_xss(Arr::get($_GET,'endtime'));
        $order_status=Common::remove_xss(Arr::get($_GET,'order_status'));
        $settle_status=Common::remove_xss(Arr::get($_GET,'settle_status'));
        $info = Model_Member_Order_Extend::get_order_list($this->_id, $type, $id, $typeid, $starttime, $endtime, $settle_status, $order_status);
        Model_Member_Order_Extend::export_excel_order_count($info['list'], $fields);
    }

    //交易记录
    public function action_orderrecord()
    {
        $action = Common::remove_xss(Arr::get($_GET,'action'));
        if($action=='read')
        {
            $keyword = Common::remove_xss(Arr::get($_GET,'keyword'));
            $deal_type = Common::remove_xss(Arr::get($_GET,'deal_type'));
            $deal_status = Common::remove_xss(Arr::get($_GET,'deal_status'));
            $pageno = Common::remove_xss(Arr::get($_GET, 'pageno'));
            $pagesize = Common::remove_xss(Arr::get($_GET,'pagesize'));
            $info = Model_Member_Order_Extend::get_overview_list($this->_id, $keyword, $deal_type, $pagesize , $pageno, $deal_status);

            foreach($info['list'] as &$l)
            {
                $l['addtime']=date("Y-m-d H:i:s",$l['addtime']);
            }

            echo json_encode($info);


            exit;
        }
        $this->display('finance/orderrecord');
    }

    //交易记录导出Excel
    public function action_orderrecord_export_excel()
    {
        $fields = array();
        $deal_type = Common::remove_xss(Arr::get($_GET,'deal_type'));
        $deal_status = Common::remove_xss(Arr::get($_GET,'deal_status'));
        $keyword = Common::remove_xss(Arr::get($_GET,'keyword'));

        $info = Model_Member_Order_Extend::get_overview_list($this->_id, $keyword, $deal_type, 999999, 1, $deal_status);

        Model_Member_Order_Extend::export_excel_order_record($info['list'], $fields);
    }


}