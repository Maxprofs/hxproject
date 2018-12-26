<?php

/**
 * Class Controller_Index
 */
class Controller_Index extends Stourweb_Controller
{
    private  $_typeid = 2;
    private  $_user_info = NULL;
    private $roomtype = array('单床1.5米', '大床1.8米', '大床2米', '双床1.2米', '双床1.5米', '双床1.8米', '三床1.2米', '大床/双床');//床型
    private $windowtype = array('有窗', '内窗', '无窗');
    private $repasttype = array('单早', '双早', '含', '不含', '早餐', '早晚餐', '三餐', '一价全包', '用晚含早');
    private $computertype = array('有线', 'WIFI', '含', '不含');

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

        $columns = ORM::factory('hotel_content')
            ->where("(webid=0 and isopen=1) or columnname='tupian'")
            ->order_by('displayorder', 'asc')
            ->get_all();
        $this->assign('columns', $columns);
        $this->assign('webid', 0);
        $this->assign('position', '添加酒店');
        $this->assign('action', 'add');
        $this->assign('ranklist', ORM::factory('hotel_rank')->get_all());
        $this->display('edit');
    }

    //修改产品
    public function action_edit()
    {

        $productid = intval(Arr::get($_GET,'id'));
        //星级列表
        $rank_list = Model_Hotel_Rank::get_list();
        $this->assign('ranklist', ORM::factory('hotel_rank')->get_all());
        $info = ORM::factory('hotel', $productid)->as_array();
        $columns = ORM::factory('hotel_content')->where("(webid=0 and isopen=1) or columnname='tupian'")->order_by('displayorder', 'asc')->get_all();
        $info['kindlist_arr'] = Model_Destinations::getKindlistArr($info['kindlist']);
        $info['attrlist_arr'] = Common::get_selected_attr(2, $info['attrid']);
        $info['iconlist_arr'] = Common::get_selected_icon($info['iconlist']);
        $info['piclist_arr'] = json_encode(Common::get_upload_picture($info['piclist']));//图片数组
        $extend_info = Common::get_extend_info($this->_typeid,$info['id']);
        $this->assign('columns', $columns);
        $this->assign('extendinfo', $extend_info);//扩展信息
        $this->assign('ranklist',$rank_list);
        $this->assign('info', $info);
        $this->assign('action', 'edit');
        $this->assign('position', '修改酒店' . $info['title']);
        $this->display('edit');
    }

    //酒店保存

    public function action_ajax_save()
    {

        $action = Arr::get($_POST, 'action');//当前操作
        $id = Arr::get($_POST, 'productid');
        $status = false;
        $webid = Arr::get($_POST, 'webid');//所属站点
        //添加操作
        if ($action == 'add' && empty($id))
        {
            $model = ORM::factory('hotel');
            $model->aid = Common::get_last_aid('sline_hotel', $webid);
            $model->addtime = time();
        }
        else
        {
            $model = ORM::factory('hotel', $id);
            if ($model->webid != $webid) //如果更改了webid重新生成aid
            {
                $model->aid = Common::get_last_aid('sline_hotel', $webid);
            }
            $productid = $id;
        }
        $attrids = implode(',', Arr::get($_POST, 'attrlist'));//属性
        if (!empty($attrids))
        {
            $attrmode = ORM::factory("hotel_attr")->where("id in ($attrids)")->group_by('pid')->get_all();
            foreach ($attrmode as $k => $v)
            {
                $attrids = $v['pid'] . ',' . $attrids;
            }
        }
        $imagestitle = Arr::get($_POST, 'imagestitle');
        $images = Arr::get($_POST, 'images');
        $imgheadindex = Arr::get($_POST, 'imgheadindex');
        //图片处理
        $piclist = '';
        $litpic = $images[$imgheadindex];
        for ($i = 1; isset($images[$i]); $i++)
        {
            $desc = isset($imagestitle[$i]) ? $imagestitle[$i] : '';
            $pic = !empty($desc) ? $images[$i] . '||' . $desc : $images[$i];
            $piclist .= $pic . ',';
        }
        $piclist = strlen($piclist) > 0 ? substr($piclist, 0, strlen($piclist) - 1) : '';//图片
        $kindlist = Arr::get($_POST, 'kindlist');
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
        $model->title = Arr::get($_POST, 'title');
        $model->address = Arr::get($_POST, 'address');
        $model->webid = $webid;
        $model->sellpoint = Arr::get($_POST, 'sellpoint');
        $model->recommendnum = $_POST['recommendnum'];
        $model->telephone = Arr::get($_POST, 'telephone');
        $model->opentime = Arr::get($_POST, 'opentime');
        $model->decoratetime = Arr::get($_POST, 'decoratetime');//装修时间
        $model->opentime = Arr::get($_POST, 'opentime');
        $model->kindlist = implode(',', Model_Destinations::getParentsStr(implode(',', $kindlist)));//所属目的地
        $model->finaldestid = empty($_POST['finaldestid']) ? Model_Destinations::getFinaldestId(explode(',', $model->kindlist)) : $_POST['finaldestid'];
        $model->attrid = $attrids;//属性
        $model->iconlist = implode(',', Arr::get($_POST, 'iconlist'));//图标
        $model->distributorlist = $this->_user_info['id'];
        $model->satisfyscore = Arr::get($_POST, 'satisfyscore') ? Arr::get($_POST, 'satisfyscore') : 0;//满意度
        $model->bookcount = Arr::get($_POST, 'bookcount') ? Arr::get($_POST, 'bookcount') : 0;//销量
        $model->piclist = $piclist;

        $model->litpic = Arr::get($_POST, 'litpic');//封面图
        $model->traffic = Arr::get($_POST, 'jiaotong');//交通指南
        $model->notice = Arr::get($_POST, 'zhuyi');//注意事项
        $model->equipment = Arr::get($_POST, 'fujian');//附件
        $model->aroundspots = Arr::get($_POST, 'zhoubian');//周边景点
        $model->seotitle = Arr::get($_POST, 'seotitle');//优化标题
        $model->tagword = Arr::get($_POST, 'tagword');
        $model->keyword = Arr::get($_POST, 'keyword');
        $model->description = Arr::get($_POST, 'description');
        $model->fuwu = $_POST['fuwu'];
        $model->modtime = time();
        $model->hotelrankid = Arr::get($_POST, 'hotelrankid');
        $model->lng = $_POST['lng'];
        $model->lat = $_POST['lat'];
        $link = new Model_Tool_Link();
        $model->content = $link->keywordReplaceBody(Arr::get($_POST, 'jieshao'), 2);
        $model->litpic = $litpic;
        $model->templet = Arr::get($_POST, 'templet');
        if ($action == 'add' && empty($id))
        {
            $model->ishidden = 1;//默认隐藏
            $model->save();

        }
        else
        {
            if($this->_user_info['id'] != $model->distributorlist)
            {
                echo json_encode(array('status' => 0, 'msg' => '只能修改自己的产品信息'));
                exit;
            }
            $model->save();
        }
        if ($model->saved())
        {
            if ($action == 'add')
            {
                $productid = $model->id; //插入的产品id
            }
            Common::save_extend_data($this->_typeid, $productid, $_POST);//扩展信息保存
            $status = true;
        }
        echo json_encode(array('status' => $status, 'productid' => $productid));

    }

    //产品列表页
    public function action_list()
    {
        $templet = Common::remove_xss(Arr::get($_GET,'templet'));
        $keyword = Common::remove_xss(Arr::get($_GET,'keyword'));
        $pagesize = intval(Arr::get($_GET,'pagesize'));
        $pagesize = $pagesize ? $pagesize : 30;
        $templet = !empty($templet) ? $templet : 'list';
        $data = Model_Hotel::hotel_list($pagesize,$keyword);
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

        $info = array('lastoffer' => array('pricerule' => 'all'));
        $this->assign('position', '添加房型');
        $this->assign('action', 'add');
        $hotelid = Arr::get($_GET,'productid');
        $info['hotelid'] = $hotelid;
        $hotelinfo = ORM::factory('hotel', $hotelid)->as_array();
        $this->assign('hotelname', $hotelinfo['title']);
        $this->assign('hotelid', $hotelid);
        $this->assign('roomtype', $this->roomtype);
        $this->assign('windowtype', $this->windowtype);
        $this->assign('repasttype', $this->repasttype);
        $this->assign('computertype', $this->computertype);
        $this->assign('info',$info);
        $this->display('suit_edit');
    }



    //套餐修改
    public function action_suit_edit()
    {

        $suitid = intval(Arr::get($_GET,'id'));
        if($suitid)
        {
            $info = ORM::factory('hotel_room',$suitid)->as_array();
            $hotelname = ORM::factory('hotel',$info['hotelid'])->get('title');
            $info['lastoffer'] = unserialize($info['lastoffer']);
            if (empty($info['lastoffer']))
            {
                $info['lastoffer'] = array('pricerule' => 'all');
            }
            $info['piclist_arr'] = json_encode(Common::get_upload_picture($info['piclist']));//图片数组
            $this->assign('hotelname',$hotelname);
            $this->assign('info',$info);
            $this->assign('position','修改酒店房型');
            $this->assign('action','edit');
            $this->assign('roomtype', $this->roomtype);
            $this->assign('windowtype', $this->windowtype);
            $this->assign('repasttype', $this->repasttype);
            $this->assign('computertype', $this->computertype);
            $this->display('suit_edit');
        }



    }

    //套餐保存
    public function action_ajax_suit_save()
    {


        $action = Arr::get($_POST, 'action');
        $hotelid = Arr::get($_POST, 'hotelid');
        $images = Arr::get($_POST, 'images');
        $imagestitle = Arr::get($_POST, 'imagestitle');
        $roomid = Arr::get($_POST, 'roomid');//房间id
        $description = Arr::get($_POST, 'description');//房型说明
        $suitid = $roomid;

        //权限判断
        $distributor = ORM::factory('hotel',$hotelid)->get('distributorlist');
        if($distributor!=$this->_user_info['id'])
        {
            echo json_encode(array('status' => 0, 'msg' => '只能修改/添加自己套餐产品'));
            exit;
        }

        //图片处理
        $piclist = '';
        for ($i = 1; isset($images[$i]); $i++)
        {
            $desc = isset($imagestitle[$i]) ? $imagestitle[$i] : '';
            $pic = !empty($desc) ? $images[$i] . '||' . $desc : $images[$i];
            $piclist .= $pic . ',';
        }
        $piclist = strlen($piclist) > 0 ? substr($piclist, 0, strlen($piclist) - 1) : '';//图片
        //添加保存
        if ($action == 'add' && empty($roomid))
        {
            $model = ORM::factory('hotel_room');
            $model->hotelid = $hotelid;
        }
        else //修改保存
        {
            $model = ORM::factory('hotel_room', $roomid);
        }
        $model->roomname = Arr::get($_POST, 'roomname');
        $model->sellprice = Arr::get($_POST, 'sellprice') ? Arr::get($_POST, 'sellprice') : 0;
        $model->price = Arr::get($_POST, 'price') ? Arr::get($_POST, 'price') : 0;
        $model->roomstyle = Arr::get($_POST, 'roomstyle');
        $model->breakfirst = Arr::get($_POST, 'breakfirst');
        $model->computer = Arr::get($_POST, 'computer');
        $model->roomarea = Arr::get($_POST, 'roomarea');
        $model->roomfloor = Arr::get($_POST, 'roomfloor');
        $model->roomwindow = Arr::get($_POST, 'roomwindow');
        $model->number = Arr::get($_POST, 'roomnum') ? Arr::get($_POST, 'roomnum') : 0;
        $model->jifencomment = Arr::get($_POST, 'jifencomment') ? Arr::get($_POST, 'jifencomment') : 0;
        $model->jifentprice = Arr::get($_POST, 'jifentprice') ? Arr::get($_POST, 'jifentprice') : 0;
        $model->jifenbook = Arr::get($_POST, 'jifenbook') ? Arr::get($_POST, 'jifenbook') : 0;
        $model->paytype = Arr::get($_POST, 'paytype') ? Arr::get($_POST, 'paytype') : 1;
        $model->dingjin = Arr::get($_POST, 'dingjin');
        $model->piclist = $piclist;
        $model->description = $description;
        $model->lastoffer = Common::last_offer(2, $_POST);
        if ($action == 'add' && empty($roomid))
        {
            $model->create();
        }
        else
        {
            $model->save();
        }
        if ($model->saved())
        {
            if ($action == 'add')
            {
                $roomid = $model->id; //插入的产品id
                $suitid = $roomid;
            }
            else
            {
                $roomid = null;
            }
            $status = true;
        }
        self::save_baojia($hotelid, $suitid, $_POST);
        echo json_encode(array('status' => $status, 'roomid' => $roomid));
    }

    /*
    * 酒店房型报价
    * */
    public function save_baojia($hotelid, $roomid, $arr)
    {

        $pricerule = Arr::get($arr, 'pricerule');
        $starttime = Arr::get($arr, 'starttime');
        $endtime = Arr::get($arr, 'endtime');
        $basicprice = Arr::get($arr, 'basicprice') ? Arr::get($arr, 'basicprice') : 0;
        $profit = Arr::get($arr, 'profit') ? Arr::get($arr, 'profit') : 0;
        $description = Arr::get($arr, 'suit_description');
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
                $model = ORM::factory('hotel_room_price')->where("suitid=$roomid and day='$begintime'")->find();
                $data_arr = array();
                $data_arr['hotelid'] = $hotelid;
                $data_arr['suitid'] = $roomid;
                $data_arr['basicprice'] = $basicprice;
                $data_arr['profit'] = $profit;
                $data_arr['description'] = $description;
                $data_arr['price'] = $price;
                $data_arr['day'] = $begintime;
                $data_arr['number'] = $number;
                if(empty($price))
                {
                    $query = DB::delete('hotel_room_price')->where("suitid=$roomid and day='$begintime'");
                    $query->execute();
                }
                else if ($model->suitid)
                {
                    $query = DB::update('hotel_room_price')->set($data_arr)->where("suitid=$roomid and day='$begintime'");
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
                    $data_arr['hotelid'] = $hotelid;
                    $data_arr['suitid'] = $roomid;
                    $data_arr['basicprice'] = $basicprice;
                    $data_arr['profit'] = $profit;
                    $data_arr['description'] = $description;
                    $data_arr['price'] = $price;
                    $data_arr['day'] = $newtime;
                    $data_arr['number'] = $number;
                    if(empty($price))
                    {
                        $query = DB::delete('hotel_room_price')->where("suitid=$roomid and day='$newtime'");
                        $query->execute();
                    }
                    else if ($model->suitid)
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
                    $model = ORM::factory('hotel_room_price')->where("suitid=$roomid and day='$begintime'")->find();
                    $data_arr = array();
                    $data_arr['hotelid'] = $hotelid;
                    $data_arr['suitid'] = $roomid;
                    $data_arr['basicprice'] = $basicprice;
                    $data_arr['profit'] = $profit;
                    $data_arr['description'] = $description;
                    $data_arr['price'] = $price;
                    $data_arr['day'] = $begintime;
                    $data_arr['number'] = $number;
                    if(empty($price))
                    {
                        $query = DB::delete('hotel_room_price')->where("suitid=$roomid and day='$begintime'");
                        $query->execute();
                    }
                    else if ($model->suitid)
                    {
                        $query = DB::update('hotel_room_price')->set($data_arr)->where("suitid=$roomid and day='$begintime'");
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
        Model_Hotel::update_min_price($hotelid);
    }


    /**
     * 动态修改积分
     */
    public function action_ajax_suit_jifen()
    {

        $field = Common::remove_xss(Arr::get($_GET,'field'));
        $suitid = Common::remove_xss(Arr::get($_GET,'suitid'));
        $v = Common::remove_xss(Arr::get($_GET,'v'));
        $m = ORM::factory('hotel_room',$suitid);
        $m->$field = $v;
        $m->save();
    }
    /**
     * 删除房型
     */
    public function action_ajax_suit_delete()
    {

        $suitid = Common::remove_xss(Arr::get($_GET,'suitid'));
        $status = 0;
        if($suitid)
        {
            $m = ORM::factory('hotel_room',$suitid);
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
        $id_arr = explode(',',$ids);
        foreach($id_arr as $id)
        {
            $sql = "UPDATE `sline_hotel` SET ishidden='1' WHERE id=$id";
            $flag = DB::query(Database::UPDATE,$sql)->execute();
        }

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




 

  
}