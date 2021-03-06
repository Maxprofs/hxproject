<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head script_top=89LzDt >
<meta charset="utf-8">
<title>文章管理-笛卡CMS<?php echo $coreVersion;?></title>
 <?php echo  Stourweb_View::template('stourtravel/public/public_js');  ?>
 <?php echo Common::getCss('style.css,base.css,base_new.css'); ?>
 <?php echo Common::getScript("uploadify/jquery.uploadify.min.js,jquery.buttonbox.js,choose.js"); ?>
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
                    <div class="fl select-box w200 mt-6 ml-10">
                        <select name="status" onchange="togStatus(this)" class="select">
                            <option value="0" > 优惠券类型</option>
                            <?php $n=1; if(is_array($kindlist)) { foreach($kindlist as $k) { ?>
                            <option value="<?php echo $k['id'];?>" > <?php echo $k['kindname'];?></option>
                            <?php $n++;}unset($n); } ?>
                        </select>
                    </div>
                    <div class="cfg-header-search">
                        <input type="text" id="searchkey" placeholder="优惠券名称" datadef="优惠券名称" class="search-text">
                        <a href="javascript:;" class="search-btn" onclick="CHOOSE.searchKeyword()">搜索</a>
                    </div>
                    <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
                    <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" id="addbtn">添加</a>
                </div>
                <div id="product_grid_panel" class="content-nrt">
                </div>
            </td>
        </tr>
    </table>
