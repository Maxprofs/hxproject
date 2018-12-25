<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Uploader extends Stourweb_Controller
{

    /*
     * 上传DOC文档
     * */
    public function action_uploaddoc()
    {
        $basefolder = BASEPATH . '/uploads/main/doc/';

        $filedata = ARR::get($_FILES, 'Filedata');
        $path_info = pathinfo($filedata['name']);
        $filename = date('YmdHis');
        $filepath = $basefolder . $filename . '.' . $path_info['extension'];//文件上传路径
        if (!file_exists($basefolder))
        {
            mkdir($basefolder, 0777, true);
        }
        $out = array();
        if ($rs = move_uploaded_file($filedata['tmp_name'], $filepath))
        {
            $out = array(
                'status' => true,
                'name'=>$path_info['basename'],
                'path' => $GLOBALS['cmsurl'] . '/uploads/main/doc/' . $filename . '.' . $path_info['extension']

            );
        }
        echo json_encode($out);
    }

}