<?php defined('SYSPATH') or die('No direct script access.');

/**
 * 订单管理
 * Class Order
 */
class Model_Member_Invoice extends ORM
{

    /**
     * @function 获取发票列表
     * @param $memberid
     * @param null $keyword
     * @param null $type 多个用英文逗号隔开
     * @param int $page
     * @param int $pagesize
     */
   public static function search_result($memberid,$keyword=null,$types=null,$page=1,$pagesize=20)
   {
       $w = " where memberid='{$memberid}' ";

       $value_arr = array();
       if($types!==null && preg_match("/^[0-9,]*$/i",$types))
       {
           $w .= " and type in ({$types}) ";
       }

       if(!empty($keyword))
       {
           $w .=" and title like :keyword ";
           $value_arr[':keyword'] = '%'.$keyword.'%';
       }

       $page = $page<1?1:$page;
       $offset = ($page-1)*$pagesize;

       $sql = " select * from sline_member_invoice {$w} limit {$offset},{$pagesize} ";
       $sql_num = "select count(*) as num from sline_member_invoice {$w} ";
       $list = DB::query(Database::SELECT,$sql)->parameters($value_arr)->execute()->as_array();
       $total = DB::query(Database::SELECT,$sql_num)->parameters($value_arr)->execute()->get('num');
       $result = array('list'=>$list,'total'=>$total);
       return $result;
   }

   public static function  get_type_name($type)
   {
       $type_arr = array(0=>'个人发票', 1=>'公司发票', 2=>'增值发票');
       return $type_arr[$type];
   }
}