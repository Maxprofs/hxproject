<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Customize_Field extends Stourweb_Controller
{


    public function before()
    {
        parent::before();
        $action = $this->request->action();
        //这里需要补权限的判断功能
    }

    /*
     * 属性列表
     * */
    public function action_index()
    {
        $action = $this->params['action'];

        if (empty($action))
        {
            $this->display('admin/customize/field/index');
        }
        else if ($action == 'read')
        {
            $node = Arr::get($_GET, 'node');
            $list = array();
            if ($node == 'root')//属性组根
            {
                $list = ORM::factory('customize_extend_field_desc')->where('pid', '=', '0')->get_all();
                foreach ($list as $k => $v)
                {
                    $list[$k]['allowDrag'] = false;
                }
            }
            else //子级
            {
                $list = ORM::factory('customize_extend_field_desc')->where('pid', '=', $node)->get_all();
                foreach ($list as &$v)
                {
                    $v['leaf'] = true;
                }
                $list[] = array(
                    'leaf' => true,
                    'id' => $node . 'add',
                    'chinesename' => '<button class="btn btn-primary radius size-S" onclick="addSub(\'' . $node . '\')">添加</button>',
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
            $model = ORM::factory('customize_extend_field_desc');
            $subnum=DB::select(array(DB::expr("count(*)"),'num'))->from('customize_extend_field_desc')->where('pid','=',$pid)->execute()->get('num');
            $index = $subnum+1;

            $model->pid = $pid;
            $model->chinesename = '选项值'.$index;
            $model->save();
            if ($model->saved())
            {
                $model->reload();
                $info = $model->as_array();
                echo json_encode($info);
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
                $model = ORM::factory('customize_extend_field_desc', $id);
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

        else if ($action == 'delete')//属性删除
        {
            $rawdata = file_get_contents('php://input');
            $data = json_decode($rawdata,true);
            $id = $data['id'];
            $this->delete_field($id);

        }
        else if ($action == 'update')//更新操作
        {
            $id = Arr::get($_POST, 'id');
            $field = Arr::get($_POST, 'field');
            $val = Arr::get($_POST, 'val');
            $model = ORM::factory('customize_extend_field_desc', $id);
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

    public function action_ajax_field_check()
    {
        $fieldname = Arr::get($_POST, 'fieldname');
        $fieldname = 'e_'.$fieldname;
        $flag = 'false';
        $model = ORM::factory('customize_extend_field_desc')->where("fieldname='$fieldname'")->find();
        if (!isset($model->id))//没有找到就通过
        {
            $flag = 'true';
        }
        echo $flag;
    }

    public function action_dialog_add_field()
    {
        $this->display('admin/customize/field/dialog_add_field');
    }

    public function action_ajax_field_save()
    {
        $fieldname = $_POST['fieldname'];
        $chinesename = $_POST['chinesename'];
        $fieldname = 'e_'.$fieldname;
        $model = ORM::factory('customize_extend_field_desc')->where('fieldname', '=', $fieldname)->find();
        if($model->loaded())
        {
            echo json_encode(array('status'=>false,'msg'=>'字段已存在'));
            return;
        }
        $model->fieldname = $fieldname;
        $model->chinesename = $chinesename;
        $model->isopen = 1;
        $model->save();
        if ($model->saved()) {
            if (empty($id)) {
                DB::query(1, "ALTER TABLE `sline_customize_extend_field` ADD COLUMN `{$fieldname}` VARCHAR(255) NULL DEFAULT NULL COMMENT '$chinesename'")->execute();
            }
        }
        echo json_encode(array('status'=>true));
    }

    private function delete_field($id)
    {
        $model = ORM::factory('customize_extend_field_desc',$id);
        if(!$model->loaded())
            return false;
        if($model->pid==0)
        {
            DB::delete('customize_extend_field_desc')->where('pid','=',$id)->execute();
            DB::query(1, "ALTER TABLE `sline_customize_extend_field` DROP COLUMN `".$model->fieldname."`")->execute();
        }
        $model->delete();
        return true;
    }
}