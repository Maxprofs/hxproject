<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Created by PhpStorm.
 * Author: daisc
 * QQ: 2444329889
 * Time: 2018/03/28 17:51
 * Desc: desc
 */

class Controller_Admin_Envelope extends Stourweb_Controller
{
    function before()
    {
        parent::before();

        $this->assign('parentkey',$this->params['parentkey']);
        $this->assign('itemid',$this->params['itemid']);


    }

    public function action_index()
    {

        $product_list = Model_Envelope::get_use_modules();
        $this->assign('product_list',$product_list);
        $action = $this->params['action'];
        if(!$action)
        {
            $this->display('admin/envelope/list');

        }
        elseif ($action=='read')
        {
            $this->_read_envelope();
        }
        elseif ($action=='update')
        {
            $this->_update_envelope();
        }
        elseif ($action='delete')
        {
            $data = file_get_contents('php://input');
            $data = json_decode($data);
            DB::update('envelope')->set(array('delete'=>1))->where('id','=',$data->id)->execute();
          //  echo  'ok';
        }

    }

    public function action_add()
    {
        $product_list = Model_Envelope::get_use_modules();
        $id  = $this->params['id'];
        if($id)
        {
            $info = DB::select()->from('envelope')->where('id','=',$id)->execute()->current();
            if($info['typeids'])
            {
                $info['typeids'] = explode(',',$info['typeids']);
            }
            $this->assign('info',$info);
        }
      //  $product_list = Model_Envelope::get_finish_use_modules($product_list,$id);


        $default_share_litpic = Model_Envelope::get_default_share_litpic();
        $this->assign('product_list',$product_list);
        $this->assign('default_share_litpic',$default_share_litpic);
        $this->display('admin/envelope/add');
    }

    //保存
    public function action_ajax_save()
    {
        $id = $_POST['id'];

        $title = $_POST['title'];
        $typeids = $_POST['typeids'];
        $share_money = $_POST['share_money'];
        $share_money< 11 ? $share_money = 11 :$share_money = $share_money;
        $total_number = $_POST['total_number'];
        $status = $_POST['status'];
        $share_title = $_POST['share_title'];
        $share_description = $_POST['share_description'];
        $share_litpic = $_POST['share_litpic'];
        $description = $_POST['description'];
        $data = array(
            'title'=>$title,
            'typeids'=>implode(',',$typeids) ,
            'share_money'=>$share_money,
            'total_number'=>$total_number,
            'status'=>$status,
            'share_title'=>$share_title,
            'share_description'=>$share_description,
            'share_litpic'=>$share_litpic,
            'description'=>$description,
            'total_money'=>$share_money * $total_number
        );
        if($id)
        {
            DB::update('envelope')->set($data)->where('id','=',$id)->execute();
        }
        else
        {
            $data['addtime'] = time();
            list($id) = DB::insert('envelope',array_keys($data))->values(array_values($data))->execute();
        }
        if($status==1)
        {
            //关闭其他的相同typeid的红包策略
            foreach ($typeids  as $typeid)
            {
                DB::update('envelope')->set(array('status'=>0))->where("find_in_set($typeid,typeids) and id<>$id")
                    ->execute();

            }

        }


        echo $id;


    }

    //更新红包信息
    private function _update_envelope()
    {

        $id = $_POST['id'];
        $val = $_POST['val'];
        $field = $_POST['field'];
        if($field=='status'&&$val==1)
        {
            //判断是否有相同产品的红包
            $typeids = DB::select('typeids')->from('envelope')
                ->where('id','=',$id)->execute()->get('typeids');
            $typeids = explode(',',$typeids);
            foreach ($typeids as $typeid)
            {
                DB::update('envelope')->set(array('status'=>0))->where("find_in_set($typeid,typeids) and id<>$id")
                    ->execute();

            }
        }
        $rsn = DB::update('envelope')->set(array($field=>$val))
            ->where('id','=',$id)
            ->and_where('delete','=',0)
            ->and_where('is_finish','=',0)
            ->execute();
        if($rsn)
        {
            exit(json_encode(array('status'=>1,'msg'=>'更新成功')));
        }
        else
        {
            exit(json_encode(array('status'=>0,'msg'=>'保存失败，该红包已经被领完了!')));
        }
    }



    //读取红包资料
    private function _read_envelope()
    {
        $typeid = $_GET['typeid'];
        $keyword = $_GET['keyword'];
        $start= $_GET['start'];
        $limit = $_GET['limit'];
        $where =" `delete`=0";
        if($typeid)
        {
            $where .=" and find_in_set($typeid,typeids)";
        }
        if($keyword)
        {
            $where .=" and title like '%$keyword%'";
        }
        $sort = json_decode($_GET['sort'],true) ;

        if($sort = $sort[0])
        {
            $order_c = $sort['property'];
            $order_d = $sort['direction'];
        }
        else
        {
            $order_c = 'id';
            $order_d = 'desc';
        }

        $total = DB::select(DB::expr('count(*) as num'))
            ->from('envelope')->where($where)->execute()->get('num');
        $list = DB::select()->from('envelope')->where($where)
            ->offset($start)->limit($limit)->order_by($order_c,$order_d)->execute()->as_array();
        foreach ($list as &$l)
        {
            if($l['typeids'])
            {
                $modulelist = DB::select('modulename')->from('model')
                    ->where("id in ({$l['typeids']})")
                    ->execute()->as_array('modulename');
                $l['typeid_title'] = implode(',',array_keys($modulelist));

            }
            $l['total_number'] = $l['total_number'] - $l['share_number'];
            $l['use_rate'] = Model_Envelope::get_envelope_use_rate($l['id']);
            $l['new_rate'] = Model_Envelope::get_envelope_new_rate($l['id']);

        }
        unset($l);
        echo json_encode(array('total'=>$total,'lists'=>$list));

    }

