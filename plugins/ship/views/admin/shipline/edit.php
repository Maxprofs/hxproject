<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>笛卡CMS{$coreVersion}</title>
    {template 'stourtravel/public/public_js'}
    {php echo Common::getCss('style.css,base.css,base2.css,jqtransform.css,base_new.css'); }
    {php echo Common::getCss('ext-theme-neptune-all-debug.css','js/extjs/resources/ext-theme-neptune/'); }
    {php echo Common::getScript("uploadify/jquery.uploadify.min.js,product_add.js,choose.js,st_validate.js,jquery.colorpicker.js,jquery.jqtransform.js,imageup.js,jquery.upload.js,insurance.js"); }
    {php echo Common::getCss('uploadify.css','js/uploadify/'); }
    <style>
        #linedoc-content{  margin-left: 50px; line-height: 30px; list-style: none; clear: both;}
        #linedoc-content li{ list-style-position: inside; list-style: decimal;}
        #linedoc-content span{ padding-right:5px;}
        #linedoc-content span.del{ color: #f00; cursor:pointer;margin: 0 5px;}
        #linedoc-content span.del:hover{text-decoration:underline }
    </style>
</head>



<body>
<!--顶部-->
{php Common::getEditor('jseditor','',$sysconfig['cfg_admin_htmleditor_width'],300,'Sline','','print',true);}
<table class="content-tab">
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
                    <span class="item" id="column_{$col['columnname']}" onclick="Product.switchTabs(this,'{$col['columnname']}',switchBacks)">{$col['chinesename']}</span>
                {/loop}    
                <span class="item" id="column_seo" onclick="Product.switchTabs(this,'seo')">优化</span>
                <span class="item" id="column_extend" onclick="Product.switchTabs(this,'extend')">扩展设置</span>
    		</div>
    		<a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>	
    	</div>
    	
            <div class="manage-nr">
                <form id="product_fm" table_float=R6ByYj >
                <div id="content_basic" class="product-add-div content-show">
                	<ul class="info-item-block">
                		<li>
                			<span class="item-hd">航线名称：</span>
                			<div class="item-bd">
                				<input type="text" name="title" data-required="true" class="input-text w700" value="{$info['title']}"/>
                                <input type="hidden" name="lineid" id="line_id" value="<?php echo $info['id'];   ?>"/>
                			</div>
                		</li>
                		<li>
                			<span class="item-hd">邮轮选择：</span>
                			<div class="item-bd">
                				<span class="select-box w150 mr-10">
                					 <select class="select" name="supplierlist" id="supplierlist_sel">
                                        <option value="0">请选择邮轮公司</option>
                                        {loop $supplierlist $supplier}
                                        <option value="{$supplier['id']}" {if $info['supplierlist']==$supplier['id']}selected="selected"{/if}>{$supplier['suppliername']}</option>
                                        {/loop}
                                    </select>
                				</span>
                				<span class="select-box w150">
                					<select class="select" name="shipid" id="shipid_sel">
                                        <option value="0">请选择邮轮</option>
                                        {loop $shiplist $ship}
                                        <option value="{$ship['id']}" {if $info['shipid']==$ship['id']}selected="selected"{/if}>{$ship['title']}</option>
                                        {/loop}
                                    </select>
                				</span>	
                			</div>
                		</li>
                		<li>
                			<span class="item-hd">行程天数：</span>
                			<div class="item-bd">
                				<span class="select-box w150">
                					<select class="select" name="scheduleid" id="shipdate_sel">
	                                    <option value="">请选择邮轮天数</option>
	                                    {loop $schedulelist $schedule}
	                                      <option value="{$schedule['id']}" {if $info['scheduleid']==$schedule['id']}selected="selected"{/if}>{$schedule['title']}</option>
	                                    {/loop}
	                                </select>
                				</span>	
                			</div>
                		</li>
                		<li>
                			<span class="item-hd">航线属性：</span>
                			<div class="item-bd">
                				<a href="javascript:;" class="fl btn btn-primary radius size-S mt-3" onclick="Product.getAttrid(this,'.attr-sel',104)" title="选择">选择</a>
                				<div class="save-value-div mt-2 ml-10 attr-sel w700">
                                    {loop $info['attrlist_arr'] $k $v}
                                    <span class="mb-5"><s onclick="$(this).parent('span').remove()"></s>{$v['attrname']}<input type="hidden" name="attrlist[]" value="{$v['id']}"></span>
                                    {/loop}
                                </div>
                			</div>
                		</li>
                		<li>
                			<span class="item-hd">出发地：</span>
                			<div class="item-bd">
                				<span class="select-box w150">
	                				<select class="select" name="startcity">
	                                    <option value="0">请选择出发地</option>
	                                {loop $startplacelist $place}
	                                    <option value="{$place['id']}" {if $info['startcity']==$place['id']}selected="selected"{/if}>{$place['cityname']}</option>
	                                {/loop}
	                                </select>
                				</span>	
                			</div>
                		</li>
                		<li>
                			<span class="item-hd">目的地选择：</span>
                			<div class="item-bd">
                				<a href="javascript:;" class="fl btn btn-primary radius size-S mt-3" onclick="Product.getDest(this,'.dest-sel',104)" title="选择">选择</a>
                				 <div class="save-value-div mt-2 ml-10 dest-sel w700">
                                    {loop $info['kindlist_arr'] $k $v}

                                       <span class="mb-5 {if $info['finaldestid']==$v['id']}finaldest{/if}" title="{if $info['finaldestid']==$v['id']}最终目的地{/if}" ><s onclick="$(this).parent('span').remove()"></s>{$v['kindname']}<input type="hidden" class="lk" name="kindlist[]" value="{$v['id']}"/>
                                           {if $info['finaldestid']==$v['id']}<input type="hidden" class="fk" name="finaldestid" value="{$info['finaldestid']}"/>{/if}</span>
                                    {/loop}
                                </div>
                			</div>
                		</li>
                		<li>
                			<span class="item-hd">提前天数：</span>
                			<div class="item-bd">
                				<span class="item-text va-t">建议提前</span>
                				 <input type="text" name="linebefore" value="{$info['linebefore']}" data-regrex="number" data-msg="必须为数字" class="input-text w50 va-t ml-5"/>
                				 <span class="ml-5">天报名</span>
                				 <label class="radio-label ml-10"><input type="checkbox" name="islinebefore" value="1" {if $info['islinebefore']==1}checked="checked"{/if}/>报价显示限制提前天数</label>
                			</div>
                		</li>
                		<li>
                			<span class="item-hd">航线卖点：</span>
                			<div class="item-bd">
                				<input type="text" name="sellpoint" value="{$info['sellpoint']}"  class="input-text w700"/>
                			</div>
                		</li>
                	</ul>
                	<div class="line"></div>
                	<ul class="info-item-block">
                		<li>
                			<span class="item-hd">预订送积分策略：</span>
                			<div class="item-bd">
                				 <a href="javascript:;" class="fl btn btn-primary radius size-S mt-3" onclick="Product.getJifenbook(this,'.jifenbook-sel',104)" title="选择">选择</a>
                				 <div class="save-value-div mt-2 ml-10 jifenbook-sel">
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
                				<a href="javascript:;" class="fl btn btn-primary radius size-S mt-3" onclick="Product.getJifentprice(this,'.jifentprice-sel',104)" title="选择">选择</a>
                				<div class="save-value-div mt-2 ml-10 jifentprice-sel">
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
                <div id="content_jieshao" class="product-add-div content-hide">
					<ul class="info-item-block">
						<li>
							<span class="item-hd">旅游天数：</span>
							<div class="item-bd">
								<input type="text" value="{$info['lineday']}" data-regrex="number" data-required="true" data-msg="必须为数字" id="travel_days" class="input-text w60" name="lineday" onblur="switchBack()"/>
								<span class="item-text ml-10">*天</span>
								<input type="text" value="{$info['linenight']}" data-regrex="number" data-msg="必须为数字" class="input-text w60 ml-10" name="linenight"/>								
                                <span class="item-text ml-10">晚</span>
							</div>
						</li>
						<li>
							<span class="item-hd">排版方式：</span>
							<div class="item-bd">
								<div class="temp-chg">
                                    <a <?php if($info['isstyle']==2 ||empty($info['isstyle'])) echo 'class="on"';   ?> href="javascript:void(0)" onclick="togStyle(this,2)">标准版</a>
                                    <a <?php if($info['isstyle']==1) echo 'class="on"';   ?> href="javascript:void(0)" onclick="togStyle(this,1)">简洁版</a>
                                    <input type="hidden" name="isstyle" id="line_isstyle" value="{$info['isstyle']}"/>
                                </div>
							</div>
						</li>
					</ul>
                    
                    <div class="content-jieshao-simple" style="<?php  if(empty($info['isstyle'])||$info['isstyle']==2) echo 'display:none'   ?>">
                    	<textarea class="ml-80" name="jieshao" id="simple_jieshao">{$info['jieshao']}</textarea>
                    </div>
                    <div class="content-jieshao-detail" style="<?php  if($info['isstyle']==1) echo 'display:none'   ?>">

                        <?php
                           foreach($info['linejieshao_arr'] as $k=>$v)
                           {


                               $breakfirst_check=$v['breakfirsthas']==1?'checked="checked"':'';
                               $lunch_check=$v['lunchhas']==1?'checked="checked"':'';
                               $supper_check=$v['supperhas']==1?'checked="checked"':'';
                               $starttime_check=$v['starttimehas']==1?'checked="checked"':'';
                               $endtime_check=$v['endtimehas']==1?'checked="checked"':'';
                               $country_check=$v['countryhas']==1?'checked="checked"':'';
                               $living_check=$v['livinghas']==1?'checked="checked"':'';

                               $jieshao='<div class="add-class" style="border-bottom:none;">';
                               $jieshao.='<ul class="info-item-block">';
                               $jieshao.='<li><span class="item-hd">第'.$v['day'].'天：</span>';
                               $jieshao.='<div class="item-bd">';
                               $jieshao.='<input type="text" name="jieshaotitle['.$v['day'].']" value="'.$v['title'].'" class="input-text w700"/></div>';
                               $jieshao.='</li>';
                               $jieshao.='<li class="jieshao-diner">';
                               $jieshao.='<span class="item-hd"></span>';
                               $jieshao.='<div class="item-bd">';

                               $jieshao.='<label class="check-label fl"><input type="checkbox" name="endtimehas['.$v['day'].']" value="1" '.$endtime_check.'>抵港时间</label>';
                               $jieshao.='<input class="input-text w200 ml-5 mr-20 fl" type="text" name="endtime['.$v['day'].']" value="'.$v['endtime'].'"/>';
                               $jieshao.='<label class="check-label fl"><input type="checkbox" name="starttimehas['.$v['day'].']" value="1" '.$starttime_check.'>启航时间</label>';
                               $jieshao.='<input class="input-text w200 ml-5 mr-20 fl" type="text" name="starttime['.$v['day'].']" value="'.$v['starttime'].'"/>';
                               $jieshao.='</div>';
                               $jieshao.='</li>';
                               $jieshao.='<li class="jieshao-diner">';
                               $jieshao.='<span class="item-hd"></span>';
                               $jieshao.='<div class="item-bd">';
                               $jieshao.='<label class="check-label fl"><input type="checkbox" name="breakfirsthas['.$v['day'].']" '.$breakfirst_check.' value="1">邮轮早餐</label>';
                               $jieshao.='<input class="input-text w200 ml-5 mr-20 fl" type="text" name="breakfirst['.$v['day'].']" value="'.$v['breakfirst'].'"/>';
                               $jieshao.='<label class="check-label fl"><input type="checkbox" name="lunchhas['.$v['day'].']" value="1" '.$lunch_check.'>邮轮午餐</label>';
                               $jieshao.='<input class="input-text w200 ml-5 mr-20 fl" type="text" name="lunch['.$v['day'].']" value="'.$v['lunch'].'"/>';
                               $jieshao.='<label class="check-label fl"><input type="checkbox" name="supperhas['.$v['day'].']" value="1" '.$supper_check.'>邮轮晚餐</label>';
                               $jieshao.='<input class="input-text w200 ml-5 mr-20 fl" type="text" name="supper['.$v['day'].']" value="'.$v['supper'].'"/>';
                               $jieshao.='</div>';
                               $jieshao.='</li>';
                               $jieshao.='<li class="jieshao-diner">';
                               $jieshao.='<span class="item-hd"></span>';
                               $jieshao.='<div class="item-bd">';
                               $jieshao.='<label class="check-label fl"><input type="checkbox" name="countryhas['.$v['day'].']" value="1" '.$country_check.' >国家城市</label>';
                               $jieshao.='<input class="input-text w200 ml-5 mr-20 fl" type="text" name="country['.$v['day'].']" value="'.$v['country'].'"/>';
                               $jieshao.='<label class="check-label fl"><input type="checkbox" name="livinghas['.$v['day'].']" value="1" '.$living_check.'>入住</label>';
                               $jieshao.='<input class="input-text w200 ml-5 mr-20 fl" type="text" name="living['.$v['day'].']" value="'.$v['living'].'"/>';
                               $jieshao.='</div>';
                               $jieshao.='</li>';
                               $jieshao.='<li class="xc-con">';
                               $jieshao.='<span class="item-hd">行程内容：</span>';
                               $jieshao.='<div class="item-bd">';
                               $jieshao.='<textarea name="txtjieshao['.$v['day'].']" style=" float:left" id="line_content_'.$v['day'].'">'.$v['content'].'</textarea>';
                               $jieshao.='</div>';
                               $jieshao.='</li>';
                               $jieshao.='</ul></div>';
                               echo $jieshao;
                           }

                        ?>
                    </div>
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
                <div id="content_visacontent" class="product-add-div content-hide">
                	<ul class="info-item-block">
                        <li>
                        	<span class="item-hd" id="content_visacontent_title"></span>
                        	<div class="item-bd">
                                <textarea id="visacontent" name="visacontent">{$info['visacontent']}</textarea>
                            </div>
                        </li>
                   </ul>    	
                </div>
                <div id="content_bookcontent" class="product-add-div content-hide">
                	<ul class="info-item-block">
                		<li>
                			<span class="item-hd" id="content_bookcontent_title"></span>
                			<div class="item-bd">
                				<textarea id="bookcontent" name="bookcontent">{$info['bookcontent']}</textarea>
                			</div>
                		</li>
                	</ul>
                </div>

                <div id="content_linedoc" class="product-add-div content-hide">
                        <div  class="up-pic">
                            <dl>
                                <dt>行程附件：</dt>
                                <dd>
                                    <div class="up-file-div">
                                        <div id="attach_btn" class="btn-file mt-4">上传附件</div>
                                        <input type="hidden" name="linedoc" id="linedoc" value="{$info['linedoc']}">
                                    </div>
                                </dd>
                            </dl>
                            <ol id="linedoc-content">
                                {loop $info['linedoc']['path'] $k $v}
                                <li><span class="name">{$info['linedoc']['name'][$k]}</span><input type="hidden" name="linedoc[name][]" value="{$info['linedoc']['name'][$k]}"><input type="hidden" class="path" name="linedoc[path][]" value="{$v}"><span class="del">删除</span></li>
                                {/loop}
                            </ol>
                        </div>
                    </div>
                <div id="content_tupian" class="product-add-div content-hide">
					<ul class="info-item-block">
						<li>
							<span class="item-hd">图片：</span>
							<div class="item-bd">
								<div class="">
									<div id="pic_btn" class="btn btn-primary radius size-S mt-3">上传图片</div>
									 <span class="item-text c-999 ml-10">建议上传尺寸1024*695px</span>
								</div>
								<div class="up-list-div">

                                    <ul>
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
                                            $html .= '<img class="fl" src="' . $imginfo_arr[0] . '" width="100" height="100">';
                                            $html .= '<p class="p1">';
                                            $html .= '<input type="text" class="img-name" name="imagestitle[' . $img_index . ']" value="' . $imginfo_arr[1] . '" style="width:90px">';
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
                </div>
                <div id="content_seo" class="product-add-div content-hide">
                	<ul class="info-item-block">
                		<li>
                			<span class="item-hd">显示模版：</span>
                			<div class="item-bd">
                				<div class="temp-chg" id="templet_list">
                                    <a {if $info['templet']=='line_show.htm'}class="on"{/if}  href="javascript:void(0)"  data-value="line_show.htm" onclick="setTemplet(this)">标准</a>
                                    {loop $templetlist $r}
                                    <a {if $info['templet']==$r['path']}class="on"{/if}  href="javascript:void(0)" data-value="{$r['path']}" onclick="setTemplet(this)">{$r['templetname']}</a>
                                    {/loop}
                                    <input type="hidden" name="templet" id="templet" value="{$info['templet']}"/>
                                </div>
                			</div>
                		</li>
                		<li>
                			<span class="item-hd">标题颜色：</span>
                			<div class="item-bd"><input type="text" name="color" value="{$info['color']}" class="input-text w100"/></div>
                		</li>
                		<li>
                			<span class="item-hd">热度基数：</span>
                			<div class="item-bd">
                				<span class="item-text fl">推荐次数</span>
                                <input type="text" name="recommendnum" value="{$info['recommendnum']}" data-regrex="number" data-msg="*必须为数字" class="input-text w60 ml-5 mr-20 fl"/>
                                <span class="item-text fl">满意度</span>
                                <input type="text" name="satisfyscore" value="{$info['satisfyscore']}" data-regrex="number" data-msg="*必须为数字" class="input-text w60 ml-5 mr-20 fl"/>
                                <span class="item-text fl">销量</span>
                                <input type="text" name="bookcount" value="{$info['bookcount']}" data-regrex="number" data-msg="*必须为数字" class="input-text w60 ml-5 mr-20 fl"/>
                			</div>
                		</li>
                		<li>
                			<span class="item-hd">图标设置：</span>
                			<div class="item-bd">
                				<a href="javascript:;" class="fl btn btn-primary radius size-S mt-3" onclick="Product.getIcon(this,'.icon-sel')" title="选择">选择</a>
                                <div class="save-value-div mt-2 ml-10 icon-sel w700">
                                    {loop $info['iconlist_arr'] $k $v}
                                    <span class="mb-5"><s onclick="$(this).parent('span').remove()"></s><img src="{$v['picurl']}"><input type="hidden" name="iconlist[]" value="{$v['id']}"></span>
                                    {/loop}
                                </div>
                			</div>
                		</li>
                	</ul>
                    <div class="line"></div>
                    <ul class="info-item-block">
                    	<li>
                    		<span class="item-hd">优化标题：</span>
                    		<div class="item-bd">
                    			<input type="text" name="seotitle" value="{$info['seotitle']}" class="input-text w700">
                    		</div>
                    	</li>
                    	<li>
                    		<span class="item-hd">Tag词：</span>
                    		<div class="item-bd">
                    			<input type="text" name="tagword" class="input-text w700" value="{$info['tagword']}">
                    		</div>
                    	</li>
                    	<li>
                    		<span class="item-hd">关键词：</span>
                    		<div class="item-bd">
                    			<input type="text" name="keyword" value="{$info['keyword']}" class="input-text w700">
                    		</div>
                    	</li>
                    	<li>
                    		<span class="item-hd">页面描述：</span>
                    		<div class="item-bd">
                    			<textarea class="textarea w700" name="description" cols="" rows="">{$info['description']}</textarea>
                    		</div>
                    	</li>
                    </ul>
                    
                </div>
                {php $contentArr=Common::getExtendContent(104,$extendinfo);}
                {php echo $contentArr['contentHtml'];}
                <div id="content_extend" class="product-add-div content-hide">
                    {php echo $contentArr['extendHtml'];}
                </div>


                </form>
                
                <div class="clear clearfix pt-20 pb-20">
                	<input type="hidden" name="webid" value="0"/>
                    <a class="btn btn-primary radius size-L ml-115" id="save_btn" href="javascript:;">保存</a>
                </div>
            </div>

    </td>
