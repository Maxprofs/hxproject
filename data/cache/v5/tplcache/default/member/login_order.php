<script>
    var isLoginOrder="<?php echo $GLOBALS['cfg_login_order'];?>";
    var isLogin=false;
    //登陆下订单
    function is_login_order(){
        var bool=true;
        var username=ST.Storage.getItem('st_username');
        var logintime=ST.Storage.getItem('st_user_logintime');
        var data=ST.Storage.getItem('st_data');
        var req={username:username,logintime:logintime,data:data};
        $.ajax({
            type:"POST",
            data:req,
            async:false,
            url:SITEURL+"member/login/ajax_is_login",
            dataType:'json',
            success:function(data){
                if(data.status)
                {
                    isLogin =true;
                }
            }
        });
        if(isLoginOrder==1 && !isLogin){
            $('#is_login_order').removeClass('hide');
            bool=false;
        }
        return bool;
    }
</script> <?php if(strpos(Common::get_current_url(),'/member/')===false) { ?> <?php echo Common::js('jquery.validate.js,jquery.md5.js');?> <?php echo  Stourweb_View::template("member/login_fast");  ?> <?php } ?>
