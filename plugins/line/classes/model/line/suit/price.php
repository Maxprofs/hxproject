<?php defined('SYSPATH') or die('No direct access allowed.');


class Model_Line_Suit_Price extends ORM
{
    /**
     * @param $suitid
     * @param $useday
     * @return mixed
     * 产品套餐按天获取报价
     */

    public static function get_price_byday($suitid,$useday)
    {
        $sql = "SELECT * FROM `sline_line_suit_price` WHERE suitid='$suitid' AND `day`>='$useday' AND number!=0 ORDER BY `day` ASC limit 1";
        $ar = DB::query(1,$sql)->execute()->as_array();
        foreach($ar as &$v)
        {
            $v['childprofit'] = Currency_Tool::price($v['childprofit']);
            $v['childbasicprice'] = Currency_Tool::price($v['childbasicprice']);
            $v['childprice'] = Currency_Tool::price($v['childprice']);
            $v['oldprofit'] = Currency_Tool::price($v['oldprofit']);
            $v['oldbasicprice'] = Currency_Tool::price($v['oldbasicprice']);
            $v['oldprice'] = Currency_Tool::price($v['oldprice']);
            $v['adultprofit'] = Currency_Tool::price($v['adultprofit']);
            $v['adultbasicprice'] = Currency_Tool::price($v['adultbasicprice']);
            $v['adultprice'] = Currency_Tool::price($v['adultprice']);
            $v['roombalance'] = Currency_Tool::price($v['roombalance']);
        }
        return $ar;
    }
    /**
     * @function 获取产品最低价格
     * @param $suitid
     * @param string $field
     * @return mixed
     */
    public static function get_min_price($suitid,$field='')
    {
        $time=time();
        if(!empty($field))
        {
            //获取利润
            $result=DB::query(Database::SELECT,"select min($field) as minprice from sline_line_suit_price where  day>$time and suitid=$suitid")->execute()->as_array();
            if($result[0]['minprice'] =='0')
            {
                $field = 'childprofit';
                $result=DB::query(Database::SELECT,"select min($field) as minprice from sline_line_suit_price where  day>$time and suitid=$suitid")->execute()->as_array();
            }
        }else{
            //获取最低报价
            $field = 'adultprice';
            $result=DB::query(Database::SELECT,"select min($field) as minprice from sline_line_suit_price where  day>$time and suitid=$suitid")->execute()->as_array();
            if($result[0]['minprice'] =='0')
            {
                $field = 'childprice';
                $result=DB::query(Database::SELECT,"select min($field) as minprice from sline_line_suit_price where  day>$time and suitid=$suitid")->execute()->as_array();
            }
        }
        return $result[0]['minprice'];
    }


    /**
     * @function 获取某天的报价，后台用
     * @param $suitid
     * @param $useday
     * @return mixed
     */
    public static function get_price_by_date($suitid,$useday)
    {
        $sql = "SELECT * FROM `sline_line_suit_price` WHERE suitid='$suitid' AND day='$useday'  limit 1";
        $ar = DB::query(1,$sql)->execute()->current();
        if($ar['propgroup'])
        {
            $ar['propgroup'] = explode(',',$ar['propgroup']);
        }
        return $ar;
    }

    /**
     * @function 更新某一天的报价
     */
    public static function update_date_price($lineid,$suitid,$date,$data,$isdel=0)
    {
        $date = strtotime($date);
        if(!$suitid||!$lineid||!$date)
        {
            return false;
        }
        DB::delete('line_suit_price')->where('suitid','=',$suitid)
            ->and_where('day','=',$date)->execute();
        //如果不是删除
        if(!$isdel)
        {
            $data['lineid'] = $lineid;
            $data['suitid'] = $suitid;
            $data['day'] = $date;
            DB::insert('line_suit_price',array_keys($data))->values(array_values($data))->execute();
        }


    }

}