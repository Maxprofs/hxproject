<!doctype html>
<html>
<head body_color=4IPwnm >
    <meta charset="utf-8">
    <title>订单-{$info['ordersn']}</title>
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    {Common::css('base.css,mobilebone.css')}
    {Common::css_plugin('line-order-show.css','line')}
    {Common::js('jquery.min.js,lib-flexible.js,jquery.layer.js,validate.js,layer/layer.m.js,mobilebone.js')}
</head>
<body>
<div class="page" id="pageHome">
{request "pub/header_new/typeid/$typeid/isordershow/1"}
<!-- 公用顶部 -->
<div class="page-content">
<div class="order-show-item">
    <div class="order-tip-info">
        <p class="num">订单编号：{$info['ordersn']}</p>
        <p class="num">下单时间：{date('Y-m-d H:i',$info['addtime'])}</p>
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
{/if}
<!-- 二维码 -->

<div class="order-show-item">
    <div class="order-pdt-info">
        <a class="pdt-info-tw" href="{$product['url']}" data-ajax="false">
            <div class="pic"><img src="{Common::img($info['litpic'],194,132)}" title="" alt=""></div>
            <div class="con">
                <p class="name">{$product['title']}</p>

            </div>
        </a>
        <ul class="pdt-info-list">
            <li>
                <span class="type">预订套餐</span>
                <span class="data">{$info['suitname']}</span>
            </li>
            <li>
                <span class="type">预订方式</span>
                <span class="data">{if $info['paytype']==1}全额预订{elseif $info['paytype']==2}定金预订{else}二次确认{/if}</span>
            </li>
            <li>
                <span class="type">出发时间</span>
                <span class="data">{$info['usedate']}</span>
            </li>
        </ul>

    </div>
</div>
<div class="order-show-item">
    <div class="order-pdt-info">
        <ul class="pdt-info-list">
            {if !empty($info['price']) && !empty($info['dingnum'])}
            <li><span class="type">成人</span><span class="data">{Currency_Tool::symbol()}{$info['price']}×{$info['dingnum']}人</span></li>
            {/if}
            {if !empty($info['childprice']) && !empty($info['childnum'])}
            <li><span class="type">儿童</span><span class="data">{Currency_Tool::symbol()}{$info['childprice']}×{$info['childnum']}人</span></li>
            {/if}
            {if !empty($info['oldprice']) && !empty($info['oldnum'])}
            <li><span class="type">老人</span> <span class="data">{Currency_Tool::symbol()}{$info['oldprice']}×{$info['oldnum']}人</span></li>
            {/if}
            {if !empty($info['roombalancenum'])}
            <li><span class="type">单房差({if $info['roombalance_paytype']==1}预付{else}到店付{/if})</span> <span class="data">{Currency_Tool::symbol()}{$info['roombalance']}×{$info['roombalancenum']}间</span></li>
            {/if}
            {if $additional}
            {loop $additional $sub}
            <li><span class="type">{$sub['productname']}({$sub['usedate']})</span> <span class="data">{Currency_Tool::symbol()}{$sub['price']}×{$sub['dingnum']}</span></li>
            {/loop}
            {/if}
        </ul>
        {if !empty($info['iscoupon']) || $info['usejifen']||$info['envelope_price']||$info['platform_discount']}
        <ul class="pdt-info-list">
            {if !empty($info['iscoupon'])}
            <li><span class="type">优惠券</span><span class="data">{Currency_Tool::symbol()}{$info['iscoupon']['cmoney']}</span></li>
            {/if}
            {if $info['usejifen']}
            <li><span class="type">积分抵现</span><span class="data">{Currency_Tool::symbol()}{$info['jifentprice']}</span></li>
            {/if}
            {if $info['envelope_price']}
            <li><span class="type">红包抵扣</span><span class="data">{Currency_Tool::symbol()}{$info['envelope_price']}</span></li>
            {/if}
            {if $info['platform_discount']>0}
            <li><span class="type">平台优惠</span><span class="data">{Currency_Tool::symbol()}{$info['platform_discount']}</span></li>
            {/if}
        </ul>
        {/if}
        {if $info['paytype']==1}
        <div class="pdt-info-total">
            <span>应付总额</span>
            <span>{Currency_Tool::symbol()}{$info['payprice']}</span>
        </div>
        {/if}
        {if $info['paytype']==2}
        <div class="pdt-info-total">
            <p class="txt">在线支付(定金){Currency_Tool::symbol()}{$info['payprice']}+到店支付{Currency_Tool::symbol()}{php}echo $info['totalprice']-$info['payprice']; {/php}</p>
        </div>
        {/if}
    </div>
