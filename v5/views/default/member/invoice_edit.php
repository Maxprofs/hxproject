<!doctype html>
<html>

	<head>
		<meta charset="utf-8">
        <title>{__('添加或修改发票')}-{$webname}</title>
        {include "pub/varname"}
        {Common::css('user.css,base.css,extend.css,invoice.css')}
        {Common::js('jquery.min.js,base.js,common.js,jquery.validate.js,jquery.validate.addcheck.js')}
	</head>

	<body>

    {request "pub/header"}

		<div class="big">
			<div class="wm-1200">

				<div class="st-main-page">

                    {include "member/left_menu"}

                    <div class="user-invoice-wrap fr">
                        <div class="invoice-info">
                            <form id="frm">
                            <h3 class="title">{if empty($info)}新增{else}修改{/if}发票信息</h3>
                            <ul class="invoice-item" id="invoice_con">
                                <li>
                                    <span class="item-bt">发票类型：</span>
                                    <div class="item-nr">
                                        <label><input type="radio"  name="mtype" value="1" {if $info['type']!=2}checked="checked"{/if}>普通发票</label>
                                        <label><input type="radio" name="mtype" {if $info['type']==2}checked="checked"{/if} value="2">增值发票</label>
                                    </div>
                                </li>
                                <li class="sub_type">
                                    <span class="item-bt">类型：</span>
                                    <div class="item-nr">
                                        <label><input type="radio" name="subtype" value="0" {if $info['type']!=1}checked="checked"{/if}>个人</label>
                                        <label><input type="radio" name="subtype" value="1" {if $info['type']==1}checked="checked"{/if}>公司</label>
                                    </div>
                                </li>
                                <li class="tp_0 tp_1 tp_item">
                                    <span class="item-bt"><i>*</i>&nbsp;发票抬头：</span>
                                    <div class="item-nr">
                                        <input type="text" class="input-text fl" name="title" placeholder="请填写公司全称" value="{$info['title']}">
                                    </div>
                                </li>
                                <li class="tp_1 tp_item">
                                    <span class="item-bt"><i>*</i>&nbsp;纳税人识别号：</span>
                                    <div class="item-nr">
                                        <input type="text" class="input-text fl" name="taxpayer_number"  placeholder="纳税人识别号" value="{$info['taxpayer_number']}">
                                    </div>
                                </li>
                                <li class="tp_item">
                                    <span class="item-bt"><i>*</i>&nbsp;地址：</span>
                                    <div class="item-nr">
                                        <input type="text" name="taxpayer_address" class="input-text fl" placeholder="请填写公司地址" value="{$info['taxpayer_address']}">
                                    </div>
                                </li>
                                <li class="tp_item">
                                    <span class="item-bt"><i>*</i>&nbsp;联系电话：</span>
                                    <div class="item-nr">
                                        <input type="text" name="taxpayer_phone" class="input-text fl" placeholder="请填写公司电话" value="{$info['taxpayer_phone']}">
                                    </div>
                                </li>
                                <li class="tp_item">
                                    <span class="item-bt"><i>*</i>&nbsp;开户网点：</span>
                                    <div class="item-nr">
                                        <input type="text" name="bank_branch" class="input-text fl" placeholder="请填写公司开户行" value="{$info['bank_branch']}">
                                    </div>
                                </li>
                                <li class="tp_item">
                                    <span class="item-bt"><i>*</i>&nbsp;银行账号：</span>
                                    <div class="item-nr">
                                        <input type="text" name="bank_account" class="input-text fl" placeholder="请填写公司开户账户号" value="{$info['bank_account']}">
                                    </div>
                                </li>
                            </ul>
                            <div class="btn-wrap">
                                <a href="/member/index/invoice" class="cancel-btn">取消</a>
                                <a href="javascript:;" class="confirm-btn">确认</a>
                            </div>
                             <input type="hidden" id="invoice_id" name="id" value="{$info['id']}"/>
                            </form>
                        </div>
                    </div>
				</div>
			</div>
		</div>
    {request "pub/footer"}
    {Common::js('layer/layer.js')}
		<!--友情链接-->



		<script>
			$(function() {

                //左侧菜单选中
                $("#nav_invoice").addClass('on');
                if(typeof(on_leftmenu_choosed)=='function')
                {
                    on_leftmenu_choosed();
                }

                //初始化
                $("input[name=mtype],input[name=subtype]").change(function(){
                    tog_type();
                });
                //第一次调用
                tog_type();


                //删除发票
                $(".del-btn").click(function(){
                    var id=$(this).attr('data-id');
                    parent.layer.open({
                        type: 1,
                        title: "删除",
                        area: ['480px', '250px'],
                        content: '确定删除该发票',
                        btn: ['确认', '取消'],
                        btnAlign: 'c',
                        closeBtn: 0,
                        yes: function (index, b) {
                            parent.layer.close(index);
                        }
                    });
                });


                //发票验证
                $("#frm").validate({
                    focusInvalid:false,
                    rules: {
                        'title':
                        {
                            required: true
                        },
                        taxpayer_number:{
                            required:true
                        },
                        taxpayer_address:{
                            required:true
                        },
                        taxpayer_phone:{
                            required:true,
                            isPhone:true
                        },
                        bank_branch:{
                            required:true
                        },
                        bank_account:{
                            required:true
                        }
                    },
                    messages: {
                        'title':{
                            required:"必填"
                        },
                        'taxpayer_number':{
                            required:"必填"
                        },
                        'taxpayer_address':{
                            required:"必填"
                        },
                        'taxpayer_phone':{
                            required:"必填"
                        },
                        'bank_branch':{
                            required:"必填"
                        },
                        'bank_account':{
                            required:"必填"
                        }
                    },
                   /* errUserFunc:function(element){
                        var eleTop = $(element).offset().top;
                        $("html,body").animate({scrollTop: eleTop}, 100);
                    },*/
                   /* errorPlacement: function(error, element) {
                        if(element.is("input[name^='cfg_invoice_type_1']"))
                        {
                            element.parents('.item-bd').append(error);
                        }
                        else
                        {
                            error.insertAfter(element);
                        }
                    },*/
                    submitHandler:function(form){

                        $.ajax({
                            type:'post',
                            url:SITEURL+'member/index/ajax_invoice_save',
                            data:$("#frm").serialize(),
                            dataType:'json',
                            success:function(data){
                                if(data.status){
                                    layer.msg("保存成功",{
                                        icon:6,
                                        time:1000
                                    });
                                    $("#invoice_id").val(data.id);
                                }else{
                                    layer.msg(data.msg, {icon:5});
                                    return false;
                                }
                            }
                        })
                        return false;//阻止常规提交
                    }
                });



                //保存发票
                $('.confirm-btn').click(function(){
                    $("#frm").submit();
                });



                function tog_type()
                {
                    var mtype=$('input[name=mtype]:checked').val();
                    var subtype=$('input[name=subtype]:checked').val();
                    if(mtype==2)
                    {
                        $("#invoice_con li").show();
                        $("#invoice_con .sub_type").hide();
                    }
                    else
                    {
                        $("#invoice_con li.tp_item").hide();
                        $("#invoice_con .sub_type").show();
                        $("#invoice_con .tp_"+subtype).show();
                    }
                }
			});
		</script>

	</body>

</html>