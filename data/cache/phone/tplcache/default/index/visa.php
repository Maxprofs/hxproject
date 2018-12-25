<?php if($channel['visa']['isopen']==1) { ?>
<div class="st-product-block">
    <h3 class="st-title-bar">
        <i class="line-icon"></i>
        <span class="title-txt"><?php echo $channel['visa']['channelname'];?></span>
    </h3>
    <ul class="st-list-block clearfix">
        <?php $visa_tag = new Taglib_Visa();if (method_exists($visa_tag, 'query')) {$data = $visa_tag->query(array('action'=>'query','flag'=>'order','row'=>'4',));}?>
        <?php $n=1; if(is_array($data)) { foreach($data as $row) { ?>
        <li>
            <a class="item" href="<?php echo $row['url'];?>">
                <div class="pic"><img src="<?php echo $defaultimg;?>" st-src="<?php echo Common::img($row['litpic'],330,225);?>" title="<?php echo $row['title'];?>"></div>
                <div class="tit"><?php echo $row['title'];?></div>
                <div class="price">
                    <?php if($row['price']) { ?>
                    <span class="jg"><i class="currency_sy no-style"><?php echo Currency_Tool::symbol();?></i><span class="num"><?php echo $row['price'];?></span></span>
                    <?php } else { ?>
                    <span class="dx">电询</span>
                    <?php } ?>
                </div>
            </a>
        </li>
        <?php $n++;}unset($n); } ?>
        
    </ul>
    <div class="st-more-bar">
        <a class="more-link" href="<?php echo $cmsurl;?>visa/all/">查看更多</a>
    </div>
</div>
<!--签证-->
<?php } ?>
