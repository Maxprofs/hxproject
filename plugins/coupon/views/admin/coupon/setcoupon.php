<?php defined('SYSPATH') or die();?>
{template 'stourtravel/public/public_js'}
{php echo Common::getCss('style.css,base.css,base2.css,plist.css,inlinegrid.css'); }
{php echo Common::getScript("uploadify/jquery.uploadify.min.js,product_add.js,choose.js,imageup.js"); }

<style>
   body
   {

   }
</style>

<div class="pro-search ml-10 mt-4 fl mt-4">
    <input type="text" id="searchkey" value="" placeholder="优惠券名称"class="sty-txt1 set-text-xh wid_200">
    <a href="javascript:;" class="head-search-btn" onclick="CHOOSE.searchKeyword()"></a>
</div>

<div id="freekefu_panel" style="line-height: 20px;" >
</div>
<a class="normal-btn ml-20"  style="margin-left:45%" id="btn_save" href="javascript:;">确定</a>

<script>

    //关联产品列表
    Ext.onReady(
        function () {

            Ext.tip.QuickTipManager.init();
            //产品store
            window.product_store = Ext.create('Ext.data.Store', {

                fields: [
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
                    'send_and_total',
                    'leftnum',
                ],
                proxy: {
                    type: 'ajax',
                    extraParams: {},
                    api: {
                        read: SITEURL+'coupon/admin/coupon/member_give?action=dialog_getcoupon&method=read',  //读取数据的URL
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
            window.product_grid = Ext.create('Ext.grid.Panel', {
                store: product_store,
                renderTo: 'freekefu_panel',
                border: 0,
                width: "900px",
                bodyBorder: 0,
                bodyStyle: 'border-width:0px',
                scroll:'vertical', //只要垂直滚动条
                bbar: Ext.create('Ext.toolbar.Toolbar', {
                    store: product_store,  //这个和grid用的store一样
                    displayInfo: true,
                    emptyMsg: "",
                    items: [
                        {
                            xtype:'panel',
                            id:'listPagePanel',
                            html:'<div id="line_page"></div>'
                        },
                        {
                            xtype: 'combo',
                            fieldLabel: '每页显示数量',
                            width: 200,
                            labelAlign: 'right',
                            forceSelection: true,
                            value: 10,
                            store: {fields: ['num'], data: [
                                {num: 10},
                                {num: 30},
                                {num: 60}
                            ]},
                            displayField: 'num',
                            valueField: 'num',
                            listeners: {
                                select: CHOOSE.changeNum
                            }
                        }

                    ],
                    listeners: {
                        single: true,
                        render: function (bar) {
                            var items = this.items;
                            bar.insert(0, Ext.create('Ext.panel.Panel', {border: 0, html: '<div class="panel_bar"></div>'}));
                            bar.insert(1, Ext.create('Ext.toolbar.Fill'));
                        }
                    }

                }),
                columns:[

                    {
                        text:'优惠券名称',
                        width:'20%',
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
                        width:'20%',
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
                        width:'20%',
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
                        width:'10%',
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
                        text:'已领/发放张数',
                        width:'22%',
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
                        text: '选择',
                        width: '8%',
                        // xtype:'templatecolumn',
                        tdCls: 'product-ch',
                        align: 'center',
                        dataIndex: 'id',
                        menuDisabled:true,
                        border: 0,
                        renderer: function (value, metadata, record) {
                            var name=record.get('name');
                            var leftnum=record.get('leftnum');
                            var checked = '';
                            if(value=='{$couponid}')
                            {
                                checked = 'checked'
                            }
                            return  "<input type='radio'  "+checked+"  name='couponid' data-leftnum='"+leftnum+"' data-title='"+name+"' class='product_check' style='cursor:pointer' value='" + value + "'/>";
                        }

                    },
                ],


            });
        })


</script>

<script>
    $(function(){
        $('body').css('background','white')
        $(document).on('click','#btn_save',function()
        {
            var obj = $('.product_check:checked');
            var couponid = $(obj).val();
            var title = $(obj).attr('data-title');
            var leftnum = $(obj).attr('data-leftnum');
            var data=[];
            data.push(couponid)
            data.push(title)
            data.push(leftnum)
            ST.Util.responseDialog({data:data},true);
        });
    })
</script>