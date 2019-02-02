<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>套餐添加/修改</title>
    <?php echo  Stourweb_View::template('stourtravel/public/public_js');  ?>
    <?php echo Common::getCss('style.css,base.css,base2.css,base_new.css'); ?>
    <?php echo Common::getScript("uploadify/jquery.uploadify.min.js,DatePicker/WdatePicker.js,product_add.js,imageup.js,jquery.validate.js"); ?>
    <?php echo Common::getCss('uploadify.css','js/uploadify/'); ?>
    <style>
        .date-list .price-td{
            padding: 0px 5px;
        }
        .date-list .price-td label{
            color:red;
        }
        .date-list .price-td .price-del-btn{
            padding: 2px 5px;
            border-radius:3px;
            border:1px solid #dfdfdf;
        }
    </style>
</head>
<body>
<table class="content-tab">
    <tr>
    <td width="119px" class="content-lt-td"  valign="top">
     <?php echo  Stourweb_View::template('stourtravel/public/leftnav');  ?>
    <!--右侧内容区-->
    </td>
     <td valign="top" class="content-rt-td">
          <form method="post" name="product_frm" id="product_frm" autocomplete="off" head_ul=SmACXC >
          
          <div class="cfg-header-bar">
<a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
</div>
            <!--基础信息开始-->
            <div class="product-add-div">
            <ul class="info-item-block">
            <li>
            <span class="item-hd">当前邮轮线路：</span>
            <div class="item-bd">
            <span class="item-text"><?php echo $lineinfo['title'];?></span> 
            </div>
            </li>
            <li>
            <span class="item-hd">舱房名称：</span>
            <div class="item-bd">
            <span class="item-text"><?php echo $roominfo['title'];?></span>
            </div>
            </li>
            <li>
            <span class="item-hd">舱房类别：</span>
            <div class="item-bd">
            <span class="item-text"><?php echo $roominfo['kindname'];?></span>
            </div>
            </li>
            <li>
            <span class="item-hd">舱房面积：</span>
            <div class="item-bd">
            <span class="item-text"><?php echo $roominfo['area'];?> m<sup>2</sup></span>
            </div>
            </li>
            <li>
            <span class="item-hd">可住人数：</span>
            <div class="item-bd">
            <span class="item-text"><?php echo $roominfo['peoplenum'];?> 人</span>
            </div>
            </li>
            <li>
            <span class="item-hd">房间数：</span>
            <div class="item-bd">
            <span class="item-text"><?php echo $roominfo['num'];?> 间</span>
            </div>
            </li>
            <li>
            <span class="item-hd">舱房窗型：</span>
            <div class="item-bd">
            <span class="item-text"><?php if($roominfo['iswindow']==1) { ?>有窗<?php } else { ?>无窗<?php } ?>
</span>
            </div>
            </li>
            <li>
            <span class="item-hd">所在楼层：</span>
            <div class="item-bd">
            <span class="item-text"><?php echo $roominfo['floornames'];?></span>
            </div>
            </li>
            <li>
            <span class="item-hd">设施描述：</span>
            <div class="item-bd">
            <span class="item-text"><?php echo $roominfo['content'];?></span>
            </div>
            </li>
            <li>
            <span class="item-hd">舱房图片：</span>
            <div class="item-bd">
            <div class="up-list-div">
                              <ul>
                                  <?php $n=1; if(is_array($roominfo['piclist_arr'])) { foreach($roominfo['piclist_arr'] as $pic) { ?>
                                  <li class="img-li">
                                      <img class="fl" src="<?php echo $pic['litpic'];?>" width="100" height="100">
                                      <p class="p1">
                                          <?php echo $pic['desc'];?>

                                      </p>
                                      <p class="p2">
                                      </p>
                                  </li>
                                  <?php $n++;}unset($n); } ?>
                              </ul>
                          </div>
            </div>
            </li>
            </ul>  
              <div class="line"></div>
              <ul class="info-item-block">
              <li>
              <span class="item-hd">支付方式：</span>
              <div class="item-bd">
              <div class="on-off">
                                <span class="item-text">全款支付</span>
                                <input type="hidden" name="paytype" value="1"/>
                                  <!--  <input type="radio" name="paytype" value="1" <?php if($info['paytype']=='1') { ?>checked="checked"<?php } ?>
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
                                   </script> -->
                              </div>
              </div>
              </li>
              <li>
              <span class="item-hd">航次日期：</span>
              <div class="item-bd">
              <div class="lh-30"><?php if($scheduleinfo['title']) { ?>已选择行程天数【<?php echo $scheduleinfo['title'];?>】，请在下面选择行程天数下需要报价的航次日期进行报价<?php } else { ?>你还未选择行程天数，暂时不能报价<?php } ?>
