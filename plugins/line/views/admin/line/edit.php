<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>笛卡CMS{$coreVersion}</title>
    {template 'stourtravel/public/public_min_js'}
    {Common::getCss('style.css,base.css,base2.css,base_new.css,order.show.css')}
    {Common::getScript("jquery.upload.js,product_add.js,choose.js,st_validate.js,jquery.colorpicker.js,imageup.js,jquery.upload.js,insurance.js")}
    <style>
        #linedoc-content{  margin-left: 10px; line-height: 30px; list-style: none; clear: both;}
        #linedoc-content li{ list-style-position: inside; list-style: decimal;}
        #linedoc-content span{ padding-right:5px;}
        #linedoc-content span.del{ color: #f00; cursor:pointer;margin: 0 5px;}
        #linedoc-content span.del:hover{text-decoration:underline }
    </style>
</head>
<body>
<!--顶部-->
{php Common::getEditor('jseditor','',$sysconfig['cfg_admin_htmleditor_width'],300,'Sline','','print',true);}
<table class="content-tab" script_right=y_KzDt >
    <tr>
        <td width="119px" class="content-lt-td" valign="top">
            {template 'stourtravel/public/leftnav'}
            <!--右侧内容区-->
        </td>
        <td valign="top" class="content-rt-td" style="overflow:auto;">
            <div class="cfg-header-bar">
                <div class="cfg-header-tab">
                    <span class="item on" id="column_basic" onclick="Product.switchTabs(this,'basic')">基础信息</span>
                    {loop $columns $col}
                    <span class="item" id="column_{$col['columnname']}" onclick="Product.switchTabs(this,'{$col['columnname']}',switchBack)">{$col['chinesename']}</span>
                    {/loop}
                    <span class="item " id="column_tupian" onclick="Product.switchTabs(this,'tupian')">图片</span>
                    <span class="item " id="column_promotion" onclick="Product.switchTabs(this,'promotion')">促销</span>
                    <span class="item" id="column_seo" onclick="Product.switchTabs(this,'seo')">优化</span>
                    <span class="item" id="column_template" onclick="Product.switchTabs(this,'template')">模板</span>

                    <span class="item" id="column_extend" onclick="Product.switchTabs(this,'extend')">扩展{Common::get_help_icon('extend_filed')}</span>
                </div>
                <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
            </div>
            <div class="clear clearfix">
                <form id="product_fm">
                    <div id="content_basic" class="product-add-div content-show">
                        <ul class="info-item-block">
                            <li>
                                <span class="item-hd">选择站点{Common::get_help_icon('product_site')}：</span>
                                <div class="item-bd">
                                        <span class="select-box w200">
                                            <select class="select" name="webid">
                                                <option value="0" {if $info['webid']==0}selected="selected"{/if}>主站</option>
                                                {loop $weblist $web}
                                                <option {if $web['webid']==$info['webid']}selected="selected"{/if} value="{$web['webid']}">{$web['webname']}</option>
                                                {/loop}
                                            </select>
                                        </span>
                                </div>
                            </li>
                            <li>
                                <span class="item-hd">产品标题{Common::get_help_icon('product_title')}：</span>
                                <div class="item-bd">
                                    <input type="text" name="title" data-required="true" class="input-text w800" value="{$info['title']}"/>
                                    <input type="hidden" name="lineid" id="line_id" value="{$info['id']}"/>
                                </div>
                            </li>
                            <li>
                                <span class="item-hd">标题颜色{Common::get_help_icon('product_color')}：</span>
                                <div class="item-bd">
                                    <input type="text" name="color" value="{$info['color']}" style="color:  {$info['color']}"  class="input-text w100 title-color"/>
                                    <span style=" display: inline-block; width: 15px; height: 15px; vertical-align: middle; background: {$info['color']}"></span>
                                </div>
                            </li>
                            <li>
                                <span class="item-hd">产品卖点{Common::get_help_icon('product_sellpoint')}：</span>
                                <div class="item-bd">
                                    <input type="text" name="sellpoint" value="{$info['sellpoint']}"  class="input-text w800"/>
                                </div>
                            </li>
                            <li>
                                <span class="item-hd">旅游天数{Common::get_help_icon('line_travel_days')}：</span>
                                <div class="item-bd">
                                    <input type="text" value="{$info['lineday']}" data-regrex="number" data-required="true" data-msg="必须为数字" id="travel_days" class="input-text w80" name="lineday"/>
                                    <span class="ml-5">天</span>
                                    <input type="text" value="{$info['linenight']}" data-regrex="number" data-msg="必须为数字" class="input-text w80 ml-10" name="linenight"/>
                                    <span class="ml-5">晚</span>
                                </div>
                                </dd>
                            </li>
                            <li>
                                <span class="item-hd">提前天数{Common::get_help_icon('line_advance_days')}：</span>
                                <div class="item-bd">
                                    <span class="item-text va-t">建议提前</span>
                                    <input type="text" name="linebefore" value="{$info['linebefore']}" data-regrex="number" data-msg="必须为数字" class="input-text w50 va-t ml-5"/>
                                    <span class="ml-5">天报名</span>
                                    <label class="radio-label ml-10"><input type="checkbox" name="islinebefore" value="1" {if $info['islinebefore']==1}checked="checked"{/if}/>少于提前天数，则禁止预订</label>
                                </div>
                            </li>
                            <li>
                                <span class="item-hd">上/下架{Common::get_help_icon('product_shelves')}：</span>
                                <div class="item-bd">
                                    <label class="radio-label"><input type="radio" name="status"  {if $info['status']==3}checked="checked"{/if} value="3">上架</label>
                                    <label class="radio-label ml-20"><input type="radio" name="status"  {if $info['status']==2}checked="checked"{/if} value="2">下架</label>
                                </div>
                            </li>
                        </ul>
                        <div class="line"></div>
                        <ul class="info-item-block">
                            <li>
                                <span class="item-hd">目的地{Common::get_help_icon('product_destination')}：</span>
                                <div class="item-bd">
                                    <a href="javascript:;" class="fl btn btn-primary radius size-S mt-3" onclick="Product.getDest(this,'.dest-sel',1)" title="选择">选择</a>
                                    <div class="save-value-div ml-10 dest-sel">
                                        {loop $info['kindlist_arr'] $k $v}
                                        <span class="mb-5 {if $info['finaldestid']==$v['id']}finaldest{/if}" title="{if $info['finaldestid']==$v['id']}最终目的地{/if}" ><s onclick="$(this).parent('span').remove()"></s>{$v['kindname']}<input type="hidden" class="lk" name="kindlist[]" value="{$v['id']}"/>
                                                   {if $info['finaldestid']==$v['id']}<input type="hidden" class="fk" name="finaldestid" value="{$info['finaldestid']}"/>{/if}</span>
                                        {/loop}
                                    </div>
                                </div>
                            </li>
                            <li>
                                <span class="item-hd">出发地{Common::get_help_icon('line_startcity')}：</span>
                                <div class="item-bd">
                                    <a href="javascript:;" class="fl btn btn-primary radius size-S mt-3" onclick="Product.setStartPlace(this,'.dest-sel')" title="选择">选择</a>
                                    <div class="save-value-div ml-10 start_place">
                                        {loop $startplacelist $place}
                                        {if $place['id']==$info['startcity']}
                                        <span class="mb-5 finaldest" ><s onclick="$(this).parent('span').remove()"></s>{$place['cityname']}
                                            <input type="hidden" class="lk" name="startcity" value="{$info['startcity']}"/>
                                        </span>
                                        {/if}
                                        {/loop}
                                    </div>
