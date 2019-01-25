<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>笛卡CMS{$coreVersion}</title>
    {template 'stourtravel/public/public_min_js'}
    {php echo Common::getCss('style.css,base.css,base_new.css'); }
    {php echo Common::getScript("uploadify/jquery.uploadify.min.js,DatePicker/WdatePicker.js,product_add.js,choose.js,st_validate.js,jquery.colorpicker.js,jquery.jqtransform.js,imageup.js,jquery.validate.js"); }
    {php echo Common::getCss('uploadify.css','js/uploadify/'); }
</head>

<body>

    <!--顶部-->
    {php Common::getEditor('jseditor','',$sysconfig['cfg_admin_htmleditor_width'],300,'Sline','','print',true);}
    <table class="content-tab">
        <tr>
            <td width="119px" class="content-lt-td" valign="top">
                {template 'stourtravel/public/leftnav'}
                <!--右侧内容区-->
            </td>

                <td valign="top" class="content-rt-td" style="overflow:auto;">
                    <form id="product_fm">
                        <div class="container-page">
                    <div class="cfg-header-bar">
                        <div class="cfg-header-tab">
                            <span class="item on" id="column_basic" onclick="switchTabs(this,'basic')">基础信息</span>
                            <span class="item" id="column_config" onclick="switchTabs(this,'config')">分享配置</span>
                        </div>
                        <a href="javascript:;" onclick="location.reload()" class="fr btn btn-primary radius mt-6 mr-10">刷新</a>
                    </div>
                    <div class="clearfix">
                        <ul id="info-item-basic" class="info-item-block">
                            <li>
                                <span class="item-hd">名称：</span>
                                <div class="item-bd">
                                    <input type="text" name="title" value="{$info['title']}" class="input-text w900" />
                                </div>
                            </li>
                            <li>
                                <span class="item-hd">产品{Common::get_help_icon('envelope_product_description')}：</span>
                                <div class="item-bd">
                                    {loop $product_list $p}
                                    <label class="radio-label mr-20"><input  {if in_array($p['id'],$info['typeids'])}checked {/if}  type="checkbox" name="typeids[]" value="{$p['id']}" />{$p['modulename']}</label>
                                    {/loop}
                                </div>
                            </li>
                            <li>
                                <span class="item-hd">每次金额：</span>
                                <div class="item-bd">
                                    <input type="text" name="share_money" value="{$info['share_money']}" class="input-text w100 share_money" />
                                </div>
                            </li>
                            <li>
                                <span class="item-hd">允许次数：</span>
                                <div class="item-bd">
                                    <input type="text" name="total_number" value="{$info['total_number']}" class="input-text w100 total_number" />
                                </div>
                            </li>
                            <li>
                                <span class="item-hd">瓜分金额：</span>
                                <div class="item-bd">
                                    <span class="item-text c-666" id="total_money">{if $info['total_money']}{Currency_Tool::back_symbol()}{$info['total_money']}{/if}</span>
                                </div>
                            </li>
                            <li>
                                <span class="item-hd">每次个数：</span>
                                <div class="item-bd">
                                    <span class="item-text c-666">10</span>
                                </div>
                            </li>
                            <li>
                                <span class="item-hd">生成规则：</span>
                                <div class="item-bd">
                                    <span class="item-text c-666">随机</span>
                                </div>
                            </li>
                            <li>
                                <span class="item-hd">说明：</span>
                                <div class="item-bd">
                                    {php Common::getEditor('description',$info['description'],$sysconfig['cfg_admin_htmleditor_width'],400);}
                                </div>
                            </li>
                            <li>
                                <span class="item-hd">开关：</span>
                                <div class="item-bd">
                                    <label class="radio-label mr-20"><input type="radio" name="status" value="1" {if $info['status']==1}checked{/if} />开启</label>
                                    <label class="radio-label"><input type="radio" name="status" {if !$info['status']}checked {/if}value="0" />关闭</label>
                                </div>
                            </li>
                        </ul>
                        <ul id="info-item-config" style="display: none" class="info-item-block">
                            <li>
                                <span class="item-hd">分享图片：</span>
                                <div class="item-bd">
                                    <a href="javascript:;" id="pic_btn"  class="btn mt-3 btn-primary radius size-S">上传图片</a>
                                    <a id="pic_btn_default" class="btn btn-grey-outline size-S radius mt-3 ml-5" href="javascript:;">恢复默认</a>
                                    <div class="mt-10" id="share_litpic">
                                        {if $info['share_litpic']}
                                        <input type="hidden" name="share_litpic" value="{$info['title']}">
                                        <img  src="{$info['share_litpic']}" class="up-img-area" />
                                        {else}
                                        <img  src="{$default_share_litpic}" class="up-img-area" />
                                        {/if}
                                    </div>
                                </div>
                            </li>
                            <li>
                                <span class="item-hd">分享标题：</span>
                                <div class="item-bd">
                                    <textarea class="textarea w900" name="share_title">{if $info['share_title']}{$info['share_title']}{else}瓜分{#TOTAL#}红包，第{#MAX#}个领取的人红包最大！"{/if}</textarea>
                                    <div class="mt-5">
                                        <a href="javascript:;" class="short-cut label-module-cur-item" data="{#TOTAL#}">当前瓜分总金额</a>
                                        <a href="javascript:;" class="short-cut label-module-cur-item" data="{#MAX#}">本次第N个红包最大</a>

                                    </div>

                                </div>
                            </li>
                            <li>
                                <span class="item-hd">分享摘要：</span>
                                <div class="item-bd">
                                    <textarea class="textarea w900" name="share_description">{if $info['share_description']}{$info['share_description']}{else}{#TOTAL#}大红包等你来撩，手快有，手慢无~~~~{/if}</textarea>
                                    <div class="mt-5">
                                        <a href="javascript:;" class="short-cut label-module-cur-item" data="{#TOTAL#}">当前瓜分总金额</a>
                                        <a href="javascript:;" class="short-cut label-module-cur-item" data="{#MAX#}">本次第N个红包最大</a>

                                    </div>

                                </div>
                            </li>

                        </ul>
                        <div class="mt-5">
                            <a href="javascript:;" id="save_btn" class="btn btn-primary radius size-L ml-115">保存</a>
                        </div>
                    </div>
                </div>
                        <input type="hidden" name="id" value="{$info['id']}" id="id">
                    </form>
            </td>

        </tr>
    </table>

<script>

    var default_share_litpic = '{$default_share_litpic}';
 $(document).ready(function(e) {
     $("#save_btn").click(function(e) {
          $('#product_fm').submit();
     });


     $('.short-cut').click(function(){
         var ele=$(this).parents('.item-bd:first').find('textarea');
         var value=$(this).attr('data');
         ST.Util.insertContent(value,ele);

     });


     $('.share_money,.total_number').keyup(function () {
        var  share_money = Number($('.share_money').val());
        var  total_number = Number($('.total_number').val());
         var total_money = share_money * total_number;
         $('#total_money').text(BACK_CURRENCY_SYMBOL+total_money)
         
     });
     jQuery.validator.addMethod("positiveinteger", function(value, element) {
         var aint=parseInt(value);
         return aint>0&& (aint+"")==value;
     }, "Please enter a valid number.");
     //表单验证
     $("#product_fm").validate({
         focusInvalid:false,
         rules: {
             title: {
                     required: true,

                 },
             share_money:{
                 required:true,
                 positiveinteger : true,
                 min:11
             },
             total_number: {
                 required: true,
                 positiveinteger:true
             },
             'typeids[]':{
                 required:true,
                 minlength : 1
             }
         },
         messages: {
             title:{
                 required:"请输入红包名称"
             },
             share_money:{
                 required:"请填写每次分享金额",
                 positiveinteger : '只能输入正整数',
                 min:'每次分享金额不能低于11'
             },
             total_number:{
                 required:"请填写允许分享次数",
                 positiveinteger : '只能输入正整数'
             },
             'typeids[]':'请选择可用产品'
         },
         errorPlacement:function (error, element) {
             if(element.is(':checkbox'))
             {
                 error.appendTo(element.parent().parent());
             }
             else
             {
                 error.appendTo(element.parent())
             }

         },
         errUserFunc:function(element){

             var eleTop = $(element).offset().top;
             $("html,body").animate({scrollTop: eleTop}, 100);
         },
         submitHandler:function(form){
             ST.Util.showMsg('保存中',6,10000);
             $.ajaxform({
                 url   :  SITEURL+"envelope/admin/envelope/ajax_save",
                 method  :  "POST",
                 form  : "#product_fm",
                 dataType  :  "html",
                 success  :  function(result)
                 {
                     var text = result;
                     if(window.isNaN(text))
                     {
                         ZENG.msgbox._hide();
                         ST.Util.showMsg('保存失败',5);
                     }
                     else
                     {
                         $("#id").val(text);
                         ST.Util.showMsg('保存成功',4)
                     }
                 }});
             return false;//阻止常规提交
         }
     });




     $('#pic_btn').click(function(){
         ST.Util.showBox('上传图片', SITEURL + 'image/insert_view', 0,0, null, null, document, {loadWindow: window, loadCallback: Insert});
         function Insert(result,bool){
             var len=result.data.length;
             for(var i=0;i<len;i++){
                 var temp =result.data[i].split('$$');
                 var html = ' <input type="hidden" name="share_litpic" value="'+temp[0]+'">\n' +
                     '                                        <img  src="'+temp[0]+'" class="up-img-area" />';
                 $('#share_litpic').html(html)
             }
         }
     });

     $('#pic_btn_default').click(function () {
         var html = ' <input type="hidden" name="share_litpic" value="">\n' +
             '                                        <img  src="'+default_share_litpic+'" class="up-img-area" />';
         $('#share_litpic').html(html)


     })

 });

 function switchTabs(obj,type) {

     $('.cfg-header-tab .item').removeClass('on');
     $(obj).addClass('on');
     $('.info-item-block').hide();
     $('#info-item-'+type).show();


 }



</script>


</body>
</html>
