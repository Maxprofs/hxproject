<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>订单查看--笛卡CMS{$coreVersion}</title>
    {template 'stourtravel/public/public_min_js'}
    {php echo Common::getCss('style.css,base.css,base_new.css'); }
    {php echo Common::getScript("uploadify/jquery.uploadify.min.js,product_add.js,choose.js,imageup.js"); }
    <style>
        .hide{ display: none;}
    </style>

</head>
<body>

    <table class="content-tab" strong_body=JDACXC >
        <tr>
            <td width="119px" class="content-lt-td"  valign="top">
                {template 'stourtravel/public/leftnav'}
                <!--右侧内容区-->
            </td>
            <td valign="top" class="content-rt-td ">
                <form id="frm" name="frm">
                    <div class="cfg-header-bar">
                        <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
                    </div>
                    <ul class="info-item-block">
                        <li>
                            <span class="item-hd">游记标题：</span>
                            <div class="item-bd">
                                <span class="item-text">{$info['title']}</span>
                            </div>
                        </li>
                        <li>
                            <span class="item-hd">发布时间：</span>
                            <div class="item-bd">
                                <span class="item-text">{php echo Common::myDate('Y-m-d H:i:s',$info['modtime']);}</span>
                            </div>
                        </li>
                        <li>
                            <span class="item-hd">游记顶部图：</span>
                            <div class="item-bd">
                                {if !empty($info['bannerpic'])}<img src="{$info['bannerpic']}" class="up-img-area" />{/if}
                            </div>
                        </li>
                        {if !empty($info['litpic'])}
                        <li>
                            <span class="item-hd">游记封面图：</span>
                            <div class="item-bd">
                                {if !empty($info['litpic'])}<img src="{$info['litpic']}" class="up-img-area" />{/if}
                            </div>
                        </li>
                        {/if}
                        {if !empty($info['description'])}
                        <li>
                            <span class="item-hd">游记描述：</span>
                            <div class="item-bd">
                                <div class="item-section mt-3">{$info['description']}</div>
                            </div>
                        </li>
                        {/if}
                        <li>
                            <span class="item-hd">目的地选择：</span>
                            <div class="item-bd">
                                <a href="javascript:;" class="btn btn-primary radius size-S mt-3" onclick="Product.getDest(this,'.dest-sel',101)"  title="选择">选择</a>
                                <div class="save-value-div mt-2 ml-10 dest-sel">
                                    {loop $info['kindlist_arr'] $k $v}
                                        <span class="choose-child-item {if $info['finaldestid']==$v['id']}c-red finaldest{/if}" title="{if $info['finaldestid']==$v['id']}最终目的地{/if}" >{$v['kindname']}<s class="icon-Close" onclick="$(this).parent('span').remove()"></s><input type="hidden" class="lk" name="kindlist[]" value="{$v['id']}"/>
                                            {if $info['finaldestid']==$v['id']}<input type="hidden" class="fk" name="finaldestid" value="{$info['finaldestid']}"/>{/if}
                                        </span>
                                    {/loop}
                                </div>
                            </div>
                        </li>
                        <li>
                            <span class="item-hd">游记内容：</span>
                            <div class="item-bd">
                                {php Common::getEditor('content',$info['content'],$sysconfig['cfg_admin_htmleditor_width'],400);}
                            </div>
                        </li>
                        <li>
                            <span class="item-hd">游记阅读量：</span>
                            <div class="item-bd">
                                <input class="input-text w100" type="text" name="read_num" value="{$info['read_num']}"/>
                                <span class="item-hd">真实阅读量:{$info['shownum']}</span>
                            </div>
                        </li>
                        <li class="list_dl {if $info['status']!=-1}hide{/if}" id="reason">
                            <span class="item-hd">未通过原因：</span>
                            <div class="item-bd">
                                <input class="input-text w900" type="text" name="reason" value="{$info['reason']}"/>
                            </div>
                        </li>
                        <li>
                            <span class="item-hd">审核状态：</span>
                            <div class="item-bd">
                                <label class="radio-label"><input name="status" type="radio" class="checkbox" value="-1" {if $info['status']==-1}checked="checked"{/if}  />审核未通过</label>
                                <label class="radio-label ml-20"><input name="status" type="radio" class="checkbox" value="0" {if $info['status']==0}checked="checked"{/if}  />待审核</label>
                                <label class="radio-label ml-20"><input name="status" type="radio" class="checkbox" value="1" {if $info['status']==1}checked="checked"{/if}  />审核通过</label>
                            </div>
                        </li>
                    </ul>
                    <div class="clear clearfix pt-5 pb-20">
                        <a class="btn btn-primary radius size-L ml-115" id="btn_save" href="javascript:;">保存</a>
                        <input type="hidden" id="id" name="id" value="{$info['id']}">
                        <input type="hidden" name="title" value="{$info['title']}">
                        <input type="hidden" name="memberid" value="{$info['memberid']}">
                        <input type="hidden" name="issend" value="{$info['issend']}">
                        <input type="hidden" name="jifen" value="30">
                    </div>
                </form>
            </td>
        </tr>
    </table>

<script language="JavaScript">



    $(function(){
        //保存
        $("#btn_save").click(function(){
            if($(".dest-sel input:hidden").length==0)
            {
                ST.Util.showMsg('目的地不能为空', 5);
                return;
            }

            $.ajaxform({
                url   :  SITEURL+"notes/admin/notes/ajax_save",
                method  :  "POST",
                form  : "#frm",
                dataType:'json',
                success  :  function(data)
                {

                    if(data.status)
                    {
                        ST.Util.showMsg('保存成功!','4',2000);

                    }


                }});

        })


    })
    $(function(){
    $('input[name="status"]').change(function(){
        var val=$(this).val();
       if(val==-1){
           $('#reason').removeClass('hide');
       }else{
           $('#reason').addClass('hide');
       }
    });
    });
</script>

</body>
</html>