<!--                                    <span class="select-box w200">-->
<!--                                        <select class="select" name="startcity">-->
<!--                                            <option value="0">请选择出发地</option>-->
<!--                                            {loop $startplacelist $place}-->
<!--                                            <option value="{$place['id']}" {if $info['startcity']==$place['id']}selected="selected"{/if}>{$place['cityname']}</option>-->
<!--                                            {/loop}-->
<!--                                        </select>-->
<!--                                    </span>-->
                                </div>
                            </li>
                            <li>
                                <span class="item-hd">产品属性{Common::get_help_icon('product_attr')}：</span>
                                <div class="item-bd">
                                    <a href="javascript:;" class="fl btn btn-primary radius size-S mt-3" onclick="Product.getAttridNew(this,'.attr-sel',1)" title="选择">选择</a>
                                    <div class="type-bar-block clearfix attr-sel">
                                        {loop $info['attrlist_arr']  $v}
                                        {if $v['pid']==0}
                                        <ul class="info-item-block">
                                            <li>
                                                <span class="item-hd">{$v['attrname']}：</span>
                                                <input type="hidden" name="attrlist[]" value="{$v['id']}"/>
                                                <div class="item-bd attr-parent-div" pid="{$v['id']}">
                                                    {loop $info['attrlist_arr']  $a}
                                                    {if $a['pid']==$v['id']}
                                                    <span class="choose-child-item mb-5 mr-5">{$a['attrname']}<i onclick="Product.removeAttrNew(this)" class="icon-Close"></i></span>
                                                    <input type="hidden" name="attrlist[]" value="{$a['id']}"/>
                                                    {/if}
                                                    {/loop}
                                                </div>
                                            </li>
                                        </ul>
                                        {/if}
                                        {/loop}
                                    </div>
                                </div>
                            </li>
                            <?php   $cfg_icon_rule = Model_Sysconfig::get_configs(0,array('cfg_icon_rule'));
                            $cfg_icon_rule = $cfg_icon_rule['cfg_icon_rule']; ?>
                            {if $cfg_icon_rule==1}
                            <li>
                                <span class="item-hd">图标设置{Common::get_help_icon('product_icon')}：</span>
                                <div class="item-bd">
                                    <a href="javascript:;" class="fl btn btn-primary radius size-S mt-3" onclick="Product.getIconNew(this,'.icon-sel')" title="选择">选择</a>
                                    <div class="save-value-div ml-10 icon-sel">
                                        {loop $info['iconlist_arr'] $k $v}
                                        <span class="mb-5 " title="{$v['kind']}" >
                                            <s onclick="$(this).parent('span').remove()"></s>{$v['kind']}
                                            <input type="hidden" class="lk" name="iconlist[]" value="{$v['id']}"/>
                                        </span>
                                        {/loop}
                                    </div>
                                </div>
                            </li>
                            {else}
                            <li>
                                <span class="item-hd">图标设置{Common::get_help_icon('product_icon')}：</span>
                                <div class="item-bd">
                                    <a href="javascript:;" class="fl btn btn-primary radius size-S mt-3" onclick="Product.getIcon(this,'.icon-sel')" title="选择">选择</a>
                                    <div class="save-value-div ml-10 icon-sel">
                                        {loop $info['iconlist_arr'] $k $v}
                                        <span class="mb-5"><s onclick="$(this).parent('span').remove()"></s><img src="{$v['picurl']}"><input type="hidden" name="iconlist[]" value="{$v['id']}"></span>
                                        {/loop}
                                    </div>
                                </div>
                            </li>
                            {/if}
                            <li>
                                <span class="item-hd">供应商{Common::get_help_icon('product_supplier')}：</span>
                                <div class="item-bd">
                                    <a href="javascript:;" class="fl btn btn-primary radius size-S mt-3" onclick="Product.getSupplier(this,'.supplier-sel',1)" title="选择">选择</a>
                                    <div class="save-value-div ml-10 supplier-sel">
                                        {if !empty($info['supplier_arr']['id'])}
                                        <span class="mb-5"><s onclick="$(this).parent('span').remove()"></s>{$info['supplier_arr']['suppliername']}<input type="hidden" name="supplierlist[]" value="{$info['supplier_arr']['id']}"></span>
                                        {/if}
                                    </div>
                                </div>
                            </li>
                            {php}$contractlist = Model_Contract::get_product_contract_list(1){/php}
                            {if $contractlist}
                            <li>
                                <span class="item-hd">合同{Common::get_help_icon('product_contract')}：</span>

                                <div class="item-bd">
                                    <div id="contract_list">
                                        {loop $contractlist $contract}
                                        <a   {if $info['contractid']==$contract['id']}class="label-module-cur-item mr-5"{else}class="label-module-item mr-5"{/if}  href="javascript:void(0)" data-value="{$contract['id']}" onclick="setContract(this)">{$contract['title']}</a>
                                        {/loop}
                                        <input type="hidden" name="contractid" id="contractid" value="{$info['contractid']}"/>
                                    </div>
                                </div>
                            </li>
                            {/if}
                        </ul>
                    </div>
                    <div id="content_tupian" class="product-add-div content-hide">
                        <ul class="info-item-block">
                            <li>
                                <span class="item-hd">图片{Common::get_help_icon('product_images')}：</span>
                                <div class="item-bd">
                                    <div class="">
                                        <div id="pic_btn" class="btn btn-primary radius size-S mt-3">上传图片</div>
                                        <span class="item-text c-999 ml-10">建议上传尺寸1024*695px</span>
                                    </div>
                                    <div class="up-list-div">
                                        <ul class="clearfix">
                                            <?php
                                            $pic_arr = explode(',', $info['piclist']);
                                            $litpic_arr = explode('||', $info['litpic']);

                                            $img_index = 1;
                                            $head_index = 0;
                                            foreach ($pic_arr as $k => $v) {
                                                if (empty($v))
                                                    continue;
                                                $imginfo_arr = explode('||', $v);
                                                $headpic_style = $imginfo_arr[0] == $litpic_arr[0] ? 'style="display: block; background: green;"' : '';
                                                $head_index = $imginfo_arr[0] == $litpic_arr[0] ? $img_index : $head_index;
                                                $headpic_hint = $imginfo_arr[0] == $litpic_arr[0] ? '已设为封面' : '设为封面';
                                                $html = '<li class="img-li">';
                                                $html .= '<div class="pic"><img class="fl" src="' . $imginfo_arr[0] . '" /></div>';
                                                $html .= '<p class="p1">';
                                                $html .= '<input type="text" class="img-name" name="imagestitle[' . $img_index . ']" value="' . $imginfo_arr[1] . '">';
                                                $html .= '<input type="hidden" class="img-path" name="images[' . $img_index . ']" value="' . $imginfo_arr[0] . '">';
                                                $html.='</p>';
                                                $html.='<p class="p2">';
                                                $html.='<span class="btn-ste" onclick="Imageup.setHead(this,' . $img_index . ')" ' . $headpic_style . '>' . $headpic_hint . '</span><span class="btn-closed" onclick="Imageup.delImg(this,\'' . $imginfo_arr[0] . '\',' . $img_index . ')"></span>';
                                                $html.='</p></li>';
                                                echo $html;
                                                $img_index++;
                                            }
                                            echo '<script> window.image_index=' . $img_index . ';</script>';
                                            ?>
                                        </ul>
                                        <input type="hidden" class="headimgindex" name="imgheadindex" value="<?php  echo $head_index;  ?>">
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <ul class="info-item-block">
                            <li>
                                <span class="item-hd">视频{Common::get_help_icon('product_video')}：</span>
                                <div class="item-bd">
                                    <div class="mt-3">
                                        <a href="javascript:;" class="btn btn-primary radius size-S" id="uploadVideo">上传视频</a>
                                        <span class="item-text ml-10 c-999">视频大小不超过5M</span>
                                    </div>
                                    <ul class="up-video-list" id="videoContent">
                                        {if $info['product_video']}
                                        {php}list(,$videoName)=explode('|',$info['product_video']){/php}
                                        <li><input name="product_video" type="hidden" value="{$info['product_video']}"><span class="v-name">{$videoName}</span><a href="javascript:;" class="btn-link ml-20" onclick="videoNode()">删除</a></li>
                                        {/if}
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div id="content_promotion" class="product-add-div content-hide">
                        <div class="pd-10">
                            {if St_Functions::is_system_app_install(111)}
                            <div class="order-show-wrap mb-10">
                                <div class="order-show-bar">
                                    <span class="order-bar-tit c-primary">附加产品</span>
                                </div>
                                {request 'insurance/admin/insurance/product_add/typeid/1/productid/'.$info['id']}
                            </div>
                            {/if}
                            {if St_Functions::is_normal_app_install('together')}
                            <div class="order-show-wrap mb-10">
                                <div class="order-show-bar">
                                    <span class="order-bar-tit c-primary">拼团策略</span>
                                </div>
                                {request 'together/admin/together/product_add/typeid/1/productid/'.$info['id'].'/menuid/'.$_GET['menuid']}
                            </div>
                            {/if}
                            <div class="mb-10">
                                <div class="order-show-bar">
                                    <span class="order-bar-tit c-primary">积分策略{Common::get_help_icon('product_integral_strategy')}</span>
                                </div>
                                <ul class="info-item-block">
                                    <li>
                                        <span class="item-hd">预订送积分策略：</span>
                                        <div class="item-bd">
                                            <a href="javascript:;" class="fl btn btn-primary radius size-S mt-3" onclick="Product.getJifenbook(this,'.jifenbook-sel',1)" title="选择">选择</a>
                                            <div class="save-value-div ml-10 jifenbook-sel">
                                                {if !empty($info['jifenbook_info'])}
                                            <span><s onclick="$(this).parent('span').remove()"></s>{$info['jifenbook_info']['title']}({$info['jifenbook_info']['value']}{if $info['jifenbook_info']['rewardway']==1}%{/if}积分)
                                                    {if $info['jifenbook_info']['isopen']==0}<a class="cor_f00">[已关闭]</a>{/if}<input type="hidden" name="jifenbook_id" value="{$info['jifenbook_info']['id']}">
                                                </span>
                                                {/if}
                                            </div>
                                            <span class="item-text ml-10 c-999">*未选择的情况下默认使用全局策略</span>
                                        </div>
                                    </li>
                                    <li>
                                        <span class="item-hd">积分抵现策略：</span>
                                        <div class="item-bd">
                                            <a href="javascript:;" class="fl btn btn-primary radius size-S mt-3" onclick="Product.getJifentprice(this,'.jifentprice-sel',1)" title="选择">选择</a>
                                            <div class="save-value-div ml-10 jifentprice-sel">
                                                {if !empty($info['jifentprice_info'])}
                                            <span><s onclick="$(this).parent('span').remove()"></s>{$info['jifentprice_info']['title']}({$info['jifentprice_info']['toplimit']}积分)
                                                    {if $info['jifentprice_info']['isopen']==0}<a class="cor_f00">[已关闭]</a>{/if}<input type="hidden" name="jifentprice_id" value="{$info['jifentprice_info']['id']}">
                                                </span>
                                                {/if}
                                            </div>
                                            <span class="item-text ml-10 c-999">*未选择的情况下默认使用全局策略</span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="">
                                <div class="order-show-bar">
                                    <span class="order-bar-tit c-primary">促销数据</span>
                                </div>

                                <ul class="info-item-block">
                                    <li>
                                        <div class="item-bd" style="padding-left: 50px">
                                            <span class="item-text">推荐次数<input type="text" name="recommendnum" value="{$info['recommendnum']}" data-regrex="number" data-msg="*必须为数字" class="input-text w100 ml-5 reset-input"/></span>
                                            <span class="item-text ml-20">满意度{Common::get_help_icon('product_satisfaction')}<input type="text" name="satisfyscore" value="{if !$info['id']}100 {else}{$info['satisfyscore']}{/if}" data-regrex="number" data-max="100"  data-msg="*必须为数字" class="input-text w100 ml-5 reset-input"/></span>
                                            <span class="item-text ml-20">销量{Common::get_help_icon('product_sales')}<input type="text" name="bookcount" value="{$info['bookcount']}" data-regrex="number" data-msg="*必须为数字" class="input-text w100 ml-5 reset-input"/></span>
                                        </div>
                                    </li>
                                </ul>

                            </div>
                        </div>
                    </div>

                    <div id="content_jieshao" class="product-add-div content-hide">
                        <ul class="info-item-block">
                            <li>
                                <span class="item-hd">排版方式：</span>
                                <div class="item-bd">
                                    <a class=" mr-5 {if $info['isstyle']==2 OR empty($info['isstyle'])}label-module-cur-item{else}label-module-item{/if}" href="javascript:void(0)"  onclick="togStyle(this,2)">标准版</a>
                                    <a class=" mr-5 {if $info['isstyle']==1}label-module-cur-item{else}label-module-item{/if}" href="javascript:void(0)"  onclick="togStyle(this,1)">简洁版</a>

                                    <input type="hidden" name="isstyle" id="line_isstyle" value="{$info['isstyle']}"/>
                                </div>
                            </li>
                        </ul>

                        <ul class="info-item-block content-jieshao-detail-extend" style="<?php  if($info['isstyle']==1) echo 'display:none'   ?>">
                            <div class="line"></div>
                            <li>
                                <span class="item-hd">行程附件{Common::get_help_icon('line_word_stoke')}：</span>
                                <div class="item-bd">
                                    <div class="">
                                        <a id="attach_btn" class="btn btn-primary radius size-S mt-3" href="javascript:;">上传附件</a>
                                        <span class="item-text" id="linedoc-content">
                            {loop $info['linedoc']['path'] $k $v}
                                    <span class="name">{$info['linedoc']['name'][$k]}</span>
                                            <input type="hidden" name="linedoc[name][]" value="{$info['linedoc']['name'][$k]}">
                                            <input type="hidden" class="path" name="linedoc[path][]" value="{$v}">
                                            <span class="del">删除</span>
                            {/loop}
                                        </span>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <span class="item-hd">用餐情况：</span>
                                <div class="item-bd">
                                    <div class="on-off">
                                        <label class="radio-label"><input type="radio" onclick="togDiner(1)" name="showrepast" value="1" {if $info['showrepast']==1 OR !isset($info['showrepast'])}checked="checked"{/if}>显示</label>
                                        <label class="radio-label ml-20"><input type="radio" onclick="togDiner(0)" {if $info['showrepast']==0 AND isset($info['showrepast'])}checked="checked"{/if} name="showrepast" value="0">隐藏</label>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <span class="item-hd">住宿情况：</span>
                                <div class="item-bd">
                                    <div class="on-off">
                                        <label class="radio-label"><input type="radio" onclick="togHotel(1)" name="showhotel" value="1" {if $info['showhotel']==1 OR !isset($info['showhotel'])}checked="checked"{/if}>显示</label>
                                        <label class="radio-label ml-20"><input type="radio" onclick="togHotel(0)" {if $info['showhotel']==0 AND isset($info['showhotel'])}checked="checked"{/if} name="showhotel" value="0">隐藏</label>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <span class="item-hd">往返交通：</span>
                                <div class="item-bd">
                                    <div class="on-off">
                                        <label class="radio-label"><input type="radio" onclick="togTran(1)" name="showtran" value="1" {if $info['showtran']==1 OR !isset($info['showtran'])}checked="checked"{/if}>显示</label>
                                        <label class="radio-label ml-20"><input type="radio" onclick="togTran(0)" {if $info['showtran']==0 AND isset($info['showtran'])}checked="checked"{/if} name="showtran" value="0">隐藏</label>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <div class="line"></div>
                        <div class="content-jieshao-simple  mt-10" style="<?php  if(empty($info['isstyle'])||$info['isstyle']==2) echo 'display:none'   ?>">
                            <div>
                                <textarea name="jieshao" id="simple_jieshao">{$info['jieshao']}</textarea>
                            </div>
                        </div>
                            <div class="content-jieshao-detail" style="<?php  if($info['isstyle']==1) echo 'display:none'   ?>">

                            <?php


                            foreach($info['linejieshao_arr'] as $k=>$v)
                            {
                                $jiaotong = '';
                                $transport_arr=explode(',',$v['transport']);
                                foreach($sysjiaotong as $v1)
                                {
                                    $checkstatus = in_array($v1,$transport_arr) ? "checked='checked'" : '';
                                    $jiaotong.="<label class=\"radio-label mr-20\" style=\"cursor:pointer;\"><span class=\"\"><input class=\"\" type=\"checkbox\" ".$checkstatus."  name=\"transport[".$v['day']."][]\" value=\"".$v1."\"/></span>".$v1."</label>";
                                }

                                foreach($transport_arr as $user)
                                {
                                    if(!in_array($user,$sysjiaotong) && !empty($user))
                                    {
                                        $jiaotong.="<label class=\"radio-label mr-20\" style=\"cursor:pointer;\"><span class=\"\"><input checked='checked'  class=\"\" type=\"checkbox\"  name=\"transport[".$v['day']."][]\" value=\"".$user."\"/></span>".$user."</label>";

                                    }

                                }
                                $jiaotong.=" <span id=\"addjt_".$v['day']."\"></span><a href='javascript:;' class='addimg btn btn-primary radius size-S va-m' data-contain='addjt_".$v['day']."' data-day='".$v['day']."'>添加</a>";


                                $breakfirst_check=$v['breakfirsthas']==1?'checked="checked"':'';
                                $lunch_check=$v['lunchhas']==1?'checked="checked"':'';
                                $supper_check=$v['supperhas']==1?'checked="checked"':'';
                                $transport_arr=explode(',',$v['transport']);
                                $car_check=in_array(2,$transport_arr)?'checked="checked"':'';
                                $train_check=in_array(3,$transport_arr)?'checked="checked"':'';
                                $plane_check=in_array(1,$transport_arr)?'checked="checked"':'';
                                $ship_check=in_array(4,$transport_arr)?'checked="checked"':'';
                                $food_style=$info['showrepast']==0?"display:none":'';
                                $hotel_style=$info['showrepast']==0?"display:none":'';
                                $tran_style=$info['showrepast']==0?"display:none":'';
                                $dayspot= Model_Line::get_day_spot_html($v['day'],$v['lineid']);
                                $jieshao='<ul class="info-item-block">';
                                $jieshao.='<li><span class="item-hd">第'.$v['day'].'天：</span>';
                                $jieshao.='<div class="item-bd">';
                                $jieshao.='<input type="text" name="jieshaotitle['.$v['day'].']" value="'.$v['title'].'" class="input-text w800"/></div>';
                                $jieshao.='</li>';
                                $jieshao.='<li class="jieshao-diner" style="'.$food_style.'">';
                                $jieshao.='<span class="item-hd">用餐情况：</span>';
                                $jieshao.='<div class="item-bd">';
                                $jieshao.='<span class="item-text"><label class="radio-label"><input type="checkbox" name="breakfirsthas['.$v['day'].']" '.$breakfirst_check.' value="1">早餐</label>';
                                $jieshao.='<input class="input-text w200 ml-5 va-t" type="text" name="breakfirst['.$v['day'].']" value="'.$v['breakfirst'].'"/></span>';
                                $jieshao.='<span class="item-text ml-20"><label class="radio-label"><input type="checkbox" name="lunchhas['.$v['day'].']" '.$lunch_check.' value="1">午餐</label>';
                                $jieshao.='<input class="input-text w200 ml-5 va-t" type="text" name="lunch['.$v['day'].']" value="'.$v['lunch'].'"/></span>';
                                $jieshao.='<span class="item-text ml-20"><label class="radio-label"><input type="checkbox" name="supperhas['.$v['day'].']" '.$supper_check.' value="1">晚餐</label>';
                                $jieshao.='<input class="input-text w200 ml-5 va-t" type="text"name="supper['.$v['day'].']" value="'.$v['supper'].'"/></span>';
                                $jieshao.='</div>';
                                $jieshao.='</li>';
                                $jieshao.='<li  class="jieshao-hotel" style="'.$hotel_style.'"><span class="item-hd">住宿情况：</span>';
                                $jieshao.='<div class="item-bd"><input type="text" class="input-text w200" name="hotel['.$v['day'].']" value="'.$v['hotel'].'"></div>';
                                $jieshao.='</li>';
                                $jieshao.='<li  class="jieshao-tran" style="'.$tran_style.'"><span class="item-hd">交通工具：</span>';
                                $jieshao.='<div class="item-bd">';
                                $jieshao.=$jiaotong;
                                $jieshao.='</div>';
                                $jieshao.='</li>';
                                $jieshao.='<li class="xc-con">';
                                $jieshao.='<span class="item-hd">行程内容：</span>';
                                $jieshao.='<div class="item-bd">';
                                $jieshao.='<textarea name="txtjieshao['.$v['day'].']" style=" float:left" id="line_content_'.$v['day'].'">'.$v['jieshao'].'</textarea>';
                                $jieshao.='</div>';
                                $jieshao.='</li>';
                                if(St_Functions::is_system_app_install(5))
                                {
                                    $jieshao.='<li>';
                                    $jieshao.='<span class="item-hd">相关景点'.Common::get_help_icon('line_extract_spots').'：</span>';
                                    $jieshao.='<div class="item-bd"><input type="button" class="fl btn btn-primary radius size-S mt-4" value="提取" onclick="autoGetSpot('.$v['day'].')"><div class="save-value-div mt-2 ml-10" id="listspot_'.$v['day'].'">'.$dayspot.'</div></div>';
                                    $jieshao.='</li>';
                                }

                                $jieshao.='</ul>';
                                $jieshao.='<div class="line"></div>';
                                echo $jieshao;
                            }

                            ?>
                        </div>
                    </div>
                    <div id="content_biaozhun" class="product-add-div content-hide">
                        <ul class="info-item-block">
                            <li>
                                <span class="item-hd" id="content_biaozhun_title"></span>
                                <div class="item-bd">
                                    <textarea id="biaozhun" name="biaozhun">{$info['biaozhun']}</textarea>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div id="content_beizu" class="product-add-div content-hide">
                        <ul class="info-item-block">
                            <li>
                                <span class="item-hd" id="content_beizu_title"></span>
                                <div class="item-bd">
                                    <textarea id="beizu" name="beizu">{$info['beizu']}</textarea>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div id="content_payment" class="product-add-div content-hide">
                        <ul class="info-item-block">
                            <li>
                                <span class="item-hd" id="content_payment_title"></span>
                                <div class="item-bd">
                                    <textarea id="payment" name="payment">{$info['payment']}</textarea>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div id="content_feeinclude" class="product-add-div content-hide">
                        <ul class="info-item-block">
                            <li>
                                <span class="item-hd" id="content_feeinclude_title"></span>
                                <div class="item-bd">
                                    <textarea id="feeinclude" name="feeinclude">{$info['feeinclude']}</textarea>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div id="content_features" class="product-add-div content-hide">
                        <ul class="info-item-block">
                            <li>
                                <span class="item-hd" id="content_features_title"></span>
                                <div class="item-bd">
                                    <textarea id="features" name="features">{$info['features']}</textarea>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div id="content_reserved1" class="product-add-div content-hide">
                        <ul class="info-item-block">
                            <li>
                                <span class="item-hd" id="content_reserved1_title"></span>
                                <div class="item-bd">
                                    <textarea id="reserved1" name="reserved1">{$info['reserved1']}</textarea>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div id="content_reserved2" class="product-add-div content-hide">
                        <ul class="info-item-block">
                            <li>
                                <span class="item-hd" id="content_reserved2_title"></span>
                                <div class="item-bd">
                                    <textarea id="reserved2" name="reserved2">{$info['reserved2']}</textarea>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div id="content_reserved3" class="product-add-div content-hide">
                        <ul class="info-item-block">
                            <li>
                                <span class="item-hd" id="content_reserved3_title"></span>
                                <div class="item-bd">
                                    <textarea id="reserved3" name="reserved3">{$info['reserved3']}</textarea>
                                </div>
                            </li>
                        </ul>
                    </div>



                    <div id="content_template" class="product-add-div content-hide">
                        <ul class="info-item-block">
                            <li>
                                <span class="item-hd">电脑端模板{Common::get_help_icon('product_template_set')}：</span>
                                <input type="hidden" name="templet" id="templet" value="{$info['templet']}"/>
                                <div class="item-bd" id="templet_list_pc">

                                </div>
                            </li>
                            <li>
                                <span class="item-hd">移动端模板{Common::get_help_icon('product_template_set')}：</span>
                                <input type="hidden" name="wap_templet" id="wap_templet" value="{$info['wap_templet']}"/>
                                <div class="item-bd" id="templet_list_wap">


                                </div>
                            </li>
                        </ul>
                    </div>
                    <div id="content_seo" class="product-add-div content-hide">
                        <ul class="info-item-block">
                            <li>
                                <span class="item-hd">优化标题{Common::get_help_icon('content_seotitle')}：</span>
                                <div class="item-bd">
                                    <input type="text" name="seotitle" value="{$info['seotitle']}" class="input-text w600">
                                </div>
                            </li>

                            <li>
                                <span class="item-hd">Tag词{Common::get_help_icon('content_tagword')}：</span>
                                <div class="item-bd">
                                    <!-- <input type="button" class="btn-sum-xz mt-4" value="提取">-->
                                    <input type="text" name="tagword" class="input-text w600 " value="{$info['tagword']}">
                                </div>
                            </li>
                            <li>
                                <span class="item-hd">关键词{Common::get_help_icon('content_keyword')}：</span>
                                <div class="item-bd">
                                    <input type="text" name="keyword" value="{$info['keyword']}" class="input-text w600">
                                </div>
                            </li>
                            <li>
                                <span class="item-hd">页面描述{Common::get_help_icon('content_description')}：</span>
                                <div class="item-bd">
                                    <textarea class="set-area"  style="width: 588px"  name="description" cols="" rows="">{$info['description']}</textarea>
                                </div>
                            </li>
                            <li>
                                <span class="item-hd">301重定向{Common::get_help_icon('httpstatus_301')}：</span>
                                <div class="item-bd">
                                    <input type="text" name="redirect_url" id="redirecturl"  class="input-text w600" value="{$info['redirect_url']}">
                                </div>
                            </li>
                        </ul>
                    </div>

                    {php $contentArr=Common::getExtendContent(1,$extendinfo);}
                    {php echo $contentArr['contentHtml'];}
                    <div id="content_extend" class="product-add-div content-hide">
                        {php echo $contentArr['extendHtml'];}
                    </div>
                </form>
                <div class="clear clearfix pt-20 pb-20 mt-5 mb-20">
                    <a class="btn btn-primary radius size-L ml-115" id="save_btn" href="javascript:;">保存</a>
                </div>
            </div>
        </td>
    </tr>
