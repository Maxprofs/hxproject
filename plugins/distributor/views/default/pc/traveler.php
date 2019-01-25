<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>{__('游客管理')}-{$webname}</title>
    {include "pub/varname"}
    {Common::css('user.css,base.css,extend.css,base_new.css')}
    {php echo Common::css('extjs/resources/ext-theme-neptune/ext-theme-neptune-all-debug(org).css'); }
    {php echo Common::js("jquery.min.js,choose.js,msgbox/msgbox.js,extjs/ext-all.js,extjs/locale/ext-lang-zh_CN.js,jquery.buttonbox.js,common_ext.js,datepicker/WdatePicker.js"); }
	<style>
		.user-message-center{
			margin-bottom: 20px;
		}
		.user-message-bar{
			background-color: #fff;
		}
	</style>
</head>
<body>

{request "pub/header"}

  <div class="big">
  	<div class="wm-1200">

      <div class="st-guide">
      	<a href="{$cmsurl}">{__('首页')}</a>&nbsp;&nbsp;&gt;&nbsp;&nbsp;{__('游客管理')}
      </div><!--面包屑-->

      <div class="st-main-page">
        {include "member/left_menu"}
		<div class="user-message-center fr">
			<div class="user-message-bar">游客管理</div>
		</div>
		<div class="user-message-center fr">
			<div class="user-message-bar">
        		<span style="margin-left: 17px;">注册时间:</span><input type="text" class="input-text w200" id="starttime" onclick="WdatePicker({maxDate:'%y-%M-%d'})"> 至 <input type="text" class="input-text w200" id="endtime" onclick="WdatePicker({maxDate:'%y-%M-%d'})"> <button class="btn btn-primary radius ml-10" id="export">导出数据</button>
			</div>
		</div>
        <div class="user-main-box" id="user-main-box" style="background-color: #fff;">
		</div>
    </div>
  </div>
{Common::js('layer/layer.js')}
{request "pub/footer"}

<script>
Ext.application({
    name: 'drawgrid',
    launch: function() {
        Ext.tip.QuickTipManager.init();
        // 建立一个store要使用的 model
        Ext.define('members', {
            extend: 'Ext.data.Model',
            fields: [
                { name: 'mid', type: 'string' },
                { name: 'truename', type: 'string' },
                { name: 'mobile', type: 'string' },
                { name: 'email', type: 'string' },
                { name: 'cardid', type: 'string' },
                { name: 'logintime', type: 'string' },
                { name: 'address', type: 'string' }
            ]
        });

        window.product_store = Ext.create('Ext.data.Store', {
            model: 'members',
            proxy: {
                type: 'ajax',
                url: '/distributor/pc/traveler/ajax_gettravelers',
                reader: {
                    type: 'json',
                    root: 'list',
                    totalProperty: 'total'
                }
            },
            remoteSort: true,
            pageSize: 20,
            autoLoad: true,
            listeners: {
                load: function(store, records, successful, eOpts) {
                    var pageHtml = ST.Util.page(store.pageSize, store.currentPage, store.getTotalCount(), 20);
                    $("#distributor_page").html(pageHtml);
                    window.product_grid.doLayout();
                    $(".pageContainer .pagePart a").click(function () {
                        var page = $(this).attr('page');
                        product_store.loadPage(page);
                    });
                }
            }
        });
        window.product_grid = Ext.create('Ext.grid.Panel', {
            store: product_store,
            renderTo: 'product_grid_panel',
            style:{border:'1px solid silver'},
            bodyBorder: 0,
            bodyStyle: 'border-width:0px',
            scroll: 'vertical',
            bbar:Ext.create('Ext.toolbar.Toolbar',{
                store: product_store, //这个和grid用的store一样
                displayInfo: true,
                emptyMsg: "没有数据了",
                background:'none',
                items:[{
                    xtype:'panel',
                    id:'listPagePanel',
                    html:'<div id="distributor_page"></div>'
                }
                ],
                listeners:{
                    single:true,
                    render:function(bar) {
                        var items = this.items;
                        bar.insert(0,Ext.create('Ext.panel.Panel',{
                            border:0,
                            html:''
                        }));
                        bar.insert(1, Ext.create('Ext.toolbar.Fill'));
                    },
                },
            }),
            columns: [
                { 
                    text: '编号',
                    dataIndex: 'mid',
                    width: '5%',
                    align: 'center',
                    border:0,
                    sortable: false,
                    menuDisabled:true,
                    renderer: function (value, metadata, record) {
                        return value;
                    }
                },
                { 
                    text: '姓名',
                    dataIndex: 'truename',
                    width: '10%',
                    align: 'center',
                    border:0,
                    sortable: false,
                    menuDisabled:true,
                    renderer: function (value, metadata, record) {
                        return value;
                    }
                },
                { 
                    text: '手机号码',
                    dataIndex: 'mobile',
                    width: '13%',
                    align: 'center',
                    border:0,
                    sortable: false,
                    menuDisabled:true,
                    renderer: function (value, metadata, record) {
                        return value;
                    }
                },
                { 
                    text: '邮件',
                    dataIndex: 'email',
                    width: '15%',
                    align: 'center',
                    border:0,
                    sortable: false,
                    menuDisabled:true,
                    renderer: function (value, metadata, record) {
                        return value;
                    }
                },
                { 
                    text: '证件号码',
                    dataIndex: 'cardid',
                    width: '17%',
                    align: 'center',
                    border:0,
                    sortable: false,
                    menuDisabled:true,
                    renderer: function (value, metadata, record) {
                        return value;
                    }
                },
                { 
                    text: '上次登录时间',
                    dataIndex: 'logintime',
                    width: '15%',
                    align: 'center',
                    border:0,
                    sortable: false,
                    menuDisabled:true,
                    renderer: function (value, metadata, record) {
                    	if (value==0) {
                    		return '从未登录'
                    	}else{
                    		return formatDate(value);
                    	}
                        
                    }
                },
                { 
                    text: '地址',
                    dataIndex: 'address',
                    width: '25%',
                    align: 'center',
                    border:0,
                    sortable: false,
                    menuDisabled:true,
                    renderer: function (value, metadata, record) {
                        return value;
                    }
                }
            ],
            width: $('#user-main-box').css('width'),
            renderTo: 'user-main-box'
        });
    }
});
	$(function() {
		//导航选中
        $("#nav_traveler").addClass('on');
        $('#export').click(function(event) {
        	/* Act on the event */
        	var url="/distributor/pc/traveler/genexcel/"+$("#starttime").val()+"/"+$("#endtime").val();
        	window.open(url);
        });
	});
	function formatDate(timestamp) {
        var date = new Date(parseInt(timestamp)*1000);//时间戳为10位需*1000，时间戳为13位的话不需乘1000
        Y = date.getFullYear() + '-';
        M = (date.getMonth()+1 < 10 ? '0'+(date.getMonth()+1) : date.getMonth()+1) + '-';
        D = date.getDate()<10?'0'+date.getDate():date.getDate();
        if (date.getHours()<10) {
            h = '0'+date.getHours() + ':';
        }else{
            h = date.getHours() + ':';
        }
        if (date.getMinutes()<10) {
            m='0'+date.getMinutes()+':';
        }else{
            m = date.getMinutes() + ':';
        }
        if (date.getSeconds()<10) {
            s='0'+date.getSeconds();
        }else{
            s = date.getSeconds();
        }
        return Y+M+D+' '+h+m+s;
     }
</script>

</body>
</html>
