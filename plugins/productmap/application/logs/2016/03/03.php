<?php defined('SYSPATH') OR die('No direct script access.'); ?>

2016-03-03 11:44:04 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL pub/side_menu was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-03 11:44:04 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL pub/side_menu was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\application\cache\tplcache\default\list.php(32): Kohana_Request->execute()
#3 D:\web\v5\plugins\supplier_hotel\application\classes\stourweb\view.php(72): include('D:\web\v5\plugi...')
#4 D:\web\v5\plugins\supplier_hotel\application\classes\stourweb\view.php(373): Stourweb_View->capture('D:\web\v5\plugi...', Array)
#5 D:\web\v5\plugins\supplier_hotel\application\classes\stourweb\controller.php(51): Stourweb_View->render()
#6 D:\web\v5\plugins\supplier_hotel\application\classes\controller\index.php(34): Stourweb_Controller->display('list')
#7 [internal function]: Controller_Index->action_list()
#8 D:\web\v5\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Index))
#9 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#10 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#11 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#12 {main}
2016-03-03 11:45:23 --- ERROR: ErrorException [ 1 ]: Call to undefined method Common::css() ~ APPPATH\cache\tplcache\default\list.php [ 6 ]
2016-03-03 11:45:23 --- STRACE: ErrorException [ 1 ]: Call to undefined method Common::css() ~ APPPATH\cache\tplcache\default\list.php [ 6 ]
--
#0 [internal function]: Kohana_Core::shutdown_handler()
#1 {main}
2016-03-03 11:55:36 --- ERROR: Database_Exception [ 1146 ]: Table 'www_standsmore_com.sline_sline_sysconfig' doesn't exist [ SELECT `value` FROM `sline_sline_sysconfig` WHERE varname='cfg_logo' AND webid=0 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2016-03-03 11:55:36 --- STRACE: Database_Exception [ 1146 ]: Table 'www_standsmore_com.sline_sline_sysconfig' doesn't exist [ SELECT `value` FROM `sline_sline_sysconfig` WHERE varname='cfg_logo' AND webid=0 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 D:\web\v5\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `value` ...', false, Array)
#1 D:\web\v5\tools\common\functions.php(20): Kohana_Database_Query->execute()
#2 D:\web\v5\tools\common\functions.php(403): Functions::st_query('sline_sysconfig', 'varname='cfg_lo...', 'value', true)
#3 D:\web\v5\plugins\supplier_hotel\application\classes\controller\pub.php(18): Functions::get_sys_para('cfg_logo')
#4 [internal function]: Controller_Pub->action_header()
#5 D:\web\v5\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Pub))
#6 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#7 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#8 D:\web\v5\plugins\supplier_hotel\application\cache\tplcache\default\list.php(29): Kohana_Request->execute()
#9 D:\web\v5\plugins\supplier_hotel\application\classes\stourweb\view.php(72): include('D:\web\v5\plugi...')
#10 D:\web\v5\plugins\supplier_hotel\application\classes\stourweb\view.php(373): Stourweb_View->capture('D:\web\v5\plugi...', Array)
#11 D:\web\v5\plugins\supplier_hotel\application\classes\stourweb\controller.php(51): Stourweb_View->render()
#12 D:\web\v5\plugins\supplier_hotel\application\classes\controller\index.php(34): Stourweb_Controller->display('list')
#13 [internal function]: Controller_Index->action_list()
#14 D:\web\v5\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Index))
#15 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#16 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#17 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#18 {main}
2016-03-03 13:40:51 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL supplier/pc/login was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 13:40:51 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL supplier/pc/login was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 13:41:21 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL supplier/pc/login was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 13:41:21 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL supplier/pc/login was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 13:41:25 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL supplier/pc/login was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 13:41:25 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL supplier/pc/login was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 13:41:30 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL plugins/supplier/pc/login was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 13:41:30 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL plugins/supplier/pc/login was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 13:42:00 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL plugins/supplier/pc/login was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 13:42:00 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL plugins/supplier/pc/login was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 13:55:00 --- ERROR: ErrorException [ 4 ]: syntax error, unexpected '$', expecting '(' ~ APPPATH\cache\tplcache\default\pub\header.php [ 14 ]
2016-03-03 13:55:00 --- STRACE: ErrorException [ 4 ]: syntax error, unexpected '$', expecting '(' ~ APPPATH\cache\tplcache\default\pub\header.php [ 14 ]
--
#0 [internal function]: Kohana_Core::shutdown_handler()
#1 {main}
2016-03-03 14:16:23 --- ERROR: ErrorException [ 1 ]: Call to undefined method Common::getIco() ~ APPPATH\cache\tplcache\default\edit.php [ 57 ]
2016-03-03 14:16:23 --- STRACE: ErrorException [ 1 ]: Call to undefined method Common::getIco() ~ APPPATH\cache\tplcache\default\edit.php [ 57 ]
--
#0 [internal function]: Kohana_Core::shutdown_handler()
#1 {main}
2016-03-03 14:17:08 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 14:17:08 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 14:17:08 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 14:17:08 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 14:17:09 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 14:17:09 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 14:17:09 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/sp_btns.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 14:17:09 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/sp_btns.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 14:17:18 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/sp_btns.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 14:17:18 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/sp_btns.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 14:17:52 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 14:17:52 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 14:17:52 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/sp_btns.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 14:17:52 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/sp_btns.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 14:17:52 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 14:17:52 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 14:17:53 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 14:17:53 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 14:18:33 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/sp_btns.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 14:18:33 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/sp_btns.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 14:18:33 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 14:18:33 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 14:18:33 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 14:18:33 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 14:18:33 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 14:18:33 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 14:18:45 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/order was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-03 14:18:45 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/order was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 14:19:04 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/sp_btns.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 14:19:04 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/sp_btns.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 14:20:44 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/sp_btns.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 14:20:44 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/sp_btns.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 14:21:39 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 14:21:39 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 14:21:39 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/sp_btns.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 14:21:39 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/sp_btns.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 14:21:39 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 14:21:39 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 14:21:39 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 14:21:39 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 14:21:49 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 14:21:49 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 14:21:50 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 14:21:50 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 14:21:50 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/sp_btns.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 14:21:50 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/sp_btns.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 14:21:50 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 14:21:50 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 14:22:03 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/sp_btns.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 14:22:03 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/sp_btns.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 14:36:32 --- ERROR: ErrorException [ 4 ]: syntax error, unexpected '$this' (T_VARIABLE) ~ APPPATH\classes\controller\index.php [ 52 ]
2016-03-03 14:36:32 --- STRACE: ErrorException [ 4 ]: syntax error, unexpected '$this' (T_VARIABLE) ~ APPPATH\classes\controller\index.php [ 52 ]
--
#0 [internal function]: Kohana_Core::shutdown_handler()
#1 {main}
2016-03-03 14:43:36 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/sp_btns.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 14:43:36 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/sp_btns.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 14:43:36 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 14:43:36 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 14:43:36 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 14:43:36 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 14:43:36 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 14:43:36 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 15:14:59 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 15:14:59 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 15:14:59 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 15:14:59 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 15:14:59 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/sp_btns.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 15:14:59 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/sp_btns.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 15:14:59 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 15:14:59 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 15:15:03 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/sp_btns.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 15:15:03 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/sp_btns.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 15:15:03 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 15:15:03 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 15:15:03 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 15:15:03 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 15:15:03 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 15:15:03 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 15:15:57 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 15:15:57 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 15:15:57 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 15:15:57 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 15:15:57 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/sp_btns.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 15:15:57 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/sp_btns.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 15:15:57 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 15:15:57 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 15:16:44 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 15:16:44 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 15:16:44 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 15:16:44 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 15:16:44 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/sp_btns.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 15:16:44 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/sp_btns.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 15:16:44 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 15:16:44 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 15:17:10 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 15:17:10 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 15:17:10 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 15:17:10 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 15:17:10 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 15:17:10 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 15:17:10 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/sp_btns.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 15:17:10 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/sp_btns.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 15:17:28 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 15:17:28 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 15:17:28 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 15:17:28 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 15:17:29 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 15:17:29 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 15:17:29 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/sp_btns.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 15:17:29 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/sp_btns.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 15:19:16 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/sp_btns.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 15:19:16 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/sp_btns.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 15:20:47 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 15:20:47 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 15:20:47 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 15:20:47 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 15:20:47 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/sp_btns.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 15:20:47 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/sp_btns.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 15:20:48 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 15:20:48 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 15:25:09 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 15:25:09 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 15:25:09 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 15:25:09 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 15:25:09 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 15:25:09 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 15:27:10 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 15:27:10 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 15:27:11 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 15:27:11 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 15:27:11 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 15:27:11 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 15:27:30 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 15:27:30 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 15:27:30 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 15:27:30 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 15:27:30 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 15:27:30 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 15:28:55 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/close-sp.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 15:28:55 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/close-sp.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 15:28:55 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 15:28:55 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 15:28:56 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 15:28:56 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 15:28:56 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 15:28:56 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 15:30:38 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 15:30:38 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 15:30:38 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 15:30:38 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 15:30:38 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 15:30:38 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 15:35:19 --- ERROR: ErrorException [ 1 ]: Call to undefined method Common::getEditor() ~ APPPATH\cache\tplcache\default\edit.php [ 191 ]
2016-03-03 15:35:19 --- STRACE: ErrorException [ 1 ]: Call to undefined method Common::getEditor() ~ APPPATH\cache\tplcache\default\edit.php [ 191 ]
--
#0 [internal function]: Kohana_Core::shutdown_handler()
#1 {main}
2016-03-03 15:35:33 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/vendor/slineeditor/js/editor_config.js was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-03 15:35:33 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/vendor/slineeditor/js/editor_config.js was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 15:35:33 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/vendor/slineeditor/js/editor_ui_all.js was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-03 15:35:33 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/vendor/slineeditor/js/editor_ui_all.js was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 15:35:33 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/vendor/slineeditor/lang/zh-cn/zh-cn.js was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-03 15:35:33 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/vendor/slineeditor/lang/zh-cn/zh-cn.js was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 15:35:33 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/vendor/slineeditor/themes/default/css/ueditor.css was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-03 15:35:33 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/vendor/slineeditor/themes/default/css/ueditor.css was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 15:35:34 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 15:35:34 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 15:35:34 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 15:35:34 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 15:35:34 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 15:35:34 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 15:38:55 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/vendor/slineeditor/themes/default/css/ueditor.css was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-03 15:38:55 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/vendor/slineeditor/themes/default/css/ueditor.css was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 15:39:59 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 15:39:59 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 15:40:00 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 15:40:00 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 15:40:00 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 15:40:00 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 15:41:22 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 15:41:22 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 15:41:22 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 15:41:22 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 15:41:22 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 15:41:22 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 16:01:06 --- ERROR: ErrorException [ 1 ]: Call to undefined method Common::getEditor() ~ APPPATH\cache\tplcache\default\edit.php [ 197 ]
2016-03-03 16:01:06 --- STRACE: ErrorException [ 1 ]: Call to undefined method Common::getEditor() ~ APPPATH\cache\tplcache\default\edit.php [ 197 ]
--
#0 [internal function]: Kohana_Core::shutdown_handler()
#1 {main}
2016-03-03 16:01:37 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 16:01:37 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 16:01:37 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 16:01:37 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 16:01:37 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 16:01:37 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 16:07:56 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 16:07:56 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 16:07:56 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 16:07:56 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 16:07:57 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 16:07:57 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 16:09:27 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 16:09:27 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 16:09:27 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 16:09:27 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 16:09:27 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 16:09:27 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 16:10:48 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 16:10:48 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 16:10:49 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 16:10:49 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 16:10:49 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 16:10:49 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 16:40:16 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/order was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-03 16:40:16 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/order was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 16:40:16 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/order was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-03 16:40:16 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/order was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 17:38:00 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 17:38:00 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/temp-chg-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 17:38:00 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 17:38:00 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-03 17:38:00 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-03 17:38:00 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/base-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_hotel\index.php(131): Kohana_Request->execute()
#3 {main}