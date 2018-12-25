<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>笛卡CMS{$coreVersion}</title>
    {template 'stourtravel/public/public_min_js'}
    {php echo Common::getScript("jquery.upload.js"); }
    {php echo Common::getScript("jquery.validate.js"); }
    {php echo Common::getCss('style.css,base.css,base_new.css'); }
</head>

<body style="background-color: #fff">
       <form name="seofrm" id="seofrm">
         <div class="w-set-con" style="margin: 0">
          <div class="w-set-nr" style="padding:0">
              <div class="nr-list" style="width: 160px">
                  <h4 class="tit"><span class="fl">国家封面图：</span></h4>
                  <div class="txt">
                      <a href="javascript:;" id="file_upload_litpic" class="btn btn-primary radius size-S">上传图片</a>
                      <span class="tip-img-size tip-img-padding0">(1024*695px)</span>
                  </div>

                  <div class="logolist">

                      <img src="" id="litpic_cover" width="80" height="60" style="margin: 3px;">
                      <a style="cursor:pointer;" onClick="delImage('litpic_cover','litpic')")>删除</a>

                  </div>
              </div>
              <div class="nr-list" style="width: 160px">
                  <h4 class="tit"><span class="fl">国家国旗：</span></h4>
                  <div class="txt">
                      <a href="javascript:;" id="file_upload_guoqi" class="btn btn-primary radius size-S">上传图片</a>
                      <span class="tip-img-size tip-img-padding0">(124*124px)</span>
                  </div>
                  <div class="logolist">

                      <img src="" id="litpic_guoqi" width="80" height="60" style="margin: 3px;">
                      <a style="cursor:pointer;" onClick="delImage('litpic_guoqi','countrypic')")>删除</a>

                  </div>
              </div>
              <div class="nr-list" style="width: 160px">
                  <h4 class="tit"><span class="fl">国家栏目页背景图：</span></h4>
                  <div class="txt">
                      <a href="javascript:;" id="file_upload_bg" class="btn btn-primary radius size-S">上传图片</a>
                      <span class="tip-img-size tip-img-padding0">(1200*280px)</span>
                  </div>
                  <div class="logolist">

                      <img src="" id="litpic_bg" width="80" height="60" style="margin: 3px;">
                      <a style="cursor:pointer;" onClick="delImage('litpic_bg','bigpic')")>删除</a>

                  </div>
              </div>

          	<div class="nr-list">
               <h4 class="tit"><span class="fl">优化标题：</span><div class="help-ico"><img class="fl" src="{$GLOBALS['cfg_public_url']}images/help-ico.png" alt="帮助" title="帮助"></div></h4>
              <div class="txt">
              	<input type="text" name="seotitle" id="seotitle" class="set-text-xh set-text-bz3" value="{$seoinfo['seotitle']}" />
              </div>
            </div>
              <div class="nr-list">
                  <h4 class="tit"><span class="fl">关键词：</span><div class="help-ico"><img class="fl" src="{$GLOBALS['cfg_public_url']}images/help-ico.png" alt="帮助" title="帮助"></div></h4>
                  <div class="txt">
                      <input type="text" id="keyword" name="keyword" class="set-text set-text-xh set-text-bz3" value="{$seoinfo['keyword']}" />

                  </div>
              </div>
              <div class="nr-list">
                  <h4 class="tit"><span class="fl">描述：</span><div class="help-ico"><img class="fl" src="{$GLOBALS['cfg_public_url']}images/help-ico.png" alt="帮助" title="帮助"></div></h4>
                  <div class="txt">
                      <textarea name="description" cols="3" style="width:500px;height: 60px; padding:3px;">{$seoinfo['description']}</textarea>

                  </div>
              </div>
              <div class="nr-list">
                  <h4 class="tit"><span class="fl">介绍：</span><div class="help-ico"><img class="fl" src="{$GLOBALS['cfg_public_url']}images/help-ico.png" alt="帮助" title="帮助"></div></h4>
                  <div class="txt">
                      {php Common::getEditor('jieshao',$seoinfo['jieshao'],500,200,'Line');}
                  </div>
              </div>
              <div class="nr-list">
                  <h4 class="tit"><span class="fl">英文：</span><div class="help-ico"></div></h4>
                  <div class="txt">
                      <input type="text" name="english" id="english" class=" w200 set-text-xh"  value="{$seoinfo['english']}" />
                  </div>
              </div>


            <div class="opn-btn">
            	<a class="save" href="javascript:;"  id="btn_save">保存</a>
             <!-- <a class="cancel" href="#">取消</a>-->
            </div>

          </div>
        </div>
           <input type="hidden" id="kindname" name="kindname"  value="{$seoinfo['kindname']}">
           <input type="hidden" id="countryid" name="countryid"  value="{$seoinfo['id']}">
           <input type="hidden" id="cfg_litpic_cover" name="cfg_litpic_cover"  value="{$seoinfo['litpic']}">
           <input type="hidden" id="cfg_litpic_guoqi" name="cfg_litpic_guoqi"  value="{$seoinfo['countrypic']}">
           <input type="hidden" id="cfg_litpic_bg" name="cfg_litpic_bg"  value="{$seoinfo['bigpic']}">

        </form>




    <script>
       $('#btn_save').click(function(){


           $("#seofrm").submit();


       })


       jQuery.validator.addMethod("isenglish",
           function (value, element)
           {
              return /^[A-Za-z][A-Za-z0-9\s]*$/.test(value);
           },
           "请填写小写字母或小写字母与数字的组合");

       //表单验证
       $("#seofrm").validate({

           focusInvalid:false,
           rules: {
               english:
               {
                   required: true,
                   isenglish:true,
                   remote:
                   {
                       type:"POST",
                       url:SITEURL+'visa/admin/visa/ajax_check_area_english',
                       data:
                       {
                           countryid:function()
                           {
                               return $("#countryid").val()
                           },
                           english:function()
                           {
                               return $("#english").val();
                           }
                       }
                   }
               }
           },
           messages: {
               english:{
                   required:"请输入拼音",
                   remote:"该拼音已被使用"
               }

           },
           submitHandler:function(form)
           {
               var ajaxurl = SITEURL+'visa/admin/visa/ajax_config_save';
               $.ajaxform({
                   url: ajaxurl,
                   method: 'POST',
                   form : '#seofrm',
                   dataType:'json',
                   success: function (data) {
                       if(data.status)
                       {
                           ST.Util.showMsg('保存成功',4);
                       }
                   }
               });
               return false;//阻止常规提交
           }
       });

       //图片上传
       $(function(){

           //图片显示
           var cfg_litpic_cover = $("#cfg_litpic_cover").val();
           var cfg_litpic_guoqi = $("#cfg_litpic_guoqi").val();
           var cfg_litpic_bg = $("#cfg_litpic_bg").val();
           if(cfg_litpic_cover!='')
           {
               $("#litpic_cover").attr('src',cfg_litpic_cover);
           }

           else
           {
               $("#litpic_cover").attr('src',SITEURL+'public/images/nopic.jpg');
           }
           if(cfg_litpic_guoqi!='')
           {
               $("#litpic_guoqi").attr('src',cfg_litpic_guoqi);
           }

           else
           {
               $("#litpic_guoqi").attr('src',SITEURL+'public/images/nopic.jpg');
           }
           if(cfg_litpic_bg!='')
           {
               $("#litpic_bg").attr('src',cfg_litpic_bg);
           }

           else
           {
               $("#litpic_bg").attr('src',SITEURL+'public/images/nopic.jpg');
           }

           //国家封面图片上传
            $('#file_upload_litpic').click(function () {
                uploadImg($('#litpic_cover'), $('#cfg_litpic_cover'));
            });

           //国旗上传
           $('#file_upload_guoqi').click(function () {
               uploadImg($('#litpic_guoqi'), $('#cfg_litpic_guoqi'));
           });

           //国家搜索页面顶部背景上传
           $('#file_upload_bg').click(function () {
               uploadImg($('#litpic_bg'), $('#cfg_litpic_bg'));
           });

       });

       //删除图片
       function delImage(id,field)
       {
           var $image = $("#cfg_"+id).val();
           var countryid = $("#countryid").val();

           $.ajax({
               type:'POST',
               url:SITEURL+'visa/admin/visa/ajax_del_image',
               data:{countryid:countryid,field:field,image:$image},
               dataType:'json',
               success:function(data){
                    if(data.status==1){
                        $("#"+id).attr('src',SITEURL+'public/images/nopic.jpg');
                        $("#cfg_"+id).val('');
                    }
               }
           })

       }

       //上传图片
        function uploadImg($img, $hide) {
            $.upload({
                // 上传地址
                url: SITEURL+'uploader/uploadfile',
                // 文件域名字
                fileName: 'Filedata',
                fileType: 'jpg,png,gif',
                // 其他表单数据
                params: {uploadcookie:"<?php echo Cookie::get('username')?>"},
                // 上传完成后, 返回json, text
                dataType: 'json',
                // 上传之前回调,return true表示可继续上传
                onSend: function() {
                    return true;
                },
                // 上传之后回调
                onComplate: function(info) {

                    if (info.success == 'true'){
                        $img.attr('src', info.bigpic);
                        $hide.val(info.bigpic);
                    }
                }
            });
        }

     </script>

</body>
</html>
