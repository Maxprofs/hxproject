<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>附加选项</title>
    {template 'stourtravel/public/public_min_js'}
    {Common::getCss('style.css,base.css,base_new.css')}
    {Common::getScript('config.js')}
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
                    <div class="cfg-header-bar">
                        <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
                    </div>
                    <ul class="info-item-block">
                        {if St_Functions::is_normal_app_install('supplierlinemanage')}
                        <li class="rowElem">
                            <span class="item-hd">自动审核{Common::get_help_icon('auto_audit')}：</span>
                            <div class="item-bd">
                                <label class="radio-label"><input type="radio"  name="cfg_line_supplier_check_auto" value="1" {if $config['cfg_line_supplier_check_auto']=='1'}checked{/if}>自动审核</label>
                                <label class="radio-label ml-20"><input type="radio"  name="cfg_line_supplier_check_auto" value="0" {if $config['cfg_line_supplier_check_auto']!=1}checked{/if}>人工审核</label>
                            </div>
                        </li>
                        {/if}

                      <li class="rowElem">
                          <span class="item-hd">游客信息{Common::get_help_icon('cfg_write_tourer')}：</span>
                          <div class="item-bd">
                              <label class="radio-label"><input type="radio"  name="cfg_write_tourer" value="1" {if $config['cfg_write_tourer']=='1'}checked{/if}>开启</label>
                              <label class="radio-label ml-20"><input type="radio"  name="cfg_write_tourer" value="0" {if $config['cfg_write_tourer']=='0'}checked{/if}>关闭</label>
                          </div>
                      </li>
                      <li class="rowElem">
                          <span class="item-hd">发票信息{Common::get_help_icon('cfg_bill_open')}：</span>
                          <div class="item-bd">
                              <label class="radio-label"><input type="radio"  name="cfg_bill_open" value="1" {if $config['cfg_bill_open']=='1'}checked{/if}>开启</label>
                              <label class="radio-label ml-20"><input type="radio"  name="cfg_bill_open" value="0" {if $config['cfg_bill_open']=='0'}checked{/if}>关闭</label>
                          </div>
                      </li>
                    </ul>
                    <div class="clear clearfix mt-5">
                        <a class="btn btn-primary radius size-L ml-115" href="javascript:;" id="btn_save">保存</a>
                        <input type="hidden" name="webid" id="webid" value="0">
                    </div>
                </form>
            </td>
        </tr>
    </table>

	<script>

	$(document).ready(function(){

        //配置信息保存
        $("#btn_save").click(function(){

            //var webid= $("#webid").val();
            Config.saveConfig(0);

        });

    })












    </script>

</body>
</html>
