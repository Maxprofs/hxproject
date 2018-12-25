<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>线路订单管理-笛卡CMS{$coreVersion}</title>
    {template 'stourtravel/public/public_js'}
    {php echo Common::getCss('style.css,base.css,base_new.css'); }
    {php echo Common::getScript("jquery.buttonbox.js,choose.js"); }
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
                    <div class="fl select-box w100 mt-5 ml-10">
                        <select name="webid" onchange="togStatus(this)"  class="select">
                            <option value="0" >提现状态</option>
                            <option value="1">待审核</option>
                            <option value="2">未通过</option>
                            <option value="3">已提现</option>
                        </select>
                    </div>
                    <div class="cfg-header-search">
                        <input type="text" id="searchkey" placeholder="供应商名称" datadef="供应商名称" class="search-text" />
                        <a href="javascript:;" class="search-btn" onclick="searchKeyword()">搜索</a>
                    </div>
                    <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
                </div>
                <div id="product_grid_panel" class="content-nrt" >

                </div>
            </td>
        </tr>
    </table>

<script>
window.display_mode = 1;	//默认显示模式
Ext.onReady(
    function () {
        Ext.tip.QuickTipManager.init();
        //var editico = "{php echo Common::getIco('edit');}";
        var delico = "{php echo Common::getIco('del');}";
        var editico = "{php echo Common::getIco('order');}";
        var unviewico="{php echo Common::getIco('order_unview');}";

        $("#searchkey").focusEffect();




        //产品store
        window.product_store = Ext.create('Ext.data.Store', {

            fields: [
                'id',
                'withdrawamount',
                'addtime',
                'status',
                'proceeds_type_title',
                'suppliername',
                'allow_price',
                'withdraw_price_finish',
                'withdraw_price_approval',
                'brokerage_price',
            ],

            proxy: {
                type: 'ajax',
                api: {
                    read: SITEURL+'supplier_brokerage/admin/brokerage/approval/action/read/',  //读取数据的URL
                    update: SITEURL+'supplier_brokerage/admin/brokerage/approval/action/save/',
                    destroy: SITEURL+'supplier_brokerage/admin/brokerage/approval/action/delete/'
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
                    if(!successful){
                        ST.Util.showMsg("{__('norightmsg')}",5,1000);
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
                            select: changeNum
                        }
                    }

                ],

                listeners: {
                    single: true,
                    render: function (bar) {
                        var items = this.items;
                      //  bar.down('tbfill').hide();

                        bar.insert(0, Ext.create('Ext.panel.Panel', {border: 0, html: '<div class="panel_bar"></div>'}));

                        bar.insert(1, Ext.create('Ext.toolbar.Fill'));
                        //items.add(Ext.create('Ext.toolbar.Fill'));
                    }
                }
            }),
            columns: [
                {
                    text: '商家名称',
                    width: '15%',
                    dataIndex: 'suppliername',
                    align: 'center',
                    border: 0,
                    sortable: false,
                    menuDisabled:true,
                    renderer: function (value, metadata, record) {
                        return value;
                    }

                },
                {
                    text: '收款时间',
                    width: '15%',
                    dataIndex: 'addtime',
                    align: 'center',
                    border: 0,
                    sortable: false,
                    menuDisabled:true,
                    renderer: function (value, metadata, record) {
                        return value;
                    }
                },
                {
                    text: '提现金额',
                    width: '10%',
                    dataIndex: 'withdrawamount',
                    align: 'center',
                    border: 0,
                    sortable: false,
                    menuDisabled:true,
                    renderer: function (value, metadata, record) {
                        if(value>0)
                        {
                            return '<i class="c-f60">'+value+'</i>'
                        }
                        return value;
                    }

                },

                {
                    text: '可提现金额',
                    width: '15%',
                    dataIndex: 'allow_price',
                    align: 'center',
                    border: 0,
                    sortable: false,
                    menuDisabled:true,
                    renderer: function (value, metadata, record) {
                        return value;
                    }

                },
                {
                    text: '已提现金额',
                    width: '15%',
                    dataIndex: 'withdraw_price_finish',
                    align: 'center',
                    border: 0,
                    sortable: false,
                    menuDisabled:true,
                    renderer: function (value, metadata, record) {
                        return value;
                    }

                },
                {
                    text: '提现到',
                    width: '10%',
                    dataIndex: 'proceeds_type_title',
                    align: 'center',
                    border: 0,
                    sortable: false,
                    menuDisabled:true,
                    renderer: function (value, metadata, record) {
                        return value;
                    }

                },

                {
                    text: '提现状态',
                    width: '10%',
                    dataIndex: 'status',
                    align: 'center',
                    border: 0,
                    sortable: false,
                    menuDisabled:true,
                    renderer: function (value, metadata, record) {
                        if(value==0)
                        {
                            return '<i style="color: red">待审核</i>'
                        }
                        else if(value==1)
                        {
                            return '已提现'
                        }
                        else  if(value==2)
                        {
                            return '未通过'
                        }

                    }

                },

                {
                    text: '操作',
                    width: '10%',
                    align: 'center',
                    border: 0,
                    sortable: false,
                    menuDisabled:true,
                    cls: 'mod-1',
                    renderer: function (value, metadata, record) {

                        var id = record.get('id');
                        var status = record.get('status');
                        if(status==0)
                        {
                            var text = '审核';
                        }
                        else
                        {
                            var  text = '详情';
                        }
                        var html = "<a href='javascript:void(0);' onclick='modify(" + id + ")' class='btn-link va-m ml-10'>"+text+"</a>";
                        return html;


                    }
                }
            ],
            listeners: {
                boxready: function () {


                    var height = Ext.dom.Element.getViewportHeight();
                    //console.log('viewportHeight:'+height);
                    this.maxHeight = height-76 ;
                    this.doLayout();
                },
                afterlayout: function (grid) {






               /*    var data_height = 0;
                    try {
                        data_height = grid.getView().getEl().down('.x-grid-table').getHeight();
                    } catch (e) {
                    }
                    var height = Ext.dom.Element.getViewportHeight();
                    console.log(data_height+'---'+height);
                    if (data_height > height - 76) {
                        window.has_biged = true;
                        grid.height = height - 76;
                    }
                    else if (data_height < height - 76) {
                        if (window.has_biged) {
                            delete window.grid.height;
                            window.has_biged = false;
                            grid.doLayout();
                        }
                    }*/
                }
            },
            plugins: [
                Ext.create('Ext.grid.plugin.CellEditing', {
                    clicksToEdit: 2,
                    listeners: {
                        edit: function (editor, e) {
                            var id = e.record.get('mid');
                            //  var view_el=window.product_grid.getView().getEl();
                            //  view_el.scrollBy(0,this.scroll_top,false);
                            updateField(0, id, e.field, e.value, 0);
                            return false;

                        }

                    }
                })
            ],
            viewConfig: {
                enableTextSelection:true
            }
        });


    });

