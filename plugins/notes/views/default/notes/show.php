<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>{$info['title']}-{$webname}</title>
    {include "pub/varname"}
    {Common::css_plugin('youji.css','notes')}
    {Common::css('base.css,extend.css')}
    {Common::js('jquery.min.js,base.js,common.js,delayLoading.min.js')}
</head>

<body>

{request "pub/header"}


  <div class="fb_top_bg" style="background:url({Common::img($info['bannerpic'],1920,420)}) center no-repeat;background-size: cover;">
  	<div class="show_tit"><strong>{$info['title']}</strong></div>
  </div>

  <div class="big msg_shadow">
  	<div class="show_msg">
    	<img src="{$author['litpic']}" alt="{$author['nickname']}" width="130" height="130" />
    	<span class="name">{$author['nickname']}</span>
    	<span class="date">{Common::mydate('Y-m-d H:i',$info['modtime'])}</span>
    	<span class="num">{$info['shownum']}人已阅</span>
        <span class="tag">
            {if $info['destinations']}
            <i class="ico"></i>
                {loop $info['destinations'] $dest}
                <a href="/{$dest['pinyin']}/" target="_blank">{$dest['kindname']}</a>
                {/loop}
            {/if}
        </span>

      <div class="bdsharebuttonbox fr">
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
    </div>
  </div>

	<div class="big">
  	<div class="wm-1200">
        <div class="show-content">
            {if St_Functions::is_normal_app_install('product_seeding')}
            {php}
            $seeding = Model_Product_Seeding::get_info(3);
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
            $seeding_flag = 'order';
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
        	<div class="recommend-show mb-15">
				<div class="recommend-tit">今日推荐</div>
				<ul class="clearfix">
					{loop $recommends $rec}
					<li class="clearfix{if $n==2} mr-0{/if}">
						<div class="pic">
                            <a href="{$rec['url']}">
                                <img src="{Product::get_lazy_img()}" st-src="{Common::img($rec['litpic'],134,90)}" alt="{$rec['title']}" title="{$rec['title']}" />
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
            <div class="show_txt_con">
            {if $info['description']}
            <div class="show_js">
                <span class="qm"></span>
                <span class="hm"></span>
                {$info['description']}
            </div>
            {/if}
            <div class="show_nr">
                {Common::content_image_width($info['content'],833,0)}
            </div>
          </div>
            {if St_Functions::is_normal_app_install('product_seeding')}
            {php}
            $seeding = Model_Product_Seeding::get_info(3);
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
            $seeding_flag = 'order';
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
                        <div class="pic">
                            <a href="{$rec['url']}">
                                <img src="{Product::get_lazy_img()}" st-src="{Common::img($rec['litpic'],134,90)}" alt="{$rec['title']}" title="{$rec['title']}" />
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
            <div class="yj-user-comment-box">
                <h3 class="xg-tit">相关评论</h3>
                <ul id="notes_content">
                {st:notes action="comment" typeid="101" articleid="$info['id']" row="5" return="comment"}
                    {loop $comment['data'] $c}
                        <li>
                            <div class="user-name"><img src="{$c['member']['litpic']}" /><span>{$c['member']['nickname']}</span></div>
                            <div class="user-con">
                                {if !empty($c['dockid'])}
                                <div class="quote-item">
                                    <p class="tit">引用 {$c['reply']['nickname']} 发表于 {$c['reply']['addtime']} 的回复：</p>
                                    <p class="txt">{$c['reply']['content']}</p>
                                </div>
                                {/if}
                                <div class="contxt">
                                    <p class="nr">{$c['content']}</p>
                                    <p class="cz"><span>{$c['addtime']}</span><a class="reply_btn cursor" data-replyid="{$c['id']}" data-nickname="{$c['member']['nickname']}">回复</a></p>
                                </div>
                            </div>
                        </li>
                    {/loop}
                {/st}
                </ul>
                {if $comment['page']}
                <div class="main_mod_page clear" id="notes_page" data="{articleid:'{$info['id']}'}">
                    {$comment['page']}
                </div>
                {Common::js('template.js')}
                <script id="notes_content_template" type="text/html">
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
                        $('#notes_page').find('a').live('click',function(){
                            $('#notes_content').html('<img src="/res/images/loading.gif" style="display:block;width:28px;height:28px;margin:160px auto 157px auto;">');
                            var url=$(this).attr('data');
                            var data=eval("("+$('#notes_page').attr('data')+")");
                            $.get(url,data,function(list){
                                $('#notes_content').html(template('notes_content_template', list));
                                $('#notes_page').html(list['page']);
                            },'json')
                            return false;
                        });
                    })
                </script>
                <!-- 翻页 -->
                {/if}
                <div class="publish-comment-box">
                    <h3>发表评论</h3>
                    <div class="comment-con"><textarea name="" id="content" cols="" rows=""></textarea></div>
                    <div class="comment-msg">
                        <a class="tj-btn" class="tj-btn" href="javascript:;">提交</a>
                        <span class="yzm">验证码：<img src="{$cmsurl}captcha" onClick="this.src=this.src+'?math='+ Math.random()" height="30" /><input type="text" id="checkcode" class="w105" /></span>
                        <span id="m_info">

                        </span>
                        <span class="nc">昵称：<input id="nickname" type="text" class="w105" value="{if $member}{$member['nickname']}{/if}" /></span>
                        <input type="hidden" id="dockid" value="0"/>
                        <input type="hidden" id="articleid" value="{$info['id']}"/>
                    </div>
                </div>
            </div><!-- 用户评论 -->
        </div>
      <div class="st-sidebox">
          {st:right action="get" typeid="$typeid" data="$templetdata" pagename="show"}
      </div><!-- 右侧自定义内容 -->

    </div>
  </div>

{request "pub/footer"}
{Common::js('layer/layer.js',0)}
<script>
    // $(function(){
    //     var typeid = "{$typeid}";
    //     var productid = "{$info['id']}";
    //     $.getJSON(SITEURL+'pub/ajax_add_shownum',{typeid:typeid,productid:productid},function(){});
    // })
</script>
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
            var typeid = 101;
            var nickname = $("#nickname").val();
            var content = $("#content").val();

            if(content.length<5){
                layer.msg('评论不得不于5个字', {
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
                url:SITEURL+'notes/ajax_add_comment',
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
                        //重置回复
                        $("#dockid").val('');

                    }else if(data==3){
                        layer.msg('{__("notes_comment_waiting_confirm")}', {
                            icon: 6,
                            time: 1500
                        });
                        location.reload();
                    }else if(data==2){
                        layer.msg('{__("notes_comment_success")}', {
                            icon: 6,
                            time: 1500
                        });
                        location.reload();
                    } else{
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
                    $txt = '<a class="dl-btn" href="/member/login">登录</a>';
                }
                $("#m_info").html($txt);
            }

        })
    })
</script>
</body>
</html>
