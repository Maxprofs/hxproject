<?php
require(dirname(__FILE__) . "/../stcmsdemobase.php");

class MemberSave extends StcmsDemoBase
{

    private $_method = "api/standard/member/save";

    public function exec()
    {
        $headpicfile = BASEPATH . "/testheadpic.png";
        $fp = fopen($headpicfile,"rb");
        $headpicdata = fread($fp,filesize($headpicfile));
        fclose($fp);
        $testheadpic = ".png," . base64_encode($headpicdata);
        $params = array(
            "id" => "55",
            "email" => "www11@stourweb.cn",
            "mobile" => "13730667028",
            "password" => "123456",
            "nickname" => "xxxxx",
            "sex" => "男",
            "birthday" => "1994/10/2",
            "constellation" => "天蝎座",
            "qq" => "573077778",
            "signature" => "sssssssssssssss",
            "headpic"=> $testheadpic,
            "identity_card" => "510182195896541258",
            "truename" => "测试api",
            "safequestion" => "aaa",
            "safeanswer" => "bbb",
            "checkemail" => "1",
            "checkphone" => "1",
            "jifen" => "100",
            "address" => "pz100"
        );

        $request_result = $this->send_request($this->_method, $params);
        if ($request_result['success'] == false)
        {
            exit("错误：" . $request_result['message']);
        }

        var_dump($request_result['body']);
    }

}

?>
