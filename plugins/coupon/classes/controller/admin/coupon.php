<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Coupon extends Stourweb_Controller
{

    private $_isnotallowtype = '14,12,4,6,7,11,10,101,109,107';
    public function before()
    {
        parent::before();
        $action = $this->request->action();

        $this->assign('itemid', $this->params['itemid']);
        $this->assign('weblist', Common::getWebList());
    }


    public function action_index()
    {

        $action = $this->params['action'];
        if (empty($action)) {
            $kindlist = DB::select('id','kindname')->from('coupon_kind')->where('isopen=1')->execute()->as_array();
            $this->assign('kindlist',$kindlist);
            $this->display('admin/index');
        }
        if($action=='read')
        {
            $kindid = Arr::get($_GET,'kindid');
            $start=Arr::get($_GET,'start');
            $limit=Arr::get($_GET,'limit');
            $keyword=Arr::get($_GET,'keyword');
            $w = "a.id is not null and isdel=0 ";
            $w .=empty($kindid)?'':" and a.kindid=$kindid ";
            $w .= empty($keyword)?'':" and a.name like '%{$keyword}%'";
            $sort = json_decode(Arr::get($_GET,'sort'),true);
            if(empty($sort))
            {
                $order = ' a.id desc';
            }
            else
            {
                $order = "a .{$sort[0]['property']} {$sort[0]['direction']}";
            }
            $totalcount_arr=DB::query(Database::SELECT,"select count(*) as num from sline_coupon a where $w")->execute()->as_array();
            $sql="select a.* from sline_coupon as a where $w  order by $order limit $start,$limit";
            $list=DB::query(Database::SELECT,$sql)->execute()->as_array();
            foreach($list as &$l)
            {
                $modeldata = DB::select('kindname')->from('coupon_kind')->where('id','=',$l['kindid'])->execute()->current();
                $l['kindname'] = $modeldata['kindname'];
                if(!$l['isnever'])
                {
                    $l['endtime']='永久有效';
                }
                else
                {
                    $l['endtime']=date('Y-m-d',$l['starttime']).'至'.date('Y-m-d',$l['endtime']);
                }
                if($l['type']==1)
                {
                    $l['amount'] = number_format($l['amount']*10/100,1).'折';

                }
                $sql = "select count(*) as num from sline_member_coupon WHERE cid={$l['id']}";
                $send = DB::query(1,$sql)->execute()->get('num');
                $l['send_and_total'] = "$send/{$l['totalnumber']}张";
            }
            $result['total']=$totalcount_arr[0]['num'];
            $result['lists']=$list;
            $result['success']=true;
            echo json_encode($result);

        }

        if($action=='update')
        {

            $id = Arr::get($_POST,'id');
            $val = Arr::get($_POST,'val');
            $field = Arr::get($_POST,'field');
            if($field=='displayorder'&&empty($val))
            {
                $val = 9999;
            }
            $model = ORM::factory('coupon',$id);
            $model->$field = $val;
           if( $model->save())
           {
               echo 'ok';

           }
            else
            {
                echo 'no';

            }
        }
        if($action =='delete')
        {
            $rawdata=file_get_contents('php://input');
            $data=json_decode($rawdata);
            $id=$data->id;
            if(is_numeric($id))
            {
                if(DB::update('coupon')->where("id=$id")->set(array('isdel'=>1))->execute())
                {
                    $w = "cid=$id and usenum=0 ";
                    DB::delete('member_coupon')->where($w)->execute();

                }
            }
        }

    }


    /**
     * @function 优惠券统计
     */
    public function action_stat()
    {

        $action = $this->params['action'];
        if (empty($action)) {
            $kindlist = DB::select('id','kindname')->from('coupon_kind')->where('isopen=1')->execute()->as_array();
            $this->assign('kindlist',$kindlist);
            $this->display('admin/stat');
        }
        if($action=='read')
        {
            $kindid = Arr::get($_GET,'kindid');
            $start=Arr::get($_GET,'start');
            $limit=Arr::get($_GET,'limit');
            $keyword=Arr::get($_GET,'keyword');
            $w = "a.id is not null";
            $w .=empty($kindid)?'':" and b.kindid=$kindid ";
            $w .=empty($keyword)?'':" and (b.name like '%{$keyword}%' or a.mid in(select mid from sline_member where mobile like '%$keyword%'))";
            $totalcount_arr=DB::query(Database::SELECT,"select count(*) as num from sline_member_coupon as a  LEFT JOIN  sline_coupon as b  on a.cid=b.id where $w")->execute()->as_array();
            $sql="select a.*,b.name,b.type,b.isnever,b.samount,b.antedate,b.typeid,b.amount,b.kindid,b.endtime,b.starttime from sline_member_coupon as a
  LEFT JOIN  sline_coupon as b  on a.cid=b.id where $w ORDER by a.addtime desc limit $start,$limit";
            $list=DB::query(Database::SELECT,$sql)->execute()->as_array();
            foreach($list as &$l)
            {
                $modeldata = DB::select('kindname')->from('coupon_kind')->where('id','=',$l['kindid'])->execute()->current();
                $l['kindname'] = $modeldata['kindname'];
                if(!$l['isnever'])
                {
                    $l['endtime']='永久有效';
                }
                else
                {
                    $l['endtime']=date('Y-m-d',$l['starttime']).'至'.date('Y-m-d',$l['endtime']);
                }
                if($l['type']==1)
                {
                    $l['amount'] = number_format($l['amount']*10/100,1).'折';
                }
                $l['memberinfo'] =  $memberinfo = DB::select()->from('member')->where('mid','=',$l['mid'])->execute()->current();
                $l['addtime'] = date('Y-m-d H:i:s ',$l['addtime']);
                if($l['usetime'])
                    $l['usetime'] = date('Y-m-d  H:i:s ',$l['usetime']);
            }
            $result['total']=$totalcount_arr[0]['num'];
            $result['lists']=$list;
            $result['success']=true;
            echo json_encode($result);
        }

    }


    /**
     * @function 添加优惠券
     */
    public function action_add()
    {

        $kindlist = DB::select('id','kindname')->from('coupon_kind')->where('isopen=1')->execute()->as_array();
        $info['kindlist'] = $kindlist;
        $member_grades = DB::select()->from('member_grade')->execute()->as_array();
        $this->assign('member_grades',$member_grades);
        $models =  DB::select('id','modulename')->from('model')->where( "id not in ($this->_isnotallowtype)")->and_where('and isopen=1')->execute()->as_array();
        $this->assign('models',$models);
        $this->assign('position', '添加优惠券');
        $this->assign('action', 'add');
        $this->assign('info', $info);
        $this->display('admin/edit');
    }
    /**
     * @function 添加优惠券
     */
    public function action_edit()
    {
        $models =  DB::select('id','modulename')->from('model')->where("id not in ($this->_isnotallowtype)")->and_where('and isopen=1')->execute()->as_array();
        $this->assign('models',$models);
        $id = intval(Arr::get($_GET,'id'));
        $info = DB::select('*')->from('coupon')->where('id','=',$id)->execute()->current();
        $kindlist = DB::select('id','kindname')->from('coupon_kind')->where('isopen=1')->execute()->as_array();
        $info['starttime'] = date('Y-m-d H:i:s',$info['starttime']);
        $info['endtime'] = date('Y-m-d H:i:s',$info['endtime']);
        $info['kindlist'] = $kindlist;
        if($info['type']==1)
        {
            $info['amount'] = $info['amount']/10;
        }
        $info['memeber_grades'] = explode(',',$info['memeber_grades']);
        $member_grades = DB::select()->from('member_grade')->execute()->as_array();
        $this->assign('member_grades',$member_grades);
        if($info['modules'])
        {
            $info['modules']  =DB::select('id','modulename')->from('model')->where("id in ({$info['modules']})")->execute()->as_array();
        }

        $models =  DB::select('id','modulename')->from('model')->where("id not in ($this->_isnotallowtype)")->and_where('and isopen=1')->execute()->as_array();
        $this->assign('models',$models);

        $this->assign('position', '修改优惠券');
        $this->assign('info', $info);
        $this->assign('action', 'edit');
        $this->assign('id', $id);
        $this->display('admin/edit');
    }

    public function action_view()
    {

        $models =  DB::select('id','modulename')->from('model')->where("id not in ($this->_isnotallowtype)")->and_where('and isopen=1')->execute()->as_array();
        $this->assign('models',$models);
        $id = intval(Arr::get($_GET,'id'));
        $info = DB::select('*')->from('coupon')->where('id','=',$id)->execute()->current();
        $kindlist = DB::select('id','kindname')->from('coupon_kind')->where('isopen=1')->execute()->as_array();
        $info['starttime'] = date('Y-m-d',$info['starttime']);
        $info['endtime'] = date('Y-m-d',$info['endtime']);
        $info['kindlist'] = $kindlist;
        if($info['type']==1)
        {
            $info['amount'] = $info['amount']/10;
        }
        $info['memeber_grades'] = explode(',',$info['memeber_grades']);
        $member_grades = DB::select()->from('member_grade')->execute()->as_array();
        $this->assign('member_grades',$member_grades);
        if($info['modules'])
        {
            $info['modules']  =DB::select('id','modulename')->from('model')->where("id in ({$info['modules']})")->execute()->as_array();
        }

        $models =  DB::select('id','modulename')->from('model')->where("id not in ($this->_isnotallowtype)")->and_where('and isopen=1')->execute()->as_array();
        $this->assign('models',$models);

        $this->assign('position', '修改优惠券');
        $this->assign('info', $info);
        $this->assign('action', 'edit');
        $this->assign('id', $id);
        $this->display('admin/view');

    }


    /**
     * 指定产品类型
     */
    public function action_dialog_setmodeltype()
    {
        $models  = Arr::get($_GET,'models');
        $models = explode('_',$models);
        $allowmodels =  DB::select('id','modulename','issystem')->from('model')->where("id not in ($this->_isnotallowtype)")->and_where('and isopen=1')->execute()->as_array();
        $sysmodels = array();
        $extendmodels = array();
        foreach($allowmodels as $model)
        {
            if($model['issystem']==1)
            {
                $sysmodels[] = $model;
            }
            else
            {
                $extendmodels[] = $model;
            }
        }
        $this->assign('models',$models);
        $this->assign('sysmodels',$sysmodels);
        $this->assign('selector',Arr::get($_GET,'selector'));
        $this->assign('extendmodels',$extendmodels);
        $this->display('admin/coupon/setmodeltype');

    }



    /**
     * @function 获取当前优惠券关联产品
     */
    public function action_pro_list()
    {

        $typeid = Arr::get($_GET,'typeid')?Arr::get($_GET,'typeid'):0;
        $id = Arr::get($_GET,'id');
        $page = Arr::get($_GET,'page');
        $limit = 10;
        $start = ($page-1)*$limit;
        $keyword=Arr::get($_GET,'keyword');
        if($id)
        {
            $w = "a.cid=$id ";
        }
        else
        {
            $w = "a.cid is not null ";

        }

        $w .= empty($keyword)?'':" and a.protitle like '%{$keyword}%'";
        $w .= empty($typeid)?'':' and a.typeid='.$typeid;
        $totalcount_arr=DB::query(Database::SELECT,"select count(*) as num from sline_coupon_pro a where $w")->execute()->as_array();
        $sql="select a.* from sline_coupon_pro as a where $w  limit $start,$limit";

        $list=DB::query(Database::SELECT,$sql)->execute()->as_array();
        foreach($list as &$l)
        {
            $modeldata = DB::select('modulename')->from('model')->where('id','=',$l['typeid'])->execute()->current();
            $l['typename'] = $modeldata['modulename'];
            $l['bh'] = St_Product::product_series($l['id'], "{$l['typeid']}");//编号
        }
        $result['total']=$totalcount_arr[0]['num'];
        $result['page'] = $page;
        $result['pagesize'] = 10;
        $result['lists']=$list;
        $result['success']=true;
        echo json_encode($result);

    }

    /**
     * @function  优惠券指定产品
     */
    public function  action_add_product()
    {
        $action = $this->params['action'];
        if(!$action)
        {
            $id = Arr::get($_GET,'id');
            $models =  DB::select('id','modulename')->from('model')->where("id not in ($this->_isnotallowtype)")->and_where('and isopen=1')->execute()->as_array();
            $this->assign('models',$models);
            $this->assign('couponid',$id);
            $this->display('admin/coupon/prolist');
        }
        if($action=='read')
        {

            $typeid = Arr::get($_GET,'typeid')?Arr::get($_GET,'typeid'):1;
            $modeldata = DB::select('maintable','modulename')->from('model')->where('id','=',$typeid)->execute()->current();
            $protable = $modeldata['maintable'];
            $start=Arr::get($_GET,'start');
            $limit=Arr::get($_GET,'limit');
            $keyword=Arr::get($_GET,'keyword');
            $cid = Arr::get($_GET,'cid');
            //排除已经选择的产品
            $defarr =   DB::select('proid')->from('coupon_pro')->where("typeid = $typeid and cid = $cid")->execute()->as_array();
            $defstr = '';
            foreach($defarr as $def)
            {
                $defstr .= $def['proid'].',';
            }
            $defstr = rtrim($defstr,',');
            if($defstr)
            {

                $w = "a.id is not null and ishidden=0  and not  a.id in ($defstr) ";
            }
            else
            {
                $w = "a.id is not null and ishidden=0 ";

            }

            if($protable=='model_archive')
            {
                $w .= " and a.typeid=$typeid";
            }
            $w .= empty($keyword)?'':" and a.title like '%{$keyword}%'";
            $totalcount_arr=DB::query(Database::SELECT,"select count(*) as num from sline_$protable a where $w")->execute()->as_array();
            $sql="select a.id,a.title from sline_$protable as a   LEFT JOIN  sline_allorderlist as b   ON (a.id=b.aid and b.typeid=$typeid) where $w    ORDER BY IFNULL(b.displayorder,9999) ASC,a.modtime DESC,a.addtime DESC  limit $start,$limit";
            $list=DB::query(Database::SELECT,$sql)->execute()->as_array();
            foreach($list as &$l)
            {
                $l['typename'] = $modeldata['modulename'];
                $l['bh'] = St_Product::product_series($l['id'], "{$typeid}");//编号
            }
            $result['total']=$totalcount_arr[0]['num'];
            $result['lists']=$list;
            $result['success']=true;
            echo json_encode($result);
        }
        if($action=='del')
        {
            $id = Arr::get($_POST,'id');
            if(is_numeric($id))
            {
                DB::delete('coupon_pro')->where('id','=',$id)->execute();
            }
            echo 'ok';
        }

    }


    /**
     * @function 保存基本信息
     */
    public function action_ajax_save()
    {
        $status = false;
        $action = Arr::get($_POST,'action');
        $kindid = Arr::get($_POST,'kindid');
        $name = Arr::get($_POST,'name');
        $type = Arr::get($_POST,'type');
        $amount = Arr::get($_POST,'amount');
        $isnever = Arr::get($_POST,'isnever');
        $starttime = Arr::get($_POST,'starttime');
        $endtime = Arr::get($_POST,'endtime');
        $samount = Arr::get($_POST,'samount');
        $antedate = Arr::get($_POST,'antedate');
        $totalnumber = Arr::get($_POST,'totalnumber');
        $maxnumber = Arr::get($_POST,'maxnumber');
        $couponid = Arr::get($_POST,'couponid');
        $typeid = Arr::get($_POST,'typeid');
        $membergrade = Arr::get($_POST,'membergrade');
        $models = Arr::get($_POST,'models');
        $isopen = Arr::get($_POST,'isopen');
        $needjifen = Arr::get($_POST,'needjifen');
        //保存基本信息
        if($action == 'add' && empty($couponid))
        {
            $model = ORM::factory('coupon');
        }
        else
        {
            $model = ORM::factory('coupon',$couponid);

        }
        $model->kindid = $kindid;
        $model->name = $name;
        $model->type = $type;
        if($type==1)
        {
            $amount = $amount[1]*10;//折扣比换算
        }
        else
        {
            $amount = $amount[0];
        }
        $model->amount = $amount;
        $model->isnever = $isnever;
        $model->starttime = strtotime($starttime);
        $model->samount = $samount;
        $model->antedate = $antedate;
        $model->totalnumber = $totalnumber;
        $model->maxnumber = $maxnumber;
        $model->endtime = strtotime($endtime);
        $model->typeid = $typeid;
        $model->memeber_grades= implode(',',$membergrade);
        $model->modules= implode(',',$models);
        $model->isopen= $isopen;
        $model->needjifen= $needjifen;
        if($action=='add' && empty($couponid))
        {
            $model->code = $this->get_coucode();
            $model->addtime = time();
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
                $couponid = $model->id; //插入的产品id
            }
            $status = true;
        }
        echo json_encode(array('status'=>$status,'couponid'=>$couponid));


    }


    private  function get_coucode()
    {
        $code = 'CON';
        $num = rand(1000,100000);
        $num = $num .time();
        $num = substr($num,0,12);
        $code .= $num;
        $check = DB::select('id')->from('coupon')->where("code='$code'")->execute()->current();
        if($check)
        {
            return $this->get_coucode();

        }
        else
        {
            return $code;
        }

    }

    /**
     * @function 保存关联产品信息
     */
    public function action_ajax_prolist_save()
    {

        $id = Arr::get($_POST,'id');
        $subdata = Arr::get($_POST,'subdata');
        $subdata = explode(',',$subdata);
        foreach($subdata as $data)
        {
            $data = explode('_',$data);
            $set_arr=array('cid','proid','typeid','protitle');
            $val_arr=array($id,$data[1],$data[0],$data[2]);
            DB::insert('coupon_pro',$set_arr)->values($val_arr)->execute();
        }
        echo json_encode(array('status'=>'yes'));
    }

    /**
     * 查看数据报表
     */
    public function action_dataview()
    {
        $year = date('Y');
        $this->assign('thisyear', $year);
        $this->display('admin/coupon/data_view');

    }

    /**
     * 生成excel 数据
     */
    public function action_excel()
    {
        $kindlist = DB::select('id','kindname')->from('coupon_kind')->where('isopen=1')->execute()->as_array();
        $this->assign('kindlist',$kindlist);
        $this->display('admin/coupon/excel');

    }


    /**
     * 导出数据
     */
    public function action_genexcel()
    {

        $starttime = strtotime(Arr::get($_GET, 'starttime'));
        $endtime = strtotime(Arr::get($_GET, 'endtime'));
        $couponkind = Arr::get($_GET, 'couponkind');
        $timetype = Arr::get($_GET, 'timetype');
        switch ($timetype)
        {
            case 1:
                $time_arr = $this->getTimeRange(1);
                break;
            case 2:
                $time_arr = $this->getTimeRange(2);
                break;
            case 3:
                $time_arr = $this->getTimeRange(3);
                break;
            case 5:
                $time_arr = $this->getTimeRange(5);
                break;
            case 6:
                $time_arr = array($starttime, $endtime);
                break;

        }

        $stime = date('Y-m-d', $time_arr[0]);
        $etime = date('Y-m-d', $time_arr[1]);

        $w = "a.addtime>=$time_arr[0] and a.addtime<=$time_arr[1] ";
        if($couponkind)
        {
            $w .= " and  b.kindid=$couponkind";

        }

        $table = "<table border='1' ><tr >";
        $table .= "<td>优惠券名称</td>";
        $table .= "<td>金额/折扣比</td>";
        $table .= "<td>领取会员昵称</td>";
        $table .= "<td>会员手机号</td>";
        $table .= "<td>优惠券类型</td>";
        $table .= "<td>有效期</td>";
        $table .= "<td>订单满减</td>";
        $table .= "<td>提前天数</td>";
        $table .= "<td>领取时间</td>";
        $table .= "<td>使用时间</td>";
        $table .= "<td>订单号</td>";
        $table .= "</tr>";
        $sql = "select a.id as roleid,a.mid,a.cid,a.totalnum,a.usenum,a.addtime,a.usetime,b.*  from  sline_member_coupon as a LEFT JOIN sline_coupon as b on a.cid=b.id WHERE {$w}";
        $list = DB::query(1,$sql)->execute()->as_array();

        foreach($list as &$l)
        {
            $modeldata = DB::select('kindname')->from('coupon_kind')->where('id','=',$l['kindid'])->execute()->current();
            $l['kindname'] = $modeldata['kindname'];
            if(!$l['isnever'])
            {
                $l['endtime']='永久有效';
            }
            else
            {
                $l['endtime']=date('Y-m-d H:i:s',$l['endtime']);
            }
            if($l['type']==1)
            {
                $l['amount'] = number_format($l['amount']*10/100,1).'折';
            }
            else
            {
                $l['amount'] =  $l['amount'] .'元';
            }
            $l['memberinfo'] =  $memberinfo = DB::select()->from('member')->where('mid','=',$l['mid'])->execute()->current();
            $l['addtime'] = date('Y-m-d H:i:s ',$l['addtime']);
            if($l['usetime'])
            {

                $l['usetime'] = date('Y-m-d  H:i:s ',$l['usetime']);
                $ordersninfo = DB::select('ordersn')->from('member_order_coupon')->where('roleid','=',$l['roleid'])->execute()->current();
                $l['ordersn'] = '订单号：'.$ordersninfo['ordersn'] ;

            }
            $table .= "<tr>";
            $table .= "<td>{$l['name']}</td>";
            $table .= "<td>{$l['amount']}</td>";
            $table .= "<td>{$l['memberinfo']['nickname']}</td>";
            $table .= "<td>{$l['memberinfo']['mobile']}</td>";
            $table .= "<td>{$l['kindname']}</td>";
            $table .= "<td>{$l['endtime']}</td>";
            $table .= "<td>{$l['samount']}</td>";
            $table .= "<td>{$l['antedate']}天</td>";
            $table .= "<td>{$l['addtime']}</td>";
            $table .= "<td>{$l['usetime']}</td>";
            $table .= "<td>{$l['ordersn']}</td>";
            $table .='</tr>';
        }

            $table .= "</table>";

            $filename = date('Ymdhis');
            ob_end_clean();//清除缓冲区
            header('Pragma:public');
            header('Expires:0');
            header('Content-Type:charset=utf-8');
            header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
            header('Content-Type:application/force-download');
            header('Content-Type:application/vnd.ms-excel');
            header('Content-Type:application/octet-stream');
            header('Content-Type:application/download');
            header('Content-Disposition:attachment;filename=' . $filename . ".xls");
            header('Content-Transfer-Encoding:binary');
           // if (empty($arr))
          //  {
                echo iconv('utf-8', 'GBK', $table);
          //  }
          //  else
           //     echo $table;
            exit();


    }


    public function getTimeRange($type)
    {
        $curtime = time();
        switch ($type)
        {
            case 1:
                $starttime = strtotime(date('Y-m-d 00:00:00'));
                $endtime = strtotime(date('Y-m-d 23:59:59'));
                break;
            case 2:
                $starttime = strtotime(date('Y-m-d 00:00:00', strtotime('-1 day')));
                $endtime = strtotime(date('Y-m-d 23:59:59', strtotime('-1 day')));
                break;
            case 3:
                $starttime = strtotime(date("Y-m-d", $curtime - 60 * 60 * 24 * 7));
                $endtime = $curtime;
                break;
            case 4:
                $starttime = strtotime(date('Y-m-d 00:00:00', strtotime('last Sunday')));
                $endtime = strtotime(date('Y-m-d H:i:s', strtotime('last Sunday') + 7 * 24 * 3600 - 1));
                break;
            case 5:
                $starttime = strtotime(date("Y-m-d", $curtime - 60 * 60 * 24 * 31));
                $endtime = $curtime;
                break;
            case 6:
                $starttime = strtotime(date('Y-m-01 00:00:00', strtotime('-1 month')));
                $endtime = strtotime(date('Y-m-31 23:59:00', strtotime('-1 month')));
                break;
        }
        $out = array(
            $starttime,
            $endtime
        );
        return $out;

    }

    /**
     * 删除优惠券
     */
    public function action_delrow()
    {
        $id = Arr::get($_POST,'id');
        if(DB::update('coupon')->where("id=$id")->set(array('isdel'=>1))->execute())
        {
            $w = "cid=$id and usenum=0 and ISNULL(usetime)";
            DB::delete('member_coupon')->where($w)->execute();
            echo 'ok';
        }


    }


    /**
     * 赠送优惠券
     */
    public function action_member_give()
    {

        $action = Arr::get($_GET,'action');
        if(empty($action))
        {
            $this->display('admin/coupon/give_list');
        }
        if($action=='read')
        {

            $kindid = Arr::get($_POST,'kindid');
            $start=Arr::get($_GET,'start');
            $limit=Arr::get($_GET,'limit');
            $keyword=Arr::get($_GET,'keyword');
            $w = "a.id is not null and is_give=1";
            $w .=empty($kindid)?'':" and b.kindid=$kindid ";
            $w .=empty($keyword)?'':" and (b.name like '%{$keyword}%' or a.mid in(select mid from sline_member where mobile like '%$keyword%'))";

            $totalcount_arr=DB::query(Database::SELECT,"select count(*) as num from sline_member_coupon as a  LEFT JOIN  sline_coupon as b  on a.cid=b.id where $w")->execute()->as_array();
            $sql="select a.*,b.name,b.type,b.isnever,b.samount,b.antedate,b.typeid,b.amount,b.kindid,b.endtime,b.starttime from sline_member_coupon as a
  LEFT JOIN  sline_coupon as b  on a.cid=b.id where $w  ORDER by a.addtime desc limit $start,$limit";
            $list=DB::query(Database::SELECT,$sql)->execute()->as_array();
            foreach($list as &$l)
            {
                $modeldata = DB::select('kindname')->from('coupon_kind')->where('id','=',$l['kindid'])->execute()->current();
                $l['kindname'] = $modeldata['kindname'];
                if(!$l['isnever'])
                {
                    $l['endtime']='永久有效';
                }
                else
                {
                    $l['endtime']=date('Y-m-d',$l['starttime']).'至'.date('Y-m-d',$l['endtime']);

                }
                if($l['type']==1)
                {
                    $l['amount'] = number_format($l['amount']*10/100,1).'折';
                }
                $l['memberinfo'] =  $memberinfo = DB::select()->from('member')->where('mid','=',$l['mid'])->execute()->current();
                $l['addtime'] = date('Y-m-d H:i:s ',$l['addtime']);
                if($l['usetime'])
                {
                    $l['usetime'] = date('Y-m-d  H:i:s ',$l['usetime']);
                }
            }
            $result['total']=$totalcount_arr[0]['num'];
            $result['lists']=$list;
            $result['success']=true;
            echo json_encode($result);

        }
        elseif($action=="add")
        {
            $this->display('admin/coupon/give_add');
        }
        elseif($action=='dialog_getcoupon')
        {
            $method = Arr::get($_GET,'method');
            $couponid = Arr::get($_GET,'couponid');
            if(empty($method))
            {
                $this->assign('couponid',$couponid);
                $this->display('admin/coupon/setcoupon');
            }
            elseif($method=='read')
            {
                 $this->get_coupon_list();
            }
        }
        elseif($action=='dialog_getmember')
        {
            $method = Arr::get($_GET,'method');
            if(empty($method))
            {
                $memberid = Arr::get($_GET,'memberid');

                if($memberid)
                {
                    $memberlist = DB::select('nickname','truename','mid')->from('member')->where("mid in ($memberid)")->execute()->as_array();

                    $this->assign('memberlist',$memberlist);
                }

                $this->assign('memberid',$memberid);

                $this->display('admin/coupon/setmember');
            }
            elseif($method=='read')
            {
                $this->get_member_list();
            }
        }

    }

    private function get_member_list()
    {

        $start=Arr::get($_GET,'start');
        $limit=Arr::get($_GET,'limit');
        $keyword=Arr::get($_GET,'keyword');
        $memberid = Arr::get($_GET,'memberid');
        $w = ' mid>0';
        $w .= empty($keyword)?'':" and (nickname like '%{$keyword}%' or truename like '%{$keyword}%' or mobile like '%{$keyword}%' or email like '%{$keyword}%')";
        $totalcount_arr=DB::query(Database::SELECT,"select count(*) as num from sline_member  where $w")->execute()->as_array();
        $sql="select * from sline_member  where $w  limit $start,$limit";
        $list=DB::query(Database::SELECT,$sql)->execute()->as_array();
        foreach($list as &$l)
        {
            $memberids = explode(',',$memberid);
            if(in_array($l['mid'],$memberids))
            {
                $l['check'] = 1;
            }


            $sql = "select count(*) as num  from sline_member_order WHERE status in(2,5) and memberid={$l['mid']}";
            $l['ordernum'] = DB::query(1,$sql)->execute()->get('num');
        }
        $result['total']=$totalcount_arr[0]['num'];
        $result['lists']=$list;
        $result['success']=true;
        echo json_encode($result);


    }


    private function get_coupon_list()
    {
        $start=Arr::get($_GET,'start');
        $limit=Arr::get($_GET,'limit');
        $keyword=Arr::get($_GET,'keyword');
        $w = "a.id is not null and isdel=0 ";
        $w .= empty($keyword)?'':" and a.name like '%{$keyword}%'";
        $order = 'a.displayorder';
        $totalcount_arr=DB::query(Database::SELECT,"select count(*) as num from sline_coupon a where $w")->execute()->as_array();
        $sql="select a.* from sline_coupon as a where $w  order by $order limit $start,$limit";
        $list=DB::query(Database::SELECT,$sql)->execute()->as_array();
        foreach($list as &$l)
        {
            $modeldata = DB::select('kindname')->from('coupon_kind')->where('id','=',$l['kindid'])->execute()->current();
            $l['kindname'] = $modeldata['kindname'];
            if(!$l['isnever'])
            {
                $l['endtime']='永久有效';
            }
            else
            {
                $l['endtime']=date('Y-m-d',$l['starttime']).'至'.date('Y-m-d',$l['endtime']);
            }
            if($l['type']==1)
            {
                $l['amount'] = number_format($l['amount']*10/100,1).'折';

            }
            $sql = "select count(*) as num from sline_member_coupon WHERE cid={$l['id']}";
            $send = DB::query(1,$sql)->execute()->get('num');
            $l['send_and_total'] = "$send/{$l['totalnumber']}张";
            $l['leftnum'] = $l['totalnumber']-$send;
        }
        $result['total']=$totalcount_arr[0]['num'];
        $result['lists']=$list;
        $result['success']=true;
        echo json_encode($result);


    }


    /**
     * 保存赠送信息
     */
    public function action_ajax_save_member_give()
    {
        $couponid = Arr::get($_POST,'couponid');
        $sendnum = Arr::get($_POST,'sendnum');
        $memberids = Arr::get($_POST,'memberid');
        foreach($memberids as $member)
        {
            $inser_arr =array(
                'mid'=>$member,
                'cid'=>$couponid,
                'totalnum'=>1,
                'addtime'=>time(),
                'is_give'=>1,
                'givetime'=>time(),
            );
            for($i=1;$i<=$sendnum;$i++)
            {
                DB::insert('member_coupon',array_keys($inser_arr))->values(array_values($inser_arr))->execute();
            }

        }

    }




}