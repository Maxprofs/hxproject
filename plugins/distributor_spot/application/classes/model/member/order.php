<?php
defined('SYSPATH') or die('No direct access allowed.');

class Model_Member_Order extends ORM
{

    /**
     * @var array
     * 订单状态
     */
    public  static $orderStatus = array(
        0=>'等待处理',
        1=>'等待付款',
        2=>'付款成功',
        3=>'订单取消',
        4=>'已退款',
        5=>'交易完成',
        6=>'退款确认',
    );
    /**
     * @var arraay
     * 供应商可以修改的状态
     */
    public static $changeableStatus = array(0,1,3);
    /**
     * 我的授信总额
     */
    public function get_my_order_price_total($num = 10)
    {
        $st_distributor_id = intval(Cookie::get('st_distributor_id'));
        $sql = "SELECT SUM(dingnum * price + childnum * childprice + oldnum * oldprice) AS total FROM sline_member_order WHERE status='5' AND find_in_set('{$st_distributor_id}',distributorlist)";
        $row = DB::query(1,$sql)->execute()->as_array();
        return $row[0]['total'] ;
    }
    /**
     * 我最近的授信
     */
    public function get_my_credit($num = 10)
    {
        $st_distributor_id = intval(Cookie::get('st_distributor_id'));
        $whereStr = " (status='5' OR status='2') AND find_in_set('{$st_distributor_id}',distributorlist)";

        $data = ORM::factory('member_order')
            ->where($whereStr)
            ->limit(intval($num))
            ->get_all();

        $data = $this->_get_list_data_format($data);

        return $data ;
    }

    /**
     * 验单记录 数据获取
     */
    public function get_credit_record_list()
    {
        $pagesize = 20;
        $st_distributor_id = intval(Cookie::get('st_distributor_id'));

        $p = intval($_GET['p']);
        $p = $p == 0 ? 1 : $p;

        $whereStr = " (status='5' OR status='2') AND find_in_set('{$st_distributor_id}',distributorlist) ";
        $searchKey = trim($_GET['searchKey']);
        if ($searchKey != '')
        {
            $whereStr .= " AND (ordersn='{$searchKey}' OR eticketno='{$searchKey}')" ;
        }

        //2.路由字符串
        $url_array = array(
            'controller' => 'credit',
            'action' => 'credit_record'
        );

        $return = $this->_set_pages('member_order', $pagesize, $url_array, 'consumetime', $whereStr, 'DESC','query_string');

        $return['list'] = $this->_get_list_data_format($return['list']);

        return $return ;
    }

    /**
     * 验单记录 数据获取
     * @param $num    获取条数
     * @return array
     */
    public function get_check_record($num = 10)
    {
        $st_distributor_id = intval(Cookie::get('st_distributor_id'));
        $whereStr = " (status='5' OR status='2') AND find_in_set('{$st_distributor_id}',distributorlist) AND isconsume='1'";

        $data = ORM::factory('member_order')
            ->where($whereStr)
            ->limit(intval($num))
            ->get_all();

        $data = $this->_get_list_data_format($data);

        return $data ;
    }

    /**
     * 我要验单 数据获取
     */
    public function get_my_check_list()
    {
        if(empty($_GET['searchKey']))
        {
            return NULL;
        }
        else
        {
            $orderData = array();
            $noOrderData = NULL;
            $st_distributor_id = intval(Cookie::get('st_distributor_id'));
            $sqlStr = " (status='5' OR status='2') AND find_in_set('{$st_distributor_id}',distributorlist) AND isconsume='0'";
            foreach($_GET['searchKey'] as $k=>$v)
            {
                $v = trim($v);
                if($v != '')
                {
                    $whereStr = " AND (ordersn='{$v}' OR eticketno='{$v}')" ;
                    $data = ORM::factory('member_order')
                        ->where($sqlStr.$whereStr)
                        ->get_all();

                    if(empty($data))
                    {
                        $noOrderData[] = $v;
                    }
                    else
                    {
                        $orderData = array_merge_recursive($orderData, $this->_get_list_data_format($data));
                    }
                }
                else
                {
                    unset($_GET['searchKey'][$k]);
                }
            }

        }
        return array('orderData' => $orderData, 'noOrderData' => $noOrderData);
    }

