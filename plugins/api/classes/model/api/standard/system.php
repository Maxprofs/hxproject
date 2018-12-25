<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Api_Standard_System
{

    public static function get_model_type_list()
    {
        $sql = "SELECT
	id,
	modulename,
	pinyin,
	issystem,
	isopen
FROM
	sline_model";

        return DB::query(Database::SELECT, $sql)->execute()->as_array();

    }

    /*
     * 将相对文件url换成绝对文件url
     */
    public static function reorganized_resource_url($url)
    {
       // return (stripos(strtolower($url), "http://") !== 0 ? (empty($url) ? "" : "{$GLOBALS['cfg_basehost']}/{$url}") : $url);
	   if(!empty($url))
	   {
			$http = stripos(strtolower($url), 'http://') ;
			$https = stripos(strtolower($url), 'https://') ;
			if( $http === $https)
			{
			   return  $GLOBALS['cfg_basehost'] .'/'. $url;
			}
	   }
	   return $url;
    }

    /*
     * 将unix时间戳换成可识别时间字符串
     */
    public static function format_unixtime($unix_time)
    {
        return ($unix_time ? date("Y-m-d H:i:s", $unix_time) : "");
    }

    /**
     * 获取系统参数值
     */
    public static function get_sys_para($varname)
    {
         $v = DB::select('value')->from('sysconfig')->where('varname','=',$varname)->and_where('webid','=',0)->execute()->get('value');

         return  $v ? $v : '';
    }

    /**
     * @function 获取星期
     * @param $day
     * @return mixed
     */
    public static function get_weekday($day)
    {
        $w = date('w',$day);
        //注意上面返回的都是 数字,0123456.所以如果要显示中文的星期，可以定义下面的数组就可以了。
        $weekarray=array("日","一","二","三","四","五","六"); //0表示星期日
        return $weekarray[$w];
    }



}