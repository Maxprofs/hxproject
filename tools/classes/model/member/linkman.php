<?php defined('SYSPATH') or die('No direct script access.');

/**
 * 常用联系人管理
 * Class Linkman
 */
class Model_Member_Linkman extends ORM
{
    /**
     * @function 添加常用联系人
     * @param $ar
     * @param $mid
     * @throws Kohana_Exception
     */
    public static function add_tourer_to_linkman($ar, $mid)
    {
        $m = ORM::factory('member_linkman')
            ->where("memberid=$mid and cardtype='{$ar['cardtype']}' and idcard='{$ar['cardnumber']}'")
            ->find();
        $new = array(
            'linkman' => $ar['tourername'],
            'idcard' => $ar['cardnumber'],
            'cardtype' => $ar['cardtype'],
            'memberid' => $mid,
            'mobile' => $ar['mobile'],
            'sex' => $ar['sex'],
        );
        //如果没有找到,则自动加入常用联系人表
        if (!$m->loaded())
        {
            $_m = ORM::factory('member_linkman');
            foreach ($new as $k => $v)
            {
                $_m->$k = $v;
            }
            $_m->save();
        }
    }

    /**
     * @function 分页读取联系人.
     * @param $mid
     * @param $page
     * @param int $pagesize
     * @return mixed
     *
     */

    public static function get_linkman($mid,$page,$pagesize=5,$order=null)
    {

        if($order)
        {
            $order .= ',id desc';
        }
        else
        {
            $order = ' id desc';
        }

        $page = $page ? $page : 1;
        $pagesize = $pagesize ? $pagesize : 5;
        $offset = (intval($page)-1)*$pagesize;
        $sql = "SELECT * FROM sline_member_linkman ";
        $sql .= " WHERE memberid ={$mid} ";
        $sql .= "ORDER BY $order ";
        $sql .= "LIMIT {$offset},{$pagesize} ";
        $arr = DB::query(1, $sql)->execute()->as_array();
        $total = DB::select(DB::expr('count(*) as num'))
            ->from('member_linkman')
            ->where('memberid','=',$mid)
            ->execute()->get('num');
        $out = array(
            'list' => $arr,
            'total'=>$total
        );
        return $out;
    }

    ///***************************** PC端开始  ************************************///

    /**
     * @function 获取某个会员的联系人信息
     * @param $mid
     * @return mixed
     */
    public static function get_list($mid)
    {
        $sql = "SELECT * FROM sline_member_linkman ";
        $sql .= "WHERE memberid ={$mid} ";
        $sql .= "ORDER BY id desc";
        $arr = DB::query(1, $sql)->execute()->as_array();
        return $arr;
    }



    /**
     * @function 获取联系人详情
     * @param $id
     * @return mixed
     */
    public static function detail($id)
    {
        $sql = "SELECT * FROM sline_member_linkman ";
        $sql .= "WHERE id={$id}";
        $arr = DB::query(1, $sql)->execute()->as_array();
        return $arr[0];
    }

    ///***************************** PC端结束  ************************************///


    /**
     * @function 格式化手机端列表
     * @param $list
     */
    public static function format_wap_list($list)
    {

        foreach ($list as &$l)
        {
            $pinyin = Common::get_pinyin($l['linkman']);
            if($pinyin)
            {
                $pinyin = strtoupper(substr($pinyin,0,1));
                $l['pinyin'] = $pinyin;
            }
            if(!$l['mobile'])
            {
                $l['mobile'] = '';
            }

        }
        unset($l);
        return $list;

    }


}