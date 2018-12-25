<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Class Controller_Spot
 * 景点/门票控制器
 */
class Controller_Pc_Spot extends Stourweb_Controller
{
    private $_typeid = 5;
    private $_cache_key = '';

    public function before()
    {
        parent::before();
        //检查缓存
        $this->_cache_key = Common::get_current_url();
        $html = Common::cache('get', $this->_cache_key);
        $genpage = Common::remove_xss(Arr::get($_GET, 'genpage'));
        if (!empty($html) && empty($genpage)) {
            echo $html;
            exit;
        }
        $channelname = Model_Nav::get_channel_name($this->_typeid);
        $this->assign('typeid', $this->_typeid);
        $this->assign('channelname', $channelname);
    }


    /**
     * 首页
     */
    public function action_index()
    {
        $seoinfo = Model_Nav::get_channel_seo($this->_typeid);
        $this->assign('seoinfo', $seoinfo);
        //首页模板
        $templet = Product::get_use_templet('spot_index');
        $templet = $templet ? $templet : 'spot/index';
        $this->display($templet);
        //缓存内容
        $content = $this->response->body();
        Common::cache('set', $this->_cache_key, $content);
    }

    /*
     * 搜索页
     */
    public function action_list()
    {
        $req_uri = $_SERVER['HTTP_X_FORWARDED_PROTO'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $is_all = false;
        if (Common::get_web_url(0) . '/spots/all' == $req_uri || Common::get_web_url(0) . '/spots/all/' == $req_uri)
        {
            $is_all = true;
        }
        //参数值获取
        $destPy = $this->request->param('destpy');
        $sign = $this->request->param('sign');
        $priceId = intval($this->request->param('priceid'));
        $sortType = intval($this->request->param('sorttype'));
        $attrId = $this->request->param('attrid');
        $p = intval($this->request->param('p'));
        $attrId = !empty($attrId) ? $attrId : 0;
        $keyword = strip_tags($_GET['keyword']);
        $keyword = St_String::filter_mark($keyword);
        $destPy = $destPy ? $destPy : 'all';
        $pagesize = 12;


        $channel_info = Model_Nav::get_channel_info($this->_typeid);
        $channel_name = empty($channel_info['seotitle']) ? $channel_info['shortname'] : $channel_info['seotitle'];
        $route_array = array(
            'controller' => $this->request->controller(),
            'action' => $this->request->action(),
            'destpy' => $destPy,
            'priceid' => $priceId,
            'sorttype' => $sortType,
            'attrid' => $attrId,
            'page' => $p,
            'keyword' => $keyword,
            'channel_name' => $channel_name
        );

        $out = Model_Spot::search_result($route_array, $keyword, $p, $pagesize);

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
        $destId = $destPy == 'all' ? 0 : ORM::factory('destinations')->where("pinyin='$destPy'")->find()->get('id');
        $destId = $destId ? $destId : 0;
        //目的地子站判断
        Common::check_is_sub_web($destId, 'spots/' . $destPy);
        //目的地信息
        $destInfo = array();
        if ($destId) {
            $destInfo = Model_Spot::get_dest_info($destId);
        }
        $chooseitem = Model_Spot::get_selected_item($route_array);
        $search_title = Model_Spot::gen_seotitle($route_array);
        $tagword = Model_Spot_Kindlist::get_list_tag_word($destPy);
        $this->assign('tagword', $tagword);
        $this->assign('destid', $destId);
        $this->assign('destinfo', $destInfo);
        $this->assign('list', $out['list']);
        $this->assign('chooseitem', $chooseitem);
        $this->assign('searchtitle', $search_title);
        $this->assign('param', $route_array);
        $this->assign('currentpage', $p);
        $this->assign('pageinfo', $pager);
        $this->assign('is_all', $is_all);

        $templet = St_Functions::get_list_dest_template_pc($this->_typeid, $destId);
        $templet = empty($templet) ? Product::get_use_templet('spot_list') : $templet;
        $templet = $templet ? $templet : 'spot/list';
        $this->display($templet);

        //缓存内容
        $content = $this->response->body();
        Common::cache('set', $this->_cache_key, $content);

    }


    /*
     * 预订
     * */
    public function action_book()
    {
        //会员信息
        $userInfo = Product::get_login_user_info();
        //要求预订前必须登陆
        if (!empty($GLOBALS['cfg_login_order']) && empty($userInfo['mid'])) {
            $this->request->redirect(Common::get_main_host() . '/member/login/?redirecturl=' . urlencode(Common::get_current_url()));
        }
        $productId = Common::remove_xss(Arr::get($_GET, 'productid'));
        $suitId = Common::remove_xss(Arr::get($_GET, 'suitid'));
        //防止空提交
        if (empty($productId) || empty($suitId)) {
            $this->request->redirect($this->request->referrer());
        }
        //套餐信息
        $suitInfo = Model_Spot_Suit::suit_info($suitId);
        //预订日期
        $useDate = Arr::get($_GET, 'usedate');
        $cur_time = time();
        if (is_null($useDate)) {
            $sql = "select * from sline_spot_ticket_price a left join sline_spot_ticket b on a.ticketid=b.id   where a.ticketid='{$suitId}' and a.number!=0  and a.day>({$cur_time}+b.day_before*24*3600-case when (b.hour_before=0 and b.minute_before=0) then 24*3600 else (3600*b.hour_before+b.minute_before*60) end) order by a.day asc limit 1";
            $ticket = DB::query(Database::SELECT,$sql)->execute()->current();
            $useDate = !empty($ticket) ? $ticket['day'] : $cur_time;
            $useDate = date('Y-m-d', $useDate);
        }


        //产品信息
        $info = ORM::factory('spot', $productId)->as_array();
        $info['price'] = Currency_Tool::price($info['price']);
        $info['url'] = Common::get_web_url($info['webid']) . "/spots/show_{$info['aid']}.html";
        $info['usedate'] = $useDate;
        //产品编号
        $info['series'] = St_Product::product_series($info['id'], 5);

        //frmcode
        $code = md5(time());
        Common::session('code', $code);


        //积分抵现所需积分
        $jifentprice_info = Model_Jifen_Price::get_used_jifentprice($info['jifentprice_id'], $this->_typeid);
        $this->assign('jifentprice_info', $jifentprice_info);
        $jifenbook_info = Model_Jifen::get_used_jifenbook($info['jifenbook_id'], $this->_typeid);
        $this->assign('jifenbook_info', $jifenbook_info);
        $this->assign('info', $info);
        $this->assign('suitInfo', $suitInfo);
        $this->assign('userInfo', $userInfo);
        $this->assign('frmcode', $code);
        $this->display('spot/book');
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
        $userInfo = Product::get_login_user_info();
        $memberId = $userInfo ? $userInfo['mid'] : 0;//会员id
        $webid = intval(Arr::get($_POST, 'webid'));//网站id
        $dingNum = intval(Arr::get($_POST, 'dingnum'));//数量
        $suitId = intval(Arr::get($_POST, 'suitid'));
        $productId = intval(Arr::get($_POST, 'productid'));//产品id
        $useDate = Arr::get($_POST, 'usedate');//使用日期

        $linkMan = Common::remove_xss(Arr::get($_POST, 'linkman'));//联系人姓名
        $linkTel = Common::remove_xss(Arr::get($_POST, 'linktel'));//联系人电话
        $linkEmail = Arr::get($_POST, 'linkemail');//联系人邮箱

        $linkTel = empty($linkTel) && !empty($userInfo) ? $userInfo['mobile'] : $linkTel;
        $linkEmail = empty($linkEmail) && !empty($userInfo) ? $userInfo['email'] : $linkEmail;

        $remark = Common::remove_xss(Arr::get($_POST, 'remark'));//订单备注
        $payType = Arr::get($_POST, 'paytype');//支付方式
        $needJifen = intval($_POST['needjifen']);


        //游客信息读取
        $t_name = Arr::get($_POST, 't_name');
        $t_cardtype = Arr::get($_POST, 't_cardtype');
        $t_mobile = Arr::get($_POST, 't_mobile');
        $t_cardno = Arr::get($_POST, 't_cardno');
        $t_sex = Arr::get($_POST, 't_sex');
        $t_issave = Arr::get($_POST, 't_issave');
        $tourer = array();

        for ($i = 0; $i < $dingNum; $i++) {
            if (empty($t_name[$i])) {
                continue;
            }
            $tourer[] = array(
                'name' => $t_name[$i],
                'mobile' => $t_mobile[$i],
                'sex' => $t_sex[$i],
                'cardtype' => $t_cardtype[$i],
                'cardno' => $t_cardno[$i],
                'issave' => $t_issave[$i]
            );
        }

        //产品信息
        $info = ORM::factory('spot', $productId)->as_array();
        //检测订单有效性
        $check_result = Model_Spot::before_order_check($productId, $suitId, strtotime($useDate));
        $check_result['adultprice'] = Currency_Tool::price($check_result['adultprice']);
        if (!$check_result) {
            $this->request->redirect('/tips/order');
        };
        //套餐信息
        $suitInfo = Model_Spot_Suit::suit_info($suitId);
        $suitInfo['ourprice'] = $check_result['adultprice'];
        $orderSn = Product::get_ordersn('05');

        $info['title'] = $info['title'] . ' -- ' .Model_Spot_Ticket_Type::get_info($suitInfo['tickettypeid'], 'kindname') ."({$suitInfo['title']})";

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

        //判断库存
        if (!Model_Spot::check_storage($productId, $dingNum, $suitId, $useDate)) {
            exit('storage is not enough!');
        }

        //自动关闭订单时间
        $auto_close_time = $suitInfo['auto_close_time'] ? $suitInfo['auto_close_time'] : 0;

        if($auto_close_time)
        {
            // $auto_close_time = strtotime("+{$auto_close_time} hours");
            // 兼容小时分钟
            $auto_close_time = time() + $auto_close_time;
        }

        $arr = array(
            'ordersn' => $orderSn,
            'webid' => $webid,
            'typeid' => $this->_typeid,
            'productautoid' => $info['id'],
            'productaid' => $info['aid'],
            'productname' => $info['title'],
            'price' => $suitInfo['ourprice'],
            'usedate' => $useDate,
            'dingnum' => $dingNum,
            'departdate' => '',
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
            'status' => $suitInfo['need_confirm'] ? 0:1,
            'remark' => $remark,
            'source' => 1,//来源PC,
            'pay_way' => $suitInfo['pay_way'] ,//线上线下.
            'auto_close_time' =>$auto_close_time, //自动关闭订单时间
            'refund_restriction'=>$suitInfo['refund_restriction'],//退改条件
            'need_confirm' => $suitInfo['need_confirm'] ? $suitInfo['need_confirm'] : 0 ,//是否需要确认.
        );

        /*--------------------------------------------------------------优惠券信息------------------------------------------------------------*/
        //优惠券判断
        $croleid = intval(Arr::get($_POST, 'couponid'));
        if ($croleid) {
            $cid = DB::select('cid')->from('member_coupon')->where("id=$croleid")->execute()->current();
            $totalprice = Model_Coupon::get_order_totalprice($arr);
            $ischeck = Model_Coupon::check_samount($croleid, $totalprice, $this->_typeid, $info['id'], $useDate);
            if ($ischeck['status'] == 1) {
                Model_Coupon::add_coupon_order($cid, $orderSn, $totalprice, $ischeck, $croleid); //添加订单优惠券信息
            }
            else {
                exit('coupon  verification failed!');//优惠券不满足条件
            }
        }

        /*-----------------------------------------------------------------优惠券信息--------------------------------------*/

        //添加订单
        if (St_Product::add_order($arr, 'Model_Spot', $arr)) {

            $orderInfo = Model_Member_Order::order_info($orderSn);
            Model_Member_Order_Tourer::add_tourer_pc($orderInfo['id'], $tourer, $orderInfo['memberid']);

            Common::session('_platform', 'pc');
            //这里作判断是跳转到订单查询页面

            $payurl = Common::get_main_host() . "/payment/?ordersn=" . $orderSn;
            $this->request->redirect($payurl);


        }


    }

    /**
     * 日历报价
     */
    public function action_dialog_calendar()
    {
        $suitid = intval(Arr::get($_POST, 'suitid'));
        $year = intval(Arr::get($_POST, 'year'));
        $month = intval(Arr::get($_POST, 'month'));
        $containdiv = Arr::get($_POST, 'containdiv');
        $nowDate = new DateTime();
        $year = !empty($year) ? $year : $nowDate->format('Y');
        $month = !empty($month) ? $month : $nowDate->format('m');
        $out = '';
        $priceArr = Model_Spot::get_month_price($year, $month, $suitid);
        $out .= Common::calender($year, $month, $priceArr, $suitid, $containdiv);
        echo $out;
    }

    /**
     * 套餐当天价格
     */
    public function action_suit_day_price()
    {
        $inputdate = Arr::get($_GET, 'inputdate');
        $suitid = intval(Arr::get($_GET, 'suitid'));
        $suit_info=Model_Spot_Suit::suit_info($suitid);
        $order_start_date=strtotime(date('Y-m-d',time()))+$suit_info["day_before"]*24*3600;
        $info = Model_Spot_Ticket_Price::current_price($suitid, strtotime($inputdate));

        //$tickettype_name = DB::select('kindname')->from('spot_ticket_type')->where('id','=',$suit_info['tickettypeid'])->execute()->get('kindname');
        $price = !empty($info) ? $info['price'] : 0;
        if($order_start_date>strtotime($inputdate))
        {
            $price=0;
            $info['number']=0;
        }
        echo json_encode(array('price' => $price,'number'=>$info['number']));
    }

    /*
     * 内容页
     */
    public function action_show()
    {
        $aid = intval($this->request->param('aid'));
        //详情
        $info = Model_Spot::spot_detail($aid);
//        if (!$info) {
//            $this->request->redirect('error/404');
//        }
        //seo
        $seoInfo = Product::seo($info);
        //产品图片
        $info['piclist'] = Product::pic_list($info['piclist']);
        //属性列表
        $info['attrlist'] = Model_Spot::spot_attr($info['attrid']);
        //最低价
        $price = Model_Spot::get_minprice($info['id'], array('info' => $info));
        $info['price'] = $price['price'];
        $info['sellprice'] = $price['sellprice'];
        //点评数
        $info['commentnum'] = Model_Comment::get_comment_num($info['id'], $this->_typeid);
        //销售数量
        $info['sellnum'] = Model_Member_Order::get_sell_num($info['id'], $this->_typeid) + intval($info['bookcount']);
        //产品编号
        $info['series'] = St_Product::product_series($info['id'], 5);
        //产品图标
        $info['iconlist'] = Product::get_ico_list($info['iconlist']);
        //支付方式
        $paytypeArr = explode(',', $GLOBALS['cfg_pay_type']);
        //满意度
        // $info['score'] = $info['satisfyscore'] ? $info['satisfyscore'] . '%' : mt_rand(90, 98) . '%';
        $info['score'] = St_Functions::get_satisfy($this->_typeid, $info['id'], $info['satisfyscore']);//满意度
        //是否有门票
        $info['hasticket'] = Model_Spot::has_ticket($info['id']);

        $info['jifentprice_info'] = Model_Jifen_Price::get_used_jifentprice($info['jifentprice_id'], $this->_typeid);
        $info['jifenbook_info'] = Model_Jifen::get_used_jifenbook($info['jifenbook_id'], $this->_typeid);
        $info['jifencomment_info'] = Model_Jifen::get_used_jifencomment($this->_typeid);
        //目的地上级
        if ($info['finaldestid'] > 0) {
            $finalDestInfo = DB::select_array(array('kindname'))->from('destinations')->where('id', '=', $info['finaldestid'])->execute()->current();
            if ($finalDestInfo)
            {
                $info['finaldestname'] = $finalDestInfo['kindname'];
            }
        }

        if(Model_Supplier::display_is_open()&&$info['supplierlist'])
        {
            $info['suppliername'] = Arr::get(Model_Supplier::get_supplier_info($info['supplierlist'],array('suppliername')),'suppliername');
        }

        //扩展字段信息
        $extend_info = Model_Spot::get_extend_info($info['id']);
        $this->assign('seoinfo', $seoInfo);
        $this->assign('info', $info);
        $this->assign('paytypeArr', $paytypeArr);
        $this->assign('extendinfo', $extend_info);
		$this->assign('destid', $info['finaldestid']);
        $this->assign('tagword', $info['tagword']);

        $templet = Model_Spot::get_product_template($info);
        $templet= $templet? $templet :  Product::get_use_templet('spot_show');
        $templet = $templet ? $templet : 'spot/show';
        $this->display($templet);

        Product::update_click_rate($info['aid'], $this->_typeid);
        //缓存内容
        $content = $this->response->body();
        Common::cache('set', $this->_cache_key, $content);
    }


    /*
    * 首页ajax请求获取景点
    * */
    public function action_ajax_index_spot()
    {
        $destid = intval(Arr::get($_GET, 'destid'));
        $pagesize = intval(Arr::get($_GET, 'pagesize'));
        $offset = 0;
        $list = Model_Spot::get_spot_bymdd($destid, $pagesize, $offset);
        foreach ($list as &$v) {
            $v['litpic'] = Common::img($v['litpic'], 283, 193);
        }
        echo json_encode(array('list' => $list));

    }

    //判断库存
    public function action_ajax_check_storage()
    {

        $dingnum = $_POST['dingnum'];
        $suitid = $_POST['suitid'];
        $startdate = $_POST['startdate'];
        $status = Model_Spot::check_storage(0, $dingnum, $suitid, $startdate);
        echo json_encode(array('status' => $status));
    }


}