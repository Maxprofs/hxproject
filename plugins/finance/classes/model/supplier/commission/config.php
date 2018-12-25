<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Supplier_Commission_Config extends ORM
{
    /**
     * @function 保存返佣通用配置
     * @param $varname
     * @param $value
     */
    public static function save_normal_config($varname, $value)
    {
        $model = ORM::factory('supplier_commission_config')->where('varname','=',$varname)->find();
        if($model->loaded())
        {
            $model->value = $value;
        }
        else
        {
            $model->varname = $varname;
            $model->value = $value;
        }
        $model->save();
    }
}