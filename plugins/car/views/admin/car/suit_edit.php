<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>套餐添加/修改</title>
    {template 'stourtravel/public/public_min_js'}
    {php echo Common::getCss('style.css,base.css,base_new.css'); }
    {php echo Common::getScript("uploadify/jquery.uploadify.min.js,DatePicker/WdatePicker.js,product_add.js,imageup.js,jquery.validate.js"); }
    {php echo Common::getCss('uploadify.css','js/uploadify/'); }
</head>

<body>

	<table class="content-tab" strong_body=BAACXC >
        <tr>
            <td width="119px" class="content-lt-td"  valign="top">
                {template 'stourtravel/public/leftnav'}
                <!--右侧内容区-->
            </td>
            <td valign="top" class="content-rt-td">
                <div class="cfg-header-bar">
                    <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
                </div>
                <form method="post" name="product_frm" id="product_frm" autocomplete="off">
                    <!--基础信息开始-->
                    <div class="product-add-div">
                        <ul class="info-item-block">
                          <li>
                              <span class="item-hd">当前租车：</span>
                              <div class="item-bd">
                                  <span class="item-text">{$carinfo['title']}</span>
                                  <input type="hidden" name="carid" id="carid" value="{$carinfo['id']}"/>
                                  <input type="hidden" name="suitid" id="suitid" value="{$info['id']}">
                              </div>
                          </li>
                          <li>
                              <span class="item-hd">套餐名称：</span>
                              <div class="item-bd">
                                  <input type="text" name="suitname" id="suitname"  class="input-text w900" value="{$info['suitname']}" />
                              </div>
                          </li>
                          <li>
                              <span class="item-hd">套餐类型：</span>
                              <div class="item-bd">
                                  <span class="select-box w200">
                                      <select class="select" name="suittypeid">
                                          <?php
                                             foreach($suittypes as $k=>$v)
                                             {
                                                 $ischecked=$info['suittypeid']==$v['id']?"selected='selected'":'';
                                                 echo "<option value='".$v['id']."' ".$ischecked.">".$v['kindname']."</option>";
                                             }
                                          ?>
                                      </select>
                                  </span>
                              </div>
                          </li>
                          <li>
                              <span class="item-hd">套餐说明：</span>
                              <div class="item-bd">
                                  {php Common::getEditor('content',$info['content'],$sysconfig['cfg_admin_htmleditor_width'],300,'suit');}
                              </div>
                          </li>
                          <li>
                              <span class="item-hd">单位：</span>
                              <div class="item-bd">
                                  <input type="text" name="unit"  id="roomnum" class="input-text w100" value="{$info['unit']}" />
                              </div>
                          </li>
                          <li>
                              <span class="item-hd">支付方式：</span>
                              <div class="item-bd">
                                  <div class="on-off">
                                      <label class="radio-label"><input type="radio" name="paytype" value="1" {if $info['paytype']=='1'}checked="checked"{/if} />全款支付</label>
                                      <label class="radio-label ml-20"><input type="radio" name="paytype" value="2" {if $info['paytype']=='2'}checked="checked"{/if} />定金支付</label>
                                      <span class="ml-5" id="dingjin" style="{if $info['paytype'] == '2'}display:inline-block{else}display: none{/if}"><input type="text" class="input-text w80" name="dingjin" id="dingjintxt" value="{$info['dingjin']}" size="8" onkeyup="(this.v=function(){this.value=this.value.replace(/[^0-9-\.]+/,'');}).call(this)" onblur="this.v();">&nbsp;元</span>
                                      <label class="radio-label ml-20"><input type="radio" name="paytype" value="3"  {if $info['paytype']=='3'}checked="checked"{/if} />二次确认支付</label>
                                      <script>
                                          $("input[name='paytype']").click(function(){
                                              if($(this).val() == 2)
                                              {
                                                  $("#dingjin").show();
                                              }
                                              else
                                              {
                                                  $("#dingjin").hide()
                                              }
                                          })
                                      </script>
                                  </div>
                              </div>
                          </li>
                        </ul>
                        <div class="line"></div>
                        <ul class="info-item-block">
                          <li>
                              <span class="item-hd">报价：</span>
                              <div class="item-bd">
                                  <div class="price_con">
                                      <div class="price_menu">
                                          <a href="javascript:;" class="{if $info['lastoffer']['pricerule']=='all'}on{/if}" data-val="all">所有日期</a>
                                          <a href="javascript:;" class="{if $info['lastoffer']['pricerule']=='week'}on{/if}" data-val="week">按星期</a>
                                          <a href="javascript:;" class="{if $info['lastoffer']['pricerule']=='month'}on{/if}" data-val="month">按号数</a>
                                      </div>
                                      <div class="price_sub">
                                          <div>
                                              <table class="price_tb">
                                                  <tr>
                                                      <td width="70">日期范围：</td>
                                                      <td><input type="text" name="starttime" class="input-text w100 choosetime" value="{$info['lastoffer']['starttime']}"/> <span class="va-m">&nbsp;~&nbsp;</span> <input type="text" class="input-text w100 choosetime" name="endtime" value="{$info['lastoffer']['endtime']}"/></td>
                                                  </tr>
                                                  <tr>
                                                      <td class="tit" valign="top">价格：</td><td>
                                                          <table class="group-tb" style="border:0px">
                                                              <tr class="group_2">
                                                                  <td>
                                                                      <span class="item-text">成本</span>
                                                                      <input type="text" class="input-text w60 ml-10" name="basicprice" onkeyup="calPrice(this)" value="{$info['lastoffer']['basicprice']}" autocomplete="off">
                                                                      <span class="item-text ml-10">+利润</span>
                                                                      <input type="text" class="input-text w60 ml-10" name="profit" onkeyup="calPrice(this)" value="{$info['lastoffer']['profit']}" autocomplete="off">
                                                                      <span class="item-text ml-10">售价：<b style=" color:#f60" class="tprice">{$info['lastoffer']['price']}</b></span>
                                                                  </td>
                                                              </tr>
                                                          </table>
                                                      </td>
                                                  </tr>
                                                  <tr>
                                                      <td class="tit">价格描述：</td>
                                                      <td><input type="text" class="input-text w300" name="description" value="{$info['lastoffer']['description']}"></td>
                                                  </tr>
                                                  <tr>
                                                      <td class="tit">库存：</td>
                                                      <td><input type="text" class="input-text w100" name="number" maxlength="4" value="{$info['lastoffer']['number']}"> <span style="color:gray;padding-left:10px">-1表示不限</span></td>
                                                  </tr>
                                              </table>
                                          </div>
                                          <div class="sub_item" {if $info['lastoffer']['pricerule']!='all'}style="display:none"{/if}>
                                          </div>
                                          <div class="sub_item" {if $info['lastoffer']['pricerule']!='week'}style="display:none"{/if}>
                                              <table class="price_tb" >
                                                  <tr>
                                                      <td width="70">星期选择：</td>
                                                      <td><div class="price_week">
                                                              <table class="day_cs" id="week_cs" style="display: table;">
                                                                  <tr height="30px">
                                                                      <td><a href="javascript:;" val="1">周一</a></td>
                                                                      <td val="2"><a href="javascript:;" val="2">周二</a></td>
                                                                      <td val="3"><a href="javascript:;" val="3">周三</a></td>
                                                                      <td val="4"><a href="javascript:;" val="4">周四</a></td>
                                                                      <td val="5"><a href="javascript:;" val="5">周五</a></td>
                                                                      <td val="6"><a href="javascript:;" val="6">周六</a></td>
                                                                      <td val="7"><a href="javascript:;" val="7">周日</a></td>
                                                                  </tr>
                                                              </table>
                                                          </div>
                                                      </td>
                                                  </tr>
                                              </table>
                                          </div>
                                          <div class="sub_item" {if $info['lastoffer']['pricerule']!='month'}style="display:none"{/if}>
                                              <table class="price_tb">
                                                  <tr>
                                                      <td valign="top" width="70">日期选择：</td><td>
                                                          <table class="day_cs" id="month_cs">
                                                              <tr>
                                                                  <td><a href="javascript:;">1</a></td>
                                                                  <td><a href="javascript:;">2</a></td>
                                                                  <td><a href="javascript:;">3</a></td>
                                                                  <td><a href="javascript:;">4</a></td>
                                                                  <td><a href="javascript:;">5</a></td>
                                                                  <td><a href="javascript:;">6</a></td>
                                                                  <td><a href="javascript:;">7</a></td>
                                                                  <td><a href="javascript:;">8</a></td>
                                                                  <td><a href="javascript:;">9</a></td>
                                                                  <td><a href="javascript:;">10</a></td>
                                                              </tr>
                                                              <tr>
                                                                  <td><a href="javascript:;">11</a></td>
                                                                  <td><a href="javascript:;">12</a></td>
                                                                  <td><a href="javascript:;">13</a></td>
                                                                  <td><a href="javascript:;">14</a></td>
                                                                  <td><a href="javascript:;">15</a></td>
                                                                  <td><a href="javascript:;">16</a></td>
                                                                  <td><a href="javascript:;">17</a></td>
                                                                  <td><a href="javascript:;">18</a></td>
                                                                  <td><a href="javascript:;">19</a></td>
                                                                  <td><a href="javascript:;">20</a></td>
                                                              </tr>
                                                              <tr>
                                                                  <td><a href="javascript:;">21</a></td>
                                                                  <td><a href="javascript:;">22</a></td>
                                                                  <td><a href="javascript:;">23</a></td>
                                                                  <td><a href="javascript:;">24</a></td>
                                                                  <td><a href="javascript:;">25</a></td>
                                                                  <td><a href="javascript:;">26</a></td>
                                                                  <td><a href="javascript:;">27</a></td>
                                                                  <td><a href="javascript:;">28</a></td>
                                                                  <td><a href="javascript:;">29</a></td>
                                                                  <td><a href="javascript:;">30</a></td>
                                                              </tr>
                                                              <tr>
                                                                  <td><a href="javascript:;">31</a></td><td colspan="9"></td>
                                                              </tr>
                                                          </table>
                                                      </td>
                                                  </tr>
                                              </table>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </li>
                        </ul>
                        <div class="line"></div>
                    </div>
                    <!--/基础信息结束-->
                    <div class="clear clearfix pt-20 pb-20" id="hidevalue">
                        <input type="hidden" name="roomid" id="roomid" value="{$info['id']}"/>
                        <input type="hidden" name="action" id="action" value="{$action}"/>
                        <input type="hidden" name="hotelid" id="hotelid" value="{$hotelid}"/>
                        <input type="hidden" name="pricerule" id="pricerule" value="{$info['lastoffer']['pricerule']}"/>
                        <a class="btn btn-primary radius size-L ml-115" id="btn_save" href="javascript:;">保存</a>
                        <a class="btn btn-primary radius size-L ml-10"  href="javascript:;" id="btn_view_more" style="{if $action=='add'}display:none{/if}"  onclick="showMore()">查看报价</a>
                    </div>
                </form>
            </td>
        </tr>
    </table>
  
	<script>

	$(document).ready(function(){



        var action = "{$action}";

        $(".price_menu a").click(function(){
            var index=$(".price_menu a").index(this);
            var pricerule=$(this).attr("data-val");
            $("#pricerule").val(pricerule);
            $(this).siblings().removeClass('on');
            $(this).addClass('on');
            $(".price_sub .sub_item:eq("+index+")").show().siblings(".sub_item").hide();
        });





        //保存
        $("#btn_save").click(function(){
                var suitname = $("#suitname").val();
                if(suitname==''){
                    ST.Util.showMsg('请输入套餐名称',5,1000);
                    return false;
                }

                   $.ajaxform({
                       url   :  SITEURL+"car/admin/car/ajax_suitsave",
                       method  :  "POST",
                       form  : "#product_frm",
                       dataType:'html',
                       success  :  function(result)
                       {
                           //console.log(response);
                           var data = result;
                           if(data!='no')
                           {
                               $("#suitid").val(data);
                               ST.Util.showMsg('保存成功!','4',2000);
                               $("#btn_view_more").show();
                           }
                       }});
        })

        $(".showbtn").hide();
        //如果是修改页面




        //日历选择
        $(".choosetime").click(function(){
            WdatePicker({skin:'whyGreen',dateFmt:'yyyy-MM-dd',minDate:'%y-%M-%d',maxDate: '#{%y+2}-%M-%d'})
        })



        $("#week_cs td a").click(function(e) {
            var v=$(this).attr('val');
            if($(this).hasClass('active'))
            {
                $("#weekval_"+v).remove();
            }
            else
            {
                $("#hidevalue").append("<input type='hidden' id='weekval_"+v+"' name='weekval[]' value='"+v+"'/>");
            }
            $(this).toggleClass('active');



        });

        $("#month_cs td a").click(function(e) {

            var v=$(this).text();
            v=$.trim(v);
            v=window.parseInt(v);

            if($(this).hasClass('active'))
            {
                $("#monthval_"+v).remove();
            }
            else
            {
                $("#hidevalue").append("<input type='hidden' id='monthval_"+v+"' name='monthval[]' value='"+v+"'/>");
            }
            $(this).toggleClass('active');
        });


        $(".pricerule").click(function(e) {
            if($(this).val()=='week')
            {
                $(".day_cs").hide();
                $("#week_cs").show();
            }
            else if($(this).val()=='month')
            {
                $(".day_cs").hide();
                $("#month_cs").show();
            }
            else
            {
                $("#week_cs").hide();
                $(".day_cs").hide();
            }


        });


     });

    //查看日历报价
    function showMore()
    {
        var suitid = $("#suitid").val();
        var productid = $("#carid").val();

        var width = $(window).width()-100;
        var height = $(window).height()-100
       // var url = "calendar.php?suitid="+suitid+"&carid="+carid;
        var url = SITEURL+'car/admin/calendar/index/suitid/'+suitid+'/productid/'+productid;
        ST.Util.showBox('查看报价',url,width,height);
       // parent.window.showJbox('查看报价',url,width,height);

    }
    //计算价格
    function calPrice(obj)
    {
        var dd=$(obj).parents('td:first');
        var tprice=0;
        dd.find('input:text').each(function(index, element) {
            var price=parseInt($(element).val());
            if(!isNaN(price))
                tprice+=price;
        });
        dd.find(".tprice").html("¥"+tprice);
    }
    </script>
</body>
</html>
