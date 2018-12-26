<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>提现详情-{$webname}</title>


    {Model_Supplier::css("style.css,base.css,extend.css",'brokerage')}

    {Common::js("jquery.min.js")}
    {Common::js("layer/layer.js")}
</head>

<body>

<div class="page-box">

    {request 'pc/pub/header'}

    {template 'pc/brokerage/sidemenu'}

    <div class="main">
        <div class="content-box">

                <div class="finance-content">
                    <div class="finance-tit"><strong class="bt">提现详情</strong></div>
                    <div class="finance-bloock">
                        <div class="tx-show-item">
                            <ul>
                                <li class="clearfix">
                                    <strong class="item-bt">商家名称：</strong>
                                    <div class="item-nr">
                                        <span >{$info['distributorname']}</span>
                                    </div>
                                </li>
                                <li class="clearfix">
                                    <strong class="item-bt">申请时间：</strong>
                                    <div class="item-nr">
                                        <span >{date('Y-m-d H:i:s',$info['addtime'])}</span>
                                    </div>
                                </li>
                                <li class="clearfix">
                                    <strong class="item-bt">提现金额：</strong>
                                    <div class="item-nr">
                                        <span class="color-red">{$info['withdrawamount']}</span>
                                    </div>
                                </li>
                                <li class="clearfix">
                                    <strong class="item-bt">提现到：</strong>
                                    <div class="item-nr">
                                        <span>{$info['proceeds_type_title']}</span>
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
                                {elseif $info['proceeds_type']==3}
                                <li class="clearfix">
                                    <strong class="item-bt">微信账号：</strong>
                                    <div class="item-nr">
                                        <span>{$info['wechataccount']}</span>
                                    </div>
                                </li>
                                <li class="clearfix">
                                    <strong class="item-bt">微信昵称：</strong>
                                    <div class="item-nr"><span>{$info['wechataccountname']}</span></div>
                                </li>
                                {/if}
                                <li class="clearfix">
                                    <strong class="item-bt">提现状态：</strong>
                                    <div class="item-nr">
                                        {if $info['status']==0}
                                        <span class="dfk">审核中</span>
                                        {elseif $info['status']==1}
                                        <span class="dcl">已提现</span>
                                        {else}
                                        <span class="ywc">未通过</span>
                                        {/if}
                                    </div>
                                </li>
                                {if $info['description']}
                                <li class="clearfix">
                                    <strong class="item-bt">备注说明：</strong>
                                    <div class="item-nr"><span>{$info['description']}</span></div>
                                </li>
                                {/if}
                                {if $info['status']==1}
                                <li class="clearfix">
                                    <strong class="item-bt">付款凭证：</strong>
                                    <div class="item-nr">
                                        <span  style="cursor: pointer" onclick="showPic('{$info['certificate']}')"><img  style="max-width: 150px" src="{$info['certificate']}"></span>
                                    </div>
                                </li>
                                {/if}

                                {if $info['status']}
                                <li class="clearfix">
                                    <strong class="item-bt">平台说明：</strong>
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

            <div class="st-record">{Common::get_sys_para('cfg_distributor_footer')}</div>

        </div>
    </div>
    <!-- 主体内容 -->

</div>
<script>
    $(function () {
        $('.hd-menu a').removeClass('cur');
        $('.hd-menu #brokerage').addClass('cur');
        $('#brokerage_approval').addClass('on');

        $(".back-btn").click(function () {
            location.href = "{$cmsurl}brokerage/approval";
        });

    });

    //显示大图
    function showPic(src) {

    }



</script>
</body>
</html>
