<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    {template "pub/varname"}
    {Common::css('base.css,user_new.css')}
    {Common::css_plugin('booking.css','spot')}
    {Common::load_skin()}
    {Common::js('jquery.min.js,base.js')}
    {Common::js('layer/layer.js')}
</head>
<body>
<div class="user-line-order-wrap" style="overflow:hidden;">
    <div class="info-item">
        <div class="condition-item clearfix">
            <div class="condition-item clearfix">
                <div class="text">
                    <h3 class="orange">{$info['statusname']}</h3>
                    <div class="list clearfix">
                        <p>{__('订单编号')}：{$info['ordersn']}</p>
                        <p>{if $info['paytype']==2}{__('定金支付')}{else}{__('应付总额')}{/if}：<em>{Currency_Tool::symbol()}{if $info['paytype']==2}{$info['payprice']}{else}{$info['actual_price']}{/if}</em></p>
                    </div>
                </div>
                <div class="btn clearfix">
                    {if $info['status']=='1'}
                    <a class="cancel-btn fr" href="javascript:;">{__('取消订单')}</a>
                    <a class="pay-btn fr" href="javascript:;">{__('立即付款')}</a>
                    {/if}
                    {if $info['status']=='0'}
                    <a class="cancel-btn fr" href="javascript:;">{__('取消订单')}</a>
                    {/if}
                    {if $info['status']==2&&$info['refund_restriction']!=1}
                    <a id="apply-refund-Click" class="refund-btn fr cursor">{__('申请退款')}</a>
                    {/if}
                    {if $info['status']==6}
                    <a id="cancel-refund-Click" class="cancel-refund-btn refund-btn fr cursor">{__('取消退款')}</a>
                    {/if}
                    {if $info['status']==5 && $info['ispinlun']=='0'}
                    <a href="javascript:void(0);" class="comment-btn pl-btn">{__('我要点评')}</a>
                    {/if}
                </div>
            </div>
        </div>
    </div>
    <!-- 订单状态 -->
    <div class="info-item">
        <div class="order-speed-box">
            {if  $info['status']<6 && $info['status']!=4}
            <div class="order-speed-step">
                <ul class="clearfix">
                    <li class="step-first cur">
                        <em></em>
                        <strong></strong>
                        <span>{__('提交订单')}</span>
                    </li>
                    <li class="step-second {if $info['status']>1}cur{elseif $info['status']==1}active{/if}">
                        <em></em>
                        <strong></strong>
                        <span>{__('等待付款')}</span>
                    </li>
                    {if $info['status']==3}
                    <li class="step-third active">
                        <em></em>
                        <strong></strong>
                        <span>{__('已取消')}</span>
                    </li>
                    {elseif $info['status']==4}
                    <li class="step-third cur"  >
                        <em></em>
                        <strong></strong>
                        <span>{__('等待消费')}</span>
                    </li>
                    <li class="step-fourth active"  >
                        <em></em>
                        <strong></strong>
                        <span>{__('已退款')}</span>
                    </li>
                    {else}
                    <li class="step-third {if $info['status']>2}cur{elseif $info['status']==2}active{/if}"  >
                        <em></em>
                        <strong></strong>
                        <span>{__('等待消费')}</span>
                    </li>
                    <li class="step-fourth {if $info['status']==5 && $info['ispinlun']!=1}active{elseif $info['status']==5}cur{/if}">
                        <em></em>
                        <strong></strong>
                        <span>{__('等待评价')}</span>
                    </li>
                    <li class="step-fifth {if $info['status']==5 && $info['ispinlun']==1}active{/if}" >
                        <em></em>
                        <strong></strong>
                        <span>{__('交易完成')}</span>
                    </li>
                    {/if}
                </ul>
            </div>
            {else}
            <div class="order-speed-step">
                <ul class="clearfix">
                    <li class="step-first cur blue">
                        <em></em>
                        <strong></strong>
                        <span>{__('申请退款')}</span>
                    </li>
                    <li class="step-second cur">
                        <strong></strong>
                    </li>
                    <li class="step-third {if $info['status']==6}active{else} cur blue{/if}">
                        <em></em>
                        <strong></strong>
                        <span>{__('退款确认')}</span>
                    </li>
                    <li class="step-fourth {if $info['status']==4}cur{/if}">
                        <strong></strong>
                    </li>
                    <li class="step-fifth {if $info['status']==4} cur active{/if}">
                        <em></em>
                        <strong></strong>
                        <span>{__('已退款')}</span>
                    </li>
                </ul>
            </div>
            {/if}
            <div class="speed-show-list">
                {php $log_list = Model_Member_Order_Log::get_list($info['id']);}
                <ul class="info-list" style="height: 52px;">
                    {loop $log_list $log}
                    <li><span>{date('Y-m-d H:i:s',$log['addtime'])}</span><span>{$log['description']}</span></li>
                    {/loop}
                </ul>
                {if count($log_list)>2}
                <div id="more-info" class="more-info down">{__('展开详细进度')}</div>
                {/if}
            </div>
        </div>
    </div>
    <!-- 流程 -->
    <div class="info-item">
        <div class="ost-item">
            <h3 class="tit">{__('订单信息')}</h3>
            <div class="os-block">
                <div class="order-show-info">

                    <table width="100%" border="0" class="order-show-table">
                        <tr>
                            <th width="45%" height="40" scope="col"><span class="l-con">{__('产品名称')}</span></th>
                            <th width="15%" scope="col">{__('使用日期')}</th>
                            <th width="15%" scope="col">{__('单价')}</th>
                            <th width="10%" scope="col">{__('数量')}</th>
                            <th width="15%" scope="col">{__('总价')}</th>
                        </tr>
                        <tr>
                            <td height="40"><span class="l-con">{$info['productname']}</span></td>
                            <td>{$info['usedate']}</td>
                            <td>{$info['price']}</td>
                            <td>{$info['dingnum']}</td>
                            <td><span class="jg"><i class="currency_sy">{Currency_Tool::symbol()}</i>{php}echo $info['price'] * $info['dingnum'];{/php}</span></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- 订单信息 -->
    <div class="info-item">
        <div class="ost-item">
            <h3 class="tit">{__('联系人信息')}</h3>
            <ul class="ost-content">
                <li class="linkman-info clearfix">
                    <div class="contact-list clearfix">
                        <div class="item-block">
                            <p class="ty ty1"><label>{__('联系人')}：</label>{$info['linkman']}</p>
                        </div>
                        <div class="item-block">
                            <p class="ty ty1"><label>{__('手机号')}：</label>{$info['linktel']}</p>
                        </div>
                        {if !empty($info['linkemail'])}
                        <div class="item-block">
                            <p class="ty ty1"><label>{__('邮箱')}：</label>{$info['linkemail']}</p>
                        </div>
                        {/if}
                    </div>
                </li>
                {if !empty($info['remark'])}
                <li>
                    <span class="hd">{__('预订备注')}：</span>
                    <div class="bd">
                        <p>{$info['remark']}</p>
                    </div>
                </li>
                {/if}
            </ul>
        </div>
    </div>
    <!-- 联系人信息 -->

    {st:member action="order_tourer" orderid="$info['id']" return="tourer"}
    {if !empty($tourer)}
    <div class="info-item">
        <div class="ost-item">
            <h3 class="tit">{__('游客信息')}</h3>
            <ul class="tourist-list">
                {if !empty($tourer)}
                {php $num=1;}
                {loop $tourer $k $t}
                {php}$t_mobile_secret = substr($t['mobile'], 0, 3).'****'.substr($t['mobile'], 7); {/php}
                <li>
                    <div class="base-info">
                        <label>旅客{$num}</label>
                        <span class="off">{$t['tourername']}{if !empty($t['mobile'])}<i class="ico secret" data-mobile="{$t['mobile']}" data-secret="{$t_mobile_secret}"></i>{/if}</span>
                    </div>
                    <div class="more-info clearfix">
                        {if !empty($t['mobile'])}
                        <p>
                            <label>{__('手机号码')}：</label>
                            <em class="phone">{$t_mobile_secret}</em>
                        </p>
                        {/if}
                        {if !empty($t['sex'])}
                        <p>
                            <label>{__('性别')}：</label>
                            {$t['sex']}
                        </p>
                        {/if}
                        {if !empty($t['cardtype'])}
                        <p>
                            <label>{__('证件类型')}：</label>
                            {$t['cardtype']}
                        </p>
                        {/if}
                        {if !empty($t['cardnumber'])}
                        <p>
                            <label>{__('证件号码')}：</label>
                            {$t['cardnumber']}
                        </p>
                        {/if}
                    </div>
                </li>
                {php $num++;}
                {/loop}
                {/if}
            </ul>
        </div>
    </div>
    <!-- 游客信息 -->
    {/if}

    {st:member action="order_bill" orderid="$info['id']" return="bill"}
    {if !empty($bill)}
    <div class="info-item">
        <div class="ost-item">
            <div class="os-term">
                <div class="os-tit">{__('发票信息')}</div>
                <div class="os-block">
                    <div class="order-show-invoice">
                        <ul>
                            <li><em>{__('发票明细')}：</em>{__('旅游费')}</li>
                            <li><em>{__('发票金额')}：</em><i class="currency_sy">{Currency_Tool::symbol()}</i>{$info['payprice']}</li>
                            <li><em>{__('发票抬头')}：</em>{$bill['title']}</li>
                            <li><em>{__('收件人')}：</em>{$bill['receiver']}</li>
                            <li><em>{__('联系电话')}：</em>{$bill['mobile']}</li>
                            <li><em>{__('收货地址')}：</em>{$bill['province']} {$bill['city']} {$bill['address']}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- 发票信息 -->
    {/if}

    {if !empty($info['iscoupon'])|| !empty($info['usejifen'])}
    <div class="info-item">
        <div class="ost-item">
            <h3 class="tit">{__('优惠信息')}</h3>
            <ul class="ost-content">
                {if !empty($info['iscoupon'])}
                <li>
                    <span class="hd">{__('优惠券')}：</span>
                    <div class="bd">
                        <p>（{$info['iscoupon']['name']}） <em class="price">-{Currency_Tool::symbol()}{$info['iscoupon']['cmoney']}</em></p>
                    </div>
                </li>
                {/if}
                {if $info['usejifen']}
                <li>
                    <span class="hd">{__('积分抵现')}：</span>
                    <div class="bd">
                        <p>（使用{$info['needjifen']}积分抵扣）<em class="price">-{Currency_Tool::symbol()}{$info['jifentprice']}</em></p>
                    </div>
                </li>
                {/if}
                {if floatval($info['platform_discount'])>0}
                <li>
                    <span class="hd">{__('平台优惠')}：</span>
                    <div class="bd">
                        <p>（{__('平台管理员优惠')}） <em class="price">-{Currency_Tool::symbol()}{$info['platform_discount']}</em></p>
                    </div>
                </li>
                {/if}
            </ul>
        </div>
    </div>
    <!-- 优惠信息 -->
    {/if}
    {if !empty($info['paytime'])}
    <div class="info-item">
        <div class="ost-item">
            <h3 class="tit">{__('支付信息')}</h3>
            <ul class="ost-content">
                <li>
                    <span class="hd">{__('支付方式')}：</span>
                    <div class="bd">
                        <p>{if !empty($info['online_transaction_no'])}线上支付{else}线下支付{/if}</p>
                    </div>
                </li>
                {if !empty($info['paysource'])}
                <li>
                    <span class="hd">{__('支付渠道')}：</span>
                    <div class="bd">
                        <p>{$info['paysource']}</p>
                    </div>
                </li>
                {/if}
                {if !empty($info['online_transaction_no'])}
                {php}
                $trade = json_decode($info['online_transaction_no'],true);
                {/php}
                <li>
                    <span class="hd">{__('流水号')}：</span>
                    <div class="bd">
                        <p>{$trade['transaction_no']}</p>
                    </div>
                </li>
                {/if}
                {if !empty($info['paytime'])}
                <li>
                    <span class="hd">{__('付款时间')}：</span>
                    <div class="bd">
                        <p>{date('Y-m-d H:i:s',$info['paytime'])}</p>
                    </div>
                </li>
                {/if}
                {if !empty($info['payment_proof'])}
                <li>
                    <span class="hd">{__('付款凭证')}：</span>
                    <div class="bd">
                        <div class="img yt-img">
                            <a href="javascript:;" id="layer-photos-demo">
                                <div class="mask"></div>
                                <p>{__('查看原图')}</p>
                                <img src="{$info['payment_proof']}" width="150"  alt="" title="" />
                            </a>
                        </div>
                    </div>
                </li>
                {/if}
            </ul>
        </div>
    </div>
    {/if}
    <!-- 支付信息 -->


    {if $info['refund']}
    <div class="info-item">
        <div class="ost-item">
            <h3 class="tit">退款信息</h3>
            <ul class="ost-content">
                <li>
                    <span class="hd">退款金额：</span>
                    <div class="bd">
                        <p><em class="price"><i class="currency_sy">{Currency_Tool::symbol()}</i>{$info['refund']['refund_fee']}</em></p>
                    </div>
                </li>
                <li>
                    <span class="hd">退款原因：</span>
                    <div class="bd">
                        <p>{$info['refund']['refund_reason']}</p>
                    </div>
                </li>
                <li>
                    <span class="hd">退款方式：</span>
                    <div class="bd">
                        <p>{if $info['refund']['refund_proof'] && empty($info['refund']['refund_no'])}
                            线下
                            {else}
                            线上
                            {/if}
                        </p>
                    </div>
                </li>
                {if $info['refund']['platform']}
                <li>
                    <span class="hd">退款渠道：</span>
                    <div class="bd">
                        <p>{$info['refund']['platform']}</p>
                    </div>
                </li>
                {/if}
                {if $info['refund']['alipay_account']}
                <li>
                    <span class="hd">退款账号：</span>
                    <div class="bd">
                        <p>{$info['refund']['alipay_account']}</p>
                    </div>
                </li>
                {/if}
                {if $info['refund']['cardholder']}
                <li>
                    <span class="hd">持卡人：</span>
                    <div class="bd">
                        <p>{$info['refund']['cardholder']}</p>
                    </div>
                </li>
                {/if}
                {if $info['refund']['bank']}
                <li>
                    <span class="hd">开户行：</span>
                    <div class="bd">
                        <p>{$info['refund']['bank']}</p>
                    </div>
                </li>
                {/if}
                {if $info['refund']['cardnum']}
                <li>
                    <span class="hd">卡号：</span>
                    <div class="bd">
                        <p>{$info['refund']['cardnum']}</p>
                    </div>
                </li>
                {/if}
                <li>
                    <span class="hd">退款时间：</span>
                    <div class="bd">
                        <p>{date('Y-m-d H:i:s',$info['refund']['modtime'])}</p>
                    </div>
                </li>
                {if $info['refund']['refund_proof']}
                <li>
                    <span class="hd">退款凭证：</span>
                    <div class="bd">
                        <div class="img yt-img" >
                            <a href="javascript:void(0)" >
                                <div class="mask"></div>
                                <p>查看原图</p>
                                <img  src="{$info['refund']['refund_proof']}" width="150" />
                            </a>
                        </div>
                    </div>
                </li>
                {/if}
            </ul>
        </div>
    </div>
    {/if}
    <!-- 支付信息 -->
    {if !empty($info['eticketno']) && Product::is_app_install('stourwebcms_app_supplierverifyorder')}
    <div class="info-item">
        <div class="ost-item">
            <h3 class="tit">{__('消费码')}</h3>
            <ul class="ost-content">
                <li>
                    <span class="hd">{__('验单码')}：</span>
                    <div class="bd">
                        <p>{$info['eticketno']}</p>
                    </div>
                </li>
                <li>
                    <span class="hd">{__('二维码')}：</span>
                    <div class="bd">
                        <div class="code">
                            <img src="/res/vendor/qrcode/make.php?param={$info['eticketno']}" alt="" title="" />
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    {/if}
    <!-- 消费码 -->

    <div class="info-item">
        <div class="settlement-info clearfix">
            <div class="total">
                {if $info['paytype'] == 1}
                <p class="price">应付总额：<em><i class="currency_sy">{Currency_Tool::symbol()}</i>{$info['pay_price']}</em>{if $info['jifenbook']}<span>预订赠送积分{$info['jifenbook']}</span>{/if}</p>
                <p class="calc">（总额<i class="currency_sy">{Currency_Tool::symbol()}</i>{$info['totalprice']} - 优惠{Currency_Tool::symbol()}{$info['privileg_price']} = 应付总额{Currency_Tool::symbol()}{$info['pay_price']}）</p>
                {else}
                <p class="price">定金支付：<em><i class="currency_sy">{Currency_Tool::symbol()}</i>{$info['pay_price']}</em>{if $info['jifenbook']}<span>预订赠送积分{$info['jifenbook']}</span>{/if}</p>
                <p class="calc"> ({__('到店支付')} <i class="currency_sy">{Currency_Tool::symbol()}</i>{php}echo $info['totalprice']-$info['payprice']; {/php} + {__('定金支付')} <i class="currency_sy">{Currency_Tool::symbol()}</i>{$info['payprice']})</p>
                {/if}
            </div>
            <div class="pay">
                {if $info['status']=='1'}
                <a class="pay-btn" href="javascript:;">{__('立即付款')}</a>
                {/if}
                {if $info['paytype']==2}
                <p>*尾款请通过联系商家转账或到店支付</p>
                {/if}
            </div>
        </div>
        <!-- 结算 -->
    </div>
    <!-- 支付结算 -->
