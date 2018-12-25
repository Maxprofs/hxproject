<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Copyright:www.deccatech.cn
 * Author: netman
 * QQ: 1649513971
 * Time: 2017/7/4 16:36
 * Desc:微信h5支付后台管理
 */

class Controller_Admin_Wxh5 extends Stourweb_Controller
{
    public function before()
    {
        parent::before();
    }

    /**
     * @function 后台配置页
     */
    public function action_index()
    {
        //帐户配置信息
        $config = Kohana::$config->load('wxh5')->as_array();
        //payset配置
        $payset = DB::select()->from('payset')->where('pinyin','=','wxh5')->execute()->current();

        $this->assign('config',$config);
        $this->assign('payset',$payset);
        $this->display('admin/wxh5/index');
    }

    /**
     * @function 保存配置信息
     */
    public function action_ajax_save_config()
    {
        $app_id = St_Filter::remove_xss(Arr::get($_POST, 'appid'));
        $app_secret = St_Filter::remove_xss(Arr::get($_POST, 'appsecret'));
        $mch_id = St_Filter::remove_xss(Arr::get($_POST,'mchid'));
        $mch_key = St_Filter::remove_xss(Arr::get($_POST,'mchkey'));

        $pay_id = intval(Arr::get($_POST,'payid'));
        $isopen = intval(Arr::get($_POST,'isopen'));
        $displayorder = intval(Arr::get($_POST,'displayorder'));


        $file = WXH5 . 'config' . DIRECTORY_SEPARATOR . 'wxh5.php';
        $array = array(
            'appid'    => $app_id,
            'appsecret' => $app_secret,
            'mchid' => $mch_id,
            'mchkey' => $mch_key
        );
        $res = file_put_contents($file, "<?php defined('SYSPATH') or die('No direct script access.');\n\rreturn " . var_export($array, 1) . ';');
        if ($res !== false)
        {

            $data = array(
                'isopen' => $isopen,
                'displayorder' => $displayorder
            );
            DB::update('payset')->set($data)->where('id','=',$pay_id)->execute();
            exit(json_encode(array('status' => 1, 'msg' => 'success')));
        }
        exit(json_encode(array('status' => 0, 'msg' => 'error')));
    }
}