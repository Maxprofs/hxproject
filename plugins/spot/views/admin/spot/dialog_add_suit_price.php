<?php defined('SYSPATH') or die('No direct script access.');?>
{template 'stourtravel/public/public_min_js'}
{php echo Common::getCss('base.css,base_new.css'); }
{php echo Common::getScript("choose.js,product_add.js,jquery.validate.js,DatePicker/WdatePicker.js"); }

<style>
    .container-page .item-hd{
        width: 70px !important;
    }
    .container-page .item-bd{
        padding-left: 75px !important;
    }
    .container-page .info-item-block
    {
        padding: 0 !important;
    }
 
</style>

<div class="container-page">
    <form id="submit_frm" float_ul=VLACXC >
    <ul class="info-item-block">
        <li>
            <span class="item-hd">报价日期：</span>
            <div class="item-bd">
                <input type="text" name="starttime" class="input-text w200 choosetime" autocomplete="off" />
                <span class="item-text pl-5 pr-5 c-999">—</span>
                <input type="text"  name="endtime"  class="input-text w200 choosetime" autocomplete="off" />
            </div>
        </li>
        <li>
            <span class="item-hd"></span>
            <div class="item-bd">
                <div class="date-scope-container">
                    <div class="ds-tab-nav">
                        <label class="radio-label"><input type="radio" name="pricerule" value="1" checked />全部日期范围</label>
                        <label class="radio-label ml-50"><input type="radio" name="pricerule" value="2" />日期范围下的星期</label>
                        <label class="radio-label ml-50"><input type="radio" name="pricerule" value="3" />日期范围下的天</label>
                    </div>
                    <div class="ds-tab-box mt-10 clearfix tab-box-3" style="display: none">
                        <?php  for ($i=1;$i<=31;$i++)
                        {
                            echo " <span class='item' data-id='$i'>$i</span>"  ;
                        }
                        ?>
                    </div>
                    <div class="ds-tab-box mt-10 clearfix tab-box-2" style="display: none">
                        <span class="item" data-id="1">星期一</span>
                        <span class="item" data-id="2">星期二</span>
                        <span class="item" data-id="3">星期三</span>
                        <span class="item" data-id="4">星期四</span>
                        <span class="item" data-id="5">星期五</span>
                        <span class="item" data-id="6">星期六</span>
                        <span class="item" data-id="7">星期天</span>
                    </div>
                </div>
            </div>
        </li>
        <li>
            <span class="item-hd">价格{Common::get_help_icon('spot_price')}：</span>
            <div class="item-bd">
                <div class="mb-10">
                    <label class="check-label va-m"></label>
                    <span class="item-text ml-10">成本<input name="adultbasicprice" value="{$info['adultbasicprice']}" type="text" class="input-text w100 va-t ml-5 reset-input"></span>
                    <span class="item-text ml-10">利润<input name="adultprofit" value="{$info['adultprofit']}" type="text" class="input-text w100 va-t ml-5 reset-input"></span>
                    <span class="item-text ml-10">售价 <span id="adultprice" class="pl-5 c-f60 reset-span" >{$info['adultprice']}</span></span>
                </div>
               <!-- <div class="mb-10">
                    <span class="item-text ml-10">分销价<input name="adultdistributionprice" value="{$info['adultdistributionprice']}" type="text" class="input-text w100 va-t ml-5 reset-input"></span>

                </div>-->
            </div>
        </li>
        <li>
            <span class="item-hd">库存{Common::get_help_icon('product_stock')}：</span>
            <div class="item-bd">
                <label class="radio-label mt-2">
                    <input type="radio" {if $info['number']==-1||!$info['suitid']} checked {/if} name="store" value="1">不限</label>
                <span class="item-text" style="height: 31px">
                        <label class="radio-label ml-30" >
                            <input type="radio" {if $info['number']!=-1&&$info['suitid']} checked {/if}  name="store" value="2">数量</label>
                        <input   type="text" id="number" name="number" value="{$info['number']}"  {if $info['number']==-1||!$info['suitid']} style="display:none" {/if}  class="reset-input input-text w100 ml-5 va-t">
                    </span>
            </div>
        </li>
        <li>
            <span class="item-hd"></span>
            <div class="item-bd">
                <a href="javascript:;" id="clear-data" class="btn btn-grey-outline Size-s radius">清空报价</a>
            </div>
        </li>
    </ul>
    <input type="hidden" name="ticketid" value="{$ticketid}">
    <input type="hidden" name="spotid" value="{$spotid}">
    <div id="hidevalue" class="hide">

    </div>
    </form>
    <div class="clearfix text-c mt-20">
        <a href="javascript:;" id="cancel-btn" class="btn btn-grey-outline  radius">取消</a>
        <a href="javascript:;" class="btn btn-primary radius ml-10">确定</a>
    </div>
