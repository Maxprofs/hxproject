<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>供应商收入审核-笛卡CMS{$coreVersion}</title>
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
                <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
                <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10 btn_excel">导出Excel</a>
            </div>
            <div class="cfg-search-bar">
                <div class="fl select-box w100 mt-3 ml-10">
                    <select name="typeid" onchange="togTypeids(this)" class="select">
                        <option value="">产品类别</option>
                        {loop $modules $row}
                        <option value="{$row['id']}">{$row['modulename']}</option>
                        {/loop}
                    </select>
                </div>
                <div class="fl select-box w150 mt-3 ml-10">
                    <select name="paysource" onchange="togPaysource(this)" class="select">
                        <option value="">支付方式</option>
                        {loop $pay_sources $v}
                        <option value="{$v['paysource']}">{$v['paysource']}</option>
                        {/loop}
                    </select>
                </div>
                <div class="fl select-box w150 mt-3 ml-10">
                    <select name="status" onchange="togStatus(this)" class="select">
                        <option value="">到账状态</option>
                        {loop $account_status $k $v}
                        <option value="{$k}">{$v}</option>
                        {/loop}
                    </select>
                </div>
                <div class="cfg-header-search">
                    <input type="text" id="searchkey" placeholder="订单号/联系人姓名/联系人电话" datadef="订单号/联系人姓名/联系人电话" class="search-text" />
                    <a href="javascript:;" class="search-btn" onclick="searchKeyword()">搜索</a>
                </div>
            </div>
            <div id="product_grid_panel" class="content-nrt" >

            </div>
        </td>
    </tr>
</table>

