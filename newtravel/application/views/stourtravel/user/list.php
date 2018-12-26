<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>用户管理-笛卡CMS{$coreVersion}</title>
    {template 'stourtravel/public/public_js'}
    {php echo Common::getCss('style.css,base.css,base2.css,plist.css,base_new.css'); }
    {php echo Common::getScript("jquery.validate.js,choose.js"); }
<style>
   .user-add-tb{
       width:340px;
       table-layout: fixed;
       line-height: 35px;
   }
   .user-add-tb td input{
       height: 24px;
   }
   .user-add-tb td textarea{
       height: 50px;
       width: 240px;
   }
   .error{
       color:red;
       padding-left:5px;
   }
</style>

</head>
<body style="overflow:hidden" right_left=PHJzDt >

    <table class="content-tab">
        <tr>
            <td width="119px" class="content-lt-td"  valign="top">
                 {template 'stourtravel/public/leftnav'}
                <!--右侧内容区-->
            </td>
            <td valign="top" class="content-rt-td" style="overflow:hidden">
                <div class="list-top-set">
                    <div class="list-web-pad"></div>
                    <div class="list-web-ct">
                        <table class="list-head-tb">
                            <tr>
                                <td class="head-td-lt"></td>
                                <td class="head-td-rt">
                                    <a href="javascript:;" class="btn btn-primary radius" onclick="window.location.reload()">刷新</a>
                                    <a href="javascript:;" class="btn btn-primary radius" id="addbtn">添加</a>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div id="product_grid_panel" class="content-nrt">
                </div>
            </td>
        </tr>
    </table>
 
