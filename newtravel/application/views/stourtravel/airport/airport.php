<!doctype html>
<html>
<head table_head=AIACXC >
    <meta charset="utf-8">
    <title>笛卡CMS{$coreVersion}</title>
    {template 'stourtravel/public/public_js'}
    {php echo Common::getCss('style.css,base.css,base2.css,plist.css,base_new.css'); }
    {php echo Common::getScript("uploadify/jquery.uploadify.min.js,listimageup.js,common.js"); }
    {php echo Common::getCss('uploadify.css','js/uploadify/'); }

</head>
<body style="overflow:hidden">
<table class="content-tab">
    <tr>
        <td width="119px" class="content-lt-td" valign="top">
            {template 'stourtravel/public/leftnav'}
            <!--右侧内容区-->
        </td>
        <td valign="top" class="content-rt-td" style="overflow:hidden">

            <div class="cfg-header-bar">
                <div class="cfg-header-search">
                    <input type="text" id="searchkey"  placeholder="区域/城市/机场名称或三字码" class="search-text">
                    <a href="javascript:;" title="搜索" class="search-btn" onclick="searchDest()">搜索</a>
                </div>
                <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
            </div>

            <div id="line_grid_panel" class="content-nrt">
                <div id="airport_tree_panel" class="content-nrt">

                </div>
            </div>

            <div class="panel_bar">
                <a class="btn btn-primary radius" href="javascript:;" onClick="chooseAll()">全选</a>
                <a class="btn btn-primary radius ml-10" href="javascript:;" onClick="chooseDiff()">反选</a>
                <a class="btn btn-primary radius ml-10" href="javascript:;" onClick="delSome()">删除</a>
            </div>
        </td>
    </tr>
</table>

<script>


