<!doctype html> <html> <head div_left=VrKzDt > <meta charset="utf-8"> <title>微信扫码支付-<?php echo $GLOBALS['cfg_webname'];?></title> <link type="text/css" rel="stylesheet" href="/res/css/base.css"/> <script type="text/javascript" src="/res/js/jquery.min.js"></script> <script type="text/javascript" src="/res/js/common.js"></script> </head> <body> <?php echo $header;?> <div class="big"> <div class="wm-1200"> <link href="/payment/public/css/pay.css" rel="stylesheet" media="screen" type="text/css" /> <div class="width_1210"> <div class="st-guide"> <a href="/">首页</a>&nbsp;&nbsp;&gt;&nbsp;&nbsp;在线支付
            </div> <div class="wx-main"> <div class="pay-weixin"> <div class="p-w-box"> <div class="p-w-hd">
                            微信支付
                        </div> <div class="pw-box-hd"> <img src="<?php echo $src;?>" /> </div> <div class="pw-box-ft"> <p>请使用微信扫一扫</p> <p>扫描二维码支付</p> </div> </div> <div class="p-w-sidebar"> </div> </div> <div class="payment-change"></div> </div> </div> <form action="/payment/status/" style='display:none;' method="post" id="auto_submit"> <input type="text" name="ordersn" value="<?php echo $ordersn;?>"/> <input type="text" name="sign" value="<?php echo $sign;?>"/> <input type="submit" value="提交"> </form> <script>
            function wx_submit(){
                var data={ 'ordersn':'<?php echo $ordersn;?>' }
                $.post('/payment/index/ajax_ispay',data,function(rs){
                    if(rs.result==false){
                        //再次提交数据
                        window.setTimeout("wx_submit()",3000);
                    }else{
                        $('#auto_submit').submit();
                    }
                },'json');
            }
            var intval=window.setTimeout("wx_submit()",5000);
        </script> </div> </div> <?php echo $footer;?> </body> </html>
