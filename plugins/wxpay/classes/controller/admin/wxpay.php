<?php defined('SYSPATH') or die('No direct script access.');

/**
 *Copyright www.deccatech.cn
 *Author: nilsir
 *QQ: 2758691158
 *Time: 2017/7/19 14:27
 *Desc: 微信支付后台操作类
 */
class Controller_Admin_Wxpay extends Stourweb_Controller
{
    private $_id = 8;
    private $_pay_types;
    private $_certs_arr = array(
        //微信
        8 => array(
            'dir'   => '/plugins/wxpay/vendor/pc/wxpay/cert/',
            'files' => array(
                'apiclient_cert.p12',
                'apiclient_cert.pem',
                'apiclient_key.pem',
                'rootca.pem',
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
        $fields = array('cfg_wxpay_appid', 'cfg_wxpay_mchid', 'cfg_wxpay_key', 'cfg_wxpay_appsecret');
        $cert_info = $this->_certs_arr[$this->_id];
        $is_uploaded = $this->_is_certs_uploaded($cert_info);

        $configs = Model_Sysconfig::get_configs(0, $fields);
        $this->assign('is_uploaded', $is_uploaded);
        $this->assign('payid', $this->_id);
        $this->assign('configs', $configs);
        $this->assign('displayorder', Model_Payset::get_displayorder($this->_id));
        $this->display('admin/wxpay/index');
    }

    /**
     * @function 支付信息保存
     */
    public function action_ajax_save()
    {
        $payid = $_POST['payid'];
        $isopen = $_POST['isopen'];
        $webid = $_POST['webid'];
        $webid = empty($webid) ? 0 : $webid;

        $result_paytypes = $this->_pay_types;

        if ($isopen == 1)
        {
            if (! in_array($payid, $result_paytypes))
            {
                array_push($result_paytypes, $payid);
            }
        }
        else
        {
            if (in_array($payid, $result_paytypes))
            {
                $key = array_search($payid, $result_paytypes);

                array_splice($result_paytypes, $key, 1);
            }
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
        Model_Sysconfig::save_config($configs);
        //新版开启和关闭
        Model_Payset::set_open_status($payid, $isopen);

        //排序
        $displayorder = intval($_POST['displayorder']);
        Model_Payset::set_displayorder($payid, $displayorder);


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
        $payid = $_POST['payid'];
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
            $dir = $this->_certs_arr[$payid]['dir'];
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