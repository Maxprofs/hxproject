<?php defined('SYSPATH') or die('No direct script access.');



class Controller_Mobile_Coupon extends Stourweb_Controller
{

    private $_cache_key = '';
    public function before()
    {
        parent::before();


    }
    /**
     * 优惠券首页
     */
    public function action_index()
    {
        $p = intval($this->request->param('p'));
        $productid = intval($this->request->param('productid'));
        $typeid = intval($this->request->param('typeid'));
        //配置访问地址 当前控制器方法
        if($typeid&&$productid)
        {
            $fromurl = $_SERVER['HTTP_REFERER'];
            if(strpos($fromurl,'show')=== false)
            {
                $fromurl = URL::site();
            }
            $this->assign('fromurl',$fromurl);
        }
        $this->assign('img_url',$GLOBALS['cfg_m_img_url']);
        $this->assign('productid',$productid);
        $this->assign('typeid',$typeid);
        $this->display('../mobile/coupon/index');
    }


    public  function action_ajax_get_list()
    {
        $p = intval(Arr::get($_POST,'page'));
        $productid = intval(Arr::get($_POST,'productid'));
        $typeid = intval(Arr::get($_POST,'typeid'));
        $pagesize = 12;
        $route_array = array(
            'controller' => $this->request->controller(),
            'action' => $this->request->action(),
        );
        $out = Model_Coupon::search_result($route_array, $p, $pagesize,$typeid,$productid);
        $list =  Model_Coupon::get_data($out['list']);
        if(empty($list))
        {
            echo json_encode(array('status'=>1));
        }
        else
        {
            echo json_encode(array('list'=>$list));
        }
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
        else{
            $cid = intval(Arr::get($_POST,'cid'));
            $flag = Model_Coupon::check_receive_status($cid);
            switch($flag['status'])
            {
                case 1:
                    $result =  Model_Coupon::get_coupon($cid,$userInfo['mid']);
                    if($result)
                    {
                        $fromurl = $this->cmsurl.'coupon/search-'.$cid;
                        $out = array('msg'=>'领取成功!','status'=>2,'fromurl'=>$fromurl);
                    }
                    break;
                case 2:
                    $out = array('msg'=>'领取失败,该优惠券已经领完','status'=>0);
                    break;
                case 3:
                    $out = array('msg'=>'领取失败,您已经领取过该优惠券','status'=>0);
                    break;
                case 4:
                    $out = array('msg'=>'领取失败,会员等级不满足领取条件','status'=>0);
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

        //必须登陆才能使用
        $userInfo = Product::get_login_user_info();
        if(empty($userInfo))
        {
            return false;
        }
        $typeid = intval($this->request->param('typeid'));
        $proid = intval($this->request->param('proid'));
        $out = Model_Coupon::get_pro_coupon($typeid,$proid);
        $this->assign('list',$out);
        $this->assign('typeid',$typeid);
        $this->assign('proid',$proid);
        $this->display('../mobile/coupon/book/box');
    }

    public function action_box_new()
    {

        //必须登陆才能使用
        $userInfo = Product::get_login_user_info();
        if(empty($userInfo))
        {
            return false;
        }
        $typeid = intval($this->request->param('typeid'));
        $proid = intval($this->request->param('proid'));
        $out = Model_Coupon::get_pro_coupon($typeid,$proid);
        $this->assign('list',$out);
        $this->assign('typeid',$typeid);
        $this->assign('proid',$proid);
        $template=isset($_GET['template'])?$_GET['template']:'box_new';
        $this->display('../mobile/coupon/book/'.$template);
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
        $startdate =Arr::get($_POST,'startdate');
        $out =  Model_Coupon::check_samount($roleid,$totalprice,$typeid,$proid,$startdate);
        echo json_encode($out);
    }

  /**
     * 手机版产品详情，领取优惠券
     */
    public function action_float_box()
    {
        $typeid = intval($this->request->param('typeid'));
        $proid = intval($this->request->param('proid'));
        $info = Model_Coupon::get_mobile_coupon_info($typeid,$proid);
        $this->assign('coupon',$info);
        $this->display('../mobile/coupon/f_get_box');
    }


    /**
     * @function  立即使用列表
     */
    public function action_search()
    {
        $cid = $this->request->param('cid');
        $typeid = intval(Arr::get($_GET,'typeid'));
        $keyword = intval(Arr::get($_GET,'keyword'));
        if(is_numeric($cid))
        {
            $couponinfo = DB::select('typeid','modules','name')->from('coupon')->where("id=$cid")->execute()->current();
            if($couponinfo['typeid']==0)
            {
                $this->request->redirect($GLOBALS['cfg_basehost']);
            }
            $this->assign('page',1);
            $this->assign('typeid',$typeid);
            $this->assign('cid',$cid);
            $this->assign('keyword',$keyword);
            $this->display('../mobile/coupon/cloudsearch');

        }
        else
        {
            $this->request->redirect('/error/404',404);
        }

    }


    public function action_search_ajax_more()
    {

        $cid = Arr::get($_GET,'cid');
        $typeid = intval(Arr::get($_GET,'typeid'));
        $keyword = Common::remove_xss(Arr::get($_GET,'keyword'));
        if(is_numeric($cid))
        {
            $couponinfo = DB::select('typeid','modules','name')->from('coupon')->where("id=$cid")->execute()->current();

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

            if($keyword)
            {
                $where .=" and title like '%$keyword%'";
            }

            $leftnav = Model_Coupon::get_search_left_nav($where,$product_list);

            $route_array = array(
                'controller'=>$this->request->controller(),
                'action'=>$this->request->action(),
                'cid'=>$cid
            );
            $pagesize = 10;
            $p = intval(Arr::get($_GET,'page'));
            if($typeid)
            {
                $where .= " and typeid=$typeid";
            }
            $out = Model_Coupon::search_search_result($route_array,$where,$p,$pagesize);

            if($pagesize*$p<$out['total'])
            {
                $page = ++$p;
            }
            else
            {
                $page = -1;
            }
            $result = array(
                'typeArr'=>$leftnav,
                'list'=>$out['list'],
                'page'=>$page,
            );
           echo json_encode($result);

        }



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
        if(is_numeric($cid)&&$userInfo['mid'])
        {
            $userInfo  = Model_Member::get_member_info($userInfo['mid']);
            $info = Model_Coupon::get_integral_info($cid,$userInfo['mid']);
        }
        $info['litpic'] = $GLOBALS['cfg_basehost'].'/plugins/coupon/public/mobile/images/integral_show.jpg';
        $this->assign('member',$userInfo);
        $this->assign('info',$info);

        $this->display('../mobile/coupon/integral/show');
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
            $userInfo  = Model_Member::get_member_info($userInfo['mid']);
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