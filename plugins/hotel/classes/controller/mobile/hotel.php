<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Class Controller_Hotel
 * @desc 酒店总控制器
 */
class Controller_Mobile_Hotel extends Stourweb_Controller
{
    private $_typeid = 2;   //产品类型
    private $_cache_key = '';

    public function before()
    {
        parent::before();
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

    /**
     * 酒店首页
     */
    public function action_index()
    {
        $seoinfo = Model_Nav::get_channel_seo_mobile($this->_typeid);
        $this->assign('seoinfo', $seoinfo);
        $this->display('../mobile/hotel/index', 'hotel_index');
        //缓存内容
        $content = $this->response->body();
        Common::cache('set', $this->_cache_key, $content);
    }


    public function action_searchnav()
    {


        $this->assign('typeid', $this->_typeid);
        $this->display('../mobile/hotel/searchnav');

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
            $this->display('../mobile/hotel/discount');
        }


    }

    //获取报价日历html
    public function action_ajax_price_calendar()
    {
        $suitid = $_GET['suitid'];
        $productid = $_GET['productid'];
        $startdate = $_GET['startdate'];
        $cov = $_GET['cov'];
        $year = date("Y"); //当前月
        $month = date("m");//当前年
        $out = '';


        $startdate = $startdate ? $startdate : date('Y-m-d');

        for ($i = 1; $i <= 24; $i++) {
            if ($month == 13) {
                $year = $year + 1;
                $month = 1;
            }
            $price_arr = Model_Hotel::get_month_price($year, $month, $suitid, $startdate);
            $out .= empty($price_arr) ? '' : self::gen_price_calendar_html($year, $month, $price_arr, $cov,$suitid);
            $month++;
        }
        echo $out;

    }

