
{Common::css('add-passenger.css')}
<div class="header_top bar-nav">
    <a class="back-link-icon"  href="javascript:void(0)" data-rel="back"></a>
    <h1 class="page-title-bar">{$info['action']}常用旅客</h1>
    {if $info['id']}
    <a class="delete"  data-id="{$info['id']}" href="javascript:void(0)">删除</a>
    {/if}
</div>
<!-- 公用顶部 -->
<div class="page-content">
    <form id="linkmanfrm">
        <div class="passenger-list">
            <ul class="passenger-info">
                <li>
                    <strong class="item-hd">姓名</strong>
                    <input type="text"  name="linkman" value="{$info['linkman']}" placeholder="请填写您的真实姓名" class="write-info" />
                </li>
                <li class="last-li">
                    <strong class="item-hd">性别</strong>
                    <span class="sex-choose">
                        <em data-sex="男" class="men {if $info['sex']!='女'}on{/if}"><i class="ico"></i>男</em>
                        <em  data-sex="女" class="women {if $info['sex']=='女'}on{/if}"><i class="ico"></i>女</em>
                    </span>
                </li>
            </ul>
        </div>
        <div class="passenger-list">
            <ul class="passenger-info">
                <li>
                    <strong class="item-hd">手机号</strong>
                    <input type="text" name="mobile"  value="{$info['mobile']}"  placeholder="请填写13位手机号" class="write-info" />
                </li>
                <li>
                    <strong class="item-hd">证件类型</strong>
                    <span class="cert-type" id="cardtype-text">{if $info['cardtype']}  {$info['cardtype']}{else}身份证{/if}<i class="more-ico"></i></span>
                </li>
                <li class="last-li">
                    <strong class="item-hd">证件号码</strong>
                    <input type="text" name="idcard" id="idcard" value="{$info['idcard']}"   placeholder="请填写证件号码" class="write-info" />
                </li>
            </ul>
        </div>
        <input type="hidden" name="cardtype" id="cardtype" value="{if $info['cardtype']}{$info['cardtype']}{else}身份证{/if}"/>
        <input type="hidden" name="sex" value="{if $info['sex']}{$info['sex']}{else}男{/if}"/>
        <input type="hidden" name="id" value="{$info['id']}"/>
    </form>
</div>

<a class="save-btn-box save-linkman" href="javascript:void(0)">保存</a>

<div class="foo-box hide" id="suit_list">
    <div class="tc-container">
        <div class="tc-tit-bar"><strong class="bt">选择证件</strong><i class="close-icon"></i></div>
        <div class="tc-wrapper">
            <ul>
                <li data-cardtype="身份证"  {if $info['cardtype']=='身份证'||!$info['cardtype']}  class="active"{/if}><em class="item">身份证</em><i class="radio-btn"></i></li>
                <li data-cardtype="护照" {if $info['cardtype']=='护照'} class="active" {/if}><em class="item">护照</em><i class="radio-btn"></i></li>
                <li data-cardtype="台胞证" {if $info['cardtype']=='台胞证'} class="active" {/if}><em class="item">台胞证</em><i class="radio-btn"></i></li>
                <li data-cardtype="军官证" {if $info['cardtype']=='军官证'} class="active" {/if}><em class="item">军官证</em><i class="radio-btn"></i></li>
                <li data-cardtype="港澳通行证" {if $info['cardtype']=='港澳通行证'} class="active" {/if}><em class="item">港澳通行证</em><i class="radio-btn"></i></li>
                <li data-cardtype="出生日期" {if $info['cardtype']=='出生日期'} class="active" {/if}><em class="item">出生日期</em><i class="radio-btn"></i></li>
            </ul>
        </div>
    </div>
</div>

<div class="erro-msg-txt" style="display: none"></div>


