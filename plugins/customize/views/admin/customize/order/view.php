<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>查看订单</title>
    {template 'stourtravel/public/public_min_js'}
    {Common::getCss('style.css,base.css,order-manage.css,base_new.css')}
    {Common::getScript("jquery.validate.js,choose.js")}
    {Common::getScript("product_add.js,choose.js,imageup.js")}
    {Common::getScript('jquery.upload.js')}
    <script>
        window.CURRENCY_SYMBOL="{Currency_Tool::symbol()}";
    </script>
    <style>
        #linedoc-content{line-height: 30px; clear: both;}
        #linedoc-content span{ padding-right:5px;}
        #linedoc-content a.del{ color: #f00;margin: 0 5px;}
        #linedoc-content a.del:hover{text-decoration:underline }
    </style>
</head>
<body>
<table class="content-tab">
    <tr>
        <td width="119px" class="content-lt-td"  valign="top">
            {template 'stourtravel/public/leftnav'}
            <!--右侧内容区-->
        </td>
        <td valign="top" class="content-rt-td" style="overflow-y: hidden">
       <form method="post" id="frm" name="frm">

        <div class="order-info-container">
            <div class="order-info-bar">
                <strong class="bt-bar">订单信息</strong>
                <a href="javascript:;" class="fr btn btn-primary radius mt-2 mr-10" onclick="window.location.reload()">刷新</a>
            </div>
            <div class="order-info-block">
                <ul>
                  <li>
                        <span class="item-hd">订单号：</span>
                        <div class="item-bd">
                            <span class="order-num">{$order_info['ordersn']}</span>
                        </div>
                    </li>
                    <li>
                        <span class="item-hd">预订会员：</span>
                        <div class="item-bd">
                            {if !empty($info['membername'])}
                            <span class="order-num">{$info['membername']}</span>
                            {/if}
                        </div>
                    </li>
                   <!-- <li>
                        <span class="item-hd">供应商：</span>
                        <div class="item-bd">
                            {if $order_info['status']==0}
                            <a href="javascript:;" class="choose-btn mt-4 supplier-cs" onclick="Product.getSupplier(this,'.supplier-sel')"  title="选择">选择</a>
                                {if !empty($info['supplier_arr']['id'])}
                                  <span class="choose-child-item ml-10">{$info['supplier_arr']['suppliername']}<input type="hidden" name="supplierlist[]" value="{$info['supplier_arr']['id']}" /><i class="close-icon del-supplier" data-id="{$info['supplier_arr']['id']}" ></i></span>
                                {/if}
                            {else}
                                  <span class="order-num">{$info['supplier_arr']['suppliername']}</span>
                            {/if}
                        </div>
                    </li>-->
                </ul>
            </div>
        </div>
           <!-- 订单信息 -->

        <div class="order-info-container">
            <div class="order-info-bar"><strong class="bt-bar">联系人信息</strong></div>
            <div class="order-info-block">
                <ul>
                    <li>
                        <span class="item-hd">联系人姓名：</span>
                        <div class="item-bd">
                            <span class="order-num">{$info['contactname']}</span>

                        </div>
                    </li>
                    <li>
                        <span class="item-hd">联系人电话：</span>
                        <div class="item-bd">
                            <span class="order-num">{$info['phone']}</span>
                        </div>
                    </li>
                    <li>
                        <span class="item-hd">联系人邮箱：</span>
                        <div class="item-bd">
                            <span class="order-num">{$info['email']}</span>
                        </div>
                    </li>
                    <li>
                        <span class="item-hd">预订说明：</span>
                        <div class="item-bd">
                            <span class="order-num">{$info['content']}</span>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

           <div class="order-info-container">
               <div class="order-info-bar"><strong class="bt-bar">旅行计划</strong></div>
               <div class="order-info-block">
                   <ul>
                       <li>
                           <span class="item-hd">出发日期：</span>
                           <div class="item-bd">
                               <span class="order-num">{if !empty($info['starttime'])}{date('Y-m-d',$info['starttime'])}{/if}</span>

                           </div>
                       </li>
                       <li>
                           <span class="item-hd">出游天数：</span>
                           <div class="item-bd">
                               <span class="order-num">{$info['days']}</span>
                           </div>
                       </li>
                       <li>
                           <span class="item-hd">目的地：</span>
                           <div class="item-bd">
                               <span class="order-num">{$info['dest']}</span>
                           </div>
                       </li>
                       <li>
                           <span class="item-hd">出发地：</span>
                           <div class="item-bd">
                               <span class="order-num">{$info['startplace']}</span>
                           </div>
                       </li>
                       <li>
                           <span class="item-hd">成人数：</span>
                           <div class="item-bd">
                               <span class="order-num">{$info['adultnum']}</span>
                           </div>
                       </li>
                       <li>
                           <span class="item-hd">儿童数：</span>
                           <div class="item-bd">
                               <span class="order-num">{$info['childnum']}</span>
                           </div>
                       </li>
                       {php $extend_fields=Model_Customize_Extend_Field_Desc::get_fields();}

                       {loop $extend_fields $field}
                       <li>
                           <span class="item-hd">{$field['chinesename']}：</span>
                           <div class="item-bd">
                               <span class="order-num">{$extend_info[$field['fieldname']]}</span>
                           </div>
                       </li>
                       {/loop}
                   </ul>
               </div>
           </div>
           {if $order_info['status']==0}
           <div class="order-info-container">
               {php Common::getEditor('jseditor','',$sysconfig['cfg_admin_htmleditor_width'],300,'Sline','','print',true);}
               <div class="order-info-bar"><strong class="bt-bar">旅行方案</strong></div>
               <div class="order-info-block">
                   <ul>

                       <li>
                           <span class="item-hd">方案参考：</span>
                           <div class="item-bd">
                               <a href="javascript:;" class="btn btn-primary radius size-S va-t mt-3" id="choose_plan" title="选择">选择</a>
                               <span id="case_plan" class="order-num ml-5"></span>
                           </div>
                       </li>
                       <li>
                           <span class="item-hd">方案标题：</span>
                           <div class="item-bd">
                               <input type="text" class="default-text wid_460" id="case_title" name="title" placeholder="方案标题" value="{$info['title']}">
                           </div>
                       </li>
                       <li>
                           <span class="item-hd">方案描述：</span>
                           <div class="item-bd">
                               <textarea id="case_content" name="case_content">{$info['case_content']}</textarea>
                           </div>
                       </li>
                       <li>
                           <span class="item-hd">方案附件：</span>
                           <div class="item-bd">
                               <div>
                                 <!--  <div id="attach_btn" class="btn-file mt-4">上传附件</div>-->
                                   <a href="javascript:;" id="attach_btn" class="btn btn-primary radius size-S">上传附件</a>
                                   <input type="hidden" name="linedoc" id="linedoc" value="{$info['linedoc']}">
                               </div>
                               <div>
                                   <ol id="linedoc-content" >
                                       {loop $info['linedoc']['path'] $k $v}
                                       <li><span class="name">{$info['linedoc']['name'][$k]}</span><input type="hidden" name="linedoc[name][]" value="{$info['linedoc']['name'][$k]}"><input type="hidden" class="path" name="linedoc[path][]" value="{$v}"><a href="javascript:;" class="del">删除</a></li>
                                       {/loop}
                                   </ol>
                               </div>
                           </div>
                       </li>
                       <li>
                           <span class="item-hd">方案报价：</span>
                           <div class="item-bd">
                               <input type="text" class="default-text wid_460" name="price" value="{$order_info['price']}" placeholder="方案报价"/>
                           </div>
                       </li>
                       <li>
                           <span class="item-hd">预订送积分：</span>
                           <div class="item-bd">
                               <input type="text" class="default-text wid_460" name="jifenbook" value="{$order_info['jifenbook']}" placeholder="预订送积分"/>
                           </div>
                       </li>
                       <li>
                           <span class="item-hd">最高抵现积分：</span>
                           <div class="item-bd">
                               <input type="text" class="default-text wid_460" name="maxtpricejifen" value="{$info['maxtpricejifen']}" placeholder="积分抵现"/>
                           </div>
                       </li>
                   </ul>
               </div>
               <script>
                   var id="{$info['id']}";
                   $(function(){
                       window.case_content=window.JSEDITOR('case_content');
                       //选择计划
                       $("#choose_plan").click(function(){
                           var params={loadCallback: choosePlan,loadWindow:window};
                           var url= SITEURL+"customize/admin/order/dialog_get_plan";
                           ST.Util.showBox('选择方案',url,'600','430',null,null,document,params);
                       });

                       //附件上传


                       $('#attach_btn').click(function(){
                           $.upload({
                               // 上传地址
                               url: SITEURL+'uploader/uploaddoc',
                               // 文件域名字
                               fileName: 'Filedata',
                               fileType: 'doc,docx,pdf',
                               // 其他表单数据
                               params: {uploadcookie:"<?php echo Cookie::get('username')?>"},
                               // 上传完成后, 返回json, text
                               dataType: 'json',
                               // 上传之前回调,return true表示可继续上传
                               onSend: function() {
                                   return true;
                               },
                               // 上传之后回调
                               onComplate: function(info) {

                                   if(info.status){
                                       var html='<li><span class="name">'+info.name+'</span><input type="hidden" name="linedoc[name][]" value="'+info.name+'"><input class="path" type="hidden" name="linedoc[path][]" value="'+info.path+'"><a href="javascript:;" class="del">删除</a></li>';
                                       $("#linedoc-content").append(html);
                                   }


                               }
                           });
                       })

                       //附件删除
                       $("#linedoc-content").find('.del').live('click',function(){
                           var parent=$(this).parent();
                           $.post(SITEURL+'customize/admin/order/ajax_del_doc',{'file':parent.find('.path').val(),'id':id},function(rs){
                               if(rs.status){
                                   parent.remove();
                               }
                           },'json');
                       });
                       function choosePlan(result)
                       {
                           $("#case_plan").text(result.title);
                           $("#case_title").val(result.title);
                           case_content.setContent(result.content);
                           copyLinedoc(result.linedoc);
                       }

                       function copyLinedoc(linedoc)
                       {
                           var url=SITEURL+'customize/admin/order/ajax_copy_linedoc';
                           $.ajax({
                               type: "post",
                               url: url,
                               dataType: 'json',
                               data: {linedoc:linedoc},
                               success: function (result, textStatus){
                                   var linedoc_html = '';
                                   for(var i in result.path)
                                   {
                                       var row = result.path[i];
                                       linedoc_html+='<li><span class="name">'+result['name'][i]+'</span>';
                                       linedoc_html+='<input type="hidden" name="linedoc[name][]" value="'+result['name'][i]+'">';
                                       linedoc_html+='<input type="hidden" class="path" name="linedoc[path][]" value="'+row+'"><a href="javascript:;" class="del">删除</a>';
                                       linedoc_html+='</li>';
                                   }
                                   $("#linedoc-content").html(linedoc_html);
                               }
                           });
                       }
                   })

               </script>
           </div>
           {else}
           <div class="order-info-container">
               <div class="order-info-bar"><strong class="bt-bar">旅行方案</strong></div>
               <div class="order-info-block">
                   <ul>

                       <li>
                           <span class="item-hd">方案标题：</span>
                           <div class="item-bd">

                                <span class="order-num">{$info['title']}</span>
                           </div>
                       </li>
                       <li>
                           <span class="item-hd">方案描述：</span>
                           <div class="item-bd">
                                <span class="order-num">{$info['case_content']}</span>
                           </div>
                       </li>
                       <li>
                           <span class="item-hd">方案附件：</span>
                           <div class="item-bd">
                               <span class="order-num">
                                       {loop $info['linedoc']['path'] $k $v}
                                      <a href="{$v}" class="name mr-10">{$info['linedoc']['name'][$k]}</a>
                                       {/loop}
                               </span>
                           </div>
                       </li>
                       <li>
                           <span class="item-hd">方案报价：</span>
                           <div class="item-bd">
                               <span class="order-num">{$order_info['price']}</span>
                           </div>
                       </li>
                       <li>
                           <span class="item-hd">预订送积分：</span>
                           <div class="item-bd">
                               <span class="order-num">{$order_info['jifenbook']}</span>
                           </div>
                       </li>
                       <li>
                           <span class="item-hd">最高抵现积分：</span>
                           <div class="item-bd">
                                <span class="order-num">{$info['maxtpricejifen']}</span>
                           </div>
                       </li>
                   </ul>
               </div>
           </div>
           {/if}





           <!--游客信息-->
           {if !empty($tourer)}
           <div class="order-info-container">
               <div class="order-info-bar"><strong class="bt-bar">游客信息</strong></div>
               <div class="order-info-block">
                   <table class="user-info-table" id="tourer_list">
                       <tr>
                           <td width="8%">序号</td>
                           <td width="25%">游客姓名</td>
                           <td width="15%">性别</td>
                           <td width="20%">证件类型</td>
                           <td width="40%">证件号码</td>
                       </tr>
                       {loop $tourer $k $r}
                       <tr>
                           <td>{php echo $k+1;}</td>
                           <td>{$r['tourername']}</td>
                           <td>{$r['sex']}</td>
                           <td>{$r['cardtype']}</td>
                           <td>{$r['cardnumber']}</td>
                       </tr>
                       {/loop}

                   </table>
               </div>
           </div>
           {/if}
           <!-- 游客信息 -->
        <!-- 联系人信息 -->
        {if !empty($bill)}
        <div class="order-info-container">
            <div class="order-info-bar"><strong class="bt-bar">发票信息</strong></div>
            <div class="order-info-block">
                <ul>
                    <li>
                        <span class="item-hd">发票金额：</span>
                        <div class="item-bd">
                            <span class="receipt-num pay_total_price ">{Currency_Tool::symbol()}{$info['totalprice']}</span>
                        </div>
                    </li>
                    <li>
                        <span class="item-hd">发票明细：</span>
                        <div class="item-bd">
                            <span class="receipt-type ">旅游费</span>
                        </div>
                    </li>
                    <li>
                        <span class="item-hd">发票抬头：</span>
                        <div class="item-bd">
                            <span class="receipt-type">{$bill['title']}</span>
                        </div>
                    </li>
                    <li>
                        <span class="item-hd">收件人姓名：</span>
                        <div class="item-bd">
                            <span class="receipt-type">{$bill['receiver']}</span>
                        </div>
                    </li>
                    <li>
                        <span class="item-hd">收件人电话：</span>
                        <div class="item-bd">
                            <span class="receipt-type">{$bill['mobile']}</span>
                        </div>
                    </li>
                    <li>
                        <span class="item-hd">邮寄地址：</span>
                        <div class="item-bd" id="city">
                            <span class="receipt-type">{$bill['province']} {$bill['city']} {$bill['address']}</span>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        {/if}
        <!-- 发票信息 -->
        {if $order_info['usejifen'] || $order_info['cmoney']}
       <div class="order-info-container">
            <div class="order-info-bar"><strong class="bt-bar">优惠信息</strong></div>
            <div class="order-info-block">
                <ul>
                    <li>
                        <span class="item-hd">优惠明细：</span>
                        <div class="item-bd">
                            {if $order_info['usejifen']}
                            <span class="pre-tial">积分抵扣<strong class="ml-10 color_f60">-{Currency_Tool::symbol()}{$order_info['jifentprice']}</strong></span>
                            {/if}
                            {if $order_info['cmoney']}
                            <span class="pre-tial">优惠券抵扣<strong class="ml-10 color_f60">-{Currency_Tool::symbol()}{$order_info['cmoney']}</strong></span>
                            {/if}
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        {/if}
        <!-- 优惠信息 -->

        <div class="order-info-container mb-50">
            <div class="order-info-bar"><strong class="bt-bar">支付信息</strong></div>
            <div class="order-info-block">
                <ul>
                    {if !empty($order_info['paysource'])}
                    <li>
                        <span class="item-hd">支付来源：</span>
                        <div class="item-bd">
                            <span class="order-num">{$order_info['paysource']}</span>
                        </div>
                    </li>
                    {/if}
                    <li>
                        <span class="item-hd">订单状态：</span>
                        <div class="item-bd"  id="status_con">
                            {loop $orderstatus $v}
                            <label class="radio-label mr-30" {if $current_status['displayorder']>$v['displayorder'] || ($current_status['status']==4 && $v['status']==5)} style="color:#999" {/if}>
                            <input name="status" type="radio" class="checkbox" value="{$v['status']}" {if $order_info['status']==$v['status']}checked="checked"{/if} {if $current_status['displayorder']>$v['displayorder'] || ($current_status['status']==4 && $v['status']==5)}disabled="disabled"{/if}/>{$v['status_name']}
                            </label>
                            {/loop}

                        </div>
                    </li>

                  <!--  <li>
                        <span class="item-hd">备注说明：</span>
                        <div class="item-bd">
                            <textarea name="admin_remark" class="default-textarea mt-8" placeholder="管理员备注的一些想要针对订单说明的内容"></textarea>
                        </div>
                    </li>-->
                </ul>
            </div>
        </div>
        <!-- 支付信息 -->

        <div class="order-amount-bar">
            <span class="item">原价合计：<strong class="color_f60 org_total_price">{Currency_Tool::symbol()}{$order_info['totalprice']}</strong></span>
            <span class="item">优惠合计：<strong class="color_f60 privilege_total_price">-{Currency_Tool::symbol()}{$order_info['privileg_price']}</strong></span>
            <span class="item">支付总计：<strong class="color_f60 pay_total_price"><b>{Currency_Tool::symbol()}{$order_info['payprice']}</b></strong></span>
            <a class="fr btn btn-primary radius size-L mt-10" id="btn_save" href="javascript:;">保存</a>
        </div>
        <!-- 总计价格 -->
        <input type="hidden" id="id" name="id" value="{$info['id']}">

        </form>
        </td>
    </tr>
