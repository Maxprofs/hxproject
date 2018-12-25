<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>酒店套餐列表管理</title>
    <?php echo Common::css("style.css,base.css");?>
    <?php echo Common::js("jquery.min.js,common.js,choose.js");?>
    <?php echo  Stourweb_View::template("pub/public_js");  ?>
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
    <?php echo Request::factory("pub/header")->execute()->body(); ?>
    <?php echo Request::factory("pub/sidemenu")->execute()->body(); ?>
    
    <div class="main">
    <div class="content-box">
        
        <div class="frame-box">
          
          <div class="pt-manage-box">
          
            <div class="pt-rows"><a class="pt-manage-add-btn fr" href="<?php echo $cmsurl;?>index/add">添加</a></div>
            
            <div class="pm-tab-box">
            
              <div class="pm-search-box">
                <div class="pm-search-con"><input type="text" class="pm-search-text keyword" value="<?php echo $keyword;?>" /><a href="javascript:void(0)" class="pm-search-btn">搜索</a></div>
                <div class="pm-tabnav">
                    <a class="pm-ta-lb" href="<?php echo $cmsurl;?>index">列表</a>
                    <a class="pm-ta-bj cur" href="<?php echo $cmsurl;?>index/suit_list">报价</a>
                </div>
              </div>
              
              <div class="pm-tabcon-list">
              <table class="pm-table-hd" width="100%" border="0">
                  <tr class="pl-th">
                    <th width="6%" height="38" scope="col">选择</th>
                    <th width="8%" scope="col">编号</th>
                    <th width="30%" scope="col">酒店名称</th>
                    <th width="8%" scope="col">报价有效期</th>
                    <th width="8%" scope="col">预订积分</th>
                    <th width="8%" scope="col">评论积分</th>
                    <th width="8%" scope="col">积分抵现</th>
                    <th width="8%" scope="col">最低价格</th>
                    <th width="8%" scope="col">最低利润</th>
                    <th width="8%" scope="col">管理</th>
                  </tr>
                </table>
              </div>
              
              <div class="pm-tabcon-list" id="productList">
                <table class="pm-table-list" width="100%" border="0">
                 <?php $n=1; if(is_array($list)) { foreach($list as $row) { ?>
                  <tr class="pl-tr">
                    <td width="6%" height="34" align="center"><div class="pm-table-boxs"><input type="checkbox" class="checkbox-lb product_check" value="<?php echo $row['id'];?>" /></div></td>
                    <td width="8%" align="center"><div class="pm-table-boxs"><?php echo $row['series'];?></div></td>
                    <td width="30%"><div class="pm-table-boxs"><a class="pm-table-bt" href="<?php echo $row['url'];?>" target="_blank"><?php echo $row['title'];?></a></div></td>
                    <td width="8%" align="center"><div class="pm-table-boxs"><span class="color-grey"><?php echo $row['expired_date'];?></span></div></td>
                    <td width="8%" align="center"><div class="pm-table-boxs">&nbsp;</div></td>
                    <td width="8%" align="center"><div class="pm-table-boxs">&nbsp;</div></td>
                    <td width="8%" align="center"><div class="pm-table-boxs">&nbsp;</div></td>
                    <td width="8%" align="center"><div class="pm-table-boxs">&nbsp;</div></td>
                    <td width="8%" align="center"><div class="pm-table-boxs">&nbsp;</div></td>
                    <td width="8%" align="center">
                      <div class="pm-table-boxs">
                        <a href="<?php echo $cmsurl;?>index/suit_add?productid=<?php echo $row['id'];?>" class="pm-add-tc-btn" title="添加套餐">添加套餐</a>
                      </div>
                    </td>
                  </tr>
                   <?php $n=1; if(is_array($row['suit'])) { foreach($row['suit'] as $suit) { ?>
                     <tr class="pl-tr pl-child-tr">
                        <td width="6%" height="34" align="center"><div class="pm-table-boxs">&nbsp;</div></td>
                        <td width="8%" align="center"><div class="pm-table-boxs">&nbsp;</div></td>
                        <td width="30%"><div class="pm-table-boxs"><a class="pm-table-bt" href="#"><?php echo $suit['roomname'];?></a></div></td>
                        <td width="8%" align="center"><div class="pm-table-boxs"><span class="color-grey"><?php echo $suit['expired_date'];?></span></div></td>
                        <td width="8%" align="center"><div class="pm-table-boxs"><input type="text" class="pm-jf-text" data-field="jifenbook" data-id="<?php echo $suit['id'];?>" value="<?php echo $suit['jifenbook'];?>" /></div></td>
                        <td width="8%" align="center"><div class="pm-table-boxs"><input type="text" class="pm-jf-text" data-field="jifencomment" data-id="<?php echo $suit['id'];?>" value="<?php echo $suit['jifencomment'];?>" /></div></td>
                        <td width="8%" align="center"><div class="pm-table-boxs"><input type="text" class="pm-jf-text" data-field="jifentprice" data-id="<?php echo $suit['id'];?>" value="<?php echo $suit['jifentprice'];?>" /></div></td>
                        <td width="8%" align="center"><div class="pm-table-boxs"><span class="color-grey"><?php echo $suit['min_price'];?></span></div></td>
                        <td width="8%" align="center"><div class="pm-table-boxs"><span class="color-grey"><?php echo $suit['min_profit'];?></span></div></td>
                        <td width="8%" align="center">
                          <div class="pm-table-boxs">
                            <a href="<?php echo $cmsurl;?>index/suit_edit?id=<?php echo $suit['id'];?>" class="pm-delete-btn" title="编辑"></a>
                            <a href="javascript:void(0)" data-id="<?php echo $suit['id'];?>" class="pm-edit-btn" title="删除"></a>
                          </div>
                        </td>
                     </tr>
                   <?php $n++;}unset($n); } ?>
                 <?php $n++;}unset($n); } ?>
                </table>
              </div>
              
              <div class="pm-btm-box">
              <a class="pm-gn-btn" href="javascript:;">全选</a>
              <a class="pm-gn-btn ml-10" href="javascript:;">反选</a>
              <!--<a class="pm-gn-btn btm-delete-btn ml-10" href="#">删除</a>-->
                <div class="pm-btm-msg">
                  <?php echo $pageinfo;?>
                </div>
              </div>
              
            </div>
            
            
          </div><!-- 产品列表 -->
            
        </div>
            <?php echo Request::factory("pub/footer")->execute()->body(); ?>
        
      </div>
    </div><!-- 主体内容 -->
  
  </div>
<script>
    $(function(){
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
        //删除房型
        $(".pm-edit-btn").click(function(){
            var suitid = $(this).attr('data-id');
            if(suitid){
                ST.Util.confirmBox('删除房型','删除房型后无法恢复,确定删除?',function(){
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
    })
</script>
</body>
</html>
