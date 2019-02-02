<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>邮轮线路列表-笛卡CMS<?php echo $coreVersion;?></title>
 <?php echo  Stourweb_View::template('stourtravel/public/public_js');  ?>
   <?php echo Common::getCss('style.css,base.css,base2.css,plist.css,base_new.css'); ?>
   <?php echo Common::getCss('ext-theme-neptune-all-debug.css','js/extjs/resources/ext-theme-neptune/'); ?>
   <?php echo Common::getScript("uploadify/jquery.uploadify.min.js,jquery.buttonbox.js,choose.js"); ?>
   <?php echo Common::getCss('uploadify.css','js/uploadify/'); ?>
</head>
<body style="overflow:hidden">
<table class="content-tab" div_left=RaKzDt >
   <tr>
    <td width="119px" class="content-lt-td"  valign="top">
     <?php echo  Stourweb_View::template('stourtravel/public/leftnav');  ?>
    <!--右侧内容区-->
    </td>
    <td valign="top" class="content-rt-td" style="overflow:hidden">
    <div class="cfg-header-bar clearfix">
    <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
        <a href="javascript:;" id="addbtn" class="fr btn btn-primary radius mt-6 mr-10" >添加</a>               
    </div>
    
    <div class="cfg-search-bar" id="search_bar">
    <span class="cfg-select-box btnbox mt-3 ml-10" id="website" data-url="box/index/type/weblist" data-result="result_webid">站点切换&nbsp;&gt;&nbsp;<span id="result_webid">全部</span><i class="arrow-icon"></i></span>
    <span class="cfg-select-box btnbox mt-3 ml-10" id="startcity" data-url="box/index/type/startplace" data-result="result_startcity">出发地&nbsp;&gt;&nbsp;<span id="result_startcity">全部</span><i class="arrow-icon"></i></span>
    <span class="cfg-select-box btnbox mt-3 ml-10" id="destination" data-url="box/index/type/destlist" data-result="result_dest" >目的地&nbsp;&gt;&nbsp;<span id="result_dest">全部</span><i class="arrow-icon"></i></span>
    <span class="cfg-select-box btnbox mt-3 ml-10" id="attrlist" data-url="box/index/type/attrlist/typeid/104" data-result="result_attrlist" >属性&nbsp;&gt;&nbsp;<span id="result_attrlist">全部</span><i class="arrow-icon"></i></span>
    <div class="cfg-header-search">
    <input type="text" id="searchkey" placeholder="游轮线路名称/产品编号/供应商" datadef="游轮线路名称/产品编号/供应商" class="search-text">
        <a href="javascript:;" class="search-btn" onclick="CHOOSE.searchKeyword()">搜索</a>
    </div>
    <span class="cfg-search-tab display-mod fr">
