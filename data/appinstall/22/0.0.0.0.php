<?php define('DATAPATH', dirname(dirname(dirname(__FILE__))));
require_once(DATAPATH . "/slinesql.class.php");
//执行sql  $mysql->query
//检测数据 $mysql->check_data  bool
//检测字段 $mysql->check_column bool
//检测表   $mysql->check_table bool
//检测索引 $mysql->check_index bool
//获取错误 $mysql->error() void | string(错误信息)

//sline_menu
if ($mysql->check_table("sline_menu"))
{
    $parent = array(0, '供应商', 'supplier');
    $supplier = array(
        array('logo设置', 'logo', 1, 1, '/plugins/supplier/set/logo/parentkey/supplier/itemid/1'),
        array('底部设置', 'footer', 2, 1, '/plugins/supplier/set/footer/parentkey/supplier/itemid/2'),
    );

    foreach ($supplier as $v)
    {
        $sql = "select * from sline_menu where extlink={$v[3]} and extraparam='{$v[4]}'";
        if ($mysql->check_data($sql))
        {
            $sql = "delete from sline_menu where  extlink={$v[3]} and extraparam='{$v[4]}'";
            $mysql->query($sql);
        }
    }

    $sql = "select * from sline_menu where pid={$parent[0]} and title='{$parent[1]}' and entitle='{$parent[2]}'";
    if ($mysql->check_data($sql))
    {
        $sql = "delete from sline_menu where pid={$parent[0]} and title='{$parent[1]}' and entitle='{$parent[2]}'";
        $mysql->query($sql);
    }
}

//sline_menu_new
if ($mysql->check_table("sline_menu_new"))
{
    foreach ($supplier as $v)
    {
        if ($mysql->check_data("select * from sline_menu_new where extlink={$v[3]} and extparams='{$v[4]}';"))
        {
            $mysql->query("delete from  `sline_menu_new`  where extlink={$v[3]} and extparams='{$v[4]}';");
        }

    }
}
