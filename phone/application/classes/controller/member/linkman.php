<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Class Controller_Member_Linkman
 * 常用联系人
 */
class Controller_Member_Linkman extends Stourweb_Controller
{
    public function before()
    {
        parent::before();
        $this->member = Common::session('member');
        if (empty($this->member))
        {
            $this->request->redirect('member/login');
        }
    }

    /**
     * 首页
     */
    public function action_index()
    {

        $this->assign('refresh',$refresh);
        $this->display('member/linkman/index');
    }

    /**
     *
     */
    public function action_ajax_more()
    {
        $page = intval($_GET['page']);
        $page = $page < 1 ? 1 : $page;
        $pagesize = 12;
        $order = 'CONVERT(linkman USING gbk)';
        $out = Model_Member_Linkman::get_linkman($this->member['mid'],$page,$pagesize,$order);
        $list = Model_Member_Linkman::format_wap_list($out['list']);
        foreach ($list as &$v)
        {
            $v['url'] = $this->cmsurl . "member/linkman/update?action=edit&id={$v['id']}";
        }
        unset($v);
        echo Product::list_search_format($list, $page,$pagesize);


    }

    /**
     * 添加、修改联系人
     */
    public function action_update()
    {
        $action = isset($_GET['action']) ? $_GET['action'] : '';
        $listUrl = $this->cmsurl . 'member/linkman/';
        switch ($action)
        {
            //编辑
            case 'edit':
                $info = Model_Member_Linkman::detail(Common::remove_xss($_GET['id']));
                $info['action'] = '修改';
                $this->assign('info', $info);
                $this->display('member/linkman/edit');
                break;
            //添加
            case 'add':
                $info['action'] = '添加';
                $info['isadd'] = true;
                $this->assign('info', $info);
                $this->display('member/linkman/edit');
                break;
            //删除
            case 'delete':
                $data['bool'] = 0;
                $id = Common::remove_xss($_GET['id']);

                $rows = DB::delete('member_linkman')->where("id={$id} and memberid={$this->member['mid']}")->execute();
                if ($rows > 0)
                {
                    $data['bool'] = 1;
                    $data['url'] = $listUrl;
                    $data['msg'] = __('success_delete');
                } else
                {
                    $data['msg'] = __('error_delete');
                }
                echo json_encode($data);
                break;
            //新增或更新数据
            case 'save':
                $data['bool'] = 0;
                $_POST = Common::remove_xss($_POST);
                $_POST['linkman'] = trim($_POST['linkman']);
                $_POST['mobile'] = trim($_POST['mobile']);
                $_POST['idcard'] = trim($_POST['idcard']);
                $_POST['cardtype'] = trim($_POST['cardtype']);
                $_POST['sex'] = trim($_POST['sex']);
                if (empty($_POST['id']))
                {
                    $_POST['memberid'] = $this->member['mid'];

                    list(, $rows) = DB::insert('member_linkman', array_keys($_POST))->values(array_values($_POST))->execute();
                    if ($rows > 0)
                    {
                        $data['bool'] = 1;
                        $data['status'] = 1;
                        $data['url'] = $listUrl;
                        $data['msg'] = __('success_add');
                    } else
                    {
                        $data['msg'] = __('error_add');
                    }
                }
                else
                {
                    $id = $_POST['id'];
                    unset($_POST['id']);
                    DB::update('member_linkman')->set($_POST)->where("id={$id} and memberid={$this->member['mid']}")->execute();
                    $data['bool'] = 1;
                    $data['status'] = 1;
                    $data['url'] = $listUrl;
                    $data['msg'] = __('success_edit');
                }
                echo json_encode($data);
                break;
        }
    }


    /**
     * @function 检查证件号 是否重复
     */
    public function action_ajax_check_linkman_card()
    {
        $id = intval($_POST['id']);
        $idcard = Common::remove_xss($_POST['idcard']);
        $cardtype = Common::remove_xss($_POST['cardtype']);
        $where = "idcard = '$idcard' and cardtype='$cardtype' and memberid={$this->member['mid']}";
        if($id)
        {
            $where .= " and id<>$id";
        }
        $check = DB::select('id')->from('member_linkman')
            ->where($where)
            ->execute()->get('id');
        if($check)
        {
            exit(json_encode(array('status'=>0)));
        }
        else
        {
            exit(json_encode(array('status'=>1)));
        }
    }


    /**
     * 检测身份证、电话号码是否存在
     */
    public function action_ajax_check()
    {
        $_POST = Common::remove_xss($_POST);
        if (count($_POST) != 1)
        {
            exit('false');
        }
        $key = array_keys($_POST);
        $key = $key[0];
        $val = $key == 'idcard' ? "'{$_POST[$key]}'" : $_POST[$key];
        $result = DB::select()->from('member_linkman')->where("{$key}=$val and memberid=" . $this->member['mid'])->execute()->as_array();
        empty($result) ? exit('true') : exit('false');
    }
}