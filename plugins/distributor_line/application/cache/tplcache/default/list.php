<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>供应商管理</title>
    <?php echo Common::css('base.css,style.css,extend.css');?>
    <?php echo Common::js('jquery.min.js,jquery.colorpicker.js,common.js,choose.js,product.js,insurance.js');?>
    <?php echo  Stourweb_View::template("pub");  ?>
</head>
<body>
    <div class="content-box">
        
        <div class="frame-box">
          
          <div class="pt-manage-box">
          
            <div class="pt-rows"><a class="pt-manage-add-btn fr" href="<?php echo $cmsurl;?>index/add">添加</a></div>
            
            <div class="pm-tab-box">
            
              <div class="pm-search-box">
                <div class="pm-search-con"><form method="get"><input type="text" class="pm-search-text" name="keyword" value="<?php echo $keyword;?>"/><a href="javascript:void(0)" id="search_btn" class="pm-search-btn">搜索</a></form></div>
                <div class="pm-tabnav">
                  <a class="pm-ta-lb cur togmod"  href="<?php echo $cmsurl;?>index/list" data-id="1">列表</a>
                  <a class="pm-ta-bj togmod" href="<?php echo $cmsurl;?>index/suit" data-id="2">报价</a>
                </div>
              </div>
                <div class="pm-tabcon-list">
                    <table class="pm-table-hd" width="100%" border="0">
                        <tr class="pl-th">
                            <th width="5%" height="38" scope="col">选择</th>
                            <th width="15%" scope="col">编号</th>
                            <th width="40%" scope="col">路线名称</th>
                            <th width="15%" scope="col">报价有效期</th>
                            <th width="15%" scope="col">上架状态</th>
                            <th width="10%" scope="col">管理</th>
                        </tr>
                    </table>
                </div>
                <div class="pm-tabcon-list" id="productList">
                    <table class="pm-table-list" width="100%" border="0">
                        <?php $n=1; if(is_array($list)) { foreach($list as $row) { ?>
                        <tr class="pl-tr" id="product_<?php echo $row['id'];?>">
                            <td width="5%" height="34" align="center"><div class="pm-table-boxs"><input type="checkbox" class="checkbox-lb cs-check" value="<?php echo $row['id'];?>"/></div></td>
                            <td width="15%" align="center"><div class="pm-table-boxs"><?php echo $row['lineseries'];?></div></td>
                            <td width="40%"><div class="pm-table-boxs"><a class="pm-table-bt" href="<?php echo $row['url'];?>" target="_blank"><?php echo $row['title'];?></a></div></td>
                            <td width="15%" align="center"><div class="pm-table-boxs"><?php if($row['suitday']) { ?><span class="color-grey"><?php echo $row['suitday'];?></span><?php } else { ?><span class="color-red">无套餐</span><?php } ?>
</div></td>
                            <td width="15%" align="center"><div class="pm-table-boxs"><?php if($row['ishidden']==0) { ?><span class="color-green">已通过</span><?php } else { ?><span class="color-red">未通过</span><?php } ?>
</div></td>
                            <td width="10%" align="center">
                                <div class="pm-table-boxs">
                                    <a href="javascript:void(0)" class="pm-delete-btn" onclick="goEdit('<?php echo $row['id'];?>')"  title="编辑"></a>
                                </div>
                            </td>
                        </tr>
                        <?php $n++;}unset($n); } ?>
                    </table>
                </div>
                <div class="pm-btm-box">
                    <a id="choose_all" class="pm-gn-btn" href="javascript:;">全选</a>
                    <a id="choose_diff" class="pm-gn-btn ml-10" href="javascript:;">反选</a>
                    <a class="pm-gn-btn btm-delete-btn ml-10" id="product_offline" href="javascript:;">下架</a>
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
<script>
    $(function() {
        $("#pagesize_fm select").change(function(){
            $("#pagesize_fm").submit();
        });
        $("#choose_all").click(function(){
            $(".cs-check").each(function(){
                $(this).attr("checked",true)
            });
        });
        $("#choose_diff").click(function(){
            $(".cs-check").each(function(){
                $(this).attr("checked",!this.checked);
            });
        });
        $("#product_offline").click(function(){
            if($(".cs-check:checked").length<=0)
            {
                ST.Util.showMsg("请选择至少一条线路",1);
                return;
            }
            ST.Util.confirmBox("提示","确定下架",function(){
                $(".cs-check:checked").each(function(){
                    var id=$(this).val();
                    offProduct(id);
                });
            })
        });
        $("#search_btn").click(function(){
             $(this).parents("form:first").submit();
        })
    });
    $(window).resize(function(){
        sizeHeight()
    })
    function sizeHeight()
    {
        var pmHeight = $(window).height();
        var gdHeight = 250;
        $('#productList').height(pmHeight-gdHeight);
    }
    sizeHeight();
    //其他操作
     function goEdit(id)
     {
         ST.openUrl(SITEURL+"index/edit/id/"+id);
     }
    function offProduct(id)
    {
        var url=SITEURL+'index/ajax_off_product';
        var params={id:id};
        $.ajax({
            type: "POST",
            url: url,
            data: params,
            dataType: "json",
            success: function(data){
                if(data.status)
                {
                  //  $("#product_"+id).remove();
                  //  $(".sub_"+id).remove();
                }
            }
        });
    }
</script>
</body>
</html>
