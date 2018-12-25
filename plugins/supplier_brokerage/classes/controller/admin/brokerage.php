<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Created by PhpStorm.
 * Author: daisc
 * QQ: 2444329889
 * Time: 2018/01/10 15:12
 * Desc: desc
 */

class Controller_Admin_Brokerage extends Stourweb_Controller
{

    function before()
    {
        parent::before();
    }


    public function action_index()
    {
        $action = $this->params['action'];
        if(!$action)
        {
            $order_status=Model_Member_Order::$orderStatus;
            $this->assign('order_status',json_encode($order_status));
            $this->display('admin/supplier_brokerage/index');
        }
        switch ($action)
        {
            case 'read':
                $this->show_list();
                break;
        }
    }

    /**
     * @function 记录列表
     */
    private function show_list()
    {
        $start = $_GET['start'];
        $limit = $_GET['limit'];
        $status = $_GET['status'];
        $keyword = $_GET['keyword'];
        $where = "a.id>0";
        if($status)
        {
            $where .= " and a.status=$status";
        }
        if($keyword)
        {
            $where .=" and (b.productname like '%$keyword%' or c.suppliername like '%$keyword%' or a.ordersn like '%$keyword%')";
        }
        $sql="select a.*,b.productname,b.status as order_status,c.suppliername from sline_supplier_brokerage as a LEFT JOIN sline_member_order as b  on a.ordersn=b.ordersn  LEFT JOIN sline_supplier as c  on  a.supplierlist=c.id WHERE $where order by a.addtime desc limit $start,$limit";
        $total_sql = "select count(*) as num from sline_supplier_brokerage as a LEFT JOIN sline_member_order as b  on a.ordersn=b.ordersn  LEFT JOIN sline_supplier as c  on  a.supplierlist=c.id WHERE $where ";
        $total = DB::query(1,$total_sql)->execute()->get('num');
        $list = DB::query(1,$sql)->execute()->as_array();
        foreach ($list as &$l)
        {
            $l['addtime'] = date('Y-m-d H:i:s',$l['addtime']);
            $l['open_price'] = $l['brokerage'] - $l['finish_brokerage'] ;
        }
        unset($l);
        echo  json_encode(array('total'=>$total,'lists'=>$list));

    }


    //结算确认
    public function action_change_status()
    {
        $id = $_GET['id'];
        $info = DB::select()->from('supplier_brokerage')
            ->where('id','=',$id)->execute()->current();
        $info['open_price'] = $info['brokerage'] - $info['finish_brokerage'] ;
        $this->assign('info',$info);
        $this->display('admin/supplier_brokerage/dialog_change_status');

    }


    //保存结算信息
    public function action_ajax_change_status()
    {
        $id = $_POST['id'];
        $open_price = $_POST['open_price'];
        $info = DB::select()->from('supplier_brokerage')
            ->where('id','=',$id)->execute()->current();
        if($info['status']!=1)
        {
            exit(json_encode(array('status'=>0)));
        }
        if($info['finish_brokerage'])
        {
            $info['open_price'] = $info['brokerage'] - $info['finish_brokerage'] ;
            if($open_price!=$info['open_price'])
            {
                exit(json_encode(array('status'=>0)));
            }
            $open_price += $info['finish_brokerage'];
        }
        $data = array(
            'finish_brokerage'=>$open_price,
            'modtime'=>time(),
        );
        if($open_price>$info['brokerage'])
        {
            exit(json_encode(array('status'=>0)));
        }
        if($open_price==$info['brokerage'])
        {
            $data['status'] = 2;
        }
        $rsn = DB::update('supplier_brokerage')->set($data)->where('id','=',$id)->execute();
        if($rsn)
        {
            exit(json_encode(array('status'=>1)));
        }

    }

    //修改结算规则
    public function action_modify_rule()
    {

        $config = Model_Sysconfig::get_configs(0,array('cfg_supplier_brokerage_start_days','cfg_supplier_brokerage_finish_days','cfg_supplier_brokerage_type'));

        if(!$config['cfg_supplier_brokerage_start_days'])
        {
            $config['cfg_supplier_brokerage_start_days'] = 0 ;
        }
        if(!$config['cfg_supplier_brokerage_finish_days'])
        {
            $config['cfg_supplier_brokerage_finish_days'] = 0 ;
        }

        $this->assign('config',$config);
        $this->display('admin/supplier_brokerage/modify_rule');
    }


