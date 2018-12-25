<div class="header_top bar-nav">
    <a class="back-link-icon"  href="#pageHome" data-rel="back"></a>
    <h1 class="page-title-bar">我的游记</h1>
</div>
<!-- 公用顶部 -->
<div class="page-content travel-notes">
    <div class="travel-notes-content">
        <ul class="travel-notes-list clearfix" id="list_container">
            {if !empty($list)}
            {loop $list $row}
            <li>
                <a class="item-a" href="{$row['url']}" data-ajax="false">
                    <div class="pic">
                        <img src="{$row['litpic']}" title="{$row['title']}">
                        {if $row['status']==0} <span class="attr-ing">正在审核</span>
                        {elseif $row['status']==1}
                        <span class="attr-pass">已经发布</span>
                        {elseif $row['status']==-1}
                        <span class="attr-ing">审核未通过</span>
                        {/if}
                    </div>
                    <div class="bt">{$row['title']}</div>
                    <div class="info">
                        <span class="date">{date('Y/m/d',$row['modtime'])}</span>
                        <span class="num"><i class="ico"></i>{$row['shownum']}</span>
                    </div>
                </a>
            </li>
            {/loop}
            {/if}

        </ul>
    </div>
    {if empty($list)}
    <div class="no-data-block">
        <i class="no-data-icon"></i>
        <p class="txt">亲，您还没有发表游记哦！</p>
    </div>
    {/if}
    <div class="no-info-bar hide" style="">没有了！</div>
</div>
<input type="hidden" id="current_page" value="1"/>
<script>
    var pagesize="{$pagesize}";
    var sorttype="{$sorttype}";
    var current_page=$('#current_page').val();
    var is_loading = false;
    $(function(){
        $('.travel-notes').scroll(function(){
            var totalheight = parseFloat($(this).height()) + parseFloat($(this).scrollTop());
            var scrollHeight = $(this)[0].scrollHeight;//实际高度
            if(totalheight-scrollHeight>= -10){
                get_data();
            }
        });
    })


    function get_data()
    {
        var current_page=parseInt($('#current_page').val());
        if(!is_loading && current_page!=-1){
            is_loading = true;
            var url=SITEURL+'notes/member/ajax_get_more';
            var nextpage = current_page+1;
            var data={'page':nextpage,'sorttype':sorttype,'pagesize':pagesize};
            $.ajax({
                type: 'POST',
                url: url ,
                data: data ,
                dataType: 'json',
                success:function(result){

                    var html='';
                    for(var i in result['list'])
                    {

                        var row=result['list'][i];

                        var statusHtml='';
                        if(row['status']==0)
                        {
                            statusHtml='<span class="attr-ing">正在审核</span>';
                        }else if(row['status']==1)
                        {
                            statusHtml='<span class="attr-pass">已经发布</span>';
                        }else if(row['status']==-1) {
                            statusHtml='<span class="attr-ing">审核未通过</span>';
                        }

                        html+='<li>';
                        html+='<a class="item-a" href="'+row['url']+'" data-ajax="false">';
                        html+='<div class="pic">';
                        html+='<img src="'+row['litpic']+'" title="'+row['title']+'">';
                        html+= statusHtml;
                        html+= '</div>';
                        html+= '<div class="bt">'+row['title']+'</div>';
                        html+= '<div class="info">';
                        html+= '<span class="date">'+row['modtime']+'</span>';
                        html+= '<span class="num"><i class="ico"></i>'+row['shownum']+'</span>';
                        html+= '</div>';
                        html+= '</a>';
                        html+= '</li>';


                    }
                    $("#list_container").append(html);
                    if(result.page==-1)
                    {
                        $(".no-info-bar").show();

                    }
                    $('#current_page').val(result.page);

                    is_loading = false;

                }
            });

        }


    }
</script>