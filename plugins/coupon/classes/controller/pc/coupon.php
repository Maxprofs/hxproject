<?php defined('SYSPATH') or die('No direct script access.');



class Controller_Pc_Coupon extends Stourweb_Controller
{



    public function before()
    {
        parent::before();

    }


    /**
     * 优惠券首页
     */
    public function action_index()
    {
        $main_host = DB::select('weburl')->from('weblist')->where('webid=0')->execute()->get('weburl');
        if($GLOBALS['cfg_basehost']!=$main_host)
        {
            $this->request->redirect($main_host.'/coupon');
        }
        $p = intval($this->request->param('p'));
        $typeid = intval($this->request->param('typeid'));
        $proid = intval($this->request->param('proid'));
        $pagesize = 12;
        $route_array = array(
            'controller' => $this->request->controller(),
            'action' => $this->request->action(),
            'typeid' => $typeid,
            'proid' => $proid,
        );
        $out = Model_Coupon::search_result($route_array, $p, $pagesize,$typeid,$proid);
        $pager = Pagination::factory(
            array(
                'current_page' => array('source' => 'route', 'key' => 'p'),
                'view' => 'default/pagination/search',
                'total_items' => $out['total'],
                'items_per_page' => $pagesize,
                'first_page_in_url' => false,
            )
        );

        $redirecturl = urlencode(Common::get_current_url());
        $this->assign('redirecturl',$redirecturl);


        //配置访问地址 当前控制器方法
        $pager->route_params($route_array);
        $this->assign('list', $out['list']);
        $this->assign('param', $route_array);
        $this->assign('currentpage', $p);
        $this->assign('pageinfo', $pager);
        $this->display('coupon/index');



    }

    /**
     * @ｆｕｎｃｔｉｏｎ 领取优惠券
     */
    public function action_ajxa_get_coupon()
    {
        //会员信息
        $userInfo = Product::get_login_user_info();
        //要求领取前必须登陆
        if (empty($userInfo['mid']))
        {
           $out = array('msg'=>'领取失败,请先登陆','status'=>1);
        }
        else
        {

            $cid = intval(Arr::get($_POST,'cid'));
            $flag = Model_Coupon::check_receive_status($cid);
            switch($flag['status'])
            {
                case 1:
                    $result =  Model_Coupon::get_coupon($cid,$userInfo['mid']);
                    if($result)
                        $out = array('msg'=>'领取成功!','status'=>2);
                    break;
                case 2:
                    $out = array('msg'=>'领取失败,该优惠券已经领完','status'=>0);
                    break;
                case 3:
                    $out = array('msg'=>'领取失败,您已经领取过该优惠券','status'=>0);
                    break;
                case 4:
                    $out = array('msg'=>'领取失败,您的会员等级不满足条件','status'=>0);
                    break;

            }
        }

        echo json_encode($out);
    }


    /**
     * 预定页优惠券模块
     */
    public function action_box()
    {
        $typeid = intval($this->request->param('typeid'));
        $proid = intval($this->request->param('proid'));
        $out = Model_Coupon::get_pro_coupon($typeid,$proid);
        $this->assign('list',$out);
        $this->assign('typeid',$typeid);
        $this->assign('proid',$proid);
        $this->display('coupon/book/box');
    }


    /**
     * 检查是否符合优惠条件
     */
    public function action_ajax_check_samount()
    {
        $roleid = intval(Arr::get($_POST,'couponid'));
        $totalprice =floatval(Arr::get($_POST,'totalprice'));
        $typeid =intval(Arr::get($_POST,'typeid'));
        $proid =intval(Arr::get($_POST,'proid'));
        $starttime = Arr::get($_POST,'startdate');
        $out =  Model_Coupon::check_samount($roleid,$totalprice,$typeid,$proid,$starttime);
        echo json_encode($out);
    }
  /**
     * 优惠券浮动框
     */
    public function action_float_box()
    {

        $typeid = $this->request->param('typeid');
        $proid = $this->request->param('proid');
        $this->assign('typeid',$typeid);
        $this->assign('proid',$proid);
        $this->display('coupon/f_get_box');
    }


