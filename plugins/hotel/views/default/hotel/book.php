<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>预订{$info['title']}-{$GLOBALS['cfg_webname']}</title>
    {include "pub/varname"}
    {Common::css_plugin('hotel.css','hotel')}
    {Common::css('base.css,extend.css,stcalendar.css')}
    {Common::js('jquery.min.js,base.js,common.js,SuperSlide.min.js,jquery.validate.js,jquery.validate.addcheck.js')}

</head>
<body>

 {request "pub/header"}

  <div class="big">
  	<div class="wm-1200">

    	<div class="st-guide">
            <a href="{$cmsurl}">{$GLOBALS['cfg_indexname']}</a>&nbsp;&nbsp;&gt;&nbsp;&nbsp;{$channelname}
        </div><!--面包屑-->

      <div class="st-main-page">
          <div class="order-content">
          {if empty($userInfo['mid'])}
          <div class="order-hint-msg-box">
              <p class="hint-txt">温馨提示：<a href="{$cmsurl}member/login" id="fast_login">登录</a>可享受预定送积分、积分抵现！</p>
          </div><!-- 未登录提示 -->
          {/if}
          <form id="orderfrm" method="post" action="{$cmsurl}hotel/create">
            <div class="con-order-box">
                <div class="product-msg">
                <h3 class="pm-tit"><strong class="ico01">预定信息</strong></h3>
                <dl class="pm-list">
                    <dt>产品编号：</dt>
                  <dd>{$info['series']}</dd>
                </dl>
                <dl class="pm-list">
                    <dt>产品名称：</dt>
                  <dd>{$info['title']}</dd>
                </dl>
                <dl class="pm-list">
                    <dt>产品类型：</dt>
                  <dd>{$suitInfo['roomname']}</dd>
                </dl>
                <div class="table-msg">
                  <table width="100%" border="0" class="people_info" script_table=LxACXC >
                    <tr>
                      <th width="25%" height="40" scope="col"><span class="l-con">入住日期</span></th>
                      <th width="25%" scope="col">离店日期</th>
                      <th width="25%" scope="col">购买数量</th>
                      <th width="25%" scope="col">总价格</th>
                    </tr>

                      <tr>
                          <td height="40">

                                <input type="text" class="inputdate" name="startdate" id="startdate"  value="">

                          </td>
                          <td>

                              <input type="text" class="inputdate" name="leavedate" id="leavedate" value="">
                          </td>
                          <td>
                              <div class="control-box">
                                  <span class="add-btn">-</span>
                                  <input type="text" id="dingnum" name="dingnum" class="number-text" value="1"/>
                                  <span class="sub-btn">+</span>
                              </div>
                          </td>
                          <td><span class="price suit-totalprice"></span></td>
                      </tr>

                  </table>
                </div>
              </div><!--预定信息-->
              <div class="product-msg">
                <h3 class="pm-tit"><strong class="ico02">联系人信息</strong></h3>
                <dl class="pm-list">
                  <dt><span class="st-star-ico">*</span>联系人：</dt>
                  <dd><input type="text" class="linkman-text" name="linkman" value="{$userInfo['truename']}" /><span class="st-ts-text hide"></span></dd>
                </dl>
                  <dl class="pm-list">
                      <dt><i class="st-star-ico">*</i>手机号码：</dt>
                      <dd>
                          <input type="text" id="linktel"  class="linkman-text" name="linktel"  value="{$userInfo['mobile']}">
                          <span class="st-ts-text hide"></span>
                          {if $GLOBALS['cfg_plugin_hotel_book_sms_verify']==1}
                          <a class="ver-code" id="linktel_btn" href="javascript:;">获取验证码</a>
                          {/if}
                      </dd>
                  </dl>

                  {if $GLOBALS['cfg_plugin_hotel_book_sms_verify']==1}
                  <dl class="pm-list">
                      <dt><i class="st-star-ico">*</i>验证码：</dt>
                      <dd>
                          <input type="text" id="phone_code" class="linkman-text" name="phone_code">
                      </dd>
                  </dl>
                  {/if}
                <dl class="pm-list">
                    <dt>电子邮箱：</dt>
                  <dd><input type="text" class="linkman-text" name="linkemail" value="{$userInfo['email']}" /></dd>
                </dl>
                <dl class="pm-list">
                    <dt>订单留言：</dt>
                  <dd><textarea class="order-remarks" name="remark" cols="" rows=""></textarea></dd>
                </dl>
              </div><!--联系人信息-->

                {if $GLOBALS['cfg_plugin_hotel_usetourer']==1}
                <div class="product-msg">
                    <h3 class="pm-tit"><strong class="ico03">游客信息</strong></h3>
                    {st:member action="linkman" memberid="$userInfo['mid']" return="tourerlist"}
                    {if !empty($userInfo) && !empty($tourerlist[0]['linkman'])}

                    <div class="select-linkman">
                        <div class="bt">选择常用旅客：</div>
                        <div class="son">
                            {loop $tourerlist $row}
                                    <span data-linkman="{$row['linkman']}" data-cardtype="{$row['cardtype']}"
                                          data-idcard="{$row['idcard']}" data-sex="{$row['sex']}"><i></i>{$row['linkman']}</span>
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

                                var total_num = $("#dingnum").val();

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
                                                    $('#t_cardno_' + id).rules('add', { isIDCard: true, messages: {isIDCard: "身份证号码格式不正确"}});
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
                                            $(obj).find('.t_cardtype').first().val('身份证');
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


              <!--支付方式-->

                {if !empty($userInfo) && ($suitInfo['paytype']==1 || $suitInfo['paytype']==3)}
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


              </div><!--积分优惠-->
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
                  <input type="button" class="tj-btn" value="提交订单" />
                  <input type="text" name="checkcode" id="checkcode" maxlength="4" class="ma-text" />
                  <span class="pic"><img src="{$cmsurl}captcha" onClick="this.src=this.src+'?math='+ Math.random()" width="80" height="32" /></span>
                  <span class="bt">验证码：</span>

                </div>
              </div><!--提交订单-->
            </div><!--订单内容-->
            <!--隐藏域-->
            <input type="hidden" name="suitid" id="suitid" value="{$suitInfo['id']}"/>
            <input type="hidden" name="hotelid" value="{$info['id']}"/>
            <input type="hidden" name="usedate" value="{$info['usedate']}"/>
            <input type="hidden" name="webid" value="{$info['webid']}"/>
            <input type="hidden" name="frmcode" value="{$frmcode}"><!--安全校验码-->
            <input type="hidden" name="usejifen" id="usejifen" value="0"/><!--是否使用积分-->
            <input type="hidden" id="price" value="0"/>
            <input type="hidden" id="jifentprice" value="{$suitInfo['jifentprice']}"><!--积分抵现金额-->
            <input type="hidden" id="total_price" value=""/>

          </form>
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
                      <li><a class="pic" href="{$info['url']}"><img src="{$info['litpic']}" alt="{$info['title']}"></a></li>
                      <li>
                          <a class="txt" href="{$info['url']}">{$info['title']}({$suitInfo['roomname']})</a>
                          <p class="address">{$info['address']}</p>
                      </li>
                  </ul>
                  <ul class="ul-list">
                      <li>床型：{$suitInfo['roomstyle']}</li>
                      <li>宽带：{$suitInfo['computer']}</li>
                      <li>早餐：{$suitInfo['breakfirst']}</li>
                      <li>楼层：{$suitInfo['roomfloor']}</li>
                      <li>面积：{$suitInfo['roomarea']}</li>
                  </ul>
                  <div class="total-price">订单总额：<span class="totalprice"></span></div>
              </div>
          </div>

          </div>
        </div><!--订单结算信息-->
      </div>

    </div>





 {request "pub/footer"}
 {Common::js('layer/layer.js')}
 <div id="calendar" style="display: none"></div>
