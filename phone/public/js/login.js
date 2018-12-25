if(typeof(window.ST) == 'undefined') {
    var login = {};
}else{
    var login = window.ST;
}
if (typeof(window.SITEURL) == 'undefined'){
    var SITEURL='/';
}else {
    var SITEURL=window.SITEURL;
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
    check_login:function() {
        //登陆检测
        var logintime=Storage.getItem('st_user_logintime');
        var data=Storage.getItem('st_secret');
        if(!data){
            Storage.removeItem('st_secret');
            Storage.removeItem('st_user_logintime');
        }
        $.post(SITEURL+'member/login/ajax_check_login',{data:data,logintime:logintime},function(rs){
            Global.eval_js(rs);
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
    login_in_m:function(data,callback) {
        $.post(SITEURL + 'member/login/ajax_check', data, function (rs) {
            callback(rs);
        }, 'json');
    },
    login_sendCode_m:function (data,callback) {
        $.post(SITEURL + 'member/login/ajax_send_code', data, function (rs) {
            callback(rs);
        }, 'json');
    },
    login_codeLogin_m:function (data,callback) {
        $.post(SITEURL + 'member/login/ajax_sms_code_login', data, function (rs) {
            callback(rs);
        }, 'json');
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


