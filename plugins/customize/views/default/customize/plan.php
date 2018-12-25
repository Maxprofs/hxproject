<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head div_head=9vACXC >
    <meta charset="utf-8">
    <title>{$info['title']}-{$GLOBALS['cfg_webname']}</title>
    {include "pub/varname"}
    {Common::css('base.css,extend.css')}
    {Common::js('jquery.min.js,base.js,common.js,delayLoading.min.js,SuperSlide.min.js')}
    {Common::css_plugin('customize.css','customize')}

</head>

<body>
{request "pub/header"}
    <div class="big">
        <div class="wm-1200">

            <div class="st-guide">
                <a href="{$cmsurl}">{$GLOBALS['cfg_indexname']}</a>&nbsp;&nbsp;&gt;&nbsp;&nbsp;{$channelname}
            </div><!--面包屑-->

            <div class="custom-show-hd">
                <div class="info-pic">
                    <div class="pic"><img src="{Common::img($info['litpic'],1200,600)}" alt="{$info['title']}" /></div>
                    <div class="txt">
                        <h3 class="tit">{$info['title']}</h3>
                        <span class="num">浏览：{$info['shownum']}</span>
                    </div>
                </div>
                <div class="info-txt">
                    <div class="attr clearfix">
                        <span>目的地：{$info['dest']}</span>
                        <span>出发日期：{date('Y-m-d',$info['starttime'])}出发</span>
                        <span>出游天数：{$info['days']}天</span>
                        <span>成人：{$info['adultnum']}人</span>
                        <span>儿童：{$info['childnum']}人</span>
                        <span>出发地：{$info['startplace']}</span>
                        {php $extend_fields=Model_Customize_Extend_Field_Desc::get_fields();}
                        {loop $extend_fields $field}
                            {if !empty($extend_info[$field['fieldname']])}
                             <span>{$field['chinesename']}: {$extend_info[$field['fieldname']]}</span>
                            {/if}
                        {/loop}
                    </div>
                    <div class="wt-custom">
                        <a class="btn-link" href="/customize/" target="_blank"><i class="ico"></i>我要定制</a>
                    </div>
                </div>
            </div>

            <div class="custom-show-bd">
                <div class="custom-tit"><strong>出游方案</strong></div>
                <div class="con-txt clearfix">
                    {Common::content_image_width($info['content'],1200,0)}
                </div>
            </div>

        </div>
    </div>

{request "pub/footer"}
{request "pub/flink"}
</body>
</html>
