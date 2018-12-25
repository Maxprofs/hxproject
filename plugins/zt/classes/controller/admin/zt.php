<?php defined('SYSPATH') or die('No direct script access.');
class Controller_Admin_Zt  extends Stourweb_Controller{
    public function before()
    {
        parent::before();
        $this->assign('parentkey',$this->params['parentkey']);
        $this->assign('itemid',$this->params['itemid']);
        //优惠券是否安装
        $is_coupon_install = St_Functions::is_normal_app_install('coupon');
        $this->assign('is_coupon_install',$is_coupon_install);




    }
	public function action_list()
	{

		$action=$this->params['action'];
		if(empty($action))  //显示线路列表页
		{
		    $this->display('admin/zt/list');
		}
		else if($action=='read')    //读取列表
		{
			$start=Arr::get($_GET,'start');
			$limit=Arr::get($_GET,'limit');
            $keyword=Arr::get($_GET,'keyword');
            $sort=json_decode(Arr::get($_GET,'sort'));
            $addtime_desc = 'desc';
			if($sort[0]->property)
			{
				if($sort[0]->property=='displayorder')
				{
					$order='order by displayorder '.$sort[0]->direction;
				}
				else if($sort[0]->property=='addtime')
				{
                    $addtime_desc = $sort[0]->direction;
				}
			}
			$w="id is not null";
            $w.= !empty($keyword) ? " and title like '%$keyword%'" : '';
			$sql="select *,ifnull(displayorder,9999) as displayorder from sline_zt where $w $order ORDER BY addtime $addtime_desc limit $start,$limit";
			$totalcount_arr=DB::query(Database::SELECT,"select count(*) as num from sline_zt  where $w")->execute()->as_array();
			$list=DB::query(Database::SELECT,$sql)->execute()->as_array();
			
			$result['total']=$totalcount_arr[0]['num'];
			$result['lists']=$list;
            $result['success']=true;
			echo json_encode($result);
		}
		else if($action=='delete') //删除某个记录
		{
		   
		   $rawdata=file_get_contents('php://input');
		   $data=json_decode($rawdata);
		   $id=$data->id;   
		   if(is_numeric($id)) 
		   {
		    $model=ORM::factory('zt',$id);
		    $model->delete_clear();
		   } 
		}
		else if($action=='update')//更新某个字段
		{
			$id=Arr::get($_POST,'id');
			$field=Arr::get($_POST,'field');
			$val=Arr::get($_POST,'val');

            $value_arr[$field] = $val;
            $isupdated = DB::update('theme')->set($value_arr)->where('id','=',$id)->execute();
            if($isupdated)
                echo 'ok';
            else
                echo 'no';
		}
	}
	/*
	 *修改专题
	*/
	public function action_edit()
	{

	    $themeid = $this->params['themeid'];
        $this->assign('action','edit');
        $info = ORM::factory('zt',$themeid)->as_array();
        $this->assign('info',$info);
        $this->assign('position','修改专题');
        //pc模板
        $this->assign('pc_templet_list',Model_Zt::get_usertpl());
        //手机模板
        $this->assign('m_templet_list',Model_Zt::get_usertpl(1));
        $this->display('admin/zt/edit');
	}
	
	/*
	*添加专题
	*/
	public function action_add()
	{
		$this->assign('action','add');
        $this->assign('position','添加专题');
        //pc模板
        $this->assign('pc_templet_list',Model_Zt::get_usertpl());
        //手机模板
        $this->assign('m_templet_list',Model_Zt::get_usertpl(1));
        $this->display('admin/zt/edit');
	}
    /*
     * 专题保存
     * */
	public function action_ajax_save()
	{
		$themeid=Arr::get($_POST,'themeid');
        $data_arr=array();
        $data_arr['title']=Arr::get($_POST,'ztname');

        $data_arr['introduce']=Arr::get($_POST,'introduce') ? Arr::get($_POST,'introduce') : '';
		$data_arr['bgcolor']=Arr::get($_POST,'bgcolor') ? Arr::get($_POST,'bgcolor') : '';
        $data_arr['pc_banner'] = Arr::get($_POST,'pc_banner') ? Arr::get($_POST,'pc_banner') : '';
        $data_arr['bgimage']=Arr::get($_POST,'bgimage') ? Arr::get($_POST,'bgimage') : '';
        $data_arr['m_banner']=Arr::get($_POST,'m_banner') ? Arr::get($_POST,'m_banner') : '';

		$data_arr['pc_templet']=Arr::get($_POST,'pc_templet') ? Arr::get($_POST,'pc_templet') : '';
        $data_arr['m_templet'] = Arr::get($_POST,'m_templet') ? Arr::get($_POST,'m_templet') : '';
        $data_arr['pinyin'] = Arr::get($_POST,'pinyin') ? Arr::get($_POST,'pinyin') : '';
        $data_arr['ishidden'] = Arr::get($_POST,'ishidden') ? Arr::get($_POST,'ishidden') : 0;
		
        $data_arr['seotitle']=Arr::get($_POST,'seotitle');
        $data_arr['keyword']=Arr::get($_POST,'keyword');
        $data_arr['tagword']=Arr::get($_POST,'tagword');
        $data_arr['description']=Arr::get($_POST,'description');
        $data_arr['bgrepeat']=Arr::get($_POST,'bgrepeat');
        if($themeid)
        {
            $data_arr['modtime'] = time();
            $flag = DB::update('zt')->set($data_arr)->where('id','=',$themeid)->execute();
            $result = $themeid;
            //保存channel 信息
            if(!empty($_POST['channelname']))
            {
                $m = new Model_Zt_Channel();
                $m->update($_POST);
            }
        }
        else
        {
            $data_arr['addtime'] = time();
            $row = DB::insert('zt',array_keys($data_arr))->values(array_values($data_arr))->execute();
            $result = $row[0] ? $row[0] : 0;
        }
        if($result)
        {
            echo $result;
        }
        else
            echo 'no';
		
	}


