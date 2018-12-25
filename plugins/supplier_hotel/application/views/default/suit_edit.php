<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>酒店管理-{$webname}</title>
    {Common::css("style.css,base.css,style_hotel.css,base_hotel.css")}
    {Common::js("jquery.min.js,common.js,product.js,choose.js,imageup.js")}
    {include "pub/public_js"}
    <script type="text/javascript"src="/tools/js/DatePicker/WdatePicker.js"></script>

</head>
<body right_color=AQLrzm >

<div class="page-box">

{request "pub/header"}

{request "pub/sidemenu"}


<div class="main">
<div class="content-box">

<div class="frame-box">

<div class="pt-manage-box">
<form method="post" name="product_frm" id="product_frm" autocomplete="off">
<div class="manage-nr">

    <div class="w-set-tit bom-arrow" id="nav">
        <span class="on">{$position}</span>
        <a href="javascript:;" class="refresh-btn" onclick="window.location.reload()">刷新</a>
    </div>

<!--基础信息开始-->
    <div class="product-add-div">
        <div class="add-class">
            <dl>
                <dt>当前酒店：</dt>
                <dd>
                   {$hotelname}
                </dd>
            </dl>
            <dl>
                <dt>房型名称：</dt>
                <dd>
                    <input type="text" name="roomname" id="roomname" class="set-text-xh text_700 mt-2" value="{$info['roomname']}"/>
                </dd>
            </dl>
            <dl>
                <dt>房型说明：</dt>
                <dd style="height: 200px;line-height: 20px">

                    {php Common::get_editor('description',$info['description'],700,120,'Line');}
                </dd>
            </dl>
            <dl>
                <dt>门市价：</dt>
                <dd>
                    <input type="text" name="sellprice" id="sellprice" class="set-text-xh text_100 mt-2" value="{$info['sellprice']}"/>
                    <span class="fl ml-5">元</span>
                </dd>
            </dl>
            <dl>
                <dt>优惠价：</dt>
                <dd>
                    <input type="text" name="price" id="price" class="set-text-xh text_100 mt-2" value="{$info['price']}"/>
                    <span class="fl ml-5">元</span>
                </dd>
            </dl>
            <dl>
                <dt>房间面积：</dt>
                <dd>
                    <input type="text" name="roomarea" id="roomarea" class="set-text-xh text_100 mt-2" value="{$info['roomarea']}"/>
                    <span class="fl ml-5">㎡</span>
                </dd>
            </dl>
            <dl>
                <dt>房间楼层：</dt>
                <dd>
                    <input type="text" name="roomfloor" id="roomfloor" class="set-text-xh text_100 mt-2" value="{$info['roomfloor']}"/>
                    <span class="fl ml-5">层</span>
                </dd>
            </dl>
            <dl>
                <dt>房间数：</dt>
                <dd>
                    <input type="text" name="roomnum" id="roomnum" class="set-text-xh text_100 mt-2" value="{$info['number']}"/>
                    <span class="fl ml-5">间</span>
                </dd>
            </dl>
            <dl>
                <dt>床型：</dt>
                <dd>

                    <div class="on-off">
                        {loop $roomtype $room}
                        <input id="R_BedCategory_{$n}" type="radio" name="roomstyle" value="{$room}" {if $info['roomstyle']==$room}checked="checked"{/if}/>
                        <label for="R_BedCategory_{$n}">{$room}</label>
                        {/loop}

                        <input type="radio" name="roomstyle" id="user_room_v" value="{if !in_array($info['roomstyle'],$roomtype) && !empty($info['roomstyle'])}{$info['roomstyle']}{/if}" {if !in_array($info['roomstyle'],$roomtype) && !empty($info['roomstyle'])} checked="checked"{/if}/>
                        <label for="user_room_v"><input type="text" class="uservalue" data-value="user_room_v" style="width:70px;border-left:none;border-right:none;border-top:none" value="{if !in_array($info['roomstyle'],$roomtype) && !empty($info['roomstyle'])}{$info['roomstyle']}{/if}"></label>


                        <script>
                            $(function () {

                                $('.uservalue').bind('input propertychange', function () {
                                    var datacontain = $(this).attr('data-value');
                                    $('#' + datacontain).val($(this).val());
                                });

                            })
                        </script>


                    </div>

                </dd>
            </dl>
            <dl>
                <dt>窗户：</dt>
                <dd>

                    <div class="on-off">
                        {loop $windowtype $window}
                            <input id="roomwindow_{$n}" type="radio" name="roomwindow" value="{$window}" {if $info['roomwindow']==$window}checked="checked"{/if}/>
                            <label for="roomwindow_{$n}">{$window}</label>
                        {/loop}
                        <input type="radio" name="roomwindow" id="user_window_v" value="{if !in_array($info['roomwindow'],$windowtype) && !empty($info['roomwindow'])}{$info['roomwindow']}{/if}" {if !in_array($info['roomwindow'],$windowtype) && !empty($info['roomwindow'])} checked="checked"{/if}/>
                        <label for="user_roomwindow_v"><input type="text" class="uservalue" data-value="user_window_v" style="width:70px;border-left:none;border-right:none;border-top:none"
                                                              value="{if !in_array($info['roomwindow'],$windowtype) && !empty($info['roomwindow'])} {$info['roomwindow']}{/if}"></label>


                    </div>

                </dd>
            </dl>
            <dl>
                <dt>餐标：</dt>
                <dd>

                    <div class="on-off">
                        {loop $repasttype $repast}
                        <input type="radio" name="breakfirst" id="b{$n}" value="{$repast}" {if $info['breakfirst']==$repast}checked="checked"{/if}/>
                        <label for="b{$n}">{$repast}</label>
                        {/loop}
                        <input type="radio" name="breakfirst" id="user_repast_v" value="{if !in_array($info['breakfirst'],$repasttype) && !empty($info['breakfirst'])}{$info['breakfirst']}{/if}" {if !in_array($info['breakfirst'],$repasttype) && !empty($info['breakfirst'])} checked="checked"{/if}/>
                        <label for="user_repast_v"><input type="text" class="uservalue" data-value="user_repast_v" style="width:70px;border-left:none;border-right:none;border-top:none" value="{if !in_array($info['breakfirst'],$repasttype) && !empty($info['breakfirst'])} {$info['breakfirst']}{/if}"></label>


                    </div>

                </dd>
            </dl>
            <dl>
                <dt>宽带：</dt>
                <dd>

                    <div class="on-off">
                        {loop $computertype $computer}
                        <input name="computer" type="radio" value="{$computer}" id="c{$n}" {if $info['computer']==$computer}checked="checked"{/if}/>
                        <label for="c{$n}">{$computer}</label>
                        {/loop}
                        <input type="radio" name="computer" id="user_computer_v" value="{if !in_array($info['computer'],$computertype) && !empty($info['computer'])}{$info['computer']}{/if}" {if !in_array($info['computer'],$computertype) && !empty($info['computer'])} checked="checked"{/if}/>
                        <label for="user_computer_v"><input type="text" class="uservalue" data-value="user_computer_v" style="width:70px;border-left:none;border-right:none;border-top:none" value="{if !in_array($info['computer'],$computertype) && !empty($info['computer'])} {$info['computer']}{/if}"></label>


                    </div>

                </dd>
            </dl>
            <dl>
                <dt>房型图片：</dt>
                <dd style="height: auto">
                    <div class="">
                        <div class="up-file-div" style="height:30px;">
                            <div id="pic_btn" class="btn-file mt-4">上传图片</div>
                        </div>
                        <div class="up-file-div" style="width: 180px;">
                            <div class="" style="float: left;color: #999;">建议上传尺寸1024*695px</div>
                        </div>
                        <div class="up-list-div">

                            <ul class="pic-sel">

                            </ul>
                        </div>
                    </div>
                </dd>
            </dl>
        </div>

        <div class="add-class">
