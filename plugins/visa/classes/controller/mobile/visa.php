<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Class Controller_Visa 签证
 */
class Controller_Mobile_Visa extends Stourweb_Controller
{
    private $_typeid = 8;   //产品类型
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

    /**
     * 线路首页
     */
    public function action_index()
    {
        $seoinfo = Model_Nav::get_channel_seo_mobile($this->_typeid);
        $this->assign('seoinfo', $seoinfo);
        $this->display('../mobile/visa/index', 'visa_index');
        //缓存内容
        $content = $this->response->body();
        Common::cache('set', $this->_cache_key, $content);
    }

    /**
     * 线路列表URL
     */
    public function action_list()
    {


        $uri = $this->request->param('params');
        $data = $this->_explode_url($uri);
        //判断是否是搜索的区域.
        $show_area=0;
        //是否显示区域选择(默认不显示)
        if($data['area']=='all'&&!isset($_GET['country']))
        {
            $show_area=1;
        }
        if(isset($_GET['country']))
        {
            $data['area'] = Model_Visa::get_visa_area_pinyin($_GET['country']);
        }
        $area = Model_Visa::vias_area($data['area']);
        if (!empty($area))
        {
            $area['litpic'] = Common::img($area['litpic'], 220, 150);
            $area['summary'] = St_String::cut_html_str(strip_tags($area['jieshao']), 30, '...');
            $area['title'] = $area['kindname'] . '_' . $this->channelname;
        }

        $city = Model_Visa::visa_city();
        $seoInfo = Model_Visa::search_seo_mobile($data['area']);
        $this->assign('show_area', $show_area);
        $this->assign('seoinfo', $seoInfo);
        $this->assign('area', $area);
        $this->assign('city', $city);
        $this->assign('areapy', $data['area']);
        $this->assign('page', $data['page']);
        $this->assign('cityid', $data['cityid']);
        $this->assign('visatype', $data['visatype']);
        $this->display('../mobile/visa/list', 'visa_list');
        //缓存内容
        $content = $this->response->body();
        Common::cache('set', $this->_cache_key, $content);
    }

    /**
     * 签证搜索
     */
    public function action_search()
    {
        $seoinfo = Model_Nav::get_channel_seo_mobile($this->_typeid);
        $this->assign('seoinfo', $seoinfo);
        $this->display('../mobile/visa/search');
    }

    public
    function action_searchnav()
    {
        $this->assign('typeid', $this->_typeid);
        $this->display('../mobile/visa/searchnav');
    }

    /**
     * 分隔URL参数 visa/area-cityid-typeid-page
     * @return mixed
     */
    private function _explode_url($uri)
    {
        $params = explode('-', str_replace('/', '-', Common::remove_xss($uri)));
        $count = count($params);
        if ($count == 0) {
            exit;
        }
        switch ($count) {
            case 1:
                list($data['area']) = $params;
                $data['cityid'] = $data['typeid'] = 0;
                break;
            case 2:
                list($data['area'], $data['cityid']) = $params;
                $data['typeid'] = 0;
                break;
            case 3:
                list($data['area'], $data['cityid'], $data['visatype']) = $params;
                break;
            case 4:
                list($data['area'], $data['cityid'], $data['visatype'], $data['page']) = $params;
                break;
        }
        //分页
        $data['page'] = empty($data['page']) ? 1 : $data['page'];
        return $data;
    }

    /**
     * AJAX 获取签证列表数据
     */
    public function action_ajax_visa_more()
    {
        $params = $this->request->param('params');
        $uri = $this->_explode_url($params);

        $data = $this->visa_data($uri);
        echo Product::list_search_format($data, $uri['page']);
    }

    public function action_ajax_area()
    {
        $params = Common::remove_xss($_POST['area']);
        $data = Model_Visa::vias_area($params, 'kindname');
        echo empty($data) ? '0' : Common::get_web_url($GLOBALS['$sys_webid']) . "/visa/{$data['pinyin']}";
    }

    /**
     * 签证列表数据
     * @param $uri
     * @return mixed
     */
    private function visa_data($uri)
    {
        $data = Model_Visa::parse_url($uri['area'], $uri['cityid'], $uri['page'], $uri['visatype']);
        foreach ($data as &$v) {
            $v['url'] = Common::get_web_url($v['webid']) . "/visa/show_{$v['aid']}.html";
            $v['litpic'] = Common::img($v['litpic'], 220, 150);
            $v['satisfyscore'] = Model_Comment::get_score($v['id'], $this->_typeid, $v['satisfyscore'], $v['commentnum']);//满意度
            $v['sellnum'] = Model_Member_Order::get_sell_num($v['id'], $this->_typeid) + intval($v['bookcount']);
            $city = Model_Visa::visa_city_by_id($v['cityid']);
            if (is_array($city)) {
                $city = $city['kindname'];
            }
            $v['city'] = $city;
        }
        return $data;
    }

