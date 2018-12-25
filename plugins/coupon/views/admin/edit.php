<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>优惠券添加/修改</title>
{template 'stourtravel/public/public_js'}
{php echo Common::getCss('style.css,base.css,base_new.css'); }
{php echo Common::getScript("uploadify/jquery.uploadify.min.js,product_add.js,choose.js,imageup.js,DatePicker/WdatePicker.js"); }

    <style>
        .set-text-xh{
            float: none;
        }
        .bz{
            color: #c5c5c5;
        }
        .radio_check
        {
            vertical-align: middle;margin: -2px 2px 0 0

        }
        .order-info-bar {
            height: 33px;
            background: #f1f9ff;
        }
        .order-info-bar .bt-bar {
            display: inline-block;
            color: #8fc0d6;
            height: 33px;
            line-height: 33px;
            padding: 0 20px;
            font-size: 13px;
        }


    </style>
</head>
<body>

	<table class="content-tab">
        <tr>
            <td width="119px" class="content-lt-td"  valign="top">
                {template 'stourtravel/public/leftnav'}
                <!--右侧内容区-->
            </td>
            <td valign="top" class="content-rt-td ">
                <form method="post" name="product_frm" id="product_frm">
                    <div class="cfg-header-bar">
                        <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
                    </div>
                <div class="manage-nr mt-1">
                    <!--基础信息开始-->
                  <div class="product-add-div">
                      <div class="order-info-bar"><strong class="bt-bar">基本信息</strong></div>
                      <ul class="info-item-block">
                          <li>
                              <span class="item-hd">优惠券名称：</span>
                              <div class="item-bd">
                                  <input type="text" name="name" id="name" class="input-text w300"  value="{$info['name']}" />
                                  <span class="item-text c-999 ml-10">*必填</span>
                              </div>
                          </li>
                          <li>
                               <span class="item-hd">优惠券开关：</span>
                               <div class="item-bd">
                                   <label class="radio-label"><input type="radio" name="isopen" value="1" {if $info['isopen']==1} checked="checked"{/if} >开启</label>
                                   <label class="radio-label ml-20"><input type="radio"  name="isopen" value="0" {if $info['isopen']==0} checked="checked"{/if} >关闭</label>
                               </div>
                           </li>
                          <li>
                              <span class="item-hd">优惠券金额：</span>
                              <div class="item-bd">
                                  <label class="radio-label"><input class="radio_check" type="radio" name="type" value="0" {if $info['type']==0} checked="checked"{/if} >固定金额</label>
                                  <input type="text" name="amount[0]" id="amount0" class="input-text w100 mr-5" value="{if $info['type']==0} {$info['amount']} {/if}" />元
                                  <label class="radio-label ml-20"><input class="radio_check" type="radio" name="type"  {if $info['type']==1} checked="checked"{/if}  value="1">折扣比</label>
                                  <input type="text" name="amount[1]" id="amount1" class="input-text w100 mr-5" value="{if $info['type']==1} {$info['amount']} {/if}" />折
                                  <span class="item-text c-999 ml-10">*必填项，设置可抵扣金额或折扣比，最小为1和0.1</span>
                              </div>
                          </li>
                          <li>
                               <span class="item-hd">订单满减：</span>
                               <div class="item-bd">
                                   <span class="item-text">订单金额满：</span>
                                   <input type="text" name="samount" id="samount" class="input-text w100 mr-5" value="{if $info['samount']}{$info['samount']}{else}0{/if}" />可用
                                   <span class="item-text c-999 ml-10">*默认为0，表示不限制使用金额</span>
                               </div>
                          </li>
                          <li>
                              <span class="item-hd">优惠券有效期：</span>
                              <div class="item-bd">
                                  <label class="radio-label"><input  type="radio"   class="radio_check"  name="isnever" value="0" {if $info['isnever']==0} checked="checked"{/if}  >永久有效</label>
                                  <label class="radio-label ml-20"><input type="radio" class="radio_check"  name="isnever" {if $info['isnever']==1} checked="checked"{/if}  value="1">区间内有效</label>
                                  <span {if $info['isnever']==0} style="display:none"{/if} class="isneverspan item-text va-t ml-5">
                                      <input type="text" name="starttime" id="starttime" class="input-text w200 choosetime" value="{$info['starttime']}" />
                                      <span>—</span>
                                      <input type="text" name="endtime" id="endtime" class="input-text w200 choosetime" value="{$info['endtime']}" />
                                      <span class="item-text c-999 ml-10">*必填</span>
                                  </span>
                              </div>
                          </li>
                          <li>
                              <span class="item-hd">发放数量：</span>
                              <div class="item-bd">
                                  <input type="text" name="totalnumber" id="totalnumber" class="input-text w100"  value="{$info['totalnumber']}" />&nbsp;张&nbsp;&nbsp; <span class="item-text c-999">*设置此优惠券的总数量，领取完后则不能再领取</span>
                              </div>
                          </li>
                          <li>
                              <span class="item-hd">用户最多领取：</span>
                              <div class="item-bd">
                                  <input type="text" name="maxnumber" id="maxnumber" class="input-text w100"  value="{if $info['maxnumber']}{$info['maxnumber']}{else}1{/if}" />&nbsp;张&nbsp;&nbsp; <span class="item-text c-999">*设置每个账号最多可以领取多少张优惠券，默认为1张</span>
                              </div>
                          </li>
                      </ul>
                  </div>
                  <div class="product-add-div">
                      <div class="order-info-bar"><strong class="bt-bar">领取条件</strong></div>
                      <ul class="info-item-block">
                          <li>
                              <span class="item-hd">发券方式：</span>
                              <div class="item-bd">
                                  <label class="radio-label">
                                      <input type="radio" name="kindid" value="1" {if $info['kindid']!=2} checked="checked"{/if} >免费领取
                                  </label>
                                  <label class="radio-label ml-20">
                                      <input type="radio" name="kindid" value="2" {if $info['kindid']==2} checked="checked"{/if} >积分兑换
                                  </label>
                                  <input type="text" name="needjifen" id="needjifen" class="input-text w100 ml-5" value=" {$info['needjifen']} " />
                                  <span class="item-text ml-5">积分可兑换</span>
                              </div>
                          </li>
                          <li>
                              <span class="item-hd">领取会员级别：</span>
                              <div class="item-bd">
                                  {loop $member_grades $grade}
                                  <label class="check-label mr-20">
                                      <input type="checkbox" name="membergrade[]" value="{$grade['id']}" {if in_array($grade['id'],$info['memeber_grades'])||!$info['memeber_grades']}  checked {/if}  >{$grade['name']}
                                  </label>
                                  {/loop}
                              </div>
                          </li>
                      </ul>
                  </div>
                  <div class="product-add-div">
                      <div class="order-info-bar"><strong class="bt-bar">使用条件</strong></div>
                          <ul class="info-item-block">
                             <li>
                                 <span class="item-hd">提前可用天数：</span>
                                 <div class="item-bd">
                                     <input type="text" name="antedate" id="antedate" class="input-text w100" value="{if $info['antedate']}{$info['antedate']}{else}0{/if}" />
                                     <span class="item-text c-999 ml-10">*提前天数是设置提前预定产品的天数，若设置提前7天可用，则必须预定7天后的产品才能使用该优惠券。默认为0，表示不提前</span>
                                 </div>
                             </li>
                              <li>
                                  <span class="item-hd">可使用产品：</span>
                                  <div class="item-bd">
                                      <div>
                                          <label class="radio-label"><input type="radio" name="typeid" value="0" {if $info['typeid']==0} checked {/if}>所有产品</label>
                                          <span class="item-text c-999 ml-10">*默认所有产品可用，设置为所有产品则可以在所有产品中使用</span>
                                      </div>
                                      <div class="clearfix">
                                          <label class="radio-label"><input class="radio_check" type="radio" name="typeid" value="1" {if $info['typeid']==1} checked {/if}> 按产品类</label>
                                          <div class="typeid_1" {if $info['typeid']!=1} style="display: none" {else} style="display: inline-block" {/if}>
                                          <a href="javascript:;" class="btn btn-primary radius size-S ml-10" onclick="add_product.getsetmodeltype(this,'.modules-sel',1)" title="选择">选择</a>
                                          <div style="display: inline-block; float: none" class="save-value-div ml-10 modules-sel">
                                              {loop $info['modules'] $module}
                                              <span style="display: inline-block; float: none"><s onclick="$(this).parent('span').remove()"></s>{$module['modulename']}<input type="hidden" name="models[]" value="{$module['id']}"></span>
                                              {/loop}
                                          </div>
                                      </div>
                                  </div>
                                  <div>
                                      <label class="radio-label"><input type="radio" name="typeid" value="9999" {if $info['typeid']==9999} checked {/if}> 指定产品</label>
                                      <div class="typeid_9999" {if $info['typeid']!=9999}  style="display: none" {else} style="display: inline-block" {/if} >
                                      <a href="javascript:;" class="btn btn-primary radius size-S ml-10" onclick="add_product.getaddproduct(this,'.attr-sel',1)" title="指定">指定</a>
                                  </div>
                                  <div class="apply-tab-wrap typeid_9999" {if $info['typeid']!=9999}  style="display: none" {else} style="display:block" {/if}>
                                  <div class="action-bar clearfix">
                                      <div class="tab-line pt-10 pb-10">管理已应用的产品：</div>
                                      <div class="item-nr">
                                          <span class="select-box w200">
                                              <select id="search_typeid" class="select" onchange="togStatus(this)">
                                                  <option value="0"> 全部</option>
                                                  {loop $models $m}
                                                  <option value="{$m['id']}"> {$m['modulename']}</option>
                                                  {/loop}
                                              </select>
                                          </span>
                                          <input type="text" class="input-text w300 ml-10" id="search_input" value="" placeholder="请输入关键词">
                                          <a class="btn btn-primary radius ml-10" href="javascript:;" id="search_btn">搜索</a>
                                      </div>
                                  </div>
                                  <div class="apply-tab-block mt-10 pr-20">
                                      <table class="table table-border table-bordered" id="dlg_tb">
                                          <tr>
                                              <th width="150">产品编号</th>
                                              <th>产品类型</th>
                                              <th>产品名称</th>
                                              <th width="150">管理</th>
                                          </tr>
                                      </table>
                                      <div class="btn-block" >
                                          <div class="pm-btm-msg" id="page_info">

                                          </div>
                                      </div>
                                  </div>
                                      </div>
                                    </div>
                                  </div>
                              </li>
                          </ul>
                  </div>
                  <div class="clear clearfix pt-20 pb-20">
                      <input type="hidden" name="couponid" id="couponid" value="{$info['id']}"/>
                      <input type="hidden" name="action" id="action" value="{$action}"/>
                      <a class="btn btn-primary radius size-L ml-115" id="btn_save" href="javascript:;">保存</a>
                  </div>
                </form>
            </td>
        </tr>
    </table>

	<script>

        add_product = {
            getsetmodeltype:function(dom,selector)
            {

                var  models= [];
                $(selector+" input:hidden").each(function(index,obj){

                    models.push($(obj).val());
                });
                models = models.join('_');
                CHOOSE.setSome("选择品类",{loadWindow:window,loadCallback:add_product.listgetsetmodeltype},SITEURL+'coupon/admin/coupon/dialog_setmodeltype?models='+models+'&selector='+encodeURI(selector),1);
            },
            listgetsetmodeltype:function(result,bool)
            {
                var data=result.data;
                var html = '';
                $.each(data,function(index,model){
                    html +='<span  style="display: inline-block; float: none"><s onclick="$(this).parent(\'span\').remove()"></s>'+model.modulename+'<input type="hidden" name="models[]" value="'+model.id+'"></span>';
                })
                $('.modules-sel').html(html)
            },
            getaddproduct:function()
            {
                var  cid = $('#couponid').val();
                if(!cid)
                {
                    ST.Util.showMsg("请先保存优惠券基础信息,然后才能指定产品", 5, 1000);
                    return;
                }
                var params={loadCallback: add_product.listchooseProduct,loadWindow:window};
                var url= SITEURL+'coupon/admin/coupon/add_product?id='+cid
                ST.Util.showBox('指定产品',url,'900','600',null,null,document,params);
            },
            listchooseProduct:function(){
               get_product_list();//加载列表
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

        $('#amount0').blur(function () {
            var val = parseInt($(this).val());
            if (isNaN(val)) {
                val = '';
            } else {
                val = Math.abs(val);
                if (val > 99999) {
                    val = 99999;
                }
            }
            $(this).val(val);
        });

        $('#amount1').blur(function () {
            var val = parseFloat($(this).val());
            if (isNaN(val)) {
                val = '';
            } else {
                val = Math.abs(val);
                if (val >=10) {
                    val = 9.9;
                }
            }
            $(this).val(val);
        });

        $('#samount').blur(function () {
            var val = parseInt($(this).val());
            if (isNaN(val)) {
                val = '';
            } else {
                val = Math.abs(val);
                if (val >= 1000000) {
                    val = 999999;
                }
            }
            $(this).val(val);
        });

        //保存
        $("#btn_save").click(function(){
               var name = $("#name").val();
               var samount = $("#samount").val();
               var totalnumber = $("#totalnumber").val();
               var maxnumber = $("#maxnumber").val();
                var type = $('input[name=type]:checked').val();
               if(type==0)
               {
                   var amonut = $('#amount0').val();
               }
                else
               {
                   var amonut = $('#amount1').val();
               }

            //验证名称
             if(name==''||totalnumber==''||maxnumber==''||amonut==''){
                   $("#nav").find('span').first().trigger('click');
                   $("#name").focus();
                   ST.Util.showMsg('请填写基础信息',5,2000);
               }
               else
               {

                   var typeid = $('input[name=typeid]:checked').val();
                   if(typeid==1)
                   {
                       var length = $('.modules-sel input:hidden').length;
                       if(length<1)
                       {
                           ST.Util.showMsg('请选择可使用的产品类',5,2000);
                           return false;
                       }
                   }



                   Ext.Ajax.request({
                       url   :  SITEURL+"coupon/admin/coupon/ajax_save",
                       method  :  "POST",
                       isUpload :  true,
                       form  : "product_frm",
                       datatype  :  "JSON",
                       success  :  function(response, opts)
                       {
                           var data = $.parseJSON(response.responseText);
                           if(data.status)
                           {
                               if(data.couponid!=null){
                                   $("#couponid").val(data.couponid);
                               }
                               ST.Util.showMsg('保存成功!','4',2000);
                           }
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
            var typeid = $('#search_typeid').val();
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
                                ST.Util.showMsg("{__('norightmsg')}",5,1000);
                            }
                        }});

                }


            });

        }




    </script>




</body>
</html>
