<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>笛卡CMS{$coreVersion}</title>
    {template 'stourtravel/public/public_min_js'}
    {Common::getCss('style.css,base.css,base2.css,base_new.css')}
    {Common::getScript("product_add.js")}
</head>
<body>
<!--顶部-->

<table class="content-tab">
    <tr>
        <td width="119px" class="content-lt-td" valign="top">
            {template 'stourtravel/public/leftnav'}
            <!--右侧内容区-->
        </td>
        <td valign="top" class="content-rt-td" style="overflow:auto;">
            <div class="cfg-header-bar">
                <div class="cfg-header-tab">
                    {if $is_install_article}
                    <span class="item" id="column_article" onclick="Product.switchTabs(this,'article')">攻略详情页</span>
                    {/if}

                    {if $is_install_news}
                    <span class="item" id="column_news" onclick="Product.switchTabs(this,'news')">资讯详情页</span>
                    {/if}

                    {if $is_install_notes}
                    <span class="item" id="column_notes" onclick="Product.switchTabs(this,'notes')">游记详情页</span>
                    {/if}
                </div>
                <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
            </div>
            <div class="clear clearfix">
                <form id="product_fm">
                    {if $is_install_article}
                    <div id="content_article" class="product-add-div content-hide">
                        <ul class="info-item-block">
                            <li>
                                <span class="item-hd">功能开关：</span>
                                <div class="item-bd">
                                    <label class="radio-label mr-20"><input type="radio" {if $article['status']==1}checked{/if} name="article_status" value="1">开启</label>
                                    <label class="radio-label "><input type="radio" {if $article['status']==0}checked{/if} name="article_status" value="0">关闭</label>
                                </div>
                            </li>
                            <li>
                                <span class="item-hd">推荐位置：</span>
                                <div class="item-bd">
                                    <label class="radio-label mr-20"><input type="radio" {if $article['location']==1}checked{/if} name="article_location" value="1">文前</label>
                                    <label class="radio-label "><input type="radio" {if $article['location']==2}checked{/if} name="article_location" value="2">文后</label>
                                </div>
                            </li>
                            <li>
                                <span class="item-hd">选择产品：</span>
                                <div class="item-bd">
                                    <span class="select-box w200">
                                        <select class="select" name="article_typeid">
                                            {loop $pdts $p}
                                            <option {if $p['id']==$article['typeid']}selected{/if} value="{$p['id']}">{$p['modulename']}</option>
                                            {/loop}
                                        </select>
                                    </span>
                                </div>
                            </li>
                            <li>
                                <span class="item-hd">推荐类型{Common::get_help_icon('product_seeding_kind')}：</span>
                                <div class="item-bd">
                                    <label class="radio-label mr-20"><input type="radio" {if $article['kind']==1}checked{/if} name="article_kind" value="1">热门产品</label>
                                    <label class="radio-label "><input type="radio" {if $article['kind']==2}checked{/if} name="article_kind" value="2">TAG相关产品</label>
                                </div>
                            </li>
                        </ul>
                    </div>
                    {/if}

                    {if $is_install_news}
                    <div id="content_news" class="product-add-div content-hide">
                        <ul class="info-item-block">
                            <li>
                                <span class="item-hd">功能开关：</span>
                                <div class="item-bd">
                                    <label class="radio-label mr-20"><input type="radio" {if $news['status']==1}checked{/if} name="news_status" value="1">开启</label>
                                    <label class="radio-label "><input type="radio" {if $news['status']==0}checked{/if} name="news_status" value="0">关闭</label>
                                </div>
                            </li>
                            <li>
                                <span class="item-hd">推荐位置：</span>
                                <div class="item-bd">
                                    <label class="radio-label mr-20"><input type="radio" {if $news['location']==1}checked{/if} name="news_location" value="1">文前</label>
                                    <label class="radio-label "><input type="radio" {if $news['location']==2}checked{/if} name="news_location" value="2">文后</label>
                                </div>
                            </li>
                            <li>
                                <span class="item-hd">选择产品：</span>
                                <div class="item-bd">
                                    <span class="select-box w200">
                                        <select class="select" name="news_typeid">
                                            {loop $pdts $p}
                                            <option {if $p['id']==$news['typeid']}selected{/if} value="{$p['id']}">{$p['modulename']}</option>
                                            {/loop}
                                        </select>
                                    </span>
                                </div>
                            </li>
                            <li>
                                <span class="item-hd">推荐类型{Common::get_help_icon('product_seeding_kind')}：</span>
                                <div class="item-bd">
                                    <label class="radio-label mr-20"><input type="radio" {if $news['kind']==1}checked{/if} name="news_kind" value="1">热门产品</label>
                                </div>
                            </li>
                        </ul>
                    </div>
                    {/if}

                    {if $is_install_notes}
                    <div id="content_notes" class="product-add-div content-hide">
                        <ul class="info-item-block">
                            <li>
                                <span class="item-hd">功能开关：</span>
                                <div class="item-bd">
                                    <label class="radio-label mr-20"><input type="radio" {if $notes['status']==1}checked{/if} name="notes_status" value="1">开启</label>
                                    <label class="radio-label "><input type="radio" {if $notes['status']==0}checked{/if} name="notes_status" value="0">关闭</label>
                                </div>
                            </li>
                            <li>
                                <span class="item-hd">推荐位置：</span>
                                <div class="item-bd">
                                    <label class="radio-label mr-20"><input type="radio" {if $notes['location']==1}checked{/if} name="notes_location" value="1">文前</label>
                                    <label class="radio-label "><input type="radio" {if $notes['location']==2}checked{/if} name="notes_location" value="2">文后</label>
                                </div>
                            </li>
                            <li>
                                <span class="item-hd">选择产品：</span>
                                <div class="item-bd">
                                    <span class="select-box w200">
                                        <select class="select" name="notes_typeid">
                                            {loop $pdts $p}
                                            <option {if $p['id']==$notes['typeid']}selected{/if} value="{$p['id']}">{$p['modulename']}</option>
                                            {/loop}
                                        </select>
                                    </span>
                                </div>
                            </li>
                            <li>
                                <span class="item-hd">推荐类型{Common::get_help_icon('product_seeding_kind')}：</span>
                                <div class="item-bd">
                                    <label class="radio-label mr-20"><input type="radio" {if $notes['kind']==1}checked{/if} name="notes_kind" value="1">热门产品</label>
                                </div>
                            </li>
                        </ul>
                    </div>
                    {/if}
                </form>
                <div class="clear clearfix pt-5 pb-20">
                    <a class="btn btn-primary radius size-L ml-115" id="save_btn" href="javascript:;">保存</a>
                </div>
            </div>
        </td>
    </tr>
</table>

<script>

$(function () {
    $('.cfg-header-tab').find('.item:first').trigger('click');
    $('#save_btn').click(function () {
        $.post(
            SITEURL + 'seeding/admin/seeding/ajax_save',
            $('#product_fm').serialize(),
            function (data) {
                if(data.status){
                    ST.Util.showMsg('保存成功!','4',2000);
                }
            },
            'json'
        );
    });
});

</script>

</body>
</html>