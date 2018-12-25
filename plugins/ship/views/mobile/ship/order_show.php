<?php defined('SYSPATH') or die();?><!doctype html>
<html>
<head padding_border=RYFDMj >
    <meta charset="utf-8">
    <title>订单详情</title>
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    {Common::css('base.css')}
    {Common::css_plugin('m_ship.css','ship')}
    {Common::js('lib-flexible.js,Zepto.js')}


</head>

<body>

{request "pub/header_new/typeid/$typeid/isorder/1"}
    <!-- 公用顶部 -->

    <div class="order-show-item">
        <div class="order-tip-info">
            <p class="num">订单编号：{$info['ordersn']}</p>
            <p class="num">下单时间：{date('Y-m-d H:i:s',$info['addtime'])}</p>
            <span class="status">{$info['statusname']}</span>
        </div>
    </div>
    <!-- 订单编号、时间 -->
    {if !empty($info['eticketno']) && Product::is_app_install('stourwebcms_app_supplierverifyorder')}
    <div class="order-show-item">
        <div class="order-code-info">
            <img class="code-img" src="//{Common::get_main_prefix()}{Common::get_domain()}/res/vendor/qrcode/make.php?param={$info['eticketno']}&size=7" />
            <div class="code-num">消费码：{$info['eticketno']}</div>
        </div>
    </div>
    <!-- 二维码 -->
    {/if}


    <div class="order-show-item">
        <div class="order-pdt-info">
            <a class="pdt-info-tw" href="{$info['url']}">
                <div class="pic"><img src="{$info['litpic']}" title="" alt=""></div>
                <div class="con">
                    <p class="name"> {$info['productname']}</p>
                    <p class="date"> {$info['usedate']}出发</p>
                </div>
            </a>
            <ul class="pdt-info-list">
                {loop $sublist $sub}
                <li><span class="type">{$sub['title']}</span><span class="data">{Currency_Tool::symbol()}{$sub['price']}×{$sub['dingnum']}间</span></li>
                {/loop}
            </ul>
            {if !empty($info['iscoupon'])|| !empty($info['usejifen'])}
            <ul class="pdt-info-list">
                {if !empty($info['iscoupon'])}
                <li>
                    <span class="type">优惠券<em class="ml">({$info['iscoupon']['name']})</em></span>
                    <span class="data">{Currency_Tool::symbol()}{$info['iscoupon']['cmoney']}</span>
                </li>
                {/if}
                {if $info['usejifen']}
                <li><span class="type">积分抵现</span><span class="data">{Currency_Tool::symbol()}{$info['jifentprice']}</span></li>
                {/if}
            </ul>
            {/if}
            <div class="pdt-info-total">
                <span>应付总额</span>
                <span>{Currency_Tool::symbol()}{$info['actual_price']}</span>
            </div>
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
            <li>
                <span class="item-hd">电子邮箱：</span>
                <div class="item-bd">{$info['linkemail']}</div>
            </li>
            {if $info['remark']}
            <li>
                <span class="item-hd">其它备注：</span>
                <div class="item-bd">{$info['remark']}</div>
            </li>
            {/if}
        </ul>
    </div>
    <!-- 联系人 -->
    {if !empty($tourlist)}
    <div class="order-show-item" id="visitor-console">
        <div class="order-user-info-bar">
            <span class="hd">游客信息</span>
            <span class="bd">{count($tourlist)}个<i class="more-icon"></i></span>
        </div>
    </div>
    {/if}
    <!-- 游客信息 -->
    {if $info['paysource']}
    <div class="order-show-item">
        <div class="order-user-info-bar">
            <span class="hd">支付方式</span>
            <span class="bd">{$info['paysource']}</span>
        </div>
    </div>
    {/if}
    <!-- 支付方式 -->

    <div class="order-fix-item-bar">
        <div class="order-fix-total-bar">
            <span class="price">应付总额：<em class="num">&yen;{$info['actual_price']}</em></span>
            <span class="btn-block">
                {if $info['status']<2}
<!--                <a href="javascript:;" class="btn btn-grey">取消订单</a>-->
                {/if}
                {if $info['status']==0}
                <a href="javascript:;" class="btn btn-blue">等待确认</a>
                {elseif $info['status']==1}
                 <a href="{$info['payurl']}" class="btn btn-red">立即付款</a>
                {elseif $info['status']==2}
<!--                <a href="javascript:;" class="btn btn-blue">申请退款</a>-->
                {elseif $info['status']==5&&empty($info['ispinlun'])}
                  <a href="{$cmsurl}member#&{$cmsurl}member/comment/index?id={$info['id']}" class="btn btn-orange">立即评价</a>
                {/if}
            </span>
            {Common::js('layer/layer.m.js')}
            <script>
                $(function(){
                    $('.order-fix-total-bar .btn-blue').click(function(){
                        layer.open({
                            content:'请联系客服!'
                        })
                    })

                })
            </script>
        </div>
    </div>
    <!-- 总计 -->

    <div id="visitor-info" class="layer-container">
        <div class="layer-wrap">
            <div class="layer-tit"><strong class="bt">游客信息</strong><i class="close-ico"></i></div>
            <div class="layer-block">
                <div class="visitor-table">
                    <ul>
                        {loop $tourlist $tour}
                        <li>
                            <p>游客{$n}： {$tour['tourername']}（{$tour['sex']}）</p>
                            <p>{$tour['cardtype']}： {$tour['cardnumber']}</p>
                        </li>
                        {/loop}

                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- 游客信息展示 -->

    <script>

        //查看游客信息
        $("#visitor-console").on("click",function(){
            $("#visitor-info").show();
        });

        $("#visitor-info .close-ico").on("click",function(){
            $("#visitor-info").hide();
        })

    </script>

</body>
</html>