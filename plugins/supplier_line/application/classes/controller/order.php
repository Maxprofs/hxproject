<?php defined('SYSPATH') or die('No direct script access.');

/**
 *
 */
class Controller_Order extends Stourweb_Controller
{
    //默认对象

    private $_typeid = 1;

    /**
     * 初始化
     */
    public function before()
    {
        parent::before();
        $this->_model = new Model_Member_Order();
    }

    /**
     * 全部订单
     */
    public function action_all()
    {
        $pagesize = Arr::get($_GET,'pagesize');
        $pagesize = !empty($pagesize) ? $pagesize : 30;
        $model = new Model_Member_Order();
        $data = $model->get_my_order_list($this->_typeid,$pagesize);
        $this->assign('statusarr',Model_Member_Order::get_changeable_statusnames());
        $this->assign('data', $data);
        $this->assign('get', $_GET);
        $this->display('order/all');
    }

    /**
     * 订单查看
     */
    public function action_show()
    {
        $id = intval($_GET['id']);
        $data = $this->_model->get_order_info($id);

        if(empty($data))
        {
            $this->request->redirect($this->request->referrer());
        }
        $w = "orderid={$data['id']}";
        $sql = "select * from sline_member_order_extend where $w";
        $r = DB::query(Database::SELECT, $sql)->execute()->current();
        $data['price']=$r['basicprice'];
        $data['childprice']=$r['childbasicprice'];
        $data['oldprice']=$r['oldbasicprice'];
        //是否是分销商订单
        if ($data['distributor']==$data['memberid']) {
            $this->assign('did',1);
        }else{
            $this->assign('did',0);
        }
        $this->assign('statusarr',Model_Member_Order::get_changeable_statusnames());
        $this->assign('info', $data);
        $this->display('order/show');
    }

    /**
     * 修改订单状态
     */
    public function action_ajax_order_status()
    {
        $supplierid = Cookie::get('st_supplier_id');
        $did = Common::remove_xss(Arr::get($_POST, 'did'));
        $dpayed = Common::remove_xss(Arr::get($_POST, 'payed'));
        $dpaydate = Common::remove_xss(Arr::get($_POST, 'paydate'));
        if ($did && ($dpaydate=='' || $dpayed=='')) {
            echo json_encode(array('status'=>false,'msg'=>'没有设置已付款金额或结款时间'));
            return;
        }
        $ordersn = Arr::get($_POST, 'ordersn');
        $status = Arr::get($_POST, 'status');
        $close_reason = Arr::get($_POST, 'content') ? Arr::get($_POST, 'content') : 0;
        $order_model = ORM::factory('member_order')->where('ordersn','=',$ordersn)->and_where('supplierlist','=',$supplierid)->find();
        if($order_model->loaded()&& in_array($status,Model_Member_Order::$changeableStatus) && in_array($order_model->status,Model_Member_Order::$changeableStatus))
        {
            if (Model_Member_Order::close_expire($order_model->id)) {
                echo json_encode(array('status'=>false,'msg'=>'订单过期已关闭'));
                return;
            }
            $order_model->status = $status;
            if ($status == 3) {
                $order_model->close_reason = $close_reason;
            }
            $order_model->dpayed=$dpayed;
            $order_model->dpaydate=$dpaydate;
            $order_model->save();
            if($order_model->saved())
            {
                $this->send_order_msgnotice($ordersn, $supplierid);
                echo json_encode(array('status'=>true,'msg'=>'修改成功'));
                return;
            }
        }
        echo json_encode(array('status'=>false,'msg'=>'修改错误'));
    }

    public function send_order_msgnotice($ordersn, $supplierid)
    {
        $order = DB::select()->from('member_order')->where('ordersn', '=', $ordersn)->and_where('supplierlist', '=', $supplierid)->execute()->current();
        if (empty($order))
        {
            return;
        }

        if ($order['status'] == 0)
        {
            St_SMSService::send_product_order_msg(NoticeCommon::PRODUCT_ORDER_UNPROCESSING_MSGTAG, $order);
            St_EmailService::send_product_order_email(NoticeCommon::PRODUCT_ORDER_UNPROCESSING_MSGTAG, $order);
        }
        if ($order['status'] == 1)
        {
            St_SMSService::send_product_order_msg(NoticeCommon::PRODUCT_ORDER_PROCESSING_MSGTAG, $order);
            St_EmailService::send_product_order_email(NoticeCommon::PRODUCT_ORDER_PROCESSING_MSGTAG, $order);
        }
        if ($order['status'] == 2)
        {
            St_SMSService::send_product_order_msg(NoticeCommon::PRODUCT_ORDER_PAYSUCCESS_MSGTAG, $order);
            St_EmailService::send_product_order_email(NoticeCommon::PRODUCT_ORDER_PAYSUCCESS_MSGTAG, $order);
        }
        if ($order['status'] == 3)
        {
            St_SMSService::send_product_order_msg(NoticeCommon::PRODUCT_ORDER_CANCEL_MSGTAG, $order);
            St_EmailService::send_product_order_email(NoticeCommon::PRODUCT_ORDER_CANCEL_MSGTAG, $order);
        }
    }

    public function action_excel()
    {
        $this->assign('typeid', $this->_typeid);
        $this->assign('statusnames', Model_Member_Order::$orderStatus);
        $this->display('order/excel');
    }

    public function action_genexcel()
    {
        $typeid = $this->_typeid;
        $timetype = $this->params['timetype'];
        $starttime = strtotime(Arr::get($_GET, 'starttime'));
        $endtime = strtotime(Arr::get($_GET, 'endtime'));
        $status = $_GET['status'];
        switch ($timetype)
        {
            case 1:
                $time_arr = St_Functions::back_get_time_range(1);
                break;
            case 2:
                $time_arr = St_Functions::back_get_time_range(2);
                break;
            case 3:
                $time_arr = St_Functions::back_get_time_range(3);
                break;
            case 5:
                $time_arr = St_Functions::back_get_time_range(5);
                break;
            case 6:
                $time_arr = array($starttime, $endtime);
                break;
        }

        $excel = Model_Member_Order::back_order_excel($time_arr, $typeid, $status);
        $filename = date('Ymdhis');
        ob_end_clean();//清除缓冲区
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
        echo iconv('utf-8', 'gbk', $excel);
        exit();
    }
}