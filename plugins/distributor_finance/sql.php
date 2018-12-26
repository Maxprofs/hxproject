<?php define('DATAPATH', dirname(dirname(dirname(__FILE__))));
require_once(DATAPATH . "/slinesql.class.php");
//执行sql  $mysql->query
//检测数据 $mysql->check_data  bool
//检测字段 $mysql->check_column bool
//检测表   $mysql->check_table bool
//检测索引 $mysql->check_index bool
//获取错误 $mysql->error() void | string(错误信息)


if(!$mysql->check_table("sline_distributor_finance_drawcash"))
{
    $mysql->query("CREATE TABLE `sline_distributor_finance_drawcash` (
`id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `distributorid` int(11) DEFAULT NULL COMMENT '分销商ID',
  `withdrawamount` float DEFAULT NULL COMMENT '提现金额',
  `proceeds_type` tinyint(1) DEFAULT '1' COMMENT '收款方类型:1银行 2支付宝',
  `bankname` varchar(255) DEFAULT NULL COMMENT '银行名称',
  `bankcardnumber` varchar(100) DEFAULT NULL COMMENT '银行卡号',
  `bankaccountname` varchar(255) DEFAULT NULL COMMENT '银行账户名',
  `alipayaccount` varchar(255) DEFAULT NULL COMMENT '支付宝账号',
  `alipayaccountname` varchar(255) DEFAULT NULL COMMENT '支付宝账户姓名',
  `description` varchar(255) DEFAULT NULL COMMENT '说明',
  `addtime` int(11) DEFAULT NULL COMMENT '申请时间',
  `finishtime` int(11) DEFAULT NULL COMMENT '完成或拒绝时间',
  `status` tinyint(2) DEFAULT '0' COMMENT '提现状态(0 提交中，1完成,  2未通过)',
  `audit_description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='供应商提现';
");

	$mysql->error();
}
else
{
    //更新字段
    if(!$mysql->check_column('sline_distributor_finance_drawcash','proceeds_type'))
    {
        $mysql->query("ALTER TABLE `sline_distributor_finance_drawcash` ADD COLUMN `proceeds_type` tinyint(1) DEFAULT '1' COMMENT '收款方类型:1银行 2支付宝' AFTER `withdrawamount`");
        $mysql->error();
    }
    if(!$mysql->check_column('sline_distributor_finance_drawcash','alipayaccount'))
    {
        $mysql->query("ALTER TABLE `sline_distributor_finance_drawcash` ADD COLUMN `alipayaccount` varchar(255) DEFAULT NULL COMMENT '支付宝账号' AFTER `bankaccountname`");
        $mysql->error();
    }
    if(!$mysql->check_column('sline_distributor_finance_drawcash','alipayaccountname'))
    {
        $mysql->query("ALTER TABLE `sline_distributor_finance_drawcash` ADD COLUMN `alipayaccountname`  varchar(255) DEFAULT NULL COMMENT '支付宝账户姓名' AFTER `alipayaccount`;");
        $mysql->error();
    }
}

