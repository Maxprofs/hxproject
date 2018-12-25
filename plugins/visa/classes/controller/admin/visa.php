<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Visa extends Stourweb_Controller
{

    /*
     * 签证总控制器
     * @author:netman
     * @data:2014-07-22
     * */
    private $_typeid = 8;
    public function before()
    {
        parent::before();
        $action = $this->request->action();

        if ($action == 'visa')
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
                Common::getUserRight('visa', $user_action);


        } else if ($action == 'add')
        {
            Common::getUserRight('visa', 'sadd');
        } else if ($action == 'edit')
        {
            Common::getUserRight('visa', 'smodify');
        } else if ($action == 'ajax_save')
        {
            Common::getUserRight('visa', 'smodify');
        } else if ($action == 'ajax_visatype_list')
        {
            Common::getUserRight('visatype', 'slook');
        } else if ($action == 'ajax_visatype_save')
        {
            Common::getUserRight('visatype', 'smodify');
        } else if ($action == 'ajax_visatype_del')
        {
            Common::getUserRight('visatype', 'sdelete');
        } else if ($action == 'ajax_visacity_list')
        {
            Common::getUserRight('visacity', 'slook');
        } else if ($action == 'ajax_visacity_save')
        {
            Common::getUserRight('visacity', 'smodify');
        } else if ($action == 'ajax_visacity_del')
        {
            Common::getUserRight('visacity', 'sdelete');
        } else if ($action == 'ajax_visacity_add')
        {
            Common::getUserRight('visacity', 'sadd');
        } else if ($action == 'visaarea')
        {
            $param = $this->params['action'];

            $right = array(
                'read' => 'slook',
                'addsub' => 'sadd',
                'save' => 'smodify',
                'delete' => 'sdelete',
                'update' => 'smodify'
            );
            $user_action = $right[$param];
            if (!empty($user_action))
                Common::getUserRight('visaarea', $user_action);
        }


        $arealist = ORM::factory('visa_area')->where('pid', '=', 0)->get_all();
        $visatypelist = ORM::factory('visa_kind')->get_all();
        $citylist = ORM::factory('visa_city')->get_all();
        $this->assign('arealist', $arealist);
        $this->assign('visatypelist', $visatypelist);
        $this->assign('citylist', $citylist);
        $this->assign('parentkey', $this->params['parentkey']);
        $this->assign('itemid', $this->params['itemid']);
        $this->assign('weblist', Common::getWebList());
        $this->assign('templetlist', Common::getUserTemplteList('visa_show'));//获取上传的用户模板
    }

    public function action_visa()
    {

        $action = $this->params['action'];
        if (empty($action))  //显示线路列表页
        {
            $this->assign('kindmenu', Common::getConfig('menu_sub.visakind'));//分类设置项
            $this->display('admin/visa/list');
        } else if ($action == 'read')    //读取列表
        {
            $start = Arr::get($_GET, 'start');
            $limit = Arr::get($_GET, 'limit');
            $visatype = Arr::get($_GET, 'visatype');
            $cityid = Arr::get($_GET, 'cityid');
            $keyword = Arr::get($_GET, 'keyword');
            $keyword = Common::getKeyword($keyword);
            //echo $keyword;
            $specOrders = array('attrid', 'kindlist', 'iconlist', 'themelist');
            $sort = json_decode(Arr::get($_GET, 'sort'), true);
            $order = 'order by a.modtime desc';
            if ($sort[0]['property'])
            {
                if ($sort[0]['property'] == 'displayorder')
                    $prefix = '';
                else if ($sort[0]['property'] == 'ishidden')
                {
                    $prefix = 'a.';
                } else if (in_array($sort[0]['property'], $specOrders))
                {
                    $prefix = 'order_';
                }
                $order = 'order by ' . $prefix . $sort[0]['property'] . ' ' . $sort[0]['direction'] . ',a.modtime desc';
            }
            $w = "a.id is not null";
            $w .= empty($keyword) ? '' : " and (a.title like '%{$keyword}%' or a.id like '%{$keyword}%')";
            $w .= empty($visatype) ? '' : " and a.visatype=$visatype";
            $w .= empty($cityid) ? '' : " and a.cityid=$cityid";

            $sql = "select a.*,if(length(ifnull(a.iconlist,''))=0,0,1) as order_iconlist,if(length(ifnull(a.themelist,''))=0,0,1) as order_themelist,ifnull(b.displayorder,9999) as displayorder from sline_visa as a left join sline_allorderlist b on (a.id=b.aid and b.typeid=8)  where $w $order limit $start,$limit";
            //echo $sql;


            $totalcount_arr = DB::query(Database::SELECT, "select count(*) as num from sline_visa a where $w")->execute()->as_array();
            $list = DB::query(Database::SELECT, $sql)->execute()->as_array();
            $new_list = array();
            foreach ($list as $k => $v)
            {

                $v['visakind'] = DB::select('kindname')->from('visa_kind')->where('id','=',$v['visatype'])->execute()->get('kindname');
                $v['visacity'] = DB::select('kindname')->from('visa_city')->where('id','=',$v['cityid'])->execute()->get('kindname');//ORM::factory('visa_city')->where('id', '=', $v['cityid'])->find()->get('kindname');

                $iconname = Model_Icon::getIconName($v['iconlist']);
                $name = '';
                foreach ($iconname as $icon)
                {
                    if (!empty($icon))
                        $name .= '<span style="color:red">[' . $icon . ']</span>';
                }

                $v['iconname'] = $name;

                $v['series'] = St_Product::product_series($v['id'], 8);//编号
                //供应商信息
                $supplier = $supplier = DB::select()->from('supplier')->where('id','=',$v['supplierlist'])->execute()->current();
                $v['suppliername'] = $supplier['suppliername'];
                $v['linkman'] = $supplier['linkman'];
                $v['mobile'] = $supplier['mobile'];
                $v['address'] = $supplier['address'];
                $v['qq'] = $supplier['qq'];
                $new_list[] = $v;
            }
            $result['total'] = $totalcount_arr[0]['num'];
            $result['lists'] = $new_list;
            $result['success'] = true;

            echo json_encode($result);
        } else if ($action == 'save')   //保存字段
        {

        } else if ($action == 'delete') //删除某个记录
        {
            $rawdata = file_get_contents('php://input');
            $data = json_decode($rawdata);
            $id = $data->id;

            if (is_numeric($id)) //
            {
                $model = ORM::factory('visa', $id);
                $model->delete_clear();
            }
        } else if ($action == 'update')//更新某个字段
        {
            $id = Arr::get($_POST, 'id');
            $field = Arr::get($_POST, 'field');
            $val = Arr::get($_POST, 'val');
            $kindid = Arr::get($_POST, 'kindid');


            if ($field == 'displayorder')  //如果是排序
            {
                $displayorder = empty($val) ? 9999 : $val;
                if (is_numeric($id))//
                {

                    $order = ORM::factory('allorderlist');
                    $order_mod = $order->where("aid", '=', $id)
                        ->and_where('typeid', '=', '8')
                        ->and_where('webid', '=', '0')
                        ->find();

                    if ($order_mod->id)  //如果已经存在
                    {
                        $order_mod->displayorder = $displayorder;
                    } else   //如果这个排序不存在
                    {
                        $order_mod->displayorder = $displayorder;
                        $order_mod->aid = $id;
                        $order_mod->webid = 0;
                        $order_mod->typeid = 8;
                    }
                    $order_mod->save();
                    if ($order_mod->saved())
                    {
                        echo 'ok';
                    } else
                        echo 'no';


                }

            } else  //如果不是排序字段
            {

                $value_arr[$field]=$val;
                $updated=DB::update('visa')->set($value_arr)->where('id','=',$id)->execute();
                if ($updated)
                    echo 'ok';
                else
                    echo 'no';
            }
        }
    }

    /*
     * 添加签证页面
     * */
    public function action_add()
    {
        $materials = Model_Visa_Material::get_list(1);

        $this->assign('webid', 0);
        $this->assign('position', '添加签证');
        $this->assign('action', 'add');
        $columns = ORM::factory('visa_content')->where("(webid=0 and isopen=1) or columnname='tupian'")->order_by('displayorder', 'asc')->get_all();
        $this->assign('columns', $columns);
        $this->assign('materials', $materials);

        $this->display('admin/visa/edit');
    }

    /*
    * 修改签证
    * */
    public function action_edit()
    {
        $productid = $this->params['id'];
        $this->assign('action', 'edit');
        $info = ORM::factory('visa', $productid)->as_array();
        $info['attachment']=unserialize($info['attachment']);
        $nationlist = ORM::factory('visa_area')->where("pid='{$info['areaid']}'")->get_all();

        $info['iconlist_arr'] = Common::getSelectedIcon($info['iconlist']);//图标数组
        $info['supplier_arr'] = ORM::factory('supplier', $info['supplierlist'])->as_array();

        $info['jifenbook_info'] = DB::select()->from('jifen')->where('id','=',$info['jifenbook_id'])->execute()->current();
        $info['jifentprice_info'] = DB::select()->from('jifen_price')->where('id','=',$info['jifentprice_id'])->execute()->current();

        $extendinfo = Common::getExtendInfo(8, $info['id']);

        $columns = ORM::factory('visa_content')->where("(webid=0 and isopen=1) or columnname='tupian'")->order_by('displayorder', 'asc')->get_all();
        $materials = Model_Visa_Material::get_list(1);
        foreach ($materials as &$ma)
        {
            $ma['content'] = Model_Visa_Material_Content::get_content($productid, $ma['pinyin']);
        }
        $this->assign('columns', $columns);
        $this->assign('extendinfo', $extendinfo);//扩展信息
        $this->assign('info', $info);
        $this->assign('nationlist', $nationlist);
        $this->assign('position', '修改签证' . $info['title']);
        $this->assign('materials', $materials);

        $this->display('admin/visa/edit');
    }

    /*
     * 保存(ajax)
     * */
    public function action_ajax_save()
    {
        $action = Arr::get($_POST, 'action');//当前操作

        $id = Arr::get($_POST, 'productid');

        $status = false;


        //添加操作
        if ($action == 'add' && empty($id))
        {
            $model = ORM::factory('visa');
            $model->aid = Common::getLastAid('sline_visa', 0);
            $model->addtime = time();
        } else
        {
            $model = ORM::factory('visa', $id);
        }
        $model->title = Arr::get($_POST, 'title');
        $model->webid = 0;
        $model->keyword = Arr::get($_POST, 'keyword');
        $model->seotitle = Arr::get($_POST, 'seotitle');
        $model->description = Arr::get($_POST, 'description');
        $model->tagword = Arr::get($_POST, 'tagword');
        $model->sellpoint = Arr::get($_POST, 'sellpoint') ? Arr::get($_POST, 'sellpoint') : '';
        $model->visatype = Arr::get($_POST, 'visatype') ? Arr::get($_POST, 'visatype') : 0;
        $model->litpic = Arr::get($_POST, 'litpic');//封面图
        $model->feeinclude = Arr::get($_POST, 'feeinclude');
        $model->handleday = Arr::get($_POST, 'handleday');
        $model->validday = Arr::get($_POST, 'validday');
        $model->needinterview = Arr::get($_POST, 'needinterview');//
        $model->needletter = Arr::get($_POST, 'needletter');//优化标题
        $model->price = Arr::get($_POST, 'price');
        $model->marketprice = Arr::get($_POST, 'marketprice');
        $model->handlerange = Arr::get($_POST, 'handlerange');
        $model->areaid = Arr::get($_POST, 'areaid') ? Arr::get($_POST, 'areaid') : 0;
        $model->cityid = Arr::get($_POST, 'cityid') ? Arr::get($_POST, 'cityid') : 0;
        $model->nationid = Arr::get($_POST, 'nationid');
        $link = new Model_Tool_Link();
        $model->content = $link->keywordReplaceBody(Arr::get($_POST, 'content'), 8);
        //$model->content = Arr::get($_POST,'content');
        $model->shownum = Arr::get($_POST, 'shownum') ? Arr::get($_POST, 'shownum') : 0;//优化标题
        $model->partday = Arr::get($_POST, 'partday');
        $model->acceptday = Arr::get($_POST, 'acceptday');
        $model->handlepeople = Arr::get($_POST, 'handlepeople');
        $model->belongconsulate = Arr::get($_POST, 'belongconsulate');//优化标题
        $model->booknotice = Arr::get($_POST, 'booknotice');
        $model->circuit = Arr::get($_POST, 'circuit');
        $model->friendtip = Arr::get($_POST, 'friendtip');
        $model->paytype = Arr::get($_POST, 'paytype') ? Arr::get($_POST, 'paytype') : 1;
        $model->dingjin = Arr::get($_POST, 'dingjin');
        $model->jifenbook_id = empty($_POST['jifenbook_id'])?0:$_POST['jifenbook_id'];
        $model->jifentprice_id =empty($_POST['jifentprice_id'])?0:$_POST['jifentprice_id'];
        if($model->paytype!=2){
            $model->dingjin=0;
        }
        $model->ishidden = Arr::get($_POST, 'ishidden') ? Arr::get($_POST, 'ishidden') : 0;//显示隐藏

        $model->jifentprice = Arr::get($_POST, 'jifentprice') ? Arr::get($_POST, 'jifentprice') : 0;
        $model->jifenbook = Arr::get($_POST, 'jifenbook') ? Arr::get($_POST, 'jifenbook') : 0;
        $model->jifencomment = Arr::get($_POST, 'jifencomment') ? Arr::get($_POST, 'jifencomment') : 0;

        $model->iconlist = implode(',', Arr::get($_POST, 'iconlist'));//图标
        $model->supplierlist = implode(',', Arr::get($_POST, 'supplierlist'));

        $model->satisfyscore = Arr::get($_POST, 'satisfyscore') ? Arr::get($_POST, 'satisfyscore') : 0;//满意度
        $model->bookcount = Arr::get($_POST, 'bookcount') ? Arr::get($_POST, 'bookcount') : 0;//销量
        $model->litpic = Arr::get($_POST, 'litpic');
        $model->templet = Arr::get($_POST, 'templet');
        $model->recommendnum = $_POST['recommendnum'];
        $model->attachment = serialize($_POST['attachment']);
        $model->modtime = time();

        if ($action == 'add' && empty($id))
        {

            $model->create();
        } else
        {
            $model->update();
        }


        if ($model->saved())
        {
            if ($action == 'add')
            {
                $productid = $model->id; //插入的产品id

            } else
            {
                $productid = null;
            }
            Common::saveExtendData(8, $model->id, $_POST);//扩展信息保存
            Model_Visa_Material_Content::save_content($model->id,$_POST);
            $status = true;
        }
        echo json_encode(array('status' => $status, 'productid' => $productid));


    }

    /*
     * 获取国家
     * */
    public function action_ajax_getnation()
    {

        $pid = Arr::get($_POST, 'pid');
        $arr = ORM::factory('visa_area')->where('pid', '=', $pid)->and_where('isopen', '=', 1)->get_all();
        echo json_encode($arr);

    }

    /*
     * 签证类型管理
     * */
    public function action_visatype()
    {
        $this->display('admin/visa/type_list');
    }

    /*
     * 签证类型表
     * */
    public function action_ajax_visatype_list()
    {
        $out = self::commonGetList('visa_kind');
        echo json_encode(array('trlist' => $out));
    }

    /*
     * 签证类型动态保存
     * */
    public function action_ajax_visatype_save()
    {

        self::commonSave('visa_kind', $_POST);//调用公共方法进行保存

        echo json_encode(array('status' => true));

    }

    /*
     * 签证类型删除
     * */
    public function action_ajax_visatype_del()
    {
        $navid = Arr::get($_GET, 'id');

        $out = self::commonDel('visa_kind', $navid);

        echo json_encode($out);

    }

    /*
  * 签发城市管理
  * */
    public function action_visacity()
    {
        $this->display('admin/visa/city_list');
    }

    /*
     * 签发城市表
     * */
    public function action_ajax_visacity_list()
    {
        $out = self::commonGetList('visa_city');
        echo json_encode(array('trlist' => $out));
    }

    /*
     * 签发城市动态保存
     * */
    public function action_ajax_visacity_save()
    {

        self::commonSave('visa_city', $_POST);//调用公共方法进行保存

        echo json_encode(array('status' => true));

    }

    /*
     * 签发城市删除
     * */
    public function action_ajax_visacity_del()
    {
        $navid = Arr::get($_GET, 'id');

        $out = self::commonDel('visa_city', $navid);

        echo json_encode($out);

    }

    /*
     * 签发城市添加
     * */
    public function action_ajax_visacity_add()
    {
        $status = 0;
        $id = 0;
        $model = new Model_Visa_City();
        $model->kindname = '自定义';
        $model->displayorder = 9999;
        $model->save();
        if ($model->saved())
        {
            $id = $model->id;
            $status = 1;

        }
        echo json_encode(array('status' => $status, 'id' => $id));

    }

    /*
     * 签证区域管理
     * */


    public function action_visaarea()
    {


        $action = $this->params['action'];

        $attrtable = 'visa_area';//当前操作表

        if (empty($action))
        {
            $this->display('admin/visa/area_list');
        }
        else if ($action == 'read')
        {


            $node = Arr::get($_GET, 'node');
            $list = array();
            if ($node == 'root')//属性组根
            {
                $list = ORM::factory($attrtable)->where('pid', '=', '0')->get_all();
                foreach ($list as $k => $v)
                {

                    $list[$k]['allowDrag'] = false;
                }
                $list[] = array(
                    'leaf' => true,
                    'id' => '0add',
                    'kindname' => '<button class="btn btn-primary radius size-S" onclick="addSub(0)">添加</button>',
                    'allowDrag' => false,
                    'allowDrop' => false,
                    'displayorder' => 'add'
                );
            }
            else //子级
            {
                $list = ORM::factory($attrtable)->where('pid', '=', $node)->get_all();
                foreach ($list as $k => $v)
                {
                    $list[$k]['leaf'] = true;
                }
                $list[] = array(
                    'leaf' => true,
                    'id' => $node . 'add',
                    'kindname' => '<button class="btn btn-primary radius size-S" onclick="addSub(\'' . $node . '\')">添加</button>',
                    'allowDrag' => false,
                    'allowDrop' => false,
                    'displayorder' => 'add'
                );
            }
            echo json_encode(array('success' => true, 'text' => '', 'children' => $list));
        }
        else if ($action == 'addsub')//添加子级
        {
            $pid = Arr::get($_POST, 'pid');

            $model = ORM::factory($attrtable);
            $model->pid = $pid;
            $model->kindname = "自定义";
            $model->save();

            if ($model->saved())
            {
                $model->reload();
                echo json_encode($model->as_array());
            }
        }
        else if ($action == 'save') //保存修改
        {
            $rawdata = file_get_contents('php://input');
            $field = Arr::get($_GET, 'field');
            $data = json_decode($rawdata);
            $id = $data->id;
            if ($field)
            {
                $model = ORM::factory($attrtable, $id);
                if ($model->id)
                {
                    if(empty($model->pinyin))
                    {
                        $tmp_pinyin = Common::getPinYin($data->$field);
                        for ($i = 0; $i <= 100; $i++)
                        {
                            if ($i > 0)
                            {
                                $model->pinyin = $tmp_pinyin . $i;
                            }
                            else
                            {
                                $model->pinyin = $tmp_pinyin;
                            }
                            $dest_chk_model = ORM::factory($attrtable)->where("pinyin='{$model->pinyin}' and id!={$model->id}")->find();
                            if (!$dest_chk_model->loaded()) //检测拼音是否重复
                                break;
                        }
                    }
                    $model->$field = $data->$field;
                    $model->save();
                    if ($model->saved())
                        echo 'ok';
                    else
                        echo 'no';
                }
            }

        } else if ($action == 'drag') //拖动
        {
            $moveid = Arr::get($_POST, 'moveid');
            $overid = Arr::get($_POST, 'overid');
            $position = Arr::get($_POST, 'position');
            $movemodel = ORM::factory($attrtable, $moveid);
            $overmodel = ORM::factory($attrtable, $overid);
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
                echo 'ok';
            else
                echo 'no';


        } else if ($action == 'delete')//属性删除
        {
            $rawdata = file_get_contents('php://input');
            $data = json_decode($rawdata);
            $id = $data->id;
            if (!is_numeric($id))
            {
                echo json_encode(array('success' => false));
                exit;
            }
            $model = ORM::factory($attrtable, $id);
            $model->delete();

        } else if ($action == 'update')//更新操作
        {
            $id = Arr::get($_POST, 'id');
            $field = Arr::get($_POST, 'field');
            $val = Arr::get($_POST, 'val');
            if($field=='displayorder' && $val==''){
                $val=9999;
            }
            $model = ORM::factory($attrtable, $id);
            if ($model->id)
            {
                if(empty($model->pinyin))
                {
                    $tmp_pinyin = Common::getPinYin($val);
                    for ($i = 0; $i <= 100; $i++)
                    {
                        if ($i > 0)
                        {
                            $model->pinyin = $tmp_pinyin . $i;
                        }
                        $dest_chk_model = ORM::factory($attrtable)->where("pinyin='{$model->pinyin}' and id!={$model->id}")->find();
                        if (!$dest_chk_model->loaded()) //检测拼音是否重复
                            break;
                    }
                }
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
     * 国家配置
     * */
    public function action_config()
    {
        $id = $this->params['id'];
        $seoinfo = ORM::factory('visa_area', $id)->as_array();
        if(empty($seoinfo['pinyin'])){
            $seoinfo['pinyin']=Common::getPinYin($seoinfo['kindname']);
        }
        $this->assign('seoinfo', $seoinfo);
        $this->display('admin/visa/area_config');
    }

    /*
     * 判断拼音是否重复
     */
    public function action_ajax_check_area_english()
    {
        $english = $_POST['english'];
        $countryid = $_POST['countryid'];
        $exist_id = DB::select('id')->from('visa_area')->where('english','=', $english)->and_where('id','!=',$countryid)->execute()->current();
        echo empty($exist_id)?'true':'false';
    }

    /*
     * 国家优化配置信息保存
     * */
    public function action_ajax_config_save()
    {
        $status = 0;
        $id = Arr::get($_POST, 'countryid');
        $kindname = Arr::get($_POST, 'kindname');
        $model = ORM::factory('visa_area', $id);
        $model->seotitle = Arr::get($_POST, 'seotitle');
        $model->keyword = Arr::get($_POST, 'keyword');
        $model->jieshao = Arr::get($_POST, 'jieshao');
        $model->description = Arr::get($_POST, 'description');
        $english = $_POST['english'];
        $pinyin = strtolower(str_replace(' ','',$english));

        $model->pinyin = empty($pinyin) ? Common::getPinYin($kindname) : $pinyin;
        $model->english = empty($english)?$model->pinyin:$english;
        $model->litpic = Arr::get($_POST, 'cfg_litpic_cover');
        $model->bigpic = Arr::get($_POST, 'cfg_litpic_bg');
        $model->countrypic = Arr::get($_POST, 'cfg_litpic_guoqi');
        $model->save();
        if ($model->saved())
        {
            $status = 1;
        }
        echo json_encode(array('status' => $status, 'id' => $id));

    }

    /*
     * 删除图片
     * */
    public function action_ajax_del_image()
    {
        $status = 0;
        $id = Arr::get($_POST, 'countryid');
        $field = Arr::get($_POST, 'field');
        $image = Arr::get($_POST, 'image');
        $model = ORM::factory('visa_area', $id);
        if ($model->loaded())
        {
            $model->$field = '';
            $model->save();
            if ($model->saved())
            {
                $image = BASEPATH . $image;
                @unlink($image);
                $status = 1;
            }
        }

        echo json_encode(array('status' => $status));

    }


    /*
     * 针对数据结构一致公共保存方法
     * @param $factory ,模型
     * @param $data ,data
     * */
    public function commonSave($factory, $data)
    {
        $kindname = Arr::get($data, 'kindname');
        $displayorder = Arr::get($data, 'displayorder');
        $newname = Arr::get($data, 'newname');
        $newdisplayorder = Arr::get($data, 'newdisplayorder');
        $isopen = Arr::get($data, 'isopen');
        $id = Arr::get($data, 'id');
        for ($i = 0; isset($kindname[$i]); $i++)
        {
            $obj = ORM::factory($factory)->where('id', '=', $id[$i])->find();
            $obj->kindname = $kindname[$i];
            $obj->displayorder = $displayorder[$i];
            $obj->isopen = $isopen[$i];
            $obj->update();
            $obj->clear();
        }
        for ($i = 0; isset($newname[$i]); $i++)
        {
            $model = ORM::factory($factory);
            $model->kindname = $newname[$i];
            $model->displayorder = $newdisplayorder[$i];
            $model->isopen = $isopen[$i];
            $model->create();
            $model->clear();
        }

    }

    /*
     * 针对数据结构一致的公共获取数据方法
     * */
    public function commonGetList($factory)
    {
        $model = ORM::factory($factory);
        $arr = $model->order_by('displayorder', 'asc')->get_all();

        $out = array();
        foreach ($arr as $row)
        {

            $out[] = array('displayorder' => $row['displayorder'], 'kindname' => $row['kindname'],'isopen' => $row['isopen'], 'id' => $row['id']);

        }
        return $out;
    }

    /*
     * 公共删除数据方法
     * */
    public function commonDel($factory, $id)
    {
        $model = ORM::factory($factory, $id);
        $model->delete();
        $out = array();
        if (!$model->loaded())
        {
            $out['status'] = true;
        } else
        {
            $out['status'] = false;
        }
        return $out;
    }

    /**
     * 异步删除附件
     */
    public function action_ajax_del_doc()
    {
        $bool = false;
        if (isset($_POST['file']))
        {
            //删除文件
            $file = realpath(BASEPATH . $_POST['file']);
            $bool = unlink($file);
            if ($bool && isset($_POST['id']))
            {
                $data=DB::select()->from('visa')->where('id', '=', $_POST['id'])->execute()->current();
                if(!empty($data)){
                    $attach=unserialize($data['attachment']);
                    foreach($attach['path'] as $k=>$v){
                      if($v==$_POST['file']){
                          unset($attach['path'][$k]);
                          unset($attach['name'][$k]);
                          break;
                      }
                    }
                    DB::update('visa')->set(array('attachment' => serialize($attach)))->where('id', '=', $_POST['id'])->execute();
                }
            }
        }
        echo json_encode(array('status' => $bool));
    }

    /*
     行程
   */
    public function action_content()
    {
        $action = $this->params['action'];
        if (empty($action))
        {
            $linecontent = ORM::factory('visa_content')->where('webid=0')->order_by('displayorder')->get_all();
            $this->assign('list', $linecontent);
            $this->display('admin/visa/content');
        }
        else if ($action == 'save')
        {
            $displayorder = Arr::get($_POST, 'displayorder');
            $chinesename = Arr::get($_POST, 'chinesename');
            $isopen = Arr::get($_POST, 'isopen');

            foreach ($displayorder as $k => $v)
            {
                $model = ORM::factory('visa_content', $k);
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
            Model_Visa_Content::update_extend_field_name();
            echo 'ok';
        }
    }
    //添加内容项
    public function action_ajax_content_add()
    {
        $extend_table = 'sline_visa_extend_field';

        $lastIndex = Common::getExtendContentIndex($extend_table);
        $fieldName = 'e_' . 'content_' . $lastIndex;
        $result = Common::addField($extend_table, 'content_' . $lastIndex, 'mediumtext', 0, '自定义' . $lastIndex);
        if ($result)
        {
            $data = Model_Visa_Content::add_content_field($fieldName, '自定义' . $lastIndex);
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
        $model = ORM::factory('visa_content', $id);
        $columnName = $model->columnname;
        $model->delete();
        DB::query(Database::DELETE, "alter table `sline_visa_extend_field` drop column $columnName")->execute();
        $extendModel = ORM::factory('extend_field')->where('typeid', '=', $this->_typeid)->and_where('fieldname', '=', $columnName)->find();
        $extendModel->delete();
        echo json_encode(array('status'=>true));
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

        $this->display('admin/visa/sms');
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
        $this->display('admin/visa/email');
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

    /**
     * @function 签证人群列表
     */
    public function action_material()
    {
        $materials = Model_Visa_Material::get_list();
        $this->assign('materials', $materials);
        $this->display('admin/visa/material');
    }

    /**
     * @function 保存签证人群信息
     */
    public function action_ajax_save_material()
    {
        $id = Arr::get($_POST, 'id');
        $title = Arr::get($_POST, 'val');
        $is_show = intval(Arr::get($_POST, 'is_show'));
        if ($id)
        {
            $orm = ORM::factory('visa_material', $id);
        }
        else
        {
            $orm = ORM::factory('visa_material');
        }
        if (! $orm->is_system)
        {
            $orm->is_system = 0;
        }
        $orm->title = $title;
        $orm->is_show = $is_show;
        $orm->save();
        if ($orm->saved())
        {
            if (! $orm->is_system)
            {
                $new_orm = ORM::factory('visa_material', $orm->id);
                $pinyin = 'material' . $orm->id;
                $new_orm->pinyin = $pinyin;
                $new_orm->save();

                Model_Visa_Material_Content::add_column($pinyin, $title);
            }

            exit(json_encode(array('status' => 1, 'auto_id' => $orm->id)));
        }

        exit(json_encode(array('status' => 0)));
    }

    /**
     * @function 删除签证人群
     * @throws Kohana_Exception
     */
    public function action_ajax_del_material()
    {
        $id = Arr::get($_POST, 'id');
        if ($id)
        {
            $orm = ORM::factory('visa_material', $id);
            if(! $orm->is_system)
            {
                $field = $orm->pinyin;
                $orm->delete()->clear();
                Model_Visa_Material_Content::del_column($field);
            }
        }
        exit(json_encode(array('status' => 1)));
    }

    /**
     * @function 克隆visa产品
     */
    public function action_ajax_clone()
    {
        $num = Arr::get($_POST, 'num');
        $visaid = Arr::get($_POST, 'id');
        $model = new Model_Visa();
        $flag = $model->clone_visa($visaid, $num);
        echo json_encode(array('status' => $flag));
    }
}