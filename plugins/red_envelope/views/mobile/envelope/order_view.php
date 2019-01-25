<?php defined('SYSPATH') or die('No direct script access.');?>
{Common::css_plugin('redenvelope.css','red_envelope')}
<div class="red-envelope-box">
    <i class="close-icon" id="redEnvelopeCloseEntry"></i>
    <div class="red-envelope-entry">
        <span class="num">{$info['view_total']}</span>
    </div>
</div>
<!-- 红包入口 -->
<div class="layer-share-wrap">
    <div class="black-bg"></div>
    <div class="share-layer">
        <h3>邀请好友</h3>
        <div class="wechat-box">
            <p class="tit">微信分享</p>
            <p class="msg">请在微信浏览器内点击微信右上角<img src="{$GLOBALS['cfg_plugin_red_envelope_public_full_url']}/mobile/images/wechat-operate-icon.png">按钮，通过【发送给朋友】、【分享到朋友圈】进行分享。</p>
        </div>
        <div class="other-box clearfix">
            <ul class="hd clearfix">
                <li>
                    <a class="item" href="javascript:;" id="shareCopyLink">
                        <i class="icon copy-icon"></i>
                        <span class="name">复制链接</span>
                    </a>
                </li>
                <li>
                    <a class="item" href="javascript:;" id="shareFaceToFace">
                        <i class="icon face-icon"></i>
                        <span class="name">当面扫码</span>
                    </a>
                </li>
                <li>
                    <a class="item" href="http://v.t.sina.com.cn/share/share.php?url={urlencode($url)}&title={$info['title']}">
                        <i class="icon sina-icon"></i>
                        <span class="name">新浪微博</span>
                    </a>
                </li>
            </ul>
            <div class="bd">
                <div class="tabs-con copy-words">
                                <textarea class="copy-area" name="">长按文字 复制链接
        {$url}</textarea>
                </div>
                <div class="tabs-con read-code">
                    <div class="code-img">
                        <span class="pic"><img src="//{$GLOBALS['main_host']}/res/vendor/qrcode/make.php?param={$url}"></span>
                        <p>─ 长按识别二维码 ─</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{include '../mobile/envelope/pub/envelope_share'}
<script>
    var SITEURL = "{URL::site()}";
    $(function () {

        //分享弹窗
        $(".red-envelope-entry").click(function(){
            $(".layer-share-wrap").show();
        });
        $(".black-bg").click(function(){
            $(".layer-share-wrap").hide();
        });
        $("#shareCopyLink").click(function(){
            $(".copy-words").show();
            $(".read-code").hide();
        });
        $("#shareFaceToFace").click(function(){
            $(".copy-words").hide();
            $(".read-code").show();
        });

        $("#redEnvelopeCloseEntry").on("click",function(){
            $(this).parents(".red-envelope-box").hide()
        })

    })


</script>

