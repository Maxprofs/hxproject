<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Created by PhpStorm.
 * Author: daisc
 * QQ: 2444329889
 * Time: 2017/12/20 9:40
 * Desc: 合同管理后台
 */

class Controller_Admin_Contract extends Stourweb_Controller
{



    function before()
    {
        parent::before();
        $this->assign('parentkey', $this->params['parentkey']);
        $this->assign('itemid', $this->params['itemid']);
        $this->assign('party',Model_Contract::get_contract_config());
        $party_defalut=Model_Sysconfig::get_configs(0,'cfg_default_partyB',1);
        $this->assign('default_partyB',$party_defalut?$party_defalut:0);
        $this->assign('models',Model_Contract::get_opentypes());
    }


    /**
     * @function 后台合同首页
     */
    public function action_index()
    {
        $action = $this->params['action'];
        if(!$action)
        {
            $this->display('admin/contract/list');
        }
        if($action == 'read')
        {
            $start = $_GET['start'];
            $limit = $_GET['limit'];
            $keyword = $_GET['keyword'];
            $typeid = $_GET['typeid'];
            $where = 'id >0';
            if($keyword)
            {
                $where .=" and title like '%$keyword%'";
            }
            if($typeid)
            {
                $where .=" and typeid=$typeid";
            }

            $sort = json_decode($_GET['sort'],true);
            $sort = $sort[0];
            if($sort)
            {
                $property = $sort['property'];
                $direction = $sort['direction'];
            }
            else
            {
                $property = 'id';
                $direction = 'desc';
            }

            $total = DB::select(DB::expr('count(*) as num'))->from('contract')
                ->where($where)->execute()->get('num');
            $list = DB::select('id','title','typeid','status')->from('contract')->where($where)
                ->offset($start)->limit($limit)->order_by($property,$direction)->execute()->as_array();
            foreach ($list as &$l)
            {
                if($l['typeid'])
                {
                    $l['typename'] = DB::select('shortname')->from('nav')
                        ->where('typeid','=',$l['typeid'])->execute()->get('shortname');
                }
                else
                {
                    $l['typename'] = '未设置';
                }
            }
            unset($l);
            echo  json_encode(array('total'=>$total,'list'=>$list));
        }
        elseif ($action == 'update')
        {
            $id = $_POST['id'];
            $val = $_POST['val'];
            $field = $_POST['field'];
            DB::update('contract')->set(array($field=>$val))->where('id','=',$id)->execute();
            echo 'ok';
        }
        elseif ($action == 'delete')
        {
            $data = file_get_contents('php://input');
            $data = json_decode($data);
            if($data->id)
            {
                DB::delete('contract')->where('id','=',$data->id)->execute();
            }
        }
    }

    /**
     * @function 添加/修改合同
     */
    public function action_add()
    {
        $id =  $this->params['id'];
        if($id)
        {
            $info = DB::select()->from('contract')
                ->where('id','=',$id)->execute()
                ->current();
            $this->assign('info',$info);
        }
        $this->display('admin/contract/add');
    }


    /**
     * @function 保存合同
     */
    public function action_ajax_save()
    {
        $data = $_POST;
        $id = $_POST['id'];
        unset($data['id']);
        if($id)
        {
            DB::update('contract')->set($data)->where('id','=',$id)->execute();
        }
        else
        {
            $data['addtime'] = time();
            list($id) = DB::insert('contract',array_keys($data))->values(array_values($data))->execute();
        }
        echo $id;
    }


