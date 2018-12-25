<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>扩展属性-笛卡CMS{$coreVersion}</title>
    {template 'stourtravel/public/public_js'}
    {php echo Common::getCss('style.css,base.css,base_new.css'); }
    {php echo Common::getScript("choose.js"); }

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
                        <input type="text" id="searchkey" placeholder="方案名称"  datadef="方案名称" class="search-text">
                        <a href="javascript:;" class="search-btn" onclick="searchKeyword()">搜索</a>
                    </div>
                    <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
                    <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" id="addbtn">添加</a>
                </div>
                <div id="product_grid_panel" class="content-nrt">
                </div>
            </td>
        </tr>
    </table>

<script>

Ext.onReady(
    function () {
        Ext.tip.QuickTipManager.init();

        $("#searchkey").focusEffect();
        //添加按钮
        $("#addbtn").click(function(){
            var url=SITEURL+"customize/admin/plan/add{if isset($_GET['menuid'])}/menuid/{$_GET['menuid']}{/if}";
            ST.Util.addTab('添加方案',url,0);
        });

        //产品store
        window.product_store = Ext.create('Ext.data.Store', {

            fields: [
                'id',
                'title',
                'shownum',
                'dest',
                'startplace',
                'days',
                'adultnum',
                'childnum',
                'addtime',
                'modtime',
                'starttime',
                'displayorder',
                'url'
            ],
            proxy: {
                type: 'ajax',
                api: {
                    read: SITEURL+'customize/admin/plan/index/action/read',  //读取数据的URL
                    destroy:  SITEURL+'customize/admin/plan/index/action/delete'
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
                load: function (store, records, successful, eOpts) {
                    var pageHtml = ST.Util.page(store.pageSize, store.currentPage, store.getTotalCount(), 10);
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
                            select: changeNum
                        }
                    }

                ],

                listeners: {
                    single: true,
                    render: function (bar) {
                        var items = this.items;
                        bar.insert(0,Ext.create('Ext.panel.Panel',{border:0,html:'<div class="panel_bar"><a class="btn btn-primary radius" href="javascript:void(0);" onclick="CHOOSE.chooseAll()">全选</a><a class="btn btn-primary radius ml-10" href="javascript:void(0);" onclick="CHOOSE.chooseDiff()">反选</a><a class="btn btn-primary radius ml-10" href="javascript:void(0);" onclick="CHOOSE.delMore()">删除</a></div>'}));
                        bar.insert(2,Ext.create('Ext.toolbar.Fill'));
                    }
                }
            }),
            columns: [
                {
                    text:'选择',
                    width:'5%',
                    // xtype:'templatecolumn',
                    tdCls:'product-ch',
                    align:'center',
                    dataIndex:'id',
                    border:0,
                    menuDisabled:true,
                    renderer : function(value, metadata,record) {
                         return  "<input type='checkbox' class='product_check' id='box_"+value+"' style='cursor:pointer' value='"+value+"'/>";
                    }

                },
                {
                    text: '排序',
                    width: '6%',
                    align: 'center',
                    menuDisabled:true,
                    dataIndex:'displayorder',
                    sortable: true,
                    cls:'sort-col',
                    border: 0,
                    renderer: function (value, metadata, record) {
                        var id=record.get('id');
                        var newvalue=value;
                        if(value==9999||value==999999)
                            newvalue='';
                        return "<input type='text' value='"+newvalue+"' class='row-edit-txt' onblur=\"updateField(this,'"+id+"','displayorder',0,'input')\"/>";
                    }
                },
                {
                    text: '标题',
                    width: '24%',
                    dataIndex: 'title',
                    align: 'left',
                    border: 0,
                    sortable: false,
                    menuDisabled:true,
                    renderer: function (value, metadata, record) {
                            var url=record.get('url');
                            return "<a href='"+url+"' class='line-title' target='_blank'>"+value+"</a>";
                    }

                },
                {
                    text: '目的地',
                    width: '11%',
                    dataIndex: 'dest',
                    align: 'center',
                    border: 0,
                    sortable: false,
                    menuDisabled:true,
                    renderer: function (value, metadata, record) {
                        return value;
                    }

                },
                {
                    text: '出发地',
                    width: '11%',
                    dataIndex: 'startplace',
                    align: 'center',
                    border: 0,
                    sortable: false,
                    menuDisabled:true,
                    renderer: function (value, metadata, record) {
                        return value;
                    }

                },
                {
                    text: '出游天数',
                    width: '8%',
                    dataIndex: 'days',
                    align: 'center',
                    border: 0,
                    sortable: false,
                    menuDisabled:true,
                    renderer: function (value, metadata, record) {
                        return value;
                    }
                },
                {
                    text: '成人数',
                    width: '8%',
                    dataIndex: 'adultnum',
                    align: 'center',
                    border: 0,
                    sortable: false,
                    menuDisabled:true,
                    renderer: function (value, metadata, record) {
                        return value;
                    }
                },
                {
                    text: '儿童数',
                    width: '8%',
                    dataIndex: 'childnum',
                    align: 'center',
                    border: 0,
                    sortable: false,
                    menuDisabled:true,
                    renderer: function (value, metadata, record) {
                        return value;
                    }
                },
                {
                    text: '出发日期',
                    width: '10%',
                    dataIndex: 'starttime',
                    align: 'center',
                    border: 0,
                    cls:'sort-col',
                    sortable: true,
                    menuDisabled:true,
                    renderer: function (value, metadata, record) {
                        return value;
                    }
                },
                {
                    text: '管理',
                    width: '9%',
                    align: 'center',
                    border: 0,
                    sortable: false,
                    menuDisabled:true,
                    renderer: function (value, metadata, record) {
                        var id = record.get('id');
                        var html ="<a href='javascript:;' title='编辑' class='btn-link' onclick=\"goModify("+id+")\">编辑</a>";
                        return html;
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

            ],
            viewConfig: {

            }
        });


    })

