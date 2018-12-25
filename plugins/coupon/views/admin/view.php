<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title background_size=8MM8Zk >优惠券添加/修改</title>
    {template 'stourtravel/public/public_js'}
    {php echo Common::getCss('style.css,base.css,base2.css,plist.css,inlinegrid.css,couponextend.css,jf.css'); }

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
                <div class="manage-nr">
                    <div class="w-set-tit bom-arrow" id="nav">
                        <a href="javascript:;" class="refresh-btn" onclick="window.location.reload()">刷新</a>
                    </div>
                    <!--基础信息开始-->
                    <div class="product-add-div">
                        <div class="order-info-bar"><strong class="bt-bar">基本信息</strong></div>
                      <span class="add-class">
                           <dl >
                               <dt>优惠券编号：</dt>
                               <dd>
                                   {$info['code']}
                               </dd>
                           </dl>
                          <dl >
                              <dt>优惠券名称：</dt>
                              <dd>
                                  {$info['name']}
                              </dd>
                          </dl>
                          <dl >
                              <dt>优惠券开关：</dt>
                              <dd>
                                  {if $info['isopen']==1}
                                  开启
                                  {else}
                                  关闭
                                  {/if}

                              </dd>
                          </dl>
                          <dl>
                              <dt>优惠券金额：</dt>
                              <dd>
                                  {$info['amount']}
                                  {if $info['type']==1}
                                  折
                                  {/if}
                              </dd>
                          </dl>
                           <dl >
                               <dt>订单满减：</dt>
                               <dd>
                                   满 {$info['samount']} 可用
                               </dd>
                           </dl>
                          <dl>
                              <dt>优惠券有效期：</dt>
                              <dd>

                                  {if $info['isnever']==0}
                                    永久有效
                                  {else}
                                  {$info['starttime']} - {$info['endtime']}
                                  {/if}

                              </dd>
                          </dl>
                          <dl>
                              <dt>发放数量：</dt>
                              <dd>
                                  {$info['totalnumber']}
                              </dd>
                          </dl>
                          <dl>
                              <dt>用户最多领取：</dt>
                              <dd>
                                  {$info['maxnumber']}
                              </dd>
                          </dl>
                      </span>
                    </div>

                    <div class="product-add-div">
                        <div class="order-info-bar"><strong class="bt-bar">领取条件</strong></div>
                      <span class="add-class">

                          <dl >
                              <dt>发券方式：</dt>
                              <dd>

                                  {if $info['kindid']==1}
                                  免费领取
                                  {else}
                                  积分兑换&nbsp;&nbsp;
                                  {$info['needjifen']}积分可兑换
                                  {/if}

                              </dd>
                          </dl>
                          <dl>
                              <dt>领取会员级别：</dt>
                              <dd>
                                  {loop $member_grades $grade}

                                  {if in_array($grade['id'],$info['memeber_grades'])}
                                  {$grade['name']}、
                                  {/if}



                                  {/loop}
                              </dd>
                          </dl>
                      </span>
                    </div>
                    <div class="product-add-div">
                        <div class="order-info-bar"><strong class="bt-bar">使用条件</strong></div>
                      <span class="add-class">
                         <dl>
                             <dt>提前可用天数：</dt>
                             <dd>
                                 {$info['antedate']}天
                             </dd>
                         </dl>
                          <dl>
                              <dt>可使用产品：</dt>
                              <dd style="width: 1000px">
                                  {if $info['typeid']==0}
                                  所有产品
                                  {elseif $info['typeid']==1}
                                  指定品类： {loop $info['modules'] $module}
                                            {$module['modulename']}、
                                            {/loop}
                                  {elseif $info['typeid']==9999}
                                  指定产品
                                  <br>
                                  <div class="action-bar clearfix">
                                      <div class="tab-line">管理已应用的产品：</div>
                                      <div class="item-nr">
                                          <select id="search_typeid"  class="drop-down" onchange="togStatus(this)">
                                              <option value="0"> 全部</option>
                                              {loop $models $m}
                                              <option value="{$m['id']}"> {$m['modulename']}</option>
                                              {/loop}
                                          </select>
                                          <input type="text" class="default-text ml-10" id="search_input" value="" placeholder="请输入关键词">
                                          <a class="st-btn ml-10" href="javascript:;" id="search_btn">搜索</a>
                                      </div>
                                  </div>
                                  <div class="apply-tab-block">
                                      <table  class="st-table-item" width="150%" id="dlg_tb">
                                          <tr>
                                              <th width="150">产品编号</th>
                                              <th>产品类型</th>
                                              <th>产品名称</th>
                                          </tr>
                                      </table>
                                      <div class="btn-block" >
                                          <div class="pm-btm-msg" id="page_info">

                                          </div>
                                      </div>
                                  </div>
                                  {/if}

                            </div>



                             </dd>
                            </dl>
                         </span>
                 </div>


            </form>
        </td>
    </tr>
</table>




<script>

    $(function(){
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
             '</tr>';
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





</script>




</body>
</html>
