<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>供应商返佣设置</title>
    {template 'stourtravel/public/public_js'}


	
    <link type="text/css" href="{$GLOBALS['cfg_plugin_finance_public_url']}css/fx_base.css" rel="stylesheet" />
    <link type="text/css" href="{$GLOBALS['cfg_plugin_finance_public_url']}css/fx_style.css" rel="stylesheet" />
    <link type="text/css" href="{$GLOBALS['cfg_plugin_finance_public_url']}css/fx_product.css" rel="stylesheet" />
    
    
	
    {php echo Common::getScript('config.js');}
    {php echo Common::getScript("uploadify/jquery.uploadify.min.js"); }
    {php echo Common::getCss('uploadify.css','js/uploadify/'); }
	{php echo Common::getCss('base.css,style.css,base_new.css'); }
	<style>
		.global_nav .kj_tit{
			border-bottom: none;
		}
	</style>

</head>
<body>
<table class="content-tab" body_left=vXJzDt >
    <tr>
        <td width="119px" class="content-lt-td"  valign="top">
            {template 'stourtravel/public/leftnav'}
            <!--右侧内容区-->
        </td>
        <td valign="top" class="content-rt-td">
            <!--面包屑-->

            <div>
                <form id="frm">
                    <div class="w-set-con">
                    	<div class="cfg-header-bar">
                    		<div class="cfg-header-tab">
                    			{loop $productlist $product}
	                            <span class="item" data-id="{$product['id']}">{$product['modulename']}</span>
	                            {/loop}
	                            <span class="item" data-id="basic_config">参数配置</span>
                    		</div>
                    		<a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a></div>
                    	</div>
                        

                            
                        <div class="w-set-nr">

                            {loop $productlist $product}
                            <div class="picture ml-10 ratio-content" id="product_{$product['id']}" style="display: none;">
                            	<ul class="info-item-block">
                            		<li>
                            			<span class="item-hd">返佣类型：</span>
                            			<div class="item-bd">
                            				<label class="radio-label mr-20"><input type="radio" name="cfg_commission_type_{$product['id']}" class="fx_type" value="1" {if $info['cfg_commission_type_'.$product['id']]==1}checked="checked"{/if}>比例</label>
                            				<label class="radio-label mr-20"><input type="radio" name="cfg_commission_type_{$product['id']}" class="fx_type" value="0" {if $info['cfg_commission_type_'.$product['id']]==0}checked="checked"{/if}>现金</label>
                            				<span class="c-999">是按比例计算返佣金额还是直接返固定的金额</span>
                            			</div>
                            		</li>
                            	</ul>
                                


                                <div class="typecon_1 typecon" style="{if $info['cfg_commission_type_'.$product['id']]==0}display:none{/if}">
                                	<ul class="info-item-block">
                                		<li>
                                			<span class="item-hd">平台佣金比例：</span>
                                			<div class="item-bd">
                                				<input type="text" name="cfg_commission_ratio_{$product['id']}" class="input-text w70" value="{php echo $info['cfg_commission_ratio_'.$product['id']]}"/>
                                				<span class="item-text">%</span>
                                				<span class="item-text c-999 ml-5">平台能拿到的佣金比例</span>
                                			</div>
                                		</li>
                                	</ul>
                                   
                                </div>


                                <div class="typecon_0 typecon" style="{if $info['cfg_commission_type_'.$product['id']]==1}display:none{/if}">
                                	<ul class="info-item-block">
                                		{if $product['id']==1}
                                		<li>
                                			<span class="item-hd">平台成人佣金金额：</span>
                                			<div class="item-bd">
                                				<input type="text" name="cfg_commission_cash_{$product['id']}" class="input-text w70" value="{php echo $info['cfg_commission_cash_'.$product['id']]}"/><span class="item-text">元</span>
                                				<span class="item-text c-999 ml-5">平台能拿到的佣金金额</span>
                                			</div>
                                		</li>
                                		<li>
                                			<span class="item-hd">平台老人佣金金额：</span>
                                			<div class="item-bd">
                                				<input type="text" name="cfg_commission_cash_{$product['id']}_old" class="input-text w70" value="{php echo $info['cfg_commission_cash_'.$product['id'].'_old']}"/>
                                				<span class="item-text">元</span>
                                				<span class="item-text c-999 ml-5">平台能拿到的佣金金额</span>
                                			</div>
                                		</li>
                                		<li>
                                			<span class="item-hd">平台小孩佣金金额：</span>
                                			<div class="item-bd">
                                				<input type="text" name="cfg_commission_cash_{$product['id']}_child" class="input-text w70" value="{php echo $info['cfg_commission_cash_'.$product['id'].'_child']}"/>
                                				<span class="item-text">元</span>
                                				<span class="item-text c-999 ml-5">平台能拿到的佣金金额</span>
                                			</div>
                                		</li>
                                		{else}
                                		<li>
                                			<span class="item-hd">平台佣金金额：</span>
                                			<div class="item-bd">
                                				<input type="text" name="cfg_commission_cash_{$product['id']}" class="input-text w70" value="{php echo $info['cfg_commission_cash_'.$product['id']]}"/>
                                				<span class="item-text">元</span>
                                				<span class="item-text c-999 ml-5">平台能拿到的佣金金额</span>
                                			</div>
                                		</li>
                                		{/if}
                                	</ul>                                                   
                                </div>
                                {if St_Functions::open_single_finance_set($product['id'])}
                                <p><a data-url="finance/admin/financeextend/config_commission_product/typeid/{$product['id']}/{if isset($_GET['menuid'])}menuid/{$_GET['menuid']}/{/if}parentkey/finance/itemid/5" href="javascript:;" class="fl btn btn-primary radius size-S mt-3 config_commission_product">设置{$product['modulename']}具体产品反佣</a>
                                    <span class="item-text c-999 ml-10">
                                        如果某一产品的对应的反佣比例未设置或为0，那么系统将使用当前页设置的栏目反佣比例或现金
                                    </span>
                                </p>
                                {/if}
                            </div>
                            {/loop}

                            <div class="picture ml-10 ratio-content" id="product_basic_config" style="display: none;">
                            	<ul class="info-item-block">
                            		<li>
                            			<span class="item-hd">现金返佣计算规则：</span>
                            			<div class="item-bd">
                            				<label class="radio-label mr-20"><input type="radio" name="cfg_commission_cash_calc_type" class="fx_type" value="0" {if $info['cfg_commission_cash_calc_type']==0}checked="checked"{/if}>订单额</label>
                            				<label class="radio-label mr-20"><input type="radio" name="cfg_commission_cash_calc_type" class="fx_type" value="1" {if $info['cfg_commission_cash_calc_type']==1}checked="checked"{/if}>订单购买人数</label>
                            			</div>
                            		</li>
                            	</ul>
                            </div>
							<div class="clear clearfix pt-20">
			                    <a class="btn btn-primary radius size-L ml-115" href="javascript:;" id="btn_save">保存</a>
			                </div>
                            
                        </div>
                    </div>
                </form>
            </div>
        </td>
    </tr>
