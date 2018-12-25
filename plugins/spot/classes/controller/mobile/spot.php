<?php defined('SYSPATH') or die('No direct script access.');


/**
 * Class Controller_Spot 门票景点
 */
class Controller_Mobile_Spot extends Stourweb_Controller
{
    private $_typeid = 5;   //产品类型
    private $_cache_key = '';

    public function before()
    {
        parent::before();
        //检查缓存
        $this->_cache_key = Common::get_current_url();
        $html = Common::cache('get', $this->_cache_key);
        $genpage = intval(Arr::get($_GET, 'genpage'));
        if (!empty($html) && empty($genpage)) {
            echo $html;
            exit;
        }
        $channelname = Model_Nav::get_channel_name_mobile($this->_typeid);
        $this->assign('typeid', $this->_typeid);
        $this->assign('channelname', $channelname);

    }

    /*
     * 景点首页
     * */
    public function action_index()
    {
        $seoinfo = Model_Nav::get_channel_seo_mobile($this->_typeid);
        $this->assign('seoinfo', $seoinfo);
        $this->display('../mobile/spot/index', 'spot_index');
        //缓存内容
        $content = $this->response->body();
        Common::cache('set', $this->_cache_key, $content);
    }


    /**
     * @function 底部搜索
     */
    public function action_searchnav()
    {
        $this->assign('typeid', $this->_typeid);
        $this->display('../mobile/spot/searchnav');
    }


    /*
* 选择目的地
*/
    public function action_ajax_get_next_dests()
    {
        $destpy = $_POST['destpy'];
        $typeid = $_POST['typeid'];
        $isparent = $_POST['isparent'];
        $destpy = empty($destpy) ? 'all' : $destpy;
        $dest_info = array('id' => '0', 'kindname' => '目的地', 'pinyin' => 'all');
        $pid = 0;
        if ($destpy != 'all') {
            $dest_info = DB::select()->from('destinations')->where('pinyin', '=', $destpy)->execute()->current();
            $subnum = DB::select(array(DB::expr("count(*)"), 'num'))->from('destinations')->where('pid', '=', $dest_info['id'])->and_where('isopen', '=', 1)->and_where(DB::expr("FIND_IN_SET({$typeid},opentypeids)"), '>', 0)->execute()->get('num');
            $pid = $isparent == 1 || $subnum <= 0 ? $dest_info['pid'] : $dest_info['id'];
        }
        $parents = null;
        if ($pid != 0) {
            $parents = Model_Destinations::get_parents($pid);
            $parents = array_reverse($parents);
            $parents[] = $dest_info;
        }
        $list = DB::select('id', 'pinyin', 'kindname')->from('destinations')->where('isopen', '=', 1)->and_where('pid', '=', $pid)->and_where(DB::expr("FIND_IN_SET({$typeid},opentypeids)"), '>', 0)->execute()->as_array();
        foreach ($list as &$child) {
            $child['subnum'] = DB::select(array(DB::expr("count(*)"), 'num'))->from('destinations')->where('pid', '=', $child['id'])->and_where('isopen', '=', 1)->and_where(DB::expr("FIND_IN_SET({$typeid},opentypeids)"), '>', 0)->execute()->get('num');
        }
        $parent = DB::select('id', 'kindname', 'pinyin')->from('destinations')->where('id', '=', $pid)->execute()->current();
        echo json_encode(array('status' => true, 'list' => $list, 'parents' => $parents, 'parent' => $parent));
    }


