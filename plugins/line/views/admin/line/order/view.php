<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>查看订单</title>
    {include 'stourtravel/public/public_min_js'}
    {Common::getScript("jquery.validate.js,choose.js,jquery.upload.js")}
    {Common::getCss('style.css,base.css,base_new.css,lightbox.min.css,order.show.css')}
    <script>
        window.CURRENCY_SYMBOL="{Currency_Tool::symbol()}";
    </script>
</head>
<body>
<table class="content-tab">
    <tr>
        <td width="119px" class="content-lt-td"  valign="top">
            {template 'stourtravel/public/leftnav'}
            <!--右侧内容区-->
        </td>
        <td valign="top" class="content-rt-td" style="overflow-y: hidden">
            <div class="cfg-header-bar clearfix">
                <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
            </div>
            <form method="post" id="frm" name="frm">
                <div class="order-show-container pd-10">

                    <div class="order-show-wrap mb-10">
                        <div class="order-show-bar">
                            <span class="order-bar-tit c-primary">订单信息</span>
                        </div>
                        <div class="order-show-block">
                            <ul class="info-item-block">
                                <li>
                                    <span class="item-hd">订单编号：</span>
                                    <div class="item-bd">
                                        <span class="item-text c-666">{$info['ordersn']}</span>
                                    </div>
                                </li>
                                <li>
                                    <span class="item-hd">下单时间：</span>
                                    <div class="item-bd">
                                        <span class="item-text c-666">{date('Y-m-d H:i:s',$info['addtime'])}</span>
                                    </div>
                                </li>
                                <li>
                                    <span class="item-hd">订单状态：</span>
                                    <div class="item-bd">
                                        <span class="item-text c-666">{$current_status['status_name']}</span>
                                        {if $info['status'] == 1 && $info['auto_close_time']}
                                        <span class="item-text c-999 ml-10">{date('Y-m-d H:i:s',$info['auto_close_time'])}超时</span>
                                        {/if}
                                    </div>
                                </li>

                                <li>
                                    <span class="item-hd">订单来源：</span>
                                    <div class="item-bd">
                                        <span class="item-text c-666">{php echo Model_Member_Order::$order_source[$info['source']];}</span>
                                    </div>
                                </li>
	                            {if $info['eticketno']}
	                            <li>
		                            <span class="item-hd">消费码：</span>
		                            <div class="item-bd">
			                            <span class="item-text c-666">{$info['eticketno']}</span>
		                            </div>
	                            </li>
	                            {/if}
                                <li>
                                    <span class="item-hd">业务员：</span>
                                    <div class="item-bd">
                            <span class="select-box w150">

                                <select class="select" name="saleman">
                                    <option value="">请选择</option>
                                    {loop $saleman $man}
                                        {if $man['username']!='root'}
                                      <option value="{$man['username']}" {if $info['saleman'] == $man['username']}selected="selected"{/if}>{$man['username']}</option>
                                        {/if}
                                    {/loop}

                                </select>
                            </span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- 订单信息 -->

                    <div class="order-show-wrap mb-10">
                        <div class="order-show-bar">
                            <span class="order-bar-tit c-primary">预定信息</span>
                        </div>
                        <div class="order-show-block">
                            <ul class="info-item-block">
                                <li>
                                    <span class="item-hd">预订产品：</span>
                                    <div class="item-bd">
                                        <span class="item-text c-666">{$info['productname']}</span>
                                    </div>
                                </li>

                                <li>
                                    <span class="item-hd">供应商：</span>
                                    <div class="item-bd">
                                        {if empty($supplier)}
                                            <span class="item-text c-666">平台自营</span>
                                        {else}
                                            <span class="item-text c-666">{$supplier['suppliername']}</span>
                                        {/if}

                                    </div>
                                </li>
                                <li>
                                    <span class="item-hd">预订方式：</span>
                                    <div class="item-bd">
                                        <span class="item-text c-666">{if $info['paytype']==1}全款预定{else}定金预定{/if}</span>
                                    </div>
                                </li>
                                <li>
                                    <span class="item-hd">预订会员：</span>
                                    <div class="item-bd">
                                        <span class="item-text c-666">{$info['membername']}</span>
                                    </div>
                                </li>
                                <li>
                                    <span class="item-hd">出发时间：</span>
                                    <div class="item-bd">
                                        <span class="item-text c-666">{$info['usedate']}</span>
                                    </div>
                                </li>
                                <li>
                                    <span class="item-hd">价格明细：</span>
                                    <div class="item-bd">
                                        <table class="table table-border table-bordered table-bg table-order w600">
                                            <thead>
                                            <tr class="text-c">
                                                <th><span class="c-999">类别</span></th>
                                                <th><span class="c-999">单价</span></th>
                                                <th><span class="c-999">数量</span></th>
                                                <th><span class="c-999">小计</span></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            {if $info['dingnum']}
                                            <tr class="text-c">
                                                <td>
                                                    <span class="c-999">成人</span>
                                                </td>
                                                <td>
                                                    <span class="c-999">{Currency_Tool::symbol()}{$info['price']}</span>
                                                </td>
                                                <td>
                                                    <span class="c-999">{$info['dingnum']}</span>
                                                </td>
                                                <td>
                                                    <span class="c-f60">{Currency_Tool::symbol()}{php echo $info['dingnum']*$info['price'];}</span>
                                                </td>
                                            </tr>
                                            {/if}
                                            {if $info['oldnum']}
                                            <tr class="text-c">
                                                <td>
                                                    <span class="c-999">老人</span>
                                                </td>
                                                <td>
                                                    <span class="c-999">{Currency_Tool::symbol()}{$info['oldprice']}</span>
                                                </td>
                                                <td>
                                                    <span class="c-999">{$info['oldnum']}</span>
                                                </td>
                                                <td>
                                                    <span class="c-f60">{Currency_Tool::symbol()}{php echo $info['oldnum']*$info['oldprice'];}</span>
                                                </td>
                                            </tr>
                                            {/if}
                                            {if $info['childnum']}
                                            <tr class="text-c">
                                                <td>
                                                    <span class="c-999">儿童</span>
                                                </td>
                                                <td>
                                                    <span class="c-999">{Currency_Tool::symbol()}{$info['childprice']}</span>
                                                </td>
                                                <td>
                                                    <span class="c-999">{$info['childnum']}</span>
                                                </td>
                                                <td>
                                                    <span class="c-f60">{Currency_Tool::symbol()}{php echo $info['childnum']*$info['childprice'];}</span>
                                                </td>
                                            </tr>
                                            {/if}
                                            {if $info['roombalancenum']}
                                            <tr class="text-c">
                                                <td>
                                                    <span class="c-999">单房差</span>
                                                </td>
                                                <td>
                                                    <span class="c-999">{Currency_Tool::symbol()}{$info['roombalance']}</span>
                                                </td>
                                                <td>
                                                    <span class="c-999">{$info['roombalancenum']}</span>
                                                </td>
                                                <td>
                                                    <span class="c-f60">{Currency_Tool::symbol()}{php echo $info['roombalancenum']*$info['roombalance'];}</span>
                                                </td>
                                            </tr>
                                            {/if}
                                            </tbody>
                                        </table>
                                    </div>
                                </li>
                                {if !empty($additional)}
                                 <li class="mt-10">
                                    <span class="item-hd">保险信息：</span>
                                    <div class="item-bd">
                                        <table class="table table-border table-bordered table-bg table-order w600">
                                            <thead>
                                            <tr class="text-c">
                                                <th><span class="c-999">名称</span></th>
                                                <th><span class="c-999">单价</span></th>
                                                <th><span class="c-999">数量</span></th>
                                                <th><span class="c-999">小计</span></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            {loop $additional $sub}

                                            <tr class="text-c">
                                                <td>
                                                    <span class="c-999">{$sub['productname']}</span>
                                                </td>
                                                <td>
                                                    <span class="c-999">{Currency_Tool::symbol()}{$sub['price']}</span>
                                                </td>
                                                <td>
                                                    <span class="c-999">{$sub['dingnum']}</span>
                                                </td>
                                                <td>
                                                    <span class="c-f60">{Currency_Tool::symbol()}{php echo $sub['dingnum']*$sub['price'];}</span>
                                                </td>
                                            </tr>
                                            {/loop}

                                            </tbody>
                                        </table>
                                    </div>
                                </li>
                                {/if}
                            </ul>
                        </div>
                    </div>
                    <!-- 预定信息 -->

                    <div class="order-show-wrap mb-10">
                        <div class="order-show-bar">
                            <span class="order-bar-tit c-primary">联系信息</span>
                        </div>
                        <div class="order-show-block">
                            <ul class="info-item-block">
                                <li>
                                    <span class="item-hd">姓名：</span>
                                    <div class="item-bd">
                                        <span class="item-text c-666">{$info['linkman']}</span>
                                    </div>
                                </li>
                                <li>
                                    <span class="item-hd">手机号码：</span>
                                    <div class="item-bd">
                                        <span class="item-text c-666">{$info['linktel']}</span>
                                    </div>
                                </li>
                                {if $info['linkemail']}
                                <li>
                                    <span class="item-hd">电子邮箱：</span>
                                    <div class="item-bd">
                                        <span class="item-text c-666">{$info['linkemail']}</span>
                                    </div>
                                </li>
                                {/if}
                                {if $info['remark']}
                                <li>
                                    <span class="item-hd">预订备注：</span>
                                    <div class="item-bd">
                                        <div class="item-section mt-4 c-666">
                                            {$info['remark']}
                                        </div>
                                    </div>
                                </li>
                                {/if}
                            </ul>
                        </div>
                    </div>
                    <!-- 联系信息 -->
                    {if !empty($tourers)}
                    <div class="order-show-wrap mb-10">
                        <div class="order-show-bar">
                            <span class="order-bar-tit c-primary">旅客信息</span>
                        </div>

                        <div class="order-show-block">
                            <ul class="info-item-block">
                                <li>
                                    <span class="item-hd">旅客名单：</span>
                                    <div class="item-bd">
                                        <table class="table table-border table-bordered table-bg table-order w900">
                                            <thead>
                                            <tr class="text-c">
                                                <th>姓名</th>
                                                <th>性别</th>
                                                <th>手机号</th>
                                                <th>证件类型</th>
                                                <th>证件号码</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            {loop $tourers $t}
                                             <tr class="text-c">
                                                <td><span class="c-666">{$t['tourername']}</span></td>
                                                <td><span class="c-666">{$t['sex']}</span></td>
                                                <td><span class="c-666">{$t['mobile']}</span></td>
                                                <td><span class="c-666">{$t['cardtype']}</span></td>
                                                <td><span class="c-666">{$t['cardnumber']}</span></td>
                                            </tr>
                                            {/loop}
                                            </tbody>
                                        </table>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- 旅客信息 -->
                    {/if}

                    <div class="order-show-wrap mb-10">
                        <div class="order-show-bar">
                            <span class="order-bar-tit c-primary">优惠信息</span>
                        </div>

                        <div class="order-show-block">
                            <ul class="info-item-block">
                                {if $info['cmoney']}
                                <li>
                                    <span class="item-hd">优惠券：</span>
                                    <div class="item-bd">
                                        <span class="item-text c-666">(优惠券抵扣)<span class="c-f60">-{Currency_Tool::symbol()}{$info['cmoney']}</span></span>
                                    </div>
                                </li>
                                {/if}
                                {if $info['usejifen']}
                                <li>
                                    <span class="item-hd">积分抵现：</span>
                                    <div class="item-bd">
                                        <span class="item-text c-666">(积分抵扣)<span class="c-f60">-{Currency_Tool::symbol()}{$info['jifentprice']}</span></span>
                                    </div>
                                </li>
                                {/if}
                                {if $info['envelope_price']}
                                <li>
                                    <span class="item-hd">红包优惠：</span>
                                    <div class="item-bd">
                                        <span class="item-text c-666">(红包抵扣)<span class="c-f60">-{Currency_Tool::symbol()}{$info['envelope_price']}</span></span>
                                    </div>
                                </li>
                                {/if}
                                <!--定金支付不享受线上优惠政策-->
                                {if $info['dingjin']==0}
                                <li>
                                    <span class="item-hd">平台优惠：</span>
                                    <div class="item-bd">
                                        <span class="item-text c-666">(平台管理员优惠)
                                            <span class="c-f60">{if $info['status'] =='1'}-{Currency_Tool::symbol()}
                                                <input type="text" class="input-text w100 ml-10" name="platform_discount" id="platform_discount"  maxlength="5" placeholder="输入优惠金额"
                                                       value="{intval($info['platform_discount'])}">{else}-{Currency_Tool::symbol()}{intval($info['platform_discount'])}{/if}
                                            </span>
                                        </span>
                                    </div>
                                </li>
                                {/if}

                            </ul>
                        </div>
                    </div>
                    <!-- 优惠信息 -->

                    {if $info['contract']}
                    <div class="order-show-wrap mb-10">
                        <div class="order-show-bar">
                            <span class="order-bar-tit c-primary">合同信息</span>
                        </div>
                        <div class="order-show-block">
                            <ul class="info-item-block">
                                <li>
                                    <span class="item-hd">合同名称：</span>
                                    <div class="item-bd">
                                        <a href="javascript:;" class="item-text btn-link" onclick="showContract('{$info['ordersn']}')">{$info['contract']['title']}</a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- 合同信息 -->
                    {/if}
                    {if !empty($bill)}
                    <div class="order-show-wrap mb-10">
                        <div class="order-show-bar">
                            <span class="order-bar-tit c-primary">发票信息</span>
                        </div>
                        <div class="order-show-block">
                            <ul class="info-item-block">
                                <li>
                                    <span class="item-hd">发票金额：</span>
                                    <div class="item-bd">
                                        <span class="item-text c-666">{Currency_Tool::symbol()}{$info['totalprice']}</span>
                                    </div>
                                </li>
                                <li>
                                    <span class="item-hd">发票明细：</span>
                                    <div class="item-bd">
                                        <span class="item-text c-666">旅游费</span>
                                    </div>
                                </li>
                                <li>
                                    <span class="item-hd">发票抬头：</span>
                                    <div class="item-bd">
                                        <span class="item-text c-666">{$bill['title']}</span>
                                    </div>
                                </li>
                                <li>
                                    <span class="item-hd">收件人：</span>
                                    <div class="item-bd">
                                        <span class="item-text c-666">{$bill['receiver']}</span>
                                    </div>
                                </li>
                                <li>
                                    <span class="item-hd">手机号码：</span>
                                    <div class="item-bd">
                                        <span class="item-text c-666">{$bill['mobile']}</span>
                                    </div>
                                </li>
                                <li>
                                    <span class="item-hd">邮寄地址：</span>
                                    <div class="item-bd">
                                        <span class="item-text c-666">{$bill['province']} {$bill['city']} {$bill['address']}</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- 发票信息 -->
                    {/if}

                    {if !empty($info['paytime']) && $info['pay_price']>0}
                    <div class="order-show-wrap mb-10">
                        <div class="order-show-bar">
                            <span class="order-bar-tit c-primary">支付信息</span>
                        </div>
                        <div class="order-show-block">
                            <ul class="info-item-block">
                                <li>
                                    <span class="item-hd">支付方式：</span>
                                    <div class="item-bd">
                                        {if !empty($info['online_transaction_no'])}
                                            <span class="item-text c-666">线上支付</span>
                                        {else}
                                            <span class="item-text c-666">线下支付</span>
                                        {/if}
                                    </div>
                                </li>
                                {if !empty($info['paysource'])}
                                <li>
                                    <span class="item-hd">支付渠道：</span>
                                    <div class="item-bd">
                                        <span class="item-text c-666">{$info['paysource']}</span>
                                    </div>
                                </li>
                                {/if}
                                {if !empty($info['online_transaction_no'])}
                                <li>
                                    {php}
                                       $trade = json_decode($info['online_transaction_no'],true);

                                    {/php}
                                    <span class="item-hd">流水号：</span>
                                    <div class="item-bd">
                                        <span class="item-text c-666">{$trade['transaction_no']}</span>
                                    </div>
                                </li>
                                {/if}
                                {if !empty($info['payment_proof'])}
                                <li>
                                    <span class="item-hd">支付凭证：</span>
                                    <div class="item-bd">
                                        <div class="mt-10">
                                            <a href="{$info['payment_proof']}" rel="lightbox">
                                                <img id="payProofImg3" src="{$info['payment_proof']}" class="up-img-area" />
                                            </a>
                                        </div>
                                    </div>
                                </li>
                                {/if}
                                <li>
                                    <span class="item-hd">支付时间：</span>
                                    <div class="item-bd">
                                        <span class="item-text c-666">{date('Y-m-d H:i:s',$info['paytime'])}</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- 支付信息 -->
                    {/if}

                    {if $info['refund']}
                    <div class="order-show-wrap mb-10">
                        <div class="order-show-bar">
                            <span class="order-bar-tit c-primary">退款信息</span>
                        </div>
                        <div class="order-show-block">
                            <ul class="info-item-block">
                                <li>
                                    <span class="item-hd">退款方式：</span>
                                    <div class="item-bd">
                                        <span class="item-text c-666">{$info['refund']['platform']}</span>
                                    </div>
                                </li>
                                {if $info['refund']['alipay_account']}
                                <li>
                                    <span class="item-hd">退款账号：</span>
                                    <div class="item-bd">
                                        <span class="item-text c-666">{$info['refund']['alipay_account']}</span>
                                    </div>
                                </li>
                                {/if}
                                {if $info['refund']['cardholder']}
                                <li>
                                    <span class="item-hd">持卡人：</span>
                                    <div class="item-bd">
                                        <span class="item-text c-666">{$info['refund']['cardholder']}</span>
                                    </div>
                                </li>
                                {/if}
                                {if $info['refund']['bank']}
                                <li>
                                    <span class="item-hd">开户行：</span>
                                    <div class="item-bd">
                                        <span class="item-text c-666">{$info['refund']['bank']}</span>
                                    </div>
                                </li>
                                {/if}

                                {if $info['refund']['cardnum']}
                                <li>
                                    <span class="item-hd">银行卡号：</span>
                                    <div class="item-bd">
                                        <span class="item-text c-666">{$info['refund']['cardnum']}</span>
                                    </div>
                                </li>
                                {/if}

                                <li>
                                    <span class="item-hd">退款金额：</span>
                                    <div class="item-bd">
                                        <span class="item-text c-f60">{$info['refund']['refund_fee']}</span>
                                    </div>
                                </li>
                                <li>
                                    <span class="item-hd">申请时间：</span>
                                    <div class="item-bd">
                                        <span class="item-text">{date('Y-m-d H:i:s',$info['refund']['addtime'])}</span>
                                    </div>
                                </li>
                                <li>
                                    <span class="item-hd">退款原因：</span>
                                    <div class="item-bd">
                                        <span class="item-text c-666">{$info['refund']['refund_reason']}</span>
                                    </div>
                                </li>
                                {if $info['refund']['status'] == 1}
                                    <li>
                                        <span class="item-hd">退款时间：</span>
                                        <div class="item-bd">
                                            <span class="item-text c-666">{date('Y-m-d H:i:s',$info['refund']['modtime'])}</span>
                                        </div>
                                    </li>
                                {/if}
                                {if $info['refund']['refund_proof']}
                                <li>
                                    <span class="item-hd">退款凭证：</span>
                                    <div class="item-bd">
                                        <div class="mt-10">
                                            <a href="{$info['refund']['refund_proof']}" rel="lightbox">
                                                <img id="payProofImg4" src="{$info['refund']['refund_proof']}" class="up-img-area" />
                                            </a>
                                        </div>
                                    </div>
                                </li>
                                {/if}
                                {if $info['refund']['description']}
                                <li>
                                    <span class="item-hd">处理结果：</span>
                                    <div class="item-bd">
                                        <span class="item-text c-666">{$info['refund']['description']}</span>
                                    </div>
                                </li>
                                {/if}
                            </ul>
                        </div>
                    </div>
                    <!-- 退款信息 -->
                    {/if}


                    <div class="total-block-bar mb-10">
                        <div class="order-show-block">
                            <ul class="info-item-block">
                                <li>
                                    <span class="item-hd">预订总额：</span>
                                    <div class="item-bd">
                                        <span class="item-text c-666">{Currency_Tool::symbol()}{$info['totalprice']}</span>
                                    </div>
                                </li>
                                <li>
                                    <span class="item-hd">优惠总额：</span>
                                    <div class="item-bd">
                                        <span class="item-text c-666">-{Currency_Tool::symbol()}{$info['privileg_price']}</span>
                                    </div>
                                </li>
                                <li>
                                    <strong class="item-hd f-14">{if $info['paytype']==1}应付总额：{else}应付定金：{/if}</strong>
                                    <div class="item-bd">
                                        <strong class="item-text c-f60 f-16">{Currency_Tool::symbol()}{$info['pay_price']}</strong>
                                        {if $info['jifenbook']}
                                        <span class="item-text c-999 ml-20">赠送积分{$info['jifenbook']}</span>
                                        {/if}
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- 结算 -->

                    <div class="order-show-wrap">
                        <div class="order-show-block">
                            <ul class="info-item-block">
                                {if !empty($supplier)}
                                <li>
                                    <span class="item-hd">供应商收益：</span>
                                    <div class="item-bd">
                                        <span class="item-text c-666">{Currency_Tool::symbol()}{$income['supplier_income']}</span>
                                    </div>
                                </li>
                                {/if}
                                <li>
                                    <span class="item-hd">平台分佣：</span>
                                    <div class="item-bd">
                                        <span class="item-text c-666">{Currency_Tool::symbol()}{$income['platform_commission']}</span>
                                    </div>
                                </li>
                                <li>
                                    <span class="item-hd">平台收益：</span>
                                    <div class="item-bd">
                                        <span class="item-text c-666">{Currency_Tool::symbol()}{$income['platform_income']}</span>
                                    </div>
                                </li>

                                {if !empty($fenxiao_info)}
                                {if isset($fenxiao_info['commission'])}
                                <li>
                                    <span class="item-hd">分销自购收益：</span>
                                    <div class="item-bd">
                                        <span class="item-text c-666">{Currency_Tool::symbol()}{$fenxiao_info['commission']}</span>
                                    </div>
                                </li>
                                {/if}
                                {if isset($fenxiao_info['commission1'])}
                                <li>
                                    <span class="item-hd">直属上级收益：</span>
                                    <div class="item-bd">
                                        <span class="item-text c-666">{Currency_Tool::symbol()}{$fenxiao_info['commission1']}</span>
                                    </div>
                                </li>
                                {/if}
                                {if isset($fenxiao_info['commission2'])}
                                <li>
                                    <span class="item-hd">二级上级收益：</span>
                                    <div class="item-bd">
                                        <span class="item-text c-666">{Currency_Tool::symbol()}{$fenxiao_info['commission2']}</span>
                                    </div>
                                </li>
                                {/if}
                                {if isset($fenxiao_info['commission3'])}
                                <li>
                                    <span class="item-hd">三级上级收益：</span>
                                    <div class="item-bd">
                                        <span class="item-text c-666">{Currency_Tool::symbol()}{$fenxiao_info['commission3']}</span>
                                    </div>
                                </li>
                                {/if}
                               {/if}
                            </ul>
                        </div>
                    </div>
                    <!-- 收益 -->

                    {if $info['close_reason'] && $info['status']==3}
                    <div class="order-show-wrap mb-10">

                        <div class="order-show-block">
                            <ul class="info-item-block">

                                <li>
                                    <span class="item-hd">关闭原因：</span>
                                    <div class="item-bd">
                                        <span class="item-text c-666">{$info['close_reason']}</span>
                                    </div>
                                </li>

                            </ul>
                        </div>
                    </div>
                    <!-- 取消原因 -->
                    {/if}

                    <div class="order-show-wrap mb-10">
                        {include "admin/line/order/status/status"}

                    </div>
                    <!-- 订单状态 -->

                    <div class="clear pb-20 mb-10 mt-20">
                        <input type="hidden" id="id" name="id" value="{$info['id']}">
                        <input type="hidden" id="typeid" name="typeid" value="{$typeid}">
                        <input type="hidden" id="is_pay_online" value="{$info['pay_online']}">
                        <a href="javascript:;" id="btn_save" class="btn btn-primary radius size-L ml-115">保存</a>
                        {if $info['status']==6 &&$info['pay_online']==1}
                        <a class="btn btn-warning size-L radius ml-5 va-m" id="refund_back" href="javascript:;">拒绝退款</a>
                        <a class="btn btn-success size-L radius ml-5 va-m" id="refund_allow" href="javascript:;">同意退款</a>
                        {/if}
                    </div>

                </div>
            </form>
        </td>
    </tr>
