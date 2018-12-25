<?php defined('SYSPATH') or die('No direct script access.');

/**
 * 游记评论
 * Class Controller_Admin_Notes_Comment
 */
class Controller_Admin_Notes_Comment extends Stourweb_Controller
{
    public function before()
    {
        parent::before();
    }

    public function action_index()
    {
        $action = $this->params['action'];
        if (empty($action))
        {
            $this->display('admin/notes/comment/list');
        }
        else if ($action == 'read')
        {
            $start = Arr::get($_GET, 'start');
            $limit = Arr::get($_GET, 'limit');
            $order = 'order by a.addtime desc';
            $w = '';
            if (isset($this->params['typeid']))
            {
                $w .= 'where typeid=' . $this->params['typeid'];
            }
            $sql = "select a.*  from sline_comment as a $w $order limit $start,$limit";
            $totalcount_arr = DB::query(Database::SELECT, "select count(*) as num from sline_comment $w ")->execute()->current();
            $list = DB::query(Database::SELECT, $sql)->execute()->as_array();
            $new_list = array();
            foreach ($list as $k => $v)
            {
                $row = DB::select()->from('notes')->where('id', '=', $v['articleid'])->execute()->current();
                $v['productname'] = "<a href='/notes/show_{$v['articleid']}.html' class='product-title' target=\"_blank\">{$row['title']}</a>";
                $v['nickname'] = Model_Comment::getMemberName($v['memberid']);
                $v['modulename'] = Model_Comment::getPinlunModule($v['typeid']);
                $new_list[] = $v;
            }
            $result['total'] = $totalcount_arr['num'];
            $result['lists'] = $new_list;
            $result['success'] = true;
            echo json_encode($result);
        }
        else if ($action == 'save')
        {

        }
        else if ($action == 'delete')
        {
            $rawdata = file_get_contents('php://input');
            $data = json_decode($rawdata);
            $id = $data->id;
            if (is_numeric($id))
            {
                $model = ORM::factory('comment', $id);
                $model->delete();
            }
        }
        else if ($action == 'update')//更新某个字段
        {
            $id = Arr::get($_POST, 'id');
            $field = Arr::get($_POST, 'field');
            $val = Arr::get($_POST, 'val');

           $model = ORM::factory('comment', $id);
            $old_isshow = $model->isshow;
            if ($model->id)
            {
                $model->$field = $val;
                $model->save();
                if ($model->saved())
                {
                    if($field=='isshow' && $val==1 && $old_isshow!=$val)
                    {
                        Model_Message::add_note_msg(103,$model->articleid,null,$id);
                        Model_Comment::on_verified($id,$model->typeid,$model->memberid);
                    }
                    echo 'ok';
                }
                else
                    echo 'no';
            }
        }
    }

    /**
     * 评论验证通过
     */
    private function on_verified($commentid,$typeid,$memberid)
    {
        $allowed_typeids = array(4,6,11,101);
        if(empty($typeid)||empty($memberid)||!in_array($typeid,$allowed_typeids))
        {
            return;
        }
        $model_info = Model_Model::get_module_info($typeid);
        $jifen = Model_Jifen::reward_jifen('sys_comment_'.$model_info['pinyin'],$memberid);
        if(!empty($jifen))
        {
            St_Product::add_jifen_log($memberid,'评论'.$model_info['modulename'].'送积分'.$jifen,$jifen,2);
        }
    }
}