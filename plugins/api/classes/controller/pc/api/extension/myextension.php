<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Pc_Api_Extension_MyExtension extends Controller_Pc_Api_Base
{
    public function before()
    {
        parent::before();
    }

    public function action_test()
    {
        $result = Model_Api_Extension_MyExtension::test();
        $this->send_datagrams($this->client_info['id'], $result, $this->client_info['secret_key']);
    }

}