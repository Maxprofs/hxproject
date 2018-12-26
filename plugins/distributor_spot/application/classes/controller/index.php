<?php

/**
 * Class Controller_Index
 */
class Controller_Index extends Stourweb_Controller
{
    private  $_typeid = 5;
    private  $_user_info = NULL;


    public function before()
    {
        //登陆状态判断
        $st_distributor_id = Cookie::get('st_distributor_id');
        if(empty($st_distributor_id))
        {
            $this->request->redirect($GLOBALS['cfg_basehost'].'/plugins/distributor/pc/login');
        }
        else
        {
            $this->_user_info = Model_Supplier::get_distributor_byid($st_distributor_id);
            $this->_check_right();
            $this->assign('userinfo',$this->_user_info);
        }
        parent::before();
        $weblist = Common::get_web_list();
        $this->assign('weblist',$weblist);
        $this->assign('typeid',$this->_typeid);

    }
    //首页
    public function action_index()
    {
        $this->request->redirect('index/list');
    }
    //添加产品
    public function action_add()
    {

        $this->assign('action', 'add');
        $columns = ORM::factory('spot_content')->where("(webid=0 and isopen=1) or columnname='tupian'")->order_by('displayorder', 'asc')->get_all();
        $this->assign('columns', $columns);
        $this->display('edit');
    }

    //修改产品
    public function action_edit()
    {

        $productid = intval(Arr::get($_GET,'id'));
        $info = ORM::factory('spot', $productid)->as_array();
        $info['kindlist_arr'] = Model_Destinations::getKindlistArr($info['kindlist']);
        $info['attrlist_arr'] = Common::get_selected_attr($this->_typeid, $info['attrid']);
        $info['iconlist_arr'] = Common::get_selected_icon($info['iconlist']);
        $info['distributor_arr'] = ORM::factory('distributor', $info['distributorlist'])->as_array();
        $info['piclist_arr'] = json_encode(Common::get_upload_picture($info['piclist']));//图片数组
        $columns = ORM::factory('spot_content')->where("(webid=0 and isopen=1) or columnname='tupian'")->order_by('displayorder', 'asc')->get_all();
        $extendinfo = Common::get_extend_info($this->_typeid, $info['id']);
        $this->assign('columns', $columns);
        $this->assign('extendinfo', $extendinfo);//扩展信息
        $this->assign('action', 'edit');
        $this->assign('info', $info);
        $this->display('edit');


    }

    //保存

