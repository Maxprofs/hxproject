<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>资讯管理-笛卡CMS{$coreVersion}</title>
 {template 'stourtravel/public/public_js'}
 {php echo Common::getCss('style.css,base.css,base_new.css'); }
    {php echo Common::css_plugin('admin/css/red-paper.css','red_envelope')}
 {php echo Common::getScript("uploadify/jquery.uploadify.min.js,jquery.buttonbox.js,choose.js"); }

</head>
<body style="overflow:hidden">

    <table class="content-tab" script_table=9pDCXC >
        <tr>
            <td width="119px" class="content-lt-td"  valign="top">
                {template 'stourtravel/public/leftnav'}
                <!--右侧内容区-->
            </td>
            <td valign="top" class="content-rt-td" style="overflow:hidden">
                <div class="cfg-header-bar">

                    <div class="fl select-box w100 mt-3 ml-10">
                        <select name="webid" onchange="togStatus(this)"  class="select">
                            <option value="0" >筛选产品</option>
                            {loop $product_list $p}
                            <option value="{$p['id']}">{$p['modulename']}</option>
                            {/loop}
                        </select>
                    </div>

                    <div class="cfg-header-search">
                        <input type="text" id="searchkey"  placeholder="名称" class="search-text">
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



   window.display_mode=1;	//默认显示模式
   window.product_kindid=0;  //默认目的地ID


  Ext.onReady(
    function() 
    {
		 Ext.tip.QuickTipManager.init();

        $(".btnbox").buttonBox();

        $("#searchkey").focusEffect();
        //添加按钮
        $("#addbtn").click(function(){
            ST.Util.addTab('添加','{$cmsurl}envelope/admin/envelope/add/{if isset($_GET['menuid'])}menuid/{$_GET['menuid']}/{/if}parentkey/news/itemid/1',0);
        });


		 
		 
		 
		 
		 
		
		//产品store
        window.product_store=Ext.create('Ext.data.Store',{

		 fields:[
             'id',
             'title',
             'typeid_title',
             'total_money',
             'total_number',
             'share_number',
             'status',
             'use_rate',
             'new_rate',
             'is_finish',


         ],

         proxy:{
		   type:'ajax',
		   api: {
              read: SITEURL+'envelope/admin/envelope/index/action/read',  //读取数据的URL
			  update:SITEURL+'envelope/admin/envelope/index/action/save',
			  destroy:SITEURL+'envelope/admin/envelope/index/action/delete'
              },
		      reader:{
                type: 'json',   //获取数据的格式 
                root: 'lists',
                totalProperty: 'total'
                }
	         },
		 remoteSort:true,
         autoLoad:true,
		 pageSize:20,
         listeners:{
                load:function( store, records, successful, eOpts )
                {
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

							bar.insert(1,Ext.create('Ext.toolbar.Fill'));
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
				   align:'center',
				   dataIndex:'id',
				   border:0,
                   menuDisabled:true,
				   renderer : function(value, metadata,record) {
					    id=record.get('id');
					    if(id.indexOf('suit')==-1)
					    return  "<input type='checkbox' class='product_check' id='box_"+id+"' style='cursor:pointer' value='"+value+"'/>";
					 
					}
				  
			   },
			   {
				   text:'名称',
				   width:'20%',
				   dataIndex:'title',
				   align:'left',
                   menuDisabled:true,
				   border:0,
				   sortable:false,
				   renderer : function(value, metadata,record) {
					            return value
			                       
						}
				  
			   },


			   {
				   text:'条件',
				   width:'15%',
				   align:'center',
				   dataIndex:'typeid_title',
				   border:0,
                   menuDisabled:true,
                   sortable:false,
				   renderer : function(value, metadata,record,rowIndex,colIndex) {
                        return value;
                    }


			   },

               {
                   text:'瓜分总金额',
                   width:'10%',
                   align:'center',
                   border:0,
                   dataIndex:'total_money',
                   sortable:false,
                   menuDisabled:true,
                   renderer : function(value, metadata,record,rowIndex,colIndex) {

                        return value;
                   }


               },
               {
                   text:'剩余分享次数',
                   width:'10%',
                   dataIndex:'total_number',
                   align:'center',
                   menuDisabled:true,
                   border:0,
                   sortable:false,
                   renderer : function(value, metadata,record) {
                       return value

                   }

               },
           {
               text:'成交转化率',
               width:'10%',
               dataIndex:'use_rate',
               align:'center',
               menuDisabled:true,
               border:0,
               sortable:false,
               renderer : function(value, metadata,record) {
                   return value+'%'

               }

           },
           {
               text:'拉新率',
               width:'10%',
               dataIndex:'new_rate',
               align:'center',
               menuDisabled:true,
               border:0,
               sortable:false,
               renderer : function(value, metadata,record) {
                   return value+'%'

               }

           },

			   {
				   text:'开关状态',
				   width:'10%',
				  // xtype:'templatecolumn',
				   align:'center',
				   border:0,
				   dataIndex:'status',
				   xtype:'actioncolumn',
                   menuDisabled:true,
				    cls:'mod-1 sort-col',
		           items:[
			       {

			        getClass: function(v, meta, rec) {
                        var is_finish=rec.get('is_finish');
                        if(is_finish==1)
                        {
                            return 'dest-status-finish';
                        }


			            // Or return a class from a function
					    if(v==1)
						  return 'dest-status-ok';
						else
						  return 'dest-status-none';  
                    },
				    handler:function(view,index,colindex,itm,e,record)
				    {
					   var val=record.get('status');
                       var id=record.get('id');
	                   var newval=val==1?0:1;
					   updateField(null,record.get('id'),'status',newval)
					   
				    }
			      }
			      ]
				  
				  
			   },

			   {
				   text:'管理',
				   width:'10%',
				   align:'center',
				   border:0,
				   sortable:false,
                   menuDisabled:true,
				  renderer : function(value, metadata,record) {
					     var id=record.get('id');
					     var is_finish=record.get('is_finish');
                         var html = '';
                         if(is_finish!=1)
                         {
                             html +="<a href='javascript:void(0);' title='编辑' class='btn-link mr-10' onclick=\"goModify("+id+")\">编辑</a>";
                         }
						 return  html += "<a href='javascript:void(0);' title='统计' class='btn-link' onclick=\"goShow("+id+")\">统计</a>";
						 	
                                   // return getExpandableImage(value, metadata,record);
                    }
				  
			   }
	           ],
			 listeners:{
		            boxready:function()
		            {
					
				
					   var height=Ext.dom.Element.getViewportHeight();
					   this.maxHeight=height-40;
					   this.doLayout();
		            },
					afterlayout:function(grid)
					{

					   var data_height=0;
					   try{
					     data_height=grid.getView().getEl().down('.x-grid-table').getHeight();
					   }catch(e)
					   {
					   }
					  var height=Ext.dom.Element.getViewportHeight();

					  if(data_height>height-40)
					  {
						  window.has_biged=true;
						  grid.height=height-40;
					  }
					  else if(data_height<height-40)
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
      if(data_height>height-40)
          window.product_grid.height=(height-40);
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
	
	 
	  Ext.Ajax.request({
						 url   :  SITEURL+"envelope/admin/envelope/index/action/update",
						 method  :  "POST",
						 datatype  :  "JSON",
						 params:{id:id,field:field,val:value},
						 success  :  function(response, opts) 
						 {
                            var  data = eval('('+response.responseText+')');


							 if(data.status==1)
							 {
                                 window.product_store.reload();

						      
							 }
                             else
                             {
                                 ST.Util.showMsg(data.msg,5,1000);
                             }
						 }});

  }

   function togStatus(ele)
   {
       var status=$(ele).val();
       window.product_store.getProxy().setExtraParam('typeid',status);
       window.product_store.loadPage(1);

   }

    //修改
    function goModify(id)
    {
        var record = window.product_store.getById(id.toString());
        var title = record.get('title');
        var url = SITEURL+'envelope/admin/envelope/add/{if isset($_GET['menuid'])}menuid/{$_GET['menuid']}/{/if}/id/'+id;

        parent.window.addTab('修改-'+title,url,1);
    }

    //统计
    function goShow(id) {

        var record = window.product_store.getById(id.toString());
        var title = record.get('title');
        var url = SITEURL+'envelope/admin/envelope/count/{if isset($_GET['menuid'])}menuid/{$_GET['menuid']}/{/if}/id/'+id;

        parent.window.addTab('统计-'+title,url,1);
    }


</script>

</body>
</html>
