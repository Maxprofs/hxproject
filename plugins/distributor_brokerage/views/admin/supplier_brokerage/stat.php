<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title color_head=ZsACXC >线路订单管理-笛卡CMS{$coreVersion}</title>
    {template 'stourtravel/public/public_js'}
    {php echo Common::getCss('style.css,base.css,base_new.css'); }
    {php echo Common::getScript("jquery.buttonbox.js,choose.js,DatePicker/WdatePicker.js"); }
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

                    <div class="cfg-header-order-info">
                        <span class="item">总计可提金额：<span class="c-f60">&yen;{$price_arr['allow_price']}</span></span>
                        <span class="item">累积已提金额：<span class="c-f60">&yen;{$price_arr['withdraw_price_finish']}</span></span>
                        <span class="item">总计申请中金额：<span class="c-f60">&yen;{$price_arr['withdraw_price_approval']}</span></span>
                    </div>
                    <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
                </div>
                <div class="cfg-search-bar">
                    <div class="fl select-box w100 mt-2 ml-10">
                        <select name="webid" onchange="togStatus(this)"  class="select">
                            <option value="0" >供应商分类</option>
                            {loop $distributorkind $distributor}
                            <option value="{$distributor['id']}">{$distributor['kindname']}</option>
                            {/loop}

                        </select>
                    </div>

                    <span class="fl ml-20 mr-20 mt-3">
                        日期范围：
                        <input type="text" id="starttime" class="input-text w150 choosetime" />
                        <span class="pl-5 pr-5">至</span>
                        <input type="text"  id="endtime" class="input-text w150 choosetime" />
                    </span>
                    <div class="cfg-header-search">
                        <input type="text" id="searchkey" placeholder="供应商名称" datadef="供应商名称" class="search-text" />
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
Ext.onReady(
    function () {
        Ext.tip.QuickTipManager.init();
        $("#searchkey").focusEffect();

        //产品store
        window.product_store = Ext.create('Ext.data.Store', {

            fields: [
                'id',
                'distributorname',
                'kindname',
                'allow_price',
                'withdraw_price_finish',
                'withdraw_price_approval',
            ],

            proxy: {
                type: 'ajax',
                api: {
                    read: SITEURL+'distributor_brokerage/admin/brokerage/stat/action/read/',  //读取数据的URL
                    update: SITEURL+'distributor_brokerage/admin/brokerage/stat/action/save/',
                    destroy: SITEURL+'distributor_brokerage/admin/brokerage/stat/action/delete/'
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
                    width: '20%',
                    dataIndex: 'distributorname',
                    align: 'center',
                    border: 0,
                    sortable: false,
                    menuDisabled:true,
                    renderer: function (value, metadata, record) {
                        return value;
                    }

                },
                {
                    text: '供应商分类',
                    width: '20%',
                    dataIndex: 'kindname',
                    align: 'center',
                    border: 0,
                    sortable: false,
                    menuDisabled:true,
                    renderer: function (value, metadata, record) {
                        return value;
                    }
                },

                {
                    text: '可提金额',
                    width: '20%',
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
                    text: '申请中金额',
                    width: '20%',
                    dataIndex: 'withdraw_price_approval',
                    align: 'center',
                    border: 0,
                    sortable: false,
                    menuDisabled:true,
                    renderer: function (value, metadata, record) {
                        return value;
                    }

                },
                {
                    text: '已提金额',
                    width: '20%',
                    dataIndex: 'withdraw_price_finish',
                    align: 'center',
                    border: 0,
                    sortable: false,
                    menuDisabled:true,
                    renderer: function (value, metadata, record) {
                        return value;
                    }

                },

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


//日历选择
$(".choosetime").click(function(){
    var is_end = 0 ;
    if($(this).attr('id')=='endtime')
    {
        is_end = 1;
    }

    WdatePicker({skin:'whyGreen',dateFmt:'yyyy-MM-dd',maxDate: '#{%y+2}-%M-%d',onpicked:function () {
           if(is_end)
           {
               var starttime = $('#starttime').val();
               var endtime = $(this).val();
               if(CompareDate(starttime,endtime))
               {
                   ST.Util.showMsg('结束时间不能大于开始日期',5,1000);
                   $(this).val('');
                   return false;
               }
           }
           else
           {
               $('#endtime').val('');
           }

        }})
});

function CompareDate(d1,d2)
{
    return ((new Date(d1.replace(/-/g,"\/"))) > (new Date(d2.replace(/-/g,"\/"))));
}
function togStatus(ele)
{
    var status=$(ele).val();
    window.product_store.getProxy().setExtraParam('kindid',status);
    window.product_store.loadPage(1);

}
//按进行搜索
function searchKeyword() {
    var keyword = $.trim($("#searchkey").val());
    var datadef = $("#searchkey").attr('datadef');
    keyword = keyword==datadef ? '' : keyword;
    var starttime =$('#starttime').val();
    var endtime = $('#endtime').val();

    if(check_date(starttime,endtime))
    {
        ST.Util.showMsg('结束时间小于能大于开始时间',5,1000);
        return false;
    }
    window.product_store.getProxy().setExtraParam('starttime',starttime);
    window.product_store.getProxy().setExtraParam('endtime',endtime);
    window.product_store.getProxy().setExtraParam('keyword',keyword);
    window.product_store.loadPage(1);
}
//切换每页显示数量
function changeNum(combo, records) {
    var pagesize=records[0].get('num');
    window.product_store.pageSize=pagesize;
    window.product_store.loadPage(1);
}

function check_date(begintime,endtime) {

    var startTime = new Date(begintime);
    var endTime = new Date(endtime);
    return (startTime>endTime||startTime==endTime)

}





</script>

</body>
</html>
