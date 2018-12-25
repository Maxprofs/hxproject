<?php defined('SYSPATH') or die('No direct script access.');


class Controller_Pc_Api_Standard_Destination extends Controller_Pc_Api_Base
{
    public function before()
    {
        parent::before();
    }

    //热门目的地
    public function action_query()
    {
        $result = array();
        $type_id = Common::remove_xss($this->request_body->content->model_type_id);
        $keyword = Common::remove_xss($this->request_body->content->keyword);
        switch ($type_id)
        {
            case 1:
                $product_dest_table = 'sline_line_kindlist';
                break;
            case 2:
                $product_dest_table = 'sline_hotel_kindlist';
                break;
            case 5:
                $product_dest_table = 'sline_spot_kindlist';
                break;
        }

        $sql = "select a.id,a.kindname,if(find_in_set({$type_id},opentypeids),1,0) as isopen,a.pinyin,b.ishot from sline_destinations a left join $product_dest_table b on a.id=b.kindid where a.isopen=1";
        if ($keyword)
        {
            $sql .= " and (a.kindname like '%{$keyword}%' or a.pinyin like '%{$keyword}%')";
            $result = DB::query(Database::SELECT, $sql)->execute()->as_array();
        }
        else
        {
            $result = array('hot' => array(), 'character' => array());
            foreach (range('A', 'Z') as $value)
            {
                $result['character'][$value] = array();
            }
            $list = DB::query(Database::SELECT, $sql)->execute()->as_array();
            foreach ($list as $item)
            {
                if ($item['ishot'])
                {
                    array_push($result['hot'], $item);
                }
                if ($item['pinyin'])
                {
                    $key = strtoupper($item['pinyin']{0});
                    array_push($result['character'][$key], $item);
                }
            }
            if ($result['hot'])
            {
                usort($result['hot'], array($this, '_sort_by_pinyin'));
            }
            foreach ($result['character'] as $k => $value)
            {
                if (!$value)
                {
                    unset($result['character'][$k]);
                    continue;
                }
                usort($result['character'][$k], array($this, '_sort_by_pinyin'));
            }
        }
        $this->send_datagrams($this->client_info['id'], $result, $this->client_info['secret_key']);
    }

    private function _sort_by_pinyin($a, $b)
    {
        return strcmp($a['pinyin'], $b['pinyin']);
    }
}