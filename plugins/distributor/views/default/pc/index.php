<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title color_background=3c5QDl >分销商管理系统-{$webname}</title>
    {Common::css_plugin_distributor('base.css,style.css','distributor')}
    {Common::js_plugin_distributor("jquery.min.js",'distributor')}

</head>
<body>

<div class="page-box">
    {request 'distributor/pc/pub/header'}
    
    <div class="main" style=" left: 0">
        <div class="content-box">
            <div class="user-msg-box">
                <div class="user-headimg">
                    {if !empty($userinfo['litpic'])}
                    <img id="face" src="{$userinfo['litpic']}" width="94" height="94"/>
                    {else}
                    <img id="face" src="{$GLOBALS['cfg_res_url']}/images/default-headimg.jpg" width="94" height="94"/>
                    {/if}
                </div>
                <div class="user-msg">
                    <div class="yz">
                        <strong class="name">{if $userinfo['nickname']}{$userinfo['nickname']}{else}分销商{/if}</strong>
                        <p class="time">上次登录：{date('Y年m月d日 H:i',$userinfo['logintime'])}</p>
                    </div>
                    <div class="gd">
                        <p><span>账户ID：</span>HX{str_pad($userinfo['mid'],6,'0',STR_PAD_LEFT)}</p>
                        <p><span>手机号：</span>{$userinfo['mobile']}</p>
                        <p><span>邮&nbsp&nbsp&nbsp&nbsp箱：</span>{$userinfo['email']}</p>
                    </div>
                </div>
            </div>
            <!-- 用户资料 -->

            <div class="frame-box">
                <div class="frame-con">
                    <div class="verify-box">
                        <div class="verify-tit">
                            <strong class="bt">我最近的验单</strong>
                        </div>
                        <div class="verify-con">
                            <table class="verify-table" width="100%" border="0">
                                <tr>
                                    <th width="45%" height="40" align="center" scope="col">订单信息</th>
                                    <th width="10%" height="40" align="center" scope="col">价格</th>
                                    <th width="10%" height="40" align="center" scope="col">数量</th>
                                    <th width="10%" height="40" align="center" scope="col">总额</th>
                                    <th width="10%" height="40" align="center" scope="col">状态</th>
                                    <th width="15%" height="40" align="center" scope="col">操作</th>
                                </tr>
                                {loop $data $v}
                                <tr>
                                    <td>
                                        <div class="cp">
                                            <a href="{$v['url']}" target="_blank">
                                                <div class="pic">
                                                    <img src="{$v['litpic']}" width="112" height="80" alt="{$v['productname']}"/>
                                                </div>
                                                <div class="con">
                                                    <p class="bt">{$v['productname']}</p>

                                                    <p class="dx">短信码：{$v['smscode']}</p>

                                                    <p class="hm">订单号：{$v['ordersn']}</p>
                                                </div>
                                            </a>
                                        </div>
                                    </td>
                                    <td><span class="price">&yen;{$v['unitprice']}</span></td>
                                    <td><span class="num">x{$v['num']}</span></td>
                                    <td><span class="total">&yen;{$v['total']}</span></td>
                                    <td>
                                        <span class="{if $v['isconsume']==1 }period{else}wxf{/if}">{if $v['isconsume']==1 }已消费{else}未消费{/if}</span>
                                    </td>
                                    <td>
                                        <a class="show" href="/plugins/supplier_check/pc/checkorder/show_order?id={$v['id']}">查看订单</a>
                                    </td>
                                </tr>
                                {/loop}
                            </table>
                        </div>
                    </div>
                    <!-- 验单记录 -->

                </div>
            </div>
            {request "distributor/pc/pub/footer"}

            {include "pc/pub/notice"}

        </div>
    </div>
    <!-- 主体内容 -->

</div>
<script>
    $(function () {
        $("#nav_index").addClass('on');
    });
</script>
</body>
</html>
