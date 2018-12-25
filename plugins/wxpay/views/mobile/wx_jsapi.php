<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>微信安全支付</title>
    <script type="text/javascript">
        //调用微信JS api 支付
        function jsApiCall()
        {
            WeixinJSBridge.invoke(
                'getBrandWCPayRequest',
                <?php echo $parameter; ?>,
                function(res){
                    if(res.err_msg == "get_brand_wcpay_request:ok"){
                       window.location.href="/payment/status/index/?<?php echo 'sign='.md5('11').'&ordersn='.$ordersn;?>";
                   }else{
                       //返回跳转到订单详情页面
                       window.location.href="/payment/status/?<?php echo 'sign='.md5('00');?>";
                   }
                }
            );
        }

        function callpay()
        {
            if (typeof WeixinJSBridge == "undefined"){
                if( document.addEventListener ){
                    document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
                }else if (document.attachEvent){
                    document.attachEvent('WeixinJSBridgeReady', jsApiCall);
                    document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
                }
            }else{
                jsApiCall();
            }
        }
    </script>
</head>
<body>
<br/>
<div>
    <p>当前支付产品:<?php echo $productname;?></p>
    <p>该笔订单支付金额为:<span style="color:#f00;font-size:50px"><?php echo $total_fee;?></span>元</p>
</div>
<div align="center">
    <button style="width:210px; height:50px; border-radius: 15px;background-color:#FE6714; border:0px #FE6714 solid; cursor: pointer;  color:white;  font-size:16px;" type="button" onclick="callpay()" >立即支付</button>
</div>
</body>
</html>