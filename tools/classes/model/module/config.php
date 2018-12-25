<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Module_Config extends ORM
{

    public static function get_page_module_info()
    {
        $page_list = Common::format_page_name(false);
        return $page_list["mould"];
    }

    public static function get_page_info($pid = 0)
    {
        $page_list = Common::format_page_name(false);
        $page_list = $page_list["page"];
        $page_list = array_values($page_list);
        if (!empty($pid))
        {
            $page_count = count($page_list);
            for ($index = 0; $index < $page_count; $index++)
            {
                if ($page_list[$index]["pid"] != $pid)
                {
                    unset($page_list[$index]);
                }
            }
        }
        $page_list = array_values($page_list);
        return $page_list;
    }

    public static function get_module_list()
    {
        $module_raw_list = ORM::factory('model')->get_all();

        $module_list = array(array(
            "id" => 0,
            "name" => "公共模块"
        ));
        foreach ($module_raw_list as $module_raw)
        {
            $module_list[] = array(
                "id" => $module_raw["id"],
                "name" => "{$module_raw["modulename"]}模块"
            );
        }

        return $module_list;
    }

    public static function get_selected_block($webid, $pagename)
    {
        $resolve_pagename_result = self::resolve_pagename($pagename);
        $row = DB::select('moduleids')
            ->from('module_config')
            ->where('typeid', '=', $resolve_pagename_result["typeid"])
            ->and_where('shortname', '=', $resolve_pagename_result["shortname"])
            ->and_where('webid', '=', $webid)
            ->execute()
            ->current();

        if (!empty($row['moduleids']))
        {
            $sql = "select modulename,aid,version,issystem,type from sline_module_list where find_in_set(aid,'{$row['moduleids']}')";
            $rows = DB::query(Database::SELECT, $sql)->execute()->as_array();

            $moduleids_array = explode(",", $row['moduleids']);
            $result = array();
            foreach ($moduleids_array as $moduleid)
            {
                foreach ($rows as $row)
                {
                    if ($row["aid"] == $moduleid)
                    {
                        $result[] = $row;
                        break;
                    }
                }
            }
            return $result;
        }

        return array();
    }

    public static function get_module_block($typeid, $exclude_ids = null, $issystem = null, $version = 5)
    {
        $db = DB::select("modulename", "aid", "version", "issystem", "type")
            ->from('module_list')
            ->where('type', '=', $typeid);
        if (is_numeric($issystem))
        {
            $db->and_where('issystem', '=', $issystem);
        }
        if (is_numeric($version))
        {
            $db->and_where('version', '=', $version);
        }
        if (!empty($exclude_ids))
        {
            $db->and_where(DB::expr("not find_in_set(aid,'{$exclude_ids}')"), ">", 0);
        }

        return $db->execute()->as_array();
    }

    public static function save_page_block($webid, $pagename, $pagename_title, $blockids)
    {
        $resolve_pagename_result = self::resolve_pagename($pagename);

        DB::delete('module_config')
            ->where('typeid', '=', $resolve_pagename_result["typeid"])
            ->and_where('shortname', '=', $resolve_pagename_result["shortname"])
            ->and_where('webid', '=', $webid)
            ->execute();

        DB::insert('module_config', array("webid", "pagename", "shortname", "typeid", "moduleids"))
            ->values(array($webid, $pagename_title, $resolve_pagename_result["shortname"], $resolve_pagename_result["typeid"], $blockids))
            ->execute();

    }

    public static function resolve_pagename($pagename)
    {
        $result = array(
            'typeid' => 0,
            'shortname' => $pagename
        );

        $pagename_arr = explode("_", $pagename);
        if ($pagename_arr[0] == "ship")
        {
            $result["typeid"] = 104;
            $result["shortname"] = trim(str_ireplace("ship", "", $pagename), "_");
            return $result;
        }

        for ($length = count($pagename_arr); $length > 0; $length--)
        {
            $pinyin = implode("_", array_slice($pagename_arr, 0, $length));
            $sql = "select id from sline_model where pinyin='{$pinyin}'";

            $row = DB::query(Database::SELECT, $sql)->execute()->as_array();
            if (count($row) > 0)
            {
                $result["typeid"] = $row[0]["id"];
                $result["shortname"] = trim(str_ireplace($pinyin, "", $pagename), "_");
                return $result;
            }
        }

        return $result;
    }

}