    public function action_ajax_save()
    {
        $action = Arr::get($_POST,'action');//当前操作
        $productid = Arr::get($_POST, 'productid');
        $webid = Arr::get($_POST, 'webid');
        $kindlist = Arr::get($_POST, 'kindlist');
        $status = false;
        if ($webid != 0)//自动添加子站目的地属性
        {
            if (is_array($kindlist))
            {
                if (!in_array($webid, $kindlist))
                {
                    array_push($kindlist, $webid);
                }
            }
            else
            {
                $kindlist = array($webid);//如果为空则直接加webid
            }
        }
        $attrids = implode(',', Arr::get($_POST, 'attrlist'));//属性
        if (!empty($attrids))
        {
            $attrmode = ORM::factory("spot_attr")->where("id in ($attrids)")->group_by('pid')->get_all();
            foreach ($attrmode as $k => $v)
            {
                $attrids = $v['pid'] . ',' . $attrids;
            }
        }
        $imagestitle = Arr::get($_POST,'imagestitle');
        $images = Arr::get($_POST,'images');
        $imgheadindex = Arr::get($_POST,'imgheadindex');

        //图片处理
        $piclist ='';
        $litpic = $images[$imgheadindex];
        for($i=1;isset($images[$i]);$i++)
        {
            $desc = isset($imagestitle[$i]) ? $imagestitle[$i] : '';
            $pic = !empty($desc) ? $images[$i].'||'.$desc : $images[$i];
            $piclist .= $pic.',';

        }
        $piclist =strlen($piclist)>0 ? substr($piclist,0,strlen($piclist)-1) : '';//图片

        //添加操作
        if($action == 'add' && empty($productid))
        {
            $model = ORM::factory('spot');
            $model->aid = Common::get_last_aid('sline_spot',$webid);
            $model->distributorlist = Cookie::get('st_distributor_id');
            $model->addtime = time();
            $model->ishidden = 1;
        }
        else
        {
            $model = ORM::factory('spot',$productid);
            if($model->webid != $webid) //如果更改了webid重新生成aid
            {
                $aid = Common::get_last_aid('sline_spot',$webid);
                $model->aid = $aid;
            }
        }

        $model->title = Arr::get($_POST,'title');
        $model->shortname = Arr::get($_POST,'shortname');
        $model->address = Arr::get($_POST,'address');
        $model->webid = $webid;
        $model->shownum = Arr::get($_POST,'shownum')?Arr::get($_POST,'shownum'): 0;
        $model->author = Arr::get($_POST,'author');//编辑人
        $model->getway = Arr::get($_POST,'getway');//取票方式
        $model->sellpoint = Arr::get($_POST,'sellpoint');

        $model->kindlist = implode(',', Model_Destinations::getParentsStr(implode(',', $kindlist)));//所属目的地
        $model->attrid = $attrids;//属性
        $model->lng = Arr::get($_POST,'lng') ? Arr::get($_POST,'lng') : 0;
        $model->lat = Arr::get($_POST,'lat') ? Arr::get($_POST,'lat') : 0;

        $model->iconlist = implode(',',Arr::get($_POST,'iconlist'));//图标

        $model->satisfyscore = Arr::get($_POST,'satisfyscore')?Arr::get($_POST,'satisfyscore'):0;//满意度
        $model->bookcount = Arr::get($_POST,'bookcount')?Arr::get($_POST,'bookcount'):0;//销量
        $model->piclist = $piclist;
        $link = new Model_Tool_Link();
        $model->content=$link->keywordReplaceBody(Arr::get($_POST,'content'),5);

        $model->isspotarea = 0;
        $model->booknotice = Arr::get($_POST,'booknotice');
        $model->recommendnum=$_POST['recommendnum'];
        $model->seotitle = Arr::get($_POST,'seotitle');//优化标题
        $model->tagword = Arr::get($_POST,'tagword');
        $model->keyword = Arr::get($_POST,'keyword');
        $model->description = Arr::get($_POST,'description');
        $model->kindlist = implode(',', Model_Destinations::getParentsStr(implode(',', Arr::get($_POST, 'kindlist'))));//所属目的地
        $model->finaldestid=empty($_POST['finaldestid'])?Model_Destinations::getFinaldestId(explode(',',$model->kindlist)):$_POST['finaldestid'];
        $model->attrid = implode(',',Arr::get($_POST,'attrlist'));//属性
        $model->iconlist = implode(',',Arr::get($_POST,'iconlist'));//图标
        $model->modtime = time();
        $model->litpic = $litpic;


        if($action=='add' && empty($productid))
        {

            $model->create();
        }
        else
        {
            $model->update();
        }


        if($model->saved())
        {
            if($action=='add')
            {

                $productid = $model->id; //插入的产品id

            }
            else
            {
                $productid =null;
            }
            Common::save_extend_data($this->_typeid,$model->id,$_POST);//扩展信息保存

            $status = true;
        }
        echo json_encode(array('status'=>$status,'productid'=>$productid));

    }

    //产品列表页
    public function action_list()
    {
        $templet = Common::remove_xss(Arr::get($_GET,'templet'));
        $keyword = Common::remove_xss(Arr::get($_GET,'keyword'));
        $pagesize = intval(Arr::get($_GET,'pagesize'));
        $pagesize = $pagesize ? $pagesize : 30;
        $templet = !empty($templet) ? $templet : 'list';
        $data = Model_Spot::ticket_list($pagesize,$keyword);
        $this->assign('pagesize',$pagesize);
        $this->assign('pageinfo',$data['pageinfo']);
        $this->assign('keyword',$keyword);
        $this->assign('list',$data['list']);
        $this->display($templet);

    }

    //套餐列表页
    public function action_suit_list()
    {
        $templet = 'suit_list';
        $this->request->redirect('index/list?templet='.$templet);

    }

    public function action_suit_add()
    {


        $this->assign('action', 'add');
      //  $productid = Arr::get($_GET,'productid');

       // $info['productid'] = $productid;
       // $suittypes = ORM::factory('spot_ticket_type')->where("spotid=" . $productid)->get_all();
       // $this->assign("suittypes",$suittypes);
       // $spotinfo = ORM::factory('spot', $productid)->as_array();
        $info = array('lastoffer' => array('pricerule' => 'all'));
        $this->assign('info',$info);
        $this->assign('position','添加套餐');
      //  $this->assign('productname', $spotinfo['title']);
      //  $this->assign('productid', $productid);
        $this->display('suit_edit');
    }


