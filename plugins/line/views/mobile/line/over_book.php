<!doctype html>
<html>
<head ul_clear=4otJVl >
    <meta charset="utf-8">
    <title>{$info['title']}预订-{$webname}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    {Common::css('mobilebone.css,base.css,add-passenger.css,reset-style.css,style-new.css,invoice.css')}
    {Common::css_plugin('line.css','line')}
    {Common::js('jquery.min.js,lib-flexible.js,swiper.min.js,mobilebone.js,delayLoading.min.js,jquery.layer.js,validate.js')}
    {Common::js('layer/layer.js',0)}
    <script>
        Mobilebone.evalScript = true;
    </script>
</head>

<body>

<div class="page out" id="pageHome">

    {request "pub/header_new/typeid/$typeid/isbookpage/1"}
    <!-- 公用顶部 -->

    <div class="page-content book-content-first">

        <section>
            <form action="{$cmsurl}line/create" id="orderfrm" method="post">
                <div class="wrap-content">

                {if empty($userinfo['mid'])}
                <div class="login-hint-txt">
                    温馨提示：<a class="login-link" href="{$cmsurl}member/login" data-ajax="false">登录</a>可享受预订送积分、积分抵现！
                </div>
                {/if}
                <!-- 温馨提示 -->

                <div class="booking-info-block clearfix">
                    <h3 class="block-tit-bar"><strong class="no-style">预订信息</strong></h3>
                    <div class="line-name-block">
                        <div class="tit">{$info['title']}</div>
                        <div class="num">产品编号：{$info['lineseries']}</div>
                    </div>
                    <ul class="line-info-block">
                        <li>
                            <div class="item-hd">预订套餐</div>
                            <div class="item-bd">{$suitinfo['suitname']}</div>
                        </li>
                        <li>
                            <div class="item-hd">预订方式</div>
                            {if $suitinfo['paytype']==1}
                            <div class="item-bd">全额预订</div>
                            {elseif $suitinfo['paytype']==2}
                            <div class="item-bd">定金预订</div>
                            {/if}

                        </li>
                        <li>
                            <div class="item-hd">出发日期</div>
                            <div class="item-bd">{$params['usedate']}</div>
                        </li>
                        <li>
                            <div class="item-hd">出游人数</div>
                            <div class="item-bd">
                                {if $params['dingnum']}
                                {$params['dingnum']}成人
                                {/if}
                                {if $params['childnum']}
                                {$params['childnum']}儿童
                                {/if}
                                {if $params['oldnum']}
                                {$params['oldnum']}老人
                                {/if}
                                {if $params['roombalancenum']}
                                {$params['roombalancenum']}单房差
                                {/if}
                            </div>
                        </li>
                    </ul>
                </div>
                <!-- 产品信息 -->

                <div class="booking-info-block clearfix">
                    <h3 class="block-tit-bar"><strong class="no-style">联系信息</strong></h3>
                    <div class="block-item">
                        <ul>
                            <li>
                                <strong class="item-hd no-style">姓名：</strong>
                                <input  type="text" name="linkman" id="field_linkman"   class="write-info" value="{$userinfo['truename']}" placeholder="请填写真实姓名" />
                                <span class="nd">(必填)</span>
                            </li>
                            <li>
                                <strong class="item-hd no-style">手机号码：</strong>
                                <input type="text" name="linktel" id="field_linktel" value="{$userinfo['mobile']}" class="write-info" placeholder="请输入常用手机号码" />
                                <span class="nd">(必填)</span>
                            </li>
                            <li>
                                <strong class="item-hd no-style">电子邮箱：</strong>
                                <input type="text" name="linkemail"  class="write-info" placeholder="请输入常用电子邮箱" />
                            </li>
                        </ul>
                    </div>
                    <div class="block-remarks">
                        <strong class="item-hd no-style">订单备注：</strong>
                        <textarea name="remark" class="item-txt"></textarea>
                    </div>
                </div>
                <!-- 订单联系人 -->
                {if $GLOBALS['cfg_write_tourer']==1}
                <div class="booking-info-block clearfix" id="tourer_con">
                    <h3 class="block-tit-bar"><strong class="no-style">旅客信息</strong>
                        {if !empty($userinfo['mid'])}<a class="yk-check-link fr" href="#commonUse">选择常用游客<i class="more-ico"></i></a>{/if}
                    </h3>
                    <div class="block-item">
                        <?php for ($i=1;$i<=$params['total'];$i++): ?>
                        <ul >
                            <li>
                                <strong class="item-bt no-style">旅客{$i}</strong>
                                <input type="hidden" name="t_issave[{$i}]" value="0">
                                <span class="common tour_save"><i></i>存为常用旅客</span>
                            </li>
                            <li>
                                <strong class="item-hd no-style">姓名</strong>
                                <input type="text" class="write-info tourer_linkman tourer_tourername" fieldname="tourername" name="t_tourername[{$i}]" placeholder="请填写真实姓名" />
                                <span class="nd">(必填)</span>
                            </li>
                            <li>
                                <strong class="item-hd no-style t_cardtype"><span class="t_cardtype_txt">身份证</span><input type="hidden" fieldname="cardtype" class="field_t_cardtype" name="t_cardtype[{$i}]" value="身份证"/><i class="down-ico"></i></strong>
                                <input type="text" class="write-info tourer_idcard" fieldname="cardnumber" name="t_cardnumber[{$i}]" placeholder="请输入证件号码" />
                                <span class="nd">(必填)</span>
                            </li>
                            <li class="tourer_item_sex">
                                <strong class="item-hd no-style">性别</strong>
                                <div class="sex-bar">
                                    <span class="check-label-item sex_male checked" data-value="男"><i class="icon"></i>男</span>
                                    <span class="check-label-item sex_female" data-value="女"><i class="icon"></i>女</span>
                                    <input type="hidden" fieldname="sex" name="t_sex[{$i}]" value="男"/>
                                </div>
                            </li>
                            <li>
                                <strong class="item-hd no-style">手机号</strong>
                                <input type="text" class="write-info tourer_mobile" fieldname="mobile" name="t_mobile[{$i}]" placeholder="请输入手机号" />
                            </li>
                        </ul>
                        <?php endfor; ?>

                    </div>
                </div>
                {/if}
                <!-- 游客信息 -->

                {if !empty($userinfo) && $suitinfo['paytype']!=2}
                {request "line/discount?productid=".$info['id']}
                {/if}
                <!-- 优惠政策 -->
                {if $GLOBALS['cfg_invoice_open_1']==1}
               <!-- <div class="made-receipt">
                    <strong class="no-style">开具发票</strong>
                    <i class="check-box"></i>
                </div>
                <div class="receipt-item hide">
                    <ul>
                        <li>
                            <strong class="fp-hd no-style">发票抬头：</strong>
                            <input type="text" class="fp-info" name="bill_title" placeholder="请填写个人姓名或公司名称" >
                        </li>
                        <li>
                            <strong class="fp-hd no-style">收件人：</strong>
                            <input type="text" class="fp-info" name="bill_receiver" placeholder="请填写姓名" >
                        </li>
                        <li>
                            <strong class="fp-hd no-style">联系电话：</strong>
                            <input type="text" class="fp-info" name="bill_mobile" placeholder="手机号码" >
                        </li>
                        <li>
                            <strong class="fp-hd no-style">收货地址：</strong>
                            <textarea name="bill_address" class="fp-info" placeholder="输入收货地址，支持换行"></textarea>
                        </li>
                    </ul>
                </div> -->

                    <div class="booking-info-block clearfix" id="invoice_book_con">
                        <div class="invoice-block">
                            <ul class="">
                                <li class="invoice_book_type">
                                    <a class="all" href="#editInvoice">
	                                    <span class="item">
	                                        <strong>发票</strong>
	                                    </span>
                                        <span class="more-type"><em class="txt">不开发票</em><i class="more-ico"></i></span>
                                        <input type="hidden" class="has_invoice" name="usebill" value="0"/>
                                    </a>
                                </li>
                                <li class="invoice_book_title" style="display: none;">
                                    <a class="all" href="javascript:;">
	                                    <span class="item">
	                                        <strong>发票抬头</strong>
	                                    </span>
                                        <span class="more-type"><em class="txt"></em></span>
                                    </a>
                                </li>
                                <li class="invoice_book_address" style="display: none">
                                    <a class="all" href="#editInvoiceAddress">
	                                    <span class="item">
	                                        <strong>邮寄地址</strong>
	                                    </span>
                                        <span class="more-type"><em class="txt"></em><i class="more-ico"></i></span>
                                    </a>
                                </li>

                            </ul>
                            <div class="invoice_book_hid">
                            </div>
                            <div class="invoice_book_address_hid">
                            </div>
                        </div>
                    </div>



                <!-- 开具发票 -->
                {/if}
                    {if $GLOBALS['cfg_line_order_agreement_open']==1||$info['contract']}
                <div class="agreement-block">
                    <i {$GLOBALS['cfg_line_order_agreement_selected']} class="check-box {if $GLOBALS['cfg_line_order_agreement_selected']!=='0'}on{/if}"></i>我已阅读并同意
                    {if $GLOBALS['cfg_line_order_agreement_open']==1}
                    <a href="#bkDocumentContent">《预订须知》</a>
                    {/if}
                    {if $info['contract']}
                    <a href="#htDocumentContent">《{$info['contract']['title']}》</a>
                    {/if}
                </div>
                    {/if}
                <!-- 预订协议 -->
                <input type="hidden" name="suitid" id="field_suitid"  value="{$suitinfo['id']}" />
                <input type="hidden" name="productid" id="field_productid" value="{$info['id']}"/>
                <input type="hidden" name="dingnum" id="field_dingnum" value="{$params['dingnum']}"/>
                <input type="hidden" name="oldnum" id="field_oldnum" value="{$params['oldnum']}"/>
                <input type="hidden" name="childnum" id="field_childnum" value="{$params['childnum']}"/>
                <input type="hidden" name="roombalance_num" id="field_roombalance_num" value="{$params['roombalancenum']}"/>
                <input type="hidden" name="startdate" id="field_startdate" value="{$params['usedate']}"/>
                <input type="hidden" name="couponid" id="couponid"  value=""/>
                <input type="hidden" name="needjifen"  id="needjifen"  value="0"/>
                <input type="hidden" name="envelope_member_id"  id="envelope_member_id"  value="0"/>
                <input type="hidden" name="roombalance_paytype" id="field_roombalance_paytype"   value="1"/>
