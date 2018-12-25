<!doctype html>
<html>
<head padding_bottom=HBNzDt >
    <meta charset="utf-8">
    <title>订单-{$info['ordersn']}</title>
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    {Common::css('base.css')}
    {Common::css_plugin('order.css','customize')}
    {Common::js('jquery.min.js,lib-flexible.js,jquery.layer.js,validate.js,layer/layer.m.js')}
</head>
<body>
{request "pub/header_new/typeid/$typeid/isordershow/1"}
<!-- 公用顶部 -->

<div class="order-show-item">
    <div class="order-tip-info">
        <p class="num">订单编号：{$info['ordersn']}</p>
        <p class="num">下单时间：{date('Y-m-d H:i',$info['addtime'])}</p>
        <span class="status">{$info['statusname']}</span>
    </div>
</div>
<!-- 订单编号、时间 -->

{if !empty($info['iscoupon']) || $info['usejifen']}
<div class="order-show-item">
    <div class="order-pdt-info">

        <ul class="pdt-info-list">
            {if !empty($info['iscoupon'])}
            <li><span class="type">优惠券</span><span class="data">{Currency_Tool::symbol()}{$info['iscoupon']['cmoney']}</span></li>
            {/if}
            {if $info['usejifen']}
            <li><span class="type">积分抵现</span><span class="data">{Currency_Tool::symbol()}{$info['jifentprice']}</span></li>
            {/if}
        </ul>
       </div>
</div>
{/if}


<div class="order-show-item">
    <ul class="order-link-man-info">
        <li>
            <span class="item-hd">目的地：</span>
            <div class="item-bd">{$customize_info['dest']}</div>
        </li>
        <li>
            <span class="item-hd">出发地：</span>
            <div class="item-bd">{$customize_info['startplace']}</div>
        </li>
        <li>
            <span class="item-hd">出发日期：</span>
            <div class="item-bd">{date('Y-m-d',$customize_info['starttime'])}</div>
        </li>
        <li>
            <span class="item-hd">出游天数：</span>
            <div class="item-bd">{$customize_info['days']}</div>
        </li>
        <li>
            <span class="item-hd">成人：</span>
            <div class="item-bd">{$customize_info['adultnum']}</div>
        </li>
        <li>
            <span class="item-hd">儿童：</span>
            <div class="item-bd">{$customize_info['childnum']}</div>
        </li>
        {loop $extend_fields $key $field}
        <li>
            <span class="item-hd">{$field['chinesename']}：</span>
            <div class="item-bd">{$extend_info[$field['fieldname']]}</div>
        </li>
        {/loop}
        <li>
            <span class="item-hd">其它备注：</span>
            <div class="item-bd">{$customize_info['content']}</div>
        </li>
    </ul>
</div>
<!-- 联系人 -->
<div class="order-show-item">
    <ul class="order-link-man-info">
        <li>
            <span class="item-hd">联系人：</span>
            <div class="item-bd">{$customize_info['contactname']}</div>
        </li>
        <li>
            <span class="item-hd">联系电话：</span>
            <div class="item-bd">{$customize_info['phone']}</div>
        </li>
        <li>
            <span class="item-hd">邮箱：</span>
            <div class="item-bd">{$customize_info['email']}</div>
        </li>
        <li>
            <span class="item-hd">所在地点：</span>
            <div class="item-bd">{$customize_info['address']}</div>
        </li>
        <li>
            <span class="item-hd" style="width:2.8rem">合适联系时间：</span>
            <div class="item-bd">{$customize_info['contacttime']}</div>
        </li>
   </ul>
</div>

{if !empty($customize_info['case_content'])}
<div class="order-show-item" id="case_btn">
    <div class="order-user-info-bar">
        <span class="hd">旅行方案</span>
        <span class="bd">有<i class="more-icon"></i></span>
    </div>
</div>
{/if}

{st:member action="order_tourer" orderid="$info['id']" return="tourer_list"}
{if !empty($tourer_list)}
<div class="order-show-item" id="visitor-console">
    <div class="order-user-info-bar">
        <span class="hd">游客信息</span>
        <span class="bd">{count($tourer_list)}个<i class="more-icon"></i></span>
    </div>
</div>
{/if}

{st:member action="order_bill" orderid="$info['id']" return="bill"}
{if !empty($bill)}
<div class="order-show-item" id="invoice-console">
    <div class="order-user-info-bar">
        <span class="hd">发票信息</span>
        <span class="bd">有<i class="more-icon"></i></span>
    </div>
</div>
{/if}





<div class="order-show-item">
    <div class="order-user-info-bar">
        <span class="hd">支付方式</span>
        <span class="bd">{$info['paytype_name']}</span>
    </div>
</div>
<!-- 支付方式 -->

<div class="order-fix-item-bar">
    <div class="order-fix-total-bar">
        <span class="price">{if $info['paytype']==2}定金支付{else}应付总额{/if}：<em class="num">{Currency_Tool::symbol()}{$info['payprice']}</em></span>

           <!-- <span class="btn-block">
              {if $info['status']=='1'}
               <a href="javascript:;" class="btn btn-grey cancel_btn">取消订单</a>
                <a href= "{Common::get_main_host()}/payment/?ordersn={$info['ordersn']}" class="btn btn-red pay_btn">立即付款</a>
             {/if}
             {if $info['status']=='0'}
                <a href="javascript:;" class="btn btn-grey cancel_btn">取消订单</a>
             {/if}
             {if $info['status']==5 && $info['ispinlun']!=1}
               <a href="{$cmsurl}member#&{$cmsurl}member/comment/index?id={$info['id']}" class="btn btn-orange comment_btn">立即评价</a>
              {/if}
                  {if $info['status']==2}
               <a href="javascript:;" class="btn btn-blue refund_btn">申请退款</a>
              {/if}
                  {if $info['status']==6}
               <a href="javascript:;" class="btn btn-blue refund_cancel_btn">取消退款</a>
              {/if}
            </span>-->
    </div>