    /**
     * 验单记录 数据获取
     */
    public function get_check_record_list()
    {
        $pagesize = 20;
        $st_distributor_id = intval(Cookie::get('st_distributor_id'));

        $p = intval($_GET['p']);
        $p = $p == 0 ? 1 : $p;

        $whereStr = " (status='5' OR status='2') AND find_in_set('{$st_distributor_id}',distributorlist) AND isconsume='1'";
        $searchKey = trim($_GET['searchKey']);
        if ($searchKey != '')
        {
            $whereStr .= " AND (ordersn='{$searchKey}' OR eticketno='{$searchKey}')" ;
        }

        //2.路由字符串
        $url_array = array(
            'controller' => 'Checkorder',
            'action' => 'check_record'
        );

        $return = $this->_set_pages('member_order', $pagesize, $url_array, 'consumetime', $whereStr, 'DESC','query_string');

        $return['list'] = $this->_get_list_data_format($return['list']);

        return $return ;
    }

    /**
     * @return array
     * 我的订单列表
     */
    public function get_my_order_list($typeid,$pagesize)
    {
        $pagesize = $pagesize ? $pagesize : 30;

        $st_distributor_id = intval(Cookie::get('st_distributor_id'));
        // 供应商查询订单待确认的,已取消,已消费
        $whereStr = " FIND_IN_SET('{$st_distributor_id}',distributorlist) AND typeid=$typeid and status  in (0,5,3) ";
        $searchKey = trim($_GET['searchKey']);
        if ($searchKey != '')
        {
            $whereStr .= " AND (ordersn='{$searchKey}' OR eticketno='{$searchKey}')" ;
        }
        //查询出待消费,已完成,待确认的订单
        $whereStr .= " AND (status=3 OR status=5 OR status=0)";
        //2.路由字符串
        $url_array = array(
            'controller' => 'order',
            'action' => 'all'
        );

        $return = $this->_set_pages('member_order', $pagesize, $url_array, 'addtime', $whereStr, 'DESC','query_string');

        $return['list'] = $this->_get_list_data_format($return['list']);

        return $return ;
    }

    /**
     * 获取订单信息
     */
    public function get_order_info($id)
    {
        $st_distributor_id = intval(Cookie::get('st_distributor_id'));
        $whereStr = " find_in_set('{$st_distributor_id}',distributorlist)";
        $whereStr .= " AND id='{$id}'" ;
        $data = ORM::factory('member_order')
            ->where($whereStr)
            ->get_all();
        $data = $this->_get_data_format($data[0]);

        return $data;
    }

    /**
     * 获取订单信息
     */
    public function check_order_info($id)
    {
        $st_distributor_id = intval(Cookie::get('st_distributor_id'));
        $whereStr = " (status='5' OR status='2') AND find_in_set('{$st_distributor_id}',distributorlist)";
        $whereStr .= " AND id='{$id}'" ;
        $data = ORM::factory('member_order')
            ->where($whereStr)
            ->get_all();

        if($data[0]['isconsume'] == 0)
        {
            $updateArr = array(
                'isconsume' => 1,
                'consumetime' => time(),
                'consumeverifyuser' => $st_distributor_id,
                'consumeverifymemo' => '供应商自己验单'
            );
            $whereStr .= " AND consumetime IS NULL";
            $rtn = $this->_update_field_by_where($updateArr, $whereStr, 'member_order');
            if($rtn)
            {
                $rtnData = array('status' => 1,'msg' => '验单成功');
            }
            else
            {
                $rtnData = array('status' => 0,'msg' => '验单失败');
            }
        }
        else
        {
            $rtnData = array('status' => 0,'msg' => '该票已被使用');
        }

        return $rtnData;
    }