</div>
<script>
    $(function () {

        //切换库存方式
        $('input[name=store]').change(function () {
            var store = $(this).val();
            if(store==1)
            {
                $('#number').hide();
            }
            else
            {
                $('#number').show();
            }
        });
        //重置表单
        $('#clear-data').click(function () {
            ST.Util.confirmBox('提示','确定要清空报价?',function () {
                $('.reset-box').attr('checked',false);
                $('.reset-input').val('');
                $('.reset-span').text('');
            })
        });
        //验证
        $('.reset-input').keyup(function () {
            var value = $(this).val();
//            if(value.length==1)
//            {
//                value=value.replace(/[^0-9]/g,'')
//            }
//            else
//            {
//                value=value.replace(/\D/g,'')
//            }
            value = value.replace(/[^\d.]/g, "");//清除“数字”和“.”以外的字符
            value = value.replace(/^\./g, "");//验证第一个字符是数字而不是.
            value = value.replace(/\.{2,}/g, ".");//只保留第一个. 清除多余的.
            value = value.replace(".", "$#$").replace(/\./g, "").replace("$#$", ".");
            value = value.replace(/([0-9]+\.[0-9]{2})[0-9]*/,"$1");
            $(this).val(value);

        });

        //价格变化
        $('input[name=adultbasicprice],input[name=adultprofit]').change(function () {
           var adultbasicprice = $('input[name=adultbasicprice]').val();
           var adultprofit = $('input[name=adultprofit]').val();
           var adultprice = ST.Math.add(adultbasicprice,adultprofit);
           $('#adultprice').text(adultprice)
        });

        //日历选择
        $(".choosetime").click(function(){
            WdatePicker({skin:'whyGreen',dateFmt:'yyyy-MM-dd',minDate:'%y-%M-%d',maxDate: '#{%y+2}-%M-%d'})
        });
        //报价方式切换
        $('input[name=pricerule]').change(function () {
            var type = $(this).val();
            $('.tab-box-3').hide();
            $('.tab-box-2').hide();
            if(type==2)
            {
                $('.tab-box-2').show();
            }
            if(type==3)
            {
                $('.tab-box-3').show();
            }
            ST.Util.resizeDialog('.container-page');
        });
        //星期选择
        $(".tab-box-2 span").click(function(e) {
            var v=$(this).data('id');
            if($(this).hasClass('on'))
            {
                $("#weekval_"+v).remove();
            }
            else
            {
                $("#hidevalue").append("<input type='hidden' id='weekval_"+v+"' name='weekval[]' value='"+v+"'/>");
            }
            $(this).toggleClass('on');

        });
        //具体到天
        $(".tab-box-3 span").click(function(e) {

            var v=$(this).data('id');
            v=$.trim(v);
            v=window.parseInt(v);
            if($(this).hasClass('on'))
            {
                $("#monthval_"+v).remove();
            }
            else
            {
                $("#hidevalue").append("<input type='hidden' id='monthval_"+v+"' name='monthval[]' value='"+v+"'/>");
            }
            $(this).toggleClass('on');
        });




        //确定
        $('.btn-primary').click(function () {

            var starttime = $('input[name=starttime]').val();
            var endtime = $('input[name=endtime]').val();
            var d1 = new Date(starttime);
            var d2 = new Date(endtime);
            if(starttime == '' || endtime==''){
                ST.Util.showMsg('报价日期还没有选择',5,1000);
                return false;
            }
            if(d1 >d2)
            {
                ST.Util.showMsg('开始时间不能大于结束时间',5,1000);
                return false;
            }


            if($("input[name='store']:checked").val()==2){
                if($('#number').val()==""){
                    ST.Util.showMsg('请设置库存',5,1000);
                    return false;
                }
            }
            var data = $('#submit_frm').serialize();
            ST.Util.responseDialog({data:data},true);
        });
        //取消
        $('#cancel-btn').click(function () {
            var data = $('#submit_frm').serialize();
            ST.Util.responseDialog({data:data},false);
        })



    })

</script>