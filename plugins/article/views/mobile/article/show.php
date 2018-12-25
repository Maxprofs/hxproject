<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head head_top=87MzDt >
    <meta charset="utf-8">
    <title>{$seoinfo['seotitle']}-{$GLOBALS['cfg_webname']}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    {if $seoinfo['keyword']}
    <meta name="keywords" content="{$seoinfo['keyword']}" />
    {/if}
    {if $seoinfo['description']}
    <meta name="description" content="{$seoinfo['description']}" />
    {/if}
    {Common::css('base.css,reset-style.css')}
    {Common::css_plugin('article.css','article')}
    {Common::js('lib-flexible.js,jquery.min.js,delayLoading.min.js')}
</head>

<body>
    {request "pub/header_new/typeid/$typeid/isshowpage/1"}


    {if St_Functions::is_normal_app_install('product_seeding')}
    {php}
    $seeding = Model_Product_Seeding::get_info(1);
    $seeding_status = $seeding['status'];
    $seeding_location = $seeding['location'];
    $seeding_typeid = $seeding['typeid'];
    $seeding_kind = $seeding['kind'];
    {/php}
    {if $seeding_status}
    {if $seeding_location==1}
    {if $seeding_typeid>0}
    {php}
    $seeding_model = Model_Model::get_module_info($seeding_typeid);
    if ($seeding_model['id'] > 200 && $seeding_model['maintable'] == 'model_archive')
    {
    $taglib = 'tongyong';
    }
    else
    {
    $taglib = $seeding_model['pinyin'];
    }

    if($seeding_kind == 1)
    {
    $seeding_flag = 'order';
    }
    else
    {
    $seeding_flag = 'tagrelative';
    }
    {/php}
    {if $taglib == 'line'}
    {st:line action="query" flag="$seeding_flag" tagword="$tagword" row="2" return="recommends"}
    {elseif $taglib == 'outdoor'}
    {st:outdoor action="query" flag="$seeding_flag" tagword="$tagword" row="2" return="recommends"}
    {elseif $taglib == 'hotel'}
    {st:hotel action="query" flag="$seeding_flag" tagword="$tagword" row="2" return="recommends"}
    {elseif $taglib == 'car'}
    {st:car action="query" flag="$seeding_flag" tagword="$tagword" row="2" return="recommends"}
    {elseif $taglib == 'spot'}
    {st:spot action="query" flag="$seeding_flag" tagword="$tagword" row="2" return="recommends"}
    {elseif $taglib == 'visa'}
    {st:visa action="query" flag="$seeding_flag" tagword="$tagword" row="2" return="recommends"}
    {elseif $taglib == 'tuan'}
    {st:tuan action="query" flag="$seeding_flag" tagword="$tagword" row="2" return="recommends"}
    {elseif $taglib == 'ship_line'}
    {st:ship action="query" flag="$seeding_flag" tagword="$tagword" row="2" return="recommends"}
    {elseif $taglib == 'tongyong'}
    {st:tongyong action="query" flag="$seeding_flag" tagword="$tagword" typeid="$seeding_typeid" row="2" return="recommends"}
    {/if}
    {if $recommends}
	<div class="recommend-show mt-20 mb-20">
		<div class="recommend-title-bar">
			<i class="line-icon"></i>
			<span class="title-txt">今日推荐</span>
			<i class="del-icon"></i>
		</div>
		<div class="recommend-list">
			<ul class="clearfix">
                {loop $recommends $rec}
                <li class="{if $n==2}mr-0{/if}">
                    <a href="{$rec['url']}">
                        <div class="pic">
                            <img src="{$defaultimg}" st-src="{Common::img($rec['litpic'])}" alt="{$rec['title']}" title="{$rec['title']}" />
                        </div>
                        <p class="bt">{$rec['title']}</p>
                        <p class="attr clearfix">
                            {if $rec['price']}
                            <span class="price">{Currency_Tool::symbol()}<b class="no-style">{$rec['price']}</b>起</span>
                            {else}
                            <span class="price"><b class="no-style">电询</b></span>
                            {/if}
                            <span class="myd">满意度：<em>{php echo rtrim($rec['satisfyscore'], '%') . '%';}</em></span>
                        </p>
                    </a>
                </li>
                {/loop}
			</ul>
		</div>
	</div>
	<!--今日推荐-->
    {/if}
    {/if}
    {/if}
    {/if}
    {/if}

    <div class="article-show-page">
        <div class="article-show-bar">
            <h1 class="title">{$info['title']}</h1>
            <div class="info">
                <span class="item">{date('Y-m-d', $info['modtime'])}</span>
                <span class="item">{$info['author']}</span>
            </div>
        </div>
        <div class="article-summary-block">
            {$info['summary']}
        </div>
        <div class="article-show-content clearfix">
            {Product::strip_style($info['content'])}
        </div>
        <div class="article-from-bar">
            文章来源：{$info['comefrom']}
        </div>
    </div>

    <div class="st-product-block">
        <h3 class="st-title-bar">
            <i class="line-icon"></i>
            <span class="title-txt">推荐攻略</span>
        </h3>
        <ul class="st-article-list">
            {st:article action="query" flag="order" offset="0" row="4" return="articlelist" havepic="true"}
            {loop $articlelist $articlerow}
            <li>
                <a class="item" href="{$articlerow['url']}">
                    <div class="pic">
                        <img src="{$defaultimg}" st-src="{Common::img($articlerow['litpic'],258,164)}" alt="{$articlerow['title']}" />
                    </div>
                    <div class="info">
                        <div class="tit">{$articlerow['title']}</div>
                        <div class="txt">{Common::cutstr_html($articlerow['summary'],30)}</div>
                        <div class="data">
                            {if $articlerow['lastdest']['kindname']}
                                <span class="mdd"><i class="icon"></i>{$articlerow['lastdest']['kindname']}</span>
                            {/if}
                            {if $articlerow['shownum']}
                            <span class="num"><i class="icon"></i>{$articlerow['shownum']}</span>
                            {/if}
                        </div>
                    </div>
                </a>
            </li>
            {/loop}
            {/st}
        </ul>
    </div>
    <!--推荐攻略-->

    {if St_Functions::is_normal_app_install('product_seeding')}
    {php}
    $seeding = Model_Product_Seeding::get_info(1);
    $seeding_status = $seeding['status'];
    $seeding_location = $seeding['location'];
    $seeding_typeid = $seeding['typeid'];
    $seeding_kind = $seeding['kind'];
    {/php}
    {if $seeding_status}
    {if $seeding_location==2}
    {if $seeding_typeid>0}
    {php}
    $seeding_model = Model_Model::get_module_info($seeding_typeid);
    if ($seeding_model['id'] > 200 && $seeding_model['maintable'] == 'model_archive')
    {
    $taglib = 'tongyong';
    }
    else
    {
    $taglib = $seeding_model['pinyin'];
    }

    if($seeding_kind == 1)
    {
    $seeding_flag = 'order';
    }
    else
    {
    $seeding_flag = 'tagrelative';
    }
    {/php}
    {if $taglib == 'line'}
    {st:line action="query" flag="$seeding_flag" tagword="$tagword" row="2" return="recommends"}
    {elseif $taglib == 'outdoor'}
    {st:outdoor action="query" flag="$seeding_flag" tagword="$tagword" row="2" return="recommends"}
    {elseif $taglib == 'hotel'}
    {st:hotel action="query" flag="$seeding_flag" tagword="$tagword" row="2" return="recommends"}
    {elseif $taglib == 'car'}
    {st:car action="query" flag="$seeding_flag" tagword="$tagword" row="2" return="recommends"}
    {elseif $taglib == 'spot'}
    {st:spot action="query" flag="$seeding_flag" tagword="$tagword" row="2" return="recommends"}
    {elseif $taglib == 'visa'}
    {st:visa action="query" flag="$seeding_flag" tagword="$tagword" row="2" return="recommends"}
    {elseif $taglib == 'tuan'}
    {st:tuan action="query" flag="$seeding_flag" tagword="$tagword" row="2" return="recommends"}
    {elseif $taglib == 'ship_line'}
    {st:ship action="query" flag="$seeding_flag" tagword="$tagword" row="2" return="recommends"}
    {elseif $taglib == 'tongyong'}
    {st:tongyong action="query" flag="$seeding_flag" tagword="$tagword" typeid="$seeding_typeid" row="2" return="recommends"}
    {/if}
    {if $recommends}
    <div class="recommend-show mb-20">
		<div class="recommend-title-bar">
			<i class="line-icon"></i>
			<span class="title-txt">今日推荐</span>
			<i class="del-icon"></i>
		</div>
		<div class="recommend-list">
			<ul class="clearfix">
                {loop $recommends $rec}
				<li class="{if $n==2}mr-0{/if}">
					<a href="{$rec['url']}">
						<div class="pic"><img src="{$defaultimg}" st-src="{Common::img($rec['litpic'])}" alt="{$rec['title']}" title="{$rec['title']}" /></div>
						<p class="bt">{$rec['title']}</p>
						<p class="attr clearfix">
                            {if $rec['price']}
                            <span class="price">{Currency_Tool::symbol()}<b class="no-style">{$rec['price']}</b>起</span>
                            {else}
                            <span class="price"><b class="no-style">电询</b></span>
                            {/if}
                            <span class="myd">满意度：<em>{php echo rtrim($rec['satisfyscore'], '%') . '%';}</em></span>
						</p>
					</a>
				</li>
                {/loop}
			</ul>
		</div>
	</div>
	<!--今日推荐-->
    {/if}
    {/if}
    {/if}
    {/if}
    {/if}
    {request 'pub/code'}
    {request 'pub/footer'}
    {include 'pub/article_write_html'}

</body>
</html>
