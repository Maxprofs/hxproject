<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>套餐列表管理</title>
    {Common::css("style.css,base.css")}
    {Common::js("jquery.min.js,common.js,choose.js")}
    {include "pub/public_js"}
<script>
	$(function(){
		
		//给列表容器赋予一个动态高度
		function sizeHeight(){
			var pmHeight = $(window).height();
			var gdHeight = 320;
			$('#productList').height(pmHeight-gdHeight);
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

    {request "pub/header"}

    {request "pub/sidemenu"}
    
    <div class="main">
    	<div class="content-box">
        
        <div class="frame-box">
          
          <div class="pt-manage-box">
          
            <div class="pt-rows"><a class="pt-manage-add-btn fr add-product" href="javascript:;">添加</a></div>
            
            <div class="pm-tab-box">
            
              <div class="pm-search-box">
                <div class="pm-search-con"><input type="text" class="pm-search-text keyword" value="{$keyword}" /><a href="javascript:void(0)" class="pm-search-btn">搜索</a></div>
                <div class="pm-tabnav">
                    <a class="pm-ta-lb" href="{$cmsurl}index">列表</a>
                    <a class="pm-ta-bj cur" href="{$cmsurl}index/suit_list">报价</a>
                </div>
              </div>
              
              <div class="pm-tabcon-list">
              	<table class="pm-table-hd" width="100%" border="0">
                  <tr class="pl-th">
                    <th width="6%" height="38" scope="col">选择</th>
                    <th width="16%" scope="col">编号</th>
                    <th width="30%" scope="col">景点/门票名称</th>
                    <th width="8%" scope="col">门票类型</th>
                      <th width="8%" scope="col">价格</th>
                    <th width="8%" scope="col">提前天数</th>
                      <th width="8%" scope="col">支付方式</th>

                    <th width="8%" scope="col">管理</th>
                  </tr>
                </table>
              </div>
              
              <div class="pm-tabcon-list" id="productList">

                <table class="pm-table-list" width="100%" border="0">
                 {loop $list $row}
                  <tr class="pl-tr">
                    <td width="6%" height="34" align="center"><div class="pm-table-boxs"><input type="checkbox" class="checkbox-lb product_check" value="{$row['id']}" /></div></td>
                    <td width="16%" align="center"><div class="pm-table-boxs">{$row['series']}</div></td>
                    <td width="30%"><div class="pm-table-boxs"><a class="pm-table-bt" href="{$row['url']}" target="_blank">{$row['title']}</a></div></td>
                    <td width="8%" align="center"><div class="pm-table-boxs">&nbsp;</div></td>
                    <td width="8%" align="center"><div class="pm-table-boxs">&nbsp;</div></td>
                    <td width="8%" align="center"><div class="pm-table-boxs">&nbsp;</div></td>
                    <td width="8%" align="center">
                      <div class="pm-table-boxs">
                        <a href="javascript:;" data-id="{$row['id']}" class="pm-add-tc-btn add-suit" title="添加套餐">添加套餐</a>
                      </div>
                    </td>
                  </tr>
                   {loop $row['suit'] $suit}
                     <tr class="pl-tr pl-child-tr">
                        <td width="6%" height="34" align="center"><div class="pm-table-boxs">&nbsp;</div></td>
                        <td width="16%" align="center"><div class="pm-table-boxs">&nbsp;</div></td>
                        <td width="30%"><div class="pm-table-boxs"><a class="pm-table-bt" href="javascript:;">{$suit['title']}</a></div></td>
                        <td width="8%" align="center"><div class="pm-table-boxs"><span class="color-grey">{$suit['suit_type']}</span></div></td>
                        <td width="8%" align="center"><div class="pm-table-boxs"><span class="color-grey">{$suit['min_price']}</span></div></td>
                        <td width="8%" align="center"><div class="pm-table-boxs"><span class="color-grey">{$suit['day_before_str']}</span></div></td>
                         <td width="8%" align="center"><div class="pm-table-boxs"><span class="color-grey">{$suit['paytype_name']}</span></div></td>
                        <td width="8%" align="center">
                          <div class="pm-table-boxs">
                            <a href="{$cmsurl}index/suit_edit?id={$suit['id']}" class="pm-delete-btn" title="编辑"></a>
                            <a href="javascript:void(0)" data-id="{$suit['id']}" class="pm-edit-btn" title="删除"></a>
                          </div>
                        </td>
                     </tr>
                   {/loop}

                 {/loop}

                </table>
              </div>
              
              <div class="pm-btm-box">
              	<a class="pm-gn-btn choose_all" href="javascript:;">全选</a>
              	<a class="pm-gn-btn ml-10 choose_diff" href="javascript:;">反选</a>
              	<!--<a class="pm-gn-btn btm-delete-btn ml-10" href="#">删除</a>-->
                <div class="pm-btm-msg">
                  {$pageinfo}
                </div>
              </div>
              
            </div>
            
            
          </div><!-- 产品列表 -->
            
        </div>

            {request "pub/footer"}
        
      </div>
    </div><!-- 主体内容 -->
  
  </div>
<script>
    $(function(){

        $("#nav_spot_list").addClass('on');
        //全选
        $(".choose_all").click(function(){
            CHOOSE.chooseAll();
        })
        //反选
        $(".choose_diff").click(function(){
            CHOOSE.chooseDiff();
        })
        //动态修改积分
        $('.pm-jf-text').keyup(function(){
                var v = Number($(this).val());
                var field = $(this).attr('data-field');
                var suitid = $(this).attr('data-id');
                if(v){
                    $.getJSON(SITEURL+'index/ajax_suit_jifen',{field:field,suitid:suitid,v:v},function(data){
                    })
                }
        })

        //搜索产品
        $(".pm-search-btn").click(function(){
            var keyword = $('.keyword').val();
            if(keyword != ''){
                var url = SITEURL+'index/list?templet=suit_list&keyword='+keyword;
                location.href = url;
            }
        })

        //删除
        $(".pm-edit-btn").click(function(){
            var suitid = $(this).attr('data-id');
            if(suitid){
                ST.Util.confirmBox('删除?','删除后无法恢复,确定删除?',function(){
                    $.getJSON(SITEURL+'index/ajax_suit_delete',{suitid:suitid},function(data){
                        if(data.status==1){
                            ST.Util.showMsg('删除成功',4);
                            location.reload();
                        }else{
                            ST.Util.showMsg('删除失败',5);
                        }
                    })
                },function(){
                    ST.Util.closeBox();
                })

            }
        })

        //添加产品
        $(".add-product").click(function(){
            var verifystatus = "{$userinfo['verifystatus']}";
            if(verifystatus != '3'){
                ST.Util.showMsg('未通过资质审核,暂时不能进行此操作',5);
                return false;
            }else{
                location.href = SITEURL+'index/add';
            }

        })
        //添加套餐
        $('.add-suit').click(function(){

            var id = $(this).attr('data-id');
            var verifystatus = "{$userinfo['verifystatus']}";
            if(verifystatus != '3'){
                ST.Util.showMsg('未通过资质审核,暂时不能进行此操作',5);
                return false;
            }else{
                location.href = SITEURL+'index/suit_add?productid='+id;

            }

        })

    })
</script>

</body>
</html>
