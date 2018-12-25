<?php defined('SYSPATH') or die('No direct script access.');
//引入公用函数库
require TOOLS_COMMON . 'functions.php';

class Common extends Functions
{
    /*
     * 获取扩展表
     * */
    public static function get_extend_table($typeid)
    {
        $row = parent::st_query('model',"id=$typeid",'*',true);

        return  $row['addtable'];
    }

    /*
     * 根据typeid获取扩展字段信息
     * */
    public static function get_extend_info($typeid, $productid)
    {
        $table = self::get_extend_table($typeid);
        $arr = parent::st_query($table,"productid='$productid'","*",true);
        return $arr;
    }

    /**
     * 上次报价记录
     * @param $modelId
     * @param $data
     * @return array
     */
    public static function last_offer($modelId, $data)
    {
        $lastOffer = array();
        switch ($modelId)
        {
            //线路
            case 1:
                $lastOffer = array(
                    'pricerule' => $data['pricerule'],
                    'adultbasicprice' => $data['adultbasicprice'],
                    'adultprofit' => $data['adultprofit'],
                    'adultprice' => $data['adultbasicprice'] + $data['adultprofit'],
                    'childbasicprice' => $data['childbasicprice'],
                    'childprofit' => $data['childprofit'],
                    'childprice' => $data['childbasicprice'] + $data['childprofit'],
                    'oldbasicprice' => $data['oldbasicprice'],
                    'oldprofit' => $data['oldprofit'],
                    'oldprice' => $data['oldbasicprice'] + $data['oldprofit'],
                    'starttime' => $data['starttime'],
                    'endtime' => $data['endtime'],
                );
                break;
            //酒店、租车
            case 2:
            case 3:
                $lastOffer = array(
                    'pricerule' => $data['pricerule'],
                    'basicprice' => $data['basicprice'],
                    'profit' => $data['profit'],
                    'price' => $data['basicprice'] + $data['profit'],
                    'starttime' => $data['starttime'],
                    'endtime' => $data['endtime'],
                );
                break;
        }
        return serialize($lastOffer);
    }
    //获取前某个月的开始时间和结束时间
    public static function get_last_month($monthnum=1)
    {
        $timestamp=time();
        $curday=date('Y-m-d');
        $prevmonthday=strtotime("$curday -$monthnum month");
        $firsttime=strtotime(date('Y-m-01',$prevmonthday));
        $firstday=date('Y-m-d',$firsttime);
        $lasttime=strtotime("$firstday +1 month -1 day");
        return array($firsttime,$lasttime);
    }
    public static function session($k, $v = '')
    {
        $session = Session::instance();
        if (empty($v))
        {
            $session = is_null($v) ? $session->delete($k) : $session->get($k);
        } else
        {
            $session->set($k, $v);
        }
        return $session;
    }
    public static function cutstr($str,$len,$suffix='...')
    {
        return mb_substr($str,0,$len,'utf-8').$suffix;
    }





}
