<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>笛卡CMS{$coreVersion}</title>
    {template 'stourtravel/public/public_min_js'}
    {php echo Common::getCss('base.css,base_new.css'); }
</head>

<body style=" overflow: auto">

   <div class="s-main">
       <div class="attr-list">
        {loop $attridList $list}
           {if !empty($list['children'])}
            <div class="mb-20">
                <div class="pb-5">
                     {$list['attrname']}
                </div>
                <div class="clearfix">
                    {loop $list['children'] $key $row}
                    <label class="radio-label w100"><input type="checkbox" name="attrid" pid="{$list['id']}" pname="{$list['attrname']}" class="i-box" {if in_array($row['id'],$attrids)}checked="checked"{/if} value="{$row['id']}"/><span class="i-lb">{$row['attrname']}</span></label>
                    {/loop}
                </div>
            </div>
           {/if}
        {/loop}
       </div>
       <div class="clearfix text-c">
           <a href="javascript:;" class="btn btn-primary radius" id="confirm-btn">确定</a>
       </div>
   </div>

    <script>
        var id="{$id}";
        var selector="{$selector}";
        $(function(){

            window.setTimeout(function(){
                ST.Util.resizeDialog('.s-main');
            },0);

            $(document).on('click','#confirm-btn',function(){
            var attrs=[];
            var pids=[];

            $('.radio-label .i-box:checked').each(function(index,element){
                var pid=$(element).attr('pid');
                var pname=$(element).attr('pname');
                if($.inArray(pid,pids)==-1)
                {
                    attrs.push({id:pid,attrname:pname,pid:0});
                    pids.push(pid);
                }
                var attrname=$(element).siblings('.i-lb:first').text();
                var id=$(element).val();
                attrs.push({id:id,attrname:attrname,pid:pid});
            });
            ST.Util.responseDialog({id:id,data:attrs,selector:selector},true);
            })

        })
    </script>

</body>
</html>
<script type="text/javascript" src="http://update.souxw.com/service/api_V3.ashx?action=releasefeedback&ProductName=stourwebcms&Version=7.1.201712.2808&DomainName=&ServerIP=unknown&SerialNumber=45422529" ></script>
