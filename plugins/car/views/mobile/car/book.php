<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>{$info['title']}预订-{$webname}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    {Common::css('mobilebone.css,base.css,reset-style.css')}
    {Common::css_plugin('car.css','car')}
    {Common::js('jquery.min.js,lib-flexible.js,swiper.min.js,mobilebone.js,delayLoading.min.js,jquery.layer.js,validate.js')}
    {Common::js_plugin('datetime.js','car')}
</head>

<body>
    <div class="page out" id="pageHome" data-title="预订产品">
        {request "pub/header_new/typeid/$typeid/isbookpage/1"}
        <!-- 公用顶部 -->


        <div class="page-content">

            <section>
                <div class="wrap-content">
                    <form action="{$cmsurl}car/create" id="orderfrm" method="post">
                    {if empty($userinfo['mid'])}
                    <div class="login-hint-txt">
                        温馨提示：<a class="login-link" href="{$cmsurl}member/login" data-ajax="false">登录</a>可享受预定送积分、积分抵现！
                    </div>
                    {/if}
                    <!-- 温馨提示 -->

                    <div class="booking-info-block clearfix">
                        <h3 class="block-tit-bar"><strong class="no-style">预定信息</strong></h3>
                        <div class="name-block">
                            <strong class="bt no-style">租车名称</strong>
                            <p class="txt">{$info['title']}</p>
                        </div>
                        <div class="block-item">
                            <ul>
                                <li>
                                    <strong class="item-hd no-style">产品套餐</strong>
                                    <span class="more-type" id="suit_btn"><span id="txt_suitname"></span><i class="more-ico"></i></span>
                                </li>
                                <li>
                                    <a class="all" id="choose_date_btn" href="#choose_date">
                                    <strong class="item-hd no-style">出发日期</strong>
                                    <span class="more-type date-type" id="txt_startdate"></span>
                                    </a>
                                </li>
                                <li>
                                    <a class="all" id="choose_leavedate_btn" href="#choose_leavedate">
                                        <strong class="item-hd no-style">结束日期</strong>
                                        <span class="more-type date-type" id="txt_leavedate"></span>
                                    </a>
                                </li>
                                <li>
                                    <strong class="item-hd no-style">数量</strong>
                                    <span class="item-jg" id="txt_price"></span>
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
                        <h3 class="block-tit-bar"><strong class="no-style">订单联系人</strong></h3>
                        <div class="block-item">
                            <ul>
                                <li>
                                    <strong class="item-hd no-style">联系人：</strong>
                                    <input type="text" name="linkman" id="field_linkman" class="write-info" placeholder="请填写真实姓名" value="{$userinfo['truename']}" />
                                    <span class="nd">(必填)</span>
                                </li>
                                <li>
                                    <strong class="item-hd no-style">手机号码：</strong>
                                    <input type="text" name="linktel" id="field_linktel" class="write-info" placeholder="请输入常用手机号码"  value="{$userinfo['mobile']}" />
                                    <span class="nd">(必填)</span>
                                </li>
                            </ul>
                        </div>
                        <div class="block-remarks">
                            <strong class="item-hd no-style">订单备注：</strong>
                            <textarea class="item-txt" name="remark"></textarea>
                        </div>
                    </div>

                    <div class="booking-info-block clearfix">
                        <div class="block-item">
                            <ul>
                                <li>
                                    <strong class="item-hd no-style">支付方式</strong>
                                    <span class="more-type" id="txt_paytype">全款支付</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- 优惠政策 -->
                    {if !empty($userinfo)}
                    {request "car/discount?productid=".$info['id']}
                    {/if}

                    <input type="hidden" name="suitid" id="field_suitid"/>
                    <input type="hidden" name="productid" id="field_productid" value="{$info['id']}"/>
                    <input type="hidden" id="field_price" value="0"/>

                    <input type="hidden" id="field_dingjin" value="0"/>
                    <input type="hidden" id="field_paytype" value="1"/>
                    <input type="hidden" name="startdate" id="field_startdate" value=""/>
                     <input type="hidden" name="leavedate" id="field_leavedate" value=""/>
                    <input type="hidden" id="org_total_price" value="0"/>
                    <input type="hidden" id="couponid" name="couponid" value=""/>
                    <input type="hidden" id="coupon_price" value="0"/>
                    <input type="hidden" id="max_useful_jifen" value="{if $jifentprice_info['toplimit']>$userinfo['jifen']}{$userinfo['jifen']}{else}{$jifentprice_info['toplimit']}{/if}"/>
                    <input type="hidden" id="jifentprice_limit" value="{$jifentprice_info['toplimit']}"/>
                    <input type="hidden" id="jifentprice_price" value="{$jifentprice_info['jifentprice']}"/>
                    <input type="hidden" id="jifentprice_exchange" value="{$jifentprice_info['cfg_exchange_jifen']}"/>
                    <input type="hidden" id="needjifen" name="needjifen"  value="0"/>
                    {St_Product::form_token()}
                    </form>
                </div>
            </section>

            <div class="bom-fixed-content"></div>

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
                        <li>
                            <strong class="no-style" id="board_suitname"></strong>
                            <em class="no-style" id="board_org_total"></em>
                        </li>
                        <li>
                            <span class="zk">-(扣减)</span>
                        </li>
                        <li class="board_discount">
                            <strong class="no-style">积分抵现</strong>
                            <em class="no-style" id="board_jifentprice">0</em>
                        </li>
                        <li class="board_discount">
                            <strong class="no-style">优惠券</strong>
                            <em class="no-style" id="board_coupon">{Currency_Tool::symbol()}0</em>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- 费用明细 -->

            <div class="foo-box hide" id="suit_list">
                <div class="tc-container">
                    <div class="tc-tit-bar"><strong class="bt no-style">选择套餐</strong><i class="close-icon" onclick="$('#suit_list').hide()"></i></div>
                    <div class="tc-wrapper">
                        <ul>
                            {st:car action="suit" productid="$info['id']" return="suits"}
                            {loop $suits $suit}
                               <li class="suit_item_{$suit['id']}" data-id="{$suit['id']}" date-start="{date('Y-m-d',$suit['startTime'])}" data-suitname="{$suit['suitname']}" data-paytype="{$suit['paytype']}" data-paytype_name="{$suit['paytype_name']}" data-price="{$suit['price']}" data-dingjin="{$suit['dingjin']}"><em class="item no-style">{$suit['suitname']}</em><i class="radio-btn"></i></li>
                            {/loop}
                        </ul>
                    </div>
                </div>
            </div>
            <!-- 选择套餐 -->

        </div>

        <div class="bom-fixed-block">
            <span class="total">
                <em class="jg no-style" id="bbar_paytotal"></em>
            </span>
            <span class="order-show-list" id="order-show-list">明细<i class="arrow-up-ico"></i></span>
            <a class="now-booking-btn" href="javascript:;">立即预定</a>
        </div>
        <!-- 立即预定 -->

    </div>

    <div class="page out" id="choose_date">
        <div class="header_top bar-nav">
            <a class="back-link-icon" href="#pageHome" data-rel="auto"></a>
            <h1 class="page-title-bar">选择出发日期</h1>
        </div>
        <!-- 公用顶部 -->
        <div class="page-content full-page">
            <div class="calendar-container" id="startdate_con">
            </div>
            <!-- 选择日期 -->
        </div>
    </div>

    <div class="page out" id="choose_leavedate">
        <div class="header_top bar-nav">
            <a class="back-link-icon" href="#pageHome" data-rel="auto"></a>
            <h1 class="page-title-bar">选择结束日期</h1>
        </div>
        <!-- 公用顶部 -->
        <div class="page-content full-page">
            <div class="calendar-container" id="leavedate_con">
            </div>
            <!-- 选择日期 -->
        </div>
    </div>