    /**
     * 浮动框列表内容
     */
    public function action_ajax_get_float_list()
    {
        $typeid = intval(Arr::get($_POST,'typeid'));
        $proid = intval(Arr::get($_POST,'proid'));
        $out = Model_Coupon::search_result('', 1, 3,$typeid,$proid);
        echo json_encode($out);

    }




    /**
     * @function  立即使用列表
     */
    public function action_search()
    {
        $cid = $this->request->param('cid');

        if(is_numeric($cid))
        {
            $couponinfo = DB::select('typeid','modules','name')->from('coupon')->where("id=$cid")->execute()->current();
            $typeid = intval(Arr::get($_GET,'typeid'));
            if($couponinfo['typeid']==0)
            {
                $this->request->redirect($GLOBALS['cfg_basehost']);
            }
            if($couponinfo['typeid']==1)
            {
                $where = " typeid in ({$couponinfo['modules']})";

                $product_list = $couponinfo['modules'];
            }
            else
            {
                $product_list = DB::select('proid','typeid')->from('coupon_pro')->where("cid=$cid")->execute()->as_array();
                $where = '';
                $k = 1;
                foreach($product_list as $product)
                {
                    if($k==1)
                    {
                        $where .=" (typeid={$product['typeid']} and tid={$product['proid']})";
                    }
                    else
                    {
                        $where .=" or (typeid={$product['typeid']} and tid={$product['proid']})";
                    }
                    $k++;
                }
                $where = "($where)";
            }
            $leftnav = Model_Coupon::get_search_left_nav($where,$product_list);
            $this->assign('leftnav',$leftnav);
            $route_array = array(
                'controller'=>$this->request->controller(),
                'action'=>$this->request->action(),
                'cid'=>$cid
            );
            $pagesize = 10;
            $p = intval(Arr::get($_GET,'p'));
            if($typeid)
            {
                $where .= " and typeid=$typeid";
            }
            $out = Model_Coupon::search_search_result($route_array,$where,$p,$pagesize);
            $pager = Pagination::factory(
                array(

                    'current_page' => array('source' => 'query_string', 'key' => 'p'),
                    'view'=>'default/pagination/search',
                    'total_items' => $out['total'],
                    'items_per_page' => $pagesize,
                    'first_page_in_url' => false,
                )
            );
            //配置访问地址 当前控制器方法
            $pager->route_params($route_array);
            $this->assign('couponinfo',$couponinfo);
            $this->assign('typeid',$typeid);
            $this->assign('list',$out['list']);
            $this->assign('total',$out['total']);
            $this->assign('cid',$cid);
            $this->assign('pageinfo',$pager);
            $this->display('coupon/cloudsearch');

        }
        else
        {
            $this->request->redirect('/error/404',404);
        }

    }


