<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>笛卡CMS<?php echo $coreVersion;?></title>
   <?php echo  Stourweb_View::template('stourtravel/public/public_js');  ?>
   <?php echo Common::getCss('style.css,base.css,base2.css,plist.css,base_new.css'); ?>
   <?php echo Common::getScript("uploadify/jquery.uploadify.min.js,jquery.buttonbox.js,choose.js"); ?>
   <?php echo Common::getCss('uploadify.css','js/uploadify/'); ?>
</head>
<body style="overflow:hidden">
<table class="content-tab" html_size=YMM8Zk >
   <tr>
    <td width="119px" class="content-lt-td"  valign="top">
     <?php echo  Stourweb_View::template('stourtravel/public/leftnav');  ?>
    <!--右侧内容区-->
    </td>
    <td valign="top" class="content-rt-td" style="overflow:hidden">
<div class="cfg-header-bar">
           <?php $n=1; if(is_array($kindmenu)) { foreach($kindmenu as $menu) { ?>
           <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="ST.Util.addTab('<?php echo $menu['name'];?>','<?php echo $menu['url'];?>',1);"><?php echo $menu['name'];?></a>
           <?php $n++;}unset($n); } ?>
           <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
           <a href="javascript:;" id="addbtn" class="fr btn btn-primary radius mt-6 mr-10" >添加</a>       
</div>
 
<div class="cfg-search-bar" id="search_bar">
<span class="cfg-select-box btnbox mt-3 ml-10" id="website" data-url="box/index/type/weblist" data-result="result_webid">站点切换&nbsp;&gt;&nbsp;<span id="result_webid">全部</span><i class="arrow-icon"></i></span>
<span class="cfg-select-box btnbox mt-3 ml-10" id="destination" data-url="box/index/type/destlist" data-result="result_dest" >目的地&nbsp;&gt;&nbsp;<span id="result_dest">全部</span><i class="arrow-icon"></i></span>
<span class="cfg-select-box btnbox mt-3 ml-10" id="attrlist" data-url="box/index/type/attrlist/typeid/2" data-result="result_attrlist" >属性&nbsp;&gt;&nbsp;<span id="result_attrlist">全部</span><i class="arrow-icon"></i></span>
<div class="cfg-header-search">
<input type="text" id="searchkey" placeholder="酒店名称/酒店编号" datadef="酒店名称/酒店编号" class="search-text">
                <a href="javascript:;" class="search-btn" onclick="CHOOSE.searchKeyword()">搜索</a>
</div>
<span class="cfg-search-tab display-mod fr">
<a href="javascript:void(0);" title="基本信息" class="item on" onClick="CHOOSE.togMod(this,1)">基本信息</a>
<a href="javascript:void(0);" title="套餐" class="item" onClick="CHOOSE.togMod(this,2)">套餐</a>
<a href="javascript:void(0);" title="供应商" class="item" onClick="CHOOSE.togMod(this,3)">供应商</a>
</span>
</div>
        
        <div id="product_grid_panel" class="content-nrt"></div>
  </td>
  </tr>
 </table> 
