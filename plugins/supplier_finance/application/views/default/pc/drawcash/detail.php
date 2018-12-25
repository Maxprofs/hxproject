<!doctype html>
<html>
<head bottom_float=Vkuokk >
    <meta charset="utf-8">
    <title>提现详情-{$webname}</title>
    {Common::css("style.css,base.css")}

    <link type="text/css" rel="stylesheet" href="/plugins/supplier_finance/public/default/pc/css/base.css">
    <link type="text/css" rel="stylesheet" href="/plugins/supplier_finance/public/default/pc/css/style.css">

    {Common::js("jquery.min.js")}
    <style>
        .order-con .order-msg ul li .itemtitle
        {

            width: 120px;
        }
    </style>
</head>

<body>

<div class="page-box">

    {request 'pc/pub/header'}

    {template 'pc/pub/sidemenu'}

    <div class="main">
        <div class="content-box">

                <div class="finance-content">
                    <div class="finance-tit"><strong class="bt">提现详情</strong></div>
                    <div class="finance-bloock">
                        <div class="tx-show-item">
                            <ul>
                                <li class="clearfix">
                                    <strong class="item-bt">提现金额：</strong>
                                    <div class="item-nr">
                                        <span class="color-red">&yen;{$info['withdrawamount']}</span>
                                    </div>
                                </li>
                                <li class="clearfix">
                                    <strong class="item-bt">账户类型：</strong>
                                    <div class="item-nr">
                                        {if $info['proceeds_type']==1}
                                        <span>银行卡</span>
                                        {elseif $info['proceeds_type']==2}
                                        <span>支付宝</span>
                                        {/if}
                                    </div>
                                </li>

                                {if $info['proceeds_type']==1}

                                <li class="clearfix">
                                    <strong class="item-bt">银行卡号：</strong>
                                    <div class="item-nr">
                                        <span>{$info['bankcardnumber']}</span>
                                    </div>
                                </li>
                                <li class="clearfix">
                                    <strong class="item-bt">账户名：</strong>
                                    <div class="item-nr">
                                        <span>{$info['bankaccountname']}</span>
                                    </div>
                                </li>
                                <li class="clearfix">
                                    <strong class="item-bt">开户银行：</strong>
                                    <div class="item-nr"><span>{$info['bankname']}</span></div>
                                </li>

                                {elseif $info['proceeds_type']==2}

                                <li class="clearfix">
                                    <strong class="item-bt">支付宝账号：</strong>
                                    <div class="item-nr">
                                        <span>{$info['alipayaccount']}</span>
                                    </div>
                                </li>
                                <li class="clearfix">
                                    <strong class="item-bt">真实姓名：</strong>
                                    <div class="item-nr"><span>{$info['alipayaccountname']}</span></div>
                                </li>

                                {/if}

                                <li class="clearfix">
                                    <strong class="item-bt">备注说明：</strong>
                                    <div class="item-nr"><span>{$info['description']}</span></div>
                                </li>
                                <hr>
                                <li class="clearfix">
                                    <strong class="item-bt">进度状态：</strong>
                                    <div class="item-nr">
                                        {if $info['status']==0}
                                            <span class="dfk">{$info['status_name']}</span>
                                        {elseif $info['status']==2}
                                            <span class="dcl">{$info['status_name']}</span>
                                        {else}
                                            <span class="ywc">{$info['status_name']}</span>
                                        {/if}
                                    </div>
                                </li>


                                {if $info['status']!=0}
                                <li class="clearfix">
                                    <strong class="item-bt">审核时间：</strong>
                                    <div class="item-nr">
                                        <span>
                                            {php}
                                            if(!empty($info['finishtime']))
                                                echo date('Y-m-d H:i:s',$info['finishtime']);
                                        {/php}
                                        </span>
                                    </div>
                                </li>
                                <li class="clearfix">
                                    <strong class="item-bt">审核说明：</strong>
                                    <div class="item-nr"><span>{$info['audit_description']}</span></div>
                                </li>
                                {/if}


                            </ul>
                        </div>
                        <div class="btn-block clearfix">
                            <a class="back-btn" href="javascript:;">返回</a>
                        </div>
                    </div>
                </div>

            </div>

            <div class="st-record">{Common::get_sys_para('cfg_supplier_footer')}</div>

        </div>
    </div>
    <!-- 主体内容 -->

</div>
<script>
    $(function () {
        $("#nav_drawcash").addClass('on');
        $(".back-btn").click(function () {
            location.href = "{$cmsurl}pc/drawcash/list";
        });

    });
</script>
</body>
</html>
