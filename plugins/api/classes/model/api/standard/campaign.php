<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/23 0023
 * Time: 13:34
 */
class Model_Api_Standard_Campaign extends Model_Campaign
{

    protected static $_typeid=105;
    /**
     * @function 获取栏目信息
     * @param int $platform 平台，0表示PC端，1表示移动端
     * @param int $webid 子站id
     * @return mixed
     */
    public static function channel($platform=0,$webid=0)
    {
        $row = array();
        if($platform==0)
        {
            $row = DB::select()->from('nav')->where('typeid', '=', self::$_typeid)->and_where('issystem', '=', 1)->and_where('webid','=',$webid)->execute()->current();
        }
        else if($platform==1)
        {
            $row = DB::select()->from('m_nav')->where('m_typeid','=',self::$_typeid)->and_where('m_issystem','=',1)->execute()->current();
        }
        return $row;
    }

    /**
     * @function 获取产品详情
     * @param $id 产品id
     * @return array
     * @throws Kohana_Exception
     */
    public static function detail($id)
    {
        $info = ORM::factory('campaign')->where('id', '=', $id)->find()->as_array();
        if(empty($info))
        {
            return null;
        }
        //seo
        $seo_info = Product::seo($info);

        $info['seo_info'] = $seo_info;
        //产品图片
        $piclist = Product::pic_list($info['piclist']);
        $piclist_new = array();
        foreach($piclist as &$pic)
        {
            $pic_new = Model_Api_Standard_System::reorganized_resource_url($pic[0]);
            $piclist_new[] = $pic_new;
        }
        $info['pic_list'] = $piclist_new;
        //属性列表
        $info['attr_list'] = Model_Campaign::line_attr($info['attrid']);
        //最低价
        $info['price'] = Model_Campaign::get_minprice($info['id'], array('info', $info));
        //点评数
        $info['comment_num'] = Model_Comment::get_comment_num($info['id'], self::$_typeid);
        //销售数量
        $info['sell_num'] = Model_Member_Order::get_sell_num($info['id'], self::$_typeid) + intval($info['bookcount']);
        //产品编号
        $info['series'] = St_Product::product_series($info['id'], self::$_typeid);
        //产品图标
        $info['icon_list'] = Product::get_ico_list($info['iconlist']);
        //最新航线
        $info['satisfy_score'] = St_Functions::get_satisfy(self::$_typeid,$info['id'],$info['satisfyscore']);

        $info['line_doc'] = unserialize($info['linedoc']);
        $info['joined_number'] =Model_Campaign::get_joined_number($info['id']);
        $info['joining_number'] = Model_Campaign::get_joining_number($info['id']);

        $info['gathertime_fmt'] = date('Y-m-d H:i:s',$info['gathertime']);
        $info['starttime_fmt'] = date('Y-m-d',$info['starttime']);
        $info['endtime_fmt'] = date('Y-m-d',$info['endtime']);

        $info['startcity_name'] = Model_Startplace::start_city($info['startcity']);
        $info['finaldest_name'] = DB::select('kindname')->from('destinations')->where('id','=',$info['finaldestid'])->execute()->get('kindname');
        $info['book_status']= Model_Campaign::get_book_status($info['bookstarttime'],$info['bookendtime']);

        $info['jifentprice_info'] = Model_Jifen_Price::get_used_jifentprice($info['jifentprice_id'],self::$_typeid);
        $info['jifenbook_info'] = Model_Jifen::get_used_jifenbook($info['jifenbook_id'],self::$_typeid);
        $info['jifencomment_info'] = Model_Jifen::get_used_jifencomment(self::$_typeid);

        //目的地上级
        if ($info['finaldestid'] > 0)
        {
            $finaldest_name = DB::select('kindname')->from('destinations')->where('id','=',$info['finaldestid'])->execute()->get('kindname');
            $info['finaldest_name']= $finaldest_name;
        }
        //扩展字段信息
        $extend_info = ORM::factory('campaign_extend_field')
            ->where("productid=" . $info['id'])
            ->find()
            ->as_array();
        $info['extend_info'] = $extend_info;
        $suits = self::suits($info['id']);
        $info['suit_list'] = $suits;

        $member_list_info = Model_Campaign::search_order_members($info['id']);
        $member_list = $member_list_info['list'];
        foreach($member_list as &$book_member)
        {
            $book_member['litpic'] = Common::img($book_member['litpic']);
        }

        $info['member_list'] = $member_list;
        $info['introduce_list'] = self::get_introduce_list(array('product_info'=>$info));
        return $info;
    }

