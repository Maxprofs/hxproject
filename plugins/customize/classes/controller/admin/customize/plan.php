<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Customize_Plan extends Stourweb_Controller
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
        $action=$this->params['action'];
        if(empty($action))  //显示线路列表页
        {
            $this->display('admin/customize/plan/index');
        }
        else if($action=='read')    //读取列表
        {
            $start=Arr::get($_GET,'start');
            $limit=Arr::get($_GET,'limit');
            $keyword=Arr::get($_GET,'keyword');

            $sort=json_decode($_GET['sort'],true);
            $order='order by displayorder desc';

            if($sort[0]['property'])
            {
                $order='order by '.$sort[0]['property'].' '.$sort[0]['direction'].',modtime desc';
            }
            $w=" where id is not null";
            $w.=empty($keyword)?'':" and title like '%{$keyword}%'";

            $sql="select id,title,modtime,dest,starttime,startplace,days,adultnum,childnum,displayorder,shownum from sline_customize_plan {$w} {$order} limit {$start},{$limit}";
            $totalcount_arr=DB::query(Database::SELECT,"select count(*) as num from sline_customize_plan  $w")->execute()->as_array();
            $list=DB::query(Database::SELECT,$sql)->execute()->as_array();
            $new_list=array();
            foreach($list as $k=>$v)
            {
                $v['starttime'] = empty($v['starttime'])?'': date('Y-m-d',$v['starttime']);
                $v['url'] = Common::getBaseUrl(0) . '/customize/plan_' . $v['id'] . '.html';
                $new_list[]=$v;
            }
            $result['total']=$totalcount_arr[0]['num'];
            $result['lists']=$new_list;
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
                $model=ORM::factory('customize_plan',$id);
                $model->delete();
            }


        }
        else if($action=='update')//更新某个字段
        {
            $id=Arr::get($_POST,'id');
            $field=Arr::get($_POST,'field');
            $val=Arr::get($_POST,'val');
            if($field=='displayorder')  //如果是排序
            {
                $val=empty($val)?999999:$val;
            }
            $model=ORM::factory('customize_plan',$id);
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
    public function action_add()
    {

        $this->display('admin/customize/plan/edit');
    }
    public function action_edit()
    {
        $id = $this->params['id'];
        $info = DB::select()->from('customize_plan')->where('id','=',$id)->execute()->current();
        $extend_info = DB::select()->from('customize_extend_field')->where('planid','=',$id)->execute()->current();
        $info['piclist_arr'] =  json_encode(Common::getUploadPicture($info['piclist']));//图片数组
        $info['starttime'] = empty($info['starttime'])?'':date('Y-m-d', $info['starttime']);
        $info['linedoc'] = unserialize($info['linedoc']);
        $this->assign('info',$info);
        $this->assign('extend_info',$extend_info);
        $this->display('admin/customize/plan/edit');
    }
    public function action_ajax_save()
    {
        $id = $_POST['id'];
        $curtime = time();
        //添加操作

        $model = ORM::factory('customize_plan',$id);

        if(!$model->loaded())
        {
            $model->addtime = $curtime;
        }

        $imagestitle = $_POST['imagestitle'];
        $images = $_POST['images'];
        $imgheadindex = $_POST['imgheadindex'];

        //图片处理
        $piclist ='';
        $litpic = $images[$imgheadindex];
        for($i=1;isset($images[$i]);$i++)
        {
            $desc = isset($imagestitle[$i]) ? $imagestitle[$i] : '';
            $pic = !empty($desc) ? $images[$i].'||'.$desc : $images[$i];
            $piclist .= $pic.',';
        }
        $piclist =strlen($piclist)>0 ? substr($piclist,0,strlen($piclist)-1) : '';//图片


        $model->title = $_POST['title'];
        $model->content = $_POST['content'];
        $model->piclist = $piclist;
        $model->litpic = $litpic;
        $model->modtime = $curtime;
        $model->linedoc = serialize(($_POST['linedoc']));

        $model->dest = $_POST['dest'];
        $model->startplace = $_POST['startplace'];
        $model->starttime = empty($_POST['starttime'])?'': strtotime($_POST['starttime']);
        $model->days = $_POST['days'];
        $model->adultnum = $_POST['adultnum'];
        $model->childnum = $_POST['childnum'];

        $model->save();
        $status = false;
        if ($model->saved())
        {
            $id = $model->id;
            $extend_model = ORM::factory('customize_extend_field')->where('planid','=',$model->id)->find();
            foreach($_POST as $k=>$v)
            {
                if(strpos($k,'e_')===0)
                {
                    $extend_model->$k=$v;
                }
            }
            $extend_model->planid = $model->id;
            $extend_model->save();
            $status = true;
        }
        echo json_encode(array('status' => $status, 'productid' => $id));
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
            $bool = unlink($file);
            if ($bool && isset($_POST['id']))
            {
                $data=DB::select()->from('customize_plan')->where('id', '=', $_POST['id'])->execute()->current();
                if(!empty($data)){
                    $attach=unserialize($data['linedoc']);
                    foreach($attach['path'] as $k=>$v){
                        if($v==$_POST['file']){
                            unset($attach['path'][$k]);
                            unset($attach['name'][$k]);
                            break;
                        }
                    }
                    DB::update('customize_plan')->set(array('linedoc' => serialize($attach)))->where('id', '=', $_POST['id'])->execute();
                }
            }
        }
        echo json_encode(array('status' => $bool));
    }
}