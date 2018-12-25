if(typeof(window.ST) == 'undefined') {
    var login = {};
}else{
    var login = window.ST;
}
if (typeof(SITEURL) == 'undefined'){
    var SITEURL='/';
}
var Storage={
    setItem:function(key, data) {
        localStorage.setItem(key,data);
    },
    getItem:function(key) {
        return localStorage.getItem(key);
    },
    removeItem:function(key) {
        localStorage.removeItem(key);
    },
    clear: function(){
        localStorage.clear();
    }
};
login.Storage = Storage;
var Global={
    check_login:function(callback) {
        //登陆状态
        var logintime=Storage.getItem('st_user_logintime');
        var secret=Storage.getItem('st_secret');
        var req;
        if(secret)
        {
            req={logintime:logintime,data:secret};
        }else{
            Storage.removeItem('st_secret');
            Storage.removeItem('st_user_logintime');
        }
        $.ajax({
            type:"POST",
            data:req,
            async:false,
            url:SITEURL+"member/login/ajax_is_login",
            dataType:'json',
            success:function(data){
                if(data.status){
                    //更新存储有效期
                    if(!secret)
                    {
                        secret=data.secret;
                    }
                    Global.update_storage_login_data(secret,data.checktime);
                }
                //执行回调
                callback(data);
            }
        });
    },
    update_storage_login_data:function(md5,time) {//更新storage存储
        if(!md5){
            Storage.removeItem('st_secret');
            Storage.removeItem('st_user_logintime');
            return false;
        }
        //本地数据保持
        Storage.setItem('st_secret',md5);
        //设置保持时间
        Storage.setItem('st_user_logintime',time);
    },
    login_callback:function(data){
        Global.update_storage_login_data(data.secret,data.time);
    },
    login_out: function(){
        $.post(SITEURL + 'member/login/ajax_login_out',{}, function (rs) {
            //callback(rs);
            if(rs.status)
            {
                Storage.removeItem('st_secret');
                Storage.removeItem('st_user_logintime');
                window.location.href = rs.url;
            }
        }, 'json');
    },
    //执行js
    eval_js:function(js) {
        var script = document.createElement('script');
        script.type = "text/javascript";
        script.text = js;
        document.getElementsByTagName('head')[0].appendChild(script);
        document.head.removeChild(document.head.lastChild);
    }
};
login.Login = Global;
window.ST = login;


