<?php

/**
 * Î¢ÐÅ¿ìËÙµÇÂ½ÅäÖÃ
 * Class Controller_Index
 */
class Controller_Conf extends Stourweb_Controller
{
    /**
     * ÅäÖÃÊÓÍ¼
     */
    public function action_index()
    {
        $this->validate_login();
        $this->display('stourtravel/conf');
    }
}