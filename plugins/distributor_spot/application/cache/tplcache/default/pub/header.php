<?php echo $header;?>
<script>
    var SITEURL = "<?php echo $cmsurl;?>";
    $(function(){
        $("#p_spot").addClass('cur').siblings().removeClass('cur');
    })
</script>