<script>

    var max_useful_jifen="{if $jifentprice_info['toplimit']>$userInfo['jifen']}{$userInfo['jifen']}{else}{$jifentprice_info['toplimit']}{/if}";
    var linktel_verify_identity = "{$linktel_verify_identity}";
    var linktel_tick_time = 0;
    $(function(){

        //获取可订的最小时间
        get_mindate_book();

        //积分计算
        $("#needjifen").on('keyup change',function(){
            jifentprice_update();
            get_total_price(1);
        });

        //入住日期与离店日期选择
        $("#startdate,#leavedate").click(function(){
            var suitid = $("#suitid").val();
            get_calendar(suitid,this);

        })

        $('.tj-btn').click(function(){
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

                linkman:{
                    required: true

                },
                linktel:{
                    required:true,
                    isPhone:true

                },
                phone_code:
                {
                   required:true,
                   remote:{
                       url: SITEURL+'hotel/ajax_check_phone_code',
                       type: 'post',
                       data:{
                           linktel:function(){
                               return $("#linktel").val();
                           },
                           phone_code: function(){
                               return $("#phone_code").val();
                           }

                       }
                   }
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
                            url: SITEURL + 'hotel/ajax_check_code',
                            type: 'post',
                        },
                        depends : function(element) {
                            return element.value.length==4;
                        }

                    }

                }
            },
            messages: {
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
                phone_code:{
                    required:'请填写手机验证码',
                    remote:'验证码错误'
                },
                checkcode: {
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




        //数量减少
        $(".control-box").find('.add-btn').click(function(){

           var obj = $(this).parent().find('.number-text');
           var cur = Number(obj.val());
           if(cur>1){
               cur = cur-1;
               obj.val(cur);

           }
            gen_tourer();
            get_range_price();

        })
        //数量添加
        $(".control-box").find('.sub-btn').click(function(){

            var obj = $(this).parent().find('.number-text');
            var cur = Number(obj.val());
            cur++;
            obj.val(cur);
            get_range_price();
            gen_tourer();
        });
        $('#dingnum').blur(function () {
            var val = parseInt($(this).val());
            val = isNaN(val) || val < 1 ? 1 : val;
            $(this).val(val);
        });
        gen_tourer();



        $('body').delegate('.prevmonth,.nextmonth','click',function(){

            var year = $(this).attr('data-year');
            var month = $(this).attr('data-month');
            var suitid = $(this).attr('data-suitid');
            var contain =$(this).attr('data-contain');

            get_calendar(suitid,$("#"+contain)[0],year,month);


        });


        $("#linktel_btn").click(function(){

            if(linktel_tick_time>0)
            {
                return;
            }
            var mobile=$("#linktel").val();
            $.ajax({
                type:'POST',
                url:SITEURL+'hotel/ajax_send_verify_code',
                data:{
                    linktel_verify_identity:linktel_verify_identity,
                    mobile:mobile
                },
                dataType:'json',
                success:function(data){
                    if(data.status){
                        linktel_tick(60);
                    }else{
                        layer.msg(data.msg,
                            {
                            icon: 5,
                            time: 1000
                        })
                    }
                }

            })

        });

    })
    //获取可预订最小日期
    function get_mindate_book() {
        var suitid = $("#suitid").val();
        var url = SITEURL + 'hotel/ajax_mindate_book'
        $.getJSON(url, {suitid: suitid}, function (data) {

            $('#startdate').val(data.startdate);
            $('#leavedate').val(data.enddate);
            get_range_price();
        })
    }
    //获取日期范围内报价
    function get_range_price() {
        var startdate = $("#startdate").val();
        var leavedate = $("#leavedate").val();
        var suitid = $("#suitid").val();
        var dingnum = $("#dingnum").val();
        var url = SITEURL + 'hotel/ajax_range_price'
        $.getJSON(url, {startdate: startdate, leavedate: leavedate, suitid: suitid, dingnum: dingnum}, function (data) {

            $('#price').val(data.price);
            $(".suit-totalprice").html(CURRENCY_SYMBOL+data.price);
            get_total_price();
        })
    }
    //检测库存

    function check_storage() {
        var startdate = $("#startdate").val();
        var enddate = $("#leavedate").val();
        var dingnum = $("#dingnum").val();
        var suitid = $("#suitid").val();
        var flag = 1;

        $.ajax({
            type: 'POST',
            url: SITEURL + 'hotel/ajax_check_storage',
            data: {startdate: startdate, enddate: enddate, dingnum: dingnum, suitid: suitid},
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

        var a = arguments[0] ? arguments[0] : 0;
        if(!a)
        {
            on_orgprice_changed();
        }
        var price = Number($("#price").val());

        var org_totalprice=price;
        $("#total_price").val(price);

        //使用积分
        var jifentprice = jifentprice_calculate();
        price = price - jifentprice;

        //设置优惠券
        var coupon_price = $('#coupon_price').val();
        if(coupon_price)
        {
            price = price - coupon_price;
        }

        if(price<0)
        {
            var negative_params={totalprice:price,jifentprice:jifentprice,couponprice:coupon_price,org_totalprice:org_totalprice};
            on_negative_totalprice(negative_params);
            return;
        }


        $(".totalprice").html('<i class="currency_sy">{Currency_Tool::symbol()}</i>'+price);


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


        var url = SITEURL+'hotel/dialog_calendar';

            $.post(url,{suitid:suitid,year:year,month:month,containdiv:containdiv},function(data){
                if(data){
                    $("#calendar").html(data);
                    $("#calendar").data(suitid,data);
                    show_calendar_box();

                }
            })



    }

   //选择日期
   function choose_day(day, containdiv){

       if(containdiv=='leavedate'){
            var startdate = $("#startdate").val();
            if(!CompareDate(day,startdate)){
                layer.msg('离店日期必须大于入住日期',{
                    icon:5,
                    time:1000
                });
                //layer.closeAll();
                return false;
            }
       }
       else if(containdiv=='startdate'){
           var leavedate = $("#leavedate").val();
           $('#leavedate').val(getNextDay(day))
       }

       $('#'+containdiv).val(day);
       layer.closeAll();
       get_range_price();

   }



    function CompareDate(d1,d2)
    {
        return ((new Date(d1.replace(/-/g,"\/"))) > (new Date(d2.replace(/-/g,"\/"))));
    }
    function getNextDay(d){
        d = new Date(d.replace(/-/g,"\/"));
        d = +d + 1000*60*60*24;
        d = new Date(d);
        //return d;
        //格式化
        var month = d.getMonth()+1;

        if(month<10)
        {
            month = '0'+month
        }
        var day = d.getDate();
        if(day<10)
        {
            day = '0'+day
        }
        return d.getFullYear()+"-"+month+"-"+day;
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

    function linktel_tick(seconds) {
        if(seconds) {
            linktel_tick_time = seconds;
        }
        if(linktel_tick_time > 0)
        {
           $("#linktel_btn").addClass("wait-time");
           $("#linktel_btn").text(linktel_tick_time+"s后重发");

           linktel_tick_time--;
           setTimeout(linktel_tick,1000);
        }
        else if(linktel_tick_time<=0)
        {
            linktel_tick_time=0;
            $("#linktel_btn").removeClass("wait-time");
            $("#linktel_btn").text("重发验证码");
        }
    }


    function gen_tourer() {


        var total_num = $("#dingnum").val();

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
                $('#tourer_list').on('change', $(obj),function(){
                    var id = $(obj).attr('id').replace('t_cardtype_', '');

                    $('#t_cardno_' + id).rules("remove", 'isIDCard');
                    if ($(obj).val() == '身份证') {
                        $('#t_cardno_' + id).rules('add', { isIDCard: true, messages: {isIDCard: "身份证号码格式不正确"}});
                    }
                });
                $(obj).change();
            }
        );


    }



</script>
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
