<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>订单支付-<?php echo Common::C('cfg_webname');?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link type="text/css" rel="stylesheet" href="/phone/public/css/base.css">
    <script type="text/javascript" src="/phone/public/js/lib-flexible.js"></script>
    <script type="text/javascript" src="/phone/public/js/jquery.min.js"></script>
    <script type="text/javascript" src="/phone/public/js/layer/layer.m.js"></script>
    <script type="text/javascript" src="/phone/public/js/template.js"></script>
    <link href="/payment/public/css/mpay.css" rel="stylesheet" media="screen" type="text/css" />
</head>
<style>
    img{
        width:100%;
        height:100%
    }
    /*富文本内容移动设备弹出层样式控制*/
    .layermcont{
        height:480px;
        overflow-y:auto;
        text-align: left;
    }
</style>
<body>
<?php echo $header;?>
<div class="payment_page_pic"><img src="/payment/public/images/mobile/st-order-zhifu.gif" /></div>
<div class="confirm_order_msg">
    <ul>
        <li><span>订单号：</span><?php echo $order['ordersn'];?></li>
        <li><span>产品名称：</span><?php echo $order['productname'];?></li>
        <li><span>产品编号：</span><?php echo $order['series_number'];?></li>
        <li><span>购买时间：</span><?php echo date('Y年m月d日 H:i:s',$order['addtime']);?></li>
        <li><span>支付价格：</span><?php echo Currency_Tool::symbol();?><?php echo $order['single_pay_price'];?></li>
    </ul>
    <?php if(!empty($additional)) { ?>
        <?php $n=1; if(is_array($additional)) { foreach($additional as $sub) { ?>
            <ul>
                <li><span>订单号：</span><?php echo $sub['ordersn'];?></li>
                <li><span>产品名称：</span><?php echo $sub['productname'];?></li>
                <li><span>支付价格：</span><?php echo Currency_Tool::symbol();?><?php echo $sub['pay_price'];?></li>
            </ul>
        <?php $n++;}unset($n); } ?>
    <?php } ?>
</div>
<div class="payway">
    <ul>
         <?php if($order['status'] !=0) { ?>
            <li class="l1"><strong>支付方式</strong><?php if($order['paytype']==1) { ?><span>全款预订</span><?php } else if($order['paytype']==2) { ?><span>定金预订</span><?php } else { ?><span>二次确认</span><?php } ?>
</li>
            <li class="l2">
                <p><strong>总金额</strong><em><?php echo Currency_Tool::symbol();?><?php echo $order['totalprice'];?></em></p>
                <?php if($order['usejifen'] == 1) { ?>
                    <p><strong>积分抵现</strong><em><?php echo Currency_Tool::symbol();?>-<?php echo $order['jifentprice'];?></em></p>
                <?php } ?>
                 <?php if($order['iscoupon']) { ?>
                    <p><strong>优惠券</strong><em><?php echo Currency_Tool::symbol();?>-<?php echo $order['cmoney'];?></em></p>
                 <?php } ?>
                <?php if($order['envelope_price']) { ?>
                <p><strong>红包抵扣</strong><em><?php echo Currency_Tool::symbol();?>-<?php echo $order['envelope_price'];?></em></p>
                <?php } ?>
                <p><strong>实际支付</strong><span><?php echo Currency_Tool::symbol();?><?php echo $order['pay_price'];?></span></p>
            </li>
            <li class="l3" id="mobile_common_pay">
                <?php if($order['pay_way']==1 || $order['pay_way'] == 3) { ?>
                  <?php $n=1; if(is_array($pay_method['online'])) { foreach($pay_method['online'] as $v) { ?>
                    <a id="m_<?php echo $v['id'];?>" data-paymethod="online" href="javascript:" <?php if((isset($v['selected']) && $v['selected'])) { ?>class="on"<?php } ?>
 data="ordersn=<?php echo $order['ordersn'];?>&method=<?php echo $v['id'];?>" data-payurl="<?php echo $v['payurl'];?>"><img src="<?php echo $v['litpic'];?>" /></a>
                  <?php $n++;}unset($n); } ?>
                <?php } ?>
                <?php if($order['pay_way']==2 || $order['pay_way'] == 3) { ?>
                    <?php $n=1; if(is_array($pay_method['offline'])) { foreach($pay_method['offline'] as $v) { ?>
                    <a id="m_<?php echo $v['id'];?>" data-paymethod="offline"  href="javascript:" data="ordersn=<?php echo $order['ordersn'];?>&method=<?php echo $v['id'];?>" data-payurl="<?php echo $v['payurl'];?>"><img src="<?php echo $v['litpic'];?>" /></a>
                    <?php $n++;}unset($n); } ?>
                <?php } ?>
            </li>
        <?php } else { ?>
            <li class="l1"><strong>二次确认支付</strong></li>
            <li class="payment-second-txt">您的订单已提交成功，您所购买的产品是二次确认产品，需要平台管理审核。审核通过之后，请到订单中心查看并完成付款！</li>
        <?php } ?>
    </ul>
