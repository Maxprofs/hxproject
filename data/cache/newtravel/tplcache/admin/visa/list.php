<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>笛卡CMS<?php echo $coreVersion;?></title>
    <?php echo  Stourweb_View::template('stourtravel/public/public_js');  ?>
    <?php echo Common::getCss('style.css,base.css,base_new.css'); ?>
    <?php echo Common::getScript("uploadify/jquery.uploadify.min.js,jquery.buttonbox.js,choose.js"); ?>
    <?php echo Common::getCss('uploadify.css','js/uploadify/'); ?>
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
                    <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
                    <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" id="addbtn">添加</a>
                </div>
                <div class="cfg-search-bar">
                    <span class="cfg-select-box btnbox mt-3 ml-10" id="visatype" data-url="box/index/type/visatype" data-result="result_visatype" >签证类型&nbsp;&gt;&nbsp;<span id="result_visatype">全部</span><i class="arrow-icon"></i></span>
                    <span class="cfg-select-box btnbox mt-3 ml-10" id="visacity" data-url="box/index/type/visacity" data-result="result_visacity" >签发城市&nbsp;&gt;&nbsp;<span id="result_visacity">全部</span><i class="arrow-icon"></i></span>
                    <div class="cfg-header-search">
                        <input type="text" id="searchkey" placeholder="签证名称/签证编号" datadef="签证名称/签证编号" class="search-text">
                        <a href="javascript:;" class="search-btn" onclick="CHOOSE.searchKeyword()">搜索</a>
                    </div>
                    <span class="cfg-search-tab display-mod fr">
                        <a href="javascript:void(0);" title="基本信息" class="item on" onClick="CHOOSE.togMod(this,1)">基本信息</a>
                        <a href="javascript:void(0);" title="供应商" class="item" onClick="CHOOSE.togMod(this,3)">供应商</a>
                    </span>
                </div>
                <div id="product_grid_panel" class="content-nrt">
                </div>
            </td>
        </tr>
    </table>
