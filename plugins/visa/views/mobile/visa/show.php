<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>{$seoinfo['seotitle']}-{$GLOBALS['cfg_webname']}</title>
    {if $seoinfo['keyword']}
    <meta name="keywords" content="{$seoinfo['keyword']}" />
    {/if}
    {if $seoinfo['description']}
    <meta name="description" content="{$seoinfo['description']}" />
    {/if}
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    {Common::css('base.css,reset-style.css')}
    {Common::css_plugin('visa.css','visa')}
    {Common::js('lib-flexible.js,jquery.min.js,delayLoading.min.js')}
</head>
<body>

    {request "pub/header_new/typeid/$typeid/isshowpage/1"}

    <div class="visa-show-top">
        <div class="pic"><img src="{Common::img($info['litpic'],750,375)}" /></div>
        <div class="tit">{$info['title']}
            {loop $info['iconlist'] $icon}
            <img src="{$icon['litpic']}" />
            {/loop}</div>
        <div class="txt">{$info['sellpoint']}</div>
        <div class="supplier_data clearfix hide">
            {if $info['suppliers']}
            <p class="supplier">供应商：{$info['suppliers']['suppliername']}</p>
            {/if}
            {if $info['xxxxx']}
            <s></s>
            <p class="num">{$info['sellnum']}人参加过</p>
            <s></s>
            <p class="dest">目的地：{$info['finaldest_name']}</p>
            {/if}
        </div>
        <div class="price">
            {if !empty($info['price'])}
            <i class="currency_sy no-style">{Currency_Tool::symbol()}</i>
            <span class="num">{$info['price']}</span>
            {else}电询{/if}
        </div>
        <ul class="info">
            <li class="item">
                <span class="num">{$info['sellnum']}</span>
                <span class="unit">销量</span>
            </li>
            <li class="item">
                <span class="num">{$info['satisfyscore']}%</span>
                <span class="unit">满意度</span>
            </li>
            <li class="item link pl">
                <span class="num">{$info['commentnum']}</span>
                <span class="unit">人点评</span>
                <i class="more-icon"></i>
            </li>
            <li class="item link question">
                <span class="num">{Model_Question::get_question_num($typeid,$info['id'])}</span>
                <span class="unit">人咨询</span>
                <i class="more-icon"></i>
            </li>
        </ul>
    </div>

    <!--优惠券-->
    {if St_Functions::is_normal_app_install('coupon')}
    {request "coupon/float_box-$typeid-".$info['id']}
    {/if}
    <div class="visa-info-container">
        <h3 class="visa-info-bar">
            <span class="title-txt">产品信息</span>
        </h3>
        <ul class="visa-info-list">
            {if !empty($info['handleday'])}
            <li class="item"><span class="hd">办理时间：</span>{$info['handleday']}</li>
            {/if}
            {if !empty($info['kindname'])}
            <li class="item"><span class="hd">签证类型：</span>{$info['kindname']}</li>
            {/if}
            {if !empty($info['country'])}
            <li class="item"><span class="hd">签证地区：</span>{$info['country']}</li>
            {/if}
            {if !empty($info['cityname'])}
            <li class="item"><span class="hd">签发城市：</span>{$info['cityname']}</li>
            {/if}
            {if !empty($info['validday'])}
            <li class="item"><span class="hd">有&nbsp;&nbsp;效&nbsp;&nbsp;期：</span>{$info['validday']}</li>
            {/if}
            <li class="item"><span class="hd">面试需要：</span>{if $info['needinterview']==1}需要{else}不需要{/if}</li>
            <li class="item"><span class="hd">邀&nbsp;&nbsp;请&nbsp;&nbsp;函：</span>{if $info['needletter']==1}需要{else}不需要{/if}</li>
            {if !empty($info['partday'])}
            <li class="item"><span class="hd">停留时间：</span>{$info['partday']}</li>
            {/if}
            {if !empty($info['acceptday'])}
            <li class="item" class="item"><span class="hd">受理时间：</span>{$info['acceptday']}</li>
            {/if}
            {if !empty($info['handlepeople'])}
            <li class="item"><span class="hd">受理人群：</span>{$info['handlepeople']}</li>
            {/if}
            {if !empty($info['belongconsulate'])}
            <li class="item"><span class="hd">所属领管：</span>{$info['belongconsulate']}</li>
            {/if}
            {if !empty($info['handlerange'])}
            <li class="item"><span class="hd">受理范围：</span>{$info['handlerange']}</li>
            {/if}
        </ul>
        <div class="visa-choose-date order" data-id="{$info['id']}"><i class="car-icon"></i>选择出行时间<i class="more-icon" ></i></div>
    </div>

        <div class="show_cont">
            {if $is_show_material}
            <div class="visa-info-container">
                <h3 class="visa-info-bar">
                    <span class="title-txt">材料所需</span>
                </h3>
                <div class="down-tab-list">
                    {loop $materials $ma}
                    {if $ma['content']}
                    <dl class="tab-item">
                        <dt class="tab-nav">
                            {$ma['title']}
                        </dt>
                        <dd class="tab-box">
                            <div class="">
                                {Product::strip_style($ma['content'])}
                            </div>
                        </dd>
                    </dl>
                    {/if}
                    {/loop}
                </div>
            </div>
            {/if}
            {st:detailcontent action="get_content" typeid="8" productinfo="$info"}
            {loop $data $row}
            {if $row['columnname']=='material'}
            {php continue}
            {/if}

            {if $row['columnname']=='attachment' && empty($info['attachment'])}
                {php continue}
            {/if}

            {if $row['columnname']=='attachment' && empty($info['attachment'])}
               {php continue}
            {/if}
            <div class="visa-info-container">
                <h3 class="visa-info-bar">
                    <span class="title-txt">{$row['chinesename']}</span>
                </h3>
                <div class="visa-info-wrapper clearfix">
                    {if $row['columnname']=='attachment'}
                    <ol class="attachment" id="attachment">
                        {loop $info['attachment']['path'] $k $v}
                        <li><a href="/pub/download/?file={$v}&name={$info['attachment']['name'][$k]}" title="{$info['attachment']['name'][$k]} 下载" class="name">{$info['attachment']['name'][$k]}</a></li>
                        {/loop}
                    </ol>
                    {else}
                    {$row['content']}
                    {/if}


                </div>
            </div>
            {/loop}
            {/st}
        </div>

    {request 'pub/code'}
    {request 'pub/footer'}

    <div class="bom_link_box">
        <div class="bom_fixed">
            <a href="tel:{$GLOBALS['cfg_m_phone']}">电话咨询</a>
            <a class="on cursor order" data-id="{$info['id']}">立即预定</a>
        </div>
    </div>


    <script>
        $(function () {

            $(".tab-item").eq(0).children(".tab-box").show();
            $(".tab-item").on("click",function(){
                var _this = $(this);
                _this.children(".tab-box").show();
                _this.siblings().children(".tab-box").hide()
            })


            $('.pl').click(function(){
                var url = SITEURL+"pub/comment/id/{$info['id']}/typeid/{$typeid}";
                window.location.href = url;
            })

            //预订按钮
            $('.order').click(function(){
                var productid = $(this).attr('data-id');
                url = SITEURL+'visa/book/id/'+productid;
                window.location.href = url;
            })

            //问答页面
            $('.question').click(function(){
                var url = SITEURL+"question/product_question_list?articleid={$info['id']}&typeid={$typeid}";
                window.location.href = url;
            })
        });

    </script>

</body>
</html>
