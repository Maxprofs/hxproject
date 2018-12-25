<?php defined('SYSPATH') or die('No direct script access.');
class Controller_Admin_Notes extends Stourweb_Controller{

    /*
     * 游记总控制器
     * @author:netman
     * @data:2016-08-09
     * */
    private $_typeid = 101;

    public function before()
    {
        parent::before();
        $action = $this->request->action();
        if($action == 'index')
        {

            $param = $this->params['action'];

            $right = array(
                'read'=>'slook',
                'save'=>'smodify',
                'delete'=>'sdelete',
                'update'=>'smodify'
            );
            $user_action = $right[$param];
            if(!empty($user_action))
                Common::getUserRight('notes',$user_action);


        }
        else if($action == 'view')
        {
            Common::getUserRight('notes','slook');
        }
        else if($action == 'ajax_save')
        {
            Common::getUserRight('notes','smodify');
        }
        $this->assign('parentkey',$this->params['parentkey']);
        $this->assign('itemid',$this->params['itemid']);

    }
    public function action_index()
    {
        $action=$this->params['action'];
        if(empty($action))  //显示问答列表
        {
            $this->display('admin/notes/list');
        }
        else if($action=='read')    //读取列表
        {
            $start=Arr::get($_GET,'start');
            $limit=Arr::get($_GET,'limit');
            $keyword=Arr::get($_GET,'keyword');
            $where=!is_null($keyword)?"where a.title like '%{$keyword}%'":'';
            $order='order by a.modtime desc';
            $sort=json_decode(Arr::get($_GET,'sort'),true);
//            $specOrders=array('description','kindlist','iconlist','themelist');
            if($sort[0]['property'])
            {
                if($sort[0]['property']=='displayorder')
                    $prefix='';
                else
                {
                    $prefix='a.';
                }
                $order='order by '.$prefix.$sort[0]['property'].' '.$sort[0]['direction'].',a.modtime desc';
            }
            $sql="select a.*,ifnull(b.displayorder,999999) as displayorder,b.isding from sline_notes as a left join sline_allorderlist b on (a.id=b.aid and b.typeid=$this->_typeid) {$where} $order limit $start,$limit";
            $totalcount_arr=DB::query(Database::SELECT,"select count(*) as num from sline_notes a {$where} ")->execute()->as_array();
            $list=DB::query(Database::SELECT,$sql)->execute()->as_array();
            $new_list=array();
            foreach($list as $k=>$v)
            {
                if(empty($v['description']))
                {
                    $v['description']=strip_tags($v['content']);
                }
                $v['nickname'] = Model_Comment::getMemberName($v['memberid']);
                $new_list[] = $v;
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

            if(is_numeric($id)) //
            {
                $model=ORM::factory('notes',$id);
                $model->delete();
            }
        }
        else if($action=='update')//更新某个字段
        {
            $id=Arr::get($_POST,'id');
            $field=Arr::get($_POST,'field');
            $val=Arr::get($_POST,'val');

            $value_arr[$field] = $val;
           // $isupdated = DB::update('notes')->set($value_arr)->where('id','=',$id)->execute();
            $model = ORM::factory('notes',$id);
            $old_status = $model->status;
            if($field=='displayorder')  //如果是排序
            {
                $displayorder=empty($val)?9999:$val;
                if(is_numeric($id))//
                {
                    if(empty($kindid))  //全局排序
                    {
                        $order=ORM::factory('allorderlist');
                        $order_mod=$order->where("aid='$id' and typeid=$this->_typeid and webid=0")->find();

                        if($order_mod->id)  //如果已经存在
                        {
                            $order_mod->displayorder=$displayorder;
                        }
                        else   //如果这个排序不存在
                        {
                            $order_mod->displayorder=$displayorder;
                            $order_mod->aid=$id;
                            $order_mod->webid=0;
                            $order_mod->typeid=$this->_typeid;
                        }
                        $order_mod->save();
                        if($order_mod->saved())
                        {
                            echo 'ok';
                        }
                        else
                            echo 'no';
                    }
                    else  //按目的地排序
                    {

                        $kindorder=ORM::factory('kindorderlist');
                        $kindorder_mod=$kindorder->where("aid='$id' and typeid=$this->_typeid and classid=$kindid")->find();
                        if($kindorder_mod->id)
                        {
                            $kindorder_mod->displayorder=$displayorder;
                        }
                        else
                        {
                            $kindorder_mod->displayorder=$displayorder;
                            $kindorder_mod->aid=$id;
                            $kindorder_mod->classid=$kindid;
                            $kindorder_mod->typeid=$this->_typeid;
                        }
                        $kindorder_mod->save();
                        if($kindorder->saved())
                            echo 'ok';
                        else
                            echo 'no';
                    }
                }
            }
            else
            {
                $model->$field = $val;
                $model->save();
                if ($model->saved()) {
                    if ($field == 'status' && $val == 1)
                    {
                        $this->on_verified($this->_typeid, $model->memberid);
                    }
                    if ($field == 'status' && $old_status != $val)
                    {
                        if ($model->status == 1)
                        {
                            Model_Message::add_note_msg(101, $model->id, $model->as_array());
                        }
                        if ($model->status == -1)
                        {
                            Model_Message::add_note_msg(102, $model->id, $model->as_array());
                        }
                    }
                    echo 'ok';
                }
                else
                {
                    echo 'no';
                }
            }
        }

    }
    /**
     * 查看游记
     */
    public function action_view()
    {
      $id=$this->params['id'];
      $info = ORM::factory('notes')->where('id','=',$id)->find()->as_array();
      $info['kindlist_arr'] = ORM::factory('destinations')->getKindlistArr($info['kindlist']);//目的地数组

      $this->assign('info',$info);
      $this->display('admin/notes/view');
    }

    /**
     * 功能开关
     */
    public function action_config()
    {
        $action = $this->params['action'];
        if(!$action)
        {
            $configinfo = Model_Sysconfig::get_configs(0,array('cfg_notes_pinlun_audit_open'));
            $this->assign('config',$configinfo);
            $this->display('admin/notes/config');
        }
    }

    /**
     * 站内通知
     */
    public function action_message()
    {
        $typeid = $this->params['typeid'];

        $status_arr = array(
            array('name'=>'发布成功，待审核','status'=>'100','content'=>'','isopen'=>0),
            array('name'=>'审核通过','status'=>'101','content'=>'','isopen'=>0),
            array('name'=>'审核不通过','status'=>'102','content'=>'','isopen'=>0),
            array('name'=>'评论成功','status'=>'103','content'=>'','isopen'=>0)
        );
        foreach($status_arr as &$row)
        {
            $msg_cfg = DB::select()->from('message_config')->and_where('type','=',$row['status'])->execute()->current();
            if(!empty($msg_cfg))
            {
                $row['isopen'] = $msg_cfg['isopen'];
                $row['content'] =  $msg_cfg['content'];
            }
        }
        $this->assign('status_arr',$status_arr);
        $this->display('stourtravel/message/order');
        $this->display('admin/notes/message');
    }

    public function action_ajax_save_message()
    {
        $content = $_POST['content'];
        $isopen = $_POST['isopen'];

        foreach($content as $k=>$v)
        {
            $msg_model = ORM::factory('message_config')->where('type','=',$k)->find();
            $msg_model->type = $k;
            $msg_model->isopen = $isopen[$k];
            $msg_model->content = $v;
            $msg_model->save();
        }
        echo json_encode(array('status'=>true));
    }

    /**
     * 游记审核
     */
    public function action_ajax_save()
    {
        $id = Arr::get($_POST,'id');
        $status = false;
        $kindlist = implode(',', Model_Destinations::getParentsStr(implode(',', Arr::get($_POST, 'kindlist'))));

        $model = ORM::factory('notes',$id);
        $old_status = $model->status;
        $model->reason= $_POST['reason'];
        if($_POST['status']!=-1){
            $model->reason='';
        }

        $model->status = $_POST['status'];
        $model->read_num = $_POST['read_num'];
        $model->audittime = time();
        $model->kindlist = $kindlist;
        $model->finaldestid=empty($_POST['finaldestid'])?Model_Destinations::getFinaldestId(explode(',', $model->kindlist)):$_POST['finaldestid'];
        $model->content = $_POST['content'];
        $model->save();
        if($model->saved())
        {
            if($old_status!=1 && $_POST['status']==1)
            {
                $this->on_verified($this->_typeid,$model->memberid);
            }

            if($old_status!=$model->status)
            {
                if($model->status==1)
                {
                    Model_Message::add_note_msg(101,$model->id,$model->as_array());
                }
                if($model->status==-1)
                {
                    Model_Message::add_note_msg(102,$model->id,$model->as_array());
                }
            }


            $status = true;
        }
        echo json_encode(array('status'=>$status));
     }

    /*
   * 审核通过后调用
   */
    public function on_verified($typeid,$memberid)
    {
        $model_info = Model_Model::get_module_info($typeid);
        $jifen = Model_Jifen::reward_jifen('sys_write_'.$model_info['pinyin'],$memberid);
        if(!empty($jifen))
        {
            St_Product::add_jifen_log($memberid,'发布'.$model_info['modulename'].'送积分'.$jifen,$jifen,2);
        }
    }




}