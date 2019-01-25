<?php defined('SYSPATH') OR die('No direct script access.'); ?>

2019-01-25 17:40:43 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'order by asc' at line 1 [ select sline_member_cash_log.id,sline_member.nickname,sline_member_cash_log.amount,FROM_UNIXTIME(sline_member_cash_log.addtime,'%Y-%m-%d %H:%i:%s') as addtime,sline_member_cash_log.description,sline_member_cash_log.voucherpath,sline_member_cash_log.savecashstatus from sline_member,sline_member_cash_log where sline_member_cash_log.memberid=sline_member.mid and sline_member_cash_log.type=100 limit 0,10 order by asc ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-25 17:40:43 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'order by asc' at line 1 [ select sline_member_cash_log.id,sline_member.nickname,sline_member_cash_log.amount,FROM_UNIXTIME(sline_member_cash_log.addtime,'%Y-%m-%d %H:%i:%s') as addtime,sline_member_cash_log.description,sline_member_cash_log.voucherpath,sline_member_cash_log.savecashstatus from sline_member,sline_member_cash_log where sline_member_cash_log.memberid=sline_member.mid and sline_member_cash_log.type=100 limit 0,10 order by asc ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select sline_me...', false, Array)
#1 E:\wamp64\www\plugins\distributor\classes\controller\admin\distributor.php(37): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Admin_Distributor->action_ajax_load_cashlog()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Admin_Distributor))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\newtravel\index.php(123): Kohana_Request->execute()
#7 {main}
2019-01-25 17:41:17 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'asc limit 0,10' at line 1 [ select sline_member_cash_log.id,sline_member.nickname,sline_member_cash_log.amount,FROM_UNIXTIME(sline_member_cash_log.addtime,'%Y-%m-%d %H:%i:%s') as addtime,sline_member_cash_log.description,sline_member_cash_log.voucherpath,sline_member_cash_log.savecashstatus from sline_member,sline_member_cash_log where sline_member_cash_log.memberid=sline_member.mid and sline_member_cash_log.type=100 order by asc limit 0,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-25 17:41:17 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'asc limit 0,10' at line 1 [ select sline_member_cash_log.id,sline_member.nickname,sline_member_cash_log.amount,FROM_UNIXTIME(sline_member_cash_log.addtime,'%Y-%m-%d %H:%i:%s') as addtime,sline_member_cash_log.description,sline_member_cash_log.voucherpath,sline_member_cash_log.savecashstatus from sline_member,sline_member_cash_log where sline_member_cash_log.memberid=sline_member.mid and sline_member_cash_log.type=100 order by asc limit 0,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select sline_me...', false, Array)
#1 E:\wamp64\www\plugins\distributor\classes\controller\admin\distributor.php(37): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Admin_Distributor->action_ajax_load_cashlog()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Admin_Distributor))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\newtravel\index.php(123): Kohana_Request->execute()
#7 {main}