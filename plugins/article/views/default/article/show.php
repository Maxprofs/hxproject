<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head margin_head=i1zCXC >
<meta charset="utf-8">
    <title>{$seoinfo['seotitle']}-{$GLOBALS['cfg_webname']}</title>
    {if $seoinfo['keyword']}
    <meta name="keywords" content="{$seoinfo['keyword']}" />
    {/if}
    {if $seoinfo['description']}
    <meta name="description" content="{$seoinfo['description']}" />
    {/if}
    {include "pub/varname"}
    {Common::css_plugin('gonglue.css','article')}
    {Common::css('gonglue.css,base.css,extend.css')}
    {Common::js('jquery.min.js,base.js,common.js,delayLoading.min.js')}
</head>

<body>

{request "pub/header"}



  <div class="big">
  	<div class="wm-1200">

        <div class="st-guide">
            {st:position action="show_crumbs" typeid="$typeid" info="$info"}
        </div><!--面包屑-->

      <div class="st-main-page">

		<div class="st-glcon-show">

          <div class="glcon-advimg">
              {st:ad action="getad" name="s_article_show_1" pc="1" return="ad"}
              {if !empty($ad)}
                <a href="{$ad['adlink']}"><img src="{Common::img($ad['adsrc'])}" alt="{$ad['adsrc']}" /></a>
              {/if}
          </div><!-- 广告 {$taglib}-->

            {if St_Functions::is_normal_app_install('product_seeding')}
            {php}
            $seeding = Model_Product_Seeding::get_info(1);
            $seeding_status = $seeding['status'];
            $seeding_location = $seeding['location'];
            $seeding_typeid = $seeding['typeid'];
            $seeding_kind = $seeding['kind'];
            {/php}
            {if $seeding_status}
            {if $seeding_location==1}
            {if $seeding_typeid>0}
            {php}
            $seeding_model = Model_Model::get_module_info($seeding_typeid);
            if ($seeding_model['id'] > 200 && $seeding_model['maintable'] == 'model_archive')
            {
                $taglib = 'tongyong';
            }
            else
            {
                $taglib = $seeding_model['pinyin'];
            }

            if($seeding_kind == 1)
            {
                $seeding_flag = 'order';
            }
            else
            {
                $seeding_flag = 'tagrelative';
            }
            {/php}
            <!-- 广告zhangycx {$tagword}-->
            {if $taglib == 'line'}
            {st:line action="query" flag="$seeding_flag" tagword="$tagword" row="2" return="recommends"}
            {elseif $taglib == 'hotel'}
            {st:hotel action="query" flag="$seeding_flag" tagword="$tagword" row="2" return="recommends"}
            {elseif $taglib == 'outdoor'}
            {st:outdoor action="query" flag="$seeding_flag" tagword="$tagword" row="2" return="recommends"}
            {elseif $taglib == 'car'}
            {st:car action="query" flag="$seeding_flag" tagword="$tagword" row="2" return="recommends"}
            {elseif $taglib == 'spot'}
            {st:spot action="query" flag="$seeding_flag" tagword="$tagword" row="2" return="recommends"}
            {elseif $taglib == 'visa'}
            {st:visa action="query" flag="$seeding_flag" tagword="$tagword" row="2" return="recommends"}
            {elseif $taglib == 'tuan'}
            {st:tuan action="query" flag="$seeding_flag" tagword="$tagword" row="2" return="recommends"}
            {elseif $taglib == 'ship_line'}
            {st:ship action="query" flag="$seeding_flag" tagword="$tagword" row="2" return="recommends"}
            {elseif $taglib == 'tongyong'}
            {st:tongyong action="query" flag="$seeding_flag" tagword="$tagword" typeid="$seeding_typeid" row="2" return="recommends"}
            {/if}
            {if $recommends}
            <div class="recommend-show">
			<div class="recommend-tit">今日推荐2</div>
			<ul class="clearfix">
                {loop $recommends $rec}
				<li class="clearfix{if $n==2} mr-0{/if}">
					<div class="pic">
                        <a href="{$rec['url']}">
                            <img src="{Product::get_lazy_img()}" st-src="{Common::img($rec['litpic'],146,98)}" alt="{$rec['title']}" title="{$rec['title']}" />
                        </a>
                    </div>
					<div class="info clearfix">
						<p class="attr clearfix">
                            {if $rec['price']}
							<span class="price">{Currency_Tool::symbol()}<b>{$rec['price']}</b>起</span>
                            {else}
                            <span class="price"><b>电询</b></span>
                            {/if}
							<span class="myd">满意度：<em>{php echo rtrim($rec['satisfyscore'], '%') . '%';}</em></span>
						</p>
						<a class="bt" href="{$rec['url']}">{$rec['title']}</a>
					</div>
				</li>
                {/loop}
			</ul>
		</div>
            <!--今日推荐-->
            {/if}
            {/if}
            {/if}
            {/if}
            {/if}

          <div class="st-gl-article-box">
          	<div class="article-con">
            	<div class="article-tit">
                <h1>{$info['title']}</h1>
                <div class="adta">
                  <span class="date">更新时间：{Common::mydate('Y-m-d',$info['modtime'])}</span>
                  <span class="name">小编：{$info['author']}</span>
                  <span class="pl">{$info['commentnum']}</span>
                  <span class="look">{$info['shownum']}</span>
                </div>
              </div>
                {if !empty($info['summary'])}
                <div class="article-summary">{$info['summary']}</div>
                {/if}
              <div class="gl-contxt">
                  {Common::content_image_width($info['content'],833,0)}
              {if !empty($info['comefrom'])||!empty($info['fromsite'])}
              <p class="fr">文章来源:&nbsp;&nbsp;{$info['comefrom']}&nbsp;{$info['fromsite']}</p>
              {/if}
              </div>
              <div class="bdsharebuttonbox">
              	<a href="#" class="bds_more" data-cmd="more"></a>
                <a href="#" class="bds_qzone" data-cmd="qzone"></a>
                <a href="#" class="bds_tsina" data-cmd="tsina"></a>
                <a href="#" class="bds_tqq" data-cmd="tqq"></a>
                <a href="#" class="bds_renren" data-cmd="renren"></a>
                <a href="#" class="bds_weixin" data-cmd="weixin"></a>
              </div>
							<script>
								window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdPic":"","bdStyle":"0","bdSize":"16"},"share":{},"image":{"viewList":["qzone","tsina","tqq","renren","weixin"],"viewText":"分享到：","viewSize":"16"},"selectShare":{"bdContainerClass":null,"bdSelectMiniList":["qzone","tsina","tqq","renren","weixin"]}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='/res/js/bdshare/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];
							</script>
              <div class="article-list">
                  {if !empty($info['prev']['title'])}
                  <a class="prev" href="{$info['prev']['url']}">上一篇：{$info['prev']['title']}</a>
                  {else}
                  <a class="prev" href="javascript:;">上一篇：没有了</a>
                  {/if}
                  {if !empty($info['next']['title'])}
                  <a class="next" href="{$info['next']['url']}">下一篇：{$info['next']['title']}</a>
                  {else}
                  <a class="next" href="javascript:;">下一篇：没有了</a>
                  {/if}
              </div>
            </div>
          </div><!-- 攻略文章 -->

            {if St_Functions::is_normal_app_install('product_seeding')}
            {php}
            $seeding = Model_Product_Seeding::get_info(1);
            $seeding_status = $seeding['status'];
            $seeding_location = $seeding['location'];
            $seeding_typeid = $seeding['typeid'];
            $seeding_kind = $seeding['kind'];
            {/php}
            {if $seeding_status}
            {if $seeding_location==2}
            {if $seeding_typeid>0}
            {php}
            $seeding_model = Model_Model::get_module_info($seeding_typeid);
            if ($seeding_model['id'] > 200 && $seeding_model['maintable'] == 'model_archive')
            {
            $taglib = 'tongyong';
            }
            else
            {
            $taglib = $seeding_model['pinyin'];
            }

            if($seeding_kind == 1)
            {
            $seeding_flag = 'order';
            }
            else
            {
            $seeding_flag = 'tagrelative';
            }
            {/php}
            {if $taglib == 'line'}
            {st:line action="query" flag="$seeding_flag" tagword="$tagword" row="2" return="recommends"}
            {elseif $taglib == 'outdoor'}
            {st:outdoor action="query" flag="$seeding_flag" tagword="$tagword" row="2" return="recommends"}
            {elseif $taglib == 'hotel'}
            {st:hotel action="query" flag="$seeding_flag" tagword="$tagword" row="2" return="recommends"}
            {elseif $taglib == 'car'}
            {st:car action="query" flag="$seeding_flag" tagword="$tagword" row="2" return="recommends"}
            {elseif $taglib == 'spot'}
            {st:spot action="query" flag="$seeding_flag" tagword="$tagword" row="2" return="recommends"}
            {elseif $taglib == 'visa'}
            {st:visa action="query" flag="$seeding_flag" tagword="$tagword" row="2" return="recommends"}
            {elseif $taglib == 'tuan'}
            {st:tuan action="query" flag="$seeding_flag" tagword="$tagword" row="2" return="recommends"}
            {elseif $taglib == 'ship_line'}
            {st:ship action="query" flag="$seeding_flag" tagword="$tagword" row="2" return="recommends"}
            {elseif $taglib == 'tongyong'}
            {st:tongyong action="query" flag="$seeding_flag" tagword="$tagword" typeid="$seeding_typeid" row="2" return="recommends"}
            {/if}
            {if $recommends}
          <div class="recommend-box">
				<h3>今日推荐</h3>
				<ul class="clearfix">
                    {loop $recommends $rec}
					<li class="clearfix{if $n==2} mr-0{/if}">
						<a class="pic" href="{$rec['url']}">
                            <img src="{Product::get_lazy_img()}" st-src="{Common::img($rec['litpic'],134,90)}" alt="{$rec['title']}" title="{$rec['title']}" />
                        </a>
						<div class="info clearfix">
							<p class="attr clearfix">
                                {if $rec['price']}
                                <span class="price">{Currency_Tool::symbol()}<b>{$rec['price']}</b>起</span>
                                {else}
                                <span class="price"><b>电询</b></span>
                                {/if}
                                <span class="myd">满意度：<em>{php echo rtrim($rec['satisfyscore'], '%') . '%';}</em></span>
							</p>
							<a class="bt" href="{$rec['url']}">{$rec['title']}</a>
						</div>
					</li>
                    {/loop}
				</ul>
			</div>
			<!--今日推荐-->
            {/if}
            {/if}
            {/if}
            {/if}
            {/if}

          {if !empty($info['finaldestid'])}
          <div class="xg-read-box">
          	<h3>相关阅读</h3>
            <div class="conlist">
              <ul>
                {st:article action="query" flag="relative" row="4" destid="$info['finaldestid']" return="arc"}
                    {loop $arc $a}
                        <li>
                            <a href="{$a['url']}" target="_blank">
                            <p class="pic"><img src="{Common::img($a['litpic'],200,140)}" alt="{$a['title']}" /></p>
                            <p class="bt">{$a['title']}</p>
                            </a>
                        </li>
                    {/loop}

              </ul>
            </div>
          </div><!-- 相关阅读 -->
          {/if}


          <div class="gl-user-comment-box">
          	<ul id="article_content">
               {st:article action="comment" typeid="4" articleid="$info['id']" row="5" return="comment"}
                    {loop $comment['data'] $c}
                        <li>
                            <div class="user-name"><img src="{$c['litpic']}" /><span>{$c['nickname']}</span></div>
                            <div class="user-con">
                                {if !empty($c['dockid'])}
                                <div class="quote-item">
                                    <p class="tit">引用 {$c['reply']['nickname']} 发表于 {$c['reply']['addtime']} 的回复：</p>
                                    <p class="txt">{$c['reply']['content']}</p>
                                </div>
                                {/if}
                                <div class="contxt">
                                <p class="nr">{$c['content']}</p>
                                <p class="cz"><span>{$c['addtime']}</span><a class="reply_btn cursor" data-replyid="{$c['id']}" data-nickname="{$c['nickname']}">回复</a></p>
                              </div>
                            </div>
                        </li>
                    {/loop}
                {/st}
            </ul>
              {if $comment['page']}
              <div class="main_mod_page clear" id="article_page" data="{articleid:'{$info['id']}'}">
                  {$comment['page']}
              </div>
              {Common::js('template.js')}
              <script id="article_content_template" type="text/html">
                  {{each data as $v}}
                  <li>
                      <div class="user-name"><img src="{{$v['member']['litpic']}}" /><span>{{$v['member']['nickname']}}</span></div>
                      <div class="user-con">
                          {{if $v['dockid'] && $v['reply'] }}
                          <div class="quote-item">
                              <p class="tit">引用 {{$v['reply']['nickname']}} 发表于 {{$v['reply']['addtime']}} 的回复：</p>
                              <p class="txt">{{$v['reply']['content']}}</p>
                          </div>
                          {{/if}}
                          <div class="contxt">
                              <p class="nr">{{$v['content']}}</p>
                              <p class="cz"><span>{{$v['addtime']}}</span><a class="reply_btn cursor" data-replyid="{{$v['id']}}" data-nickname="{{$v['member']['nickname']}}">回复</a></p>
                          </div>
                      </div>
                  </li>
                  {{/each}}
              </script>
              <script>
                  $(function(){
                      $('#article_page').find('a').live('click',function(){
                          $('#article_content').html('<img src="/res/images/loading.gif" style="display:block;width:28px;height:28px;margin:160px auto 157px auto;">');
                          var url=$(this).attr('data');
                          var data=eval("("+$('#article_page').attr('data')+")");
                          $.get(url,data,function(list){
                              $('#article_content').html(template('article_content_template', list));
                              $('#article_page').html(list['page']);
                          },'json')
                          return false;
                      });
                  })
              </script>
              <!-- 翻页 -->
              {/if}
            <div class="publish-comment-box" id="replybox">
            	<h3>发表评论</h3>
              <div class="comment-con"><textarea name="" id="content" cols="" rows=""></textarea></div>
              <div class="comment-msg">
                <a class="tj-btn" href="javascript:;">提交</a>
              	<span class="yzm">验证码：<img src="{$cmsurl}captcha" onClick="this.src=this.src+'?math='+ Math.random()" width="80" height="30" /><input type="text" id="checkcode" class="w105" /></span>
                 <span id="m_info">

                 </span>


              </div>
            </div>
          </div><!-- 用户评论 -->

        </div><!-- 攻略主体详情 -->

        <div class="st-sidebox">
            {st:right action="get" typeid="$typeid" data="$templetdata" pagename="show"}
        </div>

        <input type="hidden" id="dockid" value="0"/>
        <input type="hidden" id="articleid" value="{$info['id']}"/>

      </div>

    </div>
  </div>

