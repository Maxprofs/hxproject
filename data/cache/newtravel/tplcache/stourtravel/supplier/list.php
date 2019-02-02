<!doctype html>
<html>
<head script_ul=JIACXC >
    <meta charset="utf-8">
    <title>供应商管理-笛卡CMS<?php echo $coreVersion;?></title>
    <?php echo  Stourweb_View::template('stourtravel/public/public_js');  ?>
    <?php echo Common::getCss('style.css,base.css,base2.css,plist.css,base_new.css'); ?>
    <?php echo Common::getScript("choose.js"); ?>
</head>
<style>
    /*搜索*/
</style>
<body style="overflow:hidden">
<table class="content-tab">
    <tr>
        <td width="119px" class="content-lt-td" valign="top">
            <?php echo  Stourweb_View::template('stourtravel/public/leftnav');  ?>
            <!--右侧内容区-->
        </td>
        <td valign="top" class="content-rt-td" style="overflow:hidden">
            <div class="cfg-header-bar">
                <span class="select-box w150 mt-5 ml-10 fl">
            <select name="authorization" onchange="searchKeyword()"  class="select">
                        <option value="">经营范围</option>
                        <?php $n=1; if(is_array($product_list)) { foreach($product_list as $p) { ?>
                        <option value="<?php echo $p['id'];?>"><?php echo $p['modulename'];?></option>
                        <?php $n++;}unset($n); } ?>
                    </select>
            </span>
            <span class="select-box w150 mt-5 ml-10 fl">
            <select name="kindid" onchange="searchKeyword()"  class="select">
                        <option value="">所属分类</option>
                        <?php $n=1; if(is_array($kindmenu)) { foreach($kindmenu as $item) { ?>
                        <option value="<?php echo $item['id'];?>"><?php echo $item['kindname'];?></option>
                        <?php $n++;}unset($n); } ?>
                    </select>
            </span>
                <span class="select-box w150 mt-5 ml-10 fl">
            <select name="suppliertype" onchange="searchKeyword()" class="select">
                        <option value="">供应商类型</option>
                        <option value='0'>平台供应商</option>
                        <option value='1'>第三方供应商</option>
                    </select>
                </span>
            <span class="select-box w150 mt-5 ml-10 fl">
            <select name="verifystatus" onchange="searchKeyword()" class="select">
                    <option value="">认证状态</option>
                    <option value='0'>未认证</option>
                    <option value='1'>审核中</option>
                    <option value='2'>未通过</option>
                    <option value='3'>已认证</option>
                </select>
                </span>
                <div class="cfg-header-search">
                <input type="text" id="searchkey" placeholder="供应商名称/联系人/手机号/邮箱" value=""  class="search-text" />
                    <a href="javascript:;" class="search-btn" onclick="searchKeyword()">搜索</a>
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
window.display_mode = 1;//默认显示模式
window.product_kindid = 0;  //默认目的地ID
window.kindmenu=<?php echo json_encode($kindmenu);?>;
Ext.onReady(
    function () {
        Ext.tip.QuickTipManager.init();
        var editico = "<?php echo Common::getIco('edit');?>";
        var delico = "<?php echo Common::getIco('del');?>";
        //添加按钮
        $("#addbtn").click(function(){
            var url=SITEURL+"supplier/add/menuid/<?php echo $_GET['menuid'];?>/parentkey/member/itemid/2";
            //ST.Util.showBox('添加供应商',url,'600','400',function(){window.product_store.load()});
            ST.Util.addTab('添加供应商',url,0);
        });
        //产品store
        window.product_store = Ext.create('Ext.data.Store', {
            fields: [
                'id',
                'displayorder',
                'suppliername',
                'authorization_h',
                'suppliertype',
                'verifystatus',
                'account',
                'linkman',
                'telephone',
                'kindid',
                'mobile',
                'email',
                'qq'
            ],
            proxy: {
                type: 'ajax',
                api: {
                    read: SITEURL+'supplier/index/action/read',  //读取数据的URL
                    update: SITEURL+'supplier/index/action/save',
                    destroy: SITEURL+'supplier/index/action/delete'
                },
                reader: {
                    type: 'json',   //获取数据的格式
                    root: 'lists',
                    totalProperty: 'total'
                },
                extraParams:{
                    keyword:'',
                    kindid:'',
                    verifystatus:'',
                    suppliertype:'',
                    authorization:''
                }
            },
            remoteSort: true,
            pageSize: 20,
            autoLoad: true,
            listeners: {
                load: function (store, records, successful, eOpts) {
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
                    width: '5%',
                    // xtype:'templatecolumn',
                    tdCls: 'product-ch',
                    align: 'center',
                    dataIndex: 'id',
                    border: 0,
                    menuDisabled:true,
                    renderer: function (value, metadata, record) {
                        return  "<input type='checkbox' class='product_check' style='cursor:pointer' value='" + value + "'/>";
                    }
                },
                {
                    text: '排序',
                    width: '5%',
                    cls:'sort-col',
                    // xtype:'templatecolumn',
                    tdCls: 'product-ch',
                    align: 'center',
                    dataIndex: 'displayorder',
                    border: 0,
                    menuDisabled:true,
                    renderer: function (value, metadata, record) {
                        var id=record.get('id');
                        var newvalue=value;
                        if(value==9999||value==999999)
                            newvalue='';
                        return "<input type='text'value='"+newvalue+"' class='row-edit-txt' onblur=\"updateField(this,'"+id+"','displayorder',0,'input')\"/>";
                    }
                },
                {
                    text: '供应商名称',
                    width: '10%',
                    dataIndex: 'suppliername',
                    align: 'left',
                    border: 0,
                    sortable: false,
                    menuDisabled:true,
                    renderer: function (value, metadata, record) {
                        return value;
                    }
                },
                {
                    text: '经营范围',
                    width: '14%',
                    dataIndex: 'authorization_h',
                    align: 'left',
                    border: 0,
                    sortable: false,
                    menuDisabled:true,
                    renderer: function (value, metadata, record) {
                        return  value;
                    }
                },
                {
                    text: '供应商类型',
                    width: '9%',
                    dataIndex: 'suppliertype',
                    align: 'center',
                    cls:'sort-col',
                    border: 0,
                    sortable: true,
                    menuDisabled:true,
                    renderer : function(value, metadata,record) {
                        if(value==0)
                            return "平台供应商";
                        if(value==1)
                            return "第三方供应商";
                    }
                },
                {
                    text: '是否认证',
                    width: '8%',
                    dataIndex: 'verifystatus',
                    align: 'center',
                    cls:'sort-col',
                    border: 0,
                    sortable: true,
                    menuDisabled:true,
                    renderer : function(value, metadata,record) {
                        var id=record.get('id');
                        var is_selected=" selected='selected' ";
                        var html ="<select onchange=\"updateField(this,"+id+",'verifystatus',0,'select')\" class='row-edit-select'>";
                        html+="<option value='0'" + (value==0?is_selected:'') + ">未认证</option>";
                        html+="<option value='1'" + (value==1?is_selected:'') + ">审核中</option>";
                        html+="<option value='2'" + (value==2?is_selected:'') + ">未通过</option>";
                        html+="<option value='3'" + (value==3?is_selected:'') + ">已认证</option>";
                        html+="</select>";
                        return html;
                    }
                },
                {
                    text: '联系人',
                    width: '10%',
                    dataIndex: 'linkman',
                    align: 'left',
                    border: 0,
                    sortable: false,
  menuDisabled:true,
                    renderer: function (value, metadata, record) {
                        return value;
                    }
                },
                {
                    text: '座机号码',
                    width: '10%',
                    dataIndex: 'telephone',
                    align: 'left',
                    border: 0,
                    sortable: false,
  menuDisabled:true,
                    renderer: function (value, metadata, record) {
                        return value;
                    }
                },
                {
                    text: '手机号码',
                    width: '10%',
                    dataIndex: 'mobile',
                    align: 'left',
                    border: 0,
                    sortable: false,
  menuDisabled:true,
                    renderer: function (value, metadata, record) {
                        return value;
                    }
                },
                {
                    text: 'Email',
                    width: '10%',
                    dataIndex: 'email',
                    align: 'left',
                    border: 0,
                    sortable: false,
  menuDisabled:true,
                    renderer: function (value, metadata, record) {
                        return value;
                    }
                },
               /* {
                    text: '地址',
                    width: '13%',
                    dataIndex: 'address',
                    align: 'left',
                    border: 0,
                    sortable: false,
  menuDisabled:true,
                    renderer: function (value, metadata, record) {
                        var id=record.get('id');
                        return  "<input type='text' value='"+value+"' style='text-align:left' class='row-edit-txt' onblur=\"updateField(this,'"+id+"','address',0,'input')\"/>";
                    }
                },*/
                {
                    text: '操作',
                    width: '9%',
                    align: 'center',
                    border: 0,
                    sortable: false,
  menuDisabled:true,
                    cls: 'mod-1',
                    renderer: function (value, metadata, record) {
                        var id = record.get('id');
                        var html = "<a href='javascript:void(0);' title='修改' class='btn-link' onclick=\"modify(" + id + ")\">编辑</a>"+
                                "&nbsp;&nbsp;&nbsp;<a href='javascript:void(0);' title='删除' class='btn-link' onclick=\"delS(" + id + ")\">删除</a>";
                        return html;
                        // return getExpandableImage(value, metadata,record);
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
                    } catch (e) {
                    }
                    var height = Ext.dom.Element.getViewportHeight();
                    // console.log(data_height+'---'+height);
                    if (data_height > height - 40) {
                        window.has_biged = true;
                        grid.height = height - 40;
                    }
                    else if (data_height < height - 40) {
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
    if (data_height > height - 40)
        window.product_grid.height = (height - 40);
    else
       // delete window.product_grid.height;
    window.product_grid.doLayout();
})
//按进行搜索
function searchKeyword() {
    var params={
        keyword : $.trim($("#searchkey").val()),
        kindid : $("select[name='kindid']").find("option:selected").val(),
        verifystatus : $("select[name='verifystatus']").find("option:selected").val(),
        authorization : $("select[name='authorization']").find("option:selected").val(),
        suppliertype : $("select[name='suppliertype']").find("option:selected").val()
    };
    window.product_store.getProxy().setExtraParam('keyword',params.keyword);
    window.product_store.getProxy().setExtraParam('kindid',params.kindid);
    window.product_store.getProxy().setExtraParam('verifystatus',params.verifystatus);
    window.product_store.getProxy().setExtraParam('authorization',params.authorization);
    window.product_store.getProxy().setExtraParam('suppliertype',params.suppliertype);
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
    console.log(record);
    if (type == 'select'||type=='input') {
        value = Ext.get(ele).getValue();
    }
    if (type == 'checkbox') {
        value = ele.checked ? 1 : 0;
    }
    var view_el = window.product_grid.getView().getEl();
    Ext.Ajax.request({
        url: SITEURL+"supplier/index/action/update",
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
                   // ST.Util.showMsg("<?php echo __('norightmsg');?>",5,1000);
            }
        }});
}
//删除套餐
function delS(id) {
    ST.Util.confirmBox("提示","确定删除？",function(){
            window.product_store.getById(id.toString()).destroy();
    })
}
//修改
function modify(id)
{
    var url=SITEURL+"supplier/edit/menuid/<?php echo $_GET['menuid'];?>/parentkey/member/itemid/3/id/"+id;
    ST.Util.addTab('修改供应商信息',url,1);
}
</script>
</body>
</html>
