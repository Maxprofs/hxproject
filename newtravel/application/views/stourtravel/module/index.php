<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>模块管理--笛卡CMS{$coreVersion}</title>
    {template 'stourtravel/public/public_js'}
    {php echo Common::getCss('style.css,base.css,base_new.css,module.css'); }
    {php echo Common::getScript('ks-switch.pack.js,jquery.jqtransform.js,jqueryui/jquery-ui.min.js');}
    {php echo Common::getCss('jquery-ui.min.css','js/jqueryui/'); }
    {php echo Common::getScript("jquery.buttonbox.js,choose.js"); }

</head>

<body top_border=5QJIAj >

	<table class="content-tab">
        <tr>
            <td width="119px" class="content-lt-td"  valign="top">
                 {template 'stourtravel/public/leftnav'}
                 <!--右侧内容区-->
            </td>
            <td valign="top" class="content-rt-td">
                <div class="cfg-header-bar">
                    <span class="cfg-select-box btnbox mt-5 ml-10" id="custom_website" data-url="box/index/type/custom_website" data-result="result_webid">站点切换&nbsp;&gt;&nbsp;
                        <span id="result_webid">主站</span><i class="arrow-icon"></i>
                    </span>
                    <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
                    <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" id="moduleblocklist"><s></s>管理模块</a>
                </div>
                <form id="configfrm">
					<div class="module-container clearfix">
						<div class="module-wrapper-left">
							<div class="module-page">
								<h4 class="tit-bar">
									网站页面{Common::get_help_icon('module_index_webpage')}</h4>
								<ul class="page-list">
                                    {loop $page_module_list $page_module}
									<li class="item">
                                        <a class="m-menu" href="javascript:;" onclick="javascript:getModulePage(this,'{$page_module["id"]}');">{$page_module["name"]}</a>
										<div class="sub">

										</div>
									</li>
                                    {/loop}

								</ul>
							</div>
							<div class="module-add">
								<h4 class="tit-bar">
									已添加模块{Common::get_help_icon('module_index_added_module')}</h4>
								<ul id="moduleAddItem" class="add-list">

								</ul>
							</div>
						</div>
						<div class="module-change-icon">
						</div>
						<div class="module-wrapper-right">
							<div class="module-type">
								<h4 class="tit-bar">
									模块类型{Common::get_help_icon('module_index_xinxi_module_catolog')}</h4>
								<ul class="type-list">
                                    {loop $module_list $module}
									<li class="item" onclick="javascript:getModuleBlock(this,'{$module["id"]}');">{$module["name"]}</li>
                                    {/loop}

								</ul>
							</div>
							<div class="module-choose">
								<h4 class="tit-bar">
									功能模块{Common::get_help_icon('module_index_xinxi_module')}</h4>
								<ul id="moduleTypeItem" class="choose-list">

								</ul>
							</div>
						</div>
					</div>
				</form>
            </td>
        </tr>
    </table>

    <input type="hidden" id="webid" value="0">
    <input type="hidden" id="pagename" value="">
    <input type="hidden" id="pagename_title" value="">


    <script>

        $(document).ready(function () {

            function getHeight() {
                $(".module-container").height($(window).height() - 40);
            }
            getHeight();
            $(window).resize(function () {
                getHeight()
            });

            $("#moduleAddItem,#moduleTypeItem").sortable({
                connectWith: ".add-list",
                update: savePageBlock
            });
            $("#moduleAddItem .item,#moduleTypeItem .item").disableSelection();

            $(".btnbox").buttonBox();

            $("#moduleblocklist").click(function () {
                ST.Util.addTab('模块列表', 'module/list/menuid/{$menuid}')
            })

            initUI();
        });

        function custom_website(obj, webid, webname, resultid) {
            $("#" + resultid).html(webname);
            $(obj).addClass('cur').siblings().removeClass('cur');
            $('#webid').val(webid);

            initUI();
        }

        function initUI() {
            $(".page-list li a:contains('首页')").first().trigger('click');
        }

        function getModulePage(sender, pageModuleId) {
            $(sender).parent().addClass("active").siblings().removeClass("active");

            if ($.trim($(sender).siblings(".sub").html()) == "") {
                ST.Util.showMsg("正在加载页面数据...", 6, 1000000);
                $.ajax({
                    type: 'post',
                    url: SITEURL + "module/ajax_page_list",
                    data: {page_module_id: pageModuleId},
                    dataType: 'json',
                    success: function (rs) {
                        ST.Util.hideMsgBox();
                        if (rs.status === 1) {
                            var html = "";
                            for (var index = 0; index < rs.data.length; index++) {
                                html += "<a class=\"s-menu\" onclick=\"getSelectedModuleBlock(this,'" + rs.data[index].id + "','" + rs.data[index].title + "');\">" + rs.data[index].title + "</a>";
                            }
                            $(sender).siblings(".sub").html(html);

                            $(sender).siblings(".sub").find("a").first().trigger('click');
                        } else {
                            ST.Util.showMsg(rs.msg, 5, 3000);
                        }
                    }
                });

            }
            else {
                $(sender).siblings(".sub").find("a").first().trigger('click');
            }

        }

        function getSelectedModuleBlock(sender, pagename, pagenametitle) {
            $(sender).addClass("on").siblings().removeClass("on");
            $("#pagename").val(pagename);
            $("#pagename_title").val(pagenametitle);

            ST.Util.showMsg("正在加载页面所选模块数据...", 6, 1000000);
            $.ajax({
                type: 'post',
                url: SITEURL + "module/ajax_page_selected_block",
                data: {pagename: pagename, webid: $("#webid").val()},
                dataType: 'json',
                success: function (rs) {
                    ST.Util.hideMsgBox();
                    if (rs.status === 1) {
                        var html = "";
                        for (var index = 0; index < rs.data.length; index++) {
                            html += "<li class=\"item\" data-block-id=\"" + rs.data[index].aid + "\">" + rs.data[index].modulename;
                            html += "<i class=\"close-icon\" onclick=\"deleteSelectedModuleBlock(this);\"></i>";
                            html += "</li>";
                        }
                        $("#moduleAddItem").html(html);

                        if ($(".type-list li").find(".on").length <= 0) {
                            $(".type-list li").first().trigger('click');
                        }
                        else {
                            $(".type-list li").find(".on").first().trigger('click');
                        }

                    } else {
                        ST.Util.showMsg(rs.msg, 5, 3000);
                    }
                }
            });

        }

        function deleteSelectedModuleBlock(sender) {
            ST.Util.confirmBox('删除模块', "确定删除此模块吗?", function () {
                $(sender).parent().remove();
                savePageBlock(null, null, true);
            });

        }

        function getModuleBlock(sender, moduleId) {
            $(sender).addClass("on").siblings().removeClass("on");

            ST.Util.showMsg("正在加载模块列表数据...", 6, 1000000);
            $.ajax({
                type: 'post',
                url: SITEURL + "module/ajax_module_block",
                data: {typeid: moduleId, exclude_ids: getPageSelectedBlockIds()},
                dataType: 'json',
                success: function (rs) {
                    ST.Util.hideMsgBox();
                    if (rs.status === 1) {
                        var html = "";
                        for (var index = 0; index < rs.data.length; index++) {
                            html += "<li class=\"item\" data-block-id=\"" + rs.data[index].aid + "\">" + rs.data[index].modulename;
                            html += "<i class=\"close-icon hide\" onclick=\"deleteSelectedModuleBlock(this);\"></i>";
                            html += "</li>";
                        }
                        $("#moduleTypeItem").html(html);

                    } else {
                        ST.Util.showMsg(rs.msg, 5, 3000);
                    }
                }
            });

        }

        function getPageSelectedBlockIds() {
            var ids = new Array();
            $("#moduleAddItem li").each(function () {
                ids.push($(this).attr("data-block-id"));
            });
            return ids;
        }

        function savePageBlock(event, ui, reloadModuleBlock = false) {
            $("#moduleAddItem li").each(function () {
                $(this).find("i").removeClass("hide");
            });

            ST.Util.showMsg("正在保存页面模块配置数据...", 6, 1000000);
            $.ajax({
                type: 'post',
                url: SITEURL + "module/ajax_save_page_block",
                data: {
                    webid: $("#webid").val(),
                    pagename: $("#pagename").val(),
                    pagename_title: $("#pagename_title").val(),
                    blockids: getPageSelectedBlockIds()
                },
                dataType: 'json',
                success: function (rs) {
                    ST.Util.hideMsgBox();
                    if (rs.status === 1) {

                        if (reloadModuleBlock) {
                            if ($(".type-list li").filter(".on").length > 0) {
                                $(".type-list li").filter(".on").first().trigger('click');
                            }
                        }

                    } else {
                        ST.Util.showMsg(rs.msg, 5, 3000);
                    }
                }
            });

        }

    </script>

</body>
</html>
