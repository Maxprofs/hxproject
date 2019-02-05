<?php defined('SYSPATH') OR die('No direct script access.'); ?>

2019-02-04 10:44:12 --- ERROR: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ SELECT * FROM sline_model WHERE id= ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
2019-02-04 10:44:12 --- STRACE: Database_Exception [ 1064 ]: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 [ SELECT * FROM sline_model WHERE id= ] ~ MODPATH\database\classes\kohana\database\mysql.php [ 194 ]
--
#0 E:\wamp64\www\core\modules\database\classes\kohana\database\query.php(251): Kohana_Database_MySQL->query(1, 'SELECT * FROM s...', false, Array)
#1 E:\wamp64\www\tools\classes\model\model.php(67): Kohana_Database_Query->execute()
#2 E:\wamp64\www\tools\classes\model\model.php(196): Model_Model::all_model(NULL)
#3 E:\wamp64\www\payment\application\classes\controller\index.php(210): Model_Model::get_product_bymodel(NULL, NULL, 'id')
#4 E:\wamp64\www\payment\application\classes\controller\index.php(76): Controller_Index->_ordersn_checked('001190201145431...')
#5 [internal function]: Controller_Index->action_index()
#6 E:\wamp64\www\core\system\classes\kohana\request\client\internal.php(116): ReflectionMethod->invoke(Object(Controller_Index))
#7 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#8 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#9 E:\wamp64\www\payment\index.php(132): Kohana_Request->execute()
#10 {main}