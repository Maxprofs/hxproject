<?php
require(dirname(__FILE__) . "/../stcmsdemobase.php");

class OrderSearch extends StcmsDemoBase
{

    private $_method = "api/standard/order/search";

    public function exec()
    {
        $search_params = array(
            "webid" => "0",
            "status" => "2",
            "end_time" => "2017-02-14",
            "page" => array(
                "start" => "9",
                "limit" => "3"
            ),
            "sort" => array(
                "property" => "id",
                "direction" => ""

            )
        );

        $request_result = $this->send_request($this->_method, $search_params);
        if ($request_result['success'] == false)
        {
            exit("错误：" . $request_result['message']);
        }

        var_dump($request_result['body']);
    }

}

?>
