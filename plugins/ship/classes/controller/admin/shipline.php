<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/6 0006
 * Time: 10:01
 */
class Controller_Admin_Shipline extends Stourweb_Controller{
    private $_typeid=104;
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
        $action = $this->params['action'];
        if (empty($action))  //显示线路列表页
        {
            $this->assign('kindmenu', Common::getConfig('menu_sub.ship_linekind'));//分类设置项
            $this->display('admin/shipline/index');
        }
        else if ($action == 'read')    //读取列表
        {
            $start = Arr::get($_GET, 'start');
            $limit = Arr::get($_GET, 'limit');
            $serial = $keyword = Arr::get($_GET, 'keyword');
            $kindid = Arr::get($_GET, 'kindid');
            $attrid = Arr::get($_GET, 'attrid');
            $startcity = Arr::get($_GET, 'startcity');
            $sort = json_decode(Arr::get($_GET, 'sort'), true);
            $webid = Arr::get($_GET, 'webid');
            $webid = empty($webid) ? '-1' : $webid;
            $keyword = Common::getKeyword($keyword);
            $specOrders = array('attrid', 'kindlist', 'iconlist', 'themelist');
            $order = 'order by a.modtime desc';
            if ($sort[0]['property'])
            {
                if ($sort[0]['property'] == 'displayorder')
                    $prefix = '';
                else if ($sort[0]['property'] == 'ishidden')
                {
                    $prefix = 'a.';
                }
                else if ($sort[0]['property'] == 'suitday')
                {
                    $prefix = 'd.';
                }
                else if (in_array($sort[0]['property'], $specOrders))
                {
                    $prefix = 'order_';
                }
                $order = 'order by ' . $prefix . $sort[0]['property'] . ' ' . $sort[0]['direction'] . ',a.modtime desc';
            }
            $w = "a.id is not null";
            if (!empty($keyword))
            {
                $w .= preg_match('`^\d+$`', $keyword)  ? " and a.id={$keyword}" : " and (a.title like '%{$serial}%' or a.supplierlist in(select id from sline_supplier where suppliername like '%{$serial}%'))";
            }
            $w .= empty($kindid) ? '' : " and find_in_set($kindid,a.kindlist)";
            $w .= empty($attrid) ? '' : " and find_in_set($attrid,a.attrid)";
            $w .= empty($startcity) ? '' : " and a.startcity='$startcity'";
            $w .= $webid == '-1' ? '' : " and a.webid=$webid";
            if ($kindid != 0)
            {
                $sql = "select a.id,a.aid,a.title,a.shipid,a.scheduleid,a.iconlist,a.finaldestid,a.price,a.startcity,if(length(ifnull(a.attrid,''))=0,0,1) as order_attrid,if(length(ifnull(a.kindlist,''))=0,0,1) as order_kindlist,if(length(ifnull(a.iconlist,''))=0,0,1) as order_iconlist,if(length(ifnull(a.themelist,''))=0,0,1) as order_themelist,
a.attrid,a.webid,a.kindlist,a.ishidden,a.piclist,a.themelist,a.supplierlist,b.isjian,IFNULL(b.displayorder,9999) as displayorder,b.isding,b.istejia,ifnull(d.suitday,0) as suitday from sline_ship_line as a left join sline_kindorderlist b on (a.id=b.aid and b.typeid=104 and b.classid=$kindid)  left join (select
c.lineid,c.id,min(c.suitday) as suitday,c.shipid,c.scheduleid  from(select a.lineid,a.id,a.shipid,b.scheduleid,max(ifnull(b.day,0)) as suitday from sline_ship_line_suit a inner join sline_ship_line_suit_price b on a.id=b.suitid group by a.id,b.scheduleid) c group by c.lineid,c.scheduleid) d on a.id=d.lineid and a.shipid=d.shipid and a.scheduleid=d.scheduleid where $w $order limit  $start,$limit";
            }
            else
            {
                $sql = "select a.id,a.aid,a.title,a.shipid,a.scheduleid,a.supplierlist,a.iconlist,a.finaldestid,a.price,a.startcity,a.attrid,if(length(ifnull(a.attrid,''))=0,0,1) as order_attrid,if(length(ifnull(a.kindlist,''))=0,0,1) as order_kindlist,if(length(ifnull(a.iconlist,''))=0,0,1) as order_iconlist,if(length(ifnull(a.themelist,''))=0,0,1) as order_themelist,a.webid,a.kindlist,a.ishidden,a.piclist,a.themelist,b.isjian,IFNULL(b.displayorder,9999) as displayorder,b.isding,b.istejia,ifnull(d.suitday,0) as suitday from sline_ship_line as a left join sline_allorderlist b on (a.id=b.aid and b.typeid=104)   left join (select
c.lineid,c.id,min(c.suitday) as suitday,c.shipid,c.scheduleid  from(select a.lineid,a.id,a.shipid,b.scheduleid,max(ifnull(b.day,0)) as suitday from sline_ship_line_suit a inner join sline_ship_line_suit_price b on a.id=b.suitid group by a.id,a.shipid,b.scheduleid) c group by c.lineid,c.shipid,c.scheduleid) d on a.id=d.lineid and a.shipid=d.shipid and a.scheduleid=d.scheduleid where $w $order  limit $start,$limit";
            }