</div>
<div class="agreement-term-content" style="display: none;">
    <div class="agreement-term-tit"><strong>{$GLOBALS['cfg_order_agreement_title']}</strong><i class="close-ico" onclick="$(this).parents('.agreement-term-content').hide();"></i></div>
    <div class="agreement-term-block">
        <h3 class="agreement-bt">《{$GLOBALS['cfg_order_agreement_title']}》</h3>
        <div class="agreement-nr">
            {$GLOBALS['cfg_order_agreement']}
        </div>
    </div>
</div>
<script>
    var orderid="{$info['id']}";
    $(document).ready(function(){
        //手机号显示隐藏
        $('.secret').click(function(){
            var t_m = $(this).data('mobile');
            var t_secret = $(this).data('secret');
            if($(this).parent().hasClass('off')){
                $(this).parent().removeClass('off').addClass('on');
                $(this).parents('li').first().find('.phone').html(t_m);
            }else{
                $(this).parent().removeClass('on').addClass('off');
                $(this).parents('li').first().find('.phone').html(t_secret);
            }
        });
        //图片显示
        $(".yt-img").click(function() {

            var litpic = $(this).find('img').attr('src');
            var content = "<div style='width: 100%'><img src='"+litpic+"' width='100%' height='100%'></div>";

            parent.layer.open({
                type: 1,
                title: false,
                area:['800px','600px'],
                content: content
            })
        })

        //订单详细进度
        $("#more-info").on("click",function(){
            if( $(this).hasClass("down") )
            {
                $(this).addClass("up").removeClass("down").text("{__('收起详细进度')}");
                $(this).prev().css("height","auto");
            }
            else
            {
                $(this).addClass("down").removeClass("up").text("{__('查看详细进度')}");
                $(this).prev().css("height","64px");
            }
            parent.ReFrameHeight();
        })

        //付款
        $(".pay-btn").click(function(){
            var locateurl = "{$GLOBALS['cfg_basehost']}/member/index/pay/?ordersn={$info['ordersn']}";
            top.location.href = locateurl;
        })


        //显示协议
        $("#agreement_btn").click(function(){
            $(".agreement-term-content").show();
            adjust_agreement_pos();
        });
        $(window.parent).scroll(function(){
            adjust_agreement_pos();
        });


        //取消订单
        $(".cancel-btn").click(function(){
            var LayerDlg = parent && parent.layer ? parent.layer:layer;
            var url = SITEURL +'spots/member/ajax_order_cancel';
            LayerDlg.confirm('{__("order_cancel_content")}', {
                icon: 3,
                btn: ['{__("Abort")}','{__("OK")}'], //按钮
                btn1:function(){
                    LayerDlg.closeAll();
                },
                btn2:function(){
                    $.getJSON(url,{orderid:orderid},function(data){
                        if(data.status){
                            LayerDlg.msg('{__("order_cancel_ok")}', {icon:6,time:1000});
                            setTimeout(function(){location.reload()},1000);
                        }
                        else{
                            LayerDlg.msg('{__("order_cancel_failure")}', {icon:5,time:1000});
                        }
                    })
                },
                cancel:function(){
                    LayerDlg.closeAll();
                }
            })
        });

        //立即评论
        $(".pl-btn").click(function(){
            var url = "{$GLOBALS['cfg_basehost']}/member/order/pinlun?ordersn={$info['ordersn']}";
            top.location.href = url;
        })

    })



    function adjust_agreement_pos()
    {
        var top = $(window.parent).scrollTop();
        var w_height=$(window).height();
        if(top+550>w_height)
        {
            top= w_height-550;
        }
        $(".agreement-term-content").css({top:top,'margin':'0px 0 0 -400px'});
    }

