<?php defined('SYSPATH') or die(); ?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>写游记-{$webname}</title>
    {include "pub/varname"}
    {Common::css_plugin('youji.css','notes',false)}
    {Common::css('base.css,extend.css')}
    {Common::js('jquery.min.js,base.js,common.js,jquery.upload.js')}
</head>

<body>

{request "pub/header"}
<div class="big">
    <div class="wm-1200">

        <div class="top_yj_fb">
            <span>发表新游记</span>
            <!--<a href="#">发表游记</a>-->
        </div>

    </div>
</div>
<form id="savefrm" method="post" strong_body=JDACXC >
    <div class="fb_top_bg" id="banner_litpic"
         style=" background:url({if empty($info['bannerpic'])}/res/images/notes_default_banner.png{else}{$info['bannerpic']}{/if}) center no-repeat">
        <div class="tj_gg_box upbtn" data-type="banner">
            <i></i>
            <strong>添加/修改顶部图</strong>
            <span>图片尺寸建议1920px*420px</span>
        </div>
        <div class="tj_yj_tit">
            <input style="width: 1000px;" type="text" id="title" name="title" class="write" maxlength="40" max="40"
                   placeholder="这里添加游记标题" value="{$info['title']}"/>
            <span id="title_notes" data="最长40个字">最长40个字</span>
        </div>
    </div>

    <div class="big bgcolor_f5">
        <div class="wm-1200">
            <div class="pic_txt_box">
                <div class="pic_con">
                    {if !empty($info['litpic'])}
                    <div class="img-box"><img src="{Common::img($info['litpic'],358,258)}" id="cover_litpic"/></div>
                    {else}
                    <div class="img-box"><img src="{Common::img(Common::nopic(),358,258)}" id="cover_litpic"/></div>
                    {/if}
                    <span class="add_pic"><a href="javascript:;" class="upbtn" data-type="cover">添加封面</a></span>
                    <span class="exp-txt">最佳尺寸690*345</span>
                </div>
              <!--  <div class="add-dest">
                    <h3>添加游玩地点</h3>

                    <div class="text-block">
                        {loop $info['destinations'] $dest}
                        <span class="child" data="{$dest['id']}">{$dest['kindname']}<i class="close"></i></span>&nbsp;
                        {/loop}
                        <div class="import-dest">
                            <input type="text" id="search" class="import-input" placeholder="请输入您去过的城市"/>
                        </div>
                        <ul class="dest-drop-down hide" id="dest-drop-down">

                        </ul>
                        {Common::js('template.js')}
                        <script id="notes_write_template" type="text/html">
                            {{each list as v}}
                                <li data="{{v.id}}">{{v.kindname}}</li>
                            {{/each}}
                        </script>
                    </div>
                </div>-->
                <div class="txt_con">
                    <h3>填写游记摘要</h3>
                    <textarea name="description" placeholder="不填则默认截取正文内容" id="description" class="write" cols="" rows="" max="140">{$info['description']}</textarea>
                    <span class="yhb"></span>

                    <p id="description_notes" data="最多140个字">最多140个字</p>
                </div>
            </div>
            <div class="edit_box">
                <h3>编辑正文</h3>

                <div class="edit_con" style="padding:0" id="myEditor">
                    {Common::get_editor("content",$info['content'],1200,380,'Note')}
                </div>
                <a href="javascript:;" id="save_btn">发表游记</a>
            </div>
            <input type="hidden" id="banner" name="banner" value="{if empty($info['bannerpic'])}/plugins/notes/public/images/default_banner.png{else}{$info['bannerpic']}{/if}"/>
            <input type="hidden" id="cover" name="cover" value="{$info['litpic']}"/>
            <input type="hidden" autocomplete="off" id="noteid" name="noteid" value="{$info['id']}"/>
            <input type="hidden" name="frmcode" value="{$frmcode}"/>
            <input type="hidden" id="place" name="place" value="{$info['place']}">

        </div>
    </div>
</form>

{request "pub/footer"}
{Common::js('layer/layer.js',0)}

