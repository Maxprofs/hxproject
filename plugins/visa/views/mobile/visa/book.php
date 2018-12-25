<!doctype html>
<html>
<head margin_padding=74OzDt >
    <meta charset="utf-8">
    <title>{$info['title']}预订-{$webname}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    {Common::css('mobilebone.css,base.css,reset-style.css')}
    {Common::css_plugin('mobiscroll.min.css','visa')}
    {Common::css_plugin('visa.css','visa')}
    {Common::js('jquery.min.js,lib-flexible.js,swiper.min.js,mobilebone.js,delayLoading.min.js,jquery.layer.js,validate.js')}
    {Common::js_plugin('mobiscroll.min.js,datetime.js','visa')}
</head>

<body>
<div class="page out" id="pageHome" data-title="预订产品">
    {request "pub/header_new/typeid/$typeid/isbookpage/1"}
    <!-- 公用顶部 -->
    <div class="page-content">

            <section>
                <div class="wrap-content">
                    <form action="{$cmsurl}visa/create" id="orderfrm" method="post">
                    {if empty($userinfo['mid'])}
                    <div class="login-hint-txt">
                        温馨提示：<a class="login-link" href="{$cmsurl}member/login" data-ajax="false">登录</a>可享受预定送积分、积分抵现！
                    </div>
                    {/if}
                    <!-- 温馨提示 -->

                    <div class="booking-info-block clearfix">
                        <h3 class="block-tit-bar"><strong class="no-style">预定信息</strong></h3>
                        <div class="name-block">
                            <strong class="bt no-style">签证名称</strong>
                            <p class="txt">{$info['title']}</p>
                        </div>
                        <div class="block-item">
                            <ul>
                                <li>
                                    <strong class="item-hd no-style">出行日期</strong>
                                    <span class="more-type date-type" id="txt_startdate">{date('Y-m-d',strtotime('+1 day'))}</span>
                                </li>
                                <li>
                                    <strong class="item-hd no-style">数量</strong>
                                    <span class="item-jg" id="txt_price">{Currency_Tool::symbol()}{$info['price']}</span>
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
                                    <span class="more-type" id="txt_paytype">{$info['paytype_name']}</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- 优惠政策 -->
                    {if !empty($userinfo)}
                    {request "visa/discount?productid=".$info['id']}
                    {/if}

                    <input type="hidden" name="suitid" id="field_suitid"/>
                    <input type="hidden" name="productid" id="field_productid" value="{$info['id']}"/>
                    <input type="hidden" id="field_price" value="{$info['price']}"/>
                    <input type="hidden" id="field_usedate" name="usedate" value="{date('Y-m-d',strtotime('+1 day'))}"/>
                        <input type="hidden" id="field_storage" value="{$info['number']}"/>
                    <input type="hidden" id="field_dingjin" value="{$info['dingjin']}"/>
                    <input type="hidden" id="field_paytype" value="{$info['paytype']}"/>
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

            <div class="bom-fixed-content">
                <div class="bom-fixed-block">
                    <span class="total">
                        <em class="jg no-style" id="bbar_paytotal"></em>
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
                            <strong class="no-style">应付总额</strong>
                            <em class="fr no-style" id="board_total"></em>
                        </p>
                        <p class="sm hide" id="board_dingjin" ></p>
                    </div>
                    <ul class="mx-list">
                        <li>
                            <strong id="board_suitname" class="no-style"></strong>
                            <em id="board_org_total" class="no-style"></em>
                        </li>
                        <li>
                            <span class="zk">-(扣减)</span>
                        </li>
                        <li class="board_discount">
                            <strong class="no-style">积分抵现</strong>
                            <em id="board_jifentprice" class="no-style">0</em>
                        </li>
                        <li class="board_discount">
                            <strong class="no-style">优惠券</strong>
                            <em id="board_coupon" class="no-style">{Currency_Tool::symbol()}0</em>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- 费用明细 -->

        </div>
    </div>
{request "pub/code"}
{if St_Functions::is_normal_app_install('coupon')}{request "coupon/box_new-$typeid-".$info['id']}{/if}

    <script>
        var CURRENCY_SYMBOL="{Currency_Tool::symbol()}";
        var productid = "{$info['id']}";
      //  var field_arr={json_encode($fieldlist)};
        $(document).ready(function() {

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

            //明细列表
            $("#order-show-list").click(function () {
                $("#fee-box").removeClass("hide")
            });
            $("#fee-box").click(function () {
                $(this).addClass("hide")
            })

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

        $('#txt_startdate').mobiscroll().calendar({
            theme: 'mobiscroll',    //日期选择器使用的主题
            lang: 'zh',          //使用语言
            dateFormat: 'yy-mm-dd',     //显示方式
            display: 'bottom',     //显示方式,
            min: new Date(),    //显示方式,
            onDayChange:function(event){
                var date=event.date;
                var date_fmt=Datetime.format('yyyy-MM-dd',date);
                $("#field_usedate").val(date_fmt);
                $("#txt_startdate").text(date_fmt);
            }
        });

        get_total_price(1);

        function check_form()
        {

            var dingnum=$("#field_dingnum").val();
            var linkman=$("#field_linkman").val();
            var linktel=$("#field_linktel").val();
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
