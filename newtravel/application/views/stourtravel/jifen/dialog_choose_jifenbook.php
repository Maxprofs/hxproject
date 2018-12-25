<!doctype html>
<html>
<head font_float=5cyt-j >
    <meta charset="utf-8">
    <title>笛卡CMS{$coreVersion}</title>
    {template 'stourtravel/public/public_min_js'}
    {php echo Common::getCss('base.css,base_new.css'); }
    <style>
        .no-content-td:hover
        {
            background: none !important;
        }
    </style>
</head>
<body >
<div class="s-main">
    <div class="container-page">
        <div class="clearfix">
            <form id="search_frm">
            <div class="pop-search-block">
                <input type="text"class="search-text" name="keyword"  value="{$keyword}" placeholder="策略标题" />
                <a href="javascript:;" class="search-btn">搜索</a>
            </div>
                <input type="hidden" name="jifenid" value="{$jifenid}">
                <input type="hidden" name="typeid" value="{$typeid}">
                <input type="hidden" name="selector" value="{$selector}">
            </form>
        </div>
        <div class="clearfix mt-10">
            <div style="height: 408px">
                <table class="table table-bg table-border table-hover">
                    <thead>
                    <tr class="text-c">
                        <th width="10%">选择</th>
                        <th width="30%">调用标识</th>
                        <th width="45%">策略标题</th>
                        <th width="15%">赠送分数</th>
                    </tr>
                    </thead>
                    <tbody>
                    {if $list}
                    {loop $list $l}
                    <tr class="text-c">
                        <td>
                            <input data-pool='{json_encode($l)}'  type="radio" class="va-t mt-3" name="checkjifen" {if $jifenid==$l['id']}checked {/if} value="{$l['id']}"  />
                        </td>
                        <td>{$l['label']}</td>
                        <td>
                            <div class="insurance-name-td text-overflow">{$l['title']}</div>
                        </td>
                        <td>{php}   $score_str = $l['rewardway']==1?$l['value'].'%':$l['value'];   {/php}  {$score_str}</td>
                    </tr>
                    {/loop}
                    {else}
                    <tr class="text-c">
                        <td class="no-content-td " colspan="4" height="365" >
                            没有搜索到相关内容
                        </td>
                    </tr>
                    {/if}
                    </tbody>
                </table>
            </div>
            <div class="clearfix fr mt-10">
                {$pageinfo}
            </div>
        </div>
        <div class="clearfix text-c mt-20">
            <a href="javascript:;" class="btn btn-grey-outline radius">取消</a>
            <a href="javascript:;" class="btn btn-primary radius ml-10 confirm-btn">确定</a>
        </div>
    </div>
</div>
<script>

    var selector="{$selector}";
    $(function(){
        //确定
        $(".confirm-btn").click(function(){
            var jifenid=$("input[name=checkjifen]:checked").val();
            if(!jifenid)
            {
                ST.Util.showMsg('请先选择策略','5',1500);
                return;
            }
            var jifen_info = $("input[name=checkjifen]:checked").data('pool');
            var params={};
            params['selector']=selector;
            params['data']=jifen_info;

            ST.Util.responseDialog(params,true);
        });

        $('.search-btn').click(function () {
            $('#search_frm').submit();

        })
        $('.btn-grey-outline').click(function () {
            var params={};
            ST.Util.responseDialog(params,false);
        })

    })

</script>
</body>
</html>
