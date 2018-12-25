<?php define('DATAPATH', dirname(dirname(dirname(__FILE__))));
require_once(DATAPATH . "/slinesql.class.php");
//执行sql  $mysql->query
//检测数据 $mysql->check_data  bool
//检测字段 $mysql->check_column bool
//检测表   $mysql->check_table bool
//检测索引 $mysql->check_index bool
//获取错误 $mysql->error() void | string(错误信息)

//sline_menu_new
if ($mysql->check_table("sline_menu_new"))
{
    $sql = "delete from sline_menu_new where directory='share/admin' and controller='wxclient' and method='index' ";
    $mysql->query($sql);

    if (!$mysql->check_data("select * from sline_menu_new where pid=132;"))
    {
        $sql = "update sline_menu_new set isshow=0 where title in ('微信站点','微信端') and level=1";
        $mysql->query($sql);
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
if (isset($moduleArr['share_wx_client']))
{ 
    unset($moduleArr['share_wx_client']);
    file_put_contents($moduleFile, "<?php \r\n" . 'return ' . var_export($moduleArr, true) . ';');
}