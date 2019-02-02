<?php defined('SYSPATH') or die();?> <!doctype html> <html> <head> <meta charset="utf-8"> <title><?php if($is_all) { ?>旅游攻略大全_热门旅游攻略_旅游资讯-<?php echo $GLOBALS['cfg_webname'];?><?php } else { ?><?php echo $searchtitle;?><?php } ?> </title> <?php echo $destinfo['keyword'];?> <?php echo $destinfo['description'];?> <?php echo  Stourweb_View::template("pub/varname");  ?> <?php echo Common::css_plugin('gonglue.css','article');?> <?php echo Common::css('base.css,extend.css');?> <?php echo Common::js('jquery.min.js,base.js,common.js,delayLoading.min.js');?> </head> <body> <?php echo Request::factory("pub/header")->execute()->body(); ?> <div class="big"> <div class="wm-1200"> <div class="st-guide"> <?php require_once ("E:/wamp64/www/taglib/position.php");$position_tag = new Taglib_Position();if (method_exists($position_tag, 'list_crumbs')) {$data = $position_tag->list_crumbs(array('action'=>'list_crumbs','destid'=>$destinfo['dest_id'],'typeid'=>$typeid,));}?> </div><!--面包屑--> <div class="st-main-page"> <div class="st-gl-list-box"> <div class="seo-content-box"> <h3 class="seo-bar"><span class="seo-title"><?php if($destinfo['dest_name']) { ?><?php echo $destinfo['dest_name'];?><?php echo $channelname;?><?php } else { ?><?php echo $channelname;?><?php } ?> </span></h3> <?php if($destinfo['dest_jieshao']) { ?> <div class="seo-wrapper clearfix"> <?php echo $destinfo['dest_jieshao'];?> </div> <?php } ?> </div> <!-- 目的地优化设置 --> <div class="st-list-search"> <div class="been-tj" <?php if(count($chooseitem)<1) { ?>style="display:none"<?php } ?>
> <strong>已选条件：</strong> <p> <?php $n=1; if(is_array($chooseitem)) { foreach($chooseitem as $item) { ?> <span class="chooseitem" data-url="<?php echo $item['url'];?>"><?php echo $item['itemname'];?><i></i></span> <?php $n++;}unset($n); } ?> <a href="javascript:;" class="clearc">清空筛选条件 </a> </p> </div> <div class="line-search-tj"> <dl class="type"> <dt>目的地：</dt> <dd> <p> <?php require_once ("E:/wamp64/www/taglib/dest.php");$dest_tag = new Taglib_Dest();if (method_exists($dest_tag, 'query')) {$destlist = $dest_tag->query(array('action'=>'query','typeid'=>$typeid,'flag'=>'nextsame','row'=>'100','pid'=>$destid,'return'=>'destlist',));}?> <?php $n=1; if(is_array($destlist)) { foreach($destlist as $dest) { ?> <a href="<?php echo $cmsurl;?>raiders/<?php echo $dest['pinyin'];?>/"><?php echo $dest['kindname'];?></a> <?php $n++;}unset($n); } ?> <?php if(count($destlist)>10) { ?> <em><b>收起</b><i class='up'></i></em> <?php } ?> </p> </dd> </dl> <!--属性组读取--> <?php require_once ("E:/wamp64/www/taglib/attr.php");$attr_tag = new Taglib_Attr();if (method_exists($attr_tag, 'query')) {$grouplist = $attr_tag->query(array('action'=>'query','flag'=>'grouplist','typeid'=>$typeid,'return'=>'grouplist',));}?> <?php $n=1; if(is_array($grouplist)) { foreach($grouplist as $group) { ?> <dl class="type"> <dt><?php echo $group['attrname'];?>：</dt> <dd> <p> <?php require_once ("E:/wamp64/www/taglib/attr.php");$attr_tag = new Taglib_Attr();if (method_exists($attr_tag, 'query')) {$attrlist = $attr_tag->query(array('action'=>'query','flag'=>'childitem','typeid'=>$typeid,'groupid'=>$group['id'],'return'=>'attrlist',));}?> <?php $n=1; if(is_array($attrlist)) { foreach($attrlist as $attr) { ?> <a href="<?php echo Model_Article::get_search_url($attr['id'],'attrid',$param);?>" <?php if(Common::check_in_attr($param['attrid'],$attr['id'])!==false) { ?>class="on"<?php } ?>
><?php echo $attr['attrname'];?></a> <?php $n++;}unset($n); } ?> </p> </dd> </dl> <?php $n++;}unset($n); } ?> </div> </div><!-- 条件搜索 --> <div class="st-gl-list-con"> <?php if(!empty($list)) { ?> <ul> <?php $n=1; if(is_array($list)) { foreach($list as $a) { ?> <li> <div class="pic"><i>HOT</i><a href="<?php echo $a['url'];?>" target="_blank" title="<?php echo $a['title'];?>"><img src="<?php echo Product::get_lazy_img();?>" st-src="<?php echo Common::img($a['litpic'],320,218);?>" alt="<?php echo $a['title'];?>" /></a></div> <div class="con"> <p class="tit"> <a href="<?php echo $a['url'];?>" target="_blank" title="<?php echo $a['title'];?>"><?php echo $a['title'];?> </a> </p> <p class="attr"> <?php $n=1; if(is_array($a['attrlist'])) { foreach($a['attrlist'] as $attr) { ?> <span><?php echo $attr['attrname'];?></span> <?php $n++;}unset($n); } ?> </p> <p class="txt"><?php echo Common::cutstr_html($a['content'],300);?></p> <p class="data"> <span class="num"><?php echo $a['shownum'];?></span> <span class="date"><?php echo Common::mydate('Y-m-d',$a['modtime']);?></span> </p> </div> </li> <?php $n++;}unset($n); } ?> </ul> <div class="main_mod_page clear"> <?php echo $pageinfo;?> </div><!-- 翻页 --> <?php } else { ?> <div class="no-content"> <p><i></i>抱歉，没有找到相关攻略！<a href="/raiders/all">查看全部攻略</a></p> </div> <?php } ?> </div> </div> </div> </div> <?php echo Request::factory("pub/footer")->execute()->body(); ?> <?php echo Request::factory("pub/flink")->execute()->body(); ?> <script>
    $(function(){
        //搜索条件去掉最后一条边框
        $('.line-search-tj').find('dl').last().addClass('bor_0')
        $(".line-search-tj dl dd em").toggle(function(){
            $(this).prev().height('24px');
            $(this).children('b').text('展开');
            $(this).children('i').removeClass('up')
        },function(){
            $(this).prev().height('auto');
            $(this).children('b').text('收起');
            $(this).children('i').addClass('up')
        });
        //排序方式点击
        $('.sort-sum').find('a').click(function(){
            var url = $(this).find('i').attr('data-url');
            window.location.href = url;
        })
        //删除已选
        $(".chooseitem").find('i').click(function(){
            var url = $(this).parent().attr('data-url');
            window.location.href = url;
        })
        //清空筛选条件
        $('.clearc').click(function(){
            var url = SITEURL+'raiders/all/';
            window.location.href = url;
        })
        //隐藏没有属性下级分类
        $(".type").each(function(i,obj){
            var len = $(obj).find('dd p a').length;
            if(len<1){
                $(obj).hide();
            }
        })
    })
</script> </body> </html>