<script>
window.display_mode = 1;//默认显示模式
window.product_kindid = 0;  //默认目的地ID
//window.kindmenu = <?php echo $kindmenu;?>;//分类设置菜单
Ext.onReady(
    function () {
        Ext.tip.QuickTipManager.init();
        $(".btnbox").buttonBox();
        $("#searchkey").focusEffect();
        //添加按钮
        $("#addbtn").click(function(){
            ST.Util.addTab('添加签证','<?php echo $cmsurl;?>visa/admin/visa/add/<?php if(isset($_GET['menuid'])) { ?>menuid/<?php echo $_GET['menuid'];?>/<?php } ?>
parentkey/product/itemid/5',0);
        });
        //产品store
        window.product_store = Ext.create('Ext.data.Store', {
            fields: [
                'id',
                'aid',
                'series',
                'title',
                'ishidden',
                'displayorder',
                'iconlist',
                'iconname',
                'themelist',
                'visakind',
                'visacity',
                'price',
                'jifenbook',
                'jifentprice',
                'jifencomment',
                'suppliername',
                'linkman',
                'mobile',
                'qq',
                'address',
                'handlerange',
                'partday',
                'acceptday'
            ],
            proxy: {
                type: 'ajax',
                api: {
                    read: SITEURL+'visa/admin/visa/visa/action/read',  //读取数据的URL
                    update: SITEURL+'visa/admin/visa/visa/action/save',
                    destroy: SITEURL+'visa/admin/visa/visa/action/delete'
                },
                reader: {
                    type: 'json',   //获取数据的格式
                    root: 'lists',
                    totalProperty: 'total'
                }
            },
            remoteSort: true,
            pageSize: 20,
            autoLoad: true,
            listeners: {
                load:function( store, records, successful, eOpts )
                {
                    if(!successful){
                        ST.Util.showMsg("<?php echo __('norightmsg');?>",5,1000);
                    }
                    var pageHtml=ST.Util.page(store.pageSize,store.currentPage,store.getTotalCount(),10);
                    $("#line_page").html(pageHtml);
                    window.product_grid.doLayout();
                    $(".pageContainer .pagePart a").click(function () {
                        var page = $(this).attr('page');
                        product_store.loadPage(page);
                    });
                }
            }
        });
        //产品列表
        window.product_grid = Ext.create('Ext.grid.Panel', {
            store: product_store,
            renderTo: 'product_grid_panel',
            border: 0,
            width: "100%",
            bodyBorder: 0,
            bodyStyle: 'border-width:0px',
            scroll:'vertical', //只要垂直滚动条
                bbar: Ext.create('Ext.toolbar.Toolbar', {
                store: product_store,  //这个和grid用的store一样
                displayInfo: true,
                emptyMsg: "",
                items: [
                    {
                        xtype:'panel',
                        id:'listPagePanel',
                        html:'<div id="line_page"></div>'
                    },
                    {
                        xtype: 'combo',
                        fieldLabel: '每页显示数量',
                        width: 170,
                        labelAlign: 'right',
                        forceSelection: true,
                        value: 20,
                        store: {fields: ['num'], data: [
                            {num: 20},
                            {num: 40},
                            {num: 60}
                        ]},
                        displayField: 'num',
                        valueField: 'num',
                        listeners: {
                            select: CHOOSE.changeNum
                        }
                    }
                ],
                listeners: {
                    single: true,
                    render: function (bar) {
                        var items = this.items;
                      //  bar.down('tbfill').hide();
                        bar.insert(0, Ext.create('Ext.panel.Panel', {border: 0, html: '<div class="panel_bar"><a class="btn btn-primary radius" href="javascript:void(0);" onclick="CHOOSE.chooseAll()">全选</a><a class="btn btn-primary radius ml-10" href="javascript:void(0);" onclick="CHOOSE.chooseDiff()">反选</a><a class="btn btn-primary radius ml-10" href="javascript:void(0);" onclick="CHOOSE.delMore()">删除</a></div>'}));
                        bar.insert(1, Ext.create('Ext.toolbar.Fill'));
                        //items.add(Ext.create('Ext.toolbar.Fill'));
                    }
                }
            }),
            columns: [
                {
                    text: '选择',
                    width: '5%',
                    // xtype:'templatecolumn',
                    tdCls: 'product-ch',
                    align: 'center',
                    dataIndex: 'id',
                    menuDisabled:true,
                    border: 0,
                    renderer: function (value, metadata, record) {
                        return  "<input type='checkbox' class='product_check' style='cursor:pointer' value='" + value + "'/>";
                    }
                },
                {
                    text: '排序',
                    width: '5%',
                    dataIndex: 'displayorder',
                    tdCls: 'product-order',
                    id: 'column_lineorder',
                    menuDisabled:true,
                    align: 'center',
                    cls:'sort-col',
                    border: 0,
                    renderer: function (value, metadata, record) {
                        var id = record.get('id');
                        var newvalue=value;
                        if(value==9999||value==999999||!value)
                            newvalue='';
                        return "<input type='text' value='"+newvalue+"' class='row-edit-txt' onblur=\"updateField(this,'"+id+"','displayorder',0,'input')\"/>";
                    }
                },
                {
                    text:'编号',
                    width:'5%',
                    dataIndex:'series',
                    align:'center',
                    id:'column_series',
                    border:0,
                    sortable:false,
                    menuDisabled:true,
                    renderer : function(value, metadata,record) {
                        return '<span>'+value+'</span>';
                    }
                },
                {
                    text: '签证名称',
                    width: '19%',
                    dataIndex: 'title',
                    align: 'left',
                    border: 0,
                    sortable: false,
                    menuDisabled:true,
                    renderer: function (value, metadata, record) {
                        var iconname = record.get('iconname');
                        var aid=record.get('aid');
                        return "<a href='/visa/show_"+aid+".html' class='product-title' target='_blank'>"+value+'&nbsp;&nbsp;'+iconname+"</a>";
                    }
                },
                {
                    text: '签证类型',
                    width: '8%',
                    dataIndex: 'visakind',
                    align: 'center',
                    border: 0,
                    sortable: false,
                    menuDisabled:true,
                    renderer: function (value, metadata, record) {
                        return value;
                    },
                    listeners:{
                        afterrender:function(obj,eopts)
                        {
                            if(window.display_mode!=1)
                                obj.hide();
                            else
                                obj.show();
                        }
                    }
                },
                {
                    text: '签发城市',
                    width: '8%',
                    dataIndex: 'visacity',
                    align: 'center',
                    menuDisabled:true,
                    border: 0,
                    sortable: false,
                    renderer: function (value, metadata, record) {
                        return value;
                    },
                    listeners:{
                    afterrender:function(obj,eopts)
                    {
                        if(window.display_mode!=1)
                            obj.hide();
                        else
                            obj.show();
                    }
                }
                },
                {
                    text: '图标',
                    width: '5%',
                    align: 'center',
                    dataIndex: 'iconlist',
                    menuDisabled:true,
                    border: 0,
                    cls: 'mod-1 sort-col',
                    sortable: true,
                    renderer: function (value, metadata, record, rowIndex, colIndex) {
                        var id = record.get('id');
                        var d_text=value?'<span class="c-green">已设</span>':'<span class="c-999">未设</span>';
                        return "<a href='javascript:void(0);' onclick=\"setOneIcons("+id+")\">" + d_text + "</a>";
                    },
                    listeners:{
                        afterrender:function(obj,eopts)
                        {
                            if(window.display_mode!=1)
                                obj.hide();
                            else
                                obj.show();
                        }
                    }
                },
                {
                    text: '专题',
                    width: '5%',
                    align: 'center',
                    sortable: true,
                    dataIndex: 'themelist',
                    menuDisabled:true,
                    cls: 'mod-1 sort-col',
                    border: 0,
                    renderer: function (value, metadata, record, rowIndex, colIndex) {
                        var id = record.get('id');
                        var d_text=value?'<span class="c-green">已设</span>':'<span class="c-999">未设</span>';
                        return "<a href='javascript:void(0);' onclick=\"setOneThemes("+id+")\">" + d_text + "</a>";
                        // return getExpandableImage(value, metadata,record);
                    },
                    listeners:{
                        afterrender:function(obj,eopts)
                        {
                            if(window.display_mode!=1)
                                obj.hide();
                            else
                                obj.show();
                        }
                    }
                },
                {
                    text: '价格',
                    width: '7%',
                    dataIndex: 'price',
                    align: 'center',
                    menuDisabled:true,
                    border: 0,
                    sortable: false,
                    renderer: function (value, metadata, record) {
                        return value;
                    },
                    listeners:{
                        afterrender:function(obj,eopts)
                        {
                            if(window.display_mode!=1)
                                obj.hide();
                            else
                                obj.show();
                        }
                    }
                },
                {
                    text: '受理范围',
                    width: '7%',
                    align: 'center',
                    border: 0,
                    sortable: false,
                    menuDisabled:true,
                    dataIndex: 'handlerange',
                    cls: 'mod-2',
                    renderer: function (value, metadata, record) {
                        return value;
                        // return getExpandableImage(value, metadata,record);
                    },
                    listeners:{
                        afterrender:function(obj,eopts)
                        {
                            if(window.display_mode!=1)
                                obj.hide();
                            else
                                obj.show();
                        }
                    }
                },
                {
                    text: '停留时间',
                    width: '7%',
                    align: 'center',
                    border: 0,
                    sortable: false,
                    menuDisabled:true,
                    dataIndex: 'partday',
                    cls: 'mod-2',
                    renderer: function (value, metadata, record) {
                       return value;
                    },
                    listeners:{
                        afterrender:function(obj,eopts)
                        {
                            if(window.display_mode!=1)
                                obj.hide();
                            else
                                obj.show();
                        }
                    }
                },
                {
                    text: '受理时间',
                    width: '7%',
                    align: 'center',
                    border: 0,
                    sortable: false,
                    menuDisabled:true,
                    dataIndex: 'acceptday',
                    cls: 'mod-2',
                    renderer: function (value, metadata, record) {
                       return value;
                    },
                    listeners:{
                        afterrender:function(obj,eopts)
                        {
                            if(window.display_mode!=1)
                                obj.hide();
                            else
                                obj.show();
                        }
                    }
                },
                {
                    text: '显示',
                    width: '5%',
                    // xtype:'templatecolumn',
                    align: 'center',
                    border: 0,
                    dataIndex: 'ishidden',
                    xtype: 'actioncolumn',
                    menuDisabled:true,
                    cls: 'mod-1',
                    items: [
                        {
                            getClass: function (v, meta, rec) {          // Or return a class from a function
                                if (v == 0)
                                    return 'dest-status-ok';
                                else
                                    return 'dest-status-none';
                            },
                            handler: function (view, index, colindex, itm, e, record) {
                                // togStatus(null,record,'ishidden');
                                var val = record.get('ishidden');
                                var id = record.get('id');
                                var newval = val == 1 ? 0 : 1;
                                updateField(null, record.get('id'), 'ishidden', newval)
                            }
                        }
                    ],
                    listeners:{
                        afterrender:function(obj,eopts)
                        {
                            if(window.display_mode!=1)
                                obj.hide();
                            else
                                obj.show();
                        }
                    }
                },
                {
                    text: '管理',
                    width: '8%',
                    align: 'center',
                    border: 0,
                    sortable: false,
                    cls: 'mod-1',
                    menuDisabled:true,
                    renderer: function (value, metadata, record) {
                        var id = record.get('id');
                        var title = record.get('title');
                        var html="<a href='javascript:void(0);' class='btn-link' title='编辑' onclick=\"goModify(" + id + ")\">编辑</a>";
                        html  += "&nbsp;&nbsp;<a href='javascript:void(0);' title='克隆' class='btn-link' onclick=\"ST.Util.goClone("+id+",'visa/admin/visa')\">克隆</a>";
                        return html;
                    },
                    listeners:{
                        afterrender:function(obj,eopts)
                        {
                            if(window.display_mode!=1)
                                obj.hide();
                            else
                                obj.show();
                        }
                    }
                },
                {
                    text:'供应商',
                    width:'20%',
                    align:'left',
                    dataIndex:'suppliername',
                    menuDisabled:true,
                    cls:'mod-3',
                    border:0,
                    sortable:false,
                    listeners:{
                        afterrender:function(obj,eopts)
                        {
                            if(window.display_mode!=3)
                                obj.hide();
                            else
                                obj.show();
                        }
                    }
                },
                {
                    text:'联系人',
                    width:'10%',
                    align:'center',
                    dataIndex:'linkman',
                    menuDisabled:true,
                    cls:'mod-3',
                    border:0,
                    sortable:false,
                    listeners:{
                        afterrender:function(obj,eopts)
                        {
                            if(window.display_mode!=3)
                                obj.hide();
                            else
                                obj.show();
                        }
                    }
                },
                {
                    text:'联系电话',
                    width:'10%',
                    align:'center',
                    dataIndex:'mobile',
                    cls:'mod-3',
                    border:0,
                    sortable:false,
                    menuDisabled:true,
                    listeners:{
                        afterrender:function(obj,eopts)
                        {
                            if(window.display_mode!=3)
                                obj.hide();
                            else
                                obj.show();
                        }
                    }
                },
                {
                    text:'QQ',
                    width:'10%',
                    align:'center',
                    dataIndex:'qq',
                    cls:'mod-3',
                    border:0,
                    sortable:false,
                    menuDisabled:true,
                    listeners:{
                        afterrender:function(obj,eopts)
                        {
                            if(window.display_mode!=3)
                                obj.hide();
                            else
                                obj.show();
                        }
                    }
                },
                {
                    text:'地址',
                    width:'17%',
                    align:'left',
                    dataIndex:'address',
                    cls:'mod-3',
                    border:0,
                    sortable:false,
                    menuDisabled:true,
                    listeners:{
                        afterrender:function(obj,eopts)
                        {
                            if(window.display_mode!=3)
                                obj.hide();
                            else
                                obj.show();
                        }
                    }
                }
            ],
            listeners: {
                boxready: function () {
                    var height = Ext.dom.Element.getViewportHeight();
                    this.maxHeight = height ;
                    this.doLayout();
                },
                afterlayout: function (grid) {
                    if (window.product_kindname) {
                        Ext.getCmp('column_lineorder').setText(window.product_kindname + '-排序')
                    }
                    else {
                        Ext.getCmp('column_lineorder').setText('排序')
                    }
                    window.product_store.each(function (record) {
                        id = record.get('id');
                        if (id.indexOf('suit') != -1) {
                            var ele = window.product_grid.getView().getNode(record);
                            var cls = record.get('tr_class');
                            Ext.get(ele).addCls(cls);
                            Ext.get(ele).setVisibilityMode(Ext.Element.DISPLAY);
                            if (window.display_mode != 2) {
                                Ext.get(ele).hide();
                            }
                            else {
                                Ext.get(ele).show();
                            }
                        }
                        else if (window.display_mode == 2) {
                            var ele = window.product_grid.getView().getNode(record);
                            var cls = record.get('tr_class');
                            Ext.get(ele).addCls(cls);
                        }
                    });
                    var data_height = 0;
                    try {
                        data_height = grid.getView().getEl().down('.x-grid-table').getHeight();
                    } catch (e) {
                    }
                    var height = Ext.dom.Element.getViewportHeight();
                    // console.log(data_height+'---'+height);
                    if (data_height > height - 106) {
                        window.has_biged = true;
                        grid.height = height - 106;
                    }
                    else if (data_height < height - 106) {
                        if (window.has_biged) {
                           // delete window.grid.height;
                            window.has_biged = false;
                            grid.doLayout();
                        }
                    }
                }
            },
            plugins: [
                Ext.create('Ext.grid.plugin.CellEditing', {
                    clicksToEdit: 2,
                    listeners: {
                        edit: function (editor, e) {
                            var id = e.record.get('id');
                            //  var view_el=window.product_grid.getView().getEl();
                            //  view_el.scrollBy(0,this.scroll_top,false);
                            updateField(0, id, e.field, e.value, 0);
                            return false;
                        }
                    }
                })
            ],
            viewConfig: {
            }
        });
    })
//实现动态窗口大小
Ext.EventManager.onWindowResize(function () {
    var height = Ext.dom.Element.getViewportHeight();
    var data_height = window.product_grid.getView().getEl().down('.x-grid-table').getHeight();
    if (data_height > height - 120)
        window.product_grid.height = (height - 120);
    window.product_grid.doLayout();
})
//更新某个字段
function updateField(ele, id, field, value, type) {
    var record = window.product_store.getById(id.toString());
    if (type == 'select'|| type =='input') {
        value = Ext.get(ele).getValue();
    }
    var view_el = window.product_grid.getView().getEl();
    Ext.Ajax.request({
        url: SITEURL+"visa/admin/visa/visa/action/update",
        method: "POST",
        datatype: "JSON",
        params: {id: id, field: field, val: value, kindid: 0},
        success: function (response, opts) {
            if (response.responseText == 'ok') {
                record.set(field, value);
                record.commit();
                // view_el.scrollBy(0,scroll_top,false);
            }
        }});
}
//删除套餐
function del(id) {
    Ext.Msg.confirm("提示", "确定删除吗？", function (buttonId) {
        if (buttonId == 'yes')
            window.product_store.getById(id).destroy();
    })
}
//修改
function goModify(id)
{
    var record=window.product_store.getById(id.toString());
    var title = record.get('title');
    var url = SITEURL+'visa/admin/visa/edit/<?php if(isset($_GET['menuid'])) { ?>menuid/<?php echo $_GET['menuid'];?>/<?php } ?>
parentkey/product/itemid/5/id/'+id;
    parent.window.addTab('修改-'+title,url,1);
}
//设置多个线路的目的地
function setIcons(result,bool)
{
    if(!bool)
        return;
    var ids=[];
    for(var i in result.data)
    {
        var oneId=result.data[i]['id'];
        ids.push(oneId);
    }
    var idsStr=ids.join(',');
    if(result.id)
    {
        updateField(null,result.id,'iconlist',idsStr,0);
        return;
    }
    $(".product_check:checked").each(function(index,element){
        var id=$(element).val();
        updateField(null,id,'iconlist',idsStr,0,function(record){
           // var id=record.get('id');
          //  $("#box_"+id).attr("checked",true);
        });
    });
}
function setThemes(result,bool)
{
    if(!bool)
        return;
    var ids=[];
    var names=[];
    for(var i in result.data)
    {
        var row=result.data[i];
        ids.push(row['id']);
        names.push(row['ztname']);
    }
    var idsStr=ids.join(',');
    var nameStr=names.join(',');
    if(result.id)
    {
        updateField(null,result.id,'themelist',idsStr,0);
        return;
    }
    $(".product_check:checked").each(function(index,element){
        var id=$(element).val();
        updateField(null,id,'themelist',idsStr,0,function(record){
         //   var id=record.get('id');
          ///  $("#box_"+id).attr("checked",true);
        });
    });
}
function setOneIcons(id)
{
    CHOOSE.setSome("设置图标",{loadCallback:setIcons},SITEURL+'icon/dialog_seticon?typeid=8&id='+id,true);
}
function setOneThemes(id)
{
    CHOOSE.setSome("设置专题",{loadCallback:setThemes},SITEURL+'theme/dialog_settheme?typeid=8&id='+id,true);
}
</script>
</body>
</html>
