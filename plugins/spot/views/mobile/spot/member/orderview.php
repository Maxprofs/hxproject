<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>订单-{$info['ordersn']}</title>
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    {Common::css('base.css,mobilebone.css,style-new.css')}
    {Common::css_plugin('order.css','spot')}
    {Common::js('jquery.min.js,lib-flexible.js,jquery.layer.js,validate.js,layer/layer.m.js')}
</head>
<body>
{request "pub/header_new/typeid/$typeid/isordershow/1"}
<!-- 公用顶部 -->
<div class="page-content">

    <div class="order-show-item">
        <div class="order-tip-info">
            <p class="num">订单编号：{$info['ordersn']}</p>
            <p class="num">预订时间：{date('Y-m-d H:i',$info['addtime'])}</p>
            <span class="status">{$info['statusname']}</span>
        </div>
    </div>
    <!-- 订单编号、时间 -->
    {if !empty($info['eticketno']) && Product::is_app_install('stourwebcms_app_supplierverifyorder') && in_array($info['status'],array(2,5))}
    <div class="order-show-item">
        <div class="order-code-info">
            <img class="code-img" src="//{$GLOBALS['main_host']}/res/vendor/qrcode/make.php?param={$info['eticketno']}" />
            <div class="code-num">消费码：{$info['eticketno']}</div>
        </div>
    </div>
    <!--消费码-->
    {/if}

    <div class="order-show-item">
        <div class="order-pdt-info">
            <a class="pdt-info-tw" href="javascript:void(0)">
                <div class="pic"><img src="{Common::img($product['litpic'],194,132)}" title="{$product['title']}" alt="{$product['title']}"></div>
                <div class="con">{$product['title']}</div>
            </a>
            <ul class="pdt-info-list">
                <li>
                    <span class="type">预订方式</span>
                    <span class="data">{$info['paytype_name']}</span>
                </li>
                <li>
                    <span class="type">使用时间</span>
                    <span class="data">{$info['usedate']}</span>
                </li>
            </ul>
        </div>
    </div>
    <!--产品详情-->

    <div class="order-show-item">
        <div class="order-pdt-info">
            <div class="order-tc-bar">
                <div class="hd">
                    {$info['productname']}x{$info['dingnum']}
                </div>
                <div class="pri">{Currency_Tool::symbol()}{$info['price']}</div>
            </div>
            <div class="line-dashed"></div>
            {if !empty($info['iscoupon']) || $info['usejifen']}
            <ul class="pdt-info-list">
                {if !empty($info['iscoupon'])}
                <li>
                    <span class="type">优惠券<em>（{$info['iscoupon']['name']}）</em></span>
                    <span class="data">-{Currency_Tool::symbol()}{$info['iscoupon']['cmoney']}</span>
                </li>
                {/if}
                {if $info['usejifen']}
                <li>
                    <span class="type">积分抵现<em>（使用{$info['needjifen']}积分抵扣）</em></span>
                    <span class="data">-{Currency_Tool::symbol()}{$info['jifentprice']}</span>
                </li>
                {/if}
                {if $info['platform_discount']}
                <li>
                    <span class="type">平台优惠<em>（平台管理员优惠）</em></span>
                    <span class="data">-{Currency_Tool::symbol()}{$info['platform_discount']}</span>
                </li>
                {/if}
            </ul>
            {/if}
            <div class="line"></div>
            <div class="pdt-info-total">
                <span>{if $info['paytype']==2}应付定金{else}应付总额{/if}</span>
                <span>{Currency_Tool::symbol()}{$info['actual_price']}</span>
            </div>
            {if $info['paytype']==2}
            <div class="pdt-info-total">
                <p class="txt">在线支付(定金){Currency_Tool::symbol()}{$info['payprice']}+到店支付{Currency_Tool::symbol()}{php}echo $info['actual_price']-$info['payprice']; {/php}</p>
            </div>
            {/if}
        </div>
    </div>
    <!--产品详情-->

    <div class="order-show-item">
        <ul class="order-link-man-info">
            <li>
                <span class="item-hd">联系人：</span>
                <div class="item-bd">{$info['linkman']}</div>
            </li>
            <li>
                <span class="item-hd">联系电话：</span>
                <div class="item-bd">{$info['linktel']}</div>
            </li>
            {if !empty($info['linkemail'])}
            <li>
                <span class="item-hd">电子邮箱：</span>
                <div class="item-bd">{$info['linkemail']}</div>
            </li>
            {/if}
            {if !empty($info['remark'])}
            <li>
                <span class="item-hd">其它备注：</span>
                <div class="item-bd">
                    {$info['remark']}
                </div>
            </li>
            {/if}
        </ul>
    </div>
    <!--联系人-->
    {st:member action="order_tourer" orderid="$info['id']" return="tourer"}
    {if !empty($tourer)}
    <div class="order-show-item" id="visitor-console">
        <div class="order-user-info-bar">
            <span class="hd">游客信息</span>
            <span class="bd">{count($tourer)}个<i class="more-icon"></i></span>
        </div>
    </div>
    <!--游客信息-->
    {/if}
    {st:member action="order_bill" orderid="$info['id']" return="bill"}
    {if !empty($bill)}.
    <div class="order-show-item" id="invoice-console">
        <div class="order-user-info-bar">
            <span class="hd">发票信息</span>
            <span class="bd">有<i class="more-icon"></i></span>
        </div>
    </div>
    {/if}
    <div class="order-show-item">
        <a href="javascript:void(0)">
            <div class="order-user-info-bar">
                <span class="hd">支付方式</span>
                <span class="bd">{if !empty($info['online_transaction_no'])}线上支付{else}线下支付{/if}<i class="more-icon" style="display: none;"></i></span>
            </div>
        </a>
    </div>
    <!--支付信息-->
    {if $info['refund']}
    <div class="order-show-item">
        <a href="#orderRefundInfo">
            <div class="order-user-info-bar">
                <span class="hd">退款信息</span>
                <span class="bd"><i class="more-icon"></i></span>
            </div>
        </a>
    </div>
    <!--退款信息-->
    {/if}

    <div class="order-fix-item-bar">
        <div class="order-fix-total-bar">
            <span class="price">{if $info['paytype']==2}定金支付{else}应付总额{/if}：<em class="num">{Currency_Tool::symbol()}{$info['payprice']}</em></span>
            <span class="btn-block">
                {if $info['status']=='0'}
                <a href="javascript:;" class="btn btn-grey cancel_btn">取消订单</a>
                {/if}
                {if $info['status']=='1'}
                <a href="javascript:;" class="btn btn-grey cancel_btn">取消订单</a>
                <a href= "{Common::get_main_host()}/payment/?ordersn={$info['ordersn']}" class="btn btn-red pay_btn">立即付款</a>
                {/if}
                {if $info['status']=='2'&&$info['refund_restriction']!=1}
                <a href="{$cmsurl}spots/member/order_refund?ordersn={$info['ordersn']}" data-ajax="false" class="btn btn-blue refund_btn">申请退款</a>
                {/if}
                {if $info['status']=='3'}
                <a href="javascript:;" class="btn btn-grey">已取消</a>
                {/if}
                {if $info['status']==5 && $info['ispinlun']!=1}
                <a href="{$cmsurl}member#&{$cmsurl}member/comment/index?id={$info['id']}" class="btn btn-orange comment_btn">立即评价</a>
                {/if}
                {if $info['status']==6}
                <a href="javascript:;" class="btn cancel-refund refund_cancel_btn">取消退款</a>
                {/if}
            </span>
        </div>
    </div>

