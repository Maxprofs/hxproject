<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>{$info['title']}预订-{$webname}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    {Common::css('mobilebone.css,base.css')}
    {Common::css_plugin('spot.css','spot')}
    {Common::js('jquery.min.js,lib-flexible.js,swiper.min.js,mobilebone.js,delayLoading.min.js,jquery.layer.js,validate.js')}
</head>

<body>
<div class="page out" id="pageHome" data-title="预订产品">
    {request "pub/header_new/typeid/$typeid/isbookpage/1"}
    <!-- 公用顶部 -->

    <div class="page-content">
            <section>
                <div class="wrap-content">
                    <form action="{$cmsurl}spot/create" id="orderfrm" method="post">
                    {if empty($userinfo['mid'])}
                    <div class="login-hint-txt">
                        温馨提示：<a class="login-link" href="{$cmsurl}/member/login" data-ajax="false">登录</a>可享受预定送积分、积分抵现！
                    </div>
                    {/if}
                    <!-- 温馨提示 -->

                    <div class="booking-info-block clearfix">
                        <h3 class="block-tit-bar"><strong>预定信息</strong></h3>
                        <div class="name-block">
                            <strong class="bt">景点名称</strong>
                            <p class="txt">{$info['title']}</p>
                        </div>
                        <div class="block-item">
                            <ul>
                                <li>
                                    <strong class="item-hd">产品套餐</strong>
                                    <span class="more-type" id="suit_btn"><span id="txt_suitname"></span><i class="more-ico"></i></span>
                                </li>
                                <li>
                                    <a class="all" id="choose_date_btn" href="#choose_date">
                                    <strong class="item-hd">使用日期</strong>
                                    <span class="more-type date-type" id="txt_startdate"></span>
                                    </a>
                                </li>
                                <li id="adult_con">
                                    <strong class="item-hd">预定数量</strong>
                                    <span class="item-jg" id="txt_adultprice"></span>
                                    <span class="amount-opt-wrap">
                                        <a href="javascript:;" class="sub-btn">–</a>
                                        <input type="text" name="dingnum" id="field_dingnum" class="num-text" maxlength="4" value="1">
                                        <a href="javascript:;" class="add-btn">+</a>
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- 预定信息 -->





                    <div class="booking-info-block clearfix">
                        <h3 class="block-tit-bar"><strong>订单联系人</strong></h3>
                        <div class="block-item">
                            <ul>
                                <li>
                                    <strong class="item-hd">联系人：</strong>
                                    <input type="text" name="linkman" id="field_linkman" class="write-info" placeholder="请填写真实姓名" value="{$userinfo['truename']}" />
                                    <span class="nd">(必填)</span>
                                </li>
                                <li>
                                    <strong class="item-hd">手机号码：</strong>
                                    <input type="text" name="linktel" id="field_linktel" class="write-info" placeholder="请输入常用手机号码"  value="{$userinfo['mobile']}" />
                                    <span class="nd">(必填)</span>
                                </li>
                            </ul>
                        </div>
                        <div class="block-remarks">
                            <strong class="item-hd">订单备注：</strong>
                            <textarea class="item-txt" name="remark"></textarea>
                        </div>
                    </div>
                    <!-- 订单联系人 -->
                    {if $GLOBALS['cfg_plugin_spot_usetourer']==1}
                      <div class="booking-info-block clearfix" id="tourer_con">
                        <h3 class="block-tit-bar">
                            <strong>游客信息</strong>
                            {if !empty($userinfo['mid'])}<a class="yk-check-link fr" href="#commonUse">选择常用游客<i class="more-ico"></i></a>{/if}
                        </h3>
                        <div class="block-item">

                        </div>
                    </div>
                    {/if}
                    <!-- 游客信息 -->

                    <div class="booking-info-block clearfix">
                        <div class="block-item">
                            <ul>
                                <li>
                                    <strong class="item-hd">支付方式</strong>
                                    <span class="more-type" id="txt_paytype">全款支付</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- 优惠政策 -->
                    {if !empty($userinfo)}
                    {request "spot/discount?productid=".$info['id']}
                    {/if}
                    <input type="hidden" name="suitid" id="field_suitid"/>
                    <input type="hidden" name="productid" id="field_productid" value="{$info['id']}"/>
                    <input type="hidden" id="field_price" value="0"/>

                    <input type="hidden" id="field_dingjin" value="0"/>
                    <input type="hidden" id="field_paytype" value="1"/>
                    <input type="hidden" name="startdate" id="field_startdate" value=""/>
                    <input type="hidden" id="org_total_price" value="0"/>
                    <input type="hidden" id="couponid" name="couponid" value=""/>
                    <input type="hidden" id="coupon_price" value="0"/>
                    <input type="hidden" id="max_useful_jifen" value="{if $jifentprice_info['toplimit']>$userinfo['jifen']}{$userinfo['jifen']}{else}{$jifentprice_info['toplimit']}{/if}"/>
                    <input type="hidden" id="jifentprice_limit" value="{$jifentprice_info['toplimit']}"/>
                    <input type="hidden" id="jifentprice_price" value="{$jifentprice_info['jifentprice']}"/>
                    <input type="hidden" id="jifentprice_exchange" value="{$jifentprice_info['cfg_exchange_jifen']}"/>
                    <input type="hidden" id="needjifen" name="needjifen"  value="0"/>
                    </form>
                </div>
            </section>

            <div class="bom-fixed-content">
                <div class="bom-fixed-block">
                    <span class="total">
                        <em class="jg" id="bbar_paytotal"></em>
                    </span>
                    <span class="order-show-list" id="order-show-list">明细<i class="arrow-up-ico"></i></span>
                    <a class="now-booking-btn" href="javascript:;">立即预定</a>
                </div>
            </div>
            <!-- 立即预定 -->

            <div class="fee-box hide" id="fee-box">
                <div class="fee-container">
                    <div class="fee-row">
                        <p class="ze">
                            <strong>应付总额</strong>
                            <em class="fr" id="board_total"></em>
                        </p>
                        <p class="sm hide" id="board_dingjin" ></p>
                    </div>
                    <ul class="mx-list">
                        <li>
                            <strong id="board_suitname"></strong>
                            <em id="board_org_total"></em>
                        </li>
                        <li>
                            <span class="zk">-(扣减)</span>
                        </li>
                        <li class="board_discount">
                            <strong>积分抵现</strong>
                            <em id="board_jifentprice">0</em>
                        </li>
                        <li class="board_discount">
                            <strong>优惠券</strong>
                            <em id="board_coupon">{Currency_Tool::symbol()}0</em>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- 费用明细 -->

            <!-- 支付方式 -->

            <div class="foo-box hide" id="cardtype_con">
                <div class="foo-container">
                    <ul class="list">
                        <li>护照</li>
                        <li>身份证</li>
                        <li>台胞证</li>
                        <li>港澳通行证</li>
                        <li>军官证</li>
                        <li>出生日期</li>
                    </ul>
                </div>
            </div>
            <!-- 证件选择 -->

            <div class="foo-box hide" id="suit_list">
                <div class="tc-container">
                    <div class="tc-tit-bar"><strong class="bt">选择套餐</strong><i class="close-icon" onclick="$('#suit_list').hide()"></i></div>
                    <div class="tc-wrapper">
                        <ul>
                            {st:spot action="suit" productid="$info['id']"}
                            {loop $data $suit}
                            <li data-id="{$suit['id']}"  date-start="{date('Y-m-d',$suit['startTime'])}" data-suitname="{$suit['title']}" data-paytype="{$suit['paytype']}" data-paytype_name="{$suit['paytype_name']}" data-price="{$suit['ourprice']}" data-dingjin="{$suit['dingjin']}"><em class="item">{$suit['title']}</em><i class="radio-btn"></i></li>
                            {/loop}
                        </ul>
                    </div>
                </div>
            </div>
            <!-- 选择套餐 -->

        <!--单房差支付-->
        <div class="foo-box hide" id="roombalance_type_con">
            <div class="foo-container">
                <ul class="list">
                    <li val="1">预付</li>
                    <li val="2">到店付</li>
                </ul>
            </div>
        </div>


        </div>
    </div>

    <div class="page out" id="commonUse">
        <header>
            <div class="header_top">
                <a class="back-link-icon" href="#pageHome" data-rel="back"></a>
                <h1 class="page-title-bar">选择常用旅客</h1>
            </div>
        </header>
        <!-- 公用顶部 -->
        <div class="page-content">

            <div class="linkman-group" style="top:0">
                {st:member action="linkman" memberid="$userinfo['mid']" return="tourerlist"}
                <ul class="linkman-list clearfix">
                    {loop $tourerlist $tourer}
                    <li data-fields='{json_encode($tourer)}'>
                        <span class="checkbox-label"><i class="check-icon"></i></span>
                        <div class="info">
                            <strong class="name">{$tourer['linkman']}</strong>
                            <span class="code">{$tourer['cardtype']}  {$tourer['idcard']}</span>
                        </div>
                    </li>
                    {/loop}
                </ul>
                <a class="save-info-btn" href="#pageHome" data-rel="back">确认</a>
            </div>
        </div>
    </div>
    <div class="page out" id="choose_date">
        <div class="header_top bar-nav">
            <a class="back-link-icon" href="#pageHome" data-rel="auto"></a>
            <h1 class="page-title-bar">选择日期</h1>
        </div>
        <!-- 公用顶部 -->
        <div class="page-content full-page">
            <div class="calendar-container">
            </div>
            <!-- 选择日期 -->
        </div>
    </div>



