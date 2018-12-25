<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Line extends Stourweb_Controller
{
    private $_jiaotong = array('飞机', '汽车', '火车', '轮船');
    private $_typeid = 1;

    public function before()
    {
        parent::before();
        //权限判断
        $action = $this->request->action();
        if ($action == 'line')
        {
            $param = $this->params['action'];
            $right = array(
                'read' => 'slook',
                'save' => 'smodify',
                'delete' => 'sdelete',
                'update' => 'smodify'
            );
            $user_action = $right[$param];
            if (!empty($user_action))
            {
                Common::getUserRight('line', $user_action);
            }
        }
        else if ($action == 'add')
        {
            Common::getUserRight('line', 'sadd');
        }
        else if ($action == 'edit')
        {
            Common::getUserRight('line', 'smodify');
        }
        else if ($action == 'day')
        {
            $param = $this->params['action'];
            $right = array(
                'add' => 'slook',
                'save' => 'smodify',
                'del' => 'sdelete'
            );
            $user_action = $right[$param] ? $right[$param] : 'slook';
            if (!empty($user_action))
            {
                Common::getUserRight('lineday', $user_action);
            }
        }
        else if ($action == 'price')
        {
            $param = $this->params['action'];
            $right = array(
                'add' => 'slook',
                'save' => 'smodify',
                'del' => 'sdelete'
            );
            $user_action = $right[$param] ? $right[$param] : 'slook';
            if (!empty($user_action))
            {
                Common::getUserRight('lineprice', $user_action);
            }
        }
        else if ($action == 'content') //线路行程
        {
            $param = $this->params['action'];
            $right = array(
                'save' => 'smodify',
            );
            $user_action = $right[$param] ? $right[$param] : 'slook';
            if (!empty($user_action))
            {
                Common::getUserRight('linejieshao', $user_action);
            }
        }
        else if ($action == 'ajax_linesave')
        {
            Common::getUserRight('line', 'smodify');
        }
        $this->assign('parentkey', $this->params['parentkey']);
        $this->assign('itemid', $this->params['itemid']);
        $this->assign('weblist', Common::getWebList());
        $this->assign('sysjiaotong', $this->_jiaotong);//交通
        // $this->assign('templetlist', Common::getUserTemplteList('line_show'));
    }

    /*
    线路列表操作
    */
    public function action_line()
    {

        $action = $this->params['action'];
        if (empty($action))  //显示线路列表页
        {
            $this->assign('kindmenu', Common::getConfig('menu_sub.linekind'));//分类设置项
            $this->display('admin/line/list');
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
            $webid = isset($_GET['webid']) ? Arr::get($_GET, 'webid') : '-1';
            $serial = Common::getKeyword($keyword);
            $specOrders = array('attrid', 'kindlist', 'iconlist', 'themelist');
            $order = ' ORDER BY IF(`status`>1,2,1),modtime DESC';
            $is_suitday = 0;
            if ($sort[0]['property'])
            {
                if ($sort[0]['property'] == 'displayorder')
                {
                    $prefix = '';
                }
                else if ($sort[0]['property'] == 'ishidden')
                {
                    $prefix = 'a.';
                }
                else if ($sort[0]['property'] == 'suitday')
                {
                    $prefix = 'd.';
                    $is_suitday = 1;
                }
                else if (in_array($sort[0]['property'], $specOrders))
                {
                    $prefix = 'order_';
                }
                $order = 'order by ' . $prefix . $sort[0]['property'] . ' ' . $sort[0]['direction'] . ',a.modtime desc';
            }
            $w = "a.id is not null and a.status>0 and a.status<4";
            if (!empty($keyword))
            {
                $w .= preg_match('`^\d+$`', $serial) ? " and (a.id={$serial} or a.title like '%{$keyword}%')"
                    : ($keyword == "平台自营" ? " and (a.title like '%{$keyword}%' or a.supplierlist is null or a.supplierlist='')"
                        : " and (a.title like '%{$keyword}%' or a.supplierlist in(select id from sline_supplier where suppliername like '%{$keyword}%'))");
            }
            $w .= empty($kindid) ? '' : " and find_in_set($kindid,a.kindlist)";
            $w .= empty($attrid) ? '' : " and find_in_set($attrid,a.attrid)";
            $w .= empty($startcity) ? '' : " and a.startcity='$startcity'";
            $w .= $webid == '-1' ? '' : " and a.webid=$webid";


            if ($kindid != 0)
            {
                $sql = "select a.id,a.aid,a.title,a.iconlist,a.finaldestid,a.price,a.startcity,if(length(ifnull(a.attrid,''))=0,0,1) as order_attrid,if(length(ifnull(a.kindlist,''))=0,0,1) as order_kindlist,if(length(ifnull(a.iconlist,''))=0,0,1) as order_iconlist,if(length(ifnull(a.themelist,''))=0,0,1) as order_themelist,
a.attrid,a.webid,a.kindlist,a.ishidden,a.piclist,a.themelist,a.supplierlist,a.status,b.isjian,IFNULL(b.displayorder,9999) as displayorder,b.isding,b.istejia";
                $sql.= $is_suitday==1? ",ifnull(d.suitday,0) as suitday ":'';
                $sql.=" from sline_line as a left join sline_kindorderlist b on (a.id=b.aid and b.typeid=1 and b.classid=$kindid) ";
                $sql.=$is_suitday==1?"left join (select
c.lineid,c.id,min(c.suitday) as suitday from(select a.lineid,a.id,max(ifnull(b.day,0)) as suitday from sline_line_suit a left join sline_line_suit_price b on a.id=b.suitid group by a.id) c group by c.lineid) d on a.id=d.lineid ":'';
                $sql.=" where $w  group by a.id $order limit  $start,$limit";
            }
            else
            {
                $sql = "select a.id,a.aid,a.title,a.supplierlist,a.status,a.iconlist,a.finaldestid,a.price,a.startcity,a.attrid,if(length(ifnull(a.attrid,''))=0,0,1) as order_attrid,if(length(ifnull(a.kindlist,''))=0,0,1) as order_kindlist,if(length(ifnull(a.iconlist,''))=0,0,1) as order_iconlist,if(length(ifnull(a.themelist,''))=0,0,1) as order_themelist,a.webid,a.kindlist,a.ishidden,a.piclist,a.themelist,b.isjian,IFNULL(b.displayorder,9999) as displayorder,b.isding,b.istejia ";
                $sql.= $is_suitday==1? ",ifnull(d.suitday,0) as suitday ":'';
                $sql.=" from sline_line as a left join sline_allorderlist b on (a.id=b.aid and b.typeid=1)  ";
                $sql.= $is_suitday==1?" left join (select
c.lineid,c.id,min(c.suitday) as suitday from(select a.lineid,a.id,max(ifnull(b.day,0)) as suitday from sline_line_suit a left join sline_line_suit_price b on a.id=b.suitid group by a.id) c group by c.lineid) d on a.id=d.lineid ":'';
                $sql.=" where $w group by a.id $order  limit $start,$limit";
            }
            $totalcount_arr = DB::query(Database::SELECT, "select count(*) as num from sline_line a where $w")->execute()->as_array();
            $list = DB::query(Database::SELECT, $sql)->execute()->as_array();
            $new_list = array();
            foreach ($list as $k => $v)
            {
                $v['kindname'] = Model_Destinations::getKindnameList($v['kindlist']);

                if(!$is_suitday)
                {
                    $v['suitday'] = DB::query(Database::SELECT,"select max(ifnull(b.day,0)) as suitday from sline_line_suit a left join sline_line_suit_price b on a.id=b.suitid  where a.lineid='{$v['id']}' group by a.id order by suitday limit 1 ")->execute()->get('suitday');
                }


                $finalDestInfo = DB::select_array(array('kindname'))->from('destinations')->where('id', '=', $v['finaldestid'])->execute()->current();//ORM::factory('destinations', $v['finaldestid']);
                if ($finalDestInfo)
                {
                    $v['finaldestname'] = $finalDestInfo['kindname'];
                }

                $v['attrname'] = Model_Line_Attr::get_attrname_list($v['attrid']);
                $v['url'] = Common::getBaseUrl($v['webid']) . '/lines/show_' . $v['aid'] . '.html';
                $iconname = Model_Icon::getIconName($v['iconlist']);
                $name = '';
                foreach ($iconname as $icon)
                {
                    if (!empty($icon))
                    {
                        $name .= '<span class="c-666">[' . $icon . ']</span>';
                    }
                }
                $v['iconname'] = $name;
                $v['lineseries'] = St_Product::product_series($v['id'], 1);//线路编号
                //供应商信息
                $supplier = DB::select()->from('supplier')->where('id', '=', $v['supplierlist'])->execute()->current();//ORM::factory('supplier')->where("id='{$v['supplierlist']}'")->find()->as_array();

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
                $suitOrder = $sort[0]['property'] == 'suitday' ? 'order by suitday ' . $sort[0]['direction'] : '';
                $suitSql = "select a.*,max(b.day) as suitday from sline_line_suit a left join sline_line_suit_price b on a.id=b.suitid where a.lineid={$v['id']}  group by a.id $suitOrder";
                $suit = DB::query(Database::SELECT, $suitSql)->execute()->as_array();
                if (!empty($suit))
                {
                    $v['tr_class'] = 'parent-line-tr';
                }
                if (empty($suit))
                {
                    $v['suitday'] = -1;
                }
                $new_list[] = $v;
                foreach ($suit as $key => $val)
                {
                    $val['title'] = $val['suitname'];
                    $val['minprice'] = Model_Line_Suit_Price::get_min_price($val['id']);
                    $val['minprofit'] = Model_Line_Suit_Price::get_min_price($val['id'], 'adultprofit');
                    $val['id'] = 'suit_' . $val['id'];
                    if ($key != count($suit) - 1)
                    {
                        $val['tr_class'] = 'suit-tr';
                    }
                    $new_list[] = $val;
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
                if ($field == 'displayorder')
                {
                    $displayorder = $data->displayorder;
                    if (empty($kindid))  //全局排序
                    {
                        $order = ORM::factory('allorderlist');
                        $order_mod = $order->where("aid='$id' and typeid=1 and webid=0")->find();
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
                            $order_mod->typeid = 1;
                        }
                        $order_mod->save();
                    }
                    else  //按目的地排序
                    {
                        $kindorder = ORM::factory('kindorderlist');
                        $kindorder_mod = $kindorder->where("aid='$id' and typeid=1 and classid=$kindid")->find();
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
                            $kindorder_mod->typeid = 1;
                        }
                        $kindorder_mod->save();
                    }
                }
            }
            else if (strpos($id, 'suit') !== FALSE)//如果是套餐
            {
                $suitid = substr($id, strpos($id, '_') + 1);
                $suit = ORM::factory('line_suit', $suitid);
                if ($field == 'displayorder')
                {
                    $displayorder = $data->displayorder;
                    $displayorder = empty($displayorder) ? 999999 : $displayorder;
                    $suit->displayorder = $displayorder;
                    $suit->save();
                }
                else
                {
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
                $line = ORM::factory('line', $id);
                $line->delete_clear();
                $jieshao_model = new Model_Line_Jieshao();
                $jieshao_model->delete_by_lineid($id);
            }
            else if (strpos($id, 'suit') !== FALSE)
            {
                $suitid = substr($id, strpos($id, '_') + 1);
                $suit = ORM::factory('line_suit', $suitid);
                $lineid = $suit->lineid;
                $suit->delete_clear();
                //删除套餐报价并更新最低报价
                DB::delete('line_suit_price')->where('suitid', '=', $suitid)->execute();
                DB::update('line')->set(array('price_date' => 0))->execute();
                Model_Line::update_min_price($lineid);
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
                        $order_mod = $order->where("aid='$id' and typeid=1 and webid=0")->find();
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
                            $order_mod->typeid = 1;
                        }
                        $order_mod->save();
                        if ($order_mod->saved())
                        {
                            echo 'ok';
                        }
                        else
                        {
                            echo 'no';
                        }
                    }
                    else  //按目的地排序
                    {
                        $kindorder = ORM::factory('kindorderlist');
                        $kindorder_mod = $kindorder->where("aid='$id' and typeid=1 and classid=$kindid")->find();
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
                            $kindorder_mod->typeid = 1;
                        }
                        $kindorder_mod->save();
                        if ($kindorder->saved())
                        {
                            echo 'ok';
                        }
                        else
                        {
                            echo 'no';
                        }
                    }
                }
                else if (strpos($id, 'suit') !== FALSE)//如果是套餐
                {
                    $suitid = substr($id, strpos($id, '_') + 1);
                    $suit = ORM::factory('line_suit', $suitid);
                    $displayorder = $val;
                    $displayorder = empty($displayorder) ? 999999 : $displayorder;
                    if ($suit->id)
                    {
                        $suit->displayorder = $displayorder;
                        $suit->save();
                        if ($suit->saved())
                        {
                            echo 'ok';
                        }
                        else
                        {
                            echo 'no';
                        }
                    }
                }
            }
            elseif ($field == 'status')
            {
                if (is_numeric($id))   //如果是线路
                {
                    $orm = ORM::factory('line', $id);
                    if ($val == 3)
                    {
                        $orm->status = 3;
                        $orm->ishidden = 0;
                    }
                    elseif ($val == 2)
                    {
                        $orm->status = 2;
                        $orm->ishidden = 1;
                    }
                    $orm->save();
                    if ($orm->saved())
                    {
                        echo 'ok';
                    }
                    else
                    {
                        echo 'no';
                    }
                }
            }
            else //如果不是排序
            {
                if (is_numeric($id))
                {
                    $model = ORM::factory('line', $id);
                }
                else if (strpos($id, 'suit') !== FALSE)
                {
                    $suitid = substr($id, strpos($id, '_') + 1);
                    $model = ORM::factory('line_suit', $suitid);
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
                    {
                        echo 'ok';
                    }
                    else
                    {
                        echo 'no';
                    }
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
        $columns = DB::select()->from('line_content')->where_open()->where('webid', '=', $webid)->and_where('isopen', '=', 1)
            ->and_where('isline', '=', 0)->and_where('columnname', '!=', 'linespot')->and_where_close()->or_where('columnname', '=', 'tupian')->order_by('displayorder', 'ASC')->execute()->as_array();

        $startplacelist = DB::select()->from('startplace')->where('pid', '!=', 0)->execute()->as_array();//ORM::factory('startplace')->where("pid!=0")->get_all();
        $this->assign('startplacelist', $startplacelist);
        $this->assign('columns', $columns);
        $this->assign('usertransport', array());
        $this->assign('position', '添加线路');
        $this->assign('action', 'add');
        //$this->assign('hasinsurance', Model_Insurance::hasInsurance());
        $this->display('admin/line/edit');
    }

    /*
     * 编辑线路
     */
    public function action_edit()
    {
        $lineid = $this->params['lineid'];
        $model = ORM::factory('line', $lineid);
        $this->assign('action', 'edit');
        $startplacelist = DB::select()->from('startplace')->where('pid', '!=', 0)->execute()->as_array();
        $this->assign('startplacelist', $startplacelist);
        //$this->assign('hasinsurance', Model_Insurance::hasInsurance());


        if ($model->id)
        {
            $info = $model->as_array();
            $extendinfo = Common::getExtendInfo(1, $model->id);
            $info['kindlist_arr'] = Model_Destinations::getKindlistArr($info['kindlist']);
            $attrid_arr = explode(',', $info['attrid']);
            $attr_arr = array();
            foreach ($attrid_arr as $k => $v)
            {
                $attr = ORM::factory('line_attr')->where(" id='$v'")->find();
                if ($attr->id)
                {
                    $attr_arr[] = $attr->as_array();
                }
            }
            $info['attrlist_arr'] = $attr_arr;
            $info['iconlist_arr'] = Common::getSelectedIcon($info['iconlist']);
            $info['supplier_arr'] = ORM::factory('supplier', $info['supplierlist'])->as_array();
            $info['insurance_arr'] = Model_Insurance::getNamePaires($info['insuranceids']);
            $day_arr = array_chunk(ORM::factory('line_jieshao')->where("lineid='" . $info['id'] . "'")->order_by('day', 'asc')->get_all(), $info['lineday']);
            $info['linejieshao_arr'] = $day_arr[0];
            $columns = ORM::factory('line_content')->where("(webid=0 and isopen=1 and isline=0 and columnname!='linespot') or (columnname='tupian' and webid=0)")->order_by('displayorder', 'asc')->get_all();
            $info['linedoc'] = unserialize($info['linedoc']);
            $info['jifenbook_info'] = DB::select()->from('jifen')->where('id', '=', $info['jifenbook_id'])->execute()->current();
            $info['jifentprice_info'] = DB::select()->from('jifen_price')->where('id', '=', $info['jifentprice_id'])->execute()->current();

            $this->assign('columns', $columns);
            $this->assign('webid', $info['webid']);
            $this->assign('info', $info);
            $this->assign('extendinfo', $extendinfo);//扩展信息
            $this->assign('position', '修改' . $info['title']);
            $this->assign('usertransport', explode(',', $info['transport']));
            $this->display('admin/line/edit');
        }
        else
        {
            echo 'URL地址错误，请重新选择线路';
        }
    }

    /*
       通过ajax保存线路
    */
    public function action_ajax_save()
    {
        $attrids = implode(',', Arr::get($_POST, 'attrlist'));//属性
        if (!empty($attrids))
        {
            $attrids = implode(',', Model_Attrlist::getParentsStr($attrids, 1));
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
        $data_arr['islinebefore'] = $_POST['islinebefore'] ? 1 : 0;
        $data_arr['recommendnum'] = $_POST['recommendnum'];
        $data_arr['supplierlist'] = implode(',', Arr::get($_POST, 'supplierlist'));
        $data_arr['linebefore'] = Arr::get($_POST, 'linebefore') ? Arr::get($_POST, 'linebefore') : 0;
        $data_arr['storeprice'] = Arr::get($_POST, 'storeprice') ? Arr::get($_POST, 'storeprice') : 0;
        $data_arr['childrule'] = Arr::get($_POST, 'childrule');
        $data_arr['templet'] = Arr::get($_POST, 'templet');
        $data_arr['templet'] = empty($data_arr['templet']) ? 'line_show.htm' : $data_arr['templet'];
        $data_arr['color'] = Arr::get($_POST, 'color');
        $data_arr['satisfyscore'] = Arr::get($_POST, 'satisfyscore') ? Arr::get($_POST, 'satisfyscore') : 0;
        $data_arr['bookcount'] = Arr::get($_POST, 'bookcount') ? Arr::get($_POST, 'bookcount') : 0;
        $data_arr['seotitle'] = Arr::get($_POST, 'seotitle');
        $data_arr['keyword'] = Arr::get($_POST, 'keyword');
        $data_arr['tagword'] = Arr::get($_POST, 'tagword');
        $data_arr['description'] = Arr::get($_POST, 'description');
        $data_arr['modtime'] = time();
        $data_arr['isstyle'] = Arr::get($_POST, 'isstyle') ? Arr::get($_POST, 'isstyle') : 2; //默认标准版
        $data_arr['showrepast'] = Arr::get($_POST, 'showrepast');
        $data_arr['jieshao'] = Arr::get($_POST, 'jieshao');
        $data_arr['biaozhun'] = Arr::get($_POST, 'biaozhun');
        $data_arr['beizu'] = Arr::get($_POST, 'beizu');
        $data_arr['payment'] = Arr::get($_POST, 'payment');
        $data_arr['feeinclude'] = Arr::get($_POST, 'feeinclude');
        $data_arr['features'] = Arr::get($_POST, 'features');
        $data_arr['reserved1'] = Arr::get($_POST, 'reserved1');
        $data_arr['reserved2'] = Arr::get($_POST, 'reserved2');
        $data_arr['reserved3'] = Arr::get($_POST, 'reserved3');
        $data_arr['startcity'] = Arr::get($_POST, 'startcity');
        $data_arr['transport'] = $this->get_transport();
        $data_arr['iconlist'] = Arr::get($_POST, 'iconlist') ? implode(',', Arr::get($_POST, 'iconlist')) : '';
        $data_arr['insuranceids'] = Arr::get($_POST, 'insuranceids') ? implode(',', Arr::get($_POST, 'insuranceids')) : '';
        $data_arr['jifenbook_id'] = empty($_POST['jifenbook_id']) ? 0 : $_POST['jifenbook_id'];
        $data_arr['jifentprice_id'] = empty($_POST['jifentprice_id']) ? 0 : $_POST['jifentprice_id'];
        //301跳转,自动添加链接
        if (!preg_match("/^(http|https):/", $_POST['redirect_url']) && !empty($_POST['redirect_url']))
        {
            $data_arr['redirect_url'] = 'http://' . $_POST['redirect_url'];
        }
		elseif(preg_match("/^(http|https):/", $_POST['redirect_url']) && !empty($_POST['redirect_url']))
        {
            $data_arr['redirect_url'] = $_POST['redirect_url'];
        }
        else
		{
		    $data_arr['redirect_url'] = '';
		}


        $data_arr['showhotel'] = Arr::get($_POST, 'showhotel');
        $data_arr['showtran'] = Arr::get($_POST, 'showtran');
        $data_arr['contractid'] = Arr::get($_POST, 'contractid');
        $data_arr['wap_templet'] = Arr::get($_POST, 'wap_templet');
        $data_arr['product_video'] = Arr::get($_POST, 'product_video');
        $data_arr['together_time'] = Arr::get($_POST, 'together_time');
        $data_arr['together_ids'] = implode(',',Arr::get($_POST, 'together_ids')) ;//拼团

        $status = Arr::get($_POST, 'status');
        if ($status == 3)
        {
            $data_arr['status'] = 3;
            $data_arr['ishidden'] = 0;
        }
        if ($status == 2)
        {
            $data_arr['status'] = 2;
            $data_arr['ishidden'] = 1;
        }
        $link = new Model_Tool_Link();
        $data_arr['jieshao'] = $link->keywordReplaceBody($data_arr['jieshao'], 1);

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
        if (!$headimgindex)
        {
            $data_arr['litpic'] = '';
        }
        $imgstr = trim($imgstr, ',');
        $data_arr['piclist'] = $imgstr;
        $data_arr['linedoc'] = serialize(Arr::get($_POST, 'linedoc'));
        if ($lineid == 0)
        {
            $data_arr['addtime'] = $data_arr['modtime'];
            $model = ORM::factory('line');
            $model->aid = Common::getLastAid('sline_line', $data_arr['webid']);
            $model->addtime = time();
            $data_arr['adminid'] = Session::instance()->get('userid');
        }
        else
        {
            $data_arr['modtime'] = time();
            $model = ORM::factory('line', $lineid);
            if ($model->webid != $data_arr['webid']) //如果更改了webid重新生成aid
            {
                $aid = Common::getLastAid('sline_line', $data_arr['webid']);
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
            if (St_Functions::is_system_app_install(111))
            {
                $planids = Arr::get($_POST, 'planid');
                if ($planids)
                {
                    Model_Insurance_Base::add_product_list($this->_typeid, $lineid, $planids);
                }
            }
            $this->savejieshao($lineid);
            Common::saveExtendData(1, $lineid, $_POST);//扩展信息保存
            echo $lineid;
        }
        else
        {
            echo 'no';
        }
    }


    private function get_transport()
    {
        if ($_POST['showtran'] != 1)
        {
            return '';
        }
        $transport = array();
        if ($_POST['transport'])
        {
            foreach ($_POST['transport'] as $t)
            {
                foreach ($t as $v)
                {
                    if (!in_array($v, $transport))
                    {
                        $transport[] = $v;
                    }
                }
            }
        }
        if ($transport)
        {
            return implode(',', $transport);
        }
        return '';
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
        $hotel_arr = Arr::get($_POST, 'hotel');
        $transport_arr = Arr::get($_POST, 'transport');
        $jieshao_arr = Arr::get($_POST, 'txtjieshao');
        // $beforemodels=ORM::factory('line_jieshao')->where("lineid='$lineid'")->find_all()->as_array();
        foreach ($title_arr as $k => $v)
        {
            $model = ORM::factory('line_jieshao')->where("lineid='$lineid' and day='$k'")->find();
            if (empty($model->id))
            {
                $model = ORM::factory('line_jieshao');
            }
            $model->lineid = $lineid;
            $model->day = $k;
            $model->hotel = $hotel_arr[$k];
            $model->breakfirst = $breakfirst_arr[$k];
            $model->lunch = $lunch_arr[$k];
            $model->supper = $supper_arr[$k];
            $model->title = $v;
            $superhas_arr[$k] = empty($superhas_arr[$k]) ? 0 : $superhas_arr[$k];
            $lunchhas_arr[$k] = empty($lunchhas_arr[$k]) ? 0 : $lunchhas_arr[$k];
            $breakfirsthas_arr[$k] = empty($breakfirsthas_arr[$k]) ? 0 : $breakfirsthas_arr[$k];
            $model->supperhas = $supperhas_arr[$k];
            $model->lunchhas = $lunchhas_arr[$k];
            $model->breakfirsthas = $breakfirsthas_arr[$k];
            $model->transport = implode(',', $transport_arr[$k]);
            $link = new Model_Tool_Link();
            $model->jieshao = $link->keywordReplaceBody($jieshao_arr[$k], 1);

            $model->save();
        }
    }

    /*
     * 线路天数
     */
    public function action_day()
    {
        $action = $this->params['action'];
        $this->assign('chooseid', 'attr_day');//顶部选中
        if (empty($action))
        {
            $list = ORM::factory('line_day')->get_all();
            $this->assign('list', $list);
            $this->display('admin/line/day');
        }
        else if ($action == 'add')
        {
            $model = ORM::factory('line_day');
            $model->create();
            echo $model->id;
        }
        else if ($action == 'save')
        {
            $word = Arr::get($_POST, 'dayword');
            foreach ($word as $k => $v)
            {
                DB::update('line_day')->set(array('word' => $v))->where('id', '=', $k)->execute();

            }
            echo 'ok';
        }
        else if ($action == 'del')
        {
            $id = Arr::get($_POST, 'id');
            //$model = ORM::factory('line_day', $id);
            //$model->delete();
            DB::delete('line_day')->where('id', '=', $id)->execute();
            echo 'ok';
        }
    }

    /*
     * 线路价格列表
     */
    public function action_price()
    {
        $this->assign('chooseid', 'attr_price');//顶部选中
        $action = $this->params['action'];
        if (empty($action))
        {
            $list = ORM::factory('line_pricelist')->get_all();
            $this->assign('list', $list);
            $this->display('admin/line/price');
        }
        else if ($action == 'add')
        {
            $model = ORM::factory('line_pricelist');
            $model->create();
            echo $model->id;
        }
        else if ($action == 'save')
        {
            $lowerprice = Arr::get($_POST, 'lowerprice');
            $highprice = Arr::get($_POST, 'highprice');
            // $newlowerprice = Arr::get($_POST, 'newlowerprice');
            // $newhighprice = Arr::get($_POST, 'newhighprice');
            foreach ($lowerprice as $k => $v)
            {
                /*$model = ORM::factory('line_pricelist', $k);
                if ($model->id)
                {
                    $model->lowerprice = $v;
                    $model->highprice = $highprice[$k];
                    $model->save();
                }*/
                $arr = array('lowerprice' => $v, 'highprice' => $highprice[$k]);
                DB::update('line_pricelist')->set($arr)->where('id', '=', $k)->execute();

            }
            echo 'ok';
        }
        else if ($action == 'del')
        {
            $id = Arr::get($_POST, 'id');
            DB::delete('line_pricelist')->where('id', '=', $id)->execute();
            echo 'ok';
        }
    }

    /*
     * 线路属性操作
     */
    public function action_attr()
    {
        $action = $this->params['action'];
        if (empty($action))
        {
            $this->display('admin/line/attr');
        }
        else if ($action == 'read')
        {
            $node = Arr::get($_GET, 'node');
            $list = array();
            if ($node == 'root')
            {
                $list = ORM::factory('line_attr')->where('pid=0')->get_all();
                foreach ($list as $k => $v)
                {
                    $list[$k]['kindname'] = Model_Destinations::getKindnameList($v['destid']);
                    $list[$k]['allowDrag'] = false;
                }
                $list[] = array('leaf' => true, 'id' => '0add', 'attrname' => '<button class="dest-add-btn" onclick="addSub(0)">添加</button>', 'allowDrag' => false, 'allowDrop' => false, 'displayorder' => 'add');
            }
            else
            {
                $list = ORM::factory('line_attr')->where('pid=' . $node)->get_all();
                foreach ($list as $k => $v)
                {
                    $list[$k]['kindname'] = Model_Destinations::getKindnameList($v['destid']);
                    $list[$k]['leaf'] = true;
                }
                $list[] = array('leaf' => true, 'id' => $node . 'add', 'attrname' => '<button class="dest-add-btn" onclick="addSub(\'' . $node . '\')">添加</button>', 'allowDrag' => false, 'allowDrop' => false, 'displayorder' => 'add');
            }
            echo json_encode(array('success' => true, 'text' => '', 'children' => $list));
        }
        else if ($action == 'addsub')
        {
            $pid = Arr::get($_POST, 'pid');
            $model = ORM::factory('line_attr');
            $model->pid = $pid;
            $model->attrname = "未命名";
            $model->save();
            if ($model->saved())
            {
                $model->reload();
                //  $dest->updateSibling('add');
                echo json_encode($model->as_array());
            }
        }
        else if ($action == 'save')
        {
            $rawdata = file_get_contents('php://input');
            $field = Arr::get($_GET, 'field');
            $data = json_decode($rawdata);
            $id = $data->id;
            if ($field)
            {
                $model = ORM::factory('line_attr', $id);
                if ($model->id)
                {
                    $model->$field = $data->$field;
                    $model->save();
                    if ($model->saved())
                    {
                        echo 'ok';
                    }
                    else
                    {
                        echo 'no';
                    }
                }
            }
        }
        else if ($action == 'drag')
        {
            $moveid = Arr::get($_POST, 'moveid');
            $overid = Arr::get($_POST, 'overid');
            $position = Arr::get($_POST, 'position');
            $movemodel = ORM::factory('line_attr', $moveid);
            $overmodel = ORM::factory('line_attr', $overid);
            if ($position == 'append')
            {
                $movemodel->pid = $overid;
            }
            else
            {
                $movemodel->pid = $overmodel->pid;
            }
            $movemodel->save();
            if ($movemodel->saved())
            {
                echo 'ok';
            }
            else
            {
                echo 'no';
            }
        }
        else if ($action == 'delete')
        {
            $rawdata = file_get_contents('php://input');
            $data = json_decode($rawdata);
            $id = $data->id;
            if (!is_numeric($id))
            {
                echo json_encode(array('success' => false));
                exit;
            }
            $model = ORM::factory('line_attr', $id);
            $model->delete_clear();
        }
        else if ($action == 'update')
        {
            $id = Arr::get($_POST, 'id');
            $field = Arr::get($_POST, 'field');
            $val = Arr::get($_POST, 'val');
            $model = ORM::factory('line_attr', $id);
            if ($model->id)
            {
                $model->$field = $val;
                $model->save();
                if ($model->saved())
                {
                    echo 'ok';
                }
                else
                {
                    echo 'no';
                }
            }
        }
    }

    /*
      线路行程
    */
    public function action_content()
    {
        $action = $this->params['action'];
        if (empty($action))
        {
            $linecontent = ORM::factory('line_content')->where('webid=0')->order_by('displayorder')->get_all();
            $config = Model_Menu_New::set_config();//var_dump($linecontent );
            foreach ($config as $item)
            {
                if (is_null($item['typeid']) && $item['controller'] == 'config' && $item['method'] == 'payment')
                {
                    foreach ($linecontent as &$content)
                    {
                        if ($content['columnname'] == 'payment')
                        {
                            $content['link_url'] = $item['url'];
                            $content['link_title'] = $item['title'];
                            break;
                        }
                    }
                    break;
                }
            }
            $this->assign('list', $linecontent);
            $this->display('admin/line/content');
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
                $model = ORM::factory('line_content', $k);
                if ($model->id)
                {
                    $open = $isopen[$k] ? 1 : 0;
                    $model->chinesename = $chinesename[$k];
                    $model->displayorder = $v;
                    $model->isopen = $open;
                    $model->save();
                }
            }
            /*foreach($newchinesename as $k=>$v)
            {
                $open=$newisopen[$k]?1:0;
                $model=ORM::factory('line_content');
                $model->chinesename=$v;
                $model->isopen=$open;
                $model->displayorder=$newdisplayorder[$k];
                $model->save();
            }*/
            //更新扩展字段描述
            Model_Line_Content::update_extend_field_name();
            echo 'ok';
        }
    }

    /*
     * 添加套餐
     */
    public function action_addsuit()
    {
        $lineid = $this->params['lineid'];
        $lineinfo = ORM::factory('line', $lineid)->as_array();
        $info = array('lastoffer' => array('pricerule' => 'all', 'number' => '-1'));
        $this->assign('lineinfo', $lineinfo);
        $this->assign('info', $info);
        $this->assign('action', 'add');
        $this->assign('position', '添加套餐');
        $this->display('admin/line/suit_edit');
    }

    /*
   * 修改套餐
   */
    public function action_editsuit()
    {
        $suitid = $this->params['suitid'];
        $info = ORM::factory('line_suit', $suitid)->as_array();


        $lineinfo = ORM::factory('line', $info['lineid'])->as_array();
        $this->assign('action', 'edit');
        $this->assign('lineinfo', $lineinfo);
        $this->assign('info', $info);
        $this->assign('position', '修改套餐');
        $this->display('admin/line/suit_edit');
    }

    /*
     * 保存套餐
     */
    public function action_ajax_suitsave()
    {
        $lineid = Arr::get($_POST, 'lineid');
        $suitid = $_POST['suitid'];
        $data_arr = array();
        $data_arr['suitname'] = Arr::get($_POST, 'suitname');
        $data_arr['lineid'] = Arr::get($_POST, 'lineid');
        $data_arr['description'] = Arr::get($_POST, 'content');
        $data_arr['sellprice'] = Arr::get($_POST, 'sellprice');
        $data_arr['adultdesc'] = Arr::get($_POST, 'adultdesc');
        $data_arr['childdesc'] = Arr::get($_POST, 'childdesc');
        $data_arr['olddesc'] = Arr::get($_POST, 'olddesc');
        $data_arr['roomdesc'] = Arr::get($_POST, 'roomdesc');
        //会员预订方式
        $data_arr['paytype'] = Arr::get($_POST, 'paytype');

        $data_arr['dingjin'] = $data_arr['paytype'] == 2 ? Arr::get($_POST, 'dingjin') : '';


        //预订确认方式
        $data_arr['need_confirm'] = Arr::get($_POST, 'need_confirm') ? Arr::get($_POST, 'need_confirm') : 0;
        //会员支付方式
        $data_arr['pay_way'] = array_sum(Arr::get($_POST, 'pay_way'));
        //待付款时限,默认不限制
        $data_arr['auto_close_time'] = Arr::get($_POST, 'auto_close_time') ? Arr::get($_POST, 'auto_close_time') : 0;

        if ($data_arr['paytype'] != 2)
        {
            $data_arr['dingjin'] = 0;
        }
        if ($suitid)
        {
            $model = ORM::factory('line_suit', $suitid);
        }
        else
        {
            $model = ORM::factory('line_suit');
        }
        foreach ($data_arr as $k => $v)
        {
            $model->$k = $v;
        }
        $model->save();
        if ($model->saved())
        {
            $model->reload();
            Model_Line::update_min_price($lineid);
            echo $model->id;
        }
        else
        {
            echo 'no';
        }
    }

    public function save_baojia($lineid, $suitid, $arr)
    {
        $pricerule = Arr::get($arr, 'pricerule');
        $starttime = Arr::get($arr, 'starttime');
        $endtime = Arr::get($arr, 'endtime');
        $propgroup = Arr::get($arr, 'propgroup');

        if (empty($starttime) || empty($endtime))
        {
            return false;
        }
        //儿童
        $childbasicprice = $childprofit = 0;
        if (in_array(1, $propgroup))
        {
            $childbasicprice = Arr::get($arr, 'childbasicprice') ? Arr::get($arr, 'childbasicprice') : $childbasicprice;
            $childprofit = Arr::get($arr, 'childprofit') ? Arr::get($arr, 'childprofit') : $childprofit;
        }
        //成人
        $adultbasicprice = $adultprofit = 0;
        if (in_array(2, $propgroup))
        {
            $adultbasicprice = Arr::get($arr, 'adultbasicprice') ? Arr::get($arr, 'adultbasicprice') : $adultbasicprice;
            $adultprofit = Arr::get($arr, 'adultprofit') ? Arr::get($arr, 'adultprofit') : $adultprofit;
        }
        //老人
        $oldbasicprice = $oldprofit = 0;
        if (in_array(3, $propgroup))
        {
            $oldbasicprice = Arr::get($arr, 'oldbasicprice') ? Arr::get($arr, 'oldbasicprice') : $oldbasicprice;
            $oldprofit = Arr::get($arr, 'oldprofit') ? Arr::get($arr, 'oldprofit') : $oldprofit;
        }
        $roombalance = $arr['roombalance'];
        // $description = Arr::get($arr, 'description'); //描述
        $arr['store'] == 1 ? $number = -1 : $number = Arr::get($arr, 'number'); //库存
        $monthval = Arr::get($arr, 'monthval');
        $weekval = Arr::get($arr, 'weekval');
        $stime = strtotime($starttime);
        $etime = strtotime($endtime);
        $adultprice = floatval($adultbasicprice) + floatval($adultprofit);
        $childprice = floatval($childbasicprice) + floatval($childprofit);
        $oldprice = floatval($oldbasicprice) + floatval($oldprofit);

        //按日期范围报价
        if ($pricerule == '1')
        {
            $begintime = $stime;
            while (true)
            {
                $data_arr = array();
                $data_arr['lineid'] = $lineid;
                $data_arr['suitid'] = $suitid;
                $data_arr['adultbasicprice'] = $adultbasicprice;
                $data_arr['adultprofit'] = $adultprofit;
                $data_arr['adultprice'] = $adultprice;
                $data_arr['childbasicprice'] = $childbasicprice;
                $data_arr['childprofit'] = $childprofit;
                $data_arr['childprice'] = $childprice;
                $data_arr['oldbasicprice'] = $oldbasicprice;
                $data_arr['oldprofit'] = $oldprofit;
                $data_arr['oldprice'] = $oldprice;
                //  $data_arr['day'] = $begintime;
                // $data_arr['description'] = $description;
                $data_arr['roombalance'] = empty($roombalance) ? 0 : $roombalance;
                $data_arr['number'] = $number;
                $data_arr['propgroup'] = implode(',', $propgroup);
                $isdel = 0;
                if (!$propgroup || ($adultprice == 0 && $childprice == 0 && $oldprice == 0))
                {
                    $isdel = 1;
                }
                Model_Line_Suit_Price::update_date_price($lineid, $suitid, date('Y-m-d', $begintime), $data_arr, $isdel);
                $begintime = $begintime + 86400;
                if ($begintime > $etime)
                {
                    break;
                }
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
                    {
                        $v = '0' . $v;
                    }
                    $newtime = strtotime($beginyear . '-' . $beginmonth . '-' . $v);
                    if ((int)$v > (int)$daynum || $newtime < $stime || $newtime > $etime)
                    {
                        continue;
                    }
                    $data_arr['lineid'] = $lineid;
                    $data_arr['suitid'] = $suitid;
                    $data_arr['adultbasicprice'] = $adultbasicprice;
                    $data_arr['adultprofit'] = $adultprofit;
                    $data_arr['adultprice'] = $adultprice;
                    $data_arr['childbasicprice'] = $childbasicprice;
                    $data_arr['childprofit'] = $childprofit;
                    $data_arr['childprice'] = $childprice;
                    $data_arr['oldbasicprice'] = $oldbasicprice;
                    $data_arr['oldprofit'] = $oldprofit;
                    $data_arr['oldprice'] = $oldprice;
                    $data_arr['day'] = $newtime;
                    // $data_arr['description'] = $description;
                    $data_arr['roombalance'] = empty($roombalance) ? 0 : $roombalance;
                    $data_arr['number'] = $number;
                    $data_arr['propgroup'] = implode(',', $propgroup);
                    $isdel = 0;
                    if (!$propgroup || ($adultprice == 0 && $childprice == 0 && $oldprice == 0))
                    {
                        $isdel = 1;
                    }

                    Model_Line_Suit_Price::update_date_price($lineid, $suitid, date('Y-m-d', $newtime), $data_arr, $isdel);

                }
                $beginmonth = (int)$beginmonth + 1;
                if ($beginmonth > 12)
                {
                    $beginmonth = $beginmonth - 12;
                    $beginyear++;
                }
                if (($beginmonth > $emonth && $beginyear >= $eyear) || ($beginmonth <= $emonth && $beginyear > $eyear))
                {
                    break;
                }
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
                    $data_arr['lineid'] = $lineid;
                    $data_arr['suitid'] = $suitid;
                    $data_arr['adultbasicprice'] = $adultbasicprice;
                    $data_arr['adultprofit'] = $adultprofit;
                    $data_arr['adultprice'] = $adultprice;
                    $data_arr['childbasicprice'] = $childbasicprice;
                    $data_arr['childprofit'] = $childprofit;
                    $data_arr['childprice'] = $childprice;
                    $data_arr['oldbasicprice'] = $oldbasicprice;
                    $data_arr['oldprofit'] = $oldprofit;
                    $data_arr['oldprice'] = $oldprice;
                    $data_arr['day'] = $begintime;
                    // $data_arr['description'] = $description;
                    $data_arr['roombalance'] = empty($roombalance) ? 0 : $roombalance;
                    $data_arr['number'] = $number;
                    $data_arr['propgroup'] = implode(',', $propgroup);
                    $isdel = 0;
                    if (!$propgroup || ($adultprice == 0 && $childprice == 0 && $oldprice == 0))
                    {
                        $isdel = 1;
                    }
                    Model_Line_Suit_Price::update_date_price($lineid, $suitid, date('Y-m-d', $begintime), $data_arr, $isdel);

                }
                $begintime = $begintime + 86400;
                if ($begintime > $etime)
                {
                    break;
                }
            }
        }
        Model_Line::update_min_price($lineid);
    }

    /*
     * 删除行程附件
     * */
    public function action_ajax_del_doc()
    {
        $bool = false;
        if (isset($_POST['file']))
        {
            //删除文件
            $file = realpath(BASEPATH . $_POST['file']);
            $bool = !$file || unlink($file);
            if ($bool && isset($_POST['id']))
            {
                $data = DB::select()->from('line')->where('id', '=', $_POST['id'])->execute()->current();
                if (!empty($data))
                {
                    $attach = unserialize($data['linedoc']);
                    foreach ($attach['path'] as $k => $v)
                    {
                        if ($v == $_POST['file'])
                        {
                            unset($attach['path'][$k]);
                            unset($attach['name'][$k]);
                            break;
                        }
                    }
                    DB::update('line')->set(array('linedoc' => serialize($attach)))->where('id', '=', $_POST['id'])->execute();
                }
            }
        }
        echo json_encode(array('status' => $bool));
    }

    //获取景点
    public function action_ajax_getspot()
    {
        $content = Arr::get($_POST, 'content');
        $lineid = Arr::get($_POST, 'lineid');
        $day = Arr::get($_POST, 'day');
        $model = new Model_Line();
        $out = $model->auto_get_spot($content, $lineid, $day);
        echo json_encode($out);
    }

    //删除提取的景点
    public function action_ajax_del_dayspot()
    {
        $autoid = Arr::get($_POST, 'autoid');
        $model = new Model_Line();
        $flag = $model->del_day_spot($autoid);
        echo json_encode(array('status' => $flag));
    }

    //克隆线路
    public function action_ajax_clone()
    {
        $num = Arr::get($_POST, 'num');
        $lineid = Arr::get($_POST, 'id');
        $model = new Model_Line();
        $flag = $model->clone_line($lineid, $num);
        echo json_encode(array('status' => $flag));
    }

    //最低价规则
    public function action_min_price_rule()
    {
        $filed = array('cfg_line_minprice_rule', 'cfg_line_price_description');
        $config = Model_Sysconfig::get_configs(0, $filed);
        $this->assign('config', $config);
        $this->display('admin/line/min_price_rule');
    }

    /*
     * 短信通知
     */
    public function action_sms()
    {
        $model_info = DB::select()->from('model')->where('id', '=', $this->_typeid)->execute()->current();
        $pinyin = $model_info['pinyin'];
        $arr = DB::select()->from('sms_msg')->where('msgtype', 'like', $pinyin . '_%')->execute()->as_array();
        foreach ($arr as $row)
        {
            $key = substr($row['msgtype'], strlen($pinyin . '_'));
            $this->assign($key, $row['msg']);
            $this->assign($key . '_open', $row['isopen']);
        }

        $this->display('admin/line/sms');
    }

    /*
     * 短信保存
     */
    public function action_ajax_save_sms_msg()
    {
        $model_info = DB::select()->from('model')->where('id', '=', $this->_typeid)->execute()->current();
        $pinyin = $model_info['pinyin'];
        for ($i = 1; $i <= 4; $i++)
        {
            $_open = 'isopen' . $i;
            $_msg = 'order_msg' . $i;
            $open = $_POST[$_open];
            $msg = $_POST[$_msg];
            $msgtype = $pinyin . '_' . $_msg;
            $model = ORM::factory('sms_msg')->where('msgtype', '=', $msgtype)->find();
            $model->msgtype = $msgtype;
            $model->msg = $msg;
            $model->isopen = $open;
            $model->save();
        }
        echo json_encode(array('status' => true, 'msg' => '提交成功'));
    }

    /*
     * 邮件通知
     */
    public function action_email()
    {
        $model_info = DB::select()->from('model')->where('id', '=', $this->_typeid)->execute()->current();
        $pinyin = $model_info['pinyin'];
        $arr = DB::select()->from('email_msg')->where('msgtype', 'like', $pinyin . '_%')->execute()->as_array();
        foreach ($arr as $row)
        {
            $key = substr($row['msgtype'], strlen($pinyin . '_'));
            $this->assign($key, $row['msg']);
            $this->assign($key . '_open', $row['isopen']);
        }
        $this->display('admin/line/email');
    }

    /*
    * 邮件保存
    */
    public function action_ajax_save_email_msg()
    {
        $model_info = DB::select()->from('model')->where('id', '=', $this->_typeid)->execute()->current();
        $pinyin = $model_info['pinyin'];
        for ($i = 1; $i <= 4; $i++)
        {
            $_open = 'isopen' . $i;
            $_msg = 'order_msg' . $i;
            $open = $_POST[$_open];
            $msg = $_POST[$_msg];
            $msgtype = $pinyin . '_' . $_msg;
            $model = ORM::factory('email_msg')->where('msgtype', '=', $msgtype)->find();
            $model->msgtype = $msgtype;
            $model->msg = $msg;
            $model->isopen = $open;
            $model->save();
        }
        echo json_encode(array('status' => true, 'msg' => '提交成功'));
    }

    //添加内容项
    public function action_ajax_content_add()
    {
        $extend_table = 'sline_line_extend_field';

        $lastIndex = Common::getExtendContentIndex($extend_table);
        $fieldName = 'e_' . 'content_' . $lastIndex;
        $result = Common::addField($extend_table, 'content_' . $lastIndex, 'mediumtext', 0, '自定义' . $lastIndex);
        if ($result)
        {
            $data = Model_Line_Content::add_content_field($fieldName, '自定义' . $lastIndex);
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
        $model = ORM::factory('line_content', $id);
        $columnName = $model->columnname;
        $model->delete();
        DB::query(Database::DELETE, "alter table `sline_line_extend_field` drop column $columnName")->execute();
        $extendModel = ORM::factory('extend_field')->where('typeid', '=', $this->_typeid)->and_where('fieldname', '=', $columnName)->find();
        $extendModel->delete();
        echo json_encode(array('status' => true));
    }

    //清除最低价
    public function action_ajax_clear_minprice()
    {
        $rs = DB::update('line')->set(array('price_date' => null))->execute();
        echo $rs > 0 ? 1 : 0;
    }

    /**
     * 获取产品套餐
     */
    public function action_ajax_suit_list()
    {
        $status = 0;
        $product_id = intval($_POST['product_id']);
        $arr = DB::select()->from('line_suit')->where('lineid', '=', $product_id)->execute()->as_array();
        if (count($arr) > 0)
        {
            $status = 1;
        }
        echo json_encode(array('status' => $status, 'list' => $arr));
    }

    /**
     * 获取套餐选择日期报价
     */
    public function action_ajax_suit_price()
    {
        $suit_id = intval(Arr::get($_GET, 'suit_id'));

        $useday = strtotime(Arr::get($_GET, 'useday'));
        $ar = Model_Line_Suit_Price::get_price_byday($suit_id, $useday);
        echo json_encode($ar[0]);
    }


    /**
     * @function 供应商审核
     */
    public function action_dialog_supplier_check()
    {
        $action = $_GET['action'];
        $id = $_GET['id'];
        if (!$action)
        {
            $this->assign('id', $id);
            $this->display('admin/line/dialog_supplier_check');
        }
        if ($action == 'save')
        {
            $data = array(
                'status' => $_GET['status'],
                'refuse_msg' => $_GET['refuse_msg'],
                'modtime' => time(),
            );
            //审核通过自动上架，不通过下架
            if ($_GET['status'] == 3)
            {
                $data['ishidden'] = 0;
            }
            else
            {
                $data['ishidden'] = 1;
            }
            DB::update('line')->set($data)->where('id', '=', $id)->execute();
            echo 'ok';
        }
    }

    /**
     * @function 异步获取模板列表
     */
    public function action_ajax_get_template_list()
    {
        $page = $_POST['page'];
        $webid = $_POST['webid'];
        $list = Model_Line::get_template_list($page, $webid);
        echo json_encode($list);

    }

    /**
     * @function 修改报价弹窗
     */
    public function action_dialog_edit_suit_price()
    {
        $suitid = $_GET['suit'];
        $lineid = $_GET['lineid'];
        $date = strtotime($_GET['date']);
        $ar = Model_Line_Suit_Price::get_price_by_date($suitid, $date);
        $this->assign('suitid', $suitid);
        $this->assign('lineid', $lineid);
        $this->assign('date', $_GET['date']);
        $this->assign('info', $ar);
        $this->display('admin/line/calendar/dialog_edit_price');
    }

    /**
     * @function 保存一天的报价
     */
    public function action_ajax_save_day_price()
    {
        $propgroup = $_POST['propgroup'] ? $_POST['propgroup'] : array();

        if (in_array(2, $propgroup))
        {
            $adultbasicprice = floatval($_POST['adultbasicprice']);
            $adultprofit = floatval($_POST['adultprofit']);
            $adultprice = $adultbasicprice + $adultprofit;
        }
        else
        {
            $adultprofit = $adultbasicprice = $adultprice = 0;
        }

        if (in_array(1, $propgroup))
        {
            $childbasicprice = floatval($_POST['childbasicprice']);
            $childprofit = floatval($_POST['childprofit']);
            $childprice = $childbasicprice + $childprofit;
        }
        else
        {
            $childprice = $childprofit = $childbasicprice = 0;
        }
        if (in_array(3, $propgroup))
        {
            $propgroup[] = 3;
            $oldbasicprice = floatval($_POST['oldbasicprice']);
            $oldprofit = floatval($_POST['oldprofit']);
            $oldprice = $oldbasicprice + $oldprofit;
        }
        else
        {
            $oldprice = $oldbasicprice = $oldprofit = 0;
        }
        $roombalance = $_POST['roombalance'] ? floatval($_POST['roombalance']) : 0;
        $store = $_POST['store'];
        $store == 1 ? $number = -1 : $number = $_POST['number'];
        $suitid = $_POST['suitid'];
        $lineid = $_POST['lineid'];
        $date = $_POST['date'];
        $data = array(
            'adultbasicprice' => $adultbasicprice,
            'adultprofit' => $adultprofit,
            'adultprice' => $adultprice,
            'childbasicprice' => $childbasicprice,
            'childprofit' => $childprofit,
            'childprice' => $childprice,
            'oldbasicprice' => $oldbasicprice,
            'oldprofit' => $oldprofit,
            'oldprice' => $oldprice,
            'roombalance' => $roombalance,
            'number' => $number,
            'propgroup' => implode(',', $propgroup)
        );
        $isdel = 0;
        if (!$propgroup || ($adultprice == 0 && $childprice == 0 && $oldprice == 0))
        {
            $isdel = 1;
        }
        Model_Line_Suit_Price::update_date_price($lineid, $suitid, $date, $data, $isdel);
        Model_Line::update_min_price($lineid);
        $data['date'] = $date;
        echo json_encode($data);

    }


    /**
     * @function 清空全部报价
     */
    public function action_ajax_clear_all_price()
    {
        $suitid = $_POST['suitid'];
        $lineid = $_POST['lineid'];
        DB::delete('line_suit_price')->where('suitid', '=', $suitid)
            ->and_where('lineid', '=', $lineid)->execute();

    }

    /**
     * @function 添加报价
     */
    public function action_dialog_add_suit_price()
    {
        $action = $_GET['action'];
        $lineid = $_GET['lineid'];
        $suitid = $_GET['suit'];

        $this->assign('action', $action);
        $this->assign('lineid', $lineid);
        $this->assign('suitid', $suitid);
        $this->display('admin/line/calendar/dialog_add_price');
    }

    /**
     * @function 保存套餐报价
     */
    public function action_ajax_save_suit_price()
    {
        $lineid = $_POST['lineid'];
        $suitid = $_POST['suitid'];
        $arr = $_POST;
        $this->save_baojia($lineid, $suitid, $arr);

    }

    public function action_agreement()
    {
        $fields = array('cfg_line_order_agreement_open', 'cfg_line_order_agreement','cfg_line_order_agreement_selected');
        $config = Model_Sysconfig::get_configs(0, $fields);
        $this->assign('config', $config);
        $this->display('admin/line/agreement');
    }
}
