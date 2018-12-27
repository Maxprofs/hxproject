<?php defined('SYSPATH') or die();?> <!doctype html> <html> <head script_div=yZzCXC > <meta charset="utf-8"> <title><?php echo $seoinfo['seotitle'];?>-<?php echo $GLOBALS['cfg_webname'];?></title> <?php if($seoinfo['keyword']) { ?> <meta name="keywords" content="<?php echo $seoinfo['keyword'];?>" /> <?php } ?> <?php if($seoinfo['description']) { ?> <meta name="description" content="<?php echo $seoinfo['description'];?>" /> <?php } ?> <?php echo  Stourweb_View::template("pub/varname");  ?> <?php echo Common::css_plugin('visa.css','visa');?> <?php echo Common::css('base.css,extend.css',false);?> <?php echo Common::js('jquery.min.js,base.js,common.js,SuperSlide.min.js,template.js,delayLoading.min.js');?> </head> <body> <?php echo Request::factory("pub/header")->execute()->body(); ?> <div class="visa_bg_box"> <div class="country_sar"> <div class="import"> <input type="text" class="sr_text search_country" placeholder="请输入国家拼音/名称" /> <input type="button" class="tj_btn gocountry" value="" /> </div> <div class="public"> <?php $visa_tag = new Taglib_Visa();if (method_exists($visa_tag, 'area')) {$arealist = $visa_tag->area(array('action'=>'area','flag'=>'order','row'=>'5','return'=>'arealist',));}?> <?php $n=1; if(is_array($arealist)) { foreach($arealist as $k => $area) { ?> <a href="<?php echo $area['url'];?>" target="_blank"><?php echo $area['title'];?></a> <?php $n++;}unset($n); } ?> </div> </div> </div><!--签证搜索--> <div class="big"> <div class="wm-1200"> <div class="st-main-page"> <?php echo Common::js('layer/layer.js');?> <script>
                $(function(){
                    $('.search_country').Result({url:SITEURL+'visa/ajax_nation'});
                    //按目的地搜索
                    $(".gocountry").click(function(){
                        var countryname = $(".search_country").val();
                        if(countryname==''){
                            layer.open({
                                content: '<?php echo __("no_country_keyword");?>',
                                btn: ['<?php echo __("OK");?>']
                            });
                            $(".gocountry").focus();
                            return false;
                        }
                        var pinyin = get_nation_pinyin(countryname);
                        if(pinyin!='')
                        {
                            var url = SITEURL+'visa/'+pinyin+'/';
                            window.open(url,'_self');
                        }
                        else{
                            layer.open({
                                content: '<?php echo __("country_no_visa");?>',
                                btn: ['<?php echo __("OK");?>']
                            });
                            $(".gocountry").focus();
                        }
                    })
                })
                /*
                 * 根据国家读取拼音
                 * */
                function get_nation_pinyin(country)
                {
                    var pinyin = '';
                    $.ajax({
                        type:'POST',
                        url:SITEURL+'visa/ajax_nation_pinyin',
                        data:{areaname:country},
                        dataType:'json',
                        async:false,
                        success:function(data){
                            if(data.pinyin){
                                pinyin = data.pinyin;
                            }
                        }
                    })
                    return pinyin;
                }
            </script> <div class="visa-hot-country"> <div class="hot-country-tit">热门签证国家</div> <div class="hot-country-block"> <ul> <?php $visa_tag = new Taglib_Visa();if (method_exists($visa_tag, 'area')) {$arealist = $visa_tag->area(array('action'=>'area','flag'=>'hot','minprice'=>'true','row'=>'8','return'=>'arealist',));}?> <?php $n=1; if(is_array($arealist)) { foreach($arealist as $k => $area) { ?> <li <?php if(($k+1)%4==0 ) { ?>class="mr_0"<?php } ?>
> <a href="<?php echo $area['url'];?>"> <div class="pic"> <div class="layer"> <span class="hy"><?php echo $area['title'];?></span> <span class="eg"><?php echo $area['english'];?></span> </div> <img src="<?php echo Product::get_lazy_img();?>" st-src="<?php echo Common::img($area['litpic'],282,192);?>" alt="<?php echo $area['title'];?>" /> </div> <div class="txt"> <span class="gj"><?php echo $area['title'];?></span> <?php if($area['price']) { ?> <span class="jg"><b><?php echo Currency_Tool::symbol();?><?php echo $area['price'];?></b>起</span> <?php } ?> </div> </a> </li> <?php $n++;}unset($n); } ?> </ul> </div> </div><!--签证国家--> <div class="hot-visa-box"> <div class="visa-bt"><h3>热门签证</h3></div> <div class="visa-list-box"> <ul class="st-visa-list"> <?php $visa_tag = new Taglib_Visa();if (method_exists($visa_tag, 'query')) {$visalist = $visa_tag->query(array('action'=>'query','flag'=>'order','row'=>'10','return'=>'visalist',));}?> <?php $n=1; if(is_array($visalist)) { foreach($visalist as $v) { ?> <li <?php if($n%5==0) { ?>class="mr_0"<?php } ?>
> <a class="fl" href="<?php echo $v['url'];?>" target="_blank"> <div class="country"><em><img src="<?php echo Product::get_lazy_img();?>" st-src="<?php echo Common::img($v['litpic'],140,95);?>" alt="<?php echo $v['title'];?>"/></em></div> <span class="tit"><?php echo $v['title'];?></span> </a> <p class="num"> <del> <?php if(!empty($v['sellprice'])) { ?>
                                    原价：<i class="currency_sy"><?php echo Currency_Tool::symbol();?></i><?php echo $v['sellprice'];?> <?php } ?> </del> <span> <?php if($v['price']) { ?> <b><i class="currency_sy"><?php echo Currency_Tool::symbol();?></i><?php echo $v['price'];?></b> <?php } else { ?>
                             电询
                          <?php } ?> </span> </p> </li> <?php $n++;}unset($n); } ?> </ul> </div> </div><!--热门签证--> <div class="visa-tabbox-country"> <div class="st-tabnav"> <strong>全部签证国家</strong> <?php $visa_tag = new Taglib_Visa();if (method_exists($visa_tag, 'area')) {$arealist = $visa_tag->area(array('action'=>'area','flag'=>'query','pid'=>'0','row'=>'10','return'=>'arealist',));}?> <?php $n=1; if(is_array($arealist)) { foreach($arealist as $area) { ?> <span <?php if($n==1) { ?> class="on"<?php } ?>
 data-id="<?php echo $area['id'];?>"><?php echo $area['title'];?></span> <?php $n++;}unset($n); } ?> </div> <div class="st-tabcon"> <ul> <?php $visa_tag = new Taglib_Visa();if (method_exists($visa_tag, 'area')) {$childarea = $visa_tag->area(array('action'=>'area','flag'=>'query','pid'=>$arealist[0]['id'],'row'=>'60','return'=>'childarea',));}?> <?php $n=1; if(is_array($childarea)) { foreach($childarea as $a) { ?> <li><a href="<?php echo $a['url'];?>" target="_blank"><?php echo $a['title'];?></a></li> <?php $n++;}unset($n); } ?> </ul> </div> </div><!--全部签证国家--> <!--栏目介绍--> <?php if(!empty($seoinfo['jieshao'])) { ?> <div class="st-comm-introduce"> <div class="st-comm-introduce-txt"> <?php echo $seoinfo['jieshao'];?> </div> </div> <?php } ?> <div class="visa_flow_path"> <div class="tit"> <h3>签证办理，快人一步</h3> <p>省时 · 省事 · 省心 · 省力</p> </div> <ul> <li> <img src="<?php echo $GLOBALS['cfg_public_url'];?>images/visa_bz01.png" alt="提交订单" /> <p class="num1"> <strong>提交订单</strong> <span>Submit orders</span> </p> </li> <li class="visa-arrow-right"></li> <li> <img src="<?php echo $GLOBALS['cfg_public_url'];?>images/visa_bz02.png" alt="提交订单" /> <p class="num2"> <strong>提交签证材料</strong> <span>Submit Visa materials</span> </p> </li> <li class="visa-arrow-right"></li> <li> <img src="<?php echo $GLOBALS['cfg_public_url'];?>images/visa_bz03.png" alt="提交订单" /> <p class="num3"> <strong>审核材料</strong> <span>Audit  material</span> </p> </li> <li class="visa-arrow-right"></li> <li> <img src="<?php echo $GLOBALS['cfg_public_url'];?>images/visa_bz04.png" alt="提交订单" /> <p class="num4"> <strong>送签（面试）</strong> <span>Interview </span> </p> </li> <li class="visa-arrow-right"></li> <li> <img src="<?php echo $GLOBALS['cfg_public_url'];?>images/visa_bz05.png" alt="提交订单" /> <p class="num5"> <strong>成功出签</strong> <span>Success</span> </p> </li> </ul> </div><!--签证流程--> <div class="visa_atc"> <?php require_once ("E:/wamp64/www/taglib/attr.php");$attr_tag = new Taglib_Attr();if (method_exists($attr_tag, 'query')) {$att = $attr_tag->query(array('action'=>'query','flag'=>'childitem','row'=>'4','typeid'=>'4','groupid'=>'6','return'=>'att',));}?> <?php $index=0;?> <?php $n=1; if(is_array($att)) { foreach($att as $at) { ?> <div class="article_list <?php if($index%4==0) { ?>mr_0<?php } ?>
"> <h3><?php echo $at['title'];?></h3> <ul> <?php $article_tag = new Taglib_Article();if (method_exists($article_tag, 'query')) {$data = $article_tag->query(array('action'=>'query','flag'=>'byattrid','attrid'=>$at['id'],'row'=>'4',));}?> <?php $n=1; if(is_array($data)) { foreach($data as $v) { ?> <li><a href="<?php echo $v['url'];?>" target="_blank"><?php echo $v['title'];?></a></li> <?php $n++;}unset($n); } ?> </ul> </div> <?php $index++?> <?php $n++;}unset($n); } ?> </div><!--签证文章--> </div> </div> </div> <?php echo Request::factory("pub/footer")->execute()->body(); ?> <?php echo Request::factory("pub/flink")->execute()->body(); ?> <?php echo Common::js('result/result.js');?> <link type="text/css" href="/res/js/result/result.css" rel="stylesheet" /> <script type="text/html" id="tpl_area"> <ul>
        {{each list as value i}}
        <li><a href="{{value.url}}" target="_blank">{{value.title}}</a></li>
        {{/each}}
    </ul> </script> <script>
    $(function(){
        //区域切换
        $('.st-tabnav').find('span').click(function(){
            var destid = $(this).attr('data-id');
            var url = SITEURL+'visa/ajax_index_area';
            var concontain = $('.st-tabcon');
            var content = concontain.data(destid);
            $(this).addClass('on').siblings().removeClass('on');
            concontain.html('<img src="/res/images/loading.gif" style="display:block;width:28px;height:28px;margin:160px auto 157px auto;">');
            if(content!=undefined){
                concontain.html(content);
            }else{
                $.getJSON(url, {areaid:destid,pagesize:60}, function(data) {
                    var licontent = template('tpl_area',data);
                    concontain.html(licontent);
                    concontain.data(destid,licontent);
                });
            }
        })
        //搜索国家
        $('.destname').Result({url:SITEURL+'destination/ajax_dest_by_pinyin',extraParams:{typeid:2}});
    })
</script> </body> </html>
