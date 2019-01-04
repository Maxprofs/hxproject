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
        color:white;
        text-decoration: none;
    }
    .setdest{
        text-align: center;
    }
    .setdest button:hover{
        background: #999;
    }
</style>

<body >
    <div id="tree">
    </div>
    <div class='setdest'>
        <button onclick="setdest()">确定</button>
    </div>
    <script>
        var list = <?php echo json_encode($list) ?>;

        // var data =[list];
        // console.log(data);
        $(function() {
            // sortdata(0,list);
            // sortdata(list);
            $('#tree').treeview({
                data:list,
                onNodeSelected:function (e,n) {
                    console.log(n)
                },
                emptyicon:"glyphicon glyphicon-chevron-right",
                selectedIcon:"glyphicon glyphicon-chevron-down",
                onhoverColor:'#333',
                selectedBackColor:"#aaa",
                showCheckbox:true
            });
        });

        function getdata(id) {
            $.ajax({
                url: '/newtravel/supplier/ajax_select_dest',
                type: 'get',
                dataType: 'json',
                data: {id: id},
            })
            .done(function(data) {
                console.log(data);
            })
        }
        function sortdata(obj) {
            for (var a in obj) {
                if (typeof(obj[a]['nodes'])=='object') {
                    sortdata(obj[a]);
                }else{
                    console.log(obj[a])
                }
            }
        }
        // function sortdata(node='',list='') {
        //     $.each(list, function(index, val) {
        //         var n=[];
        //         $.each(val, function(i, v) {
        //             switch(i){
        //                 case 'id':
        //                     n['text']=v+'  ';
        //                     break;
        //                 case 'kindname':
        //                     n['text']+=v;
        //                     break;
        //                 case 'pid':
        //                     var id = n['text'].slice(0,n['text'].search(' '));
        //                     var kindname=n['text'].slice(n['text'].search(/  /),n['text'].length)
        //                     n['text']='  <a href="#" onclick="getdata('+id+')">'+id+'  '+kindname+'</a>';
        //                     n['icon']="glyphicon glyphicon-chevron-right";
        //                     n['backColor']="#bbb";
        //                     n['color']="#000";
        //                     break;
        //             }
        //         });
        //         data.push(n);
        //     });
        // }
    </script>
</body>

</html>