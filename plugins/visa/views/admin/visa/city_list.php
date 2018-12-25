<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head size_font=Bkuokk >
    <meta charset="utf-8">
    <title>签发城市管理-笛卡CMS{$coreVersion}</title>
    {template 'stourtravel/public/public_js'}
    {php echo Common::getCss('style.css,base.css,base_new.css'); }
</head>

<body>

    <table class="content-tab">
        <tr>
            <td width="119px" class="content-lt-td"  valign="top">
                <!--左侧导航区-->
                {template 'stourtravel/public/leftnav'}
            </td>
            <td valign="top" class="content-rt-td">
                <div class="cfg-header-bar">
                    <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
                    <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="addcity()">添加</a>
                </div>
                <form name="frm" id="frm">
                    <table class="table table-bg table-hover">
                        <thead>
                            <tr class="text-c">
                                <th width="10%">排序</th>
                                <th width="70%">签发城市</th>
                                <th width="10%">显示</th>
                                <th width="10%">管理</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>

                </form>
                <div class="clear clearfix pd-20">
                    <a class="btn btn-primary radius size-L" href="javascript:;" onclick="save()">保存</a>
                </div>
            </td>
        </tr>
    </table>

</body>
<script>
    $(function(){
        //选中分类
        //$(".w-set-tit").find('span').eq(3).addClass('on');
        getList();

    })
    var delpic ="{php echo Common::getIco('del');}";
    function getList()
    {


        $.getJSON(SITEURL+"visa/admin/visa/ajax_visacity_list","",function(data){

            $("#frm tr:not(:eq(0))").remove();//先清除内容
            var trlist = data.trlist;


            $.each(trlist, function(i, trinfo){
                var check_str = trinfo['isopen']==1?'checked="checked"':'';
                var tr = '';
                tr += '<tr class="text-c">';
                tr += '<td><input type="text" class="input-text w80 text-c"  name="displayorder[]" value="'+trinfo.displayorder+'" /></td>';
                tr += '<td><input type="text"  name="kindname[]" class="input-text"  value="'+trinfo.kindname+'" /></td>';
                tr += '<td><input type="checkbox" name="isopen[]" value="1" '+check_str+'></td>'
                tr += '<td>'+'<a href="javascript:;" class="btn-link" onclick="del('+trinfo.id+',this)" title="删除">删除</a>'+'<input type="hidden" name="id[]" value="'+trinfo.id+'"/></td>';
                $("#frm tr:last").after(tr);
            });
        });
    }


    function save()
    {
        var webid=0;
        var ajaxurl = SITEURL+'visa/admin/visa/ajax_visacity_save';
        ST.Util.showMsg('保存中,请稍后...',6,5000);
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
    function addcity()
    {

        $.ajax({
            type:'POST',
            url:SITEURL+'visa/admin/visa/ajax_visacity_add',
            dataType:'json',
            success:function(data){
                if(data.status==1){
                    var check_str = data['isopen']==1?'checked="checked"':'';
                    var tr = '';
                    tr += '<tr class="text-c">';
                    tr += '<td><input type="text" class="input-text w80 text-c"  name="displayorder[]" class="tb-text" value="9999" /></td>';
                    tr += '<td><input type="text"  name="kindname[]" class="input-text" value="自定义" /></td>';
                    tr += '<td><input type="checkbox" name="isopen[]" value="1" '+check_str+'></td>'
                    tr += '<td>'+'<a href="javascript:;" class="btn-link" onclick="del('+data.id+',this)" title="删除">删除</a>'+'<input type="hidden" name="id[]" value="'+data.id+'"/></td>';
                    $("#frm tbody:last").append(tr);
                }
                else{
                    ST.Util.showMsg("{__('norightmsg')}",5,1000);
                }
            }
        })






    }

    //删除
    function del(id,obj)
    {
        ST.Util.confirmBox('删除签发城市','确定删除吗?',function(){
            if(id==0){
                $(obj).parents('tr').first().remove();
            }
            else
            {
                var boxurl = SITEURL+'visa/admin/visa/ajax_visacity_del';
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
