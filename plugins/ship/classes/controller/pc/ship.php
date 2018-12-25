<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Pc_Ship extends Stourweb_Controller
{
    /*
     * 租车总控制器
     * */

    private $_typeid = 104;
    private $_cache_key = '';

    public function before()
    {
        parent::before();
        //检查缓存
         $this->_cache_key = Common::get_current_url();
          $html = Common::cache('get', $this->_cache_key);
          $genpage = Common::remove_xss(Arr::get($_GET, 'genpage'));
        if (!empty($html) && empty($genpage))
        {
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
        $total = Model_Member_Order::get_sell_num(0, $this->_typeid);
        $this->assign('totalorder', $total);
        $this->assign('seoinfo', $seoinfo);
        $templet = Product::get_use_templet('ship_index');
        $templet = $templet ? $templet : 'ship/index';
        $this->display($templet);
        //缓存内容
          $content = $this->response->body();
         Common::cache('set', $this->_cache_key, $content);

    }

    //详细页
    public function action_show()
    {

        $aid = intval($this->request->param('aid'));

        $info = ORM::factory('ship_line')->where('aid', '=', $aid)->and_where('webid', '=', $GLOBALS['sys_webid'])->find()->as_array();

        //seo
        $seoInfo = Product::seo($info);
        //产品图片
        $info['piclist'] = Product::pic_list($info['piclist']);
        //属性列表
        $info['attrlist'] = Model_Ship_Line::line_attr($info['attrid']);
        //最低价
        $info['priceinfo'] = Model_Ship_Line::get_minprice($info['id'], array('info', $info),1);

        //点评数
        $info['commentnum'] = Model_Comment::get_comment_num($info['id'], $this->_typeid);
        //销售数量
        $info['sellnum'] = Model_Member_Order::get_sell_num($info['id'], $this->_typeid) + intval($info['bookcount']);
        //产品编号
        $info['series'] = St_Product::product_series($info['id'], $this->_typeid);
        //产品图标
        $info['iconlist'] = Product::get_ico_list($info['iconlist']);
        //最新航线

        $info['lastest_line'] =  Model_Ship_Line::get_starttime($info['id']);


        $info['schedule_name'] =  DB::select('title')->from('ship_schedule')->where('id','=',$info['scheduleid'])->execute()->get('title');
        $info['satisfyscore'] = St_Functions::get_satisfy($this->_typeid,$info['id'],$info['satisfyscore']);

        $info['jifentprice_info'] = Model_Jifen_Price::get_used_jifentprice($info['jifentprice_id'],$this->_typeid);
        $info['jifenbook_info'] = Model_Jifen::get_used_jifenbook($info['jifenbook_id'],$this->_typeid);
        $info['jifencomment_info'] = Model_Jifen::get_used_jifencomment($this->_typeid);
        //目的地上级
        if ($info['finaldestid'] > 0)
        {
            $predest = Product::get_predest($info['finaldestid']);
            $this->assign('predest', $predest);

            $finaldest_name = DB::select('kindname')->from('destinations')->where('id','=',$info['finaldestid'])->execute()->get('kindname');
            $info['finaldest_name']= $finaldest_name;
        }
        //支付方式
        $paytypeArr = explode(',', $GLOBALS['cfg_pay_type']);

        //扩展字段信息
        $extend_info = ORM::factory('ship_line_extend_field')
            ->where("productid=" . $info['id'])
            ->find()
            ->as_array();

        $this->assign('seoinfo', $seoInfo);
        $this->assign('info', $info);
        $this->assign('paytypeArr', $paytypeArr);
        $this->assign('extendinfo', $extend_info);
        $templet = Product::get_use_templet('ship_show');
        $templet = $templet ? $templet : 'ship/show';
        $this->display($templet);
        Model_Ship_Line::update_click_rate($info['id']);
        //缓存内容
        $content = $this->response->body();
        Common::cache('set', $this->_cache_key, $content);

    }

    //轮船详情
    public function action_cruise()
    {
        $id = intval($this->request->param('aid'));
        $info = ORM::factory('ship', $id)->as_array();

        if (!$info['id'])
        {
            $this->request->redirect('error/404');
        }
        //seo
        $seoInfo = Product::seo($info);
        //产品图片
        $info['piclist'] = Product::pic_list($info['piclist']);
        $info['supplier'] = DB::select()->from('supplier')->where('id', '=', $info['supplierlist'])->execute()->current();
        $this->assign('seoinfo', $seoInfo);
        $this->assign('info', $info);
        $templet = 'ship/cruise';
        $this->display($templet);
        //缓存内容
        $content = $this->response->body();
        Common::cache('set', $this->_cache_key, $content);
    }

    /*
    //报价日历
    public function action_dialog_calendar()
    {
        $suitid = Arr::get($_POST, 'suitid');
        $year = Arr::get($_POST, 'year');
        $month = Arr::get($_POST, 'month');
        if (empty($year) && empty($month))
        {
            $data = DB::select()->from('car_suit_price')->where('suitid', '=', $suitid)->and_where('day', '>=', time())->execute()->current();
            if (!empty($data))
            {
                $year = date('Y', $data['day']);
                $month = date('m', $data['day']);
            }
            else
            {
                $nowDate = new DateTime();
                $year = $nowDate->format('Y');
                $month = $nowDate->format('m');
            }
        }
        $out = '';
        $priceArr = Product::get_suit_price($year, $month, $suitid, $this->_typeid);
        $out .= Common::calender($year, $month, $priceArr, $suitid);
        echo $out;
    }
*/
    //列表页
    public function action_list()
    {
        $req_uri = $_SERVER['HTTP_X_FORWARDED_PROTO'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $is_all = false;
        if (Common::get_web_url(0) . '/ship/all' == $req_uri || Common::get_web_url(0) . '/ship/all/' == $req_uri)
        {
            $is_all = true;
        }
        //参数值获取
        $destPy = $this->request->param('destpy');
        $sign = $this->request->param('sign');
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
        $pagesize = 12;



        $route_array = array(
            'controller' => $this->request->controller(),
            'action' => $this->request->action(),
            'destpy' => $destPy,
            'dayid' => $dayId,
            'priceid' => $priceId,
            'sorttype' => $sortType,
            'startcityid' => $startcityId,
            'shipid' => $shipid,
            'attrid' => $attrId
        );
        //$start_time=microtime(true); //获取程序开始执行的时间

        $out = Model_Ship_Line::search_result($route_array, $keyword, $p, $pagesize);
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
        //目的地信息
        $destInfo = array();
        if ($destId)
        {
            $destInfo = Model_Ship_Line::get_dest_info($destId);
        }

        $channel_info = Model_Nav::get_channel_info($this->_typeid);
        $channel_name = empty($channel_info['seotitle'])?$channel_info['shortname']:$channel_info['seotitle'];
        $seo_params = array(
            'destpy' => $destPy,
            'dayid' => $dayId,
            'priceid' => $priceId,
            'sorttype' => $sortType,
            'startcityid' => $startcityId,
            'shipid' => $shipid,
            'attrid' => $attrId,
            'p' => $p,
            'keyword' => $keyword,
            'channel_name'=>$channel_name
        );

        $chooseitem = Model_Ship_Line::get_selected_item($route_array);
        $search_title = Model_Ship_Line::gen_seotitle($seo_params);
        $tagword = Model_Ship_Line_Kindlist::get_list_tag_word($destPy);
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

        $templet = St_Functions::get_list_dest_template_pc($this->_typeid,$destId);
        $templet = empty($templet)? Product::get_use_templet('ship_list'):$templet;
        $templet = $templet ? $templet : 'ship/list';
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
        if (!empty($GLOBALS['cfg_login_order']) && empty($userInfo['mid']))
        {
            $this->request->redirect(Common::get_main_host() . '/member/login/?redirecturl=' . urlencode(Common::get_current_url()));
        }
        $productId = intval(Arr::get($_GET, 'lineid'));
        $suitid = Arr::get($_GET, 'suitid');
        $number = $_GET['number'];
        $dateid = intval($_GET['dateid']);

        //如果参数为空,则返回上级页面
        if (empty($productId) || empty($suitId))
        {
           // $this->request->redirect($this->request->referrer());
        }




        //产品信息
        $info = ORM::factory('ship_line', $productId)->as_array();
        //套餐按出发日期价格
        if(empty($dateid))
        {
            $starttime = Model_Ship_Line::get_starttime($productId);
            $dateid = DB::select('id')->from('ship_schedule_date')->where('starttime','=',$starttime)->and_where('scheduleid','=',$info['scheduleid'])->execute()->get('id');
        }
        $suitid_arr = explode(',',$suitid);
        $number_arr = explode(',',$number);
        $suit_arr=array();

        foreach($suitid_arr as $k=>$v)
        {
            if(empty($v))
                continue;
            $suit_info = Model_Ship_Line::get_suit_info($productId,$v,$dateid);
            if(empty($suit_info))
                continue;
            $book_peoplenum = intval($number_arr[$k])<=0?0:intval($number_arr[$k]);
            $suit_info['book_peoplenum'] = $book_peoplenum;
            $suit_info['kindname'] = DB::select('title')->from('ship_room_kind')->where('id','=',$suit_info['kindid'])->execute()->get('title');
            $suit_arr[] = $suit_info;
        }



        $info['url'] = Common::get_web_url($info['webid']) . "/ship/show_{$info['aid']}.html";
        $info['series'] = St_Product::product_series($info['id'], '104');
        $info['dateid'] = $dateid;
        $starttime = DB::select('starttime')->from('ship_schedule_date')->where('id','=',$dateid)->execute()->get('starttime');
        $info['startdate'] = date('Y-m-d',$starttime);

        //积分抵现所需积分
        $jifentprice_info = Model_Jifen_Price::get_used_jifentprice($info['jifentprice_id'],$this->_typeid);


        $code = md5(time());
        Common::session('code', $code);

        $this->assign('info', $info);
        $this->assign('typeid',$this->_typeid);
        $this->assign('suitlist',$suit_arr);
        $this->assign('userInfo', $userInfo);
        $this->assign('jifentprice_info',$jifentprice_info);
       // $this->assign('needjifen', $needjifen);
        $this->assign('frmcode', $code);
        $this->display('ship/book');
    }

    /*
* 创建订单
* */

    public function action_create()
    {
        $frmCode = Arr::get($_POST, 'frmcode');
        $checkCode = strtolower(Arr::get($_POST, 'checkcode'));
        //验证码验证
        if (!Captcha::valid($checkCode) || empty($checkCode))
        {
            exit();
        }
        //安全校验码验证
        $orgCode = Common::session('code');
        if ($orgCode != $frmCode)
        {
            exit();
        }
        //会员信息
        $userInfo = Product::get_login_user_info();
        $memberId = $userInfo ? $userInfo['mid'] : 0;//会员id
        $webid = intval(Arr::get($_POST, 'webid'));//网站id
        $lineId = intval(Arr::get($_POST, 'lineid'));//线路id
        $dateid = Arr::get($_POST, 'dateid');//出发日期
        $linkMan = Arr::get($_POST, 'linkman');//联系人姓名
        $linkTel = Arr::get($_POST, 'linktel');//联系人电话
        $linkEmail = Arr::get($_POST, 'linkemail');//联系人邮箱

        $linkTel = empty($linkTel) && !empty($userInfo)?$userInfo['mobile']:$linkTel;
        $linkEmail = empty($linkEmail) && !empty($userInfo)?$userInfo['email']:$linkEmail;

        $needJifen = intval($_POST['needjifen']);
        $remark = Arr::get($_POST, 'remark');//订单备注
        $roomnum_arr = $_POST['roomnum'];
        $peoplenum_arr = $_POST['peoplenum'];
        $paytype = 1;
        $dingjin = 0;
        $curtime = time();

        $suit_arr = array();
        $totalprice = 0;
        $date_info =  DB::select()->from('ship_schedule_date')->where('id','=',$dateid)->execute()->current();

        $startdate = date('Y-m-d',$date_info['starttime']);
        $enddate = date('Y-m-d',$date_info['endtime']);

        foreach($roomnum_arr as $k=>$v)
        {
            if(empty($v))
                continue;
            $suit_info = Model_Ship_Line::get_suit_info($lineId,$k,$dateid);
            $v = intval($v);
            $suit_info['dingnum'] = $v;
            $suit_info['peoplenum'] = $peoplenum_arr[$k];
            $suit_info['number'] = intval($suit_info['number']);
            if($suit_info['number']!=-1 && $v>$suit_info['number'])
            {
                header("Content-type:text/html;charset=utf-8");
                exit("房间".$suit_info['suitname'].'库存不足!');
            }
            $totalprice+= $suit_info['price'] * intval($v);
            $suit_arr[] = $suit_info;
        }

        $info = ORM::factory('ship_line', $lineId)->as_array();

        //积分抵现.
        $jifentprice = 0;
        $useJifen = 0;
        if ($needJifen)
        {
            $jifentprice = Model_Jifen_Price::calculate_jifentprice($info['jifentprice_id'],$this->_typeid,$needJifen,$userInfo);
            $useJifen = empty($jifentprice)?0:1;
            $needJifen = empty($jifentprice)?0:$needJifen;
        }
        //积分评论
        $jifencomment_info = Model_Jifen::get_used_jifencomment($this->_typeid);
        $jifencomment = empty($jifencomment_info)?0:$jifencomment_info['value'];


        //游客信息读取
        $t_name = Arr::get($_POST, 't_name');
        $t_cardtype = Arr::get($_POST, 't_cardtype');
        $t_cardno = Arr::get($_POST, 't_cardno');
        $tourer = array();
        $totalNum = 0;
        for ($i = 0; $i < count($t_name); $i++)
        {
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
            'childprice' =>0,
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
            'departdate'=>$enddate,
            'usejifen' => $useJifen,
            'needjifen' => $needJifen,
            'status' => $status,
            'remark' => $remark
        );

        /*--------------------------------------------------------------优惠券信息------------------------------------------------------------*/
        //优惠券判断
        $croleid = intval(Arr::get($_POST, 'couponid'));
        if($croleid)
        {
            $cid = DB::select('cid')->from('member_coupon')->where("id=$croleid")->execute()->current();
            $totalprice = Model_Coupon::get_order_totalprice($arr);
            $ischeck =  Model_Coupon::check_samount($croleid,$totalprice,$this->_typeid,$info['id'],$startdate);
            if($ischeck['status']==1)
            {
                Model_Coupon::add_coupon_order($cid,$orderSn,$totalprice,$ischeck,$croleid); //添加订单优惠券信息
            }
            else
            {
                exit('coupon  verification failed!');//优惠券不满足条件
            }
        }
        /*-----------------------------------------------------------------优惠券信息--------------------------------------*/


        //添加订单
        if (St_Product::add_order($arr,'Model_Ship_Line',array_merge($arr,array('child_list'=>$suit_arr))))//Model_Ship_Line::add_order($arr))
        {
            $orderInfo = Model_Member_Order::get_order_by_ordersn($orderSn);
            foreach($suit_arr as $row)
            {
                $child_model = ORM::factory('member_order_child');
                $child_model->pid = $orderInfo['id'];
                $child_model->suitid = $row['suitid'];
                $child_model->price = $row['price'];
                $child_model->title = $row['suitname'];
                $child_model->dingnum = $row['dingnum'];
                $child_model->peoplenum = $row['peoplenum'];
                $child_model->status = $status;
                $child_model->addtime = $curtime;
                $child_model->ordersn = Product::get_sub_ordersn($this->_typeid);
                $child_model->save();
               // Model_Ship_Line::minu_storage($row['suitid'],$dateid,$row['dingnum']);
            }

            Model_Member_Order::add_tourer_pc($orderInfo['id'], $tourer, $memberId);
            Common::session('_platform', 'pc');

                $payurl = Common::get_main_host() . "/payment/?ordersn=" . $orderSn;
                $this->request->redirect($payurl);
        }


    }

    /* 打印页面 */
    public function action_print()
    {
        $id = intval($this->request->param('aid'));
        $dateid = $_GET['dateid'];
        if (empty($id))
        {
            exit('wrong id');
        }

        //线路详情
        $date_info = DB::select()->from('ship_schedule_date')->where('id','=',$dateid)->execute()->current();
        $info = ORM::factory('ship_line', $id)->as_array();
        $info['startcity'] = Model_Startplace::start_city($info['startcity']);
        $info['series'] = St_Product::product_series($info['id'], $this->_typeid);
        $info['finaldest_name'] = DB::select('kindname')->from('destinations')->where('id','=',$info['finaldestid'])->execute()->get('kindname');
        $info['schedule_name'] =  DB::select('title')->from('ship_schedule')->where('id','=',$info['scheduleid'])->execute()->get('title');
        $info['starttime'] = $date_info['starttime'];
        $info['endtime'] = $date_info['endtime'];
        $jieshaolist = DB::select()->from('ship_line_jieshao')->where('lineid','=',$id)->order_by('day', 'ASC')->execute()->as_array();
        $this->assign('info', $info);
        $this->assign('jieshaolist',$jieshaolist);
        $this->display('ship/print');
        //缓存内容
        $content = $this->response->body();
        Common::cache('set', $this->_cache_key, $content);


    }
    /*

    //首页按车型读取数据
    public function action_ajax_index_car()
    {
        $carkindid = Arr::get($_GET, 'carkindid');
        $pagesize = Arr::get($_GET, 'pagesize');
        $list = Model_Car::get_car_list(" and carkindid=$carkindid", 0, $pagesize);
        echo json_encode(array('list' => $list));
    }

  */
    public function action_ajax_get_month_shiplist()
    {
        $year = intval($_POST['year']);
        $month = intval($_POST['month']);
        $first_datetime = strtotime($year . '-' . $month . '-01');
        $last_datetime = strtotime($year . '-' . $month . '-01' . ' +1 month -1 day');
        $now_time = strtotime(date('Y-m-d'));


        $sql = 'select c.starttime,a.price,a.price/b.peoplenum as avgprice,b.id as suitid from sline_ship_line_suit_price a ';
        $sql .= ' inner join (select a.id,a.shipid,b.scheduleid,b.title,b.id as lineid,b.webid,b.aid,b.linebefore,b.islinebefore,c.peoplenum from sline_ship_line_suit a ';
        $sql .= ' inner join sline_ship_line b on a.lineid=b.id and a.shipid=b.shipid inner join sline_ship_room c on a.roomid=c.id where b.ishidden=0) b  on a.suitid=b.id and a.scheduleid=b.scheduleid ';
        $sql .= ' inner join sline_ship_schedule_date c on a.dateid=c.id ';
        $sql .= ' where (case when b.islinebefore=1 then (c.starttime-b.linebefore*24*3600)>=' . $now_time . ' else c.starttime>='.$now_time.' end) ';
        $sql .='  and  c.starttime>=' . $first_datetime . ' and c.starttime<=' . $last_datetime . ' and a.price>0 ';
        $sql .=   '  order by c.starttime asc,avgprice asc';


       // $sql .= 'inner join sline_ship c on b.shipid=c.id where a.day>=' . $first_datetime . ' and a.day<=' . $last_datetime . ' and a.price>0 group by day order by a.day ';

         $arr = DB::query(Database::SELECT, $sql)->execute()->as_array();

         $list=array();
         $days=array();
         foreach($arr as $val)
         {
             if(in_array($val['starttime'],$days))
             {
                 continue;
             }
             $days[]=$val['starttime'];

             $sql = 'select c.starttime as day,a.price,b.lineid,b.roomid,b.webid,b.aid,d.title from sline_ship_line_suit_price a ';
             $sql .= ' inner join (select a.id as suitid,a.roomid,a.shipid,b.scheduleid,b.title,b.id as lineid,b.webid,b.aid from sline_ship_line_suit a ';
             $sql .= ' inner join sline_ship_line b on a.lineid=b.id and a.shipid=b.shipid where b.ishidden=0) b  on a.suitid=b.suitid and a.scheduleid=b.scheduleid ';
             $sql .= ' inner join sline_ship_schedule_date c on a.dateid=c.id ';
             $sql .= ' inner join sline_ship d on a.shipid=d.id ';
             $sql .= ' where c.starttime='.$val['starttime'].' and a.price='.$val['price'].' and b.suitid='.$val['suitid'];
             $list[] = DB::query(Database::SELECT,$sql)->execute()->current();
         }

        foreach ($list as &$v)
        {
            $v['date'] = date('Y-m-d', $v['day']);
            $v['lines'] = $this->get_lines_of_day($v['day']);
            $v['url'] = Common::get_web_url($v['webid']) . "/ship/show_{$v['aid']}.html";
            $v['passed_destnames'] = implode('-', Model_Ship_Line_Jieshao::get_passed_destlist($v['lineid']));

            $peoplenum = DB::select('peoplenum')->from('ship_room')->where('id','=',$v['roomid'])->execute()->get('peoplenum');
            $peoplenum = empty($peoplenum)?1:$peoplenum;
            $v['price'] = floor($v['price']/$peoplenum);
            $v['price'] = Currency_Tool::price($v['price']);


            //$v['price'] = $alllines[0]['price'];
           // $v['url'] = $alllines[0]['url'];
           // $v['passed_destnames'] = implode('-', Model_Ship_Line_Jieshao::get_passed_destlist($alllines[0]['id']));


        }
        echo json_encode($list);
    }

    //获取某天某个轮船的线路
    private function get_lines_of_dayship($time, $shipid)
    {
        $line_fields = 'b.id,b.webid,b.aid,b.title,b.price,b.price_date,b.litpic,b.startcity,b.kindlist,b.attrid,b.bookcount,b.storeprice,b.sellpoint,b.iconlist,b.satisfyscore,b.finaldestid,b.scheduleid,b.shipid';
        $sql = 'select a.day,min(a.price) as price,b.* from sline_ship_line_suit_price a ';
        $sql .= ' inner join (select a.id as suitid,' . $line_fields . ' from sline_ship_line_suit a ';
        $sql .= ' inner join sline_ship_line b on a.lineid=b.id and a.shipid=b.shipid where b.ishidden=0 and a.shipid=' . $shipid . ') b  on a.suitid=b.suitid and a.scheduleid=b.scheduleid ';
        $sql .= ' and a.day=' . $time;
        $sql.= ' where a.price>0 ';
        $sql .= ' group by a.lineid order by price';
        $list = DB::query(Database::SELECT, $sql)->execute()->as_array();
        foreach ($list as &$v)
        {
            $v['price'] = Model_Ship_Line::get_minprice($v['id'], $v);
            $v['destname'] = DB::select('kindname')->from('destinations')->where('id', '=', $v['finaldestid'])->execute()->get('kindname');
            $v['destname'] = empty($v['destname']) ? '' : $v['destname'];
            $v['passed_destnames'] = implode(',', Model_Ship_Line_Jieshao::get_passed_destlist($v['id']));
            $v['url'] = Common::get_web_url($v['webid']) . "/ship/show_{$v['aid']}.html";
        }
        return $list;

    }

    //获取某天线路
    private function get_lines_of_day($time)
    {
        $now_time = strtotime(date('Y-m-d'));
        $line_fields = 'a.lineid,b.id,b.webid,b.aid,b.title,b.price,b.price_date,b.litpic,b.linebefore,b.islinebefore,b.startcity,b.kindlist,b.attrid,b.bookcount,b.storeprice,b.sellpoint,b.iconlist,b.satisfyscore,b.finaldestid,b.scheduleid,b.shipid';
        $sql = 'select c.starttime as day,min(a.price) as price,b.* from sline_ship_line_suit_price a ';
        $sql .= ' inner join (select a.id as suitid,' . $line_fields . ' from sline_ship_line_suit a ';
        $sql .= ' inner join sline_ship_line b on a.lineid=b.id and a.shipid=b.shipid where b.ishidden=0) b  on a.suitid=b.suitid and a.scheduleid=b.scheduleid ';
        $sql .= ' inner join sline_ship_schedule_date c on a.dateid=c.id ';
        $sql .= ' where c.starttime=' . $time;
        $sql .= ' and (case when b.islinebefore=1 then c.starttime-b.linebefore*24*3600>=' . $now_time . '  else true end) ';
        $sql .=' and a.price>0 ';
        $sql .= ' group by a.lineid';
        $list = DB::query(Database::SELECT, $sql)->execute()->as_array();


        foreach ($list as &$v)
        {
            $v['price'] = $this->get_day_min_price($v['lineid'],$v['day']);//Model_Ship_Line::get_minprice($v['lineid'], array('info'=>$v));
            $v['destname'] = DB::select('kindname')->from('destinations')->where('id', '=', $v['finaldestid'])->execute()->get('kindname');
            $v['destname'] = empty($v['destname']) ? '' : $v['destname'];
            $v['passed_destnames'] = implode(',', Model_Ship_Line_Jieshao::get_passed_destlist($v['id']));
            $v['url'] = Common::get_web_url($v['webid']) . "/ship/show_{$v['aid']}.html";
        }
        return $list;
    }

    private function get_day_min_price($lineid,$time)
    {
        $sql='select a.price,a.suitid,c.roomid,x.peoplenum,a.price/x.peoplenum as avgprice,a.storeprice from sline_ship_line_suit_price a inner join sline_ship_schedule_date b on a.dateid=b.id and a.scheduleid=b.scheduleid
        inner join (select a.id,a.roomid,b.scheduleid from sline_ship_line_suit a inner join sline_ship_line b
        on a.lineid=b.id and a.shipid=b.shipid where a.lineid='.$lineid.') c  on a.suitid=c.id and a.scheduleid=c.scheduleid
        inner join sline_ship_room x on c.roomid=x.id
        where a.lineid='.$lineid.' and a.price>0 and b.starttime='.$time.' order by avgprice asc limit 1';
        $avgprice = DB::query(Database::SELECT,$sql)->execute()->get('avgprice');

        return Currency_Tool::price($avgprice);
    }

    //读取线路套餐
    public function action_ajax_load_data()
    {
        $shipId = intval(Arr::get($_REQUEST, 'lineid'));
        $day = strtotime(Arr::get($_REQUEST, 'starttime'));
        $data = Model_Ship::get_ship_suite($shipId, $day);
        echo json_encode($data);
    }

    /**
     * 日历报价
     */
    public function action_dialog_calendar()
    {


        $year = intval(Arr::get($_POST, 'year'));
        $month = intval(Arr::get($_POST, 'month'));
        $lineid = intval(Arr::get($_POST, 'lineid'));
        $containdiv = Arr::get($_POST, 'containdiv');
        $nowDate = new DateTime();
        $year = !empty($year) ? $year : $nowDate->format('Y');
        $month = !empty($month) ? $month : $nowDate->format('m');
        $out = '';
        $info = DB::select('islinebefore', 'linebefore')->from('ship_line')->where('id', '=', $lineid)->execute()->current();
        $ext['islinebefore'] = $info['islinebefore'];
        $ext['linebefore'] = $info['linebefore'];
        if ($ext['islinebefore'])
        {
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
        while ($day <= $lastday)
        {
            $cday = $year . '-' . $month . '-' . $day;

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
            $dayPrice = $priceArr[$cdayme]['minprice'];




            //库存
            $priceArr[$cdayme]['number'] = $priceArr[$cdayme]['number'] < -1 ? 0 : $priceArr[$cdayme]['number'];
            $number = $priceArr[$cdayme]['number'] != -1 ? $priceArr[$cdayme]['number'] : '不限';

         /*   if($number=='不限')
                $numstr = '';
            elseif($number>0)
                $numstr = '<b style="font-size: 1rem;font-weight:normal">余位&nbsp;'.$number.'</b>';
         */

            //定义单元格样式，高，宽
            $tdStyle = "height='80'";
            //判断当前的日期是否小于今天
            $tdcontent = '<span class="num">' . $day . '</span>';
            if ($defaultmktime >= $currentmktime)
            {


                if ($dayPrice)
                {

                    $dayPriceStrs = Currency_Tool::symbol() . $dayPrice . '<br>';
                    $balanceStr = '';

                    $tdcontent .= '<b class="price">' . $dayPriceStrs . '</b>' . $balanceStr;
                    if($numstr)
                        $tdcontent .= $numstr;
                    if ($number === 0)
                    {
                        $onclick = '';
                    }
                    else
                    {
                        $onclick = 'onclick="choose_day(\'' . $cday . '\',\'' . $contain . '\')"';
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
    //获取套餐信息
    public static function action_ajax_price_day()
    {
        $useday = $_GET['useday'];
        $lineid = Arr::get($_GET, 'lineid');
        $list = Model_Ship_Line::get_price_byday($lineid, $useday);
        echo json_encode($list);
    }

    /*
    * 验证验证码是否正确
    * */
    public function action_ajax_check_code()
    {
        $flag = 'false';
        $checkcode = strtolower(Arr::get($_POST, 'checkcode'));
        if (Captcha::valid($checkcode))
        {
            $flag = 'true';
        }
        echo $flag;
    }

    public function action_ajax_check_storage()
    {
        $suitids = $_POST['suitids'];
        $numbers = $_POST['numbers'];
        $suitid_arr = explode(',',$suitids);
        $number_arr = explode(',',$numbers);
        $dateid = $_POST['dateid'];
        $lineid = $_POST['lineid'];

        $status = true;
        $msg = '';
        foreach($suitid_arr as $k=>$v)
        {
            if(empty($v))
                continue;
            $suitinfo = Model_Ship_Line::get_suit_info($lineid,$v,$dateid);
            $dingnum = intval($number_arr[$k]);
            if(empty($suitinfo))
            {
                $status = false;
                $msg = '报价不存在';
            }
            else if($suitinfo['number']!=-1 && $dingnum>intval($suitinfo['number']))
            {
                $status = false;
                $msg =$suitinfo['suitname'].'库存不足';
            }
        }
        echo json_encode(array('status'=>$status,'msg'=>$msg));

    }

}