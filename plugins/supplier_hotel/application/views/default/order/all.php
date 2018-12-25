<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>我的订单-{$webname}</title>
    {Common::css("style.css,base.css")}
    {Common::js("jquery.min.js,common.js")}
    <link type="text/css" href="/min/?f=/tools/js/artDialog/css/ui-dialog.css,/tools/js/msgbox/msgbox.css" rel="stylesheet" />
    <script type="text/javascript"src="/min/?f=/tools/js/artDialog/dist/dialog-plus.js,/tools/js/msgbox/msgbox.js"></script>
    <script>
        window.SITEURL="{$cmsurl}";
        window.PUBLICURL="{$GLOBALS['cfg_res_url']}";
        window.BASEHOST="{$GLOBALS['cfg_basehost']}";
    </script>
</head>

<body>

<div class="page-box">
    {request "pub/header"}

    {request "pub/sidemenu"}
    <!-- 侧边导航 -->

    <div class="main">
        <div class="content-box">

            <div class="frame-box">
                <div class="frame-con">

                    <div class="verify-box">
                        <form id="st_form" method="get" action="{$cmsurl}order/all">
                        <div class="verify-list-tit">
                            <strong class="bt">我的订单</strong>
                            <div class="pm-btm-box fr" style="margin: 0;padding: 0;">
                                <a class="pm-gn-btn btn_excel" title="导出excel" href="javascript:;">导出excel</a>
                            </div>
                        </div>
                        <div class="verify-search-box">
                            <div class="verify-search-con">
                                <input type="text" name="searchKey" class="search-txt" placeholder="请输入短信码或订单号进行搜索" value="{$get['searchKey']}"/>
                                <input type="button" class="search-btn" value="搜索"/>
                            </div>
                        </div>
                        <div class="verify-con">
                            <table class="verify-table" width="100%" border="0">
                                <tr>
                                    <th width="45%" height="40" align="center" scope="col">订单信息</th>
                                    <th width="10%" height="40" align="center" scope="col">使用日期</th>
                                    <th width="10%" height="40" align="center" scope="col">数量</th>
                                    <th width="10%" height="40" align="center" scope="col">总额</th>
                                    <th width="10%" height="40" align="center" scope="col">状态</th>
                                    <th width="15%" height="40" align="center" scope="col">操作</th>
                                </tr>
                                {loop $data['list'] $v}
                                <tr>
                                    <td>
                                        <div class="cp">
                                            <a href="{$v['url']}" target="_blank">
                                                <div class="pic">
                                                    <img src="{$v['litpic']}" width="112" height="80" alt="{$v['productname']}"/>
                                                </div>
                                                <div class="con">
                                                    <p class="bt">{$v['productname']}</p>
                                                    <p class="hm">订单号：{$v['ordersn']}</p>
                                                </div>
                                            </a>
                                        </div>
                                    </td>
                                    <td><span class="price">{$v['usedate']}</span></td>
                                    <td><span class="num">{$v['num']}</span></td>
                                    <td><span class="total">{if $v['dingjin']>0&&$v['paytype']==2}定金{/if}&yen;{$v['total']}</span></td>
                                    <td>
                                        {if !in_array($v['status'],Model_Member_Order::$changeableStatus)}
                                        <span class="{if $v['status']==2 }period{else}wxf{/if}">{$v['order_status']}</span>
                                        {else}
                                        <span>{$v['order_status']}</span>
<!--                                        <select onchange="change_status(this,'{$v['ordersn']}')">-->
<!--                                            {loop $statusarr $k=>$status}-->
<!--                                            <option value="{$k}" {if $k==$v['status']}selected="selected"{/if}  >{$status}</option>-->
<!--                                            {/loop}-->
<!--                                        </select>-->
                                        {/if}
                                    </td>
                                    <td>
                                        <a class="show" href="{$cmsurl}order/show?id={$v['id']}">查看订单</a>
                                    </td>
                                </tr>
                                {/loop}
                            </table>


                            {if empty($data)}
                            <div class="nofound-order">对不起！没有符合条件，请尝试其他搜索条件。</div>
                            <!-- 搜索无结果 -->
                            {/if}
                        </form>
                    </div>
                    <div class="pm-btm-box">
                            <div class="pm-btm-msg">
                                {$data['pageinfo']}
                            </div>
                    </div>
                </div>
                    <!-- 验单记录 -->


                </div>
            </div>
        {request "pub/footer"}
        </div>
    </div>
    <!-- 主体内容 -->

</div>

<script>
    $(function(){
        $("#nav_hotel_order").addClass('on');
        $('body').delegate('.add-list','click',function() {
            $(this).parent().after('<li><input name="num[]" type="text" class="num-list" placeholder="请输入短信码进行搜索"/><span class="add-list">增加</span></li>');
            $(this).remove();
        });
        $(".search-btn").click(function(){
            $("#st_form").submit();
        });
        $(".btn_excel").click(function(){
            var url=SITEURL+"order/excel";
            ST.Util.showBox('订单生成excel',url,560,380,function(){});
        })
    });

    function change_status(ele,ordersn)
    {
        var status = $(ele).val();
        $.ajax({
            type:'POST',
            data:{ordersn:ordersn,status:status},
            url:SITEURL+'order/ajax_order_status',
            dataType:'json',
            success:function(data){

            }
        })
    }
</script>
</body>
</html>
