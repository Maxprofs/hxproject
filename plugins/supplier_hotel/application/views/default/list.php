<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>酒店列表-{$webname}</title>
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
                  <a class="pm-ta-lb cur" href="{$cmsurl}index">列表</a>
                  <a class="pm-ta-bj" href="{$cmsurl}index/suit_list">报价</a>
                </div>
              </div>
              
              <div class="pm-tabcon-list">
              	<table class="pm-table-hd" width="100%" border="0">
                  <tr class="pl-th">
                    <th width="5%" height="38" scope="col">选择</th>
                    <th width="15%" scope="col">编号</th>
                    <th width="25%" scope="col">酒店名称</th>
                    <th width="15%" scope="col">报价有效期</th>
                    <th width="15%" scope="col">星级</th>
                    <th width="15%" scope="col">审核状态</th>
                    <th width="10%" scope="col">管理</th>
                  </tr>
                </table>
              </div>
              
              <div class="pm-tabcon-list" id="productList">
                  {if !empty($list)}
                    <table class="pm-table-list" width="100%" border="0">
                      {loop $list $row}
                      <tr class="pl-tr">
                        <td width="5%" height="34" align="center"><div class="pm-table-boxs">
                                <input type='checkbox' class="product_check checkbox-lb" style='cursor:pointer' id="box_{$row['id']}" value="{$row['id']}"/>
                                </div></td>
                        <td width="15%" align="center"><div class="pm-table-boxs">{$row['series']}</div></td>
                        <td width="25%"><div class="pm-table-boxs"><a class="pm-table-bt" href="{$row['url']}" target="_blank">{$row['title']}</a></div></td>
                        <td width="15%" align="center">
                            <div class="pm-table-boxs">
                                {if !empty($row['expired_date'])}
                                 <span class="color-grey">{$row['expired_date']}</span>
                                {else}
                                 <span class="color-red">无套餐</span>
                                {/if}
                            </div></td>
                        <td width="15%" align="center">{$row['rank']}</td>
                        <td width="15%" align="center"><div class="pm-table-boxs">
                                {if $row['ishidden']==0}
                                 <span class="color-green">已通过</span>
                                {else}
                                 <span class="color-red">未通过</span>
                                {/if}
                            </div></td>
                        <td width="10%" align="center">
                          <div class="pm-table-boxs">
                            <a href="{$cmsurl}index/edit?id={$row['id']}" class="pm-delete-btn" title="编辑"></a>
                            <!--<a href="javascript:void(0)" class="pm-delete-btn" title="删除"></a>-->
                          </div>
                        </td>
                      </tr>
                      {/loop}
                    </table>
                  {else}
                    <p style="text-align: center;height: 40px;line-height: 40px">还没有发布相关产品!</p>
                  {/if}
              </div>
              
              <div class="pm-btm-box">
              	<a class="pm-gn-btn choose_all" href="javascript:;">全选</a>
              	<a class="pm-gn-btn ml-10 choose_diff" href="javascript:;">反选</a>
              	<a class="pm-gn-btn btm-delete-btn ml-10 offline" href="javascript:;">下线</a>
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

</body>
<script>
    $(function(){
        $("#nav_hotel_list").addClass('on');

        //全选
        $(".choose_all").click(function(){
            CHOOSE.chooseAll();
        })
        //反选
        $(".choose_diff").click(function(){
            CHOOSE.chooseDiff();
        })
        //下线产品
        $(".offline").click(function(){
            var length=$('.product_check:checked').length;
            if(length==0)
            {
                ST.Util.showMsg('请先选择项',5);
                return;
            }
            else
            {
                ST.Util.confirmBox('下架产品','下架产品后需要在管理员再次审核才能在前台展示,确定下架产品',function(){
                    var ids = '';
                    $('.product_check:checked').each(function(i,obj){

                        ids+= $(obj).val()+',';
                    })
                    ids = ids.slice(0,-1);
                    $.getJSON(SITEURL+'index/ajax_offline',{ids:ids},function(data){
                        if(data.status==1){
                            ST.Util.showMsg('下线产品成功',4);
                            location.reload();
                        }else{
                            ST.Util.showMsg('下线产品失败',5);
                        }
                    })
                },function(){
                    ST.Util.closeBox();
                })

            }


        })
        //搜索产品
        $(".pm-search-btn").click(function(){
            var keyword = $('.keyword').val();
            if(keyword != ''){
                var url = SITEURL+'index/list?keyword='+keyword;
                location.href = url;
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



    })
</script>
</html>
