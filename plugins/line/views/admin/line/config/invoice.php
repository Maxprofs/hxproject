<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>附加选项</title>
    {template 'stourtravel/public/public_min_js'}
    {Common::getCss('style.css,base.css,base_new.css')}
    {Common::getScript('config.js,jquery.validate.js')}
</head>
<body>

<table class="content-tab" margin_html=KGACXC >
    <tr>
        <td width="119px" class="content-lt-td"  valign="top">
            {template 'stourtravel/public/leftnav'}
            <!--右侧内容区-->
        </td>
        <td valign="top" class="content-rt-td">
            <form id="frm">
                <div class="cfg-header-bar">
                    <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
                </div>
                <ul class="info-item-block">
                    <li>
                        <span class="item-hd">发票开关：</span>
                        <div class="item-bd">
                            <label class="radio-label"><input type="radio" name="cfg_invoice_open_1" value="1" {if $info['cfg_invoice_open_1']==1}checked="checked"{/if}>开启</label>
                            <label class="radio-label ml-20"><input type="radio" name="cfg_invoice_open_1" value="0" {if $info['cfg_invoice_open_1']==0}checked="checked"{/if}>关闭</label>
                        </div>
                    </li>
                    <li>
                        <span class="item-hd"><i class="star-note-ico mr-5">*</i>发票类型：</span>
                        <div class="item-bd">
                            <label class="check-label"><input type="checkbox" name="cfg_invoice_type_1[]" {if in_array(1,$info['cfg_invoice_type_1_arr'])}checked="checked"{/if} value="1">普通发票</label>
                            <label class="check-label ml-20"><input type="checkbox" {if in_array(2,$info['cfg_invoice_type_1_arr'])}checked="checked"{/if} name="cfg_invoice_type_1[]" value="2">增值专票</label>
                        </div>
                    </li>
                    <li>
                        <span class="item-hd"><i class="star-note-ico mr-5">*</i>发票明细：</span>
                        <div class="item-bd">
                            <input type="text" name="cfg_invoice_content_1" value="{$info['cfg_invoice_content_1']}" class="input-text w500">  <span class="c-999">多个明细请用英文逗号隔开</span>
                        </div>
                    </li>
                    <li>
                        <span class="item-hd">发票说明<!-- 有一个帮助图标 -->：</span>
                        <div class="item-bd">
                            <textarea class="textarea w500" name="cfg_invoice_des_1" cols="" rows="">{$info['cfg_invoice_des_1']}</textarea>
                        </div>
                    </li>
                </ul>
                <div class="btn-wrap mt-25">
                    <a class="btn btn-primary radius size-L ml-115" id="btn_save" href="javascript:;">保存</a>
                </div>
            </form>
        </td>
    </tr>
</table>

<script>

    $(document).ready(function(){
        //验证
        $("#frm").validate({
            focusInvalid:false,
            rules: {
                'cfg_invoice_type_1[]':
                {
                    required: function(){
                        return $("input[name=cfg_invoice_open_1]:checked").val()==1;
                    }
                },
                'cfg_invoice_content_1':{
                    required:function(){
                        return $("input[name=cfg_invoice_open_1]:checked").val()==1;
                    }
                }
            },
            messages: {
                'cfg_invoice_type_1[]':{
                    required:"请选择发票类型"
                },
                'cfg_invoice_content_1':{
                    required:'请填写发票明细'
                }
            },
            errUserFunc:function(element){

                var eleTop = $(element).offset().top;
                $("html,body").animate({scrollTop: eleTop}, 100);
            },
            errorPlacement: function(error, element) {
                if(element.is("input[name^='cfg_invoice_type_1']"))
                {
                    element.parents('.item-bd').append(error);
                }
                else
                {
                    error.insertAfter(element);
                }
            },
            submitHandler:function(form){

                $.ajaxform({
                    url:SITEURL+'line/admin/config/ajax_invoice_save',
                    form:'#frm',
                    dataType:'json',
                    method:'post',
                    success:function(result){
                        if(result.status)
                            ST.Util.showMsg('保存成功',4);
                        else
                            ST.Util.showMsg('保存失败',5)
                    }
                })
                return false;//阻止常规提交
            }
        });


        $("#btn_save").click(function(){
            $("#frm").submit();
        })
    })
</script>

</body>
</html>
