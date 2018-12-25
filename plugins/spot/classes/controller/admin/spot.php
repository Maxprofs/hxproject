<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Spot extends Stourweb_Controller
{
    private $_typeid = 5;

    public function before()
    {
        parent::before();
        $action = $this->request->action();

        if ($action == 'spot')
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
                Common::getUserRight('spot', $user_action);

        }
        else if ($action == 'add')
        {
            Common::getUserRight('spot', 'sadd');
        }
        else if ($action == 'edit')
        {
            Common::getUserRight('spot', 'smodify');
        }
        else if ($action == 'price')
        {
            Common::getUserRight('spotprice', 'slook');
        }

        else if ($action == 'ajax_price')
        {
            $param = $this->params['action'];
            $right = array(

                'save' => 'smodify',
                'del' => 'sdelete'
            );
            $user_action = $right[$param] ? $right[$param] : 'slook';
            if (!empty($user_action))
                Common::getUserRight('spotprice', $user_action);

        }
        else if ($action == 'ajax_save')
        {
            Common::getUserRight('spot', 'smodify');
        }
        $this->assign('parentkey', $this->params['parentkey']);
        $this->assign('itemid', $this->params['itemid']);
        $this->assign('weblist', Common::getWebList());
    }

    /*
   景点列表
    */
    public function action_spot()
    {
        $action = $this->params['action'];
        if (empty($action))  //显示线路列表页
        {
            $this->assign('kindmenu', Common::getConfig('menu_sub.spotkind'));//分类设置项
            $this->display('admin/spot/list');
        }
        else if ($action == 'read')    //读取列表
        {
            $start = Arr::get($_GET, 'start');
            $limit = Arr::get($_GET, 'limit');
            $keyword = Arr::get($_GET, 'keyword');
            $kindid = Arr::get($_GET, 'kindid');
            $attrid = Arr::get($_GET, 'attrid');
            $sort = json_decode(Arr::get($_GET, 'sort'), true);
            $order = 'order by a.modtime desc';
            $webid = isset($_GET['webid']) ? Arr::get($_GET, 'webid') : '-1';
            $keyword = Common::getKeyword($keyword);
            $specOrders = array('attrid', 'kindlist', 'iconlist', 'themelist');

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
                else if (in_array($sort[0]['property'], $specOrders))
                {
                    $prefix = 'order_';
                }
                else if ($sort[0]['property'] == 'suitday')
                {
                    $prefix = 'd.';
                    $is_suitday = 1;
                }

                else if($sort[0]['property']=='status')
                {
                    $sort[0]['property']='un_status_num';
                    $prefix = 's.';
                }
                $order = 'order by ' . $prefix . $sort[0]['property'] . ' ' . $sort[0]['direction'] . ',a.modtime desc';
            }
            $w = "a.id is not null";
            $w .= empty($keyword) ? '' : " and (a.title like '%{$keyword}%' or a.id like '%{$keyword}%' or a.id in (select j.spotid from sline_spot_ticket j inner join sline_supplier k on j.supplierlist=k.id where k.suppliername like '%{$keyword}%' or k.mobile like '%{$keyword}%' or k.email like '%{$keyword}%' ))";
            $w .= empty($kindid) ? '' : " and find_in_set($kindid,a.kindlist)";
            $w .= empty($attrid) ? '' : " and find_in_set($attrid,a.attrid)";
            $w .= $webid == '-1' ? '' : " and a.webid=$webid";

            if (empty($kindid))
            {
                $sql = "select a.aid,a.id,a.title,a.price,a.tagword,a.kindlist,a.finaldestid,a.attrid,a.litpic,if(length(ifnull(a.attrid,''))=0,0,1) as order_attrid,if(length(ifnull(a.kindlist,''))=0,0,1) as order_kindlist,if(length(ifnull(a.iconlist,''))=0,0,1) as order_iconlist,if(length(ifnull(a.themelist,''))=0,0,1) as order_themelist,
a.webid,a.piclist,a.themelist,a.iconlist,a.supplierlist,a.ishidden,b.isjian,ifnull(b.displayorder,9999) as displayorder,b.isding ";
                $sql.= $is_suitday==1? ",ifnull(d.suitday,0) as suitday ":'';
                $sql .=" from sline_spot as a left join sline_allorderlist b on (a.id=b.aid and b.typeid=5) ";
                $sql.=$is_suitday==1?"left join (select
c.spotid,c.id,min(c.suitday) as suitday from(select a.spotid,a.id,max(ifnull(b.day,0)) as suitday from sline_spot_ticket a left join sline_spot_ticket_price b on a.id=b.ticketid group by a.id) c group by c.spotid) d on a.id=d.spotid ":'';

                $sql.=" left join (select spotid,count(*) as un_status_num from sline_spot_ticket where status!=3  group by spotid) s on a.id=s.spotid ";
                $sql .=" where $w group by a.id $order  limit $start,$limit ";
            }
            else
            {
                $sql = "select a.aid,a.id,a.title,a.price,a.finaldestid,if(length(ifnull(a.attrid,''))=0,0,1) as order_attrid,if(length(ifnull(a.kindlist,''))=0,0,1) as order_kindlist,if(length(ifnull(a.iconlist,''))=0,0,1) as order_iconlist,if(length(ifnull(a.themelist,''))=0,0,1) as order_themelist,
a.tagword,a.kindlist,a.attrid,a.litpic,a.webid,a.piclist,a.themelist,a.iconlist,a.supplierlist,a.ishidden,b.isjian,ifnull(b.displayorder,9999) as displayorder,b.isding ";
                $sql.= $is_suitday==1? ",ifnull(d.suitday,0) as suitday ":'';
                $sql.=" from sline_spot as a left join sline_kindorderlist as b on (b.classid={$kindid} and a.id=b.aid and b.typeid=5) ";
                $sql.=$is_suitday==1?" left join (select
c.spotid,c.id,min(c.suitday) as suitday from(select a.spotid,a.id,max(ifnull(b.day,0)) as suitday from sline_spot_ticket a left join sline_spot_ticket_price b on a.id=b.ticketid group by a.id) c group by c.spotid) d on a.id=d.spotid ":'';
                $sql.=" left join (select spotid,count(*) as un_status_num from sline_spot_ticket where status!=3  group by spotid) s on a.id=s.spotid ";
                $sql .=" where $w group by a.id $order  limit $start,$limit ";

            }

            $totalcount_arr = DB::query(Database::SELECT, "select count(*) as num from sline_spot a where $w")->execute()->as_array();
            $list = DB::query(Database::SELECT, $sql)->execute()->as_array();
            $new_list = array();
            foreach ($list as $k => $v)
            {


                $finalDestInfo = DB::select_array(array('kindname'))->from('destinations')->where('id', '=', $v['finaldestid'])->execute()->current();
                if ($finalDestInfo)
                    $v['finaldestname'] = $finalDestInfo['kindname'];
                $v['kindname'] = Model_Destinations::get_kindname_list($v['kindlist']);
                $v['attrname'] = Model_Spot_Attr::get_attrname_list($v['attrid']);
                $v['url'] = Common::getBaseUrl($v['webid']) . '/spots/show_' . $v['aid'] . '.html';
                $iconname = Model_Icon::getIconName($v['iconlist']);
                $name = '';
                foreach ($iconname as $icon)
                {
                    if (!empty($icon))
                        $name .= '<span class="c-999 ml-10">[' . $icon . ']</span>';
                }
                $v['iconname'] = $name;

                $v['series'] = St_Product::product_series($v['id'], 5);//编号

                //供应商信息
               /* $supplier = DB::select()->from('supplier')->where('id', '=', $v['supplierlist'])->execute()->current();
                $v['suppliername'] = $supplier['suppliername'];*/
                //$v['linkman'] = $supplier['linkman'];
                //$v['mobile'] = $supplier['mobile'];
                //$v['address'] = $supplier['address'];

                //$v['qq'] = $supplier['qq'];

                //报价有效期
                if(!$is_suitday)
                {
                    $v['suitday'] = DB::query(Database::SELECT,"select max(ifnull(b.day,0)) as suitday from sline_spot_ticket a left join sline_spot_ticket_price b on a.id=b.ticketid  where a.spotid='{$v['id']}' group by a.id order by suitday limit 1 ")->execute()->get('suitday');
                }


                $suit_order = $sort[0]['property'] == 'suitday' ? 'order by suitday ' . $sort[0]['direction'] : ' order by a.displayorder asc';
                $suit_order = $sort[0]['property'] == 'un_status_num' ? 'order by case when status!=3 then 1 else 0 end ' . $sort[0]['direction'] : ' order by a.displayorder asc';


                $suits = DB::query(Database::SELECT, "select a.*,b.kindname as tickettypename,max(c.day) as suitday  from sline_spot_ticket a left join sline_spot_ticket_type b on a.tickettypeid=b.id left join sline_spot_ticket_price c on a.id=c.ticketid where a.spotid={$v['id']} group by a.id {$suit_order}")->execute()->as_array();

                if (!empty($suits))
                    $v['tr_class'] = 'parent-product-tr';
                if (empty($suits))
                {
                    $v['suitday'] = -1;
                }
                $new_list[] = $v;
                foreach ($suits as $key => $val)
                {
                    $supplier = DB::select()->from('supplier')->where('id', '=', $val['supplierlist'])->execute()->current();
                    $val['suppliername'] = $supplier['suppliername'];
                    $val['linkman'] = $supplier['linkman'];
                    $val['mobile'] = $supplier['mobile'];
                    $val['address'] = $supplier['address'];
                    $val['qq'] = $supplier['qq'];

                    $val['ticketid'] = $val['id'];//门票id
                    $val['spotid'] = $v['id'];//景点id
                    $val['id'] = 'suit_' . $val['id'];
                    $val['paytype_name'] = Model_Member_Order::get_paytype_name($val['paytype']);
                    $val['price'] = $this->get_ticket_min_price($val['ticketid']);

                    if ($key != count($suits) - 1)
                        $val['tr_class'] = 'suit-tr';
                    $new_list[] = $val;
                }
            }

            $result['total'] = $totalcount_arr[0]['num'];
            $result['lists'] = $new_list;
            $result['success'] = true;

            echo json_encode($result);
        }
        else if ($action == 'save')   //保存字段
        {

        }
        else if ($action == 'delete') //删除某个记录
        {
            $rawdata = file_get_contents('php://input');
            $data = json_decode($rawdata);
            $id = $data->id;

            if (is_numeric($id)) //租车
            {
                $model = ORM::factory('spot', $id);
                $model->delete_clear();
            }
            else if (strpos($id, 'suit') !== FALSE)
            {
                $suitid = substr($id, strpos($id, '_') + 1);
                $suit = ORM::factory('spot_ticket', $suitid);
                $suit->delete_clear();
                DB::update('spot')->set(array('price_date'=>0))->execute();
            }
        }
        else if ($action == 'update')//更新某个字段
        {
            $id = Arr::get($_POST, 'id');
            $field = Arr::get($_POST, 'field');
            $val = Arr::get($_POST, 'val');
            $kindid = Arr::get($_POST, 'kindid');


            if ($field == 'displayorder')  //如果是排序
            {
                $displayorder = empty($val) ? 9999 : $val;
                if (is_numeric($id))//如果是景点
                {
                    if (empty($kindid))  //全局排序
                    {
                        $order = ORM::factory('allorderlist');
                        $order_mod = $order->where("aid='$id' and typeid=5 and webid=0")->find();

                        if ($order_mod->id)  //如果已经存在
                        {
                            $order_mod->displayorder = $displayorder;
                        }
                        else   //如果这个排序不存在
                        {
                            $order_mod->displayorder = $displayorder;
                            $order_mod->aid = $id;
                            $order_mod->webid = 0;
                            $order_mod->typeid = 5;
                        }
                        $order_mod->save();
                        if ($order_mod->saved())
                        {
                            echo 'ok';
                        }
                        else
                            echo 'no';
                    }
                    else  //按目的地排序
                    {
                        $kindorder = ORM::factory('kindorderlist');
                        $kindorder_mod = $kindorder->where("aid='$id' and typeid=5 and classid=$kindid")->find();
                        if ($kindorder_mod->id)
                        {
                            $kindorder_mod->displayorder = $displayorder;
                        }
                        else
                        {
                            $kindorder_mod->displayorder = $displayorder;
                            $kindorder_mod->aid = $id;
                            $kindorder_mod->classid = $kindid;
                            $kindorder_mod->typeid = 5;
                        }
                        $kindorder_mod->save();
                        if ($kindorder->saved())
                            echo 'ok';
                        else
                            echo 'no';

                    }
                }
                else if (strpos($id, 'suit') !== FALSE)
                {
                    $suitid = substr($id, strpos($id, '_') + 1);
                    $value_arr = array('displayorder' => $displayorder);
                    $updated = DB::update('spot_ticket')->set($value_arr)->where('id', '=', $suitid)->execute();
                    if ($updated)
                        echo 'ok';
                    else
                        echo 'no';


                }

            }
            else  //如果不是排序字段
            {
                if (is_numeric($id))
                {
                    $model = ORM::factory('spot', $id);
                }
                else if (strpos($id, 'suit') !== FALSE)
                {
                    $suitid = substr($id, strpos($id, '_') + 1);
                    $model = ORM::factory('spot_ticket', $suitid);
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
                        $model->$field = implode(',', Model_Attrlist::getParentsStr($val, 5));
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
   * 添加景点
   * */
    public function action_add()
    {
        $this->assign('webid', 0);
        $this->assign('position', '添加景点');
        $this->assign('action', 'add');
        $columns = ORM::factory('spot_content')->where("(webid=0 and isopen=1) and columnname!='tupian'")->order_by('displayorder', 'asc')->get_all();
        $this->assign('columns', $columns);
        $this->display('admin/spot/edit');
    }

    /*
    * 修改景点
    * */
    public function action_edit()
    {
        $productid = $this->params['id'];

        $this->assign('action', 'edit');
        $info = ORM::factory('spot', $productid)->as_array();
        $info['kindlist_arr'] = ORM::factory('destinations')->getKindlistArr($info['kindlist']);//目的地数组


        $info['attrlist_arr'] = json_encode(Common::getSelectedAttr(5, $info['attrid']));//属性数组
        $info['iconlist_arr'] =  Common::getSelectedIcon($info['iconlist']);//json_encode(Common::getSelectedIcon($info['iconlist']));//图标数组
        $info['supplier_arr'] = ORM::factory('supplier', $info['supplierlist'])->as_array();
        $info['piclist_arr'] = json_encode(Common::getUploadPicture($info['piclist']));//图片数组

        $info['jifenbook_info'] = DB::select()->from('jifen')->where('id','=',$info['jifenbook_id'])->execute()->current();
        $info['jifentprice_info'] = DB::select()->from('jifen_price')->where('id','=',$info['jifentprice_id'])->execute()->current();


        $columns = ORM::factory('spot_content')->where("(webid=0 and isopen=1) and columnname!='tupian'")->order_by('displayorder', 'asc')->get_all();
        $extendinfo = Common::getExtendInfo(5, $info['id']);
        $this->assign('columns', $columns);
        $this->assign('extendinfo', $extendinfo);//扩展信息
        $this->assign('info', $info);
        $this->assign('position', '修改景点' . $info['title']);
        $this->display('admin/spot/edit');


    }

    /*
     * 保存景点(ajax)
     * */
    public function action_ajax_save()
    {


        $action = Arr::get($_POST, 'action');//当前操作

        $id = Arr::get($_POST, 'productid');

        $status = false;

        $webid = Arr::get($_POST, 'webid');//所属站点
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

        //添加操作
        if ($action == 'add' && empty($id))
        {
            $model = ORM::factory('spot');
            $model->aid = Common::getLastAid('sline_spot', $webid);
            $model->addtime = time();
        }
        else
        {
            $model = ORM::factory('spot', $id);
            if ($model->webid != $webid) //如果更改了webid重新生成aid
            {
                $aid = Common::getLastAid('sline_spot', $webid);
                $model->aid = $aid;
            }
        }
        //选中上级属性
        $attrids = implode(',', Arr::get($_POST, 'attrlist'));//属性
        if (!empty($attrids))
        {
            $attrmode = ORM::factory("spot_attr")->where("id in ($attrids)")->group_by('pid')->get_all();
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
        foreach ($images as $key => $value)
        {
            $desc = isset($imagestitle[$key]) ? $imagestitle[$key] : '';
            $pic = !empty($desc) ? $images[$key] . '||' . $desc : $images[$key];
            $piclist .= $pic . ',';
        }
        $piclist = strlen($piclist) > 0 ? substr($piclist, 0, strlen($piclist) - 1) : '';//图片


        $model->title = Arr::get($_POST, 'title');
        $model->shortname = Arr::get($_POST, 'shortname');
        $model->address = Arr::get($_POST, 'address');
        $model->webid = $webid;

        $model->shownum = Arr::get($_POST, 'shownum') ? Arr::get($_POST, 'shownum') : 0;

        $model->author = Arr::get($_POST, 'author');//编辑人
        $model->ishidden = Arr::get($_POST, 'ishidden') ? Arr::get($_POST, 'ishidden') : 0;//显示隐藏
        $model->getway = Arr::get($_POST, 'getway');//取票方式
        $model->sellpoint = Arr::get($_POST, 'sellpoint');

        $model->attrid = $attrids;//属性
        $model->lng = Arr::get($_POST, 'lng') ? Arr::get($_POST, 'lng') : 0;
        $model->lat = Arr::get($_POST, 'lat') ? Arr::get($_POST, 'lat') : 0;

        $model->iconlist = implode(',', Arr::get($_POST, 'iconlist'));//图标


        $model->satisfyscore = Arr::get($_POST, 'satisfyscore') ? Arr::get($_POST, 'satisfyscore') : 0;//满意度
        $model->bookcount = Arr::get($_POST, 'bookcount') ? Arr::get($_POST, 'bookcount') : 0;//销量
        $model->piclist = $piclist;
        $link = new Model_Tool_Link();
        $model->content = $link->keywordReplaceBody(Arr::get($_POST, 'content'), 5);
        //$model->content = Arr::get($_POST,'content');//景点介绍
        $model->isspotarea = 0;
        $model->booknotice = Arr::get($_POST, 'booknotice');
        $model->recommendnum = $_POST['recommendnum'];
        $model->seotitle = Arr::get($_POST, 'seotitle');//优化标题
        $model->tagword = Arr::get($_POST, 'tagword');
        $model->keyword = Arr::get($_POST, 'keyword');
        $model->description = Arr::get($_POST, 'description');
        $model->kindlist = implode(',', Model_Destinations::getParentsStr(implode(',', $kindlist)));//所属目的地
        $model->finaldestid = empty($_POST['finaldestid']) ? Model_Destinations::getFinaldestId(explode(',', $model->kindlist)) : $_POST['finaldestid'];
        $model->attrid = implode(',', Arr::get($_POST, 'attrlist'));//属性
        $model->iconlist = implode(',', Arr::get($_POST, 'iconlist'));//图标
        $model->supplierlist = implode(',', Arr::get($_POST, 'supplierlist'));
        $model->modtime = time();
        $model->jifenbook_id = empty($_POST['jifenbook_id'])?0:$_POST['jifenbook_id'];
        $model->jifentprice_id =empty($_POST['jifentprice_id'])?0:$_POST['jifentprice_id'];
        $model->open_time_des = $_POST['open_time_des'];

        $model->templet = $_POST['templet'];
        $model->wap_templet = $_POST['wap_templet'];

        $model->litpic = $litpic;

        /*$columnlist = $model->table_columns();
        foreach($columnlist as $key=>$v)
        {
            if($v['type']=='int' && $key!='id')
            {
                $model->$key = empty($model->$key) ? 0 : $model->$key;
            }

        }*/

        if ($action == 'add' && empty($id))
        {
            $model->create();
        }
        else
        {
            $model->update();
        }


        if ($model->saved())
        {
            if ($action == 'add')
            {

                $productid = $model->id; //插入的产品id

            }
            else
            {
                $productid = $model->id;
            }
            Common::saveExtendData(5, $model->id, $_POST);//扩展信息保存

            $status = true;
        }
        echo json_encode(array('status' => $status, 'productid' => $productid));


    }

    /*
 * 门票价格范围操作
 * */
    public function action_price()
    {
        $action = $this->params['action'];
        $this->assign('chooseid','attr_price');
        if (empty($action))
        {
            $list = ORM::factory('spot_pricelist')->where('webid', '=', '0')->order_by('min', 'asc')->get_all();
            $this->assign('list', $list);
            $this->display('admin/spot/price');
        }


    }

    /*
    * 门票价格ajax操作
    * */
    public function action_ajax_price()
    {
        $action = $this->params['action'];

        //动态保存
        if ($action == 'save')
        {
            $max = Arr::get($_POST, 'max');
            $min = Arr::get($_POST, 'min');
            $id = Arr::get($_POST, 'id');
            $newmin = Arr::get($_POST, 'newmin');
            $newmax = Arr::get($_POST, 'newmax');


            //保存原来的
            for ($i = 0; isset($id[$i]); $i++)
            {
                $obj = ORM::factory('spot_pricelist')->where('id', '=', $id[$i])->find();
                if (!empty($min[$i])) $obj->min = $min[$i];
                if (!empty($max[$i])) $obj->max = $max[$i];
                $obj->update();
                $obj->clear();
            }
            //添加新的
            for ($i = 0; isset($newmin[$i]); $i++)
            {
                $obj = ORM::factory('spot_pricelist');
                if (!empty($newmin[$i])) $obj->min = $newmin[$i];
                if (!empty($newmax[$i])) $obj->max = $newmax[$i];
                $obj->webid = 0;
                $obj->create();
                $obj->clear();
            }

            echo json_encode(array('status' => true));

        }
        //动态删除
        if ($action == 'del')
        {
            $id = Arr::get($_POST, 'id');
            $model = ORM::factory('spot_pricelist', $id);
            $model->delete();
            $out = array();
            if (!$model->loaded())
            {
                $out['status'] = true;
            }
            else
            {
                $out['status'] = false;
            }
            echo json_encode($out);
        }


    }


    /*
    * 门票列表管理
    * */
    public function action_ticket()
    {

        $action = $this->params['action'];
        $spotid = $this->params['spotid'];
        $this->assign('spotid', $spotid);
        $this->assign('tickettypelist', json_encode(ORM::factory('spot_ticket_type')->where('spotid', '=', $spotid)->order_by('displayorder', 'asc')->get_all()));
        if (empty($action))  //显示线路列表页
        {
            $info = ORM::factory('spot', $spotid)->as_array();
            $position = $info['title'];
            $this->assign('position', $position);
            $this->display('admin/spot/ticket_list');
        }
        else if ($action == 'read')    //读取列表
        {
            $start = Arr::get($_GET, 'start');
            $limit = Arr::get($_GET, 'limit');

            /*$list = ORM::factory('hotel_room')
                       ->where('hotelid','=',$hotelid)
                       ->order_by('displayorder','asc')
                       ->offset($start)
                       ->limit($limit)
                       ->as_array();*/
            $sql = "select a.* from sline_spot_ticket a where a.spotid='$spotid' order by a.displayorder asc limit $start,$limit";
            $totalcount_arr = DB::query(Database::SELECT, "select count(*) as num from sline_spot_ticket a where spotid='$spotid'")->execute()->as_array();
            $list = DB::query(Database::SELECT, $sql)->execute()->as_array();
            $new_list = array();
            foreach ($list as $k => $v)
            {
                $new_list[] = $v;
            }
            $result['total'] = $totalcount_arr[0]['num'];
            $result['lists'] = $new_list;
            $result['success'] = true;

            echo json_encode($result);
        }
        else if ($action == 'save')   //保存字段
        {
            $rawdata = file_get_contents('php://input');
            $field = Arr::get($_GET, 'field');
            $data = json_decode($rawdata);
            $id = $data->id;
            if ($field)
            {
                $value_arr = array();
                $value_arr[$field] = $data->$field;
                $updated = DB::update('spot_ticket')->set($value_arr)->where('id', '=', $id)->execute();
                if ($updated)
                    echo 'ok';
                else
                    echo 'no';

            }

        }
        else if ($action == 'delete') //删除某个记录
        {
            $rawdata = file_get_contents('php://input');
            $data = json_decode($rawdata);
            $id = $data->id;
            // $id = Arr::get($_GET,'id');

            if (is_numeric($id)) //
            {
                $model = ORM::factory('spot_ticket', $id);
                $model->delete();

            }
        }
        else if ($action == 'update') //更新单个字段.
        {
            $id = Arr::get($_POST, 'id');
            $field = Arr::get($_POST, 'field');
            $val = Arr::get($_POST, 'val');
            $model = ORM::factory('spot_ticket', $id);
            if ($model->id)
            {
                $model->$field = $val;
                $model->save();
                if ($model->saved())
                    echo 'ok';
                else
                    echo 'no';
            }
        }
    }

    /*
    * 门票添加/修改
    * */
    public function action_ticket_op()
    {
        $action = $this->params['action'];
        $spotid = $this->params['spotid'];
        $this->assign('spotid', $spotid);
        $spotinfo = ORM::factory('spot', $spotid)->as_array();
        $this->assign('spotname', $spotinfo['title']);
        $this->assign('tickettypelist', ORM::factory('spot_ticket_type')->where('spotid', '=', $spotid)->order_by('displayorder','asc')->get_all());//门票类型
        if ($action == 'add')
        {
            $info = array('lastoffer' => array('pricerule' => 'all','number'=>'-1'));
            $this->assign('info', $info);
            $this->assign('position', '添加门票');
            $this->assign('action', 'add');
        }
        else if ($action == 'edit')
        {
            $ticketid = $this->params['ticketid'];
            $info = ORM::factory('spot_ticket', $ticketid)->as_array();
            $info['piclist_arr'] = json_encode(Common::getUploadPicture($info['piclist']));//图片数组
            $info['lastoffer'] = unserialize($info['lastoffer']);
            $info['supplier_arr'] = ORM::factory('supplier', $info['supplierlist'])->as_array();
            $info['fill_tourer_items_arr'] = explode(',',$info['fill_tourer_items']);
            $hour = $info['hour_before']<10?'0'.$info['hour_before']:$info['hour_before'];
            $minute = $info['minute_before']<10?'0'.$info['minute_before']:$info['minute_before'];
            $info['time_before'] = $hour.':'.$minute;

            if (empty($info['lastoffer']))
            {
                $info['lastoffer'] = array('pricerule' => 'all','number'=>'-1');
            }
            $info['auto_close_time_hour'] = floor($info['auto_close_time'] / 3600);; 
            $info['auto_close_time_minute'] = floor(($info['auto_close_time'] - ($info['auto_close_time_hour'] * 3600)) / 60);
            $this->assign('info', $info);
            $this->assign('position', '修改门票');
            $this->assign('action', 'edit');
        }
        $this->display('admin/spot/ticket_edit');
    }

    /*
     * 门票保存
     * */
    public function action_ajax_ticket_save()
    {
        $action = Arr::get($_POST, 'action');
        $spotid = Arr::get($_POST, 'spotid');
        $images = Arr::get($_POST, 'images');
        $imagestitle = Arr::get($_POST, 'imagestitle');
        $ticketid = Arr::get($_POST, 'ticketid');
        $suitid = $ticketid;


        //添加保存
        if ($action == 'add' && empty($ticketid))
        {
            $model = ORM::factory('spot_ticket');
            $model->status = 3;
        }
        else //修改保存
        {
            $model = ORM::factory('spot_ticket', $ticketid);
        }

        $tickettypeid = $_POST['tickettypeid'];
        $newtickettype = $_POST['newtickettype'];
        if(!empty($newtickettype))
        {
            $newtickettypeid = Model_Spot::add_suittype($newtickettype,$spotid);
            $tickettypeid = !empty($newtickettypeid)?$newtickettypeid:$tickettypeid;
        }

        $model->title = Arr::get($_POST, 'title');
        $model->tickettypeid = $tickettypeid;
        $model->sellprice = Arr::get($_POST, 'sellprice') ? Arr::get($_POST, 'sellprice') : 0;
        $model->ourprice = Arr::get($_POST, 'ourprice') ? Arr::get($_POST, 'ourprice') : 0;
        $model->jifencomment = Arr::get($_POST, 'jifencomment') ? Arr::get($_POST, 'jifencomment') : 0;
        $model->jifentprice = Arr::get($_POST, 'jifentprice') ? Arr::get($_POST, 'jifentprice') : 0;
        $model->jifenbook = Arr::get($_POST, 'jifenbook') ? Arr::get($_POST, 'jifenbook') : 0;
        $model->number = Arr::get($_POST, 'ticketnum') ? Arr::get($_POST, 'ticketnum') : 0;
        $model->dingjin = Arr::get($_POST, 'dingjin') ? Arr::get($_POST, 'dingjin') : 0;
        $model->paytype = Arr::get($_POST, 'paytype') ? Arr::get($_POST, 'paytype') : 1;
        $model->day_before = $_POST['day_before'];
        //预订确认方式
        $model->need_confirm = Arr::get($_POST, 'need_confirm') ? Arr::get($_POST, 'need_confirm') : 0;
        //会员支付方式
        $model->pay_way = array_sum(Arr::get($_POST, 'pay_way'));
        //待付款时限,默认不限制(分钟小时制)
        $auto_close_time_minute = Arr::get($_POST, 'auto_close_time_minute') ? Arr::get($_POST, 'auto_close_time_minute') : 0;
        $auto_close_time_hour = Arr::get($_POST, 'auto_close_time_hour') ? Arr::get($_POST, 'auto_close_time_hour') : 0;
        $model->auto_close_time = $auto_close_time_hour * 3600 + $auto_close_time_minute * 60;

        $model->get_ticket_way = $_POST['get_ticket_way'];
        $model->effective_days = intval($_POST['effective_days']);
        $model->refund_restriction = intval($_POST['refund_restriction']);
        $model->supplierlist = implode(',', Arr::get($_POST, 'supplierlist'));
        $model->fill_tourer_type = intval($_POST['fill_tourer_type']);
        $model->fill_tourer_items = implode(',',$_POST['fill_tourer_items']);

        if ($model->paytype != 2)
        {
            $model->dingjin = 0;
        }

        if($model->paytype==2)
        {
            $model->pay_way=1;
        }


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
        if ($model->paytype != 2)
        {
            $model->dingjin = 0;
        }
        $model->description = Arr::get($_POST, 'descriptionspot') ? Arr::get($_POST, 'descriptionspot') : '';
        $model->lastoffer = $this->get_last_offer($_POST);


        $model->spotid = $spotid;

        if ($action == 'add' && empty($ticketid))
        {
            $model->create();
        }
        else
        {
            $model->update();
        }
        if ($model->saved())
        {
            if ($action == 'add')
            {
                $ticketid = $model->id; //插入的产品id
                $suitid = $ticketid;
            }
            else
            {
                $roomid = null;
            }

            $status = true;
        }
        $this->saveBaoJia($spotid, $ticketid,$_POST);
        echo json_encode(array('status' => $status, 'ticketid' => $ticketid));

    }

    public function get_last_offer($data)
    {
        $lastOffer = array();

        $lastOffer = array(
            'pricerule' => $data['pricerule'],
            'adultbasicprice' => $data['adultbasicprice'],
            'adultprofit' => $data['adultprofit'],
            'adultprice' => $data['adultbasicprice'] + $data['adultprofit'],
            'adultmarketprice' => $data['adultmarketprice'],
            'adultdistributionprice' => $data['adultdistributionprice'],
            'starttime' => $data['starttime'],
            'endtime' => $data['endtime'],
            'number' => $data['number'],
            'description'=>$data['description']
        );
        return serialize($lastOffer);
    }

    public function saveBaoJia($spotid, $ticketid,$arr)
    {
        //$pricerule,$starttime,$endtime,$hotelid,$roomid,$basicprice,$profit,$description
        $pricerule = Arr::get($arr, 'pricerule');
        $starttime = Arr::get($arr, 'starttime');
        $endtime = Arr::get($arr, 'endtime');
        $basicprice = Arr::get($arr, 'adultbasicprice') ? Arr::get($arr, 'adultbasicprice') : 0;
        $profit = Arr::get($arr, 'adultprofit') ? Arr::get($arr, 'adultprofit') : 0;
        $description = Arr::get($arr, 'description');
        $adultmarketprice = $arr['adultmarketprice'];
        $adultdistributionprice = $arr['adultdistributionprice'];
        $monthval = Arr::get($arr, 'monthval');
        $weekval = Arr::get($arr, 'weekval');
        $number = Arr::get($arr, 'number');
        if (empty($starttime) || empty($endtime))
            return false;
        $stime = strtotime($starttime);
        $etime = strtotime($endtime);
        $price = $basicprice + $profit;
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
                $data_arr['adultdistributionprice'] = $adultdistributionprice;
                $data_arr['adultmarketprice'] = $adultmarketprice;
                $data_arr['day'] = $begintime;
                $data_arr['number'] = $number;
                if (empty($price))
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
                    $data_arr['adultdistributionprice'] = $adultdistributionprice;
                    $data_arr['adultmarketprice'] = $adultmarketprice;
                    $data_arr['day'] = $newtime;
                    $data_arr['number'] = $number;
                    if (empty($price))
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
                    $data_arr['adultdistributionprice'] = $adultdistributionprice;
                    $data_arr['adultmarketprice'] = $adultmarketprice;
                    $data_arr['day'] = $begintime;
                    $data_arr['number'] = $number;
                    if (empty($price))
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
        Model_Spot::update_min_price_spot_ticket($spotid,$ticketid);
    }

    /*
     * 门票类型管理
     * */

    public function action_tickettype()
    {

        $action = $this->params['action'];
        if (empty($action))
        {
            $spotid = $this->params['spotid'];
            $list = ORM::factory('spot_ticket_type')->where('spotid','=',$spotid)->get_all();
            $this->assign('list', $list);
            $this->assign('spotid', $spotid);
            $this->display('admin/spot/suittype');
        }
        else if ($action == 'save')
        {
            $spotid = Arr::get($_POST, 'spotid');
            $kindname_arr = Arr::get($_POST, 'kindname');
            $displayorder_arr = Arr::get($_POST, 'displayorder');

            foreach ($kindname_arr as $k => $v)
            {
                $model = ORM::factory('spot_ticket_type', $k);
                if ($model->id)
                {
                    $model->kindname = $v;
                    $model->spotid = $spotid;
                    $model->displayorder = $displayorder_arr[$k] ? $displayorder_arr[$k] : 9999;
                    $model->save();
                }
            }
            echo 'ok';
        }
        else if ($action == 'del')
        {
            $id = Arr::get($_POST, 'id');
            $model = ORM::factory('spot_ticket_type', $id);
            $model->delete();
            echo 'ok';
        }
        else if ($action == 'add')
        {
            $spotid = $_POST['spotid'];
            $model = ORM::factory('spot_ticket_type');
            $model->spotid = $spotid;
            $model->save();
            $model->reload();
            echo $model->id;
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

        $this->display('admin/spot/sms');
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
        $this->display('admin/spot/email');
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
            $spotcontent = ORM::factory('spot_content')->where('webid=0 and columnname!="tupian"')->order_by('displayorder')->get_all();
            $this->assign('list', $spotcontent);
            $this->display('admin/spot/content');
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
                $model = ORM::factory('spot_content', $k);
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
            Model_Spot_Content::update_extend_field_name();
            echo 'ok';
        }
    }
    //添加内容项
    public function action_ajax_content_add()
    {
        $extend_table = 'sline_spot_extend_field';

        $lastIndex = Common::getExtendContentIndex($extend_table);
        $fieldName = 'e_' . 'content_' . $lastIndex;
        $result = Common::addField($extend_table, 'content_' . $lastIndex, 'mediumtext', 0, '自定义' . $lastIndex);
        if ($result)
        {
            $data = Model_Spot_Content::add_content_field($fieldName, '自定义' . $lastIndex);
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
        $model = ORM::factory('spot_content', $id);
        $columnName = $model->columnname;
        $model->delete();
        DB::query(Database::DELETE, "alter table `sline_spot_extend_field` drop column $columnName")->execute();
        $extendModel = ORM::factory('extend_field')->where('typeid', '=', $this->_typeid)->and_where('fieldname', '=', $columnName)->find();
        $extendModel->delete();
        echo json_encode(array('status'=>true));
    }
    private function  get_ticket_min_price($ticketid)
    {
        $curtime = time();
        $sql = "select a.ticketid,min(adultprice) as price from sline_spot_ticket_price a left join sline_spot_ticket b on a.ticketid=b.id   where a.ticketid='{$ticketid}'  and a.day>({$curtime}+b.day_before*24*3600-3600*b.hour_before-b.minute_before*60) group by a.ticketid order by price";
        return DB::query(Database::SELECT,$sql)->execute()->get('price');

    }

    /**
     * @function 添加报价
     */
    public function action_dialog_add_suit_price()
    {
        $spotid = $_GET['spotid'];
        $ticketid = $_GET['ticketid'];

        $this->assign('spotid', $spotid);
        $this->assign('ticketid', $ticketid);
        $this->display('admin/spot/dialog_add_suit_price');
    }


    //保存套餐价格
    public function action_ajax_save_suit_price()
    {
       $ticketid = $_POST['ticketid'];
       $spotid = $_POST['spotid'];
       $_POST['number'] = $_POST['store']==1?'-1':$_POST['number'];
       $this->saveBaoJia($spotid,$ticketid,$_POST);
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
        $back_symbol = Currency_Tool::back_symbol();
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

    /**
     * @function 修改报价弹窗
     */
    public function action_dialog_edit_suit_price()
    {
        $ticketid = $_GET['ticketid'];
        $spotid = $_GET['spotid'];
        $date_time = strtotime($_GET['date']);
        $ar = DB::select()->from('spot_ticket_price')->where('ticketid','=',$ticketid)->and_where('day','=',$date_time)->execute()->current();
        $this->assign('ticketid', $ticketid);
        $this->assign('spotid', $spotid);
        $this->assign('date', $_GET['date']);
        $this->assign('info', $ar);
        $this->display('admin/spot/dialog_edit_suit_price');
    }

    public function action_ajax_save_day_price()
    {
        $info = array();
        $info['adultbasicprice'] = doubleval($_POST['adultbasicprice']);
        $info['adultprofit'] = doubleval($_POST['adultprofit']);
        $info['adultprice'] =  $info['adultbasicprice']+$info['adultprofit'];
        $info['adultdistributionprice'] = $_POST['adultdistributionprice'];
        $store = $_POST['store'];
        $number = intval($_POST['number']);
        $info['number'] = $store=='1'?'-1':$number;
        $info['ticketid'] = $_POST['ticketid'];
        $info['spotid'] = $_POST['spotid'];
        $date = $_POST['date'];
        $info['day'] = strtotime($_POST['date']);

        if($info['adultprice']==0)
        {
            DB::delete('spot_ticket_price')->where('ticketid','=',$info['ticketid'])->and_where('day','=',$info['day'])->execute();
            $info['is_clear'] = 1;
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
        }
        $info['date'] = $date;
        Model_Spot::update_min_price_spot_ticket($info['spotid'],$info['ticketid']);
        echo json_encode($info);
    }

    /**
     * @function 供应商审核
     */
    public function action_dialog_supplier_check()
    {
        $action = $_GET['action'];
        $suitid = $_GET['suitid'];
        if (!$action)
        {
            $this->assign('suitid', $suitid);
            $this->display('admin/spot/dialog_supplier_check');
        }
        if ($action == 'save')
        {
            $data = array(
                'status' => $_GET['status'],
                'refuse_msg' => $_GET['refuse_msg'],
                'modtime' => time(),
            );
            DB::update('spot_ticket')->set($data)->where('id', '=', $suitid)->execute();
            echo 'ok';
        }
    }

    //预订须知
    public function action_agreement()
    {
        $fields = array('cfg_spot_order_agreement_open', 'cfg_spot_order_agreement','cfg_spot_order_agreement_selected');
        $config = Model_Sysconfig::get_configs(0, $fields);
        $this->assign('config', $config);
        $this->display('admin/spot/agreement');
    }

    public function action_ajax_clear_all_price()
    {
        $ticketid = $_POST['ticketid'];
        DB::delete('spot_ticket_price')->where('ticketid', '=', $ticketid)->execute();
    }


    /**
     * @function 异步获取模板列表
     */
    public function action_ajax_get_template_list()
    {
        $page = $_POST['page'];
        $webid = $_POST['webid'];
        if($webid)
        {
            $pclist = Model_Templet::get_templet_list_by_page('sub_site', $page, $webid );
        }
        else
        {
            $pclist = Model_Templet::get_templet_list_by_page('pc', $page, $webid );
        }
        $waplist = Model_Templet::get_templet_list_by_page('wap', $page, 0 );
        echo json_encode(array('pclist'=> array_reverse($pclist),'waplist'=> array_reverse($waplist)));
    }

    public function action_ajax_add_tickettype()
    {
        $spotid = intval($_POST['spotid']);
        $name = $_POST['name'];

        if(empty($name) || empty($spotid))
        {
            echo json_encode(array('status'=>false,'msg'=>'错误'));
            return;
        }


        $m = ORM::factory('spot_ticket_type')->where("kindname",'=',$name)->find();
        if($m->loaded())
        {
            echo json_encode(array('status'=>false,'msg'=>'类型名称重复'));
            return;
        }
        else
        {
            $mi = ORM::factory('spot_ticket_type');
            $mi->kindname = $name;
            $mi->spotid = $spotid;
            $mi->save();
            if($mi->saved())
            {
                $mi->reload();
                $id = $mi->id;
                echo json_encode(array('status'=>true,'data'=>$mi->as_array()));
            }
            else
            {
                echo json_encode(array('status'=>false,'msg'=>'保存失败'));
            }
        }
    }




}