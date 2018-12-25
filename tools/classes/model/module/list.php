<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Module_List extends ORM
{

    public static function search_block($keyword, $module_id, $issystem, $start, $limit)
    {
        $result = array(
            'row_count' => 0,
            'data' => array()
        );

        $where = "
FROM
	sline_module_list
WHERE
    version=5 ";

        if ($keyword)
        {
            $where .= " and (
            modulename LIKE '%{$keyword}%'
            )";
        }

        if (is_numeric($module_id))
        {
            $where .= " and type={$module_id}";
        }

        if (is_numeric($issystem))
        {
            $where .= " and issystem={$issystem}";
        }


        $sql = "select count(*) as row_count {$where}";
        $list = DB::query(Database::SELECT, $sql)->execute()->as_array();
        $result['row_count'] = $list[0]['row_count'];

        $sql = "SELECT
        id,
        aid,
        modulename,
        issystem,
        type,
        '' as type_name,
        version
      {$where}";
        $sql .= " ORDER BY issystem,id desc";
        if ($start != "" && $limit != "")
        {
            $sql .= " LIMIT {$start},{$limit}";
        }

        $list = DB::query(Database::SELECT, $sql)->execute()->as_array();
        $module_list = Model_Module_Config::get_module_list();
        foreach ($list as &$item)
        {
            foreach ($module_list as $module)
            {
                if ($item["type"] == $module["id"])
                {
                    $item["type_name"] = $module["name"];
                    break;
                }
            }
        }

        $result['data'] = $list;
        return $result;
    }

    public static function get_block($id)
    {
        $sql = "
        SELECT
        id,
        aid,
        modulename,
        body,
        issystem,
        type,
        version
        FROM
	sline_module_list
WHERE version=5 and id={$id}";
        $result = DB::query(DataBase::SELECT, $sql)->execute()->as_array();
        if (count($result) <= 0)
            return null;
        else
            return $result[0];
    }

    public static function add_block(array $info)
    {
        //set_time
        unset($info['id']);
        $info['aid'] = Common::getLastAid('sline_module_list');
        $info['webid'] = 0;
        $info['version'] = 5;
        DB::insert('module_list', array_keys($info))->values(array_values($info))->execute();

    }

    public static function update_block(array $info)
    {
        $info['webid'] = 0;
        $info['version'] = 5;
        DB::update('module_list')->set($info)->where("id", "=", $info['id'])->execute();

    }

    public static function delete_block($id)
    {
        DB::delete('module_list')->where(DB::expr("find_in_set(id,'{$id}')"), ">", 0)->execute();
    }
}