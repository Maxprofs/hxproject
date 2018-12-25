<div class="cfg-header-tab">
    <span class="item {if $chooseid==attr_attr} on {/if}"    data-id="attr_attr"  onclick="changeTab(this)" >属性分类</span>
    <span class="item {if $chooseid==attr_price} on {/if}"  data-id="attr_price"  onclick="changeTab(this)"  >价格属性</span>
    <span class="item {if $chooseid==attr_numconfig} on {/if}" data-id="attr_numconfig"  onclick="changeTab(this)" >显示分类数量</span>
</div>
<script>

    function changeTab(obj) {
           if($(obj).hasClass('on'))
           {
               return false;
           }
           var id = $(obj).data('id');
           var url = SITEURL;
           switch (id)
           {
               case 'attr_attr':
                   url += 'spot/admin/attrid/list/menuid/{$_GET['menuid']}';
                   break;
               case 'attr_price':
                   url += 'spot/admin/spot/price/menuid/{$_GET['menuid']}';
                   break;
               case 'attr_numconfig':
                   url += 'spot/admin/attrid/attr_num_config/menuid/{$_GET['menuid']}';
                   break;
           }
           location.href = url;

    }
</script>