    /*
    * 优惠信息
    */
    public function action_discount()
    {
        $jifen = array();
        $bool = true;
        $member = Model_Member_Login::check_login_info();
        if ($member) {
            $userInfo = Model_Member::get_member_byid($member['mid']);
            $jifen['isopen'] = 1;
            $jifen['exchange'] = $GLOBALS['cfg_exchange_jifen'];
            $jifen['userjifen'] = $userInfo['jifen'];
            if (empty($jifen['exchange'])) {
                $bool = false;
            }
        }
        $this->assign('jifen', $jifen);
        /*******************************新增优惠券********************************/
        if (St_Functions::is_normal_app_install('coupon')) {
            $typeid = intval($this->request->param('typeid'));
            $proid = intval($this->request->param('productid'));
            $couponlist = Model_Coupon::get_pro_coupon($typeid, $proid);
            if ($couponlist) {
                $bool = true;
                $this->assign('couponlist', $couponlist);
            }
        }
        $this->assign('typeid', $this->_typeid);

        if ($bool) {
            $this->display('../mobile/spot/discount');
        }


    }


    //获取报价日历html
    public function action_ajax_price_calendar()
    {
        $suitid = $_GET['suitid'];
        $productid = $_GET['productid'];
        $startdate = $_GET['startdate'];
        $year = date("Y"); //当前月
        $month = date("m");//当前年
        $out = '';

        //线路提前预定
        $day = strtotime(date('Y-m-d'));

        $startdate = $startdate ? $startdate : date('Y-m-d', $day);
        $out .= '<div class="calendar-tip-bar"><div class="calendar-hd" id="calendarHd"><table>';
        $out .= '<tbody><tr><th>日</th><th>一</th><th>二</th><th>三</th><th>四</th><th>五</th><th>六</th></tr>';
        $out .= '</tbody></table></div></div>';

        for ($i = 1; $i <= 24; $i++) {
            if ($month == 13) {
                $year = $year + 1;
                $month = 1;
            }
            $price_arr = Model_Spot::get_month_price($year, $month, $suitid, $startdate);

            $out .= empty($price_arr) ? '' : self::gen_price_calendar_html($year, $month, $price_arr);
            $month++;
        }
        echo $out;

    }

    public static function gen_price_calendar_html($year, $month, $price_arr)
    {

        $first_day_time = strtotime($year . '-' . $month . '-' . '01');
        $last_day_time = strtotime(date('Y-m-d', $first_day_time) . " +1 month -1 day");
        $start_week = date('w', $first_day_time);
        $start_week = $start_week == 0 ? 7 : $start_week;

        $currency_symbol = Currency_Tool::symbol();

        $html = '<div class="calendar-wrap"><h3 class="calendar-date">';
        $html .= '<strong class="calendar-cur" time-data="">' . date('Y年m月', $first_day_time) . '</strong></h3>';
        $html .= '<table width="100%">';

        for ($j = 1; $j <= 8; $j++) {
            $html .= '<tr class="calendar-bd">';
            for ($i = 0; $i < 7; $i++) {

                $number = ($j - 1) * 7 + $i;
                $cur_day_time = $first_day_time + ($number - $start_week) * 24 * 3600;
                $cur_date = date('Y-m-d', $cur_day_time);
                $cur_day = date('j', $cur_day_time);
                $price_info = $price_arr[$cur_day_time];
                if ($cur_day_time < $first_day_time || $cur_day_time > $last_day_time) {
                    $html .= '<td><div class="item"></div></td>';
                }
                else if (empty($price_info)) {
                    $html .= '<td><div class="item"><span class="date">' . $cur_day . '</span></div></td>';
                }
                else if (!empty($price_info)) {

                    $html .= '<td adultprice="' . $price_info['adult_price'] . '" childprice="' . $price_info['child_price'] . '" oldprice="' . $price_info['old_price'] . '" number="' . $price_info['number'] . '"  date="' . $cur_date . '"  onclick="choose_day(this)">';
                    $html .= '<div class="item opt"><span class="date">' . $cur_day . '</span>';
                    $html .= '<span class="price">' . $currency_symbol . $price_info['price'] . '<br></span>';
                    $stock = $price_info['number'] == '-1' ? '库存充足' : '剩余'.$price_info['number'].'张';
                    $html .= '<span class="stock">' . $stock . '</span>';
                    $html .= '</div></td>';
                }

            }
            $html .= '</tr>';
            if ($cur_day_time && $cur_day_time > $last_day_time) {
                break;
            }
        }

        $html .= '</table></div>';
        return $html;


    }