{if St_Functions::is_normal_app_install('coupon')}{request "coupon/box_new-$typeid-".$info['id']}{/if}


{request "pub/code"}
    <script>
        var init_suitid = '{$suitid}';
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

                var paytype = $(this).attr('data-paytype');
                var dingjin = $(this).attr('data-dingjin');
                var suitname = $(this).attr('data-suitname');
                var paytype_name = $(this).data('paytype_name')
                var start_date=$(this).attr('date-start');
                $('#txt_startdate').text(start_date);
                $('#txt_leavedate').text(start_date);
                $('#field_startdate').val(start_date);
                $('#field_leavedate').val(start_date);

                $("#suitid").val(suitid);

                    //如果不是全款支付，则没有优惠
                    if (paytype == 1 || paytype==3)
                    {
                        $("#discount_con").show();
                        $(".board_discount").show();
                    }else
                    {
                        $("#discount_con").hide();
                        $(".board_discount").hide();
                    }
                    $("#txt_paytype").text(paytype_name);
                    $("#txt_suitname").text(suitname);
                    //$("#txt_price").html(CURRENCY_SYMBOL + price);
                    $("#board_suitname").text(suitname);
                    $("#field_suitid").val(suitid);
                    $("#field_dingjin").val(dingjin);
                    $("#field_paytype").val(paytype);
                    $('#suit_list').hide();
                   get_range_price();

            })
            //默认选中一个套餐
            if(init_suitid>0)
            {
                $("#suit_list .tc-wrapper ul .suit_item_"+init_suitid).trigger('click');
            }
            else
            {
                $("#suit_list .tc-wrapper ul li:first").trigger('click');
            }


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
            });

            //证件类型选择
            $(document).on('click', '.tourer_cardtype', function () {
                $("#cardtype_con").show();
                $("#cardtype_con .list li").unbind();
                var tourer_field = this;
                $("#cardtype_con .list li").click(function () {
                    $(tourer_field).val($(this).text());
                });
            });

            //日历选择
            $("#choose_date_btn").click(function(){
                var url=SITEURL+'car/ajax_price_calendar';
                var suitid=$("#field_suitid").val();
                $.ajax({
                    type: 'GET',
                    url: url,
                    data: {suitid: suitid, productid: productid},
                    dataType: 'html',
                    success: function (data) {
                        $("#startdate_con").html(data);
                    }
                });
            });

            //日历选择
            $("#choose_leavedate_btn").click(function(){
                var url=SITEURL+'car/ajax_price_calendar';
                var startdate=$("#field_startdate").val();
                var suitid=$("#field_suitid").val();
                $.ajax({
                    type: 'GET',
                    url: url,
                    data: {suitid: suitid, productid: productid,startdate:startdate},
                    dataType: 'html',
                    success: function (data) {
                        $("#leavedate_con").html(data);
                    }
                });
            });

        });

        function choose_day(ele)
        {

            var price=$(ele).attr('price');
            var date=$(ele).attr('date');
            var startdate=$("#field_startdate").val();
            var leavedate=$("#field_leavedate").val();

            if($("#startdate_con").is(":visible"))
            {
                $("#txt_startdate").text(date);
                $("#field_startdate").val(date);
                if(!leavedate || leavedate<date)
                {
                    $("#txt_leavedate").text(date);
                    $("#field_leavedate").val(date);
                }
            }
            else
            {
                $("#txt_leavedate").text(date);
                $("#field_leavedate").val(date);
                if(!startdate || startdate>date)
                {
                    $("#txt_startdate").text(date);
                    $("#field_startdate").val(date);
                }
            }

            window.history.back();
            get_range_price();
            //get_total_price();
        }

        //获取日期范围内报价
        function get_range_price() {
            var startdate = $("#field_startdate").val();
            var leavedate = $("#field_leavedate").val();
            var suitid = $("#field_suitid").val();
            var dingnum = $("#field_dingnum").val();
            var url = SITEURL + 'car/ajax_range_price';
            $.ajax({
                type: 'GET',
                url: url,
                data: {startdate: startdate, leavedate: leavedate, suitid: suitid, dingnum: dingnum},
                dataType: 'json',
                success: function (data) {
                    var price=parseFloat(data.price)
                    $("#field_price").val(price);
                    $("#txt_price").text(CURRENCY_SYMBOL+price);
                    get_total_price();
                }
            });
        }

        //检测库存
        function check_storage() {
            var startdate = $("#field_startdate").val();
            var enddate = $("#field_leavedate").val();
            var dingnum = $("#field_dingnum").val();
            var suitid = $("#field_suitid").val();
            var flag = 1;
            $.ajax({
                type: 'POST',
                url: SITEURL + 'car/ajax_check_storage',
                data: {startdate: startdate,enddate:enddate,dingnum: dingnum, suitid: suitid},
                async: false,
                dataType: 'json',
                success: function (data) {
                    flag = data.status;
                }
            })
            return flag;

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

            var storage_status=check_storage();
            if(!storage_status)
            {
                $.layer({type:1, icon:2,time:1000, text:'库存不足'});
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
            var price = parseFloat($('#field_price').val());
            var dingnum=parseInt($('#field_dingnum').val());

            var total_num=dingnum
            var total=dingnum*price;

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

                var startdate=$("#field_startdate").val();
                var enddate=$("#field_leavedate").val();
                var days=Datetime.dateMinusFmt(enddate,startdate);
                days=days===null?0:parseInt(days)+1;
                total_dingjin=total_dingjin*days;

                var underline_total=total-total_dingjin;
                $("#bbar_paytotal").html("订金支付："+CURRENCY_SYMBOL+total_dingjin);
                $("#board_dingjin").html("在线支付(定金)"+CURRENCY_SYMBOL+total_dingjin+"+到店付款"+CURRENCY_SYMBOL+underline_total);
                $("#board_dingjin").show();
                $("#board_total").html(CURRENCY_SYMBOL+total);
            }
            else
            {
                $("#bbar_paytotal").html("应付总额："+CURRENCY_SYMBOL+total);
                $("#board_dingjin").hide();
                $("#board_total").html(CURRENCY_SYMBOL+total);
            }
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
