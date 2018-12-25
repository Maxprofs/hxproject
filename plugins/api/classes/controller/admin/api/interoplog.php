<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Api_Interoplog extends Stourweb_Controller
{

    public function before()
    {

        parent::before();
    }

    /*
    酒店列表操作

    */
    public function action_index()
    {
        $action = is_null($this->params['action']) ? 'null' : $this->params['action'];
        switch ($action)
        {
            case 'null':
                $client_list = Model_Api_Client::get_all_info();
                $this->assign('client_list', $client_list);

                $this->display('admin/api/interop_log');
                break;
            case 'read':
                $start = Arr::get($_GET, 'start');
                $limit = Arr::get($_GET, 'limit');
                $client_id = Common::remove_xss(Arr::get($_GET, 'client_id'));
                $success = Common::remove_xss(Arr::get($_GET, 'success'));
                $keyword = Common::remove_xss(Arr::get($_GET, 'searchkey'));

                $list = Model_Api_Interop_Log::search($keyword, $client_id, $success, $start, $limit);
                $result['total'] = $list['row_count'];
                $result['lists'] = $list['data'];
                $result['success'] = true;
                echo json_encode($result);
                break;
        }
    }

    public function action_show_detail()
    {
        $log_id = intval($this->params['id']);
        if(!empty($log_id))
            $info = Model_Api_Interop_Log::get_info($log_id);

        $this->assign('info',$info);
        $this->display('admin/api/interop_log_detail');
    }

}