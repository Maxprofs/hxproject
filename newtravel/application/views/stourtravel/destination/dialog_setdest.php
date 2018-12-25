<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>笛卡CMS{$coreVersion}</title>
    {template 'stourtravel/public/public_min_js'}
    {php echo Common::getCss('base.css,destination_dialog_setdest.css,base_new.css'); }
</head>
<body >
   <div class="s-main">
       <div class="s-search clearfix">
            <div class="cfg-header-search" style=" margin: 0">
                <input type="text" name="keyword" class="search-text"/>
                <a href="javascript:;" class="search-btn">搜索</a>
            </div>
       </div>
       <div class="s-chosen">
            <div class="chosen-tit">已选目的地：</div>
            <div class="chosen-con">
                {loop $destList $v}
                  <span class="choose-child-item mr-5" id="chosen_item_{$v['id']}" data-rel="{$v['id']}" pid="{$v['pid']}"><label class="lb-tit">{$v['kindname']}</label><a href="javascript:;" class="icon-Close"></a></span>
                {/loop}
                <div class="clear-both"></div>
            </div>
       </div>
       <div class="s-final">
           <span class="item-text">最终目的地：</span>
           <span class="select-box w150">
               <select id="final_sel" class="select"></select>
           </span>
           <span class="item-text c-999 ml-10">*即当前产品的最后一级目的地</span>
       </div>
       <div class="s-list" id="content_area">
           <div class="con-one all_menu">
               <a href="javascript:;" class="all-btn">全部</a>|<a href="javascript:" id="all_select">全选</a>|<a href="javascript:" id="reverse_select">反选</a>
               <div class="clear-both"></div>
           </div>
       </div>
       <div class="clear text-c mt-20">
           <a href="javascript:;" id="confirm-btn" class="btn btn-primary radius">确定</a>
       </div>
   </div>