{if St_Functions::is_normal_app_install('coupon')}{request "coupon/box_new-$typeid-".$info['id']}{/if}

    <script>
        var CURRENCY_SYMBOL="{Currency_Tool::symbol()}";
        var productid = "{$info['id']}";
      //  var field_arr={json_encode($fieldlist)};
        $(document).ready(function() {

            //弹出套餐选择菜单
            $("#suit_btn").click(function () {
                $("#suit_list").show();
            });

            //套餐选择
            $("#suit_list .tc-wrapper ul li").click(function () {
                $(this).addClass('active');
                $(this).siblings().removeClass('active');
                    var suitid = $(this).data('id');

                    var paytype = $(this).data('paytype');
                    var price = $(this).data('price');
                    var dingjin = $(this).data('dingjin');
                    var suitname = $(this).data('suitname');
                    var paytype_name = $(this).data('paytype_name');
                    var startdate = $(this).attr('date-start');
                    //如果不是全款支付，则没有优惠
                    if (paytype == 1 || paytype==3)
                    {
                        $("#discount_con").show();
                        $(".board_discount").show();
                    }
                    else
                    {
                        $("#discount_con").hide();
                        $(".board_discount").hide();
                    }
                    $("#txt_paytype").text(paytype_name);
                    $("#txt_suitname").text(suitname);
                    $("#txt_price").html(CURRENCY_SYMBOL + price);
                    $("#board_suitname").text(suitname);
                    $("#field_suitid").val(suitid);
                    $("#field_price").val(price);
                    $("#field_dingjin").val(dingjin);
                    $("#field_paytype").val(paytype);
                    $("#field_startdate").val(startdate);
                    $("#txt_startdate").text(startdate);
                    $('#suit_list').hide();
                get_total_price();
            })
            //默认选中一个套餐
            $("#suit_list .tc-wrapper ul li:first").trigger('click');


            $("#txt_startdate").click(function(){
                $("#choose_date").show();
            });

            //数量修改
            $('.sub-btn,.add-btn').click(function () {
                var num = $(this).siblings(".num-text").val();
                var num = !num ? 0 : parseInt(num);
                if ($(this).is('.sub-btn')) {
                    num = num > 0 ? --num : 0;
                }
                else {
                    num++;
                }
                $(this).siblings(".num-text").val(num);
                refresh_tourers(num);
                get_total_price();

            });

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
            $("#order-show-list").click(function () {
                $("#fee-box").removeClass("hide")
            });
            $("#fee-box").click(function () {
                $(this).addClass("hide")
            })

            //游客选择
            $(".linkman-list li .check-icon").click(function () {
                var tourer = $(this).parents('li:first').data('fields');
                if ($(this).hasClass('on')) {
                    $(this).removeClass('on');
                    switch_tourer(tourer, 1);
                }
                else {
                    if(switch_tourer(tourer))
                    {
                        $(this).addClass('on');
                    }
                }
            });

            //证件类型弹出框
            $("#cardtype_con").click(function () {
                $(this).hide();
            })
            $("#cardtype_con .list li").click(function () {

            });

            $("#roombalance_type_btn").click(function(){
                $("#roombalance_type_con").show();
            });
            $("#roombalance_type_con ul li").click(function(){
                 var txt=$(this).text();
                 var val=$(this).attr('val');
                 $("#field_roombalance_paytype").val(val);
                 $("#txt_roombalance_type").text(txt);
                get_total_price(0);

            });
            $("#roombalance_type_con").click(function(){
                $(this).hide();
            });



            //证件类型选择
            $(document).on('click', '.tourer_cardtype', function () {
                $("#cardtype_con").show();
                $("#cardtype_con .list li").unbind();
                var tourer_field = this;
                $("#cardtype_con .list li").click(function () {
                    $(tourer_field).val($(this).text());
                });
            })

            //游客性别选择
            $(document).on('click','.tourer_item_sex .check-label-item',function(){
                   $(this).addClass('checked');
                   $(this).siblings().removeClass('checked');
                   var val=$(this).data('value');
                   $(this).siblings('input:hidden').val(val);
            })


            //日历选择
            $("#choose_date_btn").click(function(){

                var url=SITEURL+'spot/ajax_price_calendar';
                var suitid=$("#field_suitid").val();
                $.ajax({
                    type: 'GET',
                    url: url,
                    data: {suitid: suitid, productid: productid},
                    dataType: 'html',
                    success: function (data) {
                        $(".calendar-container").html(data);
                    }
                });
            });



            //第一次刷新游客信息
            refresh_tourers();

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


            //刷新游客
            function refresh_tourers()
            {
                if($("#tourer_con").length<=0)
                {
                    return;
                }
                var num=parseInt($("#field_dingnum").val());
                var exist_num=$("#tourer_con .block-item ul").length;
                exist_num=!exist_num?0:exist_num;

                if(exist_num>num)
                {
                    var cur_index=num-1;
                    $("#tourer_con .block-item ul:gt("+cur_index+")").remove();
                }
                else
                {
                    for(var i=exist_num;i<num;i++)
                    {
                        var html=gen_tourer(i+1);

                        $("#tourer_con .block-item").append(html);
                        $(".tourer_item_sex .check-label-item").css('cursor','pointer');
                    }
                }
                $(".t_cardtype").click(function(){
                   // $(this).unbind();
                    $("#cardtype_con").show();
                    var cur_field=this;
                    $("#cardtype_con li").unbind();
                    $("#cardtype_con li").click(function(){
                        var val=$(this).text();
                        $(cur_field).find('.t_cardtype_txt').text(val);
                        $(cur_field).find('.field_t_cardtype').val(val);

                    });
                });
            }

            //生成游客
            //生成游客
            function gen_tourer(index)
            {
                var html='';
                html+='<ul><li><strong class="item-bt">游客'+index+'</strong></li>';

                html+='<li><strong class="item-hd">姓名</strong>';
                html+='<input type="text" class="write-info tourer_linkman tourer_tourername" fieldname="tourername" name="t_tourername['+index+']" placeholder="与乘客证件一致">';
                html+='<span class="nd">(必填)</span></li>';

                html+='<li><strong class="item-hd t_cardtype"><span class="t_cardtype_txt">身份证</span><input type="hidden" fieldname="cardtype" class="field_t_cardtype" name="t_cardtype['+index+']" value="身份证"/><i class="down-ico"></i></strong>';
                html+='<input type="text" class="write-info tourer_idcard" fieldname="cardnumber" name="t_cardnumber['+index+']" placeholder="请输入证件号码">';
                html+='<span class="nd">(必填)</span></li>';

                html+='<li class="tourer_item_sex">';
                html+='<strong class="item-hd">性别</strong>';
                html+='<div class="sex-bar">';
                html+='<span class="check-label-item sex_male checked" data-value="男"><i class="icon"></i>男</span>';
                html+='<span class="check-label-item sex_female" data-value="女"><i class="icon"></i>女</span>';
                html+='<input type="hidden" fieldname="sex" name="t_sex[' + index + ']" value="男"/>';
                html+='</div></li>';

                html+='<li><strong class="item-hd">手机号</strong>';
                html+='<input type="text" class="write-info tourer_mobile" fieldname="mobile" name="t_mobile['+index+']" placeholder="请输入手机号"></li>'
                html+='</ul>';
                return html;

            }
        });

        function choose_day(ele)
        {
            var adultprice=$(ele).attr('adultprice');
            var date=$(ele).attr('date');
            console.debug(date)
            $("#txt_adultprice").text(CURRENCY_SYMBOL+adultprice);
            $("#field_price").val(adultprice);
            $("#txt_startdate").text(date);
            $("#field_startdate").val(date);
            window.history.back();
            get_total_price();
        }

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
            var suitid=$("#field_suitid").val();
            var dingnum=$("#field_dingnum").val();
            var linkman=$("#field_linkman").val();
            var linktel=$("#field_linktel").val();
            if(!suitid)
            {
                $.layer({type:1, icon:2,time:1000, text:'请至少选择一个套餐'});
                return false;
            }

            //预订数量
            if(dingnum<1)
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
                    if(!value)
                    {
                        $.layer({type:1, icon:2,time:1000, text:'游客手机号码不能为空'});
                        is_tourer_checked=true;
                    }
                    else if(!Validate.mobile(value))
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
                            $.layer({type:1, icon:2,time:1000, text:'游客身份证格式错误'});
                            is_tourer_checked=true;
                        }
                    }
                    else
                    {
                        if(!value)
                        {
                            $.layer({type:1, icon:2,time:1000, text:'游客'+desc+'不能为空1'});
                            is_tourer_checked=true;
                        }
                    }
                }
                else
                {
                    if(!value)
                    {
                        $.layer({type:1, icon:2,time:1000, text:'游客'+desc+'不能为空2'});
                        is_tourer_checked=true;
                    }
                }
            });
            if(is_tourer_checked)
            {
                return false;
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
            var adultprice = parseFloat($('#field_price').val());
            var dingnum=parseInt($('#field_dingnum').val());

            var total_num=dingnum;
            var total=dingnum*adultprice;


            var org_totalprice=total;
            $("#board_org_total").html(CURRENCY_SYMBOL+org_totalprice);
            $("#org_total_price").val(org_totalprice);


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


            if(total<0)
            {
                var negative_params={totalprice:total,jifentprice:jifentprice,couponprice:coupon_price,org_totalprice:org_totalprice};
                on_negative_totalprice(negative_params);
                return;
            }

            var total_dingjin=0;
            var paytype=$("#field_paytype").val();
            if(paytype==2)
            {
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
                $("#bbar_paytotal").html("应付总额："+CURRENCY_SYMBOL+total_final);
                $("#board_dingjin").hide();
                $("#board_total").html(CURRENCY_SYMBOL+total_final);
            }




           // $('.totalprice').text(total);
            //$('.totalprice').attr('data-price',total);
        }

        //当总价小于0时
        function on_negative_totalprice(params)
        {
            // layer.msg('优惠价格超过产品总价，请重新选择优惠策略',{icon:5,time:2200})
            layer.open({
                content: '优惠价格超过产品总价，请重新选择优惠策略',
                btn: ['{__("OK")}']
            });
            if(typeof(coupon_reset)=='function')
            {
                coupon_reset();
            }
            if(typeof(jifentprice_reset)=='function')
            {
                jifentprice_reset();
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
        }

    </script>

</body>
</html>
