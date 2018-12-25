<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Class Controller_Member_Comment
 * 用户评论
 */
class Controller_Member_Frequency extends Stourweb_Controller
{
    /**
     * 前置操作
     */
    private $_member;
    public function before()
    {
        parent::before();
        $this->_member = Common::session('member');
        if (empty($this->_member))
        {
            Common::message(array('message' => __('unlogin'), 'jumpUrl' => $this->cmsurl . 'member/login'));
        }
    }

    /**
     * 评论视图
     */
    public function action_index()
    {
        $this->display('member/frequency/index');
    }
}