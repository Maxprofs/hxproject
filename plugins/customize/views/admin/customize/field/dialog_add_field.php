<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>笛卡CMS{$coreVersion}</title>
    {template 'stourtravel/public/public_min_js'}
    {php echo Common::getCss('style.css,base.css'); }
    {php echo Common::getScript("jquery.validate.js"); }
    <style>
        .error{
            color:red;
            padding-left:5px;
        }
        .opclose{display: none}
    </style>
</head>
<body style="background-color: #fff">
   <form id="frm" name="frm">
    <div class="out-box-con">
        <dl class="list_dl">
            <dt class="wid_90">字段名称：</dt>
            <dd>
                 <input type="text" class="set-text-xh mt-4 w160" name="fieldname" id="fieldname" value="" >
            </dd>
        </dl>
        <dl class="list_dl">
            <dt class="wid_90">字段中文名：</dt>
            <dd><input type="text" class="set-text-xh w160 mt-4" name="chinesename" id="chinesename" value="" ></dd>
        </dl>

        <dl class="list_dl">
            <dt class="wid_90">&nbsp;</dt>
            <dd>
                <a class="default-btn wid_60" id="btn_save" href="javascript:;">保存</a>
            </dd>
        </dl>
    </div>
   </form>

<script language="JavaScript">
    //字段验证
    jQuery.validator.addMethod("isfield", function(value, element) {
        var v = /^[a-zA-Z]{1}([a-zA-Z0-9]|[_]){0,19}$/;
        return this.optional(element) || (v.test(value));
    }, "字段名称不正确");
    jQuery.validator.addMethod("chinese", function(value, element) {
        var chinese = /^[\u4e00-\u9fa5]+$/;
        return this.optional(element) || (chinese.test(value));
    }, "只能输入中文");

    //表单验证
    $("#frm").validate({

        focusInvalid:false,
        rules: {
            fieldname:
            {
                required: true,
                isfield:true,
                minlength:1,
                maxlength:20,
                remote:
                {
                    type:"POST",
                    url:SITEURL+'customize/admin/field/ajax_field_check',
                    data:
                    {
                        fieldname:function()
                        {
                            return $("#fieldname").val()
                        },
                        typeid:function(){

                            return $("#typeid").val();
                        }
                    }
                }


            },
            chinesename: {
                required: true,
                chinese: true

            }

        },
        messages: {

            fieldname:{
                required:"请输入字段名称",
                isfield:'字段名称不正确',
                minlength:'字段名长度必须为1-20位',
                maxlength:'字段名长度必须为1-20位',
                remote:'字段名重复'

            },

            fieldtype: {
                required:"请选择字段类型"

            },
            chinesename: {
                required: "请填写字段别名",
                chinese: "只能输入中文"

            }
        },
        errUserFunc:function(element){
        },
        submitHandler:function(form){
            $.ajaxform({
                url   :  SITEURL+"customize/admin/field/ajax_field_save",
                method  :  "POST",
                form  : "#frm",
                dataType: 'json',
                success  :  function(data)
                {
                    if(data.status)
                    {
                        ST.Util.responseDialog('',true);
                        ST.Util.showMsg('保存成功!','4',2000);
                    }
                    else
                    {
                        ST.Util.showMsg(data.msg,'5',1500);
                    }
                }});
            return false;//阻止常规提交
       }
    });

    $(function(){
        //保存
        $("#btn_save").click(function(){
            $("#frm").submit();
            return false;
        })
    })


</script>

</body>
</html>