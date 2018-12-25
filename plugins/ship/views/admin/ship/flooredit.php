<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>邮轮添加/修改</title>
{template 'stourtravel/public/public_js'}
{php echo Common::getCss('style.css,base.css,base2.css,plist.css,inlinegrid.css,base_new.css'); }
{php echo Common::getScript("uploadify/jquery.uploadify.min.js,product_add.js,choose.js,imageup.js"); }
{php echo Common::getCss('uploadify.css','js/uploadify/'); }
</head>
<body bottom_top=dULzDt >
	<table class="content-tab">
    <tr>
    <td width="119px" class="content-lt-td"  valign="top">
     {template 'stourtravel/public/leftnav'}
    <!--右侧内容区-->
    </td>
     <td valign="top" class="content-rt-td ">

          <form method="post" name="product_frm" id="product_frm">
          <div class="manage-nr">
          	
              <div class="cfg-header-bar" id="nav">
                  <a href="javascript:;" class="fr btn btn-primary radius mr-10 mt-6" onclick="window.location.reload()">刷新</a>
              </div>
              
               <!--基础信息开始-->
                  <div class="product-add-div">
                  	<ul class="info-item-block">
                  		<li>
                  			<span class="item-hd">甲板名称：</span>
                  			<div class="item-bd">
                  				<input type="text" name="title" id="title" class="input-text w400"  value="{$info['title']}" />
                  			</div>
                  		</li>
                  		<li>
                  			<span class="item-hd">舱房：</span>
                  			<div class="item-bd lh-30">
                  				{$info['rooms']}
                  			</div>
                  		</li>
                  		<li>
                  			<span class="item-hd">服务设施：</span>
                  			<div class="item-bd lh-30">
                  				{$info['facilities']}
                  			</div>
                  		</li>
                  		<li>
                  			<span class="item-hd">甲板位置：</span>
                  			<div class="item-bd">
                  				<div>
                                    <div id="pic_btn" class="btn btn-primary radius size-S mt-3">上传图片</div>
                                    <span class="item-text c-999 ml-10">建议上传尺寸宽830px以内</span>
                                </div>
                                  <div class="up-list-div">
                                      <input type="hidden" class="headimgindex" name="imgheadindex" value=""/>
                                      <input type="hidden" name="litpic" id="litpic" value="{$info['litpic']}"/>
                                      <ul class="pic-sel">

                                      </ul>
                                  </div>
                                  
                  			</div>
                  		</li>
                  	</ul>  

                  </div>
				
				<div class="fl clearfix pb-20">
                	<input type="hidden" name="shipid" id="shipid" value="{$shipid}"/>
                    <input type="hidden" name="id" id="productid"  value="{$info['id']}"/>
                    <input type="hidden" name="action" id="action" value="{$action}"/>
                    <a class="btn btn-primary radius size-L ml-115" id="btn_save" href="javascript:;">保存</a>
              	</div>
          </div>

        </form>
    </td>
    </tr>
    </table>

	<script>

	$(document).ready(function(){


        //上传图片
        $('#pic_btn').click(function(){
            ST.Util.showBox('上传图片', SITEURL + 'image/insert_view', 0,0, null, null, document, {loadWindow: window, loadCallback: Insert});
            function Insert(result,bool){
                var len=result.data.length;
                for(var i=0;i<len;i++){
                    var temp =result.data[i].split('$$');
                    Imageup.genePic(temp[0],".up-list-div ul",".cover-div");
                }
            }
        })
        //pdf附件
        setTimeout(function(){
            $('#attach_btn').uploadify({
                'swf': PUBLICURL + 'js/uploadify/uploadify.swf',
                'uploader': SITEURL + 'uploader/uploaddoc',
                'buttonImage' : PUBLICURL+'images/uploadfile.png',  //指定背景图
                'formData':{uploadcookie:"<?php echo Cookie::get('username')?>"},
                'fileTypeExts':'*.pdf',
                'auto': true,   //是否自动上传
                'removeTimeout':0.2,
                'height': 25,
                'width': 80,
                'onUploadSuccess': function (file, data, response) {


                    var info=$.parseJSON(data);
                    var html = '<a href="'+info.path+'" target="_blank">查看附件</a>&nbsp;';
                    $("#attachment").val(info.path);
                    if(action=='edit')
                        html+= '<a href="javascript:;" onclick="delAttach()">删除</a>'
                    $("#doclist").html(html);

                }
            });
        },10)



        //保存
        $("#btn_save").click(function(){

               var title = $("#title").val();

            //验证名称
             if(title==''){
                   $("#nav").find('span').first().trigger('click');
                   $("#title").focus();
                   ST.Util.showMsg('请填写楼层名称',5,2000);
               }
               else
               {
                   $.ajaxform({
                       url   :  SITEURL+"ship/admin/ship/ajax_floor_save",
                       method  :  "POST",
                       form  : "#product_frm",
                       dataType  :  "JSON",
                       success  :  function(data)
                       {

                           if(data.status)
                           {
                               if(data.productid!=null){
                                   $("#productid").val(data.productid);
                               }
                               ST.Util.showMsg('保存成功!','4',2000);
                           }
                       }});
               }
        })


        //如果是修改页面


        {if $action=='edit'}


            var litpic = $("#litpic").val();
            $(".img-li").find('img').each(function(i,item){

                        if($(item).attr('src')==litpic){
                            var obj = $(item).parent().find('.btn-ste')[0];
                            Imageup.setHead(obj,i+1);
                        }
            })



            var piclist = ST.Modify.getUploadFile({$info['piclist_arr']});

            $(".pic-sel").html(piclist);
            var litpic = $("#litpic").val();
            $(".img-li").find('img').each(function(i,item){

                if($(item).attr('src')==litpic){
                    var obj = $(item).parent().find('.btn-ste')[0];
                    Imageup.setHead(obj,i+1);
                }
            })
            window.image_index= $(".pic-sel").find('li').length;//已添加的图片数量
        {/if}
     });
     function showpic()
     {
         $("#updiv").show();
     }
     function unshowpic()
     {
         $("#updiv").hide();
     }

    </script>


</body>
</html>
