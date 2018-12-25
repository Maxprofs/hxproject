<?php define('DATAPATH', dirname(dirname(dirname(__FILE__))));
require_once(DATAPATH . "/slinesql.class.php");
//执行sql  $mysql->query
//检测数据 $mysql->check_data  bool
//检测字段 $mysql->check_column bool
//检测表   $mysql->check_table bool
//检测索引 $mysql->check_index bool
//获取错误 $mysql->error() void | string(错误信息)
/*INSERT INTO `www_standsmore_com`.`sline_menu_new` (`id`, `pid`, `level`, `typeid`, `title`, `directory`, `controller`, `method`, `datainfo`, `isshow`, `displayorder`, `extparams`, `extlink`) VALUES ('241', '213', '2', '104', '短信通知', 'shipadmin', 'shipline', 'sms', NULL, '1', '9999', NULL, '0');
INSERT INTO `www_standsmore_com`.`sline_menu_new` (`id`, `pid`, `level`, `typeid`, `title`, `directory`, `controller`, `method`, `datainfo`, `isshow`, `displayorder`, `extparams`, `extlink`) VALUES ('242', '213', '2', '104', '邮件通知', 'shipadmin', 'shipline', 'email', NULL, '1', '9999', NULL, '0');


*/

//创建信息表integral_index
