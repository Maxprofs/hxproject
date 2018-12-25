<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Class Controller_Line
 * 线路控制器
 */
class Controller_Mobile_Line extends Stourweb_Controller
{
    private $_typeid = 1;   //产品类型
    private $_cache_key = '';

    public function before()
    {

        parent::before();
        $this->_cache_key = Common::get_current_url();
        $html = Common::cache('get', $this->_cache_key);
        $genpage = intval(Arr::get($_GET, 'genpage'));
        if (!empty($html) && empty($genpage))
        {
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
        $this->display('../mobile/line/index', 'line_index');
        //缓存内容
        $content = $this->response->body();
        Common::cache('set', $this->_cache_key, $content);
    }

    /**
     * 线路搜索页
     */
    public function action_list()
    {


        //参数处理
        $urlParam = $this->request->param('params');
        $destPy = 'all';
        $dayId = $priceId = $sortType = $keyword = $attrId = $startcityId = 0;
        $params = explode('-', str_replace('/', '-', $urlParam));
        $count = count($params);
        switch ($count)
        {
            //目的地
            case 1:
                list($destPy) = $params;
                break;
            //关键字、属性
            case 8:
                list($destPy, $dayId, $priceId, $sortType, $keyword, $startcityId, $attrId, $page) = $params;
                break;
        }

        $keyword = Arr::get($_GET, 'keyword');
        $keyword = Common::remove_xss($keyword);
        $page = $page < 1 ? 1 : $page;

        $destname = $destPy != 'all' ? DB::select('kindname')->from('destinations')->where('pinyin', '=', $destPy)->execute()->get('kindname') : '目的地';
        $destid = $destPy != 'all' ? DB::select('id')->from('destinations')->where('pinyin', '=', $destPy)->execute()->get('id') : 0;
        $startcityname = $startcityId != 0 ? DB::select('cityname')->from('startplace')->where('id', '=', $startcityId)->execute()->get('cityname') : '出发地';
        //出发地
        $startcitylist = self:: _get_startcity();
        $this->assign('startcitylist', $startcitylist);

        //获取seo信息
        $seo = Model_Line::search_seo_mobile($destPy);

        $seo_params = array(
            'destpy' => $destPy,
            'dayid' => $dayId,
            'priceid' => $priceId,
            'sorttype' => $sortType,
            'startcityid' => $startcityId,
            'attrid' => $attrId,
            'p' => $page,

        );
        $search_title = Model_Line::gen_seotitle($seo_params);
        $header_title = $this->get_header_title($destPy);

        $this->assign('header_title',$header_title);
        $this->assign('search_title', $search_title);
        $this->assign('seoinfo', $seo);
        $this->assign('destpy', Common::remove_xss($destPy));
        $this->assign('destname', $destname);
        $this->assign('destid', $destid);
        $this->assign('dayid', intval($dayId));
        $this->assign('sorttype', intval($sortType));
        $this->assign('keyword', Common::remove_xss($keyword));
        $this->assign('attrid', Common::remove_xss($attrId));
        $this->assign('startcityid', intval($startcityId));
        $this->assign('startcityname', Common::remove_xss($startcityname));
        $this->assign('priceid', intval($priceId));
        $this->assign('page', $page);
        $this->display('../mobile/line/list', 'line_list');
        //缓存内容
        $content = $this->response->body();
        Common::cache('set', $this->_cache_key, $content);
    }

    /**
     * 线路搜索页(搜索初始页)
     */
    public function action_search()
    {
        $this->display('../mobile/line/search');
    }

    /**
     * 线路预订
     */
    public function action_book()
    {

        $userinfo = Model_Member_Login::check_login_info();
        $userinfo = Model_Member::get_member_byid($userinfo['mid']);
        //要求预订前必须登陆
        if (!empty($GLOBALS['cfg_login_order']) && empty($userinfo['mid']))
        {
            $cancel_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $this->cmsurl;
            $this->request->redirect(Common::get_main_host() . '/phone/member/login?redirecturl=' . urlencode(Common::get_current_url()) . '&cancelurl=' . urlencode($cancel_url));
        }
        $productid = $this->params['id'];
        $info = ORM::factory('line', $productid)->as_array();
        if(!$info['id'])
        {
            Common::head404();
        }
        $suitid = $this->params['suitid'];
        $usedate = $this->params['usedate'];
        $suitlist = Taglib_Line::suit(array('productid'=>$productid));
        $this->assign('suitlist',$suitlist);
        $this->assign('suitid',$suitid);
        $this->assign('usedate',$usedate);
        $this->assign('info',$info);
        $this->display('../mobile/line/book');


    }

    /*
     *预定下一步
     */
    public function action_over_book()
    {
        $userinfo = Model_Member_Login::check_login_info();
        $userinfo = Model_Member::get_member_byid($userinfo['mid']);
        //要求预订前必须登陆
        if (!empty($GLOBALS['cfg_login_order']) && empty($userinfo['mid']))
        {
            $cancel_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $this->cmsurl;
            $this->request->redirect(Common::get_main_host() . '/phone/member/login?redirecturl=' . urlencode(Common::get_current_url()) . '&cancelurl=' . urlencode($cancel_url));
        }

        $join_id = intval($_GET['join_id']);//拼团id
        $adult_num = intval($_GET['adult_num']);//成人
        $child_num = intval($_GET['child_num']);//小孩
        $old_num = intval($_GET['old_num']);//老人
        $roombalance_num = intval($_GET['roombalance_num']);//单房差
        $productid = intval($_GET['productid']);
        $suitid = intval($_GET['suitid']);
        $usedate = $_GET['usedate'];
        $suitPrice = Model_Line_Suit_Price::get_price_byday($suitid, strtotime($usedate));
        //如果没有报价，或者预定人数为0
        if(!$suitPrice[0]||(!$adult_num&&!$child_num&&!$old_num))
        {
            Common::head404();
        }

        $params = array(
            'dingnum'=>$adult_num,
            'childnum'=>$child_num,
            'oldnum'=>$old_num,
            'roombalancenum'=>$roombalance_num,
            'usedate'=>$usedate,
            'total'=>$adult_num+$child_num+$old_num,
            'join_id'=>$join_id
        );
        $info = ORM::factory('line', $productid)->as_array();
        if($info['contractid'])
        {
            $info['contract'] = Model_Contract::get_contents($info['contractid'],$this->_typeid);

            $url = St_Functions::get_web_url(0). '/contract/book_view/contract_id/'.$info['contractid'];

            $info['contract']['content'] = St_Network::http($url);
        }
        $info['lineseries'] = St_Product::product_series($info['id'], 1);
        $suitinfo = DB::select()->from('line_suit')->where('id','=',$suitid)->execute()->current();
        $jifentprice_info = Model_Jifen_Price::get_used_jifentprice($info['jifentprice_id'], $this->_typeid);
        $this->assign('jifentprice_info', $jifentprice_info);
        $this->assign('info', $info);
        $this->assign('suitinfo', $suitinfo);
        $this->assign('userinfo', $userinfo);
        $this->assign('params',$params);
        $this->assign('suitPrice', $suitPrice[0]);
        $member = Model_Member_Login::check_login_info();
        if (!empty($member))
        {
            $this->assign('member', Model_Member::get_member_byid($member['mid']));
        }
        $this->display('../mobile/line/over_book');


    }


    /*
  * 列表页筛选
  */
    public function action_searchnav()
    {

        $this->assign('typeid', $this->_typeid);
        $this->display('../mobile/line/searchnav');
    }

    /**
     * 创建订单
     */
    public function action_create()
    {
        St_Product::token_check($_POST) or Common::order_status();
        $refer_url = $_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : $this->cmsurl;
        //套餐id
        $suitid = Arr::get($_POST, 'suitid');
        //联系人
        $linkman = Arr::get($_POST, 'linkman');
        //手机号
        $linktel = Arr::get($_POST, 'linktel');
        $linkidcard = Arr::get($_POST, 'linkidcard');
        //备注信息
        $remark = Arr::get($_POST, 'remark');
        //产品id
        $id = Arr::get($_POST, 'productid');
        //出行时间
        $startdate = Arr::get($_POST, 'startdate');


        //成人数量
        $dingnum = Arr::get($_POST, 'dingnum');
        //小孩数量
        $childnum = Arr::get($_POST, 'childnum');
        //老人数量
        $oldnum = Arr::get($_POST, 'oldnum');

        $needJifen = $_POST['needjifen'];

        $join_id = intval($_POST['join_id']);//拼团id

        //验证部分
        $validataion = Validation::factory($_POST);
        $validataion->rule('linktel', 'not_empty');
        $validataion->rule('linktel', 'phone');
        $validataion->rule('linkman', 'not_empty');

        if (!$validataion->check())
        {
            $error = $validataion->errors();
            $keys = array_keys($validataion->errors());
            Common::message(array('message' => __("error_{$keys[0]}_{$error[$keys[0]][0]}"), 'jumpUrl' => $refer_url));
        }

        //发票
        $usebill = $_POST['usebill'];
        $invoice_type = $_POST['invoice_type'];
        $bill_info = array(
            'title' => $_POST['invoice_title'],
            'content' => $_POST['invoice_content'],
            'type' => $_POST['invoice_type'],
            'taxpayer_number' => $invoice_type!=0?$_POST['invoice_taxpayer_number']:'',
            'taxpayer_address' => $invoice_type==2?$_POST['invoice_taxpayer_address']:'',
            'taxpayer_phone' => $invoice_type==2?$_POST['invoice_taxpayer_phone']:'',
            'bank_branch' => $invoice_type==2?$_POST['invoice_bank_branch']:'',
            'bank_account' => $invoice_type==2?$_POST['invoice_bank_account']:'',
            'mobile' => $_POST['invoice_addr_phone'],
            'receiver' => $_POST['invoice_addr_receiver'],
            'postcode' => $_POST['invoice_addr_postcode'],
            'province' => $_POST['invoice_addr_province'],
            'city' => $_POST['invoice_addr_city'],
            'address' => $_POST['invoice_addr_address']
        );





        $info = ORM::factory('line')->where("id=$id")->find()->as_array();
        $suitArr = ORM::factory('line_suit')
            ->where("id=:suitid")
            ->param(':suitid', $suitid)
            ->find()
            ->as_array();
        $suitArr['dingjin'] = Currency_Tool::price($suitArr['dingjin']);
        $priceArr = DB::select()->from('line_suit_price')->where('day', '=', strtotime($startdate))->and_where('suitid', '=', $suitid)->execute()->current();

        $priceArr['adultprice'] = Currency_Tool::price($priceArr['adultprice']);
        $priceArr['childprice'] = Currency_Tool::price($priceArr['childprice']);
        $priceArr['oldprice'] = Currency_Tool::price($priceArr['oldprice']);


        //$suitArr
        $totalnum = $dingnum + $childnum + $oldnum;
        $storage = intval($priceArr['number']);
        if ($storage != -1 && $storage < $totalnum)
        {
            Common::message(array('message' => __("error_no_storage"), 'jumpUrl' => $refer_url));
            exit;
        }

        //下架状态判断
        if($info['status']!=3)
        {
            Common::message(array('message' => __("当前产品为下架状态,不可预订"), 'jumpUrl' => $refer_url));
            exit;
        }





        /*if ($suitArr['paytype'] == '3')//这里补充一个当为二次确认时,修改订单为未处理状态.
        {
            $info['status'] = 0;
        }
        else
        {
            $info['status'] = 1;
        }*/

        $info['name'] = $info['title'] . "({$suitArr['suitname']})";
        $info['paytype'] = $suitArr['paytype'];
        $info['dingjin'] = doubleval($suitArr['dingjin']);
        $info['ourprice'] = doubleval($priceArr['adultprice']);
        $info['childprice'] = doubleval($priceArr['childprice']);
        $info['oldprice'] = doubleval($priceArr['oldprice']);
        $info['usedate'] = $startdate;

        //游客信息
        $t_name = Arr::get($_POST, 't_tourername');
        $t_cardtype = Arr::get($_POST, 't_cardtype');
        $t_cardno = Arr::get($_POST, 't_cardnumber');
        $t_sex = Arr::get($_POST, 't_sex');
        $t_mobile = Arr::get($_POST, 't_mobile');
        $t_issave = Arr::get($_POST, 't_issave');
        $tourer = array();
        $totalNum = $dingnum + $childnum + $oldnum;

        for ($i = 1; $i <= $totalNum; $i++) {
            if (empty($t_name[$i])) {
                continue;
            }
            $tourer[] = array(
                'name' => $t_name[$i],
                'sex' => $t_sex[$i],
                'cardtype' => $t_cardtype[$i],
                'cardno' => $t_cardno[$i],
                'mobile' => $t_mobile[$i],
                'issave' =>$t_issave[$i]
            );
        }
        //积分抵现.
        $userInfo = Model_Member_Login::check_login_info();
        $userInfo = Model_Member::get_member_byid($userInfo['mid']);
        $jifentprice = 0;
        $useJifen = 0;
        if ($needJifen)
        {
            $jifentprice = Model_Jifen_Price::calculate_jifentprice($info['jifentprice_id'], $this->_typeid, $needJifen, $userInfo);
            $useJifen = empty($jifentprice) ? 0 : 1;
            $needJifen = empty($jifentprice) ? 0 : $needJifen;
        }
        //积分评论
        $jifencomment_info = Model_Jifen::get_used_jifencomment($this->_typeid);
        $jifencomment = empty($jifencomment_info) ? 0 : $jifencomment_info['value'];


        $ordersn = Product::get_ordersn('01');


        //自动关闭订单时间
        $auto_close_time = $suitArr['auto_close_time'] ? $suitArr['auto_close_time'] : 0;
        if($auto_close_time)
        {
            $auto_close_time = strtotime("+{$auto_close_time} hours");
        }





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
            'childnum' => $childnum,
            'oldprice' => $info['oldprice'],
            'oldnum' => $oldnum,
            'linkman' => $linkman,
            'linktel' => $linktel,
            'linkidcard' => $linkidcard,
            'suitid' => $suitid,
            'remark' => $remark,
            'status' => $suitArr['need_confirm'] ? 0:1,
            'usejifen' => $useJifen,
            'needjifen' => $needJifen,
            'roombalance' => $priceArr['roombalance'],
            'roombalancenum' => intval($_POST['roombalance_num']),
            'roombalance_paytype' => intval($_POST['roombalance_paytype']),
            'source' => 2,//来源手机,
            'pay_way' => $suitArr['pay_way'],//支付方式
            'need_confirm' => $suitArr['need_confirm'] ? $suitArr['need_confirm'] : 0 ,//是否需要确认.
            'auto_close_time' =>$auto_close_time //自动关闭订单时间
        );
        /*--------------------------------------------------------------优惠券信息------------------------------------------------------------*/
        //优惠券判断
        $croleid = intval(Arr::get($_POST, 'couponid'));
        if ($croleid)
        {
            $cid = DB::select('cid')->from('member_coupon')->where("id=$croleid")->execute()->current();
            $totalprice = Model_Coupon::get_order_totalprice($arr);
            $ischeck = Model_Coupon::check_samount($croleid, $totalprice, $this->_typeid, $info['id'], $startdate);
            if ($ischeck['status'] == 1)
            {
                Model_Coupon::add_coupon_order($cid, $ordersn, $totalprice, $ischeck, $croleid); //添加订单优惠券信息
            }
            else
            {
                exit('coupon  verification failed!');//优惠券不满足条件
            }
        }
        /*-----------------------------------------------------------------优惠券信息--------------------------------------*/
        //合同判断
        if($info['contractid'])
        {
            $contract = Model_Contract::get_contents($info['contractid'],$this->_typeid);
            if($contract)
            {
                $arr['contract_id'] = $info['contractid'];
            }
        }


        //添加订单
        if (St_Product::add_order($arr, 'Model_Line', $arr))
        {
            //添加拼团
            if(St_Functions::is_normal_app_install('together'))
            {
                Model_Together::join_together($ordersn,$this->_typeid,$arr['productautoid'],$join_id);
            }
            //添加红包
            if(St_Functions::is_normal_app_install('red_envelope'))
            {
                $envelope_member_id = intval($_POST['envelope_member_id']);
                if($envelope_member_id&&$member['mid'])
                {
                    Model_Order_Envelope::order_use_envelope($envelope_member_id,$ordersn,$this->_typeid,$member['mid']);
                }
            }


            St_Product::delete_token();
            $orderInfo = Model_Member_Order::get_order_by_ordersn($ordersn);
            Model_Member_Order_Tourer::add_tourer_pc($orderInfo['id'], $tourer,$orderInfo['memberid']);

            if ($usebill)
            {
                Model_Member_Order_Bill::add_bill_info($orderInfo['id'], $bill_info);
            }

            //如果是立即支付则执行支付操作,否则跳转到产品详情页面

            $html = Common::payment_from(array('ordersn' => $ordersn));
            if ($html)
            {
                echo $html;
            }
        }
    }

