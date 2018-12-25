<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>线路产品管理-{$webname}</title>
{Common::css('base.css,style.css,extend.css')}
{Common::js('jquery.min.js')}
<script>
	$(function(){
		
		//给列表容器赋予一个动态高度
		function sizeHeight(){
			var pmHeight = $(window).height();
            var contentHeight=pmHeight-70;
            $(".side-menu,.panel").height(contentHeight);
            $(".side-menu,.panel iframe").height(contentHeight);
		}
		
		//高度改变
		$(window).resize(function(){
			sizeHeight()
		})
		sizeHeight()
	})
</script>
</head>

<body>

 <div class="page-box">
    <table class="main-tb" cellpadding="0" cellspacing="0">
        <tr class="top-tr"><td colspan="2">
                {$header}
                <script>
                    $(function(){
                        $("#p_line").addClass('cur').siblings().removeClass('cur');
                    })
                </script>
            </td>
        </tr>

        <tr>
            <td class="side-td">
                <div class="side-menu">

                    <dl class="order">
                        <dt><a href="javascript:;">线路管理</a></dt>
                        <dd>
                            <a href="{$cmsurl}index/list" id="nav_line_list" class="on" target="frm">线路列表</a>
                            <a href="{$cmsurl}order/all" id="nav_line_order" target="frm">线路订单</a>
                        </dd>
                    </dl>
                    <div class="shrink-btn"></div>
                </div><!-- 侧边导航 -->
             </td>
            <td>
              <div class="panel">
                    <iframe src="{$cmsurl}index/list" name="frm">
                    </iframe>
              </div>
          </td>
        </tr>
    </table>

</div>
<script>
    $(".order dd a").click(function(){
        $(this).addClass('on').siblings().removeClass('on');
    })
</script>
</body>
</html>
