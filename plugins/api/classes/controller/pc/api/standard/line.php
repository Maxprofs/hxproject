<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Pc_Api_Standard_Line extends Controller_Pc_Api_Base
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
        $adname = Common::remove_xss($this->request_body->content->name);
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
        $result = Model_Api_Standard_Line::channel();
        $this->send_datagrams($this->client_info['id'], $result, $this->client_info['secret_key']);
    }

    /**
     * 获取线路列表
     */
    public function action_list()
    {
        //条数
        $pagesize = intval($this->request_body->content->pagesize);
        //页码
        $page = intval($this->request_body->content->page);
        //关键词
        $keyword = Common::remove_xss($this->request_body->content->keyword);
        $params = array(
            'page' => $page,
            'pagesize' => $pagesize,
            'keyword' => $keyword
        );
        $result = Model_Api_Standard_Line::search($params);

        $this->send_datagrams($this->client_info['id'], $result, $this->client_info['secret_key']);

    }


    //线路详情
    public function action_detail()
    {
        $id = intval($this->request_body->content->productid);
        if ($id)
        {
            $result = Model_Api_Standard_Line::detail($id);

            if (empty($result))
            {
                $this->send_datagrams($this->client_info['id'], $result, $this->client_info['secret_key'], false, '查询线路失败', '查询线路失败');
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

        $suitid = intval($this->request_body->content->suitid);
        $row = intval($this->request_body->content->row);

        $year = intval($this->request_body->content->year);
        $month = intval($this->request_body->content->month);
        if ($suitid)
        {
            $query = DB::select()->from('line_suit_price')->where('suitid', '=', $suitid);
            if (empty($year) && empty($month))
            {
                $day = strtotime(date('Y-m-d'));
                $res = $query->execute()->current();
                if ($lineid = $res['lineid'])
                {
                    if (Model_Line::is_line_before($lineid))
                    {
                        $dyaBeforeNum = DB::select('linebefore')
                                          ->from('line')
                                          ->where('id', '=', $lineid)
                                          ->execute()
                                          ->get('linebefore');
                        $dayBeforeNum = !empty($dyaBeforeNum) ? $dyaBeforeNum : 0;
                        $day += $dayBeforeNum * 86400;
                    }
                }

                $query->and_where('day', '>=', $day);
            }
            else
            {
                $need_full_days = true;
                $start = strtotime("$year-$month-1");

                $end = strtotime("$year-$month-31");
                $query->and_where('day', '>=', $start);
                $query->and_where('day', '<=', $end);
                // $days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                $days = date('t', strtotime($start));

            };
            if ($row)
            {
                $query->limit($row);
            }


            $result = $query->execute()->as_array();
            $now = strtotime(date('Y-m-d'));

            if ($lineid = $result[0]['lineid'])
            {
                if (Model_Line::is_line_before($lineid))
                {
                    $dyaBeforeNum = DB::select('linebefore')
                                      ->from('line')
                                      ->where('id', '=', $lineid)
                                      ->execute()
                                      ->get('linebefore');
                    $dayBeforeNum = !empty($dyaBeforeNum) ? $dyaBeforeNum : 0;
                    $now += $dayBeforeNum * 86400;
                }
            }

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
        if ($this->request_body->content->productautoid)
        {
            $productautoid = intval($this->request_body->content->productautoid);
            $order['productautoid'] = $productautoid;
            $order['litpic'] = DB::select('litpic')->from('line')->where('id', '=', $productautoid)->execute()->get('litpic');
        }
        //产品aid
        if ($this->request_body->content->productautoaid)
        {
            $productautoaid = intval($this->request_body->content->productautoaid);
            $order['productaid'] = $productautoaid;
        }
        //产品名称
        if ($this->request_body->content->productname)
        {
            $productname = Common::remove_xss($this->request_body->content->productname);
            $order['productname'] = $productname;
        }
        //成人价格
        if ($this->request_body->content->price)
        {
            $price = Common::remove_xss($this->request_body->content->price);
            $order['price'] = $price;
        }
        //小孩报价
        if ($this->request_body->content->childprice)
        {
            $childprice = Common::remove_xss($this->request_body->content->childprice);
            $order['childprice'] = $childprice;
        }
        //老人价格
        if ($this->request_body->content->oldprice)
        {
            $oldprice = Common::remove_xss($this->request_body->content->oldprice);
            $order['oldprice'] = $oldprice;
        }
        //联系人
        if ($this->request_body->content->linkman)
        {
            $linkman = Common::remove_xss($this->request_body->content->linkman);
            $order['linkman'] = $linkman;
        }
        //联系电话
        if ($this->request_body->content->linktel)
        {
            $linktel = Common::remove_xss($this->request_body->content->linktel);
            $order['linktel'] = $linktel;
        }
        //备注说明
        if ($this->request_body->content->remark)
        {
            $remark = Common::remove_xss($this->request_body->content->remark);
            $order['remark'] = $remark;
        }
        //会员id
        if ($this->request_body->content->memberid)
        {
            $memberid = intval($this->request_body->content->memberid);
            $order['memberid'] = $memberid;
            Common::session('member', array('mid' => $memberid));
        }
        //套餐id
        if ($this->request_body->content->suitid)
        {
            $suitid = intval($this->request_body->content->suitid);
            $order['suitid'] = $suitid;
        }
        //成人数量
        if ($this->request_body->content->dingnum)
        {
            $dingnum = intval($this->request_body->content->dingnum);
            $order['dingnum'] = $dingnum;
        }
        //小孩数量
        if ($this->request_body->content->childnum)
        {
            $childnum = intval($this->request_body->content->childnum);
            $order['childnum'] = $childnum;
        }
        //老人数量
        if ($this->request_body->content->oldnum)
        {
            $oldnum = intval($this->request_body->content->oldnum);
            $order['oldnum'] = $oldnum;
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
            $dingjin = floatval($this->request_body->content->dingjin);
            $order['dingjin'] = $dingjin;
        }
        //出发日期
        if ($this->request_body->content->usedate)
        {
            $usedate = $this->request_body->content->usedate;
            $order['usedate'] = $usedate;
        }
        //单房差
        if ($this->request_body->content->roombalance)
        {
            $roombalance = $this->request_body->content->roombalance;
            $order['roombalance'] = $roombalance;
        }
        //单房差数量
        if ($this->request_body->content->roombalancenum)
        {
            $roombalancenum = $this->request_body->content->roombalancenum;
            $order['roombalancenum'] = $roombalancenum;
        }
        //单房差支付方式
        if ($this->request_body->content->roombalance_paytype)
        {
            $roombalance_paytype = $this->request_body->content->roombalance_paytype;
            $order['roombalance_paytype'] = $roombalance_paytype;
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
                $this->send_datagrams($this->client_info['id'], array('status' => false, 'msg' => 'coupon  verification failed!', 'ext' => array($couponid, $totalprice, $order['typeid'], $order['productautoid'])), $this->client_info['secret_key']);
                exit;
            }
        }
        $pay_way = $this->request_body->content->pay_way;
        if ($pay_way)
        {
            $order['pay_way'] = $pay_way;
        }
        //判断是否需要管理员手动确认
        $query = DB::select()->from('line_suit')->where('id', '=', $suitid)->and_where('lineid','=',$productautoid)->execute()->current();
        $need_confirm = $query['need_confirm'];

        $auto_close_time = $this->request_body->content->auto_close_time;
        if ($auto_close_time)
        {
            $order['auto_close_time'] = $auto_close_time;
        }

		// 游客信息
        $tourist = $this->request_body->content->tourist;

        if ($order['memberid'])
        {
            $out = Model_Api_Standard_Order::add_order($order, 'Model_Line');
            if ($out)
            {
                $order_id = DB::select('id')->from('member_order')->where('ordersn', '=', $order['ordersn'])->execute()->get('id');
                $order_info = Model_Member_Order::order_info($order['ordersn']);
                $order_info['orderid'] = $order_id;
                $order_info['need_confirm'] = $need_confirm;

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

                $result = array(
                    'status' => true,
                    'orderinfo' => $order_info
                );
                $this->send_datagrams($this->client_info['id'],$result,$this->client_info['secret_key']);
            }
            else
            {
                $result = array(
                    'status' => false,
                    'msg' => $out['msg']
                );
                $this->send_datagrams($this->client_info['id'], $result, $this->client_info['secret_key']);

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
            'pinyin' => 'line',
            'keyword' => $keyword,
            'typeid' => 1
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
        $result = Taglib_Line::query(array('flag' => 'order', 'row' => $pagesize));
        foreach ($result as &$item)
        {
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
                array('id' => 3, 'name' => '销量最高'),
                array('id' => 4, 'name' => '产品推荐')
            ),

            'start_city' => array('name' => '出发地', 'child' => array()),
            'attribute' => array(),
            'day' => array('name' => '天数', 'child' => array()),
            'price' => array('name' => '价格', 'child' => array()),

        );
        //出发地
        $result['start_city']['child'] = DB::select('id', array('cityname', 'name'))->from('startplace')->where('isopen', '=', 1)->and_where('pid', '>', 0)->order_by('displayorder', 'asc')->execute()->as_array();
        //属性
        $result['attribute'] = DB::select('id', array('attrname', 'name'))->from('line_attr')->where('pid', '=', 0)->and_where('isopen', '=', 1)->order_by(DB::expr('ifnull(displayorder,9999)'), 'asc')->execute()->as_array();
        foreach ($result['attribute'] as &$item)
        {
            $item['child'] = DB::select('id', array('attrname', 'name'))->from('line_attr')->where('pid', '=', $item['id'])->and_where('isopen', '=', 1)->order_by(DB::expr('ifnull(displayorder,9999)'), 'asc')->execute()->as_array();

        }
        //天数
        $result['day']['child'] = DB::select()->from('line_day')->execute()->as_array();
        $autoindex = 1;
        foreach ($result['day']['child'] as &$r)
        {
            $number = substr($r['word'], 0, 2);
            $arr = array("零", "一", "二", "三", "四", "五", "六", "七", "八", "九");
            if (strlen($number) == 1)
            {
                $days = $arr[$number];
            }
            else
            {
                if ($number == 10)
                {
                    $days = "十";
                }
                else
                {
                    if ($number < 20)
                    {
                        $days = "十";
                    }
                    else
                    {
                        $days = $arr[substr($number, 0, 1)] . "十";
                    }
                    if (substr($number, 1, 1) != "0")
                    {
                        $days .= $arr[substr($number, 1, 1)];
                    }
                }
            }
            if ($autoindex == count($result['filter']['day']['child']))
            {
                $r['name'] = $days . "日游以上";
            }
            else
            {
                $r['name'] = $days . "日游";
            }

            $autoindex++;
        }
        $result['price']['child'] = DB::select()->from('line_pricelist')->where('lowerprice', '>=', 0)->order_by('lowerprice', 'asc')->execute()->as_array();

        //价格
        foreach ($result['price']['child'] as &$row)
        {
            if ($row['lowerprice'] == 0 && $row['highprice'] != 0)
            {
                $row['name'] = Currency_Tool::symbol() . $row['highprice'] . '以下';
            }
            else if ($row['highprice'] == '' || $row['highprice'] == 0)
            {
                $row['name'] = Currency_Tool::symbol() . $row['lowerprice'] . '以上';
            }
            else if ($row['lowerprice'] != '' && $row['highprice'] != '')
            {
                $row['name'] = Currency_Tool::symbol() . $row['lowerprice'] . '-' . Currency_Tool::symbol() . $row['highprice'];
            }
        }
        $this->send_datagrams($this->client_info['id'], $result, $this->client_info['secret_key']);
    }

    public function action_general_query()
    {
        $params = array(
            'pagesize' => $this->request_body->content->pagesize,
            'keyword' => $this->request_body->content->keyword,
        );
        $path = $this->request_body->content->path;
        list($params['destpy'], $params['dayid'], $params['priceid'], $params['sorttype'], , $params['startcityid'], $params['attrid'], $params['page']) = explode('-', $path);

        $result = Model_Api_Standard_Line::search($params);
        $this->send_datagrams($this->client_info['id'], $result, $this->client_info['secret_key']);
    }
	// 获取游客信息是否开启
	public function action_get_tourists()
	{
		$result = DB::select()->from('sysconfig')->where('varname', '=', 'cfg_write_tourer')->execute()->current();
		$this->send_datagrams($this->client_info['id'], $result, $this->client_info['secret_key']);
	}

}