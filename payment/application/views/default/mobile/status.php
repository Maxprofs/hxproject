<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo $info['title'];?>-<?php echo $info['cfg_webname'];?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link type="text/css" rel="stylesheet" href="/phone/public/css/base.css" />
    <link type="text/css" rel="stylesheet" href="/payment/public/css/pay_new.css" />
    <script type="text/javascript" src="/phone/public/js/lib-flexible.js"></script>
</head>

<body right_bottom=HkOzDt >

<div class="header_top">
    <h1 class="page-title-bar"><?php echo $info['title']?></h1>
</div>
<!-- 公用头部 -->

<div class="pay-status-bar">
    <div class="status-txt"><i class="status-icon <?php if(in_array($info['sign'],array(11,12,13,14,27))) echo 'success-icon'; else echo 'fail-icon'; ?> "></i><?php echo $info['msg']?></div>
</div>

<div class="pay-info-block">
    <ul class="info-list">
        <li>
            <div class="hd">订单号：</div>
            <div class="bd"><?php echo $info['ordersn']; ?></div>
        </li>
        <li>
            <div class="hd">产品名称：</div>
            <div class="bd"><?php echo $info['productname']; ?></div>
        </li>
        <li>
            <div class="hd">支付金额：</div>
            <div class="bd"><span class="total"><?php echo  Currency_Tool::symbol(); ?><?php echo $info['total']; ?></span></div>
        </li>
    </ul>
</div>

<div class="pay-back-bar">
    <a class="b-link" href="/">返回首页</a>
    <a class="b-link" href="/member#&myOrder">查看订单</a>
</div>
<?php  if($info['envelope_show']): ?>
<div class="pay-ad-block">
    <a class="item" href="/phone/member/order/show?id=<?php echo $info['order_id'] ?>">
        <span class="num"><?php echo $info['envelope_show']['view_total']; ?></span>
        <img src="/payment/public/images/pay-page-banner.jpg">
    </a>
</div>
<?php endif; ?>

</body>
</html>