</script>

{if $info['status']==2}
<script>
    $(function () {
        //申请退款
        $("#apply-refund-Click").on("click", function () {
            parent.layer.open({
                type: 2,
                title: "申请退款",
                area: ['560px','570px'],
                content: '{$cmsurl}spots/member/order_refund?ordersn={$info['ordersn']}',
                btn: ['确认', '取消'],
                btnAlign: 'C',
                closeBtn: 0,
                yes: function (index, b) {
                    var frm = parent.layer.getChildFrame('#refund_frm', index);
                    if(check_refund_frm(frm)==false)
                    {
                        return false;
                    }
                    parent.layer.close(index);
                    var data = $(frm).serialize();
                    refund_status(data);
                }
            });
        });
    });

    /**
     *
     * @param frm_data 表单验证
     */
    function check_refund_frm(frm_data)
    {
        var refund_reason = $(frm_data).find('textarea[name=refund_reason]').val();
        if(refund_reason.replace(/(^\s*)|(\s*$)/g, "").length<5)
        {
            parent.layer.open({
                content: '退款原因不能少于五个字',
                btn: ['{__("OK")}'],
            });
            return false;
        }
        var refund_auto = $(frm_data).find('input[name=refund_auto]').val();
        var platform = $(frm_data).find('input[name=platform]:checked').val();
        if(refund_auto!=1)
        {
            if(platform=='alipay')
            {
                var alipay_account = $(frm_data).find('input[name=alipay_account]').val();
                if(alipay_account.replace(/(^\s*)|(\s*$)/g, "").length<5)
                {
                    parent.layer.open({
                        content: '请填写正确的支付宝账号',
                        btn: ['{__("OK")}'],
                    });
                    return false;
                }
            }
            else if(platform=='bank')
            {
                var cardholder = $(frm_data).find('input[name=cardholder]').val();
                var cardnum = $(frm_data).find('input[name=cardnum]').val();
                var bank = $(frm_data).find('input[name=bank]').val();
                if(cardholder.length<1||cardnum.length<10||bank.length<2)
                {
                    parent.layer.open({
                        content: '请填写正确的银行卡信息',
                        btn: ['{__("OK")}'],
                    });
                    return false;
                }
            }
        }
        return true;
    }



    function refund_status(data) {
        $.post('{$GLOBALS["cfg_basehost"]}/spots/member/ajax_order_refund', data, function (result) {
            parent.layer.open({
                content: result.message,
                btn: ['{__("OK")}'],
                end:function(){
                    window.location.reload();
                }
            });
        }, 'json');
    }
</script>
{/if}
{if $info['status']==6}
<script>
    $(function () {
        //取消退款
        $("#cancel-refund-Click").on("click", function () {
            parent.layer.open({
                type: 1,
                title: "取消退款",
                area: ['480px', '250px'],
                content: '<div id="cancel-refund" class="cancel-refund"><p>确定取消退款申请？</p></div>',
                btn: ['确认', '取消'],
                btnAlign: 'c',
                closeBtn: 0,
                yes: function (index, b) {
                    parent.layer.close(index);
                    //提交信息
                    refund_status({'ordersn': '{$info['ordersn']}'});
                }
            });
        });
    });
    function refund_status(data) {
        $.post('{$GLOBALS["cfg_basehost"]}/spots/member/ajax_order_refund_back', data, function (result) {
            parent.layer.open({
                content: result.message,
                btn: ['{__("OK")}'],
                end:function(){
                    window.location.reload();
                }
            });
        }, 'json');
    }
</script>
{/if}



</body>
</html>