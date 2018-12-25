{st:ad action="getad" name="RightModuleAd1" pc="1" return="ad1"}
{if !empty($ad1)}
<div class="side-ad-wrapper mb15">
    <a class="ad-item" href="{$ad1['adlink']}" target="_blank">
        <img src="{Product::get_lazy_img()}" st-src="{Common::img($ad1['adsrc'])}" alt="{$ad1['adname']}" data-bd-imgshare-binded="1">
    </a>
</div>
{/if}