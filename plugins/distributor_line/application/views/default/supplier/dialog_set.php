<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>笛卡CMS4.0</title>
    {include "pub"}
    {Common::css('admin_base.css,admin_base2.css,admin_style.css,style.css,destination_dialog_setdest.css,distributor_dialog_set.css')}
    {Common::css('public/js/uploadify/uploadify.css',false,false)}
    {Common::css('public/js/artDialog/css/ui-dialog.css',false,false)}
    {Common::css('public/js/msgbox/msgbox.css',false,false)}
    {Common::js('jquery.min.js,artDialog/dist/dialog-plus.js,msgbox/msgbox.js,jquery.colorpicker.js,common.js,choose.js,product.js,uploadify/uploadify.js')}

    <style>
        .con-one .s-item .lb-tit{ float: none;}

    </style>
</head>
<body >
   <div class="s-main">
       <div class="s-list">
           <div class="con-one">
               <a href="javascript:;" class="all-btn">分类</a>
               <div class="clear-both"></div>
           </div>
           <div class="con-one" step="1">
               <ul>
                   <li>
                       {loop $kind $k $v}
                       <span class="dest-item" id="item_37" pid="0"><label class="lb-tit ">{$v['kindname']}</label><a class="lb-num num-len{strlen($v['count'])}" href="javascript:;" data-rel="{$v['id']}">{$v['count']}</a></span>
                       {if ($k+1)%4==0}
                       <div class="clear-both"></div>
                   </li><li>
                       {/if}
                       {/loop}
                       <div class="clear-both"></div>
                   </li>

               </ul>
           </div>
       </div>
       <div class="save-con">
           <a href="javascript:;" class="confirm-btn">确定</a>
       </div>
   </div>
<script>
    var id="{$id}";
    var selector="{$selector}";
    var distributor='{$distributorArr}'
    $(function() {
       setTimeout(function(){
          ST.Util.resizeDialog('.s-main');
       },0);
    $(document).on('click','.confirm-btn',function(){
        var ele=$(".main-body .i-box:checked");
        var id=$(ele).val();
        var distributorname=$(ele).siblings('.lb-tit').text();
        var data=(typeof(id)=='undefined')?'':[{id:id,distributorname:distributorname}];
        ST.Util.responseDialog({id:id,selector:selector,data:data},true);

    })
    $(document).on('click','.lb-num',function(){
        var step=$(this).parents('.con-one:first').attr('step');
        var pid=$(this).attr('data-rel');
        var nextStep=parseInt(step)+1;
        getNextDests(pid,nextStep);
    })
    function getNextDests(pid,step,keyword)
    {
        var url=SITEURL+'distributor/ajax_distributor_kindid';
        var rowNum=4;
        $.ajax({
            type: "post",
            url: url,
            dataType:'json',
            data:{pid:pid,keyword:keyword},
            success: function(data, textStatus){
                var oldStep=parseInt(step);
                $(".s-list .con-one").each(function(index,element){
                    var oneStep=$(element).attr('step');
                    oneStep=parseInt(oneStep);
                    if(oneStep>=oldStep)
                        $(element).remove();
                });//console.log(data['nextlist']);
                if(typeof(data)=='object') {
                    var html = "<div class='con-one main-body' step='" + step + "'><ul>";
                    var lastIndex=0;
                    var totalCount=data['nextlist'].length;
                    for(var i in data['nextlist'])
                    {
                        if(i%rowNum==0)
                        {
                            html+="<li>";
                            lastIndex=parseInt(rowNum)+parseInt(i)-1;
                        }
                       var row=data['nextlist'][i];
                        var check=distributor==row['id']?'checked="checked"':'';
                        html+='<span class="s-item" id="item_'+row['id']+'" pid="'+pid+'"><input type="radio" '+check+' name="distributor" class="i-box" value="'+row['id']+'"/> <label class="lb-tit">'+row['distributorname']+'</label></span>';
                        if(i==lastIndex||i==totalCount-1)
                        {
                            html+="<div class='clear-both'></div></li>"
                        }

                    }
                    html+='</ul></div>';
                    $('.s-list').append(html);
                }
                ST.Util.resizeDialog('.s-main');

            },
            error: function(){

            }
        });

    }
    })
</script>

</body>
</html>