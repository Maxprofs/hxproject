<?php defined('SYSPATH') or die('No direct script access.');?>
{Common::css("style.css,base_new.css,base.css,base2.css,jquery.datetimepicker.css")}
{Common::js("jquery.min.js,common.js,product.js,choose.js,imageup.js,jquery.datetimepicker.full.js")}
<script type="text/javascript"src="/tools/js/DatePicker/WdatePicker.js"></script>
{include "pub/public_js"}
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
    <form id="submit_frm">
    <ul class="info-item-block">
        <li>
            <span class="item-hd">价格：</span>
            <div class="item-bd">
                <div class="mb-10">
                    <label class="check-label va-m"></label>
                    <span class="item-text ml-10">成本<input name="adultbasicprice" value="{$info['adultbasicprice']}" type="text" class="input-text w100 va-t ml-5 reset-input"></span>
                    <span class="item-text ml-10">利润<input name="adultprofit" value="{$info['adultprofit']}" type="text" class="input-text w100 va-t ml-5 reset-input"></span>
                    <span class="item-text ml-10">售价 <span id="price" class="pl-5 c-f60 reset-span" >{$info['price']}</span></span>
                </div>

            </div>
        </li>
        <li>
        <span class="item-hd">库存：</span>
        <div class="item-bd">
            <label class="radio-label">
                <input type="radio" checked="" name="store" {if $info['number']==-1}checked="checked"{/if} value="1">不限</label>
                <span class="item-text" style="height: 31px">
                        <label class="radio-label ml-30">
                            <input type="radio" name="store" {if $info['number']!=-1}checked="checked"{/if} value="2">数量</label>
                        <input type="text" id="number" name="number" value="{$info['number']}" {if $info['number']==-1}style="display: none;"{/if} class="reset-input input-text w100 ml-5 va-t">
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
        <input type="hidden" name="suitid" value="{$suitid}">
        <input type="hidden" name="date" value="{$date}">
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
               /// $('.reset-box').attr('checked',false);
                $('.reset-input').val('');
              /// $('.reset-span').text('');
            })
        });
        //验证
        $('.reset-input').keyup(function () {
            var value = $(this).val();
            value = value.replace(/[^\d.]/g, "");//清除“数字”和“.”以外的字符
            value = value.replace(/^\./g, "");//验证第一个字符是数字而不是.
            value = value.replace(/\.{2,}/g, ".");//只保留第一个. 清除多余的.
            value = value.replace(".", "$#$").replace(/\./g, "").replace("$#$", ".");
            value = value.replace(/([0-9]+\.[0-9]{2})[0-9]*/,"$1");
            $(this).val(value);
        });
        //价格变化
        $('input[name=adultbasicprice],input[name=adultprofit]').change(function () {
           var basicprice = $('input[name=adultbasicprice]').val();
           var profit = $('input[name=adultprofit]').val();
           var price = ST.Math.add(basicprice,profit);
           $('#price').text(price)
        });

        //确定
        $('.btn-primary').click(function () {
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