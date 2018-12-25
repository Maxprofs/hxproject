<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Mobile_Ship extends Stourweb_Controller
{

    private $_typeid = 104;   //产品类型
    private $_cache_key = '';

    function before()
    {

        parent::before();
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
     * @function  邮轮首页
     */
    public function action_index()
    {
        $seoinfo = Model_Nav::get_channel_seo_mobile($this->_typeid);
        $this->assign('seoinfo', $seoinfo);
        $this->display('../mobile/ship/index', 'ship_index');
        //缓存内容
        $content = $this->response->body();
        Common::cache('set', $this->_cache_key, $content);
    }


    /**
     * @function 航线列表
     */
    public function action_list()
    {

        //参数值获取
        $destPy = $this->request->param('destpy');
        $dayId = intval($this->request->param('dayid'));
        $priceId = intval($this->request->param('priceid'));
        $sortType = intval($this->request->param('sorttype'));
        $startcityId = intval($this->request->param('startcityid'));
        $shipid = intval($this->request->param('shipid'));
        $attrId = $this->request->param('attrid');
        $p = intval($this->request->param('p'));
        $attrId = !empty($attrId) ? $attrId : 0;
        $destPy = $destPy ? $destPy : 'all';
        $keyword = Common::remove_xss(Arr::get($_GET, 'keyword'));
        $destId = $destPy == 'all' ? 0 : DB::select('id')->from('destinations')->where('pinyin', '=', $destPy)->execute()->get('id');

        $destId = $destId ? $destId : 0;
        $params = array(
            'destpy' => $destPy,
            'dayid' => $dayId,
            'priceid' => $priceId,
            'sorttype' => $sortType,
            'startcityid' => $startcityId,
            'shipid' => $shipid,
            'attrid' => $attrId,
            'page' => $p,
            'destid' => $destId,
            'keyword' => $keyword
        );

        $search_title = Model_Ship_Line::gen_seotitle($params);


        $this->assign('params', $params);
        $this->assign('attr_arr', explode('_', $attrId));
        //获取seo信息

        $seo = Model_Ship::search_seo_mobile($destPy);
        $this->assign('seoinfo', $seo);
        $this->assign('search_title', $search_title);
        $this->display('../mobile/ship/list', 'ship_list');
        //缓存内容
        $content = $this->response->body();
        Common::cache('set', $this->_cache_key, $content);
    }


    /**
     * @function 航线详情
     */
    public function action_show()
    {
        $aid = intval($this->request->param('aid'));

        $info = ORM::factory('ship_line')->where('aid', '=', $aid)->and_where('webid', '=', $GLOBALS['sys_webid'])->find()->as_array();

        if(empty($info['id']))
        {
            Common::head_404();
        }

        //seo
        $seoInfo = Product::seo($info);
        //产品图片
        $info['piclist'] = Product::pic_list($info['piclist']);
        //属性列表
        $info['attrlist'] = Model_Ship_Line::line_attr($info['attrid']);
        //最低价
        $info['priceinfo'] = Model_Ship_Line::get_minprice($info['id'], array('info', $info), 1);

        //点评数
        $info['commentnum'] = Model_Comment::get_comment_num($info['id'], $this->_typeid);
        //销售数量
        $info['sellnum'] = Model_Member_Order::get_sell_num($info['id'], $this->_typeid) + intval($info['bookcount']);
        //产品编号
        $info['series'] = St_Product::product_series($info['id'], $this->_typeid);
        //产品图标
        $info['iconlist'] = Product::get_ico_list($info['iconlist']);
        //供应商
        $info['suppliers']=null;
        if($info['supplierlist'])
        {
            $info['suppliers'] = DB::query(1, "SELECT suppliername FROM `sline_supplier` WHERE id={$info['supplierlist']}")->execute()->current();
        }
        //最新航线

        $info['lastest_line'] = Model_Ship_Line::get_starttime($info['id']);


        $info['schedule_name'] = DB::select('title')->from('ship_schedule')->where('id', '=', $info['scheduleid'])->execute()->get('title');
        $info['satisfyscore'] = St_Functions::get_satisfy($this->_typeid, $info['id'], $info['satisfyscore']);

        $info['jifentprice_info'] = Model_Jifen_Price::get_used_jifentprice($info['jifentprice_id'], $this->_typeid);
        $info['jifenbook_info'] = Model_Jifen::get_used_jifenbook($info['jifenbook_id'], $this->_typeid);
        $info['jifencomment_info'] = Model_Jifen::get_used_jifencomment($this->_typeid);
        //目的地上级
        if ($info['finaldestid'] > 0) {
            $predest = Model_Ship::get_predest($info['finaldestid']);
            $this->assign('predest', $predest);

            $finaldest_name = DB::select('kindname')->from('destinations')->where('id', '=', $info['finaldestid'])->execute()->get('kindname');
            $info['finaldest_name'] = $finaldest_name;
        }
        //支付方式
        $paytypeArr = explode(',', $GLOBALS['cfg_pay_type']);

        //扩展字段信息
        $extend_info = ORM::factory('ship_line_extend_field')
            ->where("productid=" . $info['id'])
            ->find()
            ->as_array();

        //优惠券
        if (St_Functions::is_normal_app_install('coupon')) {
            $coupon = Model_Coupon::get_mobile_coupon_info($this->_typeid, $info['id']);
            $this->assign('coupon', $coupon);
        }

        //套餐
        $suitids = Model_Ship::get_useful_suitids($info['id']);


        $this->assign('seoinfo', $seoInfo);
        $this->assign('info', $info);
        $this->assign('paytypeArr', $paytypeArr);
        $this->assign('extendinfo', $extend_info);
        $this->display('../mobile/ship/show', 'ship_show');
        //缓存内容
        $content = $this->response->body();
        Common::cache('set', $this->_cache_key, $content);


    }


    /**
     * @function 预定
     */
    public function action_book()
    {
        $userinfo = Model_Member_Login::check_login_info();
        $userinfo = Model_Member::get_member_byid($userinfo['mid']);
        //要求预订前必须登陆
        if (!empty($GLOBALS['cfg_login_order']) && empty($userinfo['mid'])) {
            $cancel_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $this->cmsurl;
            $this->request->redirect(Common::get_main_host() . '/phone/member/login?redirecturl=' . urlencode(Common::get_current_url()).'&cancelurl='.urlencode($cancel_url));
        }
        $this->assign('userinfo', $userinfo);
        if (!empty($userinfo)) {
            $this->assign('member', Model_Member::get_member_byid($userinfo['mid']));
        }
        $productId = intval(Arr::get($_GET, 'lineid'));
        $suitid = Arr::get($_GET, 'suitid');
        $number = Arr::get($_GET, 'number');
        $dateid = intval($_GET['dateid']);
        if (!$productId || !$suitid || !$number || !$dateid) {
            die('不合法的请求');
        }
        //产品信息
        $info = ORM::factory('ship_line', $productId)->as_array();
        //套餐按出发日期价格
        if (empty($dateid)) {
            $starttime = Model_Ship_Line::get_starttime($productId);
            $dateid = DB::select('id')->from('ship_schedule_date')->where('starttime', '=', $starttime)->and_where('scheduleid', '=', $info['scheduleid'])->execute()->get('id');
        }
        $suitid_arr = explode('_', $suitid);
        $number_arr = explode('_', $number);
        $suit_arr = array();
        $totalprice = 0;
        $total_num = 0;
        $total_room = 0;
        foreach ($suitid_arr as $k => $v) {
            if (empty($v))
                continue;
            $suit_info = Model_Ship_Line::get_suit_info($productId, $v, $dateid);
            if (empty($suit_info))
                continue;
            $book_peoplenum = intval($number_arr[$k])<=0?0:intval($number_arr[$k]);
            $room_num = ceil($book_peoplenum / $suit_info['peoplenum']);
            $total_room += $room_num;
            if ($room_num > $suit_info['number'] && $suit_info['number'] != -1) {
                die('库存不足!');
            }
            $suit_info['book_peoplenum'] = $book_peoplenum;
            $suit_info['book_roomnum'] = $room_num;
            $total_num += $book_peoplenum;
            $suit_info['kindname'] = DB::select('title')->from('ship_room_kind')->where('id', '=', $suit_info['kindid'])->execute()->get('title');
            $suit_arr[] = $suit_info;
            $totalprice += $suit_info['price'] * $room_num;
        }

        $info['url'] = Common::get_web_url($info['webid']) . "/ship/show_{$info['aid']}.html";
        $info['series'] = St_Product::product_series($info['id'], '104');
        $info['dateid'] = $dateid;
        $starttime = DB::select('starttime')->from('ship_schedule_date')->where('id', '=', $dateid)->execute()->get('starttime');
        $info['startdate'] = date('Y-m-d', $starttime);
        $totalnum = array();
        for ($num = 1; $num <= $total_num; $num++) {
            $totalnum[] = $num;
        }

        //优惠券
        if (St_Functions::is_normal_app_install('coupon')) {
            $couponlist = Model_Coupon::get_pro_coupon($this->_typeid, $productId);
            if ($couponlist) {
                $this->assign('couponlist', $couponlist);
            }
        }
        //积分抵现所需积分
        $jifentprice_info = Model_Jifen_Price::get_used_jifentprice($info['jifentprice_id'], $this->_typeid);
        $code = md5(time());
        Common::session('code', $code);
        $this->assign('dateid', Arr::get($_GET, 'dateid'));
        $this->assign('suitid', Arr::get($_GET, 'suitid'));
        $this->assign('number', Arr::get($_GET, 'number'));
        $this->assign('totalprice', $totalprice);
        $this->assign('totalnum', $totalnum);
        $this->assign('total_room', $total_room);
        $this->assign('starttime', Arr::get($_GET, 'start_time'));
        $this->assign('info', $info);
        $this->assign('suitlist', $suit_arr);
        $this->assign('jifentprice_info', $jifentprice_info);
        $this->assign('frmcode', $code);

        $this->display('../mobile/ship/book');
    }


    public function action_create()
    {
        St_Product::token_check($_POST) or Common::order_status();
        $refer_url = $_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : $this->cmsurl;
        $frmCode = Arr::get($_POST, 'frmcode');
        //安全校验码验证
        $orgCode = Common::session('code');
        if ($orgCode != $frmCode || empty($frmCode)) {
            exit();
        }

        //会员信息
        $userInfo = Model_Member_Login::check_login_info();
        $memberId = $userInfo ? $userInfo['mid'] : 0;//会员id
        $userInfo = Model_Member::get_member_byid($userInfo['mid']);
        $webid = intval(Arr::get($_POST, 'webid'));//网站id
        $lineId = intval(Arr::get($_POST, 'lineid'));//线路id
        $dateid = Arr::get($_POST, 'dateid');//出发日期
        $linkMan = Arr::get($_POST, 'linkman');//联系人姓名
        $linkTel = Arr::get($_POST, 'linktel');//联系人电话
        $linkEmail = Arr::get($_POST, 'linkemail');//联系人邮箱

        $linkTel = empty($linkTel) && !empty($userInfo) ? $userInfo['mobile'] : $linkTel;
        $linkEmail = empty($linkEmail) && !empty($userInfo) ? $userInfo['email'] : $linkEmail;

        $needJifen = intval($_POST['jifentprice_info']);
        $remark = Arr::get($_POST, 'remark');//订单备注
        $roomnum_arr = explode('_', Arr::get($_POST, 'suitid'));
        $peoplenum_arr = explode('_', Arr::get($_POST, 'number'));;
        $paytype = 1;
        $dingjin = 0;
        $curtime = time();

        $suit_arr = array();
        $totalprice = 0;
        $date_info = DB::select()->from('ship_schedule_date')->where('id', '=', $dateid)->execute()->current();

        $startdate = date('Y-m-d', $date_info['starttime']);
        $enddate = date('Y-m-d', $date_info['endtime']);

        foreach ($roomnum_arr as $k => $v) {
            if (empty($v))
                continue;
            $suit_info = Model_Ship_Line::get_suit_info($lineId, $v, $dateid);

            $v = intval($v);
            $room_num = ceil($peoplenum_arr[$k] / $suit_info['peoplenum']);
            $suit_info['dingnum'] = $room_num;
            $suit_info['peoplenum'] = $peoplenum_arr[$k];
            $suit_info['number'] = intval($suit_info['number']);
            if ($suit_info['number'] != -1 && $suit_info['dingnum'] > $suit_info['number']) {
                header("Content-type:text/html;charset=utf-8");
                exit("房间" . $suit_info['suitname'] . '库存不足!');
            }
            $totalprice += $suit_info['price'] * intval($suit_info['dingnum']);
            $suit_arr[] = $suit_info;
        }

        $info = ORM::factory('ship_line', $lineId)->as_array();

        //积分抵现.
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


        //游客信息读取
        $t_name = Arr::get($_POST, 't_name');
        $t_cardtype = Arr::get($_POST, 't_cardtype');
        $t_cardno = Arr::get($_POST, 't_cardno');
        $tourer = array();
        $totalNum = 0;
        for ($i = 0; $i < count($t_name); $i++) {
            $tourer[] = array(
                'name' => $t_name[$i],
                'cardtype' => $t_cardtype[$i],
                'cardno' => $t_cardno[$i]
            );
        }


        $orderSn = Product::get_ordersn('104');

        $status = 1;
        $arr = array(
            'ordersn' => $orderSn,
            'webid' => $webid,
            'typeid' => $this->_typeid,
            'productautoid' => $info['id'],
            'productaid' => $info['aid'],
            'productname' => $info['title'],
            'price' => $totalprice,
            'childprice' => 0,
            'oldprice' => 0,
            'usedate' => $startdate,
            'dingnum' => 1,
            'childnum' => 0,
            'oldnum' => 0,
            'linkman' => $linkMan,
            'linktel' => $linkTel,
            'linkemail' => $linkEmail,
            'jifentprice' => $jifentprice,
            'jifenbook' => $info['jifenbook_id'],
            'jifencomment' => $jifencomment,
            'addtime' => $curtime,
            'memberid' => $memberId,
            'dingjin' => $dingjin,
            'paytype' => $paytype,
            'suitid' => '',
            'departdate' => $enddate,
            'usejifen' => $useJifen,
            'needjifen' => $needJifen,
            'status' => $status,
            'remark' => $remark
        );

        /*--------------------------------------------------------------优惠券信息------------------------------------------------------------*/
        //优惠券判断
        $croleid = intval(Arr::get($_POST, 'couponid'));
        if ($croleid) {
            $cid = DB::select('cid')->from('member_coupon')->where("id=$croleid")->execute()->current();
            $totalprice = Model_Coupon::get_order_totalprice($arr);
            $ischeck = Model_Coupon::check_samount($croleid, $totalprice, $this->_typeid, $info['id'], $startdate);
            if ($ischeck['status'] == 1) {
                Model_Coupon::add_coupon_order($cid, $orderSn, $totalprice, $ischeck, $croleid); //添加订单优惠券信息
            }
            else {
                exit('coupon  verification failed!');//优惠券不满足条件
            }
        }
        /*-----------------------------------------------------------------优惠券信息--------------------------------------*/


        //添加订单
        if (St_Product::add_order($arr, 'Model_Ship_Line', array_merge($arr, array('child_list' => $suit_arr))))//Model_Ship_Line::add_order($arr))
        {
            St_Product::delete_token();
            $orderInfo = Model_Member_Order::get_order_by_ordersn($orderSn);
            foreach ($suit_arr as $row) {
                $child_model = ORM::factory('member_order_child');
                $child_model->pid = $orderInfo['id'];
                $child_model->suitid = $row['suitid'];
                $child_model->price = $row['price'];
                $child_model->title = $row['suitname'];
                $child_model->dingnum = $row['dingnum'];
                $child_model->peoplenum = $row['peoplenum'];
                $child_model->status = $status;
                $child_model->addtime = $curtime;
                $child_model->ordersn = $this->_get_sub_ordersn($this->_typeid);
                $child_model->save();
            }
            $tourname = $_POST['tourname'];
            $cardtype = $_POST['cardtype'];
            $touridcard = $_POST['touridcard'];
            $toursex = $_POST['toursex'];
            $tourmobile = $_POST['tourmobile'];
            $tour_arr = array();
            foreach ($tourname as $k => $val) {
                $t['name'] = Common::remove_xss($val);
                $t['cardtype'] = Common::remove_xss($cardtype[$k]);
                $t['cardno'] = Common::remove_xss($touridcard[$k]);
                $t['sex'] = Common::remove_xss($toursex[$k]);
                $t['mobile'] = Common::remove_xss($tourmobile[$k]);
                $tour_arr[] = Common::remove_xss($t);
            }
            $userInfo = Model_Member_Login::check_login_info();
            Model_Member_Order::add_tourer_pc($orderInfo['id'], $tour_arr, $userInfo['mid']);
            //如果是立即支付则执行支付操作,否则跳转到产品详情页面

            $html = Common::payment_from(array('ordersn' => $orderSn));
            if ($html) {
                echo $html;
            }
        }

    }


    public function action_order_show()
    {

        $id = intval(Arr::get($_GET, 'id'));
        $row = Model_Member_Order::get_order_detail($id, $this->member['mid']);
        if (empty($row)) {
            $this->request->redirect(Kohana::$base_url . 'pub/404');
        }
        $info = Model_Member_Order::order_info($row['ordersn'], $this->_mid);
        $sublist = DB::select()->from('member_order_child')->where('pid', '=', $info['id'])->execute()->as_array();
        $tourlist = DB::select()->from('member_order_tourer')->where('orderid', '=', $info['id'])->execute()->as_array();
        $info['url'] = $this->ger_product_url($info['typeid'], $info['productautoid']);
        $info['payurl'] = Common::get_main_host() . "/payment/?ordersn={$row['ordersn']}";
        //封面图
        $model = ORM::factory('model', $info['typeid']);
        $table = $model->maintable;
        if ($table) {
            $productinfo = ORM::factory($table, $info['productautoid'])->as_array();
            $info['litpic'] = Common::img($productinfo['litpic'], 194, 132);
        }

        $this->assign('info', $info);
        $this->assign('sublist', $sublist);
        $this->assign('tourlist', $tourlist);
        $this->assign('member', $this->member);
        $this->display('../mobile/ship/order_show');

    }


    private function ger_product_url($typeid, $id)
    {
        //定义有手机端的typeid数组
        $mobile_ids = array(1, 2, 3, 5, 8, 11, 13, 105, 104);
        $model = ORM::factory('model', $typeid);
        $table = $model->maintable;
        $pinyin = $model->pinyin;

        if ($table != 'model_archive' && !in_array($typeid, $mobile_ids)) {
            return '';
        }
        if (!class_exists('Model_' . $table)) {
            return '';
        }
        $info = ORM::factory($table, $id)->as_array();
        $py = empty($model->correct) ? $pinyin : $model->correct;
        $url = St_Functions::get_web_url($info['webid']) . "/{$py}/show_{$info['aid']}.html";
        return $url;
    }


    /*
    * 生成子订单编号
    */
    private function _get_sub_ordersn($kind)
    {
        /* 选择一个随机的方案 */
        return 'SUB' . $kind . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99));
    }


    public function action_ajax_dialog_calendar()
    {

        $year = intval(Arr::get($_POST, 'year'));
        $month = intval(Arr::get($_POST, 'month'));
        $lineid = intval(Arr::get($_POST, 'lineid'));
        $containdiv = Arr::get($_POST, 'containdiv');
        $html = '';
        for ($k = 1; $k < 13; $k++) {
            if ($k > 1) {
                $month++;
                if ($month > 12) {
                    $month = 1;
                    $year++;

                }
            }

            $html .= $this->dialog_calendar($year, $month, $lineid, $containdiv);

        }
        echo $html;

    }


    /**
     * @function 获取日历
     */
    public function dialog_calendar($year, $month, $lineid, $containdiv)
    {

        $nowDate = new DateTime();
        $year = !empty($year) ? $year : $nowDate->format('Y');
        $month = !empty($month) ? $month : $nowDate->format('m');
        $out = '';
        $info = DB::select('islinebefore', 'linebefore')->from('ship_line')->where('id', '=', $lineid)->execute()->current();
        $ext['islinebefore'] = $info['islinebefore'];
        $ext['linebefore'] = $info['linebefore'];
        if ($ext['islinebefore']) {
            $startdate = date('Y-m-d', strtotime("+{$ext['linebefore']} days", time()));
        }
        $priceArr = Model_Ship_Line::get_suit_price($year, $month, $lineid, $startdate);
        $out .= self::calender($year, $month, $priceArr, 0, $containdiv);
        echo $out;
    }


    public static function calender($year = '', $month = '', $priceArr = NULL, $suitid, $contain = '')
    {

        date_default_timezone_set('Asia/Shanghai');
        $year = abs(intval($year));
        $month = abs(intval($month));
        $tmonth = $month < 10 ? "0" . $month : $month;
        $defaultYM = $year . '-' . $tmonth;
        $nowDate = new DateTime();
        if ($year <= 0) {
            $year = $nowDate->format('Y');
        }
        if ($month <= 0 or $month > 12) {
            $month = $nowDate->format('m');
        }
        //上一年
        $prevYear = $year - 1;
        //上一月
        $mpYear = $year;
        $preMonth = $month - 1;
        if ($preMonth <= 0) {
            $preMonth = 12;
            $mpYear = $prevYear;
        }
        $preMonth = $preMonth < 10 ? '0' . $preMonth : $preMonth;
        //下一年
        $nextYear = $year + 1;
        //下一月
        $mnYear = $year;
        $nextMonth = $month + 1;
        if ($nextMonth > 12) {
            $nextMonth = 1;
            $mnYear = $nextYear;
        }
        $nextMonth = $nextMonth < 10 ? '0' . $nextMonth : $nextMonth;
        //日历头
        $html = '<div class="calendar-wrap">
<h3 class="calendar-date">
                        <strong class="calendar-cur"  time-data="' . $mnYear . '-' . $nextMonth . '">' . $year . '年' . $month . '月</strong>
                    </h3>
		<table width="100%">
			<tr class="calendar-hd">
				<th >一</th>
				<th >二</th>
				<th >三</th>
				<th >四</th>
				<th >五</th>
				<th >六</th>
				<th >日</th>
			</tr>
';

        $currentDay = $nowDate->format('Y-m-j');

        //当月最后一天
        $creatDate = new DateTime("$year-$nextMonth-0");
        $lastday = $creatDate->format('j');
        $creatDate = NULL;

        //循环输出天数
        $day = 1;
        $line = '';
        while ($day <= $lastday) {
            $cday = $year . '-' . $month . '-' . $day;

            //当前星期几
            $creatDate = new DateTime("$year-$month-$day");
            $nowWeek = $creatDate->format('N');
            $creatDate = NULL;

            if ($day == 1) {
                $line = '<tr class="calendar-bd">';
                $line .= str_repeat('<td><div class="item"></div></td>', $nowWeek - 1);
            }
            //判断当前的日期是否小于今天
            $defaultmktime = mktime(1, 1, 1, $month, $day, $year);
            $currentmktime = mktime(1, 1, 1, date("m"), date("j"), date("Y"));
            //echo '<hr>';
            $tday = ($day < 10) ? '0' . $day : $day;
            $cdaydate = $defaultYM . '-' . $tday;
            $cdayme = strtotime($cdaydate);
            //单价
            $dayPrice = $priceArr[$cdayme]['minprice'];

            //库存
            $priceArr[$cdayme]['number'] = $priceArr[$cdayme]['number'] < -1 ? 0 : $priceArr[$cdayme]['number'];
            $number = $priceArr[$cdayme]['number'] != -1 ? $priceArr[$cdayme]['number'] : '不限';
            $item_style = "item";
            if ($number == '不限') {
                $item_style = "item opt";
                $numstr = '<span class="stock">库存充足</span>';
            }
            elseif ($number > 0) {
                $item_style = "item opt";
                $numstr = '<span class="stock">库存' . $number . '</span>';
            }
            else {

                $item_style = "item end";
                $numstr = '<span class="stock">已售罄</span>';
            }
            //判断当前的日期是否小于今天
            $tdcontent = '<span class="date">' . $day . '</span>';
            if ($defaultmktime >= $currentmktime) {
                if ($dayPrice) {
                    $dayPriceStrs = Currency_Tool::symbol() . $dayPrice . '<br>';
                    $tdcontent .= '<span class="price">' . $dayPriceStrs . '</span>';
                    if ($numstr) {
                        $tdcontent .= $numstr;
                    }

                    if ($number !== 0) {
                        $onclick = 'onclick="choose_day(\'' . $cday . '\',\'' . $contain . '\')"';
                    }
                }
                else {
                    $onclick = '';
                }
                if ($onclick == '') {

                    $line .= "<td><div class='$item_style'>" . $tdcontent . "</div></td>";
                }
                else {
                    $line .= "<td $onclick ><div class='$item_style'>" . $tdcontent . "</div></td>";
                }
            }
            else {
                $line .= "<td><div class='item'>" . $tdcontent . "</div></td>";
            }


            //一周结束
            if ($nowWeek == 7) {
                $line .= '</tr>';
                $html .= $line;
                $line = '<tr class="calendar-bd">';
            }

            //全月结束
            if ($day == $lastday) {
                if ($nowWeek != 7) {
                    $line .= str_repeat('<td><div class="item"></div></td>', 7 - $nowWeek);
                }
                $line .= '</tr>';
                $html .= $line;

                break;
            }

            $day++;
        }

        $html .= '
		</table>
</div>
';

        return $html;

    }


    /**
     * @function 加载舱房信息
     */
    public function action_ajax_load_data()
    {
        $lineid = intval(Arr::get($_POST, 'lineid'));
        $starttime = strtotime(Arr::get($_POST, 'starttime'));
        $data = Model_Ship::get_ship_suite($lineid, $starttime);
        if ($data['suit']) {
            foreach ($data['suit'] as &$suit) {
                $suit['room']['litpic'] = Common::img($suit['room']['litpic'], 162, 162);
                $suit['room']['content'] = Common::cutstr_html($suit['room']['content'], 20);

            }


        }
        echo json_encode($data);
    }


    /**
     * @function  加载更多航线
     */
    public function action_ajax_line_more()
    {

        $pagesize = 12;
        //参数值获取
        $destPy = $this->request->param('destpy');
        $dayId = intval($this->request->param('dayid'));
        $priceId = intval($this->request->param('priceid'));
        $sortType = intval($this->request->param('sorttype'));
        $startcityId = intval($this->request->param('startcityid'));
        $shipid = intval($this->request->param('shipid'));
        $attrId = $this->request->param('attrid');
        $p = intval($this->request->param('p'));
        $p = $p < 1 ? 1 : $p;
        $attrId = !empty($attrId) ? $attrId : 0;
        $destPy = $destPy ? $destPy : 'all';
        $keyword = Common::remove_xss(Arr::get($_GET, 'keyword'));
        $params = array(
            'destpy' => $destPy,
            'dayid' => $dayId,
            'priceid' => $priceId,
            'sorttype' => $sortType,
            'startcityid' => $startcityId,
            'shipid' => $shipid,
            'attrid' => $attrId,
            'page' => $p,
            'keyword' => $keyword
        );

        $out = Model_Ship_Line::search_result($params, $keyword, $p, $pagesize);
        $totalpage = ceil($out['total'] / $pagesize);
        $list = array();
        foreach ($out['list'] as $l) {
            if ($l['finaldestid']) {
                $l['finaldest_name'] = DB::select('kindname')->from('destinations')->where("id ={$l['finaldestid']}")->execute()->get('kindname');
            }
            if ($l['starttime']) {
                $l['starttime'] = date('m月d日', $l['starttime']);
            }
            $l['litpic'] = Common::img($l['litpic'], 220, 150);
            $l['title'] = St_String::cut_html_str($l['title'], 30, '...');

            $list[] = $l;
        }
        $outpage = $totalpage > $p ? $p : -1;
        echo json_encode(array('list' => $list, 'page' => $outpage));
    }


    /**
     * 获取目的地相关项目
     * @param $destid
     * @param null $params
     */
    public function action_ajax_get_dest_rel()
    {
        $destid = intval(Arr::get($_POST, 'destid'));
        $rtn = array();
        $typeid = $this->_typeid;
        $destid = $destid ? $destid : 0;
        $sub_dest_list = ORM::factory('destinations')
            ->where(" FIND_IN_SET($typeid,opentypeids) ")
            ->where(" and pid='$destid' AND isopen=1")->get_all();//下级目的地
        //判断是否存在下级目的地
        foreach ($sub_dest_list as &$v) {
            $sub = DB::select(DB::expr('count(1) num'))->from('destinations')
                ->where(" FIND_IN_SET($typeid,opentypeids) ")
                ->where(" and pid='{$v['id']}' AND isopen=1")->execute()->get('num', 0);//下级目的地
            $v['has_sub'] = $sub > 0 ? true : false;
        }
        //当前目的地
        $current_dest = DB::select()->from('destinations')->where('id', '=', $destid)->execute()->current();
        if ($current_dest) {
            //当前目的地存在 //上级目的地
            $parent_dest = DB::select()->from('destinations')->where('id', '=', $current_dest['pid'])->execute()->current();
            if (empty($parent_dest)) {
                $parent_dest['id'] = 0;
                $parent_dest['pinyin'] = 'all';
                $parent_dest['kindname'] = '目的地';
            }
        }
        else {
            //当前目的地不存在
            $current_dest['id'] = 0;
            $current_dest['pinyin'] = 'all';
            $current_dest['kindname'] = '目的地';
        }
        $rtn['sub_list'] = $sub_dest_list;
        $rtn['current'] = $current_dest;
        $rtn['parent'] = $parent_dest;
        echo json_encode($rtn);
    }


    /**
     * @function 邮轮详情
     */
    public function action_cruise()
    {
        $id = $this->request->param('aid');
        $info = ORM::factory('ship', $id)->as_array();

        if (!$info['id']) {
            $this->request->redirect('error/404');
        }
        //seo
        $seoInfo = Product::seo($info);
        //产品图片
        $info['piclist'] = Product::pic_list($info['piclist']);
        $info['supplier'] = DB::select()->from('supplier')->where('id', '=', $info['supplierlist'])->execute()->current();
        $this->assign('seoinfo', $seoInfo);
        $this->assign('info', $info);
        $this->display('../mobile/ship/cruise', 'ship_cruise');
        //缓存内容
        $content = $this->response->body();
        Common::cache('set', $this->_cache_key, $content);
    }


    /**
     * @function　舱房信息
     */
    public function action_roomlist()
    {
        $id = $this->request->param('aid');
        $info = ORM::factory('ship', $id)->as_array();
        if (!$info['id']) {
            $this->request->redirect('error/404');
        }
        //seo
        $seoInfo = Product::seo($info);
        $this->assign('seoinfo', $seoInfo);
        $this->assign('info', $info);
        $this->display('../mobile/ship/cruise/roomlist');
        //缓存内容
        $content = $this->response->body();
        Common::cache('set', $this->_cache_key, $content);

    }


    /**
     * @function  其他设施详情
     */
    public function action_facility()
    {
        $id = intval($this->params['aid']);
        $kindid = intval($this->params['kindid']);

        if (!$id || !$kindid) {
            $this->request->redirect('error/404');
        }
        $info = ORM::factory('ship', $id)->as_array();
        if (!$info['id']) {
            $this->request->redirect('error/404');
        }
        //seo
        $seoInfo = Product::seo($info);
        $this->assign('seoinfo', $seoInfo);
        $this->assign('kindid', $kindid);
        $this->assign('info', $info);
        $this->display('../mobile/ship/cruise/facility');
        //缓存内容
        $content = $this->response->body();
        Common::cache('set', $this->_cache_key, $content);
    }


}