//实现动态窗口大小
Ext.EventManager.onWindowResize(function () {

    var height = Ext.dom.Element.getViewportHeight();
    var data_height = window.product_grid.getView().getEl().down('.x-grid-table').getHeight();
    if (data_height > height - 76)
        window.product_grid.height = (height - 76);
    else
       delete window.product_grid.height;
    window.product_grid.doLayout();
});


function togStatus(ele)
{
    var status=$(ele).val();
    window.product_store.getProxy().setExtraParam('status',status);
    window.product_store.loadPage(1);

}
//按进行搜索
function searchKeyword() {
    var keyword = $.trim($("#searchkey").val());
    var datadef = $("#searchkey").attr('datadef');
    keyword = keyword==datadef ? '' : keyword;
    window.product_store.getProxy().setExtraParam('keyword',keyword);
    window.product_store.loadPage(1);
}
//切换每页显示数量
function changeNum(combo, records) {
    var pagesize=records[0].get('num');
    window.product_store.pageSize=pagesize;
    window.product_store.loadPage(1);
}
//审核
function modify(id) {

    var url = SITEURL+'supplier_brokerage/admin/brokerage/modify_approval/menuid/{$_GET['menuid']}/id/'+id;
    ST.Util.addTab('提现详情',url,1)

}





</script>

</body>
</html>
