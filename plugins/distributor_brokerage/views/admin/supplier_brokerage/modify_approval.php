<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>线路订单管理-笛卡CMS{$coreVersion}</title>
    {template 'stourtravel/public/public_js'}
    {php echo Common::getCss('style.css,base.css,base_new.css'); }
    {php echo Common::getScript('config.js');}
</head>
<body style="overflow:hidden">

    <table class="content-tab">
        <tr>
            <td width="119px" class="content-lt-td" valign="top">
                {template 'stourtravel/public/leftnav'}
                <!--右侧内容区-->
            </td>
            <td valign="top" class="content-rt-td" style="overflow:hidden">
                <div class="container-page">
                    <div class="cfg-header-bar">
                        <a href="javascript:;" class="fr btn btn-primary radius mt-4 mr-10" onclick="window.location.reload()">刷新</a>
                    </div>
                    <div class="clearfix">
                        <form id="configfrm">
                            <ul class="info-item-block">
                                <li>
                                    <span class="item-hd">商家名称：</span>
                                    <div class="item-bd">
                                        <span class="item-text va-t">{$info['distributorname']}</span>
                                    </div>
                                </li>
                                <li>
                                    <span class="item-hd">申请时间：</span>
                                    <div class="item-bd">
                                        <span class="item-text va-t">{date('Y-m-d H:i:s',$info['addtime'])}</span>
                                    </div>
                                </li>
                                <li>
                                    <span class="item-hd">提现金额：</span>
                                    <div class="item-bd">
                                        <span class="item-text va-t c-f60">{$info['withdrawamount']}</span>
                                    </div>
                                </li>
                                <li>
                                    <span class="item-hd">可提现金额：</span>
                                    <div class="item-bd">
                                        <span class="item-text va-t">{$info['allow_price']}</span>
                                    </div>
                                </li>
                                <li>
                                    <span class="item-hd">已提现金额：</span>
                                    <div class="item-bd">
                                        <span class="item-text va-t">{$info['withdraw_price_finish']}</span>
                                    </div>
                                </li>
                                <li>
                                    <span class="item-hd">提现到：</span>
                                    <div class="item-bd">
                                        <span class="item-text va-t">{$info['proceeds_type_title']}</span>
                                    </div>
                                </li>
                                {if $info['alipayaccount']}
                                <li>
                                    <span class="item-hd">支付宝账户：</span>
                                    <div class="item-bd">
                                        <span class="item-text va-t">{$info['alipayaccount']}</span>
                                    </div>
                                </li>
                                {/if}
                                {if $info['alipayaccountname']}
                                <li>
                                    <span class="item-hd">支付宝账户名：</span>
                                    <div class="item-bd">
                                        <span class="item-text va-t">{$info['alipayaccountname']}</span>
                                    </div>
                                </li>
                                {/if}
                                {if $info['wechataccount']}
                                <li>
                                    <span class="item-hd">微信账号：</span>
                                    <div class="item-bd">
                                        <span class="item-text va-t">{$info['wechataccount']}</span>
                                    </div>
                                </li>
                                {/if}
                                {if $info['bankcardnumber']}
                                <li>
                                    <span class="item-hd">银行卡号：</span>
                                    <div class="item-bd">
                                        <span class="item-text va-t">{$info['bankcardnumber']}</span>
                                    </div>
                                </li>
                                <li>
                                    <span class="item-hd">银行卡户名：</span>
                                    <div class="item-bd">
                                        <span class="item-text va-t">{$info['bankaccountname']}</span>
                                    </div>
                                </li>
                                <li>
                                    <span class="item-hd">开户银行：</span>
                                    <div class="item-bd">
                                        <span class="item-text va-t">{$info['bankname']}</span>
                                    </div>
                                </li>

                                {/if}
                                {if $info['description']}
                                <li>
                                    <span class="item-hd">备注说明：</span>
                                    <div class="item-bd">
                                        <span class="item-text va-t" style="height: auto;">{$info['description']}</span>
                                    </div>
                                </li>
                                {/if}
                                <li>
                                    <span class="item-hd">提现状态：</span>
                                    <div class="item-bd">
                                        {if $info['status']==1}
                                        <span class="item-text va-t">已提现</span>
                                        {elseif $info['status']==2}
                                        <span class="item-text va-t">未通过</span>
                                        {else}
                                        <label class="radio-label"><input checked type="radio" name="status" value="0">待审核</label>
                                        <label class="radio-label ml-20"><input type="radio" name="status" value="2">未通过</label>
                                        <label class="radio-label ml-20"><input type="radio" name="status" value="1">已提现</label>

                                        {/if}
                                    </div>
                                </li>
                                {if $info['status']==0}
                                <li style="display: none" id="add_certificate">
                                    <span class="item-hd">付款凭证：</span>
                                    <div class="item-bd">
                                        <div id="file_upload" class="btn btn-primary radius size-S mt-3">上传凭证</div>
                                        <span class="item-text ml-10 c-999">*仅支持jpg、png格式</span>
                                        <div class="pt-10 clearfix">
                                            <img src="{$info['certificate']}" id="adimg" class="up-img-area">
                                        </div>
                                    </div>
                                </li>
                                <li style="display: none;height: auto;" id="add_description">
                                    <span class="item-hd">平台说明：</span>
                                    <div class="item-bd">
                                        <textarea name="audit_description" class="textarea w600"> </textarea>
                                    </div>
                                </li>
                                <input type="hidden" name="id" value="{$info['id']}" />
                                <input type="hidden" id="certificate" name="certificate" value="{$info['certificate']}" />
                                {/if}

                                {if $info['status']>0}
                                {if $info['certificate']}
                                <li>
                                    <span class="item-hd">付款凭证：</span>
                                    <div class="item-bd">
                                        <div class="pt-10 clearfix">
                                            <img src="{$info['certificate']}" id="adimg" class="up-img-area">
                                        </div>
                                    </div>
                                </li>
                                {/if}
                                <li>
                                    <span class="item-hd">平台说明：</span>
                                    <div class="item-bd">
                                        <span class="item-text va-t">{$info['audit_description']}</span>
                                    </div>
                                </li>
                                {/if}
                            </ul>
                        </form>
                        {if $info['status']==0}
                        <div class="clear pb-20">
                            <a href="javascript:;" id="sub_frm" class="btn btn-primary radius size-L ml-115">保存</a>
                        </div>
                        {/if}
                    </div>
                </div>
            </td>
        </tr>
    </table>

