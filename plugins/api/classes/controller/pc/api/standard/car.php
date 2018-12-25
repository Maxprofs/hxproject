<?php defined('SYSPATH') or die('No direct script access.');

/**
 *User: idoiwill
 *Email: xslt@idoiwill.com
 *Blog: http://www.idoiwill.com
 *DateTime: 2017/5/17 12:16
 */
class Controller_Pc_Api_Standard_Car extends Controller_Pc_Api_Base
{
    public function before()
    {
        parent::before();
    }

    /**
     * @desc 获取轮播图
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

    /**
     * @desc 栏目信息
     */
    public function action_channel()
    {
        $result = Model_Api_Standard_Car::channel();

        $this->send_datagrams($this->client_info['id'], $result, $this->client_info['secret_key']);
    }

    /**
     * @desc 获取租车列表
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
            'page'     => $page,
            'pagesize' => $pagesize,
            'keyword'  => $keyword,
        );
        $result = Model_Api_Standard_Car::search($params);

        $this->send_datagrams($this->client_info['id'], $result, $this->client_info['secret_key']);
    }

    /**
     * @desc 租车详情
     */
    public function action_detail()
    {
        $id = intval($this->request_body->content->productid);
        if ($id)
        {
            $result = Model_Api_Standard_Car::detail($id);

            if (empty($result))
            {
                $this->send_datagrams($this->client_info['id'], $result, $this->client_info['secret_key'], false, '查询租车失败', '查询租车失败');
            } else
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

        $suitid = intval($this->request_body->content->suitid);
        $row = intval($this->request_body->content->row);

        $year = intval($this->request_body->content->year);
        $month = intval($this->request_body->content->month);
        if ($suitid)
        {
            $query = DB::select()->from('car_suit_price')->where('suitid', '=', $suitid);
            if (empty($year) && empty($month))
            {
                $day = strtotime(date('Y-m-d'));
                $query->and_where('day', '>', $day);
            } else
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
                            'oldprice'   => 0,
                        );
                        array_unshift($result, $r);
                    }
                }
            }


            if (empty($result))
            {
                $this->send_datagrams($this->client_info['id'], $result, $this->client_info['secret_key'], false, '获取最新报价失败', '获取最新报价失败');
            } else
            {

                $out = array(
                    'list' => $result,
                );
                $this->send_datagrams($this->client_info['id'], $out, $this->client_info['secret_key']);
            }

        }


    }

    /**
     * @desc 创建订单
     */
    public function action_create_order()
    {

        $order = array(
            'webid'   => 0,
            'addtime' => time(),
        );

        $type_id = $this->request_body->content->typeid;
        if ($type_id)
        {
            $typeid = intval($type_id);
            $order['typeid'] = $typeid;
            $tmp = intval($typeid) < 10 ? '0' . $typeid : $typeid;
            $ordersn = St_Product::get_ordersn($tmp);
            $order['ordersn'] = $ordersn;

        }

        //产品id
        $product_autoid = $this->request_body->content->productautoid;
        if ($product_autoid)
        {
            $productautoid = intval($product_autoid);
            $order['productautoid'] = $productautoid;
            $order['litpic'] = DB::select('litpic')->from('car')->where('id', '=', $productautoid)->execute()->get('litpic');
        }

        //产品aid
        $product_autoaid = $this->request_body->content->productautoaid;
        if ($product_autoaid)
        {
            $productautoaid = intval($product_autoaid);
            $order['productautoid'] = $productautoaid;
        }

        //产品名称
        $product_name = $this->request_body->content->productname;
        if ($product_name)
        {
            $productname = Common::remove_xss($product_name);
            $order['productname'] = $productname;
        }

        //成人价格
        $adult_price = $this->request_body->content->price;
        if ($adult_price)
        {
            $price = Common::remove_xss($adult_price);
            $order['price'] = $price;
        }

        //联系人
        $link_man = $this->request_body->content->linkman;
        if ($link_man)
        {
            $linkman = Common::remove_xss($link_man);
            $order['linkman'] = $linkman;
        }

        //联系电话
        $link_tel = $this->request_body->content->linktel;
        if ($link_tel)
        {
            $linktel = Common::remove_xss($link_tel);
            $order['linktel'] = $linktel;
        }

        //备注说明
        $re_mark = $this->request_body->content->remark;
        if ($re_mark)
        {
            $remark = Common::remove_xss($re_mark);
            $order['remark'] = $remark;
        }

        //会员id
        $member_id = $this->request_body->content->memberid;
        if ($member_id)
        {
            $memberid = intval($member_id);
            $order['memberid'] = $memberid;
        }

        //套餐id
        $suit_id = $this->request_body->content->suitid;
        if ($suit_id)
        {
            $suitid = intval($suit_id);
            $order['suitid'] = $suitid;
        }

        //成人数量
        $ding_num = $this->request_body->content->dingnum;
        if ($ding_num)
        {
            $dingnum = intval($ding_num);
            $order['dingnum'] = $dingnum;
        }

        //支付方式
        $pay_type = $this->request_body->content->paytype;
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
        $use_date = $this->request_body->content->usedate;
        if ($use_date)
        {
            $usedate = $use_date;
            $order['usedate'] = $usedate;
        }

        if ($order['memberid'])
        {
            $out = Model_Api_Standard_Order::add_order($order, 'Model_Car');
            if ($out['status'])
            {
                $order_id = DB::select('id')->from('member_order')->where('ordersn', '=', $order['ordersn'])->execute()->get('id');
                $order['orderid'] = $order_id;
                $result = array(
                    'status'    => true,
                    'orderinfo' => $order,
                );
                $this->send_datagrams($this->client_info['id'], $result, $this->client_info['secret_key']);
            } else
            {
                $result = array(
                    'status' => false,
                    'msg'    => $out['msg'],
                );
                $this->send_datagrams($this->client_info['id'], $result, $this->client_info['secret_key']);

            }
        }


    }
}