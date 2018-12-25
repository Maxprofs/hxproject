<?php define('DATAPATH', dirname(dirname(dirname(__FILE__))));
require_once(DATAPATH . "/slinesql.class.php");
//执行sql  $mysql->query
//检测数据 $mysql->check_data  bool
//检测字段 $mysql->check_column boo
//检测表   $mysql->check_table bool
//检测索引 $mysql->check_index bool
//获取错误 $mysql->error() void | string(错误信息)

if($mysql->check_table("sline_api_client")){
    $mysql->query("DROP TABLE `sline_api_client`;");
    $mysql->error();
}

if($mysql->check_table("sline_api_interop_log")){
    $mysql->query("DROP TABLE `sline_api_interop_log`;");
    $mysql->error();
}


if ($mysql->check_table("sline_menu_new"))
{
    $mysql->query("DELETE FROM sline_menu_new where title='API客户端' and directory='api/admin' and controller='client' and method='index';");
    $mysql->query("DELETE FROM sline_menu_new where title='API交互日志' and directory='api/admin' and controller='interoplog' and method='index';");

    if (!$mysql->check_data("select * from sline_menu_new where pid=178 and isshow=1;"))
    {
        $mysql->query("UPDATE sline_menu_new SET isshow=0 WHERE id=178;");
    }
}

//卸载引导模块
define('BASEPATH', dirname(DATAPATH));
$moduleArr = array();
$moduleFile = BASEPATH . str_replace('/', DIRECTORY_SEPARATOR, '/data/module.php');

if (file_exists($moduleFile))
{
    $moduleArr = include $moduleFile;
}
if (isset($moduleArr['api']))
{ 
    unset($moduleArr['api']);
    file_put_contents($moduleFile, "<?php \r\n" . 'return ' . var_export($moduleArr, true) . ';');
}
