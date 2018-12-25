<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>分销商列表-笛卡CMS<?php echo $coreVersion;?></title>
    <?php echo  Stourweb_View::template('stourtravel/public/public_js');  ?>
    <?php echo Common::getScript("uploadify/jquery.uploadify.min.js,jquery.buttonbox.js,choose.js"); ?>
    <?php echo Common::getCss('style.css,base.css,base2.css,plist.css,base_new.css'); ?>
    <?php echo Common::css_plugin('distributor.css','distributor');?>
</head>
<body style="overflow:hidden">
    <table class="content-tab">
        <tr>
            <td width="119px" class="content-lt-td" valign="top">
                <?php echo  Stourweb_View::template('stourtravel/public/leftnav');  ?>
                <!--右侧内容区-->
            </td>
            <td valign="top" class="content-rt-td" style="overflow:hidden">
                <div class="cfg-header-bar clearfix">
                    <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
                    <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" id="addbtn">添加</a>
                </div>
                <div class="cfg-search-bar" id="search_bar">
                    <div class="cfg-header-search">
                        <input type="text" id="searchkey" placeholder="名称/法人姓名/联系电话/" datadef="名称/编号/" class="searchkey">
                        <a href="javascript:;" class="search-btn" onclick="CHOOSE.searchKeyword()">搜索</a>
                    </div>
                    <span class="cfg-search-tab display-mod fr">
                        <a href="javascript:void(0);" title="基本信息" class="item on">分销商</a>
                    </span>
                </div>
                <div id="product_grid_panel" class="content-nrt" style="width: 100%;">
                </div>
            </td>
        </tr>
    </table>
</body>
<script>
Ext.application({
    name: 'drawgrid',
    launch: function() {
        Ext.tip.QuickTipManager.init();
        // 建立一个store要使用的 model
        Ext.define('distributor', {
            extend: 'Ext.data.Model',
            fields: [
                { name: 'mid', type: 'string' },
                { name: 'nickname', type: 'string' },
                { name: 'truename', type: 'string' },
                { name: 'phone', type: 'string' },
                { name: 'email', type: 'string' },
                { name: 'mobile', type: 'string' },
                { name: 'isopen', type: 'string' }
            ]
        });
        window.product_store = Ext.create('Ext.data.Store', {
            model: 'distributor',
            proxy: {
                type: 'ajax',
                url: '/newtravel/distributor/admin/distributor/pageload',
                reader: {
                    type: 'json',
                    root: 'lists',
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
                            html:'<div class="panel_bar"><a class="btn btn-primary radius" href="javascript:void(0);" onclick="CHOOSE.chooseAll()">全选</a><a class="btn btn-primary radius ml-10" href="javascript:void(0);" onclick="CHOOSE.chooseDiff()">反选</a></div>'
                        }));
                        bar.insert(1, Ext.create('Ext.toolbar.Fill'));
                    },
                },
            }),
            columns: [
                {
                    text: '选择',
                    width: '5%',
                        // xtype:'templatecolumn',
                    tdCls: 'product-ch',
                    align: 'center',
                    dataIndex: 'mid',
                    menuDisabled: true,
                    sortable: false,
                    border: 0,
                    renderer: function(value, metadata, record) {
                            return "<input type='checkbox' class='product_check' style='cursor:pointer' id='box_" + value + "' value='" + value + "'/>";
                        }
                },
                { 
                    text: '分销商名称',
                    dataIndex: 'nickname',
                    width: '20%',
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
                    dataIndex: 'truename',
                    width: '10%',
                    align: 'center',
                    border: 0,
                    sortable: false,
                    menuDisabled:true,
                    renderer: function (value, metadata, record) {
                        return value;
                    }
                },
                { 
                    text: '联系电话',
                    dataIndex: 'phone',
                    width: '15%',
                    align: 'center',
                    border: 0,
                    sortable: false,
                    menuDisabled:true,
                    renderer: function (value, metadata, record) {
                        return value;
                    }
                },
                { 
                    text: '手机号码',
                    dataIndex: 'mobile',
                    width: '15%',
                    align: 'center',
                    border: 0,
                    sortable: false,
                    menuDisabled:true,
                    renderer: function (value, metadata, record) {
                        return value;
                    }
                },
                { 
                    text: '邮箱地址',
                    dataIndex: 'email',
                    width: '15%',
                    align: 'center',
                    border: 0,
                    sortable: false,
                    menuDisabled:true,
                    renderer: function (value, metadata, record) {
                        return value;
                    }
                },
                { 
                    text: '状态',
                    dataIndex: 'isopen',
                    width: '10%',
                    align: 'center',
                    border: 0,
                    sortable: false,
                    menuDisabled:true,
                    renderer: function (value, metadata, record) {
                        if (value==1) {
                            return "启用";
                        }else{
                            return "禁用";
                        }
                    }
                },
                { 
                    text: '操作',
                    // dataIndex: 'id',
                    width: '10%',
                    align: 'center',
                    border: 0,
                    sortable: false,
                    menuDisabled:true,
                    renderer: function (value, metadata, record) {
                        var id = record.get('mid');
                        var html = "<a href='javascript:void(0);' title='修改' class='btn-link' onclick=\"finance(" + id + ")\">财务</a>"+
                                "&nbsp;&nbsp;&nbsp;<a href='javascript:void(0);' title='修改' class='btn-link' onclick=\"modify(" + id + ")\">编辑</a>"+
                                "&nbsp;&nbsp;&nbsp;<a href='javascript:void(0);' title='删除' class='btn-link' onclick=\"del(" + id + ")\">删除</a>";
                        return html;
                    }
                }
            ],
            width: Ext.dom.AbstractElement.getViewportWidth()-119,
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
        //添加按钮
        $("#addbtn").click(function() {
            var url=SITEURL + 'distributor/admin/distributor/add/<?php if(isset($_GET['menuid'])) { ?>menuid/<?php echo $_GET['menuid'];?>/<?php } ?>
parentkey/product/itemid/1';
            ST.Util.addTab('添加分销商', url, 0);
        });
    }
});
    //修改
    function modify(id) {
        var url=SITEURL + 'distributor/admin/distributor/edit/' + id +'/<?php if(isset($_GET['menuid'])) { ?>menuid/<?php echo $_GET['menuid'];?>/<?php } ?>
parentkey/product/itemid/1';
        parent.window.addTab('修改分销商信息', url, 1);
    }
    function finance(id) {
        // console.log(id);
        var url=SITEURL + 'distributor/admin/distributor/finance/' + id +'/<?php if(isset($_GET['menuid'])) { ?>menuid/<?php echo $_GET['menuid'];?>/<?php } ?>
parentkey/product/itemid/1';
        var title=window.product_store.findRecord('mid',id).get('nickname');
        parent.window.addTab('修改'+title+'财务信息', url, 1);
    }
    //删除套餐
    function del(id)
    {
        ST.Util.confirmBox("提示","确定删除这个分销商吗？",function(){
            $.ajax({
                url: '/newtravel/distributor/admin/distributor/del',
                type: 'get',
                dataType: 'json',
                data: {id: id},
            })
            .done(function(data) {
                if (data.status) {
                    ST.Util.showMsg("删除成功！", 4, 3000);
                    setTimeout("window.location.reload()",'2000')
                }else{
                    ST.Util.showMsg("管理员分销商账号不能删除，请更改后删除。", 5, 3000);
                }
            })
        })
    }
</script>
</html>