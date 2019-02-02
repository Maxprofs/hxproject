<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>设置线路返佣比例和金额-笛卡CMS<?php echo $coreVersion;?></title>
    <?php echo  Stourweb_View::template('stourtravel/public/public_js');  ?>
    <?php echo Common::getCss('style.css,base.css,base_new.css,base2.css,plist.css'); ?>
    <link type="text/css" href="<?php echo $GLOBALS['cfg_plugin_finance_public_url'];?>css/fx_base.css" rel="stylesheet" />
    <link type="text/css" href="<?php echo $GLOBALS['cfg_plugin_finance_public_url'];?>css/fx_product.css" rel="stylesheet" />
    <script type="text/javascript" src="/tools/js/artDialog/dist/dialog-min.js"></script>
    <?php echo Common::getScript("uploadify/jquery.uploadify.min.js,jquery.buttonbox.js,choose.js,artDialog/dist/dialog-min.js"); ?>
    <?php echo Common::getCss('ui-dialog.css','js/artDialog/css/'); ?>
</head>
<body style="overflow:hidden">
<table class="content-tab">
    <tr>
        <td width="119px" class="content-lt-td"  valign="top">
            <?php echo  Stourweb_View::template('stourtravel/public/leftnav');  ?>
            <!--右侧内容区-->
        </td>
        <td valign="top" class="content-rt-td" style="overflow:hidden">
            <div class="cfg-header-bar">
                <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
            </div>
            <div class="cfg-search-bar" id="search_bar">
                <span class="select-box w150 mt-3 ml-10 fl">
                    <select class="select" id="fx_products">
                        <?php $n=1; if(is_array($products)) { foreach($products as $product) { ?>
                        <option value="<?php echo $product['id'];?>" <?php if($typeid==$product['id']) { ?>selected="selected"<?php } ?>
><?php echo $product['modulename'];?></option>
                        <?php $n++;}unset($n); } ?>
                    </select>
                </span>
                <div class="select-box w150 mt-3 ml-10 fl">
                    <select class="select" id="fx_supplier">
                        <option value="">供应商</option>
                        <?php $n=1; if(is_array($supplier_list)) { foreach($supplier_list as $supplier) { ?>
                        <option value="<?php echo $supplier['id'];?>"><?php echo $supplier['suppliername'];?></option>
                        <?php $n++;}unset($n); } ?>
                    </select>
                </div>
                <div class="cfg-header-search">
                    <input type="text" id="searchkey" value="产品标题或编号" datadef="产品标题或编号" class="search-text">
                    <a href="javascript:;" class="search-btn" onclick="searchData()">搜索</a>
                </div>
                 <span class="display-mod">
                 </span>
            </div>
            <div id="product_grid_panel" class="content-nrt">
            </div>
        </td>
    </tr>