//实现动态窗口大小
Ext.EventManager.onWindowResize(function () {
    var height = Ext.dom.Element.getViewportHeight();
    var data_height = window.product_grid.getView().getEl().down('.x-grid-table').getHeight();
    if (data_height > height - 106)
        window.product_grid.height = (height - 106);
    else
        delete window.product_grid.height;
    window.product_grid.doLayout();


})



function togStatus(obj, record, field) {
    var val = record.get(field);
    var id = record.get('id');
    id = id.substr(id.indexOf('_') + 1);
    var newval = val == 1 ? 0 : 1;
    Ext.Ajax.request({
        url: SITEURL+"customize/admin/plan/index/action/update",
        method: "POST",
        datatype: "JSON",
        params: {id: id, field: field, val: newval},
        success: function (response, opts) {
            if (response.responseText == 'ok') {
                record.set(field, newval);
                record.commit();
            }
        }});

}
//切换每页显示数量
function changeNum(combo, records) {

    var pagesize = records[0].get('num');
    window.product_store.pageSize = pagesize;
    //window.product_grid.down('pagingtoolbar').moveFirst();
    window.product_store.load({start:0});
}
//选择全部
function chooseAll() {
    var check_cmp = Ext.query('.product_check');
    for (var i in check_cmp) {
        if (!Ext.get(check_cmp[i]).getAttribute('checked'))
            check_cmp[i].checked = 'checked';
    }

    //  window.sel_model.selectAll();
}
//反选
function chooseDiff() {
    var check_cmp = Ext.query('.product_check');
    for (var i in check_cmp)
        check_cmp[i].click();

}


//更新某个字段
function updateField(ele, id, field, value, type) {
    var record = window.product_store.getById(id.toString());

    if (type == 'select' || type=='input') {
        value = Ext.get(ele).getValue();
    }
    var view_el = window.product_grid.getView().getEl();


    Ext.Ajax.request({
        url: SITEURL+"customize/admin/plan/index/action/update",
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

function searchKeyword() {
    var keyword = $.trim($("#searchkey").val());
    var datadef = $("#searchkey").attr('datadef');
    keyword = keyword==datadef ? '' : keyword;
    window.product_store.getProxy().setExtraParam('keyword',keyword);
    window.product_store.loadPage(1);
}

//修改
function goModify(id)
{
    var record = window.product_store.getById(id.toString());
    var title = record.get('title');
    var url=SITEURL+"customize/admin/plan/edit/id/"+id+'{if isset($_GET['menuid'])}/menuid/{$_GET['menuid']}{/if}';
    parent.window.addTab('修改-'+title,url,1);
}
</script>
</body>
</html>