    /*
     * 列表页面
     * */
    public function action_list()
    {
        //参数处理
        $urlParam = $this->request->param('params');
        $destPy = 'all';
        $priceId = $sortType = $keyword = $attrId = $page = 0;
        $params = explode('-', str_replace('/', '-', $urlParam));
        $count = count($params);
        switch ($count) {
            //目的地
            case 1:
                list($destPy) = $params;
                break;
            //属性
            case 5:
                list($destPy, $priceId, $sortType, $attrId, $page) = $params;
                break;
        }
        $keyword = Arr::get($_GET, 'keyword');
        $destname = $destPy != 'all' ? DB::select('kindname')->from('destinations')->where('pinyin', '=', $destPy)->execute()->get('kindname') : '目的地';
        $page = empty($page) ? 1 : $page;
        //获取seo信息
        $seo = Model_Spot::search_seo($destPy, $this->_typeid);
        if ($page > 1) {
            $seo['seotitle'] = '第' . $page . '页_' . $seo['seotitle'];
        }
        $destid = $destPy != 'all' ? DB::select('id')->from('destinations')->where('pinyin', '=', $destPy)->execute()->get('id') : 0;

        $seo_params = array(

            'destpy' => $destPy,
            'priceid' => $priceId,
            'sorttype' => $sortType,
            'attrid' => $attrId,
            'page' => $page,
            'keyword' => $keyword,
        );
        $search_title = Model_Spot::gen_seotitle($seo_params);
        $this->assign('search_title', $search_title);
        $this->assign('seoinfo', $seo);
        $this->assign('destpy', Common::remove_xss($destPy));
        $this->assign('destname', $destname);
        $this->assign('destid', $destid);
        $this->assign('sorttype', intval($sortType));
        $this->assign('keyword', Common::remove_xss($keyword));
        $this->assign('attrid', Common::remove_xss($attrId));
        $this->assign('priceid', intval($priceId));
        $this->assign('page', $page);
        $this->display('../mobile/spot/list', 'spot_list');
        //缓存内容
        $content = $this->response->body();
        Common::cache('set', $this->_cache_key, $content);
    }

    /*
     * 景点/门票详细页
     * */
    public function action_show()
    {
        $aid = intval($this->request->param('aid'));
        //子站内容显示
        if (isset($_GET['webid'])) {
            $GLOBALS['sys_webid'] = intval(Arr::get($_GET, 'webid'));
        }
        $row = DB::select()->from('spot')->where('webid', '=', $GLOBALS['sys_webid'])->and_where('aid', '=', $aid)->execute()->current();

        if(empty($row))
        {
            Common::head_404();
        }

        //点击率加一
        Product::update_click_rate($aid, $this->_typeid);
        //扩展字段信息
        $extend_info = Model_Spot::get_extend_info($row['id']);
        $seoinfo = Product::seo($row);
        $priceArr = Model_Spot::get_minprice($row['id'], array('info' => $row));
        $row['hasticket'] = Model_Spot::has_ticket($row['id']);
        $row['piclist'] = Product::pic_list($row['piclist']);
        $row['price'] = $priceArr['price'];
        $row['sellprice'] = $priceArr['sellprice'];
        $row['attrlist'] = Model_Spot_Attr::get_attr_list($row['attrid']);//属性列表.
        $row['commentnum'] = Model_Comment::get_comment_num($row['id'], 5); //评论次数
        $row['satisfyscore'] = Model_Comment::get_score($row['id'], $this->_typeid, $row['satisfyscore'], $row['commentnum']);//满意度
        $row['sellnum'] = Model_Member_Order::get_sell_num($row['id'], 5) + intval($row['bookcount']); //销售数量
        $jifentprice_info = Model_Jifen_Price::get_used_jifentprice($row['jifentprice_id'], $this->_typeid);
        $this->assign('jifentprice_info', $jifentprice_info);
        $jifenbook_info = Model_Jifen::get_used_jifenbook($row['jifenbook_id'], $this->_typeid);
        $this->assign('jifenbook_info', $jifenbook_info);
        $jifencomment_info = Model_Jifen::get_used_jifencomment($this->_typeid);
        $this->assign('jifencomment_info', $jifencomment_info);
        $this->assign('seoinfo', $seoinfo);
        $this->assign('info', $row);
        $this->assign('extendinfo', $extend_info);

        $template = Model_Spot::get_product_template($row,true);
        $user_tpl = $template ?  true : false;
        $user_tpl ? $show_templat = $template : $show_templat = '../mobile/spot/show';
        $this->display($show_templat,'spot_show',$user_tpl);
        //缓存内容
        $content = $this->response->body();
        Common::cache('set', $this->_cache_key, $content);
    }

