<?php if($channel['ship_line']['isopen']==1) { ?>
<div class="st-product-block">
    <h3 class="st-title-bar">
        <i class="line-icon"></i>
        <span class="title-txt"><?php echo $channel['ship_line']['channelname'];?></span>
    </h3>
    <ul class="st-ship-list clearfix">
        <?php $ship_tag = new Taglib_Ship();if (method_exists($ship_tag, 'query')) {$subdata = $ship_tag->query(array('action'=>'query','row'=>'4','return'=>'subdata',));}?>
        <?php $n=1; if(is_array($subdata)) { foreach($subdata as $ship) { ?>
        <li>
            <a class="item" href="<?php echo $ship['url'];?>">
                <div class="pic">
                    <img src="<?php echo Common::img($ship['litpic'],330,225);?>" alt="<?php echo $ship['title'];?>" />
                    <?php if(!empty($ship['starttime'])) { ?><span class="date">出发时间：<?php echo date('Y-m-d',$ship['starttime']);?></span><?php } ?>
                </div>
                <div class="tit"><?php echo $ship['title'];?></div>
                <div class="info clearfix">
                    <span class="price fl"><?php if(!empty($ship['price'])) { ?><?php echo Currency_Tool::symbol();?><strong class="num no-style"><?php echo $ship['price'];?></strong>起<?php } else { ?>电询<?php } ?>
</span>
                    <span class="loac fr"><i class="icon"></i><?php if(!empty($ship['finaldest_name'])) { ?><?php echo $ship['finaldest_name'];?><?php } ?>
</span>
                </div>
            </a>
        </li>
        <?php $n++;}unset($n); } ?>
    </ul>
    <div class="st-more-bar">
        <a class="more-link" href="<?php echo $cmsurl;?>ship/all/">查看更多</a>
    </div>
</div>
<?php } ?>
<!--热门活动-->