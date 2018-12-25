<?php defined('SYSPATH') or die('No direct script access.');
class Controller_Startplace extends Stourweb_Controller{

    /*
     * 出发地配置
     *
     */
    public function before()
    {
        parent::before();
        $action = $this->request->action();
        if($action == 'index')
        {
            $param = $this->params['action'];
            $right = array(
                'read'=>'slook',
                'addsub'=>'sadd',
                'save'=>'smodify',
                'delete'=>'sdelete',
                'update'=>'smodify'
            );
            $user_action = $right[$param];
            if(!empty($user_action))
                Common::getUserRight('startplace',$user_action);

        }

        $this->assign('parentkey',$this->params['parentkey']);
        $this->assign('itemid',$this->params['itemid']);

    }
    public function action_index()
    {



        $action=$this->params['action'];

        $attrtable = 'startplace';//当前操作表

        if(empty($action))
        {


            $configinfo = ORM::factory('sysconfig')->getConfig(0);
            $this->assign('config', $configinfo);


            $this->display('stourtravel/startplace/index');
        }
        else if($action=='read')
        {


            $node=Arr::get($_GET,'node');
            $list=array();
            if($node=='root')//属性组根
            {
                $list=ORM::factory($attrtable)->where('pid','=','0')->get_all();
                foreach($list as $k=>$v)
                {

                    $list[$k]['allowDrag']=false;
                    $list[$k]['kindname']=$v['cityname'];
                }
                $list[]=array(
                    'leaf'=>true,
                    'id'=>'0add',
                    'cityname'=>'<button class="btn btn-primary size-S radius" onclick="addSub(0)">添加</button>',
                    'allowDrag'=>false,
                    'allowDrop'=>false,
                    'displayorder'=>'add'
                );
            }
            else //子级
            {
                $list=ORM::factory($attrtable)->where('pid','=',$node)->get_all();
                foreach($list as $k=>$v)
                {
                    $list[$k]['leaf']=true;
                    $list[$k]['kindname'] = $v['cityname'];
                }
                $list[]=array(
                    'leaf'=>true,
                    'id'=>$node.'add',
                    'cityname'=>'<button class="dest-add-btn df-add-btn" onclick="addSub(\''.$node.'\')">添加</button>',
                    'allowDrag'=>false,
                    'allowDrop'=>false,
                    'displayorder'=>'add'
                );
            }
            echo json_encode(array('success'=>true,'text'=>'','children'=>$list));
        }
        else if($action=='addsub')//添加子级
        {
            $pid=Arr::get($_POST,'pid');
            $model=ORM::factory($attrtable);
            $model->pid=$pid;
            $model->cityname="自定义";
            $model->save();

            if($model->saved())
            {
                $model->reload();
                echo json_encode($model->as_array());
            }
        }
        else if($action=='save') //保存修改
        {
            $rawdata=file_get_contents('php://input');
            $field=Arr::get($_GET,'field');

            $data=json_decode($rawdata);
            $id=$data->id;
            if($field)
            {

                $value_arr[$field] = $data->$field;
                $isupdated = DB::update($attrtable)->set($value_arr)->where('id','=',$id)->execute();
                if($isupdated)
                    echo 'ok';
                else
                    echo 'no';
            }

        }
        else if($action=='drag') //拖动
        {
            $moveid=Arr::get($_POST,'moveid');
            $overid=Arr::get($_POST,'overid');
            $position=Arr::get($_POST,'position');
            $movemodel=ORM::factory($attrtable,$moveid);
            $overmodel=ORM::factory($attrtable,$overid);
            if($position=='append')
            {
                $movemodel->pid=$overid;
            }
            else
            {
                $movemodel->pid=$overmodel->pid;
            }
            $movemodel->save();
            if($movemodel->saved())
                echo 'ok';
            else
                echo 'no';

        }

        else if($action=='delete')//属性删除
        {
            $rawdata=file_get_contents('php://input');
            $data=json_decode($rawdata);
            $id=$data->id;
            if(!is_numeric($id))
            {
                echo json_encode(array('success'=>false));
                exit;
            }
            $model=ORM::factory($attrtable,$id);
            $model->delete();

        }
        else if($action=='update')//更新操作
        {
            $id=Arr::get($_POST,'id');
            $field=Arr::get($_POST,'field');
            $val=Arr::get($_POST,'val');

            $value_arr[$field] = $val;
            $isupdated = DB::update($attrtable)->set($value_arr)->where('id','=',$id)->execute();
            if($isupdated)
                echo 'ok';
            else
                echo 'no';

        }

    }
    public function action_ajax_has_children()
    {
        $id = $_POST['id'];
        $num = DB::query(Database::SELECT,"select count(*) as num from sline_startplace where pid='{$id}' ")->execute()->get('num');
        echo json_encode(array('num'=>$num));
    }

    public function action_dialog_set_start_place()
    {
        $id = $this->params['id'];
        $startplacetop = DB::select()->from('startplace')->where('pid', '=', 0)->and_where('isopen','=',1)->execute()->as_array();
        $startplacelist = DB::select()->from('startplace')->where('pid', '!=', 0)->and_where('isopen','=',1)->execute()->as_array();
        foreach ($startplacetop as &$item)
        {
            $pid=$item['id'];
            $item['num'] = DB::query(Database::SELECT,"select count(*) as num from sline_startplace where pid='{$pid}' and isopen=1")->execute()->get('num');
        }
        $this->assign('startplacetop', $startplacetop);
        $this->assign('startplacelist', $startplacelist);
        $this->assign('startplaceid', $id);
        $this->display('stourtravel/startplace/startplace');
    }

    public function action_ajax_get_start_place()
    {
        $id = intval($_REQUEST['pid']);
        $keyword = trim(Arr::get($_POST, 'keyword'));
        $sql="SELECT * FROM sline_startplace";
        $where=" WHERE isopen=1";
        if($id)
        {
            $where.=" AND pid={$id}";
        }
        if($keyword)
        {
            $keyword_str='%'.$keyword.'%';
            $where.=" AND cityname like '{$keyword_str}'";
        }
        $sql.=$where;
        $startplace=DB::query(Database::SELECT,$sql)->execute()->as_array();
        echo json_encode(array('status' => $startplace?true:false, 'msg' => 'ok', 'list' => $startplace,'count'=>count($startplace)));
    }
}