Ext.onReady(
    function () {
        $("#searchkey").focusEffect();
        //机场store
        window.airport_store = Ext.create('Ext.data.TreeStore', {
            fields: [
                'id',
                'name',
                'pid',
                'type',
                'code',
                'english',
                'issystem'
            ],
            proxy: {
                type: 'ajax',
                extraParams: {},
                api: {
                    read: SITEURL+'airport/index/action/read',  //读取数据的URL
                    update: SITEURL+'airport/index/action/save',
                    destroy: SITEURL+'airport/index/action/delete'
                },
                reader: 'json'
            },
            autoLoad: true,
            listeners: {
                sort: function (node, childNodes, eOpts) {

                },
                load:function( store, records, successful, eOpts )
                {
                    if(!successful){
                        ST.Util.showMsg("{__('norightmsg')}",5,1000);
                    }
                }
            }
        });
        window.sel_model = Ext.create('Ext.selection.CheckboxModel');
        //机场panel
        window.airport_treepanel = Ext.create('Ext.tree.Panel', {
            store: airport_store,
            rootVisible: false,
            renderTo: 'airport_tree_panel',
            border: 0,
            style: 'border:0px;',
            width: "100%",
            bodyBorder: 0,
            bodyStyle: 'border-width:0px',
            scroll:'vertical',
            listeners: {
                afterlayout: function (panel) {
                    var data_height = panel.getView().getEl().down('.x-grid-table').getHeight();

                    var height = Ext.dom.Element.getViewportHeight();

                    if (data_height > height - 120) {
                        window.has_biged = true;
                        panel.height = height - 120;
                    }
                    else if (data_height < height - 120) {
                        if (window.has_biged) {
                            delete panel.height;
                            window.has_biged = false;
                            window.airport_treepanel.doLayout();
                        }
                    }
                }


            },
           viewConfig: {
                forceFit: true,
                border: 0,
                listeners: {
                    boxready: function () {
                        var height = Ext.dom.Element.getViewportHeight();
                        this.up('treepanel').maxHeight = height - 120;
                        this.up('treepanel').doLayout();
                    }
                }
            },
            columns: [
                {
                    text: '选择',
                    width: '8%',
                    dataIndex: '',
                    tdCls: 'dest-al-mid',
                    align: 'center',
                    draggable: false,
                    menuDisabled:true,
                    sortable:false,
                    renderer:function(value, metadata,record)
                    {
                        var id=String(record.get('id'));
                        var issystem=record.get('issystem');
                        if(issystem==1 || id.indexOf('add')!=-1)
                        {
                            return;
                        }
                        return "<input type='checkbox' class='airport_check' value='" + id + "' style='cursor:pointer' onclick='togCheck(" + id + ")'/>";

                    }
                },
                {
                    xtype: 'treecolumn',
                    text: '区域/城市/机场',
                    dataIndex:'name',
                    id: 'airport_name',
                    menuDisabled:true,
                    sortable:false,
                    locked: false,
                    width: '35%',
                    renderer : function(value, metadata,record) {
                        var id=record.get('id');
                        id=id.toString();
                        if(id.indexOf('add')==-1)
                        {
                            //var editHtml="<input type='text' class='row-edit-txt' value='"+value+"'  />";
                            return "<span>"+value+"</span>"+"&nbsp;&nbsp;<font color='orange'>[id:"+id+"]</font>";

                        }
                        return value;
                    }
                },
                {
                    text: '英文名',
                    dataIndex: 'english',
                    width: '20%',
                    align: 'center',
                    sortable: false,
                    menuDisabled:true,
                    renderer : function(value, metadata,record) {
                        return value;
                    }
                },
                {
                    text: '类型',
                    dataIndex: 'type',
                    width: '13%',
                    align: 'center',
                    sortable: false,
                    menuDisabled:true,
                    renderer : function(value, metadata,record) {
                        var name_arr=["区域","城市","机场"];
                        var id=String(record.get('id'));
                        if(id.indexOf('add')!=-1)
                        {
                            return;
                        }
                        value = !value?0:value;
                        return name_arr[value];
                    }
                },
                {
                    text: '机场三字码',
                    dataIndex: 'code',
                    width: '13%',
                    align: 'center',
                    sortable: false,
                    menuDisabled:true,
                    renderer : function(value, metadata,record) {
                        return value;
                    }
                },
                {
                    text:'管理',
                    dataIndex:'',
                    width:'11%',
                    align:'center',
                    sortable:false,
                    menuDisabled:true,
                    renderer:function(value,metadata,record)
                    {
                        var id = String(record.get('id'));
                        var issystem=record.get('issystem');
                        if(issystem==1 || id.indexOf('add')!=-1)
                        {
                            return;
                        }
                        return '<a href="javascript:;" title="优化设置" class="btn-link" onclick="modify(\'' + id + '\')">设置</a>';
                    }
                }
            ]
        });


    }
);

function updateField(ele,id,field,val,type)
{
    if(type=='input')
       val=$(ele).val();

    Ext.Ajax.request({
        url: "airport/action/update",
        method: "POST",
        datatype: "JSON",
        params: {id: id, field: field, val: val},
        success: function (response, opts) {
            if (response.responseText == 'ok') {
                record.set(field, val);
                record.save();
            }
        }});
}





function addSub(pid) {

    var precord = pid == 0 ? window.airport_store.getRootNode() : window.airport_store.getNodeById(pid);
    var addnode = window.airport_store.getNodeById(pid + 'add');
    ST.Util.showBox('添加机场',SITEURL+'airport/dialog_edit',500,'',null,null,document,{loadWindow:window,loadCallback:function(params){
        params['pid']=pid;
        $.ajax({
            url: 'airport/action/addsub',
            type:'POST',
            data:params,
            dataType:'json',
            success:function(result,textStatus,jqXHR){
                if(result.status)
                {
                    var view_el = window.airport_treepanel.getView().getEl()
                    precord.insertBefore(result.data, addnode);
                }
            }
        })
    }});
}

function modify(id)
{
    ST.Util.showBox('修改机场',SITEURL+'airport/dialog_edit/id/'+id,500,'',null,null,document,{loadWindow:window,loadCallback:function(params)
                {

                    var record=window.airport_store.getNodeById(id);
                    record.set('name',params.name)
                    record.set('english',params.english);
                    record.set('type',params.type);
                    record.set('code',params.code);
                    record.save();
                }


    });
}


