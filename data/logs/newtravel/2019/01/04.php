<?php defined('SYSPATH') OR die('No direct script access.'); ?>

2019-01-04 10:39:35 --- ERROR: ErrorException [ 4 ]: syntax error, unexpected '[', expecting ',' or ';' ~ APPPATH\classes\controller\supplier.php [ 9 ]
2019-01-04 10:39:35 --- STRACE: ErrorException [ 4 ]: syntax error, unexpected '[', expecting ',' or ';' ~ APPPATH\classes\controller\supplier.php [ 9 ]
--
#0 [internal function]: Kohana_Core::shutdown_handler()
#1 {main}
2019-01-04 10:53:16 --- ERROR: ErrorException [ 4 ]: syntax error, unexpected '&', expecting identifier (T_STRING) or variable (T_VARIABLE) or '{' or '$' ~ APPPATH\classes\controller\supplier.php [ 41 ]
2019-01-04 10:53:16 --- STRACE: ErrorException [ 4 ]: syntax error, unexpected '&', expecting identifier (T_STRING) or variable (T_VARIABLE) or '{' or '$' ~ APPPATH\classes\controller\supplier.php [ 41 ]
--
#0 [internal function]: Kohana_Core::shutdown_handler()
#1 {main}
2019-01-04 11:27:38 --- ERROR: ErrorException [ 4 ]: syntax error, unexpected 'foreach' (T_FOREACH) ~ APPPATH\classes\controller\supplier.php [ 52 ]
2019-01-04 11:27:38 --- STRACE: ErrorException [ 4 ]: syntax error, unexpected 'foreach' (T_FOREACH) ~ APPPATH\classes\controller\supplier.php [ 52 ]
--
#0 [internal function]: Kohana_Core::shutdown_handler()
#1 {main}
2019-01-04 11:27:53 --- ERROR: ErrorException [ 4 ]: syntax error, unexpected '$children' (T_VARIABLE) ~ APPPATH\classes\controller\supplier.php [ 58 ]
2019-01-04 11:27:53 --- STRACE: ErrorException [ 4 ]: syntax error, unexpected '$children' (T_VARIABLE) ~ APPPATH\classes\controller\supplier.php [ 58 ]
--
#0 [internal function]: Kohana_Core::shutdown_handler()
#1 {main}
2019-01-04 11:30:30 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-04 11:30:30 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select id,kindn...', false, Array)
#1 E:\wamp64\www\newtravel\application\classes\controller\supplier.php(64): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Supplier->action_ajax_select_dest()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Supplier))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\newtravel\index.php(123): Kohana_Request->execute()
#7 {main}
2019-01-04 11:30:30 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-04 11:30:30 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select id,kindn...', false, Array)
#1 E:\wamp64\www\newtravel\application\classes\controller\supplier.php(64): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Supplier->action_ajax_select_dest()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Supplier))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\newtravel\index.php(123): Kohana_Request->execute()
#7 {main}
2019-01-04 11:30:31 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-04 11:30:31 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select id,kindn...', false, Array)
#1 E:\wamp64\www\newtravel\application\classes\controller\supplier.php(64): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Supplier->action_ajax_select_dest()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Supplier))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\newtravel\index.php(123): Kohana_Request->execute()
#7 {main}
2019-01-04 11:30:32 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-04 11:30:32 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select id,kindn...', false, Array)
#1 E:\wamp64\www\newtravel\application\classes\controller\supplier.php(64): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Supplier->action_ajax_select_dest()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Supplier))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\newtravel\index.php(123): Kohana_Request->execute()
#7 {main}
2019-01-04 11:30:32 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-04 11:30:32 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select id,kindn...', false, Array)
#1 E:\wamp64\www\newtravel\application\classes\controller\supplier.php(64): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Supplier->action_ajax_select_dest()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Supplier))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\newtravel\index.php(123): Kohana_Request->execute()
#7 {main}
2019-01-04 11:30:33 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-04 11:30:33 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select id,kindn...', false, Array)
#1 E:\wamp64\www\newtravel\application\classes\controller\supplier.php(64): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Supplier->action_ajax_select_dest()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Supplier))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\newtravel\index.php(123): Kohana_Request->execute()
#7 {main}
2019-01-04 11:32:24 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-04 11:32:24 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select id,kindn...', false, Array)
#1 E:\wamp64\www\newtravel\application\classes\controller\supplier.php(64): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Supplier->action_ajax_select_dest()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Supplier))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\newtravel\index.php(123): Kohana_Request->execute()
#7 {main}
2019-01-04 11:32:27 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-04 11:32:27 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select id,kindn...', false, Array)
#1 E:\wamp64\www\newtravel\application\classes\controller\supplier.php(64): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Supplier->action_ajax_select_dest()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Supplier))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\newtravel\index.php(123): Kohana_Request->execute()
#7 {main}
2019-01-04 11:32:27 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-04 11:32:27 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select id,kindn...', false, Array)
#1 E:\wamp64\www\newtravel\application\classes\controller\supplier.php(64): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Supplier->action_ajax_select_dest()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Supplier))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\newtravel\index.php(123): Kohana_Request->execute()
#7 {main}
2019-01-04 11:32:28 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-04 11:32:28 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select id,kindn...', false, Array)
#1 E:\wamp64\www\newtravel\application\classes\controller\supplier.php(64): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Supplier->action_ajax_select_dest()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Supplier))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\newtravel\index.php(123): Kohana_Request->execute()
#7 {main}
2019-01-04 11:32:29 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-04 11:32:29 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select id,kindn...', false, Array)
#1 E:\wamp64\www\newtravel\application\classes\controller\supplier.php(64): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Supplier->action_ajax_select_dest()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Supplier))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\newtravel\index.php(123): Kohana_Request->execute()
#7 {main}
2019-01-04 11:32:29 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-04 11:32:29 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select id,kindn...', false, Array)
#1 E:\wamp64\www\newtravel\application\classes\controller\supplier.php(64): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Supplier->action_ajax_select_dest()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Supplier))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\newtravel\index.php(123): Kohana_Request->execute()
#7 {main}
2019-01-04 11:32:30 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-04 11:32:30 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select id,kindn...', false, Array)
#1 E:\wamp64\www\newtravel\application\classes\controller\supplier.php(64): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Supplier->action_ajax_select_dest()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Supplier))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\newtravel\index.php(123): Kohana_Request->execute()
#7 {main}
2019-01-04 11:32:30 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-04 11:32:30 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select id,kindn...', false, Array)
#1 E:\wamp64\www\newtravel\application\classes\controller\supplier.php(64): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Supplier->action_ajax_select_dest()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Supplier))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\newtravel\index.php(123): Kohana_Request->execute()
#7 {main}
2019-01-04 11:32:31 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-04 11:32:31 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select id,kindn...', false, Array)
#1 E:\wamp64\www\newtravel\application\classes\controller\supplier.php(64): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Supplier->action_ajax_select_dest()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Supplier))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\newtravel\index.php(123): Kohana_Request->execute()
#7 {main}
2019-01-04 11:32:31 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-04 11:32:31 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select id,kindn...', false, Array)
#1 E:\wamp64\www\newtravel\application\classes\controller\supplier.php(64): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Supplier->action_ajax_select_dest()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Supplier))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\newtravel\index.php(123): Kohana_Request->execute()
#7 {main}
2019-01-04 11:32:33 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-04 11:32:33 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select id,kindn...', false, Array)
#1 E:\wamp64\www\newtravel\application\classes\controller\supplier.php(64): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Supplier->action_ajax_select_dest()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Supplier))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\newtravel\index.php(123): Kohana_Request->execute()
#7 {main}
2019-01-04 11:32:34 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-04 11:32:34 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select id,kindn...', false, Array)
#1 E:\wamp64\www\newtravel\application\classes\controller\supplier.php(64): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Supplier->action_ajax_select_dest()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Supplier))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\newtravel\index.php(123): Kohana_Request->execute()
#7 {main}
2019-01-04 11:32:35 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-04 11:32:35 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select id,kindn...', false, Array)
#1 E:\wamp64\www\newtravel\application\classes\controller\supplier.php(64): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Supplier->action_ajax_select_dest()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Supplier))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\newtravel\index.php(123): Kohana_Request->execute()
#7 {main}
2019-01-04 11:32:36 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-04 11:32:36 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select id,kindn...', false, Array)
#1 E:\wamp64\www\newtravel\application\classes\controller\supplier.php(64): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Supplier->action_ajax_select_dest()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Supplier))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\newtravel\index.php(123): Kohana_Request->execute()
#7 {main}
2019-01-04 11:32:36 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-04 11:32:36 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select id,kindn...', false, Array)
#1 E:\wamp64\www\newtravel\application\classes\controller\supplier.php(64): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Supplier->action_ajax_select_dest()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Supplier))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\newtravel\index.php(123): Kohana_Request->execute()
#7 {main}
2019-01-04 11:32:43 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-04 11:32:43 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ select id,kindname,pid from sline_destinations where pid=  ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select id,kindn...', false, Array)
#1 E:\wamp64\www\newtravel\application\classes\controller\supplier.php(64): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Supplier->action_ajax_select_dest()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Supplier))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\newtravel\index.php(123): Kohana_Request->execute()
#7 {main}