<script>
    <?php
 echo  'window.rankmenu='.json_encode(Model_Hotel_Rank::get_list()).';';
 ?>
   window.display_mode=1;//默认显示模式
   window.product_kindid=0;  //默认目的地ID
  // window.kindmenu = <?php echo $kindmenu;?>;//分类设置菜单
  Ext.onReady(
    function() 
    {
 Ext.tip.QuickTipManager.init();
        $(".btnbox").buttonBox();
        $("#searchkey").focusEffect();
        //添加按钮
        $("#addbtn").click(function(){
            ST.Util.addTab('添加酒店',SITEURL+'hotel/admin/hotel/add/<?php if(isset($_GET['menuid'])) { ?>menuid/<?php echo $_GET['menuid'];?>/<?php } ?>
parentkey/product/itemid/2',0);
        });
//产品store
        window.product_store=Ext.create('Ext.data.Store',{
 fields:[
             'id',
             'aid',
             'webid',
             'title',
             'series',
             'hotelrankid',
             'telephone',
             'hotelkind',
             'fuwu',
             'shownum',
             'kindlist',
             'attrid',
             'ishidden',
             'displayorder',
             'kindname',
             'iconlist',
             'attrname',
             'themelist',
             'tr_class',
             'price',
             'jifentprice',
             'jifencomment',
             'jifenbook',
             'hotelid',
             'roomid',
             'roomarea',
             'roomstyle',
             'computer',
             'iconlist',
             'iconname',
             'suppliername',
             'linkman',
             'mobile',
             'qq',
             'address',
             'suitday',
             'url',
             'finaldestid',
             'finaldestname'
         ],
         proxy:{
   type:'ajax',
   api: {
              read: SITEURL+'hotel/admin/hotel/hotel/action/read/',  //读取数据的URL
  update:SITEURL+'hotel/admin/hotel/action/save',
  destroy:SITEURL+'hotel/admin/hotel/hotel/action/delete'
              },
      reader:{
                type: 'json',   //获取数据的格式
                root: 'lists',
                totalProperty: 'total'
              }
         },
 remoteSort:true,
 pageSize:20,
         autoLoad:true,
 listeners:{
             load:function( store, records, successful, eOpts )
             {
                 if(!successful){
                     ST.Util.showMsg("<?php echo __('norightmsg');?>",5,1000);
                 }
                 var pageHtml=ST.Util.page(store.pageSize,store.currentPage,store.getTotalCount(),10);
                 $("#line_page").html(pageHtml);
                 product_grid.doLayout();
                 $(document).on('click',".pageContainer .pagePart a",function(){
                     var page=$(this).attr('page');
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
   width:"100%",
   bodyBorder:0,
   bodyStyle:'border-width:0px',
       scroll:'vertical', //只要垂直滚动条
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
bar.insert(0,Ext.create('Ext.panel.Panel',{border:0,html:'<div class="panel_bar"><a class="fl btn btn-primary radius mr-10" href="javascript:void(0);" onclick="CHOOSE.chooseAll()">全选</a><a class="fl btn btn-primary radius mr-10" href="javascript:void(0);" onclick="CHOOSE.chooseDiff()">反选</a><a class="fl btn btn-primary radius mr-10" href="javascript:void(0);" onclick="CHOOSE.delMore()">删除</a></div>'}));
bar.insert(1,Ext.create('Ext.panel.Panel',{border:0,items:[{
 xtype:'button',
                                 cls:'my-extjs-btn',
 text:'批量设置',
 menu: {
                                     cls:'menu-no-icon',
                                     width:"82px",
                                     shadow:false,
                                     items:[
                                     {
                                         text: '目的地', handler: function () {
                                         CHOOSE.setSome("设置目的地", {
                                             loadCallback: setDests,
                                             maxHeight: 500
                                         }, SITEURL + 'destination/dialog_setdest');
                                     }
                                     },
                                     {
                                         text: '属性', handler: function () {
                                         CHOOSE.setSome("设置属性", {loadCallback: setAttrids}, SITEURL + 'attrid/dialog_setattrid?typeid=2');
                                     }
                                     },
                                     {
                                         text: '专题', handler: function () {
                                         CHOOSE.setSome("设置专题", {loadCallback: setThemes}, SITEURL + 'theme/dialog_settheme?typeid=2');
                                     }
                                     },
                                     {
                                         text: '图标', handler: function () {
                                         CHOOSE.setSome("设置图标", {loadCallback: setIcons}, SITEURL + 'icon/dialog_seticon?typeid=2');
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
   width:'5%',
  // xtype:'templatecolumn',
   tdCls:'product-ch',
                   menuDisabled:true,
   align:'center',
   dataIndex:'id',
   border:0,
   renderer : function(value, metadata,record) {
    id=record.get('id');

    if(id.indexOf('suit')==-1)
    return  "<input type='checkbox' class='product_check' style='cursor:pointer' id='box_"+id+"' value='"+value+"'/>";
 
}
  
   },
   {
   text:'排序',
   width:'5%',
   dataIndex:'displayorder',
                   tdCls:'product-order',
   id:'column_lineorder',
   align:'center',
                   menuDisabled:true,
                   cls:'sort-col',
   border:0,
   renderer : function(value, metadata,record) {
              var id=record.get('id'); 
   if(id.indexOf('suit')!=-1)
        metadata.tdAttr ="data-qtip='指同一酒店下房型的显示顺序'"+"data-qclass='dest-tip'";
                                  var newvalue=value;
  if(value==9999||value==999999||!value)
      newvalue='';
                                  return "<input type='text' value='"+newvalue+"' class='row-edit-txt' onblur=\"updateField(this,'"+id+"','displayorder',0,'input')\"/>";
}
  
   },
               {
                   text:'编号',
                   width:'5%',
                   dataIndex:'series',
                   id:'column_series',
                   align:'center',
                   menuDisabled:true,
                   border:0,
                   sortable:false,
                   renderer : function(value, metadata,record) {
                       return '<span>'+value+'</span>';
                   }
               },
   {
   text:'酒店名称',
   width:'30%',
   dataIndex:'title',
   align:'left',
   id:'column_hotelname',
                   menuDisabled:true,
   border:0,
   sortable:false,
   renderer : function(value, metadata,record) {
            var aid=record.get('aid');
    var id=record.get('id');
                                var roomid = record.get('roomid');
                                var hotelid = record.get('hotelid');
                                var iconname = record.get('iconname');
                                var url=record.get('url');
 
 if(!isNaN(id))
                           return "<a class='#333'  href='"+url+"' class='product-title' target='_blank'>"+value+"&nbsp;&nbsp;"+iconname+"</a>";
                         else if(id.indexOf('suit')!=-1)
 {
    metadata.tdAttr ="data-qtip='点击跳转到房型设置页面'  data-qclass='dest-tip'";
   return "<a href='javascript:void(0);' onclick=\"modSuit('"+roomid+"','"+hotelid+"')\" class='suit-title'>&bull;&nbsp;&nbsp;"+value+"</a>";
 }
}
  
   },
              {
               text:'报价有效期',
               width:'8%',
               dataIndex:'suitday',
               align:'center',
               cls:'mod-1 sort-col',
                menuDisabled:true,
               sortable:true,
               renderer : function(value, metadata,record,rowIndex,colIndex) {
                   var id = record.get('id');
                   var curdate = new Date();
                   var curtimestamp = curdate.getTime();
                   var date = new Date(value * 1000);
                   if(value && value>0) {
                       var color=value*1000<curtimestamp?'red':'#999';
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
  text:'星级',
  width:'10%',
  dataIndex:'hotelrankid',
  align:'center',
  cls:'mod-1',
  sortable:false,
                   menuDisabled:true,
  renderer : function(value, metadata,record,rowIndex,colIndex) {
   
  var id=record.get('id');
                      if(!isNaN(id))
  {
 // return "<select><option>一星级</option><option>二星级</option></select>";
    var html="<select onchange=\"updateField(this,"+id+",'hotelrankid',0,'select')\" class='row-edit-select'><option>所有</option>";
Ext.Array.each(window.rankmenu, function(row, index, itelf) {
       var is_selected=row.id==value?"selected='selected'":'';
                                       html+="<option value='"+row.id+"' "+is_selected+">"+row.hotelrank+"</option>";
      });
    html+="</select>";
return html;
 
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
                   text:'供应商',
                   width:'12%',
                   align:'center',
                   dataIndex:'suppliername',
                   cls:'mod-3',
                   border:0,
                   menuDisabled:true,
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
                   text:'联系电话',
                   width:'8%',
                   align:'center',
                   dataIndex:'mobile',
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
                   text:'QQ',
                   width:'8%',
                   align:'center',
                   dataIndex:'qq',
                   cls:'mod-3',
                   border:0,
                   sortable:false,
                   menuDisabled:true,
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
                   align:'left',
                   dataIndex:'address',
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
   text:'目的地',
   width:'6%',
   dataIndex:'kindlist',
   align:'center',
    cls:'mod-1 sort-col',
                   menuDisabled:true,
   sortable:true,
   renderer : function(value, metadata,record,rowIndex,colIndex) {
                       var kindname=record.get('kindname');
                       var finaldestname=record.get('finaldestname');
                       if(kindname) {
                           kindname=kindname.replace(finaldestname,'<font color="red">'+finaldestname+'</font>');
                           metadata.tdAttr = "data-qtip='" + kindname + "'" + "data-qclass='dest-tip'";
                       }
                       var id=record.get('id');
                       var d_text=value?'<span style="color:green">已设</span>':'<span class="c-999">未设</span>';
                       return "<a href='javascript:void(0);' onclick=\"setOneDests("+id+")\">"+d_text+"</a>";
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
   width:'6%',
   align:'center',
   dataIndex:'iconlist',
   border:0,
   cls:'mod-1 sort-col',
                   menuDisabled:true,
   sortable:true,
   renderer : function(value, metadata,record,rowIndex,colIndex) {
  
     var id=record.get('id');
                         var d_text=value?'<span style="color:green">已设</span>':'<span class="c-999">未设</span>';
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
   width:'6%',
   align:'center',
   dataIndex:'attrid',
   border:0,
   sortable:true,
   cls:'mod-1 sort-col',
                   menuDisabled:true,
   renderer : function(value, metadata,record,rowIndex,colIndex) {
  
     var attrname=record.get('attrname');
 if(attrname)
    metadata.tdAttr ="data-qtip='"+attrname+"'data-qclass='dest-tip'";
 
 var id=record.get('id');
                         var d_text=value?'<span style="color:green">已设</span>':'<span class="c-999">未设</span>';
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
   width:'6%',
   align:'center',
   sortable:true,
  dataIndex:'themelist',
                   menuDisabled:true,
  cls:'mod-1 sort-col',
   border:0,
  renderer : function(value, metadata,record,rowIndex,colIndex) {

 var id=record.get('id');
                         var d_text=value?'<span style="color:green">已设</span>':'<span class="c-999">未设</span>';
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
              /* {
                   text: '房型',
                   width: '6%',
                   align: 'center',
                   sortable: false,
                   dataIndex: 'id',
                   cls: 'mod-1',
                   border: 0,
                   renderer: function (value, metadata, record, rowIndex, colIndex) {
                       var id = record.get('id');
                       var hotelname = record.get('hotelname');
                       return "<a href='javascript:void(0);' onclick=\"roomList(" + id + ",'"+hotelname+"')\">房型管理</a>";
                   },
                   listeners: {
                       afterrender: function (obj, eopts) {
                           if(window.display_mode!=1)
                               obj.hide();
                           else
                               obj.show();
                       }
                   }
               },*/
   {
   text:'显示',
   width:'6%',
  // xtype:'templatecolumn',
   align:'center',
   border:0,
   dataIndex:'ishidden',
   xtype:'actioncolumn',
                   menuDisabled:true,
    cls:'mod-1 sort-col',
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
  // togStatus(null,record,'ishidden');
   var val=record.get('ishidden');
                       var id=record.get('id');
                   var newval=val==1?0:1;
  updateField(null,record.get('id'),'ishidden',newval)
   
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
   width:'8%',
   align:'center',
   border:0,
   sortable:false,
                    menuDisabled:true,
   cls:'mod-1',
   renderer : function(value, metadata,record) {
   var id=record.get('id');
   return "<a href='javascript:void(0);' title='编辑'  class='btn-link' onclick=\"goModify("+id+")\">编辑</a>"
                              +"&nbsp;&nbsp;<a href='javascript:void(0);' title='克隆' class='btn-link' onclick=\"ST.Util.goClone("+id+",'hotel/admin/hotel')\">克隆</a>";
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
               text:'房间面积',
               width:'9%',
               align:'center',
               border:0,
               sortable:false,
               menuDisabled:true,
               dataIndex:'roomarea',
               cls:'mod-2',
               renderer : function(value, metadata,record,rowindex,colindex) {
                   return value;
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
           },
           {
               text:'床型',
               width:'9%',
               align:'center',
               border:0,
               sortable:false,
               menuDisabled:true,
               dataIndex:'roomstyle',
               cls:'mod-2',
               renderer : function(value, metadata,record) {
                   return value;
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
           },
           {
               text:'宽带',
               width:'9%',
               align:'center',
               border:0,
               sortable:false,
               dataIndex:'computer',
               menuDisabled:true,
               cls:'mod-2',
               renderer : function(value, metadata,record) {
                  return value;
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
           },
   {
   text:'宽带',
   width:'9%',
   align:'center',
   border:0,
   sortable:false,
   dataIndex:'computer',
                   menuDisabled:true,
   cls:'mod-2',
   renderer : function(value, metadata,record) {
     var id=record.get('id');
 var wifi_arr=[{name:'不含'},{name:'含'},{name:'有线'},{name:'WIFI'}];
 if(id.indexOf('suit')!=-1)
   {
   var html="<select onchange=\"updateField(this,'"+id+"','computer',0,'select')\" class='row-edit-select'>";
   Ext.Array.each(wifi_arr, function(row, index, itself){
     var is_selected=value==row.name?"selected='selected'":'';
 html+="<option value='"+row.name+"' "+is_selected+">"+row.name+"</option>"
});
   html+="</select>";
   return html;

   }
     else
    return '';
                                   // return getExpandableImage(value, metadata,record);
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
  
   },
   {
   text:'管理',
   width:'14%',
   align:'center',
   border:0,
   sortable:false,
   dataIndex:'computer',
                   menuDisabled:true,
   cls:'mod-2',
   renderer : function(value, metadata,record) {
     var id=record.get('id');
                         var hotelid = record.get('hotelid');
                         var roomid = record.get('roomid');
 if(id.indexOf('suit')!=-1)
   {
   return "<a href='javascript:;' class='btn-link' title='编辑' onclick=\"modSuit('"+roomid+"','"+hotelid+"')\">编辑</a>&nbsp;&nbsp;<a href='javascript:;' title='删除' class='btn-link' onclick=\"delSuit('"+id+"')\">删除</a>";
   }
     else
                             return '<a href="javascript:;"  class="btn-link" onclick="ST.Util.addTab(\'添加房型\',\'hotel/admin/hotel/room_op/menuid/<?php echo $_GET['menuid'];?>/parentkey/product/itemid/2/action/add/hotelid/'+id+'\')">添加房型</a>';
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
  
           ],
 listeners:{
            boxready:function()
            {


    var height=Ext.dom.Element.getViewportHeight();
   this.maxHeight=height-76;
   this.doLayout();
            },
afterlayout:function(grid)
{
            if(window.product_kindname)
{
 Ext.getCmp('column_lineorder').setText(window.product_kindname+'-排序')
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
   
   var data_height=0;
   try{
     data_height=grid.getView().getEl().down('.x-grid-table').getHeight();
   }catch(e)
   {
   }
  var height=Ext.dom.Element.getViewportHeight();
// console.log(data_height+'---'+height);
  if(data_height>height-76)
  {
  window.has_biged=true;
  grid.height=height-76;
  }
  else if(data_height<height-76)
  {
  if(window.has_biged)
  {
//delete window.grid.height;
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
//   var view_el=window.product_grid.getView().getEl();
//  view_el.scrollBy(0,this.scroll_top,false);
updateField(0,id,e.field,e.value,0);
return false;
  
 },
 beforeedit:function(editor,e)
 {
  //  var view_el=window.product_grid.getView().getEl();
                     //   this.scroll_top=view_el.getScrollTop();   
  
 
 }
 }
               })
             ],
viewConfig:{
enableTextSelection:true
}   
   });
   
  
  
})

//实现动态窗口大小
  Ext.EventManager.onWindowResize(function(){
  
  var height=Ext.dom.Element.getViewportHeight(); 
  var data_height=window.product_grid.getView().getEl().down('.x-grid-table').getHeight();
  if(data_height>height-76)
     window.product_grid.height=(height-76);
   else
      delete window.product_grid.height;
   window.product_grid.doLayout();
  
   
     /* var height=Ext.dom.Element.getViewportHeight();
   window.product_grid.maxHeight=(height-150);
   window.product_grid.doLayout();
   */
 }) 


    
 
  
  //更新某个字段
    function updateField(ele,id,field,value,type,callback)
    {
        var record=window.product_store.getById(id.toString());
        if(type=='select'||type=='input')
        {
            value=Ext.get(ele).getValue();
        }
        var view_el=window.product_grid.getView().getEl();
        Ext.Ajax.request({
            url   :  "hotel/action/update",
            method  :  "POST",
            datatype  :  "JSON",
            params:{id:id,field:field,val:value,kindid:window.product_kindid},
            success  :  function(response, opts)
            {
                if(response.responseText=='ok')
                {
                    // var view_el=window.product_grid.getView().getEl()
                    //  var scroll_top=view_el.getScrollTop();
                    record.set(field,value);
                    record.commit();
                    if(typeof(callback)=='function')
                    {
                        callback(record);
                    }
                    // view_el.scrollBy(0,scroll_top,false);
                }
            }});
    }
  
  
  //删除
  function delSuit(id)
  {
      ST.Util.confirmBox("提示","确定删除这个套餐？",function(){
         window.product_store.getById(id).destroy();
  })
  }
  //修改
  function goModify(id)
  {
      var record=window.product_store.getById(id.toString());
      var title = record.get('title');
      var url = SITEURL+'hotel/admin/hotel/edit/<?php if(isset($_GET['menuid'])) { ?>menuid/<?php echo $_GET['menuid'];?>/<?php } ?>
parentkey/product/itemid/2/id/'+id;
      parent.window.addTab('修改-'+title,url,1);
  }
  //房型管理
  function roomList(id,hotelname)
  {
      var url = SITEURL+'hotel/admin/hotel/room/<?php if(isset($_GET['menuid'])) { ?>menuid/<?php echo $_GET['menuid'];?>/<?php } ?>
parentkey/product/itemid/2/hotelid/'+id;
      ST.Util.addTab(hotelname,url);
  }
//modSuit
  function modSuit(roomid,hotelid)
  {
      //var hotelid = $("#hotelid").val();
      var record =window.product_store.getById('suit_'+roomid);
      var title = record.get('title');
      var url = SITEURL+'hotel/admin/hotel/room_op/<?php if(isset($_GET['menuid'])) { ?>menuid/<?php echo $_GET['menuid'];?>/<?php } ?>
parentkey/product/itemid/2/action/edit/hotelid/'+hotelid+'/roomid/'+roomid;
      ST.Util.addTab('修改-'+title,url);
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
              //  var id=record.get('id');
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
              //  var id=record.get('id');
               // $("#box_"+id).attr("checked",true);
            });
            return;
        }
        $(".product_check:checked").each(function(index,element){
            var id=$(element).val();
            updateField(null,id,'attrid',idsStr,0,function(record){
                record.set('attrname',nameStr);
                record.commit();
              //  var id=record.get('id');
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
              // var id=record.get('id');
                //$("#box_"+id).attr("checked",true);
            });
        });
    }
    function setOneDests(id)
    {
        CHOOSE.setSome("设置目的地",{loadCallback:setDests,maxHeight:500},SITEURL+'destination/dialog_setdest?typeid=2&id='+id,true);
    }
    function setOneIcons(id)
    {
        CHOOSE.setSome("设置图标",{loadCallback:setIcons},SITEURL+'icon/dialog_seticon?typeid=2&id='+id,true);
    }
    function setOneAttrids(id)
    {
        CHOOSE.setSome("设置属性",{loadCallback:setAttrids},SITEURL+'attrid/dialog_setattrid?typeid=2&id='+id,true);
    }
    function setOneThemes(id)
    {
        CHOOSE.setSome("设置专题",{loadCallback:setThemes},SITEURL+'theme/dialog_settheme?typeid=2&id='+id,true);
    }
</script>
</body>
</html>