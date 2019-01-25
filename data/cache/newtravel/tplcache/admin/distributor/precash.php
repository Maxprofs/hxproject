<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>笛卡CMS<?php echo $coreVersion;?></title>
    <?php echo  Stourweb_View::template('stourtravel/public/public_js');  ?>
    <?php echo Common::getCss('style.css,base.css,base2.css,base_new.css'); ?>
    <?php echo Common::getScript("choose.js"); ?>   
    <style>
        .error{
            color:red;
            padding-left:5px;
        }
        .hide{
            display: none;
        }
    </style>
</head>
<body style="background-color: #fff">
    <table class="content-tab">
        <tr>
            <td width="119px" class="content-lt-td" valign="top">
                <?php echo  Stourweb_View::template('stourtravel/public/leftnav');  ?>
                <!--右侧内容区-->
            </td>
            <td valign="top" class="content-rt-td" style="overflow:hidden">
                <div class="cfg-header-bar clearfix">
                    <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
                </div>
                <div class="cfg-search-bar" id="search_bar">
                    <span class="cfg-search-tab display-mod fr">
                        <a href="javascript:void(0);" title="预存款充值申请列表" class="item on">预存款充值申请列表</a>
                    </span>
                </div>
                <div id="product_grid_panel" class="content-nrt" style="width: 100%;">
                </div>
            </td>
        </tr>
    </table>
    <script language="JavaScript">
Ext.application({
    name: 'drawgrid',
    launch: function() {
        Ext.tip.QuickTipManager.init();
        // 建立一个store要使用的 model
        Ext.define('distributor', {
            extend: 'Ext.data.Model',
            fields: [
                { name: 'id', type: 'string' },
                { name: 'nickname', type: 'string' },
                { name: 'amount', type: 'string' },
                { name: 'addtime', type: 'string' },
                { name: 'description', type: 'string' },
                { name: 'voucherpath', type: 'string' },
                { name: 'savecashstatus', type: 'string' }
            ]
        });
        window.product_store = Ext.create('Ext.data.Store', {
            model: 'distributor',
            proxy: {
                type: 'ajax',
                url: '/newtravel/distributor/admin/distributor/ajax_load_cashlog',
                reader: {
                    type: 'json',
                    root: 'list',
                    totalProperty: 'total'
                }
            },
            pageSize: 10,
            autoLoad: true,
            listeners: {
                load: function(store, records, successful, eOpts) {
                    if (!successful) {
                        ST.Util.showMsg("<?php echo __('norightmsg');?>", 5, 1000);
                        return;
                    }
                    var pageHtml = ST.Util.page(store.pageSize, store.currentPage, store.getTotalCount(), 10);
                    $("#distributor_page").html(pageHtml);
                    window.product_grid.doLayout();
                    $(".pageContainer .pagePart a").click(function () {
                        var page = $(this).attr('page');
                        product_store.loadPage(page);
                    });
                }
            }
        });
        window.product_grid = Ext.create('Ext.grid.Panel', {
            store: product_store,
            renderTo: 'product_grid_panel',
            border: 0,
            bodyBorder: 0,
            bodyStyle: 'border-width:0px',
            scroll: 'vertical',
            bbar:Ext.create('Ext.toolbar.Toolbar',{
                store: product_store, //这个和grid用的store一样
                displayInfo: true,
                emptyMsg: "没有数据了",
                items:[{
                    xtype:'panel',
                    id:'listPagePanel',
                    html:'<div id="distributor_page"></div>'
                },
                {
                    xtype:'combo',
                    fieldLabel:'每页显示数量',
                    width:170,
                    labelAlign: 'right',
                    forceSelection:true,
                    value:10,
                    store:{ fields: ['num'], data: [{ num: 10 }, { num: 20 }, { num: 30 }] },
                    displayField:'num',
                    valueField:'num',
                    listeners:{
                        select:CHOOSE.changeNum
                    }
                }
                ],
                listeners:{
                    single:true,
                    render:function(bar) {
                        var items = this.items;
                        bar.insert(0,Ext.create('Ext.panel.Panel',{
                            border:0,
                            html:'<div class="panel_bar"></div>'
                        }));
                        bar.insert(1, Ext.create('Ext.toolbar.Fill'));
                    },
                },
            }),
            columns: [
                { 
                    text: '编号',
                    dataIndex: 'id',
                    width: '3%',
                    align: 'center',
                    border:0,
                    sortable: false,
                    menuDisabled:true,
                    renderer: function (value, metadata, record) {
                        return value;
                    }
                },
                { 
                    text: '部门名称',
                    dataIndex: 'nickname',
                    width: '17%',
                    align: 'center',
                    border:0,
                    sortable: false,
                    menuDisabled:true,
                    renderer: function (value, metadata, record) {
                        return value;
                    }
                },
                { 
                    text: '充值金额',
                    dataIndex: 'amount',
                    width: '10%',
                    align: 'center',
                    border:0,
                    sortable: false,
                    menuDisabled:true,
                    renderer: function (value, metadata, record) {
                        return value;
                    }
                },
                { 
                    text: '充值时间',
                    dataIndex: 'addtime',
                    width: '10%',
                    align: 'center',
                    border:0,
                    sortable: false,
                    menuDisabled:true,
                    renderer: function (value, metadata, record) {
                        return value;
                    }
                },
                { 
                    text: '内容',
                    dataIndex: 'description',
                    width: '35%',
                    align: 'center',
                    border:0,
                    sortable: false,
                    menuDisabled:true,
                    renderer: function (value, metadata, record) {
                        return value;
                    }
                },
                { 
                    text: '查看凭证',
                    dataIndex: 'voucherpath',
                    width: '10%',
                    align: 'center',
                    border:0,
                    sortable: false,
                    menuDisabled:true,
                    renderer: function (value, metadata, record) {
                        if (value=='') {
                            return '未上传凭证'
                        }else{
                            return formatDate(value);
                        }
                        
                    }
                },
                { 
                    text: '操作',
                    dataIndex: 'savecashstatus',
                    width: '15%',
                    align: 'center',
                    border:0,
                    sortable: false,
                    menuDisabled:true,
                    renderer: function (value, metadata, record) {
                        switch(value){
                            case '0':
                                return "<button class='btn btn-warning radius' onclick='savecash()'>确认</button><button class='btn btn-primary radius ml-10' onclick='cancel()'>退回</button>"
                                break;
                            case 1:
                                break;
                            case 2:
                            break;
                        }
                    }
                }
            ],
            width: $('#product_grid_panel').css('width'),
            renderTo: 'product_grid_panel'
        });
        //实现动态窗口大小
        Ext.EventManager.onWindowResize(function() {
            var height = Ext.dom.Element.getViewportHeight()-76;
            var width = Ext.dom.Element.getViewportWidth()-119;
            window.product_grid.maxHeight = height;
            window.product_grid.maxWidth = width;
            console.log(width);
            console.log(height);
            window.product_grid.doLayout();
        })
    }
});
    $(function() {
        $('#btn-save').click(function(event) {
            ST.Util.confirmBox('提示',"是否为<?php echo $info['nickname'];?>充值"+$("#cash").val()+元,function () {
                console.log(data);
            });
        });
    });
    function finance(id) {
        // console.log(id);
        var url=SITEURL + 'distributor/admin/distributor/finance/' + id +'/<?php if(isset($_GET['menuid'])) { ?>menuid/<?php echo $_GET['menuid'];?>/<?php } ?>
parentkey/product/itemid/1';
        var title=window.product_store.findRecord('mid',id).get('nickname');
        parent.window.addTab(title+'备用金充值', url, 1);
    }
    </script>
</body>
</html>