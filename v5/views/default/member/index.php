<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>{__('会员中心')}-{$webname}</title>
    {include "pub/varname"}
    {Common::css('user.css,base.css,extend.css',false)}

    <link rel="stylesheet" type="text/css" href="/res/js/artDialog7/css/dialog.css">
    
    {Common::js('jquery.min.js,base.js,common.js,jquery.zclip.js,xdate.js')}
    <script type="text/javascript" src="/res/js/artDialog7/dist/dialog-plus.js"></script>
    {Common::js('layer/layer.js')}
</head>
<body>
{request "pub/header"}
<div class="big">
<div class="wm-1200">

<div class="st-guide">
    <a href="{$cmsurl}">{__('首页')}</a>&nbsp;&nbsp;&gt;&nbsp;&nbsp;{__('会员中心')}
</div><!--面包屑-->
<div class="st-main-page">
{include "member/left_menu"}
<div class="user-order-box">
    <div class="user-home-box">
        {if (empty($info['email']) || empty($info['mobile'])||empty($info['nickname'])||empty($info['truename'])||empty($info['cardid'])||empty($info['address']))}
        <div class="hint-msg-box">
            <span class="close-btn">{__('关闭')}</span>
            <p class="hint-txt">
                {if empty($info['email']) || empty($info['mobile'])}
                {__('温馨提示：请完善<a href="/member/index/userinfo">手机/邮箱</a>信息，避免错过产品预定联系等重要通知!')}
                {elseif (empty($info['nickname'])||empty($info['truename'])||empty($info['cardid'])||empty($info['address']))}
                {__('温馨提醒：请完善<a href="/member/index/userinfo">个人资料</a>信息，体验更便捷的产品预定流程！')}
                {/if}
            </p>
        </div>
        <script>
            $(function(){
                $('.close-btn').click(function(){
                    $('.hint-msg-box').hide(500);
                })
            })
        </script>
        {/if}
        <div class="user-home-msg">
            <div class="user-msg-con">
                <div class="user-pic"><!-- <div class="level"><a href="/member/club/rank">Common::member_rank($info['mid'],array('return'=>'current'))</a></div> --><a href="/member/index/userinfo"><img src="{$info['litpic']}" width="118" height="118" /></a></div>
                <div class="user-txt">
                    <p class="name">{$info['nickname']}</p>
 <!--                    <p class="item-bar">{__('会员等级')}：{Common::member_rank($info['mid'],array('return'=>'rankname'))}</p> -->
                    <p class="item-bar">{__('登录邮箱')}：
                        {if $info['email']}{$info['email']}{else}{__('未绑定')} <a class="rz-no" href="{$cmsurl}member/index/modify_email?change=0">{__('立即绑定')}</a>{/if}</p>
                    <p class="item-bar">{__('手机号码')}：
                        {if $info['mobile']}{$info['mobile']}{else}{__('未绑定')} <a class="rz-no" href="{$cmsurl}member/index/modify_phone?change=0">{__('立即绑定')}</a>{/if}</p>
                    <p class="item-bar">真实姓名：
                        {if $info['verifystatus']==2}{$info['truename']}{else}{if $info['verifystatus']==1}审核中 {elseif  $info['verifystatus']==3}审核失败 {else}未实名{/if}
                        <a class="rz-no" href="{$cmsurl}member/index/modify_idcard">实名认证</a>{/if}</p>
                    <p class="item-bar">服务网点：
                        <?php 
                            if ($info['binddistributor']=='0') {
                                echo '未绑定 <a class="rz-no" style="margin-left:0px;" href="#">联系管理员</a>';
                            }else{
                                $dinfo=Model_Distributor::distributor_find_relationship($info['mid'],'view');
                                echo "<a href='#' class='rz-no' style='margin-left:0px;'' onclick='serviceinfo()'>服务网点信息</a>";
                            }
                         ?>
                         </p>
                    {if $info['bflg']==1}
                        <p class="item-bar">我的链接：<?php echo '<a href="#" id="copy" style="margin-left:4px;" class="rz-no">复制链接</a>'; ?><a href="#" class="rz-no" onclick="checkqrcode()">二维码</a></p>
                    {/if}
                </div>
            </div><!-- 账号信息 -->
            <div class="user-msg-right">
                <div class="user-msg-tj">
                <ul class="clearfix">
                    <li class="my-jf" data-url="/member/order/all-unpay">
                        <em></em>
                        <span>{__('未付款')}</span>
                    </li>
                    <li class="un-fk" data-url="/member/order/all-uncomment">
                        <em></em>
                        <span>{__('未点评')}</span>

                    </li>
                    <li class="un-dp" data-url="/member/index/myquestion">
                        <em></em>
                        <span>{__('我的咨询')}</span>
                    </li>
                    {if St_Functions::is_normal_app_install('system_integral')}
                    <li class="my-sc" data-url="/integral">
                        <em></em>
                        <span>积分商城</span>
                    </li>
                    {/if}
                    {if St_Functions::is_normal_app_install('integral_award')}
                    <li class="my-hd" data-url="/award">
                        <em></em>
                        <span>积分活动</span>
                    </li>
                    {/if}
                </ul>
            </div><!-- 订单信息 -->
                <div class="user-info-exchange">
                <ul class="clearfix">
                    
                    {if $info['bflg']==1}
                    <li><em>预存款余额：</em><strong>{Currency_Tool::symbol()}{php echo $info['money']-$info['money_frozen']}</strong></li>
                    <li><em>授信额度：</em><strong>{$info['credit']}</strong></li>
                    <li><em>加盟期限：</em><strong id="jmqx">{$info['jiamengqixian']}</strong></li>
                    <li><em>短信余额：</em><strong>{$info['sms']}</strong></li>
                    {/if}