    /*
    * 门票预订
     * */
    public function action_book()
    {
        $userinfo = Model_Member_Login::check_login_info();
        $userinfo = Model_Member::get_member_byid($userinfo['mid']);
        $suitid = intval($_GET['suitid']);
        //要求预订前必须登陆
        if (!empty($GLOBALS['cfg_login_order']) && empty($userinfo['mid'])) {
            $cancel_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $this->cmsurl;
            $this->request->redirect(Common::get_main_host() . '/phone/member/login?redirecturl=' . urlencode(Common::get_current_url()).'&cancelurl='.urlencode($cancel_url));
        }
        $productid = intval($this->params['id']);
        //要求预订页必须选中套餐
        if (empty($suitid)) {
            $this->request->redirect(Common::get_main_host() . '/phone/spots/show_'.$productid.'.html');
        }
        $info = DB::select()->from('spot')->where('id', '=', $productid)->execute()->current();
        $priceArr = Model_Spot::get_minprice($info['id'], array('info' => $info));
        $info['price'] = $priceArr['price'];
        $jifentprice_info = Model_Jifen_Price::get_used_jifentprice($info['jifentprice_id'], $this->_typeid);
        $this->assign('jifentprice_info', $jifentprice_info);
        $this->assign('info', $info);
        $this->assign('userinfo', $userinfo);
        $member = Model_Member_Login::check_login_info();
        $suit_info=Model_Spot_Suit::suit_info($suitid);
        $this->assign('suit_info', $suit_info);
        $next_price=Model_Spot_Ticket_Price::get_next_price($suit_info);
        $this->assign('next_price',$next_price);
        $this->assign('suitid',$suitid);
        if (!empty($member)) {
            $this->assign('member', Model_Member::get_member_byid($member['mid']));
        }
        $this->display('../mobile/spot/book');
    }

    /**
     * 套餐当天价格
     */
    public function action_suit_day_price()
    {
        $inputdate = Arr::get($_GET, 'inputdate');
        $suitid = intval(Arr::get($_GET, 'suitid'));
        $suit_info=Model_Spot_Suit::suit_info($suitid);
        $order_start_date=time()+$suit_info["day_before"]*24*3600;
        $info = Model_Spot_Ticket_Price::current_price($suitid, strtotime($inputdate));
        $price = !empty($info) ? $info['price'] : 0;
        if($order_start_date>strtotime($inputdate))
        {
            $price=0;
            $info['number']=0;
        }
        echo json_encode(array('price' => $price));
    }

