<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>产品列表-笛卡CMS<?php echo $coreVersion;?></title>
    <?php echo  Stourweb_View::template('stourtravel/public/public_js');  ?>
    <?php echo Common::getCss('style.css,base.css,base2.css,plist.css,base_new.css'); ?>
    <?php echo Common::getScript("uploadify/jquery.uploadify.min.js,jquery.buttonbox.js,choose.js"); ?>
    <?php echo Common::getCss('uploadify.css','js/uploadify/'); ?>
</head>
<body style="overflow:hidden">
    <table class="content-tab">
        <tr>
            <td width="119px" class="content-lt-td"  valign="top">
                <?php echo  Stourweb_View::template('stourtravel/public/leftnav');  ?>
                <!--右侧内容区-->
            </td>
            <td valign="top" class="content-rt-td" style="overflow:hidden">
                <div class="cfg-header-bar clearfix">
                    <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
                    <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" id="addbtn">添加</a>
                </div>
                <div class="cfg-search-bar" id="search_bar">
                    <span class="cfg-select-box btnbox mt-3 ml-10" id="website" data-url="box/index/type/weblist" data-result="result_webid">站点切换&nbsp;&gt;&nbsp;<span id="result_webid">全部</span><i class="arrow-icon"></i></span>
                    <span class="cfg-select-box btnbox mt-3 ml-10" id="startcity" data-url="box/index/type/startplace" data-result="result_startcity">出发地&nbsp;&gt;&nbsp;<span id="result_startcity">全部</span><i class="arrow-icon"></i></span>
                    <span class="cfg-select-box btnbox mt-3 ml-10" id="destination" data-url="box/index/type/destlist" data-result="result_dest" >目的地&nbsp;&gt;&nbsp;<span id="result_dest">全部</span><i class="arrow-icon"></i></span>
                    <span class="cfg-select-box btnbox mt-3 ml-10" id="attrlist" data-url="box/index/type/attrlist/typeid/1" data-result="result_attrlist" >属性&nbsp;&gt;&nbsp;<span id="result_attrlist">全部</span><i class="arrow-icon"></i></span>
                    <div class="cfg-header-search">
                        <input type="text" id="searchkey" placeholder="名称/编号/供应商" datadef="名称/编号/供应商" class="search-text">
                        <a href="javascript:;" class="search-btn" onclick="CHOOSE.searchKeyword()">搜索</a>
                    </div>
                    <span class="cfg-search-tab display-mod fr">
                        <a href="javascript:void(0);" title="基本信息" class="item on" onClick="CHOOSE.togMod(this,1)">产品</a>
                        <a href="javascript:void(0);" title="套餐" class="item" onClick="CHOOSE.togMod(this,2)">报价</a>
                        <a href="javascript:void(0);" title="供应商" class="item" onClick="CHOOSE.togMod(this,3)">供应商</a>
                    </span>
                </div>
                <div id="product_grid_panel" class="content-nrt">
                </div>
            </td>
        </tr>
    </table>
