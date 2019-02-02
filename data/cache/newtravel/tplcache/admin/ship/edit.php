<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>邮轮添加/修改</title>
<?php echo  Stourweb_View::template('stourtravel/public/public_js');  ?>
<?php echo Common::getCss('style.css,base.css,base2.css,plist.css,inlinegrid.css,base_new.css'); ?>
<?php echo Common::getScript("uploadify/jquery.uploadify.min.js,product_add.js,choose.js,imageup.js"); ?>
<?php echo Common::getCss('uploadify.css','js/uploadify/'); ?>
</head>
<body>
<table class="content-tab">
    <tr>
    <td width="119px" class="content-lt-td"  valign="top">
     <?php echo  Stourweb_View::template('stourtravel/public/leftnav');  ?>
    <!--右侧内容区-->
    </td>
     <td valign="top" class="content-rt-td ">
          <form method="post" name="product_frm" id="product_frm" script_div=AmACXC >
          
          <div class="manage-nr">
          
              <div class="cfg-header-bar" id="nav">
              <div class="cfg-header-tab">
                <span class="item on">基础信息</span>
                <span class="item" data-id="tupian">邮轮图片</span>
                <span class="item" data-id="schedule">邮轮航次</span>
                <span class="item" data-id="floor">甲板导航</span>
                <span class="item" data-id="room">房型信息</span>
                <span class="item" data-id="facility">服务设施</span>
                        <span class="item" data-id="seo">优化</span>
                </div>  
                <a href="javascript:;" class="fr btn btn-primary radius mr-10 mt-6" onclick="window.location.reload()">刷新</a>
              </div>
              
               <!--基础信息开始-->
                <div class="product-add-div">
                  
                  <ul class="info-item-block">
                  <li>
                  <span class="item-hd">邮轮名称：</span>
                  <div class="item-bd">
                  <input type="text" name="title" id="title" class="input-text w400"  value="<?php echo $info['title'];?>" />
                  </div>
                  </li>
                  <li>
                  <span class="item-hd">邮轮介绍：</span>
                  <div class="item-bd">
                  <?php Common::getEditor('content',$info['content'],700,300,'Sline');?>
                  </div>
                  </li>
                  <li>
                  <span class="item-hd">所属公司：</span>
                  <div class="item-bd">
                  <span class="select-box w150">
                  <select class="select" name="supplierlist">
                                        <option value="">请选择...</option>
                                    <?php $n=1; if(is_array($supplierlist)) { foreach($supplierlist as $supplier) { ?>
                                        <option value="<?php echo $supplier['id'];?>" <?php if($info['supplierlist']==$supplier['id']) { ?>selected="selected"<?php } ?>
 ><?php echo $supplier['suppliername'];?></option>
                                    <?php $n++;}unset($n); } ?>
                                  </select>
                  </span>
                  </div>
                  </li>
                  <li>
                  <span class="item-hd">总吨位：</span>
                  <div class="item-bd">
                  <input type="text" name="weight" id="weight" class="input-text w70" value="<?php echo $info['weight'];?>" />
                  <span class="item-text ml-5">吨</span>
                  </div>
                  </li>
                  <li>
                  <span class="item-hd">载客量：</span>
                  <div class="item-bd">
                  <input type="text" name="seatnum" id="seatnum" class="input-text w70" value="<?php echo $info['seatnum'];?>"/>
                  <span class="item-text ml-5">位</span>
                  </div>
                  </li>
                  <li>
                  <span class="item-hd">船体长度：</span>
                  <div class="item-bd">
                  <input type="text" name="length" id="length" class="input-text w70" value="<?php echo $info['length'];?>" />
                  <span class="item-text ml-5">米</span>
                  </div>
                  </li>
                  <li>
                  <span class="item-hd">船体宽度：</span>
                  <div class="item-bd">
                  <input type="text" name="width" id="width" class="input-text w70" value="<?php echo $info['width'];?>" />
                  <span class="item-text ml-5">米</span>
                  </div>
                  </li>
                  <li>
                  <span class="item-hd">甲板楼层：</span>
                  <div class="item-bd">
                  <input type="text" name="floornum" id="floornum" class="input-text w70" value="<?php echo $info['floornum'];?>" />
                  <span class="item-text ml-5">层</span>
                  </div>
                  </li>
                  <li>
                  <span class="item-hd">船速：</span>
                  <div class="item-bd">
                  <input type="text" name="speed" id="speed" class="input-text w70" value="<?php echo $info['speed'];?>" />
                  <span class="item-text ml-5">节</span>
                  </div>
                  </li>
                  <li>
                  <span class="item-hd">首航时间：</span>
                  <div class="item-bd">
                  <input type="text" name="sailtime" id="sailtime" class="input-text w70" value="<?php echo $info['sailtime'];?>" />
                  <span class="item-text ml-5">年</span>
                  </div>
                  </li>
                  </ul>
                  <div class="line"></div>
                  </div>
              <!--/基础信息结束-->
              <div class="product-add-div" data-id="tupian">
              <ul class="info-item-block">
              <li>
              <span class="item-hd">图片：</span>
              <div class="item-bd">
              <div class="">
                                <div id="pic_btn" class="btn btn-primary radius size-S mt-3">上传图片</div>
                                <span class="item-text c-999 ml-10">建议封面图上传尺寸为1200*500</span>
                            </div>
                            <div class="up-list-div">
                                <input type="hidden" class="headimgindex" name="imgheadindex" value=""/>
                                <input type="hidden" name="litpic" id="litpic" value="<?php echo $info['litpic'];?>"/>
                                <ul class="pic-sel">
     
                                </ul>
                            </div>
              </div>
              </li>
              </ul>  
              </div>
              <div class="product-add-div" data-id="schedule">
                  <div class="inline-grid">
                      <div class="inline-header">
                          <a href="javascript:;" id="schedule_add"  class="inline-add-btn ml-10">添加</a>
                      </div>
                      <div id="schedule_panel" class="inline-body">

                      </div>
                  </div>
              </div>
                  <div class="product-add-div" data-id="floor">
                          <div class="inline-grid">
                                  <div class="inline-header">
                                     <a href="javascript:;" id="floor_add"  class="inline-add-btn ml-10">添加</a>
                                  </div>
                                 <div id="floor_panel" class="inline-body">
                                 </div>
                          </div>
                  </div>
                  <div class="product-add-div" data-id="room">
                      <div class="inline-grid">
                          <div class="inline-header">
                              <a href="javascript:;" id="room_add"  class="inline-add-btn ml-10">添加</a>
                          </div>
                          <div id="room_panel" class="inline-body">
                          </div>
                      </div>
                  </div>
                  <div class="product-add-div" data-id="facility">
                      <div class="inline-grid">
                          <div class="inline-header">
                              <a href="javascript:;" id="facility_add"  class="inline-add-btn ml-10">添加</a>
                          </div>
                          <div id="facility_panel" class="inline-body">
                          </div>
                      </div>
                  </div>
                  <!--seo-->
                  <div class="product-add-div" data-id="seo">
                      <ul class="info-item-block">
                          <li>
                              <span class="item-hd">优化标题：</span>
                              <div class="item-bd">
                                  <input type="text" name="seotitle" value="<?php echo $info['seotitle'];?>" class="input-text w700">
                              </div>
                          </li>
                          <li>
                              <span class="item-hd">Tag词：</span>
                              <div class="item-bd">
                                  <input type="text" name="tagword" class="input-text w700" value="<?php echo $info['tagword'];?>">
                              </div>
                          </li>
                          <li>
                              <span class="item-hd">关键词：</span>
                              <div class="item-bd">
                                  <input type="text" name="keyword" value="<?php echo $info['keyword'];?>" class="input-text w700">
                              </div>
                          </li>
                          <li>
                              <span class="item-hd">页面描述：</span>
                              <div class="item-bd">
                                  <textarea class="textarea w700" name="description" cols="" rows=""><?php echo $info['description'];?></textarea>
                              </div>
                          </li>
                      </ul>
                  </div>
                  
                <div class="clear clearfix pt-20 pb-20">
                <input type="hidden" name="productid" id="productid" value="<?php echo $info['id'];?>"/>
                    <input type="hidden" name="action" id="action" value="<?php echo $action;?>"/>
                    <a class="btn btn-primary radius size-L ml-115" id="btn_save" href="javascript:;">保存</a>
                </div>  
          </div>
        </form>
    </td>
    </tr>
    </table>
