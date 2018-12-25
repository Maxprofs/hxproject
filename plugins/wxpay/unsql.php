<?php define('DATAPATH', dirname(dirname(dirname(__FILE__))));
require_once(DATAPATH . "/slinesql.class.php");
define('BASEPATH', dirname(DATAPATH));
//执行sql  $mysql->query
//检测数据 $mysql->check_data  bool
//检测字段 $mysql->check_column boo
//检测表   $mysql->check_table bool
//检测索引 $mysql->check_index bool
//获取错误 $mysql->error() void | string(错误信息)
function delete_data()
{
    global $mysql;
    $sqls = array(
        //menu_new
        'sline_menu_new'  => 'where pid=174 and title="微信"',
        //payset
        'sline_payset'  => 'where name="微信支付" and pinyin="wxpay"',
    );
    foreach ($sqls as $k => $v)
    {
        $mysql->query("delete from {$k} {$v}");
    }
}

function del_module()
{
    $moduleArr = array();
    $moduleFile = DATAPATH . DIRECTORY_SEPARATOR . 'module.php';
    if (file_exists($moduleFile))
    {
        $moduleArr = include $moduleFile;
    }
    if (isset($moduleArr['wxpay']))
    {
        unset($moduleArr['wxpay']);
        file_put_contents($moduleFile, "<?php \r\n" . 'return ' . var_export($moduleArr, true) . ';');
    }
}

delete_data();
del_module();