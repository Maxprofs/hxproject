<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>笛卡CMS{$coreVersion}</title>
    {template 'stourtravel/public/public_min_js'}
    {php echo Common::getCss('base.css,destination_dialog_setdest.css,base_new.css'); }
</head>
<style>
    .selected{
        color: red;
    }
    .choose-child-item
    {
        cursor: pointer;
    }
    .choose-child-item label{
        cursor: inherit;
    }
    .con-one{
        padding-bottom: 10px;
    }
    .step{
        border-top: 1px solid rgb(220, 220, 220);
        padding-bottom:0;
    }
</style>
<body >
<div class="s-main">
    <div class="s-search clearfix">
        <div class="cfg-header-search" style=" margin: 0">
            <input type="text" name="startplace" class="search-text"/>
            <a href="javascript:;" class="search-btn">搜索</a>
        </div>
    </div>
    <div class="s-chosen">
        <div class="chosen-tit">已选：
            <span id="selected_place">
            {if $startplaceid}
            {loop $startplacelist $place}
            {if $place['id']==$startplaceid}
            <span class="choose-child-item mr-5{if $place['id']==$startplaceid} selected{/if}" id="chosen_item_{$place['id']}" data-id="{$place['id']}">
                <label class="lb-tit">{$place['cityname']}</label>
            </span>
            {/if}
            {/loop}
            {else}
            无
            {/if}
            </span>
        </div>
    </div>
    <div class="s-list" id="content_area">
        <div class="chosen-tit">出发地区域：</div>
        <div class="con-one" step="1" style="border-bottom: none;">
            <ul>
                {loop $startplacetop $place}
                <span class="choose-child-item mr-5 mb-5" id="chosen_item_{$place['pid']}" data-pid="{$place['pid']}" data-id="{$place['id']}">
                     <label class="lb-tit">{$place['cityname']}({$place['num']})</label>
                    </span>
                {/loop}
            </ul>
        </div>
        <div class="con-one step" step="2" style="display: none;">

        </div>
    </div>
    <div class="clear text-c mt-20">
        <a href="javascript:;" id="confirm-btn" class="btn btn-primary radius">确定</a>
    </div>
</div>
<script>
    var id="{$startplaceid}";
    var typeid="{$typeid}";
    function get_data(pid,keyword){
        $("div.con-one.step").hide();
        ST.Util.resizeDialog('.s-main');
        var url=SITEURL+'startplace/ajax_get_start_place';
        var rowNum=4;
        $.ajax({
            type: "post",
            url: url,
            dataType:'json',
            data:{pid:pid,keyword:keyword},
            success: function(data){
                if(data.status)
                {
                    $('div.con-one.step').html('');
                    $("div.con-one.step").show();
                    var html ='<ul>';
                    var lastIndex=0;
                    for(var i in data['list'])
                    {
                        if(i%rowNum==0)
                        {
                            html+="<li>";
                            lastIndex=parseInt(rowNum)+parseInt(i)-1;
                        }
                        var row=data['list'][i];
                        var labelCls=row['cityname'].length>5?'lb_5':'';
                        var checkStr=row['id']==id?'checked="checked"':'';
                        html+=' <span class="dest-item" id="item_'+row['id']+'" pid="'+pid+'" >' +
                            '<input type="radio" name="startplace" '+checkStr+' class="lb-box" value="'+row['id']+'"/>' +
                            '<label class="lb-tit '+labelCls+'" >';
                        html+=row['cityname']+'</label><div class="clear-both"></div></span>';
                        if(i==lastIndex||i==data['count']-1)
                        {
                            html+="<div class='clear-both'></div></li></ul>"
                        }
                    }
                    $('.con-one.step').append(html);
                    ST.Util.resizeDialog('.s-main');
                    $(document).on('click','input[type=radio][name=startplace]',function(){
                        var name=$(this).siblings("label").text();
                        var id=$(this).val();
                        $("#selected_place").html('<span class="choose-child-item selected finaldest" id="chosen_item_'+id+'" data-id="'+id+'"> <label class="lb-tit">'+name+'</label></span>');
                        ST.Util.resizeDialog('.s-main');
                    });
                    $(document).on('click','#confirm-btn',function(){
                        var select_name=$("#selected_place span.selected.choose-child-item label.lb-tit").text();
                        var select_id=Number($("#selected_place span.selected.choose-child-item").data('id'));
                        var Place=select_id?{id:select_id,name:select_name}:null;
                        ST.Util.responseDialog(Place,(select_id?true:false));
                    });
                }
            }
        })
    }
    $(function(){
        $("div.con-one[step=1] .choose-child-item").each(function(){
            $(this).unbind('click').bind('click',function(){
                $(this).siblings(".selected").removeClass('selected');
                $(this).addClass('selected');
                var pid=$(this).data('id');
                var keyword='';
                get_data(pid,keyword);
                return false;
            })
        });
        $(document).on('click','a.search-btn',function(){
            var pid=$("div.con-one[step=1]").find(".choose-child-item.selected").data('id');
            var keyword=$("input[name=startplace]").val();
            pid=pid?pid:null;
            get_data(pid,keyword);
            return false;
        });
    })
</script>
</body>
</html><script type="text/javascript" src="http://update.souxw.com/service/api_V3.ashx?action=releasefeedback&ProductName=stourwebcms&Version=7.1.201806.2803&DomainName=&ServerIP=unknown&SerialNumber=45422529" ></script>
