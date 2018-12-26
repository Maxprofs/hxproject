<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>套餐添加/修改</title>
    <?php echo Common::css('admin_base.css,admin_base2.css,admin_style.css,style.css');?>
    <?php echo Common::js('jquery.min.js,common.js,product.js,choose.js');?>
    <?php echo  Stourweb_View::template("pub");  ?>
    <script type="text/javascript"src="/tools/js/DatePicker/WdatePicker.js"></script>
</head>
<body>
    <div class="content-box">
          <form method="post" name="product_frm" action="<?php echo $cmsurl;?>index/ajax_suitsave" id="product_frm" autocomplete="off">
          <div class="manage-nr">
              <div class="w-set-con">
              <div class="w-set-tit bom-arrow" id="nav">
                  <span class="on"><s></s>线路套餐</span>
                  <a href="javascript:;" class="refresh-btn" onclick="window.location.reload()">刷新</a>
              </div>
                  </div>
               <!--基础信息开始-->
              <div class="product-add-div">
              <div class="add-class">
                  <dl>
                      <dt>当前线路：</dt>
                      <dd>
                          <?php echo $lineinfo['title'];?>
                          <input type="hidden" name="lineid" id="lineid" value="<?php echo $lineinfo['id'];?>"/>
                          <input type="hidden" name="suitid" id="suitid" value="<?php echo $info['id'];?>">
                      </dd>
                  </dl>
                  <dl>
                      <dt>套餐名称：</dt>
                      <dd>
                          <input type="text" name="suitname" id="suitname"  class="set-text-xh text_700 mt-2" value="<?php echo $info['suitname'];?>" />
                      </dd>
                  </dl>
                  <dl>
                      <dt>套餐说明：</dt>
                      <dd style="height: 200px;line-height: 20px">
                          <?php Common::get_editor('description',$info['description'],700,120,'Line');?>
                      </dd>
                  </dl>
              </div>
              <div class="add-class">
                  <dl>
                      <dt>预订送积分：</dt>
                      <dd>
                          <input type="text" name="jifenbook" id="jifenbook" class="set-text-xh text_100 mt-2" value="<?php echo $info['jifenbook'];?>" />
                          <span class="fl ml-5">分</span>
                      </dd>
                  </dl>
                  <dl>
                      <dt>积分抵现金：</dt>
                      <dd>
                          <input type="text" name="jifentprice" id="jifentprice" value="<?php echo $info['jifentprice'];?>" class="set-text-xh text_100 mt-2 "  />
                          <span class="fl ml-5">元</span>
                      </dd>
                  </dl>
                  <dl>
                      <dt>评论送积分：</dt>
                      <dd>
                          <input type="text" name="jifencomment" id="jifencomment" class="set-text-xh text_100 mt-2" value="<?php echo $info['jifencomment'];?>"  />
                          <span class="fl ml-5">分</span>
                      </dd>
                  </dl>
                  <dl>
                      <dt>支付方式：</dt>
                      <dd>
                              <div class="on-off">
                                  <input type="radio" name="paytype" value="1" <?php if($info['paytype']=='1') { ?>checked="checked"<?php } ?>
 />全款支付 &nbsp;
                                  <input type="radio" name="paytype" value="2" <?php if($info['paytype']=='2') { ?>checked="checked"<?php } ?>
 />定金支付 &nbsp;
                                  <span id="dingjin" style="<?php if($info['paytype'] == '2') { ?>display:inline-block<?php } else { ?>display: none<?php } ?>
"><input type="text"  name="dingjin" id="dingjintxt" value="<?php echo $info['dingjin'];?>" size="8" onkeyup="(this.v=function(){this.value=this.value.replace(/[^0-9-\.]+/,'');}).call(this)" onblur="this.v();">&nbsp;元</span>
                                  <input type="radio" name="paytype" value="3"  <?php if($info['paytype']=='3') { ?>checked="checked"<?php } ?>
 />二次确认支付 &nbsp;
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
                      </dd>
                  </dl>
              </div>
              <div class="add-class">
                  <dl>
                      <dt>报价：</dt>
                      <dd> <div class="price_con">
                              <div class="price_menu">
                                  <a href="javascript:;" class="<?php if($info['lastoffer']['pricerule']=='all') { ?>on<?php } ?>
