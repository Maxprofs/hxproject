<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Class Controller_Admin_Spot_Order
 * 景点订单管理
 */
class Controller_Admin_Spot_Order extends Stourweb_Controller
{
    private $_typeid = 5;
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
     * 酒店订单列表
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
            $supplier_list = DB::query(Database::SELECT, "SELECT id,suppliername FROM sline_supplier WHERE find_in_set({$this->_typeid},authorization)")->execute()->as_array();

            $saleman_list  = DB::select('username')->from('admin')->execute()->as_array();
            $this->assign('supplier_list', $supplier_list);
            $this->assign('paysources', Model_Member_Order::get_pay_source());
            $this->assign('statusnames', $status_json_arr);
            $this->assign('position', $channelname . '订单');
            $this->assign('channelname', $channelname);
            $this->assign('saleman_list',$saleman_list);
            $this->display('admin/spot/order/list');
        }
        else if ($action == 'read')    //读取列表
        {
            $start = Arr::get($_GET, 'start');
            $limit = Arr::get($_GET, 'limit');
            $keyword = Arr::get($_GET, 'keyword');
            $status = $_GET['status'];
            $paysource = $_GET['paysource'];
            $sort = json_decode($_GET['sort'], true);
            $webid = $_GET['webid'];

            $source = $_GET['source']; //预订来源
            $paytype = $_GET['paytype'];//预订方式
            $pay_way = $_GET['pay_way'];//支持的支付方式
            $supplierid = $_GET['supplierid'];//供应商
            $saleman = $_GET['saleman'];
            //查询数组
            $params = array(
                'start' => $start,
                'limit' => $limit,
                'keyword' => $keyword,
                'status' => $status,
                'paysource' => $paysource,
                'typeid' => $this->_typeid,
                //'webid' => $webid,
                'sort' => $sort[0],
                'source' => $source,
                'paytype' => $paytype,
                'pay_way' => $pay_way,
                'supplierid' => $supplierid,
                'saleman'=>$saleman
            );
            $result = Model_Member_Order::back_order_list($params);
            $status=DB::select()->from('spot_order_status')->where('is_show','=',1)->execute()->as_array();
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
                    Model_Spot::storage($order['suitid'],$dingnum,$order);
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
                'product_model' => 'Model_Spot'
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

        $suit_info = DB::select()->from('spot_ticket')->where('id','=',$info['suitid'])->execute()->current();
        if(!empty($suit_info))
        {
            $suit_info['tickettypeid_name'] = DB::select('kindname')->from('spot_ticket_type')->where('id','=',$suit_info['tickettypeid'])->execute()->get('kindname');
            $this->assign('suit_info',$suit_info);
        }

        //供应商信息
        if($info['supplierlist'])
        {
            $supplier = DB::select('suppliername','mobile')
                ->from('supplier')
                ->where('id','=',$info['supplierlist'])
                ->execute()
                ->current();
            $this->assign('supplier',$supplier);
        }
        //游客信息
        $tourers = Model_Member_Order_Tourer::get_tourer_by_orderid($info['id']);

        //发票信息
        $bill = DB::select()->from('member_order_bill')->where('orderid','=',$info['id'])->execute()->current();

        //套餐信息
        $suit = DB::select()->from('spot_ticket')->where('id','=',$info['suitid'])->execute()->current();


        $status = DB::select()->from('spot_order_status')->where('is_show', '=', 1)->order_by('displayorder', 'asc')->execute()->as_array();
        foreach ($status as $v)
        {
            if ($v['status'] == $info['status'])
            {
                $this->assign('current_status', $v);
                break;
            }
        }

        //关系
        $relationship = array(
            '0' => array(0,1,2,3,5),
            '1' => array(1,2,3,5),
            '2' => array(2,4,5),
            '3' => array(),
            '4' => array(),
            '5' => array(),
            '6' => array(4)
        );

        //收益信息
        $income = Model_Member_Order_Compute::get_income_info($info['id']);
        if(St_Functions::is_normal_app_install('mobiledistribution') && method_exists('Model_Fenxiao','get_order_fenxiao_info'))
        {
            $fenxiao_info = Model_Fenxiao::get_order_fenxiao_info($info);
            $income['platform_income'] = $income['platform_income']-floatval($fenxiao_info['commission'])-floatval($fenxiao_info['commission1'])-floatval($fenxiao_info['commission2'])-floatval($fenxiao_info['commission3']);

            $this->assign('fenxiao_info',$fenxiao_info);
        }
        if(!empty($income))
        {
            $this->assign('income',$income);
        }

        //业务员
        $saleman  = DB::select('username')->from('admin')->execute()->as_array();
        $this->assign('saleman',$saleman);

        $info = Pay_Online_Refund::get_refund_info($info);
        $this->assign('member',$member);
        $this->assign('tourers', $tourers);
        $this->assign('bill',$bill);
        $this->assign('suit',$suit);
        $this->assign('info', $info);
        $this->assign('typeid', $typeid);
        $this->assign('orderstatus', $status);
        $this->assign('relationship',$relationship);
        $this->display('admin/spot/order/view');
    }

    /*
     * 保存
     * */
    public function action_ajax_save()
    {

        $id = $_POST['id'];
        $paysource = Arr::get($_POST, 'paysource');
        //新订单状态
        $new_status = Arr::get($_POST,'status');
        //业务员
        $saleman = Arr::get($_POST,'saleman');
        //支付凭证
        $payment_proof = Arr::get($_POST,'payment_proof') ? Arr::get($_POST,'payment_proof') : '' ;
        //内部优惠
        $platform_discount = Arr::get($_POST,'platform_discount') ? Arr::get($_POST,'platform_discount') : 0 ;
        //关闭原因
        $close_reason = Arr::get($_POST,'close_reason') ? Arr::get($_POST,'close_reason') : '';

        //退款原因
        $refund_reason = Arr::get($_POST,'refund_reason') ? Arr::get($_POST,'refund_reason') : '';

        //退款渠道
        $refund_source = Arr::get($_POST,'refund_source') ? Arr::get($_POST,'refund_source') : '';

        //退款类型
        $refund_type = Arr::get($_POST,'refund_type') ? intval(Arr::get($_POST,'refund_type')):0;

        //退款金额
        $refund_price = Arr::get($_POST,'refund_price') ? Arr::get($_POST,'refund_price') : 0;

        //线下退款凭证
        $refund_proof = Arr::get($_POST,'refund_proof') ? Arr::get($_POST,'refund_proof') : '';

        //拒绝退款原因
        $reject_refund_reason = Arr::get($_POST,'reject_refund_reason') ? Arr::get($_POST,'reject_refund_reason') : '';

        $old_order_info = DB::select()->from('member_order')->where('id','=',$id)->execute()->current();
        //更新信息
        $data = array();
        //业务员
        if(!empty($saleman))
        {
            $data['saleman'] = $saleman;
        }
        //线下支付
        if(!empty($paysource))
        {
            //支付时间
            $data['paytime'] = time();
            $data['paysource'] = $paysource;
            $data['payment_proof'] = $payment_proof;
        }
        //平台优惠,当前订单是未支付状态.
        if(intval($platform_discount) >= 0 && $old_order_info['status'] == 1)
        {
            $data['platform_discount'] = $platform_discount;
        }
        //订单关闭原因
        if(!empty($close_reason))
        {
            $data['close_reason'] = $close_reason;
        }
        //订单退款原因
        if(!empty($refund_reason))
        {
            $data['refund_reason'] = $refund_reason;

        }
        //订单状态发生变化
        if($old_order_info['status'] != $new_status && $new_status)
        {

            $data['status'] = $new_status;
            //新状态变为待消费的情况
            if($new_status == 2)
            {
                if(!$old_order_info['eticketno'])
                {
                    $data['eticketno'] = Common::get_eticketno();
                }
            }
            //变为已退款状态,执行退款操作
            else if($new_status == 4)
            {
                $data['refund_reason'] = $refund_reason;
                //如果在线交易号不为空,则执行线上退款操作.
                if($old_order_info['online_transaction_no'] != ''&&$refund_type==1)
                {
                    $offline = false;
                    $refund_data = array(

                        'refund_reason' => $refund_reason,
                        'refund_platform' => $refund_source,
                        'refund_type' => 1,

                    );
                    Pay_Online_Refund::refund_start($old_order_info['ordersn'],'Model_Spot',$offline,$refund_data);
                }
                //线下退款
                else
                {

                    $offline = true;
                    $refund_data = array(
                        'refund_proof' => $refund_proof,
                        'refund_reason' => $refund_reason,
                        'refund_platform' => $refund_source,
                        'refund_type' => 0,

                    );
                    Pay_Online_Refund::refund_start($old_order_info['ordersn'],'Model_Spot',$offline,$refund_data);

                }
            }
            //新订单状态变为关闭,记录关闭原因.
            else if($new_status == 3)
            {
                $data['close_reason'] = $close_reason;
            }
        }
        $status = false;
        if(count($data)>0)
        {
            $flag = DB::update('member_order')->set($data)->where('id','=',$id)->execute();
            if($flag)
            {
                $product_model = 'Model_Spot';
                $order = DB::select()->from('member_order')->where('id', '=', $id)->execute()->current();

                //如果内部优惠更新,则更新订单统计表
                if($platform_discount >=0)
                {
                    Model_Member_Order_Compute::update($order['ordersn']);
                    //价格变化,预订送积分重新计算
                    Model_Member_Order::update_order_jifen($order);

                }
                $status = Model_Member_Order::back_order_status_changed($old_order_info['status'], $order, $product_model);
            }
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
        $this->display('admin/spot/order/data_view');
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
        $this->assign('params',$_GET);
        $this->assign('statusnames', Model_Member_Order::$order_status);
        $this->display('admin/spot/order/excel');
    }

   /* public function action_genexcel()
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

        if (empty($excel))
        {
            echo iconv('utf-8', 'gbk', $excel);
        }
        else
        {
            echo $excel;
        }
        exit();
    }*/


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
        $model = 'Model_Spot';
        $type = $_POST['type'];
        $ordersn = $_POST['ordersn'];
        $description = $_POST['description'];
        $order = Model_Member_Order::order_info($ordersn);
        $pay_online = $order['pay_online'];
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


    /*
     * 添加订单
     * */
    public function action_add()
    {
        $status_json_arr = array();
        foreach (Model_Member_Order::$order_status as $k => $v)
        {
            $status_json_arr[] = array('status' => $k, 'name' => $v);
        }
        $this->assign('statusnames', $status_json_arr);
        $this->display('admin/spot/order/add');
    }

    /**
     * 获取产品套餐
     */
    public function action_ajax_suit_list()
    {
        $status = 0;
        $product_id = intval($_POST['product_id']);
        $arr = DB::select()->from('spot_ticket')->where('spotid', '=', $product_id)->and_where('status','=',3)->execute()->as_array();
        if (count($arr) > 0)
        {
            $status = 1;
        }
        echo json_encode(array('status' => $status, 'list' => $arr));
    }

    /**
     * 获取套餐选择日期报价
     */
    public function action_ajax_suit_price()
    {
        $suit_id = intval(Arr::get($_GET, 'suit_id'));
        $useday = strtotime(Arr::get($_GET, 'useday'));
        $price_info = DB::select()->from('spot_ticket_price')->where('ticketid','=',$suit_id)->and_where('day','=',$useday)->execute()->current();
        $price_info['price'] = Currency_Tool::price($price_info['adultprice']);
        echo json_encode($price_info);
    }

    /**
     * 日历报价
     */
    public function action_dialog_calendar()
    {

        $suitid = intval($this->params['suitid']);
        $year = intval($this->params['year']);
        $month = intval($this->params['month']);
        $nowDate = new DateTime();
        $year = !empty($year) ? $year : $nowDate->format('Y');
        $month = !empty($month) ? $month : $nowDate->format('m');
        $out = '';

        $starttime = strtotime("$year-$month-1");
        $endtime = strtotime("$year-$month-1 +1 month -1 day");

        $curtime = time();
        $sql = "select a.* from sline_spot_ticket_price a left join sline_spot_ticket b on a.ticketid=b.id where a.day>({$curtime}+b.day_before*24*3600-case when (b.hour_before=0 and b.minute_before=0) then 24*3600 else (3600*b.hour_before+b.minute_before*60) end) and a.day>={$starttime} and a.day<={$endtime} and a.ticketid='{$suitid}' ";
        $price_arr = DB::query(Database::SELECT,$sql)->execute()->as_array();
        ////////////////////////////

        $price_set_arr = array();
        foreach($price_arr as &$v)
        {
            $v['price'] = Currency_Tool::price($v['adultprice']);
            $price_set_arr[$v['day']] = $v;
        }

        $calendar = $this->calender($year, $month, $price_set_arr, $suitid);
        $this->assign('calendar',$calendar);
        $this->assign('suitid',$suitid);
        $this->display('admin/spot/order/dialog_calendar');
    }

     private  function calender($year = '', $month = '', $priceArr = NULL, $suitid, $contain = '')
    {

        date_default_timezone_set('Asia/Shanghai');
        $year = abs(intval($year));
        $month = abs(intval($month));
        $tmonth = $month < 10 ? "0" . $month : $month;
        $defaultYM = $year . '-' . $tmonth;
        $nowDate = new DateTime();
        if ($year <= 0)
        {
            $year = $nowDate->format('Y');
        }
        if ($month <= 0 or $month > 12)
        {
            $month = $nowDate->format('m');
        }
        //上一年
        $prevYear = $year - 1;
        //上一月
        $mpYear = $year;
        $preMonth = $month - 1;
        if ($preMonth <= 0)
        {
            $preMonth = 12;
            $mpYear = $prevYear;
        }
        $preMonth = $preMonth < 10 ? '0' . $preMonth : $preMonth;
        //下一年
        $nextYear = $year + 1;
        //下一月
        $mnYear = $year;
        $nextMonth = $month + 1;
        if ($nextMonth > 12)
        {
            $nextMonth = 1;
            $mnYear = $nextYear;
        }
        $nextMonth = $nextMonth < 10 ? '0' . $nextMonth : $nextMonth;
        //日历头
        $html = '<div id="calendar_tab">
<table width="100%" border="1" style="border-collapse: collapse;">

  <tr align="center" >
    <td class="top_title"><a id="premonth" data-year="' . $mpYear . '" class="prevmonth" data-suitid="' . $suitid . '"  data-month="' . $preMonth . '" href="javascript:;" data-contain="' . $contain . '">上一月</a></td>
    <td colspan="3" class="top_title" style="height:50px;">' . $year . '年' . $month . '月</td>
    <td class="top_title"><a id="nextmonth"  data-year="' . $mnYear . '" class="nextmonth" data-suitid="' . $suitid . '" data-month="' . $nextMonth . '" href="javascript:;" data-contain="' . $contain . '">下一月</a></td>

  </tr>
  <tr>
  	<td colspan="5">
		<table width="100%" border="1" >
			<tr align="center">
				<td style="height:25px;">一</td>
				<td style="height:25px;">二</td>
				<td style="height:25px;">三</td>
				<td style="height:25px;">四</td>
				<td style="height:25px;">五</td>
				<td style="height:25px;">六</td>
				<td style="height:25px;">日</td>
			</tr>
';

        $currentDay = $nowDate->format('Y-m-j');

        //当月最后一天
        $creatDate = new DateTime("$year-$nextMonth-0");
        $lastday = $creatDate->format('j');
        $creatDate = NULL;

        //循环输出天数
        $day = 1;
        $line = '';
        while ($day <= $lastday)
        {
            $cday = $year . '-' . $month . '-' . $day;

            //当前星期几
            $creatDate = new DateTime("$year-$month-$day");
            $nowWeek = $creatDate->format('N');
            $creatDate = NULL;

            if ($day == 1)
            {
                $line = '<tr align="center">';
                $line .= str_repeat('<td>&nbsp;</td>', $nowWeek - 1);
            }
            if ($cday == $currentDay)
            {
                $style = 'style="font-size:16px; font-family:微软雅黑,Arial,Helvetica,sans-serif;color:#FF6600;line-height:22px;"';
            }
            else
            {
                $style = 'style=" font-size:16px; font-family:微软雅黑,Arial,Helvetica,sans-serif;line-height:22px;"';
            }
            //判断当前的日期是否小于今天
            $defaultmktime = mktime(1, 1, 1, $month, $day, $year);

            $currentmktime = mktime(1, 1, 1, date("m"), date("j"), date("Y"));
            //echo '<hr>';
            $tday = ($day < 10) ? '0' . $day : $day;
            $cdaydate = $defaultYM . '-' . $tday;
            $cdayme = strtotime($cdaydate);
            //单价
            $dayPrice = $priceArr[$cdayme]['price'];

            //库存
            $priceArr[$cdayme]['number'] = $priceArr[$cdayme]['number'] < -1 ? 0 : $priceArr[$cdayme]['number'];
            $number = $priceArr[$cdayme]['number'] != -1 ? $priceArr[$cdayme]['number'] : '充足';
            $numstr = '<b style="font-weight:normal">余位&nbsp;' . $number . '</b>';

            //定义单元格样式，高，宽
            $tdStyle = "height='80'";
            //判断当前的日期是否小于今天
            $tdcontent = '<span class="num">' . $day . '</span>';
            if ($defaultmktime >= $currentmktime)
            {


                if ($dayPrice)
                {

                    $dayPriceStrs = Currency_Tool::symbol() . $dayPrice . '<br>';
                    $balanceStr = '';

                    $tdcontent .= '<b class="price">' . $dayPriceStrs . '</b>' . $balanceStr;
                    if ($numstr)
                    {
                        $tdcontent .= $numstr;
                    }
                    if ($number === 0)
                    {
                        $onclick = '';
                    }
                    else
                    {
                        $onclick = 'onclick="choose_day(\'' . $cday . '\',\'' . $contain . '\')"';
                    }

                }
                else
                {
                    $dayPriceStrs = '';
                    $tdcontent .= '<b class="no_yd"></b>' . '<b class="roombalance_b"></b>';
                    $onclick = '';
                    $numberinfo = "<span class='kucun'></span>";

                }
                if ($onclick == '')
                {

                    $line .= "<td $tdStyle class='nouseable' >" . $tdcontent . "</td>";
                }
                else
                {
                    $line .= "<td $tdStyle $onclick style='cursor:pointer;' class='useable' >" . $tdcontent . "</td>";
                }
            }
            else
            {
                $dayPriceStrs = '&nbsp;&nbsp;';
                $tdcontent .= '<b class="no_yd"></b>';
                $line .= "<td $tdStyle class='nouseable' >" . $tdcontent . "</td>";
            }


            //$line .= "<td $style>$day <div>不可订</div></td>";

            //一周结束
            if ($nowWeek == 7)
            {
                $line .= '</tr>';
                $html .= $line;
                $line = '<tr align="center">';
            }

            //全月结束
            if ($day == $lastday)
            {
                if ($nowWeek != 7)
                {
                    $line .= str_repeat('<td>&nbsp;</td>', 7 - $nowWeek);
                }
                $line .= '</tr>';
                $html .= $line;

                break;
            }

            $day++;
        }

        $html .= '
		</table>
	</td>
  </tr>
</table>
</div>
';
        return $html;

    }

    //保存订单
    public function action_ajax_save_order()
    {
        //会员信息
        $memberId = $_POST['member_id'];//会员id
        $webid = 0;//网站id
        $dingnum = intval(Arr::get($_POST, 'dingnum'));//成人数量
        $suit_id = intval(Arr::get($_POST, 'suitid'));//套餐id
        $product_id = intval(Arr::get($_POST, 'product_id'));//线路id
        $usedate = Arr::get($_POST, 'usedate');//出发日期
        $linkMan = Arr::get($_POST, 'linkman');//联系人姓名
        $linkTel = Arr::get($_POST, 'linktel');//联系人电话
        $linkEmail = Arr::get($_POST, 'linkemail');//联系人邮箱
        $remark = Arr::get($_POST, 'remark');//订单备注
        $status = Arr::get($_POST, 'status');//订单状态

        $useJifen = 0;
        $paysource = Arr::get($_POST, 'paysource');//支付来源



        //游客信息读取
        $t_name = Arr::get($_POST, 't_name');
        $t_cardtype = Arr::get($_POST, 't_cardtype');
        $t_cardno = Arr::get($_POST, 't_cardno');
        $t_sex = Arr::get($_POST, 't_sex');
        $t_mobile = Arr::get($_POST, 't_mobile');
        $tourer = array();
        for ($i = 0; $i < $dingnum; $i++)
        {
            if (empty($t_name[$i]))
            {
                continue;
            }
            $tourer[] = array(
                'name' => $t_name[$i],
                'cardtype' => $t_cardtype[$i],
                'cardno' => $t_cardno[$i],
                'sex' => $t_sex[$i],
                'mobile' => $t_mobile[$i],
            );
        }


        //套餐信息
        $suit_info = DB::select()->from('spot_ticket')->where('id', '=', $suit_id)->execute()->current();

        //产品信息
        $info = ORM::factory('spot', $product_id)->as_array();
        //套餐按出发日期价格
        $suit_price =  DB::select()->from('spot_ticket_price')->where('ticketid', '=', $suit_id)->and_where('day', '=', strtotime($usedate))->execute()->current();
        $suit_price['adultprice'] = Currency_Tool::price($suit_price['adultprice']);
        $suit_price['dingjin'] = Currency_Tool::price($suit_price['dingjin']);


        $orderSn = St_Product::get_ordersn('5');


        $arr = array(
            'ordersn' => $orderSn,
            'webid' => $webid,
            'typeid' => $this->_typeid,
            'productautoid' => $info['id'],
            'productaid' => $info['aid'],
            'productname' => $info['title'] . "({$suit_info['suitname']})",
            'price' => $suit_price['adultprice'],
            'childprice' => 0,
            'oldprice' => 0,
            'usedate' => $usedate,
            'dingnum' => $dingnum,
            'childnum' => 0,
            'oldnum' => 0,
            'linkman' => $linkMan,
            'linktel' => $linkTel,
            'linkemail' => $linkEmail,
            'jifentprice' => 0,
            'jifenbook' => 0,
            'jifencomment' => 0,
            'addtime' => time(),
            'memberid' => $memberId,
            'dingjin' => $suit_price['dingjin'],
            'paytype' => $suit_price['paytype'],
            'suitid' => $suit_id,
            'usejifen' => 0,
            'needjifen' => 0,
            'status' => $status,
            'remark' => $remark,
            'isneedpiao' => 0,
            'paysource' => $paysource,
            'source' => 4,
            'supplierlist' => $suit_info['supplierlist']

        );

        //添加订
        $result = $this->add_order($arr,'Model_Spot',$arr);
        if ($result['status'])
        {
            $orderInfo = Model_Member_Order::get_order_by_ordersn($orderSn);
            Model_Member_Order_Tourer::add_tourer_pc($orderInfo['id'], $tourer, $memberId);
            //发票信息存储
            $flag = 1;
            //二次确认状态,设置的支付状态切换
            if ($suit_info['paytype'] == 3 && $status > 1)
            {
                DB::update('member_order')->set(array('status' => $status))->where('id', '=', $orderInfo['id'])->execute();
            }
            //订单状态改变短信发送
           // Model_Member_Order::back_order_status_changed(0, $orderInfo, 'Model_Spot');
        }
        echo json_encode($result);

    }

    public function action_genexcel()
    {

        $typeid = $this->_typeid;
        $timetype = $this->params['timetype'];
        $starttime = empty($_GET['starttime'])? null:strtotime($_GET['starttime'].' 00:00:00');
        $endtime =empty($_GET['endtime'])?null: strtotime($_GET['endtime'].' 23:59:59');
        $status = $_GET['status'];

        $time_arr = array();
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
        //$excel = Model_Member_Order::back_order_excel($time_arr, $typeid, $status);


        $sort = json_decode($_GET['sort'], true);
        //$webid = $_GET['webid'];
        //查询数组
        $params = array(
            'keyword' => $_GET['keyword'],
            'status' => $_GET['status'],
            'paysource' => $_GET['paysource'],
            'sort' => $sort[0],
            'source' => $_GET['source'],
            'paytype' => $_GET['paytype'],
            'pay_way' => $_GET['pay_way'],
            'supplierid' =>$_GET['supplierid'],
            'saleman'=>$_GET['saleman'],
            'start_time'=>$time_arr[0],
            'end_time'=>$time_arr[1],
            'time_target'=>$_GET['time_target'],
            'sort_property'=>$_GET['sort_property'],
            'sort_direction'=>$_GET['sort_direction']
        );


        $order_list = $this->get_order_list($params);
        $excel = $this->gene_excel($order_list);

        $filename = date('Ymdhis');
        ob_end_clean();//清除缓冲区
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
        echo iconv('utf-8', 'gbk', $excel);
        exit();
    }
    protected function get_order_list($params)
    {
        $status = $params['status'];
        $keyword = $params['keyword'] ? $params['keyword'] : '';
        $paysource = $params['paysource'] ? $params['paysource'] : '';
        $start_time = $params['start_time'] ? $params['start_time'] : '';
        $end_time = $params['end_time'] ? $params['end_time'] : '';
        $eticketno = $params['eticketno'] ? $params['eticketno'] : '';
        $memberid = $params['memberid'];
        $isconsume = $params['isconsume'];
        //$webid = $params['webid'] ? $params['webid'] : 0;
        // $sort = $params['sort'] ? $params['sort'] : array();

        $source = $params['source'] ? $params['source'] : 0;
        $paytype = $params['paytype'] ? $params['paytype'] : 0;
        $pay_way = $params['pay_way'] ? $params['pay_way'] : 0;
        $saleman = $params['saleman'];
        $time_target = $params['time_target'];

        $supplierid = is_numeric($params['supplierid']) ? $params['supplierid'] : -1;

        $sort_direction = $params['sort_direction'];
        $sort_direction = empty($sort_direction)?'ASC':$sort_direction;
        $sort_property = $params['sort_property'];

        $order = 'order by a.addtime desc';
        if (!empty($sort_property)) {
            $order = " order by a.{$sort_property} {$sort_direction},a.addtime desc";
        }

        $w = "where a.id>0 ";

        $w .= ' and a.typeid=' . $this->_typeid;

        if (!empty($status) || $status === 0 || $status === '0') {
            $w .= ' and a.status=' . $status;
        }
        if (!empty($isconsume) || $isconsume === 0 || $isconsume === '0') {
            $w .= ' and a.isconsume=' . $isconsume;
        }
        if (!empty($memberid) || $memberid === 0 || $memberid === '0') {
            $w .= ' and a.memberid=' . $memberid;
        }
        if (!empty($eticketno)) {
            $w .= " and a.eticketno='$eticketno'";
        }
        if (!empty($paysource)) {
            $w .= " and a.paysource='$paysource'";
        }


        if(empty($time_target))
        {
            if (!empty($start_time)) {
                $w .= " and a.addtime>=$start_time";
            }
            if (!empty($end_time)) {
                $w .= " and a.addtime<=$end_time";
            }
        }
        else if($time_target==1)
        {
            if (!empty($start_time)) {
                $w .= " and unix_timestamp(a.usedate)>=$start_time";
            }
            if (!empty($end_time)) {
                $w .= " and unix_timestamp(a.usedate)<=$end_time";
            }
        }


        if(!empty($saleman))
        {
            $w .= " and a.saleman='{$saleman}'";
        }
        if (!empty($keyword)) {
            $w .= " and (a.ordersn like '%{$keyword}%' or a.linkman like '%{$keyword}%' or a.linktel like '%{$keyword}%' or a.linkemail like '%{$keyword}%' or a.productname like '%{$keyword}%' or a.eticketno='{$keyword}')";
        }
        /* if ($webid >= 0) {
             $w .= " and a.webid=" . $webid;
         }*/
        if($source)
        {
            $w .= " and a.source=" . $source;
        }
        if($paytype)
        {
            $w .= " and a.paytype=" . $paytype;
        }
        //支付方式
        if($pay_way && $pay_way!=3)
        {
            //线上支付
            if($pay_way == 1)
            {
                $w .= " and a.online_transaction_no!='' and a.paytime>0";
            }
            //线下支付
            else if($pay_way == 2)
            {
                $w .= " and a.online_transaction_no='' and a.paytime>0 ";
            }
        }
        if ($supplierid != -1)
        {
            if ($supplierid == 0)
            {
                $w .= " and (a.supplierlist is null or a.supplierlist='')";
            } else
            {
                $w .= " and a.supplierlist='" . $supplierid . "'";
            }
        }

        $w .= " and b.virtual!=2";

        $sql = "SELECT a.*,c.suppliername,c.email as supplieremail,c.mobile as suppliermobile FROM `sline_member_order` AS a
        LEFT JOIN `sline_member` AS b ON(a.memberid=b.mid)
        LEFT JOIN `sline_supplier` AS c ON(a.supplierlist=c.id) $w $order";

        $list = DB::query(Database::SELECT, $sql)->execute()->as_array();
        $new_list = array();
        foreach ($list as $k => $v) {

            $v['addtime'] = date('Y-m-d H:i:s', $v['addtime']);
            $v['price'] = Model_Member_Order::order_total_payprice($v['id'], $v);
            $v['statusname'] = Model_Member_Order::get_status_name($v['status']); //$order_status[$v['status']];
            $v['dingnum'] = $v['dingnum'] + $v['childnum'] + $v['oldnum'];

            //订单总价信息
            $total_info = Model_Member_Order_Compute::get_order_price($v['id']);
            if($total_info && !empty($total_info['total_price']))
            {
                $v['price'] = $total_info['pay_price'];
            }
            $new_list[] = $v;
        }
        return $new_list;
    }

    protected function gene_excel($order_list)
    {

        $table = "<table border='1' ><tr>";
        $table .= "<td>订单号</td>";
        $table .= "<td>产品名称</td>";
        $table .= "<td>预订日期</td>";
        $table .= "<td>使用日期</td>";
        $table .= "<td>数量</td>";
        $table .= "<td>价格</td>";

        //$table .= "<td>保险</td>";

        $table .= "<td>应付总额</td>";
        $table .= "<td>交易状态</td>";
        $table .= "<td>供应商</td>";
        $table .= "<td>业务员</td>";
        $table .= "<td>预订人</td>";
        $table .= "<td>联系电话</td>";
        $table.= "<td><table border='1'><tr><td colspan='5'>游客信息</td></tr><tr><td>姓名</td><td>性别</td><td>手机号</td><td>证件类型</td><td>证件号码</td></tr></table></td>";

        $table .= "</tr>";
        foreach ($order_list as $row)
        {

            $tourers = Model_Member_Order_Tourer::get_tourer_by_orderid($row['id']);

            $childOrderLabel = $row['pid'] == 0 ? '' : "[子订单]";
            $table .= "<tr>";
            $table .= "<td style='vnd.ms-excel.numberformat:@'>" . $childOrderLabel . "{$row['ordersn']}</td>";
            $table .= "<td>{$row['productname']}</td>";
            $table .= "<td>" .$row['addtime']. "</td>";
            $table .= "<td>{$row['usedate']}</td>";
            $table .= "<td>{$row['dingnum']}</td>";
            $table .= "<td>{$row['price']}</td>";
            // $table .= "<td>{$insurancePrice}</td>";

            $table .= "<td>{$row['price']}</td>";
            $table .= "<td>{$row['statusname']}</td>";
            $table .= "<td>{$row['suppliername']}</td>";
            $table .= "<td>{$row['saleman']}</td>";
            $table .= "<td>{$row['linkman']}</td>";
            $table .= "<td>{$row['linktel']}</td>";
            $table .= "<td><table border='1'>";

            if(!empty($tourers) && count($tourers)>0)
            {
                foreach ($tourers as $tourer) {
                    $table .= "<tr><td>{$tourer['tourername']}</td><td>{$tourer['sex']}</td><td>{$tourer['mobile']}</td><td>{$tourer['cardtype']}</td><td style='vnd.ms-excel.numberformat:@'>{$tourer['cardnumber']}</td></tr>";
                }
            }
            else
            {
                $table .= "<tr><td></td><td></td><td></td><td></td><td></td></tr>";
            }
            $table .= "</table></td>";
            $table .= "</tr>";


        }

        $table .= "</table>";
        return $table;
    }

    private function add_order($arr, $productModel, $params)
    {
        $flag = 0;
        $model = ORM::factory('member_order');
        if (is_array($arr))
        {
            //下单用户信息再次检查
            if (empty($arr['memberid']))
            {
                return array('status'=>false,'msg'=>'购买会员不能为空');
            }
            $db = Database::instance();
            $db->begin();
            try
            {
                //减存
                $dingnum = intval($arr['dingnum']) + intval($arr['childnum']) + intval($arr['oldnum']);
                $bool = call_user_func(array($productModel, 'storage'), $arr['suitid'], '-' . $dingnum, $params);
                if (!$bool)
                {
                   throw new Exception('库存不足');
                }

                //线路户外二次确认流程调整,不走此逻辑

                foreach ($arr as $k => $v)
                {
                    $model->$k = $v;
                }
                $model->save();
                if (!$model->saved())
                {
                    //回滚库存
                    call_user_func(array($productModel, 'storage'), $arr['suitid'], $dingnum, $params);
                    throw new Exception('添加订单错误');
                }
                $db->commit();
            }
            catch (Exception $e)
            {
                $db->rollback();
                return array('status'=>false,'msg'=>$e->getMessage());
            }
            //预订送积分
            $model->jifenbook_id = $arr['jifenbook'];
            $model->jifenbook = St_Product::calculate_jifenbook($arr['jifenbook'], $model->typeid, $model->ordersn);
            $model->update();

            //添加日志
            Model_Member_Order_Log::add_log($model->as_array());

            //扣除积分
            if ($arr['usejifen'] && $arr['needjifen'])
            {
                Model_Member_Jifen::deduct($arr['ordersn']);
            }

            Model_Message::add_order_msg($model->as_array());
            //订单监控
            $detectresult = Model_Member_Order::detect($arr['ordersn']);
            //   var_dump($detectresult);exit;

            //用户通知信息
            if ($arr['status'] == '0')
            {
                St_SMSService::send_product_order_msg(NoticeCommon::PRODUCT_ORDER_UNPROCESSING_MSGTAG, $arr);
                St_EmailService::send_product_order_email(NoticeCommon::PRODUCT_ORDER_UNPROCESSING_MSGTAG, $arr);
            }
            else
            {
                St_SMSService::send_product_order_msg(NoticeCommon::PRODUCT_ORDER_PROCESSING_MSGTAG, $arr);
                St_EmailService::send_product_order_email(NoticeCommon::PRODUCT_ORDER_PROCESSING_MSGTAG, $arr);
            }

            //订单结算信息表数据存储
            Model_Member_Order_Compute::add($arr['ordersn']);

            if(St_Functions::is_normal_app_install('mobiledistribution') && method_exists('Model_Fenxiao','book_data'))
            {
                Model_Fenxiao::book_data($arr['ordersn']);
            }
        }
        return array('status'=>true);
    }



}