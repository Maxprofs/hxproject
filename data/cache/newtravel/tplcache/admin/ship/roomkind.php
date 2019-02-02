<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>笛卡CMS<?php echo $coreVersion;?></title>
    <?php echo  Stourweb_View::template('stourtravel/public/public_js');  ?>
    <?php echo Common::getCss('style.css,base.css,base2.css,plist.css,base_new.css'); ?>
</head>
<body style="overflow:hidden">
<table class="content-tab">
    <tr>
        <td width="119px" class="content-lt-td" valign="top">
            <?php echo  Stourweb_View::template('stourtravel/public/leftnav');  ?>
            <!--右侧内容区-->
        </td>
        <td valign="top" class="content-rt-td" style="overflow:hidden">
            <div class="cfg-header-bar">
                <a href="javascript:;" class="fr btn btn-primary radius mr-10 mt-6" onclick="window.location.reload()">刷新</a>
            </div>
            
            <div id="line_grid_panel" class="content-nrt">
                <div id="attr_tree_panel" class="content-nrt">
                </div>
                <div class="panel_bar">
                </div>
        </td>
    </tr>
</table>
<script>
    Ext.onReady(
        function () {
            Ext.tip.QuickTipManager.init();
            window.attr_store = Ext.create('Ext.data.TreeStore', {
                fields: [
                    'id',
                    'title'
                ],
                proxy: {
                    type: 'ajax',
                    extraParams: {typeid: window.display_mod},
                    api: {
                        read: SITEURL+'ship/admin/ship/roomkind/action/read',  //读取数据的URL
                        update:  SITEURL+'ship/admin/ship/roomkind/action/save',
                        destroy:  SITEURL+'ship/admin/ship/roomkind/action/delete'
                    },
                    reader:{
                        type:'json',
                        root:'children'
                    } //'json'
                },
                autoLoad: true,
                listeners: {
                    load:function( store, records, successful, eOpts )
                    {
                        if(!successful){
                            ST.Util.showMsg("<?php echo __('norightmsg');?>",5,1000);
                        }
                    }
                }
            });
            //属性树
            window.attr_treepanel = Ext.create('Ext.tree.Panel', {
                store: attr_store,
                rootVisible: false,
                renderTo: 'attr_tree_panel',
                border: 0,
                style: 'margin-left:0px;border:0px;',
                width: "100%",
                bodyBorder: 0,
                bodyStyle: 'border-width:0px',
                // selModel:sel_model,
                scroll:'vertical', //只要垂直滚动条
                listeners: {
                    celldblclick: function (view, td, cellIndex, record, tr, rowIndex, e, eOpts) {
                        if (record.get('displayorder') == 'add')
                            return false;
                    },
                    afterlayout: function (panel) {
                        var data_height = panel.getView().getEl().down('.x-grid-table').getHeight();
                        var height = Ext.dom.Element.getViewportHeight();
                        // console.log(data_height+'---'+height);
                        if (data_height > height - 100) {
                            window.has_biged = true;
                            panel.height = height - 100;
                        }
                        else if (data_height < height - 100) {
                            if (window.has_biged) {
                                delete panel.height;
                                window.has_biged = false;
                                window.attr_treepanel.doLayout();
                            }
                        }
                    }
                },
                viewConfig: {
                    forceFit: true,
                    border: 0,
                    plugins: {
                        ptype: 'treeviewdragdrop',
                        enableDrag: true,
                        enableDrop: true,
                        displayField: 'kindname'
                    },
                    listeners: {
                        boxready: function () {
                            var height = Ext.dom.Element.getViewportHeight();
                            this.up('treepanel').maxHeight = height - 100;
                            this.up('treepanel').doLayout();
                        }
                    }
                },
                columns: [
                    {
                        //有展开按钮的指定为treecolumn
                        text: '分类名称',
                        dataIndex: 'title',
                        sortable:false,
                        locked: false,
                        align:'center',
                        menuDisabled:true,
                        width: '70%',
                        editor:{xtype:'textfield',listeners:{
                            focus:function(ele,event)
                            {
                                var inputId=ele.getInputId();
                                var inputEle= $("#"+inputId)
                                var str=ele.getValue();
                                var width=80;
                                if(str)
                                {
                                    var len=str.length*20;
                                    width=len<width?width:len;
                                }
                                inputEle.css({'padding':'0px 10px','width':width});
                                $(inputEle).parent().attr("align",'center');
                            }
                        }},
                        renderer : function(value, metadata,record) {
                            var id=record.get('id');
                            if(id.indexOf('add')==-1)
                            {
                                return "<span class='row-editable-sp'>"+value+"</span>"+"&nbsp;&nbsp;<font color='orange'>[id:"+id+"]</font>";
                            }
                            return value;
                        }
                    },
                    {
                        text: '<span class="grid_column_text">管理</span>',
                        width: '30%',
                        tdCls: 'attr-al-mid',
                        align:'center',
                        menuDisabled:true,
                        renderer : function(value, metadata,record) {
                            var id=record.get('id');
                            var pid = record.get('pid');
                            if(id.indexOf('add')!=-1)
                                return '';
                            return '<a href="javascript:void(0);" title="删除" class="btn-link" onclick="del('+id+')">删除</a>';
                        }
                    }
                ],
                plugins: [
                    Ext.create('Ext.grid.plugin.CellEditing', {
                        clicksToEdit: 1,
                        listeners: {
                            edit: function (editor, e) {
                                e.record.commit();
                                e.record.save({params: {field: e.field}});
                            }
                            ,
                            beforeEdit:function(editor,e){
                                var id=e.record.get('id');
                                if(id.indexOf('add')!=-1)
                                    return false;
                            }
                        }
                    })
                ]
            });
        }
    );
    function togStatus(obj, record, field) {
        var val = record.get(field);
        var id = record.get('id');
        id = id.substr(id.indexOf('_') + 1);
        var newval = val == 1 ? 0 : 1;
        Ext.Ajax.request({
            url: "attrination/action/update",
            method: "POST",
            datatype: "JSON",
            params: {id: id, field: field, val: newval, typeid: window.display_mode},
            success: function (response, opts) {
                if (response.responseText == 'ok') {
                    record.set(field, newval);
                    record.commit();
                }
            }});
    }
    Ext.getBody().on('mouseup', function () {
        window.node_moving = false;
    });
    Ext.getBody().on('mousemove', function (e, t, eOpts) {
        if (window.node_moving == true) {
            // console.log('mov_'+window.node_moving);
            var tree_view = window.attr_treepanel.down('treeview');
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
        var data_height = window.attr_treepanel.getView().getEl().down('.x-grid-table').getHeight();
        if (data_height > height - 100)
            window.attr_treepanel.height = (height - 100);
        else
            delete window.attr_treepanel.height;
        window.attr_treepanel.doLayout();
    })
    function cascadeattr(attr, index) {
        if (attr.length == 1) {
            var node = window.attr_store.getNodeById(attr[0]);
            var ele = window.attr_treepanel.getView().getNode(node);
            if (ele) {
                var edom = Ext.get(ele);
                edom.addCls('search-attr-tr');
                if (index == 0)
                    viewScroll(edom);
            }
        }
        else {
            var node = window.attr_store.getNodeById(attr[0]);
            attr.shift();
            node.expand(false, function () {
                cascadeattr(attr, index);
            });
        }
    }
    function viewScroll(extdom)   //在treeview里滚动
    {
        var tree_view = window.attr_treepanel.getView();
        var view_y = tree_view.getY();
        var dom_y = extdom.getY();
        window.setTimeout(function () {
            window.first_scroll = true;
            extdom.scrollIntoView(tree_view.getEl());
        }, 450);
        //else
        // extdom.scrollIntoView(tree_view.getEl());
    }
    function chooseAll() {
        var check_cmp = Ext.query('.attr_check');
        for (var i in check_cmp) {
            if (!Ext.get(check_cmp[i]).getAttribute('checked'))
                check_cmp[i].click();
        }
        //  window.sel_model.selectAll();
    }
    function chooseDiff() {
        var check_cmp = Ext.query('.attr_check');
        for (var i in check_cmp)
            check_cmp[i].click();
        //var records=window.sel_model.getSelection();
        //window.sel_model.selectAll(true);
        //window.sel_model.deselect(records,true);
        //var
    }
    function addSub(pid,path) {
        var precord = pid == 0 ? window.attr_store.getRootNode() : window.attr_store.getNodeById(pid);
        var addnode = window.attr_store.getNodeById(pid + 'add');
        Ext.Ajax.request({
            method: 'post',
            url: SITEURL+'ship/admin/ship/roomkind/action/addsub',
            params: {pid: pid,path:path},
            success: function (response) {
                var newrecord = Ext.decode(response.responseText);
                var view_el = window.attr_treepanel.getView().getEl()
                var scroll_top = view_el.getScrollTop();
                precord.insertBefore(newrecord, addnode);
                //view_el.scroll('t',scroll_top);
            }
        });
    }
    function del(id) {
        ST.Util.confirmBox("提示","确定删除？",function(){
            id=id.toString();
            var node=window.attr_store.getNodeById(id);
            node.destroy();
        });
    }
    function getHelp(e) {
        if (e && e.stopPropagation)
        //因此它支持W3C的stopPropagation()方法
            e.stopPropagation();
        else
        //否则，我们需要使用IE的方式来取消事件冒泡
            window.event.cancelBubble = true;
    }
    function updateField(ele,id,field,value,type,callback)
    {console.log(ele,id,field,value,type,callback);
        var record=window.attr_store.getNodeById(id.toString());
        if(type=='select' || type=='input')
        {
            value=Ext.get(ele).getValue();
        }
        Ext.Ajax.request({
            url   :  SITEURL+"ship/admin/ship/roomkind/action/update",
            method  :  "POST",
            datatype  :  "JSON",
            params:{id:id,field:field,val:value},
            success  :  function(response, opts)
            {
                record.set(field,value);
                record.commit();
                if(typeof(callback)=='function')
                {
                    callback(record);
                }
            }});
    }
    function stopDef(e)
    {
        if (e && e.stopPropagation)
        //因此它支持W3C的stopPropagation()方法
            e.stopPropagation();
        else
        //否则，我们需要使用IE的方式来取消事件冒泡
            window.event.cancelBubble = true;
    }
</script>
</body>
</html>
