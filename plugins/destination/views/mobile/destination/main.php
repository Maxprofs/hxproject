<!doctype html>
<html>
<head table_bottom=56NzDt >
<meta charset="utf-8">
<title>{$seoinfo['seotitle']}-{$GLOBALS['cfg_webname']}</title>
{if $seoinfo['keyword']}
<meta name="keywords" content="{$seoinfo['keyword']}" />
{/if}
{if $seoinfo['description']}
<meta name="description" content="{$seoinfo['description']}" />
{/if}
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
{Common::css('base.css,destination.css')}
{Common::js('lib-flexible.js,jquery.min.js,template.js')}

</head>
<body>

  	{request "pub/header_new/typeid/$typeid"}


    <div class="dest-hd">
        {if $destinfo['litpic']}
        <a href="javascript:;" class="pic">
            <img src="{Common::img($destinfo['litpic'],750,510)}" title="{$destinfo['kindname']}"/>
            <div class="dest-msg">
                <span class="ch">{$destinfo['kindname']}</span>
                <span class="en">{strtoupper($destinfo['pinyin'])}</span>
            </div>
            {if St_Functions::is_system_app_install(6)}
            <div class="photo-link" onclick="window.open('{$cmsurl}photos/{$destinfo['pinyin']}')"><i class="icon"></i>{$destinfo['picnum']}</div>
            {/if}
        </a>
        {/if}
    </div>
    <!--目的地介绍-->

    {if !empty($destinfo['jieshao'])}
    <div class="dest-ht">
        <p class="txt">{St_Functions::cutstr_html($destinfo['jieshao'],40)}</p>
        <a class="more" id="more-dest-info" href="javascript:;">查看全部<i class="icon"></i></a>
    </div>
    {/if}

    <div class="dest-menu clearfix">
        {st:channel action="destchannel" destpinyin="$destinfo['pinyin']" row="100"}
        {loop $data $row}
        {if $row['m_typeid']==1}
        {st:line action="query" flag="mdd" destid="$destinfo['id']" row="1" return="list"}
        {elseif $row['m_typeid']==2}
        {st:hotel action="query" flag="mdd" destid="$destinfo['id']" row="1" return="list"}
        {elseif $row['m_typeid']==3}
        {st:car action="query" flag="recommend" destid="$destinfo['id']"  row="1" return="list"}
        {elseif $row['m_typeid']==5}
        {st:spot action="query" flag="mdd" destid="$destinfo['id']" row="1" return="list"}
        {elseif $row['m_typeid']==105}
        {st:campaign action="query" flag="mdd" destid="$destinfo['id']" row="1" bookstatus="2,3" return="list"}
        {elseif $row['m_typeid']==104}
        {st:ship action="query" flag="mdd" destid="$destinfo['id']" row="1" return="list"}
        {elseif $row['m_typeid']==114}
        {st:outdoor action="query" flag="mdd" destid="$destinfo['id']" row="1"  return="list"}
        {elseif $row['m_typeid']==4}
        {st:article action="query" flag="mdd_order" destid="$destinfo['id']" row="1"  return="list"}
        {elseif $row['m_typeid']==13}
        {st:tuan action="query" flag="mdd" destid="$destinfo['id']" row="1"  return="list"}
        {elseif $row['m_typeid']==6}
        {st:photo action="query" flag="mdd" destid="$destinfo['id']" row="1"  return="list"}
        {elseif $row['m_typeid']==106}
        {st:guide action="service_by_dest" destid="$destinfo['id']" row="1"  return="list"}
        {elseif $row['m_typeid']>200}
        {st:tongyong action="query" flag="mdd" destid="$destinfo['id']" typeid="$row['m_typeid']" row="1"  return="list"}
        {/if}
        {if $list}
        <a class="item" {if $list==1}{$row['m_typeid']}{/if} href="{$row['url']}">
            <span class="icon"><img src="{$row['ico']}"/></span>
            <span class="name">{$row['title']}</span>
        </a>
        {/if}
        {/loop}
        {/st}

    </div>
    <!--目的地导航-->

    <div class="layer-dest-container" id="layerDestContainer">
        <div class="layer-dest-wrap">
            <h3 class="bar-tit">{$destinfo['kindname']}</h3>
            <div class="dest-content clearfix">
                {$destinfo['jieshao']}
            </div>
        </div>
        <a class="layer-close-btn" href="javascript:;"></a>
    </div>


    {request "pub/footer"}
    {request "pub/code"}

    <script>
        $(function(){
            //目的地详情
            $("#more-dest-info").on("click",function(){
                $("#layerDestContainer").show();
            });
            $(".layer-close-btn").on("click",function(){
                $("#layerDestContainer").hide();
            })
        })
    </script>

</body>
</html>