    public static function gen_price_calendar_html($year, $month, $price_arr, $cov,$suitid='')
    {

        $first_day_time = strtotime($year . '-' . $month . '-' . '01');
        $last_day_time = strtotime(date('Y-m-d', $first_day_time) . " +1 month -1 day");
        $start_week = date('w', $first_day_time);
        $start_week = $start_week == 0 ? 7 : $start_week;

        $currency_symbol = Currency_Tool::symbol();

        $html = '<div class="calendar-wrap"><h3 class="calendar-date">';
        $html .= '<strong class="calendar-cur" time-data="">' . date('Y年m月', $first_day_time) . '</strong></h3>';
        $html .= '<table width="100%">';
        $html .= '<tr class="calendar-hd"><th>一</th><th>二</th><th>三</th><th>四</th><th>五</th><th>六</th><th>日</th></tr>';


        $prev_day_enable_select=false;
        for ($j = 1; $j <= 8; $j++) {
            $html .= '<tr class="calendar-bd">';
            for ($i = 1; $i <= 7; $i++) {

                $number = ($j - 1) * 7 + $i;
                $cur_day_time = $first_day_time + ($number - $start_week) * 24 * 3600;
                $cur_date = date('Y-m-d', $cur_day_time);
                $cur_day = date('j', $cur_day_time);

                $price_info = $price_arr[$cur_day_time];
                if ($cur_day_time < $first_day_time || $cur_day_time > $last_day_time) {
                    $html .= '<td><div class="item"></div></td>';
                    $prev_day_enable_select=false;
                }
                else if (empty($price_info))
                {
                    if($cov=='txt_enddate')
                    {

                        $prev_date_timestamp = strtotime($cur_date)-24*3600;
                        $prev_date_price_info = DB::select()->from('hotel_room_price')->where('suitid','=',$suitid)->and_where('day','=',$prev_date_timestamp)->execute()->current();
                        if(!empty($prev_date_price_info) &&  $prev_date_price_info['number']!=0)
                        {
                            $prev_day_enable_select=true;
                        }

                    }
                    else
                    {
                        $prev_day_enable_select=false;
                    }
                    $prev_click_str=$prev_day_enable_select?'date="' . $cur_date . '"  onclick="choose_day(this,\'' . $cov . '\')"':'';
                    $html .= '<td '.$prev_click_str.'><div class="item opt"><span class="date">' . $cur_day . '</span></div></td>';
                    $prev_day_enable_select=false;
                }
                else if (!empty($price_info))
                {

                    $prev_day_enable_select=true;
                    $html .= '<td adultprice="' . $price_info['adult_price'] . '" childprice="' . $price_info['child_price'] . '" oldprice="' . $price_info['old_price'] . '" number="' . $price_info['number'] . '" roombalance="' . $price_info['roombalance'] . '" date="' . $cur_date . '"  onclick="choose_day(this,\'' . $cov . '\')">';
                    $html .= '<div class="item opt"><span class="date">' . $cur_day . '</span>';
                    $html .= '<span class="price">' . $currency_symbol . $price_info['price'] . '<br></span>';
                    $stock = $price_info['number'] == '-1' ? '库存充足' : $price_info['number'];
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


    public function action_map()
    {
        $id = intval($_GET['id']);
        $info = DB::select()->from('hotel')->where('id', '=', $id)->execute()->current();
        $seoinfo = array('seotitle' => $info['title']);
        $this->assign('info', $info);
        $this->assign('seoinfo', $seoinfo);
        $this->display('../mobile/hotel/map');
    }

    public function action_mapnear()
    {
        $seoinfo = array('seotitle' => '附近酒店');
        $this->assign('seoinfo', $seoinfo);
        $this->display('../mobile/hotel/mapnear');
    }

    /*
     * 酒店搜索页(搜索初始页)
     */
    public function action_search()
    {
        $this->display('../mobile/hotel/search');
    }

    /*
     * 酒店搜索列表页
     * */
    public function action_list()
    {
        //参数处理
        $urlParam = $this->request->param('params');
        $destPy = 'all';
        $destId = $rankId = $priceId = $sortType = $keyword = $attrId = 0;
        $params = explode('-', str_replace('/', '-', $urlParam));
        $count = count($params);
        switch ($count) {
            //目的地
            case 1:
                list($destPy) = $params;
                break;
            //关键字、属性
            case 7:
                list($destPy, $rankId, $priceId, $sortType, $keyword, $attrId, $page) = $params;
                break;
        }
        $keyword = Arr::get($_GET, 'keyword');
        $page = $page < 1 ? 1 : intval($page);
        $destname = $destPy != 'all' ? ORM::factory('destinations')->where('pinyin', '=', $destPy)->find()->get('kindname') : '目的地';
        $destid = $destPy != 'all' ? DB::select('id')->from('destinations')->where('pinyin', '=', $destPy)->execute()->get('id') : 0;
        //获取seo信息
        $seo = Model_Hotel::search_seo_mobile($destPy, 2);

        //入店时间
        $starttime = Arr::get($_GET, 'starttime');
        //离店时间
        $endtime = Arr::get($_GET, 'endtime');


        $seo_params = array(
            'destpy' => $destPy,
            'rankid' => $rankId,
            'priceid' => $priceId,
            'sorttype' => $sortType,
            'displaytype' => 0,
            'attrid' => $attrId,
            'p' => $page,
            'keyword' => $keyword,
            'starttime' => $starttime,
            'endtime' => $endtime
        );
        $search_title = Model_Hotel::gen_seotitle($seo_params);
        $this->assign('search_title', $search_title);
        $this->assign('seoinfo', $seo);
        $this->assign('destpy', Common::remove_xss($destPy));
        $this->assign('destname', $destname);
        $this->assign('rankid', Common::remove_xss($rankId));
        $this->assign('sorttype', Common::remove_xss($sortType));
        $this->assign('keyword', Common::remove_xss($keyword));
        $this->assign('attrid', Common::remove_xss($attrId));
        $this->assign('priceid', Common::remove_xss($priceId));
        $this->assign('destid', $destid);
        $this->assign('starttime', $starttime);
        $this->assign('endtime', $endtime);
        $this->assign('page', $page);
        $this->display('../mobile/hotel/list', 'hotel_list');
        //缓存内容
        $content = $this->response->body();
        Common::cache('set', $this->_cache_key, $content);
    }

    /*
     * 酒店详细页
     */
    public function action_show()
    {
        $aid = intval($this->request->param('aid'));
        //子站内容显示
        if (isset($_GET['webid'])) {
            $GLOBALS['sys_webid'] = intval(Arr::get($_GET, 'webid'));
        }
        $info = DB::select()->from('hotel')->where('webid', '=', $GLOBALS['sys_webid'])->and_where('aid', '=', $aid)->execute()->current();

        if(empty($info))
        {
            Common::head_404();
        }

        //扩展字段信息
        $extend_info = DB::select()->from('hotel_extend_field')->where('productid', '=', $info['id'])->execute()->as_array();
        //点击率加一
        Product::update_click_rate($aid, $this->_typeid);
        $seoinfo = Product::seo($info);
        $info['piclist'] = Product::pic_list($info['piclist']);
        $info['price'] = Model_Hotel::get_minprice($info['id'], array('info', $info));
        $info['commentnum'] = Model_Comment::get_comment_num($info['id'], $this->_typeid); //评论次数
        $info['satisfyscore'] = Model_Comment::get_score($info['id'], $this->_typeid, $info['satisfyscore'], $info['commentnum']);//满意度
        $info['sellnum'] = Model_Member_Order::get_sell_num($info['id'], $this->_typeid) + intval($info['bookcount']); //销售数量
        $info['hotelrank'] = ORM::factory('hotel_rank', $info['hotelrankid'])->get('hotelrank');
        //供应商
        $info['suppliers']=null;
        if($info['supplierlist'])
        {
            $info['suppliers'] = DB::query(1, "SELECT suppliername FROM `sline_supplier` WHERE id={$info['supplierlist']}")->execute()->current();
        }
        $this->assign('seoinfo', $seoinfo);
        $this->assign('info', $info);
        $this->assign('extendinfo', $extend_info);
        $this->display('../mobile/hotel/show', 'hotel_show');
        //缓存内容
        $content = $this->response->body();
        Common::cache('set', $this->_cache_key, $content);
    }

    /*
     * 酒店预订页
     * */
    public function action_book()
    {
        $userinfo = Model_Member_Login::check_login_info();
        $userinfo = Model_Member::get_member_byid($userinfo['mid']);
        //要求预订前必须登陆
        if (!empty($GLOBALS['cfg_login_order']) && empty($userinfo['mid']))
        {
            $cancel_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $this->cmsurl;
            $this->request->redirect(Common::get_main_host() . '/phone/member/login?redirecturl=' . urlencode(Common::get_current_url()).'&cancelurl='.urlencode($cancel_url));
        }
        $productid = intval($this->params['id']);
        $suitid = intval($this->params['suitid']);
        $startdate = strtotime($this->params['startdate']) ;
        $enddate = strtotime($this->params['enddate'] );
        $startdate  = $startdate ? date('Y-m-d',$startdate) : date('Y-m-d');
        $enddate  = $enddate ? date('Y-m-d',$enddate) : date('Y-m-d',strtotime('+1 days'));



        $info = DB::select()->from('hotel')->where('id', '=', $productid)->execute()->current();
        $info['price'] = Model_Hotel::get_minprice($info['id'], array('info' => $info));
        $jifentprice_info = Model_Jifen_Price::get_used_jifentprice($info['jifentprice_id'], $this->_typeid);
        $this->assign('jifentprice_info', $jifentprice_info);
        $this->assign('info', $info);
        $this->assign('suitid', $suitid);
        $this->assign('userinfo', $userinfo);
        $this->assign('startdate', $startdate);
        $this->assign('enddate', $enddate);
        $member = Model_Member_Login::check_login_info();
        if (!empty($member)) {
            $this->assign('member', Model_Member::get_member_byid($member['mid']));
        }
        $this->display('../mobile/hotel/book');
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
        $linkman = common::remove_xss(Arr::get($_POST, 'linkman'));
        //手机号
        $linktel = common::remove_xss(Arr::get($_POST, 'linktel'));
        $linkidcard = common::remove_xss(Arr::get($_POST, 'linkidcard'));
        //备注信息
        $remark = common::remove_xss(Arr::get($_POST, 'remark'));
        //产品id
        $id = intval(Arr::get($_POST, 'productid'));
        //入住时间
        $startdate = Arr::get($_POST, 'startdate');
        //离店时间
        $leavedate = Arr::get($_POST, 'departdate');
        //预订房间数
        $dingnum = intval(Arr::get($_POST, 'dingnum'));

        $needJifen = $_POST['needjifen'];


        //日期判断
        if(!(strtotime($startdate)<strtotime($leavedate)))
        {
            Common::message(array('message' => "入住日期必须大于离店日期", 'jumpUrl' => $refer_url));
        }




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
        $info = ORM::factory('hotel')->where('id', '=', $id)->find()->as_array();
        $suitArr = ORM::factory('hotel_room')->where('id', '=', $suitid)->find()->as_array();
        $suitArr['dingjin'] = Currency_Tool::price($suitArr['dingjin']);
        $suitPrice = Model_Hotel::suit_range_price($suitid, $startdate, $leavedate, $dingnum);
        if (in_array($suitArr['paytype'], array(3, 4)))//这里补充一个当为二次确认时,修改订单为未处理状态.
        {
            $info['status'] = 0;
        }
        else {
            $info['status'] = 1;
        }
        $info['name'] = $info['title'] . "({$suitArr['roomname']})";
        $info['paytype'] = $suitArr['paytype'];
        $info['dingjin'] = $suitArr['dingjin'];
        $info['ourprice'] = doubleval($suitPrice);
        $info['childprice'] = 0;
        $info['usedate'] = $startdate;
        $info['departdate'] = $leavedate;

        $diffdate = (strtotime($leavedate) - strtotime($startdate)) / (24 * 60 * 60);
        $info['dingjin'] = doubleval($info['dingjin'] * $diffdate);


        //积分抵现.
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


        $ordersn = Product::get_ordersn('02');
        $arr = array(
            'ordersn' => $ordersn,
            'webid' => 0,
            'typeid' => $this->_typeid,
            'productautoid' => $id,
            'productaid' => $info['aid'],
            'productname' => $info['name'],
            'litpic' => $info['litpic'],
            'price' => $info['ourprice'],
            'childprice' => $info['childprice'],
            'jifentprice' => $jifentprice,
            'jifenbook' => $info['jifenbook_id'],
            'jifencomment' => $jifencomment,
            'paytype' => $info['paytype'],
            'dingjin' => $info['dingjin'],
            'usedate' => $info['usedate'],
            'departdate' => $info['departdate'],
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
            'status' => $info['status'] ? $info['status'] : 0,
            'usejifen' => $useJifen,
            'needjifen' => $needJifen,
        );
        /*--------------------------------------------------------------优惠券信息------------------------------------------------------------*/
        //优惠券判断
        $croleid = intval(Arr::get($_POST, 'couponid'));
        if ($croleid) {
            $cid = DB::select('cid')->from('member_coupon')->where("id=$croleid")->execute()->current();
            $totalprice = Model_Coupon::get_order_totalprice($arr);
            $ischeck = Model_Coupon::check_samount($croleid, $totalprice, $this->_typeid, $info['id'], $startdate);
            if ($ischeck['status'] == 1) {
                Model_Coupon::add_coupon_order($cid, $ordersn, $totalprice, $ischeck, $croleid); //添加订单优惠券信息
            }
            else {
                exit('coupon  verification failed!');//优惠券不满足条件
            }
        }
        /*-----------------------------------------------------------------优惠券信息--------------------------------------*/

        //添加订单
        if (St_Product::add_order($arr, 'Model_Hotel', $arr)) {
            St_Product::delete_token();

            $order_info = Model_Member_Order::order_info($ordersn);
            Model_Member_Order::add_tourer($order_info['id'], $_POST);//游客信息

            $html = Common::payment_from(array('ordersn' => $ordersn));
            if ($html) {
                echo $html;
            }
        }
    }

    /**
     * ajax请求 加载更多
     */
    public function action_ajax_hotel_more()
    {
        $urlParam = $this->request->param('params');
        $keyword = Arr::get($_GET, 'keyword') ? Arr::get($_GET, 'keyword') : '';

        //入店时间
        if (isset($_GET['starttime']) && !empty($_GET['starttime'])) {
            $starttime = strtotime(St_Filter::remove_xss($_GET['starttime']));
        }
        //离店时间
        if (isset($_GET['endtime']) && !empty($_GET['endtime'])) {
            $endtime = strtotime(St_Filter::remove_xss($_GET['endtime']));
        }

        $data = Model_Hotel::search_result_mobile($urlParam, $keyword, $starttime, $endtime);
        echo($data);
    }

    public function action_ajax_near_hotels()
    {
        $lat = floatval($_POST['lat']);
        $lng = floatval($_POST['lng']);
        $maxDistance = 3000;
        $sql = "select id,aid,webid,title,price,address,lng,lat,ROUND(6378.138*2*ASIN(SQRT(POW(SIN((" . $lat . "*PI()/180-lat*PI()/180)/2),2)+COS(" . $lat . "*PI()/180)*COS(lat*PI()/180)*POW(SIN((" . $lng . "*PI()/180-lng*PI()/180)/2),2))))  AS distance from sline_hotel where ROUND(6378.138*2*ASIN(SQRT(POW(SIN((" . $lat . "*PI()/180-lat*PI()/180)/2),2)+COS(" . $lat . "*PI()/180)*COS(lat*PI()/180)*POW(SIN((" . $lng . "*PI()/180-lng*PI()/180)/2),2))))<" . $maxDistance . " and  lat is not null and lng is not null order by distance asc";
        $list = DB::query(Database::SELECT, $sql)->execute()->as_array();
        foreach ($list as &$row) {
            $row['url'] = Common::get_web_url($row['webid']) . "/hotels/show_{$row['aid']}.html";
        }
        echo json_encode(array('status' => true, 'data' => $list));
    }

    /*
     * 获取房型进店和离店日期价格
     * */
    public function action_ajax_range_price()
    {
        $startdate = Arr::get($_GET, 'startdate');
        $enddate = Arr::get($_GET, 'leavedate');
        $suitid = intval(Arr::get($_GET, 'suitid'));
        $dingnum = intval(Arr::get($_GET, 'dingnum'));
        $price = Model_Hotel::suit_range_price($suitid, $startdate, $enddate, $dingnum);
        echo json_encode(array('price' => $price));
    }

    /**
     *
     * 获取套餐可预订的最小日期.
     *
     */
    public function action_ajax_mindate_book()
    {
        $suitid = Arr::get($_GET, 'suitid');
        $day = Model_Hotel::suit_mindate_book($suitid);
        echo json_encode(array(
            'startdate' => date('Y-m-d', $day),
            'enddate' => date('Y-m-d', strtotime("+1 day", $day))
        ));
    }

    /**
     *
     * 检测库存是否能够预订
     */
    public function action_ajax_check_storage()
    {
        $startdate = Arr::get($_POST, 'startdate');
        $enddate = Arr::get($_POST, 'enddate');
        $dingnum = intval(Arr::get($_POST, 'dingnum'));
        $suitid = intval(Arr::get($_POST, 'suitid'));
        $flag = Model_Hotel::check_suit_storage($suitid, $startdate, $enddate, $dingnum);
        echo json_encode(array('status' => $flag));
    }

    public function add_tourer($orderid, $arr, $memberid)
    {

        $tourname = $arr['tourname'];
        $tourcard = $arr['touridcard'];
        $cardtype = $arr['tourcardtype'];

        for ($i = 0; isset($tourname[$i]); $i++) {

            $ar = array(
                'orderid' => $orderid,
                'tourername' => $tourname[$i],
                'cardtype' => $cardtype[$i],
                'cardnumber' => $tourcard[$i],

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
}