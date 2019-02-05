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
    <style>
      .capricorncd-calendar-container{
        width: 1200px;
      }

      .basic{
        color: blue;
      }
    </style>
</head>

<body>

    <table class="content-tab">
        <tr>
            <td width="119px" class="content-lt-td"  valign="top">
                {template 'stourtravel/public/leftnav'}
                <!--右侧内容区-->
            </td>
            <td valign="top" class="content-rt-td">
                <form method="post" name="product_frm" id="product_frm" autocomplete="off">

                    <div class="cfg-header-bar">
                        <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
                    </div>

              <div class="manage-nr">

                   <!--基础信息开始-->
                  <div class="product-add-div">
                      <ul class="info-item-block">
                          <li>
                              <span class="item-hd">产品名称：</span>
                              <div class="item-bd">
                                  <div class="item-text">{$lineinfo['title']}</div>
                                  <input type="hidden" name="lineid" id="lineid" value="{$lineinfo['id']}"/>
                                  <input type="hidden" name="suitid" id="suitid" value="{$info['id']}">
                              </div>
                          </li>
                          <li>
                              <span class="item-hd">套餐名称：</span>
                              <div class="item-bd">
                                  <input type="text" name="suitname" id="suitname"  class="input-text w600" value="{$info['suitname']}" />
                              </div>
                          </li>
                          <li>
                              <span class="item-hd">原价{Common::get_help_icon('product_original_price')}：</span>
                              <div class="item-bd">
                                  <input type="text" name="sellprice" id="sellprice" maxlength="6"  class="input-text w100 number-only" value="{$info['sellprice']}" />
                              </div>
                          </li>

                          <li>
                              <span class="item-hd">套餐报价：</span>
                              <div class="item-bd">
                                  <a href="javascript:;" class="fl btn btn-primary radius size-S mt-3 mr-5"  onclick="add_suit_price()" title="添加报价">添加报价</a>
                                  <a href="javascript:;" class="btn btn-grey-outline radius size-S mt-3 ml-5" onclick="delall()">清除报价</a>
                                  <a class="btn-link" id="more_price"  onclick="showMore()" style="margin-left: 560px;display: none">查看更多报价</a>
                              </div>
                          </li>
                        <li>
                          <span class="item-hd">日历价格说明：</span>
                          <div class="item-bd" style="position: relative;top: 5px;"><span style="color:#ff6600;">橙色：销售价</span>&nbsp;&nbsp;&nbsp;<span style="color:blue;">蓝色：结算价</span></div>
                        </li>
                          <li>
                              <span class="item-hd"></span>
                              <div class="item-bd">
                                  <div class="container fl">

                                  </div>
                              </div>
                          </li>
                          <li>
                              <span class="item-hd">价格说明：</span>

                              <div class="item-bd">
                                  <span class="mr-10 w60" style="display: inline-block">儿童标准</span><input type="text" name="childdesc" id="childdesc"  class="input-text w600" value="{$info['childdesc']}" />
                              </div>
                              <div class="item-bd mt-10">
                                  <span class="mr-10 w60" style="display: inline-block">老人标准</span><input type="text" name="olddesc" id="olddesc"  class="input-text w600" value="{$info['olddesc']}" />
                              </div>
                              <div class="item-bd mt-10">
                                  <span class="mr-10 w60" style="display: inline-block" >单房差标准</span><input type="text" name="roomdesc" id="adultdesc"  class="input-text w600" value="{$info['roomdesc']}" />
                              </div>
                          </li>
                      </ul>
                      <div class="line"></div>
                      <ul class="info-item-block">
                          <li>
                              <span class="item-hd">套餐说明：</span>
                              <div class="item-bd">
                                  {php Common::getEditor('content',$info['description'],$sysconfig['cfg_admin_htmleditor_width'],300,'Line');}
                              </div>
                          </li>
                          <li>
                              <span class="item-hd">会员预定方式：</span>
                              <div class="item-bd">
                                  <div class="on-off">
                                      <label class="radio-label"><input type="radio" name="paytype" value="1" {if $info['paytype']=='1' OR empty($info['paytype'])}checked="checked"{/if} />全额预定</label>
