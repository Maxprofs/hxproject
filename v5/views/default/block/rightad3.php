{st:ad action="getad" name="RightModuleAd3" pc="1" return="ad3"}
{if !empty($ad3)}
<div class="side-ad-wrapper mb15">
    <a class="ad-item" href="{$ad3['adlink']}" target="_blank">
        <img src="{Product::get_lazy_img()}" st-src="{Common::img($ad3['adsrc'])}" alt="{$ad3['adname']}" data-bd-imgshare-binded="1">
    </a>
</div>
{/if}