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
    $sql = 'SELECT `id` FROM `sline_menu_new` WHERE `title`=\'支付宝\' AND `pid` = 174 LIMIT 1';
    $auto_id = get_auto_id($sql);
    $data = array(
        'pid'          => 174,
        'level'        => 2,
        'title'        => '支付宝',
        'directory'    => 'alipay/admin',
        'controller'   => 'alipay',
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
    //支付宝
    $sql = 'SELECT `id` FROM `sline_payset` WHERE `name`=\'支付宝\' AND `pinyin` = \'alipay\' LIMIT 1';
    $auto_id = get_auto_id($sql);
    $data = array(
        'id'           => 1,
        'name'         => '支付宝',
        'pinyin'       => 'alipay',
        'litpic'       => '/uploads/payset/11.png',
        'isopen'       => 1,
        'issystem'     => 0,
        'description'  => '',
        'displayorder' => 9999,
        'platform'     => 0,
        'icon'         => '/uploads/payset/pay_zfb.gif',
    );
    if ($auto_id)
    {
        update_data($data, 'sline_payset', $auto_id);
    }
    else
    {
        write_data($data, 'sline_payset');
    }
    //支付宝即时到账
    $sql = 'SELECT `id` FROM `sline_payset` WHERE `name`=\'支付宝即时到账\' AND `pinyin` = \'alipaycash\' LIMIT 1';
    $auto_id = get_auto_id($sql);
    $data = array(
        'id'           => 11,
        'name'         => '支付宝即时到账',
        'pinyin'       => 'alipaycash',
        'litpic'       => '/uploads/payset/11.png',
        'isopen'       => 1,
        'issystem'     => 0,
        'description'  => '支付宝网页即时到账功能，可让用户在线向开发者的支付宝账号支付资金，交易资金即时到账，帮助开发者快速回笼资金。',
        'displayorder' => 9999,
        'platform'     => 1,
        'icon'         => '/uploads/payset/pay_zfb.gif',
    );
    if ($auto_id)
    {
        update_data($data, 'sline_payset', $auto_id);
    }
    else
    {
        write_data($data, 'sline_payset');
    }
    //支付宝双功能
    $sql = 'SELECT `id` FROM `sline_payset` WHERE `name`=\'支付宝双功能\' AND `pinyin` = \'alipaydouble\' LIMIT 1';
    $auto_id = get_auto_id($sql);
    $data = array(
        'id'           => 12,
        'name'         => '支付宝双功能',
        'pinyin'       => 'alipaydouble',
        'litpic'       => '/uploads/payset/12.png',
        'isopen'       => 1,
        'issystem'     => 0,
        'description'  => '买家可担保交易和即时到帐完成交易',
        'displayorder' => 9999,
        'platform'     => 1,
        'icon'         => '/uploads/payset/pay_zfb.gif',
    );
    if ($auto_id)
    {
        update_data($data, 'sline_payset', $auto_id);
    }
    else
    {
        write_data($data, 'sline_payset');
    }
    //支付宝担保交易
    $sql = 'SELECT `id` FROM `sline_payset` WHERE `name`=\'支付宝担保交易\' AND `pinyin` = \'alipaydanbao\' LIMIT 1';
    $auto_id = get_auto_id($sql);
    $data = array(
        'id'           => 13,
        'name'         => '支付宝担保交易',
        'pinyin'       => 'alipaydanbao',
        'litpic'       => '/uploads/payset/13.png',
        'isopen'       => 1,
        'issystem'     => 0,
        'description'  => '买家先将交易资金存入支付宝并通知卖家发货，买家确认收货后资金自动进入卖家支付宝账户，完成交易。',
        'displayorder' => 9999,
        'platform'     => 1,
        'icon'         => '/uploads/payset/pay_zfb.gif',
    );
    if ($auto_id)
    {
        update_data($data, 'sline_payset', $auto_id);
    }
    else
    {
        write_data($data, 'sline_payset');
    }
    //支付宝网银
    $sql = 'SELECT `id` FROM `sline_payset` WHERE `name`=\'支付宝网银\' AND `pinyin` = \'alipaybank\' LIMIT 1';
    $auto_id = get_auto_id($sql);
    $data = array(
        'id'           => 14,
        'name'         => '支付宝网银',
        'pinyin'       => 'alipaybank',
        'litpic'       => '/uploads/payset/14.png',
        'isopen'       => 1,
        'issystem'     => 0,
        'description'  => '买家可直接通过网上银行进行支付，无需通过支付宝就能完成交易。',
        'displayorder' => 9999,
        'platform'     => 1,
        'icon'         => '/uploads/payset/pay_zfb.gif',
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
    if (! isset($moduleArr['alipay']))
    {
        $moduleArr['alipay'] = '/plugins/alipay';
        file_put_contents($moduleFile, "<?php \r\n" . 'return ' . var_export($moduleArr, true) . ';');
    }
}

add_menu_new_data();
add_payset_data();
add_module();
