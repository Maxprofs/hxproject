<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Supplier extends Stourweb_Controller
{
    /*
     * 供应商总控制器
     *
     */
    public function before()
    {
        parent::before();
    }

   
    /*
          以json方式返回供应商列表
       */
    public function action_ajax_distributor_kindid()
    {
        $sql= "select * from sline_distributor where kindid={$_POST['pid']} order by  convert(distributorname using gbk) asc";
        $list =DB::query(Database::SELECT,$sql)->execute()->as_array();;
        echo json_encode(array('nextlist'=>$list));
    }
    /*
      设置产品供应商
    */
    public function action_ajax_set_distributor()
    {
        $product_arr = array(
            1 => 'line',
            2 => 'hotel',
            3 => 'car',
            4 => 'article',
            5 => 'spot',
            6 => 'photo',
            8 => 'visa',
            13 => 'tuan'
        );
        $typeid = ARR::get($_POST, 'typeid');
        $productid = ARR::get($_POST, 'productid');
        $distributorids = ARR::get($_POST, 'distributorids');
        $model = ORM::factory($product_arr[$typeid], $productid);
        $is_success = 'ok';
        $productid_arr = explode('_', $productid);
        foreach ($productid_arr as $k => $v)
        {
            $model = ORM::factory($product_arr[$typeid], $v);
            if ($model->id)
            {
                $model->distributorlist = $distributorids;
                $model->save();
                if (!$model->saved())
                    $is_success = 'no';
            }
        }
        echo $is_success;
    }

    /*
     * ajax检测是否存在
     * */
    public function action_ajax_check()
    {
        $field = $this->params['type'];
        $val = ARR::get($_POST, 'val');//值
        $mid = ARR::get($_POST, 'mid');//会员id
        $flag = Model_Member::checkExist($field, $val, $mid);
        echo $flag;
    }

    public function action_dialog_set()
    {
        $distributors = $_GET['distributors'];
        $id = $_GET['id'];
        $typeid = $_GET['typeid'];
        $selector = urldecode($_GET['selector']);
        $distributorArr = explode(',', $distributors);
        $distributorList = ORM::factory('distributor')->get_all();
        $kind=$this->_distributor_kind();
        array_unshift($kind,array('id'=>0,'kindname'=>'默认'));
        $column=array();
        foreach($distributorList as $v){
            array_push($column,$v['kindid']);
        }
        $count=array_count_values($column);
        foreach($kind as &$v){
            if(!empty($count[$v['id']])){
                $v['count']=$count[$v['id']];
            }
        }
        $this->assign('distributorArr', implode(',',$distributorArr));
        $this->assign('selector', $selector);
        $this->assign('kind',$kind);
        $this->display('distributor/dialog_set');
    }
    private function _distributor_kind()
    {
        $kind = DB::query(Database::SELECT, "select *,concat(path,'-',id) as level from sline_distributor_kind where isopen=1 order by level asc,displayorder asc")->execute()->as_array();
        return $kind;
    }

  
}