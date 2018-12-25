<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>酒店星级管理-笛卡CMS{$coreVersion}</title>
    {template 'stourtravel/public/public_min_js'}
    {php echo Common::getCss('style.css,base.css,base_new.css'); }
</head>

<body>
<table class="content-tab" margin_html=mxACXC >
    <tr>
        <td width="119px" class="content-lt-td"  valign="top">

            <!--左侧导航区-->
            {template 'stourtravel/public/leftnav'}
            <!--右侧内容区-->
        </td>
        <td valign="top" class="content-rt-td">
                    
            <div class="cfg-header-bar">
                {template 'admin/hotel/kind_top'}
                <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
                <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="add()">添加</a>
            </div>
            <form name="rankfrm" id="rankfrm">
                <table class="table table-bg table-hover" width="100%" border="0" cellspacing="0" cellpadding="0">
                	<thead>
                		<tr>
                            <th class="text-l" scope="col" width="10%"><span class="pl-10">排序</span></th>
                            <th class="text-l" scope="col" width="80%"><span class="fl">星级分类</span><div class="help-ico mh-k">{php echo Common::getIco('help',13); }</div></th>
                            <th class="text-r" scope="col" width="10%"><span class="pr-20">管理</span></th>
                        </tr>
                	</thead>  
                </table>
            </form>
            <div class="clear pb-20">
                <a class="btn btn-primary radius size-L mt-20 ml-20" href="javascript:;" onclick="save()">保存</a>
            </div>

        </td>
    </tr>
</table>
<input type="hidden" name="webid" id="webid" value="0"/>
</body>
<script>
    $(function(){
        //选中星级分类
        $(".w-set-tit").find('span').eq(1).addClass('on');
        getRankList();

    })
    var delpic ="{php echo Common::getIco('del');}";
    function getRankList()
    {
        var webid=$("#webid").val();

        $.getJSON(SITEURL+"hotel/admin/hotel/ajax_ranklist","webid="+webid,function(data){

            $("#rankfrm tr:not(:eq(0))").remove();//先清除内容
            var trlist = data.trlist;


            $.each(trlist, function(i, trinfo){
                var tr = '';
                tr += "<tr>";
                tr += '<td class="text-l"><input type="text" class="input-text w60 ml-10"  name="displayorder[]" value="'+trinfo.displayorder+'" /></td>';
                tr += '<td><input type="text"  name="rankname[]" class="input-text w200 pl-5"  value="'+trinfo.rankname+'" /></td>';
                tr += '<td class="text-r"><a href="javascript:;" class="btn-link pr-20" onclick="del('+trinfo.id+',this)" title="删除">删除</a>'+'<input type="hidden" name="id[]" value="'+trinfo.id+'"/></td>';
                $("#rankfrm tr:last").after(tr);
            });
        });
    }

    //星级保存
    function save()
    {
        var webid=0;
        var ajaxurl = SITEURL+'hotel/admin/hotel/ajax_rank_save';
        ST.Util.showMsg('保存中,请稍后...',6,5000);
        $.ajaxform({
            url: ajaxurl,
            data: { webid: webid},
            method: 'POST',
            form : '#rankfrm',
            dataType:'json',
            success: function (data) {
                if(data.status)
                {
                    ST.Util.showMsg('保存成功',4);
                }
            }
        });

    }

    //添加星级
    function add()
    {
        /* $.ajax({
         type:'POST',
         url:SITEURL+'hotel/ajax_rank_add',
         dataType:'json',
         success:function(data){
         if(data.status){
         var tr = '';
         tr += "<tr>";
         tr += '<td height="40" align="center"><input type="text" class="zs_text set-text-xh wid_60"  name="displayorder[]" class="tb-text" value="9999" /></td>';
         tr += '<td><input type="text"  name="newrankname[]" class="tb-text" value="自定义" /></td>';
         tr += '<td align="center" onclick="del(0,this)">'+delpic+'<input type="hidden" name="id[]" value="0"/></td>';
         $("#rankfrm tr:last").after(tr);
         }
         }

         })*/
        var tr = '';
        tr += "<tr>";
        tr += '<td class="text-l"><input type="text" class="input-text w60 ml-10"  name="newdisplayorder[]" value="9999" /></td>';
        tr += '<td><input type="text"  name="newrankname[]"  class="input-text w200 pl-5" value="自定义" /></td>';
        tr += '<td class="text-r">'+'<a href="javascript:;" class="btn-link pr-20" onclick="del(0,this)" title="删除">删除</a>'+'<input type="hidden" name="id[]" value="0"/></td>';
        $("#rankfrm tr:last").after(tr);



    }

    //星级删除
    function del(id,obj)
    {
        ST.Util.confirmBox('删除星级','确定删除吗?',function(){
            if(id==0){
                $(obj).parents('tr').first().remove();
            }
            else
            {
                var boxurl = SITEURL+'hotel/admin/hotel/ajax_rank_del';
                $.getJSON(boxurl,"id="+id,function(data){

                    if(data.status == true){
                        $(obj).parents('tr').first().remove();
                        ST.Util.showMsg('删除成功',4);
                    }
                    else{
                        ST.Util.showMsg('删除失败',5);
                    }

                });
            }

        })
    }

</script>
</html>