<script>


    $(function () {
        //切换状态
        $('input[name=status]').change(function () {
           var val = $(this).val();
           if(val>0)
           {
               $('#add_description').show();
               if(val==1)
               {
                   $('#add_certificate').show();
               }
               else
               {
                   $('#add_certificate').hide();
               }
           }
           else
           {
               $('#add_description').hide();
           }



        });


        //提交
        $('#sub_frm').click(function () {
            $.ajax({
                dataType:'json',
                type:'post',
                url:SITEURL+'distributor_brokerage/admin/brokerage/approval/action/save',
                data:$('#configfrm').serialize(),
                success:function (data) {
                    if(data.status==1)
                    {
                        ST.Util.showMsg('保存成功',4,1000);
                        setInterval(function () {
                            location.reload();
                        },1000)
                    }
                    else
                    {
                        ST.Util.showMsg('保存失败',5,1000);
                    }

                }
            })
        });

        //上传图片
        $('#file_upload').click(function(){
            ST.Util.showBox('上传凭证', SITEURL + 'image/insert_view', 0,0, null, null, parent.document, {loadWindow: window, loadCallback: Insert});
            function Insert(result,bool){
                var temp =result.data[0].split('$$');
                var src = temp[0];
                if(!src.match(/\.png$/i)&&!src.match(/\.jpg$/i))
                {
                    ST.Util.showMsg('只能选择jpg,png格式的图片!',5,1500);
                }
                else
                {
                    if(src){
                        $("#adimg").attr('src',src);
                        $('#certificate').val(src);
                    }
                }
            }
        })
    })





</script>

</body>
</html>
