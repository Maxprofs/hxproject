<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Pc_Api_Standard_Order extends Controller_Pc_Api_Base
{
    public function before()
    {
        parent::before();
    }

    /*
    * 获取订单状态列表
    */
    public function action_get_status_list()
    {
        $result = Model_Api_Standard_Order::get_status_list();
        $this->send_datagrams($this->client_info['id'], $result, $this->client_info['secret_key']);

    }

    /*
    * 获取订单支付类型列表
    */
    public function action_get_paytype_list()
    {
        $result = Model_Api_Standard_Order::get_paytype_list();
        $this->send_datagrams($this->client_info['id'], $result, $this->client_info['secret_key']);

    }

    public function action_search()
    {
        $condition = array();
        $condition['typeid'] = Common::remove_xss($this->request_body->content->model_type_id);
        $condition['status'] = Common::remove_xss($this->request_body->content->status);
        $condition['keyword'] = Common::remove_xss($this->request_body->content->keyword);
        $condition['paysource'] = Common::remove_xss($this->request_body->content->paysource);
        $condition['start_time'] = Common::remove_xss($this->request_body->content->start_time);
        $condition['end_time'] = Common::remove_xss($this->request_body->content->end_time);
        $condition['eticketno'] = Common::remove_xss($this->request_body->content->eticketno);
        $condition['memberid'] = Common::remove_xss($this->request_body->content->memberid);
        $condition['isconsume'] = Common::remove_xss($this->request_body->content->isconsume);
        $condition['webid'] = Common::remove_xss($this->request_body->content->webid);
        $condition['webid'] = (is_numeric($condition['webid']) ? $condition['webid'] : -1);

        $condition['start'] = Common::remove_xss($this->request_body->content->page->start);
        $condition['limit'] = Common::remove_xss($this->request_body->content->page->limit);
        $condition['sort'] = array();
        if ($this->request_body->content->sort->property)
        {
            $condition['sort']['property'] = Common::remove_xss($this->request_body->content->sort->property);
            if ($this->request_body->content->sort->direction)
            {
                $condition['sort']['direction'] = Common::remove_xss($this->request_body->content->sort->direction);
            } else
            {
                $condition['sort']['direction'] = "asc";
            }
        }

        $result = Model_Api_Standard_Order::search($condition);

        $this->send_datagrams($this->client_info['id'], $result, $this->client_info['secret_key']);
    }

    public function action_get_detail()
    {
        $id = Common::remove_xss($this->request_body->content->id);

        $result = Model_Api_Standard_Order::get_detail($id);
		
        if (empty($result))
        {
            $this->send_datagrams($this->client_info['id'], $result, $this->client_info['secret_key'], false, "查找订单信息失败", "查找订单信息失败");
        } else
        {
            $this->send_datagrams($this->client_info['id'], $result, $this->client_info['secret_key']);
        }
    }

    public function action_statistics_annual_report()
    {
        $year = Common::remove_xss($this->request_body->content->year);
        $model_type_id = Common::remove_xss($this->request_body->content->model_type_id);

        $current_year = date('Y');
        $year = empty($year) ? $current_year : $year;
        if ($year > $current_year)
        {
            $this->send_datagrams($this->client_info['id'], null, $this->client_info['secret_key'], false, "统计年份不能超过今年", "统计年份不能超过今年");
        }

        $result = Model_Api_Standard_Order::statistics_annual_report($year, $model_type_id);

        $this->send_datagrams($this->client_info['id'], $result, $this->client_info['secret_key']);
    }

    public function action_statistics_monthly_report()
    {
        $model_type_id = Common::remove_xss($this->request_body->content->model_type_id);

        $result = Model_Api_Standard_Order::statistics_monthly_report($model_type_id);

        $this->send_datagrams($this->client_info['id'], $result, $this->client_info['secret_key']);
    }

    public function action_change_status()
    {
        $id = Common::remove_xss($this->request_body->content->id);
        $result = Model_Api_Standard_Order::get_detail($id);
        $ordersn = $result['ordersn'];
        St_Payment::change_order($ordersn, '微信小程序');
        $detectresult = Model_Member_Order_listener::detect($ordersn);
        $out = array('status'=>1);
        $this->send_datagrams($this->client_info['id'], $out, $this->client_info['secret_key']);


    }
	
	public function action_cancelOrder()
	{
		$ordersn = Common::remove_xss($this->request_body->content->ordersn);
        $result = Model_Api_Standard_Order::cancelOrder($ordersn);
		$this->send_datagrams($this->client_info['id'], $result, $this->client_info['secret_key']);
	}
	



}