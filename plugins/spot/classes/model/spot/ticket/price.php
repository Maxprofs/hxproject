<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Spot_Ticket_Price extends ORM {

    /**
     * 获取当前时间的报价
     * @param $suitid
     * @param $timeStamp
     * @return array
     */
    public static function current_price($suitid, $timeStamp)
    {
        $arr = DB::select()->from('spot_ticket_price')->where("ticketid=$suitid")->and_where('day', '=', $timeStamp)->and_where('number', '!=', 0)->execute()->current();
        $data = !empty($arr) ? $arr : array();
        if (isset($data['adultprice']))
        {
            $data['price'] = Currency_Tool::price($data['adultprice']);
        }
        return $data;
    }

    /**
     * 获取最近几天的报价
     * @param $suitid
     * @param $row 获取几天的数据
     * @return array
     */
    public static function get_next_price($suit, $row=2)
    {
        $suitid=$suit['id'];
        $cur_time = time();
        $sql = "select a.* from sline_spot_ticket_price a left join sline_spot_ticket b on a.ticketid=b.id ";
        $sql .=" where a.ticketid='{$suitid}' and a.number!=0  ";
        $sql .=" and a.day>({$cur_time}+b.day_before*24*3600-case when (b.hour_before=0 and b.minute_before=0) then 24*3600 else (3600*b.hour_before+b.minute_before*60) end) limit {$row}";
        $arr = DB::query(Database::SELECT,$sql)->execute()->as_array();
        foreach ($arr as &$data)
        {
            $data = !empty($data) ? $data : array();
            if (isset($data['adultprice']))
            {
                $data['price'] = Currency_Tool::price($data['adultprice']);
            }
            $data['date'] = date('Y-m-d',$data['day']);
        }
        return $arr;
    }

    /**
     * @function 返回套餐报价状态
     * @param $suitid 套餐ID
     * @return int 3:没有报价('电询'),2:有报价,订完,1:可预订
     */
    public static function get_price_status($suit)
    {
        $suitid=$suit['id'];
        $day=strtotime(date('Y-m-d',time()+intval($suit["day_before"])*24*3600));
        $arr = DB::select()->from('spot_ticket_price')->where("ticketid=$suitid")->and_where('day', '>=', $day)->execute()->as_array();
        //存在报价
        if(!empty($arr))
        {
            //有库存
            $arr2 = DB::select()->from('spot_ticket_price')->where("ticketid=$suitid")->and_where('day', '>=', $day)->and_where('number', '!=', 0)->execute()->as_array();
            return empty($arr2)?2:1;
        }
        //没有报价
        return 3;
    }
}