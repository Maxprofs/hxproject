<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Line_Jieshao extends ORM
{

    /**
     * 获取行程
     * @param $lineid
     * @return mixed
     */
    public static function detail($lineid,$lineday)
    {
        $lineid = intval($lineid);
        $lineday = intval($lineday);
        $sql = "SELECT * FROM sline_line_jieshao where lineid ={$lineid} ORDER BY day ASC LIMIT 0,$lineday";
        $arr= DB::query(1, $sql)->execute()->as_array();

        return $arr;
    }

    /**
     * 手机端获取行程
     * @param $lineid
     * @return mixed
     */
    public static function detail_mobile($lineid,$day)
    {
        $sql = "SELECT * FROM sline_line_jieshao where lineid ={$lineid} and day<={$day} order by day asc";
        $arr= DB::query(1, $sql)->execute()->as_array();
        foreach($arr as &$v){
            $v['jieshao']= Product::strip_style($v['jieshao']);
            if($v['breakfirsthas'])
            {
                $v['breakfirst'] = empty($v['breakfirst']) ? '含' : $v['breakfirst'];
            }else{
                $v['breakfirst'] = '自理';
            }
            if($v['lunchhas'])
            {
                $v['lunch'] = empty($v['lunch']) ? '含' : $v['lunch'];
            }else{
                $v['lunch'] = '自理';
            }
            if($v['supperhas'])
            {
                $v['supper'] = empty($v['supper']) ? '含' : $v['supper'];
            }
            else{
                $v['supper'] = '自理';
            }
        }
        return $arr;
    }

    /**
     * @function 按线路id删除线路介绍
     * @param $lineid
     */
    public function delete_by_lineid($lineid)
    {
        $sql = "delete from sline_line_jieshao where lineid = '$lineid'";
        $this->query($sql,3);
        //删除咨询
        DB::delete('question')->where('typeid','=',1)
            ->and_where('productid','=',$lineid)
            ->execute();


    }
}