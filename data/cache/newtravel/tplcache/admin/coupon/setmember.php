<?php defined('SYSPATH') or die();?>
<?php echo  Stourweb_View::template('stourtravel/public/public_js');  ?>
<?php echo Common::getCss('style.css,base.css,base2.css,plist.css,inlinegrid.css'); ?>
<?php echo Common::getScript("uploadify/jquery.uploadify.min.js,product_add.js,choose.js,imageup.js"); ?>
<style>
   .kind-title{
       font-size: 15px;
   }
   .x-body
   {
       background: white;
   }
   body
   {
       background: white;
   }
</style>
<div class="pro-search ml-10 mt-4 fl mt-4">
    <input type="text" id="searchkey" value="" placeholder="昵称/真实姓名/手机号/邮箱"class="sty-txt1 set-text-xh wid_200">
    <a href="javascript:;" class="head-search-btn" onclick="CHOOSE.searchKeyword()"></a>
</div>
<div id="freekefu_panel" style="line-height: 20px;" >
</div>
<input type="hidden" id="typeid" value="<?php echo $typeid;?>">
<input type="hidden" id="productid" value="<?php echo $productid;?>">
<div class="product-add-div">
    <div class="add-class">
        <dl>
            <dt style="width:110px">已选择会员：</dt>
            <dd>
                <div class="save-value-div mt-2 ml-10 insurance-sel">
                    <?php $n=1; if(is_array($memberlist)) { foreach($memberlist as $member) { ?>
                                     <span style="display: inline-block;float: none" onclick="$(this).parent('span').remove()" >
                                         <s onclick="remove_span(this)"></s>
                                         <?php echo $member['nickname'];?>(<?php echo $member['truename'];?>)
                                         <input type="hidden" name="memberid[]" value="<?php echo $member['mid'];?>">
                                     </span>
                    <?php $n++;}unset($n); } ?>
                </div>
            </dd>
        </dl>
    </div>
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
                    'mid',
                    'nickname',
                    'truename',
                    'cardid',
                    'mobile',
                    'email',
                    'ordernum',
                    'check',
                ],
                proxy: {
                    type: 'ajax',
                    extraParams: {typeid: '<?php echo $typeid;?>',productid:'<?php echo $productid;?>',planids:'<?php echo $planids;?>'},
                    api: {
                        read: SITEURL+'coupon/admin/coupon/member_give?action=dialog_getmember&method=read&memberid=<?php echo $memberid;?>',  //读取数据的URL
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
                columns: [
                    {
                        text: '会员昵称',
                        width: '18%',
                        dataIndex: 'nickname',
                        align: 'left',
                        border: 0,
                        sortable: false,
                        menuDisabled:true,
                        renderer: function (value, metadata, record) {
                            return value;
                        }
                    },
                    {
                        text: '真实姓名',
                        width: '10%',
                        dataIndex: 'truename',
                        align: 'left',
                        border: 0,
                        sortable: false,
                        menuDisabled:true,
                        renderer: function (value, metadata, record) {
                            return value;
                        }
                    },
                    {
                        text: '身份证',
                        width: '18%',
                        dataIndex: 'cardid',
                        align: 'left',
                        border: 0,
                        sortable: false,
                        menuDisabled:true,
                        renderer: function (value, metadata, record) {
                            return value;
                        }
                    },
                    {
                        text: '手机号',
                        width: '18%',
                        dataIndex: 'mobile',
                        align: 'left',
                        border: 0,
                        sortable: false,
                        menuDisabled:true,
                        renderer: function (value, metadata, record) {
                            return value;
                        }
                    },
                    {
                        text: '邮箱',
                        width: '18%',
                        dataIndex: 'email',
                        align: 'left',
                        border: 0,
                        sortable: false,
                        menuDisabled:true,
                        renderer: function (value, metadata, record) {
                            return value;
                        }
                    },
                    {
                        text: '购买次数',
                        width: '8%',
                        dataIndex: 'ordernum',
                        align: 'left',
                        border: 0,
                        sortable: false,
                        menuDisabled:true,
                        renderer: function (value, metadata, record) {
                            return value+'次';
                        }
                    },
                    {
                        text: '选择',
                        width: '10%',
                        align: 'center',
                        border: 0,
                        sortable: false,
                        cls: 'mod-1',
                        menuDisabled:true,
                        renderer: function (value, metadata, record) {
                            var id = record.get('mid');
                            var nickname = record.get('nickname');
                            var truename = record.get('truename');
                            var check = record.get('check');
                            var checked = null;
                            if(check==1)
                            {
                                checked = 'checked="checked"';
                            }
                            nickname += '('+truename+')';
                            var html = '<input type="checkbox"'+checked+' onclick="check_member(this)" class="product_check" name="planlist" style="cursor:pointer"  data-name="'+nickname+'"  value="'+id+'">';
                            return html;
                        }
                    }
                ],
            });
        })
    function check_member(obj)
    {
        var memberid = $(obj).val();
        var title = $(obj).attr('data-name');
        var checked = $(obj).attr('checked');
        if(checked=='checked')
        {
            var html = ' <span style="display: inline-block;float: none" ><s onclick="$(this).parent(\'span\').remove()"></s>'+title+'<input type="hidden" name="memberid[]" value="'+memberid+'"></span>'
            $('.insurance-sel').append(html);
        }
        else
        {
            $('.insurance-sel input').each(function(k,input){
                if($(input).val()==planid)
                {
                    $(input).parent('span').remove();
                }
            })
        }
    }
    function remove_span(obj)
    {
        $(obj).parent('span').remove();
        var planid = $(obj).parent('span').find('input').val();
        $('input[name=planlist]').each(function(k,input){
            if($(input).val()==planid)
            {
                $(input).prop('checked',false);
            }
        })
    }
</script>
<script>
    $(function(){
        $(document).on('click','#btn_save',function()
        {
            var html = $('.insurance-sel').html();
            ST.Util.responseDialog({html:html},true);
        });
    })
</script>