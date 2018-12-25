
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>会员中心</title>
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    {Common::css('style-new.css,mobilebone.css,swiper.min.css,certification.css,invoice.css')}
    {Common::js('lib-flexible.js')}
    {Common::js('jquery.min.js,mobilebone.js,swiper.min.js,jquery.validate.min.js,jquery.layer.js,template.js,layer/layer.m.js')}
</head>
<body>
<div id="{if $info['id']}editInvoice{else}addInvoice{/if}" class="page out">
    <div class="header_top bar-nav">
        <a class="back-link-icon" href="javascript:;" data-rel="back"></a>
        <h1 class="page-title-bar">{if empty($info)}新增{else}修改{/if}常用发票</h1>
    </div>
    <!-- 公用顶部 -->

    <div class="page-content invoice-list-content">
        <div class="invoice-container">
            <form class="invoice_edit_frm">
            <dl class="edit-invoice-con">
                <dd>
                    <span class="hd">发票类型</span>
                    <div class="bd mtype_con">
                        {if $info['id']}
                         <label>{if $info['type']==2}增值发票{else}普通发票{/if}</label>
                        {/if}
                        <label  {if $info['id']}style="display:none"{/if} data-val="1" {if $info['type']!=2}class="on"{/if}><i class="sel-ico"></i>普通发票</label>
                        <label {if $info['id']}style="display:none"{/if} data-val="2"{if $info['type']==2}class="on"{/if}><i class="sel-ico"></i>增值发票</label>
                    </div>
                </dd>
                <dd class="subtype_con">
                    <span class="hd">类型</span>
                    <div class="bd">
                        <label data-val="0" {if $info['type']==0}class="on"{/if}><i class="sel-ico"></i>个人</label>
                        <label data-val="1" {if $info['type']==1}class="on"{/if}><i class="sel-ico"></i>公司</label>
                    </div>
                </dd>
                <dd class="tp_item tp_0 tp_1">
                    <span class="hd">发票抬头</span>
                    <div class="bd">
                        <input type="text" class="txt" name="title" placeholder="" value="{$info['title']}"/>
                        <span class="tags ">必填</span>
                    </div>
                </dd>
                <dd class="tp_item tp_1">
                    <span class="hd">纳税人识别号</span>
                    <div class="bd">
                        <input type="text" class="txt" name="taxpayer_number" placeholder="" value="{$info['taxpayer_number']}"/>
                        <span class="tags">必填</span>
                    </div>
                </dd>
                <dd class="tp_item">
                    <span class="hd">地址</span>
                    <div class="bd">
                        <input type="text" name="taxpayer_address" class="txt" placeholder="" value="{$info['taxpayer_address']}"/>
                        <span class="tags">必填</span>
                    </div>
                </dd>
                <dd class="tp_item">
                    <span class="hd">联系电话</span>
                    <div class="bd">
                        <input type="text" name="taxpayer_phone" class="txt" placeholder="" value="{$info['taxpayer_phone']}"/>
                        <span class="tags">必填</span>
                    </div>
                </dd>
                <dd class="tp_item">
                    <span class="hd">开户网点</span>
                    <div class="bd">
                        <input type="text" name="bank_branch" class="txt" placeholder=""  value="{$info['bank_branch']}"/>
                        <span class="tags">必填</span>
                    </div>
                </dd>
                <dd class="tp_item">
                    <span class="hd">银行账号</span>
                    <div class="bd">
                        <input type="text" class="txt" name="bank_account" placeholder="" value="{$info['bank_account']}"/>
                        <span class="tags">必填</span>
                    </div>
                </dd>
            </dl>
             <input type="hidden" name="id" value="{$info['id']}"/>
            </form>
        </div>
    </div>

    <div class="btn-wrap">
        <a href="javascript:;" class="invo-btn invoice_add_edit_btn">保存</a>
    </div>
