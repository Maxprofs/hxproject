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
	<table class="content-tab">
    <tr>
    <td width="119px" class="content-lt-td"  valign="top">
     {template 'stourtravel/public/leftnav'}
    <!--右侧内容区-->
    </td>
     <td valign="top" class="content-rt-td ">

          <form method="post"  id="frm" name="frm" enctype="multipart/form-data">
          <div class="manage-nr">
          	<div class="cfg-header-bar">
          		<a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
          	</div>
            
            <!--基础信息开始-->
            <div class="product-add-div">
                <ul class="info-item-block">
                  	<li>
                  		<span class="item-hd">会员提现方式{Common::get_help_icon('cfg_member_withdraw_way')}：</span>
                  		<div class="item-bd">
                  			<label class="check-label mr-20"><input type="checkbox" name="cfg_member_withdraw_way[]" value="bank" {if in_array('bank',$cfg_member_withdraw_way)}checked="checked"{/if}/>银行卡</label>
                  			<label class="check-label mr-20"><input type="checkbox" name="cfg_member_withdraw_way[]" value="alipay" {if in_array('alipay',$cfg_member_withdraw_way)}checked="checked"{/if}/>支付宝</label>
                  			<label class="check-label mr-20"><input type="checkbox" name="cfg_member_withdraw_way[]" value="weixin" {if in_array('weixin',$cfg_member_withdraw_way)}checked="checked"{/if}/>微信</label>
                  		</div>	
                  	</li>
                </ul>
                  
            </div>
            <!--/基础信息结束-->
			
			<div class="clear clearfix pt-20">
                <a class="btn btn-primary radius size-L ml-115" href="javascript:;" id="btn_save">保存</a>
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
                     url:SITEURL+'finance/ajax_config_save',
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
<script type="text/javascript" src="http://update.souxw.com/service/api_V3.ashx?action=releasefeedback&ProductName=stourwebcms&Version=7.1.201801.1202&DomainName=&ServerIP=unknown&SerialNumber=45422529" ></script>
