<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>笛卡CMS{$coreVersion}</title>
    {php echo Common::css('base.css'); }
    {php echo Common::css('extjs/resources/ext-theme-neptune/ext-theme-neptune-all-debug-user.css'); }
    {php echo Common::css('msgbox/msgbox.css'); }
    {php echo Common::js("jquery.min.js,choose.js,msgbox/msgbox.js,extjs/ext-all.js,extjs/locale/ext-lang-zh_CN.js,jquery.buttonbox.js,common_ext.js"); }
    {Common::css_plugin('distributor.css','distributor')}
    {Common::js_plugin('distributor.js','distributor')}
    <style type="text/css">
        .select{
            float: left;
            display: inline-block;
            height: 30px;
            margin: 5px 10px 0 0;
        }
        table td th tr{
            background:transparent;
        }
        .listPagePanel-body{
            height: 25px;
        }
        .pageContainer .pagePart .floor{
            position: relative;
            height: 20px;
            width: 20px;
            line-height:20px;
            top: 1px;
            padding-left: 5px;
        }
        div.cfg-header-search{
            float: right;
        }

    </style>
</head>
<body style="overflow:hidden;">
    <table class="content-tab">
        <tr>
            <td valign="top" class="content-rt-td">

                <div class="cfg-header-bar">
                    <span class="select-box w150 mt-5 fl">
                        <select class="select" name="province" id="province"></select>
                    </span>
                    <span class="select-box w150 mt-5 ml-10 fl">
                        <select class="select" name="city" id="city"></select>
                    </span>
                    <div class="cfg-header-search">
                        <input type="text" style="width: 140px;" id="searchkey" placeholder="名称/联系人/手机号" value="" class="search-text" />
                        <a href="javascript:;" id="search-btn" class="search-btn">搜索</a>
                        <a href="javascript:;" id="confire-btn" style="pointer-events: none;" class="search-btn">确定</a>
                    </div>
                    <!-- <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a> -->
                    <!-- <a href="javascript:;" id="btn_bind" class="fr btn btn-primary radius mt-6 mr-10" >绑定</a> -->
                </div>
                <div id="product_grid_panel" class="content-nrt" style="width: 100%;">

                </div>
            </td>
        </tr>
    </table>
    <script>
