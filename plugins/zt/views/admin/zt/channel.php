{php Common::getEditor('jseditor','',$sysconfig['cfg_admin_htmleditor_width'],150,'Sline','','print',true);}
<div class="theme-info-container">
    <div class="theme-info-block">
        <ul>
            <li>
                <strong class="item-hd">栏目数量：</strong>
                <div class="item-bd">
                        <span class="amount-opt-wrap mt-2">
                            <a href="javascript:;" class="sub-btn go-un">–</a>
                            <input type="text" class="num-text channel-num" maxlength="2" value="0">
                            <a href="javascript:;" class="add-btn">+</a>
                        </span>
                </div>
            </li>
        </ul>
    </div>
</div>
<!-- 栏目数 -->

<div class="theme-info-container">
    <div class="theme-info-bar">

    </div>
    <div id="channel_list">

    </div>
</div>
<script>
    $(function(){
        //add channel
        $('.add-btn').click(function(){
            var now_num = Number($('.bt-bar').length);
            if(now_num == 10){
                ST.Util.showMsg('最多添加10个栏目',5,1000);
            }else{

                var ztid = $('#themeid').val();
                var channelid = ZT.add_channel(ztid);
                var html = ZT.load(channelid);
                ZT.hide('.channel-item');//hide all
                $('#channel_list').append(html);
                $('#channel_info_'+channelid).show();
                now_num++;
                $('.channel-num').val(now_num);

                //add bar
                var new_channel = {
                    id:channelid,
                    title:"自定义"+channelid
                }
                ZT.add_channel_bar(new_channel);
                window.JSEDITOR('channel_introduce_'+channelid);
                //choose the last one
                $('.bt-bar').last().trigger('click');
            }
        })
        //del channel
        $('.sub-btn').click(function(){

            //is more than one?
            if($('.bt-bar').length<0){
                return false;
            }

            var options = '<option value="0">请选择要删除的专题栏目</option>';
            $('.bt-bar').each(function (i,obj){
                var channelname = $(obj).text();
                var channelid = $(obj).attr('data-channelid');
                options+='<option value="'+channelid+'">'+channelname+'</option>';
            })
            var content = "删除栏目:<select id='choose_channelid'>"+options+"</select>";
            ST.Util.confirmBox("请选择需要删除的专题栏目?",content,function(){

                var channelid = $('#choose_channelid',parent.document).val();
                if(channelid>0){

                    ST.Util.confirmBox("删除栏目提示",'确认删除此栏目?',function(){
                        var flag = ZT.delete_channel(channelid);
                        if(flag){
                            //remove content
                            $('#channel_info_'+channelid).remove();
                            //remove bar
                            $('.bt-bar-'+channelid).remove();

                            //change channel num
                            $('.channel-num').val(Number($('.channel-num').val())-1);

                            ST.Util.showMsg('删除专题栏目成功',4,1000);

                        }else{
                            ST.Util.showMsg('请选择要删除专题栏目',5,1000);
                        }
                    }
                   ,function(){})
                }
            },function(){})
        })
        //channel click
        $('body').delegate('.bt-bar','click',function(){
            $(this).addClass('on').siblings().removeClass('on');
            var channelid = $(this).attr('data-channelid');
            var kindtype = $(this).attr('data-kindtype');

            ZT.hide('.channel-item');//hide all

            if ($('#channel_info_' + channelid).length > 0) {
                $('#channel_info_' + channelid).show();
            }else{

                var html = ZT.load(channelid);
                $('#channel_list').append(html);
                $('#channel_info_' + channelid).show();
                //textarea instants to editor
                window.JSEDITOR('channel_introduce_'+channelid);
            }

            if(kindtype !=1){
                //load channel product
                ZT.load_product(channelid,1);
            }else{
                //load channel coupon
                ZT.load_coupon(channelid,1);
            }

        })
        //get exists channel
        var ztid = $('#themeid').val();
        ZT.get_channel(ztid);
        //choose product
        $('body').delegate('.choose-product','click',function(){

                var channelid = $(this).attr('data-channelid');
                var kindtype  = Number($("#kindtype_"+channelid).val());

                if(kindtype == 0)
                {
                    ST.Util.showMsg("请选择栏目类型", 5, 1000);
                    return;
                }
                if(kindtype == 1){
                    var params={loadCallback: ZT.load_coupon,loadWindow:window};
                }else{
                    var params={loadCallback: ZT.load_product,loadWindow:window};
                }


                var url= SITEURL+"zt/admin/zt/dialog_get_products/kindtype/"+kindtype+'/channelid/'+channelid;
                ST.Util.showBox('选择',url,'600','430',null,null,document,params);
            });

        //remove product
        $('body').delegate('.remove-product','click',function(){
            var obj = $(this).parents('tr').first();
            var id = $(this).data('id');
            ST.Util.confirmBox("移除提示",'确定移除?',function(){
                var flag = ZT.remove_channel_product(id);
                if(flag){
                    ST.Util.showMsg('移除成功',4,1000);
                    $(obj).remove();

                }

            },null);

        })
        //remove coupon
        $('body').delegate('.remove-coupon','click',function(){
            var obj = $(this).parents('tr').first();
            var id = $(this).data('id');
            ST.Util.confirmBox("移除提示",'确定移除?',function(){
                var flag = ZT.remove_channel_coupon(id);
                if(flag){
                    ST.Util.showMsg('移除成功',4,1000);
                    $(obj).remove();

                }

            },null);

        })

        // save order
        $('body').delegate('.product_order','blur',function(){
            var id = $(this).data('id');
            var displayorder = $(this).val();
            var url = SITEURL+'zt/admin/zt/ajax_set_product_displayorder';
            $.ajax({
                type: "post",
                url: url,
                dataType: 'json',
                data: {id: id,displayorder:displayorder},
                success: function (result){

                }
            });



        })



    })
</script>