    /**
     * @function 获取产品套餐列表
     * @param $productid
     * @return Array
     */
    public static function suits($productid)
    {
        $suit = ORM::factory('campaign_suit')
            ->where("campaignid=:productid")
            ->order_by('displayorder', 'ASC')
            ->param(':productid', $productid)
            ->get_all();
        foreach ($suit as &$r)
        {
            $r['title'] = $r['suitname'];
            $r['price'] = Currency_Tool::price($r['price']);
            $r['paytype_name'] = Model_Member_Order::get_paytype_name($r['paytype']);
        }
        return $suit;
    }


    /**
     * @function 获取介绍列表
     * @param $params
     */
    public static function get_introduce_list($params)
    {
        $default = array(
            'typeid' => '',
            'product_info' => 0,
            'onlyrealfield' => 0,
        );
        $params = array_merge($default, $params);
        extract($params);
        if (empty($product_info))
        {
            return array();
        };
        $arr = DB::select('columnname', 'chinesename', 'isrealfield')->from('campaign_content')->where('isopen','=',1)->order_by('displayorder', 'asc')->execute()->as_array();

        $productid = $product_info['id'];//产品id

        $ar = DB::select()->from('campaign_extend_field')->where('productid','=',$productid)->execute()->as_array();

        $list = array();
        foreach ($arr as $v)
        {
            if ($v['columnname'] == 'tupian' || $v['isrealfield']!=1 || $v['columnname']=='linedoc')
            {
                continue;
            }

            $content = !empty($product_info[$v['columnname']]) ? $product_info[$v['columnname']] : $ar[0][$v['columnname']];
            $content = $content ? $content : '';

            $one_item = array();
            $one_item['columnname'] = $v['columnname'];
            $one_item['chinesename'] = $v['chinesename'];
            if(empty($content))
            {
                continue;
            }
            $one_item['content'] =  $content; //针对PC/手机版选择是否去样式.

            //var_dump($a,13246798);
            $list[] = $one_item;

        }
        return $list;
    }

    public static function order_detail($order_id)
    {
        $order_sn = DB::select('ordersn')->from('member_order')->where('id','=',$order_id)->and_where('typeid','=',self::$_typeid)->execute()->get('ordersn');
        $order_info = Model_Member_Order::order_info($order_sn);
        if(empty($order_info))
        {
           return false;
        }
        $order_info['litpic'] = Model_Api_Standard_System::reorganized_resource_url($order_info['litpic']);
        $order_info['addtime_fmt'] = date('Y-m-d H:i:s',$order_info['addtime']);
        $order_info['suit_info'] = Model_Campaign_Suit::suit_info($order_info['suitid']);
        $order_info['tourer_list'] =  DB::select()->from('campaign_tourer')->where('orderid','=',$order_id)->execute()->as_array();
        $product_info = DB::select()->from('campaign')->where('id','=',$order_info['productautoid'])->execute()->current();
        $order_info['gathertime'] = !empty($product_info['gathertime'])?date('Y-m-d H:i',$product_info['gathertime']):'';
        $order_info['gatheraddress'] = $product_info['gatheraddress'];
        $order_info['finaldest_name'] = DB::select('kindname')->from('destinations')->where('id','=',$product_info['finaldestid'])->execute()->get('kindname');
        return $order_info;
    }


}