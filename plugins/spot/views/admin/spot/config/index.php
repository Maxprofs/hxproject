<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
<title>配置首页</title>
    {template 'stourtravel/public/public_min_js'}
    {php echo Common::getCss('style.css,base.css,base_new.css'); }
    {php echo Common::getScript("uploadify/jquery.uploadify.min.js,product_add.js,choose.js,imageup.js"); }
    {php echo Common::getCss('uploadify.css','js/uploadify/'); }
</head>

<body>

	<table class="content-tab" html_div=BLACXC >
        <tr>
            <td width="119px" class="content-lt-td"  valign="top">
                {template 'stourtravel/public/leftnav'}
                <!--右侧内容区-->
            </td>
            <td valign="top" class="content-rt-td ">
                <div class="cfg-header-bar">
                    <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
                </div>
                <form method="post"  id="frm" name="frm" enctype="multipart/form-data">
                    <!--基础信息开始-->
                    <div class="product-add-div">
                        <ul class="info-item-block">

                            <li class="">
                                <span class="item-hd">自动审核<img class="ml-5" style="cursor:pointer; vertical-align: middle; margin-top: -3px;" title="查看帮助auto_audit" src="/newtravel/public/images/help-ico.png" onclick="ST.Util.helpBox(this,'auto_audit',event)">：</span>
                                <div class="item-bd">
                                    <label class="radio-label"><input type="radio" name="cfg_spot_supplier_check_auto" {if $list['cfg_spot_supplier_check_auto']=='1'}checked="checked"{/if}  value="1">自动审核</label>
                                    <label class="radio-label ml-20"><input type="radio" name="cfg_spot_supplier_check_auto"  {if $list['cfg_spot_supplier_check_auto']==0}checked="checked"{/if} value="0">人工审核</label>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <!--/基础信息结束-->
                    <div class="clear clearfix mt-5">
                        <a class="btn btn-primary radius size-L ml-115" id="btn_save" href="javascript:;">保存</a>
                    </div>
                </form>
            </td>
       </tr>
    </table>

<script>
	$(document).ready(function(){

        $("#nav").find('span').click(function(){

            Product.changeTab(this,'.product-add-div');//导航切换
        })
        $("#nav").find('span').first().trigger('click');



        $("#btn_save").click(function(){
             $.ajaxform({
                     url:SITEURL+'spot/admin/config/ajax_config_save',
                     form:'#frm',
                     dataType:'json',
                     method:'post',
                     success:function(result){
                         if(result.status)
                             ST.Util.showMsg('保存成功',4);
                         else
                             ST.Util.showMsg('失败',5)
                     }
                 })
        })

    });





</script>
</body>
</html>
