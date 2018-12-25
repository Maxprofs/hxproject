<?php define('DATAPATH', dirname(dirname(dirname(__FILE__))));
require_once(DATAPATH . "/slinesql.class.php");
//执行sql  $mysql->query
//检测数据 $mysql->check_data  bool
//检测字段 $mysql->check_column boo
//检测表   $mysql->check_table bool
//检测索引 $mysql->check_index bool
//获取错误 $mysql->error() void | string(错误信息)

//添加游记评论到菜单
$data = $mysql->query('SELECT * FROM sline_menu_new WHERE pid=1 AND typeid=101 AND title="游记"');
if ($data[0]['datainfo'])
{
    $implode = explode(',', $data[0]['datainfo']);
}
else
{
    $implode = array();
}
if (($index = array_search('3', $implode)) !== false)
{
    unset($implode[$index]);
    $sql = 'UPDATE sline_menu_new SET datainfo="' . implode(',', $implode) . '" WHERE pid=1 AND typeid=101 AND title="游记"';
    $mysql->query($sql);
}
