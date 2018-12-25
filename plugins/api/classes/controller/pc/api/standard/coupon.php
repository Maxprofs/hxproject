<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Pc_Api_Standard_Coupon extends Controller_Pc_Api_Base
{
    public function before()
    {
        parent::before();
    }

    //优惠券列表
    public function action_receive_list()
    {
        $page = intval($this->request_body->content->page) or $page = 1;
        $pagesize = intval($this->request_body->content->pagesize) or $pagesize = 10;
        Common::session('member', array('mid' => $this->request_body->content->memberid));
        $route_array = array(
            'controller' => $this->request->controller(),
            'action' => $this->request->action(),
        );
        $out = Model_Coupon::search_result($route_array, $page, $pagesize, 0, 0);
        $result = Model_Coupon::get_data($out['list']);
        $this->send_datagrams($this->client_info['id'], $result, $this->client_info['secret_key']);
    }

    //获取优惠券
    public function action_receive()
    {
        $memberid = intval($this->request_body->content->memberid);
        $id = intval($this->request_body->content->id);
        $data = Model_Coupon::check_receive_status($id);
        $result = array('receive' => 0);
        if ($data['status'] == 1)
        {
            if (Model_Coupon::get_coupon($id, $memberid))
            {
                $result['receive'] = 1;
                Common::session('member', array('mid' => $memberid));
                $data = Model_Coupon::check_receive_status($id);
            }
        }
        $result['status'] = $data['status'];
        $this->send_datagrams($this->client_info['id'], $result, $this->client_info['secret_key']);
    }

    //会员优惠券
    public function action_own()
    {
        $page = intval($this->request_body->content->page) or $page = 1;
        $pagesize = intval($this->request_body->content->pagesize) or $pagesize = 10;
        Common::session('member', array('mid' => $this->request_body->content->memberid));
        $result = array();
        //未使用
        $params = array('isout' => 1, 'kindid' => 0);
        $out = Model_Coupon::member_search_result($params, $page, $pagesize);
        $result['use'] = Model_Coupon::get_data($out['list']);
        //已使用
        $params = array('isout' => 3, 'kindid' => 0);
        $out = Model_Coupon::member_search_result($params, $page, $pagesize);
        $result['used'] = Model_Coupon::get_data($out['list']);
        //已失效
        $params = array('isout' => 2, 'kindid' => 0);
        $out = Model_Coupon::member_search_result($params, $page, $pagesize);
        $result['nouse'] = Model_Coupon::get_data($out['list']);
        $this->send_datagrams($this->client_info['id'], $result, $this->client_info['secret_key']);
    }

    //可用优惠券
    public function action_use_list()
    {
        $type_id = Common::remove_xss($this->request_body->content->model_type_id);
        $product_id = Common::remove_xss($this->request_body->content->product_id);
        Common::session('member', array('mid' => $this->request_body->content->memberid));
        $result = Model_Coupon::get_pro_coupon($type_id, $product_id);
        $this->send_datagrams($this->client_info['id'], $result, $this->client_info['secret_key']);
    }


}