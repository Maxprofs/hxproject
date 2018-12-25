<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
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
    {Common::css('base.css,extend.css')}
    {Common::js('jquery.min.js,base.js,common.js')}
</head>

<body>

{request "pub/header"}
  
  
  
  <div class="big">
  	<div class="wm-1200">

        <div class="st-guide">
            <a href="{$cmsurl}">{$GLOBALS['cfg_indexname']}</a>&gt;<a href="/raiders/">{$channelname}</a>&gt;
            {loop $predest $dest}
            <a href="/raiders/{$dest['pinyin']}/">{$dest['kindname']}{$channelname}</a>&gt;
            {/loop}
        </div><!--面包屑-->
      
      <div class="st-main-page">
      
		<div class="st-glcon-show">
        	
          <div class="glcon-advimg">
              {st:ad action="getad" name="s_article_show_1" pc="1" return="ad"}
              {if !empty($ad)}
                <a href="{$ad['adlink']}"><img class="fl" src="{Common::img($ad['adsrc'])}" alt="{$ad['adsrc']}" width="905" /></a>
              {/if}
          </div><!-- 广告 -->
          
          <div class="day-prefer">
          	<h3>今日优惠</h3>
            <div class="conlist">
            	<ul>
                {st:line action="query" flag="order" row="2"}
                 {php}$k=1;{/php}
                 {loop $data $info}
                    <li {if $k%2==0}class="mr_0"{/if}>

                        <div class="pic"><a href="{$info['url']}" target="_blank"><img src="{Common::img($info['litpic'],200,140)}" alt="{$info['title']}" /></a></div>
                        <div class="js">
                            <p class="tit"><a href="{$info['url']}" target="_blank">{$info['title']}</a></p>
                            <p class="attr">
                                {loop $info['iconlist'] $ico}
                                    <img src="{$ico['litpic']}" />
                                {/loop}
                            </p>
                            <p class="price">
                                {if !empty($info['sellprice'])}
                                    <em>原价：<del><i class="currency_sy">{Currency_Tool::symbol()}</i>{$info['sellprice']}</del></em>
                                {/if}
                                {if !empty($info['price'])}
                                <span><b><i class="currency_sy">{Currency_Tool::symbol()}</i>{$info['price']}</b>元</span>
                                {else}
                                <span>电询</span>
                                {/if}
                            </p>
                          </div>
                    </li>
                    {php}$k++;{/php}
                 {/loop}
                {/st}

              </ul>
            </div>
          </div><!-- 今日优惠 -->
          
          <div class="st-gl-article-box">
          	<div class="article-con">
            	<div class="article-tit">
                <h1>{$info['title']}</h1>
                <div class="adta">
                  <span class="date">更新时间：{Common::mydate('Y-m-d',$info['modtime'])}</span>
                  <span class="name">发布人：{$info['author']}</span>
                  <span class="pl">{$info['commentnum']}</span>
                  <span class="look">{$info['shownum']}</span>
                </div>
              </div>
              <div class="gl-contxt">
                {$info['content']}
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
                  <a class="next" href="javascript:;">上一篇：没有了</a>
                  {/if}

              </div>
            </div>
            {if !empty($info['finaldestid'])}
            <div class="xg-lines-box">
            	<h3>相关线路推荐</h3>
              <div class="conlist">
              	<ul>
                    {st:line action="query" flag="relative" row="4" destid="$info['finaldestid']" return="rlist"}
                    {loop $rlist $l}
                        <li>
                        <div class="pic"><a href="{$l['url']}" target="_blank"><img src="{Common::img($l['litpic'],100,68)}" alt="{$l['title']}" /></a></div>
                        <div class="nr">
                            <p class="bt"><a href="{$l['url']}" target="_blank">{$l['title']}</a></p>
                          <p class="attr">
                              {loop $l['iconlist'] $ico}
                                <img src="{$ico['litpic']}" />
                              {/loop}
                          </p>
                          <p class="data">
                              {if !empty($l['booknum'])}
                              <span>销量：{$l['booknum']}</span>
                              {/if}
                              {if !empty($l['satisfyscore'])}
                              <span>满意度：{$l['satisfyscore']}</span>
                              {/if}
                              {if !empty($l['recommendnum'])}
                              <span>推荐：{$l['recommendnum']}</span></p>
                              {/if}
                        </div>
                        <div class="price">

                            {if !empty($l['sellprice'])}
                            <em>原价：<del><i class="currency_sy">{Currency_Tool::symbol()}</i>{$l['sellprice']}</del></em>
                            {/if}
                            {if !empty($l['price'])}
                            <span><b><i class="currency_sy">{Currency_Tool::symbol()}</i>{$l['price']}</b>元</span>
                            {else}
                            <span>电询</span>
                            {/if}
                        </div>
                      </li>
                    {/loop}

                </ul>
              </div>
            </div><!-- 相关线路推荐 -->
           {/if}
          </div><!-- 攻略文章 -->
          {if !empty($info['finaldestid'])}
          <div class="xg-read-box">
          	<h3>相关阅读</h3>
            <div class="conlist">
              <ul>
                {st:article action="query" flag="relative" row="4" destid="$info['finaldestid']" return="arc"}
                    {loop $arc $a}
                        <li>
                            <a href="{$a['url']}" target="_blank"><img src="{Common::img($a['litpic'],200,140)}" alt="{$a['title']}" /><p>{$a['title']}</p></a>
                        </li>
                    {/loop}

              </ul>
            </div>
          </div><!-- 相关阅读 -->
          {/if}
          
          <div class="gl-user-comment-box">
          	<ul>
               {st:comment action="query" flag="raider" articleid="$info['id']" row="10" return="comment"}

                {loop $comment $c}
                    <li>
                        <div class="user-name"><img src="{$c['litpic']}" /><span>{$c['nickname']}</span></div>
                        <div class="user-con">
                            <div class="contxt">
                            {if !empty($c['dockid'])}
                                <p class="hf">回复<span>{$c['replyname']}</span></p>
                            {/if}
                            <p class="nr">{$c['content']}</p>
                            <p class="cz"><span>{Common::mydate('Y-m-d H:i:s',$c['addtime'])}</span><a class="reply_btn" href="#replybox" data-replyid="{$c['id']}">回复</a></p>
                          </div>
                        </div>
                    </li>
                {/loop}

            </ul>
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
        $(".reply_btn").click(function(){

            $("#dockid").val($(this).attr('data-replyid'));

        })

        //提交问答
        $(".tj-btn").click(function(){

            var articleid = $("#articleid").val();
            var dockid = $("#dockid").val();
            var checkcode = $("#checkcode").val();
            var typeid = 4;
            var nickname = $("#nickname").val();
            var content = $("#content").val();

            if(content.length<5){
                layer.msg('{__("reply_not_empty")}', {
                    icon: 5

                })
                return false;
            }
            if(checkcode==''){
                layer.msg('{__("checkcode_empty")}', {
                    icon: 5


                })
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


                        })
                        //重新加载验证码
                        $("#imgcheckcode").attr('src',"{$cmsurl}captcha?"+Math.random());

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


        })

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
                    $txt = '<a class="dl-btn" href="/member/login">登陆</a>';
                }
                $("#m_info").html($txt);
            }

        })
    })
</script>

</body>
</html>
