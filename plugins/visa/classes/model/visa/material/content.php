<?php defined('SYSPATH') or die('No direct script access.');

/**
 *Copyright www.deccatech.cn
 *Author: nilsir
 *QQ: 2758691158
 *Time: 2018/1/10 14:26
 *Desc:
 */
class Model_Visa_Material_Content extends ORM
{
    /**
     * @function 添加列
     * @param        $field ,列名
     * @param string $comment , 注释
     * @return bool
     */
    public static function add_column($field, $comment = '')
    {
        $sql = 'SHOW COLUMNS FROM `sline_visa_material_content`';

        $rows = DB::query(1, $sql)
                  ->execute()
                  ->as_array();
        $bool = true;
        foreach ($rows as $v)
        {
            if ($v['Field'] == $field)
            {
                $bool = false;
                break;
            }
        }
        if ($bool)
        {
            $sql = "ALTER TABLE `sline_visa_material_content` ADD COLUMN `{$field}` LONGTEXT NULL COMMENT '{$comment}(自定义)'";
            DB::query(1, $sql)
              ->execute();
        }

        return true;
    }

    /**
     * @function 删除列
     * @param $field
     * @return bool
     */
    public static function del_column($field)
    {
        $sql = 'SHOW COLUMNS FROM `sline_visa_material_content`';

        $rows = DB::query(1, $sql)
                  ->execute()
                  ->as_array();
        $bool = false;
        foreach ($rows as $v)
        {
            if ($v['Field'] == $field)
            {
                $bool = true;
                break;
            }
        }
        if ($bool)
        {
            $sql = "ALTER TABLE `sline_visa_material_content` DROP COLUMN `{$field}`";
            DB::query(1, $sql)
              ->execute();
        }

        return true;
    }

    /**
     * @function 获取签证人群详细内容
     * @param $visa_id
     * @param $field
     * @return mixed
     */
    public static function get_content($visa_id, $field)
    {
        return DB::select($field)
                 ->from('visa_material_content')
                 ->where('visa_id', '=', $visa_id)
                 ->execute()
                 ->get($field, '');
    }

    /**
     * @function 保存签证人群详细内容
     * @param $visa_id
     * @param $arr
     * @return bool
     * @throws Kohana_Exception
     */
    public static function save_content($visa_id, $arr)
    {
        $materials = Model_Visa_Material::get_list(1);
        $data = array();
        foreach ($materials as $v)
        {
            $data[$v['pinyin']] = $arr[$v['pinyin']];
        }
        unset($arr);

        $orm = ORM::factory('visa_material_content')
                  ->where('visa_id', '=', $visa_id)
                  ->find();
        if (! $orm->id)
        {
            $orm = ORM::factory('visa_material_content');
            $orm->visa_id = $visa_id;
        }
        foreach ($data as $k => $val)
        {
            $orm->$k = $val;
        }

        $orm->save();
        if ($orm->saved())
        {
            return true;
        }

        return false;
    }
}