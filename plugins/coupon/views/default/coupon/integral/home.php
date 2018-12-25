{if $list}
<div class="exchange-content">
    <h3 class="column-bar clearfix">
        <strong class="bar-tit">积分兑换券</strong>
        <a class="more-link" href="/coupon/integral_all" target="_blank">更多&gt;</a>
    </h3>
    <div class="exchange-block">
        <ul class="clearfix">
            {loop $list $k $v}
            <li {if $k && ($k+1)%4==0}class="mr_0"{/if}>
                <a href="{$cmsurl}coupon/integral_show?cid={$v['id']}"  class="pic"><img src="{Common::img($v['litpic'],285,194)}" alt="{$v['name']}"/></a>
                <div class="info">
                    <a href="javascript:;"  class="bt">{$v['name']}
                        <br>
                        {if $v['type']==0}
                        <em>订单满{$v['samount']}立减{$v['amount']}元</em>
                        {else}
                        <em>订单满{$v['samount']}享{$v['amount']}折</em>
                        {/if}</a>
                    <p class="data clearfix">
                        <em class="jf-num"><b>{$v['needjifen']}</b>积分</em>
                        <a class="dh-btn get_coupon" data-maxnumber="{$v['maxnumber']}" {if $v['isnever']==1} data-endtime="{$v['endtime']}" {/if} data-jifen="{$v['needjifen']}" data-title="{$v['name']}" data-id="{$v['id']}" href="javascript:;">立即兑换</a>
                    </p>
                </div>
            </li>
            {/loop}
        </ul>
    </div>
</div>

<div class="hint-change hide" id="hintChange">
    <i class="icon"></i>
    <div class="hint-wrap">
        <p class="tf">您正在使用<span class="jf"></span>兑换</p>
        <p class="ts"></p>
        <p class="tt"></p>
    </div>
</div>
{/if}
<!-- 热门兑换 -->
{Common::js('layer/layer.js',0)}
<script>


    $(function(){
        $('.get_coupon').click(function(){

            var couponid = $(this).attr('data-id');
            var title = $(this).attr('data-title');
            var jifen = $(this).attr('data-jifen');
            var endtime = $(this).attr('data-endtime');
            var maxnumber = $(this).attr('data-maxnumber');
            if(!endtime)
            {
                endtime = '永久有效';
            }
            else
            {
                endtime ='有效期至：'+endtime;
            }
            if(!maxnumber)
            {
                maxnumber = '&nbsp;&nbsp;&nbsp;'
            }
            else
            {
                maxnumber = '&nbsp;&nbsp;&nbsp;每个会员限领'+maxnumber+'张'
            }
            $('#hintChange .jf').text(jifen+'积分');
            $('#hintChange .ts').text(title);
            $('#hintChange .tt').html(endtime+maxnumber);
            $("#hintChange").removeClass("hide");
                layer.open({
                    type: 1,
                    title: '提示兑换',
                    area: ['500px'],
                    btn: ['确定','取消'],
                    btnAlign: 'c',
                    content: $('#hintChange'),
                    yes:function(){
                        get_coupon(couponid);
                    }
                    ,btn2: function(){
                        $("#hintChange").addClass("hide");
                        layer.closeAll()
                    }
                    ,cancel: function(){
                        $("#hintChange").addClass("hide");
                        layer.closeAll()
                    }
                });
        })
    })


    function get_coupon(couponid)
    {

        $.ajax({
            type: 'POST',
            url: SITEURL + 'coupon/ajxa_get_coupon_from_integral',
            data: {cid:couponid},
            async: false,
            dataType: 'json',
            success: function (data)
            {
                if(data.status==0)
                {
                    layer.msg(data.msg, {icon: 5,time: 1000});
                }
                if(data.status==1)
                {
                    layer.msg(data.msg, {icon: 5,time: 1000},function(){
                        var url = SITEURL+'member/login?redirecturl={$redirecturl}';
                        window.location.href=url;
                    });
                }
                if(data.status==2)
                {
                    layer.msg(data.msg, {icon: 6,time: 1000},function(){
                        window.location.reload();
                    });
                }
            }
        })


    }
</script>