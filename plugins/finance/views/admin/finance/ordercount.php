<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>笛卡CMS{$coreVersion}</title>
    {template 'stourtravel/public/public_js'}
    {php echo Common::getCss('style.css,base.css,base2.css,plist.css,base_new.css'); }
    {php echo Common::getScript("uploadify/jquery.uploadify.min.js"); }
    {php echo Common::getCss('uploadify.css','js/uploadify/'); }
	{php echo Common::get_skin_css();}

    <link type="text/css" href="{$GLOBALS['cfg_plugin_finance_public_url']}css/base.css" rel="stylesheet" />
    <link type="text/css" href="{$GLOBALS['cfg_plugin_finance_public_url']}css/style.css" rel="stylesheet" />
    <link type="text/css" href="{$GLOBALS['cfg_plugin_finance_public_url']}css/finance_ordercount.css" rel="stylesheet" />

    <style type="text/css">
        .finance-block{
            width: 100%;
            overflow: auto;
        }
        .finance-block span{
            width: 180px;
            height: 19px;
            display: block;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            margin: 0 auto;
        }
    </style>


</head>
<body>
<table class="content-tab">
    <tr>
        <td width="119px" class="content-lt-td" valign="top">
            {template 'stourtravel/public/leftnav'}
            <!--右侧内容区-->
        </td>
        <td valign="top" class="content-rt-td">
			<div class="cfg-header-bar">
				<a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
                <a class="fr mr-10 lh-30 mt-6 keywords-description" href="http://www.deccatech.cn/help/518.html" target="_blank">关键字段说明</a>
			</div>
           

            <div class="content-nrt">

            <div class="finance-content">
            	<ul class="info-item-block">
            		<li>
            			<span class="item-hd">查询类别：</span>
            			<div class="item-bd">
            				<span class="select-box w200">
            					<select id="category" name="category" class="select">
	                                <option value="0">请选择</option>
	                                <option value="1">产品名称</option>
	                                <option value="2">供应商</option>
	                                <option value="3">分销商</option>
	                           </select>  
            				</span>
            				<a href="javascript:;" id="choose-btn" style="display: none" class="btn btn-primary radius size-S mt-3">选择</a>
            				<div class="census-item" style="padding: 0;display: inline-block;"><span class="cp-title"><i class="close-btn"></i></span></div>
            			</div>
            		</li>
            		<li>
            			<span class="item-hd">下单时间：</span>
            			<div class="item-bd">
            				<div class="census-item" style="padding: 0;">
	            				<span class="date-box">
		                            <input type="text" class="date-start" id="starttime">
		                            <i class="date-ico"></i>
		                        </span>
		                            <span>&nbsp;&nbsp;至&nbsp;&nbsp;</span>
		                        <span class="date-box">
		                            <input type="text" class="date-end" id="endtime">
		                            <i class="date-ico"></i>
		                        </span>
	                        </div>
            			</div>
            		</li>
            		<li>
            			<span class="item-hd">结算状态：</span>
            			<div class="item-bd">
            				<span class="select-box w200">
            					<select name="" class="select" id="settle_status">
	                                <option value="-1">全部</option>
	                                <option value="0">未结算</option>
	                                <option value="1">已结算</option>
	                            </select>
            				</span>	
            			</div>
            		</li>
            		<li>
            			<span class="item-hd">订单状态：</span>
            			<div class="item-bd">
            				<span class="select-box w200">
            					<select name="" class="select" id="order_status">
	                                <option value="-1">全部</option>
	                                <option value="0">处理中</option>
	                                <option value="1">等待付款</option>
	                                <option value="2">已付款</option>
	                                <option value="3">已取消</option>
	                                <option value="4">退款成功</option>
	                                <option value="5">交易完成</option>
	                            </select>
            				</span>	
            			</div>
            		</li>
            		<li>
            			<span class="item-hd">统计字段：</span>
            			<div class="item-bd" id="count_fields">
            				{loop $count_fields $k $v}
                            <label class="check-label w150"><input type="checkbox" {if $v['checked']}checked="checked"{/if} name="{$k}">{$v['title']}</label>
                            {if $n%8==0}
                            <br/>
                            {/if}
                            {/loop}
            			</div>
            		</li>
            		<li>
            			<span class="item-hd">&nbsp;</span>
            			<div class="item-bd">
            				<a href="javascript:;" class="fl btn btn-primary radius size-S mt-3 mr-20" id="create-table">生成报表</a>
                            <a href="javascript:;" class="fl btn btn-primary radius size-S mt-3 mr-20" id="export_excel">导出报表</a>
            			</div>
            		</li>
            		
            	</ul>
            <div class="census-item">
                <ul>
                    <li class="clearfix no-float" id="count-msg-container">
                        <div class="item-nr">
                            <ul>
                                <li>订单数量：<span id="total">1</span></li>
                                <li class="count-item">订单总额：<span id="totalprice"></span></li>
                                <li class="count-item">支付总额：<span id="payprice"></span></li>
                                <li class="count-item">积分抵现：<span id="jifentprice"></span></li>
                                <li class="count-item">产品成本：<span id="basicprice"></span></li>
                                <li class="count-item">平台返佣：<span id="commission"></span></li>
                                <li class="count-item count-item-last">结算金额：<span id="settle_amount"></span></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
            <!-- 订单筛选 -->
            <div class="finance-block">
                <div class="explain-txt"><!--<a href="#" target="_blank">关键字段说明</a>--></div>
                <table width="100%" border="0" class="finance-table-list">
                    <tbody id="order_list">
                    <tr id="order_list_header">
                        {loop $count_fields $k $v}
                        <th class="text-c" data-name="{$k}">{$v['title']}</th>
                        {/loop}
                    </tr>


                    </tbody>
                </table>
            </div>
            <!-- 订单列表 -->
            <div class="btn-block">

                <!--<a class="btn-link" href="javascript:;" id="count_info">统计信息</a>-->
                <div class="pm-btm-msg pm-btm-msg-order-list">
                    <!--订单分页-->

                    <div class="show-num ml-20" id="order_list_page">
                        		每页显示数量：
                        <select name="order-pagesize" id="order_pagesize">
                            <option value="15">15</option>
                            <option value="30">30</option>
                            <option value="40">40</option>
                            <option value="50">50</option>
                            <option value="60">60</option>
                        </select>
                    </div>
                </div>
            </div>
            </div>

            <div id="choose-product" class="popup-layer" style="display: none">
                <div class="finance-popup-content">
                    <div class="popup-tit"><strong>选择产品</strong><i id="close-pdt-btn" class="close-btn"></i></div>
                    <div class="finance-popup-block">
                        <div class="search-term clearfix">
                            <select class="search-select module-select" name="">

                                {loop $modules $m}
                                <option value="{$m['id']}">{$m['modulename']}</option>
                                {/loop}


                            </select>
                            <div class="search-box">
                                <input type="text" class="search-text search-text-product" placeholder="产品名称/产品编号">
                                <input type="button" class="search-btn search-btn-product">
                            </div>
                            <div class="txt">输入产品名称或编号进行搜索，搜索刷新下面的结果列表。若没有列表显示为空</div>
                        </div>
                        <div class="search-list">
                            <form name="">
                                <table class="table-list" width="100%" border="0">
                                    <tbody>
                                    <tr id="product_header">
                                        <th width="15%">编号</th>
                                        <th width="75%"><div class="pd-name">产品名称</div></th>
                                        <th width="10%">选择</th>
                                    </tr>


                                    </tbody>
                                </table>
                                <script type="text/html" id="tpl_product_list">

                                    {{each list as value i}}
                                    <tr>
                                        <td>{{value.series}}</td>
                                        <td><div class="pd-name">{{value.title}}</div></td>
                                        <td><label class="radio-btn">
                                            <input type="radio" name="products" {{if i==0}}checked="checked"{{/if}} data-id={{value.id}}>
                                        </label>
                                        </td>
                                    </tr>
                                    {{/each}}

                                </script>
                            </form>
                        </div>
                        <div class="pm-btm-box">
                            <div class="pm-btm-msg pm-btm-msg-product">

                            </div>
                        </div>
                        <div class="sure-item"><a class="sure-btn" href="javascript:;">确定</a></div>
                    </div>
                </div>
            </div>

            <!--供应商-->
            <div id="choose-supplier" class="popup-layer" style="display: none">
                <div class="finance-popup-content">
                    <div class="popup-tit"><strong>选择供应商</strong><i id="close-pdt-btn" class="close-btn"></i></div>
                    <div class="finance-popup-block">
                        <div class="search-term clearfix">
                            <div class="search-box">
                                <input type="text" class="search-text search-text-supplier" placeholder="供应商名称/手机号码">
                                <input type="button" class="search-btn search-btn-supplier">
                            </div>
                            <div class="txt">输入供应商名称或手机号码进行搜索，搜索刷新下面的结果列表。若没有列表显示为空</div>
                        </div>
                        <div class="search-list">
                            <form name="">
                                <table class="table-list" width="100%" border="0">
                                    <tbody>
                                    <tr id="supplier_header">
                                        <th width="20%">供应商名称</th>
                                        <th width="35%"><div class="pd-name">联系人</div></th>
                                        <th width="35%"><div class="pd-name">手机号</div></th>
                                        <th width="10%">选择</th>
                                    </tr>


                                    </tbody>
                                </table>
                                <script type="text/html" id="tpl_supplier_list">

                                    {{each list as value i}}
                                    <tr>
                                        <td>{{value.suppliername}}</td>
                                        <td><div class="pd-name">{{value.linkman}}</div></td>
                                        <td><div class="pd-name">{{value.mobile}}</div></td>
                                        <td><label class="radio-btn"><input type="radio" {{if i==0}}checked="checked"{{/if}} name="suppliers" data-id={{value.id}}></label></td>
                                    </tr>
                                    {{/each}}

                                </script>
                            </form>
                        </div>
                        <div class="pm-btm-box">
                            <div class="pm-btm-msg pm-btm-msg-supplier">

                            </div>
                        </div>
                        <div class="sure-item"><a class="sure-btn" href="javascript:;">确定</a></div>
                    </div>
                </div>
            </div>


            <!--分销商-->
            <div id="choose-fenxiao" class="popup-layer" style="display: none">
                <div class="finance-popup-content">
                    <div class="popup-tit"><strong>选择分销商</strong><i id="close-pdt-btn" class="close-btn"></i></div>
                    <div class="finance-popup-block">
                        <div class="search-term clearfix">
                            <div class="search-box">
                                <input type="text" class="search-text search-text-fenxiao" placeholder="分销商账号">
                                <input type="button" class="search-btn search-btn-fenxiao">
                            </div>
                            <div class="txt">输入分销商账号进行搜索，搜索刷新下面的结果列表。若没有列表显示为空</div>
                        </div>
                        <div class="search-list">
                            <form name="">
                                <table class="table-list" width="100%" border="0">
                                    <tbody>
                                    <tr id="fenxiao_header">
                                        <th width="15%">账号</th>
                                        <th width="75%"><div class="pd-name">分销商等级</div></th>
                                        <th width="10%">选择</th>
                                    </tr>


                                    </tbody>
                                </table>
                                <script type="text/html" id="tpl_fenxiao_list">

                                    {{each list as value i}}
                                    <tr>
                                        <td class="pd-name">{{value.nickname}}</td>
                                        <td><div>{{value.rank}}</div></td>
                                        <td><label class="radio-btn"><input type="radio" {{if i==0}}checked="checked"{{/if}} name="fenxiaos" data-id={{value.id}}></label></td>
                                    </tr>
                                    {{/each}}

                                </script>
                            </form>
                        </div>
                        <div class="pm-btm-box">
                            <div class="pm-btm-msg pm-btm-msg-fenxiao">

                            </div>
                        </div>
                        <div class="sure-item"><a class="sure-btn" href="javascript:;">确定</a></div>
                    </div>
                </div>
            </div>

            <!-- 统计信息 -->
            <div id="cli_dialog_div"></div>

            </div>

        </td>
    </tr>
</table>


<script>
    window.count_fields='{json_encode($count_fields)}';
</script>
<script type="text/javascript" src="{$GLOBALS['cfg_plugin_finance_public_url']}js/common.js"></script>
<script type="text/javascript" src="{$GLOBALS['cfg_plugin_finance_public_url']}js/finance_ordercount.js"></script>
<script type="text/javascript" src="/res/js/template.js"></script>

<script type="text/javascript" src="/res/js/datepicker/WdatePicker.js"></script>

</body>
</html>
