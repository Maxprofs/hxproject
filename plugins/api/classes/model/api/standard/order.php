<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Api_Standard_Order
{

    public static function get_status_list()
    {
        $status_list = Model_Member_Order::$statusNames;
        $result = array();
        foreach ($status_list as $status_id => $status_name)
        {
            $result[] = array('id' => $status_id, 'name' => $status_name);
        }
        return $result;

    }

    public static function get_paytype_list()
    {
        $paytype_list = Model_Member_Order::$paytype_names;
        $result = array();
        foreach ($paytype_list as $paytype_id => $paytype_name)
        {
            $result[] = array('id' => $paytype_id, 'name' => $paytype_name);
        }
        return $result;

    }

    public static function search($condition)
    {
        $result = array(
            'row_count' => 0,
            'data' => array()
        );

        $order_list = Model_Member_Order::back_order_list($condition);
        if (count($order_list['lists']) <= 0)
            return $result;

        $data = array();
        foreach ($order_list['lists'] as $order)
        {
            //$data[] = self::to_order_info($order, true);
            $temp= Model_Member_Order::order_info($order['ordersn']);
            $temp['litpic'] = Model_Api_Standard_System::reorganized_resource_url($temp['litpic']);
            $data[] =$temp;
        }

        $result['row_count'] = $order_list['total'];
        $result['data'] = $data;
        return $result;

    }

    private static function to_order_info($order_data, $is_list)
    {
        $order_info = array();
        $order_info['id'] = $order_data['id'];
        $order_info['pid'] = $order_data['pid'];
        $order_info['webid'] = $order_data['webid'];
        $order_info['ordersn'] = $order_data['ordersn'];
        $order_info['memberid'] = $order_data['memberid'];
        $order_info['supplierid'] = $order_data['supplierlist'];
        $order_info['model_type_id'] = $order_data['typeid'];
        $order_info['productname'] = $order_data['productname'];
        $order_info['productautoid'] = $order_data['productautoid'];
        $order_info['usedate'] = $order_data['usedate'];
        $order_info['suitid'] = $order_data['suitid'];
        $order_info['litpic'] = Model_Api_Standard_System::reorganized_resource_url($order_data['litpic']);

        $order_info['marketprice'] = $order_data['marketprice'];
        if ($is_list)
        {
            $order_info['addtime'] = $order_data['addtime'];
            $order_info['totalprice'] = Model_Member_Order::order_total_price($order_data['id']);
            $order_info['totalnum'] = $order_data['dingnum'];
        } else
        {
            $order_info['addtime'] = Model_Api_Standard_System::format_unixtime($order_data['addtime']);
            $order_info['adultprice'] = $order_data['price'];
            $order_info['adultnum'] = $order_data['dingnum'];
            $order_info['childprice'] = $order_data['childprice'];
            $order_info['childnum'] = $order_data['childnum'];
            $order_info['oldprice'] = $order_data['oldprice'];
            $order_info['oldnum'] = $order_data['oldnum'];
            $order_info['totalprice'] = Model_Member_Order::order_total_price($order_data['id'], $order_data);
            $order_info['totalnum'] = $order_data['dingnum'] + $order_data['childnum'] + $order_data['oldnum'];
            $order_info['privileg_price'] = Model_Member_Order::order_privileg_price($order_data['id'], $order_data);
            $order_info['actual_price'] = $order_info['totalprice'] - $order_info['privileg_price'];
            $order_info['payprice'] = Model_Member_Order::order_total_payprice($order_data['id'], $order_data);
        }


        $order_info['roombalance'] = $order_data['roombalance'];
        $order_info['roombalancenum'] = $order_data['roombalancenum'];
        $order_info['dingjin'] = $order_data['dingjin'];
        $order_info['effective_date'] = $order_data['usedate'];
        $order_info['expiration_date'] = $order_data['departdate'];
        $order_info['ispay'] = $order_data['ispay'];
        $order_info['paysource'] = $order_data['paysource'];
        $order_info['paytime'] = Model_Api_Standard_System::format_unixtime($order_data['paytime']);
        $order_info['paytype'] = $order_data['paytype'];
        $order_info['paytype_name'] = Model_Member_Order::$paytype_names[$order_data['paytype']];
        $order_info['status'] = $order_data['status'];
        $order_info['status_name'] = Model_Member_Order::$order_status[$order_data['status']];
        $order_info['linkman'] = $order_data['linkman'];
        $order_info['linktel'] = $order_data['linktel'];
        $order_info['linkemail'] = $order_data['linkemail'];
        $order_info['linkqq'] = $order_data['linkqq'];
        $order_info['finishtime'] = Model_Api_Standard_System::format_unixtime($order_data['finishtime']);
        $order_info['ispinlun'] = $order_data['ispinlun'];
        $order_info['isneedpiao'] = $order_data['isneedpiao'];
        $order_info['remark'] = $order_data['remark'];
        $order_info['viewstatus'] = $order_data['viewstatus'];
        $order_info['eticketno'] = $order_data['eticketno'];
        $order_info['isconsume'] = $order_data['isconsume'];
        $order_info['consumetime'] = Model_Api_Standard_System::format_unixtime($order_data['consumetime']);
        $order_info['consumeverifyuser'] = $order_data['consumeverifyuser'];
        $order_info['consumeverifymemo'] = $order_data['consumeverifymemo'];
        $order_info['departdate'] = $order_data['departdate'];


        return $order_info;
    }

    public static function get_detail($id)
    {
        $sql = "SELECT * FROM `sline_member_order` WHERE id={$id}";
        $info = DB::query(Database::SELECT, $sql)->execute()->current();
        if (empty($info))
        {
            return null;
        }

        $result=Model_Member_Order::order_info($info['ordersn']);
        $result['status_name'] = Model_Member_Order::$order_status[$result['status']];
        $result['litpic'] = Model_Api_Standard_System::reorganized_resource_url($result['litpic']);
        //会员信息
        $result['member_info'] = array();
        $member = DB::select('*')->from('member')->where('mid', '=', $info['memberid'])->execute()->current();
        if (!empty($member))
        {
            $result['member_info'] = array(
                'id' => $member['mid'],
                'nickname' => $member['nickname'],
                'truename' => $member['truename'],
                'email' => $member['email'],
                'mobile' => $member['mobile'],
                'litpic' => Model_Api_Standard_System::reorganized_resource_url($member['litpic'])
            );
        }

        //游客信息
        $result['tourer_list'] = array();
        $tourers = Model_Member_Order_Tourer::get_tourer_by_orderid($info['id']);
        if (count($tourers) > 0)
        {
            $result['tourer_list'] = $tourers;
        }

        //发票信息
        $result['fapiao_info'] = array();
        $bill = DB::select()->from('member_order_bill')->where('orderid', '=', $info['id'])->execute()->current();
        if (!empty($bill))
        {
            $result['fapiao_info'] = $bill;
        }
		
        $result["web_url"] =  $GLOBALS['cfg_basehost'];

        return $result;
    }
	// 取消订单
	public static function cancelOrder($ordersn)
	{
		$sql = "SELECT * FROM `sline_member_order` WHERE ordersn={$ordersn}";
        $info = DB::query(Database::SELECT, $sql)->execute()->current();
        if (empty($info))
        {
            return null;
        }
		else
		{   
			$sql = "DELETE FROM sline_member_order WHERE ordersn={$ordersn}";
			$result = DB::query(Database::DELETE, $sql)->execute();
			if($result)
			{
				$status['msg'] = 1;
			}else
			{
				$status['msg'] = 0;
			}
			
			return $status;
		}

	}
    public static function statistics_annual_report($year, $model_type_id = 0)
    {
        $current_year = date('Y');
        if ($current_year < $year)
        {
            return null;
        }

        for ($i = 1; $i <= 12; $i++)
        {
            $starttime = date('Y-m-d', mktime(0, 0, 0, $i, 1, $year)); //开始时间

            $endtime = strtotime("$starttime +1 month -1 day"); //结束时间
            $timearr = array(strtotime($starttime), $endtime);

            $out[$i] = Model_Member_Order::back_order_price_year($timearr, $model_type_id);
        }

        return $out;
    }

    public static function statistics_monthly_report($model_type_id = 0)
    {
        $out = array();

        //今日销售
        $time_arr = St_Functions::back_get_time_range(1);
        $out['today'] = Model_Member_Order::back_caculate_info_by_timerange($time_arr, $model_type_id);

        //昨日销售
        $time_arr = St_Functions::back_get_time_range(2);
        $out['yesterday'] = Model_Member_Order::back_caculate_info_by_timerange($time_arr, $model_type_id);

        //本周销售
        $time_arr = St_Functions::back_get_time_range(3);
        $out['thisweek'] = Model_Member_Order::back_caculate_info_by_timerange($time_arr, $model_type_id);

        //本月销售
        $time_arr = St_Functions::back_get_time_range(5);
        $out['thismonth'] = Model_Member_Order::back_caculate_info_by_timerange($time_arr, $model_type_id);

        return $out;
    }

    /**
     * @function 创建订单
     * @param $arr
     * @param $product_model
     * @return bool|int
     */
    //roinheart
    public static function add_order1($arr,$product_model)
    {

        $flag = 0;
        $msg = '';
        $model = ORM::factory('member_order');
        if (is_array($arr))
        {

            $db = Database::instance();
            $db->begin();
            try
            {

                //减存
                $dingnum = intval($arr['dingnum']) + intval($arr['childnum']) + intval($arr['oldnum']);
                $bool = call_user_func(array($product_model, 'storage'), $arr['suitid'], '-' . $dingnum, $arr);
                if (!$bool)
                {
                    $msg = '库存不足';
                    return array('status'=>0,'msg'=>$msg);
                }
                //添加供应商信息
                $arr['supplierlist'] = St_Product::get_product_supplier($arr['typeid'], $arr['productautoid']);
                if ($arr['paytype'] == '3')//这里补充一个当为二次确认时,修改订单为未处理状态.
                {
                    $arr['status'] = 0;
                }
                else
                {
                    $arr['status'] = 1;
                }


                foreach ($arr as $k => $v)
                {
                    $model->$k = $v;
                }
                $model->save();
                if (!$model->saved())
                {
                    //回滚库存
                    call_user_func(array($product_model, 'storage'), $arr['suitid'], $arr['dingnum'], $arr);

                    return array('status'=>0,'msg'=>'保存失败');
                }
                $db->commit();
            }
            catch (Exception $e)
            {
                $db->rollback();
                return array('status'=>0,'msg'=>'保存失败');
            }

            //预订送积分
            $model->jifenbook = St_Product::calculate_jifenbook($arr['jifenbook'], $model->typeid, $model->ordersn);
            $model->update();

            //添加日志
            Model_Member_Order_Log::add_log($model->as_array());

            //扣除积分
            if ($arr['usejifen'] && $arr['needjifen'])
            {
                Model_Member_Jifen::deduct($arr['ordersn']);
            }


            //订单监控
            $detectresult = Model_Member_Order::detect($arr['ordersn']);
            //   var_dump($detectresult);exit;
            if ($detectresult !== true)
            {
                return false;
            }


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

            //返回状态
            $flag = 1;
        }
        $out = array(
            'msg' => $msg,
            'status' => $flag
        );
        return $out;
    }


}