{request "pub/footer"}
{Common::js('layer/layer.js',0)}
<script>
    $(function(){
        //回复
        $(".reply_btn").live('click',function(){
            $('#content').attr('placeholder','回复 '+$(this).attr('data-nickname'));
            $("#dockid").val($(this).attr('data-replyid'));
        });
        //提交问答
        $(".tj-btn").click(function(){
            var articleid = $("#articleid").val();
            var dockid = $("#dockid").val();
            var checkcode = $("#checkcode").val();
            var typeid = 4;
            var nickname = $("#nickname").val();
            var content = $("#content").val();

            if(content.length<5){
                layer.msg('评论不得少于5个字', {
                    icon: 5
                });
                return false;
            }
            if(checkcode==''){
                layer.msg('{__("checkcode_empty")}', {
                    icon: 5
                });
                return false;
            }
            $.ajax({
                type:'POST',
                url:SITEURL+'article/ajax_add_comment',
                data:{
                    articleid:articleid,
                    content:content,
                    checkcode:checkcode,
                    nickname:nickname,
                    typeid:typeid,
                    dockid:dockid
                },
                success:function(data){
                    if(data==1){
                        layer.msg('{__("checkcode_error")}', {
                            icon: 5
                        });
                        //重新加载验证码
                        $("#imgcheckcode").attr('src',"{$cmsurl}captcha?"+Math.random());
                        //清除回复ID
                        $("#dockid").val()
                    }else if(data==3){
                        layer.msg('{__("reply_success")}',{
                            icon:6,
                            time:1500
                        });
                        location.reload();
                    }else{
                        layer.msg('{__("reply_failure")}', {
                            icon: 5
                        })
                    }
                }
            })
        });
        //登陆状态
        //登陆检测
        var logintime=ST.Storage.getItem('st_user_logintime');
        var md5=ST.Storage.getItem('st_secret');
        var localData;
        if(md5)
        {
            localData={data:md5,logintime:logintime};
        }
        $.ajax({
            type:"POST",
            url:SITEURL+"member/login/ajax_is_login",
            dataType:'json',
            data:localData,
            success:function(data){
                if(data.status){
                    $txt = '';
                }else{
                    $txt = '<a class="dl-btn" href="/member/login">登录</a>';
                }
                $("#m_info").html($txt);
            }
        })
    })
</script>

</body>
</html>
