<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Member_Order_Extend extends ORM
{
    public static $order_status=array(
        0=>'未处理',
        1=>'处理中',
        2=>'付款成功',
        3=>'订单取消',
        4=>'退款成功',
        5=>'交易完成'
    );
    //统计计算
    public static $count_fields=array(
        'ordersn' => array('title' => '订单号', 'checked' => true),
        'productname' => array('title' => '产品名称', 'checked' => true),
        'ordernum' => array('title' => '产品数量', 'checked' => true),
        'order_add_time' => array('title' => '下单时间', 'checked' => false),
        'consume_starttime' => array('title' => '消费开始时间', 'checked' => false),
        'consume_endtime' => array('title' => '消费结束时间', 'checked' => false),
        'totalprice' => array('title' => '订单总额', 'checked' => true),
        'payprice' => array('title' => '支付金额', 'checked' => true),//
        'settle_status' => array('title' => '结算状态', 'checked' => false),
        'settle_amount' => array('title' => '结算金额', 'checked' => false),
        'income' => array('title' => '订单收益', 'checked' => true),
        'product_basicprice' => array('title' => '产品成本', 'checked' => true),
        'commission' => array('title' => '平台返佣', 'checked' => false),
        'type_name' => array('title' => '产品类型', 'checked' => true),
        'status_name' => array('title' => '订单状态', 'checked' => true),
        'jifentprice' => array('title' => '积分抵现', 'checked' => true),
        'coupon' => array('title' => '优惠券', 'checked' => true),

        //----
        /*
        'jifentprice' => array('title' => '积分抵现', 'checked' => true),

        'paysource' => array('title' => '支付方式', 'checked' => false),
        'fenxiao_commission1' => array('title' => '直属上级返佣', 'checked' => false),
        'fenxiao_commission2' => array('title' => '二级上级返佣', 'checked' => false),
        'fenxiao_commission3' => array('title' => '三级上级返佣', 'checked' => false),
        'distributorname' => array('title' => '供应商名称', 'checked' => true),
        'distributormobile' => array('title' => '供应商联系方式', 'checked' => false),
        'distributortype_name' => array('title' => '供应商类型', 'checked' => true),

        //销售类型
        'fenxiao_account1' => array('title' => '直属分销商', 'checked' => false),
        'fenxiao_account2' => array('title' => '二级分销商', 'checked' => false),
        'fenxiao_account3' => array('title' => '三级分销商', 'checked' => false),

        'paytime' => array('title' => '支付时间', 'checked' => false),*/

    );
    /**
     * 判断是否购买三级分销
     * @return bool
     */
    public static function is_buy_fenxiao()
    {
        $file = BASEPATH.'/plugins/fx_phone';

        $sql = "SELECT TABLE_NAME FROM information_schema.`TABLES` WHERE TABLE_NAME='sline_fenxiao'";
        $rows = DB::query(Database::SELECT, $sql)->execute()->as_array();

        if(file_exists($file) && !empty($rows))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * @function 获取订单列表
     * @param $query_type 1:产品名称,2:供应商账号,3:分销商账号
     * @param $typeid $query_type为1时有效
     * @param null $query_id
     * @param $starttime
     * @param $endtime
     * @param $settle_status 0 未结算 1 已结算
     * @param $status
     * @param $pagesize
     * @param $pageno
     */
    public static function get_order_list($distributorid, $query_type=null, $query_id=null, $typeid=null, $starttime=null, $endtime=null, $settle_status=null, $status=null, $pagesize=999999, $pageno=1)
    {
        $sql = " SELECT * FROM sline_member_order a ";
        $where = "AND a.distributorlist ='{$distributorid}' ";
        //查询类型
        if($query_type==1)
        {
            //产品
            if($typeid>0)
            {
                $where .= "AND a.typeid='{$typeid}' ";
            }
            if($typeid>0 && $query_id>0)
            {
                $where .= "AND a.productautoid='{$query_id}'";
            }
        }
        elseif($query_type==2)
        {
            //供应商
            //$where .= "AND a.distributorlist ='{$query_id}' ";
        }
        elseif($query_type==3)
        {
            //分销商
            $where .= "AND a.memberid='{$query_id}' ";
        }
        //开始结束时间
        if(!empty($starttime))
        {
            $where .= "AND a.addtime>='{$starttime}' ";
        }
        if(!empty($endtime))
        {
            $where .= "AND a.addtime<='{$endtime}' ";
        }
        //订单状态
        if($settle_status>-1)
        {
            if ($settle_status == 1)
            {
                //已结算
                $or = "OR a.status='5' ";
            }
            else
            {
                $or = "OR (a.status>='0' AND a.status<5) ";
            }


            if($status>-1)
            {
                $where .= "AND (a.status='{$status}' {$or} ) ";
            }
            else
            {
                $where .= "AND".ltrim($or, 'OR');
            }
        }
        else
        {
            if($status>-1)
            {
                $where .= "AND (a.status='{$status}') ";
            }

        }
        //where条件处理
        if(!empty($where))
        {
            $where = " WHERE ".ltrim($where, 'AND');
        }

        $sql_total = 'SELECT COUNT(1) num '.strchr($sql.$where, 'FROM');
        $total = DB::query(Database::SELECT, $sql_total)->execute()->current();

        $pageno = intval($pageno)<=0 ? 1 : intval($pageno);
        $pagesize = empty($pagesize) ? 30 : $pagesize;
        $start = ($pageno - 1) * $pagesize ;
        $sql = $sql.$where." ORDER BY addtime DESC LIMIT {$start},{$pagesize} ";
        //echo $sql;exit;
        $list = DB::query(Database::SELECT, $sql)->execute()->as_array();
        foreach($list as &$o)
        {
            //添加扩展数据
            $order_extend = DB::select()->from('member_order_extend')->where('orderid','=',$o['id'])
                ->execute()->current();
            foreach($order_extend as $k=>$v)
            {
                $o[$k] = $v;
            }

            //格式数据
            $o['status_name'] = self::$order_status[$o['status']];//订单状态
            $o['type_name']=self::get_typename($o['typeid']); // 类型名称
            $o['ordernum'] = $o['dingnum'] + $o['childnum'] + $o['oldnum']; //购买数量
            $o['order_add_time']=date("Y-m-d H:i:s",$o['addtime']);//下单时间

            $o['consume_starttime']=$o['usedate'];
            $o['consume_endtime']=$o['departdate'];

            $distributor = DB::select("distributorname", "mobile", "telephone","distributortype")->from('distributor')->where('id','=',$o['distributorlist'])->execute()->current();
            if(!empty($distributor))
            {
                $o['distributorname']=$distributor['distributorname'];
                $o['distributormobile'] = empty($distributor['mobile']) ? $distributor['telephone'] : $distributor['mobile'];
                $o['distributortype'] = $distributor['distributortype'];
                $o['distributortype_name'] = empty($o['distributortype']) ? '--' : ($o['distributortype']==1 ? '第三方供应商' : '平台供应商');
            }
            else
            {
                $o['distributorname'] = '--';
                $o['distributormobile'] = '--';
                $o['distributortype'] = '--';
                $o['distributortype_name'] = '--';
            }

            $o['total_fee'] = self::get_order_totalfee($o);
            $o['totalprice'] = $o['total_fee'];

            $o['jifentprice'] = $o['usejifen']==1 ? floatval($o['jifentprice']) : 0;//积分抵现
            $o['coupon'] = self::get_order_coupon($o);//优惠券
            $o['payprice'] = $o['total_fee'] - $o['jifentprice'] - $o['coupon']; //支付金额


            //$o['commission']= self::get_distributor_commission($o);//平台返佣
            $o['commission'] = self::get_platform_commission($o['orderid']);//平台返佣

            $o['settle_amount'] = $o['total_fee'] - $o['commission']; //结算金额
            $o['settle_status'] = $o['status'] == 5 ? '已结算' : '未结算'; //结算状态


            $o['product_basicprice']=0;//成本
            if ($o['dingnum'] > 0)
            {
                $o['product_basicprice'] += (intval($o['basicprice'])) * $o['dingnum'];
            }
            if ($o['childnum'] > 0)
            {
                $o['product_basicprice'] += (intval($o['childbasicprice'])) * $o['childnum'];
            }
            if ($o['oldnum'] > 0)
            {
                $o['product_basicprice'] += (intval($o['oldbasicprice'])) * $o['oldnum'];
            }


            //分销
            if(St_Functions::is_normal_app_install('mobiledistribution'))
            {
                $fenxiao = DB::select('amount','fxmemberid')->from('fenxiao_record')->where('orderid','=',"{$o['id']}")
                    ->order_by('fxmembertype','asc')->execute()->as_array();
                $index = 1;
                $fenxiao_amount=0;
                foreach($fenxiao as $fx)
                {
                    $o['fenxiao_commission'+$index]=$fx['amount'];//分销金额

                    //会员信息
                    $member = DB::select('nickname','mobile')->from('member')->execute()->current();
                    $o['fenxiao_account'+$index] = !empty($member['nickname']) ? $member['nickname'] : $member['mobile'];
                    $fenxiao_amount = $fenxiao_amount + floatval($fx['amount']);

                    $index++;
                }
                $o['fenxiao_amount']=$fenxiao_amount;//分销总额
            }

            $o['income'] = self :: get_platform_income($o);//平台收益
            $o['paytime'] = empty($o['paytime']) ? '--' : date("Y-m-d H:i:s", $o['paytime']);
        }

        return array('total' => $total['num'], 'list' => $list);
    }


    /**
     * @function 获取平台分佣信息
     * @return array
     */
    public static function get_distributor_commission($order)
    {
        //第三方供应商
        if ($order['distributortype'] != 1)
            return 0;

        // 获取具体产品的分佣配置
        $model_commission_product = ORM::factory('distributor_commission_product')->where('typeid','=',$order['typeid'])
            ->where('productid','=',$order['productautoid'])->find();
        if($model_commission_product->loaded()
            && $model_commission_product->commission_ratio>0
            && $model_commission_product->commission_cash>0
            && $model_commission_product->commission_cash_child>0
            && $model_commission_product->commission_cash_old>0
        )
        {
            $is_set_product = true;
            $product_commission_type    = intval($model_commission_product->commission_type);
            $product_commission_ratio   = intval($model_commission_product->commission_ratio);
            $product_commission_cash    = intval($model_commission_product->commission_cash);
            $product_commission_cash_child    = intval($model_commission_product->commission_cash_child);
            $product_commission_cash_old      = intval($model_commission_product->commission_cash_old);
        }

        //总体配置
        $w_in = "'cfg_commission_cash_calc_type','cfg_commission_type_{$order['typeid']}','cfg_commission_ratio_{$order['typeid']}','cfg_commission_cash_{$order['typeid']}'";
        if ($order['typeid'] == 1)
        {
            $w_in .= ",'cfg_commission_cash_1_child','cfg_commission_cash_1_old'";
        }

        $sql = "SELECT * FROM sline_distributor_commission_config WHERE varname in ($w_in)";
        $config = DB::query(Database::SELECT, $sql)->execute()->as_array('varname', 'value');
        $product_commission_type    = $is_set_product ? $product_commission_type : intval($config["cfg_commission_type_{$order['typeid']}"]);
        $product_commission_ratio   = $is_set_product ? $product_commission_ratio : intval($config["cfg_commission_ratio_{$order['typeid']}"]);
        $product_commission_cash    = $is_set_product ? $product_commission_cash : intval($config["cfg_commission_cash_{$order['typeid']}"]);
        $product_commission_cash_child    = $is_set_product ? $product_commission_cash_child : intval($config["cfg_commission_cash_1_child"]);
        $product_commission_cash_old      = $is_set_product ? $product_commission_cash_old : intval($config["cfg_commission_cash_1_old"]);
        $product_commission_cash_calc_type= intval($config["cfg_commission_cash_calc_type"]);

        $rtn=0;
        if($product_commission_type == 1)
        {
            //比例
            $rtn = round( intval($product_commission_ratio) * $order['total_fee'] / 100, 2);
        }
        elseif($product_commission_type == 0)
        {
            //现金
            if($product_commission_cash_calc_type == 0)
            {
                // 订单设置佣金
                $rtn = floatval($product_commission_cash);
            }
            else
            {
                // 订单中购买人数设置佣金
                $rtn = $order['dingnum']*$product_commission_cash + $order['childnum']*$product_commission_cash_child + $order['oldnum']*$product_commission_cash_old;
            }

        }
        return $rtn;
    }

    //获取平台收益
    public static function get_platform_income($order)
    {
        $income = 0;
        if ($order['status'] == 3 || $order['status'] == 4)
            return $income;

        $income = $order['total_fee'] - $order['product_basicprice'] - $order['jifentprice'] - $order['coupon'] - floatval($order['fenxiao_amount']);
        if($order['distributortype']==1)
        {
            //第三方供应商
            $income = $income - $order['commission'];
        }

        return $income;
    }



    /**
     * @function 获取产品类型
     * @param $typeid
     */
    public static function get_typename($typeid)
    {
        $rtn='';
        $model = ORM::factory('model',$typeid);
        if($model->loaded())
            $rtn=$model->modulename;
        return $rtn;
    }

    //获取优惠卷
    public static function get_order_coupon($order)
    {
        $coupon = 0;
        $sql_check = "show tables like 'sline_member_order_coupon'";
        $tab = DB::query(Database::SELECT, $sql_check)->execute()->current();
        if($tab)
        {
            $coupon = DB::select()->from("member_order_coupon")->where('ordersn','=',$order['ordersn'])->execute()->get('cmoney',0);
        }
        return $coupon;
    }


    /**
     * 获取订单总金额
     * @param $order
     * @return int
     */
    public static function get_order_totalfee($order)
    {
        $rs = $order;
        $num = intval($rs['dingnum']) + intval($rs['childnum']) + intval($rs['oldnum']);
        if (($dingjin = $rs['dingjin']) > 0 && $rs['paytype'] == 2)
        {
            //定金支付
            $total = $dingjin * $num;
        }
        else
        {
            //全额支付
            $total = $rs['dingnum'] * $rs['price'] + $rs['childnum'] * $rs['childprice'] + $rs['oldnum'] * $rs['oldprice'];
        }
        //保险
        if ($rs['typeid'] == 1)
        {
            $sql = "select bookordersn,insurednum,payprice from sline_insurance_booking where bookordersn='{$order['ordersn']}'";
            $insurance = DB::query(Database::SELECT, $sql)->execute()->as_array();
            //叠加保险金额
            foreach ($insurance as $v)
            {
                if (!empty($v['insurednum']))
                {
                    $total += $v['payprice'];
                }
            }

            if($rs['roombalance_paytype']==1)
            {
                $balanceTotal=doubleval($rs['roombalance']*intval($rs['roombalancenum']));
                $total+=$balanceTotal;
            }

        }
        return $total;
    }


    /**
     * 通过审核状态 获取体现的金额
     */
    public static function get_withdrawed_amount($distributorid, $status)
    {
        $sql = "SELECT SUM(withdrawamount) withdrawamount FROM sline_distributor_finance_drawcash WHERE distributorid='{$distributorid}' and status='{$status}'";
        $total = DB::query(Database::SELECT, $sql)->execute()->current();
        $total = $total['withdrawamount'];
        return empty($total) ? 0 : $total;
    }

    /**
     * 获取提现列表
     */
    public static function get_withdraw_list($distributorid=null, $status=null, $starttime=null, $endtime=null, $pagesize=99999, $pageno=1)
    {
        $sql = 'SELECT * FROM sline_distributor_finance_drawcash';
        $where = '';
        if(!empty($distributorid))
        {
            $where .= "AND distributorid='{$distributorid}' ";
        }
        if($status>=0 && $status<=2)
        {
            $where .= "AND status='{$status}' ";
        }
        if(!empty($starttime))
        {
            $where .= "AND addtime>='{$starttime}' ";
        }
        if(!empty($endtime))
        {
            $where .= "AND addtime<='{$endtime}' ";
        }
        if(!empty($where))
        {
            $where = " WHERE ".substr($where, strpos($where, 'AND')+3);
        }
        $order_by = "ORDER BY addtime desc ";

        $sql_total = "select count(1) num ".strchr($sql, 'FROM').$where;
        $total = DB::query(Database::SELECT, $sql_total)->execute()->current();
        $total = $total['num'];

        $offset = ($pageno - 1) * $pagesize + 1;
        $sql = $sql.$where.$order_by." LIMIT {$offset},{$pagesize}";
        $list = DB::query(Database::SELECT, $sql)->execute()->as_array();
        foreach($list as &$l)
        {
            $distributor = DB::select()->from('distributor')->where('id','=',$l['distributorid'])->execute()->current();
            $l['distributor']=$distributor;
        }
        return array('total'=>$total, 'list'=>$list);
    }


    /**********************************************************************
     * 订单统计
     **********************************************************************/
//获取筛选列表
    public static function get_query_list($distributorid, $category, $typeid=null, $keyword=null, $pagesize=10, $pageno=1 )
    {
        $offset = ($pageno - 1) * $pagesize;
        //1:产品列表;2:供应商;3:分销商
        if($category==1)
        {
            $table = ORM::factory('model',$typeid);
            if(!$table->loaded())
            {
                return array();
            }
            $dbobj = DB::select()->from($table->maintable)->limit($pagesize)->offset($offset);
            $dbobj->where('distributorlist','=',$distributorid);
            if(!empty($keyword))
            {
                $num = intval($keyword);
                $dbobj->where('id','like',"%{$num}%")->or_where('title','like',"%{$keyword}%");
            }

            // echo (string)$dbobj;exit;

            $list=$dbobj->execute()->as_array();
            foreach($list as &$li)
            {
                $li['series']=Common::getSeries($li['id'],'');
            }

            $dbobj = DB::select(DB::expr("COUNT(1) num"))->from($table->maintable);
            $dbobj->where('distributorlist','=',$distributorid);
            if(!empty($keyword))
            {
                $dbobj->where('id','like',"%{$keyword}%")->or_where('title','like',"%{$keyword}%");
            }
            //echo (string)$dbobj;exit;

            $total=$dbobj->execute()->get('num', 0);
        }

        return array('total' => $total, 'list' => $list);
    }


    /**
     * 导出订单结算excel
     * @param $orderlist 订单列表
     * @param $fields 要导出的字段
     */
    public static function export_excel_order_count($orderlist, $fields)
    {
        include_once  BASEPATH.'/tools/lib/phpexcel/PHPExcel.php';
        $excel = new PHPExcel();

        $letter = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','Y','W','X','Y','Z');

        //头部信息
        $index=0;
        foreach(Model_Member_Order_Extend::$count_fields as $k=>$v)
        {
            if(in_array($k, $fields))
            {
                $excel->getActiveSheet()->setCellValue("$letter[$index]1","{$v['title']}");
                $index++;
            }
        }
        //数据部分
        $row_count=2;
        foreach($orderlist as $o)
        {
            $index=0;
            foreach(Model_Member_Order_Extend::$count_fields as $k=>$v)
            {
                if(in_array($k, $fields))
                {
                    $excel->getActiveSheet()->setCellValue("{$letter[$index]}{$row_count}","{$o[$k]}");
                    $index++;
                }
            }
            $row_count++;
        }

        $name = '订单查看'.date("YmdHis");
        ob_end_clean();//清除缓冲区,避免乱码
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$name.'.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
        $objWriter->save('php://output');
        exit;

        /*$write = new PHPExcel_Writer_Excel5($excel);
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
        header("Content-Type:application/force-download");
        header("Content-Type:application/vnd.ms-execl");
        header("Content-Type:application/octet-stream");
        header("Content-Type:application/download");;
        header('Content-Disposition:attachment;filename="testdata.xls"');
        header("Content-Transfer-Encoding:binary");
        $write->save('php://output');*/

    }

    /**********************************************************************
     * 交易明细
     **********************************************************************/
    public static $withdraw_status=array(
        0=>'审核中',
        1=>'审核通过',
        2=>'审核未通过',
    );

    public static $order_record_fields=array(
        'addtime'=>'创建时间',
        'productname'=>'名称',
        'type_name'=>'交易类型',
        'price'=>'金额',
        'status_name'=>'交易状态'
        //operator
    );
    /**
     * 获取财务总览信息
     */
    public static function get_overview_info($distributorid)
    {
        $list_info = Model_Member_Order_Extend::get_order_list($distributorid);
        //var_dump($list_info);exit;

        $total_amount = 0;//结算总额
        $settled_amount = 0;//已结算
        $un_settle_amount = 0;//未结算

        foreach($list_info['list'] as $o)
        {
            if($o['status']==2 || $o['status']==5)
            {
                $total_amount += $o['settle_amount'];
            }

            if($o['status']==5)
            {
                $settled_amount += $o['settle_amount'];
            }

            if($o['status']==2)
            {
                $un_settle_amount += $o['settle_amount'];
            }
        }

        $withdraw = Model_Member_Order_Extend::get_withdrawed_amount($distributorid, 1); //已提现金额
        $withdrawing = Model_Member_Order_Extend::get_withdrawed_amount($distributorid, 0);//提现中金额
        $withdraw_total = $settled_amount - $withdraw - $withdrawing;//可提现金额


        //计算
        $available_amount = $total_amount - $withdraw > 0 ? $total_amount - $withdraw : 0 ;
        $total_amount = $total_amount > 0 ? $total_amount : 0;
        $withdraw = $withdraw >0 ? $withdraw : 0;
        $withdrawing = $withdrawing ? $withdrawing : 0;
        $withdraw_total = $withdraw_total>0 ? $withdraw_total : 0;
        $account_balance = $settled_amount - $withdraw >0 ? $settled_amount - $withdraw : 0;
        $settled_amount = $settled_amount>0 ? $settled_amount : 0;
        $un_settle_amount = $un_settle_amount ? $un_settle_amount : 0;


        return array(
            'available_amount' => $available_amount,
            'total_amount' => $total_amount,
            'withdraw' => $withdraw,
            'withdrawing'=> $withdrawing,
            'withdraw_total'=>$withdraw_total,//可提现金额
            'account_balance' =>$account_balance, //账户余额

            'settled_amount'=>$settled_amount,
            'un_settle_amount'=>$un_settle_amount
        );
    }

    /**
     * @$deal_type 1 销售订单 2 提现
     * @$status 销售: 0,1,2:交易处理中;3,4:交易失败;5:交易完成,提现: 0:交易处理中;1:交易完成;2:交易失败
     * 获取预览列表
     */
    public static function get_overview_list($distributorid=null, $keywords=null, $deal_type=null, $pagesize=12, $pageno=1,$status=6)
    {
        //销售
        $order_where = "";
        $order_limit = "";

        //提现
        $wd_where = "";
        $wd_limit = "";

        //销售限制条件
        if(!empty($keywords))
        {
            $order_where .= "AND ordersn like '%{$keywords}%' OR productname like '%{$keywords}%' ";
            $wd_where .= "AND description like '%{$keywords}%' ";
        }
        if(!empty($distributorid))
        {
            $order_where .= "AND distributorlist='{$distributorid}' ";
            $wd_where .= "AND distributorid='{$distributorid}' ";
        }

        if($status>0 && $status < 4)
        {
            if($status == 1)
            {
                $order_where .= 'AND status in (0,1,2) ';
                $wd_where .= "AND status = 0 ";
            }
            elseif($status == 2)
            {
                $order_where .= 'AND status in (5) ';
                $wd_where .= "AND status = 1 ";
            }
            elseif($status == 3)
            {
                $order_where .= 'AND status in (3,4) ';
                $wd_where .= "AND status = 2 ";
            }

        }

        if(!empty($order_where))
        {
            $order_where = " WHERE ".ltrim($order_where, 'AND');
        }

        //提现限制条件
        if(!empty($wd_where))
        {
            $wd_where = " WHERE ".ltrim($wd_where, 'AND');
        }

        //偏移量
        $offset = ($pageno-1)*$pagesize;

        //var_dump($offset);

        if(empty($deal_type))
        {
            //$order_limit=$wd_limit=" LIMIT {$offset},{$pagesize} ";
        }
        else
        {
            if($deal_type==1)
            {
                //$order_limit = " LIMIT {$offset},{$pagesize} ";
                $wd_limit = " LIMIT {$offset},0 ";
            }
            elseif($deal_type==2)
            {
                $order_limit = " LIMIT {$offset},0 ";
                //$wd_limit = " LIMIT {$offset},{$pagesize} ";
            }
        }



        $sql = <<<SQL
                SELECT * FROM (
                (SELECT id, addtime, typeid, productname, status, price  FROM sline_member_order {$order_where} ORDER BY addtime DESC {$order_limit} )
                UNION
                (SELECT id, addtime, '-1', description, status, withdrawamount  FROM sline_distributor_finance_drawcash {$wd_where} ORDER BY addtime DESC {$wd_limit} )
                ) t
SQL;

        //echo $sql;exit;

        $sql_total = " SELECT count(1) num ".strchr($sql, 'FROM');
        $total = DB::query(Database::SELECT, $sql_total)->execute()->get('num',0);

        //echo $sql_total;exit;

        $sql .= " ORDER BY addtime DESC LIMIT  {$offset},{$pagesize} ";
        $list = DB::query(Database::SELECT, $sql)->execute()->as_array();
        foreach($list as &$l)
        {
            if($l['typeid']==-1)
            {
                $l['status_name']=self::$withdraw_status[$l['status']];
                $l['type_name']='提现';
                $l['operator']='-';
                $l['productname'] = date('Y-m-d', $l['addtime']). '  申请提现';
            }
            else
            {
                $l['status_name']=self::$order_status[$l['status']];
                $l['type_name']='销售';
                $l['operator']='+';

                $order = DB::select()->from('member_order')->where('id','=',$l['id'])->execute()->current();
                $l['price']=Model_Member_Order_Extend::get_order_totalfee($order);
            }
        }

        return array('list'=>$list, 'total'=>$total);
    }

    //订单记录导出Excel
    public static function export_excel_order_record($list)
    {

        include_once  BASEPATH.'/tools/lib/phpexcel/PHPExcel.php';
        $excel = new PHPExcel();

        $letter = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','Y','W','X','Y','Z');
        //var_dump($list);exit;

        //头部信息
        $index=0;
        foreach(self::$order_record_fields as $k=>$v)
        {
            $excel->getActiveSheet()->setCellValue("$letter[$index]1","{$v}");
            $index++;
        }
        //数据部分
        $row_count=2;
        foreach($list as $o)
        {
            $o['addtime'] = date("Y-m-d H:i:s", $o['addtime']);
            $index=0;
            foreach(self::$order_record_fields as $fk=>$fv)
            {
                $tmp = $fk == 'price' ? ($o['operator'] . $o[$fk]) : $o[$fk];
                $excel->getActiveSheet()->setCellValue("{$letter[$index]}{$row_count}","{$tmp}");
                $index++;
            }

            $row_count++;
        }


        $name = '交易记录'.date("YmdHis");
        ob_end_clean();//清除缓冲区,避免乱码
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$name.'.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
        $objWriter->save('php://output');
        exit;


        /*$write = new PHPExcel_Writer_Excel5($excel);
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
        header("Content-Type:application/force-download");
        header("Content-Type:application/vnd.ms-execl");
        header("Content-Type:application/octet-stream");
        header("Content-Type:application/download");;
        header('Content-Disposition:attachment;filename="testdata.xls"');
        header("Content-Transfer-Encoding:binary");
        $write->save('php://output');*/
    }


    /**********************************************************************
     * 获取订单的基础信息
     **********************************************************************/

    //1.添加订单时获取利润
    /**
     * @param $order 订单信息（需要包含orderid, suitid，typeid, usedate，departdate）
     *
     */
    public static function get_profit($order)
    {
        $typeid = $order['typeid'];
        if($typeid==1)
        {
            $rtn=self::get_profit_line($order);
        }
        elseif($typeid==2)
        {
            $rtn=self::get_profit_hotel($order);
        }
        elseif($typeid==3)
        {
            $rtn=self::get_profit_car($order);
        }
        elseif($typeid==5)
        {
            $rtn=self::get_profit_spot($order);
        }
        elseif($typeid==8)
        {
            $rtn=self::get_profit_visa($order);
        }
        elseif($typeid==13)
        {
            $rtn=self::get_profit_tuan($order);
        }
        elseif($typeid==104)
        {
            $rtn=self::get_profit_ship($order);
        }
        elseif($typeid>=201)
        {
            $rtn=self::get_profit_tongyong($order);
        }
        //var_dump($rtn);
        return $rtn;
    }

    /**
     * 获取线路的利润
     * @param $order
     */
    public static function get_profit_line($order)
    {
        $time = strtotime($order['usedate']);
        $arr = ORM::factory('line_suit_price')
            ->where("suitid={$order['suitid']} AND day={$time}")
            ->find()
            ->as_array();
        $arr['childprofit'] = Currency_Tool::price($arr['childprofit']);
        $arr['childbasicprice'] = Currency_Tool::price($arr['childbasicprice']);
        //$arr['childprice'] = Currency_Tool::price($arr['childprice']);
        $arr['oldprofit'] = Currency_Tool::price($arr['oldprofit']);
        $arr['oldbasicprice'] = Currency_Tool::price($arr['oldbasicprice']);
        //$arr['oldprice'] = Currency_Tool::price($arr['oldprice']);
        $arr['profit'] = Currency_Tool::price($arr['adultprofit']);
        $arr['basicprice'] = Currency_Tool::price($arr['adultbasicprice']);
        //$arr['adultprice'] = Currency_Tool::price($arr['adultprice']);
        $arr['roombalance'] = Currency_Tool::price($arr['roombalance']);

        return $arr;
    }

    /**
     * 获取酒店的利润
     * @param $order
     */
    public static function get_profit_hotel($order)
    {
        $sdate = strtotime($order['usedate']);
        $edate = strtotime($order['departdate']);;

        $sql = "SELECT profit,basicprice FROM`sline_hotel_room_price` ";
        $sql .= "WHERE suitid='{$order['suitid']}' AND day>=$sdate AND day<$edate";
        $ar = DB::query(1, $sql)->execute()->as_array();
        $profit = 0;
        $basicprice = 0;
        foreach ($ar as $row)
        {
            $row['profit'] = Currency_Tool::price($row['profit']);
            $profit += $row['profit'];
            $row['basicprice'] = Currency_Tool::price($row['basicprice']);
            $basicprice += $row['basicprice'];
        }

        return array(
            'profit'=>$profit,
            'childprofit'=>'',
            'oldprofit'=>'',
            'basicprice'=>$basicprice,
            'childbasicprice'=>'',
            'oldbasicprice'=>''
        );
    }

    /**
     * 获取租车的利润
     * @param $order
     */
    public static function get_profit_car($order)
    {
        $time = strtotime($order['usedate']);
        $arr = ORM::factory('car_suit_price')
            ->where("suitid='{$order['suitid']}' AND day=$time")
            ->find()
            ->as_array();

        $arr['profit']=Currency_Tool::price($arr['adultprofit']);
        $arr['childprofit']='';
        $arr['oldprofit']='';
        $arr['basicprice']=Currency_Tool::price($arr['adultbasicprice']);
        $arr['childbasicprice']='';
        $arr['oldbasicprice']='';
        //$arr['price']=Currency_Tool::price($arr['adultprice']);

        return $arr;
    }

    /**
     * 获取景点的利润
     * @param $order
     */
    public static function get_profit_spot($order)
    {
        $suit = ORM::factory('spot_ticket',$order['productautoid'])->as_array();

        //$suit['sellprice']=Currency_Tool::price($suit['sellprice']);
        $suit['ourprice']=Currency_Tool::price($suit['ourprice']);
        //$suit['dingjin'] = Currency_Tool::price($suit['dingjin']);

        $profit = 0;
        return array(
            'profit' => $profit,
            'childprofit' => '',
            'oldprofit' => '',
            'basicprice' => $suit['ourprice'],
            'childbasicprice' => '',
            'oldbasicprice'=>'',
        );

    }

    /**
     * 获取签证的利润
     * @param $order
     */
    public static function get_profit_visa($order)
    {
        $arr = DB::select()->from('visa')->where('id','=',$order['productautoid'])->execute()->current();
        $arr['price'] = Currency_Tool::price($arr['price']);
        $profit = 0;
        return array(
            'profit' => $profit,
            'childprofit' => '',
            'oldprofit' => '',
            'basicprice' => $arr['price'],
            'oldbasicprice' => '',
            'childbasicprice' => ''
        );
    }

    /**
     * 获取团购的利润
     * @param $order
     */
    public static function get_profit_tuan($order)
    {
        $arr = DB::select()->from('tuan')->where('id','=',$order['productautoid'])->execute()->current();
        $arr['price'] = Currency_Tool::price($arr['price']);
        $profit = 0;
        return array(
            'profit' => $profit,
            'childprofit' => '',
            'oldprofit' => '',
            'basicprice' => $arr['price'],
            'oldbasicprice' => '',
            'childbasicprice' => ''
        );
    }
    public static function get_profit_ship($order)
    {
        $sub_orders = DB::select()->from('member_order_child')->where('pid','=',$order['id'])->execute()->as_array();

        $price_info= array(
            'profit' => 0,
            'childprofit' => '',
            'oldprofit' => '',
            'basicprice' =>0,
            'oldbasicprice' => '',
            'childbasicprice' => ''
        );

        $starttime = strtotime($order['usedate']);
        $endtime = strtotime($order['departdate']);
        foreach($sub_orders as $row)
        {
            $suit_sql = "select a.* from sline_ship_line_suit_price a inner join sline_ship_line b on a.lineid=b.id and a.shipid=b.shipid and a.scheduleid=b.scheduleid inner join sline_ship_schedule_date c on a.dateid=c.id and a.scheduleid=c.scheduleid where a.suitid={$row['suitid']} and b.id={$order['productautoid']} and c.starttime={$starttime} and c.endtime={$endtime} ";
            $suit_info = DB::query(Database::SELECT, $suit_sql)->execute()->current();
            $price_info['profit'] += Currency_Tool::price(floatval($suit_info['profit']) * $order['dingnum']);
            $price_info['basicprice'] += Currency_Tool::price(floatval($suit_info['basicprice']) * $order['dingnum']);
        }
        return $price_info;
    }

    /**
     * 获取通用产品的利润
     * @param $order
     */
    public static function get_profit_tongyong($order)
    {
        $time = strtotime($order['usedate']);
        $arr = DB::select('profit','basicprice')->from('model_suit_price')
            ->where('suitid','=',$order['suitid'])->and_where('day','=',$time)
            ->execute()->current();

        $arr['profit'] = Currency_Tool::price($arr['profit']);
        $arr['basicprice'] = Currency_Tool::price($arr['basicprice']);

        return array(
            'profit' => $arr['profit'],
            'childprofit' => '',
            'oldprofit' => '',
            'basicprice' => $arr['basicprice'],
            'childbasicprice' => '',
            'oldbasicprice' => ''
        );
    }


    /**
     * 利润、成本存入订单扩展表
     * @function 添加订单对应的利润信息
     * @param $orderid
     * @param $profit
     * @return bool
     */
    public static function add_order_extend($order)
    {

        $extend_info = DB::select()->from('member_order_extend')->where('orderid','=',$order['id'])->execute()->current();
        if(!empty($extend_info))
        {
            $result = array(
                'status' => 0,
                'msg' => "订单已存在",
                'data' => "orderid: {$order['id']}"
            );

            return $result;

        }
        $profits = self::get_profit($order);

        $arr=array(
            'orderid'=>$order['id'],

            'profit'=>$profits['profit'],
            'oldprofit'=>$profits['oldprofit'],
            'childprofit'=>$profits['childprofit'],

            'basicprice'=>$profits['basicprice'],
            'childbasicprice'=>$profits['childbasicprice'],
            'oldbasicprice'=>$profits['oldbasicprice']
        );

        $ist_data = DB::insert('member_order_extend',array_keys($arr))->values(array_values($arr))
            ->execute();

        $status = $ist_data[1] > 0 ? 1 : 0;
        $result = array(
            'status' => $status,
            'msg' => "",
            'data' => "orderid: {$order['id']}"
        );
        return $result;
    }


    /**
     * @function 根据订单获取平台抽取的佣金
     * @param $order_id
     */
    public static function get_platform_commission($order_id)
    {
        $row = DB::select('commission_cash')
            ->from('distributor_commission_record')
            ->where('order_id','=',$order_id)
            ->execute()
            ->current();
        return intval($row['commission_cash'])>0 ? $row['commission_cash'] : 0;
    }


}