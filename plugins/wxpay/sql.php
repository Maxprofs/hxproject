<?php define('DATAPATH', dirname(dirname(dirname(__FILE__))));


require_once(DATAPATH . "/slinesql.class.php");
//执行sql  $mysql->query
//检测数据 $mysql->check_data  bool
//检测字段 $mysql->check_column boo
//检测表   $mysql->check_table bool
//检测索引 $mysql->check_index bool
//获取错误 $mysql->error() void | string(错误信息)

//写入数据到数据库
function write_data($data, $table, $returnInsertId = false)
{
    global $mysql;
    //格式化数据
    foreach ($data as &$v)
    {
        if (is_string($v))
        {
            $v = "'{$v}'";
        }
        if (is_null($v))
        {
            $v = "''";
        }
    }
    $sql = "INSERT INTO `{$table}` (" . implode(',', array_keys($data)) . ") VALUES (" . implode(',', array_values($data)) . ");";
    $mysql->query($sql);
    if ($returnInsertId)
    {
        return $mysql->last_insert_id();
    }
}

function update_data($data, $table, $id)
{
    global $mysql;
    //格式化数据
    $clumns = '';
    if (isset($data['id']))
    {
        unset($data['id']);
    }
    foreach ($data as $key => &$v)
    {
        if (is_string($v))
        {
            $v = "'{$v}'";
        }
        if (is_null($v))
        {
            $v = "''";
        }

        $clumns .= '`' . $key . '`' . '=' . $v . ',';
    }
    $clumns = rtrim($clumns, ',');
    $sql = 'UPDATE ' . '`' . $table . '`' . ' SET ' . $clumns . ' WHERE `id` = ' . $id;

    $mysql->query($sql);

}

function get_auto_id($sql)
{
    global $mysql;
    $rtn = $mysql->query($sql);
    if (! empty($rtn))
    {
        return $rtn[0]['id'];
    }

    return false;
}


function add_menu_new_data()
{
    $sql = 'SELECT `id` FROM `sline_menu_new` WHERE `title`=\'微信\' AND `pid` = 174 LIMIT 1';
    $auto_id = get_auto_id($sql);
    $data = array(
        'pid'          => 174,
        'level'        => 2,
        'title'        => '微信',
        'directory'    => 'wxpay/admin',
        'controller'   => 'wxpay',
        'method'       => 'index',
        'isshow'       => 1,
        'displayorder' => 9999,
    );

    if ($auto_id)
    {
        update_data($data, 'sline_menu_new', $auto_id);
    }
    else
    {
        write_data($data, 'sline_menu_new');
    }

}

function add_payset_data()
{
    //微信支付
    $sql = 'SELECT `id` FROM `sline_payset` WHERE `name`=\'微信支付\' AND `pinyin` = \'wxpay\' LIMIT 1';
    $auto_id = get_auto_id($sql);
    $data = array(
        'id'           => 8,
        'name'         => '微信支付',
        'pinyin'       => 'wxpay',
        'litpic'       => '/uploads/payset/8.png',
        'isopen'       => 1,
        'issystem'     => 0,
        'description'  => '',
        'displayorder' => 9999,
        'platform'     => 0,
        'icon'         => '/uploads/payset/pay_wx.gif',
    );
    if ($auto_id)
    {
        update_data($data, 'sline_payset', $auto_id);
    }
    else
    {
        write_data($data, 'sline_payset');
    }
}

function add_module()
{
    $moduleArr = array();
    $moduleFile = DATAPATH . DIRECTORY_SEPARATOR . 'module.php';
    if (file_exists($moduleFile))
    {
        $moduleArr = include $moduleFile;
    }
    if (! isset($moduleArr['wxpay']))
    {
        $moduleArr['wxpay'] = '/plugins/wxpay';
        file_put_contents($moduleFile, "<?php \r\n" . 'return ' . var_export($moduleArr, true) . ';');
    }
}

add_menu_new_data();
add_payset_data();
add_module();
