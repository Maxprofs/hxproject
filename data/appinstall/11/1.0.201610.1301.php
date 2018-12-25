<?php define('DATAPATH', dirname(dirname(dirname(__FILE__))));
require_once(DATAPATH . "/slinesql.class.php");
//执行sql  $mysql->query
//检测数据 $mysql->check_data  bool
//检测字段 $mysql->check_column boo
//检测表   $mysql->check_table bool
//检测索引 $mysql->check_index bool
//获取错误 $mysql->error() void | string(错误信息)

$mysql->query('update sline_menu_new set directory=\'customize/admin\',controller=\'customize\',method=\'sms\',extparams=\'/typeid/{$typeid}\' where typeid=14 and level=2 and title=\'短信通知\';');
$mysql->query('update sline_menu_new set directory=\'customize/admin\',controller=\'customize\',method=\'email\',extparams=\'/typeid/{$typeid}\' where typeid=14 and level=2 and title=\'邮件通知\';');




