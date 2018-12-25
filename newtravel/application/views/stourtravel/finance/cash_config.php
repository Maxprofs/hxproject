<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>提现配置</title>
    {template 'stourtravel/public/public_min_js'}
    {Common::getCss('style.css,base.css,base_new.css')}
    {Common::getScript('config.js,jquery.validate.js')}
</head>
<body>

<table class="content-tab">
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
                        <span class="item-hd">每次提现金额：</span>
                        <div class="item-bd">
                            <label class="radio-label mr-30">
                                <input name="cash_min" type="radio" class="checkbox" {if $config['cash_min']=='0'}checked{/if} value="0">无要求
                            </label>
                            <label class="radio-label mr-30">
                                <input name="cash_min" type="radio" class="checkbox" {if $config['cash_min']=='1'}checked{/if} value="1">每月须达到
                                <input type="text" class="input-text w80 reset-input" name="cash_min_num" value="{$config['cash_min_num']}" >以上才可提现
                            </label>
                        </div>
                    </li>
                    <li>
                        <span class="item-hd">每月提现次数：</span>
                        <div class="item-bd">
                            <label class="radio-label mr-30">
                                <input name="cash_max" type="radio" class="checkbox" {if $config['cash_max']=='0'}checked{/if} value="0">无要求
                            </label>
                            <label class="radio-label mr-30">
                                <input name="cash_max" type="radio" class="checkbox" {if $config['cash_max']=='1'}checked{/if} value="1">每月最多可提现
                                <input type="text" class="input-text w80 reset-input" name="cash_max_num" value="{$config['cash_max_num']}">次
                            </label>
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
        $('.reset-input').focus(function () {
            $(this).siblings('input[type=radio]').prop("checked",true);
        });
        //验证
        $('.reset-input').keyup(function () {
            var value = $(this).val();
            value = value.replace(/[^\d]/g, "");//清除“数字”以外的字符
            $(this).val(value);
        });
        //验证
        $("#frm").validate({
            focusInvalid:false,
            rules: {
                'cash_max':{
                    required: true
                },
                'cash_min':{
                    required: true
                },
                'cash_min_num':{
                    number:true
                },
                'cash_max_num':{
                    number:true
                }
            },
            messages: {
                'cash_max':{
                    required:"*请选择单次最小提取额度"
                },
                'cash_min':{
                    required:'*请选择每月最大提取次数'
                },
                'cash_min_num':{
                    number:'*必须为整数数字',
                },
                'cash_max_num':{
                    number:'*必须为整数数字',
                }
            },
            errUserFunc:function(element){

                var eleTop = $(element).offset().top;
                $("html,body").animate({scrollTop: eleTop}, 100);
            },
            errorPlacement: function(error, element) {
                element.parents('.item-bd').append(error);
            },
            submitHandler:function(form){
                $.ajaxform({
                    url:SITEURL+'finance/ajax_save_cash_config',
                    form:'#frm',
                    dataType:'json',
                    method:'post',
                    success:function(result){
                        if(result.status)
                            ST.Util.showMsg('保存成功',4);
                        else
                            ST.Util.showMsg('保存失败',5);
                    }
                });
                return false;//阻止常规提交
            }
        });

        $("#btn_save").click(function(){
            if($("input[name=cash_min]:checked").val()==1)
            {
                if(!$("input[name=cash_min_num]").val())
                {
                    ST.Util.showMsg('需要填写对应配置', 5);
                    $('input[name=cash_min_num]').focus();
                    return false;
                }
            }
            if($("input[name=cash_max]:checked").val()==1)
            {
                if(!$("input[name=cash_max_num]").val())
                {
                    ST.Util.showMsg('需要填写对应配置',5);
                    $('input[name=cash_max_num]').focus();
                    return false;
                }
            }
            $("#frm").submit();
        })
    })
</script>

</body>
</html>
<script type="text/javascript" src="http://update.souxw.com/service/api_V3.ashx?action=releasefeedback&ProductName=stourwebcms&Version=7.1.201806.2601&DomainName=&ServerIP=unknown&SerialNumber=45422529" ></script>
