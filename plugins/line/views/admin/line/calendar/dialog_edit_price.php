<?php defined('SYSPATH') or die('No direct script access.');?>
{template 'stourtravel/public/public_min_js'}
{php echo Common::getCss('base.css,base_new.css'); }
{php echo Common::getScript("choose.js,product_add.js,jquery.validate.js"); }

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
            <span class="item-hd">价格{Common::get_help_icon('product_price')}：</span>
            <div class="item-bd">
                <div class="mb-10">
                    <label class="check-label va-m">
                        <input class="reset-box" type="checkbox" name="propgroup[]"  value="2"  {if in_array(2,$info['propgroup'])} checked {/if}  >成人</label>
                    <span class="item-text ml-10">成本<input name="adultbasicprice" value="{$info['adultbasicprice']}" type="text" class="input-text w100 va-t ml-5 reset-input"></span>
                    <span class="item-text ml-10">利润<input name="adultprofit" value="{$info['adultprofit']}" type="text" class="input-text w100 va-t ml-5 reset-input"></span>
                    <span class="item-text ml-10">售价 <span id="adultprice" class="pl-5 c-f60 reset-span" >{$info['adultprice']}</span></span>
                </div>
                <div class="mb-10">
                    <label class="check-label va-m">
                        <input class="reset-box" type="checkbox" name="propgroup[]"  value="1"  {if in_array(1,$info['propgroup'])} checked {/if}>儿童</label>
                    <span class="item-text ml-10">成本<input name="childbasicprice" value="{$info['childbasicprice']}" type="text" class="input-text w100 va-t ml-5 reset-input"></span>
                    <span class="item-text ml-10">利润<input name="childprofit" value="{$info['childprofit']}" type="text" class="input-text w100 va-t ml-5 reset-input"></span>
                    <span class="item-text ml-10">售价 <span id="childprice" class="pl-5 c-f60 reset-span" >{$info['childprice']}</span></span>
                </div>
                <div class="mb-10">
                    <label class="check-label va-m">
                        <input class="reset-box" type="checkbox" name="propgroup[]"  value="3"  {if in_array(3,$info['propgroup'])} checked {/if}>老人</label>
                    <span class="item-text ml-10">成本<input name="oldbasicprice" value="{$info['oldbasicprice']}" type="text" class="input-text w100 va-t ml-5 reset-input"></span>
                    <span class="item-text ml-10">利润<input name="oldprofit" value="{$info['oldprofit']}" type="text" class="input-text w100 va-t ml-5 reset-input"></span>
                    <span class="item-text ml-10">售价 <span id="oldprice" class="pl-5 c-f60 reset-span" >{$info['oldprice']}</span></span>
                </div>
            </div>
        </li>
        <li>
            <span class="item-hd">单房差{Common::get_help_icon('line_single_room')}：</span>
            <div class="item-bd">
                <input type="text" class="input-text w100 reset-input" name="roombalance" value="{$info['roombalance']}">
            </div>
        </li>
        <li>
            <span class="item-hd">库存{Common::get_help_icon('product_stock')}：</span>
            <div class="item-bd">
                <label class="radio-label">
                    <input type="radio" {if $info['number']==-1||!$info['suitid']} checked {/if} name="store" value="1">不限</label>
                <span class="item-text" style="height: 31px">
                        <label class="radio-label ml-30">
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
        <input type="hidden" name="suitid" value="{$suitid}">
        <input type="hidden" name="date" value="{$date}">
        <input type="hidden" name="lineid" value="{$lineid}">
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
            var adultprice = ST.Math.add(adultbasicprice, adultprofit);
            $('#adultprice').text(adultprice)
        });
        $('input[name=childbasicprice],input[name=childprofit]').change(function () {
            var childbasicprice = $('input[name=childbasicprice]').val();
            var childprofit = $('input[name=childprofit]').val();
            var childprice = ST.Math.add(childbasicprice,childprofit);
            $('#childprice').text(childprice)
        });
        $('input[name=oldbasicprice],input[name=oldprofit]').change(function () {
            var oldbasicprice = $('input[name=oldbasicprice]').val();
            var oldprofit = $('input[name=oldprofit]').val();
            var oldprice = ST.Math.add(oldbasicprice,oldprofit);
            $('#oldprice').text(oldprice)
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