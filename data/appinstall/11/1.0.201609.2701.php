<?php define('DATAPATH', dirname(dirname(dirname(__FILE__))));
require_once(DATAPATH . "/slinesql.class.php");
//执行sql  $mysql->query
//检测数据 $mysql->check_data  bool
//检测字段 $mysql->check_column boo
//检测表   $mysql->check_table bool
//检测索引 $mysql->check_index bool
//获取错误 $mysql->error() void | string(错误信息)

function delete_data($sqls)
{
	global $mysql;
	foreach ($sqls as $k => $v)
	{
		$mysql->query("delete from {$k} {$v}");
	}
}

  


//清除数据
$sqls = array(

    'sline_page'=>"where pagename in ('customize_index') or (pid=0 and kindname='私人定制')",
    'sline_advertise_5x' => 'where is_pc="1" and is_system="1" and prefix="customize_index"',
);
delete_data($sqls);