    //套餐修改
    public function action_suit_edit()
    {

        $suitid = intval(Arr::get($_GET,'id'));

        if($suitid)
        {

            $info = ORM::factory('spot_ticket',$suitid)->as_array();
            $product = ORM::factory('spot',$info['spotid'])->as_array();
            $suittypes = ORM::factory('spot_ticket_type')->where("spotid=" . $info['spotid'])->get_all();
            $info['lastoffer'] = unserialize($info['lastoffer']);
            if (empty($info['lastoffer']))
            {
                $info['lastoffer'] = array('pricerule' => 'all');
            }
            $info['fill_tourer_items_arr'] = explode(',',$info['fill_tourer_items']);
            $hour = $info['hour_before']<10?'0'.$info['hour_before']:$info['hour_before'];
            $minute = $info['minute_before']<10?'0'.$info['minute_before']:$info['minute_before'];
            $info['time_before'] = $hour.':'.$minute;

            $this->assign("suittypes",$suittypes);
            $this->assign('product',$product);
            $this->assign('info',$info);
            $this->assign('productid',$info['spotid']);
            $this->assign('action','edit');
            $this->assign('position','修改套餐');
            $this->display('suit_edit');
        }



    }

    //套餐保存
    public function action_ajax_suit_save()
    {
        $distributor_id = $this->_user_info['id'];

        $spotid = Arr::get($_POST,'spotid');
        $ticketid = Arr::get($_POST,'id');
        $tickettypeid=Arr::get($_POST, 'tickettypeid');

        $model = ORM::factory('spot_ticket',$ticketid);
        if($model->loaded() && $model->distributorlist!=$distributor_id)
        {
            echo json_encode(array('status'=>false,'msg'=>'你没有权限'));
            return;
        }
        if(empty($spotid))
        {
            echo json_encode(array('status'=>false,'msg'=>'请选择景点'));
            return;
        }



        $newtickettype = Arr::get($_POST,'newtickettype');
        if(!empty($newtickettype))
        {
            $newtickettypeid = Model_Spot::add_suittype($newtickettype,$spotid);
            $tickettypeid = !empty($newtickettypeid)?$newtickettypeid:$tickettypeid;
        }

        if(!$model->loaded())
        {
            $model->status=0;
        }
        $model->title = Arr::get($_POST, 'title');
        $model->tickettypeid = $tickettypeid;
        $model->sellprice = Arr::get($_POST, 'sellprice') ? Arr::get($_POST, 'sellprice') : 0;
        $model->paytype = 1;
        //会员支付方式
        $model->pay_way = array_sum(Arr::get($_POST, 'pay_way'));
        //预订确认方式
        $model->need_confirm = Arr::get($_POST, 'need_confirm') ? Arr::get($_POST, 'need_confirm') : 0;
        //待付款时限,默认不限制
        $model->get_ticket_way = $_POST['get_ticket_way'];
        $model->effective_days = intval($_POST['effective_days']);
        $model->refund_restriction = intval($_POST['refund_restriction']);
        $model->distributorlist = $distributor_id;
        $model->fill_tourer_type = intval($_POST['fill_tourer_type']);
        $model->fill_tourer_items = implode(',',$_POST['fill_tourer_items']);
        $model->day_before = $_POST['day_before'];
        $time_before = $_POST['time_before'];
        $hour = 0;
        $minute = 0;
        if(!empty($time_before))
        {
            $time_before_arr = explode(':',$time_before);
            $hour = empty($time_before_arr[0])?0:intval($time_before_arr[0]);
            $minute = empty($time_before_arr[1])?0:intval($time_before_arr[1]);
        }
        $model->hour_before = $hour;
        $model->minute_before = $minute;
        $model->description = Arr::get($_POST,'description');
        $model->spotid = $spotid;


        $model->save();
        if($model->saved())
        {

            $this->update_status_after_edit($ticketid);
            $ticketid = $model->id;
            $status = true;
        }
        echo json_encode(array('status'=>$status,'id'=>$ticketid));
    }