<!--                    <li><em>我的余额：</em><strong>¥6525</strong></li>-->
                    {if isset($info['coupon'])}
                    <li class="last-li"><em>优惠券：</em><strong>{$info['coupon']}张</strong></li>
                    {/if}
                </ul>
            </div>
            </div>

        </div>
        <div class="user-home-order">
            <div class="order-tit">{__('最新订单')}<a class="more" href="/member/order/all">查看更多&gt;</a></div>
            {if !empty($neworder)}
            <div class="order-list">
                <table width="100%" border="0">
                    <tr>
                        <th width="51%" height="38" scope="col">{__('订单信息')}</th>
                        <th width="13%" height="38" scope="col">{__('会员账号')}</th>
                        <th width="13%" height="38" scope="col">{__('订单金额')}</th>
                        <th width="13%" height="38" scope="col">{__('订单状态')}</th>
                        <th width="13%" height="38" scope="col">{__('订单操作')}</th>
                    </tr>
                    {loop $neworder $order}
                    <tr>
                        <td height="114">
                            <div class="con">
                                <dl>
                                    <dt><a href="{if $order['is_standard_product']}{$order['producturl']}{else}{$cmsurl}member/order/view?ordersn={$order['ordersn']}{/if}" target="_blank"><img src="{Common::img($order['litpic'],110,80)}" width="110" height="80" alt="{$order['title']}" /></a></dt>
                                    <dd>
                                        <a class="tit" href="{if $order['is_standard_product']}{$order['producturl']}{else}{$cmsurl}member/order/view?ordersn={$order['ordersn']}{/if}" target="_blank">{$order['productname']}</a>
                                        <p>{__('订单编号')}：{$order['ordersn']}</p>
                                        <p>{__('下单时间')}：{Common::mydate('Y-m-d H:i:s',$order['addtime'])}</p>
                                    </dd>
                                </dl>
                            </div>
                        </td>
                        <td align="center">
                            <?php
                                $user=Model_Member::get_member_info($order['memberid']);
                                if ($user['mobile']!='') {
                                     echo $user['mobile'];
                                }else{
                                    echo $user['email'];
                                }
                            ?>
                        </td>
                        {if $order['typeid']!=107}
                        <td align="center"><span class="price"><i class="currency_sy">{Currency_Tool::symbol()}</i>{$order['totalprice']}</span></td>
                        {else}
                        <td align="center"><span class="price">{$order['needjifen']}&nbsp;积分</span></td>
                        {/if}
                        <td align="center"><span class="dfk">{$order['statusname']}</span></td>
                        <td align="center">


                            {if $order['status']=='1'&&$order['pid']==0&&$order['memberid']==$mid}
                            <a class="now-fk" href="{$cmsurl}member/index/pay?ordersn={$order['ordersn']}">{__('立即付款')}</a>
                            <a class="cancel_order now-dp" style="background:#ccc" href="javascript:;" data-orderid="{$order['id']}">{__('取消')}</a>
                            {elseif $order['status']=='5' && $order['ispinlun']!=1 && $order['is_commentable']&&$order['memberid']==$mid}
                            <a class="now-dp" href="{$cmsurl}member/order/pinlun?ordersn={$order['ordersn']}">{__('立即点评')}</a>
                            {/if}

                            <a class="order-ck" href="{$cmsurl}member/order/view?ordersn={$order['ordersn']}">{__('查看订单')}</a>


                        </td>
                    </tr>
                    {/loop}

                </table>
            </div>
            {else}
                <div class="order-no-have"><span></span><p>{__('您的订单空空如也')}，<a href="/">{__('去逛逛')}</a>{__('去哪儿玩吧')}！</p></div>
            {/if}
        </div><!-- 我的订单 -->

        {if St_Functions::is_system_app_install(1)}
         {st:line action="query" flag="order" row="4" return="recline"}
         {if !empty($recline)}
            <div class="guess-you-like">
                <div class="like-tit">{__('猜你喜欢的')}</div>
                <div class="like-list">
                    <ul>


                            {loop $recline $line}
                            <li {if $n%4==0}class="mr_0"{/if}>
                                <div class="pic"><a href="{$line['url']}" target="_blank"><img src="{Common::img($line['litpic'])}" alt="{$line['title']}" /></a></div>
                                <div class="con">
                                    <a href="{$line['url']}" target="_blank">{$line['title']}</a>
                                    <p>
                                        {if !empty($line['sellprice'])}
                                        <del>{__('市场价')}：<i class="currency_sy">{Currency_Tool::symbol()}</i>{$line['sellprice']}</del>
                                        {/if}
                                        {if !empty($line['price'])}
                                            <span><i class="currency_sy">{Currency_Tool::symbol()}</i><b>{$line['price']}</b>{__('元')}{__('起')}</span>
                                        {else}
                                            <span>{__('电询')}</span>
                                        {/if}
                                    </p>
                                </div>
                            </li>
                           {/loop}
                    </ul>
                </div>
            </div>
          {/if}
        {/if}
    </div>
