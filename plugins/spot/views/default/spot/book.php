<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>预订{$info['title']}-{$GLOBALS['cfg_webname']}</title>
    {include "pub/varname"}
    {Common::css_plugin('scenic.css','spot')}
    {Common::css('base.css,extend.css,stcalendar.css')}
    {Common::css_plugin('booking.css','spot')}
    {Common::js('jquery.min.js,base.js,common.js,SuperSlide.min.js,jquery.validate.js,jquery.validate.addcheck.js')}

</head>
<body style="background: #f6f6f6">

 {request "pub/header"}

<div class="big">
    <div class="wm-1200">
            <div class="st-guide">
                <a href="{$cmsurl}">{$GLOBALS['cfg_indexname']}</a>&nbsp;&nbsp;&gt;&nbsp;&nbsp;{$channelname}
            </div>
            <!--面包屑-->
            {if empty($userInfo['mid'])}
            <div class="order-hint-msg-box">
                <p class="hint-txt">温馨提示：<a href="{$cmsurl}member/login" id="fast_login">登录</a>可享受预定送积分、积分抵现！</p>
            </div>
            <!-- 未登录提示 -->
            {/if}
            <div class="clearfix">
                <div class="booking-l-container">
                    <form id="orderfrm" method="post" action="{$cmsurl}spot/create">
                        <div class="booking-info-block">
                            <div class="bib-hd-bar">
                                <h1 class="hb-title">{$suitInfo['title']}-{Model_Spot_Ticket_Type::get_info($suitInfo['tickettypeid'], 'kindname')}<a href="javascript:;" class="ticket-explain-btn" id="ticketExplain">门票说明</a></h1>
                                <div class="hb-number">产编号：{$info['series']}</div>
                            </div>
                            <div class="bib-bd-wrap">
                                <ul class="booking-item-block">
                                    <li>
                                        <span class="item-hd">使用日期：</span>
                                        <div class="item-bd">
                                            <input type="text" class="input-text w230 inputdate" id="inputdate" name="usedate"
                                                   value="{$info['usedate']}" readonly />
                                        </div>
                                    </li>
                                    <li>
                                        <span class="item-hd">门票信息：</span>
                                        <div class="item-bd">
                                            <table class="booking-price-table people_info">
                                                <thead>
                                                <tr>
                                                    <th width="25%" align="left"><span class="name">景点名称</span></th>
                                                    <th width="15%">门票类型</th>
                                                    <th width="13%">库存</th>
                                                    <th width="15%">售价</th>
                                                    <th width="18%">数量</th>
                                                    <th width="15%">小计</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td style="text-align: left;padding-left: 10px;">{$info['title']}</td>
                                                    <td class="suit_type">{Model_Spot_Ticket_Type::get_info($suitInfo['tickettypeid'], 'kindname')}</td>
                                                    <td class="suit_number">无</td>
                                                    <td>
                                                        <i class="currency_sy">{Currency_Tool::symbol()}</i>
                                                        <span class="suit_price">0</span>
                                                    </td>
                                                    <td>
                                                        <div class="booking-amount-control">
                                                            <span class="sub-btn sub is_order_number">-</span>
                                                            <input type="text" id="dingnum" name="dingnum" class="number-text" readonly value="1"/>
                                                            <span class="add-btn add is_order_number">+</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="o-price adult_total_price price suit-totalprice"></span>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!--预定信息-->
                        <div class="booking-info-block">
                            <div class="bib-hd-bar">
                                <span class="col-title">联系人信息</span>
                            </div>
                            <div class="bib-bd-wrap">
                                <ul class="booking-item-block">
                                    <li>
                                        <span class="item-hd"><i class="st-star-ico">*</i>姓名：</span>
                                        <div class="item-bd">
                                            <input type="text" class="input-text w230" name="linkman"
                                                   value="{$userInfo['truename']}" placeholder="" />
                                        </div>
                                    </li>
                                    <li>
                                        <span class="item-hd"><i class="st-star-ico">*</i>手机：</span>
                                        <div class="item-bd">
                                            <input type="text" class="input-text w230" name="linktel"
                                                   value="{$userInfo['mobile']}" placeholder="" />
                                        </div>
                                    </li>
                                    <li>
                                        <span class="item-hd">邮箱：</span>
                                        <div class="item-bd">
                                            <input type="text" class="input-text w230" name="linkemail"
                                                   value="{$userInfo['email']}" placeholder="" />
                                        </div>
                                    </li>
                                    <li>
                                        <span class="item-hd">预订备注：</span>
                                        <div class="item-bd">
                                            <textarea name="remark" cols="" rows="" class="text-area"></textarea>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!--联系人信息-->


                        {if $suitInfo['fill_tourer_type']!=='0'&&$suitInfo['fill_tourer_items']}
                        <div class="booking-info-block">
                            <div class="bib-hd-bar">
                                <span class="col-title">旅客信息</span>
                            </div>
                            {st:member action="linkman" memberid="$userInfo['mid']" return="tourerlist"}
                            {if !empty($userInfo) && !empty($tourerlist[0]['linkman'])}
                            <div class="bib-select-linkman">
                                <div class="bib-select-bar">选择常用旅客</div>
                                <div class="bib-select-bd">
                                    <div class="bib-select-box">
                                        {loop $tourerlist $row}
                                        <span class="check-item" data-linkman="{$row['linkman']}" data-cardtype="{$row['cardtype']}"
                                              data-idcard="{$row['idcard']}" data-sex="{$row['sex']}" data-mobile="{$row['mobile']}"><i class="check-icon"></i>{$row['linkman']}</span>
                                        {/loop}
                                    </div>
                                    {if count($tourerlist)>5}
                                    <a class="bib-check-more down" href="javascript:;">更多</a>
                                    {/if}
                                </div>
                            </div>
                            <script>
                                $(function () {
                                    //展开更多
                                    $(".bib-check-more").on("click",function(){
                                        if($(this).hasClass("down")){
                                            $(this).removeClass("down").text("收起").prev(".bib-select-box").css({
                                                "height": "auto"
                                            });
                                        }else{
                                            $(this).addClass("down").text("更多").prev(".bib-select-box").css({
                                                "height": "24px"
                                            });
                                        }
                                    });

                                    //选择游客
                                    $(".bib-select-box .check-item").click(function () {
                                        if($(this).hasClass("check-active-item")){
                                            $(this).removeClass("check-active-item")
                                        } else{
                                            $(this).addClass("check-active-item")
                                        }

                                        var t_linkman = $(this).attr('data-linkman');
                                        var t_cardtype = $(this).attr('data-cardtype');
                                        var t_idcard = $(this).attr('data-idcard');
                                        var t_sex = $(this).attr('data-sex');
                                        var t_mobile = $(this).attr('data-mobile');
                                        //已选中数量

                                        //总人数
                                        var total_num = parseInt($("#dingnum").val());
                                        var has_choose = $(".bib-select-box .check-item.check-active-item").length;

                                        //如果选中数量大于总人数,则取消选中.
                                        if (has_choose > total_num) {
                                            $(this).removeClass("check-active-item")
                                            return;
                                        }
                                        //如果是选中事件
                                        if ($(this).hasClass('check-active-item')) {
                                            $("#tourer_list .bib-linkman-block").each(function (i, obj) {
                                                if ($(obj).find('.t_name').first().val() == '') {
                                                    $(obj).find('.t_name').first().val(t_linkman);
                                                    $(obj).find('.t_cardtype').first().val(t_cardtype);
                                                    $(obj).find('.t_cardno').first().val(t_idcard);
                                                    $(obj).find('.t_mobile').first().val(t_mobile);
                                                    $(obj).find('.sex').each(function () {
                                                        if($(this).data('sex')==t_sex)
                                                        {
                                                            $(obj).find('.sex').removeClass('active');
                                                            $(this).addClass('active');
                                                            $(obj).parent().find('input:hidden').val(t_sex)
                                                        }
                                                    });
                                                    //身份证验证
                                                    $(obj).find('.t_cardno').first().rules("remove", 'required');
                                                    $(obj).find('.t_cardno').first().rules("remove", 'isIDCard');
                                                    $(obj).find('.t_cardno').first().rules("remove", 'date');
                                                    $(obj).find('.t_cardno').first().rules("remove", 'alnum');
                                                    if (t_cardtype== '身份证') {
                                                        $(obj).find('.t_cardno').first().rules('add', {required: true,isIDCard: true, messages: {required: "请输入身份证号码",isIDCard: "身份证号码不正确"}});
                                                    }else if(t_cardtype== '出生日期'){
                                                        $(obj).find('.t_cardno').first().rules("add", {required: true,date:true, messages: {required: "请输入出生日期",date: "日期格式不正确"}});
                                                    }else{
                                                        $(obj).find('.t_cardno').first().rules("add", {required: true,alnum:true,messages: {required: "请输入证件号"}});
                                                    }
                                                    return false;
                                                }
                                            })
                                        } else {
                                            $("#tourer_list .bib-linkman-block").each(function (i, obj) {
                                                if ($(obj).find('.t_name').first().val() == t_linkman
                                                    && $(obj).find('.t_cardno').first().val() == t_idcard
                                                    && $(obj).find('.t_cardtype').first().val() == t_cardtype
                                                    && $(obj).find('.t_mobile').first().val()==t_mobile
                                                ) {
                                                    $(obj).find('.t_name').first().val('');
                                                    $(obj).find('.t_cardno').first().val('');
                                                    $(obj).find('.t_cardtype').first().val('身份证');
                                                    $(obj).find('.t_mobile').first().val('');
                                                    if($(obj).find('.common-use-label').hasClass("active")){
                                                        $(obj).find('.common-use-label').removeClass("active")
                                                    }
                                                }
                                            })
                                        }
                                    })
                                })
                            </script>
                            {/if}
                            {/st}
                            <div class="visitor-msg" id="tourer_list"{if $suitInfo['fill_tourer_type']==1} data-max="1"{/if}{if $suitInfo['fill_tourer_items']} data-field="{$suitInfo['fill_tourer_items']}"{/if}>

                            </div>
                        </div>
                        <!--游客信息-->
                        {/if}
                        {if St_Functions::is_normal_app_install('coupon')}
                        {php}$coupon=Model_Coupon::get_pro_coupon($typeid,$info['id']);{/php}
                        {/if}
                        {if !empty($userInfo) && ($suitInfo['paytype']==1 || $suitInfo['paytype']==3)&&($coupon||!empty($userInfo) && !empty($jifentprice_info))}
                        <div class="booking-info-block">
                            <div class="bib-hd-bar">
                                <span class="col-title">优惠信息</span>
                            </div>
                            <div class="bib-bd-wrap">
                                <div class="bib-yh-block">
                                    <ul class="booking-item-block">
                                        {if $coupon}
                                        <li>
                                            <span class="item-hd">优惠券抵扣：</span>
                                            <div class="item-bd">
                                                <select name="couponid"  id="couponid-sel" class="select w230">
                                                    <option value="0">不使用</option>
                                                    {loop $coupon $l}
                                                    <option value="{$l['roleid']}"> {if $l['type']==1}  {$l['amount']}折{else}￥{$l['amount']}  {/if}（{$l['name']}：满{$l['samount']}可用）</option>
                                                    {/loop}
                                                </select>
                                            </div>
                                            <input type="hidden" id="coupon_price" value="">
                                            <script>
                                                $(function(){
                                                    $('#couponid-sel').change(function(){
                                                        var couponid = $(this).val();
                                                        set_coupon(couponid);
                                                    })
                                                })

                                                /**
                                                 * 设置优惠券
                                                 */
                                                function set_coupon(couponid)
                                                {
                                                    var totalprice = Number($("#total_price").val());
                                                    var typeid ={$typeid} ;
                                                    var proid ={$info['id']};
                                                    var startdate = $('input[name=usedate]').val();
                                                    if(!startdate)
                                                    {
                                                        startdate = $('input[name=startdate]').val();
                                                    }
                                                    if(couponid>0)
                                                    {
                                                        $.ajax({
                                                            type:"post",
                                                            url:SITEURL+'coupon/ajax_check_samount',
                                                            data:{couponid:couponid,totalprice:totalprice,typeid:typeid,proid:proid,startdate:startdate},
                                                            datatype:'json',
                                                            success:function(data){
                                                                data = JSON.parse(data);

                                                                if(typeof(coupon_callback)=='function')
                                                                {
                                                                    data['coupon_price']= ST.Math.sub(totalprice,data.totalprice);
                                                                    coupon_callback(data);
                                                                    return;
                                                                }
                                                                if(data.status==1)
                                                                {
                                                                    //$("#total_price").val(data.totalprice);
                                                                    $('#coupon_price').val(ST.Math.sub(totalprice,data.totalprice));

                                                                    $('.totalprice').html('<i class="currency_sy">' + CURRENCY_SYMBOL + '</i>' + data.totalprice);
                                                                }
                                                                else
                                                                {
                                                                    $('#coupon_price').val(0);
                                                                    layer.msg('不符合使用条件',{icon:5})
                                                                    $('select[name=couponid] option:first').attr('selected','selected');
                                                                }
                                                            }
                                                        })
                                                    }
                                                    else
                                                    {
                                                        $('#coupon_price').val(0);
                                                        get_total_price();
                                                    }
                                                }
                                            </script>
                                        </li>
                                        {/if}
                                        <!--优惠券-->
                                        {if !empty($userInfo) && !empty($jifentprice_info)}
                                        <li>
                                            <span class="item-hd">积分抵扣：</span>
                                            <div class="item-bd">
                                                <input type="text" id="needjifen"
                                                       data-exchange="{$jifentprice_info['cfg_exchange_jifen']}"
                                                       class="input-text w100 jf-num"
                                                       name="needjifen"/>
                                                <span class="ml10">积分抵扣<span class="c-red" id="jifentprice">{Currency_Tool::symbol()}0</span></span>
                                                <span class="ml10 c-999">最多可以使用{$jifentprice_info['toplimit']}积分抵扣<i class="currency_sy">{Currency_Tool::symbol()}</i>{$jifentprice_info['jifentprice']}，我当前积分：{$userInfo['jifen']}</span>
                                                <span class="jifen-error error-txt ml10" style="display: none;">积分不足</span>
                                            </div>
                                        </li>
                                        {/if}
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <script>
                            if($("#yhzc_tit").siblings().not('script,style').length==0)
                            {
                                $("#yhzc_tit").hide();
                            }
                        </script>
                        <!-- 优惠信息 -->
                        {/if}

                        <div class="booking-info-block">
                            {if $suitInfo['paytype']==2}
                            <div class="pay-info-bar">
                                <span class="item">应付定金：<span class="pri totalprice"></span></span>
                            </div>
                            {else}
                            <div class="pay-info-bar">
                                <span class="item">应付总额：<span class="pri totalprice"></span></span>
                                {if !empty($info['jifenbook_info'])&&$info['jifenbook_info']['value']!=0}
                                <span class="c-999 ml10">（预订赠送积分{if $info['jifenbook_info']['rewardway']==1}订单总额{$info['jifenbook_info']['value']}%的{else}{$info['jifenbook_info']['value']}{/if}分）</span>
                                {/if}
                            </div>
                            {/if}
                        </div>
                        <!-- 应付总额 -->

                        <div class="booking-info-block clearfix">
                            {if $GLOBALS['cfg_spot_order_agreement_open']==1}
                            <div class="fl booking-agreement-block mt10">
                                <span id="agreementBookingCheck" class="common-use-label {if $GLOBALS['cfg_spot_order_agreement_selected']==='1'}active{/if}"><i class="icon"></i>我已阅读并同意</span>
                                <a class="link" id="bkDocument" href="javascript:;">《预定须知》</a>
                            </div>
                            {/if}
                            <div class="fr booking-submit-block">
                                <span class="yzm-txt">验证码：</span>
                                <img class="yzm-label" src="{$cmsurl}captcha" onClick="this.src=this.src+'?math='+ Math.random()" width="80" height="32"/>
                                <input type="text" class="input-text w100 ml10" name="checkcode" id="checkcode" maxlength="4" />
                                <a class="booking-submit-btn ml10 tj-btn" href="javascript:;">提交订单</a>
                            </div>
                        </div>
                        <!--提交订单-->
                        {if $GLOBALS['cfg_spot_order_agreement_open']==1}
                        <div class="bk-document-box" style="display: none;" id="bkDocumentBox">
                            {$GLOBALS['cfg_spot_order_agreement']}
                        </div>
                        {/if}
                        <!-- 预订须知 -->

                        <div class="ticket-document-box" style="display: none;" id="ticketDocumentBox">
                            <div class="tickettype-nr">
                                {if $suitInfo['effective_days']}
                                <div class="tickettype-nr-sm">
                                    <strong class="hd">门票有效期</strong>
                                    <div class="bd">{if !empty($suitInfo['effective_days'])}
                                        {$suitInfo['effective_before_days_des']}
                                        {else}验票当天24:00前{/if}</div>
                                </div>
                                {/if}
                                {if !empty($suitInfo['get_ticket_way'])}
                                <div class="tickettype-nr-sm">
                                    <strong class="hd">取票方式</strong>
                                    <div class="bd">{$suit['get_ticket_way']}</div>
                                </div>
                                {/if}
                                <div class="tickettype-nr-sm">
                                    <strong class="hd">退改方式</strong>
                                    <div class="bd">{if $suitInfo['refund_restriction']==0}无条件退
                                        {elseif $suitInfo['refund_restriction']==1}不可退改
                                        {elseif $suitInfo['refund_restriction']==2}有条件退{/if}</div>
                                </div>
                                {if !empty($suitInfo['description'])}
                                <div class="tickettype-nr-sm">
                                    <strong class="hd">门票说明</strong>
                                    <div class="bd">
                                        {$suitInfo['description']}
                                    </div>
                                </div>
                                {/if}
                            </div>
                        </div>
                        <!-- 门票说明 -->
                        <!--订单内容-->

                        <!--隐藏域-->
                        <input type="hidden" name="productid" value="{$info['id']}"/>
                        <input type="hidden" name="webid" value="{$info['webid']}"/>
                        <input type="hidden" name="frmcode" value="{$frmcode}"><!--安全校验码-->
                        <input type="hidden" name="usejifen" id="usejifen" value="0"/><!--是否使用积分-->
                        <input type="hidden" id="price" value="{if $suitInfo['paytype']==2}{$suitInfo['dingjin']}{else}{$suitInfo['ourprice']}{/if}"/>
                        <input type="hidden" id="jifentprice" value="{$suitInfo['jifentprice']}"><!--积分抵现金额-->
                        <input type="hidden" name="suitid" id="suitid" value="{$suitInfo['id']}"/>
                        <input type="hidden" id="total_price" value=""/>

                    </form>
                    <input type="hidden" id="storage" value="0"/>
                    <input type="hidden" id="paytype" value="{$suitInfo['paytype']}"/>
                    <input type="hidden" id="dingjin" value="{$suitInfo['dingjin']}"/>
                </div>
                <div class="booking-r-container">
                    <div class="booking-side-total">
                        <div class="side-total-bar"><span class="tit">结算信息</span></div>
                        <div class="side-total-block">
                            <h4 class="side-total-tit">预订明细</h4>
                            <ul class="side-total-list">
                                <li>
                                    <span class="hd">预订方式</span>
                                    <span class="bd">{$suitInfo['paytype_name']}</span>
                                </li>
                                <li>
                                    <span class="hd">预定日期</span>
                                    <span class="bd todaydate">{date('Y-m-d',time())}</span>
                                </li>
                                <li>
                                    <span class="hd">使用日期</span>
                                    <span class="bd usedate">{$info['usedate']}</span>
                                </li>
                                <li>
                                    <span class="hd">景点名称</span>
                                    <span class="bd">{$info['title']}</span>
                                </li>
                                <li>
                                    <span class="hd">门票类型</span>
                                    <span class="bd">{Model_Spot_Ticket_Type::get_info($suitInfo['tickettypeid'], 'kindname')}</span>
                                </li>
                            </ul>
                        </div>

                        {if !empty($userInfo) && ($suitInfo['paytype']==1 || $suitInfo['paytype']==3)&&($coupon||!empty($userInfo) && !empty($jifentprice_info))}
                        <div class="side-total-block">
                            <h4 class="side-total-tit">优惠明细</h4>
                            <ul class="side-total-list" id="discount">
                                {if $coupon}
                                <li>
                                    <span class="hd">优惠券</span>
                                    <span class="bd coupon_price">未使用</span>
                                </li>
                                {/if}
                                {if !empty($userInfo) && !empty($jifentprice_info)}
                                <li>
                                    <span class="hd">积分抵扣</span>
                                    <span class="bd jifentprice">不抵扣</span>
                                </li>
                                {/if}
                            </ul>
                        </div>
                        {/if}
                        <div class="side-total-block hide">
                            <h4 class="side-total-tit">定金明细</h4>
                            <ul class="side-total-list">
                                <li>
                                    <span class="hd">应付定金额</span>
                                    <span class="bd">￥50×5</span>
                                </li>
                            </ul>
                        </div>
                        <div class="side-total-block side-amount-bar">
                            <ul class="side-total-list">
                                <li>
                                    <span class="hd">预订总额：</span>
                                    <span class="bd c-f60 order-total-price suit-totalprice">0</span>
                                </li>
                                {if !empty($userInfo) && ($suitInfo['paytype']==1 || $suitInfo['paytype']==3)&&($coupon||!empty($userInfo) && !empty($jifentprice_info))}
                                <li class="discount-total">
                                    <span class="hd">优惠总额</span>
                                    <span class="bd c-f60 discount-total-price">0</span>
                                </li>
                                {/if}
                                <li class="all-li">
                                    <span class="hd all-item">应付{if $suitInfo['paytype']==2}定金{else}总额{/if}</span>
                                    <span class="bd all-pri pay-total-price totalprice">0</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!--订单结算信息-->
            </div>
        </div>
        {request "pub/footer"}
        {Common::js('layer/layer.js',0)}
        {Common::js('datepicker/WdatePicker.js',0)}
        <div id="calendar" style="display: none"></div>
