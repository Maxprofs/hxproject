<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/23 0023
 * Time: 11:42
 */
class Controller_Pc_Api_Standard_Campaign extends Controller_Pc_Api_Base implements Interface_Product
{
    protected $_typeid = 105;
    //栏目信息
    public function action_channel()
    {
        $result = Model_Api_Standard_Campaign::channel();
        $this->send_datagrams($this->client_info['id'], $result, $this->client_info['secret_key']);
    }

    //获取广告信息
    public function action_get_rolling_ad()
    {
        $adname = St_Filter::remove_xss($this->request_body->content->name);
        $result = array();
        if($adname)
        {
            $result = Model_Api_Standard_Ad::getad(array('name'=>$adname));
        }
        $this->send_datagrams($this->client_info['id'], $result, $this->client_info['secret_key']);
    }

    /**
     * 获取列表
     */
    public function action_list()
    {
        //参数值获取
        $dest_py =$this->request_body->content->dest_py;
        $sign = $this->request_body->content->sign;
        $day_id = $this->request_body->content->day_id;
        $price_id = $this->request_body->content->price_id;
        $sort_type = $this->request_body->content->sort_type;
        $startcity_id = $this->request_body->content->startcity_id;
        $group_id = $this->request_body->content->group_id;
        $book_status = $this->request_body->content->book_status;
        $attr_id = $this->request_body->content->attr_id;
        $p = intval($this->request_body->content->page);
        $attr_id = !empty($attr_id) ? $attr_id : 0;
        $dest_py = $dest_py ? $dest_py : 'all';
        $keyword = $this->request_body->content->keyword;
        $keyword = strip_tags($keyword);
        $keyword = St_String::filter_mark($keyword);
        $page_size = intval($this->request_body->content->page_size);


        $params = array(
            'destpy' => $dest_py,
            'dayid' => $day_id,
            'priceid' => $price_id,
            'sorttype' => $sort_type,
            'startcityid' => $startcity_id,
            'attrid' => $attr_id,
            'groupid'=> $group_id,
            'bookstatus'=>$book_status,
            'p' => $p,
            'keyword' => $keyword
        );
        $out = Model_Api_Standard_Campaign::search_result($params, $keyword, $p, $page_size);

        foreach($out['list'] as &$row)
        {
            $date = $this->format_date($row['starttime']);
            $row['starttime_desc'] = $date.'出发，'.$row['lineday'].'天';
        }

        $result = array(
            'data'=>$out['list'],
            'row_count'=>$out['total']
        );
        $this->send_datagrams($this->client_info['id'], $result, $this->client_info['secret_key']);



    }
    //详情
    public function action_detail()
    {
        $id = intval($this->request_body->content->product_id);
        if($id)
        {
            $result = Model_Api_Standard_Campaign::detail($id);

            if (empty($result))
            {
                $this->send_datagrams($this->client_info['id'], $result, $this->client_info['secret_key'], false,'查询活动失败','查询活动失败');
            } else
            {
                $this->send_datagrams($this->client_info['id'], $result, $this->client_info['secret_key']);
            }
        }
    }
    /*
      * 获取报价,暂无此功能
      */
    public function action_price()
    {

    }
    /**
     * 创建订单
     */
    public function action_create_order()
    {




        $ding_num = intval($this->request_body->content->ding_num);//数量
        $suit_id = intval($this->request_body->content->suit_id);//套餐id
        //$product_id= intval($this->request_body->content->product_id);//产品id



        $tourer_list = self::struct_to_array($this->request_body->content->tourer_list);
        $member_id = $this->request_body->content->member_id;
        $link_info = self::struct_to_array($this->request_body->content->link_info);

        $bill_info = self::struct_to_array($this->request_body->content->bill_info);
        $privilege_info =  self::struct_to_array($this->request_body->content->privilege_info);
        $remark = $this->request_body->content->remark;
        $is_need_bill = $this->request_body->content->is_need_bill;






        //套餐信息
        $suit_info = Model_Campaign_Suit::suit_info($suit_id);

        $product_id = $suit_info['campaignid'];

        //产品信息
        $info = ORM::factory('campaign', $product_id)->as_array();
        $info['title']=$info['title'] . "({$suit_info['suitname']})";

        //会员信息
        $member_info = Model_Member::get_member_byid($member_id);

        if(empty($member_info['mid']) || empty($info['id']) || empty($suit_info['id']))
        {
            $this->send_datagrams($this->client_info['id'], false, $this->client_info['secret_key'], false,'下单失败，请确定会员或产品是否存在','下单失败，请确定会员或产品是否存在');
            return;
        }


        $link_info = empty($link_info)?array():$link_info;
        $link_info['name'] = empty($link_info['name'])?$member_info['truename']:$link_info['name'];
        $link_info['phone'] = empty($link_info['phone'])?$member_info['mobile']:$link_info['phone'];
        $link_info['email'] = empty($link_info['email'])?$member_info['email']:$link_info['email'];


        $is_use_jifen = 0;
        $jifen_to_price = 0;
        if ($privilege_info['price_jifen'])
        {
            $jifen_to_price = Model_Jifen_Price::calculate_jifentprice($info['jifentprice_id'],$this->_typeid,$privilege_info['price_jifen'],$member_info);
            $is_use_jifen = empty($jifen_to_price)?0:1;
            $privilege_info['price_jifen'] = empty($jifentprice)?0:$privilege_info['price_jifen'];
        }

        //订单号
        $order_sn = Product::get_ordersn($this->_typeid);
        //价格
        $total_price = $suit_info['price'];
        //积分评论
        $jifen_comment_info = Model_Jifen::get_used_jifencomment($this->_typeid);
        $jifen_comment = empty($jifen_comment_info)?0:$jifen_comment_info['value'];

        //订单状态(全款支付,定金支付,二次确认)
        $status = $suit_info['paytype'] != 3 ? 1 : 0;

        $arr = array(
            'ordersn' => $order_sn,
            'webid' => 0,
            'typeid' => $this->_typeid,
            'productautoid' => $info['id'],
            'productaid' => $info['aid'],
            'productname' => $info['title'],
            'litpic'=>$info['litpic'],
            'price' => $total_price,
            'usedate' => date('Y-m-d',$info['starttime']),
            'dingnum' => $ding_num,
            'departdate' => date('Y-m-d',$info['endtime']),
            'linkman' => $link_info['name'],
            'linktel' => $link_info['phone'],
            'linkemail' => $link_info['email'],
            'jifentprice' => $jifen_to_price,
            'jifenbook' => $info['jifenbook_id'],
            'jifencomment' => $jifen_comment,
            'addtime' => time(),
            'memberid' => $member_id,
            'dingjin' => $suit_info['dingjin'],
            'paytype' => $suit_info['paytype'],
            'suitid' => $suit_id,
            'usejifen' => $is_use_jifen,
            'needjifen' => $privilege_info['price_jifen'],
            'status' => $status,
            'remark' => $remark,
            'isneedpiao' => 0

        );

        /*--------------------------------------------------------------优惠券信息------------------------------------------------------------*/
        //优惠券判断
        $coupon_id = intval($privilege_info['coupon_id']);
        if($coupon_id)
        {
            $cid = DB::select('cid')->from('member_coupon')->where("id=$coupon_id")->execute()->current();
            $total_price = Model_Coupon::get_order_totalprice($arr);
            $is_check =  Model_Coupon::check_samount($coupon_id,$total_price,$this->_typeid,$info['id']);
            if($is_check['status']==1)
            {
                Model_Coupon::add_coupon_order($cid,$order_sn,$total_price,$is_check,$coupon_id); //添加订单优惠券信息
            }
            else
            {
                $this->send_datagrams($this->client_info['id'], false, $this->client_info['secret_key'], false,'下单失败，优惠券不满足条件','下单失败，优惠券不满足条件');
                return;
            }
        }

        /*-----------------------------------------------------------------优惠券信息--------------------------------------*/
        //添加订单

        if (Model_Api_Standard_Order::add_order($arr, 'Model_Campaign',$arr))
        {


            $order_info = Model_Member_Order::order_info($order_sn);


            $tourer_list_new = array();
            foreach($tourer_list as $tourer)
            {
                $tourer_new = array();
                $tourer_new['tourername'] = $tourer['name'];
                $tourer_new['cardtype'] = $tourer['card_type'];
                $tourer_new['cardnumber'] = $tourer['card_number'];
                $tourer_new['sex'] = $tourer['sex'];
                $tourer_new['mobile'] = $tourer['phone'];
               // $tourer_new['email'] = $tourer['email'];
                $tourer_new['address'] = $tourer['address'];
                $tourer_list_new[] = $tourer_new;
            }

            Model_Campaign_Tourer::add_tourer($order_info['id'], $tourer_list_new,$order_info['memberid']);

            if ($is_need_bill)
            {
                Model_Member_Order_Bill::add_bill_info($order_info['id'], $bill_info);
            }

            $this->send_datagrams($this->client_info['id'], $order_info, $this->client_info['secret_key']);
        }

    }