</div>
{if $info['status']==2}
<div id="orderRefund" class="page out hide">
    <div class="header_top bar-nav">
        <a class="back-link-icon" href="#myOrder" data-rel="back"></a>
        <h1 class="page-title-bar">退款申请</h1>
    </div>
    <!-- 公用顶部 -->
    <div class="page-content">
        <div class="refund-content">
            <div class="refund-box">
                <h3 class="tit">请填写退款原因（必填）</h3>
                <textarea name="reason" class="txt" placeholder="请填写退款原因（必填）"></textarea>
            </div>
            <div class="refund-btn-bar">
                <a href="javascript:;" class="y-btn refund_submit">确认退款</a>
                <a href="javascript:;" class="n-btn refund_no">暂不退款</a>
            </div>
        </div>
    </div>
</div>
{/if}
{if $info['refund']}
<div class="page out" id="orderRefundInfo">

    <div class="order-show-item">
        <ul class="order-link-man-info">
            <li>
                <span class="item-hd">退款方式：</span>
                <div class="item-bd">{$info['refund']['platform']}</div>
            </li>
            {if $info['refund']['alipay_account']}
            <li>
                <span class="item-hd">退款账号：</span>
                <div class="item-bd">{$info['refund']['alipay_account']}</div>
            </li>
            {/if}
            {if $info['refund']['cardholder']}
            <li>
                <span class="item-hd">持卡人：</span>
                <div class="item-bd">{$info['refund']['cardholder']}</div>
            </li>
            {/if}
            {if $info['refund']['bank']}
            <li>
                <span class="item-hd">开户行：</span>
                <div class="item-bd">{$info['refund']['bank']}</div>
            </li>
            {/if}
            {if $info['refund']['cardnum']}
            <li>
                <span class="item-hd">银行卡号：</span>
                <div class="item-bd">{$info['refund']['cardnum']}</div>
            </li>
            {/if}

            <li>
                <span class="item-hd">退款金额：</span>
                <div class="item-bd" style="color: #ff6b1a">{Currency_Tool::symbol()}{$info['refund']['refund_fee']}</div>
            </li>
            <li>
                <span class="item-hd">退款原因：</span>
                <div class="item-bd">{if $info['refund']['refund_reason']}{$info['refund']['refund_reason']}{else}无{/if}</div>
            </li>
            {if $info['refund']['description']}
            <li>
                <span class="item-hd">处理结果：</span>
                <div class="item-bd">{$info['refund']['description']}</div>
            </li>
            {/if}
        </ul>
    </div>
