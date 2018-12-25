<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Customize_Order extends Stourweb_Controller
{
    private $_typeid = 14;
    /*
     * 订单总控制器
     *
     */
    public function before()
    {
        parent::before();
        $this->assign('typeid',$this->_typeid);
        $action = $this->request->action();
        //这里需要补权限的判断功能

    }
    /*
     * 订单列表
     * */
    public function action_index()
    {
        $action = $this->params['action'];
        if (empty($action))  //显示列表
        {
            $this->assign('statusnames', Model_Member_Order::getStatusNamesJs());
            $this->display('admin/customize/order/list');
        }
        else if ($action == 'read')    //读取列表
        {
            $start = Arr::get($_GET, 'start');
            $limit = Arr::get($_GET, 'limit');
            $keyword = Arr::get($_GET, 'keyword');

            $order = 'order by a.addtime desc';
            $sort = json_decode($_GET['sort'], true);
            if(!empty($sort[0]))
            {

                if($sort[0]['property'] == 'status')
                {
                    $order = ' order by b.status '.$sort[0]['direction'].' ,a.addtime desc';
                }
                else
                {
                    $order = ' order by a.'.$sort[0]['property'].' '.$sort[0]['direction'].' ,a.addtime desc';
                }
            }

            if (!empty($keyword))
            {
                $w = " where ( a.contactname like '%{$keyword}%' or a.phone like '%{$keyword}%') or b.ordersn='{$keyword}'";
            }


            $sql = "select distinct a.id,a.*,b.status as order_status   from sline_customize as a LEFT JOIN sline_member_order as b on a.id=b.productautoid and b.typeid=".$this->_typeid."  $w $order limit $start,$limit";
            $totalcount_arr = DB::query(Database::SELECT, "select count(*) as num from sline_customize a LEFT JOIN sline_member_order as b on a.id=b.productautoid and b.typeid=".$this->_typeid." $w ")->execute()->as_array();
            $list = DB::query(Database::SELECT, $sql)->execute()->as_array();
            $new_list = array();
            foreach ($list as $k => $v)
            {
                $v['addtime'] = Common::myDate('Y-m-d H:i:s', $v['addtime']);
                $v['starttime'] = Common::myDate('Y-m-d', $v['starttime']);
                $v['status'] = $v['order_status'];
                $v['status'] = Model_Member_Order::$order_status[$v['status']];
                $new_list[] = $v;
            }
            $result['total'] = $totalcount_arr[0]['num'];
            $result['lists'] = $new_list;
            $result['success'] = true;

            echo json_encode($result);
        }

        else if ($action == 'delete') //删除某个记录
        {
            $rawdata = file_get_contents('php://input');
            $data = json_decode($rawdata);
            $id = $data->id;

            if (is_numeric($id)) //
            {
                try
                {
                    $db = Database::instance();
                    $db->begin();

                    DB::delete('customize')->where('id','=',$id)->execute();
                    DB::delete('member_order')->where('productautoid','=',$id)
                        ->and_where('typeid','=',14)
                        ->execute();
                    $db->commit();

                }
                catch(Exception $e)
                {

                    $db->rollback();

                }




            }
        }
        else if ($action == 'update')//更新某个字段
        {
            $id = Arr::get($_POST, 'id');
            $field = Arr::get($_POST, 'field');
            $val = Arr::get($_POST, 'val');

            $order_fields=array('status');

            if(in_array($field,$order_fields))
            {
                $model = ORM::factory('member_order')->where('productautoid','=',$id)->and_where('typeid','=',$this->_typeid)->find();
            }
            else
            {
                $model = ORM::factory('customize')->where('id', '=', $id)->find();
            }
            if ($model->id)
            {
                $model->$field = $val;
                $model->update();
                if ($model->saved())
                    echo 'ok';
                else
                    echo 'no';
            }
        }

    }
    /*
     * 查看订单信息
     * */
    public function action_view()
    {
        $id = $this->params['id'];//订单id.
        $model = ORM::factory('customize')->where('id', '=', $id)->find();
        $info = $model->as_array();
        if ($model->loaded())
        {
                $model->viewstatus = 1;
                $model->save();
        }
        $info['linedoc']=unserialize($info['linedoc']);

        $member = DB::select('nickname')->from('member')->where('mid','=',$info['memberid'])->execute()->current();
        $info['membername'] = $member['nickname'] ? $member['nickname'] : '';

        $info['supplier_arr'] = ORM::factory('supplier', $info['supplierlist'])->as_array();



        $ordersn = DB::select('ordersn')->from('member_order')->where('productautoid','=',$id)->and_where('typeid','=',$this->_typeid)->execute()->get('ordersn');
        $order_info = Model_Member_Order::order_info($ordersn);


        $privileg_price=0;
        if(St_Functions::is_normal_app_install('coupon'))
        {
            $iscoupon = Model_Coupon::order_view($order_info['ordersn']);
            $order_info['cmoney'] = $iscoupon['cmoney'];
            $privileg_price+=$iscoupon['cmoney'];
        }
        if($order_info['usejifen']==1 && $order_info['jifentprice'])
        {
            $privileg_price+=$order_info['jifentprice'];
        }
        //优惠价格
        $order_info['privileg_price'] = $privileg_price;
        //游客信息
        $tourer = Model_Member_Order_Tourer::get_tourer_by_orderid($order_info['id']);

        $status = DB::select()->from('customize_order_status')->where('is_show', '=', 1)->order_by('displayorder', 'asc')->execute()->as_array();
        foreach ($status as $v)
        {
            if ($v['status'] == $order_info['status'])
            {
                $this->assign('current_status', $v);
                break;
            }
        }


        //扩展信息
        $extend_info = Model_Customize::get_extend_info($info['id']);
        $this->assign('info', $info);
        $this->assign('order_info',$order_info);
        $this->assign('tourer',$tourer);
        $this->assign('extend_info',$extend_info);
        $this->assign('orderstatus', $status);
        $this->display('admin/customize/order/view');
    }

   public function action_dialog_get_plan()
   {
       $this->display('admin/customize/order/dialog_get_plan');
   }

   public function action_ajax_get_plan()
   {
       $page = intval($_POST['page']);
       $keyword = $_POST['keyword'];
       $page = $page<1?1:$page;
       $pagesize = 8;
       $offset = $pagesize*($page-1);

       $w = " where id is not null ";
       $w.= !empty($keyword)?" and title like '%{$keyword}%' ":'';
       $sql = " select * from sline_customize_plan {$w} limit {$offset},{$pagesize}";
       $sql_num = " select count(*) as num from sline_customize_plan {$w} ";
       $list = DB::query(Database::SELECT,$sql)->execute()->as_array();
       $total = DB::query(Database::SELECT,$sql_num)->execute()->get('num');
       foreach($list as &$v)
       {
           $v['linedoc']=unserialize($v['linedoc']);
       }
       $result = array('list'=>$list,'total'=>$total,'pagesize'=>$pagesize,'page'=>$page);
       echo json_encode($result);
   }
    /*
     * 保存
     * */
    public function action_ajax_save()
    {

        $id = Arr::get($_POST, 'id');
        $type = Arr::get($_POST, 'type');

        $status = true;
        $model = ORM::factory('customize', $id);

        $order_model = ORM::factory('member_order')->where('productautoid','=',$id)->and_where('typeid','=',$this->_typeid)->find();
        $org_price = $order_model->price;
        $status = $_POST['status'];
        $oldstatus = $order_model->status;
        if($order_model->status == 0)
        {
            $model->title = $_POST['title'];
            $model->case_content = $_POST['case_content'];
            $model->supplierlist = $_POST['supplierlist'][0];
            $model->linedoc = serialize($_POST['linedoc']);

            $order_model->productname = empty($_POST['title'])?'私人定制':'私人定制:'.$_POST['title'];
            $order_model->price = $_POST['price'];
            $order_model->jifenbook = $_POST['jifenbook'];
           // $order_model->jifentprice = $_POST['jifentprice'];
            $order_model->supplierlist = $_POST['supplierlist'][0];
            $order_model->paysource = $_POST['paysource'];
            $order_model->paytype=1;

            $model->maxtpricejifen=intval($_POST['maxtpricejifen']);
            $model->save();
        }
        if($status!=$oldstatus)
           $order_model->status = $status;

        $model->update();
        $order_model->update();
        if ($order_model->saved())
        {
            //价格更新,更新计算价格
            if($org_price * 100 != $_POST['price'] * 100)
            {
                Model_Member_Order_Compute::update($order_model->ordersn);
            }
        }
        Model_Member_Order::back_order_status_changed($oldstatus,$order_model->as_array(),'Model_Customize');
        echo json_encode(array('status' => $status));
    }
    /*
     * 订单统计数据查看
     * */
    public function action_dataview()
    {
        $year = date('Y');
        $this->assign('thisyear', $year);
        $this->assign('typeid', $this->_typeid);
        $this->display('admin/customize/order/data_view');
    }

    public function action_ajax_copy_linedoc()
    {
        $linedoc = $_POST['linedoc'];
        foreach($linedoc['path'] as $k=>$v)
        {
            $suffix = substr($v,strrpos($v,'.')+1);
            $new_name = date('YmdHis').$k.'.'.$suffix;
            $url_file = dirname($v).'/'.$new_name;
            $new_file = BASEPATH.dirname($v).'/'.$new_name;
            $file = realpath(BASEPATH . $v);
            $result = copy($file,$new_file);
            $linedoc['path'][$k] = $url_file;
        }
        echo json_encode($linedoc);
    }

    public function action_ajax_del_doc()
    {
        $bool = false;
        if (isset($_POST['file']))
        {
            //删除文件
            $file = realpath(BASEPATH . $_POST['file']);
            $bool = unlink($file);
            if ($bool && isset($_POST['id']))
            {
                $data=DB::select()->from('customize')->where('id', '=', $_POST['id'])->execute()->current();
                if(!empty($data)){
                    $attach=unserialize($data['linedoc']);
                    foreach($attach['path'] as $k=>$v){
                        if($v==$_POST['file']){
                            unset($attach['path'][$k]);
                            unset($attach['name'][$k]);
                            break;
                        }
                    }
                    DB::update('customize')->set(array('linedoc' => serialize($attach)))->where('id', '=', $_POST['id'])->execute();
                }
            }
        }
        echo json_encode(array('status' => $bool));
    }
}