<!--                                       <label class="radio-label ml-20"><input type="radio" name="paytype" value="2" {if $info['paytype']=='2'}checked="checked"{/if} />定金预定</label>
                                      <span id="dingjin" style="{if $info['paytype'] != '2'}display: none{/if}">
                                          &nbsp;&nbsp;&nbsp;每人支付定金
                                          <input type="text" class="input-text w60 va-t" maxlength="6" name="dingjin" id="dingjintxt" value="{$info['dingjin']}" size="6" onkeyup="(this.v=function(){this.value=this.value.replace(/[^0-9-\.]+/,'');}).call(this)" onblur="this.v();">&nbsp;</span> -->

                                      <script>
                                          $("input[name='paytype']").click(function(){
                                              if($(this).val() == 2)
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
                                      </script>
                                  </div>
                              </div>
                          </li>
                          <li>
                              <span class="item-hd">预定确认方式：</span>
                              <div class="item-bd">
                                  <label class="radio-label"><input type="checkbox" name="need_confirm" value="1" {if $info['need_confirm']=='1'}checked="checked"{/if} />需要供应商或管理员手动确认</label>
                              </div>
                          </li>
                          <li>
                              <span class="item-hd">会员支付方式：</span>
                              <div class="item-bd">
                                  <label class="radio-label"><input type="checkbox" name="pay_way[]" id="online_pay" value="1" {if $info['pay_way']=='1' || $info['pay_way']==3}checked="checked"{/if} {if $action=='add'}checked="checked"{/if} />线上支付</label>
<!--                                   <label class="radio-label"><input type="checkbox" name="pay_way[]" id="offline_pay" value="2" {if $info['pay_way']=='2' || $info['pay_way']==3}checked="checked"{/if} {if $action=='add'}checked="checked"{/if} />线下支付</label> -->
                              </div>
                          </li>
<!--                           <li>
                              <span class="item-hd">待付款时限：</span>
                              <div class="item-bd">
                                  <input type="text" name="auto_close_time_hour" id="auto_close_time_hour" maxlength="2" onkeyup="value=value.replace(/[^\d]/g,'')"  class="input-text w60" {if $action=='add'}value="24"{else}value="{$info['auto_close_time_hour']}"{/if} />&nbsp;小时
                                  <input type="text" name="auto_close_time_minute" id="auto_close_time_minute" maxlength="2" onkeyup="value=value.replace(/[^\d]/g,'')"  class="input-text w60" {if $action=='add'}value="0"{else}value="{$info['auto_close_time_minute']}"{/if} />&nbsp;分钟
                              </div>
                          </li> -->

                      </ul>
                  </div>
                  <!-- 基础信息结束 -->

                  <div class="clear clearfix pb-20" id="hidevalue">
                      <input type="hidden" name="pricerule" id="pricerule" value="{$info['lastoffer']['pricerule']}"/>
                      <input type="hidden" name="action" id="action" value="{$action}"/>
                      <input type="hidden" name="lineid" id="lineid" value="{$lineinfo['id']}">
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
        $("#btn_save").click(function(){
                var suitname = $("#suitname").val();
                if(suitname==''){
                    ST.Util.showMsg('请输入套餐名称',5,1000);
                    return false;
                }

                var pay_way_number = $('input[name^=pay_way]:checked').length;
                if(pay_way_number == 0){
                    ST.Util.showMsg('请至少选择一种支付方式',5,1000);
                    return false;
                }
                $.ajaxform({
                       url   :  SITEURL+"line/admin/line/ajax_suitsave",
                       method  :  "POST",
                       form  : "#product_frm",
                       dataType:'html',
                       async:false,
                       success  :  function(result)
                       {

                           var data = result;
                           if(data!='no')
                           {
                               $("#suitid").val(data);
                               ST.Util.showMsg('保存成功!','4',2000);
                               $("#btn_view_more").show();


                           }
                       }});
        });
        ajax_get_suit_price('','',true);



     });

    //添加报价
    function add_suit_price() {
        var suitid = $("#suitid").val();
        var lineid = $("#lineid").val();
        if(!suitid)
        {
            var suitname = $("#suitname").val();
            if(suitname==''){
                ST.Util.showMsg('请输入套餐名称',5,1000);
                return false;
            }
            $.ajaxform({
                url   :  SITEURL+"line/admin/line/ajax_suitsave",
                method  :  "POST",
                form  : "#product_frm",
                dataType:'html',
                success  :  function(result)
                {
                    var data = result;
                    if(data!='no')
                    {
                        $("#suitid").val(data);

                        CHOOSE.setSome("添加报价",{maxHeight:600,loadWindow:window,loadCallback:add_suit_price_callback},SITEURL+'line/admin/line/dialog_add_suit_price?suit='+data+'&lineid='+lineid,1)

                    }
                }});

        }
        else
        {
            CHOOSE.setSome("添加报价",{maxHeight:600,loadWindow:window,loadCallback:add_suit_price_callback},SITEURL+'line/admin/line/dialog_add_suit_price?suit='+suitid+'&lineid='+lineid,1)

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
            url:SITEURL+'line/admin/line/ajax_save_suit_price',
            success:function (data) {
                ST.Util.showMsg('保存成功',4,1000);
                ajax_get_suit_price('','',true)
            }
        });

    }

     //清除所有的报价
    function delall() {
        var suitid = $("#suitid").val();
        var lineid = $("#lineid").val();
        ST.Util.confirmBox('提示','清除报价后，不可恢复。确定清空全部报价?',function () {
            $.ajax({
                type:'post',
                dataType:'json',
                data:{suitid:suitid,lineid:lineid},
                url:SITEURL+'line/admin/line/ajax_clear_all_price',
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
        var suitid = $("#suitid").val();
        var productid = $("#lineid").val();
        var width = $(window).width()-100;
        var height = $(window).height()-100
        var url = SITEURL+'line/admin/calendar/index/suitid/'+suitid+'/productid/'+productid;
        ST.Util.showBox('查看报价',url,1350,height);
    }


    //日期处理回调
    function calendarCallback(date) {
        return ajax_get_suit_price(date.getFullYear(),date.getMonth()+1,false)
    }

    //按月加载数据
    function ajax_get_suit_price(y,m,init) {
        var suitid = $("#suitid").val();
        var out = [];
        $.ajax({
            type:'post',
            dataType:'json',
            async:false,
            data:{year:y,month:m,suitid:suitid},
            url:SITEURL+'line/admin/calendar/ajax_get_suit_price',
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
        var suitid = $("#suitid").val();
        var lineid = $("#lineid").val();
        CHOOSE.setSome("修改报价("+data.date+')',{maxHeight:500,width:540,loadWindow:window,loadCallback:calendar_edit},SITEURL+'line/admin/line/dialog_edit_suit_price?suit='+suitid+'&date='+data.date+'&lineid='+lineid,1)
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
                url:SITEURL+'line/admin/line/ajax_save_day_price',
                success:function (data) {
                    ST.Util.showMsg('保存成功',4,1000);
                    set_calendat_day_params(data)
                }
            })
        }
    }

    //修改日历某天的显示数据
    function set_calendat_day_params(data) {

        var propgroup = data.propgroup.split(',');
        if(propgroup[0])
        {
            var adultprice = '' ;
            var adultbasicprice='';
            var childprice = '';
            var childbasicprice='';
            var oldprice = '';
            var oldbasicprice='';
            var number = 0;
            data.number==-1 ?  number='充足' :  number=data.number;
            if($.inArray('2',propgroup)!=-1)
            {
                adultprice = back_symbol+data.adultprice;
                adultbasicprice = back_symbol+data.adultbasicprice;
            }
            if($.inArray('1',propgroup)!=-1)
            {
                childprice = back_symbol+data.childprice;
                childbasicprice=back_symbol+data.childbasicprice;
            }
            if($.inArray('3',propgroup)!=-1)
            {
                oldprice = back_symbol+data.oldprice;
                oldbasicprice=back_symbol+data.oldbasicprice;
            }
            var html = '<p class="item"><span class="attr">成人</span><span class="num">'+adultprice+'<span class="basic">'+adultbasicprice+'</span></span></p>' +
                '<p class="item"><span class="attr">小孩</span><span class="num">'+childprice+'<span class="basic">'+childbasicprice+'</span></span></p>' +
                '<p class="item"><span class="attr">老人</span><span class="num">'+oldprice+'<span class="basic">'+oldbasicprice+'</span></span></p>' +
                '<p class="item"><span class="attr">单房差</span><span class="num">'+back_symbol+data.roombalance+'</span></p>' +
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
                        name: '成人'
                    },
                    {
                        key: 'child_price',
                        name: '小孩'
                    },
                    {
                        key: 'old_price',
                        name: '老人'
                    },
                    {
                        key: 'roombalance',
                        name: '单房差'
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
                        name: '成人'
                    },
                    {
                        key: 'child_price',
                        name: '小孩'
                    },
                    {
                        key: 'old_price',
                        name: '老人'
                    },
                    {
                        key: 'roombalance',
                        name: '单房差'
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
    </script>


</body>
</html>
