<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>笛卡CMS4.0</title>
    {Common::js('jquery.min.js')}
    {include "pub"}
    {Common::css('admin_base.css,admin_base2.css,admin_style.css,style.css,destination_dialog_setdest.css,base_new.css')}
    {Common::css('public/js/uploadify/uploadify.css,public/js/artDialog/css/ui-dialog.css')}
    {Common::js('artDialog/dist/dialog-plus.js,jquery.colorpicker.js,common.js,choose.js,product.js,uploadify/uploadify.js')}
</head>
<body>
<div class="s-main">
    <div class="s-search">
        <div class="txt-wp">
            <input type="text" name="keyword" class="s-txt"/><a href="javascript:;" class="s-btn"></a>
        </div>
    </div>
    <div class="s-chosen">
        <div class="chosen-tit">已选出发地：</div>
        <div class="chosen-con" id="selected_place">
            {if $startplaceid}
            {loop $startplacelist $place}
            {if $place['id']==$startplaceid}
            <span class="chosen-one" id="chosen_item_{$place['id']}" data-id="{$place['id']}"><label class="lb-tit">{$place['cityname']}</label><a
                        href="javascript:;" class="del">x</a></span>
            {/if}
            {/loop}
            {else}
            无
            {/if}
            <div class="clear-both"></div>
        </div>
    </div>
    <div class="s-list" id="content_area">
        <div class="con-one" step="1">
            <ul>
                <li>
                    {loop $startplacetop $place}
                    <span class="dest-item choose-child-item" id="chosen_item_{$place['pid']}"
                          data-pid="{$place['pid']}" data-id="{$place['id']}">
                        <label class="lb-tit">{$place['cityname']}</label>
                        <a class="lb-num num-len1" href="javascript:;" data-rel="{$place['id']}">{$place['num']}</a>
                    </span>
                    {/loop}
                    <div class='clear-both'></div>
                </li>
            </ul>
        </div>
        <div class="con-one" step="2" style="display: none;">

        </div>
    </div>
    <div class="save-con">
        <a href="javascript:;" class="confirm-btn" id="confirm-btn">确定</a>
    </div>
</div>
<script>
    var id = "{$startplaceid}";
    var typeid = "{$typeid}";
    function get_data(pid, keyword) {
        $("div.con-one.step").hide();
        ST.Util.resizeDialog('.s-main');
        var url = SITEURL + 'index/ajax_get_start_place';
        var rowNum = 4;
        $.ajax({
            type: "post",
            url: url,
            dataType: 'json',
            data: {pid: pid, keyword: keyword},
            success: function (data) {
                if (data.status) {
                    $('div.con-one[step=2]').html('');
                    $("div.con-one[step=2]").show();
                    var html = '<ul>';
                    var lastIndex = 0;
                    for (var i in data['list']) {
                        if (i % rowNum == 0) {
                            html += "<li>";
                            lastIndex = parseInt(rowNum) + parseInt(i) - 1;
                        }
                        var row = data['list'][i];
                        var labelCls = row['cityname'].length > 5 ? 'lb_5' : '';
                        var checkStr = row['id'] == id ? 'checked="checked"' : '';
                        html += ' <span class="dest-item" id="item_' + row['id'] + '" pid="' + pid + '" >' +
                            '<input type="radio" name="startplace" ' + checkStr + ' class="lb-box" value="' + row['id'] + '"/>' +
                            '<label class="lb-tit ' + labelCls + '" >';
                        html += row['cityname'] + '</label><div class="clear-both"></div></span>';
                        if (i == lastIndex || i == data['count'] - 1) {
                            html += "<div class='clear-both'></div></li>"
                        }
                    }
                    html += '</ul>';
                    $('.con-one[step=2]').append(html);
                    ST.Util.resizeDialog('.s-main');
                    $(document).on('click', 'input[type=radio][name=startplace]', function () {
                        var name = $(this).siblings("label").text();
                        var id = $(this).val();
                        var select_html='<span class="chosen-one" id="chosen_item_' + id + '" data-id="' + id + '"><label class="lb-tit">' + name + '</label><a href="javascript:;" class="del">x</a></span> ' +
                            '<div class="clear-both"></div>'
                        $("#selected_place").html(select_html);
                        ST.Util.resizeDialog('.s-main');
                    });
                    $(document).on('click', '#confirm-btn', function () {
                        var select_name = $("#selected_place span.chosen-one label.lb-tit").text();
                        var select_id = Number($("#selected_place span.chosen-one").data('id'));
                        var Place = select_id ? {id: select_id, name: select_name} : null;
                        ST.Util.responseDialog(Place, (select_id ? true : false));
                    });
                }
            }
        })
    }
    $(function () {
        $("div.con-one[step=1] .choose-child-item").each(function () {
            $(this).unbind('click').bind('click', function () {
                $(this).siblings(".selected").removeClass('selected');
                $(this).addClass('selected');
                var pid = $(this).data('id');
                var keyword = '';
                get_data(pid, keyword);
                return false;
            })
        });
        $(document).on('click', 'a.s-btn', function () {
            var pid = $("div.con-one[step=1]").find(".choose-child-item").data('id');
            var keyword = $("input[name=keyword]").val();
            pid = pid ? pid : null;
            get_data(pid, keyword);
            return false;
        });
    })
</script>

</body>
</html>
