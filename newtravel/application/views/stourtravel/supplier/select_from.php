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
    .setfrom{
        text-align: center;
        margin-top: 10px;
    }
    .setfrom button:hover{
        background: #999;
    }
    h5{
        margin-top: 0px;
    }
    .tree{
        overflow-y: auto;
        width: 400px;
        height: 340px;
    }
    .selectedfrom{
        width: 400px;
        height: 70px;
        overflow-y: auto;
    }
    .selectedfrom span{
        margin: 2px;
    }
</style>

<body >
    <h5>已选择出发地</h5>
    <div id="selectedfrom" class="pre-scrollable selectedfrom">
        
    </div>
    <div class="pre-scrollable tree" id="tree">
    </div>
    <div class='setfrom'>
        <button onclick="setfrom()">确定</button>
    </div>
    <div id="divids">
        <input type="hidden" id="fromids" name="fromids" value="">
    </div>
    
    <script>
        var list = <?php echo json_encode($list) ?>;
        var colorobj={'0':'default','1':'primary','2':'success','3':'info','4':'warning','5':'danger'}

        $(function() {
            $('#tree').treeview({
                data:list,
                onNodeSelected:function (e,n) {
                    // console.log(n) 
                },
                onNodeChecked:function (e,n) {
                    var obj = $('#selectedfrom').children()
                    var deststr=[]
                    $.each(obj, function(i, v) {
                        deststr.push($(v).text())
                    });
                    // 点击的值不存在于‘已选择目的地’中则添加
                    if (deststr.indexOf(n.text)==-1){
                        var htm = $('#selectedfrom').html();
                        var id = n.text.slice(0,n.text.indexOf(" "));
                        $('#selectedfrom').html(htm+'<span id="'+id+'" class="btn btn-'+colorobj[Math.floor(Math.random()*6)]+' btn-xs">'+n.text+'</span>')
                        if ($('#fromids').val()!=='') {
                            $('#fromids').val($('#fromids').val()+','+id)
                        }else{
                            $('#fromids').val(id);
                        }
                        
                    }
                },
                // 点击取消时的值存在于‘已选择目的地’中则删除
                onNodeUnchecked:function (e,n) {
                    var obj = $('#selectedfrom').children()
                    $.each(obj, function(i, v) {
                        var objval =$(v).text().replace(/^\s+|\s+$/gm,'');
                        var nval=n.text.replace(/^\s+|\s+$/gm,'');
                        if (objval==nval) {
                            $(v).remove();
                            var ids = $('#fromids').val()
                            ids=ids.split(',');
                            var idx=ids.indexOf($(v).attr('id'));
                            ids.splice(idx);
                            ids=ids.join(',')
                            $('#fromids').val(ids)
                        }
                    });
                },
                showCheckbox:true,
                selectedBackColor:'#8888fa',
                onhoverColor:'#aaa'
            });
            // 初始化后收起所有节点
            $('#tree').treeview('collapseAll', { silent: true });
        });
        function setfrom() {
            if ($('#fromids').val()!=='') {
                var htm = $('#selectedfrom').html()+$('#divids').html();
                $('#from_li',window.parent.document).html(htm);
                parent.d.remove()
            }else{
                if (confirm('没有选择任何出发地是否关闭')) {
                    parent.d.remove()
                }else{
                    return;
                }
            }
        }
    </script>
</body>

</html>