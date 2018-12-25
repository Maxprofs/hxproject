<?php defined('SYSPATH') OR die('No direct script access.'); ?>

2016-03-04 11:01:11 --- ERROR: View_Exception [ 0 ]: The requested view pub/public_js could not be found ~ APPPATH\classes\stourweb\view.php [ 281 ]
2016-03-04 11:01:11 --- STRACE: View_Exception [ 0 ]: The requested view pub/public_js could not be found ~ APPPATH\classes\stourweb\view.php [ 281 ]
--
#0 D:\web\v5\plugins\supplier_hotel\application\classes\stourweb\view.php(157): Stourweb_View->set_filename('pub/public_js')
#1 D:\web\v5\plugins\supplier_hotel\application\classes\stourweb\view.php(30): Stourweb_View->__construct('pub/public_js', Array)
#2 D:\web\v5\plugins\supplier_hotel\application\classes\stourweb\view.php(581): Stourweb_View::factory('pub/public_js', Array)
#3 D:\web\v5\plugins\supplier_hotel\application\cache\tplcache\default\edit.php(7): Stourweb_View::template('pub/public_js')
#4 D:\web\v5\plugins\supplier_hotel\application\classes\stourweb\view.php(72): include('D:\web\v5\plugi...')
#5 D:\web\v5\plugins\supplier_hotel\application\classes\stourweb\view.php(373): Stourweb_View->capture('D:\web\v5\plugi...', Array)
#6 D:\web\v5\plugins\supplier_hotel\application\classes\stourweb\controller.php(50): Stourweb_View->render()
#7 D:\web\v5\plugins\supplier_hotel\application\classes\controller\index.php(33): Stourweb_Controller->display('edit')
#8 [internal function]: Controller_Index->action_add()
#9 D:\web\v5\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Index))
#10 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#11 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#12 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#13 {main}
2016-03-04 11:01:45 --- ERROR: View_Exception [ 0 ]: The requested view pub/public_js could not be found ~ APPPATH\classes\stourweb\view.php [ 281 ]
2016-03-04 11:01:45 --- STRACE: View_Exception [ 0 ]: The requested view pub/public_js could not be found ~ APPPATH\classes\stourweb\view.php [ 281 ]
--
#0 D:\web\v5\plugins\supplier_hotel\application\classes\stourweb\view.php(157): Stourweb_View->set_filename('pub/public_js')
#1 D:\web\v5\plugins\supplier_hotel\application\classes\stourweb\view.php(30): Stourweb_View->__construct('pub/public_js', Array)
#2 D:\web\v5\plugins\supplier_hotel\application\classes\stourweb\view.php(581): Stourweb_View::factory('pub/public_js', Array)
#3 D:\web\v5\plugins\supplier_hotel\application\cache\tplcache\default\edit.php(7): Stourweb_View::template('pub/public_js')
#4 D:\web\v5\plugins\supplier_hotel\application\classes\stourweb\view.php(72): include('D:\web\v5\plugi...')
#5 D:\web\v5\plugins\supplier_hotel\application\classes\stourweb\view.php(373): Stourweb_View->capture('D:\web\v5\plugi...', Array)
#6 D:\web\v5\plugins\supplier_hotel\application\classes\stourweb\controller.php(50): Stourweb_View->render()
#7 D:\web\v5\plugins\supplier_hotel\application\classes\controller\index.php(33): Stourweb_Controller->display('edit')
#8 [internal function]: Controller_Index->action_add()
#9 D:\web\v5\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Index))
#10 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#11 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#12 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#13 {main}
2016-03-04 11:03:03 --- ERROR: View_Exception [ 0 ]: The requested view pub/public_js could not be found ~ APPPATH\classes\stourweb\view.php [ 281 ]
2016-03-04 11:03:03 --- STRACE: View_Exception [ 0 ]: The requested view pub/public_js could not be found ~ APPPATH\classes\stourweb\view.php [ 281 ]
--
#0 D:\web\v5\plugins\supplier_hotel\application\classes\stourweb\view.php(157): Stourweb_View->set_filename('pub/public_js')
#1 D:\web\v5\plugins\supplier_hotel\application\classes\stourweb\view.php(30): Stourweb_View->__construct('pub/public_js', Array)
#2 D:\web\v5\plugins\supplier_hotel\application\classes\stourweb\view.php(581): Stourweb_View::factory('pub/public_js', Array)
#3 D:\web\v5\plugins\supplier_hotel\application\cache\tplcache\default\edit.php(7): Stourweb_View::template('pub/public_js')
#4 D:\web\v5\plugins\supplier_hotel\application\classes\stourweb\view.php(72): include('D:\web\v5\plugi...')
#5 D:\web\v5\plugins\supplier_hotel\application\classes\stourweb\view.php(373): Stourweb_View->capture('D:\web\v5\plugi...', Array)
#6 D:\web\v5\plugins\supplier_hotel\application\classes\stourweb\controller.php(50): Stourweb_View->render()
#7 D:\web\v5\plugins\supplier_hotel\application\classes\controller\index.php(33): Stourweb_Controller->display('edit')
#8 [internal function]: Controller_Index->action_add()
#9 D:\web\v5\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Index))
#10 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#11 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#12 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#13 {main}
2016-03-04 11:03:31 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 11:03:31 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 11:03:31 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 11:03:31 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 11:03:31 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 11:03:31 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 11:03:49 --- ERROR: View_Exception [ 0 ]: The requested view pub/public_js could not be found ~ APPPATH\classes\stourweb\view.php [ 281 ]
2016-03-04 11:03:49 --- STRACE: View_Exception [ 0 ]: The requested view pub/public_js could not be found ~ APPPATH\classes\stourweb\view.php [ 281 ]
--
#0 D:\web\v5\plugins\supplier_hotel\application\classes\stourweb\view.php(157): Stourweb_View->set_filename('pub/public_js')
#1 D:\web\v5\plugins\supplier_hotel\application\classes\stourweb\view.php(30): Stourweb_View->__construct('pub/public_js', Array)
#2 D:\web\v5\plugins\supplier_hotel\application\classes\stourweb\view.php(581): Stourweb_View::factory('pub/public_js', Array)
#3 D:\web\v5\plugins\supplier_hotel\application\cache\tplcache\default\edit.php(14): Stourweb_View::template('pub/public_js')
#4 D:\web\v5\plugins\supplier_hotel\application\classes\stourweb\view.php(72): include('D:\web\v5\plugi...')
#5 D:\web\v5\plugins\supplier_hotel\application\classes\stourweb\view.php(373): Stourweb_View->capture('D:\web\v5\plugi...', Array)
#6 D:\web\v5\plugins\supplier_hotel\application\classes\stourweb\controller.php(50): Stourweb_View->render()
#7 D:\web\v5\plugins\supplier_hotel\application\classes\controller\index.php(33): Stourweb_Controller->display('edit')
#8 [internal function]: Controller_Index->action_add()
#9 D:\web\v5\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Index))
#10 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#11 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#12 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#13 {main}
2016-03-04 11:07:03 --- ERROR: View_Exception [ 0 ]: The requested view pub/public_js could not be found ~ APPPATH\classes\stourweb\view.php [ 281 ]
2016-03-04 11:07:03 --- STRACE: View_Exception [ 0 ]: The requested view pub/public_js could not be found ~ APPPATH\classes\stourweb\view.php [ 281 ]
--
#0 D:\web\v5\plugins\supplier_hotel\application\classes\stourweb\view.php(157): Stourweb_View->set_filename('pub/public_js')
#1 D:\web\v5\plugins\supplier_hotel\application\classes\stourweb\view.php(30): Stourweb_View->__construct('pub/public_js', Array)
#2 D:\web\v5\plugins\supplier_hotel\application\classes\stourweb\view.php(581): Stourweb_View::factory('pub/public_js', Array)
#3 D:\web\v5\plugins\supplier_hotel\application\cache\tplcache\default\edit.php(14): Stourweb_View::template('pub/public_js')
#4 D:\web\v5\plugins\supplier_hotel\application\classes\stourweb\view.php(72): include('D:\web\v5\plugi...')
#5 D:\web\v5\plugins\supplier_hotel\application\classes\stourweb\view.php(373): Stourweb_View->capture('D:\web\v5\plugi...', Array)
#6 D:\web\v5\plugins\supplier_hotel\application\classes\stourweb\controller.php(50): Stourweb_View->render()
#7 D:\web\v5\plugins\supplier_hotel\application\classes\controller\index.php(33): Stourweb_Controller->display('edit')
#8 [internal function]: Controller_Index->action_add()
#9 D:\web\v5\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Index))
#10 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#11 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#12 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#13 {main}
2016-03-04 11:09:38 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL tools/js/msgbox/msgbox.css was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 11:09:38 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL tools/js/msgbox/msgbox.css was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 11:33:12 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 11:33:12 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 11:33:12 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 11:33:12 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 11:33:12 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 11:33:12 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 11:33:34 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 11:33:34 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 11:33:34 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 11:33:34 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 11:33:34 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 11:33:34 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 11:37:37 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 11:37:37 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 11:37:37 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 11:37:37 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 11:37:37 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 11:37:37 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 11:38:26 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 11:38:26 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 11:38:26 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 11:38:26 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 11:38:26 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 11:38:26 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 11:38:46 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 11:38:46 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 11:38:46 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 11:38:46 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 11:38:46 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 11:38:46 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 11:38:51 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL destination/dialog_setdest was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 11:38:51 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL destination/dialog_setdest was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 11:39:06 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL destination/dialog_setdest was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 11:39:06 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL destination/dialog_setdest was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 11:39:37 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 11:39:37 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 11:39:37 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 11:39:37 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 11:39:37 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 11:39:37 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 11:39:38 --- ERROR: View_Exception [ 0 ]: The requested view default/pub could not be found ~ APPPATH\classes\stourweb\view.php [ 324 ]
2016-03-04 11:39:38 --- STRACE: View_Exception [ 0 ]: The requested view default/pub could not be found ~ APPPATH\classes\stourweb\view.php [ 324 ]
--
#0 D:\web\v5\plugins\supplier_hotel\application\classes\stourweb\view.php(187): Stourweb_View->set_filename('default/pub')
#1 D:\web\v5\plugins\supplier_hotel\application\classes\stourweb\view.php(30): Stourweb_View->__construct('default/pub', Array, NULL, NULL)
#2 D:\web\v5\plugins\supplier_hotel\application\classes\stourweb\view.php(634): Stourweb_View::factory('default/pub', Array)
#3 D:\web\v5\plugins\supplier_hotel\application\cache\tplcache\default\destination\dialog_setdest.php(6): Stourweb_View::template('pub')
#4 D:\web\v5\plugins\supplier_hotel\application\classes\stourweb\view.php(74): include('D:\web\v5\plugi...')
#5 D:\web\v5\plugins\supplier_hotel\application\classes\stourweb\view.php(417): Stourweb_View->capture('D:\web\v5\plugi...', Array)
#6 D:\web\v5\plugins\supplier_hotel\application\classes\stourweb\controller.php(50): Stourweb_View->render()
#7 D:\web\v5\plugins\supplier_hotel\application\classes\controller\destination.php(139): Stourweb_Controller->display('destination/dia...')
#8 [internal function]: Controller_Destination->action_dialog_setdest()
#9 D:\web\v5\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Destination))
#10 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#11 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#12 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#13 {main}
2016-03-04 11:44:33 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 11:44:33 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 11:44:33 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/dest_btns.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 11:44:33 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/dest_btns.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 11:44:41 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/dest_btns.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 11:44:41 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/dest_btns.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 11:47:06 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 11:47:06 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/dest_btns.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 11:47:06 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 11:47:06 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/dest_btns.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 11:47:52 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/dest_btns.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 11:47:52 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/dest_btns.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 11:50:56 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 11:50:56 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/dest_btns.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 11:50:56 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 11:50:56 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/dest_btns.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 11:51:05 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/dest_btns.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 11:51:05 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/dest_btns.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 11:55:20 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/dest_btns.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 11:55:20 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/dest_btns.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 11:55:22 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/dest_btns.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 11:55:22 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/dest_btns.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 11:55:26 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/dest_btns.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 11:55:26 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/dest_btns.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 11:55:50 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/dest_btns.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 11:55:50 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/dest_btns.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 12:00:58 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL plugins/supplier_hotel/public/css/base.css was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 12:00:58 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL plugins/supplier_hotel/public/css/base.css was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 12:00:58 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL plugins/supplier_hotel/public/css/style_hotel.css was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 12:00:58 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL plugins/supplier_hotel/public/css/style_hotel.css was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 12:00:58 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL plugins/supplier_hotel/public/css/base_hotel.css was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 12:00:58 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL plugins/supplier_hotel/public/css/base_hotel.css was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 12:00:58 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL plugins/supplier_hotel/public/css/style.css was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 12:00:58 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL plugins/supplier_hotel/public/css/style.css was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 12:00:58 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL plugins/supplier_hotel/public/css/destination_dialog_setdest.css was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 12:00:58 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL plugins/supplier_hotel/public/css/destination_dialog_setdest.css was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 12:01:01 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL plugins/supplier_hotel/public/css/style_hotel.css was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 12:01:01 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL plugins/supplier_hotel/public/css/style_hotel.css was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 12:01:01 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL plugins/supplier_hotel/public/css/style.css was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 12:01:01 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL plugins/supplier_hotel/public/css/style.css was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 12:01:01 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL plugins/supplier_hotel/public/css/base.css was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 12:01:01 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL plugins/supplier_hotel/public/css/base.css was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 12:01:01 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL plugins/supplier_hotel/public/css/destination_dialog_setdest.css was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 12:01:01 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL plugins/supplier_hotel/public/css/destination_dialog_setdest.css was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 12:01:01 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL plugins/supplier_hotel/public/css/base_hotel.css was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 12:01:01 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL plugins/supplier_hotel/public/css/base_hotel.css was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 12:04:23 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 12:04:23 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 12:04:50 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 12:04:50 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 12:09:08 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 12:09:08 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 13:20:00 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL supplier/dialog_set was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 13:20:00 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL supplier/dialog_set was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 13:20:34 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 13:20:34 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 13:20:34 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 13:20:34 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 13:20:34 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 13:20:34 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 13:21:40 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 13:21:40 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 13:21:40 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 13:21:40 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 13:21:40 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 13:21:40 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 13:53:19 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 13:53:19 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 13:53:55 --- ERROR: ErrorException [ 1 ]: Class 'Model_model' not found ~ MODPATH\orm\classes\kohana\orm.php [ 46 ]
2016-03-04 13:53:55 --- STRACE: ErrorException [ 1 ]: Class 'Model_model' not found ~ MODPATH\orm\classes\kohana\orm.php [ 46 ]
--
#0 [internal function]: Kohana_Core::shutdown_handler()
#1 {main}
2016-03-04 13:54:37 --- ERROR: View_Exception [ 0 ]: The requested view default/pub could not be found ~ APPPATH\classes\stourweb\view.php [ 324 ]
2016-03-04 13:54:37 --- STRACE: View_Exception [ 0 ]: The requested view default/pub could not be found ~ APPPATH\classes\stourweb\view.php [ 324 ]
--
#0 D:\web\v5\plugins\supplier_hotel\application\classes\stourweb\view.php(187): Stourweb_View->set_filename('default/pub')
#1 D:\web\v5\plugins\supplier_hotel\application\classes\stourweb\view.php(30): Stourweb_View->__construct('default/pub', Array, NULL, NULL)
#2 D:\web\v5\plugins\supplier_hotel\application\classes\stourweb\view.php(634): Stourweb_View::factory('default/pub', Array)
#3 D:\web\v5\plugins\supplier_hotel\application\cache\tplcache\default\attrid\dialog_setattrid.php(6): Stourweb_View::template('pub')
#4 D:\web\v5\plugins\supplier_hotel\application\classes\stourweb\view.php(74): include('D:\web\v5\plugi...')
#5 D:\web\v5\plugins\supplier_hotel\application\classes\stourweb\view.php(417): Stourweb_View->capture('D:\web\v5\plugi...', Array)
#6 D:\web\v5\plugins\supplier_hotel\application\classes\stourweb\controller.php(50): Stourweb_View->render()
#7 D:\web\v5\plugins\supplier_hotel\application\classes\controller\attrid.php(515): Stourweb_Controller->display('attrid/dialog_s...')
#8 [internal function]: Controller_Attrid->action_dialog_setattrid()
#9 D:\web\v5\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Attrid))
#10 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#11 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#12 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#13 {main}
2016-03-04 14:02:36 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 14:02:36 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 14:02:36 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 14:02:36 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 14:02:36 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 14:02:36 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 14:02:48 --- ERROR: ErrorException [ 1 ]: Call to undefined method Common::getWebList() ~ APPPATH\classes\controller\icon.php [ 37 ]
2016-03-04 14:02:48 --- STRACE: ErrorException [ 1 ]: Call to undefined method Common::getWebList() ~ APPPATH\classes\controller\icon.php [ 37 ]
--
#0 [internal function]: Kohana_Core::shutdown_handler()
#1 {main}
2016-03-04 14:04:32 --- ERROR: View_Exception [ 0 ]: The requested view default/stourtravel/public/public_min_js could not be found ~ APPPATH\classes\stourweb\view.php [ 324 ]
2016-03-04 14:04:32 --- STRACE: View_Exception [ 0 ]: The requested view default/stourtravel/public/public_min_js could not be found ~ APPPATH\classes\stourweb\view.php [ 324 ]
--
#0 D:\web\v5\plugins\supplier_hotel\application\classes\stourweb\view.php(187): Stourweb_View->set_filename('default/stourtr...')
#1 D:\web\v5\plugins\supplier_hotel\application\classes\stourweb\view.php(30): Stourweb_View->__construct('default/stourtr...', Array, NULL, NULL)
#2 D:\web\v5\plugins\supplier_hotel\application\classes\stourweb\view.php(634): Stourweb_View::factory('default/stourtr...', Array)
#3 D:\web\v5\plugins\supplier_hotel\application\cache\tplcache\default\icon\dialog_seticon.php(6): Stourweb_View::template('stourtravel/pub...')
#4 D:\web\v5\plugins\supplier_hotel\application\classes\stourweb\view.php(74): include('D:\web\v5\plugi...')
#5 D:\web\v5\plugins\supplier_hotel\application\classes\stourweb\view.php(417): Stourweb_View->capture('D:\web\v5\plugi...', Array)
#6 D:\web\v5\plugins\supplier_hotel\application\classes\stourweb\controller.php(50): Stourweb_View->render()
#7 D:\web\v5\plugins\supplier_hotel\application\classes\controller\icon.php(213): Stourweb_Controller->display('icon/dialog_set...')
#8 [internal function]: Controller_Icon->action_dialog_seticon()
#9 D:\web\v5\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Icon))
#10 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#11 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#12 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#13 {main}
2016-03-04 14:05:20 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 14:05:20 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 14:05:20 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 14:05:20 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 14:05:20 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 14:05:20 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 14:06:00 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 14:06:00 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 14:06:12 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 14:06:12 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 14:08:29 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/vendor/baidumap/index.html was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 14:08:29 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/vendor/baidumap/index.html was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 15:56:09 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 15:56:09 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 15:56:09 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 15:56:09 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 16:08:17 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 16:08:17 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 16:08:17 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 16:08:17 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 16:09:14 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 16:09:14 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 16:09:14 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 16:09:14 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 16:10:14 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 16:10:14 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 16:10:14 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 16:10:14 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 16:10:31 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL supplier/dialog_set was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 16:10:31 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL supplier/dialog_set was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 16:10:38 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 16:10:38 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 16:12:44 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 16:12:44 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 16:12:44 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 16:12:44 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 16:12:48 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL supplier/dialog_set was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 16:12:48 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL supplier/dialog_set was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 16:12:55 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 16:12:55 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 16:12:55 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 16:12:55 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 16:12:56 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL supplier/dialog_set was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 16:12:56 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL supplier/dialog_set was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 16:13:08 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL supplier/dialog_set was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 16:13:08 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL supplier/dialog_set was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 16:13:23 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL supplier/dialog_set was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 16:13:23 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL supplier/dialog_set was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 16:15:12 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 16:15:12 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 16:15:12 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 16:15:12 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 16:15:15 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL supplier/dialog_set was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 16:15:15 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL supplier/dialog_set was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 16:16:29 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 16:16:29 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 16:16:29 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 16:16:29 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 16:17:42 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 16:17:42 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-04 16:17:42 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-04 16:17:42 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}