    /**
     * 数据修改
     * @param $update_arr
     * @param $where
     * @param $tabName
     * @return object
     */
    private function _update_field_by_where($updateArr, $where, $tabName)
    {
        return DB::update($tabName)->set($updateArr)->where($where)->execute();
    }
    /**
     * 分页
     * @param $db_name
     * @param $pagesize
     * @param array $url_array
     * @param $sort
     * @param null $where
     * @param string $orderby
     * @param string $source
     * @return array
     */
    private function _set_pages($db_name, $pagesize, array $url_array, $sort, $where = NULL, $orderby = 'DESC', $source = 'query_string')
    {

        //获取数据库对象
        if ($where) $page_object = ORM::factory($db_name)->where($where);
        else
            $page_object = ORM::factory($db_name);

        //定义每页显示的条数
        $pagesize = isset($pagesize) ? $pagesize : 20;

        $pager = Pagination::factory(array(
                'current_page' => array('source' => $source, 'key' => 'p'), //配置数据的总量
                'view'=>'pagination/distributor',
                'total_items' => $page_object->count_all(), //数据总条数
                'items_per_page' => $pagesize,   //配置每页显示的数量
                'first_page_in_url' => false,  //是否把第一页 p = 1 显示在地址栏 true为显示 false为不显示
            )
        );

        //配置访问地址 当前控制器方法
        //var_dump($url_array);exit;
        $pager->route_params($url_array);

        if ($where) $page_object = ORM::factory($db_name)->where($where);
        else
            $page_object = ORM::factory($db_name);

        //返回当前页的数据结果
        $list = $page_object->offset($pager->offset)->limit($pager->items_per_page)->order_by($sort, $orderby)->get_all();

        return array('list' => $list, 'pageinfo' => $pager);

    }

    /**
     * 数据格式化
     * @param $data
     * @return array
     */
    private function _get_list_data_format($data)
    {
        if(empty($data))
        {
            return array();
        }
        else
        {
            foreach($data AS &$v)
            {
                $v = $this->_get_data_format($v);
            }
        }
        return $data;
    }

    /**
     * 数据格式化
     * @param $data
     * @return array
     */
    private function _get_data_format($data)
    {
        if(empty($data))
        {
            return array();
        }
        else
        {
            //产品地址
            $product = $this->_get_product_url($data['productautoid'], $data['typeid']);
            $data['url'] = $product['url'];
            $data['productname'] = $product['title']?$product['title']:$data['productname'];
            //价格类型——套餐名称
            $data['pricetype'] = $this->_get_product_suit_name($data['suitid'],$data['typeid']);

            //读取产品图片
            $table = DB::select_array(array('maintable'))->from('model')->where("id='{$data['typeid']}'")->execute()->current();
            if($table['maintable'])
            {
                if(Model_Model::is_standard_product($data['typeid']))
                {
                    $product = DB::select_array(array('litpic'))->from($table['maintable'])->where("id='{$data['productautoid']}'")->execute()->current();
                    $data['litpic'] = $product['litpic'];

                }
            }
            if(empty($data['litpic']))
            {
                $data['litpic'] = $GLOBALS['cfg_cmspath'].$GLOBALS['cfg_public_url'].'images/not-img.jpg';
            }
            //短信验证码
            $data['smscode'] = $data['eticketno'];
            //数量
            $data['num'] = intval(intval($data['dingnum']) + intval($data['childnum']) + intval($data['oldnum']));
            //订单状态
            $data['order_status'] = self::$orderStatus[$data['status']];
            //价格
            $data['unitprice'] = floatval($data['price']);
            $data['unitprice'] = $data['unitprice'] ? $data['unitprice'] : floatval($data['childprice']);
            $data['unitprice'] = $data['unitprice'] ? $data['unitprice'] : floatval($data['oldprice']);
            $data['unitprice'] = sprintf("%.2f", $data['unitprice']); ;
            //总额
           // $data['total'] = sprintf("%.2f", intval($data['dingnum']) * floatval($data['price'])
           //     + intval($data['childnum']) * floatval($data['childprice'])
            //    + intval($data['oldnum']) * floatval($data['oldprice']));
            $order_info = self::order_info($data['ordersn']);
            $data['tourer'] = $order_info['tourer'];
            $data['insurance'] = $order_info['insurance'];
            $data['bill'] = $order_info['bill'];
            $data['total'] = $order_info['payprice'];

            $data['total_price'] = $order_info['total_price'];
            $data['subscription_price'] = $order_info['subscription_price'];
            $compute_info = Model_Member_Order_Compute::get_income_info($data['id']);
            $data['compute_info'] = $compute_info;

            //收货地址
            if ($data['receiver_address_id'])
            {
                $address_info = DB::select()->from('member_address')->where('id', '=', $data['receiver_address_id'])->execute()->current();
                $receiver_address = $address_info['province'] . $address_info['city'] . $address_info['address'] . ' (' . $address_info['receiver'] . ') ' . $address_info['phone'];
                $data['receiver_address'] = $receiver_address;
            }
        }
        return $data;
    }




