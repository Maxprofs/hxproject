<?php defined('SYSPATH') or die('No direct script access.');

/**
 *Copyright www.deccatech.cn
 *Author: nilsir
 *QQ: 2758691158
 *Time: 2017/7/19 10:52
 *Desc: 支付宝后台操作类
 */
class Controller_Admin_Alipay extends Stourweb_Controller
{
    private $_id = 1;
    private $_pay_types;

    private $_certs_arr = array(
        //支付宝
        1 => array(
            'dir'   => '/plugins/alipay/vendor/pc/alipay_cash/',
            'files' => array(
                'rsa_private_key.pem',
                'rsa_private_key_pkcs8.pem',
                'rsa_public_key.pem',
            ),
        ),
    );


    public function before()
    {
        parent::before();
        $cfg_pay_type = Model_Sysconfig::get_configs(0, 'cfg_pay_type', true);
        $this->_pay_types = explode(',', $cfg_pay_type);
        $this->assign('pay_types', $this->_pay_types);
    }

    public function action_index()
    {
        $fields = array('cfg_alipay_account', 'cfg_alipay_pid', 'cfg_alipay_key','cfg_alipay_appid','alipay_public_key','merchant_private_key');
        $configs = Model_Sysconfig::get_configs(0, $fields);
        $cert_info = $this->_certs_arr[$this->_id];
        $is_uploaded = $this->_is_certs_uploaded($cert_info);
        $this->assign('is_uploaded', $is_uploaded);
        $this->assign('payid', $this->_id);
        $this->assign('configs', $configs);
        $this->assign('displayorder', Model_Payset::get_displayorder($this->_id));

        $this->display('admin/alipay/index');
    }

    /**
     * @function 支付宝信息保存
     */
    public function action_ajax_alipay_save()
    {
        $alipay_payids = array('11', '12', '13', '14');
        $payids = $_POST['payids'];
        $webid = $_POST['webid'];
        $webid = empty($webid) ? 0 : $webid;

        $result_paytypes = array_diff($this->_pay_types, $alipay_payids);
        if (!empty($payids))
        {
            $result_paytypes = array_merge($result_paytypes, $payids);
            $result_paytypes[] = 1;
        }
        else
        {
            $result_paytypes = array_diff($result_paytypes, 1);
        }
        $result_paytypes = array_unique(array_filter($result_paytypes));
        $cfg_pay_type = implode(',', $result_paytypes);
        $configs = array('webid' => $webid, 'cfg_pay_type' => $cfg_pay_type);
        foreach ($_POST as $k => $v)
        {
            if (strpos($k, 'cfg_') === 0)
            {
                $configs[$k] = $v;
            }
        }
        $merchant_private_key = $_POST['merchant_private_key'];
        $alipay_public_key = $_POST['alipay_public_key'];
        $configs['alipay_public_key'] = $alipay_public_key;
        $configs['merchant_private_key'] = $merchant_private_key;
        Model_Sysconfig::save_config($configs);
        $displayorder = intval($_POST['displayorder']);

        //新版本开启和关闭
        foreach ($alipay_payids as $v)
        {
            Model_Payset::set_displayorder($v, $displayorder);
            if (in_array($v, $payids))
            {
                Model_Payset::set_open_status($v, 1);
            }
            else
            {
                Model_Payset::set_open_status($v, 0);
            }

        }
        if(!empty($payids) && count($payids)>0)
        {
            Model_Payset::set_open_status(1,1);
        }
        else
        {
            Model_Payset::set_open_status(1,0);
        }

        //排序存储()
        Model_Payset::set_displayorder(1, $displayorder);
        echo json_encode(array('status' => true, 'msg' => '保存成功'));
    }



    /**
     * @function 判断证书是否存在
     * @param $info
     * @return bool
     */
    private function _is_certs_uploaded($info)
    {
        $basepath = rtrim(BASEPATH . '/', '\\../');
        foreach ($info['files'] as $file)
        {
            $full_path = $basepath . $info['dir'] . $file;
            if (! file_exists($full_path))
            {
                return false;
            }
        }

        return true;
    }


    /**
     * @function 上传证书
     */
    public function action_upload_certs()
    {

        $basefolder = BASEPATH . '/uploads/main/certs/';
        $filedata = ARR::get($_FILES, 'Filedata');
        $path_info = pathinfo($filedata['name']);
        $filename = date('YmdHis');
        $filepath = $basefolder . $filename . '.' . $path_info['extension'];//文件上传路径
        if (! file_exists($basefolder))
        {
            mkdir($basefolder, 0777, true);
        }
        $out = array('status' => false);
        if ($rs = move_uploaded_file($filedata['tmp_name'], $filepath))
        {
            $dir = $this->_certs_arr[1]['dir'];
            //解压文件
            include(PUBLICPATH . '/vendor/zipfolder.php');
            $archive = new ZipFolder();
            $archive->setLoadPath(dirname($filepath) . '/');
            $archive->setFile(basename($filepath));

            $unzippath = BASEPATH . $dir;

            //如果没有证书目录，则生成目录
            if (! file_exists($unzippath))
            {
                mkdir($unzippath, 0777, true);
            }
            $archive->setSavePath($basefolder);
            $extractResult = $archive->openZip();
            if (! $extractResult || Common::isEmptyDir(dirname($filepath)))
            {

                $out['msg'] = '文件损坏或网站目录及子目录无写权限'; //目录无写权限
                exit(json_encode($out));
            }
            else
            {
                $moveResult = Common::xCopy($basefolder . "{$filename}", $unzippath, true);
                if ($moveResult['success'] == false)
                {
                    $out['msg'] = '证书文件移动失败,' . $moveResult['errormsg'];
                    exit(json_encode($out));
                }
            }
            $out['status'] = true;


            //删除上传的文件
            Common::rrmdir($basefolder);
        }
        else
        {
            $out['msg'] = '证书上传错误';
        }
        echo json_encode($out);
    }





}