</div>
<!-- 产品详情 -->
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
        {if $info['linkemail']}
        <li>
            <span class="item-hd">电子邮箱：</span>
            <div class="item-bd">{$info['linkemail']}</div>
        </li>
        {/if}
        {if $info['remark']}
        <li>
            <span class="item-hd">其它备注：</span>
            <div class="item-bd">{$info['remark']}</div>
        </li>
        {/if}
    </ul>
</div>
<!-- 联系人 -->
{st:member action="order_tourer" orderid="$info['id']" return="tourer"}

{if !empty($tourer)}
<div class="order-show-item" id="visitor-console">
    <div class="order-user-info-bar">
        <span class="hd">游客信息</span>
        <span class="bd">{count($tourer)}个<i class="more-icon"></i></span>
    </div>
</div>
{/if}

{if $info['contract']}
    <div class="order-show-item" id="contract-console">
        <div class="order-user-info-bar">
            <span class="hd">{$info['contract']['title']}</span>
            <span class="bd"><i class="more-icon"></i></span>
        </div>
    </div>
    {/if}

<!-- 游客信息 -->
{st:member action="order_bill" orderid="$info['id']" return="bill"}
{if !empty($bill)}
<div class="order-show-item" id="invoice-console">
    <div class="order-user-info-bar">
        <span class="hd">发票信息</span>
        <span class="bd">有<i class="more-icon"></i></span>
    </div>
</div>
{/if}
{if !empty($info['refund'])}
<div class="order-show-item" id="refund-console">
    <div class="order-user-info-bar">
        <span class="hd">退款信息</span>
        <span class="bd"><i class="more-icon"></i></span>
    </div>
</div>
{/if}

{if !empty($info['paytime'])}
<div class="order-show-item" id="payment-console">
    <div class="order-user-info-bar">
        <span class="hd">支付信息</span>
        <span class="bd"><i class="more-icon"></i></span>
    </div>
</div>
{/if}
<!-- 支付方式 -->
<div class="order-show-item">
    <div class="order-pay-info-bar">
        <span class="price">应付总额<em class="num">{Currency_Tool::symbol()}{$info['payprice']}</em></span>
        <span class="btn-block">
             {if $info['status']=='1'}
                    <a href="javascript:;" class="btn cancel_btn">取消订单</a>
                    <a href="{Common::get_main_host()}/payment/?ordersn={$info['ordersn']}" class="btn pay_btn">立即付款</a>
             {/if}
             {if $info['status']==5 && $info['ispinlun']!=1}
                   <a href="{$cmsurl}member#&{$cmsurl}member/comment/index?id={$info['id']}" class="btn btn-orange comment_btn">立即评价</a>
             {/if}
             {if $info['status']==2}
                    <a href="{$cmsurl}lines/member/order_refund?ordersn={$info['ordersn']}" data-ajax="false" class="btn  refund_btn">申请退款</a>
                    <a href="javascript:;" data-ajax="false" class="btn  consume_btn">确认消费</a>
             {/if}
             {if $info['status']==6}
                   <a href="javascript:;" class="btn refund_cancel_btn">取消退款</a>
             {/if}


        </span>
    </div>
</div>

<!-- 总计 -->
</div>

    {if St_Functions::is_normal_app_install('red_envelope')}
    {request 'envelope/order_view/ordersn/'.$info['ordersn']}
    {/if}


</div>

{if !empty($tourer)}
<div id="visitor-info" class="layer-container">
    <div class="layer-wrap">
        <div class="layer-tit"><strong class="bt">游客信息</strong><i class="close-ico"></i></div>
        <div class="layer-block-con">
            <div class="visitor-table">
                <ul>
                    {loop $tourer  $k $t}
                    <li>
                        <p>姓名： {$t['tourername']}</p>
                        <p>{$t['cardtype']}： {$t['cardnumber']}</p>
                        <p>性别： {$t['sex']}</p>
                        <p>手机号：{$t['mobile']}</p>
                    </li>
                    {/loop}
                </ul>
            </div>
        </div>
    </div>
