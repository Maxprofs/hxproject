<?php define('DATAPATH', dirname(dirname(dirname(__FILE__))));
require_once(DATAPATH . "/slinesql.class.php");
//执行sql  $mysql->query
//检测数据 $mysql->check_data  bool
//检测字段 $mysql->check_column boo
//检测表   $mysql->check_table bool
//检测索引 $mysql->check_index bool
//获取错误 $mysql->error() void | string(错误信息)

if ($mysql->check_table("sline_menu_new"))
{
    $mysql->query("delete from sline_menu_new where title='登录背景' and level=3 and extlink=1 and extparams='/plugins/supplier/set/loginbg/parentkey/supplier/itemid/3';");

}

