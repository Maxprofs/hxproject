
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