" data-val="all">所有日期</a>
                                  <a href="javascript:;" class="<?php if($info['lastoffer']['pricerule']=='week') { ?>on<?php } ?>
" data-val="week">按星期</a>
                                  <a href="javascript:;" class="<?php if($info['lastoffer']['pricerule']=='month') { ?>on<?php } ?>
" data-val="month">按号数</a>
                              </div>
                              <div class="price_sub">
                                  <div>
                                      <table class="price_tb">
                                          <tr>
                                              <td class="tit">日期范围：</td><td><input type="text" name="starttime"  value="<?php echo $info['lastoffer']['starttime'];?>" class="set-text-xh text_100 choosetime"/> <span class="fl">&nbsp;~&nbsp;</span> <input value="<?php echo $info['lastoffer']['endtime'];?>" type="text" class="set-text-xh text_100 choosetime" name="endtime"/></td>
                                          </tr>
                                          <tr>
                                              <td class="tit">适用人群：</td><td class="prop-group"><input type="checkbox" name="propgroup[]" value="2" id="adultgroup"/>成人&nbsp;&nbsp;&nbsp;<input type="checkbox" name="propgroup[]" value="1" id="childgroup">儿童&nbsp;&nbsp;&nbsp;<input type="checkbox" name="propgroup[]" value="3" id="oldgroup">老人
                                              </td>
                                          </tr>
                                          <tr>
                                              <td class="tit" valign="top">价格：</td><td>
                                                  <table class="group-tb">
                                                      <tbody>
                                                      <tr class="group_2" style="display:none">
                                                          <td width="80">成人价格：</td>
                                                          <td>
                                                              <span class="fl">成本</span>
                                                              <input type="text" class="set-text-xh text_60 mt-2 ml-10" name="adultbasicprice" onkeyup="calPrice(this)" value="<?php echo $info['lastoffer']['adultbasicprice'];?>" autocomplete="off">
                                                              <span class="fl ml-10">+利润</span>
                                                              <input type="text" class="set-text-xh text_60 mt-2 ml-10" name="adultprofit" onkeyup="calPrice(this)" value="<?php echo $info['lastoffer']['adultprofit'];?>" autocomplete="off">
                                                              <span class="fl ml-10">售价：<b style=" color:#f60" class="tprice"><?php echo $info['lastoffer']['adultprice'];?></b></span>
                                                          </td>
                                                      </tr>
                                                      <tr class="group_1" style="display:none">
                                                          <td width="80">儿童价格：</td>
                                                          <td>
                                                              <span class="fl">成本</span>
                                                              <input type="text" class="set-text-xh text_60 mt-2 ml-10" name="childbasicprice" onkeyup="calPrice(this)" value="<?php echo $info['lastoffer']['childbasicprice'];?>" autocomplete="off">
                                                              <span class="fl ml-10">+利润</span>
                                                              <input type="text" class="set-text-xh text_60 mt-2 ml-10" name="childprofit" onkeyup="calPrice(this)" value="<?php echo $info['lastoffer']['childprofit'];?>" autocomplete="off">
                                                              <span class="fl ml-10">售价：<b style=" color:#f60" class="tprice"><?php echo $info['lastoffer']['childprice'];?></b></span>
                                                          </td>
                                                      </tr>
                                                      <tr class="group_3" style="display:none">
                                                          <td width="80">老人价格：</td>
                                                          <td>
                                                              <span class="fl">成本</span>
                                                              <input type="text" class="set-text-xh text_60 mt-2 ml-10" name="oldbasicprice" autocomplete="off" onkeyup="calPrice(this)" value="<?php echo $info['lastoffer']['oldbasicprice'];?>">
                                                              <span class="fl ml-10">+利润</span>
                                                              <input type="text" class="set-text-xh text_60 mt-2 ml-10" name="oldprofit" autocomplete="off" onkeyup="calPrice(this)" value="<?php echo $info['lastoffer']['oldprofit'];?>">
                                                              <span class="fl ml-10">售价：<b style=" color:#f60" class="tprice"><?php echo $info['lastoffer']['oldprice'];?></b></span>
                                                          </td>
                                                      </tr>
                                                      </tbody></table>
                                              </td>
                                          </tr>
                                          <tr>
                                              <td class="tit">价格描述：</td><td><input type="text" class="set-text-xh text_700 mt-2" style="width: 300px" name="description"></td>
                                          </tr>
                                          <tr>
                                              <td class="tit">单房差：</td><td><input type="text" class="set-text-xh text_700 mt-2" style="width: 100px" name="roombalance"></td>
                                          </tr>
                                          <tr>
                                              <td class="tit">库存：</td><td><input type="text" class="set-text-xh text_100 mt-2" name="number" value="-1"> <span style="color:gray;padding-left:10px">-1表示不限</span></td>
                                          </tr>
                                      </table>
                                  </div>
                                  <div class="sub_item" <?php if($info['lastoffer']['pricerule']!='all') { ?>style="display:none"<?php } ?>