<script>
$(document).ready(function(){
        $("#nav").find('span').click(function(){
            var save_arr=['floor','room','facility','schedule'];
            var data_id=$(this).data('id');
            if($.inArray(data_id,save_arr)!=-1)
            {
                var productid=$("#productid").val();
                if(!productid)
                {
                    ST.Util.showMsg('请先保存游轮!','5',1500);
                    return;
                }
            }
            Product.changeTab(this,'.product-add-div');
            if(data_id=='schedule')
            {
                window.product_schedule_store.getProxy().setExtraParam('shipid',productid);
                window.product_schedule_store.reload();
            }
            if(data_id=='floor')
            {
                window.product_floor_store.getProxy().setExtraParam('shipid',productid);
                window.product_floor_store.reload();
            }
            if(data_id=='room')
            {
                window.product_room_store.getProxy().setExtraParam('shipid',productid);
                window.product_room_store.reload();
            }
            if(data_id=='facility')
            {
                window.product_facility_store.getProxy().setExtraParam('shipid',productid);
                window.product_facility_store.reload();
            }
        })
        $("#nav").find('span').first().trigger('click');
        var action = "<?php echo $action;?>";
        //上传图片
        $('#pic_btn').click(function(){
            ST.Util.showBox('上传图片', SITEURL + 'image/insert_view', 0,0, null, null, document, {loadWindow: window, loadCallback: Insert});
            function Insert(result,bool){
                var len=result.data.length;
                for(var i=0;i<len;i++){
                    var temp =result.data[i].split('$$');
                    Imageup.genePic(temp[0],".up-list-div ul",".cover-div");
                }
            }
        })
        //pdf附件
        setTimeout(function(){
            $('#attach_btn').uploadify({
                'swf': PUBLICURL + 'js/uploadify/uploadify.swf',
                'uploader': SITEURL + 'uploader/uploaddoc',
                'buttonImage' : PUBLICURL+'images/uploadfile.png',  //指定背景图
                'formData':{uploadcookie:"<?php echo Cookie::get('username')?>"},
                'fileTypeExts':'*.pdf',
                'auto': true,   //是否自动上传
                'removeTimeout':0.2,
                'height': 25,
                'width': 80,
                'onUploadSuccess': function (file, data, response) {
                    var info=$.parseJSON(data);
                    var html = '<a href="'+info.path+'" target="_blank">查看附件</a>&nbsp;';
                    $("#attachment").val(info.path);
                    if(action=='edit')
                        html+= '<a href="javascript:;" onclick="delAttach()">删除</a>'
                    $("#doclist").html(html);
                }
            });
        },10)
        //保存
        $("#btn_save").click(function(){
               var title = $("#title").val();
            //验证名称
             if(title==''){
                   $("#nav").find('span').first().trigger('click');
                   $("#title").focus();
                   ST.Util.showMsg('请填写轮船名称',5,2000);
               }
               else
               {
                   Ext.Ajax.request({
                       url   :  SITEURL+"ship/admin/ship/ajax_save",
                       method  :  "POST",
                       isUpload :  true,
                       form  : "product_frm",
                       datatype  :  "JSON",
                       success  :  function(response, opts)
                       {
                           var data = $.parseJSON(response.responseText);
                           if(data.status)
                           {
                               if(data.productid!=null){
                                   $("#productid").val(data.productid);
                               }
                               ST.Util.showMsg('保存成功!','4',2000);
                           }
                       }});
               }
        })
        //如果是修改页面
        <?php if($action=='edit') { ?>
            var litpic = $("#litpic").val();
            $(".img-li").find('img').each(function(i,item){
                        if($(item).attr('src')==litpic){
                            var obj = $(item).parent().find('.btn-ste')[0];
                            Imageup.setHead(obj,i+1);
                        }
            })
            var piclist = ST.Modify.getUploadFile(<?php echo $info['piclist_arr'];?>);
            $(".pic-sel").html(piclist);
            var litpic = $("#litpic").val();
            $(".img-li").find('img').each(function(i,item){
                if($(item).attr('src')==litpic){
                    var obj = $(item).parent().find('.btn-ste')[0];
                    Imageup.setHead(obj,i+1);
                }
            })
            window.image_index= $(".pic-sel").find('li').length;//已添加的图片数量
        <?php } ?>
     });
     function showpic()
     {
         $("#updiv").show();
     }
     function unshowpic()
     {
         $("#updiv").hide();
     }
    </script>
    <!--航次列表-->
    <script>
        Ext.onReady(
            function () {
                Ext.tip.QuickTipManager.init();
                $("#schedule_add").click(function(){
                    var productid=$("#productid").val();
                    ST.Util.addTab('添加邮轮航次','<?php echo $cmsurl;?>ship/admin/ship/scheduleadd/shipid/'+productid+'/<?php if(isset($_GET['menuid'])) { ?>menuid/<?php echo $_GET['menuid'];?>/<?php } ?>
parentkey/ship_linekind/itemid/<?php echo $itemid;?>',0);
                });
                //产品store
                window.product_schedule_store = Ext.create('Ext.data.Store', {
                    fields: [
                        'id',
                        'title'
                    ],
                    proxy: {
                        type: 'ajax',
                        api: {
                            read: SITEURL+'ship/admin/ship/schedulelist/action/read',  //读取数据的URL
                            update: SITEURL+'ship/admin/ship/schedulelist/action/save',
                            destroy: SITEURL+'ship/admin/ship/schedulelist/action/delete'
                        },
                        reader: {
                            type: 'json',   //获取数据的格式
                            root: 'lists',
                            totalProperty: 'total'
                        }
                    },
                    remoteSort: true,
                    pageSize: 10,
                    autoLoad: true,
                    listeners: {
                        load: function (store, records, successful, eOpts) {
                            if(!successful){
                                ST.Util.showMsg("<?php echo __('norightmsg');?>",5,1000);
                            }
                            var pageHtml = ST.Util.page(store.pageSize, store.currentPage, store.getTotalCount(), 10);
                            $("#schedule_page").html(pageHtml);
                            window.product_schedule_grid.doLayout();
                            $(".pageContainer .pagePart a").click(function () {
                                var page = $(this).attr('page');
                                product_schedule_store.loadPage(page);
                            });
                        }
                    }
                });
                //产品列表
                window.product_schedule_grid = Ext.create('Ext.grid.Panel', {
                    store: product_schedule_store,
                    renderTo: 'schedule_panel',
                    border: 0,
                    width: "100%",
                    bodyBorder: 0,
                    bodyStyle: 'border-width:0px',
                    scroll:'vertical', //只要垂直滚动条
                    bbar: Ext.create('Ext.toolbar.Toolbar', {
                        store: product_schedule_store,  //这个和grid用的store一样
                        displayInfo: true,
                        emptyMsg: "",
                        items: [
                            {
                                xtype:'panel',
                                id:'listPagePanel',
                                html:'<div id="schedule_page"></div>'
                            },
                            {
                                xtype: 'combo',
                                fieldLabel: '每页显示数量',
                                width: 170,
                                labelAlign: 'right',
                                forceSelection: true,
                                value: 30,
                                store: {fields: ['num'], data: [
                                    {num: 10},
                                    {num: 30},
                                    {num: 60}
                                ]},
                                displayField: 'num',
                                valueField: 'num',
                                listeners: {
                                    select: changescheduleNum
                                }
                            }
                        ],
                        listeners: {
                            single: true,
                            render: function (bar) {
                                var items = this.items;
                                // bar.down('tbfill').hide();
                                //  bar.insert(0, Ext.create('Ext.panel.Panel', {border: 0, html: '<div class="panel_bar"><a class="abtn" href="javascript:void(0);" onclick="chooseAll()">全选</a><a class="abtn" href="javascript:void(0);" onclick="chooseDiff()">反选</a><a class="abtn" href="javascript:void(0);" onclick="del()">删除</a></div>'}));
                                bar.insert(0, Ext.create('Ext.toolbar.Fill'));
                                //items.add(Ext.create('Ext.toolbar.Fill'));
                            }
                        }
                    }),
                    columns: [
                        {
                            text: '行程天数',
                            width: '80%',
                            dataIndex: 'title',
                            align: 'center',
                            border: 0,
                            sortable: false,
                            menuDisabled:true
                        },
                        {
                            text: '管理',
                            width: '20%',
                            align: 'center',
                            border: 0,
                            sortable: false,
                            cls: 'mod-1',
                            menuDisabled:true,
                            renderer: function (value, metadata, record) {
                                var id = record.get('id');
                                var html = "<a href='javascript:void(0);' class='btn-link' onclick=\"scheduleView(" + id + ")\">编辑</a>"+
                                    '&nbsp;&nbsp;<a href="javascript:void(0);" title="删除" class="btn-link" onclick="delschedule('+id+')">删除</a>';
                                return html;
                                // return getExpandableImage(value, metadata,record);
                            }
                        }
                    ],
                    listeners: {
                        boxready: function () {
                            var height = Ext.dom.Element.getViewportHeight();
                            this.maxHeight = height ;
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
                            if (data_height > height - 106) {
                                window.has_biged = true;
                                grid.height = height - 106;
                            }
                            else if (data_height < height - 106) {
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
                                    //  var view_el=window.product_schedule_grid.getView().getEl();
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
        //切换每页显示数量
        function changescheduleNum(combo, records) {
            var pagesize = records[0].get('num');
            window.product_schedule_store.pageSize = pagesize;
            window.product_schedule_grid.down('pagingtoolbar').moveFirst();
        }
        function scheduleView(id)
        {
            var url = SITEURL+'ship/admin/ship/scheduleedit/id/'+id+'/<?php if(isset($_GET['menuid'])) { ?>menuid/<?php echo $_GET['menuid'];?>/<?php } ?>
parentkey/ship_linekind/itemid/<?php echo $itemid;?>';
            parent.window.addTab('修改航次',url,1);
        }
        function delschedule(id)
        {
            ST.Util.confirmBox("提示","确定删除这个航次？",function(){
                id=id.toString();
                window.product_schedule_store.getById(id).destroy();
            })
        }
        Ext.EventManager.onWindowResize(function(){
            var height=Ext.dom.Element.getViewportHeight();
            window.product_schedule_grid.maxHeight=(height-106);
            window.product_schedule_grid.doLayout();
        })
    </script>
<!--楼层列表-->
<script>
    Ext.onReady(
        function () {
            Ext.tip.QuickTipManager.init();
            $("#floor_add").click(function(){
                var productid=$("#productid").val();
                ST.Util.addTab('添加游轮楼层','<?php echo $cmsurl;?>ship/admin/ship/flooradd/shipid/'+productid+'/<?php if(isset($_GET['menuid'])) { ?>menuid/<?php echo $_GET['menuid'];?>/<?php } ?>
parentkey/ship_linekind/itemid/<?php echo $itemid;?>',0);
            });
            //产品store
            window.product_floor_store = Ext.create('Ext.data.Store', {
                fields: [
                    'id',
                    'displayorder',
                    'title',
                    'rooms',
                    'facilities'
                ],
                proxy: {
                    type: 'ajax',
                    api: {
                        read: SITEURL+'ship/admin/ship/floorlist/action/read',  //读取数据的URL
                        update: SITEURL+'ship/admin/ship/floorlist/action/save',
                        destroy: SITEURL+'ship/admin/ship/floorlist/action/delete'
                    },
                    reader: {
                        type: 'json',   //获取数据的格式
                        root: 'lists',
                        totalProperty: 'total'
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
                        var pageHtml = ST.Util.page(store.pageSize, store.currentPage, store.getTotalCount(), 20);
                        $("#floor_page").html(pageHtml);
                        window.product_floor_grid.doLayout();
                        $(".pageContainer .pagePart a").click(function () {
                            var page = $(this).attr('page');
                            product_floor_store.loadPage(page);
                        });
                    }
                }
            });
            //产品列表
            window.product_floor_grid = Ext.create('Ext.grid.Panel', {
                store: product_floor_store,
                renderTo: 'floor_panel',
                border: 0,
                width: "100%",
                bodyBorder: 0,
                bodyStyle: 'border-width:0px',
                scroll:'vertical', //只要垂直滚动条
                bbar: Ext.create('Ext.toolbar.Toolbar', {
                    store: product_floor_store,  //这个和grid用的store一样
                    displayInfo: true,
                    emptyMsg: "",
                    items: [
                        {
                            xtype:'panel',
                            id:'listPagePanel',
                            html:'<div id="floor_page"></div>'
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
                                select: changeFloorNum
                            }
                        }
                    ],
                    listeners: {
                        single: true,
                        render: function (bar) {
                            var items = this.items;
                            // bar.down('tbfill').hide();
                          //  bar.insert(0, Ext.create('Ext.panel.Panel', {border: 0, html: '<div class="panel_bar"><a class="abtn" href="javascript:void(0);" onclick="chooseAll()">全选</a><a class="abtn" href="javascript:void(0);" onclick="chooseDiff()">反选</a><a class="abtn" href="javascript:void(0);" onclick="del()">删除</a></div>'}));
                            bar.insert(0, Ext.create('Ext.toolbar.Fill'));
                            //items.add(Ext.create('Ext.toolbar.Fill'));
                        }
                    }
                }),
                columns: [
                    {
                        text: '排序',
                        width: '10%',
                        dataIndex: 'displayorder',
                        align: 'center',
                        border: 0,
                        sortable: true,
                        menuDisabled:true,
                        cls:'sort-col',
                        renderer: function (value, metadata, record) {
                            var id=record.get('id');
                            var newvalue=value;
                            if(value==9999||value==999999)
                                newvalue='';
                            return "<input type='text' value='"+newvalue+"' class='row-edit-txt' onblur=\"updateFloorField(this,'"+id+"','displayorder',0,'input')\"/>";
                        }
                    },
                    {
                        text: '楼层',
                        width: '20%',
                        dataIndex: 'title',
                        align: 'center',
                        border: 0,
                        sortable: false,
                        menuDisabled:true,
                        renderer: function (value, metadata, record) {
                            return value;
                        }
                    },
                    {
                        text: '房型',
                        width: '30%',
                        dataIndex: 'rooms',
                        align: 'center',
                        border: 0,
                        sortable: false,
                        menuDisabled:true
                    },
                    {
                        text: '服务设施',
                        width: '30%',
                        dataIndex: 'facilities',
                        align: 'center',
                        border: 0,
                        sortable: false,
                        menuDisabled:true
                    },
                    {
                        text: '管理',
                        width: '10%',
                        align: 'center',
                        border: 0,
                        sortable: false,
                        cls: 'mod-1',
                        menuDisabled:true,
                        renderer: function (value, metadata, record) {
                            var id = record.get('id');
                            var html = "<a href='javascript:void(0);' class='btn-link' onclick=\"floorView(" + id + ")\">编辑</a>"+
                                '&nbsp;&nbsp;<a href="javascript:void(0);" title="删除" class="btn-link" onclick="delFloor('+id+')">删除</a>';
                            return html;
                            // return getExpandableImage(value, metadata,record);
                        }
                    }
                ],
                listeners: {
                    boxready: function () {
                        var height = Ext.dom.Element.getViewportHeight();
                        this.maxHeight = height ;
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
                        if (data_height > height - 106) {
                            window.has_biged = true;
                            grid.height = height - 106;
                        }
                        else if (data_height < height - 106) {
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
                                //  var view_el=window.product_floor_grid.getView().getEl();
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
    //切换每页显示数量
    function changeFloorNum(combo, records) {
        var pagesize = records[0].get('num');
        window.product_floor_store.pageSize = pagesize;
        window.product_floor_grid.down('pagingtoolbar').moveFirst();
    }
    function floorView(id)
    {
        var url = SITEURL+'ship/admin/ship/flooredit/id/'+id+'/<?php if(isset($_GET['menuid'])) { ?>menuid/<?php echo $_GET['menuid'];?>/<?php } ?>
parentkey/ship_linekind/itemid/<?php echo $itemid;?>';
        parent.window.addTab('修改楼层',url,1);
    }
    function delFloor(id)
    {
        ST.Util.confirmBox("提示","确定删除这个楼层？",function(){
            id=id.toString();
            window.product_floor_store.getById(id).destroy();
        })
    }
    function updateFloorField(ele,id,field,value,type,callback)
    {
        var record=window.product_floor_store.getById(id.toString());
        if(type=='select'||type=='input')
        {
            value=Ext.get(ele).getValue();
        }
        var view_el=window.product_floor_grid.getView().getEl();
        Ext.Ajax.request({
            url   :  SITEURL+"ship/admin/ship/floorlist/action/update",
            method  :  "POST",
            datatype  :  "JSON",
            params:{id:id,field:field,val:value},
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
    Ext.EventManager.onWindowResize(function(){
        var height=Ext.dom.Element.getViewportHeight();
        window.product_floor_grid.maxHeight=(height-106);
        window.product_floor_grid.doLayout();
    })
</script>
    <!--舱房列表-->
<script>
    Ext.onReady(
        function () {
            Ext.tip.QuickTipManager.init();
            $("#room_add").click(function(){
                var productid=$("#productid").val();
                ST.Util.addTab('添加游轮房型','<?php echo $cmsurl;?>ship/admin/ship/roomadd/shipid/'+productid+'/<?php if(isset($_GET['menuid'])) { ?>menuid/<?php echo $_GET['menuid'];?>/<?php } ?>
parentkey/ship_linekind/itemid/<?php echo $itemid;?>',0);
            });
            //产品store
            window.product_room_store = Ext.create('Ext.data.Store', {
                fields: [
                    'id',
                    'title',
                    'shipid',
                    'kindid',
                    'kindname',
                    'area',
                    'peoplenum',
                    'num',
                    'iswindow',
                    'floorsname',
                    'floors',
                    'displayorder'
                ],
                proxy: {
                    type: 'ajax',
                    api: {
                        read: SITEURL+'ship/admin/ship/roomlist/action/read',  //读取数据的URL
                        update: SITEURL+'ship/admin/ship/roomlist/action/save',
                        destroy: SITEURL+'ship/admin/ship/roomlist/action/delete'
                    },
                    reader: {
                        type: 'json',   //获取数据的格式
                        root: 'lists',
                        totalProperty: 'total'
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
                        var pageHtml = ST.Util.page(store.pageSize, store.currentPage, store.getTotalCount(), 20);
                        $("#room_page").html(pageHtml);
                        window.product_room_grid.doLayout();
                        $(".pageContainer .pagePart a").click(function () {
                            var page = $(this).attr('page');
                            product_room_store.loadPage(page);
                        });
                    }
                }
            });
            //产品列表
            window.product_room_grid = Ext.create('Ext.grid.Panel', {
                store: product_room_store,
                renderTo: 'room_panel',
                border: 0,
                width: "100%",
                bodyBorder: 0,
                bodyStyle: 'border-width:0px',
                scroll:'vertical', //只要垂直滚动条
                bbar: Ext.create('Ext.toolbar.Toolbar', {
                    store: product_room_store,  //这个和grid用的store一样
                    displayInfo: true,
                    emptyMsg: "",
                    items: [
                        {
                            xtype:'panel',
                            id:'listPagePanel',
                            html:'<div id="room_page"></div>'
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
                                select: changeRoomNum
                            }
                        }
                    ],
                    listeners: {
                        single: true,
                        render: function (bar) {
                            var items = this.items;
                            // bar.down('tbfill').hide();
                          //  bar.insert(0, Ext.create('Ext.panel.Panel', {border: 0, html: '<div class="panel_bar"><a class="abtn" href="javascript:void(0);" onclick="chooseAll()">全选</a><a class="abtn" href="javascript:void(0);" onclick="chooseDiff()">反选</a><a class="abtn" href="javascript:void(0);" onclick="del()">删除</a></div>'}));
                            bar.insert(0, Ext.create('Ext.toolbar.Fill'));
                            //items.add(Ext.create('Ext.toolbar.Fill'));
                        }
                    }
                }),
                columns: [
                    {
                        text:'排序',
                        width:'8%',
                        dataIndex:'displayorder',
                        align:'center',
                        menuDisabled:true,
                        cls:'sort-col',
                        border:0,
                        renderer : function(value, metadata,record) {
                            var id=record.get('id');
                            var newvalue=value;
                            if(value==9999||value==999999)
                                newvalue='';
                            return "<input type='text' value='"+newvalue+"' class='row-edit-txt' onblur=\"updateRoomField(this,'"+id+"','displayorder',0,'input')\"/>";
                        }
                    },
                    {
                        text: '房型名称',
                        width: '16%',
                        dataIndex: 'title',
                        align: 'center',
                        border: 0,
                        sortable: false,
                        menuDisabled:true,
                        renderer: function (value, metadata, record) {
                            return value;
                        }
                    },
                    {
                        text: '房型类别',
                        width: '15%',
                        dataIndex: 'kindname',
                        align: 'center',
                        border: 0,
                        sortable: false,
                        menuDisabled:true
                    },
                    {
                        text: '房型间数',
                        width: '12%',
                        dataIndex: 'num',
                        align: 'center',
                        border: 0,
                        sortable: false,
                        menuDisabled:true
                    },
                    {
                        text: '面积',
                        width: '10%',
                        dataIndex: 'area',
                        align: 'center',
                        border: 0,
                        sortable: false,
                        menuDisabled:true
                    },
                    {
                        text: '可住人数',
                        width: '10%',
                        dataIndex: 'peoplenum',
                        align: 'center',
                        border: 0,
                        sortable: false,
                        menuDisabled:true
                    },
                    {
                        text: '窗型',
                        width: '10%',
                        dataIndex: 'iswindow',
                        align: 'center',
                        border: 0,
                        sortable: false,
                        menuDisabled:true,
                        renderer: function (value, metadata, record) {
                            if(value==1)
                               return '有';
                            else
                              return '无';
                            // return getExpandableImage(value, metadata,record);
                        }
                    },
                    {
                        text: '甲板楼层',
                        width: '10%',
                        dataIndex: 'floorsname',
                        align: 'center',
                        border: 0,
                        sortable: false,
                        menuDisabled:true
                    },
                    {
                        text: '管理',
                        width: '10%',
                        align: 'center',
                        border: 0,
                        sortable: false,
                        cls: 'mod-1',
                        menuDisabled:true,
                        renderer: function (value, metadata, record) {
                            var id = record.get('id');
                            var html = "<a href='javascript:void(0);' class='btn-link' onclick=\"viewRoom(" + id + ")\">编辑</a>"+
                                '&nbsp;&nbsp;<a href="javascript:void(0);" title="删除" class="btn-link" onclick="delRoom('+id+')">删除</a>';
                            return html;
                            // return getExpandableImage(value, metadata,record);
                        }
                    }
                ],
                listeners: {
                    boxready: function () {
                        var height = Ext.dom.Element.getViewportHeight();
                        this.maxHeight = height ;
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
                        if (data_height > height - 106) {
                            window.has_biged = true;
                            grid.height = height - 106;
                        }
                        else if (data_height < height - 106) {
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
                                //  var view_el=window.product_floor_grid.getView().getEl();
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
    //切换每页显示数量
    function changeRoomNum(combo, records) {
        var pagesize = records[0].get('num');
        window.product_room_store.pageSize = pagesize;
        window.product_room_grid.down('pagingtoolbar').moveFirst();
    }
    Ext.EventManager.onWindowResize(function(){
        var height=Ext.dom.Element.getViewportHeight();
        window.product_room_grid.maxHeight=(height-106);
        window.product_room_grid.doLayout();
    })
    function updateRoomField(ele,id,field,value,type,callback)
    {
        var record=window.product_room_store.getById(id.toString());
        if(type=='select'||type=='input')
        {
            value=Ext.get(ele).getValue();
        }
        var view_el=window.product_room_grid.getView().getEl();
        Ext.Ajax.request({
            url   :  SITEURL+"ship/admin/ship/roomlist/action/update",
            method  :  "POST",
            datatype  :  "JSON",
            params:{id:id,field:field,val:value},
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
    function delRoom(id)
    {
        ST.Util.confirmBox("提示","确定删除这个房间？",function(){
            id=id.toString();
            window.product_room_store.getById(id).destroy();
        })
    }
    function viewRoom(id)
    {
        var url = SITEURL+'ship/admin/ship/roomedit/id/'+id+'/<?php if(isset($_GET['menuid'])) { ?>menuid/<?php echo $_GET['menuid'];?>/<?php } ?>
parentkey/ship_linekind/itemid/<?php echo $itemid;?>';
        parent.window.addTab('修改舱房',url,1);
    }
</script>
    <!--设施列表-->
<script>
    Ext.onReady(
        function () {
            Ext.tip.QuickTipManager.init();
            $("#facility_add").click(function(){
                var productid=$("#productid").val();
                ST.Util.addTab('添加游轮设施','<?php echo $cmsurl;?>ship/admin/ship/facilityadd/shipid/'+productid+'/<?php if(isset($_GET['menuid'])) { ?>menuid/<?php echo $_GET['menuid'];?>/<?php } ?>
parentkey/ship_linekind/itemid/<?php echo $itemid;?>',0);
            });
            //产品store
            window.product_facility_store = Ext.create('Ext.data.Store', {
                fields: [
                    'id',
                    'title',
                    'shipid',
                    'kindid',
                    'kindname',
                    'opentime',
                    'isfree',
                    'floorsname',
                    'floors',
                    'displayorder'
                ],
                proxy: {
                    type: 'ajax',
                    api: {
                        read: SITEURL+'ship/admin/ship/facilitylist/action/read',  //读取数据的URL
                        update: SITEURL+'ship/admin/ship/facilitylist/action/save',
                        destroy: SITEURL+'ship/admin/ship/facilitylist/action/delete'
                    },
                    reader: {
                        type: 'json',   //获取数据的格式
                        root: 'lists',
                        totalProperty: 'total'
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
                        var pageHtml = ST.Util.page(store.pageSize, store.currentPage, store.getTotalCount(), 20);
                        $("#facility_page").html(pageHtml);
                        window.product_facility_grid.doLayout();
                        $(".pageContainer .pagePart a").click(function () {
                            var page = $(this).attr('page');
                            product_facility_store.loadPage(page);
                        });
                    }
                }
            });
            //产品列表
            window.product_facility_grid = Ext.create('Ext.grid.Panel', {
                store: product_facility_store,
                renderTo: 'facility_panel',
                border: 0,
                width: "100%",
                bodyBorder: 0,
                bodyStyle: 'border-width:0px',
                scroll:'vertical', //只要垂直滚动条
                bbar: Ext.create('Ext.toolbar.Toolbar', {
                    store: product_facility_store,  //这个和grid用的store一样
                    displayInfo: true,
                    emptyMsg: "",
                    items: [
                        {
                            xtype:'panel',
                            id:'listPagePanel',
                            html:'<div id="facility_page"></div>'
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
                                select: changeFacilityNum
                            }
                        }
                    ],
                    listeners: {
                        single: true,
                        render: function (bar) {
                            var items = this.items;
                            // bar.down('tbfill').hide();
                          //  bar.insert(0, Ext.create('Ext.panel.Panel', {border: 0, html: '<div class="panel_bar"><a class="abtn" href="javascript:void(0);" onclick="chooseAll()">全选</a><a class="abtn" href="javascript:void(0);" onclick="chooseDiff()">反选</a><a class="abtn" href="javascript:void(0);" onclick="del()">删除</a></div>'}));
                            bar.insert(0, Ext.create('Ext.toolbar.Fill'));
                            //items.add(Ext.create('Ext.toolbar.Fill'));
                        }
                    }
                }),
                columns: [
                    {
                        text:'排序',
                        width:'8%',
                        dataIndex:'displayorder',
                        align:'center',
                        menuDisabled:true,
                        cls:'sort-col',
                        border:0,
                        renderer : function(value, metadata,record) {
                            var id=record.get('id');
                            var newvalue=value;
                            if(value==9999||value==999999||!value)
                                newvalue='';
                            return "<input type='text' value='"+newvalue+"' class='row-edit-txt' onblur=\"updateFacilityField(this,'"+id+"','displayorder',0,'input')\"/>";
                        }
                    },
                    {
                        text: '设施名称',
                        width: '28%',
                        dataIndex: 'title',
                        align: 'center',
                        border: 0,
                        sortable: false,
                        menuDisabled:true,
                        renderer: function (value, metadata, record) {
                            return value;
                        }
                    },
                    {
                        text: '设施类别',
                        width: '15%',
                        dataIndex: 'kindname',
                        align: 'center',
                        border: 0,
                        sortable: false,
                        menuDisabled:true
                    },
                    {
                        text: '开放时间',
                        width: '12%',
                        dataIndex: 'opentime',
                        align: 'center',
                        border: 0,
                        sortable: false,
                        menuDisabled:true
                    },
                    {
                        text: '是否免费',
                        width: '12%',
                        dataIndex: 'isfree',
                        align: 'center',
                        border: 0,
                        sortable: false,
                        menuDisabled:true,
                        renderer: function (value, metadata, record) {
                                 if(value==1)
                                    return '免费';
                                 else
                                    return '收费';
                            // return getExpandableImage(value, metadata,record);
                        }
                    },
                    {
                        text: '所在楼层',
                        width: '15%',
                        dataIndex: 'floorsname',
                        align: 'center',
                        border: 0,
                        sortable: false,
                        menuDisabled:true
                    },
                    {
                        text: '管理',
                        width: '10%',
                        align: 'center',
                        border: 0,
                        sortable: false,
                        cls: 'mod-1',
                        menuDisabled:true,
                        renderer: function (value, metadata, record) {
                            var id = record.get('id');
                            var html = "<a href='javascript:void(0);' class='btn-link' onclick=\"viewFacility(" + id + ")\">编辑</a>"+
                                '&nbsp;&nbsp;<a href="javascript:void(0);" title="删除" class="btn-link" onclick="delFacility('+id+')">删除</a>';
                            return html;
                            // return getExpandableImage(value, metadata,record);
                        }
                    }
                ],
                listeners: {
                    boxready: function () {
                        var height = Ext.dom.Element.getViewportHeight();
                        this.maxHeight = height ;
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
                        if (data_height > height - 106) {
                            window.has_biged = true;
                            grid.height = height - 106;
                        }
                        else if (data_height < height - 106) {
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
                                //  var view_el=window.product_floor_grid.getView().getEl();
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
    //切换每页显示数量
    function changeFacilityNum(combo, records) {
        var pagesize = records[0].get('num');
        window.product_facility_store.pageSize = pagesize;
        window.product_facility_grid.down('pagingtoolbar').moveFirst();
    }
    Ext.EventManager.onWindowResize(function(){
        var height=Ext.dom.Element.getViewportHeight();
        window.product_facility_grid.maxHeight=(height-106);
        window.product_facility_grid.doLayout();
    })
    function viewFacility(id)
    {
        var url = SITEURL+'ship/admin/ship/facilityedit/id/'+id+'/<?php if(isset($_GET['menuid'])) { ?>menuid/<?php echo $_GET['menuid'];?>/<?php } ?>
parentkey/ship_linekind/itemid/<?php echo $itemid;?>';
        parent.window.addTab('修改设施',url,1);
    }
    function updateFacilityField(ele,id,field,value,type,callback)
    {
        var record=window.product_facility_store.getById(id.toString());
        if(type=='select'||type=='input')
        {
            value=Ext.get(ele).getValue();
        }
        var view_el=window.product_facility_grid.getView().getEl();
        Ext.Ajax.request({
            url   :  SITEURL+"ship/admin/ship/facilitylist/action/update",
            method  :  "POST",
            datatype  :  "JSON",
            params:{id:id,field:field,val:value},
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
    function delFacility(id)
    {
        ST.Util.confirmBox("提示","确定删除这个设施？",function(){
            id=id.toString();
            window.product_facility_store.getById(id).destroy();
        })
    }
</script>
</body>
</html>
