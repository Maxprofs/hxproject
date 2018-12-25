<div class="cfg-header-tab">
    <span class="item {if $chooseid==attr_attr} on {/if}"    data-id="attr_attr"  onclick="changeTab(this)" >属性分类</span>
    <span class="item {if $chooseid==attr_price} on {/if}"  data-id="attr_price"  onclick="changeTab(this)"  >价格属性</span>
    <span class="item {if $chooseid==attr_day} on {/if}"    data-id="attr_day"  onclick="changeTab(this)" >天数属性</span>
    <span class="item {if $chooseid==attr_Numconfig} on {/if}" data-id="attr_Numconfig"  onclick="changeTab(this)" >显示分类数量</span>
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
                   url += 'line/admin/attrid/list/menuid/{$_GET['menuid']}';
                   break;
               case 'attr_price':
                   url += 'line/admin/line/price/menuid/{$_GET['menuid']}';
                   break;
               case 'attr_day':
                   url += 'line/admin/line/day/menuid/{$_GET['menuid']}';
                   break;
               case 'attr_Numconfig':
                   url += 'line/admin/attrid/attr_num_config/menuid/{$_GET['menuid']}';
                   break;
           }
           location.href = url;

    }
</script>