</table>
<div id="calendar" style="display: none"></div>
<script>
    var oldstatus = "{$order_info['status']}";
    $(function(){
        $("#btn_save").click(function(){

            var curstatus=$("#status_con input:radio:checked").val();
            if(curstatus!=oldstatus)
            {
                ST.Util.confirmBox("提示", "订单状态有改动，确定保存？", function () {
                    ajax_submit();
                });
            }
            else
            {
                ajax_submit();
            }
        })

        //删除供应商
        $(document).on('click','.del-supplier',function(){
             $(this).parent().remove();
        })
    })
    Product.listSupplier=function(result,bool)
    {
        var html='';
        for(var i in result.data)
        {
            html+='<span class="choose-child-item ml-10">'+ result.data[i].suppliername+'<input type="hidden" name="supplierlist[]" value="'+result.data[i]['id']+'" /><i class="close-icon del-supplier" data-id="'+result.data[i].id+'" ></i></span>';
        }
        $('.supplier-cs').siblings().remove();
        $('.supplier-cs').after(html);
    }

    function ajax_submit()
    {
        $.ajaxform({
            url   :  SITEURL+"customize/admin/order/ajax_save",
            method  :  "POST",
            form  : "#frm",
            dataType:'json',
            success  :  function(data)
            {
                if(data.status)
                {
                    ST.Util.showMsg('保存成功!','4',2000);
                    setTimeout(function(){
                        window.location.reload();
                    },1500)
                }
            }
        })
    }

</script>
</body>
</html>