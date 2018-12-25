<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>门票类型管理-笛卡CMS{$coreVersion}</title>
    {template 'stourtravel/public/public_js'}
    {php echo Common::getCss('style.css,base_new.css'); }
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
                <!--右侧内容区-->
                <div class="content-nr">
                        <div class="w-set-con">
                            <div class="cfg-header-bar">
                                <div class="cfg-header-tab">
                                    {template 'admin/spot/ticket_top'}
                                </div>
                                <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
                            </div>
                            <div class="w-set-nr">

                                <div class="add_menu-btn ml10">
                                    <a href="javascript:;" class="add-btn-class" onclick="add_ticket_type()">添加</a>
                                </div>

                                <div class="table-div-b-m ml10">
                                    <form name="frm" id="frm">
                                        <table  border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <th scope="col" height="40" class="w100">排序</th>
                                                <th scope="col" align="left" class="w200"><span class="fl">门票类型</span></th>
                                                <th scope="col" class="w100">管理</th>
                                            </tr>
                                        </table>
                                        <input type="hidden" name="spotid" id="spotid" value="{$spotid}"/>
                                    </form>
                                </div>

                                <div class="opn-btn">
                                    <a class="save btn_save" href="javascript:;" onclick="save()">保存</a>
                                </div>

                            </div>
                        </div>
                </div>
            </td>
        </tr>
    </table>

</body>
<script>
    $(function(){
        //选中分类
        $(".cfg-header-bar").find('span').eq(1).addClass('on');
        getList();

    })
    var delpic ="{php echo Common::getIco('del');}";
    function getList()
    {
        var spotid=$("#spotid").val();

        $.getJSON(SITEURL+"spot/admin/spot/ajax_tickettype_list","spotid="+spotid,function(data){

            $("#frm tr:not(:eq(0))").remove();//先清除内容
            var trlist = data.trlist;


            $.each(trlist, function(i, trinfo){
                var tr = '';
                tr += "<tr>";
                tr += '<td height="40" align="center"><input type="text" class="zs_text set-text-xh w100"  name="displayorder[]" class="tb-text" value="'+trinfo.displayorder+'" /></td>';
                tr += '<td><input type="text"  name="kindname[]" class="tb-text w200 ml-5"  value="'+trinfo.kindname+'" /></td>';
                tr += '<td align="center" onclick="del('+trinfo.id+',this)">'+delpic+'<input type="hidden" name="id[]" value="'+trinfo.id+'"/></td>';
                $("#frm tr:last").after(tr);
            });
        });
    }


    function save()
    {
        var webid=0;
        var ajaxurl = SITEURL+'spot/admin/spot/ajax_tickettype_save';
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
    function add_ticket_type()
    {

        var tr = '';
        tr += "<tr>";
        tr += '<td height="40" align="center"><input type="text" class="zs_text set-text-xh w100"  name="newdisplayorder[]" class="tb-text" value="9999" /></td>';
        tr += '<td><input type="text"  name="newname[]" class="tb-text w200 ml-5" value="自定义" /></td>';
        tr += '<td align="center" onclick="del(0,this)">'+delpic+'<input type="hidden" name="id[]" value="0"/></td>';
        $("#frm tr:last").after(tr);



    }

    //删除
    function del(id,obj)
    {
        ST.Util.confirmBox('删除门票分类','确定删除吗?',function(){
            if(id==0){
                $(obj).parents('tr').first().remove();
            }
            else
            {
                var boxurl = SITEURL+'spot/admin/spot/ajax_tickettype_del';
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
