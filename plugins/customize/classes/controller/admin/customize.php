<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Customize extends Stourweb_Controller
{
    private $_typeid = 14;
    /*
     * 订单总控制器
     *
     */
    public function before()
    {
        parent::before();
        $this->assign('typeid', $this->_typeid);
        $action = $this->request->action();
        //这里需要补权限的判断功能
    }
    /*
* 短信通知
*/
    public function action_sms()
    {
        $model_info = DB::select()->from('model')->where('id','=',$this->_typeid)->execute()->current();
        $pinyin = $model_info['pinyin'];
        $arr = DB::select()->from('sms_msg')->where('msgtype','like',$pinyin.'_%')->execute()->as_array();
        foreach($arr as $row)
        {
            $key = substr($row['msgtype'],strlen($pinyin.'_'));
            $this->assign($key,$row['msg']);
            $this->assign($key.'_open',$row['isopen']);
        }

        $this->display('admin/customize/sms');
    }
    /*
     * 短信保存
     */
    public function action_ajax_save_sms_msg()
    {
        $model_info = DB::select()->from('model')->where('id','=',$this->_typeid)->execute()->current();
        $pinyin = $model_info['pinyin'];
        for ($i = 1; $i <= 4; $i++)
        {
            $_open = 'isopen' . $i;
            $_msg = 'order_msg' . $i;
            $open = $_POST[$_open];
            $msg = $_POST[$_msg];
            $msgtype = $pinyin.'_'.$_msg;
            $model = ORM::factory('sms_msg')->where('msgtype','=',$msgtype)->find();
            $model->msgtype = $msgtype;
            $model->msg = $msg;
            $model->isopen = $open;
            $model->save();
        }
        echo json_encode(array('status'=>true,'msg'=>'提交成功'));
    }
    /*
     * 邮件通知
     */
    public function action_email()
    {
        $model_info = DB::select()->from('model')->where('id','=',$this->_typeid)->execute()->current();
        $pinyin = $model_info['pinyin'];
        $arr = DB::select()->from('email_msg')->where('msgtype','like',$pinyin.'_%')->execute()->as_array();
        foreach($arr as $row)
        {
            $key = substr($row['msgtype'],strlen($pinyin.'_'));
            $this->assign($key,$row['msg']);
            $this->assign($key.'_open',$row['isopen']);
        }
        $this->display('admin/customize/email');
    }
    /*
    * 邮件保存
    */
    public function action_ajax_save_email_msg()
    {
        $model_info = DB::select()->from('model')->where('id','=',$this->_typeid)->execute()->current();
        $pinyin = $model_info['pinyin'];
        for ($i = 1; $i <= 4; $i++)
        {
            $_open = 'isopen' . $i;
            $_msg = 'order_msg' . $i;
            $open = $_POST[$_open];
            $msg = $_POST[$_msg];
            $msgtype = $pinyin.'_'.$_msg;
            $model = ORM::factory('email_msg')->where('msgtype','=',$msgtype)->find();
            $model->msgtype = $msgtype;
            $model->msg = $msg;
            $model->isopen = $open;
            $model->save();
        }
        echo json_encode(array('status'=>true,'msg'=>'提交成功'));
    }
}