<?php defined('SYSPATH') or die('No direct access allowed.');

/**
 * 微信小程序处理过滤函数
 * Class Model_Api_Standard_Xcx
 */
class Model_Api_Standard_Xcx
{

    function filter_content($content)
    {
        $preg = '/<img.*?src=[\"|\'](.*?)[\"|\']?\s(.*?)>/i';

        $content = preg_replace_callback(
            $preg,
            function ($matches) {
                $src = $matches[1];
                if(strpos($src,'http')===false)
                {
                    $src = Model_Api_Standard_System::reorganized_resource_url($src);
                }
                return '<img src="'.$src.'" '.$matches[2].'>';
            },
            $content
        );
        return $content;


    }

}