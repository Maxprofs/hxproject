<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Zt_Channel_Product extends ORM
{

    //删除数据
    public function delete_clear()
    {
        $this->delete();
    }

    /**
     * @function 栏目信息
     * @param $channelid
     * @return mixed
     */
    public static function add_product($channelid, $typeid, $productids)
    {
        foreach ($productids as $id)
        {
            if (!self::check_is_exists($id, $typeid, $channelid))
            {
                $data = array(
                    'channelid' => $channelid,
                    'typeid' => $typeid,
                    'productid' => $id
                );
                $result = DB::insert('zt_channel_product', array_keys($data))->values(array_values($data))->execute();
            }
        }


    }

    /**
     * @function 检测产品是否已经添加
     * @param $productid
     * @param $typeid
     * @param $channelid
     * @return int
     */
    public static function check_is_exists($productid, $typeid, $channelid)
    {
        $row = DB::select('id')->from('zt_channel_product')
            ->where('productid', '=', $productid)
            ->and_where('typeid', '=', $typeid)
            ->and_where('channelid', '=', $channelid)
            ->execute()
            ->current();
        return $row['id'] ? 1 : 0;
    }


    /**
     * @function 获取专题栏目已设置的产品
     * @param $channelid
     * @param $page
     * @param $pagesize
     * @return array
     */
    public static function get_product($channelid, $page, $pagesize)
    {
        $offset = $pagesize * ($page - 1);
        $arr = DB::select()->from('zt_channel_product')
            ->where('channelid', '=', $channelid)
            ->order_by('displayorder','ASC')
            ->offset($offset)
            ->limit($pagesize)
            ->execute()
            ->as_array();
        $out = array();
        foreach ($arr as &$row)
        {
            $product = self::get_product_info($row['typeid'], $row['productid']);
            if(!empty($product))
            {
                $product['id'] = $row['id'];
                $product['displayorder'] = $row['displayorder']==9999 ? '' : $row['displayorder'];
                array_push($out, $product);
            }


        }
        return $out;
    }

    /**
     * @function 获取栏目产品总量
     * @param $channelid
     * @return int
     */
    public static function get_total_num($channelid)
    {
        $t = DB::select()->from('zt_channel_product')->where('channelid', '=', $channelid)->execute()->as_array();
        $total = count($t);
        return $total;
    }

    /**
     * @function 获取产品的详细信息
     * @param $typeid
     * @param $productid
     * @return array
     */
    public static function get_product_info($typeid, $productid)
    {
        $info = Model_Model::get_module_info($typeid);
        $path = empty($info['correct']) ? $info['pinyin'] : $info['correct'];
        if (empty($info['maintable']))
        {
            return array();
        }
        $row = DB::select()
            ->from($info['maintable'])
            ->where('id', '=', $productid)
                // 只查询显示的产品
            ->and_where('ishidden', '=', 0)
            ->execute()
            ->current();
        if(empty($row))
        {
            return array();
        }
        $out = $row;
        $out['url'] = Zt::get_base_url($row['webid']) . '/' . $path . '/show_' . $row['aid'] . '.html';
        $out['series'] = St_Product::product_series($row['id'], $typeid);//编号
        if ($typeid != 4 && $typeid != 6)
        {
            $out['price'] = self::get_product_price($typeid, $row['id']);
        }
        $out['typeid'] = $typeid;
        $out['title'] = $row['title'];
        $out['typename'] = $info['modulename'];
        //自定义产品信息
        $infoModel = 'Model_' . $info['maintable'];
        if (is_callable(array($infoModel, 'custom_info')))
        {
            $productInfo = $infoModel::custom_info($row['id']);
            $out['price'] = $productInfo['price'];
            $out['url'] = $productInfo['url'];
        }
        if ($typeid == 6)
        {
            $out['summary'] = St_Functions::cutstr_html($row['description'], 20);
        }
        if ($typeid == 4)
        {
            $out['summary'] = $row['summary'];
        }
        return $out;
    }


    /**
     * @function 删除栏目里的产品
     * @param $id
     * @return object
     */
    public static function remove_product($id)
    {
        return DB::delete('zt_channel_product')->where('id', '=', $id)->execute();
    }

    /**
     * @function 设置产品排序
     * @param $id
     * @param $displayorder
     * @return mixed
     */
    public static function set_displayorder($id,$displayorder)
    {
        $arr = array(
            'displayorder' => $displayorder
        );
        return DB::update('zt_channel_product')->set($arr)->where('id','=',$id)->execute();
    }

    /**
     * @function 获取产品最低价
     * @param $typeid
     * @param $productid
     * @return array|int|number
     */
    public static function get_product_price($typeid, $productid)
    {

        switch ($typeid)
        {
            case 1:
                $price = Model_Line::get_minprice($productid);
                break;
            case 2:
                $price = Model_Hotel::get_minprice($productid);
                break;
            case 3:
                $price = Model_Car::get_minprice($productid);
                break;
            case 5:
                $row = Model_Spot::get_minprice($productid);
                $price = $row['price'];
                break;
            case 8:
                $row = Model_Visa::visa_detail_id($productid);
                $price = $row['price'];
                break;
            case 13:
                $row = Model_Tuan::tuan_detail_id($productid);
                $price = $row['price'];
                break;
            case 104:
                $price = Model_Ship_Line::get_minprice($productid, array());
                break;
            case 105:
                $price = Model_Campaign::get_minprice($productid, array());
                break;
            case 109:
                $price = DB::select('price')->from('duobao')->where('id', '=', $productid)->execute()->get('price');
                $price = Currency_Tool::price($price);
                break;
            case 114:
                $price = Model_Outdoor::get_minprice($productid);
                    break;
            default:
                $price = Model_Tongyong::get_minprice($productid);
        }
        return $price ? $price : 0;
    }


}