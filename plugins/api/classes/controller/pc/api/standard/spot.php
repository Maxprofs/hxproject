<?php defined('SYSPATH') or die('No direct script access.');

/**
 *User: idoiwill
 *Email: xslt@idoiwill.com
 *Blog: http://www.idoiwill.com
 *DateTime: 2017/5/15 15:06
 */
class Controller_Pc_Api_Standard_Spot extends Controller_Pc_Api_Base
{
    protected $_typeid = 5;

    public function before()
    {
        parent::before();
    }

    /**
     * @desc 获取轮播图
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

    /**
     * @desc 栏目信息
     */
    public function action_channel()
    {
        $result = Model_Api_Standard_Spot::channel();
        $this->send_datagrams($this->client_info['id'], $result, $this->client_info['secret_key']);

    }

    /**
     * @desc 景点列表页
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
        $params = array(
            'page' => $page,
            'pagesize' => $page_size,
            'keyword' => $keyword,
            'destpy' => $dest_py,
            'priceid' => $price_id,
            'sorttype' => $sort_type,
            'attrid' => $attr_id
        );
        $out = Model_Api_Standard_Spot::search($params);
        $result = array(
            'data' => $out['list'],
            'row_count' => $out['row_count']
        );


        $this->send_datagrams($this->client_info['id'], $result, $this->client_info['secret_key']);
    }

    /**
     * @desc 景点详情页
     */
    public function action_detail()
    {
        $id = intval($this->request_body->content->product_id);
        if ($id)
        {
            $result = Model_Api_Standard_Spot::detail($id);

            if (empty($result))
            {
                $this->send_datagrams($this->client_info['id'], $result, $this->client_info['secret_key'], false, '查询景点失败', '查询景点失败');
            }
            else
            {
                $this->send_datagrams($this->client_info['id'], $result, $this->client_info['secret_key']);
            }

        }
    }

