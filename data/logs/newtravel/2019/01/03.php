<?php defined('SYSPATH') OR die('No direct script access.'); ?>

2019-01-03 00:10:29 --- ERROR: ErrorException [ 4 ]: syntax error, unexpected '$this' (T_VARIABLE) ~ APPPATH\classes\controller\supplier.php [ 43 ]
2019-01-03 00:10:29 --- STRACE: ErrorException [ 4 ]: syntax error, unexpected '$this' (T_VARIABLE) ~ APPPATH\classes\controller\supplier.php [ 43 ]
--
#0 [internal function]: Kohana_Core::shutdown_handler()
#1 {main}
2019-01-03 01:11:05 --- ERROR: ErrorException [ 1 ]: Cannot use object of type stdClass as array ~ E:\wamp64\www\data\cache\newtravel\tplcache\stourtravel\supplier\select_dest.php [ 21 ]
2019-01-03 01:11:05 --- STRACE: ErrorException [ 1 ]: Cannot use object of type stdClass as array ~ E:\wamp64\www\data\cache\newtravel\tplcache\stourtravel\supplier\select_dest.php [ 21 ]
--
#0 [internal function]: Kohana_Core::shutdown_handler()
#1 {main}
2019-01-03 01:13:22 --- ERROR: ErrorException [ 1 ]: Cannot use object of type stdClass as array ~ E:\wamp64\www\data\cache\newtravel\tplcache\stourtravel\supplier\select_dest.php [ 18 ]
2019-01-03 01:13:22 --- STRACE: ErrorException [ 1 ]: Cannot use object of type stdClass as array ~ E:\wamp64\www\data\cache\newtravel\tplcache\stourtravel\supplier\select_dest.php [ 18 ]
--
#0 [internal function]: Kohana_Core::shutdown_handler()
#1 {main}
2019-01-03 01:48:59 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL supplier/action_ajax_select_dest was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2019-01-03 01:48:59 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL supplier/action_ajax_select_dest was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#2 E:\wamp64\www\newtravel\index.php(123): Kohana_Request->execute()
#3 {main}
2019-01-03 01:50:06 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL supplier/action_ajax_select_dest was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2019-01-03 01:50:06 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL supplier/action_ajax_select_dest was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#2 E:\wamp64\www\newtravel\index.php(123): Kohana_Request->execute()
#3 {main}
2019-01-03 01:52:10 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL supplier/action_ajax_select_dest was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2019-01-03 01:52:10 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL supplier/action_ajax_select_dest was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#2 E:\wamp64\www\newtravel\index.php(123): Kohana_Request->execute()
#3 {main}
2019-01-03 01:52:55 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL supplier/action_ajax_select_dest was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2019-01-03 01:52:55 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL supplier/action_ajax_select_dest was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#2 E:\wamp64\www\newtravel\index.php(123): Kohana_Request->execute()
#3 {main}
2019-01-03 01:54:20 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select * from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-03 01:54:20 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select * from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select * from s...', false, Array)
#1 E:\wamp64\www\newtravel\application\classes\controller\destination.php(118): Kohana_Database_Query->execute()
#2 E:\wamp64\www\newtravel\application\classes\controller\supplier.php(48): Controller_Destination->action_destination('read', 'dest_', 0, 'selectdest')
#3 [internal function]: Controller_Supplier->action_ajax_select_dest()
#4 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Supplier))
#5 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#7 E:\wamp64\www\newtravel\index.php(123): Kohana_Request->execute()
#8 {main}
2019-01-03 03:25:17 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-03 03:25:17 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select id,kindn...', false, Array)
#1 E:\wamp64\www\newtravel\application\classes\controller\supplier.php(50): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Supplier->action_ajax_select_dest()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Supplier))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\newtravel\index.php(123): Kohana_Request->execute()
#7 {main}
2019-01-03 03:25:25 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-03 03:25:25 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select id,kindn...', false, Array)
#1 E:\wamp64\www\newtravel\application\classes\controller\supplier.php(50): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Supplier->action_ajax_select_dest()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Supplier))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\newtravel\index.php(123): Kohana_Request->execute()
#7 {main}
2019-01-03 03:40:56 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-03 03:40:56 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select id,kindn...', false, Array)
#1 E:\wamp64\www\newtravel\application\classes\controller\supplier.php(50): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Supplier->action_ajax_select_dest()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Supplier))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\newtravel\index.php(123): Kohana_Request->execute()
#7 {main}
2019-01-03 03:41:45 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-03 03:41:45 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select id,kindn...', false, Array)
#1 E:\wamp64\www\newtravel\application\classes\controller\supplier.php(50): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Supplier->action_ajax_select_dest()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Supplier))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\newtravel\index.php(123): Kohana_Request->execute()
#7 {main}
2019-01-03 03:49:29 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-03 03:49:29 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select id,kindn...', false, Array)
#1 E:\wamp64\www\newtravel\application\classes\controller\supplier.php(50): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Supplier->action_ajax_select_dest()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Supplier))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\newtravel\index.php(123): Kohana_Request->execute()
#7 {main}
2019-01-03 03:55:45 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-03 03:55:45 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select id,kindn...', false, Array)
#1 E:\wamp64\www\newtravel\application\classes\controller\supplier.php(50): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Supplier->action_ajax_select_dest()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Supplier))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\newtravel\index.php(123): Kohana_Request->execute()
#7 {main}
2019-01-03 03:55:57 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-03 03:55:57 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select id,kindn...', false, Array)
#1 E:\wamp64\www\newtravel\application\classes\controller\supplier.php(50): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Supplier->action_ajax_select_dest()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Supplier))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\newtravel\index.php(123): Kohana_Request->execute()
#7 {main}
2019-01-03 03:55:57 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-03 03:55:57 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select id,kindn...', false, Array)
#1 E:\wamp64\www\newtravel\application\classes\controller\supplier.php(50): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Supplier->action_ajax_select_dest()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Supplier))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\newtravel\index.php(123): Kohana_Request->execute()
#7 {main}
2019-01-03 03:55:57 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-03 03:55:57 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select id,kindn...', false, Array)
#1 E:\wamp64\www\newtravel\application\classes\controller\supplier.php(50): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Supplier->action_ajax_select_dest()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Supplier))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\newtravel\index.php(123): Kohana_Request->execute()
#7 {main}
2019-01-03 03:55:59 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-03 03:55:59 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select id,kindn...', false, Array)
#1 E:\wamp64\www\newtravel\application\classes\controller\supplier.php(50): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Supplier->action_ajax_select_dest()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Supplier))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\newtravel\index.php(123): Kohana_Request->execute()
#7 {main}
2019-01-03 04:02:37 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-03 04:02:37 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select id,kindn...', false, Array)
#1 E:\wamp64\www\newtravel\application\classes\controller\supplier.php(50): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Supplier->action_ajax_select_dest()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Supplier))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\newtravel\index.php(123): Kohana_Request->execute()
#7 {main}
2019-01-03 04:03:24 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-03 04:03:24 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select id,kindn...', false, Array)
#1 E:\wamp64\www\newtravel\application\classes\controller\supplier.php(50): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Supplier->action_ajax_select_dest()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Supplier))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\newtravel\index.php(123): Kohana_Request->execute()
#7 {main}
2019-01-03 04:04:12 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-03 04:04:12 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select id,kindn...', false, Array)
#1 E:\wamp64\www\newtravel\application\classes\controller\supplier.php(50): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Supplier->action_ajax_select_dest()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Supplier))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\newtravel\index.php(123): Kohana_Request->execute()
#7 {main}
2019-01-03 04:04:22 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-03 04:04:22 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select id,kindn...', false, Array)
#1 E:\wamp64\www\newtravel\application\classes\controller\supplier.php(50): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Supplier->action_ajax_select_dest()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Supplier))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\newtravel\index.php(123): Kohana_Request->execute()
#7 {main}
2019-01-03 04:04:23 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-03 04:04:23 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select id,kindn...', false, Array)
#1 E:\wamp64\www\newtravel\application\classes\controller\supplier.php(50): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Supplier->action_ajax_select_dest()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Supplier))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\newtravel\index.php(123): Kohana_Request->execute()
#7 {main}
2019-01-03 09:46:28 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-03 09:46:28 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select id,kindn...', false, Array)
#1 E:\wamp64\www\newtravel\application\classes\controller\supplier.php(50): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Supplier->action_ajax_select_dest()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Supplier))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\newtravel\index.php(123): Kohana_Request->execute()
#7 {main}
2019-01-03 09:56:13 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-03 09:56:13 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select id,kindn...', false, Array)
#1 E:\wamp64\www\newtravel\application\classes\controller\supplier.php(50): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Supplier->action_ajax_select_dest()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Supplier))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\newtravel\index.php(123): Kohana_Request->execute()
#7 {main}
2019-01-03 09:56:14 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-03 09:56:14 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select id,kindn...', false, Array)
#1 E:\wamp64\www\newtravel\application\classes\controller\supplier.php(50): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Supplier->action_ajax_select_dest()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Supplier))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\newtravel\index.php(123): Kohana_Request->execute()
#7 {main}
2019-01-03 09:56:56 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-03 09:56:56 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select id,kindn...', false, Array)
#1 E:\wamp64\www\newtravel\application\classes\controller\supplier.php(50): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Supplier->action_ajax_select_dest()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Supplier))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\newtravel\index.php(123): Kohana_Request->execute()
#7 {main}
2019-01-03 11:43:26 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-03 11:43:26 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select id,kindn...', false, Array)
#1 E:\wamp64\www\newtravel\application\classes\controller\supplier.php(50): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Supplier->action_ajax_select_dest()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Supplier))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\newtravel\index.php(123): Kohana_Request->execute()
#7 {main}
2019-01-03 11:43:31 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-03 11:43:31 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select id,kindn...', false, Array)
#1 E:\wamp64\www\newtravel\application\classes\controller\supplier.php(50): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Supplier->action_ajax_select_dest()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Supplier))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\newtravel\index.php(123): Kohana_Request->execute()
#7 {main}
2019-01-03 11:43:32 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-03 11:43:32 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select id,kindn...', false, Array)
#1 E:\wamp64\www\newtravel\application\classes\controller\supplier.php(50): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Supplier->action_ajax_select_dest()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Supplier))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\newtravel\index.php(123): Kohana_Request->execute()
#7 {main}
2019-01-03 11:46:10 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-03 11:46:10 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select id,kindn...', false, Array)
#1 E:\wamp64\www\newtravel\application\classes\controller\supplier.php(50): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Supplier->action_ajax_select_dest()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Supplier))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\newtravel\index.php(123): Kohana_Request->execute()
#7 {main}
2019-01-03 11:46:43 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-03 11:46:43 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select id,kindn...', false, Array)
#1 E:\wamp64\www\newtravel\application\classes\controller\supplier.php(50): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Supplier->action_ajax_select_dest()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Supplier))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\newtravel\index.php(123): Kohana_Request->execute()
#7 {main}
2019-01-03 11:48:21 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-03 11:48:21 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select id,kindn...', false, Array)
#1 E:\wamp64\www\newtravel\application\classes\controller\supplier.php(50): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Supplier->action_ajax_select_dest()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Supplier))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\newtravel\index.php(123): Kohana_Request->execute()
#7 {main}
2019-01-03 11:48:27 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-03 11:48:27 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select id,kindn...', false, Array)
#1 E:\wamp64\www\newtravel\application\classes\controller\supplier.php(50): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Supplier->action_ajax_select_dest()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Supplier))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\newtravel\index.php(123): Kohana_Request->execute()
#7 {main}
2019-01-03 11:49:41 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-03 11:49:41 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select id,kindn...', false, Array)
#1 E:\wamp64\www\newtravel\application\classes\controller\supplier.php(50): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Supplier->action_ajax_select_dest()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Supplier))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\newtravel\index.php(123): Kohana_Request->execute()
#7 {main}
2019-01-03 11:50:48 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-03 11:50:48 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select id,kindn...', false, Array)
#1 E:\wamp64\www\newtravel\application\classes\controller\supplier.php(50): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Supplier->action_ajax_select_dest()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Supplier))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\newtravel\index.php(123): Kohana_Request->execute()
#7 {main}
2019-01-03 11:50:50 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-03 11:50:50 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select id,kindn...', false, Array)
#1 E:\wamp64\www\newtravel\application\classes\controller\supplier.php(50): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Supplier->action_ajax_select_dest()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Supplier))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\newtravel\index.php(123): Kohana_Request->execute()
#7 {main}
2019-01-03 11:50:50 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-03 11:50:50 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select id,kindn...', false, Array)
#1 E:\wamp64\www\newtravel\application\classes\controller\supplier.php(50): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Supplier->action_ajax_select_dest()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Supplier))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\newtravel\index.php(123): Kohana_Request->execute()
#7 {main}
2019-01-03 11:50:51 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-03 11:50:51 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select id,kindn...', false, Array)
#1 E:\wamp64\www\newtravel\application\classes\controller\supplier.php(50): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Supplier->action_ajax_select_dest()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Supplier))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\newtravel\index.php(123): Kohana_Request->execute()
#7 {main}
2019-01-03 11:50:53 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-03 11:50:53 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select id,kindn...', false, Array)
#1 E:\wamp64\www\newtravel\application\classes\controller\supplier.php(50): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Supplier->action_ajax_select_dest()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Supplier))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\newtravel\index.php(123): Kohana_Request->execute()
#7 {main}
2019-01-03 11:56:43 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-03 11:56:43 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select id,kindn...', false, Array)
#1 E:\wamp64\www\newtravel\application\classes\controller\supplier.php(50): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Supplier->action_ajax_select_dest()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Supplier))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\newtravel\index.php(123): Kohana_Request->execute()
#7 {main}
2019-01-03 11:57:23 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-03 11:57:23 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select id,kindn...', false, Array)
#1 E:\wamp64\www\newtravel\application\classes\controller\supplier.php(50): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Supplier->action_ajax_select_dest()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Supplier))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\newtravel\index.php(123): Kohana_Request->execute()
#7 {main}
2019-01-03 12:11:38 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-03 12:11:38 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select id,kindn...', false, Array)
#1 E:\wamp64\www\newtravel\application\classes\controller\supplier.php(50): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Supplier->action_ajax_select_dest()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Supplier))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\newtravel\index.php(123): Kohana_Request->execute()
#7 {main}
2019-01-03 12:11:40 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-03 12:11:40 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select id,kindn...', false, Array)
#1 E:\wamp64\www\newtravel\application\classes\controller\supplier.php(50): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Supplier->action_ajax_select_dest()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Supplier))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\newtravel\index.php(123): Kohana_Request->execute()
#7 {main}
2019-01-03 12:25:01 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-03 12:25:01 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select id,kindn...', false, Array)
#1 E:\wamp64\www\newtravel\application\classes\controller\supplier.php(50): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Supplier->action_ajax_select_dest()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Supplier))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\newtravel\index.php(123): Kohana_Request->execute()
#7 {main}
2019-01-03 12:25:02 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-03 12:25:02 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select id,kindn...', false, Array)
#1 E:\wamp64\www\newtravel\application\classes\controller\supplier.php(50): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Supplier->action_ajax_select_dest()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Supplier))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\newtravel\index.php(123): Kohana_Request->execute()
#7 {main}
2019-01-03 12:25:03 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-03 12:25:03 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select id,kindn...', false, Array)
#1 E:\wamp64\www\newtravel\application\classes\controller\supplier.php(50): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Supplier->action_ajax_select_dest()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Supplier))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\newtravel\index.php(123): Kohana_Request->execute()
#7 {main}
2019-01-03 12:26:04 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-03 12:26:04 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select id,kindn...', false, Array)
#1 E:\wamp64\www\newtravel\application\classes\controller\supplier.php(50): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Supplier->action_ajax_select_dest()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Supplier))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\newtravel\index.php(123): Kohana_Request->execute()
#7 {main}
2019-01-03 12:27:08 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-03 12:27:08 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select id,kindn...', false, Array)
#1 E:\wamp64\www\newtravel\application\classes\controller\supplier.php(50): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Supplier->action_ajax_select_dest()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Supplier))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\newtravel\index.php(123): Kohana_Request->execute()
#7 {main}
2019-01-03 13:13:02 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-03 13:13:02 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select id,kindn...', false, Array)
#1 E:\wamp64\www\newtravel\application\classes\controller\supplier.php(50): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Supplier->action_ajax_select_dest()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Supplier))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\newtravel\index.php(123): Kohana_Request->execute()
#7 {main}
2019-01-03 13:20:18 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-03 13:20:18 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select id,kindn...', false, Array)
#1 E:\wamp64\www\newtravel\application\classes\controller\supplier.php(50): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Supplier->action_ajax_select_dest()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Supplier))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\newtravel\index.php(123): Kohana_Request->execute()
#7 {main}
2019-01-03 13:20:18 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-03 13:20:18 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select id,kindn...', false, Array)
#1 E:\wamp64\www\newtravel\application\classes\controller\supplier.php(50): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Supplier->action_ajax_select_dest()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Supplier))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\newtravel\index.php(123): Kohana_Request->execute()
#7 {main}
2019-01-03 13:20:20 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-03 13:20:20 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select id,kindn...', false, Array)
#1 E:\wamp64\www\newtravel\application\classes\controller\supplier.php(50): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Supplier->action_ajax_select_dest()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Supplier))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\newtravel\index.php(123): Kohana_Request->execute()
#7 {main}
2019-01-03 13:20:21 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-03 13:20:21 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select id,kindn...', false, Array)
#1 E:\wamp64\www\newtravel\application\classes\controller\supplier.php(50): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Supplier->action_ajax_select_dest()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Supplier))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\newtravel\index.php(123): Kohana_Request->execute()
#7 {main}