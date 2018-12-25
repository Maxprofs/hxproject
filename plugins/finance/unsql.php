<?php define('DATAPATH', dirname(dirname(dirname(__FILE__))));
require_once(DATAPATH . "/slinesql.class.php");
//执行sql  $mysql->query
//检测数据 $mysql->check_data  bool
//检测字段 $mysql->check_column boo
//检测表   $mysql->check_table bool
//检测索引 $mysql->check_index bool
//获取错误 $mysql->error() void | string(错误信息)

delete_data();
//delete_table();
//添加核心数据
function delete_data()
{
    global $mysql;
    $sqls = array(
        'sline_menu_new' => "where controller='financeextend' ",
        'sline_member_order_listener'=> "where execute_url like '%financeextend/order_set_count_info%'",
    );
    foreach ($sqls as $k => $v)
    {
        $mysql->query("delete from {$k} {$v}");
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
if (isset($moduleArr['finance']))
{
    unset($moduleArr['finance']);
    file_put_contents($moduleFile, "<?php \r\n" . 'return ' . var_export($moduleArr, true) . ';');
}
