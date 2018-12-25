<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Hotel_Content extends ORM {


    public static function add_content_field($field, $description)
    {

        $model = new self;
        $model = $model->where('columnname', '=', $field)->find();
        $model->columnname = $field;
        $model->chinesename = $description;
        $model->issystem = 0;
        $model->isopen = 1;
        $model->isrealfield = 1;
        $model->displayorder = 99;
        $model->webid=0;
        if ($model->save())
        {
            $model->reload();
            return $model->as_array();
        }
        else
        {
            return false;
        }
    }

    /**
     * @function 更新扩展字段描述
     */
    public static function update_extend_field_name()
    {
        $typeid = 2;
        $arr = DB::select_array(array('chinesename','columnname'))->from('hotel_content')->where('columnname','like','e_%')->execute()->as_array();
        foreach($arr as $row)
        {
            $data = array('description'=>$row['chinesename']);
            DB::update('extend_field')->set($data)->where('fieldname','=',$row['columnname'])->and_where('typeid','=',$typeid)->execute();
        }
    }
}