<!--                    拼团id-->
                <input type="hidden" name="join_id" id="join_id"   value="{$params['join_id']}"/>

                <input type="hidden" id="field_price" value="0"/>
                <input type="hidden" id="field_adultprice" value="{$suitPrice['adultprice']}"/>
                <input type="hidden" id="field_childprice" value="{$suitPrice['childprice']}"/>
                <input type="hidden" id="field_oldprice" value="{$suitPrice['oldprice']}"/>
                <input type="hidden" id="field_roombalance" value="{$suitPrice['roombalance']}"/>
                <input type="hidden" id="field_dingjin" value="{$suitinfo['dingjin']}"/>
                <input type="hidden" id="field_paytype" value="{$suitinfo['paytype']}"/>
                <input type="hidden" id="org_total_price" value="0"/>
                <input type="hidden" id="coupon_price" value="0"/>
                <input type="hidden" id="envelope_price" value="0"/>
                <input type="hidden" id="max_useful_jifen" value="{if $jifentprice_info['toplimit']>$userinfo['jifen']}{$userinfo['jifen']}{else}{$jifentprice_info['toplimit']}{/if}"/>
                <input type="hidden" id="jifentprice_limit" value="{$jifentprice_info['toplimit']}"/>
                <input type="hidden" id="jifentprice_price" value="{$jifentprice_info['jifentprice']}"/>
                <input type="hidden" id="jifentprice_exchange" value="{$jifentprice_info['cfg_exchange_jifen']}"/>
                {St_Product::form_token()}
            </div>
            </form>
        </section>



        <div class="fee-box hide" id="fee-box">
            <div class="fee-container">
                <div class="fee-row">
                    <p class="ze">
                        <strong class="no-style">应付总额</strong>
                        <em class="fr no-style" id="board_total"></em>
                    </p>
                    <p class="sm hide" id="board_dingjin" ></p>
                </div>
                <ul class="mx-list">
                    {if $params['dingnum']>0}
                    <li class="hide">
                        <strong class="no-style">{$suitinfo['suitname']}({$params['dingnum']}成人)</strong>
                        <em class="no-style" id="org_adult_total"></em>
                    </li>
                    {/if}
                    {if $params['childnum']>0}
                    <li class="hide">
                        <strong class="no-style">{$suitinfo['suitname']}({$params['childnum']}儿童)</strong>
                        <em class="no-style" id="org_child_total"></em>
                    </li>
                    {/if}
                    {if $params['oldnum']>0}
                    <li class="hide">
                        <strong class="no-style">{$suitinfo['suitname']}({$params['oldnum']}老人)</strong>
                        <em class="no-style" id="org_old_total"></em>
                    </li>
                    {/if}
                    {if $params['roombalancenum']>0}
                    <li class="board_roombalance">
                        <strong class="no-style">单房差（预付）</strong>
                        <em class="no-style"></em>
                    </li>
                    {/if}
                    <li>
                        <span class="zk">-(扣减)</span>
                    </li>
                    <li class="board_discount">
                        <strong class="no-style">积分抵现</strong>
                        <em class="no-style" id="board_jifentprice">0</em>
                    </li>
                    {if St_Functions::is_normal_app_install('coupon')}
                    <li class="board_discount">
                        <strong class="no-style">优惠券</strong>
                        <em class="no-style" id="board_coupon">{Currency_Tool::symbol()}0</em>
                    </li>
                    {/if}
                    {if St_Functions::is_normal_app_install('red_envelope')}
                    <li class="board_discount">
                        <strong class="no-style">红包抵扣</strong>
                        <em class="no-style" id="board_envelope">{Currency_Tool::symbol()}0</em>
                    </li>
                    {/if}
                </ul>
            </div>
        </div>
        <!-- 费用明细 -->

        <div class="foo-box hide" id="cardtype_con">
            <div class="tc-container">
                <div class="tc-tit-bar"><strong class="bt no-style">选择证件类型</strong><i class="close-icon"></i></div>
                <div class="tc-wrapper">
                    <ul>
                        <li class="active"><em class="item no-style">身份证</em><i class="radio-btn"></i></li>
                        <li ><em class="item no-style">护照</em><i class="radio-btn"></i></li>
                        <li><em class="item no-style">台胞证</em><i class="radio-btn"></i></li>
                        <li><em class="item no-style">军官证</em><i class="radio-btn"></i></li>
                        <li><em class="item no-style">港澳通行证</em><i class="radio-btn"></i></li>
                        <li ><em class="item no-style">出生日期</em><i class="radio-btn"></i></li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- 证件选择 -->
        <div class="bom-fixed-content"></div>


    </div>

    <div class="bom-fixed-block">
        <span class="total">
            <em class="jg no-style" id="bbar_paytotal"></em>
        </span>
        <span class="order-show-list" id="order-show-list">明细<i class="arrow-up-ico"></i></span>
        <a class="now-booking-btn" href="javascript:;">立即预订</a>
    </div>
    <!-- 立即预订 -->

