<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>优惠券添加/修改</title>
<?php echo  Stourweb_View::template('stourtravel/public/public_js');  ?>
<?php echo Common::getCss('style.css,base.css,base_new.css'); ?>
<?php echo Common::getScript("uploadify/jquery.uploadify.min.js,product_add.js,choose.js,imageup.js,DatePicker/WdatePicker.js"); ?>
</head>
<body>
    <table class="content-tab">
        <tr>
            <td width="119px" class="content-lt-td"  valign="top">
                <?php echo  Stourweb_View::template('stourtravel/public/leftnav');  ?>
                <!--右侧内容区-->
            </td>
            <td valign="top" class="content-rt-td">
                <form method="post" name="product_frm" id="product_frm">
                    <div class="cfg-header-bar">
                        <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
                    </div>
                    <div class="product-add-div">
                        <ul class="info-item-block">
                            <li>
                                <span class="item-hd">优惠券名称：</span>
                                <div class="item-bd">
                                    <div>
                                        <a href="javascript:;" class="fl btn btn-primary radius size-S mt-3" onclick="add_product.getcoupon(this,'.attr-sel',1)" title="选择">选择</a>
                                        <div class="save-value-div ml-10 couponid-sel">
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <span class="item-hd">赠送数量：</span>
                                <div class="item-bd">
                                    <input type="number" name="sendnum" class="input-text w100" value="1">&nbsp;&nbsp;张 <span style="color: #15b000" id="leftnum"></span>
                                </div>
                            </li>
                            <li>
                                <span class="item-hd">选择会员：</span>
                                <div class="item-bd">
                                    <div>
                                        <a href="javascript:;" class="fl btn btn-primary radius size-S mt-3" onclick="add_product.getmember(this,'.attr-sel',1)" title="选择">选择</a>
                                        <div class="save-value-div ml-10 members-sel">
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="clear clearfix p5-20 pb-20">
                        <a class="btn btn-primary radius size-L ml-115" id="btn_save" href="javascript:;">保存</a>
                    </div>
                </form>
            </td>
        </tr>
    </table>
<script>
        add_product = {
            getcoupon:function(dom,selector)
            {
                var couponid = $('input[name=couponid]').val();
                var params={loadCallback: add_product.listgetcoupon,loadWindow:window};
                var url= SITEURL+'coupon/admin/coupon/member_give?action=dialog_getcoupon&couponid='+couponid+'&selector='+encodeURI(selector)
                ST.Util.showBox('选择优惠券',url,'900','600',null,null,document,params);
            },
            listgetcoupon:function(result,bool)
            {
                var data = result.data
                var html = ' <span style="display: inline-block; float: none"><s onclick="$(this).parent(\'span\').remove()"></s>'+data[1]+'<input type="hidden" name="couponid" value="'+data[0]+'"></span>';
                $('#leftnum').text('剩余'+data[2]+'张')
                $('.couponid-sel').html(html)
            },
            getmember:function()
            {
                var memberid = [];
                $('.members-sel input:hidden').each(function(index,obj){
                    memberid.push($(obj).val())
                });
                memberid = memberid.join(',');
                var params={loadCallback: add_product.listgetmember,loadWindow:window};
                var url= SITEURL+'coupon/admin/coupon/member_give?action=dialog_getmember&memberid='+memberid
                ST.Util.showBox('选择会员',url,'900','600',null,null,document,params);
            },
            listgetmember:function(result,bool){
                $('.members-sel').html(result.html)
            }
        };