    //审核
    public function action_approval()
    {
        $action = $this->params['action'];
        if(!$action)
        {
            $this->display('admin/supplier_brokerage/approval');

        }
        switch ($action)
        {
            case 'read':
                $this->approval_list();
                break;
            case 'save':
                $id = $_POST['id'];
                $status = $_POST['status'];
                $audit_description = $_POST['audit_description'];
                $certificate = $_POST['certificate'];
                if($status)
                {
                    $data = array(
                        'status'=>$status,
                        'audit_description'=>$audit_description,
                        'certificate'=>$certificate,
                        'finishtime'=>time(),
                    );
                    DB::update('supplier_finance_drawcash')->set($data)
                        ->where('id','=',$id)->and_where('status','=',0)
                        ->execute();
                }
                echo  json_encode(array('status'=>1));
                break;
        }





    }


    //审核列表
    private function approval_list()
    {
        $start = $_GET['start'];
        $limit = $_GET['limit'];
        $status = $_GET['status'];
        $keyword = $_GET['keyword'];
        $where = " a.id>0 and b.id>0";
        switch ($status)
        {
            case 1://未审核
                $where .= " and a.status=0";
                break;
            case 2://审核未通过
                $where .=" and a.status=2";
                break;
            case 3:
                $where .=" and a.status=1";
                break;
        }
        if($keyword)
        {
            $where .=" and b.suppliername like '%$keyword%'";
        }
        $total_sql="select COUNT(*) as num from sline_supplier_finance_drawcash as a LEFT JOIN sline_supplier as b on a.supplierid=b.id WHERE $where ";
        $total = DB::query(1,$total_sql)->execute()->get('num');

        $sql="select a.*,b.suppliername from sline_supplier_finance_drawcash as a LEFT JOIN sline_supplier as b on a.supplierid=b.id WHERE $where ORDER by a.id desc limit $start,$limit";
        $list = DB::query(1,$sql)->execute()->as_array();
        foreach ($list as &$l)
        {
            $l['addtime'] = date('Y-m-d H:i:s',$l['addtime']);
            $l['proceeds_type_title'] = Model_Supplier_Brokerage::get_proceeds_type($l['proceeds_type']);
            $l = array_merge($l,Model_Supplier_Brokerage::get_supplier_price_info($l['supplierid']));
        }
        unset($l);


        echo json_encode(array('lists'=>$list,'total'=>$total));
    }


    //提现修改
    public function action_modify_approval()
    {
        $id = $this->params['id'];
        $sql = "select a.*,b.suppliername  from sline_supplier_finance_drawcash as a LEFT JOIN sline_supplier as b on a.supplierid=b.id WHERE a.id=$id";
        $info = DB::query(1,$sql)->execute()->current();
        if($info)
        {
            $info = array_merge($info,Model_Supplier_Brokerage::get_supplier_price_info($info['supplierid']));
            $info['proceeds_type_title'] = Model_Supplier_Brokerage::get_proceeds_type($info['proceeds_type']);
        }
        $this->assign('info',$info);
        $this->display('admin/supplier_brokerage/modify_approval');

    }



    /**
     * @function 统计
     */
    public function action_stat()
    {

        $action = $this->params['action'];
        if(!$action)
        {
            $price_arr = Model_Supplier_Brokerage::get_total_price_info();
            $supplierkind = DB::select()->from('supplier_kind')->where('isopen','=',1)
                ->execute()->as_array();
            $this->assign('supplierkind',$supplierkind);
            $this->assign('price_arr',$price_arr);
            $this->display('admin/supplier_brokerage/stat');
        }
        elseif ($action == 'read')
        {
            $starttime = strtotime($_GET['starttime']);
            $endtime = strtotime($_GET['endtime']);
            $keyword = $_GET['keyword'];
            $kindid = $_GET['kindid'];
            $start = $_GET['start'];
            $limit = $_GET['limit'];
            $where = 'id>0 and verifystatus=3';
            if($keyword)
            {
                $where .=" and suppliername like '%$keyword%'";
            }
            if($kindid)
            {
                $where .=" and kindid=$kindid";
            }
            $total = DB::select(DB::expr('count(*) as num'))->from('supplier')
                ->where($where)->execute()->get('num');
            $list = DB::select('id','suppliername','kindid')->from('supplier')
                ->where($where)->order_by('id','desc')->offset($start)
                ->limit($limit)->execute()->as_array();
            foreach ($list as &$l)
            {
                //时间范围的财务信息
                $time_price = Model_Supplier_Brokerage::get_supplier_time_price($l['id'],$starttime,$endtime);
                $l = array_merge($l,$time_price);
                if($l['kindid'])
                {
                    $l['kindname'] = DB::select('kindname')->from('supplier_kind')
                        ->where('id','=',$l['kindid'])->execute()->get('kindname');
                }
            }
            unset($l);
            echo  json_encode(array('total'=>$total,'lists'=>$list));

        }





    }


}