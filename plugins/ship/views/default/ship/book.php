<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>预订{$info['title']}-{$GLOBALS['cfg_webname']}</title>
    {include "pub/varname"}
    {Common::css('lines.css,base.css,extend.css,stcalendar.css')}
    {Common::css_plugin('ship.css','ship',0)}
    {Common::js('jquery.min.js,base.js,common.js,SuperSlide.min.js,jquery.validate.js,jquery.validate.addcheck.js')}
</head>

<body>

{request "pub/header"}

<div class="big">
    <div class="wm-1200">

        <div class="st-guide">
            <a href="{$cmsurl}">{$GLOBALS['cfg_indexname']}</a>&nbsp;&nbsp;&gt;&nbsp;&nbsp;{$channelname}
        </div><!-- 面包屑 -->

        <div class="st-main-page">

            <div class="order-content">

                {if empty($userInfo['mid'])}
                <div class="order-hint-msg-box">
                    <p class="hint-txt">温馨提示：<a href="javascript:;" onclick="showDialogLogin()" id="fast_login">登录</a>可享受预定送积分、积分抵现！</p>
                </div>
                <!-- 未登录提示 -->
                {/if}
                <form id="orderfrm" method="post" action="{$cmsurl}ship/create">
                <div class="con-order-box">
                    <div class="product-msg">
                        <h3 class="pm-tit"><strong class="ico01">预定信息</strong></h3>
                        <dl class="pm-list">
                            <dt>航线编号：</dt>
                            <dd>{$info['series']}</dd>
                        </dl>
                        <dl class="pm-list">
                            <dt>产品名称：</dt>
                            <dd>{$info['title']}</dd>
                        </dl>
                        <dl class="pm-list">
                            <dt>出发时间：</dt>
                            <dd>
                                <div class="set-out-date">
                                    <div class="current-date" id="inputdate">{$info['startdate']}</div>
                                </div>
                            </dd>
                        </dl>
                        <dl class="pm-list">
                            <dt>舱房：</dt>
                            <dd>
                                <table class="ship-order-table" width="100%" border="0" id="suit_table" padding_html=pmACXC >
                                    <tr>
                                        <th width="22%"><span class="pl20">舱房名称</span></th>
                                        <th width="10%">舱房类型</th>
                                        <th width="12%">可住人数</th>
                                        <th width="12%">库存房间数</th>
                                        <th width="12%">入住人数</th>
                                        <th width="12%">房间数</th>
                                        <th width="12%">价格</th>
                                    </tr>
                                    {loop $suitlist $suit}
                                    <tr id="suit_{$suit['suitid']}" data-id="{$suit['suitid']}" data-price="{$suit['price']}" data-peoplenum="{$suit['peoplenum']}" data-number="{$suit['number']}" class="suit-row">
                                        <td style="text-align: left">{$suit['suitname']}</td>
                                        <td>{$suit['kindname']}</td>
                                        <td>{$suit['peoplenum']}</td>
                                        <td>{if $suit['number']!='-1'}{$suit['number']}{else}不限{/if}</td>
                                        <td><span class="num-opt"><i class="sub">-</i><input type="text" class="increase-num people-num" readonly="" name="peoplenum[{$suit['suitid']}]" value="{$suit['book_peoplenum']}"><i class="add">+</i></span></td>
                                        <td><span class="num-opt"><span class="num-opt"><input type="text" class="increase-num room-num" readonly="" name="roomnum[{$suit['suitid']}]" value="0"></span></span></td>
                                        <td><span class="price"></span></td></tr>
                                    {/loop}
                                </table>
                            </dd>
                        </dl>
                    </div><!--预定信息-->
                    <div class="product-msg">
                        <h3 class="pm-tit"><strong class="ico02">联系人信息</strong></h3>
                        <dl class="pm-list">
                            <dt><span class="st-star-ico">*</span>联系人：</dt>
                            <dd><input type="text" class="linkman-text" name="linkman"
                                       value="{$userInfo['truename']}"/><span class="st-ts-text hide"></span></dd>
                        </dl>
                        <dl class="pm-list">
                            <dt><span class="st-star-ico">*</span>手机号码：</dt>
                            <dd><input type="text" class="linkman-text" name="linktel"
                                       value="{$userInfo['mobile']}"/><span class="st-ts-text hide"></span></dd>
                        </dl>
                        <dl class="pm-list">
                            <dt>电子邮箱：</dt>
                            <dd><input type="text" class="linkman-text" value="{$userInfo['email']}" name="linkemail"/></dd>
                        </dl>
                        <dl class="pm-list">
                            <dt>订单留言：</dt>
                            <dd><textarea class="order-remarks" name="remark" cols="" rows=""></textarea></dd>
                        </dl>
                    </div>
                    <!--联系人信息-->

                    {if $GLOBALS['cfg_plugin_ship_line_usetourer']==1}
                    <div class="product-msg">
                        <h3 class="pm-tit"><strong class="ico03">游客信息</strong></h3>
                        {st:member action="linkman" memberid="$userInfo['mid']" return="tourerlist"}
                        {if !empty($userInfo) && !empty($tourerlist[0]['linkman'])}

                        <div class="select-linkman">
                            <div class="bt">选择常用旅客：</div>
                            <div class="son">
                                {loop $tourerlist $row}
                                    <span data-linkman="{$row['linkman']}" data-cardtype="{$row['cardtype']}"
                                          data-idcard="{$row['idcard']}"><i></i>{$row['linkman']}</span>
                                {/loop}
                                {/st}
                            </div>
                            {if count($tourerlist)>5}
                            <div class="more">更多&gt;</div>
                            {/if}
                        </div>
                        <script>
                            $(function () {
                                $('.select-linkman .more').click(function () {
                                    if ($('.select-linkman .son').attr('style') == '') {
                                        $('.select-linkman .son').attr("style", "height:auto");
                                        $(this).text('隐藏');
                                    } else {
                                        $('.select-linkman .son').attr("style", "");
                                        $(this).text('更多');
                                    }

                                })

                                //选择游客
                                $('.select-linkman .son span').click(function () {
                                    var t_linkman = $(this).attr('data-linkman');
                                    var t_cardtype = $(this).attr('data-cardtype');
                                    var t_idcard = $(this).attr('data-idcard');
                                    //已选中数量

                                    var total_num = 0;
                                    $(".suit-row").each(function(){
                                        var s_peoplenum = parseInt($(this).find(".people-num:first").val());
                                        total_num+=s_peoplenum;
                                    });

                                    $(this).find('i').toggleClass('on');
                                    var has_choose = $('.select-linkman .son span i.on').length;
                                    //如果选中数量大于总人数,则取消选中.
                                    if (has_choose > total_num) {

                                        $(this).find('i').removeClass('on');

                                        return;
                                    }

                                    //如果是选中事件
                                    if ($(this).find('i').attr('class') == 'on') {


                                        $("#tourer_list tr").each(function (i, obj) {
                                            if ($(obj).find('.t_name').first().val() == '') {
                                                $(obj).find('.t_name').first().val(t_linkman);
                                                $(obj).find('.t_cardtype').first().val(t_cardtype);
                                                $(obj).find('.t_cardno').first().val(t_idcard);
                                                return false;
                                            }
                                        });

                                        //身份证验证
                                        $("select[name^='t_cardtype']").each(
                                            function(i,obj){
                                                $('#tourer_list').on('change', $(obj),function(){
                                                    var id = $(obj).attr('id').replace('t_cardtype_', '');

                                                    $('#t_cardno_' + id).rules("remove", 'isIDCard');
                                                    if ($(obj).val() == '身份证') {
                                                        $('#t_cardno_' + id).rules('add', { isIDCard: true, messages: {isIDCard: "身份证号码不正确"}});
                                                    }
                                                });
                                                $(obj).change();
                                            }
                                        );

                                    }
                                    else {

                                        $("#tourer_list tr").each(function (i, obj) {
                                            if ($(obj).find('.t_name').first().val() == t_linkman
                                                && $(obj).find('.t_cardno').first().val() == t_idcard
                                                && $(obj).find('.t_cardtype').first().val() == t_cardtype
                                            ) {
                                                $(obj).find('.t_name').first().val('');
                                                $(obj).find('.t_cardno').first().val('');
                                                $(obj).find('.t_cardtype').first().val('请选择');
                                            }


                                        })

                                    }

                                })
                            })
                        </script>
                        {/if}
                        <div class="visitor-msg">
                            <table width="100%" border="0" id="tourer_list">

                            </table>
                        </div>
                    </div>
                    <!--游客信息-->
                    {/if}

                    {if !empty($userInfo)}
                    <div class="product-msg">
                        <h3 class="pm-tit" id="yhzc_tit"><strong class="ico08">优惠政策</strong></h3>
                        {if St_Functions::is_normal_app_install('coupon')}

                        {request 'coupon/box-'.$typeid.'-'.$info['id']}
                        {/if}
                        {if !empty($userInfo) && !empty($jifentprice_info)}
                        <div class="item-yh">
                            <h3>积分优惠</h3>
                            <div class="item-nr">
                                <table>
                                    <tr>
                                        <td>
                                            <span class="use-jf"><label>使用 </label><input type="text" id="needjifen"  data-exchange="{$jifentprice_info['cfg_exchange_jifen']}" class="jf-num" name="needjifen"/><label> 积分抵扣<em class="dk-num" id="jifentprice">{Currency_Tool::symbol()}0</em></label></span>
                                            <span class="cur-jf">最多可以使用{$jifentprice_info['toplimit']}积分抵扣<i class="currency_sy">{Currency_Tool::symbol()}</i>{$jifentprice_info['jifentprice']}，我当前积分：{$userInfo['jifen']}</span>
                                        </td>
                                        <td>
                                            <span class="jifen-error"></span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        {/if}
                    </div>
                    <script>
                        if($("#yhzc_tit").siblings().not('script,style').length==0)
                        {
                            $("#yhzc_tit").hide();
                        }
                    </script>
                    {/if}

                    <div class="order-js-box">
                        <div class="total">订单结算总额：<span class="totalprice"></span></div>
                        <div class="yz">
                            <input type="button" class="tj-btn" value="提交订单"/>
                            <input type="text" name="checkcode" id="checkcode" maxlength="4" class="ma-text"/>
                            <span class="pic"><img src="{$cmsurl}captcha"
                                                   onClick="this.src=this.src+'?math='+ Math.random()" width="80"
                                                   height="32"/></span>
                            <span class="bt">验证码：</span>

                        </div>
                    </div>

                </div>
                    <input type="hidden" name="lineid" id="lineid" value="{$info['id']}"/>
                    <input type="hidden" name="webid" value="{$info['webid']}"/>
                    <input type="hidden" name="frmcode" value="{$frmcode}"><!--安全校验码-->
                    <input type="hidden" name="usejifen" id="usejifen" value="0"/><!--是否使用积分-->
                    <input type="hidden" id="total_price" value=""/>
                    <input type="hidden" name="usedate" value="{$info['startdate']}"/>
                    <input type="hidden" name="dateid" id="dateid" value="{$info['dateid']}"/>
                 </form>
                <!--订单内容-->
                <div class="clear"></div>
                {if $GLOBALS['cfg_order_agreement_open']==1}
                <div class="booking-need-term">
                    <div class="term-tit"><strong>我已阅读预定须知，同意则提交订单</strong></div>
                    <div class="term-block">
                        {$GLOBALS['cfg_order_agreement']}
                    </div>
                </div>
                {/if}
            </div>

            <div class="st-sidebox">

                <div class="side-order-box">
                    <div class="order-total-tit">结算信息</div>
                    <div class="show-con">
                        <ul class="ul-cp">
                            <li><a class="pic" href="{$info['url']}"><img src="{$info['litpic']}" alt="{$info['title']}" /></a></li>
                            <li><a class="txt" href="{$info['url']}">{$info['title']}</a></li>
                        </ul>
                        <ul class="ul-list">
                            <li>购买时间：{date('Y-m-d')}</li>
                            <li>出行日期：<span id="right_usedate">{$info['usedate']}</span></li>
                            <li>舱房数量：<span id="right_totalnum">{$info['roomnum']}</span></li>
                        </ul>
                        <div class="total-price">订单总额：<span id="right_totalprice" class="totalprice"></span></div>
                    </div>
                </div>
                <!--订单结算信息-->

            </div>

        </div>

    </div>
