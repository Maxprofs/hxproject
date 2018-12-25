<?php if($channel['notes']['isopen']) { ?>
<div class="st-product-block">
    <h3 class="st-title-bar">
        <i class="line-icon"></i>
        <span class="title-txt"><?php echo $channel['notes']['channelname'];?></span>
    </h3>
    <ul class="st-travelnotes-list">
        <?php $notes_tag = new Taglib_Notes();if (method_exists($notes_tag, 'query')) {$data = $notes_tag->query(array('action'=>'query','flag'=>'order','row'=>'3',));}?>
        <?php $n=1; if(is_array($data)) { foreach($data as $row) { ?>
        <li>
            <a class="item" href="<?php echo $row['url'];?>">
                <div class="pic">
                    <img src="<?php echo $defaultimg;?>" st-src="<?php echo Common::img($row['litpic'],235,160);?>" alt="<?php echo $row['title'];?>"/>
                </div>
                <div class="info">
                    <p class="tit"><?php echo $row['title'];?></p>
                    <p class="data clearfix">
                        <span class="phone fl"><?php echo Common::cutstr_html($row['nickname'],16);?></span>
                        <span class="num fr"><i class="icon"></i><?php echo $row['shownum'];?></span>
                    </p>
                </div>
            </a>
        </li>
        <?php $n++;}unset($n); } ?>
        
    </ul>
    <div class="st-more-bar">
        <a class="more-link" href="<?php echo $cmsurl;?>notes/all/">查看更多</a>
    </div>
</div>
<!--游记-->
<?php } ?>
