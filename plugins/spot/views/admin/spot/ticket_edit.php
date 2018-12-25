<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>套餐添加/修改</title>
    {template 'stourtravel/public/public_min_js'}
    {php echo Common::getCss('style.css,base.css,base2.css,base_new.css,calendar-price-jquery.min.css'); }
    {php echo Common::getScript("uploadify/jquery.uploadify.min.js,DatePicker/WdatePicker.js,choose.js,product_add.js,imageup.js,jquery.validate.js,calendar-price-jquery.js"); }
    {php echo Common::getCss('uploadify.css','js/uploadify/'); }
    {php echo Common::css_plugin('jquery.datetimepicker.css','spot');}
    {php echo Common::js_plugin('jquery.datetimepicker.full.js','spot');}
</head>

<body>

    <table class="content-tab">
        <tr>
            <td width="119px" class="content-lt-td"  valign="top">
                {template 'stourtravel/public/leftnav'}
                <!--右侧内容区-->
            </td>
            <td valign="top" class="content-rt-td">
                <form method="post" name="product_frm" id="product_frm" autocomplete="off" head_div=CLACXC >
                    <div class="cfg-header-bar">
                        <div class="cfg-header-tab" id="nav">
                            <span class="item on">基础信息</span>
                            <span class="item" data-id="other">高级设置</span>
                        </div>
                        <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
                    </div>
              <div class="manage-nr">

                   <!--基础信息开始-->
                  <div class="product-add-div">
                      <ul class="info-item-block">
                          <li>
                              <span class="item-hd">当前景点：</span>
                              <div class="item-bd">
                                  <span class="item-text">{$spotname}</span>
                              </div>
                          </li>
                          <li>
                              <span class="item-hd">门票名称：</span>
                              <div class="item-bd">
                                  <input type="text" name="title" id="title" class="input-text w900" value="{$info['title']}" />
                              </div>
                          </li>
                          <li>
                              <span class="item-hd">门票类型{Common::get_help_icon('spot_ticket_type')}：</span>
                              <div class="item-bd">
                                    <span class="select-box w150">
                                        <select class="select" name="tickettypeid" id="tickettypeid">
                                            <option value="">请选择门票类型</option>
                                            {loop $tickettypelist $k}
                                            <option value="{$k['id']}" {if $info['tickettypeid']==$k['id']}selected="selected"{/if} >{$k['kindname']}</option>
                                            {/loop}
                                        </select>
                                    </span>
                                  <input type="text" id="field_newtickettype" name="newtickettype" style="display: none" class="input-text w100" value=""/>
                                  <a href="javascript:;" class="btn btn-primary radius size-S mt-3 mr-5" id="newtickettype_btn">添加类型</a>
                              </div>
                          </li>
                          <li>
                              <span class="item-hd">供应商：</span>
                              <div class="item-bd">
                                  <a href="javascript:;" class="fl btn btn-primary radius size-S va-t mt-5" onclick="Product.getSupplier(this,'.supplier-sel')"  title="选择">选择</a>
                                  <div class="save-value-div mt-2 ml-10 supplier-sel w700">
                                      {if !empty($info['supplier_arr']['id'])}
                                      <span class="mb-5"><s onclick="$(this).parent('span').remove()"></s>{$info['supplier_arr']['suppliername']}<input type="hidden" name="supplierlist[]" value="{$info['supplier_arr']['id']}"></span>
                                      {/if}
                                  </div>
                              </div>
                          </li>
                          <li>
                              <span class="item-hd">原价{Common::get_help_icon('product_original_price')}：</span>
                              <div class="item-bd">
                                  <input type="text" name="sellprice"  class="input-text w80" value="{$info['sellprice']}" />
                              </div>
                          </li>

                          <li>
                              <span class="item-hd">套餐报价{Common::get_help_icon('product_suit_price')}：</span>
                              <div class="item-bd">
                                  <a href="javascript:;" class="fl btn btn-primary radius size-S mt-3 mr-5"  onclick="add_suit_price()" title="添加报价">添加报价</a>
                                  <a href="javascript:;" class="btn btn-grey-outline radius size-S mt-3 ml-5" onclick="delall()">清除报价</a>
                                  <a class="btn-link" id="more_price"  onclick="showMore()" style="margin-left: 680px;display: none">查看更多报价</a>
                              </div>
                          </li>
                          <li>
                              <span class="item-hd"></span>
                              <div class="item-bd">
                                  <div class="container fl">

                                  </div>
                              </div>
                          </li>

                      </ul>
                      <div class="line"></div>
                      <ul class="info-item-block">

                          <li>
                              <span class="item-hd">提前预订时间{Common::get_help_icon('spot_ticket_day_before')}：</span>
                              <div class="item-bd">
                                    <span class="item-text">
                                        提前<input type="text" id="day_before" maxlength="3" name="day_before" class="input-text w50 ml-5 mr-5 text-c" value="{$info['day_before']}" />天预订
                                    </span>
                                    <span class="item-text ml-20">
                                        <input type="text" name="time_before" id="time_before" class="input-text w100 mr-5" value="{$info['time_before']}" />前结束当天预订
                                    </span>
                                  <span class="item-text c-999 ml-20">*前台报价会根据提前时间来显示, 小时分钟均为00时，表示可以在23：59：59秒前预订</span>
                                  <label class="error-lb"></label>
                              </div>
                          </li>
                          <li>
                              <span class="item-hd">取票方式{Common::get_help_icon('ticket_get_way')}：</span>
                              <div class="item-bd">
                                  <input type="text" name="get_ticket_way"  class="input-text w900" value="{$info['get_ticket_way']}" />
                              </div>
                          </li>
                          <li>
                              <span class="item-hd">有效期{Common::get_help_icon('ticket_check_effective_days')}：</span>
                              <div class="item-bd">
                                 游客指定入园日期后 <input type="text" name="effective_days"  class="input-text w50" value="{$info['effective_days']}" /> 天内有效
                              </div>
                          </li>
                          <li>
                              <span class="item-hd">退票类型{Common::get_help_icon('ticket_refund_restriction_type')}：</span>
                              <div class="item-bd">
                                  <label class="radio-label"><input type="radio" name="refund_restriction" value="0" {if empty($info['refund_restriction'])}checked="checked"{/if} />无条件退款</label>
                                  <label class="radio-label ml-20"><input type="radio" name="refund_restriction" value="1" {if $info['refund_restriction']=='1'}checked="checked"{/if} />不可退改</label>
                                  <label class="radio-label ml-20"><input type="radio" name="refund_restriction" value="2" {if $info['refund_restriction']=='2'}checked="checked"{/if} />有条件退改</label>
                            </div>
                          </li>
                          <li>
                              <span class="item-hd">门票描述{Common::get_help_icon('ticket_description_content')}：</span>
                              <div class="item-bd">
                                  {php Common::getEditor('descriptionspot',$info['description'],$sysconfig['cfg_admin_htmleditor_width'],200,'Line');}
                              </div>
                          </li>
                          <li>
                              <span class="item-hd">会员预定方式{Common::get_help_icon('order_pay_type')}：</span>
                              <div class="item-bd">
                                  <div class="on-off">
                                      <label class="radio-label"><input type="radio" name="paytype" value="1" {if $info['paytype']=='1' OR empty($info['paytype'])}checked="checked"{/if} />全额预定</label>
                                      <label class="radio-label ml-20"><input type="radio" name="paytype" id="field_paytype_2" value="2" {if $info['paytype']=='2'}checked="checked"{/if} />定金预定</label>
                                      <span id="dingjin" style="{if $info['paytype'] != '2'}display: none{/if}">
                                          &nbsp;&nbsp;&nbsp;每人支付定金
                                          <input type="text" class="input-text w60 va-t" maxlength="6" name="dingjin" id="dingjintxt" value="{$info['dingjin']}" size="6" onkeyup="(this.v=function(){this.value=this.value.replace(/[^0-9-\.]+/,'');}).call(this)" onblur="this.v();">&nbsp;</span>

                                      <script>
                                          $("input[name='paytype']").click(function(){
                                              if($("#field_paytype_2:checked").length>0)
                                              {
                                                  $("#dingjin").show();
                                                  $("#online_pay").attr('checked',true);
                                                  $("#online_pay").attr('disabled',true);
                                                  $('#offline_pay').attr('checked',false);
                                                  $('#offline_pay').attr('disabled',true);

                                              }
                                              else
                                              {

                                                  $("#dingjin").hide();
                                                  $("#online_pay").attr('checked',false);
                                                  $('#offline_pay').attr('checked',false);
                                                  $("#online_pay").attr('disabled',false);
                                                  $('#offline_pay').attr('disabled',false);

                                              }
                                          })

                                          $(document).ready(function(){
                                              if($("#field_paytype_2:checked").length>0)
                                              {
                                                  $("#field_paytype_2").trigger('click');
                                              }
                                          });



                                      </script>
                                  </div>
                              </div>
                          </li>
                          <li>
                              <span class="item-hd">预定确认方式{Common::get_help_icon('order_need_confirm')}：</span>
                              <div class="item-bd">
                                  <label class="radio-label"><input type="checkbox" name="need_confirm" value="1" {if $info['need_confirm']=='1'}checked="checked"{/if} />需要供应商或管理员手动确认</label>
                              </div>
                          </li>
                          <li>
                              <span class="item-hd">会员支付方式{Common::get_help_icon('order_pay_way')}：</span>
                              <div class="item-bd">
                                  <label class="radio-label"><input type="checkbox" name="pay_way[]" id="online_pay" value="1" {if $info['pay_way']=='1' || $info['pay_way']==3}checked="checked"{/if} {if $action=='add'}checked="checked"{/if} />线上支付</label>
                                  <label class="radio-label"><input type="checkbox" name="pay_way[]" id="offline_pay" value="2" {if $info['pay_way']=='2' || $info['pay_way']==3}checked="checked"{/if} {if $action=='add'}checked="checked"{/if} />线下支付</label>
                              </div>
                          </li>
                          <li>
                              <span class="item-hd">待付款时限{Common::get_help_icon('order_auto_close_time')}：</span>
                                <div class="item-bd">
                                  <input type="text" name="auto_close_time_hour" id="auto_close_time_hour" maxlength="2" onkeyup="value=value.replace(/[^\d]/g,'')"  class="input-text w60" {if $action=='add'}value="24"{else}value="{$info['auto_close_time_hour']}"{/if} />&nbsp;小时
                                  <input type="text" name="auto_close_time_minute" id="auto_close_time_minute" maxlength="2" onkeyup="value=value.replace(/[^\d]/g,'')"  class="input-text w60" {if $action=='add'}value="0"{else}value="{$info['auto_close_time_minute']}"{/if} />&nbsp;分钟
                                </div>
                          </li>

                      </ul>
                  </div>
                  <!-- 基础信息结束 -->
                  <div class="product-add-div" data-id="other">
                          <ul class="info-item-block">
                          <li>
                              <span class="item-hd">游客信息：</span>
                              <div class="item-bd">
                                  <label class="radio-label"><input type="radio" name="fill_tourer_type" value="0" {if empty($info['fill_tourer_type'])}checked="checked"{/if} />不需要</label>
                                  <label class="radio-label ml-20"><input type="radio" name="fill_tourer_type" value="1" {if $info['fill_tourer_type']=='1'}checked="checked"{/if} />仅需要一位</label>
                                  <label class="radio-label ml-20"><input type="radio" name="fill_tourer_type" value="2" {if $info['fill_tourer_type']=='2'}checked="checked"{/if} />需要所有游客信息</label>
                              </div>
                          </li>
                          <li>
                              <span class="item-hd">游客信息必填项：</span>
                              <div class="item-bd">
                                  <label class="radio-label"><input type="checkbox" name="fill_tourer_items[]" value="tourername" {if in_array('tourername',$info['fill_tourer_items_arr']) || empty($info['id'])}checked="checked"{/if} />姓名</label>
                                  <label class="radio-label"><input type="checkbox" name="fill_tourer_items[]" value="mobile" {if in_array('mobile',$info['fill_tourer_items_arr']) || empty($info['id'])}checked="checked"{/if} />手机号</label>
                                  <label class="radio-label"><input type="checkbox" name="fill_tourer_items[]" value="cardnumber" {if in_array('cardnumber',$info['fill_tourer_items_arr']) || empty($info['id'])}checked="checked"{/if} />证件号</label>
                                  <label class="radio-label"><input type="checkbox" name="fill_tourer_items[]" value="sex"  {if in_array('sex',$info['fill_tourer_items_arr']) || empty($info['id'])}checked="checked"{/if}/>性别</label>
                              </div>
                          </li>
                          </ul>
                   </div>
                  <div class="clear clearfix pb-20" id="hidevalue">
                      <input type="hidden" name="ticketid" id="ticketid" value="{$info['id']}"/>
                      <input type="hidden" name="action" id="action" value="{$action}"/>
                      <input type="hidden" name="spotid" id="spotid" value="{$spotid}">
                      <a class="btn btn-primary radius size-L ml-115" id="btn_save" href="javascript:;">保存</a>
                  </div>
              </div>
            </form>
            </td>
        </tr>
    </table>
  
	<script>
        var back_symbol = '{Currency_Tool::back_symbol()}';
        var action = '{$action}';
        $(document).ready(function(){
            //保存
            $("#btn_save").click(function()
            {
                var pay_way_number = $('input[name^=pay_way]:checked').length;
                if(pay_way_number == 0){
                    ST.Util.showMsg('请至少选择一种支付方式',5,1000);
                    return false;
                }
                $("#product_frm").submit();
            });

            //添加类型按钮
            $("#newtickettype_btn").click(function(){
                if($('#field_newtickettype').is(':visible'))
                {
                    add_tickettype();
                }
                else
                {
                    $("#field_newtickettype").show();
                    $("#newtickettype_btn").text('确定');
                }
            });

            //头部切换
            $("#nav").find('span').click(function(){
                Product.changeTab(this,'.product-add-div');//导航切换
            });
            $("#nav").find('span').first().trigger('click');


            jQuery.validator.addMethod("time", function(value, element) {
                return this.optional(element) || /^[012]{0,1}[0-9]{1}:[0-6]{1}[0-9]{1}$/.test(value);
            }, "请输入正确的时间格式");

            $('#time_before').datetimepicker({
                format:'H:i',
                datepicker:false,
                timepicker:true,
                allowTimes:[
                    '01:00','02:00','03:00','04:00','05:00','06:00','07:00','08:00','09:00','10:00','11:00','12:00','13:00','14:00',
                    '15:00','16:00','17:00','18:00','19:00','20:00','21:00','22:00','23:00','00:00',
                ]
            });

            //验证
            $("#product_frm").validate({
                focusInvalid:false,
                rules: {
                    title:
                    {
                        required: true
                    },
                    tickettypeid:{
                        required:true
                    },
                    day_before:{
                        digits:true
                    },
                    time_before:{
                        time:true
                    }
                },
                messages: {
                    title:{
                        required:"请输入套餐名称"
                    },
                    tickettypeid:{
                        required:'门票类型不能为空'
                    },
                    day_before:{
                        digits:'仅能输入正整数'
                    }
                },
                errUserFunc:function(element){
                    var eleTop = $(element).offset().top;
                    $("html,body").animate({scrollTop: eleTop}, 100);
                },
                errorPlacement:function(error,element){
                    if(element.is('#day_before') || element.is('#time_before')) {
                        $(element).siblings('.error-lb').append(error);
                    }
                    else
                    {
                        $(element).parent().append(error)
                    }

                },
                submitHandler:function(form){

                    $.ajaxform({
                        url   :  SITEURL+"spot/admin/spot/ajax_ticket_save",
                        method  :  "POST",
                        form  : "#product_frm",
                        dataType:'json',
                        success  :  function(data)
                        {

                            if(data.status)
                            {
                                if(data.ticketid!=null){
                                    $("#ticketid").val(data.ticketid);
                                }
                                ST.Util.showMsg('保存成功!','4',2000);
                                $("#btn_view_more").show();
                            }
                        }});
                    return false;//阻止常规提交
                }
            });

            //初始化
            ajax_get_suit_price('','',true);
     });

    //添加报价
    function add_suit_price() {
        var ticketid = $("#ticketid").val();
        var spotid = $("#spotid").val();
        if(!ticketid)
        {
            var suitname = $("#suitname").val();
            if(suitname==''){
                ST.Util.showMsg('请输入套餐名称',5,1000);
                return false;
            }
            $.ajaxform({
                url   :  SITEURL+"spot/admin/spot/ajax_ticket_save",
                method  :  "POST",
                form  : "#product_frm",
                dataType:'json',
                success  :  function(data)
                {
                    if(data.status)
                    {
                        $("#ticketid").val(data.ticketid);
                        CHOOSE.setSome("添加报价",{maxHeight:600,loadWindow:window,loadCallback:add_suit_price_callback},SITEURL+'spot/admin/spot/dialog_add_suit_price?ticketid='+data.ticketid+'&spotid='+spotid,1)
                    }
                }});

        }
        else
        {
            CHOOSE.setSome("添加报价",{maxHeight:600,loadWindow:window,loadCallback:add_suit_price_callback},SITEURL+'spot/admin/spot/dialog_add_suit_price?ticketid='+ticketid+'&spotid='+spotid,1)

        }


    }
    //添加报价回调
    function add_suit_price_callback(result,bool) {
        if(!bool)
        {
            return false;
        }
        $.ajax({
            data:result.data,
            dataType:'json',
            type:'post',
            url:SITEURL+'spot/admin/spot/ajax_save_suit_price',
            success:function (data) {
                ST.Util.showMsg('保存成功',4,1000);
                ajax_get_suit_price('','',true)
            }
        });

    }

     //清除所有的报价
    function delall() {
        var ticketid = $("#ticketid").val();
        ST.Util.confirmBox('提示','清除报价后，不可恢复。确定清空全部报价?',function () {
            $.ajax({
                type:'post',
                dataType:'json',
                data:{ticketid:ticketid},
                url:SITEURL+'spot/admin/spot/ajax_clear_all_price',
                success:function (data) {
                    ST.Util.showMsg('清除成功',4,1000);
                   /* setTimeout(function () {
                        location.reload();
                    },1000);*/
                    ajax_get_suit_price('','',true)
                }
            })
        })
    }

    //查看日历报价
    function showMore()
    {
        var ticketid = $("#ticketid").val();
        var productid = $("#spotid").val();

        var width = $(window).width()-100;
        var height = $(window).height()-100
        // var url = "calendar.php?suitid="+suitid+"&carid="+carid;
        var url = SITEURL+'spot/admin/calendar/index/suitid/'+ticketid+'/typeid/5/productid/'+productid;
        ST.Util.showBox('查看报价',url,width,height);
    }


    //日期处理回调
    function calendarCallback(date) {
        return ajax_get_suit_price(date.getFullYear(),date.getMonth()+1,false)
    }

    //按月加载数据
    function ajax_get_suit_price(y,m,init) {
        var suitid = $("#ticketid").val();
        var out = [];
        $.ajax({
            type:'post',
            dataType:'json',
            async:false,
            data:{year:y,month:m,suitid:suitid},
            url:SITEURL+'spot/admin/spot/ajax_get_suit_price',
            success:function (data) {

                if(init)
                {
                    if(data.starttime)
                    {
                        $('#more_price').show();
                        calendar_init(data)
                        $('.container').show();
                    }
                    else
                    {
                        $('#more_price').hide();
                        $('.container').hide();
                    }
                }
                else
                {
                    out = data.list;
                }
            }

        });
        return out;
    }

    //修改报价
    function edit_price(data)
    {
        var ticketid = $("#ticketid").val();
        var spotid = $("#spotid").val();
        CHOOSE.setSome("修改报价("+data.date+')',{maxHeight:500,width:540,loadWindow:window,loadCallback:calendar_edit},SITEURL+'spot/admin/spot/dialog_edit_suit_price?ticketid='+ticketid+'&date='+data.date+'&spotid='+spotid,1)
    }
    //修改报价，更新日历
    function calendar_edit(data,bool)
    {

        if(!bool)
        {
            return false;
        }
        else
        {
            $.ajax({
                data:data.data,
                dataType:'json',
                type:'post',
                url:SITEURL+'spot/admin/spot/ajax_save_day_price',
                success:function (data) {
                    ST.Util.showMsg('保存成功',4,1000);
                    set_calendat_day_params(data)
                }
            })
        }
    }

    //修改日历某天的显示数据
    function set_calendat_day_params(data) {

        if(data['is_clear']!='1')
        {
            data.number==-1 ?  number='充足' :  number=data.number;
           adultprice = back_symbol+data.adultprice;

            var html = '<p class="item"><span class="attr">价格</span><span class="num">'+adultprice+'</span></p>' +
                '<p class="item"><span class="attr">库存</span><span class="num">'+number+'</span></p>';
            $('.calendar-table-wrapper td[data-id='+data.date+'] .data-hook').html(html)
        }
        else
        {
            $('.calendar-table-wrapper td[data-id='+data.date+'] .data-hook').html('')
        }

    }

    //日历初始化
    function calendar_init(mockData) {
            $.CalendarPrice({
                // 显示日历的容器
                el: '.container',
                // 设置开始日期
                // 可选参数，默认为系统当前日期
                 startDate: mockData.starttime,
                // 可选参数，默认为开始日期相同的1年后的日期
                // 设置日历显示结束日期
                //  endDate: '2018-09',
                // 初始数据
                data: mockData.list,
                //点击单个日期,修改报价
                everyday: function (data) {
                    edit_price(data);
                },
                // 配置需要设置的字段名称，请与你传入的数据对象对应
                config: [
                    {
                        key: 'price',
                        name: '价格'
                    },
                    {
                        key: 'number',
                        name: '库存'
                    }
                ],
                // 配置在日历中要显示的字段
                show: [
                    {
                        key: 'price',
                        name: '价格'
                    },
                    {
                        key: 'number',
                        name: '库存'
                    }
                ],
                // 自定义风格(颜色)
                style: {
                    // 详见参数说明
                    // ...
                    // 头部背景色
                    //headerBgColor: '#f00',
                    // 头部文字颜色
                    //headerTextColor: '#fff'
                }
            });
        }

      //添加类型
        function  add_tickettype()
        {
            var spotid = $("#spotid").val();
            var name = $("#field_newtickettype").val();
            name = $.trim(name);
            if(!name)
            {
                ST.Util.showMsg('类型名称不能为空', 5, 1000);
                return;
            }

            $.ajax({
                data:{name:name,spotid:spotid},
                dataType:'json',
                type:'post',
                url:SITEURL+'spot/admin/spot/ajax_add_tickettype',
                success:function (result) {
                    if(result.status)
                    {
                        var data = result.data;
                        var option_html = "<option selected='selected' value='"+data.id+"'>"+data.kindname+"</option>"
                        $("#tickettypeid").append(option_html);
                        $("#field_newtickettype").hide();
                        $("#newtickettype_btn").text('添加类型');
                        ST.Util.showMsg('添加门票类型成功', 4, 1000);
                    }
                    else
                    {
                        ST.Util.showMsg(data.msg, 5, 1000);
                    }
                }
            })
        }

    </script>


</body>
</html>
