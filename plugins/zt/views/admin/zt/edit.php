<!doctype html>
<html>
<head>

<meta charset="utf-8">
<title>专题添加/修改</title>
    {template 'stourtravel/public/public_min_js'}
    {php echo Common::getCss('style.css,base.css,base_new.css'); }
    {php echo Common::getScript("uploadify/jquery.uploadify.min.js,product_add.js,imageup.js,jquery.colorpicker.js"); }
    {php echo Common::getCss('uploadify.css','js/uploadify/'); }
    {Common::css_plugin('theme.css','zt')}
    {Common::js_plugin('zt.js','zt')}
</head>
<body>

	<table class="content-tab" body_html=UvBCXC >
    <tr>
    <td width="119px" class="content-lt-td"  valign="top">
     {template 'stourtravel/public/leftnav'}
    <!--右侧内容区-->
    </td>
     <td valign="top" class="content-rt-td ">

          <div class="manage-nr">
                  <div class="cfg-header-bar">
                    <div class="cfg-header-tab" id="nav">
                        <span class="item on" id="column_basic" onclick="Product.switchTabs(this,'basic')"><s></s>基础信息</span>
                        <span class="item" id="column_basic" onclick="Product.switchTabs(this,'channel',switch_back)"><s></s>栏目内容</span>
                        <span class="item" id="column_basic" onclick="Product.switchTabs(this,'templet')"><s></s>模板设置</span>
                        <span class="item" id="column_seo" onclick="Product.switchTabs(this,'seo')"><s></s>优化信息</span>
                    </div>
                    <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
              </div>

              <form id="product_fm">
                <div class="product-add-div" id="content_basic">
                    <ul class="info-item-block">
                        <li>
                            <span class="item-hd"><i class="star-note-ico mr-5">*</i>专题名称：</span>
                            <div class="item-bd">
                                <input type="text" name="ztname" data-required="true" id="ztname" value="{$info['title']}" class="input-text w900">
                                <input type="hidden" name="themeid" id="themeid" value="{$info['id']}">
                            </div>
                        </li>
                        <li>
                            <span class="item-hd">专题介绍：</span>
                            <div class="item-bd">
                                {php  echo Common::getEditor('introduce',$info['introduce'],$sysconfig['cfg_admin_htmleditor_width'],250);}
                            </div>
                        </li>
                        <li>
                            <span class="item-hd">专题背景色：</span>
                            <div class="item-bd">
                                <input type="text" value="{$info['bgcolor']}" name="bgcolor" {if !empty($info['bgcolor'])}style="color:{$info['bgcolor']}"{/if} class="input-text w150 bg-color">
                                <span class="item-text c-999 ml-10">*仅部分专题模板支持该功能</span>
                            </div>
                        </li>
                        <li>
                            <span class="item-hd">专题PC横幅：</span>
                            <div class="item-bd" id="dd_logo">
                                <span id="banner_btn" class="btn btn-primary radius size-S mt-3">上传图片</span>
                                <span class="item-text c-999 ml-10">*仅部分专题模板支持该功能,建议尺寸为1920*624</span>
                                <?php
                                if($info['pc_banner'])
                                    echo "<div class='image-dv mt-5' id='image_logo'><div><img src=\"".$info['pc_banner']."\"  class=\"up-img-area\"></div><div class='mt-5'><a href='javascipt:;'   class='btn-link ' onClick=\"delImage(this)\">删除</a><input type='hidden' name='pc_banner' value='".$info['pc_banner']."'/></div></div>";
                                ?>
                            </div>
                        </li>
                        <li>
                            <span class="item-hd">专题背景图片：</span>
                            <div class="item-bd" id="image_bg">
                                <span id="bg_btn" class="btn btn-primary radius size-S mt-3">上传图片</span>
                                <span>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="bgrepeat" {if $info['bgrepeat']}checked{/if} value="1">平铺&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="bgrepeat" {if !$info['bgrepeat']}checked{/if} value="0">不平铺</span>
                                <span class="item-text c-999 ml-10">*仅标准版支持平铺功能。如不平铺，则建议图片宽度为1920</span>
                                <?php
                                if($info['bgimage'])
                                    echo "<div class='image-dv mt-5' id='image_bk'><div><img src=\"".$info['bgimage']."\"  class=\"up-img-area\"></div><div class='mt-5'><a href='javascipt:;' class='btn-link' onClick=\"delImage(this)\">删除</a><input type='hidden' name='bgimage' value='".$info['bgimage']."'/></div></div>";
                                ?>
                            </div>
                        </li>
                        <li>
                            <span class="item-hd">专题手机横幅：</span>
                            <div class="item-bd" id="m_banner_image_bg">
                                <span id="m_banner_btn" class="btn btn-primary radius size-S mt-3">上传图片</span>
                                <span class="item-text c-999 ml-10">*仅部分手机专题模板支持该功能,建议尺寸为514*317</span>
                                <?php
                                if($info['m_banner'])
                                    echo "<div class='image-dv mt-5' id='image_bk_m_banner'><div><img src=\"".$info['m_banner']."\" class=\"up-img-area\"></div><div class='mt-5'><a href='javascipt:;'  class='btn-link' onClick=\"delImage(this)\">删除</a><input type='hidden' name='m_banner' value='".$info['m_banner']."'/></div></div>";
                                ?>
                            </div>
                        </li>

                    </ul>


                </div>
                <div class="product-add-div" id="content_channel" style="display: none;">
                    <div class="clearfix">
                        {template 'admin/zt/channel'}
                    </div>
                </div>
                  <div class="product-add-div" id="content_templet" style="display: none;">
                      <ul class="info-item-block">
                          <li>
                              <span class="item-hd">PC显示模版：</span>
                              <div class="item-bd">
                                  <div  id="templet_list">
                                      <a {if $info['pc_templet']==''}class="label-module-cur-item mr-5"{else}class="label-module-item mr-5"{/if}  href="javascript:void(0)" data-templet="pc_templet"  data-value="" onclick="setTemplet(this)">标准</a>
                                      {loop $pc_templet_list $r}
                                      <a {if $info['pc_templet']==$r['path']}class="label-module-cur-item mr-5"{else}class="label-module-item mr-5"{/if}  href="javascript:void(0)" data-templet="pc_templet" data-value="{$r['path']}" onclick="setTemplet(this)">{$r['templetname']}</a>
                                      {/loop}
                                      <input type="hidden" name="pc_templet" id="pc_templet" value="{$info['pc_templet']}"/>
                                  </div>
                              </div>
                          </li>
                          <li>
                              <span class="item-hd">手机显示模版：</span>
                              <div class="item-bd">
                                  <div  id="templet_list">
                                      <a {if $info['m_templet']==''}class="label-module-cur-item mr-5"{else}class="label-module-item mr-5"{/if}  href="javascript:void(0)" data-templet="m_templet"   data-value="" onclick="setTemplet(this)">标准</a>
                                      {loop $m_templet_list $r}
                                      <a {if $info['m_templet']==$r['path']}class="label-module-cur-item mr-5"{else}class="label-module-item mr-5"{/if}  href="javascript:void(0)" data-templet="m_templet" data-value="{$r['path']}" onclick="setTemplet(this)">{$r['templetname']}</a>
                                      {/loop}
                                      <input type="hidden" name="m_templet" id="m_templet" value="{$info['m_templet']}"/>
                                  </div>
                              </div>
                          </li>

                      </ul>
                  </div>
                    <div id="content_seo" class="product-add-div content-hide" style="display: none;">
                        <ul class="info-item-block">
                            <li>
                                <span class="item-hd">前台隐藏：</span>
                                <div class="item-bd">
                                    <label class="radio-label"><input type="radio" name="ishidden"  {if $info['ishidden']==0}checked="checked"{/if} value="0">显示</label>
                                    <label class="radio-label ml-20"><input type="radio" name="ishidden"  {if $info['ishidden']==1}checked="checked"{/if} value="1">隐藏</label>
                                    <span class="item-text c-999 ml-20 va-t">*设置该专题是否在前台进行显示</span>
                                </div>
                            </li>
                            <li>
                                <span class="item-hd">拼音：</span>
                                <div class="item-bd">
                                    <input type="text" name="pinyin" id="pinyin" class="input-text w200" value="{$info['pinyin']}">
                                    <span class="item-text c-999 ml-10">*如果填写拼音,此专题的访问地址将会是http://网站域名/zt/pinyin</span>
                                </div>
                            </li>
                            <li>
                                <span class="item-hd">优化标题：</span>
                                <div class="item-bd">
                                    <input type="text" name="seotitle" id="seotitle" class="input-text w900" value="{$info['seotitle']}">
                                </div>
                            </li>
                            <li>
                                <span class="item-hd">Tag词：</span>
                                <div class="item-bd">
                                    <input type="text" id="tagword" name="tagword" class="input-text w900" value="{$info['tagword']}">
                                </div>
                            </li>
                            <li>
                                <span class="item-hd">关键词：</span>
                                <div class="item-bd">
                                    <input type="text" name="keyword" id="keyword" class="input-text w900" value="{$info['keyword']}">
                                </div>
                            </li>
                            <li>
                                <span class="item-hd">页面描述：</span>
                                <div class="item-bd">
                                    <textarea class="textarea w900" name="description" id="description" cols="" rows="">{$info['description']}</textarea>
                                </div>
                            </li>
                        </ul>
                    </div>
                </form>


                  <div class="clear">
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
            var contain = $(obj).attr('data-templet');

            $(obj).parent().find('.label-module-cur-item').addClass('label-module-item');
            $(obj).parent().find('.label-module-cur-item').removeClass('label-module-cur-item');
            $(obj).removeClass('label-module-item');
            $(obj).addClass('label-module-cur-item');

            $("#"+contain).val(templet);

        }
    var is_coupon_install = "{$is_coupon_install}";
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
                                pdom.remove();
                                var content="<div class='image-dv' id='image_logo'><div><img src=\""+img+"\"/></div><div><a href='javascript:;' onclick='delImage(this)'>删除</a><input type='hidden' name='logo' value='"+img+"'/></div></div>";
                                $("#dd_logo").append(content);
                            }})
                    }
                    else
                    {
                        var content="<div class='image-dv' id='image_logo'><div><img src=\""+img+"\"  class=\"up-img-area\"></div><div><a href='javascript:;' onclick='delImage(this)'>删除</a><input type='hidden' name='pc_banner' value='"+img+"'/></div></div>";
                        $("#dd_logo").append(content);
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
                                pdom.remove();
                                var content="<div class='image-dv' id='image_bk'><div><img src=\""+img+"\"  class=\"up-img-area\"></div><div><a href='javascript:;' onclick='delImage(this)'>删除</a><input type='hidden' name='bgimage' value='"+img+"'/></div></div>";
                                $("#image_bg").append(content);
                            }})
                    }
                    else
                    {
                        var content="<div class='image-dv' id='image_bk'><div><img src=\""+img+"\"  class=\"up-img-area\"></div><div><a href='javascript:;' onclick='delImage(this)'>删除</a><input type='hidden' name='bgimage' value='"+img+"'/></div></div>";
                        $("#image_bg").append(content);
                    }
                }
            }
        });
        $('#m_banner_btn').click(function(){
            ST.Util.showBox('上传图片', SITEURL + 'image/insert_view', 0,0, null, null, document, {loadWindow: window, loadCallback: Insert});
            function Insert(result,bool){
                if(result.data.length>0){
                    var len=result.data.length-1;
                    var temp =result.data[len].split('$$');
                    var img=temp[0];
                    var pdom=$("#image_bk_m_banner");
                    if(pdom)
                    {
                        var path=pdom.find('input:hidden').val();
                        $.ajax({
                            type: "post",
                            url : SITEURL+"uploader/delpicture",
                            dataType:'html',
                            data:{picturepath:path},
                            success: function(result){
                                pdom.remove();
                                var content="<div class='image-dv' id='image_bk_m_banner'><div><img src=\""+img+"\"  class=\"up-img-area\"></div><div><a href='javascript:;' onclick='delImage(this)'>删除</a><input type='hidden' name='m_banner' value='"+img+"'/></div></div>";
                                $("#m_banner_image_bg").append(content);
                            }})
                    }
                    else
                    {
                        var content="<div class='image-dv' id='image_bk_m_banner'><div><img src=\""+img+"\"/></div><div><a href='javascript:;' onclick='delImage(this)'>删除</a><input type='hidden' name='image_bk_m_banner' value='"+img+"'/></div></div>";
                        $("#m_banner_image_bg").append(content);
                    }
                }
            }
        });

        //保存
        $("#btn_save").click(function(){

            save_zt(1);

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

     function switch_back(){
         save_zt();
     }
     //保存专题
     function save_zt(showmsg){
         var pinyin = $("#pinyin").val();
         var themeid = $("#themeid").val();
         if(pinyin){
             var pystatus = 1;
             $.ajax({
                 type:'POST',
                 url:SITEURL+"zt/admin/zt/ajax_check_pinyin",
                 data:{pinyin:pinyin,themeid:themeid},
                 dataType:'json',
                 async:false,
                 success:function(data){
                     if(data.status==0){
                         ST.Util.showMsg('专题拼音重复,请修改',5,2000);
                         $('#column_seo').trigger('click');
                         pystatus =0;
                     }
                 }
             })
             if(!pystatus){
                 return false;
             }
         }
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
                 url   :  SITEURL+"zt/admin/zt/ajax_save",
                 method  :  "POST",
                 form  : "#product_fm",
                 dataType  :  "html",
                 success  :  function(result)
                 {

                     var id= result;
                     if(id>0)
                     {
                         $("#themeid").val(id);
                         if(showmsg){
                             ST.Util.showMsg('保存成功!','4',2000);
                         }

                     }
                     else{
                         if(showmsg){
                             ST.Util.showMsg("{__('norightmsg')}",5,1000);
                         }

                     }

                 }});
         }
     }

    </script>

</body>
</html>
