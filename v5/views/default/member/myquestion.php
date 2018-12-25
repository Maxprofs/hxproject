<!doctype html>
<html>
<head>
<meta charset="utf-8">
    <title>{__('我的咨询')}-{$webname}</title>
    {include "pub/varname"}
    {Common::css('user.css,base.css,extend.css')}
    {Common::js('jquery.min.js,base.js,common.js,jquery.validate.js,jquery.cookie.js')}

</head>

<body>

  {request "pub/header"}
  <div class="big">
  	<div class="wm-1200">
    
      <div class="st-guide">
            <a href="{$cmsurl}">{__('首页')}</a>&nbsp;&nbsp;&gt;&nbsp;&nbsp;{__('我的咨询')}
      </div><!--面包屑-->
      
      <div class="st-main-page">

          {include "member/left_menu"}
        
        <div class="user-order-box">
          <div class="tabnav">
            <span class="on">{__('我的咨询')}</span>
          </div>
          <div class="tabcon">
            {if !empty($list)}
              <div class="zixun-list-con">
                  <ul>
                      {loop $list $row}
                      <li>
                          <div class="name">{Common::mydate('Y-m-d',$row['addtime'])}&nbsp;&nbsp;咨询产品<a href="{$row['producturl']}" target="_blank">{$row['productname']}</a></div>
                          <div class="wt">
                              <span class="hd">咨询：</span>
                              <div class="bd">{$row['content']}</div>
                          </div>
                          <div class="txt">
                              <span class="hd">回复：</span>
                              <div class="bd">{if !empty($row['replycontent'])}{$row['replycontent']}{else}暂未回复{/if}</div>
                          </div>
                          {if !empty($row['replytime'])}
                          <div class="date">{Common::mydate('Y-m-d H:i:s',$row['replytime'])}</div>
                          {/if}
                      </li>
                      {/loop}
                  </ul>
              </div>
            <div class="main_mod_page clear">
             {$pageinfo}
            </div><!--翻页-->
          </div>
          {else}
            <div class="zx-no-have"><span></span><p>{__('还没有咨询，有疑问？')}<a href="/questions/" target="_blank">{__('去提一个')}</a></p></div>
          {/if}
        </div><!--我的咨询-->
        
      </div>
    
    </div>
  </div>

  {request "pub/footer"}
  <script>
      $(function(){
          $('#nav_myquestion').addClass('on');
      })
  </script>

</body>
</html>