</div>

<div class="page out"  id="commonUse">
    <header>
        <div class="header_top">
            <a class="back-link-icon" href="javascript:;" data-rel="back"></a>
            <h1 class="page-title-bar">选择常用旅客</h1>
        </div>
    </header>
    <!-- 公用顶部 -->
    <div class="page-content">
        <p class="passenger-prompt">请从下方选择常用旅客信息，需选择（1/1）</p>
        <div class="passenger-all-list" id="linkman-list">

        </div>
        <div class="onload-box">
            <div class="onloading hide"><i></i>加载中</div>
            <div class="network-erro hide"><i></i>网络异常，加载失败</div>
            <div class="no-passenger hide">
                <i></i>
                暂无常用旅客，赶紧新增常用旅客
            </div>
        </div>
    </div>
</div>

{if $GLOBALS['cfg_line_order_agreement_open']}
<div class="page out" id="bkDocumentContent">
    <header>
        <div class="header_top">
            <a class="back-link-icon" href="javascript:;"  data-rel="back"></a>
            <h1 class="page-title-bar">预订须知</h1>
        </div>
    </header>
    <!-- 公用顶部 -->
    <div class="page-content">
        <div class="bk-document-page">
            <div class="bk-content-wrap">
                {Common::content_image_width($GLOBALS['cfg_line_order_agreement'],540,0)}

            </div>
        </div>
    </div>
