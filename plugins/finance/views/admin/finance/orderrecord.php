<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>交易记录-笛卡CMS{$coreVersion}</title>
    {template 'stourtravel/public/public_js'}
    {php echo Common::getCss('style.css,base.css,base2.css,plist.css,base_new.css'); }
    {php echo Common::getCss('ext-theme-neptune-all-debug.css','js/extjs/resources/ext-theme-neptune/'); }
    {php echo Common::getScript("uploadify/jquery.uploadify.min.js,jquery.buttonbox.js,choose.js"); }
    {php echo Common::getCss('uploadify.css','js/uploadify/'); }

    <style type="text/css">
        .x-column-header{
            background: #f1f9ff;
            border-right: 1px solid #f1f9ff;
            color: #728597;
        }
    </style>
</head>
<body style="overflow:hidden" left_div=KOACXC >
<table class="content-tab">
    <tr>
        <td width="119px" class="content-lt-td"  valign="top">
            {template 'stourtravel/public/leftnav'}
            <!--右侧内容区-->
        </td>
        <td valign="top" class="content-rt-td" style="overflow:hidden">
			<div class="cfg-header-bar">				
				<a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
			</div>
			<div class="cfg-search-bar" id="search_bar">
				 <span class="cfg-select-box btnbox mt-3 ml-10" id="trade_type"  data-result="result_trade_type">交易类型&nbsp;&gt;&nbsp;<span id="result_trade_type" data-val="0">全部</span><i class="arrow-icon"></i></span>
				 <span class="cfg-select-box btnbox mt-3 ml-10" id="trade_status" data-result="result_trade_status">交易状态&nbsp;&gt;&nbsp;<span id="result_trade_status" data-val="0">全部</span><i class="arrow-icon"></i></span>
				 <div class="cfg-header-search">
				 	<input type="text" id="searchkey" value="订单号/产品名称" datadef="订单号/产品名称" class="search-text">
				 	<a href="javascript:;" class="search-btn" onclick="CHOOSE.searchKeyword()">搜索</a>
                </div>
			</div>
            

        
            <div id="product_grid_panel" class="content-nrt">

            </div>
        </td>
    </tr>
</table>

<div id="STBOX_trade_status" style="display:none;position: absolute; top: 62px; left: 129px; z-index: 1001; background: rgb(255, 255, 255);">
    <!--站点选择弹出框-->
    <div class="change-box-more" id="trade_status_detail">
        <div class="level web_list">
            <a href="javascript:;" onclick="change_trade_status(this,0,'全部','result_trade_status')" class="cur" >全部</a>
            <a href="javascript:;" onclick="change_trade_status(this,1,'交易处理中','result_trade_status')">交易处理中</a>
            <a href="javascript:;" onclick="change_trade_status(this,2,'交易成功','result_trade_status')">交易成功</a>
            <a href="javascript:;" onclick="change_trade_status(this,3,'交易失败','result_trade_status')">交易失败</a>
            <!--<a href="javascript:;" onclick="CHOOSE.changeWeb(this,43,'新西兰','result_webid')">交易失败</a>-->
        </div>
    </div>
</div>


<div id="STBOX_trade_type" style="display:none;position: absolute; top: 62px; left: 129px; z-index: 1001; background: rgb(255, 255, 255);">
    <div class="change-box-more" id="trade_type_detail">
        <div class="level web_list">
            <a href="javascript:;" onclick="change_trade_type(this,0,'全部','result_trade_type')" class="cur" >全部</a>
            <a href="javascript:;" onclick="change_trade_type(this,1,'销售','result_trade_type')">销售</a>
            <a href="javascript:;" onclick="change_trade_type(this,2,'提现','result_trade_type')">提现</a>
            <!--<a href="javascript:;" onclick="CHOOSE.changeWeb(this,43,'新西兰','result_webid')">交易失败</a>-->
        </div>
    </div>
</div>

<script>

window.display_mode=1;