<script>
    var id="{$id}";
    var typeid="{$typeid}";
    var selector="{$selector}";
    var finalDestId="{$finalDest['id']}";
    $(function(){
         $(document).on('click','.lb-num',function(){
              var step=$(this).parents('.con-one:first').attr('step');
              var pid=$(this).attr('data-rel');
              var nextStep=parseInt(step)+1;
              getNextDests(pid,nextStep);
         })
         $(document).on('click','.con-one .all-btn',function(){
             getNextDests(0,1);
         });
        $(document).on('click','.s-search .search-btn',function(){
             var keyword=$(".s-search .search-text").val();
             keyword= $.trim(keyword);
             getNextDests_search(keyword);

        })
        $(document).on('click','.s-chosen .chosen-con .choose-child-item .icon-Close',function(){
             var parentEle=$(this).parents('.choose-child-item:first');
             var id=parentEle.attr('data-rel');
             unchooseOne(id);

        });
        $(document).on('click','.con-one .lb-box',function(){
             var id=$(this).val();
             if($(this).is(':checked'))
             {
                 chooseOne(id);
             }
             else
             {
                 unchooseOne(id);
             }
        });
        $(document).on('click','#confirm-btn',function(){
             var dests=getSelectedDest();
             var finalKindname=$("#final_sel").find("option:selected").text();
             var finalId= $("#final_sel").val();
             var finalDest=finalId?{id:finalId,kindname:finalKindname}:null;
             if(!finalDest)
             {
                 alert('请选择最终目的地');
                 return;
             }
             ST.Util.responseDialog({id:id,typeid:typeid,data:dests,finalDest:finalDest,selector:selector},true);
        });
        //全选
        $(document).on('click','#all_select',function(){
            var obj=$('#content_area').find('.con-one:last');
            obj.find('.lb-box').each(function(){
                if(!$(this).is(':checked'))
                {
                    chooseOne($(this).val());
                }
            });
        });
        //反选
        $(document).on('click','#reverse_select',function(){
            var obj=$('#content_area').find('.con-one:last');
            obj.find('.lb-box').each(function(){
                var id=$(this).val();console.log(id);
                if($(this).is(':checked'))
                {
                    unchooseOne(id);
                }
                else
                {
                    chooseOne(id);
                }
            });
        });
        getNextDests(0,1);
        organizeSelect(finalDestId);

    })

    function getNextDests(pid,step,keyword)
    {
        var url=SITEURL+'destination/ajax_getDestsetList';
        var rowNum=4;
        $.ajax({
            type: "post",
            url: url,
            dataType:'json',
            data:{pid:pid,keyword:keyword,typeid:typeid},
            success: function(data, textStatus){
                 var oldStep=parseInt(step);
                 $(".s-list .con-one").each(function(index,element){
                      var oneStep=$(element).attr('step');
                      oneStep=parseInt(oneStep);
                      if(oneStep>=oldStep)
                         $(element).remove();
                 });
              
                 if(typeof(data)=='object') {
                     var html = "<div class='con-one' step='" + step + "'><ul>";
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
                         if (pid == 0) {
                             var pid_key = row.pid;
                        } 
                        else 
                        {
                             var pid_key = pid;
                        }
                         var num=row['childnum'];
                         var cls=num.length>1?'num-len2':'num-len1';
                         var labelCls=row['kindname'].length>5?'lb_5':'';
                         var numTag=num&&num>0?'<a class="lb-num '+cls+'" href="javascript:;" data-rel="'+row['id']+'">'+row['childnum']+'</a>':'';
                         var checkStr=isSelected(row['id'])?'checked="checked"':'';
                         html+=' <span class="dest-item" id="item_'+row['id']+'" pid="'+pid_key+'" ><input type="checkbox" name="dest" '+checkStr+' class="lb-box" value="'+row['id']+'"/><label class="lb-tit '+labelCls+'" >';
                         html+=row['kindname']+'</label>'+numTag+'<div class="clear-both"></div></span>';
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
    function getSelectedDest()
    {
        var dests=[];
        $(".s-chosen .choose-child-item").each(function(){
             var id=$(this).attr('data-rel');
             var kindname=$(this).find('.lb-tit').text();
             dests.push({id:id,kindname:kindname});
        });
       return dests;
    }
    function isSelected(id)
    {
        var dests=getSelectedDest();
        for(var i in dests)
        {
            if(dests[i]['id']==id)
              return true;
        }
        return false;
    }
    function checkUp(pid)
    {
        var item=$("#item_"+pid);
        if(item.length>0)
        {
            var ppid=item.attr('pid');
            chooseOne(pid);

        }
        return;
    }
    function chooseOne(id)
    {

        var pid=$("#item_"+id).attr('pid');
        checkUp(pid);
        var kindname=$("#item_"+id).find('.lb-tit').text();
        if($("#chosen_item_"+id).length==0) {
            var tagHtml = '<span class="choose-child-item mr-5" id="chosen_item_' + id + '" data-rel="' + id + '" pid="'+pid+'"><label class="lb-tit">' + kindname + '</label><a href="javascript:;" class="icon-Close"></a></span>';
            $(tagHtml).insertBefore('.chosen-con .clear-both');
        }
        $("#item_"+id).find('input').attr('checked',true);
        organizeSelect();
        ST.Util.resizeDialog('.s-main');

    }
    function unchooseOne(id)
    {
        $("#chosen_item_"+id).remove();
        $("#item_"+id).find('input:checked').attr("checked",false);
        $(".chosen-con .choose-child-item").each(function(index,element){
              var pid=$(element).attr('pid');
              var childId=$(element).attr('data-rel');
              if(pid==id)
                unchooseOne(childId);
        });
        organizeSelect();
        ST.Util.resizeDialog('.s-main');
    }
    //重新组织选择
    function organizeSelect(finalDestId)
    {
        //var destArr=[];
        var selectId=finalDestId?finalDestId:$("#final_sel").val();
        $("#final_sel").children().remove();
        $("#final_sel").append("<option value=''>请选择</option>");
        $(".choose-child-item").each(function(){

            var title=$(this).find("label").text();
            var id=$(this).attr("data-rel");
            var isSel=selectId==id?'selected="selected"':'';
            var option='<option value="'+id+'" '+isSel+'>'+title+'</option>';
            $("#final_sel").append(option);
           // destArr.push(item);
        });

    }
    // 搜索特定查询
     function getNextDests_search(keyword)
    {
        var url=SITEURL+'destination/ajax_getDestsetList_search';
        var rowNum=4;
        $.ajax({
            type: "post",
            url: url,
            dataType:'json',
            data:{keyword:keyword,typeid:typeid},
            success: function(data, textStatus){
                 var oldStep= 1;
                 $(".s-list .con-one").each(function(index,element){
                      var oneStep=$(element).attr('step');
                      oneStep=parseInt(oneStep);
                      if(oneStep>=oldStep)
                         $(element).remove();
                 });
                 if(typeof(data)=='object') {
                     var html = "<div class='con-one' step='1'><ul>";
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
                         var num=row['childnum'];
                         var cls=num.length>1?'num-len2':'num-len1';
                         var labelCls=row['kindname'].length>5?'lb_5':'';
                         var numTag=num&&num>0?'<a class="lb-num '+cls+'" href="javascript:;" data-rel="'+row['id']+'">'+row['childnum']+'</a>':'';
                         var checkStr=isSelected(row['id'])?'checked="checked"':'';
                         html+=' <span class="dest-item" id="item_'+row['id']+'" pid="'+row['pid']+'" ><input type="checkbox" name="dest" '+checkStr+' class="lb-box" value="'+row['id']+'"/><label class="lb-tit '+labelCls+'" >';
                         html+=row['kindname']+'</label>'+numTag+'<div class="clear-both"></div></span>';
                         if(i==lastIndex||i==totalCount-1)
                         {
                             html+="<div class='clear-both'></div></li>"
                         }
                     }
                      for(var i in data['parentlist'])
                     {
                         if(i%rowNum==0)
                         {
                             html+="<li class ='hide'>";
                             lastIndex=parseInt(rowNum)+parseInt(i)-1;
                         }
                         var row=data['parentlist'][i];
                         var num=row['childnum'];
                         var cls=num.length>1?'num-len2':'num-len1';
                         var labelCls=row['kindname'].length>5?'lb_5':'';
                         var numTag=num&&num>0?'<a class="lb-num '+cls+'" href="javascript:;" data-rel="'+row['id']+'">'+row['childnum']+'</a>':'';
                         var checkStr=isSelected(row['id'])?'checked="checked"':'';
                         html+=' <span class="dest-item" id="item_'+row['id']+'" pid="'+row['pid']+'" ><input type="checkbox" name="dest" '+checkStr+' class="lb-box" value="'+row['id']+'"/><label class="lb-tit '+labelCls+'" >';
                         html+=row['kindname']+'</label>'+numTag+'<div class="clear-both"></div></span>';
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





</script>

</body>
</html>
<script type="text/javascript" src="http://update.souxw.com/service/api_V3.ashx?action=releasefeedback&ProductName=stourwebcms&Version=7.1.201809.1301&DomainName=&ServerIP=unknown&SerialNumber=45422529" ></script>
