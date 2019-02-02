<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>文章管理-笛卡CMS<?php echo $coreVersion;?></title>
 <?php echo  Stourweb_View::template('stourtravel/public/public_js');  ?>
 <?php echo Common::getCss('style.css,base.css,base_new.css'); ?>
 <?php echo Common::getScript("uploadify/jquery.uploadify.min.js,jquery.buttonbox.js,choose.js"); ?>
</head>
<body style="overflow:hidden" right_bottom=KkOzDt >
    <table class="content-tab">
        <tr>
            <td width="119px" class="content-lt-td"  valign="top">
                <?php echo  Stourweb_View::template('stourtravel/public/leftnav');  ?>
                <!--右侧内容区-->
            </td>
            <td valign="top" class="content-rt-td" style="overflow:hidden">
                <div class="cfg-header-bar">
                    <div class="cfg-header-search">
                        <input type="text" id="searchkey" placeholder="优惠券名称/会员手机号" datadef="优惠券名称" class="search-text">
                        <a href="javascript:;" class="search-btn" onclick="CHOOSE.searchKeyword()">搜索</a>
                    </div>
                    <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
                    <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" id="addbtn">赠送</a>
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
            ST.Util.addTab('赠送优惠券','<?php echo $cmsurl;?>coupon/admin/coupon/member_give/<?php if(isset($_GET['menuid'])) { ?>menuid/<?php echo $_GET['menuid'];?><?php } ?>
?action=add');
        });

//产品store
        window.product_store=Ext.create('Ext.data.Store',{
 fields:[
             'memberinfo',
             'name',
             'amount',
             'endtime',
             'samount',
             'antedate',
             'usetime',
 'addtime'
         ],
         proxy:{
   type:'ajax',
   api: {
              read: SITEURL+'coupon/admin/coupon/member_give/action/read',  //读取数据的URL
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
bar.insert(0, Ext.create('Ext.panel.Panel', {border: 0, html: '<div class="panel_bar"></div>'}));
bar.insert(1, Ext.create('Ext.toolbar.Fill'));
}
}
                 }),   
   columns:[
   {
   text:'会员昵称',
   width:'18%',
   dataIndex:'memberinfo',
   align:'center',
   menuDisabled:true,
   border:0,
   sortable:false,
   renderer : function(value, metadata,record) {
   return value.nickname;
   }
   },
   {
   text:'会员手机号',
   width:'10%',
   dataIndex:'memberinfo',
   align:'center',
   menuDisabled:true,
   border:0,
   sortable:false,
   renderer : function(value, metadata,record) {
   return value.mobile;
   }
   },
   {
   text:'优惠券名称',
   width:'24%',
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
   text:'优惠券金额',
   width:'6%',
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
   text:'订单满减',
   width:'8%',
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
   text:'赠送数量',
   width:'8%',
   align:'center',
   cls:'mod-1',
   menuDisabled:true,
   border:0,
   sortable:false,
   renderer : function(value, metadata,record) {
  return '1';
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
   text:'赠送时间',
   width:'8%',
   align:'center',
   dataIndex:'addtime',
   cls:'mod-1',
   menuDisabled:true,
   border:0,
   sortable:false,
   renderer : function(value, metadata,record) {
   return value;
   }
   },
   {
   text:'使用时间',
   width:'8%',
   align:'center',
   dataIndex:'usetime',
   cls:'mod-1',
   menuDisabled:true,
   border:0,
   sortable:false,
   renderer : function(value, metadata,record) {
   return value;
   }
   },
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