    /**
     * 获取产品 套餐名称
     * @param $suitid
     * @param $typeid
     * @return string
     */
    private function _get_product_suit_name($suitid,$typeid)
    {
        $suit_name =  '';
        if($suitid > 0)
        {
            switch($typeid)
            {
                case 1://线路
                    $suit = $this->_get_field_by_where(array('suitname'), "id='{$suitid}'", 'line_suit');
                    $suit_name = $suit['suitname'];
                    break;
                case 2://酒店
                    $suit = $this->_get_field_by_where(array('roomname'), "id='{$suitid}'", 'hotel_room');
                    $suit_name = $suit['roomname'];
                    break;
                case 3://租车
                    $suit = $this->_get_field_by_where(array('suitname'), "id='{$suitid}'", 'car_suit');
                    $suit_name = $suit['suitname'];
                    break;
                case 5://门票
                    $suit = $this->_get_field_by_where(array('title'), "id='{$suitid}'", 'spot_ticket');
                    $suit_name = $suit['title'];
                    break;
            }
        }
        return $suit_name;
    }
    /**
     * 获取产品URL地址、产品名称
     * @param $id
     * @param $typeid
     * @param string $productname
     * @return string
     */
    private function _get_product_url($id,$typeid)
    {

        $channeltable=array(
            "1"=>"line",
            "2"=>"hotel",
            "3"=>"car",
            "4"=>"article",
            "5"=>"spot",
            "6"=>"photo",
            "7"=>"theme",
            "8"=>"visa",
            "9"=>"ticket",
            "10"=>"leave",
            "11"=>"advertise",
            "12"=>"allcomments",
            "13"=>"tuan",
        );

        $tablename = $channeltable[$typeid];

        $fields=array(
            '1'=>array('field'=>'title','link'=>'lines'),
            '2'=>array('field'=>'title','link'=>'hotels'),
            '3'=>array('field'=>'title','link'=>'cars'),
            '4'=>array('field'=>'title','link'=>'article'),
            '5'=>array('field'=>'title','link'=>'spots'),
            '8'=>array('field'=>'title','link'=>'visa'),
            '13'=>array('field'=>'title','link'=>'tuan')
        );
        $field = $fields[$typeid]['field'];
        $link = $fields[$typeid]['link'];

        //如果为空,则是通用模块
        if(empty($field))
        {
            $moduleinfo = $this->_get_field_by_where(array('*'), "id='{$typeid}'", 'model');

            $field = 'title';
            $link = $moduleinfo['pinyin'];
            $tablename = 'model_archive';
        }
        $row = DB::select_array(array('webid', 'aid',$field))->from($tablename)->where("id='{$id}'")->execute()->current();

        if(!empty($row))
        {
            $weburl = $this->_get_webURL_by_webid($row['webid']);
            $url = "{$weburl}/{$link}/show_{$row['aid']}.html";
        }
        else
        {
            $url = '#';
        }

        return array('title'=>$row['title'],'url'=>$url);
    }