    public  function action_integral_home()
    {
        //必须安装积分商城
        if(!St_Functions::is_system_app_install(107))
        {
            $this->request->redirect('/error/404',404);
        }
        $redirecturl = urlencode(Common::get_current_url());
        $this->assign('redirecturl',$redirecturl);

        $route_array = array(
            'controller'=>$this->request->controller(),
            'action'=>$this->request->action(),
        );
        $p = 1;
        $pagesize = 4;
        $out = Model_Coupon::search_result($route_array, $p, $pagesize,null,null,2);
        $list = $out['list'];
        foreach($list as &$l)
        {
            $l['litpic']  = $GLOBALS['cfg_basehost'].'/plugins/coupon/public/images/integral.jpg';

        }
        $this->assign('list',$list);
        $this->display('coupon/integral/home');


    }
    public  function action_integral_all()
    {

            //必须安装积分商城
        if(!St_Functions::is_system_app_install(107))
        {
            $this->request->redirect('/error/404',404);
        }
        $redirecturl = urlencode(Common::get_current_url());
        $this->assign('redirecturl',$redirecturl);

        $route_array = array(
            'controller'=>$this->request->controller(),
            'action'=>$this->request->action(),
        );
        $p = intval(Arr::get($_GET,'p'));
        $pagesize = 20;
        $out = Model_Coupon::search_result($route_array, $p, $pagesize,null,null,2);
        $pager = Pagination::factory(
            array(
                'current_page' => array('source' => 'query_string', 'key' => 'p'),
                'view' => 'default/pagination/search',
                'total_items' => $out['total'],
                'items_per_page' => $pagesize,
                'first_page_in_url' => false,
            )
        );
        $list = $out['list'];
        foreach($list as &$l)
        {
            $l['litpic']  = $GLOBALS['cfg_basehost'].'/plugins/coupon/public/images/integral.jpg';

        }
        $type = DB::select()->from('integral_attr')->where('isopen', '=', 1)->execute()->as_array();
        $this->assign('type',$type);
        $this->assign('result',$list);
        $this->assign('pager',$pager);
        $this->display('coupon/integral/list');


    }


    /**
     * 积分商城详情
     */
    public function action_integral_show()
    {

        //必须安装积分商城
        if(!St_Functions::is_system_app_install(107))
        {
            $this->request->redirect('/error/404',404);
        }
        $cid = Arr::get($_GET,'cid');
        $userInfo = Product::get_login_user_info();
        if(is_numeric($cid))
        {
            $info = Model_Coupon::get_integral_info($cid,$userInfo['mid']);
        }

        $this->assign('member',$userInfo);
        $this->assign('info',$info);

        $this->display('coupon/integral/show');


    }



    /**
     * 积分商城领取优惠券
     */
    public function action_ajxa_get_coupon_from_integral()
    {


        //会员信息
        $userInfo = Product::get_login_user_info();
        //要求领取前必须登陆
        if (empty($userInfo['mid']))
        {
            $out = array('msg'=>'领取失败,请先登陆','status'=>1);
        }
        else
        {
            $cid = intval(Arr::get($_POST,'cid'));
            $flag = Model_Coupon::check_receive_status($cid);
            switch($flag['status'])
            {
                case 1:
                    $couponinfo = DB::select('needjifen','name')->from('coupon')->where("id=$cid and kindid=2")->execute()->current();
                    if($userInfo['jifen']<$couponinfo['needjifen'])
                    {
                        $out = array('msg'=>'领取失败,您的积分不足以兑换该优惠券','status'=>0);
                    }
                    else
                    {
                        $result =  Model_Coupon::get_coupon($cid,$userInfo['mid']);
                        if($result)
                        {
                            try
                            {
                                //扣除积分并写入日志
                                DB::update('member')->set(array('jifen'=>DB::expr('jifen-'.$couponinfo['needjifen'])))->where('mid','=',$userInfo['mid'])->execute();
                                $content = "兑换优惠券<{$couponinfo['name']}>使用{$couponinfo['needjifen']}积分";
                                St_Product::add_jifen_log($userInfo['mid'], $content,$couponinfo['needjifen'], 1);
                                $out = array('msg'=>'领取成功!','status'=>2);
                            }
                            catch(Exception $e)
                            {
                                //删除优惠券
                                DB::delete('coupon')->where("id={$result[0]} and cid=$cid")->execute();
                                $out = array('msg'=>'领取失败!','status'=>0);
                            }
                        }

                    }
                    break;
                case 2:
                    $out = array('msg'=>'领取失败,该优惠券已经领完','status'=>0);
                    break;
                case 3:
                    $out = array('msg'=>'领取失败,您已经领取过该优惠券','status'=>0);
                    break;
                case 4:
                    $out = array('msg'=>'领取失败,您的会员等级不满足条件','status'=>0);
                    break;

            }
        }

        echo json_encode($out);

    }







}