</tr>


<!--左侧导航区-->

<!--右侧内容区-->

<script>
 $(document).ready(function(e) {
     window.feeinclude=window.JSEDITOR('feeinclude');
     window.visacontent=window.JSEDITOR('visacontent');
     window.bookcontent=window.JSEDITOR('bookcontent');
     window.simple_jieshao=window.JSEDITOR('simple_jieshao');
     //颜色选择器
	  $(".title-color").colorpicker({
            ishex:true,
            success:function(o,color){
                $(o).val(color)
            },
            reset:function(o){
            }
        });


     $("#supplierlist_sel").change(function(){
          var supplierid=$(this).val();
          getShips(supplierid);

     });

     $("#shipid_sel").change(function(){
         var shipid = $(this).val();
         getSchedules(shipid);
     })



     $("#save_btn").click(function(e) {
             ST.Util.showMsg('保存中',6,10000);
             Ext.Ajax.request({
                 url   :  SITEURL+"ship/admin/shipline/ajax_linesave",
                 method  :  "POST",
                 isUpload :  true,
                 form  : "product_fm",
                 waitMsg  :  "保存中...",
                 datatype  :  "JSON",
                 success  :  function(response, opts)
                 {
                     var text = response.responseText;
                     if(window.isNaN(text))
                     {
                         ZENG.msgbox._hide();
                         ST.Util.showMsg('保存失败,请检查权限！',5);
                     }
                     else
                     {
                         // Ext.get('line_id').setValue(text);
                         $("#line_id").val(text);
                         ST.Util.showMsg('保存成功',4)
                     }
                 }});
     });

     switchBack();

 });
 
  function switchBacks(columnname){
  	if($('#column_'+columnname).length>0){
            if( $('#content_'+columnname+'_title').length>0){
                $('#content_'+columnname+'_title').html($('#column_'+columnname).text()+'：');
            }
        }
  }

