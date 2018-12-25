<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Ship_Attrid extends Stourweb_Controller
{
    private $_typeid = 104;

    public function before()
    {
        parent::before();
        $action = $this->request->action();
        //这里需要补权限的判断功能
    }

    /*
     * 属性列表
     * */
    public function action_list()
    {
        $action = $this->params['action'];
        $typeid = $this->_typeid;
        $modeuleinfo = Model_Model::get_module_info($typeid);
        $attrtable = $modeuleinfo['attrtable'];//当前操作表

        if (empty($action))
        {
            $channelname = $modeuleinfo['title'];//产品名
            $menu = $modeuleinfo['pinyin'] . 'kind';
            $this->assign('typeid', $typeid);
            $this->assign('menu', $menu);
            $this->assign('channelname', $channelname);
            $this->display('admin/ship/attrid/list');
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
                    $list[$k]['kindname'] = Model_Destinations::get_kindname_list($v['destid']);
                    $list[$k]['allowDrag'] = false;
                }
                $list[] = array(
                    'leaf' => true,
                    'id' => '0add',
                    'attrname' => '<button class="btn btn-primary radius size-S" onclick="addSub(0)">添加</button>',
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
                    $list[$k]['kindname'] = Model_Destinations::get_kindname_list($v['destid']);
                    $list[$k]['leaf'] = true;
                }
                $list[] = array(
                    'leaf' => true,
                    'id' => $node . 'add',
                    'attrname' => '<button class="btn btn-primary radius size-S" onclick="addSub(\'' . $node . '\')">添加</button>',
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
            $model->attrname = "未命名";
            $model->webid = 0;
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
                    $model->$field = $data->$field;
                    $model->save();
                    if ($model->saved())
                        echo 'ok';
                    else
                        echo 'no';
                }
            }

        }
        else if ($action == 'drag') //拖动
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
        }

        else if ($action == 'delete')//属性删除
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
        }
        else if ($action == 'update')//更新操作
        {
            $id = Arr::get($_POST, 'id');
            $field = Arr::get($_POST, 'field');
            $val = Arr::get($_POST, 'val');
            $model = ORM::factory($attrtable, $id);

            if($field=='displayorder')
            {
                $val = empty($val)?9999:$val;
            }

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
     * 属性高级配置
     * */
    public function action_config()
    {
        $attrid = $this->params['id'];
        $typeid = $this->_typeid;
        $table = Model_Model::get_attr_table($typeid);
        $info = ORM::factory($table, $attrid)->as_array();
        $this->assign('info', $info);
        $this->assign('typeid', $typeid);
        $this->display('admin/ship/attrid/config');
    }

    /*
     * 属性配置保存
     * */
    public function action_ajax_config_save()
    {
        $typeid = $this->_typeid;
        $table = Model_Model::get_attr_table($typeid);
        $id = ARR::get($_POST, 'attrid');
        $desc = ARR::get($_POST, 'description');
        $litpic = ARR::get($_POST, 'litpic');
        $model = ORM::factory($table, $id);
        $model->litpic = $litpic;
        $model->description = $desc;
        $model->update();
        if ($model->saved())
        {
            echo json_encode(array('status' => true));
        }
    }

    /*
     * 扩展字段列表
     * */
    public function action_extendlist()
    {
        $action = $this->params['action'];
        $typeid = $this->_typeid;
        $extend_table = 'sline_extend_field';//当前操作表
        $this->assign('typeid', $typeid);
        $this->assign('isextendmodel', 0);
        if (empty($action))
        {
            $channelname = Model_Model::get_module_name($typeid);
            $this->assign('typeid', $typeid);
            $this->assign('channelname', $channelname);
            $this->display('admin/ship/attrid/extendfield');
        }
        else if ($action == 'read')
        {

            $start = Arr::get($_GET, 'start');
            $limit = Arr::get($_GET, 'limit');
            $sql = "select a.*  from $extend_table as a where typeid='$typeid' order by addtime desc limit $start,$limit";
            $list = DB::query(1, $sql, false)->execute()->as_array();
            $totalcount_arr = DB::query(Database::SELECT, "select count(*) as num from $extend_table where typeid='$typeid' ")->execute()->as_array();
            $result['total'] = $totalcount_arr[0]['count'];
            $result['lists'] = $list;
            $result['success'] = true;

            echo json_encode($result);
        }
        else if ($action == 'add')
        {

            $this->display('admin/ship/attrid/addfield');
        }
        else if ($action == 'delete')
        {
            $rawdata = file_get_contents('php://input');
            $data = json_decode($rawdata);
            $id = $data->id;
            $fieldname = $data->fieldname;
            $typeid = $this->params['typeid'];
            $extend_table = 'sline_' . Model_Model::get_extend_table($typeid);
            if (is_numeric($id))
            {
                ORM::factory('extend_field', $id)->delete();
                Common::delField($extend_table, $fieldname);
                //清理扩展字段
                DB::delete('ship_line_content')->where('columnname','=',$fieldname)->execute();
            }
        }
        else if ($action == 'update')//更新某个字段
        {
            $id = Arr::get($_POST, 'id');
            $field = Arr::get($_POST, 'field');
            $val = Arr::get($_POST, 'val');
            if (is_numeric($id))
            {
                $model = ORM::factory('extend_field')->where('id', '=', $id)->find();
            }
            if ($model->id)
            {
                $model->$field = $val;

                $model->update();
                if ($model->saved())
                    echo 'ok';
                else
                    echo 'no';
            }
        }
    }

    /*
     * 扩展字段保存
     * */
    public function action_ajax_extendfield_save()
    {
        $ftype = array(
            'text' => 'varchar(255)',
            'editor' => 'mediumtext'
        );
        $fieldname = Arr::get($_POST, 'fieldname');
        $fieldtype = Arr::get($_POST, 'fieldtype');
        $description = Arr::get($_POST, 'description');
        $isunique = Arr::get($_POST, 'isunique');
        $typeid = Arr::get($_POST, 'typeid');
        $extend_table = 'sline_' . Model_Model::get_extend_table($typeid);//扩展表名称
        $_ftype = $ftype[$fieldtype];
        Common::addField($extend_table, $fieldname, $_ftype, $isunique, $description);
        $model = ORM::factory('extend_field');
        $model->typeid = $typeid;
        $model->fieldname = 'e_' . $fieldname;
        $model->fieldtype = $fieldtype;
        $model->description = $description;
        $model->isopen = 1;
        $model->isunique = $isunique;
        $model->save();
        if ($model->saved())
        {
            echo json_encode(array('status' => true));
        }
    }

    /*
     * 字段名检测
     * */
    public function action_ajax_field_check()
    {
        $fieldname = Arr::get($_POST, 'fieldname');
        $typeid = $this->_typeid;
        $flag = 'false';
        $model = ORM::factory('extend_field')->where("fieldname='e_$fieldname' and typeid='$typeid'")->find();
        if (!isset($model->id))//没有找到就通过
        {
            $flag = 'true';
        }
        echo $flag;
    }

    /*
     * 公用行程内容处理控制器
     *
     * */
    public function action_content()
    {
        $action = $this->params['action'];
        $typeid = $this->_typeid;
        $modeuleinfo = Model_Model::get_module_info($typeid);
        $content_table = $modeuleinfo['pinyin'] . '_content';
        $channelname = $modeuleinfo['modulename'];
        $this->assign('typeid', $typeid);
        $this->assign('channelname', $channelname);
        if (empty($action))
        {
            $model = ORM::factory($content_table);
            if ($modeuleinfo['issystem'] != 1)
            {
                $contentlist = $model->where('typeid', '=', $typeid . ' and columnname!="tupian"')->order_by('displayorder')->get_all();
            }
            else
            {
                $contentlist = $model->where('columnname!="tupian"')->order_by('displayorder')->get_all();
            }

            $this->assign('list', $contentlist);
            $this->display('admin/ship/attrid/content');
        }
        else if ($action == 'save')
        {
            $displayorder = Arr::get($_POST, 'displayorder');
            $chinesename = Arr::get($_POST, 'chinesename');
            $isopen = Arr::get($_POST, 'isopen');
            foreach ($displayorder as $k => $v)
            {
                $m = ORM::factory($content_table);
                $model = $m->where("id=$k")->find();
                if ($model->id)
                {
                    $open = $isopen[$k] ? 1 : 0;
                    $model->chinesename = $chinesename[$k];
                    $model->displayorder = ($v == '' ? 9999 : $v);
                    $model->isopen = $open;
                    $model->save();
                    $this->add_extend_field($typeid, $model->columnname, $model->chinesename, 1);
                }
            }
            echo 'ok';
        }
    }


    public function action_ajax_addfield()
    {
        $typeid = $this->_typeid;
        $extend_table = 'sline_' . Model_Model::get_extend_table($typeid);
        if (empty($extend_table))
        {
            echo json_encode(array('status' => false, 'msg' => '类型错误'));
            return;
        }
        $lastIndex = Common::getExtendContentIndex($extend_table);
        $fieldName = 'e_' . 'content_' . $lastIndex;
        $result = Common::addField($extend_table, 'content_' . $lastIndex, 'mediumtext', 0, '自定义' . $lastIndex);
        if ($result)
        {
            $data = $this->add_content_field($typeid, $fieldName, '自定义' . $lastIndex);
            $this->add_extend_field($typeid, $fieldName, '自定义' . $lastIndex);
            echo json_encode(array('status' => true, 'msg' => '添加成功', 'data' => $data));
        }
        else
        {
            echo json_encode(array('status' => false, 'msg' => '添加失败'));
        }
    }

    public function action_ajax_delfield()
    {
        $id = $_POST['id'];
        $typeid = $_POST['typeid'];
        $this->del_content_field($typeid, $id);
    }

    public function action_dialog_delfield()
    {
        $id = $_GET['id'];
        $typeid = $this->_typeid;
        $modeuleinfo = Model_Model::get_module_info($typeid);
        $table = $modeuleinfo['pinyin'] . '_content';
        $model = ORM::factory($table, $id);
        if (!$model->loaded())
        {
            return false;
        }
        $columnName = $model->columnname;
        $extendTable = 'sline_' . Model_Model::get_extend_table($typeid);//扩展表名称
        $sql = "select productid from $extendTable where $columnName is not null and $columnName!=''";
        $list = DB::query(Database::SELECT, $sql)->execute()->as_array();
        $ids = array();
        if (!empty($list))
        {
            foreach ($list as $v)
            {
                $ids[] = $v['productid'];
            }
        }
        $idsStr = implode(',', $ids);
        if (!empty($idsStr))
        {
            $sql2 = "select * from sline_search where tid in ($idsStr) and typeid={$typeid}";
            $productList = DB::query(Database::SELECT, $sql2)->execute()->as_array();
            $this->assign('products', $productList);
        }
        $this->assign('id', $id);
        $this->display('admin/ship/attrid/dialog_delfield');
    }


    /**
     * @function 添加内容字段
     * @param $typeid
     * @param $field
     * @param $description
     * @return array|bool
     */
    public function add_content_field($typeid, $field, $description)
    {
        $modeuleinfo = Model_Model::get_module_info($typeid);
        $table = $modeuleinfo['pinyin'] . '_content';
        $model = ORM::factory($table)->where('columnname', '=', $field)->find();
        $model->columnname = $field;
        $model->chinesename = $description;
        $model->issystem = 0;
        $model->isopen = 1;
        $model->isrealfield = 1;
        $model->displayorder = 99;
        $model->webid = 0;
        if ($model->save())
        {
            $model->reload();
            return $model->as_array();
        }
        else
        {
            return false;
        }
    }

    /**
     * @function 删除字段
     * @param $typeid
     * @param $id
     * @return bool
     */
    public function del_content_field($typeid, $id)
    {
        $modeuleinfo = Model_Model::get_module_info($typeid);
        $table = $modeuleinfo['pinyin'] . '_content';
        $model = ORM::factory($table, $id);
        $columnName = $model->columnname;
        $model->delete();
        $extend_table = 'sline_' . Model_Model::get_extend_table($typeid);
        $result = DB::query(Database::DELETE, "alter table `$extend_table` drop column $columnName")->execute();
        if (!$result)
            return false;
        $extendModel = ORM::factory('extend_field')->where('typeid', '=', $typeid)->and_where('fieldname', '=', $columnName)->find();
        $extendModel->delete();
        return true;
    }


    public function add_extend_field($typeid, $field, $description, $issave = 0)
    {
        $model = ORM::factory('extend_field')->where('typeid', '=', $typeid)->and_where('fieldname', '=', $field)->find();
        if ($issave == 1 && !$model->loaded())
        {
            return false;
        }
        $model->typeid = $typeid;
        $model->fieldname = $field;
        $model->fieldtype = 'editor';
        $model->description = $description;
        $model->isopen = 1;
        $model->isunique = 0;
        return $model->save();
    }
}