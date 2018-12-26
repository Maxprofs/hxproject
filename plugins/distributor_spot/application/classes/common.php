<?php defined('SYSPATH') or die('No direct script access.');
//引入公用函数库
require TOOLS_COMMON . 'functions.php';

class Common extends Functions
{
    /*
     * 获取扩展表
     * */
    public static function get_extend_table($typeid)
    {
        $row = parent::st_query('model',"id=$typeid",'*',true);

        return  $row['addtable'];
    }

    /*
     * 根据typeid获取扩展字段信息
     * */
    public static function get_extend_info($typeid, $productid)
    {
        $table = self::get_extend_table($typeid);
        $arr = parent::st_query($table,"productid='$productid'","*",true);
        return $arr;
    }

    /**
     * 上次报价记录
     * @param $modelId
     * @param $data
     * @return array
     */
    public static function last_offer($modelId, $data)
    {
        $lastOffer = array();
        switch ($modelId)
        {
            //线路
            case 1:
                $lastOffer = array(
                    'pricerule' => $data['pricerule'],
                    'adultbasicprice' => $data['adultbasicprice'],
                    'adultprofit' => $data['adultprofit'],
                    'adultprice' => $data['adultbasicprice'] + $data['adultprofit'],
                    'childbasicprice' => $data['childbasicprice'],
                    'childprofit' => $data['childprofit'],
                    'childprice' => $data['childbasicprice'] + $data['childprofit'],
                    'oldbasicprice' => $data['oldbasicprice'],
                    'oldprofit' => $data['oldprofit'],
                    'oldprice' => $data['oldbasicprice'] + $data['oldprofit'],
                    'starttime' => $data['starttime'],
                    'endtime' => $data['endtime'],
                );
                break;
            //酒店、租车
            case 2:
            case 3:
                $lastOffer = array(
                    'pricerule' => $data['pricerule'],
                    'basicprice' => $data['basicprice'],
                    'profit' => $data['profit'],
                    'price' => $data['basicprice'] + $data['profit'],
                    'starttime' => $data['starttime'],
                    'endtime' => $data['endtime'],
                );
                break;
        }
        return serialize($lastOffer);
    }

    public static function myDate($format, $timest)
    {
        $addtime = 8 * 3600;
        if (empty($format))
        {
            $format = 'Y-m-d H:i:s';
        }
        return gmdate($format, $timest + $addtime);
    }

    //加载指定模块的css
    public static function plugin_pinyin_css($filelist, $pinyin)
    {
        $filearr = explode(',', $filelist);
        $filelist = array();
        $out = '';
        foreach ($filearr as $file)
        {
            $plugin_file = '/'.basename(dirname(DOCROOT)).'/'.$pinyin."/public/css/{$file}";
            $tfile = dirname(DOCROOT).'/'.$pinyin.'/public/css/'.$file;
            if (file_exists($tfile))
            {
                $filelist[] = $plugin_file;
            }
        }

        if (!empty($filelist))
        {
            $f = implode(',', $filelist);
            $cssUrl = '/min/?f=' . $f;
            $out = '<link type="text/css" href="' . $cssUrl . '" rel="stylesheet"  />' . "\r\n";
        }
        return $out;
    }

    //加载指定模块的js
    public static function plugin_pinyin_js($filelist, $pinyin)
    {
        $filearr = explode(',', $filelist);
        $filelist = array();
        $out = '';
        foreach ($filearr as $file)
        {
            $plugin_file = '/'.basename(dirname(DOCROOT)).'/'.$pinyin."/public/js/{$file}";
            $tfile = dirname(DOCROOT).'/'.$pinyin.'/public/js/'.$file;
            if (file_exists($tfile))
            {
                $filelist[] = $plugin_file;
            }
        }
        if ($filelist)
        {
            //如果开启自动合并js
            $f = implode(',', $filelist);
            $jsUrl = '/min/?f=' . $f;
            $out = '<script type="text/javascript" src="' . $jsUrl . '"></script>' . "\r\n";

        }
        return $out;
    }



}