</div>
<!-- 总计 -->


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

<!-- 游客信息展示 -->
{if !empty($customize_info['case_content'])}
<div id="case_info" class="layer-container" style="display: none;">
    <div class="layer-wrap">
        <div class="layer-tit"><strong class="bt">旅行方案</strong><i class="close-ico"></i></div>
        <div class="layer-block-con">
            <div class="case-table">
                <p class="clearfix">
                    <label class="lb">方案标题：</label>
                    <span class="sp">{$customize_info['title']}</span>
                </p>
                <p class="clearfix">
                    <label class="lb">方案报价：</label>
                    <span class="sp">{Currency_Tool::symbol()}{$info['price']}</span>
                </p>

                {if !empty($supplier)}
                <p class="clearfix">
                    <label class="lb">方案提供商：</label>
                    <span class="sp">{$supplier['suppliername']}</span>
                </p>
                <p class="clearfix">
                    <label class="lb">联系电话：</label>
                    <span class="sp">{$supplier['mobile']}</span>
                </p>
                {/if}

                <p class="clearfix">
                    <label class="lb">方案内容：</label>
                </p>
                <p class="clearfix">
                    {$customize_info['case_content']}
                </p>
            </div>
        </div>
    </div>
</div>
{/if}
{if !empty($tourer_list)}
<div id="visitor-info" class="layer-container">
    <div class="layer-wrap">
        <div class="layer-tit"><strong class="bt">游客信息</strong><i class="close-ico"></i></div>
        <div class="layer-block-con">
            <div class="visitor-table">
                <ul>
                    {loop $tourer_list  $k $t}
                    <li>
                        <p>姓名： {$t['tourername']}</p>
                        <p>{$t['cardtype']}： {$t['cardnumber']}</p>
                        <p>性别： {$t['sex']}</p>
                        {if !empty($t['mobile'])}
                        <p>手机号：{$t['mobile']}</p>
                        {/if}
                    </li>
                    {/loop}
                </ul>
            </div>
        </div>
    </div>
</div>
{/if}
<!-- 游客信息展示 -->

{if !empty($bill)}
<div id="invoice-info" class="layer-container" style="display: none;">
    <div class="layer-wrap">
        <div class="layer-tit"><strong class="bt">发票信息</strong><i class="close-ico"></i></div>
        <div class="layer-block-con">
            <div class="invoice-table">
                <p class="clearfix">
                    <label>发票明细：</label>
                    <span>旅游费</span>
                </p>
                <p class="clearfix">
                    <label>发票金额：</label>
                    <span>{Currency_Tool::symbol()}{$info['payprice']}</span>
                </p>
                <p class="clearfix">
                    <label>发票抬头： </label>
                    <span>{$bill['title']}</span>
                </p>
                <p class="clearfix">
                    <label>收&nbsp;&nbsp;件&nbsp;&nbsp;人： </label>
                    <span>{$bill['receiver']}</span>
                </p>
                <p class="clearfix">
                    <label>联系电话：</label>
                    <span>{$bill['mobile']}</span>
                </p>
                <p class="clearfix">
                    <label>收货地址：</label>
                    <span>{$bill['province']} {$bill['city']} {$bill['address']}</span>
                </p>
            </div>
        </div>
    </div>
</div>
{/if}



<script>
    var CURRENCY_SYMBOL="{Currency_Tool::symbol()}";
    var SITEURL="{URL::site()}";
    var ordersn="{$info['ordersn']}"
    var orderid="{$info['id']}";
    $(document).ready(function(){

        $("#case_btn").on("click",function(){
            $("#case_info").show();
        });
        $("#case_info .close-ico,#invoice-info").on("click",function(){
            $("#case_info").hide();
        });

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

            var url = SITEURL +'customize/member/ajax_order_cancel';
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


        {if $info['status']==2}
            //退款
            $(".refund_btn").click(function(){
                $('#orderRefund').removeClass('hide');


            });
            //取消退款
            $('.refund_no').click(function () {
                $('#orderRefund').addClass('hide');
                $('textarea[name=reason]').val('');
            });
            //申请退款
            $('.refund_submit').click(function () {
                var reason = $('textarea[name=reason]').val();
                var url = SITEURL +'customize/member/ajax_order_refund';
                $.ajax({
                    type: 'post',
                    url: url,
                    data: {ordersn:ordersn,reason:reason},
                    dataType: 'json',
                    success: function (data) {
                        if(data.bool)
                        {
                            window.location.reload();
                        }
                        //$("#startdate_con").html(data);
                    }
                });
            })
            {/if}
                {if $info['status']==6}
                    $('.refund_cancel_btn').click(function () {

                        layer.open({
                            content: '您确定要取消退款吗？'
                            ,btn: ['确定', '取消']
                            ,yes: function(index){
                                $.post(SITEURL+'customize/member/ajax_order_refund_back', {ordersn:ordersn}, function (result) {
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