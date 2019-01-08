<!doctype html>
<html>

<head script_ul=JIACXC>
    <meta charset="utf-8">
    <title>供应商管理-笛卡CMS{$coreVersion}</title>
    {php echo Common::getScript("jquery-3.3.1.min.js"); }
    {php echo Common::getScript("public/bootstrap/js/bootstrap.min.js",false); }
    {php echo Common::getScript("public/bootstrap/js/bootstrap-treeview.min.js",false); }
    {php echo Common::getCss('bootstrap.min.css','bootstrap/css'); }
    {php echo Common::getCss('bootstrap-treeview.min.css','bootstrap/css'); }
</head>
<style>
    a{
        color: black;

    }
    a:hover{
        color:#fff;
        text-decoration: none;
    }
    h5{
        margin-top: 0px;
    }
    .tree{
        overflow-y: auto;
        width: 400px;
        height: 340px;
    }
    .selecteddest{
        width: 400px;
        height: 70px;
        overflow-y: auto;
    }
    .selecteddest span{
        color: red;
        display: inline-block;
        height: 30px;
        line-height: 30px;
        padding: 0 28px 0 10px;
        vertical-align: middle;
        margin-right: 10px;
        position: relative;
        background: #f1f1f1;
    }
    span s {
        display: inline-block;
        width: 8px;
        height: 8px;
        cursor: pointer;
        opacity: .6;
        position: absolute;
        right: 10px;
        top: 11px;
    }
    .badge{
        visibility: hidden;
    }
</style>

<body >
    <h5 style="float: left;">已选择目的地</h5>
    <div id="selecteddest" class="pre-scrollable selecteddest">
        
    </div>
    <div class="pre-scrollable tree" id="tree">
    </div>
    <div id="divids">
        {if $setids!='undefined'}
            <input type="hidden" id="{$limittype}ids" name="{$limittype}ids" value="{$setids}">
        {else}
            <input type="hidden" id="{$limittype}ids" name="{$limittype}ids" value="">
        {/if}
    </div>
    <div class='setdest' style="text-align: center;">
        <buttonc class="btn btn-info btn-bg" onclick="setdest()">关闭</button>
    </div>
    <script>
        var list = <?php echo json_encode($list) ?>;
        $('#selecteddest').html("<?php echo $sethtml ?>");
        $(function() {
            $('#tree').treeview({
                data:list,
                onNodeSelected:function (e,n) {
                    // console.log(n) 
                },
                onNodeChecked:function (e,n) {
                    var obj = $('#selecteddest').children()
                    var deststr=[]
                    $.each(obj, function(i, v) {
                        deststr.push($(v).text())
                    });
                    // 点击的值不存在于‘已选择目的地’中则添加
                    if (deststr.indexOf(n.text)==-1){
                        var htm = $('#selecteddest').html();
                        var id = n.text.slice(0,n.text.indexOf(" "));
                        $('#selecteddest').html(htm+'<span id="'+id+'">'+n.text+'<s onclick="removespan(this)"></s></span>')
                        if ($("#{$limittype}ids").val()!=='') {
                            $("#{$limittype}ids").val($("#{$limittype}ids").val()+','+id)
                        }else{
                            $("#{$limittype}ids").val(id);
                        }
                        if ($('#action',parent.document).val()=='edit') {
                                var tbl="{$limittype}";
                                if (tbl=='dest') {
                                    tbl='destinations'
                                }else{
                                    tbl='startplace'
                                }
                                $.ajax({
                                    url: '/newtravel/supplier/ajax_set_supplierid',
                                    type: 'post',
                                    dataType: 'json',
                                    data: {tbl: tbl,isopen:1,placeid:id,supplierid:$('#id',parent.document).val()},
                                })
                                .done(function(msg) {
                                    return;
                                })
                        }
                    }
                },
                // 点击取消时的值存在于‘已选择目的地’中则删除
                onNodeUnchecked:function (e,n) {
                    var obj = $('#selecteddest').children()
                    $.each(obj, function(i, v) {
                        var objval =$(v).text().replace(/^\s+|\s+$/gm,'');
                        var nval=n.text.replace(/^\s+|\s+$/gm,'');
                        if (objval==nval) {
                            $(v).remove();
                            if ($('#action',parent.document).val()=='add') {
                                var ids = $("#{$limittype}ids").val()
                                ids=ids.split(',');
                                var idx=ids.indexOf($(v).attr('id'));
                                ids.splice(idx,1);
                                ids=ids.join(',')
                                $("#{$limittype}ids").val(ids)
                            }else{
                                var tbl="{$limittype}";
                                if (tbl=='dest') {
                                    tbl='destinations'
                                }else{
                                    tbl='startplace'
                                }
                                $.ajax({
                                    url: '/newtravel/supplier/ajax_set_supplierid',
                                    type: 'post',
                                    dataType: 'json',
                                    data: {tbl: tbl,isopen:0,placeid:$(v).attr('id'),supplierid:$('#id',parent.document).val()},
                                })
                                .done(function(msg) {
                                    $(ele).parent('span').remove();
                                })
                            }
                        }
                    });
                },
                showCheckbox:true,
                selectedBackColor:'#8888fa',
                onhoverColor:'#aaa',
                showTags:true
            });
            // 初始化后收起所有节点
            $('#tree').treeview('collapseAll', { silent: true });
            $('.badge').parent('li').find('.check-icon').attr('disabled', 'disabled');
        });
        function setdest() {
                var htm = $('#selecteddest').html()+$('#divids').html();
                $("#{$limittype}_li",window.parent.document).html(htm);
                parent.d.remove()
        }
    </script>
</body>

</html>