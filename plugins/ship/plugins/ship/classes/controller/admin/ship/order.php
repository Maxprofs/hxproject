<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Ship_Order extends Stourweb_Controller
{
    private $_typeid =104;
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
     * 租车订单列表
     * */
    public function action_index()
    {
        $action = $this->params['action'];
        $webid = Arr::get($_GET, 'webid');
        //订单模板
        $channelname = Model_Model::get_module_name($this->_typeid);

        if (empty($action))  //显示列表
        {
            $status_json_arr=array();
            foreach(Model_Member_Order::$order_status as $k=>$v)
            {
                $status_json_arr[]=array('status'=>$k,'name'=>$v);
            }
            $this->assign('paysources', Model_Member_Order::get_pay_source());
            $this->assign('statusnames', $status_json_arr);
            $this->assign('position', $channelname . '订单');
            $this->assign('channelname', $channelname);
            $this->display('admin/ship/order/list');
        }
        else if ($action == 'read')    //读取列表
        {
            $start = Arr::get($_GET, 'start');
            $limit = Arr::get($_GET, 'limit');
            $keyword = Arr::get($_GET, 'keyword');
            $status = $_GET['status'];
            $paysource = $_GET['paysource'];
            $sort = json_decode($_GET['sort'], true);
            //查询数组
            $params = array(
                'start' => $start,
                'limit' => $limit,
                'keyword' => $keyword,
                'status' => $status,
                'paysource' => $paysource,
                'typeid'   => $this->_typeid,
                'sort'=>$sort[0]
            );
            $result = Model_Member_Order::back_order_list($params);
            $status=DB::select()->from('ship_order_status')->where('is_show','=',1)->execute()->as_array();
            foreach($result['lists'] as &$v){
                foreach($status as $s){

                    if($v['status']==$s['status']){
                        $v['statusname']=$s['status_name'];
                        break;
                    }
                }
            }
            echo json_encode($result);
        }
        else if ($action == 'save')   //保存字段
        {

        }
        else if ($action == 'delete') //删除某个记录
        {
            $rawdata = file_get_contents('php://input');
            $data = json_decode($rawdata);
            $id = $data->id;

            if (is_numeric($id)) //
            {
                $order = Model_Member_Order::get_order_detail($id);
                //订单处理中/等待付款的订单返库存
                if($order['status'] < 3)
                {
                    $dingnum = intval($order['dingnum']) + intval($order['childnum']) + intval($order['oldnum']);
                    Model_Ship_Line::storage($order['suitid'],$dingnum,strtotime($order['userdate']));
                }
                Model_Member_Order::order_delete($id);
            }
        }
        else if ($action == 'update')//更新某个字段
        {
            $id = Arr::get($_POST, 'id');
            $field = Arr::get($_POST, 'field');
            $val = Arr::get($_POST, 'val');
            $params = array(
                'orderid' => $id,
                'field' => $field,
                'value' => $val,
                'product_model' => 'Model_Ship_Line'
            );
            $status = Model_Member_Order::back_order_update_field($params);
            if($status)
            {
                echo 'ok';
                exit();
            }
            else
            {
                echo 'no';
                exit();
            }


        }
    }
    /*
     * 查看订单信息
     * */
    public function action_view()
    {
        $id = $this->params['id'];//订单id.
        $type = $this->params['type'];//订单类型
        $typeid = $this->_typeid;
        $model = ORM::factory('member_order')->where('id', '=', $id)->find();
        $info = $model->as_array();
        if ($model->loaded())
        {
                $model->viewstatus = 1;
                $model->save();
        }
        $info = Model_Member_Order::order_info($info['ordersn']);

        //会员信息
        $member = DB::select('nickname')->from('member')->where('mid','=',$info['memberid'])->execute()->current();
        $info['membername'] = $member['nickname'] ? $member['nickname'] : '';

        //游客信息
        $tourers = Model_Member_Order_Tourer::get_tourer_by_orderid($info['id']);

        //发票信息
        $bill = DB::select()->from('member_order_bill')->where('orderid','=',$info['id'])->execute()->current();

        $sublist = DB::select('*')->from('member_order_child')->where('pid','=',$info['id'])->execute()->as_array();
        $status=DB::select()->from('ship_order_status')->where('is_show','=',1)->execute()->as_array();
        foreach ($status as $v)
        {
            if ($v['status'] == $info['status'])
            {
                $this->assign('current_status', $v);
                break;
            }
        }


        $info = Pay_Online_Refund::get_refund_info($info);
        $this->assign('bill',$bill);
        $this->assign('tourers', $tourers);
        $this->assign('info', $info);
        $this->assign('sublist',$sublist);
        $this->assign('typeid', $typeid);
        $this->assign('orderstatus', $status);
        $this->display('admin/ship/order/view');
    }
    /*
     * 修改订单
     */
    public function action_ajax_save()
    {

        $id = Arr::get($_POST, 'id');
        $status = false;
        $model = ORM::factory('member_order', $id);
        $oldstatus = $model->status;//原来状态.

        $model->status = $_POST['status'];
        $newstatus = $_POST['status'];

        if(in_array($oldstatus,array(0,1)))
        {
            $price_arr = $_POST['price'];
            $main_price = 0;
            foreach($price_arr as $k=>$v)
            {
                $child_order = ORM::factory('member_order_child',$k);
                if($child_order->loaded())
                {
                    $child_order->price = $v;
                    $main_price += $v*$child_order->dingnum;
                    $child_order->save();
                }
            }
            $model->price = $main_price;
            $model->remark = $_POST['remark'];
        }
        $product_model = 'Model_Ship_Line';
        if($model->status <= $newstatus)
        {
            $model->status = $newstatus;
        }

        if ($model->status == "2" && isset($model->eticketno) && $model->eticketno == "")
        {
            $model->eticketno = Common::get_eticketno();
        }
        $model->save();


        if ($model->saved())
        {

           $order = DB::select()->from('member_order')->where('id','=',$id)->execute()->current();
           $status = Model_Member_Order::back_order_status_changed($oldstatus,$order,$product_model);


        }
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
        $this->display('admin/ship/order/data_view');
    }
    /*
     * 异步获取相关统计数据
     * */
    public function action_ajax_sell_info()
    {
        $out = array();
        $typeid = $this->_typeid;

        //今日销售
        $time_arr = St_Functions::back_get_time_range(1);
        $out['today'] = Model_Member_Order::back_caculate_price_by_timerange($time_arr, $typeid);

        //昨日销售
        $time_arr = St_Functions::back_get_time_range(2);
        $out['last'] = Model_Member_Order::back_caculate_price_by_timerange($time_arr, $typeid);

        //本周销售
        $time_arr = St_Functions::back_get_time_range(3);;
        $out['thisweek'] = Model_Member_Order::back_caculate_price_by_timerange($time_arr, $typeid);

        //本月销售
        $time_arr = St_Functions::back_get_time_range(5);
        $out['thismonth'] = Model_Member_Order::back_caculate_price_by_timerange($time_arr, $typeid);

        //全部销售额
        $out['total'] = Model_Member_Order::back_caculate_price_by_timerange(0, $typeid);
        echo json_encode($out);
    }
    //按年进行统计
    public function action_ajax_year_tj()
    {
        $year = $this->params['year'];
        $typeid = $this->_typeid;
        $current_year = date('Y');
        if ($current_year < $year) exit();
        for ($i = 1; $i <= 12; $i++)
        {
            $starttime = date('Y-m-d', mktime(0, 0, 0, $i, 1, $year));//开始时间

            $endtime = strtotime("$starttime +1 month -1 day");//结束时间
            $timearr = array(strtotime($starttime), $endtime);

            $out[$i] = Model_Member_Order::back_order_price_year($timearr, $typeid);
        }
        echo json_encode($out);

    }
    /*
     * 生成excel页面
     * */
    public function action_excel()
    {
        $this->assign('typeid', $this->params['typeid']);
        $this->assign('statusnames', Model_Member_Order::$order_status);
        $this->display('admin/ship/order/excel');
    }
    public function action_genexcel()
    {

        $typeid = $this->_typeid;
        $timetype = $this->params['timetype'];
        $starttime = strtotime(Arr::get($_GET, 'starttime'));
        $endtime = strtotime(Arr::get($_GET, 'endtime'));
        $status = $_GET['status'];
        switch ($timetype)
        {
            case 1:
                $time_arr = St_Functions::back_get_time_range(1);
                break;
            case 2:
                $time_arr = St_Functions::back_get_time_range(2);
                break;
            case 3:
                $time_arr = St_Functions::back_get_time_range(3);
                break;
            case 5:
                $time_arr = St_Functions::back_get_time_range(5);
                break;
            case 6:
                $time_arr = array($starttime, $endtime);
                break;
        }
        $excel = Model_Member_Order::back_order_excel($time_arr,$typeid,$status);

        $filename = date('Ymdhis');
		ob_end_clean();
        header('Pragma:public');
        header('Expires:0');
        header('Content-Type:charset=utf-8');
        header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
        header('Content-Type:application/force-download');
        header('Content-Type:application/vnd.ms-excel');
        header('Content-Type:application/octet-stream');
        header('Content-Type:application/download');
        header('Content-Disposition:attachment;filename=' . $filename . ".xls");
        header('Content-Transfer-Encoding:binary');

        //define("FILETYPE","xls");
        //header("Content-type:application/vnd.ms-excel");
        //header('Content-type: charset=GBK');
        //header('Pragma: no-cache');
        //header('Expires: 0');
        //header("Content-Disposition:filename=".$info['name'].".xls");
        //$str = iconv("UTF-8//IGNORE","GBK//IGNORE",$str);
        if (empty($excel))
        {
            echo iconv('utf-8', 'gbk', $excel);
        }
        else
        {
            echo $excel;
        }
        exit();
    }

    public function action_ajax_sell_tj()
    {
        $out = array();
        $typeid = $this->_typeid;
        //今日销售
        $time_arr = St_Functions::back_get_time_range(1);
        $out['today'] = Model_Member_Order::back_caculate_info_by_timerange($time_arr, $typeid);

        //昨日销售
        $time_arr =St_Functions::back_get_time_range(2);
        $out['last'] = Model_Member_Order::back_caculate_info_by_timerange($time_arr, $typeid);

        //本周销售
        $time_arr =St_Functions::back_get_time_range(3);
        $out['thisweek'] = Model_Member_Order::back_caculate_info_by_timerange($time_arr, $typeid);

        //本月销售
        $time_arr =St_Functions::back_get_time_range(5);
        $out['thismonth'] = Model_Member_Order::back_caculate_info_by_timerange($time_arr, $typeid);

        echo json_encode($out);

    }


    /**
     * @function 退款操作
     */
    public function action_ajax_refund_submit()
    {
        $model = 'Model_Ship_Line';
        $type = $_POST['type'];
        $ordersn = $_POST['ordersn'];
        $description = $_POST['description'];
        if($type == 'allow')
        {
            $status = Pay_Online_Refund::refund_start($ordersn,$model);
        }
        elseif ($type == 'back')
        {
            Pay_Online_Refund::admin_refund_back($ordersn,$model,$description);
            $status = 1;
        }

        echo  json_encode(array('status'=>$status));

    }

}