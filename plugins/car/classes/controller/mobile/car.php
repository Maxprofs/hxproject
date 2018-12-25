<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Class Controller_Car
 * 租车控制器
 */
class Controller_Mobile_Car extends Stourweb_Controller
{
    private $_typeid = 3;   //产品类型
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
     * 租车首页
     */
    public function action_index()
    {
        $seoinfo = Model_Nav::get_channel_seo_mobile($this->_typeid);
        $this->assign('seoinfo', $seoinfo);
        $this->display('../mobile/car/index', 'car_index');
        //缓存内容
        $content = $this->response->body();
        Common::cache('set', $this->_cache_key, $content);
    }

    /**
     * 租车搜索页(搜索初始页)
     */
    public function action_search()
    {
        $this->display('../mobile/car/search');
    }

    /**
     * 租车列表
     */
    public function action_list()
    {
        $uri = $this->request->param('params');
        $uriArr = $this->_explode_url($uri);
        $destname = $uriArr['destPy'] != 'all' ? DB::select('kindname')->from('destinations')->where('pinyin', '=', $uriArr['destPy'])->execute()->get('kindname') : '目的地';
        //获取seo信息
        $seo = Model_Car::search_seo_mobile($uriArr['destPy']);
        $destid = $destPy != 'all' ? DB::select('id')->from('destinations')->where('pinyin', '=', $uriArr['destPy'])->execute()->get('id') : 0;

        $seo_params = array(
            'destpy' => $uriArr['destPy'],
            'carkindid' => $uriArr['kindid'],
            'attrid' => $uriArr['attrid'],
            'priceid' => $uriArr['priceid'],
            'p' => $uriArr['page'],
            'keyword' => $uriArr['keyword']
        );
        $search_title = Model_Car::gen_seotitle($seo_params);
        $this->assign('search_title', $search_title);
        $this->assign('seoinfo', $seo);
        $this->assign('destname', $destname);
        $this->assign('destid', $destid);
        $this->assign('destpy', $uriArr['destPy']);
        $this->assign('attrid', $uriArr['attrid']);
        $this->assign('priceid', intval($uriArr['priceid']));
        $this->assign('kindid', intval($uriArr['kindid']));
        $this->assign('sorttype', intval($uriArr['sorttype']));
        $this->assign('keyword', $uriArr['keyword']);
        $this->assign('page', intval($uriArr['page']));
        $this->display('../mobile/car/list', 'car_list');
        //缓存内容
        $content = $this->response->body();
        Common::cache('set', $this->_cache_key, $content);
    }

    /*
* 列表页筛选
*/
    public
    function action_searchnav()
    {

        $this->assign('typeid', $this->_typeid);
        $this->display('../mobile/car/searchnav');
    }

    /*
   * 选择目的地
   */
    public
    function action_ajax_get_next_dests()
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

    /**
     * ajax请求 加载更多
     */
    public function action_ajax_car_more()
    {
        $uri = $this->request->param('params');
        $uriArr = $this->_explode_url($uri);
        $data = Model_Car::search_result_mobile($uriArr);
        echo($data);
    }

    /**
     * 分隔URL参数
     * @return mixed
     */
    private function _explode_url($uri)
    {
        $params = explode('-', str_replace('/', '-', Common::remove_xss($uri)));
        $data['kindid'] = $data['sorttype'] = $data['attrid'] = $data['priceid'] = 0;
        $count = count($params);
        if ($count == 0) {
            exit;
        }
        switch ($count) {
            case 1:
                $data['status'] = $data['attrId'] = 0;
                list($data['destPy']) = $params;
                break;
            //关键字、属性
            case 5:
                list($data['destPy'], $data['kindid'], $data['sorttype'], $data['attrid'], $data['priceid']) = $params;
                break;
            //关键字、属性
            case 6:
                list($data['destPy'], $data['kindid'], $data['sorttype'], $data['attrid'], $data['priceid'], $data['page']) = $params;
                break;
            // 
               
        }
        //分页
        $data['page'] = empty($data['page']) ? 1 : $data['page'];
        //关键字
        $data['keyword'] = empty($_GET['keyword']) ? '' : $_GET['keyword'];
        return $data;
    }