</table>
<script>
window.display_mode=1;//默认显示模式
window.product_kindid=0;  //默认目的地ID
var typeid="<?php echo $typeid;?>";
Ext.onReady(
    function()
    {
        Ext.tip.QuickTipManager.init();
        $(".btnbox").buttonBox();
        $("#searchkey").focusEffect();
        //添加按钮
        //产品store
        window.product_store=Ext.create('Ext.data.Store',{
            fields:[
                'id',
                'title',
                'url',
                'modtime',
                'commission_type',
                'commission_ratio',
                'commission_cash',
                'commission_cash_child',
                'commission_cash_old'
            ],
            proxy:{
                type:'ajax',
                extraParams:{typeid:typeid},
                api: {
                    read: SITEURL+'finance/admin/financeextend/config_commission_product/action/read/typeid/<?php echo $typeid;?>',  //读取数据的URL
                    update:SITEURL+'finance/admin/financeextend/config_commission_product/action/save/typeid/<?php echo $typeid;?>',
                    destroy:SITEURL+'finance/admin/financeextend/config_commission_product/action/delete/typeid/<?php echo $typeid;?>'
                },
                reader:{
                    type: 'json',   //获取数据的格式
                    root: 'lists',
                    totalProperty: 'total'
                }
            },
            remoteSort:true,
            autoLoad:true,
            pageSize:30,
            listeners:{
                load:function( store, records, successful, eOpts )
                {
                    if(!successful){
                        ST.Util.showMsg("<?php echo __('norightmsg');?>",5,1000);
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
        window.product_grid=Ext.create('Ext.grid.Panel',{
            store:product_store,
            renderTo:'product_grid_panel',
            border:0,
            bodyBorder:0,
            bodyStyle:'border-width:0px',
            scroll:'vertical', //只要垂直滚动条
            bbar: Ext.create('Ext.toolbar.Toolbar', {
                store: product_store,  //这个和grid用的store一样
                displayInfo: true,
                emptyMsg: "",
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
                        //bar.down('tbfill').hide();
                        bar.insert(0,Ext.create('Ext.panel.Panel',{border:0,html:'<div class="panel_bar"><a class="btn btn-primary radius" href="javascript:void(0);" onclick="CHOOSE.chooseAll()">全选</a><a class="btn btn-primary radius ml-10" href="javascript:void(0);" onclick="setFenxiao()">批量设置</a></div>'}));
                        bar.insert(1,Ext.create('Ext.toolbar.Fill'));
                        //items.add(Ext.create('Ext.toolbar.Fill'));
                    }
                }
            }),
            columns:[
                {
                    text:'选择',
                    width:'6%',
                    // xtype:'templatecolumn',
                    tdCls:'product-ch',
                    align:'center',
                    dataIndex:'id',
                    border:0,
                    menuDisabled:true,
                    renderer : function(value, metadata,record) {
                        var id=record.get('id');
                        return  "<input type='checkbox' class='product_check' id='box_"+id+"' style='cursor:pointer' value='"+value+"'/>";
                    }
                },
                {
                    text:'产品ID',
                    width:'10%',
                    dataIndex:'id',
                    align:'center',
                    menuDisabled:true,
                    border:0,
                    sortable:false,
                    renderer : function(value, metadata,record) {
                        return value;
                    }
                },
                {
                    text:'标题',
                    width:'26%',
                    dataIndex:'title',
                    align:'left',
                    menuDisabled:true,
                    border:0,
                    sortable:false,
                    renderer : function(value, metadata,record) {
                        var url=record.get('url');
                        return "<a href='"+url+"' class='line-title' target='_blank'>"+value+"</a>";
                    }
                },
                {
                    text:'添加产品时间',
                    width:'10%',
                    cls: 'mod-2 sort-col',
                    dataIndex:'modtime',
                    align:'center',
                    menuDisabled:true,
                    border:0,
                    sortable:true,
                    renderer : function(value, metadata,record) {
                        return value;
                    }
                },
                {
                    text: '返佣类型',
                    width: '16%',
                    dataIndex: 'commission_type',
                    align: 'center',
                    border: 0,
                    cls: 'mod-1 sort-col',
                    menuDisabled: true,
                    sortable: true,
                    renderer: function (value, metadata, record) {
                        var id = record.get('id');
                        value = !value ? '' : value;
                        return '<select class="row-edit-select" onchange="updateField(this,'+id+',\'commission_type\',0,\'select\')">' +
                            '<option value="1" '+ (value==1? 'selected="selected"':'' )+'>比例</option>' +
                            '<option value="0" '+ (value==0? 'selected="selected"':'' )+'>现金</option>' +
                            '</select>';
                    }
                },
                {
                    text: '比例',
                    width: '8%',
                    dataIndex: 'commission_ratio',
                    align: 'center',
                    border: 0,
                    cls: 'mod-1 sort-col',
                    menuDisabled: true,
                    sortable: true,
                    renderer: function (value, metadata, record) {
                        var id = record.get('id');
                        value = !value ? '' : value;
                        return "<input type='text' value='" + value + "' class='row-edit-txt fx-ratio-edit'  onblur=\"updateField(this,'" + id + "','commission_ratio',0,'input')\"/><span style='color:green'> %<span>";
                    }
                },
                {
                    text: '金额',
                    width: '8%',
                    dataIndex: 'commission_cash',
                    align: 'center',
                    border: 0,
                    cls: 'mod-1 sort-col',
                    menuDisabled: true,
                    sortable: true,
                    renderer: function (value, metadata, record) {
                        var id = record.get('id');
                        value = !value ? '' : value;
                        return "<input type='text' value='" + value + "' class='row-edit-txt fx-ratio-edit' onblur=\"updateField(this,'" + id + "','commission_cash',0,'input')\"/><span style='color:green'> 元<span>";
                    }
                },
                {
                    text: '金额(小孩)',
                    width: '8%',
                    dataIndex: 'commission_cash_child',
                    align: 'center',
                    border: 0,
                    cls: 'mod-1 sort-col',
                    menuDisabled: true,
                    sortable: true,
                    renderer: function (value, metadata, record) {
                        var id = record.get('id');
                        value = !value ? '' : value;
                        return "<input type='text' value='" + value + "' class='row-edit-txt fx-ratio-edit'  onblur=\"updateField(this,'" + id + "','commission_cash_child',0,'input')\"/><span style='color:green'> 元<span>";
                    }
                },
                {
                    text: '金额(老人)',
                    width: '8%',
                    dataIndex: 'commission_cash_old',
                    align: 'center',
                    border: 0,
                    cls: 'mod-1 sort-col',
                    menuDisabled: true,
                    sortable: true,
                    renderer: function (value, metadata, record) {
                        var id = record.get('id');
                        value = !value ? '' : value;
                        return "<input type='text' value='" + value + "' class='row-edit-txt fx-ratio-edit' onblur=\"updateField(this,'" + id + "','commission_cash_old',0,'input')\"/><span style='color:green'> 元<span>";
                    }
                }
            ],
            listeners:{
                boxready:function()
                {
                    var height=Ext.dom.Element.getViewportHeight();
                    this.maxHeight=height-106;
                    this.doLayout();
                },
                afterlayout:function(grid)
                {
                    if(window.product_kindname)
                    {
                        //Ext.getCmp('column_lineorder').setText(window.product_kindname+'-排序')
                    }
                    else
                    {
                        //Ext.getCmp('column_lineorder').setText('排序')
                    }
                    /*window.product_store.each(function(record){
                     id=record.get('id');
                     });*/
                    var data_height=0;
                    try{
                        data_height=grid.getView().getEl().down('.x-grid-table').getHeight();
                    }catch(e)
                    {
                    }
                    var height=Ext.dom.Element.getViewportHeight();
                    if(data_height>height-106)
                    {
                        window.has_biged=true;
                        grid.height=height-106;
                    }
                    else if(data_height<height-106)
                    {
                        if(window.has_biged)
                        {
                            window.has_biged=false;
                            grid.doLayout();
                        }
                    }
                }
            },
            plugins: [
                Ext.create('Ext.grid.plugin.CellEditing', {
                    clicksToEdit:2,
                    listeners:{
                        edit:function(editor, e)
                        {
                            var id=e.record.get('id');
                            updateField(0,id,e.field,e.value,0);
                            return false;
                        },
                        beforeedit:function(editor,e)
                        {
                        }
                    }
                })
            ],
            viewConfig:{
                //enableTextSelection:true
            }
        });
    })
//实现动态窗口大小
Ext.EventManager.onWindowResize(function(){
    var height=Ext.dom.Element.getViewportHeight();
    var data_height=window.product_grid.getView().getEl().down('.x-grid-table').getHeight();
    if(data_height>height-106)
        window.product_grid.height=(height-106);
    else
        delete window.product_grid.height;
    window.product_grid.doLayout();
})
$("#fx_products").change(function(){
    var tid=$(this).val();
    typeid=tid;
    //  product_store.getProxy().setExtraParam('typeid',typeid);
    //product_store.loadPage(1);
    var url=SITEURL+'finance/admin/financeextend/config_commission_product/typeid/'+tid+'/parentkey/finance/itemid/5<?php if($menuid) { ?>/menuid/<?php echo $menuid;?><?php } ?>
';
    window.location.href=url;
});
$("#fx_supplier").change(function(){
    searchData();
});
//更新某个字段
function updateField(ele,id,field,value,type,callback)
{
    var record=window.product_store.getById(id.toString());
    if(type=='select'||type=='input')
    {
        value=Ext.get(ele).getValue();
        if(!(type=='input'))
        {
            return;
        }
    }
    var view_el=window.product_grid.getView().getEl();
    Ext.Ajax.request({
        url   :  SITEURL+"finance/admin/financeextend/config_commission_product/action/update",
        method  :  "POST",
        datatype  :  "JSON",
        params:{id:id,field:field,val:value,typeid:typeid},
        success  :  function(response, opts)
        {
            if(response.responseText=='ok')
            {
                record.set(field,value);
                record.commit();
                if(typeof(callback)=='function')
                {
                    callback(record);
                }
            }
            else
            {
                ST.Util.showMsg("<?php echo __('norightmsg');?>",5,1000);
            }
        }});
}
function updateFields(id,data)
{
    var record=window.product_store.getById(id.toString());
    var view_el=window.product_grid.getView().getEl();
    data['id']=id;
    data['typeid']=typeid;
    Ext.Ajax.request({
        url   :  SITEURL+"finance/admin/financeextend/config_commission_product/action/updatesome",
        method  :  "POST",
        datatype  :  "JSON",
        params:data,
        success  :  function(response, opts)
        {
            if(response.responseText=='ok')
            {
                for(var i in data) {
                    record.set(i, data[i]);
                    record.commit();
                    if (typeof(callback) == 'function') {
                        callback(record);
                    }
                }
            }
            else
            {
                ST.Util.showMsg("<?php echo __('norightmsg');?>",5,1000);
            }
        }});
}
function setFenxiao()
{
    if($(".product_check:checked").length<=0)
    {
        ST.Util.showMsg("请至少选择一个产品",5,1000);
        return;
    }
    var content='<div class="item-one" id="ratio_set_con"><table>'+
        '<tr><td class="tit">佣金类型：</td><td><select name="commission_type"  id="set_commission_type"><option value="1" selected="selected" >比例</option><option value="0">现金</option></select></td></tr>'+
        '<tr><td class="tit">比例：</td><td><input type="text" name="commission_ratio"  id="set_commission_ratio" class="set-text-xh text_60" value=""><span style="color:green"> %</span></td></tr>'+
        '<tr><td class="tit">现金：</td><td><input type="text" name="commission_cash"  id="set_commission_cash" class="set-text-xh text_60" value=""><span style="color:green"> 元</span></td></tr>'+
        '<tr id="tr_commission_cash_child"><td class="tit">现金(小孩)：</td><td><input type="text" name="commission_cash_child"  id="set_commission_cash_child" class="set-text-xh text_60" value=""><span style="color:green"> 元</span></td></tr>'+
        '<tr id="tr_commission_cash_old"><td class="tit">现金(老人)：</td><td><input type="text" name="commission_cash_old"  id="set_commission_cash_old" class="set-text-xh text_60" value=""><span style="color:green"> 元</span></td></tr>'+
        '</table>' +
        '<div class="save-con"><a href="javascript:;" class="confirm-btn" id="ratio_set_btn">确定</a></div>' +
        '</div>';
    var dlg = dialog({
        title: '批量设置',
        content: content,
        onshow:function(){
            $("#ratio_set_btn").click(function(){
                var commission_type=$("#set_commission_type").val();
                var commission_ratio=$("#set_commission_ratio").val();
                var commission_cash=$("#set_commission_cash").val();
                var commission_cash_child=$("#set_commission_cash_child").val();
                var commission_cash_old=$("#set_commission_cash_old").val();
                $(".product_check:checked").each(function(){
                    var id=$(this).val();
                    updateFields(id,{'commission_type':commission_type,'commission_ratio':commission_ratio,'commission_cash':commission_cash,'commission_cash_child':commission_cash_child,'commission_cash_old':commission_cash_old})
                })
                dlg.remove();
                location.reload();
            });
        }
    });
    dlg.showModal();
    //var url = SITEURL+'product/dialog_setratio/typeid/1/'
    //CHOOSE.setSome("设置分销",null,url,1);
}
function searchData()
{
    var keyword = $.trim($("#searchkey").val());
    var datadef = $("#searchkey").attr('datadef');
    keyword = keyword==datadef ? '' : keyword;
    var supplier = $("#fx_supplier").val();
    window.product_store.getProxy().setExtraParam('keyword',keyword);
    window.product_store.getProxy().setExtraParam('supplier',supplier);
    window.product_store.loadPage(1);
}
</script>
<!--右侧选中效果-->
<script type="text/javascript" src="<?php echo $GLOBALS['cfg_plugin_finance_public_url'];?>js/common.js"></script>
</body>
</html>
