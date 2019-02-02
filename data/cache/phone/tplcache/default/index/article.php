<?php if($channel['article']['isopen']) { ?>
<div class="st-product-block">
    <h3 class="st-title-bar">
        <i class="line-icon"></i>
        <span class="title-txt"><?php echo $channel['article']['channelname'];?></span>
    </h3>
    <ul class="st-article-list">
        <?php $article_tag = new Taglib_Article();if (method_exists($article_tag, 'query')) {$article_data = $article_tag->query(array('action'=>'query','flag'=>'order','row'=>'3','return'=>'article_data',));}?>
        <?php $n=1; if(is_array($article_data)) { foreach($article_data as $row) { ?>
        <li>
            <a class="item" href="<?php echo $row['url'];?>">
                <div class="pic"><img src="<?php echo $defaultimg;?>" st-src="<?php echo Common::img($row['litpic'],235,160);?>" alt="<?php echo $row['title'];?>"/></div>
                <div class="info">
                    <p class="tit"><?php echo $row['title'];?></p>
                    <p class="txt"><?php echo Common::cutstr_html($row['summary'],20);?></p>
                    <p class="data">
                        <span class="mdd"><i class="icon"></i><?php echo $row['finaldest']['kindname'];?></span>
                        <span class="num"><i class="icon"></i><?php echo $row['shownum'];?></span>
                    </p>
                </div>
            </a>
        </li>
        <?php $n++;}unset($n); } ?>
        
    </ul>
    <div class="st-more-bar">
        <a class="more-link" href="<?php echo $cmsurl;?>raiders/all/">查看更多</a>
    </div>
</div>
<!--攻略-->
<?php } ?>
