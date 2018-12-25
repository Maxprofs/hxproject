<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Pc_Visa extends Stourweb_Controller
{
    /*
     * 签证总控制器
     * */

    private $_typeid = 8;
    private $_cache_key = '';

    public function before()
    {
        parent::before();
        //检查缓存
        $this->_cache_key = Common::get_current_url();
        $html = Common::cache('get', $this->_cache_key);
        if (!empty($html)) {
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
        //模板
        $templet = Product::get_use_templet('visa_index');
        $templet = $templet ? $templet : 'visa/index';
        $this->display($templet);

        //缓存内容
        $content = $this->response->body();
        Common::cache('set', $this->_cache_key, $content);
    }

    //详细页
    public function action_show()
    {
        $id = intval($this->request->param('aid'));
        $info = Model_Visa::visa_detail($id);
        if (empty($info['id'])) {
            $this->request->redirect('error/404');
        }
        //seo
        $seoInfo = Product::seo($info);
        //产品图片
        $info['piclist'] = Product::pic_list($info['piclist']);
        //属性列表
        $info['attrlist'] = Model_Visa::attr($info['attrid']);
        //点评数
        $info['commentnum'] = Model_Comment::get_comment_num($info['id'], $this->_typeid);
        //销售数量
        $info['sellnum'] = Model_Member_Order::get_sell_num($info['id'], $this->_typeid) + intval($info['bookcount']);
        //产品编号
        $info['series'] = St_Product::product_series($info['id'], 8);
        //产品图标
        $info['iconlist'] = Product::get_ico_list($info['iconlist']);

        $info['visatype'] = DB::select('kindname')->from('visa_kind')->where('id', '=', $info['visatype'])->execute()->get('kindname');
        //面签
        $info['interview'] = $info['needinterview'] == 0 ? '不需要' : ($info['needinterview'] == 1 ? "需要" : "领馆决定");
        //邀请函
        $info['letter'] = $info['needletter'] == 0 ? '不需要' : ($info['needletter'] == 1 ? "需要" : "领馆决定");
        //附件
        $info['attachment'] = unserialize($info['attachment']);

        $info['jifentprice_info'] = Model_Jifen_Price::get_used_jifentprice($info['jifentprice_id'], $this->_typeid);
        $info['jifenbook_info'] = Model_Jifen::get_used_jifenbook($info['jifenbook_id'], $this->_typeid);
        $info['jifencomment_info'] = Model_Jifen::get_used_jifencomment($this->_typeid);
        //支付方式
        $paytypeArr = explode(',', $GLOBALS['cfg_pay_type']);

        //扩展字段信息
        $extend_info = Model_Visa::visa_extend($info['id']);

        $materials = Model_Visa_Material::get_list(1);
        foreach ($materials as &$ma)
        {
            $ma['content'] = Model_Visa_Material_Content::get_content($info['id'], $ma['pinyin']);
        }
        $this->assign('seoinfo', $seoInfo);
        $this->assign('info', $info);
        $this->assign('tagword', $info["tagword"]);
        $this->assign('paytypeArr', $paytypeArr);
        $this->assign('extendinfo', $extend_info);
        $this->assign('materials', $materials);
        //模板
        $templet = Product::get_use_templet('visa_show');
        $templet = $templet ? $templet : 'visa/show';
        $this->display($templet);
        Product::update_click_rate($info['aid'], $this->_typeid);
        //缓存内容
        $content = $this->response->body();
        Common::cache('set', $this->_cache_key, $content);

    }


    //列表页
    public function action_list()
    {
        //参数值获取
        $countryPy = $this->request->param('countrypy');
        $sign = $this->request->param('sign');
        $cityId = intval($this->request->param('cityid'));
        $sortType = intval($this->request->param('sorttype'));
        $visaTypeid = intval($this->request->param('visatypeid'));
        $p = intval($this->request->param('p'));
        if (empty($countryPy)) exit;
        $pagesize = 10;
        $keyword = Arr::get($_GET, 'keyword');

        $route_array = array(
            'controller' => $this->request->controller(),
            'action' => $this->request->action(),
            'countrypy' => $countryPy,
            'cityid' => $cityId,
            'sorttype' => $sortType,
            'visatypeid' => $visaTypeid
        );
        //$start_time=microtime(true); //获取程序开始执行的时间

        $out = Model_Visa::search_result($route_array, $keyword, $p, $pagesize);
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

        //国家信息

        $country = DB::select()->from('visa_area')->where('pinyin', '=', $countryPy)->execute()->current();
        if (empty($country)) {
            $this->request->redirect('visa', '301');
        }

        $country['banner'] = $country['bigpic'] ? $country['bigpic'] : $GLOBALS['cfg_public_url'] . 'images/guojia_bg.jpg';
        $country['name'] = $country['kindname'];
        $country['nation_flag'] = $country['countrypic'] ? $country['countrypic'] : Product::get_default_image();


        //$end_time=microtime(true);

        //$total=$end_time-$start_time; //计算差值

        $seo_params = array(
            'countrypy' => $countryPy,
            'cityid' => $cityId,
            'visatypeid' => $visaTypeid,
            'p' => $p,
            'keyword' => $keyword
        );
        $searchTitle = Model_Visa::gen_seotitle($seo_params);

        $this->assign('country', $country);
        $this->assign('list', $out['list']);
        $this->assign('searchtitle', $searchTitle);
        $this->assign('param', $route_array);
        $this->assign('currentpage', $p);
        $this->assign('pageinfo', $pager);
        $templet = Product::get_use_templet('visa_list');
        $templet = $templet ? $templet : 'visa/list';
        $this->display($templet);
        //缓存内容
        $content = $this->response->body();
        Common::cache('set', $this->_cache_key, $content);
    }

    //签证预订
    public function action_book()
    {
        $userInfo = Product::get_login_user_info();
        //要求预订前必须登陆
        if (!empty($GLOBALS['cfg_login_order']) && empty($userInfo['mid'])) {
            $this->request->redirect(Common::get_main_host() . '/member/login/?redirecturl=' . urlencode(Common::get_current_url()));
        }
        $productId = intval(Arr::get($_GET, 'productid'));
        $useDate = Arr::get($_GET, 'usedate');
        $dingNum = intval(Arr::get($_GET, 'dingnum'));
        //防止空提交
        if (empty($productId)) {
            $this->request->redirect($this->request->referrer());
        }
        //产品信息
        $info = Model_Visa::visa_detail_id($productId);
        //产品编号
        $info['url'] = Common::get_web_url($info['webid']) . "/visa/show_{$info['aid']}.html";
        $info['series'] = St_Product::product_series($info['id'], 8);
        $info['usedate'] = $useDate;
        $info['visatype'] = DB::select('kindname')->from('visa_kind')->where('id', '=', $info['visatype'])->execute()->get('kindname');
        $info['dingnum'] = $dingNum;
        //frmcode
        $code = md5(time());
        Common::session('code', $code);
        //积分抵现所需积分
        $jifentprice_info = Model_Jifen_Price::get_used_jifentprice($info['jifentprice_id'], $this->_typeid);

        $this->assign('info', $info);
        $this->assign('userInfo', $userInfo);
        $this->assign('jifentprice_info', $jifentprice_info);
        $this->assign('frmcode', $code);
        $this->display('visa/book');
    }

    //保存订单
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
        $suitId = 0;
        $productId = intval(Arr::get($_POST, 'productid'));//产品id
        $useDate = Arr::get($_POST, 'usedate');//使用日期

        $linkMan = Arr::get($_POST, 'linkman');//联系人姓名
        $linkTel = Arr::get($_POST, 'linktel');//联系人电话
        $linkEmail = Arr::get($_POST, 'linkemail');//联系人邮箱

        $linkTel = empty($linkTel) && !empty($userInfo) ? $userInfo['mobile'] : $linkTel;
        $linkEmail = empty($linkEmail) && !empty($userInfo) ? $userInfo['email'] : $linkEmail;

        $remark = Arr::get($_POST, 'remark');//订单备注


        $payType = Arr::get($_POST, 'paytype');//支付方式
        $needJifen = intval($_POST['needjifen']);
        //检测订单有效性
        $check_result = common::before_order_check(array('model' => 'visa', 'productid' => $productId, 'suitid' => $suitId, 'day' => strtotime($useDate)));
        if (!$check_result) {
            $this->request->redirect('/tips/order');
        };
        //产品信息
        $info = Model_Visa::visa_detail_id($productId);
        $orderSn = Product::get_ordersn('08');
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
        $status = $info['paytype'] != 3 ? 1 : 0;

        $arr = array(
            'ordersn' => $orderSn,
            'webid' => $webid,
            'typeid' => $this->_typeid,
            'productautoid' => $info['id'],
            'productaid' => $info['aid'],
            'productname' => $info['title'],
            'price' => $info['price'],
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
            'dingjin' => $info['dingjin'],
            'paytype' => $info['paytype'],
            'suitid' => $suitId,
            'usejifen' => $useJifen,
            'needjifen' => $needJifen,
            'status' => $status,
            'remark' => $remark,
            'isneedpiao' => 0
        );

        //var_dump($arr);exit;
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
        if (St_Product::add_order($arr, 'Model_Visa', $arr['usedate'])) {
            Common::session('_platform', 'pc');
            $payurl = Common::get_main_host() . "/payment/?ordersn=" . $orderSn;
            $this->request->redirect($payurl);

        }
    }

    //首页按目的地读取区域
    public function action_ajax_index_area()
    {
        $destid = intval(Arr::get($_GET, 'areaid'));
        $pagesize = intval(Arr::get($_GET, 'pagesize'));
        $list = Model_Visa::vias_area_by_id($destid, $pagesize);
        foreach ($list as &$l) {
            $l['url'] = Common::get_web_url(0) . "/visa/{$l['pinyin']}/";
            $l['title'] = $l['kindname'];
        }
        echo json_encode(array('list' => $list));
    }

    /*
     * 异步获取国家名称
     */
    public function action_ajax_nation()
    {
        if (!$this->request->is_ajax()) exit;
        $keyword = Arr::get($_GET, 'keyword');
        $rule = "/^[a-zA-Z]+$/i";
        if (!preg_match($rule, $keyword)) {
            //按文字进行搜索
            $str = Model_Visa_Area::match_chinese($keyword);
        }
        else {
            //按拼音进行搜索
            $str = Model_Visa_Area::match_pinyin($keyword);
        }
        echo $str;

    }

    //异步获取区域拼音
    public function action_ajax_nation_pinyin()
    {
        if (!$this->request->is_ajax()) exit;
        $kindname = Arr::get($_POST, 'areaname');
        $pinyin = Model_Visa_Area::get_pinyin($kindname);
        echo json_encode(array('pinyin' => $pinyin));

    }


}