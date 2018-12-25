<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>笛卡CMS{$coreVersion}</title>
    {template 'stourtravel/public/public_min_js'}
    {php echo Common::getCss('base.css,base_new.css,style.css'); }

    <style>
        .container-page .item-hd{
            width: 60px !important;
        }
        .container-page .item-bd{
            padding-left: 30px !important;
        }
        .container-page .info-item-block
        {
            padding: 0 !important;
        }

    </style>
</head>
<body>
            <div class="container-page" id="item_template">
                <ul class="info-item-block">
                    <li>
<!--                        <span class="item-hd"></span>-->
                        <div class="item-bd">
                            {loop $templatelist $tpl}

                            <a  class="{if ($tpl['pagepath']==$info['templetpath']&&$webtype=='pc')||($tpl['pagepath']==$info['wap_templetpath']&&$webtype=='web')}label-module-cur-item {else}label-module-item{/if}  mr-5 mb-5"  href="javascript:void(0)" data-type="templet" data-title="{$tpl['title']}" data-value="{$tpl['pagepath']}" onclick="setTemplet(this)">{$tpl['title']}</a>
                            {/loop}
                        </div>

                    </li>
                </ul>
                <div class="clearfix text-c mt-20">
                    <a href="javascript:;" id="cancel-btn" class="btn btn-grey-outline  radius">取消</a>
                    <a href="javascript:;" class="btn btn-primary radius ml-10">确定</a>
                </div>
                <form id="submit_frm">
                    <input type="hidden" name="kindid" value="{$info['kindid']}">
                    <input type="hidden" name="webtype" id="webtype" value="{$webtype}">
                    <input type="hidden" name="templetpath" value="{$info['templetpath']}">
                    <input type="hidden" name="wap_templetpath" value="{$info['wap_templetpath']}">
                    <input type="hidden" name="templet_name" value="">
                    <input type="hidden" name="wap_templet_name" value="">
                <form>

            </div>

</body>
<script>

    $(function () {

        //确定
        $('.btn-primary').click(function () {
            var obj = $('.label-module-cur-item');
            var path = $(obj).data('value');
            var title = $(obj).data('title');
            var webtype = $('#webtype').val();
            if(webtype=='wap')
            {
                $('input[name=wap_templetpath]').val(path);
                $('input[name=wap_templet_name]').val(title);
            }
            else if(webtype=='pc')
            {
                $('input[name=templetpath]').val(path);
                $('input[name=templet_name]').val(title);
            }

            var data = $('#submit_frm').serialize();
            ST.Util.responseDialog({data:data},true);
        });
        //取消
        $('#cancel-btn').click(function () {
            ST.Util.responseDialog({},false);
        })

    });


    function setTemplet(obj) {
        $('.info-item-block a').removeClass('label-module-cur-item');
        $('.info-item-block a').addClass('label-module-item');
        $(obj).addClass('label-module-cur-item');

    }

</script>
</html>
