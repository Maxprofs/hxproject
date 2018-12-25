/**
 * Created by Administrator on 17-1-10.
 */
(function($){
    var ZT = {
        get_channel:function(ztid){
            var url = SITEURL+'zt/admin/zt/ajax_channel_list';
            var html = '';
            $.ajax({
                type:'POST',
                url:url,
                data:{ztid:ztid},
                dataType:'json',
                success:function(data){
                    var num = 0;
                    if(data){
                        var html = '';

                        $.each(data,function(i,row){
                            ZT.add_channel_bar(row);
                            num++;
                        })
                    }
                    //channel num
                    $('.channel-num').val(num);

                    if($('.bt-bar').length>0){
                        $('.bt-bar').first().trigger('click');
                    }

                }
            })
            return html;

        },
        load:function(channelid){
            var url = SITEURL+'zt/admin/zt/ajax_channel_info';
            var html = '';
            $.ajax({
                type:'POST',
                url:url,
                data:{channelid:channelid},
                dataType:'json',
                async:false,
                success:function(data){
                   html = ZT.generate_html(data);
                }
            })
            return html;



        },
        add_channel:function(ztid){
            var url = SITEURL+'zt/admin/zt/ajax_add_channel';
            var channelid = 0;

            $.ajax({
                type:'POST',
                url:url,
                data:{ztid:ztid},
                dataType:'json',
                async:false,
                success:function(data){
                    if(data.channelid){
                        channelid = data.channelid;
                    }
                }
            })
            return channelid;





        },
        hide:function(obj){
          $(obj).hide();
        },
        add_channel_bar:function(row){
            var html='<span class="bt-bar bt-bar-'+row.id+'" data-channelid="'+row.id+'" data-kindtype="'+row.kindtype+'">'+row.title+'</span>';
            $('.theme-info-bar').append(html);
        },
        delete_channel:function(channelid){
            var url = SITEURL+'zt/admin/zt/ajax_delete_channel';
            var status = 0;
            $.ajax({
                type:'POST',
                url:url,
                data:{channelid:channelid},
                dataType:'json',
                async:false,
                success:function(data){
                    if(data.status){
                        status = 1;
                    }
                }
            })
            return status;

        },
        generate_html:function(channelinfo){

            var check_status_1 = channelinfo.isopen == 1 ? "checked='checked'" : '';
            var check_status_2 = channelinfo.isopen == 0 ? "checked='checked'" : '';
            var kindtype_choose_1 = kindtype_choose_2 = kindtype_choose_3 = '';
            if(channelinfo.kindtype == 1){
                kindtype_choose_1 = "selected='selected'";
            }else if(channelinfo.kindtype == 2){
                kindtype_choose_2 = "selected='selected'";
            }else if(channelinfo.kindtype == 3){
                kindtype_choose_3 = "selected='selected'";
            }
            var html = '<div class="theme-info-block channel-item" id="channel_info_'+channelinfo.id+'" style="display:none">';
                html+= '<ul class="info-item-block">';
                html+='    <li>';
                html+='        <span class="item-hd">栏目名称：</span>';
                html+='        <div class="item-bd">';
                html+='            <input type="text" name="channelname['+channelinfo.id+']" class="default-text wid_460" value="'+channelinfo.title+'" />';
                html+='        </div>';
                html+='    </li>';
                html+='    <li>';
                html+='        <span class="item-hd">栏目排序：</span>';
                html+='        <div class="item-bd">';
                html+='            <input type="text" name="displayorder['+channelinfo.id+']" class="default-text wid_60" value="'+channelinfo.displayorder+'" />';
                html+='            <span class="bz-txt">请填写数字，例如“1、2、3”</span>';
                html+='        </div>';
                html+='    </li>';
                html+='    <li>';
                html+='     <span class="item-hd">是否开启：</span>';
                html+='        <div class="item-bd">';
                html+='            <label class="radio-label mr-30"><input type="radio" value="1"'+check_status_1+' name="isopen['+channelinfo.id+']">开启</label>';
                html+='                <label class="radio-label mr-30"><input type="radio" value="0" '+check_status_2+' name="isopen['+channelinfo.id+']">关闭</label>';
                html+='                </div>';
                html+='     </li>';
                html+='     <li>';
                html+='                <span class="item-hd">栏目介绍：</span>';
                html+='               <div class="item-bd">';
                html+='                    <textarea  id="channel_introduce_'+channelinfo.id+'" name="channel_introduce['+channelinfo.id+']">'+channelinfo.introduce+'</textarea>';
                html+='                </div>';
                html+='            </li>';
                html+='        <li>';
                html+='           <span class="item-hd">栏目类型：</span>';
                html+='              <div class="item-bd">';
                html+='                <select name="kindtype['+channelinfo.id+']" id="kindtype_'+channelinfo.id+'" class="drop-down wid_200">';
                html+='                 <option value="0">请选择</option>';
                if(is_coupon_install){
                    html+='                 <option value="1" '+kindtype_choose_1+'>优惠券</option>';
                }

            html+='                     <option value="2" '+kindtype_choose_2+'>产品陈列</option>';
            html+='                     <option value="3"'+kindtype_choose_3+'>文章列表</option>';
            html+='                     </select>';
            html+='                   </div>';
            html+='             </li>';
            html+='             <li>';
            html+='                  <span class="item-hd">内容列表：</span>';
            html += '                   <div class="item-bd">';
            html += '                        <a href="javascript:;" class="btn btn-primary radius size-S mt-3 choose-product" title="选择" data-channelid="' + channelinfo.id + '">选择</a>';
            html += '                       <table class="set-reward-table clear" id="channel_product_' + channelinfo.id + '">';


             html+='                       </table>';
             html+='<div class="btn-block">';
             html+='  <div class="pm-btm-msg pageinfo" id="page_info_'+channelinfo.id+'">';
             html+='  </div>';
             html+='</div>';


             html+='                   </div>';
             html+='               </li>';
             html+='               <li>';
             html+='                   <span class="item-hd">更多按钮：</span>';
             html+='                   <div class="item-bd">';
             html+='                       <input type="text" class="default-text wid_460" name="moreurl['+channelinfo.id+']" value="'+channelinfo.moreurl+'" placeholder="请输入更多按钮的链接地址" />';
             html+='                   </div>';
             html+='               </li>';
             html+='           </ul>';
             html+='       </div>';
             return html;


        },
        //get channel has selected products
        load_product:function(channelid,page){

           var url=SITEURL+'zt/admin/zt/ajax_get_channel_product';
            $.ajax({
                type: "post",
                url: url,
                dataType: 'json',
                data: {page: page,channelid:channelid},
                success: function (result, textStatus){

                    ZT.gen_product_list(result,channelid);
                }
            });
        },
        gen_product_list:function(result,channelid){

            var html='';
            html += '  <tr>';
            html += '  <th width="10%">产品排序</th>';
            html += '  <th width="10%">产品编号</th>';
            html += '  <th width="20%">产品类型</th>';
            html += '  <th width="45%">产品名称</th>';
            html += '  <th width="15%">管理</th>';
            html += '  </tr>';
            for(var i in result.list)
            {
                var row=result.list[i];
                html+='<tr>';
                html+='<td><input type="text" class="wid_40 pl-5 product_order" data-id="'+row.id+'" value="'+row.displayorder+'" onkeyup="this.value=this.value.replace(/[^0-9]/g,\'\')" onafterpaste="this.value=this.value.replace(/[^0-9]/g,\'\')" "></td>';
                html+='<td>'+row.series+'</td>';
                html+='<td>'+row.typename+'</td>';
                html+='<td><a class="bt" href="'+row.url+'" target="_blank">'+row.title+'</a></td>';
                html+='<td><a class="delete remove-product" data-id="'+row.id+'" href="javascript:;">移除</a></td>';
                html+='</tr>';

            }
            $('#channel_product_'+channelid).find("tr").remove();
            $('#channel_product_'+channelid).append(html);
            var pageHtml = ST.Util.page(result.pagesize, result.page, result.total, 5);
            $("#page_info_"+channelid).html(pageHtml);
            $('body').delegate('.pageinfo a','click',function(){
                var page = $(this).attr('page');
                ZT.load_product(channelid,page);
            })
        },
        //remove channel product
        remove_channel_product:function(id){
            var url = SITEURL+'zt/admin/zt/ajax_remove_channel_product';
            var flag = 0;
            $.ajax({
                type:'post',
                url:url,
                data:{id:id},
                dataType:'json',
                async:false,
                success:function(data){
                    if(data.status){
                        flag = 1;
                    }
                }
            })
            return flag;
        },
        load_coupon:function(channelid,page){
            var url=SITEURL+'zt/admin/zt/ajax_get_channel_coupon';
            $.ajax({
                type: "post",
                url: url,
                dataType: 'json',
                data: {page: page,channelid:channelid},
                success: function (result, textStatus){
                    ZT.gen_coupon_list(result,channelid);
                }
            });
        },
        gen_coupon_list:function(result,channelid){

            var html='';
            html += '  <tr>';
            html += '  <th width="15%">优惠券编码</th>';
            html += '  <th width="15%">优惠券类型</th>';
            html += '  <th width="40%">优惠券名称</th>';
            html += '  <th width="15%">有效期</th>';
            html += '  <th width="15%">管理</th>';
            html += '  </tr>';
            for(var i in result.list)
            {
                var row=result.list[i];
                html+='<tr>';
                html+='<td>'+row.code+'</td>';
                html+='<td>'+row.kindname+'</td>';
                html+='<td><a class="bt" href="javascript:;">'+row.name+'</a></td>';
                html+='<td>'+row.endtime+'</td>';
                html+='<td><a class="delete remove-coupon" data-id="'+row.id+'" href="javascript:;">移除</a></td>';
                html+='</tr>';

            }
            $('#channel_product_'+channelid).find("tr").remove();
            $('#channel_product_'+channelid).append(html);
            var pageHtml = ST.Util.page(result.pagesize, result.page, result.total, 5);
            $("#page_info_"+channelid).html(pageHtml);
            $('body').delegate('.pageinfo a','click',function(){
                var page = $(this).attr('page');
                ZT.load_coupon(channelid,page);
            })
        },
        remove_channel_coupon:function(id){
            var url = SITEURL+'zt/admin/zt/ajax_remove_channel_coupon';
            var flag = 0;
            $.ajax({
                type:'post',
                url:url,
                data:{id:id},
                dataType:'json',
                async:false,
                success:function(data){
                    if(data.status){
                        flag = 1;
                    }
                }
            })
            return flag;
        }




    }
    window.ZT = ZT;
})(jQuery)