    /**
     * @function 配置乙方信息
     */
    public function action_config()
    {
        $webid = intval($_REQUEST['webid'])?intval($_REQUEST['webid']):0;
        $action = $this->params['action'];
        if ($action == 'save')
        {
            $data=$_POST;
            $id = intval($_POST['id']);
            unset($data['id']);
            if($id)
            {
                $data['modifytime'] = time();
                DB::update('contract_partyb')->set($data)->where('id','=',$id)->execute();
            }
            else
            {
                $data['addtime'] = time();
                list($id) = DB::insert('contract_partyb',array_keys($data))->values(array_values($data))->execute();
            }
            echo json_encode(array('status' => true));
        }
        elseif ($action=='add'||$action=='edit')
        {
            $config=array();
            if($action=='edit')
            {
                $id = intval($this->params['id']);
                $config=DB::select()->from('contract_partyb')->where('id','=',$id)->execute()->current();
            }
            $this->assign('config',$config);
            $this->display('admin/contract/config');
        }
        elseif ($action=='delete')
        {
            $data = file_get_contents('php://input');
            $data = json_decode($data);
            if($data->id)
            {
                DB::delete('contract_partyb')->where('id','=',$data->id)->execute();
            }
        }
        elseif ($action=='read')
        {
            $start = $_GET['start'];
            $limit = $_GET['limit'];
            $keyword = $_GET['keyword'];
            $where = '1=1';
            if($keyword)
            {
                $where .=" and name like '%$keyword%'";
            }
            if($webid)
            {
                $where .=" and webid=$webid";
            }

            $sort = json_decode($_GET['sort'],true);
            $sort = $sort[0];
            if($sort)
            {
                $property = $sort['property'];
                $direction = $sort['direction'];
            }
            else
            {
                $property = 'id';
                $direction = 'desc';
            }
            $total = DB::select(DB::expr('count(*) as num'))->from('contract_partyb')
                ->where($where)->execute()->get('num');
            $list = DB::select()->from('contract_partyb')->where($where)
                ->offset($start)->limit($limit)->order_by($property,$direction)->execute()->as_array();

            echo  json_encode(array('total'=>$total,'list'=>$list));
        }
        elseif ($action=='update')
        {

            $id = $_POST['id'];
            $val = $_POST['val'];
            $field = $_POST['field'];
            if($field=='is_default')
            {
                //保存默认乙方信息
                $arr['webid']=$webid;
                $arr['cfg_default_partyB']=intval($id);
                Model_Sysconfig::save_config($arr);
            }
            else
            {
                DB::update('contract_partyb')->set(array($field=>$val))->where('id','=',$id)->execute();
            }
            echo 'ok';
        }
        else
        {
            $totalcount_arr = DB::query(Database::SELECT,"select count(*) as num from sline_contract_partyb")->execute()->as_array();
            $num=$totalcount_arr[0]['num'];
            $this->assign('num',$num);
            $this->display('admin/contract/partyB_list');
        }

    }


    /**
     * @function预览合同
     */
    public function action_view()
    {
        $id =  $this->params['id'];
        if($id)
        {

            $info = DB::select()->from('contract')
                ->where('id','=',$id)->execute()
                ->current();
            if(!$info['partyBid']||$info['partyBid']<=0)
            {
                $info['partyBid']=Model_Sysconfig::get_configs(0,'cfg_default_partyB',1);
            }
            $config=  Model_Contract::get_contract_config($info['partyBid']);
            if(!$info['partyBid'])
            {
                $list=Model_Contract::get_contract_config(false);
                $config=$list[0];
            }
            $this->assign('config',$config);
            $this->assign('info',$info);
            $this->display('admin/contract/view');
        }

    }


    //预览订单合同
    public function action_order_view()
    {
        $ordersn = $this->params['ordersn'];
        $order = Model_Member_Order::order_info($ordersn);
        $order = Model_Contract::format_order_data($order);
        $info = DB::select()->from('contract')
            ->where('id','=',$order['contract_id'])->execute()
            ->current();
        if(!$info['partyBid']||$info['partyBid']<=0)
        {
            $info['partyBid']=Model_Sysconfig::get_configs(0,'cfg_default_partyB',1);
        }
        $config=  Model_Contract::get_contract_config($info['partyBid']);
        if(!$info['partyBid'])
        {
            $list=Model_Contract::get_contract_config(false);
            $config=$list[0];
        }
        $this->assign('config',$config);
        $this->assign('order',$order);
        $this->assign('info',$info);
        $this->display('admin/contract/view');

    }



}