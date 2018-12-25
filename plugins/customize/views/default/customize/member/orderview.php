<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    {template "pub/varname"}
    {Common::css('base.css,user_new.css')}
    {Common::load_skin()}
    {Common::js('jquery.min.js,base.js,jquery.validate.js,jquery.validate.addcheck.js,city/jquery.cityselect.js')}
    {Common::js('layer/layer.js',0)}
    <script src="/tools/js/ajaxform.js"></script>
</head>
<body>
<div class="user-content-wrap fr" style="overflow:hidden">
    <div class="condition-col">
        <span class="item-child fl">{__('订单号')}：{$info['ordersn']}</span>
        <span class="item-child fl">{__('订单状态')}：{$info['statusname']}</span>
        {if $info['status']=='1'}
        <a class="cancel-btn fr" href="javascript:;">{__('取消订单')}</a>
        <a class="pay-btn fr" href="javascript:;">{__('立即付款')}</a>
        {/if}
        {if $info['status']=='0'}
         <a class="cancel-btn fr" href="javascript:;">{__('取消订单')}</a>
        {/if}
    </div>
    <!-- 订单状态 -->
    <div class="order-show-speed">
        <div class="order-speed-step">
            <ul class="clearfix">
                <li class="step-first cur">
                    <em></em>
                    <strong></strong>
                    <span>{__('提交需求')}</span>
                </li>
                <li class="step-second {if $info['status']==0}active{else}cur{/if}">
                    <em></em>
                    <strong></strong>
                    <span>{__('客服处理中')}</span>
                </li>
                {if $info['status']==3}
                <li class="step-third active"  >
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
                <li class="step-third {if $info['status']>1}cur{elseif $info['status']==1}active{/if}"  >
                    <em></em>
                    <strong></strong>
                    <span>{__('获得旅行方案')}</span>
                </li>
                <li class="step-fourth {if $info['status']>2}cur{elseif $info['status']==2}active{/if}" >
                    <em></em>
                    <strong></strong>
                    <span>{__('等待消费')}</span>
                </li>
                <li class="step-fifth {if $info['status']==5}active{/if}" >
                    <em></em>
                    <strong></strong>
                    <span>{__('交易完成')}</span>
                </li>
                {/if}
            </ul>
        </div>
        <div class="speed-show-list">
            {php $log_list = Model_Member_Order_Log::get_list($info['id']);}
            <ul class="info-list" style="height: auto;">
                {loop $log_list $log}
                <li><span>{date('Y-m-d H:i:s',$log['addtime'])}</span><span>{$log['description']}</span></li>
                {/loop}
            </ul>
            {if count($log_list)>2}
            <div id="more-info" class="more-info up">{__('收起详细进度')}</div>
            {/if}
        </div>
    </div>
    <!-- 订单进度 -->
    <div class="os-term">
        <div class="os-tit">{__('定制需求')}</div>
        <div class="os-block">
            <div class="custom-xq">
                <div class="info-list clearfix">
                    <ul>
                        <li><strong>{__('目的地')}：</strong>{$customize_info['dest']}</li>
                        <li><strong>{__('出发日期')}：</strong>{date('Y-m-d',$customize_info['starttime'])}</li>
                        <li><strong>{__('出游天数')}：</strong>{$customize_info['days']}天</li>
                        <li><strong>{__('成人')}：</strong>{$customize_info['adultnum']}人</li>
                        <li><strong>{__('儿童')}：</strong>{$customize_info['childnum']}人</li>
                    </ul>
                    <ul>
                        <li><strong>{__('出发地')}：</strong>{$customize_info['startplace']}</li>
                        {loop $extend_fields $key $field}
                          {php if($key==4) break;}
                        <li>
                            <strong>{$field['chinesename']}：</strong>{$extend_info[$field['fieldname']]}
                        </li>
                        {/loop}
                    </ul>
                    <ul>
                        {loop $extend_fields $key $field}
                        {php if($key<4) continue;}
                        <li>
                            <strong>{$field['chinesename']}：</strong>{$extend_info[$field['fieldname']]}
                        </li>
                        {/loop}
                    </ul>
                </div>
                <div class="txt-box">
                    <h4 class="txt-tit">{__('备注')}：</h4>
                    <p class="txt-con">{$customize_info['content']}</p>
                </div>
            </div>
        </div>
    </div>
    <!-- 定制需求 -->
    <div class="os-term">
        <div class="os-tit">{__('旅行方案')}</div>
        <div class="os-block">
            <div class="travel-case">
                <div class="case-item">
                    <h4 class="tit">{$customize_info['title']}</h4>
                    <div class="txt">{$customize_info['case_content']}</div>
                </div>
                <div class="case-info">
                    {if !empty($customize_info['linedoc'])}
                    <p class="xz">{__('方案附件')}：
                        {loop $customize_info['linedoc']['path'] $k $v}
                            <a href="{$v}">{$customize_info['linedoc']['name'][$k]}</a>&nbsp;&nbsp;
                        {/loop}
                    </p>
                    {/if}
                    <p class="jg">{__('方案报价')}：<span><i class="currency_sy">{Currency_Tool::symbol()}</i>{$info['price']}</span></p>

                    {if !empty($supplier)}
                    <p class="fa">{__('方案提供商')}：{$supplier['suppliername']}</p>
                    <p class="lx">{__('联系电话')}：{$supplier['mobile']} {if !empty($supplier['mobile'])}<span>(*{__('如有疑问？请电话联系')})</span>{/if}</p>
                    {/if}
                </div>
            </div>
        </div>
    </div>


    <!-- 联系人信息 -->
    <div class="os-term">
        <div class="os-tit">{__('联系人信息')}</div>
        <div class="os-block">
            <div class="linkman-info clearfix">
                <div class="item-block">
                    <em>{__('联系人')}：</em>
                    <p>{$customize_info['contactname']}</p>
                </div>
                <div class="item-block">
                    <em>{__('手机号')}：</em>
                    <p>{$customize_info['phone']}</p>
                </div>
                <div class="item-block">
                    <em>{__('邮箱')}：</em>
                    <p>{$customize_info['email']}</p>
                </div>
                <div class="item-block bz">
                    <em>{__('备注')}：</em>
                    <p>{$customize_info['content']}</p>
                </div>
            </div>
        </div>
    </div>
    <form method="post" id="frm" action="{$cmsurl}customize/member/order_save" target="_top">
    <!-- 联系人信息 -->

  {st:member action="order_tourer" orderid="$info['id']" return="tourer"}
    {if $info['status']==1}
    <div class="os-term">
        <div class="os-tit">{__('游客信息')}</div>
        <div class="os-block">

            {st:member action="linkman" memberid="$mid" return="tourerlist"}
            {if !empty($tourerlist[0]['linkman'])}
            <div class="select-linkman">
                <div class="bt">{__('选择常用旅客')}：</div>
                <div class="son" id="tourer_con">
                    {loop $tourerlist $tl}
                       <span data-name="{$tl['linkman']}" data-cardtype="{$tl['cardtype']}" data-idcard="{$tl['idcard']}" class="cs-tourer-item"><i class=""></i>{$tl['linkman']}</span>
                    {/loop}
                </div>
                {if count($tourerlist)>5}
                <div class="more" id="tourer_more">{__('更多')}&gt;</div>
                <script>
                    $("#tourer_more").click(function(){
                         if($(this).hasClass('expanded'))
                         {
                             $("#tourer_con").css('height',30);
                             $(this).html("{__('更多')}&gt;");
                         }
                         else
                         {
                             $("#tourer_con").css('height','auto');
                             $(this).html("&lt;{__('隐藏')}");
                         }
                         $(this).toggleClass('expanded');
                        window.parent.ReFrameHeight();
                    });
                </script>
                {/if}
            </div>
            {/if}
            <div class="user-table-info clear">
                <table margin_padding=zkOzDt >
                    {php for($i=0;$i<$customize_info['totalnum'];$i++){  }
                    <tbody>
                    <tr>
                        <td colspan="4" height="20"></td>
                    </tr>
                    <tr>
                        <th width="10%"><strong class="yk">{__('旅客')}{php echo $i+1;}</strong></th>
                        <td width="15%"><span class="name">{__('姓名')}：</span></td>
                        <td width="20%"><input type="text" name="t_tourername[{$i}]" class="default-text" value="{$tourer[$i]['tourername']}"></td>
                        <td><input type="hidden" name="t_touerid[{$i}]" value="{$tourer[$i]['id']}"/></td>
                    </tr>
                    <tr>
                        <td colspan="4" height="10"></td>
                    </tr>
                    <tr>
                        <th>&nbsp;</th>
                        <td><span class="name">{__('证件类型')}：</span></td>
                        <td>
                            <select class="drop-down" name="t_cardtype[{$i}]" >
                               <option value="">{__('请选择')}</option>
                               <option value="{__('护照')}" {if $tourer[$i]['cardtype']=='护照'}selected="selected"{/if}>{__('护照')}</option>
                               <option value="{__('身份证')}" {if $tourer[$i]['cardtype']=='身份证'}selected="selected"{/if}>{__('身份证')}</option>
                               <option value="{__('台胞证')}" {if $tourer[$i]['cardtype']=='台胞证'}selected="selected"{/if}>{__('台胞证')}</option>
                               <option value="{__('港澳通行证')}" {if $tourer[$i]['cardtype']=='港澳通行证'}selected="selected"{/if}>{__('港澳通行证')}</option>
                               <option value="{__('军官证')}" {if $tourer[$i]['cardtype']=='军官证'}selected="selected"{/if}>{__('军官证')}</option>
                               <option value="{__('出生日期')}" {if $tourer[$i]['cardtype']=='出生日期'}selected="selected"{/if}>{__('出生日期')}</option>
                            </select>
                        </td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="4" height="10"></td>
                    </tr>
                    <tr>
                        <th>&nbsp;</th>
                        <td><span class="name">{__('证件号码')}：</span></td>
                        <td><input type="text" class="default-text" name="t_cardnumber[{$i}]" value="{$tourer[$i]['cardnumber']}"/></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="4" height="20"></td>
                    </tr>
                    </tbody>
                    {php } }
                </table>
            </div>
        </div>
    </div>
    {/if}
    <!-- 游客信息 -->
    {if $info['status']>1 &&!empty($tourer)}

    <div class="os-term">
        <div class="os-tit">{__('游客信息')}</div>
        <div class="os-block">
            <div class="user-bm-info">
                <ul class="clearfix">
                    {if !empty($tourer)}
                    {loop $tourer $k $t}
                    <li class="{php if(($k+1)%4==0) echo 'mr_0';}">
                        <p><em>{__('姓名')}：</em><span>{$t['tourername']}</span></p>
                        <p><em>{__('证件类型')}：</em><span>{$t['cardtype']}</span></p>
                        <p><em>{__('证件号码')}：</em><span>{$t['cardnumber']}</span></p>
                    </li>
                    {/loop}
                   {/if}
                </ul>
            </div>
        </div>
    </div>

    {/if}

    {st:member action="order_bill" orderid="$info['id']" return="bill"}
    <!-- 游客信息 -->
    {if $info['status']==1}
    <div class="os-term">
        <div class="os-tit">{__('发票信息')}</div>
        <div class="os-block">
            <div class="st-item-block">
                <div class="receipt-nav check-con">
                    <span  data-val="1" {if !empty($bill)}class="on"{/if}><i class="ico"></i>{__('需要发票')}</span>
                    <span {if empty($bill)}class="on"{/if} data-val="0"><i class="ico"></i>{__('不需要发票')}</span>
                    <input type="hidden" id="isneedbill" name="isneedbill" value="0"/>
                </div>
                <ul {if empty($bill)}style="display:none"{/if} id="voice_con">
                    <li>
                        <strong class="item-hd">{__('发票金额')}：</strong>
                        <div class="item-bd">
                            <span class="jg-num payprice"><i class="currency_sy">{Currency_Tool::symbol()}</i>{$info['payprice']}</span>
                            <span class="ts-txt">({__('发票奖于您出游归来后5个工作日开具并由快递寄出，请注意查收')})</span>
                        </div>
                    </li>
                    <li>
                        <strong class="item-hd">{__('发票明细')}：</strong>
                        <div class="item-bd">
                            <span class="pt-txt">{__('旅游费')}</span>
                        </div>
                    </li>
                    <li>
                        <strong class="item-hd">{__('发票抬头')}：</strong>
                        <div class="item-bd">
                            <input type="text" class="default-text w300 fl" name="bill_title" value="{$bill['title']}" placeholder="{__('请填写个人姓名或公司名称')}">

                        </div>
                    </li>
                    <li>
                        <strong class="item-hd">{__('收件人')}：</strong>
                        <div class="item-bd">
                            <input type="text" class="default-text w300 fl" name="bill_receiver" value="{$bill['receiver']}" placeholder="{__('请详细填写收件人姓名')}">

                        </div>
                    </li>
                    <li>
                        <strong class="item-hd">{__('联系电话')}：</strong>
                        <div class="item-bd">
                            <input type="text" class="default-text w300 fl" name="bill_phone" value="{$bill['mobile']}" placeholder="{__('请详细填写收件人电话')}">

                        </div>
                    </li>
                    <li>
                        <strong class="item-hd">{__('收货地址')}：</strong>
                        <div class="item-bd" id="city">
                            <select class="drop-down prov" name="bill_prov">

                            </select>
                            <select class="drop-down ml5 city" name="bill_city">
                            </select>
                            <input type="text" class="default-text mt10 w700" name="bill_address" value="{$bill['address']}" placeholder="{__('请填写详细地址')}">
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    {/if}
    <!-- 发票信息 -->


    {if !empty($bill) && $info['status']>1}
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
                    <li><em>{__('收货地址')}：</em>{$bill['address']}</li>
                </ul>
            </div>
        </div>
    </div>
    {/if}
    <!-- 发票信息 -->
    {if $info['status']==1}
    <div class="os-term">
        <div class="os-tit">{__('优惠信息')}</div>
        <div class="os-block">
            <div class="order-show-cheap">
            <ul>

                {if !empty($info['iscoupon'])}
                <li><em>{__('优惠券')}：</em>{Currency_Tool::symbol()}{$info['iscoupon']['cmoney']}（{$info['iscoupon']['name']}）</li>
                <input type="hidden" id="coupon_price" value="{$info['iscoupon']['cmoney']}"/>
                {/if}

                {if $info['usejifen']}
                <li><em>{__('积分抵现')}：</em><i class="currency_sy">{Currency_Tool::symbol()}</i>{$info['jifentprice']}</li>
                <input type="hidden" id="usejifen" name="usejifen" value="{$info['usejifen']}"/>
                <input type="hidden" id="jifentprice" value="{$info['jifentprice']}"/>
                <span id="jifen_tprice" style="display: none">{$info['jifentprice']}</span>
                {/if}
            </ul>
           </div>
            {if empty($info['iscoupon']) || empty($info['usejifen'])}
            <div class="item-yh clear">
                {if empty($info['iscoupon'])}
                <div class="item-nr" id="coupon_con">
                    {if St_Functions::is_normal_app_install('coupon')}
                    {request 'coupon/box-'.$typeid.'-'.$info['id']}
                    {/if}
                    <script>
                        $("#coupon_con h3").remove();
                    </script>
                </div>
                {/if}
                {if empty($info['usejifen'])}
                    <div class="item-nr">
                                        <span class="use-jf">
                                            <label>使用：</label>
                                            <input type="text" name="needjifen" id="jifen_need" class="jf-num"/>
                                            积分抵扣
                                        </span>
                        <span class="dk-num">- {Currency_Tool::symbol()}<span id="jifen_tprice">0</span></span>
                        <span class="not-full" id="jifen_error"></span>
                        <span class="cur-jf">最多可使用{$customize_info['maxtpricejifen']}积分抵扣{Currency_Tool::symbol()}{$customize_info['maxjifentprice']}，我当前积分：{$user['jifen']}</span>
                        <input type="hidden" id="jifen_exchange" value="{$GLOBALS['cfg_exchange_jifen']}"/>
                        <input type="hidden" id="jifen_maxuse" value="{if $customize_info['maxtpricejifen']>$user['jifen']}{$user['jifen']}{else}{$customize_info['maxtpricejifen']}{/if}"/>
                    </div>
                {/if}
            </div>
            {/if}
        </div>
    </div>
    {/if}

    <!-- 优惠信息 -->
    {if (!empty($info['iscoupon'])||$info['usejifen']) && $info['status']>1 }
    <div class="os-term">
        <div class="os-tit">{__('优惠信息')}</div>
        <div class="os-block">
            <div class="order-show-cheap">
                <ul>
                    {if !empty($info['iscoupon'])}
                    <li><em>{__('优惠券')}：</em>-{Currency_Tool::symbol()}{$info['iscoupon']['cmoney']}（{$info['iscoupon']['name']}）</li>
                    {/if}
                    {if $info['usejifen']}
                    <li><em>{__('积分抵现')}：</em><i class="currency_sy">{Currency_Tool::symbol()}</i>{$info['jifentprice']}</li>
                    {/if}
                </ul>
            </div>
        </div>
    </div>
    {/if}
    <div class="os-term">
        <div class="os-tit">{__('支付信息')}</div>
        <div class="os-block">
            <div class="order-show-cheap">
                <ul>
                    <li><em>{__('支付方式')}：</em>{$info['paytype_name']} </li>
                    {if $GLOBALS['cfg_order_agreement_open']==1&& $info['status']>1}
                    <li><em>{__('预定协议')}：</em><span class="check-ht" id="agreement_btn">《{$GLOBALS['cfg_order_agreement_title']}》</span></li>
                    {/if}
                </ul>
            </div>
        </div>
    </div>
    <!-- 优惠信息 -->
    {if !empty($info['eticketno']) && Product::is_app_install('stourwebcms_app_supplierverifyorder')}
    <div class="os-term">
        <div class="os-tit">{__('消费码')}</div>
        <div class="os-block">
            <div class="order-show-code">
                <p class="txt"><em>{__('短信消费码')}：</em>{$info['eticketno']}</p>
                <div class="pic"><img src="/res/vendor/qrcode/make.php?param={$info['eticketno']}"></div>
            </div>
        </div>
    </div>
    {/if}
    <!-- 消费码 -->
    <div class="os-term">
        <div class="os-tit">{__('结算信息')}</div>
        <div class="os-block">
            <div class="order-item-count clearfix">
                <div class="item-nr">
                    <div class="item-list"><strong class="hd">{__('商品总额')}：</strong><span class="jg"><i class="currency_sy">{Currency_Tool::symbol()}</i>{$info['totalprice']}</span></div>
                    <div class="item-list"><strong class="hd">{__('商品优惠')}：</strong><span class="jg" id="reward_price">{Currency_Tool::symbol()}{php echo $info['payprice']-$info['totalprice']; }</span></div>
                    <hr>
                    <div class="item-total"><strong class="hd">{__('应付总额')}：</strong><span class="jg payprice"><i class="currency_sy" >{Currency_Tool::symbol()}</i>{$info['payprice']}</span></div>
                    {if $info['status']=='1' && $GLOBALS['cfg_order_agreement_open']==1}
                    <div class="agree-order-term">
                        <label class="radio-label"><input type="checkbox" class="check-btn" name="agreement">{__('同意')}</label>
                        <a class="xy-link" href="javascript:;" id="agreement_btn">《{$GLOBALS['cfg_order_agreement_title']}》</a>
                    </div>
                    {/if}
                </div>
            </div>
        </div>
    </div>
        <input type="hidden" name="customizeid" value="{$customize_info['id']}"/>
        <input type="hidden" id="totalprice" value="{$info['totalprice']}"/>
        <input type="hidden" id="total_price" value="{$info['totalprice']"/>
        <input type="hidden" id="orderid" value="{$info['id']}"/>
     </form>
    <div class="condition-col">
        <span class="item-child">{__('在线支付')}：<strong class="jg payprice"><i class="currency_sy" >{Currency_Tool::symbol()}</i>{$info['payprice']}</strong></span>
        {if $info['status']=='1'}
        <a class="pay-btn fr" href="javascript:;">{__('立即付款')}</a>
        {/if}
    </div>
    <!-- 支付结算 -->

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
        var ordersn = "{$info['ordersn']}";
        var status = "{$info['status']}";

        $(function(){

            //积分改动
            $("#jifen_need").change(function(){
                 var jifen = parseInt($("#jifen_need").val());
                 jifen=!jifen?0:jifen;
                 var jifen_exchange = $("#jifen_exchange").val();
                 var jifen_maxuse = $("#jifen_maxuse").val();
                 if(jifen>jifen_maxuse)
                 {
                     $("#jifen_error").text("积分超过使用限制");
                     $("#jifen_tprice").text(0);
                     get_total_price();
                     return;
                 }
                 var tprice = Math.floor(jifen/jifen_exchange);
                 $("#jifen_tprice").text(tprice);
                 $("#jifen_error").text("");
                 get_total_price();
            });

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
            })

            //初始化总价
            if(status=='1')
            {
                get_total_price();
            }
            //提交
            $(".pay-btn").click(function(){
                if($('#jifen_error').text() != ''){
                    parent.layer.msg($('#jifen_error').text(),{icon:5});
                    return false;
                }
                 $("#frm").submit();
            });

            $("#agreement_btn").click(function(){
                $(".agreement-term-content").show();
                adjust_agreement_pos();
            });
            $(window.parent).scroll(function(){
                adjust_agreement_pos();
            });


            //验证有效性
            $("#frm").validate({
                submitHandler: function(form) {
                    form.submit();
                },
                errorClass: 'st-ts-text',
                errorElement: 'span',
                rules: {
                    bill_title:{
                        required:{
                            depends: function(element) {
                                return $("#isneedbill").val()==1?true:false;
                            }
                        }
                    },
                    bill_receiver:{
                        required:{
                            depends: function(element) {
                                return $("#isneedbill").val()==1?true:false;
                            }
                        }
                    },
                    bill_phone:{
                        required:{
                            depends: function(element) {
                                return $("#isneedbill").val()==1?true:false;
                            }
                        }
                    },
                    agreement:{
                        required:true
                    }
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).attr('style', 'border:1px solid red');
                },
                unhighlight: function (element, errorClass) {
                    $(element).attr('style', '');
                },
                messages: {
                    bill_title:{
                        required:'{__('请填写个人姓名或公司名称')}'
                    },
                    bill_receiver:{
                        required:'{__('请详细填写收件人姓名')}'
                    },
                    bill_phone:{
                        required:'{__('请详细填写收件人电话')}'
                    }
                    ,
                    agreement:{
                        required:'{__('请先同意协议')}'
                    }
                },
                errorPlacement: function (error, element) {
                     if($(element).parent().is('td'))
                     {
                         $(element).parent().next().append(error);
                     }
                    else if($(element).attr('name')=='agreement')
                    {
                        $(element).parent().next().after(error);
                        window.parent.ReFrameHeight();
                    }
                     else
                     {
                         $(element).after(error);
                     }
                }
            });
            //添加验证
            $("input[name^='t_tourername'").each(function(){
                $(this).rules("remove");
                $(this).rules("add", {required: true, messages: {required: "{__('请填写游客姓名')}"}});
            });
            $("select[name^='t_cardtype'").each(function(){
                $(this).rules("remove");
                $(this).rules("add", {required: true, messages: {required: "{__('请选择证件类型')}"}});
            });
            $("input[name^='t_cardnumber'").each(function(){
                $(this).rules("remove");
                $(this).rules("add", {required: true, messages: {required: "{__('请填写证件号码')}"}});
            });

            //省市选择
            $("#city").citySelect({
                nodata:"none",
                'prov':"{$bill['province']}",
                'city':"{$bill['city']}",
                required:false
            });

           //是否需要发票
           $(".check-con span i").click(function(){
                var ele = $(this).parent();
                if(!ele.hasClass('on'))
                {
                    var val=ele.data('val');
                    ele.addClass('on');
                    ele.siblings().removeClass('on');
                    ele.siblings('input:hidden').val(val);
                    if(val==1)
                    {
                        $("#voice_con").show();
                    }
                    else
                    {
                        $("#voice_con").hide();
                    }
                    window.parent.ReFrameHeight();
                }
           });

           //选择游客
            $('.cs-tourer-item i').click(function(){
                 var pele=$(this).parent();
                 var name=pele.data('name');
                 var cardtype=pele.data('cardtype');
                 var idcard=pele.data('idcard');

                  if($(this).hasClass('on'))
                  {
                      $(this).removeClass('on');
                      $(".user-table-info tbody").each(function(){
                            var t_touerername=$(this).find("input[name^='t_tourername']").val();
                            if(t_touerername==name)
                            {
                                $(this).find('input').val('');
                                $(this).find('select option:first').attr('selected',true);
                            }
                      });
                  }
                  else
                  {

                      var is_selected=false;
                      $(".user-table-info tbody").each(function(){
                          if(is_selected==true)
                             return;
                          var t_touerername=$(this).find("input[name^='t_tourername']").val();
                          if(t_touerername=='')
                          {
                              $(this).find("input[name^='t_tourername']").val(name).valid();
                              $(this).find("select").find("option[value='"+cardtype+"']").attr('selected',true);
                              $(this).find("select").valid();

                              $(this).find("input[name^='t_cardnumber']").val(idcard).valid();
                              is_selected=true;
                          }
                      });
                      if(is_selected)
                      {
                          $(this).addClass('on');
                      }
                  }

            });

            //积分选择
            $(".use-jf label i").click(function(){
                $(this).parent().toggleClass('on');
                 if($(this).parent().hasClass('on'))
                 {
                     $("#usejifen").val(1);
                 }
                 else
                 {
                     $("#usejifen").val(0);
                 }
                 get_total_price();

            });

            //取消订单
            $(".cancel-btn").click(function(){
                var LayerDlg = parent && parent.layer ? parent.layer:layer;

                    var orderid = $("#orderid").val();
                    var url = SITEURL +'customize/member/ajax_order_cancel';
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



        })

        function get_total_price(a)
        {

            var totalprice=$("#totalprice").val();
            var jifentprice=parseInt($("#jifen_tprice").text());
            jifentprice=!jifentprice?0:jifentprice;

            var prev_totalprice=totalprice-jifentprice;

            $("#total_price").val(prev_totalprice);
            var coupon_price=Number($("#coupon_price").val());
            coupon_price=!coupon_price?0:coupon_price;
            var reward_price = coupon_price+jifentprice;
            var payprice=prev_totalprice-coupon_price;
            $("#reward_price").html('<i class="currency_sy" >'+CURRENCY_SYMBOL+'</i>'+reward_price);
            $(".payprice").html('<i class="currency_sy" >'+CURRENCY_SYMBOL+'</i>'+payprice);
            if(payprice<0)
            {
                on_negative_totalprice();
            }
        }
        //当价格小于0时
        function on_negative_totalprice()
        {
            parent.layer.msg("{__('优惠价超过了原价')}",{icon:5});
            $("#jifen_need").val(0);
            $("#jifen_need").trigger('change');
        }

        function coupon_callback(data)
        {
            if(data.status==1)
            {
                //$("#total_price").val(data.totalprice);
                $('#coupon_price').val(data.coupon_price);
            }
            else
            {
                $('#coupon_price').val(0);
                parent.layer.msg('{__('不符合使用条件')}',{icon:5})
                $('select[name=couponid] option:first').attr('selected','selected');
            }
            get_total_price();
        }
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
</div>
</body>
</html>