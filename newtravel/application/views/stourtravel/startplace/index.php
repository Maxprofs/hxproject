<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>出发地管理-笛卡CMS{$coreVersion}</title>
    {template 'stourtravel/public/public_js'}
    {php echo Common::getCss('style.css,base.css,base2.css,plist.css,base_new.css'); }
    {php echo Common::getScript('config.js,jquery.colorpicker.js');}
    <style>
        .x-tree-view{
            overflow: hidden !important;
            overflow-y: auto !important;
        }
    </style>
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
                    <div class="cfg-header-tab">
                        <span class="item on" data-contain="navigation">全局出发地</span>
                        <span class="item" data-contain="open">功能开关</span>
                    </div>
                    <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
                </div>


                <div id="navigation" class="div_container">
                    <div id="line_grid_panel" class="content-nrt">
                        <div id="attr_tree_panel" class="content-nrt"></div>
                        <div class="st-bottom-console-bar clear clearfix">
                            <a class="btn btn-primary radius" href="javascript:;" onClick="chooseAll()">全选</a>
                            <a class="btn btn-primary radius ml-10" href="javascript:;" onClick="chooseDiff()">反选</a>
                            <a class="btn btn-primary radius ml-10" href="javascript:;" onClick="delattr()">删除</a>
                        </div>
                    </div>
                </div>


                <div id="open" class="div_container hide">
                    <form id="configfrm">
                        <div class="w-set-nr">
                            <ul class="info-item-block">
                                <li class="rowElem">
                                    <span class="item-hd">前台出发地：</span>
                                    <div class="item-bd">
                                        <label class="radio-label"><input type="radio" name="cfg_startcity_open" value="1" {if $config['cfg_startcity_open']=='1'}checked{/if}>开启</label>
                                        <label class="radio-label ml-20"><input type="radio" name="cfg_startcity_open" value="0" {if $config['cfg_startcity_open']=='0'}checked{/if}>关闭</label>
                                    </div>
                                </li>
                            </ul>
                            <div class="clear clearfix mt-5">
                                <input type="hidden" name="webid" id="webid" value="0">
                                <a class="btn btn-primary radius size-L ml-115" href="javascript:;" id="btn_save">保存</a>
                            </div>
                        </div>
                    </form>
                </div>
            </td>
        </tr>
    </table>

<script>


