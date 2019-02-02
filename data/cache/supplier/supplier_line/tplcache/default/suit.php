<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>供应商管理</title>
    <?php echo Common::css('base.css,style.css,extend.css,admin_base.css');?>
    <?php echo Common::js('jquery.min.js,common.js');?>
    <?php echo  Stourweb_View::template("pub");  ?>
</head>
<body>
    <div class="content-box">
        
        <div class="frame-box">
          
          <div class="pt-manage-box">
          
            <div class="pt-rows"></div>
            
            <div class="pm-tab-box">
            
              <div class="pm-search-box">
                  <div class="pm-search-con"><form method="get"><input type="text" class="pm-search-text" name="keyword" value="<?php echo $keyword;?>"/><a href="javascript:void(0)" id="search_btn" class="pm-search-btn">搜索</a></form></div>
                <div class="pm-tabnav">
                  <a class="pm-ta-lb togmod"  href="<?php echo $cmsurl;?>index/list" data-id="1">列表</a>
                  <a class="pm-ta-bj togmod cur" href="<?php echo $cmsurl;?>index/suit" data-id="2">报价</a>
                </div>
              </div>
                <div class="pm-tabcon-list">
                    <table class="pm-table-hd" width="100%" border="0">
                        <tr class="pl-th">
                            <th width="8%" scope="col" height="38">编号</th>
                            <th width="42%" scope="col">路线名称</th>
                            <th width="10%" scope="col">报价有效期</th>
                            <th width="10%" scope="col">销售价</th>
                            <th width="10%" scope="col">门市利润</th>
                            <th width="10%" scope="col">结算价</th>
                            <th width="10%" scope="col">管理</th>
                        </tr>
                    </table>
                </div>
                <div class="pm-tabcon-list" id="productList">
                    <table class="pm-table-list" width="100%" border="0">
                        <?php $n=1; if(is_array($list)) { foreach($list as $row) { ?>
                        <?php if(strpos($row['id'],'suit')===false) { ?>
                        <tr class="pl-tr" id="product_<?php echo $row['id'];?>">
                            <td width="8%" align="center"><div class="pm-table-boxs"><?php echo $row['lineseries'];?></div></td>
                            <td width="42%"><div class="pm-table-boxs"><a class="pm-table-bt" target="_blank" href="<?php echo $row['url'];?>"><?php echo $row['title'];?></a></div></td>
                            <td width="10%" align="center"><div class="pm-table-boxs"><span class="color-grey"><?php echo $row['suitday'];?></span></div></td>
                            <td width="10%" align="center"><div class="pm-table-boxs">&nbsp;</div></td>
                            <td width="10%" align="center"><div class="pm-table-boxs">&nbsp;</div></td>
                            <td width="10%" align="center"><div class="pm-table-boxs">&nbsp;</div></td>
                            <td width="10%" align="center">
                                <div class="pm-table-boxs">
                                    <a href="javascript:void(0)" class="pm-add-tc-btn" onclick="addSuit('<?php echo $row['id'];?>')" title="添加套餐">添加套餐</a>
                                </div>
                            </td>
                        </tr>
                        <?php } else { ?>
                        <tr class="pl-tr pl-child-tr sub_<?php echo $row['lineid'];?>" id="product_<?php echo $row['id'];?>">
                            <td width="8%" align="center"><div class="pm-table-boxs">&nbsp;</div></td>
                            <td width="42%"><div class="pm-table-boxs"><a class="pm-table-bt" href="#"><?php echo $row['title'];?></a></div></td>
                            <td width="10%" align="center"><div class="pm-table-boxs"><span class="color-grey"><?php echo $row['suitday'];?></span></div></td>
                            <td width="10%" align="center"><div class="pm-table-boxs"><span class="color-grey"><?php echo $row['minprice'];?></span></div></td>
                            <td width="10%" align="center"><div class="pm-table-boxs"><span class="color-grey"><?php echo $row['minprofit'];?></span></div></td>
                            <td width="10%" align="center"><div class="pm-table-boxs"><span class="color-grey"><?php echo $row['basicprice'];?></span></div></td>
                            <td width="10%" align="center">
                                <div class="pm-table-boxs">
                                    <a href="javascript:void(0)" class="pm-delete-btn" onclick="goEdit('<?php echo $row['id'];?>')" title="编辑"></a>
                                    <a href="javascript:void(0)" class="pm-edit-btn" onclick="delSuit('<?php echo $row['id'];?>')" title="删除"></a>
                                </div>
                            </td>
                        </tr>
                        <?php } ?>
                       <?php $n++;}unset($n); } ?>
                    </table>
                </div>
                <div class="pm-btm-box">
                    <div class="pm-btm-msg">
                        <?php echo $pagestr;?>
                        <div class="show-num ml-20">
                            <form action="" method="get" id="pagesize_fm">
                            每页显示数量：
                            <select name="pagesize" >
                                <option value="30" <?php if($pagesize==30) { ?> selected="selected"  <?php } ?>
>30</option>
                                <option value="40" <?php if($pagesize==40) { ?> selected="selected"  <?php } ?>
>40</option>
                                <option value="50" <?php if($pagesize==50) { ?> selected="selected"  <?php } ?>
>50</option>
                                <option value="60" <?php if($pagesize==60) { ?> selected="selected"  <?php } ?>
>60</option>
                            </select>
                           </form>
                        </div>
                    </div>
                </div>
            </div>
            
          </div><!-- 产品列表 -->
            
        </div>
        
        <?php echo  Stourweb_View::template("footer");  ?>
        
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
         var verifystatus = "<?php echo $userinfo['verifystatus'];?>";
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
