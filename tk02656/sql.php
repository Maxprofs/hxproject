<?php define('DATAPATH', dirname(dirname(dirname(__FILE__))));
require_once(DATAPATH . "/slinesql.class.php");
//执行sql  $mysql->query
//检测数据 $mysql->check_data  bool
//检测字段 $mysql->check_column boo
//检测表   $mysql->check_table bool
//检测索引 $mysql->check_index bool
//获取错误 $mysql->error() void | string(错误信息)

//图库分组添加status字段
if (!$mysql->check_column('sline_image_group', 'status'))
{
    $mysql->query('ALTER TABLE `sline_image_group` ADD COLUMN `status`  tinyint(1) NULL DEFAULT 1 COMMENT \'0:进入回收站\' AFTER `level`');
}