    public function get_last_offer($data)
    {
        $lastOffer = array();

        $lastOffer = array(
            'pricerule' => $data['pricerule'],
            'adultbasicprice' => $data['adultbasicprice'],
            'adultprofit' => $data['adultprofit'],
            'adultprice' => $data['adultbasicprice'] + $data['adultprofit'],
            'adultmarketprice'=>  $data['adultmarketprice'],
            'adultdistributionprice'=>$data['adultdistributionprice'],
            'starttime' => $data['starttime'],
            'endtime' => $data['endtime'],
            'description' => $data['description'],
            'number' => $data['number']
        );
        return serialize($lastOffer);
    }
    public function saveBaoJia($spotid, $ticketid, $arr)
    {
        //$pricerule,$starttime,$endtime,$hotelid,$roomid,$basicprice,$profit,$description
        $pricerule = Arr::get($arr, 'pricerule');
        $starttime = Arr::get($arr, 'starttime');
        $endtime = Arr::get($arr, 'endtime');
        $basicprice = Arr::get($arr, 'adultbasicprice') ? Arr::get($arr, 'adultbasicprice') : 0;
        $profit = Arr::get($arr, 'adultprofit') ? Arr::get($arr, 'adultprofit') : 0;
        $description = Arr::get($arr, 'description');
        $adultmarketprice=$arr['adultmarketprice'];
        $adultdistributionprice=$arr['adultdistributionprice'];
        $monthval = Arr::get($arr, 'monthval');
        $weekval = Arr::get($arr, 'weekval');
        $number = Arr::get($arr, 'number');
        if (empty($starttime) || empty($endtime))
            return false;
        $stime = strtotime($starttime);
        $etime = strtotime($endtime);
        $price = (double)$basicprice + (double)$profit;
        //按日期范围报价
        if ($pricerule == '1')
        {
            $begintime = $stime;
            while (true)
            {
                $model = ORM::factory('spot_ticket_price')->where("ticketid=$ticketid and day='$begintime'")->find();
                $data_arr = array();
                $data_arr['spotid'] = $spotid;
                $data_arr['ticketid'] = $ticketid;
                $data_arr['adultbasicprice'] = $basicprice;
                $data_arr['adultprofit'] = $profit;
                $data_arr['description'] = $description;
                $data_arr['adultprice'] = $price;
                $data_arr['adultdistributionprice']=$adultdistributionprice;
                $data_arr['adultmarketprice']=$adultmarketprice;
                $data_arr['day'] = $begintime;
                $data_arr['number'] = $number;
                if(empty($price))
                {
                    $query = DB::delete('spot_ticket_price')->where("ticketid=$ticketid and day='$begintime'");
                    $query->execute();
                }
                else if ($model->ticketid)
                {
                    $query = DB::update('spot_ticket_price')->set($data_arr)->where("ticketid=$ticketid and day='$begintime'");
                    $query->execute();
                }
                else
                {
                    foreach ($data_arr as $k => $v)
                    {
                        $model->$k = $v;
                    }
                    $model->save();
                }
                $begintime = $begintime + 86400;
                if ($begintime > $etime)
                    break;
            }
        }
        //按号进行报价
        else if ($pricerule == '3')
        {
            $syear = date('Y', $stime);
            $smonth = date('m', $stime);
            $sday = date('d', $stime);
            $eyear = date('Y', $etime);
            $emonth = date('m', $etime);
            $eday = date('d', $etime);
            $beginyear = $syear;
            $beginmonth = $smonth;
            while (true)
            {
                $daynum = date('t', strtotime($beginyear . '-' . $beginmonth . '-' . '01'));
                foreach ($monthval as $v)
                {
                    if ((int)$v < 10)
                        $v = '0' . $v;
                    $newtime = strtotime($beginyear . '-' . $beginmonth . '-' . $v);
                    if ((int)$v > (int)$daynum || $newtime < $stime || $newtime > $etime)
                        continue;
                    $model = ORM::factory('spot_ticket_price')->where("ticketid=$ticketid and day='$newtime'")->find();
                    $data_arr = array();
                    $data_arr['spotid'] = $spotid;
                    $data_arr['ticketid'] = $ticketid;
                    $data_arr['adultbasicprice'] = $basicprice;
                    $data_arr['adultprofit'] = $profit;
                    $data_arr['description'] = $description;
                    $data_arr['adultprice'] = $price;
                    $data_arr['adultdistributionprice']=$adultdistributionprice;
                    $data_arr['adultmarketprice']=$adultmarketprice;
                    $data_arr['day'] = $newtime;
                    $data_arr['number'] = $number;
                    if(empty($price))
                    {
                        $query = DB::delete('spot_ticket_price')->where("ticketid=$ticketid and day='$newtime'");
                        $query->execute();
                    }
                    else if ($model->ticketid)
                    {
                        $query = DB::update('spot_ticket_price')->set($data_arr)->where("ticketid=$ticketid and day='$newtime'");
                        $query->execute();
                    }
                    else
                    {
                        foreach ($data_arr as $k => $v)
                        {
                            $model->$k = $v;
                        }
                        $model->save();
                    }
                }
                $beginmonth = (int)$beginmonth + 1;
                if ($beginmonth > 12)
                {
                    $beginmonth = $beginmonth - 12;
                    $beginyear++;
                }
                if (($beginmonth > $emonth && $beginyear >= $eyear) || ($beginmonth <= $emonth && $beginyear > $eyear))
                    break;
                $beginmonth = $beginmonth < 10 ? '0' . $beginmonth : $beginmonth;
            }
        }
        //按星期进行报价
        else if ($pricerule == '2')
        {
            $begintime = $stime;
            while (true)
            {
                $cur_week = date('w', $begintime);
                $cur_week = $cur_week == 0 ? 7 : $cur_week;
                if (in_array($cur_week, $weekval))
                {
                    $model = ORM::factory('spot_ticket_price')->where("ticketid=$ticketid and day='$begintime'")->find();
                    $data_arr = array();
                    $data_arr['spotid'] = $spotid;
                    $data_arr['ticketid'] = $ticketid;
                    $data_arr['adultbasicprice'] = $basicprice;
                    $data_arr['adultprofit'] = $profit;
                    $data_arr['description'] = $description;
                    $data_arr['adultprice'] = $price;
                    $data_arr['adultdistributionprice']=$adultdistributionprice;
                    $data_arr['adultmarketprice']=$adultmarketprice;
                    $data_arr['day'] = $begintime;
                    $data_arr['number'] = $number;
                    if(empty($price))
                    {
                        $query = DB::delete('spot_ticket_price')->where("ticketid=$ticketid and day='$begintime'");
                        $query->execute();
                    }
                    else if ($model->ticketid)
                    {
                        $query = DB::update('spot_ticket_price')->set($data_arr)->where("ticketid=$ticketid and day='$begintime'");
                        $query->execute();
                    }
                    else
                    {
                        foreach ($data_arr as $k => $v)
                        {
                            $model->$k = $v;
                        }
                        $model->save();
                    }
                }
                $begintime = $begintime + 86400;
                if ($begintime > $etime)
                    break;
            }
        }
        // Model_Model_Archive::updateMinPrice($productid);
    }
    /*
    * 报价
    * */
    public function save_baojia($hotelid, $roomid, $arr)
    {

        $pricerule = Arr::get($arr, 'pricerule');
        $starttime = Arr::get($arr, 'starttime');
        $endtime = Arr::get($arr, 'endtime');
        $basicprice = Arr::get($arr, 'basicprice') ? Arr::get($arr, 'basicprice') : 0;
        $profit = Arr::get($arr, 'profit') ? Arr::get($arr, 'profit') : 0;
        $description = Arr::get($arr, 'description');
        $monthval = Arr::get($arr, 'monthval');
        $weekval = Arr::get($arr, 'weekval');
        $number = Arr::get($arr, 'number');
        if (empty($starttime) || empty($endtime))
            return false;
        $stime = strtotime($starttime);
        $etime = strtotime($endtime);
        $price = (int)$basicprice + (int)$profit;
        $pricerule = !empty($pricerule) ? $pricerule : 'all';
        //按日期范围报价
        if ($pricerule == 'all')
        {
            $begintime = $stime;
            while (true)
            {
                $model = ORM::factory('car_suit_price')->where("suitid=$roomid and day='$begintime'")->find();
                $data_arr = array();
                $data_arr['carid'] = $hotelid;
                $data_arr['suitid'] = $roomid;
                $data_arr['adultbasicprice'] = $basicprice;
                $data_arr['adultprofit'] = $profit;
                $data_arr['description'] = $description;
                $data_arr['adultprice'] = $price;
                $data_arr['day'] = $begintime;
                $data_arr['number'] = $number;
                if ($model->suitid)
                {
                    $query = DB::update('car_suit_price')->set($data_arr)->where("suitid=$roomid and day='$begintime'");
                    $query->execute();
                }
                else
                {
                    foreach ($data_arr as $k => $v)
                    {
                        $model->$k = $v;
                    }
                    $model->save();
                }
                $begintime = $begintime + 86400;
                if ($begintime > $etime)
                    break;
            }
        }
        //按号进行报价
        else if ($pricerule == 'month')
        {
            $syear = date('Y', $stime);
            $smonth = date('m', $stime);
            $sday = date('d', $stime);
            $eyear = date('Y', $etime);
            $emonth = date('m', $etime);
            $eday = date('d', $etime);
            $beginyear = $syear;
            $beginmonth = $smonth;
            while (true)
            {
                $daynum = date('t', strtotime($beginyear . '-' . $beginmonth . '-' . '01'));
                foreach ($monthval as $v)
                {
                    if ((int)$v < 10)
                        $v = '0' . $v;
                    $newtime = strtotime($beginyear . '-' . $beginmonth . '-' . $v);
                    if ((int)$v > (int)$daynum || $newtime < $stime || $newtime > $etime)
                        continue;
                    $model = ORM::factory('hotel_room_price')->where("suitid=$roomid and day='$newtime'")->find();
                    $data_arr = array();
                    $data_arr['carid'] = $hotelid;
                    $data_arr['suitid'] = $roomid;
                    $data_arr['adultbasicprice'] = $basicprice;
                    $data_arr['adultprofit'] = $profit;
                    $data_arr['description'] = $description;
                    $data_arr['adultprice'] = $price;
                    $data_arr['day'] = $newtime;
                    $data_arr['number'] = $number;
                    if ($model->suitid)
                    {
                        $query = DB::update('hotel_room_price')->set($data_arr)->where("suitid=$roomid and day='$newtime'");
                        $query->execute();
                    }
                    else
                    {
                        foreach ($data_arr as $k => $v)
                        {
                            $model->$k = $v;
                        }
                        $model->save();
                    }
                }
                $beginmonth = (int)$beginmonth + 1;
                if ($beginmonth > 12)
                {
                    $beginmonth = $beginmonth - 12;
                    $beginyear++;
                }
                if (($beginmonth > $emonth && $beginyear >= $eyear) || ($beginmonth <= $emonth && $beginyear > $eyear))
                    break;
                $beginmonth = $beginmonth < 10 ? '0' . $beginmonth : $beginmonth;
            }
        }
        //按星期进行报价
        else if ($pricerule == 'week')
        {
            $begintime = $stime;
            while (true)
            {
                $cur_week = date('w', $begintime);
                $cur_week = $cur_week == 0 ? 7 : $cur_week;
                if (in_array($cur_week, $weekval))
                {
                    $model = ORM::factory('car_suit_price')->where("suitid=$roomid and day='$begintime'")->find();
                    $data_arr = array();
                    $data_arr['hotelid'] = $hotelid;
                    $data_arr['suitid'] = $roomid;
                    $data_arr['adultbasicprice'] = $basicprice;
                    $data_arr['adultprofit'] = $profit;
                    $data_arr['description'] = $description;
                    $data_arr['adultprice'] = $price;
                    $data_arr['day'] = $begintime;
                    $data_arr['number'] = $number;
                    if ($model->suitid)
                    {
                        $query = DB::update('car_suit_price')->set($data_arr)->where("suitid=$roomid and day='$begintime'");
                        $query->execute();
                    }
                    else
                    {
                        foreach ($data_arr as $k => $v)
                        {
                            $model->$k = $v;
                        }
                        $model->save();
                    }
                }
                $begintime = $begintime + 86400;
                if ($begintime > $etime)
                    break;
            }
        }
        Model_Car::update_min_price($hotelid);
    }


