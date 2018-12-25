{if $GLOBALS['cfg_write_tourer']==1}
<div class="booking-info-block">
    <div class="bib-hd-bar">
        <span class="col-title">旅客信息</span>
    </div>
    <div class="bib-bd-wrap">
        {st:member action="linkman" memberid="$userInfo['mid']" return="tourerlist"}
        {if !empty($userInfo) && !empty($tourerlist[0]['linkman'])}
            <div class="bib-select-linkman">
                <div class="bib-select-bar">选择常用旅客</div>
                <div class="bib-select-bd">
                    <div class="bib-select-box">
                        {loop $tourerlist $row}
                         <span class="check-item choose-linkman" data-linkman="{$row['linkman']}" data-cardtype="{$row['cardtype']}"
                               data-idcard="{$row['idcard']}" data-sex="{$row['sex']}" data-mobile="{$row['mobile']}"><i class="check-icon"></i>{$row['linkman']}</span>
                        {/loop}
                    </div>
                    {if count($tourerlist)>5}
                     <a class="bib-check-more down" href="javascript:;">更多</a>
                    {/if}
                </div>
            </div>
        {/if}
        <div class="visitor-msg" id="tourer_list">

        </div>
    </div>
</div>

<script>

   $(function(){


       //展开更多
       $(".bib-check-more").on("click",function(){
           if($(this).hasClass("down")){
               $(this).removeClass("down").text("收起").prev(".bib-select-box").css({
                   "height": "auto"
               })
           }
           else{
               $(this).addClass("down").text("更多").prev(".bib-select-box").css({
                   "height": "24px"
               })
           }
       });

       //性别选择
       $('body').delegate('.sex','click',function(){
           $(this).addClass("active").siblings().removeClass("active");
           $(this).siblings('input:hidden').val($(this).attr("data-sex"));
       })



       //选择保存到常用
       $('#tourer_list').on('click','.save-linkman',function () {
           if($(this).hasClass('active'))
           {
               $(this).removeClass('active');
               $(this).next('input:hidden').val(0);
           }
           else
           {
               $(this).addClass('active');
               $(this).next('input:hidden').val(1);
           }
       });


       //选择游客
       $('.choose-linkman').click(function () {
           var t_linkman = $(this).attr('data-linkman');
           var t_cardtype = $(this).attr('data-cardtype');
           var t_idcard = $(this).attr('data-idcard');
           var t_sex = $(this).attr('data-sex');
           var t_mobile = $(this).attr('data-mobile');

           //总人数
           var total_num = get_total_num();
           $(this).toggleClass('check-active-item');

           var has_choose = $('.check-active-item').length;
           //如果选中数量大于总人数,则取消选中.
           if (has_choose > total_num) {
               $(this).removeClass('check-active-item');
               return;
           }
           //如果是选中事件
           if ($(this).hasClass('check-active-item')) {

               $("#tourer_list .bib-linkman-block").each(function (i, obj) {
                   if ($(obj).find('.t_name').first().val() == '')
                   {
                       $(obj).find('.t_name').first().val(t_linkman);
                       $(obj).find('.t_cardtype').first().val(t_cardtype);
                       $(obj).find('.t_cardno').first().val(t_idcard);
                       $(obj).find('.t_mobile').first().val(t_mobile);
                       $(obj).find('.sex').each(function () {
                           if($(this).data('sex')==t_sex)
                           {
                               $(obj).find('.sex').removeClass('active');
                               $(this).addClass('active');
                               $(obj).parent().find('input:hidden').val(t_sex)
                           }
                       });
                       //身份证验证
                       $(obj).find('.t_cardno').first().rules("remove", 'required');
                       $(obj).find('.t_cardno').first().rules("remove", 'isIDCard');
                       $(obj).find('.t_cardno').first().rules("remove", 'date');
                       $(obj).find('.t_cardno').first().rules("remove", 'alnum');
                       if (t_cardtype== '身份证') {
                           $(obj).find('.t_cardno').first().rules('add', {required: true,isIDCard: true, messages: {required: "请输入身份证号码",isIDCard: "身份证号码不正确"}});
                       }else if(t_cardtype== '出生日期'){
                           $(obj).find('.t_cardno').first().rules("add", {required: true,date:true, messages: {required: "请输入出生日期",date: "日期格式不正确"}});
                       }else{
                           $(obj).find('.t_cardno').first().rules("add", {required: true,alnum:true,messages: {required: "请输入证件号"}});
                       }
                       return false;
                   }
               });
           }
           else
           {
               $("#tourer_list .bib-linkman-block").each(function (i, obj) {
                   if ($(obj).find('.t_name').first().val() == t_linkman
                       && $(obj).find('.t_cardno').first().val() == t_idcard
                       && $(obj).find('.t_cardtype').first().val() == t_cardtype
                   )
                   {
                       $(obj).find('.t_name').first().val('');
                       $(obj).find('.t_cardno').first().val('');
                       $(obj).find('.t_cardtype').first().val('身份证');
                       $(obj).find('.sex').removeClass('active');
                       $(obj).find('input:hidden').val('男');
                       $(obj).find('.sex:first').addClass('active');
                       $(obj).find('.t_mobile').first().val('');
                   }


               })

           }

       })
   })



    /*生成tourer html*/
    function add_tourer() {

        var total_num = get_total_num();
        var html = '';
        var hasnum = $("#tourer_list").find('.bib-linkman-block').length;
        for (var i = hasnum; i < total_num; i++) {
            html += parse_tourer_template(i);
        }
        $("#tourer_list").append(html);
        //动态添加游客姓名
        $("input[name^='t_name']").each(
            function (i, obj) {
                $(obj).rules("remove");
                $(obj).rules("add", {required: true,byteRangeLength:true, messages: {required: "请输入姓名",byteRangeLength:'最大支持4个中文汉字'}});

            }
        );
        //证件类型
        $("input[name^='t_cardno']").each(
            function (i, obj) {
                $(obj).rules("remove");
                var id = $(obj).attr('id').replace('t_cardno_', '');
                $(obj).rules("remove", 'required');
                $(obj).rules("remove", 'isIDCard');
                $(obj).rules("remove", 'date');
                $(obj).rules("remove", 'alnum');
                if ($('#t_cardtype_' + id).val()== '身份证') {
                    $(obj).rules('add', {required: true,isIDCard: true, messages: {required: "请输入身份证号码",isIDCard: "身份证号码不正确"}});
                }else if($('#t_cardtype_' + id).val()== '出生日期'){
                    $(obj).rules("add", {required: true,date:true, messages: {required: "请输入出生日期",date: "日期格式不正确"}});
                }else{
                    $(obj).rules("add", {required: true,alnum:true,messages: {required: "请输入证件号"}});
                }
            }
        );
        //手机号
        $("input[name^='t_mobile']").each(
            function (i, obj) {
                $(obj).rules("remove");
                $(obj).rules("add", {required: true,isMobile:true, messages: {required: "请输入手机号码",isMobile: "请输入正确的手机号"}});
            }
        );
        //身份证验证
        $('#tourer_list').on('change', '.t_cardtype',function(){
            var id = $(this).attr('id').replace('t_cardtype_', '');
            $("span[for='t_cardno_"+id+"']").remove();
            $('#t_cardno_' + id).val('');
            $('#t_cardno_' + id).rules("remove", 'required');
            $('#t_cardno_' + id).rules("remove", 'isIDCard');
            $('#t_cardno_' + id).rules("remove", 'date');
            $('#t_cardno_' + id).rules("remove", 'alnum');
            $('#t_cardno_' + id).removeAttr("placeholder");
            if ($(this).val()== '身份证') {
                $('#t_cardno_' + id).rules('add', {required: true,isIDCard: true, messages: {required: "请输入身份证号码",isIDCard: "身份证号码不正确"}});
            }else if($(this).val()== '出生日期'){
                $('#t_cardno_' + id).rules("add", {required: true,date:true, messages: {required: "请输入出生日期",date: "日期格式不正确"}});
                $('#t_cardno_' + id).attr('placeholder','格式:yyyy-mm-dd');
            }else{
                $('#t_cardno_' + id).rules("add", {required: true,alnum:true,messages: {required: "请输入证件号"}});
            }
        });


        jQuery.validator.addMethod("byteRangeLength", function(value, element) {
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
            return this.optional(element) || ( length >= 0 && length <= 4 );
        }, $.validator.format("最大支持4个中文汉字"));


    }
    /*移除tourer*/
    function remove_tourer() {
        $("#tourer_list .bib-linkman-block").last().remove();
    }
    /**
     * 解析游客模板
     * @param i
     * @returns {string}
     */
    function parse_tourer_template(i){
     var template = '<div class="bib-linkman-block clearfix">';
         template+='<div class="hd-box">旅客{{tnumber}}</div>';
        template+='<div class="bd-box">';
        template+='<ul class="booking-item-block">';
        template+='<li>';
        template+='<span class="item-hd"><i class="st-star-ico">*</i>旅客姓名：</span>';
        template+='<div class="item-bd">';
        template+='<input type="text" class="input-text t_name w230" name="t_name[{{number}}]" id="t_name[{{number}}]" value="" placeholder="">';

        template+='</div>';
        template+='</li>';
        template+='<li>';
        template+='<span class="item-hd"><i class="st-star-ico">*</i>旅客性别：</span>';
        template+='<div class="item-bd">';
        template+='<div class="bib-radio-box">';
        template+='<span class="bib-radio-label active sex" data-sex="男"><i class="radio-icon"></i>男</span>';
        template+='<span class="bib-radio-label sex" data-sex="女"><i class="radio-icon"></i>女</span>';
        template+='<input type="hidden" name="t_sex[{{number}}]" value="男">';
        template+='</div>';

        template+='</div>';
        template+='</li>';
        template+='<li>';
        template+='<span class="item-hd"><i class="st-star-ico">*</i>手机号码：</span>';
        template+='<div class="item-bd">';
        template+='<input type="text" name="t_mobile[{{number}}]" class="input-text w230 t_mobile" value="" placeholder="">';
        template+='</div>';
        template+='</li>';
        template+='<li>';
        template+='<span class="item-hd"><i class="st-star-ico">*</i>证件类型：</span>';
        template+='<div class="item-bd">';
        template+='<select class="select w230 t_cardtype" id="t_cardtype_{{number}}" name="t_cardtype[{{number}}]">';
        template+='<option value="身份证">身份证</option>';
        template+='<option value="护照">护照</option>';
        template+='<option value="台胞证">台胞证</option>';
        template+='<option value="港澳通行证">港澳通行证</option>';
        template+='<option value="军官证">军官证</option>';
        template+='<option value="出生日期">出生日期</option>';


        template+='</select>';
        template+='</div>';
        template+='</li>';
        template+='<li>';
        template+='<span class="item-hd"><i class="st-star-ico">*</i>证件号码：</span>';
        template+='<div class="item-bd">';
        template+='<input type="text" class="input-text w230 t_cardno" id="t_cardno_{{number}}" name="t_cardno[{{number}}]" value="" placeholder="">';
        template+='</div>';
        template+='</li>';
        template+='<li>';
        template+='<span class="item-hd">&nbsp;</span>';
        template+='<div class="item-bd">';
        template+='<span class="common-use-label mt10 save-linkman"><i class="icon"></i>存为常用联系人</span><input type="hidden" name="t_issave[{{number}}]" value="0">';
        template+='</div>';
        template+='</li>';
        template+='</ul>';
        template+='</div>';
        template+='</div>';

        var html = '';
        html = template.replace(/\{\{number\}\}/g,i);
        html = html.replace(/\{\{tnumber\}\}/g,i+1);
        return html;
    }
</script>
{/if}