    public function action_order_detail()
    {


        $order_id =$this->request_body->content->order_id;
        $order_info = Model_Api_Standard_Campaign::order_detail($order_id);
        $this->send_datagrams($this->client_info['id'], $order_info, $this->client_info['secret_key']);
    }
    private function format_date($starttime)
    {
        $date = array();
        $week_arr = array("周日", "周一", "周二", "周三", "周四", "周五", "周六");
        $week = $week_arr[date('w', $starttime)];
        $str = date('m月d日',$starttime);
        $str .="({$week})";
        return $str;
    }

    public static function struct_to_array($item)
    {
        if (is_object($item) || is_array($item))
        {
            $item = (array)$item;
            foreach ($item as $key => $val)
            {
                $item[$key] = self::struct_to_array($val);
            }
        }
        return $item;
    }

    /**
     * @function 删除产品相关的数据
     * @param $product_id
     * @return mixed
     */
    public function delete_clear($product_id)
    {
        // TODO: Implement delete_clear() method.
    }

    /**
     * @function 获取产品访问地址
     * @param array $params
     * @return string
     */
    public function get_show_url($params = array())
    {
        // TODO: Implement get_show_url() method.
    }

    /**
     * @function 获取产品最低价
     * @param array $params
     * @return float
     */
    public function get_minprice($params = array())
    {
        // TODO: Implement get_minprice() method.
    }

    /**
     * @function 获取搜索结果
     * @param array $params
     * @return json
     */
    public function search_result($params = array())
    {
        // TODO: Implement search_result() method.
    }

    /**
     * @function 生成列表页面seotitle信息
     * @param array $param
     * @return string
     */
    public function gen_seotitle($param = array())
    {
        // TODO: Implement gen_seotitle() method.
    }

    /**
     * @function 库存检测函数,用于检测库存是否满足预订需求
     * @param array $param
     * @return bool true|false
     */
    public function check_storage($param = array())
    {
        // TODO: Implement check_storage() method.
    }

    /**
     * @function 库存操作函数,实现库存的减少与添加
     * @param array $param
     * @return bool true|false
     */
    public function storage($param = array())
    {
        // TODO: Implement storage() method.
    }
}