<script>
   window.display_mode=1;
  Ext.onReady(
    function() 
    {
 Ext.tip.QuickTipManager.init();
        $(".btnbox").buttonBox();
        $("#searchkey").focusEffect();
        //添加按钮
        $("#addbtn").click(function(){
            ST.Util.addTab('添加线路',SITEURL+'line/admin/line/add/<?php if(isset($_GET['menuid'])) { ?>menuid/<?php echo $_GET['menuid'];?>/<?php } ?>
parentkey/product/itemid/1',0);
        });
//线路store
        window.product_store=Ext.create('Ext.data.Store',{
 fields:[
             'id',
             'aid',
             'webid',
             'title',
             'lineseries',
     'kindlist',
             'kindname',
             'starttime',
             'endtime',
             'attrid',
             'attrname',
             'tprice',
             'profit',
             'price',
             'isjian',
             'istejia',
             'addtime',
             'modtime',
             'displayorder',
             'ishidden',
             'suit',
             'jifentprice',
             'jifencomment',
             'jifenbook',
             'propgroup',
             'minprice',
             'minprofit',
             'tr_class',
             'iconlist',
             'iconname',
             'suppliername',
             'linkman',
             'mobile',
             'qq',
             'address',
             'url',
             'suitday',
             'finaldestid',
             'finaldestname',
             'status'
         ],
         proxy:{
   type:'ajax',
   api: {
              read: SITEURL+'line/admin/line/line/action/read',  //读取数据的URL
  update:SITEURL+'line/admin/line/line/action/save',
  destroy:SITEURL+'line/admin/line/line/action/delete'
              },
      reader:{
                type: 'json',   //获取数据的格式 
                root: 'lines',
                totalProperty: 'total'
                }
         },
 remoteSort:true,
            pageSize:20,
         autoLoad:true,
 listeners: {
             load: function (store, records, successful, eOpts) {
                 if (!successful) {
                     ST.Util.showMsg("<?php echo __('norightmsg');?>", 5, 1000);
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
  value:20,
  store:{fields:['num'],data:[{num:20},{num:40},{num:60}]},
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
bar.insert(0,Ext.create('Ext.panel.Panel',{border:0,html:'<div class="panel_bar"><a class="btn btn-primary radius" href="javascript:void(0);" onclick="CHOOSE.chooseAll()">全选</a><a class="btn btn-primary radius ml-10" href="javascript:void(0);" onclick="CHOOSE.chooseDiff()">反选</a><a class="btn btn-primary radius ml-10" href="javascript:void(0);" onclick="CHOOSE.delMore()">删除</a></div>'}));
bar.insert(1,Ext.create('Ext.panel.Panel',{border:0,items:[{
                                xtype: 'button',
                                cls:'my-extjs-btn',
                                text: '批量设置',
                                menu: {
                                    cls:'menu-no-icon',
                                    width:"82px",
                                    shadow:false,
                                    items:[
                                        {
                                            text: '目的地',handler: function () {
                                                CHOOSE.setSome("设置目的地", {
                                                    loadCallback: setDests,
                                                    maxHeight: 500
                                                }, SITEURL + 'destination/dialog_setdest');
                                            }
                                        },
                                        {
                                            text: '属性',handler: function () {
                                            CHOOSE.setSome("设置属性", {loadCallback: setAttrids}, SITEURL + 'attrid/dialog_setattrid?typeid=1');
                                         }
                                        },
                                        {
                                            text: '图标',handler: function () {
                                            CHOOSE.setSome("设置图标", {loadCallback: setIcons}, SITEURL + 'icon/dialog_seticon_new?typeid=1');
                                          }
                                        }
                                    ]
                              }

}]}));
bar.insert(2,Ext.create('Ext.toolbar.Fill'));
//items.add(Ext.create('Ext.toolbar.Fill'));
}
}
                 }),   
   columns:[
   {
   text:'选择',
   width:'6%',
  // xtype:'templatecolumn',
   tdCls:'line-ch',
   align:'center',
   dataIndex:'id',
                   menuDisabled:true,
                   sortable:false,
   border:0,
   renderer : function(value, metadata,record) {
    id=record.get('id');
    if(id.indexOf('suit')==-1)
    return  "<input type='checkbox' class='product_check' style='cursor:pointer' id='box_"+value+"' value='"+value+"'/>";
 
}
  
   },
   {
   text:'排序',
   width:'6%',
   dataIndex:'displayorder',
                   tdCls:'line-order',
   id:'column_lineorder',
   align:'center',
                   menuDisabled:true,
                   cls:'sort-col',
   border:0,
   renderer : function(value, metadata,record) {
              var id=record.get('id'); 
   if(id.indexOf('suit')!=-1)
        metadata.tdAttr ="data-qtip='指同一条线路下套餐的显示顺序'"+"data-qclass='dest-tip'";
                                  var newvalue=value;
  if(value==9999||value==999999)
       newvalue='';
                                  return "<input type='text' onkeyup=\"if(this.value.length==1){this.value=this.value.replace(/[^0-9]/g,'')}else{this.value=this.value.replace(/\\D/g,'')}\" onafterpaste=\"if(this.value.length==1){this.value=this.value.replace(/[^0-9]/g,'0')}else{this.value=this.value.replace(/\\D/g,'')}\" value='"+newvalue+"' class='row-edit-txt' onblur=\"updateField(this,'"+id+"','displayorder',0,'input')\"/>";
 
},
                   listeners:{
                       afterrender:function(obj,eopts)
                       {
                           if(window.display_mode==3 )
                               obj.hide();
                           else
                               obj.show();
                       }
                   }
  
   },
               {
                   text:'编号',
                   width:'6%',
                   dataIndex:'lineseries',
                   align:'center',
                   id:'column_lineseries',
                   menuDisabled:true,
                   border:0,
                   sortable:false,
                   renderer : function(value, metadata,record) {
                       return '<span>'+value+'</span>';
                   }
               },
   {
   text:'产品名称',
   width:'30%',
   dataIndex:'title',
   align:'left',
   id:'column_linename',
                   menuDisabled:true,
   border:0,
   sortable:false,
   renderer : function(value, metadata,record) {
  //  return  "<input type='checkbox' class='product_check' value='"+value+"'/>"; 

                         var aid=record.get('aid');
 var id=record.get('id');
                                     var iconname = record.get('iconname');
                                     var url=record.get('url');
 
 if(!isNaN(id))
                           return "<a href='"+url+"' target='_blank'>"+value+"&nbsp;&nbsp;"+iconname+"</a>";
                         else if(id.indexOf('suit')!=-1)
 {
    //metadata.tdAttr ="data-qtip='点击跳转到套餐设置页面'  data-qclass='dest-tip'";
   return "<a href='javascript:void(0);' class='suit-title'>&bull;&nbsp;&nbsp;"+value+"</a>";
 }
}
  
   }
   ,
               {
                   text: '报价有效期'+ST.Util.getGridHelp('line_validity'),
                   width: '12%',
                   align: 'center',
                   dataIndex:'suitday',
                   border: 0,
                   menuDisabled:true,
                   cls: 'mod-1 sort-col',
                   sortable: true,
                   renderer: function (value, metadata, record) {
                       //  return  "<input type='checkbox' class='product_check' value='"+value+"'/>";
                       var curdate=new Date();
                       var id=record.get('id');
                       var curtimestamp=curdate.getTime();
                      var date=new Date(value*1000);
                       if(value && value>0) {
                           var color=value*1000<curtimestamp?'red':'green';
                           return '<span style="color:'+color+'">' + Ext.Date.format(date, 'Y-m-d') + '</span>';
                       }
                       else if(value==-1) {
                           return '<span class="c-999">无套餐 </span>';
                       }
                       else
                       {
                           var str = id.indexOf('suit') == -1 ? '部分未报价' : '未报价';
                           return '<span style="color:red">' + str + '</span>';
                       }
                     }
               },
    {
   text:'最低价格',
   width:'13%',
   align:'center',
   border:0,
   cls:'mod-2',
   dataIndex:'minprice',
   sortable:false,
                    menuDisabled:true,
   listeners:{
    afterrender:function(obj,eopts)
{
if(window.display_mode!=2)
    obj.hide();
                            else
                                obj.show();
    }
}  
},
    {
   text:'最低利润',
   width:'13%',
   align:'center',
   dataIndex:'minprofit',
                    menuDisabled:true,
   border:0,
   cls:'mod-2',
   sortable:false,
   listeners:{
    afterrender:function(obj,eopts)
{
if(window.display_mode!=2)
    obj.hide();
                            else
                                obj.show();
    }
}  
},
               {
   text:'管理',
   width:'19%',
   align:'center',
   border:0,
   cls:'mod-2',
   sortable:false,
                   menuDisabled:true,
   renderer : function(value, metadata,record) {
  //  return  "<input type='checkbox' class='product_check' value='"+value+"'/>"; 

                         var aid=record.get('aid');
 var id=record.get('id');
                                     var name=record.get('title');
                          if(id.indexOf('suit')!=-1)
                                      {
                                         var suitid=id.slice(id.indexOf('_')+1);
     return "<a href='javascript:;' class='btn-link' title='编辑套餐'  onclick=\"modify_suit('"+id+"')\">编辑</a>&nbsp;&nbsp;<a href='javascript:void(0);' title='删除' class='btn-link' onclick=\"delSuit('"+id+"')\">删除</a>";
                                      }
                                      else
                                      {
                                          return '<a href="javascript:;" class="btn-link" onclick="ST.Util.addTab(\'添加套餐\',\'line/admin/line/addsuit/<?php if(isset($_GET['menuid'])) { ?>menuid/<?php echo $_GET['menuid'];?>/<?php } ?>
parentkey/product/itemid/1/lineid/'+id+'\')">添加套餐</a>';
                                      }
}, 
   listeners:{
    afterrender:function(obj,eopts)
{
if(window.display_mode!=2)
    obj.hide();
                            else
                                obj.show();
    }
}  

}
    ,
   {
   text:'供应商'+ST.Util.getGridHelp('product_supplier'),
   width:'10%',
   align:'center',
   dataIndex:'suppliername',
   cls:'mod-3',
                   menuDisabled:true,
   border:0,
                   align:'left',
   sortable:false,
                   renderer:function (value, metadata,record) {
                       return (value==''||value==null||value==undefined?'平台自营':value);
                   },
listeners:{
    afterrender:function(obj,eopts)
{
if(window.display_mode!=3)
    obj.hide();
                            else
                                obj.show();
    }
}
   
   },
               {
                   text:'联系人',
                   width:'7%',
                   align:'center',
                   dataIndex:'linkman',
                   cls:'mod-3',
                   menuDisabled:true,
                   border:0,
                   sortable:false,
                   listeners:{
                       afterrender:function(obj,eopts)
                       {
                           if(window.display_mode!=3)
                               obj.hide();
                           else
                               obj.show();
                       }
                   }
               },
   {
   text:'联系电话',
   width:'9%',
   align:'center',
   dataIndex:'mobile',
   cls:'mod-3',
                   menuDisabled:true,
   border:0,
   sortable:false,
listeners:{
    afterrender:function(obj,eopts)
{
if(window.display_mode!=3)
    obj.hide();
                            else
                                obj.show();
    }
}
   
   },
               {
                   text:'QQ',
                   width:'8%',
                   align:'center',
                   dataIndex:'qq',
                   menuDisabled:true,
                   cls:'mod-3',
                   border:0,
                   sortable:false,
                   listeners:{
                       afterrender:function(obj,eopts)
                       {
                           if(window.display_mode!=3)
                               obj.hide();
                           else
                               obj.show();
                       }
                   }
               },
               {
                   text:'地址',
                   width:'17%',
                   dataIndex:'address',
                   menuDisabled:true,
                   cls:'mod-3',
                   border:0,
                   align:'left',
                   sortable:false,
                   listeners:{
                       afterrender:function(obj,eopts)
                       {
                           if(window.display_mode!=3)
                               obj.hide();
                           else
                               obj.show();
                       }
                   }
               },
   {
   text:'目的地',
   width:'10%',
   dataIndex:'kindlist',
   align:'center',
                   menuDisabled:true,
    cls:'mod-1 sort-col',
   sortable:true,
   renderer : function(value, metadata,record) {
     var kindname=record.get('kindname');
                          var finaldestname=record.get('finaldestname');
 if(kindname) {
                             kindname=kindname.replace(finaldestname,'<font color="red">'+finaldestname+'</font>');
                             metadata.tdAttr = "data-qtip='" + kindname + "'" + "data-qclass='dest-tip'";
                         }
 var id=record.get('id');
 var d_text=value?'<span class="c-green">已设</span>':'<span class="c-999">未设</span>';

 return "<a href='javascript:void(0);' onclick=\"setOneDests("+id+")\">"+d_text+"</a>";
                                   // return getExpandableImage(value, metadata,record);
                    },
 listeners:{
    afterrender:function(obj,eopts)
{
if(window.display_mode!=1)
    obj.hide();
                            else
                                obj.show();
    }
}
  
   },
   {
 text:'图标',
   width:'7%',
   align:'center',
   dataIndex:'iconlist',
                   menuDisabled:true,
   border:0,
   cls:'mod-1 sort-col',
   sortable:true,
   renderer : function(value, metadata,record) {
     var id=record.get('id');
 var d_text=value?'<span class="c-green">已设</span>':'<span class="c-999">未设</span>';
 return "<a href='javascript:void(0);' onclick=\"setOneIcons("+id+")\">"+d_text+"</a>";
                                   // return getExpandableImage(value, metadata,record);
                    },
 listeners:{
    afterrender:function(obj,eopts)
{
if(window.display_mode!=1)
    obj.hide();
                            else
                                obj.show();
    }
}
 
  
   },
   {
   text:'属性',
   width:'7%',
   align:'center',
   dataIndex:'attrid',
                   menuDisabled:true,
   border:0,
   sortable:true,
   cls:'mod-1 sort-col',
   renderer : function(value, metadata,record) {
     var attrname=record.get('attrname');
 if(attrname)
 metadata.tdAttr ="data-qtip='"+attrname+"'data-qclass='dest-tip'";
 var id=record.get('id');
 var d_text=value?'<span class="c-green">已设</span>':'<span class="c-999">未设</span>';
 return "<a href='javascript:void(0);' onclick=\"setOneAttrids("+id+")\">"+d_text+"</a>";
                                   // return getExpandableImage(value, metadata,record);
                    },
 listeners:{
    afterrender:function(obj,eopts)
{
if(window.display_mode!=1)
    obj.hide();
                            else
                                obj.show();
    }
}
   },
   {
   text:'上/下架',
   width:'8%',
  // xtype:'templatecolumn',
   align:'center',
   border:0,
   dataIndex:'status',
   xtype:'actioncolumn',
                   menuDisabled:true,
                   cls: 'mod-1 sort-col',
                   renderer : function(value, metadata,record) {
                       var id = record.get('id');
                       if(value==1) {
                           return '<img title="审核中" alt="审核中" onclick="supplierCheckBox('+id+')" role="button" ' +
                               ' src="data:image/gif;base64,R0lGODlhAQABAID/AMDAwAAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" ' +
                               'class="x-action-col-icon x-action-col-0 dest-status-wait">'
                       }
                       if(value==3) {
                           return '<img title="上架" alt="上架" onclick="updateField(null,'+id+',\'status\',2)" role="button" ' +
                               ' src="data:image/gif;base64,R0lGODlhAQABAID/AMDAwAAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" ' +
                               'class="x-action-col-icon x-action-col-0 dest-status-ok">'
                       }
                       if(value==2){
                           return '<img title="下架" alt="下架" onclick="updateField(null,'+id+',\'status\',3)" role="button" ' +
                           ' src="data:image/gif;base64,R0lGODlhAQABAID/AMDAwAAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" ' +
                           'class="x-action-col-icon x-action-col-0 dest-status-none">'
                       }
                   },
   listeners:{
    afterrender:function(obj,eopts)
{
if(window.display_mode!=1)
    obj.hide();
                            else
                                obj.show();
    }
}
  
  
   },
    {
   text:'管理'+ST.Util.getGridHelp('line_manage'),
   width:'10%',
   align:'center',
   border:0,
   sortable:false,
                    menuDisabled:true,
   cls:'mod-1',
   renderer : function(value, metadata,record) {
                         var linename=record.get('title');
     var id=record.get('id');
                         var status = record.get('status');
 var html =  "<a href='javascript:void(0);' title='编辑' class='btn-link' onclick=\"goModify("+id+")\">编辑</a>"
                                 if(status==2 || status == 3)
                                 {
                                    html  += "&nbsp;&nbsp;<a href='javascript:void(0);' title='克隆' class='btn-link' onclick=\"ST.Util.goClone("+id+",'line/admin/line')\">克隆</a>";
                                 }
                         return html;
                    },
 listeners:{
    afterrender:function(obj,eopts)
{
if(window.display_mode!=1)
    obj.hide();
                            else
                                obj.show();
    }
} 
  
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

            if(window.line_kindname)
{
 Ext.getCmp('column_lineorder').setText(window.line_kindname+'-排序')
}
else
    {
Ext.getCmp('column_lineorder').setText('排序')
}

window.product_store.each(function(record){
        id=record.get('id');
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
 }

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
   //供应商审核
   function supplierCheckBox(id)
   {
       ST.Util.showBox("审核",SITEURL+'line/admin/line/dialog_supplier_check?id='+id,500,'',null,null,document,{loadWindow: window, loadCallback: setSupplierCheck});
   }
   //执行审核
   function setSupplierCheck(result,bool)
   {
       console.log(result);
       Ext.Ajax.request({
           url   :  SITEURL+"line/admin/line/dialog_supplier_check",
           method  :  "get",
           datatype  :  "JSON",
           params:{id:result.id,action:'save',status:result.data.status,refuse_msg:result.data.refuse_msg},
           success  :  function(response, opts)
           {
               if(response.responseText=='ok')
               {
                   window.product_store.reload();
               }
           }});
   }
 
//更新某个字段
  function updateField(ele,id,field,value,type,callback)
  {
  var record=window.product_store.getById(id.toString());
  if(type=='select'||type=='input')
  {
  value=Ext.get(ele).getValue();
  }
  Ext.Ajax.request({
 url   :  SITEURL+"line/admin/line/line/action/update",
 method  :  "POST",
 datatype  :  "JSON",
 params:{id:id,field:field,val:value,kindid:window.product_kindid},
 success  :  function(response, opts) 
 {
 if(response.responseText=='ok')
{
   var view_el=window.product_grid.getView().getEl()
                         //  var scroll_top=view_el.getScrollTop();
   record.set(field,value);
   record.commit(); 
                               if(typeof(callback)=='function')
                               {
                                   callback(record);
                               }
 }
                             else
                             {
                                ST.Utils.showMsg("<?php echo __('norightmsg');?>",5,1000);
                             }
 }});
  }
  //切换显示或隐藏
   function togStatus(obj,record,field)
  {
       var val=record.get(field);
       var id=record.get('id');
   var newval=val==1?0:1;
   Ext.Ajax.request({
 url   :  SITEURL+"line/admin/line/line/action/update",
 method  :  "POST",
 datatype  :  "JSON",
 params:{id:id,field:field,val:newval},
 success  :  function(response, opts) 
 {
 if(response.responseText=='ok')
{
var view_el=window.product_grid.getView().getEl()
                            var scroll_top=view_el.getScrollTop();
   record.set(field,newval);
   record.commit();
    view_el.scrollBy(0,scroll_top,false);
 }
 }});
 
  }
  //删除套餐
  function delSuit(id)
  {
 ST.Util.confirmBox("提示","确定删除这个套餐？",function(){
         window.product_store.getById(id).destroy();
  })
  }
  //修改
  function goModify(lineid)
  {
      var record=window.product_store.getById(lineid.toString());
      var title = record.get('title');
      parent.window.addTab('修改-'+title,SITEURL+'line/admin/line/edit/lineid/'+lineid+'/<?php if(isset($_GET['menuid'])) { ?>menuid/<?php echo $_GET['menuid'];?>/<?php } ?>
parentkey/product/itemid/1',1);
  }
  //修改套餐
  function modify_suit(id)
  {
      var record=window.product_store.getById(id.toString());
      var title = record.get('title');
      var suitid=id.slice(id.indexOf('_')+1);
      ST.Util.addTab('修改-'+title,'line/admin/line/editsuit/<?php if(isset($_GET['menuid'])) { ?>menuid/<?php echo $_GET['menuid'];?>/<?php } ?>
parentkey/product/itemid/1/suitid/'+suitid);
  }
  //设置多个线路的目的地
  function setDests(result,bool)
  {
      if(!bool)
         return;
      var ids=[];
      var destNames=[];
      for(var i in result.data)
      {
          var arr=result.data;
          ids.push(arr[i]['id']);
          destNames.push(arr[i]['kindname']);
      }
      var idsStr=ids.join(',');
      var destNamesStr=destNames.join(',');
      if(result.id)
      {
          if(result.finalDest) {
              updateField(null, result.id, 'finaldestid', result.finalDest.id, 0, function (record) {
                  record.set('finaldestname', result.finalDest.kindname);
                  record.commit();
              });
          }
          updateField(null,result.id,'kindlist',idsStr,0,function(record){
          record.set('kindname',destNamesStr);
          record.commit();
         // var id=record.get('id');
         // $("#box_"+id).attr("checked",true);
        });
          return;
      }
      $(".product_check:checked").each(function(index,element){
            var id=$(element).val();
            updateField(null,id,'kindlist',idsStr,0,function(record){
                record.set('kindname',destNamesStr);
                record.commit();
              //  var id=record.get('id');
               // $("#box_"+id).attr("checked",true);
            });
      });
  }
   //设置属性
  function setAttrids(result,bool)
  {
      if(!bool)
        return;
      var ids=[];
      var names=[];
      for(var i in result.data)
      {
          var arr=result.data;
          ids.push(arr[i]['id']);
          names.push(arr[i]['attrname']);
      }
      var idsStr=ids.join(',');
      var nameStr=names.join(',');
      if(result.id)
      {
          updateField(null,result.id,'attrid',idsStr,0,function(record){
               record.set('attrname',nameStr);
               record.commit();
             // var id=record.get('id');
             // $("#box_"+id).attr("checked",true);
          });
          return;
      }
      $(".product_check:checked").each(function(index,element){
          var id=$(element).val();
          updateField(null,id,'attrid',idsStr,0,function(record){
              record.set('attrname',nameStr);
              record.commit();
             // var id=record.get('id');
             // $("#box_"+id).attr("checked",true);
          });
      });
  }
  function setIcons(result,bool)
  {
      if(!bool)
        return;
      var ids=[];
      for(var i in result.data)
      {
          var oneId=result.data[i]['id'];
          ids.push(oneId);
      }
      var idsStr=ids.join(',');
      if(result.id)
      {
          updateField(null,result.id,'iconlist',idsStr,0);
          return;
      }
      $(".product_check:checked").each(function(index,element){
          var id=$(element).val();
          updateField(null,id,'iconlist',idsStr,0,function(record){
             // var id=record.get('id');
             // $("#box_"+id).attr("checked",true);
          });
      });
  }
  function setOneDests(id)
  {
      CHOOSE.setSome("设置目的地",{loadCallback:setDests,maxHeight:500},SITEURL+'destination/dialog_setdest?typeid=1&id='+id,true);
  }
  function setOneIcons(id)
  {
      CHOOSE.setSome("设置图标",{loadCallback:setIcons,maxHeight:500},SITEURL+'icon/dialog_seticon_new?typeid=1&id='+id,true);
  }
  function setOneAttrids(id)
  {
      CHOOSE.setSome("设置属性",{loadCallback:setAttrids},SITEURL+'attrid/dialog_setattrid?typeid=1&id='+id,true);
  }
</script>
</body>
</html>
