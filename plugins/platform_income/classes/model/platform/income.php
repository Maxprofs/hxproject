<?php defined('SYSPATH') or die('No direct script access.');

/**
 *Copyright www.deccatech.cn
 *Author: nilsir
 *QQ: 2758691158
 *Time: 2017/12/26 15:50
 *Desc: 平台收入
 */
class Model_Platform_Income extends ORM
{
    /**
     * @var array 到账状态
     */
    public static $account_status = array('待确认', '已到账');

    /**
     * @function 通过订单号获取收入记录
     * @param $ordersn
     * @return mixed
     */
    public static function get_info_by_ordersn($ordersn)
    {
        return DB::select()
                 ->from('platform_income')
                 ->where('ordersn', '=', $ordersn)
                 ->execute()
                 ->current();
    }

    /**
     * @function 保存收入记录
     * @param array  $arr
     * @param string $id
     * @return bool
     */
    public static function save_info(array $arr, $id = '')
    {
        $ordersn = $arr['ordersn'];
        if (! $ordersn)
        {
            return false;
        }
        unset($arr['ordersn']);
        if ($id)
        {
            $orm = ORM::factory('platform_income', $id);
        }
        else
        {
            if (self::get_info_by_ordersn($ordersn))
            {
                $orm = ORM::factory('platform_income')
                          ->where('ordersn', '=', $ordersn)
                          ->find();
            }
            else
            {
                $orm = ORM::factory('platform_income');
                $orm->ordersn = $ordersn;
            }
        }
        foreach ($arr as $k => $v)
        {
            $orm->$k = $v;
        }

        $orm->save();
        if ($orm->saved())
        {
            return true;
        }

        return false;
    }

    /**
     * @function 获取所有可买产品模型
     * @return mixed
     */
    public static function get_all_pdt_modules()
    {
        return DB::select('id', 'modulename', 'pinyin')
                 ->from('model')
                 ->where('is_orderable', '=', 1)
                 ->execute()
                 ->as_array();
    }

    /**
     * @function 获取支付方式
     * @return mixed
     */
    public static function get_pay_sources()
    {
        return DB::select('paysource')
                 ->distinct('paysource')
                 ->from('member_order')
                 ->where('paysource', 'IS NOT', null)
                 ->execute()
                 ->as_array();
    }

    /**
     * @function 获取总记录数
     * @return mixed
     */
    public static function get_total_count($params)
    {
        $sql = 'SELECT COUNT(a.`id`) AS `total`';
        $sql .= 'FROM `sline_platform_income` AS `a` ';
        $sql .= 'LEFT JOIN `sline_member_order` AS b ON(a.`ordersn` = b.`ordersn`) ';
        $sql .= 'LEFT JOIN `sline_model` AS `c` ON(a.`type_id` = c.`id`) ';
        $sql .= 'WHERE 1 = 1 ';
        if ($params['type_id'])
        {
            $sql .= 'AND a.`type_id` = ' . $params['type_id'] . ' ';
        }
        if ($params['pay_type'])
        {
            $sql .= 'AND a.`pay_type` = \'' . $params['pay_type'] . '\' ';
        }
        if ($params['status'] != '')
        {
            $sql .= 'AND a.`status` = ' . $params['status'] . ' ';
        }
        if ($params['keyword'])
        {
            $sql .= "AND (a.`ordersn` LIKE '%{$params['keyword']}%' OR a.`linkman` LIKE '%{$params['keyword']}%' OR a.`linktel` LIKE '%{$params['keyword']}%') ";
        }

        return DB::query(1, $sql)->execute()->get('total', 0);
    }

