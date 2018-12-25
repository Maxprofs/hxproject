<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Line_Order extends Stourweb_Controller
{
    private $_typeid = 1;

    /*
     * 订单总控制器
     *
     */
    public function before()
    {
        parent::before();
        $this->assign('typeid', $this->_typeid);
        $action = $this->request->action();

        //这里需要补权限的判断功能

    }

    /*
     * 线路订单列表
     * */
    public function action_index()
    {
        $action = $this->params['action'];
        $webid = Arr::get($_GET, 'webid');
        //订单模板
        $channelname = Model_Model::get_module_name($this->_typeid);

        if (empty($action))  //显示列表
        {
            $status_json_arr = array();
            foreach (Model_Member_Order::$order_status as $k => $v)
            {
                $status_json_arr[] = array('status' => $k, 'name' => $v);
            }
            $supplier_list = DB::query(Database::SELECT, "SELECT id,suppliername FROM sline_supplier WHERE find_in_set({$this->_typeid},authorization)")->execute()->as_array();

            $saleman_list  = DB::select('username')->from('admin')->execute()->as_array();
            $this->assign('supplier_list', $supplier_list);
            $this->assign('paysources', Model_Member_Order::get_pay_source());
            $this->assign('statusnames', $status_json_arr);
            $this->assign('position', $channelname . '订单');
            $this->assign('channelname', $channelname);
            $this->assign('saleman_list',$saleman_list);
            $this->display('admin/line/order/list');
        }
        else if ($action == 'read')    //读取列表
        {
            $start = Arr::get($_GET, 'start');
            $limit = Arr::get($_GET, 'limit');
            $keyword = Arr::get($_GET, 'keyword');
            $status = $_GET['status'];
            $paysource = $_GET['paysource'];
            $sort = json_decode($_GET['sort'], true);
            //$webid = $_GET['webid'];
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
            $status=DB::select()->from('line_order_status')->where('is_show','=',1)->execute()->as_array();
            foreach($result['lists'] as &$v)
            {
                foreach($status as $s)
                {

                    if($v['status']==$s['status'])
                    {
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
                if ($order['status'] < 3)
                {
                    $dingnum = intval($order['dingnum']) + intval($order['childnum']) + intval($order['oldnum']);
                    Model_Line::storage($order['suitid'], $dingnum, $order);
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
                'product_model' => 'Model_Line'
            );
            $status = Model_Member_Order::back_order_update_field($params);
            if ($status)
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
        //业务员
        $saleman  = DB::select('username')->from('admin')->execute()->as_array();

        $info = Model_Member_Order::order_info($info['ordersn']);


        //会员信息
        $member = DB::select('nickname')->from('member')->where('mid', '=', $info['memberid'])->execute()->current();
        $info['membername'] = $member['nickname'] ? $member['nickname'] : '';

        //游客信息
        $tourers = Model_Member_Order_Tourer::get_tourer_by_orderid($info['id']);

        //发票信息
        $bill = DB::select()->from('member_order_bill')->where('orderid', '=', $info['id'])->execute()->current();

        //套餐信息
        $suit = DB::select()->from('line_suit')->where('id', '=', $info['suitid'])->execute()->current();
        $fields = array('cfg_write_tourer', 'cfg_bill_open');
        $config = Model_Sysconfig::get_configs(0, $fields);
        $this->assign('config', $config);
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


        //订单的附加保险

        if (St_Functions::is_system_app_install(111))
        {
            $additional = DB::select()->from('member_order')->where('pid','=',$info['id'])->execute()->as_array();

            $this->assign('additional', $additional);

        }
        $status = DB::select()->from('line_order_status')->where('is_show', '=', 1)->execute()->as_array();
        foreach ($status as $v)
        {
            if ($v['status'] == $info['status'])
            {
                $this->assign('current_status', $v);
                break;
            }
        }
        //退款信息
        $info = Pay_Online_Refund::get_refund_info($info);
        if($info['contract_id'])
        {
            $info['contract'] = Model_Contract::get_contents($info['contract_id'],$this->_typeid);
        }
        //收益信息
        $income = Model_Member_Order_Compute::get_income_info($info['id']);

        //订单状态关系
        $relationship = array(
            '0' => array(0,1,2,3,5),
            '1' => array(1,2,3,5),
            '2' => array(2,4,5),
            '3' => array(),
            '4' => array(),
            '5' => array(),
            '6' => array(4)
        );

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

        $this->assign('member', $member);
        $this->assign('tourers', $tourers);
        $this->assign('bill', $bill);
        $this->assign('suit', $suit);
        $this->assign('info', $info);
        $this->assign('typeid', $typeid);//Model_Member_Order::$order_status
        $this->assign('orderstatus', $status);
        $this->assign('saleman',$saleman);
        $this->assign('relationship',$relationship);
        $this->display('admin/line/order/view');


    }

    /*
     * 保存
     * */
    public function action_ajax_save()
    {

        $id = Arr::get($_POST, 'id');
        //支付渠道
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
        if(!empty($payment_proof))
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
               /* //待审核,审核不通过,重置为待消费
                if($old_order_info['status'] == 6)
                {
                    Pay_Online_Refund::admin_refund_back($old_order_info['ordersn'],'Model_Line',$reject_refund_reason);
                }*/
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
                    Pay_Online_Refund::refund_start($old_order_info['ordersn'],'Model_Line',$offline,$refund_data);
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
                    Pay_Online_Refund::refund_start($old_order_info['ordersn'],'Model_Line',$offline,$refund_data);

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
                $product_model = 'Model_Line';
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
        $this->display('admin/line/order/data_view');
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
        $time_arr = St_Functions::back_get_time_range(7);
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
        $this->assign('params',$_GET);
        $this->assign('statusnames', Model_Member_Order::$order_status);
        $this->display('admin/line/order/excel');
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
        echo iconv('utf-8', 'gbk//INGNORE', $excel);
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
        $time_arr = St_Functions::back_get_time_range(2);
        $out['last'] = Model_Member_Order::back_caculate_info_by_timerange($time_arr, $typeid);

        //本周销售
        $time_arr = St_Functions::back_get_time_range(3);
        $out['thisweek'] = Model_Member_Order::back_caculate_info_by_timerange($time_arr, $typeid);

        //本月销售
        $time_arr = St_Functions::back_get_time_range(5);
        $out['thismonth'] = Model_Member_Order::back_caculate_info_by_timerange($time_arr, $typeid);

        echo json_encode($out);

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
        $fields = array('cfg_write_tourer', 'cfg_bill_open');
        $config = Model_Sysconfig::get_configs(0, $fields);
        $this->assign('config', $config);
        $this->display('admin/line/order/add');
    }

    //添加订单保存
    public function action_ajax_save_order()
    {

        //会员信息

        $memberId = $_POST['member_id'];//会员id
        $webid = 0;//网站id
        $adultNum = intval(Arr::get($_POST, 'adult_num'));//成人数量
        $childNum = intval(Arr::get($_POST, 'child_num'));//小孩数量
        $oldNum = intval(Arr::get($_POST, 'old_num'));//老人数量
        $suitId = intval(Arr::get($_POST, 'suitid'));//套餐id
        $lineId = intval(Arr::get($_POST, 'product_id'));//线路id
        $useDate = Arr::get($_POST, 'usedate');//出发日期
        $linkMan = Arr::get($_POST, 'linkman');//联系人姓名
        $linkTel = Arr::get($_POST, 'linktel');//联系人电话
        $linkEmail = Arr::get($_POST, 'linkemail');//联系人邮箱
        $remark = Arr::get($_POST, 'remark');//订单备注
        $status = Arr::get($_POST, 'status');//订单状态

        $roomBalanceNum = intval(Arr::get($_POST, 'room_balance_num'));//单房差数量
        //$roomBalance_Paytype = intval(Arr::get($_POST, 'roombalance_paytype'));//单房差支付方式.
        $roomBalance_Paytype = 0;
        //$isneedBill = intval(Arr::get($_POST, 'isneedbill'));//是否需要发票
        $billTitle = Arr::get($_POST, 'bill_title');//发票抬头
        $billReceiver = Arr::get($_POST, 'bill_receiver');//发票接收人
        $billPhone = Arr::get($_POST, 'bill_phone');//发票联系人电话
        $billProv = Arr::get($_POST, 'bill_prov');//发票联系人省份
        $billCity = Arr::get($_POST, 'bill_city');//发票联系人城市
        $billAddress = Arr::get($_POST, 'bill_address');//发票联系人地址
        $payType = Arr::get($_POST, 'paytype');//支付方式
        $useJifen = 0;
        $paysource = Arr::get($_POST, 'paysource');//支付来源

        /* //检测订单有效性
         $check_result = common::before_order_check(array('model' => 'line', 'productid' => $lineId, 'suitid' => $suitId, 'day' => strtotime($useDate)));
         if (!$check_result)
         {
             exit('订单无效');
         };*/
        //发票信息
        $billInfo = array(
            'title' => $billTitle,
            'receiver' => $billReceiver,
            'mobile' => $billPhone,
            'province' => $billProv,
            'city' => $billCity,
            'address' => $billAddress
        );

        //游客信息读取
        $t_name = Arr::get($_POST, 't_name');
        $t_cardtype = Arr::get($_POST, 't_cardtype');
        $t_cardno = Arr::get($_POST, 't_cardno');
        $t_sex = Arr::get($_POST, 't_sex');
        $t_mobile = Arr::get($_POST, 't_mobile');
        $tourer = array();
        $totalNum = $adultNum + $childNum + $oldNum;
        for ($i = 0; $i < $totalNum; $i++)
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
        $suitInfo = Model_Line_Suit::suit_info($suitId);
        //产品信息
        $info = ORM::factory('line', $lineId)->as_array();
        //套餐按出发日期价格
        $suitPrice = Model_Line_Suit::suit_price($suitId, $useDate);
        $orderSn = St_Product::get_ordersn('01');


        //判断库存
        if (!Model_Line::check_storage($lineId, $totalNum, $suitId, $useDate))
        {
            exit(json_encode(array('status' => 0, 'msg' => '库存不足')));
        }

        $arr = array(
            'ordersn' => $orderSn,
            'webid' => $webid,
            'typeid' => $this->_typeid,
            'productautoid' => $info['id'],
            'productaid' => $info['aid'],
            'productname' => $info['title'] . "({$suitInfo['suitname']})",
            'price' => $suitPrice['adultprice'],
            'childprice' => $suitPrice['childprice'],
            'oldprice' => $suitPrice['oldprice'],
            'usedate' => $useDate,
            'dingnum' => $adultNum,
            'childnum' => $childNum,
            'oldnum' => $oldNum,
            'linkman' => $linkMan,
            'linktel' => $linkTel,
            'linkemail' => $linkEmail,
            'jifentprice' => $suitInfo['jifentprice'],
            'jifenbook' => $suitInfo['jifenbook'],
            'jifencomment' => $suitInfo['jifencomment'],
            'addtime' => time(),
            'memberid' => $memberId,
            'dingjin' => $suitInfo['dingjin'],
            'paytype' => $suitInfo['paytype'],
            'suitid' => $suitId,
            'usejifen' => $useJifen,
            'needjifen' => 0,
            'roombalance' => $suitPrice['roombalance'],
            'roombalancenum' => $roomBalanceNum,
            'roombalance_paytype' => $roomBalance_Paytype,
            'status' => $status,
            'remark' => $remark,
            'isneedpiao' => 0,
            'paysource' => $paysource,
            'source' => 4

        );

        //添加订单
        $flag = 0;
        if (St_Product::add_order($arr, 'Model_Line', $arr))
        {

            $orderInfo = Model_Member_Order::get_order_by_ordersn($orderSn);
            Model_Member_Order_Tourer::add_tourer_pc($orderInfo['id'], $tourer, $memberId);
            //发票信息存储
            if ($billInfo)
            {
                Model_Member_Order_Bill::add_bill_info($orderInfo['id'], $billInfo);
            }
            $flag = 1;
            //二次确认状态,设置的支付状态切换
            if ($suitInfo['paytype'] == 3 && $status > 1)
            {
                DB::update('member_order')->set(array('status' => $status))->where('id', '=', $orderInfo['id'])->execute();
            }

            //订单状态改变短信发送
            Model_Member_Order::back_order_status_changed(0, $orderInfo, 'Model_Line');


        }
        echo json_encode(array('status' => $flag));

    }


    /**
     * @function 退款操作
     */
    public function action_ajax_refund_submit()
    {
        $model = 'Model_Line';
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

    protected function get_order_list($params)
    {
        $typeid = $params['typeid'];
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
        if (!empty($typeid) || $typeid === 0 || $typeid === '0') {
            $w .= ' and a.typeid=' . $typeid;
        }
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
        $table .= "<td>成人数量</td>";
        $table .= "<td>成人价格</td>";

        $table .= "<td>儿童数量</td>";
        $table .= "<td>儿童价格</td>";
        $table .= "<td>老人数量</td>";
        $table .= "<td>老人价格</td>";
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

            /*if ($order['typeid'] == 1)
            {
                $insInfo = ORM::factory('insurance_booking')->where("bookordersn", '=', $order['ordersn'])->find()->as_array();
                if ($insInfo['payprice'])
                {
                    $price += $insInfo['payprice'];
                    $insurancePrice = $insInfo['payprice'];
                }

            }*/

            $childOrderLabel = $row['pid'] == 0 ? '' : "[子订单]";
            $table .= "<tr>";
            $table .= "<td style='vnd.ms-excel.numberformat:@'>" . $childOrderLabel . "{$row['ordersn']}</td>";
            $table .= "<td>{$row['productname']}</td>";
            $table .= "<td>" .$row['addtime']. "</td>";
            $table .= "<td>{$row['usedate']}</td>";
            $table .= "<td>{$row['dingnum']}</td>";
            $table .= "<td>{$row['price']}</td>";


                $table .= "<td>{$row['childnum']}</td>";
                $table .= "<td>{$row['childprice']}</td>";
                $table .= "<td>{$row['oldnum']}</td>";
                $table .= "<td>{$row['oldprice']}</td>";
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
}