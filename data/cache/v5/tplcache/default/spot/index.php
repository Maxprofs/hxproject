<?php defined('SYSPATH') or die();?> <!doctype html> <html> <head strong_background=7c5QDl > <meta charset="utf-8"> <title><?php echo $seoinfo['seotitle'];?>-<?php echo $GLOBALS['cfg_webname'];?></title> <?php if($seoinfo['keyword']) { ?> <meta name="keywords" content="<?php echo $seoinfo['keyword'];?>" /> <?php } ?> <?php if($seoinfo['description']) { ?> <meta name="description" content="<?php echo $seoinfo['description'];?>" /> <?php } ?> <?php echo  Stourweb_View::template("pub/varname");  ?> <?php echo Common::css_plugin('scenic.css','spot');?> <?php echo Common::css('base.css,extend.css');?> <?php echo Common::js('jquery.min.js,base.js,common.js,SuperSlide.min.js,template.js,delayLoading.min.js');?> </head> <body> <?php echo Request::factory("pub/header")->execute()->body(); ?> <div class="big"> <div class="wm-1200"> <div class="st-guide"> <a href="<?php echo $cmsurl;?>"><?php echo $GLOBALS['cfg_indexname'];?></a>&nbsp;&nbsp;&gt;&nbsp;&nbsp;<?php echo $channelname;?> </div><!--面包屑--> <div class="st-scenic-home-top"> <div id="st-scenic-slideBox" class="st-scenic-slideBox"> <div class="hd"> <ul> <?php require_once ("E:/wamp64/www/taglib/ad.php");$ad_tag = new Taglib_Ad();if (method_exists($ad_tag, 'getad')) {$spotad = $ad_tag->getad(array('action'=>'getad','name'=>'SpotRollingAd','pc'=>'1','return'=>'spotad',));}?> <?php $n=1; if(is_array($spotad['aditems'])) { foreach($spotad['aditems'] as $k => $v) { ?> <li>$k</li> <?php $n++;}unset($n); } ?> </ul> </div> <div class="bd"> <ul> <?php $n=1; if(is_array($spotad['aditems'])) { foreach($spotad['aditems'] as $k => $v) { ?> <li><a href="<?php echo $v['adlink'];?>" target="_blank"><img original-src="<?php echo Common::img($v['adsrc'],1200,360);?>" alt="<?php echo $v['adname'];?>" /></a></li> <?php $n++;}unset($n); } ?> </ul> </div> <!--前/后按钮代码--> <a class="prev" href="javascript:void(0)"></a> <a class="next" href="javascript:void(0)"></a> </div><!--景点门票首页焦点图--> </div> <!--栏目介绍--> <?php if(!empty($seoinfo['jieshao'])) { ?> <div class="st-comm-introduce"> <div class="st-comm-introduce-txt"> <?php echo $seoinfo['jieshao'];?> </div> </div> <?php } ?> <?php require_once ("E:/wamp64/www/taglib/dest.php");$dest_tag = new Taglib_Dest();if (method_exists($dest_tag, 'query')) {$destlist = $dest_tag->query(array('action'=>'query','flag'=>'channel_nav','typeid'=>$typeid,'row'=>'6','return'=>'destlist',));}?> <?php $n=1; if(is_array($destlist)) { foreach($destlist as $dest) { ?> <div class="st-cp-slideTab"> <div class="st-tabnav"> <h3><?php echo $dest['kindname'];?></h3> <span data-id="<?php echo $dest['id'];?>" class="on" data-url="/spots/<?php echo $dest['pinyin'];?>/">热门<i></i></span> <?php require_once ("E:/wamp64/www/taglib/dest.php");$dest_tag = new Taglib_Dest();if (method_exists($dest_tag, 'query')) {$nextdest = $dest_tag->query(array('action'=>'query','flag'=>'next','typeid'=>$typeid,'pid'=>$dest['id'],'row'=>'6','return'=>'nextdest',));}?> <?php $n=1; if(is_array($nextdest)) { foreach($nextdest as $nr) { ?> <span data-id="<?php echo $nr['id'];?>" data-url="/spots/<?php echo $nr['pinyin'];?>/"><?php echo $nr['kindname'];?><i></i></span> <?php $n++;}unset($n); } ?> <a href="/spots/<?php echo $dest['pinyin'];?>/" class="more">更多<?php echo $channelname;?></a> </div> <div class="st-tabcon"> <ul> <?php $spot_tag = new Taglib_Spot();if (method_exists($spot_tag, 'query')) {$spotlist = $spot_tag->query(array('action'=>'query','flag'=>'mdd','destid'=>$dest['id'],'row'=>'4','return'=>'spotlist',));}?> <?php $n=1; if(is_array($spotlist)) { foreach($spotlist as $spot) { ?> <li <?php if($n%4==0) { ?>class="mr_0"<?php } ?>
> <a class="pic" href="<?php echo $spot['url'];?>" target="_blank" title="<?php echo $spot['title'];?>"><img src="<?php echo Product::get_lazy_img();?>" st-src="<?php echo Common::img($spot['litpic'],283,193);?>" alt="<?php echo $spot['title'];?>" /></a> <p class="tit"><a href="<?php echo $spot['url'];?>" target="_blank" title="<?php echo $spot['title'];?>"><?php echo $spot['title'];?></a></p> <p class="data"> <?php if($spot['sellprice']) { ?> <del>原价：<i class="currency_sy"><?php echo Currency_Tool::symbol();?></i><?php echo $spot['sellprice'];?></del> <?php } ?> <?php if($spot['price']) { ?> <span><b><i class="currency_sy"><?php echo Currency_Tool::symbol();?></i><?php echo $spot['price'];?></b>起</span> <?php } else { ?> <span>电询</span> <?php } ?> </p> </li> <?php $n++;}unset($n); } ?> </ul> </div> </div> <?php $n++;}unset($n); } ?> </div> </div> <?php echo Request::factory("pub/footer")->execute()->body(); ?> <?php echo Request::factory("pub/flink")->execute()->body(); ?> </body> <script type="text/html" id="tpl_spot"> <ul class="st-cp-list">
        {{each list as value i}}
        <li {{if (i+1)%4==0}}class="mr_0"{{/if}}> <a class="pic" href="{{value.url}}" target="_blank" title="<?php echo $spot['title'];?>"><img src="{{value.litpic}}" alt="{{value.title}}" /></a> <p class="tit"><a href="{{value.url}}" target="_blank" title="<?php echo $spot['title'];?>">{{value.title}}</a></p> <p class="data">
            {{if value.sellprice}}
            <del>原价：<i class="currency_sy"><?php echo Currency_Tool::symbol();?></i>{{value.sellprice}}</del>
            {{/if}}
            {{if value.price}}
            <span><b><i class="currency_sy"><?php echo Currency_Tool::symbol();?></i>{{value.price}}</b>起</span>
            {{else}}
            <span><b></b></span>
            {{/if}}
        </p> </li>
        {{/each}}
    </ul> </script> <script>
    $(function(){
        //景点门票首页焦点图
        $('.st-scenic-slideBox').slide({
            mainCell:'.bd ul',
            effect:"fold",
            easing:'easeOutCirc',
            autoPlay:true,
            switchLoad:"original-src"
        })
        //选中第一个选项
        $('.st-tabnav').each(function(i,obj){
           // $(obj).find('span').first().addClass('on');
        })
        $('.st-tabnav').find('span').click(function(){
            var destid = $(this).attr('data-id');
            var url = SITEURL+'spot/ajax_index_spot';
            var content = $(this).data(destid);
            var concontain = $(this).parents('.st-cp-slideTab').first().find('.st-tabcon');
            $(this).addClass('on').siblings().removeClass('on');
            var urlmore = $(this).attr("data-url");
            $(this).parent().find('.more').attr('href',urlmore);
            concontain.html('<img src="/res/images/loading.gif" style="display:block;width:28px;height:28px;margin:160px auto 157px auto;">');
            if(content){
                concontain.html(content);
            }else{
                $.getJSON(url, {destid:destid,pagesize:4}, function(data) {
                    var licontent = template('tpl_spot',data);
                    concontain.html(licontent);
                    concontain.data(destid,licontent);
                });
            }
        })
    })
</script> </html>
