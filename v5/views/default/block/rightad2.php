{st:ad action="getad" name="RightModuleAd2" pc="1" return="ad2"}
{if !empty($ad2)}
<div class="side-ad-wrapper mb15">
    <a class="ad-item" href="{$ad2['adlink']}" target="_blank">
        <img src="{Product::get_lazy_img()}" st-src="{Common::img($ad2['adsrc'])}" alt="{$ad2['adname']}" data-bd-imgshare-binded="1">
    </a>
</div>
{/if}