<script>
  var roles={$roles};
  Ext.onReady(
    function() 
    {
		 Ext.tip.QuickTipManager.init();

		 /*顶部按钮，相关设置，站点等*/
	     Ext.get('addbtn').on('click',function()
         {
             var url = SITEURL+'user/dialog_edit/menuid/{$_GET['menuid']}';
             ST.Util.addTab('添加用户',url,0)
           //  ST.Util.showBox("添加用户",SITEURL+'user/dialog_edit',600,435,null,null,document,{loadWindow:window,loadCallback:function(){product_store.reload(); }});
         });
		 //产品store
         window.product_store=Ext.create('Ext.data.Store',{
		 fields:['id','username','beizu','roleid','phone','email','notice_title'],
         proxy:{
		   type:'ajax',
		   api: {
              read: SITEURL+'user/list/action/read',  //读取数据的URL
			  update:SITEURL+'user/list/action/save',
			  destroy:SITEURL+'user/list/action/delete'
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
         listeners: {
                 load: function (store, records, successful, eOpts) {
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
							  select:changeNum
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
				   border:0,
				     menuDisabled:true,
				   renderer : function(value, metadata,record) {
					    id=record.get('id');
					    if(id.indexOf('suit')==-1)
					    return  "<input type='checkbox' class='product_check' style='cursor:pointer' value='"+value+"'/>"; 
					 
					}
			   },

			   {
				   text:'用户名',
				   width:'10%',
				   dataIndex:'username',
				   align:'left',
				   border:0,
				   sortable:false,
                   menuDisabled:true,
				   renderer : function(value, metadata,record) {
					       return value;
						}
			   },
               {
               text: '<span class="grid_column_text">权限</span>'+ST.Util.getGridHelp('admin_field_roleid'),
               width:'10%',
               dataIndex:'roleid',
               align:'left',
               border:0,
               sortable:false,
			     menuDisabled:true,
               renderer : function(value, metadata,record) {
                    var id=record.get('id');
                    var roleid = record.get('roleid');
                    var status = roleid==1 ? "disabled=\"disabled\" style='color:#b9b9b9' " : '';

                    var html="<select "+status+" onchange=\"updateField(this,"+id+",'roleid',0,'select')\" class='row-edit-select'><option value='0'>请选择..</option>"
                    Ext.Array.each(roles,function(row,index){

                            var is_selected=value==row.roleid?"selected='selected'":'';
                            html+="<option value='"+row.roleid+"' "+is_selected+">"+row.rolename+"</option>";


                    })
                    html+="</select>";
                   return html;
                  // return value;
               }
              },
           {
               text:'接收通知产品',
               width:'20%',
               dataIndex:'notice_title',
               align:'left',
               border:0,
               sortable:false,
               menuDisabled:true,
               renderer : function(value, metadata,record) {
                   return value;
               }
           },
           {
               text:'手机号',
               width:'15%',
               dataIndex:'phone',
               align:'left',
               border:0,
               sortable:false,
               menuDisabled:true,
               renderer : function(value, metadata,record) {
                   var id=record.get('id');
                   if(!value)
                   {
                       value ='';
                   }
                   return  "<input type='text' value='"+value+"' style='text-align:left' class='row-edit-txt' onblur=\"updateField(this,'"+id+"','phone',0,'input')\"/>";
               }

           },
           {
               text:'邮箱',
               width:'15%',
               dataIndex:'email',
               align:'left',
               border:0,
               sortable:false,
               menuDisabled:true,
               renderer : function(value, metadata,record) {
                   var id=record.get('id');
                   if(!value)
                   {
                       value ='';
                   }
                   return  "<input type='text' value='"+value+"' style='text-align:left' class='row-edit-txt' onblur=\"updateField(this,'"+id+"','email',0,'input')\"/>";
               }

           },

              {
               text:'备注',
               width:'10%',
               dataIndex:'beizu',
               align:'left',
               border:0,
               sortable:false,
			     menuDisabled:true,
               renderer : function(value, metadata,record) {
                      var id=record.get('id');
                      return  "<input type='text' value='"+value+"' style='text-align:left' class='row-edit-txt' onblur=\"updateField(this,'"+id+"','beizu',0,'input')\"/>";
                  }

               },
			   {
				   text:'管理',
				   width:'10%',
				   align:'center',
				   border:0,
				   sortable:false,
				     menuDisabled:true,
				   dataIndex:'id',
				   renderer : function(value, metadata,record) {    
				         //  title=record.get('ztname');
						  // return "<a href='javascript:;' onclick=\"ST.Util.addTab('修改"+title+"','"+SITEURL+"zhuanti/edit/themeid/"+value+"')\">修改</a>";
                                   // return getExpandableImage(value, metadata,record);
								return "<a href='javascript:;' class='btn-link' onclick=\"goModify("+value+")\">编辑</a>"
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


//  Ext.get('right_manage').on('click',function(dom){
//
//      ST.Util.addTab("权限管理",SITEURL+"user/right/parentkey/member/itemid/3");
//  })



  //进行搜索
  function goSearch(ele,val,field)
  {
	 
	  if(field=='kindid')
	  {
	     Ext.select('.kind-search-cs a').removeCls('active');
	    Ext.get(ele).addCls('active'); 
	  }
	  window.product_store.getProxy().setExtraParam(field,val);
	  window.product_store.loadPage(1);
	  
  }
  
    
  function searchDest(ele)
  {
	   var keyword=Ext.get(ele).prev().getValue();
	   keyword=Ext.String.trim(keyword);
	   goSearch(0,keyword,'keyword');
  }
	
	//切换每页显示数量
  function changeNum(combo,records)
  {
		
		var pagesize=records[0].get('num');
		window.product_store.pageSize=pagesize;
       window.product_store.loadPage(1);

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
	  var check_cmp=Ext.select('.product_check:checked');
	  if(check_cmp.getCount()==0)
	  {
		  return;
	  }
	  
	  var system_managers=window.product_store.query('roleid',1);
	  
	  var managers_num=system_managers.getCount();
	 
	  
	   ST.Util.confirmBox("提示","确定删除",function(buttonId){
		    
	      check_cmp.each(
		  function(el,c,index)
				{
					var record=window.product_store.getById(el.getValue());
					if(record.get('roleid')==1)
					{
						if(managers_num==1)
						{
							ST.Util.showMsg('至少要保留一个系统管理员',5);
							return;
						}
						else
						{
							managers_num--;
							record.destroy();
						}
						
					}
					else
					  record.destroy();
				}
			 );
	   })
  }
 
  
  //更新某个字段
  function updateField(ele,id,field,value,type)
  {
	  var record=window.product_store.getById(id.toString());
	  if(type=='select' || type=='input')
	  {
		  value=Ext.get(ele).getValue();
	  }
	  var view_el=window.product_grid.getView().getEl();
	
	 
	  Ext.Ajax.request({
						 url   :  "list/action/update",
						 method  :  "POST",
						 datatype  :  "JSON",
						 params:{id:id,field:field,val:value},
						 success  :  function(response, opts) 
						 {
							 if(response.responseText=='ok')
							 {
							 
							   record.set(field,value);
							   record.commit(); 
						      
							 }
						 }});
  }
  

  
  //设置帮助的显示位置
  function setPosition(dom,types,id)
  {
	  Ext.create('Ext.window.Window',
	           { 
			     title:'设置显示位置',
				 border:1,
				 style: {
                     borderStyle: 'solid',
					 borderWidth:'1px'
                  },
				 bodyStyle:'padding:10px', 
				 ghost:false,
				 autoShow:true,
				 listeners:{
					  boxready:function(win)
					  {

						  var html="<div><span style=\"margin-left:10px\"><input onclick=\"choosePos(this,9,0)\" type=\"checkbox\"  value=\"0\" style=\"vertical-align:middle\">全选</span>";
						  var  choosed=types.split(',');
						  Ext.Object.each(typearr, function(key, value, myself)
						  {
							   var tid=key.slice(4);
							   
							   var is_checked='';
							   if(Ext.Array.contains(choosed,tid))
							       is_checked="checked='checked'" 
							   
							   html+="<span style='margin-left:10px'><input onclick=\"choosePos(this,"+id+","+tid+")\" type='checkbox' "+is_checked+" value='"+tid+"' style='vertical-align:middle'/>"+value+"</span>"
						  });
						  html+="</div>";
						  win.update(html);
					  }
					}
			   });
	  
	  
  }

  
  //修改
  function goModify(id)
  {
      var url = SITEURL+'user/dialog_edit/menuid/{$_GET['menuid']}?id='+id;
      ST.Util.addTab('修改用户',url,0)
      //ST.Util.showBox("修改用户",SITEURL+'user/dialog_edit?id='+id,600,435,null,null,document,{loadWindow:window,loadCallback:function(){product_store.reload(); }});
  }
  
  
  
</script>

</body>
</html>