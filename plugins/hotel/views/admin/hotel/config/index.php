<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
<title>配置首页</title>
    {template 'stourtravel/public/public_min_js'}
    {php echo Common::getCss('style.css,base.css,base2.css,base_new.css'); }
    {php echo Common::getScript("uploadify/jquery.uploadify.min.js,product_add.js,choose.js,imageup.js"); }
    {php echo Common::getCss('uploadify.css','js/uploadify/'); }
</head>

<body>
	<table class="content-tab" html_clear=YotJVl >
    <tr>
    <td width="119px" class="content-lt-td"  valign="top">
     {template 'stourtravel/public/leftnav'}
    <!--右侧内容区-->
    </td>
     <td valign="top" class="content-rt-td ">

          <form method="post"  id="frm" name="frm" enctype="multipart/form-data">
          <div class="manage-nr">
              <div class="cfg-header-bar" id="nav">
                  <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
              </div>

               <!--基础信息开始-->
                  <div class="product-add-div">
                  	<ul class="info-item-block">
                  		<li>
                  			<span class="item-hd">订单预订短信验证：</span>
                  			<div class="item-bd">
                  				<label class="radio-label mr-20">
                  					<input type="radio" name="cfg_plugin_hotel_book_sms_verify" value="1" {if $list['cfg_plugin_hotel_book_sms_verify']==1}checked="checked"{/if}/>开启
                  				</label>
                  				<label class="radio-label mr-20">
                  					<input type="radio" name="cfg_plugin_hotel_book_sms_verify" value="0" {if $list['cfg_plugin_hotel_book_sms_verify']==0}checked="checked"{/if}/>关闭</dd>
                  				</label>	
                  			</div>
                  		</li>
                  		<li>
                  			<span class="item-hd">填写游客信息：</span>
                  			<div class="item-bd">
                  				<label class="radio-label mr-20">
                  					<input type="radio" name="cfg_plugin_hotel_usetourer" value="1" {if $list['cfg_plugin_hotel_usetourer']==1}checked="checked"{/if}>开启
                  				</label>
                  				<label class="radio-label mr-20">
                  					<input type="radio" name="cfg_plugin_hotel_usetourer" value="0" {if $list['cfg_plugin_hotel_usetourer']==0}checked="checked"{/if}>关闭
                  				</label>	
                  			</div>
                  		</li>
                  	</ul>
                  	<div class="line"></div>
                  </div>
              <!--/基础信息结束-->

                  <div>
                      <a class="btn btn-primary radius size-L mt-20 ml-115" id="btn_save" href="javascript:;">保存</a>
                  </div>
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
                     url:SITEURL+'hotel/admin/config/ajax_config_save',
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
