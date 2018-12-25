<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Class Controller_Admin_Destination
 * 酒店目的地控制器
 */
class Controller_Admin_Hotel_Destination extends Stourweb_Controller
{

    private $_typeid = 2;

    public function before()
    {
        parent::before();
        $action = $this->request->action();
        $this->assign('templetlist', Common::getUserTemplteList('dest_index')); //获取上传的用户模板
        $this->assign('typeid', $this->_typeid);
        //这里接下来需要添加权限判断的相关功能

    }

    public function action_destination()
    {
        $action = $this->params['action'];
        $model_info = Model_Model::get_module_info($this->_typeid);
        $model_info['path'] = empty($model_info['correct'])?$model_info['pinyin']:$model_info['correct'];
        $product_dest_table = 'sline_' . $model_info['pinyin'] . '_kindlist';
        $this->assign('model_info', $model_info);
        if (empty($action))
        {
            $position = $model_info['modulename'] . '目的地';
            $this->assign('position', $position);
            $this->display('admin/hotel/destination/destination');
        }
        else if ($action == 'read')
        {
            $node = Arr::get($_GET, 'node');
            $node_arr = explode('_', $node);
            $pid = $node_arr[1] == 'root' ? 0 : $node_arr[1];
            $bfields = 'b.kindid,b.seotitle,b.keyword,b.description,b.tagword,b.jieshao,b.isfinishseo,b.isnav,b.ishot,b.displayorder';
            $sql = "select a.id,a.kindname,if(find_in_set($this->_typeid,opentypeids),1,0) as isopen,a.pinyin,a.iswebsite,{$bfields} from sline_destinations a left join $product_dest_table b on a.id=b.kindid where a.pid=$pid and a.isopen=1";
            $list = DB::query(Database::SELECT, $sql)->execute()->as_array();
            foreach($list as &$v)
            {
                $subnum=DB::select(array(DB::expr("count(*)"),'num'))->from('destinations')->where('pid','=',$v['id'])->and_where('isopen','=',1)->execute()->get('num');
                if($subnum<=0)
                    $v['leaf']=true;
            }
            echo json_encode(array('success' => true, 'text' => '', 'children' => $list));
        }
        else if ($action == 'update')
        {
            $id = Arr::get($_POST, 'id');
            $field = Arr::get($_POST, 'field');
            $val = Arr::get($_POST, 'val');
            $typeid = Arr::get($_POST, 'typeid');
            if ($field == 'displayorder' && $val == '')
            {
                $val = 9999;
            }
            if ($field == 'isopen')
            {
                $result = Model_Destinations::set_typeid_open($id, $typeid, $val);
                if ($result)
                {
                    echo 'ok';
                }
                else
                {
                    echo 'no';
                }
            }
            else
            {
                $product_dest_table = $model_info['pinyin'] . '_kindlist';
                $model = new Model_Tongyong($product_dest_table);
                $model = $model->where("kindid=$id")->find();
                if (!$model->loaded())
                {
                    $model->kindid = $id;
                }
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
        else
        {
            if ($action == 'save')
            {
                $pinyin = '';
                $rawdata = file_get_contents('php://input');
                $field = Arr::get($_GET, 'field');
                $current_pinyin = Arr::get($_GET, 'pinyin');
                $data = json_decode($rawdata);
                $typeid = $this->_typeid;
                $dest_id_arr = explode('_', $data->id);
                $dest_id = $dest_id_arr[1];
                $moduleinfo = Model_Model::get_module_info($typeid);
                $product_dest_table = $moduleinfo['pinyin'] . '_kindlist';
                if (!is_numeric($dest_id_arr[1]))
                {
                    echo json_encode(array('success' => false));
                }
                $dest = new Model_Tongyong($product_dest_table);
                $dest = $dest->where("kindid=$dest_id")->find();
                if (!$dest->loaded())
                {
                    $dest->kindid = $dest_id;
                    $dest->displayorder = $data->displayorder;
                }
                else
                {
                    unset($data->id);
                    unset($data->parentId);
                    unset($data->leaf);
                    unset($data->kindname);
                    unset($data->isopen);
                    unset($data->iswebsite);
                    unset($data->istopnav);
                    unset($data->pinyin);
                    unset($data->pid);
                    unset($data->kindtype);
                    unset($data->litpic);
                    unset($data->piclist);
                    unset($data->issel);
                    unset($data->shownum);
                    unset($data->templet);
                    unset($data->weburl);
                    foreach ($data as $k => $v)
                    {
                        $dest->$k = $v;
                    }
                    $dest->displayorder = $data->displayorder;
                }
                $dest->displayorder = empty($dest->displayorder) ? 9999 : $dest->displayorder;
                $dest->save();
                if ($dest->saved())
                {
                    echo json_encode(array('success' => true, 'pinyin' => $pinyin));
                }
                else
                {
                    echo json_encode(array('success' => false));
                }
            }

            else
            {
                if ($action == 'search')
                {
                    $keyword = trim(Arr::get($_POST, 'keyword'));
                    $list = DB::query(Database::SELECT, "select id,pid from sline_destinations where kindname like '%{$keyword}%'")->execute()->as_array();
                    $new_arr = array();
                    foreach ($list as $k => $v)
                    {
                        $temp_arr = array();
                        if ($v['pid'] != 0)
                        {
                            $temp_id = $v['pid'];
                            $temp_arr = array($v['pid'], $v['id']);
                            while (true)
                            {
                                $temp_dest = ORM::factory('destinations', $temp_id)->as_array();
                                if ($temp_dest['pid'] != 0)
                                {
                                    array_unshift($temp_arr, $temp_dest['pid']);
                                    $temp_id = $temp_dest['pid'];
                                }
                                else
                                {
                                    break;
                                }
                            }
                            $new_arr[] = $temp_arr;
                        }
                        else
                        {
                            $new_arr[] = array($v['id']);
                        }
                    }
                    if (empty($new_arr))
                    {
                        echo 'no';
                    }
                    else
                    {
                        echo json_encode($new_arr);
                    }
                }
            }
        }

    }

    /*
       获取下级目的地,用于各个列表的目的地筛选
    */
    public function action_ajax_get_next_dest_list()
    {
        $pid = Arr::get($_POST, 'pid');
        $keyword = Arr::get($_POST, 'keyword');
        $pid = empty($pid) ? 0 : $pid;
        if ($keyword)
        {
            $sql = "select id,kindname,pinyin from sline_destinations where kindname like '%{$keyword}%' order by pinyin asc";
        }
        else
        {
            $sql = "select id,kindname,pinyin from sline_destinations where pid=$pid  order by pinyin asc";
        }
        $destlist = DB::query(Database::SELECT, $sql)->execute()->as_array();
        echo json_encode($destlist);
    }

    /*
      获取下级目的地和已设置的目的地名称,用于产品的目的地设置
    */
    public function action_ajax_getDestsetList()
    {
        $pid = Arr::get($_POST, 'pid');
        $keyword = Arr::get($_POST, 'keyword');
        $pid = empty($pid) ? 0 : $pid;
        $kindlist = Arr::get($_POST, 'kindlist');
        if ($keyword)
        {
            $sql = "select id,kindname,pinyin from sline_destinations where kindname like '%{$keyword}%' and isopen=1  order by pinyin asc";
        }
        else
        {
            $sql = "select id,kindname,pinyin from sline_destinations where pid=$pid and isopen=1  order by pinyin asc";
        }
        $destlist = DB::query(Database::SELECT, $sql)->execute()->as_array();
        foreach ($destlist as $key => $row)
        {
            $sql = "select count(*) as num from sline_destinations where pid='{$row['id']}' and isopen=1";
            $r = DB::query(1, $sql)->execute()->as_array();
            $destlist[$key]['childnum'] = $r[0]['num'];
        }
        if ($kindlist)
        {
            $_arr = explode(',', $kindlist);
            foreach ($_arr as $k => $v)
            {
                $_dest = ORM::factory('destinations', $v);
                if ($_dest->id)
                {
                    $nv['id'] = $_dest->id;
                    $nv['kindname'] = $_dest->kindname;
                    $new_arr[] = $nv;
                }
            }
        }
        $dest_parents = Model_Destinations::get_parents($pid);
        echo json_encode(array('nextlist' => $destlist, 'selected' => $new_arr, 'parents' => $dest_parents));
    }

    /**
     * 产品优化信息
     */
    public function action_dialog_productinfo()
    {
        $id = $_GET['id'];
        $typeid = $this->_typeid;
        $moduleinfo = Model_Model::get_module_info($typeid);
        $product_dest_table = $moduleinfo['pinyin'] . '_kindlist';
        $model = new Model_Tongyong($product_dest_table);
        $info = $model->where("kindid", '=', $id)->find()->as_array();
        $pageName = $moduleinfo['pinyin'] . '_list';
        $templateList = St_Product::get_template_list($pageName);
        $this->assign('templateList', $templateList);
        $this->assign('id', $id);
        $this->assign('typeid', $typeid);
        $this->assign('info', $info);
        $this->display('admin/hotel/destination/dialog_productinfo');
    }
}