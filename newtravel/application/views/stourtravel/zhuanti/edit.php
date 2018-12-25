<!doctype html>
<html>
<head>

    <meta charset="utf-8">
<title color_clear=5otJVl >专题添加/修改</title>
    {template 'stourtravel/public/public_min_js'}
    {php echo Common::getCss('style.css,base.css,base2.css,base_new.css'); }
    {php echo Common::getScript("uploadify/jquery.uploadify.min.js,product_add.js,imageup.js,jquery.colorpicker.js"); }
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
		
        <div class="manage-nr">
         	<div class="cfg-header-bar" id="nav">
         		<div class="cfg-header-tab">
         			<span class="item on" id="column_basic" onclick="Product.switchTabs(this,'basic')">基础信息</span>
                    <span class="item" id="column_seo" onclick="Product.switchTabs(this,'seo')">优化信息</span>
         		</div>
         		<a href="javascript:;" class="fr btn btn-primary radius mr-10 mt-6" onclick="window.location.reload()">刷新</a>	
         	</div> 		

              <form id="product_fm">
                <div class="product-add-div" id="content_basic">
                	<ul class="info-item-block">
                		<li>
                			<span class="item-hd">专题名称：</span>
                			<div class="item-bd">
                				<input type="text" name="ztname" data-required="true" id="ztname" value="{$info['ztname']}" class="input-text w200"><span class="item-text">*</span>
                                <input type="hidden" name="themeid" id="themeid" value="{$info['id']}">
                			</div>
                		</li>
                		<li>
                			<span class="item-hd">短标题：</span>
                			<div class="item-bd">
                				<input type="text" class="input-text w700" name="shortname" value="{$info['shortname']}">
                			</div>
                		</li>
                		<li>
                			<span class="item-hd">专题背景色：</span>
                			<div class="item-bd">
                				<input type="text" value="{$info['bgcolor']}" name="bgcolor" class="input-text w150 bg-color">
                			</div>
                		</li>
                		<li>
                			<span class="item-hd">访问量：</span>
                			<div class="item-bd">
                				<input type="text" name="shownum" class="input-text w150" value="{$info['shownum']}"/>
                			</div>
                		</li>
                		<li>
                			<span class="item-hd">专题介绍：</span>
                			<div class="item-bd">
                				{php  echo Common::getEditor('jieshao',$info['jieshao'],$sysconfig['cfg_admin_htmleditor_width'],250);}
                			</div>
                		</li>
                		<li>
                			<span class="item-hd">显示模版：</span>
                			<div class="item-bd">
                				<div id="templet_list">
                                    <a {if $info['templet']==''}class="label-module-item mr-5"{/if}  href="javascript:void(0)"  data-value="" onclick="setTemplet(this)">标准</a>
                                    {loop $templetlist $r}
                                    <a {if $info['templet']==$r['path']}class="label-module-cur-item mr-5"{else}class="label-module-item mr-5"{/if}  href="javascript:void(0)" data-value="{$r['path']}" onclick="setTemplet(this)">{$r['templetname']}</a>
                                    {/loop}
                                    <input type="hidden" name="templet" id="templet" value="{$info['templet']}"/>
                                </div>
                			</div>
                		</li>
                	</ul>
                	<div class="line"></div>
                    <ul class="info-item-block">
                    	<li>
                    		<span class="item-hd">专题横幅：</span>
                    		<div class="item-bd" id="dd_logo">
                    			<div>
	                    			<div id="banner_btn" class="btn btn-primary radius size-S mt-3">上传图片</div>
	                                <span class="item-text c-999 ml-10">建议上传尺寸1920*580px</span>
                                </div>
                               
                              
                               <div class='image-dv pt-10' id='image_logo'>
                               	 {if $info['logo']}
	                               	<div>
		                               	<img src="{$info['logo']}"/>
		                               	<input type='hidden' name='logo' value='{$info['logo']}'/>
		                               	<a class="btn-link" href='javascript:;' onclick='delImage(this)'>删除</a>
	                               </div>
	                                  {/if}
                                 </div>
                            
                             
                    		</div>
                    	</li>
                    	<li>
                    		<span class="item-hd">专题背景图片：</span>
                    		<div class="item-bd" id="image_bg">
                    			<div id="bg_btn" class="btn btn-primary radius size-S mt-3">上传图片</div>
                    			
                               	<div class='image-dv pt-10' id='image_bgimage'>
                               		 {if $info['bgimage']}
	                               	<div>
		                               	<img src="{$info['bgimage']}"/>
		                               	<input type='hidden' name='bgimage' value='{$info['bgimage']}'/>
	                              		<a class="btn-link" href='javascript:;' onclick='delImage(this)'>删除</a>
	                               </div>
	                                  {/if}
                                </div>
                            
                    			
                          
                    		</div>
                    	</li>
                    </ul>
                </div>
                
                <div id="content_seo" class="product-add-div content-hide" style="display: none;">
                	<ul class="info-item-block">
                		<li>
                			<span class="item-hd">优化标题：</span>
                			<div class="item-bd">
                				<input type="text" name="seotitle" id="seotitle" class="input-text w700" value="{$info['seotitle']}">
                			</div>
                		</li>
                		<li>
                			<span class="item-hd">Tag词：</span>
                			<div class="item-bd">
                				<input type="text" id="tagword" name="tagword" class="input-text w700" value="">
                			</div>
                		</li>
                		<li>
                			<span class="item-hd">关键词：</span>
                			<div class="item-bd">
                				<input type="text" name="keyword" id="keyword" class="input-text w700" value="{$info['keyword']}">
                			</div>
                		</li>
                		<li>
                			<span class="item-hd">页面描述：</span>
                			<div class="item-bd">
                				<textarea class="textarea w700" name="description" id="description" cols="" rows="">{$info['description']}</textarea>
                			</div>
                		</li> 
                	</ul>
                </div>
                </form>

				<div class="fl clearfix pb-20">
                    <a class="btn btn-primary radius size-L ml-115" id="btn_save" href="javascript:;">保存</a>
              	</div>	

          </div>
    </td>
    </tr>
    </table>

	<script>
        //设置模板
        function setTemplet(obj)
        {
            var templet = $(obj).attr('data-value');
            $(obj).addClass('label-module-cur-item').siblings().removeClass('label-module-cur-item');
            $("#templet").val(templet);

        }
        
        
	$(document).ready(function(){

      $('.uploadify-button').css('backgroundImage','url("'+PUBLICURL+'images/upload-ico.png'+'")');
        //上传图片
        $('#banner_btn').click(function(){
            ST.Util.showBox('上传图片', SITEURL + 'image/insert_view', 0,0, null, null, document, {loadWindow: window, loadCallback: Insert});
            function Insert(result,bool){
                if(result.data.length>0){
                    var len=result.data.length-1;
                    var temp =result.data[len].split('$$');
                    var img=temp[0];
                    var pdom=$("#image_logo");
                    if(pdom.length>0)
                    {

                        var path=pdom.find('input:hidden').val();
                        $.ajax({
                            type: "post",
                            url : SITEURL+"uploader/delpicture",
                            dataType:'html',
                            data:{picturepath:path},
                            success: function(result){
                                var content = '<div><img src="'+img+'"/><input type="hidden" name="logo" value="'+img+'"/></div><a class="btn-link" href="javascript:;"onclick="delImage(this)">删除</a>'
                                $("#image_logo").html(content);
                            }})
                    }
                    else
                    {
                       var content = '<div><img src="'+img+'"/><input type="hidden" name="logo" value="'+img+'"/></div><a class="btn-link" href="javascript:;"onclick="delImage(this)">删除</a>'
                                $("#image_logo").html(content);
                    }
                }
            }
        });
        $('#bg_btn').click(function(){
            ST.Util.showBox('上传图片', SITEURL + 'image/insert_view', 0,0, null, null, document, {loadWindow: window, loadCallback: Insert});
            function Insert(result,bool){
                if(result.data.length>0){
                    var len=result.data.length-1;
                    var temp =result.data[len].split('$$');
                    var img=temp[0];
                    var pdom=$("#image_bk");
                    if(pdom)
                    {
                        var path=pdom.find('input:hidden').val();
                        $.ajax({
                            type: "post",
                            url : SITEURL+"uploader/delpicture",
                            dataType:'html',
                            data:{picturepath:path},
                            success: function(result){
                                var content = '<div><img src="'+img+'"/><input type="hidden" name="bgimage" value="'+img+'"/></div><a class="btn-link" href="javascript:;"onclick="delImage(this)">删除</a>'
                                $("#image_bgimage").html(content);
                            }})
                    }
                    else
                    {
                        var content = '<div><img src="'+img+'"/><input type="hidden" name="bgimage" value="'+img+'"/></div><a class="btn-link" href="javascript:;"onclick="delImage(this)">删除</a>'
                                $("#image_bgimage").html(content);
                    }
                }
            }
        });

        //保存
        $("#btn_save").click(function(){

               var ztname = $("#ztname").val();

            //验证名称
             if(ztname==''){
                   $("#nav").find('span').first().trigger('click');
                   $("#ztname").focus();
                   ST.Util.showMsg('请填写专题名称',5,2000);
               }
               else
               {
                   $.ajaxform({
                       url   :  SITEURL+"zhuanti/ajax_save",
                       method  :  "POST",
                       form  : "#product_fm",
                       dataType  :  "html",
                       success  :  function(result)
                       {

                           var id= result;
                           if(id>0)
                           {
                               $("#themeid").val(id);
                               ST.Util.showMsg('保存成功!','4',2000);
                           }
                           else{
                               ST.Util.showMsg("{__('norightmsg')}",5,1000);
                           }

                       }});
               }

        })

		$(".bg-color").colorpicker({
					ishex:true,
					success:function(o,color){
						$(o).val(color)
					},
					reset:function(o){
		
					}
				});
	

     });
     function delImage(dom)
	 {
		 
		  var pdom=$(dom).parents(".image-dv").first();
		  pdom.remove();
		  var path=pdom.find('input:hidden').val();
					   $.ajax({
						type: "post",
						url : SITEURL+"uploader/delpicture",
						dataType:'html',
						data:{picturepath:path},
						success: function(result){	
						
						}})
	 }
    </script>

</body>
</html>