</div>
                          <?php if(!empty($scheduleinfo['id'])) { ?>
                          <div>
                              <div><label class="check-label"><input type="checkbox" value="1" id="date_all_btn"/>全选</label></div>
                              <div>
                                  <table class="date-list">
                                  <?php $n=1; if(is_array($datelist)) { foreach($datelist as $date) { ?>
                                      <tr id="date_<?php echo $date['id'];?>">
                                          <td><label class="check-label"><input type="checkbox" class="date-item" name="date[]" value="<?php echo $date['id'];?>" <?php if(in_array($date['id'],$info['lastoffer']['dates'])) { ?>checked="checked"<?php } ?>
/><?php echo date('Y.m.d',$date['starttime']);?>-<?php echo date('Y.m.d',$date['endtime']);?></label></td>
                                          <td class="price-td"><?php if(!empty($date['dateid'])) { ?>市场价：<label><?php echo $date['storeprice'];?></label>  成本：<label><?php echo $date['basicprice'];?></label>  利润：<label><?php echo $date['profit'];?></label>  优惠价：<label><?php echo $date['price'];?></label>   库存：<label><?php echo $date['number'];?></label> <a href="javascript:;" class="btn-link" onclick="del_price(<?php echo $info['id'];?>,<?php echo $date['id'];?>)">清除报价</a> <?php } ?>
</td>
                                      </tr>
                                  <?php $n++;}unset($n); } ?>
                                  </table>
                              </div>
                          </div>
                         <?php } ?>
              </div>
              </li>
               <?php if(!empty($scheduleinfo['id'])) { ?>
              <li>
              <span class="item-hd">市场价：</span>
              <div class="item-bd">
              <input type="text" name="storeprice" id="storeprice" class="input-text w100" value="<?php echo $info['lastoffer']['storeprice'];?>"  /><span class="item-text ml-10">元/间</span>
              </div>
              </li>
              <li>
              <span class="item-hd">优惠价：</span>
              <div class="item-bd">
              <span class="item-text mr-5">成本：</span><input type="text" name="basicprice" id="basicprice"  class="input-text w100 mr-20" value="<?php echo $info['lastoffer']['basicprice'];?>"/>
                          <span class="item-text mr-5">+利润</span><input type="text" name="profit" id="profit" class="input-text w100" value="<?php echo $info['lastoffer']['profit'];?>"/>
                          <span class="item-text" id="total_price">=<i style="color:red"></i>元/间</span>
              </div>
              </li>
              <li>
              <span class="item-hd">库存：</span>
              <div class="item-bd">
              <input type="text" name="number" id="number" class="input-text w100" value="<?php echo $info['lastoffer']['number'];?>"  />
              </div>
              </li>
              <?php } ?>
              </ul>
              
              <div class="clear clearfix pd-20" id="hidevalue">
                 <input type="hidden" name="pricerule" id="pricerule" value="<?php echo $info['lastoffer']['pricerule'];?>"/>
                   <input type="hidden" name="action" id="action" value="<?php echo $action;?>"/>
                   <input type="hidden" name="lineid" id="lineid" value="<?php echo $lineinfo['id'];?>">
                   <input type="hidden" name="suitid" id="suitid" value="<?php echo $info['id'];?>">
                   <input type="hidden" name="scheduleid" value="<?php echo $lineinfo['scheduleid'];?>"/>
            <a class="btn btn-primary radius size-L ml-10" href="javascript:;" id="btn_save" >保存</a>
        </div>     
        </form>
    </td>
    </tr>
    </table>
<script>
        $(document).ready(function(){
            $("#date_all_btn").click(function(){
                 if($(this).is(":checked"))
                 {
                     $(".date-item").attr('checked',true);
                 }
                 else
                 {
                     $(".date-item").attr('checked',false);
                 }
            });
            cal_price();
            $("#basicprice,#profit").change(function(){
                cal_price();
            });
            //保存
            $("#btn_save").click(function(){
                Ext.Ajax.request({
                    url   :  SITEURL+"ship/admin/shipline/ajax_suit_save",
                    method  :  "POST",
                    isUpload :  true,
                    form  : "product_frm",
                    success  :  function(response, opts)
                    {
                        //console.log(response);
                        var data = $.parseJSON(response.responseText);
                        if(data.status)
                        {
                            ST.Util.showMsg('保存成功!','4',2000);
                            setTimeout(function(){
                                window.location.reload();
                            },2000);
                        }
                    }});
            })
});
function cal_price()
{
    var basicprice = parseInt($("#basicprice").val());
    basicprice=!basicprice?0:basicprice;
    var profit = parseInt($("#profit").val());
    profit = !profit?0:profit;
    var totalPrice = basicprice+profit;
    $("#total_price i").text(totalPrice);
}
//查看日历报价
function showMore()
{
    var suitid = $("#suitid").val();
    var productid = $("#lineid").val();
    var width = $(window).width()-100;
    var height = $(window).height()-100
    // var url = "calendar.php?suitid="+suitid+"&carid="+carid;
    var url = SITEURL+'calendar/index/suitid/'+suitid+'/typeid/104/productid/'+productid;
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
function del_price(suitid,dateid)
{
    $.ajax({
        type: 'POST',
        url: SITEURL+"ship/admin/shipline/ajax_suit_pricedel" ,
        dataType: 'json',
        data: {suitid:suitid,dateid:dateid},
        success: function(result)
        {
            if(result.status)
            {
                ST.Util.showMsg('保存成功!','4',2000);
                $("#date_"+dateid+' .price-td').html('');
            }
        }
    });
}
</script>
</body>
</html>
