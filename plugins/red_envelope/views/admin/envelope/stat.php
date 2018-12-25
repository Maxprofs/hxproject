<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>资讯管理-笛卡CMS{$coreVersion}</title>
 {template 'stourtravel/public/public_js'}
 {php echo Common::getCss('style.css,base.css,base_new.css'); }
 {php echo Common::getScript("uploadify/jquery.uploadify.min.js,jquery.buttonbox.js,choose.js"); }

</head>
<body style="overflow:hidden">

    <table class="content-tab">
        <tr>
            <td width="119px" class="content-lt-td"  valign="top">
                {template 'stourtravel/public/leftnav'}
                <!--右侧内容区-->
            </td>
            <td valign="top" class="content-rt-td" style="overflow:hidden">
                <div class="cfg-header-bar">

                    <div class="cfg-header-search">
                        <input type="text" id="searchkey"  placeholder="红包名称/会员手机号/会员昵称" class="search-text">
                        <a href="javascript:;" class="search-btn" onclick="CHOOSE.searchKeyword()">搜索</a>
                    </div>
                    <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
                    <a href="javascript:;" target="_blank" class="fr btn btn-primary radius mt-6 mr-10" id="excel">导出excel</a>
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

        $('#excel').click(function () {
            var url = SITEURL+'envelope/admin/envelope/excel_stat';
            window.open(url)


        })
		 
		
		//产品store
        window.product_store=Ext.create('Ext.data.Store',{

		 fields:[
             'id',
             'envelope_title',
             'typeid_title',
             'money',
             'addtime',
             'usetime',
             'nickname',
             'mobile',
         ],

         proxy:{
		   type:'ajax',
		   api: {
              read: SITEURL+'envelope/admin/envelope/stat/action/read',  //读取数据的URL
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

							bar.insert(0,Ext.create('Ext.panel.Panel'));

							bar.insert(1,Ext.create('Ext.toolbar.Fill'));
							bar.insert(2,Ext.create('Ext.toolbar.Fill'));
							//items.add(Ext.create('Ext.toolbar.Fill'));
						}
					}	
                 }), 		 			 
	   columns:[

           {
               text:'会员昵称',
               width:'15%',
               dataIndex:'nickname',
               align:'center',
               menuDisabled:true,
               border:0,
               sortable:false,
               renderer : function(value, metadata,record) {
                   return value

               }

           },
           {
               text:'会员手机号',
               width:'15%',
               dataIndex:'mobile',
               align:'center',
               menuDisabled:true,
               border:0,
               sortable:false,
               renderer : function(value, metadata,record) {
                   return value

               }

           },

			   {
				   text:'金额',
				   width:'15%',
				   dataIndex:'money',
				   align:'center',
                   menuDisabled:true,
				   border:0,
				   sortable:false,
				   renderer : function(value, metadata,record) {
					            return value
			                       
						}
				  
			   },


			   {
				   text:'可用产品',
				   width:'20%',
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
                   text:'红包名称',
                   width:'15%',
                   align:'center',
                   border:0,
                   dataIndex:'envelope_title',
                   sortable:false,
                   menuDisabled:true,
                   renderer : function(value, metadata,record,rowIndex,colIndex) {

                        return value;
                   }


               },

           {
               text:'领取时间',
               width:'10%',
               dataIndex:'addtime',
               align:'center',
               menuDisabled:true,
               border:0,
               sortable:false,
               renderer : function(value, metadata,record) {
                   return value

               }

           },
           {
               text:'使用时间',
               width:'10%',
               dataIndex:'usetime',
               align:'center',
               menuDisabled:true,
               border:0,
               sortable:false,
               renderer : function(value, metadata,record) {
                   return value

               }

           },

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
                                 ST.Util.showMsg("{__('norightmsg')}",5,1000);
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