    /**
     * 获取产品URL地址
     * @param $webid
     * @return string
     */
    private function _get_webURL_by_webid($webid)
    {
        $globals = $this->_get_field_by_where(array('*'), "webid='{$webid}'", 'sysconfig');
        $root='';
        $prefix = $globals['sys_webprefix'] ;
        $domain = $this->_get_base_url($globals);//顶级域名
        if($webid!=0)
        {
            $destinfo = $this->_get_field_by_where(array('*'), "id='{$webid}'", 'destinations');
            $prefix = $destinfo['webprefix'];
        }
        else
        {
            $weblist = $this->_get_field_by_where(array('webprefix'), "webid='0'", 'weblist');
            $prefix = $weblist['webprefix'] ? $weblist['webprefix'] : 'www';
        }
        $root = St_Functions::get_http_prefix().$prefix.$domain;
        return $root;
    }

    /**
     * 分析当前域名,返回主域名
     * @return string
     */
    public function _get_base_url()
    {
        $url = $GLOBALS['cfg_basehost'];

        $uarr = explode('.',$url);
        $k = 0;
        $out = '';
        foreach($uarr as $value)
        {
            $out.= $k!=0 ? $value : '';
            $out .='.';
            $k++;
        }
        $out = substr($out,0,strlen($out)-1);
        return $out;
    }

    //返回符合条件的单条数据
    public function _get_field_by_where($field, $where, $tabName=NULL)
    {
        return DB::select_array($field)->from($tabName?$tabName:$this->_table_name)->where($where)->execute()->current();
    }

    /*
     * 手机版新增功能函数
     */
    /**
     * @param $code
     * @return mixed
     */
    public function get_order_by_code($code)
    {
        $sql = "SELECT * FROM sline_member_order WHERE eticketno='$code'";

        return DB::query(1,$sql)->execute()->current();
    }

    /**
     * 获取订单信息
     */
    public function check_order_mobile_info($code)
    {
        $account_id = intval(Cookie::get('st_distributor_id'));
        $whereStr = " (status='5' OR status='2') ";

        $whereStr .= " AND eticketno='{$code}'";
        $data = ORM::factory('member_order')
            ->where($whereStr)
            ->find()
            ->as_array();
        if(!empty($data))
        {

            if ($data[0]['isconsume'] == 0)
            {
                    $updateArr = array(
                        'isconsume' => 1,
                        'consumetime' => time(),
                        'consumeverifyuser' => $account_id,
                        'consumeverifymemo' => '景区兑票'
                    );
                    $whereStr = " (status='5' OR status='2') ";
                    // $whereStr .= " AND ordersn='".$return['data']->ordersn."'" ;
                    $whereStr .= " AND isconsume='0' ";
                    $whereStr .= " AND eticketno='{$code}'";
                    $rtn = $this->_update_field_by_where($updateArr, $whereStr, 'member_order');
                    if ($rtn)
                    {
                        $rtnData = array('status' => 1, 'msg' => '验单成功');
                    }
                    else
                    {
                        $rtnData = array('status' => 0, 'msg' => '验单失败');
                    }


            }
            else
            {
                $rtnData = array('status' => 0, 'msg' => '该票已被使用');
            }
        }
        else
        {
            $rtnData = array('status' => 0, 'msg' => '验单失败');
        }

        return $rtnData;
    }


