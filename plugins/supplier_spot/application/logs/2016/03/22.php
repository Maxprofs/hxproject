<?php defined('SYSPATH') OR die('No direct script access.'); ?>

2016-03-22 10:26:49 --- ERROR: ErrorException [ 1 ]: Call to undefined method Common::getExtendContent() ~ APPPATH\cache\tplcache\default\edit.php [ 225 ]
2016-03-22 10:26:49 --- STRACE: ErrorException [ 1 ]: Call to undefined method Common::getExtendContent() ~ APPPATH\cache\tplcache\default\edit.php [ 225 ]
--
#0 [internal function]: Kohana_Core::shutdown_handler()
#1 {main}
2016-03-22 11:03:24 --- ERROR: Kohana_Exception [ 0 ]: Cannot update spot model because it is not loaded. ~ MODPATH\orm\classes\kohana\orm.php [ 1486 ]
2016-03-22 11:03:24 --- STRACE: Kohana_Exception [ 0 ]: Cannot update spot model because it is not loaded. ~ MODPATH\orm\classes\kohana\orm.php [ 1486 ]
--
#0 D:\web\v5\plugins\supplier_spot\application\classes\controller\index.php(179): Kohana_ORM->update()
#1 [internal function]: Controller_Index->action_ajax_save()
#2 D:\web\v5\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Index))
#3 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#4 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#5 D:\web\v5\plugins\supplier_spot\index.php(131): Kohana_Request->execute()
#6 {main}
2016-03-22 11:42:33 --- ERROR: Kohana_Exception [ 0 ]: Cannot update spot model because it is not loaded. ~ MODPATH\orm\classes\kohana\orm.php [ 1486 ]
2016-03-22 11:42:33 --- STRACE: Kohana_Exception [ 0 ]: Cannot update spot model because it is not loaded. ~ MODPATH\orm\classes\kohana\orm.php [ 1486 ]
--
#0 D:\web\v5\plugins\supplier_spot\application\classes\controller\index.php(179): Kohana_ORM->update()
#1 [internal function]: Controller_Index->action_ajax_save()
#2 D:\web\v5\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Index))
#3 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#4 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#5 D:\web\v5\plugins\supplier_spot\index.php(131): Kohana_Request->execute()
#6 {main}
2016-03-22 11:42:40 --- ERROR: Kohana_Exception [ 0 ]: Cannot update spot model because it is not loaded. ~ MODPATH\orm\classes\kohana\orm.php [ 1486 ]
2016-03-22 11:42:40 --- STRACE: Kohana_Exception [ 0 ]: Cannot update spot model because it is not loaded. ~ MODPATH\orm\classes\kohana\orm.php [ 1486 ]
--
#0 D:\web\v5\plugins\supplier_spot\application\classes\controller\index.php(179): Kohana_ORM->update()
#1 [internal function]: Controller_Index->action_ajax_save()
#2 D:\web\v5\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Index))
#3 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#4 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#5 D:\web\v5\plugins\supplier_spot\index.php(131): Kohana_Request->execute()
#6 {main}
2016-03-22 11:44:20 --- ERROR: Kohana_Exception [ 0 ]: Cannot update spot model because it is not loaded. ~ MODPATH\orm\classes\kohana\orm.php [ 1486 ]
2016-03-22 11:44:20 --- STRACE: Kohana_Exception [ 0 ]: Cannot update spot model because it is not loaded. ~ MODPATH\orm\classes\kohana\orm.php [ 1486 ]
--
#0 D:\web\v5\plugins\supplier_spot\application\classes\controller\index.php(179): Kohana_ORM->update()
#1 [internal function]: Controller_Index->action_ajax_save()
#2 D:\web\v5\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Index))
#3 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#4 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#5 D:\web\v5\plugins\supplier_spot\index.php(131): Kohana_Request->execute()
#6 {main}
2016-03-22 11:46:33 --- ERROR: Database_Exception [ 1054 ]: Unknown column 'productid' in 'where clause' [ SELECT * FROM `sline_spot_ticket` WHERE productid='1909' ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2016-03-22 11:46:33 --- STRACE: Database_Exception [ 1054 ]: Unknown column 'productid' in 'where clause' [ SELECT * FROM `sline_spot_ticket` WHERE productid='1909' ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 D:\web\v5\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'SELECT * FROM `...', false, Array)
#1 D:\web\v5\plugins\supplier_spot\application\classes\model\spot.php(145): Kohana_Database_Query->execute()
#2 D:\web\v5\plugins\supplier_spot\application\classes\model\spot.php(105): Model_Spot::get_spot_suit('1909')
#3 D:\web\v5\plugins\supplier_spot\application\classes\model\spot.php(38): Model_Spot::format_data(Array)
#4 D:\web\v5\plugins\supplier_spot\application\classes\controller\index.php(212): Model_Spot::spot_list(30, '')
#5 [internal function]: Controller_Index->action_list()
#6 D:\web\v5\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Index))
#7 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#8 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#9 D:\web\v5\plugins\supplier_spot\index.php(131): Kohana_Request->execute()
#10 {main}
2016-03-22 11:48:52 --- ERROR: Kohana_Exception [ 0 ]: Cannot update spot model because it is not loaded. ~ MODPATH\orm\classes\kohana\orm.php [ 1486 ]
2016-03-22 11:48:52 --- STRACE: Kohana_Exception [ 0 ]: Cannot update spot model because it is not loaded. ~ MODPATH\orm\classes\kohana\orm.php [ 1486 ]
--
#0 D:\web\v5\plugins\supplier_spot\application\classes\controller\index.php(180): Kohana_ORM->update()
#1 [internal function]: Controller_Index->action_ajax_save()
#2 D:\web\v5\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Index))
#3 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#4 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#5 D:\web\v5\plugins\supplier_spot\index.php(131): Kohana_Request->execute()
#6 {main}
2016-03-22 11:49:01 --- ERROR: Kohana_Exception [ 0 ]: Cannot update spot model because it is not loaded. ~ MODPATH\orm\classes\kohana\orm.php [ 1486 ]
2016-03-22 11:49:01 --- STRACE: Kohana_Exception [ 0 ]: Cannot update spot model because it is not loaded. ~ MODPATH\orm\classes\kohana\orm.php [ 1486 ]
--
#0 D:\web\v5\plugins\supplier_spot\application\classes\controller\index.php(180): Kohana_ORM->update()
#1 [internal function]: Controller_Index->action_ajax_save()
#2 D:\web\v5\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Index))
#3 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#4 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#5 D:\web\v5\plugins\supplier_spot\index.php(131): Kohana_Request->execute()
#6 {main}
2016-03-22 11:53:12 --- ERROR: Kohana_Exception [ 0 ]: Cannot update spot model because it is not loaded. ~ MODPATH\orm\classes\kohana\orm.php [ 1486 ]
2016-03-22 11:53:12 --- STRACE: Kohana_Exception [ 0 ]: Cannot update spot model because it is not loaded. ~ MODPATH\orm\classes\kohana\orm.php [ 1486 ]
--
#0 D:\web\v5\plugins\supplier_spot\application\classes\controller\index.php(180): Kohana_ORM->update()
#1 [internal function]: Controller_Index->action_ajax_save()
#2 D:\web\v5\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Index))
#3 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#4 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#5 D:\web\v5\plugins\supplier_spot\index.php(131): Kohana_Request->execute()
#6 {main}
2016-03-22 11:55:59 --- ERROR: Database_Exception [ 1054 ]: Unknown column 'e_content_1' in 'field list' [ INSERT INTO `sline_spot_extend_field` (`productid`, `e_content_1`) VALUES ('1909', '自定义') ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2016-03-22 11:55:59 --- STRACE: Database_Exception [ 1054 ]: Unknown column 'e_content_1' in 'field list' [ INSERT INTO `sline_spot_extend_field` (`productid`, `e_content_1`) VALUES ('1909', '自定义') ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 D:\web\v5\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(2, 'INSERT INTO `sl...', false, Array)
#1 D:\web\v5\tools\common\functions.php(594): Kohana_Database_Query->execute()
#2 D:\web\v5\plugins\supplier_spot\application\classes\controller\index.php(196): Functions::save_extend_data(5, '1909', Array)
#3 [internal function]: Controller_Index->action_ajax_save()
#4 D:\web\v5\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Index))
#5 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#7 D:\web\v5\plugins\supplier_spot\index.php(131): Kohana_Request->execute()
#8 {main}
2016-03-22 11:56:10 --- ERROR: Database_Exception [ 1054 ]: Unknown column 'e_content_1' in 'field list' [ INSERT INTO `sline_spot_extend_field` (`productid`, `e_content_1`) VALUES ('1909', '自定义') ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2016-03-22 11:56:10 --- STRACE: Database_Exception [ 1054 ]: Unknown column 'e_content_1' in 'field list' [ INSERT INTO `sline_spot_extend_field` (`productid`, `e_content_1`) VALUES ('1909', '自定义') ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 D:\web\v5\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(2, 'INSERT INTO `sl...', false, Array)
#1 D:\web\v5\tools\common\functions.php(594): Kohana_Database_Query->execute()
#2 D:\web\v5\plugins\supplier_spot\application\classes\controller\index.php(196): Functions::save_extend_data(5, '1909', Array)
#3 [internal function]: Controller_Index->action_ajax_save()
#4 D:\web\v5\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Index))
#5 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#7 D:\web\v5\plugins\supplier_spot\index.php(131): Kohana_Request->execute()
#8 {main}
2016-03-22 11:58:11 --- ERROR: Database_Exception [ 1054 ]: Unknown column 'e_test' in 'field list' [ INSERT INTO `sline_spot_extend_field` (`productid`, `e_test`) VALUES ('1909', '') ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2016-03-22 11:58:11 --- STRACE: Database_Exception [ 1054 ]: Unknown column 'e_test' in 'field list' [ INSERT INTO `sline_spot_extend_field` (`productid`, `e_test`) VALUES ('1909', '') ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 D:\web\v5\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(2, 'INSERT INTO `sl...', false, Array)
#1 D:\web\v5\tools\common\functions.php(594): Kohana_Database_Query->execute()
#2 D:\web\v5\plugins\supplier_spot\application\classes\controller\index.php(196): Functions::save_extend_data(5, '1909', Array)
#3 [internal function]: Controller_Index->action_ajax_save()
#4 D:\web\v5\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Index))
#5 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#7 D:\web\v5\plugins\supplier_spot\index.php(131): Kohana_Request->execute()
#8 {main}
2016-03-22 14:53:20 --- ERROR: ErrorException [ 1 ]: Call to undefined method Model_Spot::updateMinPrice() ~ APPPATH\classes\controller\index.php [ 341 ]
2016-03-22 14:53:20 --- STRACE: ErrorException [ 1 ]: Call to undefined method Model_Spot::updateMinPrice() ~ APPPATH\classes\controller\index.php [ 341 ]
--
#0 [internal function]: Kohana_Core::shutdown_handler()
#1 {main}
2016-03-22 15:02:18 --- ERROR: Database_Exception [ 1054 ]: Unknown column 'suitid' in 'where clause' [ SELECT MIN(ourprice) AS price  FROM `sline_spot_ticket` WHERE spotid='1909'  AND suitid=20  AND day>1458630138 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2016-03-22 15:02:18 --- STRACE: Database_Exception [ 1054 ]: Unknown column 'suitid' in 'where clause' [ SELECT MIN(ourprice) AS price  FROM `sline_spot_ticket` WHERE spotid='1909'  AND suitid=20  AND day>1458630138 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 D:\web\v5\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'SELECT MIN(ourp...', false, Array)
#1 D:\web\v5\plugins\supplier_spot\application\classes\model\spot.php(133): Kohana_Database_Query->execute()
#2 D:\web\v5\plugins\supplier_spot\application\classes\model\spot.php(148): Model_Spot::get_min_data('1909', '20')
#3 D:\web\v5\plugins\supplier_spot\application\classes\model\spot.php(105): Model_Spot::get_spot_suit('1909')
#4 D:\web\v5\plugins\supplier_spot\application\classes\model\spot.php(38): Model_Spot::format_data(Array)
#5 D:\web\v5\plugins\supplier_spot\application\classes\controller\index.php(212): Model_Spot::spot_list(30, '')
#6 [internal function]: Controller_Index->action_list()
#7 D:\web\v5\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Index))
#8 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#9 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#10 D:\web\v5\plugins\supplier_spot\index.php(131): Kohana_Request->execute()
#11 {main}
2016-03-22 15:04:00 --- ERROR: Database_Exception [ 1054 ]: Unknown column 'suitid' in 'where clause' [ SELECT `sline_spot_ticket_type`.`id` AS `id`, `sline_spot_ticket_type`.`kindname` AS `kindname`, `sline_spot_ticket_type`.`spotid` AS `spotid`, `sline_spot_ticket_type`.`description` AS `description`, `sline_spot_ticket_type`.`displayorder` AS `displayorder` FROM `sline_spot_ticket_type` AS `sline_spot_ticket_type` WHERE suitid=1909 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2016-03-22 15:04:00 --- STRACE: Database_Exception [ 1054 ]: Unknown column 'suitid' in 'where clause' [ SELECT `sline_spot_ticket_type`.`id` AS `id`, `sline_spot_ticket_type`.`kindname` AS `kindname`, `sline_spot_ticket_type`.`spotid` AS `spotid`, `sline_spot_ticket_type`.`description` AS `description`, `sline_spot_ticket_type`.`displayorder` AS `displayorder` FROM `sline_spot_ticket_type` AS `sline_spot_ticket_type` WHERE suitid=1909 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 D:\web\v5\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `sline_s...', 'Model_Spot_Tick...', Array)
#1 D:\web\v5\core\modules\orm\classes\kohana\orm.php(1188): Kohana_Database_Query->execute(Object(Database_MySQL))
#2 D:\web\v5\core\modules\orm\classes\kohana\orm.php(1043): Kohana_ORM->_load_result(true)
#3 D:\web\v5\core\modules\orm\classes\kohana\orm.php(1054): Kohana_ORM->find_all()
#4 D:\web\v5\plugins\supplier_spot\application\classes\controller\index.php(262): Kohana_ORM->get_all()
#5 [internal function]: Controller_Index->action_suit_edit()
#6 D:\web\v5\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Index))
#7 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#8 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#9 D:\web\v5\plugins\supplier_spot\index.php(131): Kohana_Request->execute()
#10 {main}
2016-03-22 15:17:43 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2016-03-22 15:17:43 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL order/default/pc/images/not-img.jpg was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 D:\web\v5\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 D:\web\v5\core\system\classes\kohana\request.php(1160): Kohana_Request_Client->execute(Object(Request))
#2 D:\web\v5\plugins\supplier_spot\index.php(131): Kohana_Request->execute()
#3 {main}