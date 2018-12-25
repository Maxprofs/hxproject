<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Api_Interop_Log extends ORM
{

    protected $_table_name = 'api_interop_log';

    public static function search($keyword, $client_id, $success, $start, $limit)
    {
        $result = array(
            'row_count' => 0,
            'data' => array()
        );

        $where = "
FROM
	sline_api_interop_log
	LEFT JOIN sline_api_client
ON
    sline_api_interop_log.client_id=sline_api_client.id
WHERE
    1=1 ";

        if ($keyword)
        {
            $where .= " and (
            sline_api_interop_log.url LIKE '%{$keyword}%'
            or sline_api_interop_log.msg LIKE '%{$keyword}%'
            or sline_api_interop_log.remote_info LIKE '%{$keyword}%'
            )";
        }

        if (is_numeric($client_id))
        {
            $where .= " and sline_api_interop_log.client_id={$client_id}";
        }

        if (is_numeric($success))
        {
            $where .= " and sline_api_interop_log.success={$success}";
        }


        $sql = "select count(*) as row_count {$where}";
        $list = DB::query(Database::SELECT, $sql)->execute()->as_array();
        $result['row_count'] = $list[0]['row_count'];

        $sql = "SELECT
        sline_api_interop_log.*,
        from_unixtime(sline_api_interop_log.action_time) as action_time_h,
        sline_api_client.name as api_client_name
      {$where}";
        $sql .= " ORDER BY sline_api_interop_log.action_time DESC";
        if ($start != "" && $limit != "")
        {
            $sql .= " LIMIT {$start},{$limit}";
        }

        $list = DB::query(Database::SELECT, $sql)->execute()->as_array();
        $result['data'] = $list;

        return $result;
    }

    public static function get_info($id)
    {
        $sql = "
        SELECT
        sline_api_interop_log.*,
        from_unixtime(sline_api_interop_log.action_time) as action_time_h,
        sline_api_client.name as api_client_name
        FROM
	sline_api_interop_log
	LEFT JOIN sline_api_client
ON
    sline_api_interop_log.client_id=sline_api_client.id
WHERE sline_api_interop_log.id={$id}";
        $result = DB::query(DataBase::SELECT, $sql)->execute()->as_array();
        if (count($result) <= 0)
            return null;
        else
            return $result[0];
    }

    public static function add_info(array $info)
    {
        //set_time
        unset($info['id']);
        $info['action_time'] = time();
        DB::insert('api_interop_log', array_keys($info))->values(array_values($info))->execute();

        $log_expire_time = strtotime("-30 day");
        DB::delete('api_interop_log')->where("action_time", "<=", $log_expire_time)->execute();
    }

    //获得访客真实ip
    public static function get_client_ip()
    {

        return empty($_SERVER['REMOTE_ADDR']) ? $_SERVER["HTTP_CLIENT_IP"] : $_SERVER['REMOTE_ADDR'];

    }

}