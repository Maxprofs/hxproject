<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Hotel_Kindlist extends ORM {

    protected  $_table_name = 'hotel_kindlist';
	
	
	public function delete_clear()
	{
		$this->delete();
	}

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
                          ->from('hotel_kindlist')
                          ->where('kindid', '=', $dest_id)
                          ->execute()
                          ->get('tagword', '');

            return $tag_word;
        }

        return '';
    }
}