$(document).ready(function(){
        $('input[name=isnever]').click(function(){
            var val = $(this).val();
            if(val>0)
            {
                $('.isneverspan').show();
            }
            else
            {
                $('.isneverspan').hide();
            }
        });
        $('input[name=typeid]').click(function(){
            var val = $(this).val();
            if(val==1)
            {
                $('.typeid_1').css('display','inline-block')
                $('.typeid_9999').hide();
            }
            else if(val==9999)
            {
                $('.typeid_9999').each(function(index,obj){
                    if($(obj).hasClass('apply-tab-wrap'))
                    {
                        $(obj).show()
                    }
                    else
                    {
                        $(obj).css('display','inline-block')
                    }
                })
                $('.typeid_1').hide();
            }
            else
            {
                $('.typeid_1').hide();
                $('.typeid_9999').hide();
            }
        })
        //保存
        $("#btn_save").click(function(){
               var couponid = $("input[name=couponid]").val();
               var sendnum = $("input[name=sendnum]").val();
               var memberlenth = $('.members-sel input:hidden').length
            //验证名称
             if(couponid==''||sendnum<1||memberlenth<1)
             {
                   ST.Util.showMsg('请完善赠送信息',5,2000);
             }
             else
             {
                   Ext.Ajax.request({
                       url   :  SITEURL+"coupon/admin/coupon/ajax_save_member_give",
                       method  :  "POST",
                       isUpload :  true,
                       form  : "product_frm",
                       datatype  :  "JSON",
                       success  :  function(response, opts)
                       {
                           ST.Util.showMsg('保存成功!','4',1000);
                           setTimeout(function(){
                               $('.couponid-sel').remove();
                               $('.members-sel').remove();
                               $('#leftnum').text('')
                           },1000)
                       }});
               }
        })
     });
    </script>
<script>
    $(function(){
        //日历选择
        $(".choosetime").click(function(){
           WdatePicker({skin:'whyGreen',dateFmt:'yyyy-MM-dd HH:mm:ss',minDate:'%y-%M-%d',maxDate: '#{%y+2}-%M-%d'})
        });
        get_product_list();
        $('#search_btn').click(function(){
            get_product_list();
        })
    })
</script>
<!--    产品信息-->
    <script>
       function   togStatus(obj)
       {
           get_product_list();
       }
        function get_product_list()
        {
            var id = $('#couponid').val();
            var keyword = $("#search_input").val();
            var typeid = $('#search_typeid').val();
            if(!id)
            {
                return false;
            }
            $.ajax({
                type:'get',
                dataType:'json',
                data:{id:id,page:1,keyword:keyword,typeid:typeid},
                url:  SITEURL+"coupon/admin/coupon/pro_list",
                success:function(result)
                {
                    genList(result);
                }
            })
        }
        function loadProducts(page)
        {
            var id = $('#couponid').val();
            var url = SITEURL+"coupon/admin/coupon/pro_list";
            var keyword = $("#search_input").val();
            $.ajax({
                type: "get",
                url: url,
                dataType: 'json',
                data: {page: page,id:id,keyword:keyword,typeid:typeid},
                success: function (result, textStatus){
                    genList(result);
                }
            });
        }
        function genList(result)
        {
            var html='';
            for(var i in result.lists)
            {
                var row=result.lists[i];
                html+='<tr class="tb-item">' +
                    '<td>'+row['bh']+'</td>'+
                    '<td>'+row['typename']+'</td>'+
                    '<td>'+row['protitle']+'</td>'+
                    '<td><a class="delete" href="javascript:;" onclick="delRow(this,'+row.id+')" >移除</a></td></tr>';
            }
            $("#dlg_tb .tb-item").remove();
            $("#dlg_tb").append(html);
            var pageHtml = ST.Util.page(result.pagesize, result.page, result.total, 5);
            $("#page_info").html(pageHtml);
            $("#page_info a").click(function () {
                var page = $(this).attr('page');
                loadProducts(page);
            });
        }
        function delRow(dom,id)
        {
            ST.Util.confirmBox('提示','确定删除吗?',function(){
                if(id==0)
                    $(dom).parents('tr').first().remove();
                else
                {
                    Ext.Ajax.request({
                        url   :  SITEURL+"coupon/admin/coupon/add_product/action/del",
                        method  :  "POST",
                        params:{id:id},
                        success  :  function(response, opts)
                        {
                            var text = response.responseText;
                            if(text=='ok')
                            {
                                get_product_list();
                            }
                            else
                            {
                                ST.Util.showMsg("<?php echo __('norightmsg');?>",5,1000);
                            }
                        }});
                }
            });
        }
    </script>
</body>
</html>