    //配置
    public function action_config()
    {
        $config = Model_Sysconfig::get_sys_conf('value','cfg_envelope_description');

        $this->assign('config',$config);
        $this->display('admin/envelope/config');

    }

    public function action_count()
    {
        $id = $this->params['id'];
        //成交率
        $use_rate = Model_Envelope::get_envelope_use_rate($id);
        //领取率
        $get_rate = Model_Envelope::get_envelope_get_rate($id);
        //分享情况，总次数，与剩余次数
        $envelope = DB::select('total_number','share_number')->from('envelope')
            ->where('id','=',$id)->execute()->current();
        $total_number = $envelope['total_number'] * 10;
        $envelope['total_number'] = $envelope['total_number'] - $envelope['share_number'];
        //总可领取（等于分享订单数*10）
//        $total_order = DB::select(DB::expr('count(*) as num'))
//            ->from('envelope_order')->where('envelope_id','=',$id)
//            ->execute()->get('num');
//
//
//
//        $total_number = $total_order *10 ;
        //领取次数
        $total_get=  DB::select(DB::expr('count(*) as num'))
            ->from('envelope_member')->where('envelope_id','=',$id)
            ->execute()->get('num');
        //使用次数
        $total_use=  DB::select(DB::expr('count(*) as num'))
            ->from('envelope_member')->where('envelope_id','=',$id)
            ->and_where('use','=',1)->execute()->get('num');
        //新用户数
        $new_get=  DB::select(DB::expr('count(*) as num'))
            ->from('envelope_member')->where('envelope_id','=',$id)
            ->and_where('is_new_member','=',1)->execute()->get('num');
        $old_get = $total_get - $new_get;
        $this->assign('use_rate',$use_rate);
        $this->assign('get_rate',$get_rate);
        $this->assign('envelope',$envelope);
        $this->assign('total_number',$total_number);
        $this->assign('total_get',$total_get);
        $this->assign('total_use',$total_use);
        $this->assign('new_get',$new_get);
        $this->assign('old_get',$old_get);


        $this->display('admin/envelope/count');

    }

    //统计领用率
    public function action_stat()
    {
        $action = $_GET['action'];
        if(!$action)
        {

            $this->display('admin/envelope/stat');
        }
        elseif ($action== 'read')
        {
            $keyword = $_GET['keyword'];
            $start = $_GET['start'];
            $limit = $_GET['limit'];
            $where = " a.id>0";
            if($keyword)
            {
                $where .=" and (a.envelope_title like '%$keyword%' or b.nickname like '%$keyword%' or b.mobile like '%$keyword%')";
            }
            $total_sql = "select count(*) as num from sline_envelope_member as a LEFT JOIN sline_member as b on a.memberid=b.mid WHERE $where";
            $total = DB::query(1,$total_sql)->execute()->get('num');
            $list_sql = "select a.*,b.nickname,b.mobile from sline_envelope_member as a LEFT JOIN sline_member as b on a.memberid=b.mid WHERE $where ORDER BY  addtime desc limit $start,$limit";
            $list = DB::query(1,$list_sql)->execute()->as_array();
            foreach ($list as &$l)
            {
                $l['addtime'] = date('Y-m-d H:i:s',$l['addtime']);
                if($l['use'])
                {
                    $l['usetime'] = date('Y-m-d H:i:s',$l['usetime']);
                }
                if($l['typeids'])
                {
                    $modulelist = DB::select('modulename')->from('model')
                        ->where("id in ({$l['typeids']})")
                        ->execute()->as_array('modulename');
                    $l['typeid_title'] = implode(',',array_keys($modulelist));

                }
            }
            unset($l);
            exit(json_encode(array('total'=>$total,'lists'=>$list)));
        }
    }

    //导出excel
    public function action_excel_stat()
    {
        $table = Model_Envelope::get_excel_stat_table();
        $filename = date('Ymdhis');
        ob_end_clean();
        header('Pragma:public');
        header('Expires:0');
        header('Content-Type:charset=utf-8');
        header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
        header('Content-Type:application/force-download');
        header('Content-Type:application/vnd.ms-excel');
        header('Content-Type:application/octet-stream');
        header('Content-Type:application/download');
        header('Content-Disposition:attachment;filename=' . $filename . ".xls");
        header('Content-Transfer-Encoding:binary');
        if (empty($table))
        {
            echo iconv('utf-8', 'gbk', $table);
        }
        else
        {
            echo $table;
        }
        exit();
    }



}