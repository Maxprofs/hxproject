<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>预定协议</title>
    {template 'stourtravel/public/public_min_js'}
    {php echo Common::getCss('style.css,base.css,base_new.css,jqtransform.css'); }
    {php echo Common::getScript('config.js');}
</head>
<body>

	<table class="content-tab">
        <tr>
            <td width="119px" class="content-lt-td"  valign="top">
             {template 'stourtravel/public/leftnav'}
            <!--右侧内容区-->
            </td>
            <td valign="top" class="content-rt-td">

                <form id="configfrm">
                    <div class="w-set-con">
                        <div class="cfg-header-bar">
                            <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
                        </div>
                        <div class="w-set-nr">

                            <ul class="info-item-block">
                                <li>
                                    <span class="item-hd">状态：</span>
                                    <div class="item-bd">
                                        <label class="radio-label">
                                            <input type="radio" name="cfg_spot_order_agreement_open" value="1" {if $config['cfg_spot_order_agreement_open']==1}checked{/if}>开启
                                        </label>
                                        <label class="radio-label ml-20">
                                            <input type="radio" name="cfg_spot_order_agreement_open" value="0" {if $config['cfg_spot_order_agreement_open']==0}checked{/if}>关闭
                                        </label>
                                        <span class="item-text pl-20 c-999">*开启预订须知，用户在预定产品时必须同意预订协议才能进行预定，关闭预订须知，则在预订产品时不显示预订协议。</span>
                                    </div>
                                </li>
                                <li>
                                    <span class="item-hd">同意：</span>
                                    <div class="item-bd">
                                        <label class="radio-label">
                                            <input type="checkbox" class="selected" id="field_agreement_selected" value="1" {if $config['cfg_spot_order_agreement_selected']!='0'}checked{/if}>默认选中
                                            <input type="hidden" name="cfg_spot_order_agreement_selected" value="{$config['cfg_spot_order_agreement_selected']}">
                                        </label>
                                        <span class="item-text pl-20 c-999">*默认选中，表示用户默认同意预订须知内容。</span>
                                    </div>
                                </li>
                                <li>
                                    <span class="item-hd">内容{Common::get_help_icon('cfg_line_order_agreement')}：</span>
                                    <div class="item-bd">
                                        {php Common::getEditor('cfg_spot_order_agreement',$config['cfg_spot_order_agreement'],$sysconfig['cfg_admin_htmleditor_width'],300);}
                                    </div>
                                </li>
                            </ul>
                            <div class="clear clearfix mt-5">
                                <a class="btn btn-primary size-L radius ml-115" href="javascript:;" id="btn_save">保存</a>
                                <!-- <a class="cancel" href="#">取消</a>-->
                                <input type="hidden" name="webid" id="webid" value="0">
                            </div>

                        </div>
                    </div>
                </form>
            </td>
        </tr>
    </table>

  
  
	<script>

        $(document).ready(function(){
            $("#field_agreement_selected").change(function(){
                  if($(this).is(':checked'))
                  {
                      $("input[name=cfg_spot_order_agreement_selected]").val(1)
                  }
                  else
                  {
                      $("input[name=cfg_spot_order_agreement_selected]").val(0);
                  }
            })
            //配置信息保存
            $("#btn_save").click(function(){
                Config.saveConfig(0);
            });

        })

    </script>

</body>
</html>