</div>
<script>

    var max_useful_jifen="{if $jifentprice_info['toplimit']>$userInfo['jifen']}{$userInfo['jifen']}{else}{$jifentprice_info['toplimit']}{/if}";
    $(function(){
        //门票说明
        $("#ticketExplain").on("click",function(){
            layer.open({
                type: 1,
                title: "门票说明",
                area: ['790px', '505px'],
                btn: ['确定'],
                btnAlign: "c",
                scrollbar: false,
                content: $('#ticketDocumentBox')
            });
        });

        $("#bkDocument").on("click",function(){
            layer.open({
                type: 1,
                title: "预订须知",
                area: ['900px', '500px'],
                btn: ['确定'],
                btnAlign: "c",
                scrollbar: false,
                content: $('#bkDocumentBox')
            });
        });

        init();
        function init(){
            var suitid = $("#suitid").val();
            var url = SITEURL + 'spot/suit_day_price';
            $.getJSON(url, {'inputdate':$('#inputdate').val(),'suitid':suitid}, function (data) {
                $('#price').val(data.price);
                $('.booking-price-table span.suit_price').text(data.price);
                $('#storage').val(data.number);
                if(data.number<0) {
                    $('.booking-price-table .suit_number').text('充足');
                }
                if(data.number==0) {
                    $('.booking-price-table .suit_number').text('无余票');
                }
                if(data.number>0) {
                    $('.booking-price-table .suit_number').text(data.number);
                }
                get_total_price();
            });
        }

        //积分计算
        $("#needjifen").on('keyup change',function(){
            jifentprice_update();
            get_total_price(1);
        });

        //预订须知合同
        $("#agreementBookingCheck").on("click",function(){
            if($(this).hasClass("active")){
                $(this).removeClass("active")
            }
            else{
                $(this).addClass("active")
            }
        });

        //出发日期选择
        $("#inputdate").click(function(){
            var suitid = $("#suitid").val();
            var date=$(this).val().split('-');
            get_calendar(suitid,this,date[0],date[1]);
        });
        $('body').delegate('.prevmonth,.nextmonth','click',function(){

            var year = $(this).attr('data-year');
            var month = $(this).attr('data-month');
            var suitid = $(this).attr('data-suitid');
            var contain =$(this).attr('data-contain');

            get_calendar(suitid,$("#"+contain)[0],year,month);

        });
        function get_calendar(suitid,obj,year,month){
            //加载等待
            layer.open({
                type: 3,
                icon: 2

            });
            var containdiv = '';
            if(obj){
                containdiv = $(obj).attr('id');
            }
            var url = SITEURL+'spot/dialog_calendar';

            $.post(url,{suitid:suitid,year:year,month:month,containdiv:containdiv},function(data){
                if(data){
                    $("#calendar").html(data);
                    $("#calendar").data(suitid,data);
                    show_calendar_box();

                }
            })
        }
        function show_calendar_box(){
            layer.closeAll();
            layer.open({
                type: 1,
                title:'',
                area: ['480px', '430px'],
                shadeClose: true,
                content: $('#calendar').html()
            });

        }


        //提交订单
        $('.tj-btn').click(function(){
            if($("div.booking-agreement-block").length>0)
            {
                if(!$("div.booking-agreement-block").find('span.common-use-label').hasClass('active'))
                {
                    layer.open({
                        content: '请先仔细阅读我们的预订条款',
                        btn: ['{__("OK")}']
                    });
                    return false;
                }
            }
            $("#orderfrm").submit();
        })

        //表单验证

        $("#orderfrm").validate({

            submitHandler:function(form){

                var flag = check_storage();
                if(!flag){
                    layer.open({
                        content: '{__("error_no_storage")}',
                        btn: ['{__("OK")}']
                    });
                    return false;

                }else{
                    ST.Util.showLoading({isfade:true,text:'提交中...'});
                    form.submit();
                }


            } ,
            errorClass:'st-ts-text',
            errorElement:'span',
            rules: {
                usedate:{
                    required: true
                },
                linkman:{
                    required: true

                },
                linktel:{
                    required:true,
                    isPhone:true

                },
                linkemail:{
                    email:true
                },
                needjifen:{
                    digits:true,
                    min:0,
                    max:parseInt(max_useful_jifen)
                },
                checkcode:{
                    required:true,
                    minlength:4,
                    remote: {
                        param: {
                            url: SITEURL + 'pub/ajax_check_code',
                            type: 'post',
                        },
                        depends : function(element) {
                            return element.value.length==4;
                        }

                    }
                }
            },
            messages: {
                usedate:{
                    required: "请选择使用日期"
                },
                linkman:{
                    required: "请填写联系人信息"
                },
                linktel:{
                    required: "请填写联系方式"
                },
                linkemail:{
                    email:'邮箱格式错误'
                },
                needjifen:{
                    digits:'请输入数字',
                    min:'不得小于0',
                    max:'超过抵扣上限'
                },
                checkcode:{
                    required: "请填写验证码",
                    minlength: "",
                    remote: "验证码错误"
                }
            },
            highlight: function(element, errorClass, validClass) {
                $(element).attr('style','border:1px solid red');
            },
            unhighlight:function(element, errorClass){
                $(element).attr('style','');
            },
            errorPlacement:function(error,element){
                if(element.is('#checkcode')) {
                    if($(error).text()!=''){
                        layer.tips('验证码错误', '#checkcode', {
                            tips: 3
                        });
                    }
                }
                else if(element.is('#needjifen'))
                {
                    $(".jifen-error").append(error);
                }
                else
                {
                    $(element).parent().append(error)
                }
            }
        });

        add_tourer();

        //数量减少
        $(".booking-price-table").find('.sub-btn').click(function () {
            var obj = $(this).parent().find('.number-text');
            var cur = Number(obj.val());
            if (cur > 1) {
                cur = cur - 1;
                obj.val(cur);
            }
            if(cur<1){
                cur=1;
            }
            var storage=Number($("#storage").val());
            if ((storage != '-1' && cur > storage)||storage==0) {
                layer.alert('{__("error_no_storage")}', {
                    icon: 5
                });
                $('.booking-submit-btn.tj-btn').addClass('disabled');
                return false;
            }else{
                $('.booking-submit-btn.tj-btn').removeClass('disabled');
            }
            $('.dingnum').html(cur);
            get_total_price();
            remove_tourer();
        })
        //数量添加
        $(".booking-price-table").find('.add-btn').click(function () {
            var obj = $(this).parent().find('.number-text');
            var cur = Number(obj.val());
            cur++;
            var storage=Number($("#storage").val());
            if ((storage != '-1' && cur > storage)||storage==0) {
                layer.alert('{__("error_no_storage")}', {
                    icon: 5
                });
                $('.booking-submit-btn.tj-btn').addClass('disabled');
                return false;
            }else{
                $('.booking-submit-btn.tj-btn').removeClass('disabled');
            }
            obj.val(cur);
            $('.dingnum').html(cur);
            get_total_price();
            add_tourer();
        });

        //使用积分抵现
        $('.use-jf label i').click(function(){
            var totalprice = Number($("#total_price").val());
            if($('.use-jf label').attr('class')!='on'){
                var jifentprice = Number($("#jifentprice").val());
                if(jifentprice > totalprice){
                    layer.alert('{__("can_not_tprice")}',{
                        icon:5
                    })
                    return false;
                }
            }
            $(this).parent().toggleClass('on');
            get_total_price(1);
        })

    })
    //选择日期
    function choose_day(day, containdiv){
        var old_date=$('#inputdate').val();
        var suitid = $("#suitid").val();
        var url = SITEURL + 'spot/suit_day_price';
        $.getJSON(url, {'inputdate':day,'suitid':suitid}, function (data) {
            if(data.number>0&&data.number<$("#dingnum").val()){
                layer.alert('{__("error_no_storage")}', {
                    icon: 5
                });
                $("#inputdate").val(old_date);
//                $('.booking-submit-btn.tj-btn').addClass('disabled');
                return false;
            }
            $('#price').val(data.price);
            $('.booking-price-table span.suit_price').text(data.price);
            $('#storage').val(data.number);
            if(data.number<0) {
                $('.booking-price-table .suit_number').text('充足');
            }
            if(data.number==0) {
                $('.booking-price-table .suit_number').text('无余票');
            }
            if(data.number>0) {
                $('.booking-price-table .suit_number').text(data.number);
            }
            get_total_price();
            $('.usedate').text(day);
        });
        $('#'+containdiv).val(day);
        layer.closeAll();
    }
    //检测库存
    function check_storage() {
        var startdate = $("#inputdate").val();
        var dingnum = $("#dingnum").val();
        var suitid = $("#suitid").val();
        var flag = 1;

        $.ajax({
            type: 'POST',
            url: SITEURL + 'spot/ajax_check_storage',
            data: {startdate: startdate,  dingnum: dingnum, suitid: suitid},
            async: false,
            dataType: 'json',
            success: function (data) {
                flag = data.status;
            }
        })
        return flag;

    }


    //获取总价
    function get_total_price(a){
        //选择积分的时候不重置优惠券
        var a = arguments[0] ? arguments[0] : 0;
        if(!a)
        {
            on_orgprice_changed();
        }
        var dingnum = Number($("#dingnum").val());
        var price = Number($("#price").val());
        if($("#paytype").val()==2)
        {
            var price = Number($("#dingjin").val());
        }


        price = ST.Math.mul(price,dingnum);
        var org_totalprice=price;
        $("#total_price").val(price);
        $(".suit-totalprice").html(CURRENCY_SYMBOL+price);

        //使用积分抵现
        var jifentprice = jifentprice_calculate();
        if(jifentprice)
        {
            $(".jifentprice").html(CURRENCY_SYMBOL + jifentprice);
            price = ST.Math.sub(price,jifentprice);
        }

        //设置优惠券
        var coupon_price=0;
        if($('#coupon_price').length>0)
        {
            coupon_price = $('#coupon_price').val();
        }
        if(coupon_price)
        {
            $(".coupon_price").html(CURRENCY_SYMBOL+coupon_price);
            price = ST.Math.sub(price,coupon_price);
        }
        if(price<0)
        {
            var negative_params={totalprice:price,jifentprice:jifentprice,couponprice:coupon_price,org_totalprice:org_totalprice};
            on_negative_totalprice(negative_params);
            return;
        }
        var discount_price=ST.Math.add(Number(coupon_price),Number(jifentprice));
        $(".discount-total-price").html(CURRENCY_SYMBOL+discount_price);

        $(".totalprice").html('<i class="currency_sy">'+CURRENCY_SYMBOL+'</i>'+price);
    }

    //性别选择
    $('body').delegate('.sex','click',function(){
        $(this).addClass("active").siblings().removeClass("active");
        $(this).siblings('input:hidden').val($(this).attr("data-sex"));
    });

    /*生成tourer html*/
    function add_tourer() {
        if($("#tourer_list").length<1)
        {
            return false;
        }
        var total_num = parseInt($("#dingnum").val());

        var html = '';
        var hasnum = $("#tourer_list").find('.bib-linkman-block').length;
        hasnum = !hasnum ? 0 : hasnum;
        var only_one=$("#tourer_list").attr('data-max');
        if(only_one==1)
        {
            total_num=1;
        }
        if(only_one==1&&hasnum==1)
        {
            return false;
        }

        if (hasnum > total_num) {
            var cur_index = total_num - 1;
            $("#tourer_list .bib-linkman-block:gt(" + cur_index + ")").remove();
        }
        var fields_str=$("#tourer_list").attr('data-field');
        if(fields_str){
            var fields_arr=fields_str.split(",");
        }
        for (var i = hasnum; i < total_num; i++) {
            var index=hasnum+1;
            html += '<div class="bib-linkman-block clearfix"><div class="hd-box">旅客' + index + '</div>';
            html += '<div class="bd-box"><ul class="booking-item-block">';

            if($.inArray("tourername",fields_arr)>=0)
            {
                //姓名
                html += '<li><span class="item-hd"><i class="st-star-ico">*</i>旅客姓名：</span>';
                html +='<div class="item-bd"><input type="text" class="input-text w230 t_name" name="t_name[' + i + ']" placeholder="" />';
                html += '</div></li>';
            }
            if($.inArray("sex",fields_arr)>=0)
            {
                //性别
                html += '<li> <span class="item-hd"><i class="st-star-ico">*</i>旅客性别：</span>';
                html += '<div class="item-bd"> <div class="bib-radio-box">';
                html += '<input type="hidden" name="t_sex[' + i + ']" value="男">';
                html += '<span class="bib-radio-label active sex" data-sex="男">';
                html += '<i class="radio-icon"></i>男</span><span class="bib-radio-label sex" data-sex="女">';
                html += '<i class="radio-icon"></i>女</span></div></div></li>';
            }
            if($.inArray("mobile",fields_arr)>=0)
            {
                //手机
                html += '<li> <span class="item-hd"><i class="st-star-ico">*</i>手机号码：</span><div class="item-bd">';
                html +='<input type="text" class="input-text w230 t_mobile" id="t_mobile_'+i+'" name="t_mobile[' + i + ']" placeholder=""></div></li>';
            }
            if($.inArray("cardnumber",fields_arr)>=0)
            {
                //证件
                html += '<li><span class="item-hd"><i class="st-star-ico">*</i>证件类型：</span> <div class="item-bd">';
                html += '<select class="select w230 t_cardtype" id="t_cardtype_'+i+'" name="t_cardtype[' + i + ']"> <option value="身份证">身份证</option><option value="护照">护照</option><option value="台胞证">台胞证</option>';
                html += '<option value="港澳通行证">港澳通行证</option> <option value="军官证">军官证</option> <option value="出生日期">出生日期</option> </select> </div> </li>';
                //证件号码
                html += '<li> <span class="item-hd"><i class="st-star-ico">*</i>证件号码：</span><div class="item-bd"><input type="text" class="input-text w230 t_cardno" id="t_cardno_'+i+'" name="t_cardno[' + i + ']"  placeholder="">';
                html += '</div></li>';
            }

            //存为联系人
            html += '<li><span class="item-hd">&nbsp;</span><div class="item-bd">';
            html += '<span class="common-use-label mt10 save-linkman"><i class="icon"></i>存为常用联系人</span><input type="hidden" name="t_issave['+i+']" value="0"></div></li>';
            html += '</ul></div></div>';
        }
        $("#tourer_list").append(html);
        //选择保存到常用
        $('#tourer_list').on('click','.save-linkman',function () {
            if($(this).hasClass('active'))
            {
                $(this).removeClass('active');
                $(this).next('input:hidden').val(0);
            }
            else
            {
                $(this).addClass('active');
                $(this).next('input:hidden').val(1);
            }
        });

//        if (hasnum == 0) {
//            var tourname = "{$userInfo['truename']}";
//            var tour_mobile = "{$userInfo['mobile']}";
//            var tour_idcard = "{$userInfo['cardid']}";
//            var obj = $("#tourer_list").find('div.bib-linkman-block').first();
//            obj.find('.t_name').val(tourname);
//            obj.find('.t_mobile').val(tour_mobile);
//            obj.find('.t_cardno').val(tour_idcard);
//            obj.find('.t_cardtype').val('身份证');
//        }
        //动态添加游客姓名
        $("input[name^='t_name']").each(
            function (i, obj) {
                $(obj).rules("remove");
                $(obj).rules("add", {required: true,byteRangeLength:true, messages: {required: "请输入姓名",byteRangeLength:'最大支持4个中文汉字'}});

            }
        );
        //证件类型
        $("input[name^='t_cardno']").each(
            function (i, obj) {
                $(obj).rules("remove");
                var id = $(obj).attr('id').replace('t_cardno_', '');
                $(obj).rules("remove", 'required');
                $(obj).rules("remove", 'isIDCard');
                $(obj).rules("remove", 'date');
                $(obj).rules("remove", 'alnum');
                if ($('#t_cardtype_' + id).val()== '身份证') {
                    $(obj).rules('add', {required: true,isIDCard: true, messages: {required: "请输入身份证号码",isIDCard: "身份证号码不正确"}});
                }else if($('#t_cardtype_' + id).val()== '出生日期'){
                    $(obj).rules("add", {required: true,date:true, messages: {required: "请输入出生日期",date: "日期格式不正确"}});
                }else{
                    $(obj).rules("add", {required: true,alnum:true,messages: {required: "请输入证件号"}});
                }
            }
        );
        //手机号
        $("input[name^='t_mobile']").each(
            function (i, obj) {
                $(obj).rules("remove");
                $(obj).rules("add", {required: true,isMobile:true, messages: {required: "请输入手机号码",isMobile: "请输入正确的手机号"}});
            }
        );
        //身份证验证
        $('#tourer_list').on('change', '.t_cardtype',function(){
            var id = $(this).attr('id').replace('t_cardtype_', '');
            $("span[for='t_cardno_"+id+"']").remove();
            $('#t_cardno_' + id).val('');
            $('#t_cardno_' + id).rules("remove", 'required');
            $('#t_cardno_' + id).rules("remove", 'isIDCard');
            $('#t_cardno_' + id).rules("remove", 'date');
            $('#t_cardno_' + id).rules("remove", 'alnum');
            $('#t_cardno_' + id).removeAttr("placeholder");
            if ($(this).val()== '身份证') {
                $('#t_cardno_' + id).rules('add', {required: true,isIDCard: true, messages: {required: "请输入身份证号码",isIDCard: "身份证号码不正确"}});
            }else if($(this).val()== '出生日期'){
                $('#t_cardno_' + id).rules("add", {required: true,date:true, messages: {required: "请输入出生日期",date: "日期格式不正确"}});
                $('#t_cardno_' + id).attr('placeholder','格式:yyyy-mm-dd');
            }else{
                $('#t_cardno_' + id).rules("add", {required: true,alnum:true,messages: {required: "请输入证件号"}});
            }
        });
        jQuery.validator.addMethod("byteRangeLength", function(value, element) {
            var length = 0;
            for(var i = 0; i < value.length; i++){
                if(value.charCodeAt(i) > 127){
                    length++;
                }
                else
                {
                    length += 0.5;
                }
            }
            return this.optional(element) || ( length >= 0 && length <= 4 );
        }, $.validator.format("最大支持4个中文汉字"));
    }
    //结算
    var windowHeight = $(window).height();
    var offSetTop = $(".booking-side-total").offset().top;
    $(window).scroll(function(){
        if( $(window).scrollTop() > offSetTop ){
            $(".booking-side-total").addClass("booking-side-fixed");
            if( $(".booking-side-total").height() > windowHeight ){
                $(".booking-side-fixed").css({
                    "bottom":"0",
                    "overflow-y":"auto"
                })
            }
        }
        else{
            $(".booking-side-total").removeClass("booking-side-fixed")
        }
    });

    /*移除tourer*/
    function remove_tourer() {
        if($("#tourer_list").length<1)
        {
            return false;
        }
        var hasnum = $("#tourer_list").find('.bib-linkman-block').length;
        hasnum = !hasnum ? 0 : hasnum;
        if(hasnum==1)
        {
            return false;
        }
        $("#tourer_list .bib-linkman-block").last().remove();
    }
    //计算积分抵现价格
    function jifentprice_calculate()
    {
        var needjifen=parseInt($("#needjifen").val());
        if(!needjifen||needjifen<=0)
            return 0;
        var exchange=$("#needjifen").data('exchange');
        var price=Math.floor(ST.Math.div(needjifen,exchange));
        return price;
    }
    //重设积分,即积分置0
    function jifentprice_reset()
    {
        $("#needjifen").val(0);
        jifentprice_update();

    }
    //更新积分价格
    function jifentprice_update()
    {
        var price=jifentprice_calculate();
        $("#jifentprice").html(CURRENCY_SYMBOL+price);
    }

    //重置优惠券
    function coupon_reset()
    {
        $('select[name=couponid] option:first').attr('selected','selected');//优惠券重置
        $('#coupon_price').val(0);

    }
    //当总价小于0时
    function on_negative_totalprice(params)
    {
        layer.msg('优惠价格超过产品总价，请重新选择优惠策略',{icon:5,time:2200})
        jifentprice_reset();
        coupon_reset();
        get_total_price(1);
    }
    //当原始价格发生改变时
    function on_orgprice_changed()
    {
        coupon_reset();
        jifentprice_reset();
    }

    //优惠券回调
    function coupon_callback(data)
    {
        if(data.status==1)
        {

            $('#coupon_price').val(data['coupon_price']);
            get_total_price(1);
        }
        else
        {
            coupon_reset();
            layer.msg('不符合使用条件',{icon:5})
        }
    }
</script>
<div id="calendar"></div>
{if empty($userInfo['mid'])}
{Common::js('jquery.md5.js')}
{include "member/login_fast"}
 <script>
     $('#fast_login').click(function(){
         $('#is_login_order').removeClass('hide');
         return false;
     });
 </script>
{/if}
</body>
</html>
