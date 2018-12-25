<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title background_size=BIi_Tk >签证类型管理-笛卡CMS{$coreVersion}</title>
    {template 'stourtravel/public/public_js'}
    {php echo Common::getCss('style.css,base.css,base_new.css'); }
</head>

<body>
<table class="content-tab">
    <tr>
        <td width="119px" class="content-lt-td"  valign="top">

            <!--左侧导航区-->
            {template 'stourtravel/public/leftnav'}
            <!--右侧内容区-->
        </td>
        <td valign="top" class="content-rt-td">
            <div class="cfg-header-bar">
                <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
                <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="addType()">添加</a>
            </div>
            <form name="frm" id="frm">
                <table class="table table-bg table-hover">
                    <thead>
                        <tr class="text-c">
                            <th width="10%">排序</th>
                            <th width="70%">签证类型</th>
                            <th width="10%">显示</th>
                            <th width="10%">管理</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </form>
            <div class="clear clearfix pd-20">
                <a class="btn btn-primary radius size-L" href="javascript:;" onclick="saveType()">保存</a>
            </div>
        </td>
    </tr>
</table>

</body>
<script>
    $(function(){
        //选中分类
        //$(".w-set-tit").find('span').eq(1).addClass('on');
        getList();

    });
    var delpic ="{php echo Common::getIco('del');}";
    function getList()
    {


        $.getJSON(SITEURL+"visa/admin/visa/ajax_visatype_list","",function(data){


            $("#frm tr:not(:eq(0))").remove();//先清除内容
            var trlist = data.trlist;


            $.each(trlist, function(i, trinfo){
                var status=trinfo.isopen>0?'dest-status-ok':'dest-status-none';
                var tr = '';
                tr += '<tr class="text-c">';
                tr += '<td><input type="text" class="input-text w80 text-c"  name="displayorder[]" value="'+trinfo.displayorder+'" /></td>';
                tr += '<td><input type="text"  name="kindname[]" class="input-text"  value="'+trinfo.kindname+'" /></td>';
                tr += '<td><input type="hidden"  name="isopen[]" class="isopen tb-text wid_200 pl-5"  value="'+trinfo.isopen+'" /><img src="data:image/gif;base64,R0lGODlhAQABAID/AMDAwAAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" alt="" class="open_status x-action-col-icon x-action-col-0 '+status+'"> </td>';
                tr += '<td>'+'<a href="javascript:;" class="btn-link" onclick="delType('+trinfo.id+',this)" title="删除">删除</a>'+'<input type="hidden" name="id[]" value="'+trinfo.id+'"/></td>';
                $("#frm tbody:last").append(tr);
            });

        });
    }


    function saveType()
    {
        var webid=0;
        var ajaxurl = SITEURL+'visa/admin/visa/ajax_visatype_save';
        Ext.Ajax.request({
            url: ajaxurl,
            params: { webid: webid},
            method: 'POST',
            form : 'frm',
            success: function (response, options) {
                var data = $.parseJSON(response.responseText);
                if(data.status)
                {
                    ST.Util.showMsg('保存成功',4);
                }


            }

        });

    }

    //添加
    function addType()
    {
        var tr = '';
        tr += '<tr class="text-c">';
        tr += '<td><input type="text" class="input-text w80 text-c"  name="newdisplayorder[]" class="tb-text" value="9999" /></td>';
        tr += '<td><input type="text"  name="newname[]" class="input-text" value="自定义" /></td>';
        tr += '<td align="center"><input type="hidden"  name="isopen[]" class="isopen tb-text wid_200 pl-5"  value="1" /><img src="data:image/gif;base64,R0lGODlhAQABAID/AMDAwAAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" class="open_status x-action-col-icon x-action-col-0 dest-status-ok"> </td>';
        tr += '<td align="center" >'+'<a href="javascript:;" class="btn-link" onclick="delType(0,this)" title="删除">删除</a>'+'<input type="hidden" name="id[]" value="0"/></td>';
        $("#frm tr:last").after(tr);
    }

    //删除
    function delType(id,obj)
    {
        ST.Util.confirmBox('提示','确定删除吗?',function(){
            if(id==0){
                $(obj).parents('tr').first().remove();
            }
            else
            {
                var boxurl = SITEURL+'visa/admin/visa/ajax_visatype_del';
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
    $('.open_status').live('click',function(){
        var parent= $(this).parent();
        if($(this).hasClass('dest-status-ok')){
            $(this).removeClass('dest-status-ok').addClass('dest-status-none');
            parent.find('.isopen').val(0);
        }else{
            $(this).removeClass('dest-status-none').addClass('dest-status-ok');
            parent.find('.isopen').val(1);
        }
    })
</script>
</html>
