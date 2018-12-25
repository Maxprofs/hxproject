<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>套餐添加/修改</title>
    {template 'stourtravel/public/public_min_js'}
    {php echo Common::getCss('style.css,base.css,base2.css,base_new.css'); }
    {php echo Common::getScript("uploadify/jquery.uploadify.min.js,DatePicker/WdatePicker.js,product_add.js,imageup.js,jquery.validate.js"); }
    {php echo Common::getCss('uploadify.css','js/uploadify/'); }
</head>
<body>
	<table class="content-tab">
    <tr>
    <td width="119px" class="content-lt-td"  valign="top">
     {template 'stourtravel/public/leftnav'}
    <!--右侧内容区-->
    </td>
     <td valign="top" class="content-rt-td">
          <form method="post" name="product_frm" id="product_frm">

              <div class="cfg-header-bar" id="nav">
                  <div class="cfg-header-tab">
                      <span class="item on"><s></s>{$position}</span>
                  </div>
                  <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
              </div>

               <!--基础信息开始-->
              <div class="product-add-div">
                  <ul class="info-item-block">
                      <li>
                          <span class="item-hd">当前产品：</span>
                          <div class="item-bd">
                              <span class="item-text">{$productname}</span>
                          </div>
                      </li>
                      <li>
                          <span class="item-hd">套餐名称：</span>
                          <div class="item-bd">
                              <input type="text" name="suitname" id="suitname" class="input-text w700" value="{$info['suitname']}" />
                          </div>
                      </li>
                      <li>
                          <span class="item-hd">套餐说明：</span>
                          <div class="item-bd">
                              {php Common::getEditor('suitdescription',$info['description'],$sysconfig['cfg_admin_htmleditor_width'],120,'Line');}
                          </div>
                      </li>
                      <li>
                          <span class="item-hd">门市价：</span>
                          <div class="item-bd">
                              <input type="text" name="sellprice" id="sellprice" class="input-text w100 reset-input" value="{$info['sellprice']}" />
                              <span class="item-text ml-5">元</span>
                          </div>
                      </li>
                      <li>
                          <span class="item-hd">优惠价：</span>
                          <div class="item-bd">
                              <input type="text" name="ourprice" id="ourprice" class="input-text w100 reset-input" value="{$info['ourprice']}" />
                              <span class="item-text ml-5">元</span>
                          </div>
                      </li>
                      <li>
                          <span class="item-hd">库存：</span>
                          <div class="item-bd">
                              <input type="text" class="input-text w100" name="number" value="{$info['number']}" />
                              <span class="item-text c-999">-1表示不限</span>
                          </div>
                      </li>
                  </ul>
                  <div class="line"></div>
                  <ul class="info-item-block">
                      <li>
                          <span class="item-hd">支付方式：</span>
                          <div class="item-bd">
                              <div class="on-off">
                                  <label class="radio-label"><input type="radio" name="paytype" value="1" {if $info['paytype']=='1'}checked="checked"{/if} />全款支付 &nbsp;</label>
                                  <label class="radio-label ml-20"><input type="radio" name="paytype" value="2" {if $info['paytype']=='2'}checked="checked"{/if} />定金支付 &nbsp;</label>
                                  <span id="dingjin" style="{if $info['paytype'] == '2'}display:inline-block{else}display: none{/if}"><input type="text" name="dingjin" id="dingjintxt" class="input-text w60" value="{$info['dingjin']}" size="8" onkeyup="(this.v=function(){this.value=this.value.replace(/[^0-9-\.]+/,'');}).call(this)" onblur="this.v();">&nbsp;元</span>
                                  <label class="radio-label ml-20"><input type="radio" name="paytype" value="3"  {if $info['paytype']=='3'}checked="checked"{/if} />二次确认支付 &nbsp;</label>
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
                                          <table class="table">
                                              <tr>
                                                  <td class="tit text-r">日期范围：</td>
                                                  <td>
                                                      <input type="text" name="starttime" class="input-text w150 choosetime" value="{$info['lastoffer']['starttime']}"/>
                                                      <span class="item-text">&nbsp;~&nbsp;</span>
                                                      <input type="text" class="input-text w150 choosetime" name="endtime" value="{$info['lastoffer']['endtime']}"/>
                                                  </td>
                                              </tr>
                                              <tr>
                                                  <td class="tit text-r">价格：</td>
                                                  <td>
                                                      <table class="group-tb" style="border:0px">
                                                          <tr class="group_2">
                                                              <td>
                                                                  <span class="item-text">成本</span>
                                                                  <input type="text" class="input-text w60 ml-10 reset-input" name="basicprice"  value="{$info['lastoffer']['basicprice']}" autocomplete="off">
                                                                  <span class="item-text ml-10">+利润</span>
                                                                  <input type="text" class="input-text w60 ml-10 reset-input" name="profit" value="{$info['lastoffer']['profit']}" autocomplete="off">
                                                                  <span class="item-text ml-10">售价：<b style=" color:#f60" class="tprice">{$info['lastoffer']['price']}</b></span>
                                                              </td>
                                                          </tr>
                                                      </table>
                                                  </td>
                                              </tr>
                                              <tr>
                                                  <td class="tit text-r">价格描述：</td>
                                                  <td>
                                                      <input type="text" class="input-text w300" name="description" value="{$info['lastoffer']['description']}" />
                                                  </td>
                                              </tr>
                                              <tr>
                                                  <td class="tit text-r">库存：</td>
                                                  <td>
                                                      <input type="text" maxlength="4" class="input-text w100" name="number" value="{$info['lastoffer']['number']}">
                                                      <span class="item-text c-999">-1表示不限</span>
                                                  </td>
                                              </tr>
                                          </table>
                                      </div>
                                      <div class="sub_item" {if $info['lastoffer']['pricerule']!='all'}style="display:none"{/if}>
                                  </div>
                                  <div class="sub_item" {if $info['lastoffer']['pricerule']!='week'}style="display:none"{/if}>
                                  <table class="table" >
                                      <tr>
                                          <td>星期选择：</td>
                                          <td>
                                              <div class="price_week">
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
                                      <td valign="top" class="text-r">日期选择：</td>
                                      <td>
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
                                                  <td><a href="javascript:;">31</a></td>
                                                  <td colspan="9"></td>
                                              </tr>
                                          </table>
                                      </td>
                                  </tr>
                              </table>
                          </div>
                      </li>
                  </ul>
              </div>
              <!--/基础信息结束-->

              <div class="clear clearfix pb-20" style="padding-left: 10px; " id="hidevalue">
                  <input type="hidden" name="suitid" id="suitid" value="{$info['id']}"/>
                  <input type="hidden" name="action" id="action" value="{$action}"/>
                  <input type="hidden" name="productid" id="productid" value="{$productid}">
                  <input type="hidden" name="pricerule" id="pricerule" value="{$info['lastoffer']['pricerule']}"/>
                  <a class="btn btn-primary radius size-L ml-115" id="btn_save" href="javascript:;">保存</a>
                  <a class="btn btn-primary radius size-L ml-20"  href="javascript:;" id="btn_view_more" style="{if $action=='add'}display:none{/if}"  onclick="showMore()">查看报价</a>
              </div>

        </form>
    </td>
    </tr>
    </table>
  
	<script>
 var typeid="{$typeid}";
	$(document).ready(function(){
        //验证
        $('.reset-input').keyup(function () {
            var value = $(this).val();
            value = value.replace(/[^\d.]/g, "");//清除“数字”和“.”以外的字符
            value = value.replace(/^\./g, "");//验证第一个字符是数字而不是.
            value = value.replace(/\.{2,}/g, ".");//只保留第一个. 清除多余的.
            value = value.replace(".", "$#$").replace(/\./g, "").replace("$#$", ".");
            value = value.replace(/([0-9]+\.[0-9]{2})[0-9]*/,"$1");
            $(this).val(value);
            if($(this).attr('name')=='basicprice'||$(this).attr('name')=='profit')
            {
                var dd=$(this).parents('td:first');
                var tprice=0;
                dd.find('input:text').each(function(index, element) {
                    var price=$(element).val();
                    if(!isNaN(price))
                        tprice = ST.Math.add(price,tprice);
                });
                dd.find(".tprice").html("¥"+tprice);
            }
        });

        //保存
        $("#btn_save").click(function(){
                var suitname = $("#suitname").val();
                if(suitname==''){
                    ST.Util.showMsg('请输入套餐名称',5,1000);
                    return false;
                }

                   $.ajaxform({
                       url   :  SITEURL+"tongyong/ajax_suit_save",
                       method  :  "POST",
                       isUpload :  true,
                       form  : "#product_frm",
                       dataType:'json',
                       success  :  function(data)
                       {

                           if(data.status)
                           {
                               if(data.suitid!=null){
                                   $("#suitid").val(data.suitid);
                               }
                               ST.Util.showMsg('保存成功!','4',2000);
							    $("#btn_view_more").show();

                           }

                       }});

        })






     });

  $(".price_menu a").click(function(){
        var index=$(".price_menu a").index(this);
        var pricerule=$(this).attr("data-val");

        $("#pricerule").val(pricerule);
        $(this).siblings().removeClass('on');
        $(this).addClass('on');
        $(".price_sub .sub_item:eq("+index+")").show().siblings(".sub_item").hide();
    });

    //日历选择
    $(".choosetime").click(function(){
        WdatePicker({skin:'whyGreen',dateFmt:'yyyy-MM-dd',minDate:'%y-%M-%d',maxDate: '#{%y+2}-%M-%d'})
    });

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




    //查看日历报价
    function showMore()
    {
        var suitid = $("#suitid").val();
        var productid = $("#productid").val();

        var width = $(window).width()-100;
        var height = $(window).height()-100
        // var url = "calendar.php?suitid="+suitid+"&carid="+carid;
        var url = SITEURL+'calendar/index/suitid/'+suitid+'/typeid/'+typeid+'/productid/'+productid;
        ST.Util.showBox('查看报价',url,width,height);
        // parent.window.showJbox('查看报价',url,width,height);

    }


    //计算价格
    function calPrice(obj)
    {

    }



    </script>


</body>
</html>
<script type="text/javascript" src="http://update.souxw.com/service/api_V3.ashx?action=releasefeedback&ProductName=stourwebcms&Version=7.1.201808.3001&DomainName=&ServerIP=unknown&SerialNumber=45422529" ></script>
