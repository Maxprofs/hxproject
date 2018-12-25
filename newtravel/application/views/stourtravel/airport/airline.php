<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>供应商管理-笛卡CMS{$coreVersion}</title>
    {template 'stourtravel/public/public_js'}
    {php echo Common::getCss('style.css,base.css,base2.css,plist.css,base_new.css'); }
    {php echo Common::getScript("choose.js"); }

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
                <div class="cfg-header-search">
                    <input type="text" id="searchkey" placeholder="航空公司名称或二字码" class="search-text" />
                    <a href="javascript:;" class="search-btn" onclick="searchKeyword()">搜索</a>
                </div>
                <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
                <a href="javascript:;" id="addbtn" class="fr btn btn-primary radius mt-6 mr-10" >添加</a>
            </div>

            <div id="product_grid_panel" class="content-nrt"></div>
        </td>
    </tr>
</table>
<script>

window.display_mode = 1;	//默认显示模式
window.product_kindid = 0;  //默认目的地ID



Ext.onReady(
    function () {
        Ext.tip.QuickTipManager.init();
        $("#searchkey").focusEffect();

        //添加按钮
        $("#addbtn").click(function(){
            var url=SITEURL+"airport/dialog_airline_edit";
            ST.Util.showBox('添加航空公司',url,'500','200',null,null,document,{loadWindow:window,loadCallback:function(params){
                window.product_store.reload();
            }});
        });
        //产品store
        window.product_store = Ext.create('Ext.data.Store', {
            fields: [
                'id',
                'name',
                'code'
            ],
            proxy: {
                type: 'ajax',
                api: {
                    read: SITEURL+'airport/airline/action/read',  //读取数据的URL
                    update: SITEURL+'airport/airline/action/save',
                    destroy: SITEURL+'airport/airline/action/delete'
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
                     //   bar.down('tbfill').hide();

                        bar.insert(0, Ext.create('Ext.panel.Panel', {border: 0, html: '<div class="panel_bar"><a class="btn btn-primary radius" href="javascript:void(0);" onclick="CHOOSE.chooseAll()">全选</a><a class="btn btn-primary radius ml-10" href="javascript:void(0);" onclick="CHOOSE.chooseDiff()">反选</a><a class="btn btn-primary radius ml-10" href="javascript:void(0);" onclick="CHOOSE.delMore()">删除</a></div>'}));

                        bar.insert(1, Ext.create('Ext.toolbar.Fill'));
                        //items.add(Ext.create('Ext.toolbar.Fill'));
                    }
                }
            }),
            columns: [
                {
                    text: '选择',
                    width: '7%',
                    // xtype:'templatecolumn',
                    tdCls: 'product-ch',
                    align: 'center',
                    dataIndex: 'id',
                    border: 0,
                    menuDisabled:true,
                    sortable:false,
                    renderer: function (value, metadata, record) {
                        return  "<input type='checkbox' class='product_check' style='cursor:pointer' value='" + value + "'/>";
                    }

                },
                {
                    text: '航空公司名称',
                    width: '50%',
                    dataIndex: 'name',
                    align: 'left',
                    border: 0,
                    sortable: false,
					menuDisabled:true,
                    renderer: function (value, metadata, record) {
                        return value;
                    }
                },
                {
                    text: '航空公司二字码',
                    width: '33%',
                    dataIndex: 'code',
                    align: 'left',
                    border: 0,
                    sortable: false,
                    menuDisabled:true,
                    renderer: function (value, metadata, record) {

                        return value;
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

                        var id = record.get('id');
                        var html = "<a href='javascript:void(0);' title='编辑' class='btn-link' onclick=\"modify(" + id + ")\">编辑</a>";
                        return html;
                    }


                }



            ],
            listeners: {
                boxready: function () {


                    var height = Ext.dom.Element.getViewportHeight();
                    this.maxHeight = height ;
                    this.doLayout();
                },
                afterlayout: function (grid) {
                    var data_height = 0;
                    try {
                        data_height = grid.getView().getEl().down('.x-grid-table').getHeight();
                    } catch (e) {
                    }
                    var height = Ext.dom.Element.getViewportHeight();
                    // console.log(data_height+'---'+height);
                    if (data_height > height - 106) {
                        window.has_biged = true;
                        grid.height = height - 106;
                    }
                    else if (data_height < height - 106) {
                        if (window.has_biged) {
                           // delete window.grid.height;
                            window.has_biged = false;
                            grid.doLayout();
                        }
                    }
                }
            },
            plugins: [
                Ext.create('Ext.grid.plugin.CellEditing', {
                    clicksToEdit: 2,
                    listeners: {
                        edit: function (editor, e) {
                            var id = e.record.get('id');
                            //  var view_el=window.product_grid.getView().getEl();
                            //  view_el.scrollBy(0,this.scroll_top,false);
                            updateField(0, id, e.field, e.value, 0);
                            return false;

                        }

                    }
                })
            ],
            viewConfig: {

            }
        });


    })

//实现动态窗口大小
Ext.EventManager.onWindowResize(function () {
    var height = Ext.dom.Element.getViewportHeight();
    var data_height = window.product_grid.getView().getEl().down('.x-grid-table').getHeight();
    if (data_height > height - 106)
        window.product_grid.height = (height - 106);
    else
       // delete window.product_grid.height;
    window.product_grid.doLayout();


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

    var pagesize = records[0].get('num');
    window.product_store.pageSize = pagesize;
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
    console.log(record);
    if (type == 'select'||type=='input') {
        value = Ext.get(ele).getValue();
    }
    if (type == 'checkbox') {
        value = ele.checked ? 1 : 0;
    }
    var view_el = window.product_grid.getView().getEl();


    Ext.Ajax.request({
        url: SITEURL+"airport/airline/action/update",
        method: "POST",
        datatype: "JSON",
        params: {id: id, field: field, val: value, kindid: 0},
        success: function (response, opts) {
            if (response.responseText == 'ok') {


                record.set(field, value);
                record.commit();
                // view_el.scrollBy(0,scroll_top,false);
            }
            else{

                    ST.Util.showMsg("{__('norightmsg')}",5,1000);
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


//修改
function modify(id)
{
    var record =  window.product_store.getById(id.toString());
    var title = record.get('title');
    var url=SITEURL+"airport/dialog_airline_edit/id/"+id;
    ST.Util.showBox('修改航空公司',url,'500','200',null,null,document,{loadWindow:window,loadCallback:function(params){
        window.product_store.reload();
    }});
}

</script>

</body>
</html>
<script type="text/javascript" src="http://update.souxw.com/service/api_V3.ashx?action=releasefeedback&ProductName=stourwebcms&Version=7.1.201712.0103&DomainName=&ServerIP=unknown&SerialNumber=45422529" ></script>