    /**
     * 租车详情页
     */
    public function action_show()
    {
        $aid = intval($this->request->param('aid'));
        //子站内容显示
        if (isset($_GET['webid'])) {
            $GLOBALS['sys_webid'] = intval(Arr::get($_GET, 'webid'));
        }

        $info = DB::select()->from('car')->where('webid', '=', $GLOBALS['sys_webid'])->and_where('aid', '=', $aid)->execute()->current();

        if(empty($info))
        {
            Common::head_404();
        }

        //扩展字段信息
        $extend_info = DB::select()->from('car_extend_field')->where('productid', '=', $info['id'])->execute()->current();


        //点击率加一
        Product::update_click_rate($aid, $this->_typeid);

        $seoinfo = Product::seo($info);
        $info['piclist'] = Product::pic_list($info['piclist']);
        $info['commentnum'] = Model_Comment::get_comment_num($info['id'], $this->_typeid); //评论次数
        $info['satisfyscore'] = St_Functions::get_satisfy($this->_typeid, $info['id'], $info['satisfyscore'], array('suffix' => ''));//Model_Comment::get_score($info['id'], $this->_typeid, $info['satisfyscore'], $info['commentnum']);//满意度
        $info['sellnum'] = Model_Member_Order::get_sell_num($info['id'], $this->_typeid) + intval($info['bookcount']); //销售数量
        $info['carkindname'] = Model_Car_Kind::get_carkindname($info['carkindid']);
        $info['attrlist'] = Model_Car_attr::get_attr_list($info['attrid']);
        $info['price'] = Model_Car::get_minprice($info['aid'], array('info' => $info));
        //供应商
        $info['suppliers']=null;
        if($info['supplierlist'])
        {
            $info['suppliers'] = DB::query(1, "SELECT suppliername FROM `sline_supplier` WHERE id={$info['supplierlist']}")->execute()->current();
        }
        $this->assign('seoinfo', $seoinfo);
        $this->assign('info', $info);
        $this->assign('extendinfo', $extend_info);
        $this->display('../mobile/car/show', 'car_show');
        //缓存内容
        $content = $this->response->body();
        Common::cache('set', $this->_cache_key, $content);
    }

    /**
     * 租车预订页
     */
    public function action_book()
    {
        $userinfo = Model_Member_Login::check_login_info();
        $userinfo = Model_Member::get_member_byid($userinfo['mid']);
        //要求预订前必须登陆
        if (!empty($GLOBALS['cfg_login_order']) && empty($userinfo['mid'])) {
            $this->request->redirect(Common::get_main_host() . '/phone/member/login?redirecturl=' . urlencode(Common::get_current_url()));
        }
        $productid = intval($this->params['id']);
        $suitid = intval($_GET['suitid']);
        //$info = ORM::factory('car', $productid)->as_array();
        $info = DB::select()->from('car')->where('id', '=', $productid)->execute()->current();
        $info['price'] = Model_Car::get_minprice($info['aid'], array('info' => $info));
        $jifentprice_info = Model_Jifen_Price::get_used_jifentprice($info['jifentprice_id'], $this->_typeid);
        $this->assign('jifentprice_info', $jifentprice_info);
        $this->assign('info', $info);
        $this->assign('userinfo', $userinfo);
        $this->assign('suitid', $suitid);
        $member = Model_Member_Login::check_login_info();
        if (!empty($member)) {
            $this->assign('member', Model_Member::get_member_byid($member['mid']));
        }
        $this->display('../mobile/car/book');
    }

