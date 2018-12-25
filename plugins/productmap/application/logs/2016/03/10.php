<?php defined('SYSPATH') OR die('No direct script access.'); ?>

2016-03-10 09:20:10 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'add time desc limit 0' at line 1 [ select * from sline_fenxiao_withdraw  where id is not null and memberid=169 and addtime>=1457539200 order by add time desc limit 0 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2016-03-10 09:20:10 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'add time desc limit 0' at line 1 [ select * from sline_fenxiao_withdraw  where id is not null and memberid=169 and addtime>=1457539200 order by add time desc limit 0 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 D:\HTML\standsmore5\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select * from s...', false, Array)
#1 D:\HTML\standsmore5\plugins\fx_phone\application\classes\model\fenxiao\withdraw.php(31): Kohana_Database_Query->execute()
#2 D:\HTML\standsmore5\plugins\fx_phone\application\classes\controller\commission.php(69): Model_Fenxiao_Withdraw::get_list('169', Array)
#3 [internal function]: Controller_Commission->action_progress()
#4 D:\HTML\standsmore5\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Commission))
#5 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#7 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#8 {main}
2016-03-10 09:20:10 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'add time desc limit 0' at line 1 [ select * from sline_fenxiao_withdraw  where id is not null and memberid=169 and addtime>=1457539200 order by add time desc limit 0 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2016-03-10 09:20:10 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'add time desc limit 0' at line 1 [ select * from sline_fenxiao_withdraw  where id is not null and memberid=169 and addtime>=1457539200 order by add time desc limit 0 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 D:\HTML\standsmore5\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select * from s...', false, Array)
#1 D:\HTML\standsmore5\plugins\fx_phone\application\classes\model\fenxiao\withdraw.php(31): Kohana_Database_Query->execute()
#2 D:\HTML\standsmore5\plugins\fx_phone\application\classes\controller\commission.php(69): Model_Fenxiao_Withdraw::get_list('169', Array)
#3 [internal function]: Controller_Commission->action_progress()
#4 D:\HTML\standsmore5\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Commission))
#5 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#7 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#8 {main}
2016-03-10 09:40:57 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL commission/ajax_progress was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-10 09:40:57 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL commission/ajax_progress was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 10:25:36 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and addtime ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2016-03-10 10:25:36 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and addtime ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 D:\HTML\standsmore5\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select * from s...', false, Array)
#1 D:\HTML\standsmore5\plugins\fx_phone\application\classes\model\fenxiao\withdraw.php(31): Kohana_Database_Query->execute()
#2 D:\HTML\standsmore5\plugins\fx_phone\application\classes\controller\commission.php(92): Model_Fenxiao_Withdraw::get_list('169', Array)
#3 [internal function]: Controller_Commission->action_ajax_get_progress()
#4 D:\HTML\standsmore5\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Commission))
#5 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#7 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#8 {main}
2016-03-10 10:26:21 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and addtime ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2016-03-10 10:26:21 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and addtime ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 D:\HTML\standsmore5\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select * from s...', false, Array)
#1 D:\HTML\standsmore5\plugins\fx_phone\application\classes\model\fenxiao\withdraw.php(31): Kohana_Database_Query->execute()
#2 D:\HTML\standsmore5\plugins\fx_phone\application\classes\controller\commission.php(92): Model_Fenxiao_Withdraw::get_list('169', Array)
#3 [internal function]: Controller_Commission->action_ajax_get_progress()
#4 D:\HTML\standsmore5\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Commission))
#5 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#7 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#8 {main}
2016-03-10 10:26:22 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and addtime ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2016-03-10 10:26:22 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and addtime ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 D:\HTML\standsmore5\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select * from s...', false, Array)
#1 D:\HTML\standsmore5\plugins\fx_phone\application\classes\model\fenxiao\withdraw.php(31): Kohana_Database_Query->execute()
#2 D:\HTML\standsmore5\plugins\fx_phone\application\classes\controller\commission.php(92): Model_Fenxiao_Withdraw::get_list('169', Array)
#3 [internal function]: Controller_Commission->action_ajax_get_progress()
#4 D:\HTML\standsmore5\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Commission))
#5 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#7 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#8 {main}
2016-03-10 10:26:22 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and addtime ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2016-03-10 10:26:22 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and addtime ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 D:\HTML\standsmore5\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select * from s...', false, Array)
#1 D:\HTML\standsmore5\plugins\fx_phone\application\classes\model\fenxiao\withdraw.php(31): Kohana_Database_Query->execute()
#2 D:\HTML\standsmore5\plugins\fx_phone\application\classes\controller\commission.php(92): Model_Fenxiao_Withdraw::get_list('169', Array)
#3 [internal function]: Controller_Commission->action_ajax_get_progress()
#4 D:\HTML\standsmore5\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Commission))
#5 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#7 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#8 {main}
2016-03-10 10:26:23 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and addtime ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2016-03-10 10:26:23 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and addtime ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 D:\HTML\standsmore5\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select * from s...', false, Array)
#1 D:\HTML\standsmore5\plugins\fx_phone\application\classes\model\fenxiao\withdraw.php(31): Kohana_Database_Query->execute()
#2 D:\HTML\standsmore5\plugins\fx_phone\application\classes\controller\commission.php(92): Model_Fenxiao_Withdraw::get_list('169', Array)
#3 [internal function]: Controller_Commission->action_ajax_get_progress()
#4 D:\HTML\standsmore5\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Commission))
#5 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#7 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#8 {main}
2016-03-10 10:26:23 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and addtime ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2016-03-10 10:26:23 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and addtime ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 D:\HTML\standsmore5\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select * from s...', false, Array)
#1 D:\HTML\standsmore5\plugins\fx_phone\application\classes\model\fenxiao\withdraw.php(31): Kohana_Database_Query->execute()
#2 D:\HTML\standsmore5\plugins\fx_phone\application\classes\controller\commission.php(92): Model_Fenxiao_Withdraw::get_list('169', Array)
#3 [internal function]: Controller_Commission->action_ajax_get_progress()
#4 D:\HTML\standsmore5\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Commission))
#5 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#7 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#8 {main}
2016-03-10 10:26:23 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and addtime ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2016-03-10 10:26:23 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'and addtime ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 D:\HTML\standsmore5\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select * from s...', false, Array)
#1 D:\HTML\standsmore5\plugins\fx_phone\application\classes\model\fenxiao\withdraw.php(31): Kohana_Database_Query->execute()
#2 D:\HTML\standsmore5\plugins\fx_phone\application\classes\controller\commission.php(92): Model_Fenxiao_Withdraw::get_list('169', Array)
#3 [internal function]: Controller_Commission->action_ajax_get_progress()
#4 D:\HTML\standsmore5\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Commission))
#5 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#7 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#8 {main}
2016-03-10 10:43:04 --- ERROR: ErrorException [ 1 ]: Call to undefined method Common::session() ~ APPPATH\classes\controller\index.php [ 9 ]
2016-03-10 10:43:04 --- STRACE: ErrorException [ 1 ]: Call to undefined method Common::session() ~ APPPATH\classes\controller\index.php [ 9 ]
--
#0 [internal function]: Kohana_Core::shutdown_handler()
#1 {main}
2016-03-10 10:52:30 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-10 10:52:30 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 10:52:32 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-10 10:52:32 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 10:52:35 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-10 10:52:35 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 10:53:44 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-10 10:53:44 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 10:53:45 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-10 10:53:45 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 10:53:46 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-10 10:53:46 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 10:53:46 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-10 10:53:46 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 10:53:47 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-10 10:53:47 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 10:53:47 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-10 10:53:47 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 10:53:47 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-10 10:53:47 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 10:53:47 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-10 10:53:47 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 10:53:47 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-10 10:53:47 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 18:32:19 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-10 18:32:19 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 18:33:57 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-10 18:33:57 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 18:35:41 --- ERROR: ErrorException [ 1 ]: Call to undefined method Model_Member::get_consume_amount() ~ APPPATH\classes\controller\index.php [ 162 ]
2016-03-10 18:35:41 --- STRACE: ErrorException [ 1 ]: Call to undefined method Model_Member::get_consume_amount() ~ APPPATH\classes\controller\index.php [ 162 ]
--
#0 [internal function]: Kohana_Core::shutdown_handler()
#1 {main}
2016-03-10 18:35:42 --- ERROR: ErrorException [ 1 ]: Call to undefined method Model_Member::get_consume_amount() ~ APPPATH\classes\controller\index.php [ 162 ]
2016-03-10 18:35:42 --- STRACE: ErrorException [ 1 ]: Call to undefined method Model_Member::get_consume_amount() ~ APPPATH\classes\controller\index.php [ 162 ]
--
#0 [internal function]: Kohana_Core::shutdown_handler()
#1 {main}
2016-03-10 18:35:48 --- ERROR: ErrorException [ 1 ]: Call to undefined method Model_Member::get_consume_amount() ~ APPPATH\classes\controller\index.php [ 162 ]
2016-03-10 18:35:48 --- STRACE: ErrorException [ 1 ]: Call to undefined method Model_Member::get_consume_amount() ~ APPPATH\classes\controller\index.php [ 162 ]
--
#0 [internal function]: Kohana_Core::shutdown_handler()
#1 {main}
2016-03-10 18:42:12 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/progress was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-10 18:42:12 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/progress was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 18:59:49 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL plugins/fx_phone/public/js/sm.min.js was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-10 18:59:49 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL plugins/fx_phone/public/js/sm.min.js was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 18:59:49 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL plugins/fx_phone/public/js/zepto.min.js was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-10 18:59:49 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL plugins/fx_phone/public/js/zepto.min.js was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 18:59:49 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL plugins/fx_phone/public/js/jquery.min.js was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-10 18:59:49 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL plugins/fx_phone/public/js/jquery.min.js was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 18:59:50 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL plugins/fx_phone/public/js/jquery.min.js was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-10 18:59:50 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL plugins/fx_phone/public/js/jquery.min.js was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 18:59:50 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL plugins/fx_phone/public/js/zepto.min.js was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-10 18:59:50 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL plugins/fx_phone/public/js/zepto.min.js was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 18:59:50 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL plugins/fx_phone/public/js/sm.min.js was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-10 18:59:50 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL plugins/fx_phone/public/js/sm.min.js was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 18:59:50 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL plugins/fx_phone/public/js/zepto.min.js was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-10 18:59:50 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL plugins/fx_phone/public/js/zepto.min.js was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 18:59:50 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL plugins/fx_phone/public/js/sm.min.js was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-10 18:59:50 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL plugins/fx_phone/public/js/sm.min.js was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 18:59:50 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL plugins/fx_phone/public/js/jquery.min.js was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-10 18:59:50 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL plugins/fx_phone/public/js/jquery.min.js was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 18:59:50 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL plugins/fx_phone/public/js/jquery.min.js was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-10 18:59:50 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL plugins/fx_phone/public/js/jquery.min.js was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 18:59:51 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL plugins/fx_phone/public/js/jquery.min.js was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-10 18:59:51 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL plugins/fx_phone/public/js/jquery.min.js was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 19:00:02 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL plugins/fx_phone/public/js/jquery.min.js was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-10 19:00:02 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL plugins/fx_phone/public/js/jquery.min.js was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 19:00:24 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL plugins/fx_phone/public/js/zepto.min.js was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-10 19:00:24 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL plugins/fx_phone/public/js/zepto.min.js was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 19:01:11 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL plugins/fx_phone/public/js/jquery.min.js was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-10 19:01:11 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL plugins/fx_phone/public/js/jquery.min.js was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 19:03:31 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL plugins/fx_phone/public/js/jquery.min.js was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-10 19:03:31 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL plugins/fx_phone/public/js/jquery.min.js was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 20:14:48 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-10 20:14:48 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 20:14:52 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-10 20:14:52 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 20:14:57 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-10 20:14:57 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 20:14:58 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-10 20:14:58 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 20:14:59 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-10 20:14:59 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 20:15:00 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-10 20:15:00 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 20:15:10 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-10 20:15:10 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 20:15:49 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-10 20:15:49 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 20:16:17 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-10 20:16:17 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 20:16:22 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-10 20:16:22 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 20:17:26 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-10 20:17:26 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 20:17:35 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-10 20:17:35 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 20:19:39 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-10 20:19:39 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 20:20:12 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-10 20:20:12 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 20:20:23 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-10 20:20:23 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 20:20:25 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-10 20:20:25 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 20:20:26 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-10 20:20:26 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 20:20:27 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-10 20:20:27 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 20:20:28 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-10 20:20:28 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 20:20:55 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-10 20:20:55 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 20:20:56 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-10 20:20:56 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 20:21:01 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-10 20:21:01 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 20:21:02 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-10 20:21:02 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 20:21:05 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-10 20:21:05 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 20:21:08 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-10 20:21:08 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 20:21:09 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-10 20:21:09 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 20:21:24 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-10 20:21:24 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 20:21:25 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-10 20:21:25 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 20:21:44 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-10 20:21:44 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 20:22:08 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-10 20:22:08 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 20:33:08 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-10 20:33:08 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 20:36:09 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-10 20:36:09 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 20:36:11 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-10 20:36:11 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 20:36:12 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-10 20:36:12 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 20:36:12 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-10 20:36:12 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 20:36:18 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-10 20:36:18 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 20:36:54 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-10 20:36:54 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 20:36:54 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-10 20:36:54 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 20:36:55 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-10 20:36:55 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 20:36:55 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-10 20:36:55 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 20:36:58 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-10 20:36:58 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 20:37:05 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-10 20:37:05 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 20:37:31 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-10 20:37:31 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 20:37:31 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-10 20:37:31 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 20:37:31 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-10 20:37:31 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 20:37:32 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-10 20:37:32 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 20:37:34 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-10 20:37:34 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 20:37:46 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-10 20:37:46 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-10 20:46:53 --- ERROR: ErrorException [ 1 ]: Call to undefined function herder() ~ APPPATH\classes\controller\index.php [ 195 ]
2016-03-10 20:46:53 --- STRACE: ErrorException [ 1 ]: Call to undefined function herder() ~ APPPATH\classes\controller\index.php [ 195 ]
--
#0 [internal function]: Kohana_Core::shutdown_handler()
#1 {main}