    /**
     * 动态修改积分
     */
    public function action_ajax_suit_jifen()
    {

        $field = Common::remove_xss(Arr::get($_GET,'field'));
        $suitid = Common::remove_xss(Arr::get($_GET,'suitid'));
        $v = Common::remove_xss(Arr::get($_GET,'v'));
        $m = ORM::factory('spot_ticket',$suitid);
        $m->$field = $v;
        $m->save();
    }
    /**
     * 删除套餐
     */
    public function action_ajax_suit_delete()
    {

        $suitid = Common::remove_xss(Arr::get($_GET,'suitid'));
        $status = 0;
        if($suitid)
        {
            $m = ORM::factory('spot_ticket',$suitid);
            $m->delete();
            if(!$m->loaded())
            {
                $status = 1;
            }
        }
        echo json_encode(array('status'=>$status));
    }

    //下线产品
    public function action_ajax_offline()
    {

        $status = 0;
        $ids = Common::remove_xss(Arr::get($_GET,'ids'));
        $sql = "UPDATE `sline_spot_ticket` SET ishidden=1 WHERE id IN($ids)";
        $flag = DB::query(Database::UPDATE,$sql)->execute();
        if($flag>0)
        {
            $status = 1;
        }
        echo json_encode(array('status'=>$status));
    }

