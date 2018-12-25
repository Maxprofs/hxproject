<?php
    /**
     * Copyright:www.deccatech.cn
     * Time: 2018/4/13 0013 14:06
     * Desc:
     */
    /*check相关配置*/
    $type = $_REQUEST['CheckType'];
    $data = array('status' => true, 'msg' => 'OK');
    switch ($type) {
        //检测文件大小是否超过限制
        case 'file':
            $size = intval($_REQUEST['CheckSize']) / (1024 * 1024);
            $post_max = intval(ini_get('post_max_size'));
            $upload_max = intval(ini_get('upload_max_filesize'));
            if ($size > $post_max) {
                $data = array('status' => false, 'msg' => '超出PHP配置参数post_max_size的值:' . ini_get('post_max_size') . '.');
            } elseif ($size > $upload_max) {
                $data = array('status' => false, 'msg' => '超出PHP配置参数upload_max_filesize的值:' . ini_get('upload_max_filesize') . '.');
            } else {
                $data = array('status' => true, 'msg' => 'OK');
            }
            break;
    }
    echo json_encode($data);