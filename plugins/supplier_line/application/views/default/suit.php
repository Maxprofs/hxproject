<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>供应商管理</title>

    {Common::css('base.css,style.css,extend.css,admin_base.css')}
    {Common::js('jquery.min.js,common.js')}
    {include "pub"}
</head>

<body>
    	<div class="content-box">
        
        <div class="frame-box">
          
          <div class="pt-manage-box">
          
            <div class="pt-rows"></div>
            
            <div class="pm-tab-box">
            
              <div class="pm-search-box">
                  <div class="pm-search-con"><form method="get"><input type="text" class="pm-search-text" name="keyword" value="{$keyword}"/><a href="javascript:void(0)" id="search_btn" class="pm-search-btn">搜索</a></form></div>
                <div class="pm-tabnav">
                  <a class="pm-ta-lb togmod"  href="{$cmsurl}index/list" data-id="1">列表</a>
                  <a class="pm-ta-bj togmod cur" href="{$cmsurl}index/suit" data-id="2">报价</a>
                </div>
              </div>

                <div class="pm-tabcon-list">
                    <table class="pm-table-hd" width="100%" border="0">
                        <tr class="pl-th">
                            <th width="8%" scope="col" height="38">编号</th>
                            <th width="40%" scope="col">路线名称</th>
                            <th width="10%" scope="col">报价有效期</th>
                            <th width="14%" scope="col">最低价格</th>
                            <th width="14%" scope="col">最低利润</th>
                            <th width="10%" scope="col">管理</th>
                        </tr>
                    </table>
                </div>

                <div class="pm-tabcon-list" id="productList">
                    <table class="pm-table-list" width="100%" border="0">
                        {loop $list $row}
                        {if strpos($row['id'],'suit')===false}
                        <tr class="pl-tr" id="product_{$row['id']}">
                            <td width="8%" align="center"><div class="pm-table-boxs">{$row['lineseries']}</div></td>
                            <td width="30%"><div class="pm-table-boxs"><a class="pm-table-bt" target="_blank" href="{$row['url']}">{$row['title']}</a></div></td>
                            <td width="10%" align="center"><div class="pm-table-boxs"><span class="color-grey">{$row['suitday']}</span></div></td>

                            <td width="8%" align="center"><div class="pm-table-boxs">&nbsp;</div></td>
                            <td width="8%" align="center"><div class="pm-table-boxs">&nbsp;</div></td>
                            <td width="8%" align="center">
                                <div class="pm-table-boxs">
                                    <a href="javascript:void(0)" class="pm-add-tc-btn" onclick="addSuit('{$row['id']}')" title="添加套餐">添加套餐</a>
                                </div>
                            </td>
                        </tr>
                        {else}
                        <tr class="pl-tr pl-child-tr sub_{$row['lineid']}" id="product_{$row['id']}">
                            <td width="8%" align="center"><div class="pm-table-boxs">&nbsp;</div></td>
                            <td width="40%"><div class="pm-table-boxs"><a class="pm-table-bt" href="#">{$row['title']}</a></div></td>
                            <td width="10%" align="center"><div class="pm-table-boxs"><span class="color-grey">{$row['suitday']}</span></div></td>
                            <td width="14%" align="center"><div class="pm-table-boxs"><span class="color-grey">{$row['minprice']}</span></div></td>
                            <td width="14%" align="center"><div class="pm-table-boxs"><span class="color-grey">{$row['minprofit']}</span></div></td>
                            <td width="10%" align="center">
                                <div class="pm-table-boxs">
                                    <a href="javascript:void(0)" class="pm-delete-btn" onclick="goEdit('{$row['id']}')" title="编辑"></a>
                                    <a href="javascript:void(0)" class="pm-edit-btn" onclick="delSuit('{$row['id']}')" title="删除"></a>
                                </div>
                            </td>
                        </tr>
                        {/if}
                       {/loop}
                    </table>
                </div>
                <div class="pm-btm-box">
                    <div class="pm-btm-msg">
                        {$pagestr}
                        <div class="show-num ml-20">
                            <form action="" method="get" id="pagesize_fm">
                            每页显示数量：
                            <select name="pagesize" >
                                <option value="30" {if $pagesize==30} selected="selected"  {/if}>30</option>
                                <option value="40" {if $pagesize==40} selected="selected"  {/if}>40</option>
                                <option value="50" {if $pagesize==50} selected="selected"  {/if}>50</option>
                                <option value="60" {if $pagesize==60} selected="selected"  {/if}>60</option>
                            </select>
                           </form>
                        </div>
                    </div>
                </div>
            </div>
            
          </div><!-- 产品列表 -->
            
        </div>
        
        {include "footer"}
        
      </div>
    <!-- 主体内容 -->
<script>

    window.mode=1;

    $(function(){


        $("#pagesize_fm select").change(function(){
            $("#pagesize_fm").submit();
        });

        //给列表容器赋予一个动态高度
        function sizeHeight(){
            var pmHeight = $(window).height();
            var gdHeight = 250;
            $('#productList').height(pmHeight-gdHeight);
        }

        //高度改变
        $(window).resize(function(){
            sizeHeight()
        })
        sizeHeight()


        $("#search_btn").click(function(){
            $(this).parents("form:first").submit();
        })


    })
    //其他操作
     function goEdit(id)
     {
         var suitid=id.replace('suit_','');
         ST.openUrl(SITEURL+"index/suit_edit/suitid/"+suitid);
     }
     function addSuit(id)
     {
         var verifystatus = "{$userinfo['verifystatus']}";
         if(verifystatus != '3'){
             ST.Util.showMsg('未通过资质审核,暂时不能进行此操作',5);
             return false;
         }else{
             ST.openUrl(SITEURL+"index/suit_add/lineid/"+id);
         }


     }
     function updateField(ele,field,id)
     {

         var val=$(ele).val();
         var suitid=id.replace('suit_','');
         var params={'field':field,'val':val,'suitid':suitid}
         var url=SITEURL+'index/ajax_update_suit'
         $.ajax({
             type: "POST",
             url: url,
             data: params,
             dataType: "json",
             success: function(data){

             }
         });

     }
     function delSuit(id)
     {
         var suitid=id.replace('suit_','');
         var params={'suitid':suitid}
         var url=SITEURL+'index/ajax_del_suit'
         $.ajax({
             type: "POST",
             url: url,
             data: params,
             dataType: "json",
             success: function(data){
                 if(data.status)
                 {
                     $("#product_"+id).remove();
                 }
             }
         });
     }





</script>

</body>
</html>