</div>
{/if}
{if $info['contract']['content']}
<div class="page out" id="htDocumentContent">
    <header>
        <div class="header_top">
            <a class="back-link-icon"  href="javascript:;" data-rel="back"></a>
            <h1 class="page-title-bar">旅游合同</h1>
        </div>
    </header>
    <!-- 公用顶部 -->
    <div class="page-content">
        <div class="bk-document-page">
            {Common::content_image_width($info['contract']['content'],540,0)}
        </div>
    </div>
</div>
{/if}

{if St_Functions::is_normal_app_install('coupon')}{request "coupon/box_new-$typeid-".$info['id']}{/if}
{if St_Functions::is_normal_app_install('red_envelope')}{request "envelope/product_book/typeid/$typeid/"}{/if}

{request "pub/code"}

{request "invoice/choose/typeid/1"}
{request "invoice/address/typeid/1"}

<script>
    var init_suitid = "{$suitid}";
    var CURRENCY_SYMBOL="{Currency_Tool::symbol()}";
    var productid = "{$info['id']}";
    $(function () {
        //证件类型选择
        $(".t_cardtype").click(function(){
            $("#cardtype_con").show();
            var cur_field=this;
            var now_val =  $(cur_field).find('.t_cardtype_txt').text();

            $("#cardtype_con li").removeClass('active');
            $("#cardtype_con li").each(function () {
                if($(this).text()==now_val)
                {
                    $(this).addClass('active');
                }
            });
            $("#cardtype_con li").unbind();
            $("#cardtype_con li").click(function(){
                var val=$(this).text();
                $(cur_field).find('.t_cardtype_txt').text(val);
                $(cur_field).find('.field_t_cardtype').val(val);
                $(cur_field).siblings('input[fieldname="cardnumber"]').val('');
                if(val==='出生日期'){
                    $(cur_field).siblings('input[fieldname="cardnumber"]').attr('placeholder','请选择日期');
                    $(cur_field).siblings('input[fieldname="cardnumber"]').attr('type','date');
                }else{
                    $(cur_field).siblings('input[fieldname="cardnumber"]').attr('placeholder','请输入证件号码');
                    $(cur_field).siblings('input[fieldname="cardnumber"]').attr('type','text');
                }
            });
        });
        $("#cardtype_con").click(function () {
            $(this).hide();
        });
        $("#cardtype_con .list li").click(function () {

        });
        //游客性别选择
        $(document).on('click','.tourer_item_sex .check-label-item',function(){
            $(this).addClass('checked');
            $(this).siblings().removeClass('checked');
            var val=$(this).data('value');
            $(this).siblings('input:hidden').val(val);
        })

        //发票选择
        $(".made-receipt .check-box").on("click", function () {
            if (!$(this).hasClass("on")) {
                $(this).addClass("on");
                $(".receipt-item").show();
                $("#field_usebill").val(1);
            }
            else {
                $(this).removeClass("on");
                $(".receipt-item").hide();
                $("#field_usebill").val(0);
            }
        });
        //明细列表
        $("#order-show-list").click(function(){
            $("#fee-box").removeClass("hide")
        });
        $("#fee-box").click(function(){
            $(this).addClass("hide")
        });
        $('.agreement-block .check-box').click(function () {
            if($(this).hasClass('on'))
            {
                $(this).removeClass('on')
            }
            else
            {
                $(this).addClass('on')
            }
        });
        get_total_price();


    });