    //-----------------------------新增加函数--------------------------
    /**
     * 订单信息并计算总价
     * @param $ordersn
     * @return array
     */
    public static function order_info($ordersn)
    {

        $sql = "SELECT * FROM `sline_member_order` WHERE ordersn='{$ordersn}' ORDER BY id DESC LIMIT 1 ";
        $rs = DB::query(Database::SELECT, $sql)->execute()->current();
        $num=$rs['dingnum']+$rs['childnum']+$rs['oldnum'];
        if(intval($rs['dingjin'])>0)
        {
            //定金支付
            $total= intval($rs['dingjin'])*$num;
        }
        else if($rs['typeid']!=2)
        {
            //全额支付
            $total=$rs['dingnum']*$rs['price']+$rs['childnum']*$rs['childprice']+$rs['oldnum']*$rs['oldprice'];
        }
        else
        {
            //酒店需要重新计算金额
            $total = self::suit_range_price($rs['suitid'],$rs['usedate'],$rs['departdate'],$rs['dingnum']);
        }

        //单房差
        if($rs['roombalancenum'] && $rs['roombalance'])
        {
            $total = $total+intval($rs['roombalance']);
        }


        $rs['totalprice'] = $total;//订单金额
        //保险
        if ($rs['typeid'] == 1)
        {
            $sql ="SELECT bookordersn,insurednum,payprice FROM `sline_insurance_booking` WHERE bookordersn='{$ordersn}'";
            $insurance=DB::query(Database::SELECT, $sql)->execute()->as_array();
            //叠加保险金额

            foreach($insurance as $v)
            {
                if(!empty($v['insurednum']))
                {
                    $total+=$v['payprice'];


                }
            }
        }

        //积分抵现
        if(intval($rs['usejifen'])===1)
        {
            $total=$total-$rs['jifentprice'];
        }

        if($rs['typeid']==1)
        {
            $rs['tourer'] = self::get_tourer($rs['id']);
            $rs['insurance'] = self::get_insurance_list($rs['ordersn']);
            $rs['bill'] = self::get_bill_info($rs['id']);
        }

        $total_info = Model_Member_Order_Compute::get_order_price($rs['id']);
        if(!empty($total_info))
        {
            $rs['total_price'] = $total_info['total_price'];
            $rs['privileg_price'] = $total_info['privileg_price'];
            $rs['subscription_price'] = $total_info['subscription_price'];
            $rs['real_total_price'] = $rs['total_price']-$rs['privileg_price'];
            $rs['payprice'] = $total_info['pay_price'];
            $rs['pay_price'] = $total_info['pay_price'];
        }
        else
        {
            $rs['subscription_price'] = $rs['paytype']==2? $total:0;
        }


        //总金额写入数组
        $rs['payprice']=$total;
        return $rs;
    }

    /*
    *获取套餐日期范围内价格总和.
    * */
    public static function suit_range_price($suitid,$sdate,$edate,$dingnum)
    {
        $startdate = $sdate;
        $sdate = strtotime($sdate);
        $flag = is_null($edate);
        $edate = !$flag ? strtotime($edate) : strtotime("$startdate +1 day");;


        $sql = "SELECT price FROM`sline_hotel_room_price` ";
        $sql.= "WHERE suitid='$suitid' AND day>=$sdate AND day<$edate";
        $ar = DB::query(1,$sql)->execute()->as_array();
        $price = 0;
        foreach($ar as $row)
        {
            $price+=$row['price']*$dingnum;
        }
        return $price;
    }

    //获取游客信息
    public static function get_tourer($orderid)
    {
        $sql = "SELECT * FROM `sline_member_order_tourer` WHERE orderid='$orderid'";
        return DB::query(1,$sql)->execute()->as_array();
    }
    //获取保险信息
    public static function get_insurance_list($ordersn)
    {
        $sql = "SELECT a.*,b.productname FROM `sline_insurance_booking` a LEFT JOIN `sline_insurance` b ON(a.productcasecode=b.productcode) WHERE bookordersn='$ordersn'";
        return DB::query(1,$sql)->execute()->as_array();
    }
    //发票信息
    public static function get_bill_info($orderid)
    {
        $sql = "SELECT * FROM `sline_member_order_bill` WHERE orderid='$orderid'";
        return DB::query(1,$sql)->execute()->current();
    }

    //获取可更改状态名称
    public static function get_changeable_statusnames()
    {
        //$allowed_status=array(0,1,3);
        $new_arr=array();
        foreach(self::$orderStatus as $k=>$v)
        {
            if(in_array($k,self::$changeableStatus))
            {
                $new_arr[$k] = $v;
            }
        }
        return $new_arr;
    }