</div><!--会员首页-->

</div>

</div>
</div>
{request "pub/footer"}
<script>
    window.d = null;

//弹出框
/*
  params为附加参数，可以是与dialog有关的所有参数，也可以是自定义参数
  其中自定义参数里有
  loadWindow: 表示回调函数的window
  loadCallback: 表示回调函数
  maxHeight:指定最高高度

 */
function floatBox(boxtitle, url, boxwidth, boxheight, closefunc, nofade,fromdocument,params) {
    boxwidth = boxwidth != '' ? boxwidth : 0;
    boxheight = boxheight != '' ? boxheight : 0;
    var func = $.isFunction(closefunc) ? closefunc : function () {
    };
    fromdocument = fromdocument ? fromdocument : null;//来源document

    var initParams={
        url: url,
        title: boxtitle,
        width: boxwidth,
        height: boxheight,
        scroll:0,
        loadDocument:fromdocument,
        onclose: function () {
            func();
        }
    }
    initParams= $.extend(initParams,params);

    var dlg = dialog(initParams);


    if(typeof(dlg.loadCallback)=='function'&&typeof(dlg.loadWindow)=='object')
    {
       dlg.finalResponse=function(arg,bool,isopen){
            dlg.loadCallback.call(dlg.loadWindow,arg,bool);
            if(!isopen)
              this.remove();
       }
    }

    window.d=dlg;
    d.close()
    if (initParams.width != 0) {
        d.width(initParams.width);
    }
    if (initParams.height!= 0) {
        d.height(initParams.height);
    }
  
    if (nofade) {
        d.show()
    } else {
        d.showModal();
    }

}
    function serviceinfo(){
        var url=SITEURL+"distributor/pc/distributor/serviceinfo/"+"{$dinfo}";
        floatBox('服务网点信息',url,'500','250');
    }
    function checkqrcode() {
        var url=SITEURL+"member/index/checkqrcode";
        floatBox("我的二维码",url,'200','200');
    }
    function diff(endDate) {
        var now = new XDate();
        endDate = new XDate(endDate);
        var diff = now.diffDays(endDate);
        return diff;
    }
    $(function(){
        if ({$info['bflg']}) {
            var jmf="'"+{$info['jiamengfei']}+"'";
            var deposit="'"+{$info['money']}+"'"
            var diffDay=parseInt(diff($('#jmqx').text()));
            if (diffDay<30) {
                //询问框
                layer.confirm('加盟协议还有'+diffDay+'天到期，续期吗？', {
                    btn: ['火速续期','算了，还是分了吧！'] //按钮
                }, function(){
                    if (deposit<jmf) {
                        layer.confirm('预存款不足，请充值预存款！',{btn:['前往充值','知道了']},function() {
                            window.location.href=SITEURL+'member/bag/index?type=100';   
                        });
                    }else{
                        var url=SITEURL+'distributor/pc/distributor/ajax_renewal';
                        $.ajax({
                            url: url,
                            type: 'POST',
                            dataType: 'json',
                        })
                        .done(function(data) {
                            layer.msg(data.msg,{time:2000,icon:6})
                        })
                    }
                }, function(){
                    layer.msg('没有你的日子里，我会想念你！', {
                        time: 20000, //20s后自动关闭
                        btn: ['谢谢！']
                    });
                });
            }
        }

        $('#copy').zclip({
            path:'{$root}'+'/res/swf/ZeroClipboard.swf',
            copy:function () {
                return '{$GLOBALS['cfg_basehost']}'+'/member/register/index/'+'{$info['mid']}';
            },
            afterCopy:function() {
                    layer.msg('复制成功！', {time: 1000, icon:6});
            }
        });
        $("#nav_index").addClass('on');
        if(typeof(on_leftmenu_choosed)=='function')
        {
            on_leftmenu_choosed();
        }

        $(".user-msg-tj li").click(function(){
            var url = $(this).attr('data-url');
            if(url!=''){
                location.href = url;
            }
        })


    })


</script>
{include "member/order/jsevent"}
</body>
</html>
