<!doctype html>
<html>
<head ul_padding=sQOzDt >
<meta charset="utf-8">
<title>笛卡CMS{$coreVersion}</title>
 {template 'stourtravel/public/public_js'}
 {php echo Common::getCss('style.css,base.css,base_new.css'); }
 {php echo Common::getScript("jquery.buttonbox.js,choose.js"); }
<style>
  .yqlj-set-tab tr{
	   height:30px;
	   line-height:30px; 
	  }
  
</style>

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
                    <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
                    <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" id="addbtn" >添加</a>
                </div>

                <div class="cfg-search-bar">

                    <div class="cfg-header-search">
                        <input type="text" id="searchkey" value="专题名称" datadef="专题名称" class="search-text">
                        <a href="javascript:;" class="search-btn" onclick="CHOOSE.searchKeyword()">搜索</a>
                    </div>

                </div>
                <div id="product_grid_panel" class="content-nrt">

                </div>
            </td>
        </tr>
     </table>
 
<script>
  Ext.onReady(
    function() 
    {
		 Ext.tip.QuickTipManager.init();
        $("#searchkey").focusEffect();
        //添加按钮
        $("#addbtn").click(function(){
            ST.Util.addTab('添加专题',SITEURL+'zt/admin/zt/add/{if isset($_GET['menuid'])}menuid/{$_GET['menuid']}/{/if}parentkey/sale/itemid/3');
        });


	
		 //产品store
         window.product_store=Ext.create('Ext.data.Store',{
		 fields:['id','title','pc_templet','m_templet','addtime','displayorder','pinyin'],
         proxy:{
		   type:'ajax',
		   api: {
              read: SITEURL+'zt/admin/zt/list/action/read',  //读取数据的URL
			  update:SITEURL+'zt/admin/zt/list/action/save',
			  destroy:SITEURL+'zt/admin/zt/list/action/delete'
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
							  select:changeNum
						  }
					   }
					
					],
				  listeners: {
						single: true,
						render: function(bar) {
							var items = this.items;
							//bar.down('tbfill').hide();

							bar.insert(0,Ext.create('Ext.panel.Panel',{border:0,html:'<div class="panel_bar"><a class="btn btn-primary radius " href="javascript:void(0);" onclick="CHOOSE.chooseAll()">全选</a><a class="btn btn-primary radius ml-10" href="javascript:void(0);" onclick="CHOOSE.chooseDiff()">反选</a><a class="btn btn-primary radius ml-10" href="javascript:void(0);" onclick="CHOOSE.delMore()">删除</a></div>'}));
							
							bar.insert(1,Ext.create('Ext.toolbar.Fill'));
							//items.add(Ext.create('Ext.toolbar.Fill'));
						}
					}	
                 }), 		 			 
	   columns:[
			   {
				   text:'选择',
				   width:'10%',
				  // xtype:'templatecolumn',
				   tdCls:'product-ch',
				   align:'center',
				   dataIndex:'id',
                   menuDisabled:true,
				   border:0,
				   renderer : function(value, metadata,record) {
					    id=record.get('id');
					    if(id.indexOf('suit')==-1)
					    return  "<input type='checkbox' class='product_check' style='cursor:pointer' value='"+value+"'/>"; 
					 
					}
				  
			   },
			   {
				   text:'排序',
				   width:'12%',
				   dataIndex:'displayorder',
                   tdCls:'product-order',
				   id:'column_lineorder',
                   cls:'sort-col',
                   menuDisabled:true,
				   align:'center',
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
				   text:'专题名称',
				   width:'20%',
				   dataIndex:'title',
				   align:'left',
                   menuDisabled:true,
				   border:0,
				   sortable:false,
				   renderer : function(value, metadata,record) {
                       var id=record.get('id');
                       var pinyin = record.get('pinyin');
                       if(pinyin!=''){
                           url = '/zt/'+pinyin;
                       }else{
                           url = '/zt/'+id+'.html';
                       }
                       return "<a href='"+url+"' class='line-title' target='_blank'>"+value+"</a>";

						}
				  
			   },
               {
                   text:'PC模板',
                   width:'15%',
                   align:'center',
                   border:0,
                   dataIndex:'pc_templet',
                   menuDisabled:true,
                   sortable:false,
                   renderer : function(value, metadata,record) {
                       if(value=='')
                           return '标准模板';
                       else
                           return value;

                   }


               },
               {
                   text:'手机模板',
                   width:'15%',
                   align:'center',
                   border:0,
                   dataIndex:'m_templet',
                   menuDisabled:true,
                   sortable:false,
                   renderer : function(value, metadata,record) {
                       if(value=='')
                           return '标准模板';
                       else
                           return value;

                   }


               },
			    {
				   text:'添加时间',
				   width:'15%',
				   align:'center',
				   cls:'sort-col',
				   border:0,
				   dataIndex:'addtime',
                	menuDisabled:true,
				   sortable:true,
				   renderer : function(value, metadata,record) {
						   if(value==0)
						      return '';
						   else
						   {
							   var date=new Date(value*1000);
							   return Ext.Date.format(date, 'Y-m-d');
						   }
							  	   
                    }

				  
			   },
			   
			   {
				   text:'管理',
				   width:'22%',
				   align:'center',
				   border:0,
				   sortable:false,
                   menuDisabled:true,
				   dataIndex:'id',
				   renderer : function(value, metadata,record) {    
				           title=record.get('title');
						   return "<a href='javascript:;' class='btn-link' onclick=\"ST.Util.addTab('修改"+title+"','"+SITEURL+"zt/admin/zt/edit/menuid/{$_GET['menuid']}/parentkey/sale/itemid/2/themeid/"+value+"')\">编辑</a>";
                                   // return getExpandableImage(value, metadata,record);
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
							 Ext.getCmp('column_lineorder').setText(window.product_kindname+'-排序')
						}
						else
					    {
							Ext.getCmp('column_lineorder').setText('排序')
						}
					
						window.product_store.each(function(record){
				        id=record.get('id');
						

						
					   });
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
							delete window.product_grid.height;
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

  //进行搜索
  function goSearch(ele,val,field)
  {
	 
	  if(field=='kindid')
	  {
	     Ext.select('.kind-search-cs a').removeCls('active');
	    Ext.get(ele).addCls('active'); 
	  }
	  window.product_store.getProxy().setExtraParam(field,val);
	  window.product_store.load();
	  
  }
  
    
  function searchDest(ele)
  {
	   var keyword=Ext.get(ele).prev().getValue();
	   keyword=Ext.String.trim(keyword);
	   goSearch(0,keyword,'keyword');
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
		  url   :  SITEURL+"zt/admin/zt/file_update",
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
				  ST.Utils.showMsg("{__('norightmsg')}",5,1000);
			  }
		  }});

  }


  //切换每页显示数量
  function changeNum(combo,records)
  {
		
		var pagesize=records[0].get('num');
		window.product_store.pageSize=pagesize;
		window.product_grid.down('pagingtoolbar').moveFirst();

	}
	//选择全部 
  function chooseAll()
  {
	 var check_cmp=Ext.query('.product_check');
	 for(var i in check_cmp)
	 {
		if(!Ext.get(check_cmp[i]).getAttribute('checked'))
		    check_cmp[i].checked='checked';
	 } 
	 
	//  window.sel_model.selectAll();
  }
  //反选
  function chooseDiff()
  {
	  var check_cmp=Ext.query('.product_check');
		for(var i in check_cmp)
		  check_cmp[i].click();

  }
  function delLine()
  {
	  //window.product_grid.down('gridcolumn').hide();
	  
	  var check_cmp=Ext.select('.product_check:checked');
	  
	  if(check_cmp.getCount()==0)
	  {
		  return;
	  }
      ST.Util.confirmBox("提示","确定删除？",function(){
	 check_cmp.each(
		  function(el,c,index)
				{
						window.product_store.getById(el.getValue()).destroy();	 
				}
			 );
	   })
  }
 



  
  //修改
  function goModify(id,title)
  {
	 
  }
  
  
  
</script>

</body>
</html>