<script>
    $(function () {
        $("#banner_litpic").css({
            'background-size': 'cover'
        });
        $(".uptop").click(function () {
            $(this).parent().find('input').trigger('click');
        })
        //上传图片
        $(".upbtn").click(function () {
            var type = $(this).attr('data-type');
            upload(type);
        })
        //保存游记
        $("#save_btn").click(function () {

            var title = $('#title').val();
            var reg=/^\s+$/i;
            if (title == '' || reg.test(title)) {
                layer.msg('{__("notes_title_not_empty")}', {icon: 5, time: 1000});
                return;
            }
//            var desc = $('#description').val();
//            if (desc == '' || reg.test(desc)) {
//                layer.msg('{__("notes_description_not_empty")}', {icon: 5, time: 1000});
//                return;
//            }
//            var banner = $("#banner").val();
//            if (banner == '' || reg.test(banner)) {
//                layer.msg('{__("notes_banner_not_empty")}', {icon: 5, time: 1000});
//                return;
//            }
            var cover = $("#cover").val();
            if (cover == '' || reg.test(cover)) {
                layer.msg('{__("notes_cover_not_empty")}', {icon: 5, time: 1000});
                return;
            }
            var content = $('#myEditor').find('#ueditor_0').contents().find("body").html();
            var temp = content.replace(/<[^>]+>/g, "").replace(/&nbsp;/g,'').replace(/\r\n/g,'').replace('&#8203;','');
                reg=/^[\s\t]*$/;
            if (reg.test(temp)) {
                layer.msg('{__("notes_content_not_empty")}', {icon: 5, time: 1000});
                return;
            }
            //游玩地点
            var place=new Array();
            $('.add-dest').find('.child').each(function(){
                 place.push($(this).attr('data'));
            });
            $('#place').val(place.join(','));
            var frmdata = $("#savefrm").serialize();
            var SITEURL = "{URL::SITE()}";
            var loadingbox = null;
            $.ajax({
                type: 'POST',
                url: SITEURL + 'notes/ajax_save',
                dataType: 'json',
                data: frmdata,
                beforeSend: function () {
                    loadingbox = layer.load();
                },
                success: function (data) {
                    layer.close(loadingbox);
                    if (data.status) {
                        layer.msg('{__("save_success")}', {icon: 6, time: 1000});
                        if (data.noteid) {
                            $("#noteid").val(data.noteid);
                            setTimeout(function () {
                                window.open('/notes/', '_self');
                            }, 1000);
                        }
                    } else {
                        layer.msg('{__("save_failure")}', {icon: 6, time: 1000});
                    }
                }
            })


        })

        //上传模板
        function upload(type) {

            // 上传方法
            $.upload({
                // 上传地址
                url: SITEURL + 'notes/ajax_upload_picture?type='+type,
                // 文件域名字
                fileName: 'filedata',
                fileType: 'png,jpg,jpeg,gif',
                // 其他表单数据
                params: {},
                // 上传之前回调,return true表示可继续上传
                onSend: function () {
                    return true;
                },
                // 上传之后回调
                onComplate: function (data) {
                    var data = $.parseJSON(data);
                    //如果上传成功
                    if (data.status) {
                        if (type == 'banner') {
                            $("#banner_litpic").css({
                                'background': 'url(' + data.thumb + ') center no-repeat',
                                'background-size': 'cover'
                            });
                            $("#banner").val(data.litpic);
                        }
                        else if (type == 'cover') {
                            $("#cover_litpic").attr('src', data.thumb);
                            $("#cover").val(data.litpic);
                        }


                    }
                }
            });
        }


        //限制输入
        $('.write').keyup(function () {
            var val = $(this).val();
            var len = val.length;
            var max = $(this).attr('max');
            var id = $(this).attr('id');
            if (max > len) {
                $('#' + id + '_notes').html('你还可再输入' + (max - len) + '个字');

            } else {
                $(this).val(val.slice(0, max));

                $('#' + id + '_notes').html($('#' + id + '_notes').attr('data'));
            }

        });
        //游玩地点
        var delay = (function(){
            var timer = 0;
            return function(callback, ms){
                clearTimeout (timer);
                timer = setTimeout(callback, ms);
            };
        })();
        $('#search').keyup(function () {
            window.stourweb = {};
            window.stourweb.notes = $(this);
            delay(function(){
                var node=stourweb.notes;
                var val=node.val();
                if(val.length>0){
                    $.get('/notes/member/ajax_autocomplete',{key:val},function(data){
                        if(data.hasdata>0){
                            $('#dest-drop-down').html(template('notes_write_template', data));
                            $('#dest-drop-down').removeClass('hide');
                        }else{
                            $('#dest-drop-down').addClass('hide');
                        }
                    },'json')
                }

            },300)
        });
        $('#dest-drop-down li').live('click',function(){
            var id=$(this).attr('data');
            var html='<span class="child" data="'+id+'">'+$(this).text()+'<i class="close"></i></span>&nbsp;';
                $('#dest-drop-down').addClass('hide');
                $('.import-dest').before(html);
                $('#search').val('').focus()
        })
        $('body').click(function(){
            $('#dest-drop-down').addClass('hide');
        });
        $('.add-dest').find('.close').live('click',function(){
            $(this).parent().remove();
        });
    });
</script>


</body>
</html>
