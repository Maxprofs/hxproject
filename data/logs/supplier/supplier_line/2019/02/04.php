<?php defined('SYSPATH') OR die('No direct script access.'); ?>

2019-02-04 01:17:55 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL order/                         ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2019-02-04 01:17:55 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL order/                         ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#2 E:\wamp64\www\plugins\supplier_line\index.php(135): Kohana_Request->execute()
#3 {main}