</div>
<div id="calendar" style="display: none"></div>
{Common::js('layer/layer.js',0)}
<script>
    var max_useful_jifen="{if $jifentprice_info['toplimit']>$userInfo['jifen']}{$userInfo['jifen']}{else}{$jifentprice_info['toplimit']}{/if}";
    $(function(){
        $(".suit-row").each(function(){
            var suitid = $(this).data('id');
            calculate_roomnum(suitid);
        });


        //积分计算
        $("#needjifen").on('keyup change',function(){
            jifentprice_update();
            get_total_price(1);
        });


        //提交订单按钮
        $('.tj-btn').click(function () {
            $("#orderfrm").submit();
        })
        //有效性验证
        $("#orderfrm").validate({

            submitHandler: function (form) {
                var result = check_storage();
                if(!result.status){
                    layer.open({
                        content: result.msg,
                        btn: ['{__("OK")}']
                    });
                    return false;

                }else{
                    ST.Util.showLoading({isfade:true,text:'提交中...'});
                    form.submit();
                }
            },
            errorClass: 'st-ts-text',
            errorElement: 'span',
            rules: {

                linkman: {
                    required: true

                },

                linktel: {
                    required: true,
                    isPhone: true

                },
                linkemail:{
                    email:true
                },
                needjifen:{
                    digits:true,
                    min:0,
                    max:parseInt(max_useful_jifen)
                },
                checkcode: {
                    required:true,
                    minlength:4,
                    remote: {
                        param: {
                            url: SITEURL + 'ship/ajax_check_code',
                            type: 'post',
                        },
                        depends : function(element) {
                            return element.value.length==4;
                        }

                    }
                }

            },
            messages: {
                linkman: {
                    required: "请填写联系人信息"
                },
                linktel: {
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
                checkcode: {
                    required: "请填写验证码",
                    minlength: "",
                    remote: "验证码错误"
                }
            },
            highlight: function (element, errorClass, validClass) {
                $(element).attr('style', 'border:1px solid red');
            },
            unhighlight: function (element, errorClass) {
                $(element).attr('style', '');
            },
            errorPlacement: function (error, element) {
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


        gen_tourer();

        get_total_price();

        //出发日期选择
        $("#inputdate").click(function () {

            var date = $(this).text().split('-');
            get_calendar(0, this, date[0], date[1]);

        });
        //下个月或上个月
        $('body').delegate('.prevmonth,.nextmonth', 'click', function () {

            var year = $(this).attr('data-year');
            var month = $(this).attr('data-month');
            var suitid = $(this).attr('data-suitid');
            var contain = $(this).attr('data-contain');
            get_calendar(suitid, $("#" + contain)[0], year, month);
        });

        //增加减少数量
        $('body').delegate('.add,.sub', 'click', function () {
            var suitid = $(this).parents("tr:first").data('id');
            var number = $(this).parents("tr:first").data('number')
            var year = $(this).attr('data-year');
            var input_ele = $(this).siblings(".increase-num:first");
            var val = parseInt(input_ele.val());
            val = !val?0:val;
            if($(this).is('.add'))
            {
                ++val;
            }
            else
            {
                if(val>=1)
                  --val
            }

            var roomnum = calculate_roomnum(suitid,true,val);
            var suit_ele = $("#suit_"+suitid);
            if(roomnum>parseInt(number) && number!='-1')
            {
                return;
            }

            suit_ele.find(".room-num").val(roomnum);
            input_ele.val(val);
            get_total_price();
            gen_tourer();

        });




    });

    function get_calendar(suitid, obj, year, month) {

        //加载等待
        layer.open({
            type: 3,
            icon: 2
        });
        var containdiv = '';
        if (obj) {
            containdiv = $(obj).attr('id');
        }
        var url = SITEURL + 'ship/dialog_calendar';
        var lineid = $('#lineid').val();

        $.post(url, {
            year: year,
            month: month,
            containdiv: containdiv,
            lineid: lineid
        }, function (data) {
            if (data) {
                $("#calendar").html(data);
               // $("#calendar").data(suitid, data);
                show_calendar_box();

            }
        })
    }

    //显示日历
    function show_calendar_box() {
        layer.closeAll();
        layer.open({
            type: 1,
            title: '',
            area: ['480px', '430px'],
            shadeClose: true,
            content: $('#calendar').html()
        });

    }


    //选择日期
    function choose_day(day, containdiv) {

        var lineid = $("#lineid").val();
        var url = SITEURL + 'ship/ajax_price_day';
        $("input[name=usedate]").val(day);
        $.getJSON(url, {'useday': day, 'lineid': lineid}, function (data) {
            var content = gen_suit_html(data);
            var dateid = data && data[0]['dateid']? data[0]['dateid']:0;
            $("#dateid").val(dateid);
            $("#suit_table .suit-row").remove();
            $("#suit_table").append(content);

            get_total_price();
        });
        $('#' + containdiv).text(day);
        layer.closeAll();
    }
    //生成套餐html
    function gen_suit_html(list)
    {
        var html='';
        for(var i in list)
        {
            var row=list[i];
            var number_str = row['number']=='-1'?'不限':row['number'];
            html += '<tr id="suit_'+row['suitid']+'" data-id="'+row['suitid']+'" data-price="'+row['price']+'" data-peoplenum="'+row['peoplenum']+'" data-number="'+row['number']+'" class="suit-row"><td style="text-align: left">';
            html += row['suitname'];
            html += '</td>';
            html += '<td>'+row['kindname']+'</td>';
            html += '<td>'+row['peoplenum']+'</td>';
            html += '<td>'+number_str+'</td>';
            html += '<td><span class="num-opt"><i class="sub">-</i> <input type="text" class="increase-num people-num" readonly name="peoplenum['+row['suitid']+']" value="0"> <i class="add">+</i></span></td>';
            html += '<td><span class="num-opt"><span class="num-opt"><input type="text" class="increase-num room-num" readonly name="roomnum['+row['suitid']+']" value="0"></span></td>';
            html += '<td><span class="price"></span></td>';
            html += '</tr>'
        }
        return html;
    }
    //计算房间数量
    function calculate_roomnum(suitid,isreturn,realnum)
    {
        var suit_ele = $("#suit_"+suitid);

        var  peoplenum = parseInt(suit_ele.data('peoplenum'));

         if(!isreturn)
            realnum = parseInt(suit_ele.find('.people-num:first').val());
        var roomnum = Math.ceil(realnum/peoplenum);
        if(isreturn)
            return roomnum;
        suit_ele.find(".room-num").val(roomnum);
    }

    function  get_total_price(a)
    {
        var a = arguments[0] ? arguments[0] : 0;
        if(!a)
        {
            on_orgprice_changed();
        }

        var total_price=0;
        var roomnum=0;
        $(".suit-row").each(function(){
            var s_price = parseFloat($(this).data('price'));
            var s_roomnum = parseInt($(this).find(".room-num:first").val());
            var s_total = s_price*s_roomnum;
            $(this).find(".price").text(CURRENCY_SYMBOL+s_total);
            total_price+=s_total;
            roomnum+=s_roomnum;
        });

        var org_totalprice=total_price;
        $("#total_price").val(total_price);

        //使用积分
        var jifentprice=jifentprice_calculate();
        total_price=total_price-jifentprice;


        //设置优惠券
        var coupon_price = $('#coupon_price').val();
        if(coupon_price)
        {
            total_price = total_price - coupon_price;
        }

        if(total_price<0)
        {
            var negative_params={totalprice:total_price,jifentprice:jifentprice,couponprice:coupon_price,org_totalprice:org_totalprice};
            on_negative_totalprice(negative_params);
            return;
        }

        var usedate = $("#inputdate").text();
        $("#right_usedate").text(usedate);
        $("#right_totalnum").text(roomnum);
        $("#right_totalprice").text(CURRENCY_SYMBOL+total_price);
        $(".totalprice").text(CURRENCY_SYMBOL+total_price);
    }

    function gen_tourer() {


        var total_num = 0;
        $(".suit-row").each(function(){
            var s_peoplenum = parseInt($(this).find(".people-num:first").val());
            total_num+=s_peoplenum;
        });

        var html = '';
        var hasnum = $("#tourer_list").find('tr').length;

        if(hasnum>total_num)
        {
            if(total_num==0)
            {
                $("#tourer_list").find('tr').remove();
                return;
            }
            var last_index=total_num-1;
            $("#tourer_list").find('tr:gt('+last_index+')').remove();
            return;
        }

        for (var i = hasnum; i < total_num; i++) {

            html += ' <tr>';
            html += '<td width="40%" height="60"><span class="st-star-ico fl">*</span><span class="child"><em>姓名：</em><input type="text" name="t_name[' + i + ']"';
            html += ' class="lm-text t_name" /></span></dd></td>';
            html += '<td width="60%">';
            html += '<span class="st-star-ico fl">*</span>';
            html += '<span class="child">';
            html += '<em>证件号：</em>';
            html += '<select class="t_cardtype" id="t_cardtype_'+i+'" name="t_cardtype[' + i + ']">';
            html += '<option value="0">请选择</option>';
            html += '<option value="护照">护照</option>';
            html += '<option value="身份证">身份证</option>';
            html += '<option value="台胞证">台胞证</option>';
            html += '<option value="港澳通行证">港澳通行证</option>';
            html += '<option value="军官证">军官证</option>';
            html += '<option value="出生日期">出生日期</option>';
            html += '</select>';
            html += '<input type="text" class="lm-text t_cardno" id="t_cardno_'+i+'" name="t_cardno[' + i + ']" />';
            html += '</span>';
            html += '</td>';
            html += '</tr>';
        }
        $("#tourer_list").append(html);
        if (hasnum == 0) {
            var tourname = "{$userInfo['truename']}";
            var tour_mobile = "{$userInfo['mobile']}";
            var tour_idcard = "{$userInfo['cardid']}";
            var obj = $("#tourer_list").find('tr').first();
            obj.find('.t_name').val(tourname);
            obj.find('.t_cardno').val(tour_idcard);
            obj.find('.t_cardtype').val('身份证');
        }
        //动态添加游客姓名
        $("input[name^='t_name']").each(
            function (i, obj) {
                //console.log(obj);
                //$(obj).rules("remove");
               $(obj).rules("add", {required: true, messages: {required: "请输入姓名"}});
            }
        )
        //证件类型
        $("input[name^='t_cardno']").each(
            function (i, obj) {
               $(obj).rules("remove");
                $(obj).rules("add", {required: true,alnum:true,isIDCard:true, messages: {required: "请输入证件号",isIDCard: "身份证号码格式不正确"}});
            }
        )
        //身份证验证
        $("select[name^='t_cardtype']").each(
            function(i,obj){

                $(obj).change(function(){

                    var id = $(obj).attr('id').replace('t_cardtype_', '');
                    $('#t_cardno_' + id).rules("remove", 'isIDCard');
                    if ($(this).val() == '身份证') {
                        $('#t_cardno_' + id).rules('add', { isIDCard: true, messages: {isIDCard: "身份证号码格式不正确"}});
                    }
                })
            })


    }

    //检测库存
    function check_storage() {
        var suitids = [];
        var numbers = [];
        var lineid = $("#lineid").val();
        var dateid = $("#dateid").val();
        $(".suit-row").each(function(){
            var suitid = parseInt($(this).data('id'));
            var dingnum = parseInt($(this).find(".room-num:first").val());
            suitids.push(suitid);
            numbers.push(dingnum);
        });
        var suitids_str = suitids.join(',');
        var numbers_str = numbers.join(',');
        var result={};

        $.ajax({
            type: 'POST',
            url: SITEURL + 'ship/ajax_check_storage',
            data: {lineid: lineid,  dateid: dateid,suitids:suitids_str,numbers:numbers_str},
            async: false,
            dataType: 'json',
            success: function (data) {
               result=data;
            }
        })

        return result;

    }


    //计算积分抵现价格
    function jifentprice_calculate()
    {
        var needjifen=parseInt($("#needjifen").val());
        if(!needjifen||needjifen<=0)
            return 0;
        var exchange=$("#needjifen").data('exchange');
        var price=Math.floor(needjifen/exchange);
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
{request "pub/footer"}
{if empty($userInfo['mid'])}
{Common::js('jquery.md5.js')}
{include "member/login_fast"}
<script>
    $('#fast_login').click(function () {
        $('#is_login_order').removeClass('hide');
        return false;
    });
</script>
{/if}
</body>
</html>
