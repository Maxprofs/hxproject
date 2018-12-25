<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>预订{$info['title']}-{$GLOBALS['cfg_webname']}</title>
    {include "pub/varname"}
    {Common::css_plugin('visa.css','visa')}

    {Common::css('base.css,extend.css,stcalendar.css')}
    {Common::js('jquery.min.js,base.js,common.js,SuperSlide.min.js,jquery.validate.js,jquery.validate.addcheck.js')}

</head>
<body>

 {request "pub/header"}

  <div class="big">
  	<div class="wm-1200">

    	<div class="st-guide">
            <a href="{$cmsurl}">{$GLOBALS['cfg_indexname']}</a>&nbsp;&nbsp;&gt;&nbsp;&nbsp;{$channelname}&nbsp;&nbsp;&gt;&nbsp;&nbsp;预订{$info['title']}
        </div><!--面包屑-->

      <div class="st-main-page">
          <div class="order-content">
              {if empty($userInfo['mid'])}
              <div class="order-hint-msg-box">
                  <p class="hint-txt">温馨提示：<a href="{$cmsurl}member/login" id="fast_login">登录</a>可享受预定送积分、积分抵现！</p>
              </div><!-- 未登录提示 -->
              {/if}
      <form id="orderfrm" method="post" action="{$cmsurl}visa/create">
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
                    <dt>签证类型：</dt>
                    <dd>{$info['visatype']}</dd>
             </dl>
            <div class="table-msg">
              <table width="100%" border="0" class="people_info">
                <tr>
                  <th width="25%" height="40" scope="col"><span class="l-con">日期</span></th>
                  <th width="25%" height="40" scope="col"><span class="l-con">单价</span></th>
                  <th width="25%" scope="col">购买数量</th>
                  <th width="25%" scope="col">总价格</th>
                </tr>
                  <tr>
                      <td height="40">
                            <span><input type="text" class="inputdate" name="usedate" value="{if !empty($info['usedate'])}{$info['usedate']}{else}{date('Y-m-d')}{/if}"/></span>
                      </td>
                      <td>
                          <i class="currency_sy">{Currency_Tool::symbol()}</i>{$info['price']}
                      </td>

                      <td>
                          <div class="control-box">
                              <span class="add-btn">-</span>
                              <input type="text" id="dingnum" name="dingnum" class="number-text" value="{$info['dingnum']}"/>
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
            	<dt><span class="st-star-ico">*</span>手机号码：</dt>
              <dd><input type="text" class="linkman-text" name="linktel" value="{$userInfo['mobile']}" /><span class="st-ts-text hide"></span></dd>
            </dl>
            <dl class="pm-list">
            	<dt>电子邮箱：</dt>
              <dd><input type="text" class="linkman-text" name="linkemail" value="{$userInfo['email']}" /></dd>
            </dl>
            <dl class="pm-list">
            	<dt>订单留言：</dt>
              <dd><textarea class="order-remarks" name="remark" cols="" rows=""></textarea></dd>
            </dl>
          </div><!--联系人信息-->


          <!--支付方式-->
            {if !empty($userInfo) && ($info['paytype']==1 || $info['paytype']==3)}
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

        <input type="hidden" name="productid" value="{$info['id']}"/>
        <input type="hidden" name="webid" value="{$info['webid']}"/>
        <input type="hidden" name="frmcode" value="{$frmcode}"><!--安全校验码-->
        <input type="hidden" name="usejifen" id="usejifen" value="0"/><!--是否使用积分-->
        <input type="hidden" id="price" value="{$info['price']}"/>
        <input type="hidden" id="jifentprice" value="{$info['jifentprice']}"><!--积分抵现金额-->
        <input type="hidden" id="total_price"/>

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
                          <a class="txt" href="{$info['url']}">{$info['title']}</a>
                          <p class="address"></p>
                      </li>
                  </ul>
                  <ul class="ul-list">
                      <li>签证类型：{$info['visatype']}</li>
                      <li>使用日期：<span class="usedate">{date('Y-m-d')}</span></li>
                      <li>数量：<span class="dingnum">1</span></li>
                      <li>单价：<i class="currency_sy">{Currency_Tool::symbol()}</i>{$info['price']}</li>

                  </ul>
                  <div class="total-price">订单总额：<span class="totalprice"></span></div>
              </div>
          </div>

          </div>
        </div><!--订单结算信息-->
      </div>

    </div>

 {request "pub/footer"}
 {Common::js('layer/layer.js',0)}
 {Common::js('datepicker/WdatePicker.js',0)}
 <div id="calendar" style="display: none"></div>
<script>

    var max_useful_jifen="{if $jifentprice_info['toplimit']>$userInfo['jifen']}{$userInfo['jifen']}{else}{$jifentprice_info['toplimit']}{/if}";
    $(function(){
        get_total_price();

        //积分计算
        $("#needjifen").on('keyup change',function(){
            jifentprice_update();
            get_total_price(1);
        });

        //出发日期选择
        $(".inputdate").focus(function(){

            WdatePicker({dateFmt:'yyyy-MM-dd',minDate:'%y-%M-%d',doubleCalendar:false,isShowClear:false,readOnly:true,errDealMode:1,onpicked:function(){
                $('.usedate').html($('.inputdate').val())
            }})
        })

        //提交订单
        $('.tj-btn').click(function(){
            $("#orderfrm").submit();
        })

        //表单验证

        $("#orderfrm").validate({

            submitHandler:function(form){

                ST.Util.showLoading({isfade:true,text:'提交中...'});
                form.submit();

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
            $('.dingnum').html(cur);
            get_total_price();
        })
        //数量添加
        $(".control-box").find('.sub-btn').click(function(){

            var obj = $(this).parent().find('.number-text');
            var cur = Number(obj.val());
            cur++;
            obj.val(cur);
            $('.dingnum').html(cur);
            get_total_price();
        })

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

    //检测库存
    function check_storage() {
        var startdate = $("#usedate").val();
        var dingnum = $("#dingnum").val();
        var suitid = $("#suitid").val();
        var flag = 1;

        $.ajax({
            type: 'POST',
            url: SITEURL + 'tuan/ajax_check_storage',
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
        var price = Number($("#price").val());
        var dingnum = Number($("#dingnum").val());


       price = price * dingnum ;
        var org_totalprice=price;
        $("#total_price").val(price);
        $(".suit-totalprice").html(CURRENCY_SYMBOL+price);

        //使用积分抵现
        var jifentprice = jifentprice_calculate();
        price = price- jifentprice;

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