Ext.getBody().on('mouseup', function () {
    window.node_moving = false;

    //console.log('up_'+window.node_moving);
});
Ext.getBody().on('mousemove', function (e, t, eOpts) {

    if (window.node_moving == true) {
        // console.log('mov_'+window.node_moving);

        var tree_view = window.airport_treepanel.down('treeview');
        var view_y = tree_view.getY();
        var view_bottom = view_y + tree_view.getHeight();
        var mouse_y = e.getY();
        if (mouse_y < view_y)
            tree_view.scrollBy(0, -5, false);
        if (mouse_y > view_bottom)
            tree_view.scrollBy(0, 5, false);

    }
});


Ext.EventManager.onWindowResize(function () {
    var height = Ext.dom.Element.getViewportHeight();
    var data_height = window.airport_treepanel.getView().getEl().down('.x-grid-table').getHeight();
    if (data_height > height - 120)
        window.airport_treepanel.height = (height - 120);
    else
        delete window.airport_treepanel.height;
    window.airport_treepanel.doLayout();
})

function cascadeDest(dest, index) {
    if (dest.length == 1) {
        var node = window.airport_store.getNodeById(dest[0]);
        var ele = window.airport_treepanel.getView().getNode(node);
        if (ele) {

            var edom = Ext.get(ele);
            edom.addCls('search-dest-tr');
            if (index == 0)
                viewScroll(edom);
        }
    }
    else {
        var node = window.airport_store.getNodeById(dest[0]);
        dest.shift();
        node.expand(false, function () {
            cascadeDest(dest, index);
        });

    }
}
function viewScroll(extdom)   //在treeview里滚动
{
    var tree_view = window.airport_treepanel.getView();
    var view_y = tree_view.getY();
    var dom_y = extdom.getY();


    window.setTimeout(function () {
        window.first_scroll = true;
        extdom.scrollIntoView(tree_view.getEl());
    }, 450);
    //else
    // extdom.scrollIntoView(tree_view.getEl());


}
function togCheck(id) {


    /* var check_arr=Ext.query('.airport_check[checked]');

     var del_btn=Ext.ComponentQuery.query("#airport_del_btn")[0];

     if(check_arr.length>0)
     {
     del_btn.enable();
     }
     else
     del_btn.disable();
     */

}
function chooseAll() {
    var check_cmp = Ext.query('.airport_check');
    for (var i in check_cmp) {
        if (!Ext.get(check_cmp[i]).getAttribute('checked'))
            check_cmp[i].click();
    }

    //  window.sel_model.selectAll();
}
function chooseDiff() {
    var check_cmp = Ext.query('.airport_check');
    for (var i in check_cmp)
        check_cmp[i].click();
    //var records=window.sel_model.getSelection();
    //window.sel_model.selectAll(true);

    //	window.sel_model.deselect(records,true);

    //var
}
function delSome() {

    var check_cmp = Ext.select('.airport_check:checked');
    if(check_cmp.getCount()==0)
    {
        ST.Util.showMsg("请选择至少一条数据",5);
        return;
    }

    ST.Util.confirmBox("提示","确定删除？",function(){

        check_cmp.each(
            function (el, c, index) {
                window.airport_store.getNodeById(el.getValue()).destroy();
            }
        );
    });

}
function searchDest() {

    var s_str = Ext.get('searchkey').getValue();
    //s_str=s_str.trim();
    Ext.select('.search-dest-tr').removeCls('search-dest-tr');

    if (!s_str)
        return;
    Ext.Ajax.request({
        url: 'airport/action/search',
        params: {keyword: s_str},
        method: 'POST',
        success: function (response) {


            var text = response.responseText;
            if (text == 'no') {
                ST.Util.showMsg('未找到与'+s_str+'相关的机场',5,1000);
                //Ext.Msg.alert('查询结果', "未找到与'" + s_str + "'相关的机场");
            } else {
                var list = Ext.decode(text);
                var index = 0;
                for (var i in list) {

                    var dest = list[i];
                    cascadeDest(dest, index);
                    index++;
                }
            }
            // process server response here
        }
    });

}

function prevPopup(e,ele) {
    var evt = e ? e : window.event;
    if (evt.stopPropagation) {
        evt.stopPropagation();
    }
    else {

        evt.cancelBubble = true;
    }
}
</script>



</body>
</html>