    /**
     * 检测权限,是否能进行此操作
     */
    private function _check_right()
    {
        $right_arr = explode(',',$this->_user_info['authorization']);
        if(!in_array($this->_typeid,$right_arr))
        {
            exit('Warning:no right to do this!');
        }


    }

    public function action_ajax_verify_product()
    {
        $distributorid=$this->_user_info['id'];
        $id=$_POST['id'];
        $ticket = ORM::factory('spot_ticket', $id);
        if(!$ticket->loaded()||$ticket->distributorlist!=$distributorid)
        {
            echo json_encode(array('status'=>false,'msg'=>'权限不足'));
            return;
        }
        $ticket->status=1;
        $ticket->save();
        echo json_encode(array('status'=>true,'msg'=>'提交审核成功'));
    }

    //选择产品对话框
    public function action_dialog_get_spots()
    {
        $this->display('dialog_get_spots');
    }

    //获取产品列表
    public function action_ajax_get_products()
    {
        $typeid = $_POST['typeid'];
        $keyword = $_POST['keyword'];
        $page = intval($_POST['page']);
        $page = $page<1?1:$page;
        $pagesize = 10;
        $offset = $pagesize*($page-1);


        $w = " where id is not null and ishidden=0 ";
        if(!empty($keyword))
        {
            $w.=" and title like '%{$keyword}%' or id='{$keyword}'";
        }

        $sql = "select id,title,aid,webid from  sline_spot {$w} order by modtime desc limit {$offset},{$pagesize}";
        $sql_num = "select count(*) as num from sline_spot {$w}";
        $list = DB::query(Database::SELECT,$sql)->execute()->as_array();
        $num = DB::query(Database::SELECT,$sql_num)->execute()->get('num');

        foreach($list as &$v)
        {
            $v['series'] =St_Product::product_series($v['id'], $typeid);//编号
            $v['url'] = Common::get_web_url($v['webid']) . "/spots/show_{$v['aid']}.html";

        }
        echo json_encode(array('list'=>$list,'pagesize'=>$pagesize,'page'=>$page,'total'=>$num));

    }