</script>

<!--预订部分JS-->
<script>
    $(function(){

        $(".now-booking-btn").click(function(){
            var check_status=check_form();
            if(check_status)
            {
                $("#orderfrm").submit();
            }
        });


        function check_form()
        {

            if($('.agreement-block .check-box').length>0&&!$('.agreement-block .check-box').hasClass('on'))
            {
                $.layer({type:1, icon:2,time:1000, text:'请确认同意并仔细阅读预订须知'});
                return false;
            }
            var suitid=$("#field_suitid").val();
            var dingnum=$("#field_dingnum").val();
            var oldnum =$("#field_oldnum").val();
            var childnum=$("#field_childnum").val();
            var linkman=$("#field_linkman").val();
            var linktel=$("#field_linktel").val();
            if(!suitid)
            {
                $.layer({type:1, icon:2,time:1000, text:'请至少选择一个套餐'});
                return false;
            }

            //预订数量
            var totalnum = dingnum+oldnum+childnum;
            if(totalnum<1)
            {
                $.layer({type:1, icon:2,time:1000, text:'预订数量不能为0'});
                return false;
            }

            //联系人
            if(!linkman)
            {
                $.layer({type:1, icon:2,time:1000, text:'联系人不能为空'});
                return false;
            }

            if(!linktel)
            {
                $.layer({type:1, icon:2,time:1000, text:'联系人手机号码不能为空'});
                return false;
            }
            if (!Validate.mobile(linktel)) {
                $.layer({type:1, icon:2,time:1000, text:'联系人手机号码格式错误'});
                return false;
            }



            //游客所有信息
            var is_tourer_checked=false;
            $("#tourer_con .block-item ul li input").each(function(){
                if(is_tourer_checked)
                {
                    return;
                }
                var desc=$(this).siblings('.item-hd').text();
                var fieldname=$(this).attr('fieldname');
                desc=fieldname=='cardtype'?'证件类型':desc;
                var value=$(this).val();
                if(fieldname=='mobile')
                {
                    if(!Validate.mobile(value)&&value)
                    {
                        $.layer({type:1, icon:2,time:1000, text:'游客手机号码格式错误'});
                        is_tourer_checked=true;
                    }
                }
                else if(fieldname=='cardnumber')
                {
                    var cardtype=$(this).parents('li:first').find('.field_t_cardtype').val();
                    if(cardtype=='身份证')
                    {
                        if(!Validate.idcard(value))
                        {
                            $.layer({type:1, icon:2,time:1000, text:'游客身份证不正确'});
                            is_tourer_checked=true;
                        }
                    }
                    else
                    {
                        if(!value)
                        {
                            $.layer({type:1, icon:2,time:1000, text:'游客'+desc+'不能为空'});
                            is_tourer_checked=true;
                        }
                    }
                }
                else  if(fieldname=='tourername')
                {
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

                    if(length==0||length>4)
                    {
                        $.layer({type:1, icon:2,time:1000, text:'游客'+desc+'不正确'});
                        is_tourer_checked=true;
                    }
                }
                else
                {
                    if(!value)
                    {
                        $.layer({type:1, icon:2,time:1000, text:'游客'+desc+'不能为空'});
                        is_tourer_checked=true;
                    }
                }
            });
            if(is_tourer_checked)
            {
                return false;
            }




            //发票信息
            var is_usebill= $(".has_invoice").val();
            if(is_usebill==1)
            {

                var bill_address=$("input:hidden[name='invoice_addr_receiver']").val();

                if(!bill_address)
                {
                    $.layer({type:1, icon:2,time:1000, text:'发票收货地址不能为空'});
                    return false;
                }
            }
            return true;

        }
    })
