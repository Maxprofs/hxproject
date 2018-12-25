<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Api_Client extends ORM
{

    protected $_table_name = 'api_client';

    public static function search($keyword, $status, $start, $limit)
    {
        $result = array(
            'row_count' => 0,
            'data' => array()
        );

        $where = "
FROM
	sline_api_client
WHERE
    1=1 ";

        if ($keyword)
        {
            $where .= " and (
            `name` LIKE '%{$keyword}%'
            or `secret_key` LIKE '%{$keyword}%'
            )";
        }

        if (is_numeric($status))
        {
            $where .= " and status={$status}";
        }


        $sql = "select count(*) as row_count {$where}";
        $list = DB::query(Database::SELECT, $sql)->execute()->as_array();
        $result['row_count'] = $list[0]['row_count'];

        $sql = "SELECT
        *
      {$where}";
        $sql .= " ORDER BY `id` DESC";
        if ($start != "" && $limit != "")
        {
            $sql .= " LIMIT {$start},{$limit}";
        }

        $list = DB::query(Database::SELECT, $sql)->execute()->as_array();
        $result['data'] = $list;

        return $result;
    }

    public static function get_all_info()
    {
        return DB::query(DataBase::SELECT, "select * from sline_api_client")->execute()->as_array();
    }

    public static function get_info($id)
    {
        $result = DB::query(DataBase::SELECT, "select * from sline_api_client where id={$id}")->execute()->as_array();
        if (count($result) <= 0)
            return null;
        else
            return $result[0];
    }

    public static function update_info(array $info)
    {
        if (empty($info['id']))
        {
            unset($info['id']);
            $info['secret_key'] = self::guid();
            DB::insert('api_client', array_keys($info))->values(array_values($info))->execute();
        } else
        {
            DB::update('api_client')->set($info)->where('id', '=', $info['id'])->execute();
        }
    }

    public static function delete_info($id)
    {
        DB::delete('api_client')->where('id', '=', $id)->execute();
    }

    public static function reset_secret_key($id)
    {
        $guid = self::guid();
        $info = array('secret_key' => $guid);

        DB::update('api_client')->set($info)->where('id', '=', $id)->execute();
    }

    public static function guid()
    {
        if (function_exists('com_create_guid'))
        {
            $uuid = com_create_guid();
        } else
        {
            mt_srand((double)microtime() * 10000); //optional for php 4.2.0 and up.
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45); // "-"
            $uuid = chr(123) // "{"
                . substr($charid, 0, 8) . $hyphen
                . substr($charid, 8, 4) . $hyphen
                . substr($charid, 12, 4) . $hyphen
                . substr($charid, 16, 4) . $hyphen
                . substr($charid, 20, 12)
                . chr(125);
            // "}"
        }
        return strtolower(preg_replace('/[{}-]/is', '', $uuid));
    }
}