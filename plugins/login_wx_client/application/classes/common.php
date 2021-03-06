<?php defined('SYSPATH') or die('No direct script access.');
//引入公用函数库
require TOOLS_COMMON . 'functions.php';

class Common extends Functions
{
    //验证是否登陆
    public static function checkLogin($secretkey)
    {
        $info = explode('||', self::authcode($secretkey));
        if (isset($info[0]) && $info[1])
        {
            $uname = Common::remove_xss($info[0]);
            $upwd = Common::remove_xss($info[1]);
            $model = ORM::factory('admin')->where('username','=',$uname)
                ->and_where('password','=',$upwd)
                ->find();
            if (isset($model->id))
                return $model->as_array();
            else
                return 0;
        }
    }
    //操作日志记录
    public static function addLog($controller, $action, $second_action)
    {
        $session = Session::instance();
        $session_username = $session->get('username');
        $uid = $session->get('userid');
        if (empty($uid))
            return;
        $time = date('Y-m-d H:i:s');
        $info = explode('||', self::authcode($session_username));
        $second_action = !empty($second_action) ? '->' . $second_action : '';
        $msg = "用户{$info[0]}在{$time}执行$controller->{$action}{$second_action}操作";
        $logData = array(
            'logtime' => time(),
            'uid' => $uid,
            'username' => $info[0],
            'loginfo' => $msg,
            'logip' => $_SERVER['REMOTE_ADDR']
        );
        foreach ($logData as $key => $value)
        {
            $keys .= $key . ',';
            $values .= "'" . $value . "',";
        }
        $keys = trim($keys, ',');
        $values = trim($values, ',');
        $sql = "insert into sline_user_log($keys) values($values)";
        DB::query(1, $sql)->execute();
    }
    
    /**
     * @param $field
     * @param $varname
     * @param int $webid
     * @return mixed
     * 获取配置值.
     */
    public static function get_sys_para($varname, $webid = 0)
    {
        $sql = "SELECT value FROM `sline_sysconfig` WHERE varname='$varname' AND webid=$webid";
        $result = DB::query(1, $sql)->execute()->current();
        return $result['value'];
    }

    /**
     * @function 加载后台皮肤
     * @return string
     */
    public static function get_skin_css()
    {
        $out = '';
        $cfg_skin_back_id = DB::select('value')
                              ->from('sysconfig')
                              ->where('varname', '=', 'cfg_skin_back_id')
                              ->execute()
                              ->get('value');
        if ($cfg_skin_back_id)
        {
            $file = DB::select('file')
                      ->from('skin_back')
                      ->where('id', '=', $cfg_skin_back_id)
                      ->execute()
                      ->get('file');

            $tfile = rtrim(BASEPATH, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . Common::get_sys_para('cfg_admin_dirname') . "/public/css/" . $file;
            $domain = DB::select('weburl')->from('weblist')->where('webid', '=',0)->execute()->get('weburl');
            if (file_exists($tfile))
            {
                $out .= "<link type=\"text/css\" href=\"". $domain. '/' .Common::get_sys_para('cfg_admin_dirname') . "/public/css/" . $file."\" rel=\"stylesheet\" />";
            }
        }

        return $out;
    }


}
