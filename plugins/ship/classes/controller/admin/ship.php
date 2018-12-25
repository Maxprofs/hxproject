<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/6 0006
 * Time: 10:01
 */
class Controller_Admin_Ship extends Stourweb_Controller{
    private $_typeid = 104;
    public function before()
    {
        parent::before();
        $action = $this->request->action();
        $this->assign('parentkey', $this->params['parentkey']);
        $this->assign('itemid', $this->params['itemid']);
        $this->assign('weblist', Common::getWebList());
    }
    public function action_index()
    {
        $action=$this->params['action'];
        if(empty($action))  //显示线路列表页
        {
            $this->display('admin/ship/index');
        }
        else if($action=='read')    //读取列表
        {
            $start=Arr::get($_GET,'start');
            $limit=Arr::get($_GET,'limit');
            $keyword=Arr::get($_GET,'keyword');
            $sort=json_decode(Arr::get($_GET,'sort'),true);
            $order='order by a.modtime desc';
            if($sort[0]['property'])
            {
                if($sort[0]['property']=='displayorder')
                    $prefix='';
                else if($sort[0]['property']=='ishidden')
                {
                    $prefix='a.';
                }
                else if($sort[0]['property']=='modtime')
                {
                    $prefix='a.';
                }
                $order='order by '.$prefix.$sort[0]['property'].' '.$sort[0]['direction'].',a.modtime desc';


            }
            $w="a.id is not null";
            $w.=empty($keyword)?'':" and a.title like '%{$keyword}%'";

            $sql="select a.* from sline_ship as a where $w $order limit $start,$limit";

            $totalcount_arr=DB::query(Database::SELECT,"select count(*) as num from sline_ship a where $w")->execute()->as_array();
            $list=DB::query(Database::SELECT,$sql)->execute()->as_array();

            foreach($list as $k=>&$v)
            {
                $supplier_model = ORM::factory('supplier',$v['supplierlist']);
                if($supplier_model->loaded())
                    $v['suppliername'] = $supplier_model->suppliername;
                $v['url'] = Common::getBaseUrl(0) . '/ship/cruise_' . $v['id'] . '.html';
            }
            $result['total']=$totalcount_arr[0]['num'];
            $result['lists']=$list;
            $result['success']=true;
            echo json_encode($result);
        }
        else if($action=='save')   //保存字段
        {

        }
        else if($action=='delete') //删除某个记录
        {
            $rawdata=file_get_contents('php://input');
            $data=json_decode($rawdata);
            $id=$data->id;

            if(is_numeric($id))
            {
                $model=ORM::factory('ship',$id);
                $model->delete();
            }
        }
        else if($action=='update')//更新某个字段
        {
            $id=Arr::get($_POST,'id');
            $field=Arr::get($_POST,'field');
            $val=Arr::get($_POST,'val');

                if(is_numeric($id))
                {
                    $model=ORM::factory('ship',$id);
                }
                if($model->id)
                {
                    $model->$field=$val;
                    $model->save();
                    if($model->saved())
                        echo 'ok';
                    else
                        echo 'no';
                }
        }


    }
    /*
    * 添加页面
    * */
    public function action_add()
    {
        $this->assign('position','添加游轮');
        $this->assign('action','add');
        $supplierlist = Ship::get_suppliers();
        $this->assign('supplierlist',$supplierlist);
        $this->display('admin/ship/edit');
    }
    /*
    * 修改页面
    * */
    public function action_edit()
    {
        $productid = $this->params['id'];

        $this->assign('action','edit');
        $info = ORM::factory('ship',$productid)->as_array();
        $info['piclist_arr'] =  json_encode(Common::getUploadPicture($info['piclist']));//图片数组


        $supplierlist = Ship::get_suppliers();
        $this->assign('supplierlist',$supplierlist);
        $this->assign('info',$info);
        $this->assign('position','修改游轮'.$info['title']);
        $this->display('admin/ship/edit');
    }
    /*
    * 保存(ajax)
    * */
    public function action_ajax_save()
    {
        $action = Arr::get($_POST,'action');//当前操作
        $id = Arr::get($_POST,'productid');
        $status = false;

        $content = Arr::get($_POST,'content');//文章内容

        $imagestitle = Arr::get($_POST,'imagestitle');
        $images = Arr::get($_POST,'images');
        $imgheadindex = Arr::get($_POST,'imgheadindex');
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
        if($action == 'add' && empty($id))
        {
            $model = ORM::factory('ship');
            $model->addtime = time();
        }
        else
        {
            $model = ORM::factory('ship',$id);

        }

        $model->title = Arr::get($_POST,'title');
        $model->seotitle = Arr::get($_POST,'seotitle');
        $model->keyword = Arr::get($_POST,'keyword');
        $model->tagword = Arr::get($_POST,'tagword');
        $model->description = Arr::get($_POST,'description');
        $model->modtime = Arr::get($_POST,'modtime');
        $model->litpic = $litpic;
        $model->ishidden = Arr::get($_POST,'ishidden')?Arr::get($_POST,'ishidden'):0;//显示隐藏
        $model->floornum = intval($_POST['floornum']);
        $model->supplierlist = $_POST['supplierlist'];
        $model->seatnum = intval($_POST['seatnum']);
        $model->length = intval($_POST['length']);
        $model->width = intval($_POST['width']);
        $model->weight = intval($_POST['weight']);
        $model->speed = intval($_POST['speed']);
        $model->sailtime = $_POST['sailtime'];
        $model->content = $_POST['content'];
        $model->piclist = $piclist;
        $model->litpic = $litpic;

        if($action=='add' && empty($id))
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
            $status = true;
        }
        echo json_encode(array('status'=>$status,'productid'=>$productid));

    }

    /**
     * 航次列表
     */
    public function action_schedulelist()
    {
        $action=$this->params['action'];
        if($action=='read')    //读取列表
        {

            $start=Arr::get($_GET,'start');
            $limit=Arr::get($_GET,'limit');
            $shipid = $_GET['shipid'];
            $w="where id is not null and shipid='$shipid'";

            $sql="select * from sline_ship_schedule $w limit $start,$limit";

            $totalcount_arr=DB::query(Database::SELECT,"select count(*) as num from sline_ship_schedule $w")->execute()->as_array();
            $list=DB::query(Database::SELECT,$sql)->execute()->as_array();
            $result['total']=$totalcount_arr[0]['num'];
            $result['lists']=$list;
            $result['success']=true;
            echo json_encode($result);
        }
        else if($action=='delete') //删除某个记录
        {
            $rawdata=file_get_contents('php://input');
            $data=json_decode($rawdata);
            $id=$data->id;
            if(is_numeric($id))
            {
                $model=ORM::factory('ship_schedule',$id);
                $model->delete();
            }
        }
    }

    /**
     * 添加楼层
     */
    public function action_scheduleadd()
    {
        $shipid = $this->params['shipid'];
        $this->assign('shipid',$shipid);
        $this->assign('action','add');
        $this->display('admin/ship/scheduleedit');
    }
    /**
     * 编辑楼层
     */
    public function action_scheduleedit()
    {
        $shipid = $this->params['shipid'];
        $id = $this->params['id'];
        $floor_model = ORM::factory('ship_schedule',$id);
        $info = $floor_model->as_array();

        $timelist = ORM::factory('ship_schedule_date')->where('scheduleid','=',$id)->get_all();
        $this->assign('timelist',$timelist);
        $this->assign('shipid',$info['shipid']);
        $this->assign('info',$info);
        $this->assign('action','edit');
        $this->display('admin/ship/scheduleedit');
    }

    /**
     * 保存航次
     */
    public function action_ajax_schedule_save()
    {

        $action = Arr::get($_POST,'action');//当前操作
        $id = Arr::get($_POST,'id');
        $shipid = $_POST['shipid'];
        $starttime = $_POST['starttime'];
        $endtime = $_POST['endtime'];
        $newstarttime = $_POST['newstarttime'];
        $newendtime = $_POST['newendtime'];

        if($action == 'add' && empty($id))
        {
            $model = ORM::factory('ship_schedule');
            $model->shipid=$shipid;
        }
        else
        {
            $model = ORM::factory('ship_schedule',$id);

        }
        $model->title = Arr::get($_POST,'title');
        $model->shipid = $shipid;
        if($action=='add' && empty($id))
        {
            $model->create();
        }
        else
        {
            $model->update();
        }
        $newtimelist=array();
        if($model->saved())
        {
            if($action=='add')
            {
                $id = $model->id; //插入的产品id
            }
            $status = true;

            foreach($starttime as $k=>$v)
            {
                $time_model = ORM::factory('ship_schedule_date',$k);
                if($time_model->loaded())
                {
                    $time_model->starttime = strtotime($v);
                    $time_model->endtime = strtotime($endtime[$k]);
                    $time_model->save();
                }
            }

            foreach($newstarttime as $key=>$val)
            {
                $new_timemodel = ORM::factory('ship_schedule_date');
                $new_timemodel->starttime = strtotime($val);
                $new_timemodel->endtime = strtotime($newendtime[$key]);
                $new_timemodel->scheduleid = $id;
                $new_timemodel->save();
                if($new_timemodel->saved())
                {
                    $new_timemodel->reload();
                }
                $newtimelist[]=array('id'=>$new_timemodel->id,'begintime'=>$val,'endtime'=>$newendtime[$key]);
            }
        }
        echo json_encode(array('status'=>$status,'productid'=>$id,'newlist'=>$newtimelist));
    }

    /**
     * 删除航次时间
     */
    public function action_ajax_schedule_timedel()
    {
        $id = $_POST['id'];
        $model = ORM::factory('ship_schedule_date',$id);
        if($model->loaded())
        {
            $model->delete();
            echo json_encode(array('status'=>true));
        }
    }
    /**
     * 楼层列表
     */
    public function action_floorlist()
    {
        $action=$this->params['action'];
        if($action=='read')    //读取列表
        {

            $start=Arr::get($_GET,'start');
            $limit=Arr::get($_GET,'limit');
            $shipid = $_GET['shipid'];
            $w="where id is not null and shipid='$shipid'";
            $sort = json_decode($_GET['sort'],true);
            $order='';
            if(!empty($sort))
            {
                $order.=' order by '.$sort[0]['property'].' '.$sort[0]['direction'];
            }

            $sql="select * from sline_ship_floor $w {$order} limit $start,$limit";

            $totalcount_arr=DB::query(Database::SELECT,"select count(*) as num from sline_ship_floor $w")->execute()->as_array();
            $list=DB::query(Database::SELECT,$sql)->execute()->as_array();
            foreach($list as $k=>&$v)
            {
                $v['rooms'] = Model_Ship_Room::get_names_byfloor($v['id']);
                $v['facilities'] = Model_Ship_Facility::get_names_byfloor($v['id']);
            }
            $result['total']=$totalcount_arr[0]['num'];
            $result['lists']=$list;
            $result['success']=true;
            echo json_encode($result);
        }
        else if($action=='update')//更新某个字段
        {
            $id=Arr::get($_POST,'id');
            $field=Arr::get($_POST,'field');
            $val=Arr::get($_POST,'val');

            if(is_numeric($id))
            {
                $model=ORM::factory('ship_floor',$id);
            }
            if($model->id)
            {
                $model->$field=$val;
                $model->save();
                if($model->saved())
                    echo 'ok';
                else
                    echo 'no';
            }
        }
        else if($action=='delete') //删除某个记录
        {
            $rawdata=file_get_contents('php://input');
            $data=json_decode($rawdata);
            $id=$data->id;
            if(is_numeric($id))
            {
                $model=ORM::factory('ship_floor',$id);
                $model->delete();
            }
        }
    }
    /**
     * 添加楼层
     */
    public function action_flooradd()
    {
        $shipid = $this->params['shipid'];
        $this->assign('shipid',$shipid);
        $this->assign('action','add');
        $this->display('admin/ship/flooredit');
    }
    /**
     * 编辑楼层
     */
    public function action_flooredit()
    {
        $shipid = $this->params['shipid'];
        $id = $this->params['id'];
        $floor_model = ORM::factory('ship_floor',$id);
        $info = $floor_model->as_array();
        $info['rooms'] = Model_Ship_Room::get_names_byfloor($info['id']);
        $info['facilities'] = Model_Ship_Facility::get_names_byfloor($info['id']);
        $info['piclist_arr'] = json_encode(Common::getUploadPicture($info['piclist']));//图片数组
        $this->assign('shipid',$info['shipid']);
        $this->assign('info',$info);
        $this->assign('action','edit');
        $this->display('admin/ship/flooredit');
    }

    /**
     * 楼层保存
     */
    public function action_ajax_floor_save()
    {
        $action = Arr::get($_POST,'action');//当前操作
        $id = Arr::get($_POST,'id');
        $shipid = $_POST['shipid'];
        $status = false;
        $imagestitle = Arr::get($_POST,'imagestitle');
        $images = Arr::get($_POST,'images');
        $imgheadindex = Arr::get($_POST,'imgheadindex');
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
        if($action == 'add' && empty($id))
        {
            $model = ORM::factory('ship_floor');
            $model->shipid=$shipid;
        }
        else
        {
            $model = ORM::factory('ship_floor',$id);

        }
        $model->title = Arr::get($_POST,'title');
        $model->piclist = $piclist;
        $model->litpic = $litpic;
        if($action=='add' && empty($id))
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
                $id = $model->id; //插入的产品id
            }
            else
            {
                $id =null;
            }
            $status = true;
        }
        echo json_encode(array('status'=>$status,'productid'=>$id));
    }


    /**
     * 舱房列表
     */
    public function action_roomlist()
    {
        $action=$this->params['action'];
        if($action=='read')    //读取列表
        {

            $start=Arr::get($_GET,'start');
            $limit=Arr::get($_GET,'limit');
            $shipid = $_GET['shipid'];
            $w="where id is not null and shipid='$shipid'";

            $sort = json_decode($_GET['sort'],true);
            $order='';
            if(!empty($sort))
            {
                $order.=' order by '.$sort[0]['property'].' '.$sort[0]['direction'];
            }

            $sql="select * from sline_ship_room $w {$order} limit $start,$limit";
            $totalcount_arr=DB::query(Database::SELECT,"select count(*) as num from sline_ship_room $w")->execute()->as_array();
            $list=DB::query(Database::SELECT,$sql)->execute()->as_array();
            foreach($list as $k=>&$v)
            {
                $v['kindname'] = Model_Ship_Room_Kind::get_title($v['kindid']);
                $v['floorsname'] = Model_Ship_Floor::get_names_bystr($v['floors']);
            }
            $result['total']=$totalcount_arr[0]['num'];
            $result['lists']=$list;
            $result['success']=true;
            echo json_encode($result);
        }
        else if($action=='update')//更新某个字段
        {
            $id=Arr::get($_POST,'id');
            $field=Arr::get($_POST,'field');
            $val=Arr::get($_POST,'val');

            if(is_numeric($id))
            {
                $model=ORM::factory('ship_room',$id);
            }
            if($model->id)
            {
                $model->$field=$val;
                $model->save();
                if($model->saved())
                    echo 'ok';
                else
                    echo 'no';
            }
        }
        else if($action=='delete') //删除某个记录
        {
            $rawdata=file_get_contents('php://input');
            $data=json_decode($rawdata);
            $id=$data->id;

            if(is_numeric($id))
            {
                $model=ORM::factory('ship_room',$id);
                $model->delete();
            }


        }
    }
    /**
     * 添加舱房
     */
    public function action_roomadd()
    {
        $shipid = $this->params['shipid'];
        $kindlist = ORM::factory('ship_room_kind')->get_all();
        $this->assign('kindlist',$kindlist);
        $floorlist = Model_Ship_Floor::get_floors($shipid);
        $this->assign('floorlist',$floorlist);
        $this->assign('shipid',$shipid);
        $this->assign('action','add');
        $this->display('admin/ship/roomedit');
    }

    /**
     * 编辑舱房
     */
    public function action_roomedit()
    {

        $id = $this->params['id'];
        $room_model = ORM::factory('ship_room',$id);
        $info = $room_model->as_array();
        $info['piclist_arr'] = json_encode(Common::getUploadPicture($info['piclist']));//图片数组
        $info['floor_list'] = explode(',',$info['floors']);
        $floorlist = Model_Ship_Floor::get_floors($info['shipid']);

        $kindlist = ORM::factory('ship_room_kind')->get_all();
        $this->assign('floorlist',$floorlist);
        $this->assign('kindlist',$kindlist);
        $this->assign('shipid',$info['shipid']);
        $this->assign('info',$info);
        $this->assign('action','edit');
        $this->display('admin/ship/roomedit');
    }

    /**
     * 舱房保存
     */
    public function action_ajax_room_save()
    {
        $action = Arr::get($_POST,'action');//当前操作
        $id = Arr::get($_POST,'id');
        $shipid = $_POST['shipid'];
        $status = false;
        $imagestitle = Arr::get($_POST,'imagestitle');
        $images = Arr::get($_POST,'images');
        $imgheadindex = Arr::get($_POST,'imgheadindex');
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
        if(empty($id))
        {
            $model = ORM::factory('ship_room');
        }
        else
        {
            $model = ORM::factory('ship_room',$id);
        }
        $model->title = Arr::get($_POST,'title');
        $model->area = intval($_POST['area']);
        $model->content = $_POST['content'];
        $model->num = $_POST['num'];
        $model->peoplenum = $_POST['peoplenum'];
        $model->floors = implode($_POST['floor'],',');
        $model->kindid =intval($_POST['kindid']);
        $model->iswindow = intval($_POST['iswindow']);
        $model->shipid = $shipid;
        $model->piclist = $piclist;
        $model->litpic = $litpic;
        if($action=='add' && empty($id))
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
                $id = $model->id; //插入的产品id
            }
            else
            {
                $id =null;
            }
            $status = true;
        }
        echo json_encode(array('status'=>$status,'productid'=>$id));
    }

    /**
     * 设施列表
     */
    public function action_facilitylist()
    {
        $action=$this->params['action'];
        if($action=='read')    //读取列表
        {
            $start=Arr::get($_GET,'start');
            $limit=Arr::get($_GET,'limit');
            $shipid = $_GET['shipid'];
            $w="where id is not null and shipid='$shipid'";
            $sort = json_decode($_GET['sort'],true);
            $order='';
            if(!empty($sort))
            {
                $order.=' order by '.$sort[0]['property'].' '.$sort[0]['direction'];
            }
            $sql="select * from sline_ship_facility $w {$order} limit $start,$limit";
            $totalcount_arr=DB::query(Database::SELECT,"select count(*) as num from sline_ship_facility $w")->execute()->as_array();
            $list=DB::query(Database::SELECT,$sql)->execute()->as_array();
            foreach($list as $k=>&$v)
            {
                $v['kindname'] = Model_Ship_Facility_Kind::get_title($v['kindid']);
                $v['floorsname'] = Model_Ship_Floor::get_names_bystr($v['floors']);
            }
            $result['total']=$totalcount_arr[0]['num'];
            $result['lists']=$list;
            $result['success']=true;
            echo json_encode($result);
        }
        else if($action=='update')//更新某个字段
        {
            $id=Arr::get($_POST,'id');
            $field=Arr::get($_POST,'field');
            $val=Arr::get($_POST,'val');

            if(is_numeric($id))
            {
                $model=ORM::factory('ship_facility',$id);
            }
            if($model->id)
            {
                $model->$field=$val;
                $model->save();
                if($model->saved())
                    echo 'ok';
                else
                    echo 'no';
            }
        }
        else if($action=='delete') //删除某个记录
        {
            $rawdata=file_get_contents('php://input');
            $data=json_decode($rawdata);
            $id=$data->id;

            if(is_numeric($id))
            {
                $model=ORM::factory('ship_facility',$id);
                $model->delete();
            }
        }
    }
    /**
     * 添加设施
     */
    public function action_facilityadd()
    {
        $shipid = $this->params['shipid'];
        $floorlist = Model_Ship_Floor::get_floors($shipid);
        $kindlist = ORM::factory('ship_facility_kind')->get_all();
        $this->assign('kindlist',$kindlist);
        $this->assign('floorlist',$floorlist);
        $this->assign('shipid',$shipid);
        $this->assign('action','add');
        $this->display('admin/ship/facilityedit');
    }
    /**
     * 编辑设施
     */
    public function action_facilityedit()
    {
        $shipid = $this->params['shipid'];
        $id = $this->params['id'];
        $facility_model = ORM::factory('ship_facility',$id);
        $info = $facility_model->as_array();
        $info['piclist_arr'] = json_encode(Common::getUploadPicture($info['piclist']));//图片数组
        $info['floor_list'] = explode(',',$info['floors']);
        $floorlist = Model_Ship_Floor::get_floors($info['shipid']);
        $kindlist = ORM::factory('ship_facility_kind')->get_all();
        $this->assign('kindlist',$kindlist);
        $this->assign('floorlist',$floorlist);
        $this->assign('shipid',$info['shipid']);
        $this->assign('info',$info);
        $this->assign('action','edit');
        $this->display('admin/ship/facilityedit');
    }

    /**
     * 舱房保存
     */
    public function action_ajax_facility_save()
    {
        $action = Arr::get($_POST,'action');//当前操作
        $id = Arr::get($_POST,'id');
        $shipid = $_POST['shipid'];
        $status = false;
        $imagestitle = Arr::get($_POST,'imagestitle');
        $images = Arr::get($_POST,'images');
        $imgheadindex = Arr::get($_POST,'imgheadindex');
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
        if(empty($id))
        {
            $model = ORM::factory('ship_facility');
        }
        else
        {
            $model = ORM::factory('ship_facility',$id);
        }
        $model->title = Arr::get($_POST,'title');
        $model->kindid = intval($_POST['kindid']);
        $model->content = $_POST['content'];
        $model->opentime = $_POST['opentime'];
        $model->seatnum = $_POST['seatnum'];
        $model->floors = implode($_POST['floor'],',');
        $model->shipid = $shipid;
        $model->piclist = $piclist;
        $model->litpic = $litpic;
        $model->sellpoint = $_POST['sellpoint'];
        $model->dress = $_POST['dress'];
        $model->isfree = $_POST['isfree'];
        if($action=='add' && empty($id))
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
                $id = $model->id; //插入的产品id
            }
            else
            {
                $id =null;
            }
            $status = true;
        }
        echo json_encode(array('status'=>$status,'productid'=>$id));
    }
    /*
     * 设施分类
     */
    public function action_facilitykind()
    {
        //栏目深度
        $level = 0;
        $parent = ($node = Arr::get($_GET, 'node')) == 'root' ? 0 : $node;
        $table = 'ship_facility_kind';
        $action = $this->params['action'];
        $model = ORM::factory($table);
        switch ($action)
        {
            case 'read':
                $list = $model->get_all();
                foreach ($list as $k => $v)
                {
                    $list[$k]['allowDrag'] = false;
                    $list[$k]['leaf'] =true;
                }
                $list[] = array(
                    'leaf' => true,
                    'id' => "{$parent}add",
                    'title' => "<button class=\"btn btn-primary radius size-S\" onclick=\"addSub('0','')\">添加</button>",
                    'allowDrag' => false,
                    'allowDrop' => false,
                );
                echo json_encode(array('success' => true, 'text' => '', 'children' => $list));
                break;
            case 'addsub':
                $model->title = "未命名";
                $model->save();
                if ($model->saved())
                {
                    $model->reload();
                    $data = $model->as_array();
                    $data['leaf'] = true;
                    echo json_encode($data);
                }
                break;
            case 'save':
                $rawdata = file_get_contents('php://input');
                $field = Arr::get($_GET, 'field');
                $data = json_decode($rawdata);
                $id = $data->id;
                if ($field)
                {
                    $model = ORM::factory($table, $id);
                    if ($model->id)
                    {
                        $model->$field = $data->$field;
                        $model->save();
                        if ($model->saved())
                            echo 'ok';
                        else
                            echo 'no';
                    }
                }
                break;
            case 'update':
                $id = Arr::get($_POST, 'id');
                $field = Arr::get($_POST, 'field');
                $val = Arr::get($_POST, 'val');
                $model = ORM::factory($table, $id);
                if ($model->id)
                {
                    $model->$field = $val;
                    $model->save();
                    if ($model->saved())
                        echo 'ok';
                    else
                        echo 'no';
                }
                break;
            case 'delete':
                $rawdata = file_get_contents('php://input');
                $data = json_decode($rawdata);
                $id = $data->id;
                if (!is_numeric($id))
                {
                    echo json_encode(array('success' => false));
                    exit;
                }
                $model = ORM::factory($table, $id);
                $model->delete();
                break;
            default:
                $this->display('admin/ship/facilitykind');
        }
    }

    /**
     * 舱房分类
     */
    public function action_roomkind()
    {
        //栏目深度
        $level = 0;
        $parent = ($node = Arr::get($_GET, 'node')) == 'root' ? 0 : $node;
        $table = 'ship_room_kind';
        $action = $this->params['action'];
        $model = ORM::factory($table);
        switch ($action)
        {
            case 'read':
                $list = $model->get_all();
                foreach ($list as $k => $v)
                {
                    $list[$k]['allowDrag'] = false;
                    $list[$k]['leaf'] =true;
                }
                $list[] = array(
                    'leaf' => true,
                    'id' => "{$parent}add",
                    'title' => "<button class=\"btn btn-primary radius size-S\" onclick=\"addSub('0','')\">添加</button>",
                    'allowDrag' => false,
                    'allowDrop' => false,
                );
                echo json_encode(array('success' => true, 'text' => '', 'children' => $list));
                break;
            case 'addsub':
                $model->title = "未命名";
                $model->save();
                if ($model->saved())
                {
                    $model->reload();
                    $data = $model->as_array();
                    $data['leaf'] = true;
                    echo json_encode($data);
                }
                break;
            case 'save':
                $rawdata = file_get_contents('php://input');
                $field = Arr::get($_GET, 'field');
                $data = json_decode($rawdata);
                $id = $data->id;
                if ($field)
                {
                    $model = ORM::factory($table, $id);
                    if ($model->id)
                    {
                        $model->$field = $data->$field;
                        $model->save();
                        if ($model->saved())
                            echo 'ok';
                        else
                            echo 'no';
                    }
                }
                break;
            case 'update':
                $id = Arr::get($_POST, 'id');
                $field = Arr::get($_POST, 'field');
                $val = Arr::get($_POST, 'val');
                $model = ORM::factory($table, $id);
                if ($model->id)
                {
                    $model->$field = $val;
                    $model->save();
                    if ($model->saved())
                        echo 'ok';
                    else
                        echo 'no';
                }
                break;
            case 'delete':
                $rawdata = file_get_contents('php://input');
                $data = json_decode($rawdata);
                $id = $data->id;
                if (!is_numeric($id))
                {
                    echo json_encode(array('success' => false));
                    exit;
                }
                $model = ORM::factory($table, $id);
                $model->delete();
                break;
            default:
                $this->display('admin/ship/roomkind');
        }
    }
}