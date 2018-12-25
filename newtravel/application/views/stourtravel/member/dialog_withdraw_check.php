<!doctype html>
<html>
<head border_table=IIACXC >
    <meta charset="utf-8">
    <title>笛卡CMS{$coreVersion}</title>
    {template 'stourtravel/public/public_min_js'}
    {php echo Common::getCss('base_new.css'); }
</head>

<body style=" overflow: hidden">

   <div class="s-main">
      <ul class="info-item-block">
          <li>
              <span class="f-l item-text">备注说明：</span>
              <div class="f-l w400">
                  <textarea class="textarea" id="audit_description"></textarea>
              </div>
          </li>
      </ul>
       <div class="clearfix text-c">
           <a href="javascript:;" class="btn btn-default radius c-999 mr-10 refuse" id="refuse-btn">取消</a>
           <a href="javascript:;" class="btn btn-primary radius" id="confirm-btn">确定</a>
       </div>
   </div>
    <script>
        $(function(){
            var id="{$id}";
            window.setTimeout(function(){
                ST.Util.resizeDialog('.s-main');
            },0);

            $(document).on('click','#confirm-btn,#refuse-btn',function(){
                var audit_description = $("#audit_description").val();
                status = $(this).hasClass('refuse')?0:1;
                if(status==1 && !audit_description)
                {
                    ST.Util.showMsg('请填写备注',5,1000);
                    return;
                }
                ST.Util.responseDialog({status:status,audit_description:audit_description},true);
            })

        })

    </script>

</body>
</html>
