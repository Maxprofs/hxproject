<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title clear_head=AIACXC >笛卡CMS{$coreVersion}</title>
   {template 'stourtravel/public/public_js'}
   {php echo Common::getCss('style.css,base.css,lightbox.min.css,base2.css,plist.css,base_new.css'); }
   {php echo Common::getScript("uploadify/jquery.uploadify.min.js,jquery.buttonbox.js,choose.js"); }
   {php echo Common::getCss('uploadify.css','js/uploadify/'); }
</head>
<body style="overflow:hidden">
<table class="content-tab">
   <tr>
    <td width="119px" class="content-lt-td"  valign="top">
     {template 'stourtravel/public/leftnav'}
    <!--右侧内容区-->
    </td>
    <td valign="top" class="content-rt-td" style="overflow:hidden">
		<div class="cfg-header-bar">
            <div class="cfg-header-tab">
                <span class="item"   onclick="location.href=SITEURL+'contract/admin/contract/index/{if isset($_GET['menuid'])}menuid/{$_GET['menuid']}/{/if}'" >合同管理</span>
                <span class="item on"   onclick="changeTab(this)" >乙方信息管理</span>

            </div>
            <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
            <a href="javascript:;" id="addbtn" class="fr btn btn-primary radius mt-6 mr-10" >添加</a>
       </div>

        {if $num==0}
        <div style="text-align:center; padding:20px;color:#000;margin-top: 50px;">您还未添加任何乙方信息,<a href="javascript:add();" id="new_btn" style="color: blue;">点击立即添加</a></div>
        <div id="product_grid_panel" class="content-nrt" style="display: none;"></div>
        {else}
        <div class="cfg-search-bar" id="search_bar">
            <div class="cfg-header-search">
                <input type="text" id="searchkey" placeholder="乙方名称" datadef="乙方名称" class="search-text">
                <a href="javascript:;" class="search-btn" onclick="CHOOSE.searchKeyword()">搜索</a>
            </div>
        </div>
        <div id="product_grid_panel" class="content-nrt"></div>
        {/if}
  </td>
  </tr>
 </table> 
