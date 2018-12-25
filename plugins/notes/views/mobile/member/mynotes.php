<header padding_html=ADACXC >
    <div class="header_top">
        <a class="back-link-icon" data-ajax="false" href="{$cmsurl}member"></a>
        <h1 class="page-title-bar">我的游记</h1>
        <a class="publish-notes-link fr" data-ajax="false" href="{$cmsurl}notes/member/notes_edit">发布游记</a>
    </div>
</header>
<!-- 公用顶部 -->
<div class="page-content travel-notes">
    <ul class="travel-notes-wrapper">

    </ul>
    <div class="no-content-page hide">
        <div class="no-content-icon"></div>
        <p class="no-content-txt">您暂时还没有发表过游记</p>
    </div>
    <div class="bottom-box hide">
        <p class="load-box"><i></i>正在加载中...</p>
    </div>
    <div class="no-info-bar hide">没有更多游记了！</div>
</div>
<input type="hidden" id="current_page" value="0"/>
<script type="text/html" id="notes_list">
    {{each list as value i}}
    <li class="item">
        <div class="tn-tip-bar">
            <a href="{{value.url}}" title="{{value.title}}" data-ajax="false" class="tn-title">{{value.title}}</a>
            {{if value.status==0}}
            <span class="tn-label">审核中</span>
            {{else if value.status==1}}
            <span class="tn-label pass">已经发布</span>
            {{else if value.status==-1}}
            <span class="tn-label">审核失败</span>
            {{/if}}
        </div>
        <div class="tn-content-box">
            <div class="hd-box">
                <a class="pic" title="{{value.title}}" data-ajax="false" href="{{value.url}}"><img src="{{value.litpic}}"/></a>
            </div>
            <div class="bd-box">
                <div class="txt">{{value.description}}</div>
                <div class="info">
                    <span class="date fl">{{value.modtime}}</span>
                    <span class="edit" data-type="{{value.is_pc}}" data-id="{{value.id}}"></span>
                    {{if value.status!=1}}
                    <span class="delete" data-id="{{value.id}}"></span>
                    {{/if}}
                </div>
            </div>
        </div>
    </li>
    {{/each}}
</script>
<script>
    var pagesize="{$pagesize}";
    var sorttype="{$sorttype}";
    var current_page=$('#current_page').val();
    var is_loading = false;
    $(function(){
        //bind event
        $('.travel-notes').scroll(function(){
            var totalheight = parseFloat($(this).height()) + parseFloat($(this).scrollTop());
            var scrollHeight = $(this)[0].scrollHeight;//实际高度
            if(totalheight-scrollHeight>= -10){
                get_data();
            }
        });
    });
    get_data();
    function get_data()
    {
        var current_page=parseInt($('#current_page').val());
        if(!is_loading && current_page!=-1){
            is_loading = true;
            $(".bottom-box").show();
            var url=SITEURL+'notes/member/ajax_get_more';
            var nextpage = current_page+1;
            var data={'page':nextpage,'sorttype':sorttype,'pagesize':pagesize};
            $.ajax({
                type: 'POST',
                url: url ,
                data: data ,
                dataType: 'json',
                success:function(result){
                    var html = template('notes_list',result);
                    $(".travel-notes-wrapper").append(html);

                    $("span.edit[data-id]").each(function(){
                        $(this).click(function(){
                            var id=$(this).data('id');
                            var is_pc=$(this).data('type');
                            if(is_pc==1)
                            {
                                layer.open({
                                    content: '暂不支持编辑电脑端游记',
                                    btn: ['确定'],
                                    shadeClose: false,
                                    yes: function(){
                                        is_editing=false;
                                        layer.closeAll();
                                    }
                                });
                                return false;
                            }
                            else
                            {
                                window.location.href=SITEURL+'notes/member/notes_edit/id/'+id;
                            }
                        })
                    });
                    $("span.delete[data-id]").each(function(){
                        $(this).click(function(){
                            var id=$(this).data('id');
                            layer.open({
                                content: '确定删除游记吗？',
                                btn: ['确定', '取消'],
                                yes: function(index){
                                    $.ajax({
                                        type: 'POST',
                                        url: '{$cmsurl}notes/member/notes_del/id/'+id ,
                                        data: data ,
                                        dataType: 'json',
                                        success:function(res){
                                            layer.close(index);
                                            if(res.status)
                                            {
                                                layer.open({
                                                    content: '删除成功',
                                                    skin: 'msg',
                                                    time: 1, //2秒后自动关闭
                                                    success:function () {
                                                        window.location.reload();
                                                    }
                                                });
                                            }
                                            else
                                            {
                                                layer.open({
                                                    content: res.msg,
                                                    skin: 'msg',
                                                    time: 2, //2秒后自动关闭
                                                });
                                            }
                                        }
                                    });

                                }
                            });

                        })
                    });
                    if(!html)
                    {
                        $(".no-content-page").show();
                    }
                    if(result.page==-1&&html)
                    {
                        $(".no-info-bar").show();
                    }
                    $('#current_page').val(result.page);
                    is_loading = false;
                    $(".bottom-box").hide();
                }
            });

        }

    }

</script>