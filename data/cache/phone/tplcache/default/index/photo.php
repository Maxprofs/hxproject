<?php if($channel['photo']['isopen']) { ?>
<div class="st-product-block">
    <h3 class="st-title-bar">
        <i class="line-icon"></i>
        <span class="title-txt"><?php echo $channel['photo']['channelname'];?></span>
    </h3>
    <ul class="st-photo-list clearfix">
        <?php $photo_list = Model_photo::photo_list(array('order'=>2))?>
        <?php $k=1;?>
        <?php $n=1; if(is_array($photo_list)) { foreach($photo_list as $photo) { ?>
        <?php if($k<7) { ?>
        <li>
            <a class="item" href="<?php echo $cmsur;?>photos/show_<?php echo $photo['aid'];?>.html">
                <img src="<?php echo $defaultimg;?>" st-src="<?php echo Common::img($photo['litpic'],220,150);?>" alt="<?php echo $photo['title'];?>"/>
            </a>
        </li>
        <?php } ?>
        <?php $k++;?>
        <?php $n++;}unset($n); } ?>
    </ul>
    <div class="st-more-bar">
        <a class="more-link" href="<?php echo $cmsurl;?>photos/all/">查看更多</a>
    </div>
</div>
<!--相册-->
<?php } ?>