    /**
     * 线路内容页
     */
    public function action_show()
    {
        $id = intval($this->request->param('aid'));
        //子站内容显示
        if (isset($_GET['webid']))
        {
            $GLOBALS['sys_webid'] = intval(Arr::get($_GET, 'webid'));
        }
        //线路详情
        $info = Model_Line::detail($id);
        //301重定向
        if (!empty($info['redirect_url']))
        {
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: {$info['redirect_url']}");
            exit();
        }

        if(empty($info))
        {
            Common::head_404();
        }


        //点击率加一
        Product::update_click_rate($id, $this->_typeid);
        //seo
        $seoInfo = Product::seo($info);
        //产品图片
        $info['piclist'] = Product::pic_list($info['piclist']);
        //属性列表
        $info['attrlist'] = Model_Line::line_attr($info['attrid']);
        //最低价
        $info['price'] = Model_Line::get_minprice($info['id'], array('info', $info));
        //出发城市
        $info['startcity'] = Model_Startplace::start_city($info['startcity']);
        //行程附件
        // $info['linedoc'] = unserialize($info['linedoc']);
        //点评数
        $info['commentnum'] = Model_Comment::get_comment_num($info['id'], $this->_typeid);
        //满意度
        $info['satisfyscore'] = St_Functions::get_satisfy($this->_typeid, $info['id'], $info['satisfyscore']);
        //销售数量
        $info['sellnum'] = Model_Member_Order::get_sell_num($info['id'], $this->_typeid) + intval($info['bookcount']);
        //产品编号
        $info['lineseries'] = St_Product::product_series($info['id'], 1);
        //市场价
        $info['sellprice'] = $info['storeprice'] ? $info['storeprice'] : 0;

        //产品图标
        $info['iconlist'] = Product::get_ico_list($info['iconlist']);

        //供应商
        $info['suppliers']=null;
        if($info['supplierlist'])
        {
            $info['suppliers'] = DB::query(1, "SELECT suppliername FROM `sline_supplier` WHERE id={$info['supplierlist']}")->execute()->current();
        }

        //行程附件
        $info['linedoc'] = unserialize($info['linedoc']);
        $this->assign('seoinfo', $seoInfo);
        $this->assign('info', $info);

        $template = Model_Line::get_product_template($info,true);
        $user_tpl = $template ?  true : false;
        $user_tpl ? $show_templat = $template : $show_templat = '../mobile/line/show';
        $this->display($show_templat, 'line_show',$user_tpl);

        //缓存内容
        $content = $this->response->body();
        Common::cache('set', $this->_cache_key, $content);
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
        if ($destpy != 'all')
        {
            $dest_info = DB::select()->from('destinations')->where('pinyin', '=', $destpy)->execute()->current();
            $subnum = DB::select(array(DB::expr("count(*)"), 'num'))->from('destinations')->where('pid', '=', $dest_info['id'])->and_where('isopen', '=', 1)->and_where(DB::expr("FIND_IN_SET({$typeid},opentypeids)"), '>', 0)->execute()->get('num');
            $pid = $isparent == 1 || $subnum <= 0 ? $dest_info['pid'] : $dest_info['id'];
        }
        $parents = null;
        if ($pid != 0)
        {
            $parents = Model_Destinations::get_parents($pid);
            $parents = array_reverse($parents);
            $parents[] = $dest_info;
        }
        $list = DB::select('id', 'pinyin', 'kindname')->from('destinations')->where('isopen', '=', 1)->and_where('pid', '=', $pid)->and_where(DB::expr("FIND_IN_SET({$typeid},opentypeids)"), '>', 0)->execute()->as_array();
        foreach ($list as &$child)
        {
            $child['subnum'] = DB::select(array(DB::expr("count(*)"), 'num'))->from('destinations')->where('pid', '=', $child['id'])->and_where('isopen', '=', 1)->and_where(DB::expr("FIND_IN_SET({$typeid},opentypeids)"), '>', 0)->execute()->get('num');
        }
        $parent = DB::select('id', 'kindname', 'pinyin')->from('destinations')->where('id', '=', $pid)->execute()->current();
        echo json_encode(array('status' => true, 'list' => $list, 'parents' => $parents, 'parent' => $parent));
    }