    /*
     * 创建订单
     * */
    public function action_create()
    {
        St_Product::token_check($_POST) or Common::order_status();
        $refer_url = $_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : $this->cmsurl;
        //套餐id
        $suitid = intval(Arr::get($_POST, 'suitid'));
        //联系人
        $linkman = Arr::get($_POST, 'linkman');
        //手机号
        $linktel = Arr::get($_POST, 'linktel');
        $linkidcard = Arr::get($_POST, 'linkidcard');
        //备注信息
        $remark = Arr::get($_POST, 'remark');
        //产品id

        $id = intval(Arr::get($_POST, 'productid'));
        //使用时间
        $usedate = Arr::get($_POST, 'startdate');
        //预订数量
        $dingnum = intval(Arr::get($_POST, 'dingnum'));
        $needJifen = $_POST['needjifen'];
        //验证部分
        $validataion = Validation::factory($_POST);
        $validataion->rule('linktel', 'not_empty');
        $validataion->rule('linktel', 'phone');
        $validataion->rule('linkman', 'not_empty');
        if (!$validataion->check()) {
            $error = $validataion->errors();
            $keys = array_keys($validataion->errors());
            Common::message(array('message' => __("error_{$keys[0]}_{$error[$keys[0]][0]}"), 'jumpUrl' => $refer_url));
        }
        $info = ORM::factory('spot')->where("id=$id")->find()->as_array();

        $suitArr = DB::select()->from('spot_ticket')->where('id', '=', $suitid)->execute()->current();
        $suitArr['dingjin'] = Currency_Tool::price($suitArr['dingjin']);
        $suit = DB::select()->from('spot_ticket_price')->where('ticketid', '=', $suitid)->and_where('day', '=', strtotime($usedate))->execute()->current();
        $suitArr['ourprice'] = Currency_Tool::price($suit['adultprice']);
        if ($suitArr['paytype'] == '3')//这里补充一个当为二次确认时,修改订单为未处理状态.
        {
            $info['status'] = 0;
        }
        else {
            $info['status'] = 1;
        }
        $info['name'] = $info['title'] . ' -- '. Model_Spot_Ticket_Type::get_info($suitArr['tickettypeid'], 'kindname') . "({$suitArr['title']})";
        $info['paytype'] = $suitArr['paytype'];
        $info['dingjin'] = doubleval($suitArr['dingjin']);

        $info['ourprice'] = doubleval($suitArr['ourprice']);
        $info['childprice'] = 0;
        $info['usedate'] = $usedate;
        $ordersn = Product::get_ordersn('05');


        //积分抵现.
        $userInfo = Model_Member_Login::check_login_info();
        $userInfo = Model_Member::get_member_byid($userInfo['mid']);
        $jifentprice = 0;
        $useJifen = 0;
        if ($needJifen) {
            $jifentprice = Model_Jifen_Price::calculate_jifentprice($info['jifentprice_id'], $this->_typeid, $needJifen, $userInfo);
            $useJifen = empty($jifentprice) ? 0 : 1;
            $needJifen = empty($jifentprice) ? 0 : $needJifen;
        }
        //积分评论
        $jifencomment_info = Model_Jifen::get_used_jifencomment($this->_typeid);
        $jifencomment = empty($jifencomment_info) ? 0 : $jifencomment_info['value'];

        //自动关闭订单时间
        $auto_close_time = $suitArr['auto_close_time'] ? $suitArr['auto_close_time'] : 0;
        if($auto_close_time)
        {
            // $auto_close_time = strtotime("+{$auto_close_time} hours");
            $auto_close_time = $auto_close_time + time();

        }
        $arr = array(
            'ordersn' => $ordersn,
            'webid' => 0,
            'typeid' => $this->_typeid,
            'productautoid' => $id,
            'productaid' => $info['aid'],
            'productname' => $info['name'],
            'litpic' => $info['litpic'],
            'price' => $suitArr['ourprice'],
            'childprice' => $info['childprice'],
            'jifentprice' => $jifentprice,
            'jifenbook' => $info['jifenbook_id'],
            'jifencomment' => $jifencomment,
            'paytype' => $suitArr['paytype'],
            'dingjin' => $suitArr['dingjin'],
            'usedate' => $info['usedate'],
            'departdate' => '',
            'addtime' => time(),
            'memberid' => ($member = Model_Member_Login::check_login_info()) ? $member['mid'] : 0,
            'dingnum' => $dingnum,
            'childnum' => 0,
            'oldprice' => 0,
            'oldnum' => 0,
            'linkman' => $linkman,
            'linktel' => $linktel,
            'linkidcard' => $linkidcard,
            'suitid' => $suitid,
            'remark' => $remark,
            'status' => $suitArr['need_confirm'] ? 0:1,
            'usejifen' => $useJifen,
            'needjifen' => $needJifen,
            'source' => 2,//来源手机,
            'pay_way' => $suitArr['pay_way'] ,//线上线下.
            'auto_close_time' =>$auto_close_time, //自动关闭订单时间
            'refund_restriction'=>$suitArr['refund_restriction'],//退改条件
            'need_confirm' => $suitArr['need_confirm'] ? $suitArr['need_confirm'] : 0 ,//是否需要确认.
        );

        /*--------------------------------------------------------------优惠券信息------------------------------------------------------------*/
        //优惠券判断
        $croleid = intval(Arr::get($_POST, 'couponid'));
        if ($croleid) {
            $cid = DB::select('cid')->from('member_coupon')->where("id=$croleid")->execute()->current();
            $totalprice = Model_Coupon::get_order_totalprice($arr);
            $ischeck = Model_Coupon::check_samount($croleid, $totalprice, $this->_typeid, $info['id'], $usedate);


            if ($ischeck['status'] == 1) {
                Model_Coupon::add_coupon_order($cid, $ordersn, $totalprice, $ischeck, $croleid); //添加订单优惠券信息
            }
            else {
                exit('coupon  verification failed!');//优惠券不满足条件
            }
        }
        /*-----------------------------------------------------------------优惠券信息--------------------------------------*/


        //添加订单
        if (St_Product::add_order($arr, 'Model_Spot', $arr)) {
            St_Product::delete_token();
            $order_info = Model_Member_Order::order_info($ordersn);
            Model_Member_Order::add_tourer($order_info['id'], $_POST);//游客信息


            $html = Common::payment_from(array('ordersn' => $ordersn));
            if ($html) {
                echo $html;
            }

        }
    }