<script type="text/javascript">

    $(function(){
        var is_allow = 1 ;
        $("body,html").css("height", "100%");
        //选择性别
        $(".sex-choose > em").on("click",function(){
            var sex  = $(this).data('sex');
            $('input[name=sex]').val(sex);
            $(this).addClass("on").siblings().removeClass("on")
        });

        $(".cert-type").click(function(){
            $("#suit_list").show();
        });

        $(".close-icon").click(function(){
            $("#suit_list").hide();
        });
        //切换证件类型
        $('#suit_list li').click(function () {
            $('#suit_list li').removeClass('active');
            $(this).addClass('active');
            var cardtype = $(this).data('cardtype');
            $('input[name=cardtype]').val(cardtype);
            if(cardtype=='出生日期'){
                var _html='<strong class="item-hd">出生日期</strong>' +
                    '<input type="date" name="idcard" id="idcard" value="" placeholder="请填写出生日期" class="write-info">';
            }else{
                var _html='<strong class="item-hd">证件号码</strong>' +
                    '<input type="text" name="idcard" id="idcard" value="" placeholder="请填写证件号码" class="write-info">';
            }
            $('#cardtype-text').parents('ul.passenger-info').find('li.last-li').html(_html);
            $("#suit_list").hide();
            $('#cardtype-text').html(cardtype+'<i class="more-ico"></i>');
        });
        //删除
        $('.delete').click(function () {
            var id = $(this).data('id');
            layer.open({
                content: '您确定要删除常用旅客？'
                ,btn: ['确定', '取消']
                ,yes: function(index){
                    is_allow = 0;
                    layer.close(index);
                    $.ajax({
                        type:'get',
                        dataType:'json',
                        data:{id:id},
                        url:SITEURL+'member/linkman/update?action=delete',
                        success:function (data) {
                            if(data.bool)
                            {
                                $.layer({
                                    type:1,
                                    icon:1,
                                    text:'删除成功',
                                    time:1000
                                });
                                //返回上一页面并动态刷新
                                var url = '{$cmsurl}member#&myLinkman';
                                setTimeout(function(){
                                    window.location.href = url;
                                },1000)
                            }
                            else
                            {
                                $.layer({
                                    type:1,
                                    icon:2,
                                    text:data.msg,
                                    time:1000
                                })
                            }
                        }
                    })

                }
            });
        });

        //提交
        $('.save-linkman').click(function(){
            if(is_allow==0)
            {
                return false;
            }
            var linkman = $('input[name=linkman]').val();
            var mobile = $('input[name=mobile]').val();
            if(!check_linkman(linkman))
            {

                show_error('请输入正确的姓名');
                return false;
            }
            var text_mobile = /(13\d|14[57]|15[^4,\D]|17[13678]|18\d)\d{8}|170[0589]\d{7}/g;
            var ismobile  = text_mobile.test(mobile);
            if(!ismobile&&mobile)
            {
                show_error('请输入正确的手机号');
                return false;
            }

            if(!check_idcard())
            {
                return false;
            }

            var frmdata = $("#linkmanfrm").serialize();
            is_allow = 0;
            $.ajax({
                type:'POST',
                url:SITEURL+'member/linkman/update?action=save',
                async:false,
                data:frmdata,
                dataType:'json',
                success:function(data){
                    if(data.status){
                        $.layer({
                            type:1,
                            icon:1,
                            text:'保存成功',
                            time:1000
                        });
                        //返回上一页面并动态刷新
                        var url = '{$cmsurl}member#&myLinkman';
                        setTimeout(function(){
                            is_allow = 1 ;
                            console.log(is_allow)
                            window.location.href = url;
                        },1000)

                    }else{
                        is_allow = 1;
                        $.layer({
                            type:1,
                            icon:2,
                            text:data.msg,
                            time:1000
                        })
                    }
                }

            })


        });







    });


    function show_error(text) {
        $('.erro-msg-txt').text(text);
        $('.erro-msg-txt').show();
        setTimeout(function () {
            $('.erro-msg-txt').hide();
        },2000)

    }


    //判断名称
    function check_linkman(value) {
        var length = 0;
        for(var i = 0; i < value.length; i++){
            if(value.charCodeAt(i) > 127){
                length++;
            }
            else
            {
                length += 0.5;
            }
        }
        if(length>0&&length<=4)
        {

            return true;
        }
        return false;

    }

    //判断证件号
    function check_idcard() {
        var cardtype = $.trim($('input[name=cardtype]').val());
        var idcard = $.trim($('input[name=idcard]').val());
        if(cardtype=='身份证')
        {
            if(!checkCard(idcard))
            {
                show_error('身份证号码不正确');
                return false;
            }
        }
        var pattern = /^[a-zA-Z0-9]{1,20}$/;
        if(idcard.length<1||!pattern.test(idcard))
        {
            show_error('证件号不正确');
            return false;
        }
        var flag = false;
        $.ajax({
            type:'post',
            data:{cardtype:cardtype,idcard:idcard,id:$('input[name=id]').val()},
            dataType:'json',
            async:false,
            url: SITEURL+'member/linkman/ajax_check_linkman_card',
            success:function (data) {
                if(data.status)
                {
                    flag = true;
                }
            }
        });
        
        if(flag==false)
        {
            show_error('证件号重复');
            return false;
        }
        return true;


    }


    function checkCard(card)
    {
        card=card.toLowerCase();
        var vcity={ 11:"北京",12:"天津",13:"河北",14:"山西",15:"内蒙古",21:"辽宁",22:"吉林",23:"黑龙江",31:"上海",32:"江苏",33:"浙江",34:"安徽",35:"福建",36:"江西",37:"山东",41:"河南",42:"湖北",43:"湖南",44:"广东",45:"广西",46:"海南",50:"重庆",51:"四川",52:"贵州",53:"云南",54:"西藏",61:"陕西",62:"甘肃",63:"青海",64:"宁夏",65:"新疆",71:"台湾",81:"香港",82:"澳门",91:"国外"};
        var arrint = new Array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
        var arrch = new Array('1', '0', 'x', '9', '8', '7', '6', '5', '4', '3', '2');
        var reg = /(^\d{15}$)|(^\d{17}(\d|x)$)/;
        if(!reg.test(card))return false;
        if(vcity[card.substr(0,2)] == undefined)return false;
        var len=card.length;
        if(len==15)
            reg=/^(\d{6})(\d{2})(\d{2})(\d{2})(\d{3})$/;
        else
            reg=/^(\d{6})(\d{4})(\d{2})(\d{2})(\d{3})([0-9]|x)$/;
        var d,a = card.match(new RegExp(reg));
        if(!a)return false;
        if (len==15){
            d = new Date("19"+a[2]+"/"+a[3]+"/"+a[4]);
        }else{
            d = new Date(a[2]+"/"+a[3]+"/"+a[4]);
        }
        if (!(d.getFullYear()==a[2]&&(d.getMonth()+1)==a[3]&&d.getDate()==a[4]))return false;
        if(len=18)
        {
            len=0;
            for(var i=0;i<17;i++)len += card.substr(i, 1) * arrint[i];
            return arrch[len % 11] == card.substr(17, 1);
        }
        return true;
    };

</script>