</table>



<script>

    $(document).ready(function(){
        //配置信息保存
        $("#btn_save").click(function(){
            Ext.Ajax.request({
                url   :  SITEURL+"finance/admin/financeextend/ajax_config_commission_type_save",
                method  :  "POST",
                isUpload :  true,
                form  : "frm",
                success  :  function(response, opts)
                {
                    var data = $.parseJSON(response.responseText);
                    if(data.status)
                    {
                        ST.Util.showMsg('保存成功!','4',2000);
                    }
                }
            });
        })


        //切换
        $(".fx_type").click(function(){
            var typeVal=$(this).val();
            $(this).parents('.ratio-content:first').find(".typecon").hide();
            $(this).parents('.ratio-content:first').find(".typecon_"+typeVal).show();
        });

        $(".item").click(function(){
            $(this).addClass('on');
            $(this).siblings().removeClass('on');
            var id=$(this).attr("data-id");
            $(".ratio-content").hide();
            $("#product_"+id).show();
        });
        $(".item:first").trigger('click');

        //跳转到具体产品设置页面
        $(".config_commission_product").click(function(){
            var $this = $(this);
            var url = SITEURL + $this.attr("data-url");
            ST.Util.addTab($this.text(),url,0);
        });
    });
</script>
<!--右侧选中效果-->
<script type="text/javascript" src="{$GLOBALS['cfg_plugin_finance_public_url']}js/common.js"></script>

</body>
</html>
