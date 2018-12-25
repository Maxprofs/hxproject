<?php defined('SYSPATH') or die('No direct script access.');

/**
 * 例子控制器
 */
class Controller_Index extends Stourweb_Controller
{
    /**
     * 初始化支付对象
     */
    public function before()
    {
        parent::before();
    }
    public function action_index()
    {
       $this->request->redirect('pc');
    }


    public function action_dialog_setstartplace()
    {
        $id = $this->params['id'];
        $startplacetop = DB::select()->from('startplace')->where('pid', '=', 0)->and_where('isopen','=',1)->execute()->as_array();
        $startplacelist = DB::select()->from('startplace')->where('pid', '!=', 0)->and_where('isopen','=',1)->execute()->as_array();
        foreach ($startplacetop as &$item)
        {
            $pid=$item['id'];
            $item['num'] = DB::query(Database::SELECT,"select count(*) as num from sline_startplace where pid='{$pid}' and isopen=1 ")->execute()->get('num');
        }
        $this->assign('startplacetop', $startplacetop);
        $this->assign('startplacelist', $startplacelist);
        $this->assign('startplaceid', $id);
        $this->display('dialog_setstartplace');
    }

    public function action_ajax_get_start_place()
    {
        $id = intval($_REQUEST['pid']);
        $keyword = trim(Arr::get($_POST, 'keyword'));
        $sql="SELECT * FROM sline_startplace";
        $where=" WHERE isopen=1";
        if($id)
        {
            $where.=" AND pid={$id}";
        }
        if($keyword)
        {
            $keyword_str='%'.$keyword.'%';
            $where.=" AND cityname like '{$keyword_str}'";
        }
        $sql.=$where;
        $startplace=DB::query(Database::SELECT,$sql)->execute()->as_array();
        echo json_encode(array('status' => $startplace?true:false, 'msg' => 'ok', 'list' => $startplace,'count'=>count($startplace)));
    }


}