<a href="javascript:void(0);" title="基本信息" class="item on" onClick="CHOOSE.togMod(this,1)">基本信息</a>
       <a href="javascript:void(0);" title="套餐" class="item" onClick="CHOOSE.togMod(this,2)">套餐</a>
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
            ST.Util.addTab('添加邮轮航线','<?php echo $cmsurl;?>ship/admin/shipline/add/<?php if(isset($_GET['menuid'])) { ?>menuid/<?php echo $_GET['menuid'];?>/<?php } ?>
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
             'themelist',
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
             'area',
             'num',
             'peoplenum'
         ],
         proxy:{
   type:'ajax',
   api: {
              read: SITEURL+'ship/admin/shipline/index/action/read',  //读取数据的URL
  update:SITEURL+'ship/admin/shipline/index/action/save',
  destroy:SITEURL+'ship/admin/shipline/index/action/delete'
              },
      reader:{
                type: 'json',   //获取数据的格式 
                root: 'lines',
                totalProperty: 'total'
                }
         },
 remoteSort:true, 
 pageSize:30,
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
bar.insert(0,Ext.create('Ext.panel.Panel',{border:0,html:'<div class="panel_bar"><a class="fl btn btn-primary radius mr-10" href="javascript:void(0);" onclick="CHOOSE.chooseAll()">全选</a><a class="fl btn btn-primary radius mr-10" href="javascript:void(0);" onclick="CHOOSE.chooseDiff()">反选</a><a class="fl btn btn-primary radius mr-10" href="javascript:void(0);" onclick="CHOOSE.delMore()">删除</a></div>'}));
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
                                            text: '专题',handler: function () {
                                            CHOOSE.setSome("设置专题", {loadCallback: setThemes}, SITEURL + 'theme/dialog_settheme?typeid=1');
                                            }
                                        },
                                        {
                                            text: '图标',handler: function () {
                                            CHOOSE.setSome("设置图标", {loadCallback: setIcons}, SITEURL + 'icon/dialog_seticon?typeid=1');
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
                                  return "<input type='text' value='"+newvalue+"' class='row-edit-txt' onblur=\"updateField(this,'"+id+"','displayorder',0,'input')\"/>";
 
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
   text:'航线名称',
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
                           return "<a href='"+url+"' class='line-title' target='_blank'>"+value+"&nbsp;&nbsp;"+iconname+"</a>";
                         else if(id.indexOf('suit')!=-1)
 {
    //metadata.tdAttr ="data-qtip='点击跳转到套餐设置页面'  data-qclass='dest-tip'";
   return "<a href='javascript:void(0);' class='suit-title'>&bull;&nbsp;&nbsp;"+value+"</a>";
 }
}
  
   }
   ,
               {
                   text: '报价有效期',
                   width: '8%',
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
                           return '<span>无套餐 </span>';
                       }
                       else
                       {
                           var str = id.indexOf('suit') == -1 ? '部分未报价' : '未报价';
                           return '<span style="color:red">' + str + '</span>';
                       }
                    }
               },
           {
               text:'舱房面积(m2)',
               width:'7%',
               align:'center',
               border:0,
               cls:'mod-2',
               dataIndex:'area',
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
               text:'可住人数',
               width:'7%',
               align:'center',
               border:0,
               cls:'mod-2',
               dataIndex:'peoplenum',
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
               text:'房间数',
               width:'7%',
               align:'center',
               border:0,
               cls:'mod-2',
               dataIndex:'num',
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
   text:'最低价格',
   width:'7%',
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
   width:'7%',
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
   width:'10%',
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
     return "<a href='javascript:;' class='btn-link' title='修改套餐'  onclick=\"ST.Util.addTab(\'修改套餐\',\'ship/admin/shipline/editsuit/<?php if(isset($_GET['menuid'])) { ?>menuid/<?php echo $_GET['menuid'];?>/<?php } ?>
parentkey/product/itemid/1/suitid/"+suitid+"\')\">修改套餐</a>";
                                      }
                                      else
                                      {
                                          //return '<a href="javascript:;" class="row-add-suit-btn" onclick="ST.Util.addTab(\'添加套餐\',\'line/addsuit/parentkey/product/itemid/1/lineid/'+id+'\')">添加套餐</a>';
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
   text:'供应商',
   width:'14%',
   align:'center',
   dataIndex:'suppliername',
   cls:'mod-3',
                   menuDisabled:true,
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
                   width:'14%',
                   align:'center',
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
   width:'7%',
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
   text:'专题',
   width:'7%',
   align:'center',
   sortable:true,
  dataIndex:'themelist',
  cls:'mod-1 sort-col',
                   menuDisabled:true,
   border:0,
  renderer : function(value, metadata,record) {
    
 var id=record.get('id');
 var d_text=value?'<span class="c-green">已设</span>':'<span class="c-999">未设</span>';
 return "<a href='javascript:void(0);' onclick=\"setOneThemes("+id+")\">"+d_text+"</a>";
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
   text:'显示',
   width:'7%',
  // xtype:'templatecolumn',
   align:'center',
   border:0,
   dataIndex:'ishidden',
   xtype:'actioncolumn',
                   menuDisabled:true,
                   cls: 'mod-1 sort-col',
           items:[
       {
        getClass: function(v, meta, rec) {          // Or return a class from a function
    if(v==0)
  return 'dest-status-ok';
else
  return 'dest-status-none';  
                    },
    handler:function(view,index,colindex,itm,e,record)
    {
   togStatus(null,record,'ishidden');
   
    }
      }
      ],
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
   text:'管理',
   width:'10%',
   align:'center',
   border:0,
   sortable:false,
                    menuDisabled:true,
   cls:'mod-1',
   renderer : function(value, metadata,record) {
                         var linename=record.get('title');
     var id=record.get('id');
 return "<a href='javascript:void(0);' title='编辑' class='btn-link' onclick=\"goModify("+id+")\">编辑</a>";
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

 
//更新某个字段
  function updateField(ele,id,field,value,type,callback)
  {
  var record=window.product_store.getById(id.toString());
  if(type=='select'||type=='input')
  {
  value=Ext.get(ele).getValue();
  }
  Ext.Ajax.request({
 url   : SITEURL+ "ship/admin/shipline/index/action/update",
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
 url   :  SITEURL+"ship/admin/shipline/index/action/update",
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
      var record = window.product_store.getById(lineid.toString());
      var title = record.get('title');
      parent.window.addTab('修改-'+title,SITEURL+'ship/admin/shipline/edit/lineid/'+lineid+'/<?php if(isset($_GET['menuid'])) { ?>menuid/<?php echo $_GET['menuid'];?>/<?php } ?>
parentkey/product/itemid/<?php echo $itemid;?>',1);
  }
  //设置多个线路的目的地
  function setDests(result,bool)
  {
      console.log(result);
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
  function setThemes(result,bool)
  {
      if(!bool)
          return;
      var ids=[];
      var names=[];
      for(var i in result.data)
      {
          var row=result.data[i];
          ids.push(row['id']);
          names.push(row['ztname']);
      }
      var idsStr=ids.join(',');
      var nameStr=names.join(',');
      if(result.id)
      {
          updateField(null,result.id,'themelist',idsStr,0);
          return;
      }
      $(".product_check:checked").each(function(index,element){
          var id=$(element).val();
          updateField(null,id,'themelist',idsStr,0,function(record){
            //  var id=record.get('id');
             // $("#box_"+id).attr("checked",true);
          });
      });
  }
  function setOneDests(id)
  {
      CHOOSE.setSome("设置目的地",{loadCallback:setDests,maxHeight:500},SITEURL+'destination/dialog_setdest?typeid=104&id='+id,true);
  }
  function setOneIcons(id)
  {
      CHOOSE.setSome("设置图标",{loadCallback:setIcons},SITEURL+'icon/dialog_seticon?typeid=104&id='+id,true);
  }
  function setOneAttrids(id)
  {
      CHOOSE.setSome("设置属性",{loadCallback:setAttrids},SITEURL+'attrid/dialog_setattrid?typeid=104&id='+id,true);
  }
  function setOneThemes(id)
  {
      CHOOSE.setSome("设置专题",{loadCallback:setThemes},SITEURL+'theme/dialog_settheme?typeid=104&id='+id,true);
  }
</script>
</body>
</html>
