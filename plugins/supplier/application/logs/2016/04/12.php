<?php defined('SYSPATH') OR die('No direct script access.'); ?>

2016-04-12 14:14:33 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '1458316800'' at line 1 [ SELECT price FROM`sline_hotel_room_price` WHERE suitid='262' AND day>='1458230400'' AND day ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2016-04-12 14:14:33 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '1458316800'' at line 1 [ SELECT price FROM`sline_hotel_room_price` WHERE suitid='262' AND day>='1458230400'' AND day ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 D:\web\v5\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'SELECT price FR...', false, Array)
#1 D:\web\v5\plugins\supplier\application\classes\model\member\order.php(700): Kohana_Database_Query->execute()
#2 D:\web\v5\plugins\supplier\application\classes\model\member\order.php(639): Model_Member_Order::suit_range_price('262', '2016-03-18', '2016-03-19', '1')
#3 D:\web\v5\plugins\supplier\application\classes\model\member\order.php(385): Model_Member_Order::order_info('02924282798762')
#4 D:\web\v5\plugins\supplier\application\classes\model\member\order.php(333): Model_Member_Order->_get_data_format(Array)
#5 D:\web\v5\plugins\supplier\application\classes\model\member\order.php(200): Model_Member_Order->_get_list_data_format(Array)
#6 D:\web\v5\plugins\supplier\application\classes\controller\pc\order.php(38): Model_Member_Order->get_my_order_list()
#7 [internal function]: Controller_Pc_Order->action_all()
#8 D:\web\v5\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Pc_Order))
#9 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#10 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#11 D:\web\v5\plugins\supplier\index.php(133): Kohana_Request->execute()
#12 {main}
2016-04-12 15:58:58 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-04-12 15:58:58 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier\index.php(133): Kohana_Request->execute()
#3 {main}
2016-04-12 15:59:04 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-04-12 15:59:04 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier\index.php(133): Kohana_Request->execute()
#3 {main}
2016-04-12 15:59:07 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-04-12 15:59:07 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier\index.php(133): Kohana_Request->execute()
#3 {main}
2016-04-12 15:59:10 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-04-12 15:59:10 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier\index.php(133): Kohana_Request->execute()
#3 {main}
2016-04-12 15:59:13 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-04-12 15:59:13 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier\index.php(133): Kohana_Request->execute()
#3 {main}
2016-04-12 15:59:16 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-04-12 15:59:16 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier\index.php(133): Kohana_Request->execute()
#3 {main}
2016-04-12 15:59:19 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-04-12 15:59:19 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier\index.php(133): Kohana_Request->execute()
#3 {main}
2016-04-12 15:59:22 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-04-12 15:59:22 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier\index.php(133): Kohana_Request->execute()
#3 {main}
2016-04-12 15:59:25 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-04-12 15:59:25 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier\index.php(133): Kohana_Request->execute()
#3 {main}
2016-04-12 15:59:28 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-04-12 15:59:28 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier\index.php(133): Kohana_Request->execute()
#3 {main}
2016-04-12 15:59:31 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-04-12 15:59:31 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier\index.php(133): Kohana_Request->execute()
#3 {main}
2016-04-12 15:59:34 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-04-12 15:59:34 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier\index.php(133): Kohana_Request->execute()
#3 {main}
2016-04-12 15:59:37 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-04-12 15:59:37 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier\index.php(133): Kohana_Request->execute()
#3 {main}
2016-04-12 15:59:40 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-04-12 15:59:40 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier\index.php(133): Kohana_Request->execute()
#3 {main}
2016-04-12 15:59:43 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-04-12 15:59:43 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier\index.php(133): Kohana_Request->execute()
#3 {main}
2016-04-12 15:59:46 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-04-12 15:59:46 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier\index.php(133): Kohana_Request->execute()
#3 {main}
2016-04-12 15:59:49 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-04-12 15:59:49 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier\index.php(133): Kohana_Request->execute()
#3 {main}
2016-04-12 15:59:52 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-04-12 15:59:52 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier\index.php(133): Kohana_Request->execute()
#3 {main}
2016-04-12 15:59:55 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-04-12 15:59:55 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier\index.php(133): Kohana_Request->execute()
#3 {main}
2016-04-12 15:59:58 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-04-12 15:59:58 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier\index.php(133): Kohana_Request->execute()
#3 {main}
2016-04-12 16:00:01 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-04-12 16:00:01 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier\index.php(133): Kohana_Request->execute()
#3 {main}
2016-04-12 16:00:04 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-04-12 16:00:04 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier\index.php(133): Kohana_Request->execute()
#3 {main}
2016-04-12 16:00:07 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-04-12 16:00:07 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier\index.php(133): Kohana_Request->execute()
#3 {main}
2016-04-12 16:00:10 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-04-12 16:00:10 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier\index.php(133): Kohana_Request->execute()
#3 {main}
2016-04-12 16:00:13 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-04-12 16:00:13 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier\index.php(133): Kohana_Request->execute()
#3 {main}
2016-04-12 16:00:16 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-04-12 16:00:16 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier\index.php(133): Kohana_Request->execute()
#3 {main}
2016-04-12 16:00:19 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-04-12 16:00:19 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier\index.php(133): Kohana_Request->execute()
#3 {main}
2016-04-12 16:00:22 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-04-12 16:00:22 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier\index.php(133): Kohana_Request->execute()
#3 {main}
2016-04-12 16:00:25 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-04-12 16:00:25 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier\index.php(133): Kohana_Request->execute()
#3 {main}
2016-04-12 16:00:28 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-04-12 16:00:28 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier\index.php(133): Kohana_Request->execute()
#3 {main}
2016-04-12 16:00:31 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-04-12 16:00:31 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier\index.php(133): Kohana_Request->execute()
#3 {main}
2016-04-12 16:00:34 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-04-12 16:00:34 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier\index.php(133): Kohana_Request->execute()
#3 {main}
2016-04-12 16:00:37 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-04-12 16:00:37 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier\index.php(133): Kohana_Request->execute()
#3 {main}
2016-04-12 16:00:40 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-04-12 16:00:40 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier\index.php(133): Kohana_Request->execute()
#3 {main}
2016-04-12 16:00:43 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-04-12 16:00:43 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier\index.php(133): Kohana_Request->execute()
#3 {main}
2016-04-12 16:00:46 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-04-12 16:00:46 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier\index.php(133): Kohana_Request->execute()
#3 {main}
2016-04-12 16:00:49 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-04-12 16:00:49 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier\index.php(133): Kohana_Request->execute()
#3 {main}
2016-04-12 16:00:52 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-04-12 16:00:52 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier\index.php(133): Kohana_Request->execute()
#3 {main}
2016-04-12 16:00:55 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-04-12 16:00:55 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier\index.php(133): Kohana_Request->execute()
#3 {main}
2016-04-12 16:00:58 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-04-12 16:00:58 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier\index.php(133): Kohana_Request->execute()
#3 {main}
2016-04-12 16:01:01 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-04-12 16:01:01 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier\index.php(133): Kohana_Request->execute()
#3 {main}
2016-04-12 16:01:04 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-04-12 16:01:04 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier\index.php(133): Kohana_Request->execute()
#3 {main}
2016-04-12 16:01:07 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-04-12 16:01:07 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier\index.php(133): Kohana_Request->execute()
#3 {main}
2016-04-12 16:01:10 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-04-12 16:01:10 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier\index.php(133): Kohana_Request->execute()
#3 {main}
2016-04-12 16:01:13 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-04-12 16:01:13 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier\index.php(133): Kohana_Request->execute()
#3 {main}
2016-04-12 16:01:16 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-04-12 16:01:16 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL pc/notice/ajax_checkorder was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier\index.php(133): Kohana_Request->execute()
#3 {main}