<?php defined('SYSPATH') OR die('No direct script access.'); ?>

2019-01-03 13:36:25 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL public/images/arrow-calender-right-icon.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
2019-01-03 13:36:25 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL public/images/arrow-calender-right-icon.png was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 87 ]
--
#0 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#2 E:\wamp64\www\plugins\supplier_spot\index.php(131): Kohana_Request->execute()
#3 {main}