</div>
<div class="pay-info" id="pay_offline_info" style="display:none">
    <?php echo Common::C('cfg_pay_xianxia');?>
</div>
<script>
    var status="<?php echo $order['status'];?>";
    $(document).ready(function(){
        if($('#mobile_common_pay').find('a.on').length>0){
            $('.bottom-fixed').removeClass('hide');
        }else{
            $('.bottom-fixed').addClass('hide');
        }
        $('#mobile_common_pay').find('a').click(function(){
            $(this).addClass('on').siblings('a').removeClass('on');
            $('.bottom-fixed').removeClass('hide');
            if($(this).data('paymethod')=='offline'){
                layer.open({
                    content: $('#pay_offline_info').html()
                    ,btn: ['确定']
                });
                $('#confirm_pay_btn').text('提交预订');
            }else{
                $('#confirm_pay_btn').text('立即支付');
            }
        });
        $('#mobile_common_pay').find('a').first().trigger('click');
    });
    function is_weixin() {
        var ua = window.navigator.userAgent.toLowerCase();
        if (ua.match(/MicroMessenger/i) == 'micromessenger') {
            return true;
        } else {
            return false;
        }
    }
</script>
<div class="hold-bottom-bar">
    <div class="bottom-fixed">
        <a class="confirm_pay_btn" id="confirm_pay_btn" href="javascript:;"><?php echo $btn_title;?></a>
    </div>
</div>
</body>
<script>
    var login_status=0;
    $('#confirm_pay_btn').click(function(){
        if (status>0) {
            var len=$('#mobile_common_pay').find('a.on').length;
            var data = $('#mobile_common_pay').find('a.on').attr('data');
            var payurl = $('#mobile_common_pay').find('a.on').attr('data-payurl');
            if(len!=1)
            {
                return;
            }
            if (payurl == "") {
                window.location.href = '/payment/index/confirm/?' + data;
            } else {
                window.location.href = payurl + '/?' + data;
            }
        } else {
            window.location.href = login_status>0?'/phone/member#&myOrder':'/phone/member/login?redirecturl=<?php echo urlencode("/phone/member#&myOrder");?>';
        }
    });
    function is_login($obj){
        if($obj.bool<1){
            return;
        }
        login_status=$obj.islogin;
        var html='<div class="st_user_header_pic">'
            +'<img src="'+$obj.info.litpic+'" />'
            +'<p><a>'+$obj.info.nickname+'</a></p>'
            +'</div>'
            +'<div class="st_user_cz">'
            +'<a href="/phone/"><i class="ico_01"></i>首页</a>'
            +'<a href="/phone/member/order/list"><i class="ico_02"></i>我的订单<em>'+$obj.info.orderNum+'</em></a>'
            +'<a href="/phone/member/linkman"><i class="ico_03"></i>常用联系人</a>'
            +'<a class="cursor" id="logout"><i class="ico_04"></i>退出</a>'
            +'</div>';
        $('#login-html').html(html);
    }
</script>
<script type="text/javascript" src="/phone/member/login/ajax_islogin"></script>
</html>