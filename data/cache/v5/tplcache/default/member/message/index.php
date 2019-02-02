<!doctype html> <html> <head div_clear=5otJVl > <meta charset="utf-8"> <title><?php echo __('系统消息');?>-<?php echo $webname;?></title> <?php echo  Stourweb_View::template("pub/varname");  ?> <?php echo Common::css('user.css,base.css,extend.css');?> <?php echo Common::js('jquery.min.js,base.js,common.js,jquery.validate.js,jquery.cookie.js,jquery.validate.addcheck.js');?> </head> <body> <?php echo Request::factory("pub/header")->execute()->body(); ?> <div class="big"> <div class="wm-1200"> <div class="st-guide"> <a href="<?php echo $cmsurl;?>"><?php echo __('首页');?></a>&nbsp;&nbsp;&gt;&nbsp;&nbsp;<?php echo __('常用地址');?> </div><!--面包屑--> <div class="st-main-page"> <?php echo  Stourweb_View::template("member/left_menu");  ?> <div class="user-message-center fr"> <div class="user-message-bar">系统消息</div> <div class="user-message-container"> <ul class="user-message-block" id="msg_con"> <?php $n=1; if(is_array($list)) { foreach($list as $row) { ?> <li class="item <?php 
                          if($row['memberid']==$mid && $row['status']==0){
                            echo 'unread';
                          }elseif($row['memberid']!=$mid && $row['dstatus']==0){
                            echo 'unread';
                          }
                       ?> clearfix" data-id="<?php echo $row['id'];?>"> <span class="msg-icon"></span> <div class="con-txt"> <?php echo $row['content'];?><a href="javascript:;" data-url="<?php echo $row['url'];?>" class="s-link">【点击查看】</a> </div> <span class="close-btn"></span> <span class="date"><?php echo date('Y-m-d H:i',$row['addtime']);?></span> </li> <?php $n++;}unset($n); } ?> </ul> <div class="main_mod_page clear"> <?php echo $pageinfo;?> </div><!-- 翻页 --> </div> </div> </div> </div> <?php echo Request::factory("pub/footer")->execute()->body(); ?> <?php echo Common::js('layer/layer.js');?> <script>
    $(function(){
        //导航选中
        $("#nav_message_index").addClass('on');
        if(typeof(on_leftmenu_choosed)=='function')
        {
            on_leftmenu_choosed();
        }
        $("#msg_con li .close-btn").click(function(){
            var ele = $(this).parents('li:first');
            var id = ele.attr('data-id');
            $.ajax({
                url:SITEURL+'member/message/ajax_delete',
                type:'POST', //GET
                data:{
                   id:id
                },
                dataType:'json',
                success:function(data,textStatus,jqXHR){
                    if(data.status)
                    {
                        ele.remove();
                    }
                }
            })
        });
        //更多
        $("#msg_con li .s-link").click(function(){
            var ele = $(this).parents('li:first');
            var id = ele.attr('data-id');
            var url = $(this).attr('data-url');
            $.ajax({
                url: SITEURL + 'member/message/ajax_readed',
                type: 'POST', //GET
                data: {
                    id: id
                },
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    window.location.href = url;
                }
            })
        });
    })
</script> </body> </html>
