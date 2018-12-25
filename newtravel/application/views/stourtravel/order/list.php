<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>问答管理-笛卡CMS{$coreVersion}</title>
    {template 'stourtravel/public/public_js'}
    {php echo Common::getCss('style.css,base.css,base2.css,plist.css,order.css,base_new.css'); }
    {php echo Common::getScript("jquery.buttonbox.js,choose.js"); }

</head>
<style>
    /*搜索*/

</style>
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
                    <span class="item">今日：<span id="today_price" class="c-orange"></span></span>
                    <span class="item">昨日：<span id="last_price" class="c-orange"></span></span>
                    <span class="item">本周：<span id="thisweek_price" class="c-orange"></span></span>
                    <span class="item">本月：<span id="thismonth_price" class="c-orange"></span></span>
                    <span class="item">总销售额：<span id="total_price" class="c-orange"></span></span>
                </div>
                <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
                <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10 btn_report" title="查看数据报表">数据报表</a>
                <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10 btn_excel" title="导出Excel报表">导出Excel</a>
            </div>
            <div class="cfg-search-bar" id="search_bar">
                <div class="fl select-box w100 mt-3 ml-10">
                   <select name="webid" onchange="togWeb(this)"  class="select">
                       <option value="0" >主站</option>
                       {php $weblist=Common::getWeblist()}
                        {loop $weblist $web}
                         <option value="{$web['id']}">{$web['kindname']}</option>
                        {/loop}
                   </select>
                </div>
                <div class="fl select-box w100 mt-3 ml-10">
                    <select name="status" onchange="togStatus(this)" class="select">
                        <option value="">订单状态</option>
                        {loop $statusnames $row}
                        <option value="{$row['status']}">{$row['name']}</option>
                        {/loop}
                    </select>
                </div>
                <div class="fl select-box w150 mt-3 ml-10">
                    <select name="paysource" onchange="togPaysource(this)" class="select">
                        <option value="">支付方式</option>
                        {loop $paysources $v}
                        <option value="{$v}">{$v}</option>
                        {/loop}
                    </select>
                </div>
                <div class="cfg-header-search">
                    <input type="text" id="searchkey" placeholder="订单号/产品名称/联系人" datadef="订单号/产品名称/联系人" class="search-text" />
                    <a href="javascript:;" class="search-btn" onclick="searchKeyword()">搜索</a>
                </div>
            </div>
            <div id="product_grid_panel" class="content-nrt" ></div>
        </td>
    </tr>
</table>
<script>

window.display_mode = 1;	//默认显示模式
window.product_kindid = 0;  //默认目的地ID

window.statusmenu={json_encode($statusnames)};
window.paysources={json_encode($paysources)};


