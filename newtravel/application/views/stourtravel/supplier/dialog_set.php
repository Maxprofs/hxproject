<!doctype html>
<html>
<head size_font=5kuokk >
    <meta charset="utf-8">
    <title>笛卡CMS{$coreVersion}</title>
    {template 'stourtravel/public/public_min_js'}
    {php echo Common::getScript("uploadify/jquery.uploadify.min.js,listimageup.js"); }
    {php echo Common::getCss('uploadify.css','js/uploadify/'); }
    {php echo Common::getCss('base.css,base_new.css'); }
    <style>
        .gys-scroll-area{
            height: 300px;
            margin-top: 10px;
            overflow-y: auto;
        }
        .gys-scroll-wrapper{
            font-size: 0;
        }
        .gys-scroll-wrapper .item{
            display: inline-block;
            width: 50%;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .gys-txt-msg{
            color: #999;
            line-height: 300px;
            text-align: center;
        }
    </style>
</head>
<body >
<div class="container-page pt-10">
    <div class="cfg-search-bar">
            <span class="select-box w150 fl mt-3">
                <select name="authorization" class="select search_item">
                    <option value="0">选择经营范围</option>
                     {loop $product_list $p}
                    <option value="{$p['id']}" {if $typeid==$p['id']}selected{/if}>&nbsp;{$p['modulename']}</option>
                    {/loop}
                </select>
            </span>
        <span class="select-box w150 fl mt-3 ml-10">
                <select name="kindid" class="select search_item">
                    <option value="0">所属分类</option>
                    {loop $kind $v}
                    <option value="{$v['id']}">{$v['kindname']}</option>
                    {/loop}
                </select>
            </span>
        <div class="cfg-header-search">
            <input type="text" class="search-text search_item" name="keyword" value="" placeholder="搜索供应商" />
            <a href="javascript:;" class="search-btn">搜索</a>
        </div>
    </div>
    <div class="clearfix">
        <div class="gys-scroll-area">
            <ul class="gys-scroll-wrapper hide" id="supplier">

            </ul>
            <div class="gys-txt-msg hide" id="no_supplier">没有搜到相关内容！</div>
        </div>
        <div class="clearfix text-c mt-20">
            <a href="javascript:;" class="btn btn-grey-outline radius" id="cancel_btn">取消</a>
            <a href="javascript:;" class="btn btn-primary radius ml-10" id="confirm_btn">确定</a>
        </div>
    </div>
</div>
<!-- 选择供应商 -->
</body>
<script>
    search();
    $('.search_item').change(function () {
        search();
    });
    $('.search-btn').click(function () {
        search();
    });
    function search() {
        var param = {};
        $('.search_item').each(function () {
            param[$(this).attr('name')] = $(this).val();
        });
        $.post(SITEURL + 'supplier/ajax_dialog_search', param, function (result) {
            var total = result.length;
            var i = 0;
            var html = '';
            if (total > 0) {
                while (i < total) {
                    html += '<li class="item" data="{id:' + result[i]['id'] + ',suppliername:\'' + result[i]['suppliername'] + '\'}"><label class="radio-label"><input name="item" type="radio" />' + result[i]['suppliername'] + '</label></li>';
                    ++i;
                }
                $('#supplier').html(html).removeClass('hide');
                $('#no_supplier').addClass('hide');
            } else {
                $('#supplier').addClass('hide');
                $('#no_supplier').removeClass('hide');
            }
        }, 'json');
    }

    $('#cancel_btn').click(function () {
        ST.Util.closeBox();
    });

    $('#confirm_btn').click(function () {
        var node = $('input[name="item"]:checked');
        if (node.length < 1) {
            ST.Util.closeBox();
        }
        var data = eval('(' + node.parent().parent().attr('data') + ')');
        ST.Util.responseDialog({id: data.id, selector: "{$selector}", data: [data]}, true);
    });
</script>
</html>
