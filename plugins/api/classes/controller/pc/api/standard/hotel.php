<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Pc_Api_Standard_Hotel extends Controller_Pc_Api_Base
{

    public function before()
    {
        parent::before();
    }

    /*
     * 获取轮播图广告
     */
    public function action_get_rolling_ad()
    {
        $adname = St_Filter::remove_xss($this->request_body->content->name);
        $result = array();
        if ($adname)
        {
            $result = Model_Api_Standard_Ad::getad(array('name' => $adname));
        }
        $this->send_datagrams($this->client_info['id'], $result, $this->client_info['secret_key']);

    }

    //栏目信息
    public function action_channel()
    {
        $result = Model_Api_Standard_Hotel::channel();
        $this->send_datagrams($this->client_info['id'], $result, $this->client_info['secret_key']);
    }

    /**
     * 获取酒店列表
     */
    public function action_list()
    {
        //条数
        $page_size = intval($this->request_body->content->page_size);
        //页码
        $page = intval($this->request_body->content->page);

        //目的地拼音
        $dest_name = St_Filter::remove_xss($this->request_body->content->dest_name);
        //如果是中文
        if (preg_match('/[^a-zA-Z+]/', $dest_name))
        {
            $dest_py = Common::get_pinyin($dest_name);
        }
        else
        {
            $dest_py = $dest_name;
        }
        //价格范围
        $price_id = intval($this->request_body->content->price_id);
        //排序
        $sort_type = intval($this->request_body->content->sort_type);

        //属性
        $attr_id = $this->request_body->content->attr_id;

        //关键词
        $keyword = St_Filter::remove_xss($this->request_body->content->keyword);

        //入住时间
        $start_time = St_Filter::remove_xss($this->request_body->content->start_time);

        //离店时间
        $end_time = St_Filter::remove_xss($this->request_body->content->end_time);

        //星级
        $rank_id = intval($this->request_body->content->rank_id);

        //经度,纬度(周边酒店搜索)
        if ($this->request_body->content->geo)
        {
            $lat = floatval($this->request_body->content->geo->lat);
            $lng = floatval($this->request_body->content->geo->lng);
            if (floatval($this->request_body->content->geo->distance))
            {
                $distance = floatval($this->request_body->content->geo->distance);
            }
            else
            {
                //默认给定经纬度周边3公里酒店
                $distance = 3000;
            }

        }
        $params = array(
            'page' => $page,
            'pagesize' => $page_size,
            'keyword' => $keyword,
            'destpy' => $dest_py,
            'priceid' => $price_id,
            'sorttype' => $sort_type,
            'attrid' => $attr_id,
            'starttime' => $start_time,
            'endtime' => $end_time,
            'rankid' => $rank_id,
            'lat' => $lat,
            'lng' => $lng,
            'distance' => $distance
        );
        $out = Model_Api_Standard_Hotel::search($params);
        $result = array(
            'data' => $out['list'],
            'row_count' => $out['row_count']
        );

        $this->send_datagrams($this->client_info['id'], $result, $this->client_info['secret_key']);

    }


    /**
     * 酒店详情
     */
    public function action_detail()
    {
        $id = intval($this->request_body->content->product_id);
        if ($id)
        {
            $result = Model_Api_Standard_Hotel::detail($id);
            if (empty($result))
            {
                $this->send_datagrams($this->client_info['id'], $result, $this->client_info['secret_key'], false, '查询失败', '查询失败');
            }
            else
            {
                $this->send_datagrams($this->client_info['id'], $result, $this->client_info['secret_key']);
            }
        }
    }

    /**
     * 获取报价
     */
    public function action_price()
    {

        $suitid = intval($this->request_body->content->suit_id);
        $row = intval($this->request_body->content->row);
        $year = intval($this->request_body->content->year);
        $month = intval($this->request_body->content->month);
        if ($suitid)
        {
            $query = DB::select()->from('hotel_room_price')->where('suitid', '=', $suitid);
            if (empty($year) && empty($month))
            {
                $day = strtotime(date('Y-m-d'));
                $query->and_where('day', '>', $day);
            }
            else
            {
                $need_full_days = true;
                $start = strtotime("$year-$month-1");
                $days = date('t', $start);
                $end = strtotime("$year-$month-$days");
                $query->and_where('day', '>=', $start);
                $query->and_where('day', '<=', $end);
            };
            if ($row)
            {
                $query->limit($row);
            }
            $result = $query->execute()->as_array();
            $now = strtotime(date('Y-m-d'));
            foreach ($result as &$row)
            {
                $row['digital'] = intval(date('d', $row['day']));
                //过期数据
                if ($row['day'] < $now)
                {
                    $row['adultprice'] = 0;
                    $row['childprice'] = 0;
                    $row['oldprice'] = 0;
                }
                $row['date'] = date('m-d', $row['day']);
                $row['daynum'] = intval(date('d', $row['day']));
                $row['fulldate'] = date('Y-m-d', $row['day']);
                $row['digital'] = intval(date('d', $row['day']));
                $row['weekday'] = Model_Api_Standard_System::get_weekday($row['day']);
                $row['md_date'] = date('m月d日', $row['day']);


            }
            if ($need_full_days)
            {
                $insert_day = $days - count($result);
                if ($insert_day)
                {
                    for ($i = 0; $i < $insert_day; $i++)
                    {
                        $r = array(
                            'adultprice' => 0,
                            'childprice' => 0,
                            'oldprice' => 0
                        );
                        array_unshift($result, $r);
                    }
                }
            }

            if (empty($result))
            {
                $this->send_datagrams($this->client_info['id'], $result, $this->client_info['secret_key'], false, '获取最新报价失败', '获取最新报价失败');
            }
            else
            {

                $out = array(
                    'list' => $result
                );
                $this->send_datagrams($this->client_info['id'], $out, $this->client_info['secret_key']);
            }
        }
    }

    /*
   * 获取房型进店和离店日期价格
   * */
    public function action_range_price()
    {
        $suitid = intval($this->request_body->content->suit_id);
        $startdate = St_Filter::remove_xss($this->request_body->content->start_date);
        $enddate = St_Filter::remove_xss($this->request_body->content->end_date);

        $dingnum = intval($this->request_body->content->ding_num);
        $price = Model_Hotel::suit_range_price($suitid, $startdate, $enddate, $dingnum);
        $price = $price * $dingnum;
        $result = array(
            'price' => $price
        );
        $this->send_datagrams($this->client_info['id'], $result, $this->client_info['secret_key']);

    }

    /**
     *
     * 检测库存是否能够预订
     */
    public function action_check_storage()
    {
        $suitid = intval($this->request_body->content->suit_id);
        $startdate = St_Filter::remove_xss($this->request_body->content->start_date);
        $enddate = St_Filter::remove_xss($this->request_body->content->end_date);
        $dingnum = intval($this->request_body->content->ding_num);

        $flag = Model_Hotel::check_storage(0, $dingnum, $suitid, $startdate, $enddate);
        $result = array('status' => $flag);
        $this->send_datagrams($this->client_info['id'], $result, $this->client_info['secret_key']);
    }

    /**
     * 创建订单
     */
    public function action_create_order()
    {
        $order = array(
            'webid' => 0,
            'addtime' => time()
        );
        if ($this->request_body->content->typeid)
        {
            $typeid = intval($this->request_body->content->typeid);
            $order['typeid'] = $typeid;
            $tmp = intval($typeid) < 10 ? '0' . $typeid : $typeid;
            $ordersn = St_Product::get_ordersn($tmp);
            $order['ordersn'] = $ordersn;
        }
        //产品id
        if ($this->request_body->content->product_id)
        {
            $productautoid = intval($this->request_body->content->product_id);
            $order['productautoid'] = $productautoid;
            $order['litpic'] = DB::select('litpic')->from('hotel')->where('id', '=', $productautoid)->execute()->get('litpic');
        }
        //产品aid
        if ($this->request_body->content->product_aid)
        {
            $productautoaid = intval($this->request_body->content->product_aid);
            $order['productaid'] = $productautoaid;
        }
        //产品名称
        if ($this->request_body->content->product_name)
        {
            $productname = St_Filter::remove_xss($this->request_body->content->product_name);
            $order['productname'] = $productname;
        }
        //成人价格
        if ($this->request_body->content->price)
        {
            $price = Common::remove_xss($this->request_body->content->price);
            $order['price'] = $price;
        }

        //联系人
        if ($this->request_body->content->link_info->name)
        {
            $linkman = St_Filter::remove_xss($this->request_body->content->link_info->name);
            $order['linkman'] = $linkman;
        }
        //联系电话
        if ($this->request_body->content->link_info->phone)
        {
            $linktel = St_Filter::remove_xss($this->request_body->content->link_info->phone);
            $order['linktel'] = $linktel;
        }
        //备注说明
        if ($this->request_body->content->remark)
        {
            $remark = St_Filter::remove_xss($this->request_body->content->remark);
            $order['remark'] = $remark;
        }
        //会员id
        if ($this->request_body->content->member_id)
        {
            $memberid = intval($this->request_body->content->member_id);
            $order['memberid'] = $memberid;
            Common::session('member', array('mid' => $memberid));
        }
        //套餐id
        if ($this->request_body->content->suit_id)
        {
            $suitid = intval($this->request_body->content->suit_id);
            $order['suitid'] = $suitid;
        }
        //成人数量
        if ($this->request_body->content->ding_num)
        {
            $dingnum = intval($this->request_body->content->ding_num);
            $order['dingnum'] = $dingnum;
        }

        //支付方式
        if ($this->request_body->content->paytype)
        {
            $paytype = intval($this->request_body->content->paytype);
            $order['paytype'] = $paytype;
        }
        //订金金额
        if ($this->request_body->content->dingjin)
        {
            $dingjin = intval($this->request_body->content->dingjin);
            $order['dingjin'] = $dingjin;
        }
        //入住日期
        if ($this->request_body->content->use_date)
        {
            $usedate = $this->request_body->content->use_date;
            $order['usedate'] = $usedate;
        }
        if ($this->request_body->content->end_date)
        {
            $enddate = $this->request_body->content->end_date;
            $order['departdate'] = $enddate;
        }
        $couponid = $this->request_body->content->couponid;
        if ($couponid)
        {
            $cid = DB::select('cid')->from('member_coupon')->where("id={$couponid}")->execute()->current();
            $totalprice = Model_Coupon::get_order_totalprice($order);
            $ischeck = Model_Coupon::check_samount($couponid, $totalprice, $order['typeid'], $order['productautoid']);
            if ($ischeck['status'] == 1)
            {
                Model_Coupon::add_coupon_order($cid, $order['ordersn'], $totalprice, $ischeck, $couponid);
            }
            else
            {
                $this->send_datagrams($this->client_info['id'], array('status' => false, 'msg' => 'coupon  verification failed!','ext'=>array($couponid, $totalprice, $order['typeid'], $order['productautoid'],strtotime($order['usedate']))), $this->client_info['secret_key']);
                exit;
            }
        }
        $pay_way = $this->request_body->content->pay_way;
        if ($pay_way)
        {
            $order['pay_way'] = $pay_way;
        }
        $need_confirm = $this->request_body->content->need_confirm;
        if ($need_confirm)
        {
            $order['need_confirm'] = $need_confirm;
        }
        $auto_close_time = $this->request_body->content->auto_close_time;
        if ($auto_close_time)
        {
            $order['auto_close_time'] = $auto_close_time;
        }
		// 游客信息
        $tourist = $this->request_body->content->tourist;

        if ($order['memberid'])
        {
            $out = St_Product::add_order($order, 'Model_Hotel',$order);
            if ($out)
            {
                $order_id = DB::select('id')->from('member_order')->where('ordersn', '=', $order['ordersn'])->execute()->get('id');
                $order_info = Model_Member_Order::order_info($order['ordersn']);
                $order_info['orderid'] = $order_id;
				//游客信息保存
				$arr = array();
				foreach($tourist as $k => $v)
                {
					$arr['orderid'] = $order_id;
                    $arr['tourername'] = $v->tourername;
                    $arr['sex'] = $v->sex;
                    $arr['mobile'] = $v->mobile;
                    $arr['cardtype'] = $v->cardtype;
                    $arr['cardnumber'] = $v->cardnumber;
					$query = DB::insert('member_order_tourer', array_keys($arr))->values(array_values($arr))->execute();
				}

                $this->send_datagrams($this->client_info['id'], $order_info, $this->client_info['secret_key']);
            }
            else
            {

                $this->send_datagrams($this->client_info['id'], '', $this->client_info['secret_key'], false, '下酒店订单失败', '下酒店订单失败');

            }
        }

    }

    //关键词搜索
    public function action_query_by_keyword()
    {
        $keyword = $this->request_body->content->keyword;
        $p = intval($this->request_body->content->p) or $p = 1;
        $pagesize = intval($this->request_body->content->pagesize) or $pagesize = 10;
        $route_array = array(
            'pinyin' => 'hotel',
            'keyword' => $keyword,
            'typeid' => 2
        );
        $searchcode = St_String::split_keyword($keyword);
        $result = Model_Global_Search::search_result($route_array, $searchcode, $p, $pagesize);
        $this->send_datagrams($this->client_info['id'], $result, $this->client_info['secret_key']);
    }

    //首页推荐
    public function action_index_recommend()
    {
        $p = intval($this->request_body->content->p) or $p = 1;
        $pagesize = intval($this->request_body->content->pagesize) or $pagesize = 4;
        $result = Taglib_Hotel::query(array('flag' => 'order', 'row' => $pagesize));
        foreach($result as &$item){
            $item['litpic'] = Common::img($item['litpic']);
        }
        $this->send_datagrams($this->client_info['id'], $result, $this->client_info['secret_key']);
    }

    //查询条件
    public function action_query_condition()
    {
        $result = array(
            'sort' => array(
                array('id' => 0, 'name' => '综合排序'),
                array('id' => 1, 'name' => '价格从低到高'),
                array('id' => 2, 'name' => '价格从高到低'),
                array('id' => 3, 'name' => '销量优先'),
                array('id' => 4, 'name' => '人气推荐')
            ),
            'star' => array('name' => '星级', 'child' => array()),
            'price' => array('name' => '价格', 'child' => array()),
            'attribute' => array(),
        );
        //星级
        $result['star']['child']=DB::select()->from('hotel_rank')->where('webid','=',0)->order_by('orderid','ASC')->execute()->as_array();
        //价格
        $result['price']['child']=DB::select()->from('hotel_pricelist')->where('webid','=',0)->execute()->as_array();
        foreach ($result['price']['child'] as &$row)
        {
            if ($row['min'] != '' && $row['min']!=0 && $row['max'] != '' && $row['max']!=0)
            {
                $row['name'] = Currency_Tool::symbol() . $row['min'] . '-' .Currency_Tool::symbol() . $row['max'] ;
            }
            else if ($row['min'] == '' || $row['min']==0)
            {
                $row['name'] = Currency_Tool::symbol() . $row['max'] . '以下';
            }
            else if ($row['max'] == '' || $row['max']==0)
            {
                $row['name'] =Currency_Tool::symbol() . $row['min'] . '以上';
            }
        }
        $result['attribute'] = DB::select('id', array('attrname', 'name'))->from('hotel_attr')->where('pid', '=', 0)->and_where('isopen', '=', 1)->order_by(DB::expr('ifnull(displayorder,9999)'), 'asc')->execute()->as_array();
        foreach ($result['attribute'] as &$item)
        {
            $item['child'] = DB::select('id', array('attrname', 'name'))->from('hotel_attr')->where('pid', '=', $item['id'])->and_where('isopen', '=', 1)->order_by(DB::expr('ifnull(displayorder,9999)'), 'asc')->execute()->as_array();

        }
        $this->send_datagrams($this->client_info['id'], $result, $this->client_info['secret_key']);
    }

    public function action_general_query()
    {
        $params = array(
            'pagesize' => $this->request_body->content->pagesize,
            'keyword' => $this->request_body->content->keyword
        );
        $path = $this->request_body->content->path;
        list($params['destpy'],$params['rankid'],$params['priceid'],$params['sorttype'],,$params['attrid'],$params['page']) = explode('-', $path);

        $result = Model_Api_Standard_Hotel::search($params);
        $this->send_datagrams($this->client_info['id'], $result, $this->client_info['secret_key']);
    }
	// 获取游客信息是否开启
	public function action_get_tourists()
	{
		$result = DB::select()->from('sysconfig')->where('varname', '=', 'cfg_plugin_hotel_usetourer')->execute()->current();
		$this->send_datagrams($this->client_info['id'], $result, $this->client_info['secret_key']);
	}
    //酒店日期计算库存
    public function action_get_inventory()
    {
        $startDate = $this->request_body->content->startDate;
        $endDate = $this->request_body->content->endDate;
        $suitid = $this->request_body->content->suitid;
        $touristnum = $this->request_body->content->touristnum;
        $startDate = strtotime($startDate);
        $endDate = strtotime($endDate);
        $sql = "SELECT day,number FROM sline_hotel_room_price where day >= '{$startDate}' and day < '{$endDate}' and suitid={$suitid}";
        $result = DB::query(Database::SELECT, $sql)->execute()->as_array();

        foreach($result as $k=>$v)
        {
            if($v['number'] < $touristnum && $v['number'] !='-1')
            {
                $data ['status'] = 0 ;
                $data ['day'] = date('Y-m-d',$v['day']) ;
                break;
            }
            else
            {
                $data ['status'] = 1 ;

            }
        }
        $this->send_datagrams($this->client_info['id'], $data, $this->client_info['secret_key']);
    }

}