function togWeb(ele)
{
    var webid=$(ele).val();
    window.product_store.getProxy().setExtraParam('webid',webid);
    window.product_store.loadPage(1);

}
Ext.onReady(
    function () {
        Ext.tip.QuickTipManager.init();
        //var editico = "{php echo Common::getIco('edit');}";
        var delico = "{php echo Common::getIco('del');}";
        var editico = "{php echo Common::getIco('order');}";
        var unviewico="{php echo Common::getIco('order_unview');}";

        $("#searchkey").focusEffect();

        //站点切换
   /*     var web_menu_items=[];
        Ext.Array.each(window.WEBLIST,function(row,index,itself){
            web_menu_items.push({text:row.webname,webid:row.webid});
        });

        Ext.create('Ext.button.Cycle',{
            renderTo:'list_ot_web',
            text:'主站',
            showText:true,
            style:"background:#07C3D9",
            menu:{
                items:web_menu_items
            },
            changeHandler: function(cycleBtn, activeItem) {
                if(!window.web_togfirst)
                {
                    window.web_togfirst=1;
                    return;
                }


            }

        });
        */


        //产品store
        window.product_store = Ext.create('Ext.data.Store', {

            fields: [
                'id',
                'typeid',
                'ordersn',
                'productname',
                'addtime',
                'usedate',
                'dingnum',
                'price',
                'childprice',
                'childnum',
                'linkman',
                'linktel',
                'status',
                'viewstatus',
                'paysource',
                'paytype',
                'dingjin',
                'statusname',
                'online_refund_status'


            ],

            proxy: {
                type: 'ajax',
                api: {
                    read: SITEURL+'order/index/action/read/typeid/{$typeid}',  //读取数据的URL
                    update: SITEURL+'order/index/action/save/typeid/{$typeid}',
                    destroy: SITEURL+'order/index/action/delete/typeid/{$typeid}'
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

                        bar.insert(0, Ext.create('Ext.panel.Panel', {border: 0, html: '<div class="panel_bar"><a class="btn btn-primary radius" href="javascript:void(0);" onclick="CHOOSE.chooseAll()">全选</a><a class="btn btn-primary radius ml-10" href="javascript:void(0);" onclick="CHOOSE.chooseDiff()">反选</a><a class="btn btn-primary radius ml-10" href="javascript:void(0);" onclick="CHOOSE.viewAll(selecteViewed)">已读</a></div>'}));

                        bar.insert(1, Ext.create('Ext.toolbar.Fill'));
                        //items.add(Ext.create('Ext.toolbar.Fill'));
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
                    menuDisabled:true,
                    border: 0,
                    renderer: function (value, metadata, record) {

                        return  "<input type='checkbox' class='product_check' style='cursor:pointer' value='" + value + "'/>";

                    }

                },
                {
                    text: '订单号',
                    width: '10%',
                    dataIndex: 'ordersn',
                    align: 'center',
                    border: 0,
                    sortable: false,
                    menuDisabled:true,
                    renderer: function (value, metadata, record) {
                        return value;
                    }

                },

                {
                    text: '产品名称',
                    width: '21%',
                    dataIndex: 'productname',
                    align: 'left',
                    border: 0,
                    sortable: false,
                    menuDisabled:true,
                    renderer: function (value, metadata, record) {
                        return value;
                    }
                },
                {
                    text: '联系人',
                    width: '7%',
                    dataIndex: 'linkman',
                    align: 'center',
                    border: 0,
                    sortable: false,
                    menuDisabled:true,
                    renderer: function (value, metadata, record) {
                        var str='';
                        if(value.length>0){
                            str+=value;
                        }
                        return str;
                    }

                },
                {
                    text: '联系人电话',
                    width: '7%',
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
                    text: '申请日期',
                    width: '8%',
                    dataIndex: 'addtime',
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
                    text: '使用日期',
                    width: '7%',
                    dataIndex: 'usedate',
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
                    text: '预订数量',
                    width: '6%',
                    dataIndex: 'dingnum',
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
                    text: '金额',
                    width: '8%',
                    dataIndex: 'price',
                    align: 'center',
                    border: 0,
                    sortable: false,
                    menuDisabled:true,
                    renderer: function (value, metadata, record) {
                        var dingjin=record.get('dingjin');
                        var paytype=record.get('paytype');
                        var prefix=dingjin>0&&paytype==2?'定金 ':'';
                        var str='';
                        if(value>0){
                            str+=prefix+value;
                        }
                        if(record.get('paysource')){
                            str+='<br>' +record.get('paysource');
                        }
                        return str;
                    }
                },
                {
                    text: '订单状态',
                    width: '7%',
                    dataIndex: 'status',
                    align: 'center',
                    border: 0,
                    cls:'sort-col',
                    sortable: true,
                    menuDisabled:true,
                    renderer: function (value, metadata, record) {
                        var status_name=record.get('statusname');
                        var status=record.get('status');
                        var online_refund_status=record.get('online_refund_status');
                        if(status==6&&online_refund_status==2)
                        {
                            status_name += '<i style="color: red">(退款失败)</i>';
                        }
                        return status_name;
                    }

                },
                {
                    text: '状态',
                    width: '7%',
                    dataIndex: 'viewstatus',
                    align: 'center',
                    border: 0,
                    cls:'sort-col',
                    sortable: true,
                    menuDisabled:true,
                    renderer: function (value, metadata, record) {
                        return value>0?'已读':'<span style="color:#F00;">未读</span>';
                    }

                },
                {
                    text: '管理',
                    width: '7%',
                    align: 'center',
                    border: 0,
                    sortable: false,
                    menuDisabled:true,
                    cls: 'mod-1',
                    renderer: function (value, metadata, record) {

                        var id = record.get('id');
                        var typeid = record.get('typeid');
                        var viewstatus=record.get('viewstatus');
                        var ico=viewstatus==1?editico:unviewico;
                        var html = "<a href='javascript:void(0);' class='btn-link' onclick=\"view(" + id + ","+typeid+")\">编辑</a>";
                        return html;
                    }
                }
            ],
            listeners: {
                boxready: function () {


                    var height = Ext.dom.Element.getViewportHeight();
                    //console.log('viewportHeight:'+height);
                    this.maxHeight = height-90 ;
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
                    if (data_height > height - 106) {
                        window.has_biged = true;
                        grid.height = height - 106;
                    }
                    else if (data_height < height - 106) {
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


    })

//实现动态窗口大小
Ext.EventManager.onWindowResize(function () {

    var height = Ext.dom.Element.getViewportHeight();
    var data_height = window.product_grid.getView().getEl().down('.x-grid-table').getHeight();
    if (data_height > height - 140)
        window.product_grid.height = (height - 140);
    else
       delete window.product_grid.height;
    window.product_grid.doLayout();


})

function selecteViewed(ids){
    Ext.Ajax.request({
        url   :  SITEURL+"order/viewed",
        method  :  "POST",
        datatype  :  "JSON",
        params:{ids:ids.join(',')},
        success  :  function(response, opts)
        {
            if(response.responseText=='ok')
            {
                var record;
                $.each(ids,function(index,value){
                    record=window.product_store.getById(value.toString());
                    record.set('viewstatus',1);
                    record.commit();
                });
            }
            else
            {
                ST.Util.showMsg("{__('norightmsg')}",5,1000);
            }
        }
    });
}

function togStatus(ele)
{
    var status=$(ele).val();
    window.product_store.getProxy().setExtraParam('status',status);
    window.product_store.loadPage(1);

}
function togPaysource(ele)
{
    var paysource=$(ele).val();
    window.product_store.getProxy().setExtraParam('paysource',paysource);
    window.product_store.loadPage(1);
}

$(function(){


    var typeid = "{$typeid}";
    var channelname = "{$channelname}";
    //查看数据报表
    $(".btn_report").click(function(){
        var url=SITEURL+"order/dataview/typeid/"+typeid;
        ST.Util.showBox(channelname+'订单数据报表查看',url,860,510,function(){});

    })
    //导出excel
    $(".btn_excel").click(function(){
        var url=SITEURL+"order/excel/typeid/"+typeid;
        ST.Util.showBox(channelname+'订单生成excel',url,560,380,function(){});
    })

    //获取当前产品订单常规信息
    $.getJSON(SITEURL+'order/ajax_sell_info/typeid/'+typeid,function(data){
        $("#today_price").html(data.today);
        $("#last_price").html(data.last);
        $("#thisweek_price").html(data.thisweek);
        $("#thismonth_price").html(data.thismonth);
        $("#total_price").html(data.total);

    })





})






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

    //var pagesize = records[0].get('num');
    //window.product_store.pageSize = pagesize;
    //window.product_grid.down('pagingtoolbar').moveFirst();
    //window.product_store.load({start:0});
    var pagesize=records[0].get('num');
    window.product_store.pageSize=pagesize;
    window.product_store.loadPage(1);
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
function del() {
    //window.product_grid.down('gridcolumn').hide();

    var check_cmp = Ext.select('.product_check:checked');

    if (check_cmp.getCount() == 0) {
        return;
    }
    ST.Util.confirmBox("提示","确定删除？",function(){
        check_cmp.each(
            function (el, c, index) {
                window.product_store.getById(el.getValue()).destroy();
            }
        );
    })
}
//更新某个字段
function updateField(ele, id, field, value, type) {
    var record = window.product_store.getById(id.toString());

    if (type == 'select') {
        value = Ext.get(ele).getValue();
    }
    var view_el = window.product_grid.getView().getEl();


    Ext.Ajax.request({
        url: SITEURL+"order/index/action/update/",
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

//删除套餐
function delS(id) {
    ST.Util.confirmBox("提示","确定删除？",function(){
            window.product_store.getById(id.toString()).destroy();
    })
}

//刷新保存后的结果
function refreshField(id, arr) {
    id = id.toString();
    var id_arr = id.split('_');
    // var view_el=window.product_grid.getView().getEl()
    //var scroll_top=view_el.getScrollTop();
    Ext.Array.each(id_arr, function (num, index) {
        if (num) {
            var record = window.product_store.getById(num.toString());

            for (var key in arr) {
                record.set(key, arr[key]);
                record.commit();
                // view_el.scrollBy(0,scroll_top,false);
                // window.line_grid.getView().refresh();
            }
        }
    })
}


//查看订单
function view(id,typeid)
{
    var channelname = "{$channelname}";
    var record = window.product_store.getById(id.toString());

    var url=SITEURL+"order/view/{if isset($_GET['menuid'])}menuid/{$_GET['menuid']}/{/if}id/"+id+"/typeid/"+typeid;
    //ST.Util.showBox('查看订单信息',url,600,300,function(){window.product_store.load()});
    ST.Util.addTab(channelname+'订单：'+record.get('ordersn'),url,1);

}

</script>

</body>
</html>
<script type="text/javascript" src="http://update.souxw.com/service/api_V3.ashx?action=releasefeedback&ProductName=stourwebcms&Version=7.1.201809.1301&DomainName=&ServerIP=unknown&SerialNumber=45422529" ></script>