    /**
     * 签证详情
     */
    public function action_show()
    {
        $aid = intval($this->request->param('aid'));
        //子站内容显示
        if (isset($_GET['webid'])) {
            $GLOBALS['sys_webid'] = intval(Arr::get($_GET, 'webid'));
        }
        $info = Model_Visa::visa_detail($aid);
        if (empty($info['id'])) {
            Common::head_404();
        }
        //点击率加一
        Product::update_click_rate($aid, $this->_typeid);
        $info['commentnum'] = Model_Comment::get_comment_num($info['id'], $this->_typeid);
        $info['satisfyscore'] = Model_Comment::get_score($info['id'], $this->_typeid, $info['satisfyscore'], $info['commentnum']);//满意度
        $info['sellnum'] = Model_Member_Order::get_sell_num($info['id'], $this->_typeid) + intval($info['bookcount']);
        $info['attachment'] = unserialize($info['attachment']);
        $info['kindname'] = DB::select('kindname')->from('visa_kind')->where('id', '=', $info['visatype'])->execute()->get('kindname');
        //产品图标
        $info['iconlist'] = Product::get_ico_list($info['iconlist']);
        $extend_info = Model_Visa::visa_extend($info['id']);
        //供应商
        $info['suppliers']=null;
        if($info['supplierlist'])
        {
            $info['suppliers'] = DB::query(1, "SELECT suppliername FROM `sline_supplier` WHERE id={$info['supplierlist']}")->execute()->current();
        }
        $seoInfo = Product::seo($info);

        $materials = Model_Visa_Material::get_list(1);
        $is_show_material = false;
        foreach ($materials as &$ma)
        {
            $content = Model_Visa_Material_Content::get_content($info['id'], $ma['pinyin']);
            $ma['content'] = $content;
            if ($content)
            {
                $is_show_material = true;
            }
        }

        $this->assign('info', $info);
        $this->assign('seoinfo', $seoInfo);
        $this->assign('extendinfo', $extend_info);
        $this->assign('materials', $materials);
        $this->assign('is_show_material', $is_show_material);

        $this->display('../mobile/visa/show', 'visa_show');
        //缓存内容
        $content = $this->response->body();
        Common::cache('set', $this->_cache_key, $content);
    }

    /**
     * 签证预订
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
        $productid = Common::remove_xss($this->params['id']);
        $info = ORM::factory('visa', $productid)->as_array();
        $info['price'] = Currency_Tool::price($info['price']);
        $info['litpic'] = Common::img($info['litpic'], 150, 90);

        $jifentprice_info = Model_Jifen_Price::get_used_jifentprice($info['jifentprice_id'], $this->_typeid);
        $this->assign('jifentprice_info', $jifentprice_info);
        $this->assign('info', $info);
        $this->assign('userinfo', $userinfo);
        $member = Model_Member_Login::check_login_info();
        if (!empty($member)) {
            $this->assign('member', Model_Member::get_member_byid($member['mid']));
        }
        $this->display('../mobile/visa/book');
    }

    /**
     * 团购订单
     */
    public function action_create()
    {
        St_Product::token_check($_POST) or Common::order_status();
        $refer_url = $_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : $this->cmsurl;
        //联系人
        $linkman = Arr::get($_POST, 'linkman');
        //预定时间
        $usedate = Arr::get($_POST, 'usedate');
        //手机号
        $linktel = Arr::get($_POST, 'linktel');
        //身份证
        $linkidcard = Arr::get($_POST, 'linkidcard');
        //备注信息
        $remark = Arr::get($_POST, 'remark');
        //产品id
        $id = intval(Arr::get($_POST, 'productid'));
        //预订数量
        $dingnum = intval(Arr::get($_POST, 'dingnum'));

        $needJifen = $_POST['needjifen'];
        //验证部分
        $validataion = Validation::factory($_POST);
        $validataion->rule('linktel', 'not_empty');
        $validataion->rule('linktel', 'phone');
        $validataion->rule('linkman', 'not_empty');
        $validataion->rule('dingnum', 'regex', array(':value', '/^[1-9]+$/'));
        if (!$validataion->check()) {
            $error = $validataion->errors();
            $keys = array_keys($validataion->errors());
            Common::message(array('message' => __("error_{$keys[0]}_{$error[$keys[0]][0]}"), 'jumpUrl' => $refer_url));
        }
        //二次验证
        $info = Model_Visa::visa_detail_id(intval($id));
        if ($info['paytype'] == '3')//这里补充一个当为二次确认时,修改订单为未处理状态.
        {

            $info['status'] = 0;

        }
        else {

            $info['status'] = 1;

        }

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
        //合并生成订单
        $ordersn = Product::get_ordersn('08');
        $arr = array(
            'ordersn' => $ordersn,
            'webid' => 0,
            'typeid' => $this->_typeid,
            'productautoid' => $id,
            'productaid' => $info['aid'],
            'productname' => $info['title'],
            'litpic' => $info['litpic'],
            'price' => $info['price'],
            'childprice' => $info['childprice'],
            'jifentprice' => $jifentprice,
            'jifenbook' => $info['jifenbook_id'],
            'jifencomment' => $jifencomment,
            'paytype' => $info['paytype'],
            'dingjin' => $info['dingjin'],
            'usedate' => $usedate,
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
            'suitid' => 0,
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
            $ischeck = Model_Coupon::check_samount($croleid, $totalprice, $this->_typeid, $info['id'], $usedate);
            if ($ischeck['status'] == 1) {
                Model_Coupon::add_coupon_order($cid, $ordersn, $totalprice, $ischeck, $croleid); //添加订单优惠券信息
            }
            else {
                exit('coupon  verification failed!');//优惠券不满足条件
            }
        }
        /*-----------------------------------------------------------------优惠券信息--------------------------------------*/


        //添加订单,跳转支付
        if (St_Product::add_order($arr, 'Model_Visa')) {
            St_Product::delete_token();
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
            $this->display('../mobile/visa/discount');
        }


    }
}