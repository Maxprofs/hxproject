<?php if($channel['car']['isopen']) { ?>
<div class="st-product-block">
    <h3 class="st-title-bar">
        <i class="line-icon"></i>
        <span class="title-txt"><?php echo $channel['car']['channelname'];?></span>
    </h3>
    <ul class="st-list-block clearfix">
        <?php $car_tag = new Taglib_Car();if (method_exists($car_tag, 'query')) {$car_data = $car_tag->query(array('action'=>'query','flag'=>'order','return'=>'car_data',));}?>
        <?php $n=1; if(is_array($car_data)) { foreach($car_data as $row) { ?>
        <li>
            <a class="item" href="<?php echo $row['url'];?>">
                <div class="pic"><img src="<?php echo $defaultimg;?>" st-src="<?php echo Common::img($row['litpic'],330,225);?>" alt="<?php echo $row['title'];?>"/></div>
                <div class="tit"><?php echo $row['title'];?><span class="md"><?php echo $row['sellpoint'];?></span></div>
                <div class="price">
                    <?php if(!empty($row['price'])) { ?>
                    <span class="jg"><i class="currency_sy no-style"><?php echo Currency_Tool::symbol();?></i><span class="num"><?php echo $row['price'];?></span>起</span>
                    <?php } else { ?>
                    <span class="dx">电询</span>
                    <?php } ?>
                </div>
            </a>
        </li>
        <?php $n++;}unset($n); } ?>
        
    </ul>
    <div class="st-more-bar">
        <a class="more-link" href="<?php echo $cmsurl;?>cars/all/">查看更多</a>
    </div>
</div>
<?php } ?>
<!--热门租车-->