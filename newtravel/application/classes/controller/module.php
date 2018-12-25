<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Module extends Stourweb_Controller
{

    //右模块控制器
    public function before()
    {
        parent::before();

        $weblist = Common::getWebList();
        $this->assign('weblist', $weblist);
        $this->assign('menuid', $this->params["menuid"]);
    }

    /*
     * 模块设置页
     * */
    public function action_index()
    {
        $module_list = Model_Module_Config::get_module_list();
        $this->assign('module_list', $module_list);

        $page_module_list = Model_Module_Config::get_page_module_info();
        $this->assign("page_module_list", $page_module_list);

        $this->display('stourtravel/module/index');
    }

    public function action_ajax_page_list()
    {
        $page_module_id = Arr::get($_POST, 'page_module_id');

        $list = array();
        if (!empty($page_module_id))
        {
            $page_list = Model_Module_Config::get_page_info($page_module_id);
            foreach ($page_list as $page_info)
            {
                $list[] = array(
                    "id" => preg_replace("/_list$/is", "_search", $page_info["page_name"]),//由于原有右侧模块在list页面调用时使用的是search，所以在此处将list pagename变更为search
                    "page_module_id" => $page_module_id,
                    "title" => $page_info["name"]
                );
            }
        }

        echo json_encode(array('status' => 1, 'msg' => '', 'data' => $list));
    }

    public function action_ajax_page_selected_block()
    {
        $pagename = Arr::get($_POST, 'pagename');
        $webid = Arr::get($_POST, 'webid');

        $selected_block_list = Model_Module_Config::get_selected_block($webid, $pagename);

        echo json_encode(array('status' => 1, 'msg' => '', 'data' => $selected_block_list));
    }

    public function action_ajax_module_block()
    {
        $typeid = Arr::get($_POST, 'typeid');
        $exclude_ids = implode(",", Arr::get($_POST, 'exclude_ids'));

        $module_block_list = Model_Module_Config::get_module_block($typeid, $exclude_ids);

        echo json_encode(array('status' => 1, 'msg' => '', 'data' => $module_block_list));
    }

    public function action_ajax_save_page_block()
    {
        $webid = Arr::get($_POST, 'webid');
        $pagename = Arr::get($_POST, 'pagename');
        $pagename_title = Arr::get($_POST, 'pagename_title');
        $blockids = implode(",", Arr::get($_POST, 'blockids'));

        Model_Module_Config::save_page_block($webid, $pagename, $pagename_title, $blockids);

        echo json_encode(array('status' => 1, 'msg' => '', 'data' => null));
    }


    /*
     * 模块列表
     * */
    public function action_list()
    {
        $module_list = Model_Module_Config::get_module_list();
        $this->assign('module_list', $module_list);

        $this->display('stourtravel/module/list');
    }

    public function action_ajax_search_module_block()
    {
        $searchkey = Arr::get($_GET, 'searchkey');
        $module_id = Arr::get($_GET, 'module_id');
        $start = Arr::get($_GET, 'start');
        $limit = Arr::get($_GET, 'limit');

        $list = Model_Module_List::search_block($searchkey, $module_id, null, $start, $limit);
        $result['total'] = $list['row_count'];
        $result['lists'] = $list['data'];
        $result['success'] = true;
        echo json_encode($result);
    }


    public function action_add_block()
    {
        $module_list = Model_Module_Config::get_module_list();
        $this->assign('module_list', $module_list);

        $this->display('stourtravel/module/edit');
    }

    public function action_edit_block()
    {
        $module_list = Model_Module_Config::get_module_list();
        $this->assign('module_list', $module_list);

        $blockid = $this->params["id"];
        $block_info = Model_Module_List::get_block($blockid);
        if ($block_info["issystem"] == 1)
        {
            if (!empty($block_info['body']))
            {
                if (is_file(BASEPATH . $block_info['body']))
                {
                    $block_info['body'] = file_get_contents(BASEPATH . $block_info['body']);
                }
            }
        }
        $this->assign('block_info', $block_info);

        $this->display('stourtravel/module/edit');
    }

    public function action_ajax_delete_block()
    {
        $result = array("status" => 0, "msg" => "");

        $blockid = Arr::get($_POST, 'blockid');
        if (empty($blockid))
        {
            $result["status"] = 1;
            echo(json_encode($result));
            return;
        }

        if (is_array($blockid))
        {
            $blockid = implode(",", $blockid);
        }

        Model_Module_List::delete_block($blockid);

        $result["status"] = 1;
        echo(json_encode($result));
    }


    public function action_ajax_save_block()
    {
        $result = array("status" => 0, "msg" => "");

        $blockid = Arr::get($_POST, 'blockid');
        $blockname = Arr::get($_POST, 'blockname');
        $module_id = Arr::get($_POST, 'module_id');
        $block_body = Arr::get($_POST, 'blockbody');

        $info = array(
            'modulename' => $blockname,
            'body' => $block_body,
            'issystem' => 0,
            'type' => $module_id
        );

        if (empty($blockid))
        {
            Model_Module_List::add_block($info);

        } else
        {
            $info["id"] = $blockid;
            Model_Module_List::update_block($info);
        }


        $result["status"] = 1;
        echo(json_encode($result));
    }


}