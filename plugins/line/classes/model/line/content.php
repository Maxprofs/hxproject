<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Line_Content extends ORM
{

    public static function field(){


    }

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
        $arr = DB::select_array(array('chinesename','columnname'))->from('line_content')->where('columnname','like','e_%')->execute()->as_array();
        foreach($arr as $row)
        {
                $data = array('description'=>$row['chinesename']);
                DB::update('extend_field')->set($data)->where('fieldname','=',$row['columnname'])->and_where('typeid','=',1)->execute();
        }
    }
}