Ext.application({
    name: 'drawgrid',
    launch: function() {
        Ext.tip.QuickTipManager.init();
        // 建立一个store要使用的 model
        Ext.define('distributor', {
            extend: 'Ext.data.Model',
            fields: [
                { name: 'mid', type: 'string' },
                { name: 'nickname', type: 'string' },
                { name: 'truename', type: 'string' },
                { name: 'phone', type: 'string' },
                { name: 'mobile', type: 'string' },
                { name: 'address', type: 'string' }
            ]
        });

        window.product_store = Ext.create('Ext.data.Store', {
            model: 'distributor',
            proxy: {
                type: 'ajax',
                url: '/distributor/pc/distributor/pageload',
                reader: {
                    type: 'json',
                    root: 'lists',
                    totalProperty: 'total'
                },
                extraParams:{
                    city: ''
                }
            },
            remoteSort: true,
            pageSize: 5,
            autoLoad: true,
            listeners: {
                load: function(store, records, successful, eOpts) {
                    if (!successful) {
                        ST.Util.showMsg("{__('norightmsg')}", 5, 1000);
                        return;
                    }
                    if (records.length==0 && store.proxy.extraParams['city']!='' && $('#searchkey').val()=='') {
                        // 当前城市没有服务网点
                        ST.Util.showMsg("非常抱歉，"+store.proxy.extraParams['city']+"本公司没有服务网点。", 5, 5000);
                    }else if(records.length==0 && store.proxy.extraParams['city']!='' && $('#searchkey').val()!=''){
                        // 当前城市搜索为空
                        ST.Util.showMsg("没有搜索到相关服务网点信息。", 5, 5000);
                    }
                    var pageHtml = ST.Util.page(store.pageSize, store.currentPage, store.getTotalCount(), 10);
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
                    text: '选择',
                    width: '10%',
                        // xtype:'templatecolumn',
                    tdCls: 'product-ch',
                    align: 'center',
                    dataIndex: 'mid',
                    menuDisabled: true,
                    sortable: false,
                    border:0,
                    renderer: function(value, metadata, record) {
                            return "<input type='radio' class='product_check' style='cursor:pointer' id='box' name='box' onclick='radioclick(this)' value='" + value + "'/>";
                        }
                },
                { 
                    text: '服务点名称',
                    dataIndex: 'nickname',
                    width: '35%',
                    align: 'center',
                    border:0,
                    sortable: false,
                    menuDisabled:true,
                    renderer: function (value, metadata, record) {
                        return value;
                    }
                },
                { 
                    text: '联系人',
                    dataIndex: 'truename',
                    width: '20%',
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
                    width: '35%',
                    align: 'center',
                    border:0,
                    sortable: false,
                    menuDisabled:true,
                    renderer: function (value, metadata, record) {
                        return value;
                    }
                }
            ],
            width: Ext.dom.AbstractElement.getViewportWidth(),
            renderTo: 'product_grid_panel'
        });
        // //实现动态窗口大小
        // Ext.EventManager.onWindowResize(function() {
        //     var height = Ext.dom.Element.getViewportHeight()-76;
        //     var width = Ext.dom.Element.getViewportWidth()-119;
        //     window.product_grid.maxHeight = height;
        //     window.product_grid.maxWidth = width;
        //     console.log(width);
        //     console.log(height);
        //     window.product_grid.doLayout();
        // })
        //添加按钮
        // $("#btn_bind").click(function() {
        //     ajax_bind();
        // });
    }
});
var frm=$('.on',window.parent.document).attr('data-type');
        $(function() {
            initSelect($('#province'));
            $('#province').change(function(event) {
                /* Act on the event */
                initSelect($('#city'));
            });
            $('#city').change(function(event) {
                /* Act on the event */
                window.product_store.getProxy().setExtraParam('city',$("#city").val());
                window.product_store.load()
            });
            $('#search-btn').click(function(event) {
                /* Act on the event */
                search();
            });
            $('#confire-btn').click(function(event) {
                /* Act on the event */
                window.parent.d.close();

            });
        });
        window.onload = function() {
            initSelect($('#city'));
        }

        // function ajax_bind() {
        //     var mid =$("#mid").val();
        //     var bid =$("input[name='box']:checked").val();
        //     if (mid==undefined || bid==undefined) {
        //         ST.Util.showMsg('请选择服务网点。', '2', 2000);
        //         return;
        //     }
        //     $.ajax({
        //         url: '/distributor/pc/distributor/ajax_bind',
        //         method: "POST",
        //         dataType: 'json',
        //         data:{"mid":'"'+mid+'"',"bid":'"'+bid+'"'},
        //     })
        //     .done(function(data) {
        //             if (data.status) {
        //                 ST.Util.showMsg(data.msg, '4', 2000);
        //                 setTimeout('window.parent.location.reload()',3000);
        //             } else {
        //                 ST.Util.showMsg(data.msg, '5', 2000);
        //             }
        //     })
        // }

        function initSelect(ele) {
            var opt = [];
            $.getJSON('/res/json/pc.json', function(json, textStatus) {
                /*optional stuff to do after success */
                if ($(ele).attr('id') == 'province') {
                    $.each(json, function(index, val) {
                        /* iterate through array or object */
                        opt.push('<option value="' + index + '">' + index + '</option>');
                    });
                } else {
                    $.each(json, function(index, val) {
                        /* iterate through array or object */
                        if (index == $('#province').val()) {
                            opt.push('<option value="">请选择城市</option>');
                            $.each(val, function(i, v) {
                                /* iterate through array or object */
                                    opt.push('<option value="' + v + '">' + v + '</option>');
                            });
                        }
                    });
                }
                $(ele).html(opt.join(''));
            });
            $('.x-grid-td').css('background', 'transparent');
            return true;
        }
        function radioclick(ele) {
            // body...
            $('#'+frm+'did',window.parent.document).val($(ele).val());
            var name = $(ele).parent('div').parent('td').next('td').text();
            $('#'+frm+'didname',window.parent.document).val(name);
            $('#confire-btn').css({
                'pointer-events':'auto',
                'background': '#0082dd'
            });

        }
        function search() {
            if ($('#city').val()!='') {
                CHOOSE.searchKeyword();
            }else{
                ST.Util.showMsg("请选择城市后再进行搜索。", 5, 5000);
            }
        }
    </script>
</body>

</html>