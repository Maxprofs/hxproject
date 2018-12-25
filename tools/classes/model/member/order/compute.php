<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Member_Order_Compute{

    public static function add($ordersn)
    {


        //订单信息
        $info = Model_Member_Order::order_info($ordersn);
        //检测是否计算过订单信息.
        if(self::is_computed($info['id']))
        {
            return false;
        }

        //订单总价
        $total_price = $info['totalprice'];
        //优惠总价
        $privileg_price = $info['privileg_price'];
        //定金总价
        $num = $info['dingnum'] + $info['childnum'] + $info['oldnum'];
        $subscription_price = $info['dingjin'] ? $info['dingjin'] * $num : 0;
        if(empty($info['supplierlist']))
        {
            //平台自营，平台分佣为所有订单价
            $platform_commission = $total_price;
        }
        else
        {
            //平台佣金
            $platform_commission = self::caculate_platform_commission($info);
        }


        //平台佣金最高不能超过总价.
        if($platform_commission > $total_price)
        {
            $platform_commission = $total_price;
        }
        $data = array(
            'order_id' => $info['id'],
            'total_price' => $total_price,
            'privileg_price' => $privileg_price,
            'subscription_price' => $subscription_price,
            'additional_total_price' => 0,
            'platform_commission' => $platform_commission
        );
        DB::insert('member_order_compute',array_keys($data))->values(array_values($data))->execute();




    }

    /**
     * @function 总价,优惠价,佣金更新
     * @param $ordersn 订单号
     */
    public static function update($ordersn)
    {
        if($ordersn)
        {
            //重置计算信息
            self::reset($ordersn);
            //订单信息
            $info = Model_Member_Order::order_info($ordersn);
            if(!$info)
            {
                return;
            }
            $sub_order_info = self::get_sub_info($info['id']);

            $privileg_price = $info['privileg_price'] + $sub_order_info['total_privelege'];
            $total_price = $info['totalprice'] + $sub_order_info['total_price'];

            if(empty($info['supplierlist']))
            {
                //平台自营，平台分佣为所有订单价
                $platform_commission = $total_price;
            }
            else
            {
                //平台佣金
                $platform_commission = self::caculate_platform_commission($info);
            }


            $total_commission = $platform_commission + $sub_order_info['total_commission'];


            $data = array(
                'privileg_price' => $privileg_price,
                'total_price' => $total_price,
                'additional_total_price' => $sub_order_info['total_price'],
                'platform_commission' => $total_commission
            );
            $flag = DB::update('member_order_compute')->set($data)->where('order_id','=',$info['id'])->execute();
        }




    }

    /**
     * @function 重置计算的金额.
     * @param $ordersn
     * @return bool|object
     */
    public static function reset($ordersn)
    {
        $flag = false;
        $order_id = DB::select('id')->from('member_order')->where('ordersn','=',$ordersn)->execute()->get('id');
        if($order_id)
        {
            $data = array(
                'privileg_price' => 0,
                'total_price' => 0,
                'platform_commission' => 0
            );
            $flag =  DB::update('member_order_compute')->set($data)->where('order_id','=',$order_id)->execute();
        }
        return $flag;

    }

    /**
     * @function 计算佣金信息
     * @param $order
     * @return array|int
     */
    public static function caculate_platform_commission($order)
    {

        //检测财务是否安装.
        if(!self::is_finance_install())
        {
            return 0;
        }

        //单独产品分佣
        $r = ORM::factory('supplier_commission_product')
            ->where('typeid','=',$order['typeid'])
            ->where('productid','=',$order['productautoid'])
            ->find()
            ->as_array();
        if(is_array($r)&& (($r['commission_type']==1 && $r['commission_ratio'])||($r['commission_type']==0 && ($r['commission_cash']||$r['commission_cash_child'] ||$r['commission_cash_old']))))
        {

            $product_commission_type = $r['commission_type'];
            $product_commission_ratio = $r['commission_ratio'];
            $product_commission_cash = $r['commission_cash'];
            $product_commission_cash_child = $r['commission_cash_child'];
            $product_commission_cash_old = $r['commission_cash_old'];


        }
        //全局分佣设置
        else
        {
            $w_in = "'cfg_commission_cash_calc_type','cfg_commission_type_{$order['typeid']}','cfg_commission_ratio_{$order['typeid']}','cfg_commission_cash_{$order['typeid']}'";
            if ($order['typeid'] == 1)
            {
                $w_in .= ",'cfg_commission_cash_1_child','cfg_commission_cash_1_old'";
            }

            $sql = "SELECT * FROM sline_supplier_commission_config WHERE varname in ($w_in)";
            $config = DB::query(Database::SELECT, $sql)->execute()->as_array('varname', 'value');
            $product_commission_type = $config["cfg_commission_type_{$order['typeid']}"];
            $product_commission_ratio = $config["cfg_commission_ratio_{$order['typeid']}"];
            $product_commission_cash = $config["cfg_commission_cash_{$order['typeid']}"];
            $product_commission_cash_child    = $config["cfg_commission_cash_1_child"];
            $product_commission_cash_old      = $config["cfg_commission_cash_1_old"];

        }

        $total_price = $order['totalprice'];
        //按比例返佣
        if($product_commission_type == 1)
        {


            $product_commission_cash = round( intval($product_commission_ratio) * $total_price / 100, 2);
        }
        //按现金返佣
        elseif($product_commission_type == 0)
        {

            $product_commission_cash = $order['dingnum']*$product_commission_cash + $order['childnum']*$product_commission_cash_child + $order['oldnum']*$product_commission_cash_old;

            //防止分佣金额设置大于订单金额.
            $product_commission_cash = $product_commission_cash <= $total_price ? $product_commission_cash : $total_price;

        }

        return $product_commission_cash ? $product_commission_cash : 0;
    }

    /**
     * @function 获取附加产品总价.
     * @param $pid
     * @return int|mixed
     */
    public static function caculate_additional_price($pid)
    {
        $addtional_total_price = 0;
        $additional = DB::select()->from('member_order')->where('pid','=',$pid)->execute()->as_array();

        if($additional)
        {
            foreach($additional as &$sub)
            {

                $sub_price = Model_Member_Order::order_total_price($sub['id']);
                $addtional_total_price+= $sub_price;
            }

        }
        return $addtional_total_price;
    }

    /**
     * @function 是否计算过订单信息.
     * @param $order_id
     * @return int
     */
    public static function is_computed($order_id)
    {
        $row = DB::select('id')->from('member_order_compute')->where('order_id','=',$order_id)->execute()->as_array();
        return $row['id'] ? $row['id'] : 0;
    }

    /**
     * @function
     * @param $order_id
     * @return array 返回计算的订单佣金,收益信息.
     */
    public static function get_income_info($order_id)
    {
        $out = array();
        $info = DB::select()->from('member_order_compute')->where('order_id','=',$order_id)->execute()->current();
        if($info)
        {
            //供应商收益 = 订单总额-平台佣金-附加总额
            $out['supplier_income'] = $info['total_price'] - $info['platform_commission'] - $info['additional_total_price'];
            if($out['supplier_income']<0)
            {
                $out['supplier_income'] = 0;
            }
            //平台收益 = 平台佣金-优惠金额+附加产品金额
            $out['platform_income'] = $info['platform_commission'] - $info['privileg_price'] + $info['additional_total_price'];

            //平台佣金
            $out['platform_commission'] = $info['platform_commission'];

            //尾款 = 订单总额-定金总额
            if($info['subscription_price'])
            {
                $out['left_price'] = $info['total_price'] - $info['subscription_price'];

            }
            //分销收益
            if(St_Functions::is_normal_app_install('mobiledistribution'))
            {
                //获取当前订单分销的信息...
                $out['fenxiao'] = array();

            }

        }
        return $out;


    }

    /**
     * @function 订单计算好的结果.
     * @param $order_id
     * @return array
     */
    public static function get_order_price($order_id)
    {
        $row = DB::select()->from('member_order_compute')->where('order_id','=',$order_id)->execute()->current();
        if($row)
        {
            if($row['subscription_price'] ==0)
            {
                //支付价格 = 总价-优惠价
                $row['pay_price'] = $row['total_price'] - $row['privileg_price'];
            }
            else
            {    //支付价格 = 订金总价-优惠价
                $row['pay_price'] = $row['subscription_price'] - $row['privileg_price'];
            }
            //如果支付金额大于订单总额,则支付金额为订单总额.
            if($row['pay_price'] > $row['total_price'])
            {
                $row['pay_price'] = $row['total_price'];
            }
            //如果支付金额小于0,则置为0
            if($row['pay_price'] < 0)
            {
                $row['pay_price'] = 0;
            }

        }
        return $row ? $row : array();
    }

    /**
     * @function 获取子订单佣金信息.
     * @param $pid
     * @return array
     */
    private static function get_sub_info($pid)
    {
        //检测是否有子订单
        $sub_orders = DB::select()->from('member_order')->where('pid','=',$pid)->execute()->as_array();
        //子订单金额
        $sub_total_price = 0;
        //子订单佣金
        $sub_total_commision =  0;
        //子订单优惠
        $sub_total_privelege = 0;
        if($sub_orders)
        {
            foreach($sub_orders as $order)
            {
                $sub_total_price += Model_Member_Order::order_total_price($order['id'],$order);
                $sub_total_commision += self::caculate_platform_commission($order);
                $sub_total_privelege += $order['privileg_price'];
            }
        }
        return array(
            'total_price' => $sub_total_price,
            'total_commission' => $sub_total_commision,
            'total_privelege' => $sub_total_privelege
        );
    }

    /**
     * @function 检测财务是否安装.
     * @return bool
     */
    private static function is_finance_install()
    {
        $table_name = 'sline_supplier_commission_product';
        $result = DB::query(1,"SHOW TABLES LIKE '{$table_name}'")->execute()->as_array();
        if($result[0] && St_Functions::is_normal_app_install('system_finance'))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

}