</div>
{/if}
<!-- 游客信息展示 -->
{if $info['contract']}
<div  id="contract-info" class="layer-container">
    <div class="layer-wrap">
        <div class="layer-tit"><strong class="bt">{$info['contract']['title']}</strong><i class="close-ico"></i></div>
        <div class="layer-block-con">
            {$contract}
        </div>
    </div>
</div>
{/if}

{if !empty($bill)}
<div id="invoice-info" class="layer-container" style="display: none;">
    <div class="layer-wrap">
        <div class="layer-tit"><strong class="bt">发票信息</strong><i class="close-ico"></i></div>
        <div class="layer-block-con">
            <div class="invoice-table">
                <p class="clearfix">
                    <label>发票类型：</label>
                    <span>{if $bill['type']==2}增值专票{else}普通发票{/if}</span>
                </p>
                <p class="clearfix">
                    <label>发票金额：</label>
                    <span>{Currency_Tool::symbol()}{$info['payprice']}</span>
                </p>
                <p class="clearfix">
                    <label>发票明细：</label>
                    <span>{$bill['content']}</span>
                </p>
                <p class="clearfix">
                    <label>发票抬头：</label>
                    <span>{$bill['title']}</span>
                </p>
                {if !empty($bill['taxpayer_number'])}
                <p class="clearfix">
                    <label>识&nbsp;&nbsp;别&nbsp;&nbsp;号：</label>
                    <span>{$bill['taxpayer_number']}</span>
                </p>
                {/if}
                {if $bill['type']==2}
                <p class="clearfix">
                    <label>地  址：</label>
                    <span>{$bill['taxpayer_address']}</span>
                </p>
                <p class="clearfix">
                    <label>联系电话：</label>
                    <span>{$bill['taxpayer_phone']}</span>
                </p>
                <p class="clearfix">
                    <label>开户网点：</label>
                    <span>{$bill['bank_branch']}</span>
                </p>
                <p class="clearfix">
                    <label>银行账号：</label>
                    <span>{$bill['bank_account']}</span>
                </p>
                {/if}

                <p class="clearfix">
                    <label>收&nbsp;&nbsp;件&nbsp;&nbsp;人：</label>
                    <span>{$bill['receiver']}</span>
                </p>
                <p class="clearfix">
                    <label>手机号码：</label>
                    <span>{$bill['mobile']}</span>
                </p>
                {if !empty($bill['postcode'])}
                <p class="clearfix">
                    <label >邮政编码：</label>
                    <span>{$bill['postcode']}</span>
                </p>
                {/if}
                <p class="clearfix">
                    <label>邮寄地址：</label>
                    <span>{$bill['province']} {$bill['city']} {$bill['address']}</span>
                </p>
            </div>
        </div>
    </div>
</div>
{/if}
{if $info['paytime']}
<div id="payInfo" class="page out">
    <div class="header_top">
        <a class="back-link-icon" data-rel="back" href="javascript:void(0)"></a>
        <h1 class="page-title-bar">支付信息</h1>
    </div>
    <div class="page-content bg-fff">
        <ul class="info-item-block">
            <li>
                <span class="item-hd">支付方式：</span>
                <div class="item-bd">{if !empty($info['online_transaction_no'])}线上支付{else}线下支付{/if}</div>
            </li>
            {if !empty($info['paysource'])}
            <li>
                <span class="item-hd">支付渠道：</span>
                <div class="item-bd">{$info['paysource']}</div>
            </li>
            {/if}
            {if !empty($info['online_transaction_no'])}
            {php}
              $trade = json_decode($info['online_transaction_no'],true);
            {/php}
            <li>
                <span class="item-hd">流水号：</span>
                <div class="item-bd">{$trade['transaction_no']}</div>
            </li>
            {/if}
            <li>
                <span class="item-hd">支付时间：</span>
                <div class="item-bd">{date('Y-m-d H:i:s',$info['paytime'])}</div>
            </li>
            {if !empty($info['payment_proof'])}
            <li>
                <span class="item-hd">付款凭证：</span>
                <div class="item-bd">
                    <a class="see" href="#payProof">查看凭证</a>
                </div>
            </li>
            {/if}
        </ul>
    </div>
