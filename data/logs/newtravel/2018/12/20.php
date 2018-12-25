<?php defined('SYSPATH') OR die('No direct script access.'); ?>

2018-12-20 14:09:16 --- ERROR: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2018-12-20 14:09:16 --- STRACE: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `mid`, `...', false, Array)
#1 E:\wamp64\www\plugins\distributor\classes\model\distributor.php(92): Kohana_Database_Query->execute()
#2 E:\wamp64\www\plugins\distributor\classes\controller\admin\distributor.php(62): Model_Distributor::distributor_list('', '', 'NaN', '10')
#3 [internal function]: Controller_Admin_Distributor->action_pageload()
#4 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Admin_Distributor))
#5 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#7 E:\wamp64\www\newtravel\index.php(122): Kohana_Request->execute()
#8 {main}
2018-12-20 14:09:18 --- ERROR: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2018-12-20 14:09:18 --- STRACE: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `mid`, `...', false, Array)
#1 E:\wamp64\www\plugins\distributor\classes\model\distributor.php(92): Kohana_Database_Query->execute()
#2 E:\wamp64\www\plugins\distributor\classes\controller\admin\distributor.php(62): Model_Distributor::distributor_list('', '', 'NaN', '10')
#3 [internal function]: Controller_Admin_Distributor->action_pageload()
#4 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Admin_Distributor))
#5 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#7 E:\wamp64\www\newtravel\index.php(122): Kohana_Request->execute()
#8 {main}
2018-12-20 14:09:20 --- ERROR: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2018-12-20 14:09:20 --- STRACE: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `mid`, `...', false, Array)
#1 E:\wamp64\www\plugins\distributor\classes\model\distributor.php(92): Kohana_Database_Query->execute()
#2 E:\wamp64\www\plugins\distributor\classes\controller\admin\distributor.php(62): Model_Distributor::distributor_list('', '', 'NaN', '10')
#3 [internal function]: Controller_Admin_Distributor->action_pageload()
#4 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Admin_Distributor))
#5 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#7 E:\wamp64\www\newtravel\index.php(122): Kohana_Request->execute()
#8 {main}
2018-12-20 14:09:22 --- ERROR: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2018-12-20 14:09:22 --- STRACE: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `mid`, `...', false, Array)
#1 E:\wamp64\www\plugins\distributor\classes\model\distributor.php(92): Kohana_Database_Query->execute()
#2 E:\wamp64\www\plugins\distributor\classes\controller\admin\distributor.php(62): Model_Distributor::distributor_list('', '', 'NaN', '10')
#3 [internal function]: Controller_Admin_Distributor->action_pageload()
#4 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Admin_Distributor))
#5 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#7 E:\wamp64\www\newtravel\index.php(122): Kohana_Request->execute()
#8 {main}
2018-12-20 14:09:24 --- ERROR: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2018-12-20 14:09:24 --- STRACE: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `mid`, `...', false, Array)
#1 E:\wamp64\www\plugins\distributor\classes\model\distributor.php(92): Kohana_Database_Query->execute()
#2 E:\wamp64\www\plugins\distributor\classes\controller\admin\distributor.php(62): Model_Distributor::distributor_list('', '', 'NaN', '10')
#3 [internal function]: Controller_Admin_Distributor->action_pageload()
#4 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Admin_Distributor))
#5 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#7 E:\wamp64\www\newtravel\index.php(122): Kohana_Request->execute()
#8 {main}
2018-12-20 14:09:26 --- ERROR: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2018-12-20 14:09:26 --- STRACE: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `mid`, `...', false, Array)
#1 E:\wamp64\www\plugins\distributor\classes\model\distributor.php(92): Kohana_Database_Query->execute()
#2 E:\wamp64\www\plugins\distributor\classes\controller\admin\distributor.php(62): Model_Distributor::distributor_list('', '', 'NaN', '10')
#3 [internal function]: Controller_Admin_Distributor->action_pageload()
#4 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Admin_Distributor))
#5 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#7 E:\wamp64\www\newtravel\index.php(122): Kohana_Request->execute()
#8 {main}
2018-12-20 14:09:28 --- ERROR: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2018-12-20 14:09:28 --- STRACE: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `mid`, `...', false, Array)
#1 E:\wamp64\www\plugins\distributor\classes\model\distributor.php(92): Kohana_Database_Query->execute()
#2 E:\wamp64\www\plugins\distributor\classes\controller\admin\distributor.php(62): Model_Distributor::distributor_list('', '', 'NaN', '10')
#3 [internal function]: Controller_Admin_Distributor->action_pageload()
#4 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Admin_Distributor))
#5 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#7 E:\wamp64\www\newtravel\index.php(122): Kohana_Request->execute()
#8 {main}
2018-12-20 14:09:30 --- ERROR: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2018-12-20 14:09:30 --- STRACE: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `mid`, `...', false, Array)
#1 E:\wamp64\www\plugins\distributor\classes\model\distributor.php(92): Kohana_Database_Query->execute()
#2 E:\wamp64\www\plugins\distributor\classes\controller\admin\distributor.php(62): Model_Distributor::distributor_list('', '', 'NaN', '10')
#3 [internal function]: Controller_Admin_Distributor->action_pageload()
#4 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Admin_Distributor))
#5 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#7 E:\wamp64\www\newtravel\index.php(122): Kohana_Request->execute()
#8 {main}
2018-12-20 14:09:32 --- ERROR: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2018-12-20 14:09:32 --- STRACE: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `mid`, `...', false, Array)
#1 E:\wamp64\www\plugins\distributor\classes\model\distributor.php(92): Kohana_Database_Query->execute()
#2 E:\wamp64\www\plugins\distributor\classes\controller\admin\distributor.php(62): Model_Distributor::distributor_list('', '', 'NaN', '10')
#3 [internal function]: Controller_Admin_Distributor->action_pageload()
#4 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Admin_Distributor))
#5 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#7 E:\wamp64\www\newtravel\index.php(122): Kohana_Request->execute()
#8 {main}
2018-12-20 14:09:34 --- ERROR: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2018-12-20 14:09:34 --- STRACE: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `mid`, `...', false, Array)
#1 E:\wamp64\www\plugins\distributor\classes\model\distributor.php(92): Kohana_Database_Query->execute()
#2 E:\wamp64\www\plugins\distributor\classes\controller\admin\distributor.php(62): Model_Distributor::distributor_list('', '', 'NaN', '10')
#3 [internal function]: Controller_Admin_Distributor->action_pageload()
#4 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Admin_Distributor))
#5 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#7 E:\wamp64\www\newtravel\index.php(122): Kohana_Request->execute()
#8 {main}
2018-12-20 14:09:37 --- ERROR: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2018-12-20 14:09:37 --- STRACE: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `mid`, `...', false, Array)
#1 E:\wamp64\www\plugins\distributor\classes\model\distributor.php(92): Kohana_Database_Query->execute()
#2 E:\wamp64\www\plugins\distributor\classes\controller\admin\distributor.php(62): Model_Distributor::distributor_list('', '', 'NaN', '10')
#3 [internal function]: Controller_Admin_Distributor->action_pageload()
#4 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Admin_Distributor))
#5 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#7 E:\wamp64\www\newtravel\index.php(122): Kohana_Request->execute()
#8 {main}
2018-12-20 14:09:39 --- ERROR: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2018-12-20 14:09:39 --- STRACE: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `mid`, `...', false, Array)
#1 E:\wamp64\www\plugins\distributor\classes\model\distributor.php(92): Kohana_Database_Query->execute()
#2 E:\wamp64\www\plugins\distributor\classes\controller\admin\distributor.php(62): Model_Distributor::distributor_list('', '', 'NaN', '10')
#3 [internal function]: Controller_Admin_Distributor->action_pageload()
#4 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Admin_Distributor))
#5 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#7 E:\wamp64\www\newtravel\index.php(122): Kohana_Request->execute()
#8 {main}
2018-12-20 14:09:41 --- ERROR: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2018-12-20 14:09:41 --- STRACE: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `mid`, `...', false, Array)
#1 E:\wamp64\www\plugins\distributor\classes\model\distributor.php(92): Kohana_Database_Query->execute()
#2 E:\wamp64\www\plugins\distributor\classes\controller\admin\distributor.php(62): Model_Distributor::distributor_list('', '', 'NaN', '10')
#3 [internal function]: Controller_Admin_Distributor->action_pageload()
#4 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Admin_Distributor))
#5 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#7 E:\wamp64\www\newtravel\index.php(122): Kohana_Request->execute()
#8 {main}
2018-12-20 14:09:43 --- ERROR: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2018-12-20 14:09:43 --- STRACE: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `mid`, `...', false, Array)
#1 E:\wamp64\www\plugins\distributor\classes\model\distributor.php(92): Kohana_Database_Query->execute()
#2 E:\wamp64\www\plugins\distributor\classes\controller\admin\distributor.php(62): Model_Distributor::distributor_list('', '', 'NaN', '10')
#3 [internal function]: Controller_Admin_Distributor->action_pageload()
#4 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Admin_Distributor))
#5 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#7 E:\wamp64\www\newtravel\index.php(122): Kohana_Request->execute()
#8 {main}
2018-12-20 14:09:45 --- ERROR: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2018-12-20 14:09:45 --- STRACE: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `mid`, `...', false, Array)
#1 E:\wamp64\www\plugins\distributor\classes\model\distributor.php(92): Kohana_Database_Query->execute()
#2 E:\wamp64\www\plugins\distributor\classes\controller\admin\distributor.php(62): Model_Distributor::distributor_list('', '', 'NaN', '10')
#3 [internal function]: Controller_Admin_Distributor->action_pageload()
#4 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Admin_Distributor))
#5 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#7 E:\wamp64\www\newtravel\index.php(122): Kohana_Request->execute()
#8 {main}
2018-12-20 14:09:47 --- ERROR: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2018-12-20 14:09:47 --- STRACE: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `mid`, `...', false, Array)
#1 E:\wamp64\www\plugins\distributor\classes\model\distributor.php(92): Kohana_Database_Query->execute()
#2 E:\wamp64\www\plugins\distributor\classes\controller\admin\distributor.php(62): Model_Distributor::distributor_list('', '', 'NaN', '10')
#3 [internal function]: Controller_Admin_Distributor->action_pageload()
#4 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Admin_Distributor))
#5 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#7 E:\wamp64\www\newtravel\index.php(122): Kohana_Request->execute()
#8 {main}
2018-12-20 14:09:49 --- ERROR: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2018-12-20 14:09:49 --- STRACE: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `mid`, `...', false, Array)
#1 E:\wamp64\www\plugins\distributor\classes\model\distributor.php(92): Kohana_Database_Query->execute()
#2 E:\wamp64\www\plugins\distributor\classes\controller\admin\distributor.php(62): Model_Distributor::distributor_list('', '', 'NaN', '10')
#3 [internal function]: Controller_Admin_Distributor->action_pageload()
#4 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Admin_Distributor))
#5 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#7 E:\wamp64\www\newtravel\index.php(122): Kohana_Request->execute()
#8 {main}
2018-12-20 14:09:51 --- ERROR: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2018-12-20 14:09:51 --- STRACE: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `mid`, `...', false, Array)
#1 E:\wamp64\www\plugins\distributor\classes\model\distributor.php(92): Kohana_Database_Query->execute()
#2 E:\wamp64\www\plugins\distributor\classes\controller\admin\distributor.php(62): Model_Distributor::distributor_list('', '', 'NaN', '10')
#3 [internal function]: Controller_Admin_Distributor->action_pageload()
#4 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Admin_Distributor))
#5 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#7 E:\wamp64\www\newtravel\index.php(122): Kohana_Request->execute()
#8 {main}
2018-12-20 14:09:53 --- ERROR: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2018-12-20 14:09:53 --- STRACE: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `mid`, `...', false, Array)
#1 E:\wamp64\www\plugins\distributor\classes\model\distributor.php(92): Kohana_Database_Query->execute()
#2 E:\wamp64\www\plugins\distributor\classes\controller\admin\distributor.php(62): Model_Distributor::distributor_list('', '', 'NaN', '10')
#3 [internal function]: Controller_Admin_Distributor->action_pageload()
#4 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Admin_Distributor))
#5 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#7 E:\wamp64\www\newtravel\index.php(122): Kohana_Request->execute()
#8 {main}
2018-12-20 14:09:55 --- ERROR: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2018-12-20 14:09:55 --- STRACE: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `mid`, `...', false, Array)
#1 E:\wamp64\www\plugins\distributor\classes\model\distributor.php(92): Kohana_Database_Query->execute()
#2 E:\wamp64\www\plugins\distributor\classes\controller\admin\distributor.php(62): Model_Distributor::distributor_list('', '', 'NaN', '10')
#3 [internal function]: Controller_Admin_Distributor->action_pageload()
#4 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Admin_Distributor))
#5 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#7 E:\wamp64\www\newtravel\index.php(122): Kohana_Request->execute()
#8 {main}
2018-12-20 14:09:57 --- ERROR: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2018-12-20 14:09:57 --- STRACE: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `mid`, `...', false, Array)
#1 E:\wamp64\www\plugins\distributor\classes\model\distributor.php(92): Kohana_Database_Query->execute()
#2 E:\wamp64\www\plugins\distributor\classes\controller\admin\distributor.php(62): Model_Distributor::distributor_list('', '', 'NaN', '10')
#3 [internal function]: Controller_Admin_Distributor->action_pageload()
#4 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Admin_Distributor))
#5 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#7 E:\wamp64\www\newtravel\index.php(122): Kohana_Request->execute()
#8 {main}
2018-12-20 14:09:59 --- ERROR: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2018-12-20 14:09:59 --- STRACE: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `mid`, `...', false, Array)
#1 E:\wamp64\www\plugins\distributor\classes\model\distributor.php(92): Kohana_Database_Query->execute()
#2 E:\wamp64\www\plugins\distributor\classes\controller\admin\distributor.php(62): Model_Distributor::distributor_list('', '', 'NaN', '10')
#3 [internal function]: Controller_Admin_Distributor->action_pageload()
#4 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Admin_Distributor))
#5 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#7 E:\wamp64\www\newtravel\index.php(122): Kohana_Request->execute()
#8 {main}
2018-12-20 14:10:01 --- ERROR: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2018-12-20 14:10:01 --- STRACE: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `mid`, `...', false, Array)
#1 E:\wamp64\www\plugins\distributor\classes\model\distributor.php(92): Kohana_Database_Query->execute()
#2 E:\wamp64\www\plugins\distributor\classes\controller\admin\distributor.php(62): Model_Distributor::distributor_list('', '', 'NaN', '10')
#3 [internal function]: Controller_Admin_Distributor->action_pageload()
#4 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Admin_Distributor))
#5 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#7 E:\wamp64\www\newtravel\index.php(122): Kohana_Request->execute()
#8 {main}
2018-12-20 14:10:03 --- ERROR: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2018-12-20 14:10:03 --- STRACE: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `mid`, `...', false, Array)
#1 E:\wamp64\www\plugins\distributor\classes\model\distributor.php(92): Kohana_Database_Query->execute()
#2 E:\wamp64\www\plugins\distributor\classes\controller\admin\distributor.php(62): Model_Distributor::distributor_list('', '', 'NaN', '10')
#3 [internal function]: Controller_Admin_Distributor->action_pageload()
#4 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Admin_Distributor))
#5 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#7 E:\wamp64\www\newtravel\index.php(122): Kohana_Request->execute()
#8 {main}
2018-12-20 14:10:05 --- ERROR: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2018-12-20 14:10:05 --- STRACE: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `mid`, `...', false, Array)
#1 E:\wamp64\www\plugins\distributor\classes\model\distributor.php(92): Kohana_Database_Query->execute()
#2 E:\wamp64\www\plugins\distributor\classes\controller\admin\distributor.php(62): Model_Distributor::distributor_list('', '', 'NaN', '10')
#3 [internal function]: Controller_Admin_Distributor->action_pageload()
#4 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Admin_Distributor))
#5 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#7 E:\wamp64\www\newtravel\index.php(122): Kohana_Request->execute()
#8 {main}
2018-12-20 14:10:07 --- ERROR: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2018-12-20 14:10:07 --- STRACE: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `mid`, `...', false, Array)
#1 E:\wamp64\www\plugins\distributor\classes\model\distributor.php(92): Kohana_Database_Query->execute()
#2 E:\wamp64\www\plugins\distributor\classes\controller\admin\distributor.php(62): Model_Distributor::distributor_list('', '', 'NaN', '10')
#3 [internal function]: Controller_Admin_Distributor->action_pageload()
#4 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Admin_Distributor))
#5 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#7 E:\wamp64\www\newtravel\index.php(122): Kohana_Request->execute()
#8 {main}
2018-12-20 14:10:09 --- ERROR: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2018-12-20 14:10:09 --- STRACE: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `mid`, `...', false, Array)
#1 E:\wamp64\www\plugins\distributor\classes\model\distributor.php(92): Kohana_Database_Query->execute()
#2 E:\wamp64\www\plugins\distributor\classes\controller\admin\distributor.php(62): Model_Distributor::distributor_list('', '', 'NaN', '10')
#3 [internal function]: Controller_Admin_Distributor->action_pageload()
#4 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Admin_Distributor))
#5 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#7 E:\wamp64\www\newtravel\index.php(122): Kohana_Request->execute()
#8 {main}
2018-12-20 14:10:11 --- ERROR: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2018-12-20 14:10:11 --- STRACE: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `mid`, `...', false, Array)
#1 E:\wamp64\www\plugins\distributor\classes\model\distributor.php(92): Kohana_Database_Query->execute()
#2 E:\wamp64\www\plugins\distributor\classes\controller\admin\distributor.php(62): Model_Distributor::distributor_list('', '', 'NaN', '10')
#3 [internal function]: Controller_Admin_Distributor->action_pageload()
#4 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Admin_Distributor))
#5 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#7 E:\wamp64\www\newtravel\index.php(122): Kohana_Request->execute()
#8 {main}
2018-12-20 14:10:13 --- ERROR: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2018-12-20 14:10:13 --- STRACE: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `mid`, `...', false, Array)
#1 E:\wamp64\www\plugins\distributor\classes\model\distributor.php(92): Kohana_Database_Query->execute()
#2 E:\wamp64\www\plugins\distributor\classes\controller\admin\distributor.php(62): Model_Distributor::distributor_list('', '', 'NaN', '10')
#3 [internal function]: Controller_Admin_Distributor->action_pageload()
#4 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Admin_Distributor))
#5 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#7 E:\wamp64\www\newtravel\index.php(122): Kohana_Request->execute()
#8 {main}
2018-12-20 14:10:15 --- ERROR: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2018-12-20 14:10:15 --- STRACE: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `mid`, `...', false, Array)
#1 E:\wamp64\www\plugins\distributor\classes\model\distributor.php(92): Kohana_Database_Query->execute()
#2 E:\wamp64\www\plugins\distributor\classes\controller\admin\distributor.php(62): Model_Distributor::distributor_list('', '', 'NaN', '10')
#3 [internal function]: Controller_Admin_Distributor->action_pageload()
#4 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Admin_Distributor))
#5 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#7 E:\wamp64\www\newtravel\index.php(122): Kohana_Request->execute()
#8 {main}
2018-12-20 14:10:17 --- ERROR: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2018-12-20 14:10:17 --- STRACE: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `mid`, `...', false, Array)
#1 E:\wamp64\www\plugins\distributor\classes\model\distributor.php(92): Kohana_Database_Query->execute()
#2 E:\wamp64\www\plugins\distributor\classes\controller\admin\distributor.php(62): Model_Distributor::distributor_list('', '', 'NaN', '10')
#3 [internal function]: Controller_Admin_Distributor->action_pageload()
#4 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Admin_Distributor))
#5 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#7 E:\wamp64\www\newtravel\index.php(122): Kohana_Request->execute()
#8 {main}
2018-12-20 14:10:19 --- ERROR: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2018-12-20 14:10:19 --- STRACE: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `mid`, `...', false, Array)
#1 E:\wamp64\www\plugins\distributor\classes\model\distributor.php(92): Kohana_Database_Query->execute()
#2 E:\wamp64\www\plugins\distributor\classes\controller\admin\distributor.php(62): Model_Distributor::distributor_list('', '', 'NaN', '10')
#3 [internal function]: Controller_Admin_Distributor->action_pageload()
#4 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Admin_Distributor))
#5 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#7 E:\wamp64\www\newtravel\index.php(122): Kohana_Request->execute()
#8 {main}
2018-12-20 14:10:21 --- ERROR: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2018-12-20 14:10:21 --- STRACE: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `mid`, `...', false, Array)
#1 E:\wamp64\www\plugins\distributor\classes\model\distributor.php(92): Kohana_Database_Query->execute()
#2 E:\wamp64\www\plugins\distributor\classes\controller\admin\distributor.php(62): Model_Distributor::distributor_list('', '', 'NaN', '10')
#3 [internal function]: Controller_Admin_Distributor->action_pageload()
#4 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Admin_Distributor))
#5 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#7 E:\wamp64\www\newtravel\index.php(122): Kohana_Request->execute()
#8 {main}
2018-12-20 14:10:23 --- ERROR: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2018-12-20 14:10:23 --- STRACE: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `mid`, `...', false, Array)
#1 E:\wamp64\www\plugins\distributor\classes\model\distributor.php(92): Kohana_Database_Query->execute()
#2 E:\wamp64\www\plugins\distributor\classes\controller\admin\distributor.php(62): Model_Distributor::distributor_list('', '', 'NaN', '10')
#3 [internal function]: Controller_Admin_Distributor->action_pageload()
#4 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Admin_Distributor))
#5 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#7 E:\wamp64\www\newtravel\index.php(122): Kohana_Request->execute()
#8 {main}
2018-12-20 14:10:25 --- ERROR: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2018-12-20 14:10:25 --- STRACE: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `mid`, `...', false, Array)
#1 E:\wamp64\www\plugins\distributor\classes\model\distributor.php(92): Kohana_Database_Query->execute()
#2 E:\wamp64\www\plugins\distributor\classes\controller\admin\distributor.php(62): Model_Distributor::distributor_list('', '', 'NaN', '10')
#3 [internal function]: Controller_Admin_Distributor->action_pageload()
#4 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Admin_Distributor))
#5 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#7 E:\wamp64\www\newtravel\index.php(122): Kohana_Request->execute()
#8 {main}
2018-12-20 14:10:27 --- ERROR: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2018-12-20 14:10:27 --- STRACE: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `mid`, `...', false, Array)
#1 E:\wamp64\www\plugins\distributor\classes\model\distributor.php(92): Kohana_Database_Query->execute()
#2 E:\wamp64\www\plugins\distributor\classes\controller\admin\distributor.php(62): Model_Distributor::distributor_list('', '', 'NaN', '10')
#3 [internal function]: Controller_Admin_Distributor->action_pageload()
#4 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Admin_Distributor))
#5 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#7 E:\wamp64\www\newtravel\index.php(122): Kohana_Request->execute()
#8 {main}
2018-12-20 14:10:29 --- ERROR: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2018-12-20 14:10:29 --- STRACE: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `mid`, `...', false, Array)
#1 E:\wamp64\www\plugins\distributor\classes\model\distributor.php(92): Kohana_Database_Query->execute()
#2 E:\wamp64\www\plugins\distributor\classes\controller\admin\distributor.php(62): Model_Distributor::distributor_list('', '', 'NaN', '10')
#3 [internal function]: Controller_Admin_Distributor->action_pageload()
#4 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Admin_Distributor))
#5 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#7 E:\wamp64\www\newtravel\index.php(122): Kohana_Request->execute()
#8 {main}
2018-12-20 14:10:31 --- ERROR: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2018-12-20 14:10:31 --- STRACE: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `mid`, `...', false, Array)
#1 E:\wamp64\www\plugins\distributor\classes\model\distributor.php(92): Kohana_Database_Query->execute()
#2 E:\wamp64\www\plugins\distributor\classes\controller\admin\distributor.php(62): Model_Distributor::distributor_list('', '', 'NaN', '10')
#3 [internal function]: Controller_Admin_Distributor->action_pageload()
#4 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Admin_Distributor))
#5 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#7 E:\wamp64\www\newtravel\index.php(122): Kohana_Request->execute()
#8 {main}
2018-12-20 14:10:33 --- ERROR: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2018-12-20 14:10:33 --- STRACE: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `mid`, `...', false, Array)
#1 E:\wamp64\www\plugins\distributor\classes\model\distributor.php(92): Kohana_Database_Query->execute()
#2 E:\wamp64\www\plugins\distributor\classes\controller\admin\distributor.php(62): Model_Distributor::distributor_list('', '', 'NaN', '10')
#3 [internal function]: Controller_Admin_Distributor->action_pageload()
#4 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Admin_Distributor))
#5 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#7 E:\wamp64\www\newtravel\index.php(122): Kohana_Request->execute()
#8 {main}
2018-12-20 14:10:35 --- ERROR: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2018-12-20 14:10:35 --- STRACE: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `mid`, `...', false, Array)
#1 E:\wamp64\www\plugins\distributor\classes\model\distributor.php(92): Kohana_Database_Query->execute()
#2 E:\wamp64\www\plugins\distributor\classes\controller\admin\distributor.php(62): Model_Distributor::distributor_list('', '', 'NaN', '10')
#3 [internal function]: Controller_Admin_Distributor->action_pageload()
#4 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Admin_Distributor))
#5 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#7 E:\wamp64\www\newtravel\index.php(122): Kohana_Request->execute()
#8 {main}
2018-12-20 14:10:37 --- ERROR: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2018-12-20 14:10:37 --- STRACE: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `mid`, `...', false, Array)
#1 E:\wamp64\www\plugins\distributor\classes\model\distributor.php(92): Kohana_Database_Query->execute()
#2 E:\wamp64\www\plugins\distributor\classes\controller\admin\distributor.php(62): Model_Distributor::distributor_list('', '', 'NaN', '10')
#3 [internal function]: Controller_Admin_Distributor->action_pageload()
#4 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Admin_Distributor))
#5 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#7 E:\wamp64\www\newtravel\index.php(122): Kohana_Request->execute()
#8 {main}
2018-12-20 14:10:39 --- ERROR: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2018-12-20 14:10:39 --- STRACE: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `mid`, `...', false, Array)
#1 E:\wamp64\www\plugins\distributor\classes\model\distributor.php(92): Kohana_Database_Query->execute()
#2 E:\wamp64\www\plugins\distributor\classes\controller\admin\distributor.php(62): Model_Distributor::distributor_list('', '', 'NaN', '10')
#3 [internal function]: Controller_Admin_Distributor->action_pageload()
#4 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Admin_Distributor))
#5 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#7 E:\wamp64\www\newtravel\index.php(122): Kohana_Request->execute()
#8 {main}
2018-12-20 14:10:41 --- ERROR: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2018-12-20 14:10:41 --- STRACE: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `mid`, `...', false, Array)
#1 E:\wamp64\www\plugins\distributor\classes\model\distributor.php(92): Kohana_Database_Query->execute()
#2 E:\wamp64\www\plugins\distributor\classes\controller\admin\distributor.php(62): Model_Distributor::distributor_list('', '', 'NaN', '10')
#3 [internal function]: Controller_Admin_Distributor->action_pageload()
#4 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Admin_Distributor))
#5 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#7 E:\wamp64\www\newtravel\index.php(122): Kohana_Request->execute()
#8 {main}
2018-12-20 14:10:43 --- ERROR: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2018-12-20 14:10:43 --- STRACE: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `mid`, `...', false, Array)
#1 E:\wamp64\www\plugins\distributor\classes\model\distributor.php(92): Kohana_Database_Query->execute()
#2 E:\wamp64\www\plugins\distributor\classes\controller\admin\distributor.php(62): Model_Distributor::distributor_list('', '', 'NaN', '10')
#3 [internal function]: Controller_Admin_Distributor->action_pageload()
#4 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Admin_Distributor))
#5 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#7 E:\wamp64\www\newtravel\index.php(122): Kohana_Request->execute()
#8 {main}
2018-12-20 14:10:45 --- ERROR: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2018-12-20 14:10:45 --- STRACE: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `mid`, `...', false, Array)
#1 E:\wamp64\www\plugins\distributor\classes\model\distributor.php(92): Kohana_Database_Query->execute()
#2 E:\wamp64\www\plugins\distributor\classes\controller\admin\distributor.php(62): Model_Distributor::distributor_list('', '', 'NaN', '10')
#3 [internal function]: Controller_Admin_Distributor->action_pageload()
#4 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Admin_Distributor))
#5 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#7 E:\wamp64\www\newtravel\index.php(122): Kohana_Request->execute()
#8 {main}
2018-12-20 14:10:46 --- ERROR: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2018-12-20 14:10:46 --- STRACE: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `mid`, `...', false, Array)
#1 E:\wamp64\www\plugins\distributor\classes\model\distributor.php(92): Kohana_Database_Query->execute()
#2 E:\wamp64\www\plugins\distributor\classes\controller\admin\distributor.php(62): Model_Distributor::distributor_list('', '', 'NaN', '10')
#3 [internal function]: Controller_Admin_Distributor->action_pageload()
#4 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Admin_Distributor))
#5 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#7 E:\wamp64\www\newtravel\index.php(122): Kohana_Request->execute()
#8 {main}
2018-12-20 14:11:01 --- ERROR: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2018-12-20 14:11:01 --- STRACE: Database_Exception [ 1327 ]: Undeclared variable: NaN [ SELECT `mid`, `nickname`, `truename`, `phone`, `email`, `mobile`, `isopen` FROM `sline_member` WHERE `bflg` = '1' AND `isopen` != '3' LIMIT NaN,10 ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'SELECT `mid`, `...', false, Array)
#1 E:\wamp64\www\plugins\distributor\classes\model\distributor.php(92): Kohana_Database_Query->execute()
#2 E:\wamp64\www\plugins\distributor\classes\controller\admin\distributor.php(62): Model_Distributor::distributor_list('', '', 'NaN', '10')
#3 [internal function]: Controller_Admin_Distributor->action_pageload()
#4 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Admin_Distributor))
#5 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#6 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#7 E:\wamp64\www\newtravel\index.php(122): Kohana_Request->execute()
#8 {main}