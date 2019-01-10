<div class="sidle-module">
    <h3 class="sidle-tit">常用菜单</h3>
    <div class="sidle-con shut-menu">
        <?php $n=1; if(is_array($quickmenu)) { foreach($quickmenu as $v) { ?>
            <a class="config_item item"  href="javascript:;" title="<?php echo $v['path'];?>" data-url="<?php echo $v['menu']['2'];?>" data-name="<?php echo $v['menu']['1'];?>" target="_blank"><?php echo $v['menu']['1'];?></a>
        <?php $n++;}unset($n); } ?>
    </div>
    <div class="side-menu-bar">
        <a class="btn-link" href="javascript:;" id="add-menu"><i class="add-icon"></i></a>
    </div>
</div>
<script>
    $('#add-menu').click(function(){
        ST.Util.showBox('常用菜单', SITEURL + 'quickmenu/select', 670,383, null, null, document, {loadWindow: window, loadCallback: Insert});
        function Insert(data){
            var html='';
            for(var i in data){
                html+='<a class="config_item item" href="javascript:;" data-url="'+data[i]['menu'][2]+'" data-name="'+data[i]['menu'][1]+'" title="'+data[i]['path']+'" target="_blank">'+data[i]['menu'][1]+'</a>';
            }
            $('.shut-menu').html(html);
        }
    });
    //
    $(".shut-menu a").live('click',function(){
        var url = $(this).data('url');
        var title = $(this).data('name');
        ST.Util.addTab(title,url);
    })
</script>