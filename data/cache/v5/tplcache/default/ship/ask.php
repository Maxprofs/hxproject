<?php defined('SYSPATH') or die();?> <!-- 我要咨询 --> <?php echo Common::js('layer/layer.js');?> <?php echo Common::js('template.js');?> <div class="ship-show-block"> <div class="column-tit">我要咨询</div> <div class="column-block"> <div class="st-tj-question"> <textarea name="question" id="question" cols="" placeholder="请填写你的问题" rows=""></textarea> <div class="msg"> <a class="tj-btn" href="javascript:;" data-productid="<?php echo $info['id'];?>" data-typeid="<?php echo $typeid;?>">提交</a> <span><em>验证码：</em><input type="text" id="checkcode" /><img src="<?php echo $cmsurl;?>captcha"  onClick="this.src=this.src+'?math='+ Math.random()" width="80" height="30" /></span> <span><em>昵称：</em> <span id="_c_u" style="line-height: 30px;height: 30px"></span> </span> <span><em><?php echo __('手机号码');?>：</em> <span id="_c_m" style="line-height: 30px;height: 30px"> </span> </span> </div> </div> </div> </div> <div class="ship-show-block"> <div class="column-tit">大家都在问</div> <div class="column-block"> <div class="line-consult"> <ul id="st_consult"> </ul> <div class="pagediv" style="text-align: center;display: none" data-quecount="<?php echo $row['plcount'];?>"  id="page"></div> <input type="hidden" id="curr_page" value="1"> <p class="consult-more-block"><a class="consult-more-btn">加载更多</a></p> </div> </div> </div> <script type="text/html" id="tpl_ask_list">
    {{each list as value i}}
    <li> <p class="consult-txt"> <span>{{value.nickname}}</span> <span>{{value.fmt_date}}</span> <span>{{value.fmt_time}}</span> </p> <dl class="asking clearfix"> <dt>咨询</dt> <dd>{{#value.content}}</dd> </dl> <dl class="answering clearfix"> <dt>回复</dt> <dd>{{#value.replycontent}}</dd> </dl> </li>
    {{/each}}
</script> <script>
    //提交问答
    $(".tj-btn").click(function(){
        var question = $("#question").val();
        var checkcode = $("#checkcode").val();
        var productid = $(this).attr('data-productid');
        var typeid = $(this).attr('data-typeid');
        var nickname = $("#nickname").val();
        var mobile = $("#mobile").val();
        if(question.length<5){
            layer.alert('<?php echo __("question_empty");?>', {
                icon: 5,
                title: '<?php echo __("notice");?>'
            });
            return false;
        }
        var mobileReg=/^(\+?0?86\-?)?1[345789]\d{9}$/;
        if (mobile == '' || !mobileReg.test(mobile)) {
            var msg = mobile.length <1 ? '<?php echo __("手机号码不能为空");?>' : '<?php echo __("请填写正确的手机号码");?>';
            layer.alert(msg, {
                icon: 5,
                title: '<?php echo __("notice");?>'
            });
            return false;
        }
        if(checkcode==''){
            layer.alert('<?php echo __("checkcode_empty");?>', {
                icon: 5,
                title: '<?php echo __("notice");?>'
            });
            return false;
        }
        $.ajax({
            type:'POST',
            url:SITEURL+'pub/ajax_add_question',
            data:{
                productid:productid,
                content:question,
                checkcode:checkcode,
                nickname:nickname,
                typeid:typeid,
                questype:0,
                mobile:mobile
            },
            success:function(data){
                if(data==1){
                    layer.alert('<?php echo __("checkcode_error");?>', {
                        icon: 5,
                        title: '<?php echo __("notice");?>'
                    });
                    //重新加载验证码
                    $("#imgcheckcode").attr('src',"<?php echo $cmsurl;?>captcha?"+Math.random());
                }else if(data==3){
                    layer.msg('<?php echo __("question_success");?>',{
                        icon:6,
                        time:1500
                    });
                    location.reload();
                }else{
                    layer.alert('<?php echo __("question_failure");?>', {
                        icon: 5,
                        title: '<?php echo __("notice");?>'
                    });
                }
            }
        });
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
            var mobile;
            if(data.status){
                mobile = '<input type="text" class="w100" value="'+data.user.mobile+'" name="mobile" id="mobile" />';
                $txt = '<span>'+data.user.nickname+'</span><input type="hidden" value="'+data.user.nickname+'" name="nickname" id="nickname" />';
            }else{
                mobile = '<input type="text" class="w100" value="" name="mobile" id="mobile" />';
                $txt = '<input type="text" name="nickname" id="nickname" /><a href="<?php echo $cmsurl;?>member/login/"><?php echo __("登录");?></a>';
            }
            $("#_c_u").html($txt);
            $("#_c_m").html(mobile);
        }
    });
    $(function () {
        get_more_ask("<?php echo $info['id'];?>", "<?php echo $typeid;?>", parseInt($('#curr_page').val()));
        $('.consult-more-btn').click(function () {
            var pdtid = "<?php echo $info['id'];?>";
            var typeid = "<?php echo $typeid;?>";
            var page = parseInt($('#curr_page').val());
            get_more_ask(pdtid, typeid, page);
        });
    });
    //获取更多咨询
    function get_more_ask(pdtid, typeid, page) {
        $.ajax({
            type: 'GET',
            url: SITEURL + 'pub/ajax_get_more_ask',
            dataType: 'json',
            data: {
                product_id: pdtid,
                type_id: typeid,
                page: page
            },
            beforeSend: function () {
                ST.Util.showLoading({text: ''});
            },
            complete: function () {
                ST.Util.closeLoading();
            },
            success: function (data) {
                if (data.status){
                    var list_html = template('tpl_ask_list',data);
                    $('#st_consult').append(list_html);
                    if (data.num < 10){
                        $('.consult-more-btn').hide();
                    }else{
                        $('.consult-more-btn').show();
                    }
                    $('#curr_page').val(page + 1);
                }else{
                    $('.consult-more-btn').hide();
                }
            }
        });
    }
</script> <!-- 我要咨询 -->