<?php
/**
 * Copyright:www.deccatech.cn
 * Time: 2018/4/13 0013 14:06
 * Desc:
 */
header('Content-type:text/html;charset=utf-8');
error_reporting( E_ERROR | E_WARNING );
ini_set("display_errors","0");
date_default_timezone_set("PRC");
$base64_image_content = $_POST['imgBase64'];

//匹配出图片的格式
$result=array('url'=>$_POST['imgBase64'],'msg'=>'base64ToImg','status'=>false);
if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result))
{
    $type = $result[2];

    //目录生成
    $pathStr="upload/video_poster/";
    $fileName = time() . rand( 1 , 10000 ) . ".png";
    if ( strrchr( $pathStr , "/" ) != "/" ) {
        $pathStr .= "/";
    }
    $pathStr .= date( "Ymd" );
    //检查是否有该文件夹，如果没有就创建，并给予最高权限
    if ( !file_exists( $pathStr ) ) {
        if ( !mkdir( $pathStr , 0777 , true ) ) {
            $result=array('url'=>'','msg'=>'目录创建失败','status'=>false);
        }
    }
    //拼接全路径
    $fullName = $pathStr . '/' . $fileName;
    if (file_put_contents($fullName, base64_decode(str_replace($result[1], '', $base64_image_content))))
    {
        $result=array('url'=>$fullName,'msg'=>'保存图片成功','status'=>true);
    }
    else
    {
        $result=array('url'=>'','msg'=>'保存图片失败','status'=>false);
    }
}
echo json_encode($result);