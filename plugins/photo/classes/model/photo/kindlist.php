<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Photo_Kindlist extends ORM {

    protected  $_table_name = 'photo_kindlist';
	
	
	public function deleteClear()
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
                          ->from('photo_kindlist')
                          ->where('kindid', '=', $dest_id)
                          ->execute()
                          ->get('tagword', '');

            return $tag_word;
        }

        return '';
    }

}