<?php if($channel['line']['isopen']==1) { ?>
<div class="st-product-block">
    <h3 class="st-title-bar">
        <i class="line-icon"></i>
        <span class="title-txt"><?php echo $channel['line']['channelname'];?></span>
    </h3>
    <ul class="st-list-block clearfix">
        <?php $line_tag = new Taglib_Line();if (method_exists($line_tag, 'query')) {$line_data = $line_tag->query(array('action'=>'query','flag'=>'order','row'=>'4','return'=>'line_data',));}?>
        <?php $n=1; if(is_array($line_data)) { foreach($line_data as $row) { ?>
        <li>
            <a class="item" href="<?php echo $row['url'];?>">
                <div class="pic"><img src="<?php echo $defaultimg;?>" st-src="<?php echo Common::img($row['litpic'],330,225);?>" alt="<?php echo $row['title'];?>"/></div>
                <div class="tit double"><?php if($row['color']) { ?><span style="color:<?php echo $row['color'];?>"><?php echo $row['title'];?></span><?php } else { ?><?php echo $row['title'];?><?php } ?>
<span class="md"><?php echo $row['sellpoint'];?></span>
                </div>
                <div class="price">
                    <?php if(!empty($row['price'])) { ?>
                    <span class="jg"><i class="currency_sy no-style"><?php echo Currency_Tool::symbol();?></i><strong class="num no-style"><?php echo $row['price'];?></strong>起</span>
                    <?php } else { ?>
                    <span class="dx">电询</span>
                    <?php } ?>
                </div>
            </a>
        </li>
        <?php $n++;}unset($n); } ?>
        
    </ul>
    <div class="st-more-bar">
        <a class="more-link" href="<?php echo $cmsurl;?>lines/all/">查看更多</a>
    </div>
</div>
<?php } ?>
<!--热门线路-->