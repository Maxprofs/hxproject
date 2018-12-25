<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/13 0013
 * Time: 9:16
 */
class Model_Ship_Line_Kindlist extends ORM
{
    /**
     * @function 根据目的地拼音获取tagword
     * @param $pinyin
     * @return string
     */
    public static function get_list_tag_word($pinyin)
    {
        if ($pinyin == 'all' || $pinyin == '')
        {
            return '';
        }
        $dest_id = DB::select('id')
                     ->from('destinations')
                     ->where('pinyin', '=', $pinyin)
                     ->execute()
                     ->get('id');
        if ($dest_id)
        {
            $tag_word = DB::select('tagword')
                          ->from('ship_line_kindlist')
                          ->where('kindid', '=', $dest_id)
                          ->execute()
                          ->get('tagword', '');

            return $tag_word;
        }

        return '';
    }
}