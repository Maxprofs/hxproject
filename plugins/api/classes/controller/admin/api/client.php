<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Api_Client extends Stourweb_Controller
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
                $this->display('admin/api/list');
                break;
            case 'read':
                $start = Arr::get($_GET, 'start');
                $limit = Arr::get($_GET, 'limit');
                $status = Common::remove_xss(Arr::get($_GET, 'status'));
                $keyword = Common::remove_xss(Arr::get($_GET, 'searchkey'));

                $list = Model_Api_Client::search($keyword,$status, $start, $limit);
                $result['total'] = $list['row_count'];
                $result['lists'] = $list['data'];
                $result['success'] = true;
                echo json_encode($result);
                break;
        }
    }

    public function action_update_client()
    {
        $client_id = intval($this->params['id']);
        if(!empty($client_id))
            $info = Model_Api_Client::get_info($client_id);

        $this->assign('info',$info);
        $this->display('admin/api/update_client');
    }

    public function action_ajax_delete_client()
    {
        $client_id = intval(Arr::get($_POST, "id"));

        if(!empty($client_id))
            Model_Api_Client::delete_info($client_id);

        echo json_encode(array('status' => 1, 'msg' => "删除成功"));
    }

    public function action_ajax_save_client()
    {
        $info = array();
        $info['id'] = intval(Arr::get($_POST, "id"));
        $info['name'] = Common::remove_xss(Arr::get($_POST, "name"));
        $info['secret_key'] = Common::remove_xss(Arr::get($_POST, "secret_key"));
        $info['config'] = trim(Common::remove_xss(Arr::get($_POST, "config")));
        $info['status'] = intval(Arr::get($_POST, "status"));

        Model_Api_Client::update_info($info);

        echo json_encode(array('status' => 1, 'msg' => "保存成功"));
    }

    public function action_ajax_reset_secret_key()
    {
        $client_id = intval(Arr::get($_POST, "id"));

        if(!empty($client_id))
            Model_Api_Client::reset_secret_key($client_id);

        echo json_encode(array('status' => 1, 'msg' => "重置通信密钥成功"));
    }

}