</table>

<script>

    var is_spot_open=parseInt('{if St_Functions::is_system_app_install(5)}1{else}0{/if}');
    $(document).ready(function(e) {

        //编辑器
        window.biaozhun=window.JSEDITOR('biaozhun');
        window.simple_jieshao=window.JSEDITOR('simple_jieshao');
        window.beizu=window.JSEDITOR('beizu');
        window.payment=window.JSEDITOR('payment');
        window.feeinclude=window.JSEDITOR('feeinclude');
        window.features=window.JSEDITOR('features');
        window.reserved1=window.JSEDITOR('reserved1');
        window.reserved2=window.JSEDITOR('reserved2');
        window.reserved3=window.JSEDITOR('reserved3');

        //保存状态
        window.is_saving = 0;

        //颜色选择器
        $(".title-color").colorpicker({
            ishex:true,
            success:function(o,color){
                $(o).val(color);
                $(o).next().css('background',color)
            },
            reset:function(o){
                $(o).val('');
                $(o).next().css('background','')
            }
        });

        var validate_action={};

        $("#product_fm input,#product_fm textarea").st_readyvalidate(validate_action);

        $("#save_btn").click(function(e) {

            //检测是否是在保存状态
            if(is_saving == 1){
                return false;
            }
            window.is_saving = 1;

            //行程安排模式,先关闭,后面需要再加上.
            /*
            var content_style = $("#line_isstyle").val();
            var valid = true;
            var msg = '';

            if(content_style == 2){
                $("input[name^='jieshaotitle']").each(function(i,obj){

                    if($(obj).val().length == 0)
                    {
                        valid = false;
                        msg = '行程天数标题还没有填写完整';
                        return false
                    }
                })*/


                /*$("textarea[name^='txtjieshao']").each(function(i,obj){
                    var icontent = $(obj).val();
                    if(icontent.length == 0){
                        valid = false;
                        msg = '线路行程内容没有填写完整';
                        return false;
                    }
                })

            }
            if(!valid){
                ST.Util.showMsg(msg,5,1000);
                window.is_saving = 0;
                return false;
            }*/


            var validate=$("#product_fm input,#product_fm textarea").st_govalidate({require:function(element,index){
                $(element).css("border","1px solid red");
                if(index==1)
                {
                    var switchDiv=$(element).parents(".product-add-div").first();
                    if(switchDiv.is(":hidden")&&!switchId)
                    {
                        var switchId=switchDiv.attr('id');
                        var columnId=switchId.replace('content','column');
                        $("#"+columnId).trigger('click');
                    }
                }
            }});

            if(validate==true)
            {
                ST.Util.showMsg('保存中',6,10000);

                $.ajaxform({
                    url   :  SITEURL+"line/admin/line/ajax_save",
                    method  :  "POST",
                    form  : "#product_fm",
                    dataType  :  "JSON",
                    success  :  function(result)
                    {
                        var text = result;
                        if(window.isNaN(text))
                        {
                            ZENG.msgbox._hide();
                            ST.Util.showMsg('保存失败,请检查权限！',5);
                        }
                        else
                        {

                            $("#line_id").val(text);
                            ST.Util.showMsg('保存成功',4)
                        }
                        window.is_saving = 0;


                    }});

            }
            else
            {
                ST.Util.showMsg("请将信息填写完整",1,1200);
                window.is_saving = 0;
            }
        });



        ajax_get_template();
        $('select[name=webid]').change(function () {
            ajax_get_template();
        })

    });

    //切换时的回调函数
    function switchBack(columnname)
    {

        if($('#column_'+columnname).length>0){
            if( $('#content_'+columnname+'_title').length>0){
                $('#content_'+columnname+'_title').html($('#column_'+columnname).text()+'：');
            }
        }

        if(columnname=='jieshao')
        {
            var days=$("#travel_days").val();
            if(days<=0)
            {
                ST.Util.showMsg("请先填写旅游天数",1,1500);
                $("#travel_days").css("border","1px solid red");
                $("#column_basic").trigger("click");
            }
            else
            {
                var showrepast = $('input[name=showrepast]:checked').val();
                var showhotel = $('input[name=showhotel]:checked').val();
                var showtran = $('input[name=showtran]:checked').val();
                var html="";
                var jieshao_num=$(".content-jieshao-detail").find('.info-item-block').length;
                jieshao_num=!jieshao_num?0:jieshao_num;
                var jiaotong = '';
                jiaotong+='<label class="radio-label mr-20"><input class="" type="checkbox"value="飞机" name="transport[{day}][]">';
                jiaotong+='飞机</label>';
                jiaotong+='<label class="radio-label mr-20"><input class="" type="checkbox" name="transport[{day}][]" value="高铁">';
                jiaotong+='高铁</label>';
                jiaotong+='<label class="radio-label mr-20"><input class="" type="checkbox" name="transport[{day}][]" value="自驾"/>';
                jiaotong+='自驾</label>';
                jiaotong+='<label class="radio-label mr-20"><input class="" type="checkbox" name="transport[{day}][]" value="大巴"/>';
                jiaotong+='大巴</label>';
                jiaotong+='<label class="radio-label mr-20"><input class="" type="checkbox" name="transport[{day}][]" value="邮轮">';
                jiaotong+='邮轮</label>';
                jiaotong+="<span id=\"addjt_{day}\"></span><a href='javascript:;' class='addimg btn btn-primary radius size-S ml-20' data-contain='addjt_{day}' data-day='{day}'>添加</a>";

                var day_content='<ul class="info-item-block">';
                day_content+='<li><span class="item-hd">第{day}天：</span>';
                day_content+='<div class="item-bd">';
                day_content+='<input type="text" name="jieshaotitle[{day}]" value="" class="input-text w800"/></div>';
                day_content+='</li>';
                day_content+='<li class="jieshao-diner">';
                day_content+='<span class="item-hd">用餐情况：</span>';
                day_content+='<div class="item-bd">';
                day_content+='<span class="item-text"><label class="radio-label"><input class="" type="checkbox" name="breakfirsthas[{day}]" value="1">';
                day_content+='早餐</label>';
                day_content+='<input class="input-text w200 ml-5" type="text" name="breakfirst[{day}]"/></span>';
                day_content+='<span class="item-text ml-20"><label class="radio-label"><input class="" type="checkbox" name="lunchhas[{day}]" value="1">';
                day_content+='午餐</label>';
                day_content+='<input class="input-text w200 ml-5" type="text" name="lunch[{day}]" value=""/></span>';
                day_content+='<span class="item-text ml-20"><label class="radio-label"><input class="" type="checkbox" name="supperhas[{day}]"  value="1">';
                day_content+='晚餐</label>';
                day_content+='<input class="input-text w200 ml-5" type="text" name="supper[{day}]" value=""/></span>';
                day_content+='</div>';
                day_content+='</li>';
                day_content+='<li class="jieshao-hotel"><span class="item-hd">住宿情况：</span>';
                day_content+='<div class="item-bd"><input type="text"  class="set-text-xh text_222 mt-2" name="hotel[{day}]"></div>';
                day_content+='</li>';
                day_content+='<li class="jieshao-tran"><span class="item-hd">交通工具：</span>';
                day_content+='<div class="item-bd">';
                day_content+=jiaotong;
                day_content+='</div>';
                day_content+='</li>';
                day_content+='<li class="xc-con">';
                day_content+='<span class="item-hd">行程内容：</span>';
                day_content+='<div class="item-bd">';
                day_content+='<textarea name="txtjieshao[{day}]" style=" float:left" id="line_content_{day}"></textarea>';
                day_content+='</div>';
                day_content+='</li>';
                //if(St_Functions::is_system_app_install(5))
                if(is_spot_open==1)
                {
                    day_content+='<li>';
                    day_content+='<span class="item-hd">相关景点'+ST.Util.getGridHelp('line_extract_spots')+'：</span>';
                    day_content+='<div class="item-bd"><input type="button" class="btn btn-primary radius size-S mt-4" value="提取" onclick="autoGetSpot({day})"><div class="save-value-div mt-2 ml-10" id="listspot_{day}"></div></div>';
                    day_content+='</li>';
                }

                day_content+='</ul>';
                day_content+='<div class="line"></div>';
                if(jieshao_num<days)
                {
                    for(var i=jieshao_num+1;i<=days;i++)
                    {
                        html+=day_content.replace(/\{day\}/g,i);
                    }
                    $(".content-jieshao-detail").append(html);
                }
                else if(jieshao_num>days)
                {
                    $(".content-jieshao-detail .info-item-block").each(function (i,obj) {
                        if(i+1>days)
                        {
                            $(obj).next('.line').remove();
                            $(obj).remove();
                        }

                    });

                   // $(".content-jieshao-detail").find('.info-item-block').gt(days).remove();
                }

                for(var i=1;i<=days;i++)
                {
                    window['line_content_'+i]=window.JSEDITOR('line_content_'+i);
                }

                togDiner(showrepast);
                togHotel(showhotel);
                togTran(showtran);

                addJiaoTong2();
            }
        }
    }

    function setContract(obj) {

        if($(obj).hasClass('label-module-cur-item'))
        {
            $(obj).removeClass('label-module-cur-item');
            $(obj).addClass('label-module-item');
            $('#contractid').val(0);
        }
        else
        {
            $('#contract_list a').removeClass('label-module-cur-item');
            $('#contract_list a').addClass('label-module-item');
            $(obj).addClass('label-module-cur-item');
            $(obj).removeClass('label-module-item');
            var id = $(obj).data('value');
            $('#contractid').val(id);
        }


    }

    function togDiner(num)
    {
        if(num==1)
        {
            $(".jieshao-diner").show();
        }
        else
            $(".jieshao-diner").hide();
    }
    function togHotel(num)
    {
        if(num==1)
        {
            $(".jieshao-hotel").show();
        }
        else
            $(".jieshao-hotel").hide();
    }
    function togTran(num)
    {
        if(num==1)
        {
            $(".jieshao-tran").show();
        }
        else
            $(".jieshao-tran").hide();
    }
    function togStyle(dom,num)
    {
        $("#line_isstyle").val(num);
        $(dom).parent().find('a').removeClass('label-module-cur-item');
        $(dom).parent().find('a').addClass('label-module-item');
        $(dom).addClass('label-module-cur-item');
        $(dom).removeClass('label-module-item');
        if(num==1)
        {
            $(".content-jieshao-detail").hide();
            $(".content-jieshao-detail-extend").hide();
            $(".content-jieshao-simple").show();
        }
        else
        {
            $(".content-jieshao-detail-extend").show();
            $(".content-jieshao-detail").show();
            $(".content-jieshao-simple").hide();
        }
    }

    //删除附件
    function delDoc()
    {
        var lineid = '{$info['id']}';
        $.ajax({
            type:'POST',
            url:SITEURL+'line/admin/line/ajax_del_doc',
            data:{lineid:lineid},
            dataType:'json',
            success:function(data){
                if(data.status){
                    $("#doclist").html('');
                    ST.Util.showMsg('删除成功',4,1000);

                };
            }
        })
    }

    //一键提取景点
    function autoGetSpot(i)
    {

        //var totalday="{sline:var.fields.lineday/}";
        var lineid=$("#line_id").val();
        if(lineid==0)return;
        var icontent = window['line_content_'+i].getContent();
        $.ajax(
            {
                type: "post",
                data: {content:icontent,lineid:lineid,day:i},
                url: SITEURL+"line/admin/line/ajax_getspot",
                dataType:'json',
                beforeSend:function(){
                    ST.Util.showMsg('正在提取...',6,5000);
                },
                success: function(data,textStatus)
                {
                    if(data.length>0)
                    {
                        var html='';
                        $.each(data,function(i,row){
                            html+='<span><s onclick="delDaySpot(this,\''+row.autoid+'\')"></s>'+row.title+'</span>'

                        })
                        $("#listspot_"+i).append(html);//显示提取到的景点

                        ST.Util.showMsg('提取成功!',4,1000);
                    }
                    else
                    {
                        ST.Util.showMsg("提取失败",5,1000);
                    }


                },
                error: function()
                {
                    ST.Util.showMsg("请求出错",5,1000);
                }

            });

    }
    //删除提取的景点
    function delDaySpot(obj,autoid)
    {
        $.ajax({
            type:'POST',
            data:{autoid:autoid},
            url:SITEURL+'line/admin/line/ajax_del_dayspot',
            dataType:'json',
            success:function(data){
                if(data.status){
                    $(obj).parent().remove();
                }
            }
        })
    }

    //设置模板
    function setTemplet(obj)
    {
        var templet = $(obj).data('value');
        var select = $(obj).data('type');
        $(obj).parent().find('a').removeClass('label-module-cur-item');
        $(obj).parent().find('a').addClass('label-module-item');
        $(obj).addClass('label-module-cur-item');
        $(obj).removeClass('label-module-item');
        $("#"+select).val(templet);
    }

    //添加交通
    function addJiaoTong()
    {
        var myDate = new Date();
        var mid = "jt_"+myDate.getMilliseconds();//毫秒数
        var html = "<input name=\"transport_pub[]\" type=\"checkbox\" class=\"checkbox\" id=\""+mid+"\" value=\"\">&nbsp;<label for=\"Transport\"><input type=\"text\" class=\"uservalue\" data-value=\""+mid+"\" style=\"width:70px;border-left:none;border-right:none;border-top:none\"  value=\"\"></label>";
        $("#addjt").append(html);

        $('.uservalue').unbind('input propertychange').bind('input propertychange', function() {
            var datacontain = $(this).attr('data-value');
            $('#'+datacontain).val($(this).val());
        });
    }

    $(function(){
        addJiaoTong2();
    });

    function addJiaoTong2()
    {
        $(".addimg").unbind('click').click(function(){
            var day = $(this).attr('data-day');
            var datacontain = $(this).attr('data-contain');

            var myDate = new Date();
            var mid = "jt_" + myDate.getMilliseconds();//毫秒数
            var html = "<input  class=\"mt-8\" type=\"checkbox\"  name=\"transport["+day+"][]\" id=\""+mid+"\" value=\"\"/>&nbsp;<label class=\"ml-5 mr-20\" style=\"cursor:pointer;\"><input type=\"text\" class=\"day_uservalue\" data-value=\"" + mid + "\" style=\"width:70px;border-left:none;border-right:none;border-top:none\"  value=\"\"></label>";


            $("#"+datacontain).append(html);

            $('.day_uservalue').unbind('input propertychange').bind('input propertychange', function () {
                var datacontain = $(this).attr('data-value');
                $('#' + datacontain).val($(this).val());
            });

        })
    }

    //获取可用模板
    function ajax_get_template() {
        var webid = $('select[name=webid]').val();
        var template = "{$info['templet']}";
        var wap_templet = "{$info['wap_templet']}";
        $.ajax({
            type:'post',
            dataType:'json',
            url:SITEURL+'line/admin/line/ajax_get_template_list',
            data:{page:'line_show',webid:webid},
            success:function (data) {

                if(data.pclist.length>0)
                {
                    var pchtml = '';
                    $(data.pclist).each(function (i,v) {
                        var itemclass = 'label-module-item';
                        if ((!template || template=='line_show.htm') && v.isuse == 1)
                        {
                            itemclass = 'label-module-cur-item';
                        }
                        else if (template == v.pagepath)
                        {
                            itemclass = 'label-module-cur-item';
                        }
                        pchtml += '<a  class="'+itemclass+' mr-5"  href="javascript:void(0)" data-type="templet" data-value="'+v.pagepath+'" onclick="setTemplet(this)">'+v.title+'</a>';
                    });
                    $('#templet_list_pc').html(pchtml);
                }
                if(data.waplist.length>0)
                {
                    var waphtml = '';
                    $(data.waplist).each(function (i,v) {
                        var itemclass = 'label-module-item';

                        if (wap_templet == v.pagepath)
                        {
                            itemclass = 'label-module-cur-item';
                        }
                        waphtml += '<a  class="'+itemclass+' mr-5"  href="javascript:void(0)" data-type="wap_templet" data-value="'+v.pagepath+'" onclick="setTemplet(this)">'+v.title+'</a>';
                    });
                    $('#templet_list_wap').html(waphtml);
                }


            }



        })



    }


