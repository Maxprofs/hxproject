<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>笛卡CMS{$coreVersion}</title>
    {template 'stourtravel/public/public_min_js'}
    {php echo Common::getCss('style.css,base.css,base_new.css'); }
    {Common::css_plugin('material.css', 'visa')}
</head>
<body>

<table class="content-tab">
    <tr>
        <td width="119px" class="content-lt-td" valign="top">
            {template 'stourtravel/public/leftnav'}
            <!--右侧内容区-->
        </td>
        <td valign="top" class="content-rt-td" style="overflow-x:hidden;">
            <div class="cfg-header-bar">
                <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
                <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" id="additem">添加</a>
            </div>
            <div class="clearfix">
                <table class="table table-bg">
                    <thead>
                        <tr>
                            <th width="80%"><span class="ml-15">针对人群{Common::get_help_icon('visa_material')}：</span></th>
                            <th width="10%" class="text-c">显示</th>
                            <th width="10%" class="text-c">管理</th>
                        </tr>
                    </thead>
                    <tbody id="material_tbody">
                        {loop $materials $v}
                        <tr>
                            <td>
                                <input class="input-text ml-10" maxlength="10" type="text" data-id="{$v['id']}" value="{$v['title']}" />
                            </td>
                            <td class="text-c">
                                <a class="control-switch change-show{if $v['is_show'] == 0} switch-hide{/if}"  href="javascript:;"></a>
                            </td>
                            {if $v['is_system'] != 1}
                            <td class="text-c">
                                <a href="javascript:;" class="btn-link cancel-btn">删除</a>
                            </td>
                            {/if}
                        </tr>
                        {/loop}
                    </tbody>
                </table>
            </div>
        </td>
    </tr>
</table>

<script>
    var $material_tbody = $('#material_tbody');
    //添加
    $('#additem').click(function () {
        var length = $material_tbody.find('tr').length;
        if (length >= 8){
            ST.Util.showMsg("最多只能添加8种人群",1,1000);
            return false;
        }
        var html = '<tr>';
            html += '<td>';
            html += '<input class="input-text ml-10" maxlength="10" type="text" data-id="" value="">';
            html += '</td>';
            html += '<td class="text-c">';
            html += '<a class="control-switch switch-hide change-show" href="javascript:;"></a>';
            html += '</td>';
            html += '<td class="text-c">';
            html += '<a href="javascript:;" class="btn-link cancel-btn" data-id="">删除</a>';
            html += '</td>';
            html += '</tr>';

        $material_tbody.append(html);
    });

    //保存人群名称
    $material_tbody.on('blur', 'input', function () {
        var $this = $(this);
        var id = $this.data('id');
        var val = $this.val();
        var $is_show = $this.closest('tr').find('.change-show');
        if ($is_show.hasClass('switch-hide')){
            var is_show = 0;
        }else{
            is_show = 1;
        }
        val = $.trim(val);
        if(val == ''){
            return false;
        }
        save_info(id, val, is_show, $this);
    });

    //改变显示状态
    $material_tbody.on('click', '.change-show', function () {
        var $input = $(this).closest('tr').find('input');
        var id = $input.data('id');
        var val = $input.val();
        if($(this).hasClass('switch-hide')){
            var is_show = 1;
            $(this).removeClass('switch-hide');
        }else {
            is_show = 0;
            $(this).addClass('switch-hide');
        }
        save_info(id, val, is_show, $input)
    });

    //删除
    $material_tbody.on('click','.cancel-btn', function () {
        var $tr = $(this).closest('tr');
        var $input = $tr.find('input');
        var id = $input.data('id');

        ST.Util.confirmBox("提示","确定删除该项？",function(){
            if (id){
                $.post(
                    SITEURL+"visa/admin/visa/ajax_del_material",
                    {id: id},
                    function(data){
                        if(data.status){
                            $tr.remove();
                        }
                    },
                    'json'
                );
            }else{
                $tr.remove();
            }
        });
    });

    //保存数据
    function save_info(id, val, is_show, $this) {
        $.post(
            SITEURL + 'visa/admin/visa/ajax_save_material',
            {id: id, val: val, is_show: is_show},
            function (data) {
                if(data.status){
                    $this.data('id', data.auto_id);
                }
            },
            'json'
        );
    }
</script>

</body>
</html>
