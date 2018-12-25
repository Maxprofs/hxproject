<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Created by PhpStorm.
 * Author: daisc
 * QQ: 2444329889
 * Time: 2017/12/20 10:30
 * Desc: desc
 */

class Model_Contract extends ORM
{

    /**
     * @function 获取可用模块
     */
    public static function get_opentypes()
    {
        $types = '1,114';//目前只有线路和户外可用
        $sql = "select a.id,b.shortname from sline_model as a LEFT JOIN sline_nav as b on a.id=b.typeid and b.webid=0
WHERE a.id in ($types)";
        return DB::query(1,$sql)->execute()->as_array();
    }


    /**
     * @function 获取乙方配置
     */
    public static function get_contract_config($id,$webid=0)
    {
//        $files = array(
//            'cfg_contract_name',
//            'cfg_contract_phone',
//            'cfg_contract_seal',
//        );
//        return Model_Sysconfig::get_configs(0, $files);
        $query = DB::select()->from('contract_partyb')->where('status','=',1)->and_where('webid','=',$webid);
        if($id)
        {
            $list=$query->and_where('id','=',intval($id))->execute()->current();
        }
        else
        {
            $list = $query->execute()->as_array();
        }
        return $list;
    }


    /**
     * @function 获取产品类可用的合同列表
     * @param $typeid
     */
    public static function get_product_contract_list($typeid)
    {
        $list = DB::select('id','title')->from('contract')
            ->where('status','=',1)->and_where('typeid','=',$typeid)
            ->execute()->as_array();
        return $list;
    }

    /**
     * @function 获取合同内容
     * @param $id
     */
    public static function get_contents($id,$typeid)
    {
        return DB::select('content','title')
            ->from('contract')
            ->where('id','=',$id)
            ->and_where('status','=',1)
            ->and_where('typeid','=',$typeid)
            ->execute()->current();
    }


    /**
     * @function 格式化订单数据
     */
    public static function format_order_data($order)
    {
        $order['series'] = St_Product::product_series($order['productautoid'], $order['typeid']);
        $order['suitname'] = self::_get_suitname($order);
        if($order['typeid']==1)
        {
            $line = DB::select()->from('line')->where('id','=',$order['productautoid'])
                ->execute()->current();
            $order['line'] = $line;
        }
        return $order;

    }






    private static function _get_suitname($order)
    {
        switch ($order['typeid'])
        {
            case 1:
                return DB::select('suitname')->from('line_suit')
                    ->where('id','=',$order['suitid'])->execute()->get('suitname');


        }


    }


    public static function get_content($params)
    {
        $default = array(
            'typeid' => '',
            'productinfo' => 0,
            'onlyrealfield' => 0,
            'pc' => 0

        );
        $params = array_merge($default, $params);
        extract($params);
        if (empty($typeid)) return array();
        $tables = array(
            '1' => 'sline_line_content',
            '2' => 'sline_hotel_content',
            '3' => 'sline_car_content',
            '5' => 'sline_spot_content',
            '8' => 'sline_visa_content',
            '13' => 'sline_tuan_content'
        );
        $extend_tables = array(
            '1' => 'sline_line_extend_field',
            '2' => 'sline_hotel_extend_field',
            '3' => 'sline_car_extend_field',
            '5' => 'sline_spot_extend_field',
            '8' => 'sline_visa_extend_field',
            '13' => 'sline_tuan_extend_field'
        );
        $table = $tables[$typeid];
        $extend_tables = $extend_tables[$typeid];
        $where = '';
        if (empty($table))
        {
            //扩展产品
            $isExists = DB::select()->from('model')->where("id={$typeid}")->execute()->current();
            if (empty($isExists))
            {
                return '';
            }
            $table = 'sline_model_content';
            $extend_tables = "sline_{$isExists['addtable']}";
            $where = 'typeid=' . $typeid . ' and ';
        }
        $sql = "SELECT columnname,chinesename,isrealfield FROM {$table} ";
        $sql .= "WHERE $where webid=0 and isopen=1 ";
        $sql .= "ORDER BY displayorder ASC";
        $arr = DB::query(1, $sql)->execute()->as_array();

        //扩展表数据
        $productid = $productinfo['id'];//产品id
        $sql = "SELECT * FROM $extend_tables WHERE productid='$productid'";
        $ar = DB::query(1, $sql)->execute()->as_array();
        $list = array();
        foreach ($arr as $v)
        {
            if ($v['columnname'] == 'tupian')
            {
                continue;
            }
            if ($v['isrealfield'] == 1)
            {
                $content = !empty($productinfo[$v['columnname']]) ? $productinfo[$v['columnname']] : $ar[0][$v['columnname']];
                $content = $content ? $content : '';
            }
            //是否只显示真实字段
            else if ($onlyrealfield == 1)
            {
                $content = '';
            }
            else
            {
                $content = $productid;
            }
            //行程附件
            if ($v['columnname'] == 'linedoc')
            {
                if ('array' == strtolower($content))
                {
                    $content = null;
                }
            }
            if (empty($content) && $v['columnname'] != 'payment')
            {
                continue;
            }

            $a = array();
            $a['columnname'] = $v['columnname'];
            $a['chinesename'] = $v['chinesename'];
            if ($typeid == 1 && $v['columnname'] == 'jieshao' && $productinfo['isstyle'] == 2)
            {
                $lineContent = DB::query(1, "SELECT * FROM sline_line_jieshao where lineid ={$content} and `day`=1 and title!='' and title is not null")->execute()->current();
                if (!$lineContent)
                {
                    continue;
                }
            }
            if($typeid == 1 && $v['columnname'] == 'jieshao' && $productinfo['isstyle'] == 1)
            {
                $content = $productinfo['jieshao'];
                if(empty($content))
                {
                    continue;
                }
            }
            // $content = Product::replace_strong_to_span($content);
            $a['content'] = $pc == 0 ? Product::strip_style($content) : $content; //针对PC/手机版选择是否去样式.
            $list[] = $a;

        }
        return $list;
    }








}