</script>


<!--公共函数JS-->
<script>
    //更新总价
    function get_total_price(a)
    {
        if(!a)
        {
            on_orgprice_changed();
        }
        var adultprice = parseFloat($('#field_adultprice').val());
        var dingnum=parseInt($('#field_dingnum').val());

        var childprice=parseFloat($("#field_childprice").val());
        var childnum=parseInt($("#field_childnum").val());

        var oldprice=parseFloat($("#field_oldprice").val());
        var oldnum=parseInt($("#field_oldnum").val());

        var total_num=dingnum+childnum+oldnum;
        var adult_total = dingnum*adultprice;
        var child_total = childnum*childprice;
        var old_total = oldnum*oldprice;
        var total=adult_total+child_total+old_total;
        var org_totalprice=total;
        if(adult_total>0)
        {
            $('#org_adult_total').parent().removeClass('hide');
            $("#org_adult_total").html(CURRENCY_SYMBOL+adult_total);
        }
        if(child_total>0)
        {
            $('#org_child_total').parent().removeClass('hide');
            $("#org_child_total").html(CURRENCY_SYMBOL+child_total);
        }
        if(old_total>0)
        {
            $('#org_old_total').parent().removeClass('hide');
            $("#org_old_total").html(CURRENCY_SYMBOL+old_total);
        }
        $("#org_total_price").val(org_totalprice);
        //单房差相关
        var roombalance_total=0;
        var roombalance_price=parseFloat($("#field_roombalance").val());
        var roombalance_type=$("#field_roombalance_paytype").val();
        var roombalance_num = parseInt($("#field_roombalance_num").val());
        roombalance_total=roombalance_price*roombalance_num;

        $(".board_roombalance em").text(CURRENCY_SYMBOL+roombalance_total);
        if(roombalance_price<=0)
        {
            $(".board_roombalance").hide();
        }
        else
        {
            $(".board_roombalance").show();
        }

        //积分抵现
        var jifentprice = 0;
        if (typeof(jifentprice_calculate) == 'function')
        {
            jifentprice=jifentprice_calculate();
        }
        $("#board_jifentprice").html(CURRENCY_SYMBOL+jifentprice);

        total=total-jifentprice;

        //设置优惠券
        var coupon_price = $('#coupon_price').val();
        coupon_price=!coupon_price?0:coupon_price;
        if(coupon_price)
        {
            total = total - coupon_price;
        }
        $("#board_coupon").html(CURRENCY_SYMBOL+coupon_price);


        //发票是否重置
        if(typeof(invoice_reset)=='function')
        {
            invoice_reset(total);
        }

        if(total<0)
        {
            var negative_params={totalprice:total,jifentprice:jifentprice,couponprice:coupon_price,org_totalprice:org_totalprice};
            on_negative_totalprice(negative_params);
            return;
        }

        //设置红包
        var envelope_price = $('#envelope_price').val();
        envelope_price=!envelope_price?0:envelope_price;
        if(envelope_price)
        {
            total = total - envelope_price;
        }
        $("#board_envelope").html(CURRENCY_SYMBOL+envelope_price);
        if(total<0)
        {
            total = 0 ;
        }
        var total_dingjin=0;
        var paytype=$("#field_paytype").val();
        if(paytype==2)
        {
            total+=roombalance_total;
            var dingjin= $("#field_dingjin").val();
            total_dingjin=dingjin*total_num;
            var underline_total=total-total_dingjin;
            $("#bbar_paytotal").html("订金支付："+CURRENCY_SYMBOL+total_dingjin);
            $("#board_dingjin").html("在线支付(定金)"+CURRENCY_SYMBOL+total_dingjin+"+到店付款"+CURRENCY_SYMBOL+underline_total);
            $("#board_dingjin").show();
            $("#board_total").html(CURRENCY_SYMBOL+total);
        }
        else
        {



            var total_final=total;
            total_final+=roombalance_total;
            $("#bbar_paytotal").html("应付总额："+CURRENCY_SYMBOL+total_final);
            if(roombalance_type==1 && roombalance_total>0)
            {
                $("#board_dingjin").hide();
            }
            else if(roombalance_type==2 && roombalance_total>0)
            {
                $("#bbar_paytotal").html("应付总额："+CURRENCY_SYMBOL+total);
                $("#board_dingjin").hide();
                $("#board_dingjin").show();
                $("#board_dingjin").html("在线支付"+CURRENCY_SYMBOL+total+"+到店付款"+CURRENCY_SYMBOL+roombalance_total)
            }
            $("#board_total").html(CURRENCY_SYMBOL+total_final);
        }




        // $('.totalprice').text(total);
        //$('.totalprice').attr('data-price',total);
    }

    //当总价小于0时
    function on_negative_totalprice(params)
    {
        // layer.msg('优惠价格超过产品总价，请重新选择优惠策略',{icon:5,time:2200})

        $.layer({
            type:1,
            icon:2,
            text:'优惠价格超过产品总价，请重新选择优惠策略',
            time:1000
        });
        if(typeof(coupon_reset)=='function')
        {
            coupon_reset();
        }
        if(typeof(jifentprice_reset)=='function')
        {
            jifentprice_reset();
        }
        if(typeof(envelope_reset)=='function')
        {
            envelope_reset();
        }

        get_total_price(1);
    }



    //当原始价格发生改变时
    function on_orgprice_changed()
    {
        if(typeof(coupon_reset)=='function')
        {
            coupon_reset();
        }
        if(typeof(jifentprice_reset)=='function')
        {
            jifentprice_reset();
        }
        if(typeof(envelope_reset)=='function')
        {
            jifentprice_reset();
        }
    }