</table>
<div id="calendar" style="display: none"></div>
{Common::getScript("lightbox.min.js")}
<script>

    var oldstatus = "{$info['status']}";



    $(function(){



        //订单保存
        $("#btn_save").click(function(){
            var curstatus=$("#status_con input:radio:checked").val();

            if(curstatus!=oldstatus && curstatus!=undefined)
            {
                ST.Util.confirmBox("提示", "订单状态有改动，确定保存？", function () {
                    ajax_submit();
                });
            }
            else
            {
                ajax_submit();
            }
        });


        //同意退款
        $('#refund_allow').click(function () {

                ST.Util.confirmBox("退款提示", "退款金额会原路退回，确定同意退款？", function () {

                    refund_submit('allow','同意退款');
                });

        });
        //拒绝退款
        $('#refund_back').click(function () {
            ST.Util.confirmBox("拒绝退款", '<div class="pop-refund-back"><span class="hd-item">原因：</span><textarea class="bd-area" id="description"></textarea><div>', function () {
                var description = $("#description", window.parent.document).val();
                refund_submit('back',description);
            });

        })
        //
        $('#platform_discount').on('keyup change',function(){
            discountChange(this);
        })


    });

    //平台优惠修改
    function discountChange(obj){
        if($(obj).attr("data-event-processing") == "true"){
            return;
        }
        $(obj).attr("data-event-processing","true");

//        var inputvalue = obj.value.replace(/[^\d]/g,'');
        var value=obj.value;
        value = value.replace(/[^\d.]/g, "");//清除“数字”和“.”以外的字符
        value = value.replace(/^\./g, "");//验证第一个字符是数字而不是.
        value = value.replace(/\.{2,}/g, ".");//只保留第一个. 清除多余的.
        value = value.replace(".", "$#$").replace(/\./g, "").replace("$#$", ".");
        value = value.replace(/([0-9]+\.[0-9]{2})[0-9]*/,"$1");
        var inputvalue = value;

        //订单总额
        var total_price = "{$info['totalprice']}";
        //积分+优惠券总额
        var coupon = "{$info['cmoney']}";
        var jifentprice = "{$info['jifentprice']}";
        //平台分佣
        var platform_commission = "{$income['platform_commission']}";

        if(Number(platform_commission)>=Number(total_price)){
            platform_commission = total_price;
        }

        var discount = ST.Math.add(coupon,jifentprice);
        var platform_discount = Number(inputvalue);
        discount=ST.Math.add(platform_discount,discount);

        var pay_price = Number(platform_commission);
        if (discount > pay_price) {
            ST.Util.confirmBox("优惠金额确认", "全部优惠金额相加已大于平台收益，您确认要继续吗？",
                function () {
                    obj.value = inputvalue;
                    $(obj).attr("data-event-processing", "false");
                }, function () {
                    obj.value = 0;
                    $(obj).attr("data-event-processing", "false");
                }
            );
        } else {
            obj.value = inputvalue;
            $(obj).attr("data-event-processing", "false");
        }

    }

    //查看合同
    function showContract(id) {

        var url = SITEURL+'contract/admin/contract/order_view/ordersn/'+id;
        window.open(url)

    }


    function refund_submit(type,description) {
        var ordersn = '{$info['ordersn']}';
        $.ajax({
            url : SITEURL+"line/admin/order/ajax_refund_submit",
            type:'post',
            dataType:'json',
            data:{type:type,ordersn:ordersn,description:description},
            success : function(data)
            {
                if(data.status)
                {
                    ST.Util.showMsg('保存成功!','4',2000);
                    setTimeout(function(){
                        window.location.reload();
                    },1500)
                }
            }
        });
    }



    function ajax_submit() {
        $.ajaxform({
            url   :  SITEURL+"line/admin/order/ajax_save",
            method  :  "POST",
            form  : "#frm",
            dataType:'json',
            success  :  function(data)
            {
                if(data.status)
                {
                    ST.Util.showMsg('保存成功!','4',2000);
                    setTimeout(function(){
                        window.location.reload();
                    },1500)
                }else{

                    ST.Util.showMsg('保存失败,请确认是否修改了相关信息?',5,2000);
                    return false;
                }
            }
        })
    }


</script>
</body>
</html>