    /**
     * @desc 获取报价
     */
    public function action_price()
    {

        $suitid = intval($this->request_body->content->suit_id);
        $suitInfo=Model_Spot_Suit::suit_info($suitid);
        $row = intval($this->request_body->content->row);

        $year = intval($this->request_body->content->year);
        $month = intval($this->request_body->content->month);
        if ($suitid)
        {
            $query = DB::select()->from('spot_ticket_price')->where('ticketid', '=', $suitid);
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
                $cur_time=time();
                if(intval($suitInfo['hour_before'])==0&&intval($suitInfo['minute_before'])==0)
                {
                    $offset=24*3600;
                }
                else
                {
                    $offset=3600*intval($suitInfo['hour_before'])+intval($suitInfo['minute_before'])*60;
                }
                $now=$cur_time+intval($suitInfo['day_before'])*24*3600-$offset;
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
                $this->send_datagrams($this->client_info['id'], $out , $this->client_info['secret_key']);
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
        $type_id = $this->_typeid;
        if ($type_id)
        {
            $typeid = intval($type_id);
            $order['typeid'] = $typeid;
            $tmp = intval($typeid) < 10 ? '0' . $typeid : $typeid;
            $ordersn = St_Product::get_ordersn($tmp);
            $order['ordersn'] = $ordersn;

        }
        //产品id
        $product_id = intval($this->request_body->content->product_id);
        if ($product_id)
        {
            $product_id = intval($product_id);
            $order['productautoid'] = $product_id;
            $order['litpic'] = DB::select('litpic')->from('spot')->where('id', '=', $product_id)->execute()->get('litpic');
        }
        //产品aid
        $aid = $this->request_body->content->product_aid;
        if ($aid)
        {
            $productautoaid = intval($aid);
            $order['productaid'] = $productautoaid;
        }
        //产品名称
        $pdt_name = $this->request_body->content->product_name;
        if ($pdt_name)
        {
            $product_name = St_Filter::remove_xss($pdt_name);
            $order['productname'] = $product_name;
        }
        //成人价格
        $adult_price = $this->request_body->content->price;
        if ($adult_price)
        {
            $price = St_Filter::remove_xss($adult_price);
            $order['price'] = $price;
        }
        //联系人信息
        $link_man = $this->request_body->content->link_info->name;
        if ($link_man)
        {
            $linkman = St_Filter::remove_xss($link_man);
            $order['linkman'] = $linkman;
        }

        //联系电话
        $link_tel = $this->request_body->content->link_info->phone;
        if ($link_tel)
        {
            $linktel = St_Filter::remove_xss($link_tel);
            $order['linktel'] = $linktel;
        }
        //email
        $email = $this->request_body->content->link_info->email;
        if ($email)
        {
            $email = St_Filter::remove_xss($email);
            $order['linkemail'] = $email;
        }

        //备注说明
        $re_mark = $this->request_body->content->remark;
        if ($re_mark)
        {
            $remark = St_Filter::remove_xss($re_mark);
            $order['remark'] = $remark;
        }

        //会员id
        $member_id = $this->request_body->content->member_id;
        if ($member_id)
        {
            $memberid = intval($member_id);
            $order['memberid'] = $memberid;
            Common::session('member', array('mid' => $memberid));
        }

        //套餐id
        $suit_id = $this->request_body->content->suit_id;
        if ($suit_id)
        {
            $suitid = intval($suit_id);
            $order['suitid'] = $suitid;
        }
        $suitInfo=Model_Spot_Suit::suit_info($suit_id);
        //成人数量
        $ding_num = $this->request_body->content->ding_num;
        if ($ding_num)
        {
            $dingnum = intval($ding_num);
            $order['dingnum'] = $dingnum;
        }

        //支付方式
        //$pay_type = $this->request_body->content->paytype;
        $pay_type = $suitInfo['paytype'];
        if ($pay_type)
        {
            $paytype = intval($pay_type);
            $order['paytype'] = $paytype;
        }
        //订金金额
        $ding_jin = $this->request_body->content->dingjin;
        if ($ding_jin)
        {
            $dingjin = intval($ding_jin);
            $order['dingjin'] = $dingjin;
        }

        //出发日期
        $use_date = $this->request_body->content->use_date;
        if ($use_date)
        {
            $usedate = $use_date;
            $order['usedate'] = $usedate;
        }
        $couponid = $this->request_body->content->couponid;
        if ($couponid)
        {
            $cid = DB::select('cid')->from('member_coupon')->where("id={$couponid}")->execute()->current();
            $totalprice = Model_Coupon::get_order_totalprice($order);
            $ischeck = Model_Coupon::check_samount($couponid, $totalprice, $order['typeid'], $order['productautoid'],strtotime( $order['usedate']));
            if ($ischeck['status'] == 1)
            {
                Model_Coupon::add_coupon_order($cid, $order['ordersn'], $totalprice, $ischeck, $couponid);
            }
            else
            {
                $this->send_datagrams($this->client_info['id'], array('status' => false, 'msg' => 'coupon  verification failed!'), $this->client_info['secret_key']);
                exit;
            }
        }
        //$pay_way = $this->request_body->content->pay_way;
        $pay_way = $suitInfo['pay_way'];
        if ($pay_way)
        {
            $order['pay_way'] = $pay_way;
        }
        //$need_confirm = $this->request_body->content->need_confirm;
        $need_confirm = $suitInfo['need_confirm']?$suitInfo['need_confirm']:0;
		$order['need_confirm']=$need_confirm;
        $order['status']=$need_confirm==1?0:1;

        $auto_close_time = $suitInfo['auto_close_time']?$suitInfo['auto_close_time']:0;
        if ($auto_close_time)
        {
            $auto_close_time = strtotime("+{$auto_close_time} hours");
            $order['auto_close_time'] = $auto_close_time;
        }

		// 游客信息
        $tourist = $this->request_body->content->tourist;

        if ($order['memberid'])
        {
            $out = St_Product::add_order($order,'Model_Spot',$order);
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
                $this->send_datagrams($this->client_info['id'], $result, $this->client_info['secret_key']);
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

    /**
     * 获取热门目的地
     */
    public function action_hot_city()
    {
        $result = Model_Api_Standard_Spot::hot_dest();
        $this->send_datagrams($this->client_info['id'], $result, $this->client_info['secret_key']);
    }

    /**
     * 按目的地关键词搜索
     */
    public function action_search_city()
    {
        $keyword = St_Filter::remove_xss($this->request_body->content->keyword);
        if (!empty($keyword))
        {
            $result = Model_Api_Standard_Spot::search_dest($keyword);

            $this->send_datagrams($this->client_info['id'], $result, $this->client_info['secret_key']);
        }


    }

    //关键词搜索
    public function action_query_by_keyword()
    {
        $keyword = $this->request_body->content->keyword;
        $p = intval($this->request_body->content->p) or $p = 1;
        $pagesize = intval($this->request_body->content->pagesize) or $pagesize = 10;
        $route_array = array(
            'pinyin' => 'spot',
            'keyword' => $keyword,
            'typeid' => 5
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
        $result = Taglib_Spot::query(array('flag' => 'order', 'row' => $pagesize));
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
                array('id' => 3, 'name' => '销量优先'),
                array('id' => 4, 'name' => '人气推荐')
            ),
            'price' => array('name' => '价格', 'child' => array()),
            'attribute' => array(),
        );
        //价格
        $result['price']['child'] = DB::select()->from('spot_pricelist')->where('webid', '=', 0)->execute()->as_array();
        foreach ($result['price']['child'] as &$row)
        {
            if ($row['min'] != '' && $row['max'] != '')
            {
                $row['name'] = Currency_Tool::symbol() . $row['min'] . '-' . Currency_Tool::symbol() . $row['max'];
            }
            else if ($row['min'] == '')
            {
                $row['name'] = Currency_Tool::symbol() . $row['max'] . '以下';
            }
            else if ($row['max'] == '')
            {
                $row['name'] = Currency_Tool::symbol() . $row['min'] . '以上';
            }
        }
        $result['attribute'] = DB::select('id', array('attrname', 'name'))->from('spot_attr')->where('pid', '=', 0)->and_where('isopen', '=', 1)->order_by(DB::expr('ifnull(displayorder,9999)'), 'asc')->execute()->as_array();
        foreach ($result['attribute'] as &$item)
        {
            $item['child'] = DB::select('id', array('attrname', 'name'))->from('spot_attr')->where('pid', '=', $item['id'])->and_where('isopen', '=', 1)->order_by(DB::expr('ifnull(displayorder,9999)'), 'asc')->execute()->as_array();

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
        list($params['destpy'], $params['priceid'], $params['sorttype'], $params['attrid'], $params['page']) = explode('-', $path);

        $result = Model_Api_Standard_Spot::search($params);
        $this->send_datagrams($this->client_info['id'], $result, $this->client_info['secret_key']);
    }
	// 获取游客信息是否开启
	public function action_get_tourists()
	{
        $suitid = $this->request_body->content->suitid;
        $suitInfo=Model_Spot_Suit::suit_info($suitid);
		//$result = DB::select()->from('sysconfig')->where('varname', '=', 'cfg_plugin_spot_usetourer')->execute()->current();
        $result['value']=$suitInfo['fill_tourer_type'];
        $this->send_datagrams($this->client_info['id'], $result, $this->client_info['secret_key']);
	}
}