            $totalcount_arr = DB::query(Database::SELECT, "select count(*) as num from sline_ship_line a where $w")->execute()->as_array();
            $list = DB::query(Database::SELECT, $sql)->execute()->as_array();
            $new_list = array();
            foreach ($list as $k => $v)
            {
                $v['kindname'] = Model_Destinations::getKindnameList($v['kindlist']);
                $finalDestModel = ORM::factory('destinations', $v['finaldestid']);
                if ($finalDestModel->loaded())
                    $v['finaldestname'] = $finalDestModel->kindname;
                $v['attrname'] = Model_Ship_Line_Attr::get_attrs($v['attrid']);
                $v['url'] = Common::getBaseUrl($v['webid']) . '/ship/show_' . $v['aid'] . '.html';
                $iconname = Model_Icon::getIconName($v['iconlist']);
                $name = '';
                foreach ($iconname as $icon)
                {
                    if (!empty($icon))
                        $name .= '<span style="color:red">[' . $icon . ']</span>';
                }
                $v['iconname'] = $name;
                $v['lineseries'] = St_Product::product_series($v['id'], 104);//线路编号
                //供应商信息
                $supplier = ORM::factory('supplier')->where("id='{$v['supplierlist']}'")->find()->as_array();
                $v['suppliername'] = $supplier['suppliername'];
                $v['linkman'] = $supplier['linkman'];
                $v['mobile'] = $supplier['mobile'];
                $v['address'] = $supplier['address'];
                $v['qq'] = $supplier['qq'];
                /*foreach($supplier as $key=>$v)
                {
                    $v[$key] = $v;
                }*/
                //$suit=ORM::factory('line_suit')->where("lineid={$v['id']}")->get_all();


                Model_Ship_Line::update_suit($v['id'],$v['shipid']);
                $suitOrder = $sort[0]['property'] == 'suitday' ? 'order by suitday ' . $sort[0]['direction'] : '';
                $suitOrder = $sort[0]['property'] == 'displayorder'?' order by a.displayorder '. $sort[0]['direction']:$suitOrder;
                $suitSql = "select a.*,c.title,max(b.day) as suitday,c.area,c.num,c.peoplenum from sline_ship_line_suit a inner join sline_ship_room c on a.shipid=c.shipid and a.roomid=c.id  left join sline_ship_line_suit_price b on a.id=b.suitid and b.dateid in (select id from sline_ship_schedule_date where scheduleid='{$v['scheduleid']}') where a.lineid={$v['id']} and a.shipid='{$v['shipid']}'  group by a.id $suitOrder";
                $suit = DB::query(Database::SELECT, $suitSql)->execute()->as_array();
                if (!empty($suit))
                    $v['tr_class'] = 'parent-line-tr';
                if(empty($suit))
                {
                    $v['suitday'] = -1;
                }
                $new_list[] = $v;
                $is_priced = true;
                $line_index = count($new_list);
                $line_index = $line_index>0?$line_index-1:0;
                foreach ($suit as $key => $val)
                {

                    $val['minprice'] = Model_Ship_Line_Suit_Price::get_min_price($val['id'],$v['shipid'],$v['scheduleid']);
                    $val['minprofit'] = Model_Ship_Line_Suit_Price::get_min_profit($val['id'], $v['shipid'],$v['scheduleid']);

                    $val['id'] = 'suit_' . $val['id'];
                    if ($key != count($suit) - 1)
                        $val['tr_class'] = 'suit-tr';
                    if(empty($val['suitday']))
                    {
                        $is_priced=false;
                    }
                    $new_list[] = $val;
                }
                if($v['suitday']!=-1 && !$is_priced)
                {
                    $new_list[$line_index]['suitday'] = 0;
                }

            }
            $result['total'] = $totalcount_arr[0]['num'];
            $result['lines'] = $new_list;
            $result['success'] = true;
            echo json_encode($result);
        }
        else if ($action == 'save')   //保存字段
        {
            $rawdata = file_get_contents('php://input');
            $data = json_decode($rawdata);
            $field = Arr::get($_GET, 'field');
            $kindid = Arr::get($_GET, 'kindid');
            $id = $data->id;
            if (is_numeric($id))   //如果是线路
            {
                if ($field == 'displayorder') {
                    $displayorder = $data->displayorder;
                    if (empty($kindid))  //全局排序
                    {
                        $order = ORM::factory('allorderlist');
                        $order_mod = $order->where("aid='$id' and typeid=104 and webid=0")->find();
                        $displayorder = empty($displayorder) ? 9999 : $displayorder;
                        if ($order_mod->id)  //如果已经存在
                        {
                            $order_mod->displayorder = $displayorder;
                        } else   //如果这个排序不存在
                        {
                            $order_mod->displayorder = $displayorder;
                            $order_mod->aid = $id;
                            $order_mod->webid = 0;
                            $order_mod->typeid = 104;
                        }
                        $order_mod->save();
                    } else  //按目的地排序
                    {
                        $kindorder = ORM::factory('kindorderlist');
                        $kindorder_mod = $kindorder->where("aid='$id' and typeid=104 and classid=$kindid")->find();
                        $displayorder = empty($displayorder) ? 9999 : $displayorder;
                        if ($kindorder_mod->id) {
                            $kindorder_mod->displayorder = $displayorder;
                        } else {
                            $kindorder_mod->displayorder = $displayorder;
                            $kindorder_mod->aid = $id;
                            $kindorder_mod->classid = $kindid;
                            $kindorder_mod->typeid = 104;
                        }
                        $kindorder_mod->save();
                    }
                }
            } else if (strpos($id, 'suit') !== FALSE)//如果是套餐
            {
                $suitid = substr($id, strpos($id, '_') + 1);
                $suit = ORM::factory('ship_line_suit', $suitid);
                if ($field == 'displayorder') {
                    $displayorder = $data->displayorder;
                    $displayorder = empty($displayorder) ? 999999 : $displayorder;
                    $suit->displayorder = $displayorder;
                    $suit->save();
                } else {
                    $suit->$field = $data->$field;
                    $suit->save();
                }
            }


        }
        else if ($action == 'delete')
        {
            $rawdata = file_get_contents('php://input');
            $data = json_decode($rawdata);
            $id = $data->id;
            if (is_numeric($id)) //线路删除
            {
                $line = ORM::factory('ship_line', $id);
                $line->delete();
                DB::delete('ship_line_jieshao')->where('lineid','=',$id)->execute();
            }
        }
        else if ($action == 'update')
        {
            $id = Arr::get($_POST, 'id');
            $field = Arr::get($_POST, 'field');
            $val = Arr::get($_POST, 'val');
            $kindid = Arr::get($_POST, 'kindid');
            if ($field == 'displayorder')
            {
                if (is_numeric($id))   //如果是线路
                {
                    $displayorder = $val;
                    if (empty($kindid))  //全局排序
                    {
                        $order = ORM::factory('allorderlist');
                        $order_mod = $order->where("aid='$id' and typeid=104 and webid=0")->find();
                        $displayorder = empty($displayorder) ? 9999 : $displayorder;
                        if ($order_mod->id)  //如果已经存在
                        {
                            $order_mod->displayorder = $displayorder;
                        }
                        else   //如果这个排序不存在
                        {
                            $order_mod->displayorder = $displayorder;
                            $order_mod->aid = $id;
                            $order_mod->webid = 0;
                            $order_mod->typeid = 104;
                        }
                        $order_mod->save();
                        if ($order_mod->saved())
                            echo 'ok';
                        else
                            echo 'no';
                    }
                    else  //按目的地排序
                    {
                        $kindorder = ORM::factory('kindorderlist');
                        $kindorder_mod = $kindorder->where("aid='$id' and typeid=104 and classid=$kindid")->find();
                        $displayorder = empty($displayorder) ? 9999 : $displayorder;
                        if ($kindorder_mod->id)
                        {
                            $kindorder_mod->displayorder = $displayorder;
                        }
                        else
                        {
                            $kindorder_mod->displayorder = $displayorder;
                            $kindorder_mod->aid = $id;
                            $kindorder_mod->classid = $kindid;
                            $kindorder_mod->typeid = 104;
                        }

                        $kindorder_mod->save();
                        if ($kindorder->saved())
                            echo 'ok';
                        else
                            echo 'no';
                    }
                }
                else if (strpos($id, 'suit') !== FALSE)//如果是套餐
                {
                    $suitid = substr($id, strpos($id, '_') + 1);
                    $suit = ORM::factory('ship_line_suit', $suitid);
                    $displayorder = $val;
                    $displayorder = empty($displayorder) ? 999999 : $displayorder;
                    if ($suit->id)
                    {
                        $suit->displayorder = $displayorder;
                        $suit->save();
                        if ($suit->saved())
                            echo 'ok';
                        else
                            echo 'no';
                    }
                }
            }
            else //如果不是排序
            {
                if (is_numeric($id))
                {
                    $model = ORM::factory('ship_line', $id);
                }
                else if (strpos($id, 'suit') !== FALSE)
                {
                    $suitid = substr($id, strpos($id, '_') + 1);
                    $model = ORM::factory('ship_line_suit', $suitid);
                }
                if ($model->id)
                {
                    $model->$field = $val;
                    if ($field == 'kindlist')
                    {
                        $model->$field = implode(',', Model_Destinations::getParentsStr($val));
                    }
                    else if ($field == 'attrid')
                    {
                        $model->$field = implode(',', Model_Attrlist::getParentsStr($val, 1));
                    }
                    $model->save();
                    if ($model->saved())
                        echo 'ok';
                    else
                        echo 'no';
                }
            }
        }
    }
    /*
   * 添加线路
   */
    public function action_add()
    {
        $webid = 0;
        $this->assign('webid', 0);
        $columns = ORM::factory('ship_line_content')->where("(isopen=1 and columnname!='linespot') or columnname='tupian' ")->order_by('displayorder', 'asc')->get_all();
        $startplacelist = ORM::factory('startplace')->where("pid!=0")->get_all();
        $supplierlist = Ship::get_suppliers();
        $this->assign('startplacelist', $startplacelist);
        $this->assign('columns', $columns);
        $this->assign('usertransport', array());
        $this->assign('position', '添加游轮线路');
        $this->assign('action', 'add');
        $this->assign('supplierlist',$supplierlist);
        $this->display('admin/shipline/edit');
    }
    /*
     * 编辑线路
     */
    public function action_edit()
    {
        $lineid = $this->params['lineid'];
        $model = ORM::factory('ship_line', $lineid);
        $this->assign('action', 'edit');
        $startplacelist = ORM::factory('startplace')->where("pid!=0")->get_all();
        $this->assign('startplacelist', $startplacelist);
        if ($model->id)
        {
            $info = $model->as_array();
            $extendinfo = Common::getExtendInfo(104, $model->id);
            $info['kindlist_arr'] = Model_Destinations::getKindlistArr($info['kindlist']);
            $info['attrlist_arr'] =Model_Ship_Line_Attr::get_attrs($info['attrid']);
            $info['iconlist_arr'] = Common::getSelectedIcon($info['iconlist']);
            $info['supplier_arr'] = ORM::factory('supplier', $info['supplierlist'])->as_array();

            $info['jifenbook_info'] = DB::select()->from('jifen')->where('id','=',$info['jifenbook_id'])->execute()->current();
            $info['jifentprice_info'] = DB::select()->from('jifen_price')->where('id','=',$info['jifentprice_id'])->execute()->current();

            $day_arr = array_chunk(ORM::factory('ship_line_jieshao')->where("lineid='" . $info['id'] . "'")->order_by('day', 'asc')->get_all(), $info['lineday']);
            $info['linejieshao_arr'] = $day_arr[0];
            $columns = ORM::factory('ship_line_content')->where("(isopen=1 and columnname!='linespot') or columnname='tupian'")->order_by('displayorder', 'asc')->get_all();
            /* foreach($columns as $key => $c)
             {
                 if(preg_match('/^e_/',$c['columnname']))
                 {
                     unset($columns[$key]);
                 }
             }*/
            $info['linedoc']=unserialize($info['linedoc']);
            $supplierlist = ORM::factory('supplier')->get_all();
            $shiplist = ORM::factory('ship')->where('supplierlist','=',$info['supplierlist'])->get_all();
            $schedulelist = ORM::factory('ship_schedule')->where('shipid','=',$info['shipid'])->get_all();
            $this->assign('schedulelist',$schedulelist);
            $this->assign('shiplist',$shiplist);
            $this->assign('supplierlist',$supplierlist);

            $this->assign('columns', $columns);
            $this->assign('webid', $info['webid']);
            $this->assign('info', $info);
            $this->assign('extendinfo', $extendinfo);//扩展信息
            $this->assign('position', '修改' . $info['title']);
            $this->assign('usertransport', explode(',', $info['transport']));
            $this->display('admin/shipline/edit');
        }
        else
            echo 'URL地址错误，请重新选择游轮线路';
    }


    /**
     * 保存航线
     */
    public function action_ajax_linesave()
    {
        $attrids = implode(',', Arr::get($_POST, 'attrlist'));//属性
        if (!empty($attrids))
        {
            $attrids = implode(',', Model_Attrlist::getParentsStr($attrids, 104));
        }
        $lineid = Arr::get($_POST, 'lineid');
        $data_arr = array();
        $data_arr['webid'] = Arr::get($_POST, 'webid');
        $data_arr['webid'] = empty($data_arr['webid']) ? 0 : $data_arr['webid'];
        $webid = $data_arr['webid'];
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
        $data_arr['title'] = Arr::get($_POST, 'title');
        $data_arr['sellpoint'] = Arr::get($_POST, 'sellpoint');
        $data_arr['kindlist'] = implode(',', Model_Destinations::getParentsStr(implode(',', $kindlist)));
        $data_arr['finaldestid'] = empty($_POST['finaldestid']) ? Model_Destinations::getFinaldestId(explode(',', $data_arr['kindlist'])) : $_POST['finaldestid'];
        $data_arr['attrid'] = $attrids;
        $data_arr['lineday'] = Arr::get($_POST, 'lineday') ? Arr::get($_POST, 'lineday') : 1;
        $data_arr['linenight'] = Arr::get($_POST, 'linenight') ? Arr::get($_POST, 'linenight') : 0;
        $data_arr['linebefore'] = $_POST['linebefore'];
        $data_arr['islinebefore'] = $_POST['islinebefore'];
        $data_arr['scheduleid'] = $_POST['scheduleid'];

        $data_arr['recommendnum'] = $_POST['recommendnum'];
        $data_arr['supplierlist'] = $_POST['supplierlist'];
        $data_arr['shipid'] = intval($_POST['shipid']);
        $data_arr['templet'] = Arr::get($_POST, 'templet');
        $data_arr['color'] = Arr::get($_POST, 'color');
        $data_arr['satisfyscore'] = Arr::get($_POST, 'satisfyscore') ? Arr::get($_POST, 'satisfyscore') : 0;
        $data_arr['bookcount'] = Arr::get($_POST, 'bookcount') ? Arr::get($_POST, 'bookcount') : 0;
        $data_arr['ishidden'] = Arr::get($_POST, 'ishidden') ? Arr::get($_POST, 'ishidden') : 0;//显示隐藏
        $data_arr['seotitle'] = Arr::get($_POST, 'seotitle');
        $data_arr['keyword'] = Arr::get($_POST, 'keyword');
        $data_arr['tagword'] = Arr::get($_POST, 'tagword');
        $data_arr['description'] = Arr::get($_POST, 'description');
        $data_arr['modtime'] = time();
        $data_arr['isstyle'] = Arr::get($_POST, 'isstyle') ? Arr::get($_POST, 'isstyle') : 2; //默认标准版
        $data_arr['jieshao'] = Arr::get($_POST, 'jieshao');
        $data_arr['shipid'] = $_POST['shipid'];

        $data_arr['feeinclude'] = Arr::get($_POST, 'feeinclude');
        $data_arr['visacontent'] = $_POST['visacontent'];
        $data_arr['bookcontent'] = $_POST['bookcontent'];

        $data_arr['startcity'] = Arr::get($_POST, 'startcity');

        $data_arr['iconlist'] = Arr::get($_POST, 'iconlist') ? implode(',', Arr::get($_POST, 'iconlist')) : '';

        $data_arr['jifenbook_id'] = empty($_POST['jifenbook_id'])?0:$_POST['jifenbook_id'];
        $data_arr['jifentprice_id'] = empty($_POST['jifentprice_id'])?0:$_POST['jifentprice_id'];

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
        $data_arr['linedoc'] = serialize(Arr::get($_POST, 'linedoc'));
        if ($lineid == 0)
        {
            $data_arr['addtime'] = $data_arr['modtime'];
            $model = ORM::factory('ship_line');
            $model->aid = Common::getLastAid('sline_ship_line', $data_arr['webid']);
            $model->addtime = time();
            $data_arr['adminid']=Session::instance()->get('userid');
        }
        else
        {
            $data_arr['modtime'] = time();
            $model = ORM::factory('ship_line', $lineid);
            if ($model->webid != $data_arr['webid']) //如果更改了webid重新生成aid
            {
                $aid = Common::getLastAid('sline_ship_line', $data_arr['webid']);
                $model->aid = $aid;
            }
            $model->modtime = time();
        }
        foreach ($data_arr as $k => $v)
        {
            $model->$k = $v;
        }
        $model->save();
        if ($model->saved())
        {
            $model->reload();
            $lineid = $model->id;
            $this->savejieshao($lineid);
            Common::saveExtendData(104, $lineid, $_POST);//扩展信息保存
            echo $lineid;
        }
        else
            echo 'no';
    }

    /*
     * 线路天数
     */
    public function action_day()
    {
        $action = $this->params['action'];
        if (empty($action))
        {
            $list = ORM::factory('ship_line_day')->get_all();
            $this->assign('list', $list);
            $this->display('admin/shipline/day');
        }
        else if ($action == 'add')
        {
            $model = ORM::factory('ship_line_day');
            $model->create();
            echo $model->id;
        }
        else if ($action == 'save')
        {
            $word = Arr::get($_POST, 'title');
            foreach ($word as $k => $v)
            {
                $model = ORM::factory('ship_line_day', $k);
                if ($model->id)
                {
                    $model->title = $v;
                    $model->save();
                }
            }
            echo 'ok';
        }
        else if ($action == 'del')
        {
            $id = Arr::get($_POST, 'id');
            $model = ORM::factory('ship_line_day', $id);
            $model->delete();
            echo 'ok';
        }
    }

    /*
     * 线路价格列表
     */
    public function action_price()
    {
        $action = $this->params['action'];
        if (empty($action))
        {
            $list = ORM::factory('ship_line_pricelist')->get_all();
            $this->assign('list', $list);
            $this->display('admin/shipline/price');
        }
        else if ($action == 'add')
        {
            $model = ORM::factory('ship_line_pricelist');
            $model->create();
            echo $model->id;
        }
        else if ($action == 'save')
        {
            $lowerprice = Arr::get($_POST, 'lowerprice');
            $highprice = Arr::get($_POST, 'highprice');
            $newlowerprice = Arr::get($_POST, 'newlowerprice');
            $newhighprice = Arr::get($_POST, 'newhighprice');
            foreach ($lowerprice as $k => $v)
            {
                $model = ORM::factory('ship_line_pricelist', $k);
                if ($model->id)
                {
                    $model->lowerprice = $v;
                    $model->highprice = $highprice[$k];
                    $model->save();
                }
            }
            echo 'ok';
        }
        else if ($action == 'del')
        {
            $id = Arr::get($_POST, 'id');
            $model = ORM::factory('ship_line_pricelist', $id);
            $model->delete();
            echo 'ok';
        }
    }
    //获取供应商下的游轮
    public function action_ajax_get_shiplist()
    {
        $supplierid=intval($_POST['supplierid']);
        $list=ORM::factory('ship')->where('supplierlist','=',$supplierid)->get_all();
        echo json_encode(array('status'=>true,'msg'=>'获取成功','list'=>$list));
    }
    //获取渡轮下的日程
    public function action_ajax_get_schedulelist()
    {
        $shipid=intval($_POST['shipid']);
        $list=ORM::factory('ship_schedule')->where('shipid','=',$shipid)->get_all();
        echo json_encode(array('status'=>true,'msg'=>'获取成功','list'=>$list));
    }
    //保存介绍
    public function savejieshao($lineid)
    {
        $title_arr = Arr::get($_POST, 'jieshaotitle');
        $breakfirsthas_arr = Arr::get($_POST, 'breakfirsthas');
        $breakfirst_arr = Arr::get($_POST, 'breakfirst');
        $lunchhas_arr = Arr::get($_POST, 'lunchhas');
        $lunch_arr = Arr::get($_POST, 'lunch');
        $supperhas_arr = Arr::get($_POST, 'supperhas');
        $supper_arr = Arr::get($_POST, 'supper');
        $jieshao_arr = Arr::get($_POST, 'txtjieshao');
        $starttime_arr = $_POST['starttime'];
        $starttimehas_arr= $_POST['starttimehas'];
        $endtime_arr = $_POST['endtime'];
        $endtimehas_arr = $_POST['endtimehas'];
        $country_arr = $_POST['country'];
        $countryhas_arr = $_POST['countryhas'];
        $living_arr = $_POST['living'];
        $livinghas_arr = $_POST['livinghas'];


        // $beforemodels=ORM::factory('line_jieshao')->where("lineid='$lineid'")->find_all()->as_array();
        foreach ($title_arr as $k => $v)
        {
            $model = ORM::factory('ship_line_jieshao')->where("lineid='$lineid' and day='$k'")->find();
            if (empty($model->id))
                $model = ORM::factory('ship_line_jieshao');
            $model->lineid = $lineid;
            $model->day = $k;
            $model->breakfirst = $breakfirst_arr[$k];
            $model->lunch = $lunch_arr[$k];
            $model->supper = $supper_arr[$k];
            $model->title = $v;
            $model->starttime = $starttime_arr[$k];
            $model->endtime = $endtime_arr[$k];
            $model->country = $country_arr[$k];
            $model->living = $living_arr[$k];

            $model->starttimehas = $starttimehas_arr[$k];
            $model->endtimehas = $endtimehas_arr[$k];
            $model->countryhas = $countryhas_arr[$k];
            $model->livinghas = $livinghas_arr[$k];

            $superhas_arr[$k] = empty($superhas_arr[$k]) ? 0 : $superhas_arr[$k];
            $lunchhas_arr[$k] = empty($lunchhas_arr[$k]) ? 0 : $lunchhas_arr[$k];
            $breakfirsthas_arr[$k] = empty($breakfirsthas_arr[$k]) ? 0 : $breakfirsthas_arr[$k];

            $model->supperhas = $supperhas_arr[$k];
            $model->lunchhas = $lunchhas_arr[$k];
            $model->breakfirsthas = $breakfirsthas_arr[$k];
            $link = new Model_Tool_Link();
            $model->content = $jieshao_arr[$k];
            $model->save();
        }
    }

    /*
  * 修改套餐
  */
    public function action_editsuit()
    {
        $suitid = $this->params['suitid'];
        $info = ORM::factory('ship_line_suit', $suitid)->as_array();
        $roominfo = $this->get_roominfo($info['roomid']);
        $info['lastoffer'] = unserialize($info['lastoffer']);

        if (empty($info['lastoffer']))
        {
            $info['lastoffer'] = array('pricerule' => 'all','number'=>'-1');
        }
        $lineinfo = ORM::factory('ship_line', $info['lineid'])->as_array();
        $scheduleinfo = ORM::factory('ship_schedule',$lineinfo['scheduleid'])->as_array();
        $datelist = Model_Ship_Schedule_Date::get_date_list($lineinfo['scheduleid'],$suitid);// ORM::factory('ship_schedule_date')->where('scheduleid','=',$lineinfo['scheduleid'])->get_all();
        $this->assign('datelist',$datelist);
        $this->assign('scheduleinfo',$scheduleinfo);
        $this->assign('roominfo',$roominfo);
        $this->assign('action', 'edit');
        $this->assign('lineinfo', $lineinfo);
        $this->assign('info', $info);
        $this->assign('position', '修改套餐');
        $this->display('admin/shipline/suit_edit');
    }
    private function get_roominfo($roomid)
    {
        $room_model = ORM::factory('ship_room',$roomid);
        if(!$room_model->loaded())
            return null;
        $roominfo = $room_model->as_array();
        $roominfo['kindname']  = Model_Ship_Room_Kind::get_title($roominfo['kindid']);
        $roominfo['floornames'] = $room_model->get_floors();
        $roominfo['piclist_arr'] = Common::getUploadPicture($roominfo['piclist']);//图片数组
        return $roominfo;
    }

    /*
   * 房型保存
   * */
    public function action_ajax_suit_save()
    {
        $action = Arr::get($_POST, 'action');
        $lineid = intval($_POST['lineid']);
        $suitid = Arr::get($_POST, 'suitid');//房间id


        $model = ORM::factory('ship_line_suit', $suitid);


        $model->number = Arr::get($_POST, 'roomnum') ? Arr::get($_POST, 'roomnum') : 0;
        $model->jifencomment = Arr::get($_POST, 'jifencomment') ? Arr::get($_POST, 'jifencomment') : 0;
        $model->jifentprice = Arr::get($_POST, 'jifentprice') ? Arr::get($_POST, 'jifentprice') : 0;
        $model->jifenbook = Arr::get($_POST, 'jifenbook') ? Arr::get($_POST, 'jifenbook') : 0;
        $model->paytype = Arr::get($_POST, 'paytype') ? Arr::get($_POST, 'paytype') : 1;
        $model->dingjin = Arr::get($_POST, 'dingjin');
        if($model->paytype!=2){
            $model->dingjin=0;
        }
        $model->lastoffer =$this->last_offer($_POST);
        $status=false;
        $model->update();
        if ($model->saved())
        {
            $status = true;
        }
        $_POST['shipid'] = $model->shipid;
        $this->saveBaoJia($lineid, $suitid, $_POST);
        DB::update('ship_line')->set(array( 'price_date' =>0))->where('id', '=', $lineid)->execute();
        echo json_encode(array('status' => $status, 'suitid' => $suitid));
    }
    public function last_offer($arr)
    {
        $info['storeprice'] = $arr['storeprice'];
        $info['basicprice'] = $arr['basicprice'];
        $info['profit'] = $arr['profit'];
        $info['number'] = $arr['number'];
        $info['dates']  = $arr['date'];
        return serialize($info);
    }
    public function saveBaoJia($lineid, $suitid, $arr)
    {
        $basicprice = Arr::get($arr, 'basicprice') ? Arr::get($arr, 'basicprice') : 0;
        $profit = Arr::get($arr, 'profit') ? Arr::get($arr, 'profit') : 0;
        $price = (int)$basicprice + (int)$profit;
        $storeprice = $arr['storeprice'];
        $number = Arr::get($arr, 'number');
        $scheduleid = $arr['scheduleid'];
        $shipid = $arr['shipid'];

        $date = $arr['date'];

        foreach ($date as $v)
        {
            $dateInfo = ORM::factory('ship_schedule_date',$v)->as_array();
            if(empty($dateInfo['id']))
                continue;
            $model = ORM::factory('ship_line_suit_price')->where("suitid=$suitid and scheduleid=$scheduleid and dateid=$v")->find();
            $data_arr = array();
            $data_arr['lineid'] = $lineid;
            $data_arr['suitid'] = $suitid;
            $data_arr['basicprice'] = $basicprice;
            $data_arr['storeprice'] = $storeprice;
            $data_arr['profit'] = $profit;
            $data_arr['price'] = $price;
            $data_arr['day'] = $dateInfo['starttime'];
            $data_arr['scheduleid'] = $scheduleid;
            $data_arr['dateid'] = $v;
            $data_arr['shipid'] = $shipid;
            $data_arr['number'] = $number;
            if ($model->suitid)
            {
                $query = DB::update('ship_line_suit_price')->set($data_arr)->where("suitid=$suitid and scheduleid=$scheduleid and dateid=$v");
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
        Model_Ship_Line::get_minprice($lineid,null,0,true);
    }

    /**
     * 删除报价
     */
    public function action_ajax_suit_pricedel()
    {
        $suitid = $_POST['suitid'];
        $dateid = $_POST['dateid'];
        $result = DB::delete('ship_line_suit_price')->where('suitid','=',$suitid)->and_where('dateid','=',$dateid)->execute();
        if($result)
        {
            echo json_encode(array('status'=>true,'msg'=>'删除完成'));
        }
        else
        {
            echo json_encode(array('status'=>false,'msg'=>'删除失败'));
        }
    }


    /*
     * 短信通知
     */
    public function action_sms()
    {
        $model_info = DB::select()->from('model')->where('id','=',$this->_typeid)->execute()->current();
        $pinyin = $model_info['pinyin'];
        $arr = DB::select()->from('sms_msg')->where('msgtype','like',$pinyin.'_%')->execute()->as_array();
        foreach($arr as $row)
        {
            $key = substr($row['msgtype'],strlen($pinyin.'_'));
            $this->assign($key,$row['msg']);
            $this->assign($key.'_open',$row['isopen']);
        }

        $this->display('admin/shipline/sms');
    }

    /*
     * 短信保存
     */
    public function action_ajax_save_sms_msg()
    {
        $model_info = DB::select()->from('model')->where('id','=',$this->_typeid)->execute()->current();
        $pinyin = $model_info['pinyin'];
        for ($i = 1; $i <= 4; $i++)
        {
            $_open = 'isopen' . $i;
            $_msg = 'order_msg' . $i;
            $open = $_POST[$_open];
            $msg = $_POST[$_msg];
            $msgtype = $pinyin.'_'.$_msg;
            $model = ORM::factory('sms_msg')->where('msgtype','=',$msgtype)->find();
            $model->msgtype = $msgtype;
            $model->msg = $msg;
            $model->isopen = $open;
            $model->save();
        }
        echo json_encode(array('status'=>true,'msg'=>'提交成功'));
    }
    /*
     * 邮件通知
     */
    public function action_email()
    {
        $model_info = DB::select()->from('model')->where('id','=',$this->_typeid)->execute()->current();
        $pinyin = $model_info['pinyin'];
        $arr = DB::select()->from('email_msg')->where('msgtype','like',$pinyin.'_%')->execute()->as_array();
        foreach($arr as $row)
        {
            $key = substr($row['msgtype'],strlen($pinyin.'_'));
            $this->assign($key,$row['msg']);
            $this->assign($key.'_open',$row['isopen']);
        }
        $this->display('admin/shipline/email');
    }
    /*
    * 邮件保存
    */
    public function action_ajax_save_email_msg()
    {
        $model_info = DB::select()->from('model')->where('id','=',$this->_typeid)->execute()->current();
        $pinyin = $model_info['pinyin'];
        for ($i = 1; $i <= 4; $i++)
        {
            $_open = 'isopen' . $i;
            $_msg = 'order_msg' . $i;
            $open = $_POST[$_open];
            $msg = $_POST[$_msg];
            $msgtype = $pinyin.'_'.$_msg;
            $model = ORM::factory('email_msg')->where('msgtype','=',$msgtype)->find();
            $model->msgtype = $msgtype;
            $model->msg = $msg;
            $model->isopen = $open;
            $model->save();
        }
        echo json_encode(array('status'=>true,'msg'=>'提交成功'));
    }

    //内容介绍
    public function action_content()
    {


        $action = $this->params['action'];
        if (empty($action))
        {
            $linecontent = ORM::factory('ship_line_content')->order_by('displayorder')->get_all();
            $this->assign('list', $linecontent);
            $this->display('admin/shipline/content');
        }
        else if ($action == 'save')
        {
            $displayorder = Arr::get($_POST, 'displayorder');
            $chinesename = Arr::get($_POST, 'chinesename');
            $isopen = Arr::get($_POST, 'isopen');
            $newdisplayorder = Arr::get($_POST, 'newdisplayorder');
            $newchinesename = Arr::get($_POST, 'newchinesename');
            $newisopen = Arr::get($_POST, 'newisopen');
            foreach ($displayorder as $k => $v)
            {
                $model = ORM::factory('ship_line_content', $k);
                if ($model->id)
                {
                    $open = $isopen[$k] ? 1 : 0;
                    $model->chinesename = $chinesename[$k];
                    $model->displayorder = $v;
                    $model->isopen = $open;
                    $model->save();
                }
            }
            //更新扩展字段描述
            Model_Ship_Line_Content::update_extend_field_name();
            echo 'ok';
        }
    }
    //添加内容项
    public function action_ajax_content_add()
    {
        $extend_table = 'sline_ship_line_extend_field';

        $lastIndex = Common::getExtendContentIndex($extend_table);
        $fieldName = 'e_' . 'content_' . $lastIndex;
        $result = Common::addField($extend_table, 'content_' . $lastIndex, 'mediumtext', 0, '自定义' . $lastIndex);
        if ($result)
        {
            $data = Model_Ship_Line_Content::add_content_field($fieldName, '自定义' . $lastIndex);
            Model_Extend_Field::add_extend_field($this->_typeid, $fieldName, '自定义' . $lastIndex);
            echo json_encode(array('status' => true, 'msg' => '添加成功', 'data' => $data));
        }
        else
        {
            echo json_encode(array('status' => false, 'msg' => '添加失败'));
        }
    }

    //删除内容项
    public function action_ajax_content_del()
    {
        $id = $_POST['id'];
        $model = ORM::factory('ship_line_content', $id);
        $columnName = $model->columnname;
        $model->delete();
        $result = DB::query(Database::DELETE, "alter table `sline_ship_line_extend_field` drop column $columnName")->execute();

        $extendModel = ORM::factory('extend_field')->where('typeid', '=', $this->_typeid)->and_where('fieldname', '=', $columnName)->find();
        $extendModel->delete();
        echo json_encode(array('status'=>true));
    }


    public function action_config()
    {
        $config = DB::select()->from('sysconfig')->where('varname','like','cfg_plugin_ship_line_%')->execute()->as_array();
        $list = array();
        foreach($config as $v)
        {
            $list[$v['varname']] = $v['value'];
        }
        $this->assign('list',$list);
        $this->display('admin/shipline/config');
    }
    public function action_ajax_config_save()
    {
        $cfg_arr = array('webid'=>0);
        foreach($_POST as $k=>$v)
        {
            if(strpos($k,'cfg_')===0)
            {
                $cfg_arr[$k] = $v;
            }
        }
        $sys_model = new Model_Sysconfig();
        $sys_model->saveConfig($cfg_arr);
        echo json_encode(array('status'=>true,'msg'=>'保存成功'));

    }



}
