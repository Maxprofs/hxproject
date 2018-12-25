<?php
require(dirname(__FILE__) . "/../stcmsdemobase.php");

class MemberSearch extends StcmsDemoBase
{

    private $_method = "api/standard/member/search";

    public function exec()
    {
        $search_params = array(
            "keyword" => "",
            "start_time" => "",
            "start_time" => "",
            "end_time" => "",
            "begin_jifen" => "2000",
            "end_jifen" => "2500",
            "birthday" => "",
            "sex" => "",
            "page" => array(
                "start" => "0",
                "limit" => "4"
            ),
            "sort" => array(
                "property" => "id",
                "direction" => "desc"

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
