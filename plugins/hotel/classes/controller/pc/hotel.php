<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Pc_Hotel extends Stourweb_Controller
{
    /*
     * 酒店总控制器
     * */

    private $_typeid = 2;
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
        $channelname = Model_Nav::get_channel_name($this->_typeid);
        $this->assign('typeid', $this->_typeid);
        $this->assign('channelname', $channelname);

    }

    //首页
    public function action_index()
    {
        $seoinfo = Model_Nav::get_channel_seo($this->_typeid);
        $this->assign('seoinfo', $seoinfo);
        $templet = Product::get_use_templet('hotel_index');
        $templet = $templet ? $templet : 'hotel/index';
        $this->display($templet);
        //缓存内容
        $content = $this->response->body();
        Common::cache('set', $this->_cache_key, $content);
    }

    //详细页
    public function action_show()
    {

        $id = intval($this->request->param('aid'));
        //详情
        $info = Model_Hotel::detail($id);
        if (!$info) {
            $this->request->redirect('error/404');
        }
        //点击率加一
        Product::update_click_rate($info['aid'], $this->_typeid);
        //seo
        $seoInfo = Product::seo($info);
        //产品图片
        $info['piclist'] = Product::pic_list($info['piclist']);
        //属性列表
        $info['attrlist'] = Model_Hotel::hotel_attr($info['attrid']);
        //最低价
        $info['price'] = Model_Hotel::get_minprice($info['id'], array('info' => $info));
        //点评数
        $info['commentnum'] = Model_Comment::get_comment_num($info['id'], $this->_typeid);
        //销售数量
        $info['sellnum'] = Model_Member_Order::get_sell_num($info['id'], $this->_typeid) + intval($info['bookcount']);
        //产品编号
        $info['series'] = St_Product::product_series($info['id'], 2);
        //产品图标
        $info['iconlist'] = Product::get_ico_list($info['iconlist']);
        //星级
        $info['hotelrank'] = DB::select('hotelrank')->from('hotel_rank')->where('id', '=', $info['hotelrankid'])->execute()->get('hotelrank');
        $info['satisfyscore'] = St_Functions::get_satisfy($this->_typeid, $info['id'], $info['satisfyscore'], array('suffix' => ''));

        $info['jifentprice_info'] = Model_Jifen_Price::get_used_jifentprice($info['jifentprice_id'], $this->_typeid);
        $info['jifenbook_info'] = Model_Jifen::get_used_jifenbook($info['jifenbook_id'], $this->_typeid);
        $info['jifencomment_info'] = Model_Jifen::get_used_jifencomment($this->_typeid);
        if(Model_Supplier::display_is_open()&&$info['supplierlist'])
        {
            $info['suppliername'] = Arr::get(Model_Supplier::get_supplier_info($info['supplierlist'],array('suppliername')),'suppliername');
        }
        //支付方式
        $paytypeArr = explode(',', $GLOBALS['cfg_pay_type']);
        //扩展字段信息
        $extend_info = ORM::factory('hotel_extend_field')
            ->where("productid=" . $info['id'])
            ->find()
            ->as_array();
        //目的地上级
        if ($info['finaldestid'] > 0) {
            $predest = Product::get_predest($info['finaldestid']);
            $this->assign('predest', $predest);
        }
        $this->assign('seoinfo', $seoInfo);
        $this->assign('info', $info);
        $this->assign('paytypeArr', $paytypeArr);
        $this->assign('extendinfo', $extend_info);
        $this->assign('destid', $info['finaldestid']);
        $this->assign('tagword', $info['tagword']);

        $templet = Product::get_use_templet('hotel_show');
        $templet = $templet ? $templet : 'hotel/show';
        $this->display($templet);

        //缓存内容
        $content = $this->response->body();
        Common::cache('set', $this->_cache_key, $content);
    }

    //列表页
    public function action_list()
    {
        $req_uri = $_SERVER['HTTP_X_FORWARDED_PROTO'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $is_all = false;
        if (Common::get_web_url(0) . '/hotels/all' == $req_uri || Common::get_web_url(0) . '/hotels/all/' == $req_uri)
        {
            $is_all = true;
        }
        //参数值获取
        $destPy = $this->request->param('destpy');
        $sign = $this->request->param('sign');
        $rankId = intval($this->request->param('rankid'));
        $priceId = intval($this->request->param('priceid'));
        $sortType = intval($this->request->param('sorttype'));
        $attrId = $this->request->param('attrid');
        $p = intval($this->request->param('p'));
        $attrId = !empty($attrId) ? $attrId : 0;
        $destPy = $destPy ? $destPy : 'all';
        $pagesize = 20;
        $keyword = strip_tags($_GET['keyword']);
        $keyword = St_String::filter_mark($keyword);

        $route_array = array(
            'controller' => $this->request->controller(),
            'action' => $this->request->action(),
            'destpy' => $destPy,
            'rankid' => $rankId,
            'priceid' => $priceId,
            'sorttype' => $sortType,
            'displaytype' => 0,
            'attrid' => $attrId,
            'starttime' => '',
            'endtime' => ''
        );
        //入店时间
        if (isset($_GET['starttime']) && !empty($_GET['starttime'])) {
            $starttime = strtotime(St_Filter::remove_xss($_GET['starttime']));
            $route_array['starttime'] = $starttime ? $starttime : '';
            $starttime_str = $starttime ? St_Filter::remove_xss($_GET['starttime']) : '';
            $this->assign('starttime', $starttime_str);
        }
        //离店时间
        if (isset($_GET['endtime']) && !empty($_GET['endtime'])) {
            $endtime = strtotime(St_Filter::remove_xss($_GET['endtime']));
            $route_array['endtime'] = $endtime ? $endtime : '';
            $endtime_str = $endtime ? St_Filter::remove_xss($_GET['endtime']) : '';
            $this->assign('endtime', $endtime_str);
        }
        //分页数
        if (isset($_GET['pagesize']) && !empty($_GET['pagesize'])) {
            $pagesizeTemp = intval($_GET['pagesize']);
            if ($pagesizeTemp) {
                $pagesize = $pagesizeTemp;
            }
        }
        //$start_time=microtime(true); //获取程序开始执行的时间
        $out = Model_Hotel::search_result($route_array, $keyword, $p, $pagesize);
        $pager = Pagination::factory(
            array(

                'current_page' => array('source' => 'route', 'key' => 'p'),
                'view' => 'default/pagination/search',
                'total_items' => $out['total'],
                'items_per_page' => $pagesize,
                'first_page_in_url' => false,
            )
        );
        //配置访问地址 当前控制器方法

        $pager->route_params($route_array);
        $destId = $destPy == 'all' ? 0 : DB::select('id')->from('destinations')->where('pinyin', '=', $destPy)->execute()->get('id');
        $destId = $destId ? $destId : 0;
        Common::check_is_sub_web($destId, 'hotels/' . $destPy);
        //目的地信息
        $destInfo = array();
        $preDest = array();
        if ($destId) {
            $destInfo = Model_Hotel::get_dest_info($destId);

        }
        //$end_time=microtime(true);

        //$total=$end_time-$start_time; //计算差值
        $channel_info = Model_Nav::get_channel_info($this->_typeid);
        $channel_name = empty($channel_info['seotitle']) ? $channel_info['shortname'] : $channel_info['seotitle'];

        $seo_params = array(
            'destpy' => $destPy,
            'rankid' => $rankId,
            'priceid' => $priceId,
            'sorttype' => $sortType,
            'displaytype' => 0,
            'attrid' => $attrId,
            'starttime' => '',
            'endtime' => '',
            'p' => $p,
            'keyword' => $keyword,
            'channel_name' => $channel_name
        );
        $chooseitem = Model_Hotel::get_selected_item($route_array);
        $search_title = Model_Hotel::gen_seotitle($seo_params);
        $tagword = Model_Hotel_Kindlist::get_list_tag_word($destPy);
        $this->assign('tagword', $tagword);
        $this->assign('destid', $destId);
        $this->assign('destinfo', $destInfo);
        // $this->assign('predest', $preDest);
        $this->assign('list', $out['list']);
        $this->assign('chooseitem', $chooseitem);
        $this->assign('searchtitle', $search_title);
        $this->assign('param', $route_array);
        $this->assign('currentpage', $p);
        $this->assign('pageinfo', $pager);
        $this->assign('is_all', $is_all);

        $templet = St_Functions::get_list_dest_template_pc($this->_typeid, $destId);
        $templet = empty($templet) ? Product::get_use_templet('hotel_list') : $templet;
        $templet = $templet ? $templet : 'hotel/list';
        $this->display($templet);
        //缓存内容
        $content = $this->response->body();
        Common::cache('set', $this->_cache_key, $content);
    }

    //预订页面
    public function action_book()
    {
        //会员信息
        $userInfo = Product::get_login_user_info();
        //要求预订前必须登陆
        if (!empty($GLOBALS['cfg_login_order']) && empty($userInfo['mid'])) {
            $this->request->redirect(Common::get_main_host() . '/member/login/?redirecturl=' . urlencode(Common::get_current_url()));
        }
        $productId = Arr::get($_GET, 'hotelid');
        $suitId = Arr::get($_GET, 'suitid');

        if (empty($productId) || empty($suitId)) {
            $this->request->redirect($this->request->referrer());
        }

        $info = ORM::factory('hotel', $productId)->as_array();


        //套餐信息

        $suitInfo = Model_Hotel_Room::suit_info($suitId);
        //产品信息
        $info = ORM::factory('hotel', $productId)->as_array();
        //产品编号
        $info['series'] = St_Product::product_series($info['id'], 2);
        $info['url'] = Common::get_web_url($info['webid']) . "/hotels/show_{$info['aid']}.html";
        //frmcode
        $code = md5(time());
        Common::session('code', $code);
        //积分抵现所需积分
        $needjifen = $GLOBALS['cfg_exchange_jifen'] * $suitInfo['jifentprice']; //所需积分
        //最新日期
        //积分抵现所需积分
        $jifentprice_info = Model_Jifen_Price::get_used_jifentprice($info['jifentprice_id'], $this->_typeid);


        $linktel_verify_identity = md5(time());

        Common::session('linktel_verify_identity', $linktel_verify_identity);

        $this->assign('linktel_verify_identity', $linktel_verify_identity);
        $this->assign('jifentprice_info', $jifentprice_info);
        $this->assign('info', $info);
        $this->assign('suitInfo', $suitInfo);


        $this->assign('userInfo', $userInfo);
        $this->assign('needjifen', $needjifen);
        $this->assign('frmcode', $code);
        $this->display('hotel/book');
    }

    public function action_ajax_send_verify_code()
    {
        $mobile = $_POST['mobile'];
        $linktel_verify_identity = $_POST['linktel_verify_identity'];
        $cur_time = time();

        $org_identity = Common::session('linktel_verify_identity');
        if (empty($linktel_verify_identity) || $linktel_verify_identity != $org_identity) {
            echo json_encode(array('status' => false, 'msg' => '检验码错误'));
            return;
        }
        //手机号验证
        if (empty($mobile)) {
            echo json_encode(array('status' => false, 'msg' => '手机号不能为空'));
            return;
        }
        else {
            $sent_num = Common::session('sent_num_' . $mobile); //已发验证码次数
            $sent_num = empty($sent_num) ? 0 : intval($sent_num);

            $last_sent_time_1 = Common::session('last_sent_time_' . $mobile);//上次发送时间
            $last_sent_time_1 = empty($last_sent_time_1) ? 0 : $last_sent_time_1;

            $last_sent_time_2 = Common::session('last_sent_time_' . $linktel_verify_identity);
            $last_sent_time_2 = empty($last_sent_time_2) ? 0 : $last_sent_time_2;

            $interval_time_1 = $cur_time - $last_sent_time_1;
            $interval_time_2 = $cur_time - $last_sent_time_2;

            if ($interval_time_1 < 60 || $interval_time_2 < 60) {
                echo json_encode(array('status' => false, 'msg' => '验证码发送过于频繁'));
                return;
            }

            $linktel_code = mt_rand(10000, 99999);
            $content = "尊敬的客户，你的手机验证码是{$linktel_code}";


            $flag = json_decode(St_SMSService::send_msg($mobile, $GLOBALS['cfg_webname'], $content));
            if ($flag->Success)//发送成功
            {
                Common::session('linktel_code_' . $mobile, $linktel_code);
                Common::session('sent_num_' . $mobile, ++$sent_num);
                Common::session('last_send_time_' . $mobile, $cur_time);
                Common::session('last_send_time_' . $linktel_verify_identity, $cur_time);
                echo json_encode(array('status' => true, 'msg' => '验证码发送成功'));
            }
            else {
                echo json_encode(array('status' => false, 'msg' => '验证码发送失败，请重试' . $flag->Message));
            }

        }

    }

    public function action_ajax_check_phone_code()
    {
        $linktel = $_POST['linktel'];
        $phone_code = $_POST['phone_code'];
        $org_phone_code = Common::session('linktel_code_' . $linktel);
        if (empty($phone_code) || $phone_code != $org_phone_code) {
            echo 'false';
        }
        else {
            echo 'true';
        }

    }

    /*
     * 创建订单
     * */

    public function action_create()
    {

        $frmCode = Arr::get($_POST, 'frmcode');
        $checkCode = strtolower(Arr::get($_POST, 'checkcode'));
        //验证码验证
        if (!Captcha::valid($checkCode) || empty($checkCode)) {
            exit();
        }
        //安全校验码验证
        $orgCode = Common::session('code');
        if ($orgCode != $frmCode) {
            exit();
        }


        //会员信息
        $userInfo = Product::get_login_user_info();
        $memberId = $userInfo ? $userInfo['mid'] : 0;//会员id
        $webid = intval(Arr::get($_POST, 'webid'));//网站id
        $dingNum = intval(Arr::get($_POST, 'dingnum'));//房间数量
        $suitId = intval(Arr::get($_POST, 'suitid'));//套餐id
        $hotelId = intval(Arr::get($_POST, 'hotelid'));//酒店id
        $startDate = Arr::get($_POST, 'startdate');//入住日期
        $departDate = Arr::get($_POST, 'leavedate');//离店日期
        $linkMan = Arr::get($_POST, 'linkman');//联系人姓名
        $linkTel = Arr::get($_POST, 'linktel');//联系人电话
        $linkEmail = Arr::get($_POST, 'linkemail');//联系人邮箱
        $linkTel = empty($linkTel) && !empty($userInfo) ? $userInfo['mobile'] : $linkTel;
        $linkEmail = empty($linkEmail) && !empty($userInfo) ? $userInfo['email'] : $linkEmail;
        //日期判断
        if(!(strtotime($startDate)<strtotime($departDate)))
        {
            $this->request->redirect('/tips/order');
        }


        if ($GLOBALS['cfg_plugin_hotel_book_sms_verify'] == 1) {
            $phone_code = $_POST['phone_code'];
            $org_phone_code = Common::session('linktel_code_' . $linkTel);
            if (empty($phone_code) || $phone_code != $org_phone_code) {
                exit('phone verify error!');
            }
            Common::session('linktel_code_' . $linkTel, null);
        }

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


        $remark = Arr::get($_POST, 'remark');//订单备注
        $payType = Arr::get($_POST, 'paytype');//支付方式
        $useJifen = intval(Arr::get($_POST, 'usejifen'));//是否使用积分
        $needJifen = intval($_POST['needjifen']);
        //检测订单有效性
        $check_result = common::before_order_check(array('model' => 'hotel', 'productid' => $hotelId, 'suitid' => $suitId, 'day' => strtotime($startDate)));
        if (!$check_result) {
            $this->request->redirect('/tips/order');
        };
        //套餐信息
        $suitInfo = Model_Hotel_Room::suit_info($suitId);
        //产品信息
        $info = ORM::factory('hotel', $hotelId)->as_array();
        $orderSn = Product::get_ordersn('02');
        $priceArr = ORM::factory('hotel_room_price')->where("day=" . strtotime($startDate) . " and suitid=" . $suitId)->find()->as_array();
        //这里直接计算出房间总价
        //酒店需要重新计算金额
        $total_price = Model_Hotel::suit_range_price($suitId, $startDate, $departDate, $dingNum);

        //判断积分使用是否满足需求.
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

        //订单状态(全款支付,定金支付,二次确认)
        $status = $suitInfo['paytype'] != 3 ? 1 : 0;


        $diffdate = (strtotime($departDate) - strtotime($startDate)) / (24 * 60 * 60);
        $suitInfo['dingjin'] = doubleval($suitInfo['dingjin'] * $diffdate);

        /*if(!Model_Hotel::check_storage($hotelId,$dingNum,$suitId,$startDate,$departDate))
        {
            exit('storage is not enough!');
        }*/
        $arr = array(
            'ordersn' => $orderSn,
            'webid' => $webid,
            'typeid' => $this->_typeid,
            'productautoid' => $info['id'],
            'productaid' => $info['aid'],
            'productname' => $info['title'] . "({$suitInfo['roomname']})",
            'price' => $total_price,

            'usedate' => $startDate,
            'dingnum' => $dingNum,
            'departdate' => $departDate,

            'linkman' => $linkMan,
            'linktel' => $linkTel,
            'linkemail' => $linkEmail,
            'jifentprice' => $jifentprice,
            'jifenbook' => $info['jifenbook_id'],
            'jifencomment' => $jifencomment,
            'addtime' => time(),
            'memberid' => $memberId,
            'dingjin' => $suitInfo['dingjin'],
            'paytype' => $suitInfo['paytype'],
            'suitid' => $suitId,
            'usejifen' => $useJifen,
            'needjifen' => $needJifen,
            'status' => $status,
            'remark' => $remark,
            'isneedpiao' => 0

        );
        /*--------------------------------------------------------------优惠券信息------------------------------------------------------------*/
        //优惠券判断
        $croleid = intval(Arr::get($_POST, 'couponid'));
        if ($croleid) {
            $cid = DB::select('cid')->from('member_coupon')->where("id=$croleid")->execute()->current();
            $totalprice = Model_Coupon::get_order_totalprice($arr);
            $ischeck = Model_Coupon::check_samount($croleid, $totalprice, $this->_typeid, $info['id'], $startDate);
            if ($ischeck['status'] == 1) {
                Model_Coupon::add_coupon_order($cid, $orderSn, $totalprice, $ischeck, $croleid); //添加订单优惠券信息
            }
            else {
                exit('coupon  verification failed!');//优惠券不满足条件
            }
        }

        /*-----------------------------------------------------------------优惠券信息--------------------------------------*/
        //添加订单
        if (St_Product::add_order($arr, 'Model_Hotel', $arr)) {
            Common::session('_platform', 'pc');

            $order_info = Model_Member_Order::order_info($orderSn);
            Model_Member_Order::add_tourer_pc($order_info['id'], $tourer, $order_info['memberid']);
            //这里作判断是跳转到订单查询页面

            $payurl = Common::get_main_host() . "/payment/?ordersn=" . $orderSn;
            $this->request->redirect($payurl);

        }
    }


    //报价日历
    public function action_dialog_calendar()
    {
        $suitid = Arr::get($_POST, 'suitid');
        $year = Arr::get($_POST, 'year');
        $month = Arr::get($_POST, 'month');
        $containdiv = Arr::get($_POST, 'containdiv');
        if (empty($year) && empty($month)) {
            $data = DB::select()->from('hotel_room_price')->where('suitid', '=', $suitid)->and_where('day', '>=', time())->execute()->current();
            if (!empty($data)) {
                $year = date('Y', $data['day']);
                $month = date('m', $data['day']);
            }
            else {
                $nowDate = new DateTime();
                $year = $nowDate->format('Y');
                $month = $nowDate->format('m');
            }
        }
        $out = '';
        $priceArr = Product::get_suit_price($year, $month, $suitid, $this->_typeid);
        $out .= $this->calender($year, $month, $priceArr, $suitid, $containdiv);
        echo $out;
    }

    public function  calender($year = '', $month = '', $priceArr = NULL, $suitid, $contain = '')
    {

            date_default_timezone_set('Asia/Shanghai');
            $year = abs(intval($year));
            $month = abs(intval($month));
            $tmonth = $month < 10 ? "0" . $month : $month;
            $defaultYM = $year . '-' . $tmonth;
            $nowDate = new DateTime();
            if ($year <= 0)
            {
                $year = $nowDate->format('Y');
            }
            if ($month <= 0 or $month > 12)
            {
                $month = $nowDate->format('m');
            }
            //上一年
            $prevYear = $year - 1;
            //上一月
            $mpYear = $year;
            $preMonth = $month - 1;
            if ($preMonth <= 0)
            {
                $preMonth = 12;
                $mpYear = $prevYear;
            }
            $preMonth = $preMonth < 10 ? '0' . $preMonth : $preMonth;
            //下一年
            $nextYear = $year + 1;
            //下一月
            $mnYear = $year;
            $nextMonth = $month + 1;
            if ($nextMonth > 12)
            {
                $nextMonth = 1;
                $mnYear = $nextYear;
            }
            $nextMonth = $nextMonth < 10 ? '0' . $nextMonth : $nextMonth;
            //日历头
            $html = '<div id="calendar_tab">
        <table width="100%" border="1" style="border-collapse: collapse;">

          <tr align="center" >
            <td class="top_title"><a id="premonth" data-year="' . $mpYear . '" class="prevmonth" data-suitid="' . $suitid . '"  data-month="' . $preMonth . '" href="javascript:;" data-contain="' . $contain . '">上一月</a></td>
            <td colspan="3" class="top_title" style="height:50px;">' . $year . '年' . $month . '月</td>
            <td class="top_title"><a id="nextmonth"  data-year="' . $mnYear . '" class="nextmonth" data-suitid="' . $suitid . '" data-month="' . $nextMonth . '" href="javascript:;" data-contain="' . $contain . '">下一月</a></td>

          </tr>
          <tr>
            <td colspan="5">
                <table width="100%" border="1" >
                    <tr align="center">
                        <td style="height:25px;">一</td>
                        <td style="height:25px;">二</td>
                        <td style="height:25px;">三</td>
                        <td style="height:25px;">四</td>
                        <td style="height:25px;">五</td>
                        <td style="height:25px;">六</td>
                        <td style="height:25px;">日</td>
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
            $prev_day_enable_select = false;
            while ($day <= $lastday)
            {

                $month_str = $month < 10 ? '0' . $month : $month;
                $day_str = $day < 10 ? '0' . $day : $day;
                $cday = $year . '-' . $month_str . '-' . $day_str;
                //当前星期几
                $creatDate = new DateTime("$year-$month-$day");
                $nowWeek = $creatDate->format('N');
                $creatDate = NULL;

                if ($day == 1)
                {
                    $line = '<tr align="center">';
                    $line .= str_repeat('<td>&nbsp;</td>', $nowWeek - 1);
                }
                if ($cday == $currentDay)
                {
                    $style = 'style="font-size:16px; font-family:微软雅黑,Arial,Helvetica,sans-serif;color:#FF6600;line-height:22px;"';
                }
                else
                {
                    $style = 'style=" font-size:16px; font-family:微软雅黑,Arial,Helvetica,sans-serif;line-height:22px;"';
                }
                //判断当前的日期是否小于今天
                $defaultmktime = mktime(1, 1, 1, $month, $day, $year);

                $currentmktime = mktime(1, 1, 1, date("m"), date("j"), date("Y"));
                //echo '<hr>';
                $tday = ($day < 10) ? '0' . $day : $day;
                $cdaydate = $defaultYM . '-' . $tday;
                $cdayme = strtotime($cdaydate);
                //单价
                $dayPrice = $priceArr[$cdayme]['price'];

                $dayPrice = empty($dayPrice) ? $priceArr[$cdayme]['child_price'] : $dayPrice;

                $dayPrice = empty($dayPrice) ? $priceArr[$cdayme]['old_price'] : $dayPrice;


                //库存
                $priceArr[$cdayme]['number'] = $priceArr[$cdayme]['number'] < -1 ? 0 : $priceArr[$cdayme]['number'];
                $number = $priceArr[$cdayme]['number'] != -1 ? $priceArr[$cdayme]['number'] : '充足';
                $numstr = '<b style="font-size: 1rem;font-weight:normal">余位&nbsp;' . $number . '</b>';

                //定义单元格样式，高，宽
                $tdStyle = "height='80'";
                //判断当前的日期是否小于今天
                $tdcontent = '<span class="num">' . $day . '</span>';
                if ($defaultmktime >= $currentmktime)
                {
                    if($day_str=='1')
                    {
                        $prev_day_timestamp=strtotime($cday)-24*3600;
                        $prev_price_info = DB::select()->from('hotel_room_price')->where('suitid','=',$suitid)->and_where('day','=',$prev_day_timestamp)->execute()->current();
                        if(!empty($prev_price_info) &&  $prev_price_info['number']!=0)
                        {
                            $prev_day_enable_select=true;
                        }

                    }
                    if ($dayPrice || $contain == "leavedate")//当选择结束日期时，可以选择报价日期后一天没有报价的日期
                    {



                        if ($number !== 0 && $dayPrice)
                        {
                            $dayPriceStrs = Currency_Tool::symbol() . $dayPrice . '<br>';
                            $tdcontent .= '<b class="price">' . $dayPriceStrs . '</b>' . $numstr;

                            $onclick = 'onclick="choose_day(\'' . $cday . '\',\'' . $contain . '\')"';
                            $prev_day_enable_select = true;
                        }
                        else
                        {
                            $tdcontent .= '<b class="no_yd"></b>' . '<b class="roombalance_b"></b>';
                            if ($contain == "leavedate" && $prev_day_enable_select)
                            {
                                $onclick = 'onclick="choose_day(\'' . $cday . '\',\'' . $contain . '\')"';
                            }
                            else
                            {
                                $onclick = '';
                            }
                            $prev_day_enable_select = false;

                        }

                    }
                    else
                    {
                        $dayPriceStrs = '';
                        $tdcontent .= '<b class="no_yd"></b>' . '<b class="roombalance_b"></b>';
                        $onclick = '';
                        $numberinfo = "<span class='kucun'></span>";

                    }
                    if ($onclick == '')
                    {

                        $line .= "<td $tdStyle class='nouseable' >" . $tdcontent . "</td>";
                    }
                    else
                    {
                        $line .= "<td $tdStyle $onclick style='cursor:pointer;' class='useable' >" . $tdcontent . "</td>";
                    }
                }
                else
                {
                    $dayPriceStrs = '&nbsp;&nbsp;';
                    $tdcontent .= '<b class="no_yd"></b>';
                    $line .= "<td $tdStyle class='nouseable' >" . $tdcontent . "</td>";
                }


                //$line .= "<td $style>$day <div>不可订</div></td>";

                //一周结束
                if ($nowWeek == 7)
                {
                    $line .= '</tr>';
                    $html .= $line;
                    $line = '<tr align="center">';
                }

                //全月结束
                if ($day == $lastday)
                {
                    if ($nowWeek != 7)
                    {
                        $line .= str_repeat('<td>&nbsp;</td>', 7 - $nowWeek);
                    }
                    $line .= '</tr>';
                    $html .= $line;

                    break;
                }

                $day++;
            }

            $html .= '
                </table>
            </td>
          </tr>
        </table>
        </div>
        ';
            return $html;

        }




    //目的地
    public function action_ajax_dest()
    {
        $data = Arr::get($_GET, 'dataid');

        if ($data == 'hot') {
            $list = Model_Destinations::get_hot_dest($this->_typeid, 0, 15);
        }
        else {
            $list = Model_Destinations::get_dest_by_pinyin($data, $this->_typeid, 0, 15);
        }
        echo json_encode(array('list' => $list));

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
        if (empty($day)) {
            echo json_encode(array(
                'startdate' => date('Y-m-d', time()),
                'enddate' => date('Y-m-d', strtotime("+1 day", time()))
            ));
            return;
        }
        echo json_encode(array(
            'startdate' => date('Y-m-d', $day),
            'enddate' => date('Y-m-d', strtotime("+1 day", $day))
        ));
    }

    /*
    * 获取房型进店和离店日期价格
    * */
    public function action_ajax_range_price()
    {
        $startdate = Arr::get($_GET, 'startdate');
        $enddate = Arr::get($_GET, 'leavedate');
        $suitid = Arr::get($_GET, 'suitid');
        $suitid = intval($suitid);
        $dingnum = intval(Arr::get($_GET, 'dingnum'));
        $price = Model_Hotel::suit_range_price($suitid, $startdate, $enddate, $dingnum);
        $price = $price * $dingnum;
        echo json_encode(array('price' => $price));
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
        $flag = Model_Hotel::check_storage(0, $dingnum, $suitid, $startdate, $enddate);
        echo json_encode(array('status' => $flag));
    }

    /*
     * 验证验证码是否正确
     * */
    public function action_ajax_check_code()
    {
        $flag = 'false';
        $checkcode = strtolower(Arr::get($_POST, 'checkcode'));
        if (Captcha::valid($checkcode)) {
            $flag = 'true';
        }
        echo $flag;
    }

    //根据目的地名获取拼音
    public function action_ajax_dest_py()
    {
        $destname = Arr::get($_POST, 'destname');
        $pinyin = 'all';
        $pinyin = DB::select('pinyin')->from('destinations')->where('kindname', '=', $destname)->execute()->get('pinyin');
        echo $pinyin;
    }


}