    //获取门票类型
    public function action_ajax_get_ticket_types()
    {
        $spotid = $_POST['spotid'];
        $list = DB::select()->from('spot_ticket_type')->where('spotid','=',$spotid)->execute()->as_array();
        echo json_encode($list);
    }

    //修改所有价格
    public function action_dialog_edit_all_suit_price()
    {
        $suitid = $_GET['suitid'];
        $this->assign('suitid',$suitid);
        $this->display('dialog_edit_all_suit_price');
    }

    //完成设置一段时间内的报价
    public function action_ajax_save_all_price()
    {
        $ticketid = $_POST['suitid'];
        $spotid = DB::select('spotid')->from('spot_ticket')->where('id','=',$ticketid)->execute()->get('spotid');
        $_POST['number'] = $_POST['number_type']==1?'-1':$_POST['number'];
        $this->saveBaoJia($spotid,$ticketid,$_POST);
        $this->update_status_after_edit($ticketid);
    }

    //获取日历价格
    public function action_ajax_get_suit_price()
    {
        $suitid = $_POST['suitid'];
        $year = $_POST['year'];
        $month = $_POST['month'];

        //获取最近的报价时间
        if(!$year&&!$month)
        {
            $firstday = DB::select('day')->from('spot_ticket_price')
                ->where('ticketid','=',$suitid)->and_where('day','>=',strtotime(date('Y-m-d')))->limit(1)->execute()->get('day');
            if(empty($firstday))
            {
                exit(json_encode(array('starttime'=>'')));
            }
            $startday = date('Y-m-01',$firstday);
            //如果默认的当月的第一天小于当前时间，那么最近可编辑时间为当前时间
            if(strtotime($startday)<date('Y-m-d'))
            {
                $startday = date('Y-m-d');
            }
            $year = date('Y',$firstday);
            $month = date('m',$firstday);
        }
        else
        {
            $startday = date('Y-m-d');
        }

        $out = $this->get_suitprice_arr($year,$month,$suitid);
        $list = array();
        foreach ($out as $o)
        {
            $temp['date'] = $o['date'];
            $temp['price'] = $o['price'];
            $o['number']==-1 ? $temp['number'] = '充足' : $temp['number'] = $o['number'];
            $list[] = $temp;
        }
        echo  json_encode(array('list'=>$list,'starttime'=>$startday));
    }
    public function get_suitprice_arr($year, $month, $suitid)
    {

        $start = strtotime("$year-$month-1");
        $end = strtotime("$year-$month-31");

        $arr = DB::select()->from('spot_ticket_price')->where('ticketid', '=', $suitid)
            ->and_where('day', '>=', $start)
            ->and_where('day', '<=', $end)
            ->execute()->as_array();
        $price = array();
        foreach ($arr as $row)
        {
            if ($row)
            {
                $day = $row['day'];
                $price[$day]['date'] = Common::myDate('Y-m-d', $row['day']);
                $price[$day]['basicprice'] = isset($row['adultbasicprice']) ? $row['adultbasicprice'] : $row['basicprice'];
                $price[$day]['profit'] = isset($row['adultprofit']) ? $row['adultprofit'] : $row['profit'];
                $price[$day]['price'] = isset($row['adultprice']) ? $row['adultprice'] : $row['price'];

                $price[$day]['ticketid'] = $suitid;
                $price[$day]['number'] = $row['number'];//库存
            }
        }
        return $price;
    }

