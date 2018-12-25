<!doctype html>
<html>
<head script_table=IIACXC >
	<meta charset="utf-8">
	<title>确认订单-{Common::C('cfg_webname')}</title>
	<link type="text/css" rel="stylesheet" href="/res/css/base.css"/>
	<link type="text/css" rel="stylesheet" href="/payment/public/css/payment.css" />
	<script type="text/javascript" src="/res/js/jquery.min.js"></script>
    <script type="text/javascript" src="/res/js/common.js"></script>
</head>
<body>
   {$header}
	<div class="big">
		<div class="wm-1200">

			<div class="st-guide">
				<a href="{$GLOBALS['cfg_basehost']}">首页</a>&nbsp;&nbsp;&gt;&nbsp;&nbsp;订单支付
			</div><!--面包屑-->

			<div class="st-main-page">
				<div class="st-payment-way">
					<div class="payment-order">
						<div class="payment-order-tit clearfix">
							<div class="msg">马上支付！</div>
							<div class="price">支付总额：<em>{Currency_Tool::symbol()}{$order['pay_price']}</em></div>
						</div>
						<div class="payment-order-list">
							<ul>
								<li class="clearfix">
									<span class="hd">订单号：</span>
									<div class="bd">{$order['ordersn']}</div>
								</li>
								<li class="clearfix">
									<span class="hd">产品名称：</span>
									<div class="bd">{$order['productname']}</div>
								</li>
								<li class="clearfix">
									<span class="hd">产品编号：</span>
									<div class="bd">{$order['series_number']}</div>
								</li>
								<li class="clearfix">
									<span class="hd">提交时间：</span>
									<div class="bd">{date('Y年m月d日 H:i:s',$order['addtime'])}</div>
								</li>
								<li class="clearfix">
									<span class="hd">预订方式：</span>
									<div class="bd">{if $order['paytype']==2}定金预订<i class="des">（该产品您选择的定金预定方式，本次支付为定金部分。请到店或通过个人中心尾款订单，完成尾款支付。）</i>{else}全款预订{/if}</div>
								</li>
								<li class="clearfix">
									<span class="hd">应付金额：</span>
									<div class="bd"><em>{Currency_Tool::symbol()}{$order['single_pay_price']}</em></div>
								</li>
							</ul>
                            {if !empty($additional)}
                                {loop $additional $sub}
                                <ul>

                                    <li class="clearfix">
                                        <span class="hd">订单号：</span>
                                        <div class="bd">{$sub['ordersn']}</div>
                                    </li>
                                    <li class="clearfix">
                                        <span class="hd">产品名称：</span>
                                        <div class="bd">{$sub['productname']}</div>
                                    </li>
                                    <li class="clearfix">
                                        <span class="hd">预订方式：</span>
                                        <div class="bd">全款预订</div>
                                    </li>
                                    <li class="clearfix">
                                        <span class="hd">应付金额：</span>
                                        <div class="bd"><em>{Currency_Tool::symbol()}{$sub['pay_price']}</em></div>
                                    </li>
                                </ul>
                                {/loop}
                            {/if}
						</div>
					</div>
					<!-- 订单信息 -->
                    {if $order['status']!=0}
					<div class="payment-con-box">
						<h3 class="payment-tit">选择以下支付方式付款</h3>
						<div class="payment-con">
							<div class="payment-line payment-on">
                                {if ($order['pay_way']==1 || $order['pay_way'] == 3) && !empty($pay_method['online'])}
								<dl>
									<dt>线上支付</dt>
									<dd>
										<ul>
                                            {loop $pay_method['online'] $k $v}
                                                <li data-type="online" data="{$v['id']}" data-payurl="{$v['payurl']}" class="{if $v['selected']}active {/if}{if $n%5==0}mr_0{/if}" >
                                                    <span><img src="{$v['litpic']}" /></span>
                                                </li>
                                            {/loop}

										</ul>

									</dd>
								</dl>
                                {/if}
								{if ($order['pay_way']==2 || $order['pay_way']==3) && !empty($pay_method['offline'])}

								<dl>
									<dt>线下支付</dt>
									<dd>
										<ul>
                                            {loop $pay_method['offline'] $k $v}
											<li data-type="offline" data-payurl="{$v['payurl']}" data="ordersn={$order['ordersn']}&method={$v['id']}"><span><img src="/uploads/payset/6.png" /></span></li>
                                            {/loop}
										</ul>
										<div class="pay-info">
                                            {Common::C('cfg_pay_xianxia')}
										</div>
									</dd>
								</dl>

                                {/if}
							</div>

							 <div class="payment-now-btn"><a href="javascript:;" id="st-payment-submit">{if $order['pay_way']!=2}立即支付{else}提交预定{/if}</a></div>
						</div>

					</div>
					<!--全额支付-->
                    {else}
                    <div class="payment-con-box">
                        <h3 class="payment-tit">预定提示</h3>
                        <div class="payment-con">
                            <p class="free-txt">您预定的产品需要平台管理审核。审核通过之后，请到订单中心查看并完成付款！</p>
                            <div class="payment-dd-btn"><a href="/member/order/all">查看订单</a></div>
                        </div>
                    </div>
                    {/if}
				</div>
			</div>

		</div>
	</div>

	<div class="st-payment-back-box" id="st-payment-back-box" style="display: none;">
		<div class="st-back-con">
			<h3>支付反馈<i class="close-button"></i></h3>
			<div class="payment-ts-con">
				<div class="payment-opp">
                    <a href="/member/order/view?ordersn={$order['ordersn']}" target="_blank">
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
   {$footer}

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
                ordersn:"{$order['ordersn']}",
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