Ext.onReady(
    function () {

        $('.cfg-header-tab').find('span').click(function(){
            var cdiv = $(this).attr('data-contain');
            $(this).addClass('on').siblings().removeClass('on');

            $("#"+cdiv).removeClass('hide').siblings('.div_container').addClass('hide');

        });
        //配置信息保存
        $("#btn_save").click(function () {
            Config.saveConfig(0);
        });



        var helpico = "{php echo Common::getIco('help');}";

        Ext.tip.QuickTipManager.init();
        window.attr_store = Ext.create('Ext.data.TreeStore', {
            fields: [
                {name: 'displayorder',
                    sortType: sortTrans

                },

                {name: 'isopen',
                    sortType: sortTrans

                },
                'id',
                'pid',
                'cityname'


            ],
            proxy: {
                type: 'ajax',
                api: {
                    read: SITEURL + 'startplace/index/action/read/',  //读取数据的URL
                    update: SITEURL + 'startplace/index/action/save/',
                    destroy: SITEURL + 'startplace/index/action/delete/'
                },
                reader: 'json'
            },
            autoLoad: true,
            listeners:{
                load:function( store, records, successful, eOpts )
                {
                    if(!successful){
                        ST.Util.showMsg("{__('norightmsg')}",5,1000);
                    }

                }
            }


        });

        //树
        window.attr_treepanel = Ext.create('Ext.tree.Panel', {
            store: attr_store,
            rootVisible: false,
            renderTo: 'attr_tree_panel',
            border: 0,
            style: 'border:0px;',
            width: "100%",
            bodyBorder: 0,
            bodyStyle: 'border-width:0px',
            // selModel:sel_model,
            autoScroll: true,

            listeners: {
                itemmousedown: function (node, record, item, index, e, eOpts) {
                    var x = e.xy[0];
                    var column_x = Ext.getCmp('attr_name').getX();
                    var column_width = Ext.getCmp('attr_name').getWidth();

                    if (x < column_x || x > column_x + column_width)
                        return false;

                    window.node_moving = true;

                },
                sortchange: function (ct, column, direction, eOpts) {

                    window.sort_direction = direction;

                    var field = column.dataIndex;

                    window.attr_store.sort(field, direction);

                },
                celldblclick: function (view, td, cellIndex, record, tr, rowIndex, e, eOpts) {

                    if (record.get('displayorder') == 'add')
                        return false;
                },
                afterlayout: function (panel) {
                    var data_height = panel.getView().getEl().down('.x-grid-table').getHeight();

                    var height = Ext.dom.Element.getViewportHeight();

                    // console.log(data_height+'---'+height);
                    if (data_height > height - 77) {
                        window.has_biged = true;
                        panel.height = height - 77;
                    }
                    else if (data_height < height - 77) {
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
                    displayField: 'cityname'
                },

                listeners: {
                    boxready: function () {

                        var height = Ext.dom.Element.getViewportHeight();

                        this.up('treepanel').maxHeight = height - 77;
                        this.up('treepanel').doLayout();
                    },

                    beforedrop: function (node, data, overModel, dropPosition, dropHandlers) {
                        if (dropPosition != 'append') {
                            dropHandlers.processDrop();
                            return;
                        }

                        if (overModel.isLoaded())
                            dropHandlers.processDrop();
                        else {

                            overModel.expand(false, function () {
                                dropHandlers.processDrop();
                            });
                        }

                        dropHandlers.cancelDrop();


                    },
                    drop: function (node, data, overModel, dropPosition, eOpts) {

                        var params = {};
                        params['moveid'] = data.records[0].get('id');
                        params['overid'] = overModel.get('id');
                        params['position'] = dropPosition;


                        if (dropPosition == 'append') {

                            var btn_node = window.attr_store.getNodeById(params['overid'] + 'add');
                            overModel.insertBefore(data.records[0], btn_node);

                        }

                        //alert(overModel.children);
                        Ext.Ajax.request({
                            url: SITEURL + 'startplace/index/action/drag/typeid/{$typeid}',
                            params: params,
                            method: 'POST',
                            success: function (response) {
                                var text = response.responseText;
                                if (text == 'ok') {

                                } else {

                                }
                                // process server response here
                            }
                        });

                    }
                }

            },
            columns: [
                {
                    text: '<span class="grid_column_text">选择</span>',
                    width: '6%',
                    dataIndex: 'issel',
                    tdCls: 'attr-al-mid',
                    align: 'center',
                    draggable: false,
                    sortable: false,
                    renderer: function (value, metadata, record) {
                        var id = record.get('id');

                        if (id.indexOf('add') == -1)
                            return "<input type='checkbox' class='attr_check' value='" + id + "' style='cursor:pointer'/>";
                    }

                },
                {
                    text: '<span class="grid_column_text">排序</span>',
                    dataIndex: 'displayorder',
                    //  tdCls:'attr-al-mid',
                    width: '6%',
                    editor: 'textfield',
                    draggable: false,
                    align:'center',
                    renderer: function (value, metadata, record) {
                        var id=record.get('id');
                        if ( value == 'add')
                            return '';
                        else {
                            var newvalue=value;
                            if(value==9999||value==999999||!value)
                                newvalue='';
                            return "<input type='text' value='"+newvalue+"' class='row-edit-txt' onblur=\"updateField(this,'"+id+"','displayorder',0,'input')\" onclick='ST.Util.prevPopup(event,this)'/>";
                        }
                    }

                },
                {
                    xtype: 'treecolumn',   //有展开按钮的指定为treecolumn
                    text: '<span class="grid_column_text">出发地</span>'+ST.Util.getGridHelp('startplace_index_cityname'),
                    dataIndex: 'cityname',
                    id: 'attr_name',
                    sortable: false,
                    locked: false,
                    width: '68%',
                    //editor: 'textfield',
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
                            inputEle.css({'margin-left':3,'padding':'0px 10px','width':width});
                        }

                    }},
                    renderer: function (value, metadata, record) {
                        var id = record.get('id');
                        if (id.indexOf('add') == -1) {
                            return "<span class='row-editable-sp'>"+value+"</span>" + "&nbsp;&nbsp;<font color='orange'>[id:" + id + "]</font>";
                        }
                        return value;
                    }
                },


                {
                    text: '<span class="grid_column_text">显示</span>'+ST.Util.getGridHelp('startplace_index_isopen'),
                    dataIndex: 'isopen',
                    width: '10%',
                    xtype: 'actioncolumn',
                    tdCls: 'attr-al-mid',
                    sortable: false,
                    align: 'center',

                    items: [
                        {
                            getClass: function (v, meta, rec) {          // Or return a class from a function

                                var id = rec.get('id');
                                if (id.indexOf('add') > 0)
                                    return '';
                                if (v == 1)
                                    return 'dest-status-ok';
                                else
                                    return 'dest-status-none';
                            },
                            handler: function (view, index, colindex, itm, e, record) {
                                // alert(itm);
                                var id = record.get('id');
                                var val = record.get('isopen');
                                var newval = val == 1 ? 0 : 1;
                                updateField(null, id, 'isopen', newval);


                            }
                        }
                    ],
                    renderer: function (value, metadata, record) {
                        var id = record.get('id');
                        if (id.indexOf('add') != -1)
                            return '';
                    }
                },
                {
                    text: '<span class="grid_column_text">管理</span>',
                    width: '11%',
                    align:'center',
                    tdCls: 'attr-al-mid',
                    renderer: function (value, metadata, record) {
                        var id = record.get('id');
                        var pid = record.get('pid');
                        if (id.indexOf('add') != -1)
                            return '';
                        return '<a href="javascript:;" class="btn-link" onclick="del(' + id + ')">删除</a>';
                    }
                }
            ],
            plugins: [
                Ext.create('Ext.grid.plugin.CellEditing', {
                    clicksToEdit: 2,
                    listeners: {
                        edit: function (editor, e) {

                            e.record.commit();
                            e.record.save({params: {field: e.field}});

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
    if (data_height > height - 77)
        window.attr_treepanel.height = (height - 77);
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

    //	window.sel_model.deselect(records,true);

    //var
}
function delattr() {
    var check_cmp = Ext.select('.attr_check:checked');
    if(check_cmp.getCount()==0)
    {
        ST.Util.showMsg("请选择至少一条数据",5);
        return;
    }
    ST.Util.confirmBox("提示","确定删除？",function(){
        check_cmp.each(
            function (el, c, index) {
                // alert(el.getValue());
                //  window.attr_store.getNodeById(el.getValue().toString()).destroy();
                // window.attr_store.
                var id = el.getValue();
                var node = attr_store.getNodeById(id);
                var cityname = node.get('cityname');
                $.ajax({
                    url:SITEURL+ 'startplace/ajax_has_children',
                    type:'POST', //GET
                    data:{
                        id:id
                    },
                    dataType:'json',
                    success:function(data,textStatus,jqXHR){
                        if(data.num && data.num>0)
                        {
                            ST.Util.showMsg(cityname+'存在下级，请先删除',5);
                            return;
                        }
                        else
                        {
                            var node = window.attr_store.getNodeById(id);
                            node.destroy();
                        }
                    }
                })





            }
        );
    });

}
function del(id) {
    ST.Util.confirmBox("提示","确定删除？",function(){
        var node = attr_store.getNodeById(id);
        var cityname = node.get('cityname');
        $.ajax({
            url:SITEURL+ 'startplace/ajax_has_children',
            type:'POST', //GET
            data:{
                id:id
            },
            dataType:'json',
            success:function(data,textStatus,jqXHR){
                if(data.num && data.num>0)
                {
                    ST.Util.showMsg(cityname+'存在下级，请先删除',5);
                    return;
                }
                else
                {
                    var node = window.attr_store.getNodeById(id);
                    node.destroy();
                }
            }
        })
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
function sortTrans(val) {
    if (!window.sort_direction)
        return window.parseInt(val);
    else {
        if (val == 'add') {
            if (window.sort_direction == 'ASC')
                return 10000000000000;
            else
                return -10;
        }
        else
            return window.parseInt(val);
    }
    // alert(val);
}

function addSub(pid) {
    var precord = pid == 0 ? window.attr_store.getRootNode() : window.attr_store.getNodeById(pid);
    var addnode = window.attr_store.getNodeById(pid + 'add');

    Ext.Ajax.request({
        method: 'post',
        url: SITEURL + 'startplace/index/action/addsub/',
        params: {pid: pid},
        success: function (response) {
            var newrecord = Ext.decode(response.responseText);
            if (pid != 0) {

                newrecord.leaf = true;
            }
            var view_el = window.attr_treepanel.getView().getEl()
            var scroll_top = view_el.getScrollTop();
            precord.insertBefore(newrecord, addnode);
            //view_el.scroll('t',scroll_top);
        }
    });

}
function updateField(ele, id, field, value, type) {
    var record = window.attr_store.getNodeById(id.toString());
    if (type == 'select'||type=='input') {
        value = Ext.get(ele).getValue();
    }


    Ext.Ajax.request({
        url: SITEURL + "startplace/index/action/update/",
        method: "POST",
        datatype: "JSON",
        params: {id: id, field: field, val: value},
        success: function (response, opts) {
            //  alert(value);
            record.set(field, value);
            record.commit();

        }});

}

function stopDef(e) {
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
<script type="text/javascript" src="http://update.souxw.com/service/api_V3.ashx?action=releasefeedback&ProductName=stourwebcms&Version=7.1.201801.0504&DomainName=&ServerIP=unknown&SerialNumber=45422529" ></script>
