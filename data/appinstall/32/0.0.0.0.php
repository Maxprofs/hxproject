<?php define('DATAPATH', dirname(dirname(dirname(__FILE__))));
require_once(DATAPATH . "/slinesql.class.php");
//执行sql  $mysql->query
//检测数据 $mysql->check_data  bool
//检测字段 $mysql->check_column boo
//检测表   $mysql->check_table bool
//检测索引 $mysql->check_index bool
//获取错误 $mysql->error() void | string(错误信息)
$menu = $mysql->query("select id from sline_menu_new WHERE `title`='红包'");
$pid = $menu[0]['id'];

$mysql->query("delete from sline_menu_new WHERE   pid=$pid or id=$pid");


//卸载引导模块
define('BASEPATH', dirname(DATAPATH));
$moduleArr = array();
$moduleFile = BASEPATH . str_replace('/', DIRECTORY_SEPARATOR, '/data/module.php');
if (file_exists($moduleFile))
{
    $moduleArr = include $moduleFile;
}
if (isset($moduleArr['red_envelope']))
{
    unset($moduleArr['red_envelope']);
    file_put_contents($moduleFile, "<?php \r\n" . 'return ' . var_export($moduleArr, true) . ';');
}