    public function add_tourer($orderid, $arr, $memberid)
    {

        $tourname = $arr['tourname'];
        $tourmobile = $arr['tourmobile'];
        $tourcard = $arr['touridcard'];
        $cardtype = $arr['tourcardtype'];

        for ($i = 0; isset($tourname[$i]); $i++) {

            $ar = array(
                'orderid' => $orderid,
                'tourername' => $tourname[$i],
                'cardtype' => $cardtype[$i],
                'cardnumber' => $tourcard[$i],
                'mobile' => $tourmobile[$i]

            );
            $m = ORM::factory('member_order_tourer');
            foreach ($ar as $k => $v) {
                $m->$k = $v;
            }
            $m->save();
            Model_Member_Linkman::add_tourer_to_linkman($ar, $memberid);
            $m->clear();
        }


    }

    /*

     * 景点搜索页(搜索初始页)

     */

    public function action_search()
    {
        $this->display('../mobile/spot/search');
    }


    /**
     * ajax请求 加载更多
     */
    public function action_ajax_spot_more()
    {
        $urlParam = $this->request->param('params');
        $keyword = Arr::get($_GET, 'keyword') ? Arr::get($_GET, 'keyword') : '';
        $data = Model_Spot::search_result_mobile($urlParam, $keyword);
        echo $data;
    }

    /**
     * 按天获取报价与库存.
     */
    public static function action_ajax_price_day()
    {
        $useday = strtotime(Arr::get($_GET, 'date'));
        $suitid = intval(Arr::get($_GET, 'suitid'));
        $ar = Model_Spot_Ticket_Price::current_price($suitid, $useday);
        $data['price']=$ar['price'];
        $data['number']=$ar['number'];
        $data['description']=$ar['description'];
        $data['spotid']=$ar['spotid'];
        $data['ticketid']=$ar['ticketid'];
        echo json_encode($data);
    }


}