</script>

<script>
    var action = '{$action}';
    var id='{$info['id']}';
    $('#pic_btn').click(function(){
        ST.Util.showBox('上传图片', SITEURL + 'image/insert_view', 0,0, null, null, document, {loadWindow: window, loadCallback: Insert});
        function Insert(result,bool){
            var len=result.data.length;
            for(var i=0;i<len;i++){
                var temp =result.data[i].split('$$');
                Imageup.genePic(temp[0],".up-list-div ul",".cover-div",temp[1]);
            }
        }
    });


    $('#attach_btn').click(function(){
        // 上传方法
        $.upload({
            // 上传地址
            url: SITEURL+'uploader/uploaddoc',
            // 文件域名字
            fileName: 'Filedata',
            fileType: 'doc,docx,pdf',
            // 其他表单数据
            params: {uploadcookie:"<?php echo Cookie::get('username')?>"},
            // 上传完成后, 返回json, text
            dataType: 'json',
            // 上传之前回调,return true表示可继续上传
            onSend: function() {
                return true;
            },
            // 上传之后回调
            onComplate: function(info) {
                if(info.status){
                    if(info.status){
                        var html='<span class="name">'+info.name+'</span><input type="hidden" name="linedoc[name][]" value="'+info.name+'"><input class="path" type="hidden" name="linedoc[path][]" value="'+info.path+'"><span class="del">删除</span>';
                        $("#linedoc-content").html(html);
                    }
                }
            }
        });
    })


    $('#uploadVideo').click(function(){
        // 上传方法
        $.upload({
            // 上传地址
            url: SITEURL+'uploader/video',
            // 文件域名字
            fileName: 'video',
            fileType: 'mp4',
            // 其他表单数据
            params: {uploadcookie:"<?php echo Cookie::get('username')?>"},
            // 上传完成后, 返回json, text
            dataType: 'json',
            // 上传之前回调,return true表示可继续上传
            onSend: function() {
                return true;
            },
            // 上传之后回调
            onComplate: function(info) {
                if(info.status){
                    $('#videoContent').html('<li><input name="product_video" type="hidden" value="'+info.data.path+'|'+info.data.name+'"><span class="v-name">'+info.data.name+'</span><a href="javascript:;" class="btn-link ml-20" onclick="videoNode()">删除</a></li>');
                }
            }
        });

    });
    function videoNode(_this){
        $('#videoContent').html('');
    }
    function updateInsurance(result,bool)
    {
        var container= $('.insurance-sel');
        container.children().remove();
        var html='';
        var productsArr=result.data;
        for(var i in productsArr)
        {
            var product=productsArr[i];
            html+='<span><s onclick="$(this).parent(\'span\').remove()"></s>';
            html+=product['productname'];
            html+='<input type="hidden" name="insuranceids[]" value="'+product['id']+'">'
            html+='</span>'
        }
        container.append(html);

    }
    $("#linedoc-content").find('.del').live('click',function(){
        var parent=$(this).parent();
        $.post(SITEURL+'line/admin/line/ajax_del_doc/',{'file':parent.find('.path').val(),'id':id},function(rs){
            if(rs.status){
                parent.html('');
            }
        },'json');
    });


</script>

</body>
</html>
