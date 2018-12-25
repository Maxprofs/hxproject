<?php defined('SYSPATH') OR die('No direct script access.'); ?>

2016-06-07 16:38:16 --- ERROR: View_Exception [ 0 ]: The requested view default/conf could not be found ~ APPPATH\classes\stourweb\view.php [ 281 ]
2016-06-07 16:38:16 --- STRACE: View_Exception [ 0 ]: The requested view default/conf could not be found ~ APPPATH\classes\stourweb\view.php [ 281 ]
--
#0 D:\wamp\www\V5\plugins\login_wx_client\application\classes\stourweb\view.php(157): Stourweb_View->set_filename('default/conf')
#1 D:\wamp\www\V5\plugins\login_wx_client\application\classes\stourweb\view.php(30): Stourweb_View->__construct('default/conf', NULL)
#2 D:\wamp\www\V5\plugins\login_wx_client\application\classes\stourweb\controller.php(95): Stourweb_View::factory('default/conf')
#3 D:\wamp\www\V5\plugins\login_wx_client\application\classes\controller\conf.php(14): Stourweb_Controller->display('conf')
#4 [internal function]: Controller_Conf->action_index()
#5 D:\wamp\www\V5\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Conf))
#6 D:\wamp\www\V5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#7 D:\wamp\www\V5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#8 D:\wamp\www\V5\plugins\login_wx_client\index.php(133): Kohana_Request->execute()
#9 {main}
2016-06-07 16:39:08 --- ERROR: View_Exception [ 0 ]: The requested view default/stourtravel/conf could not be found ~ APPPATH\classes\stourweb\view.php [ 281 ]
2016-06-07 16:39:08 --- STRACE: View_Exception [ 0 ]: The requested view default/stourtravel/conf could not be found ~ APPPATH\classes\stourweb\view.php [ 281 ]
--
#0 D:\wamp\www\V5\plugins\login_wx_client\application\classes\stourweb\view.php(157): Stourweb_View->set_filename('default/stourtr...')
#1 D:\wamp\www\V5\plugins\login_wx_client\application\classes\stourweb\view.php(30): Stourweb_View->__construct('default/stourtr...', NULL)
#2 D:\wamp\www\V5\plugins\login_wx_client\application\classes\stourweb\controller.php(95): Stourweb_View::factory('default/stourtr...')
#3 D:\wamp\www\V5\plugins\login_wx_client\application\classes\controller\conf.php(14): Stourweb_Controller->display('stourtravel/con...')
#4 [internal function]: Controller_Conf->action_index()
#5 D:\wamp\www\V5\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Conf))
#6 D:\wamp\www\V5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#7 D:\wamp\www\V5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#8 D:\wamp\www\V5\plugins\login_wx_client\index.php(133): Kohana_Request->execute()
#9 {main}
2016-06-07 16:43:28 --- ERROR: View_Exception [ 0 ]: The requested view stourtravel/public/public_js could not be found ~ APPPATH\classes\stourweb\view.php [ 281 ]
2016-06-07 16:43:28 --- STRACE: View_Exception [ 0 ]: The requested view stourtravel/public/public_js could not be found ~ APPPATH\classes\stourweb\view.php [ 281 ]
--
#0 D:\wamp\www\V5\plugins\login_wx_client\application\classes\stourweb\view.php(157): Stourweb_View->set_filename('stourtravel/pub...')
#1 D:\wamp\www\V5\plugins\login_wx_client\application\classes\stourweb\view.php(30): Stourweb_View->__construct('stourtravel/pub...', Array)
#2 D:\wamp\www\V5\plugins\login_wx_client\application\classes\stourweb\view.php(581): Stourweb_View::factory('stourtravel/pub...', Array)
#3 D:\wamp\www\V5\plugins\login_wx_client\application\cache\tplcache\default\stourtravel\conf.php(6): Stourweb_View::template('stourtravel/pub...')
#4 D:\wamp\www\V5\plugins\login_wx_client\application\classes\stourweb\view.php(72): include('D:\\wamp\\www\\V5\\...')
#5 D:\wamp\www\V5\plugins\login_wx_client\application\classes\stourweb\view.php(373): Stourweb_View->capture('D:\\wamp\\www\\V5\\...', Array)
#6 D:\wamp\www\V5\plugins\login_wx_client\application\classes\stourweb\controller.php(102): Stourweb_View->render()
#7 D:\wamp\www\V5\plugins\login_wx_client\application\classes\controller\conf.php(14): Stourweb_Controller->display('stourtravel/con...')
#8 [internal function]: Controller_Conf->action_index()
#9 D:\wamp\www\V5\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Conf))
#10 D:\wamp\www\V5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#11 D:\wamp\www\V5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#12 D:\wamp\www\V5\plugins\login_wx_client\index.php(133): Kohana_Request->execute()
#13 {main}
2016-06-07 16:49:30 --- ERROR: View_Exception [ 0 ]: The requested view stourtravel/public/leftnav could not be found ~ APPPATH\classes\stourweb\view.php [ 281 ]
2016-06-07 16:49:30 --- STRACE: View_Exception [ 0 ]: The requested view stourtravel/public/leftnav could not be found ~ APPPATH\classes\stourweb\view.php [ 281 ]
--
#0 D:\wamp\www\V5\plugins\login_wx_client\application\classes\stourweb\view.php(157): Stourweb_View->set_filename('stourtravel/pub...')
#1 D:\wamp\www\V5\plugins\login_wx_client\application\classes\stourweb\view.php(30): Stourweb_View->__construct('stourtravel/pub...', Array)
#2 D:\wamp\www\V5\plugins\login_wx_client\application\classes\stourweb\view.php(581): Stourweb_View::factory('stourtravel/pub...', Array)
#3 D:\wamp\www\V5\plugins\login_wx_client\application\cache\tplcache\default\stourtravel\conf.php(44): Stourweb_View::template('stourtravel/pub...')
#4 D:\wamp\www\V5\plugins\login_wx_client\application\classes\stourweb\view.php(72): include('D:\\wamp\\www\\V5\\...')
#5 D:\wamp\www\V5\plugins\login_wx_client\application\classes\stourweb\view.php(373): Stourweb_View->capture('D:\\wamp\\www\\V5\\...', Array)
#6 D:\wamp\www\V5\plugins\login_wx_client\application\classes\stourweb\controller.php(102): Stourweb_View->render()
#7 D:\wamp\www\V5\plugins\login_wx_client\application\classes\controller\conf.php(14): Stourweb_Controller->display('stourtravel/con...')
#8 [internal function]: Controller_Conf->action_index()
#9 D:\wamp\www\V5\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Conf))
#10 D:\wamp\www\V5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#11 D:\wamp\www\V5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#12 D:\wamp\www\V5\plugins\login_wx_client\index.php(133): Kohana_Request->execute()
#13 {main}
2016-06-07 16:54:18 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL config/ajax_getconfig was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-06-07 16:54:18 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL config/ajax_getconfig was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\wamp\www\V5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\wamp\www\V5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\wamp\www\V5\plugins\login_wx_client\index.php(133): Kohana_Request->execute()
#3 {main}
2016-06-07 16:56:53 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL config/ajax_getconfig was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-06-07 16:56:53 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL config/ajax_getconfig was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\wamp\www\V5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\wamp\www\V5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\wamp\www\V5\plugins\login_wx_client\index.php(133): Kohana_Request->execute()
#3 {main}
2016-06-07 16:59:22 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL config/ajax_getconfig was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-06-07 16:59:22 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL config/ajax_getconfig was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\wamp\www\V5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\wamp\www\V5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\wamp\www\V5\plugins\login_wx_client\index.php(133): Kohana_Request->execute()
#3 {main}
2016-06-07 17:00:05 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL config/ajax_getconfig was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-06-07 17:00:05 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL config/ajax_getconfig was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\wamp\www\V5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\wamp\www\V5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\wamp\www\V5\plugins\login_wx_client\index.php(133): Kohana_Request->execute()
#3 {main}
2016-06-07 17:02:16 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL config/ajax_getconfig was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-06-07 17:02:16 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL config/ajax_getconfig was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\wamp\www\V5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\wamp\www\V5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\wamp\www\V5\plugins\login_wx_client\index.php(133): Kohana_Request->execute()
#3 {main}
2016-06-07 17:03:20 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL config/ajax_getconfig was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-06-07 17:03:20 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL config/ajax_getconfig was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\wamp\www\V5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\wamp\www\V5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\wamp\www\V5\plugins\login_wx_client\index.php(133): Kohana_Request->execute()
#3 {main}
2016-06-07 17:03:41 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL config/ajax_getconfig was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-06-07 17:03:41 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL config/ajax_getconfig was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\wamp\www\V5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\wamp\www\V5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\wamp\www\V5\plugins\login_wx_client\index.php(133): Kohana_Request->execute()
#3 {main}
2016-06-07 17:20:35 --- ERROR: ErrorException [ 1 ]: Call to undefined method Common::checkLogin() ~ APPPATH\classes\stourweb\controller.php [ 47 ]
2016-06-07 17:20:35 --- STRACE: ErrorException [ 1 ]: Call to undefined method Common::checkLogin() ~ APPPATH\classes\stourweb\controller.php [ 47 ]
--
#0 [internal function]: Kohana_Core::shutdown_handler()
#1 {main}
2016-06-07 17:31:51 --- ERROR: ErrorException [ 1 ]: Call to undefined method Common::checkLogin() ~ APPPATH\classes\stourweb\controller.php [ 47 ]
2016-06-07 17:31:51 --- STRACE: ErrorException [ 1 ]: Call to undefined method Common::checkLogin() ~ APPPATH\classes\stourweb\controller.php [ 47 ]
--
#0 [internal function]: Kohana_Core::shutdown_handler()
#1 {main}
2016-06-07 17:42:23 --- ERROR: ErrorException [ 1 ]: Class 'Model_admin' not found ~ MODPATH\orm\classes\kohana\orm.php [ 46 ]
2016-06-07 17:42:23 --- STRACE: ErrorException [ 1 ]: Class 'Model_admin' not found ~ MODPATH\orm\classes\kohana\orm.php [ 46 ]
--
#0 [internal function]: Kohana_Core::shutdown_handler()
#1 {main}
2016-06-07 17:42:48 --- ERROR: ErrorException [ 1 ]: Class 'Model_role_module' not found ~ MODPATH\orm\classes\kohana\orm.php [ 46 ]
2016-06-07 17:42:48 --- STRACE: ErrorException [ 1 ]: Class 'Model_role_module' not found ~ MODPATH\orm\classes\kohana\orm.php [ 46 ]
--
#0 [internal function]: Kohana_Core::shutdown_handler()
#1 {main}