<?php

/**
 * ΢�ſ��ٵ�½����
 * Class Controller_Index
 */
class Controller_Conf extends Stourweb_Controller
{
    /**
     * ������ͼ
     */
    public function action_index()
    {
        $this->validate_login();
        $this->display('stourtravel/conf');
    }
}