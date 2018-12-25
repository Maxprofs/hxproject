<?php

		$root = dirname(dirname(__FILE__));
		$ordersn = $_GET['ordersn'];
        $src = "ordersn=".$ordersn;
        //输出图片
        include $root.'/res/vendor/qrcode/phpqrcode.php';
        $errorCorrectionLevel = 'L';//容错级别
        $matrixPointSize = 6;//生成图片大小
        //生成二维码图片
        $img = QRcode::png($src,false,$errorCorrectionLevel, $matrixPointSize, 2);
        echo  imagepng($img);

?>