    //修改某天价格对话框
    public function action_dialog_edit_suit_price()
    {
        $suitid = $_GET['suitid'];
        $date = $_GET['date'];
        $date_time = strtotime($_GET['date']);
        $info = DB::select()->from('spot_ticket_price')->where('ticketid','=',$suitid)->and_where('day','=',$date_time)->execute()->current();
        $info = empty($info)?array('number'=>-1):$info;
        $this->assign('suitid',$suitid);
        $this->assign('date',$date);
        $this->assign('info',$info);
        $this->display('dialog_edit_suit_price');
    }

    //保存单独某个价格
    public function action_ajax_save_day_price()
    {

        $ticket_id =  $_POST['suitid'];
        $spotid = DB::select('spotid')->from('spot_ticket')->where('id','=',$ticket_id)->execute()->get('spotid');

        $info = array();
        $info['adultbasicprice'] = doubleval($_POST['adultbasicprice']);
        $info['adultprofit'] = doubleval($_POST['adultprofit']);
        $info['adultprice'] =  $info['adultbasicprice']+$info['adultprofit'];
       //$info['adultdistributionprice'] = $_POST['adultdistributionprice'];
        $store = $_POST['store'];
        $number = intval($_POST['number']);
        $info['number'] = $store=='1'?'-1':$number;
        $info['ticketid'] =$ticket_id;
        $info['spotid'] = $spotid;
        $date = $_POST['date'];
        $info['day'] = strtotime($_POST['date']);

        $save_status = false;
        if($info['adultprice']==0)
        {
            DB::delete('spot_ticket_price')->where('ticketid','=',$info['ticketid'])->and_where('day','=',$info['day'])->execute();
        }
        else
        {
            $row = DB::select()->from('spot_ticket_price')->where('ticketid','=',$info['ticketid'])->and_where('day','=',$info['day'])->execute()->current();
            if(empty($row))
            {
                $save_status = DB::insert('spot_ticket_price')->columns(array_keys($info))->values(array_values($info))->execute();
            }
            else
            {
                $save_status= DB::update('spot_ticket_price')->set($info)->where('ticketid','=',$info['ticketid'])->and_where('day','=',$info['day'])->execute();
            }
            $info['date'] = $date;
            $info['price'] = $info['adultprice'];
            echo json_encode($info);
        }
        $this->update_status_after_edit($ticket_id);
    }
    //清除报价
    public function action_ajax_clear_suit_price()
    {
        $suitid = $_POST['suitid'];
        DB::delete('spot_ticket_price')->where('ticketid','=',$suitid)->execute();
    }

    public function action_ajax_off_ticket()
    {
        $distributorid=$this->_user_info['id'];
        $id=$_POST['id'];
        $line = ORM::factory('spot_ticket', $id);
        if(!$line->loaded()||$line->distributorlist!=$distributorid||$line->status!=3)
        {
            echo json_encode(array('status'=>false,'msg'=>'权限不足'));
            return;
        }
        $line->status=2;
        $line->save();
        echo json_encode(array('status'=>true,'msg'=>'下线成功'));
    }
    public function action_ajax_up_ticket()
    {
        $distributorid=$this->_user_info['id'];
        $id=$_POST['id'];
        $line = ORM::factory('spot_ticket', $id);
        if(!$line->loaded()||$line->distributorlist!=$distributorid)
        {
            echo json_encode(array('status'=>false,'msg'=>'权限不足'));
            return;
        }
        $line->status=0;
        $line->save();
        echo json_encode(array('status'=>true,'msg'=>'上线成功'));
    }

    public function update_status_after_edit($suitid)
    {
        $cfg_spot_distributor_check_auto = DB::select('value')
            ->from('sysconfig')
            ->where('varname','=','cfg_spot_distributor_check_auto')
            ->execute()
            ->get('value');
        $data = array(
            'status'=>1
        );

        if($cfg_spot_distributor_check_auto==0)
        {
            DB::update('spot_ticket')->set($data)->where('id', '=', $suitid)->and_where('status', '>', 0)->execute();
        }
        else
        {
            $data = array(
                'status'=>3
            );
            DB::update('spot_ticket')->set($data)->where('id', '=', $suitid)->execute();
        }

    }
}