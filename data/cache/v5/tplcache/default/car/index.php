<?php defined('SYSPATH') or die();?> <!doctype html> <html> <head html_color=0ATBbm > <meta charset="utf-8"> <title><?php echo $seoinfo['seotitle'];?>-<?php echo $GLOBALS['cfg_webname'];?></title> <?php if($seoinfo['keyword']) { ?> <meta name="keywords" content="<?php echo $seoinfo['keyword'];?>" /> <?php } ?> <?php if($seoinfo['description']) { ?> <meta name="description" content="<?php echo $seoinfo['description'];?>" /> <?php } ?> <?php echo  Stourweb_View::template("pub/varname");  ?> <?php echo Common::css_plugin('car.css','car');?> <?php echo Common::css('base.css,extend.css');?> <?php echo Common::js('jquery.min.js,base.js,common.js,SuperSlide.min.js,template.js,delayLoading.min.js');?> </head> <body> <?php echo Request::factory("pub/header")->execute()->body(); ?> <div class="big"> <div class="wm-1200"> <div class="st-guide"> <a href="<?php echo $cmsurl;?>"><?php echo $GLOBALS['cfg_indexname'];?></a>&nbsp;&nbsp;&gt;&nbsp;&nbsp;<?php echo $channelname;?> </div><!--面包屑--> <div class="st-car-home-top"> <div class="st-car-search"> <dl class="search-dl"> <dt>车型</dt> <dd> <input type="text" class="cs-text up-ico carkind" placeholder="车型" data-id="0" /> <div class="cs-select-box"> <?php $car_tag = new Taglib_Car();if (method_exists($car_tag, 'kind_list')) {$data = $car_tag->kind_list(array('action'=>'kind_list','row'=>'10',));}?> <?php $n=1; if(is_array($data)) { foreach($data as $kind) { ?> <span data-id="<?php echo $kind['id'];?>"><?php echo $kind['title'];?></span> <?php $n++;}unset($n); } ?> </div> </dd> </dl> <?php require_once ("E:/wamp64/www/taglib/attr.php");$attr_tag = new Taglib_Attr();if (method_exists($attr_tag, 'query')) {$grouplist = $attr_tag->query(array('action'=>'query','flag'=>'grouplist','row'=>'3','typeid'=>$typeid,'return'=>'grouplist',));}?> <?php $n=1; if(is_array($grouplist)) { foreach($grouplist as $group) { ?> <dl class="search-dl"> <dt><?php echo $group['attrname'];?></dt> <dd> <input type="text" class="cs-text up-ico searchattr" placeholder="<?php echo $group['attrname'];?>" data-id="0" /> <div class="cs-select-box"> <?php require_once ("E:/wamp64/www/taglib/attr.php");$attr_tag = new Taglib_Attr();if (method_exists($attr_tag, 'query')) {$data = $attr_tag->query(array('action'=>'query','flag'=>'childitem','groupid'=>$group['id'],'row'=>'10','typeid'=>$typeid,));}?> <?php $n=1; if(is_array($data)) { foreach($data as $r) { ?> <span data-id="<?php echo $r['id'];?>"><?php echo $r['title'];?></span> <?php $n++;}unset($n); } ?> </div> </dd> </dl> <?php $n++;}unset($n); } ?> <div class="car-search-btn"><a href="javascript:;">搜索</a></div> </div><!--租车搜索--> <div id="st-car-slideBox" class="st-car-slideBox"> <div class="hd"> <ul> <?php require_once ("E:/wamp64/www/taglib/ad.php");$ad_tag = new Taglib_Ad();if (method_exists($ad_tag, 'getad')) {$carad = $ad_tag->getad(array('action'=>'getad','name'=>'CarRollingAd','pc'=>'1','return'=>'carad',));}?> <?php $n=1; if(is_array($carad['aditems'])) { foreach($carad['aditems'] as $k => $v) { ?> <li><?php echo $k;?></li> <?php $n++;}unset($n); } ?> </ul> </div> <div class="bd"> <ul> <?php $n=1; if(is_array($carad['aditems'])) { foreach($carad['aditems'] as $v) { ?> <li><a href="<?php echo $v['adlink'];?>" target="_blank"><img src="<?php echo Product::get_lazy_img();?>" original-src="<?php echo Common::img($v['adsrc'],815,320);?>" alt="<?php echo $v['adname'];?>" /></a></li> <?php $n++;}unset($n); } ?> </ul> </div> <!--前/后按钮代码--> <a class="prev" href="javascript:void(0)"></a> <a class="next" href="javascript:void(0)"></a> </div><!--租车首页焦点图--> </div> <!--栏目介绍--> <?php if(!empty($seoinfo['jieshao'])) { ?> <div class="st-comm-introduce"> <div class="st-comm-introduce-txt"> <?php echo $seoinfo['jieshao'];?> </div> </div> <?php } ?> <div class="st-cp-slideTab"> <div class="st-tabnav"> <h3>热门推荐</h3> <?php $car_tag = new Taglib_Car();if (method_exists($car_tag, 'kind_list')) {$carkind = $car_tag->kind_list(array('action'=>'kind_list','return'=>'carkind',));}?> <?php $n=1; if(is_array($carkind)) { foreach($carkind as $kind) { ?> <span data-id="<?php echo $kind['id'];?>" <?php if($n==1) { ?>class="on"<?php } ?>
><?php echo $kind['title'];?><i></i></span> <?php $n++;}unset($n); } ?> <a href="/cars/all" class="more">更多</a> </div> <div class="st-tabcon"> <ul> <?php $car_tag = new Taglib_Car();if (method_exists($car_tag, 'query')) {$data = $car_tag->query(array('action'=>'query','flag'=>'recommend','kindid'=>$carkind[0]['id'],'row'=>'8',));}?> <?php $n=1; if(is_array($data)) { foreach($data as $c) { ?> <li <?php if($n%4==0) { ?>class="mr_0"<?php } ?>
> <i class="hot-ico"></i> <a class="pic" href="<?php echo $c['url'];?>" title="<?php echo $c['title'];?>" target="_blank"><img src="<?php echo Product::get_lazy_img();?>" st-src="<?php echo Common::img($c['litpic'],283,193);?>" alt="<?php echo $c['title'];?>" /></a> <p class="tit"><a href="<?php echo $c['url'];?>" target="_blank" title="<?php echo $c['title'];?>"><?php echo $c['title'];?></a></p> <p class="data"> <em>满意度 <?php if($c['satisfyscore']) { ?><?php echo $c['satisfyscore'];?>%<?php } ?> </em> <?php if(!empty($c['price'])) { ?> <span><i class="currency_sy"><?php echo Currency_Tool::symbol();?></i><b><?php echo $c['price'];?></b>起</span> <?php } else { ?> <span>电询</span> <?php } ?> </p> </li> <?php $n++;}unset($n); } ?> </ul> </div> </div> <script type="text/html" id="tpl_car"> <ul>
          {{each list as value i}}
            <li {{if (i+1)%4==0}}class="mr_0"{{/if}}> <i class="hot-ico"></i> <a class="pic" href="{{value.url}}" title="{{value.title}}" target="_blank"><img src="{{value.litpic}}" alt="{{value.title}}" /></a> <p class="tit"><a href="{{value.url}}" target="_blank" title="{{value.title}}">{{value.title}}</a></p> <p class="data"> <em>满意度 {{if value.satisfyscore}}{{value.satisfyscore}}%{{/if}}</em>
                {{if value.price!=''}}
                <span><i class="currency_sy"><?php echo Currency_Tool::symbol();?></i><b>{{value.price}}</b>起</span>
                {{else}}
                 <span>电询</span>
                {{/if}}
            </p> </li>
          {{/each}}
           </ul> </script> <script>
            $(function(){
                $('.st-tabnav').find('span').click(function(){
                    var carkindid = $(this).attr('data-id');
                    var url = SITEURL+'car/ajax_index_car';
                    var content = $(this).data(carkindid);
                    var concontain = $('.st-tabcon');
                    $(this).addClass('on').siblings().removeClass('on');
                    concontain.html('<img src="/res/images/loading.gif" style="display:block;width:28px;height:28px;margin:160px auto 157px auto;">');
                    if(content){
                        concontain.html(content);
                    }else{
                        $.getJSON(url, {carkindid:carkindid,pagesize:8}, function(data) {
                               var licontent = template('tpl_car',data);
                               concontain.html(licontent);
                               concontain.data(carkindid,licontent);
                        });
                    }
                })
            })
        </script> <div class="comment-list-box"> <div class="com-tit"> <h3>客户点评</h3> <p>了解最真实的旅游服务评价</p> </div> <div class="com-conbox"> <?php require_once ("E:/wamp64/www/taglib/comment.php");$comment_tag = new Taglib_Comment();if (method_exists($comment_tag, 'query')) {$data = $comment_tag->query(array('action'=>'query','flag'=>'car','row'=>'5',));}?> <?php $n=1; if(is_array($data)) { foreach($data as $c) { ?> <dl> <dt><a href="javascript:;" target="_blank"><img src="<?php echo Product::get_lazy_img();?>" st-src="<?php echo Common::img($c['product_litpic'],180,110);?>" /></a></dt> <dd> <p class="bt"> <?php if(!empty($c['productname'])) { ?> <?php echo $c['productname'];?> <?php } ?> <span class="price"><?php if(!empty($c['product_price'])) { ?>预定价格：<i class="currency_sy"><?php echo Currency_Tool::symbol();?></i><?php echo $c['product_price'];?><?php } ?> </span> </p> <p class="user"><span class="name"><?php echo $c['nickname'];?></span><span class="date"><?php echo Common::mydate('Y-m-d',$c['addtime']);?></span></p> <p class="txt"><?php echo $c['content'];?></p> <p class="score"><em>综合评分：</em><span><i style=" width:<?php echo $c['percent'];?>"></i></span></p> </dd> </dl> <?php $n++;}unset($n); } ?> </div> </div> </div> </div> <?php echo Request::factory("pub/footer")->execute()->body(); ?> <?php echo Request::factory("pub/flink")->execute()->body(); ?> <script>
     $(function(){
         //租车首页焦点图
         $('.st-car-slideBox').slide({
 mainCell:'.bd ul',
 effect:"fold",
interTime: 5000,
delayTime: 500,
autoPlay:true,
                        switchLoad:"original-src"
 })
         //租车下拉选择
         $('.cs-text').click(function(){
             $('.cs-select-box').hide();
             var selectBox =$(this).parent().find('.cs-select-box');
             if(selectBox.css("display")=="none"){
                 $(this).removeClass('up-ico').addClass('down-ico')
                 $(this).next().slideDown("fast");
             }else{
                 $(this).next().slideUp("fast");
                 $(this).removeClass('down-ico').addClass('up-ico');
                 selectBox.hide();
             }
         });
         $(".cs-select-box span").click(function(){
             $(this).parent().prev().removeClass('down-ico').addClass('up-ico')
             var txt = $(this).text();
             $(this).parent().prev().val(txt);
             var value = $(this).attr("data-id");
             $(this).parent().prev().attr('data-id',value);
             $(this).parent().hide();
         });
         //搜索
         $(".car-search-btn").click(function(){
             var carkind = $(".carkind").attr('data-id');
             var attrid = '';
             var attrArr = [];
              $('.searchattr').each(function(i,obj){
                  attrArr.push($(obj).attr('data-id'))
              })
             attrid = attrArr.join('_',attrArr);
             attrid = attrid ? attrid : 1;
             var url = SITEURL+'cars/all-'+carkind+'-'+attrid;
             location.href = url;
         })
         $(document).mouseup(function(e){
             var _con = $('.cs-select-box');   // 设置目标区域
             if(!_con.is(e.target) && _con.has(e.target).length === 0){ // Mark 1
                 $('.cs-select-box').hide();
             }
         });
     })
 </script> </body> </html>
