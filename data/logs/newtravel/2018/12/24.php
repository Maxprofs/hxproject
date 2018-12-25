<?php defined('SYSPATH') OR die('No direct script access.'); ?>

2018-12-24 11:17:51 --- ERROR: HTTP_Exception_404 [ 404 ]: The requested URL distributor/pc/index was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
2018-12-24 11:17:51 --- STRACE: HTTP_Exception_404 [ 404 ]: The requested URL distributor/pc/index was not found on this server. ~ SYSPATH\classes\kohana\request\client\internal.php [ 111 ]
--
#0 E:\wamp64\www\core\system\classes\kohana\request\client.php(64): Kohana_Request_Client_Internal->execute_request(Object(Request))
#1 E:\wamp64\www\core\system\classes\kohana\request.php(1177): Kohana_Request_Client->execute(Object(Request))
#2 E:\wamp64\www\newtravel\index.php(122): Kohana_Request->execute()
#3 {main}
2018-12-24 11:19:04 --- ERROR: ErrorException [ 1 ]: Call to undefined method Common::session() ~ E:\wamp64\www\tools\classes\model\member\login.php [ 233 ]
2018-12-24 11:19:04 --- STRACE: ErrorException [ 1 ]: Call to undefined method Common::session() ~ E:\wamp64\www\tools\classes\model\member\login.php [ 233 ]
--
#0 [internal function]: Kohana_Core::shutdown_handler()
#1 {main}
2018-12-24 11:25:06 --- ERROR: ErrorException [ 1 ]: Call to undefined method Common::session() ~ E:\wamp64\www\tools\classes\model\member\login.php [ 233 ]
2018-12-24 11:25:06 --- STRACE: ErrorException [ 1 ]: Call to undefined method Common::session() ~ E:\wamp64\www\tools\classes\model\member\login.php [ 233 ]
--
#0 [internal function]: Kohana_Core::shutdown_handler()
#1 {main}
2018-12-24 11:26:44 --- ERROR: ErrorException [ 1 ]: Call to undefined method Common::session() ~ E:\wamp64\www\tools\classes\model\member\login.php [ 233 ]
2018-12-24 11:26:44 --- STRACE: ErrorException [ 1 ]: Call to undefined method Common::session() ~ E:\wamp64\www\tools\classes\model\member\login.php [ 233 ]
--
#0 [internal function]: Kohana_Core::shutdown_handler()
#1 {main}