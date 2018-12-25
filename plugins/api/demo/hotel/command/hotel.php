<?php
require(dirname(__FILE__) . "/../hoteldemo.php");

class Hotel extends Hoteldemo
{

    private $_method = "api/standard/hotel/";

    public function exec()
    {
        $action = $_GET['action'];
        $params = $_GET;
        $request_result = $this->send_request($this->_method.$action, $params);
        if ($request_result['success'] == false)
        {
            exit("错误：" . $request_result['message']);
        }

        var_dump($request_result['body']);
    }

}

?>
