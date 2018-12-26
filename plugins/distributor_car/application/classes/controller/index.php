<?php

/**
 * Class Controller_Index
 */
class Controller_Index extends Stourweb_Controller
{
    private  $_typeid = 3;
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
        $this->assign('carkindidlist', ORM::factory('car_kind')->where('webid=0')->get_all());
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
        $columns = ORM::factory('car_content')->where("(webid=0 and isopen=1) or columnname='tupian'")->order_by('displayorder', 'asc')->get_all();
        $this->assign('columns', $columns);
        $this->display('edit');
    }

    //修改产品
    public function action_edit()
    {

        $productid = intval(Arr::get($_GET,'id'));
        $info = ORM::factory('car', $productid)->as_array();
        $info['kindlist_arr'] = Model_Destinations::getKindlistArr($info['kindlist']);
        $info['attrlist_arr'] = Common::get_selected_attr($this->_typeid, $info['attrid']);
        $info['iconlist_arr'] = Common::get_selected_icon($info['iconlist']);
        $info['distributor_arr'] = ORM::factory('distributor', $info['distributorlist'])->as_array();
        $info['piclist_arr'] = json_encode(Common::get_upload_picture($info['piclist']));//图片数组
        $columns = ORM::factory('car_content')->where("(webid=0 and isopen=1) or columnname='tupian'")->order_by('displayorder', 'asc')->get_all();
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

        $carid = Arr::get($_POST, 'carid');
        $webid = Arr::get($_POST, 'webid');
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
        $attrids = implode(',', Arr::get($_POST, 'attrlist'));//属性
        if (!empty($attrids))
        {
            $attrmode = ORM::factory("car_attr")->where("id in ($attrids)")->group_by('pid')->get_all();
            foreach ($attrmode as $k => $v)
            {
                $attrids = $v['pid'] . ',' . $attrids;
            }
        }
        $data_arr = array();
        $data_arr['title'] = Arr::get($_POST, 'title');
        $data_arr['sellpoint'] = Arr::get($_POST, 'sellpoint') ? Arr::get($_POST, 'sellpoint') : '';
        $data_arr['seatnum'] = Arr::get($_POST, 'seatnum') ? Arr::get($_POST, 'seatnum') : 0;
        $data_arr['maxseatnum'] = Arr::get($_POST, 'maxseatnum') ? Arr::get($_POST, 'maxseatnum') : 0;
        $data_arr['usedyears'] = Arr::get($_POST, 'usedyears') ? Arr::get($_POST, 'usedyears') : 0;
        $data_arr['phone'] = Arr::get($_POST, 'phone') ? Arr::get($_POST, 'phone') : 0;
        $link = new Model_Tool_Link();
        $data_arr['content'] = $link->keywordReplaceBody(Arr::get($_POST, 'content'), 3);
        $data_arr['notice'] = Arr::get($_POST, 'notice');
        $data_arr['recommendnum'] = $_POST['recommendnum'];
        $data_arr['satisfyscore'] = Arr::get($_POST, 'satisfyscore') ? Arr::get($_POST, 'satisfyscore') : 90;
        $data_arr['bookcount'] = Arr::get($_POST, 'bookcount') ? Arr::get($_POST, 'bookcount') : 0;
        $data_arr['webid'] = $webid;
        $data_arr['carkindid'] = Arr::get($_POST, 'carkindid');
        $data_arr['kindlist'] = implode(',', Model_Destinations::getParentsStr(implode(',', $kindlist)));
        $data_arr['finaldestid']=empty($_POST['finaldestid'])?Model_Destinations::getFinaldestId(explode(',',$data_arr['kindlist'])):$_POST['finaldestid'];
        $data_arr['attrid'] = $attrids;
        $data_arr['iconlist'] = implode(',', Arr::get($_POST, 'iconlist'));
        $data_arr['seotitle'] = Arr::get($_POST, 'seotitle');//优化标题
        $data_arr['tagword'] = Arr::get($_POST, 'tagword');
        $data_arr['keyword'] = Arr::get($_POST, 'keyword');
        $data_arr['description'] = Arr::get($_POST, 'description');
        $data_arr['templet'] = Arr::get($_POST, 'templet');
        $data_arr['modtime'] = time();
        //图片处理
        $images_arr = Arr::get($_POST, 'images');
        $imagestitle_arr = Arr::get($_POST, 'imagestitle');
        $headimgindex = Arr::get($_POST, 'imgheadindex');
        $imgstr = "";
        foreach ($images_arr as $k => $v)
        {
            $imgstr .= $v . '||' . $imagestitle_arr[$k] . ',';
            if ($headimgindex == $k)
            {
                $data_arr['litpic'] = $v;
            }
        }
        $imgstr = trim($imgstr, ',');
        $data_arr['piclist'] = $imgstr;
        if ($carid)
        {
            $model = ORM::factory('car', $carid);
            $model->modtime = time();
        }
        else
        {
            $model = ORM::factory('car');
            $model->aid = Common::get_last_aid('sline_car', $data_arr['webid']);
            $model->addtime = time();
            $model->distributorlist = $this->_user_info['id'];
            $model->ishidden = 1;//默认隐藏
        }
        foreach ($data_arr as $k => $v)
        {
            $model->$k = $v;
        }
        $status = 0;
        $model->save();
        if ($model->saved())
        {
            $model->reload();
            $status = 1;
            $carid = $model->id;
            Common::save_extend_data($this->_typeid, $carid, $_POST);//扩展信息保存
        }
        echo json_encode(array('status' => $status, 'productid' => $carid));

    }

    //产品列表页
    public function action_list()
    {
        $templet = Common::remove_xss(Arr::get($_GET,'templet'));
        $keyword = Common::remove_xss(Arr::get($_GET,'keyword'));
        $pagesize = intval(Arr::get($_GET,'pagesize'));
        $pagesize = $pagesize ? $pagesize : 30;
        $templet = !empty($templet) ? $templet : 'list';
        $data = Model_Car::car_list($pagesize,$keyword);
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

        $this->assign('action', 'add');
        $carid = Arr::get($_GET,'productid');

        $info['carid'] = $carid;
        $carinfo = ORM::factory('car', $carid)->as_array();
        $this->assign('position','添加套餐');
        $this->assign('carname', $carinfo['title']);
        $this->assign('carid', $carid);
        $this->display('suit_edit');
    }



    //套餐修改
    public function action_suit_edit()
    {

        $suitid = intval(Arr::get($_GET,'id'));

        if($suitid)
        {

            $info = ORM::factory('car_suit',$suitid)->as_array();
            $carname = ORM::factory('car',$info['carid'])->get('title');
            $info['lastoffer'] = unserialize($info['lastoffer']);
            if (empty($info['lastoffer']))
            {
                $info['lastoffer'] = array('pricerule' => 'all');
            }
            $suittypes = ORM::factory('car_suit_type')->where("carid=" . $info['carid'])->get_all();
            $this->assign("suittypes",$suittypes);
            $this->assign('carname',$carname);
            $this->assign('info',$info);
            $this->assign('carid',$info['carid']);
            $this->assign('action','edit');
            $this->assign('position','修改套餐');
            $this->display('suit_edit');
        }



    }

    //套餐保存
    public function action_ajax_suit_save()
    {


        $carid = Arr::get($_POST, 'carid');
        $suitid = Arr::get($_POST, 'suitid');
        //权限判断
        $distributor = ORM::factory('car',$carid)->get('distributorlist');
        if($distributor!=$this->_user_info['id'])
        {
            echo json_encode(array('status' => 0, 'msg' => '只能修改/添加自己套餐产品'));
            exit;
        }
        $suittypeid = Arr::get($_POST, 'suittypeid');
        $newsuittype = Arr::get($_POST,'newsuittype');
        if(!empty($newsuittype))
        {
            $suittypeid = Model_Car::add_suittype($newsuittype,$carid);
        }

        $data_arr = array();
        $data_arr['suitname'] = Arr::get($_POST, 'suitname');
        $data_arr['carid'] = Arr::get($_POST, 'carid');
        $data_arr['content'] = Arr::get($_POST, 'content');
        $data_arr['unit'] = Arr::get($_POST, 'unit');
        $data_arr['suittypeid'] = $suittypeid;
        $data_arr['jifentprice'] = Arr::get($_POST, 'jifentprice') ? Arr::get($_POST, 'jifentprice') : 0;
        $data_arr['jifenbook'] = Arr::get($_POST, 'jifenbook') ? Arr::get($_POST, 'jifenbook') : 0;
        $data_arr['jifencomment'] = Arr::get($_POST, 'jifencomment') ? Arr::get($_POST, 'jifencomment') : 0;
        $data_arr['paytype'] = Arr::get($_POST, 'paytype');
        $data_arr['dingjin'] = Arr::get($_POST, 'dingjin') ? Arr::get($_POST, 'dingjin') : 0;
        $data_arr['lastoffer'] = Common::last_offer(3, $_POST);
        if ($suitid)
        {
            $model = ORM::factory('car_suit', $suitid);
        }
        else
            $model = ORM::factory('car_suit');
        foreach ($data_arr as $k => $v)
        {
            $model->$k = $v;
        }
        $model->save();
        $status = 0;
        if ($model->saved())
        {
            $status = 1;
            $model->reload();
            $suitid = $model->id;
            $this->save_baojia($carid, $suitid, $_POST);
        }
        echo json_encode(array('status' => $status, 'suitid' => $suitid));
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
                if(empty($price))
                {
                    $query = DB::delete('car_suit_price')->where("suitid=$roomid and day='$begintime'");
                    $query->execute();
                }
                else if ($model->suitid)
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
                    $model = ORM::factory('car_suit_price')->where("suitid=$roomid and day='$newtime'")->find();
                    $data_arr = array();
                    $data_arr['carid'] = $hotelid;
                    $data_arr['suitid'] = $roomid;
                    $data_arr['adultbasicprice'] = $basicprice;
                    $data_arr['adultprofit'] = $profit;
                    $data_arr['description'] = $description;
                    $data_arr['adultprice'] = $price;
                    $data_arr['day'] = $newtime;
                    $data_arr['number'] = $number;
                    if(empty($price))
                    {
                        $query = DB::delete('car_suit_price')->where("suitid=$roomid and day='$newtime'");
                        $query->execute();
                    }
                    else if ($model->suitid)
                    {
                        $query = DB::update('car_suit_price')->set($data_arr)->where("suitid=$roomid and day='$newtime'");
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
                    $data_arr['carid'] = $hotelid;
                    $data_arr['suitid'] = $roomid;
                    $data_arr['adultbasicprice'] = $basicprice;
                    $data_arr['adultprofit'] = $profit;
                    $data_arr['description'] = $description;
                    $data_arr['adultprice'] = $price;
                    $data_arr['day'] = $begintime;
                    $data_arr['number'] = $number;
                    if(empty($price))
                    {
                        $query = DB::delete('car_suit_price')->where("suitid=$roomid and day='$begintime'");
                        $query->execute();
                    }
                    else if ($model->suitid)
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
        $m = ORM::factory('car_suit',$suitid);
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
            $m = ORM::factory('car_suit',$suitid);
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
        $sql = "UPDATE `sline_car` SET ishidden=1 WHERE id IN($ids)";
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




 

  
}