</div>
<script>
    var SITEURL="{$cmsurl}";
    var container = "#{if $info['id']}editInvoice{else}addInvoice{/if}";
    $(function(){

        $(container+" .edit-invoice-con dd .bd input").focus(function(){
            $(this).siblings(".tags").hide();
        });
        $(container+" .edit-invoice-con dd .bd input").blur(function(){
            var val=$(this).val();
            if(val==""){
                $(this).siblings(".tags").show();
            }
        });

        //切换样式
        $(container+" .invoice_edit_frm .mtype_con label,"+container+" .invoice_edit_frm .subtype_con label").click(function(){
             $(this).addClass('on').siblings('label').removeClass('on');
             tog_type();
        });

        //初次切换
        tog_type();

        //提交
        $(container+" .invoice_add_edit_btn").click(function(){
            var mtype=$(container+" .invoice_edit_frm .mtype_con label.on").attr('data-val');
            var subtype=$(container+" .invoice_edit_frm .subtype_con label.on").attr('data-val');
            var type = mtype==2?2:subtype;
            var title= $.trim($(container+" .invoice_edit_frm input[name=title]").val());
            var taxpayer_number=$.trim($(container+" .invoice_edit_frm input[name='taxpayer_number']").val());
            var taxpayer_address=$.trim($(container+" .invoice_edit_frm input[name='taxpayer_address']").val());
            var taxpayer_phone=$.trim($(container+" .invoice_edit_frm input[name='taxpayer_phone']").val());
            var bank_branch=$.trim($(container+" .invoice_edit_frm input[name='bank_branch']").val());
            var bank_account=$.trim($(container+" .invoice_edit_frm input[name='bank_account']").val());
            var id=$(container+" .invoice_edit_frm input[name=id]").val();

            try{
                if(!title)
                {
                    throw "发票抬头不能为空";
                }

                if(type!=0 && !taxpayer_number)
                {
                    throw "纳税人识别号不能为空";
                }

                if(type==2)
                {
                   if(!taxpayer_address)
                   {
                       throw "地址不能为空";
                   }
                   if(!taxpayer_phone)
                   {
                       throw "联系电话不能为空";
                   }
                   if(!is_phone(taxpayer_phone))
                   {
                       throw "联系电话格式错误";
                   }
                   if(!bank_branch)
                   {
                       throw "开户网点不能为空";
                   }
                   if(!bank_account)
                   {
                       throw "银行账号不能为空";
                   }
                }
                $.ajax({
                    url:SITEURL+'member/invoice/ajax_invoice_save',
                    type:'POST', //GET
                    data:{
                        mtype:mtype,
                        subtype:subtype,
                        id:id,
                        title:title,
                        taxpayer_number:taxpayer_number,
                        taxpayer_address:taxpayer_address,
                        taxpayer_phone:taxpayer_phone,
                        bank_branch:bank_branch,
                        bank_account:bank_account
                    },
                    dataType:'json',
                    success:function(data,textStatus,jqXHR)
                    {
                        if(data.status)
                        {
                            $.layer({
                                type:2,
                                text:data.msg,
                                time:1000
                            })


                            setTimeout(function(){
                                if(typeof(on_invoice_edited)=='function')
                                {
                                    on_invoice_edited();
                                }
                                window.history.back();

                                $("#addInvoice input").val('');



                            },1000);
                        }
                        else
                        {
                            $.layer({
                                type:2,
                                text:data.msg,
                                time:1000
                            })
                        }
                    }
                })
            }
            catch(e)
            {
                $.layer({
                    type:2,
                    text:e,
                    time:1000
                })
            }
        });







        //切换类型
        function tog_type()
        {
            var mtype=$(container+" .invoice_edit_frm .mtype_con label.on").attr('data-val');
            var subtype=$(container+" .invoice_edit_frm .subtype_con label.on").attr('data-val');
            if(mtype==2)
            {
                $(container+" .invoice_edit_frm dd").show();
                $(container+" .invoice_edit_frm .subtype_con").hide();
            }
            else
            {
                $(container+" .invoice_edit_frm dd.tp_item").hide();
                $(container+" .invoice_edit_frm .subtype_con").show();
                $(container+" .invoice_edit_frm .tp_"+subtype).show();
            }

        }

        //判断是否为手机
        function is_phone(value)
        {
            var mobile = /^1+\d{10}$/;
            var tel = /^\d{3,4}-?\d{7,9}$/;
            return tel.test(value) || mobile.test(value);
        }


    });
</script>

</body>
</html>