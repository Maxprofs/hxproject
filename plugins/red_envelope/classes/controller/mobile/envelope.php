<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Created by PhpStorm.
 * Author: daisc
 * QQ: 2444329889
 * Time: 2018/04/02 14:03
 * Desc: desc
 */
class Controller_Mobile_Envelope extends Stourweb_Controller
{

    function before()
    {
        parent::before();

    }

    public function action_order_view()
    {
        $ordersn = $this->params['ordersn'];
        if($ordersn)
        {
            $info = Model_Order_Envelope::order_show($ordersn);
            if($info)
            {
                $baseurl =Common::get_web_url(0);

                //$url = rtrim($baseurl,'//') .'/'.'envelope/view';
                $url = rtrim($baseurl,'//') .'/'.'envelope/view/params/'.base64_encode($info['id']);
                $this->assign('url',$url);
                $this->assign('info',$info);
                $this->display('../mobile/envelope/order_view');
            }
        }
    }




    public function action_view()
    {
        $envelope_order_id = intval(base64_decode($this->params['params'])) ;
        $member_new =  Common::session('envelope_new_member');
        if(!$envelope_order_id)
        {
            exit('params error!');
        }
        //判断是否登陆
        $userinfo = Model_Member_Login::check_login_info();
        if(!isset($userinfo['mid']))
        {
            Common::session('envelope_order_id',$envelope_order_id);
            $this->request->redirect('member/login');
        }
        else
        {



            Model_Order_Envelope::add_envelope_member($userinfo['mid'],$envelope_order_id,$member_new);
            list($list,$own,$has_max) = Model_Order_Envelope::get_envelope_show_list($envelope_order_id,$userinfo['mid']);
            if(empty($list))
            {
                exit('params error!');
            }
            $ordersn = DB::select('ordersn')->from('envelope_order')->where('id','=',$envelope_order_id)->execute()->get('ordersn');
            $info = Model_Order_Envelope::order_show($ordersn,true);

            $baseurl =Common::get_web_url(0);
            $url = rtrim($baseurl,'//') .'/'.'envelope/view/params/'.base64_encode($info['id']);
            $this->assign('url',$url);
            $this->assign('info',$info);


            $envelope_id = $list[0]['envelope_id'];
            $config = DB::select('description')->from('envelope')->where('id','=',$envelope_id)
            ->execute()->get('description');
            $this->assign('config',$config);
            $this->assign('list',$list);
            $this->assign('own',$own);
            $this->assign('has_max',$has_max);
            $this->display('../mobile/envelope/view');
        }

    }

    public function action_product_book()
    {
        $typeid = intval($this->params['typeid']);
        $member = Model_Member_Login::check_login_info();
        $mid = $member['mid'];
        if($typeid&&$mid)
        {
            $list = Model_Order_Envelope::get_book_envelope($typeid,$mid);
            $this->assign('list',$list);
            $this->display('../mobile/envelope/product_book');
        }

    }




}