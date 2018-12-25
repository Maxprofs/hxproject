<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Spot extends ORM
{
    public static function get_minprice($spotid, $params = array())
    {
        $rs = array('price' => 0);
        $time = strtotime(date('Y-m-d'));
        $update_minprice = false;
        if (!is_array($params))
        {
            $params = array('ticketid' => $params);
        }
        if (!isset($params['ticketid']))
        {
            //市场价最低
            $sql = "SELECT MIN(CAST(sellprice as SIGNED)) AS sellprice FROM `sline_spot_ticket` ";
            $sql .= "WHERE spotid='{$spotid}' AND sellprice >0";
            $row = DB::query(1, $sql)->execute()->current();
            $rs['sellprice'] = Currency_Tool::price($row['sellprice']);
            //报价最低
            if (!isset($params['info']))
            {
                $params['info'] = DB::select('price', 'price_date')->from('spot')->where('id', '=', $spotid)->execute()->current();
            }
            if ($time == $params['info']['price_date'])
            {
                $rs['price'] = Currency_Tool::price($params['info']['price']);
                return $rs;
            }
            //更新最低价
            $update_minprice = true;
        }
        $where = isset($params['ticketid']) ? " and `ticketid` ={$params['ticketid']} " : '';
        $sql = 'SELECT MIN(adultprice) as price FROM sline_spot_ticket_price WHERE `spotid`="' . $spotid . '" and `day`>=' . $time . ' and (`number`>0 or `number`=-1) ' . $where;
        $result = DB::query(1, $sql)->execute()->current();
        if ($result)
        {
            $rs['price'] = $result['price'];
        }
        //更新产品最低价
        if ($update_minprice)
        {
            DB::update('spot')->set(array('price' => $rs['price'], 'price_date' => $time))->where('id', '=', $spotid)->execute();
        }
        $rs['price'] = Currency_Tool::price($rs['price']);
        return $rs;
    }
}