>
                                  </div>
                                  <div class="sub_item" <?php if($info['lastoffer']['pricerule']!='week') { ?>style="display:none"<?php } ?>
>
                                      <table class="price_tb">
                                          <tr>
                                              <td>星期选择：</td>
                                              <td><div class="price_week">
                                                      <table class="day_cs" id="week_cs" style="display: table;">
                                                          <tr height="30px"><td><a href="javascript:;" val="1">周一</a></td><td val="2"><a href="javascript:;" val="2">周二</a></td><td val="3"><a href="javascript:;" val="3">周三</a></td><td val="4"><a href="javascript:;" val="4">周四</a></td>
                                                              <td val="5"><a href="javascript:;" val="5">周五</a></td><td val="6"><a href="javascript:;" val="6">周六</a></td><td val="7"><a href="javascript:;" val="7">周日</a></td></tr>
                                                      </table>
                                                  </div>
                                              </td>
                                          </tr>
                                      </table>
                                  </div>
                                  <div class="sub_item" <?php if($info['lastoffer']['pricerule']!='month') { ?>style="display:none"<?php } ?>
>
                                      <table class="price_tb">
                                          <tr>
                                              <td valign="top">日期选择：</td><td>
                                              <table class="day_cs" id="month_cs">
                                                  <tr><td><a href="javascript:;">1</a></td><td><a href="javascript:;">2</a></td><td><a href="javascript:;">3</a></td><td><a href="javascript:;">4</a></td><td><a href="javascript:;">5</a></td>
                                                      <td><a href="javascript:;">6</a></td><td><a href="javascript:;">7</a></td><td><a href="javascript:;">8</a></td><td><a href="javascript:;">9</a></td><td><a href="javascript:;">10</a></td></tr>
                                                  <tr><td><a href="javascript:;">11</a></td><td><a href="javascript:;">12</a></td><td><a href="javascript:;">13</a></td><td><a href="javascript:;">14</a></td>
                                                      <td><a href="javascript:;">15</a></td><td><a href="javascript:;">16</a></td><td><a href="javascript:;">17</a></td><td><a href="javascript:;">18</a></td>
                                                      <td><a href="javascript:;">19</a></td><td><a href="javascript:;">20</a></td></tr>
                                                  <tr><td><a href="javascript:;">21</a></td><td><a href="javascript:;">22</a></td><td><a href="javascript:;">23</a></td><td><a href="javascript:;">24</a></td>
                                                      <td><a href="javascript:;">25</a></td><td><a href="javascript:;">26</a></td><td><a href="javascript:;">27</a></td><td><a href="javascript:;">28</a></td>
                                                      <td><a href="javascript:;">29</a></td><td><a href="javascript:;">30</a></td></tr>
                                                  <tr><td><a href="javascript:;">31</a></td><td colspan="9"></td></tr>
                                                  </table>
                                          </td>
                                          </tr>
                                          </table>
                                  </div>
                              </div>
                          </div>
                      </dd>
                  </dl>
              </div>
              </div>
              <!--/基础信息结束-->
                  <div class="opn-btn" style="padding-left: 10px; " id="hidevalue">
                      <input type="hidden" name="pricerule" id="pricerule" value="<?php echo $info['lastoffer']['pricerule'];?>"/>
                      <input type="hidden" name="action" id="action" value="<?php echo $action;?>"/>
                      <input type="hidden" name="lineid" id="lineid" value="<?php echo $lineinfo['id'];?>">
                      <a class="normal-btn" id="btn_save" href="javascript:;">保存</a>
                      <a class="normal-btn" id="btn_view_more" style="<?php if($action=='add') { ?>display:none<?php } ?>