</div>
{if !empty($info['payment_proof'])}
<div id="payProof" class="page out">
    <div class="original-show-page">
        <div class="original-info-bar">
            <span class="back-page exit"><a href="javascript:;" class="ico" data-rel="back"></a></span>
        </div>

        <div class="original-show-block">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <div class="swiper-slide pic">
                        <img src="{$info['payment_proof']}" alt="支付凭证"/>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
{/if}
{/if}



{if $info['refund']}
<div id="refundInfo"  class="page out">
    <div class="header_top">
        <a class="back-link-icon" data-rel="back" href="javascript:void(0)"></a>
        <h1 class="page-title-bar">退款信息</h1>
    </div>
    <div class="page-content bg-fff">
        <ul class="info-item-block">
            <li>
                <span class="item-hd">退款金额：</span>
                <div class="item-bd">
                    <p class="price">{Currency_Tool::symbol()}{$info['refund']['refund_fee']}</p>
                </div>
            </li>
            <li>
                <span class="item-hd">退款原因：</span>
                <div class="item-bd">{Currency_Tool::symbol()}{$info['refund']['refund_reason']}</div>
            </li>
            {if $info['refund']['platform']}
            <li>
                <span class="item-hd">退款方式：</span>
                <div class="item-bd">{$info['refund']['platform']}</div>
            </li>
            {/if}
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
            {if $info['refund']['refund_proof']}
            <li>
                <span class="item-hd">退款凭证：</span>
                <div class="item-bd">
                    <a class="see" href="#refundProof">查看凭证</a>
                </div>
            </li>
            {/if}


        </ul>
    </div>
</div>
    {if $info['refund']['refund_proof']}
    <div id="refundProof" class="page out">
        <div class="original-show-page">
            <div class="original-info-bar">
                <span class="back-page exit"><a href="javascript:;" class="ico" data-rel="back"></a></span>
            </div>
            <div class="original-show-block page-content">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide pic">
                            <img src="{$info['refund']['refund_proof']}" height="100"  />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {/if}
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
        });

        //查看合同信息
        $("#contract-console").on("click",function(){
            $("#contract-info").show();
        });
        //关闭合同信息
        $("#contract-info .close-ico").on("click",function(){
            $("#contract-info").hide();
        });

        //查看发票信息
        $("#invoice-console").on("click",function(){
            $("#invoice-info").show();
        });
        //关闭发票信息
        $("#invoice-info .close-ico,#invoice-info").on("click",function(){
            $("#invoice-info").hide();
        });
        //查看支付信息
        $("#payment-console").on("click",function(){
            location.href = '#payInfo';
        });
        //关闭支付信息
        $("#payment-info .close-ico,#payment-info").on("click",function(){
            $("#payment-info").hide();
        });
        //查看退款信息
        $("#refund-console").on("click",function(){
            //$("#refund-info").show();
            location.href = '#refundInfo'
        });
        //关闭退款信息
        $("#refund-info .close-ico,#refund-info").on("click",function(){
            $("#refund-info").hide();
        });

        //取消订单
        $(".cancel_btn").click(function(){

            var url = SITEURL +'lines/member/ajax_order_cancel';
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

        //确认订单
        $(".consume_btn").click(function(){
            var ordersn= "{$info['ordersn']}";
            var url = SITEURL+"lines/member/ajax_order_confirm";
            $.layer({
                type : 3,
                text : '确认消费?',
                ok:function(){
                    $.getJSON(url,{ordersn:ordersn},function(data){
                        if(data.status){
                            $.layer({type:2,icon:1,text:"操作成功",time:1000});
                            setTimeout(function(){
                                location.reload();
                            },1000)
                        }
                    })
                },
                cancel:function(){
                    $.layer.close();
                }

            })

        })



        {if $info['status']==6}
        $('.refund_cancel_btn').click(function () {

            layer.open({
                content: '您确定要取消退款吗？'
                ,btn: ['确定', '取消']
                ,yes: function(index){
                    $.post(SITEURL+'lines/member/ajax_order_refund_back', {ordersn:ordersn}, function (result) {
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