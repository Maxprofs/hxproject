<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>酒店房型添加/修改</title>
    {template 'stourtravel/public/public_min_js'}
    {php echo Common::getCss('style.css,base.css,base2.css,base_new.css'); }
    {php echo Common::getScript("uploadify/jquery.uploadify.min.js,DatePicker/WdatePicker.js,product_add.js,imageup.js,jquery.validate.js"); }
    {php echo Common::getCss('uploadify.css','js/uploadify/'); }
</head>

<body>
	<table class="content-tab" margin_padding=cAOzDt >
    	<tr>
    		<td width="119px" class="content-lt-td"  valign="top">
    		{template 'stourtravel/public/leftnav'}
    		<!--右侧内容区-->
    		</td>
     		<td valign="top" class="content-rt-td">
          		<form method="post" name="product_frm" id="product_frm" autocomplete="off">
          			<div class="manage-nr">
              			<div class="cfg-header-bar" id="nav">
                  			<a href="javascript:;" class="fr btn btn-primary radius mr-10 mt-6" onclick="window.location.reload()">刷新</a>
              			</div>

               			<!--基础信息开始-->
              			<div class="product-add-div pb-20">
              				<ul class="info-item-block">
              					<li>
              						<span class="item-hd">当前酒店：</span>
              						<div class="item-bd">
              							<span class="item-text">{$hotelname}</span>
              						</div>
              					</li>
              					<li>
              						<span class="item-hd">房型名称：</span>
              						<div class="item-bd">
              							<input type="text" name="roomname" id="roomname" class="input-text w700" value="{$info['roomname']}" />
              						</div>
              					</li>
              					<li>
              						<span class="item-hd">房型说明：</span>
              						<div class="item-bd">
              							{php Common::getEditor('content',$info['description'],$sysconfig['cfg_admin_htmleditor_width'],120,'suit');}
              						</div>
              					</li>
              					<li>
              						<span class="item-hd">门市价：</span>
              						<div class="item-bd">
              							<input type="text" name="sellprice" id="sellprice" class="input-text w100" value="{$info['sellprice']}" />
                          				<span class="item-text">元</span>
              						</div>
              					</li>
              					<li>
              						<span class="item-hd">房间面积：</span>
              						<div class="item-bd">
              							<input type="text" name="roomarea" id="roomarea" class="input-text w100" value="{$info['roomarea']}" />
                          				<span class="item-text">㎡</span>
              						</div>
              					</li>
              					<li>
              						<span class="item-hd">房间楼层：</span>
              						<div class="item-bd">
              							<input type="text" name="roomfloor" id="roomfloor" class="input-text w100" value="{$info['roomfloor']}" />
                          				<span class="item-text">层</span>
              						</div>
              					</li>
              					<li>
              						<span class="item-hd">房间数：</span>
              						<div class="item-bd">
              							<input type="text" name="roomnum" id="roomnum" class="input-text w100" value="{$info['number']}" />
                          				<span class="item-text">间</span>
              						</div>
              					</li>
              					<li>
              						<span class="item-hd">床型：</span>
              						<div class="item-bd">
              							<form class="fl">
                              				<div class="on-off lh-30">
                                  				{loop $roomtype $room}
                                   				<label class="radio-label mr-20" for="R_BedCategory_{$n}"><input id="R_BedCategory_{$n}" type="radio" name="roomstyle" value="{$room}" {if $info['roomstyle']==$room}checked="checked"{/if}/>{$room}</label>
                                  				{/loop}
                                  				<input  type="radio" name="roomstyle" id="user_room_v" value="{if !in_array($info['roomstyle'],$roomtype) && !empty($info['roomstyle'])}{$info['roomstyle']}{/if}"  {if !in_array($info['roomstyle'],$roomtype) && !empty($info['roomstyle'])} checked="checked"{/if}/>
                                  				<label class="radio-label mr-20" for="user_room_v">
                                  					<input type="text" class="uservalue" data-value="user_room_v" style="width:70px;border-left:none;border-right:none;border-top:none"  value="{if !in_array($info['roomstyle'],$roomtype) && !empty($info['roomstyle'])}{$info['roomstyle']}{/if}">                      						
                                  				</label>
												<script>
												    $(function(){
											            $('.uservalue').bind('input propertychange', function() {
									                       var datacontain = $(this).attr('data-value');
									                       $('#'+datacontain).val($(this).val());
											            });
												    })
												</script>
											</div>
										</form>
              						</div>
              					</li>
              					<li>
              						<span class="item-hd">窗户：</span>
              						<div class="item-bd">
              							<div class="on-off lh-30">
                                  			{loop $windowtype $window}
                                  			<label class="radio-label mr-20" for="roomwindow_{$n}"><input id="roomwindow_{$n}" type="radio" name="roomwindow" value="{$window}"  {if $info['roomwindow']==$window}checked="checked"{/if}/>{$window}</label>
                                  			{/loop}
                                  			<input  type="radio" name="roomwindow" id="user_window_v" value="{if !in_array($info['roomwindow'],$windowtype) && !empty($info['roomwindow'])}{$info['roomwindow']}{/if}"  {if !in_array($info['roomwindow'],$windowtype) && !empty($info['roomwindow'])} checked="checked"{/if}/>
                                  			<label class="radio-label mr-20" for="user_roomwindow_v"><input type="text" class="uservalue" data-value="user_window_v" style="width:70px;border-left:none;border-right:none;border-top:none"  value="{if !in_array($info['roomwindow'],$windowtype) && !empty($info['roomwindow'])} {$info['roomwindow']}{/if}"></label>
                                 		</div>
              						</div>
              					</li>
              					<li>
              						<span class="item-hd">餐标：</span>
              						<div class="item-bd">
              							<div class="on-off">
		                                  	{loop $repasttype $repast}
		                                  	<label class="radio-label mr-20" for="b{$n}"><input type="radio" name="breakfirst" id="b{$n}"  value="{$repast}" {if $info['breakfirst']==$repast}checked="checked"{/if}/>{$repast}</label>
		                                  	{/loop}
		                                  	<input  type="radio" name="breakfirst" id="user_repast_v" value="{if !in_array($info['breakfirst'],$repasttype) && !empty($info['breakfirst'])}{$info['breakfirst']}{/if}"  {if !in_array($info['breakfirst'],$repasttype) && !empty($info['breakfirst'])} checked="checked"{/if}/>
		                                  	<label class="radio-label mr-20" for="user_repast_v"><input type="text" class="uservalue" data-value="user_repast_v" style="width:70px;border-left:none;border-right:none;border-top:none"  value="{if !in_array($info['breakfirst'],$repasttype) && !empty($info['breakfirst'])} {$info['breakfirst']}{/if}"></label>
	                              		</div>
              						</div>
              					</li>
              					<li>
              						<span class="item-hd">宽带：</span>
              						<div class="item-bd">
              							<div class="on-off lh-30">
		                                	{loop $computertype $computer}
		                                   	<label class="radio-label mr-20" for="c{$n}"><input name="computer" type="radio" value="{$computer}" id="c{$n}" {if $info['computer']==$computer}checked="checked"{/if}/>{$computer}</label>
		                                  	{/loop}
		                                  	<input  type="radio" name="computer" id="user_computer_v" value="{if !in_array($info['computer'],$computertype) && !empty($info['computer'])}{$info['computer']}{/if}"  {if !in_array($info['computer'],$computertype) && !empty($info['computer'])} checked="checked"{/if}/>
		                                  	<label class="radio-label mr-20" for="user_computer_v"><input type="text" class="uservalue" data-value="user_computer_v" style="width:70px;border-left:none;border-right:none;border-top:none"  value="{if !in_array($info['computer'],$computertype) && !empty($info['computer'])} {$info['computer']}{/if}"></label>
		                              </div>
              						</div>
              					</li>
              					<li>
              						<span class="item-hd">房型图片：</span>
              						<div class="item-bd">
              							<div id="pic_btn" class="btn btn-primary radius size-S mt-4">上传图片</div>
              							<div class="clear"></div>
              							<div class="up-list-div" >
			                                <ul class="pic-sel">
												
			                                </ul>
		                             	</div>
              						</div>
              					</li>
              					<li>
              						<span class="item-hd">支付方式：</span>
              						<div class="item-bd">
              							<div class="on-off">
                                  			<label class="radio-label mr-20"><input type="radio" name="paytype" value="1" {if $info['paytype']=='1'}checked="checked"{/if} />全款支付</label>
                                  			<label class="radio-label mr-20"><input type="radio" name="paytype" value="2" {if $info['paytype']=='2'}checked="checked"{/if} />定金支付</label>
                                  			<span class="mr-10" id="dingjin" style="{if $info['paytype'] == '2'}display:inline-block{else}display: none{/if}"><input type="text" class="input-text w50"  name="dingjin" id="dingjintxt" value="{$info['dingjin']}" size="8" onkeyup="(this.v=function(){this.value=this.value.replace(/[^0-9-\.]+/,'');}).call(this)" onblur="this.v();">&nbsp;元</span>
                                  			<label class="radio-label mr-20"><input type="radio" name="paytype" value="3"  {if $info['paytype']=='3'}checked="checked"{/if} />二次确认支付</label>
                                  			<label class="radio-label mr-20"><input type="radio" name="paytype" value="4"  {if $info['paytype']=='4'}checked="checked"{/if} />线下支付</label>
                                  			<script>
                                      			$("input[name='paytype']").click(function(){
                                          			if($(this).val() == 2){
                                              			$("#dingjin").show();
                                          			}else{
                                              			$("#dingjin").hide()
                                          			}
                                      			});
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
                                              				<td class="tit text-r">日期范围：</td><td><input type="text" name="starttime" class="input-text w100 choosetime" value="{$info['lastoffer']['starttime']}"/> <span class="item-text">&nbsp;~&nbsp;</span> <input type="text" class="input-text w100 choosetime" name="endtime" value="{$info['lastoffer']['endtime']}"/></td>
                                          				</tr>
                                          				<tr>
                                              				<td class="tit text-r">价格：</td>
                                              				<td>
                                                  				<table class="table">
	                                                      			<tr class="group_2">
	                                                          			<td>
	                                                              			<span class="item-text">成本</span>
	                                                              			<input type="text" class="input-text w60 ml-10" name="basicprice" onkeyup="calPrice(this)" value="{$info['lastoffer']['basicprice']}" autocomplete="off">
	                                                              			<span class="item-text">+利润</span>
	                                                              			<input type="text" class="input-text w60  ml-10" name="profit" onkeyup="calPrice(this)" value="{$info['lastoffer']['profit']}" autocomplete="off">
	                                                              			<span class="item-text ml-10">售价：<b style=" color:#f60" class="tprice">{$info['lastoffer']['price']}</b></span>
	                                                          			</td>
	                                                      			</tr>
                                                 				</table>
                                              				</td>
                                          				</tr>
                                          				<tr>
                                              				<td class="tit text-r">价格描述：</td>
                                              				<td>
                                              					<input type="text" class="input-text w300 fl" name="description" value="{$info['lastoffer']['description']}">                                           						
                                              					</td>
                                          				</tr>
                                          				<tr>
                                              				<td class="tit text-r">库存：</td>
                                              				<td><input type="text" class="input-text w100 fl" name="number" maxlength="4" value="{$info['lastoffer']['number']}"> <span class="fl lh-30 c-999 pl-10">-1表示不限</span></td>
                                          				</tr>
                                      				</table>
                                  				</div>
                                  				<div class="sub_item" {if $info['lastoffer']['pricerule']!='all'}style="display:none"{/if}></div>
                                  				<div class="sub_item" {if $info['lastoffer']['pricerule']!='week'}style="display:none"{/if}>
                                      				<table class="price_tb" >
                                          				<tr>
                                              				<td class="text-r">星期选择：</td>
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
                                              				<td align="right" valign="top">日期选择：</td>
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
                              				</div>
                          				</div>
              						</div>
              					</li>
              				</ul>
              				<div class="line"></div>	
              			</div>
              			<!--/基础信息结束-->
						
						<div class="clear pb-20" id="hidevalue">
							<input type="hidden" name="roomid" id="roomid" value="{$info['id']}"/>
	                      	<input type="hidden" name="action" id="action" value="{$action}"/>
	                      	<input type="hidden" name="hotelid" id="hotelid" value="{$hotelid}">
	                      	<input type="hidden" name="pricerule" id="pricerule" value="{$info['lastoffer']['pricerule']}"/>
	                      	<a class="btn btn-primary radius size-L ml-115" id="btn_save" href="javascript:;">保存</a>
	                      	<a class="btn btn-primary radius size-L ml-10" id="btn_view_more" style="{if $action=='add'}display:none{/if}"  href="javascript:;" onclick="showMore()">查看报价</a>
						</div>	
          			</div>
        		</form>
    		</td>
    	</tr>
    </table>

	<script>

	$(document).ready(function(){
        $(".price_menu a").click(function(){
            var index=$(".price_menu a").index(this);
            var pricerule=$(this).attr("data-val");
            $("#pricerule").val(pricerule);
            $(this).siblings().removeClass('on');
            $(this).addClass('on');
            $(".price_sub .sub_item:eq("+index+")").show().siblings(".sub_item").hide();
        });


        var action = "{$action}";


        $('#pic_btn').click(function(){
            ST.Util.showBox('上传图片', SITEURL + 'image/insert_view', 0,0, null, null, document, {loadWindow: window, loadCallback: Insert});
            function Insert(result,bool){
                var len=result.data.length;
                for(var i=0;i<len;i++){
                    var temp =result.data[i].split('$$');

                    Imageup.genePic(temp[0],".up-list-div ul",".cover-div",temp[1]);


                }
            }
        });


        //保存
        $("#btn_save").click(function(){
                var roomname = $("#roomname").val();
                if(roomname==''){
                    ST.Util.showMsg('请输入房间名称',5,1000);
                    return false;
                }

                   $.ajaxform({
                       url   :  SITEURL+"hotel/admin/hotel/ajax_room_save",
                       method  :  "POST",
                       form  : "#product_frm",
                       dataType: 'json',
                       success  :  function(data)
                       {
                           if(data.status)
                           {
                               if(data.roomid!=null){
                                   $("#roomid").val(data.roomid);
                               }
                               ST.Util.showMsg('保存成功!','4',2000);
                               $("#btn_view_more").show();
                           }
                       }});
        })


        //如果是修改页面
        if(action=='edit')
        {

            {if $action=='edit'}
                var piclist = ST.Modify.getUploadFile({$info['piclist_arr']},0);
                $(".pic-sel").html(piclist);
                window.image_index= $(".pic-sel").find('li').length;//已添加的图片数量


            {/if}


        }



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
        var suitid = $("#roomid").val();
        var productid = $("#hotelid").val();

        var width = $(window).width()-100;
        var height = $(window).height()-100
       // var url = "calendar.php?suitid="+suitid+"&carid="+carid;
        var url = SITEURL+'hotel/admin/calendar/index/suitid/'+suitid+'/productid/'+productid;
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