<script>
   window.display_mode=1;//默认显示模式
   window.product_kindid=0;  //默认目的地ID
  Ext.onReady(
    function() 
    {
 Ext.tip.QuickTipManager.init();
        $(".btnbox").buttonBox();
        $("#searchkey").focusEffect();
        //添加按钮
        $("#addbtn").click(function(){
            ST.Util.addTab('添加优惠券','<?php echo $cmsurl;?>coupon/admin/coupon/add/<?php if(isset($_GET['menuid'])) { ?>menuid/<?php echo $_GET['menuid'];?><?php } ?>
');
        });

//产品store
        window.product_store=Ext.create('Ext.data.Store',{
 fields:[
             'id',
             'name',
             'kindname',
             'amount',
             'endtime',
             'samount',
             'antedate',
             'isopen',
 'code',
 'displayorder',
 'send_and_total'
         ],
         proxy:{
   type:'ajax',
   api: {
              read: SITEURL+'coupon/admin/coupon/index/action/read',  //读取数据的URL
  update:SITEURL+'coupon/admin/coupon/index/action/save',
  destroy:SITEURL+'coupon/admin/coupon/index/action/delete'
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
                    $(".pageContainer .pagePart a").click(function(){
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
bar.insert(0, Ext.create('Ext.panel.Panel', {border: 0, html: '<div class="panel_bar"><a class="btn btn-primary radius" href="javascript:void(0);" onclick="CHOOSE.chooseAll()">全选</a><a class="btn btn-primary radius ml-10" href="javascript:void(0);" onclick="CHOOSE.chooseDiff()">反选</a><a class="btn btn-primary radius ml-10" href="javascript:void(0);" onclick="CHOOSE.delMore()">删除</a></div>'}));
bar.insert(1, Ext.create('Ext.toolbar.Fill'));
}
}
                 }),   
   columns:[
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
   text:'排序',
   width:'5%',
   dataIndex:'displayorder',
   tdCls:'product-order',
   id:'column_lineorder',
   menuDisabled:true,
   align:'center',
   cls:'sort-col',
   border:0,
   renderer : function(value, metadata,record) {
   var id=record.get('id');
   var newvalue=value;
   if(value==9999||value==999999||!value)
   newvalue='';
   return "<input type='text' value='"+newvalue+"' class='row-edit-txt' onblur=\"updateField(this,'"+id+"','displayorder',0,'input')\"/>";
   }
   },
   {
   text:'优惠券编码',
   width:'10%',
   dataIndex:'code',
   align:'center',
   menuDisabled:true,
   border:0,
   sortable:false,
   renderer : function(value, metadata,record) {
   var aid=record.get('aid');
   var id=record.get('id');
   var url=record.get('url');
   if(!isNaN(id))
   return value;
   }
   },
   {
   text:'优惠券名称',
   width:'10%',
   dataIndex:'name',
   align:'center',
                   menuDisabled:true,
   border:0,
   sortable:false,
   renderer : function(value, metadata,record) {
            var aid=record.get('aid');
    var id=record.get('id');
                                var url=record.get('url');
 
 if(!isNaN(id))
                           return value;
                       
}
  
   },
   {
   text:'优惠券类型',
   width:'5%',
   dataIndex:'kindname',
   align:'center',
   menuDisabled:true,
   border:0,
   sortable:false,
   renderer : function(value, metadata,record) {
                       return value;
                    }
   },
   {
   text:'优惠券金额',
   width:'10%',
   align:'center',
   dataIndex:'amount',
   menuDisabled:true,
   border:0,
   sortable:false,
   renderer : function(value, metadata,record) {
    return value;
                    }
 
  
   },
   {
   text:'优惠券有效期',
   width:'10%',
   align:'center',
   dataIndex:'endtime',
   menuDisabled:true,
   border:0,
   sortable:false,
   renderer : function(value, metadata,record) {
     return value;
                    }
   },
   {
   text:'订单满减',
   width:'12%',
   align:'center',
   dataIndex:'samount',
   cls:'mod-1',
   menuDisabled:true,
   border:0,
   sortable:false,
   renderer : function(value, metadata,record) {
                       return value;
                    }
   },
   {
   text:'提前天数',
   width:'8%',
   align:'center',
   dataIndex:'antedate',
   cls:'mod-1',
   menuDisabled:true,
   border:0,
   sortable:false,
   renderer : function(value, metadata,record) {
   if(value>0)
   {
   return value+'天';
   }
   else
   {
   return value;
   }
   }
   },
   {
   text:'已领/发放张数',
   width:'8%',
   align:'center',
   dataIndex:'send_and_total',
   cls:'mod-1',
   menuDisabled:true,
   border:0,
   sortable:false,
   renderer : function(value, metadata,record) {
   if(value>0)
   {
   return value+'天';
   }
   else
   {
   return value;
   }
   }
   },
   {
   text:'开启',
   width:'8%',
  // xtype:'templatecolumn',
   align:'center',
   dataIndex:'isopen',
   xtype:'actioncolumn',
   menuDisabled:true,
   border:0,
   sortable:false,
           items:[
       {
        getClass: function(v, meta, rec) {          // Or return a class from a function
    if(v==1)
  return 'dest-status-ok';
else
  return 'dest-status-none';  
                    },
    handler:function(view,index,colindex,itm,e,record)
    {
   var val=record.get('isopen');
                       var id=record.get('id');
                   var newval=val==1?0:1;
   updateField(null,record.get('id'),'isopen',newval)
    }
      }]
   },
   {
   text:'管理',
   width:'8%',
   align:'center',
   border:0,
   sortable:false,
                   menuDisabled:true,
  renderer : function(value, metadata,record) {
     var id=record.get('id');
  var contitle=record.get('name');
 var html = "<a href='javascript:void(0);' title='编辑' class='btn-link' onclick=\"goModify("+id+",'"+contitle+"')\">编辑</a>" +
 '<a href="javascript:void(0);" class="btn-link ml-5" onclick="show_view('+id+',\''+contitle+'\')">详情</a>'+
 "<a href='javascript:void(0);' title='删除' class='btn-link ml-5' onclick=\"delRow(this,"+id+")\">删除</a>"
 ;
  return html;
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
  //更新某个字段
  function updateField(ele,id,field,value,type,callback)
  {
  var record=window.product_store.getById(id.toString());
  if(type=='select'||type=='input')
  {
  value=Ext.get(ele).getValue();
  }
  var view_el=window.product_grid.getView().getEl();
  if(field=='isopen'&&value==0)
  {
  ST.Util.confirmBox('提示','确定关闭?',function()
  {
  Ext.Ajax.request({
  url   :  SITEURL+"coupon/admin/coupon/index/action/update",
  method  :  "POST",
  datatype  :  "JSON",
  params:{id:id,field:field,val:value,kindid:window.product_kindid},
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
  });
  }
  else
  {
  Ext.Ajax.request({
  url   :  SITEURL+"coupon/admin/coupon/index/action/update",
  method  :  "POST",
  datatype  :  "JSON",
  params:{id:id,field:field,val:value,kindid:window.product_kindid},
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
  }
  //修改
    function goModify(id,contitle)
    {
        var url = SITEURL+'coupon/admin/coupon/edit/id/'+id+'/<?php if(isset($_GET['menuid'])) { ?>menuid/<?php echo $_GET['menuid'];?><?php } ?>
';
        parent.window.addTab('修改优惠券：'+contitle,url,1);
    }
 //删除
    function delRow(dom,id)
    {
ST.Util.confirmBox('提示','确定删除?',function(){
if(id==0)
$(dom).parents('tr').first().remove();
else
{
$.ajaxform({
url   :  SITEURL+"coupon/admin/coupon/delrow",
method  :  "POST",
data:{id:id},
dataType  :  "html",
success  :  function(result)
{
var text = result;
if(text=='ok')
{
window.product_store.loadPage(1);
}
else
{
}
}});
}
});
    }
   function togStatus(ele)
   {
   var kindid=$(ele).val();
   window.product_store.getProxy().setExtraParam('kindid',kindid);
   window.product_store.loadPage(1);
   }
function show_view(id,contitle)
{
var url=SITEURL+"coupon/admin/coupon/view/<?php if(isset($_GET['menuid'])) { ?>menuid/<?php echo $_GET['menuid'];?>/<?php } ?>
id/"+id;
ST.Util.addTab('优惠券详情：'+contitle,url,1);
}
</script>
</body>
</html>
