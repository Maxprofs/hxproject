<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>我的订单-<?php echo $webname;?></title>
    <?php echo Common::css("style.css,base.css");?>
    <?php echo Common::js("jquery.min.js,common.js");?>
</head>
<body>
<?php echo  Stourweb_View::template("pub");  ?>
<div class="page-box">
    <div class="">
        <div class="content-box" >
            <div class="frame-box">
                <div class="frame-con">
                    <div class="verify-box">
                        <form id="st_form" method="get" action="<?php echo $cmsurl;?>order/all">
                        <div class="verify-list-tit">
                            <strong class="bt">我的订单</strong>
                            <div class="pm-btm-box fr" style="margin: 0;padding: 0;">
                                <a class="pm-gn-btn btn_excel" title="导出excel" href="javascript:;">导出excel</a>
                            </div>
                        </div>
                        <div class="verify-search-box">
                            <div class="verify-search-con">
                                <input type="text" name="searchKey" class="search-txt" placeholder="请输入短信码或订单号进行搜索" value="<?php echo $get['searchKey'];?>"/>
                                <input type="button" class="search-btn" value="搜索"/>
                            </div>
                        </div>
                        <div class="verify-con" style="overflow: auto">
                            <table class="verify-table" width="100%" border="0">
                                <tr>
                                    <th width="45%" height="40" align="center" scope="col">订单信息</th>
                                    <th width="10%" height="40" align="center" scope="col">使用日期</th>
                                    <th width="10%" height="40" align="center" scope="col">数量</th>
                                    <th width="10%" height="40" align="center" scope="col">总额</th>
                                    <th width="10%" height="40" align="center" scope="col">收益</th>
                                    <th width="10%" height="40" align="center" scope="col">状态</th>
                                    <th width="15%" height="40" align="center" scope="col">操作</th>
                                </tr>
                                <?php $n=1; if(is_array($data['list'])) { foreach($data['list'] as $v) { ?>
                                <tr>
                                    <td>
                                        <div class="cp">
                                            <a href="<?php echo $v['url'];?>">
                                                <div class="pic">
                                                    <img src="<?php echo $v['litpic'];?>" width="112" height="80" alt="<?php echo $v['productname'];?>"/>
                                                </div>
                                                <div class="con">
                                                    <p class="bt"><?php echo $v['productname'];?></p>
                                                    <p class="hm">订单号：<?php echo $v['ordersn'];?></p>
                                                </div>
                                            </a>
                                        </div>
                                    </td>
                                    <td><span class="price"><?php echo $v['usedate'];?></span></td>
                                    <td><span class="num"><?php echo $v['num'];?></span></td>
                                    <td><span class="total">&yen;<?php echo $v['total_price'];?><?php if($v['subscription_price']>0) { ?><br/>(定金&yen;<?php echo $v['subscription_price'];?>)<?php } ?>
</span></td>
                                    <td><span class="total">&yen;<?php echo $v['compute_info']['supplier_income'];?></span></td>
                                    <td>
                                        <!-- <?php if(!in_array($v['status'],Model_Member_Order::$changeableStatus)) { ?>/ -->
                                        <!-- <span class="<?php if($v['status']==2 ) { ?>period<?php } else { ?>wxf<?php } ?>
"><?php echo $v['order_status'];?></span> -->
                                        <!-- <?php } else { ?>
                                        <select onchange="change_status(this,'<?php echo $v['ordersn'];?>')">
                                            <?php $n=1; if(is_array($statusarr)) { foreach($statusarr as $k=>$status) { ?>
                                               <option value="<?php echo $k;?>" <?php if($k==$v['status']) { ?>selected="selected"<?php } ?>
  ><?php echo $status;?></option>
                                               <span class="<?php if($v['status']==2 ) { ?>period<?php } else { ?>wxf<?php } ?>
"><?php echo $v['order_status'];?>
                                            <?php $n++;}unset($n); } ?>
                                        </select>
                                        <?php } ?>
 -->
                                          <?php if(!in_array($v['status'],Model_Member_Order::$changeableStatus)) { ?>
                                        <span class="<?php if($v['status']==2 ) { ?>period<?php } else { ?>wxf<?php } ?>
"><?php echo $v['order_status'];?></span>
                                        <?php } else { ?>
                                        <span class="<?php if($v['status']==2 ) { ?>period<?php } else { ?>wxf<?php } ?>
"><?php echo $v['order_status'];?></span>
<!--                                        <select onchange="change_status(this,'<?php echo $v['ordersn'];?>')">-->
<!--                                            <?php $n=1; if(is_array($statusarr)) { foreach($statusarr as $k=>$status) { ?>-->
<!--                                            <option value="<?php echo $k;?>" <?php if($k==$v['status']) { ?>selected="selected"<?php } ?>
  ><?php echo $status;?></option>-->
<!--                                            <?php $n++;}unset($n); } ?>-->
<!--                                        </select>-->
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <a class="show" href="<?php echo $cmsurl;?>order/show?id=<?php echo $v['id'];?>">查看订单</a>
                                    </td>
                                </tr>
                                <?php $n++;}unset($n); } ?>
                            </table>
                            <?php if(empty($data)) { ?>
                            <div class="nofound-order">对不起！没有符合条件，请尝试其他搜索条件。</div>
                            <!-- 搜索无结果 -->
                            <?php } ?>
                        </form>
                    </div>
                    <div class="pm-btm-box">
                            <div class="pm-btm-msg">
                                <?php echo $data['pageinfo'];?>
                            </div>
                    </div>
                </div>
                    <!-- 验单记录 -->
                </div>
            </div>
        <?php echo  Stourweb_View::template("footer");  ?>
        </div>
    </div>
    <!-- 主体内容 -->
<script>
    $(window).resize(function(){
        sizeHeight()
    })
    function sizeHeight()
    {
        var pmHeight = $(window).height();
        var gdHeight = 250;
        $('.verify-con').height(pmHeight-gdHeight);
    }
    sizeHeight();
    $(function(){
        $("#nav_line_order").addClass('on');
        $('body').delegate('.add-list','click',function() {
            $(this).parent().after('<li><input name="num[]" type="text" class="num-list" placeholder="请输入短信码进行搜索"/><span class="add-list">增加</span></li>');
            $(this).remove();
        });
        $(".search-btn").click(function(){
            $("#st_form").submit();
        });
        //导出excel
        $(".btn_excel").click(function(){
            var url=SITEURL+"order/excel";
            ST.Util.showBox('订单生成excel',url,560,380,function(){});
        })
    });
    function change_status(ele,ordersn)
    {
        var status = $(ele).val();
        $.ajax({
            type:'POST',
            data:{ordersn:ordersn,status:status},
            url:SITEURL+'order/ajax_order_status',
            dataType:'json',
            success:function(data){
            }
        })
    }
</script>
</body>
</html>