</div>
{/if}
{if !empty($tourer)}
<div id="visitor-info" class="layer-container">
    <div class="layer-wrap">
        <div class="layer-tit"><strong class="bt">旅客信息</strong><i class="close-ico"></i></div>
        <div class="layer-block-con">
            <div class="visitor-table">
                <ul>
                    {loop $tourer  $k $t}
                    <li>
                        <p>旅客{$k+1}：{if $t['tourername']}{$t['tourername']}{if $t['sex']}（{$t['sex']}）{/if}{/if}</p>
                        {if $t['cardnumber']}
                        <p>{$t['cardtype']}： {$t['cardnumber']}</p>
                        {/if}
                    </li>
                    {/loop}
                </ul>
            </div>
        </div>
    </div>
</div>
<!--旅客信息弹框-->
{/if}


<script>
    var CURRENCY_SYMBOL="{Currency_Tool::symbol()}";
    var SITEURL="{URL::site()}";
    var ordersn="{$info['ordersn']}"
    var orderid="{$info['id']}";
    $(document).ready(function(){
        //查看游客信息
        $("#visitor-console").on("click",function(){
            $("#visitor-info").show();
        });
        //关闭游客信息
        $("#visitor-info .close-ico").on("click",function(){
            $("#visitor-info").hide();
        })

        $("#invoice-console").on("click",function(){
            $("#invoice-info").show();
        });
        $("#invoice-info .close-ico,#invoice-info").on("click",function(){
            $("#invoice-info").hide();
        });


        $(".cancel_btn").click(function(){

            var url = SITEURL +'spots/member/ajax_order_cancel';
            $.layer({
                type:3,
                text:'确定取消订单？',
                ok:function(){
                    $.ajax({
                        type: 'GET',
                        url: url,
                        data: {orderid:orderid},
                        dataType: 'json',
                        success: function (data) {
                            if(data.status)
                            {
                                window.location.reload();
                            }
                            //$("#startdate_con").html(data);
                        }
                    });
                }
            });
        });




        {if $info['status']==6}
        $('.refund_cancel_btn').click(function () {

            layer.open({
                content: '您确定要取消退款吗？'
                ,btn: ['确定', '取消']
                ,yes: function(index){
                    $.post(SITEURL+'spots/member/ajax_order_refund_back', {ordersn:ordersn}, function (result) {
                        parent.layer.open({
                            content: result.message,
                            btn: ['{__("OK")}'],
                            end:function(){
                                window.location.reload();
                            }
                        });
                    }, 'json');
                }
            });

        });
        {/if}
    });






</script>

</body>
</html>