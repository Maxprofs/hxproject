<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>结算记录-<?php echo $webname;?></title>
    <?php echo Model_Supplier::css("style.css,base.css,extend.css",'brokerage');?>
    <?php echo Common::js("jquery.min.js");?>
</head>
<body>
<div class="page-box">
    <?php echo Request::factory('pc/pub/header')->execute()->body(); ?>
    <!-- 顶部 -->
    <?php echo  Stourweb_View::template('pc/brokerage/sidemenu');  ?>
    <!-- 侧边导航 -->
    <div class="main">
        <div class="content-box">
            <div class="frame-box">
                <div class="finance-content">
                    <div class="finance-bloock">
                        <div class="census-item census-item-float-left">
                            <ul>
                                <li class="clearfix">
                                    <strong class="item-bt">结算状态：</strong>
                                    <div class="item-nr">
                                        <select name="" class="attr-select" id="status" style="padding-left: 5px">
                                            <option value="0">全部</option>
                                            <option value="1" <?php if($status==1) { ?>selected<?php } ?>
>未结算</option>
                                            <option value="2" <?php if($status==2) { ?>selected<?php } ?>
>已结算</option>
                                        </select>
                                    </div>
                                </li>
                                <li class="clearfix">
                                    <strong class="item-bt">产品名称：</strong>
                                    <div class="item-nr">
                                        <input type="text" class="date-start" value="<?php echo $keyword;?>" id="keyword" style="padding-left: 5px" placeholder="产品名称" >
                                    </div>
                                </li>
                                <li class="clearfix">
                                    <div class="item-nr">
                                        <a href="javascript:;"  class="choose-btn">搜索</a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="cw-table clearfix">
                            <table width="100%" border="0">
                                <tbody>
                                <tr id="record_list_header">
                                    <th width="10%">订单号</th>
                                    <th width="20%">产品名称</th>
                                    <th width="10%">收款时间</th>
                                    <th width="10%">订单状态</th>
                                    <th width="15%">应结金额</th>
                                    <th width="15%">未结金额</th>
                                    <th width="15%">已结金额</th>
                                    <th width="10%">结算状态</th>
                                </tr>
                                <?php $n=1; if(is_array($list)) { foreach($list as $l) { ?>
                                <tr>
                                    <td><?php echo $l['ordersn'];?></td>
                                    <td><?php echo $l['productname'];?></td>
                                    <td><?php echo $l['addtime'];?></td>
                                    <td><?php if($l['order_status']==2) { ?>待消费<?php } else { ?>已完成<?php } ?>
</td>
                                    <td><?php echo $l['brokerage'];?><?php if($l['dingjin']>0&&$l['paytype']==2) { ?>(定金:<?php echo $l['dingjin'];?>)<?php } ?>
</td>
                                    <td><?php if($l['open_price']) { ?> <span style="color: red"><?php echo $l['open_price'];?></span><?php } else { ?>0<?php } ?>
</td>
                                    <td><?php echo $l['finish_brokerage'];?></td>
                                    <td><?php if($l['status']==1) { ?> <span style="color: red">未结算</span><?php } else { ?>已结算<?php } ?>
</td>
                                </tr>
                                <?php $n++;}unset($n); } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="view-block-table">
                            <?php echo $pageinfo;?>
                        </div>
                    </div>
                </div><!-- 财务总览 -->
            </div>
            <div class="st-record"><?php echo Common::get_sys_para('cfg_supplier_footer');?></div>
        </div>
    </div>
</div>
</body>
</html>
<script>
    $(function () {
        $('.hd-menu a').removeClass('cur');
        $('.hd-menu #brokerage').addClass('cur');
        $('#brokerage_index').addClass('on');
        $('.choose-btn').click(function () {
            var status = $('#status').val();
            var keyword = $('#keyword').val();
            var url = '<?php echo $cmsurl;?>brokerage/index?status='+status+'&keyword='+keyword;
            location.href = url;
        })
    })
</script>