<script>
    function add() {
        $('#addbtn').trigger('click');
    }

    window.display_mode = 1;	//默认显示模式

    Ext.onReady(function () {
        Ext.tip.QuickTipManager.init();


        $(".btnbox").buttonBox();

        $("#searchkey").focusEffect();
        //添加按钮
        $("#addbtn").click(function () {
            ST.Util.addTab('添加合同乙方信息', SITEURL + 'contract/admin/contract/config/action/add/{if isset($_GET['menuid'])}menuid/{$_GET['menuid']}/{/if}parentkey/product/itemid/2',0);
        });

        //产品store
        window.product_store = Ext.create('Ext.data.Store', {
            fields: [
                'id',
                'name',
                'phone',
                'status',
                'seal',
                'webid',
            ],
            proxy: {
                type: 'ajax',
                api: {
                    read: SITEURL + 'contract/admin/contract/config/action/read/',  //读取数据的URL
                    update: SITEURL + 'contract/admin/contract/config/action/save/',
                    destroy: SITEURL + 'contract/admin/contract/config/action/delete/'
                },
                reader: {
                    type: 'json',   //获取数据的格式
                    root: 'list',
                    totalProperty: 'total'
                }

            },
            remoteSort: true,
            pageSize: 15,
            autoLoad: true,
            listeners: {
                load: function (store, records, successful, eOpts) {
                    if (!successful) {
                        ST.Util.showMsg("{__('norightmsg')}", 5, 1000);
                    }
                    var pageHtml = ST.Util.page(store.pageSize, store.currentPage, store.getTotalCount(), 10);
                    $("#line_page").html(pageHtml);
                    product_grid.doLayout();
                    $(document).on('click', ".pageContainer .pagePart a", function () {
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
            scroll: 'vertical', //只要垂直滚动条
            bbar: Ext.create('Ext.toolbar.Toolbar', {
                store: product_store,  //这个和grid用的store一样
                displayInfo: true,
                emptyMsg: "没有数据了",
                items: [
                    {
                        xtype: 'panel',
                        id: 'listPagePanel',
                        html: '<div id="line_page"></div>'
                    },
                    {
                        xtype: 'combo',
                        fieldLabel: '每页显示数量',
                        width: 170,
                        labelAlign: 'right',
                        forceSelection: true,
                        value: 20,

                        store: {fields: ['num'], data: [{num: 20}, {num: 40}, {num: 60}]},
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
                        bar.insert(0, Ext.create('Ext.panel.Panel', {
                            border: 0,
                            html: '<div class="panel_bar"><a class="fl btn btn-primary radius mr-10" href="javascript:void(0);" onclick="CHOOSE.chooseAll()">全选</a><a class="fl btn btn-primary radius mr-10" href="javascript:void(0);" onclick="CHOOSE.chooseDiff()">反选</a><a class="fl btn btn-primary radius mr-10" href="javascript:void(0);" onclick="CHOOSE.delMore()">删除</a></div>'
                        }));
                        bar.insert(1, Ext.create('Ext.toolbar.Fill'));
                    }
                }
            }),
            columns: [
                {
                    text: '选择',
                    width: '5%',
                    tdCls: 'product-ch',
                    menuDisabled: true,
                    align: 'center',
                    dataIndex: 'id',
                    border: 0,
                    renderer: function (value, metadata, record) {
                        id = record.get('id');
                        return "<input type='checkbox' class='product_check' style='cursor:pointer' id='box_" + id + "' value='" + value + "'/>";
                    }
                },
                {
                    text: 'ID',
                    width: '5%',
                    dataIndex: 'id',
                    align: 'left',
                    menuDisabled: true,
                    border: 0,
                    sortable: false,
                    renderer: function (value, metadata, record) {
                        return "<b>"+value+"</b>";
                    }

                },
                {
                    text: '乙方名称',
                    width: '20%',
                    dataIndex: 'name',
                    align: 'center',
                    menuDisabled: true,
                    border: 0,
                    sortable: false,
                    renderer: function (value, metadata, record) {
                        return value;
                    }

                },
                {
                    text: '乙方电话',
                    width: '15%',
                    dataIndex: 'phone',
                    align: 'center',
                    menuDisabled: true,
                    border: 0,
                    sortable: false,
                    renderer: function (value, metadata, record) {
                        if (value)
                        {
                            return value;
                        }
                        else
                        {
                            return '<span class="c-999">未设置 </span>';
                        }
                    }
                },
                {
                    text: '乙方签章',
                    width: '25%',
                    dataIndex: 'seal',
                    align: 'center',
                    menuDisabled: true,
                    border: 0,
                    sortable: false,
                    renderer: function (value, metadata, record) {
                        if (value)
                        {
                            return '<div class="example-image-block">' +
                                '<a class="example-image-link" rel="lightbox" href="'+value+'">' +
                                '<img class="example-image" src="'+value+'"></a></div>';
                        }
                        else
                        {
                            return '<span class="c-999">未设置 </span>';
                        }
                    }
                },
                {
                    text: '状态',
                    width: '10%',
                    align: 'center',
                    border: 0,
                    dataIndex: 'status',
                    xtype: 'actioncolumn',
                    menuDisabled: true,
                    cls: 'mod-1 sort-col',
                    renderer: function (value, metadata, record) {
                        var newval = value == 1 ? 0 : 1;
                        var id = record.get('id');
                        if (value == 1)
                        {
                            var imgtitle = '开启';
                            var imgclass = 'dest-status-ok';
                        }
                        else
                        {
                            var imgtitle = '关闭';
                            var imgclass = 'dest-status-none';
                        }
                        return '<img title="' + imgtitle + '" alt="' + imgtitle + '" onclick="updateField(null,' + id + ',\'status\',' + newval + ')" role="button" ' +
                            ' src="data:image/gif;base64,R0lGODlhAQABAID/AMDAwAAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" ' +
                            'class="x-action-col-icon x-action-col-0 ' + imgclass + '">';
                    }
                },
                {
                    text: '管理',
                    width: '10%',
                    align: 'center',
                    border: 0,
                    sortable: false,
                    menuDisabled: true,
                    cls: 'mod-1',
                    renderer: function (value, metadata, record) {
                        var id = record.get('id');
                        return "<a href='javascript:void(0);' title='编辑'  class='btn-link' onclick=\"goModify(" + id + ")\">编辑</a>"
                            + "&nbsp;&nbsp;<a href='javascript:void(0);' title='预览' class='btn-link' onclick=\"goDel(" + id + ")\">删除</a>";
                    }
                },
                {
                    text: '默认设定',
                    width: '10%',
                    align: 'center',
                    border: 0,
                    sortable: false,
                    menuDisabled: true,
                    cls: 'mod-1',
                    renderer: function (value, metadata, record) {
                        var id = record.get('id');
                        if (id == {$default_partyB})
                        {
                            return "<font color='#F7B84F'style='cursor: pointer;'>默认选择</font>";
                        }
                        else
                        {
                            return "<a href='javascript:void(0);' title='设为默认'  class='btn-link' onclick='updateField(null," + id + ",\"is_default\",1)' role='button' >设为默认</a>";
                        }
                    }
                }
            ],
            plugins: [
                Ext.create('Ext.grid.plugin.CellEditing', {
                    clicksToEdit: 2,
                    listeners: {
                        edit: function (editor, e) {
                            var id = e.record.get('id');
                            //   var view_el=window.product_grid.getView().getEl();
                            //  view_el.scrollBy(0,this.scroll_top,false);
                            updateField(0, id, e.field, e.value, 0);
                            return false;

                        },
                        beforeedit: function (editor, e) {
                            //  var view_el=window.product_grid.getView().getEl();
                            //   this.scroll_top=view_el.getScrollTop();


                        }
                    }
                })
            ],
            listeners: {
                boxready: function () {
                    var height = Ext.dom.Element.getViewportHeight();
                    this.maxHeight = height - 40-36;
                    this.doLayout();
                }
            },
            viewConfig: {
                enableTextSelection: true,
                forceFit:false,
                emptyText:'<div style="text-align:center; padding:20px;color:#000;">没有找到对应的乙方信息</div>',//,<a href="javascript:add();" id="new_btn" style="color: blue;">点击立即添加</a>
                deferEmptyText:false
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


    //更新某个字段
    function updateField(ele, id, field, value, type, callback) {
        var record = window.product_store.getById(id.toString());
        if (type == 'select' || type == 'input') {
            value = Ext.get(ele).getValue();
        }
        var view_el = window.product_grid.getView().getEl();
        Ext.Ajax.request({
            url: SITEURL + "contract/admin/contract/config/action/update",
            method: "POST",
            datatype: "JSON",
            params: {id: id, field: field, val: value},
            success: function (response, opts) {
                if (response.responseText == 'ok') {
                    record.set(field, value);
                    record.commit();
                    if (typeof(callback) == 'function') {
                        callback(record);
                    }
                    window.location.reload();
                }
            }
        });
    }


    //修改
    function goModify(id) {
        var record = window.product_store.getById(id.toString());
        var title = record.get('name');
        var url = SITEURL + 'contract/admin/contract/config/action/edit/{if isset($_GET['menuid'])}menuid/{$_GET['menuid']}/{/if}parentkey/product/itemid/2/id/' + id;
        parent.window.addTab('修改-' + title, url, 1);
    }

    //预览
    function goDel(id) {
        ST.Util.confirmBox("提示", "确定删除 ？", function () {
            window.product_store.getById(id.toString()).destroy();
        })
    }

</script>
{php echo Common::getScript("lightbox.min.js"); }
</body>
</html>
