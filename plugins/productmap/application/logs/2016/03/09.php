<?php defined('SYSPATH') OR die('No direct script access.'); ?>

2016-03-09 11:22:47 --- ERROR: ErrorException [ 4 ]: syntax error, unexpected T_PUBLIC ~ APPPATH\classes\controller\Index.php [ 3 ]
2016-03-09 11:22:47 --- STRACE: ErrorException [ 4 ]: syntax error, unexpected T_PUBLIC ~ APPPATH\classes\controller\Index.php [ 3 ]
--
#0 [internal function]: Kohana_Core::shutdown_handler()
#1 {main}
2016-03-09 11:23:10 --- ERROR: View_Exception [ 0 ]: The requested view default/index could not be found ~ APPPATH\classes\stourweb\view.php [ 324 ]
2016-03-09 11:23:10 --- STRACE: View_Exception [ 0 ]: The requested view default/index could not be found ~ APPPATH\classes\stourweb\view.php [ 324 ]
--
#0 D:\HTML\standsmore5\plugins\fenxiao\application\classes\stourweb\view.php(187): Stourweb_View->set_filename('default/index')
#1 D:\HTML\standsmore5\plugins\fenxiao\application\classes\stourweb\view.php(30): Stourweb_View->__construct('default/index', NULL, NULL, NULL)
#2 D:\HTML\standsmore5\plugins\fenxiao\application\classes\stourweb\controller.php(43): Stourweb_View::factory('default/index')
#3 D:\HTML\standsmore5\plugins\fenxiao\application\classes\controller\Index.php(11): Stourweb_Controller->display('index')
#4 [internal function]: Controller_Index->action_index()
#5 D:\HTML\standsmore5\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Index))
#6 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#7 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#8 D:\HTML\standsmore5\plugins\fenxiao\index.php(131): Kohana_Request->execute()
#9 {main}
2016-03-09 15:15:31 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-09 15:15:31 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-09 15:17:36 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-09 15:17:36 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-09 15:18:19 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-09 15:18:19 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-09 15:19:45 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-09 15:19:45 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-09 15:20:23 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-09 15:20:23 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-09 15:20:38 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-09 15:20:38 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-09 15:21:33 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-09 15:21:33 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-09 15:21:35 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-09 15:21:35 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-09 15:21:46 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-09 15:21:46 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-09 15:22:57 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-09 15:22:57 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-09 15:23:13 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-09 15:23:13 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-09 15:24:39 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-09 15:24:39 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-09 15:24:40 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-09 15:24:40 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-09 15:25:51 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-09 15:25:51 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-09 15:25:53 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-09 15:25:53 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-09 15:25:57 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-09 15:25:57 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-09 15:26:04 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-09 15:26:04 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-09 15:26:04 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-09 15:26:04 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-09 15:26:04 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-09 15:26:04 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-09 15:29:53 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-09 15:29:53 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-09 15:30:56 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-09 15:30:56 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-09 15:30:59 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-09 15:30:59 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-09 15:31:19 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-09 15:31:19 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-09 15:31:24 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-09 15:31:24 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-09 15:31:27 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-09 15:31:27 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-09 15:31:38 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-09 15:31:38 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-09 15:31:41 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-09 15:31:41 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-09 15:33:04 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-09 15:33:04 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-09 15:33:06 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-09 15:33:06 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-09 15:33:07 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-09 15:33:07 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-09 15:33:14 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-09 15:33:14 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-09 15:33:46 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-09 15:33:46 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/null was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-09 17:19:08 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/joinus was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-09 17:19:08 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/joinus was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-09 17:19:10 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/joinus was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-09 17:19:10 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/joinus was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-09 17:20:11 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/joinus was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-09 17:20:11 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/joinus was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-09 17:20:17 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/joinus was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-09 17:20:17 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/joinus was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-09 17:20:54 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'a.id is not null and a.fxpcode='dsfdsfdfs' order by a.fxjointime desc limit 0,10' at line 1 [ select a.*,b.* from sline_fenxiao a inner join sline_member b on a.memberid=b.mid  a.id is not null and a.fxpcode='dsfdsfdfs' order by a.fxjointime desc limit 0,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2016-03-09 17:20:54 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'a.id is not null and a.fxpcode='dsfdsfdfs' order by a.fxjointime desc limit 0,10' at line 1 [ select a.*,b.* from sline_fenxiao a inner join sline_member b on a.memberid=b.mid  a.id is not null and a.fxpcode='dsfdsfdfs' order by a.fxjointime desc limit 0,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 D:\HTML\standsmore5\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select a.*,b.* ...', false, Array)
#1 D:\HTML\standsmore5\plugins\fx_phone\application\classes\controller\Index.php(108): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Index->action_ajax_getsubmember()
#3 D:\HTML\standsmore5\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Index))
#4 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#6 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#7 {main}
2016-03-09 17:55:56 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/share was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-09 17:55:56 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/share was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-09 18:34:02 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL commission/index was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-09 18:34:02 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL commission/index was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-09 18:35:38 --- ERROR: Database_Exception [ 1582 ]: Incorrect parameter count in the call to native function 'isnull' [ select sum(isnull(withdrawamount,0)) as amount from sline_fenxiao where memberid=169 and status=1 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2016-03-09 18:35:38 --- STRACE: Database_Exception [ 1582 ]: Incorrect parameter count in the call to native function 'isnull' [ select sum(isnull(withdrawamount,0)) as amount from sline_fenxiao where memberid=169 and status=1 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 D:\HTML\standsmore5\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select sum(isnu...', false, Array)
#1 D:\HTML\standsmore5\plugins\fx_phone\application\classes\model\fenxiao.php(106): Kohana_Database_Query->execute()
#2 D:\HTML\standsmore5\plugins\fx_phone\application\classes\controller\commission.php(20): Model_Fenxiao::get_withdrawed_amount('169')
#3 [internal function]: Controller_Commission->action_index()
#4 D:\HTML\standsmore5\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Commission))
#5 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#7 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#8 {main}
2016-03-09 18:35:58 --- ERROR: Database_Exception [ 1582 ]: Incorrect parameter count in the call to native function 'isnull' [ select sum(isnull(withdrawamount,0)) as amount from sline_fenxiao_withdraw where memberid=169 and status=1 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2016-03-09 18:35:58 --- STRACE: Database_Exception [ 1582 ]: Incorrect parameter count in the call to native function 'isnull' [ select sum(isnull(withdrawamount,0)) as amount from sline_fenxiao_withdraw where memberid=169 and status=1 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 D:\HTML\standsmore5\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select sum(isnu...', false, Array)
#1 D:\HTML\standsmore5\plugins\fx_phone\application\classes\model\fenxiao.php(106): Kohana_Database_Query->execute()
#2 D:\HTML\standsmore5\plugins\fx_phone\application\classes\controller\commission.php(20): Model_Fenxiao::get_withdrawed_amount('169')
#3 [internal function]: Controller_Commission->action_index()
#4 D:\HTML\standsmore5\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Commission))
#5 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#7 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#8 {main}
2016-03-09 19:17:16 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/progress was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-09 19:17:16 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/progress was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-09 19:18:06 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/progress was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-09 19:18:06 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/progress was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-09 19:25:40 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL commission/progress was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-09 19:25:40 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL commission/progress was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\HTML\standsmore5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\HTML\standsmore5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\HTML\standsmore5\plugins\fx_phone\index.php(131): Kohana_Request->execute()
#3 {main}