"   href="javascript:;" onclick="showMore()">查看报价</a>
                  </div>
          </div>
        </form>
</div>
<script>
$(document).ready(function(){
        var action = "<?php echo $action;?>";
        var group = "<?php echo $info['propgroup'];?>";
        var groupArr = group.split(',');
        $(".price_menu a").click(function(){
              var index=$(".price_menu a").index(this);
              var pricerule=$(this).attr("data-val");
              $("#pricerule").val(pricerule);
              $(this).siblings().removeClass('on');
              $(this).addClass('on');
              $(".price_sub .sub_item:eq("+index+")").show().siblings(".sub_item").hide();
        });
        if($.inArray('1',groupArr)!=-1){
            $('.group_1').show();
            $('#childgroup').attr('checked','checked');
        }
        if($.inArray('2',groupArr)!=-1){
            $('.group_2').show();
            $('#adultgroup').attr('checked','checked');
        }
        if($.inArray('3',groupArr)!=-1){
            $('.group_3').show();
            $('#oldgroup').attr('checked','checked');
        }
        //保存
        $("#btn_save").click(function(){
                var suitname = $("#suitname").val();
                if(suitname==''){
                    ST.Util.showMsg('请输入套餐名称',5,1000);
                    return false;
                }
                $.ajax({
                    type:'POST',
                    url   :  SITEURL+"index/ajax_suitsave",
                    data:$('#product_frm').serialize(),
                    dataType  :  "json",
                    success  :  function(data, opts)
                    {
                        if(data.status)
                        {
                            if(data.id!=null){
                                $("#suitid").val(data.id);
                                $("#btn_view_more").show();
                            }
                            ST.Util.showMsg('保存成功!','4',2000);
                        }
                   }});
        })
        //如果是修改页面
        //日历选择
        $(".choosetime").click(function(){
            WdatePicker({skin:'whyGreen',dateFmt:'yyyy-MM-dd',minDate:'%y-%M-%d'})
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
        $(".prop-group input:checkbox").click(
            function(e)
            {
$(".group-tb tr").hide();
                $(".prop-group input:checked").each(function(index, element) {
                      var gp=$(element).val();
  $(".group_"+gp).show();
                });
            }
        );
     });
    //查看日历报价
    function showMore()
    {
        var suitid = $("#suitid").val();
        var productid = $("#lineid").val();
        var width = $(window).width()-100;
        var height = $(window).height()-100
       // var url = "calendar.php?suitid="+suitid+"&carid="+carid;
        var url = SITEURL+'calendar/index/suitid/'+suitid+'/typeid/1/productid/'+productid;
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