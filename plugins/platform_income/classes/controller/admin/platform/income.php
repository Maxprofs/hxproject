<?php defined('SYSPATH') or die('No direct script access.');

/**
 *Copyright www.deccatech.cn
 *Author: nilsir
 *QQ: 2758691158
 *Time: 2017/12/26 11:20
 *Desc: 平台收入审核
 */
class Controller_Admin_Platform_Income extends Stourweb_Controller
{
    private $channelname = "平台收入";
    public function before()
    {
        parent::before();
    }

    //列表页
    public function action_index()
    {
        $action = $this->params['action'];
        $modules = Model_Platform_Income::get_all_pdt_modules();
        $pay_sources = Model_Platform_Income::get_pay_sources();
        $account_status = Model_Platform_Income::$account_status;
        $channelname = $this->channelname;
        $this->assign('channelname', $channelname);
        $this->assign('modules', $modules);
        $this->assign('pay_sources', $pay_sources);
        $this->assign('account_status', $account_status);
        if ($action=='excel')  //excel导出筛选
        {
            //生成导出excel页
            $this->display('admin/platform_income/excel');
        }
        else
        {
            $this->display('admin/platform_income/list');
        }
    }

    public function action_genexcel(){
        $status = Arr::get($_GET, 'status');
        $type_id = Arr::get($_GET, 'type_id');
        $pay_type = Arr::get($_GET, 'pay_type');

        $params = array(
            'type_id'  => $type_id,
            'pay_type' => $pay_type,
            'status'   => $status,
        );
        $excel = Model_Platform_Income::income_excel($params);
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

        //define("FILETYPE","xls");
        //header("Content-type:application/vnd.ms-excel");
        //header('Content-type: charset=GBK');
        //header('Pragma: no-cache');
        //header('Expires: 0');
        //header("Content-Disposition:filename=".$info['name'].".xls");
        //$str = iconv("UTF-8//IGNORE","GBK//IGNORE",$str);
        if (empty($excel))
        {
            echo iconv('utf-8', 'gbk', $excel);
        }
        else
        {
            echo $excel;
        }
        exit();
    }

    public function action_read()
    {
        $start = Arr::get($_GET, 'start');
        $limit = Arr::get($_GET, 'limit');
        $keyword = Arr::get($_GET, 'keyword');
        $status = $_GET['status'];
        $type_id = $_GET['type_id'];
        $pay_type = $_GET['pay_type'];


        $params = array(
            'type_id'  => $type_id,
            'pay_type' => $pay_type,
            'status'   => $status,
            'keyword'  => $keyword,
            'start'    => $start,
            'limit'    => $limit,
        );
        $rows = Model_Platform_Income::get_search_list($params);
        $total = Model_Platform_Income::get_total_count($params);

        $result['total'] = $total;
        $result['lists'] = $rows;
        $result['success'] = true;

        exit(json_encode($result));
    }

    //详情页
    public function action_view()
    {
        $id = intval($this->params['id']);
        $info = Model_Platform_Income::get_info($id);

        $this->assign('info', $info);
        $this->display('admin/platform_income/view');
    }

    //更新数据
    public function action_ajax_update()
    {
        $id = Arr::get($_POST, 'id');
        $filed = Arr::get($_POST, 'filed');
        $val = Arr::get($_POST, 'val');
        $ordersn = Arr::get($_POST, 'ordersn');
        $session = Session::instance();
        $operator = ORM::factory('admin', $session->get('userid'))
                       ->get('username');
        if (! $operator)
        {
            exit(json_encode(array('status' => 0, 'msg' => '请重新登录后台')));
        }
        $arr = array(
            $filed     => $val,
            'ordersn'  => $ordersn,
            'operator' => $operator,
            'opt_time' => time(),
        );
        if (Model_Platform_Income::save_info($arr, $id))
        {
            exit(json_encode(array('status' => 1, 'msg' => '更新成功')));
        }

        exit(json_encode(array('status' => 0, 'msg' => '更新失败')));
    }

}