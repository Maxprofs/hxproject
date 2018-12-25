<?php
defined('SYSPATH') or die('No direct access allowed.');

class Model_Photo_Picture extends ORM
{
	public function deleteClear()
    {
        $this->delete();
    }
    public static function get_pictures_bypid($pid)
    {
        if(empty($pid))
            return null;
        $list=ORM::factory('photo_picture')->where("pid=$pid")->get_all();
        $result=array();
        foreach($list as $k=>$v)
        {
            $result[]=array('litpic'=>$v['litpic'],'desc'=>$v['description']);
        }
        return $result;
    }

}