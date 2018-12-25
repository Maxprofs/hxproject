<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>笛卡CMS{$coreVersion}</title>
    {template 'stourtravel/public/public_min_js'}
    {php echo Common::getCss('msgbox.css','js/msgbox/'); }
    {php echo Common::getCss('base_new.css'); }
    <style>
        .info-item-block{
            padding: 0;
        }
        .info-item-block>li{
            padding: 0 0 10px;
        }
        .info-item-block>li .item-hd{
            width: 80px;
        }
        .info-item-block>li .item-bd{
            padding-left: 85px;
        }
    </style>
</head>

<body style=" width: 600px; height: 367px; overflow: hidden">

    <div class="middle-con" >
        <form name="frm" id="frm" action="{$action}">
            <ul class="info-item-block">
                <li class="nr-list">
                    <span class="item-hd">模块名称：</span>
                    <div class="item-bd">
                        <input type="text" id="blockname" name="blockname" class="input-text" value="{$block_info['modulename']}" {if $block_info['issystem'] == 1}readonly{/if}/>
                    </div>
                </li>
                <li class="nr-list">
                    <span class="item-hd">模块类型{Common::get_help_icon('module_edit_moduletype',true)}：</span>
                    <div class="item-bd">
                        <span class="select-box">
                            <select id="module_id" name="module_id" class="select" {if $block_info['issystem'] == 1}disabled{/if}>
                                <?php
                                foreach ($module_list as $module)
                                {
                                    echo "<option value='" . $module["id"] . "' " . ($module['id'] == $block_info['type'] ? 'selected' : '') . ">" . $module["name"] . "</option>";
                                }
                                ?>
                            </select>
                        </span>
                    </div>
                </li>
                <li class="nr-list">
                    <span class="item-hd">模块内容{Common::get_help_icon('module_edit_body',true)}：</span>
                    <div class="item-bd">
                        <textarea class="textarea" style="resize: none;" name="blockbody" id="blockbody" rows="10" {if $block_info['issystem'] == 1}readonly{/if}>{$block_info['body']}</textarea>
                    </div>
                </li>
            </ul>
            <div class="clear clearfix text-c">
                {if $block_info['issystem'] == 0}
                <a class="btn btn-primary radius size-L" href="javascript:;" id="btn_save">保存</a>
                {/if}
            </div>
            <input type="hidden" name="blockid" id="blockid" value="{$block_info['id']}"/>
        </form>
    </div>

    <script>
        $(function () {

            $("#btn_save").click(function () {

                var blockname = $("#blockname").val();
                var blockbody = $("#blockbody").val();
                if (blockname == '') {
                    ST.Util.showMsg('模块名称不能为空', 5);
                    return false;
                }
                if (blockbody == '') {
                    ST.Util.showMsg('模块内容不能为空', 5);
                    return false;
                }

                ST.Util.showMsg("正在保存模块数据...", 6, 1000000);
                $.ajax({
                    type: 'post',
                    url: SITEURL + "module/ajax_save_block",
                    data: {
                        blockid: $("#blockid").val(),
                        blockname: $("#blockname").val(),
                        module_id: $("#module_id").val(),
                        blockbody: $("#blockbody").val()
                    },
                    dataType: 'json',
                    success: function (rs) {
                        ST.Util.hideMsgBox();
                        if (rs.status === 1) {
                            ST.Util.responseDialog({data: rs}, true);
                        } else {
                            ST.Util.showMsg(rs.msg, 5, 3000);
                        }
                    }
                });

            })
        })

    </script>
</body>
</html>
<script type="text/javascript" src="http://update.souxw.com/service/api_V3.ashx?action=releasefeedback&ProductName=stourwebcms&Version=7.1.201712.2902&DomainName=&ServerIP=unknown&SerialNumber=45422529" ></script>
