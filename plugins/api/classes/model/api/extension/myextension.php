<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Api_Extension_MyExtension extends ORM
{

    public static function test()
    {
        return "ok";
    }

}