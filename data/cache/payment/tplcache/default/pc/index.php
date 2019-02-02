<!doctype html>
<html>
<head script_table=IIACXC >
<meta charset="utf-8">
<title>确认订单-<?php echo Common::C('cfg_webname');?></title>
<link type="text/css" rel="stylesheet" href="/res/css/base.css"/>
<link type="text/css" rel="stylesheet" href="/payment/public/css/payment.css" />
<script type="text/javascript" src="/res/js/jquery.min.js"></script>
    <script type="text/javascript" src="/res/js/common.js"></script>
</head>
<body>
   <?php echo $header;?>
<div class="big">
<div class="wm-1200">
<div class="st-guide">
<a href="<?php echo $GLOBALS['cfg_basehost'];?>">首页</a>&nbsp;&nbsp;&gt;&nbsp;&nbsp;订单支付
</div><!--面包屑-->
<div class="st-main-page">
<div class="st-payment-way">
<div class="payment-order">
<div class="payment-order-tit clearfix">
<div class="msg">马上支付！</div>
<div class="price">支付总额：<em><?php echo Currency_Tool::symbol();?><?php echo $order['pay_price'];?></em></div>
</div>
<div class="payment-order-list">
<ul>
<li class="clearfix">
<span class="hd">订单号：</span>
<div class="bd"><?php echo $order['ordersn'];?></div>
</li>
<li class="clearfix">
<span class="hd">产品名称：</span>
<div class="bd"><?php echo $order['productname'];?></div>
</li>
<li class="clearfix">
<span class="hd">产品编号：</span>
<div class="bd"><?php echo $order['series_number'];?></div>
</li>
<li class="clearfix">
<span class="hd">提交时间：</span>
<div class="bd"><?php echo date('Y年m月d日 H:i:s',$order['addtime']);?></div>
</li>
<li class="clearfix">
<span class="hd">预订方式：</span>
<div class="bd"><?php if($order['paytype']==2) { ?>定金预订<i class="des">（该产品您选择的定金预定方式，本次支付为定金部分。请到店或通过个人中心尾款订单，完成尾款支付。）</i><?php } else { ?>全款预订<?php } ?>
</div>
</li>
<li class="clearfix">
<span class="hd">应付金额：</span>
<div class="bd"><em><?php echo Currency_Tool::symbol();?><?php echo $order['single_pay_price'];?></em></div>
</li>
</ul>
                            <?php if(!empty($additional)) { ?>
                                <?php $n=1; if(is_array($additional)) { foreach($additional as $sub) { ?>
                                <ul>
                                    <li class="clearfix">
                                        <span class="hd">订单号：</span>
                                        <div class="bd"><?php echo $sub['ordersn'];?></div>
                                    </li>
                                    <li class="clearfix">
                                        <span class="hd">产品名称：</span>
                                        <div class="bd"><?php echo $sub['productname'];?></div>
                                    </li>
                                    <li class="clearfix">
                                        <span class="hd">预订方式：</span>
                                        <div class="bd">全款预订</div>
                                    </li>
                                    <li class="clearfix">
                                        <span class="hd">应付金额：</span>
                                        <div class="bd"><em><?php echo Currency_Tool::symbol();?><?php echo $sub['pay_price'];?></em></div>
                                    </li>
                                </ul>
                                <?php $n++;}unset($n); } ?>
                            <?php } ?>