    /**
     * 添加栏目
     */
    public function action_ajax_add_channel()
    {
        $ztid = intval(Arr::get($_POST,'ztid'));
        $m = new Model_Zt_Channel();
        $channelid = $m->add($ztid);
        echo json_encode(array('channelid'=>$channelid));

    }

    /**
     * 获取栏目详细信息
     */
    public function action_ajax_channel_info()
    {
        $channelid = intval(Arr::get($_POST,'channelid'));
        $m = new Model_Zt_Channel();
        $channel_info = $m->detail($channelid);
        echo json_encode($channel_info);
    }

    /**
     * 专题栏目列表
     */
    public function action_ajax_channel_list()
    {
        $ztid = intval(Arr::get($_POST,'ztid'));
        $list = DB::select()->from('zt_channel')->where('ztid','=',$ztid)->execute()->as_array();
        if($list)
        {
            echo json_encode($list);
        }

    }

    /**
     * 删除专题栏目
     */
    public function action_ajax_delete_channel()
    {
        $channelid = intval(Arr::get($_POST,'channelid'));
        $flag = 0;
        if($channelid)
        {
           $flag = DB::delete('zt_channel')->where('id','=',$channelid)->execute();
        }
        echo json_encode(array('status'=>$flag));

    }

    /**
     * 选择产品
     */
    public function action_dialog_get_products()
    {
        $kindtype = intval($this->params['kindtype']);
        $channelid = intval($this->params['channelid']);
        $this->assign('kindtype',$kindtype);
        $this->assign('channelid',$channelid);
        if($kindtype != 1)
        {
            $m = new Model_Zt();
            $channel_arr = $m->get_need_product($kindtype);
            $this->assign('channel_arr',$channel_arr);
            $this->display('admin/zt/dialog_get_products');
        }
        else  //优惠券
        {
            $this->display('admin/zt/dialog_get_coupon');
        }
    }

    //ajax获取产品/文章列表(dialog里使用)
    public function action_ajax_get_products()
    {
        $typeid = intval($_POST['typeid']);
        $keyword = $_POST['keyword'];
        $keyword = Common::getKeyword($keyword);
        $page = intval($_POST['page']);
        $page = $page<1?1:$page;
        $pagesize = 10;
        $offset = $pagesize*($page-1);

        $info = Model_Model::get_module_info($typeid);
        $table = 'sline_'.$info['maintable'];
        //模块存在自定义搜索列表
        $infoModel = 'Model_' . $info['maintable'];
        if (is_callable(array($infoModel, 'list_search')))
        {
            echo json_encode($infoModel::list_search(array('page'=>$page,'pagesize'=>$pagesize,'offset'=>$offset,'keyword'=>$keyword)));
            exit;
        }
        $w = " where id >0 ";
        if(!empty($keyword))
        {
            $w.=" and title like '%{$keyword}%' or id='{$keyword}'";
        }
        if($table == 'sline_model_archive')
        {
            $w.= " and typeid='$typeid'";
        }
        $sql = "select id,webid,aid,title from {$table} {$w} and ishidden = 0 order by modtime desc limit {$offset},{$pagesize}";
        $sql_num = "select count(*) as num from {$table} {$w} and ishidden = 0";
        $list = DB::query(Database::SELECT,$sql)->execute()->as_array();
        $num = DB::query(Database::SELECT,$sql_num)->execute()->get('num');

        $path = empty($info['correct'])?$info['pinyin']:$info['correct'];
        foreach($list as &$v)
        {
            $v['series'] =St_Product::product_series($v['id'], $typeid);//编号
            $v['url'] = Common::getBaseUrl($v['webid']) . '/'.$path.'/show_' . $v['aid'] . '.html';
        }
        echo json_encode(array('list'=>$list,'pagesize'=>$pagesize,'page'=>$page,'total'=>$num));
    }