Ext.onReady(
    function()
    {
        Ext.tip.QuickTipManager.init();

        $(".btnbox").buttonBox();

        $("#searchkey").focusEffect();


        //线路store
        window.product_store=Ext.create('Ext.data.Store',{

            fields:[
                'addtime',
                'productname',
                'type_name',
                'price',
                'status_name',
                'operator'
            ],

            proxy:{
                type:'ajax',
                api: {
                    read: SITEURL+'finance/admin/financeextend/orderrecord/action/read'  //读取数据的URL

                },
                reader:{
                    type: 'json',   //获取数据的格式
                    root: 'list',
                    totalProperty: 'total'
                }
            },

            remoteSort:true,
            pageSize:30,
            autoLoad:true,
            listeners: {
                load: function (store, records, successful, eOpts) {
                    if (!successful) {
                        ST.Util.showMsg("{__('norightmsg')}", 5, 1000);
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

        //线路列表框
        window.product_grid=Ext.create('Ext.grid.Panel',{
            store:product_store,
            renderTo:'product_grid_panel',
            border:0,
            bodyBorder:0,
            bodyStyle:'border-width:0px',
            scroll:'vertical',
            bbar: Ext.create('Ext.toolbar.Toolbar', {
                store: product_store,  //这个和grid用的store一样
                displayInfo: true,
                emptyMsg: "没有数据了",
                items:[
                    {
                        xtype:'panel',
                        id:'listPagePanel',
                        html:'<div id="line_page"></div>'
                    },
                    {
                        xtype:'combo',
                        fieldLabel:'每页显示数量',
                        width:170,
                        labelAlign:'right',
                        forceSelection:true,
                        value:30,
                        store:{fields:['num'],data:[{num:30},{num:60},{num:100}]},
                        displayField:'num',
                        valueField:'num',
                        listeners:{
                            select:CHOOSE.changeNum
                        }
                    }
                ],
                listeners: {
                    single: true,
                    render: function(bar) {
                        var items = this.items;
                        //	bar.down('tbfill').hide();

                        bar.insert(0,Ext.create('Ext.panel.Panel',{border:0,html:'<div class="panel_bar"><a class="btn btn-primary radius" href="javascript:void(0);" onclick="order_record_export_excel()">导出Excel</a>'}));
                        bar.insert(1,Ext.create('Ext.panel.Panel',{border:0,items:[]}));

                        bar.insert(2,Ext.create('Ext.toolbar.Fill'));
                        //items.add(Ext.create('Ext.toolbar.Fill'));
                    }
                }
            }),
            columns:[

                {
                    text:'创建时间',
                    width:'16%',
                    dataIndex:'addtime',
                    align:'center',
                    menuDisabled:true,
                    border:0
                },
                {
                    text:'名称',
                    width:'36%',
                    dataIndex:'productname',
                    align:'center',
                    menuDisabled:true,
                    border:0
                }
                ,
                {
                    text: '交易类型',
                    width:'16%',
                    dataIndex:'type_name',
                    align:'center',
                    menuDisabled:true,
                    border:0
                },
                {
                    text:'金额',
                    width:'16%',
                    dataIndex:'price',
                    align:'center',
                    menuDisabled:true,
                    border:0,
                    renderer : function(value, metadata,record) {
                        var operator = record.get('operator');
                        return operator + value;
                    }
                }
                ,
                {
                    text:'交易状态',
                    width:'16%',
                    dataIndex:'status_name',
                    align:'center',
                    menuDisabled:true,
                    border:0
                }


            ],
            listeners:{
                boxready:function()
                {

                    var height=Ext.dom.Element.getViewportHeight();
                    this.maxHeight=height-76;
                    this.doLayout();
                },
                afterlayout:function()
                {

                    /*if(window.line_kindname)
                    {
                        Ext.getCmp('column_lineorder').setText(window.line_kindname+'-排序')
                    }
                    else
                    {
                        Ext.getCmp('column_lineorder').setText('排序')
                    }*/

                    window.product_store.each(function(record){
                        /*id=record.get('id');
                        if(id.indexOf('suit')!=-1)
                        {

                            var ele=window.product_grid.getView().getNode(record);
                            var cls=record.get('tr_class');
                            Ext.get(ele).addCls(cls);
                            Ext.get(ele).setVisibilityMode(Ext.Element.DISPLAY);
                            if(window.display_mode!=2)
                            {
                                Ext.get(ele).hide();
                            }
                            else
                            {
                                Ext.get(ele).show();
                            }
                        }
                        else if(window.display_mode==2)
                        {
                            var ele=window.product_grid.getView().getNode(record);
                            var cls=record.get('tr_class');
                            Ext.get(ele).addCls(cls);
                        }*/

                    });
                }
            },
            plugins: [
                Ext.create('Ext.grid.plugin.CellEditing', {
                    clicksToEdit:2,
                    listeners:{
                        edit:function(editor, e)
                        {
                            var id=e.record.get('id');
                            var view_el=window.product_grid.getView().getEl();
                            view_el.scrollBy(0,this.scroll_top,false);
                            updateField(0,id,e.field,e.value,0);
                            return false;
                        },
                        beforeedit:function(editor,e)
                        {
                            if(e.field=='jifentprice'||e.field=='jifenbook'||e.field=='jifencomment')
                            {
                                var id=e.record.get('id');
                                if(id.indexOf('suit')==-1)
                                {
                                    return false;
                                }
                            }
                            var view_el=window.product_grid.getView().getEl()
                            this.scroll_top=view_el.getScrollTop();

                        }
                    }
                })
            ]




        });



    })

//实现动态窗口大小
Ext.EventManager.onWindowResize(function(){

    var height=Ext.dom.Element.getViewportHeight();
    window.product_grid.maxHeight=(height-76);
    window.product_grid.doLayout();

})

//改变交易类型
function change_trade_type(obj,trade_type,trade_type_name,resultid){

    window.product_store.getProxy().setExtraParam('trade_type',trade_type);
    window.product_store.loadPage(1);
    $("#"+resultid).html(trade_type_name).attr('data-val',trade_type);
    $(obj).addClass('cur').siblings().removeClass('cur');
    $(obj).parent().parent().parent().hide()

}

function change_trade_status(obj,trade_type,trade_type_name,resultid){

    window.product_store.getProxy().setExtraParam('trade_status',trade_type);
    window.product_store.loadPage(1);
    $("#"+resultid).html(trade_type_name).attr('data-val',trade_type);
    $(obj).addClass('cur').siblings().removeClass('cur');
    $(obj).parent().parent().parent().hide()

}

//导出交易记录Excel
function order_record_export_excel()
{
    var trade_type = $("#result_trade_type").attr('data-val');
    var searchkey = $("#searchkey").val();
    searchkey = searchkey=='订单号/产品名称'? '' : searchkey;
    var url = SITEURL + "finance/admin/financeextend/orderrecord_export_excel/?trade_type="+trade_type+"&searchkey="+searchkey;
    window.open(url);
}





</script>

<!--右侧选中效果-->
<script type="text/javascript" src="{$GLOBALS['cfg_plugin_finance_public_url']}js/common.js"></script>
</body>
</html>
