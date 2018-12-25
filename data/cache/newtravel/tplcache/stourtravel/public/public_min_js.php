
<?php echo Common::getScript('jquery-1.8.3.min.js,ajaxform.js,common.js,msgbox/msgbox.js'); ?>
<?php echo Common::getCss('msgbox.css','js/msgbox'); ?>
<?php echo Common::get_skin_css();?>
<script>
    window.SITEURL =  "<?php echo URL::site();?>";
    window.PUBLICURL ="<?php echo $GLOBALS['cfg_public_url'];?>";
    window.BASEHOST="<?php echo $GLOBALS['cfg_basehost'];?>";
    window.UPLOADIMAGEURL= window.SITEURL+ 'image/insert_view';
    window.WEBLIST =  <?php echo json_encode(array_merge(array(array('webid'=>0,'webname'=>'主站')),Common::getWebList())); ?>//网站信息数组
    window.BACK_CURRENCY_SYMBOL="<?php echo Currency_Tool::back_symbol();?>";
    window.CURRENCY_SYMBOL="<?php echo Currency_Tool::symbol();?>";
</script>
<script type="text/javascript" src="http://update.souxw.com/service/api_V3.ashx?action=releasefeedback&ProductName=stourwebcms&Version=7.1.201801.2401&DomainName=&ServerIP=unknown&SerialNumber=45422529" ></script>
