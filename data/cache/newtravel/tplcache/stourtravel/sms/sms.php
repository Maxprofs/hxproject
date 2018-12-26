<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title color_background=zm8iDl >笛卡CMS<?php echo $coreVersion;?>短信接口</title>
    <?php echo  Stourweb_View::template('stourtravel/public/public_min_js');  ?>
    <?php echo Common::getCss('style.css,base.css,base2.css,upgrade.css,base_new.css'); ?>
</head>
<body>
    <table class="content-tab">
        <tr>
            <td width="119px" class="content-lt-td" valign="top">
                <?php echo  Stourweb_View::template('stourtravel/public/leftnav');  ?>
                <!--右侧内容区-->
            </td>
            <td valign="top" class="content-rt-td" style="overflow:auto;">
                <div class="cfg-header-bar">
                    <div class="cfg-header-tab">
                        <?php $n=1; if(is_array($providerlist)) { foreach($providerlist as $provider) { ?>
                        <span class="item <?php if($n <= 1) { ?>on<?php } ?>
" data-providerid="<?php echo $provider['id'];?>" data-providercfgurl="<?php echo $provider['config_url'];?>" ><s></s><?php echo $provider['name'];?></span>
                        <?php $n++;}unset($n); } ?>
                    </div>
                    <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
                </div>
                <div class="manage-nr">
                    <div class="version_sj">
                        <div class="version_list" style=" height: 845px">
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    </table>
<script language="JavaScript">
var public_url = "<?php echo $GLOBALS['cfg_public_url'];?>";
var basehost = "<?php echo $GLOBALS['cfg_basehost'];?>";
$(function () {
    //切换
    $('.cfg-header-tab').find('span').click(function () {
        var providerid = $(this).attr('data-providerid');
        var providercfgurl = basehost + $(this).attr('data-providercfgurl')+"?provider_id="+providerid;
        var html = "<iframe src='" + providercfgurl  + "' width='100%' height='100%' frameborder='0px'></iframe>";
        $(this).addClass('on').siblings().removeClass('on');
        $(".version_list").html(html);
    })
    $('.cfg-header-tab .on').trigger("click");
})
</script>
</body>
</html>
