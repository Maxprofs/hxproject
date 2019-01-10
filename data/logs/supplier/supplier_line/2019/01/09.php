<?php defined('SYSPATH') OR die('No direct script access.'); ?>

2019-01-09 02:21:59 --- ERROR: Database_Exception [ 1054 ]: Unknown column 'Array' in 'where clause' [ SELECT * FROM sline_startplace WHERE isopen=1 and find_in_set(Array,supplierids) AND pid=1 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-09 02:21:59 --- STRACE: Database_Exception [ 1054 ]: Unknown column 'Array' in 'where clause' [ SELECT * FROM sline_startplace WHERE isopen=1 and find_in_set(Array,supplierids) AND pid=1 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'SELECT * FROM s...', false, Array)
#1 E:\wamp64\www\plugins\supplier_line\application\classes\controller\index.php(943): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Index->action_ajax_get_start_place()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Index))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\plugins\supplier_line\index.php(135): Kohana_Request->execute()
#7 {main}
2019-01-09 02:22:02 --- ERROR: Database_Exception [ 1054 ]: Unknown column 'Array' in 'where clause' [ SELECT * FROM sline_startplace WHERE isopen=1 and find_in_set(Array,supplierids) AND pid=84 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-09 02:22:02 --- STRACE: Database_Exception [ 1054 ]: Unknown column 'Array' in 'where clause' [ SELECT * FROM sline_startplace WHERE isopen=1 and find_in_set(Array,supplierids) AND pid=84 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'SELECT * FROM s...', false, Array)
#1 E:\wamp64\www\plugins\supplier_line\application\classes\controller\index.php(943): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Index->action_ajax_get_start_place()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Index))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\plugins\supplier_line\index.php(135): Kohana_Request->execute()
#7 {main}
2019-01-09 02:22:03 --- ERROR: Database_Exception [ 1054 ]: Unknown column 'Array' in 'where clause' [ SELECT * FROM sline_startplace WHERE isopen=1 and find_in_set(Array,supplierids) AND pid=115 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-09 02:22:03 --- STRACE: Database_Exception [ 1054 ]: Unknown column 'Array' in 'where clause' [ SELECT * FROM sline_startplace WHERE isopen=1 and find_in_set(Array,supplierids) AND pid=115 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'SELECT * FROM s...', false, Array)
#1 E:\wamp64\www\plugins\supplier_line\application\classes\controller\index.php(943): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Index->action_ajax_get_start_place()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Index))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\plugins\supplier_line\index.php(135): Kohana_Request->execute()
#7 {main}
2019-01-09 02:22:03 --- ERROR: Database_Exception [ 1054 ]: Unknown column 'Array' in 'where clause' [ SELECT * FROM sline_startplace WHERE isopen=1 and find_in_set(Array,supplierids) AND pid=115 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-09 02:22:03 --- STRACE: Database_Exception [ 1054 ]: Unknown column 'Array' in 'where clause' [ SELECT * FROM sline_startplace WHERE isopen=1 and find_in_set(Array,supplierids) AND pid=115 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'SELECT * FROM s...', false, Array)
#1 E:\wamp64\www\plugins\supplier_line\application\classes\controller\index.php(943): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Index->action_ajax_get_start_place()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Index))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\plugins\supplier_line\index.php(135): Kohana_Request->execute()
#7 {main}
2019-01-09 02:22:04 --- ERROR: Database_Exception [ 1054 ]: Unknown column 'Array' in 'where clause' [ SELECT * FROM sline_startplace WHERE isopen=1 and find_in_set(Array,supplierids) AND pid=162 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-09 02:22:04 --- STRACE: Database_Exception [ 1054 ]: Unknown column 'Array' in 'where clause' [ SELECT * FROM sline_startplace WHERE isopen=1 and find_in_set(Array,supplierids) AND pid=162 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'SELECT * FROM s...', false, Array)
#1 E:\wamp64\www\plugins\supplier_line\application\classes\controller\index.php(943): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Index->action_ajax_get_start_place()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Index))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\plugins\supplier_line\index.php(135): Kohana_Request->execute()
#7 {main}
2019-01-09 02:22:06 --- ERROR: Database_Exception [ 1054 ]: Unknown column 'Array' in 'where clause' [ SELECT * FROM sline_startplace WHERE isopen=1 and find_in_set(Array,supplierids) AND pid=1 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-09 02:22:06 --- STRACE: Database_Exception [ 1054 ]: Unknown column 'Array' in 'where clause' [ SELECT * FROM sline_startplace WHERE isopen=1 and find_in_set(Array,supplierids) AND pid=1 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'SELECT * FROM s...', false, Array)
#1 E:\wamp64\www\plugins\supplier_line\application\classes\controller\index.php(943): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Index->action_ajax_get_start_place()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Index))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\plugins\supplier_line\index.php(135): Kohana_Request->execute()
#7 {main}
2019-01-09 02:31:20 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ SELECT `sline_startplace`.`id` AS `id`, `sline_startplace`.`destid` AS `destid`, `sline_startplace`.`cityname` AS `cityname`, `sline_startplace`.`isdefault` AS `isdefault`, `sline_startplace`.`isopen` AS `isopen`, `sline_startplace`.`displayorder` AS `displayorder`, `sline_startplace`.`domain` AS `domain`, `sline_startplace`.`pid` AS `pid`, `sline_startplace`.`supplierids` AS `supplierids` FROM `sline_startplace` AS `sline_startplace` WHERE pid!=0 AND `isopen` = 1find_in_set(1,supplierids ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-09 02:31:20 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ SELECT `sline_startplace`.`id` AS `id`, `sline_startplace`.`destid` AS `destid`, `sline_startplace`.`cityname` AS `cityname`, `sline_startplace`.`isdefault` AS `isdefault`, `sline_startplace`.`isopen` AS `isopen`, `sline_startplace`.`displayorder` AS `displayorder`, `sline_startplace`.`domain` AS `domain`, `sline_startplace`.`pid` AS `pid`, `sline_startplace`.`supplierids` AS `supplierids` FROM `sline_startplace` AS `sline_startplace` WHERE pid!=0 AND `isopen` = 1find_in_set(1,supplierids ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `sline_s...', 'Model_Startplac...', Array)
#1 E:\wamp64\www\core\modules\orm\classes\kohana\orm.php(1188): Kohana_Database_Query->execute(Object(Database_MySQL))
#2 E:\wamp64\www\core\modules\orm\classes\kohana\orm.php(1043): Kohana_ORM->_load_result(true)
#3 E:\wamp64\www\core\modules\orm\classes\kohana\orm.php(1054): Kohana_ORM->find_all()
#4 E:\wamp64\www\plugins\supplier_line\application\classes\controller\index.php(331): Kohana_ORM->get_all()
#5 [internal function]: Controller_Index->action_add()
#6 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Index))
#7 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#8 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#9 E:\wamp64\www\plugins\supplier_line\index.php(135): Kohana_Request->execute()
#10 {main}
2019-01-09 02:32:29 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ SELECT `sline_startplace`.`id` AS `id`, `sline_startplace`.`destid` AS `destid`, `sline_startplace`.`cityname` AS `cityname`, `sline_startplace`.`isdefault` AS `isdefault`, `sline_startplace`.`isopen` AS `isopen`, `sline_startplace`.`displayorder` AS `displayorder`, `sline_startplace`.`domain` AS `domain`, `sline_startplace`.`pid` AS `pid`, `sline_startplace`.`supplierids` AS `supplierids` FROM `sline_startplace` AS `sline_startplace` WHERE pid!=0 AND `isopen` = 1 and find_in_set(1,supplierids ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-09 02:32:29 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ SELECT `sline_startplace`.`id` AS `id`, `sline_startplace`.`destid` AS `destid`, `sline_startplace`.`cityname` AS `cityname`, `sline_startplace`.`isdefault` AS `isdefault`, `sline_startplace`.`isopen` AS `isopen`, `sline_startplace`.`displayorder` AS `displayorder`, `sline_startplace`.`domain` AS `domain`, `sline_startplace`.`pid` AS `pid`, `sline_startplace`.`supplierids` AS `supplierids` FROM `sline_startplace` AS `sline_startplace` WHERE pid!=0 AND `isopen` = 1 and find_in_set(1,supplierids ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `sline_s...', 'Model_Startplac...', Array)
#1 E:\wamp64\www\core\modules\orm\classes\kohana\orm.php(1188): Kohana_Database_Query->execute(Object(Database_MySQL))
#2 E:\wamp64\www\core\modules\orm\classes\kohana\orm.php(1043): Kohana_ORM->_load_result(true)
#3 E:\wamp64\www\core\modules\orm\classes\kohana\orm.php(1054): Kohana_ORM->find_all()
#4 E:\wamp64\www\plugins\supplier_line\application\classes\controller\index.php(331): Kohana_ORM->get_all()
#5 [internal function]: Controller_Index->action_add()
#6 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Index))
#7 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#8 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#9 E:\wamp64\www\plugins\supplier_line\index.php(135): Kohana_Request->execute()
#10 {main}
2019-01-09 12:26:08 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'SELECT * FROM sline_startplace WHERE pid=0 and isopen=1 and id IN (SELECT pid FR' at line 1 [ SELECT * FROM `sline_startplace` WHERE SELECT * FROM sline_startplace WHERE pid=0 and isopen=1 and id IN (SELECT pid FROM sline_startplace where pid!=0 and isopen=1 AND find_in_set(1,supplierids)) ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-09 12:26:08 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'SELECT * FROM sline_startplace WHERE pid=0 and isopen=1 and id IN (SELECT pid FR' at line 1 [ SELECT * FROM `sline_startplace` WHERE SELECT * FROM sline_startplace WHERE pid=0 and isopen=1 and id IN (SELECT pid FROM sline_startplace where pid!=0 and isopen=1 AND find_in_set(1,supplierids)) ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'SELECT * FROM `...', false, Array)
#1 E:\wamp64\www\plugins\supplier_line\application\classes\controller\index.php(918): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Index->action_dialog_setstartplace()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Index))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\plugins\supplier_line\index.php(135): Kohana_Request->execute()
#7 {main}
2019-01-09 12:29:21 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'SELECT * FROM sline_startplace WHERE pid=0 and isopen=1 and id IN (SELECT pid FR' at line 1 [ SELECT * FROM `sline_startplace` WHERE SELECT * FROM sline_startplace WHERE pid=0 and isopen=1 and id IN (SELECT pid FROM sline_startplace where pid!=0 and isopen=1 AND find_in_set(1,supplierids)) ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-09 12:29:21 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'SELECT * FROM sline_startplace WHERE pid=0 and isopen=1 and id IN (SELECT pid FR' at line 1 [ SELECT * FROM `sline_startplace` WHERE SELECT * FROM sline_startplace WHERE pid=0 and isopen=1 and id IN (SELECT pid FROM sline_startplace where pid!=0 and isopen=1 AND find_in_set(1,supplierids)) ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'SELECT * FROM `...', false, Array)
#1 E:\wamp64\www\plugins\supplier_line\application\classes\controller\index.php(918): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Index->action_dialog_setstartplace()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Index))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\plugins\supplier_line\index.php(135): Kohana_Request->execute()
#7 {main}
2019-01-09 12:36:05 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'WHERE pid=0 and isopen=1 and id IN (SELECT pid FROM sline_startplace where pid!=' at line 1 [ SELECT * FROM `sline_startplace` WHERE WHERE pid=0 and isopen=1 and id IN (SELECT pid FROM sline_startplace where pid!=0 and isopen=1 AND find_in_set(1,supplierids)) ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-09 12:36:05 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'WHERE pid=0 and isopen=1 and id IN (SELECT pid FROM sline_startplace where pid!=' at line 1 [ SELECT * FROM `sline_startplace` WHERE WHERE pid=0 and isopen=1 and id IN (SELECT pid FROM sline_startplace where pid!=0 and isopen=1 AND find_in_set(1,supplierids)) ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'SELECT * FROM `...', false, Array)
#1 E:\wamp64\www\plugins\supplier_line\application\classes\controller\index.php(918): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Index->action_dialog_setstartplace()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Index))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\plugins\supplier_line\index.php(135): Kohana_Request->execute()
#7 {main}
2019-01-09 12:57:12 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'supplierids) and find_in_set(1,opentypeids)  order by pinyin asc' at line 1 [ select id,kindname,pinyin from sline_destinations where pid=0 and isopen=1 and find_in_set(,supplierids) and find_in_set(1,opentypeids)  order by pinyin asc ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-09 12:57:12 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'supplierids) and find_in_set(1,opentypeids)  order by pinyin asc' at line 1 [ select id,kindname,pinyin from sline_destinations where pid=0 and isopen=1 and find_in_set(,supplierids) and find_in_set(1,opentypeids)  order by pinyin asc ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select id,kindn...', false, Array)
#1 E:\wamp64\www\plugins\supplier_line\application\classes\controller\destination.php(45): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Destination->action_ajax_getDestsetList()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Destination))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\plugins\supplier_line\index.php(135): Kohana_Request->execute()
#7 {main}
2019-01-09 12:58:00 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'supplierids) and find_in_set(1,opentypeids)  order by pinyin asc' at line 1 [ select id,kindname,pinyin from sline_destinations where pid=0 and isopen=1 and find_in_set(,supplierids) and find_in_set(1,opentypeids)  order by pinyin asc ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-09 12:58:00 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'supplierids) and find_in_set(1,opentypeids)  order by pinyin asc' at line 1 [ select id,kindname,pinyin from sline_destinations where pid=0 and isopen=1 and find_in_set(,supplierids) and find_in_set(1,opentypeids)  order by pinyin asc ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select id,kindn...', false, Array)
#1 E:\wamp64\www\plugins\supplier_line\application\classes\controller\destination.php(45): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Destination->action_ajax_getDestsetList()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Destination))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\plugins\supplier_line\index.php(135): Kohana_Request->execute()
#7 {main}
2019-01-09 12:58:40 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'supplierids) and find_in_set(1,opentypeids)  order by pinyin asc' at line 1 [ select id,kindname,pinyin from sline_destinations where pid=0 and isopen=1 and find_in_set(,supplierids) and find_in_set(1,opentypeids)  order by pinyin asc ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-01-09 12:58:40 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'supplierids) and find_in_set(1,opentypeids)  order by pinyin asc' at line 1 [ select id,kindname,pinyin from sline_destinations where pid=0 and isopen=1 and find_in_set(,supplierids) and find_in_set(1,opentypeids)  order by pinyin asc ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'select id,kindn...', false, Array)
#1 E:\wamp64\www\plugins\supplier_line\application\classes\controller\destination.php(48): Kohana_Database_Query->execute()
#2 [internal function]: Controller_Destination->action_ajax_getDestsetList()
#3 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Destination))
#4 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#5 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#6 E:\wamp64\www\plugins\supplier_line\index.php(135): Kohana_Request->execute()
#7 {main}