<?php defined('SYSPATH') or die();?>
{template 'stourtravel/public/public_js'}
{php echo Common::getCss('style.css,base.css,base2.css,plist.css,inlinegrid.css'); }
{php echo Common::getScript("uploadify/jquery.uploadify.min.js,product_add.js,choose.js,imageup.js,jquery.buttonbox.js"); }
<style>
    .sel_model{

        float: left;
        margin-top:5px

    }
    .normal-btn
    {
        margin-left: 40%;
    }

</style>
<dl>
    <select name="status" onchange="togStatus(this)" class="sel_model">
        {loop $models $m}
        <option value="{$m['id']}" > {$m['modulename']}</option>
        {/loop}
    </select>
</dl>
<div class="pro-search ml-10 mt-4 fl mt-4">

    <input type="text" id="searchkey" value="" placeholder="请输入关键词"class="sty-txt1 set-text-xh wid_200">
    <a href="javascript:;" class="head-search-btn" onclick="CHOOSE.searchKeyword()"></a>
</div>

    <div id="freekefu_panel" style="line-height: 20px;" >
    </div>
<input type="hidden" id="couponid" value="{$couponid}">
<a class="normal-btn ml-20" id="btn_save" href="javascript:;">确定</a>

<script>

    //关联产品列表
    Ext.onReady(
        function () {

            Ext.tip.QuickTipManager.init();
            //产品store
            window.product_store = Ext.create('Ext.data.Store', {

                fields: [
                    'id',
                    'title',
                    'bh',
                    'typename'
                ],
                proxy: {
                    type: 'ajax',
                    extraParams: {cid: $('#couponid').val()},
                    api: {
                        read: SITEURL+'coupon/admin/coupon/add_product/action/read/',  //读取数据的URL
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
                            width: 170,
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
                            listeners:{
                                select:CHOOSE.changeNum
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
                columns: [

                    {
                        text: '产品编号',
                        width: '20%',
                        dataIndex: 'bh',
                        align: 'left',
                        border: 0,
                        sortable: false,
                        menuDisabled:true,
                        renderer: function (value, metadata, record) {

                            return value;
                        }

                    },

                    {
                        text: '产品类型',
                        width: '20%',
                        cls:'sort-col',
                        dataIndex: 'typename',
                        align: 'left',
                        border: 0,
                        sortable: true,
                        menuDisabled:true,
                        renderer: function (value, metadata, record) {
                            return value;
                        }

                    },
                    {
                        text: '产品名称',
                        width: '40%',
                        cls:'sort-col',
                        dataIndex: 'title',
                        align: 'left',
                        border: 0,
                        sortable: true,
                        menuDisabled:true,
                        renderer: function (value, metadata, record) {

                            return value;
                        }
                    },
                    {
                        text: '选择',
                        width: '20%',
                        align: 'center',
                        border: 0,
                        sortable: false,
                        cls: 'mod-1',
                        menuDisabled:true,
                        renderer: function (value, metadata, record) {

                            var id = record.get('id');
                            var title = record.get('title');
                            var typeid = $('.sel_model').val();
                            var checked = '';
                            $.each(data,function(index,one){
                                if(typeid==one[0]&&id==one[1])
                                {
                                    checked = 'checked';
                                    return false ;
                                }
                                else
                                {
                                     checked ='';
                                }
                            })
                            var html = '<input type="checkbox" class="product_check" name="proid" style="cursor:pointer"  data-name="'+title+'" '+checked+' value="'+id+'">';
                            return html;
                        }

                    }

                ],

            });
        })

    function togStatus(ele)
    {
        var typeid=$(ele).val();
        window.product_store.getProxy().setExtraParam('typeid',typeid);
        window.product_store.loadPage(1);

    }
</script>
<script>
    var data = [];

    $(function(){

        $('body').css( 'background' ,'white');
        $('body').on('click','.product_check',function(){
            var typeid = $('.sel_model').val();
            var proid = $(this).val();
            var protitle = $(this).attr('data-name');
            if($(this).is(':checked'))
            {
                var pro = [];
                pro.push(typeid,proid,protitle);
                data.push(pro)
            }
            else
            {
                $.each(data,function(index,one){
                   if(typeid==one[0]&&proid==one[1])
                   {
                       data.splice(index, 1);
                   }
                })
            }


        });



        $(document).on('click','#btn_save',function(){
           var subdata = [];
            $.each(data,function(index,one){
                subdata.push(one.join('_'));
            })
            var id = $('#couponid').val();
            Ext.Ajax.request({
                url   :  SITEURL+"coupon/admin/coupon/ajax_prolist_save",
                method  :  "POST",
                datatype  :  "JSON",
                params:{id:id,subdata:subdata.join(',')},
                success  :  function(response, opts)
                {
                    ST.Util.showMsg('保存成功','4',1000);
                    setTimeout(function(){
                        ST.Util.responseDialog(null,true);
                    },1000)

                }});
        });
    })

</script>