</script>

<!--新版游客信息-->
<script>

    $(function () {

        get_link_data();
        set_has_num();

        /*下拉加载*/
        $('#commonUse .page-content').scroll( function() {
            var totalheight = parseFloat($(this).height()) + parseFloat($(this).scrollTop());
            var scrollHeight = $(this)[0].scrollHeight;//实际高度
            if(totalheight-scrollHeight>= -10){
                if(link_params.page!=-1 && !is_link_loading){
                    is_link_loading = true;
                    get_link_data();
                }
            }
        });

        $('.yk-check-link').click(function () {
            set_has_num();

        });

        //是否保存
        $('body').on('click','.tour_save',function () {
            if($(this).hasClass('on'))
            {
                $(this).prev().val(0);
                $(this).removeClass('on')
            }
            else
            {
                $(this).prev().val(1);
                $(this).addClass('on')
            }

        });

        //游客选择
        $('#linkman-list').on('click','li',function () {
            var linkman = $(this).data('linkman');
            var sex = $(this).data('sex');
            var mobile = $(this).data('mobile');
            var cardtype = $(this).data('cardtype');
            var idcard = $(this).data('idcard');
            var tourer = {linkman:linkman,sex:sex,mobile:mobile,cardtype:cardtype,idcard:idcard};
            if ($(this).find('.check-box').hasClass('on')) {
                $(this).find('.check-box').removeClass('on');
                switch_tourer(tourer, 1);
            }
            else
            {
                if(switch_tourer(tourer))
                {
                    $(this).find('.check-box').addClass('on');
                }
            }
            set_has_num();

        })



    });


    function set_has_num() {
        var total = $("#tourer_con .block-item ul").length;
        var has_num = 0;
        $('.tourer_tourername').each(function () {
            if($(this).val())
            {
                has_num++;
            }
        });
        var html = '请从下方选择常用旅客信息，需选择（'+has_num+'/'+total+'）'
        $('#commonUse .passenger-prompt').text(html);
    }


    //选中游客
    function switch_tourer(tourer, isdelete) {
        var isset = false;
        $("#tourer_con .block-item ul").each(function () {
            if (isset) {
                return;
            }
            var tourername = $(this).find('.tourer_tourername').val();
            if (isdelete && tourername == tourer['linkman']) {
                $(this).find('input').val('');
                isset = true;
            }
            else if (!isdelete && !tourername) {
                for (var i in tourer) {
                    $(this).find('.tourer_' + i).val(tourer[i]);

                    if(i=='cardtype')
                    {
                        $(this).find('.t_cardtype_txt').text(tourer[i]);
                        $(this).find('.field_t_cardtype').val(tourer[i]);
                    }
                    if(i=='sex')
                    {
                        if(tourer[i]==0 || tourer[i]=='女')
                        {
                            $(this).find('.sex_female').trigger('click');
                        }
                        else
                        {
                            $(this).find('.sex_male').trigger('click');
                        }
                    }

                }
                isset = true;
            }

        });
        return isset;
    }

    var is_link_loading = false;
    var link_params={
        page:1
    };



    function get_link_data() {
        $('.onloading').removeClass('hide');

        var url = SITEURL + 'member/linkman/ajax_more';

        $.ajax({
            type:'get',
            dataType:'json',
            data:link_params,
            url:url,
            success:function (data) {
                if(data.list.length>0)
                {
                    var has_pinyin = [];
                    $('#linkman-list .item').each(function () {
                        var pinyin = $(this).data('pinyin');
                        if($.inArray(pinyin,has_pinyin)==-1)
                        {
                            has_pinyin.push(pinyin);
                        }
                    })
                }
                $(data.list).each(function (index,obj)
                {
                    var l_pinyin = obj.pinyin;
                    if($.inArray(l_pinyin,has_pinyin)==-1)
                    {
                        has_pinyin.push(l_pinyin);
                        var html = ' <div class="item" data-pinyin="'+l_pinyin+'">' +
                            '<h4>'+l_pinyin+'</h4>' +
                            '<ul>' +
                            '<li data-linkman="'+obj.linkman+'"  data-sex="'+obj.sex+'" data-mobile="'+obj.mobile+'" data-cardtype="'+obj.cardtype+'" data-idcard="'+obj.idcard+'"  class="clearfix">' +
                            '<div class="check-box"></div><div class="info"><div class="tp clearfix"> ' +
                            '<strong class="name">'+obj.linkman+'</strong><strong class="sex">'+obj.sex+'</strong></div><div class="bp clearfix">' +
                            '<span class="tel">'+obj.mobile+'</span><span class="type">'+obj.cardtype+'</span><span class="card">'+obj.idcard+'</span>' +
                            '</div></div></li>' +
                            '</ul> </div>';
                        $('#linkman-list').append(html);
                    }
                    else
                    {
                        var html = '<li data-linkman="'+obj.linkman+'"  data-sex="'+obj.sex+'" data-mobile="'+obj.mobile+'" data-cardtype="'+obj.cardtype+'" data-idcard="'+obj.idcard+'"  class="clearfix">' +
                            '<div class="check-box"></div><div class="info"><div class="tp clearfix"> ' +
                            '<strong class="name">'+obj.linkman+'</strong><strong class="sex">'+obj.sex+'</strong></div><div class="bp clearfix">' +
                            '<span class="tel">'+obj.mobile+'</span><span class="type">'+obj.cardtype+'</span><span class="card">'+obj.idcard+'</span>' +
                            '</div></div></li>';
                        $('#linkman-list .item[data-pinyin='+l_pinyin+']').find('ul').append(html);

                    }
                });
                if(link_params.page==1&&data.list.length==0)
                {
                    $('#commonUse .no-passenger').removeClass('hide');
                }
                else
                {
                    $('#commonUse .no-passenger').addClass('hide');
                }

                $('#commonUse .onloading').addClass('hide');
                $('#commonUse .network-erro').addClass('hide');
                link_params.page = data.page;
                is_link_loading = false;
            },
            error:function (a, b, c) {
                $('#commonUse .network-erro').removeClass('hide');
                $('#commonUse .onloading').addClass('hide');
                is_link_loading = false;
            }

        });


    }

    //发票选中
    function on_invoice_choosed(invoice)
    {
        var type_arr={0:'个人发票',1:'公司发票',2:'增值发票'};
        var html='';
        if(!invoice)
        {
            $("#invoice_book_con .invoice_book_type .txt").text('不开发票');
            $("#invoice_book_con .invoice_book_type input:hidden").val(0);
            $("#invoice_book_con .invoice_book_title").hide();
            $("#invoice_book_con .invoice_book_address").hide();
        }
        else
        {
            var type_name = type_arr[invoice['type']];
            $(".has_invoice").val(1);
            $("#invoice_book_con .invoice_book_type .txt").text(type_name);
            $("#invoice_book_con .invoice_book_type input:hidden").val(1);
            $("#invoice_book_con .invoice_book_title .txt").text(invoice['title']);
            $("#invoice_book_con .invoice_book_title").show();
            $("#invoice_book_con .invoice_book_address").show();
        }

        for(var i in invoice)
        {
            var item=invoice[i];
            html+='<input type="hidden" name="invoice_'+i+'" value="'+item+'"/>';
        }

        $(".invoice_book_hid").html(html);
    }

    //发票地址选择
    function on_invoice_address_choosed(address)
    {
        $(".invoice_book_address .txt").html(address['receiver']+'&nbsp;&nbsp;'+address['province']+address['city']+address['address']);
        var html='';
        for(var i in address)
        {
            var item=address[i];
            html+='<input type="hidden" name="invoice_addr_'+i+'" value="'+item+'"/>';
        }
        $(".invoice_book_address_hid").html(html);
    }

</script>

</body>
</html>