<!--            <dl>-->
<!--                <dt>预订送积分：</dt>-->
<!--                <dd>-->
<!--                    <input type="text" name="jifenbook" id="jifenbook" class="set-text-xh text_100 mt-2" value="{$info['jifenbook']}"/>-->
<!--                    <span class="fl ml-5">分</span>-->
<!--                </dd>-->
<!--            </dl>-->
<!--            <dl>-->
<!--                <dt>积分抵现金：</dt>-->
<!--                <dd>-->
<!--                    <input type="text" name="jifentprice" id="jifentprice" value="{$info['jifentprice']}" class="set-text-xh text_100 mt-2"/>-->
<!--                    <span class="fl ml-5">元</span>-->
<!--                </dd>-->
<!--            </dl>-->
<!--            <dl>-->
<!--                <dt>评论送积分：</dt>-->
<!--                <dd>-->
<!--                    <input type="text" name="jifencomment" id="jifencomment" class="set-text-xh text_100 mt-2" value="{$info['jifencomment']}"/>-->
<!--                    <span class="fl ml-5">分</span>-->
<!--                </dd>-->
<!--            </dl>-->
            <dl>
                <dt>支付方式：</dt>
                <dd>

                    <div class="on-off">
                        <input type="radio" name="paytype" value="1" {if $info['paytype']=='1'}checked="checked"{/if} />全款支付 &nbsp;
                        <input type="radio" name="paytype" value="2" {if $info['paytype']=='2'}checked="checked"{/if} />定金支付 &nbsp;
                        <span id="dingjin" style="{if $info['paytype'] == '2'}display:inline-block{else}display: none{/if}"><input type="text" name="dingjin" id="dingjintxt" value="{$info['dingjin']}" size="8" onkeyup="(this.v=function(){this.value=this.value.replace(/[^0-9-\.]+/,'');}).call(this)"
                                                                                                                                   onblur="this.v();">&nbsp;元</span>
                        <input type="radio" name="paytype" value="3" {if $info['paytype']=='3'}checked="checked"{/if} />二次确认支付 &nbsp;
                        <input type="radio" name="paytype" value="4" {if $info['paytype']=='3'}checked="checked"{/if} />线下支付 &nbsp;


                        <script>
                            $("input[name='paytype']").click(function () {
                                if ($(this).val() == 2) {
                                    $("#dingjin").show();
                                }
                                else {

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
                <dd>
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
                                        <td class="tit">日期范围：</td>
                                        <td><input type="text" name="starttime" class="set-text-xh text_100 choosetime" value="{$info['lastoffer']['starttime']}"/> <span class="fl">&nbsp;~&nbsp;</span> <input type="text" class="set-text-xh text_100 choosetime" name="endtime"
                                                                                                                                                                                                                 value="{$info['lastoffer']['endtime']}"/></td>
                                    </tr>
                                    <tr>
                                        <td class="tit" valign="top">价格：</td>
                                        <td>
                                            <table class="group-tb" style="border:0px">
                                                <tr class="group_2">
                                                    <td>
                                                        <span class="fl">成本</span>
                                                        <input type="text" class="set-text-xh text_60 mt-2 ml-10" name="basicprice" onkeyup="calPrice(this)" value="{$info['lastoffer']['basicprice']}" autocomplete="off">
                                                        <span class="fl ml-10">+利润</span>
                                                        <input type="text" class="set-text-xh text_60 mt-2 ml-10" name="profit" onkeyup="calPrice(this)" value="{$info['lastoffer']['profit']}" autocomplete="off">
                                                        <span class="fl ml-10">售价：<b style=" color:#f60" class="tprice">{$info['lastoffer']['price']}</b></span>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="tit">价格描述：</td>
                                        <td><input type="text" class="set-text-xh text_700 mt-2" style="width: 300px" name="suit_description" value="{if $info['lastoffer']['description']}{$info['lastoffer']['description']}{/if}"></td>
                                    </tr>
                                    <tr>
                                        <td class="tit">库存：</td>
                                        <td><input type="text" class="set-text-xh text_100 mt-2" name="number" value="{if $info['lastoffer']['number']}{$info['lastoffer']['number']}{else}-1{/if}"> <span style="color:gray;padding-left:10px">-1表示不限</span></td>
                                    </tr>
                                </table>


                            </div>
                            <div class="sub_item"
                            {if $info['lastoffer']['pricerule']!='all'}style="display:none"{/if}>
                        </div>
                        <div class="sub_item"
                        {if $info['lastoffer']['pricerule']!='week'}style="display:none"{/if}>
                        <table class="price_tb">
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
                    <div class="sub_item"
                    {if $info['lastoffer']['pricerule']!='month'}style="display:none"{/if}>
                    <table class="price_tb">
                        <tr>
                            <td valign="top">日期选择：</td>
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
<div class="opn-btn" style="padding-left: 10px; " id="hidevalue">
    <input type="hidden" name="roomid" id="roomid" value="{$info['id']}"/>
    <input type="hidden" name="action" id="action" value="{$action}"/>
    <input type="hidden" name="hotelid" id="hotelid" value="{$info['hotelid']}">
    <input type="hidden" name="pricerule" id="pricerule" value="{$info['lastoffer']['pricerule']}"/>
    <a class="normal-btn" id="btn_save" href="javascript:;">保存</a>
    <a class="normal-btn showbtn" id="btn_view_more" style="{if $action=='add'}display:none{/if}" href="javascript:;" onclick="showMore()">查看报价</a>

</div>
</form>

</div>

</div>
<!--/基础信息结束-->
{request "pub/footer"}
</div>
</div>
<!-- 主体内容 -->

</div>

</body>

<script>
    $(function () {
        $("#nav_hotel_list").addClass('on');
        $("#nav").find('span').click(function () {
            Product.changeTab(this, '.product-add-div');//导航切换
        })
        $("#nav").find('span').first().trigger('click');
        //图片上传
        $('#pic_btn').click(function () {
            ST.Util.showBox('上传图片', BASEHOST + '/plugins/upload_image/image/insert_view', 430, 340, null, null, document, {loadWindow: window, loadCallback: Insert});
            function Insert(result, bool) {
                var len = result.data.length;
                for (var i = 0; i < len; i++) {
                    var temp = result.data[i].split('$$');
                    Imageup.genePic(temp[0], ".up-list-div ul", ".cover-div");
                }
            }
        })

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
            var roomname = $("#roomname").val();
            if(roomname==''){
                ST.Util.showMsg('请输入房间名称',5,1000);
                return false;
            }
            $.ajax({
                type:'POST',
                url:SITEURL+'index/ajax_suit_save',
                data:$("#product_frm").serialize(),
                dataType:'json',
                success:function(data){
                    if(data.status)
                    {
                        if(data.roomid!=null){
                            $("#roomid").val(data.roomid);

                        }
                        ST.Util.showMsg('保存成功!','4',2000);
                        $("#btn_view_more").show();
                    }
                }
            })


        })
        var action = "{$action}";
        if (action == 'edit') {

            var piclist = ST.Modify.getUploadFile({$info['piclist_arr']});


            $(".pic-sel").html(piclist);
            var litpic = $("#litpic").val();
            $(".img-li").find('img').each(function (i, item) {

                if ($(item).attr('src') == litpic) {
                    var obj = $(item).parent().find('.btn-ste')[0];
                    Imageup.setHead(obj, i + 1);
                }
            })
            window.image_index = $(".pic-sel").find('li').length;//已添加的图片数量

        }

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


    })
    //查看日历报价
    function showMore()
    {
        var suitid = $("#roomid").val();
        var productid = $("#hotelid").val();

        var width = $(window).width()-100;
        var height = $(window).height()-100
        var url = SITEURL+'calendar/index/suitid/'+suitid+'/typeid/2/productid/'+productid;
        ST.Util.showBox('查看报价',url,width,height);


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

    function calPrice2(obj)
    {

        var trs=$(obj).parents('tr:first');
        var tprice=0;
        trs.find('input:text').each(function(index, element) {
            var price=parseInt($(element).val());
            if(!isNaN(price))
                tprice+=price;
        });
        trs.find(".tprice").html("<font color='#FF9900'>"+tprice+"</font>元");
    }

</script>
</html>
