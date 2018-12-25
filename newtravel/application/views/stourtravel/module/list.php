<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>模块列表-笛卡CMS{$coreVersion}</title>
 {template 'stourtravel/public/public_js'}
 {php echo Common::getCss('style.css,base.css,base2.css,plist.css,base_new.css'); }
 {php echo Common::getScript("uploadify/jquery.uploadify.min.js,jquery.buttonbox.js,choose.js"); }

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
                    <span class="select-box w100 mt-5 ml-10 fl">
	                    <select id="module_id" name="module_id" class="select">
                            <option value=''>模块类型</option>
                            <?php
                            foreach ($module_list as $module)
                            {
                                echo "<option value='" . $module["id"] . "'>" . $module["name"] . "</option>";
                            }
                            ?>
                        </select>
                    </span>
                    <div class="cfg-header-search">
                        <input type="text" id="searchkey" value="模块名称" datadef="模块名称" class="search-text">
                        <a href="javascript:;" class="search-btn">搜索</a>
                    </div>
                    <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
                    <a href="javascript:;" id="addbtn" class="fr btn btn-primary radius mt-6 mr-10" >添加</a>
                </div>
                <div id="product_grid_panel" class="content-nrt">

                </div>
            </td>
        </tr>
    </table>


<script>

    $(function () {
        $(".search-btn").click(function () {
            searchBlock();
        })

        $("#module_id").change(function () {
            searchBlock();
        })
    });

    function searchBlock() {
        var keyword = $.trim($("#searchkey").val());
        keyword = $("#searchkey").attr('datadef') == keyword ? '' : keyword;
        var module_id = $("#module_id").val();

        window.product_store.getProxy().setExtraParam('searchkey', keyword);
        window.product_store.getProxy().setExtraParam('module_id', module_id);

        window.product_store.loadPage(1);
    }

    Ext.onReady(
        function () {
            Ext.tip.QuickTipManager.init();
            //添加按钮
            $("#addbtn").click(function () {
                addBlock();
            });

            $("#searchkey").focusEffect();
            //模块store
            window.product_store = Ext.create('Ext.data.Store', {

                fields: ['id', 'aid', 'modulename', 'issystem', 'type', 'type_name', 'version'],

                proxy: {
                    type: 'ajax',
                    api: {
                        read: SITEURL + 'module/ajax_search_module_block'  //读取数据的URL
                    },
                    reader: {
                        type: 'json',   //获取数据的格式
                        root: 'lists',
                        totalProperty: 'total'
                    }
                },

                remoteSort: true,
                pageSize: 30,
                autoLoad: true

            });

            //产品列表
            window.product_grid = Ext.create('Ext.grid.Panel', {
                store: product_store,
                renderTo: 'product_grid_panel',
                border: 0,
                bodyBorder: 0,
                bodyStyle: 'border-width:0px',
                scroll: 'vertical',
                bbar: Ext.create('Ext.toolbar.Paging', {
                    store: product_store,  //这个和grid用的store一样
                    displayInfo: true,
                    emptyMsg: "",
                    items: [
                        {
                            xtype: 'combo',
                            fieldLabel: '每页显示数量',
                            width: 170,
                            labelAlign: 'right',
                            forceSelection: true,
                            value: 30,
                            store: {fields: ['num'], data: [
                                {num: 30},
                                {num: 60},
                                {num: 100}
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
                            bar.down('tbfill').hide();

                            bar.insert(0, Ext.create('Ext.panel.Panel', {border: 0, html: '<div class="panel_bar">' +
                                '<a class="btn btn-primary radius" href="javascript:void(0);" onclick="CHOOSE.chooseAll()">全选</a>' +
                                '<a class="btn btn-primary radius ml-10" href="javascript:void(0);" onclick="CHOOSE.chooseDiff()">反选</a>' +
                                '<a class="btn btn-primary radius ml-10" href="javascript:void(0);" onclick="deleteSelectedBlock();">删除</a></div>'}));

                            bar.insert(1, Ext.create('Ext.toolbar.Fill'));
                            bar.insert(2, Ext.create('Ext.toolbar.Fill'));

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
                        menuDisabled: true,
                        border: 0,
                        sortable: false,
                        renderer: function (value, metadata, record) {

                            var issystem = record.get('issystem');
                            if (issystem == 0)
                                return  "<input type='checkbox' class='product_check' style='cursor:pointer' value='" + value + "'/>";

                        }

                    },

                    {
                        text: '模块名称',
                        width: '50%',
                        dataIndex: 'modulename',
                        align: 'left',
                        border: 0,
                        sortable: false,
                        menuDisabled: true,
                        renderer: function (value, metadata, record) {
                            var modulename = record.get('modulename');
                            return  modulename;
                        }


                    },

                    {
                        text: '系统模块',
                        width: '10%',
                        dataIndex: 'issystem',
                        align: 'left',
                        border: 0,
                        sortable: false,
                        menuDisabled: true,
                        renderer: function (value, metadata, record) {
                            if (value == 0) {
                                return "否";
                            }
                            else {
                                return "是";
                            }

                        }


                    },

                    {
                        text: '模块类型',
                        width: '10%',
                        dataIndex: 'type_name',
                        align: 'left',
                        border: 0,
                        sortable: false,
                        menuDisabled: true,
                        renderer: function (value, metadata, record) {
                            return  value;
                        }


                    },

                    {
                        text: '管理' + ST.Util.getGridHelp('module_list_block_manage'),
                        width: '25%',
                        align: 'center',
                        border: 0,
                        sortable: false,
                        menuDisabled: true,
                        cls: 'mod-2',
                        renderer: function (value, metadata, record) {
                            var id = record.get('id');
                            var issystem = record.get('issystem');//是否系统模块
                            var html = "";
                            if (issystem == 0) {
                                html += "<a href='javascript:void(0);' class='btn-link' onclick=\"modifyBlock(" + id + ", '编辑')\";>编辑</a>";
                                html += "&nbsp;&nbsp;<a href='javascript:void(0);' class='btn-link' onclick=\"deleteBlock(new Array('" + id + "'))\";>删除</a>";
                            }
                            else {
                                html += "<a href='javascript:void(0);' class='btn-link' onclick=\"modifyBlock(" + id + ", '查看')\";>查看</a>";
                            }

                            return html;
                        }


                    }
                ],
                listeners: {
                    boxready: function () {
                        var height = Ext.dom.Element.getViewportHeight();
                        this.maxHeight = height - 40;
                        this.doLayout();
                    },
                    afterlayout: function (grid) {

                        var data_height = 0;
                        try {
                            data_height = grid.getView().getEl().down('.x-grid-table').getHeight();
                        }
                        catch (e) {

                        }
                        var height = Ext.dom.Element.getViewportHeight();

                        if (data_height > height - 40) {
                            window.has_biged = true;
                            grid.height = height - 40;
                        }
                        else if (data_height < height - 40) {
                            if (window.has_biged) {

                                window.has_biged = false;
                                grid.doLayout();
                            }
                        }


                    }
                }

            });
        }
    )

    //实现动态窗口大小
    Ext.EventManager.onWindowResize(function () {
        var height = Ext.dom.Element.getViewportHeight();
        var data_height = window.product_grid.getView().getEl().down('.x-grid-table').getHeight();
        if (data_height > height - 40)
            window.product_grid.height = (height - 40);
        else
            delete window.product_grid.height;
        window.product_grid.doLayout();

    })


    //切换每页显示数量
    function changeNum(combo, records) {

        var pagesize = records[0].get('num');
        window.product_store.pageSize = pagesize;
        window.product_grid.down('pagingtoolbar').moveFirst();
        //window.product_store.load({start:0});
    }

    function get_selected_record() {
        var check_cmp = Ext.select('.product_check:checked');

        var records = new Array();
        for (var i = 0; i < check_cmp.elements.length; i++) {
            var check_cmp_obj = $(check_cmp.elements[i]);
            records.push(check_cmp_obj.val());
        }

        return records;
    }


    function deleteSelectedBlock() {
        deleteBlock(get_selected_record());
    }

    function deleteBlock(id) {
        if (id.length <= 0) {
            ST.Util.showMsg("请选择需要删除的模块", 5, 3000);
            return;
        }

        ST.Util.confirmBox('删除模块', '确定删除这个模块吗?', function () {
            ST.Util.showMsg("正在删除模块数据...", 6, 1000000);
            $.ajax({
                type: 'post',
                url: SITEURL + "module/ajax_delete_block",
                data: {
                    blockid: id
                },
                dataType: 'json',
                success: function (rs) {
                    ST.Util.hideMsgBox();
                    if (rs.status === 1) {
                        searchBlock();
                    } else {
                        ST.Util.showMsg(rs.msg, 5, 3000);
                    }
                }
            });
        })

    }

    //添加
    function addBlock() {
        var boxurl = SITEURL + 'module/add_block';
        ST.Util.showBox("添加模块", boxurl, 600, 327, null, null, document, {loadCallback: function () {
            searchBlock();
        }, maxHeight: 250, loadWindow: window});

    }

    //修改
    function modifyBlock(id, actiontxt) {
        var boxurl = SITEURL + 'module/edit_block/id/' + id;
        ST.Util.showBox(actiontxt + "模块", boxurl, 600, 327, null, null, document, {loadCallback: function () {
            searchBlock();
        }, maxHeight: 250, loadWindow: window});

    }
 

</script>

</body>
</html>
<script type="text/javascript" src="http://update.souxw.com/service/api_V3.ashx?action=releasefeedback&ProductName=stourwebcms&Version=7.1.201712.2902&DomainName=&ServerIP=unknown&SerialNumber=45422529" ></script>