function switchBack()
{
	
	

    var days=$("#travel_days").val();
    if(days>0)
    {
        var html="";
        var jieshao_num=$(".content-jieshao-detail").find('.add-class').length;
        jieshao_num=!jieshao_num?0:jieshao_num;
        var day_content='<div class="add-class">';
        						day_content+='<ul class="info-item-block">';
                                day_content+='<dl>';
                                    day_content+='<dt>第{day}天：</dt>';
                                    day_content+='<dd><input type="text" name="jieshaotitle[{day}]" class="set-text-xh text_700 mt-2"/></dd>';
                                day_content+='</dl>';
                                day_content+='<dl class="jieshao-diner">';
                                day_content+='<dt></dt>';
                                day_content+='<dd>';

                                day_content+='<span class="fl"><input class="mt-8 mr-3 fl" type="checkbox" name="endtimehas[{day}]" value="1"></span>';
                                day_content+='<label style="float:left;cursor:pointer;">抵港时间</label><span class="fl"><input class="set-text-xh text_177 ml-5 mr-10" type="text" name="endtime[{day}]" value=""/></span>';
                                day_content+='<span class="fl"><input class="mt-8 mr-3 fl" type="checkbox" name="starttimehas[{day}]" value="1"></span>';
                                day_content+='<label style="float:left;cursor:pointer;">启航时间</label><span class="fl"><input class="set-text-xh text_177 ml-5 mr-10" type="text" name="starttime[{day}]"/></span>';
                                day_content+='</dd>';
                                day_content+='</dl>';
                                day_content+='<dl class="jieshao-diner">';
                                    day_content+='<dt></dt>';
                                    day_content+='<dd style="width:850px">';
                                        day_content+='<span class="fl"><input class="mt-8 mr-3 fl" type="checkbox" name="breakfirsthas[{day}]" value="1"></span>';
                                        day_content+='<label style="float:left;cursor:pointer;">邮轮早餐</label><span class="fl"><input class="set-text-xh text_177 ml-5 mr-10" type="text" name="breakfirst[{day}]"/></span>';
                                        day_content+='<span class="fl"><input class="mt-8 mr-3 fl" type="checkbox" name="lunchhas[{day}]" value="1"></span>';
                                        day_content+='<label style="float:left;cursor:pointer;">邮轮午餐</label><span class="fl"><input class="set-text-xh text_177 ml-5 mr-10" type="text" name="lunch[{day}]" value=""/></span>';
                                        day_content+='<span class="fl"><input class="mt-8 mr-3 fl" type="checkbox" name="supperhas[{day}]" value="1"></span>';
                                        day_content+='<label style="float:left;cursor:pointer;">邮轮晚餐</label><span class="fl"><input class="set-text-xh text_177 ml-5 mr-10" type="text"name="supper[{day}]"/></span>';
                                    day_content+='</dd>';
                                day_content+='</dl>';
                                day_content+='<dl class="jieshao-diner">';
                                day_content+='<dt></dt>';
                                day_content+='<dd style="width:850px">';
                                day_content+='<span class="fl"><input class="mt-8 mr-3 fl" type="checkbox" name="countryhas[{day}]" value="1"></span>';
                                day_content+='<label style="float:left;cursor:pointer;">国家城市</label><span class="fl"><input class="set-text-xh text_177 ml-5 mr-10" type="text" name="country[{day}]"/></span>';
                                day_content+='<span class="fl"><input class="mt-8 mr-3 fl" type="checkbox" name="livinghas[{day}]" value="1"></span>';
                                day_content+='<label style="float:left;cursor:pointer;">入住</label><span class="fl"><input class="set-text-xh text_177 ml-5 mr-10" type="text" name="living[{day}]" value=""/></span>';
                                day_content+='</dd>';
                                day_content+='</dl>';
                                day_content+='<div class="xc-con">';
                                    day_content+='<h4>行程内容：</h4>';
                                    day_content+='<div><textarea name="txtjieshao[{day}]" style=" float:left" id="line_content_{day}"></textarea></div>';
                                day_content+='</div>';
                                day_content+='</ul>';
                            day_content+='</div>';

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
            var index=parseInt(days-1);
           $(".content-jieshao-detail").find('.add-class:gt('+index+')').remove();
        }
        for(var i=1;i<=days;i++)
        {
            window['line_content_'+i]=window.JSEDITOR('line_content_'+i);
        }
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
function togStyle(dom,num)
{
    $("#line_isstyle").val(num);
    $(dom).addClass('on');
    $(dom).siblings().removeClass('on');

    if(num==1)
    {
      $(".content-jieshao-detail").hide();
      $(".content-jieshao-simple").show();
    }
    else
    {
        $(".content-jieshao-detail").show();
        $(".content-jieshao-simple").hide();
    }
}
function nextStep()
{
    $(".w-set-tit span.on").next().trigger('click');
}
//删除附件
function delDoc()
{
    var lineid = '{$info['id']}';
    $.ajax({
        type:'POST',
        url:SITEURL+'/ship/admin/shipline/ajax_del_doc',
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

function getShips($supplierid)
{
    $.ajax(
        {
            type: "post",
            data: {supplierid:$supplierid},
            url: SITEURL+"/ship/admin/shipline/ajax_get_shiplist",
            dataType:'json',
            success: function(data,textStatus)
            {

                if(data.status)
                {
                    var html='<option value="">请选择游轮</option>';
                    for(var i in data.list)
                    {
                        var row=data.list[i];
                        html+='<option value="'+row['id']+'">'+row['title']+'</option>';
                    }
                    $("#shipid_sel").html(html);
                }
            },
            error: function()
            {
                ST.Util.showMsg("请求出错",5,1000);
            }

        });
}
function getSchedules(shipid)
{
    $.ajax(
        {
            type: "post",
            data: {shipid:shipid},
            url: SITEURL+"/ship/admin/shipline/ajax_get_schedulelist",
            dataType:'json',
            success: function(data,textStatus)
            {

                if(data.status)
                {
                    var html='<option value="">请选择行程</option>';
                    for(var i in data.list)
                    {
                        var row=data.list[i];
                        html+='<option value="'+row['id']+'">'+row['title']+'</option>';
                    }
                    $("#shipdate_sel").html(html);
                }
            },
            error: function()
            {
                ST.Util.showMsg("请求出错",5,1000);
            }
        });
}


//设置模板
function setTemplet(obj)
{
    var templet = $(obj).attr('data-value');
    $(obj).addClass('on').siblings().removeClass('on');
    $("#templet").val(templet);

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
                Imageup.genePic(temp[0],".up-list-div ul",".cover-div");
            }
        }
    });
    setTimeout(function(){
        $('#attach_btn').uploadify({
            'swf': PUBLICURL + 'js/uploadify/uploadify.swf',
            'uploader': SITEURL + 'uploader/uploaddoc',
            'buttonImage' : PUBLICURL+'images/uploadfile.png',  //指定背景图
            'formData':{uploadcookie:"<?php echo Cookie::get('username')?>"},
            'fileTypeExts':'*.doc;*.docx;*.pdf',
            'auto': true,   //是否自动上传
            'removeTimeout':0.2,
            'height': 25,
            'width': 80,
            'onUploadSuccess': function (file, data, response) {
                var info=$.parseJSON(data);
                if(info.status){
                    var html='<li><span class="name">'+info.name+'</span><input type="hidden" name="linedoc[name][]" value="'+info.name+'"><input class="path" type="hidden" name="linedoc[path][]" value="'+info.path+'"><span class="del">删除</span></li>';
                    $("#linedoc-content").append(html);
                }
            }
        });
    },10)

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
        $.post(SITEURL+'line/ajax_del_doc/',{'file':parent.find('.path').val(),'id':id},function(rs){
            if(rs.status){
                parent.remove();
            }
        },'json');
    });


</script>
</body>
</html>
