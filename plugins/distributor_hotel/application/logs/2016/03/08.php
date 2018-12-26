<?php defined('SYSPATH') OR die('No direct script access.'); ?>

2016-03-08 09:25:36 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-08 09:25:36 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\distributor_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-08 09:40:48 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-08 09:40:48 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\distributor_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-08 09:49:40 --- ERROR: Kohana_Exception [ 0 ]: Cannot update hotel model because it is not loaded. ~ MODPATH\orm\classes\kohana\orm.php [ 1486 ]
2016-03-08 09:49:40 --- STRACE: Kohana_Exception [ 0 ]: Cannot update hotel model because it is not loaded. ~ MODPATH\orm\classes\kohana\orm.php [ 1486 ]
--
#0 D:\web\v5\plugins\distributor_hotel\application\classes\model\hotel.php(28): Kohana_ORM->update()
#1 D:\web\v5\plugins\distributor_hotel\application\classes\controller\index.php(471): Model_Hotel::update_min_price('')
#2 D:\web\v5\plugins\distributor_hotel\application\classes\controller\index.php(318): Controller_Index->save_baojia('', '262', Array)
#3 [internal function]: Controller_Index->action_ajax_suit_save()
#4 D:\web\v5\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Index))
#5 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#7 D:\web\v5\plugins\distributor_hotel\index.php(131): Kohana_Request->execute()
#8 {main}
2016-03-08 09:49:49 --- ERROR: Kohana_Exception [ 0 ]: Cannot update hotel model because it is not loaded. ~ MODPATH\orm\classes\kohana\orm.php [ 1486 ]
2016-03-08 09:49:49 --- STRACE: Kohana_Exception [ 0 ]: Cannot update hotel model because it is not loaded. ~ MODPATH\orm\classes\kohana\orm.php [ 1486 ]
--
#0 D:\web\v5\plugins\distributor_hotel\application\classes\model\hotel.php(28): Kohana_ORM->update()
#1 D:\web\v5\plugins\distributor_hotel\application\classes\controller\index.php(471): Model_Hotel::update_min_price('')
#2 D:\web\v5\plugins\distributor_hotel\application\classes\controller\index.php(318): Controller_Index->save_baojia('', '262', Array)
#3 [internal function]: Controller_Index->action_ajax_suit_save()
#4 D:\web\v5\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Index))
#5 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#7 D:\web\v5\plugins\distributor_hotel\index.php(131): Kohana_Request->execute()
#8 {main}
2016-03-08 09:50:03 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-08 09:50:03 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\distributor_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-08 09:51:10 --- ERROR: Kohana_Exception [ 0 ]: Cannot update hotel model because it is not loaded. ~ MODPATH\orm\classes\kohana\orm.php [ 1486 ]
2016-03-08 09:51:10 --- STRACE: Kohana_Exception [ 0 ]: Cannot update hotel model because it is not loaded. ~ MODPATH\orm\classes\kohana\orm.php [ 1486 ]
--
#0 D:\web\v5\plugins\distributor_hotel\application\classes\model\hotel.php(28): Kohana_ORM->update()
#1 D:\web\v5\plugins\distributor_hotel\application\classes\controller\index.php(471): Model_Hotel::update_min_price('')
#2 D:\web\v5\plugins\distributor_hotel\application\classes\controller\index.php(318): Controller_Index->save_baojia('', '262', Array)
#3 [internal function]: Controller_Index->action_ajax_suit_save()
#4 D:\web\v5\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Index))
#5 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#7 D:\web\v5\plugins\distributor_hotel\index.php(131): Kohana_Request->execute()
#8 {main}
2016-03-08 10:02:20 --- ERROR: Kohana_Exception [ 0 ]: Cannot update hotel model because it is not loaded. ~ MODPATH\orm\classes\kohana\orm.php [ 1486 ]
2016-03-08 10:02:20 --- STRACE: Kohana_Exception [ 0 ]: Cannot update hotel model because it is not loaded. ~ MODPATH\orm\classes\kohana\orm.php [ 1486 ]
--
#0 D:\web\v5\plugins\distributor_hotel\application\classes\model\hotel.php(28): Kohana_ORM->update()
#1 D:\web\v5\plugins\distributor_hotel\application\classes\controller\index.php(471): Model_Hotel::update_min_price('')
#2 D:\web\v5\plugins\distributor_hotel\application\classes\controller\index.php(318): Controller_Index->save_baojia('', '262', Array)
#3 [internal function]: Controller_Index->action_ajax_suit_save()
#4 D:\web\v5\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Index))
#5 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#7 D:\web\v5\plugins\distributor_hotel\index.php(131): Kohana_Request->execute()
#8 {main}
2016-03-08 10:28:46 --- ERROR: ErrorException [ 1 ]: Call to undefined method Common::myDate() ~ APPPATH\classes\controller\calendar.php [ 346 ]
2016-03-08 10:28:46 --- STRACE: ErrorException [ 1 ]: Call to undefined method Common::myDate() ~ APPPATH\classes\controller\calendar.php [ 346 ]
--
#0 [internal function]: Kohana_Core::shutdown_handler()
#1 {main}
2016-03-08 10:33:23 --- ERROR: ErrorException [ 1 ]: Call to undefined method Common::myDate() ~ APPPATH\classes\controller\calendar.php [ 346 ]
2016-03-08 10:33:23 --- STRACE: ErrorException [ 1 ]: Call to undefined method Common::myDate() ~ APPPATH\classes\controller\calendar.php [ 346 ]
--
#0 [internal function]: Kohana_Core::shutdown_handler()
#1 {main}
2016-03-08 10:51:03 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-08 10:51:03 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\distributor_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-08 11:13:46 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/add_suit was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-08 11:13:46 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/add_suit was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\distributor_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-08 11:14:05 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/add_suit was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-08 11:14:05 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/add_suit was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\distributor_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-08 11:14:08 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL index/add_suit was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-08 11:14:08 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL index/add_suit was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\distributor_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-08 11:14:14 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-08 11:14:14 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\distributor_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-08 11:15:44 --- ERROR: Kohana_Exception [ 0 ]: Cannot update hotel model because it is not loaded. ~ MODPATH\orm\classes\kohana\orm.php [ 1486 ]
2016-03-08 11:15:44 --- STRACE: Kohana_Exception [ 0 ]: Cannot update hotel model because it is not loaded. ~ MODPATH\orm\classes\kohana\orm.php [ 1486 ]
--
#0 D:\web\v5\plugins\distributor_hotel\application\classes\model\hotel.php(28): Kohana_ORM->update()
#1 D:\web\v5\plugins\distributor_hotel\application\classes\controller\index.php(489): Model_Hotel::update_min_price('')
#2 D:\web\v5\plugins\distributor_hotel\application\classes\controller\index.php(336): Controller_Index->save_baojia('', 263, Array)
#3 [internal function]: Controller_Index->action_ajax_suit_save()
#4 D:\web\v5\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Index))
#5 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#7 D:\web\v5\plugins\distributor_hotel\index.php(131): Kohana_Request->execute()
#8 {main}
2016-03-08 11:15:51 --- ERROR: Kohana_Exception [ 0 ]: Cannot update hotel model because it is not loaded. ~ MODPATH\orm\classes\kohana\orm.php [ 1486 ]
2016-03-08 11:15:51 --- STRACE: Kohana_Exception [ 0 ]: Cannot update hotel model because it is not loaded. ~ MODPATH\orm\classes\kohana\orm.php [ 1486 ]
--
#0 D:\web\v5\plugins\distributor_hotel\application\classes\model\hotel.php(28): Kohana_ORM->update()
#1 D:\web\v5\plugins\distributor_hotel\application\classes\controller\index.php(489): Model_Hotel::update_min_price('')
#2 D:\web\v5\plugins\distributor_hotel\application\classes\controller\index.php(336): Controller_Index->save_baojia('', 264, Array)
#3 [internal function]: Controller_Index->action_ajax_suit_save()
#4 D:\web\v5\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Index))
#5 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#7 D:\web\v5\plugins\distributor_hotel\index.php(131): Kohana_Request->execute()
#8 {main}
2016-03-08 11:15:59 --- ERROR: Kohana_Exception [ 0 ]: Cannot update hotel model because it is not loaded. ~ MODPATH\orm\classes\kohana\orm.php [ 1486 ]
2016-03-08 11:15:59 --- STRACE: Kohana_Exception [ 0 ]: Cannot update hotel model because it is not loaded. ~ MODPATH\orm\classes\kohana\orm.php [ 1486 ]
--
#0 D:\web\v5\plugins\distributor_hotel\application\classes\model\hotel.php(28): Kohana_ORM->update()
#1 D:\web\v5\plugins\distributor_hotel\application\classes\controller\index.php(489): Model_Hotel::update_min_price('')
#2 D:\web\v5\plugins\distributor_hotel\application\classes\controller\index.php(336): Controller_Index->save_baojia('', 265, Array)
#3 [internal function]: Controller_Index->action_ajax_suit_save()
#4 D:\web\v5\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Index))
#5 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#7 D:\web\v5\plugins\distributor_hotel\index.php(131): Kohana_Request->execute()
#8 {main}
2016-03-08 11:16:15 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-08 11:16:15 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\distributor_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-08 11:24:16 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-08 11:24:16 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\distributor_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-08 11:42:07 --- ERROR: Kohana_Exception [ 0 ]: The  property does not exist in the Model_Hotel_Room class ~ MODPATH\orm\classes\kohana\orm.php [ 771 ]
2016-03-08 11:42:07 --- STRACE: Kohana_Exception [ 0 ]: The  property does not exist in the Model_Hotel_Room class ~ MODPATH\orm\classes\kohana\orm.php [ 771 ]
--
#0 D:\web\v5\core\modules\orm\classes\kohana\orm.php(713): Kohana_ORM->set('', NULL)
#1 D:\web\v5\plugins\distributor_hotel\application\classes\controller\index.php(501): Kohana_ORM->__set('', NULL)
#2 [internal function]: Controller_Index->action_ajax_suit_jifen()
#3 D:\web\v5\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Index))
#4 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#6 D:\web\v5\plugins\distributor_hotel\index.php(131): Kohana_Request->execute()
#7 {main}
2016-03-08 11:42:07 --- ERROR: Kohana_Exception [ 0 ]: The  property does not exist in the Model_Hotel_Room class ~ MODPATH\orm\classes\kohana\orm.php [ 771 ]
2016-03-08 11:42:07 --- STRACE: Kohana_Exception [ 0 ]: The  property does not exist in the Model_Hotel_Room class ~ MODPATH\orm\classes\kohana\orm.php [ 771 ]
--
#0 D:\web\v5\core\modules\orm\classes\kohana\orm.php(713): Kohana_ORM->set('', NULL)
#1 D:\web\v5\plugins\distributor_hotel\application\classes\controller\index.php(501): Kohana_ORM->__set('', NULL)
#2 [internal function]: Controller_Index->action_ajax_suit_jifen()
#3 D:\web\v5\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Index))
#4 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#6 D:\web\v5\plugins\distributor_hotel\index.php(131): Kohana_Request->execute()
#7 {main}
2016-03-08 11:42:08 --- ERROR: Kohana_Exception [ 0 ]: The  property does not exist in the Model_Hotel_Room class ~ MODPATH\orm\classes\kohana\orm.php [ 771 ]
2016-03-08 11:42:08 --- STRACE: Kohana_Exception [ 0 ]: The  property does not exist in the Model_Hotel_Room class ~ MODPATH\orm\classes\kohana\orm.php [ 771 ]
--
#0 D:\web\v5\core\modules\orm\classes\kohana\orm.php(713): Kohana_ORM->set('', NULL)
#1 D:\web\v5\plugins\distributor_hotel\application\classes\controller\index.php(501): Kohana_ORM->__set('', NULL)
#2 [internal function]: Controller_Index->action_ajax_suit_jifen()
#3 D:\web\v5\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Index))
#4 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#6 D:\web\v5\plugins\distributor_hotel\index.php(131): Kohana_Request->execute()
#7 {main}
2016-03-08 11:42:08 --- ERROR: Kohana_Exception [ 0 ]: The  property does not exist in the Model_Hotel_Room class ~ MODPATH\orm\classes\kohana\orm.php [ 771 ]
2016-03-08 11:42:08 --- STRACE: Kohana_Exception [ 0 ]: The  property does not exist in the Model_Hotel_Room class ~ MODPATH\orm\classes\kohana\orm.php [ 771 ]
--
#0 D:\web\v5\core\modules\orm\classes\kohana\orm.php(713): Kohana_ORM->set('', NULL)
#1 D:\web\v5\plugins\distributor_hotel\application\classes\controller\index.php(501): Kohana_ORM->__set('', NULL)
#2 [internal function]: Controller_Index->action_ajax_suit_jifen()
#3 D:\web\v5\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Index))
#4 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#6 D:\web\v5\plugins\distributor_hotel\index.php(131): Kohana_Request->execute()
#7 {main}
2016-03-08 11:42:08 --- ERROR: Kohana_Exception [ 0 ]: The  property does not exist in the Model_Hotel_Room class ~ MODPATH\orm\classes\kohana\orm.php [ 771 ]
2016-03-08 11:42:08 --- STRACE: Kohana_Exception [ 0 ]: The  property does not exist in the Model_Hotel_Room class ~ MODPATH\orm\classes\kohana\orm.php [ 771 ]
--
#0 D:\web\v5\core\modules\orm\classes\kohana\orm.php(713): Kohana_ORM->set('', NULL)
#1 D:\web\v5\plugins\distributor_hotel\application\classes\controller\index.php(501): Kohana_ORM->__set('', NULL)
#2 [internal function]: Controller_Index->action_ajax_suit_jifen()
#3 D:\web\v5\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Index))
#4 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#6 D:\web\v5\plugins\distributor_hotel\index.php(131): Kohana_Request->execute()
#7 {main}
2016-03-08 11:42:08 --- ERROR: Kohana_Exception [ 0 ]: The  property does not exist in the Model_Hotel_Room class ~ MODPATH\orm\classes\kohana\orm.php [ 771 ]
2016-03-08 11:42:08 --- STRACE: Kohana_Exception [ 0 ]: The  property does not exist in the Model_Hotel_Room class ~ MODPATH\orm\classes\kohana\orm.php [ 771 ]
--
#0 D:\web\v5\core\modules\orm\classes\kohana\orm.php(713): Kohana_ORM->set('', NULL)
#1 D:\web\v5\plugins\distributor_hotel\application\classes\controller\index.php(501): Kohana_ORM->__set('', NULL)
#2 [internal function]: Controller_Index->action_ajax_suit_jifen()
#3 D:\web\v5\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Index))
#4 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#6 D:\web\v5\plugins\distributor_hotel\index.php(131): Kohana_Request->execute()
#7 {main}
2016-03-08 11:42:08 --- ERROR: Kohana_Exception [ 0 ]: The  property does not exist in the Model_Hotel_Room class ~ MODPATH\orm\classes\kohana\orm.php [ 771 ]
2016-03-08 11:42:08 --- STRACE: Kohana_Exception [ 0 ]: The  property does not exist in the Model_Hotel_Room class ~ MODPATH\orm\classes\kohana\orm.php [ 771 ]
--
#0 D:\web\v5\core\modules\orm\classes\kohana\orm.php(713): Kohana_ORM->set('', NULL)
#1 D:\web\v5\plugins\distributor_hotel\application\classes\controller\index.php(501): Kohana_ORM->__set('', NULL)
#2 [internal function]: Controller_Index->action_ajax_suit_jifen()
#3 D:\web\v5\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Index))
#4 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#6 D:\web\v5\plugins\distributor_hotel\index.php(131): Kohana_Request->execute()
#7 {main}
2016-03-08 11:47:15 --- ERROR: Kohana_Exception [ 0 ]: The  property does not exist in the Model_Hotel_Room class ~ MODPATH\orm\classes\kohana\orm.php [ 771 ]
2016-03-08 11:47:15 --- STRACE: Kohana_Exception [ 0 ]: The  property does not exist in the Model_Hotel_Room class ~ MODPATH\orm\classes\kohana\orm.php [ 771 ]
--
#0 D:\web\v5\core\modules\orm\classes\kohana\orm.php(713): Kohana_ORM->set('', NULL)
#1 D:\web\v5\plugins\distributor_hotel\application\classes\controller\index.php(501): Kohana_ORM->__set('', NULL)
#2 [internal function]: Controller_Index->action_ajax_suit_jifen()
#3 D:\web\v5\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Index))
#4 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#6 D:\web\v5\plugins\distributor_hotel\index.php(131): Kohana_Request->execute()
#7 {main}
2016-03-08 14:06:39 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-08 14:06:39 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\distributor_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-08 14:07:47 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-08 14:07:47 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\distributor_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-08 14:07:51 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-08 14:07:51 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\distributor_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-08 14:07:53 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-08 14:07:53 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\distributor_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-08 14:09:09 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-08 14:09:09 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\distributor_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-08 14:09:18 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-08 14:09:18 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\distributor_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-08 14:20:53 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-08 14:20:53 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\distributor_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-08 14:21:08 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-08 14:21:08 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\distributor_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-08 14:21:29 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-08 14:21:29 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\distributor_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-08 14:21:30 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-08 14:21:30 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\distributor_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-08 14:26:28 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-08 14:26:28 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\distributor_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-08 14:26:49 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-08 14:26:49 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\distributor_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-08 14:27:03 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-08 14:27:03 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\distributor_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-08 14:32:59 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-08 14:32:59 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\distributor_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-08 14:35:50 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-08 14:35:50 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\distributor_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-08 14:35:50 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-08 14:35:50 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\distributor_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-08 14:37:17 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-08 14:37:17 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\distributor_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-08 14:37:38 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-08 14:37:38 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\distributor_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-08 14:37:46 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-08 14:37:46 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\distributor_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-08 14:40:10 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-08 14:40:10 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\distributor_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-08 14:40:17 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-08 14:40:17 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\distributor_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-08 14:40:20 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-08 14:40:20 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\distributor_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-08 14:40:24 --- ERROR: View_Exception [ 0 ]: The requested view default/pc/pub/header could not be found ~ APPPATH\classes\stourweb\view.php [ 324 ]
2016-03-08 14:40:24 --- STRACE: View_Exception [ 0 ]: The requested view default/pc/pub/header could not be found ~ APPPATH\classes\stourweb\view.php [ 324 ]
--
#0 D:\web\v5\plugins\distributor_hotel\application\classes\stourweb\view.php(187): Stourweb_View->set_filename('default/pc/pub/...')
#1 D:\web\v5\plugins\distributor_hotel\application\classes\stourweb\view.php(30): Stourweb_View->__construct('default/pc/pub/...', Array, NULL, NULL)
#2 D:\web\v5\plugins\distributor_hotel\application\classes\stourweb\view.php(634): Stourweb_View::factory('default/pc/pub/...', Array)
#3 D:\web\v5\plugins\distributor_hotel\application\cache\tplcache\default\order\show.php(11): Stourweb_View::template('pc/pub/header')
#4 D:\web\v5\plugins\distributor_hotel\application\classes\stourweb\view.php(74): include('D:\web\v5\plugi...')
#5 D:\web\v5\plugins\distributor_hotel\application\classes\stourweb\view.php(417): Stourweb_View->capture('D:\web\v5\plugi...', Array)
#6 D:\web\v5\plugins\distributor_hotel\application\classes\stourweb\controller.php(50): Stourweb_View->render()
#7 D:\web\v5\plugins\distributor_hotel\application\classes\controller\order.php(54): Stourweb_Controller->display('order/show')
#8 [internal function]: Controller_Order->action_show()
#9 D:\web\v5\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Order))
#10 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#11 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#12 D:\web\v5\plugins\distributor_hotel\index.php(131): Kohana_Request->execute()
#13 {main}
2016-03-08 14:40:47 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-08 14:40:47 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\distributor_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-08 14:40:47 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-08 14:40:47 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\distributor_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-08 14:40:48 --- ERROR: View_Exception [ 0 ]: The requested view default/pc/pub/header could not be found ~ APPPATH\classes\stourweb\view.php [ 324 ]
2016-03-08 14:40:48 --- STRACE: View_Exception [ 0 ]: The requested view default/pc/pub/header could not be found ~ APPPATH\classes\stourweb\view.php [ 324 ]
--
#0 D:\web\v5\plugins\distributor_hotel\application\classes\stourweb\view.php(187): Stourweb_View->set_filename('default/pc/pub/...')
#1 D:\web\v5\plugins\distributor_hotel\application\classes\stourweb\view.php(30): Stourweb_View->__construct('default/pc/pub/...', Array, NULL, NULL)
#2 D:\web\v5\plugins\distributor_hotel\application\classes\stourweb\view.php(634): Stourweb_View::factory('default/pc/pub/...', Array)
#3 D:\web\v5\plugins\distributor_hotel\application\cache\tplcache\default\order\show.php(11): Stourweb_View::template('pc/pub/header')
#4 D:\web\v5\plugins\distributor_hotel\application\classes\stourweb\view.php(74): include('D:\web\v5\plugi...')
#5 D:\web\v5\plugins\distributor_hotel\application\classes\stourweb\view.php(417): Stourweb_View->capture('D:\web\v5\plugi...', Array)
#6 D:\web\v5\plugins\distributor_hotel\application\classes\stourweb\controller.php(50): Stourweb_View->render()
#7 D:\web\v5\plugins\distributor_hotel\application\classes\controller\order.php(54): Stourweb_Controller->display('order/show')
#8 [internal function]: Controller_Order->action_show()
#9 D:\web\v5\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Order))
#10 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#11 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#12 D:\web\v5\plugins\distributor_hotel\index.php(131): Kohana_Request->execute()
#13 {main}
2016-03-08 14:42:21 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-08 14:42:21 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\distributor_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-08 14:42:25 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-08 14:42:25 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\distributor_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-08 14:42:32 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-08 14:42:32 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\distributor_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-08 14:42:38 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-08 14:42:38 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\distributor_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-08 14:42:40 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-08 14:42:40 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\distributor_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-08 14:42:46 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-08 14:42:46 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\distributor_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-08 14:43:59 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-08 14:43:59 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\distributor_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-08 14:44:12 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-08 14:44:12 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\distributor_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-08 14:44:18 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-08 14:44:18 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\distributor_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-08 14:44:21 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-08 14:44:21 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\distributor_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-08 14:44:23 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-08 14:44:23 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\distributor_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-08 14:44:25 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-08 14:44:25 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\distributor_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-08 14:44:59 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-08 14:44:59 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\distributor_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-08 14:45:03 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-08 14:45:03 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\distributor_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-08 14:45:21 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-08 14:45:21 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\distributor_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-08 14:45:38 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'AND (ordersn='成都' OR eticketno='成都')' at line 1 [ SELECT COUNT(`sline_member_order`.`id`) AS `records_found` FROM `sline_member_order` AS `sline_member_order` WHERE  AND (ordersn='成都' OR eticketno='成都') ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2016-03-08 14:45:38 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'AND (ordersn='成都' OR eticketno='成都')' at line 1 [ SELECT COUNT(`sline_member_order`.`id`) AS `records_found` FROM `sline_member_order` AS `sline_member_order` WHERE  AND (ordersn='成都' OR eticketno='成都') ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 D:\web\v5\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'SELECT COUNT(`s...', false, Array)
#1 D:\web\v5\core\modules\orm\classes\kohana\orm.php(1780): Kohana_Database_Query->execute(Object(Database_MySQL))
#2 D:\web\v5\plugins\distributor_hotel\application\classes\model\member\order.php(295): Kohana_ORM->count_all()
#3 D:\web\v5\plugins\distributor_hotel\application\classes\model\member\order.php(196): Model_Member_Order->_set_pages('member_order', 30, Array, 'addtime', ' AND (ordersn='...', 'DESC', 'query_string')
#4 D:\web\v5\plugins\distributor_hotel\application\classes\controller\order.php(40): Model_Member_Order->get_my_order_list(2, 30)
#5 [internal function]: Controller_Order->action_all()
#6 D:\web\v5\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Order))
#7 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#8 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#9 D:\web\v5\plugins\distributor_hotel\index.php(131): Kohana_Request->execute()
#10 {main}
2016-03-08 14:46:08 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'AND (ordersn='成都' OR eticketno='成都')' at line 1 [ SELECT COUNT(`sline_member_order`.`id`) AS `records_found` FROM `sline_member_order` AS `sline_member_order` WHERE  AND (ordersn='成都' OR eticketno='成都') ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2016-03-08 14:46:08 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'AND (ordersn='成都' OR eticketno='成都')' at line 1 [ SELECT COUNT(`sline_member_order`.`id`) AS `records_found` FROM `sline_member_order` AS `sline_member_order` WHERE  AND (ordersn='成都' OR eticketno='成都') ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 D:\web\v5\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'SELECT COUNT(`s...', false, Array)
#1 D:\web\v5\core\modules\orm\classes\kohana\orm.php(1780): Kohana_Database_Query->execute(Object(Database_MySQL))
#2 D:\web\v5\plugins\distributor_hotel\application\classes\model\member\order.php(293): Kohana_ORM->count_all()
#3 D:\web\v5\plugins\distributor_hotel\application\classes\model\member\order.php(194): Model_Member_Order->_set_pages('member_order', 30, Array, 'addtime', ' AND (ordersn='...', 'DESC', 'query_string')
#4 D:\web\v5\plugins\distributor_hotel\application\classes\controller\order.php(40): Model_Member_Order->get_my_order_list(2, 30)
#5 [internal function]: Controller_Order->action_all()
#6 D:\web\v5\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Order))
#7 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#8 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#9 D:\web\v5\plugins\distributor_hotel\index.php(131): Kohana_Request->execute()
#10 {main}
2016-03-08 14:46:19 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-08 14:46:19 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\distributor_hotel\index.php(131): Kohana_Request->execute()
#3 {main}
2016-03-08 14:48:58 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'id='5359'' at line 1 [ SELECT `sline_member_order`.`id` AS `id`, `sline_member_order`.`ordersn` AS `ordersn`, `sline_member_order`.`memberid` AS `memberid`, `sline_member_order`.`typeid` AS `typeid`, `sline_member_order`.`distributorlist` AS `distributorlist`, `sline_member_order`.`webid` AS `webid`, `sline_member_order`.`productaid` AS `productaid`, `sline_member_order`.`productname` AS `productname`, `sline_member_order`.`productautoid` AS `productautoid`, `sline_member_order`.`litpic` AS `litpic`, `sline_member_order`.`price` AS `price`, `sline_member_order`.`marketprice` AS `marketprice`, `sline_member_order`.`spotprice` AS `spotprice`, `sline_member_order`.`distributorprice` AS `distributorprice`, `sline_member_order`.`childprice` AS `childprice`, `sline_member_order`.`usedate` AS `usedate`, `sline_member_order`.`dingnum` AS `dingnum`, `sline_member_order`.`childnum` AS `childnum`, `sline_member_order`.`ispay` AS `ispay`, `sline_member_order`.`status` AS `status`, `sline_member_order`.`linkman` AS `linkman`, `sline_member_order`.`linktel` AS `linktel`, `sline_member_order`.`linkemail` AS `linkemail`, `sline_member_order`.`linkqq` AS `linkqq`, `sline_member_order`.`linkidcard` AS `linkidcard`, `sline_member_order`.`isneedpiao` AS `isneedpiao`, `sline_member_order`.`addtime` AS `addtime`, `sline_member_order`.`finishtime` AS `finishtime`, `sline_member_order`.`ispinlun` AS `ispinlun`, `sline_member_order`.`jifencomment` AS `jifencomment`, `sline_member_order`.`jifentprice` AS `jifentprice`, `sline_member_order`.`jifenbook` AS `jifenbook`, `sline_member_order`.`dingjin` AS `dingjin`, `sline_member_order`.`suitid` AS `suitid`, `sline_member_order`.`paytype` AS `paytype`, `sline_member_order`.`oldnum` AS `oldnum`, `sline_member_order`.`oldprice` AS `oldprice`, `sline_member_order`.`usejifen` AS `usejifen`, `sline_member_order`.`needjifen` AS `needjifen`, `sline_member_order`.`pid` AS `pid`, `sline_member_order`.`haschild` AS `haschild`, `sline_member_order`.`remark` AS `remark`, `sline_member_order`.`kindlist` AS `kindlist`, `sline_member_order`.`roombalance` AS `roombalance`, `sline_member_order`.`roombalancenum` AS `roombalancenum`, `sline_member_order`.`viewstatus` AS `viewstatus`, `sline_member_order`.`roombalance_paytype` AS `roombalance_paytype`, `sline_member_order`.`paysource` AS `paysource`, `sline_member_order`.`departdate` AS `departdate`, `sline_member_order`.`eticketno` AS `eticketno`, `sline_member_order`.`isconsume` AS `isconsume`, `sline_member_order`.`consumetime` AS `consumetime`, `sline_member_order`.`consumeverifyuser` AS `consumeverifyuser`, `sline_member_order`.`consumeverifymemo` AS `consumeverifymemo`, `sline_member_order`.`distributororderexdata` AS `distributororderexdata` FROM `sline_member_order` AS `sline_member_order` WHERE  find_in_set('0',distributorlist)  id='5359' ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2016-03-08 14:48:58 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'id='5359'' at line 1 [ SELECT `sline_member_order`.`id` AS `id`, `sline_member_order`.`ordersn` AS `ordersn`, `sline_member_order`.`memberid` AS `memberid`, `sline_member_order`.`typeid` AS `typeid`, `sline_member_order`.`distributorlist` AS `distributorlist`, `sline_member_order`.`webid` AS `webid`, `sline_member_order`.`productaid` AS `productaid`, `sline_member_order`.`productname` AS `productname`, `sline_member_order`.`productautoid` AS `productautoid`, `sline_member_order`.`litpic` AS `litpic`, `sline_member_order`.`price` AS `price`, `sline_member_order`.`marketprice` AS `marketprice`, `sline_member_order`.`spotprice` AS `spotprice`, `sline_member_order`.`distributorprice` AS `distributorprice`, `sline_member_order`.`childprice` AS `childprice`, `sline_member_order`.`usedate` AS `usedate`, `sline_member_order`.`dingnum` AS `dingnum`, `sline_member_order`.`childnum` AS `childnum`, `sline_member_order`.`ispay` AS `ispay`, `sline_member_order`.`status` AS `status`, `sline_member_order`.`linkman` AS `linkman`, `sline_member_order`.`linktel` AS `linktel`, `sline_member_order`.`linkemail` AS `linkemail`, `sline_member_order`.`linkqq` AS `linkqq`, `sline_member_order`.`linkidcard` AS `linkidcard`, `sline_member_order`.`isneedpiao` AS `isneedpiao`, `sline_member_order`.`addtime` AS `addtime`, `sline_member_order`.`finishtime` AS `finishtime`, `sline_member_order`.`ispinlun` AS `ispinlun`, `sline_member_order`.`jifencomment` AS `jifencomment`, `sline_member_order`.`jifentprice` AS `jifentprice`, `sline_member_order`.`jifenbook` AS `jifenbook`, `sline_member_order`.`dingjin` AS `dingjin`, `sline_member_order`.`suitid` AS `suitid`, `sline_member_order`.`paytype` AS `paytype`, `sline_member_order`.`oldnum` AS `oldnum`, `sline_member_order`.`oldprice` AS `oldprice`, `sline_member_order`.`usejifen` AS `usejifen`, `sline_member_order`.`needjifen` AS `needjifen`, `sline_member_order`.`pid` AS `pid`, `sline_member_order`.`haschild` AS `haschild`, `sline_member_order`.`remark` AS `remark`, `sline_member_order`.`kindlist` AS `kindlist`, `sline_member_order`.`roombalance` AS `roombalance`, `sline_member_order`.`roombalancenum` AS `roombalancenum`, `sline_member_order`.`viewstatus` AS `viewstatus`, `sline_member_order`.`roombalance_paytype` AS `roombalance_paytype`, `sline_member_order`.`paysource` AS `paysource`, `sline_member_order`.`departdate` AS `departdate`, `sline_member_order`.`eticketno` AS `eticketno`, `sline_member_order`.`isconsume` AS `isconsume`, `sline_member_order`.`consumetime` AS `consumetime`, `sline_member_order`.`consumeverifyuser` AS `consumeverifyuser`, `sline_member_order`.`consumeverifymemo` AS `consumeverifymemo`, `sline_member_order`.`distributororderexdata` AS `distributororderexdata` FROM `sline_member_order` AS `sline_member_order` WHERE  find_in_set('0',distributorlist)  id='5359' ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 D:\web\v5\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `sline_m...', 'Model_Member_Or...', Array)
#1 D:\web\v5\core\modules\orm\classes\kohana\orm.php(1188): Kohana_Database_Query->execute(Object(Database_MySQL))
#2 D:\web\v5\core\modules\orm\classes\kohana\orm.php(1043): Kohana_ORM->_load_result(true)
#3 D:\web\v5\core\modules\orm\classes\kohana\orm.php(1054): Kohana_ORM->find_all()
#4 D:\web\v5\plugins\distributor_hotel\application\classes\model\member\order.php(212): Kohana_ORM->get_all()
#5 D:\web\v5\plugins\distributor_hotel\application\classes\controller\order.php(52): Model_Member_Order->get_order_info(5359)
#6 [internal function]: Controller_Order->action_show()
#7 D:\web\v5\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Order))
#8 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#9 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#10 D:\web\v5\plugins\distributor_hotel\index.php(131): Kohana_Request->execute()
#11 {main}
2016-03-08 18:50:20 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2016-03-08 18:50:20 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/up-ico.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\distributor_hotel\index.php(131): Kohana_Request->execute()
#3 {main}