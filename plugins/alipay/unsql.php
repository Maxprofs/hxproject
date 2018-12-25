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
        'sline_menu_new'  => 'where pid=174 and title="支付宝"',
        //payset
        'sline_payset_1'  => 'where name="支付宝" and pinyin="alipay"',
        'sline_payset_11' => 'where name="支付宝即时到账" and pinyin="alipaycash"',
        'sline_payset_12' => 'where name="支付宝双功能" and pinyin="alipaydouble"',
        'sline_payset_13' => 'where name="支付宝担保交易" and pinyin="alipaydanbao"',
        'sline_payset_14' => 'where name="支付宝网银" and pinyin="alipaybank"',
    );
    foreach ($sqls as $k => $v)
    {
        if (strpos($k, 'payset') !== false)
        {
            $k = 'sline_payset';
        }
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
    if (isset($moduleArr['alipay']))
    {
        unset($moduleArr['alipay']);
        file_put_contents($moduleFile, "<?php \r\n" . 'return ' . var_export($moduleArr, true) . ';');
    }
}

delete_data();
del_module();