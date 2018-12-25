<!doctype html>
<html>
<head head_left=JbKzDt >
    <meta charset="utf-8">
    <title>API交互日志-笛卡CMS{$coreVersion}</title>
    {template 'stourtravel/public/public_js'}
    {php echo Common::getCss('style.css,base.css,base2.css,plist.css,base_new.css'); }
    {php echo Common::getScript("uploadify/jquery.uploadify.min.js,jquery.buttonbox.js,choose.js"); }
</head>
<body style="overflow:hidden" class="mall">
<table class="content-tab">
    <tr>
        <td width="119px" class="content-lt-td" valign="top">
            {template 'stourtravel/public/leftnav'}
            <!--右侧内容区-->
        </td>
        <td valign="top" class="content-rt-td" style="overflow:hidden">
        	<div class="cfg-header-bar">
        		<div class="cfg-search-bar fl">
        			<span class="fl select-box w150 mt-3 ml-10">
        				<select id="client_id" name="client_id" class="select">
                            <option value="">全部API客户端</option>
                            {loop $client_list $client_info}
                            <option value="{$client_info['id']}">{$client_info['name']}</option>
                            {/loop}
                        </select>
        			</span>	
        			<span class="fl select-box w150 mt-3 ml-10">
        				<select id="success" name="success" class="select">
                            <option value="">全部执行状态</option>
                            <option value="1">成功</option>
                            <option value="0">失败</option>
                        </select>
        			</span>	
        			<div class="cfg-header-search">
        				<input type="text" id="searchkey" name="searchkey" value="关键字" datadef="关键字" class="search-text">
                        <a href="javascript:;" class="search-btn">搜索</a>
        			</div>	
        		</div>
        		<a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>	
        	</div>	
            
            <div id="product_grid_panel" class="content-nrt">

            </div>
        </td>
    </tr>
</table>
</body>
<script>
$(function(){
    $(".search-btn").click(function(){
        searchdata();
    })
    $("#client_id,#success").change(function(){
        searchdata();
    });
});

function show_detail(id) {
    var url = SITEURL + "api/admin/interoplog/show_detail/id/" + id;
    ST.Util.showBox("API交互日志详细信息", url, 450, 450, function () {

    });
}

function searchdata() {
    var keyword = $.trim($("#searchkey").val());
    keyword = $("#searchkey").attr('datadef') == keyword ? '' : keyword;
    var client_id = $("#client_id").val();
    var success = $("#success").val();

    window.product_store.getProxy().setExtraParam('searchkey', keyword);
    window.product_store.getProxy().setExtraParam('client_id', client_id);
    window.product_store.getProxy().setExtraParam('success', success);
    window.product_store.loadPage(1);
}

Ext.onReady(
    function () {
        Ext.tip.QuickTipManager.init();

        $("#searchkey").focusEffect();

        //产品store
        window.product_store = Ext.create('Ext.data.Store', {

            fields: [
                'id',
                'client_id',
                'api_client_name',
                'url',
                'success',
                'action_time_h'
            ],

            proxy: {
                type: 'ajax',
                api: {
                    read: SITEURL + 'api/admin/interoplog/index/action/read'
                },
                reader: {
                    type: 'json',   //获取数据的格式
                    root: 'lists',
                    totalProperty: 'total'
                }
            },
            remoteSort: false,
            autoLoad: true,
            pageSize: 20,
            listeners: {
                load: function (store, records, successful, eOpts) {
                    if (!successful) {
                        ST.Util.showMsg("查找数据信息失败", 5, 3000);
                        return;
                    }

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
            bodyBorder: 0,
            bodyStyle: 'border-width:0px',
            scroll: 'vertical', //只要垂直滚动条
            bbar: Ext.create('Ext.toolbar.Toolbar', {
                store: product_store,  //这个和grid用的store一样
                displayInfo: true,
                emptyMsg: "",
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
                        //bar.down('tbfill').hide();

                        bar.insert(0, Ext.create('Ext.toolbar.Fill'));
                        //items.add(Ext.create('Ext.toolbar.Fill'));
                    }
                }
            }),
            columns: [
                {
                    text: 'API客户端',
                    width: '10%',
                    align: 'center',
                    border: 0,
                    dataIndex: 'api_client_name',
                    menuDisabled: true,
                    renderer: function (value, metadata, record, rowIndex, colIndex) {
                        return value;
                    }


                },
                {
                    text: 'API URL',
                    width: '60%',
                    align: 'center',
                    border: 0,
                    dataIndex: 'url',
                    menuDisabled: true,
                    renderer: function (value, metadata, record, rowIndex, colIndex) {
                        return value;
                    }


                },
                {
                    text: '执行状态',
                    width: '10%',
                    align: 'center',
                    border: 0,
                    dataIndex: 'success',
                    menuDisabled: true,
                    renderer: function (value, metadata, record, rowIndex, colIndex) {
                        if(value == 0)
                            return '失败';
                        else
                            return '成功';
                    }


                },
                {
                    text: '时间',
                    width: '10%',
                    align: 'center',
                    border: 0,
                    dataIndex: 'action_time_h',
                    menuDisabled: true,
                    renderer: function (value, metadata, record, rowIndex, colIndex) {
                        return value;
                    }


                },
                {
                    text: '管理'+ST.Util.getGridHelp('plugin_api_list_interoplog_manage'),
                    width: '10%',
                    align: 'center',
                    border: 0,
                    dataIndex: 'id',
                    menuDisabled: true,
                    renderer: function (value, metadata, record, rowIndex, colIndex) {
                        var detail_link = "<a class='btn-link' href=\"javascript:;\" onclick=\"javascript:show_detail(" + value + ");\">详细信息</a>";
                        return detail_link;
                    }
                }

            ],
            listeners: {
                boxready: function () {


                    var height = Ext.dom.Element.getViewportHeight();
                    this.maxHeight = height - 106;
                    this.doLayout();
                },
                afterlayout: function (grid) {

                    var data_height = 0;
                    try {
                        data_height = grid.getView().getEl().down('.x-grid-table').getHeight();
                    } catch (e) {
                    }
                    var height = Ext.dom.Element.getViewportHeight();

                    if (data_height > height - 106) {
                        window.has_biged = true;
                        grid.height = height - 106;
                    }
                    else if (data_height < height - 106) {
                        if (window.has_biged) {


                            window.has_biged = false;
                            grid.doLayout();
                        }
                    }
                }
            },
            plugins: [

            ],
            viewConfig: {
                enableTextSelection:true
            }
        });

    }
)

//切换每页显示数量
function changeNum(combo, records) {

    var pagesize = records[0].get('num');
    window.product_store.pageSize = pagesize;
    window.product_store.loadPage(1);

    //window.product_grid.down('pagingtoolbar').moveFirst();

}

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

</script>
</html>