    /**
     * @function 平台收入列表
     * @param array $array
     * @return mixed
     */
    public static function get_search_list(array $array = array())
    {
        $sql = 'SELECT a.`id`,a.`ordersn`,a.`type_id`,a.`amount`,a.`mid`,a.`pdt_type`,a.`pay_type`,';
        $sql .= 'a.`pdt_name`,a.`pay_time`,a.`status`,a.`operator`,a.`opt_time`,a.`amount`,';
        $sql .= 'c.`pinyin`,b.`id` AS `orderid`,';
        $sql .= 'b.`online_transaction_no` AS `pay_num`,';
        $sql .= 'b.`payment_proof` AS `pay_proof`,';
        $sql .= 'b.`saleman` AS `salesman`,';
        $sql .= 'b.`linkman`,';
        $sql .= 'b.`linktel` ';
        $sql .= 'FROM `sline_platform_income` AS `a` ';
        $sql .= 'LEFT JOIN `sline_member_order` AS b ON(a.`ordersn` = b.`ordersn`) ';
        $sql .= 'LEFT JOIN `sline_model` AS `c` ON(a.`type_id` = c.`id`) ';
        $sql .= 'WHERE 1 = 1 ';
        if ($array['type_id'])
        {
            $sql .= 'AND a.`type_id` = ' . $array['type_id'] . ' ';
        }
        if ($array['pay_type'])
        {
            $sql .= 'AND a.`pay_type` = \'' . $array['pay_type'] . '\' ';
        }
        if ($array['status'] != '')
        {
            $sql .= 'AND a.`status` = ' . $array['status'] . ' ';
        }
        if ($array['keyword'])
        {
            $sql .= "AND (a.`ordersn` LIKE '%{$array['keyword']}%' OR a.`linkman` LIKE '%{$array['keyword']}%' OR a.`linktel` LIKE '%{$array['keyword']}%') ";
        }
        if($array['start']&&$array['limit']){
            $sql .= " LIMIT {$array['start']},{$array['limit']}";
        }

        $rows = DB::query(1, $sql)
                  ->execute()
                  ->as_array();


        return $rows;
    }

    /**
     * @function 获取收入详情
     * @param $id
     * @return mixed
     */
    public static function get_info($id)
    {
        $sql = 'SELECT a.`id`,a.`ordersn`,a.`type_id`,a.`amount`,a.`mid`,a.`pdt_type`,a.`pay_type`,';
        $sql .= 'a.`pdt_name`,a.`pay_time`,a.`status`,a.`operator`,a.`opt_time`,a.`amount`,';
        $sql .= 'c.`pinyin`,b.`id` AS `orderid`,';
        $sql .= 'b.`online_transaction_no` AS `pay_num`,';
        $sql .= 'b.`payment_proof` AS `pay_proof`,';
        $sql .= 'b.`saleman` AS `salesman`,';
        $sql .= 'b.`linkman`,';
        $sql .= 'b.`linktel` ';
        $sql .= 'FROM `sline_platform_income` AS `a` ';
        $sql .= 'LEFT JOIN `sline_member_order` AS b ON(a.`ordersn` = b.`ordersn`) ';
        $sql .= 'LEFT JOIN `sline_model` AS `c` ON(a.`type_id` = c.`id`) ';
        $sql .= 'WHERE a.`id` = ' . $id;

        $info = DB::query(1, $sql)
                  ->execute()
                  ->current();

        $info['is_online'] = strpos($info['pay_type'], '线下支付') === false ? 1 : 0;

        return $info;
    }

    public static function income_excel($params){
        $table = "<table><tr>";
        $table .= "<th>订单号</th>";
        $table .= "<th>产品类别</th>";
        $table .= "<th>支付时间</th>";
        $table .= "<th>支付方式</th>";
        $table .= "<th>业务员</th>";
        $table .= "<th>联系人</th>";
        $table .= "<th>联系人电话</th>";
        $table .= "<th>实收额</th>";
        $table .= "<th>到账情况</th>";

        $table .= "</tr>";
        $arr=Model_Platform_Income::get_search_list($params);
        foreach ($arr as $row)
        {
            $table .= "<tr>";
            $table .= "<td style='vnd.ms-excel.numberformat:@'>{$row['ordersn']}</td>";
            $table .= "<td>{$row['pdt_type']}</td>";
            $row['pay_time']=$row['pay_time']?date('Y-m-d H:i:s', $row['pay_time']):'';
            $table .= "<td>" . $row['pay_time']."</td>";
            $table .= "<td>{$row['pay_type']}</td>";
            $table .= "<td>{$row['salesman']}</td>";
            $table .= "<td>{$row['linkman']}</td>";
            $table .= "<td>{$row['linktel']}</td>";
            $table .= "<td>{$row['amount']}</td>";
            if($row['status']==0){
                $row['_status']='待确认';
            }else{
                $row['_status']='已到账';
            }
            $table .= "<td>{$row['_status']}</td>";
            $table .= "</tr>";
        }

        $table .= "</table>";
        return $table;
    }
}