    /**
     * 获取租车开始和结束日期价格
     */
    public function action_ajax_range_price()
    {
        $startdate = Arr::get($_GET, 'startdate');
        $enddate = Arr::get($_GET, 'leavedate');
        $suitid = intval(Arr::get($_GET, 'suitid'));
        $dingnum = intval(Arr::get($_GET, 'dingnum'));
        $price = Model_Car::suit_range_price($suitid, $startdate, $enddate, $dingnum);
        echo json_encode(array('price' => $price));
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
        $ext = array();
        $startdate = $startdate ? $startdate : date('Y-m-d', $day);

        for ($i = 1; $i <= 24; $i++) {
            if ($month == 13) {
                $year = $year + 1;
                $month = 1;
            }
            $price_arr = Model_Car::get_month_price($year, $month, $suitid, $startdate);
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
        $html .= '<tr class="calendar-hd"><th>一</th><th>二</th><th>三</th><th>四</th><th>五</th><th>六</th><th>日</th></tr>';


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
                }
                else if (empty($price_info)) {
                    $html .= '<td><div class="item opt"><span class="date">' . $cur_day . '</span></div></td>';
                }
                else if (!empty($price_info)) {

                    $html .= '<td price="' . $price_info['price'] . '" number="' . $price_info['number'] . '"  date="' . $cur_date . '"  onclick="choose_day(this)">';
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

    /**
     * 获取套餐可预订的最小日期.
     */
    public function action_ajax_mindate_book()
    {
        $suitid = intval(Arr::get($_GET, 'suitid'));
        $day = Model_Car::suit_mindate_book($suitid);

        echo json_encode(array(
            'startdate' => date('Y-m-d', $day),
            'enddate' => date('Y-m-d', strtotime("+1 day", $day))
        ));
    }

    /**
     * 创建订单
     */
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
        //开始时间
        $startdate = Arr::get($_POST, 'startdate');
        //结束时间
        $leavedate = Arr::get($_POST, 'leavedate');
        //数量
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


        $info = DB::select()->from('car')->where('id', '=', $id)->execute()->current();
        $suitArr = DB::select()->from('car_suit')->where('id', '=', $suitid)->execute()->current();
        $suitArr['dingjin'] = Currency_Tool::price($suitArr['dingjin']);
        $priceArr = DB::select()->from('car_suit_price')->where('day', '=', strtotime($startdate))->and_where('suitid', '=', $suitid)->execute()->current();
        $priceArr['adultprice'] = Currency_Tool::price($priceArr['adultprice']);
        //检测库存
        $totalnum = $dingnum;
        //  $storage = intval($priceArr['number']);
        //  if ($storage != -1 && $storage < $totalnum)
        $storage_status = Model_Car::check_storage($id, $dingnum, $suitid, $startdate, $leavedate);

        if (!$storage_status) {
            Common::message(array('message' => __("error_no_storage"), 'jumpUrl' => $refer_url));
            exit;
        }
        //这里补充一个当为二次确认时,修改订单为未处理状态.
        if ($suitArr['paytype'] == '3') {
            $info['status'] = 0;
        }
        else {
            $info['status'] = 1;
        }
        $info['name'] = $info['title'] . "({$suitArr['suitname']})";
        $info['paytype'] = $suitArr['paytype'];
        $info['dingjin'] = doubleval($suitArr['dingjin']);
        $info['jifentprice'] = intval($suitArr['jifentprice']);
        $info['jifenbook'] = intval($suitArr['jifenbook']);
        $info['jifencomment'] = intval($suitArr['jifencomment']);

        //使用天数计算
        $date1 = new DateTime($startdate);
        $date2 = new DateTime($leavedate);
        $interval = date_diff($date1, $date2);
        $days = $interval->format('%a');

        $priceArr['adultprice'] = Model_Car::suit_range_price($suitid, $startdate, $leavedate, 1);;
        $info['dingjin'] = $info['dingjin'] * (intval($days) + 1);
        $info['ourprice'] = doubleval($priceArr['adultprice']);
        $info['childprice'] = 0;
        $info['usedate'] = $startdate;
        $info['departdate'] = $leavedate;
        $ordersn = Product::get_ordersn('03');

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
            'needjifen' => $needJifen
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
        if (St_Product::add_order($arr, 'Model_Car', $arr)) {
            // $orderInfo = Model_Member_Order::get_order_by_ordersn($ordersn);//var_dump($orderInfo);
            St_Product::delete_token();
            Common::session('_platform', 'mobile');
            $html = Common::payment_from(array('ordersn' => $ordersn));
            if ($html) {
                echo $html;
            }

        }
    }

    /*
   * 优惠信息
   */
    public
    function action_discount()
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
            $this->display('../mobile/car/discount');
        }


    }

    /**
     *
     * 检测库存是否能够预订
     */
    public function action_ajax_check_storage()
    {
        $startdate = Arr::get($_POST, 'startdate');
        $enddate = Arr::get($_POST, 'enddate');
        $dingnum = Arr::get($_POST, 'dingnum');
        $suitid = Arr::get($_POST, 'suitid');
        $flag = Model_Car::check_storage(0, $dingnum, $suitid, $startdate, $enddate);
        echo json_encode(array('status' => $flag));
    }
}