    /**
     * 获取套餐人群
     */
    public function action_ajax_suit_people()
    {
        $out = array();
        $suitid = intval(Arr::get($_GET, 'suitid'));
        $productid = intval(Arr::get($_GET, 'productid'));
        $row = DB::select()->from('line_suit')->where('id','=',$suitid)->execute()->current();
        $row['description'] = Product::strip_style($row['description']);
        switch ($row['paytype'])
        {
            case 1:
                $row['paytype_name']= '全款支付';
                break;
            case 2:
                $row['paytype_name']= '定金支付';
                break;
            case 3:
                $row['paytype_name']= '二次确认';
                break;

        }
        //获取最接近当前日期的报价
        $day = strtotime(date('Y-m-d'));
        //线路提前预定
        $ext = array();
        $info = DB::select('islinebefore', 'linebefore')->from('line')->where('id', '=', $productid)->execute()->current();
        $ext['islinebefore'] = $info['islinebefore'];
        $ext['linebefore'] = $info['linebefore'];
        if ($ext['islinebefore'] > 0 && $ext['linebefore'] > 0)
        {
            $day = strtotime("+{$ext['linebefore']} days", $day);
        }
        $ar = Model_Line_Suit_Price::get_price_byday($suitid, $day);

        if ($ar[0])
        {
            $out['useday'] = date('Y-m-d', $ar[0]['day']);//当前使用日期.
            $out['storage'] = $ar[0]['number'];//库存
            $out['roombalance'] = $ar[0]['roombalance'];
        }
        $group_arr = explode(',',$ar[0]['propgroup']);
        if (in_array(1, $group_arr))
        {
            $out['haschild'] = 1;
            $out['childprice'] = $ar[0]['childprice'] ? $ar[0]['childprice'] : 0;
        }
        if (in_array(2, $group_arr))
        {
            $out['hasadult'] = 1;
            $out['adultprice'] = $ar[0]['adultprice'] ? $ar[0]['adultprice'] : 0;
        }
        if (in_array(3, $group_arr))
        {
            $out['hasold'] = 1;
            $out['oldprice'] = $ar[0]['oldprice'] ? $ar[0]['oldprice'] : 0;
        }
        $out['row'] = $row;

        $hasprice = DB::select(DB::expr('count(*) as num'))->from('line_suit_price')
            ->where('lineid','=',$productid)->and_where('suitid','=',$suitid)
            ->execute()->get('num');
        $out['hasprice']= $hasprice;
        echo json_encode($out);
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
        if ($member)
        {
            $userInfo = Model_Member::get_member_byid($member['mid']);
            $jifen['isopen'] = 1;
            $jifen['exchange'] = $GLOBALS['cfg_exchange_jifen'];
            $jifen['userjifen'] = $userInfo['jifen'];
            if (empty($jifen['exchange']))
            {
                $bool = false;
            }
        }
        $this->assign('jifen', $jifen);
        /*******************************新增优惠券********************************/
        if (St_Functions::is_normal_app_install('coupon'))
        {
            $typeid = intval($this->request->param('typeid'));
            $proid = intval($this->request->param('productid'));
            $couponlist = Model_Coupon::get_pro_coupon($typeid, $proid);
            if ($couponlist)
            {
                $bool = true;
                $this->assign('couponlist', $couponlist);
            }
        }
        $this->assign('typeid', $this->_typeid);

        if ($bool)
        {
            $this->display('../mobile/line/discount');
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
        $ext = array();
        $info = DB::select('islinebefore', 'linebefore')->from('line')->where('id', '=', $productid)->execute()->current();
        $ext['islinebefore'] = $info['islinebefore'];
        $ext['linebefore'] = $info['linebefore'];
        if ($ext['islinebefore'] > 0 && $ext['linebefore'] > 0)
        {
            $day = strtotime("+{$ext['linebefore']} days", $day);
        }
        $startdate = $startdate ? $startdate : date('Y-m-d', $day);

        for ($i = 1; $i <= 24; $i++)
        {
            if ($month == 13)
            {
                $year = $year + 1;
                $month = 1;
            }
            $price_arr = Model_Line::get_month_price($year, $month, $suitid, $startdate);
            $cfg_line_minprice_rule = $GLOBALS['cfg_line_minprice_rule'];
            foreach ($price_arr as &$v)
            {

                $adultprice = $v['price'];
                $childprice = $v['child_price'];
                $oldprice = $v['old_price'];
                $minprice = $adultprice;
                $minprice = (floatval($childprice) < floatval($minprice) && $childprice > 0) || empty($minprice) ? $childprice : $minprice;
                $minprice = (floatval($oldprice) < floatval($minprice) && $oldprice > 0) || empty($minprice) > 0 ? $oldprice : $minprice;

                switch ($cfg_line_minprice_rule)
                {
                    case 1:
                        $price = $childprice;
                        break;
                    case 2:
                        $price = $adultprice;
                        break;
                    case 3:
                        $price = $oldprice;
                        break;
                    default:
                        $price = $adultprice;
                        break;
                }
                $price = empty($price) ? $minprice : $price;
                $v['price'] = $price;
                $v['adult_price'] = $adultprice;
            }


            $out .= empty($price_arr) ? '' : self::gen_price_calendar_html($year, $month, $price_arr);
            $month++;
        }
        echo $out;

    }



    //获取报价日历html新版
    public function action_ajax_price_calendar_new()
    {
        $suitid = $_GET['suitid'];
        $productid = $_GET['productid'];
        $startdate = $_GET['date'];
        $info = DB::select('islinebefore', 'linebefore')->from('line')->where('id', '=', $productid)->execute()->current();
        $ext = array();
        $ext['islinebefore'] = $info['islinebefore'];
        $ext['linebefore'] = $info['linebefore'];
        $out = '';
        if(!$startdate)
        {
            $startday = date('Y-m-d');
            $year = $_GET['year'] ;
            $month = $_GET['month'] ;
            //线路提前预定
            $day = strtotime($startday);

            if ($ext['islinebefore'] > 0 && $ext['linebefore'] > 0)
            {
                $day = strtotime("+{$ext['linebefore']} days", $day);
            }
            if(!$month||!$year)
            {
                $year = date('Y',$day);
                $month = date('m',$day);
            }

            $startdate =   date('Y-m-d', $day);
        }
        else
        {
            $day = strtotime($startdate);
            $year = date('Y',$day);
            $month = date('m',$day);
        }
        $price_arr = Model_Line::get_month_price($year, $month, $suitid, $startdate);
        $cfg_line_minprice_rule = $GLOBALS['cfg_line_minprice_rule'];
        foreach ($price_arr as &$v)
        {
            $adultprice = $v['price'];
            $childprice = $v['child_price'];
            $oldprice = $v['old_price'];
            $minprice = $adultprice;
            $minprice = (floatval($childprice) < floatval($minprice) && $childprice > 0) || empty($minprice) ? $childprice : $minprice;
            $minprice = (floatval($oldprice) < floatval($minprice) && $oldprice > 0) || empty($minprice) > 0 ? $oldprice : $minprice;
            switch ($cfg_line_minprice_rule)
            {
                case 1:
                    $price = $childprice;
                    break;
                case 2:
                    $price = $adultprice;
                    break;
                case 3:
                    $price = $oldprice;
                    break;
                default:
                    $price = $adultprice;
                    break;
            }
            $price = empty($price) ? $minprice : $price;
            $v['price'] = $price;
            $v['adult_price'] = $adultprice;
        }
        $out .= '<div class="calendar-tit-bar">选择日期';
        if($ext['islinebefore'])
        {
            $out .= '<span class="jy">建议提前'.$ext['linebefore'].'天预定</span>';
        }
        $out .= '</div>';
        $out .=  self::gen_price_calendar_html_new($year, $month, $price_arr);
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


        for ($j = 1; $j <= 8; $j++)
        {
            $html .= '<tr class="calendar-bd">';
            for ($i = 1; $i <= 7; $i++)
            {

                $number = ($j - 1) * 7 + $i;
                $cur_day_time = $first_day_time + ($number - $start_week) * 24 * 3600;
                $cur_date = date('Y-m-d', $cur_day_time);
                $cur_day = date('j', $cur_day_time);
                $price_info = $price_arr[$cur_day_time];
                if ($cur_day_time < $first_day_time || $cur_day_time > $last_day_time)
                {
                    $html .= '<td><div class="item"></div></td>';
                }
                else if (empty($price_info))
                {
                    $html .= '<td><div class="item opt"><span class="date">' . $cur_day . '</span></div></td>';
                }
                else if (!empty($price_info))
                {

                    $html .= '<td adultprice="' . $price_info['adult_price'] . '" childprice="' . $price_info['child_price'] . '" oldprice="' . $price_info['old_price'] . '" number="' . $price_info['number'] . '" roombalance="' . $price_info['roombalance'] . '" date="' . $cur_date . '"  onclick="choose_day(this)">';
                    $html .= '<div class="item opt"><span class="date">' . $cur_day . '</span>';
                    $html .= '<span class="price">' . $currency_symbol . $price_info['price'] . '<br></span>';
                    $stock = $price_info['number'] == '-1' ? '库存充足' : $price_info['number'];
                    $html .= '<span class="stock">' . $stock . '</span>';
                    $html .= '</div></td>';
                }

            }
            $html .= '</tr>';
            if ($cur_day_time && $cur_day_time > $last_day_time)
            {
                break;
            }
        }

        $html .= '</table></div>';
        return $html;


    }


    public static function gen_price_calendar_html_new($year, $month, $price_arr)
    {

        $first_day_time = strtotime($year . '-' . $month . '-' . '01');
        $last_day_time = strtotime(date('Y-m-d', $first_day_time) . " +1 month -1 day");
        $start_week = date('w', $first_day_time);
        $start_week = $start_week == 0 ? 7 : $start_week;
        $prevyear = date('Y',strtotime(date('Y-m-d', $first_day_time) . " -1 month "));
        $prevmonth = date('m',strtotime(date('Y-m-d', $first_day_time) . " -1 month "));
        $nextyear = date('Y',strtotime(date('Y-m-d', $first_day_time) . " +1 month "));
        $nextmonth = date('m',strtotime(date('Y-m-d', $first_day_time) . " +1 month "));


        $currency_symbol = Currency_Tool::symbol();
        $html = '<div class="calendar-date">
            <a class="calendar-prev"  data-year="'.$prevyear.'"  data-month="'.$prevmonth.'"  href="javascript:;"></a>
            <strong class="calendar-cur">'. date('Y年m月', $first_day_time) .'</strong>
            <a class="calendar-next" data-year="'.$nextyear.'"  data-month="'.$nextmonth.'"  href="javascript:;"></a>
        </div><div class="calendar-wrap"><table width="100%">';
        $html .= '<tr class="calendar-hd"><th>一</th><th>二</th><th>三</th><th>四</th><th>五</th><th>六</th><th>日</th></tr>';


        for ($j = 1; $j <= 8; $j++)
        {
            $html .= '<tr class="calendar-bd">';
            for ($i = 1; $i <= 7; $i++)
            {

                $number = ($j - 1) * 7 + $i;
                $cur_day_time = $first_day_time + ($number - $start_week) * 24 * 3600;
                $cur_date = date('Y-m-d', $cur_day_time);
                $cur_day = date('j', $cur_day_time);
                $price_info = $price_arr[$cur_day_time];
                if ($cur_day_time < $first_day_time || $cur_day_time > $last_day_time)
                {
                    $html .= '<td><div class="item"></div></td>';
                }
                else if (empty($price_info))
                {
                    $html .= '<td><div class="item opt"><span class="date">' . $cur_day . '</span></div></td>';
                }
                else if (!empty($price_info))
                {

                    $html .= '<td adultprice="' . $price_info['adult_price'] . '" childprice="' . $price_info['child_price'] . '" oldprice="' . $price_info['old_price'] . '" number="' . $price_info['number'] . '" roombalance="' . $price_info['roombalance'] . '" date="' . $cur_date . '"  onclick="choose_day(this)">';
                    $html .= '<div class="item opt"><span class="date">' . $cur_day . '</span>';
                    $html .= '<span class="price">' . $currency_symbol . $price_info['price'] . '<br></span>';
                    $stock = $price_info['number'] == '-1' ? '余位充足' : '余位'.$price_info['number'];
                    $html .= '<span class="stock">' . $stock . '</span>';
                    $html .= '</div></td>';
                }

            }
            $html .= '</tr>';
            if ($cur_day_time && $cur_day_time > $last_day_time)
            {
                break;
            }
        }

        $html .= '</table></div>';
        return $html;


    }


    /**
     * 按天获取报价与库存.
     */
    public static function action_ajax_price_day()
    {
        $useday = strtotime(Arr::get($_GET, 'useday'));
        $suitid = intval(Arr::get($_GET, 'suitid'));
        $ar = Model_Line_Suit_Price::get_price_byday($suitid, $useday);
        echo json_encode($ar[0]);
    }

    /**
     * ajax请求 加载更多
     */
    public function action_ajax_line_more()
    {
        $urlParam = $this->request->param('params');
        $keyword = Arr::get($_GET, 'keyword') ? Arr::get($_GET, 'keyword') : '';
        $keyword = Common::remove_xss($keyword);
        $data = Model_Line::search_result_mobile($urlParam, $keyword);
        echo($data);
    }

    /**
     * 获取下级出发地
     */
    private function _get_startcity()
    {

        //获取下级出发地
        $result = DB::select('id', 'cityname')->from('startplace')->where('pid', '!=', 0)->and_where('isopen', '=', 1)->order_by(displayorder)->execute()->as_array();
        return $result;
    }

    private function get_header_title($dest_py)
    {
        $channel_name  = Model_Nav::get_channel_name_mobile($this->_typeid);
        $dest_name = DB::select('kindname')->from('destinations')->where('pinyin', '=', $dest_py)->execute()->get('kindname');

        return $dest_name.$channel_name;

    }

}