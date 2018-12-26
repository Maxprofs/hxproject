<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Line_Suit_Price extends ORM {
    protected  $_table_name = 'line_suit_price';
	
	public static function getMinPrice($suitid,$field='adultprice')
	{
		$time=time();
		$result=DB::query(Database::SELECT,"select min($field) as minprice from sline_line_suit_price where  day>$time and suitid=$suitid")->execute()->as_array();
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