    /**
     * 保存栏目选择的产品
     */
    public function action_ajax_set_channel_product()
    {
        $channelid = intval(Arr::get($_POST,'channelid'));
        $typeid = intval(Arr::get($_POST,'typeid'));
        $productids = Arr::get($_POST,'productids');
        $productids_arr = explode(',',$productids);
        Model_Zt_Channel_Product::add_product($channelid,$typeid,$productids_arr);
        echo json_encode(array('status'=>true,'channelid'=>$channelid));

    }

    /**
     * 获取专题栏目保存的产品
     */
    public function action_ajax_get_channel_product()
    {

        $channelid = $_POST['channelid'];
        $page = intval($_POST['page']);
        $page = $page<1?1:$page;
        $pagesize = 8;
        //get total num
        $total = Model_Zt_Channel_Product::get_total_num($channelid);
        if(empty($total))
        {
            echo json_encode(array('list'=>null,'pagesize'=>0,'page'=>0,'total'=>0));
            return;
        }
        $list = Model_Zt_Channel_Product::get_product($channelid,$page,$pagesize);
        echo json_encode(array('list'=>$list,'pagesize'=>$pagesize,'page'=>$page,'total'=>$total));

    }

    /**
     * 移除产品
     */
    public function action_ajax_remove_channel_product()
    {
        $id = intval(Arr::get($_POST,'id'));
        $flag = Model_Zt_Channel_Product::remove_product($id);
        echo json_encode(array('status'=>$flag));
    }

    /**
     * 设置产品排序
     */
    public function action_ajax_set_product_displayorder()
    {
        $id = intval(Arr::get($_POST,'id'));
        $displayorder = intval(Arr::get($_POST,'displayorder'));
        if(!empty($id))
        {
            $flag = Model_Zt_Channel_Product::set_displayorder($id,$displayorder);
            echo json_encode(array('status'=>$flag));
        }
    }

    /********************************优惠券模块***********************************************/

    /*
     * 获取优惠券列表(dialog里使用)
     * */

    public function action_ajax_get_coupon()
    {

        $page = intval($_POST['page']);
        $page = $page<1?1:$page;
        $pagesize = 10;
        $offset = $pagesize*($page-1);
        $table = 'sline_coupon';
        $w = " where isopen=1 and isdel=0";

        $sql = "select * from {$table} {$w} order by addtime desc limit {$offset},{$pagesize}";
        $sql_num = "select count(*) as num from {$table} {$w}";
        $list = DB::query(Database::SELECT,$sql)->execute()->as_array();
        $num = DB::query(Database::SELECT,$sql_num)->execute()->get('num');
        foreach($list as &$v)
        {
            $v = Model_Zt_Channel_Coupon::get_coupon_info($v['id'],true);
        }
        echo json_encode(array('list'=>$list,'pagesize'=>$pagesize,'page'=>$page,'total'=>$num));
    }

    /**
     * 对话框保存已设置好的优惠券
     */
    public function action_ajax_set_channel_coupon()
    {
        $channelid = intval(Arr::get($_POST,'channelid'));
        $couponids = Arr::get($_POST,'couponids');
        $productids_arr = explode(',',$couponids);
        Model_Zt_Channel_Coupon::add_coupon($channelid,$productids_arr);
        echo json_encode(array('status'=>true,'channelid'=>$channelid));

    }

    /**
     * 获取专题栏目保存的优惠券
     */
    public function action_ajax_get_channel_coupon()
    {

        $channelid = $_POST['channelid'];
        $page = intval($_POST['page']);
        $page = $page<1?1:$page;
        $pagesize = 8;
        //get total num
        $total = Model_Zt_Channel_Coupon::get_total_num($channelid);
        if(empty($total))
        {
            echo json_encode(array('list'=>null,'pagesize'=>0,'page'=>0,'total'=>0));
            return;
        }
        $list = Model_Zt_Channel_Coupon::get_coupon($channelid,$page,$pagesize,true);
        echo json_encode(array('list'=>$list,'pagesize'=>$pagesize,'page'=>$page,'total'=>$total));

    }
    /**
     * 移除优惠券
     */
    public function action_ajax_remove_channel_coupon()
    {
        $id = intval(Arr::get($_POST,'id'));
        $flag = Model_Zt_Channel_Coupon::remove_coupon($id);
        echo json_encode(array('status'=>$flag));
    }



    /********************************优惠券模块结束***********************************************/


    /**
     * 检测拼音是否重复
     */
    public function action_ajax_check_pinyin()
    {
        $pinyin = Arr::get($_POST,'pinyin');
        $themeid = intval(Arr::get($_POST,'themeid'));
        $id = DB::select('id')->from('zt')->where('pinyin','=',$pinyin)->and_where('id','!=',$themeid)->execute()->get('id');
        $status =  $id ? 0 : 1;
        echo json_encode(array('status'=>$status));


    }




    public function action_file_update()
    {

        $field = Arr::get($_POST,'field');
        $val = Arr::get($_POST,'val');
        $id = Arr::get($_POST,'id');
        $update =array();
        $update[$field] = $val;
        DB::update('zt')->set($update)->where("id=$id")->execute();

    }

}