    /**
     * @function 后台订单生成Excel
     * @param $time_arr
     * @param $typeid
     * @param $status
     * @return string
     */
    public static function back_order_excel($time_arr, $typeid, $status)
    {

        $w = " and addtime>=$time_arr[0] AND addtime<=($time_arr[1]+86399)";

        $model = new Model_Member_Order();
        $arr = $model->get_my_all_order_list($typeid,$status,$w);


        $table = "<table border='1'><tr>";
        $table .= "<td>订单号</td>";
        $table .= "<td>产品名称</td>";
        $table .= "<td>预订日期</td>";
        $table .= "<td>使用日期</td>";
        $table .= "<td>成人数量</td>";
        $table .= "<td>成人价格</td>";
        if ($typeid == 1)
        {
            $table .= "<td>儿童数量</td>";
            $table .= "<td>儿童价格</td>";
            $table .= "<td>老人数量</td>";
            $table .= "<td>老人价格</td>";
            //$table .= "<td>保险</td>";
        }
        $table .= "<td>应付总额</td>";
        $table .= "<td>交易状态</td>";
        $table .= "<td>预订人</td>";
        $table .= "<td>联系电话</td>";
        $table.= "<td><table border='1'><tr><td colspan='5'>游客信息</td></tr><tr><td>姓名</td><td>性别</td><td>手机号</td><td>证件类型</td><td>证件号码</td></tr></table></td>";


        $table .= "</tr>";

        foreach ($arr as $row)
        {
            $order = $row;
            $price = 0;
            $insurancePrice = 0;

            $tourers = self::get_tourer($row['id']);
            if ($order['typeid'] != 2)
            {

                $price = intval($order['dingnum']) * $order['price'] + intval($order['childnum']) * $order['childprice'] + intval($order['oldnum']) * $order['oldprice'];
                if (!empty($order['usejifen']) && !empty($order['jifentprice']))
                {
                    $price = $price - intval($order['jifentprice']);//减去积分抵现的价格.
                }

            }

            $childOrderLabel = $row['pid'] == 0 ? '' : "[子订单]";
            $table .= "<tr>";
            $table .= "<td style='vnd.ms-excel.numberformat:@'>" . $childOrderLabel . "{$row['ordersn']}</td>";
            $table .= "<td>{$row['productname']}</td>";
            $table .= "<td>" . date('Y-m-d H:i:s', $row['addtime']) . "</td>";
            $table .= "<td>{$row['usedate']}</td>";
            $table .= "<td>{$row['dingnum']}</td>";
            $table .= "<td>{$row['price']}</td>";

            if ($typeid == 1)
            {
                $table .= "<td>{$row['childnum']}</td>";
                $table .= "<td>{$row['childprice']}</td>";
                $table .= "<td>{$row['oldnum']}</td>";
                $table .= "<td>{$row['oldprice']}</td>";
            }
            $table .= "<td>{$price}</td>";
            $table .= "<td>" . self::$orderStatus[$row['status']] . "</td>";
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

    /**
     * @return array
     * 我的订单所有列表
     */
    public function get_my_all_order_list($typeid,$status,$where=false)
    {

        $st_distributor_id = intval(Cookie::get('st_distributor_id'));
        $whereStr = " FIND_IN_SET('{$st_distributor_id}',distributorlist) AND typeid=$typeid";
        $searchKey = trim($_GET['searchKey']);
        if ($searchKey != '')
        {
            $whereStr .= " AND (ordersn='{$searchKey}' OR eticketno='{$searchKey}')" ;
        }
        if ($status !== null && $status !== '')
        {
            $whereStr .= " AND status=$status";
        }
        else
        {
            //$whereStr.= " AND (status=2 OR status=5)";
        }
        if($where){
            $whereStr.=$where;
        }

        $db_name='member_order';

        if ($whereStr) $page_object = ORM::factory($db_name)->where($whereStr);
        else
            $page_object = ORM::factory($db_name);

        //返回当前页的数据结果
        $list = $page_object->select('*')->order_by('addtime', 'ASC')->get_all();
        return $list ;
    }

    /**
     * 
     */
    public static function order_total_payprice($orderid, $orderInfo = null)
    {
        if (is_null($orderInfo)) {
            $rs = DB::select()->from('member_order')->where('id', '=', $orderid)->execute()->current();
        } else {
            $rs = $orderInfo;
        }

        $num = $rs['dingnum'] + $rs['childnum'] + $rs['oldnum'];
        if (doubleval($rs['dingjin']) > 0 && $rs['paytype'] == 2) {
            //定金支付
            $total = doubleval($rs['dingjin']) * $num;
        } else if ($rs['typeid'] != 2) {
            //全额支付
            $total = $rs['dingnum'] * $rs['price'] + $rs['childnum'] * $rs['childprice'] + $rs['oldnum'] * $rs['oldprice'];
        } else {
            $total = abs($rs['dingnum']) * $rs['price'];
        }
        //单房差
        if ($rs['roombalancenum'] && $rs['roombalance'] && $rs['roombalance_paytype'] == 1) {
            $total = $total + doubleval($rs['roombalance']) * intval($rs['roombalancenum']);
        }
        $rs['totalprice'] = $total;//订单金额
        //积分抵现
        if (intval($rs['usejifen']) === 1) {
            $total = $total - $rs['jifentprice'];
        }
        //全款支付，支付金额应该减去优惠券金额
        if ($rs['paytype'] == 1 || $rs['paytype'] == 3) {
            if (St_Functions::is_normal_app_install('coupon')) {
                $info['iscoupon'] = Model_Coupon::order_view($rs['ordersn']);
                $total -= $info['iscoupon']['cmoney'];
            }
        }
        //减去红包
        if (St_Functions::is_normal_app_install('red_envelope')) {

            $envelope_price = self::get_order_envelope_price($orderInfo['ordersn']);
            $total -= $envelope_price;
        }
        return $total;
    }

    public static function get_order_envelope_price($ordersn)
    {
        $money = DB::select('use_money')->from('envelope_member')
            ->where('ordersn', '=', $ordersn)
            ->execute()->get('use_money');
        $money ? $money = $money : $money = 0;
        return $money;
    }

    public static function cur_order_total_pay_price($ordersn)
    {
        $total = 0;
        if (!is_null($ordersn)) {
            $rs = DB::select()->from('member_order')->where('ordersn', '=', $ordersn)->execute()->current();

            $num = $rs['dingnum'] + $rs['childnum'] + $rs['oldnum'];
            if (doubleval($rs['dingjin']) > 0 && $rs['paytype'] == 2) {
                //定金支付
                $total = doubleval($rs['dingjin']) * $num;
            } else if ($rs['typeid'] != 2) {
                //全额支付
                $total = $rs['dingnum'] * doubleval($rs['price']) + $rs['childnum'] * doubleval($rs['childprice']) + $rs['oldnum'] * doubleval($rs['oldprice']);
            } else {
                $total = abs($rs['dingnum']) * doubleval($rs['price']);
            }
            //单房差
            if ($rs['roombalancenum'] && $rs['roombalance'] && $rs['roombalance_paytype'] == 1) {
                $total = $total + doubleval($rs['roombalance']) * intval($rs['roombalancenum']);
            }
            $rs['totalprice'] = $total;//订单金额
            //积分抵现
            if (intval($rs['usejifen']) === 1) {
                $total = $total - doubleval($rs['jifentprice']);
            }
            //全款支付，支付金额应该减去优惠券金额
            if ($rs['paytype'] == 1 || $rs['paytype'] == 3) {
                if (St_Functions::is_normal_app_install('coupon')) {
                    $info['iscoupon'] = Model_Coupon::order_view($rs['ordersn']);
                    $total -= doubleval($info['iscoupon']['cmoney']);
                }
            }
            //减去红包
            if (St_Functions::is_normal_app_install('red_envelope')) {

                $envelope_price = self::get_order_envelope_price($ordersn);
                $total -= doubleval($envelope_price);
            }
            //减去平台优惠金额
            if (doubleval($rs['platform_discount']) > 0) {
                $total -= doubleval($rs['platform_discount']);
            }
        }
        return $total;
    }

}