<script>

    window.display_mode = 1;	//默认显示模式
    window.product_kindid = 0;  //默认目的地ID
    var channelname = "{$channelname}";

    Ext.onReady(
        function () {
            Ext.tip.QuickTipManager.init();
            $("#searchkey").focusEffect();

            //产品store
            window.product_store = Ext.create('Ext.data.Store', {

                fields: [
                    'id',
                    'ordersn',
                    'type_id',
                    'amount',
                    'mid',
                    'pdt_type',
                    'pdt_name',
                    'pay_time',
                    'pay_type',
                    'pay_num',
                    'pay_proof',
                    'salesman',
                    'linkman',
                    'linktel',
                    'status',
                    'orderid',
                    'pinyin',
                ],

                proxy: {
                    type: 'ajax',
                    api: {
                        read: SITEURL+'income/admin/income/read/'  //读取数据的URL
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
                            bar.insert(0, Ext.create('Ext.toolbar.Fill'));
                        }
                    }
                }),
                columns: [
                    {
                        text: '订单号',
                        width: '10%',
                        dataIndex: 'ordersn',
                        align: 'center',
                        border: 0,
                        sortable: false,
                        menuDisabled:true,
                        renderer: function (value, metadata, record) {
                            var orderid = record.get('orderid');
                            var typeid = record.get('type_id');
                            var pinyin = record.get('pinyin');
                            var pdt_type = record.get('pdt_type');
                            var ordersn = record.get('ordersn');
                            return "<a href='javascript:void(0);' class='btn-link' onclick=\"order_view("+orderid+","+typeid+", '"+pinyin+"', '"+pdt_type+"', '"+ordersn+"')\">"+value+"</a>"
                        }
                    },

                    {
                        text: '产品类别',
                        width: '10%',
                        dataIndex: 'pdt_type',
                        align: 'center',
                        border: 0,
                        sortable: false,
                        menuDisabled:true,
                        renderer: function (value, metadata, record) {
                            return value;
                        }

                    },
                    {
                        text: '支付时间',
                        width: '10%',
                        dataIndex: 'pay_time',
                        align: 'center',
                        border: 0,
                        sortable: false,
                        menuDisabled:true,
                        renderer: function (value, metadata, record) {
                            if(value==0){
                                return '<span data-area="无"></span>';
                            }
                            var date=new Date(value*1000);
                            return '<span>' + Ext.Date.format(date, 'Y-m-d H:i:s') + '</span>';
                        }

                    },
                    {
                        text: '支付方式',
                        width: '10%',
                        dataIndex: 'pay_type',
                        align: 'center',
                        border: 0,
                        sortable: false,
                        menuDisabled:true,
                        renderer: function (value, metadata, record) {
                            return value;
                        }

                    },
                    {
                        text: '业务员',
                        width: '10%',
                        dataIndex: 'salesman',
                        align: 'center',
                        border: 0,
                        sortable: false,
                        menuDisabled:true,
                        renderer: function (value, metadata, record) {
                            return value;
                        }

                    },
                    {
                        text: '联系人',
                        width: '10%',
                        dataIndex: 'linkman',
                        align: 'center',
                        border: 0,
                        sortable: false,
                        menuDisabled:true,
                        renderer: function (value, metadata, record) {
                            return value;
                        }

                    },
                    {
                        text: '联系人电话',
                        width: '10%',
                        dataIndex: 'linktel',
                        align: 'center',
                        border: 0,
                        sortable: false,
                        menuDisabled:true,
                        renderer: function (value, metadata, record) {
                            return value;
                        }
                    },
                    {
                        text: '实收额',
                        width: '10%',
                        dataIndex: 'amount',
                        align: 'center',
                        border: 0,
                        sortable: false,
                        menuDisabled:true,
                        renderer: function (value, metadata, record) {
                            return value;
                        }

                    },
                    {
                        text: '到账情况',
                        width: '10%',
                        dataIndex: 'status',
                        align: 'center',
                        border: 0,
                        sortable: false,
                        menuDisabled:true,
                        renderer: function (value, metadata, record) {
                            if (value == 0){
                                return '<span style="color:red">待确认</span>';
                            }else{
                                return '<span>已到账</span>';
                            }
                        }
                    },
                    {
                        text: '管理',
                        width: '10%',
                        align: 'center',
                        border: 0,
                        sortable: false,
                        menuDisabled:true,
                        cls: 'mod-1',
                        renderer: function (value, metadata, record) {
                            var id=record.get('id');
                            var status = record.get('status');
                            var title = status == 0 ? '确认' : '详情';
                            return "<a href='javascript:void(0);' title='"+title+"' class='btn-link' onclick=\"view("+id+")\">"+title+"</a>"
                        }
                    }
                ],
                listeners: {
                    boxready: function () {
                        var height = Ext.dom.Element.getViewportHeight();
                        this.maxHeight = height-76 ;
                        this.doLayout();
                    },
                    afterlayout: function (grid) {

                    }
                },
                plugins: [
                    Ext.create('Ext.grid.plugin.CellEditing', {
                        clicksToEdit: 2,
                        listeners: {
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

    function togStatus(ele) {
        var status=$(ele).val();
        window.product_store.getProxy().setExtraParam('status',status);
        window.product_store.loadPage(1);
    }
    function togPaysource(ele) {
        var pay_type=$(ele).val();
        window.product_store.getProxy().setExtraParam('pay_type',pay_type);
        window.product_store.loadPage(1);
    }
    function togTypeids(ele) {
        var type_id=$(ele).val();
        window.product_store.getProxy().setExtraParam('type_id',type_id);
        window.product_store.loadPage(1);
    }

    $(function(){

    });


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

    //查看审核详情
    function view(id) {
        var record = window.product_store.getById(id.toString());
        var url=SITEURL+"income/admin/income/view/{if isset($_GET['menuid'])}menuid/{$_GET['menuid']}/{/if}id/"+id;
        ST.Util.addTab('审核详情：'+record.get('ordersn'),url,1);
    }

    //订单详情
    function order_view(id,typeid, pinyin, pdt_type, ordersn) {
        var url = SITEURL + pinyin + "/admin/order/view/id/"+id+"/typeid/"+typeid;
        ST.Util.addTab(pdt_type + '订单：' + ordersn,url,1);
    }

    //导出excel
    $(".btn_excel").click(function(){
        var url=SITEURL+"income/admin/income/index/action/excel";
        ST.Util.showBox(channelname+'订单生成excel',url,560,380,function(){});
    })

</script>
</body>
</html>