</div>
</div>
<!-- 订单信息 -->
                    <?php if($order['status']!=0) { ?>
<div class="payment-con-box">
<h3 class="payment-tit">选择以下支付方式付款</h3>
<div class="payment-con">
<div class="payment-line payment-on">
                                <?php if(($order['pay_way']==1 || $order['pay_way'] == 3) && !empty($pay_method['online'])) { ?>
<dl>
<dt>线上支付</dt>
<dd>
<ul>
                                            <?php $n=1; if(is_array($pay_method['online'])) { foreach($pay_method['online'] as $k => $v) { ?>
                                                <li data-type="online" data="<?php echo $v['id'];?>" data-payurl="<?php echo $v['payurl'];?>" class="<?php if($v['selected']) { ?>active <?php } ?>
<?php if($n%5==0) { ?>mr_0<?php } ?>
" >
                                                    <span><img src="<?php echo $v['litpic'];?>" /></span>
                                                </li>
                                            <?php $n++;}unset($n); } ?>
</ul>
</dd>
</dl>
                                <?php } ?>
<?php if(($order['pay_way']==2 || $order['pay_way']==3) && !empty($pay_method['offline'])) { ?>
<dl>
<dt>线下支付</dt>
<dd>
<ul>
                                            <?php $n=1; if(is_array($pay_method['offline'])) { foreach($pay_method['offline'] as $k => $v) { ?>
<li data-type="offline" data-payurl="<?php echo $v['payurl'];?>" data="ordersn=<?php echo $order['ordersn'];?>&method=<?php echo $v['id'];?>"><span><img src="/uploads/payset/6.png" /></span></li>
                                            <?php $n++;}unset($n); } ?>
</ul>
<div class="pay-info">
                                            <?php echo Common::C('cfg_pay_xianxia');?>
</div>
</dd>
</dl>
                                <?php } ?>
</div>
 <div class="payment-now-btn"><a href="javascript:;" id="st-payment-submit"><?php if($order['pay_way']!=2) { ?>立即支付<?php } else { ?>提交预定<?php } ?>
</a></div>
</div>
</div>
<!--全额支付-->
                    <?php } else { ?>
                    <div class="payment-con-box">
                        <h3 class="payment-tit">预定提示</h3>
                        <div class="payment-con">
                            <p class="free-txt">您预定的产品需要平台管理审核。审核通过之后，请到订单中心查看并完成付款！</p>
                            <div class="payment-dd-btn"><a href="/member/order/all">查看订单</a></div>
                        </div>
                    </div>
                    <?php } ?>
</div>
</div>
</div>
</div>
<div class="st-payment-back-box" id="st-payment-back-box" style="display: none;">
<div class="st-back-con">
<h3>支付反馈<i class="close-button"></i></h3>
<div class="payment-ts-con">
<div class="payment-opp">
                    <a href="/member/order/view?ordersn=<?php echo $order['ordersn'];?>" target="_blank">
                        <dl class="cg">
                            <dt></dt>
                            <dd>查看订单详情</dd>
                        </dl>
                    </a>
                    <a href="javascript:" id="st-payment-back-error" class="close-button">
<dl class="sb">
<dt></dt>
<dd>选择其他支付方式</dd>
</dl>
                    </a>
</div>
<p class="ts">温馨提示：请您在新打开的网上银行页面进行支付，支付完成前请不要关闭该窗口。</p>
</div>                                                                                                                             


</div>
</div>
<!-- 支付返回框 -->
   <?php echo $footer;?>
</body>
<script>
    $(function(){
        //初始化
        if($('.payment-line').find('li.active').length>0)
        {
            $('#st-payment-submit').removeClass('error');
        }
        else
        {
            $('.payment-line').find('li').first().addClass('active');
            $('#st-payment-submit').removeClass('error');
        }
        //选择线上支付方式
        $('.payment-on').find('li').click(function(){
            $('.payment-on').find('li').removeClass('active');
            $(this).addClass('active');
            $('#st-payment-submit').removeClass('error');
            if($(this).data('type') == 'offline'){
                $('#st-payment-submit').html('提交预定');
            }else{
                $('#st-payment-submit').html('立即支付');
            }
        });
        //选择线下支付
        $('#st-payment-submit').click(function(){
            var selectedLi=$('.payment-on').find('li.active');
            var len=selectedLi.length;
            if(len!=1){
                return;
            }
            var param={
                ordersn:"<?php echo $order['ordersn'];?>",
            };
            param.method=selectedLi.attr('data');
            $url=new Array();
            for(key in param){
                $url.push(key+'='+param[key]);
            }
            var payurl = selectedLi.attr('data-payurl');
            //线上支付
            $('#st-payment-back-box').css('display', 'block');
            if (payurl != '') {
                payurl = payurl + '?' + $url.join('&');
            } else {
                payurl = " /payment/index/confirm?" + $url.join('&');
            }
            window.open(payurl);
        });
        //支付失败
        $('.close-button').click(function(){
            $('#st-payment-back-box').css('display','none');
        });
    })
</script>
</html>
